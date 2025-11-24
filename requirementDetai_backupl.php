<?php
require_once('dbClass.php');
session_start();

$id = intval($_GET['id'] ?? 0); // Get ID, default to 0 for new record

$isNewRecord = ($id === 0); // Flag to determine if it's a new record

$row = []; // Initialize row data
$assignedUserIds = [];
$comments = ['num_rows' => 0, 'result_set' => []]; // Initialize comments
$user_id = $_SESSION['user_id'] ?? null;

// Status and Priority labels (moved here for self-containment)
$statusLabels = [
    0 => 'Assigned*',
    1 => 'In Progress',
    2 => 'Completed', // (Pending Review)
    3 => 'Reviewed',
    4 => 'Closed',
    5 => 'Rework',
    6 => 'Hold',
    7 => 'Cancel',
    8 => 'Scheduled'
];


$priorityLabels = [
    0 => 'Low',
    1 => 'Medium',
    2 => 'High'
];

// Get developers (users with Category = 2) for the assignedTo dropdown
$usersSql = "SELECT ID, Name FROM users WHERE Category = 2 ORDER BY Name ASC"; //AND ID != $user_id
$getUsers = db::getInstanceMaster()->db_select($usersSql);
$allUsersMap = []; // Create a map for quick lookup: ID => Name
if ($getUsers && $getUsers['num_rows'] > 0) {
    foreach ($getUsers['result_set'] as $user) {
        $allUsersMap[$user['ID']] = $user['Name'];
    }
}

// Fetch data only if it's an existing record
if (!$isNewRecord) {
    $sql = "SELECT r.*, m.MediaName, m.MediaFolder, ai.Label as Company, k.FormName, k.ModuleType, u.Name, rc.CommentText, rc.id as CommentId, rc.CreatedAt AS CommentCreatedAt,DATEDIFF(DAY, r.CreatedAt, GETDATE()) AS PendingDays
            FROM Requirements r
            LEFT JOIN kmainmedia m ON m.MediaID = r.MediaID
            LEFT JOIN AiCompany ai ON ai.ID = r.CompanyId
            LEFT JOIN kmainforms k ON k.FormId = r.FormId
            LEFT JOIN users u ON u.ID = r.CreatedBy
            LEFT JOIN (
                SELECT rc1.*
                FROM RequirementComments rc1
                INNER JOIN (
                    SELECT RequirementID, MIN(CreatedAt) AS FirstDate
                    FROM RequirementComments
                    GROUP BY RequirementID
                ) rc2 ON rc1.RequirementID = rc2.RequirementID AND rc1.CreatedAt = rc2.FirstDate
            ) rc ON rc.RequirementID = r.ID
            WHERE r.ID = $id";

    $data = db::getInstanceMaster()->db_select($sql);
    if ($data && $data['num_rows'] > 0) {
        $row = $data['result_set'][0];

        $requirementName  = $id . ": " . $row['CommentText'];
        $firstCommentCreatedAt = $row['CommentCreatedAt']; // Capture timestamp

        // echo $row['ModuleType'];
        $getModuleUrl = "SELECT * FROM Master_ModuleType WHERE ID =".$row['ModuleType'];
        $getModuleUrlResult = db::getInstanceMaster()->db_select($getModuleUrl);

        $fullURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]/".$getModuleUrlResult['result_set'][0]['url']."".$row['FormId'];
        $fullURL = "requirementRedirect.php?TaskID=".$id;


        // Fetch assigned users for existing record
        $assignSql = "SELECT DISTINCT AssignedTo FROM Requirement_AssignedTo WHERE RequirementCommentID IN (SELECT ID FROM RequirementComments WHERE RequirementID = ".$row['id'].")";
        $assigned = db::getInstanceMaster()->db_select($assignSql);
        if (!empty($assigned['result_set'])) {
            foreach ($assigned['result_set'] as $assignedRow) {
                // $assignedUserIds[] = $assignedRow['AssignedTo'];

                // Populate assignedUserNames array
                if (isset($allUsersMap[$assignedRow['AssignedTo']])) {
                    $assignedUserNames[] = $allUsersMap[$assignedRow['AssignedTo']];
                }

                // Check if the current logged-in user is one of the assigned users
                if ($user_id !== null && $assignedRow['AssignedTo'] == $user_id) {
                    $isAssignedUserForThisRequirement = true;
                }
            }
        }  
        
        //get latest updated assignee name
        $assignSql1 = "SELECT TOP 1 RC.id AS CommentID,RC.CommentText, STRING_AGG(RA.AssignedTo, ', ') AS AssignedUsers 
        FROM RequirementComments RC JOIN Requirement_AssignedTo RA ON RA.RequirementCommentID = RC.id 
        WHERE RC.RequirementID = ".$id." AND RC.CreatedBy=".$user_id." GROUP BY RC.id, RC.CommentText ORDER BY MAX(RC.CreatedAt) DESC";
        $assigned1 = db::getInstanceMaster()->db_select($assignSql1);
        // print_r($assigned1);
        if (!empty($assigned1['result_set'])) {
            foreach ($assigned1['result_set'] as $assignedRow) {
                $assignedUserIds[] = $assignedRow['AssignedUsers'];
            }
        }  

        //get latest comment status
        $latestCommentSql = "SELECT TOP 1 rc.*, u.Name FROM RequirementComments rc LEFT JOIN users u ON u.ID = rc.CreatedBy WHERE rc.RequirementID = $id ORDER BY rc.CreatedAt desc";
        $latestCommentResult = db::getInstanceMaster()->db_select($latestCommentSql);


        // Fetch comments for existing record
        $commentsSql = "SELECT rc.id, rc.CommentText, rc.CreatedAt, rc.Status, u.Name, rc.DueDate FROM RequirementComments rc LEFT JOIN users u ON u.ID = rc.CreatedBy WHERE RequirementID = $id ";
        if ($firstCommentCreatedAt !== null) {
            // Convert DateTime object to SQL-compatible string (YYYY-MM-DD HH:MM:SS)
            $formattedDate = $firstCommentCreatedAt->format('Y-m-d H:i:s.v');
            // Add condition to exclude the comment(s) with the oldest timestamp
            $commentsSql .= " AND rc.CreatedAt >= '$formattedDate'";
        }
        $commentsSql .= " ORDER BY rc.CreatedAt DESC";
        $comments = db::getInstanceMaster()->db_select($commentsSql);

        //Update notification is read
        $updateReadNotification = "UPDATE Requirement_Notifications SET ReadAt=GETDATE() WHERE TaskID=$id AND UserID=".$user_id;
        db::getInstanceMaster()->db_update($updateReadNotification);


        $getReadReceipt = "select rn.ReadAt, u.Name from Requirement_Notifications rn LEFT JOIN users u ON rn.UserID = u.ID Where rn.TaskID = $id AND rn.ReadAt IS NOT NULL GROUP BY u.Name,rn.ReadAt ORDER BY rn.ReadAt DESC";
        $getReadReceiptResults = db::getInstanceMaster()->db_select($getReadReceipt);
        // print_r($getReadReceiptResults);

        // Determine the status label and badge class for display in the overview
        $currentStatusLabel = $statusLabels[$latestCommentResult['result_set'][0]['Status'] ?? 0] ?? 'Unknown';
        $statusBadgeClass = 'badge-secondary'; // Default
        switch ($row['Status'] ?? 0) {
            case 0: $statusBadgeClass = 'badge-info'; break; // Assigned*
            case 1: $statusBadgeClass = 'badge-warning'; break; // In Progress
            case 2: $statusBadgeClass = 'badge-secondary'; break; // Completed (Pending Review)
            case 3: $statusBadgeClass = 'badge-primary'; break; // Reviewed
            case 4: $statusBadgeClass = 'badge-success'; break; // Closed
            case 5: $statusBadgeClass = 'badge-danger'; break; // Rework
            case 6: $statusBadgeClass = 'badge-warning'; break; // Hold
            case 7: $statusBadgeClass = 'badge-dark'; break; // Cancel
            case 8: $statusBadgeClass = 'badge-info'; break; // Scheduled
        }

        $currentPriorityLabel = $priorityLabels[$latestCommentResult['result_set'][0]['Priority'] ?? 0] ?? 'Unknown';
        $priorityBadgeClass = 'badge-secondary'; // Default
        switch ($latestCommentResult['result_set'][0]['Priority'] ?? 0) {
            case 0: $priorityBadgeClass = 'badge-success'; break; // Assigned*
            case 1: $priorityBadgeClass = 'badge-warning'; break; // In Progress
            case 2: $priorityBadgeClass = 'badge-danger'; break; // Completed (Pending Review)
        }


    } else {
        // If ID is provided but no data found, treat as invalid ID
        echo "<p class='text-danger text-center p-4'>No detail found for ID: " . htmlspecialchars($id) . ".</p>";
        exit;
    }
    $tmpDueDate =  $row['DueDate'];
    if($tmpDueDate == null || $tmpDueDate == ''){
        $row['DueDateDD']='';
        $DateDifference='';
    }else{
        $row['DueDate'] = $tmpDueDate->format('Y-m-d');
        $row['DueDateDD'] = $tmpDueDate->format('d-m-Y');
        $today = new DateTime("now");
        $tmpDueDate = new DateTime($row['DueDate']);
        // $tmpDueDate = new DateTime('2025-08-06');
        $ddd = $today->diff($tmpDueDate);
        $DateDifference = $ddd->format('%R%a');
        // if($ddd->format('%a'))
    }
} else {
    // For new record, initialize default values or empty strings
    $row = [
        'id' => 0, // Indicate new record
        'Requirement' => '',
        'Status' => 0, // Default to Pending
        'Priority' => 1, // Default to Medium
        'DueDate' => date('Y-m-d'),
        'DueDateDD' => date('d-m-Y'),
        'MediaName' => '', // No media for new record initially
        'MediaFolder' => '', // No media for new record initially
        'Name' => $_SESSION['user_name'] ?? 'N/A', // Assuming current user name
        'Company' => $_SESSION['dbCompanyLabel'] ?? 'N/A', // Assuming company label
        'FormId' => '', // No form ID for new
        'FormName' => '', // No form name for new
    ];
}


?>

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom">
        <h6 class="mb-0" style="font-weight:bold;">
            <?php if ($isNewRecord): ?>
                Add New Requirement
            <?php else: ?>
                <?= htmlspecialchars($requirementName) ?>
            <?php endif; ?>
        </h6>
    </div>

    <div class="row req-details">
        <?php if (!$isNewRecord): ?>
         
                <!-- Left Column -->
                <div class="col-md-8">                    
                    <div><b>Company:</b> <?= htmlspecialchars($row['Company'] ?? '-') ?></div>
                    <div><b>Module:</b> <a href="<?= htmlspecialchars($fullURL) ?>" target="_blank"><?= htmlspecialchars($row['FormName'] ?? '-') ?> (ID: <?= htmlspecialchars($row['FormId'] ?? '-') ?>)</a></div>
                     <div class="mb-2">
                        <strong>Assigned To:</strong>
                        <?php if (!empty($assignedUserNames)): ?>
                            <?php foreach ($assignedUserNames as $name): ?>
                                <span class="badge badge-primary me-1"><?= htmlspecialchars($name) ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="badge badge-light text-muted">Not assigned</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <div><strong>Assignee:</strong> <?= htmlspecialchars($row['Name'] ?? '-') ?></div>
                    <div>
                        <strong>Last Status:</strong>
                        <span class="badge <?= $statusBadgeClass ?>"><?= htmlspecialchars($currentStatusLabel) ?></span>
                    </div>
                    <div>
                        <strong>Priority:</strong>
                        <span class="badge <?= $priorityBadgeClass ?>"><?= htmlspecialchars($currentPriorityLabel) ?></span>
                    </div>
                    <div>
                        <strong>Due:</strong>
                        <span class="badge <?= $priorityBadgeClass ?>"><?= $row['DueDateDD'] ?></span>
                    </div>
                   
                    <div>
                        <?php if (!empty($row['MediaName'])): ?>
                            <strong><a href="<?= htmlspecialchars($row['MediaFolder'] . '/' . $row['MediaName']) ?>" target="_blank" class="text-info text-decoration-none d-flex align-items-center attachment-filename">View Attachment</a></strong>
                        <?php endif; ?>
                    </div>
                    <?php if($row['PendingDays'] > 0){ ?>
                    <div><strong style="font-weight: 900;font-size:18px;">Pending: <?= htmlspecialchars($row['PendingDays'] ?? '0') ?> days</strong></div>
                    <?php } ?>                    
                </div>
          


        <?php endif; ?>
    </div>

   
        <?php if ($isNewRecord): ?>
             <div class="form-group mb-4">
                <label for="requirementTextarea" class="form-label font-weight-bold text-dark">Requirement <span class="text-danger">*</span></label>
                <textarea class="form-control" id="requirementTextarea" rows="4" name="requirement" placeholder="Describe the requirement in detail..."><?= htmlspecialchars($requirementName) ?></textarea>
            </div>
        <?php endif; ?>
    <?php 
    $dateTime = new DateTime();
    $lastDateTime = $dateTime;
    // $lastDateTime = $dateTime->format('Y-m-d H:i:s');
    ?>
    <?php if (!$isNewRecord): // Only show comment section in update mode ?>
        <div >
            <h6 class="h6 font-weight-bold text-dark mb-0">Comments</h6>
            <?php if ($comments['num_rows'] > 0): ?>
                <div class="border rounded bg-light" style="max-height: 250px; overflow-y: auto;background-color: #dee2e685 !important;">
                    <?php foreach ($comments['result_set'] as $c):
                        if (!($c['CreatedAt'] instanceof DateTime)) {
                            try {
                                $c['CreatedAt'] = new DateTime($c['CreatedAt']);
                            } catch (Exception $e) {
                                $c['CreatedAt'] = new DateTime();
                                error_log("Failed to parse date for comment: " . $e->getMessage());
                            }
                        }

                        // Determine the status label and badge class for display in the overview
                        $currentStatusLabel = $statusLabels[$c['Status'] ?? 0] ?? 'Unknown';
                        $statusBadgeClass = 'badge-secondary'; // Default
                        switch ($c['Status'] ?? 0) {
                            case 0: $statusBadgeClass = 'badge-info'; break; // Assigned*
                            case 1: $statusBadgeClass = 'badge-warning'; break; // In Progress
                            case 2: $statusBadgeClass = 'badge-secondary'; break; // Completed (Pending Review)
                            case 3: $statusBadgeClass = 'badge-primary'; break; // Reviewed
                            case 4: $statusBadgeClass = 'badge-success'; break; // Closed
                            case 5: $statusBadgeClass = 'badge-danger'; break; // Rework
                            case 6: $statusBadgeClass = 'badge-warning'; break; // Hold
                            case 7: $statusBadgeClass = 'badge-dark'; break; // Cancel
                            case 8: $statusBadgeClass = 'badge-info'; break; // Scheduled
                        }

                        // Fetch assigned users for existing record
                        $commentAssignedUserNames = [];
                        $commentAssignSql = "SELECT AssignedTo FROM Requirement_AssignedTo WHERE RequirementCommentID = ".$c['id'];
                        $commentAssigned = db::getInstanceMaster()->db_select($commentAssignSql);
                        if (!empty($commentAssigned['result_set'])) {
                            foreach ($commentAssigned['result_set'] as $ca) {
                                // $assignedUserIds[] = $assignedRow['AssignedTo'];

                                // Populate assignedUserNames array
                                if (isset($allUsersMap[$ca['AssignedTo']])) {
                                    $commentAssignedUserNames[] = $allUsersMap[$ca['AssignedTo']];
                                }
                            }
                        } 
                    ?>
                        
                            <div class="comment-box d-flex align-items-start p-2 rounded shadow1-sm" style="background: transparent !important;    border-bottom: 1px solid #dbdbdb;">
                                <!-- Avatar -->
                                <div class="avatar-circle flex-shrink-0 me-3" style="margin-right:2px;">
                                    <?= strtoupper(substr($c['Name'] ?? 'U', 0, 1)) ?>
                                </div>

                                <!-- Comment Content -->
                                <div class="flex-grow-1" style="background: white !important;border-radius: 9px;padding: 5px;margin-left: 3px;">
                                    <div class="fw-bold mb-1" style="font-size: 13px;">
                                        <b style="display: inline-block;text-decoration:underline"><?= htmlspecialchars($c['Name'] ?? 'Unknown') ?></b>
                                        <span style="font-size: 10px;color: #8c8c8c;">
                                            <?= $c['CreatedAt']->format('d-m-Y h:i A') ?> 
                                            <?php 
                                            $start = $lastDateTime;
                                            $end = $c['CreatedAt'];
                                            $diff = $start->diff($end);
                                            $s = '';
                                            if($diff->days > 0) $s = $diff->days . " days ";
                                            if($diff->days > 0 || $diff->h > 0) $s .= $diff->h . " hours ago";
                                            echo "<strong>[".$s."]</strong>";
                                            ?>
                                        </span>
                                        <div class="comment-meta text-muted small" style="display: inline-block;float: right;">                                           
                                            <span class="badge <?= $statusBadgeClass ?>"><?= htmlspecialchars($currentStatusLabel) ?></span>
                                            <?php if (!empty($commentAssignedUserNames)): ?>
                                                Assigned to: 
                                                <?php foreach ($commentAssignedUserNames as $name): ?>
                                                    <span class="badge bg-primary1"><?= htmlspecialchars($name) ?></span>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <?php 
                                                $tmpDueDate1 =  $c['DueDate'];
                                                if($tmpDueDate1 == null || $tmpDueDate1 == ''){
                                                    
                                                }else{
                                                    // $c['DueDate'] = $tmpDueDate1->format('Y-m-d');
                                                    echo "<b>Due: ". $c['DueDateDD'] = $tmpDueDate1->format('d-m-Y') . '</b>';
                                                    // $today = new DateTime("now");
                                                    // $tmpDueDate1 = new DateTime($c['DueDate']);
                                                    // $ddd = $today->diff($tmpDueDate1);
                                                    // $DateDifference = $ddd->format('Due: %R%a days');
                                                    // if($ddd->format('%a'))
                                                }
                                            // echo "-".$c['DueDate']; 
                                            ?>
                                        </div>
                                    </div>
                                    <div class="comment-text mb-1">
                                        <?= nl2br(htmlspecialchars($c['CommentText'])) ?>
                                    </div>
                                    
                                </div>
                            </div>
                    
                        <!-- <hr style="margin: .5rem 0;"> -->
                    <?php endforeach; ?>

                   
                </div>
            <?php else: ?>
                <p class="text-muted small">No comments yet.</p>
            <?php endif; ?>
        </div>
        
    <?php endif; ?>
    

    <div class="row">
        <div class="col-md-9 form-group">
            <label for="assignedTo" class="form-label font-weight-bold text-dark">Assign To</label>
            <select multiple name="assignedTo[]" id="assignedTo" class="form-control">
                <?php
                if (!empty($getUsers['result_set'])) {
                    foreach ($getUsers['result_set'] as $user) {
                        $selected = in_array($user['ID'], $assignedUserIds) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($user['ID']) . '" ' . $selected . '>' . htmlspecialchars($user['Name']) . '</option>';
                    }
                } else {
                    echo '<option value="">No users available</option>';
                }
                ?>
            </select>
        </div>

        <?php if (!$isNewRecord): // Only show Status and status in update mode ?>
            <div class="col-md-3 form-group">
                <label for="statusSelect" class="form-label font-weight-bold text-dark">Status</label>
                <select id="statusSelect" class="form-control">
                    <?php
                        foreach ($statusLabels as $value => $label):
                            // For assigned users, only show In Progress (1) and Completed (2)
                            // if ($isAssignedUserForThisRequirement) {
                            //     if ($value == 1 || $value == 2) {
                            //         $selected = ($latestCommentResult['result_set'][0]['Status'] ?? 0) == $value ? 'selected' : '';
                            //         echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                            //     }
                            // } else {
                                // For non-assigned users, show all statuses
                                $selected = ($latestCommentResult['result_set'][0]['Status'] ?? 0) == $value ? 'selected' : '';
                                echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                            // }
                        endforeach;
                    ?>
                </select>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($isNewRecord): // Only show attachment input for new records ?>
        <div class="form-group mb-4">
            <label for="attachmentInput" class="form-label font-weight-bold text-dark">Attachment</label>
            <input type="file" class="form-control-file" id="attachmentInput" name="attachment">
            <small class="form-text text-muted">Max file size 5MB.</small>
            <input type="hidden" name="URLFrom" id="URLForm" value="" />
        </div>
    <?php endif; ?>
    <div class="row">
        <?php if (!$isNewRecord): // Only show comment section in update mode ?>
        <div class="form-group col-md-9">
            <label for="newComment" class="form-label font-weight-bold text-dark">Your Comment</label>
            <textarea id="newComment" rows="3" class="form-control" placeholder="Enter comment..."></textarea>
        </div>
        <?php endif; ?>
            <div class="col-md-3 form-group">
                <label for="dd" class="form-label font-weight-bold text-dark">Due Date</label>
                <input type="date" class="form-control" value="<?php echo $row['DueDate'] ?>" id="duedate" name="duedate">
                <label for="prioritySelect" class="form-label font-weight-bold text-dark">Priority</label>
                <select id="prioritySelect" class="form-control" >
                    <?php foreach ($priorityLabels as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $latestCommentResult['result_set'][0]['Priority'] == $value ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-12 form-group">
                <button class="btn btn-primary" onclick="saveRequirement(<?= $row['id'] ?>, <?= $isNewRecord ? 'true' : 'false' ?>)">
                    <?php if ($isNewRecord): ?>
                        Save
                    <?php else: ?>
                        Update
                    <?php endif; ?>
                </button>
            </div>
    </div>  
    
    <?php if (!$isNewRecord): // Only show comment section in update mode ?>
        <div>
            <?php if ($getReadReceiptResults['num_rows'] > 0): ?>
            <h6 class="h6 font-weight-bold text-dark mb-0">Read Receipts</h6>
            <div class="row border rounded bg-light" style="max-height: 250px; overflow-y: auto;background-color: #dee2e685 !important;">
                <?php foreach ($getReadReceiptResults['result_set'] as $r): ?>
                    <div class="col-md-4">
                    <div class=" comment-box d-flex1 align-items-start1 p-2 rounded shadow1-sm" style="/* background: transparent !important; // border-bottom: 1px solid #dbdbdb; */">
                        <!-- Avatar -->
                        <div class="avatar-circle flex-shrink-0 me-3" style="margin-right:2px;">
                            <?= strtoupper(substr($r['Name'] ?? 'U', 0, 1)) ?>
                        </div>

                        <!-- Comment Content -->
                        <div class="flex-grow-1" style="background: white !important;border-radius: 9px;padding: 5px;margin-left: 3px;">
                            <div class="fw-bold mb-1" style="font-size: 13px;">
                                <b style="display: inline-block;"><?= $r['Name'] ?></b>
                                        
                            </div>
                            <div class="comment-text mb-1" style="font-size: 11px;"><?= $r['ReadAt']->format('d-m-Y h:i A') ?></div>
                                    
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                   
            </div>
            <?php endif; ?>
        </div>        
    <?php endif; ?>

    <!-- <div class="d-flex justify-content-end">
        <button class="btn btn-primary" onclick="saveRequirement(<?= $row['id'] ?>, <?= $isNewRecord ? 'true' : 'false' ?>)">
            <?php if ($isNewRecord): ?>
                Save
            <?php else: ?>
                Update
            <?php endif; ?>
        </button>
    </div> -->

    
</div>

<style>
    /* Remove border-bottom from the last comment for cleaner look */
    .last-of-type-no-border.mb-2.pb-2:last-of-type {
        border-bottom: none !important;
    }
</style>
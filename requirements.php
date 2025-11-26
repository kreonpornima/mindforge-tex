<?php
// PHP code for requirements.php (remains mostly the same)
require_once('dbClass.php');
include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding
session_start();

$formId = isset($_GET['formid']) ? intval($_GET['formid']) : 0;
$NotifID = isset($_GET['NotifID']) ? intval($_GET['NotifID']) : 0;
// echo "formid".$formId;
$company = $_SESSION['dbCompany'] ?? null;
$division = $_SESSION['dbDivision'] ?? null;
$year = $_SESSION['dbYear'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

$isAssignedUserForThisRequirement = false; // Flag to check if current user is assigned

// Get filter parameters from GET request
$search_query = $_GET['search_query'] ?? '';
$filter_status = isset($_GET['filter_status']) && $_GET['filter_status'] !== '' ? intval($_GET['filter_status']) : null;
$filter_priority = isset($_GET['filter_priority']) && $_GET['filter_priority'] !== '' ? intval($_GET['filter_priority']) : null;
$filter_company = isset($_GET['filter_company']) && $_GET['filter_company'] !== '' ? intval($_GET['filter_company']) : null;
$filter_closed = isset($_GET['filter_closed']) && $_GET['filter_closed'] !== '' ? $_GET['filter_closed'] : 0;
// $filter_user = isset($_GET['filter_user']) && $_GET['filter_user'] !== '' ? intval($_GET['filter_user']) : null;
// Handle filter_user as an array for multiple selections
$filter_user = [];
if (isset($_GET['filter_user'])) {
    if (is_array($_GET['filter_user'])) {
        $filter_user = array_map('intval', $_GET['filter_user']);
    } else {
        // If only one user is selected, it might come as a single string, convert to array
        $filter_user = [intval($_GET['filter_user'])];
    }
}

$filter = '';

if ($formId > 0) {
    $filter .= " AND r.FormId = $formId";
}
$searchingText = false;
// Apply Search Query filter
if (!empty($search_query)) {
    $searchingText = true ;
    if (filter_var($search_query, FILTER_VALIDATE_INT) !== false) {
        $filter .= " AND (rc.CommentText LIKE '%$search_query%' OR r.ID = '$search_query') ";
    }else{
        $filter .= " AND (rc.CommentText LIKE '%$search_query%') ";
    }
} 

// Apply Status filter
if ($filter_status !== null) {
    $filter .= " AND latest_rc_status.Status = $filter_status";
}else{
    if(!$searchingText && !$filter_closed && $NotifID == 0) //&& $NotifID == 0
        $filter .= " AND (latest_rc_status.Status != 4 AND latest_rc_status.Status != 7) ";
}

// Apply Priority filter
if ($filter_priority !== null) {
    $filter .= " AND latest_rc_status.Priority = $filter_priority";
}

// Apply Company filter
if ($filter_company !== null) {
    $filter .= " AND r.CompanyId = $filter_company";
}

// Apply User filter
// if ($filter_user !== null) {
//     $filter .= " AND (r.CreatedBy = $filter_user OR Assg.AssignedUsers like  '%$filter_user%')";
//     // $filter .= " AND r.CreatedBy = $filter_user";
// }

if (!empty($filter_user)) {
    // print_r($filter_user);
    $userConditions = [];

    foreach ($filter_user as $userId) {
        // Escape each ID as needed
        $userConditions[] = "(',' + Assg.AssignedUsers + ',' LIKE '%," . $userId . ",%')";
    }

    $filter .= " AND (r.CreatedBy IN (" . implode(', ', $filter_user) . ")";
    if (!empty($userConditions)) {
        $filter .= " OR " . implode(' OR ', $userConditions);
    }

    $filter .= ")";
}
// echo $filter;
//AND latest_rc_status.Status = 3 AND (r.CreatedBy IN (1020, 1025) OR (',' + Assg.AssignedUsers + ',' LIKE '%,1020,%') OR (',' + Assg.AssignedUsers + ',' LIKE '%,1025,%'))

$SPName = "sp_GetRequirements";
$sp['params'] = ['@UserID','@filter'];
$sp['values'] = ["'".$_SESSION['user_id']."'","'$filter'"];
$requirements = db::getInstanceMaster()->db_sp_select($SPName, $sp['params'], $sp['values']);
// print_r($requirements);
$requirementResults = $requirements['result_set'][0];
// echo "******************************"; print_r($requirementResults);

$statusLabels = [
    0 => 'Assigned*',
    1 => 'In Progress',
    2 => 'Completed',// (Pending Review)
    3 => 'Reviewed',
    4 => 'Closed',
    5 => 'Rework',
    6 => 'Hold',
    7 => 'Cancel',
    8 => 'Scheduled'
];

$excludedStatuses = [2,3,4,5,7,8]; //PENDING WITH ME
$excludeClosedStatus = [4,7]; //OVERALL PENDING
$pendingCount = 0;
$unclosedCount = 0;
$completedNotClosedCnt = 0;
$lastAssignedToMeCnt = 0;
$statuswiseCnt= array(0,0,0,0,0,0,0,0,0);

foreach ($requirementResults as $row) {
    if (!empty($filter_user) && $row['LatestCommentStatus'] == 2) {
        if(in_array($row['CreatedBy'],$filter_user))
            $completedNotClosedCnt++;
    }
    foreach ($filter_user as $selected_user) {
        if (str_contains($row['Last_Assigned_UsersID'], $selected_user)) {
            // echo $row['Last_Assigned_UsersID'] . "<br />";
            $lastAssignedToMeCnt++;
            break;
        }
    }
    // echo $row['LatestCommentStatus'];
    if($row['LatestCommentStatus'] >= 0){
        $statuswiseCnt[$row['LatestCommentStatus']]++;
    }
    if (!in_array($row['LatestCommentStatus'], $excludedStatuses)) {
        $pendingCount++;
    }
    if (!in_array($row['LatestCommentStatus'], $excludeClosedStatus)) {
        $unclosedCount++;
    }
}
//print_r($statuswiseCnt);
// echo $lastAssignedToMeCnt;
$priorityLabels = [
    0 => 'Low',
    1 => 'Medium',
    2 => 'High'
];

if($_SESSION['Category'] == 1){
    $getCompany = "SELECT ID, Label FROM AiCompany WHERE GroupID={$_SESSION['group_id']}";
    $getUsers = "SELECT ID, Name FROM users where GroupID={$_SESSION['group_id']}";
}else{
    $getCompany = "SELECT ID, Label FROM AiCompany";
    $getUsers = "SELECT ID, Name FROM users where Category=2";
}

$getCompanyResult = db::getInstanceMaster()->db_select($getCompany);
$getUsersResult = db::getInstanceMaster()->db_select($getUsers);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tasks Viewer</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 Bootstrap 4 Theme CSS - THIS IS CRITICAL FOR PROPER STYLING -->
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.2.0/dist/select2-bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            min-height: 100vh;
            margin: 0;
            background-color: #f8f9fa; /* light grey background */
            color: #343a40; /* dark text */
        }
        .req-details{
            font-size: 13px !important;
        }
        label.form-label.font-weight-bold.text-dark {
            font-size: 0.75rem !important;
            margin-bottom: 0;
        }
        .avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .comment-box {
            border-radius: 10px;
            display: flex;
        align-items: flex-start !important; /* Ensures avatar stays at the top */
        }
        .comment-text {
            font-size: 14px;
            line-height: 1.4;
        }
        .comment-meta {
            font-size: 11px;
        }

        span.select2.select2-container.select2-container--bootstrap4 span.selection {
            line-height: 1;
        }
        .select2-container .select2-search--inline .select2-search__field {
            margin-top: 0;
            margin-left: 0;
            padding-left: 5px;
        }
        .sidebar {
            /* width: 384px; */
            /* min-width: 320px; */
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
            padding: 1.25rem;
            overflow-y: auto;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075); /* Bootstrap shadow */
            border-radius: .25rem; /* Bootstrap rounded corners */
            margin: 1.25rem;
             /* --- NEW/UPDATED CSS for scrolling --- */
            height: calc(100vh - 3rem); /* Full viewport height minus body padding (top+bottom) */
            overflow-y: auto; /* Enable vertical scrolling */
            -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
            /* --- END NEW/UPDATED CSS --- */
            margin-right: 0.25rem;
        }
        .content {
            flex: 1;
            height: calc(100vh - 3rem); 
            padding: 0rem;
            overflow-y: auto;
            margin: 1.25rem;
            background-color: #ffffff;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            border-radius: .25rem;
            border: 1px solid #dee2e6;
            margin-left: 0.25rem;
        }
        h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #343a40;
        }
        .req-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.15rem 1rem;
            border-bottom: 1px solid #e9ecef; /* lighter border */
            cursor: pointer;
            transition: background-color 0.2s ease;
            border-radius: .25rem;
            margin-bottom: .5rem;
            box-shadow: 2px 2px 4px #80808059;
            border: 0.5px solid #80808045;
        }
        .req-item:hover {
            background-color: #e2f0ff; /* light blue on hover */
        }
        .req-item.active {
            background-color: #cce5ff; /* light blue for active */
            border-left: 4px solid #007bff; /* Bootstrap primary blue */
            padding-left: calc(1rem - 4px);
        }
        .req-item .left {
            flex: 1;
            padding-right: 1rem;
            min-width: 0; /* allows ellipsis to work */
            max-width: 100%;
        }
        .req-item .right {
            text-align: right;
            font-size: 0.75rem;
            color: #6c757d; /* muted text */
        }
        .req-item strong {
            font-weight: 600;
            color: #212529; /* darker text */
        }
        .req-item small {
            font-size: 0.7rem;
            color: #495057;
            display: block; /* Ensure each small is on its own line */
        }
        /* Bootstrap badge styling for status/priority pills */
        .req-item .right .badge {
            font-size: 0.75rem; /* text-xs */
            padding: .35em .65em;
            margin-top: 0;
            display: inline-block; /* to allow margin-top */
        }
        /* Specific styles for the "Add New Requirement" button */
        .add-req-btn-container {
            margin-bottom: .5rem; /* Space below the button */
            padding-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
            text-align: center; /* Center the button */
        }
        .add-req-btn {
            width: 100%;
            padding: .5rem 1rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .pending-count {
            background-color: #ffeeba; /* Light yellow background */
            text-transform: uppercase;
            color: #856404; /* Dark yellow text */
            padding: .5rem .75rem;
            border-radius: .35rem;
            font-weight: 600;
            font-size: 0.7rem;
            /* margin-bottom: 1rem; */
            display: block; /* Takes full width */
            text-align: center;
            border: 1px solid #ffda82;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            line-height: 1.5rem;
            letter-spacing: 3px;
        }
        .filter-count {
            cursor: pointer;
            text-transform: uppercase;
            background-color: #ffeeba; /* Light yellow background */
            color: #856404; /* Dark yellow text */
            padding: .5rem .75rem;
            border-radius: .35rem;
            font-weight: 600;
            font-size: 0.7rem;
            /* margin-bottom: 1rem; */
            display: block; /* Takes full width */
            text-align: center;
            border: 1px solid #ffda82;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            line-height: 1.5rem;
            letter-spacing: 3px;
        }
        .two-line-ellipsis {
            display: -webkit-box;
            -webkit-line-clamp: 2;       /* Limit to 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .one-line-ellipsis {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            

        }
        .filter-section{
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dee2e6;
        }
        .btn-sm{
            max-height: 35px;
        }
        .insights-section span {
            background: wheat;
            margin: 0px 5px;
            padding: 2px 9px;
            border-radius: 10px;
            font-size: 13px;
        }
        .insights-section {
            margin: 0px 0px 10px 0px;
            border-bottom: 1px solid #dee2e6;
            padding: 2px 0 5px 0;
        }
        .blinking-text {
            animation: blink-animation 1s steps(1, start) infinite;
            background: yellow;
            display: inline-block;
            margin: 0 10px 0 0;
            padding: 0 10px;
            color: red;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .blinking-text2 {
            animation: blink-animation 1s steps(1, start) infinite;
            background: red;
            display: inline-block;
            margin: 0 10px 0 0;
            padding: 0 10px;
            color: yellow;
            font-weight: bold;
            letter-spacing: 1px;
        }
        @keyframes blink-animation {
            0% {
                opacity: 1; /* Visible at the beginning of the animation */
            }
            50% {
                opacity: 0; /* Hidden halfway through the animation */
            }
            100% {
                opacity: 1; /* Visible again at the end of the animation */
            }
        }
        span.swc0, span.swc1, span.swc2{
            color: white;
            background: red;
        }
    </style>
</head>
<body>
    <div class="sidebar col-md-6" id="requirementList">
        <!-- <div class="add-req-btn-container">
            <button class="btn btn-success add-req-btn" onclick="loadAddRequirementForm()">+ Add New Requirement</button>
        </div> -->
        <!-- <h3>Requirements</h3> -->
        <div class="row add-req-btn-container">
            <div class="col-md-4">
                <div class="filter-count" onclick="$('.filter-section').toggle();">
                    Search / Filter
                </div>
            </div>
            <!-- <div class="col-md-3">
                <div class="pending-count">
                    Pending with Me: <?= $pendingCount ?>
                </div>
            </div> -->
            <!-- <div class="col-md-3">
                <div class="pending-count">
                    Overall Pending: <?= $unclosedCount ?>
                </div>
            </div> -->
            <div class="col-md-4">
                <button class="btn btn-danger add-req-btn" onclick="loadAddRequirementForm()">+ Add New</button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section" style="display:none;">
            <h6 class="text-dark mb-3">SEARCH / FILTER</h6>
            <div class="form-row">
                <div class="form-group col-md-3 mb-2">
                    <select id="filterStatus" class="form-control custom-select">
                        <option value="">All Statuses</option>
                        <?php foreach ($statusLabels as $value => $label): ?>
                            <option value="<?= $value ?>" <?= ($filter_status !== null && $filter_status == $value) ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <select id="filterPriority" class="form-control custom-select">
                        <option value="">All Priorities</option>
                        <?php foreach ($priorityLabels as $value => $label): ?>
                            <option value="<?= $value ?>" <?= ($filter_priority !== null && $filter_priority == $value) ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <select id="filterCompany" class="form-control custom-select">
                        <option value="">All Companies</option> <!-- Changed label -->
                        <?php
                        if (!empty($getCompanyResult['result_set'])) {
                            foreach ($getCompanyResult['result_set'] as $company_option) { // Renamed $company to $company_option to avoid conflict
                        ?>
                            <option value="<?= htmlspecialchars($company_option['ID']) ?>"
                                <?= ($filter_company !== null && $filter_company == $company_option['ID']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($company_option['Label']) ?>
                            </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <label>
                        <input type="checkbox" id="closed" name="closed" <?php if($filter_closed) echo "checked"; ?> />
                        Include Closed
                    </label> 
                </div>
                
                <div class="form-group col-md-6 mb-2">
                    <select id="filterUser" class="form-control custom-select" multiple>
                        <option value="">All Users</option> <!-- Changed label -->
                        <?php
                        if (!empty($getUsersResult['result_set'])) {
                            foreach ($getUsersResult['result_set'] as $user_option) { // Renamed $company to $user_option to avoid conflict
                                // Check if the current user_option ID is in the $filter_users_array
                                $selected = in_array($user_option['ID'], $filter_user) ? 'selected' : '';
                        ?>
                            <option value="<?= htmlspecialchars($user_option['ID']) ?>" <?= $selected ?>>
                                <?= htmlspecialchars($user_option['Name']) ?>
                            </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            
                <div class="form-group col-md-6 mb-2">
                    <input type="text" class="form-control" id="searchQuery" placeholder="Search in text" value="<?= htmlspecialchars($search_query) ?>">
                </div>
                <div class=" col-md-6 d-flex justify-content-between">
                    <button class="btn btn-info btn-sm flex-grow-1 mr-2" onclick="applyFilters()">Apply Filters</button>
                    <button class="btn btn-secondary btn-sm flex-grow-1" onclick="clearFilters()">Clear Filters</button>
                </div>
            </div>
        </div>
        <!-- End Filter Section -->
        <div class="insights-section">
            <?php 
            // print_r($statuswiseCnt);
            if($unclosedCount > 0) echo "<div class='blinking-text'>TOTAL PENDING: " . $unclosedCount . "</div><br />";
            // if($pendingCount > 0) echo "<div class='insights-total'>PENDING WITH ME: " . $pendingCount . "</div>";
            for($i = 0; $i < 9; $i++){
                if($statuswiseCnt[$i] > 0){
                    echo "<span class='swc".$i."'>" . $statuswiseCnt[$i] . " - ". $statusLabels[$i] ."</span>";
                }
            }
            if($completedNotClosedCnt > 0) echo "<div class='blinking-text'>Completed But Not Closed By YOU: " . $completedNotClosedCnt . " (CLOSE THEM URGENTLY)</div><br />";
            if($lastAssignedToMeCnt > 0) echo "<div class='blinking-text2'>LAST ASSIGNED TO YOU: " . $lastAssignedToMeCnt . "</div><br />";
            ?>
        </div>
        <?php
        if ($requirements && is_array($requirementResults) && count($requirementResults) > 0) {
            foreach ($requirementResults as $req):
                $createdAt = $req['CreatedAt'];
                if (!($createdAt instanceof DateTime)) {
                    try {
                        $createdAt = new DateTime($createdAt);
                    } catch (Exception $e) {
                        $createdAt = new DateTime();
                        error_log("Failed to parse date for requirement ID " . ($req['ID'] ?? 'unknown') . " in iframe: " . $e->getMessage());
                    }
                }
                // echo $req['LatestCommentStatus'];
                $statusIndex = $req['LatestCommentStatus'] ?? null;
                $status = $statusLabels[$statusIndex] ?? 'Unknown';
                $priorityIndex = $req['LatestCommentPriority'] ?? null;
                $priority = $priorityLabels[$priorityIndex] ?? 'Unknown';
                
            ?>
            <div class="req-item" data-id="<?= $req['ID'] ?>">
                <div class="left">
                    <?php
                        // $reqShort = htmlspecialchars($req['CommentText']);
                        $reqShort = $req['ID'] . ": " . Encoding::fixUTF8($req['CommentText'],Encoding::ICONV_IGNORE);
                        // if (strlen($reqShort) > 100) {
                        //     $reqShort = substr($reqShort, 0, 297) . '...';
                        // }
                    if($_SESSION['Category'] == 2 || $_SESSION['Category'] == 3){
                    ?>
                    <div class="badge
                        <?php
                            if ($priorityIndex == 0) echo 'badge-success'; // Low (Bootstrap success color)
                            else if ($priorityIndex == 1) echo 'badge-warning'; // Medium (Bootstrap warning color)
                            else if ($priorityIndex == 2) echo 'badge-danger'; // High (Bootstrap danger color)
                            else echo 'badge-secondary';
                        ?>">
                        <?= $priority ?>
                    </div>
                    <?php } ?>
                    <strong class="one-line-ellipsis"><?= $reqShort ?></strong>
                    <small>Created By:<b> <?= htmlspecialchars($req['Name'] ?? '-') ?></b>
                        <?php if($_SESSION['Category'] == 2 || $_SESSION['Category'] == 3){ ?>
                            | Last Updated By:<b><?= $req['LatestUpdatedBy'] ?></b>
                        <?php if (!empty($req['Last_Assigned_Users'])): ?>
                            | Last Assigned To: <b><?= $req['Last_Assigned_Users'] ?></b>
                        <?php endif; ?>
                        <?php } ?>
                    </small>
                </div>
                <div class="right">
                    
                        <div class="badge
                            <?php
                                
                                if ($statusIndex == 0) echo 'badge-info'; // Assigned / Open* (Bootstrap info color)
                                else if ($statusIndex == 1) echo 'badge-warning'; // In Progress (Bootstrap warning color)
                                else if ($statusIndex == 2) echo 'badge-secondary'; // Completed (Pending Review) (Bootstrap success color)
                                else if ($statusIndex == 3) echo 'badge-primary'; // Reviewed / Ready for Customer (Bootstrap info color)
                                else if ($statusIndex == 4) echo 'badge-success'; // Customer Confirmed / Closed (Bootstrap warning color)
                                else if ($statusIndex == 5) echo 'badge-danger'; // Rework / Returned (Bootstrap success color)
                                else if ($statusIndex == 6) echo 'badge-warning'; // Hold (Bootstrap warning color)
                                else if ($statusIndex == 7) echo 'badge-dark'; // Cancel / Returned (Bootstrap success color)
                                else if ($statusIndex == 8) echo 'badge-info'; // Scheduled (Bootstrap success color)
                                else echo 'badge-secondary';

                            ?>">
                            <?= $status ?>
                        </div><br />
                        <?php if($_SESSION['Category'] == 2 ||$_SESSION['Category'] == 3){ ?>
                        <?php 
                        $tmpDueDate =  $req['DueDate'];
                        $dueBadge = '';
                        if($tmpDueDate == null || $tmpDueDate == ''){
                            // $req['DueDateDD']='';
                            $diffInDays=' - ';
                        }else{
                            $date2 = $tmpDueDate->format('Y-m-d');
                            $date1 = (new DateTime("now"))->format('Y-m-d');;
                            $timestamp1 = strtotime($date1);
                            $timestamp2 = strtotime($date2);
                            $diffInSeconds = ($timestamp2 - $timestamp1);
                            $difff = $diffInSeconds / (60 * 60 * 24);
                            $diffInDays = "DUE: " . $difff . " days";
                            if ($difff <= 1) $dueBadge = 'badge-danger'; // Assigned / Open* (Bootstrap info color)
                                else if ($difff == 2) $dueBadge = 'badge-warning'; // In Progress (Bootstrap warning color)
                                else if ($difff == 3) $dueBadge = 'badge-secondary'; // Completed (Pending Review) (Bootstrap success color)
                                else if ($difff >= 4) $dueBadge = 'badge-primary'; // Reviewed / Ready for Customer (Bootstrap info color)
                                // else if ($statusIndex == 4) echo 'badge-success'; // Customer Confirmed / Closed (Bootstrap warning color)
                                // else if ($statusIndex == 5) echo 'badge-danger'; // Rework / Returned (Bootstrap success color)
                                // else if ($statusIndex == 6) echo 'badge-warning'; // Hold (Bootstrap warning color)
                                // else if ($statusIndex == 7) echo 'badge-dark'; // Cancel / Returned (Bootstrap success color)
                                // else if ($statusIndex == 8) echo 'badge-info'; // Scheduled (Bootstrap success color)
                                else $dueBadge = 'badge-secondary';
                        }
                        ?>
                        <strong class="badge <?php echo $dueBadge;?>" style="font-weight: 900;font-size:14px;"><?= htmlspecialchars($diffInDays) ?></strong></small>
                    <?php } ?>
                    <!-- <br> -->
                    <small><strong style="font-weight: 600;font-size:14px;">Pending: <?= htmlspecialchars($req['PendingDays'] ?? '0') ?> days</strong></small>
                    <!--small>Created By:<b> <?= htmlspecialchars($req['Name'] ?? '-') ?></b> at <?= $createdAt->format('d-m-Y H:i:s') ?><strong style="font-weight: 900;font-size:18px;">Pending: <?= htmlspecialchars($req['PendingDays'] ?? '0') ?> days</strong></small-->

                    <!-- <small>Module: <?= htmlspecialchars($req['FormName'] ?? '-') ?></small> -->
                    
                </div>
 
            </div>
            <?php
            endforeach;
        } else {
            echo "<p class='p-4 text-center text-muted'>No TASKS found.<br />If you did not find what you are looking for, make sure you <b><u>include the Closed Status filter</u></b>.</p>";
        }
        ?>
    </div>
    <div class="content col-md-6" id="contentArea"> <!-- Renamed for clarity: contentArea -->
        <p class="text-center text-muted p-4">Select a requirement from the left panel to view details, or click "Add New Requirement" to create one.</p>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
         $(document).ready(function(){
            const contentArea1 = $('.filter-section');
            initializeSelect2Requirement(contentArea1); // Initialize Select2 on the loaded content
         
        });
         // Global function to initialize Select2 on dynamically loaded content on requirement page
        function initializeSelect2Requirement(containerElement) {
            // Destroy existing Select2 instances before re-initializing to prevent issues
            // This is important if you're replacing content that previously had Select2
            $('select', containerElement).each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
            });

            const filterUserToSelect = $('#filterUser', containerElement);
            console.log(filterUserToSelect);
            if (filterUserToSelect.length) {
                filterUserToSelect.select2({
                    placeholder: "Select user(s)",
                    allowClear: true,
                    width: '100%',
                    theme: 'bootstrap4',
                    dropdownParent: filterUserToSelect.parent()
                });
            }
        }

        // Global function to initialize Select2 on dynamically loaded content
        function initializeSelect2(containerElement) {
            // Destroy existing Select2 instances before re-initializing to prevent issues
            // This is important if you're replacing content that previously had Select2
            $('select', containerElement).each(function() {
                if ($(this).data('select2')) {
                    $(this).select2('destroy');
                }
            });

            // Initialize Select2 for assignedTo (multiple select)
            const assignedToSelect = $('#assignedTo', containerElement);
            if (assignedToSelect.length) {
                assignedToSelect.select2({
                    placeholder: "Select user(s)",
                    allowClear: true,
                    width: '100%',
                    theme: 'bootstrap4',
                    dropdownParent: assignedToSelect.parent()
                });
            }
            
            // Initialize Select2 for status and priority dropdowns (single select)
            $('#statusSelect, #prioritySelect', containerElement).select2({
                minimumResultsForSearch: Infinity,
                width: '100%',
                theme: 'bootstrap4',
                dropdownParent: assignedToSelect.parent().length ? assignedToSelect.parent() : null 
            });
        }

        // Function to load detail/edit form
        document.querySelectorAll('.req-item').forEach(item => {
            item.addEventListener('click', () => {
                const id = item.dataset.id;
                // Highlight selected
                document.querySelectorAll('.req-item').forEach(el => el.classList.remove('active'));
                item.classList.add('active');

                const contentArea = document.getElementById('contentArea');
                contentArea.innerHTML = '<p class="text-center text-muted p-4">Loading details...</p>';

                fetch('requirementDetail.php?id=' + id) // Fetch detail/edit view
                    .then(res => res.text())
                    .then(html => {
                        contentArea.innerHTML = html;
                        initializeSelect2(contentArea); // Initialize Select2 on the loaded content
                    })
                    .catch(err => {
                        console.error("Error fetching requirement details:", err);
                        contentArea.innerHTML = '<p class="text-center text-danger p-4">Failed to load details. Please try again.</p>';
                    });
            });
        });

        // Function to load the add requirement form (now points to requirementDetail.php?id=0)
        function loadAddRequirementForm() {
            // Remove active state from any selected requirement item
            document.querySelectorAll('.req-item').forEach(el => el.classList.remove('active'));

            const contentArea = document.getElementById('contentArea');
            contentArea.innerHTML = '<p class="text-center text-muted p-4">Loading add form...</p>'; // Loading indicator

            fetch('requirementDetail.php?id=0') // Load requirementDetail.php with ID 0 for new record
                .then(res => res.text())
                .then(html => {
                    contentArea.innerHTML = html;
                    $("#URLForm").val($("#URLF").val());
                    initializeSelect2(contentArea); // Initialize Select2 on the loaded add form
                })
                .catch(err => {
                    console.error("Error fetching add requirement form:", err);
                    contentArea.innerHTML = '<p class="text-center text-danger p-4">Failed to load the form. Please try again.</p>';
                });
        }

        // Consolidated function to save a requirement (new or existing)
        function saveRequirement(id, isNewRecord) { // isNewRecord is a flag passed from the button click
            const requirement = $('#requirementTextarea').val(); // Get value from the textarea
            if(<?php echo $_SESSION['Category']; ?> == 1){
                var assignedTo = JSON.parse(document.getElementById("userAssignedTo").value);
            }else{

                var assignedTo = $('#assignedTo').val(); // Gets value from the current Select2
            }
          
            var priority = $('#prioritySelect').val();
            const URLForm = $('#URLForm').val(); 
            const duedate = $('#duedate').val(); 

            
            
            const formData = new FormData();
            formData.append('action', isNewRecord ? 'add_requirement' : 'update_requirement');
            formData.append('id', id); // Will be 0 for new records, actual ID for updates
            formData.append('requirement', requirement);
            formData.append('URLForm', URLForm);
            formData.append('priority', priority);
            formData.append('duedate', duedate);
            if ($('#isShowComments').length > 0) {
                let isShowComments = $('#isShowComments').is(':checked') ? 1 : 0;
                formData.append('isShowComments', isShowComments);
            }

            if ($('#typeOfIssue').length > 0) {
                var typeOfIssue = $('#typeOfIssue').val();
                formData.append('typeOfIssue', typeOfIssue);
            }
            

            console.log(assignedTo);
            if (assignedTo) {
                assignedTo.forEach(val => formData.append('assignedTo[]', val));
            }
           
            // ONLY append attachment and formId if it's a new record AND the elements exist
            if (isNewRecord) {
                const attachmentInput = $('#attachmentInput')[0]; // Get the DOM element
                if (attachmentInput && attachmentInput.files && attachmentInput.files[0]) {
                    formData.append('attachment', attachmentInput.files[0]);
                }
                const formIdInput = <?php echo $formId; ?>;
                if (formIdInput) {
                    formData.append('formId', formIdInput);
                }
            } else {
                // Also append status, comment, priority if available (only on edit form)
                const statusSelect = $('#statusSelect');
                if(statusSelect.length) {
                    formData.append('status', statusSelect.val());
                }
                const prioritySelect = $('#prioritySelect');
                if(prioritySelect.length) {
                    formData.append('priority', prioritySelect.val());
                }
                const newComment = $('#newComment');
                if(newComment.length && newComment.val().trim() !== '') {
                    formData.append('comment', newComment.val());
                }
                formData.append('duedate', $('#duedate').val());
            }

            fetch('requirementAction.php', {
                method: 'POST',
                body: formData // No Content-Type header when using FormData, browser sets it
            })
            .then(res => res.json())
            .then(data => {
                alert(data.message); // Replace with custom modal later
                if (data.success) {
                    // Refresh the page to see updates in the sidebar list
                    location.reload(); 
                }
            })
            .catch(err => {
                console.error("Error saving requirement:", err);
                alert("Something went wrong saving the requirement."); // Replace with custom modal later
            });
        }

        // Make saveRequirement globally accessible (for onclick from requirementDetail.php)
        window.saveRequirement = saveRequirement;

        // Optionally, if the Save button on detail page directly calls saveStatusAndComment, you can remove it
        // and make it call saveRequirement instead, passing the ID and false for isNewRecord.


        function applyFilters() {
            const searchQuery = $('#searchQuery').val();
            const filterStatus = $('#filterStatus').val();
            const filterPriority = $('#filterPriority').val();
            const filterCompany = $('#filterCompany').val();
            const filterUser = $('#filterUser').val();
            const filterClosed = $('#closed').prop('checked');

            let url = new URL(window.location.origin + window.location.pathname);
            // url.searchParams.set('formId', currentFormId);
            // alert('hi',url);
            if (searchQuery) {
                url.searchParams.set('search_query', searchQuery);
            }
            if (filterStatus) {
                url.searchParams.set('filter_status', filterStatus);
            }
            if (filterPriority) {
                url.searchParams.set('filter_priority', filterPriority);
            }
            if (filterCompany) {
                url.searchParams.set('filter_company', filterCompany);
            }
            if (filterClosed) {
                url.searchParams.set('filter_closed', filterClosed);
            }
            // if (filterUser) {
            //     url.searchParams.set('filter_user', filterUser);
            // }

            if (filterUser && filterUser.length > 0) {
                // For multiple selected users, set them as an array in the URL
                url.searchParams.delete('filter_user'); // Clear existing to prevent duplicates
                console.log("filterUser",filterUser);
                filterUser.forEach(user_id => {
                    url.searchParams.append('filter_user[]', user_id);
                });
            }
             
            window.location.href = url.toString();
        }

        function clearFilters() {
            let url = new URL(window.location.origin + window.location.pathname);
            url.searchParams.set('formId', currentFormId);
            window.location.href = url.toString();
        }
    </script>
    <script>
        <?php //echo $NotifID;
        if($NotifID > 0){ ?>
            let targetId = <?php echo $NotifID; ?>;
            let targetDiv = document.querySelector(`div[data-id="${targetId}"]`);

            if (targetDiv) {
                targetDiv.click(); // This will simulate a click on the matching div
            }
        <?php } ?>
    </script>
    <input type="hidden" name="URLF" id="URLF" value="" />
</body>
</html>
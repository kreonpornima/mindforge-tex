<?php

require_once('dbClass.php'); // Ensure this file exists and provides db::getInstanceMaster()
session_start();

header('Content-Type: application/json'); // Set header for JSON response

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

$response = ['success' => false, 'message' => ''];

try {
    $action = $_POST['action'] ?? ''; // 'add_requirement' or 'update_requirement'
    $id = intval($_POST['id'] ?? 0); // ID of the requirement (0 for new records)

    $requirement = $_POST['requirement'] ?? '';
    $URLForm = $_POST['URLForm'] ?? '';
    $priority = $_POST['priority'] ?? 0;
    $duedate = $_POST['duedate'] ?? 0;
    $assignedTo = $_POST['assignedTo'] ?? []; // Array of assigned user IDs
    $attachment = $_FILES['attachment'] ?? null; // File upload data (only for add_requirement)
    $formid = intval($_POST['formId'] ?? 0);
    $current_user_id = $_SESSION['user_id'] ?? null;

    // Basic validation: ensure user is logged in
    if (!$current_user_id) {
        throw new Exception("Authentication required. User not logged in.");
    }

    // Sanitize and validate inputs
    $requirement = Encoding::fixUTF8(trim($requirement),Encoding::ICONV_IGNORE);
    $requirement = db::getInstance()->real_escape_string($requirement);
    // Ensure assignedTo values are integers for database safety
    $assignedTo = array_map('intval', (array)$assignedTo);

    if (empty($requirement)) {
        throw new Exception("Requirement description cannot be empty.");
    }

    $db = db::getInstanceMaster(); // Get database instance

    if ($action === 'add_requirement') {
        // --- Logic for adding a NEW requirement ---
        $mediaId = 0;

        // Handle attachment for new requirement
        if ($attachment && $attachment['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'img/Requirements/'; // Define your upload directory. Make sure it exists and is writable!
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            // Get file extension
            $ext = strtolower(pathinfo($attachment['name'], PATHINFO_EXTENSION));
            
            // Generate a unique file name to prevent conflicts
            $fileName = uniqid('req_') . '_' . basename($attachment['name']);
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($attachment['tmp_name'], $targetFilePath)) {
                // Insert a record into your media table (kmainmedia)
                $mediaSql = "INSERT INTO kmainmedia (MediaName, MediaType, MediaFolder) 
                VALUES ('".$fileName."','". $ext."','".$uploadDir."')";
                $mediaResult = $db->db_insertQuery($mediaSql); // Assuming db_insert returns insert_id

                // print_r($mediaResult);
                if ($mediaResult['error'] == 0) {
                    $mediaId = $mediaResult['last_id'];
                } else {
                    // Log error but proceed, maybe media record failed but file uploaded
                    error_log("Failed to save media file record for new requirement: " . ($mediaResult['message'] ?? 'Unknown error'));
                    // You might want to delete the uploaded file if the database record failed
                }
            } else {
                throw new Exception("Failed to upload attachment file.");
            }
        }

        $sql = "INSERT INTO Requirements (FormId, mediaID, CompanyId, DivisionId, YearCode, Status, CreatedBy, Priority, URLFrom, DueDate)
            VALUES ($formid, $mediaId, ".$_SESSION['dbCompany'].", ".$_SESSION['dbDivision'].", ".$_SESSION['dbYear'].", 0,".$_SESSION['user_id'].",$priority,'".$URLForm."','".$duedate."')";
    
        $insertResult = db::getInstanceMaster()->db_insertQuery($sql);
        

        if ($insertResult['error'] == 0) {
            $requirementId = $insertResult['last_id'];

            //Insert requirement name in RequirementComments table 
            $safeComment = Encoding::fixUTF8($requirement,Encoding::ICONV_IGNORE);
            $cleanComment = db::getInstance()->real_escape_string($safeComment);
            $commentSql = "INSERT INTO RequirementComments (RequirementID, CommentText,CreatedBy,Priority, DueDate)
                        VALUES ($requirementId, '$cleanComment',".$_SESSION['user_id'].",$priority,'".$duedate."')";
            $insertComment =  db::getInstanceMaster()->db_insertQuery($commentSql);

            if ($insertComment['error'] == 0) {
                $requirementCommentId = $insertComment['last_id'];

                // Assign users to the new requirement (if any are selected)
                if (!empty($assignedTo)) {
                    foreach ($assignedTo as $userId) {
                        $mapSql = "INSERT INTO Requirement_AssignedTo (RequirementCommentID, AssignedTo)
                            VALUES ($requirementCommentId, $userId)";
                        $result1 = db::getInstanceMaster()->db_insertQuery($mapSql);
                        
                        $notifSql = "INSERT INTO Requirement_Notifications ([TaskID],[UserID],[NotifyType],[CreatedBy],[CreatedAt],[CommentID]) 
                            VALUES('" . $requirementId . "', '".$userId."','1','". $_SESSION['user_id']."', GETDATE(),'".$result1['last_id']."' )";
                        $result2 = db::getInstanceMaster()->db_insertQuery($notifSql);
                    }
                }
                $response['success'] = true;
                $response['message'] = "New requirement added successfully!";
                $response['newId'] = $requirementId;
            }
        } else {
            throw new Exception("Error RN1: Failed to add new requirement to database. " . ($insertResult['message'] ?? ''));
        }

    } else if ($action === 'update_requirement') {
        // --- Logic for updating an EXISTING requirement ---
        if ($id === 0) { // Should not happen for an 'update' action
            throw new Exception("Cannot update: Requirement ID is missing or invalid.");
        }

        // Get status, priority, and comment from POST data (these fields are present in update mode)
        $status = intval($_POST['status'] ?? 0);
        $priority = intval($_POST['priority'] ?? 1);
        $comment = trim($_POST['comment'] ?? '');

        if (!empty($comment)){
            // Add a new comment if the comment field is not empty
            if (!empty($comment)) {
                $safeComment = Encoding::fixUTF8($comment, Encoding::ICONV_IGNORE);
                $cleanComment = db::getInstance()->real_escape_string($safeComment);
                $commentSql = "INSERT INTO RequirementComments (RequirementID, CommentText, CreatedBy, Status, Priority, DueDate)
                        VALUES ($id, '$cleanComment',".$_SESSION['user_id'].", $status, $priority, '".$duedate."')";
                $InsertComment = db::getInstanceMaster()->db_insertQuery($commentSql);

                if ($updInsertCommentateResult['error'] == 0 ) {
                    $RequirementCommentID = $InsertComment['last_id'];
                    // Update assigned users: First delete all existing assignments for this requirement, then re-insert
                    // This ensures only the currently selected users are assigned
                    // $db->db_delete("DELETE FROM Requirement_AssignedTo WHERE RequirementID = :reqId", [':reqId' => $id]);
                    if (!empty($assignedTo)) {
                        foreach ($assignedTo as $userId) {
                        
                            // Check if this assignment already exists
                            $checkSql = "SELECT 1 FROM Requirement_AssignedTo 
                                        WHERE RequirementID = $id AND AssignedTo = $userId";
                            $exists = db::getInstanceMaster()->db_select($checkSql);
                
                            if (empty($exists['result_set'])) {
                                // Only insert if it doesn't exist
                                $mapSql = "INSERT INTO Requirement_AssignedTo (RequirementCommentID, AssignedTo)
                                        VALUES ($RequirementCommentID, $userId)";
                                db::getInstanceMaster()->db_insertQuery($mapSql);
                            }
                        }
                    }
                    ///To get the users whom the Task is assigned
                    $sql = "select AssignedTo from Requirement_AssignedTo LEFT JOIN RequirementComments ON RequirementCommentID = RequirementComments.ID WHERE RequirementID =  " . $id . " GROUP BY AssignedTo";
                    $res = db::getInstanceMaster()->db_select($sql);
                    for($i = 0; $i < $res['num_rows']; $i++){
                        if($res['result_set'][$i]['AssignedTo'] == $_SESSION['user_id']) continue;  //To skip same user
                        $notifSql = "INSERT INTO Requirement_Notifications ([TaskID],[UserID],[NotifyType],[CreatedBy],[CreatedAt],[CommentID]) 
                            VALUES('" . $id . "', '".$res['result_set'][$i]['AssignedTo']."','2','". $_SESSION['user_id']."', GETDATE(),'".$RequirementCommentID."' )";
                        $result2 = db::getInstanceMaster()->db_insertQuery($notifSql);
                    }
                    ///To get the user who created the TASK
                    $sql = "select CreatedBy from [dbo].[requirements] WHERE id = " . $id;
                    $res = db::getInstanceMaster()->db_select($sql);
                    for($i = 0; $i < $res['num_rows']; $i++){
                        if($res['result_set'][$i]['CreatedBy'] == $_SESSION['user_id']) continue;
                        $notifSql = "INSERT INTO Requirement_Notifications ([TaskID],[UserID],[NotifyType],[CreatedBy],[CreatedAt],[CommentID]) 
                            VALUES('" . $id . "', '".$res['result_set'][$i]['CreatedBy']."','2','". $_SESSION['user_id']."', GETDATE(),'".$RequirementCommentID."' )";
                        $result2 = db::getInstanceMaster()->db_insertQuery($notifSql);
                    }
                }
                $response['success'] = true;
                $response['message'] = "Requirement updated successfully!";
            } else {
                throw new Exception("Failed to update requirement in database. " . ($updateResult['message'] ?? ''));
            }

               
        }else{
            throw new Exception("Comment Is Required.");
        }

    } else {
        throw new Exception("Invalid action specified. Action: " . Encoding::fixUTF8($action,Encoding::ICONV_IGNORE));
    }

} catch (Exception $e) {
    $response['message'] = "Error: " . $e->getMessage();
    // Log the full error details for debugging, but only return a user-friendly message
    error_log("RequirementAction PHP Error: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile() . "\nStack: " . $e->getTraceAsString());
}

echo json_encode($response);
?>

<?php

require_once('dbClass.php');

$formId = intval($_POST['formId']);
$requirements =  json_decode($_POST['requirements'], true); //Decode JSON string to array
$uploadedFiles = $_FILES['files'];
$inserted = 0;
$mediaID = 0;


foreach ($requirements as $index => $req) {
    $requirement = $req['requirement'];
    $assignedToList = $req['assignedTo'];

    // File Upload
    if (!empty($uploadedFiles['name'][$index])) {
        $tmpName = $uploadedFiles['tmp_name'][$index];
        $originalName = $uploadedFiles['name'][$index];
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $newName = uniqid("req_") . '.' . $ext;
        $uploadDir = 'img/Requirements/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $fullPath = $uploadDir . $newName;

        if (move_uploaded_file($tmpName, $fullPath)) {
            // Insert into kmainmedia or similar
            $mediaSql = "INSERT INTO kmainmedia (MediaName, MediaType, MediaFolder) 
            VALUES ('".$newName."','". $ext."','".$uploadDir."')";
            
            $mediaResult = db::getInstanceMaster()->db_insertQuery($mediaSql);
        }
        $mediaID = $mediaResult['last_id'];
    }
    // Insert into Requirements table
    $sql = "INSERT INTO Requirements (Requirement, FormId, mediaID, CompanyId, DivisionId, YearCode, Status, CreatedBy, Priority)
            VALUES ('$requirement',  $formId, $mediaID, ".$_SESSION['dbCompany'].", ".$_SESSION['dbDivision'].", ".$_SESSION['dbYear'].", 0,".$_SESSION['user_id'].",0)";
    
    $result = db::getInstanceMaster()->db_insertQuery($sql);
    $requirementId = $result['last_id'];
    // print_r($result);

    if ($requirementId) {
        $inserted++;

        foreach ($assignedToList as $userId) {
            $assignedTo = intval($userId);

            $mapSql = "INSERT INTO Requirement_AssignedTo (RequirementID, AssignedTo)
                        VALUES ($requirementId, $assignedTo)";

            $result1 = db::getInstanceMaster()->db_insertQuery($mapSql);
        }
    }
}

echo json_encode([
    'success' => $inserted > 0,
    'inserted' => $inserted,
    'message' => $inserted > 0 ? 'Saved successfully.' : 'Nothing inserted'
]);


?>
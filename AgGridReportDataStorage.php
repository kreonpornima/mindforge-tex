<?php 

ini_set('memory_limit', '1024M'); 

require_once('dbClass.php');


session_start();
// Retrieve parameters
// print_r($_REQUEST);
// echo "<br />";
// echo $t = file_get_contents('php://input');
// $r = json_decode($t);
// echo "<br />";
// print_r($r);
// exit();
// print_r(json_decode(file_get_contents('php://input'), true));
$data = $_REQUEST['data'] ?? "";
$ReportID = $_REQUEST['ReportID'] ?? 0;
$UserID = $_SESSION['user_id'] ?? 0;
$TemplateID = $_REQUEST['templateId'] ?? 0;
$TypeID = $_REQUEST['typeID'] ?? 0;
$TemplateName=$_REQUEST['tempName'] ?? 0;
$renameID=$_REQUEST['renameID'] ?? 0;
$deleteID=$_REQUEST['deleteID'] ?? 0;
$copyTemplateID=$_REQUEST['copyTemplateID'] ?? 0;
$selectedGroups=$_REQUEST['selectedGroups'] ?? [];
// echo $TemplateName;

$dbCompany = $_SESSION['dbCompany'] ?? 0;
$dbDivision = $_SESSION['dbDivision'] ?? 0;
$dbYearID = $_SESSION['dbYearID'] ?? 0;
$dbGroupID = $_SESSION['group_id'] ?? 0;


$TemplateDescription=$_REQUEST['templateDescription'] ?? 0;
$data = db::getInstance()->real_escape_string($data);
if($deleteID > 0){
    $sql = "DELETE FROM kreport_template_data WHERE ReportID = $ReportID AND ID = $TemplateID";
    $result = db::getInstanceMaster()->db_update($sql);
    echo json_encode($result);
    exit();
}
if($renameID > 0){
    $sql = "UPDATE kreport_template_data SET TemplateName = '$TemplateName', CompanyID = $dbCompany, DivisionID=$dbDivision, YearCode='$dbYearID', GroupID='$dbGroupID' WHERE ID = $renameID";
    $result = db::getInstanceMaster()->db_insertQuery($sql);
    echo json_encode($result);
    exit();
}
if($copyTemplateID > 0){
    $query = "SELECT * FROM kreport_template_data WHERE ReportID = $ReportID AND ID =$TemplateID";
    $result = db::getInstanceMaster()->db_select($query);
    if ($result['num_rows'] > 0) {
        $tName = $result["result_set"][0]["TemplateName"];
        $tDescription = $result["result_set"][0]["TemplateDescription"];
        $tTypeID = $result["result_set"][0]["TemplateTypeID"];
        $tReportJson = $result["result_set"][0]["ReportJson"];
        foreach ($selectedGroups as $groupId) {
            $sql = "INSERT INTO kreport_template_data (TemplateName, TemplateDescription, ReportID, TemplateTypeID, 
            UserID, ReportJson, GroupID) VALUES ('$tName','$tDescription','$ReportID','$tTypeID','$UserID','$tReportJson','$groupId')";
            $result = db::getInstanceMaster()->db_insertQuery($sql);
        }
        echo json_encode($result);
    }
    exit();
}

$lastInsertedID = 0;
// echo $TypeID;
// echo "TemplateTypeID";
// echo $TemplateTypeID;
if (!$TemplateID) {
    if(strlen($TemplateName) > 0){
        // echo $TemplateName;
        $sql = "INSERT INTO kreport_template_data (TemplateName, TemplateDescription, ReportID, TemplateTypeID, UserID, ReportJson, CompanyID, DivisionID, YearCode, GroupID) 
                    VALUES ('$TemplateName', '$TemplateDescription', '$ReportID', '$TypeID', '$UserID', '$data',$dbCompany,$dbDivision,'$dbYearID','$dbGroupID')";
        $result = db::getInstanceMaster()->db_insertQuery($sql);
        // echo"result";
        // print_r($result);
        echo $lastInsertedID = $result['last_id'];

        //  print_r(result);
        // $sql = "UPDATE kreport_template_data SET ReportJson = '$data',TemplateName='$TemplateName',TemplateDescription='$TemplateDescription' WHERE ID=$lastInsertedID";
        //  $result = db::getInstanceMaster()->db_insertQuery($sql);
        //  $result['result_set'][0]["ReportJson"];
        //  print_r($result);
    }
}else{
    if (strlen($data) > 0) {
        // Check if there is an existing record for the ReportID and UserID
        // echo "in the else block";
        $query = "SELECT * FROM kreport_template_data WHERE ReportID = $ReportID AND ID =$TemplateID";
        $result = db::getInstanceMaster()->db_select($query);
        // print_r($result);resultArray
        if ($result['num_rows'] > 0) {
            // If record exists, update the existing entry
            // $UpdateID = $result["result_set"][0]["ID"];
            $sql = "UPDATE kreport_template_data SET ReportJson = '$data',TemplateTypeID='$TypeID', GroupID='$dbGroupID' WHERE ID = $TemplateID";
            $result = db::getInstanceMaster()->db_insertQuery($sql);
        } else {
            // If record does not exist, insert a new entry
            $sql = "INSERT INTO kreport_template_data (ID,TypeTemplateID, ReportID, UserID, ReportJson, CompanyID, DivisionID, YearCode, GroupID) VALUES ('$TemplateID','$TypeID', '$ReportID', '$UserID', '$data',$dbCompany,$dbDivision,'$dbYearID','$dbGroupID')";
            $result = db::getInstanceMaster()->db_insertQuery($sql);
            
        }
    }  
    // Retrieve the saved state from the database
    $query = "SELECT ReportJson FROM kreport_template_data WHERE ReportID = $ReportID AND ID = $TemplateID" ;
    $result = db::getInstanceMaster()->db_select($query);
    // print_r($result);

    // Check if there's a saved state
    if ($result['num_rows'] > 0) {
        // Output the saved state
        $savedState = $result['result_set'][0]["ReportJson"];
        echo $savedState;
    
    } else {
        // If no saved state found, output an empty string
        echo "";
    }
}

// echo $lastInsertedID;
// Check if data is provided

?>


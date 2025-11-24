<?php

session_start();
require_once('dbClass.php');

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : 0;
$FieldId = isset($_POST['FieldId']) ? $_POST['FieldId'] : 0;
$FormMode = isset($_POST['FormMode']) ? $_POST['FormMode'] : 0;
$GridRowEditID = isset($_POST['GridRowEditID']) ? $_POST['GridRowEditID'] : 0;
$GridRowUniqueID = isset($_POST['GridRowUniqueID']) ? $_POST['GridRowUniqueID'] : 0;

if (preg_match('/^\d+_/', $FieldId)) {
    $parts = explode('_', $FieldId);

    // Remove first character
    $field = substr($parts[1], 1);

    $SPName = "spGetDetails_".$FormID."_".$parts[0]."_".$field;
}else{
    $SPName = "spGetDetails_$FormID";
}


$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO' AND routine_name = '$SPName'";
$sqlresult = db::getInstance()->db_select($sql);


if($sqlresult['result_set'][0]['found'] == 1) {
    $session = 'YearCode=' . $_SESSION['dbYear'] . ' AND DivisionId=' . $_SESSION['dbDivision'] . ' AND CompanyId=' . $_SESSION['dbCompany'] . ' AND FormID=' . $FormID;

    $sp['params'] = ['@FIELDID', '@FORMMODE', '@USERID', '@SESSION','@GRIDROWEDITID','@GRIDROWUNIQUEID'];
    $sp['values'] = ["'$FieldId'", "'".$FormMode."'", "'".$_SESSION['user_id']."'", "'$session'","$GridRowEditID","'".$GridRowUniqueID."'"];

    $result = db::getInstance()->db_sp_select($SPName, $sp['params'], $sp['values']);

    // print_r($result);
    $arr = array("Success" => $result['result_set'][0][0]['Success'],"GridResponse" => $result['result_set'][0][0]['GridResponse'], "tempData" => $result['result_set'][1][0]);
}

echo json_encode($arr);


?>
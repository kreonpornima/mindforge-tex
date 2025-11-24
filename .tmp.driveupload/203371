<?php
include 'dbClass.php';
//print_r($_REQUEST);
$ReportID = isset($_GET['ReportID']) ? $_GET['ReportID'] : 0; 
$ID = isset($_GET['ID']) ? $_GET['ID'] : 0; 
$Field = isset($_GET['Field']) ? $_GET['Field'] : 0; 
$oldValue = isset($_GET['oldValue']) ? $_GET['oldValue'] : 0; 
$newValue = isset($_GET['newValue']) ? $_GET['newValue'] : 0; 
$Session = isset($_GET['session']) ? $_GET['session'] : ''; 

$sql = "SELECT UpdateQuery FROM kReportGridEditableFields WHERE FormID =" . $_GET['ReportID'] . " AND DbFieldName = '" . $Field . "'";
$viewResult = db::getInstanceMaster()->db_select($sql);
// print_r($viewResult);
if($viewResult['num_rows'] > 0){
    $UpdateQuery = $viewResult['result_set'][0]['UpdateQuery'];    
    $SPresult = db::getInstance()->db_sp_select($UpdateQuery, array('@FieldName','@UpdatedData','@OldData','@PrimaryKey','@Session' ), array("'".$Field."'", "'".$newValue."'", "'".$oldValue."'", "'".$ID."'", "'".$Session."'"));
}
if($SPresult['error'] == 0){
    if($SPresult['result_set'][0][0]['ErrorFlag'] == 1){
        $SPresult['error'] = 1;
        $SPresult['error_statement'] = $SPresult['result_set'][0][0]['ErrorMsg'];
    }
}
echo json_encode($SPresult);
exit();
?>
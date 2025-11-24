<?php
include 'dbClass.php';
//print_r($_REQUEST);
$ReportID = isset($_GET['ReportID']) ? $_GET['ReportID'] : 0; 
$ID = isset($_GET['ID']) ? $_GET['ID'] : 0; 
$Field = isset($_GET['Field']) ? $_GET['Field'] : 0; 
$oldValue = isset($_GET['oldValue']) ? $_GET['oldValue'] : 0; 
$newValue = isset($_GET['newValue']) ? $_GET['newValue'] : 0; 
$Session = isset($_GET['session']) ? $_GET['session'] : ''; 
$RowData = isset($_GET['RowData']) ? $_GET['RowData'] : []; 
$output = [];
foreach ($RowData as $key => $value) {
    $output[] = "$key=$value";
}
$RowData = implode('|', $output);

$sql = "SELECT UpdateQuery FROM kReportGridEditableFields WHERE FormID =" . $_GET['ReportID'] . " AND DbFieldName = '" . $Field . "'";
$viewResult = db::getInstanceMaster()->db_select($sql);
// print_r($viewResult);
if($viewResult['num_rows'] > 0){
    $UpdateQuery = $viewResult['result_set'][0]['UpdateQuery'];    
    // if($ReportID = 5335){
        $SPresult = db::getInstance()->db_sp_select($UpdateQuery, array('@FieldName','@UpdatedData','@OldData','@PrimaryKey','@Session','@RowData' ), array("'".$Field."'", "'".$newValue."'", "'".$oldValue."'", "'".$ID."'", "'".$Session."'", "'".$RowData."'"));
    // }else{
        // $SPresult = db::getInstance()->db_sp_select($UpdateQuery, array('@FieldName','@UpdatedData','@OldData','@PrimaryKey','@Session' ), array("'".$Field."'", "'".$newValue."'", "'".$oldValue."'", "'".$ID."'", "'".$Session."'"));
    // }
    // print_r($SPresult);
}
if($SPresult['error'] == 0){
    if($SPresult['result_set'][0][0]['ErrorFlag'] == 1){
        $SPresult['error'] = 1;
        $SPresult['error_statement'] = $SPresult['result_set'][0][0]['ErrorMsg'];
    }else{
        if (isset($SPresult['result_set'][0][0])) {
            $SPresult['CurrentRowResponse'] = $SPresult['result_set'][0][0];
        }
    }
}
echo json_encode($SPresult);
exit();
?>
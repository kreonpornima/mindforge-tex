<?php 
include_once('dbClass.php');

// $ar = json_decode($_POST['excelData']);


// $spName = isset($_REQUEST['spName']) ? $_REQUEST['spName'] : "";
$excelData = isset($_REQUEST['excelData']) ? $_REQUEST['excelData'] : "";
$FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : "";


$sql1 = "SELECT * FROM kgridfields where GridId=$GridID ORDER BY DisplayOrder";
$sql1result = db::getInstanceMaster()->db_select($sql1);


$sp = [];
$sp['name'] = 'tmpSP';
$sp['params'] = ['@params'];
$sp['values'] = [$gridData];
    
$result = db::getInstanceMaster()->db_sp_select($sp['name'], $sp['params'], $sp['values']);
    
$arr = array("data" =>  $sql1result['result_set'], "gridData" =>$gridData);

echo json_encode($arr);

// echo json_encode($_POST['excelData']);
// echo ($_POST['excelData']);
?>
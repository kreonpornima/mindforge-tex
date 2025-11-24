<?php
require_once ('dbClass.php');

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : "";
$EditID = isset($_POST['EditID']) ? $_POST['EditID'] : "";

$set = [];
$val = [];

array_push($set,'@EDITID');
array_push($val, "'$EditID'");


$sp['params'] = $set;
$sp['values'] = $val;

$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = 'sp_ValidateEdit_$FormID'";
$sqlresult = db::getInstance()->db_select($sql);

if($sqlresult['result_set'][0]['found'] == 0){
    $arr = array("status" => false);
}else{
    $result = db::getInstance()->db_sp_select("sp_ValidateEdit_$FormID", $sp['params'], $sp['values']);

    $row = $result['result_set'];
    $arr = array("status" => true,"data" => $row);

}

echo json_encode($arr);

?>
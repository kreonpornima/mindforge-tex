<?php 

require_once ('dbClass.php');

$Party = $_REQUEST['selectedValue'];

$Party = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : "";
$responseParams = isset($_POST['responseParams']) ? $_POST['responseParams'] : "";

$responseParamsString = " AND ".implode(' AND ', $responseParams);

$query = "SELECT * from master_broker WHERE 1=1 $responseParamsString";

// $result = db::getInstance()->db_select($query);

// $row = $result['result_set'];

// $arr = array("BrokerName" => $row, "TrspPay" => "Testing", "ChlDate" => "2024-01-18", 
// "cnta" => "4", "Remark" => "Remark TTTest", "EntryNo" => "1234567", 
// "QualityName" => $row, "QualityType"=>$row);


$arr = array("Fld1Value" => "gsgdkjsdjkh");

echo json_encode($arr);

 ?>


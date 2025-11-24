<?php 

require_once ('dbClass.php');

$Party = $_REQUEST['selectedValue'];

$query = "SELECT * from master_broker WHERE PartyID = '$Party' ";

$result = db::getInstance()->db_select($query);



//$result = mysql_query($query);

//$row = mysql_fetch_assoc($result);

$row = $result['result_set'];

$arr = array("BrokerName" => $row, "TrspPay" => "Testing");
echo json_encode($arr);

 ?>


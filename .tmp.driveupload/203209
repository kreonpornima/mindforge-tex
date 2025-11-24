<?php 

require_once ('dbClass.php');

$responseParams = isset($_REQUEST['responseParams']) ? $_REQUEST['responseParams'] : "";
$fromRepo = isset($_REQUEST['fromRepo']) ? $_REQUEST['fromRepo'] : "";
$searchParam = isset($_REQUEST['searchParam']) ? $_REQUEST['searchParam'] : "";

if($searchParam){
    $searchString = " AND ".str_replace(',',' and ',$searchParam);
}

$query = "SELECT ". $responseParams . "  from ". $fromRepo ." where 1=1 ". $searchString; 

$result = db::getInstance()->db_select($query);

$row = $result['result_set'];
print_r($row);
//echo json_encode($row);

 ?>


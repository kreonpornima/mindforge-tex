<?php 

require_once ('dbClass.php');

$fromRepo = isset($_REQUEST['fromRepo']) ? $_REQUEST['fromRepo'] : "";
$searchParam = isset($_REQUEST['searchParam']) ? $_REQUEST['searchParam'] : "";

if($searchParam){
    $searchString = " AND ".str_replace(',',' and ',$searchParam);
}

$tblColumn = isset($_REQUEST['tblResponse']) ? $_REQUEST['tblResponse'] : "";

// print_r($columns);

$query = "SELECT $tblColumn from $fromRepo where 1=1 $searchString ";

$result = db::getInstance()->db_select($query);
// print_r($result);
$row = $result['result_set'];

$fields = explode(',',$tblColumn);
$columns = [];
for($i=0; $i<count($fields); $i++){
    array_push($columns,(array("data" => trim($fields[$i]), "name" => trim($fields[$i]))));
}
// print_r($columns);
// echo "<br>";

$arr = array("data" => $row, "columns" => $columns);

echo json_encode($arr);

 ?>


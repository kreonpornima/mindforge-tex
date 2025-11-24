<?php 

require_once ('dbClass.php');

$searchParam = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : "";

$query = "SELECT * from AiDivision where $searchParamString and ID != $editId";

$result = db::getInstance()->db_select($query);

$arr = array( "rows" => $result['num_rows']);

echo json_encode($arr);


 ?>


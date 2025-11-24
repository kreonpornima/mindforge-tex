<?php 

require_once ('dbClass.php');


$fromRepo = isset($_POST['fromRepo']) ? $_POST['fromRepo'] : "";
$searchParam = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : "";

$searchParamString = implode(" and ",$searchParam);  

$editId = $_POST['editId'];

if($editId == 0){
   $query = "SELECT * from $fromRepo where $searchParamString";
}else{

   $query = "SELECT * from $fromRepo where $searchParamString and ID != $editId";
}
// echo $query;
$result = db::getInstance()->db_select($query);

// print_r($result);

$arr = array( "rows" => $result['num_rows']);

echo json_encode($arr);


 ?>


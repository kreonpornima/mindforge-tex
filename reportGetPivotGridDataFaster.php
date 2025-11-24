<?php 

require_once ('dbClass.php');

$responseParams = isset($_REQUEST['responseParams']) ? $_REQUEST['responseParams'] : "";
$fromRepo = isset($_REQUEST['fromRepo']) ? $_REQUEST['fromRepo'] : "";
$searchParam = isset($_REQUEST['searchParam']) ? $_REQUEST['searchParam'] : "";

/*if($searchParam){
    $searchString = " AND ".str_replace(',',' and ',$searchParam);
}*/

$query = "SELECT ". $responseParams . "  from ". $fromRepo ." where 1=1 ". $searchString; 

$result = db::getInstance()->db_select($query);

//$row = $result['result_set'];
//print_r($row);
    $finalResult = array();
    $jsonData = "[";
	$separator = "";
	for($i = 0; $i < $result['num_rows']; $i++){
		foreach($result['result_set'][$i] as $key => $value){
			//echo $key . "-";
			if(is_numeric($value)) {
				$valueINT = (float) $value;
				$finalResult[$i][$key] = $valueINT;
			} else {
				$finalResult[$i][$key] = $value;
			}
		}
		if(sizeof($finalResult[$i]) > 0 )
			if(strlen(json_encode($finalResult[$i])) > 0)
				$jsonData .= $separator . json_encode($finalResult[$i]);
		$separator = ","; 
	}
	$jsonData .= "]";
    echo $jsonData;
    //$finalData = "{'data': " . $jsonData . ",'totalCount': '200','summary': [170, 20, 20, 1020]}";
    //echo $finalData;
    //echo json_encode($jsonData);
//echo json_encode($row);

 ?>


<?php
require_once ('dbClass.php');

$FormData = isset($_POST['formData']) ? $_POST['formData'] : "";

$data = explode("&",$FormData);

$FormId = explode("=",$data[0]);

$set = [];
$val = [];
$finalArray = array();
$finalCnt = 0;
$separator = "";
for($i=0; $i<count($data); $i++){
    if (strrpos($data[$i], "cnt") !== false) {
        if (strrpos($data[$i + 1], "GridId") !== false) {
            $finalCnt++;
            $separator = "";
        }
    }

    if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false ){
        if (strpos($data[$i], "kreon-grid-") === false ){
            
            $finalArray[$finalCnt] .= $separator . $data[$i];
            $separator = "|";
        }
    }else{
        if (strpos($data[$i], "editID") !== false ){
            $finalArray[0] .= "|" . $data[$i];
        }

    }
}

array_push($set,'@USERNAME');
array_push($val, "'".$_SESSION['user_id']."'");
for($k=0; $k<count($finalArray); $k++){
    if($k==0){
        array_push($set,'@FORM');
        array_push($val,"'$finalArray[$k]'");
    }else{
        array_push($set,"@GRID$k");
        array_push($val,"'$finalArray[$k]'");
    }
}

$sp['params'] = $set;
$sp['values'] = $val;


$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = 'sp_ValidateSave_$FormId[1]'";
$sqlresult = db::getInstance()->db_select($sql);

if($sqlresult['result_set'][0]['found'] == 0){
    $arr = array("status" => false);
}else{
    $result = db::getInstance()->db_sp_select("sp_ValidateSave_$FormId[1]", $sp['params'], $sp['values']);

    $row = $result['result_set'];
    $arr = array("status" => true,"data" => $row);

}

echo json_encode($arr);

?>
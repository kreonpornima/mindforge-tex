<?php 

require_once ('dbClass.php');

$responseParams = isset($_REQUEST['responseParams']) ? $_REQUEST['responseParams'] : "";
$FormData = isset($_REQUEST['FormData']) ? $_REQUEST['FormData'] : "";
$editid = isset($_REQUEST['editid']) ? $_REQUEST['editid'] : 0;
$fromRepo = isset($_REQUEST['fromRepo']) ? $_REQUEST['fromRepo'] : "";
$fromRepoSp = isset($_REQUEST['fromRepoSP']) ? $_REQUEST['fromRepoSP'] : "";
$parameters = isset($_POST['parameters']) ? $_POST['parameters'] : "";
$GridId = isset($_POST['GridId']) ? $_POST['GridId'] : "";
$user_id = isset ($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;


$responseParamsFields = explode("|",$responseParams);
$responseParamsFieldsArray = [];
$finalParams = "";
$columns = "";
for($i=0; $i<sizeof($responseParamsFields); $i++){
    $responseParamsFieldsArray = explode(":",$responseParamsFields[$i]);

    if(count($responseParamsFieldsArray) == 3){
        $columns .= $responseParamsFieldsArray[1] .",". $responseParamsFieldsArray[2];
    }else{
        $columns .= $responseParamsFieldsArray[1];
    }
    if($i != sizeof($responseParamsFields)-1){
        $columns .= ",";
    }

    $sql2 = "SELECT FieldType FROM kgridfields where GridId=$GridId AND DbFieldName='".trim($responseParamsFieldsArray[0])."'";

    $sql2result = db::getInstanceMaster()->db_select($sql2);
    if($sql2result['num_rows'] > 0){

        $finalParams .= trim($responseParamsFieldsArray[0]).":".trim($responseParamsFieldsArray[1]).":".trim($sql2result['result_set'][0]['FieldType']);

        if($responseParamsFieldsArray[1]){
            $finalParams .= ":".trim($responseParamsFieldsArray[2]);
        }

        if($i != sizeof($responseParamsFields)-1){
            $finalParams .= "|";
        }
    }
}

$finalResponseParams = explode("|", $finalParams);

if(strlen($fromRepo) > 2){
    $query = "SELECT $columns from $fromRepo WHERE 1=1 ";
    
    if(strlen($parameters) > 1){
        $query .= "AND $parameters";
    }
    // echo $query;
    $result = db::getInstance()->db_select($query);
    $row = $result['result_set'];
}

if(strlen($fromRepoSp) > 2){
    if(strlen($parameters) > 1){
        $parametersArray = explode('=',$parameters);
    }
    
    $sp['params'] = ['@username','@form','@barcode','@editid'];
    $sp['values'] = [$user_id,"'".urldecode($FormData)."'",$parametersArray[1],$editid];
    $result = db::getInstance()->db_sp_select($fromRepoSp, $sp['params'], $sp['values']);
    // print_r($result);
    $row = $result['result_set'][0];
}


$arr = array("finalParams" => $finalResponseParams,"data" => $row,"bordercolor" => $result['result_set'][1][0], "Msg" => $result['result_set'][2], "NonEditableFields" => $result['result_set'][3][0]);

echo json_encode($arr);

 ?>


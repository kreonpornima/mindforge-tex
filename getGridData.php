<?php

require_once ('dbClass.php');


include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

// $spName = isset($_REQUEST['spName']) ? $_REQUEST['spName'] : "";
$selectedRowId = isset($_REQUEST['selectedRowId']) ? $_REQUEST['selectedRowId'] : "";
$GridId = isset($_REQUEST['GridId']) ? $_REQUEST['GridId'] : "";
$FieldType = isset($_REQUEST['DBFieldType']) ? $_REQUEST['DBFieldType'] : 0;
$FormId = isset($_REQUEST['FormId']) ? $_REQUEST['FormId'] : "";
$FieldName = isset($_REQUEST['FieldName']) ? $_REQUEST['FieldName'] : "";
$isGrid = isset($_REQUEST['isGrid']) ? $_REQUEST['isGrid'] : "";
$requestParams = isset($_REQUEST['requestParams']) ? $_REQUEST['requestParams'] : "";
$formReeponse = isset($_REQUEST['formResponse']) ? $_REQUEST['formResponse'] : "";

// if($FieldType == 14){
//     $sql = "SELECT FieldOtherConditions FROM kmainfields where FieldType=14 AND GridId=$GridId";
//     $sqlresult = db::getInstanceMaster()->db_select($sql);
// }elseif($FieldType == 17){
//     $sql = "SELECT FieldOtherConditions FROM kmainfields where FieldType=17";
//     $sqlresult = db::getInstanceMaster()->db_select($sql);
// }elseif($FieldType == 23){
//     $sql = "SELECT FieldOtherConditions FROM kmainfields where FieldType=23 AND GridId=$GridId";
//     $sqlresult = db::getInstanceMaster()->db_select($sql);
// }

if($FieldType == 14){
    $sql = "SELECT FieldOtherConditions FROM kmainfields where FieldType=14 AND GridId=$GridId";
    $sqlresult = db::getInstanceMaster()->db_select($sql);
}else{
    if($isGrid == 0 ){
        $sql = "SELECT FieldOtherConditions FROM kmainfields where FormId=$FormId AND DbFieldName='$FieldName'";
        $sqlresult = db::getInstanceMaster()->db_select($sql);
    }else{
        // $FieldNames = explode('-',$FieldName);
        // print_r($FieldNames);
        $sql = "SELECT FieldOtherConditions FROM kgridfields where GridId=$GridId AND DbFieldName='$FieldName'";
        $sqlresult = db::getInstanceMaster()->db_select($sql);
    }
}

$sql1 = "SELECT * FROM kgridfields where GridId=$GridId ORDER BY DisplayOrder";
$sql1result = db::getInstanceMaster()->db_select($sql1);

$FieldOtherConditions = $sqlresult['result_set'][0]['FieldOtherConditions'];

$str1 = 'PopulateSpName';
$PopulateSpNamePos = -1;
if (strpos($FieldOtherConditions, $str1) !== false){
    $PopulateSpNamePos = strpos($FieldOtherConditions,$str1);
}

$str1 = 'PopulateDB';
$PopulateDBPos = -1;
if (strpos($FieldOtherConditions, $str1) !== false){
    $PopulateDBPos = strpos($FieldOtherConditions,$str1);
}

$str2 = 'gridResponse';
$gridResponsePos = -1;
if (strpos($FieldOtherConditions, $str2) !== false){
    $gridResponsePos = strpos($FieldOtherConditions,$str2);
}

if($PopulateSpNamePos != -1){
    $newArray = substr($FieldOtherConditions,$PopulateSpNamePos,$PopulateDBPos-$PopulateSpNamePos);
    $spParams = substr($newArray , strpos($newArray, '{')+1, strpos($newArray,'}') - 1);
    $spName = str_replace('}','',$spParams);
}

if($PopulateDB != -1){
    $newArray1 = substr($FieldOtherConditions,$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
    $DBParams = substr($newArray1 , strpos($newArray1, '{')+1, strpos($newArray1,'}') - 1);
    $PopulateDBName = str_replace('}','',$DBParams);
}

if(strlen($formReeponse) > 0){
    $formResponseA = [];
    $formResponseArray = [];
    $formResponseA = explode('|',$formReeponse);
    for($i=0; $i<sizeof($formResponseA); $i++){
        $formResponseParamsExplode = explode(":",$formResponseA[$i]);
        $sql2 = "SELECT FieldType FROM kgridfields where GridId=$GridId AND DbFieldName='".trim($formResponseParamsExplode[0])."'";
        
        $sqlresult2 = db::getInstanceMaster()->db_select($sql2);
        if($sqlresult2['num_rows'] > 0){
            $formResponseFields .= trim($formResponseParamsExplode[0]).":".trim($formResponseParamsExplode[1]).":".trim($sqlresult2['result_set'][0]['FieldType']);

            if($formResponseParamsExplode[2]){
                $formResponseFields .= ":".trim($formResponseParamsExplode[2]);
            }
            if($i != sizeof($formResponseA)-1){
                $formResponseFields .= " | ";
            }
        }
    }
    
    if(strlen($formResponseFields) > 0){
        $formResponseArray = explode('|',$formResponseFields);
    }
}

function array_change_key_case_recursive($array) {
    $result = [];
    foreach ($array as $key => $value) {
        $lowercaseKey = strtolower($key);
        if (is_array($value)) {
            $result[$lowercaseKey] = array_change_key_case_recursive($value); // Recursively change case for nested arrays
        } else {
            $result[$lowercaseKey] = $value;
        }
    }
    return $result;
}

// $data = file_get_contents('php://input');
// $dataArray = explode('&',$data);
if(strlen($PopulateDBName) > 1){
    $params = substr($PopulateDBName , strpos($PopulateDBName, '(')+1, strpos($PopulateDBName,')') - 1);
	$DBParams = str_replace(')','',$params);
    
    $DBName = explode('(',$PopulateDBName);
    if(count($DBName) > 1){
        $DBParameters = explode('=',$DBParams);
    }

    $query = "SELECT * FROM $DBName[0] WHERE 1=1";

    if(count($DBName)>1){
        $query .= " AND ".trim($DBParameters[1])." in(".$selectedRowId.")";
    }

    if(strlen($requestParams) > 1){
        $query .= " AND $requestParams";
    }
    // echo $query;
    $result = db::getInstance()->db_select($query);
    
    $row = Encoding::fixUTF8($result['result_set'],Encoding::ICONV_IGNORE);
    
    $array = array_change_key_case_recursive($sql1result['result_set']);
    $arr = array("data" => $row, "gridData" => $array, "selecedRowIdName" => trim($DBParameters[1]),"formResponseArray"=>$formResponseArray);
}

if(strlen($spName) > 1){
    $params = substr($spName , strpos($spName, '(')+1, strpos($spName,')') - 1);
	$DBParams = str_replace(')','',$params);
    
    $DBName = explode('(',$PopulateDBName);
    $DBParameters = explode('=',$DBParams);

    $data = getSPParams($spName);
    $sp = [];
    
    $sp['values'] = ["'$selectedRowId'"];
    $session .= 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND userid='.$_SESSION['user_id'].' ';

    array_push($data['params'],'@session');
    array_push($sp['values'],"'$session'");

    $result = db::getInstance()->db_sp_select($data['name'], $data['params'], $sp['values']);
    
    $row = $result['result_set'][0];
    $array = array_change_key_case_recursive($sql1result['result_set']);
    $arr = array("data" => $row, "gridData" => $array, "selecedRowIdName" => trim($DBParameters[1]),"formResponseArray"=>$formResponseArray);
    // if($FormId == 5098){
    //     print_r($arr);
    // }
}
echo json_encode($arr);

?>
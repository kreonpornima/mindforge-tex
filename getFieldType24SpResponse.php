
<?php
require_once ('dbClass.php');

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

$SpName = isset($_REQUEST['SpName']) ? $_REQUEST['SpName'] : '';
$requestParams = isset($_REQUEST['requestParams']) ? $_REQUEST['requestParams'] : '';
$PopulateField = isset($_REQUEST['PopulateField']) ? $_REQUEST['PopulateField'] : '';
$editid = isset($_REQUEST['editid']) ? $_REQUEST['editid'] : '';
$userid = isset($_REQUEST['userid']) ? $_REQUEST['userid'] : '';
$GridId = isset($_REQUEST['gridid']) ? $_REQUEST['gridid'] : '';
$FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : 0;
$FormData = isset($_POST['FormData']) ? $_POST['FormData'] : '';
$FType = isset($_POST['FType']) ? $_POST['FType'] : '';


if(strlen($requestParams) > 3){
    $requestParamsArray = [];
    $splitParams = [];
    $finalRequestParams = '';
    $requestParamsArray = explode("|",$requestParams);

    for($i=0; $i<sizeof($requestParamsArray); $i++){
        $splitParams = explode(":",$requestParamsArray[$i]);
        $dbField = trim($splitParams[0]);
        $sql2 = "SELECT FieldType FROM kgridfields WHERE GridId=$GridId AND DbFieldName='$dbField'";
        $sql2result = db::getInstanceMaster()->db_select($sql2);
        $finalRequestParams .= trim($splitParams[0]).":".trim($splitParams[1]).":".trim($sql2result['result_set'][0]['FieldType']);
        if($splitParams[2]){
            $finalRequestParams .= ":".trim($splitParams[2]);
        }
        if($i < count($requestParamsArray)-1){
            $finalRequestParams .= "|";
        }
    }

}

if(strlen($requestParams) > 3){
    $requestParams .= '|';
}
$requestParams .= 'YearCode:'.$_SESSION['dbYear'].'| DivisionId:'.$_SESSION['dbDivision'].'| CompanyId:'.$_SESSION['dbCompany'].'| FormID='.$FormID.'';





$set = [];
$val = [];
$row = $result['result_set'];
if($FType == 'GSTR1'){
    $session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND EditID=' . $editID;
    $sp['params'] = ['@form','@editid','@userid','@SESSION'];
    $sp['values'] = ["'".$requestParams."'",$editid,$userid,"'".$session."'"];
    $result = db::getInstance()->db_sp_select(trim($SpName), $sp['params'], $sp['values']);
    $checkSpResult = $result;
    $response = [];
    if($checkSpResult['error'] == '0') {
        if (isset($checkSpResult['result_set']) && count($checkSpResult['result_set']) > 0) {
            $resultSet = $checkSpResult['result_set'];
            // Extract the first array and remove it from the original array
            $sheetNameArray = array_shift($resultSet);
            $sheets = [];
            $filteredArray = array_filter($sheetNameArray, function($item) {
                return $item['cnt'] > 0;
            });
            $sheetNameArray = array_values($filteredArray);
            // echo '<pre>';
            // print_r($filteredArray);
            // print_r($resultSet);
            // print_r($sheetNameArray);
            // echo "<br />==>>" ;
            foreach ($resultSet as $index => $sheetData) {
                // echo "<br />==>>" ;
                // print_r($sheetData);
                $headers = array_keys($sheetData[0]);
                // echo "<br />>>" ;
                // print_r($headers);
                $data = [];

                foreach ($sheetData as $row) {
                    $data[] = $row;
                }

                $sheets[] = [
                    'sheetName' => $sheetNameArray[$index]['Name'],//'Sheet' . ($index + 1),
                    'headers' => $headers,
                    'data' => $data
                ];
            }
            $response = [
                'status' => 'true',
                'sheets' => $sheets
            ];
        } else {
            $response = ['status' => 'false', 'message' => 'No data found'];
        }
    } else {
        $response = ['response' => 'false', 'message' => 'Error while fetching data'];
    }
    echo json_encode($response);
}else{

    $sp['params'] = ['@form','@editid','@userid','@PopulateField'];
    $sp['values'] = ["'".$requestParams."'",$editid,$userid,"'".$PopulateField."'"];

    $result = db::getInstance()->db_sp_select(trim($SpName), $sp['params'], $sp['values']);

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

    if($_SESSION['user_id'] == 1020){
        // print_r($result['result_set']);exit();
        $tempData = [];
        $cursorPosition = '';
        $NonEditableFields = '';
        $success = '';
        $msg = '';
        $data = [];
        $gridData = [];
        $populateFields = [];

        if($GridId){
            $sql1 = "SELECT * FROM kgridfields where GridId=$GridId ORDER BY DisplayOrder";
            $sql1result = db::getInstanceMaster()->db_select($sql1);
            $gridData = array_change_key_case_recursive($sql1result['result_set']);
        }
        

        // Look for tempData in the result_set
        foreach ($result['result_set'] as $reskey => $resvalue) {
            
            if(is_array($resvalue)){
                foreach ($resvalue as $key => $value) {
                    
                    // Use strpos for compatibility
                    if (is_array($value)) {
                        $isSpecial = false;
                       
                        // If this inner array has a form_* key, extract it
                        foreach ($value as $innerKey => $innerVal) {
                            if (strpos($innerKey, 'success') === 0) {
                                $success = $innerVal;
                                $isSpecial = true;
                            }else if (strpos($innerKey, 'msg') === 0) {
                                $msg = $innerVal;
                                $isSpecial = true;
                            }else if (strpos($innerKey, 'form_') === 0) {
                                $tempData[] = [$innerKey => $innerVal];
                                $isSpecial = true;
                            }else if (strpos($innerKey, 'cursorPosition') === 0) {
                                if($innerVal){
                                    $sql3 = "SELECT FieldType FROM kmainfields WHERE FormId=$FormID AND DbFieldName='".$innerVal."'";
                                    $sql3result = db::getInstanceMaster()->db_select($sql3);

                                    $cursorPosition = $innerVal.":".$sql3result['result_set'][0]['FieldType'];
                                    $isSpecial = true;
                                    // $cursorPosition = [$innerKey => $innerVal];
                                }
                            }else if (is_string($innerKey) && strpos($innerKey, 'NonEditableFields') === 0) {
                                if($innerVal){
                                    $NonEditableFields = $innerVal;
                                    $isSpecial = true;
                                }
                            }else if(strpos($innerKey, 'PopulateFields') === 0){
                                if($innerVal){
                                    $populateFields[] = [$innerKey => $innerVal];
                                    $isSpecial = true;
                                }
                            }
                        }  

                        if (!$isSpecial) {
                            // case 1: if array has many fields like lumpno, designid → main data
                            if (count($value) > 1) {
                                $data[] = $value;
                            } 
                           
                        } 
                    }

                }
            }

           
        }

        $arr = array("status" => true, "msg" => $msg, "success" => $success, "data" => Encoding::fixUTF8($data, Encoding::ICONV_IGNORE),
         "gridData" => $gridData, "RequestParams" => $finalRequestParams, "PopulateFieldResponse" => $populateFields, 
         "cursorPosition" => $cursorPosition,"NonEditableFields" => $NonEditableFields, "tempData" => $tempData);
     
        echo json_encode($arr);
    }else{


        $sql1 = "SELECT * FROM kgridfields where GridId=$GridId ORDER BY DisplayOrder";
        $sql1result = db::getInstanceMaster()->db_select($sql1);
        // print_r($result);
        $msg = $result['result_set'][0][0]['msg'];
        $success = $result['result_set'][0][0]['success'];

        if($result['result_set'][3]){
            $sql3 = "SELECT FieldType FROM kmainfields WHERE FormId=$FormID AND DbFieldName='".$result['result_set'][3][0]['cursorPosition']."'";
            $sql3result = db::getInstanceMaster()->db_select($sql3);

            $cursorPosition = $result['result_set'][3][0]['cursorPosition'].":".$sql3result['result_set'][0]['FieldType'];
            // print_r($sql3result['result_set'][0]['FieldType']);
        }
        
        $array = array_change_key_case_recursive($sql1result['result_set']);
        
        // if($_SESSION['user_id'] == 1023){
        //     print_r($result['result_set'][1][[]]);
        // }
        // if($result['result_set'][0])
        // print_r($result);p
        if(!empty($result['result_set']) && is_array($result['result_set']) && count($result['result_set']) > 2){

            $arr = array("status" => true, "msg" => $msg, "success" => $success, "data" => Encoding::fixUTF8($result['result_set'][1], Encoding::ICONV_IGNORE), "gridData" => $array, "RequestParams" => $finalRequestParams, "PopulateFieldResponse" => $result['result_set'][2], "cursorPosition" => $cursorPosition,"NonEditableFields" => $result['result_set'][4], "tempData" => $result['result_set'][5]);
        }else{
            $arr = array("status" => true, "msg" => $msg, "success" => $success, "tempData" => $result['result_set'][1]);
        }
        echo json_encode($arr);
    }
    
}
?>
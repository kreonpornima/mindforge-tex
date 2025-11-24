<?php
require_once ('dbClass.php');
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
// include 'model.php';

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

// Retrieve the 'start' and 'limit' parameters from the request (for pagination)
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 30;
$isFilter = 0;
$formData = isset($_POST['formData']) ? $_POST['formData'] : '';
$ColumnFilters = isset($_POST['ColumnFilters']) ? $_POST['ColumnFilters'] : '';
$GlobalSearch = isset($_POST['GlobalSearch']) ? $_POST['GlobalSearch'] : '';
$DBFieldName = isset($_POST['DBFieldName']) ? $_POST['DBFieldName'] : '';
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : 0;
$formData = isset($_POST['formData']) ? $_POST['formData'] : '';
$bankRecoFlag = isset($_POST['bankRecoFlag']) ? $_POST['bankRecoFlag'] : '';


$data = explode("&",$formData);
$finalArray = array();
$finalCnt = 0;
$separator = "";
for($i=0; $i<count($data); $i++){
    if (strpos($data[$i], "csrftoken") === false){
        $finalArray[$finalCnt] .= $separator . $data[$i];
        $separator = "|";
    }
}

$FilterCondition = '';

if(strlen($ColumnFilters) > 3){
    $ColumnFiltersArray = explode("|",$ColumnFilters);
    for($i=0; $i<count($ColumnFiltersArray); $i++){
        $ColumnFilter = explode(":",$ColumnFiltersArray[$i]);
        $FilterCondition .= " AND ";
        $FilterCondition .= $ColumnFilter[0]." like '%".$ColumnFilter[1]."%'"; 
    }
}
$GlobalSearchCondition = '';
if(strlen($GlobalSearch) > 1){
    $GlobalSearchCondition .= '\'%'.$GlobalSearch.'%\' ';
}
// sp_GetData_3667_chalno
// sp_GetData_3667_4888_chalno
if($GridID == 0){
    // $data['name'] = "sp_GetData_".$FormID."_".$DBFieldName;
    $data['name'] = "sp_GetBankReconsilationDetails_".$FormID."_bankreco";
}else{
    $data['name'] = "sp_GetData_".$FormID."_".$GridID."_".$DBFieldName;
}
$session .= 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND userid='.$_SESSION['user_id'].' ';

// if($bankRecoFlag == 'uncleared' || $bankRecoFlag == 'cleared' || $bankRecoFlag == 'export'){
    $data['params'] = ['@isfilter','@filterconditions','@globalsearchcondition','@userid','@session','@form','@start','@limit','@formdata','@bankRecoFlag'];
    $sp['values'] = ["$isFilter","'".$FilterCondition."'","'".$GlobalSearchCondition."'","'".$_SESSION['user_id']."'","'$session'","'".urldecode($finalArray[0])."'",$start,$limit,"'".$formData."'","'".$bankRecoFlag."'"];
// }else{
    // $data['params'] = ['@isfilter','@filterconditions','@globalsearchcondition','@userid','@session','@form','@start','@limit','@formdata'];
    // $sp['values'] = ["$isFilter","'".$FilterCondition."'","'".$GlobalSearchCondition."'","'".$_SESSION['user_id']."'","'$session'","'".urldecode($finalArray[0])."'",$start,$limit,"'".$formData."'"];
// }

$result = db::getInstance()->db_sp_select($data['name'], $data['params'], $sp['values']);
// $arr = array("data" => $result['result_set'][0], "totalcolumnname" => $result['result_set'][1][0]['totalcolumnname'], "PopulateFields" => $result['result_set'][2][0]['PopulateField'], "PopulateFieldInGrid" => $result['result_set'][3][0]['PopulateFieldInGrid'], "PopulateGrid" => $result['result_set'][4][0]['PopulateGrid']); 
// print_r($result);
// exit();
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

$array = array_change_key_case_recursive($result['result_set']);
// print_r($array);


// print_r($result);
   
    if($bankRecoFlag == 'export'){

        if($result['error'] == '0') {
            if (isset($result['result_set']) && count($result['result_set']) > 0) {
                $resultSet = $result['result_set'];
                $sheetNameArray = array_shift($resultSet);
                $sheets = [];
                // echo '<pre>';
                // print_r($resultSet);
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
                    'response' => 'true',
                    'sheets' => $sheets
                ];
            } else {
                $response = ['response' => 'false', 'message' => 'No data found','success' => true];
            }
        } else {
            $response = ['response' => 'false', 'message' => 'Error while fetching data','success' => false];
        }
    }else{

        $response = [
            'success' => true,
            'data' => [],
            'adjamount' => '',
        ];
        
        if (!empty($array[0]) && !isset($array[0][0]['adjamount']) && is_array($array[0])) {
            $data = [];

            foreach ($array[0] as $k => $row) {
                $dataArray = [];
        
                foreach ($row as $key => $value) {
                    // Format date fields
                    if (in_array($key, ['entrydt', 'chequedt', 'cleardt']) && !empty($value)) {
                        
                        if ($value instanceof DateTime) {
                            $value = $value->format('Y-m-d');
                        } else {
                            $value = date('Y-m-d', strtotime($value));
                        }
                    }
        
                    // Handle special fields
                    if ($key === 'cleardt') {
                        if ($bankRecoFlag === 'uncleared') {
                            $dataArray[$key] = '<input type="date" style="float:left;width:80%;" class="form-control" oninput="handleBankRecoDateChange(this)" name="cleardt[]" id="cleardt" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/>';
                        } else {
                            // echo "<br>".$value;
                            $dataArray[$key] = '<input type="date" style="float:left;width:80%;" class="form-control" oninput="handleBankRecoDateChange(this)" name="cleardt[]" id="cleardt" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/><a style="padding:3px;" href="javascript:void(0)" class="btn btn-danger autofill" onclick="clearDate(this)"><span style="float:left;width:10%;" class="glyphicon glyphicon glyphicon-trash" aria-hidden="true" title="(Alt+K)"></span></a>';
                        }
                    } elseif ($key === 'entrydt') {
                        $dataArray[$key] = '<input type="date" readonly style="float:left;width:80%;" class="form-control" oninput="handleBankRecoDateChange(this)" name="entrydt" id="entrydt" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/>';
                    } elseif ($key === 'amount' || $key === 'amount') {
                        $value = ($value == '.00' || $value == '') ? '0.00' : number_format((float)$value, 2, '.', '');
                        $dataArray[$key] = '<input type="number" readonly class="form-control" name="'.$key.'" id="'.$key.'" value="'.$value.'" style=" width: auto;min-width: 50px;max-width: 120px;"/>';
                    } elseif ($key === 'sign') {
                        $dataArray[$key] = '<input type="text" readonly style="float:left;width:80%;" class="form-control" name="sign" id="sign" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/>';
                    }  else {
                        $dataArray[$key] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);
                    }
                }
        
                $data[] = $dataArray;
            }
        
            $response['data'] = $data;
            $response['success'] = true;
        }
        
        // Check and assign adjamount from $result['result_set'][1]
        // if (isset($array[1][0]['adjamount'])) {
        //     $response['adjamount'] = $array[1][0]['adjamount'];
        // }

        if (isset($array[1][0]['adjamount'])) {
            $response['adjamount'] = $array[1][0]['adjamount'];
        } elseif (isset($array[0][0]['adjamount'])) {
            $response['adjamount'] = $array[0][0]['adjamount'];
        }
        

        
    }

// Return the paged data as a JSON response
echo json_encode($response);

?>
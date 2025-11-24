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

if (strlen($ColumnFilters) > 3) {
    $ColumnFiltersArray = explode("|", $ColumnFilters);
    for ($i = 0; $i < count($ColumnFiltersArray); $i++) {
        $ColumnFilter = explode(":", $ColumnFiltersArray[$i]);
        $columnName = $ColumnFilter[0];
        $searchValue = $ColumnFilter[1];

        // ✅ Remove 'populate_search_' prefix if present
        if (strpos($columnName, 'populate_search_') === 0) {
            $columnName = substr($columnName, strlen('populate_search_'));
        }

        // ✅ Build condition safely
        $FilterCondition .= " AND $columnName LIKE '%" . addslashes($searchValue) . "%'";
    }
}
// if(strlen($ColumnFilters) > 3){
//     $ColumnFiltersArray = explode("|",$ColumnFilters);
//     for($i=0; $i<count($ColumnFiltersArray); $i++){
//         $ColumnFilter = explode(":",$ColumnFiltersArray[$i]);
//         $FilterCondition .= " AND ";
//         $FilterCondition .= $ColumnFilter[0]." like '%".$ColumnFilter[1]."%'"; 
//     }
// }
$GlobalSearchCondition = '';
if(strlen($GlobalSearch) > 1){
    $GlobalSearchCondition .= '\'%'.$GlobalSearch.'%\' ';
}
// sp_GetData_3667_chalno
// sp_GetData_3667_4888_chalno
if($GridID == 0){
    $data['name'] = "sp_GetData_".$FormID."_".$DBFieldName;
}else{
    $data['name'] = "sp_GetData_".$FormID."_".$GridID."_".$DBFieldName;
}
$session .= 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND userid='.$_SESSION['user_id'].' ';

// if($bankRecoFlag == 'uncleared' || $bankRecoFlag == 'cleared' || $bankRecoFlag == 'export'){
//     $data['params'] = ['@isfilter','@filterconditions','@globalsearchcondition','@userid','@session','@form','@start','@limit','@formdata','@bankRecoFlag'];
//     $sp['values'] = ["$isFilter","'".$FilterCondition."'","'".$GlobalSearchCondition."'","'".$_SESSION['user_id']."'","'$session'","'".urldecode($finalArray[0])."'",$start,$limit,"'".$formData."'","'".$bankRecoFlag."'"];
// }else{
    $data['params'] = ['@isfilter','@filterconditions','@globalsearchcondition','@userid','@session','@form','@start','@limit','@formdata'];
    $sp['values'] = ["$isFilter","'".$FilterCondition."'","'".$GlobalSearchCondition."'","'".$_SESSION['user_id']."'","'$session'","'".urldecode($finalArray[0])."'",$start,$limit,"'".$formData."'"];
// }

$result = db::getInstance()->db_sp_select($data['name'], $data['params'], $sp['values']);

// print_r($result);
// $arr = array("data" => $result['result_set'][0], "totalcolumnname" => $result['result_set'][1][0]['totalcolumnname'], "PopulateFields" => $result['result_set'][2][0]['PopulateField'], "PopulateFieldInGrid" => $result['result_set'][3][0]['PopulateFieldInGrid'], "PopulateGrid" => $result['result_set'][4][0]['PopulateGrid']); 

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

// $arr = array(
//     "data" => $array[0],

//     "totalcolumnname" => isset($array[1][0]['totalcolumnname'])
//         ? $array[1][0]['totalcolumnname'] 
//         : (isset($array[2][0]['populatefield']) 
//             ? $array[2][0]['populatefield'] 
//             : (isset($array[3][0]['populatefieldingrid']) 
//                 ? $array[3][0]['populatefieldingrid'] 
//                 : (isset($array[4][0]['hiddencolumns']) 
//                     ? $array[4][0]['hiddencolumns'] 
//                     : null))),

//     "PopulateFields" => isset($array[2][0]['populatefield'])
//         ? $array[2][0]['populatefield'] 
//         : (isset($array[3][0]['populatefieldingrid']) 
//             ? $array[3][0]['populatefieldingrid'] 
//             : (isset($array[4][0]['hiddencolumns']) 
//                 ? $array[4][0]['hiddencolumns'] 
//                 : (isset($array[1][0]['totalcolumnname']) 
//                     ? $array[1][0]['totalcolumnname'] 
//                     : null))),

//     "PopulateFieldInGrid" => isset($array[3][0]['populatefieldingrid']) 
//         ? $array[3][0]['populatefieldingrid'] 
//         : (isset($array[4][0]['hiddencolumns']) 
//             ? $array[4][0]['hiddencolumns'] 
//             : (isset($array[1][0]['totalcolumnname'])
//                 ? $array[1][0]['totalcolumnname'] 
//                 : (isset($array[2][0]['populatefield']) 
//                     ? $array[2][0]['populatefield'] 
//                     : null))),

//     "hiddenColumns" => isset($array[4][0]['hiddencolumns']) 
//         ? $array[4][0]['hiddencolumns'] 
//         : (isset($array[1][0]['populatefield']) 
//             ? $array[1][0]['populatefield'] 
//             : (isset($array[2][0]['totalcolumnname'])
//                 ? $array[2][0]['totalcolumnname'] 
//                 : (isset($array[3][0]['populatefield']) 
//                     ? $array[3][0]['populatefield'] 
//                     : null)))
// );



$arr = array(
    "data" => $array[0],

    "totalcolumnname" => isset($array[1][0]['totalcolumnname'])
        ? $array[1][0]['totalcolumnname'] 
        : (isset($array[2][0]['populatefield']) 
            ? $array[2][0]['populatefield'] 
            : (isset($array[3][0]['populatefieldingrid']) 
                ? $array[3][0]['populatefieldingrid'] 
                : (isset($array[4][0]['hiddencolumns']) 
                    ? $array[4][0]['hiddencolumns'] 
                    : (isset($array[5][0]['adjustableamount']) 
                        ? $array[5][0]['adjustableamount'] 
                        : null)))),

    "PopulateFields" => isset($array[2][0]['populatefield'])
        ? $array[2][0]['populatefield'] 
        : (isset($array[3][0]['populatefieldingrid']) 
            ? $array[3][0]['populatefieldingrid'] 
            : (isset($array[4][0]['hiddencolumns']) 
                ? $array[4][0]['hiddencolumns'] 
                : (isset($array[5][0]['adjustableamount']) 
                    ? $array[5][0]['adjustableamount'] 
                    : (isset($array[1][0]['totalcolumnname']) 
                        ? $array[1][0]['totalcolumnname'] 
                        : null)))),

    "PopulateFieldInGrid" => isset($array[3][0]['populatefieldingrid']) 
        ? $array[3][0]['populatefieldingrid'] 
        : (isset($array[4][0]['hiddencolumns']) 
            ? $array[4][0]['hiddencolumns'] 
            : (isset($array[5][0]['adjustableamount']) 
                ? $array[5][0]['adjustableamount'] 
                : (isset($array[1][0]['totalcolumnname'])
                    ? $array[1][0]['totalcolumnname'] 
                    : (isset($array[2][0]['populatefield']) 
                        ? $array[2][0]['populatefield'] 
                        : null)))),

    "hiddenColumns" => isset($array[4][0]['hiddencolumns']) 
        ? $array[4][0]['hiddencolumns'] 
        : (isset($array[5][0]['adjustableamount']) 
            ? $array[5][0]['adjustableamount'] 
            : (isset($array[1][0]['populatefield']) 
                ? $array[1][0]['populatefield'] 
                : (isset($array[2][0]['totalcolumnname'])
                    ? $array[2][0]['totalcolumnname'] 
                    : (isset($array[3][0]['populatefield']) 
                        ? $array[3][0]['populatefield'] 
                        : null)))),

    "AdjustableAmount" => isset($array[5][0]['adjustableamount']) 
        ? $array[5][0]['adjustableamount'] 
        : (isset($array[4][0]['hiddencolumns']) 
            ? $array[4][0]['hiddencolumns'] 
            : (isset($array[1][0]['populatefield']) 
                ? $array[1][0]['populatefield'] 
                : (isset($array[2][0]['totalcolumnname'])
                    ? $array[2][0]['totalcolumnname'] 
                    : (isset($array[3][0]['populatefield']) 
                        ? $array[3][0]['populatefield'] 
                        : null))))
                    
);



//code for add field type in PopulateFields & also check validation

// Split the string by the '|' operator
if($arr['PopulateFields'] != null){
    $parts = explode('|', $arr['PopulateFields']);

    // Iterate over each part
    foreach ($parts as &$part) {
        // Split by the first colon
        $subParts = explode(':', $part);

        $query = "SELECT FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".$subParts[0]."'";
        $queryresult = db::getInstanceMaster()->db_select($query);
        if ($queryresult['num_rows'] == 0) {
            // Return an error JSON response and exit
            echo json_encode(["success" => false, "error" => "".$subParts[0]." does not exist in form"]);
            exit(); // Terminate execution after sending the error response
        }
        // Take only the first two elements before the second colon
        $part = $subParts[0] . ':' . $subParts[1] . ':' .$queryresult['result_set'][0]['FieldType'];
    }
    // Join the parts back with '|' separator
    $NewPopulateFields = implode('|', $parts);

    // Update the 'PopulateFields' key in the $arr array
    $arr['PopulateFields'] = $NewPopulateFields;
}

if($arr['PopulateFieldInGrid'] != null){
    //code for add field type in PopulateFieldInGrid & also check validation
    // Split the string based on the delimiter " | "
    $splitString = explode(" | ", $arr['PopulateFieldInGrid']);


    // Loop through the array of strings
    foreach ($splitString as $PopulateFieldInGrids) {
        // Regular expression to split the string
        $regex = '/(\d+)\((.*)\)/';
    
        // Apply the regular expression to the string
        if (preg_match($regex, $PopulateFieldInGrids, $match)) {
            // Dynamically extracting the two parts
            $gridid = $match[1]; // This will be "2302"
            $PFields = $match[2]; // This will be "gfld1:bname:1|gfld7:cntl:7"
            
            $PopulateFieldInGridArray = explode("|", $PFields);
    
            // Iterate over each part
            for ($j=0; $j<count($PopulateFieldInGridArray); $j++) {
                // Split by the first colon
                $gridSubParts = explode(':', $PopulateFieldInGridArray[$j]);

                
                $query1 = "SELECT * from kmainfields where FormId=$FormID AND GridId=$gridid";
                $gridquery1result = db::getInstanceMaster()->db_select($query1);
                if ($gridquery1result['num_rows'] == 0) {
                    // Return an error JSON response and exit
                    echo json_encode(["success" => false, "error" => "".$gridid." grid does not exist in this form"]);
                    exit(); // Terminate execution after sending the error response
                }

                $query = "SELECT FieldType FROM kgridfields where GridId=$gridid AND DbFieldName='".$gridSubParts[0]."'";
                $gridqueryresult = db::getInstanceMaster()->db_select($query);
                if ($gridqueryresult['num_rows'] == 0) {
                    // Return an error JSON response and exit
                    echo json_encode(["success" => false, "error" => "".$gridSubParts[0]." does not exist in form"]);
                    exit(); // Terminate execution after sending the error response
                }
                // Store the grid part with FieldType added
                $gridParts[] = $gridSubParts[0] . ':' . $gridSubParts[1] . ':' .$gridqueryresult['result_set'][0]['FieldType'];
            }
        
            // Join the parts back with '|' separator
            $NewPopulateFieldInGrid = $gridid."(".implode('|', $gridParts).")";
        }
    }

    // Update the 'PopulateFieldInGrid' key in the $arr array
    $arr['PopulateFieldInGrid'] = $NewPopulateFieldInGrid;

}

if($arr['data'] != null){
    if(count($arr['data']) > 0){
        // print_r($arr['data']);
        $data = array();
        // Loop through each row of results
        foreach ($arr['data'] as $k => $row) {
            $dataArray = array();

            foreach ($row as $key => $value) {
                // Format date fields
                if (in_array($key, ['entrydt', 'chequedt', 'cleardt','entry_dt']) && !empty($value)) {
                    if ($value instanceof DateTime) {
                        $value = $value->format('Y-m-d');
                    } else {
                        $value = date('Y-m-d', strtotime($value));
                    }
                }

                // Handle specific fields
                if ($key == 'pending') {
                    $dataArray[$key] = '<input type="text" readonly class="form-control" name="pending" id="pending" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/>';
                } elseif ($key == 'adjamount') {
                    $dataArray[$key] = '<input type="number" style="float:left;width:80%;" class="form-control" onkeyup="getBillCalculation(this,\'keyup\',\'adjamount\')" name="adjamount" id="adjamount" min="0" max="'.$row['pending'].'" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/><a style="padding:3px;" href="javascript:void(0)" class="btn btn-success autofill" onclick="autoFill(this,\'adjamount\')"><span style="float:left;width:10%;" class="glyphicon glyphicon glyphicon-ok" aria-hidden="true" title="(Alt+K)"></span></a>'; //<a style="padding:3px;" href="javascript:void(0)" class="btn btn-success autofill" onclick="autoFill(this,\'adjamount\')"><span style="float:left;width:10%;" class="glyphicon glyphicon glyphicon-ok" aria-hidden="true" title="(Alt+K)"></span></a>
                } elseif ($key == 'balance') {
                    $dataArray[$key] = '<input type="number" class="form-control" name="balance" id="balance" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/>';
                } elseif($key == 'cleardt'){
                    $dataArray[$key] = '<input type="date" style="float:left;width:80%;" class="form-control" onchange="handleBankRecoDateChange(this)" name="cleardt" id="cleardt" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/>';
                }elseif($key == 'entrydt'){
                    $dataArray[$key] = '<input type="date" readonly style="float:left;width:80%;" class="form-control" onchange="handleBankRecoDateChange(this)" name="entrydt" id="entrydt" value="'.Encoding::fixUTF8($value, Encoding::ICONV_IGNORE).'"/>';
                } elseif ($key == 'dr_amount') {
                    $value = ($value == '.00' || $value == '') ? '0.00' : number_format((float)$value, 2, '.', '');
                    $dataArray[$key] = '<input type="number" readonly class="form-control" name="dr_amount" id="dr_amount" value="'.$value.'"/>';
                } elseif ($key == 'cr_amount') {
                    $value = ($value == '.00' || $value == '') ? '0.00' : number_format((float)$value, 2, '.', '');
                    $dataArray[$key] = '<input type="number" readonly class="form-control" name="cr_amount" id="cr_amount" value="'.$value.'"/>';
                }else {
                    // For other fields, just store the value
                    $dataArray[$key] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);
                } 
            }
            
            // Add the row as an associative array to $data
            $data[] = $dataArray;
        }

        // Update the 'data' key in the $arr array
        $arr['data'] = $data;
    }
}



$arr['success'] = true;
// Return the paged data as a JSON response
echo json_encode($arr);

?>
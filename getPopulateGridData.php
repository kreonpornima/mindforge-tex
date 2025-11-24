<?php

require_once ('dbClass.php');
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
$DBFieldName = isset($_POST['DBFieldName']) ? $_POST['DBFieldName'] : '';
$selectedItemsId = isset($_POST['selectedItems']) ? $_POST['selectedItems'] : '';
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 30;
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : 0;

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

if($GridID == 0){
    $SPName = 'sp_GetGridData_'.$FormID.'_'.$DBFieldName;
}else{
    $SPName = 'sp_GetGridData_'.$FormID.'_'.$GridID."_".$DBFieldName;
}
$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
$checkSp = db::getInstance()->db_select($sql);

if($checkSp['result_set'][0]['found'] == 1){
    
    $session .= 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND userid='.$_SESSION['user_id'].' ';
    $data['params'] = ['@selectedItemsId','@dbfieldname','@userid','@session','@start','@limit'];
    $sp['values'] = ["'$selectedItemsId'","'$DBFieldName'","'".$_SESSION['user_id']."'","'$session'",$start,$limit];

    $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);

    // print_r($result);

    // echo $result['result_set'][1][0]['gridResponse'];

    $firstRow   = $result['result_set'][0][0] ?? null;
    $firstKey   = is_array($firstRow) ? array_key_first($firstRow) : null;
    $arr = array("data" => $result['result_set'][0], "gridResponse" => $result['result_set'][1][0]['gridResponse'], "gridData" => $result['result_set'][2], "DynamicGridInsertFirstRowEdit" => $result['result_set'][3][0]['DynamicGridInsertFirstRowEdit'], "formResponse" => $result['result_set'][4][0]['formResponse'], "selecedRowIdName" => $firstKey); 
    
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
   
    $arr = array(
        "data" => $array[0], 
        "gridResponse" => $array[1][0]['gridresponse'],
        "gridData" => $array[2], 
        "DynamicGridInsertFirstRowEdit" => $array[3][0]['dynamicgridinsertfirstrowedit'], 
        "formResponse" => $array[4][0]['formresponse'], 
        "selecedRowIdName" => $firstKey
    ); 

    

    if($arr['gridResponse'] != null){
        // echo $arr['gridResponse'];
        // echo "<br>************************";
        // $splitString = explode("|", $arr['gridResponse']);
        // $splitString = preg_split('/(?<=\)) \| (?=\d+)/', $arr['gridResponse']);
        $splitString = preg_split('/(?<=\))\s*\|\s*(?=\d+)/', $arr['gridResponse']);

        $finalGridResponses = []; // To collect final grid strings
   
        // Loop through the array of strings
        foreach ($splitString as $gridResponse) {
            
            // Regular expression to split the string
            // $regex = '/(\d+)\((.*)\)/';

            $gridResponse = trim($gridResponse);  // remove leading/trailing spaces

            // $regex = '/(\d+)\((.*?)\)/';
            $regex = '/(\d+)\((.*?)\)/s';

            // Apply the regular expression to the string
            if (preg_match($regex, $gridResponse, $match)) {

               
                // Dynamically extracting the two parts
                $gridid = $match[1]; // This will be "2302"
                $PFields = $match[2]; // This will be "gfld1:bname:1|gfld7:cntl:7"
                
                $gridResponseArray = explode("|", $PFields);

                $gridParts = []; // 🔧 Reset this here so it doesn’t carry over to the next grid
               
                // Iterate over each part
                for ($j=0; $j<count($gridResponseArray); $j++) {
                    // Split by the first colon
                    $gridSubParts = explode(':', $gridResponseArray[$j]);

                    
                    $query1 = "SELECT * from kmainfields where FormId=$FormID AND GridId=$gridid";
                    $gridquery1result = db::getInstanceMaster()->db_select($query1);
                    if ($gridquery1result['num_rows'] == 0) {
                        // Return an error JSON response and exit
                        echo json_encode(["success" => false, "error" => "".$gridid." grid does not exist in this form"]);
                        exit(); // Terminate execution after sending the error response
                    }

                    $query = "SELECT FieldType FROM kgridfields where GridId=$gridid AND DbFieldName='".trim($gridSubParts[0])."'";
                    $gridqueryresult = db::getInstanceMaster()->db_select($query);
                    if ($gridqueryresult['num_rows'] == 0) {
                        // Return an error JSON response and exit
                        echo json_encode(["success" => false, "error" => "".$gridSubParts[0]." does not exist in form"]);
                        exit(); // Terminate execution after sending the error response
                    }
                    // Store the grid part with FieldType added
                    $gridParts[] = trim($gridSubParts[0]). ':' .trim($gridSubParts[1]). ':' .trim($gridqueryresult['result_set'][0]['FieldType']);
                }
            
                
                // Join the parts back with '|' separator
                $NewGridResponse = $gridid."(".implode('|', $gridParts).")";
                $finalGridResponses[] = $NewGridResponse;
                
            }
            // else {
            //     echo "❌ No match for: [$gridResponse]";
            // }
        }
        
        // Update the 'PopulateFieldInGrid' key in the $arr array
        // $arr['gridResponse'] = $NewGridResponse;

        // Join all grid blocks with " | " as in original
        $arr['gridResponse'] = implode(' | ', $finalGridResponses);        
    }

    // if($_SESSION['user_id'] == 1020){

    //     print_r($arr);
    // }

    // if($arr['formResponse'] != null){
    //     // Split the string based on the delimiter " | "
    //     $formResponseSplitString = explode(" | ", $arr['formResponse']);
    //     // Loop through the array of strings
    //     foreach ($formResponseSplitString as $formResponse) {
    //         // Regular expression to split the string
    //         $regex = '/(\d+)\((.*)\)/';
        
    //         // Apply the regular expression to the string
    //         if (preg_match($regex, $formResponse, $match)) {
    //             // Dynamically extracting the two parts
    //             $gridid = $match[1]; // This will be "2302"
    //             $FFields = $match[2]; // This will be "gfld1:bname:1|gfld7:cntl:7"
                
    //             $formResponseArray = explode("|", $FFields);
        
    //             // Iterate over each part
    //             for ($j=0; $j<count($formResponseArray); $j++) {
    //                 // Split by the first colon
    //                 $gridSubParts = explode(':', $formResponseArray[$j]);

                    
    //                 $query1 = "SELECT * from kmainfields where FormId=$FormID AND GridId=$gridid";
    //                 $gridquery1result = db::getInstanceMaster()->db_select($query1);
    //                 if ($gridquery1result['num_rows'] == 0) {
    //                     // Return an error JSON response and exit
    //                     echo json_encode(["success" => false, "error" => "".$gridid." grid does not exist in this form"]);
    //                     exit(); // Terminate execution after sending the error response
    //                 }

    //                 $query = "SELECT FieldType FROM kgridfields where GridId=$gridid AND DbFieldName='".$gridSubParts[0]."'";
    //                 $gridqueryresult = db::getInstanceMaster()->db_select($query);
    //                 if ($gridqueryresult['num_rows'] == 0) {
    //                     // Return an error JSON response and exit
    //                     echo json_encode(["success" => false, "error" => "".$gridSubParts[0]." does not exist in form"]);
    //                     exit(); // Terminate execution after sending the error response
    //                 }
    //                 // Store the grid part with FieldType added
    //                 $formResponseParts[] = $gridSubParts[0] . ':' . $gridSubParts[1] . ':' .$gridqueryresult['result_set'][0]['FieldType'];
    //             }
            
    //             // Join the parts back with '|' separator
    //             $NewFormResponse = implode('|', $formResponseParts);
    //         }
    //     }

    //     // Update the 'PopulateFieldInGrid' key in the $arr array
    //     $arr['formResponse'] = $NewFormResponse;
    // }

     

    // print_r($arr);
    // Return the paged data as a JSON response
    echo json_encode($arr);
}


?>
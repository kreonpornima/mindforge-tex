<?php
require_once ('dbClass.php');

$ValidationOn = isset($_POST['ValidationOn']) ? $_POST['ValidationOn'] : "";
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : 0;
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : 0;

$set = [];
$val = [];

if($FormID !=0 && $GridID !=0){
    $sql1 = "SELECT TableName FROM kmaingrid where GridId=$GridID";
    $sql1result = db::getInstanceMaster()->db_select($sql1);
    $tableName = $sql1result['result_set'][0]['TableName'];
}else if($FormID !=0 && $GridID ==0){
    $sql1 = "SELECT TableName FROM kmainforms where FormId=$FormID";
    $sql1result = db::getInstanceMaster()->db_select($sql1);
    $tableName = $sql1result['result_set'][0]['TableName'];
}


switch ($ValidationOn) {
    case "save":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $editID = isset($_POST['editID']) ? $_POST['editID'] : "";
        $data = explode("&",$FormData);
              
        $finalArray = array();
        $finalCnt = 0;
        $separator = "";
        for($i=0; $i<count($data); $i++){
            if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false 
                && strpos($data[$i], "kreon-grid-") === false && strpos($data[$i], "GridId") === false 
                && strpos($data[$i], "GridTempID") === false && strpos($data[$i], "GridEditID") === false  
                && strpos($data[$i], "csrftoken") === false){
                    $finalArray[$finalCnt] .= $separator . $data[$i];
                    $separator = "|";
            }
            // if (strrpos($data[$i], "cnt") !== false) {
            //     if (strrpos($data[$i + 1], "GridId") !== false) {
            //         $finalCnt++;
            //         $separator = "";
            //     }
            // }
        
            // if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false ){
            //     if (strpos($data[$i], "kreon-grid-") === false ){
                    
            //         $finalArray[$finalCnt] .= $separator . $data[$i];
            //         $separator = "|";
            //     }
            // }else{
            //     if (strpos($data[$i], "editID") !== false ){
            //         $finalArray[0] .= "|" . $data[$i];
            //     }
        
            // }
        }
        
        array_push($set,'@USERNAME');
        array_push($val, "'".$_SESSION['user_id']."'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set, '@editID');
        array_push($val, "'".$editID."'");
        array_push($set,'@FORM');
        array_push($val,"'".urldecode($finalArray[0])."'");

        // for($k=0; $k<count($finalArray); $k++){
        //     if($k==0){
        //         array_push($set,'@FORM');
        //         array_push($val,"'".urldecode($finalArray[$k])."'");
        //     }
            // else{
            //     array_push($set,"@GRID$k");
            //     array_push($val,"'".urldecode($finalArray[$k])."'");
            // }
        // }

        $SPName = "sp_ValidateSave_$FormID";

        break;

    case "edit":
        
        $EditID = isset($_POST['EditID']) ? $_POST['EditID'] : "";
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";

        $data = explode("&",$FormData);
        
        $finalArray = array();
        $formD = "";
        $gridData = "";

        // Find the position of `cnta` in the string
        $splitPosition = strpos($FormData, 'cnta');

        // Split the string into two parts
        if ($splitPosition !== false) {
            $formD = substr($FormData, 0, $splitPosition);  // First part before 'cnta'
            $gridData = substr($FormData, $splitPosition);     // Second part including 'cnta'
        } else {
            // If 'cnta' is not found, handle the case
            $formD = $FormData;
            $gridData = '';
        }

        // Replace all '&' with '|' in both parts
        $formD = str_replace('&', '|', $formD);
        $gridData = str_replace('&', '|', $gridData);

        // for($i=0; $i<count($data); $i++){
        //     if (strpos($data[$i], "cnt") === false && strpos($data[$i], "csrftoken") === false 
        //         && strpos($data[$i], "kreon-grid-") === false && strpos($data[$i], "GridId") === false 
        //         && strpos($data[$i], "GridTempID") === false && strpos($data[$i], "GridEditID") === false  
        //         && strpos($data[$i], "csrftoken") === false && strpos($data[$i], "kreonClickButton") === false){
        //             $finalArray[$finalCnt] .= $separator . $data[$i];
        //             $separator = "|";
        //     }else {
        //         // If it's remaining data, append it to remainingData
        //         if ($remainingData != "") {
        //             $remainingData .= "&" . $data[$i];
        //         } else {
        //             $remainingData = $data[$i]; // Initialize remainingData with first element
        //         }
        //     }
        // }

        array_push($set,'@EDITID');
        array_push($val, "'$EditID'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@USERID');
        array_push($val, "'".$_SESSION['user_id']."'");
        $finalArray[0] = $formD;
        $FormData = $gridData;

        $SPName = "sp_ValidateEdit_$FormID";

        break;

    case "delete":
    
        $DeleteID = isset($_POST['DeleteID']) ? $_POST['DeleteID'] : "";

        array_push($set,'@DELETEID');
        array_push($val, "'$DeleteID'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@USERID');
        array_push($val, "'".$_SESSION['user_id']."'");

        $query = "SELECT * FROM kmainforms WHERE FormId=$FormID";
		$queryresult = db::getInstanceMaster()->db_select($query);

        $SPName = "sp_ValidateDelete_$FormID";

        break;
        
    case "gridsave":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $GridRowTempId = isset($_POST['GridRowTempId']) ? $_POST['GridRowTempId'] : "";
        $formDataWithComma = isset($_POST['formDataWithComma']) ? $_POST['formDataWithComma'] : "";
        // echo $formDataWithComma;
        $mainFormData = isset($_POST['mainFormData']) ? $_POST['mainFormData'] : "";
        
        $data = explode("&",$mainFormData);
        
        $finalArray = array();
        $finalCnt = 0;
        $separator = "";
        for($i=0; $i<count($data); $i++){
            if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false 
                && strpos($data[$i], "kreon-grid-") === false && strpos($data[$i], "GridId") === false 
                && strpos($data[$i], "GridTempID") === false && strpos($data[$i], "GridEditID") === false  
                && strpos($data[$i], "csrftoken") === false){
                    $finalArray[$finalCnt] .= $separator . $data[$i];
                    $separator = "|";
            }
            // if (strrpos($data[$i], "cnt") !== false) {
            //     if (strrpos($data[$i + 1], "GridId") !== false) {
            //         $finalCnt++;
            //         $separator = "";
            //     }
            // }
        
            // if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false ){
            //         $finalArray[$finalCnt] .= $separator . $data[$i];
            //         $separator = "|";
            // }else{
            //     if (strpos($data[$i], "editID") !== false ){
            //         $finalArray[0] .= "|" . $data[$i];
            //     }
        
            // }
        }
        
        array_push($set,'@USERNAME');
        array_push($val, "'".$_SESSION['user_id']."'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@FORM');
        array_push($val,"'".urldecode($FormData)."'");
        array_push($set,'@GRIDROWTEMPID');
        array_push($val, "'".$GridRowTempId."'");
        array_push($set,'@FORMDATAWITHCOMMA');
        array_push($val, "'".$formDataWithComma."'");
        array_push($set,'@MAINFORM');
        array_push($val,"'".urldecode($finalArray[0])."'");

        // for($k=0; $k<count($finalArray); $k++){
        //     if($k==0){
        //         array_push($set,'@MAINFORM');
        //         array_push($val,"'".urldecode($finalArray[$k])."'");
        //     }
            // else{
            //     array_push($set,"@GRID$k");
            //     array_push($val,"'".urldecode($finalArray[$k])."'");
            // }
        // }

        $SPName = "sp_ValidateGridSave_$FormID"."_"."$GridID";

        break;

    case "gridedit":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $GridEditID = isset($_POST['GridEditID']) ? $_POST['GridEditID'] : "";
        $GridRowTempId = isset($_POST['GridRowTempId']) ? $_POST['GridRowTempId'] : "";
        $formDataWithComma = isset($_POST['formDataWithComma']) ? $_POST['formDataWithComma'] : "";

        // $data = explode("&",$FormData);
        
        // $finalArray = array();
        // $finalCnt = 0;
        // $separator = "";
        // for($i=0; $i<count($data); $i++){
        //     if (strrpos($data[$i], "cnt") !== false) {
        //         if (strrpos($data[$i + 1], "GridId") !== false) {
        //             $finalCnt++;
        //             $separator = "";
        //         }
        //     }
        
        //     if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false ){
        //             $finalArray[$finalCnt] .= $separator . $data[$i];
        //             $separator = "|";
        //     }else{
        //         if (strpos($data[$i], "editID") !== false ){
        //             $finalArray[0] .= "|" . $data[$i];
        //         }
        
        //     }
        // }
        
        array_push($set,'@USERNAME');
        array_push($val, "'".$_SESSION['user_id']."'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@GRIDEDITID');
        array_push($val, "'".$GridEditID."'");
        array_push($set,'@GRIDROWTEMPID');
        array_push($val, "'".$GridRowTempId."'");
        array_push($set,'@FORM');
        array_push($val,"'".urldecode($FormData)."'");
        array_push($set,'@FORMDATAWITHCOMMA');
        array_push($val, "'".$formDataWithComma."'");

        // for($k=0; $k<count($finalArray); $k++){
        //     if($k==0){
        //         array_push($set,'@FORM');
        //         array_push($val,"'$finalArray[$k]'");
        //     }else{
        //         array_push($set,"@GRID$k");
        //         array_push($val,"'$finalArray[$k]'");
        //     }
        // }

        $SPName = "sp_ValidateGridEdit_".$FormID."_".$GridID;

        break;

    case "gridupdate":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $GridEditID = isset($_POST['GridEditID']) ? $_POST['GridEditID'] : "";
        $GridRowTempId = isset($_POST['GridRowTempId']) ? $_POST['GridRowTempId'] : "";
        $formDataWithComma = isset($_POST['formDataWithComma']) ? $_POST['formDataWithComma'] : "";
        $mainFormData = isset($_POST['mainFormData']) ? $_POST['mainFormData'] : "";
        
        $data = explode("&",$mainFormData);
        
        $finalArray = array();
        $finalCnt = 0;
        $separator = "";
        for($i=0; $i<count($data); $i++){
            if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false 
                && strpos($data[$i], "kreon-grid-") === false && strpos($data[$i], "GridId") === false 
                && strpos($data[$i], "GridTempID") === false && strpos($data[$i], "GridEditID") === false  
                && strpos($data[$i], "csrftoken") === false){
                    $finalArray[$finalCnt] .= $separator . $data[$i];
                    $separator = "|";
            }
            // if (strrpos($data[$i], "cnt") !== false) {
            //     if (strrpos($data[$i + 1], "GridId") !== false) {
            //         $finalCnt++;
            //         $separator = "";
            //     }
            // }
        
            // if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false ){
            //         $finalArray[$finalCnt] .= $separator . $data[$i];
            //         $separator = "|";
            // }else{
            //     if (strpos($data[$i], "editID") !== false ){
            //         $finalArray[0] .= "|" . $data[$i];
            //     }
        
            // }
        }

        
        array_push($set,'@USERNAME');
        array_push($val, "'".$_SESSION['user_id']."'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@GRIDEDITID');
        array_push($val, "'".$GridEditID."'");
        array_push($set,'@GRIDROWTEMPID');
        array_push($val, "'".$GridRowTempId."'");
        array_push($set,'@FORM');
        array_push($val,"'".urldecode($FormData)."'");
        array_push($set,'@FORMDATAWITHCOMMA');
        array_push($val, "'".$formDataWithComma."'");
        array_push($set,'@MAINFORM');
        array_push($val,"'".urldecode($finalArray[0])."'");

        // for($k=0; $k<count($finalArray); $k++){
        //     if($k==0){
        //         array_push($set,'@MAINFORM');
        //         array_push($val,"'".urldecode($finalArray[$k])."'");
        //     }
            // else{
            //     array_push($set,"@GRID$k");
            //     array_push($val,"'".urldecode($finalArray[$k])."'");
            // }
        // }

        $SPName = "sp_ValidateGridUpdate_".$FormID."_".$GridID;

        break;

    case "griddelete":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $GridEditID = isset($_POST['GridEditID']) ? $_POST['GridEditID'] : "";
        $GridRowTempId = isset($_POST['GridRowTempId']) ? $_POST['GridRowTempId'] : "";

        array_push($set,'@USERNAME');
        array_push($val, "'".$_SESSION['user_id']."'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@GRIDEDITID');
        array_push($val, "'".$GridEditID."'");
        array_push($set,'@GRIDROWTEMPID');
        array_push($val, "'".$GridRowTempId."'");
        array_push($set,'@FORM');
        array_push($val,"'".urldecode($FormData)."'");

        $SPName = "sp_ValidateGridDelete_".$FormID."_".$GridID;

        break;
    
    case "lostfocus":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $FieldID = isset($_POST['FieldID']) ? $_POST['FieldID'] : "";
        $GridSerialNo = isset($_POST['gridSerialNo']) ? $_POST['gridSerialNo'] : "";
        $FieldValue = isset($_POST['fieldValue']) ? $_POST['fieldValue'] : "";
        $cuurrentRowData = isset($_POST['cuurrentRowData']) ? $_POST['cuurrentRowData'] : "";

        $data = explode("&",$FormData);
        
        $finalArray = array();
        $finalCnt = 0;
        $separator = "";
        for($i=0; $i<count($data); $i++){
            //strpos($data[$i], "editID") === false && 
            if (strpos($data[$i], "csrftoken") === false 
                && strpos($data[$i], "kreon-grid-") === false && strpos($data[$i], "GridId") === false 
                && strpos($data[$i], "GridTempID") === false && strpos($data[$i], "GridEditID") === false  
                && strpos($data[$i], "csrftoken") === false){
                    $finalArray[$finalCnt] .= $separator . $data[$i];
                    $separator = "|";
            }

            // if (strrpos($data[$i], "cnt") !== false) {
            //     if (strrpos($data[$i + 1], "GridId") !== false) {
            //         $finalCnt++;
            //         $separator = "";
            //     }
            // }
        
            // if (strpos($data[$i], "editID") === false && strpos($data[$i], "csrftoken") === false ){
            //     if (strpos($data[$i], "kreon-grid-") === false ){
                    
            //         $finalArray[$finalCnt] .= $separator . $data[$i];
            //         $separator = "|";
            //     }
            // }else{
            //     if (strpos($data[$i], "editID") !== false ){
            //         $finalArray[0] .= "|" . $data[$i];
            //     }
        
            // }
        }
        
        array_push($set,'@USERNAME');
        array_push($val, "'".$_SESSION['user_id']."'");
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        // array_push($set, '@GRIDID');
        // array_push($val, "'".$GridID."'");
        array_push($set, '@FIELDVALUE');
        array_push($val, "'".$FieldValue."'");
        array_push($set, '@FORM');
        array_push($val, "'".$cuurrentRowData."'");
        array_push($set,'@MAINFORM');
        array_push($val,"'".urldecode($finalArray[0])."'");
        $FormData = $cuurrentRowData;
        // for($k=0; $k<count($finalArray); $k++){
            // if($k==0){
            //     array_push($set,'@MAINFORM');
            //     array_push($val,"'".urldecode($finalArray[$k])."'");
            // }
            // else{
            //     array_push($set,"@GRID$k");
            //     array_push($val,"'".urldecode($finalArray[$k])."'");
            // }
        // }

        if($GridID == 0){
            $SPName = "sp_ValidateFocus_".$FormID."_".$FieldID;
        }else{
            $SPName = "sp_ValidateFocus_".$FormID."_".$GridID."_".$FieldID;
        }

        break;
        
    case "onchange":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $FieldID = isset($_POST['FieldID']) ? $_POST['FieldID'] : "";
        $data = explode("&",$FormData);
        
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
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@USERID');
        array_push($val, "'".$_SESSION['user_id']."'");

        for($k=0; $k<count($finalArray); $k++){
            if($k==0){
                array_push($set,'@FORM');
                array_push($val,"'".urldecode($finalArray[$k])."'");
            }else{
                array_push($set,"@GRID$k");
                array_push($val,"'".urldecode($finalArray[$k])."'");
            }
        }

        $SPName = "sp_ValidateOnChange_".$FormID."_".$FieldID;

        break;

    case "onclick":
        $FormData = isset($_POST['formData']) ? $_POST['formData'] : "";
        $FieldID = isset($_POST['FieldID']) ? $_POST['FieldID'] : "";
        $SelectedVALUE = isset($_POST['SelectedVALUE']) ? $_POST['SelectedVALUE'] : "";
        $SelectedLabel = isset($_POST['SelectedLabel']) ? $_POST['SelectedLabel'] : "";

        $data = explode("&",$FormData);
        
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
        array_push($set, '@TABLENAME');
        array_push($val, "'".$tableName."'");
        array_push($set,'@SELECTEDID');
        array_push($val, "'".$SelectedVALUE."'");
        array_push($set, '@SELECTEDLABEL');
        array_push($val, "'".$SelectedLabel."'");

        for($k=0; $k<count($finalArray); $k++){
            if($k==0){
                array_push($set,'@FORM');
                array_push($val,"'".urldecode($finalArray[$k])."'");
            }else{
                array_push($set,"@GRID$k");
                array_push($val,"'".urldecode($finalArray[$k])."'");
            }
        }

        $SPName = "sp_ValidateOnClick_".$FormID."_".$FieldID;

        break;
}

$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.'';
array_push($set,'@session');
array_push($val,"'$session'");

$sp['params'] = $set;
$sp['values'] = $val;



$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
$sqlresult = db::getInstance()->db_select($sql);

if($sqlresult['result_set'][0]['found'] == 0){
    if($ValidationOn == 'delete'){
        $query1 = "DELETE FROM " . $queryresult['result_set'][0]['TableName'] . " WHERE " . $queryresult['result_set'][0]['TablePrimaryKey']." = " . $DeleteID;
		$query1result = db::getInstance()->db_update($query1);
        $query2 = "SELECT GridId FROM kmainfields WHERE FieldType=14 AND FormID=$FormID";
        $query2result = db::getInstanceMaster()->db_select($query2);
        $gridResult = $query2result['result_set'];

        for($i=0; $i<sizeof($gridResult); $i++){
            $query3 = "SELECT TableName, TablePrimaryKey FROM kmaingrid WHERE GridId=".$gridResult[$i]['GridId'];
            $query3result = db::getInstanceMaster()->db_select($query3);

            $query4 = "DELETE FROM ".$query3result['result_set'][0]['TableName']." WHERE ".$query3result['result_set'][0]['TablePrimaryKey']."=".$DeleteID ;
            $query4result = db::getInstance()->db_update($query4);
        }
    }
    $arr = array("status" => false);
}else{
    // print_r($sp['params']);
    // print_r($sp['values']);
    $result = db::getInstance()->db_sp_select($SPName, $sp['params'], $sp['values']);
    // echo $SPName;
    
    
    if($result['error'] == 1){
        $arr = array("status" => true,"data" => array("Success" => 3, "Msg" => $result['error_statement']));
    }else{
        $row = $result['result_set'][0][0];
        // print_r($row);
        $row1 = array("Msg"=>$row['Msg'],"Success"=>$row['Success']);

        // Check if the 'GridResponse' field contains data longer than 5 characters
        if(strlen($row['GridResponse']) > 5){
            $row['GridResponse'] = trim($row['GridResponse']);
    
            $str1 = 'GridResponse';
            $GridResponsePos = -1;
            if (strpos($row['GridResponse'], $str1) !== false){
                $GridResponsePos = strpos($row['GridResponse'],$str1);
            }
    

            // If 'GridResponse' was found
            if($GridResponsePos != -1){
                $GridResponseParameters = substr($row['GridResponse'] , strpos($row['GridResponse'], '{')+1, strpos($row['GridResponse'],'}') - 1);
                $GridResponse = str_replace('}','',$GridResponseParameters);
              
    
                if(strlen($GridResponse) > 5){
                    $PopulateFields = explode("|",$GridResponse);
                    for($i=0; $i<sizeof($PopulateFields); $i++){
                        $PopulateFieldsArray = explode(":",$PopulateFields[$i]);
                      
                        if($GridID > 0){
                            $sql1 = "SELECT FieldType FROM kgridfields where GridId=$GridID AND DbFieldName='".trim($PopulateFieldsArray[0])."'";
                        }else{
                            $sql1 = "SELECT FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".trim($PopulateFieldsArray[0])."'";
                        }

                      
                        
                        $sql1result = db::getInstanceMaster()->db_select($sql1);
                        if($sql1result['num_rows'] > 0){
                            $PopulateFieldParams .= trim($PopulateFieldsArray[0]).":".trim($PopulateFieldsArray[1]).":".trim($sql1result['result_set'][0]['FieldType']);
            
                            if($PopulateFieldsArray[2]){
                                $PopulateFieldParams .= ":".trim($PopulateFieldsArray[2]);
                            }
            
                            if($i != sizeof($PopulateFields)-1){
                                $PopulateFieldParams .= " | ";
                            }
                        }
                    }
                    $row1['GridResponse'] = $PopulateFieldParams;
                    // $row1 = array("GridResponse" => $PopulateFieldParams,"Msg"=>$row['Msg'],"Success"=>$row['Success']);
                } 
            }
        }

        // Check if the 'NonEditableFields' field contains data
        if(strlen($row['NonEditableFields']) > 5){
            // if "NonEditableFields" then add in response
            if(strlen($row['NonEditableFields']) > 2){
                $row1['NonEditableFields'] = $row['NonEditableFields'];
            }
        }

        // Check if the 'NonEditableFields' field contains data
        if(strlen($row['EditableFields']) > 3){
            $row1['EditableFields'] = $row['EditableFields'];
        }

        // If neither 'GridResponse' nor 'NonEditableFields' exist, use the original row data
        if(!$row['GridResponse'] && !$row['NonEditableFields']){
            $row1 = $row;
        }

        $arr = array("status" => true,"data" => $row1);

        //Onlostfocus check if $result['result_set'][1] then add html data
        if($result['result_set'][1]){
            $arr['tempData']=array_change_key_case($result['result_set'][1],CASE_LOWER);
        }
    
        if(strpos($SPName, "sp_ValidateFocus_") === false){
            if($GridID == 0){
                $tempDataSpName = "sp_TempData_".$FormID."";
            }else{
                $tempDataSpName = "sp_TempData_".$FormID."_".$GridID;
            }
            $checkSp = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$tempDataSpName'";
            $checkSpResult = db::getInstance()->db_select($checkSp);

            if($checkSpResult['result_set'][0]['found'] == 1){
                $arr = array("status" => true,"data" => $row);

                $sp_temp['params'] = ['@USERNAME','@FORM','@GRID','@session'];
                $sp_temp['values'] = ["'".$_SESSION['user_id']."'","'".urldecode($finalArray[0])."'","'".urldecode($FormData)."'","'$session'"];

                $SpTempResult = db::getInstance()->db_sp_select($tempDataSpName, $sp_temp['params'], $sp_temp['values']);
                // print_r($SpTempResult);
                if($SpTempResult['result_set'][0]){
                    // print_r($SpTempResult['result_set'][0]);
                    $arr['tempData']=array_change_key_case($SpTempResult['result_set'][0],CASE_LOWER);
                }
            }
        }
    
        if($ValidationOn == "delete"){
            if($row['Success'] == 1){
                $query = "DELETE FROM " . $queryresult['result_set'][0]['TableName'] . " WHERE " . $queryresult['result_set'][0]['TablePrimaryKey']." = " . $DeleteID;
                $queryresult = db::getInstance()->db_update($query);
                $query2 = "SELECT GridId FROM kmainfields WHERE FieldType=14 AND FormID=$FormID";
                $query2result = db::getInstanceMaster()->db_select($query2);
                $gridResult = $query2result['result_set'];

                for($i=0; $i<sizeof($gridResult); $i++){
                    $query3 = "SELECT TableName, TablePrimaryKey FROM kmaingrid WHERE GridId=".$gridResult[$i]['GridId'];
                    $query3result = db::getInstanceMaster()->db_select($query3);

                    $query4 = "DELETE FROM ".$query3result['result_set'][0]['TableName']." WHERE ".$query3result['result_set'][0]['TablePrimaryKey']."=".$DeleteID ;
                    $query4result = db::getInstance()->db_update($query4);
                }
            }
        }
    }
}

echo json_encode($arr);

?>
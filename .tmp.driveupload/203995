<?php
include '../dbClass.php';
$ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
include '../reportModel.php';
// echo $db[1];
$ResultStruct = array();
$EditableStruct = array();
if(strlen($db[1]) > 2){
    $filterString = "";
    $separator = "|";
    foreach($_REQUEST as $name => $value) {
        if($name != "ReportID" && $name != "view" && $name != "formid" && $name != "Submit" ) {
            $filterString .= $name."=".$value.$separator;
        }
    }
    // echo "'".$filterString."'";
    $SPresult = db::getInstance()->db_sp_select($db[1], array('@params'), array("'".$filterString."'"));
    $ResultSet = $SPresult['result_set'][0];        //['result_set'][0] should have the data 
    $ResultStruct = $SPresult['result_set'][1];     //['result_set'][1] should have the structure
    $ResultCnt = isset($ResultSet) ? sizeof($ResultSet) : 0;
    // print_r($SPresult);
}else{
    $sql = "SELECT * FROM " . $db[0] . " WHERE 1=1 ";
    $requestArray = [];

    if(isset($filterCode)){
        for($i = 0; $i < sizeof($filterCode); $i++){
            if(isset($_REQUEST[$filterCode[$i][1]]) || isset($_REQUEST[$filterCode[$i][2]])){
                if(isset($_REQUEST[$filterCode[$i][1]])){
                    $requestArray[$filterCode[$i][1]] = $_REQUEST[$filterCode[$i][1]];
                }else{
                    $requestArray[$filterCode[$i][2]] = $_REQUEST[$filterCode[$i][2]];
                }
            }
        }
    }else{
        $filterCode  = array();
    }
    // print_r($requestArray);
    foreach($_REQUEST as $name => $value) {
        if($name != "ReportID" && $name != "view" && $name != "Submit") {
            // $requestArray[$name] = $value;
            if(isset($name)) {
                if(gettype($value) == "array") {
                    if(sizeof($value) > 0) {
                        $sql .= " AND $name IN ('" . implode("','", $value) . "' ) ";
                    }
                } else {
                    if(is_numeric($value)) {
                        $valueINT = (float) $value;
                        if($valueINT !== 0) {
                            $sql .= " AND $name = $valueINT ";
                        }
                    } else {
                        if(strlen($value) > 0) {
                            $sql .= " AND $name = '$value' ";
                        }
                    }
                }
            }
        }
    }
    
	$viewResult = db::getInstance()->db_select($sql);
    $ResultCnt = $viewResult['num_rows'];
    $ResultSet = $viewResult['result_set'];
    
    $sql = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='" . $db[0] . "'";
	$res = db::getInstance()->db_select($sql);
    $ResultStruct = $res['result_set'];
    
	// print_r($viewResult['result_set'][0]);
    // echo $ord = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));
	// echo json_encode($viewResult['result_set']);
    // exit();
}
$finalResult = array();
$jsonData = "[";
$separator = "";
include("../assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding
    // $str = "FÃÂ©dération Camerounaise—de—Football\n"; // Uses U+2014 which is invalid ISO8859-1 but exists in Win1252
    // $str = "60X60/165×x 104-132 (4/1 Satin)"; // Uses U+2014 which is invalid ISO8859-1 but exists in Win1252
    // echo Encoding::fixUTF8($str); // Will break U+2014
    // echo Encoding::fixUTF8($str, Encoding::ICONV_IGNORE); // Will preserve U+2014
    // echo Encoding::fixUTF8($str, Encoding::ICONV_TRANSLIT); // Will preserve U+2014
for($i = 0; $i < $ResultCnt; $i++){
    foreach($ResultSet[$i] as $key => $value){
        //echo $key . "-";
        if(is_numeric($value)) {
            $valueINT = (float) $value;
            $finalResult[$i][$key] = $valueINT;
        } else {
            if ($value instanceof DateTime){
                $finalResult[$i][$key] = ($value)->format('Y-m-d');
            }else{
                // $finalResult[$i][$key] = $value;
                // $finalResult[$i][$key] = unpack('N', mb_convert_encoding($value, 'UCS-4BE', 'UTF-8'));
                // $finalResult[$i][$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                // echo "<br />" . 
                $finalResult[$i][$key] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);//, Encoding::ICONV_TRANSLIT);
            }
        }
    }
    // if(sizeof($finalResult[$i]) > 0 )
    // 	if(strlen(json_encode($finalResult[$i])) > 0)
    // 		$jsonData .= $separator . json_encode($finalResult[$i]);
    // $separator = ","; 
}
// $jsonData .= "]";
// print_r($finalResult);

$sql = "select * from kReportGridEditableFields where FormID = " . $ReportID;
$editableResult = db::getInstanceMaster()->db_select($sql);
if($editableResult['num_rows'] == 0){
    $EditableStruct = array();
}else{
    for($i = 0; $i < $editableResult['num_rows']; $i++){
        $EditableStruct[$i] = array($editableResult['result_set'][$i]['DbFieldName'], $editableResult['result_set'][$i]['FieldType'],[],$editableResult['result_set'][$i]['UpdatePrimaryKey'],'');
        if($editableResult['result_set'][$i]['FieldType'] == 5){
            $s = "SELECT " . $editableResult['result_set'][$i]['TablePrimary'].",".$editableResult['result_set'][$i]['TableLabel']." as Label
                    FROM ". $editableResult['result_set'][$i]['TableFromDb']." ". $editableResult['result_set'][$i]['TableCondition'];
            $sr = db::getInstance()->db_select($s);
            $EditableStruct[$i][2] = $sr['result_set'];
            // $EditableStruct[$i][3] = $editableResult['result_set'][$i]['TablePrimary'];
            // $EditableStruct[$i][4] = $editableResult['result_set'][$i]['TableLabel'];
            $EditableStruct[$i][3] = $editableResult['result_set'][$i]['UpdatePrimaryKey']; //Column Reqd for update
            /*
            //Data to get for update query
            $updateQ = $editableResult['result_set'][$i]['UpdateQuery'];
            // Use preg_match_all to find all occurrences
            preg_match_all('/#(\S+)/', $updateQ, $matches);
            // Get the words without the '#' symbol
            $words = array_map(function($word) {
                return ltrim($word, '#');
            }, $matches[0]);
            $EditableStruct[$i][3] = $words;*/
        }
    }
    // $EditableStruct = $editableResult['result_set'];
}
// print_r($EditableStruct);
if($ResultStruct == null) $ResultStruct = array();
echo json_encode(array($finalResult, $ResultStruct, $EditableStruct));

exit();
?>
<?php
include 'dbClass.php';
// $ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
// $ReportID = isset($ReportID) ? (int)trim($ReportID) : (isset($_GET['ReportID']) ? (int)trim($_GET['ReportID']) : 0);
$ReportID = isset($ReportID) ? (int)trim($ReportID) : (isset($_GET['ReportID']) ? (int)trim($_GET['ReportID']) : 0);
include 'reportModel.php';
$UserID = $_SESSION['user_id'];



if((int)$ReportID > 5700){

    $db[1] = "sp_GridReport_" . $ReportID;
}else{

    $SPName = "sp_GridReport_" . $ReportID;
    $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO' AND routine_name = '$SPName'";
    $sqlresult = db::getInstance()->db_select($sql, "");
    if ($sqlresult['result_set'][0]['found'] == 0) {
        $db[1] = "sp_report_" . $ReportID;
    } else {
        $db[1] = "sp_GridReport_" . $ReportID;
    }
}


// echo $db[1];
// ini_set('memory_limit', '10240M');
$ResultStruct = array();
$EditableStruct = array();
$finalResult = array();
$finalKeys = array();
$filterString = "";
$separator = "|"; 

foreach($_REQUEST as $name => $value) {
    if($name != "ReportID" && $name != "view" && $name != "formid" && $name != "Submit" ) {
        // If it's a Username and value is a 10-digit mobile number
        if (strtolower($name) === 'username' && preg_match('/^\d{10}$/', $value)) {
            $value = 'u' . $value;
        }
        $filterString .= $name."=".$value.$separator;
    }
} 

if($viewReportServerSettings[0]){   //query to be done on client server

    //FOR LOGGING THE QUERY IN THE PROFILER
    $userCategory = isset ($_SESSION['Category']) ? $_SESSION['Category'] : 0;
    if($userCategory == 2){ //ONLY FOR DEVELOPERS
        $Username = $_SESSION['email'];
        $Filename = './logs/dev_'.$Username . '.proflog' ;
        if(file_exists($Filename)){ //ONLY IF PROFILER HAS STARTED
            if(strlen($db[1]) > 2){
                $sp = $db[1];
                $set = array('@params'); 
                $val = array("'".$filterString."'");
                $query = "EXEC " . trim($sp) . " ";
                if ((strlen($sp) > 0 && sizeof($set) > 0 && sizeof($set) == sizeof($val))) {
                    for ($i = 0; $i < sizeof($set); $i++) {
                        $tempVal = trim($val[$i]);
                        if($tempVal[0] == '\'' && $tempVal[strlen($tempVal) - 1 == '\'']){
                            $tempVal = substr($tempVal, 1, -1);
                            $tempVal = $tempVal;
                            $val[$i] = "'".$tempVal."'";
                        }
                        $query .= $set[$i] . "=" . $val[$i];
                        if ($i != sizeof($set) - 1) {
                            $query .= ",";
                        }
                    }
                }
                
                if (str_contains(strtolower($db[1]), "grid")) {
                    $table = '##u_gridreportdata_' . $UserID . '_' . $ReportID;
                    $query .= ", @table='" . $table . "'";
                }
            }else{
                /*
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
                */
            }        
            file_put_contents($Filename, PHP_EOL . "<br />-------------------------<br />" . PHP_EOL . "<<==FROM CLIENT SERVER ==>><br />" . $query, FILE_APPEND);
        }
    }
}else{

    if(strlen($db[1]) > 2){
        
        // echo "'".$filterString."'";
        if (str_contains(strtolower($db[1]), "grid")) {
           
            $table = '##u_gridreportdata_' . $UserID . '_' . $ReportID;
            //  echo "\nEXEC " . $db[1] . "'" . $filterString . "','" . $table . "'";
            $SPresult = db::getInstance()->db_sp_select($db[1], array('@params','@table'), array("'".$filterString."'","'".$table."'"));
            
            $sql = "select * from " . $table ;
            $result = db::getInstance()->db_select($sql);
            $ResultSet = $result['result_set'];
            // print_r($ResultSet);
            $sql = "SELECT c.name AS COLUMN_NAME,t.name AS DATA_TYPE, c.max_length AS CHARACTER_MAXIMUM_LENGTH FROM tempdb.sys.columns c
                    JOIN tempdb.sys.objects o ON c.object_id = o.object_id JOIN sys.types t ON c.user_type_id = t.user_type_id 
                    WHERE o.name LIKE '".$table."' AND o.type = 'U'";
            $result = db::getInstance()->db_select($sql);
            $ResultStruct = $result['result_set'];
            // print_r($ResultStruct);
        }else{

            $SPresult = db::getInstance()->db_sp_select($db[1], array('@params'), array("'".$filterString."'"));
            $ResultSet = $SPresult['result_set'][0];        //['result_set'][0] should have the data 
            $ResultStruct = $SPresult['result_set'][1];     //['result_set'][1] should have the structure
        }
        $ResultCnt = isset($ResultSet) ? sizeof($ResultSet) : 0;
        // if($ReportID == 3640) print_r($SPresult);
    }else{

        /*
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
        */
    }
    $structures = array();
    //GETTING DATATYPES IN AN ARRAY TO CHECK WHILE ENCODING
    if(is_array($ResultStruct)){
        for($i = 0; $i < sizeof($ResultStruct); $i++){
            $structures[$ResultStruct[$i]['COLUMN_NAME']] = $ResultStruct[$i]['DATA_TYPE'];
        }
    }
    // print_r($structures);
    $jsonData = "[";
    $separator = "";
    include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding
        // $str = "FÃÂ©dération Camerounaise—de—Football\n"; // Uses U+2014 which is invalid ISO8859-1 but exists in Win1252
        // $str = "60X60/165×x 104-132 (4/1 Satin)"; // Uses U+2014 which is invalid ISO8859-1 but exists in Win1252
        // echo Encoding::fixUTF8($str); // Will break U+2014
        // echo Encoding::fixUTF8($str, Encoding::ICONV_IGNORE); // Will preserve U+2014
        // echo Encoding::fixUTF8($str, Encoding::ICONV_TRANSLIT); // Will preserve U+2014
    for($i = 0; $i < $ResultCnt; $i++){
        $j = 0;
        foreach($ResultSet[$i] as $key => $value){
            // echo $key . "=>" . $value;
            // $newKey = $key;
            //EXTRACT KEYS 
            if($i == 0) $finalKeys[$j] = $key;
            $newKey = $j++;
            if($structures[$key] == 'int'){
                $valueINT = (int) $value;
                $finalResult[$i][$newKey] = $valueINT;
            } else if($structures[$key] == 'float'){
                $valueINT = (float) $value;
                $finalResult[$i][$newKey] = $valueINT;
            } else if($structures[$key] == 'datetime' || $structures[$key] == 'smalldatetime' || $structures[$key] == 'datetime2' || $structures[$key] == 'timestamp'){
                if($value == null || $value == "0000-00-00"){
                    $finalResult[$i][$newKey] = "";
                }else{
                    $finalResult[$i][$newKey] = ($value)->format('Y-m-d');
                }
            } else{
                $finalResult[$i][$newKey] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);//, Encoding::ICONV_TRANSLIT);
            }

            // if(is_numeric($value)) {
            //     $valueINT = (float) $value;
            //     $finalResult[$i][$key] = $valueINT;
            // } else {
            //     if ($value instanceof DateTime){
            //         $finalResult[$i][$key] = ($value)->format('Y-m-d');
            //     }else{
            //         // $finalResult[$i][$key] = $value;
            //         // $finalResult[$i][$key] = unpack('N', mb_convert_encoding($value, 'UCS-4BE', 'UTF-8'));
            //         // $finalResult[$i][$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            //         // echo "<br />" . 
            //         $finalResult[$i][$key] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);//, Encoding::ICONV_TRANSLIT);
            //     }
            // }
        }
        // if(sizeof($finalResult[$i]) > 0 )
        // 	if(strlen(json_encode($finalResult[$i])) > 0)
        // 		$jsonData .= $separator . json_encode($finalResult[$i]);
        // $separator = ","; 
    }
    // $jsonData .= "]";
    // print_r($finalResult);
}
$sql = "select * from kReportGridEditableFields where FormID = " . $ReportID;
$editableResult = db::getInstanceMaster()->db_select($sql);
if($editableResult['num_rows'] == 0){
    // $EditableStruct = array();
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

$sql = "select DbFieldName from kReportGridDrillReports where FormID = " . $ReportID;
$DrillResult = db::getInstanceMaster()->db_select($sql);
$DrillStruct = array();
if($DrillResult['num_rows'] == 0){
    
}else{
    for($i = 0; $i < $DrillResult['num_rows']; $i++){
        $DrillStruct[$i] = $DrillResult['result_set'][$i]['DbFieldName'];
    }
}

// print_r($DrillStruct);
if($ResultStruct == null) $ResultStruct = array();

if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}
header('Content-Encoding: gzip');
header('Content-Type: application/json');
echo json_encode(array($finalResult, $ResultStruct, $EditableStruct, $DrillStruct, $finalKeys, $viewReportServerSettings));
ob_end_flush();

exit();
?>
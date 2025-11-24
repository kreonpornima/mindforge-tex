<?php
include '../dbClass.php';
// print_r($_REQUEST[]);
$data = isset($_REQUEST['data']) ? $_REQUEST['data'] : [];
$ReportID = isset($_REQUEST['ReportID']) ? $_REQUEST['ReportID'] : 0;

$db[0] = "mst_quality_3106_vw";


$sql = "SELECT * FROM " . $db[0] . " WHERE 1=1 AND Product_Group like '" . $data['Product_Group'] . "' Order By QualityName Desc";
$requestArray = [];
/*
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
}*/
// echo $sql;
$viewResult = db::getInstance()->db_select($sql);
$ResultCnt = $viewResult['num_rows'];
$ResultSet = $viewResult['result_set'];


$finalResult = array();
$jsonData = "[";
$separator = "";
include("../assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding
for($i = 0; $i < $ResultCnt; $i++){
    foreach($ResultSet[$i] as $key => $value){
        if(is_numeric($value)) {
            $valueINT = (float) $value;
            $finalResult[$i][$key] = $valueINT;
        } else {
            if ($value instanceof DateTime){
                $finalResult[$i][$key] = ($value)->format('Y-m-d');
            } else {
                $finalResult[$i][$key] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);//, Encoding::ICONV_TRANSLIT);
            }
        }
    }
}

$sql = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='" . $db[0] . "'";
$res = db::getInstance()->db_select($sql);
$ResultStruct = $res['result_set'];




// echo json_encode(array($finalResult, $ResultStruct));
echo json_encode($finalResult);

exit();


$url = 'https://www.ag-grid.com/example-assets/master-detail-data.json';
// Fetch the JSON data from the URL
$jsonData = file_get_contents($url);
$data = json_decode($jsonData, true);
// print_r($data);
// Initialize the structure array
$structuredData = [];
// Infer structure based on the first record
if (!empty($data)) {
    foreach ($data[0] as $key => $value) {
        // Determine data type
        $dataType = is_int($value) ? "int" : (is_string($value) ? "string" : gettype($value));
        // Append structure information
        $structuredData[] = array("COLUMN_NAME" => $key, "DATA_TYPE" => $dataType);
    }
}
// Output the structure array for verification
// print_r($structuredData);
$finalResult = array($data, $structuredData);
// Print the final result as JSON
echo json_encode($finalResult);

?>

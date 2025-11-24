<?php
// include 'dbClass.php';
// $ReportID = isset($ReportID) ? $ReportID : 0;//(isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
// include 'reportModel.php';
// // echo $db[1];
// $ResultStruct = array();
// if(strlen($db[1]) > 2){
//     $filterString = "";
//     $separator = "|";
//     foreach($_REQUEST as $name => $value) {
//         if($name != "ReportID" && $name != "view" && $name != "formid" && $name != "Submit" ) {
//             $filterString .= $name."=".$value.$separator;
//         }
//     }
//     // echo "'".$filterString."'";
//     $SPresult = db::getInstance()->db_sp_select($db[1], array('@params'), array("'".$filterString."'"));
//     $ResultSet = $SPresult['result_set'][0];        //['result_set'][0] should have the data 
//     $ResultStruct = $SPresult['result_set'][1];     //['result_set'][1] should have the structure
//     $ResultCnt = isset($ResultSet) ? sizeof($ResultSet) : 0;
//     // print_r($SPresult);
// }else{
//   $sql = "SELECT * FROM " . $db[0] . " WHERE 1=1 ";
//   $requestArray = [];

//     if(isset($filterCode)){
//     for($i = 0; $i < sizeof($filterCode); $i++){
//         if(isset($_REQUEST[$filterCode[$i][1]]) || isset($_REQUEST[$filterCode[$i][2]])){
//             if(isset($_REQUEST[$filterCode[$i][1]])){
//                 $requestArray[$filterCode[$i][1]] = $_REQUEST[$filterCode[$i][1]];
//             }else{
//                 $requestArray[$filterCode[$i][2]] = $_REQUEST[$filterCode[$i][2]];
//             }
//         }
//     }
//     }else{
//         $filterCode  = array();
//     }
//     // print_r($requestArray);
//     foreach($_REQUEST as $name => $value) {
//         if($name != "ReportID" && $name != "view" && $name != "Submit") {
//             // $requestArray[$name] = $value;
//             if(isset($name)) {
//                 if(gettype($value) == "array") {
//                     if(sizeof($value) > 0) {
//                         $sql .= " AND $name IN ('" . implode("','", $value) . "' ) ";
//                     }
//                 } else {
//                     if(is_numeric($value)) {
//                         $valueINT = (float) $value;
//                         if($valueINT !== 0) {
//                             $sql .= " AND $name = $valueINT ";
//                         }
//                     } else {
//                         if(strlen($value) > 0) {
//                             $sql .= " AND $name = '$value' ";
//                         }
//                     }
//                 }
//             }
//         }
//     }

// 	// $viewResult = db::getInstance()->db_select($sql);
//     $ResultCnt = $viewResult['num_rows'];
//     $ResultSet = $viewResult['result_set'];
    
//     $sql = "select A.COLUMN_NAME, A.DATA_TYPE, A.CHARACTER_MAXIMUM_LENGTH  from INFORMATION_SCHEMA.columns A where table_name='" . $db[0] . "'";
// 	// $res = db::getInstance()->db_select($sql);
//     $ResultStruct = $res['result_set'];
    
// 	// print_r($viewResult['result_set'][0]);
//     // echo $ord = unpack('N', mb_convert_encoding($string, 'UCS-4BE', 'UTF-8'));
// 	// echo json_encode($viewResult['result_set']);
//     // exit();
// }
// $finalResult = array();
// $jsonData = "[";
// $separator = "";
// include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

// for($i = 0; $i < $ResultCnt; $i++){
//     foreach($ResultSet[$i] as $key => $value){
//         //echo $key . "-";
//         if(is_numeric($value)) {
//             $valueINT = (float) $value;
//             $finalResult[$i][$key] = $valueINT;
//         } else {
//             if ($value instanceof DateTime){
//                 $finalResult[$i][$key] = ($value)->format('Y-m-d');
//             }else{
//                 $finalResult[$i][$key] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);
//             }
//         }
//     }
// }

// Hardcoded JSON structure
// Database configuration
$host = 'localhost';      // Change if necessary
$dbname = 'my_database';  // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch data from users table
    $stmt = $pdo->query("SELECT ID, Name, Age, Gender,Address,City,Country FROM users");

    // Fetch all data and store it in the hardcodedJson variable
    $hardcodedJson = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Define the structure
    $hardcodedStructure = array(
        array("COLUMN_NAME" => "ID", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "Name", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "Gender", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "Age", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "Address", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "City", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "Country", "DATA_TYPE" => "string")
    );

    // Merge hardcodedJson with hardcodedStructure
    $finalResult = array($hardcodedJson, $hardcodedStructure);

    // Print the final result as JSON
    echo json_encode($finalResult);

} catch (PDOException $e) {
    // Handle error
    echo "Connection failed: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>

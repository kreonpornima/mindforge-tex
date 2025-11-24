<?php
// Database configuration
$host = 'localhost';      // Change if necessary
$dbname = 'my_database';  // Your database name
$username = 'root';       // Your database username
$password = '';           // Your database password
$FormID = isset($_GET['FormID']) ? $_GET['FormID'] : 0;

if($FormID > 0){
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM kmainforms where FormId = $FormID");
    $FormArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $TableName = $FormArray[0]['TableName']; 
    $TablePrimaryKey = $FormArray[0]['TablePrimaryKey']; 
    
    $stmt = $pdo->query("SELECT DbFieldName, FieldType, DisplayName, Required FROM kmainfields where FormId = $FormID order by DisplayOrder");
    $FieldsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $concatenatedFields = "";
    $separator = "";
    for($i = 0; $i<sizeof($FieldsArray) ; $i++){
        $concatenatedFields .= $separator . $FieldsArray[$i]['DbFieldName'];
        $separator = ",";
    }
    //echo "SELECT " . $concatenatedFields . " FROM " . $TableName . " ORDER BY " . $TablePrimaryKey . " DESC";
    $stmt = $pdo->query("SELECT ".$concatenatedFields.",".$TablePrimaryKey." FROM ".$TableName." order by ".$TablePrimaryKey." DESC");
    $TableData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $hardcodedJson = $TableData;
    //print_r($TableData);
    
    $query = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$TableName."' AND COLUMN_NAME IN ('".str_replace(",", "','", $concatenatedFields)."')";
    $stmt = $pdo->query($query);
    $TableStruct = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $hardcodedStructure = $TableStruct;
    $finalResult = array($hardcodedJson, $hardcodedStructure);
    echo json_encode($finalResult);

}

// Close the connection
$pdo = null;
exit;
?>
<?php 
// require_once ('../dbClass.php');
// echo $FormID = isset($_GET['FormID']) ? $_GET['FormID'] : 0;
// echo $Field = $_GET['Field'] ;
// // print_r($_REQUEST);
// $output = array();
// $query = "SELECT TableFromDb,TablePrimary,TableLabel from kmainfields WHERE FormID = " . $FormID . " AND DbFieldName = '" . $Field . "'";
// // select TableFromDb,TablePrimary,TableLabel from kmainfields where FormId = 4886 AND DbFieldName = 'Category'
// $result = db::getInstanceMaster()->db_select($query);
// $row = $result['result_set'][0];
// $sql ="SELECT " . $row['TablePrimary']." as ID, " . $row['TableLabel'] . " as Label FROM " . $row['TableFromDb'] ;
// $result = db::getInstance()->db_select($sql);
// echo json_encode(array($result['result_set'],$row['TablePrimary'],$row['TableLabel']));
// exit();

require_once ('dbClass.php');

header('Content-Type: application/json'); // Ensure JSON response

$FormID = isset($_GET['FormID']) ? (int)$_GET['FormID'] : 0;
$Field = isset($_GET['Field']) ? $_GET['Field'] : "";
$json_str = isset($_GET['OtherFields']) ? $_GET['OtherFields'] : "";
$OtherFieldsArray = json_decode($json_str, true);
// print_r($OtherFieldsArray);
// echo $array['partyid'];
// Validate input
if ($FormID <= 0 || empty($Field)) {
    echo json_encode(["error" => "Invalid FormID or Field"]);
    exit();
}

// Fetch TableFromDb, TablePrimary, TableLabel
$query = "SELECT TableFromDb, TablePrimary, TableLabel, TableCondition, FieldOtherConditions FROM kmainfields WHERE FormID = $FormID AND DbFieldName = '$Field'";
$result = db::getInstanceMaster()->db_select($query);

// Check if data exists
if (!$result || empty($result['result_set'])) {
    echo json_encode(["error" => "No data found"]);
    exit();
}

$row = $result['result_set'][0];

$tmp = $row['FieldOtherConditions'];
if (strpos($tmp, "parameters") !== false) {
    // Extract content between { and }
    preg_match('/\{(.*?)\}/', $tmp, $matches);
    $betweenCurlyBraces = $matches[1] ?? '';

    // Extract content between # and }
    preg_match('/#(.*?)\}/', $tmp, $matches);
    $betweenHashAndCurly = $matches[1] ?? '';
    
    $row['TableCondition'] = str_replace("#" . $betweenHashAndCurly, $OtherFieldsArray[$betweenHashAndCurly . "_ddID"], $betweenCurlyBraces);
    // echo "Between {}: " . $betweenCurlyBraces . "\n";
    // echo "Between # and }: " . $betweenHashAndCurly . "\n";
}
// print_r($row);
// $sql = "SELECT " . $row['TablePrimary'] . " AS ID, " . $row['TableLabel'] . " AS Label FROM " . $row['TableFromDb'];
$sql = "SELECT " . $row['TablePrimary'] . " AS ID, " . $row['TableLabel'] . " AS Label 
        FROM " . $row['TableFromDb'] . " 
        " . $row['TableCondition'] . " 
        ORDER BY " . $row['TablePrimary'] . " ASC";


$result = db::getInstance()->db_select($sql);

// Return JSON response
echo json_encode([
    "data" => $result['result_set'] ?? [],
    "TablePrimary" => 'ID',//$row['TablePrimary'],
    "TableLabel" => 'Label' //$row['TableLabel']
]);

exit();


 ?>


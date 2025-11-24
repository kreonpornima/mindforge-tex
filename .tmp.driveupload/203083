<?php
require_once ('dbClass.php');
$procedureName = isset($_POST['procedureName']) ? $_POST['procedureName'] : '';


// include 'model.php';
include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

$query = "SELECT sm.definition
        FROM sys.sql_modules sm
        JOIN sys.objects o ON sm.object_id = o.object_id
        WHERE o.type = 'P' AND o.name = '$procedureName'";
// echo $query;

$result = db::getInstance()->db_select($query);

foreach ($result['result_set'] as &$row) {
    // Ensure definition is valid UTF-8
    $row['definition'] = Encoding::toUTF8($row['definition']);
    $row['definition'] = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $row['definition']);
}

$arr = [
    "success" => true,
    "data" => $result['result_set']
];

// Return the paged data as a JSON response
echo json_encode($arr);

?>
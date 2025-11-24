<?php
// Set content type to JSON
header('Content-Type: application/json');
// include "reportGetDAtaFromView2.php";
return $_REQUEST;
// Get the input ID from the query string or POST data
// $id = isset($_GET['params']) ? $_GET['params'] : null;
$params = isset($_GET['params']) ? $_GET['params']:null;
return $params;
// echo $id;
// Check if ID is provided
if ($id === null) {
    echo json_encode(["error" => "No ID provided"]);
    exit();
}

// Define an array of responses based on ID
switch ($id) {
    case 1:
        $response = [
            "id" => 1,
            "name" => "Item One",
            "description" => "This is the first item"
        ];
        break;
    case 2:
        $response = [
            "id" => 2,
            "name" => "Item Two",
            "description" => "This is the second item"
        ];
        break;
    case 3:
        $response = [
            "id" => 3,
            "name" => "Item Three",
            "description" => "This is the third item"
        ];
        break;
    default:
        $response = [
            "error" => "No data found for the given ID"
        ];
        break;
}

// Output the response as JSON
echo json_encode($response);
?>
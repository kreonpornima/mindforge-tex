<?php
header('Content-Type: application/json');
$url = 'https://www.ag-grid.com/example-assets/olympic-winners.json';

// Fetch the JSON data from the URL
$jsonData = file_get_contents($url);

$data = json_decode($jsonData, true);

print_r($data);

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

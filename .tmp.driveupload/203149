<?php 

require_once ('dbClass.php');
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : '';
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '';
$UserID = isset($_POST['UserID']) ? $_POST['UserID'] : '';
$editID = isset($_POST['editID']) ? $_POST['editID'] : '';

$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND EditID=' . $editID;

$sp['params'] = ['@SESSION','@USERNAME'];
$sp['values'] = ["'$session'","'".$_SESSION['user_id']."'"];

$tempDataSpName = "sp_ImportGridExcelExport_".$GridID.""; 
$checkSpResult = db::getInstance()->db_sp_select($tempDataSpName, $sp['params'], $sp['values']);
// print_r($checkSpResult);
$response = [];

if($checkSpResult['error'] == '0') {
    // Check if the result set exists and is not empty
    if (isset($checkSpResult['result_set']) && count($checkSpResult['result_set']) > 0) {
        $resultSet = $checkSpResult['result_set']; // Assuming this is an array of rows
        // echo sizeof($resultSet);
        if(sizeof($resultSet) > 1){
            $sheetNameArray = array_shift($resultSet);
            $sheets = [];
            // echo '<pre>';
            // print_r($resultSet);
            // echo "<br />==>>" ;
            foreach ($resultSet as $index => $sheetData) {
                // echo "<br />==>>" ;
                // print_r($sheetData);
                $headers = array_keys($sheetData[0]);
                // echo "<br />>>" ;
                // print_r($headers);
                $data = [];

                foreach ($sheetData as $row) {
                    $data[] = $row;
                }

                $sheets[] = [
                    'sheetName' => $sheetNameArray[$index]['Name'],//'Sheet' . ($index + 1),
                    'headers' => $headers,
                    'data' => $data
                ];
            }
            $response = [
                'response' => 'true',
                'sheets' => $sheets
            ];
        }else{
            $headerArray = $resultSet[0][0];
            $headers = array_keys($headerArray);
            // print_r($headers);
            // Prepare the response with the headers and data
            // $headers = array_keys($resultSet[0]);
            // print($headers);
            $data = [];
    
            // Extract the data rows
            foreach ($resultSet[0] as $row) {
                $data[] = $row;
            }
    
            $response = [
                'response' => 'true',
                'headers' => $headers,
                'data' => $data
            ];
        }
    } else {
        $response = ['response' => 'false', 'message' => 'No data found'];
    }
} else {
    $response = ['response' => 'false', 'message' => 'Error while fetching data'];
}

// Return the data as a JSON response
echo json_encode($response);



// require_once ('dbClass.php');
// $GridID = isset($_POST['GridID']) ? $_POST['GridID'] : '';
// $FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '';
// $UserID = isset($_POST['UserID']) ? $_POST['UserID'] : '';
// $sp['params'] = [];
// $sp['values'] = [];

// $tempDataSpName = "sp_ImportGridExcelExport_".$GridID."";
// $checkSpResult = db::getInstance()->db_sp_select($tempDataSpName, $sp['params'], $sp['values']);

// if($checkSpResult['error'] == '0'){

//     // Check if the result set exists and is not empty
//     if (isset($checkSpResult['result_set']) && count($checkSpResult['result_set']) > 0) {
//         $resultSet = $checkSpResult['result_set']; // Assuming this is an array of rows

//         // Display the headers if available
//         if (isset($resultSet[0]) && is_array($resultSet[0])) {
//             // Assuming first row contains column names
//             $headers = array_keys($resultSet[0]);

//             echo "<table border='1'><thead><tr>";
//             foreach ($headers as $header) {
//                 if (is_string($header)) {
//                     echo "<th>" . htmlspecialchars($header) . "</th>";
//                 }
//             }
//             echo "</tr></thead><tbody>";

//             // Loop through each row and display the data
//             foreach ($resultSet[0] as $row) {
//                 echo "<tr>";
//                 foreach ($row as $key => $value) {
//                     // Ensure value is a string before passing to htmlspecialchars
//                     if (is_string($value)) {
//                         echo "<td>" . htmlspecialchars($value) . "</td>";
//                     } else {
//                         echo "<td>" . $value . "</td>";  // Display the value as is if it's not a string
//                     }
//                 }
//                 echo "</tr>";
//             }

//             echo "</tbody></table>";
//         } else {
//             echo "No records found";
//         }
//     } else {
//         echo "No data found in the result set.";
//     }
// }
?>

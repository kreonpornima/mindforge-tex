<?php 

require_once ('dbClass.php');
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : '';
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '';
$UserID = isset($_POST['UserID']) ? $_POST['UserID'] : '';
$editID = isset($_POST['editID']) ? $_POST['editID'] : '';

$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND EditID=' . $editID;

$sp['params'] = ['@SESSION','@USERNAME'];
$sp['values'] = ["'$session'","'".$_SESSION['user_id']."'"];

// $tempDataSpName = "sp_ImportGridExcelExport_".$GridID."";
$tempDataSpName = "sp_ImportGridExcelExport_2234";
$tempDataSpName = "sp_ImportGridExcelExport_3098";

$checkSpResult = db::getInstance()->db_sp_select($tempDataSpName, $sp['params'], $sp['values']);
// print_r($checkSpResult);
$response = [];

if($checkSpResult['error'] == '0') {
    if (isset($checkSpResult['result_set']) && count($checkSpResult['result_set']) > 0) {
        $resultSet = $checkSpResult['result_set'];

        // print_r($resultSet);

        // Extract the first array and remove it from the original array
        $sheetNameArray = array_shift($resultSet);
        $sheets = [];
        $filteredArray = array_filter($sheetNameArray, function($item) {
            return $item['cnt'] > 0;
        });
        $sheetNameArray = array_values($filteredArray);
        // echo '<pre>';
        // print_r($filteredArray);
        // print_r($resultSet);
        // print_r($sheetNameArray);
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
    } else {
        $response = ['response' => 'false', 'message' => 'No data found'];
    }
} else {
    $response = ['response' => 'false', 'message' => 'Error while fetching data'];
}
echo json_encode($response);
?>



<?php 

// // Simulating a mock database response (you can replace this with your actual database query logic later)
// $response = []; 

// // Mock data for multiple sheets
// $sheets = [
//     // Sheet 1 data
//     [
//         'sheetName' => 'Sheet1',
//         'headers' => ['Header1', 'Header2', 'Header3'],
//         'data' => [
//             ['Header1' => 'Data1', 'Header2' => 'Data2', 'Header3' => 'Data3'],
//             ['Header1' => 'Data4', 'Header2' => 'Data5', 'Header3' => 'Data6'],
//             ['Header1' => 'Data7', 'Header2' => 'Data8', 'Header3' => 'Data9'],
//         ]
//     ],
//     // Sheet 2 data
//     [
//         'sheetName' => 'Sheet2',
//         'headers' => ['ColumnA', 'ColumnB', 'ColumnC'],
//         'data' => [
//             ['ColumnA' => 'Info1', 'ColumnB' => 'Info2', 'ColumnC' => 'Info3'],
//             ['ColumnA' => 'Info4', 'ColumnB' => 'Info5', 'ColumnC' => 'Info6'],
//             ['ColumnA' => 'Info7', 'ColumnB' => 'Info8', 'ColumnC' => 'Info9'],
//         ]
//     ]
// ];

// // Simulating the success response (in a real scenario, you'd fetch data from a database)
// $response = [
//     'response' => 'true',
//     'sheets' => $sheets
// ];

// // Return the data as a JSON response
// echo json_encode($response);
?>

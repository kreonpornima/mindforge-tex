<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "my_database";

// header("Content-Type: application/json");

// $input = file_get_contents("php://input");
// $data = json_decode($input, true);

// if (!$data) {
//     echo json_encode(["status" => "error", "message" => "Invalid JSON format.", "input" => $input]);
//     exit;
// }
header('Content-Type: application/json'); 
include '../dbClass.php';

$data = json_decode(file_get_contents("php://input"), true);

// Ensure we received data
if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit();
}

// Retrieve FormID from JSON payload
$FormID = isset($data['FormID']) ? (int)$data['FormID'] : 0;

if ($FormID == 0) {
    echo json_encode(["status" => "error", "message" => "No Model Exists"]);
    exit();
}
// $ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
// $FormID = isset($_GET['FormID']) ? $_GET['FormID'] : 0;
// include '../reportModel.php';
// $FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : 0;
// echo "hi";exit();
$k_head_title="Form";
$k_head_include = "";
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$viewpage = isset($_GET['view']) ? $_GET['view'] : 0;
include "../model.php";

//

// if ($FormID > 0) {
//     $insertFields = [];
//     $params = [];

//     if (!empty($db[0])) { // Check if Table Name exists
//         $tableName = $db[0];

//         // Ensure only valid table columns are inserted
//         $validColumns = ["TaskDescription", "isOnTime", "Remark", "minute"]; // Add only existing columns

//         foreach ($data as $key => $value) {
//             if ($value !== null && $value !== '' && in_array($key, $validColumns)) { 
//                 $insertFields[] = $key;
//                 $params[] = $value;
//             }
//         }

//         if (!empty($insertFields)) {
//             try {
//                 $Instance = db::getInstance();
//                 if (!$Instance) {
//                     die(json_encode(["status" => "error", "message" => "Database connection failed! No Model Exists."]));
//                 }

//                 // Perform the insert operation
//                 $result = $Instance->db_insert($tableName, $insertFields, $params);

//                 if ($result['error'] == "0") { // Successful insertion
//                     $insertedID = (int)$result['last_id']; // Convert to integer
//                     echo json_encode([
//                         "success" => true,  // Use boolean instead of string
//                         "message" => "Data inserted successfully!",
//                         "insertedID" => $insertedID
//                     ]);
//                 } else {
//                     echo json_encode([
//                         "status" => "error",
//                         "message" => "Insert failed: " . $result['error_statement'],
//                         "insertedID" => 0
//                     ]);
//                 }
//             } catch (Exception $e) {
//                 echo json_encode([
//                     "status" => "error",
//                     "message" => "Error inserting data: " . $e->getMessage(),
//                     "insertedID" => 0
//                 ]);
//             }
//         } else {
//             echo json_encode([
//                 "status" => "error",
//                 "message" => "No valid data provided for insertion.", // If insertFields not found
//                 "insertedID" => 0
//             ]);
//         }
//     } else {
//         echo json_encode([
//             "status" => "error",
//             "message" => "Invalid table name.", // If table not found
//             "insertedID" => 0
//         ]);
//     }
// }

if ($FormID > 0) {
    $insertFields = [];
    $params = [];

    if (!empty($db[0])) { // Check if Table Name exists
        $tableName = $db[0];

        // Instead of using validColumns, we directly loop through the data
        foreach ($data as $key => $value) {
            if ($key !== 'FormID' && $value !== null && $value !== '') { // Only add non-null and non-empty values
                $insertFields[] = $key;
                $params[] = $value;
            }
        }
        // print_r($params);
        if (!empty($insertFields)) {
            try {
                $Instance = db::getInstance();
                if (!$Instance) {
                    die(json_encode(["status" => "error", "message" => "Database connection failed! No Model Exists."]));
                }

                // Perform the insert operation
                $result = $Instance->db_insert($tableName, $insertFields, $params);
                // print_r($result);
                if ($result['error'] == "0") { // Successful insertion
                    $insertedID = (int)$result['last_id']; // Convert to integer
                    echo json_encode([
                        "success" => true,  // Use boolean instead of string
                        "message" => "Data inserted successfully!",
                        "insertedID" => $insertedID
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Insert failed: " . $result['error_statement'],
                        "insertedID" => 0
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Error inserting data: " . $e->getMessage(),
                    "insertedID" => 0
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "No valid data provided for insertion.", // If insertFields not found
                "insertedID" => 0
            ]);
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid table name.", // If table not found
            "insertedID" => 0
        ]);
    }
}
    


//     try {
//         $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
//         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         // Fetch the table name
//         $stmt = $pdo->prepare("SELECT TableName FROM kmainforms WHERE FormId = :FormID");
//         $stmt->execute([':FormID' => $FormID]);
//         $FormArray = $stmt->fetch(PDO::FETCH_ASSOC);

//         if (!$FormArray) {
//             throw new Exception("Form ID not found in kmainforms.");
//         }

//         $TableName = $FormArray['TableName'];

//         // Fetch field details
//         $stmt = $pdo->prepare("SELECT DbFieldName, FieldType, DisplayName, Required FROM kmainfields WHERE FormId = :FormID ORDER BY DisplayOrder");
//         $stmt->execute([':FormID' => $FormID]);
//         $FieldsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         if (empty($FieldsArray)) {
//             throw new Exception("No fields found for the specified Form ID.");
//         }

//         $concatenatedFields = "";
//         $placeholders = "";
//         $separator = "";
//         foreach ($FieldsArray as $field) {
//             $fieldName = $field['DbFieldName'];
//             $fieldType = $field['FieldType'];
//             $displayName = $field['DisplayName'];
//             $isRequired = $field['Required'];
//             $fieldValue = $data[$fieldName] ?? null;

//             // Validate Required Fields
//             if ($isRequired && empty($fieldValue)) {
//                 throw new Exception("The field '{$displayName}' is required.");
//             }

//             // Type-Specific Validation
//             switch ($fieldType) {
//                 case '7': // Numeric
//                     if (!is_numeric($fieldValue)) {
//                         throw new Exception("The field '{$displayName}' must be a valid number.");
//                         // alert("The field '{$displayName}' must be a valid number.");
//                     }
//                     break;

//                 case '6': // Date
//                     $dateFormat = 'Y-m-d';
//                     $d = DateTime::createFromFormat($dateFormat, $fieldValue);
//                     if (!$d || $d->format($dateFormat) !== $fieldValue) {
//                         throw new Exception("The field '{$displayName}' must be in the format YYYY-MM-DD.");
//                     }
//                     break;

//                 case '5': // Dropdown
//                 case '19': // Dropdown
//                     if (!preg_match('/^[a-zA-Z\s]+$/', $fieldValue)) {
//                         throw new Exception("The field '{$displayName}' must contain only letters and spaces.");
//                     }
//                     break;

//                 default:
//                     // Other field types (add additional cases if needed)
//                     break;
//             }

//             // Prepare fields and values for the query
//             $fieldValue = htmlspecialchars($fieldValue, ENT_QUOTES);
//             $concatenatedFields .= $separator . $fieldName;
//             $placeholders .= $separator . "'" . $fieldValue . "'";
//             $separator = ",";
//         }

//         // Insert the data
//         $insertQuery = "INSERT INTO $TableName ($concatenatedFields) VALUES ($placeholders)";
//         $pdo->exec($insertQuery);
//         $lastInsertedId = $pdo->lastInsertId();

//         echo json_encode(["success" => "success", "message" => "Data inserted successfully.", "lastInsertedId" => $lastInsertedId]);
//     } catch (Exception $e) {
//         echo json_encode(["status" => "error", "message" => $e->getMessage(), "lastInsertedId" => 0]);
//     }
// } else {
//     echo json_encode(["success" => "error", "message" => "Invalid FormID."]);
// }
?>

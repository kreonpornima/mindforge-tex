<?php



// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "my_database";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// header("Content-Type: application/json");

// $input = file_get_contents("php://input");
// $data = json_decode($input, true);

// if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
//     echo json_encode(["status" => "error", "message" => "Invalid JSON: " . json_last_error_msg()]);
//     exit;
// }

// $FormID = isset($data['FormID']) ? $data['FormID'] : null;
// $ID = isset($data['ID']) ? $data['ID'] : 0;
// $Field = isset($data['Field']) ? $data['Field'] : null;
// $newValue = isset($data['newValue']) ? $data['newValue'] : null;

if ($FormID > 0 && $ID && $Field) {
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT TableName FROM kmainforms WHERE FormId = :FormID");
        $stmt->execute([':FormID' => $FormID]);
        $FormArray = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$FormArray) {
            throw new Exception("Form ID not found in kmainforms.");
        }
        $TableName = $FormArray['TableName'];

        $stmt = $pdo->prepare("SELECT DbFieldName, FieldType FROM kmainfields WHERE FormId = :FormID ORDER BY DisplayOrder");
        $stmt->execute([':FormID' => $FormID]);
        $FieldsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($FieldsArray)) {
            throw new Exception("No fields found for the specified Form ID.");
        }

        $validFields = array_column($FieldsArray, 'DbFieldName');
        $fieldTypes = array_column($FieldsArray, 'FieldType', 'DbFieldName');
        //  print_r($fieldTypes);

        if (!in_array($Field, $validFields)) {
            throw new Exception("Invalid field for update.");
        }

        // Validation Logic
        $validationPassed = false;
        $validationMessage = "";

        $fieldType = $fieldTypes[$Field];
        // print_r($fieldType);
        switch ($fieldType) {
            case '7':
                // if ($fieldType == 7) { // Numeric field
                    if (is_numeric($newValue) && (int)$newValue > 0) {
                        $validationPassed = true;
                    } else {
                        $validationMessage = "Invalid Value: It is Numeric Field...Please enter a Integer Value";
                    }
                // }
                break;

            case '6':
                    // echo $newValue;
                // if ($fieldType == 6) { // Date field
                    $dateFormat = 'Y-m-d';
                    $d = DateTime::createFromFormat($dateFormat, $newValue);
                    if ($d && $d->format($dateFormat) === $newValue) {
                        $validationPassed = true;
                    } else {
                        $validationMessage = "Invalid Date: Must be in YYYY-MM-DD format.";
                    }
                // }
                break;
            case '5':   //dropdown
            case '19':  //dropdown
                // if ($fieldType == 5) { // Text field
                    if (preg_match('/^[a-zA-Z\s]+$/', $newValue)) {
                        $validationPassed = true;
                    } else {
                        $validationMessage = "Invalid Input: Only letters and spaces are allowed.";
                    }
                // }
                break;

            default:
                $validationPassed = true;
        }

        if (!$validationPassed) {
            throw new Exception($validationMessage);
        }

        // Proceed with update if validation passed
        $updateQuery = "UPDATE $TableName SET $Field = :newValue WHERE ID = :ID";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([':newValue' => $newValue, ':ID' => $ID]);

        echo json_encode(["status" => "success", "message" => "Data updated successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["status" => "error1", "message" => "Database Error: " . $e->getMessage()]);
    } catch (Exception $e) {
        // echo $e;
        echo json_encode(["status" => "error2", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error3", "message" => "Invalid FormID or ID."]);
}
?>

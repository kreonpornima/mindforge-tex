<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

header("Content-Type: application/json");

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON format.", "input" => $input]);
    exit;
}

$FormID = isset($data['FormID']) ? (int)$data['FormID'] : null;

if ($FormID > 0) {
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the table name
        $stmt = $pdo->prepare("SELECT TableName FROM kmainforms WHERE FormId = :FormID");
        $stmt->execute([':FormID' => $FormID]);
        $FormArray = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$FormArray) {
            throw new Exception("Form ID not found in kmainforms.");
        }

        $TableName = $FormArray['TableName'];

        // Fetch field details
        $stmt = $pdo->prepare("SELECT DbFieldName, FieldType, DisplayName, Required FROM kmainfields WHERE FormId = :FormID ORDER BY DisplayOrder");
        $stmt->execute([':FormID' => $FormID]);
        $FieldsArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($FieldsArray)) {
            throw new Exception("No fields found for the specified Form ID.");
        }

        $concatenatedFields = "";
        $placeholders = "";
        $separator = "";
        foreach ($FieldsArray as $field) {
            $fieldName = $field['DbFieldName'];
            $fieldType = $field['FieldType'];
            $displayName = $field['DisplayName'];
            $isRequired = $field['Required'];
            $fieldValue = $data[$fieldName] ?? null;

            // Validate Required Fields
            if ($isRequired && empty($fieldValue)) {
                throw new Exception("The field '{$displayName}' is required.");
            }

            // Type-Specific Validation
            switch ($fieldType) {
                case '7': // Numeric
                    if (!is_numeric($fieldValue)) {
                        throw new Exception("The field '{$displayName}' must be a valid number.");
                        // alert("The field '{$displayName}' must be a valid number.");
                    }
                    break;

                case '6': // Date
                    $dateFormat = 'Y-m-d';
                    $d = DateTime::createFromFormat($dateFormat, $fieldValue);
                    if (!$d || $d->format($dateFormat) !== $fieldValue) {
                        throw new Exception("The field '{$displayName}' must be in the format YYYY-MM-DD.");
                    }
                    break;

                case '5': // Dropdown
                case '19': // Dropdown
                    if (!preg_match('/^[a-zA-Z\s]+$/', $fieldValue)) {
                        throw new Exception("The field '{$displayName}' must contain only letters and spaces.");
                    }
                    break;

                default:
                    // Other field types (add additional cases if needed)
                    break;
            }

            // Prepare fields and values for the query
            $fieldValue = htmlspecialchars($fieldValue, ENT_QUOTES);
            $concatenatedFields .= $separator . $fieldName;
            $placeholders .= $separator . "'" . $fieldValue . "'";
            $separator = ",";
        }

        // Insert the data
        $insertQuery = "INSERT INTO $TableName ($concatenatedFields) VALUES ($placeholders)";
        $pdo->exec($insertQuery);
        $lastInsertedId = $pdo->lastInsertId();

        echo json_encode(["success" => "success", "message" => "Data inserted successfully.", "lastInsertedId" => $lastInsertedId]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage(), "lastInsertedId" => 0]);
    }
} else {
    echo json_encode(["success" => "error", "message" => "Invalid FormID."]);
}
?>

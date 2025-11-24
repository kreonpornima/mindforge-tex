<?php
$ID = isset($_GET['ID']) ? (int)$_GET['ID'] : 0;
$Field = isset($_GET['Field']) ? $_GET['Field'] : '';
$oldValue = isset($_GET['oldValue']) ? $_GET['oldValue'] : '';
$newValue = isset($_GET['newValue']) ? $_GET['newValue'] : '';

$output = array();
$output['success'] = false;
$output['msg'] = 'Data updated successfully';

// List of allowed fields for updates
 $allowedFields = ['Athlete', 'Age', 'Date', 'Sport','country'];
// print_r($allowedFields);
// echo in_array($Field, $allowedFields) ;
// echo $ID;
if (in_array($Field, $allowedFields) && $ID > 0) {
    // echo "====> In edit  part";
    switch ($Field) {
        case 'Athlete':
            // Validate that the athlete field contains only letters and spaces
            if (preg_match('/^[a-zA-Z\s]+$/', $newValue)) {
                $output['success'] = true;
            } else {
                $output['success'] = false;
                $output['msg'] = "Please enter a valid string for athlete without any numbers.";
            }
            break;

        case 'Age':
            // Validate that the age is a positive integer
            if (is_numeric($newValue) && (int)$newValue > 0) {
                $output['success'] = true;
            } else {
                $output['success'] = false;
                $output['msg'] = "Please enter a valid positive integer for age.";
            }
            break;

        case 'Date':
            // Validate that the date is in the correct format (YYYY-MM-DD)
            $date_format = 'Y-m-d'; // Expected format
            $d = DateTime::createFromFormat($date_format, $newValue);
            if ($d && $d->format($date_format) === $newValue) {
                $output['success'] = true;
            } else {
                $output['success'] = false;
                $output['msg'] = "Please enter a valid date in YYYY-MM-DD format.";
            }
            break;

        case 'Sport':
            // Connect to the database to fetch valid sports dynamically
            $conn = new mysqli('localhost', 'root', '', 'my_database');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SELECT DISTINCT sport FROM athletes");
            $validSports = [];
            while ($row = $result->fetch_assoc()) {
                $validSports[] = $row['sport'];
            }

            if (is_array($newValue)) {
                $newValue = implode(', ', $newValue); // Convert array to a comma-separated string
            }

            // Validate each sport against the dynamic list of valid sports
            $newSports = array_map('trim', explode(',', $newValue));
            $invalidSports = array_diff($newSports, $validSports);

            if (empty($invalidSports)) {
                $output['success'] = true;
            } else {
                $output['success'] = false;
                $output['msg'] = "Invalid sports: " . implode(', ', $invalidSports);
            }

            $conn->close();
            break;
        case 'country':
            // Validate that the athlete field contains only letters and spaces
            if (preg_match('/^[a-zA-Z\s]+$/', $newValue)) {
                $output['success'] = true;
            } else {
                $output['success'] = false;
                $output['msg'] = "Please enter a valid string for country without any numbers.";
            }
            break;

        default:
            $output['success'] = false;
            $output['msg'] = "Error: Invalid field.";
            break;
    }

    // If validation passed, update the database
    if ($output['success']) {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'my_database');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the update query
        $sql = "UPDATE athletes SET $Field = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("si", $newValue, $ID); // Bind parameters
            if ($stmt->execute()) {
                $output['success'] = true;
            } else {
                $output['success'] = false;
                $output['msg'] = "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $output['success'] = false;
            $output['msg'] = "Error preparing statement: " . $conn->error;
        }

        // Close the connection
        $conn->close();
    }
} else {
    $output['success'] = false;
    $output['msg'] = "Error: Invalid Input";
}

echo json_encode($output);
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

header("Content-Type: application/json");

$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Field-level validation endpoint
if (isset($data['field'], $data['value'])) {
    $field = $data['field'];
    $value = $data['value'];
    $response = ["success" => false, "message" => "Invalid input."];

    switch ($field) {
        case 'athlete':
            if ($value && !preg_match("/^[a-zA-Z\s]+$/", $value)) {
                $response["message"] = "Please enter a valid string for the athlete field (no numbers allowed).";
            } else {
                $response = ["success" => true, "message" => "Valid athlete name."];
            }
            break;
    
        case 'age':
            if ($value && (!is_numeric($value) || (int)$value <= 0)) {
                $response["message"] = "Please enter a valid age (positive number).";
            } else {
                $response = ["success" => true, "message" => "Valid age."];
            }
            break;
    
        case 'date':
            if ($value && !strtotime($value)) {
                $response["message"] = "Please enter a valid date.";
            } else {
                $response = ["success" => true, "message" => "Valid date."];
            }
            break;
    
        case 'sport':
            if ($value && !preg_match("/^[a-zA-Z\s]+$/", $value)) {
                $response["message"] = "Please enter a valid sport (no numbers allowed).";
            } else {
                // Fetch valid sports from the database
                $validSports = [];
                $result = $conn->query("SELECT DISTINCT sport FROM athletes");
                while ($row = $result->fetch_assoc()) {
                    $validSports[] = $row['sport'];
                }
    
                if (!in_array($value, $validSports)) {
                    $response["message"] = "Invalid sport. Valid options are: " . implode(', ', $validSports);
                } else {
                    $response = ["success" => true, "message" => "Valid sport."];
                }
            }
            break;
    
        case 'country':
            if ($value && !preg_match("/^[a-zA-Z\s]+$/", $value)) {
                $response["message"] = "Please enter a valid string for the country field (no numbers allowed).";
            } else {
                $response = ["success" => true, "message" => "Valid country name."];
            }
            break;
    
        default:
            $response["message"] = "Unknown field.";
    }
    
    echo json_encode($response);
    exit;
}

// Original form submission logic with validation
$athlete = isset($data['athlete']) ? $data['athlete'] : null;
$age = isset($data['age']) ? $data['age'] : null;
$date = isset($data['date']) ? $data['date'] : null;
$sport = isset($data['sport']) ? $data['sport'] : null;
$country = isset($data['country']) ? $data['country'] : null;

$validationErrors = [];

// Validate fields (only if provided)
if ($athlete && !preg_match("/^[a-zA-Z\s]+$/", $athlete)) {
    $validationErrors[] = "Please enter a valid string for the athlete field (no numbers).";
}

if ($age && (!is_numeric($age) || (int)$age <= 0)) {
    $validationErrors[] = "Please enter a valid age (positive number).";
}

if ($date && !strtotime($date)) {
    $validationErrors[] = "Please enter a valid date.";
}

if ($sport) {
    // Fetch valid sports from the database
    $validSports = [];
    $result = $conn->query("SELECT DISTINCT sport FROM athletes");
    while ($row = $result->fetch_assoc()) {
        $validSports[] = $row['sport'];
    }

    if (!in_array($sport, $validSports)) {
        $validationErrors[] = "Invalid sport. Valid options are: " . implode(', ', $validSports);
    }
}
if ($country && !preg_match("/^[a-zA-Z\s]+$/", $country)) {
    $validationErrors[] = "Please enter a valid string for the country field (no numbers).";
}

// If there are validation errors, return them
if (!empty($validationErrors)) {
    echo json_encode([
        "success" => false,
        "message" => implode(" ", $validationErrors)
    ]);
    exit;
}

// If validation passed, allow insertion
$athlete = $athlete ? $conn->real_escape_string($athlete) : null;
$age = $age ? (int)$age : null;
$date = $date ? $conn->real_escape_string($date) : null;
$sport = $sport ? $conn->real_escape_string($sport) : null;
$country = $country ? $conn->real_escape_string($country) : null;

// Adjust the SQL query to allow NULL values for empty fields
$sql = "INSERT INTO athletes (athlete, age, date, sport, country) VALUES (
    " . ($athlete ? "'$athlete'" : "NULL") . ", 
    " . ($age !== null ? $age : "NULL") . ", 
    " . ($date ? "'$date'" : "NULL") . ", 
    " . ($sport ? "'$sport'" : "NULL") . ",
    " . ($country ? "'$country'" : "NULL") . "
)";

if ($conn->query($sql) === TRUE) {
    $lastInsertedId = $conn->insert_id; // Retrieve the last inserted ID
    echo json_encode([
        "success" => true,
        "message" => "Data saved successfully!",
        "lastInsertedId" => $lastInsertedId
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error inserting data: " . $conn->error,
        "lastInsertedId" => 0
    ]);
}

$conn->close();
?>

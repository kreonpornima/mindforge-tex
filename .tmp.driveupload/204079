<?php
$ID = isset($_GET['ID']) ? (int)$_GET['ID'] : 0;
$Field = isset($_GET['Field']) ? $_GET['Field'] : '';
$oldValue = isset($_GET['oldValue']) ? $_GET['oldValue'] : '';
$newValue = isset($_GET['newValue']) ? $_GET['newValue'] : '';


$allowedFields = ['Name', 'Gender', 'Age','Address','City','Country'];


if (in_array($Field, $allowedFields) && $ID > 0) {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'my_database');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the update query
    $sql="UPDATE users SET $Field='".$newValue."' WHERE ID ='".$ID."' ";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        
        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid input";
}
?>

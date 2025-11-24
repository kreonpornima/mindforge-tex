<?php
// Database configuration
$host = 'localhost';      // Change if necessary
$dbname = 'my_database';  // Your database name
$username = 'root';       // Your database username
$password = '';           // Your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch data from athletes table
    $stmt = $pdo->query("SELECT id,athlete, age, country, year, date, sport, gold, silver, bronze, total FROM athletes order by id desc");

    // Fetch all data and store it in the hardcodedJson variable
    $hardcodedJson = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Define the structure
    $hardcodedStructure = array(
        array("COLUMN_NAME" => "athlete", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "age", "DATA_TYPE" => "int"),
        array("COLUMN_NAME" => "date", "DATA_TYPE" => "date"),
        array("COLUMN_NAME" => "sport", "DATA_TYPE" => "string"),
        array("COLUMN_NAME" => "country", "DATA_TYPE" => "string"),
    );

    // Merge hardcodedJson with hardcodedStructure
    $finalResult = array($hardcodedJson, $hardcodedStructure);

    // Print the final result as JSON
    echo json_encode($finalResult);

} catch (PDOException $e) {
    // Handle error
    echo "Connection failed: " . $e->getMessage();
}

// Close the connection
$pdo = null;

?>
<?php

$host = 'localhost';      
$dbname = 'my_database';  
$username = 'root';       
$password = '';           

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to fetch distinct sports
    $stmt = $pdo->query("SELECT DISTINCT sport FROM athletes");

    // Fetch all distinct sports
    $rawSports = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Split multi-option values into individual sports
    $sports = [];
    foreach ($rawSports as $sport) {
        $individualSports = array_map('trim', explode(',', $sport)); 
        $sports = array_merge($sports, $individualSports);
    }

    
    $sports = array_unique($sports);
    sort($sports);

    // Return the sports as a JSON response
    echo json_encode($sports);

} catch (PDOException $e) {
    // Handle error
    echo json_encode(["error" => $e->getMessage()]);
}

// Close the connection
$pdo = null;
?>

<?php


    require_once('dbClass.php');
    session_start();

    $FormID = intval($_POST['formID']);
    include 'model.php'; // should define $db = [table, id_column]

    if (!isset($_POST['currentID'], $_POST['formID'], $_POST['direction'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
        exit;
    }

    $currentID = intval($_POST['currentID']);
    $direction = intval($_POST['direction']);
    $table = $db[0];
    $idColumn = $db[1];

    // Determine query for next or previous record
    if ($direction === 1) {
        // NEXT record (greater than current ID)
        $query = "
            SELECT TOP 1 $idColumn 
            FROM $table 
            WHERE $idColumn > $currentID 
            AND FormID = $FormID 
            AND YearCode = " . $_SESSION['dbYear'] . "
            ORDER BY $idColumn ASC
        ";
    } else {
        // PREVIOUS record (less than current ID)
        $query = "
            SELECT TOP 1 $idColumn 
            FROM $table 
            WHERE $idColumn < $currentID 
            AND FormID = $FormID 
            AND YearCode = " . $_SESSION['dbYear'] . "
            ORDER BY $idColumn DESC
        ";
    }

    // Execute
    $result = db::getInstance()->db_select($query, "AJAX-prevNext");

    if ($result['num_rows'] > 0) {
        $nextID = $result['result_set'][0][$idColumn];
        echo json_encode(['status' => 'success', 'nextID' => $nextID]);
    } else {
        echo json_encode(['status' => 'end', 'message' => 'No record found']);
    }



    // require_once ('dbClass.php');
    // $FormID = intval($_POST['formID']);
    // include 'model.php';

    // if (!isset($_POST['currentID'], $_POST['formID'], $_POST['direction'])) {
    //     echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    //     exit;
    // }

    // $currentID = intval($_POST['currentID']);
    
    // $direction = intval($_POST['direction']);
    // $db = [$db[0],$db[1]]; // Replace with your real table and ID column

    // function getNextValidRecord($id, $db, $direction, $FormID) {

    //     for ($i = 0; $i < 100; $i++) {
    //         $id += $direction;
    //         $query = "SELECT " . $db[1] . " FROM " . $db[0] . " 
    //                 WHERE " . $db[1] . " = $id 
    //                 AND FormID = $FormID 
    //                 AND YearCode = " . $_SESSION['dbYear'];
    //         $result = db::getInstance()->db_select($query, "AJAX-prevNext");

    //         if ($result['num_rows'] > 0) {
    //             return $id;
    //         }
    //     }
    //     return null;
    // }

    // $nextID = getNextValidRecord($currentID, $db, $direction, $FormID);

    // if ($nextID !== null) {
    //     echo json_encode(['status' => 'success', 'nextID' => $nextID]);
    // } else {
    //     echo json_encode(['status' => 'end', 'message' => 'No record found']);
    // }


?>
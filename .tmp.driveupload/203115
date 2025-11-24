<?php
header('Content-Type: application/json'); 
include 'dbClass.php';

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
$k_head_title="Form";
$k_head_include = "";
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$viewpage = isset($_GET['view']) ? $_GET['view'] : 0;
include "model.php";

if ($FormID > 0) {
    $insertFields = [];
    $params = [];
    
    // Check if SP exists
    // $SPName = "sp_ValidateSave_$FormID";
    // $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
    // $sqlresult = db::getInstance()->db_select($sql);

    // if($sqlresult['result_set'][0]['found'] == 0){
        // if($result['error'] == 1){
        //     $arr = array("status" => true,"data" => array("Success" => 3, "Msg" => $result['error_statement']));
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

                        //Added by pornima for call sp after save
                        $SPName = 'sp_aftersave_'.$FormID;
                        $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
                        $sqlresult = db::getInstance()->db_select($sql);
                        
                        if($sqlresult['result_set'][0]['found'] == 1){
                            $session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';

                            $data['params'] = ['@insertedid','@userid','@session'];
                            $sp['values'] = [$insertedID,$_SESSION['user_id'],"'$session'"];
                            $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
                            // print_r($result);
                            // exit();
                        }

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
    // } else {
    //     echo json_encode([
    //         "status" => "error",
    //         "message" => "Error in validation.", 
    //         "insertedID" => 0
    //     ]);
    // }
}
  
?>

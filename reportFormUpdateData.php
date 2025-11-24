<?php
include 'dbClass.php';

// Read JSON payload
$data = json_decode(file_get_contents("php://input"), true);
// print_r($data);
// Extract values with proper defaulting
$FormID = isset($data['FormID']) ? (int)$data['FormID'] : 0;
$ID = isset($data['ID']) ? (int)$data['ID'] : 0;
$Field = isset($data['Field']) ? $data['Field'] : '';
$oldValue = isset($data['oldValue']) ? $data['oldValue'] : '';
$newValue = isset($data['newValue']) ? $data['newValue'] : '';
$rowData = isset($data['rowData']) ? $data['rowData'] : '';
$Session = isset($data['session']) ? $data['session'] : '';

// Validate FormID to prevent calling invalid stored procedures
if ($FormID <= 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid FormID provided."
    ]);
    exit();
}

// Build stored procedure call
$UpdateQuery = 'sp_GridReportUpdate_' . $FormID;
    $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$UpdateQuery'";
    $checkSp = db::getInstance()->db_select($sql);
    if($checkSp['result_set'][0]['found'] == 1){  
        $SPresult = db::getInstance()->db_sp_select(
            $UpdateQuery,
            ['@FieldName', '@UpdatedData', '@OldData', '@PrimaryKey', '@Session'],
            ["'".$Field."'", "'".$newValue."'", "'".$oldValue."'", "'".$ID."'", "'".$Session."'"]
        );

        // Check if the stored procedure executed correctly
        if (isset($SPresult['error']) && $SPresult['error'] == 0) {
            if (!empty($SPresult['result_set'][0][0]['ErrorFlag']) && $SPresult['result_set'][0][0]['ErrorFlag'] == 1) {
                echo json_encode([
                    "status" => "error",
                    "message" => $SPresult['result_set'][0][0]['ErrorMsg']
                ]);
                exit();
            }
            // Return success response
            echo json_encode([
                "status" => "success",
                "message" => "Update successful"
            ]);
        } else {
            // Return general error
            echo json_encode([
                "status" => "error",
                "message" => "Database error: " . ($SPresult['error_statement'] ?? "Unknown error")
            ]);
        }
    }else{
        $sql = 'SELECT TableName, TablePrimaryKey FROM kmainforms where FormId = ' . $FormID;
        $viewResult = db::getInstanceMaster()->db_select($sql);
        if($viewResult['num_rows'] > 0){
            $TableName = $viewResult['result_set'][0]['TableName'];   
            $TablePrimaryKey = $viewResult['result_set'][0]['TablePrimaryKey'];  
            $sql = "UPDATE " . $TableName . " SET " . $Field . " = '" . $newValue . "' WHERE " . $TablePrimaryKey . " = " . $ID;
            db::getInstance()->db_update($sql);
        }
    }
exit();
?>
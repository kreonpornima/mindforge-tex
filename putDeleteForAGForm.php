<?php
header('Content-Type: application/json'); 
include 'dbClass.php';

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
if (!$id) {
    echo json_encode(['success' => false, 'error' => 'Missing ID']);
    exit;
}
$FormID = isset($data['FormID']) ? (int)$data['FormID'] : 0;
if ($FormID == 0) {
    echo json_encode(["status" => false, "error" => "No Model Exists"]);
    exit();
}
include "model.php";

    $delID = $id;
    $isDeletedFlag = false;
    $deleteErrorMsg = '';
    $deleteConfirm = 0;

    // Check if delete SP exists
    $deleteSPName = "sp_ValidateDelete_$FormID";
    $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$deleteSPName'";
    $sqlresult = db::getInstance()->db_select($sql);

    if ($sqlresult['result_set'][0]['found'] == 0) {
        $deleteConfirm = 1; // No SP, delete directly
    } else {
        // Call SP to check validations before deleting
        $session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID;
        $sp['params'] = ['@DELETEID','@TABLENAME','@USERID','@SESSION'];
        $sp['values'] = ["'$delID'","'".$db[0]."'","'".$_SESSION['user_id']."'","'$session'"];
        
        $result = db::getInstance()->db_sp_select($deleteSPName, $sp['params'], $sp['values']);
        if ($result['error'] == 1) {
            $deleteConfirm = -1;
            $deleteErrorMsg = $result['error_statement'];
        } else {
            $row = $result['result_set'][0][0];
            $deleteConfirm = ($row['Success'] == 1) ? 1 : -1;
            if ($deleteConfirm == -1) {
                $deleteErrorMsg = $row['Msg'];
            }
        }
    }

    if ($deleteConfirm == 1) {
        // Delete from main table
        $delData = "SELECT * FROM " . $db[0] . " WHERE " . $db[1]." = " . $delID;
        $delResult = db::getInstance()->db_select($delData);

        $query1 = "DELETE FROM " . $db[0] . " WHERE " . $db[1]." = " . $delID;
        $query1result = db::getInstance()->db_update($query1);
        // print_r($query1result);
        if ($query1result['error']) {
            $isDeletedFlag = false;
            $deleteErrorMsg = $query1result['error_statement'];
        } else {
            $isDeletedFlag = true;

            // Get grid fields
            $query2 = "SELECT GridId FROM kmainfields WHERE FieldType=14 AND FormID=$FormID";
            $query2result = db::getInstanceMaster()->db_select($query2);
            $gridResult = $query2result['result_set'];

            // Loop through grids and delete
            for ($i = 0; $i < sizeof($gridResult); $i++) {
                $query3 = "SELECT TableName, TablePrimaryKey, TableUnique FROM kmaingrid WHERE GridId=" . $gridResult[$i]['GridId'];
                $query3result = db::getInstanceMaster()->db_select($query3);

                $tableInfo = $query3result['result_set'][0];
                $query4 = "DELETE FROM " . $tableInfo['TableName'] . " WHERE " . $tableInfo['TablePrimaryKey'] . " = " . $delResult['result_set'][0][$tableInfo['TableUnique']];
                db::getInstance()->db_update($query4);
            }
        }
    } else {
        $isDeletedFlag = false;
    }

    echo json_encode([
        'success' => $isDeletedFlag,
        'error' => $deleteErrorMsg
    ]);
    
?>

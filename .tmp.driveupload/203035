<?php
require_once ('dbClass.php');

$FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : '0';
$FieldID = isset($_REQUEST['FieldID']) ? $_REQUEST['FieldID'] : '';

if (isset($_POST['gridData'])) {
    $gridData = json_decode($_POST['gridData'], true);

    if (!empty($gridData)) {
        $SPName = 'sp_PopupFormSaveData_'.$FormID.'_'.$FieldID;

        $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO' AND routine_name = '$SPName'";
        $checkSp = db::getInstance()->db_select($sql);

        if($checkSp['result_set'][0]['found'] == 1){
            $data['params'] = ['@FormID','@FieldID','@JsonData'];
            $sp['values'] = ["'$FormID'","'$FieldID'","'".json_encode($gridData)."'"];

            // Execute SP and get result
            $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);

            // print_r($result['result_set'][0]);

            if (!empty($result['result_set'])) {
                // Return the result as JSON
                echo json_encode([
                    'status' => 'success',
                    'data' => $result['result_set'][0]  // Should contain ShadeSummary and TotalQty
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No data returned from SP'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Stored procedure not found'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No valid data received'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request'
    ]);
}
?>

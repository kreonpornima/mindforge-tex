<?php 

require_once ('dbClass.php');

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '';
$isFilter = 0;

$SPName = 'sp_listview_'.$FormID;
$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
$sqlresult = db::getInstance()->db_select($sql);
if($sqlresult['result_set'][0]['found'] == 0){
    $sql = "SELECT * FROM kmainforms where FormId=$FormID";
    $sqlresult = db::getInstance()->db_select($sql);
    $SPName = $sqlresult['result_set'][0]['SPName'];
}


$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';

$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
$sqlresult = db::getInstance()->db_select($sql);

$response = [];

if($sqlresult['result_set'][0]['found'] == 1){
    $sql1 = "SELECT name FROM users WHERE id='".$_SESSION['user_id']."' ";
    $sql1result = db::getInstanceMaster()->db_select($sql1);	
    $username = $sql1result['result_set'][0]['name'];

    // $data['params'] = ['@whereCondition','@userid','@session'];
    // $sp['values'] = ["''","'{$_SESSION['user_id']}'", "'$session'"];

    $data['params'] = ['@whereCondition','@isFilter','@username','@session'];
    $sp['values'] = ["'ORDER BY id DESC'","$isFilter","'$username'", "'$session'"];

    $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']); 
    if (!empty($result['result_set'])) {
        // print_r($result['result_set'][1]);
        $response = $result['result_set'][1];
    }
}else{
    $sql = "SELECT ListViewDBName, TableName FROM kmainforms WHERE FormID=$FormID";
    $sqlresult = db::getInstanceMaster()->db_select($sql);

    if(strlen($sqlresult['result_set'][0]['ListViewDBName']) > 2){
        $listviewname = $sqlresult['result_set'][0]['ListViewDBName'];
        $tableName = $sqlresult['result_set'][0]['TableName'];

        $query = "SELECT COUNT(*) AS found FROM sys.objects WHERE name = '$listviewname' AND type = 'V'";
        $result = db::getInstance()->db_select($query);
        if($result['result_set'][0]['found'] == 1){
            $sql1 = "SELECT * FROM $listviewname";
            $sqlresult1 = db::getInstance()->db_select($sql1);
            if (!empty($sqlresult1['result_set'])) {
            
                $response = $sqlresult1['result_set'];
              
            }
        }else{

            $sql1 = "SELECT * FROM $tableName";
            $sqlresult1 = db::getInstance()->db_select($sql1);
            // print_r($sqlresult1);
            if (!empty($sqlresult1['result_set'])) {
                $response = $sqlresult1['result_set'];
            }
           
        }

        // $json = json_encode($response,JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

        // if ($json === false) {
        //     echo "JSON ENCODE FAILED\n";
        //     echo "Error: " . json_last_error_msg();
        // } else {
        //     echo "JSON ENCODE SUCCESS\n";
        //     // Optional: print JSON
        //     // echo $json;
        // }
            
    }
}
// var_dump($response);
// print_r($response);
echo json_encode($response,JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
exit;

?>
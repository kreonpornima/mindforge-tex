<?php 
include("dbClass.php");
$FormID = isset($_GET['FormID']) ? $_GET['FormID'] : 0;
// $TableName = isset($_GET['TableName']) ? $_GET['TableName'] : '';
$EntryID = isset($_GET['EntryID']) ? $_GET['EntryID'] : '';
$UnloadData = isset($_GET['UnloadData']) ? $_GET['UnloadData'] : 1;

if (!empty($EntryID)){
    //Update the kFormEditLock record on unload to release edit mode.
    $query = "UPDATE kFormEditLock set isDeleted=1, UpdatedAt=GETDATE() WHERE UserID = {$_SESSION['user_id']} AND isDeleted = 0 AND EntryID = $EntryID";
    $query1result = db::getInstance()->db_update($query);
}
    
if($UnloadData == 1){
    $SPName = 'sp_ValidateAdd_'.$FormID;
    $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
    $sqlresult = db::getInstance()->db_select($sql);

    $query = "SELECT TableName FROM kmainforms WHERE FormId=$FormID";
    $queryresult = db::getInstanceMaster()->db_select($query);

    if($sqlresult['result_set'][0]['found'] == 1){
        $session ='YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';
        
        $data['params'] = ['@USERID','@TABLENAME','@FORMID','@session'];
        $sp['values'] = [$_SESSION['user_id'],trim($queryresult['result_set'][0]['TableName']),$FormID,"'$session'"];
        $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
        // print_r($result);
        // exit();
    }
}

// $arr = array( "rows" => $result['num_rows']);
// echo json_encode($arr);
exit;
?>
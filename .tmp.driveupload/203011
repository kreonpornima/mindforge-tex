<?php 
require_once ('dbClass.php');
$ID = $_REQUEST['id'] ?? 0; 
$FormID = $_REQUEST['FormID'] ?? 4699; 
$UserID = $_SESSION['user_id'] ?? 0; 
$output = array();

// $session = 'FormID='.$FormID;
$SPName = 'sp_lumpselection_'.$FormID;
$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
$checkSp = db::getInstance()->db_select($sql);
$cursorPosition = '';
if($checkSp['result_set'][0]['found'] == 1){
        $session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.'';
        $sp['params'] = ['@SelectedID','@userid','@session'];
        $sp['values'] = ["'$ID'","'".$_SESSION['user_id']."'","'$session'"];
        $result = db::getInstance()->db_sp_select($SPName, $sp['params'], $sp['values']);
        // print_r($result);
        // $result = array_change_key_case_recursive($result);
        if($result['error'] == 1){
                $ErrorMsg = $result['error_statement'];
        }else{
                // print_r($result['result_set'][0][0]);
                $row = $result['result_set'][0];
                $cursorPosition = $result['result_set'][1][0]['cursorPosition'];
        }
}else{
        $query = "SELECT refid,id,pcsno,quality,qualityid,design,designid,shade,shadeid,pcs,qty,grade,gradeid,weight,rate,balancemeters,cutmtrs
                From lumpselection_".$FormID." WHERE username= " . $UserID . " AND id = " . $ID;
        $result = db::getInstance()->db_select($query);
        $row = $result['result_set'];
}
$row[0]['cursorPositionCutpack'] = $cursorPosition;
echo json_encode($row);
exit();
?>
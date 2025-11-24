<?php
session_start();
include_once("dbClass.php");

$k_debug = 0;

if($k_debug) echo "<br />" . print_r($_POST);
//exit();

$role = isset($_POST['Label']) ? $_POST['Label'] : 0;
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$regID = isset($_POST['regId']) ? $_POST['regId'] : 0;
$group_id = isset ($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;


if((int)$editID > 0){
  
    $sql = "UPDATE pagerolemaster SET Label = '" . $role . "' WHERE RoleId = " . $editID;
    $result = db::getInstanceMaster()->db_update($sql);
    // exit();
    $sql = "Delete from pageroleaccess where RoleID = " . $editID;
    $result = db::getInstanceMaster()->db_update($sql);
    $roleID = $editID;
}else{
   
    $sql ="INSERT into pagerolemaster (Label,GroupID) VALUES ('".$role."','".$group_id."')";
    $result = db::getInstanceMaster()->db_insertQuery($sql);
    $roleID = $result['last_id'];
}
if($k_debug) echo "<br />" . $sql; 
if($k_debug) echo "<br />" . print_r($result);

    $queryVals = "INSERT INTO pageroleaccess (RoleID, PageAccessID, AddBtn,EditBtn,ListView,OtherBtn, DeleteBtn) 
    							VALUES ";
    $separator = "";
    for($i = 0; $i < $_POST['totalPages']; $i++){
    	$queryVals .= $separator . "(" . $roleID . ", " . $_POST['accessId'][$i][0] . ", ";
    	if(isset($_POST['add'][$i][0])){  $queryVals .=  ($_POST['add'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=   "0" . ", ";}
    	if(isset($_POST['edit'][$i][0])){ $queryVals .=  ($_POST['edit'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	if(isset($_POST['listview'][$i][0])){ $queryVals .=  ($_POST['listview'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	if(isset($_POST['other'][$i][0])){ $queryVals .=  ($_POST['other'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	if(isset($_POST['delete'][$i][0])){ $queryVals .=  ($_POST['delete'][$i][0] == "on" ? 1 : 0) . ""; }else{ $queryVals .=  "0" . "";}
    	$queryVals .= ")";
    	$separator = ", ";
    }
    // echo $queryVals;
    // exit();
    if($k_debug) echo "<br />" . $queryVals;
    $result = db::getInstanceMaster()->db_insertQuery($queryVals);
    if($k_debug) echo "<br />" . print_r($result);
    

    if($regID){
        if($editID > 0){
            $roleID = $editID;
        }
        $sql1 = "select * from CompanyRoleAccess where RoleID = '".$roleID."' ";
        $result1 = db::getInstanceMaster()->db_insertQuery($sql1);
        if($result1){
            $sql2 = "DELETE from CompanyRoleAccess where RoleID = '".$roleID."' ";
            $result2 = db::getInstanceMaster()->db_insertQuery($sql2);
        }
        for($j=0; $j<sizeof($regID); $j++){
            $sql3 ="INSERT into CompanyRoleAccess (RoleID,RegID) VALUES ('".$roleID."','".$regID[$j]."')";
            $result = db::getInstanceMaster()->db_insertQuery($sql3);   
        }
    }
    // exit();
// echo '<script>alert("data sent successfully");</script>';

if($k_debug) exit();
// if($k_debug) echo "<br />" . print_r($result);
echo '<script>window.location="roles.php?view=1";</script>';
?>	
<?php
session_start();
include_once("dbClass.php");

$k_debug = 0;

if($k_debug) echo "<br />" . print_r($_POST);
//exit();

$role = isset($_POST['Label']) ? $_POST['Label'] : 0;
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$regID = isset($_POST['regId']) ? $_POST['regId'] : 0;
$ipaddressid = isset($_POST['ipAddressId']) ? $_POST['ipAddressId'] : 0;
$DepartmentHead = isset($_POST['DepartmentHead']) ? $_POST['DepartmentHead'] : 0;
$group_id = isset ($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;
$rightsJson = isset($_POST['rightsJson']) ? $_POST['rightsJson'] : '';

$rights = json_decode($rightsJson);


// echo "<pre>";
// print_r($rights);
// echo "</pre>";
// exit();


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

    $queryVals = "INSERT INTO pageroleaccess (RoleID, PageAccessID, AddBtn,EditBtn,ListView,OtherBtn, DeleteBtn, EwayBillBtn, EinvoiceBtn, PdfReportBtn, GridReportBtn) 
    							VALUES ";
    $separator = "";
    for($i = 0; $i < count($rights); $i++){
        // print_r($rightsJsonArray[$i]);
    	$queryVals .= $separator . "(" .$roleID . ", " . $rights[$i]->Level1 . ", ";

        $queryVals .= (!empty($rights[$i]->AddBtn) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->EditBtn) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->ListView) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->OtherBtn) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->DeleteBtn) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->EwayBillBtn) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->EinvoiceBtn) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->PdfReportBtn) ? 1 : 0) . ", ";
        $queryVals .= (!empty($rights[$i]->GridReportBtn) ? 1 : 0);

    	// if(isset($rights[$i]->AddBtn)){  $queryVals .=  ($rights[$i]->AddBtn == "on" ? 1 : 0) . ", "; }else{ $queryVals .=   "0" . ", ";}
    	// if(isset($rights[$i]->EditBtn)){ $queryVals .=  ($rights[$i]->EditBtn == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	// if(isset($rights[$i]->DeleteBtn)){ $queryVals .=  ($rights[$i]->DeleteBtn == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	// if(isset($rights[$i]->ListView)){ $queryVals .=  ($rights[$i]->ListView == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	// if(isset($rights[$i]->OtherBtn)){ $queryVals .=  ($rights[$i]->OtherBtn == "on" ? 1 : 0) . ""; }else{ $queryVals .=  "0" . "";}
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

    if($ipaddressid){
        if($editID > 0){
            $roleID = $editID;
        }
        $sql1 = "select * from MapRoleIP where RoleID = '".$roleID."' ";
        $result1 = db::getInstanceMaster()->db_insertQuery($sql1);
        if($result1){
            $sql2 = "DELETE from MapRoleIP where RoleID = '".$roleID."' ";
            $result2 = db::getInstanceMaster()->db_insertQuery($sql2);
        }
        for($j=0; $j<sizeof($ipaddressid); $j++){
            $sql3 ="INSERT into MapRoleIP (RoleID,IPAddressID) VALUES ('".$roleID."','".$ipaddressid[$j]."')";
            $result = db::getInstanceMaster()->db_insertQuery($sql3);   
        }
    }


    if($DepartmentHead){
        if($editID > 0){
            $roleID = $editID;
        }
        $sql1 = "select * from MapGeoLockingHead where RoleID = '".$roleID."' ";
        $result1 = db::getInstanceMaster()->db_insertQuery($sql1);
        if($result1){
            $sql2 = "DELETE from MapGeoLockingHead where RoleID = '".$roleID."' ";
            $result2 = db::getInstanceMaster()->db_insertQuery($sql2);
        }

        for($j=0; $j<sizeof($DepartmentHead); $j++){
            $sql3 ="INSERT into MapGeoLockingHead (RoleID,UserID) VALUES ('".$editID."','".$DepartmentHead[$j]."')";
            $result = db::getInstanceMaster()->db_insertQuery($sql3);   
        }
        
    }

    
    // exit();
// echo '<script>alert("data sent successfully");</script>';

if($k_debug) exit();
// if($k_debug) echo "<br />" . print_r($result);
echo '<script>window.location="roles.php?view=1";</script>';
?>	
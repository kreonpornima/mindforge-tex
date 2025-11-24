<?php
session_start();
include_once("dbClass.php");

$k_debug = 0;

if($k_debug) echo "<br />" . print_r($_POST);
//exit();

$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$name = isset($_POST['name']) ? $_POST['name'] : '';
$group = isset($_POST['group']) ? $_POST['group'] : 0;
$ipv4address = isset($_POST['ipv4address']) ? $_POST['ipv4address'] : '';
$isactive = isset($_POST['isActive']) ? $_POST['isActive'] : 0;

// $groupid = isset($_POST['groupId']) ? $_POST['groupId'] : 0;
// $usercategory = isset ($_POST['userCategory']) ? $_POST['userCategory'] : 0;


if((int)$editID > 0){
  
    $sql = "UPDATE geoLockings SET Name = '" . $name . "', IPv4Address = '" . $ipv4address . "', GroupID = '" . $_SESSION['group_id'] . "', 
     isActive = '" . $isactive . "'  WHERE ID = " . $editID;
  
    $result = db::getInstanceMaster()->db_update($sql);
   
}else{
   
    $sql = "INSERT INTO geoLockings (Name, IPv4Address, GroupID, isActive, CreatedBy) VALUES ('" . $name . "', '" . $ipv4address . "', " . $_SESSION['group_id'] . ", " . $isactive . ", " . $_SESSION['user_id'] . ")";
    $result = db::getInstanceMaster()->db_insertQuery($sql);
    $roleID = $result['last_id'];
}


if($k_debug) exit();
// if($k_debug) echo "<br />" . print_r($result);
echo '<script>window.location="geoLocking.php?view=1";</script>';
?>	
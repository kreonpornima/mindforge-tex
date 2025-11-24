<?php
session_start();
include_once("dbClass.php");

$k_debug = 0;

if($k_debug) echo "<br />" . print_r($_POST);
//exit();

// $editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$isGeoLocking = isset($_POST['isGeoLocking']) ? $_POST['isGeoLocking'] : '';


// $groupid = isset($_POST['groupId']) ? $_POST['groupId'] : 0;
// $usercategory = isset ($_POST['userCategory']) ? $_POST['userCategory'] : 0;

$sql = "SELECT * FROM settings WHERE UserID = {$_SESSION['user_id']}";
$result = db::getInstanceMaster()->db_select($sql);	
	


if($result['num_rows'] > 0){
    echo $sql = "UPDATE settings SET isGeoLocking = '" . $isGeoLocking . "', UpdatedBy = '". $_SESSION['user_id'] ."'  WHERE UserID = {$_SESSION['user_id']}";
    $result = db::getInstanceMaster()->db_update($sql);
}else{
    $sql ="INSERT into settings (isGeoLocking, UserID, CreatedBy) VALUES ('".$isGeoLocking."','".$_SESSION['user_id']."','".$_SESSION['user_id']."')";
    $result = db::getInstanceMaster()->db_insertQuery($sql);
    // $roleID = $result['last_id'];
}


if ($result) {
    echo "Settings updated successfully.";
} else {
    echo "Error updating settings.";
}
?>	
<?php
session_start();
include_once("dbClass.php");

$k_debug = 0;

if($k_debug) echo "<br />" . print_r($_POST);
//exit();

$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$name = isset($_POST['name']) ? $_POST['name'] : '';
$role = isset($_POST['role']) ? $_POST['role'] : 0;
$username = isset($_POST['username']) ? $_POST['username'] : '';
$authmode = isset ($_POST['authmode']) ? $_POST['authmode'] : 0;
$password = isset($_POST['password']) ? $_POST['password'] : '';
$telegramid = isset($_POST['telegramId']) ? $_POST['telegramId'] : 0;
$emailid = isset($_POST['emailId']) ? $_POST['emailId'] : '';
$isactive = isset($_POST['isActive']) ? $_POST['isActive'] : 0;

// $groupid = isset($_POST['groupId']) ? $_POST['groupId'] : 0;
// $usercategory = isset ($_POST['userCategory']) ? $_POST['userCategory'] : 0;


if((int)$editID > 0){
  
    $sql = "UPDATE users SET Name = '" . $name . "', Username = '" . $username . "', Role = '" . $role . "', Authmode = '" . $authmode . "',password = '" . $password . "',
    TelegramID = '" . $telegramid . "', EmailID = '" . $emailid . "', isActive = '" . $isactive . "'  WHERE ID = " . $editID;
  
    $result = db::getInstanceMaster()->db_update($sql);
   
}else{
   
    $sql ="INSERT into users (Username, Name, Role, Authmode, Password, TelegramID, EmailID, GroupID, Category, isActive ) VALUES ('".$username."','".$name."','".$role."','".$authmode."','".$password."','".$telegramid."','".$emailid."','".$_SESSION['group_id']."', 1, $isactive)";
    $result = db::getInstanceMaster()->db_insertQuery($sql);
    $roleID = $result['last_id'];
}


if($k_debug) exit();
// if($k_debug) echo "<br />" . print_r($result);
echo '<script>window.location="users.php?view=1";</script>';
?>	
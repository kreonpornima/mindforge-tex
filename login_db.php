<?php
require_once('dbClass.php');
session_start();
require_once('auth_helpers.php');

$email = $_POST['email'] ?? '';
$pwd = $_POST['pwd'] ?? '';
$captcha = $_POST['captcha'] ?? '';
$pwd2 = isset($_POST['pwd2']) ? $_POST['pwd2'] : "";

$result = authenticateUser($email, $pwd, $pwd2, $captcha);



if (!$result['status']) {

	// print_r($result);
	// print_r($_SESSION);
	// exit();

	echo '<script>window.location.replace("signin.php?error=' . $result['error_code'] . '");</script>';
	exit();
	
}
// exit();
// Success
header("Location: " . $result['redirect']);
// echo '<script>window.location.replace("' . $result['redirect'] . '");</script>';
// echo '<script>window.location.replace("home.php");</script>';
exit();
?>
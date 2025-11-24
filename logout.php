<?php
	include("dbClass.php");
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
	// echo $_SESSION['ConnectionError'];
	if(isset($_SESSION['ConnectionError'])){
		if($_SESSION['ConnectionError'] == 'error'){
			session_unset();
			session_destroy(); 
			//header('Location: signin.php');
			echo '<script>window.location.replace("signin.php");</script>';
			exit();
		}
	}
	// print_r($_SESSION); exit;
	// if(!isset($_SESSION['logout'])){
	// 	// if(($_SESSION['logout'] == 1)){
	// 	$_SESSION['logout'] = 1;
	// 	// unset($_SESSION['logout']);
	// 	echo '<script>window.location.replace("logout.php");</script>';
	// 	exit;
	// }
	//On logout, check if the current user has any edit mode active, then release the edit mode
	if(isset($_SESSION['user_id'])){
		$query = "UPDATE kFormEditLock set isDeleted=1, UpdatedAt=GETDATE() WHERE UserID = {$_SESSION['user_id']} AND isDeleted = 0 AND CompanyID = {$_SESSION['dbCompany']} AND DivisionID = {$_SESSION['dbDivision']}";
		$query1result = db::getInstance()->db_update($query);
		
		$SPName = 'sp_ValidateLogout';
		$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
		$sqlresult = db::getInstance()->db_select($sql);
		if($sqlresult['result_set'][0]['found'] == 1){
			$session ='YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';
			
			$data['params'] = ['@USERID','@session'];
			$sp['values'] = [$_SESSION['user_id'],"'$session'"];
			$result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
			// print_r($result);
			// exit();
		}
	}

	echo "Logged out Successfully ";
	session_unset();
	session_destroy(); 
	//header('Location: signin.php');
	echo '<script>window.location.replace("signin.php");</script>';
	exit();
		    
?>
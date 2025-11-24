<?php
include_once('./dbClass.php');

$userSessionTimeout = 60;	//in minutes

$userflag=0;   
$logincheck = isset($k_head_login_check) ? $k_head_login_check : 1;
$check_access = isset($k_head_access) ? $k_head_access : 0;
$user_access = isset($user_access) ? $user_access : 1;
if($user_access){
	if(isset($_SESSION['user_id']) && strlen($_SESSION['user_id'])>0){
		$userflag = 1;
		$logincheck =0;
		$uid = $_SESSION['user_id'];
		//$sql = "SELECT ID as uid, Name, Password FROM users WHERE ID= $uid LIMIT 1";
		$sql = "SELECT ID as uid, name,pagerolemaster.Label as Role,users.Role as RoleID FROM users LEFT JOIN pagerolemaster on users.Role= pagerolemaster.RoleId WHERE ID='".$uid."' ";
		$result = db::getInstanceMaster()->db_select($sql);	
		for($i = 0; $i < $result['num_rows']; $i++){
		     $name = $result['result_set'][$i]['name'];
		     $RoleID = $result['result_set'][$i]['RoleID'];
			 if($i == 0) break;  //instead of TOP 1 or LIMIT 1
		}
	}
	if(isset($_SESSION['LoginKey'])){
		if(strlen($_SESSION['LoginKey']) > 0){
			$sql = "select DATEDIFF(MINUTE, LastUsageAt, SYSDATETIME()) as tm, LastUsageAt from users WHERE ID='".$_SESSION['user_id']."' AND LoginKey = '".$_SESSION['LoginKey']."'";
			$result = db::getInstanceMaster()->db_select($sql);
			// print_r($result);
			if($result['num_rows'] == 0){
				echo '<script>alert("This user has logged in from a different device.");</script>';
				echo '<script>window.location.replace("logout.php");</script>';
				exit;
			}
			if($result['result_set'][0]['tm'] > $userSessionTimeout){
				echo '<script>alert("You have been logged out due to inactivity. Please login again. '.$result['result_set'][0]['tm'].'mins");</script>';
				echo '<script>window.location.replace("logout.php");</script>';
				exit;
			}
			$sql = "Update users set LastUsageAt = getdate() where ID = ".$_SESSION['user_id'];
			$result = db::getInstanceMaster()->db_update($sql);
		}
	}
	if($userflag == 0 && $logincheck==1){
	    echo '<script>window.location.replace("signin.php");</script>';
		exit();
	}
}
$menubar="";
	$sqlmenu = "SELECT * from view_allMenuAccess WHERE RoleID='".$RoleID."' AND GroupId='".$_SESSION['group_id']."' ORDER BY parentmenu,PageOrder ASC";

	$result = db::getInstanceMaster()->db_select($sqlmenu);
	$pageURL =  basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
		
		$menubar .= '<ul class="nav nav-main" id="texMenu"> ';
	    $pageAccessForUser = array();
		for($i = 0; $i < $result['num_rows']; $i++){
		    if(str_contains($result['result_set'][$i]['filename'],$pageURL)){
		        $pageAccessForUser = $result['result_set'][$i];
		    }
			$pageaccessid = $result['result_set'][$i]['id'];
			$displayname = $result['result_set'][$i]['displayname'];
			$filename = $result['result_set'][$i]['filename'];
			$parentMenu = $result['result_set'][$i]['parentmenu'];
			$FaIcon = $result['result_set'][$i]['FaIcon'];
			if($parentMenu == 0) {
				// if($result['result_set'][$i]['AddBtn'] !=0 || $result['result_set'][$i]['ListView'] !=0 || $result['result_set'][$i]['EditBtn'] !=0){
					
					$sqlmenu1 = "SELECT * from view_allMenuAccess WHERE RoleID='".$RoleID."' AND 
					GroupId='".$_SESSION['group_id']."' AND parentmenu='".$pageaccessid."' ORDER BY PageOrder ASC";

					$result1 = db::getInstanceMaster()->db_select($sqlmenu1);
					
					if($result1['num_rows'] > 0){
						
						$menubar .= '<li class="nav-parent"><a><i class="fa fa-address-book" aria-hidden="true"></i>'.$displayname.'</a> ';
							$menubar .= '<ul class="nav nav-children"> ';
								for($j = 0; $j < $result1['num_rows']; $j++){
									$subpageaccessid = $result1['result_set'][$j]['id'];
									$submenufilename = $result1['result_set'][$j]['filename'];
									$submenuFaIcon = $result1['result_set'][$j]['FaIcon'];
									$submenudisplayname = $result1['result_set'][$j]['displayname'];


									$sqlmenu2 = "SELECT * from view_allMenuAccess WHERE RoleID='".$RoleID."' AND 
										GroupId='".$_SESSION['group_id']."' AND parentmenu='".$subpageaccessid."' ORDER BY PageOrder ASC";
									
									$result2 = db::getInstanceMaster()->db_select($sqlmenu2);
									
									if($result2['num_rows'] > 0){
										$menubar .= '<li class="nav-parent" ><a><i class="fa fa-address-book" aria-hidden="true"></i>'.$submenudisplayname.'</a> ';
											$menubar .= '<ul class="nav nav-children"> ';
											for($k = 0; $k < $result2['num_rows']; $k++){
												
												$subchildmenufilename = $result2['result_set'][$k]['filename'];
												$subchildmenuFaIcon = $result2['result_set'][$k]['FaIcon'];
												$subchildmenudisplayname = $result2['result_set'][$k]['displayname'];

												$menubar .= '<li><a href="'.$subchildmenufilename.'"><i class="'.$subchildmenuFaIcon.'" aria-hidden="true"></i>'.$subchildmenudisplayname.'</a></li>';

											}
											$menubar .= '</ul> ';
										$menubar .= '</li> ';
									}
									else{
										$menubar .= '<li ><a href="'.$submenufilename.'"><i class="'.$submenuFaIcon.'" aria-hidden="true"></i>'.$submenudisplayname.'</a></li>';
									}

								}
							$menubar .= '</ul> ';
						$menubar .= '</li> ';
					}else{
						$menubar .= '<li><a href="'.$filename.'"><i class="'.$FaIcon.'" aria-hidden="true"></i>'.$displayname.'</a></li>';
					
					}
				// }
			}
			elseif($parentMenu == -1) {
			    $menubar .='';
			}
		}
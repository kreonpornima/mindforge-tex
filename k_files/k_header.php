<?php
include_once('./dbClass.php');

$userSessionTimeout = 60;	//in minutes
$userWarningTime = 55; //in minutes
if($_SESSION['Category'] == 2){
	$userSessionTimeout = 120;	//in minutes
	$userWarningTime = 115; //in minutes
}
// if($_SESSION['user_id'] == 1025){
// 	$userSessionTimeout = 1;	//in minutes
// 	$userWarningTime = 0.5; //in minutes
// }


$userflag=0;   
$logincheck = isset($k_head_login_check) ? $k_head_login_check : 1;
$check_access = isset($k_head_access) ? $k_head_access : 0;
$user_access = isset($user_access) ? $user_access : 1;
$user_access = 1;
if($user_access){
	
	if(isset($_SESSION['user_id']) && strlen($_SESSION['user_id'])>0){
		
		$userflag = 1;
		$logincheck =0;
		$uid = $_SESSION['user_id'];

		//$sql = "SELECT ID as uid, Name, Password FROM users WHERE ID= $uid LIMIT 1";
		$sql = "SELECT users.ID as uid, ISNULL(name,Username) as name,pagerolemaster.Label as Role,users.Role as RoleID, users.isActive
				, AiGroup.Label as GroupName, users.Name as Name2, users.Username, users.Category
				FROM users 
				LEFT JOIN Aigroup ON users.GroupID = AiGroup.ID
				LEFT JOIN pagerolemaster on users.Role= pagerolemaster.RoleId WHERE users.ID='".$uid."' ";
		$result = db::getInstanceMaster()->db_select($sql, "H-23");	

		//Force logout on user deactivation
		if (isset($result['result_set'][0]['isActive']) && $result['result_set'][0]['isActive'] == 0) {
			echo '<script>window.location.replace("logout.php");</script>';
			exit;
		}

		for($i = 0; $i < $result['num_rows']; $i++){
			$row = $result['result_set'][$i];
			$name = $row['name'];
			// $_SESSION['Category']=$row['Category'];
			$Category = $row['Category'];
			if($Category == 2){
				$logFileName = 'dev_' . $row['Name2'].'_'.$row['Username'];
			}else{
				$logFileName = $row['GroupName'] . '_' . $row['Name2'].'_'.$row['Username'];
			}
				// $row['GroupName'] = 'dev_' . $row['GroupName'];
		    //  if(!isset($_SESSION['logFileName']))
				$_SESSION['logFileName'] = $logFileName;
			$RoleID = $result['result_set'][$i]['RoleID'];
			$rolename = $result['result_set'][$i]['Role'];
			if($i == 0) break;  //instead of TOP 1 or LIMIT 1
		}
	}
	if(isset($_SESSION['LoginKey'])){
			
		if(strlen($_SESSION['LoginKey']) > 0){
			$sql = "select DATEDIFF(MINUTE, LastUsageAt, SYSDATETIME()) as tm, LastUsageAt from users WHERE ID='".$_SESSION['user_id']."' AND LoginKey = '".$_SESSION['LoginKey']."'";
			
			$result = db::getInstanceMaster()->db_select($sql, "H-32");
			// print_r($result);
			
			if($result['num_rows'] == 0){				
				echo '<script>alert("This user has logged in from a different device.");</script>';
				echo '<script>window.location.replace("logout.php");</script>';
				exit;
			}
			$tm = intval($result['result_set'][0]['tm']);

			if($tm > $userSessionTimeout){
				echo '<script>alert("You have been logged out due to inactivity. Please login again. '.$result['result_set'][0]['tm'].'mins");</script>';
				echo '<script>window.location.replace("logout.php");</script>';
				exit;
			}
			
			$sql = "Update users set LastUsageAt = getdate() where ID = ".$_SESSION['user_id'];
			$result = db::getInstanceMaster()->db_update($sql, "H-45");
		}
	}
	if($userflag == 0 && $logincheck==1){
	    echo '<script>window.location.replace("logout.php");</script>';
		exit();
	}

	// Check Developer company access
	if($_SESSION['Category'] == 2){
		if($_SESSION['user_id'] == 1020 || $_SESSION['user_id'] == 1025 || $_SESSION['user_id'] == 1019 || $_SESSION['user_id'] == 1018){

			
		}else{
			$sql = "SELECT * FROM map_developer_company_access WHERE UserID=".$_SESSION['user_id']." and GroupID=".$_SESSION['group_id'];
			$result = db::getInstanceMaster()->db_select($sql);
			if($result['num_rows'] == 0){
				echo '<script>window.location.replace("company.php");</script>';
				exit();
			}
		}
	}

	

	if($FormID){
		// Step 1: Call the function and store the returned access data
		$access = UserAccess($FormID, $_SESSION['access']); // make sure $FormID and $RoleID are defined
		// Deny access if all permissions are 0
		if ($access['canAdd'] == 0 && $access['canEdit'] == 0 && $access['canDelete'] == 0) {
			// Option 1: Redirect to an error/unauthorized page
			// header("Location: https://ai.mindforgeerp.com/home.php");
			echo '<script>alert("Unauthorized Page Access");window.location.replace("home.php");</script>';
			// header("Location: home.php");
			exit();
		}
	}

	if($_SESSION['Category'] == 3){
		$access = UserAccess($FormID=0, $_SESSION['access']);
	}	
}

$menubar="";
//updated by pornima on 14/2/2025 
$userCategory = isset($_SESSION['Category']) ? (int)$_SESSION['Category'] : 0;

if($userCategory == 2 || $userCategory == 3){
	$SPName = 'MENUS_LOADING_tmp';
	$data['params'] = ['@GROUPID','@ROLEID','@USERID','@CATEGORYID'];
	$sp['values'] = ["'".$_SESSION['group_id']."'","'".$RoleID."'","'".$_SESSION['user_id']."'","'".$_SESSION['Category']."'"];
}else{
	$SPName = 'MENUS_LOADING_tmp';
	$data['params'] = ['@GROUPID','@ROLEID','@USERID','@CATEGORYID'];
	$sp['values'] = ["'".$_SESSION['group_id']."'","'".$RoleID."'","'".$_SESSION['user_id']."'","'".$_SESSION['Category']."'"];
}
$result = db::getInstanceMaster()->db_sp_select($SPName, $data['params'], $sp['values'], "H-328");

// $result = db::getInstanceMaster()->db_select($sqlmenu);
$pageURL =  basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

$menubar .= '<ul class="nav nav-main" id="texMenu"> ';
$pageAccessForUser = array();
$showEndPart = false; // Flag to control when to show the "end part"
$skipMenu = false; // Flag to control skipping the menu items

if(count($result['result_set']) != 0){

	// Loop through the result set
	for($i = 0; $i < count($result['result_set'][0]); $i++){
		$displayname = $result['result_set'][0][$i]['displayname1'];
		$menulevel = $result['result_set'][0][$i]['MenuLevel'];
		$nextMenulevel = $result['result_set'][0][$i + 1]['MenuLevel'];
		$parentMenu = $result['result_set'][0][$i]['parentMenu'];
		$submenufilename = $result['result_set'][0][$i]['filename'];
		$submenuFaIcon = $result['result_set'][0][$i]['FaIcon'];

		if($i == 0 && $menulevel == 2){

			$showEndPart = true;  // Set flag to true when the condition is met
			$skipMenu = true;     // Skip the other menu items
		}

		// Skip menu generation if the flag is set
		if ($skipMenu) {
			break;  // Break out of the loop, skipping the rest of the menu items
		}
		
		if($nextMenulevel > $menulevel){ //it has submenu
			$menubar .= '<li class="nav-parent"><a><i class="fa fa-address-book" aria-hidden="true"></i>' . $displayname . '</a>';
			$menubar .= '<ul class="nav nav-children"> ';
		}

		if($nextMenulevel == $menulevel){ // no submenu
			$menubar .= '<li><a href="'.$submenufilename.'"><i class="'.$submenuFaIcon.'" aria-hidden="true"></i>'.$displayname.'</a></li>';
		}

		if($nextMenulevel < $menulevel){ // next menu is upper level menu
			$menubar .= '<li><a href="'.$submenufilename.'"><i class="'.$submenuFaIcon.'" aria-hidden="true"></i>'.$displayname.'</a></li>';
			$tmp = $menulevel - $nextMenulevel;
			if($tmp == 1) $menubar .= '</ul>';
			if($tmp == 2) $menubar .= '</ul></ul>';

		}
		if($i == $result['num_rows'] - 1){
			if($menulevel == 1) $menubar .= '</ul>';
			if($menulevel == 2) $menubar .= '</ul></ul>';
		}		
	}

	// Only add the "Home" part if the flag is true
	if ($showEndPart) {
		// Remove any other list items if $showEndPart is true
		$menubar = '<ul class="nav nav-main" id="texMenu">';  // Start the list with the Home item only
		$menubar .= '<li><a href=""><i class="" aria-hidden="true"></i>Home</a></li>';
	}

	$menubar .= '</ul>';
}


$loggeduser = isset($name) ? $name : "Admin";
$accounttype = isset($rolename) ? $rolename : "Admin Account";
if(strlen($_SESSION['dbCompanyName']) == 0){ // || $_SESSION['dbCompanyName'] == 0
	echo '<script>window.location.replace("company.php");</script>';
	exit;
}

$getNotification = "select n.ID, n.TaskID, n.UserID, n.CreatedAt, n.ReadAt, 
	CASE WHEN n.NotifyType = 1 THEN CONCAT(u.Name,' has assigned a Task to you.') 
	WHEN n.NotifyType = 2 THEN CONCAT(u.Name,' has left a comment on the Task.') 
	WHEN n.NotifyType = 3 THEN CONCAT(u.Name,' has marked to ticket as completed.') 
	END as Notif_Title from Requirement_Notifications n
	LEFT JOIN users u ON n.CreatedBy = u.ID WHERE n.ReadAt IS NULL AND UserID={$_SESSION['user_id']} ORDER BY n.ID DESC";
$getNotificationResult = db::getInstanceMaster()->db_select($getNotification, "H-405");	


function timeAgo($datetime) {
    if (!$datetime instanceof DateTime) {
        try {
            $datetime = new DateTime($datetime); // Convert string to DateTime
        } catch (Exception $e) {
            return 'Invalid date';
        }
    }

    $now = new DateTime();
    $diff = $now->diff($datetime);

    if ($diff->y > 0) return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    if ($diff->m > 0) return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    if ($diff->d > 1) return $diff->d . ' days ago';
    if ($diff->d == 1) return 'Yesterday';
    if ($diff->h > 0) return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    if ($diff->i > 0) return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    return 'Just now';
}

?>
<!doctype html>
<html class="fixed sidebar-left-collapsed sidebar-left-xs" >
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<!-- Basic -->
		
		<?php echo isset($k_head_include) ? $k_head_include : "";?>

		<title><?php echo isset($k_head_title)? $k_head_title : "Head title"; ?></title>	
		<meta name="keywords" content="<?php echo isset($k_head_keywords)? $k_head_keywords : "Main Page"; ?>" />
		<meta name="description" content="<?php echo isset($k_head_desc)? $k_head_desc : "Page Desc"; ?>">
		<meta name="author" content="<?php echo isset($k_head_author)? $k_head_author : "KreonSolutions.com"; ?>">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta charset="UTF-8">

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.css" />
		<?php 
			//Added due to conflict between datatables used on form for dropdownTableif(isset($_GET['view'])) if($_GET['view'] == 1) echo '<link rel="stylesheet" href="/assets/vendor/jquery-datatables/media/css/jquery.dataTables.css" />';  
			if(isset($_GET['view'])) if($_GET['view'] == 1) echo '<link rel="stylesheet" href="./assets/vendor/jquery-datatables/media/css/jquery.dataTables.css" />';  

			//if(isset($_GET['view'])) if($_GET['view'] == 1) echo '<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />';  
		?>
		<link rel="stylesheet" href="assets/vendor/jquery-ui/jquery-ui.theme.css" />
		<link rel="stylesheet" href="assets/vendor/dropzone/basic.css" />
		<link rel="stylesheet" href="assets/vendor/dropzone/dropzone.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris.js/morris.css" />
		<link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		<script src="assets/javascripts/jquery.hotkeys-0.7.9.js"></script>

		<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
		<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
		<!-- Excel export  -->
		<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.0/dist/xlsx.full.min.js"></script> 

		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.2.61/jspdf.min.js"></script> -->
		
		<!--script src="jspdf/jspdf.plugin.autotable.js"></script-->
		<!--<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>-->
		
		<script>
			$(document).ready(function(){
				$(window).bind('keydown', function(event) {	//FOR SHORTCUTS AROUND THE APPLICATION
					if (event.ctrlKey || event.metaKey) {
						switch (String.fromCharCode(event.which).toLowerCase()) {
							case 's':
								//On ctrl+s save & update form
								event.preventDefault();
								document.getElementById('SaveUpdate').click();
								break;
							case 'e':
								//On ctrl+e preview page open edit form
								event.preventDefault();
								const search = window.location.search;
								const substr = 'preview';
								if(search.includes(substr)){
									const pathname = window.location.pathname;
									const newSearch = search.split('&');
									const nLength = newSearch.length;
									const pathSearch = newSearch[nLength-1].replace('preview','edit');
									window.location.href = pathname+""+newSearch[0]+"&"+pathSearch;
								}
								break;
							case 'p':
								//On ctrl+p save & preview
								event.preventDefault();
								document.getElementById('SaveAndPreview').click();
								break;
							case 'd':
								event.preventDefault();
								document.getElementById('previewDeleteButton').click();
								break;
							case 'x':
								if(data1.AdjustableAmount == 'enable'){
									if (confirm('Are you sure? You want to save adjustment amount.')) {
										$('#saveAdjAmtButton').click();
									}else{
										$('.close-modal').off('click');
									}
								}else{
									$('#saveAdjAmtButton').attr('disabled', false);
									$("#DropDownModal").modal("hide"); 
								}

						}
					}

					if (event.altKey || event.metaKey) {
						switch (String.fromCharCode(event.which).toLowerCase()) {
							case 'a':
								//On alt+a save & open new form
								event.preventDefault();
								document.getElementById('SaveUpdateAddMore').click();
								break;
							case 'f':
								//On alt+f Find from Menu
								event.preventDefault();
								$("#mySearch").focus();
								$('.sidebar-toggle.hidden-xs').click();
								break;
							// case '1':
							// 	//On alt+1 
							// 	event.preventDefault();
							// 	$("#kreon-grid-aprodid").focus();
							// 	// $('.sidebar-toggle.hidden-xs').click();
							// 	break;
							// case '2':
							// 	//On alt+2
							// 	event.preventDefault();
							// 	$("#kreon-grid-bprodid").focus();
							// 	// $('.sidebar-toggle.hidden-xs').click();
							// 	break;
							case 'n':
								//On alt+n listview open new form
								event.preventDefault();
								if ($('#formAddNewBtn').length) {
									$('#formAddNewBtn')[0].click();
								}

								// const search = window.location.search;
								// const substr = 'view=1';
								// if(search.includes(substr)){
								// 	const pathname = window.location.pathname;
								// 	const newSearch = search.split('&');
								// 	const newUrl = pathname+"?"+newSearch[1];
								// 	window.location.href = newUrl;
								// }
								break;
							case 'g':
								//On alt+g grid plus button press
								// var targetIdSplit = event.target.id.split('-');
								// var gridSerialNo = targetIdSplit[2].charAt(0);
								// $(".add"+gridSerialNo).click();

								// alert(targetIdSplit);
								// alert(event.currentTarget.parentNode);
								// alert(event.target.parentElement.parentElement.id);
								var tmp = event.target.parentElement;
								
								do{
									tmp = tmp.parentElement;
									console.log("tmp",tmp);
									// alert(tmp.tagName);
								}while(tmp.tagName != 'TABLE');
								var panelID = tmp.parentElement.id;
								
								var updateId = $('#panel'+panelID.slice(-1)).find('#GridTable').find('tbody > tr:first > td:last').find('.update'+panelID.slice(-1)).attr('id');
								console.log("updateId",updateId);
								if(updateId == undefined){
									$(".add" + panelID.slice(-1)).click();
								}else{
									$(".update" + panelID.slice(-1)).click();
								}
								break;
							case 'k':
								$(event.target).next('a').click();

							// case 'e':
							// 	//On alt+e preview edit form
							// 	event.preventDefault();
							// 	if ($('#previewEditButton').length) {
							// 		$('#previewEditButton')[0].click();
							// 	}

						}
					}
				});
			});

			//in bank reco popup on Alt + K focus move to next row cleardt field
			$(document).on('keydown', 'input[name="cleardt"]', function (e) {
				if (e.altKey && e.key.toLowerCase() === 'k') {
					e.preventDefault();
					
					var $inputs = $('input[name="cleardt"]'); // all cleardt inputs
					console.log("input",$inputs.val());
					var index = $inputs.index(this);          // current input index

					if (index !== -1 && index < $inputs.length - 1) {
						var $currentInput = $(this);
						var $nextInput = $inputs.eq(index + 1); // get the next input element
						var currentVal = $currentInput.val(); // get value of clicked/active input
						$nextInput.val(currentVal);            // set it to next input
						$nextInput.focus();                      // move focus to the next input

						// Position the cursor at the end of the text value
						if ($nextInput.val()) {
							handleBankRecoDateChange($nextInput[0]); // validate
						}
					}
				}
			});

			function searchMenu() {
				var input, filter, ul, li, a, i;
				input = document.getElementById("mySearch");
				filter = input.value.toUpperCase();
				ul = document.getElementById("texMenu");
				li = ul.getElementsByTagName("li");

				for (i = 0; i < li.length; i++) {
					a = li[i].getElementsByTagName("a")[0];
					// console.log(a.innerHTML.replace(/(<([^>]+)>)/ig,""), '=>',  a.innerHTML.replace(/(<([^>]+)>)/ig,"").toUpperCase().indexOf(filter))
					if (a.innerHTML.replace(/(<([^>]+)>)/ig,"").toUpperCase().indexOf(filter) > -1 ) {
						// For 2nd level
						$(li[i]).closest('ul').closest('li').show();
						$(li[i]).closest('ul').closest('li').addClass('nav-expanded');
						// For 3rd level
						$(li[i]).closest('ul').closest('li').closest('ul').closest('li').show();
						$(li[i]).closest('ul').closest('li').closest('ul').closest('li').addClass('nav-expanded');
						li[i].style.display = "";	
					} else {
						li[i].style.display = "none";
					}
				}
			}
			// $(document).ready(function(){
				
			// });
		</script>

		<style> 
    		
    		@font-face {
                font-family: PoppinsR;
                src: url("fonts/Poppins-Regular.ttf");
            }
              
            body {
                font-family: PoppinsR;
                color: #353535;
            }
            body .btn-primary {
                background-color: #09284e;
                border-color: #09284e;
            }
			@media (min-width: 768px){
				.userbox{
					float: right;
				}
				.content-body {
					padding: 20px;
				}
			}
			.panel-actions{
				position: absolute;				
			}
			.userbox{
				margin-right: 26px;
				margin-top: 12px;
			}
			.header-right{
				height: 0 !important;
			}
			.required { 
				font-size: 1em !important; 
			} 
			.nano-content{
				right:9px !important;
			}
			html.sidebar-left-xs .sidebar-left ul.nav-main li i {
				font-size: 1.6rem;
			}
			.header {
				border-top: 1px solid #EDEDED;
			}
			
			ul.nav-main li a { color: #ffffff;}
			ul.nav-main > li > a:hover, ul.nav-main > li > a:focus {
				background-color: #808182;
			}
			ul.nav-main > li {
				background-color: #09284e;
			}
			.page-header { background: #09284e; }
			.sidebar-left .sidebar-header .sidebar-toggle{ background: #09284e !important; }
			
			@media only screen and (min-width: 768px){
				html.fixed .sidebar-left .nano-content {
					background-color: #09284e !important;
				}
				html.no-overflowscrolling .sidebar-left .nano{
					background: #09284e;
					box-shadow: -5px 0 0 #2F3139 inset;
				}
				.sidebar-left .sidebar-header .sidebar-title {
					background: #09284e;
				}
				.nano-content {
					width:218px;
				}
			}
			
			/* Loader css */
			#loader {
				border: 12px solid #f3f3f3;
				border-radius: 50%;
				border-top: 12px solid #3498db;
				width: 70px;
				height: 70px;
				animation: spin 1s linear infinite;
			}
			
 
			.center {
				position: absolute;
				top: 0;
				bottom: 0;
				left: 0;
				right: 0;
				margin: auto;
			}
 
			@keyframes spin {
				100% {
					transform: rotate(360deg);
				}
			}

			.select2_dropdown_readonly {
				pointer-events : none!important;
				background: #eee!important;
			}

			.select2-container {
				/* vertical-align: 32px; */
			}

			.is-invalid .select2-container--default .select2-selection--single {
				border-color: #dc3545;
			}
			ul.nav-main li .nav-children {
    			background: #061528;
			}
			@media only screen and (min-width: 768px) {
				html.scroll .sidebar-left .nano, html.boxed .sidebar-left .nano, html.sidebar-left-big-icons .sidebar-left .nano {
					position: relative;
					overflow: hidden;
				}

				html.sidebar-left-xs .sidebar-left ul.nav-main li .nav-children li a {
					padding-left: 18px;
				}
				html.sidebar-left-xs.sidebar-left-collapsed .sidebar-left {
					width: 45px;
				}
				html.fixed.sidebar-left-collapsed .content-body {
					margin-left: 40px;
				}
				.content-body {
					padding: 10px;
				}
				html.fixed.sidebar-left-collapsed .page-header {
					left: 45px;
				}
				html.fixed .page-header {
					top: 40px;
				}
				html.fixed .sidebar-left{
					top: 40px; 
				}
				html.fixed .inner-wrapper {
					padding-top: 92px;
				}
			}
			ul.nav-main > li > a {
				padding: 10px 10px;
			}
			ul.nav-main li .nav-children li a {
				padding: 2px 15px 2px 57px;
			}
			ul.nav-main li .nav-children {
				padding: 6px 0;
			}
			ul.nav-main li .nav-children .nav-children li a {
				padding: 2px 15px 2px 82px;
			}
			ul.nav-main li .nav-children li a:after {
				padding: 2px 10px;
			}
			ul.nav-main li.nav-parent > a:after {
				padding: 8px 10px;
			}
			html.no-overflowscrolling .nano > .nano-pane {
    			width: 5px;
			}
			.sidebar-left .sidebar-header .sidebar-toggle i{
				margin-left: 20px;
			}
			.header {
    			height: 40px;
			}
			.header .logo {
				float: left;
				margin: 0;
			}
			.userbox {
				margin-right: 26px;
				margin-top: 6px;
			}
			table.dataTable thead .sorting {
				/* background-image: url(../images/sort_both.png); */
				background: none;
			}

			.thHidden{
				display:none;
			}

			#GridTable tbody tr td:last-child:focus-within{
				outline: 1px auto rgba(0, 150, 255, 1);
				-webkit-outline: 1px auto rgba(0, 150, 255, 1);
				-moz-outline: 1px auto rgba(0, 150, 255, 1);
				-ms-outline: 1px auto rgba(0, 150, 255, 1);
				-o-outline: 1px auto rgba(0, 150, 255, 1);
				/* Use a border to apply the outline */
				border: 1px solid rgba(0, 0, 0, 0);
			}
			.listview-actions {
				display: flex;
				gap: 2px;
			}

			/* By default, show company name and hide logo */
			.company-name {
				display: inline;
			}

			.company-logo {
				display: none;
			}

			/* On mobile screens (max-width: 768px), hide company name and show logo */
			@media (max-width: 767px) {
				.company-name {
					display: none;
				}

				.company-logo a{
					width: 150px !important;
					overflow: hidden;
					display: block;
					text-overflow: ellipsis;
					white-space: nowrap;
					color: white  !important	;
				}
				
				.company-logo {
					display: block;
				}
				.header .logo-container {
					height: 40px;
				}
				.header .logo-container .logo {
        			line-height: 35px !important;
				}
				.userbox:after {
					height: 48px !important;
				}
				.header .toggle-sidebar-left {
    				top: 5px !important;
				}
				.page-header, .page-header h2, .page-header .sidebar-right-toggle {
    				height: 35px !important;
    				line-height: 35px !important;
				}
				.page-header .sidebar-right-toggle i {
					line-height: 38px;
				}
				.page-header {
					padding-right: 35px;
				}

				/* .page-header h2 {
					font-size: 14px;
					padding: !important;
				} */
			}

			/* Sp sql modal div style */
			.company-groups {
				background-color: #f0f8ff;   /* Light blue background */
				border-left: 5px solid #007bff; /* Blue left border */
				padding: 10px 15px;
				margin-bottom: 15px;
				font-size: 15px;
				font-weight: 500;
				color: #333;
				border-radius: 4px;
			}
			.company-groups strong {
				color: #007bff;
			}
		</style>
	</head>
	<body>
		<section class="body">
			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="#" class="logo">
						<img src="assets/images/kreon-logo.png" height="35" alt="" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
			
					<span class="separator"></span>
					<div class="header-right">
						<ul class="notifications" style="margin:4px 145px 0 0!important">
							<li class="">
								<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-bell"></i>
									<span class="badge"><?php echo $getNotificationResult['num_rows']; ?></span>
								</a>
								<div class="dropdown-menu notification-menu" style="">
									<div class="notification-title">
										<span class="float-right badge badge-default"><?php echo $getNotificationResult['num_rows']; ?></span>
										Task Alerts
									</div>
									<div class="content" style="overflow: auto;max-height: 80vh;">
										<ul>
											<?php foreach($getNotificationResult['result_set'] as $row){ ?>
												<li>
													<a href="requirements.php?NotifID=<?php echo $row['TaskID']; ?>" target="_blank" class="clearfix">
														<div class="image">
															<i class="fa fa-tasks bg-success text-light"></i>
														</div>
														<span class="title"><?php echo $row['Notif_Title']; ?></span>
														<span class="message"><?php echo timeAgo($row['CreatedAt']->format('d-m-Y h:i A')); ?></span>
													</a>
												</li>
											<?php } ?>
										</ul>				
										<hr>
										<div class="text-right">
											<a href="requirements.php" class="view-more">View All</a>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				
					<span class="separator"></span>
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<div class="profile-info" data-lock-name="" data-lock-email="">
								<span style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 170px;" class="name"><?php echo $name; ?></span>
								<!-- .'<br> '.$loggeduser -->
								<span class="role"><?php echo $accounttype; ?></span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="change-password.php"><i class="fa fa-user"></i> Change Pwd</a>
								</li>
								<!--li>
									<a role="menuitem" tabindex="-1" href="#"><i class="fa fa-cog"></i> My Profile</a>
								</li-->
								<?php if($_SESSION['Category'] == 2) { ?>
								<li>
									<a role="menuitem" tabindex="-1" target="_blank" href="logs/<?php echo $_SESSION['email'] ?>.log"><i class="fa fa-cog"></i> DevLogs</a>
								</li>
								<?php } ?>
								<!-- <li>
									<a role="menuitem" tabindex="-1" href="requirements.php"><i class="fa fa-tasks"></i> Requirements</a>
								</li> -->
								<li>
									<a role="menuitem" tabindex="-1" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
					
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<input type="text" class="form-control" id="mySearch" onkeyup="searchMenu()" placeholder="Search(Alt+F)...">

								<?php echo $menubar; ?>						
							</nav>				
							<hr class="separator" />
						</div>
				
					</div>
				
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2><?php isset($k_page_title) ? $k_page_title : "No Title"; ?></h2>
						
						<div class="right-wrapper text-end">
							<ol class="breadcrumbs">
								<li><a target="_self" href="./company.php"><?php echo $_SESSION['dbCompanyName']; ?></a></li>
							</ol>

							<!-- Show company name by default -->
							 
							<!-- <li class="company-name">
								<a target="_self" href="./company.php"><?php echo $_SESSION['dbCompanyName']; ?></a>
							</li> -->

							<!-- Show logo on mobile -->
							<li class="company-logo">
								<a target="_self" href="./company.php">
									<?php echo $_SESSION['dbCompanyName']; ?>
								</a>
							</li>

							
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>

						<!-- Logo for Mobile View -->
						<!-- <div class="logo-mobile-view">
							<img src="path/to/logo.png" alt="Company Logo" class="mobile-logo">
						</div> -->
					</header>
					<?php 
						$saveNoify = isset($_GET["save"]) ? $_GET["save"] : 0;
						if($saveNoify > 0){ ?>
					<div class="alert alert-success alert-dismissible show" style="margin-top: 0px;">
						<strong>Success!</strong> Your entry has been saved successfully.
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
					<?php } ?>
					<!-- start: page -->
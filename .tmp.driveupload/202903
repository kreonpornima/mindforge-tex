<?php 
	session_start();
    require_once ('dbClass.php');
	// echo $_SESSION['ConnectionError'];
	if(!isset($_SESSION['Category'])) {
		echo '<script>window.location.replace("logout.php");</script>';
		exit;
	}
	$group_id = isset ($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;
	$role_id = isset ($_SESSION['access']) ? $_SESSION['access'] : 0;
	$userCategory = isset ($_SESSION['Category']) ? $_SESSION['Category'] : 0;
	
	if($userCategory == 1){
		$sql = "SELECT a.* FROM CompanyRoleAccess Right Join (
			Select Aireg.ID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
			AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
			AiGroup.Label as GroupName, AiGroup.ID as GroupID From Aireg 
			LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
			LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
			LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID 
			WHERE AiGroup.ID = '".$group_id."') a ON CompanyRoleAccess.RegID = a.ID where CompanyRoleAccess.RoleID = '".$role_id."'";
		$results = db::getInstanceMaster()->db_select($sql);
		
	}elseif($userCategory == 2){
		
		// Check Developer company access
		if($_SESSION['user_id'] == 1020 || $_SESSION['user_id'] == 1025 || $_SESSION['user_id'] == 1019 || $_SESSION['user_id'] == 1018){
			$sql = "SELECT a.* FROM CompanyRoleAccess Right Join (
			Select Aireg.ID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
			AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
			AiGroup.Label as GroupName, AiGroup.ID as GroupID From Aireg 
			LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
			LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
			LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID 
			) a ON CompanyRoleAccess.RegID = a.ID Order By a.CompanyName, a.DivisionID, a.Year DESC";
		}else{
			$sql = "SELECT a.* FROM CompanyRoleAccess Right Join (
			Select Aireg.ID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
			AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
			AiGroup.Label as GroupName, AiGroup.ID as GroupID From Aireg 
			LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
			LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
			LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID 
			) a ON CompanyRoleAccess.RegID = a.ID INNER JOIN map_developer_company_access mca
			ON a.GroupID IN (
				SELECT GroupID 
				FROM map_developer_company_access 
				WHERE UserID = ".$_SESSION['user_id']."
			) Order By a.CompanyName, a.DivisionID, a.Year DESC";
		}
		$results = db::getInstanceMaster()->db_select($sql);
		
	}elseif($userCategory == 3){
		$sql = "SELECT Aireg.ID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
			AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
			AiGroup.Label as GroupName, AiGroup.ID as GroupID From Aireg 
			LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
			LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
			LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID WHERE AiGroup.ID='".$group_id."'";
		$results = db::getInstanceMaster()->db_select($sql);
	}else{
		echo "User category not found. Please contact administrator.";
		exit;
		
	}
	// print_r($results);
	$rows = $results['result_set'];
	$array = array("data" => $rows);
	$jsonData = json_encode($rows);
	echo "<script>var users = $jsonData; </script>";
	
?>
<html class="fixed">
	<head>
		<style>
		h1.title.text-uppercase.text-weight-bold.m-none {
			color: #0088cc !important;
			background: #ffffff !important;
		}
		</style>

		<!-- Basic -->

		<meta charset="UTF-8">
		<meta name="keywords" content="Login to Kreon" />
		<meta name="description" content="">
		<meta name="author" content="">
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<!-- <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" /> -->
		<!-- <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" /> -->
		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />
		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">
		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
		<script src="assets/vendor/jquery/jquery.js"></script>

		
		<script>

			$(document).ready(function(){
				$('#company').focus();

				// $('#company').change(function(){
				// 	alert(thiss.value)
				// 	var CompanyId = thiss.value;
				// 	if(CompanyId){
				// 		// console.log(users);
				// 		RegData = users.filter(user => user.CompanyID == CompanyId);
	
				// 		const uniqueDivisionData = Array.from(RegData.reduce((a, o) => a.set(o.DivisionID, o), new Map()).values());
						
				// 		$("#division").empty();
				// 		$("#year").empty();
				// 		$("#DivisionDiv").show();
				// 		$("#YearDiv").show();
				// 		$("#ButtonDiv").show();
	
				// 		if(uniqueDivisionData.length > 1){
				// 			$("#division").prepend("<option value='0'></option>");
				// 		}
				// 		for(var i=0; i < uniqueDivisionData.length; i++){
				// 			$('#division').append($("<option></option>")
				// 				.attr("value", uniqueDivisionData[i]['DivisionID'])
				// 				.text(uniqueDivisionData[i]['DivisionName']));	
				// 		} 
	
				// 		if(uniqueDivisionData.length == 1){
				// 			$("#DivisionDiv").hide();
				// 			const uniqueYearData = Array.from(RegData.reduce((a, o) => a.set(o.Year, o), new Map()).values());
	
				// 			for(var i=0; i < uniqueYearData.length; i++){
				// 				$('#year').append($("<option></option>")
				// 					.attr("value", uniqueYearData[i]['Year'])
				// 					.text(uniqueYearData[i]['Year']));	
				// 			}
				// 		}
				// 	}
				// });
				// console.log(users);
				$('#division').change(function(){
					var DivisionId = this.value;
					RegData = users.filter(user => user.DivisionID == DivisionId);
					const uniqueYearData = Array.from(RegData.reduce((a, o) => a.set(o.Year, o), new Map()).values());
					
					console.log('called');
					$("#year").empty();
					for(var i=0; i < uniqueYearData.length; i++){
						$('#year').append($("<option></option>")
							.attr("value", uniqueYearData[i]['Year'])
							.text(uniqueYearData[i]['Year']));
					} 
					// $("#year").val('<?php echo $_SESSION['dbYear']; ?>').trigger('change');
				});

				$('#btnSession').click(function() {
					var companyID = $("#company").val();
					var divisionID = $("#division").val();
					var yearID = $("#year").val();
					
					// alert(companyID +" "+ divisionID +" "+ yearID);
					$.ajax({
						type : 'POST',
						dataType: 'json',
						data : { companyID:companyID, divisionID:divisionID, yearID:yearID},
						url : 'storeSession.php',
						success : function(result){
							// console.log(result); 
							window.location.href = "home.php";
						}
					});
				});

			});
		</script>
	</head>
	<body>
		<section class="body-sign">
			<div class="center-sign">
				<div class="panel panel-sign">
					<div class="panel-body">
							<?php
								$connection_error = isset ($_SESSION['ConnectionError']) ? $_SESSION['ConnectionError'] : '';
								// echo "above".$connection_error;
								if($connection_error != ""){									
							?>
								<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<strong>Sorry!</strong> Unable to connect server. Check your credentials.
								</div>
							<?php
								// Unset the session variable after displaying the alert so it doesn't show again on refresh
								// unset($_SESSION['ConnectionError']);
								}
								if(isset($_SESSION['dbCompanyName'])){
									echo "<h5><b>Selected : ".$_SESSION['dbCompanyName']."</b></h5>";
								}
							?>
							<!-- <form action="company_db.php" method="post"> -->
							<?php 
							$Companies = [];
							for ($j=0; $j<sizeof($results['result_set']); $j++) {
								array_push($Companies,(array("ID"=>$results['result_set'][$j]['CompanyID'],"Name"=>$results['result_set'][$j]['CompanyName'])));
							}
							$uniqueCompanies = array_map("unserialize", array_unique(array_map("serialize",$Companies)));
							$uniqueCompanies2 = array_values($uniqueCompanies);
							// print_r($uniqueCompanies2);
							?>
							<div class="form-group mb-lg">
								<label>Company</label>
								<div class="input-group input-group-icon">
									
									<select name="company" id="company" class="form-control input-lg" onchange="getCompany(this.options[this.selectedIndex].value)">
										<?php
											for($k=0; $k<sizeof($uniqueCompanies2); $k++){
												if((int)$_SESSION['dbCompany'] == (int)$uniqueCompanies2[$k]['ID'])
													echo '<option selected value="'.$uniqueCompanies2[$k]['ID'].'">'.$uniqueCompanies2[$k]['Name'].'</option>';
												else
													echo '<option value="'.$uniqueCompanies2[$k]['ID'].'">'.$uniqueCompanies2[$k]['Name'].'</option>';
											}
                                        ?>
                                    </select>
								</div>
							</div>

                            <div class="form-group mb-lg" id="DivisionDiv" style="display:none;">
								<label>Division</label>
								<div class="input-group input-group-icon">
									<select name="division" id="division" class="form-control input-lg" >
                                        
                                    </select>
								</div>
							</div>

							<div class="form-group mb-lg" id="YearDiv" style="display:none;">
								<label>Year</label>
								<div class="input-group input-group-icon">
									<select name="year" id="year" class="form-control input-lg" >
                                        
                                    </select>
								</div>
							</div>

							<div class="row" id="ButtonDiv" style="display:none;">
								<div class="col-sm-12">
									<button class="btn btn-primary" id="btnSession">Proceed</button>
									<p id="message" style="display:none; color: red;"></p>
									<div style="display:none;">
										<?php 
										// if (isset($_SERVER['HTTP_REFERER'])) {
										// 	$previousPage = $_SERVER['HTTP_REFERER'];
										// 	// echo "Previous page URL: " . $previousPage;
										// } else {
										// 	echo "No referrer available.";
										// }
										?>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</section>

		<?php
		// echo "below".$connection_error;
		// echo "hi".$connection_error;
		// var_dump($connection_error);
		// print_r($_SESSION);
			if($connection_error == "" && isset($_SESSION['dbHost'])){
				// Code to check if a user has multiple tabs open and is in edit mode. If they try to change the company, the 'Proceed' button should be disabled and an error message should be displayed.
				$checkTableExist = "SELECT * FROM information_schema.columns WHERE table_name='kFormEditLock'";
				$result = db::getInstance()->db_select($checkTableExist);
				// echo "=>" . $result['num_rows'];
				
				if ($result['num_rows'] == 0) {
					$query = "SELECT * FROM kFormEditLock 
						WHERE CompanyID = {$_SESSION['dbCompany']} 
						AND DivisionID = {$_SESSION['dbDivision']} 
						AND UserID = {$_SESSION['user_id']} AND isDeleted = 0";

					$queryresult = db::getInstance()->db_select($query);
					if($queryresult['num_rows'] > 1) 
						$lockmsg = 'There are '.$queryresult['num_rows'].' entries open in edit mode. Kindly close the entries/tabs & refresh this page. (If not logout and login again)';
					else 
						$lockmsg = 'There is an entry open in edit mode. Kindly close the entry & refresh this page.';
					if ($queryresult['num_rows'] > 0) {
						echo '<script> 
							// Disable the button
							$("#btnSession").prop("disabled", true);

							// Show the message
							$("#message").text("'.$lockmsg.'").show();
						</script>';
					}
				}
			}
		?>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<!-- <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
		<!-- <script src="assets/vendor/magnific-popup/magnific-popup.js"></script> -->
		<!-- <script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script> -->
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>
		<script>
			var companyId = $('#company').val();
			getCompany(companyId);
		
			function getCompany(thiss){
				var CompanyId = thiss;
				if(CompanyId){
					RegData = users.filter(user => user.CompanyID == CompanyId);

					const uniqueDivisionData = Array.from(RegData.reduce((a, o) => a.set(o.DivisionID, o), new Map()).values());
					
					$("#division").empty();
					$("#year").empty();
					$("#DivisionDiv").show();
					$("#YearDiv").show();
					$("#ButtonDiv").show();

					if(uniqueDivisionData.length > 1){
						$("#division").prepend("<option value='0'></option>");
					}
					for(var i=0; i < uniqueDivisionData.length; i++){
						$('#division').append($("<option></option>")
							.attr("value", uniqueDivisionData[i]['DivisionID'])
							.text(uniqueDivisionData[i]['DivisionName']));	
					} 

					if(uniqueDivisionData.length == 1){
						$("#DivisionDiv").hide();
						const uniqueYearData = Array.from(RegData.reduce((a, o) => a.set(o.Year, o), new Map()).values());

						for(var i=0; i < uniqueYearData.length; i++){
							$('#year').append($("<option></option>")
								.attr("value", uniqueYearData[i]['Year'])
								.text(uniqueYearData[i]['Year']));	
						}
					}
					// $("#division").val('<?php echo $_SESSION['dbDivision']; ?>').trigger('change');
					// $("#year").val('<?php echo $_SESSION['dbYear']; ?>').trigger('change');
				}
			}

		</script>

	</body>

</html>

<?php 



// if(is_resource($connect)) mysql_close($connect);

?>


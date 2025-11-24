<?php
$FormID = isset($_REQUEST['form']) ? $_REQUEST['form'] : 0;
if($viewpage == 1){ //VIEW MODE
	
}else{ 

	?>
	<script>
		// This section added for 4921 adjustment form
		document.addEventListener('DOMContentLoaded', function() {
			const adjField = document.getElementById('adjustmentFormId');
			const cancelButton = document.getElementById('cancelButton');
			const formIdFromPHP = '<?php echo $FormID; ?>';

			// Check if adjustmentFormId input exists in form
			if (adjField) {
				const adjValue = adjField.value.trim();
				var previousFormId = $('#entryid').val();
				// ✅ Condition: field exists AND value equals PHP FormID
				if (adjValue !== '' && adjValue != '4921' && formIdFromPHP == 4921) {
					
					cancelButton.setAttribute('href', '<?php echo $_SERVER["PHP_SELF"]; ?>?form=' + adjValue + '&preview='+previousFormId);

				} else {
					// Field present but value doesn't match FormID
					cancelButton.setAttribute('href', '<?php echo $_SERVER['PHP_SELF'] . "?view=1&form=$FormID"; ?>');
				}
			} else {
				// Input does NOT exist → keep default link
				cancelButton.setAttribute('href', '<?php echo $_SERVER['PHP_SELF'] . "?view=1&form=$FormID"; ?>');
			}
		});
	</script>
	<?php
	
	//ADD-EDIT MODE
	if(sizeof($code) <= 0){
		?><a href="<?php echo $_SERVER['PHP_SELF']."?view=1&form=$FormID"; ?>" class="btn btn-tertiary" id="cancelButton">CANCEL</a><?php 
	}else{
	$_SESSION['csrftoken'] = md5(uniqid(mt_rand(), true));
 	?>
	<div class="row">
		<div class="col-md-12">
			<label class="col-md-4 control-label"></label>
			<input  type="hidden" value="<?php echo $editID?>" name="editID" id="editID" /><br/>
			<input  type="hidden" value="<?php echo ($editID > 0) ? $caseSensitiveResultDbData['result_set'][0]['companyid'] : $_SESSION['dbCompany']; ?>" name="kreon-companyid" id="kreon-companyid" />
			<input  type="hidden" value="<?php echo ($editID > 0) ? $caseSensitiveResultDbData['result_set'][0]['divisionid'] : $_SESSION['dbDivision']; ?>" name="kreon-divisionid" id="kreon-divisionid" />
			<input  type="hidden" value="<?php echo ($editID > 0) ? $caseSensitiveResultDbData['result_set'][0]['yearcode'] : $_SESSION['dbYear']; ?>" name="kreon-yearcode" id="kreon-yearcode" /><br/>
			<?php 

				if($saveAndPreview == 1){
					echo '<input  type="submit" name="saveButton" id="SaveAndPreview" onclick="validateOnButton(this);" value="SaveAndPreview" class="btn btn-primary" title="Ctrl+P">';
				}
			?>
			
			<?php 
				// echo $saveBtn;
				if($saveBtn == 1){
					echo '<input  type="submit" name="saveButton" id="SaveUpdate" onclick="validateOnButton(this);"  value="'.$buttonname.'" class="btn btn-primary" title="Ctrl+S">';
				}
			?>
			<?php 
				if($saveAddMore == 1){
					echo '<input  type="submit" name="saveButton" id="SaveUpdateAddMore" onclick="validateOnButton(this);" value="'.$buttonsaveaddmore.'" class="btn btn-primary" title="Alt+A">';
				}
				if($editID == 0){ ?>
				<a href="<?php echo $_SERVER['PHP_SELF']."?form=$FormID"; ?>" class="btn btn-secondary" id="clearButton">CLEAR</a>
			<?php } ?>

			<a href="<?php echo $_SERVER['PHP_SELF']."?view=1&form=$FormID"; ?>" class="btn btn-tertiary" id="cancelButton">CANCEL</a>

			<?php if(isset($isPreview) == 1){ 

				//check invoice form ewaybill & einvoice bill if anyone generated then don't allow to edit & delete from preview page
				// $invoiceForm = "select * from kmainforms where  formtype in ('INV','BIL','SGR','PGR') AND TableName='acc_trns' AND FormId=$FormID";
				// $getInvForm = db::getInstance()->db_select($invoiceForm, "FC-44: Cl-");

				$formType = isset($viewSettings[17]) ? trim($viewSettings[17]) : '';

				if (in_array(strtoupper($formType), ['INV', 'BIL', 'SGR', 'PGR'])) {
					$checkEwaybill = "SELECT 1 FROM acc_ewaybill_up WHERE entryid = $editID AND Response_EwaybillNo <> '' AND API_Status = 1";
					$getEwaybill = db::getInstance()->db_select($checkEwaybill, "FC-47: Cl-");

					$checkEInvoice = "SELECT 1 FROM acc_einvoice_up WHERE entryid = $editID AND Response_Status = 'act'";
					$getEInvoice = db::getInstance()->db_select($checkEInvoice, "FC-50: Cl-");
				}
		
				?>

					<?php if($PreviewBackBtn == 1){ ?>
						<a href="<?php echo $_SERVER['PHP_SELF']."?view=1&form=$FormID"; ?>" id="backButton" class="btn btn-primary">Listview</a>
					<?php } ?>

					<?php if($PreviewAddNewBtn == 1){ 
						//check add button access
						if($access['canAdd']){
					?>
						<a href="<?php echo $_SERVER['PHP_SELF'] . '?form=' . $FormID . '&OpenMode=add'; ?>" id="formAddNewBtn" class="btn btn-primary">ADD<span style="font-size: smaller;">(Alt+N)</span></a>
					<?php }} ?>

					<?php if($PreviewEditBtn == 1){ 
						//check edit button access
						if($access['canEdit']){
							//IF ewaybill & einvoicebill record not found then show edit button
							if($getEwaybill['num_rows'] == 0 && $getEInvoice['num_rows'] == 0){
					?>
						<a href="<?php echo $_SERVER['PHP_SELF']."?form=$FormID&edit=$editID"; ?>" id="previewEditButton" class="btn btn-primary">EDIT<span style="font-size: smaller;">(Ctrl+E)</span></a>
					<?php }}} ?>

					<?php if($PreviewDeleteBtn == 1){ 
						//check delete button access
						if($access['canDelete']){
							//IF ewaybill & einvoicebill record not found then show delete button
							if($getEwaybill['num_rows'] == 0 && $getEInvoice['num_rows'] == 0){
					?>
						
						<a href="<?php echo $_SERVER['PHP_SELF']."?view=1&form=$FormID&delID=$editID"; ?>" id="previewDeleteButton" class="btn btn-danger" >DELETE <span style="font-size: smaller;">(Ctrl+D)</span></a>
					<?php }}} ?>
					
					<?php if((int)$viewSettings[16] > 0){  //id="list-view-print-btn"?>
						<a href="javascript:void(0);" id="isVoucherPrintBtn" class="btn btn-primary" onclick="ListViewVoucherPrint(<?= $editID ?>)">Print</a>
					<?php } ?>

					<?php 
					//$BtnEinvoice = $BtnEwaybill = $BtnGstr1 = $BtnGstr2 = 0;
					$SPName = 'sp_API_ValidateEinvoice';
					$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
					$sqlresult = db::getInstance()->db_select($sql, "FC-93: Cl-");

					// if($access['canEinvoice']){
						if($BtnEinvoice == 1 && $sqlresult['result_set'][0]['found'] == 1){
							echo '<button type="button" id="previewBtnEinvoice" class="btn btn-primary" onclick="getFormExternalAPIData_Einvoice(event, \'previewBtnEinvoice\',\'einvoice\');">E-invoice</button>';
							// echo '<button type="button" id="previewBtnEway" class="btn btn-primary" onclick="showEwayPopup(event, \'previewBtnEway\',\'eway_data\');">E-way Bill</button>';
						} 
					// }
					$SPName = 'sp_API_ValidateEwaybill';
					$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
					$sqlresult = db::getInstance()->db_select($sql, "FC-103: Cl-");
					// if($access['canEwayBill']){
						if($BtnEwaybill == 1 && $sqlresult['result_set'][0]['found'] == 1){
							// echo '<button type="button" id="previewBtnEinvoice" class="btn btn-primary" onclick="getFormExternalAPIData_Einvoice(event, \'previewBtnEinvoice\',\'einvoice\');">E-invoice</button>';
							echo '<button type="button" id="previewBtnEway" class="btn btn-primary" onclick="showEwayPopup(event, \'previewBtnEway\',\'eway_data\');">E-way Bill</button>';
						} 
					// }

					$SPName = 'sp_BarcodePrint_'.$FormID;
					$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
					$sqlresult = db::getInstance()->db_select($sql, "FC-113: Cl-");
					// if($access['canBarccodePrint']){
						if($sqlresult['result_set'][0]['found'] == 1){
							echo '<button type="button" id="isBarcodePrintBtn" class="btn btn-primary" onclick="ListViewBarcodePrint('.$editID.');">Barcode Print</button>';
						}
					// }
					
					?>
					
					<div class="modal fade" id="btnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel1"></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body"></div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
					<script>
						function showEwayPopup(event, btnID, APICase){
							// $("#loadingMessage").show();
							console.log(APICase);
							// $("#" + btnID).attr("disabled", true).addClass("disabled");
							event.preventDefault();
							// return false;
							$.ajax({
								type : 'POST',
								dataType: 'json',
								data : { case : APICase, FormID:<?php echo $FormID; ?>, EntryID: <?php echo $editID; ?>},
								url : "getFormExternalAPIData.php",
								success : function(result){
									console.log(result);
									$("#" + btnID).attr("disabled", false).removeClass("disabled");
									var res = result;
									if(res['error'] > 0){
										alert(res['error_msg']);
									}else{
										var trspData = null;
										if(res['output']['TransportData']['result_set'][0] !== undefined)
											trspData = res['output']['TransportData']['result_set'][0];
										$('#btnModal').modal('show');
										$('#btnModal .modal-title').html('E-way Bill');
										let table = "<h4>Transport Details</h4><div id='eway_post_data'><table class='table table-bordered' border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; text-align: left;'>";
										table += "<tr><td>Name</td><td><input type='text' name='eway_name' class='form-control' value='"+trspData['Transportername']+"' /></td></tr>";										
										table += "<tr><td>GST No</td><td><input type='text' name='eway_gstno' class='form-control'  value='"+trspData['Transporterid']+"'/></td></tr>";										
										// table += "<tr><td>LR No</td><td><input type='text' name='eway_lrno' class='form-control' /></td></tr>";										
										// table += "<tr><td>LR Date</td><td><input type='text' name='eway_lrdt' class='form-control' /></td></tr>";										
										table += "<tr><td>Mode</td><td><input type='text' name='eway_mode' class='form-control'  value='"+trspData['Transmode']+"'/></td></tr>";										
										// table += "<tr><td>Transport Type</td><td><input type='text' name='eway_ttype' class='form-control'  value='"+trspData['Transactiontype']+"'/></td></tr>";										
										table += "<tr><td>Vehicle No.</td><td><input type='text' name='eway_vnum' class='form-control'  value='"+trspData['Vehicleno']+"'/></td></tr>";										
										table += "<tr><td>Vehicle Type</td><td><input type='text' name='eway_vtype' class='form-control'  value='"+trspData['Vehicletype']+"'/></td></tr>";										
										table += "<tr><td>Distance</td><td><input type='text' name='eway_dist' class='form-control'  value='"+trspData['Transdistance']+"'/></td></tr>";
										table += "<tr><td></td><td><button type='button' id='submit_eway_data' class='btn btn-primary' onclick='getFormExternalAPIData_Eway(event, \"submit_eway_data\",\"eway\");'>Generate E-way Bill</button></td></tr></table></div>";										
										$('#btnModal .modal-body').html(table);
									}
								},
								error: function(xhr, status, error) {
									console.error('Failed to load data:', error);
									$("#" + btnID).attr("disabled", false).removeClass("disabled");
									// $("#loadingMessage").hide();
								}
							});
							return false;
						}
						
						function getFormExternalAPIData_Eway(event, btnID, APICase){
							$("#loadingMessage").show();
							// $("#" + btnID).addClass("disabled");
							console.log(APICase);
							$("#" + btnID).attr("disabled", true).addClass("disabled");
							event.preventDefault();

							let concatenatedString = '';
							$('#eway_post_data input').each(function () {
								let name = $(this).attr('name');
								let value = $(this).val();
								if (name) {
									concatenatedString += name + "='" + value + "'|";
								}
							});
							concatenatedString = concatenatedString.slice(0, -1);
							// return false;
							$.ajax({
								type : 'POST',
								dataType: 'json',
								data : { case : APICase, FormID:<?php echo $FormID; ?>, EntryID: <?php echo $editID; ?>, FormData : concatenatedString },
								url : "getFormExternalAPIData.php",
								success : function(result){
									console.log(result);
									$("#" + btnID).attr("disabled", false).removeClass("disabled");
									// var res = JSON.parse(result);
									var res = result;
									if(res['error'] > 0){
										alert(res['error_msg']);
									}else{
										// $('#btnModal').modal('show');
										// $('#btnModal .modal-title').html('E-Invoice');
										return;
										var json = res['output'];
									}
								},
								error: function(xhr, status, error) {
									console.error('Failed to load data:', error);
									$("#" + btnID).attr("disabled", false).removeClass("disabled");
									// $("#loadingMessage").hide();
								}
							});
						}

					</script>
					<script>
						function getFormExternalAPIData_Einvoice(event, btnID, APICase){
							$("#loadingMessage").show();
							// $("#" + btnID).addClass("disabled");
							console.log(APICase);
							$("#" + btnID).attr("disabled", true).addClass("disabled");
							event.preventDefault();
							// return false;
							$.ajax({
								type : 'POST',
								dataType: 'json',
								data : { case : APICase, FormID:<?php echo $FormID; ?>, EntryID: <?php echo $editID; ?> },
								url : "getFormExternalAPIData.php",
								success : function(result){
									console.log(result);
									$("#" + btnID).attr("disabled", false).removeClass("disabled");
									// var res = JSON.parse(result);
									var res = result;
									if(res['error'] > 0){
										alert(res['error_msg']);
									}else{
										$('#btnModal').modal('show');
										$('#btnModal .modal-title').html('E-Invoice');
										var json = res['output'];
										let table = "<table class='table table-bordered' border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; text-align: left;'>";
										table += "<thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";										
										for (const key in json) {
											if (json.hasOwnProperty(key)) { // Ensure it's a direct property
												let value = json[key] !== null ? json[key] : "N/A"; // Handle null values
												if (value.length > 70) {
													value = value.substring(0, 70) + "...";
												}
												var key1 = key.replace('Response_', '');
												if(key1 == 'QRCode')
													table += `<tr><td><strong>${key1}</strong></td><td><img width="100px" src="${value}" alt="Image" /></td></tr>`;
												else
													table += `<tr><td><strong>${key1}</strong></td><td>${value}</td></tr>`;
												// $code = "R".str_pad($variant,5,"0",STR_PAD_LEFT);;
												// include("barcode/sample.php");
												// echo "<p style='font-size: 16px;margin:0px;letter-spacing:1px'>" . $code . " " . $est . "</p>";
												// if(!$flag) echo "<p style='font-size: 16px;margin:0px;'>&nbsp;</p>";
											}
										}
										table += "</tbody></table>";
										$('#btnModal .modal-body').html(table);
										// alert(res['output']);
									}
									// $("#loadingMessage").hide();
								},
								error: function(xhr, status, error) {
									console.error('Failed to load data:', error);
									$("#" + btnID).attr("disabled", false).removeClass("disabled");
									// $("#loadingMessage").hide();
								}
							});
						}
					</script>
			<?php } 
				if(isset($isView) == 1){ ?>
					<a href="<?php echo $_SERVER['PHP_SELF']."?view=1&form=$FormID"; ?>" id="backButton" class="btn btn-primary">Back</a>
			<?php } ?>

			<!-- Added by pornima  -->

			<input type="hidden" name="kreonClickButton" id="kreonClickButton" value="">
			<input type="hidden" name="csrftoken" value="<?php echo $_SESSION['csrftoken'] ?? '' ?>">
		</div>
    </div>
</form>
<?php 
}
}

?>
		
	</div>
</section>

<!-- end: page -->
<?php	
	$k_footer_before = '';
	//if(is_resource($connect)) mysql_close($connect);
	include "k_files/k_footer.php";
?>
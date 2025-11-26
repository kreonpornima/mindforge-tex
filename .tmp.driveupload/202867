<?php 
//include "k_files/k_config.php";
$k_head_keywords = "";
$k_head_desc = "Admin Template";
$k_head_author = "KreonSolutions.com";
$k_head_login_check = 1;
$k_page_title = $k_head_title; 
include "k_files/k_header.php";
if($_SESSION['user_id']){
	db::getInstance()->enableLog = 1;
}

$k_table_title = $k_head_title = $k_table_log_button = $k_table_sqlsp_button;
$FormID = isset($FormID) ? $FormID : (isset($_GET['form']) ? $_GET['form'] : 0);
// $FormID = isset($FormID) ? $FormID : (isset($_GET['form']) ? $_GET['form'] : 0);
$ReportID = isset($_REQUEST['ReportID']) ? $_REQUEST['ReportID'] : (isset($ReportID) ? $ReportID : 0);
$k_debug = isset($k_debug) ? $k_debug : 0;
$radio = array();
//if($_SESSION["user_id"] == 1)    
$bypassUserRoles = 1; //else $bypassUserRoles = 0;
// if($FormID == 5217)   $k_debug=1;
$k_user_id = $_SESSION["user_id"];
// if($k_user_id == 1020)   $k_debug=1;
//include_once('dbClass.php');
if($k_user_id == 1020 ) echo "hhh".$_SESSION['dbName'];
// echo "hhh".$_SESSION['user_id'];
// echo "HHHH".$_SESSION['dbHost'];
// echo "HHHH".$_SESSION['dbCompany'];

function checkVariable($str){ //CHECK IF THERE IS A VARIABLE AND CONVERT IT
	if(strpos($str,"$") !== false){
		//echo "<br/>c".$cc = substr($str, strpos($str,"$"));	
		//echo "<br/>p".$pp = substr($cc,0,strpos($cc," "));
		$cc = substr($str, strpos($str,"$"));
		$pp = substr($cc,0,strpos($cc," "));
		$pp = " ". $pp;
		$ini = strpos($pp, "[");
		$ini += 1;
		$len = strpos($pp, "]", $ini) - $ini;
		$dd = substr($pp, $ini, $len);
		//replace Session for this below value
		return $_SESSION[$dd];
	}else{
		return $str;
	}
}

?>

<script>
	window.onload = function(e) { // Focus On first Input field
		// $('#form').find('input[type=text]').eq(0).focus();
		var url = window.location.href;
		if(url.indexOf("preview") != -1){
			console.log($("#form select.select2-hidden-accessible").length);
			// $("#form :input").prop("disabled", true);
			$("#form :input").not(".clickable-grid-input").prop("disabled", true);
			$(document).on('select2:open', function (e) {
				$('select.select2-hidden-accessible').each(function () {
					// Prevent it from opening on focus (e.g. via tabindex)
					$(this).select2('close');

					$(this).on('select2:opening select2:open', function (e) {
						e.preventDefault();
					});

					$(this).next('.select2').find('.select2-selection').css({
						'pointer-events': 'none',
						'background-color': '#eee',
						'cursor': 'not-allowed'
					});
				});
			});


			$("input[name='saveButton']").remove();
			$(".switch").css("pointer-events","none");
			$('#form a').not('.cutpack-btn-showinpreview').each(function(index) {
				const $a = $(this);
				console.log("a",$a);
				const $parentDiv = $a.parent();

				if ($a.has('img').length || $a.attr('id') === 'downloadImg') {
					// Prevent click on image
					$a.on('click', function(e) {
						if ($(e.target).is('img')) {
							e.preventDefault();
						}
					});

					// Hide the span sibling (e.g., the delete "X" button)
					$parentDiv.find('span').hide();
				}else if ($a.attr('id') === 'downloadBtn') {
					// Do nothing for downloadBtn (keep it visible)
					// Optionally, you can add custom logic here if needed.
				}  else {
					// Hide the <a> if no image
					$a.hide();
				}
			});
			$("#backButton").show();
			// $("input[id='previewEditButton']").show();
			$("#previewEditButton").show();
			$("#previewDeleteButton").show();

			if ($("#previewBtnEinvoice").length) $("#previewBtnEinvoice").removeAttr("disabled");

			if ($("#previewBtnEway").length) $("#previewBtnEway").prop("disabled", false).css("pointer-events", "auto").css("opacity", "1");
			$("#formAddNewBtn").show();

			//Adjustment button only enable in preview mode
			$("#adjamount")
				.prop("disabled", false)             // Enable the button
				.css("pointer-events", "auto")       // Restore pointer events
				.css("opacity", "1");


			//voucher print modal open in preview page. enabled some button & field here
			$("#isVoucherPrintBtn").show();
			$("#reportTemplateSelect").removeAttr('disabled');
			$("#printModalPrintBtn").removeAttr('disabled');
			$("#printModalCloseBtn").removeAttr('disabled');

			//barcode print modal open in preview page.
			// if ($("#previewBtnEinvoice").length) 
			$("#isBarcodePrintBtn").attr("disabled", false);
			$('#barcodeTemplateSelect').removeAttr('disabled');
			$('#barcodeModalPrintBtn').removeAttr('disabled');
			$('#barcodeModalCloseBtn').removeAttr('disabled');

			//Adjustment form button code
			$("#prevButton").attr("disabled",false);

			//SQL modal copy button code
			$("#copySPDefBtn").attr("disabled",false);

			$(".grid-barcode-btn").attr("disabled", false);

			// show payment Detail button 
			$("#ShowPaymentDetails").removeAttr('disabled');
	
		}
		/*
		if(url.indexOf("display") != -1){
			
			window.validateOnLostFocusSp = true;
			$("#form :input").prop("disabled", true);
			$(':file').parent().css('pointer-events','').css("cursor","not-allowed").css("background-color","#eee");
			$("input[name='saveButton']").hide();
			// $('#form select').css("cursor","not-allowed");
			$(".switch").css("pointer-events","none");

			$('#form a').each(function(index) {
				$(this).hide();
			});
			$("#backButton").show();
			$("#form :input").each(function() {
    			var formInputId= $(this).attr('id');
				if(formInputId.indexOf('-text') != -1){
					$('#'+formInputId).css('cursor','').css("cursor","not-allowed").css("background-color","#eee");

				}

				// if(formInputId.indexOf('MultyDDModal') != -1){
				// 	if($('#'+formInputId).prop('type') !="button"){
				// 		$('#'+formInputId).css('cursor','').css("cursor","not-allowed").css("background-color","#eee");
				// 	}
				// }
			});

			
			// $("input[id='previewEditButton']").show();
			// $("#previewEditButton").show();
			// $("#previewDeleteButton").show();

		}*/
	}


	$(document).on('keydown', '.custom-file-upload', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			// Find and click the file input inside this label
			$(this).find('input[type="file"]').trigger('click');
			e.preventDefault(); // prevent accidental form submits
		}
	});

	function openWindowWithPost(url, params, windowOptions) {
		
		if(url.length > 2){
			var form = document.createElement("form");
			form.setAttribute("method", "post");
			form.setAttribute("action", url);
			form.setAttribute("target", windowOptions);
			// form.setAttribute("target", newWindow.name);  // Set the form's target to the newly opened window


			for (var key in params) {
				if (params.hasOwnProperty(key)) {
					var hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", key);
					hiddenField.setAttribute("value", params[key]);

					form.appendChild(hiddenField);
				}
			}

			document.body.appendChild(form);
			form.submit();
			document.body.removeChild(form);
		}
	}


	// function PreviewForm(FormID,FieldName,EditId){
	// 	console.log(FormID,FieldName,EditId);
	// 	// Set window options (width, height)
	// 	var windowOptions = "width=800,height=600,resizable=yes,scrollbars=yes";

	// 	if(FieldName == 'adjamount1'){
	// 		openWindowWithPost("list-data.php?form=" + FormID, { prevFormid: <?php echo $FormID; ?>, partyid: $("#partyid").val(), editID: EditId, entryid:$("#editID").val()  },windowOptions); //editID: $("#editID").val(), 
	// 	}else{
	// 		openWindowWithPost("list-data.php?form=" + FormID, { prevFormid: <?php echo $FormID; ?>, partyid: $("#partyid").val(), entryid: $("#editID").val() },windowOptions);
	// 	}
	// }

	function load_data(is_variable,is_value){	
		var dataTable = $('#datatable-table').DataTable({
			"processing":true,
			"serverSide":true,
			"order":[],
			"pageLength": 25, // 👈 Default number of rows per page
			"ajax":{
				url:"fetch.php",
				type:"POST",
				data:{FormID:FormID,is_variable:is_variable,is_value:is_value}
			},
			// "columnDefs":[
			// 	{
			// 	"targets":[0],
			// 	"orderable":false,
			// 	},
			// ],
			orderCellsTop: true,
		});
	}

	//Bank reco on date change function
	// function handleBankRecoDateChange(thiss) {
	// 	// Get closest row
	// 	var $row = $(thiss).closest("tr");

	// 	var clearDt = $(thiss).val();
	// 	var entrydt = $row.find('input[name="entrydt"]').val();


	// 	// Convert to Date objects
	// 	var clearDate = new Date(clearDt);
	// 	var entrydt = new Date(entrydt);

	// 	// Normalize to only date part (removes time zone/offset issues)
	// 	clearDate.setHours(0, 0, 0, 0);
	// 	entryDate.setHours(0, 0, 0, 0);


    // 	// Check if date is between range
    // 	if (clearDate >= entrydt) {
	// 		console.log("✅ Date is within range");

	// 		var drAmount = parseFloat($row.find('input[name="dr_amount"]').val()) || 0;
	// 		var crAmount = parseFloat($row.find('input[name="cr_amount"]').val()) || 0;
	// 		var $adjInput = $('#PopupAdjamount');
	// 		var adjAmount = parseFloat($adjInput.val()) || 0;

	// 		// Prevent duplicate adjustment: use data attribute as a flag
	// 		if (!$row.data('adjusted')) {
	// 			if (crAmount === 0) {
	// 				// Subtract drAmount from adjAmount
	// 				adjAmount -= drAmount;
	// 			} else if (drAmount === 0) {
	// 				// Add crAmount to adjAmount
	// 				adjAmount += crAmount;
	// 			}

	// 			$adjInput.val(adjAmount.toFixed(2)); // update with two decimals
	// 			$row.data('adjusted', true); // mark row as adjusted
	// 		}

	// 	} else {
	// 		console.log("❌ Date is out of range");
	// 		alert("Date is outside the allowed range!");
	// 		$(thiss).val(''); // Reset the value
	// 		$row.data('adjusted', false); // allow adjustment again
	// 		return;
	// 	}
	// }

	function clearDate(thiss){
		// Find the related input and clear it
		var $row = $(thiss).closest("tr");
		var cleardt = $row.find('input[name="cleardt"]').val('');
		$("#pillContainer").show();

		// var drAmount = parseFloat($row.find('input[name="dr_amount"]').val()) || 0;
		// var crAmount = parseFloat($row.find('input[name="cr_amount"]').val()) || 0;
		var crdrAmount = parseFloat($row.find('input[name="amount"]').val()) || 0;
		var $adjInput = $('#PopupAdjamount'); // <-- fix here
		var adjAmount = parseFloat($adjInput.val()) || 0;
		var crdrSign = $row.find('input[name="sign"]').val();
		var rowID = $(thiss).closest("tr").find("td:first input").val();

		// Prevent duplicate adjustment
		if (!$row.data('adjusted')) {
			if (crdrSign === 'Cr') {
				adjAmount += Math.abs(crdrAmount);  // Cr decreases
			} else {
				adjAmount -= crdrAmount;  // Dr increases
			}

			$adjInput.val(adjAmount.toFixed(2));

			if(adjAmount > 0){
				$("#PopupAdjamountSign").text('Dr');
			}else if (adjAmount < 0) {
				$("#PopupAdjamountSign").text('Cr');
			}
			// console.log("date",$row.find('#cleardt').val());
			$row.find('#cleardt').val('');
			
			
			var existingPill = $("#pill-" + rowID + " .pill-label");
			// console.log("existingPill length ",existingPill, existingPill.length);
			if (existingPill.length > 0) {
				existingPill.html(
					crdrAmount + "&nbsp;" +
					"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>"
				);
			} else {
				$('#pillContainer').css('display', 'block');
				$("#pillContainer").append(
					"<div id='pill-" + rowID + "' class='me-2 d-inline-block'>" +
						"<div class='pill-label btn-primary'>" +
							crdrAmount + "&nbsp;" +
							"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>" +
						"</div>" +
					"</div>"
				);
			}

			$row.data('adjusted', true);
		}
	}

	function handleBankRecoDateChange(thiss) {

		var $row = $(thiss).closest("tr");
		var rowID = $(thiss).closest("tr").find("td:first input").val();
		var clearDt = $(thiss).val();
		var crdrAmount = parseFloat($row.find('input[name="amount"]').val()) || 0;
		var $adjInput = $('#PopupAdjamount'); // <-- fix here
		var adjAmount = parseFloat($adjInput.val()) || 0;
		var crdrSign = $row.find('input[name="sign"]').val();
		$("#pillContainer").show();

		// 👉 If clear date is removed (cleared by user)
		if (clearDt.trim() === "") {
			if ($row.data('adjusted')) {
				console.log("🔄 Clearing pill and reversing amount for row", rowID);
				console.log("cr reverse",crdrAmount,adjAmount, crdrSign);
				// adjAmount = adjAmount + crdrAmount;
				// if (crdrSign === 'Cr') {
				// 	adjAmount += Math.abs(crdrAmount);  // Cr decreases
				// } else {
				// 	adjAmount -= crdrAmount;  // Dr increases
				// }
				adjAmount += crdrAmount;
				// console.log("adjAmount",adjAmount);
				$adjInput.val(adjAmount.toFixed(2));

				$("#pill-" + rowID).remove();
				$row.data('adjusted', false);

				// Hide pill container if no pills remain
				if ($("#pillContainer").children().length === 0) {
					$('#pillContainer').hide();
				}
			}
			return;
		}

		// Only validate if full date is entered
		if (!/^\d{4}-\d{2}-\d{2}$/.test(clearDt)) {
			// Partial date (still typing), allow typing without validation
			return;
		}
		
		const year = parseInt(clearDt.split('-')[0]);

		if (isNaN(year) || year < 2000) {
			// Year is invalid, show warning (but don't clear input)
			// alert("Year must be 2000 or later.");
			// $row.data('adjusted', false);
			return;
		}

		// You can place additional logic here if needed
		console.log("✅ Year is valid:", year);

		var entryDtVal = $row.find('input[name="entrydt"]').val();

		// Convert to Date objects (ensure only date part is compared)
		var clearDate = new Date(clearDt);
		var entryDate = new Date(entryDtVal);

		console.log("clearDate ",clearDate, "entryDate ",entryDate);

		// Normalize to only date part (removes time zone/offset issues)
		clearDate.setHours(0, 0, 0, 0);
		entryDate.setHours(0, 0, 0, 0);

		// Check if cleardt >= entrydt
		if (clearDate >= entryDate) {
			console.log("✅ Clear date is valid");
			
			
			// var crAmount = parseFloat($row.find('input[name="amount"]').val()) || 0;
			

			// Prevent duplicate adjustment
			if (!$row.data('adjusted')) {
				// if (crAmount === 0) {
					console.log("cr adjusted",crdrAmount,adjAmount);
					// adjAmount = adjAmount + crdrAmount;
					// if (crdrSign === 'Cr') {
					// 	adjAmount -= Math.abs(crdrAmount);  // Subtract Cr
					// } else {
					// 	adjAmount += Math.abs(crdrAmount);  // Add Dr  Math.abs(
					// }

					adjAmount  += crdrAmount;

					// console.log("adjAmount",adjAmount);
					// adjAmount += crdrAmount;
				// } else if (drAmount === 0) {
				// 	alert("dr");
				// 	adjAmount -= crAmount;
				// }

				$adjInput.val(adjAmount.toFixed(2));

				var existingPill = $("#pill-" + rowID + " .pill-label");
				console.log("existingPill length ",existingPill, existingPill.length);
				if (existingPill.length > 0) {
					existingPill
						.attr("data-date", clearDt) // store date
        				.find(".pill-label")
						.html(
							crdrAmount + "&nbsp;" +
							"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>"
						);
				} else {
					$('#pillContainer').css('display', 'block');
					$("#pillContainer").append(
						"<div id='pill-" + rowID + "' class='me-2 d-inline-block' data-date='" + clearDt + "'>" +
							"<div class='pill-label btn-primary'>" +
								crdrAmount + "&nbsp;" +
								"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>" +
							"</div>" +
						"</div>"
					);
				}

				if(adjAmount > 0){
					$("#PopupAdjamountSign").text('Dr');
				}else if (adjAmount < 0) {
					$("#PopupAdjamountSign").text('Cr');
				}

				saveBankRecoDetails();
				// $("#PopupAdjamountSign").text(crdrSign);
				$row.data('adjusted', true);

				// if ($(thiss).next('.autofill').length === 0) {
				// 	var delBtn = `
				// 		<a style="padding:3px;margin-left:5px;" href="javascript:void(0)"
				// 		class="btn btn-danger autofill"
				// 		onclick="clearDate(this)">
				// 			<span class="glyphicon glyphicon-trash" aria-hidden="true" title="(Alt+K)"></span>
				// 		</a>`;
				// 	$(thiss).after(delBtn);
				// }
			}

		} else {
			console.log("❌ Clear date is before entry date");
			alert("Clear Date cannot be earlier than Entry Date!");
			$(thiss).val('');
			$row.data('adjusted', false); // allow retry
		}
	}


	function saveBankRecoDetails(){
		var HeaderData = [];
		var bodyData = [];
		HeaderData.push('id');
		$('#ddTable').find('th').each(function(){
			var headerText = $(this).text().replace(/[\t\n]/g, '').trim()
			if (headerText != "") {
				HeaderData.push(headerText);
			}
		});
		console.log("HeaderData",HeaderData);

		// Step 1: Extract pill values
		var pillsData = {};
		$("#pillContainer > div[id^='pill-']").each(function () {
			const pillId = $(this).attr("id").replace("pill-", "");
			const amountText = $(this).find(".pill-label").text().trim().replace(/X$/, '').trim();
			if (pillId && amountText) {
				pillsData[pillId] = amountText;
			}
		});

		console.log("✅ window.bankRecoRowDataMap", window.bankRecoRowDataMap);

		// Create JSON object as key-value pairs using HeaderData and bodyData
		var jsonResult = [];
		
		console.log("length",Object.keys(pillsData));
		if (Object.keys(pillsData).length > 0){
			for (const pillId in pillsData) {
				if (!pillsData.hasOwnProperty(pillId)) continue;

				const rowData = window.bankRecoRowDataMap[pillId];
				if (!rowData) {
					console.warn("❌ Row not found for pill ID:", pillId);
					continue;
				}

				// Update Adjamount
				// const adjIndex = HeaderData.indexOf('Adjamount');
				const adjIndex = HeaderData.findIndex(h => h.toLowerCase().includes('cleardt'));
				if (adjIndex !== -1) {
					rowData[adjIndex] = pillsData[pillId];
				}

				// ✅ Always fetch fresh value from DOM (recommended)
				// const cDate = $(`#ddTable tbody tr[data-id="${pillId}"]`).find('input[name="cleardt"], input[name="cleardt"]').val() || pillsData[pillId];

				const cleanPillId = pillId.replace(/\u00A0/g, '').trim();
				console.log("cleanPillId",cleanPillId,'#ddTable tbody tr[data-id="'+cleanPillId+'"]');
				const cDate = $('#ddTable tbody tr[data-id="'+cleanPillId+'"] #cleardt').val();
				console.log("cDate",cDate);
				// Build object
				let rowObject = {};

				// Metadata
				rowObject['CompanyId'] = <?php echo $_SESSION['dbCompany']; ?>;
				rowObject['DivisionId'] = <?php echo $_SESSION['dbDivision']; ?>;
				rowObject['YearCode'] = <?php echo $_SESSION['dbYear']; ?>;
				rowObject['FormID'] = <?php echo $FormID; ?>;
				rowObject['UserID'] = <?php echo $_SESSION['user_id']; ?>;
				rowObject['ssdt'] = $('#ssdt').val();
				rowObject['lldt'] = $('#lldt').val();
				rowObject['bname'] = $('#bname').val();

				for (let j = 0; j < HeaderData.length; j++) {
					
					const header = HeaderData[j];

					// Match lowercase keys if needed
					const key = header.toLowerCase();
					if (header === 'Cleardt') {
						rowObject[key] = cDate;
					} else {
						rowObject[key] = rowData[key] !== undefined ? rowData[key] : '';
					}
				}

				
				jsonResult.push(rowObject);
			}
		}else{
			let rowObject = {};
			
			// Metadata
			rowObject['CompanyId'] = <?php echo $_SESSION['dbCompany']; ?>;
			rowObject['DivisionId'] = <?php echo $_SESSION['dbDivision']; ?>;
			rowObject['YearCode'] = <?php echo $_SESSION['dbYear']; ?>;
			rowObject['FormID'] = <?php echo $FormID; ?>;
			rowObject['UserID'] = <?php echo $_SESSION['user_id']; ?>;
			rowObject['ssdt'] = $('#ssdt').val();
			rowObject['lldt'] = $('#lldt').val();
			rowObject['bname'] = $('#bname').val();

			for (let j = 0; j < HeaderData.length; j++) {
				const header = HeaderData[j];

				// Match lowercase keys if needed
				const key = header.toLowerCase();
				if (header === 'Cleardt') {
					rowObject[key] = '';
				} else {
					rowObject[key] = '';
				}
			}
			jsonResult.push(rowObject);
		}

		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : { jsonData : jsonResult, FormID:<?php echo $FormID; ?>, generatedUniqueId: $("#kreon-grid-agenerateduniqueid").val() },
			url : "storeAdjAmount.php",
			success : function(result){
				$("#pillContainer").empty();
			}
		})
	}


	//In adjustmentamount click on ok button pending value get into adjamt text field & do calculation
	function autoFill(thiss,gridFieldName){
		var pendingVal = parseFloat($(thiss).closest("tr").find('input[name="pending"]').val());
		var adjamount = $(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').val();
		var balanceVal = parseFloat($('#PopupBalance').val());
		var GridAmount = Math.abs(parseFloat($('#kreon-grid-aamount').val()));
		console.log("GridAmount ",GridAmount);
		if(adjamount == 0){
			if(GridAmount > 0){
				console.log("balanceval:",balanceVal," pendingVal:",pendingVal)
				if(pendingVal < balanceVal){
					if(pendingVal > GridAmount)
					{
						console.log("hi1",GridAmount);
						$(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').val(GridAmount);
					}else{
						console.log("hi2",GridAmount);
						$(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').val(pendingVal);
					}
				}else{
					if(balanceVal > GridAmount){
						console.log("hi3",GridAmount);
						$(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').val(GridAmount);
					}else{
						console.log("hi4",GridAmount);
						$(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').val(balanceVal);
					}
				}
			}else{
				console.log("hi5");
				$(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').val(pendingVal);
			}

			getBillCalculation($(thiss),'click',gridFieldName);	
			
		}
		// console.log($(thiss).closest("tr").next());
		$(thiss).closest("tr").next().find('input[name="adjamount"], input[name="adjamt"]').focus().select();
		
	};

	function saveAdjAmtData(){
		var HeaderData = [];
		HeaderData.push('id');
		$('#ddTable').find('th').each(function(){
			var headerText = $(this).text().replace(/[\t\n]/g, '').trim()
			if (headerText != "") {
				HeaderData.push(headerText);
			}
		});
		console.log("HeaderData", HeaderData);

		// Step 1: Extract pill values
		var pillsData = {};
		$("#pillContainer > div[id^='pill-']").each(function () {
			const pillId = $(this).attr("id").replace("pill-", "");
			const amountText = $(this).find(".pill-label").text().trim().replace(/X$/, '').trim();
			if (pillId && amountText) {
				pillsData[pillId] = amountText;
			}
		});

		console.log("✅ window.ddRowDataMap", window.ddRowDataMap);

		
		// Metadata
		let date = new Date();
		let CreatedDate = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
		let GridId = $('#PopupGridId').val();
		let gridIdentifier = $('#grid-id-'+GridId).attr('class') || '';
		let gridSerialNo = gridIdentifier.slice(4);
		let prevCnt = parseInt($("#cnt"+gridSerialNo).val() || 0) + 1;

		// Step 3: Build jsonResult
		var jsonResult = [];

		// console.log("✅ after window.ddRowDataMap", window.ddRowDataMap);
		
		if (Object.keys(pillsData).length > 0){
			for (const pillId in pillsData) {
				if (!pillsData.hasOwnProperty(pillId)) continue;

				const rowData = window.ddRowDataMap[pillId];
				if (!rowData) {
					console.warn("❌ Row not found for pill ID:", pillId);
					continue;
				}

				// Update Adjamount
				// const adjIndex = HeaderData.indexOf('Adjamount');
				const adjIndex = HeaderData.findIndex(h => h.toLowerCase().includes('adjamt'));
				if (adjIndex !== -1) {
					rowData[adjIndex] = pillsData[pillId];
				}

				// ✅ Always fetch fresh value from DOM (recommended)
				const adjVal = $(`#ddTable tbody tr[data-id="${pillId}"]`).find('input[name="adjamount"], input[name="adjamt"]').val() || pillsData[pillId];

				// Build object
				let rowObject = {};

				// Metadata
					rowObject['srno'] = prevCnt;
					rowObject['CreatedAt'] = CreatedDate;
					rowObject['CompanyId'] = <?php echo $_SESSION['dbCompany']; ?>;
					rowObject['DivisionId'] = <?php echo $_SESSION['dbDivision']; ?>;
					rowObject['YearCode'] = <?php echo $_SESSION['dbYear']; ?>;
					rowObject['FormID'] = <?php echo $FormID; ?>;
					rowObject['UserID'] = <?php echo $_SESSION['user_id']; ?>;
					rowObject['generateduniqueid'] = $("#kreon-grid-" + gridSerialNo + "generateduniqueid").val();

				for (let j = 0; j < HeaderData.length; j++) {
					

					const header = HeaderData[j];

					// Match lowercase keys if needed
					const key = header.toLowerCase();
					if (header === 'Adjamount') {
						rowObject[key] = adjVal;
					} else {
						rowObject[key] = rowData[key] !== undefined ? rowData[key] : '';
					}
				}

				
				jsonResult.push(rowObject);
			}
		}else{
			let rowObject = {};
			rowObject['srno'] = prevCnt;
			rowObject['CreatedAt'] = CreatedDate;
			rowObject['CompanyId'] = <?php echo $_SESSION['dbCompany']; ?>;
			rowObject['DivisionId'] = <?php echo $_SESSION['dbDivision']; ?>;
			rowObject['YearCode'] = <?php echo $_SESSION['dbYear']; ?>;
			rowObject['FormID'] = <?php echo $FormID; ?>;
			rowObject['UserID'] = <?php echo $_SESSION['user_id']; ?>;
			rowObject['generateduniqueid'] = $("#kreon-grid-" + gridSerialNo + "generateduniqueid").val();

			for (let j = 0; j < HeaderData.length; j++) {
				const header = HeaderData[j];

				// Match lowercase keys if needed
				const key = header.toLowerCase();
				if (header === 'Adjamount') {
					rowObject[key] = 0;
				} else {
					rowObject[key] = '';
				}
			}
			jsonResult.push(rowObject);
		}

		console.log("✅ Final jsonResult:", jsonResult);

		// Submit
		$('#saveAdjAmtButton').attr('disabled', true);
		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : {
				jsonData : jsonResult,
				FormID: <?php echo $FormID; ?>,
				generatedUniqueId: $("#kreon-grid-agenerateduniqueid").val()
			},
			url : "storeAdjAmount.php",
			success : function(result){
				// console.log($('#kreon-grid-aadjamount-text').val());
				// your existing success handler...
				if(result['data']['Success'] == 1){
					// alert("hi1");
					if(result['data']['GridResponse']){
						// alert("hi2");
						var gridResponseFields = result['data']['GridResponse'].split('|');

						for(var k=0; k < gridResponseFields.length; k++){
							var gridResponseFieldsArray = gridResponseFields[k].split(':');

							var type = $('#'+gridResponseFieldsArray[0]).prop('type');
							if(type == 'text' || type == 'date' || type == 'number' || type == 'email' || type == 'textarea' || type == 'time'){
								// console.log("pornima", gridResponseFieldsArray[0], gridResponseFieldsArray[1]);
								$('#'+gridResponseFieldsArray[0]).val(gridResponseFieldsArray[1]);
							}
						}
					}

					var valueToSet = $('#PopupAdjamount').val();
					var prefix = '#kreon-grid-' + gridSerialNo;
					var GridAmount = $('#kreon-grid-'+gridSerialNo+'amount').val();
					var input1 = $(prefix + 'adjamount-text');
					var input2 = $(prefix + 'adjamt-text');
					// $('#kreon-grid-'+gridSerialNo+'adjamount-text').val($('#PopupAdjamount').val());
					if (input1.length) {
						input1.val(valueToSet);
					} else if (input2.length) {
						input2.val(valueToSet);
					}

					// $('#kreon-grid-'+gridSerialNo+'adjamount').val($('#PopupAdjamount').val());
					var mainInput1 = $(prefix + 'adjamount');
					var mainInput2 = $(prefix + 'adjamt');

					if (mainInput1.length) {
						mainInput1.val(valueToSet);
					} else if (mainInput2.length) {
						mainInput2.val(valueToSet);
					}

					if(+GridAmount == 0){
						$('#kreon-grid-aamount').val(valueToSet);
					}

					$("#DropDownModal").modal("hide"); 
					$('#saveAdjAmtButton').attr('disabled', false);
				}
			}
		});
	}

	//On keydown event calculate balance
	function getBillCalculation(thiss,type,gridFieldName){
		// alert($(thiss).closest("tr").find('input[name="PENDING"]').val());
		var isValidPill = true;
		var currentRow = $(thiss).attr('id');
		
		var max = $(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').attr("max");
        var min = $(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').attr("min");
		
		var GridAmount = Math.abs(parseFloat($('#kreon-grid-aamount').val()));

		if(type == 'click'){
			var currentAmount = $(thiss).closest("tr").find('input[name="pending"]').val();
		}else{
			var currentAmount = thiss.value;
		}
		
		console.log("currentAmount",currentAmount);
		if(GridAmount > 0){
			var currentAdjAmount = $(thiss).closest("tr").find('input[name="adjamount"], input[name="adjamt"]').val();
			var amount = $('#PopupAmount').val();
			var adjAmount = 0;
		}else{
			
			var currentAdjAmount = currentAmount;
			var amount = $('#PopupAmount').val();
			var adjAmount = $('#PopupAmount').val();
		
		}

		console.log("currentAmount",currentAmount);
	
		if(parseFloat(currentAmount) >= min && parseFloat(currentAmount) <= max){
			
			var rowID = $(thiss).closest("tr").find("td:first input").val();
			
			if ($("#pillContainer .pill-label").length > 0) {
				$("#pillContainer .pill-label").each(function () {
					console.log(".pill-label text:", $(this).text());

					let text = $(this).text().replace(/X$/, '').trim(); // remove 'X'
					let pillVal = parseFloat(text);

					if (!isNaN(pillVal)) {
						let pillId = $(this).parent().attr('id'); // get parent's ID like 'pill-1'
						console.log("Checking pill:", pillId, "against rowID:", rowID);

						if (pillId !== 'pill-' + rowID) {
							adjAmount += +pillVal;
						}
					}
				});
			} 
				
			adjAmount = parseFloat(adjAmount) + parseFloat(currentAdjAmount);
		
			
			if(GridAmount > 0){
				var balance = parseFloat(amount)-parseFloat(adjAmount);
				var pendingAmt = $(thiss).closest("tr").find('input[name="pending"]').val();
				if(balance != NaN){
					if(balance >= 0){
						console.log("balance",typeof balance);
						$('#PopupBalance').val(balance.toFixed(2));
						$(thiss).closest("tr").find('input[name="balance"]').val(parseFloat(pendingAmt) - parseFloat(currentAdjAmount))
					}else{
						if(event.keyCode != 8 && event.keyCode != 46 && event.keyCode != 9 && event.keyCode != 01){
							event.preventDefault();
	
							adjAmount -= parseFloat($(thiss).closest("tr").find('input[name="adjamount"],input[name="adjamt"]').val());
	
							$(thiss).closest("tr").find('input[name="adjamount"],input[name="adjamt"]').val(0);
							// $(thiss).closest("tr").find('input[name="adjamount-text"]').val(currentAmount.slice(0,-1));
							// console.log($(thiss).closest("tr").find('input[name="adjamount"]') +" == "+ $('#PopupAdjamount').val());
							isValidPill = false;
							alert('Balance cannot be less than 0.');
							return ;
						}
						
					}
				}
			}else{
				var pendingAmt = $(thiss).closest("tr").find('input[name="pending"]').val();	
				$(thiss).closest("tr").find('input[name="balance"]').val(parseFloat(pendingAmt) - parseFloat(currentAdjAmount));
				
			}
			
			if(isValidPill){
				// console.log("hi",rowID,currentAdjAmount);
				if (rowID) {
					// alert('hi');
					var existingPill = $("#pill-" + rowID + " .pill-label");
					console.log("existingPill",existingPill);
					if (+currentAdjAmount > 0) {
						if (existingPill.length > 0) {
							existingPill.html(
								currentAdjAmount + "&nbsp;" +
								"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>"
							);
						} else {
							$('#pillContainer').css('display', 'block');
							$("#pillContainer").append(
								"<div id='pill-" + rowID + "' class='me-2 d-inline-block'>" +
									"<div class='pill-label btn-primary'>" +
										currentAdjAmount + "&nbsp;" +
										"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>" +
									"</div>" +
								"</div>"
							);
						}
					} else {
						// Adj amount is 0, remove pill
						$("#pill-" + rowID).remove();
					}
				}

			}else{
				event.preventDefault();
				// let rowID = $(thiss).closest("tr").find("td:first input").val();
				$("#pill-" + rowID).remove(); //Remove bad pill
			}

			
			var adjAmount = 0;
			// If pills exist, trust pills (for filtered view)
			if ($("#pillContainer .pill-label").length > 0) {
				$("#pillContainer .pill-label").each(function () {
					console.log(".pill-label",$(this).text());
					let text = $(this).text().replace(/X$/, '').trim(); // remove 'X'
					let pillVal = parseFloat(text);
					if (!isNaN(pillVal)) {
						adjAmount += pillVal;
					}
				});
			} 

			if(isNaN(adjAmount)){
				$('#PopupAdjamount').val(0);
				isValidPill = false;
			}else{
				$('#PopupAdjamount').val(adjAmount);
				if(GridAmount == 0){
					$('#PopupAmount').val(adjAmount);
				}
			}
			console.log("after adding value",$('#PopupAdjamount').val());

			if(GridAmount > 0){
				var balance = parseFloat(amount)-parseFloat(adjAmount);

				if(balance != NaN){
					if(balance >= 0){
						$('#PopupBalance').val(balance.toFixed(2));
						$(thiss).closest("tr").find('input[name="balance"]').val(parseFloat(pendingAmt) - parseFloat(currentAdjAmount))
					}
				}
			}else{
				$(thiss).closest("tr").find('input[name="balance"]').val(parseFloat(pendingAmt) - parseFloat(currentAdjAmount));
			}

			var valueToSet = $('#PopupAdjamount').val();
			var prefix = '#kreon-grid-a' //+ gridSerialNo;
			var input1 = $(prefix + 'adjamount-text');
			var input2 = $(prefix + 'adjamt-text');

			// $('#kreon-grid-'+gridSerialNo+'adjamount-text').val($('#PopupAdjamount').val());
			if (input1.length) {
				input1.val(valueToSet);
			} else if (input2.length) {
				input2.val(valueToSet);
			}

			// $('#kreon-grid-'+gridSerialNo+'adjamount').val($('#PopupAdjamount').val());
			var mainInput1 = $(prefix + 'adjamount');
			var mainInput2 = $(prefix + 'adjamt');

			if (mainInput1.length) {
				mainInput1.val(valueToSet);
			} else if (mainInput2.length) {
				mainInput2.val(valueToSet);
			}

		}else{
			if(event.keyCode != 8 && event.keyCode != 46 && event.keyCode != 9 && event.keyCode != 01){
				event.preventDefault();
			
				$(thiss).closest("tr").find('input[name="adjamount"],input[name="adjamt"]').val(currentAmount.slice(0,-1));
				alert('Adjustment amount is greater than balance amount.');
			}
			
		}

	}

	//Deselect row on cross button
	function deselectRow(deselectRowId,deselectRowLabel,DBFieldName){
		$("#ddTable tr td:nth-child(1)").filter(function() {
			return $(this).text().trim() == deselectRowId;
		}).parent('tr').removeClass('DTTT_selected selected ');

		$("#pill-"+deselectRowId).remove();

		MDDModalHiddenValue = $('#MultyDDModal-hidden-'+DBFieldName).val();
		MDDModalHiddenValueArray = MDDModalHiddenValue.split(",");

		MDDModalLabel = $('#MultyDDModal-'+DBFieldName).val();
		MDDModalLabelArray = MDDModalLabel.split(",");

		for (let i = 0; i < MDDModalHiddenValueArray.length; i++) {
			if (MDDModalHiddenValueArray[i] == deselectRowId) {
				MDDModalHiddenValueArray.splice(i, 1);
				MDDModalLabelArray.splice(i, 1);

				break;
			}
		}

		MDDModalHiddenValueString = MDDModalHiddenValueArray.toString();
		$('#MultyDDModal-hidden-'+DBFieldName).val()
		$('#MultyDDModal-hidden-'+DBFieldName).val(MDDModalHiddenValueString);
		
		MDDModalLabelString = MDDModalLabelArray.toString();
		$('#MultyDDModal-'+DBFieldName).val();
		$('#MultyDDModal-'+DBFieldName).val(MDDModalLabelString);

	}

	function deselectAllRow(){
		var currentField = $('#DropDownModalID').val();
		var splitCurrentField = currentField.split('-');
		var currentFieldValue = splitCurrentField[0]+"-hidden-"+splitCurrentField[1];
		var currentFieldValues = $('#'+currentFieldValue).val();
		var currentFieldValuesArray = currentFieldValues.split(',');

		// var rows = $('#ddTable').rows('.DTTT_selected selected').remove().draw();

		for(var i=0; i<currentFieldValuesArray.length; i++){
			$("#ddTable tr td:nth-child(1)").filter(function() {
				return $(this).text().trim() == currentFieldValuesArray[i];
			}).parent('tr').removeClass('DTTT_selected selected ');
	
			$("#pill-"+currentFieldValuesArray[i]).remove();
		}

		$('#'+currentFieldValue).val('');
		$('#MultyDDModal-'+splitCurrentField[1]).val('');

		$("#pillContainer").empty();
		$('#pillContainerClear').css("display","none");
	}

	$("#sub_registerid").on("select2-opening", function() { 
       $("#sub_registerid").on("select2-open", function() { 
         $("#sub_registerid").select2("search","BBB");
       });
    });


	function getSheetData(sheetsMap, sheetName, XLSX, shDt){
		const sheetData = sheetsMap[sheetName]?.data || [];
		console.log(sheetName, shDt, sheetData, "<=");
		sheetData.forEach((row, i) => {
			const values = Object.values(row);
			XLSX.utils.sheet_add_aoa(shDt, [values], { origin: { r: 4 + i, c: 0 } }); // Start from row 6 (index 5)
		});
	}

	async function CallSpForFieldType24(requestParams,GridResponse,SpName,PopulateGridID,editid,userid,gridid,PopulateField,FType = null){
		try {
			var result = await $.ajax({
				type: 'POST',
				dataType: 'json',
				data: {
					requestParams:requestParams, 
					SpName:SpName, 
					editid:editid, 
					userid:userid, 
					gridid:gridid, 
					PopulateField:PopulateField, 
					FType:FType, 
					FormID:<?php echo $FormID; ?>,
					FormData: $('form').serialize()
				},
				url: 'getFieldType24SpResponse.php'
			});

			if(FType == 'GSTR1'){
				if(result['status']){
					var response = result;
					// const jsonData = await response.json();
					jsonData= response;
					console.log('jsonData',jsonData);
					// Check if the response is valid
					if (jsonData.status === "true" && jsonData.sheets) {
						let wb = XLSX.utils.book_new(); // Create a new workbook
						var cnt = 1;
						// Extract API sheets as a dictionary for easy access
						const sheetsMap = {};
						jsonData.sheets.forEach(s => {
							sheetsMap[s.sheetName] = s;
						});
						var b2bSezDeData = [
							['Summary For B2B, SEZ, DE (4A, 4B, 6B, 6C)', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Recipients','', 'No. of Invoices', '','Total Invoice Value', '', '', '', '', '', '','Total Taxable Value', 'Total Cess'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['GSTIN/UIN of Recipient', 'Receiver Name', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Reverse Charge', 'Applicable % of Tax Rate', 'Invoice Type', 'E-Commerce GSTIN', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let b2bSezDeSheet = XLSX.utils.aoa_to_sheet(b2bSezDeData);
						b2bSezDeSheet['A3'] = { t: 'n', f: 'COUNTA(A5:A2000)' }; // Count recipients
						b2bSezDeSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Count invoices
						b2bSezDeSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Count invoices
						b2bSezDeSheet['L3'] = { t: 'n', f: 'SUM(L5:L2000)' }; // Total Taxable Value
						b2bSezDeSheet['M3'] = { t: 'n', f: 'SUM(M5:M2000)' }; // Total Cess
						getSheetData(sheetsMap, 'b2b,sez,de', XLSX, b2bSezDeSheet)

						var b2bData = [
							['Summary For B2B', 'HELP', '', '', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Recipients', 'No. of Invoices', 'Total Invoice Value', '', '', '', '', '', '', '', 'Total Taxable Value', 'Total Cess', '', ''],
							[null, '', null, '', '', '', '', '', '', '', null, null, null, null],
							['GSTIN/UIN of Recipient', 'Receiver Name', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Reverse Charge', 'Applicable % of Tax Rate', 'Invoice Type', 'E-Commerce GSTIN', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let b2bSheet = XLSX.utils.aoa_to_sheet(b2bData);
						b2bSheet['A3'] = { t: 'n', f: 'SUMPRODUCT((A5:A20004<>"")/COUNTIF(A5:A20004,A5:A20004&""))' }; // Formula for cell A3
						b2bSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Formula for cell C3
						b2bSheet['G3'] = { t: 'n', f: 'SUM(G5:G2000)' }; // Formula for cell G3
						b2bSheet['N3'] = { t: 'n', f: 'SUM(N5:N2000)' }; // Formula for cell N3
						b2bSheet['O3'] = { t: 'n', f: 'SUM(O5:O2000)' }; // Formula for cell O3
						getSheetData(sheetsMap, 'b2ba', XLSX, b2bSheet);

						// b2cl Sheet
						var b2clData = [
							['Summary For B2CL', 'HELP', '', '', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Invoices', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount'],
							[null, '', null, '', '', '', null, null, null, null],
							['Invoice Number', 'Invoice Date', 'Invoice Value', 'Place Of Supply', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let b2clSheet = XLSX.utils.aoa_to_sheet(b2clData);
						b2clSheet['B3'] = { t: 'n', f: 'COUNTA(B5:B2000)' }; // Count invoices
						getSheetData(sheetsMap, 'b2cl', XLSX, b2clSheet);

						var b2claData = [
							['Summary For B2CLA (Amended B2C Large)', 'HELP', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Invoices', 'Total Inv Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Original Invoice Number', 'Original Invoice Date', 'Original Place Of Supply', 'Revised Invoice Number', 'Revised Invoice Date', 'Invoice Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount', 'E-Commerce GSTIN']
						];

						let b2claSheet = XLSX.utils.aoa_to_sheet(b2claData);
						b2claSheet['B3'] = { t: 'n', f: 'COUNTA(B5:B2000)' }; // Count invoices
						b2claSheet['C3'] = { t: 'n', f: 'SUM(C5:C2000)' }; // Total Taxable Value
						b2claSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Cess
						getSheetData(sheetsMap, 'b2cla', XLSX, b2claSheet);

						var b2csData = [
							['Summary For B2CS', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Type', 'Place Of Supply', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount', 'E-Commerce GSTIN']
						];
						let b2csSheet = XLSX.utils.aoa_to_sheet(b2csData);
						b2csSheet['A3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Taxable Value
						b2csSheet['B3'] = { t: 'n', f: 'SUM(F5:F2000)' }; // Total Cess
						getSheetData(sheetsMap, 'b2cs', XLSX, b2csSheet);

						var b2csaData = [
							['Summary For B2CSA', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Financial Year', 'Original Month', 'Place Of Supply', 'Type', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount', 'E-Commerce GSTIN']
						];
						let b2csaSheet = XLSX.utils.aoa_to_sheet(b2csaData);
						b2csaSheet['A3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Taxable Value
						b2csaSheet['B3'] = { t: 'n', f: 'SUM(F5:F2000)' }; // Total Cess
						getSheetData(sheetsMap, 'b2csa', XLSX, b2csaSheet);

						// cdnr Sheet
						var cdnrData = [
							['Summary For CDNR', 'HELP', '', '', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Recipients', 'No. of Notes', 'Total Note Value', 'Total Taxable Value', 'Total Cess', 'GSTIN/UIN of Recipient', 'Receiver Name', 'Note Number', 'Note Date', 'Note Type', 'Place Of Supply', 'Reverse Charge', 'Rate', 'Taxable Value', 'Cess Amount'],
							[null, '', null, '', '', '', '', '', null, '', '', '', '', null, null],
							['GSTIN/UIN of Recipient', 'Receiver Name', 'Note Number', 'Note Date', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let cdnrSheet = XLSX.utils.aoa_to_sheet(cdnrData);
						cdnrSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Example Formula for cdnr
						getSheetData(sheetsMap, 'cdnr', XLSX, cdnrSheet);

						var cdnraData = [
							['Summary For CDNRA (Amended CDNR)', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Recipients', 'No. of Notes', 'Total Note Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Original Note Number', 'Original Note Date', 'Revised Note Number', 'Revised Note Date', 'Note Type', 'Place Of Supply', 'Reverse Charge', 'Note Supply Type', 'Note Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let cdnraSheet = XLSX.utils.aoa_to_sheet(cdnraData);
						cdnraSheet['C3'] = { t: 'n', f: 'SUM(C5:C2000)' }; // Total Note Value
						cdnraSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Taxable Value
						cdnraSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cess
						getSheetData(sheetsMap, 'cdnra', XLSX, cdnraSheet);

						var cdnurData = [
							['Summary For CDNUR', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Notes/Vouchers', 'Total Note Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['UR Type', 'Note Number', 'Note Date', 'Note Type', 'Place Of Supply', 'Note Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let cdnurSheet = XLSX.utils.aoa_to_sheet(cdnurData);
						cdnurSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Example Formula for cdnr
						getSheetData(sheetsMap, 'cdnur', XLSX, cdnurSheet);

						var cdnuraData = [
							['Summary For CDNURA', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Notes/Vouchers', 'Total Note Value', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['UR Type', 'Original Note Number', 'Original Note Date', 'Revised Note Number', 'Revised Note Date', 'Note Type', 'Place Of Supply', 'Note Value', 'Applicable % of Tax Rate', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let cdnuraSheet = XLSX.utils.aoa_to_sheet(cdnuraData);
						cdnuraSheet['C3'] = { t: 'n', f: 'COUNTA(C5:C2000)' }; // Example Formula for cdnr
						getSheetData(sheetsMap, 'cdnura', XLSX, cdnuraSheet);

						var expData = [
							['Summary For EXP', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Invoices', 'Total Invoice Value', 'No. of Shipping Bills', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Export Type', 'Invoice Number', 'Invoice Date', 'Invoice Value', 'Port Code', 'Shipping Bill Number', 'Shipping Bill Date', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let expSheet = XLSX.utils.aoa_to_sheet(expData);
						expSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Invoice Value
						expSheet['C3'] = { t: 'n', f: 'COUNT(C5:C2000)' }; // Number of Shipping Bills
						expSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Taxable Value
						expSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cess
						getSheetData(sheetsMap, 'exp', XLSX, expSheet);

						var expaData = [
							['Summary For EXPA', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of Invoices', 'Total Invoice Value', 'No. of Shipping Bills', 'Total Taxable Value', 'Total Cess', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Export Type', 'Original Invoice Number', 'Original Invoice Date', 'Revised Invoice Number', 'Revised Invoice Date', 'Invoice Value', 'Port Code', 'Shipping Bill Number', 'Shipping Bill Date', 'Rate', 'Taxable Value', 'Cess Amount']
						];
						let expaSheet = XLSX.utils.aoa_to_sheet(expaData);
						expaSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Invoice Value
						expaSheet['C3'] = { t: 'n', f: 'COUNT(C5:C2000)' }; // Number of Shipping Bills
						expaSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Taxable Value
						expaSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cess
						getSheetData(sheetsMap, 'expa', XLSX, expaSheet);

						var atData = [
							['Summary For Advance Received', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Advance Received', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Place Of Supply', 'Rate', 'Gross Advance Received', 'Cess Amount']
						];
						let atSheet = XLSX.utils.aoa_to_sheet(atData);
						atSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Received
						atSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess
						getSheetData(sheetsMap, 'at', XLSX, atSheet);

						var ataData = [
							['Summary For Amended Tax Liability (Advance Received)', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Advance Received', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Financial Year', 'Original Month', 'Original Place Of Supply', 'Rate', 'Gross Advance Received', 'Cess Amount']
						];
						let ataSheet = XLSX.utils.aoa_to_sheet(ataData);
						ataSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Received
						ataSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess
						getSheetData(sheetsMap, 'ata', XLSX, ataSheet);

						var atadjData = [
							['Summary For Advance Adjusted', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Advance Adjusted', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Place Of Supply', 'Rate', 'Gross Advance Adjusted', 'Cess Amount']
						];
						let atadjSheet = XLSX.utils.aoa_to_sheet(atadjData);
						atadjSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Adjusted
						atadjSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess
						getSheetData(sheetsMap, 'atadj', XLSX, atadjSheet);

						var atadjaData = [
							['Summary For Amendment of Adjustment Advances', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Advance Adjusted', 'Total Cess', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Financial Year', 'Original Month', 'Original Place Of Supply', 'Rate', 'Gross Advance Adjusted', 'Cess Amount']
						];
						let atadjaSheet = XLSX.utils.aoa_to_sheet(atadjaData);
						atadjaSheet['A3'] = { t: 'n', f: 'SUM(A5:A2000)' }; // Total Advance Adjusted
						atadjaSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Cess
						getSheetData(sheetsMap, 'atadja', XLSX, atadjaSheet);
						
						var exempData = [
							['Summary For Nil Rated, Exempted, and Non-GST Supplies', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Nil Rated Supplies', 'Total Exempted Supplies', 'Total Non-GST Supplies', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Description', 'Nil Rated Supplies', 'Exempted Supplies', 'Non-GST Supplies']
						];
						let exempSheet = XLSX.utils.aoa_to_sheet(exempData);
						exempSheet['B3'] = { t: 'n', f: 'SUM(B5:B2000)' }; // Total Nil Rated Supplies
						exempSheet['C3'] = { t: 'n', f: 'SUM(C5:C2000)' }; // Total Exempted Supplies
						exempSheet['D3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Non-GST Supplies
						getSheetData(sheetsMap, 'exemp', XLSX, exempSheet);

						var hsnData = [
							['Summary For HSN', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['No. of HSN', '','','','Total Value','', 'Total Taxable Value', 'Total Integrated Tax', 'Total Central Tax', 'Total State/UT Tax', 'Total Cess'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['HSN', 'Description', 'UQC', 'Total Quantity', 'Total Value', 'Rate', 'Taxable Value', 'Integrated Tax Amount', 'Central Tax Amount', 'State/UT Tax Amount', 'Cess Amount']
						];
						let hsnSheet = XLSX.utils.aoa_to_sheet(hsnData);
						hsnSheet['A3'] = { t: 'n', f: 'COUNTA(A5:A2000)' }; // Total Value
						hsnSheet['E3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Value
						hsnSheet['G3'] = { t: 'n', f: 'SUM(G5:G2000)' }; // Total Taxable Value
						hsnSheet['H3'] = { t: 'n', f: 'SUM(H5:H2000)' }; // Total Integrated Tax
						hsnSheet['I3'] = { t: 'n', f: 'SUM(I5:I2000)' }; // Total Central Tax
						hsnSheet['J3'] = { t: 'n', f: 'SUM(J5:J2000)' }; // Total State/UT Tax
						hsnSheet['K3'] = { t: 'n', f: 'SUM(K5:K2000)' }; // Total Cess
						getSheetData(sheetsMap, 'hsn', XLSX, hsnSheet);

						var docsData = [
							['Summary of Documents Issued During the Tax Period', 'HELP', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							['Total Number of Documents', 'Total Cancelled Documents', '', '', '', '', '', '', '', '', '', '', 'HELP'],
							[null, '', null, '', '', '', null, '', '', '', '', null, null],
							['Nature of Document', 'Sr. No. From', 'Sr. No. To', 'Total Number of Documents', 'Cancelled']
						];
						let docsSheet = XLSX.utils.aoa_to_sheet(docsData);
						docsSheet['B3'] = { t: 'n', f: 'SUM(D5:D2000)' }; // Total Number of Documents
						docsSheet['C3'] = { t: 'n', f: 'SUM(E5:E2000)' }; // Total Cancelled Documents
						getSheetData(sheetsMap, 'docs', XLSX, docsSheet);

						// Step 3: Add these sheets to a workbook
						wb = XLSX.utils.book_new();
						XLSX.utils.book_append_sheet(wb, b2bSezDeSheet, 'b2b,sez,de');
						XLSX.utils.book_append_sheet(wb, b2bSheet, 'b2ba');
						XLSX.utils.book_append_sheet(wb, b2clSheet, 'b2cl');
						XLSX.utils.book_append_sheet(wb, b2claSheet, 'b2cla');
						XLSX.utils.book_append_sheet(wb, b2csSheet, 'b2cs');
						XLSX.utils.book_append_sheet(wb, b2csaSheet, 'b2csa');
						XLSX.utils.book_append_sheet(wb, cdnrSheet, 'cdnr');
						XLSX.utils.book_append_sheet(wb, cdnraSheet, 'cdnra');
						XLSX.utils.book_append_sheet(wb, cdnurSheet, 'cdnur');
						XLSX.utils.book_append_sheet(wb, cdnuraSheet, 'cdnura');
						XLSX.utils.book_append_sheet(wb, expSheet, 'exp');
						XLSX.utils.book_append_sheet(wb, expaSheet, 'expa');
						XLSX.utils.book_append_sheet(wb, atSheet, 'at');
						XLSX.utils.book_append_sheet(wb, ataSheet, 'ata');
						XLSX.utils.book_append_sheet(wb, atadjSheet, 'atadj');
						XLSX.utils.book_append_sheet(wb, atadjaSheet, 'atadja');
						XLSX.utils.book_append_sheet(wb, exempSheet, 'exemp');
						XLSX.utils.book_append_sheet(wb, hsnSheet, 'hsn');
						XLSX.utils.book_append_sheet(wb, docsSheet, 'docs');

						// Step 4: Write the workbook to an Excel file
						XLSX.writeFile(wb, 'GSTR1.xlsx');

					} else {
						alert('No data found or error fetching data.');
					}
				}
			}else{
				if(result['status']){
					if(result['success'] == 1){
						if(result['msg'] != null && result['msg'] != ''){
							alert(result['msg']);
							// return;
						}

						if(gridid){

							var gridIdentifier = $('#grid-id-'+gridid).attr('class');
							var gridSerialNo = gridIdentifier.slice(4);
						}
						var GridResponseArray=[];
						var gridRes = [];
						var gridCalculation = [];	var gridCalCnt = 0;
						var gridCalculationFieldName = [];
						var gridCalculationType = [];

						if(result['gridData']){
							for(var l=0; l<result['gridData'].length; l++){
								if(result['gridData'][l]['gridcalculation'] == 1){
									gridCalculationFieldName.push(result['gridData'][l]['dbfieldname']);
									gridCalculationType.push(result['gridData'][l]['gridcalculation']);
								}
							}
						}

						console.log("data",result['data']);

						var promises = [];

						if(result['data']){
							for(var l=0; l<result['data'].length; l++){
								GridResponseArray = GridResponse.split("|");

								for(var k=0; k<GridResponseArray.length; k++){
									gridRes = GridResponseArray[k].split(":");

									if(gridRes[2] == '1' || gridRes[2] == '7'){
										if(gridRes[3] == '1'){
											if(result['data'][l][gridRes[0]] == ""){
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).css("border","1px solid red");
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).focus();
												return false;
											}
										}
										
										$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).val(result['data'][l][gridRes[1].trim()]);

										// mfld += "<td><input readonly type=\"text\" value=\'"+result['data'][l][gridRes[1].trim()]+"\' class=\'form-control\'   name=\''+gridSerialNo+'"+gridRes[0].trim()+"[]\'   id=\'"+gridRes[0].trim()+"\'></td>";
									}else if(gridRes[2] == '5' || gridRes[2] == '19'){

										if(gridRes[4] == '1'){
											if(result['data'][l][gridRes[0]] == ""){
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).css("border","1px solid red");
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).focus();
												return false;
											}
										}
										var $newOption = $("<option selected=\"selected\"></option>").val(result['data'][l][gridRes[3].trim()]).text(result['data'][l][gridRes[1].trim()])
										if($('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).data('select2')) {
											// $('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).select2('open');
											$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).append($newOption);
											// $('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).select2('close');
										}
									
									}else if(gridRes[2].trim() == '17'){
										//Check grid field required
										if(gridRes[4] == '1'){
											if(result['data'][l][gridRes[0]] == ""){
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).css("border","1px solid red");
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).focus();
												return false;
											}
										}
										$('#kreon-grid-'+gridSerialNo+gridRes[0].trim()+'-text').val(result['data'][l][gridRes[1].trim()]);
										$('#kreon-grid-'+gridSerialNo+gridRes[0].trim()).val(result['data'][l][gridRes[3]]);
								
									}
									else if(gridRes[2].trim() == 6){
										if(gridRes[4] == '1'){
											if(result['data'][l][gridRes[0]] == ""){
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).css("border","1px solid red");
												$('#kreon-grid-'+gridSerialNo+''+gridRes[0].trim()).focus();
												return false;
											}
										}
										var dateObj =result['data'][l][gridRes[1].trim()];
										console.log("dateObj "+dateObj);
										const date = new Date(dateObj.date);
										const options = {
											timeZone: 'Asia/Calcutta',
											year: 'numeric',
											month: '2-digit',
											day: '2-digit'
										};
										const formattedDate = new Intl.DateTimeFormat('en-GB', options).format(date);
										const [day, month, year] = formattedDate.split('/');
										const inputDateValue = `${year}-${month}-${day}`;
										$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(inputDateValue);
									}		
								}

								DynamicGridInsertFirstRowEdit = ddResponseData['DynamicGridInsertFirstRowEdit'];
								// Add new row and add the promise to the array
								promises.push(AddNewRow($(this),result['gridData'],gridSerialNo,result['data'][l][result['selecedRowIdName']], DynamicGridInsertFirstRowEdit));	
							}
						}

						await Promise.all(promises);
						await CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType, gridSerialNo);

						//Populate field
						if(PopulateField != null){
							PopulateFieldArray = PopulateField.split('|');
							var PopulateFieldResponseArray = [];
							for(var j=0; j<PopulateFieldArray.length; j++){
								SplitPopulateFieldArray = PopulateFieldArray[j].split(':');
								
								var PopulateFieldResponse = result['PopulateFieldResponse'][0][SplitPopulateFieldArray[0]];
								PopulateFieldResponseArray = PopulateFieldResponse.split(':');
								
								if(PopulateFieldResponseArray[0] == 1){
									if(PopulateFieldResponseArray[1].trim() == "NULL"){
									
										$("#"+SplitPopulateFieldArray[0].trim()).val('');
									}else{
										// if(SplitPopulateFieldArray[0] == 'cut_mtrs'){
										// 	var cutMtrsValue = parseInt($('#cut_mtrs').val()) + parseInt(PopulateFieldResponseArray[1]);
										// 	$("#"+SplitPopulateFieldArray[0].trim()).val(cutMtrsValue);

										// }else{

											$("#"+SplitPopulateFieldArray[0].trim()).val(PopulateFieldResponseArray[1]);
										// }
									}

								}else if(PopulateFieldResponse[0] == 5){
									var $newOption = $("<option selected=\"selected\"></option>").val(PopulateFieldResponseArray[1]).text(PopulateFieldResponseArray[2])
									if($('#'+SplitPopulateFieldArray[0].trim()).data('select2')) {
										// $('#'+SplitPopulateFieldArray[0].trim()).select2('open');
										$('#'+SplitPopulateFieldArray[0].trim()).append($newOption).trigger('change');
										// $('#'+SplitPopulateFieldArray[0].trim()).select2('close');
									}

								}
							}

						}
												
						if(result['cursorPosition'] !="" && result['cursorPosition'] != undefined){
							var cursorPositionSplit = result['cursorPosition'].split(':');
							console.log("cursor "+cursorPositionSplit);
							if(cursorPositionSplit[1] == 5){
								$('#'+cursorPositionSplit[0]).next('span').find('.select2-selection--single').focus();
							}else if(cursorPositionSplit[1] == 17){
								$('#'+cursorPositionSplit[0]+'-text').focus();
							}else if(cursorPositionSplit[1] == 16){
								$('#'+cursorPositionSplit[0]+'-text').focus();
							}else if(cursorPositionSplit[1] == 1 || cursorPositionSplit[1] == 7){
								$('#'+cursorPositionSplit[0]).focus();
							}
						}

						// if(result['NonEditableFields'] != null && result['NonEditableFields'][0]['NonEditableFields'] != undefined){
						if (result.NonEditableFields && Array.isArray(result.NonEditableFields) && result.NonEditableFields.length > 0 && result.NonEditableFields[0].NonEditableFields !== undefined) {
							var NonEditableFields = result['NonEditableFields'][0]['NonEditableFields'].split('|');
							for(var k=0; k < NonEditableFields.length; k++){
								var NonEditableFieldArray = NonEditableFields[k].split(':');
								if(NonEditableFieldArray[1] == 'lock'){
									$('#'+NonEditableFieldArray[0]).css('pointer-events','none').css('background-color','#eee');
								}else{
									$('#'+NonEditableFieldArray[0]).css('pointer-events','').css('background-color','white');
								}
							}
						}

						if(result['tempData'] !="" && result['tempData'] != undefined){
							console.log(result['tempData']);
							$("#"+Object.keys(result['tempData'][0])).empty();
							for(var i=0; i<result['tempData'].length; i++){
								$("#"+Object.keys(result['tempData'][i])).append(Object.values(result['tempData'][i]));
							}
						}
						// return;
						
					}else{
						alert(result['msg']);
						// if(CursorPosition !="" && CursorPosition != undefined){
						// 	$('#'+CursorPosition).focus();
						// }
					}
					
				}
			}
		} catch (error) {
			console.error('Error:', error);
		}
	}

	// async function AddResultInGrid(ddRowSelectType, selectedItemId, DBFieldType, DBFieldName, isGrid, requestParams, formReeponseString) {
	// 	var gridid = ddResponseData['PopulateGrid'].split(":");
	// 	var flag = 0;
	// 	console.log("formReeponseString "+formReeponseString);
	// 	try {
	// 		// Making AJAX call with async/await
	// 		const result = await $.ajax({
	// 			type: 'POST',
	// 			dataType: 'json',
	// 			data: {
	// 				selectedRowId: selectedItemId,
	// 				GridId: gridid[1],
	// 				FormId: <?php echo $FormID; ?>,
	// 				FieldName: DBFieldName,
	// 				DBFieldType: DBFieldType,
	// 				isGrid: isGrid,
	// 				requestParams: requestParams,
	// 				formReeponse: formReeponseString
	// 			},
	// 			url: 'getGridData.php'
	// 		});

	// 		// console.log(gridid);
	// 		var gridIdentifier = $('#grid-id-' + gridid[1].trim()).attr('class');
	// 		var gridSerialNo = gridIdentifier.slice(4);

	// 		var gridRes = [];
	// 		var gridCalculationFieldName = [];
	// 		var gridCalculationType = [];
	// 		var gridResponseParams = ddResponseData['gridResponseParams'].split("|");
	// 		var OnkeyupParameterCalculation = [];

	// 		// Process grid data for calculation and input field population
	// 		for (var t = 0; t < result['gridData'].length; t++) {
	// 			if (result['gridData'][t]['GridCalculation'] > 0) {
	// 				gridCalculationFieldName.push(result['gridData'][t]['DbFieldName']);
	// 				gridCalculationType.push(result['gridData'][t]['GridCalculation']);
	// 			}

	// 			if (result['gridData'][t]['OnkeyupParameters'].length > 2) {
	// 				if (result['gridData'][t]['FieldType'] != 5) {
	// 					OnkeyupParameterCalculation.push([result['gridData'][t]['DbFieldName'], result['gridData'][t]['FieldType'], result['gridData'][t]['OnkeyupParameters']]);
	// 				}
	// 			}
	// 		}

	// 		if (Array.isArray(result['data'])) {

	// 			var promises = [];
	// 			// Loop through the data and process each row
	// 			for (var l = 0; l < result['data'].length; l++) {
	// 				for (var t = 0; t < result['gridData'].length; t++) {
	// 					if (result['gridData'][t]['Required'] == 1) {
	// 						var fldvalue = result['data'][l][result['gridData'][t]['DbFieldName']];
	// 						if (fldvalue == "" || fldvalue == 0 || fldvalue == null) {
	// 							flag = 1;
	// 							alert(result['gridData'][t]['DisplayName'] + " is required");
	// 							if (DBFieldType == 17) {
	// 								$('#' + DBFieldName +'-text').val("");
	// 								$('#' + DBFieldName).val("");
	// 							} else if (DBFieldType == 16) {
	// 								$('#' + DBFieldName+'-text').val("");
	// 								$('#' + DBFieldName).val("");
	// 							}
	// 							$('#DropDownModal').modal('hide');
	// 							return;
	// 						}
	// 					}
	// 				}

	// 				if (flag == 0) {
	// 					for (var k = 0; k < gridResponseParams.length; k++) {
	// 						gridRes = gridResponseParams[k].split(":");
	// 						if (gridRes[2].trim() == '1' || gridRes[2].trim() == '3' || gridRes[2].trim() == '7' || gridRes[2].trim() == '8') {
	// 							$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(result['data'][l][gridRes[1].trim()]);
	// 						} else if (gridRes[2].trim() == '6') {
	// 							var dateObj = result['data'][l][gridRes[1].trim()];
	// 							const date = new Date(dateObj.date);
	// 							const options = {
	// 								timeZone: 'Asia/Calcutta',
	// 								year: 'numeric',
	// 								month: '2-digit',
	// 								day: '2-digit'
	// 							};
	// 							const formattedDate = new Intl.DateTimeFormat('en-GB', options).format(date);
	// 							const [day, month, year] = formattedDate.split('/');
	// 							const inputDateValue = `${year}-${month}-${day}`;
	// 							$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(inputDateValue);
	// 						} else if (gridRes[2].trim() == '5' || gridRes[2].trim() == '19') {
	// 							if (result['data'][l][gridRes[1]] != undefined) {
	// 								var newOption = $("<option selected=\"selected\"></option>").val(result['data'][l][gridRes[3]]).text(result['data'][l][gridRes[1]]);
	// 								if ($('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).data('select2')) {
	// 									$('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).select2('open');
	// 									$('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).append(newOption).trigger("change");
	// 									$('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).select2('close');
	// 								} else {
	// 									$('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).append(newOption).trigger("change");
	// 								}
	// 							}
	// 						} else if (gridRes[2].trim() == '17') {
	// 							$('#kreon-grid-' + gridSerialNo + gridRes[0].trim() + '-text').val(result['data'][l][gridRes[1]]);
	// 							$('#kreon-grid-' + gridSerialNo + gridRes[0].trim()).val(result['data'][l][gridRes[3]]);
	// 						}
	// 					}

	// 					if (result['formResponseArray'] != null && result['formResponseArray'].length > 0) {
	// 						for (var n = 0; n < result['formResponseArray'].length; n++) {
	// 							formRes = result['formResponseArray'][n].split(":");
	// 							if (formRes[2].trim() == '1' || formRes[2].trim() == '3' || formRes[2].trim() == '6' || formRes[2].trim() == '7' || formRes[2].trim() == '8') {
	// 								$('#kreon-grid-' + gridSerialNo + '' + formRes[0].trim()).val(formRes[1].trim());
	// 							} else if (formRes[2].trim() == '5' || formRes[2].trim() == '19') {
	// 								var $newOption = $("<option selected=\"selected\"></option>").val(formRes[1]).text(formRes[3]);
	// 								$('#kreon-grid-' + gridSerialNo + '' + formRes[0]).select2('open');
	// 								$('#kreon-grid-' + gridSerialNo + '' + formRes[0]).append($newOption).trigger("change");
	// 								$('#kreon-grid-' + gridSerialNo + '' + formRes[0]).select2('close');
	// 							} else if (formRes[2].trim() == '17') {
	// 								$('#kreon-grid-' + gridSerialNo + formRes[0].trim() + '-text').val(formRes[3].trim());
	// 								$('#kreon-grid-' + gridSerialNo + formRes[0].trim()).val(formRes[1]);
	// 							}
	// 						}
	// 					}
	// 					DynamicGridInsertFirstRowEdit = ddResponseData['DynamicGridInsertFirstRowEdit'];
	// 					// Add row for each data item
	// 					promises.push(AddNewRow($(this), result['gridData'], gridSerialNo, selectedItemId, DynamicGridInsertFirstRowEdit));

	// 				}
	// 			}
	// 			// Wait for all promises to finish before moving forward
	// 			await Promise.all(promises);
				
	// 			// Wait for calculations after rows are added
	// 			await CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType, gridSerialNo);

	// 			$('#DropDownModal').modal('hide');
	// 		} else {
	// 			console.log('result["data"] is not an array', result['data']);
	// 		}

			

	// 	} catch (error) {
	// 		console.error('Error:', error);
	// 	}
	// }

	async function AddResultInGrid(ddRowSelectType, selectedItemId, DBFieldType, DBFieldName, isGrid, requestParams, formReeponseString) {
		
		var gridid = ddResponseData['PopulateGrid'].split(":");
		var flag = 0;
		console.log("formReeponseString "+formReeponseString);
		try {
			// Making AJAX call with async/await
			const result = await $.ajax({
				type: 'POST',
				dataType: 'json',
				data: {
					selectedRowId: selectedItemId,
					GridId: gridid[1],
					FormId: <?php echo $FormID; ?>,
					FieldName: DBFieldName,
					DBFieldType: DBFieldType,
					isGrid: isGrid,
					requestParams: requestParams,
					formResponse: formReeponseString
				},
				url: 'getGridData.php'
			});

			
			var gridIdentifier = $('#grid-id-' + gridid[1].trim()).attr('class');
			var gridSerialNo = gridIdentifier.slice(4);

			var gridRes = [];
			var gridCalculationFieldName = [];
			var gridCalculationType = [];
			var gridResponseParams = ddResponseData['gridResponseParams'].split("|");
			var OnkeyupParameterCalculation = [];

			// Process grid data for calculation and input field population
			for (var t = 0; t < result['gridData'].length; t++) {
				if (result['gridData'][t]['gridcalculation'] > 0) {
					gridCalculationFieldName.push(result['gridData'][t]['dbfieldname']);
					gridCalculationType.push(result['gridData'][t]['gridcalculation']);
				}
				CreateOnkeyupScriptGrid
				if (result['gridData'][t]['onkeyupparameters'].length > 2) {
					if (result['gridData'][t]['fieldtype'] != 5) {
						OnkeyupParameterCalculation.push([result['gridData'][t]['dbfieldname'], result['gridData'][t]['fieldtype'], result['gridData'][t]['onkeyupparameters']]);
					}
				}
			}

			if (Array.isArray(result['data'])) {

				var promises = [];
				// Loop through the data and process each row
				for (var l = 0; l < result['data'].length; l++) {
					for (var t = 0; t < result['gridData'].length; t++) {
						if (result['gridData'][t]['required'] == 1) {
							var fldvalue = result['data'][l][result['gridData'][t]['dbfieldname']];
							
							if (fldvalue == "" || fldvalue == 0 || fldvalue == null) {
								flag = 1;
								console.log()
								alert(result['gridData'][t]['displayname'] + " is required");
								if (DBFieldType == 17) {
									$('#' + DBFieldName +'-text').val("");
									$('#' + DBFieldName).val("");
								} else if (DBFieldType == 16) {
									$('#' + DBFieldName+'-text').val("");
									$('#' + DBFieldName).val("");
								}
								$('#DropDownModal').modal('hide');
								return;
							}
						}
					}

					if (flag == 0) {
						for (var k = 0; k < gridResponseParams.length; k++) {
							gridRes = gridResponseParams[k].split(":");
							if (gridRes[2].trim() == '1' || gridRes[2].trim() == '3' || gridRes[2].trim() == '7' || gridRes[2].trim() == '8') {
								$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(result['data'][l][gridRes[1].trim()]);
								// Call function for grid calculation
								for (var m = 0; m < OnkeyupParameterCalculation.length; m++) {
									if (OnkeyupParameterCalculation[m] != undefined) {
										if (OnkeyupParameterCalculation[m].includes(gridRes[0].trim()) == true) {
											promises.push(CreateOnkeyupScriptGrid("kreon-grid-" + gridSerialNo + "" + gridRes[0].trim(), 'grid', 'dynamic'));
										}
									}
								}
							} else if (gridRes[2].trim() == '6') {
								var dateObj = result['data'][l][gridRes[1].trim()];
								console.log("dateObj "+dateObj);
								const date = new Date(dateObj.date);
								const options = {
									timeZone: 'Asia/Calcutta',
									year: 'numeric',
									month: '2-digit',
									day: '2-digit'
								};
								const formattedDate = new Intl.DateTimeFormat('en-GB', options).format(date);
								const [day, month, year] = formattedDate.split('/');
								const inputDateValue = `${year}-${month}-${day}`;
								$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(inputDateValue);
							} else if (gridRes[2].trim() == '5' || gridRes[2].trim() == '19') {
								if (result['data'][l][gridRes[1]] != undefined) {
									var newOption = $("<option selected=\"selected\"></option>").val(result['data'][l][gridRes[3]]).text(result['data'][l][gridRes[1]]);
									if ($('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).data('select2')) {
										// $('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).select2('open');
										$('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).append(newOption).trigger("change");
										// $('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).select2('close');
									} else {
										$('#kreon-grid-' + gridSerialNo + '' + gridRes[0]).append(newOption).trigger("change");
									}
								}
							} else if (gridRes[2].trim() == '17' || gridRes[2].trim() == '16') {
								$('#kreon-grid-' + gridSerialNo + gridRes[0].trim() + '-text').val(result['data'][l][gridRes[1]]);
								$('#kreon-grid-' + gridSerialNo + gridRes[0].trim()).val(result['data'][l][gridRes[3]]);
							}
						}

						if (result['formResponseArray'] != null && result['formResponseArray'].length > 0) {
							
							for (var n = 0; n < result['formResponseArray'].length; n++) {
								formRes = result['formResponseArray'][n].split(":");
								if (formRes[2].trim() == '1' || formRes[2].trim() == '3' || formRes[2].trim() == '6' || formRes[2].trim() == '7' || formRes[2].trim() == '8') {
									$('#kreon-grid-' + gridSerialNo + '' + formRes[0].trim()).val(formRes[1].trim());
								} else if (formRes[2].trim() == '5' || formRes[2].trim() == '19') {
									// var value1 = formRes[1] ? formRes[1].trim() : 0;
									// var value3 = formRes[3] ? formRes[3].trim() : '';
									var $newOption = $("<option selected=\"selected\"></option>").val(formRes[1].trim()).text(formRes[3].trim());
									// $('#kreon-grid-' + gridSerialNo + '' + formRes[0].trim()).select2('open');
									$('#kreon-grid-' + gridSerialNo + '' + formRes[0].trim()).append($newOption).trigger("change");
									// $('#kreon-grid-' + gridSerialNo + '' + formRes[0].trim()).select2('close');
								} else if (formRes[2].trim() == '17' || formRes[2].trim() == '16') {
									// console.log("field type 17",formRes[0]);
									$('#kreon-grid-' + gridSerialNo + formRes[0].trim() + '-text').val(formRes[3].trim());
									$('#kreon-grid-' + gridSerialNo + formRes[0].trim()).val(formRes[1]);
								}
							}
						}
						DynamicGridInsertFirstRowEdit = ddResponseData['DynamicGridInsertFirstRowEdit'];
						// Add row for each data item
						promises.push(AddNewRow($(this), result['gridData'], gridSerialNo, selectedItemId, DynamicGridInsertFirstRowEdit));

					}
				}
				// Wait for all promises to finish before moving forward
				await Promise.all(promises);

				// First Row editable if DynamicGridInsertFirstRowEdit is yes
				DynamicGridInsertFirstRowEdit = ddResponseData['DynamicGridInsertFirstRowEdit'];
				if(DynamicGridInsertFirstRowEdit){
					if (DynamicGridInsertFirstRowEdit.includes('yes')) {
						var crsr = DynamicGridInsertFirstRowEdit.split('|')[1]; //cursor position
						EditFirstRow(gridSerialNo,result['gridData'], crsr);
					} 
				}
				
				// Wait for calculations after rows are added
				await CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType, gridSerialNo);

				$('#DropDownModal').modal('hide');
			} else {
				console.log('result["data"] is not an array', result['data']);
			}

			

		} catch (error) {
			console.error('Error:', error);
		}
	}

	

	async function AddNewRow(onCLickVariable, mArray, gridSerialNo, selectedRowId, DynamicGridInsertFirstRowEdit) {
		var fieldArray = [];
		var mfld = "";
		var headerGridStart = '<tr class="grp' + gridSerialNo + '" data-rowid="' + selectedRowId + '" id="' + gridSerialNo;
		var headerGridEnd = '">';
		var cuurrentRowData = "";
		var cuurrentRowDataWithComma = "";
		var thClass = "";
	
		for (var t = 0; t < mArray.length; t++) {
			// console.log("in",mArray[t]['dbfieldname']);
			var fldvalue = "";
			var fldvalue1 = "";

			if (mArray[t]['fieldtype'] == 17 || mArray[t]['fieldtype'] == 16) {
				fldvalue = $('#kreon-grid-' + gridSerialNo + mArray[t]['dbfieldname']+'-text').val();
				fldvalue1 = $('#kreon-grid-' + gridSerialNo + '' + mArray[t]['dbfieldname']).val();
			} else {
				fldvalue = $('#kreon-grid-' + gridSerialNo + '' + mArray[t]['dbfieldname']).val();
				// console.log("fldvalue",fldvalue,'#kreon-grid-' + gridSerialNo + '' + mArray[t]['dbfieldname']);
			}

			fieldArray.push([mArray[t]['fieldtype'], 'kreon-grid-' + gridSerialNo + '' + mArray[t]['dbfieldname'], mArray[t]['carryon'], mArray[t]['defaultvalue'], mArray[t]['gridcalculation'], mArray[t]['readonly']]);

			if (mArray[t][26] == 0) {
				thClass = " thHidden ";
			}

			// Building the field HTML (input types)
			if (mArray[t]['fieldtype'] == 1) {
				mfld += "<td class='" + thClass + "'><input readonly type='text' value='" + fldvalue + "' class='form-control' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' id='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "' ></td>";
			}
			if (mArray[t]['fieldtype'] == 3) {
				mfld += "<td class='" + thClass + "'><textarea readonly class='form-control' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' id='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "'>" + fldvalue + "</textarea></td>";
			}
			if (mArray[t]['fieldtype'] == 7) {
				mfld += "<td class='" + thClass + "'><input readonly type='number' value='" + fldvalue + "' class='form-control' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' id='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "'></td>";
			}
			if (mArray[t]['fieldtype'] == 6) {
				mfld += "<td class='" + thClass + "'><input readonly type='date' value='" + fldvalue + "' class='form-control' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' id='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "'></td>";
			}
			if (mArray[t]['fieldtype'] == 5 || mArray[t]['fieldtype'] == 19) {
				var selectedOption = $("#kreon-grid-" + gridSerialNo + "" + mArray[t]['dbfieldname'] + " :selected").text();
				mfld += "<td class='" + thClass + "'><select readonly style='pointer-events: none;' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' id='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "' class='form-control populate'>";
				fldvalue = fldvalue === null ? 0 : fldvalue;
				mfld += "<option value='" + fldvalue + "'>" + selectedOption + "</option>";
				mfld += "</select></td>";
			}

			if (mArray[t]['fieldtype'] == 12) {
				
				mfld += "<td class='" + thClass + "'><input disabled type='text' value='" + fldvalue + "' class='form-control' name='" + gridSerialNo + mArray[t]['dbfieldname'] + "[]' id='" + gridSerialNo + mArray[t]['dbfieldname'] + "'><input type='hidden' id='" + gridSerialNo + mArray[t]['dbfieldname'] + "' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' value='" + fldvalue1 + "'></td>";
			}

			if (mArray[t]['fieldtype'] == 16) {
				
				mfld += "<td class='" + thClass + "'><input disabled type='text' value='" + fldvalue + "' class='form-control' name='" + gridSerialNo + mArray[t]['dbfieldname'] + "-text[]' id='" + gridSerialNo + mArray[t]['dbfieldname'] + "-text'><input type='hidden' id='" + gridSerialNo + mArray[t]['dbfieldname'] + "' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' value='" + fldvalue1 + "'></td>";
			}

			if (mArray[t]['fieldtype'] == 17) {
				mfld += "<td class='" + thClass + "'><input disabled type='text' value='" + fldvalue + "' class='form-control' name='" + gridSerialNo + mArray[t]['dbfieldname'] + "-text[]' id='" + gridSerialNo + mArray[t]['dbfieldname'] + "-text'><input type='hidden' id='" + gridSerialNo + mArray[t]['dbfieldname'] + "' name='" + gridSerialNo + "" + mArray[t]['dbfieldname'] + "[]' value='" + fldvalue1 + "'></td>";
			}

			if(mArray[t]['fieldtype'] == 18){
				mfld += "<td class='"+thClass+"'><input readonly type='time' value='"+fldvalue+"' class='form-control'   name='"+gridSerialNo+""+mArray[t]['dbfieldname']+"[]\'   id='"+gridSerialNo+""+mArray[t]['dbfieldname']+"'></td>";
			}	

			var decimal=  /^-?\d*\.?\d*$/;

			//pass value to sp at adding row
			cuurrentRowData += mArray[t]['dbfieldname']+"=";
			if(mArray[t]['fieldtype'] == 1 || mArray[t]['fieldtype'] == 3 || mArray[t]['fieldtype'] == 6 || mArray[t]['fieldtype'] == 8 || mArray[t]['fieldtype'] == 12 || mArray[t]['fieldtype'] == 13 || mArray[t]['fieldtype'] == 18){
				cuurrentRowData += fldvalue != "" ? fldvalue : "";
			}else if(mArray[t]['fieldtype'] == 2 || mArray[t]['fieldtype'] == 5 || mArray[t]['fieldtype'] == 7 || mArray[t]['fieldtype'] == 9 || mArray[t]['fieldtype'] == 10 || mArray[t]['fieldtype'] == 11 || mArray[t]['fieldtype'] == 15 || mArray[t]['fieldtype'] == 19){
				cuurrentRowData += fldvalue != "" ? fldvalue : 0;
			}else if(mArray[t]['fieldtype'] == 17 || mArray[t]['fieldtype'] == 16){
				cuurrentRowData += fldvalue1 != "" ? fldvalue1 : 0;
			}
			if(t != mArray.length-1)
				cuurrentRowData += "|";

			cuurrentRowDataWithComma += mArray[t]['dbfieldname']+"=";
			if(mArray[t]['fieldtype'] == 0 || mArray[t]['fieldtype'] == 1 || mArray[t]['fieldtype'] == 3 || mArray[t]['fieldtype'] == 6 || mArray[t]['fieldtype'] == 8 || mArray[t]['fieldtype'] == 12 || mArray[t]['fieldtype'] == 13 || mArray[t]['fieldtype'] == 18){
				if(fldvalue == undefined || fldvalue == "" || fldvalue == null){
					cuurrentRowDataWithComma += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
				}else{
					if(fldvalue.match(decimal)) {
						cuurrentRowDataWithComma += (fldvalue != "" && fldvalue != null) ? fldvalue : 0;
					}else{
						cuurrentRowDataWithComma += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
					}
				}
			}else if(mArray[t]['fieldtype'] == 2 || mArray[t]['fieldtype'] == 5 || mArray[t]['fieldtype'] == 7 || mArray[t]['fieldtype'] == 9 || mArray[t]['fieldtype'] == 10 || mArray[t]['fieldtype'] == 11 || mArray[t]['fieldtype'] == 15 || mArray[t]['fieldtype'] == 19){
				cuurrentRowDataWithComma += fldvalue != "" ? fldvalue : 0;
			}else if(mArray[t]['fieldtype'] == 17 || mArray[t]['fieldtype'] == 16){

				cuurrentRowDataWithComma += (fldvalue1 != "" && fldvalue1 != "null") ? "\'\'"+fldvalue1+"\'\'" : "\'\'0\'\'";
			}
			if(t != mArray.length-1)
				cuurrentRowDataWithComma += ",";

		}

		var cnt = $('#cnt' + gridSerialNo).val();
		cnt = +cnt + 1;
		mfld += "<td><a style='padding:3px;margin:2px;' href='javascript:void(0)' class='btn btn-info edits" + gridSerialNo + "'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a><a style='padding:2px 3px;' href='javascript:void(0)' class='btn btn-danger removes" + gridSerialNo + "'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a><input type='hidden' name='" + gridSerialNo + "GridEditID[]' id='" + gridSerialNo + "GridEditID' value='0'><input type='hidden' name='" + gridSerialNo + "GridTempID[]' id='" + gridSerialNo + "GridTempID' value='" + cnt + "'></td>";
		var headofGrid = headerGridStart + '' + cnt + '' + headerGridEnd;

		document.getElementById('cnt' + gridSerialNo).value = cnt;

		// Awaiting the validation AJAX call before proceeding
		try {
			const response = await $.ajax({
				type: "POST",
				dataType: "json",
				data: {
					ValidationOn: "gridsave",
					formData: cuurrentRowData,
					formDataWithComma: cuurrentRowDataWithComma,
					mainFormData: $("form").serialize(),
					FormID: <?php echo $FormID?>,
					GridID: $('#GridId' + gridSerialNo).val(),
					GridRowTempId: cnt
				},
				url: "validateForm.php"
			});

			if (response["status"] == true) {
				if (response["data"]["Success"] == 1) {
					// $('#panel' + gridSerialNo + ' table tbody').append(headofGrid + mfld);
					$('#panel'+gridSerialNo+' table tbody tr:first').after(headofGrid + mfld);
					$(".add" + gridSerialNo).attr("disabled", false);
					if(response["tempData"]){
						$("#"+Object.keys(response["tempData"][0])).empty();
						for(var i=0; i<response["tempData"].length; i++){
							$("#"+Object.keys(response["tempData"][i])).append(Object.values(response["tempData"][i]));
						}
					}
				} else if (response["data"]["Success"] == 2) {
					if (confirm(response["data"]["Msg"] + ". Are you sure you want to submit?")) {
						// $('#panel' + gridSerialNo + ' table tbody').append(headofGrid + mfld);
						$('#panel'+gridSerialNo+' table tbody tr:first').after(headofGrid + mfld);
						$(".add" + gridSerialNo).attr("disabled", false);
						if(response["tempData"]){
							$("#"+Object.keys(response["tempData"][0])).empty();
							for(var i=0; i<response["tempData"].length; i++){
								$("#"+Object.keys(response["tempData"][i])).append(Object.values(response["tempData"][i]));
							}
						}
					} else {
						$(".add" + gridSerialNo).attr("disabled", false);
					}
				} else {
					$(".add" + gridSerialNo).attr("disabled", false);
					alert(response["data"]["Msg"]);
				}

				
				
				// if(ddResponseData['DynamicGridInsertFirstRowEdit'] == 'yes'){
				// 	//if(<?php echo $editID; ?> == 0){
				// 		if(cnt == 1){
				// 			setTimeout(
				// 			function() {
				// 				EditFirstRow(gridSerialNo,mArray);
				// 			},
				// 			300);
				// 		}
				// 	//}
				// }

			}else{
				// $('#panel'+gridSerialNo+' table tbody').append(headofGrid + mfld);
				$('#panel'+gridSerialNo+' table tbody tr:first').after(headofGrid + mfld);
			}



			
			for(var s=0; s < fieldArray.length; s++){
				if(fieldArray[s][2] != 1 && fieldArray[s][2] != 2){
					
					if(fieldArray[s][0] == 5 || fieldArray[s][0] == 19){
						
						if(fieldArray[s][3] == null || fieldArray[s][3].length == 0){

							// Step 1: Get the current onchange function as a string. onchange function remove & then adding because after adding row onchange function triggering so
							let onchangeFunction = $("#" + fieldArray[s][1]).attr("onchange");

							// Step 2: If onchange function exists, store it, remove it temporarily
							if (onchangeFunction) {
								// Step 2: Remove the onchange attribute temporarily
								$("#" + fieldArray[s][1]).removeAttr("onchange");

								// $("#"+fieldArray[s][1]).select2("open");
								$("#"+fieldArray[s][1]).val(0).trigger("change");
								// $("#"+fieldArray[s][1]).select2("close");

								// Step 4: Re-add the original onchange function with the stored value
								$("#" + fieldArray[s][1]).attr("onchange", onchangeFunction);
							}else{
								// $("#"+fieldArray[s][1]).select2("open");
								$("#"+fieldArray[s][1]).val(0).trigger("change");
								// $("#"+fieldArray[s][1]).select2("close");
							}
							
						} else{ //If Default value
							if(fieldArray[s][2] == null || fieldArray[s][2] == 0){
								// $("#"+fieldArray[s][1]).select2("open");
								$("#"+fieldArray[s][1]).val(fieldArray[s][3]).trigger("change");
								// $("#"+fieldArray[s][1]).select2("close");
							}
						}
						//after add if not readonly then remove readonly
						if(fieldArray[s][5] != '1'){
							$("#"+fieldArray[s][1]).next("span").find(".select2-selection--single").prop("readonly", false).css("pointer-events","").css("background-color","white");
						}
					}
					if(fieldArray[s][0] == 17){
						if(fieldArray[s][3] == null || fieldArray[s][3].length == 0){
							fieldName = fieldArray[s][1].split("-");
							// console.log("fieldName "+fieldName);
							$("#"+fieldName[0]+"-"+fieldName[1]+"-"+gridSerialNo+fieldName[2].slice(1)+"-text").val("");
							$("#"+fieldName[0]+"-"+fieldName[1]+"-"+gridSerialNo+fieldName[2].slice(1)).val("");
						}
						
						//after add if not readonly then remove readonly
						if(fieldArray[s][5] != '1'){
							$("#"+fieldName[0]+"-"+fieldName[1]+"-"+gridSerialNo+fieldName[2].slice(1)+"-text").prop("readonly", false).css("pointer-events","").css("background-color","white");
						}
					}else{
						if(fieldArray[s][3] == null){
							$("#"+fieldArray[s][1].trim()).val("");
							$("#"+gridSerialNo+cnt).val(0);
						}else{
							$("#"+fieldArray[s][1]).val(fieldArray[s][3]);	
						}

						//after add if not readonly then remove readonly
						if(fieldArray[s][5] != '1'){
							$("#"+fieldArray[s][1]).prop("readonly", false).css("pointer-events","").css("background-color","white");
						}		
					}

					$("#"+fieldArray[s][1]).css("border","1px solid #aa8a");
				}

				// if(fieldArray[s][2] == 2){
				// 	var fieldValueStr = $("#"+fieldArray[s][1]).val();
				// 	var splitIndex = fieldValueStr.lastIndexOf("-");
				// 	var part1 = fieldValueStr.substring(0, splitIndex); // Before the last hyphen
				// 	var part2 = fieldValueStr.substring(splitIndex + 1); // After the last hyphen

				// 	var increementValue = parseInt(part2)+1;
				// 	if(part1.length > 0){
				// 		var changeValue = part1+"-"+increementValue;
				// 	}else{
				// 		var changeValue = increementValue;
				// 	}
				// 	$("#"+fieldArray[s][1]).val(changeValue);
				// }

				//Cursor focus on grid perticular field that was mention in AfterGridAddCursorPosition field
				// if("'.$d[9].'".length > 1){
					
				// 	if(fieldArray[s][3] == 17){
				// 		if(fieldArray[s][1] == "kreon-grid-'.$d[3].''.$d[9].'-text"){
				// 			$("#"+fieldArray[s][1]).focus();
				// 		}
				// 	}else if(fieldArray[s][3] == 16){
				// 		if(fieldArray[s][1] == "kreon-grid-'.$d[3].''.$d[9].'-text"){
				// 			$("#"+fieldArray[s][1]).focus();
				// 		}
				// 	}else if(fieldArray[s][3] == 5){
				// 		console.log("in");
				// 		if(fieldArray[s][1] == "kreon-grid-'.$d[3].''.$d[9].'"){
				// 			$("#"+fieldArray[s][1]).select2("open");
				// 			$("#"+fieldArray[s][1]).val(0).trigger("change");
				// 			// $("#"+fieldArray[s][1]).select2("close");
				// 		}
				// 	}else{
				// 		if(fieldArray[s][1] == "kreon-grid-'.$d[3].''.$d[9].'"){
				// 			$("#"+fieldArray[s][1]).focus();
				// 		}
				// 	}
				// }
			}



			// if(DynamicGridInsertFirstRowEdit){
			// 	if (DynamicGridInsertFirstRowEdit.includes('yes')) {
			// 		var crsr = DynamicGridInsertFirstRowEdit.split('|')[1]; //cursor position
			// 		if(cnt == 1){
			// 			setTimeout(
			// 			function() {
			// 				EditFirstRow(gridSerialNo,mArray, crsr);
			// 			},
			// 			300);
			// 		}
			// 	} 
			// }
		} catch (error) {
			// console.error('Error:', error);
			$(".add" + gridSerialNo).attr("disabled", false);
		}
	}

	//First Row editable on grid insert dynamically
	// function EditFirstRow(gridSerialNo,mArray, cursorPos = null){
	// 	// alert("hi");
	// 	var row = $("#a1");
	// 	// console.log(row);
	// 	$(row).addClass("being-edited");

	// 	var GridEditId = $(row).find("#"+gridSerialNo+"GridEditID").val();
	// 	var GridTempId = $(row).find("#"+gridSerialNo+"GridTempID").val();

	
	// 	$(".AddEdit a:nth-child(2)").attr("id", 'a1');
	// 	$(".AddEdit a:nth-child(3)").attr("id", 'a1');
	// 	$(".AddEdit").find("#"+gridSerialNo+"GridEditID").val(GridEditId);
	// 	$(".AddEdit").find("#"+gridSerialNo+"GridTempID").val(GridTempId);

	// 	$(".AddEdit a:nth-child(1)").css("display","none");
	// 	$(".AddEdit a:nth-child(2)").show();
	// 	$(".AddEdit a:nth-child(3)").show();

	// 	for(var t=0; t < mArray.length; t++){
	// 		if(mArray[t]['fieldtype'] == 17 || mArray[t]['fieldtype'] == 17){
	// 			var EditFldvalue = $(row).find("#"+gridSerialNo + mArray[t]['dbfieldname'] + "-text").val();
	// 			var EditFldvalue1 = $(row).find("#"+gridSerialNo + mArray[t]['dbfieldname']).val();
	// 		}else if(mArray[t]['fieldtype'] == 12){
	// 			var EditFldvalue = $(row).find("a").attr("href");
	// 			var EditFldvalue1 = $(row).find("#"+gridSerialNo+mArray[t]['dbfieldname']).val();
				
	// 		}else{
	// 			var EditFldvalue = $(row).find("#"+gridSerialNo+mArray[t]['dbfieldname']).val();
	// 		}

	// 		if(mArray[t]['fieldtype'] == 5 || mArray[t]['fieldtype'] == 19){
	// 			var selectedOption = $(row).find("#"+gridSerialNo+mArray[t]['dbfieldname'] + " :selected").text();
	// 			var $newOption = $("<option selected=\"selected\"></option>").val(EditFldvalue).text(selectedOption);

	// 			// $("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).select2('open');
	// 			$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).append($newOption);
	// 			// $("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).select2('close');
	// 		}else if(mArray[t]['fieldtype'] == 17 || mArray[t]['fieldtype'] == 17){
	// 			$("#kreon-grid-"+gridSerialNo + mArray[t]['dbfieldname'] +"-text").val(EditFldvalue);
	// 			$("#kreon-grid-"+gridSerialNo + mArray[t]['dbfieldname']).val(EditFldvalue1);
	// 		}else if(mArray[t]['fieldtype'] == 12){
	// 			if(EditFldvalue1 != 0){
	// 				$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).parent("label").after("<input readonly type='hidden' value='"+EditFldvalue1+"' name='kreon-grid-aimage[]' id='kreon-grid-aimage'><a target=\"_blank\" href='"+EditFldvalue+"'><img src='"+EditFldvalue+"' width='60'></a>");
	// 			}
	// 		}else{
	// 			$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).val(EditFldvalue);

	// 			//Grid calculation on edit button
	// 			// if(mArray[t]['GridCalculation'] > 0){
	// 			// 	CreateOnChangeScriptGridCalculation("kreon-grid-"+gridSerialNo+mArray[t]['DbFieldName'], mArray[t]['GridCalculation'],"grid",0);
	// 			// }
	// 		}

	// 		if(mArray[t]['isnoteditable'] == 1){
	// 			$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).prop("readonly", true); 
	// 		}	
	// 		if(cursorPos && cursorPos.length > 0){
	// 			$("#kreon-grid-"+gridSerialNo + cursorPos).focus();	
	// 		}
	// 	}
	// }

	//First Row editable on grid insert dynamically
	function EditFirstRow(gridSerialNo,mArray, cursorPos = null){

		var row = $("#"+gridSerialNo+"1");
		var row1 = $("#"+gridSerialNo+"0");
		var isFirstRowEditable = false;

		var GridEditId = $(row).find("#"+gridSerialNo+"GridEditID").val();
		var GridTempId = $(row).find("#"+gridSerialNo+"GridTempID").val();

		if (mArray[0]['fieldtype'] == 17 || mArray[0]['fieldtype'] == 16) {
			fldvalue = $('#kreon-grid-' + gridSerialNo + mArray[0]['dbfieldname']+'-text').val();
			fldvalue1 = $('#kreon-grid-' + gridSerialNo + '' + mArray[0]['dbfieldname']).val();
		} else {
			fldvalue = $('#kreon-grid-' + gridSerialNo + '' + mArray[0]['dbfieldname']).val();
			console.log("fldvalue",fldvalue,'#kreon-grid-' + gridSerialNo + '' + mArray[0]['dbfieldname']);
		}

		var cuurrentRowData='';
		var cuurrentRowDataWithComma='';
		//pass value to sp at adding row
		cuurrentRowData += mArray[0]['dbfieldname']+"=";
		if(mArray[0]['fieldtype'] == 1 || mArray[0]['fieldtype'] == 3 || mArray[0]['fieldtype'] == 6 || mArray[0]['fieldtype'] == 8 || mArray[0]['fieldtype'] == 12 || mArray[0]['fieldtype'] == 13 || mArray[0]['fieldtype'] == 18){
			cuurrentRowData += fldvalue != "" ? fldvalue : "";
		}else if(mArray[0]['fieldtype'] == 2 || mArray[0]['fieldtype'] == 5 || mArray[0]['fieldtype'] == 7 || mArray[0]['fieldtype'] == 9 || mArray[0]['fieldtype'] == 10 || mArray[0]['fieldtype'] == 11 || mArray[0]['fieldtype'] == 15 || mArray[0]['fieldtype'] == 19){
			cuurrentRowData += fldvalue != "" ? fldvalue : 0;
		}else if(mArray[0]['fieldtype'] == 17 || mArray[0]['fieldtype'] == 16){
			cuurrentRowData += fldvalue1 != "" ? fldvalue1 : 0;
		}
		

		cuurrentRowDataWithComma += mArray[0]['dbfieldname']+"=";
		if(mArray[0]['fieldtype'] == 0 || mArray[0]['fieldtype'] == 1 || mArray[0]['fieldtype'] == 3 || mArray[0]['fieldtype'] == 6 || mArray[0]['fieldtype'] == 8 || mArray[0]['fieldtype'] == 12 || mArray[0]['fieldtype'] == 13 || mArray[0]['fieldtype'] == 18){
			if(fldvalue == undefined || fldvalue == "" || fldvalue == null){
				cuurrentRowDataWithComma += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
			}else{
				if(fldvalue.match(decimal)) {
					cuurrentRowDataWithComma += (fldvalue != "" && fldvalue != null) ? fldvalue : 0;
				}else{
					cuurrentRowDataWithComma += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
				}
			}
		}else if(mArray[0]['fieldtype'] == 2 || mArray[0]['fieldtype'] == 5 || mArray[0]['fieldtype'] == 7 || mArray[0]['fieldtype'] == 9 || mArray[0]['fieldtype'] == 10 || mArray[0]['fieldtype'] == 11 || mArray[0]['fieldtype'] == 15 || mArray[0]['fieldtype'] == 19){
			cuurrentRowDataWithComma += fldvalue != "" ? fldvalue : 0;
		}else if(mArray[0]['fieldtype'] == 17 || mArray[0]['fieldtype'] == 16){

			cuurrentRowDataWithComma += (fldvalue1 != "" && fldvalue1 != "null") ? "\'\'"+fldvalue1+"\'\'" : "\'\'0\'\'";
		}


		$.ajax({
			type : "POST",
			dataType: "json",
			data : {ValidationOn:"gridedit", formData: cuurrentRowData, formDataWithComma:cuurrentRowDataWithComma, FormID:<?php echo $FormID; ?>, GridID:$("#GridId"+gridSerialNo).val(), GridEditID: GridEditId, GridRowTempId: GridTempId},
			url : "validateForm.php",
			success:function(output) {
				if(output["status"] == true){
					if(output["data"]["Success"] == 1){
						isFirstRowEditable = true;
						
						if(output["data"]["NonEditableFields"]){
										
							return UpdateNonEditableField(output["data"]["NonEditableFields"],"'.$d[3].'");
						}
					}else{
						if(output["data"]["Success"] == 2){
							var cleanedMsg = output["data"]["Msg"]
									.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
									.replace(/\\\\/g, "");     // remove remaining double backslashes
									
							if (confirm(cleanMsg+". Are you sure you want to submit?") == true) {
								isFirstRowEditable = true;
								if(output["data"]["NonEditableFields"]){
										
									return UpdateNonEditableField(output["data"]["NonEditableFields"],"'.$d[3].'");
								}
							} else {
								isFirstRowEditable = false;
							}
						}else if(output["data"]["Success"] == 0){
							var cleanedMsg = output["data"]["Msg"]
								.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
								.replace(/\\\\/g, "");     // remove remaining double backslashes
							alert(cleanedMsg);
							// $(".edits'.$d[3].'").attr("disabled", false);
						}else{
							alert("Internal Server Error");
							$(".add'.$d[3].'").attr("disabled", false);
						}
					}		
				}else{
					isFirstRowEditable = true;
				}

				if(isFirstRowEditable){
					// console.log(row);
					$(row).addClass("being-edited");
			
					$(row1).find(".AddEdit a:nth-child(2)").attr("id", gridSerialNo+'1');
					$(row1).find(".AddEdit a:nth-child(3)").attr("id", gridSerialNo+'1');
					$(row1).find(".AddEdit").find("#"+gridSerialNo+"GridEditID").val(GridEditId);
					$(row1).find(".AddEdit").find("#"+gridSerialNo+"GridTempID").val(GridTempId);
			
					$(row1).find(".AddEdit a:nth-child(1)").css("display","none");
					$(row1).find(".AddEdit a:nth-child(2)").show();
					$(row1).find(".AddEdit a:nth-child(3)").show();
			
					for(var t=0; t < mArray.length; t++){
						if(mArray[t]['fieldtype'] == 17 || mArray[t]['fieldtype'] == 17){
							var EditFldvalue = $(row).find("#"+gridSerialNo + mArray[t]['dbfieldname'] + "-text").val();
							var EditFldvalue1 = $(row).find("#"+gridSerialNo + mArray[t]['dbfieldname']).val();
						}else if(mArray[t]['fieldtype'] == 12){
							var EditFldvalue = $(row).find("a").attr("href");
							var EditFldvalue1 = $(row).find("#"+gridSerialNo+mArray[t]['dbfieldname']).val();
							
						}else{
							var EditFldvalue = $(row).find("#"+gridSerialNo+mArray[t]['dbfieldname']).val();
							$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).val(EditFldvalue);
			
						}
			
						if(mArray[t]['fieldtype'] == 5 || mArray[t]['fieldtype'] == 19){
							var selectedOption = $(row).find("#"+gridSerialNo+mArray[t]['dbfieldname'] + " :selected").text();
							var $newOption = $("<option selected=\"selected\"></option>").val(EditFldvalue).text(selectedOption);
			
							// $("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).select2('open');
							$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).append($newOption);
							// $("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).select2('close');
						}else if(mArray[t]['fieldtype'] == 17 || mArray[t]['fieldtype'] == 17){
							$("#kreon-grid-"+gridSerialNo + mArray[t]['dbfieldname'] +"-text").val(EditFldvalue);
							$("#kreon-grid-"+gridSerialNo + mArray[t]['dbfieldname']).val(EditFldvalue1);
						}else if(mArray[t]['fieldtype'] == 12){
							if(EditFldvalue1 != 0){
								$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).parent("label").after("<input readonly type='hidden' value='"+EditFldvalue1+"' name='kreon-grid-aimage[]' id='kreon-grid-aimage'><a target=\"_blank\" href='"+EditFldvalue+"'><img src='"+EditFldvalue+"' width='60'></a>");
							}
						}else{
							console.log("EditFldvalue",EditFldvalue,"kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']);
							// $("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).val(EditFldvalue);
			
							//  $(row1).find("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).val(EditFldvalue);
							
			
							//Grid calculation on edit button
							// if(mArray[t]['GridCalculation'] > 0){
							// 	CreateOnChangeScriptGridCalculation("kreon-grid-"+gridSerialNo+mArray[t]['DbFieldName'], mArray[t]['GridCalculation'],"grid",0);
							// }
						}
			
						if(mArray[t]['isnoteditable'] == 1){
							$("#kreon-grid-"+gridSerialNo+mArray[t]['dbfieldname']).prop("readonly", true); 
						}	
						if(cursorPos && cursorPos.length > 0){
							var field = $("#kreon-grid-" + gridSerialNo + cursorPos);
							// console.log("pornima fields",field);
							if (!field.is('[readonly]')) {   // only focus if not readonly
								field.focus();
							}
							// $("#kreon-grid-"+gridSerialNo + cursorPos).focus();	
						}
					}

				}
			}
				
			});	
	}

	//On edit validation if noneditablefields get then add readonly in respective field
	function UpdateNonEditableField(NonEditableFieldString, SerialNo){
		var NonEditableFields = NonEditableFieldString.split("|");
		console.log("NonEditableFieldString",NonEditableFields);
		for(var i =0; i < NonEditableFields.length; i++){
			var type = $("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).prop("type");
			// console.log(NonEditableFields[i],type);
			if(type == "text" || type == "date" || type == "number" || type == "email" || type == "textarea" || type == "time" || type == "hidden"){
				console.log("#kreon-grid-" + SerialNo + NonEditableFields[i].trim());
				$("#kreon-grid-" + SerialNo + NonEditableFields[i].trim())
				.siblings("input[id=\'kreon-grid-" + SerialNo + NonEditableFields[i].trim() + "-text\']")
				.each(function () {
					$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()+"-text").css("pointer-events","none").css("background","#eee");
					// $("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()+"-text").prop("readonly",true);
				});

				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none").css("background","#eee");
				
			}else if(type == "select-one"){
				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).next("span").find(".select2-selection--single").css("pointer-events","none").css("background","#eee");
			}else if(type == "select-multiple"){
				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).next("span").find(".select2-selection--multiple").css("pointer-events","none").css("background","#eee");
			}else if(type == "checkbox"){
				if($("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).parent().hasClass("switch-primary") == true){
					$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).parent().css("pointer-events","none");
				}else{
					$("*[id*="+NonEditableFields[i].trim()+"]").each(function() {
						$(this).css("pointer-events","none");
					});
				}
			}else if(type == "radio"){
				$("*[id*="+NonEditableFields[i].trim()+"]").each(function() {
						$(this).css("pointer-events","none");
					});
			}else if(type == "file"){
				if($("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).prop("multiple") == true){
					$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none");
					$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).nextAll().find("span").remove();	
				}
			}else{
				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none").css("background","#eee");
			}
		}
	}

	function RemoveGridRow(gridSerialNo,selectedRowIds,gridRemoveType){
		var cnt = document.getElementById("cnt"+gridSerialNo).value;

		if(gridRemoveType == 'single'){
			for(var i=0; i<=cnt; i++){
				if(i != 0){
					$("#"+gridSerialNo+""+i).remove();
					var rowcount = cnt-i;
					$("#cnt"+gridSerialNo).val(rowcount);
				}
			}
		}else{
			for(var j=0; j<selectedRowIds.length; j++){
				selectedRowIds[j].remove();
				var rowcount = cnt-selectedRowIds.length;
				$("#cnt"+gridSerialNo).val(rowcount);
			}
		}

	}

	function checkMDDField(DBFieldName,DBFieldType){
		var MDDModalValue = [];
		var MDDModalLabel = [];
		var itemvalue = [];
		var itemlabel = [];
		var MDDModalHiddenValue = '';
		var MDDModalHidden = '';
		if(DBFieldType == 16){
			var MDDModalHiddenValue = $('#MultyDDModal-hidden-'+DBFieldName).val();
			var MDDModalHidden = $('#MultyDDModal-'+DBFieldName).val();
			MDDModalLabel = MDDModalHidden.split(',');
		}else if(DBFieldType == 23 || DBFieldType == 14){
			var MDDModalHiddenValue = $('#GridMultyDDModal-hidden-'+DBFieldName).val();
		}
		
		if(MDDModalHiddenValue){
			MDDModalValue = MDDModalHiddenValue.split(',');
			console.log(MDDModalValue);
			if(MDDModalValue.length > 0){
				for(var s=0; s<MDDModalValue.length; s++){
					itemvalue.push(parseInt(MDDModalValue[s]));
				}
	
				if(DBFieldType == 16){
					for(var t=0; t<MDDModalLabel.length; t++){
						itemlabel.push(MDDModalLabel[t]);
					}
				}
				
				// alert(itemlabel);
				return [itemlabel, itemvalue];
			}
		}else{
			return [itemlabel, itemvalue];
		}
	}

	// function SearchFunction(event,DBFieldName,DBFieldType,FormID,GridID,isGrid,gridResponseParams) {
	// 	console.log("search function");
	// 	var x = event.code;
	// 	if(x == 'ArrowDown'){
	// 		$("#ddTable tbody tr:nth-child(1) .select-checkbox").addClass('focus');
	// 		// $(".dataTables_wrapper .dataTables_filter input").focus();
	// 		$("#ddTable tbody tr:nth-child(1) td.select-checkbox:before").focus();
	// 		// $("td.select-checkbox.checkbox_align.focus").click();
	// 	}
	// 	if(x == 'Enter' || x == 'NumpadEnter') {
	// 		//On enter redirect to first page so that search starts from offset 0
	// 		// setTimeout(
	// 			// function() {
	// 				table.page( 0 ).draw( false );
	// 			// }, 100);

	// 		var viewcodeArray = data1['columns'];
	// 		console.log(viewcodeArray);
	// 		var variable = "";
	// 		var value = "";
	// 		for(var m=0; m<viewcodeArray.length; m++){
	// 			if(viewcodeArray[m]['data'] != ""){
	// 				if($("#"+viewcodeArray[m]['data']).val() != undefined && $("#"+viewcodeArray[m]['data']).val() != ""){
	// 					value += $("#"+viewcodeArray[m]['data']).val();
	// 					value += ",";
	// 					variable += viewcodeArray[m]['data']+",";
	// 				}
	// 			}
	// 		}
			
	// 		if (value.charAt(value.length - 1) === ",") {
	// 			value = value.slice(0, -1);
	// 		}
	// 		if (variable.charAt(variable.length - 1) === ",") {
	// 			variable = variable.slice(0, -1);
	// 		}
			
	// 		$("#ddTable").DataTable().destroy();
	// 		if(value != undefined && value != ""){
	// 			console.log("calling load_dd from Search_if");
	// 			load_dd(DBFieldName,DBFieldType,FormID,GridID,isGrid,gridResponseParams,variable,value);
	// 		}else{
	// 			variable = "";
	// 			value = "";
	// 			console.log("calling load_dd from Search_else");
	// 			load_dd(DBFieldName,DBFieldType,FormID,GridID,isGrid,gridResponseParams,variable,value);
	// 		}

	// 		// var value = event.target.value;
	// 		// var variable = event.target.id;
	// 		// console.log(DBFieldName);
	// 		// load_dd(DBFieldName,variable,value);
	// 	}    
	// }

	function validateOnButton(thiss){
		var btnVal = $(thiss).val();
		var editID = $("input[name=editID]").val();
		event.preventDefault();
		validateFormOnSave(event, btnVal, editID);
	}

	//Check validation on submit
	function validateFormOnSave(event,btnVal,editID){
		/* TO CHECK THE ROWS REQUIRED FOR THE GRIDS */
		var gridSerials = ["a", "b", "c", "d", "e", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "aa", "ab", "ac", "ad", "ae", "af", "ag", "ah", "aj", "ak", "al", "am", "an", "ap", "aq", "ar", "au", "av", "aw", "ax", "ay", "az"];
		var gridCount = $('#finalGridCount').val();
		console.log("VALIDATING GRID 1 : ", gridCount)
		for (var i = 0; i < +gridCount; i++){
			var tmpcnt = $("#cnt" + gridSerials[i]).val();
			var reqcnt = $("#cnt" + gridSerials[i]).data('minrowsreq');
			console.log("VALIDATING GRID 2: ", tmpcnt, reqcnt)
			if(+tmpcnt < +reqcnt){
				var gridid = $('#GridId'+gridSerials[i]).val();
				var labelText = $('#grid-id-'+gridid+' label').text().trim();

				alert("Please add rows to the "+labelText+" grid.");
				// alert("Please add rows to the grid.");
				return false;
			}
		}

		// Frontend validation whose input contain data-kvalidation
		var kvalidation = $('input,textarea,select').filter('[data-kvalidation="true"]:visible');
		var allValidate = true;
		kvalidation.each(function(){
			var $this = $(this);
			var val = $this.val();
			var elem = $this.attr('id');

			if(val == ''){  
				allValidate = false;
				$this.css("border","1px solid red").focus();
				var labelText = $this.closest('div').find('label').text().trim();
				alert("Missing data in the field - " + labelText);
				return false; // stop .each()
			} else {
				// If type is date, check min/max
				if($this.attr('type') === 'date'){
					var min = $this.attr('min');
					var max = $this.attr('max');
					
					if ((min && val < min) || (max && val > max)) {
						allValidate = false; // ✅ important
						$this.css("border", "1px solid red").focus();
						alert("Invalid date in field - " + elem + ". Date must be between " + (min || "any") + " and " + (max || "any"));
						$this.val(''); // clear invalid value
						return false; // stop .each()
					}
				}
			}
		});

		$('input,textarea,select').css("border","1px solid #aa8a");
		var required = $('input,textarea,select').filter('[required]:visible');
        var allRequired = true;
        required.each(function(){

			var $this = $(this);
			var val = $this.val();
			var elem = $this.attr('id');
			var type = $this.attr('type');

			// Find label text for this field
			var labelText = $this.closest("div").find("label").first().text().trim();

			// If not found (for custom layout), try nearest label
			if (labelText === "") {
				labelText = elem;
			}

			// Remove * or extra spaces
			labelText = labelText.replace('*', '').trim();

			// check empty OR (number type with value 0)
			if (val === '' || (type === 'number' && Number(val) === 0)) {
				allRequired = false;
				$("#" + elem).css("border", "1px solid red").focus();
				console.log("validateFormOnSave Function - error in validating reqd field", elem);
				var tmp = $("." + elem + " div label").text();
				alert("Missing data in the field - " + labelText);
				return false; // break out of .each()
			}
        });

        if(!allRequired || !allValidate){
            return;
        }
		
		$('#kreonClickButton').val(btnVal);
		event.preventDefault();

		if(!validateSelect2(event)){
			return false;
		}else{
			$('#SaveUpdate').attr('disabled', true);
			$('#SaveUpdateAddMore').attr('disabled', true);
			$('#SaveAndPreview').attr('disabled', true);
			$.ajax({
				type : 'POST',
				dataType: 'json',
				data : {ValidationOn:'save', FormID: <?php echo $FormID; ?>, formData: $('form').serialize(),editID:editID},
				url : 'validateForm.php',
				success : function(result){
					//Success = 0 - show message & stop submit
					//Success = 1 - submit form
					//Success = 2 - show message. If press ok then submit form or if press close then stop submit
					//Success = 3 - show message & stop submit(Error in exicution of query)

					if(result['status'] == true){
						if(result['data']['Success'] == 1){
							$('form').removeAttr("onSubmit");
							$("#callScriptBeforeUnload").val(0);
							$('form').unbind('submit').submit();
						}else if(result['data']['Success'] == 2){
							if (confirm(result['data']['Msg']+'. Are you sure you want to submit?') == true) {
								$('form').removeAttr("onSubmit");
								$("#callScriptBeforeUnload").val(0);
								$('form').unbind('submit').submit();
							} else {
								$('#SaveUpdate').attr('disabled', false);
								$('#SaveUpdateAddMore').attr('disabled', false);
								$('#SaveAndPreview').attr('disabled', false);
							}
						}else if(result['data']['Success'] == 0){
							alert(result['data']['Msg']);
							$('#SaveUpdate').attr('disabled', false);
							$('#SaveUpdateAddMore').attr('disabled', false);
							$('#SaveAndPreview').attr('disabled', false);
						}else{
							alert("Internal Server Error");
							$('#SaveUpdate').attr('disabled', false);
							$('#SaveUpdateAddMore').attr('disabled', false);
							$('#SaveAndPreview').attr('disabled', false);
						}
						
					}else{
						$('form').removeAttr("onSubmit");
						$("#callScriptBeforeUnload").val(0);
						$('form').unbind('submit').submit();
					}
				}
			});
		}	
	}

	function validateSelect2(event){
		// var tmp = $('form select').each(function () { return $(this).attr('id')});	
		console.log("validateSelect2", event);
		var tmp = $('form select').each(function () { return $(this); });
		var returnFlag = true;
		for(var i =0; i < tmp.length; i++){
			var input = $(tmp[i]).attr('id');
			if($('#'+input).hasClass('select2-hidden-accessible')){		
					
				if ($('#'+input).val() == 0 && $('#'+input).prop('required')) {	
					$('#'+input).next('span').find('.select2-selection--single').css('border-color','red')
					$('#'+input).next('span').find('.select2-selection--multiple').css('border-color','red')
					alert('please select '+input);
					returnFlag = false;
					break;
				}
			}
		}
		return returnFlag;
	}

	//Check validation on edit
	function validateFormOnEdit(editID){
		console.log( "validateFormOnEdit", editID)
		$.ajax({
			type : 'POST',	
			dataType: 'json',
			data : {ValidationOn:'edit', FormID: <?php echo $FormID; ?>,EditID: editID, formData: $('form').serialize()},
			url : 'validateForm.php',
			success : function(result){
				// console.log(result);
				if(result['status'] == true){
					if(result['data']['NonEditable'] != undefined && result['data']['NonEditable'].length > 0){
						var NonEditableFields = result['data']['NonEditable'].split(",");
						for(var i =0; i < NonEditableFields.length; i++){
							var type = $('#'+NonEditableFields[i]).prop('type');
							// console.log(type +" "+ NonEditableFields[i]);
							if(type == 'text' || type == 'date' || type == 'number' || type == 'email' || type == 'textarea' || type == 'time'){
								// $('#'+NonEditableFields[i]).attr('readonly','readonly');
								$('#'+NonEditableFields[i]).css('pointer-events','none').css('background','#eee');
							}else if(type == 'select-one'){
								
								// console.log($('#'+NonEditableFields[i]).next('span > span').find('.select2-selection--single'));
								// $("#"+NonEditableFields[i]).select2({disabled:'readonly'});
								// $('#'+NonEditableFields[i]).select2("container").addClass("select2_dropdown_readonly");
								// $('#'+NonEditableFields[i]).next('span').find('.select2-selection--single').addClass("select2_dropdown_readonly");
								
								$('#'+NonEditableFields[i]).next('span').find('.select2-selection--single').css('pointer-events','none').css('background','#eee');
							}else if(type == 'select-multiple'){
								$('#'+NonEditableFields[i]).next('span').find('.select2-selection--multiple').css('pointer-events','none').css('background','#eee');
							}else if(type == 'checkbox'){
								// $('#'+NonEditableFields[i]).on("click", function(){ return false; });
								if($('#'+NonEditableFields[i]).parent().hasClass('switch-primary') == true){
									$('#'+NonEditableFields[i]).parent().css('pointer-events','none');
								}else{
									// $('#'+NonEditableFields[i]).click(function(){return false;});
									$('*[id*='+NonEditableFields[i]+']').each(function() {
										$(this).css('pointer-events','none');
									});
								}
							}else if(type == 'radio'){
								$('*[id*='+NonEditableFields[i]+']').each(function() {
										$(this).css('pointer-events','none');
									});
								// $("input[type='radio']").click(function(){return false;});
							}else if(type == 'file'){
								if($('#'+NonEditableFields[i]).prop('multiple') == true){

									$('#'+NonEditableFields[i]).css('pointer-events','none');
									// console.log($('#'+NonEditableFields[i]).parent());
									$('#'+NonEditableFields[i]).nextAll().find('span').remove();
									
								}else{
									// $('#'+NonEditableFields[i]).parent().css('pointer-events','none');
								}
							}
						}
					}

					if(result["tempData"]){
						// console.log(result["tempData"][0]);
						$("#"+Object.keys(result["tempData"][0])).empty();
						for(var i=0; i<result["tempData"].length; i++){
							$("#"+Object.keys(result["tempData"][i])).append(Object.values(result["tempData"][i]));
						}
					}
				}
			}
		});
	}

	function ConfirmDialog(message) {
		$('<div></div>').appendTo('body')
			.html('<div><h6>' + message + '?</h6></div>')
			.dialog({
				modal: true,
				title: 'Delete message',
				zIndex: 10000,
				autoOpen: true,
				width: 'auto',
				resizable: false,
				buttons: {
					Yes: function() {
					// $(obj).removeAttr('onclick');                                
					// $(obj).parents('.Parent').remove();

					$('body').append('<h1>Are you sure: <i>Yes</i></h1>');

					$(this).dialog("close");
					},
					No: function() {
					$('body').append('<h1>Confirm Dialog Result: <i>No</i></h1>');

					$(this).dialog("close");
					}
				},
				close: function(event, ui) {
					$(this).remove();
				}
			});
	};

	//Check validation on edit
	function validateFormOnDelete(delID){
		// var d = ConfirmDialog("ARE YOU DELETING?");
		console.log("deleted");
		// return;
		$.ajax({
			type : 'POST',	
			dataType: 'json',
			data : {ValidationOn:'delete', FormID: <?php echo $FormID; ?>,DeleteID: delID},
			url : 'validateForm.php',
			success : function(result){
				//Success = 0 - show message & stop delete
				//Success = 1 - delete record
				//Success = 3 - show message & stop submit(Error in exicution of query)

				if(result['status'] == true){
					if(result['data']['Success'] == 1){
						alert('ENTRY DELETED!');
					}else if(result['data']['Success'] == 0){
						alert(result['data']['Msg']);
					}else{
						alert("Internal Server Error");
						$('#SaveUpdate').attr('disabled', false);
						$('#SaveUpdateAddMore').attr('disabled', false);
						$('#SaveAndPreview').attr('disabled', false);
					}
				}
			}
		});
	}


	//Check validation on Lost focus
	function validateOnLostFocusSp(thiss,GridId){
		console.log(thiss);
		var lostFocusSpFieldID = $(thiss).attr('id');
		if(lostFocusSpFieldID == undefined){
			lostFocusSpFieldID = thiss;
		}
		// console.log("==>>validateOnLostFocusSp "+lostFocusSpFieldID+" == "+GridId);
	

		if(GridId > 0){
			
			var gridIdentifier = $('#grid-id-'+GridId).attr('class');		
			var gridSerialNo = gridIdentifier.slice(4);

			var lostFocusSpFieldIDArray = lostFocusSpFieldID.split("-");
			console.log("lostFocusSpFieldIDArray",lostFocusSpFieldIDArray)
			if(lostFocusSpFieldIDArray.includes("text")){
				var newthiss = thiss.replace('-text', '');
				var fieldValue = $("#"+newthiss).val();
				var lostFocusSpField = lostFocusSpFieldIDArray[2].substring(1);
			}else{
				var fieldValue = $(thiss).val();
				var lostFocusSpField = lostFocusSpFieldIDArray[2].substring(1);
			}

			
		}else{
			var fieldValue = $(thiss).val();
			var lostFocusSpField = lostFocusSpFieldID;
		}

		// console.log("fieldvalue",fieldValue);
		// console.log("lostFocusSpField",lostFocusSpField);

		var cuurrentRowData = '';
		var row = $('#'+lostFocusSpFieldID).closest('tr').find('input,select').each(function(){
			var tdid = $(this).attr('id');
			var fieldid = tdid.replace("kreon-grid-"+gridSerialNo, "");
			cuurrentRowData += fieldid.trim()+"="+$('#'+tdid).val();

			cuurrentRowData += "|";
		});
		cuurrentRowData = cuurrentRowData.slice(0, -1)

		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : {ValidationOn:'lostfocus', FormID: <?php echo $FormID; ?>, GridID:GridId, FieldID: lostFocusSpField, fieldValue:fieldValue, formData: $('form').serialize(), cuurrentRowData:cuurrentRowData},
			url : 'validateForm.php',
			success : function(result){
				console.log("lostfocus",result);
				//Success = 0 - show message & stop submit
				//Success = 1 - submit form
				//Success = 2 - show message. If press ok then submit form or if press close then stop submit
				//Success = 3 - show message & stop submit(Error in exicution of query)
				if(result['status'] == true){
					// alert("result data success",result['data']['Success']);
					if(result['data']['Success'] == 0 || result['data']['Success'] == 2){
						alert(result['data']['Msg']);
					}

					if(result['data']['Success'] == 3){
						alert("Internal Server Error");
					}

					// Gridresponse for 5,16,16 be like fieldid : fieldlabel : fieldvalue (partyid : Mehta Distributer : 1456)
					if(result['data']['GridResponse']){
						if(result['data']['GridResponse'].length > 4){
							GridResponse = result['data']['GridResponse'].split("|");
							console.log("GridResponse",GridResponse);
							for(var i=0; i < GridResponse.length; i++){
								GridResponseArray = GridResponse[i].split(":");
								console.log("GridResponse",GridResponse,result['data']['GridResponse'].length,GridResponseArray);
								const GridResponseFieldsType = (GridResponseArray[2] || '').trim();
								
								if(GridResponseFieldsType == 0 || GridResponseFieldsType == 1 || GridResponseFieldsType == 2 || GridResponseFieldsType == 3 || GridResponseFieldsType == 7 || GridResponseFieldsType == 8){
									if(GridId != 0){		
										if(result['data']['Success'] == 0){
											$('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).val('');
										}else{
											$('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).val(GridResponseArray[1].trim());
										}
									}else{
										if(result['data']['Success'] == 0){
											$('#'+GridResponseArray[0].trim()).val('');
										}else{
											$('#'+GridResponseArray[0].trim()).val(GridResponseArray[1].trim());
										}
									}
	
								}else if(GridResponseFieldsType == 5 || GridResponseFieldsType == 19){
									
									if(GridId != 0){
										if(result['data']['Success'] == 0){
											$('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).empty();//.trigger('change');
										}else{
											console.log("field type 5",GridId);
											var $newOption = $("<option selected=\"selected\"></option>").val(GridResponseArray[3].trim()).text(GridResponseArray[1].trim())
											// $('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).select2('open');
											$('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).append($newOption).trigger('change');
											// $('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).select2('close');
										}
									}else{
										if(result['data']['Success'] == 0){
											$('#'+GridResponseArray[0].trim()).empty().trigger('change');
										}else{
											var $newOption = $("<option selected=\"selected\"></option>").val(GridResponseArray[3].trim()).text(GridResponseArray[1].trim());
											// $('#'+GridResponseArray[0].trim()).select2('open');
											$('#'+GridResponseArray[0].trim()).append($newOption);
											// $('#'+GridResponseArray[0].trim()).select2('close');
										}
									}
						
								}else if(GridResponseFieldsType == 17){
									if(GridId != 0){
										if(result['data']['Success'] == 0){
											$('#kreon-grid-'+gridSerialNo + GridResponseArray[0].trim()+'-text').val('');
											$('#kreon-grid-'+gridSerialNo + GridResponseArray[0].trim()).val('');
										}else{
											$('#kreon-grid-'+gridSerialNo + GridResponseArray[0].trim() + '-text').val(GridResponseArray[1]);
											$('#kreon-grid-'+gridSerialNo + GridResponseArray[0].trim()).val(GridResponseArray[3]);
										}
									}else{
										if(result['data']['Success'] == 0){
											$('#'+GridResponseArray[0].trim()+'-text').val('');
											$('#'+GridResponseArray[0].trim()).val('');
										}else{
											$('#'+GridResponseArray[0].trim()+'-text').val(GridResponseArray[1]);
											$('#'+GridResponseArray[0].trim()).val(GridResponseArray[3]);
										}
									}
								}else if(GridResponseFieldsType == 6){
									if(GridResponseArray[1] != ''){
										var dateObj =  GridResponseArray[1].trim();
										console.log(dateObj);
										// var [day, month, year] = dateObj.split("-");
										// var date = new Date(`${year}-${month}-${day}`);
										// var inputDateValue = date.toISOString().split('T')[0];
										var [year, month, day] = dateObj.split("-");  // Notice year comes first!
										var date = new Date(`${year}-${month}-${day}`);  // Use backticks

										var inputDateValue = date.toISOString().split('T')[0]; 
										console.log(inputDateValue);  // Optional: check the result
									}

									if(GridId != 0){
										
										if(result['data']['Success'] == 0){
											$('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).val('');
										}else{
											$('#kreon-grid-'+gridSerialNo+''+GridResponseArray[0].trim()).val(inputDateValue);
										}
									}else{
										
										if(result['data']['Success'] == 0){
											$('#'+GridResponseArray[0].trim()).val();
										}else{
											$('#'+GridResponseArray[0].trim()).val(inputDateValue);
										}
									}
	
								}
							}
						}	
					}

					if(result['data']['NonEditableFields']){
						var NonEditableFields =result['data']['NonEditableFields'].split('|');
						
						for(var k=0; k < NonEditableFields.length; k++){
							var NonEditableFieldArray = NonEditableFields[k].split(':');
							if(NonEditableFieldArray[1].trim() == 'lock'){
								// If field type text, number, textarea, date
								$('#'+NonEditableFieldArray[0].trim()).prop('readonly', true).css('pointer-events','none').css('background-color','#eee');
								// If field type dropdown
								$('#'+NonEditableFieldArray[0].trim()).next('span').find('.select2-selection--single').prop('readonly', true).css('pointer-events','none').css('background-color','#eee');
								// If field type 16/17
								$('#'+NonEditableFieldArray[0].trim())
									.siblings("input[id=\'" + NonEditableFieldArray[0].trim() + "-text\']")
									.each(function () {
										console.log("test1",NonEditableFieldArray[0].trim());
										$("#"+NonEditableFieldArray[0].trim()+"-text").css("pointer-events","none").css("background","#eee");
										$("#"+NonEditableFieldArray[0].trim()+"-text").prop("readonly",true);
									});

							}else{
								// If field type text, number, textarea, date
								$('#'+NonEditableFieldArray[0].trim()).prop('readonly', false).css('pointer-events','').css('background-color','white');
								// If field type dropdown
								$('#'+NonEditableFieldArray[0].trim()).next('span').find('.select2-selection--single').prop('readonly', false).css('pointer-events','').css('background-color','white');
								// If field type 16/17
								$('#'+NonEditableFieldArray[0].trim())
									.siblings("input[id=\'" + NonEditableFieldArray[0].trim() + "-text\']")
									.each(function () {
										console.log("test1",NonEditableFieldArray[0].trim());
										$("#"+NonEditableFieldArray[0].trim()+"-text").css("pointer-events","").css("background","white");
										$("#"+NonEditableFieldArray[0].trim()+"-text").prop("readonly",false);
									});

							}
						}
					}
					console.log("result",result);
					if(result["tempData"]){
						$("#"+Object.keys(result["tempData"][0])).empty();
						for(var i=0; i<result["tempData"].length; i++){
							// console.log(Object.values(result["tempData"][i]));
							// $("#"+Object.keys(result["tempData"][i])).append(Object.values(result["tempData"][i]));
							const original = result["tempData"][i];
							console.log(original);
							// Convert all keys to lowercase
							const lowerCased = Object.keys(original).reduce((acc, key) => {
								acc[key.toLowerCase()] = original[key];
								return acc;
							}, {});
							console.log("lowerCased",lowerCased);
							// Loop through the new object and update corresponding HTML elements
							for (const [key, value] of Object.entries(lowerCased)) {
								const element = $("#" + key);
								if (element.length) {
									element.empty().append(value);
								}
							}
						}
					}
				}

			}
		});
	}

	//Check validation on change
	function validateOnChangeSp(thiss,GridId){
		var onChangeSpFieldID = $(thiss).attr('id');
		if(GridId > 0){
			var onChangeSpFieldIDArray = onChangeSpFieldID.split("-");
			var onChangeSpField = onChangeSpFieldIDArray[2].substring(1);
		}else{
			var onChangeSpField = onChangeSpFieldID;
		}

		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : {ValidationOn:'onchange', FormID: <?php echo $FormID; ?>, FieldID: onChangeSpField, formData: $('form').serialize()},
			url : 'validateForm.php',
			success : function(result){
				//Success = 0 - show message & stop submit
				//Success = 1 - submit form
				//Success = 2 - show message. If press ok then submit form or if press close then stop submit
				//Success = 3 - show message & stop submit(Error in exicution of query)
				
				if(result['status'] == true){
					if(result['data']['Success'] == 0){
						alert(result['data']['Msg']);
					}
					if(result['data']['Success'] == 0){
						alert("Internal Server Error");
					}
					
				}
			}
		});
	}

	//Check validation on change
	function validateOnClick(DBFieldName,validateOnClickSelectedValue,validateOnClickSelectedLabel){
		
		// var onChangeSpFieldID = $(thiss).attr('id');
		// if(GridId > 0){
		// 	var onChangeSpFieldIDArray = onChangeSpFieldID.split("-");
		// 	var onChangeSpField = onChangeSpFieldIDArray[2].substring(1);
		// }else{
			var onClickSpField = DBFieldName;
		// }

		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : {ValidationOn:'onclick', FormID: <?php echo $FormID; ?>, FieldID: onClickSpField, SelectedVALUE:validateOnClickSelectedValue, SelectedLabel:validateOnClickSelectedLabel, formData: $('form').serialize()},
			url : 'validateForm.php',
			success : function(result){
				//Success = 0 - show message & stop submit
				//Success = 1 - submit form
				//Success = 2 - show message. If press ok then submit form or if press close then stop submit
				//Success = 3 - show message & stop submit(Error in exicution of query)

				if(result['status'] == true){
					if(result['data'][0]['Success'] == 0){
						alert(result['data'][0]['Msg']);
					}

					if(result['data'][0]['Success'] == 0){
						alert("Internal Server Error");
					}
				}
			}
		});
	}
	
	$(document).ready(function(){
		// Attach the event to all date inputs
		// $('input[type="date"]').on('keyup blur', function () {
		$('input[type="date"]').on('blur', function () {
			// alert('hi');
			const dateInput = $(this);
			
			const dateValue = dateInput.val();
			
			// Regular expression to check the format YYYY-MM-DD
			const regex = /^(19\d{2}|20\d{2}|21[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/;
			
			// if(dateValue.length == 10 && (dateValue.startsWith('19') || dateValue.startsWith('20'))){
				const fullDate = new Date(dateValue);
				const minDate = new Date(dateInput.attr('min'));
				const maxDate = new Date(dateInput.attr('max'));

				// Check if minDate and maxDate are valid Date objects
				if (minDate != 'Invalid Date' || maxDate !='Invalid Date') {
					if (fullDate && (fullDate < minDate || fullDate > maxDate)) {
						alert("Please enter a date within the allowed range!");
						
						// const dateObj = new Date(); // now
						// const year = dateObj.getFullYear();
						// const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Months are zero-based
						// const day = String(dateObj.getDate()).padStart(2, '0');

						// const todayDate = `${year}-${month}-${day}`;
		
						dateInput.val(null); // Clear the invalid input
					}
				}
			// }



			return;
			// Check if the date input is complete (YYYY-MM-DD format)
			if (dateValue.length >= 10) {  // Minimum length for a valid date (YYYY-MM-DD) is 10 characters
				// Only validate if the date matches the expected format
				console.log(dateValue, regex.test(dateValue));
				if (regex.test(dateValue)) {
					const fullDate = new Date(dateValue);
					const minDate = new Date(dateInput.attr('min'));
					const maxDate = new Date(dateInput.attr('max'));

					// Check if minDate and maxDate are valid Date objects
					if (minDate != 'Invalid Date' || maxDate !='Invalid Date') {
						// Check if the value is out of range
						if (fullDate && (fullDate < minDate || fullDate > maxDate)) {
							alert("Please enter a date within the allowed range!");
							dateInput.val(""); // Clear the invalid input
						}
					} 
				} else {
					console.log('valid date')
				}
			}
		});

		
		//SHIFTED TO K_HEADER
		// $(window).bind('keydown', function(event) {	//FOR SHORTCUTS AROUND THE APPLICATION
		// 	if (event.ctrlKey || event.metaKey) {
		// 		switch (String.fromCharCode(event.which).toLowerCase()) {
		// 			case 's':
		// 				//On ctrl+s save & update form
		// 				event.preventDefault();
		// 				document.getElementById('SaveUpdate').click();
		// 				break;
		// 			case 'e':
		// 				//On ctrl+e preview page open edit form
		// 				event.preventDefault();
		// 				const search = window.location.search;
		// 				const substr = 'preview';
		// 				if(search.includes(substr)){
		// 					const pathname = window.location.pathname;
		// 					const newSearch = search.split('&');
		// 					const nLength = newSearch.length;
		// 					const pathSearch = newSearch[nLength-1].replace('preview','edit');
		// 					window.location.href = pathname+""+newSearch[0]+"&"+pathSearch;
		// 				}
		// 				break;
		// 			case 'p':
		// 				//On ctrl+p save & preview
		// 				event.preventDefault();
		// 				document.getElementById('SaveAndPreview').click();
		// 				break;
		// 			case 'd':
		// 				event.preventDefault();
		// 				document.getElementById('previewDeleteButton').click();
		// 				break;
		// 			case 'x':
		// 				if(data1.AdjustableAmount == 'enable'){
		// 					if (confirm('Are you sure? You want to save adjustment amount.')) {
		// 						$('#saveAdjAmtButton').click();
		// 					}else{
		// 						$('.close-modal').off('click');
		// 					}
		// 				}else{
		// 					$('#saveAdjAmtButton').attr('disabled', false);
		// 					$("#DropDownModal").modal("hide"); 
		// 				}

		// 		}
		// 	}

		// 	if (event.altKey || event.metaKey) {
		// 		switch (String.fromCharCode(event.which).toLowerCase()) {
		// 			case 'a':
		// 				//On alt+a save & open new form
		// 				event.preventDefault();
		// 				document.getElementById('SaveUpdateAddMore').click();
		// 				break;
		// 			case 'f':
		// 				//On alt+f Find from Menu
		// 				event.preventDefault();
		// 				$("#mySearch").focus();
		// 				$('.sidebar-toggle.hidden-xs').click();
		// 				break;
		// 			case 'n':
		// 				//On alt+n listview open new form
		// 				event.preventDefault();
		// 				const search = window.location.search;
		// 				const substr = 'view=1';
		// 				if(search.includes(substr)){
		// 					const pathname = window.location.pathname;
		// 					const newSearch = search.split('&');
		// 					const newUrl = pathname+"?"+newSearch[1];
		// 					window.location.href = newUrl;
		// 				}
		// 				break;
		// 			case 'g':
		// 				//On alt+g grid plus button press
		// 				// var targetIdSplit = event.target.id.split('-');
		// 				// var gridSerialNo = targetIdSplit[2].charAt(0);
		// 				// $(".add"+gridSerialNo).click();

		// 				// alert(targetIdSplit);
		// 				// alert(event.currentTarget.parentNode);
		// 				// alert(event.target.parentElement.parentElement.id);
		// 				var tmp = event.target.parentElement;
		// 				do{
		// 					tmp = tmp.parentElement;
		// 					// alert(tmp.tagName);
		// 				}while(tmp.tagName != 'TABLE');
		// 				var panelID = tmp.parentElement.id;
		// 				// alert(panelID.charAt(0));
		// 				$(".add" + panelID.slice(-1)).click();
		// 				break;
		// 		}
		// 	}
		// });


		// Open Select2 dropdown on focus for respective elements
		$(document).on('focus', '.select2-selection.select2-selection--single', function () {
		const sel = $(this).closest('.select2-container').prev('select');
		if (!sel.data('select2-open')) {
			sel.select2('open');
		}
		});

		// var timepicker = new TimePicker('time', {
		// 	lang: 'en',
		// 	theme: 'dark'
		// });
		// timepicker.on('change', function(evt) {
		// 	var value = (evt.hour || '00') + ':' + (evt.minute || '00');
		// 	evt.element.value = value;
		// });


		$('.amodal').click(function(){ //Open modal for Add Master entry
			var BtnVal = $(this).val().split('-');
			var FormId = BtnVal[0];  //Get formid
			var targetFieldId = BtnVal[1]; //Get target field id
			var formType = BtnVal[2];
			var AddModal = 'AddMoreModal'; //Modal id
			var AddModalForm = 'ModelContent'; //Model bidy id where we display form
			$.ajax({
				type : 'POST',
				dataType: 'json',
				data : {},
				url : '/api/form.php?FormID='+FormId+'&editID=0',
				success : function(result){
					// console.log(result);
					showModalField(result,FormId,targetFieldId,formType,AddModal,AddModalForm); //On ajax response create input fields
				}
			});
		});	

		function showModalField(result, FormId, targetFieldId,formType,AddModal,AddModalForm){
			var code = result['code'];
			var mfld = "";
			var mreqv = [];
			var mreqf = [];	

			mfld += "<div class='container1'><div class='row' ><div class='col-md-12 allfields'>";
			for(var i = 0; i < code.length; i++){
				mreqv[i] = "";
				mreqf[i] ="";
				if(code[i][5] == 1){
					mreqf[i] = 'required';
					mreqv[i] = '<span class="required"> *</span>'
				}
				mfld += "<div class='"+code[i][0]+"'>";
				if(code[i][1] == 1){ //Text
					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label>"+mreqv[i]+"<input class='form-control dyn1' "+mreqf[i]+" type='text' name='"+code[i][0]+"' id='"+code[i][0]+"' value=''></div>";
				}

				if(code[i][1] == 3){ //Textarea
					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label>"+mreqv[i]+"<textarea class='form-control dyn1' "+mreqf[i]+" name='"+code[i][0]+"' id='"+code[i][0]+"' value=''></textarea></div>";
				}

				if(code[i][1] == 6){ //Date
					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label>"+mreqv[i]+"<input class='form-control dyn1' "+mreqf[i]+" type='date' name='"+code[i][0]+"' id='"+code[i][0]+"' value=''></div>";
				}

				if(code[i][1] == 7){ //Number
					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label>"+mreqv[i]+"<input class='form-control dyn1' "+mreqf[i]+" type='number' name='"+code[i][0]+"' id='"+code[i][0]+"' value=''></div>";
				}

				if(code[i][1] == 8){ //Email
					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label>"+mreqv[i]+"<input class='form-control dyn1' "+mreqf[i]+" type='email' name='"+code[i][0]+"' id='"+code[i][0]+"' value=''></div>";
				}

				if(code[i][1] == 5){ //Select From DB
					var v =  result[code[i][0]]['result_set'];
					var k =  result[code[i][0]]['keys'];

					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label>"+mreqv[i]+"<select style='width:-webkit-fill-available;' name='"+code[i][0]+"' id='"+code[i][0]+"'>";

					mfld += "<option value='0' ></option>";

					for(var j=0; j < v.length; j++){ 
						mfld += "<option value='"+v[j][k[0]]+"' >"+v[j][k[1]]+"</option>";
					}

					mfld += "</select></div>";
				}

				if(code[i][1] == 9){ //Checkbox From DB
					var v =  result[code[i][0]]['result_set'];
					var k =  result[code[i][0]]['keys'];
					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label></br>";
					for(var j=0; j < v.length; j++){ 
						mfld += "<label><input '"+code[i][5]+"' type='checkbox' name='"+code[i][0]+"[]' id='"+code[i][0]+"' value=''>"+v[j][k[1]]+"</label></br>";
					}
					mfld += "</div>";
				}

				if(code[i][1] == 4){ //Radio From DB
					var v =  result[code[i][0]]['result_set'];
					var k =  result[code[i][0]]['keys'];
					mfld += "<div class='col-md-6'><label>"+code[i][2]+"</label></br>";

					for(var j=0; j < v.length; j++){ 
						mfld += "<label><input '"+code[i][5]+"' type='radio' name='"+code[i][0]+"' value=''>"+v[j][k[1]]+"</label></br>";
					}

					mfld += "</div>";
				}

				mfld += "</div>";
			}

			mfld += "<input type='hidden' id='formid' value='"+FormId+"'>";
			mfld += "<input type='hidden' id='hiddenTargetField' value='"+targetFieldId+"'>";
			mfld += "<input type='hidden' id='formType' value='"+formType+"'>";
			mfld += "</div></div></div>";
			$('#'+AddModalForm).html(mfld);
			$('#'+AddModal).modal('show');
		}

		$("#modalForm").submit(function(event){
			var targetFieldId = document.getElementById('hiddenTargetField').value;
			var FormID = document.getElementById('formid').value;
			var formType = document.getElementById('formType').value;
			saveAddMaster(targetFieldId,FormID,formType);
			return false;
		});

		function saveAddMaster(targetFieldId,FormID,formType){
			$.ajax({
				type : 'POST',
				dataType: 'json',
				data : $('form#modalForm').serializeArray(),

				url : '/api/appdb.php?FormID='+FormID,

				success : function(result){
					console.log(result['data']);
					if(formType == 14){
						var gridIdentifier = ($('#'+targetFieldId).parent().parent().attr("id")).slice(0,1);
						var gridCnt = $("#cnt" + gridIdentifier).val();
						var lastElementFlag = false;			

						for(var i = gridCnt - 1; i >= 0; i--){
							// debugger;
							if($('#' + gridIdentifier + i ).length){ //if element exists
								if(!lastElementFlag){	//if last element then select the added value
									if($('#' + gridIdentifier + i +' select[name="aQualityName[]"]').val() > 0){ //If last element has pre selected value then add a new row
										$('.add' + gridIdentifier).click();
										i++;
									}

									$('#' + gridIdentifier + i + ' select[name="aQualityName[]"]').append($("<option></option>")
										.attr("value", result['data'][0]['ID'])
										.text(result['data'][0]['Name']));
									lastElementFlag = true;
									$('#' + gridIdentifier + i +' select[name="aQualityName[]"]').val(result['data'][0]['ID']).trigger('change');
								}else{

									$('#' + gridIdentifier + i + ' select[name="aQualityName[]"]').append($("<option></option>")
									.attr("value", result['data'][0]['ID'])
									.text(result['data'][0]['Name']))
								}
							}
						}
					}else{
						$('#'+targetFieldId).append($("<option></option>")
						.attr("value", result['data'][0]['ID'])
						.text(result['data'][0]['Name']));
						$('#'+targetFieldId).val(result['data'][0]['ID']).trigger('change');
					}

					$("#AddMoreModal").modal('hide');
					// $('#success-info').show();
					// $("#success-info").delay(5000).fadeOut(); 
				},
			});
		}
	});

	//Check value is exist or not
	function onLostFocus(thiss,editID,type){
		var thissParameters = $("#" + thiss.id + "-hidden").val();
		var fieldName = $(thiss).attr('id');
		var fieldValue = $(thiss).val();
		
		var str1 = "response";
		var responsePos = -1;
		if(thissParameters.indexOf(str1) != -1){
			responsePos = thissParameters.indexOf(str1);
		}

		var str2 = "DB";
		var dbPos = -1;
		if(thissParameters.indexOf(str2) != -1){
			dbPos = thissParameters.indexOf(str2);
		}

		var newArr = ["", ""];
		if(dbPos != -1 && responsePos != -1){ //to split between both the parameters

			var splitIndex = dbPos > responsePos ? dbPos : responsePos;
 			newArr[0] = thissParameters.substring(0, splitIndex - 1)
 			newArr[1] = thissParameters.substring(splitIndex);
	
			var responseParams = newArr[0].substring(
						newArr[0].indexOf("{") + 1, 
						newArr[0].lastIndexOf("}")
					);

			var dbParams = newArr[1].substring(
						newArr[1].indexOf("{") + 1, 
						newArr[1].lastIndexOf("}")
					);

			// console.log(responseParams);	//#Broker : 5 | response.ID | response.Name
			// console.log(dbParams);
			var responseP = responseParams.split(',');	//THIS will give all the parameters required in response
			var finalParams = [];
			var finalParamsValue = [];
			var Parameters = [];
			var flag = 0;
		
			for(var i = 0; i < responseP.length; i++){
				finalParams[i] = responseP[i].trim().split('|');
				for(var j=0; j<finalParams[i].length; j++)	{
					
					if(finalParams[i][j].trim().toLowerCase() == 'divisionid'){
						finalParamsValue[j] =  '<?php echo $_SESSION['dbDivision']; ?>';
					}else if(finalParams[i][j].trim().toLowerCase() == 'companyid'){
						finalParamsValue[j] =  '<?php echo $_SESSION['dbCompany']; ?>';
					}else{
						finalParamsValue[j] =  $('#'+finalParams[i][j].trim()).val();
					}

					if(finalParamsValue[j].length > 0){
						flag = 1;
						if(editID == 0){
							if(type == 'grid'){
								var finalParamsGridFieldSplit = finalParams[i][j].split('-');
								var paramkv = finalParamsGridFieldSplit[2].substring(1) + "=" + "'"+finalParamsValue[j]+"'";
							}else{
								var paramkv = finalParams[i][j] + "=" + "'"+finalParamsValue[j]+"'";
							}
						}else{

							var paramkv = finalParams[i][j] + "=" + "'"+finalParamsValue[j]+"'";
						}
						Parameters.push(paramkv);
					}
				}
			}
		}


		if(flag == 1){
			$.ajax({
				type : 'POST',
				dataType: 'json',
				data : {selectedValue: Parameters, editId: editID, fromRepo: dbParams},
				url : 'checkDuplicateData.php',
				success : function(result){
					//CHECK TYPE OF PARAMETERS
					// console.log(result);
					if(result['rows'] > 0){
						if(editID == 0){
							alert(fieldValue+" already exists.");
						}else{
							$( "."+fieldName ).find('div').append( "<p id='"+fieldName+"-hide' style='color:red;'>"+fieldValue+" already exists.</p>" );
							setTimeout(function() {
								$("#"+fieldName+"-hide").remove();
							}, 2000);
						}
						$("#"+fieldName).val('');

					}
									
				}
			});
		}
	}

	//Exicute given formula & place value in perticular field (NOTE- for calculation onkeyupparameter using so this function no longer need)
	// function onLostFocusCalculation(thiss,type,gridSerialNo){
	// 	var thissParameters = $("#" + thiss.id + "-hidden").val();
	
	// 	var str1 = "Formula";
	// 	var FormulaPos = -1;
	// 	if(thissParameters.indexOf(str1) != -1){
	// 		FormulaPos = thissParameters.indexOf(str1);
	// 	}

	// 	var str2 = "responseField";
	// 	var responseFieldPos = -1;
	// 	if(thissParameters.indexOf(str2) != -1){
	// 		responseFieldPos = thissParameters.indexOf(str2);
	// 	}

	// 	var newArr = ["", ""];
	// 	if(FormulaPos != -1 && responseFieldPos != -1){ //to split between both the parameters

	// 		var splitIndex = FormulaPos > responseFieldPos ? FormulaPos : responseFieldPos;
 	// 		newArr[0] = thissParameters.substring(0, splitIndex - 1)
 	// 		newArr[1] = thissParameters.substring(splitIndex);
	
	// 		var FormulaParams = newArr[0].substring(
	// 			newArr[0].indexOf("{") + 1, 
	// 			newArr[0].lastIndexOf("}")
	// 		);

	// 		var responseFieldParams = newArr[1].substring(
	// 			newArr[1].indexOf("{") + 1, 
	// 			newArr[1].lastIndexOf("}")
	// 		);

	// 	}
	// 	if(FormulaParams.length > 1){
	// 		var extractedparameters = FormulaParams.replace(/\*+/g, ' * ').replace(/\++/g, ' + ').replace(/\-+/g, ' - ').replace(/\\+/g, ' \ ');
			
			
	// 		var parameters = extractedparameters.split(" ");
	// 		var requestParams = '';

	// 		for(var i=0; i<parameters.length; i++){
	// 			if(parameters[i].indexOf("*") >= 0 || parameters[i].indexOf("+") >= 0 || parameters[i].indexOf("*") >= 0 || parameters[i].indexOf("/") >= 0 || parameters[i].indexOf("=") >= 0){
	// 				requestParams += parameters[i].trim() +" ";
	// 			}else{
	// 				if(parameters[i].length > 1){
	// 					if(type == 'grid'){
	// 						requestParams += $('#kreon-grid-'+gridSerialNo+parameters[i]).val();
	// 					}else{
	// 						requestParams += $('#'+parameters[i]).val();
	// 					}
	// 				}
	// 			}
	// 		}
	// 	}
		

	// 	if(responseFieldParams.length > 1){
	// 		if(type == 'grid'){
	// 			$('#kreon-grid-'+gridSerialNo+responseFieldParams).val(eval(requestParams));
	// 		}else{
	// 			$('#'+responseFieldParams).val(eval(requestParams));
	// 		}
	// 	}
	// }

	function dynamicFreeFill(thiss){
		var str1 = "response";
		var responsePos = -1;
		if(thiss.indexOf(str1) != -1){
			responsePos = thiss.indexOf(str1);
		}
		var str2 = "url";
		var urlPos = -1;
		if(thiss.indexOf(str2) != -1){
			urlPos = thiss.indexOf(str2);
		}

		var newArr = ["", ""];
		if(urlPos != -1 && responsePos != -1){ //to split between both the parameters
			var splitIndex = urlPos > responsePos ? urlPos : responsePos;
 			newArr[0] = thiss.substring(0, splitIndex - 1)
 			newArr[1] = thiss.substring(splitIndex);
			// console.log(newArr[0]);
			// console.log(newArr[1]);
			var responseParams = newArr[0].substring(
						newArr[0].indexOf("{") + 1, 
						newArr[0].lastIndexOf("}")
					);

			var urlParams = newArr[1].substring(
						newArr[1].indexOf("{") + 1, 
						newArr[1].lastIndexOf("}")
					);

			// console.log(responseParams);	//#Broker : 5 | response.ID | response.Name
			// console.log(urlParams);
			var responseP = responseParams.split(',');	//THIS will give all the parameters required in response
			var finalParams = [];
			for(var i = 0; i < responseP.length; i++){
				finalParams[i] = responseP[i].trim().split('|');
			}
		}
		// console.log(finalParams);
		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : {},
			url : urlParams,
			success : function(result){
				//CHECK TYPE OF PARAMETERS
				console.log(result);
				for(var i = 0; i < finalParams.length; i++){
					if(finalParams[i][1].trim() == 0 || finalParams[i][1].trim() == 1 || finalParams[i][1].trim() == 3 || finalParams[i][1].trim() == 6 || finalParams[i][1].trim() == 7 || finalParams[i][1].trim() == 8 ){	//type = textbox & others //#TrspPay | 1 | TrspPay 
						$(finalParams[i][0].trim()).val(result[finalParams[i][2].trim()]);
					}
				}				
			}
		});
	}

	async function CreateOnChangeScriptGridCalculation(gridCalculationFieldNames, gridCalculationTypes, gridSerialNo) {

		console.log("in CreateOnChangeScriptGridCalculation");
		console.log(gridCalculationFieldNames);
		console.log(gridCalculationTypes);
		// console.log(gridSerialNo);

		try {
			// Get the number of rows excluding the header
			var noOfRows = $('#cnt' + gridSerialNo).val();
			
			// Initialize an array to hold the results for each column
			var columnResults = new Array(gridCalculationFieldNames.length).fill(0);
			var columnCounts = new Array(gridCalculationFieldNames.length).fill(0); // Track non-empty values for count

			// Use async/await to wait for the DOM manipulation before proceeding
			await calculateColumnResults(noOfRows, gridCalculationFieldNames, gridCalculationTypes, gridSerialNo, columnResults, columnCounts);

			// Assuming you want to add a footer row with the result for each column
			updateFooterWithColumnResults(gridSerialNo, gridCalculationFieldNames, columnResults, columnCounts, gridCalculationTypes, noOfRows);

		} catch (error) {
			console.error("Error in calculation:", error);
		}	
	}

	async function calculateColumnResults(noOfRows, gridCalculationFieldNames, gridCalculationTypes, gridSerialNo, columnResults, columnCounts) {
		// console.log("calculateColumnResults",noOfRows, gridCalculationFieldNames, gridCalculationTypes, gridSerialNo, columnResults, columnCounts) ;
		return new Promise(resolve => {
			setTimeout(() => {
				// console.log(gridSerialNo);
				var rows = document.querySelectorAll(`.tmp_GridTable${gridSerialNo} tbody tr.grp${gridSerialNo}:not(#a0):not(.hidden)`);
				// console.log("IN CAL",rows);

				rows.forEach(row => {
					gridCalculationFieldNames.forEach((field, index) => {
						// const input = row.querySelector(`[name$="${field}[]"]`);
						const input = row.querySelector(`[name="${gridSerialNo}${field}[]"]`); //changed by mitesh due to issue with the above code
						const value = parseFloat(input?.value);
						// console.log("input",input,value);
						if (!isNaN(value)) {
							switch (gridCalculationTypes[index]) {
								case 1: columnResults[index] += value; break; // Sum
								case 2: columnResults[index] += value; columnCounts[index]++; break; // Avg
								case 3: columnCounts[index]++; break; // Count
							}
						}
						// console.log("calculating:", value, field, index, columnResults[index], input);
					});
				});
				// console.log(columnResults, columnCounts);
				
				resolve();
			}, 1000); // Simulate async delay
		});
	}

	// Function to update footer values based on column results (sum, average, count)
	function updateFooterWithColumnResults(gridSerialNo, gridCalculationFieldNames, columnResults, columnCounts, gridCalculationTypes, noOfRows) {
		
		for (var j = 0; j < gridCalculationFieldNames.length; j++) {
			// Find the footer element for this column
			var footerElement = $('#' + gridSerialNo + gridCalculationFieldNames[j] + "Footer");
		
			
			if (footerElement.length > 0) {
				if (gridCalculationTypes[j] === 1) { // Sum
					// footerElement.val(Math.round(columnResults[j] * 100) / 100);

					//updated this code by pornima for decimal places not showing proper on date 21/3/2025
					var decimalPlaces = $("#kreon-grid-"+gridSerialNo+""+ gridCalculationFieldNames[j].trim()).data('key');
					if(decimalPlaces == undefined){
						footerElement.val(columnResults[j]);
					}else{
						// console.log("footerelement", footerElement,gridSerialNo + gridCalculationFieldNames[j],columnResults[j]);
						footerElement.val(Math.round(columnResults[j] * Math.pow(10, decimalPlaces)) / Math.pow(10, decimalPlaces));
					}
					//previous code
					// footerElement.val(columnResults[j]);

				} else if (gridCalculationTypes[j] === 2) { // Average
					// Calculate average by dividing the sum by the total number of rows
					if (noOfRows > 0) {
						var average = columnResults[j] / noOfRows;
						// footerElement.val(Math.round(average * 100) / 100); // Round average to 2 decimal places
						footerElement.val(average); // Round average to 2 decimal places

						// footerElement.val(columnResults[j] / noOfRows);
					} else {
						footerElement.val(0); // Avoid division by zero
					}
				} else if (gridCalculationTypes[j] === 3) { // Count
					footerElement.val(columnCounts[j]);
				}
			}
		}
	}


	// function CreateOnChangeScriptGridCalculation(thiss, calcuType, type, currentrowno) {
	// 	// console.log("CreateOnChangeScriptGridCalculation",thiss, calcuType, type, currentrowno)
	// 	var fieldId = thiss;
	// 	// Extract the footer ID from the field ID
	// 	var splitString = fieldId.split('kreon-grid-');
	// 	var footerID = splitString[1].slice(1) + "Footer";

	// 	var sum = 0;
	// 	var arrayvalue = [];
	// 	var fieldvalue, footerValue = 0;
		
	// 	// Get the current value of the changed field
	// 	fieldvalue = $("#" + fieldId).val();
		
	// 	// Get the footer value or initialize it to 0
	// 	footerValue = $("#" + footerID).val();
	// 	if (footerValue === "") {
	// 		footerValue = 0;
	// 	}

	// 	// Get the number of rows excluding the header
	// 	var noOfRows = $('#cnt'+splitString[1][0]).val();

	// 	// Handle case when there's an active editing row
	// 	var element = $(".AddEdit a:nth-child(2)");
	// 	var editRowId = element.attr("id");

	// 	// If no edit row, proceed with recalculating for all rows
	// 	setTimeout(
	// 		function() {
	// 			for (var i = 0; i < noOfRows; i++) {
	// 				var columnID = splitString[1][0] + (i+1);
	// 				var fieldvalue = $("#" + columnID + " td #" + splitString[1]).val();
	// 				// console.log("#" + columnID + " td #" + splitString[1], fieldvalue);
					
	// 				//Next 6 lines added by Mitesh as we dont want hidden rows for CUTPACK
	// 				var checkHiddenKeyword = $("#" + columnID ).attr("class");	
	// 				// console.log(checkHiddenKeyword)
	// 				if(checkHiddenKeyword !== undefined){
	// 					if(checkHiddenKeyword.indexOf("hidden") != -1){
	// 						continue;
	// 					}
	// 				}
	// 				if (fieldvalue !== undefined && fieldvalue !== '') {
	// 					arrayvalue.push(fieldvalue);
	// 				}
	// 			}

	// 			// Perform calculation based on the type selected
	// 			var calculation;
	// 			if (calcuType === 1) {
	// 				// Sum Calculation
	// 				calculation = arrayvalue.reduce(function (acc, val) {
	// 					return acc + parseFloat(val);
	// 				}, 0);
	// 			} else if (calcuType === 2) {
	// 				// Average Calculation
	// 				if (type === 'dynamic') {
	// 					calculation = arrayvalue.reduce(function (acc, val) {
	// 						return acc + parseFloat(val);
	// 					}, 0);

	// 					$("#" + footerID).val(calculation);

	// 					if (currentrowno === noofrows - 1) {
	// 						footerValue = $("#" + footerID).val();
	// 						calculation = footerValue / noofrows;
	// 					}
	// 				} else {
	// 					var average = arrayvalue.reduce(function (acc, val) {
	// 						return acc + parseFloat(val);
	// 					}, 0);
	// 					calculation = average / arrayvalue.length;
	// 				}
	// 			} else if (calcuType === 3) {
	// 				// Count Calculation
	// 				if (type === 'dynamic') {
	// 					calculation = noofrows;
	// 				} else {
	// 					calculation = arrayvalue.length;
	// 				}
	// 			}

	// 			// Update the footer value with the calculated result
	// 			$("#" +splitString[1][0]+ footerID).val(calculation);

	// 	}, 1050);
	// }

	// function CreateOnChangeScriptGridCalculation(thiss, calcuType, type, currentrowno) {
		
	// 	if(type == "dynamic"){
	// 		var fieldId = thiss;
	// 	}else{

	// 		var fieldId = thiss[1];
	// 	}
	// 	console.log(fieldId);

	// 	// Extract the footer ID from the field ID
	// 	var splitString = fieldId[0];
	// 	var footerID = fieldId.slice(1) + "Footer";

	// 	var sum = 0;
	// 	var arrayvalue = [];
	// 	var fieldvalue, footerValue = 0;
		
	// 	// Get the current value of the changed field
	// 	// fieldvalue = $("#" + fieldId).val();
		
	// 	// Get the footer value or initialize it to 0
	// 	footerValue = $("#" + footerID).val();
	// 	if (footerValue === "") {
	// 		footerValue = 0;
	// 	}

	// 	// var table = $('#panel'+splitString[1][0]).find('#GridTable').find('tbody tr');
	// 	// console.log(table);
	// 	// Get the number of rows excluding the header
		
	// 	var noOfRows = $('#cnt'+splitString).val();

	// 	// Handle case when there's an active editing row
	// 	var element = $(".AddEdit a:nth-child(2)");
	// 	var editRowId = element.attr("id");

	// 	console.log(noOfRows);
	// 	// If no edit row, proceed with recalculating for all rows
	// 	if (editRowId === undefined) {
	// 		console.log('new row');
	// 		// Loop through all rows to collect column data
	// 		// arrayvalue.push($('#'+thiss).val());
	// 		for (var i = 0; i < noOfRows; i++) {
	// 			var columnID = splitString[0] + (i+1);
	// 			var fieldvalue = $("#" + columnID).find("td input#"+fieldId).val();

	// 			if (fieldvalue !== undefined && fieldvalue !== '') {
	// 				arrayvalue.push(fieldvalue);
	// 			}
	// 		}
	// 	} else {
	// 		console.log('edit row');
	// 		// Handle recalculating while editing a specific row
	// 		for (var i = 0; i < noOfRows; i++) {
	// 			var columnID = "a" + i;

	// 			if (editRowId !== columnID) {
	// 				var fieldvalue = $("#" + columnID + " td #" + splitString[1]).val();
	// 				if (fieldvalue !== undefined && fieldvalue !== '') {
	// 					arrayvalue.push(fieldvalue);
	// 				}
	// 			}

	// 			if (editRowId === columnID) {
	// 				var fieldvalue1 = $("#" + fieldId).val();
	// 				if (fieldvalue1 !== undefined && fieldvalue1 !== '') {
	// 					arrayvalue.push(fieldvalue1);
	// 				}
	// 			}
	// 		}
	// 	}
		
	// 	console.log(arrayvalue);
	// 	// Perform calculation based on the type selected
	// 	var calculation;
	// 	if (calcuType === 1) {
	// 		// Sum Calculation
	// 		calculation = arrayvalue.reduce(function (acc, val) {
	// 			return acc + parseFloat(val);
	// 		}, 0);
	// 	} else if (calcuType === 2) {
	// 		// Average Calculation
	// 		if (type === 'dynamic') {
	// 			calculation = arrayvalue.reduce(function (acc, val) {
	// 				return acc + parseFloat(val);
	// 			}, 0);

	// 			$("#" + footerID).val(calculation);

	// 			if (currentrowno === noofrows - 1) {
	// 				footerValue = $("#" + footerID).val();
	// 				calculation = footerValue / noofrows;
	// 			}
	// 		} else {
	// 			var average = arrayvalue.reduce(function (acc, val) {
	// 				return acc + parseFloat(val);
	// 			}, 0);
	// 			calculation = average / arrayvalue.length;
	// 		}
	// 	} else if (calcuType === 3) {
	// 		// Count Calculation
	// 		if (type === 'dynamic') {
	// 			calculation = noofrows;
	// 		} else {
	// 			calculation = arrayvalue.length;
	// 		}
	// 	}
		
	// 	// Update the footer value with the calculated result
	// 	if(!isNaN(calculation)){

	// 		$("#" + footerID).val(calculation);
	// 	}
	// }

	// function CreateOnChangeScriptGridCalculation(thiss, calcuType, type, currentrowno){
	// 	// 1 = for sum
	// 	// 2 = for average
	// 	// 3 = For count
	// 	var table = document.getElementById("GridTable");
	// 	var fieldId = thiss;

	// 	// var gridIdentifier = $(thiss).parent().closest('tr').attr('id');
	// 	var sum = 0;
	// 	var arrayvalue = [];
	// 	var splitString = fieldId.split('kreon-grid-');
	// 	var footerID = splitString[1].slice(1)+"Footer";

	// 	var fieldvalue, footerValue = 0;
	// 	fieldvalue = $("#"+fieldId).val();
	// 	footerValue = $("#"+footerID).val();

	// 	var noOfRows = table.rows.length-1;

	// 	var element = $(".AddEdit a:nth-child(2)");
	// 	var editRowId = '';
	// 	editRowId = element.attr("id");

	// 	if(footerValue == ""){
	// 		footerValue = 0;
	// 	}

	// 	// for(var i=0; i<noOfRows; i++){
	// 	// 	var columnID = "a"+i;
	// 	// 	if(editRowId == undefined){
	// 	// 		if(i == 0){
	// 	// 			var fieldvalue1=$("#" + fieldId).val();
	// 	// 			if(fieldvalue1 != undefined){
	// 	// 				arrayvalue.push(fieldvalue1);
	// 	// 			}

	// 	// 			var fieldvalue=$("#" + columnID + " td " + "#" + splitString[1]).val();
	// 	// 			if(fieldvalue != undefined && fieldvalue != ''){
	// 	// 				arrayvalue.push(fieldvalue);
	// 	// 			}else if(fieldvalue == ''){
	// 	// 				return;
	// 	// 			}

	// 	// 		}else{
	// 	// 			var fieldvalue=$("#" + columnID + " td " + "#" + splitString[1]).val();
	// 	// 			if(fieldvalue != undefined && fieldvalue != ''){
	// 	// 				arrayvalue.push(fieldvalue);
	// 	// 			}else if(fieldvalue == ''){
	// 	// 				return;
	// 	// 			}
	// 	// 		}
	// 	// 	}else{  
	// 	// 		if(editRowId != columnID){
	// 	// 			var fieldvalue=$("#" + columnID + " td " + "#" + splitString[1]).val();
	// 	// 			if(fieldvalue != undefined && fieldvalue != ''){
	// 	// 				arrayvalue.push(fieldvalue);
	// 	// 			}else if(fieldvalue == ''){
	// 	// 				return;
	// 	// 			}
	// 	// 		}
				
	// 	// 		if(editRowId == columnID){
	// 	// 			var fieldvalue1=$("#" + fieldId).val();
	// 	// 			if(fieldvalue1 != undefined && fieldvalue1 != ''){
	// 	// 				arrayvalue.push(fieldvalue1);
	// 	// 			}else if(fieldvalue1 == ''){
	// 	// 				return;
	// 	// 			}
	// 	// 		}		
	// 	// 	}	
	// 	// }

	// 	if(editRowId == undefined){

	// 		if(editRowId == undefined){
	// 			var fieldvalue1=$("#" + fieldId).val();
	// 			if(fieldvalue1 != undefined){
	// 				arrayvalue.push(fieldvalue1);
	// 			}
	// 			arrayvalue.push(footerValue);
	// 		}
	// 	}else{
	// 		for(var i=0; i<noOfRows; i++){
	// 			var columnID = "a"+i;

	// 			// alert(editRowId+ " == " +columnID);
	// 			if(editRowId != columnID){
	// 				var fieldvalue=$("#" + columnID + " td " + "#" + splitString[1]).val();
	// 				if(fieldvalue != undefined && fieldvalue != ''){
	// 					arrayvalue.push(fieldvalue);
	// 				}else if(fieldvalue == ''){
	// 					return;
	// 				}
	// 			}

	// 			if(editRowId == columnID){
	// 				var fieldvalue1=$("#" + fieldId).val();
	// 				if(fieldvalue1 != undefined && fieldvalue1 != ''){
	// 					arrayvalue.push(fieldvalue1);
	// 				}else if(fieldvalue1 == ''){
	// 					return;
	// 				}
	// 			}		
				
	// 		}
	// 	}

	// 	var calculation;
	// 	// if(type == 'dynamic'){
	// 	// 	arrayvalue.push(footerValue);
	// 	// }

	// 	if(calcuType == 1){

	// 		calculation = eval(arrayvalue.join('+'));

	// 	}else if(calcuType == 2){
	// 		if(type == 'dynamic'){
	// 			calculation = eval(arrayvalue.join('+'));
	// 			$("#" + footerID).val(calculation);

	// 			if(currentrowno == noofrows-1){
	// 				footerValue = $("#"+footerID).val();
	// 				calculation = footerValue / noofrows;
	// 			}
	// 		}else{
	// 			var average = eval(arrayvalue.join('+'));
	// 			calculation = average / arrayvalue.length;
	// 		}
	// 	}else if(calcuType == 3){
	// 		if(type == 'dynamic'){
	// 			calculation = noofrows;
	// 		}else{
	// 			calculation = arrayvalue.length;
	// 		}
	// 	}

	// 	$("#" + footerID).val(calculation);
	// }

	// Function to handle the isnull() expression dynamically
	function handleIsNullInString(str, gridSerial) {
		// Regular expression to find isnull() and capture the content inside
		let isNullPattern = /isnull\(([^,]+),\s*([^)]*)\)/g;  // Matches isnull(disc, 0.0)

		// Replace the isnull() expression dynamically
		return str.replace(isNullPattern, (match, fieldName, defaultValue) => {
			var fieldValue = $("#kreon-grid-"+gridSerial+""+ fieldName).val();
			console.log(fieldName,fieldValue);
			// Dynamically evaluate the expression for disc (e.g., variable)
			let discValueUsed = eval(fieldValue) === null ? parseFloat(defaultValue) : eval(fieldValue);

			// Return the replacement expression
			return discValueUsed;
		});
	}

	function CreateOnkeyupScriptGrid(thisElement,type,insertType){
		// alert(type);
		console.log("==>>CreateOnkeyupScriptGrid");
		var total = 1;
		var flag = 0;
		if(type == 'grid'){
			if(insertType == 'dynamic'){
				var thiss = $("#" + thisElement + "-onkeyup-hidden").val();
				var splitFieldName = thisElement.split('kreon-grid-');
				var gridSerial = splitFieldName[1].charAt(0);
			}else{
				
				var thiss = $("#" + thisElement.name.slice(0,-2) + "-onkeyup-hidden").val();
				var splitFieldName = thisElement.id.split('kreon-grid-');
				var gridSerial = splitFieldName[1].charAt(0);
			}
		}else{
			var thiss = $("#" + thisElement.name + "-onkeyup-hidden").val();
		}

		// Step 1: Replace commas inside parentheses with a placeholder (e.g., ~)
		let modifiedString = thiss.replace(/\(([^)]+)\)/g, (match) => {
			return match.replace(/,/g, "~");
		});

		var string = modifiedString.substring(
			modifiedString.indexOf("{") + 1, 
			modifiedString.lastIndexOf("}") 
		);

		var string1 = string.split(",");
		// console.log("string1 "+string1);

		// Step 3: Restore the original commas inside parentheses
		string1 = string1.map(item => item.replace(/~/g, ","));

		for(var k=0; k<string1.length; k++){
			string = string1[k].split(/(?=.*if)(?=elseif)(?=else)/);
			// console.log(string);
			if(string.length > 1){
				for(var i=0; i<string.length; i++){
					if(string[1].length > 1){
						// console.log(string[i]);
						// splitString = string[i].split(/[()]/);

						const regex = /(\w+)\(([^)]*)\)\s*\{([^}]*)\}/;
						var match = string[i].match(regex);
						var conditionalString = '';
						splitString = match ? [match[1], `${match[2]}`, `${match[3]}`] : null;

						// console.log("splitString "+splitString);

						conditionParamsArray = splitString[1].split("&");
						// console.log("conditionParamsArray "+conditionParamsArray);
						for(var l=0; l<conditionParamsArray.length; l++){
							// conditionParams = conditionParamsArray[l].split("=");
							// // console.log("conditionParams "+conditionParams[1]);
							// conditionParamsValue = $("#kreon-grid-"+gridSerial+""+conditionParams[0].trim()).next('span').find('#select2-kreon-grid-'+gridSerial+""+conditionParams[0].trim()+'-container').text();
							
							// conditionalString += '\'' + conditionParamsValue.trim() + '\' == \'' + conditionParams[1].trim() + '\'';

							// if(l != conditionParamsArray.length-1){
							// 	conditionalString += " && ";
							// }

							let operator = "=="; // default operator
							let splitChar = "=";

							if (conditionParamsArray[l].includes("!=")) {
								operator = "!=";
								splitChar = "!=";
							}
							// console.log("conditionParamsArray",conditionParamsArray[l]);
							conditionParams = conditionParamsArray[l].split(splitChar);

							// Common logic for fetching field value
							let fieldSelector = "#kreon-grid-" + gridSerial + conditionParams[0].trim();
							let select2Selector = '#select2-kreon-grid-' + gridSerial + conditionParams[0].trim() + '-container';

							let $select2Element = $(fieldSelector).next('span').find(select2Selector);

							if ($select2Element.length > 0) {
								conditionParamsValue = $select2Element.text();
							} else {
								conditionParamsValue = $(fieldSelector).val();
							}

							// Build conditional string dynamically
							// conditionalString += `'${conditionParamsValue.trim()}' ${operator} '${conditionParams[1].trim()}'`;
							
							var leftVal = conditionParamsValue.trim();
							var rightVal = conditionParams[1].trim();

							// ✅ detect numeric values
							let leftExpr = isNaN(leftVal) || leftVal === "" ? `'${leftVal}'` : leftVal;
							let rightExpr = isNaN(rightVal) || rightVal === "" ? `'${rightVal}'` : rightVal;

							conditionalString += `${leftExpr} ${operator} ${rightExpr}`;


							if(l != conditionParamsArray.length-1){
								conditionalString += " && ";
							}
						}

						// console.log("conditionalString "+conditionalString);
						
						if (eval(conditionalString)) {
							var splitStringExtract = splitString[2].replace('{','').replace('}','');
							var calculationParams = splitStringExtract.split('=');				
							flag=1;
						}
					}
				}
				
			}else if(string.length == 1){
				var cleanedString = string[0].replace(/[{}]/g, ""); // Remove { and }
				var calculationParams = cleanedString.split('=');
				flag=1;
			}
			
			if(flag){
				// console.log("calculationParams",calculationParams);
				var str = calculationParams[1].replace(/\s/g, ""); // Remove Space from string
				// console.log("str");
				// console.log(str);
				// Check if the string contains 'isnull'
				var isNullPattern = /isnull\(([^,]+),\s*([^)]*)\)/;  // Matches isnull(disc, 0.0)
				var match = str.match(isNullPattern);
				// console.log(match);
				if (match) {
					// Apply the dynamic replacement in the formula string
					str = handleIsNullInString(str,gridSerial);
				}
				var string = str.split(/([+,\-,*,(,),/])/); //Split string into array
				var calcuParams = string.filter(function(e){return e});
				var arrayWithOperator = []; // Get field value using 
				var arrayWithValue = ''; 
				var decimal=  /^-?\d*\.?\d*$/;
				for (let i = 0; i < calcuParams.length; i++) {
					if (calcuParams[i] !== '+' && calcuParams[i] !== '-' && calcuParams[i] !== '*' && calcuParams[i] !== '/' && calcuParams[i] !== '(' && calcuParams[i] !== ')' && !calcuParams[i].match(decimal) ) {
						
						if(type == 'grid'){
							// console.log("#kreon-grid-"+gridSerial+""+ calcuParams[i].trim(), $("#kreon-grid-"+gridSerial+""+ calcuParams[i].trim()).val());
							if (calcuParams[i].includes("?")) {
								var newcalculationField = calcuParams[i].replace(/\?/g, "");
								var fieldValue = $("#"+newcalculationField.trim()).val();
							}else{
								var fieldValue = $("#kreon-grid-"+gridSerial+""+ calcuParams[i].trim()).val();
							}
					
							if(fieldValue == ''){
								return;
							}else if(fieldValue == undefined){
								alert(calcuParams[i].trim()+" not found");
								return;
							}
						}else{
							var fieldValue = $("#"+calcuParams[i].trim()).val();
							// console.log(fieldValue);
							if(fieldValue == ''){
								return;
							}
						}
						arrayWithOperator.push(fieldValue);	
					}else{
						arrayWithOperator.push(calcuParams[i].trim());
					}	
				}
			
				arrayWithValue = arrayWithOperator.join(" ");
				arrayWithValue = arrayWithValue.replace(/\s+/g, ''); // ✅ Remove all spaces
				// console.log("------------------------------");
				// console.log(arrayWithValue);
				if(arrayWithValue != undefined){
					// console.log("arrayWithValue", arrayWithValue, eval(arrayWithValue));

					// ✅ Wrap negative numbers before * -1 with Math.abs()
					if (arrayWithValue.includes("*-1")) {
						// console.log("if");
						arrayWithValue = arrayWithValue.replace(/\(\s*(-?\d+(\.\d+)?)\s*\)\s*\*\s*-1/, (match, num) => {
							return `(Math.abs(${num})) * -1`;
						});

						arrayWithValue = arrayWithValue.replace(/(-?\d+(\.\d+)?)\s*\*\s*-1/, (match, num) => {
							return `(Math.abs(${num})) * -1`;
						});
					}

					total = eval(arrayWithValue); 
				}

				if(!isNaN(total)){
					if(type == 'grid'){
						var decimalPlaces = $("#kreon-grid-"+gridSerial+""+ calculationParams[0].trim()).data('key');
						if(decimalPlaces == undefined){
							var roundedTotal = total;
						}else{
							var roundedTotal = Math.round(total * Math.pow(10, decimalPlaces)) / Math.pow(10, decimalPlaces);
						}
						// console.log(roundedTotal);
						// $("#kreon-grid-"+gridSerial+""+ calculationParams[0].trim()).val(Math.round(total * 100) / 100);
						$("#kreon-grid-"+gridSerial+""+ calculationParams[0].trim()).val(roundedTotal);
					}else{
						var decimalPlaces = $("#"+calculationParams[0].trim()).data('key');
						if(decimalPlaces == undefined){
							var roundedTotal = total;
						}else{
							var roundedTotal = Math.round(total * Math.pow(10, decimalPlaces)) / Math.pow(10, decimalPlaces);
						}
						// $("#"+calculationParams[0].trim()).val(Math.round(total * 100) / 100);
						$("#"+calculationParams[0].trim()).val(roundedTotal);
					}
				}
			}
		}
	}

	//In grid  Onchage dropdown fill value in other input
	function CreateOnchangeScriptGrid(thisElement){
		selectedValue = thisElement.value;
		//elementId = thisElement.name.slice(0,-2);
		var thiss = $("#" + thisElement.name.slice(0,-2) + "-hidden").val();
		// function CreateOnchangeScript(thiss,elementId,type){
		var gridIdentifier = $(thisElement).parent().closest('tr').attr('id');
		var elementId = "#" + gridIdentifier + " td #" + thisElement.name.slice(0,-2);
		var type = 5;
		var str1 = "response";
		var responsePos = -1;
		if(thiss.indexOf(str1) != -1){
			responsePos = thiss.indexOf(str1);
		}

		var str2 = "url";
		var urlPos = -1;
		if(thiss.indexOf(str2) != -1){
			urlPos = thiss.indexOf(str2);
		}

		var newArr = ["", ""];
		if(urlPos != -1 && responsePos != -1){ //to split between both the parameters

			var splitIndex = urlPos > responsePos ? urlPos : responsePos;
 			newArr[0] = thiss.substring(0, splitIndex - 1)
 			newArr[1] = thiss.substring(splitIndex);
			// console.log(newArr[0]);
			// console.log(newArr[1]);
			var responseParams = newArr[0].substring(
						newArr[0].indexOf("{") + 1, 
						newArr[0].lastIndexOf("}")
					);

			var urlParams = newArr[1].substring(
						newArr[1].indexOf("{") + 1, 
						newArr[1].lastIndexOf("}")
					);

			console.log(responseParams);	//#Broker : 5 | response.ID | response.Name
			console.log(urlParams);
			var responseP = responseParams.split(',');	//THIS will give all the parameters required in response
			var finalParams = [];

			for(var i = 0; i < responseP.length; i++){
				finalParams[i] = responseP[i].trim().split('|');
			}
		}

		//loggedin user id, company id, year code, division, auth key for api

		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : { selectedValue : selectedValue },
			url : urlParams,
			success : function(result){
				//CHECK TYPE OF PARAMETERS
				// console.log(result);
				for(var i = 0; i < finalParams.length; i++){
					if(finalParams[i][1].trim() == 0 || finalParams[i][1].trim() == 1 || finalParams[i][1].trim() == 3 || finalParams[i][1].trim() == 6 || finalParams[i][1].trim() == 7 || finalParams[i][1].trim() == 8 ){	//type = textbox & others //#TrspPay | 1 | TrspPay 
						console.log(result[finalParams[i][2]]);
						$("#" + gridIdentifier + " td " + finalParams[i][0].trim()).val(result[finalParams[i][2].trim()])
					}
				}				
			}
		});
	}

	function CreateOnchangeScript(thisElement,type){
		elementId = thisElement.name;
		var thiss = $("#" + elementId + "-hidden").val();
		
		
		var str1 = "response";
		var responsePos = -1;
		if(thiss.indexOf(str1) != -1){
			responsePos = thiss.indexOf(str1);
		}

		var str2 = "url";
		var urlPos = -1;
		if(thiss.indexOf(str2) != -1){
			urlPos = thiss.indexOf(str2);
		}

		var newArr = ["", ""];
		if(urlPos != -1 && responsePos != -1){ //to split between both the parameters
			var splitIndex = urlPos > responsePos ? urlPos : responsePos;
 			newArr[0] = thiss.substring(0, splitIndex - 1)
 			newArr[1] = thiss.substring(splitIndex);
			console.log(newArr[0]);
			console.log(newArr[1]);
			var responseParams = newArr[0].substring(
						newArr[0].indexOf("{") + 1, 
						newArr[0].lastIndexOf("}")
					);

			var urlParams = newArr[1].substring(
						newArr[1].indexOf("{") + 1, 
						newArr[1].lastIndexOf("}")
					);
			// console.log(responseParams);	//#Broker : 5 | response.ID | response.Name
			// console.log(urlParams);
			var responseP = responseParams.split(',');	//THIS will give all the parameters required in response
			var finalParams = [];
			for(var i = 0; i < responseP.length; i++){
				finalParams[i] = responseP[i].trim().split('|');
			}
		}
		// alert(elementId);
		if(type == 4){
			var selectedValue = $('input:radio[name="'+ elementId+'"]:checked').val();
		}else{
			var selectedValue = $("#" + elementId).val();
		}
		// alert(selectedValue);
		//loggedin user id, company id, year code, division, auth key for api

		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : { selectedValue : selectedValue },
			url : urlParams,
			success : function(result){
				// alert(result);
				//CHECK TYPE OF PARAMETERS
				for(var i = 0; i < finalParams.length; i++){
					console.log(finalParams);
					if(finalParams[i][1].trim() == 0 || finalParams[i][1].trim() == 1 || finalParams[i][1].trim() == 3 || finalParams[i][1].trim() == 6 || finalParams[i][1].trim() == 7 || finalParams[i][1].trim() == 8 ){	//type = textbox & others //#TrspPay | 1 | TrspPay 
						$(finalParams[i][0].trim()).val(result[finalParams[i][2].trim()])
					}

					if(finalParams[i][1].trim() == 5){	//type = dropdown //#Broker | 5 | BrokerName|ID | Name
						resultArr = result[finalParams[i][2].trim()];
						var selectDD = "";
						for(var j = 0; j < resultArr.length; j++){
							var ddID = finalParams[i][3].trim();
							var ddVal = finalParams[i][4].trim();
							if( i == 0 ){
								selectDD += "<option selected value='" + resultArr[j][ddID] + "'>" + resultArr[j][ddVal] + "</option>"
							}else{
								selectDD += "<option value='" + resultArr[j][ddID] + "'>" + resultArr[j][ddVal] + "</option>"					
							}
							$(finalParams[i][0].trim()).html(selectDD);
						}
					}

					if(finalParams[i][1].trim() == 10){	//type = dropdown //#Broker | 5 | BrokerName|ID | Name
						resultArr = result[finalParams[i][2].trim()];
						var selectDD = "";
						for(var j = 0; j < resultArr.length; j++){
							var ddID = finalParams[i][3].trim();
							var ddVal = finalParams[i][4].trim();
							$(finalParams[i][0].trim()).select2('data', {id: ddID, text: ddVal});      
						}
					}

					if(finalParams[i][1].trim() == 4){	//type = radio button //#Broker | 4 | BrokerName|ID
						resultArr = result[finalParams[i][2].trim()];
						var selectRB = "";
						for(var j = 0; j < resultArr.length; j++){
							var ddID = finalParams[i][3].trim();
							var ddVal = finalParams[i][4].trim();
							selectRB += "<label><input type='radio' name='"+ finalParams[i][2] +"' value='"+ resultArr[j][ddID] +"' >&nbsp;"+ resultArr[j][ddVal]+"</label></br>";
						}
						$(finalParams[i][0].trim()+ "-div").html(selectRB);
					}

					if(finalParams[i][1].trim() == 9){	//type = checkbox //#Broker | 9 | BrokerName|ID
						resultArr = result[finalParams[i][2].trim()];
						var selectCB = "";
						for(var j = 0; j < resultArr.length; j++){
							var ddID = finalParams[i][3].trim();
							var ddVal = finalParams[i][4].trim();
							selectCB += "<label> <input type='checkbox' name='"+ finalParams[i][2].trim() +"[]' id='"+finalParams[i][2].trim()+"' value='"+ resultArr[j][ddID] +"' >&nbsp;"+ resultArr[j][ddVal]+"</label></br>";
						}
						$(finalParams[i][0].trim() + "-multi-div").html(selectCB);
					}
				}				
			}
		});
	}

	// //In main form Onkeyenter fill value in other input
	// function CreateOnkeyEnterScript(thisElement,type){
	// 	elementId = thisElement.id;
	// 	var thiss = $("#" + elementId + "-hidden").val();

	// 	var splitString = elementId.split('kreon-grid-');
	// 	var gridIdentifier = splitString[1].charAt(0);

	// 	var str1 = "response";
	// 	var responsePos = -1;
	// 	if(thiss.indexOf(str1) != -1){
	// 		responsePos = thiss.indexOf(str1);
	// 	}

	// 	var str2 = "DB";
	// 	var DBPos = -1;
	// 	if(thiss.indexOf(str2) != -1){
	// 		DBPos = thiss.indexOf(str2);
	// 	}

	// 	var newArr = ["", ""];
	// 	if(DBPos != -1 && responsePos != -1){ //to split between both the parameters
	// 		var splitIndex = DBPos > responsePos ? DBPos : responsePos;
 	// 		newArr[0] = thiss.substring(0, splitIndex - 1)
 	// 		newArr[1] = thiss.substring(splitIndex);

	// 		var str3 = "DB";
	// 		var DBPos1 = -1;
	// 		if(newArr[1].indexOf(str3) != -1){
	// 			DBPos1 = newArr[1].indexOf(str3);
	// 		}

	// 		var str4 = "cursorPosition";
	// 		var cursorPositionPos = -1;
	// 		if(newArr[1].indexOf(str4) != -1){
	// 			cursorPositionPos = newArr[1].indexOf(str4);
	// 		}

	// 		var str5 = 'parameters';
	// 		var parametersPos = -1;
	// 		if(newArr[1].indexOf(str5) != -1){
	// 			parametersPos = newArr[1].indexOf(str5);
	// 		}

	// 		if(DBPos1 != -1){
	// 			if(cursorPositionPos != -1){
	// 				newArr[2] = newArr[1].substring(0,cursorPositionPos);
	// 				if(parametersPos != -1){
	// 					newArr[3] = newArr[1].substring(cursorPositionPos,parametersPos);
	// 					newArr[4] = newArr[1].substring(parametersPos);
	// 				}else{
	// 					newArr[3] = newArr[1].substring(cursorPositionPos);
	// 				}
	// 			}else{
	// 				if(parametersPos != -1){
	// 					newArr[2] = newArr[1].substring(0,parametersPos);
	// 					newArr[4] = newArr[1].substring(parametersPos);
	// 				}else{
	// 					newArr[2] = newArr[1].substring(DBPos1);
	// 				}

	// 			}
	// 		}

	// 		var responseParams = newArr[0].substring(
	// 					newArr[0].indexOf("{") + 1, 
	// 					newArr[0].lastIndexOf("}")
	// 				);

	// 		var DBParams = newArr[2].substring(
	// 					newArr[2].indexOf("{") + 1, 
	// 					newArr[2].lastIndexOf("}")
	// 				);

	// 		if(newArr[3] != undefined){
	// 			var cursorPositionParams = newArr[3].substring(
	// 				newArr[3].indexOf('{') + 1, 
	// 				newArr[3].lastIndexOf('}')
	// 			);
	// 		}	
			
	// 		if(newArr[4] != undefined){
	// 			var parametersParams = newArr[4].substring(
	// 				newArr[4].indexOf('{') + 1, 
	// 				newArr[4].lastIndexOf('}')
	// 			);
	// 		}
			
			
	// 		var responseP = responseParams.split(',');	//THIS will give all the parameters required in response
	// 		var finalParams = [];
	// 		var searchColumn = [];

	// 		for(var i = 0; i < responseP.length; i++){
	// 			finalParams[i] = responseP[i].trim().split('|');
	// 			searchColumn.push(finalParams[i][2].trim());
	// 		}
	// 	}
	// 	if(type == 4){
	// 		var selectedValue = $('input:radio[name="'+ elementId+'"]:checked').val();
	// 	}else{
	// 		var selectedValue = $("#" + elementId).val();
	// 	}

	// 	if(parametersParams.length > 5){
	// 		var extractedparameters = parametersParams.replace(/\(+/g, ' (').replace(/\?+/g, ' ?').replace(/\#+/g, ' #').replace(/\)+/g, ' )');
	// 		var parameters = extractedparameters.split(" ");
			
	// 		var requestParams = '';
	// 		for(var i=0; i<parameters.length; i++){
			
	// 			if(parameters[i].indexOf("?") >= 0 || parameters[i].indexOf("#") >= 0){
	// 				if(parameters[i].length > 0){

	// 					if(parameters[i].includes("?") == true){
						
	// 						var qExtractedString = "kreon-grid-"+parameters[i].replace(/\?+/g, '');
	// 					}
						
	// 					if(parameters[i].indexOf("#") >= 0){
	// 						//If # found it remove
	// 						var qExtractedString = parameters[i].replace(/\#+/g, '');
	// 					}
						
	// 					if(qExtractedString.length > 0){
	// 						var NumberOfElements = document.querySelectorAll("[id="+qExtractedString+"]");
							
							
	// 						if(NumberOfElements.length == 2){
	// 							requestParams += $(NumberOfElements[1]).val() !="" ? $(NumberOfElements[1]).val().trim() : '0';
	// 							requestParams += " ";
	// 						}else{
	// 							if(qExtractedString == 'user_id'){
	// 								requestParams += <?php echo $_SESSION['user_id']; ?> 
	// 							}else{
	// 								requestParams += $('#'+qExtractedString).val() !="" ? $('#'+qExtractedString).val() : '0';
	// 							}
	// 							requestParams += " ";
	// 						}
							
	// 					}

	// 				}
	// 			}else{
	// 				requestParams += parameters[i].trim() +" ";
	// 			}
	// 		}
	// 	}
	// 	// console.log(requestParams);
	// 	// var Parameters = [];
	// 	// var IParameters = [];
	// 	// var str = [];
	// 	// if(parameters != undefined && parametersParams != ""){
	// 	// 	var finalParametersParams = parametersParams.split(',');
	// 	// 	for(var i=0; i < finalParametersParams.length; i++){
	// 	// 		IParameters = finalParametersParams[i].split(':');
	// 	// 		str[i] = IParameters[1];
	// 	// 		if((str[i][1] == "'" && str[i][str[i].length - 1] == "'") || (str[i][1] == "\"" && str[i][str[i].length - 1] == "\"")){
	// 	// 			var parameterValue = IParameters[1].replace(/[\"']/g, '');
	// 	// 		}else{
	// 	// 			var parameterValue =  $('#'+IParameters[1].trim()).val();
	// 	// 		}
	// 	// 		// var parameterValue = IParameters[1];

	// 	// 		var paramkv = IParameters[0].trim()+"="+parameterValue;
	// 	// 		Parameters.push(paramkv);
	// 	// 	}       
	// 	// }

	// 	//loggedin user id, company id, year code, division, auth key for api

	// 	$.ajax({
	// 		type : 'POST',
	// 		dataType: 'json',
	// 		data : { searchParam : selectedValue, searchColumn:searchColumn, fromRepo : DBParams, parameters : requestParams },
	// 		url : 'getOnkeyEnterData.php',
	// 		success : function(result){
	// 			console.log(result);
	// 			//CHECK TYPE OF PARAMETERS
	// 			for(var i = 0; i < finalParams.length; i++){
	// 				// console.log(finalParams);
	// 				if(finalParams[i][1].trim() == 0 || finalParams[i][1].trim() == 1 || finalParams[i][1].trim() == 3 || finalParams[i][1].trim() == 6 || finalParams[i][1].trim() == 7 || finalParams[i][1].trim() == 8 ){	//type = textbox & others //#TrspPay | 1 | TrspPay 
	// 					console.log(finalParams[i][0] +" - "+result[finalParams[i][2].trim()]);
	// 					$(finalParams[i][0].trim()).val(result[finalParams[i][2].trim()])
	// 				}

	// 				if(finalParams[i][1].trim() == 5){	//type = dropdown //#Broker | 5 | BrokerName|ID | Name
	// 					resultArr = result[finalParams[i][2].trim()];
	// 					var selectDD = "";
	// 					for(var j = 0; j < resultArr.length; j++){
	// 						var ddID = finalParams[i][3].trim();
	// 						var ddVal = finalParams[i][4].trim();
	// 						if( i == 0 ){
	// 							selectDD += "<option selected value='" + resultArr[j][ddID] + "'>" + resultArr[j][ddVal] + "</option>"
	// 						}else{
	// 							selectDD += "<option value='" + resultArr[j][ddID] + "'>" + resultArr[j][ddVal] + "</option>"					
	// 						}
	// 						$(finalParams[i][0].trim()).html(selectDD);
	// 					}
	// 				}

	// 				if(finalParams[i][1].trim() == 10){	//type = dropdown //#Broker | 5 | BrokerName|ID | Name
	// 					resultArr = result[finalParams[i][2].trim()];
	// 					var selectDD = "";
	// 					for(var j = 0; j < resultArr.length; j++){
	// 						var ddID = finalParams[i][3].trim();
	// 						var ddVal = finalParams[i][4].trim();
	// 						$(finalParams[i][0].trim()).select2('data', {id: ddID, text: ddVal});      
	// 					}
	// 				}

	// 				if(finalParams[i][1].trim() == 4){	//type = radio button //#Broker | 4 | BrokerName|ID
	// 					resultArr = result[finalParams[i][2].trim()];
	// 					var selectRB = "";
	// 					for(var j = 0; j < resultArr.length; j++){
	// 						var ddID = finalParams[i][3].trim();
	// 						var ddVal = finalParams[i][4].trim();
	// 						selectRB += "<label><input type='radio' name='"+ finalParams[i][2] +"' value='"+ resultArr[j][ddID] +"' >&nbsp;"+ resultArr[j][ddVal]+"</label></br>";
	// 					}
	// 					$(finalParams[i][0].trim()+ "-div").html(selectRB);
	// 				}

	// 				if(finalParams[i][1].trim() == 9){	//type = checkbox //#Broker | 9 | BrokerName|ID
	// 					resultArr = result[finalParams[i][2].trim()];
	// 					var selectCB = "";
	// 					for(var j = 0; j < resultArr.length; j++){
	// 						var ddID = finalParams[i][3].trim();
	// 						var ddVal = finalParams[i][4].trim();
	// 						selectCB += "<label> <input type='checkbox' name='"+ finalParams[i][2].trim() +"[]' id='"+finalParams[i][2].trim()+"' value='"+ resultArr[j][ddID] +"' >&nbsp;"+ resultArr[j][ddVal]+"</label></br>";
	// 					}
	// 					$(finalParams[i][0].trim() + "-multi-div").html(selectCB);
	// 				}
	// 			}	
				
	// 			if(cursorPositionParams !="" && cursorPositionParams != undefined){
	// 				$('#'+cursorPositionParams).focus();
	// 			}else{
	// 				$(".add"+gridIdentifier).click();
	// 			}
				
	// 		}
	// 	});
	// }

	//In main form Onkeyenter fill value in other input
	function CreateOnkeyEnterScript(thisElement,type){
		console.log("CreateOnkeyEnterScript");
		elementId = thisElement.id;
		var thiss = $("#" + elementId + "-hidden").val();

		var splitString = elementId.split('kreon-grid-');
		var gridIdentifier = splitString[1].charAt(0);

		var str1 = "response";
		var responsePos = -1;
		if(thiss.indexOf(str1) != -1){
			responsePos = thiss.indexOf(str1);
		}

		var str2 = "DB";
		var DBPos = -1;
		if(thiss.indexOf(str2) != -1){
			DBPos = thiss.indexOf(str2);
		}

		var newArr = ["", ""];
		if(DBPos != -1 && responsePos != -1){ //to split between both the parameters
			var splitIndex = DBPos > responsePos ? DBPos : responsePos;
 			newArr[0] = thiss.substring(0, splitIndex - 1)
 			newArr[1] = thiss.substring(splitIndex);

			var str3 = "DB";
			var DBPos1 = -1;
			if(newArr[1].indexOf(str3) != -1){
				DBPos1 = newArr[1].indexOf(str3);
			}

			var str4 = "cursorPosition";
			var cursorPositionPos = -1;
			if(newArr[1].indexOf(str4) != -1){
				cursorPositionPos = newArr[1].indexOf(str4);
			}

			var str5 = 'parameters';
			var parametersPos = -1;
			if(newArr[1].indexOf(str5) != -1){
				parametersPos = newArr[1].indexOf(str5);
			}

			var str6 = 'GridId';
			var GridIdPos = -1;
			if(newArr[1].indexOf(str6) != -1){
				GridIdPos = newArr[1].indexOf(str6);
			}

			var str7 = 'DataSpName';
			var DataSpNamePos = -1;
			if(newArr[1].indexOf(str7) != -1){
				DataSpNamePos = newArr[1].indexOf(str7);
			}

			if(DBPos1 != -1){
				if(DataSpNamePos != -1){
					if(cursorPositionPos != -1){
						if(parametersPos != -1){
							if(GridIdPos != -1){
								newArr[2] = newArr[1].substring(0,DataSpNamePos);
								newArr[6] = newArr[1].substring(DataSpNamePos,cursorPositionPos);
								newArr[3] = newArr[1].substring(cursorPositionPos,parametersPos);
								newArr[4] = newArr[1].substring(parametersPos,GridIdPos);
								newArr[5] = newArr[1].substring(GridIdPos);
							}
						}
					}
				}
			}

			// console.log(newArr[0]);
			// console.log(newArr[1]);
			// console.log(newArr[2]);
			// console.log(newArr[3]);
			// console.log(newArr[4]);
			// console.log(newArr[5]);
			// console.log(newArr[6]);


			var responseParams = newArr[0].substring(
						newArr[0].indexOf("{") + 1, 
						newArr[0].lastIndexOf("}")
					);

			var DBParams = newArr[2].substring(
						newArr[2].indexOf("{") + 1, 
						newArr[2].lastIndexOf("}")
					);

			if(newArr[3] != undefined || newArr[3].length > 1){
				var cursorPositionParams = newArr[3].substring(
					newArr[3].indexOf('{') + 1, 
					newArr[3].lastIndexOf('}')
				);
			}	
			
			if(newArr[4] != undefined || newArr[4].length > 1){
				var parametersParams = newArr[4].substring(
					newArr[4].indexOf('{') + 1, 
					newArr[4].lastIndexOf('}')
				);
			}

			if(newArr[5] != undefined || newArr[5].length > 1){
				var GridIdParams = newArr[5].substring(
					newArr[5].indexOf('{') + 1, 
					newArr[5].lastIndexOf('}')
				);

				if(GridIdParams.length > 0){
					var gridId = GridIdParams.split(":");
				}
			}

			if(newArr[6] != undefined || newArr[6].length > 1){
				var DataSpNameParams = newArr[6].substring(
					newArr[6].indexOf('{') + 1, 
					newArr[6].lastIndexOf('}')
				);
			}
			
			
			// var responseP = responseParams.split(',');	//THIS will give all the parameters required in response
			// var finalParams = [];
			// var searchColumn = [];

			// for(var i = 0; i < responseP.length; i++){
			// 	finalParams[i] = responseP[i].trim().split('|');
			// 	searchColumn.push(finalParams[i][2]);
			// }
		}
		

		if(parametersParams.length > 5){
			var extractedparameters = parametersParams.replace(/\(+/g, ' (').replace(/\?+/g, ' ?').replace(/\#+/g, ' #').replace(/\)+/g, ' )');
			var parameters = extractedparameters.split(" ");
			
			var requestParams = '';
			for(var i=0; i<parameters.length; i++){
			
				if(parameters[i].indexOf("?") >= 0 || parameters[i].indexOf("#") >= 0){
					if(parameters[i].length > 0){

						if(parameters[i].includes("?") == true){
							var gridIdentifier = $('#grid-id-'+gridId[1]).attr('class');		
							var gridSerialNo = gridIdentifier.slice(4);

							var qExtractedString = "kreon-grid-"+gridSerialNo+""+parameters[i].replace(/\?+/g, '');
						}
						
						if(parameters[i].indexOf("#") >= 0){
							//If # found it remove
							var qExtractedString = parameters[i].replace(/\#+/g, '');
						}
						
						if(qExtractedString.length > 0){
							var NumberOfElements = document.querySelectorAll("[id="+qExtractedString+"]");
							
							if(NumberOfElements.length == 2){
								requestParams += $(NumberOfElements[1]).val() !="" ? "'"+$(NumberOfElements[1]).val().trim()+"'" : '0';
								requestParams += " ";
							}else{
								if(qExtractedString == 'user_id'){
									requestParams += <?php echo $_SESSION['user_id']; ?> 
								}else{
									requestParams += $('#'+qExtractedString).val() !="" ? "'"+$('#'+qExtractedString).val().trim()+"'" : '0';
								}
								requestParams += " ";
							}	
						}
					}
				}else{
					requestParams += parameters[i].trim() +" ";
				}
			}
		}
		
		var hidden = $('form').find(':hidden');	
		hidden.show();   
		var  formSerialize = $('form').serialize();	
		hidden.hide();
		var editid = $('input[name=editID]').val();
	
		//loggedin user id, company id, year code, division, auth key for api
		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : { responseParams:responseParams, fromRepo : DBParams, fromRepoSP : DataSpNameParams, parameters : requestParams, GridId: gridId[1], FormData: formSerialize, editid:editid},
			url : 'getOnkeyEnterData.php',
			success : function(result){
				console.log("getOnkeyEnterData", result);
				finalResponseParams = result['finalParams'];
				var isBarcode = 0;
				// if(result['Msg']){
				// 	if(result['Msg'][0]['Msg'].length > 0){
				// 		alert(result['Msg'][0]['Msg']);
				// 	}
				// }

				isBarcode = 1;

				if(result['Success'] == 0){
					if(result['Msg'][0]['Msg'].length > 0){
						alert(result['Msg'][0]['Msg']);
						return;
					}
				}else if(result['Success'] == 2){
					if (confirm(result['data']['Msg']+'. Are you sure you want to show barcode details?') == true) {
						isBarcode = 1;
					}else{
						if(result['Msg'][0]['Msg'].length > 0){
							alert(result['Msg'][0]['Msg']);
							return;
						}
					}
				}
					
				//if isBarcode is 1 then exicute response
				if(isBarcode == 1){
					//CHECK TYPE OF PARAMETERS
					for(var i = 0; i < finalResponseParams.length; i++){
						console.log("pornima",finalResponseParams[i]);
						responseFinalParams = finalResponseParams[i].split(":");
						if(responseFinalParams[2] == "0" || responseFinalParams[2] == "1" || responseFinalParams[2] == "3" || responseFinalParams[2] == "6" || responseFinalParams[2] == "7" || responseFinalParams[2] == "8" ){
							$("#kreon-grid-"+gridSerialNo+""+responseFinalParams[0].trim()).val(result['data'][0][responseFinalParams[1]]);
						}
	
						if(responseFinalParams[2] == "5" || responseFinalParams[2] == "19"){
							// console.log(result['data'][0][responseFinalParams[3]]);
							var $newOption = $("<option selected=\"selected\"></option>").val(result['data'][0][responseFinalParams[3]]).text(result['data'][0][responseFinalParams[1]]);
							// $("#kreon-grid-"+gridSerialNo+""+responseFinalParams[0].trim()).select2('open');
							$("#kreon-grid-"+gridSerialNo+""+responseFinalParams[0].trim()).append($newOption).trigger("change");
							// $("#kreon-grid-"+gridSerialNo+""+responseFinalParams[0].trim()).select2('close');
						}
	
						if(responseFinalParams[2] == '17'){
							$('#kreon-grid-' + gridSerialNo + responseFinalParams[0].trim() +'-text').val(result['data'][0][responseFinalParams[1]]);
							$('#kreon-grid-'+gridSerialNo + responseFinalParams[0].trim()).val(result['data'][0][responseFinalParams[3]]);
							
						}	
	
					}

					if(result['NonEditableFields'] != null && result['NonEditableFields']['NonEditableFields'] != undefined){
						var NonEditableFields = result['NonEditableFields']['NonEditableFields'].split('|');
						for(var k=0; k < NonEditableFields.length; k++){
							
							$('#kreon-grid-'+gridSerialNo+NonEditableFields[k]).prop('readonly',true).css('background-color','#eee');
							
						}
					}
	
					setTimeout(
					function() {
						if(result['bordercolor']['bordercolor'].length > 0){
							$('#panel'+gridSerialNo).find('#GridTable tbody tr').css('border','');
							var cnt = parseInt(document.getElementById("cnt"+gridSerialNo).value);
							var color = '#'+result['bordercolor']['bordercolor'];
							// console.log('#'+gridSerialNo+cnt);
							$('#'+gridSerialNo+cnt).css('border','3px solid'+ color);
						}
					}, 500);
					
					if(cursorPositionParams !="" && cursorPositionParams != undefined){
						console.log("CreateOnkeyEnterScript Fn")
						$('#kreon-grid-'+gridSerialNo+cursorPositionParams).focus();
					}else{
						$(".add"+gridSerialNo).click();
					}
				}
				
			}
		});
	}

	function isValidText(pattern,elementID) {
		var fieldValue = $("#" + elementID ).val();
		const regex = new RegExp(pattern);
		console.log(regex.test(fieldValue));
		if(regex.test(fieldValue) == true){
			alert("Not valid format");
			$( "."+elementID ).find('div').append( "<p id='"+elementID+"-hide' style='color:red;'>Not valid format.</p>" );
					setTimeout(function() {
						$("#"+elementID+"-hide").remove();
						$("#"+elementID).val('');
					}, 2000);
		}
	}

	var isNumeric = function(val, decimals) {
		var reString = "^\\s*((\\d+(\\.\\d{0," + decimals + "})?)|((\\d*(\\.\\d{1," + decimals + "}))))\\s*$"
		var re = new RegExp(reString);
		console.log(re);
	}

	function isValidDigit(digit,elementID) {
		var digits = digit.split("=");
		var decimaldigits = digits[1].split(".");
		console.log("decimaldigits",decimaldigits);
		var NoOfDigit = decimaldigits[1].length;
		console.log("NoOfDigit",NoOfDigit);
		var fieldValue = $("#" + elementID ).val();
		console.log("fieldValue",fieldValue);
		success = false;
		if(NoOfDigit == 2){//step=0.000
			regEx = /^\d*\.?\d{0,1}$/;
		}else if(NoOfDigit == 3){//step=0.0000
			regEx = /^\d*\.?\d{0,2}$/;
		}else if(NoOfDigit == 4){ //step=0.00000
			regEx = /^\d*\.?\d{0,3}$/;
		}else if(NoOfDigit == 1){//step=0.00
			regEx = /^\d*\.?\d{0,0}$/;
		}
	
		if(regEx.test(fieldValue)) {
			console.log("if");
			success = true;
		}else {
			console.log(event.keyCode);
			if(event.keyCode != 8 && event.keyCode != 46 && event.keyCode != 9){
				event.preventDefault();
			}
			success = true;
			console.log("else");
		}
		return success;	
	}

	function onBlurUpdateLostFocusTabIndex(thiss,fieldtype){
		if(fieldtype == 17 || fieldtype == 16){
			
			if(thiss.id == undefined){
				$("#"+thiss).attr("tabindex", "-1");
				$("#"+thiss).css("pointer-events","none").css("background-color","#eee");
				
			}else{
				$("#"+thiss.id).attr("tabindex", "-1");
				$("#"+thiss.id).css("pointer-events","none").css("background-color","#eee");
			}	
		}else if(fieldtype == 5 || fieldtype == 19){
			$('#'+thiss.id).next('span').find('.select2-selection--single').css("pointer-events","none").css("background-color","#eee");
			setTimeout(
				function() {
					$('.' + thiss.id + ' .select2-selection--single').attr("tabindex","-1");
				}, 500);
		}else{
			$("#"+thiss.id).attr("tabindex", "-1");
			$("#"+thiss.id).prop("readonly", true);
		}
	}

	function onBlurClearDependentField(thiss,dependentfields){
		var match = dependentfields.match(/^(\d+)_([^_].*)$/);

		if (match) {
			var numberPart = match[1];  // "1738"
			var textPart = match[2];    // "designid"

			var className = $('#grid-id-' + numberPart).attr('class');
			var lastChar = className.slice(-1); // gets the last character
			dependentfields = 'kreon-grid-'+lastChar+textPart;
			var field = document.getElementById(dependentfields);
		}else{
			var field = document.getElementById(dependentfields);
		}

		let fieldType = field.type;

		// ✅ clear sibling visible input with -text ID
		$(field).siblings('input[id="' + dependentfields + '-text"]').each(function () {
			$(this).val('');
		});
		

		if(fieldType == "text" || fieldType == "date" || fieldType == "number" || fieldType == "email" || fieldType == "textarea" || fieldType == "time" || fieldType == "hidden"){
			$("#"+dependentfields).val('');
		}else if(fieldType == 'select-one'){ // if field type 5 or 19
			$("#"+dependentfields).val(0).trigger("change");
			$('#'+dependentfields).closest('div').find('button[title="Clear"]').prop('disabled', true);
		}
	}

	function onBlurNonEditableFields(thiss,dependentfields){
		// console.log("pornima",dependentfields);

		var match = dependentfields.match(/^(\d+)_([^_].*)$/);
		
		if (match) {
			var numberPart = match[1];  // "1738"
			var textPart = match[2];    // "designid"
			
			var className = $('#grid-id-' + numberPart).attr('class');
			var lastChar = className.slice(-1); // gets the last character
			dependentfields = 'kreon-grid-'+lastChar+textPart;
			var field = document.getElementById(dependentfields);
					console.log(field,dependentfields);
		}else{
			var field = document.getElementById(dependentfields);
					console.log(field,dependentfields);
		}

		let fieldType = field.type;
		
		// ✅ Disable sibling visible input with -text ID
		$(field).siblings('input[id="' + dependentfields + '-text"]').each(function () {
			
			$(this).css('pointer-events', 'none').css('background', '#eee');
		});

		if(fieldType == "text" || fieldType == "date" || fieldType == "number" || fieldType == "email" || fieldType == "textarea" || fieldType == "time"){
			$('#'+dependentfields).css('pointer-events','none').css('background','#eee');
		}else if(fieldType == 'select-one'){ // if field type 5 or 19
			// $("#"+dependentfields).val(0).trigger("change");
			$('#'+dependentfields).next('span').find('.select2-selection--single').css('pointer-events','none').css('background','#eee');
			// $('#'+dependentfields).find('button[title="Clear"]').prop('disabled', true);
			$('#' + dependentfields).closest('div').find('button[title="Clear"]').prop('disabled', true).css({'pointer-events':'none', 'opacity':'0.5'});
		}

		
	}

	//Use function in edit mode for loack select2 dropdown
	function lockSelect2(id) {
		var $sel = $('#'+id);

		// 1) block the dropdown from opening / unselecting
		$sel.on('select2:opening select2:unselecting', function(e){ e.preventDefault(); });

		// 2) disable keyboard focus & pointer (visual hint too)
		var $box = $sel.next('.select2-container').find('.select2-selection');
		$box.css({
		'pointer-events': 'none',   // <-- correct property name
		'background': '#eee'
		});

		// 3) hide the built-in clear icon (if enabled)
		$sel.next('.select2-container').find('.select2-selection__clear').hide();

		// 4) disable your custom clear button, if present
		// $('#<?=$m[0]?>').closest('div').find('button[title="Clear"]').prop('disabled', true);
	}

	// Get einvoice details
	function getEinvoiceDetails(caseCondition){
		if(caseCondition == 'gstr1'){
			$("#downloadgstr1").prop("disabled",true);
		}else{
			$("#downloadgstr2").prop("disabled",true);
		}
		// Show loader
		$('#loader').show();
		var period = $('#Period').val();
		$.ajax({
			url: 'getFormExternalAPIData.php',
			type: 'POST',
			data: { case : caseCondition, FormID:<?php echo $FormID; ?>, period: period },
			success: function(response) {
				console.log("response",response);
				if (response == 'OTP_REQUIRED') {
					// Hide loader while waiting for OTP
					$('#loader').hide();

					let otp = prompt("Enter OTP received for GST Auth");
					if (otp) {
						$('#loader').show(); // Show loader again during second API call
						// Ensure no unintended redirects are triggered
						$.post('getFormExternalAPIData.php', { case: caseCondition, FormID: <?php echo $FormID; ?>, period: period, otp: otp }, function(secondResponse) {
							$('#loader').hide();
							alert(secondResponse);
						});
					} else {
						// Handle cancelation of the prompt (user didn't enter OTP)
						console.log('OTP was not entered.');
					}
				} else {
					let res = typeof response === 'string' ? JSON.parse(response) : response;

					if(caseCondition == 'gstr1'){
						$("#downloadgstr1").prop("disabled",false);
					}else{
						$("#downloadgstr2").prop("disabled",false);
					}

					if (res.status === 'error') {
						// $('#loader').hide();
						alert(res.message);  // Show the error message if 'error' status
						return;
					}

					$('#loader').hide();
					if (res.status === 'success') {
						alert(res.message); // will show "Successfully Completed"
					} else {
						alert("Error: " + (res.message || "Unknown error"));
					}
				}
			}
		});
	}

	// Listview Export To Excel
	$(document).ready(function(){
		$("#listviewExportExcel").on("click", function () {
				$.ajax({
					type : 'POST',
					dataType: 'json',
					data : {FormID:<?php echo $FormID; ?>},
					url : "listviewExportExcel.php",
					success : function(response){
						console.log(response);

						if(response){
							// Flatten if response[0] is the actual array
							var data = Array.isArray(response[0]) ? response[0] : response;

							if (data && data.length > 0) {
								// Transform EntryDate and other objects to strings
								// Transform EntryDate and format to dd-mm-yy
								// data = data.map(function(item) {
								// 	var newItem = {};
								// 	for (var key in item) {
								// 		if (item.hasOwnProperty(key)) {
								// 			if (key === "EntryDate" && typeof item[key] === "object" && item[key].date) {
								// 				var dateStr = item[key].date.split(' ')[0]; // Get 'YYYY-MM-DD'
								// 				var parts = dateStr.split('-'); // ['YYYY','MM','DD']
								// 				newItem[key] = parts[2] + '-' + parts[1] + '-' + parts[0]; // dd-mm-yyyy
								// 			} else {
								// 				newItem[key] = item[key];
								// 			}
								// 		}
								// 	}
								// 	return newItem;
								// });

								data = data.map(function(item) {
									var newItem = {};
									for (var key in item) {
										if (item.hasOwnProperty(key)) {
											var value = item[key];

											// ✅ Case 1: If value is an object with a "date" property
											if (typeof value === "object" && value !== null && value.date) {
												var dateStr = value.date.split(' ')[0]; // Get 'YYYY-MM-DD'
												var parts = dateStr.split('-'); // ['YYYY','MM','DD']
												newItem[key] = parts[2] + '-' + parts[1] + '-' + parts[0]; // dd-mm-yyyy
											}
											// ✅ Case 2: If value looks like a date string (e.g., '2025-08-29')
											else if (typeof value === "string" && /^\d{4}-\d{2}-\d{2}$/.test(value)) {
												var parts = value.split('-');
												newItem[key] = parts[2] + '-' + parts[1] + '-' + parts[0]; // dd-mm-yyyy
											}
											else {
												newItem[key] = value; // Keep original if not a date
											}
										}
									}
									return newItem;
								});

								// Convert JSON to worksheet
								var worksheet = XLSX.utils.json_to_sheet(data);

								// Create a new workbook
								var workbook = XLSX.utils.book_new();
								XLSX.utils.book_append_sheet(workbook, worksheet, "Export");

								// Dynamic file name
								var formID = "<?php echo $FormID; ?>";
								XLSX.writeFile(workbook, "export_" + formID + ".xlsx");
							}
						}else {
							alert("No data available for export.");
						}
						 
					}
			})
			
		});
	});

</script>

<?php
	// Add More Form Modal
	echo '<div class="modal fade" id="AddMoreModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button> 
					<h4 class="modal-title">Add</h4>                                                             
				</div> 
				<div class="modal-body" >
					<form id="modalForm" name="modal" role="form">
						<div id="ModelContent" >
						</div>
						<div class="modal-footer" style="margin-top:10px;">					
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="submit" class="btn btn-success" id="submit">
						</div>
					</form>
				</div>   
			</div>                                                                       
		</div>                                          
	</div>';

	?>

	<!-- Log Modal -->
	<div class="modal fade" id="logModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Log Data</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<div class="scrollable-log-table-container">
							<table class="table table-sm" id="logTable"> <!-- id="dropdownContent" class="dropdown-content" -->
								<thead>
									<tr id="logTableHeader">
										<!-- Table headers will be inserted dynamically -->
									</tr>
								</thead>
								<tbody id="logItems">
									<!-- Data will be loaded here -->
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		// When the button is clicked, open the modal and fetch data
		function openLogModal(type = ''){
			// alert(type);
			$('#logModal').modal('show');
			getLogData(type);  // Call AJAX to fetch data when modal opens
		}

		function getLogData(type){
			var columnFilters = $(".search-column").map(function() {
				const column = $(this).attr("id");
				const columnValue = $(this).val().toLowerCase();
				return { column, columnValue };
			}).get();

			// Create a custom string, for example: "column1:value1, column2:value2"
			var columnFiltersString = columnFilters
				.map(function(filter) {
					if (filter.columnValue) {
						return filter.column + ":" + filter.columnValue;
					}
				})
				.filter(function(item) {
					return item !== undefined;
				})
				.join("|");

			console.log("columnFiltersString "+columnFiltersString);
			if(type == 'full') $editID = 0;
			$.ajax({
				url: 'getLogData.php', // Replace with your server endpoint
				method: 'POST',
				dataType: 'json',
				data: { start: 0, limit: 30, FormID: <?php echo $FormID; ?>, ColumnFilters: columnFiltersString, EditID: $('#editID').val()},
				success: function(response) {
					if(response['data'].length <= 0){
						$("#logItems").html("<p>No Log Found..</p>");
					}
					responseHeaders = Object.keys(response['data'][0]);
					console.log(responseHeaders);
					// Load the table headers
					let logHeaderHtml = '';

					// Iterate over each key-value pair in the current object
					for (var i=0; i<responseHeaders.length; i++) {
						logHeaderHtml += `<th>
							${responseHeaders[i].charAt(0).toUpperCase() + responseHeaders[i].slice(1)}
							<input type="search" class="search-column form-control popup-search${i}"  id="${responseHeaders[i]}" placeholder="Search ${responseHeaders[i]}" data-column="${i}">
						</th>`
					}
	
					$("#logTableHeader").empty();  // Clear existing rows
					$("#logTableHeader").append(`${logHeaderHtml}`);

				
					
		
					var ddTbody = $("#logItems");
					$("#logItems").empty();  // Clear existing rows
					var rowHtml;
					response['data'].forEach((row, rowIndex )=> {
						rowHtml = `<tr>`;
						responseHeaders.forEach((column, columnIndex)=> {
							const columnName = column;
							if (columnName in row) {
							
								if(row[columnName] && row[columnName].date){
									rowHtml += `<td>${row[columnName].date}</td>`;
								}else{
									rowHtml += `<td>${row[columnName]}</td>`;
								}
							
							}
						});
						rowHtml += `</tr>`;
						console.log("after");
						ddTbody.append(rowHtml);
					});
				},
				error: function(xhr, status, error) {
					console.error('Failed to load data:', error);
					callback(false); // Callback with false on error
				}
			});
		}

		function applyLogFilters() {
			// const globalValue = $("#globalSearch").val().toLowerCase();
			activeRowIndex=-1;
			startIndex = 0;
			var ddTbody = $("#logItems");
			ddTbody.empty();  // Clear existing rows
			getLogData();
		}

		$(document).on("keydown", function(e) {
			const visibleRows = $("#logItems tr:visible");

			if (!$("#logModal").is(":visible")) return;

			switch (e.key) {
				case "Enter":
					if (!$("#logModal").is(":visible")) {
						// Open the modal if it's not visible
						console.log("on enter");
						openLogModal();
					} else {
						var triggeringFieldId = $(e.target).attr('id');
						// alert("SearchFieldName"+SearchFieldName);
						// Apply the filter if the modal is visible
						applyLogFilters();
					}
				
			}
		});
		

	</script>


	<!-- STORED PROCEDURE get list code -->
    <style>
        .toggle-icon {
            cursor: pointer;
            font-weight: bold;
            margin-right: 8px;
            color: #007bff;
        }

		.scrollable-table-container, .scrollable-companies-div {
			max-height: 300px;
			overflow-y: auto;
			display: block;
		}

		#CompaniesTable thead th, #SQLTable thead th{
			position: sticky;
			top: 0;
			background: #f8f9fa; /* match table header background */
			z-index: 1;
		}

		
		.scrollable-log-table-container {
			max-height: 500px;
			overflow-y: auto;
			display: block;
		}

		#LOGTable thead th {
			position: sticky;
			top: 0;
			background: #f8f9fa; 
			z-index: 1;
		}

		#SQLModal .modal-header, #logModal .modal-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		#SQLModal .modal-header .close, #logModal .modal-header .close {
			margin-left: auto;
		}

		#SQLModal .modal-title, #logModal .modal-title {
			margin: 0;
			text-align: left;
		}
    </style>
    <script>
		// When the button is clicked, open the modal and fetch data


		function openSQLModal(){
			// alert(type);
			$('#SQLModal').modal('show');

			getSQLData();  // Call AJAX to fetch data when modal opens
		}

        function toggleChildren(id) {
            const children = document.querySelectorAll(`.child-of-${id}`);
            children.forEach(row => {
                row.style.display = (row.style.display === 'none') ? '' : 'none';
            });

            // Toggle arrow icon
            const icon = document.querySelector(`.toggle-icon[onclick="toggleChildren('${id}')"]`);
            if (icon) {
                icon.textContent = (icon.textContent === '▶') ? '▼' : '▶';
            }
        }

		$(document).on('change', '#selectAllSpCheckbox', function() {
			const isChecked = $(this).is(':checked');
			$('.sp-checkbox').prop('checked', isChecked);
		});

		$(document).on('change', '#selectAllCompanies', function() {
			const isChecked = $(this).is(':checked');
			$('.company-checkbox').prop('checked', isChecked);
		});

		function getSQLData(){
			$.ajax({
				url: 'getSQLData.php', // Replace with your server endpoint
				method: 'POST',
				dataType: 'json',
				data: { FormID: <?php echo $FormID; ?>,ModalType:'sql'},
				success: function(response) {
					
					const rows = response.data || [];
					const CompanyRows = response.GroupCompanies || [];
					totalRecords = response.total || 0;

					$('#spCompanyGroups').html('<strong>Groups using this form</strong> : '+response.companyGroups);

					const ddTbody = $("#SQLItems").empty();

					const ddCompaniesTbody = $("#GroupCompaniesData").empty();

					if (rows.length === 0) {
						ddTbody.append("<tr><td colspan='1'>No Log Found..</td></tr>");
					} else {
                        rows.forEach((row, index) => {
                            const spId = `sp_${index}`;
                            const hasChildren = row.CalledSPs && row.CalledSPs.length > 0;

                            const toggleIcon = hasChildren ? `<span class="toggle-icon" onclick="toggleChildren('${spId}')">▶</span>` : '';
                            const parentRow = `
                                <tr>
                                    <td>
										<input type="checkbox" class="sp-checkbox" data-id="${spId}" name="spId" value="${row['ProcedureName']}">
                                        ${toggleIcon}
                                        <a href="#" onclick="loadDefinition('${row['ProcedureName']}')">${row['ProcedureName']}</a>
                                    </td>
                                </tr>
                            `;

                            ddTbody.append(parentRow);

                            if (hasChildren) {
                                row.CalledSPs.forEach(child => {
                                    const childRow = `
                                        <tr class="child-of-${spId}" style="display: none;">
                                            <td style="padding-left: 35px;">
                                                <input type="checkbox" class="sp-checkbox" data-id="${spId}" name="spId" value="${child}"> → <a href="#" onclick="loadDefinition('${child}')">${child}</a>
                                            </td>
                                        </tr>
                                    `;
                                    ddTbody.append(childRow);
                                });
                            }
                        });

					}

					if (CompanyRows.length === 0) {
						ddCompaniesTbody.append("<tr><td colspan='1'>No Company Found..</td></tr>");
					}else{
						htmlRows = '';
							CompanyRows.forEach((row, index) => {
								const htmlRows = `
									<tr>
										<td>
											<input type="checkbox" class="company-checkbox" id="spId" name="spId" value="${row['Companyid']}"> ${row['Company']}
										</td>
									</tr>
								`;
								console.log(htmlRows);
								ddCompaniesTbody.append(htmlRows);
							});
					}
				},
				error: function(xhr, status, error) {
					console.error('Failed to load data:', error);
					callback(false); // Callback with false on error
				}
			});
		}

		function renderPagination(current, totalItems) {
			const totalPages = Math.ceil(totalItems / pageSize);
			const pagination = $('#pagination').empty();

			if (totalPages <= 1) return;

			// Previous
			pagination.append(`<li class="page-item ${current === 1 ? 'disabled' : ''}">
				<a class="page-link" href="#" onclick="getSQLData(${current - 1})">Previous</a>
			</li>`);

			// Page Numbers
			for (let i = 1; i <= totalPages; i++) {
				pagination.append(`<li class="page-item ${i === current ? 'active' : ''}">
					<a class="page-link" href="#" onclick="getSQLData(${i})">${i}</a>
				</li>`);
			}

			// Next
			pagination.append(`<li class="page-item ${current === totalPages ? 'disabled' : ''}">
				<a class="page-link" href="#" onclick="getSQLData(${current + 1})">Next</a>
			</li>`);
		}

		function loadDefinition(procName) {
			fetch('getProcedureDefinition.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: `procedureName=${encodeURIComponent(procName)}`
			})
			.then(res => res.text())
			.then(text => {
				console.log('🔍 Raw response text:', text);

				let response;
				try {
					response = JSON.parse(text);
				} catch (e) {
					console.error('❌ JSON parse failed:', e);
					document.getElementById('spDefinition').innerText = 'Invalid JSON response';
					return;
				}

				console.log('✅ Parsed response:', response);
				const container = document.getElementById('spDefinition');
				container.innerText = ''; // Clear previous content

				if (response.data && Array.isArray(response.data) && response.data.length > 0) {
					response.data.forEach((item, index) => {
						const formatted = item.definition.replace(/\r\n/g, '\n');
						container.innerText += `-- Procedure ${index + 1} --\n${formatted}\n\n`;
					});
				} else {
					container.innerText = 'No definitions found.';
					console.warn('⚠️ No data or data not an array:', response.data);
				}

                
			});
		}

        $(document).ready(function() {
            //SP defination copy code
            document.getElementById('copySPDefBtn').addEventListener('click', function() {
                const spDefText = document.getElementById('spDefinition').innerText;
                
                if (!spDefText) {
                    alert('No Stored Procedure definition to copy!');
                    return;
                }

                // Use the Clipboard API if available
                if (navigator.clipboard && window.isSecureContext) {
                    // navigator clipboard api method'
                    navigator.clipboard.writeText(spDefText).then(function() {
                    alert('Procedure definition copied to clipboard!');
                    }, function(err) {
                    alert('Failed to copy text: ' + err);
                    });
                } else {
                    // Fallback method for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = spDefText;
                    // Avoid scrolling to bottom
                    textArea.style.position = 'fixed';
                    textArea.style.top = '0';
                    textArea.style.left = '0';
                    textArea.style.width = '2em';
                    textArea.style.height = '2em';
                    textArea.style.padding = '0';
                    textArea.style.border = 'none';
                    textArea.style.outline = 'none';
                    textArea.style.boxShadow = 'none';
                    textArea.style.background = 'transparent';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();

                    try {
                        const successful = document.execCommand('copy');
                        if (successful) {
                            alert('Procedure definition copied to clipboard!');
                        } else {
                            alert('Failed to copy text');
                        }
                        } catch (err) {
                        alert('Failed to copy text: ' + err);
                        }

                        document.body.removeChild(textArea);
                    }
            });

			$('#compySpToOtherCompany').on('click', function () {

				//Disabled button
				$('#compySpToOtherCompany').prop('disabled', true);

				// Get selected SPs
				var spValues = [];
				$('input.sp-checkbox[type="checkbox"]:checked').each(function () {
					spValues.push($(this).val());
				});

				// Get selected Companies
				var companyValues = [];
				$('input.company-checkbox[type="checkbox"]:checked').each(function () {
					companyValues.push($(this).val());
				});

				if (spValues.length === 0) {
					alert("Please select at least one Stored Proceduure.");
					//Enabled button
					$('#compySpToOtherCompany').prop('disabled', false);
					return; // stop execution
				}

				if (companyValues.length === 0 ) {
					alert("Please select at least one Company!");
					//Enabled button
					$('#compySpToOtherCompany').prop('disabled', false);
					return;
				}
			
				// Show confirm box
				if (!confirm("This may create, alter, or drop and recreate the existing object?")) {
					//Enabled button
					$('#compySpToOtherCompany').prop('disabled', false);
					return; // ❌ stop execution if user cancels
				}

				// Call API via AJAX
				$.ajax({
					url: 'copySpToOtherCompany.php', // change to your PHP API file
					method: 'POST',
					data: {
						sp: spValues,
						company: companyValues,
						FormID: <?php echo $FormID; ?>
					},
					success: function (response) {
						//Enable button
						$('#compySpToOtherCompany').prop('disabled', false);
						try {
							const jsonResponse = (typeof response === 'object') ? response : JSON.parse(response);
							if (jsonResponse.success) {
								alert(jsonResponse.message); // ✅ Success message from PHP
							} else {
								alert('Error: ' + jsonResponse.message); // ✅ Error message from PHP
							}
						} catch (e) {
							alert('Unexpected Response: ' + response);
						}
					},
					error: function () {
						console.error('API call failed.');
						alert('Error: Failed to copy Stored Procedures.');
					}
					
				});
			});
        });

		function applySQLFilters() {
			// const globalValue = $("#globalSearch").val().toLowerCase();
			activeRowIndex=-1;
			startIndex = 0;
			var ddTbody = $("#SQLItems");
			ddTbody.empty();  // Clear existing rows
			getSQLData();
		}

		$(document).on("keydown", function(e) {
			const visibleRows = $("#SQLItems tr:visible");

			if (!$("#SQLModal").is(":visible")) return;

			switch (e.key) {
				case "Enter":
					if (!$("#SQLModal").is(":visible")) {
						// Open the modal if it's not visible
						console.log("on enter");
						openSQLModal();
					} else {
						var triggeringFieldId = $(e.target).attr('id');
						// alert("SearchFieldName"+SearchFieldName);
						// Apply the filter if the modal is visible
						applySQLFilters();
					}
				
			}
		});

	</script>

    <div class="modal fade" id="SQLModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Stored Procedure List</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="spCompanyGroups" class="company-groups"></div>

					<div>
						<!-- Flex container -->
						<div style="display: flex; gap: 10px;">
							<!-- Left (SP Table) -->
							<div class="table-responsive" style="flex: 0 0 60%;">
								<div class="scrollable-table-container">
									<table class="table table-sm" id="SQLTable">
										<thead>
											<tr>
												<th><input type="checkbox" id="selectAllSpCheckbox" style="margin-left:4px;"> SP Name</th>
											</tr>
										</thead>
										<tbody id="SQLItems">
											<!-- Data will be loaded here -->
										</tbody>
									</table>
								</div>
							</div>

							<!-- Right (Company Names or Additional Info) -->
							<div style="flex: 0 0 40%;">
								<!-- <span>Companies</span>
								<div id="GroupCompaniesData"></div> -->
								<div class="scrollable-companies-div" >
									<div class="table-responsive">
										<table class="table table-sm" id="CompaniesTable">
											<thead>
												<tr>
													<th>
														<input type="checkbox" id="selectAllCompanies"> Companies
													</th>
												</tr>
											</thead>
											<tbody id="GroupCompaniesData">
												<!-- Company rows will be inserted here -->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<?php if($_SESSION['Category'] == 2) ?>
						<!-- ✅ Button below both tables -->
						<div class="mt-3 text-end" style="float:right;">
							<button id="compySpToOtherCompany" class="btn btn-sm btn-warning">Submit</button>
						</div>
					</div>

					<!-- Bottom Block -->
					<div class="mt-3">
						<h6>
							Stored Procedure Definition:
							<button id="copySPDefBtn" class="btn btn-sm btn-warning" style="margin-left:10px;">Copy</button>
						</h6>
						<pre id="spDefinition" class="border p-2 bg-light" style="max-height:300px; overflow:auto; white-space:pre-wrap;"></pre>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Form Cloning -->
	<script>
		// When the button is clicked, open the modal and fetch data

		function openCloningModal(){
			// alert(type);
			$('#FormCloningModal').modal('show');
			var destinationForm = $("#formCloning").data("formname");
			$('#destinationForm').val(destinationForm+" ("+<?php echo $FormID; ?>+")");
		}

		$(document).ready(function() {
			// Initialize Select2
			$('#sourceForm').select2({
				width: '100%',               // makes it full width
				placeholder: 'Select a form', // optional placeholder
				allowClear: true,             // optional clear button
				dropdownParent: $('#FormCloningModal'),
				templateResult: function (data) {
					if (!data.id) {
						return data.text;
					}
					return data.text + ' (' + data.id + ')';
				},
				templateSelection: function (data) {
					if (!data.id) {
						return data.text;
					}
					return data.text + ' (' + data.id + ')';
				},
				matcher: function(params, data) {
					if ($.trim(params.term) === '') {
						return data;
					}

					// Search term
					var term = params.term.toLowerCase();

					// Match against both text (name) and id
					if (data.text.toLowerCase().indexOf(term) > -1 || data.id.toLowerCase().indexOf(term) > -1) {
						return data;
					}

					return null;
				}
			});

			$('#sourceCompany').select2({
				width: '100%',               // makes it full width
				placeholder: 'Select a form', // optional placeholder
				allowClear: true,             // optional clear button
				dropdownParent: $('#FormCloningModal')
			});

			$('#destinationCompany').select2({
				width: '100%',               // makes it full width
				placeholder: 'Select a form', // optional placeholder
				allowClear: true,             // optional clear button
				dropdownParent: $('#FormCloningModal')
			});

		});

		$(document).on('change', '#sourceForm', function(){
			let formId = $(this).val();
			if(formId){
				$.ajax({
					url: 'getSQLData.php',   // backend
					type: 'POST',
					data: { FormID: formId,ModalType:'clone',DestinationFormID: <?php echo $FormID; ?> },
					dataType: 'json',
					success: function(response){

						if(response.success){
							// show the block only after success
							$("#fieldsSection").show();
							$("#SpViewSection").show();
							$("#cloningLogsSection").show();

							$('#availableFields').empty();
							let html = '';
							response.fields.forEach(field => {
								html += `
								<label >
									<input type="checkbox"  value="${field.id}">
									${field.name || '(No Name)'} (${field.DbFieldName})
								</label><br>
								`;
							});
							$('#availableFields').html(html);
							

							$('#destinationFields').empty();
							if(response.destinationfields.length > 0){
								$('#destinationFieldsRow').show();
								response.destinationfields.forEach(field => {
									$('#destinationFields').append(
										`<label>${field.name || '(No Name)'} (${field.DbFieldName})</label><br>`
									);
								});
							} else {
								$('#destinationFieldsRow').hide();
							}

							$("#SPSection").show();
							$('#availableSP').empty();
							if (response.procedures && response.procedures.length > 0) {
								response.procedures.forEach(sp => {
									$('#availableSP').append(
										`<label>${sp.ProcedureName}</label><br>`
									);

									
									// If it has called SPs, add them "under" the main SP
									if (sp.CalledSPs && sp.CalledSPs.length > 0) {
										sp.CalledSPs.forEach(csp => {
											$('#availableSP').append(
												`<label>&nbsp;&nbsp;&nbsp; ${csp}</option>`
											);
										});
									}

								});
							}

							$('#destinationSP').empty();
							if (response.procedures && response.procedures.length > 0) {
								response.procedures.forEach(sp => {
									$('#destinationSP').append(
										`<label>${sp.ProcedureName}</label><br>`
									);

									
									// If it has called SPs, add them "under" the main SP
									if (sp.CalledSPs && sp.CalledSPs.length > 0) {
										sp.CalledSPs.forEach(csp => {
											$('#availableSP').append(
												`<label>&nbsp;&nbsp;&nbsp; ${csp}</option>`
											);
										});
									}

								});
							}
							
							// $('#availableView').empty();
							// if (response.views && response.views.length > 0) {
							// 	response.views.forEach(view => {
							// 		$('#availableView').append(
							// 			`<option value="${view}">${view}</option>`
							// 		);
							// 	});
							// }

						} else {
							$("#fieldsSection").hide();
							$('#availableFields').html('');
							$('#selectedFields').empty();
						}
					}
				});
			} else {
				// $('#formFieldsContainer').html("<p>Please select a form.</p>");
				$('#availableFields').html('');
				$('#selectedFields').empty();
			}
		});

		$(document).on('change', '#sourceCompany, #destinationCompany', function(){
			// get values or default to 0
			let sourceCompanyID = $('#sourceCompany').val() || 0;
			let destinationCompanyID = $('#destinationCompany').val() || 0;
			let formId = $('#sourceForm').val();

			if(formId){
				$.ajax({
					url: 'getSQLData.php',   // backend
					type: 'POST',
					data: { FormID: formId,ModalType:'cloneSP',DestinationFormID: <?php echo $FormID; ?>, sourceCompany: sourceCompanyID, destinationCompany: destinationCompanyID},
					dataType: 'json',
					success: function(response){

						if(response.success){

							// $("#SpViewSection").show();
							$('#sourceSPs').empty();
							if (response.sourceFormSp && response.sourceFormSp.length > 0) {
								response.sourceFormSp.forEach(sp => {
									$('#sourceSPs').append(
										`<label><input type="checkbox"  value="${sp.ProcedureName}" data-spname="${sp.ProcedureName}">&nbsp;&nbsp ${sp.ProcedureName} 
										<span class="sp-status" id="status-${sp.ProcedureName}"></span></label><br>`
									);

									// If it has called SPs, add them "under" the main SP
									if (sp.calledSourceSPs && sp.calledSourceSPs.length > 0) {
										sp.calledSourceSPs.forEach(csp => {
											$('#sourceSPs').append(
												`<label>&nbsp;&nbsp;&nbsp;<input type="checkbox"  value="${csp}" data-spname="${csp}">&nbsp;&nbsp  ${csp}
												<span class="sp-status" id="status-${sp.ProcedureName}"></span>
												</label><br>`
											);
										});
									}

								});
							}

							$('#destinationSPs').empty();
							if (response.destinationFormSp && response.destinationFormSp.length > 0) {
								console.log(response.destinationFormSp);
								response.destinationFormSp.forEach(sp => {
									$('#destinationSPs').append(
										`<label>${sp.ProcedureName}
										</label><br>`
									);

									
									// If it has called SPs, add them "under" the main SP
									if (sp.CalledSPs && sp.CalledSPs.length > 0) {
										sp.CalledSPs.forEach(csp => {
											$('#destinationSPs').append(
												`<label>&nbsp;&nbsp;&nbsp; ${csp}</label><br>`
											);
										});
									}

								});
							}
							
							// $('#availableView').empty();
							// if (response.views && response.views.length > 0) {
							// 	response.views.forEach(view => {
							// 		$('#availableView').append(
							// 			`<option value="${view}">${view}</option>`
							// 		);
							// 	});
							// }

						} else {
							$('#availableFields').html('');
							$('#selectedFields').empty();
						}
					}
				});
			} else {
				// $('#formFieldsContainer').html("<p>Please select a form.</p>");
				$('#availableFields').html('');
				$('#selectedFields').empty();
			}
		});

		// Toggle all checkboxes inside availableFields
		$(document).on("change", "#selectAllAvailable", function() {
			let isChecked = $(this).is(":checked");
			$("#availableFields input[type=checkbox]").prop("checked", isChecked);
		});

		// If any child checkbox is unchecked → uncheck header
		// If all child checkboxes are checked → check header
		$(document).on("change", "#availableFields input[type=checkbox]", function() {
			let all = $("#availableFields input[type=checkbox]").length;
			let checked = $("#availableFields input[type=checkbox]:checked").length;
			$("#selectAllAvailable").prop("checked", all === checked);
		});


		// Toggle all checkboxes inside availableSPs
		$(document).on("change", "#selectAllAvailableSPs", function() {
			let isChecked = $(this).is(":checked");
			$("#sourceSPs input[type=checkbox]").prop("checked", isChecked);
		});

		// If any child checkbox is unchecked → uncheck header
		// If all child checkboxes are checked → check header
		$(document).on("change", "#selectAllAvailableSPs input[type=checkbox]", function() {
			let all = $("#sourceSPs input[type=checkbox]").length;
			let checked = $("#sourceSPs input[type=checkbox]:checked").length;
			$("#selectAllAvailableSPs").prop("checked", all === checked);
		});

		$(document).ready(function(){
			// Move selected option(s) → right
			$('#addField').click(function(){
				$('#availableFields option:selected').appendTo('#selectedFields');
			});

			// Move selected option(s) ← left
			$('#removeField').click(function(){
				$('#selectedFields option:selected').appendTo('#availableFields');
			});

			// Move ALL → right
			$('#addAllFields').click(function(){
				$('#availableFields option').appendTo('#selectedFields');
			});

			// Move ALL ← left
			$('#removeAllFields').click(function(){
				$('#selectedFields option').appendTo('#availableFields');
			});

			// Get selected fields (for saving)
			function getSelectedFieldIds(){
				return $('#selectedFields option').map(function(){
					return $(this).val();
				}).get();
			}

			// Move selected option(s) → right
			$('#addField1').click(function(){
				$('#availableSP option:selected').appendTo('#selectedSP');
			});

			// Move selected option(s) ← left
			$('#removeField1').click(function(){
				$('#selectedSP option:selected').appendTo('#availableSP');
			});

			// Move ALL → right
			$('#addAllFields1').click(function(){
				$('#availableSP option').appendTo('#selectedSP');
			});

			// Move ALL ← left
			$('#removeAllFields1').click(function(){
				$('#selectedView option').appendTo('#availableView');
			});

			// Move selected option(s) → right
			$('#addField2').click(function(){
				$('#availableView option:selected').appendTo('#selectedView');
			});

			// Move selected option(s) ← left
			$('#removeField2').click(function(){
				$('#selectedView option:selected').appendTo('#availableView');
			});

			// Move ALL → right
			$('#addAllFields2').click(function(){
				$('#availableView option').appendTo('#selectedView');
			});

			// Move ALL ← left
			$('#removeAllFields2').click(function(){
				$('#selectedView option').appendTo('#availableView');
			});


		});

		$(document).on('click', '#submitFields', function () {
			// Collect checked Source Field values
			let selectedSource = [];
			$("#availableFields input[type=checkbox]:checked").each(function () {
				selectedSource.push($(this).val());
			});

			// Collect Destination Fields if you are rendering them as checkboxes too
			let selectedDestination = [];
			$("#destinationFields input[type=checkbox]:checked").each(function () {
				selectedDestination.push($(this).val());
			});

			// Debug
			console.log("Source Fields:", selectedSource);
			console.log("Destination Fields:", selectedDestination);

			if (selectedSource.length === 0 && selectedDestination.length === 0) {
				alert("⚠ Please select at least one field!");
				return;
			}

			let sourceFormId = $('#sourceForm').val();      // you must have this somewhere
			let destinationFormId = <?php echo $FormID; ?>;
			let createdBy = <?php echo $_SESSION['user_id']; ?>; // from session or PHP

			$.ajax({
				url: 'callFormCloning.php',
				type: 'POST',
				data: {
					ModalType:'formFields',
					SelectedMainIdsJson: JSON.stringify(selectedSource),
					SourceFormId: sourceFormId,
					NewFormId: destinationFormId,
					CreatedBy: createdBy
				},
				success: function (response) {
					try {
						let res = JSON.parse(response);
						if (res.success) {
							console.log("res.logID",res.logID);
							$('#formCloneLogId').val(res.logID);
							alert("✅ Cloning successful: " + res.message);
						} else {
							alert("❌ Error: " + res.message);
						}
					} catch (e) {
						alert("Unexpected response: " + response);
					}
				},
				error: function (xhr, status, error) {
					alert("❌ AJAX Error: " + error);
				}
			});
		});

		
		// $(document).on('click', '#submitDataStructure', function () {
		// 	var destinationCompanyID = []
		// 	let sourceFormId = $('#sourceForm').val(); 
		// 	let destinationFormId = <?php echo $FormID; ?>;
		// 	let createdBy = <?php echo $_SESSION['user_id']; ?>; // from session or PHP
		// 	let sourceCompanyID = $('#sourceCompany').val() ;
		// 	destinationCompanyID = $('#destinationCompany').val() || [];
		// 	let logID = $('#formCloneLogId').val() || 0;
		// 	let isSelectAllTables = $('#isSelectAllTables').is(':checked') ? 1 : 0;
		// 	let isSelectAllViews = $('#isSelectAllViews').is(':checked') ? 1 : 0;

		// 	// Collect checked Source Field values
		// 	let selectedSPs = [];
		// 	$("#sourceSPs input[type=checkbox]:checked").each(function () {
		// 		selectedSPs.push($(this).val());
		// 	});


		// 	// Debug
		// 	console.log("Source sps:", selectedSPs);

		// 	// Validation
		// 	if (!sourceCompanyID || destinationCompanyID.length === 0) {
		// 		alert("⚠️ Please select both Source Company and at least one Destination Company.");
		// 		return; // stop execution
		// 	}

		// 	if (selectedSPs.length === 0 ) {
		// 		alert("⚠ Please select at least one Stored Proceduure!");
		// 		return;
		// 	}

			

		// 	$.ajax({
		// 		url: 'callFormCloning.php',
		// 		type: 'POST',
		// 		data: {
		// 			ModalType:"dataStructure",
		// 			SelectedMainIdsJson: JSON.stringify(selectedSPs),
		// 			SourceFormId: sourceFormId,
		// 			NewFormId: destinationFormId,
		// 			CreatedBy: createdBy,
		// 			SourceCompany : sourceCompanyID,
		// 			DestinationCompany: JSON.stringify(destinationCompanyID),
		// 			logID: logID,
		// 			isSelectAllTables: isSelectAllTables,
		// 			isSelectAllViews: isSelectAllViews
		// 		},
		// 		success: function (response) {
		// 			try {
		// 				const res = (typeof response === 'string') ? JSON.parse(response) : response;

		// 				if (!res.success) {
		// 					alert("❌ Error: " + (res.message || "Unknown error"));
		// 					return;
		// 				}

		// 				// Clear all previous statuses
		// 				$(".sp-status").text("").css("color", "");

		// 				if (!Array.isArray(res.rows)) return;

		// 				const colorByStatus = {
		// 					"Created": "green",
		// 					"AlreadyExists": "orange",
		// 					"NotFoundInSource": "red",
		// 					"Error": "red"
		// 				};

		// 				res.rows.forEach(r => {
		// 					const status = (r.Status || "").trim();
		// 					const src    = r.SourceProc || "";
		// 					const tgt    = r.TargetProc || "";
		// 					const db     = r.TargetDB   || "";
		// 					const cid    = r.TargetCompanyId != null ? String(r.TargetCompanyId) : "";
		// 					const errNo  = r.ErrorNumber;
		// 					const errMsg = r.ErrorMessage;

		// 					// Prefer mapping row to SourceProc element id; fall back to TargetProc
		// 					let $el = src ? $("#status-" + src) : $();
		// 					if (!$el.length && tgt) $el = $("#status-" + tgt);
		// 					if (!$el.length) return; // nothing to paint

		// 					// Build a friendly text
		// 					let text = "";
		// 					if (status === "Created") {
		// 					text = `=> created as ${tgt || src} on ${db} (Company ${cid})`;
		// 					} else if (status === "AlreadyExists") {
		// 					text = `=> already exists as ${tgt || src} on ${db} (Company ${cid}), skipped`;
		// 					} else if (status === "NotFoundInSource") {
		// 					text = "=> not found in source";
		// 					} else if (status === "Error") {
		// 					text = `=> error ${errNo || ""} ${errMsg || ""}`.trim();
		// 					} else {
		// 					text = `=> ${status}`; // fallback
		// 					}

		// 					const color = colorByStatus[status] || "black";
		// 					$el.css("color", color).text(text);
		// 				});

		// 				// $('#availableFields').empty();
		// 				// 	let html = '';
		// 				// 	res.logs.forEach(fielologgld => {
		// 				// 		html += `
		// 				// 		<label >
		// 				// 			<input type="checkbox"  value="${field.id}">
		// 				// 			${field.name || '(No Name)'} (${field.DbFieldName})
		// 				// 		</label><br>
		// 				// 		`;
		// 				// 	});
		// 				// $('#availableFields').html(html);

		// 				if (res.logs && Array.isArray(res.logs)) {
		// 					let html = '<table class="table table-striped">';
		// 					html += `
		// 						<thead>
		// 							<tr>
		// 								<th>Action</th>
		// 								<th>Object Name</th>
		// 								<th>Description</th>
		// 								<th>Source Company</th>
		// 								<th>Destination Company</th>
		// 								<th>Created On</th>
		// 								<th>Created By</th>
		// 							</tr>
		// 						</thead>
		// 						<tbody>
		// 					`;

		// 					res.logs.forEach(function(log) {
		// 						html += `
		// 							<tr>
		// 								<td>${log.Action ?? ''}</td>
		// 								<td>${log.ObjectName ?? ''}</td>
		// 								<td>${log.Desccription ?? ''}</td>
		// 								<td>${log.SourceCompany ?? ''}</td>
		// 								<td>${log.DestinationCompany ?? ''}</td>
		// 								<td>${log.CreatedOn ?? ''}</td>
		// 								<td>${log.CreatedBy ?? ''}</td>
		// 							</tr>
		// 						`;
		// 					});

		// 					html += '</tbody></table>';
		// 					console.log("html",html);
		// 					$('#availableLogs').html(html);
		// 				}


		// 			}  catch (e) {
		// 				alert("Unexpected response: " + response);
		// 			}
		// 		},
		// 		error: function (xhr, status, error) {
		// 			alert("❌ AJAX Error: " + error);
		// 		}
		// 	});
		// });

		// $(document).on('click', '#downloadDataStructureSQL', function () {
		// 	// gather same inputs as Submit
		// 	const sourceFormId = $('#sourceForm').val();
		// 	const destinationFormId = <?php echo $FormID; ?>;
		// 	const createdBy = <?php echo $_SESSION['user_id']; ?>;
		// 	const sourceCompanyID = $('#sourceCompany').val();
		// 	const destinationCompanyID = $('#destinationCompany').val() || [];
		// 	const isSelectAllTables = $('#isSelectAllTables').is(':checked') ? 1 : 0;
		// 	const isSelectAllViews  = $('#isSelectAllViews').is(':checked') ? 1 : 0;

		// 	// collect selected SPs
		// 	const selectedSPs = [];
		// 	$("#sourceSPs input[type=checkbox]:checked").each(function () {
		// 		selectedSPs.push($(this).val());
		// 	});

		// 	if (!sourceFormId) { alert("Select a source form."); return; }
		// 	if (!sourceCompanyID) { alert("Select source company."); return; }
		// 	if (destinationCompanyID.length === 0) { alert("Select at least one destination company."); return; }
		// 	if (selectedSPs.length === 0 && !isSelectAllTables && !isSelectAllViews) {
		// 		alert("Pick at least one SP (or select tables/views).");
		// 		return;
		// 	}

		// 	// 1) call API with dryRun=1 so it builds the SQL bundle in session but does NOT execute mutations
		// 	$.ajax({
		// 		url: 'callFormCloning.php',
		// 		type: 'POST',
		// 		data: {
		// 		ModalType: 'dataStructure',
		// 		SourceFormId: sourceFormId,
		// 		NewFormId: destinationFormId,
		// 		CreatedBy: createdBy,
		// 		SourceCompany: sourceCompanyID,
		// 		DestinationCompany: JSON.stringify(destinationCompanyID),
		// 		SelectedMainIdsJson: JSON.stringify(selectedSPs),
		// 		isSelectAllTables: isSelectAllTables,
		// 		isSelectAllViews: isSelectAllViews,
		// 		dryRun: 1 // <— key flag
		// 		},
		// 		success: function () {
		// 		// 2) once bundle is ready, open the download endpoint
		// 		window.open('downloadCloneScript.php', '_blank');
		// 		},
		// 		error: function (xhr, s, e) {
		// 		alert("❌ Dry-run failed: " + e);
		// 		}
		// 	});
		// });

		// Bind both buttons
		$(document).on('click', '#submitDataStructure', function () {
			handleDataStructure(false); // run & update logs
		});
		$(document).on('click', '#downloadDataStructureSQL', function () {
			handleDataStructure(true); // dry run & download
		});

		function handleDataStructure(isDownload = false) {
			const sourceFormId = $('#sourceForm').val();
			const destinationFormId = <?php echo $FormID; ?>;
			const createdBy = <?php echo $_SESSION['user_id']; ?>;
			const sourceCompanyID = $('#sourceCompany').val();
			const destinationCompanyID = $('#destinationCompany').val() || [];
			const logID = $('#formCloneLogId').val() || 0;
			const isSelectAllTables = $('#isSelectAllTables').is(':checked') ? 1 : 0;
			const isSelectAllViews  = $('#isSelectAllViews').is(':checked') ? 1 : 0;

			// collect selected SPs
			const selectedSPs = [];
			$("#sourceSPs input[type=checkbox]:checked").each(function () {
				selectedSPs.push($(this).val());
			});

			// Validation
			if (!sourceCompanyID || destinationCompanyID.length === 0) {
				alert("⚠️ Please select both Source Company and at least one Destination Company.");
				return;
			}
			if (selectedSPs.length === 0 && !isSelectAllTables && !isSelectAllViews) {
				alert("⚠ Please select at least one Stored Procedure / Table / View!");
				return;
			}

			$.ajax({
				url: 'callFormCloning.php',
				type: 'POST',
				data: {
					ModalType: "dataStructure",
					SelectedMainIdsJson: JSON.stringify(selectedSPs),
					SourceFormId: sourceFormId,
					NewFormId: destinationFormId,
					CreatedBy: createdBy,
					SourceCompany: sourceCompanyID,
					DestinationCompany: JSON.stringify(destinationCompanyID),
					logID: logID,
					isSelectAllTables: isSelectAllTables,
					isSelectAllViews: isSelectAllViews,
					dryRun: isDownload ? 1 : 0
				},
				success: function (response) {
					if (isDownload) {
						// just trigger download
						window.open('downloadCloneScript.php', '_blank');
						return;
					}

					try {
						const res = (typeof response === 'string') ? JSON.parse(response) : response;

						if (!res.success) {
							alert("❌ Error: " + (res.message || "Unknown error"));
							return;
						}

						// Clear statuses
						$(".sp-status").text("").css("color", "");

						if (Array.isArray(res.rows)) {
							const colorByStatus = {
								"Created": "green",
								"AlreadyExists": "orange",
								"NotFoundInSource": "red",
								"Error": "red"
							};

							res.rows.forEach(r => {
								const status = (r.Status || "").trim();
								const src    = r.SourceProc || "";
								const tgt    = r.TargetProc || "";
								const db     = r.TargetDB   || "";
								const cid    = r.TargetCompanyId != null ? String(r.TargetCompanyId) : "";
								const errNo  = r.ErrorNumber;
								const errMsg = r.ErrorMessage;

								let $el = src ? $("#status-" + src) : $();
								if (!$el.length && tgt) $el = $("#status-" + tgt);
								if (!$el.length) return;

								let text = "";
								if (status === "Created") {
									text = `=> created as ${tgt || src} on ${db} (Company ${cid})`;
								} else if (status === "AlreadyExists") {
									text = `=> already exists as ${tgt || src} on ${db} (Company ${cid}), skipped`;
								} else if (status === "NotFoundInSource") {
									text = "=> not found in source";
								} else if (status === "Error") {
									text = `=> error ${errNo || ""} ${errMsg || ""}`.trim();
								} else {
									text = `=> ${status}`;
								}

								const color = colorByStatus[status] || "black";
								$el.css("color", color).text(text);
							});
						}

						if (res.logs && Array.isArray(res.logs)) {
							let html = '<table class="table table-striped">';
							html += `
								<thead>
									<tr>
										<th>Action</th>
										<th>Object Name</th>
										<th>Description</th>
										<th>Source Company</th>
										<th>Destination Company</th>
										<th>Created On</th>
										<th>Created By</th>
									</tr>
								</thead>
								<tbody>
							`;

							res.logs.forEach(function(log) {
								html += `
									<tr>
										<td>${log.Action ?? ''}</td>
										<td>${log.ObjectName ?? ''}</td>
										<td>${log.Desccription ?? ''}</td>
										<td>${log.SourceCompany ?? ''}</td>
										<td>${log.DestinationCompany ?? ''}</td>
										<td>${log.CreatedOn ?? ''}</td>
										<td>${log.CreatedBy ?? ''}</td>
									</tr>
								`;
							});

							html += '</tbody></table>';
							$('#availableLogs').html(html);
						}

					} catch (e) {
						alert("Unexpected response: " + response);
					}
				},
				error: function (xhr, status, error) {
					alert("❌ AJAX Error: " + error);
				}
			});
		}
		


	</script>

    <div class="modal fade" id="FormCloningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Form Cloning</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				

				<div class="modal-body">
					<div id="formCloningBody" style="max-height:500px; overflow-y:auto;">
						
						<div class="row mb-3">
							<!-- Select Source Form -->
							<div class="col-md-6">
								<label for="sourceForm" class="form-label fw-bold">Select Source Form</label>
								<select id="sourceForm" name="sourceForm" class="form-control populate">
									<?php
										$sql = "SELECT * FROM kmainforms";
										$result1 = db::getInstanceMaster()->db_select($sql);
										$num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
										for ($i = 0; $i < $num_rows; $i++) {
											$template = $result1['result_set'][$i];
											echo '<option class="gridTemplate" value="' . $template['FormId'] . '">' . $template['FormName'] . '</option>';
										}
									?>
								</select>
							</div>

							<!-- <div class="col-md-2"></div> -->

							<!-- selected Destination form -->
							 <div class="col-md-6">
								<label for="sourceForm" class="form-label fw-bold">Selected Destination Form</label>
								
								<input type="text" id="destinationForm" name="destinationForm" class="form-control" value="" readonly>
								
							</div>

							
						</div>

						
						<div id="fieldsSection" style="margin-top:20px;display:none;">
							<div class="panel-group" id="fieldAccordion">
								<div class="panel panel-default">
									<!-- Accordion Header -->
									<div class="panel-heading" role="tab" id="headingFields1">
										<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#fieldAccordion"
											href="#collapseFields1" aria-expanded="false" aria-controls="collapseFields1"
											style="display:block; text-decoration:none;">
											Form Design 
										</a>
										</h4>
									</div>

									<!-- Collapsible Section -->
									<div id="collapseFields1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFields1">
										<div class="panel-body">

											<!-- Fields Section -->
											<div class="row">
												<!-- Available Fields -->
												<div class="col-md-6">
													<div style="padding:5px;">
														<input type="checkbox" id="selectAllAvailable">&nbsp;&nbsp;&nbsp;<b>Source Fields</b>
													</div>
													<div id="availableFields" class="list-group border p-2 form-control"
														style="height:300px; overflow-y:auto; padding:5px;">
														<!-- Items will be added here dynamically -->
													</div>
												</div>

												<!-- <div class="col-md-2"></div> -->

												<!-- Destination Fields -->
												<div class="col-md-6">
													<div style="padding:5px;"><b>Destination Fields</b></div>
													<div id="destinationFields" class="list-group border p-2 form-control"
														style="height:300px; overflow-y:auto; padding:5px;">
														<!-- Moved items will appear here -->
													</div>
												</div>
											</div>

											<!-- Submit Button -->
											<div class="row mt-4">
												<div class="col text-center">
													<button id="submitFields" class="btn btn-success px-4">Submit</button>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div>

						<div id="SpViewSection" style="margin-top:20px;display:none;">
							<div class="panel-group" id="SpViewAccordion">
								<div class="panel panel-default">
									<!-- Accordion Header -->
									<div class="panel-heading" role="tab" id="headingFields2">
										<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#SpViewAccordion"
											href="#collapseFields2" aria-expanded="false" aria-controls="collapseFields2"
											style="display:block; text-decoration:none;">
											Data Structure
										</a>
										</h4>
									</div>

									<!-- Collapsible Section -->
									<div id="collapseFields2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFields2">
										<div class="panel-body">

											<!-- Company  Section -->
											 <div class="row mb-3">
												<!-- Select Source Form -->
												<div class="col-md-6">
													<label for="sourceCompany" class="form-label fw-bold">Select Source Company</label>
													<select id="sourceCompany" name="sourceCompany" class="form-control populate">
														<?php
															$sql = "select * from AiCompany";
															$result1 = db::getInstanceMaster()->db_select($sql);
															$num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
															echo '<option class="gridTemplate" value="">SELECT</option>';
															for ($i = 0; $i < $num_rows; $i++) {
																$template = $result1['result_set'][$i];
																echo '<option class="gridTemplate" value="' . $template['ID'] . '">' . $template['Label'] . '</option>';
															}
														?>
													</select>
												</div>

												<!-- <div class="col-md-2"></div> -->

												<!-- selected Destination form -->
												<div class="col-md-6">
													<label for="destinationCompany" class="form-label fw-bold">Select Destination Company</label>
													<select multiple id="destinationCompany" name="destinationCompany" class="form-control populate">
														<?php
															$sql = "select * from AiCompany";
															$result1 = db::getInstanceMaster()->db_select($sql);
															$num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
															$defaultCompany = $_SESSION['dbCompany'] ?? null; // session value

															for ($i = 0; $i < $num_rows; $i++) {
																$template = $result1['result_set'][$i];
																$selected = ($template['ID'] == $defaultCompany) ? "selected" : "";
																echo '<option class="gridTemplate" value="' . $template['ID'] . '" ' . $selected . '>' . $template['Label'] . '</option>';
																// echo '<option class="gridTemplate" value="' . $template['ID'] . '">' . $template['Label'] . '</option>';
															}
														?>
													</select>
													
												</div>
											</div>

										

											<div class="row">
												<div class="col-md-12">
													<button id="downloadDataStructureSQL" class="btn btn-primary" >Download SQL</button>
												</div>
												<div class="col-md-12">
													<div style="padding:5px;">
														<input type="checkbox" id="isSelectAllTables">&nbsp;&nbsp;&nbsp;<b>Clone All Tables from Source to Destination</b>														
													</div>
												</div>
												<div class="col-md-12">
													<div style="padding:5px;">
														<input type="checkbox" id="isSelectAllViews">&nbsp;&nbsp;&nbsp;<b>Clone All Views from Source to Destination</b>
													</div>
												</div>
											</div>

											<!-- SP Section -->
											<!-- Fields Section -->
											<div class="row">
												<!-- Available Fields -->
												<div class="col-md-6">
													<div style="padding:5px;">
														<input type="checkbox" id="selectAllAvailableSPs">&nbsp;&nbsp;&nbsp;<b>Source Form Stored Procedure</b>
													</div>
													<div id="sourceSPs" class="list-group border p-2 form-control"
														style="height:300px; overflow-y:auto; padding:5px;">
														<!-- Items will be added here dynamically -->
													</div>
												</div>

												<!-- <div class="col-md-2"></div> -->

												<!-- Destination Fields -->
												<div class="col-md-6">
													<div style="padding:5px;"><b>Destination Form Stored Procedure</b></div>
													<div id="destinationSPs" class="list-group border p-2 form-control"
														style="height:300px; overflow-y:auto; padding:5px;">
														<!-- Moved items will appear here -->
													</div>
												</div>
											</div>

											<!-- Submit Button -->
											<div class="row mt-4">
												<div class="col text-center">
													<button id="submitDataStructure" class="btn btn-success px-4">Submit</button>
												</div>
											</div>
											

										</div>
									</div>
								</div>
							</div>

						</div>

						<input type="hidden" id="formCloneLogId" value="0">

						<div id="cloningLogsSection" style="margin-top:20px;display:none;">
							<div class="panel-group" id="logAccordion">
								<div class="panel panel-default">
									<!-- Accordion Header -->
									<div class="panel-heading" role="tab" id="headingFields2">
										<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-parent="#logAccordion"
											href="#collapseLogs" aria-expanded="false" aria-controls="collapseLogs"
											style="display:block; text-decoration:none;">
											Logs 
										</a>
										</h4>
									</div>

									<!-- Collapsible Section -->
									<div id="collapseLogs" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFields2">
										<div class="panel-body">

											<!-- Fields Section -->
											<div class="row">
												<!-- Available Fields -->
												<div class="col-md-12">
													<div style="padding:5px;">
														<!-- <input type="checkbox" id="selectAllAvailable">&nbsp;&nbsp;&nbsp;<b>Logs</b> -->
													</div>
													<div id="availableLogs" class="list-group border p-2 form-control"
														style="height:300px; overflow-y:auto; padding:5px;">
														<!-- Items will be added here dynamically -->
													</div>
												</div>

												<!-- <div class="col-md-2"></div> -->

												<!-- Destination Fields -->
												<!-- <div class="col-md-6">
													<div style="padding:5px;"><b>Destination Fields</b></div>
													<div id="destinationFields" class="list-group border p-2 form-control"
														style="height:300px; overflow-y:auto; padding:5px;">
														Moved items will appear here -->
													<!-- </div>
												</div> -->
											</div>

											<!-- Submit Button -->
											<div class="row mt-4">
												<div class="col text-center">
													<button id="submitFields" class="btn btn-success px-4">Submit</button>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div>



					</div>
				</div>


				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


	<!-- Report Groups -->
	 <script>
		function openGroupModal(){
			// alert(type);
			$('#GroupModal').modal('show');
			getGroups();  // Call AJAX to fetch data when modal opens
		}

		function getGroups(){
			$.ajax({
				url: 'getSQLData.php', // Replace with your server endpoint
				method: 'POST',
				dataType: 'json',
				data: {FormID: <?php echo $FormID; ?>,ModalType:'groups'},
				success: function(response) {
					
					const rows = response.companyGroups || [];
				
					const ddTbody = $("#groupList").empty();
					console.log(rows);
					if (rows.length === 0) {
						ddTbody.append("No Data Found");
					} else {
						rowHtml = '';
                        rows.forEach((row, index) => {
							console.log(row);
                            rowHtml += `<input type="checkbox" id="checkbox" class="group-checkbox" value="${row['Company_Groupid']}"> ${row['Company_Group']}<br>`;

                        });
						ddTbody.append(rowHtml);
					}
				},
				error: function(xhr, status, error) {
					console.error('Failed to load data:', error);
					callback(false); // Callback with false on error
				}
			});
		}
	</script>

	<div class="modal fade" id="GroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Company List</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="groupList">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick='copyReportTemplate()'>Copy</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Requirement Modal -->
	<script>
		// When the button is clicked, open the modal and fetch data
		function openRequirementModal(){
			// alert(type);
			const iframe = document.getElementById('requirementIframe');
			iframe.src = 'requirements.php?formid=' + <?php echo $FormID; ?>;

			document.getElementById('requirementPageContainer').style.display = 'block';

			$('#RequirementModal').modal('show');
			$('#attachment').css('display', 'block');
			$('#assignedTo').attr('disabled', false);
			
			// currentPage = 1;
			// getSQLData(currentPage);  // Call AJAX to fetch data when modal opens
		}

		const requirementRows = [];

		function addRequirementToGrid() {
			const form = document.getElementById("requirementForm");
			const requirement = form.requirement.value.trim();
			const assignedToSelect = document.getElementById("assignedTo");
			const selectedOptions = [...assignedToSelect.selectedOptions]; // multiple selected
			

			if (!requirement || selectedOptions.length === 0) {
				alert("Please fill all required fields.");
				return;
			}

			const assignedTo = selectedOptions.map(opt => opt.value); // array of IDs
			const assignedToName = selectedOptions.map(opt => opt.text); // array of Names
			const fileInput = document.getElementById("attachment");
			const file = fileInput.files[0] || null;

			const rowData = {
				requirement,
				assignedTo,       // array of IDs
				assignedToName,   // array of names
				file,  // store the file object
				fileName: file?.name || null
			};

			requirementRows.push(rowData);
			renderRequirementGrid();
			form.reset();

			// Clear Select2 manually
			$('#assignedTo').val(null).trigger('change');
		}

		function renderRequirementGrid() {
			const tbody = document.getElementById("requirementGrid").querySelector("tbody");
			tbody.innerHTML = "";

			requirementRows.forEach((row, index) => {
				const tr = document.createElement("tr");
				tr.innerHTML = `
					<td>${row.requirement}</td>
					<td>${row.assignedToName.join(', ')}</td>
					<td>${row.fileName ? `<a href="#">${row.fileName}</a>` : 'No File'}</td>
					<td><button class="btn btn-danger btn-sm" onclick="removeRequirementRow(${index})">Remove</button></td>
				`;
				tbody.appendChild(tr);
			});
		}

		function removeRequirementRow(index) {
			requirementRows.splice(index, 1);
			renderRequirementGrid();
		}

		function submitRequirementForm() {
			if (requirementRows.length === 0) {
				alert("Please add at least one requirement before submitting.");
				return;
			}

			const formData = new FormData();
			formData.append('formId', <?php echo $FormID; ?>);
			formData.append('requirements', JSON.stringify(requirementRows));

			requirementRows.forEach((row, i) => {
				if (row.file) {
					formData.append(`files[${i}]`, row.file); // assuming row.file is File object
				}
			});

			console.log(formData);

			fetch("submitRequirement.php", {
				method: "POST",
				// 🚫 DO NOT manually set headers here
				body: formData
			})
			.then(res => res.json())
			.then(data => {
				if (data.success) {
					alert("Requirements saved successfully!");
					requirementRows.length = 0;
					renderRequirementGrid();
					$("#RequirementModal").modal("hide");
				} else {
					alert("Error: " + data.message);
				}
			})
			.catch(err => {
				console.error("Submit error:", err);
				alert("Submission failed.");
			});
		}
	</script>

	<div class="modal fade" id="RequirementModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document" style="width:95vw;margin: 25px auto;">
			<div class="modal-content" style="height: calc(95vh - 15px);">
				<div class="modal-header">
					<h5 class="modal-title" style="display: inline-block;" id="exampleModalLabel">Requirements</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="padding:0 !important">
					<div id="requirementPageContainer" class="mt-3" style="display: none; height: 85vh;">
						<iframe id="requirementIframe" src="" width="100%" height="100%" frameborder="0"></iframe>
					</div>
				</div>
				<!-- <div class="modal-footer"> -->
					<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
					<!-- <button type="button" class="btn btn-primary" onclick="submitRequirementForm()">Submit</button> -->
				<!-- </div> -->
			</div>
		</div>
	</div>
	<script>
		$('#requirementIframe').on('load', function () {
			var iframeDoc = $(this).contents();
			iframeDoc.find('#URLF').val(window.location.href);
		});
	</script>



	<!-- Added code for field type 16 & 17 on date 01-01-2025 -->
	<div class="modal fade" id="myModal" data-backdrop="static" tabindex="-1" aria-labelledby="myModalLabel"  aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header" style="border: 0;">
					<h5 class="modal-title" id="myModalLabel">Select Items</h5>
					<button id="PopulateGridButton" class="btn btn-primary" >Populate Grid</button>
					<button type="button" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">X</button>
					<!-- <hr> -->
					<div class="row" style="border-top: 1px solid #e5e5e5; margin-top: 10px; padding-top: 5px;margin-left:2px;">
						<div class="col-md-10">
							<div id="ShowAdjustableAmountField" class="d-flex flex-wrap gap-2 align-items-center" style="display:none;">
								<div class='PopupAmount'>
									<label>Amount:</label>
									<input type="text" class="form-control" name="PopupAmount" id="PopupAmount" value="5000" readonly style="text-align:right;">
									<input type="hidden" class="form-control" name="PopupGridId" id="PopupGridId" value="">
								</div>

								<div class='PopupAdjamount d-flex align-items-center gap-2' >
									<label>Clr Bal:</label>
									<input type="number" class="form-control" readonly name="PopupAdjamount" id="PopupAdjamount" step="any" value="" ><span id="PopupAdjamountSign"></span>
								</div>

								<div class='PopupBalance'>
									<label>Balance:</label>
									<input type="number" class="form-control" name="PopupBalance" id="PopupBalance" step="0.01" value="" readonly style="text-align:right;">
								</div>

								<div class='PopupAccount'>
									<label>Account:</label>
									<input type="text" class="form-control" name="PopupAccount" id="PopupAccount" value="" readonly style="width:200px;">
								</div>

								<div class='saveAdjAmtButton'>
									<label></label><br>
									<button style="display: none;" type="button" class="btn btn-danger" id="saveAdjAmtButton" onclick="saveAdjAmtData();">Save Adjustment Amount</button>
									<button style="display: none;" type="button" class="btn btn-default" id="saveAdjAmtCloseButton" data-dismiss="modal" aria-label="Close">Close</button>
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<input type="search" id="globalSearch" class="form-control popup-search" placeholder="Search All Columns">
						</div>
					</div>

					<div class="col-md-12" style="margin-top: 12px;margin-bottom: 12px;">
						<div id="pillContainer" style="display:flex; flex-wrap:wrap; gap:5px; max-height:60px; overflow-y:auto;"></div>
						<div id="pillContainerClear" class="mt-2">
						<button type="button" class="btn" style="padding:1px 5px;" onclick="deselectAllRow();">Clear All Selected Row</button>
						</div>
					</div>

					<div id="ValidationMessage" style="display:none;"></div>

					<input type="hidden" id="DropDownModalID" value="">
					<!-- <p>Shortcut: Press Alt + K to jump to the next row and auto-fill it with the previous date.</p> -->
				</div>

				<div class="modal-body">
					<div id="dropdownContent" class="dropdown-content" style="overflow1:hidden;">
						
						<div style="overflow:auto1;">
							<table class="table table-striped" id="ddTable">
								<thead>
									<tr id="tableHeader">
									<!-- Table headers will be inserted dynamically -->
									</tr>
								</thead>
								<tbody id="dropdownItems">
								<!-- Dynamically loaded rows will go here -->
								</tbody>
								<!-- <tfoot id="tableFooter">
							
								</tfoot> -->
							</table>
						</div>
						<div class="loading" id="loadingData">Loading...</div>
						<div class="loading" id="loadingMessage">Loading more...</div>
					</div>
				</div>
				<div class="modal-footer" style="text-align:left;">
					<button id="clearSelection" class="btn btn-secondary" onclick="clearSelection()">Clear All</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		var ddSelectedItemsValue = [];
		var ddSelectedItemsText = [];
		var startIndex = 0;
		var isKreonFT17_CallNextIndex = false;
		var itemsPerPage = 30;  // Number of items to load per scroll
		var activeRowIndex = -1;
		var triggeringButtonTabIndex = null;
		var isSpacebarPressed = false;
		var triggeringButtonId = null;
		var ddDBFieldType = 0;
		var ddResponseData = [];
		var ddisGrid = 0;
		var GridID = 0; 
		var requestParams = '';
		var formReeponseString = '';
		var triggeringButtonSrNo = '';
		var ddRowSelectType = '';

		var ddResponseTotalColumnIndex = [];
		var responseHeaders = [];
		var ddResponsePopulateFields = '';
		var ddResponsePopulateFieldInGrids = '';
		var ddResponsePopulateGrid = '';
		var ddResponseSytemType = 0;
		var hasMoreData = true;
		
		

		async function toggleModal(event) {
			console.log('in toggle modal',$(event.target).attr('id'));
			targetFieldId = $(event.target).attr('id');
		
		
			//Field label show in modal header
			var labelText = $('#'+targetFieldId).data('label');
			
			ddDBFieldType = $(event.target).data('type');

			if (targetFieldId.includes('kreon-grid')) {
				
				ddResponseSytemType = $('#'+targetFieldId).data('systemtype');
				targetFieldId = targetFieldId.split("-");
				triggeringButtonId = targetFieldId[2].substring(1);
				triggeringButtonSrNo = targetFieldId[2].charAt(0);
				ddisGrid = 1;
				GridID = $('#GridId'+targetFieldId[2].charAt(0)).val();

			}else{
				targetFieldId = targetFieldId.split("-");
				console.log("targetFieldId",targetFieldId);
				triggeringButtonId = targetFieldId[0]; 
				ddisGrid = 0;
				
				// Check if the value contains only digits 
				const isOnlyDigits = /^\d+$/.test(triggeringButtonId);
				if (isOnlyDigits == true) {
					GridID = triggeringButtonId;
					ddDBFieldType = 14;
					ddResponseSytemType = $('#'+triggeringButtonId).data('systemtype');
				}else{
					GridID = 0;
					ddResponseSytemType = $('#'+triggeringButtonId+'-text').data('systemtype');
				}

				if(ddResponseSytemType == 2){
					var buttonType = $('#'+triggeringButtonId+'-text').data('buttontype');
					if(buttonType != undefined){
						var splitButtonType = buttonType.split("-");
						GridID = splitButtonType[1];
						ddDBFieldType = 14;
					}else{
						GridID = 0;
					}
				}
			}

			$('#ShowAdjustableAmountField').hide();
			hasMoreData = true;
			console.log("hasMoreData",hasMoreData);
			var ddTbody = $("#dropdownItems");
			ddTbody.empty(); 
			var ddHeader  = $("#tableHeader");
			ddHeader.empty();
			if ($('#myModal').hasClass('show')) {
				$('#myModal').modal('hide');
			}
			// $('#myModal').modal('hide');

			
			$('#myModal').modal('show');
			
			$('#DropDownModalID').val($(event.target).attr('id'));
			
			//Field name update in modal header
			$('#myModalLabel').text(labelText);
			
			$("#pillContainer").empty();
			ddSelectedItemsValue = [];
			ddSelectedItemsText = [];
			startIndex = 0;
			triggeringButtonTabIndex = event.target.getAttribute('tabindex');
			// console.log("hello "+$("#kreon-grid-"+triggeringButtonSrNo+triggeringButtonId+"-text[type='button']").val());
			//on load in edit mode selected checkbox check & pill also display
			if(ddDBFieldType == 17){
				if(ddisGrid == 1){
					ddSelectedItemsText = $("#kreon-grid-"+triggeringButtonSrNo+triggeringButtonId+"-text[type='button']").val() ? $("#kreon-grid-"+triggeringButtonSrNo+triggeringButtonId+"-text[type='button']").val().split(",") : [];
					SingleValues = $("#kreon-grid-"+triggeringButtonSrNo+triggeringButtonId+"[type='hidden']").val().split(",");// .map(Number); //MITESH REMOVED
					
					// SingleValues = SingleValues.length === 1 && SingleValues[0] === 0 ? [] : SingleValues;
					// Check if the value is either undefined, empty string, or an array with an empty string
					if (!SingleValues || (Array.isArray(SingleValues) && SingleValues.length === 1 && SingleValues[0] === '')) {
						ddSelectedItemsValue = [];
					} else {
						ddSelectedItemsValue = SingleValues
					}
					
					$('#PopulateGridButton').hide();
				}else{
					ddSelectedItemsText = $("#"+triggeringButtonId+"-text[type='button']").val() ? $("#"+triggeringButtonId+"-text[type='button']").val().split(",") : [];
					SingleValues = $("#"+triggeringButtonId+"[type='hidden']").val().split(",");// .map(Number); //MITESH REMOVED
				
					// Check if the value is either undefined, empty string, or an array with an empty string
					if (!SingleValues || (Array.isArray(SingleValues) && SingleValues.length === 1 && SingleValues[0] === '')) {
						ddSelectedItemsValue = [];
					} else {
						ddSelectedItemsValue = SingleValues
					}

					// SingleValues = SingleValues.length === 1 && SingleValues[0] === 0 ? [] : SingleValues;
					// ddSelectedItemsValue = SingleValues;
					$('#PopulateGridButton').hide();
				}
	
			}else if(ddDBFieldType == 16){
				if(ddisGrid == 1){
					console.log("In field type 16");
					console.log(triggeringButtonSrNo,triggeringButtonId);
					ddSelectedItemsText = $("#kreon-grid-"+triggeringButtonSrNo+triggeringButtonId+"-text[type='button']").val() ? $("#kreon-grid-"+triggeringButtonSrNo+triggeringButtonId+"-text[type='button']").val().split(",") : [];
					MultipleValues = $("#kreon-grid-"+triggeringButtonSrNo+triggeringButtonId+"[type='hidden']").val().split(",");// .map(Number); //MITESH REMOVED
					if (!MultipleValues || (Array.isArray(MultipleValues) && MultipleValues[0] === '')) {
						ddSelectedItemsValue = [];
					} else {
						ddSelectedItemsValue = MultipleValues
					}
				}else{
					ddSelectedItemsText = $("#"+triggeringButtonId+"-text[type='button']").val() ? $("#"+triggeringButtonId+"-text[type='button']").val().split(",") : [];
					MultipleValues = $("#"+triggeringButtonId+"[type='hidden']").val().split(",");// .map(Number); //MITESH REMOVED
					if (!MultipleValues || (Array.isArray(MultipleValues) && MultipleValues[0] === '')) {
						ddSelectedItemsValue = [];
					} else {
						ddSelectedItemsValue = MultipleValues
					}
				}
				// MultipleValues = MultipleValues.length === 1 && MultipleValues[0] === 0 ? [] : MultipleValues;
				$('#PopulateGridButton').hide();
			}else if(ddDBFieldType == 14){
				$('#PopulateGridButton').show();
				$('#myModal').find('#PopulateGridButton').prop("disabled", false);
			}else if(ddDBFieldType == 23){
				$('#PopulateGridButton').hide();
			}
			
			// console.log("toggleModal", ddSelectedItemsValue);
			
			ddResponseData = [];
			// if(ddDBFieldType == 14){
			// 	var systemType = $('#'+triggeringButtonId).data('systemtype');
			// }else{
			// 	if(ddisGrid == 1){
			// 		var systemType = $('#kreon-grid-'+triggeringButtonSrNo+triggeringButtonId+'-text').data('systemtype');
			// 	}else{
			// 		console.log("in else");
			// 		var systemType = $('#'+triggeringButtonId+'-text').data('systemtype');
			// 	}
			// }

			
			if(ddResponseSytemType == 1){
				//old system for fld 16, 17
				console.log("in togglemodal");
				startIndex = 0;
				itemsPerPage = 30;
				await fetchTableData(triggeringButtonId);
				// loadData(triggeringButtonId);
			}else{
				//New system for fld 16, 17
				await loadHeaderData(triggeringButtonId);
			}

			activeRowIndex=-1;

			if(ddSelectedItemsValue.length > 0){
				await displaySelectedItems();
			}
			

			if(ddResponseData && ddResponseData['AdjustableAmount'] == 'enable' || ddResponseData && ddResponseData['adjamount'] == 'enable'){

				
				$('#ShowAdjustableAmountField').css('display', 'flex');
				// $('#ShowAdjustableAmountField').css('display', 'block');
				$('#PopupAmount').val(0);
				$('#PopupAdjamount').val(0);
				$('#PopupBalance').val(0);

				var gridid = ddResponseData['PopulateGrid'].split(":");
				var gridIdentifier = $('#grid-id-'+gridid[1]).attr('class');		
				var gridSerialNo = gridIdentifier.slice(4);
				$('#PopupAmount').val(Math.abs($('#kreon-grid-'+gridSerialNo+'amount').val()));

				if ($('#kreon-grid-aacnoid-text').length > 0) {
					var accountName = $('#kreon-grid-aacnoid-text').val();
				}else{
					var accountName =  $('#kreon-grid-aacnoid :selected').text();
					// find("#'.$d[3].'"+mArray[t][1] + " :selected").text();
				}
				$('#PopupAccount').val(accountName);
				// $('#PopupAdjamount').val(0);
				// alert($('#kreon-grid-'+gridSerialNo+'amount').val(), $('#kreon-grid-'+gridSerialNo+'SingleDDModaladjamount').val())
				if($('#kreon-grid-'+gridSerialNo+'amount').val() > 0){
					var baseSelector = '#kreon-grid-' + gridSerialNo;
					var adjField = $(baseSelector + 'adjamount').length ? 'adjamount' : 'adjamt';
					var adjInput = $(baseSelector + adjField);
					var amount = parseInt($(baseSelector + 'amount').val()) || 0;
					var adjValue = adjInput.val() || 0;
					
					if (adjInput.val() !== '' && adjValue > 0) {
						$('#PopupBalance').val(amount - adjValue);
						$('#PopupAdjamount').val(adjValue);
					}else{
						$('#PopupBalance').val(parseInt($('#kreon-grid-'+gridSerialNo+'amount').val()) - 0);

					}

					// if($('#kreon-grid-'+gridSerialNo+'adjamount-text').val() != ''){
					// 	if($('#kreon-grid-'+gridSerialNo+'adjamount-text').val() > 0){
					// 		$('#PopupBalance').val(parseInt($('#kreon-grid-'+gridSerialNo+'amount').val()) - parseInt($('#kreon-grid-'+gridSerialNo+'adjamount-text').val()));
					// 		$('#PopupAdjamount').val(parseInt($('#kreon-grid-'+gridSerialNo+'adjamount-text').val()));
					// 	}
					// }else{
					// 	$('#PopupBalance').val(parseInt($('#kreon-grid-'+gridSerialNo+'amount').val()) - 0);

					// }

				}else{
					$('#PopupBalance').val(0);
				}

				// if($('#kreon-grid-aSingleDDModalAdjAmt').val() != ''){
				// 	$('#PopupAdjamount').val(parseInt($('#kreon-grid-aSingleDDModalAdjAmt').val()));
				// }
				$('#PopupGridId').val(GridID);

				//this code updated in loadData function
				// setTimeout(function() {
				// 	$('#myModal .modal-body').find('#dropdownContent tbody tr:first').find('input[name="adjamount"],input[name="adjamt"]').focus().select();
				// }, 500);

				// $("#pillContainer").hide();
				// $("#clearSelection").hide();
				$(".modal-footer").html("<p>Press Alt + K for Quick Adjustment</p>");
			}else{
				setTimeout(function() {
					$('.popup-search1').focus();
				}, 500);
				$("#pillContainer").show();

			}


		}

		//Select all checkbox
		$(document).on('change', '#selectAllFielType17Checkbox', function() {
			const isChecked = $(this).is(':checked');
			// $('.item-checkbox').prop('checked', isChecked);
			$('.item-checkbox').not(this).each(function() {
				$(this).prop('checked', isChecked);
				toggleSelection(this); 
			});
		});

		function isValidDate(dateString) {
			// Regular expression for a basic date format (YYYY-MM-DD)
			const regex = /^\d{4}-\d{2}-\d{2}$/;

			// Check if the date matches the basic format
			if (!dateString.match(regex)) {
				return false;
			}

			// Try to create a Date object from the string
			const date = new Date(dateString);

			// Check if the resulting Date object is valid
			return date instanceof Date && !isNaN(date.getTime());
		}

		function getRequestCondition(){
			// console.log("in getRequestCondition",ddResponseData['requestParams']);
			requestParams='';
			formReeponseString='';

			//Request parameters
			// if(ddResponseData['requestParams'] && ddResponseData['requestParams'] != null && ddResponseData['requestParams'].length > 1 ){
			if (ddResponseData && ddResponseData['requestParams'] && ddResponseData['requestParams'].length > 1){
				// Define the input string
				var inputString = ddResponseData['requestParams'];

				// Define the regular expression to match the desired patterns
				var regex = /([?#][^ \'\)\(\\"\\=]+)[ \'\)\(\\"\\=]/g;

				// Use match method to find all matches
				var matches = [];
				var match;
				while ((match = regex.exec(inputString)) !== null) {
					matches.push(match[1]);
				}
				var parameters = matches;
				var replaceString = '';
				
				for(var i=0; i<parameters.length; i++){
					replaceString='';
					if(parameters[i].indexOf("?") >= 0 || parameters[i].indexOf("#") >= 0){
						if(parameters[i].length > 1){
							// IF Grid fields
							if(parameters[i].indexOf("?") >= 0){
								var gridid = ddResponseData['PopulateGrid'].split(":");
								var gridIdentifier = $('#grid-id-'+gridid[1]).attr('class');		
								var gridSerialNo = gridIdentifier.slice(4);
								var qExtractedString = "kreon-grid-"+gridSerialNo +""+parameters[i].replace(/\?+/g, '');
							}

							// If form fields
							if(parameters[i].indexOf("#") >= 0){
								//If # found it remove
								var qExtractedString = parameters[i].replace(/\#+/g, '');
								
							}
							
							if(qExtractedString.length > 0){
								var NumberOfElements = document.querySelectorAll("[id="+qExtractedString+"]");
								if(NumberOfElements.length == 2){
									replaceString += $(NumberOfElements[1]).val() !="" ? $(NumberOfElements[1]).val().trim() : '0';
									replaceString += " ";
								}else{
									if(qExtractedString == 'userid'){
										replaceString += <?php echo $_SESSION['user_id']; ?> 
									}else if(qExtractedString == 'companyid'){
										replaceString += <?php echo $_SESSION['dbCompany']; ?> 
									}else if(qExtractedString == 'divisionid'){
										replaceString += <?php echo $_SESSION['dbDivision']; ?> 
									}else if(qExtractedString == 'yearcode'){
										replaceString += <?php echo $_SESSION['dbYear']; ?> 
									}else if(qExtractedString == 'formid'){
										replaceString += <?php echo $FormID; ?> 
									}else{
										console.log(qExtractedString +" == "+ $('#'+qExtractedString.trim()).val());
										//replaceString += $('#'+qExtractedString).val() !="" ? $('#'+qExtractedString).val().trim() : '0';
										// replaceString += ($('#' + qExtractedString).length > 0 && $('#' + qExtractedString).val() !== "") ? $('#' + qExtractedString).val().trim() : '0';
										var elem = $('#' + qExtractedString);
										replaceString += (elem.length > 0 && elem.val() && elem.val().trim() !== "") ? elem.val().trim() : '0';
										
									}
								}
							}
							// console.log("replaceString",replaceString,parameters[i])
							// inputString.replace(parameters[i], replaceString);
							inputString = inputString.replaceAll(parameters[i], replaceString);
							// inputString.split(parameters[i]).join(replaceString);
							// console.log("inputString", inputString);
						}
					}
				}
				requestParams = inputString;
			}
			
			
			//FormResponse parameters
			if(ddResponseData && ddResponseData['FormResponse'] && ddResponseData['FormResponse'].length > 1){
				var FormResponseArray=[];
				var FormResponseExtract = [];
				var FormResponseArray = ddResponseData['FormResponse'].split('|');
				var formResponseFieldText = "";
				var formResponseFieldValue = "";
				// console.log("FormResponse",ddResponseData['FormResponse']);
				for(var j=0; j<FormResponseArray.length; j++){
					FormResponseExtract = FormResponseArray[j].split(':');
					if(FormResponseExtract[2] == 17){					
						formResponseFieldValue = $('#'+FormResponseExtract[1].trim()).val();
						formResponseFieldText = $('#'+FormResponseExtract[1].trim()+"-text").val();

					}else if(FormResponseExtract[2] == 5){
						console.log(FormResponseExtract[1].trim() +" == "+ $('#'+FormResponseExtract[1].trim()).val());
					
						formResponseFieldValue = $('select#'+FormResponseExtract[1].trim()).val();
						formResponseFieldText = $('select#'+FormResponseExtract[1].trim()).find('option:selected').text();
					
					}else{
						formResponseFieldValue = $('#'+FormResponseExtract[1].trim()).val();
					}
					
					formReeponseString += FormResponseExtract[0]+":"+formResponseFieldValue;
	
					
					if(formResponseFieldText.length > 0){
						formReeponseString += ":"+formResponseFieldText;
					}

					if(j != FormResponseArray.length-1){
						formReeponseString += " | ";
					}
				}
				console.log("formReeponseString "+formReeponseString);
			}
			console.log("IN getRequestCondition call");
		}

		function closeModal() {

			//Populate Grid on row selection
			if(ddResponseSytemType == 1){
				// console.log("in close modal",ddResponseData['gridResponseParams']);
				if(ddResponseData['gridResponseParams'] != null && ddResponseData['gridResponseParams'].length > 1 && ddResponseData['PopulateGrid'] != null && ddResponseData['PopulateGrid'].length > 1 ){
					// getRequestCondition();
					var selectedItems = ddSelectedItemsValue.toString();
					if(selectedItems.length > 0){
						console.log("in gridResponseParams "+formReeponseString);
						AddResultInGrid(ddRowSelectType,selectedItems,ddDBFieldType,triggeringButtonId,ddisGrid,requestParams,formReeponseString);
					}
				}
				
			}else{
				if($('#myModal').find('.modal-body').find('#error').length == 0){
					var selectedItems = ddSelectedItemsValue.toString();
					if(selectedItems.length > 0){
						try{
							// Making AJAX call with async/await
							$.ajax({
								type : 'POST',
								dataType: 'json',
								data : {selectedItems : selectedItems, FormID : <?php echo $FormID; ?>, DBFieldName: triggeringButtonId, GridID: GridID},
								url : 'getPopulateGridData.php',
								success : function(result){
									console.log("results",result);
									if (result['success'] == false) {
										alert(result['error']);
										return;
									}else{

										AddNewResultInGrid(result['data'], result['gridData'], result['gridResponse'], result['selecedRowIdName'], result['DynamicGridInsertFirstRowEdit'],result['formResponse']);
									}
								}
							});
						} catch (error) {
							console.error('Error:', error);
						}
					}
				}
			}

			$('#myModal').modal('hide');
			setTimeout(function() {
				if ($(".modal-backdrop").length > 0) {
					$(".modal-backdrop").remove();
				}
			}, 50); // Adjust delay as needed

			$(".popup-search1").val('');
			// for(var j=0; j<ddResponseData['columns'].length; j++){
			// 	$("#"+ddResponseData['columns'][j]['name']).val('');
			// }
		}

		async function AddNewResultInGrid(data, gridData, gridResponse, selecedRowIdName, DynamicGridInsertFirstRowEdit,formResponse){
			// console.log("AddNewResultInGrid",formResponse);
			var OnkeyupParameterCalculation = [];
			var gridCalculationFieldName = [];
			var gridCalculationType = [];

			for (var t = 0; t < gridData.length; t++) {
				if (gridData[t]['gridcalculation'] > 0) {
					gridCalculationFieldName.push(gridData[t]['dbfieldname']);
					gridCalculationType.push(gridData[t]['gridcalculation']);
				}
				if (gridData[t]['onkeyupparameters'] && gridData[t]['onkeyupparameters'].length > 2) {
					if (gridData[t]['fieldtype'] != 5) {
						OnkeyupParameterCalculation.push([gridData[t]['dbfieldname'], gridData[t]['fieldtype'], gridData[t]['onkeyupparameters']]);
					}
				}
			}

			if (Array.isArray(data)) {
				console.log("Data is an array:", data);
				var promises = [];
				var flag = 0;

				for (var l = 0; l < data.length; l++) {
					for (var t = 0; t < gridData.length; t++) {
						if (gridData[t]['required'] == 1) {
							var fldvalue = data[l][gridData[t]['dbfieldname']];
							if (fldvalue == "" || fldvalue == 0 || fldvalue == null) {
								flag = 1;
								alert(gridData[t]['displayname'] + " is required");
								if (DBFieldType == 17) {
									$('#' + DBFieldName +'-text').val("");
									$('#' + DBFieldName).val("");
								} else if (DBFieldType == 16) {
									$('#' + DBFieldName+'-text').val("");
									$('#' + DBFieldName).val("");
								}
								$('#DropDownModal').modal('hide');
								return;
							}
						}
					}

					if (flag == 0) {
						// Split the string based on the delimiter "|", or any suitable pattern
						// console.log("splitString",gridResponse);
						if (gridResponse && typeof gridResponse === "string") {
							var splitString = gridResponse.split(" | "); // splitting by " | " ensures each segment is separated
							// Loop through the array of strings
							for (var i = 0; i < splitString.length; i++) {
								var PopulateFieldInGrids = splitString[i];
								console.log(PopulateFieldInGrids);
								// Regular expression to split the string
								var regex = /(\d+)\((.*)\)/;

								// Apply the regular expression to the string
								var match = PopulateFieldInGrids.match(regex);

								if (match) {
									// Dynamically extracting the two parts
									var gridid = match[1]; // This will be "2302"
									var GridResponseString = match[2]; // This will be "gfld1:bname:1|gfld7:cntl:7"						
								}

								var gridIdentifier = $('#grid-id-' + gridid).attr('class');
								var gridSerialNo = gridIdentifier.slice(4);
								var gridResponseArray = GridResponseString.split("|");
								console.log("gridResponseArray");
								console.log(gridResponseArray);
								for (var k = 0; k < gridResponseArray.length; k++) {
									gridRes = gridResponseArray[k].split(":");

									// console.log(gridSelect2Fields);
									
									if (gridRes[2] == '1' || gridRes[2] == '7') {
										console.log("fieldtype 7 ",gridRes[0],data[l][gridRes[1]],'#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim());
										console.log(gridRes);
										$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(data[l][gridRes[1].trim()]);
										
										// Call function for grid calculation
										for (var m = 0; m < OnkeyupParameterCalculation.length; m++) {
											if (OnkeyupParameterCalculation[m] != undefined) {
												if (OnkeyupParameterCalculation[m].includes(gridRes[0].trim()) == true) {
													promises.push(CreateOnkeyupScriptGrid("kreon-grid-" + gridSerialNo + "" + gridRes[0].trim(), 'grid', 'dynamic'));
												}
											}
										}
									} else if (gridRes[2] == '5' || gridRes[2] == '19') {
										if (data[l][gridRes[1]] != undefined) {
											var newOptionValue = data[l][gridRes[1].trim()+'id'] === null ? 0 : data[l][gridRes[1].trim()+'id'];
											var $newOption = $("<option selected=\"selected\"></option>").val(newOptionValue).text(data[l][gridRes[1].trim()]);
											if ($('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).data('select2')) {
												// $('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).select2('open');
												$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).append($newOption);
												// $('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).select2('close');
											} else {
												$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).append($newOption);
											}
										}
									} else if (gridRes[2].trim() == '17' || gridRes[2].trim() == '16') {
										$('#kreon-grid-' + gridSerialNo + gridRes[0].trim() + '-text').val(data[l][gridRes[1].trim()]);
										$('#kreon-grid-' + gridSerialNo + gridRes[0].trim()).val(data[l][gridRes[3]]);
										
									}

								}

								
								//Add form field value in grid using formResponse
								if (formResponse != null && formResponse.length > 0) {
									formResponseArray = formResponse.split("|");
									for (var n = 0; n < formResponseArray.length; n++) {
										formRes = formResponseArray[n].split(":");
										if (formRes[2].trim() == '1' || formRes[2].trim() == '3' || formRes[2].trim() == '6' || formRes[2].trim() == '7' || formRes[2].trim() == '8') {
											
											$('#kreon-grid-' + gridSerialNo + '' + formRes[0].trim()).val($('#'+formRes[1].trim()).val());
										} else if (formRes[2].trim() == '5' || formRes[2].trim() == '19') {
											var $newOption = $("<option selected=\"selected\"></option>").val($('#'+formRes[1].trim()).val()).text(formRes[3]);
											// $('#kreon-grid-' + gridSerialNo + '' + formRes[0]).select2('open');
											$('#kreon-grid-' + gridSerialNo + '' + formRes[0]).append($newOption).trigger("change");
											// $('#kreon-grid-' + gridSerialNo + '' + formRes[0]).select2('close');
										} else if (formRes[2].trim() == '17' || formRes[2].trim() == '16') {
											$('#kreon-grid-' + gridSerialNo + formRes[0].trim() + '-text').val($('#'+formRes[3].trim()).val());
											$('#kreon-grid-' + gridSerialNo + formRes[0].trim()).val($('#'+formRes[1].trim()).val());
										}
									}
								}

								// Add new row and add the promise to the array
								promises.push(AddNewRow($(this), gridData, gridSerialNo, data[l][selecedRowIdName], DynamicGridInsertFirstRowEdit));
							}
						}
					}

					// Wait for all promises to finish before moving forward
					await Promise.all(promises);

					// Once the new row is added, perform calculations
					await CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType, gridSerialNo );

					// $('#DropDownModal').modal('hide');
					$('#myModal').modal('hide');
					setTimeout(function() {
						if ($(".modal-backdrop").length > 0) {
							$(".modal-backdrop").remove();
						}
					}, 50); // Adjust delay as needed
					// $(".modal-backdrop").remove(); // Removes the backdrop

				}
			}
		}

		function validateRequiredFields(requiredFieldsStr) {
			var RequiredFieldsArray = Array.isArray(requiredFieldsStr)
				? requiredFieldsStr
				: requiredFieldsStr.split('|');
		
			for (var k = 0; k < RequiredFieldsArray.length; k++) {
				var RequiredFieldValue = $("#" + RequiredFieldsArray[k].trim()).val();
				if (RequiredFieldValue === "" || RequiredFieldValue == 0) {
					$("#ValidationMessage").show();
					$('#ValidationMessage').html(
						'<span style="color: red;">' + RequiredFieldsArray[k] + ' field is required.</span>'
					);
					return false;
				}
			}

			$("#ValidationMessage").hide();
			$('#ValidationMessage').html('');
			return true;
		}


		async function fetchTableData(DBFieldName) {
			let passedValidation = false;
			await $.ajax({
				url: 'getMultyDDValue1.php',
				method: 'GET',
				dataType: 'json',
				data: {
					FormID: <?php echo $FormID; ?>,
					GridID: GridID,
					DBFieldName: DBFieldName,
					DBFieldType: ddDBFieldType,
					isGrid: ddisGrid
				},
				success: function(response) {
					ddResponseData = response;
					// If validation passed
					passedValidation = true;

					var shouldContinue = true;
					if (ddResponseData['RequiredFields'] && ddResponseData['RequiredFields'].length > 2) {
						shouldContinue = validateRequiredFields(ddResponseData['RequiredFields']);
					}
					
					if (!shouldContinue) {
						console.log("shouldContinue",shouldContinue);
						passedValidation = false; //Don't continue
						return;  // Exit before loading data or headers
					}

					
					// ✅ Only called when validation passes
					if(passedValidation){
						var columns = response['columns'];
						let headerHtml = '';
						for (let i = 0; i < columns.length; i++) {
							var column = columns[i];
							if (i == 0) {
								if(ddResponseData['SelectAllCheckbox'] == 'enable'){
									headerHtml += `<th><input type="checkbox" id="selectAllFielType17Checkbox" class="item-checkbox" ></th>`;
								}else{
									headerHtml += `<th></th>`;
								}
							} else {
								headerHtml += `<th>
									${column['name'].charAt(0).toUpperCase() + column['name'].slice(1)}<br>
									<input type="search" class="search-column form-control popup-search${i}"  id="populate_search_${column['name']}" placeholder="Search ${column['name']}" data-column="${i}">
								</th>`;
							}
						}
			
						$("#tableHeader").empty();
						$("#tableHeader").append(`${headerHtml}`);
						console.log("Loading data.......");
						if(ddResponseData && ddResponseData['AdjustableAmount'] == 'enable' || ddResponseData && ddResponseData['adjamount'] == 'enable'){
							$('#myModal .modal-body').css({
								'overflow-y': 'visible',
								'max-height': 'none'
							});

							$('#myModal .dropdown-content thead').css({
								'position': 'sticky',
								'top': '152px',      /* Height of modal-header */
								'z-index': '50',
								'background-color': '#f4f4f4'
							});
						}else{
							$('#myModal .modal-body').css({
								'overflow-y': 'auto',
								'max-height': 'calc(100vh - 150px)'
							});

							$('#myModal .dropdown-content thead').css({
								'position': 'sticky',
								'top': '-15px',      /* Height of modal-header */
								'z-index': '50',
								'background-color': '#f4f4f4'
							});

						}
						loadData(DBFieldName);
					}

					// return passedValidation;
				},
				error: function() {
					alert('Failed to load data');
				}
			});
		}

		window.ddRowDataMap = {};

		function loadData(DBFieldName) {
			if (!hasMoreData) return; 	//stop extra calls
			getRequestCondition();
			

			// if (startIndex >= data.length) return;  // If all data is already loaded, stop loading more
			$("#loadingMessage").show();

			// Show loading spinner inside the table
			$("#loadingData").show();

			var globalValue = $("#globalSearch").val().toLowerCase();

			var columnFilters = $(".search-column").map(function() {
				const column = $(this).attr("id");
				const columnValue = $(this).val().toLowerCase();
				return { column, columnValue };
			}).get();

			// Create a custom string, for example: "column1:value1, column2:value2"
			var columnFiltersString = columnFilters
				.map(function(filter) {
					if (filter.columnValue) {
						return filter.column + ":" + filter.columnValue;
					}
				})
				.filter(function(item) {
					return item !== undefined;
				})
				.join("|");

			if(ddResponseData && ddResponseData['AdjustableAmount'] == 'enable' || ddResponseData && ddResponseData['adjamount'] == 'enable'){
				startIndex = 0;
				itemsPerPage = 0;
			}
			
			$.ajax({
				url: 'getFieldType17Data.php', // Replace with your server endpoint
				method: 'POST',
				dataType: 'json',
				data: { start: startIndex, limit: itemsPerPage, DBFieldName: DBFieldName, FormID: <?php echo $FormID; ?>, GridID:GridID, isGrid:ddisGrid, DBFieldType:ddDBFieldType, GlobalSearch: globalValue, ColumnFilters: columnFiltersString, requestParams: requestParams, formData: $('form').serialize()},
				success: function(response) {
					// Hide loading spinner when data is loaded
					$("#loadingData").hide();
					console.log("inside ajax",startIndex);

					var columns = ddResponseData['columns'];
					
					var rows = response['data']; // Adjust this based on your server response format
					var ddTbody = $("#dropdownItems");

					// If there are no rows, show the "No data found" message
					if (!Array.isArray(rows) || rows.length === 0) {
						// Only show "No data found" message if it isn't already visible
						hasMoreData = false; //stop future loads
						if (!ddTbody.find('.no-data-row').length) {
							ddTbody.append('<tr class="no-data-row"><td colspan="' + columns.length + '" class="text-center"><center>No data found</center></td></tr>');
						}
						isKreonFT17_CallNextIndex = false;
						$("#loadingMessage").hide();
						return;
					}

					

					// Ensure 'columns' is defined and contains the expected structure
					if (!columns || columns.length === 0) {
						console.error("Columns are not defined properly.");
						return;
					}
					console.log(rows);
					var rowHtml;
					rows.forEach(row => {
						rowHtml = `<tr data-id="${row[columns[0]['name']]}">`;
						columns.forEach(column => {
							const columnName = column['name'];
							if (columnName in row) {
								if (columnName.trim() === columns[0]['name'].trim()) {
									// Check if the value is in ddSelectedItemsValue
									// var isChecked = ddSelectedItemsValue.includes((row[columnName].toString()));
									var isChecked = row[columnName] !== null && row[columnName] !== undefined && ddSelectedItemsValue.includes(row[columnName].toString());
									// const isChecked = ddSelectedItemsValue.includes(parseInt(row[columnName]));
									rowHtml += `<td><input type="checkbox" id="checkbox" class="item-checkbox" value="${row[columnName]}" onclick="toggleSelection(this)" ${isChecked ? 'checked' : ''}></td>`;

									//`<td><input type="hidden" value="${row[columnName]}"></td>`;
									//<input type="checkbox" class="item-checkbox" value="${row[columnName]}" onclick="toggleSelection(this)">
								} else {
									if(row[columnName] && row[columnName].date){
										rowHtml += `<td>${row[columnName].date}</td>`;
									}else{
										rowHtml += `<td>${row[columnName]}</td>`;
									}
								}
							}
						});
						rowHtml += `</tr>`;
						// console.log(rowHtml);
						ddTbody.append(rowHtml);

						// ✅ ✅ ✅ Store full row in global map for pill reference
						if (!window.ddRowDataMap) window.ddRowDataMap = {};
						let rowCopy = {};
						columns.forEach(col => {
							const key = col['name'];
							let value = row[key];

							// If value contains an input tag, extract its value using regex
							if (typeof value === 'string' && value.includes('<input')) {
								let match = value.match(/value=["']([^"']*)["']/);
								if (match && match[1] !== undefined) {
									value = match[1];
								}
							}

							rowCopy[key] = value;
						});

						// Save clean copy to global map
						window.ddRowDataMap[row[columns[0]['name']]] = rowCopy;

						if(ddResponseData['AdjustableAmount'] == 'enable' || ddResponseData['adjamount'] == 'enable'){
							
							if ($("#pillContainer").length && $("#pillContainer > div[id^='pill-']").length) {
								// Object to store all pill data
								var pillsData = {};

								// Loop through all pills inside #pillContainer
								$("#pillContainer > div[id^='pill-']").each(function() {
									var pillId = $(this).attr("id"); // e.g., "pill-123"
									var rowID = pillId.replace("pill-", ""); // Extract numeric ID

									var amountText = $(this).find(".pill-label").text().trim();
									var adjAmount = amountText.replace(/X$/, '').trim(); // Remove trailing 'X'

									pillsData[rowID] = adjAmount;
								});

								console.log("Pills Data:", pillsData);
								// Apply values to the table rows
								applyPillsToTable(pillsData);
							}

							//In edit mode against adjusted amount add pill
							$("#ddTable tbody tr").each(function () {
								let row = $(this);
								let adjInput = row.find('input[name="adjamount"], input[name="adjamt"]');
								let rowID = row.find("td:first input").val(); // assumes first column has ID

								let val = parseFloat(adjInput.val()) || 0;

								if (val > 0 && $("#pill-" + rowID).length === 0) {
									// Create pill if not already exists
									$('#pillContainer').css('display', 'block');
									$("#pillContainer").append(
										"<div id='pill-" + rowID + "' class='me-2 d-inline-block'>" +
											"<div class='pill-label btn-primary'>" +
												val + "&nbsp;" +
												"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>" +
											"</div>" +
										"</div>"
									);
								}
							});
						}
					});

					var hiddenColumns = [];

					if(ddResponseData['AdjustableAmount'] == 'enable' || ddResponseData['adjamount'] == 'enable'){
						if(ddResponseData['hiddenColumns'] != null && ddResponseData['hiddenColumns'] != ""){
							var hiddenColumns = ddResponseData['hiddenColumns'].split(',');

							if(hiddenColumns.length > 0){
								var headers = $('#tableHeader th');
								var rows = $("#dropdownItems tr");
								// console.log(rows);
								// Convert jQuery object to a plain array
								Array.from(headers).forEach(function(header, colIndex) {
									if (hiddenColumns.includes(header.innerText.trim())) {
										// Hide the column header (th)
										header.classList.add('hidden');
										
										// Loop through each row and hide the cell in the hidden column
										rows.each(function(index,row) {
											// Check if the row has enough cells
											if (row.cells.length > colIndex) {
												row.cells[colIndex].classList.add('hidden');
												
											} 
											else {
												// console.log("Row does not have enough cells: ", row);
											}
										});
									}
								});
							}
						}
						$('#myModal .modal-body').find('#dropdownContent tbody tr:first').find('input[name="adjamount"],input[name="adjamt"]').focus().select();
					}else{
						
						//logic for hide columns & add data as data-key attribute in previous row if hidden columns are present & field type is 5,19,16 & 17
						if(ddResponseData['hiddenColumns'] != null && ddResponseData['hiddenColumns'] != ""){
							var hiddenColumns = ddResponseData['hiddenColumns'].split(',');
	
							if(hiddenColumns.length > 0){
								console.log("else");
								var headers = $('#tableHeader th');
								var rows = $("#dropdownItems tr");
								// console.log(rows);
								// Convert jQuery object to a plain array
								Array.from(headers).forEach(function(header, colIndex) {
									if (hiddenColumns.includes(header.innerText.trim())) {
										// console.log("header",header);
										// Hide the column header (th)
										header.classList.add('hidden');
										
										// Loop through each row and hide the cell in the hidden column
										rows.each(function(index,row) {
											// Check if the row has enough cells
											if (row.cells.length > colIndex) {
												row.cells[colIndex].classList.add('hidden');
												// console.log("row cells",row.cells[colIndex]);
												// Add the hidden column's data to the previous cell's data-key attribute
												if (colIndex > 0) {  // Make sure there's a previous column to attach the data to
													var previousCell = row.cells[colIndex - 1];
													previousCell.setAttribute('data-key', row.cells[colIndex].innerText);
												}
												// row.cells[colIndex].remove();
											} 
											
										});
									}
								});
							}



						}
					}
					
					startIndex += itemsPerPage;
					isKreonFT17_CallNextIndex = false;
					// console.log("after startindex increement",startIndex);
					$("#loadingMessage").hide();
					// generateFooter();  // Re-generate the footer after data load
					
				},
				error: function(xhr, status, error) {
					console.error('Failed to load data:', error);
					$("#loadingMessage").hide();
				}
			});
			
			
			// startIndex += itemsPerPage;
			$("#loadingMessage").hide();
			
		}

		function applyPillsToTable(pillsData) {
			if (!pillsData || typeof pillsData !== 'object') return;

			// Loop through all rows in #ddTable
			$("#ddTable tbody tr").each(function () {
				var row = $(this);
				var rowID = row.find("td:first input[type='checkbox']").val();

				if (pillsData.hasOwnProperty(rowID)) {
					var adjInput = row.find("input[name='adjamount']");
					if (adjInput.length) {
						adjInput.val(pillsData[rowID]); // Set the value from pillsData
					}
				}
			});
		}

		function applyPillsToBankRecoTable(pillsData) {
			if (!pillsData || typeof pillsData !== 'object') return;

			// Loop through all rows in #ddTable
			$("#ddTable tbody tr").each(function () {
				var row = $(this);
				// var rowID = row.find("td:first input").val();
				var rowID = row.data("id"); // ✅ use data-id

				// if (pillsData.hasOwnProperty(rowID)) {
				// 	var clearDtInput = row.find("input[name='cleardt']");
				// 	if (clearDtInput.length) {
				// 		clearDtInput.val(pillsData[rowID]); // Set the value from pillsData
				// 	}
				// }

				// if (pillsData.hasOwnProperty(rowID)) {
				// 	var pillData = pillsData[rowID];
				// 	console.log(pillData,pillData.date);
				// 	var clearDtInput = row.find("input[name='cleardt']");
				// 	console.log("clearDtInput",clearDtInput,clearDtInput.length);
				// 	if (clearDtInput.length) {
				// 		clearDtInput.val(pillData.date || ""); // restore date
				// 	}
				// }

				if (pillsData.hasOwnProperty(rowID)) {
					var pillData = pillsData[rowID];
					console.log("Pill Data for", rowID, pillData);

					var clearDtInput = row.find("input[name='cleardt[]']"); // ✅ exact match
					console.log("clearDtInput", clearDtInput, clearDtInput.length);

					if (clearDtInput.length) {
						clearDtInput.val(pillData.date || ""); // restore date
					}
				}
			});
		}

		async function loadHeaderData(DBFieldName) {
			// getRequestCondition();

			// if (startIndex >= data.length) return;  // If all data is already loaded, stop loading more
			$("#loadingMessage").show();

			var globalValue = $("#globalSearch").val().toLowerCase();

			var columnFilters = $(".search-column").map(function() {
				const column = $(this).attr("id");
				const columnValue = $(this).val().toLowerCase();
				return { column, columnValue };
			}).get();

			// Create a custom string, for example: "column1:value1, column2:value2"
			var columnFiltersString = columnFilters
				.map(function(filter) {
					if (filter.columnValue) {
						return filter.column + ":" + filter.columnValue;
					}
				})
				.filter(function(item) {
					return item !== undefined;
				})
				.join("|");

			await $.ajax({
				url: 'getNewFieldType17Data.php', // Replace with your server endpoint
				method: 'POST',
				dataType: 'json',
				data: { start: startIndex, limit: itemsPerPage, DBFieldName: DBFieldName, FormID: <?php echo $FormID; ?>, GridID:GridID, isGrid:ddisGrid, DBFieldType:ddDBFieldType, GlobalSearch: globalValue, ColumnFilters: columnFiltersString, requestParams: requestParams, formData: $('form').serialize()},
				success: function(response) {

					if (response['success'] == false) {
						$('#myModal').find('.modal-body').html('<p id=\'error\' style=\'color:red;\'>'+response['error']+'</p>');
						callback(false); // Callback with false
					}else{
						
						responseHeaders = Object.keys(response['data'][0]);

						//define ddResponseTotalColumnIndex globally for accessing in toggleSelection function 
						var TotalColumnNameArray = response['totalcolumnname'].split('|');
						for(var j=0; j<TotalColumnNameArray.length; j++){
							var index = responseHeaders.indexOf(TotalColumnNameArray[j]);
							ddResponseTotalColumnIndex.push(index);
						}

						//define ddResponsePopulateFields globally for accessing in toggleSelection function 
						ddResponsePopulateFields = response['PopulateFields'];

						//define ddResponsePopulateFields globally for accessing in toggleSelection function 
						ddResponsePopulateFieldInGrids = response['PopulateFieldInGrid'];

						//define ddResponsePopulateGrid globally for accessing in toggleSelection function
						ddResponsePopulateGrid = response['PopulateGrid'];

						//define ddResponseHiddenColumns globally for accessing in toggleSelection function
						ddResponsePopulateGrid = response['PopulateGrid'];

						// ddResponseData = response['FormResponse'];
						
						ddResponseData['AdjustableAmount'] = response['AdjustableAmount'];

						// Load the table headers
						let headerHtml = '';

						// Iterate over each key-value pair in the current object
						for (var i=0; i<responseHeaders.length; i++) {
							if(i==0){
								headerHtml += `<th></th>`;
							}else{
								headerHtml += `<th>
									${responseHeaders[i].charAt(0).toUpperCase() + responseHeaders[i].slice(1)}<br>
									<input type="search" class="search-column form-control popup-search${i}"  id="populate_search_${responseHeaders[i]}" placeholder="Search ${responseHeaders[i]}" data-column="${i}">
								</th>`
							}
						}
		
						$("#tableHeader").empty();  // Clear existing rows
						$("#tableHeader").append(`${headerHtml}`);
						// console.log(responseHeaders[0]);
						var ddTbody = $("#dropdownItems");
						var rowHtml;
						response['data'].forEach((row, rowIndex )=> {
							rowHtml = `<tr>`;
							responseHeaders.forEach((column, columnIndex)=> {
								const columnName = column;
								if (columnName in row) {
									if (columnName.trim() === responseHeaders[0]) {
										// Check if the value is in ddSelectedItemsValue
										var isChecked = ddSelectedItemsValue.includes((row[columnName].toString()));
										// const isChecked = ddSelectedItemsValue.includes(parseInt(row[columnName]));
										rowHtml += `<td><input type="checkbox" id="checkbox" class="item-checkbox" value="${row[columnName]}" onclick="toggleSelection(this)" ${isChecked ? 'checked' : ''}></td>`;

										//`<td><input type="hidden" value="${row[columnName]}"></td>`;
										//<input type="checkbox" class="item-checkbox" value="${row[columnName]}" onclick="toggleSelection(this)">
									} else {
										if(row[columnName] && row[columnName].date){
											rowHtml += `<td>${row[columnName].date}</td>`;
										}else{
											rowHtml += `<td>${row[columnName]}</td>`;
										}
									}
								}
							});
							rowHtml += `</tr>`;
							// console.log(rowHtml);
							ddTbody.append(rowHtml);
						});

						var rowHtml;
						// console.log('hi');
						var hiddenColumns = [];
						//logic for hide columns & add data as data-key attribute in previous row if hidden columns are present & field type is 5,19,16 & 17
						if(response['hiddenColumns'] != null && response['hiddenColumns'] != ""){
							// console.log("in");
							
							var hiddenColumns = response['hiddenColumns'].split(',');

							// Capitalize the first letter of each column name
							hiddenColumns = hiddenColumns.map(function(column) {
								return column.charAt(0).toUpperCase() + column.slice(1);
							});
						
							if(hiddenColumns.length > 0){
								var headers = $('#tableHeader th');
								var rows = $("#dropdownItems tr");
								// console.log(headers);
								
								// Convert jQuery object to a plain array
								Array.from(headers).forEach(function(header, colIndex) {
									if (header.innerText.trim() !== "" && hiddenColumns.includes(header.innerText.trim())) {
										// Hide the column header (th)
										header.classList.add('hidden');
										
										// Loop through each row and hide the cell in the hidden column
										rows.each(function(index,row) {
											// Check if the row has enough cells
											if (row.cells.length > colIndex) {
												row.cells[colIndex].classList.add('hidden');
												
												// Add the hidden column's data to the previous cell's data-key attribute
												if (colIndex > 0) {  // Make sure there's a previous column to attach the data to
													var previousCell = row.cells[colIndex - 1];
													previousCell.setAttribute('data-key', row.cells[colIndex].innerText);
												}
											} 
											else {
												// console.log("Row does not have enough cells: ", row);
											}
										});
									}
								});
							}
						}
						
						// generateFooter();  // Re-generate the footer after data load
					}
				},
				error: function(xhr, status, error) {
					console.error('Failed to load data:', error);
					$("#loadingMessage").hide();
				}
			});

			startIndex += itemsPerPage;
			$("#loadingMessage").hide();
		}

		window.bankRecoRowDataMap = {};
		async function loadBankRecoData(DBFieldName) {
			// alert(DBFieldName);
			// getRequestCondition();

			// if (startIndex >= data.length) return;  // If all data is already loaded, stop loading more
			$("#loadingMessage").show();

			var globalValue = $("#globalSearch").val().toLowerCase();

			// Store current column search values before refresh
			const searchValuesMap = {};
			$(".search-column").each(function () {
				const columnId = $(this).attr("id");
				const columnValue = $(this).val();
				searchValuesMap[columnId] = columnValue;
			});

			var columnFilters = $(".search-column").map(function() {
				const column = $(this).attr("id");
				const columnValue = $(this).val().toLowerCase();
				return { column, columnValue };
			}).get();

			// Create a custom string, for example: "column1:value1, column2:value2"
			var columnFiltersString = columnFilters
				.map(function(filter) {
					if (filter.columnValue) {
						return filter.column + ":" + filter.columnValue;
					}
				})
				.filter(function(item) {
					return item !== undefined;
				})
				.join("|");

			var bankRecoFlag = '';
			if(DBFieldName == 'bankreco'){
				bankRecoFlag = 'uncleared';
			}else if(DBFieldName == 'bankreco1'){
				bankRecoFlag = 'cleared';
			}else if(DBFieldName == 'bankrecoexport'){
				bankRecoFlag = 'export';
			}

			await $.ajax({
				url: 'getBankRecoData.php', // Replace with your server endpoint
				method: 'POST',
				dataType: 'json',
				data: { start: startIndex, limit: itemsPerPage, DBFieldName: DBFieldName, FormID: <?php echo $FormID; ?>, GridID:GridID, isGrid:ddisGrid, DBFieldType:ddDBFieldType, GlobalSearch: globalValue, ColumnFilters: columnFiltersString, requestParams: requestParams, formData: $('form').serialize(), bankRecoFlag:bankRecoFlag},
				success: function(response) {

					if (response['success'] == false) {
						$('#myModal').find('.modal-body').html('<p id=\'error\' style=\'color:red;\'>'+response['error']+'</p>');
						callback(false); // Callback with false
					}else{
						if(DBFieldName == 'bankrecoexport'){
							if(response){
								generateExcelFromJson(response,filename='Bank_Reconsilation')
							}
						}else{

							// If no rows, stop here (adjamount only)
							if (!response['data'] || response['data'].length === 0) {
								let colspan = responseHeaders.length || 1;
								$("#dropdownItems").append(
									`<tr><td colspan="${colspan}" class="text-center text-muted"><center>No record found</center></td></tr>`
								);
								return;
							}

							responseHeaders = Object.keys(response['data'][0]);

							// Load the table headers
							let headerHtml = '';

							$('#PopupAdjamount').val(response['adjamount']);

							if(parseFloat(response['adjamount']) > 0){
								$("#PopupAdjamountSign").text('Dr');
							}else if(parseFloat(response['adjamount']) < 0){
								$("#PopupAdjamountSign").text('Cr');
							}

							// Iterate over each key-value pair in the current object
							for (var i=0; i<responseHeaders.length; i++) {
								if(i==0){
									headerHtml += `<th></th>`;
								}else{
									headerHtml += `<th>
										
										${responseHeaders[i].charAt(0).toUpperCase() + responseHeaders[i].slice(1)}<br>
										<input type="search" class="search-column form-control popup-search${i}"  id="${responseHeaders[i]}" placeholder="Search ${responseHeaders[i]}" data-column="${i}">

									</th>`
								}
							}
			
							if ($("#tableHeader th").length === 0){

								$("#tableHeader").empty();  // Clear existing rows
								$("#tableHeader").append(`${headerHtml}`);
							}
							// 🔁 Restore previous search values
							setTimeout(() => {
								$(".search-column").each(function () {
									const columnId = $(this).attr("id");
									if (searchValuesMap[columnId]) {
										$(this).val(searchValuesMap[columnId]);
									}
								});
							}, 0);
							
							console.log("responseHeaders",responseHeaders);
							var ddTbody = $("#dropdownItems");
							var rowHtml;
							response['data'].forEach((row, rowIndex )=> {
								console.log("row",row);
								rowHtml = `<tr data-id="${row[responseHeaders[0]]}">`;
								responseHeaders.forEach((column, columnIndex)=> {
									const columnName = column;
									if (columnName in row) {
										if (columnName.trim() === responseHeaders[0]) {
											// Check if the value is in ddSelectedItemsValue
											// var isChecked = ddSelectedItemsValue.includes((row[columnName].toString()));
											// const isChecked = ddSelectedItemsValue.includes(parseInt(row[columnName]));
											rowHtml += `<td><input type="hidden" value="${row[columnName]}"></td>`;

											//`<td><input type="hidden" value="${row[columnName]}"></td>`;
											//<input type="checkbox" class="item-checkbox" value="${row[columnName]}" onclick="toggleSelection(this)">
										} else {
											if(row[columnName] && row[columnName].date){
												rowHtml += `<td>${row[columnName].date}</td>`;
											}else{
												rowHtml += `<td>${row[columnName]}</td>`;
											}
										}
									}
								});
								rowHtml += `</tr>`;
								// console.log(rowHtml);
								ddTbody.append(rowHtml);
								

								let rowCopy = {};
								responseHeaders.forEach(col => {
									const key = col;
									let value = row[key];

									// Extract from input tag if present
									if (typeof value === 'string' && value.includes('<input')) {
										let match = value.match(/value=["']([^"']*)["']/);
										if (match && match[1] !== undefined) {
											value = match[1];
										}
									}

									rowCopy[key] = value;
								});

								// Use first column value (hidden input) as key, just like earlier
								const rowIDKey = row[responseHeaders[0]];
								window.bankRecoRowDataMap[rowIDKey] = rowCopy;
								

								if ($("#pillContainer").length && $("#pillContainer > div[id^='pill-']").length) {
									// Object to store all pill data
									var pillsData = {};
									// Loop through all pills inside #pillContainer
									$("#pillContainer > div[id^='pill-']").each(function() {
										var pillId = $(this).attr("id"); // e.g., "pill-123"
										var rowID = pillId.replace("pill-", ""); // Extract numeric ID

										var amountText = $(this).find(".pill-label").text().trim();
										var adjAmount = amountText.replace(/X$/, '').trim(); // Remove trailing 'X'
										var dateVal = $(this).attr("data-date");

										pillsData[rowID] = {
											adjAmount: adjAmount,
											date: dateVal
										};
									});
									// Apply values to the table rows
									applyPillsToBankRecoTable(pillsData);
								}

								//In edit mode against adjusted amount add pill
								$("#ddTable tbody tr").each(function () {
									let row = $(this);
									let clearDtInput = row.find('input[name="cleardt"], input[name="cleardt"]');
									let rowID = row.find("td:first input").val(); // assumes first column has ID

									let val = parseFloat(clearDtInput.val()) || '';

									if (val > 0 && $("#pill-" + rowID).length === 0) {
										// Create pill if not already exists
										$('#pillContainer').css('display', 'block');
										$("#pillContainer").append(
											"<div id='pill-" + rowID + "' class='me-2 d-inline-block'>" +
												"<div class='pill-label btn-primary'>" +
													val + "&nbsp;" +
													"<span onclick='deselectRow(" + rowID + ")' class='pill-remove bg-danger'>X</span>" +
												"</div>" +
											"</div>"
										);
									}
								});

							});

							//Added to correctly calculate the clear balance on filter.
							if ($("#pillContainer").length && $("#pillContainer > div[id^='pill-']").length) {
								// Object to store all pill data
								var adjustedAmount = 0;
								var previousAdjustedAmount = parseFloat($('#PopupAdjamount').val());
								// Loop through all pills inside #pillContainer
								$("#pillContainer > div[id^='pill-']").each(function() {
									var amountText = $(this).find(".pill-label").text().trim();
									var adjAmount = amountText.replace(/X$/, '').trim(); // Remove trailing 'X'
									var dateVal = $(this).attr("data-datfe");

									previousAdjustedAmount += parseFloat(adjAmount);
								});
								$('#PopupAdjamount').val(previousAdjustedAmount);
							}

							var rowHtml;
							// console.log('hi');
							var hiddenColumns = [];
							//logic for hide columns & add data as data-key attribute in previous row if hidden columns are present & field type is 5,19,16 & 17
							if(response['hiddenColumns'] != null && response['hiddenColumns'] != ""){
								// console.log("in");
								
								var hiddenColumns = response['hiddenColumns'].split(',');

								// Capitalize the first letter of each column name
								hiddenColumns = hiddenColumns.map(function(column) {
									return column.charAt(0).toUpperCase() + column.slice(1);
								});
							
								if(hiddenColumns.length > 0){
									var headers = $('#tableHeader th');
									var rows = $("#dropdownItems tr");
									// console.log(headers);
									
									// Convert jQuery object to a plain array
									Array.from(headers).forEach(function(header, colIndex) {
										if (hiddenColumns.includes(header.innerText.trim())) {
											// Hide the column header (th)
											header.classList.add('hidden');
											
											// Loop through each row and hide the cell in the hidden column
											rows.each(function(index,row) {
												// Check if the row has enough cells
												if (row.cells.length > colIndex) {
													row.cells[colIndex].classList.add('hidden');
													
													// Add the hidden column's data to the previous cell's data-key attribute
													if (colIndex > 0) {  // Make sure there's a previous column to attach the data to
														var previousCell = row.cells[colIndex - 1];
														previousCell.setAttribute('data-key', row.cells[colIndex].innerText);
													}
												} 
												else {
													// console.log("Row does not have enough cells: ", row);
												}
											});
										}
									});
								}
							}
						}
					
						// generateFooter();  // Re-generate the footer after data load
					}
				},
				error: function(xhr, status, error) {
					console.error('Failed to load data:', error);
					$("#loadingMessage").hide();
				}
			});

			startIndex += itemsPerPage;
			$("#loadingMessage").hide();
		}

		$('#PopulateGridButton').off().on('click', async function(e) {
			var GridMDDModalHiddenValue = ddSelectedItemsValue.toString();
			// var GridMDDModalHiddenValue = $('#GridMultyDDModal-hidden-' + DBFieldName).val();
			// var MultiSelectGridId = $('#MultiSelectGridId-hidden-' + DBFieldName).val();
			console.log("inside");
			// Disable the button
			$('#myModal').find('#PopulateGridButton').prop("disabled", true);
			if(<?php echo $FormID; ?> == 4894){

				var response = await getRequestCondition2();
				console.log(response);
			}else{
				getRequestCondition();
			}
			try {

				if(ddResponseSytemType == 1){
					var result = await $.ajax({
						type: 'POST',
						dataType: 'json',
						data: {
							selectedRowId : GridMDDModalHiddenValue, 
							GridId : GridID, 
							FormId: <?php echo $FormID; ?>, 
							DBFieldType:ddDBFieldType, 
							FieldName:triggeringButtonId, 
							isGrid:ddisGrid, 
							requestParams:requestParams

						},
						url: 'getGridData.php'
					});

					if(ddResponseSytemType == 1){

						var gridIdentifier = $('#grid-id-' + triggeringButtonId).attr('class');
					}else{
						var gridIdentifier = $('#grid-id-' + GridID).attr('class');

					}
					var gridSerialNo = gridIdentifier.slice(4);

					var gridRes = [];
					var gridCalculationFieldName = [];
					var gridCalculationType = [];
					var gridResponseArray = [];
					var OnkeyupParameterCalculation = [];

					

					for (var t = 0; t < result['gridData'].length; t++) {
						if (result['gridData'][t]['gridcalculation'] > 0) {
							gridCalculationFieldName.push(result['gridData'][t]['dbfieldname']);
							gridCalculationType.push(result['gridData'][t]['gridcalculation']);
						}

						if (result['gridData'][t]['onkeyupparameters'] && result['gridData'][t]['onkeyupparameters'].length > 2) {
							if (result['gridData'][t]['fieldtype'] != 5) {
								OnkeyupParameterCalculation.push([result['gridData'][t]['dbfieldname'], result['gridData'][t]['fieldtype'], result['gridData'][t]['onkeyupparameters']]);
							}
						}
					}

					if (Array.isArray(result['data'])) {
						console.log("Data is an array:", result['data']);
						
						var promises = [];

						for (var l = 0; l < result['data'].length; l++) {
							gridResponseArray = ddResponseData['gridResponseParams'].split("|");
							
							for (var k = 0; k < gridResponseArray.length; k++) {
								console.log("Processing row", l);
								gridRes = gridResponseArray[k].split(":");

								if (gridRes[2] == '1' || gridRes[2] == '7') {
									$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(result['data'][l][gridRes[1].trim()]);
									
									// Call function for grid calculation
									for (var m = 0; m < OnkeyupParameterCalculation.length; m++) {
										if (OnkeyupParameterCalculation[m] != undefined) {
											if (OnkeyupParameterCalculation[m].includes(gridRes[0].trim()) == true) {
												promises.push(CreateOnkeyupScriptGrid("kreon-grid-" + gridSerialNo + "" + gridRes[0].trim(), 'grid', 'dynamic'));
											}
										}
									}
								}else if (gridRes[2].trim() == '6') {
									var dateObj = result['data'][l][gridRes[1].trim()];
									
									const date = new Date(dateObj.date);
									const options = {
										timeZone: 'Asia/Calcutta',
										year: 'numeric',
										month: '2-digit',
										day: '2-digit'
									};
									const formattedDate = new Intl.DateTimeFormat('en-GB', options).format(date);
									const [day, month, year] = formattedDate.split('/');
									const inputDateValue = `${year}-${month}-${day}`;
									$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).val(inputDateValue);
								} else if (gridRes[2] == '5' || gridRes[2] == '19') {
									if (result['data'][l][gridRes[1].trim()] != undefined) {
										var $newOption = $("<option selected=\"selected\"></option>").val(result['data'][l][gridRes[3].trim()]).text(result['data'][l][gridRes[1].trim()]);
										if ($('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).data('select2')) {
											// $('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).select2('open');
											$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).append($newOption);
											// $('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).select2('close');
										} else {
											$('#kreon-grid-' + gridSerialNo + '' + gridRes[0].trim()).append($newOption);
										}
									}
								} else if (gridRes[2].trim() == '17' || gridRes[2].trim() == '16') {
									$('#kreon-grid-' + gridSerialNo + gridRes[0].trim() + '-text').val(result['data'][l][gridRes[1].trim()]);
									$('#kreon-grid-' + gridSerialNo + gridRes[0].trim()).val(result['data'][l][gridRes[3]]);
								}
							}

							DynamicGridInsertFirstRowEdit = ddResponseData['DynamicGridInsertFirstRowEdit'];

							// Add new row and add the promise to the array
							promises.push(AddNewRow($(this), result['gridData'], gridSerialNo, result['data'][l][result['selecedRowIdName']], DynamicGridInsertFirstRowEdit));

						}

						// Wait for all promises to finish before moving forward
						await Promise.all(promises);

						// Once the new row is added, perform calculations
						// for (var l = 0; l < gridCalculationFieldName.length; l++) {
							await CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType, gridSerialNo);
						// }

						// $('#DropDownModal').modal('hide');
						$('#myModal').modal('hide');
						setTimeout(function() {
							if ($(".modal-backdrop").length > 0) {
								$(".modal-backdrop").remove();
							}
						}, 50); // Adjust delay as needed
						$(".modal-/backdrop").remove(); // Removes the backdrop

					} else {
						console.log('result["data"] is not an array', result['data']);
					}
				}else{
					var selectedItems = ddSelectedItemsValue.toString();
					// Making AJAX call with async/await
					$.ajax({
						type : 'POST',
						dataType: 'json',
						data : {selectedItems : selectedItems, FormID : <?php echo $FormID; ?>, DBFieldName: triggeringButtonId, GridID: GridID},
						url : 'getPopulateGridData.php',
						success : function(result){
							// console.log(result);
							if (result['success'] == false) {
								alert(result['error']);
								return;
							}else{

								AddNewResultInGrid(result['data'], result['gridData'], result['gridResponse'], result['selecedRowIdName'], result['DynamicGridInsertFirstRowEdit'],result['formResponse']);
							}
						}
					});
				}

			} catch (error) {
				console.error('Error:', error);
			}
		});

		function applyFilters(DBFieldName) {
			// const globalValue = $("#globalSearch").val().toLowerCase();
			activeRowIndex=-1;
			startIndex = 0;
			var ddTbody = $("#dropdownItems");
			ddTbody.empty();  // Clear existing rows

			if(DBFieldName == 'bankreco' || DBFieldName == 'bankreco1'){
				loadBankRecoData(DBFieldName);
				return;
			}

			if(ddResponseSytemType == 1){
				hasMoreData = true;
				console.log("In applyfilter");
				if(!isKreonFT17_CallNextIndex){
					isKreonFT17_CallNextIndex = true;
					loadData(DBFieldName);
				}
			}else{
				loadHeaderData(DBFieldName);
			}
		}

		function toggleSelection(checkbox) {
			if(checkbox != undefined){

				// getRequestCondition();
				var rowText = checkbox.value;
				
				// Get the text of the first column (column 1) of the selected row
				var firstColumnText = $(checkbox).closest("tr").find("td:nth-child(2)").text();
				

				if (checkbox.checked) {
					if(ddDBFieldType == 17){
						// Uncheck all checkboxes
						$(".item-checkbox").prop("checked", false);
						ddSelectedItemsValue = [];
						ddSelectedItemsText = [];
						checkbox.checked = true;
						ddRowSelectType = 'single';
					}else{
						ddRowSelectType = 'multi';
					}

					ddSelectedItemsValue.push((rowText));
					// ddSelectedItemsValue.push(parseInt(rowText));
					ddSelectedItemsText.push(firstColumnText);

					
				} else {
					const index = ddSelectedItemsValue.indexOf((rowText));
					// const index = ddSelectedItemsValue.indexOf(parseInt(rowText));
					if (index !== -1) {
						ddSelectedItemsValue.splice(index, 1);
					}

					const index1 = ddSelectedItemsText.indexOf(firstColumnText);
					if (index1 !== -1) {
						ddSelectedItemsText.splice(index1, 1);
					}
				}

				displaySelectedItems();

				if(ddDBFieldType == 16 || ddDBFieldType == 17 || ddDBFieldType == 14){
					// if(ddisGrid == 1){
					// 	var systemType = $('#kreon-grid-'+triggeringButtonSrNo+triggeringButtonId+'-text').data('systemtype');
					// }else{
					// 	var systemType = $('#'+triggeringButtonId+'-text').data('systemtype');
					// }


					//Populate Field in Form
					if(ddResponseSytemType == 1){
						if(ddResponseData['PopulateFields'] != null  && ddResponseData['PopulateFields'].length > 1){
							// alert("hi");
							var headerCol = [];
							$.each(ddResponseData['columns'], function(index, value) {
								headerCol.push(value.name);  // Push the 'name' property of each object into headerCol array
							});
							
							var PoulateFieldArray = ddResponseData['PopulateFields'].split('|');
							
							for(var n=0; n < PoulateFieldArray.length; n++){
								
								for(var m=0; m < headerCol.length; m++){
									var pFieldArray = PoulateFieldArray[n].split(':');
									
									if(headerCol[m].trim() == pFieldArray[1].trim()){
										var indexOfHideColumn = headerCol.indexOf(headerCol[m]);
										// var selectedOption = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').text();

										var selectedOption = $(checkbox).closest("tr").find('td:eq(' + indexOfHideColumn + ')');

										var columnContent = selectedOption.contents(); // Get the contents of the column cell

										// Check if the content is an input element (textbox)
										if (columnContent.is('input[type="text"]')) {
											selectedOption = columnContent.val(); // Get the value if it's a textbox
										} else {
											selectedOption = columnContent.text(); // Get the text if it's not a textbox
										}
				
										
										//popup field type text, textarea, number
										if(pFieldArray[2] == 1 || pFieldArray[2] == 3 || pFieldArray[2] == 8){
											
											$('#'+pFieldArray[0].trim()+'[type="text"]').val(selectedOption);
										}else if(pFieldArray[2] == 7){
											$('#'+pFieldArray[0].trim()+'[type="number"]').val(selectedOption);
										}else if(pFieldArray[2] == 5 || pFieldArray[2] == 19){
											
											var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
											var newOption = $('<option selected="selected"></option>').val(fldvalue).text(selectedOption);
											Elements = document.querySelectorAll("select[id="+pFieldArray[0].trim()+"]");

											if($('#'+Elements.id).data('select2')) {
												// $('#'+Elements.id).select2('open');
												$(Elements).append(newOption); //.trigger("change");
												// $('#'+Elements.id).select2('close');
											}else{
												$(Elements).append(newOption);
											}
										}else if(pFieldArray[2] == 6){
											const [day, month, year] = selectedOption.split('-');
											// Create a new Date object (months are 0-indexed in JavaScript)
											const date = new Date(year, month - 1, day);
											// Format the date to yyyy-MM-dd
											const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

											$('#'+pFieldArray[0].trim()+'[type="date"]').val(formattedDate);
										}else if(pFieldArray[2] == 16){
											var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
										
											$('#'+pFieldArray[0].trim()+'-text').val(selectedOption);
											$('#'+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
										}else if(pFieldArray[2] == 17){
											var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
											$('#'+pFieldArray[0].trim()+"-text"+'[type="button"]').val(selectedOption);
											$('#'+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
											
										}
									}
								}	
							}
							
						}
					}else{
						if(ddResponsePopulateFields != null && ddResponsePopulateFields.length > 1){
							// var headerCol = [];
							// $.each(ddResponseData['columns'], function(index, value) {
							// 	headerCol.push(value.name);  // Push the 'name' property of each object into headerCol array
							// });

							var headerCol = responseHeaders;
							
							var PoulateFieldArray = ddResponsePopulateFields.split('|');

							for(var n=0; n < PoulateFieldArray.length; n++){
								
								for(var m=0; m < headerCol.length; m++){
									var pFieldArray = PoulateFieldArray[n].split(':');
									
									if(headerCol[m].trim() == pFieldArray[1].trim()){
										var indexOfHideColumn = headerCol.indexOf(headerCol[m]);
										// var selectedOption = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').text();

										var selectedOption = $(checkbox).closest("tr").find('td:eq(' + indexOfHideColumn + ')');

										var columnContent = selectedOption.contents(); // Get the contents of the column cell

										// Check if the content is an input element (textbox)
										if (columnContent.is('input[type="text"]')) {
											selectedOption = columnContent.val(); // Get the value if it's a textbox
										} else {
											selectedOption = columnContent.text(); // Get the text if it's not a textbox
										}
				
										//popup field type text, textarea, number
										if(pFieldArray[2] == 1 || pFieldArray[2] == 3 || pFieldArray[2] == 8){
											$('#'+pFieldArray[0].trim()+'[type="text"]').val(selectedOption);
										}else if(pFieldArray[2] == 0){
											$('#'+pFieldArray[0].trim()+'[type="hidden"]').val(selectedOption);
										}else if(pFieldArray[2] == 7){
											$('#'+pFieldArray[0].trim()+'[type="number"]').val(selectedOption);
										}else if(pFieldArray[2] == 5 || pFieldArray[2] == 19){
											
											var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
											var newOption = $('<option selected="selected"></option>').val(fldvalue).text(selectedOption);
											Elements = document.querySelectorAll("select[id="+pFieldArray[0].trim()+"]");

											if($('#'+Elements.id).data('select2')) {
												// $('#'+Elements.id).select2('open');
												$(Elements).append(newOption); //.trigger("change");
												// $('#'+Elements.id).select2('close');
											}else{
												$(Elements).append(newOption);
											}
										}else if(pFieldArray[2] == 6){
											const [day, month, year] = selectedOption.split('-');
											// Create a new Date object (months are 0-indexed in JavaScript)
											const date = new Date(year, month - 1, day);
											// Format the date to yyyy-MM-dd
											const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

											$('#'+pFieldArray[0].trim()).val(selectedOption);
										}else if(pFieldArray[2] == 16){
											var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
										
											$('#'+pFieldArray[0].trim()+'-text').val(selectedOption);
											$('#'+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
										}else if(pFieldArray[2] == 17){
											var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
											$('#'+pFieldArray[0].trim()+"-text"+'[type="button"]').val(selectedOption);
											$('#'+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
											
										}
									}
								}	
							}
						}
					}

					//Populate Field in Grid
					if(ddResponseSytemType == 1){
						if(ddResponseData['PopulateGridFields'] != null && ddResponseData['PopulateGridFields'].length > 1){
							var gridid = ddResponseData['PopulateGrid'].split(":");
							var gridIdentifier = $('#grid-id-'+gridid[1]).attr('class');		
							var gridSerialNo = gridIdentifier.slice(4);

							var headerCol = [];
							$.each(ddResponseData['columns'], function(index, value) {
								headerCol.push(value.name);  // Push the 'name' property of each object into headerCol array
							});
						
							var PoulateGridFieldArray = ddResponseData['PopulateGridFields'].split('|');
							console.log(PoulateGridFieldArray);
							for(var n=0; n < PoulateGridFieldArray.length; n++){
								for(var m=0; m < headerCol.length; m++){
									var pFieldArray = PoulateGridFieldArray[n].split(':');
									
									console.log(headerCol[m].trim() ,"==", pFieldArray[1].trim());
									if(headerCol[m].trim() == pFieldArray[1].trim()){
										var indexOfHideColumn = headerCol.indexOf(headerCol[m]);
										// var selectedOption = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').text();

										var selectedOption = $(checkbox).closest("tr").find('td:eq(' + indexOfHideColumn + ')');

										var columnContent = selectedOption.contents(); // Get the contents of the column cell

										// Check if the content is an input element (textbox)
										if (columnContent.is('input[type="text"]')) {
											selectedOption = columnContent.val(); // Get the value if it's a textbox
										} else {
											selectedOption = columnContent.text(); // Get the text if it's not a textbox
										}
		
										if(pFieldArray[2].trim() == 1 || pFieldArray[2].trim() == 3 || pFieldArray[2].trim() == 8){		
											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="text"]').val(selectedOption);
										}if(pFieldArray[2].trim() == 0){		
											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="hidden"]').val(selectedOption);
										}else if(pFieldArray[2].trim() == 7){
											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="number"]').val(selectedOption);
										}else if(pFieldArray[2].trim() == 5 || pFieldArray[2].trim() == 19){
						
											var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
											var newOption = $('<option selected="selected"></option>').val(fldvalue).text(selectedOption);
											Elements = document.querySelectorAll("select[id=kreon-grid-"+gridSerialNo+pFieldArray[0].trim()+"]");

											if($('#'+Elements.id).data('select2')) {
												// $('#'+Elements.id).select2('open');
												$(Elements).append(newOption).trigger("change");
												// $('#'+Elements.id).select2('close');
											}else{
												$(Elements).append(newOption);
											}
										}else if(pFieldArray[2].trim() == 6){
											const [day, month, year] = selectedOption.split('-');
											// Create a new Date object (months are 0-indexed in JavaScript)
											const date = new Date(year, month - 1, day);
											// Format the date to yyyy-MM-dd
											const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()).val(selectedOption);
										}else if(pFieldArray[2].trim() == 16){
											var fldvalue = $(this).find('td:eq('+indexOfHideColumn+')').attr('data-key');

											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'-text').val(selectedOption);
											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
										}else if(pFieldArray[2].trim() == 17){
											var fldvalue = $(this).find('td:eq('+indexOfHideColumn+')').attr('data-key');

											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'-text').val(selectedOption);
											$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
										}
									}
								}	
							}
						}
					}else{
						
						if(ddResponsePopulateFieldInGrids != null && ddResponsePopulateFieldInGrids.length > 1){

							var headerCol = responseHeaders;

							// Split the string based on the delimiter "|", or any suitable pattern
							var splitString = ddResponsePopulateFieldInGrids.split(" | "); // splitting by " | " ensures each segment is separated

							// Loop through the array of strings
							for (var i = 0; i < splitString.length; i++) {
								var PopulateFieldInGrids = splitString[i];

								// Regular expression to split the string
								var regex = /(\d+)\((.*)\)/;

								// Apply the regular expression to the string
								var match = PopulateFieldInGrids.match(regex);

								if (match) {
									// Dynamically extracting the two parts
									var gridid = match[1]; // This will be "2302"
									var PopulateFieldInGrids = match[2]; // This will be "gfld1:bname:1|gfld7:cntl:7"						
								}

								var gridIdentifier = $('#grid-id-'+gridid).attr('class');
								
								if (typeof gridIdentifier === 'undefined') {
									alert(gridid +' grid is not exist in this form');
								} else {
									var gridSerialNo = gridIdentifier.slice(4);
									var PoulateGridFieldArray = PopulateFieldInGrids.split('|');

									for(var n=0; n < PoulateGridFieldArray.length; n++){
										for(var m=0; m < headerCol.length; m++){
											var pFieldArray = PoulateGridFieldArray[n].split(':');

											if(headerCol[m].trim() == pFieldArray[1].trim()){
												var indexOfHideColumn = headerCol.indexOf(headerCol[m]);
												// var selectedOption = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').text();

												var selectedOption = $(checkbox).closest("tr").find('td:eq(' + indexOfHideColumn + ')');

												var columnContent = selectedOption.contents(); // Get the contents of the column cell

												// Check if the content is an input element (textbox)
												if (columnContent.is('input[type="text"]')) {
													selectedOption = columnContent.val(); // Get the value if it's a textbox
												} else {
													selectedOption = columnContent.text(); // Get the text if it's not a textbox
												}
												
												if(pFieldArray[2] == 1 || pFieldArray[2] == 3 || pFieldArray[2] == 8){					
													console.log('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim());
													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="text"]').val(selectedOption);
												}else if(pFieldArray[2] == 0){			
													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="hidden"]').val(selectedOption);
												}else if(pFieldArray[2] == 0){					
													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="hidden"]').val(selectedOption);
												}else if(pFieldArray[2] == 7){

													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="number"]').val(selectedOption);

												}else if(pFieldArray[2] == 5 || pFieldArray[2] == 19){
								
													var fldvalue = $(checkbox).closest("tr").find('td:eq('+indexOfHideColumn+')').attr('data-key');
													var newOption = $('<option selected="selected"></option>').val(fldvalue).text(selectedOption);
													Elements = document.querySelectorAll("select[id=kreon-grid-"+gridSerialNo+pFieldArray[0].trim()+"]");

													if($('#'+Elements.id).data('select2')) {
														// $('#'+Elements.id).select2('open');
														$(Elements).append(newOption).trigger("change");
														// $('#'+Elements.id).select2('close');
													}else{
														$(Elements).append(newOption);
													}
												}else if(pFieldArray[2] == 6){
													const [day, month, year] = selectedOption.split('-');
													// Create a new Date object (months are 0-indexed in JavaScript)
													const date = new Date(year, month - 1, day);
													// Format the date to yyyy-MM-dd
													const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()).val(selectedOption);
												}else if(pFieldArray[2] == 16){
													var fldvalue = $(this).find('td:eq('+indexOfHideColumn+')').attr('data-key');

													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'-text').val(selectedOption);
													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
												}else if(pFieldArray[2] == 17){
													var fldvalue = $(this).find('td:eq('+indexOfHideColumn+')').attr('data-key');

													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'-text').val(selectedOption);
													$('#kreon-grid-'+gridSerialNo+pFieldArray[0].trim()+'[type="hidden"]').val(fldvalue);
												}
											}
										}	
									}
								}		

								
							}
						}	
					}
				}

				if(ddDBFieldType == 14 || ddDBFieldType == 16){

			
					if(ddResponseSytemType == 1){
						if(ddResponseData['TotalColumnIndexResponse'] != undefined && ddResponseData['TotalColumnIndexResponse'].length > 0 && ddResponseData['TotalColumnIndexResponse'] != null){  					
							var responseParamsArray = ddResponseData['responseParams'].split('|');
								console.log("responseParamsArray",responseParamsArray);
							var columnMap = {};
								// $('#ddTable thead th').each(function(index) {
								// 	columnMap[$(this).text().trim()] = index;
								// });
								// console.log(columnMap);
							// foot.html('');
							var foot = $('#ddTable').find('tfoot');

							if (foot.length == 0){
								foo = $('<tfoot>').appendTo('#ddTable'); 
								// foot = $('<tr>').appendTo('tfoot');
								foot = $('<tr>').appendTo(foo);
								// for(var i=0; i<responseParamsArray.length; i++){
								// 	foot.append($('<th style="text-align:right;"></th>'));
								// }

								$('#ddTable thead th').each(function(index) {
									foot.append($('<th style="text-align:right;"></th>'));
								});

								// Apply sticky styles dynamically
								foo.css({
									'position': 'sticky',
									'bottom': '-16px',
									'background': 'grey',
									'z-index': '10'
								});
							}

							var columns = ddResponseData['TotalColumnIndexResponse'].split(',');
							for(var j=0; j< columns.length; j++){
								console.log("columns",columns[j]);
								var totalAmount=0;
								
								totalAmount = $('tfoot tr th').eq(columns[j]).text(); 
								
								if(totalAmount == ""){
									totalAmount = 0;
								}else{
									totalAmount = parseFloat(totalAmount);
								}
								
								if($(checkbox).closest("tr").find('td:eq('+columns[j]+')').text() != ""){
									console.log("$('tfoot tr th')", $(checkbox).closest("tr").find('td:eq('+columns[j]+')').text());

									totalAmount += parseFloat($(checkbox).closest("tr").find('td:eq('+columns[j]+')').text());
									$('tfoot tr th').eq(columns[j]).html(totalAmount);
								}
							}
						}
					}else{
						
						// var responseParamsArray = ddResponseData['responseParams'].split('|');
						// foot.html('');
						var foot = $('#ddTable').find('tfoot');

						if (foot.length == 0){
							foo = $('<tfoot>').appendTo('#ddTable'); 
							// foot = $('<tr>').appendTo('tfoot');
							foot = $('<tr>').appendTo(foo);
							for(var i=0; i<responseHeaders.length; i++){
								foot.append($('<th style="text-align:right;"></th>'));
							}
						}

						var columns = ddResponseTotalColumnIndex;
						for(var j=0; j< columns.length; j++){
							var totalAmount=0;
							totalAmount = $('tfoot tr th').eq(columns[j]).text(); 
							
							if(totalAmount == ""){
								totalAmount = 0;
							}else{
								totalAmount = parseFloat(totalAmount);
							}
							
							if($(checkbox).closest("tr").find('td:eq('+columns[j]+')').text() != ""){
								totalAmount += parseFloat($(checkbox).closest("tr").find('td:eq('+columns[j]+')').text());
								console.log("totalAmount "+totalAmount);
								$('tfoot tr th').eq(columns[j]).html(totalAmount);
							}
						}
					}
				}
			}
			
			// updateFooterTotal();
		}

		function displaySelectedItems() {
			// console.log('pornima');
			// console.log("ddSelectedItemsValue "+ddSelectedItemsValue);
			// console.log("ddSelectedItemsText "+ddSelectedItemsText);

			return new Promise((resolve) => {
				if (ddDBFieldType == 17) {
					if (ddisGrid == 1) {
						var button = $("#kreon-grid-" + triggeringButtonSrNo + triggeringButtonId + '-text' + '[type="button"]');
						$('#kreon-grid-' + triggeringButtonSrNo + triggeringButtonId).val('');
					} else {
						var button = $("#" + triggeringButtonId + '-text' + '[type="button"]');
						$('#' + triggeringButtonId).val('');
					}
				} else if (ddDBFieldType == 16) {
					if (ddisGrid == 1) {
						var button = $("#kreon-grid-" + triggeringButtonSrNo + triggeringButtonId + '-text' + '[type="button"]');
						$('#' + triggeringButtonId).val('');
					}else{
						var button = $("#" + triggeringButtonId + '-text' + '[type="button"]');
						$('#' + triggeringButtonId).val('');
					}
				}


				var buttonTextString = '';
				var selectedItemValueString = '';
				if(ddResponseData && ddResponseData['AdjustableAmount'] != 'enable'){
					$("#pillContainer").empty();
					// Iterate over selected values and create pill containers
					for (var i = 0; i < ddSelectedItemsValue.length; i++) {
						$("#pillContainer").append("<div id='pill-" + ddSelectedItemsValue[i] + "'><div class='pill-label btn-primary'>" + ddSelectedItemsText[i] + "&nbsp;<span onclick='deselectRow(" + ddSelectedItemsValue[i] + ")' class='pill-remove bg-danger'>X</span></div></div>");

						// Concatenate text and values
						buttonTextString += ddSelectedItemsText[i];
						selectedItemValueString += ddSelectedItemsValue[i];

						if (i != ddSelectedItemsText.length - 1) {
							buttonTextString += ",";
							selectedItemValueString += ",";
						}
					}
				}

				if (ddDBFieldType != 14) {
					if (ddisGrid == 1) {
						console.log("ddSelectedItemsText ", ddSelectedItemsText);
						$('#kreon-grid-' + triggeringButtonSrNo + triggeringButtonId + '-text').val(buttonTextString);
					} else {
						// console.log("innn ",buttonTextString);
						setTimeout(function () {
							button.val(buttonTextString);
						}, 300);
					}
				}

				// Update hidden fields with selected item values
				if (ddDBFieldType == 17) {
					if (ddisGrid == 1) {
						setTimeout(function () {
							console.log("ddSelectedItemsValue ", ddSelectedItemsValue);
							$('#kreon-grid-' + triggeringButtonSrNo + triggeringButtonId + '[type="hidden"]').val(ddSelectedItemsValue);
							resolve(); // Resolve promise after setting hidden field
						}, 300);
					} else {
						setTimeout(function () {
							$('#' + triggeringButtonId + '[type="hidden"]').val(ddSelectedItemsValue);
							resolve(); // Resolve promise after setting hidden field
						}, 300);
					}
				} else if (ddDBFieldType == 16) {
					if (ddisGrid == 1) {
						setTimeout(function () {
							$('#kreon-grid-' + triggeringButtonSrNo + triggeringButtonId + '[type="hidden"]').val(ddSelectedItemsValue);
							resolve(); // Resolve promise after setting hidden field
						}, 300);
					}else{
						setTimeout(function () {
							$('#' + triggeringButtonId + '[type="hidden"]').val(ddSelectedItemsValue);
							resolve(); // Resolve promise after setting hidden field
						}, 300);
					}
				}
			});
		}

		// Function to deselect a row and remove it from the selected lists
		function deselectRow(value) {
			// Find the index of the element
			let index = ddSelectedItemsValue.indexOf(String(value).trim());
			// If the element is found, remove it
			if (index !== -1) {
				// Remove value from selectedItemsValue array
				ddSelectedItemsValue.splice(index, 1);
				ddSelectedItemsText.splice(index, 1);
			}

			// Get and escape the associated text of the pill
			var valueText = $("#pill-" + value).find('.pill-label').text().trim().replace(/"/g, '\\"');

			// Uncheck the checkbox corresponding to the value
			$("input[type='checkbox'][value='" + value + "']").prop("checked", false);

			// Remove the pill element from the DOM
			$("#pill-" + value).remove();

			// Update the display after a short delay
			setTimeout(displaySelectedItems, 1000);
		}

		function clearSelection() {
			ddSelectedItemsValue = [];
			$(".item-checkbox").prop("checked", false);
			displaySelectedItems();
		}

		function updateActiveRow(visibleRows) {
			$("#dropdownItems tr").removeClass("active");
			if (activeRowIndex >= 0 && activeRowIndex < visibleRows.length) {
				const selectedRow = $(visibleRows[activeRowIndex]);
				selectedRow.addClass("active");
				
				// Toggle the checkbox state for the active row
				const checkbox = selectedRow.find("input[type='checkbox']");
				checkbox.focus();
			}
		}

		$(document).ready(function () {
			// Infinite scrolling to load more items when user reaches bottom
			// $('#myModal .modal-body').on('scroll', function () {
			// 	const el = this;
			// 	const scrollBottom = el.scrollHeight - el.scrollTop <= el.clientHeight + 1;

			// 	if (scrollBottom && hasMoreData) {
			// 		console.log("Reached bottom of dropdownContent");

			// 		if (ddResponseSytemType == 1) {
			// 			console.log("In scroll");
			// 			loadData(triggeringButtonId);
			// 		} else {
			// 			loadHeaderData(triggeringButtonId);
			// 		}
			// 	}
			// });

			 // When modal is opened
			if(ddResponseData && ddResponseData['AdjustableAmount'] == 'enable' || ddResponseData && ddResponseData['adjamount'] == 'enable'){
				
			}else{
				$('#myModal').on('shown.bs.modal', function () {
					console.log("Modal opened — attaching scroll event");

					const $body = $('#myModal .modal-body');
					// Always remove old scroll handler first to avoid duplicates
					$body.off('scroll').on('scroll', function () {
						const el = this;
						const scrollBottom = el.scrollHeight - el.scrollTop <= el.clientHeight + 1;

						if (scrollBottom && hasMoreData) {
							console.log("Reached bottom of modal");

							if (ddResponseSytemType == 1) {

								if(!isKreonFT17_CallNextIndex){
									isKreonFT17_CallNextIndex = true;
									loadData(triggeringButtonId);
								}
							} else {
								loadHeaderData(triggeringButtonId);
							}
						}
					});
				});
			}
		});

		

		function scrollToActiveRow() {
			const visibleRows = $("#dropdownItems tr:visible");
			// console.log(visibleRows)
			const activeRow = $(visibleRows[activeRowIndex]);
			// console.log(activeRowIndex,activeRow)
			const dropdownContent = $("#dropdownContent");
			const rowOffsetTop = activeRow.position().top;
			const dropdownScrollTop = dropdownContent.scrollTop();
			const rowHeight = activeRow.outerHeight();

			if (rowOffsetTop < 0) {
				dropdownContent.scrollTop(dropdownScrollTop + rowOffsetTop);
			} else if (rowOffsetTop + rowHeight > dropdownContent.innerHeight()) {
				dropdownContent.scrollTop(dropdownScrollTop + rowOffsetTop - dropdownContent.innerHeight() + rowHeight);
			}
		}


		// $(document).on('click', '#dropdownItems tr, #dropdownItems input[type="checkbox"]', function(event) {
		// 	if (isSpacebarPressed) return; // Prevent action if spacebar is pressed (to avoid interference)

		// 	const isCheckbox = $(event.target).is("input[type='checkbox']");
		// 	const checkbox = isCheckbox ? $(event.target) : $(this).find("input[type='checkbox']");

		// 	if (!isCheckbox) {
		// 		checkbox.prop("checked", !checkbox.prop("checked")); // Manually toggle only if row is clicked
		// 	}

		// 	toggleSelection(checkbox[0]); // Always handle the selection logic
		// });

		$(document).on('click', '#dropdownItems tr', function(event) {
			if (isSpacebarPressed) return;
			// Only toggle if click is NOT directly on the checkbox
			if (!$(event.target).is("input[type='checkbox']")) {
				const checkbox = $(this).find("input[type='checkbox']");
				checkbox.prop("checked", !checkbox.prop("checked"));
				toggleSelection(checkbox[0]);
			}
		});

		$(document).on('click', '#dropdownItems input[type="checkbox"]', function(event) {
			// if (isSpacebarPressed) return;
			// alert('hello');
			// event.stopPropagation(); // Prevent bubbling to the <tr>
			// toggleSelection(this);   // Just handle selection for the checkbox

			//click on checkbox it twice calling toggleSelection so updated this code
			if (isSpacebarPressed) return;

			if (toggleSelectionCalled) {
				toggleSelectionCalled = false; // reset for the next event cycle
				return; // prevent duplicate call
			}

			event.stopPropagation(); // Prevent bubbling to the <tr>

			toggleSelectionCalled = true;
			toggleSelection(this);

			// Reset the flag after a very short delay
			setTimeout(() => {
				toggleSelectionCalled = false;
			}, 0);
		});

		// Add an event listener to the close button
		$(".btn-close").on("click", function() {
			console.log("on btn-close");
			closeModal(); // Call your custom closeModal function
		});

		// Keyboard navigation and selection
		$(document).on("keydown", function(e) {
			const visibleRows = $("#dropdownItems tr:visible");
			const numRows = visibleRows.length;
			// var DBFieldName = $(e.target).attr('id');
			
			if (!$("#myModal").is(":visible")) return;
			// if (!$("#myModal").is(":visible") || numRows === 0) return;
			
			switch (e.key) {
				case "ArrowDown":
				e.preventDefault();
				if (activeRowIndex < numRows - 1) {
					activeRowIndex++;
					updateActiveRow(visibleRows);
					scrollToActiveRow();
				}
				break;

				case "ArrowUp":
				e.preventDefault();
				if (activeRowIndex > 0) {
					activeRowIndex--;
					updateActiveRow(visibleRows);
					scrollToActiveRow();
				}else{
					if (activeRowIndex == 0) {
						$(".popup-search1").focus();
					}
				}
				break;

				case "Enter":
					if (!$("#myModal").is(":visible")) {
						// Open the modal if it's not visible
						toggleModal(e);
					} else {
						// Apply the filter if the modal is visible & if input type number or text then don't call applyFilters
						if (!$(e.target).is("input[type='number']") && !$(e.target).is("input[type='text']")) {
							applyFilters(triggeringButtonId);
						}
					}
				break;

				case " ":
					// Allow spacebar to work for typing in search input
					if ($(e.target).is('input[type="text"], input[type="search"], textarea')) {
						return; // Let the spacebar work in the search input
					}
				
					e.preventDefault();
					isSpacebarPressed = true; // Set flag to indicate spacebar is pressed
					if (activeRowIndex >= 0 && numRows > 0) {
						const selectedRow = $(visibleRows[activeRowIndex]);
						const checkbox = selectedRow.find("input[type='checkbox']");
						
						// Toggle the checkbox checked state
						checkbox.prop("checked", !checkbox.prop("checked"));
						
						// Update the selected items list
						toggleSelection(checkbox[0]);

						// Optionally, you could highlight the active row to indicate selection change
						selectedRow.toggleClass("active");
						isSpacebarPressed = false;
					}
				break;

				case "Escape":
					// ✅ DO NOTHING HERE – let Bootstrap handle the modal closing
			
					console.log("in escape  from escape"+ddResponseData);
					// // var tabindexValue = $('#yourElementId').attr('tabindex');
					// if (triggeringButtonTabIndex !== null) {
					// 	triggeringButtonTabIndex++;
					// 	console.log("triggeringButtonTabIndex",triggeringButtonTabIndex);
					// 	$("[tabindex='"+triggeringButtonTabIndex+"']").focus();
					// }

					closeModal();
					break;

				 
				case "Home":
					// Add the event listener for the Home key
					$('#myModal .modal-body').find('#dropdownContent').scrollTop(0);
					break;

				case "Tab":
					if (e.shiftKey) {
						// Focus on the first search input field (global search or the first search-column)
						const firstSearchInput = document.querySelector('.search-column');
						if (firstSearchInput) {
							$('#myModal .modal-body').find('#dropdownContent').scrollTop(0);
							firstSearchInput.focus();
							event.preventDefault(); // Prevent default behavior to avoid jumping to the first element in the DOM
						}
					}
			}
		});	

	</script>
	<?php
	$ddtableIncludes = '

	<link rel="stylesheet" type="text/css" href="./assets/vendor/jquery-datatables/media/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="./assets/vendor/jquery-datatables/extras/TableTools/css/dataTables.tableTools.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/keytable/2.12.0/css/keyTable.dataTables.css">
	<link rel="stylesheet" type="text/css" href="./assets/vendor/jquery-datatables/media/css/select.dataTables.css">

	<script type="text/javascript" language="javascript" src="./assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/keytable/2.12.0/js/dataTables.keyTable.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/keytable/2.12.0/js/keyTable.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>
	<style>
		#myModal .btn-close, #popupGrid .btn-close {
			background-color: transparent; /* Keep background transparent */
			border: 0;
			position: absolute;
			top: 10px;     /* Adjust top distance */
			right: 10px;   /* Adjust right distance */
			width: 1.5rem; /* Size of the button */
			height: 1.5rem;
			padding: 0;    /* Adjust padding if necessary */
			color: #000;   /* Icon color */
			opacity: 0.7;  /* Default opacity */
			cursor: pointer;
			transition: opacity 0.2s ease;
		}

		#myModal .modal-dialog {
			width: 95% !important;
			max-width: 95% !important;
		}

		/*
		#myModal .dropdown-content {
			display: block;
			max-height: 500px;
			overflow-y: auto;
			position: relative; 
		}

		#myModal .dropdown-content tfoot {
			position: sticky;
			bottom: 0;
			background-color: #fff; 
			z-index: 1; 
		}

		#myModal .dropdown-content table {
			width: 100%;
			border-collapse: collapse;
		}

		#myModal .modal-body {
			// max-height: calc(100vh - 200px); 
			// overflow-y: auto;
			position: relative; 
		}*/
		#myModal .modal-body {
			overflow-y: scroll;
			// height: 67vh;
			max-height: calc(100vh - 200px); 
		}

		// #myModal .dropdown-content table thead {
		// 	background-color: #f4f4f4;
		// 	position: sticky;
		// 	top: -15px;
		// }

		#myModal .modal-header {
			position: sticky;
			top: 0;
			z-index: 100;               /* higher than table header */
			background: white;          /* mandatory */
			padding-bottom: 2px;       /* spacing */
			border-bottom: 1px solid #ddd;
		}

		#myModal .dropdown-content th, .dropdown-content td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		// #myModal .dropdown-content table thead th {
		// 	background-color: #f4f4f4;
		// 	position: sticky;
		// 	top: 0;
		// }

		#myModal .dropdown-content > table > tbody > tr:nth-of-type(odd) > td {
			background-color: #f9f9f9;
		}

		
		#myModal .dropdown-content .search-column, .dropdown-content #globalSearch {
			width: 100%;
			padding: 5px;
			margin: 5px 0;
			box-sizing: border-box;
		}

		#myModal .dropdown-content tr {
			cursor: pointer;
		}

		#myModal .dropdown-content tr:hover, .dropdown-content tr.active {
			background-color: #ddd;
		}

		#myModal .loading {
			text-align: center;
			padding: 10px;
			display: none;
		}

		#myModal .selected-items {
			margin-top: 10px;
			padding: 10px;
			background-color: #f9f9f9;
			border: 1px solid #ddd;
			max-height: 100px;
			overflow-y: auto;
		}

		#myModal .pill-label{
			display: block;
			float:left;
			// background-color: black;
			// color: white;
			border-radius: 16px;
			height: 25px;
			padding-left: 8px;
			padding-top: 2px;
			padding-right: 2px;
			margin-right:2px;
			margin-bottom:2px;
		}

		#myModal .pill-remove{
			display: block;
			float:right;
			// background: #d8d8d8;
			// color: white;
			border-radius: 21px;
			width: 21px;
			padding-left: 6px;
			cursor: pointer;
		}

		#myModal #pillContainerClear{
			display:none;
			margin-bottom:4px;
		}

		// Log modal style for sticky header
		// #logTable thead {
		// 	position: sticky;
		// 	top: 0;
		// 	z-index: 1; 
			 
		// 	background-color: #f4f4f4;
		// 	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
		// }

		// #logModal .modal-body{
		// 	padding: 0px 15px 15px 15px;
		// }

		// #logModal .modal-body {
		// 	overflow-x: auto;
		// }

		// #logModal #logTable {
		// 	min-width: 1000px;
		// 	white-space: nowrap;
		// }

		// #logModal .modal-dialog.modal-lg {
		// 	max-width: 95vw;
		// }

		// #logModal #logTable th, #logTable td {
		// 	white-space: normal;  /* Allow wrapping */
		// 	word-break: break-word;
		// 	font-size: 13px;
		// 	vertical-align: top;
		// }

		// #logModal #logTable {
		// 	width: 100% !important;
		// 	table-layout: auto !important;
		// }

		// /* Optional: set a max width only for the OldValue column */
		// #logTable td.OldValue-column {
		// 	max-width: 300px;
		// }

		#logTable th, #logTable td {
		vertical-align: middle;
		white-space: nowrap;
		}

		#logTable thead input {
		width: 100%;
		font-size: 12px;
		padding: 2px 5px;
		box-sizing: border-box;
		}

		#logTable tbody td {
		max-width: 300px;
		white-space: normal; /* allows wrapping for long JSON */
		word-break: break-all;
		}

	</style>
	';


	//Use for default value in case format then
	function replaceSqlPlaceholders($expr, $extraVars = []) {
		// default replacement map (from session + extras)
		$searchParamValue = array_merge([
			'yearcode'   => $_SESSION['dbYear']   ?? null,
			'companyid'  => $_SESSION['dbCompany'] ?? null,
			'divisionid' => $_SESSION['dbDivision'] ?? null,
			'userid'     => $_SESSION['user_id'] ?? null,
			'formid'     => $GLOBALS['FormID'] ?? null,
			'editid'     => $GLOBALS['upID'] ?? null,
		], $extraVars);

		$st = $expr;

		foreach ($searchParamValue as $key => $val) {
			if ($val === null) continue;
			$pattern = '/!' . preg_quote($key, '/') . '(?=[^a-zA-Z0-9]|$)/';
			$st = preg_replace($pattern, $val, $st);
		}

		return $st;
	}

//code array
//Types: 0=hidden 1=Text Box; 2=SelectDropDown 3=textbox 4=radio 5=Select-from-DB 6=date 7=number 8=Email 9=Checkbox-From-DB 10=MULTI-SELECT-from-DB 11=MULTI SELECT SEARCH from DB WITH MAPPING TABLE 12=Single Media Upload 13=Multiple Media Upload
//Image needs an extra folder name, Type allowed, max size allowed, single or multiple
function createInputs($arr,$FormID,$editID){

	global $k_debug;
	global $ddtableIncludes;
	$flds = "";

	if(1){ //BLOCK OTHER SETTINGS OF A FIELD
		if($arr[5] == 1){ //to check if required field
			$reqf = 'required';
			$reqv = '<span class="required"> *</span>';
		}
		else $reqf = $reqv = '';

		$divClass = "";
		$textLength="";
		
		// if($arr[21] == 1){ // Onload dynamic free fill data
		// 	if(strlen($arr[4]) == 0){
			
		// 		echo "<script>
		// 		window.addEventListener('load', function() {
		// 			dynamicFreeFill('".$arr[22]."');
		// 		}); </script>";
		// 		// $readOnly = "readonly";
		// 	}
		// }

		if($arr[9] != 0){ //to check text length size
			$textLength = "maxlength = $arr[9]";
		}

		$maxValue = "";
		if($arr[10] != 0){ //to check field max value
			$maxValue = "max = $arr[10]";
		}

		$minValue = "";
		if($arr[11] != 0){ //to check if field minimum value
			$minValue = "min = $arr[11]";
		}

		$readOnly = "";
		if($arr[12] != 0){ //to check if field readonly
			$readOnly = "readonly";
		}

		if($arr[13] == 0 ){  //to check visibility
			$divClass .= " hidden ";
		}

		//SIZES: col-md >= 992; col-sm >= 768; col-xs < 768 
		if($arr[16] !=0 ){	//Fields Size XS
			$divClass .= " col-xs-" . $arr[16] . " ";
		}

		if($arr[14] !=0 ){	//Field Size SM
			$divClass .= " col-sm-" . $arr[14] . " ";
		}

		if($arr[15] !=0 ){	//Fields Size MD
			$divClass .= " col-md-" . $arr[15] . " ";
		}

		if($arr[14] == 0 && $arr[15] == 0 && $arr[16] == 0 ){ //both the sizes are not set
			$divClass .= " col-md-3 ";
		}
		$textareaHeight = "";

		if($arr[20] != 0){ //to check textarea height
			$textareaHeight = "rows = $arr[20]";
		}

		if($arr[21] != 0){ //to check if field readonly
			$readOnly = "readonly";
		}

		$otherInputParams = $maxValue . " " . $minValue . " " . $textLength . " " . $readOnly;
		$formType = 1; // Added For Add More functionality
	}
	
	if($arr[1] == 0){ 	//hidden
		if(strlen($arr[31]) >= 1 && strlen($arr[4]) == 0){
			// if($editID == 0){
				// echo $arr[31];
				$arr[4] = $arr[31];
			// }
		}
		return "<input value='".$arr[4]."' type='hidden' ".$arr[6]." name='".$arr[0]."' id='".$arr[0]."' />";
	}

	// print_r($arr);
	// echo "<pre></pre>";

	if($arr[1] == 1){ 	//Textbox
		// global ${$arr[0]};
		
		
		if(strlen($arr[19]) < 2){	//CONDITION TO CHECK ShowTextBoxInGrid
			// if(isset(${$arr[0]})){
			// 	$arr[4] = ${$arr[0]};
			// }  

			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$arr[0]])){
						$arr[4] = $_SESSION['carryOn'][$arr[0]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}
				}
			}

			echo "<script>
				$(document).ready(function(){
					if('".$arr[39]."' == 1){
						$('#".$arr[0]."').focus();
					}
				});
			</script>";

			//If dependent field then call on blur
			if (strlen($arr[52]) > 1) {
				$dependentFields = explode("|",$arr[52]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#".$arr[0]."').on('blur', function(e) {
								onBlurClearDependentField(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//If noneditable field added then call this function
			if (strlen($arr[53]) > 1) {
				$dependentFields = explode("|",$arr[53]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#" .$arr[0]. "').on('blur', function(e) {
								onBlurNonEditableFields(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//Set default value
			if(strlen($arr[31]) >= 1 && $arr[4] == ''){
				if($editID == 0){
					$arr[4] = $arr[31];
				}
			}
			// print_r($arr);
			$flds = "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." class='form-control dyn1' value='".$arr[4]."' type='text' ".$otherInputParams." autocomplete='off' ".$arr[6]." name='".$arr[0]."' id='".$arr[0]."' ";
			if(strlen($arr[33]) > 2){
				$flds .= "onfocusout=\"isValidText('".$arr[33]."','".$arr[0]."');\"";
			}
			if($arr[32] == 1){ //to check if field editable
				if($editID > 0){
					$flds .= "readonly";
				}
			}

			//Added for getting dynamic decimalplaces
			if($arr[44] != ''){
				$flds .=" data-key=\"".$arr[44]."\"";
			}

			//Check validation using sp on lost focus
			if($arr[35] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,0);\""; //0 is gridid in form it is set as 0
			}

			//On keyup focus exicute formula calculation
			$onkeyupparameterHidden = "";
			if(strlen($arr[40]) > 5){
				$flds .= "onkeyup=\"CreateOnkeyupScriptGrid(this,'form');\""; //0 is gridid in form it is set as 0
				$onkeyupparameterHidden = '<input type="hidden" id="'.$arr[0].'-onkeyup-hidden" value="'.$arr[40].'">';
			}

			//Check value is exist or not
			$onlostfocusHidden = "";
			if($arr[26] == 1){
				$flds .= "onfocusout=\"onLostFocus(this,$editID,'form');\"";
				$onlostfocusHidden = '<input type="hidden" id="'.$arr[0].'-hidden" value="'.$arr[27].'">';
			}
			
			//Once lost focus from perticular field then again don't allow to focus on this field
			if($arr[41] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
			}

			

			$flds .= " tabindex='".$arr[39]."'/>".$onlostfocusHidden.$onlostfocuscalculationHidden.$onkeyupparameterHidden;
			
			$flds .= "</div>";

			if($arr[39] == 0){
				echo "<script>
				$('#company').focus();
				</script>";
			}
			
			if($arr[43] == 1){
				echo "<script>
					$(document).ready(function(){
						$('#".$arr[0]."').keypress(function(event) { 
							if (event.which === 13) { 
								$('#".$arr[0]."').trigger('blur');
								setTimeout(function () {
                            		console.log('barcode entered....')
									$('#".$arr[0]."').val('');
									$('#".$arr[0]."').focus();
                        		}, 1000);
							}
						});
					});
				</script>";
			}
			return $flds;
		}else{
			return "<script>window.addEventListener('load', function() {

						$('#".$arr[19]."Footer').attr('name', '".$arr[0]."'); 

						$('#".$arr[19]."Footer').val($arr[4]);

					}); </script>";
		}
	}

	if($arr[1] == 2){ 	//SELECT
		global $radio;
		$r = $radio;
		$m = $arr;
		$p = $arr[4];

		$flds = '<div class="col-md-4"><label>'.$arr[2].$reqv.'</label><select '.$reqf.' name="'.$m[0].'" id="'.$m[0].'" class="form-control" '.$arr[6].' tabindex="'.$arr[39].'" ><option></option>';

		for($j = 0; $j < sizeof($r[$m[3]]); $j++){
			$k = $j+1;  //value
			if($p == $k) {
				$flds .= '<option selected value="'. $k .'" >'.$r[$m[3]][$j].'</option>&nbsp;';
			}
			else {
				$flds .= '<option value="'. $k .'">'.$r[$m[3]][$j].'</option>&nbsp;';
			}
		}

		$flds .= '</select></div>';
		return $flds;
	}

	if($arr[1] == 3){ 	//Textarea
		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}   

		echo "<script>
				$(document).ready(function(){
					if('".$arr[39]."' == 1){
						$('#".$arr[0]."').focus();
					}
				});
			</script>";

	    // if(strcmp($arr[6], "maxlength=")) $maxChar = "maxlength='1000'";    //ADDED FOR VAPT 
	    // else $maxChar = '';

		//Set default value
		if(strlen($arr[31]) >= 1 && $arr[4] == ''){
			if($editID == 0){
				$arr[4] = $arr[31];
			}
		}
		
	    if(extractAttribute($arr[8], "RichTextEditor") !== null){     //FOR ADD NEW FUNCTION added on 15062023 for react cap api
		    $flds .= "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><textarea ".$reqf." ".$textareaHeight." class='form-control dyn1' ".$arr[6]." ".$otherInputParams." name='".$arr[0]."' id='".$arr[0]."' tabindex='".$arr[39]."' ";
			if(strlen($arr[33]) > 2){
				$flds .= "onfocusout=\"isValidText('".$arr[33]."','".$arr[0]."');\"";
			}

			if($arr[32] == 1){ //to check if field editable
				if($editID > 0){
					$flds .= "readonly";
				}
			}

			//Check validation using sp on lost focus
			if($arr[35] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,0);\"";  //0 is gridid in form it is set as 0
			}

			//Once lost focus from perticular field then again don't allow to focus on this field
			if($arr[41] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
			}

			$flds .= ">".htmlspecialchars($arr[4],ENT_QUOTES)."</textarea></div><script type='text/javascript'>CKEDITOR.replace(\"".$arr[0]."\", {height:'300px'});</script>";
			return $flds;
		}else{
		    $flds .= "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><textarea ".$reqf." ".$textareaHeight." class='form-control dyn1' ".$arr[6]." ".$otherInputParams." name='".$arr[0]."' id='".$arr[0]."' tabindex='".$arr[39]."' ";
			if(strlen($arr[33]) > 2){
				$flds .= "onfocusout=\"isValidText('".$arr[33]."','".$arr[0]."');\"";
			}

			if($arr[32] == 1){ //to check if field editable
				if($editID > 0){
					$flds .= "readonly";
				}
			}

			//Check validation using sp on lost focus
			if($arr[35] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,0);\"";  //0 is gridid in form it is set as 0
			}

			//Once lost focus from perticular field then again don't allow to focus on this field
			if($arr[41] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
			}

			$flds .= ">".htmlspecialchars($arr[4],ENT_QUOTES)."</textarea></div>";
			return $flds;
		}
	}

	if($arr[1] == 4){ 	//Radio
		/*global $radio;
		$r = $radio;
		$m = $arr;
		$p = $arr[4];
		$flds = '<div class="col-md-4"><label>'.$arr[2].$reqv.'</label><br />';
		//print_r($r[$m[3]]);
		for($j = 0; $j < sizeof($r[$m[3]]); $j++){
			$k = $j+1;  //value
			if($p == $k) {
				$flds .= '<input type="radio" checked value="'. $k .'" name="'.$m[0].'" />&nbsp;'.$r[$m[3]][$j].'<br/>';
			}
			else {
				$flds .= '<input type="radio" value="'. $k .'" name="'.$m[0].'" />&nbsp;'.$r[$m[3]][$j].'<br/>';
			}
		}
		$flds .= '</div>';
		return $flds;*/

		global $extradb;
		$eresult = array();

		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){

				$edb = $extradb[$i][1];

				$eid = $extradb[$i][2];

				$elb = $extradb[$i][3];

				$end = checkVariable($extradb[$i][4]);

				$eval = array();
				
				$esql = "SELECT ".$eid.",".$elb." FROM ".$edb . " " . $end;

				if($k_debug) echo '<br/>'.$esql.'<br/>';

				$eresult = db::getInstance()->db_select($esql, "F-9125: Cl-");

				if($k_debug){ echo '<br/>'; print_r($eresult); }

				break;

			}
		}

		if(sizeof($eresult) > 0){

			if(sizeof($eresult['result_set']) > 0){

				$m = $arr;
				$p = $arr[4];	

				// $flds = '<div class="'.$divClass.'" id="'.$arr[0].'-div"><label>'.$arr[2].$reqv.'</label>';

				$flds = '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label><br /><div id="'.$arr[0].'-div">';

				for($j = 0; $j < sizeof($eresult['result_set']); $j++){

					$k = $eresult['result_set'][$j][$eid];  //ID

					if($p == $k) { 

						$flds .= '<input '.$reqf.'  type="radio" '.$arr[6].' checked value="'. $k .'" name="'.$m[0].'" tabindex="'.$arr[39].'" ';

						if($arr[17] == 1){

							$onchange = " onchange=\"CreateOnchangeScript('" . $arr[18] . "', '".$m[0]."', '".$arr[1]."');\"";

							$flds .= $onchange;

						}

						if($arr[32] == 1){ //to check if field editable
							if($editID > 0){
								$flds .= "onclick=\"return false\"";
							}
						}

						$flds .= '/>&nbsp;'.$eresult['result_set'][$j][$elb].'<br/>';
					}
					else {

						$flds .= '<input '.$reqf.' type="radio" '.$arr[6].' value="'. $k .'" name="'.$m[0].'" tabindex="'.$arr[39].'" ';

						if($arr[17] == 1){

							$onchange = " onchange=\"CreateOnchangeScript('" . $arr[18] . "', '".$m[0]."', '".$arr[1]."');\"";

							$flds .= $onchange;

						}

						if($arr[32] == 1){ //to check if field editable
							if($editID > 0){
								$flds .= "onclick=\"return false\"";
							}
						}

						$flds .= '/>&nbsp;'.$eresult['result_set'][$j][$elb].'<br/>';
					}
				}
				$flds .= '</div>';
				return $flds;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}

	if($arr[1] == 5){ 	//SELECT from DB
		global $extradb;		
		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}

		$eresult = array();
		$m = $arr;
		$p = $arr[4];
		
		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){
				$edb = trim($extradb[$i][1]);
				$eid = trim($extradb[$i][2]);
				$elb = trim($extradb[$i][3]);
				$end = $extradb[$i][4];
				
				// $end = checkVariable($extradb[$i][4]);
				$eval = array();
				if($p){
					//$esql = "SELECT ".$eid.",".$elb." FROM ".$edb . " " . $end;
					$esql = "SELECT ".$eid.",".$elb." FROM ".$edb;
					if(strlen($end) > 1){
						$esql .= " ".$end;
					}else{
						$esql .= " WHERE 1=1";
					}
					$esql .= " AND ".$eid ."=". $p ;

					if($k_debug) echo '<br/>'.$esql.'<br/>';

					$eresult = db::getInstance()->db_select($esql, "F-9237: Cl-");

					if($k_debug){ echo '<br/>'; print_r($eresult); }
				}

				//Query for Default value
				if(strlen($arr[31]) > 0 ){
					if($editID == 0){
						$esql1 = "SELECT ".$eid.",".$elb." FROM ".$edb;
						if(strlen($end) > 1){
							$esql1 .= " ".$end;
						}else{
							$esql1 .= " WHERE 1=1";
						}

						// check if it's a CASE condition
						// if (stripos($arr[31], "case") === 0) {
						// 	// starts with CASE => use directly
						// 	$esql1 .= " AND (".$arr[31].")";
						// }else{
							$esql1 .= " AND ".$eid ."=". $arr[31];
						// }
	
						$eresult1 = db::getInstance()->db_select($esql1, "F-9260: Cl-");
					}
				}

				break;
			}
		}
		
		$flds = '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label>';
		
		if($arr[23] > 0){	
			$flds .= '<button type="button" id="AddBtnModal-'.$m[0].'"  value="'.$arr[23].'-'.$m[0].'-'.$formType.'" class="amodal" style="background: transparent;border: none !important;font-size:1;color:blue"><i class="fa fa-plus-circle"></i></button>';
		}

		//If dependent field added then call this function
		if (strlen($arr[52]) > 1) {
			$dependentFields = explode("|",$arr[52]);
			echo "<script>
				$(document).ready(function() {";

					foreach ($dependentFields as $dependentField) {
						echo "$('#".$m[0]."').on('select2:select', function(e) {
							onBlurClearDependentField(this, '" . trim($dependentField) . "');
						});";
					}

				echo "});
				</script>";
		}
		
		echo "<script>
			$(document).ready(function(){

				// $('#".$m[0]."').on('select2:select', function (e) { // select option by enter then cursor going to next field
				// 	var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
				// 	focusable = form.find('input,a,select,button,textarea').filter(':visible');
				// 	next = focusable.eq(focusable.index(this)+1);
				// 	if (next.length) {
				// 		next.focus();
				// 	} 
				// 	return false;
				// });
				
				//Once lost focus from perticular field then again don't allow to focus on this field
				if('".$arr[41]."' == 1){
					$('#".$m[0]."').on('select2:open select2:select', function (e) {
							// alert($('#".$m[0]."').find(':selected'));
							onBlurUpdateLostFocusTabIndex(this,'".$arr[1]."');
						
					});
				}

                if('".$arr[39]."' == 1){
					setTimeout(
						function() {
							console.log('Line 4547 Focus');
							$('#".$m[0]."').next('span').find('.select2-selection--single').focus();
						}, 300);
				}	
				
			});
		</script>"

		?>
		<script>
				if(<?php echo $arr[39]; ?> == 1){
					var tabindex1 = <?php echo $arr[39]; ?>;
					tabindex1++;
					// alert(tabindex1);
					console.log('Line 4561 Focus');
					$("[tabindex='"+tabindex1+"']").focus();
				}
			
		</script>

		<?php
		
			$DDSearchPreLoadedArray = [];
			$DDSearchPreLoadedData = '';
			if($edb != ''){
				$ddsql = "SELECT TOP 10 ".$elb." FROM ". $edb; //." WHERE 1=1 "
				if(strlen($end) > 1){
					$ddsql .= " ".$end;
				}
				
				$ddresult = db::getInstance()->db_select($ddsql, "F-9345: Cl-");
				
				if($ddresult){
					for($i=0; $i < count($ddresult['result_set']); $i++){
						// echo $ddresult['result_set'][$i][$elb];
						array_push($DDSearchPreLoadedArray,trim($ddresult['result_set'][$i][$elb]));
					}

					$DDSearchPreLoadedData = implode(',',$DDSearchPreLoadedArray);
					
					echo "<script>
						$(document).ready(function(){
					        
							var finalParams = ['".$eid."','".$elb."'];
							var DDSearchMinInputLen = [];

							if('".$arr[29]."' > 0){
								DDSearchMinInputLen['".$m[0]."'] = '".$arr[29]."';
							}else{
								DDSearchMinInputLen['".$m[0]."'] = 0;
							}
					
							var DDSearchPreLoadedData = [];
							var DDSearchPreLoadedDataString = [];
				
							DDSearchPreLoadedData['".$m[0]."'] = ".json_encode($DDSearchPreLoadedData).";
							if(DDSearchPreLoadedData['".$m[0]."'].length > 0){
								DDSearchPreLoadedDataString['".$m[0]."'] = ' or more char (like: '+ DDSearchPreLoadedData['".$m[0]."'] +')';
							}else{
								DDSearchPreLoadedDataString['".$m[0]."'] = ' char ';
							}						
							// // Automatically open and focus on search when the field gets focus
							// $('.godownid div span span span').on('focus', function () {
							// 	console.log('Focussed on GD');
							// 	$(this).select2('open');
							// });


							// $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
							//   // Trigger dropdown opening
							//   $(this).closest('.select2-container').prev('select').select2('open');
							// });

							// // Prevent immediate close when focusing
							// $('select').on('select2:opening', function(e) {
							//   $(this).data('is_opening', true);
							// });
							// $('select').on('select2:closing', function(e) {
							//   if ($(this).data('is_opening')) {
							//     e.preventDefault();
							//     $(this).data('is_opening', false);
							//   }
							// });




							// $(document).on('focus', '.select2-selection.select2-selection--single', function (e) {
							//   const sel = $(this).closest('.select2-container').prev('select');
							//   if (!sel.data('select2-open')) {
							//     sel.select2('open');
							//   }
							// });

							// // Track dropdown open/close state
							// $('select').on('select2:opening', function(e) {
							//   $(this).data('select2-open', true);
							// });
							// $('select').on('select2:closing', function(e) {
							//   $(this).data('select2-open', false);
							// });

							// // Close dropdown after selection
							// $('select').on('select2:select', function(e) {
							//   $(this).select2('close');
							// });





							// // Open Select2 dropdown on focus for respective elements
							// $(document).on('focus', '.select2-selection.select2-selection--single', function () {
							//   const sel = $(this).closest('.select2-container').prev('select');
							//   if (!sel.data('select2-open')) {
							//     sel.select2('open');
							//   }
							// });

							// Track dropdown open/close state for respective elements
							// $('#".$m[0]."').on('select2:opening', function () {
							//   $(this).data('select2-open', true);
							// });

							// $('#".$m[0]."').on('select2:closing', function (e) {
							//   if ($(this).data('select2-open')) {
							//     e.preventDefault();
							//     $(this).data('select2-open', false);
							//   }
							// });

							// // Close dropdown on selection for respective elements
							// $('#".$m[0]."').on('select2:select', function () {
							//   $(this).select2('close');
							// });




							$('#".$m[0]."').select2({

								//tags: true,
								// multiple: true,
								tokenSeparators: [','],
									debug: true,
									placeholder: 'select',
								// allowClear: true,
								minimumInputLength: DDSearchMinInputLen['".$m[0]."'],
								language: {
									inputTooShort: function() {
										return 'Enter ' + DDSearchMinInputLen['".$m[0]."'] + ' '+ DDSearchPreLoadedDataString['".$m[0]."'] ;
									}
								},
								//minimumResultsForSearch: 10,
								ajax: {
									url: 'getDropDownValue.php',
									dataType: 'json',
									type: 'POST',
									data: function (params) {
										var queryParameters = {
										searchText: encodeURIComponent(params.term)
										,searchParam:'".$elb."'
										,fromRepo:'".json_encode($edb)."'
										,repoCondition:'".$end."'
										,responseParams:finalParams.toString()
										,searchText1: $('form').serialize()
										,currentId:'".$m[0]."'
										,gridSerial:''
										,FormID:'".$FormID."'
										,GridID:0
										
									}
									return queryParameters;
								},
								processResults: function (data) {
									if(data['data'].length == 0){
										$('#".$m[0]."').val('');//.trigger('change')
									}
									return {
										results: $.map(data['data'], function (item) {
											$('#".$m[0]."').next('span').find('.select2-selection--single').css('border-color','#ccc');
											$('#".$m[0]."').next('span').find('.select2-selection--multiple').css('border-color','#ccc');
											return {
												// $('#".$m[0]."').select2('open');
												text: item.ddVal,	
												id: item.ddID
												// $('#".$m[0]."').select2('close');
											}
										})
									};
								}
							}

						});
					
					});

					// js helper for clear button
					function clearSelect2(id){
						$('#'+id).val(null).trigger('change');
						$('#'+id+'-hidden').val('');
					}

					
					</script>";

				}
			}
				
			
		$flds .= '<select '.$reqf.'   name="'.$m[0].'" id="'.$m[0].'" class="form-control populate" style="width:100%" tabindex="'.$arr[39].'" ';

		//Check validation using sp onChange
		if($arr[36] == 1){
			$flds .= " onchange=\"validateOnChangeSp(this,0);\""; //0 is gridid in form it is set as 0
		}

		if($arr[17] == 1){
			$onchange = " onchange=\"CreateOnchangeScript(this, '".$arr[1]."');\"";
			$flds .= $onchange;
			$onchangeHidden = '<input type="hidden" id="'.$m[0].'-hidden" value="' . $arr[18] . '" />';
		}

		

		//Check validation using sp on lost focus
		if($arr[35] == 1){
			$flds .= "onchange=\"validateOnLostFocusSp(this,0);\"";  //0 is gridid in form it is set as 0
		}

		$flds .= '><option value=""></option>'; 

		//Default value
		if(strlen($arr[31]) > 0){
			if($editID == 0){
				for($j = 0; $j < sizeof($eresult1['result_set']); $j++){
					$flds .= '<option  value="'. $eresult1['result_set'][$j][trim($eid)] .'" selected>'.$eresult1['result_set'][$j][$elb].'</option>&nbsp;';
				}
			}
		}

		if(sizeof($eresult) > 0){
			
			if(sizeof($eresult['result_set']) > 0){
				
				for($j = 0; $j < sizeof($eresult['result_set']); $j++){
					$k = $eresult['result_set'][$j][$eid];  //ID	

					if($p == $k) {
						$flds .= '<option selected value="'. $k .'" >'.$eresult['result_set'][$j][$elb].'</option>&nbsp;';
					}
				}
			}
		}

		$flds .= '</select>';

		// small clear button (useful if read-only blocks the ×)
		$flds .= '<button type="button"
			style="position:absolute; right:35px; top:26px; color:#444; background:none; border:none; font-size:16px; cursor:pointer;"
			title="Clear"
			onclick="clearSelect2(\''. $m[0] .'\')"';
		if($arr[32] == 1){
			$flds .= ' disabled ';
		}
		$flds .= '>×</button>';


		

		
		$flds .= $onchangeHidden.'</div>';

		if($arr[12] == 1){ //to check if field readonly
			echo '<script>
				// document.addEventListener("DOMContentLoaded", function() {
				// alert("Page Loaded!");
					setTimeout(
						function() {
							$("#'.$m[0].'").next("span").find(".select2-selection--single").css("pointer-events","none").css("background","#eee");
						}, 2000);
				// });
			</script>';
		}

		if($arr[32] == 1){ //to check if field editable
			// echo $m[0];
			if($editID > 0){
				// $flds .= " style=\"pointers-event:none;\"";
				echo '<script>
					$(document).ready(function () {
						setTimeout(function(){ lockSelect2("'.$m[0].'"); }, 0);
					})
				</script>';
			}
		}
		
		return $flds;

		
	}

	?>

	<?php

	if($arr[1] == 6){ 	//Date
		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}

		echo "<script>
			$(document).ready(function(){
				if('".$arr[39]."' == 1){
					$('#".$arr[0]."').focus();
				}
			});
		</script>";

		//If dependent field then call on blur
		if (strlen($arr[52]) > 1) {
			$dependentFields = explode("|",$arr[52]);
			echo "<script>
				$(document).ready(function() {";

					foreach ($dependentFields as $dependentField) {
						echo "$('#".$arr[0]."').on('blur', function(e) {
							onBlurClearDependentField(this, '" . trim($dependentField) . "');
						});";
					}

				echo "});
				</script>";
		}

		//If noneditable field added then call this function
		if (strlen($arr[53]) > 1) {
			$dependentFields = explode("|",$arr[53]);
			echo "<script>
				$(document).ready(function() {";

					foreach ($dependentFields as $dependentField) {
						echo "$('#" .$arr[0]. "').on('blur', function(e) {
							onBlurNonEditableFields(this, '" . trim($dependentField) . "');
						});";
					}

				echo "});
				</script>";
		}

		// if($arr[4] != NULL){		
		// 	if (gettype($arr[4]) == "string"){
		// 		$arr[4] =  date("d-m-Y", strtotime($arr[4]));
		// 	}
		// }
		/*
			FOR DateValidation add in Other Attributes
			Example: DateValidation="From=YearCode_Start&To=YearCode_End"
			Values Allowed:
				YearCode_Start
				YearCode_End
				today
				tomorrow
				yesterday
				2024-01-11 (value as it is)
		*/
		$date_max = '';
		$date_min = '';

		if(extractAttribute($arr[8], "DateValidation") !== null ){     
			$DateValidation = extractAttribute($arr[8], "DateValidation");
		} elseif (substr($arr[0], 0, 3) === 'ent') { // TO Check if it starts with ent like entry_dt, entdt, entrydt, etc
			//elseif ($arr[0] === 'entdt' || $arr[0] === 'entry_dt') yy
			// Default DateValidation string if $arr[0] is 'entdt'
			$DateValidation = "From=YearCode_Start&To=YearCode_End";
		}

		if(isset($DateValidation)){ 
			  
			// $DateValidation = extractAttribute($arr[8], "DateValidation");
			$DateValidationArr = explode('&', $DateValidation); 
			$sql = "select sdate,edate from AiYear where Label = '" . $_SESSION['dbYear'] . "'";
			$result = db::getInstanceMaster()->db_select($sql, "F-9703");
			// if($FormID == 3010)	print_r($result);
			$yearStartDate = $result['result_set'][0]['sdate'];
			$yearStartDate = $yearStartDate->format('Y-m-d');
			// if($FormID == 3010)	echo $yearStartDate;
			$yearEndDate = $result['result_set'][0]['edate'];
			$yearEndDate = $yearEndDate->format('Y-m-d');
			// if($FormID == 3010)	echo $yearEndDate;
			foreach ($DateValidationArr as $pair) { 
				list($key, $value) = explode('=', $pair); 
				// if($FormID == 2644)	echo $key . ',' . $value;
				if (strtolower($key) === 'from') { 
					$date_min = $value;
					if(strtolower($date_min) == 'yearcode_start'){
						$date_min = $yearStartDate;
					}
					if(strtolower($date_min) == 'yearcode_end'){
						$date_min = $yearEndDate;
					}
					if(strtolower($date_min) == 'today'){
						$date_min = date("Y-m-d");
					}
					if(strtolower($date_min) == 'tomorrow'){
						$date_min = date("Y-m-d",strtotime("tomorrow"));
					}
					if(strtolower($date_min) == 'yesterday'){
						$date_min = date("Y-m-d",strtotime("yesterday"));
					}
				} elseif (strtolower($key) === 'to') { 
					$date_max = $value; 
					if(strtolower($date_max) == 'yearcode_start'){
						$date_max = $yearStartDate;
					}
					if(strtolower($date_max) == 'yearcode_end'){
						$date_max = $yearEndDate;
					}
					if(strtolower($date_max) == 'today'){
						$date_max = date("Y-m-d");
					}
					if(strtolower($date_max) == 'tomorrow'){
						// $datetime = new DateTime('tomorrow');
						// $date_max = $datetime->format('Y-m-d H:i:s');
						$date_max = date("Y-m-d",strtotime("tomorrow"));
					}
					if(strtolower($date_max) == 'yesterday'){
						// $tmp = new DateTime(); 
						// $tmp->modify('-1 day');
						$date_max = date("Y-m-d",strtotime("yesterday"));
					}
				} 
			}
		}
				

		if(strlen($arr[31]) >= 1 && $arr[31] == 'today' && $arr[4] == ''){
			if($editID == 0){
				// echo "hi".$arr[31];
				// Check if $arr[4] is between $date_min and $date_max
				$tempDate = date('Y-m-d');
			
				if ($tempDate >= $date_min && $tempDate <= $date_max) {
					// $arr[4] is between $date_min and $date_max
					$arr[4] = $tempDate;
				}
			}
			
		}elseif(strlen($arr[31]) >= 1 && $arr[31] == 'tomorrow' && $arr[4] == ''){
			if($editID == 0){
				$datetime = new DateTime('tomorrow');
				$tempDate = $datetime->format('Y-m-d');
				if ($tempDate >= $date_min && $tempDate <= $date_max) {
					// $arr[4] is between $date_min and $date_max
					$arr[4] = $tempDate;
				}
			}
		}elseif($arr[4] != NULL ){
			if(gettype($arr[4]) == 'string'){
				$date = strtotime($arr[4]);
				$arr[4] = date('Y-m-d', $date);
			}else{
				$arr[4] = $arr[4]->format('Y-m-d');
			}
		}

		// ✅ If the field starts with "ent" and no date_min was set, default it to today
		if (substr(strtolower($arr[0]), 0, 3) === 'ent' && empty($arr[4])) {
			$dateObj = new DateTime();  // now
			$arr[4] = $dateObj->format('Y-m-d');
		}

		//If date coming 1900-01-01 like this then show empty date
		if($arr[4] == '1900-01-01' || $arr[4] == '01-01-1990'){
			$arr[4] = '';
		}
		
		//if arr[4] is within selected yearcode or not
		$flds .= "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." min='".$date_min."' max='".$date_max."' maxlength='4' pattern='\d{4}' class='form-control dyn1' value='".$arr[4]."' type='date'  ".$arr[6]." ".$otherInputParams." name='".$arr[0]."' id='".$arr[0]."' tabindex='".$arr[39]."'  ";
		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "readonly";
			}
		}

		// Add frontend validation using data-key
		if (substr($arr[0], 0, 3) === 'ent') { 
			$flds .= "data-kvalidation='true'";
		}

		//Check validation using sp on lost focus
		if($arr[35] == 1){
			$flds .= "onfocusout=\"validateOnLostFocusSp(this,0);\"";  //0 is gridid in form it is set as 0
		}

		//Once lost focus from perticular field then again don't allow to focus on this field
		if($arr[41] == 1){
			$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
		}
		
		$flds .="/></div>";
		return $flds;
	}

	if($arr[1] == 7){ 	//Number
		
		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}

		echo "<script>
			$(document).ready(function(){
				if('".$arr[39]."' == 1){
					$('#".$arr[0]."').focus();
				}
			});
		</script>";

		//If dependent field then call on blur
		if (strlen($arr[52]) > 1) {
			$dependentFields = explode("|",$arr[52]);
			echo "<script>
				$(document).ready(function() {";

					foreach ($dependentFields as $dependentField) {
						echo "$('#".$arr[0]."').on('blur', function(e) {
							onBlurClearDependentField(this, '" . trim($dependentField) . "');
						});";
					}

				echo "});
				</script>";
		}

		//If noneditable field added then call this function
		if (strlen($arr[53]) > 1) {
			$dependentFields = explode("|",$arr[53]);
			echo "<script>
				$(document).ready(function() {";

					foreach ($dependentFields as $dependentField) {
						echo "$('#" .$arr[0]. "').on('blur', function(e) {
							onBlurNonEditableFields(this, '" . trim($dependentField) . "');
						});";
					}

				echo "});
				</script>";
		}

		//Set default value
		if(strlen($arr[31]) >= 1 && $arr[4] == ''){
			if($editID == 0){
				$arr[4] = $arr[31];
			}
		}

	    // if(strcmp($arr[6], "maxlength=")) $maxChar = "maxlength='100'";    //ADDED FOR VAPT 
	    // else $maxChar = '';
		$flds .= "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." class='form-control dyn1' value='".$arr[4]."' type='number' ".$arr[6]." ".$otherInputParams." name='".$arr[0]."' id='".$arr[0]."' tabindex='".$arr[39]."'  ";
		
		if($arr[6] > 2){
			if(strpos($arr[6], 'step') !== false){
				$flds .= "onfocusout=\"isValidDigit('".$arr[6]."','".$arr[0]."');\"";
			}
		}
		

		if(strlen($arr[33]) > 2){
			$flds .= "onfocusout=\"isValidText('".$arr[33]."','".$arr[0]."');\"";
		}

		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "readonly";
			}
		}

		//Added for getting dynamic decimalplaces
		if($arr[44] != ''){
			$flds .=" data-key=\"".$arr[44]."\"";
		}

		//Check validation using sp on lost focus
		if($arr[35] == 1){
			$flds .= "onfocusout=\"validateOnLostFocusSp(this,0);\"";  //0 is gridid in form it is set as 0
		}

		//On keyup focus exicute formula calculation
		$onkeyupparameterHidden = "";
		if(strlen($arr[40]) > 5){
			$flds .= "onkeyup=\"CreateOnkeyupScriptGrid(this,'form');\""; //0 is gridid in form it is set as 0
			$onkeyupparameterHidden = '<input type="hidden" id="'.$arr[0].'-onkeyup-hidden" value="'.$arr[40].'">';
		}

		//Once lost focus from perticular field then again don't allow to focus on this field
		if($arr[41] == 1){
			$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
		}

		$flds .= "/>".$onkeyupparameterHidden."</div>";
		?>
		<script>
			$(document).ready(function(){
				document.getElementById(<?php echo "'".$arr[0]."'"; ?>).addEventListener('focus', function(event) {
					// Trigger selection on focus if Tab or Enter was used
					this.select();
				});
			});
		</script>
		<?php
		return $flds;
	}

	if($arr[1] == 8){ 	//Email
		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}

		echo "<script>
			$(document).ready(function(){
				if('".$arr[39]."' == 1){
					$('#".$arr[0]."').focus();
				}
			});
		</script>";

		//Set default value
		if(strlen($arr[31]) >= 1 && $arr[4] == ''){
			if($editID == 0){
				$arr[4] = $arr[31];
			}
		}

		$flds .= "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." class='form-control dyn1' ".$otherInputParams." value='".$arr[4]."' type='email' name='".$arr[0]."' id='".$arr[0]."'tabindex='".$arr[39]."'  ";
		if(strlen($arr[33]) > 2){
			$flds .= "onfocusout=\"isValidText('".$arr[33]."','".$arr[0]."');\"";
		}

		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "readonly";
			}
		}

		//Check validation using sp on lost focus
		if($arr[35] == 1){
			$flds .= "onfocusout=\"validateOnLostFocusSp(this,0);\"";  //0 is gridid in form it is set as 0
		}

		//Once lost focus from perticular field then again don't allow to focus on this field
		if($arr[41] == 1){
			$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
		}

		$flds .= "/></div>";
		return $flds;
	}

	if($arr[1] == 9){ 	//Checkbox-From-DB
		global $extradb;
		$eresult = array();
		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){
				// print_r($extradb);
				$edb = $extradb[$i][1];
				$eid = $extradb[$i][2];
				$elb = $extradb[$i][3];
				$end = $extradb[$i][4];
				$emnydb = $extradb[$i][6];
				$emnyid = $extradb[$i][7];
				$emnyfk = $extradb[$i][8];
				$eval = array();
				$esql = "SELECT ".$eid.",".$elb." FROM ".$edb . " " . $end;

				if($k_debug) echo '<br/>'.$esql.'<br/>';
				$eresult = db::getInstance()->db_select($esql, "F-10007: Cl-");
				if($k_debug){ echo '<br/>'; print_r($eresult); }
				break;
			}
		}

		if(sizeof($eresult) > 0){
			if(sizeof($eresult['result_set']) > 0){
				$m = $arr;
				$p = $arr[4];
				// print_r($p);
				$addNewFn = "";

    		if(extractAttribute($arr[8], "AddNewFn") !== null){     //FOR ADD NEW FUNCTION added on 23052023 for react cap api
    		    $AddNewFnName = extractAttribute($arr[8], "AddNewFn");
    		    $addNewFn = '<a style="padding:3px;" href="javascript:void(0)" class="btn btn-success" onclick="' . $AddNewFnName . '()">
    				<span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
    		} 		

				$flds = '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label>'.$addNewFn.'<br/><div class="multi-check" id="'.$arr[0].'-multi-div">';

				if(extractAttribute($arr[8], "TreeCheckbox") !== null){     //FOR ADD NEW FUNCTION added on 23052023 for react cap api
        		  //  $AddNewFnName = extractAttribute($arr[8], "TreeCheckbox");
        		  //  for($j = 0; $j < sizeof($eresult['result_set']); $j++){
    				// 	$k = $eresult['result_set'][$j][$eid];  //ID
    					/*[
					{title: "n1", expanded: true, key: "1", children: [
						{title: "n1.1 (selected)", key: "1.1"},
						{title: "n1.2", key: "1.2"},
						{title: "n1.3", key: "1.3"}
					]},
					{title: "n2", expanded: true, key: "2", children: [
						{title: "n2.1 (selected)", selected: true, key: "2.1"},
						{title: "n2.2", selected: false, key: "2.2"},
						{title: "n2.3", selected: null, key: "2.3"}
					]},
					{title: "n3", expanded: true, key: "3", children: [
						{title: "n3.1", expanded: true, key: "3.1", children: [
							{title: "n3.1.1 (unselectable)", unselectable: true, key: "3.1.1"},
							{title: "n3.1.2 (unselectable)", unselectable: true, key: "3.1.2"},
							{title: "n3.1.3", key: "3.1.3"}
						]},

						{title: "n3.2", expanded: true, key: "3.2", children: [
							{title: "n3.2.1 (unselectableStatus: true)", unselectableStatus: true, key: "3.2.1"},
							{title: "n3.2.2 (unselectableStatus: false)", unselectableStatus: false, key: "3.2.3"},
							{title: "n3.2.3", key: "3.2.3"}
						]},
						{title: "n3.3", expanded: true, key: "3.3", children: [
							{title: "n3.3.1 (unselectableStatus: true, unselectableIgnore)",
									unselectableStatus: true,  unselectableIgnore: true, key: "3.3.1"},
							{title: "n3.3.2 (unselectableStatus: false, unselectableIgnore)",
									unselectableStatus: false, unselectableIgnore: true, key: "3.3.2"},
							{title: "n3.3.3", key: "3.3.3"}
						]}
					]}
					]*/
    				// 	if($p == $k) {
    				// 		$flds .= '<label><input type="checkbox" checked '.$arr[6].' name="'.$m[0].'" id="'.$m[0].'" value="'. $k .'" >&nbsp;'.$eresult['result_set'][$j][$elb].'</label><br/>';
    				// 	}
    				// 	else { //CHANGED ON 03022020
    				// 		$flds .= '<label><input type="checkbox" '.$arr[6].' name="'.$m[0].'" id="'.$m[0].'" value="'. $k .'" >&nbsp;'.$eresult['result_set'][$j][$elb].'</label><br/>';
    				// 	}
    				// }

					if(1){
						$flds .= '
							<script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
							<script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
							<link href="fancytree/src/skin-win8/ui.fancytree.css" rel="stylesheet">
							<script src="fancytree/src/jquery.fancytree.js"></script>
							<link href="fancytree/lib/prettify.css" rel="stylesheet">
							<script src="fancytree/lib/prettify.js"></script>
							<script src="fancytree/src/jquery.fancytree.filter.js"></script>
							<style type="text/css">
								p.warning,
							p.info,
							div.info {
								font-size: small;
								background-color: #fff3cd;
								background-image: url(../doc/iconInfo_32x32.png);
								background-repeat: no-repeat;
								padding: 5px;
								padding-left: 40px;
								min-height: 25px;
							}
							.sampleButtonContainer
							{
								margin-right: 10px;
							}
							.sampleButtonContainer a
							{
								color: #212529;
								text-decoration: undereline;
								text-decoration-style: dotted;
								padding: 1px 3px;
								font-size: 70%;
							}
							.sampleButtonContainer button
							{
								margin-bottom: 3px;
							}
							p#sampleButtons h5
							{
								font-size: 9pt;
								margin-top: 3px;
								margin-bottom: 3px;
								font-weight: bold;
							}
							.description a,
							.description a:hover,
							.description a:visited,
							p.sample-links a,
							p.sample-links a:hover,
							p.sample-links a:visited
							{
								color: #212529;
							/* text-decoration: none; */
							text-decoration-style: dotted;
							/* font-weight: 600; */
							}

							.description a:hover,
							p.sample-links a:hover
							{
								text-decoration: underline;
							}
							p.sample-links a,
							p.sample-links a:hover,
							p.sample-links a:visited
							{
								margin-left: 15px;
								padding: 1px 3px;
								font-size: small;
							}
							pre{
							background:#f7f7f7;
							border:1px solid #999;
							padding:.5em;
							margin:.5em;
							font-size:.9em;
							}

							body.example button {
								display: inline-block;
								font-weight: 400;
								color: #212529;
								text-align: center;
								vertical-align: middle;
								-webkit-user-select: none;
								-moz-user-select: none;
								-ms-user-select: none;
								user-select: none;
								background-color: transparent;
								border: 1px solid transparent;
								padding: .375rem .75rem;
								font-size: 1rem;
								line-height: 1.5;
								border-radius: .25rem;
								transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
								/* small: */
								padding: .15rem .3rem;
								font-size: .675rem;
								line-height: 1.2;
								border-radius: .2rem;
								/* .btn-secondary */
								color: #fff;
								background-color: #6c757d;
								border-color: #6c757d;
							}
							[type=button]:not(:disabled), [type=reset]:not(:disabled), [type=submit]:not(:disabled), button:not(:disabled) {
							cursor: pointer;
							}

							body.example button:hover {
								text-decoration: none;
								/* .btn-secondary */
								background-color: #5a6268;
								border-color: #545b62;
							}

							body.example button:focus {
								box-shadow: 0 0 0 0.2rem rgba(130,138,145,.5);
							}

							body.example input[type=submit],
							body.example button[type=submit] {
								/* .btn-primary */
								color: #fff;
								background-color: #007bff;
								border-color: #007bff;
							}

							body.example input[type=submit]:hover,
							body.example button[type=submit]:hover {
								/* .btn-primary */
							background-color: #0069d9;
							border-color: #0062cc;
							}

							ul.fancytree-container {
								margin: 4px; /* leave some room for the safari focus border */
							}

							iframe.embedded-plunkr {
								border: 1px solid #f7f7f7;
								width: 100%;
								height: 500px;
							}

							iframe.embedded-jsbin {
								border: 1px solid #f7f7f7;
								width: 100%;
								height: 500px;
							}

							</style>

							<script type="text/javascript">
								(function ($) {
								var PLUGIN_NAME = "skinswitcher",
									defaultOptions = {
										base: "",
										choices: [],
										// extraChoices: [],
										// Events:
										change: $.noop,
									},
									methods = {
										init: function (options) {
											var i,
												opts = $.extend({}, defaultOptions, options),
												hrefs = [],
												$link = null,
												initialChoice;
											if (!this.length) {
												return this;
											}

											// Attach options to skinswitcher combobox for later access
											this.data("options", opts);
											// Find the <link> tag that is used to includes our skin CSS.
											// Add a class for later access.
											$.each(opts.choices, function () {
												hrefs.push(this.href.toLowerCase());
											});

											$("head link").each(function () {
												for (i = 0; i < hrefs.length; i++) {
													if (this.href.toLowerCase().indexOf(hrefs[i]) >= 0) {
														$link = $(this);
														$link.addClass(PLUGIN_NAME);
														initialChoice = opts.choices[i];
													}
												}
											});
											if (!$link) {
												$link = $("link." + PLUGIN_NAME);
											}

											if (!$link.length) {
												$.error(
													"Unable to find <link> tag for skinswitcher. Either set `href` to a known skin url or add a `skinswitcher` class."
												);
											}
											//
											return this.each(function () {
												// Add options to dropdown list
												var $combo = $(this);
												$combo
													.empty()
													.skinswitcher("addChoices", opts.choices)
													.change(function (event) {
														var choice = $(":selected", this).data("choice");
														$("link." + PLUGIN_NAME).attr(
															"href",
															opts.base + choice.href
														);
														opts.change(choice);
													});
												// Find out initial selection
												if (opts.init) {
													$combo.val(opts.init).change();
												} else if (initialChoice) {
													// select combobox value to match current <link> tag
													// decouple this call to prevent IE6 exception
													setTimeout(function () {
														$combo.val(initialChoice.value);
														opts.change(initialChoice);
													}, 100);
												}
											});
										},
										option: function (name, value) {
											var opts = this.data("options");
											if (typeof value !== "undefined") {
												opts[name] = value;
												return this;
											}
											return opts[name];
										},
										addChoices: function (choices) {
											var $combo = $(this);
											if ($.isPlainObject(choices)) {
												choices = [choices];
											}
											$.each(choices, function (i, choice) {
												var $opt = $("<option>", {
													text: choice.name,
													value: choice.value,
												}).data("choice", choice);
												$combo.append($opt);
											});
											return this;
										},
										change: function (value) {
											$(this).val(value).change();
											return this;
										},
										reset: function () {
											$(this).val("").change();
											return this;
										},
									};

								$.fn[PLUGIN_NAME] = function (method) {
									// Method calling logic
									if (methods[method]) {
										return methods[method].apply(
											this,
											Array.prototype.slice.call(arguments, 1)
										);
									} else if (typeof method === "object" || !method) {
										return methods.init.apply(this, arguments);
									}
									$.error(
										"Method " + method + " does not exist on jQuery." + PLUGIN_NAME
									);
								};
							})(jQuery);

							/**
							* Replacement for $().toggle(func1, func2), which was deprecated with jQuery 1.8
							* and removed in 1.9.;
							* Taken from http://stackoverflow.com/a/4911660/19166
							* By Felix Kling
							*/
							(function ($) {
								var SAMPLE_BUTTON_DEFAULTS = {
									id: undefined,
									label: "Sample",
									newline: true,
									code: function () {
										alert("not implemented");
									},
								};
								$.fn.clickToggle = function (func1, func2) {
									var funcs = [func1, func2];
									this.data("toggleclicked", 0);
									this.click(function () {
										var data = $(this).data(),
										tc = data.toggleclicked;
										$.proxy(funcs[tc], this)();
										data.toggleclicked = (tc + 1) % 2;
									});
									return this;
								};

								window.getUrlVars = function () {
									var vars = {};
									window.location.href.replace(
										/[?&]+([^=&]+)=([^&]*)/gi,
										function (m, key, value) {
											vars[key] = value;
										}
									);
									return vars;
								};
								window.getUrlParam = function (parameter, defaultvalue) {
									var urlparameter = defaultvalue;
									if (window.location.href.indexOf(parameter) > -1) {
										urlparameter = window.getUrlVars()[parameter];
									}
									return urlparameter;
								};
								window.addSampleButton = function (options) {
									var sourceCode,
										opts = $.extend({}, SAMPLE_BUTTON_DEFAULTS, options),
										$buttonBar = $("#sampleButtons"),
										$container = $("<span />", {
											class: "sampleButtonContainer",
										});

									$("<button />", {
										id: opts.id,
										title: opts.tooltip,
										text: opts.label,
									})
										.click(function (e) {
											e.preventDefault();
											opts.code();
										})
										.appendTo($container);
									$("<a />", {
										text: "Source code",
										href: "#",
										class: "showCode",
									})
										.appendTo($container)
										.click(function (e) {
											try {
												prettyPrint();
											} catch (e2) {
												alert(e2);
											}
											var $pre = $container.find("pre");
											if ($pre.is(":visible")) {
												$(this).text("Source code");
											} else {
												$(this).text("Hide source");
											}
											$pre.toggle("slow");
											return false;
										});
									sourceCode = "" + opts.code;
									// Remove outer function(){ CODE }
									//    sourceCode = sourceCode.match(/[]\{(.*)\}/);
									sourceCode = sourceCode.substring(
										sourceCode.indexOf("{") + 1,
										sourceCode.lastIndexOf("}")
									);
									//    sourceCode = $.trim(sourceCode);
									// Reduce tabs from 8 to 2 characters
									sourceCode = sourceCode.replace(/\t/g, "  ");
									// Format code samples
									$("<pre />", {
										text: sourceCode,
										class: "prettyprint",
									})
										.hide()
										.appendTo($container);
									if (opts.newline) {
										$container.append($("<br />"));
									}
									if (opts.header) {
										$("<h5 />", { text: opts.header }).appendTo($("p#sampleButtons"));
									}
									if (!$("#sampleButtons").length) {
										$.error(
											"addSampleButton() needs a container with id #sampleButtons"
										);
									}
									$container.appendTo($buttonBar);
								};

								function initCodeSamples() {
									var info,
										$source = $("#sourceCode");

										$("#codeExample").clickToggle(
										function () {
											$source.show("fast");
											if (!this.old) {
												this.old = $(this).html();
												$.get(
													this.href,
													function (code) {
														// Remove <!-- Start_Exclude [...] End_Exclude --> blocks:
														code = code.replace(
															/<!-- Start_Exclude(.|\n|\r)*?End_Exclude -->/gi,
															"<!-- (Irrelevant source removed.) -->"
														);

														// Reduce tabs from 8 to 2 characters
														code = code.replace(/\t/g, "  ");
														$source.text(code);
														// Format code samples
														try {
															prettyPrint();
														} catch (e) {
															alert(e);
														}
													},
													"html"
												);
											}
											$(this).html("Hide source code");
										},

										function () {
											$(this).html(this.old);
											$source.hide("fast");
										}
									);
									if (jQuery.ui) {
										info =
											"Fancytree " +
											jQuery.ui.fancytree.version +
											", jQuery UI " +
											jQuery.ui.version +
											", jQuery " +
											jQuery.fn.jquery;
										$("p.sample-links").after(
											"<p class=\'version-info\'>" + info + "</p>"
										);
									}
								}

								$(function () {
									if (top.location === window.location) {
										$(".hideOutsideFS").hide();
									} else {
										$(".hideInsideFS").hide();
									}
									initCodeSamples();
									$("select#skinswitcher")
										.skinswitcher({
											base: "fancytree/src/",
											choices: [
												{
													name: "XP",
													value: "xp",
													href: "skin-xp/ui.fancytree.css",
												},
												{
													name: "Vista (classic Dynatree)",
													value: "vista",
													href: "skin-vista/ui.fancytree.css",
												},
												{
													name: "Win7",
													value: "win7",
													href: "skin-win7/ui.fancytree.css",
												},
												{
													name: "Win8",
													value: "win8",
													href: "skin-win8/ui.fancytree.css",
												},
												{
													name: "Win8-N",
													value: "win8n",
													href: "skin-win8-n/ui.fancytree.css",
												},
												{
													name: "Win8 xxl",
													value: "win8xxl",
													href: "skin-win8-xxl/ui.fancytree.css",
												},
												{
													name: "Lion",
													value: "lion",
													href: "skin-lion/ui.fancytree.css",
												},
											],
											change: function (choice) {
												$("#connectorsSwitch").toggle(choice.value !== "xp");
											},
										})
										.after($("<label id=\'connectorsSwitch\'><input name=\'cbConnectors\' type=\'checkbox\'>Connectors</label>"));
									$("input[name=cbConnectors]").on("change", function (e) {
										$(".fancytree-container").toggleClass("fancytree-connectors",$(this).is(":checked"));
									});
								});
							})(jQuery);

							</script>

							<script type="text/javascript">
								$(function(){
									$("#btnDeselectAll3").click(function(){
										$.ui.fancytree.getTree("#tree3").selectAll(false);
										return false;
									});
									$("#btnSelectAll3").click(function(){
										$.ui.fancytree.getTree("#tree3").selectAll();
										return false;
									});

									$("#btnGetSelected3").click(function(){
										var selNodes = $.ui.fancytree.getTree("#tree3").getSelectedNodes();
										var selData = $.map(selNodes, function(n){
											return n.toDict();
										});

										// alert(JSON.stringify(selData));
										return false;
									});

									$("#tree3").fancytree({
										checkbox: true,
										selectMode: 3,
										extensions: ["filter"],
										quicksearch: true,
										filter: {
											autoApply: true,   // Re-apply last filter if lazy data is loaded
											autoExpand: true, // Expand all branches that contain matches while filtered
											counter: true,     // Show a badge with number of matching child nodes near parent icons
											fuzzy: false,      // Match single characters in order,
											hideExpandedCounter: true,  // Hide counter badge if parent is expanded
											hideExpanders: false,       // Hide expanders if all child nodes are hidden by filter
											highlight: true,   // Highlight matches by wrapping inside <mark> tags
											leavesOnly: false, // Match end nodes only
											nodata: true,      // Display a no data status node if result is empty
											mode: "dimm"       // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
										},

										icon: false,
										source:[], /*
										source: [
											{title: "n1", expanded: true, key: "1", children: [
												{title: "n1.1 (selected)", key: "1.1"},
												{title: "n1.2", key: "1.2"},
												{title: "n1.3", key: "1.3"}
											]},

											{title: "n2", expanded: true, key: "2", children: [
												{title: "n2.1 (selected)", selected: true, key: "2.1"},
												{title: "n2.2", selected: false, key: "2.2"},
												{title: "n2.3", selected: null, key: "2.3"}
											]},

											{title: "n3", expanded: true, key: "3", children: [
												{title: "n3.1", expanded: true, key: "3.1", children: [
													{title: "n3.1.1 (unselectable)", unselectable: true, key: "3.1.1"},
													{title: "n3.1.2 (unselectable)", unselectable: true, key: "3.1.2"},
													{title: "n3.1.3", key: "3.1.3"}
												]},

												{title: "n3.2", expanded: true, key: "3.2", children: [
													{title: "n3.2.1 (unselectableStatus: true)", unselectableStatus: true, key: "3.2.1"},
													{title: "n3.2.2 (unselectableStatus: false)", unselectableStatus: false, key: "3.2.3"},
													{title: "n3.2.3", key: "3.2.3"}
												]},

												{title: "n3.3", expanded: true, key: "3.3", children: [
													{title: "n3.3.1 (unselectableStatus: true, unselectableIgnore)",
															unselectableStatus: true,  unselectableIgnore: true, key: "3.3.1"},
													{title: "n3.3.2 (unselectableStatus: false, unselectableIgnore)",
															unselectableStatus: false, unselectableIgnore: true, key: "3.3.2"},

													{title: "n3.3.3", key: "3.3.3"}
												]}
											]}
											],*/

										init: function(event, data) {
											data.tree.visit(function(n) { n.expanded = true; });
										},

										select: function(event, data) {
											var selKeys = $.map(data.tree.getSelectedNodes(), function(node){ return node.key; });
											$("#echoSelection3").text(selKeys.join(", "));
											$("#'.$m[0].'").val(selKeys.join(", "));
											var selRootNodes = data.tree.getSelectedNodes(true);
											console.log(selRootNodes);
											var selRootKeys = $.map(selRootNodes, function(node){ return node.key; });
											// console.log(selRootKeys);
											$("#echoSelectionRootKeys3").text(selRootKeys.join(", "));
										},

										cookieId: "fancytree-Cb3",
										idPrefix: "fancytree-Cb3-"
									});
		
									$("input[name=fancyTreeCBSearch]").on("change search", function(e){

										if (e.type === "change" && e.target.onsearch !== undefined ) { return; }
										var n, tree = $.ui.fancytree.getTree(),
										match = $.trim($(this).val());
										n = tree.filterNodes(match, { mode: "hide" });
									$("span.matches").text(n ? "(" + n + " matches)" : "");
									});
								});

							</script>

						<div class="cbtree" style="display:none;">
							<p><a href="#" id="btnSelectAll3">Select all</a> - <a href="#" id="btnDeselectAll3">Deselect all</a> - <a href="#" id="btnGetSelected3">Get selected</a></p>
							<label for="filter">Filter:</label>
							<input type="search" name="fancyTreeCBSearch" incremental placeholder="Search text" autocomplete="off">
							<span class="matches"></span>
							<div>Selected keys: <span id="echoSelection3">-</span></div>
							<input type="text" name="'.$m[0].'" id="'.$m[0].'" value="'. $k .'" />
							<div>Selected root keys: <span id="echoSelectionRootKeys3">-</span></div>
						</div>
						<div id="tree3"></div>';
					}
        		}else{ //END OF ADDED FOR CHECKBOX TREE 31052023
					// echo "<br>";
					// print_r($arr);
					
    				for($j = 0; $j < sizeof($eresult['result_set']); $j++){
						$k = $eresult['result_set'][$j][$eid];  //ID
						
						$flag = 0;
						if(!(is_null($p) || $p == "")) {
							for($g = 0; $g < sizeof($p); $g++){
								if($k == $p[$g][$emnyfk]){
									$flag = 1;
									break;
								}
							}
						}
						
    					if($flag) {
    						$flds .= '<label><input type="checkbox" checked ".$otherInputParams." '.$arr[6].' name="'.$m[0].'[]" id="'.$m[0].'" value="'. $k .'" tabindex="'.$arr[39].'">&nbsp;'.$eresult['result_set'][$j][$elb].'</label><br/>';
    					}
    					else { //CHANGED ON 03022020
    						$flds .= '<label><input type="checkbox" '.$arr[6].' name="'.$m[0].'[]" id="'.$m[0].'" value="'. $k .'" tabindex="'.$arr[39].'">&nbsp;'.$eresult['result_set'][$j][$elb].'</label><br/>';
    					}
    				}
        		}
				$flds .= '</div></div>';
				return $flds;
			}else{
				return null;
			}
		}else{
			return null;
		}
	}

	if($arr[1] == 10){ 	//MULTI SELECT SEARCH from DB
        /*HEADER
            $k_head_include = '
                <link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
                <link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
                <link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />'; */
        /*FOOTER
            $k_footer_before = '
            <script src="assets/vendor/select2/js/select2.js"></script>
            <script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>';		*/

		global $extradb;
		$eresult = array();
		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){
				$edb = $extradb[$i][1];
				$eid = $extradb[$i][2];
				$elb = $extradb[$i][3];
				$eval = array();
				$esql = "SELECT ".$eid.",".$elb." FROM ".$edb;// . " " . $end;

				if($k_debug) echo '<br/>'.$esql.'<br/>';
				$eresult = db::getInstance()->db_select($esql, "F-10752: Cl-");
				if($k_debug){ echo '<br/>'; print_r($eresult); }

				break;
			}
		}
		//print_r($eresult);
		if(sizeof($eresult) > 0){
			if(sizeof($eresult['result_set']) > 0){
				//print_r($arr);
				$m = $arr;
				$p = $arr[4]; //print_r($eresult);
				$flds = '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label><select multiple data-plugin-selectTwo '.$reqf.' name="'.$m[0].'[]" id="'.$m[0].'" class="form-control populate" '.$arr[6].' tabindex="'.$arr[39].'">';

				for($j = 0; $j < sizeof($eresult['result_set']); $j++){
					$k = $eresult['result_set'][$j][$eid];  //ID
					$flag = 0;
					//echo "HHHH";
					// print_r($p);
					if(!empty($p)){
						for($g = 0; $g < sizeof($p); $g++){
							if($k == $p[$g][$extradb[0][2]]){
								$flag = 1;
								break;
							}
						}
					}

					if($flag) {
						$flds .= '<option selected value="'. $k .'" >'.$eresult['result_set'][$j][$elb].'</option>&nbsp;';
					}
					else {
						$flds .= '<option value="'. $k .'" >'.$eresult['result_set'][$j][$elb].'</option>&nbsp;';
					}
				}

				$flds .= '</select></div>';
				return $flds;

			}else{
				return null;
			}
		}else{
			return null;
		}
	}

	if($arr[1] == 11){ 	//MULTI SELECT SEARCH from DB WITH MAPPING TABLE
		global $extradb;
		$eresult = array();

		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){

				$edb = $extradb[$i][1];
				$eid = $extradb[$i][2];
				$elb = $extradb[$i][3];
				$end = $extradb[$i][4];
				$ear = $extradb[$i][5];
				$emnydb = $extradb[$i][6];
				$emnyid = $extradb[$i][7];
				$emnyfk = $extradb[$i][8];
				
				$eval = array();
				
				$esql = "SELECT ".$eid.",".$elb." FROM ".$edb;// . " " . $end;
			
				if($k_debug) echo '<br/>'.$esql.'<br/>';
							
				$eresult = db::getInstance()->db_select($esql, "F-10821: Cl-");
				
				
				if($k_debug){ echo '<br/>'; print_r($eresult); }
				break;
			}
		}

		$m = $arr;
		$p = $arr[4]; 
		
		$addNewFn = "";

		if(extractAttribute($arr[8], "AddNewFn") !== null){     //FOR ADD NEW FUNCTION added on 23052023 for react cap api

		    $AddNewFnName = extractAttribute($arr[8], "AddNewFn");
		    $addNewFn = '<a style="padding:3px;" href="javascript:void(0)" class="btn btn-success" onclick="' . $AddNewFnName . '()">

				<span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span></a>';
		}

		$flds = '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label>&nbsp;'.$addNewFn.' ';

		if($edb != ''){
			$DDSearchPreLoadedArray = [];
			$DDSearchPreLoadedData = '';
			$ddsql = "SELECT TOP 10 ".$elb." FROM ". $edb;
			$ddresult = db::getInstance()->db_select($ddsql, "F-10848: Cl-");
			if($ddresult){
				for($i=0; $i < count($ddresult['result_set']); $i++){
					array_push($DDSearchPreLoadedArray,$ddresult['result_set'][$i][$elb]);
				}
				$DDSearchPreLoadedData = implode(',',$DDSearchPreLoadedArray);
				
				echo "<script>
						$(document).ready(function(){
							var finalParams = ['".$eid."','".$elb."'];
							var DDSearchMinInputLen = [];

							if('".$arr[29]."' > 0){
								DDSearchMinInputLen['".$m[0]."'] = '".$arr[29]."';
							}else{
								DDSearchMinInputLen['".$m[0]."'] = 3;
							}

							var DDSearchPreLoadedData = [];
							var DDSearchPreLoadedDataString = [];
						
							DDSearchPreLoadedData['".$m[0]."'] = '".json_encode($DDSearchPreLoadedData)."';
							if(DDSearchPreLoadedData['".$m[0]."'].length > 0){
								DDSearchPreLoadedDataString['".$m[0]."'] = ' or more char (like: '+ DDSearchPreLoadedData['".$m[0]."'] +')';
							}else{
								DDSearchPreLoadedDataString['".$m[0]."'] = ' char ';
							}

							$('#".$m[0]."').select2({
								//tags: true,
								multiple: true,
								tokenSeparators: [',', ' '],
								debug: true,
									placeholder: 'select',
								//allowClear: true,
								minimumInputLength: DDSearchMinInputLen['".$m[0]."'],
								language: {
									inputTooShort: function() {
										return 'Enter ' + DDSearchMinInputLen['".$m[0]."'] + ' '+ DDSearchPreLoadedDataString['".$m[0]."'] ;
									}
								},
								//minimumResultsForSearch: 10,
								ajax: {
									url: 'getDropDownValue.php',
									dataType: 'json',
									type: 'POST',
									data: function (params) {
										console.log(params.term);
										var queryParameters = {
											flag: 0
											,searchText: params.term
											,searchParam:'".$elb."'
											,fromRepo:'".$edb."'
											,responseParams:finalParams.toString()
										}
										return queryParameters;
									},
									processResults: function (data) {
										if(data['data'].length == 0){
											$('#".$m[0]."').val('');//.trigger('change')
										}
										return {
											results: $.map(data['data'], function (item) {
												// console.log(ddVal);
												//console.log(item[0].Label);
												return {													
													text: item.ddVal,	
													id: item.ddID
												}
											})
										};
									}
								}
							});

							// var selectElement1 = $('#".$m[0]."');
							// $.ajax({
							// 	type : 'POST',
							// 	dataType: 'json',
							// 	data : {flag: 1,searchParam:'".$elb."',fromRepo:'".$edb."',responseParams:finalParams.toString()},
							// 	url : 'getDropDownValue.php',
							// 	success : function(data){
							// 		// console.log(data['data']);
							// 		var option = [];
							// 		for(var i=0; i< data['data'].length; i++){
							// 			option[i] = new Option(data['data'][i].ddVal, data['data'][i].ddID, false, false);
							// 			// console.log(option[i]);
							// 			selectElement1.append(option[i]).trigger('change');
							// 		}
							// 	}
							// })

						});
					</script>";
			}
		}

		$flds .= '<select multiple '.$reqf.' name="'.$m[0].'[]" id="'.$m[0].'" class="form-control populate" '.$arr[6].' tabindex="'.$arr[39].'" ';
		
		if(strlen($arr[28]) == 0){
			$flds .= ' data-plugin-selectTwo';
		}

		$flds .= '>';

		if(sizeof($eresult) > 0){

			if(sizeof($eresult['result_set']) > 0){

				for($j = 0; $j < sizeof($eresult['result_set']); $j++){

					$k = $eresult['result_set'][$j][$eid];  //ID
					$flag = 0;

					if(!(is_null($p) || $p == "")) {

						for($g = 0; $g < sizeof($p); $g++){

							if($k == $p[$g][$emnyfk]){

								$flag = 1;
								break;
							}
						}
					}

					if($flag) {

						$flds .= '<option selected value="'. $k .'" >'.$eresult['result_set'][$j][$elb].'</option>&nbsp;';

					}else{
						if(strlen($arr[28]) == 0){
							$flds .= '<option value="'. $k .'" >'.$eresult['result_set'][$j][$elb].'</option>&nbsp;';
						}

					}
				}
			}
		}
		$flds .= '</select></div>';
		return $flds;
	}

	if($arr[1] == 12){ 	//SINGLE IMAGE UPLOAD 
	    return "<div class='".$divClass."'><label class='custom-file-upload' tabindex='".$arr[39]."'><i class='fa fa-cloud-upload'></i> ".$arr[2].$reqv." <input type='file' ".$arr[6]." name='".$arr[0]."[]' id='".$arr[0]."' ".$arr[6]." />".$arr[4]."</label></div>";
		//return "<div class='col-md-4'><label>".$arr[2].$reqv."</label><input type='file' ".$arr[6]." name='".$arr[0]."[]' id='".$arr[0]."[]' ".$arr[6]."/>".$arr[4]."</div>";
	}

	if($arr[1] == 13){ 	//MULTIPLE IMAGE UPLOAD 
		return "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input style='display: block;' type='file' ".$arr[6]." name='".$arr[0]."[]' id='".$arr[0]."' ".$arr[6]." multiple='true' tabindex='".$arr[39]."'/>".$arr[4]."</div>";
	}

	if($arr[1] == 14){ 	//GRID
	    //IGNORE THIS ELEMENT 
	}	
	
	if($arr[1] == 15){ 	//Toggle Switch
		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		} 

		//If Default value set 1 then toggle is active
		if(strlen($arr[31]) >= 1 && strlen($arr[4]) == 0){
			if($editID == 0){
				$arr[4] = $arr[31];
			}
		}

		$flds = "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><br /><div class='switch switch-sm switch-primary' ";
		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "style=\"pointer-events:none\";";
			}
		}
		$flds .=">";

		$flds .= "<input type='checkbox' name='".$arr[0]."' id='".$arr[0]."' value='1' data-plugin-ios-switch=''  style='display: none;' tabindex='".$arr[39]."' ";
		if($arr[4] == 1){
			$flds .= "checked='checked'";
		}

		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "style=\"pointers-event:none;\"";
			}
		}
	
		$flds .= "></div></div>";
		return $flds;
	}
	

	if($arr[1] == 16){ //Multiselect Popup Datatable
		

		global $extradb;
		$eresult = array();
	    // print_r($arr);
		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){

				$edb = $extradb[$i][1];
				$eid = $extradb[$i][2];
				$elb = $extradb[$i][3];
				$end = $extradb[$i][4];
				$ear = $extradb[$i][5];
				$emnydb = $extradb[$i][6];
				$emnyid = $extradb[$i][7];
				$emnyfk = $extradb[$i][8];
				
				$eval = array();

				if(strlen($end) > 2){

					$esql = "SELECT ".$eid.",".$elb." FROM ".$edb . " " . $end;
					
					if($k_debug) echo '<br/>'.$esql.'<br/>';
					// echo "<br>".$esql;
					// echo "hi";exit();
					
					$eresult = db::getInstance()->db_select($esql, "F-11074: Cl-");
					
					if($k_debug){ echo '<br/>'; print_r($eresult); }
					break;
				}
			}
		}

		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				$fld16String = $_SESSION['carryOn'][$arr[0]];
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = array();
					$carryOnArray = array();
					$carryOnArray = explode(",", $fld16String);
				
					for($j=0; $j<sizeof($carryOnArray); $j++){
						
						$esql1 = "SELECT ".$eid.",".$elb." FROM ".$edb . " WHERE " . $eid."=".$carryOnArray[$j];
						$eresult1 = db::getInstance()->db_select($esql1, "F-11094: Cl-");
						
						array_push($arr[4],array($emnyfk=>$eresult1['result_set'][0][$eid],$elb=>$eresult1['result_set'][0][$elb]));
						
					}
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		} 


		$m = $arr;
		$mapTableValue = [];
		$mapTableID = [];
		$mTValue = '';
		$mTID = '';
		
		if(is_array($arr[4])){
			for($i=0; $i<sizeof($arr[4]); $i++){
				array_push($mapTableValue, $arr[4][$i][$elb]);
				array_push($mapTableID, $arr[4][$i][$emnyfk]);
			}
			$mTValue = implode(',', $mapTableValue);
			$mTID = implode(',', $mapTableID);
		}

		// $flds = "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." readonly type='text' name='".$arr[0]."-text' id='MultyDDModal-".$m[0]."'  data-tag-class='badge badge-primary' class='form-control' value='".$mTValue."' style='cursor: pointer;
		// background-color: white;' tabindex='".$arr[39]."' ";

		//Once lost focus from perticular field then again don't allow to focus on this field
		// if($arr[41] == 1){
		// 	$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
		// }
		
		// $flds .= "><input type='hidden' id='MultyDDModal-hidden-".$m[0]."' name='".$arr[0]."' value='".$mTID."'></div> ";
		
		$flds .= '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label><input type="button" '.$reqf.' data-type="'.$arr[1].'" onclick="toggleModal(event)" class="form-control" tabindex="'.$arr[39].'" name="'.$arr[0].'-text" id="'.$m[0].'-text" value="'.$mTValue.'" data-label="'.$arr[2].'" ';

		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "style=\"pointers-event:none;text-align:left;\"";
			}
		}
		
		$SPName = 'sp_GetData_'.$FormID.'_'.$arr[0];
		$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
		$checkSp = db::getInstance()->db_select($sql, "F-11140: Cl-");
		if($checkSp['result_set'][0]['found'] == 1){
			$flds .=" data-systemtype=\"2\"";
		}else{
			$flds .=" data-systemtype=\"1\"";
		}
		
		$flds .= ' style="text-align: left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis">';
		$flds .= '<input type="hidden" id="'.$m[0].'" name="'.$arr[0].'" value="'.$mTID.'"></div>';

		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				// $flds .= " style=\"pointers-event:none;\"";
				echo '<script>
					document.addEventListener("DOMContentLoaded", function() {
						$("#'.$m[0].'-text").css({"pointer-events": "none","background-color": "#eee"});
					});				
				</script>';
			}
		}

		//response{ID | Name } url { https://krdemo.kreonsolutions.in/getSender.php} parameters{ID: Sender}
		echo $ddtableIncludes;
		echo "
		<script>
		$(document).ready(function(){

			//Onload if tabindex is 1 then set focus
			if('".$arr[39]."' == 1){
				$('#MultyDDModal-".$m[0]."').focus();
			}

			$('#MultyDDModal-".$m[0]."').keypress(function(e) {
				if(e.which == 13) {
					$('#MultyDDModal-". $m[0]."').click();
				}
			});
		});

		</script>";

		?>
		<script>

			$(document).ready(function () {
				// Focus on the open button after the modal is shown
				// $('#'+<?php echo "'$arr[0]-text'"; ?>).focus(function() {
				// 	toggleModal();
				// });

				$('#'+<?php echo "'$arr[0]-text'"; ?>).keypress(function(e) {
					if(e.which == 13) {
						$('#'+<?php echo "'$arr[0]-text'"; ?>).click();
					}
				});
			});

			//On escape button press cursor move to next tabindex field
			$('#myModal').on('hidden.bs.modal', function (e) {
				console.log("escape");
				hasMoreData = false;
				$('#myModal .modal-body').off('scroll');
				console.log("escape hasMoreData",hasMoreData);
				var currentFieldId = $('#DropDownModalID').val();

				if(<?php echo "'".$arr[0]."-text'"; ?> == currentFieldId){
					//If noneditable field added then call this function
					<?php
						if (strlen($arr[53]) > 1) {
							$dependentFields = explode("|", $arr[53]);
							$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
							foreach ($dependentFields as $dependentField) {
								echo "
										onBlurNonEditableFields($('#{$sourceId}'), '" . trim($dependentField) . "');
									
								";
							}
						}
					?>

					//If dependent field then call on blur
					<?php
						if (strlen($arr[52]) > 1) {
							$dependentFields = explode("|",$arr[52]);
							$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
							foreach ($dependentFields as $dependentField) {
								echo "
									onBlurClearDependentField($('#{$sourceId}'), '" . trim($dependentField) . "');
								";
							}
						}
					?>

					//Check validation using sp on lost focus
					if(<?php echo $arr[35]; ?> == 1){
						validateOnLostFocusSp(<?php echo "'".$m[0]."'"; ?>,0); //0 is gridid in form it is set as 0
					}

					//Once lost focus from perticular field then again don't allow to focus on this field
					if(<?php echo $arr[41]; ?> == 1){
						if($("#"+<?php echo "'".$arr[0]."'"; ?>).val() != ''){
							onBlurUpdateLostFocusTabIndex(<?php echo "'".$arr[0]."'"; ?>,<?php echo $arr[1]; ?>);
						}
					}

					var tabindex = $('#'+currentFieldId).attr("tabindex");
					tabindex++;
					// console.log("'#DropDownModal' .on('hidden.bs.modal', function")
					$("[tabindex='"+tabindex+"']").focus();
				}
			})
		</script>
		<?php

		return $flds;

		$ddtableIncludes = "";
	}
	
	if($arr[1] == 17){ //Single-select Popup Datatable
		global $extradb;

		
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}
		
		$eresult = array();
		
		$p = $arr[4];
		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){

				$edb = $extradb[$i][1];
				$eid = $extradb[$i][2];
				$elb = $extradb[$i][3];
				$end = $extradb[$i][4];
				$ear = $extradb[$i][5];
				$emnydb = $extradb[$i][6];
				$emnyid = $extradb[$i][7];
				$emnyfk = $extradb[$i][8];
				
				$eval = array();

				if($p){

					$esql = "SELECT ".$eid.",".$elb." FROM ".$edb;
					if(strlen($end) > 1){
						$esql .= " ".$end;
					}else{
						$esql .= " WHERE 1=1";
					}
					$esql .= " AND ".$eid ."='". $p ."'" ;

					// if($FormID == 5258){
					// 	echo $esql;
						
					// }
					

					if($k_debug) echo '<br/>'.$esql.'<br/>';
	
					$eresult = db::getInstance()->db_select($esql, "F-11304: Cl-");
					if($k_debug){ echo '<br/>'; print_r($eresult); }
				}

				//Query for Default value
				if(strlen($arr[31]) > 0 ){
					if($editID == 0){
						$esql1 = "SELECT ".$eid.",".$elb." FROM ".$edb . " where 1=1 ";
						// check if it's a CASE condition
						if (stripos($arr[31], "case") === 0) {
							// starts with CASE => use directly

							// replace placeholders dynamically
							$st = replaceSqlPlaceholders($arr[31]);
							
							$esql1 .= " AND ".$eid ."=". $st;
						}else{
							$esql1 .= " AND ".$eid ."=". $arr[31];
						}
						
						$eresult1 = db::getInstance()->db_select($esql1, "F-11324: Cl-");
						$eresult['result_set'][0][$elb] = $eresult1['result_set'][0][$elb];
						$eresult['result_set'][0][$eid] = $eresult1['result_set'][0][$eid];

					}
				}

				break;
			}
		}
		
		$m = $arr;
		$mapTableValue = [];
		$mapTableID = [];
		$mTValue = '';
		$mTID = '';
		// echo gettype($arr[4]);
		// if($arr[4]){
		// 	$rsql = "SELECT ".$eid.",".$elb." FROM ".$edb . " where " . $eid . " = " . $arr[4];
		// 	$rresult = db::getInstance()->db_select($rsql);
		// 	$mTValue = $rresult['result_set'][0][$elb];
		// 	$mTID = $rresult['result_set'][0][$eid];
		// }

		// $flds = "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." readonly type='text'  name='".$arr[0]."-text' id='SingleDDModal-".$m[0]."'  data-tag-class='badge badge-primary' class='form-control' value='".$eresult['result_set'][0][$elb]."' style='cursor: pointer;
		// background-color: white;' tabindex='".$arr[39]."' ";

		//Once lost focus from perticular field then again don't allow to focus on this field
		// if($arr[41] == 1){
		// 	$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
		// }
		
		// $flds .= "><input type='hidden' id='SingleDDModal-hidden-".$m[0]."' name='".$arr[0]."' value='".$eresult['result_set'][0][$eid]."'></div> ";
		
		$flds .= '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label><input type="button" data-type="'.$arr[1].'" onclick="toggleModal(event)" class="form-control" tabindex="'.$arr[39].'" name="'.trim($arr[0]).'-text" id="'.trim($arr[0]).'-text" '.$reqf.' value="'.$eresult['result_set'][0][$elb].'" data-label="'.$arr[2].'" ';
		
		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "style=\"pointers-events:none;background-color:#eee;text-align:left;\"";
			}
		}
		$SPName = 'sp_GetData_'.$FormID.'_'.$m[0];
		$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
		$checkSp = db::getInstance()->db_select($sql, "F-11367: Cl-");
		if($checkSp['result_set'][0]['found'] == 1){
			$flds .=" data-systemtype=\"2\"";
		}else{
			$flds .=" data-systemtype=\"1\"";
		}
		
		$flds .= ' style="text-align: left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis">';
		$flds .= '<input type="hidden" id="'.trim($m[0]).'" name="'.trim($arr[0]).'" value="'.(isset($eresult['result_set'][0][$eid]) ? $eresult['result_set'][0][$eid] : '').'"></div>';

		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				// $flds .= " style=\"pointers-event:none;\"";
				echo '<script>
					document.addEventListener("DOMContentLoaded", function() {
						$("#'.$m[0].'-text").css({"pointer-events": "none","background-color": "#eee"});
					});
				</script>';
			}
		}

		//response{ID | Name } url { https://krdemo.kreonsolutions.in/getSender.php} parameters{ID: Sender}
		echo $ddtableIncludes;
		echo "
		<script>
		$(document).ready(function(){
			//Onload if tabindex is 1 then set focus
			if('".$arr[39]."' == 1){
				$('#".$m[0]."-text').focus();
			}

			$('#".$m[0]."-text').keypress(function(e) {
				if(e.which == 13) {
					$('#". $m[0]."-text').click();
				}
			});
		});

		</script>";

		?>
		<script>
			$(document).ready(function () {
				// Focus on the open button after the modal is shown
				// $('#'+<?php echo "'$arr[0]-text'"; ?>).focus(function() {
				// 	toggleModal();
				// });			
			});

			//On escape button press cursor move to next tabindex field
			$('#myModal').on('hidden.bs.modal', function (e) {
				hasMoreData = false;
				$('#myModal .modal-body').off('scroll');
				console.log("escape hasMoreData",hasMoreData);
				var currentFieldId = $('#DropDownModalID').val();
				if(<?php echo "'".$arr[0]."-text'"; ?> == currentFieldId){
					//If noneditable field added then call this function
					<?php
						if (strlen($arr[53]) > 1) {
							$dependentFields = explode("|", $arr[53]);
							$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
							foreach ($dependentFields as $dependentField) {
								echo "
										onBlurNonEditableFields($('#{$sourceId}'), '" . trim($dependentField) . "');
									;
								";
							}
						}
					?>

					//If dependent field then call on blur
					<?php
						if (strlen($arr[52]) > 1) {
							$dependentFields = explode("|",$arr[52]);
							$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
							foreach ($dependentFields as $dependentField) {
								echo "
									onBlurClearDependentField($('#{$sourceId}'), '" . trim($dependentField) . "');
								";
							}
						}
					?>

					var tabindex = $('#'+currentFieldId).attr("tabindex");
					tabindex++;

					// Once lost focus from perticular field then again don't allow to focus on this field
					if(<?php echo $arr[41]; ?> == 1){
						console.log('in 41');
						if($("#"+<?php echo "'".$arr[0]."-text'"; ?>).val() != ''){
							onBlurUpdateLostFocusTabIndex(<?php echo "'".$arr[0]."-text'"; ?>,<?php echo $arr[1]; ?>);
						}
					}

					//Check validation using sp on lost focus
					if(<?php echo $arr[35]; ?> == 1){
						validateOnLostFocusSp(<?php echo "'".$m[0]."'"; ?>,0); //0 is gridid in form it is set as 0
					}
					
					setTimeout(
						function() {
							console.log("Line 6401 focus")
							$("[tabindex='"+tabindex+"']").focus();
						}, 300);
				}

				
			})
		</script>
		<?php
		return $flds;

		$ddtableIncludes = "";
	}

    if($arr[1] == 18){ //TIME
		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}   

		// if($arr[4] != NULL){
		// 	if(gettype($arr[4]) == 'string'){
		// 		$date = strtotime($arr[4]);
		// 		$arr[4] = date('h:i', $date);
		// 	}else{
		// 		$arr[4] = $arr[4]->format('h:i');
		// 	}
		// }

		$flds .= "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." class='form-control dyn1' value='".$arr[4]."' type='text' id='time' ".$arr[6]." ".$otherInputParams." name='".$arr[0]."' id='".$arr[0]."' tabindex='".$arr[39]."' ";

		// $flds .= "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." class='form-control dyn1' value='".$arr[4]."' type='time' ".$arr[6]." ".$otherInputParams." name='".$arr[0]."' id='".$arr[0]."' ";
		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "readonly";
			}
		}

		//Check validation using sp on lost focus
		if($arr[35] == 1){
			$flds .= "onfocusout=\"validateOnLostFocusSp(this,0);\""; //0 is gridid in form it is set as 0
		}

		//Once lost focus from perticular field then again don't allow to focus on this field
		if($arr[41] == 1){
			$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,$arr[1]);\"";
		}

		return $flds .= "/></div>";
	}
	
	if($arr[1] == 19){ 	//SELECT from DB
		global $extradb;

		//carry on fields
		if(isset($_SESSION['carryOn'])){
			if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
				if(isset($_SESSION['carryOn'][$arr[0]])){
					$arr[4] = $_SESSION['carryOn'][$arr[0]];
					unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
				}
			}
		}

		$eresult = array();
        $m = $arr;
		$p = $arr[4];
		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){
				$edb = $extradb[$i][1];
				$eid = $extradb[$i][2];
				$elb = $extradb[$i][3];
				// $end = $extradb[$i][4];
				$end = checkVariable($extradb[$i][4]);
				$eval = array();
				
                $esql = "SELECT ".$eid.",".$elb." FROM ".$edb;
				if(strlen($end) > 1){
					$esql .= " ".$end;
				}

				$esql .= " ORDER BY ".$elb;

                if($k_debug) echo '<br/>'.$esql.'<br/>';

                $eresult = db::getInstance()->db_select($esql, "F-11555: Cl-");
            
				if($k_debug){ echo '<br/>'; print_r($eresult); }
				
				break;
			}
		}

		//Default value set exicute
		if(strlen($arr[31]) > 0 ){
			if($editID == 0){
				$p = $arr[31];
			}
		}

			
		//print_r($p);
		$flds = '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label>';
		
		if($arr[23] > 0){	
			$flds .= '<button type="button" id="AddBtnModal-'.$m[0].'"  value="'.$arr[23].'-'.$m[0].'-'.$formType.'" class="amodal" style="background: transparent;border: none !important;font-size:1;color:blue"><i class="fa fa-plus-circle"></i></button>';
		}

		//If dependent field added then call this function
		if (strlen($arr[52]) > 1) {
			$dependentFields = explode("|",$arr[52]);
			echo "<script>
				$(document).ready(function() {";

					foreach ($dependentFields as $dependentField) {
						echo "$('#".$m[0]."').on('select2:select', function(e) {
							onBlurClearDependentField(this, '" . trim($dependentField) . "');
						});";
					}

				echo "});
				</script>";
		}
		
		echo "<script>
			$(document).ready(function(){

				// $('#".$m[0]."').on('select2:select', function (e) { // select option by enter then cursor going to next field
				// 	var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
				// 	focusable = form.find('input,a,select,button,textarea').filter(':visible');
				// 	next = focusable.eq(focusable.index(this)+1);
				// 	if (next.length) {
				// 		next.focus();
				// 	} 
				// 	return false;
				// });

				//Once lost focus from perticular field then again don't allow to focus on this field
				if('".$arr[41]."' == 1){
					$('#".$m[0]."').on('select2:select', function (e) {
						onBlurUpdateLostFocusTabIndex(this,'".$arr[1]."');
					});
				}

				if('".$arr[39]."' == 1){
					setTimeout(
						function() {
							console.log('Line 4547 Focus');
							$('#".$m[0]."').next('span').find('.select2-selection--single').focus();
						}, 300);
				}
			});
		</script>";

		?>

		<script>
			if(<?php echo $arr[39]; ?> == 1){
				var tabindex1 = <?php echo $arr[39]; ?>;
				tabindex1++;
				// alert(tabindex1);
				console.log("Line 6539 focus")
				$("[tabindex='"+tabindex1+"']").focus();
			}	
		</script>

		<?php

			
		$flds .= '<select data-plugin-selectTwo '.$reqf.' name="'.$m[0].'" id="'.$m[0].'" class="form-control populate" tabindex="'.$arr[39].'" ';


		if($arr[17] == 1){
			$onchange = " onchange=\"CreateOnchangeScript(this, '".$arr[1]."');\"";
			$flds .= $onchange;
			$onchangeHidden = '<input type="hidden" id="'.$m[0].'-hidden" value="' . $arr[18] . '" />';
		}

		if($arr[32] == 1){ //to check if field editable
			if($editID > 0){
				$flds .= "style=\"pointers-event:none;\"";
			}
		}

		//Check validation using sp on lost focus
		if($arr[35] == 1){
			$flds .= "onchange=\"validateOnLostFocusSp(this,0);\"";  //0 is gridid in form it is set as 0
		}
		
		//Check validation using sp onChange
		if($arr[36] == 1){
			$flds .= "onchange=\"validateOnChangeSp(this,0);\""; //0 is gridid in form it is set as 0
		}

		if($arr[12] == 1){ //to check if field readonly
			echo '<script>
				setTimeout(
					function() {
						$("#'.$m[0].'").next("span").find(".select2-selection--single").css("pointer-events","none").css("background","#eee");
					}, 300);
			</script>';
		}

		$flds .= '><option value=""></option>'; 

		$flds .= '>'; 
		// $flds .= '><option value="0"></option>'; 

		// if(strlen($arr[6]) > 4){
			
		// 	//Use for get conditional data
		// 	echo "<script>
		// 	$(document).ready(function(){
		// 		$('#".$m[0]."').on('select2:open', function (e) {
		// 			var str1 = 'parameters';
		// 			var parametersPos = -1;
		// 			var thissParameters = '".$arr[6]."';
		// 			if(thissParameters.indexOf(str1) != -1){
		// 				parametersPos = thissParameters.indexOf(str1);
		// 			}

		// 			if(parametersPos != -1){
		// 				var parametersParams = thissParameters.substring(
		// 					thissParameters.indexOf('{') + 1, 
		// 					thissParameters.lastIndexOf('}')
		// 				);
		// 			}

		// 			if(parametersParams.length > 3){
		// 				var hidden = $('form').find(':hidden');	
		// 				hidden.show();   
		// 				var  formSerialize = $('form').serialize();	
		// 				hidden.hide(); 	

		// 				$.ajax({
		// 					type : 'POST',
		// 					dataType: 'json',
		// 					data : {FieldOtherCondition : '".$arr[6]."', gridSerial:0,searchText: formSerialize, GridID:0, dbarray0: '".$edb."', dbarray1:'".$eid."', dbarray2: '".$elb."', dbarray3: '".$end."'},
		// 					url : 'getPreLoadedDropDownValue.php',
		// 					success : function(result){
		// 						var newOption = '';
		// 						$('#".$m[0]."').empty().trigger('change');

		// 						for(var j=0; j < result['data'].length; j++){ 
		// 							newOption += '<option value=\"'+result['data'][j]['".$eid."']+'\">'+result['data'][j]['".$elb."']+'</option>';
		// 							/* var newOption = $('<option ></option>').val(result['data'][j]['".$eid."']).text(result['data'][j]['".$elb."']) */
		// 						}	
		// 						$('#".$m[0]."').append(newOption).trigger('change');

								
		// 					}
		// 				});
		// 			}
		// 		});
		// 	});
		// 	</script>";
		// }else{
			if(sizeof($eresult) > 0){
				if(sizeof($eresult['result_set']) > 0){
					for($j = 0; $j < sizeof($eresult['result_set']); $j++){
						$k = $eresult['result_set'][$j][$eid];  //ID	
	
						if($p == $k) {
							$flds .= '<option selected value="'. $k .'" >'.$eresult['result_set'][$j][$elb].'</option>&nbsp;';
						}
						else {
							$flds .='<option value="'. $k .'" >'.$eresult['result_set'][$j][$elb].'</option>&nbsp;';
						}
					}
				}
			}
		// }


		$flds .= '</select>'.$onchangeHidden.'</div>';

		return $flds;
	}

	if($arr[1] == 20){ 	//Session Default hidden
		global $viewSettings;
		
		if (strpos($viewSettings[8], $arr[0]) !== false){
			$sessionVariable = extractParameters($viewSettings[8]);
			return "<input value='".$sessionVariable."' type='hidden' ".$arr[6]." name='".$arr[0]."' />";
		}else{
			return "<input value='0' type='hidden' ".$arr[6]." name='".$arr[0]."' />";
		}
	}

	if($arr[1] == 21){ 	//Section Open
		return '<div class="'.$divClass.'">
		            <div class="toggle toggle-primary" data-plugin-toggle>
						<section class="toggle active">
							<label style="margin:0;">'.$arr[2].'</label>
							<div class="toggle-content">';
	}

	if($arr[1] == 22){ 	//Section Close
	    return "</div></section></div></div>";
	}

	
	// if($arr[1] == 23){  //GRID Multiselect Popup Datatable
	// 	global $extradb;

	// 	$eresult = array();
	// 	// print_r($extradb);
	// 	for($i = 0; $i < sizeof($extradb); $i++){
	// 		if($extradb[$i][0] == $arr[3]){

	// 			$edb = $extradb[$i][1];
	// 			$eid = $extradb[$i][2];
	// 			$elb = $extradb[$i][3];
	// 			$end = $extradb[$i][4];
	// 			$ear = $extradb[$i][5];
	// 			$emnydb = $extradb[$i][6];
	// 			$emnyid = $extradb[$i][7];
	// 			$emnyfk = $extradb[$i][8];
				
	// 			$eval = array();

	// 			$esql = "SELECT ".$eid.",".$elb." FROM ".$edb . " " . $end;
				
	// 			if($k_debug) echo '<br/>'.$esql.'<br/>';
				
	// 			$eresult = db::getInstance()->db_select($esql);
				
	// 			if($k_debug){ echo '<br/>'; print_r($eresult); }
	// 			break;
	// 		}
	// 	}
		
	// 	$m = $arr;
	// 	$mapTableValue = [];
	// 	$mapTableID = [];
	// 	$mTValue = '';
	// 	$mTID = '';
	
	// 	if(is_array($arr[4])){
	// 		for($i=0; $i<sizeof($arr[4]); $i++){
	// 			array_push($mapTableValue, $arr[4][$i][$elb]);
	// 			array_push($mapTableID, $arr[4][$i][$emnyfk]);
	// 		}
	// 		$mTValue = implode(',', $mapTableValue);
	// 		$mTID = implode(',', $mapTableID);
	// 	}
		

	// 	$flds  .= '<button type="button"  id="GridMultyDDModal-'.$m[0].'" >'.$arr[2].'</button>';
	// 	$flds .= "<input type='hidden' id='GridMultyDDModal-hidden-".$m[0]."' name='".$arr[0]."' value='".$mTID."'>";
	// 	$flds .= "<input type='hidden' id='MultiSelectGridId-hidden-".$m[0]."' name='".$arr[0]."' value='".$arr[34]."'>";


	// 	// $flds = "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." readonly type='text' name='".$arr[0]."-text' id='MultyDDModal-".$m[0]."'  data-tag-class='badge badge-primary' class='form-control' value='".$mTValue."' style='cursor: pointer;
	// 	// background-color: white;'><input type='hidden' id='MultyDDModal-hidden-".$m[0]."' name='".$arr[0]."' value='".$mTID."'></div> ";
		
	// 	//response{ID | Name } url { https://krdemo.kreonsolutions.in/getSender.php} parameters{ID: Sender}
	// 	echo $ddtableIncludes;
	// 	echo "
	// 		<script>
	// 			$(document).ready(function(){
	// 				$('#GridMultyDDModal-".$m[0]."').keypress(function(e) {
	// 					if(e.which == 13) {
	// 						$('#GridMultyDDModal-". $m[0]."').click();
	// 					}
	// 				});

	// 				$('#GridMultyDDModal-". $m[0]."').click(function(){
	// 					$('#modalLabelLarge').text('Multiple selection Dropdown');				
	// 					$('#DropDownModal').modal('show');
	// 					jqxhr = $.ajax('getMultyDDValue1.php?FormID=".$FormID."&GridID=0&DBFieldName=". $m[0]."&DBFieldType=23&isGrid=0')
	// 					.done(function () {
	// 							tableName= '#ddTable',
	// 							data1 = JSON.parse(jqxhr.responseText);
							
	// 							DBFieldName='". $m[0]."';
	// 							DBFieldType ='23';
	// 							FormID = '".$FormID."';
	// 							GridID = 0;
	// 							isGrid = '0';
								
	// 							var row = '<tr>';
	// 							var rowFilter = '<tr class=\"headerFilter\">';
	// 							$.each(data1.columns, function (k, colObj) {
									
	// 								row += '<th>' + colObj.name + '</th>';
	// 								var searchColName = colObj.name.trim();
	// 								if(k == 0){
	// 									rowFilter += '<th></th>';
	// 								}else{
	// 									rowFilter += '<th><input type=\"search\" class=\"form-control\" onkeydown=\"SearchFunction(event,DBFieldName,DBFieldType,FormID,GridID,isGrid)\" placeholder=' + searchColName + ' id='+searchColName+' name='+searchColName+'></th>';
	// 								}
									
	// 							});
	// 							rowFilter += '</tr>';
	// 							row += '</tr>';
	// 							if ($.fn.dataTable.isDataTable('#ddTable')) {
	// 								//console.log('In data');
	// 								$('#ddTable').DataTable().destroy();
	// 							}
	// 							$('#ddTable').html('<thead></thead>');
	// 							$('#ddTable thead').html(row + rowFilter);
	// 							$('.headerFilter th:first').hide();

								
	// 							var is_variable='';
	// 							var is_value='';
	// 							$('#PopulateGridButton').hide();
	// 							// console.log('calling load_dd 5771');
	// 							load_dd(DBFieldName,DBFieldType,FormID,GridID,isGrid);
	// 						});
	// 				});
	// 			});
	// 		</script>";
	// 	return $flds;

	// 	$ddtableIncludes = "";
	// }

	if($arr[1] == 23){  //GRID Multiselect Popup Datatable
		global $extradb;

		$eresult = array();
		// print_r($extradb);
		for($i = 0; $i < sizeof($extradb); $i++){
			if($extradb[$i][0] == $arr[3]){

				$edb = $extradb[$i][1];
				$eid = $extradb[$i][2];
				$elb = $extradb[$i][3];
				$end = $extradb[$i][4];
				$ear = $extradb[$i][5];
				$emnydb = $extradb[$i][6];
				$emnyid = $extradb[$i][7];
				$emnyfk = $extradb[$i][8];
				
				$eval = array();

				$esql = "SELECT ".$eid.",".$elb." FROM ".$edb . " " . $end;
				
				if($k_debug) echo '<br/>'.$esql.'<br/>';
				
				$eresult = db::getInstance()->db_select($esql, "F-11913: Cl-");
				
				if($k_debug){ echo '<br/>'; print_r($eresult); }
				break;
			}
		}
		
		$m = $arr;
		$mapTableValue = [];
		$mapTableID = [];
		$mTValue = '';
		$mTID = '';
	
		if(is_array($arr[4])){
			for($i=0; $i<sizeof($arr[4]); $i++){
				array_push($mapTableValue, $arr[4][$i][$elb]);
				array_push($mapTableID, $arr[4][$i][$emnyfk]);
			}
			$mTValue = implode(',', $mapTableValue);
			$mTID = implode(',', $mapTableID);
		}
		

		// $flds  .= '<button type="button"  id="GridMultyDDModal-'.$m[0].'" >'.$arr[2].'</button>';
		// $flds .= "<input type='hidden' id='GridMultyDDModal-hidden-".$m[0]."' name='".$arr[0]."' value='".$mTID."'>";
		// $flds .= "<input type='hidden' id='MultiSelectGridId-hidden-".$m[0]."' name='".$arr[0]."' value='".$arr[34]."'>";

		$flds  .= '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label><input type="button" data-type="'.$arr[1].'" onclick="toggleModal(event)" class="form-control" tabindex="'.$arr[39].'" name="'.$arr[0].'-text" id="'.$arr[0].'-text" style="text-align: left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis"></div>';

		// $flds = "<div class='".$divClass."'><label>".$arr[2].$reqv."</label><input ".$reqf." readonly type='text' name='".$arr[0]."-text' id='MultyDDModal-".$m[0]."'  data-tag-class='badge badge-primary' class='form-control' value='".$mTValue."' style='cursor: pointer;
		// background-color: white;'><input type='hidden' id='MultyDDModal-hidden-".$m[0]."' name='".$arr[0]."' value='".$mTID."'></div> ";
		
		//response{ID | Name } url { https://krdemo.kreonsolutions.in/getSender.php} parameters{ID: Sender}
		echo $ddtableIncludes;
		// echo "
		// 	<script>
		// 		$(document).ready(function(){
		// 			$('#GridMultyDDModal-".$m[0]."').keypress(function(e) {
		// 				if(e.which == 13) {
		// 					$('#GridMultyDDModal-". $m[0]."').click();
		// 				}
		// 			});

		// 			$('#GridMultyDDModal-". $m[0]."').click(function(){
		// 				$('#modalLabelLarge').text('Multiple selection Dropdown');				
		// 				$('#DropDownModal').modal('show');
		// 				jqxhr = $.ajax('getMultyDDValue1.php?FormID=".$FormID."&GridID=0&DBFieldName=". $m[0]."&DBFieldType=23&isGrid=0')
		// 				.done(function () {
		// 						tableName= '#ddTable',
		// 						ddResponseData = JSON.parse(jqxhr.responseText);
							
		// 						DBFieldName='". $m[0]."';
		// 						DBFieldType ='23';
		// 						FormID = '".$FormID."';
		// 						GridID = 0;
		// 						isGrid = '0';
								
		// 						var row = '<tr>';
		// 						var rowFilter = '<tr class=\"headerFilter\">';
		// 						$.each(ddResponseData.columns, function (k, colObj) {
									
		// 							row += '<th>' + colObj.name + '</th>';
		// 							var searchColName = colObj.name.trim();
		// 							if(k == 0){
		// 								rowFilter += '<th></th>';
		// 							}else{
		// 								rowFilter += '<th><input type=\"search\" class=\"form-control\" onkeydown=\"SearchFunction(event,DBFieldName,DBFieldType,FormID,GridID,isGrid)\" placeholder=' + searchColName + ' id='+searchColName+' name='+searchColName+'></th>';
		// 							}
									
		// 						});
		// 						rowFilter += '</tr>';
		// 						row += '</tr>';
		// 						if ($.fn.dataTable.isDataTable('#ddTable')) {
		// 							//console.log('In data');
		// 							$('#ddTable').DataTable().destroy();
		// 						}
		// 						$('#ddTable').html('<thead></thead>');
		// 						$('#ddTable thead').html(row + rowFilter);
		// 						$('.headerFilter th:first').hide();

								
		// 						var is_variable='';
		// 						var is_value='';
		// 						$('#PopulateGridButton').hide();
		// 						// console.log('calling load_dd 5771');
		// 						load_dd(DBFieldName,DBFieldType,FormID,GridID,isGrid);
		// 					});
		// 			});
		// 		});
		// 	</script>";

		?>

		<script>
			$(document).ready(function () {
				// Focus on the open button after the modal is shown
				// $('#'+<?php echo "'$arr[0]-text'"; ?>).focus(function() {
					
				// 	toggleModal();
				// });		
				
				$('#'+<?php echo "'$arr[0]-text'"; ?>).on('focus', function(e) {
					toggleModal(e); // Use the event object from the handler
				});
			});
		</script>

		<?php

		return $flds;

		$ddtableIncludes = "";
	}

	if($arr[1] == 24){  //Button on click call sp & set data into grid
		global $extradb;
				
		
		$fieldotherconditions = "'".$arr[6]."'";


			if (stripos($fieldotherconditions, 'openLinkParameters') !== false) {
				$tableName = '';
				$TablePK = '';
				$isButton = false;

				// Case-insensitive match for openLinkButtonCondition block
				if (preg_match('/openLinkButtonCondition\{([^}]*)\}/i', $fieldotherconditions, $matches)) {
					$params = explode(',', $matches[1]);
					foreach ($params as $param) {
						$parts = array_map('trim', explode('=', $param));
						if (count($parts) == 2) {
							if (strcasecmp($parts[0], 'TableName') == 0) {
								$tableName = $parts[1];
							} elseif (strcasecmp($parts[0], 'TablePK') == 0) {
								$TablePK = $parts[1];
							}elseif (strcasecmp($parts[0], 'isButton') == 0) {
								if($parts[1] == 'true'){
									$isButton = true;
								}else{
									$isButton = false;
								}
							}
						}
					}
				}

				if ($tableName && $TablePK) {
					$checkAdjAvailable = "SELECT * FROM $tableName WHERE $TablePK = $editID";
					$resultCheckAdjAvailable = db::getInstance()->db_select($checkAdjAvailable, "F-12060: Cl-");
				}

				// Extract openLinkUrl{} content
				if (preg_match('/openLinkUrl\{([^}]*)\}/i', $fieldotherconditions, $matches)) {
					$urlParts = explode('|', $matches[1]);
					foreach ($urlParts as $part) {
						[$key, $val] = array_map('trim', explode('=', $part));
						if (strcasecmp($key, 'ModuleType') == 0) $moduleType = $val;
						if (strcasecmp($key, 'urlData') == 0) $urlData = $val;
						if (strcasecmp($key, 'Target') == 0) $Target = $val;
					}

					// Now fetch URL using ModuleType
					if ($moduleType) {
						$getUrlQuery = "SELECT * FROM Master_ModuleType WHERE ID=$moduleType";
						$getUrl = db::getInstanceMaster()->db_select($getUrlQuery, "F-12076");
						// Assume result stored in $urlFromDB
						// Mock value for example
						$urlFromDB = $getUrl['result_set'][0]['url']; // Replace this with fetched URL from DB
						// urlData agar empty nahi hai to usi ko use karo, warna adjustmentFormId append karo
						if (!empty($urlData)) {
							$url = $urlData;
						} else {
							$url = $urlFromDB . "' + $('#adjustmentFormId').val() + '";
						}
						// $url = $urlFromDB . $urlData;
						$windowTarget = $Target;
					}

				}

				// Extract openLinkParameters{} content
				if (preg_match('/openLinkParameters\{([^}]*)\}/i', $fieldotherconditions, $matches)) {
					$paramParts = explode('|', $matches[1]);
					foreach ($paramParts as $param) {
						[$key, $val] = array_map('trim', explode(':', $param));
						$parameters[$key] = $val;
					}
				}

				// print_r($resultCheckAdjAvailable);
				
				$flds = '<div class="'.$divClass.'" ><label></label><button id="'.$arr[0].'" class="btn btn-default"  type="button" tabindex="'.$arr[39].'"';
				if($isButton){
					$flds .= 'style="font-size: 12px;padding: 3px 16px;  height: 26px !important; padding: 1px 2px !important; font-size: 12px !important;"';
				}else{
					$flds .= 'style="pointer-events: none; opacity: 0.6;font-size: 12px;padding: 3px 16px;  height: 26px !important; padding: 1px 2px !important; font-size: 12px !important;"';
				}
				$flds .= '>';
				if(isset($resultCheckAdjAvailable)){
					if($resultCheckAdjAvailable['num_rows'] == 0)
					{
						$flds .= 'AddAdjustment';
					}else{
						$flds .= 'EditAdjustment';
					}
				}else{
					$flds .= $arr[2];
				}
				$flds .= '</button></div>';
			}else{
				if($arr[0] == 'downloadgstr1' || $arr[0] == 'downloadgstr2'){
					if($arr[0] == 'downloadgstr1'){
						$caseCondition = 'gstr1';
					}else{
						$caseCondition = 'gstr2';
					}
					// SpName{sp_GenerateGSTR1Excel_5182} FormParameters{entrydt|Period} GridResponse{} PopulateField{} PopulateGrid{} cursor{} Type{GSTR1}
					$flds = '<div class="'.$divClass.'" ><label></label><button id="'.$arr[0].'" onclick="getEinvoiceDetails(\''.$caseCondition.'\')" class="btn btn-default" style="display: block;font-size: 12px;padding: 3px 16px;  height: 26px !important; padding: 1px 2px !important; font-size: 12px !important;" type="button" tabindex="'.$arr[39].'"';
					$flds .= '>'.$arr[2].'</button></div>';
					return $flds;
				}else{
					$flds = '<div class="'.$divClass.'" ><label></label><button id="'.$arr[0].'" class="btn btn-default" style="display: block;font-size: 13px;padding: 3px 8px;min-height: 30px;line-height: normal;white-space: normal;width: auto;color:white;border-color:#09284e;background-color:#09284e;" type="button" tabindex="'.$arr[39].'"';
					$flds .= '>'.$arr[2].'</button></div>';
				}
			}

			

			echo $ddtableIncludes;
			echo "
				<script>
					$(document).ready(function(){
						$('#".$arr[0]."').keypress(function(e) {
							if(e.which == 13) {
								$('#". $arr[0]."').click();
							}
						});

						$('#". $arr[0]."').click(function(){
							console.log('else');

							var FieldOtherCondition = '".str_replace("'","\'",json_encode($arr[6]))."';
							var newArr = ['', ''];

							// console.log('fieldotherconditions',FieldOtherCondition.length,FieldOtherCondition);
							if(FieldOtherCondition.length == 2){
								var baseUrl = window.location.origin + window.location.pathname +'?form='+$('#adjustmentFormId').val()+'&preview='+$('#entryid').val();
								console.log(baseUrl);
								window.location.href = baseUrl;
								return;
							}

							if (FieldOtherCondition.includes('openLinkParameters')) {
								var url = '".$url."'; 
								var FormID = '".$FormID."'; 

								// Dynamically build parameters
								const postData = {";
								if($resultCheckAdjAvailable['num_rows'] != 0){
									echo "editID: '".$resultCheckAdjAvailable['result_set'][0]['id']."',";
								}
								echo "previousFormID: '".$FormID."',";
								foreach ($parameters as $key => $val) {
									if(strlen($val) > 1){

										if (preg_match('/^[A-Z_][A-Za-z0-9_]*$/', $val)) {
											echo "\n\t\t\t\t$key: $val,";
										} else {
											echo "\n\t\t\t\t$key: $('#$val').val(),";
										}
									}
								}
								echo "
								};

								var windowOptions;
								if ('".$target."' === 'newwindow') {
									windowOptions = 'width=800,height=600,resizable=yes,scrollbars=yes';
								} else if ('".$target."' === 'newtab') {
									windowOptions = '_blank'; // new tab
								} else {
									windowOptions = '_self'; // sametab
								}
								console.log(url, postData, windowOptions);
								openWindowWithPost(url, postData, windowOptions);
									
							}else{
			
								$.ajax({
									type : 'POST',
									dataType: 'json',
									data : {FieldOtherCondition : FieldOtherCondition, FormID : '".$FormID."'},
									url : 'getFieldType24Data.php',
									success : function(result){
									console.log(result);
										if(result['FormParameters'] != null && result['FormParameters'].length > 0){
				
											var extractedparameters = result['FormParameters'].split('|');
											var extractParameters = [];
											var requestParams = '';
				
											for(var i=0; i<extractedparameters.length; i++){
												console.log(extractedparameters[i]);
												extractParameters = extractedparameters[i].split(':');
												requestParams += extractParameters[0]+':';
												if(extractParameters[0].trim().length > 1){
													var NumberOfElements = document.querySelectorAll('[id='+extractParameters[0]+']');	
													console.log('NumberOfElements '+NumberOfElements.length);
													if(NumberOfElements.length == 2){
														if(extractParameters[1] == 17){
															requestParams += $(NumberOfElements[1]).val() !='' ? $(NumberOfElements[1]).val().trim() : '0';
														}else if(extractParameters[1] == 16){
															requestParams += $(NumberOfElements[1]).val() !='' ? $(NumberOfElements[1]).val().trim() : '0';
														}else{
															requestParams += $(NumberOfElements[1]).val() !='' ? $(NumberOfElements[1]).val().trim() : '0';
														}
													}else{
														if(extractParameters[1] == 17){
															requestParams += $('#'+extractParameters[0].trim()).val() !='' ? $('#'+extractParameters[0].trim()).val() : '0';

														}else if(extractParameters[1] == 16){
															requestParams += $('#'+extractParameters[0].trim()).val() !='' ? $('#'+extractParameters[0].trim()).val() : '0';

														}else{
															requestParams += $('#'+extractParameters[0].trim()).val() !='' ? $('#'+extractParameters[0].trim()).val() : '0';
														}
													}
													if(i != extractedparameters.length-1){
														requestParams += '|';
													}
												}
											}
										}
										console.log('requestParams '+requestParams);

										CallSpForFieldType24(requestParams,result['GridResponse'],result['SpName'],result['PopulateGridID'],$('input[name=editID]').val(),'".$_SESSION['user_id']."',result['GridId'],result['PopulateField'],result['Type']);
										
										//If dependent field then call on blur
										if ('".strlen($arr[52]) ."' > 1) {
											$(document).ready(function() {
												var dependentFields = '{$arr[52]}'.split('|'); // JS split
												dependentFields.forEach(function(field) {
													field = field.trim();
													onBlurClearDependentField(this, field);
													
												});

											});	
										}
									}
								});
							}


						});
					});
				</script>";
				?>
		
				<script>
					var pressedButtonId='';
					// Capture the button ID when a button is clicked to trigger saveAdjAmtButton button
					if(<?php echo "'".$arr[0]."'"; ?> == 'bankreco' || <?php echo "'".$arr[0]."'"; ?> == 'bankreco1'){
						$('#saveAdjAmtCloseButton').on('click', function() {
							pressedButtonId = $(this).attr('id');
						});
					}

					//On escape button press cursor move to next tabindex field
					$('#myModal').on('hidden.bs.modal', function (e) {
						var currentFieldId = $('#DropDownModalID').val();
						if(<?php echo "'".$arr[0]."'"; ?> == currentFieldId){
							// alert("hi",pressedButtonId);
							if(<?php echo "'".$arr[0]."'"; ?> == 'bankreco1'){
					
								saveBankRecoDetails();
								// if( pressedButtonId == ""){
									// $('#saveBankRecoDetails').click();
								// }else{
								// 	pressedButtonId = "";
								// }
							}
						}
					});
				</script>
		<?php
		return $flds;
	}

	

	if($arr[1] == 25){  //HTML DIV
		global $extradb;

		$flds  .= '<div class="col-md-12" id="'.$arr[0].'" style="margin-top:10px;"></div>';

		return $flds;
	}


	if($arr[1] == 27){  // Label with Button triggering Bootstrap Modal

			//Set default value
			if(strlen($arr[31]) > 0 && $arr[4] == ""){
				$arr[4] = $arr[31];
			}

			$flds .= '<div class="'.$divClass.'"><label>'.$arr[2].$reqv.'</label><input type="text" class="form-control open-popup" onclick="openCustomPopup(\''.$arr[0].'\',\''.$arr[6].'\')" data-popup-id="'.$arr[0].'" data-extra="'.$arr[6].'"  style="text-align: left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis;"
			name="'.$arr[0].'" id="'.$arr[0].'" '.$arr[6].' value="'.$arr[4].'" tabindex="'.$arr[39].'" readonly /></div>';
			return $flds;
			?>
			<script>
				//On escape button press cursor move to next tabindex field
				$('#popupGrid').on('hidden.bs.modal', function (e) {
					var currentFieldId = $('#popupGridID').val();
					if(<?php echo "'".$arr[0]."'"; ?> == currentFieldId){
						//If noneditable field added then call this function
						<?php
							if (strlen($arr[53]) > 1) {
								$dependentFields = explode("|", $arr[53]);
								$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
											onBlurNonEditableFields($('#{$sourceId}'), '" . trim($dependentField) . "');
										;
									";
								}
							}
						?>

						//If dependent field then call on blur
						<?php
							if (strlen($arr[52]) > 1) {
								$dependentFields = explode("|",$arr[52]);
								$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
										onBlurClearDependentField($('#{$sourceId}'), '" . trim($dependentField) . "');
									";
								}
							}
						?>
						var tabindex = $('#'+currentFieldId).attr("tabindex");
						tabindex++;
						console.log(tabindex);

					}
				})
			</script>
			<?php
	}
}

?>

<style>

	#popupGrid .modal-body {
		overflow-y: scroll;
		// height: 67vh;
		max-height: calc(100vh - 200px); 
	}
</style>

<script>
	var triggerPopupButtonId;
	window.popupGridRowDataMap = {};
	var lastUpdatedValue = 0; // declare in outer scope

	$(document).on('keydown', '.open-popup', function(e) {
		if (e.key === 'Enter') {
			e.preventDefault();
			let popupId = $(this).data('popup-id');
			let extra = $(this).data('extra');
			console.log("popupid",popupId);
			console.log("extra",extra);
			openCustomPopup(popupId, extra);
		}
	});

	function openCustomPopup(fieldId,params) {
		
		// Extract parameters string (e.g., "parameters{qualityid=?qualityid | designid=?designnid}")
		let paramString = params.replace('parameters{', '').replace('}', '').trim();

		// Split into key-value pairs
		let paramArray = paramString.split('|').map(item => item.trim());
		console.log("paramArray",paramArray);
	
		let paramsObj = {};

		$('#popupFilters').empty();
		
		paramArray.forEach(pair => {
			let [key, value] = pair.split('=');
			key = key.trim();
			value = value.trim();

			var match = value.match(/^(\d+)_([^_].*)$/);
			console.log("match",match);
			if (match) {
				var numberPart = match[1];  // "1738"
				var textPart = match[2];    // "designid"

				var className = $('#grid-id-' + numberPart).attr('class');
				var lastChar = className.slice(-1); // gets the last character
				var realField = 'kreon-grid-'+lastChar+textPart;
				// alert(realField);
			
				// console.log("paramArray",realField, $('#'+realField).val());
				var realValue = $('#'+realField).val() || '';

				var fieldType = $('#'+realField).prop('type').toLowerCase();
				generateFilterFields(fieldType,realField,textPart);
				paramsObj[key] = realValue;

			}else{
				console.log("value",value, fieldId);
				if (new RegExp("\\b" + fieldId + "\\b", "i").test(value)) { //sizeid not in (select sizeid from stock_user) if that type of condition coming then condition pass as it is
					// console.log("Found:", fieldId);
					paramsObj[key] = value;
				} else {
					var realValue = $('#'+value).val() || '';
					var fieldType = $('#'+value).prop('type').toLowerCase();
					generateFilterFields(fieldType,key,value);
					paramsObj[key] = realValue;
				}

				

			}
		});

		console.log("paramsObj",paramsObj);

		// ✅ Convert to "key=value AND key=value" string
		// var conditionString = Object.entries(paramsObj)
		// 	.map(([k, v]) => `${k}=${v}`)
		// 	.join(' AND ');

		let conditionString = Object.entries(paramsObj)
			.map(([k, v]) => {
				if (k.toLowerCase() === fieldId.toLowerCase()) { //sizeid=sizeid not in (select sizeid from stock_user) if that type param coming then remove sizeid=
					// if key matches fieldId → use value only
					return v;
				} else {
					// otherwise → normal key=value
					return `${k}=${v}`;
				}
			})
			.join(' AND ');

		console.log("conditionString",conditionString);

		var match = fieldId.match(/^(\d+)_([^_].*)$/);

		if (match) {
			var numberPart = match[1];  // "1738"
			var textPart = match[2];    // "designid"
			
			var className = $('#grid-id-' + numberPart).attr('class');
			var gridSerialNo = className.slice(-1); // gets the last character
		
			triggerPopupButtonId = textPart;
			// console.log("if",'kreon-grid-'+gridSerialNo+triggerPopupButtonId);
			$('#popupGridID').val('kreon-grid-'+gridSerialNo+triggerPopupButtonId);
		}else{
			triggerPopupButtonId = fieldId;
			// console.log("else",triggerPopupButtonId);
			$('#popupGridID').val(triggerPopupButtonId);
		}


		$('#popupGrid').modal('show');
		lastUpdatedValue = 0;
		window.popupGridRowDataMap = {};
		getPopupGridData(triggerPopupButtonId,conditionString,gridSerialNo);
	}

	function generateFilterFields(fieldType,realField,textPart){
		console.log("fieldType",fieldType,"realField",realField,"textPart",textPart);
		var value = $('#'+realField).val();
		textPart = textPart.charAt(0).toUpperCase() + textPart.slice(1).toLowerCase();
		var inputHtml = '';
		if(fieldType == 'select-one'){
			var value1 = $('#'+realField+ ' option:selected').text();
			var selectHtml = `
				<div class="form-group col-md-3" >
					<label>${textPart}</label>
					<select class="form-control" disabled>
						<option value="${value}">${value1}</option>
					</select>
				</div>
			`;
		}else if(fieldType == "text"){
			var selectHtml = `
				<div class="form-group col-md-3">
					<label>${textPart}</label>
					<input readonly type="text" value="${value}">
				</div>
			`;
		}
			

		$('#popupFilters').append(selectHtml);
	}

	function getPopupGridData(fieldId,conditionString,gridSerialNo) {
		let passedValidation = false;

		var globalValue = $("#globalSearch").val().toLowerCase();

		// Store current column search values before refresh
		const searchValuesMap = {};
		$("#popupGridTable .search-column").each(function () {
			const columnId = $(this).attr("id");
			const columnValue = $(this).val();
			searchValuesMap[columnId] = columnValue;
		});

		var columnFilters = $("#popupGridTable .search-column").map(function() {
			const column = $(this).attr("id");
			const columnValue = $(this).val().toLowerCase();
			return { column, columnValue };
		}).get();

		console.log("columnFilters",columnFilters);

		var columnFiltersString = columnFilters
			.map(function (filter) {
				if (filter.columnValue) {
					// remove "search-" prefix if present
					var colName = filter.column.replace(/^search-/, "");
					return colName + ":" + filter.columnValue;
				}
			})
			.filter(function (item) {
				return item !== undefined;
			})
			.join("|");

		var fieldJson = $("#kreon-grid-"+gridSerialNo+fieldId).val();
		// console.log("fieldJson",fieldJson,"#kreon-grid-"+gridSerialNo+fieldId);

		$.ajax({
			url: 'getPopupGridData.php',
			method: 'GET',
			dataType: 'json',
			data: {
				FormID: <?php echo $FormID; ?>, FieldID: fieldId, conditionString:conditionString, ColumnFilters: columnFiltersString, jsonData:fieldJson
			},
			success: function(response) {
				console.log("response",response);
				// response.FieldJson may arrive as a string
				var responseFieldType = response['fields'];
				const fields = typeof responseFieldType === 'string'
					? JSON.parse(responseFieldType)
					: (responseFieldType || []);

				const rows = response['data'] || [];


				const rangelimit = response['rangelimit'];

				const step = response['step'];

				// console.log(rows);
				renderPopupGrid(fields, rows, rangelimit, step);
			},
			error: function() {
				alert('Failed to load data');
			}
		});
	}

	function renderPopupGrid(fields, rows, rangelimit, step) {
		if (!Array.isArray(fields) || fields.length === 0) {
			$('#popupGridTable').html('<div class="text-muted">No column metadata.</div>');
			return;
		}
		// if (!Array.isArray(rows) || rows.length === 0) {
		// 	$('#popupGridTable').html('<div class="text-muted">No data found.</div>');
		// 	return;
		// }

		// Normalize metadata: [{ COLUMN_NAME, DATA_TYPE }]
		const cols = fields.map(f => ({
			name: f.COLUMN_NAME,
			type: String(f.DATA_TYPE || '').trim(), // "1" = input textbox (as per your requirement)
			calc: (f.CALCULATION_TYPE || '').toLowerCase(),
			options: f.DropdownOptions ? JSON.parse(f.DropdownOptions) : []
		}));

		// Helpers
		const toNumber = v => {
			if (v === null || v === undefined) return NaN;
			if (typeof v === 'number') return v;
			const n = parseFloat(String(v).replace(/,/g, '').trim());
			return isNaN(n) ? NaN : n;
		};

		let html = '<table class="table table-sm table-bordered align-middle mb-0">';
		html += '<thead><tr>';

		const hasId = rows[0] && Object.prototype.hasOwnProperty.call(rows[0], 'id');

		for (var i=0; i<cols.length; i++) {
			if(i==0){
				html += `<th></th>`;
			}else{
				html += `<th>
					${escapeHtml(cols[i]['name'])}<br>
					<input type="search" class="search-column form-control popup-search${i}"  id="search-${escapeHtml(cols[i]['name'])}" placeholder="Search ${escapeHtml(cols[i]['name'])}" data-column="${i}" value="">
					
				</th>`
			}
		}
		html += '</tr></thead><tbody>';

		// ✅ Handle "No data" inside tbody instead of skipping entire table
		if (!Array.isArray(rows) || rows.length === 0) {
			html += `<tr><td colspan="${cols.length}" class="text-center text-muted">No records found</td></tr>`;
		} else {
		
			rows.forEach((row, rIdx) => {
				console.log("row",row);
				let rowCopy = {};
				const rowId = hasId ? row.id : rIdx;
				html += `<tr data-id="${escapeAttr(rowId)}">`;
				// if (hasId) html += `<td>${escapeHtml(row.id)}</td>`;

				cols.forEach(c => {
					const val = row[c.name] ?? '';
					rowCopy[c.name] = val;

					if (c.type === '4') {
						const rangeLimit = rangelimit; // or get dynamically if needed
						const stepValue = step; 
						// Text input for type 1
						html += `
						<td>
							<div style="display: flex; align-items: center; gap: 8px;">
								<div class="input-group">
									<input
										type="text"
										class="form-control form-control-sm grid-input"
										data-rowid="${escapeAttr(rowId)}"
										data-field="${escapeAttr(c.name)}"
										value="${escapeAttr(val)}"
										style="width: 80px;" />
									
									<div style="display: flex; gap: 4px;padding-left:4px;">
								
										<button type="button" class="btn btn-success btn-sm btn-plus"  data-rowid="${escapeAttr(rowId)}" 
										data-field="${escapeAttr(c.name)}" data-range="${rangeLimit}" data-step="${stepValue}"><i class="fa fa-plus"></i></button>
										<button type="button"  class="btn btn-danger btn-sm btn-minus" data-rowid="${escapeAttr(rowId)}" data-field="${escapeAttr(c.name)}" data-step="${stepValue}"><i class="fa fa-minus"></i></button> 
										
			
									</div>
								</div>
							</div>
						</td>`;
					}else if (c.type === '0') {
						// Text input for type 1
						html += `
						<td>
							<input
								type="hidden"
								class="form-control"
								data-rowid="${escapeAttr(rowId)}"
								data-field="${escapeAttr(c.name)}"
								value="${escapeAttr(val)}"
								style="width: 80px;" />
									
						</td>`;
					}else if (c.type === '3') {
						// Determine dynamic ID column: assume it's "<currentName>id"
						const idField = c.name.toLowerCase() + 'id';
						const labelField = c.name; // current column is the label

						// Get ID value dynamically from row
						const optionId = row[idField] ?? '';
						const labelVal = val;

						html += `
						<td>
							<select class="form-control grid-dropdown" readonly style="pointer-events:none;"
								data-rowid="${escapeAttr(rowId)}"
								data-field="${escapeAttr(c.name)}">
								<option value="${escapeAttr(optionId)}">${escapeHtml(labelVal)}</option>
							</select>
							
						</td>`;

						// const idField = c.name.toLowerCase() + 'id';
						// const selectedId = row[idField] ?? '';
						// const options = Array.isArray(c.options) ? c.options : [];

						// let dropdownHtml = `<select class="form-control grid-dropdown"
						// 	data-rowid="${escapeAttr(rowId)}"
						// 	data-field="${escapeAttr(c.name)}">`;

						// // Default placeholder
						// dropdownHtml += `<option value="">Select ${escapeHtml(c.name)}</option>`;

						// // Populate all dropdown options
						// options.forEach(opt => {
						// 	const selected = String(opt.value) === String(selectedId) ? 'selected' : '';
						// 	dropdownHtml += `<option value="${escapeAttr(opt.value)}" ${selected}>${escapeHtml(opt.label)}</option>`;
						// });

						// dropdownHtml += '</select>';

						// html += `<td>${dropdownHtml}</td>`;
					}else if (c.type === '1') {
						// Text input for type 1
						html += `
						<td>
							<input
								type="text"
								class="form-control form-control-sm"
								data-rowid="${escapeAttr(rowId)}"
								data-field="${escapeAttr(c.name)}"
								value="${escapeAttr(val)}" />
						</td>`;
					}else if (c.type === '2') {
						// Text input for type 1
						html += `
						<td>	
							<input
								type="number"
								class="form-control form-control-sm"
								data-rowid="${escapeAttr(rowId)}"
								data-field="${escapeAttr(c.name)}"
								value="${escapeAttr(val)}" />
						</td>`;
					}

					const rowIDKey = hasId ? row.id : rIdx;
					window.popupGridRowDataMap[rowIDKey] = rowCopy;
				});
			});
			
		}

		html += '</tbody>';

		// Footer (only populate the column that requested it)
		const footerCells = cols.map(c => {
			if (c.calc === 'count') return rows.length;              // e.g., shade
			if (c.calc === 'sum') {
			let s = 0;
			for (const r of rows) {
				const n = toNumber(r[c.name]);
				if (!isNaN(n)) s += n;
			}
			return s;                                              // e.g., qty
			}
			return '';
		});
		// console.log("footerCells",footerCells);
		html += '<tfoot><tr>';
		
		// Add exactly same columns as header
		for (let i = 0; i < cols.length; i++) {
			if (i === 0) {
				html += '<td style="display:none;"></td>';
			} else {
				html += `<td class="footer-cell" data-col="${i}"></td>`;
			}
		}

		html += '</tr></tfoot>';

		html += '</table>';

		$('#popupGridTable').html(html);

		// Initial calculation
		updateFooterSums(cols);

		// Event binding for recalculation on plus/minus and input change
		$(document).off('click', '.btn-plus, .btn-minus').on('click', '.btn-plus, .btn-minus', function () {
			setTimeout(() => updateFooterSums(cols), 100);
		});
		// $(document).off('input', '.grid-input, .form-control-sm').on('input', '.grid-input, .form-control-sm', function () {
		// 	updateFooterSums(cols);
		// });

		$(document)
			.off('input change', '.grid-input, .grid-input-number')
			.on('input change', '.grid-input, .grid-input-number', function () {
				updateFooterSums(cols);
		});

		console.log("popupGridRowDataMap", window.popupGridRowDataMap);
	}

	// ✅ Utility: Recalculate footer sums
	function updateFooterSums(cols) {
		const $table = $('#popupGridTable'); // or '#popupGridTableInner' if that's your table id

		cols.forEach((c, idx) => {
			if (c.calc === 'sum') {
			let total = 0;

			$table.find('tbody tr').each(function () {
				const $cell = $(this).find(`td:eq(${idx})`);

				// read from input if present, otherwise from text
				const $inp = $cell.find('input');
				const raw = $inp.length ? $inp.val() : $cell.text();

				const num = parseFloat(String(raw).replace(/,/g, '')); // normalize
				if (!isNaN(num)) total += num; // only add numbers
			});

			$table.find(`tfoot [data-col="${idx}"]`).text(total.toFixed(2));
			} else if (c.calc === 'count') {
				const count = $table.find('tbody tr.updated').length;
				$table.find(`tfoot td[data-col="${idx}"]`).text(count);
			}else {
			$table.find(`tfoot [data-col="${idx}"]`).text('');
			}
		});
	}


	// $(document).on('input', '.grid-input', function () {
	// 	// alert("hi");
	// 	const rowId = $(this).data('rowid');
	// 	const field = $(this).data('field');
	// 	const newValue = $(this).val();

	// 	if (window.popupGridRowDataMap[rowId]) {
	// 		window.popupGridRowDataMap[rowId][field] = newValue;
	// 	}
	// 	// console.log("popupGridRowDataMap", window.popupGridRowDataMap);
	// });

	$(document).on("keydown", function(e) {
			const visibleRows = $("#popupGridTable tr:visible");
			const numRows = visibleRows.length;
			// var DBFieldName = $(e.target).attr('id');
			
			if (!$("#popupGrid").is(":visible")) return;
			// if (!$("#myModal").is(":visible") || numRows === 0) return;
		
			switch (e.key) {
				case "Enter":
					if (!$("#popupGrid").is(":visible")) {
						// Open the modal if it's not visible
						toggleModal(e);
					} else {
						// Apply the filter if the modal is visible & if input type number or text then don't call applyFilters
						// if (!$(e.target).is("input[type='number']") && !$(e.target).is("input[type='text']")) {
							// alert("hi");
							getPopupGridData(triggerPopupButtonId);
							// applyFilters(triggeringButtonId);
						// }
					}
					break;

				case "Escape":
					// alert("in escape");
					saveGridData();

				break;
			}
	});	

	$('#popupGrid .modal-body').on('scroll', function() {
		const container = $(this);
		if (container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {
			const fieldId = $('#popupGrid').data('fieldid'); // Store fieldId on modal when opening
			getPopupGridData(fieldId, currentPage);
		}
	});

	// When plus button is clicked
	$(document).on('click', '.btn-plus', function () {
		const input = $(this).closest('.input-group').find('.grid-input');
		let val = parseFloat(input.val(), 10) || 0;
		const max = parseFloat($(this).data('range'), 10) || Number.POSITIVE_INFINITY;
		const step = parseFloat($(this).data('step'), 10) || 1;
		const $row = $(this).closest('tr');

		const rowId = $(this).data('rowid');
		const field = $(this).data('field');

		if (val === 0 && lastUpdatedValue !== 0) {
			val = lastUpdatedValue;
		} else {
			val = Math.min(max, val + step);
		}

		input.val(val);

		//store into popupGridRowDataMap variable
		if (window.popupGridRowDataMap[rowId]) {
			window.popupGridRowDataMap[rowId][field] = val;
		}
		// console.log(window.popupGridRowDataMap);
		$row.addClass('updated');
		lastUpdatedValue = val; // ✅ Update last value

		
	});

	$(document).on('input', '.grid-input', function () {
		const $row = $(this).closest('tr');
		const rowId = $(this).data('rowid');
		const field = $(this).data('field');
		const newValue = $(this).val();

		if (window.popupGridRowDataMap[rowId]) {
			window.popupGridRowDataMap[rowId][field] = newValue;
		}

		let val = parseFloat($(this).val(), 10) || 0;

		// ✅ Get the range limit (from sibling button or store in data attribute)
		const max = parseFloat($(this).closest('.input-group').find('.btn-plus').data('range'), 10) || Number.POSITIVE_INFINITY;

		// ✅ Enforce range limit
		if (val > max) {
			val = max;
			$(this).val(val);
			lastUpdatedValue = val;
			$row.addClass('updated');
		}

		if (val !== 0) {
			lastUpdatedValue = val;
		}
	});

	// Decrement quantity
	$(document).on('click', '.btn-minus', function() {
		const input = $(this).closest('.input-group').find('.grid-input');
		const step = parseFloat($(this).data('step'), 10) || 1;
		const rowId = $(this).data('rowid');
		const field = $(this).data('field');

		var val = parseFloat(input.val()) || 0;
		if (val > 0) {
			val = val - step;

			// ✅ Round to 2 decimals
			val = parseFloat(val.toFixed(2));

			input.val(val);

			//store into popupGridRowDataMap variable
			if (window.popupGridRowDataMap[rowId]) {
				window.popupGridRowDataMap[rowId][field] = val;
			}
			console.log(window.popupGridRowDataMap);
		}
	});

	$('#popupGrid').on('hidden.bs.modal', function () {
		saveGridData();
	});

	function saveGridData() {
		// alert("in saveGridData modal");

		const dataMap = window.popupGridRowDataMap;
		let filteredRows = [];
		console.log("dataMap", dataMap);
		// Loop through map and filter
		for (const key in dataMap) {
			if (dataMap.hasOwnProperty(key)) {
				const row = dataMap[key];
				if (parseFloat(row.qty) > 0) {
					filteredRows.push(row); // keep full row as object
				}
			}
		}

		if (filteredRows.length === 0) {
			alert("No rows with qty > 0");
			return;
		}

		// Send via AJAX
		$.ajax({
			url: 'saveGridData.php', // your PHP file
			method: 'POST',
			data: { gridData: JSON.stringify(filteredRows), FormID: <?php echo $FormID; ?>, FieldID: triggerPopupButtonId},
			success: function(response) {
				var jsonResponse = JSON.parse(response); // ✅ Convert to object
				var rowData = jsonResponse.data[0];
				
				// console.log("shadeid:", jsonResponse.data[0].shadeid_4471);

				// Loop through keys dynamically
				for (var key in rowData) {
					if (rowData.hasOwnProperty(key)) {
						var match = key.match(/^(.*?)_(\d+)$/); // split into name and number
					
						if (match) {
							var fieldName = match[1];  // "shadeid" or "qty"
							var numberPart = match[2]; // "4471"
							
							// console.log("Field:", fieldName, "Number:", numberPart, "Value:", rowData[key]);
							
							// ✅ Build your ID dynamically (similar to your logic)
							var className = $('#grid-id-' + numberPart).attr('class');
							var lastChar = className.slice(-1);
							var realField = 'kreon-grid-' + lastChar + fieldName;
							// console.log("realField",realField);
							// console.log("realValue",rowData[key]);
							// ✅ Put the value in that field
							$('#' + realField).val(rowData[key]);
						}else{
							
							$('#' + key).val(rowData[key]);
						}
					}
				}
			},
			error: function(xhr, status, error) {
				console.error("AJAX Error:", error);
			}
		});
	}


	// Simple escaping helpers
	function escapeHtml(str) {
		return String(str)
			.replaceAll('&', '&amp;')
			.replaceAll('<', '&lt;')
			.replaceAll('>', '&gt;')
			.replaceAll('"', '&quot;')
			.replaceAll("'", '&#39;');
	}

	function escapeAttr(str) {
		// attributes need quotes-safe values
		return escapeHtml(str).replaceAll('`', '&#96;');
	}
</script>

<style>
	/* Modal body: prevent its own scroll */
	#popupGrid .modal-body {
		max-height: 70vh;
		overflow: hidden;   /* no double scrollbars */
		padding: 0;
	}

	/* Filters pinned to top */
	#popupFilters {
		position: sticky;
		top: 0;
		background: #fff;
		z-index: 50;
		border-bottom: 1px solid #ddd;
	}

	/* Scroll container for the table rows */
	#popupGridTable {
		display: block;        /* allow header/body separation */
		max-height: 60vh;      /* this part scrolls */
		overflow-y: auto;
		width: 100%;
		border-collapse: separate;
		border-spacing: 0;
		padding-left: 10px;
	}

	/* Header sticks at top under filters */
	#popupGridTable thead, 
	#popupGridTable thead tr, 
	#popupGridTable thead th {
		position: sticky;
		top: 0px;   /* adjust = filters height */
		background: #f8f9fa;
		z-index: 40;
	}

	/* Keep columns aligned */
	#popupGridTable tbody tr {
		display: table;
		table-layout: fixed;
		width: 100%;
	}
	#popupGridTable thead tr {
		display: table;
		table-layout: fixed;
		width: 100%;
	}

	/* Collapse first column (header + body) */
	#popupGridTable thead tr th:first-child,
	#popupGridTable tbody tr td:first-child {
	width: 0 !important;
	max-width: 0 !important;
	min-width: 0 !important;
	padding: 0 !important;
	margin: 0 !important;
	border: 0 !important;
	overflow: hidden !important;
	}

	/* Hide any inputs visually but keep them in DOM */
	#popupGridTable tbody tr td:first-child input {
	display: none !important;
	}

	#popupGridTable tfoot td {
		position: sticky;
		bottom: 0;
		background: #fff; /* Or your preferred footer color */
		z-index: 1;
		font-weight: bold;
	}

	#popupGridTable tfoot td {
    position: sticky;
    bottom: 0;
    background: #d3d3d3; /* Light grey */
    z-index: 1;
    font-weight: bold;
}
</style>


<!-- your existing modal markup (unchanged) -->


<!-- Added code for field type 27 -->
<div class="modal fade" id="popupGrid" data-bs-backdrop="static" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="border: 0;">
				<h5 class="modal-title" id="myModalLabel">Popup Grid</h5>
				<button type="button" onclick="saveGridData();" class="btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">X</button>
			</div>

			<div class="modal-body">
				<div id="popupContent" class="popup-content">
					<input type="hidden" id="popupGridID" value="">
					<div class="popup-filters mb-3" id="popupFilters"></div>
					<div class="col-md-8">
							<div id="pillContainer"></div>
							<!-- <div id="pillContainerClear"><button type="button" class="btn" style="padding:1px 5px;" onclick="deselectAllRow();">Clear All Selected Row</button></div> -->
					</div>

					<table class="table table-striped" id="popupGridTable">

					</table>
				</div>
			</div>
			<div class="modal-footer" style="text-align:left;">
				<!-- <button id="clearSelection" class="btn btn-secondary" onclick="clearSelection()">Clear All</button> -->
			</div>
		</div>
	</div>
</div>

<script>
	$(document).on("click", ".clickable-grid-input", function () {
		let fieldid = $(this).attr("id");   // full id
		let firstChar = fieldid.charAt(0);  // get first character
		let gridid = $('#GridId'+firstChar).val();
		let GridRowEditID = $(this).closest("tr").find("input[name='" + firstChar + "GridEditID[]']").val();
		let GridRowUniqueID = $(this).closest("tr").find("input[name='" + firstChar + "GridTempID[]']").val();
		
		var modeType = '';
		// Get current page URL
		var url = window.location.href;

		// Check if 'preview=' exists in the URL
		if (url.indexOf('preview=') !== -1) {
			modeType = 'preview';
		} else {
			if($('#editID').val() != 0){
				modeType = 'edit';
			}else{
				modeType = 'add';
			}
		}
		console.log("ID:", fieldid, "First Char:", firstChar, "gridid:",gridid, "modeType:",modeType);
		$.ajax({
			url: "GetDetailsFromSpOnClick.php",   // your PHP file
			type: "POST",
			dataType: 'json',
			data: {
				FormID: "<?php echo $FormID; ?>", // your SP name
				FieldId: gridid+"_"+fieldid,
				FormMode: modeType,
				GridRowEditID: GridRowEditID,
				GridRowUniqueID: GridRowUniqueID
			},
			success: function (response) {

				if(response['Success'] == 1){
					if(response['tempData']){
						// $("#"+Object.keys(response["tempData"])).empty();
						if(response["tempData"]){
							const original = response["tempData"];
							// Convert all keys to lowercase
							const lowerCased = Object.keys(original).reduce((acc, key) => {
								acc[key.toLowerCase()] = original[key];
								return acc;
							}, {});
							console.log("lowerCased",lowerCased);
							// Loop through the new object and update corresponding HTML elements
							for (const [key, value] of Object.entries(lowerCased)) {
								const element = $("#" + key);
								if (element.length) {
									element.empty().append(value);
								}
							}
						}
					}
				}

			},
			error: function (xhr, status, error) {
				console.error("SP call failed:", error);
			}
		});
	});
</script>
<style>
	.clickable-grid-input {
		cursor: pointer;
	}
</style>

<?php

function createMore1($m,$d,$gd,$r,$id,$FormID, $db){

	global $ddtableIncludes;
	global $k_debug;
	
	$v = array();
	$row1 = array();
	$formType = 14; // Added For Add More functionality
    
	if($id > 0){		
		// if($FormID == 4609 || $FormID == 4618){ 
			if($d[5] !== $db[1]){	
				//THIS HAS BEEN CHANGED BY MITESH ON 25/02/2025 AS THE TableUnique of Grid and TablePrimary of Main could be different as raised by Shrikant
				$sql = 'SELECT ' . $d[5] . ' FROM ' . $db[0] . ' WHERE ' . $db[1] . ' = ' . $id;
				$result = db::getInstance()->db_select($sql, "F-13128: Cl-");
				$id = $result['result_set'][0][$d[5]];
 			}
		// }
		
		$sql = "SELECT * FROM ".$d[0]." WHERE ".$d[1]." = ".$id." ";
		
		if(strlen($d[10]) > 0){
			$sql .= $d[10];
		}else{
			$sql .= "ORDER BY ".$d[5]." DESC";
		}
		// echo $sql;
		// if($FormID == 4609){ echo $sql;  }
		$result = db::getInstance()->db_select($sql, "F-13142: Cl-");

		

        if($k_debug){	echo '<br /><br />' . $sql . '<br />'; print_r($result); echo '<br /><br />'; }
		$row = $result['result_set'];
		$size = sizeof($m);
		for($i = 0; $i < $result['num_rows']; $i++){
            $v[$i] = array($size);
			for($j = 0; $j < $size; $j++){
                // if($m[$j][0] == 18){
                //     // print_r($row[$i][$m[$j][1]]);
                //     $temp = $row[$i][$m[$j][1]];
                //     if(isset($temp)){
                //         $v[$i][$j] =  $temp->format('h:i:s'); //strtotime("H:ia", $temp);
                //     }
                // }else
				if($m[$j][0] == 6){
                    $temp = $row[$i][$m[$j][1]];                    
                    if(isset($temp)){
                        $v[$i][$j] =  $temp->format('Y-m-d'); //date("d-m-Y", strtotime($temp));
                    }else{
                        $v[$i][$j] = "";
                    }
                }else{
                    if(strlen($row[$i][$m[$j][1]]) == 0){
                        $v[$i][$j] = $row[$i][ucfirst($m[$j][1])];
                    }else{
                        $v[$i][$j] = $row[$i][$m[$j][1]];
                    }
                }
			}
			$v[$i][$j] = $row[$i][$d[1]];
			$v[$i][$j+1] = $row[$i][$d[5]];
			$v[$i][$j+2] = $row[$i]['uniqueid'];
		}

		// print_r($v);
	}

	
	

	$d[8] = "";
	$downloadExcel = '';
	$tempDataSpName = "sp_ImportGrid_".$d[7]."";
	$checkSp = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$tempDataSpName'";
	$checkSpResult = db::getInstance()->db_select($checkSp, "F-13189: Cl-");
	// print_r($checkSpResult);
	if($checkSpResult['result_set'][0]['found'] == 1){
		$d[8] = $tempDataSpName;
		
		$tempDataSpName = "sp_ImportGridExcelExport_".$d[7]."";
		$checkSp = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$tempDataSpName'";
		$checkSpResult = db::getInstance()->db_select($checkSp, "F-13196: Cl-");
		// print_r($checkSpResult);
		if($checkSpResult['result_set'][0]['found'] == 1){
			$downloadExcel = '<a  style="font-size: 11px;margin-top: -8px;display: block;float: right;padding-bottom: 0;" href="#" onclick="exportGridTableToExcelusingSP(\''.$d[7].'\',\'Excel for Grid - '.trim($d[2]).'\');" class="btn bizbtn downloadBtn" >Download Excel</a>'; 
		}else{
			//Blank Template
			$downloadExcel = '<a style="font-size: 11px;margin-top: -8px;display: block;float: right;padding-bottom: 0;" href="#" onclick="exportGridTableToExcel(\'GridTable'.$d[3].'\',\'Excel Import Template for Grid - '.trim($d[2]).'\')" class="btn bizbtn downloadBtn" >Download Blank Template</a>';
		}
	}
	// echo $d[8];
	$excelImport = "";
    if(strlen($d[8]) > 1){	//if grid import SP is given
		$excelImport = '<!--script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script-->
			<div class="col-md-6" style="float:right"><div class="col-md-6"></div><div class="col-md-6"><label class="custom-file-upload" style="margin-top:0;padding: 0px 12px;"><i class="fa fa-cloud-upload"></i> Grid Bulk Import <input type="file" name="BulkImport_GridTable'.$d[3].'" id="BulkImport_GridTable'.$d[3].'" accept=".csv,.xls,.xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel"></label>
			'.$downloadExcel.'
			</div></div>
			<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.0/dist/xlsx.full.min.js"></script>
			<script>
				// console.log("BulkImport_GridTable'.$d[3].'");
				document.getElementById("BulkImport_GridTable'.$d[3].'").addEventListener("change", handleFileSelectGrid'.$d[3].', false);
				function handleFileSelectGrid'.$d[3].'(evt) {
					var files = evt.target.files; // FileList object
					// console.log(evt);
					// console.log(files);
					var xl2json = new ExcelToJSONGrid'.$d[3].'();
					xl2json.parseExcel(files[0]);
				}
				
				var ExcelToJSONGrid'.$d[3].' = function() {
					
					var cols = [];
					this.parseExcel = function(file) {
						var reader = new FileReader();
						reader.onload = function(e) {
							var data = e.target.result;
							var workbook = XLSX.read(data, {
								type: "binary"
							});
							var rwCnt = 0;
							workbook.SheetNames.forEach(function(sheetName) {
							
								var XL_row_object = XLSX.utils.sheet_to_json(workbook.Sheets[sheetName], {
									defval: null // This ensures empty cells are represented as null
								});

								// Loop through each row
								// XL_row_object.forEach(row => {
								// 	for (let key in row) {
								// 		const value = row[key];
								// 		if (typeof value === "number" && value > 20000 && value < 60000) {
								// 			// Likely an Excel date serial (between 1954 and 2079)
								// 			const jsDate = XLSX.SSF.parse_date_code(value);
								// 			if (jsDate) {
								// 				// Format the date as "YYYY-MM-DD"
								// 				const formattedDate = `${jsDate.y}-${String(jsDate.m).padStart(2, "0")}-${String(jsDate.d).padStart(2, "0")}`;
								// 				row[key] = formattedDate;
								// 			}
								// 		}
								// 	}
								// });

								// Only keep columns where the first row is not null or blank
								// if (XL_row_object.length > 0) {
								// 	var firstRow = XL_row_object[0];
								// 	for (var key in firstRow) {
								// 		console.log("CHECKING...", firstRow[key]);
								// 		if (firstRow[key] === null || firstRow[key] === "") {
								// 			console.log("DELETING...");
								// 			// If the first cell in this column is blank, delete the column
								// 			XL_row_object.forEach(row => delete row[key]);
								// 		}
								// 	}
								// }
								// Convert rows into a JSON array
								var productList = JSON.parse(JSON.stringify(XL_row_object));
								console.log(XL_row_object); // Check the output
								console.log(productList);

								ImportGridExcelValidateSP(productList,"' . $d[7] . '","'.$id.'");

							});
						};
						reader.onerror = function(ex) {
						  console.log(ex);
						};
						reader.readAsBinaryString(file);
					};
				};
			</script>';
	}
		
	$temp = '<div class="grid'.$d[3].'" id="grid-id-'.$d[7].'" style="margin-top:2px;"><label class="col-md-12"><b>'.$d[2].'</b>&nbsp;</label>';
	// if(strlen($gd[1]) > 1){

	// 	$temp .= $excelImport.' <div class="col-md-6" style="margin-bottom:4px;"> <button  class="btn btn-primary" type="button"  id="GridMultyDDModal-'.$d[7].'" tabindex="'.$gd[2].'">'.$gd[3].'</button>
	// 		<input type="hidden" id="GridMultyDDModal-hidden-'.$d[7].'" value="">
	// 		<input type="hidden" id="MultiSelectGridId-hidden-'.$d[7].'" value="'.$d[7].'"></div>';

	// 	echo $ddtableIncludes;
	// 	echo "
	// 		<script>
	// 			$(document).ready(function(){
	// 				$('#GridMultyDDModal-".$d[7]."').keypress(function(e) {
	// 					if(e.which == 13) {
	// 						$('#GridMultyDDModal-". $d[7]."').click();
	// 					}
	// 				});

	// 				$('#GridMultyDDModal-". $d[7]."').click(function(){
						
	// 					$('#modalLabelLarge').text('Grid Multiple selection Dropdown');				
	// 					$('#DropDownModal').modal('show');
	// 					jqxhr = $.ajax('getMultyDDValue1.php?FormID=".$FormID."&GridID=".$d[7]."&DBFieldName=". $gd[0]."&DBFieldType=14&isGrid=0')
	// 					.done(function () {
	// 							tableName= '#ddTable',
	// 							data1 = JSON.parse(jqxhr.responseText);
	// 							DBFieldName='". $d[7]."';
	// 							DBFieldType ='14';
	// 							GridID = '".$d[7]."';
	// 							gridResponseParams = data1['gridResponseParams'];
	// 							isGrid = '0';
	// 							FormID = '".$FormID."';
								
	// 							var row = '<tr>';
	// 							var rowFilter = '<tr class=\"headerFilter\">';
	// 							$.each(data1.columns, function (k, colObj) {
									
	// 								row += '<th>' + colObj.name + '</th>';
									
	// 								var searchColName = colObj.name.trim();
	// 								if(k == 0){
	// 									rowFilter += '<th></th>';
	// 								}else{
	// 									rowFilter += '<th><input type=\"search\" class=\"form-control\" autocomplete=\"off\" onkeydown=\"SearchFunction(event,DBFieldName,DBFieldType,FormID,GridID,isGrid,gridResponseParams)\" placeholder=' + searchColName + ' id='+searchColName+' name='+searchColName+'></th>';
	// 								}
									
	// 							});
	// 							rowFilter += '</tr>';
	// 							row += '</tr>';


	// 							if('GridMultyDDModal-". $d[7]."' != $('#DropDownModalID').val()){
	// 								$('#DropDownModalID').val('GridMultyDDModal-".$d[7]."');
	// 								if ($.fn.dataTable.isDataTable('#ddTable')) {
	// 									$('#ddTable').DataTable().state.clear();
	// 									$('#ddTable').DataTable().destroy();
	// 								}
	// 							}else{
	// 								if ($.fn.dataTable.isDataTable('#ddTable')) {
	// 									$('#ddTable').DataTable().destroy();
	// 								}
	// 							}

								
	// 							$('#ddTable').html('<thead></thead>');
	// 							$('#ddTable thead').html(row + rowFilter);

	// 							$('.headerFilter th:first').hide();
								
	// 							var is_variable='';
	// 							var is_value='';
	// 							$('#PopulateGridButton').show();
	// 							// console.log('calling load_dd 5995');
								
	// 							load_dd(DBFieldName,DBFieldType,FormID,GridID,isGrid,gridResponseParams);
	// 						});
	// 				});
	// 			});
	// 		</script>";
	// }else{
	// 	$temp .= $excelImport;
	// }

	// if(strlen($gd[1]) > 1){

		// $temp .= $excelImport.' <div class="col-md-6" style="margin-bottom:4px;"> <button  class="btn btn-primary" type="button"  id="'.$d[7].'" onclick="toggleModal()" tabindex="'.$gd[2].'" ';
		
		// $SPName = 'sp_GetData_'.$FormID.'_'.$d[7];
		// $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
		// $checkSp = db::getInstance()->db_select($sql);
		// if($checkSp['result_set'][0]['found'] == 1){
		// 	$temp .=" data-systemtype=\"2\"";
		// }else{
		// 	$temp .=" data-systemtype=\"1\"";
		// }
		
		// $temp .= '>'.$gd[3].'</button><input type="hidden" id="GridMultyDDModal-hidden-'.$d[7].'" value=""><input type="hidden" id="MultiSelectGridId-hidden-'.$d[7].'" value=""></div>';

		// echo $ddtableIncludes;

		

		$SPName = 'sp_GetData_'.$FormID.'_'.$d[7].'_'.$gd[0];
		$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
		$checkSp = db::getInstance()->db_select($sql, "F-13388: Cl-");
		if($checkSp['result_set'][0]['found'] == 1){
			
			$temp .= $excelImport.' <div class="col-md-6" style="margin-bottom:4px;"> <button  class="btn btn-primary" type="button"  id="'.$gd[0].'-text" data-buttontype="grid-'.$d[7].'" onclick="toggleModal(event)" tabindex="'.$gd[2].'" ';
			$temp .=" data-systemtype=\"2\"";

			$temp .= '>'.$gd[3].'</button>';
			$temp .= '<input type="hidden" id="GridMultyDDModal-hidden-'.$gd[0].'" value="">
				<input type="hidden" id="MultiSelectGridId-hidden-'.$gd[0].'" value=""></div>';

			echo $ddtableIncludes;
				
			?>
				<script>
				$('#myModal').on('hidden.bs.modal', function (e) {
					var currentFieldId = $('#DropDownModalID').val();
					// Compare with PHP variable
					if (currentFieldId === '<?php echo $gd[0]."-text"; ?>') {
						// Check strlen of $gd[5]
						<?php if (strlen($gd[5]) > 1) { ?>
							var dependentFields = '<?php echo $gd[5]; ?>'.split('|'); // JS split
							console.log(dependentFields);
							dependentFields.forEach(function(field) {
								field = field.trim();
								// Pass the correct element instead of "this"

								onBlurNonEditableFields($('#<?php echo $d[7]; ?>'), field);
							});
						<?php } ?>
					}
				});
				</script>
				<?php
		}else{
			if(strlen($gd[1]) > 1){

				$temp .= $excelImport.' <div class="col-md-6" style="margin-bottom:4px;"> <button  class="btn btn-primary" type="button"  id="'.$d[7].'" onclick="toggleModal(event)" tabindex="'.$gd[2].'" ';
				$temp .=" data-systemtype=\"1\"";
				$temp .= '>'.$gd[3].'</button>';
				$temp .= '<input type="hidden" id="GridMultyDDModal-hidden-'.$d[7].'" value="">
					<input type="hidden" id="MultiSelectGridId-hidden-'.$d[7].'" value=""></div>';

				echo $ddtableIncludes;

				?>
				<script>
				$('#myModal').on('hidden.bs.modal', function (e) {
					var currentFieldId = $('#DropDownModalID').val();
					console.log("jnnjknknkcnkd",currentFieldId);
					// Compare with PHP variable
					if (currentFieldId === '<?php echo $d[7]; ?>') {
						// Check strlen of $gd[5]
						<?php if (strlen($gd[5]) > 1) { ?>
							var dependentFields = '<?php echo $gd[5]; ?>'.split('|'); // JS split
							console.log(dependentFields);
							dependentFields.forEach(function(field) {
								field = field.trim();
								// Pass the correct element instead of "this"

								onBlurNonEditableFields($('#<?php echo $d[7]; ?>'), field);
							});
						<?php } ?>
					}
				});
				</script>
				<?php
				
				// if(strlen($gd[5]) > 3){
				// 	if($_SESSION['user_id'] == 1020){
				// 		//If noneditable field added then call this function
				// 		$dependentFields = explode("|",$gd[5]);

				// 		foreach ($dependentFields as $dependentField) {
				// 			if($_SESSION['user_id'] == 1020){
				// 				echo $dependentField;
				// 			}
				// 			echo "<script>
				// 				$(document).ready(function() {;
				// 				// $('#" .$gd[0]. "').on('blur', function(e) {
				// 						console.log('pornima','".$gd[0]."');
				// 						onBlurNonEditableFields(this, '" . trim($dependentField) . "');
				// 					// });
				// 			});</script>";
				// 		}	
				// 	}
				// }
			}
		}
		
	// }else{
		$temp .= $excelImport;
	// }


	// style="max-height:200px;overflow-y: scroll;"
	$temp .= '<div class="col-md-12 panel-body" id="panel'.$d[3].'" style="overflow-x:auto;padding: 0 15px;max-height:'.$gd[4].'px;overflow-y: auto;">';
	$tableStart = '<table style="table-layout: fixed;word-wrap: break-word;" id="GridTable" class="table table-responsive table-bordered table-hover tmp_GridTable'.$d[3].'">';
	$tableEnd = '</table>';
	$tableHead = '<thead class=" thead-light"><tr>';
	
	$flds = '';
	//$flds = '<div class="form-group grp'.$d[3].'" id="'.$d[3].'0">';
	// $flds = '<td style="padding:2px 3px !important;" class="AddEdit" ><a  style="padding:3px;"  href="javascript:void(0)" class="btn btn-success add'.$d[3].'"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span></a><a  style="padding:3px; display:none;" href="javascript:void(0)" class="btn btn-success update'.$d[3].'"><span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></a><a  style="padding:3px; margin-left:2px; display:none;" href="javascript:void(0)" class="btn btn-info refresh'.$d[3].'"><span class="glyphicon glyphicon glyphicon-refresh" aria-hidden="true"></span></a></td>';
	$headerGridStart = '<tr class="grp'.$d[3].'" id="'.$d[3];
	$headerGridEnd   = '">';
	$reqf = [];
	$maxTabindex = 0;
	$sizeoffield = 0;
	$lastFieldId;
	if($k_debug){	echo '<br /><br />'; print_r($m); echo '<br /><br />'; }
	for($i = 0; $i < sizeof($m); $i++){		
		if($m[$i][24] > $maxTabindex){
			//Add Tabindex in plus button
			if($m[$i][0] != 0){
				$maxTabindex = $m[$i][24];
			}
		}

		// Loop through the fields to find the last valid field
		// Check if field is not readonly and tabindex is greater than 0
		if ($m[$i][23] != 1 && $m[$i][24] > 0) {
			// Store the ID of the current field
			$lastFieldId = "kreon-grid-".$d[3].$m[$i][1];  // Assuming $m[$i][$j][0] is the field ID
		}

		// print_r($m[$i]);
	    //style='width:".$m[$i][7]."px' width='".$m[$i][7]."'
		
		if($m[$i][5] == 1){ //to check if required field
			// $reqf[$i] = '<span class="required"> *</span>';
			$reqData = 'data-f-color="ffff0000"';	//compulsor in excel
		}else{
			$reqData = '';
		}

		if($m[$i][26] == 0 ){  //to check visibility
			$thClass = "thHidden";
		}else{
			$thClass = "";
		}

		$width = !empty($m[$i][7]) ? $m[$i][7] : 50;
		$tableHead .= '<th class="'.$thClass.'" width="'.$width.'"  '.$reqData.'>'.$m[$i][2].' ';

		if($m[$i][13] > 0){
			$tableHead .= '<button type="button" class="amodal" id="AddBtnModal-'.$m[$i][1].'" value="'.$m[$i][13].'-'.$m[$i][1].'-'.$formType.'" style="background: transparent;border: none !important;font-size:1;color:blue"><i class="fa fa-plus-circle"></i></button>';
		}

		$tableHead .= $reqf[$i]."</th>";

		
		if($m[$i][0] == 0){	//IF HIDDEN		width="'.$m[$i][7].'" style="width:'.$m[$i][7].'px" 

			// if($FormID== 4653) print_r($arr);
			$flds .= '<td class='.$thClass.'><input  type="hidden" value="'.$gridInputVal.'" class="form-control" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" '.$m[$i][6].' tabindex="'.$m[$i][24].'" ';

			$flds .= '/></td>';

		}

		if($m[$i][0] == 1){	//IF TEXT BOX		width="'.$m[$i][7].'" style="width:'.$m[$i][7].'px" 

			//If dependent fiedld added then call this function
			if (strlen($m[$i][30]) > 1) {
				$dependentFields = explode("|",$m[$i][30]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('blur', function(e) {
								onBlurClearDependentField(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//If dependent field added then call this function
			if (strlen($m[$i][31]) > 1) {
				$dependentFields = explode("|",$m[$i][31]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('blur', function(e) {
								onBlurNonEditableFields(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
						$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}else{
						$gridInputVal = '';
					}
				}
			}
		
			//Set Default Value
			if(strlen($m[$i][17]) > 0 && $gridInputVal == ''){
				$gridInputVal = $m[$i][17];
			}

			$flds .= '<td class='.$thClass.'><input  type="text" value="'.$gridInputVal.'" class="form-control" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" '.$m[$i][6].'  tabindex="'.$m[$i][24].'" ';

			if(strlen($m[$i][19]) > 0){
				$flds .= "onfocusout=\"isValidText('".$m[$i][19]."','kreon-grid-".$d[3].$m[$i][1]."');\"";
			}

			//Check validation using sp on lost focus
			if($m[$i][21] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
			}

			if($m[$i][23] != 0){ //to check if field readonly
				$flds .= " readonly ";
			}

			// Only add onfocus select if field is not read-only
			if ($m[$i][23] == 0) {
				$flds .= ' onfocus="this.select()"';
			}

			//Added for getting dynamic decimalplaces	
			if($m[$i][29] != ''){ //to check if field readonly
				$flds .=" data-key=\"".$m[$i][29]."\"";
			}

			
			//On keyup focus exicute formula
			if(strlen($m[$i][11]) > 2){
				$onkeyupHidden = "";
				$flds .= " onkeydown=\"CreateOnkeyupScriptGrid(this,'grid');\"";
				$onkeyupHidden = '<input type="hidden" id="kreon-grid-'.$d[3].$m[$i][1].'-onkeyup-hidden" value="' . $m[$i][11] . '" />';
			}
			
			// if($m[$i][12] > 0){
			// 	$onchange = " onblur=\"CreateOnChangeScriptGridCalculation('kreon-grid-".$d[3]."".$m[$i][1]."',".$m[$i][12].", 'grid',0);\"";
			// 	$flds .= $onchange;
			// }

			if(strlen($m[$i][20]) > 0){
				$onGridkeyupHidden = '<input type="hidden" id="kreon-grid-'.$d[3].''.$m[$i][1].'-hidden" value="' . $m[$i][20] . '" />';

				echo '<script>
					$(document).ready(function() { 
						$("#kreon-grid-'.$d[3].''.$m[$i][1].'").keydown(function(e) {
						
							if(e.which == 13) {
								CreateOnkeyEnterScript(this,"kreon-grid-'.$d[3].''.$m[$i][1].'");
							}
							
						});
					}); 
				</script>';
			}

			//Once lost focus from perticular field then again don't allow to focus on this field
			if($m[$i][25] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,'".$m[$i][0]."');\"";
			}

			//Check value is exist or not
			$onlostfocusHidden = "";
			if(strlen($m[$i][27]) > 5){
				$flds .= "onfocusout=\"onLostFocus(this,0,'grid');\"";
				$onlostfocusHidden = '<input type="hidden" id="kreon-grid-'.$d[3].''.$m[$i][1].'-hidden" value="'.$m[$i][27].'">';
			}


			$flds .= '/>';
			$flds .= $onkeyupHidden;
			$flds .= $onGridkeyupHidden ;
			$flds .= $gridonlostfocuscalculationHidden;
			$flds .= $onlostfocusHidden;

			$flds .= '</td>';
			$gridInputVal = "";
		}

		if($m[$i][0] == 3){	//IF TEXTAREA		width="'.$m[$i][7].'" style="width:'.$m[$i][7].'px" 
			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
						$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}else{
						$gridInputVal = '';
					}
				}
			}

			//Set default value
			if(strlen($m[$i][17]) > 0 && $gridInputVal == ''){
				$gridInputVal = $m[$i][17];
			}

			$flds .= '<td class='.$thClass.'><textarea class="form-control" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" '.$m[$i][6].' tabindex="'.$m[$i][24].'" ';
			if(strlen($m[$i][19]) > 0){
				$flds .= "onfocusout=\"isValidText('".$m[$i][19]."','kreon-grid-".$d[3].$m[$i][1]."');\"";
			}

			//Check validation using sp on lost focus
			if($m[$i][21] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
			}

			if($m[$i][23] != 0){ //to check if field readonly
				$flds .= " readonly ";
			}

			//Once lost focus from perticular field then again don't allow to focus on this field
			if($m[$i][25] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,'".$m[$i][0]."');\"";
			}
			
			$flds .= '>'.$gridInputVal.'</textarea></td>';

			$gridInputVal = "";
		}

		if($m[$i][0] == 12){	//IF Image
			$flds .= '<td class='.$thClass.'><label class="custom-file-upload" tabindex="'.$m[$i][24].'" style="margin-top:0px; padding:3px 12px;"><i class="fa fa-cloud-upload"></i><input type="file" class="form-controlz" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" '.$m[$i][6].'  /></label></td>';

			// $flds .= '<td class='.$thClass.'><label><input type="file" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" '.$m[$i][6].' tabindex="'.$m[$i][24].'" /></label></td>';

			// $flds .= '<td><input type="file" class="form-controlz" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" '.$m[$i][6].' /></td>';
		}

		if($m[$i][0] == 6){	//IF Date BOX		added by sneha on 01-11-2023

			//If dependent field added then call this function
			if (strlen($m[$i][30]) > 1) {
				$dependentFields = explode("|",$m[$i][30]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('blur', function(e) {
								onBlurClearDependentField(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//If dependent field added then call this function
			if (strlen($m[$i][31]) > 1) {
				$dependentFields = explode("|",$m[$i][31]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('blur', function(e) {
								onBlurNonEditableFields(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
						$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}else{
						$gridInputVal = '';
					}
				}
			}

			if(strlen($m[$i][17]) >= 1 && $m[$i][17] == 'today'){
				$gridInputVal = date('Y-m-d');
			}elseif(strlen($m[$i][17]) >= 1 && $m[$i][17] == 'tomorrow'){
				$datetime = new DateTime('tomorrow');
				$gridInputVal = $datetime->format('Y-m-d');
			}elseif($gridInputVal != NULL ){
				if(gettype($gridInputVal) == 'string'){
					$date = strtotime($gridInputVal);
					$gridInputVal = date('Y-m-d', $date);
				}else{
					$gridInputVal = $gridInputVal->format('Y-m-d');
				}
			}

			$flds .= '<td class='.$thClass.'><input type="date" value="'.$gridInputVal.'" class="form-control" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" '.$m[$i][6].' tabindex="'.$m[$i][24].'"';
			
			//Check validation using sp on lost focus
			if($m[$i][21] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
			}

			if($m[$i][23] != 0){ //to check if field readonly
				$flds .= " readonly ";
			}

			//Once lost focus from perticular field then again don't allow to focus on this field
			if($m[$i][25] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,'".$m[$i][0]."');\"";
			}

			$flds .= '/></td>';
			$gridInputVal = '';
		}

		if($m[$i][0] == 7){	//IF Number BOX		added by sneha on 01-11-2023

			//If dependent field added then call this function
			if (strlen($m[$i][30]) > 1) {
				$dependentFields = explode("|",$m[$i][30]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('blur', function(e) {
								onBlurClearDependentField(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//If dependent field added then call this function
			if (strlen($m[$i][31]) > 1) {
				$dependentFields = explode("|",$m[$i][31]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('blur', function(e) {
								onBlurNonEditableFields(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}
			
			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
						$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}else{
						$gridInputVal = "";
					}
				}
			}

			// echo $m[$i][17]." == ".$gridInputVal;

			//Set default value
			if(strlen($m[$i][17]) > 0 && $gridInputVal == ""){
				$gridInputVal = $m[$i][17];
			}
			 
			$flds .= '<td class='.$thClass.'><input type="number" value="'.$gridInputVal.'" class="form-control" name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" '.$m[$i][6].'  tabindex="'.$m[$i][24].'" ';
			
			// Only add onfocus select if field is not read-only
			if ($m[$i][23] == 0) {
				$flds .= ' onfocus="this.select()"';
			}

			//If step added in fieldothercondition then don't aloow to type
			if($m[$i][6] > 2){
				if(strpos($m[$i][6], 'step') !== false){
					$flds .= "onkeydown=\"isValidDigit('".$m[$i][6]."','kreon-grid-".$d[3].$m[$i][1]."');\"";
				}
			}
			
			
			if(strlen($m[$i][19]) > 0){
				$flds .= "onkeydown=\"isValidText('".$m[$i][19]."','kreon-grid-".$d[3].$m[$i][1]."');\"";
			}

			//On keyup focus exicute formula
			if(strlen($m[$i][11]) > 2){
				$onkeyupHidden = "";
				$flds .= " onkeydown=\"CreateOnkeyupScriptGrid(this,'grid');\"";
				$onkeyupHidden = '<input type="hidden" id="kreon-grid-'.$d[3].$m[$i][1].'-onkeyup-hidden" value="' . $m[$i][11] . '" />';
			}

			// if($m[$i][12] > 0){
			// 	$onchange = " onblur=\"CreateOnChangeScriptGridCalculation('kreon-grid-".$d[3]."".$m[$i][1]."',".$m[$i][12].", 'grid',0);\"";
			// 	$flds .= $onchange;
			// }

			//Check validation using sp on lost focus
			if($m[$i][21] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
			}

			if($m[$i][23] != 0){ //to check if field readonly
				$flds .= " readonly ";
			}

			//Added for getting dynamic decimalplaces	
			if($m[$i][29] != ''){ //to check if field readonly
				$flds .=" data-key=\"".$m[$i][29]."\"";
			}

			//Once lost focus from perticular field then again don't allow to focus on this field
			if($m[$i][25] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,'".$m[$i][0]."');\"";
			}

			$flds .= '/>'.$onkeyupHidden.'</td>';

			$gridInputVal = "";
		}

		if($m[$i][0] == 5){	//Dropdown From DB

			//If dependent field added then call this function
			if (strlen($m[$i][30]) > 1) {
				$dependentFields = explode("|",$m[$i][30]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('select2:select', function(e) {
								onBlurClearDependentField(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//If dependent field added then call this function
			if (strlen($m[$i][31]) > 1) {
				$dependentFields = explode("|",$m[$i][31]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('select2:select', function(e) {
								onBlurNonEditableFields(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			


			// select option by enter then cursor going to next field
			echo "<script>
				$(document).ready(function(){

                    //Onload focus on TabIndex if field tabindex 1
                    if('".$m[$i][24]."' == 1){
                        setTimeout(
                            function() {
								console.log('Line 7373 focus')
                                $('#kreon-grid-".$d[3].$m[$i][1]."').next('span').find('.select2-selection--single').focus();
                            }, 300);
                    }

					//Once lost focus from perticular field then again don't allow to focus on this field
					if('".$m[$i][25]."' == 1){
						$('#kreon-grid-".$d[3].$m[$i][1]."').on('select2:open select2:select', function (e) {
							onBlurUpdateLostFocusTabIndex(this,'".$m[$i][0]."');
						});
					}

					if('".$m[$i][23]."' == 1){ //to check if field readonly
						setTimeout(
                            function() {
                                $('#kreon-grid-".$d[3].$m[$i][1]."').next('span').find('.select2-selection--single').css('pointer-events','none').css('background','#eee');
                            }, 300);
					}

					
				});
			</script>";
			if($m[$i][3] < 0){	//IF to be taken from DB
				$index = ((-1) * $m[$i][3]) - 1;
				global $moreextradb;

				// if($FormID == 5098 && $m[$i][1] == 'taxid'){
				// 	print_r($moreextradb);
				// }
				//updated by pornima now moreextradb getting using dbFieldName
				// $dbarray = $moreextradb[$index];
				$dbarray = $moreextradb[$d[7]][$m[$i][1]];
				if($k_debug){ echo "<br /><br />MITESH DEBUG==>>".$i.$m[$i][1]."<pre>"; print_r($m[$i]); print_r($dbarray); echo "</pre>";}
				//carry on field
				if(isset($_SESSION['carryOn'])){
					if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
						if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
							$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
							unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
						}else{
							$gridInputVal = '';
						}
					}
				}

				//If DefaultValue, OnDropDownAjax, CarryOn not empty 
				// if(strlen($m[$i][14]) > 0 || strlen($m[$i][17]) > 2 || $gridInputVal !=''){
				// if(strlen($dbarray[3]) > 2){
				// 	$sql1 .= " AND ".$dbarray[3];
				// }
				// echo "<br>".$m[$i][17] ."===". $gridInputVal;

				if(strlen($m[$i][17]) > 2 && $gridInputVal !=''){
					// If carryon field then added in where condition
					$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0];
					if(strlen($dbarray[3]) > 1){
						$sql1 .= " ".$dbarray[3];
					}else{
						$sql1 .= " WHERE 1=1";
					}
					$sql1 .= " AND ".$dbarray[1]."=".$gridInputVal;

					$result1 = db::getInstance()->db_select($sql1, "F-13953: Cl-");
					$row1 = $result1['result_set'];
				}else if(strlen($m[$i][17]) > 0){
					// If Deault value then added in where condition
					$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0];	
					if(strlen($dbarray[3]) > 1){
						$sql1 .= " ".$dbarray[3];
					}else{
						$sql1 .= " WHERE 1=1";
					}
					$sql1 .= " AND ".$dbarray[1]."=".$m[$i][17];

					$result1 = db::getInstance()->db_select($sql1, "F-13965: Cl-");
					$row1 = $result1['result_set'];
				}else if($gridInputVal !=''){
					// If carryon field then added in where condition
					$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0];
					if(strlen($dbarray[3]) > 1){
						$sql1 .= " ".$dbarray[3];
					}else{
						$sql1 .= " WHERE 1=1";
					}
					$sql1 .= " AND ".$dbarray[1]."=".$gridInputVal;

					$result1 = db::getInstance()->db_select($sql1, "F-13977: Cl-");
					$row1 = $result1['result_set'];
				}
			
				$ddsql = "SELECT TOP 10 ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0]." ".$dbarray[3] ." ";
				$ddresult = db::getInstance()->db_select($ddsql, "F-13982: Cl-");
				// print_r($ddresult);
				if($ddresult){
					$DDSearchPreLoadedArray = [];
					for($r=0; $r < count($ddresult['result_set']); $r++){
						array_push($DDSearchPreLoadedArray,$ddresult['result_set'][$r][$dbarray[2]]);
					}
					$DDSearchPreLoadedD = '';
					$DDSearchPreLoadedD = implode(',',$DDSearchPreLoadedArray);
				
					echo "<script>
						$(document).ready(function(){

							var finalParams = ['".$dbarray[1]."','".$dbarray[2]."'];
							var DDSearchMinInputLen = [];
							if('".$m[$i][15]."' > 0){
								DDSearchMinInputLen['kreon-grid-".$d[3].$m[$i][1]."'] = '".$m[$i][15]."';
							}else{
								DDSearchMinInputLen['kreon-grid-".$d[3].$m[$i][1]."'] = 0;
							}
							var DDSearchPreLoadedData = [];
							var DDSearchPreLoadedDataString = [];
							DDSearchPreLoadedData['kreon-grid-".$d[3].$m[$i][1]."'] = '".json_encode($DDSearchPreLoadedD)."';

							if(DDSearchPreLoadedData['kreon-grid-".$d[3].$m[$i][1]."'].length > 0){
								DDSearchPreLoadedDataString['kreon-grid-".$d[3].$m[$i][1]."'] = ' or more char (like: '+ DDSearchPreLoadedData['kreon-grid-".$d[3].$m[$i][1]."'] +')';
							}else{
								DDSearchPreLoadedDataString['kreon-grid-".$d[3].$m[$i][1]."'] = ' char ';
							}
	
							$('#kreon-grid-".$d[3].$m[$i][1]."').select2({
								//tags: true,
								// multiple: true,
								tokenSeparators: [','],
								//allowClear: true,
								// placeholder: 'select',
								// debug: true,
								minimumInputLength: DDSearchMinInputLen['kreon-grid-".$d[3].$m[$i][1]."'],
								language: {
									inputTooShort: function() {
										return 'Enter ' + DDSearchMinInputLen['kreon-grid-".$d[3].$m[$i][1]."'] + ' '+ DDSearchPreLoadedDataString['kreon-grid-".$d[3].$m[$i][1]."'] ;
									}
								},
								ajax: {
									url: 'getDropDownValue.php',
									dataType: 'json',
									type: 'POST',
									data: function (params) {
										// var hidden = $('form').find(':hidden');	
										var hidden = $('form').find('input[type=\'hidden\']');
										hidden.show();   
										var  formSerialize = $('form').serialize();	
										hidden.hide(); 			
										var queryParameters = {
											searchText: encodeURIComponent(params.term)
											,searchParam:'".$dbarray[2]."'
											,fromRepo:'".$dbarray[0]."'
											,repoCondition:'".$dbarray[3]."'
											,responseParams:finalParams.toString()
											,currentId:'".$m[$i][1]."'
											,FormID:'".$FormID."'
											,GridID:'".$d[7]."'
											,gridSerial:'".$d[3]."'
											,searchText1: formSerialize
										}
										return queryParameters;
									},
									processResults: function (data) {
										return {
											results: $.map(data['data'], function (item) {
												return {
													text: item.ddVal,	
													id: item.ddID
												}
											})
										};
									}
								}
							});

							// initSelection : function (element, callback) {
							// 	var data = {id: 'IN', text: 'INDIA'};
							// 	callback(data);
							// }
							// var newOption = new Option('Pending, 1, false, false);
							// $('#kreon-grid-".$d[3].$m[$i][1]."').append(newOption).trigger('change');
						});

					</script>";
				}
				
				$flds .= '<td class='.$thClass.'><select name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" class="form-control populate" tabindex="'.$m[$i][24].'" ';
				$changeScript = "";
				$onchangeHidden = "";
				
				if($m[$i][8] == 1){
					$onchange = " onchange=\"CreateOnchangeScriptGrid(this);\"";
					$flds .= $onchange;
					$onchangeHidden = '<input type="hidden" id="kreon-grid-'.$d[3].$m[$i][1].'-hidden" value="' . $m[$i][9] . '" />';//,' . $m[$i][1] . ',' . $m[$i][0] . '
				}

				//Check validation using sp onChange
				if($m[$i][22] == 1){
					$flds .= "onchange=\"validateOnChangeSp(this,'".$d[7]."');\"";
				}

				//Check validation using sp on change
				if($m[$i][21] == 1){
					$flds .= "onchange=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
				}

                //On change exicute formula
				$onkeyupHidden ='';
				if(strlen($m[$i][11]) > 2){
					$onkeyupHidden = "";
					$flds .= " onchange=\"CreateOnkeyupScriptGrid(this,'grid');\"";
					$onkeyupHidden = '<input type="hidden" id="kreon-grid-'.$d[3].$m[$i][1].'-onkeyup-hidden" value="' . $m[$i][11] . '" />';
				}
				$flds .= '>';
				if($gridInputVal != '' && strlen($m[$i][17]) == 0){
					//For CarryOn 
					for($j = 0; $j < sizeof($row1); $j++){ 
						$flds .= '<option  value="'. $row1[$j][$dbarray[1]] .'" selected>'.$row1[$j][$dbarray[2]].'</option>&nbsp;';
					}
				}else if($gridInputVal == '' && strlen($m[$i][17]) > 0){
					//For DefaultValue
					for($j = 0; $j < sizeof($row1); $j++){ 
						$flds .= '<option  value="'. $row1[$j][$dbarray[1]] .'" selected>'.$row1[$j][$dbarray[2]].'</option>&nbsp;';
					}
				}else{
					$flds .= '<option value="">'.$m[$i][2].'</option>';
				}

				$flds .= '</select>';

				// small clear button (useful if read-only blocks the ×)
				
				$flds .= '<button type="button"
					style="position:absolute; right:17px; top:3px; color:#444; background:none; border:none; font-size:16px; cursor:pointer;font-weight:bold;"
					title="Clear"
					onclick="clearSelect2Grid(\'kreon-grid-' . $d[3] . $m[$i][1] . '\')"';
				if($m[$i][23] == 1){
					$flds .= ' disabled ';
				}
				$flds .= '>';
				$flds .= '×</button>';

				$flds .= $onchangeHidden.$onkeyupHidden.'</td>';

				echo "<script>
					$(document).ready(function(){
						if ($('.toggle').is(':visible')) {
							$('#kreon-grid-".$d[3].$m[$i][1]."').next('span').css('width','100%');
						}
					});
					</script>";

				if($m[$i][23] > 0){ //to check if field readonly
					echo '<script>
						$("#kreon-grid-'.$d[3].''.$m[$i][1].'").next("span").find(".select2-selection--single").css("pointer-events","none").css("background","#eee");
					</script>';
				}

				// helper used by the clear button
				echo "<script>
				function clearSelect2Grid(id){
					isClearClick = true; // Set the flag before clearing
					console.log('id',id);
					var \$s = $('#'+id);
					\$s.val(null).trigger('change');           // reset select2
					$('#'+id+'-hidden').val && $('#'+id+'-hidden').val('');
					$('#'+id+'-onkeyup-hidden').val && $('#'+id+'-onkeyup-hidden').val('');
					// Fire the same effects as select2:clear for dependents
					\$s.trigger({ type: 'select2:clear' });
				}
				</script>";

				$row1 = [];
			}else{			
				// if($FormID == 5102 ){ echo "<br /><br/>" . $m[$i][1] . " -------- "; var_dump($r[$m[$i][3]]);}
				$flds .= '<td><select name="'.$d[3].''.$m[$i][1].'[]" id="'.$m[$i][1].'" class="form-control" '.$m[$i][6].' >';	//<option value="0">'.$m[$i][2].'</option>
				if(is_array($r[$m[$i][3]])){
					for($j = 0; $j < sizeof($r[$m[$i][3]]); $j++){
						$k = $j+1;  //value
						$flds .= '<option value="'. $k .'" >'.$r[$m[$i][3]][$j].'</option>&nbsp;';
					}
				}else{
					if($_SESSION['Category'] == 2) //Show error for developer login else only error code
						echo "<p style='font-size:20px; color:red;'>Error Code 652: Grid Fields for ".$m[$i][1]." => SOLUTION: Add -1 to ValueFromDb to the Field</p>";
					else 
						echo "<p style='font-size:20px; color:red;'>Error Code 652: Grid Fields for ".$m[$i][1].", Contact Developer</p>";
					$sqlDev = "INSERT INTO DeveloperErrorLogs([FormID],[CompanyID],[DivisionID],[YearCode],[Database_name],[ErrorCode],[ErrorField],[Description],[RecommendedSolution],[CreatedBy],[CreatedAt])Values("
								. $FormID .",". $_SESSION['dbCompany'].",".$_SESSION['dbDivision'].",".$_SESSION['dbYearID'].",'".$_SESSION['dbName']."',652,'".$m[$i][1]."','Dropdown not converted to array','Add -1 to ValueFromDb to the Field',".$_SESSION['user_id'].",GETDATE())";
					$resultDev = db::getInstanceMaster()->db_insertQuery($sqlDev, "F-14179");
				}
				$flds .= '</select></td>';
			}
		}

		if($m[$i][0] == 16){ //Single-select Popup Datatable
			$index = ((-1) * $m[$i][3]) - 1;
			global $moreextradb;
			$dbarray = $moreextradb[$d[7]][$m[$i][1]];

			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
						$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}else{
						$gridInputVal = '';
					}
				}
			}

			if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
				$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0]." where " . $dbarray[1] ."=". $gridInputVal . " " .$dbarray[3];					
				$result1 = db::getInstance()->db_select($sql1, "F-14204: Cl-");
				$row1 = $result1['result_set'];	
			}
			// else{
			// 	$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0]." ".$dbarray[3];
			// }
		
			$flds .= "<td class=".$thClass."><input type='button' data-type='".$m[$i][0]."' onclick='toggleModal(event)' class='form-control' tabindex='".$m[$i][24]."' name='kreon-grid-".$d[3]."".$m[$i][1]."-text[]' id='kreon-grid-".$d[3]."".$m[$i][1]."-text' data-label='".$m[$i][2]."' ";
			
			$SPName = 'sp_GetData_'.$FormID.'_'.$d[7].'_'.$m[$i][1];
			$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
			$checkSp = db::getInstance()->db_select($sql, "F-14215: Cl-");
			if($checkSp['result_set'][0]['found'] == 1){
				$flds .=" data-systemtype=\"2\"";
			}else{
				$flds .=" data-systemtype=\"1\"";
			}

			$flds .= " style='text-align: left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis'>";
		
			$flds .= "<input type='hidden' id='kreon-grid-".$d[3].$m[$i][1]."' name='kreon-grid-".$d[3]."".$m[$i][1]."[]' value='".$gridInputVal."' tabindex='".$m[$i][24]."'></td> ";
			
			echo $ddtableIncludes;
			$row1 = [];
			?>
				<script>
					var pressedButtonId='';
					// Capture the button ID when a button is clicked to trigger saveAdjAmtButton button
					if(<?php echo "'".$m[$i][1]."'"; ?> == 'adjamount' || <?php echo "'".$m[$i][1]."'"; ?> == 'adjamt'){
						$('#saveAdjAmtCloseButton').on('click', function() {
							pressedButtonId = $(this).attr('id');
						});
					}

					//On escape button press cursor move to next tabindex field
					$('#myModal').on('hidden.bs.modal', function (e) {
						hasMoreData = false;
						$('#myModal .modal-body').off('scroll');
						//If noneditable field added then call this function
						<?php
							if (isset($m[$i][31]) && strlen($m[$i][31]) > 1) {
								$dependentFields = explode("|", $m[$i][31]);
								$sourceId = "kreon-grid-".$d[3].$m[$i][1] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
											onBlurNonEditableFields($('#{$sourceId}'), '" . trim($dependentField) . "');
										;
									";
								}
							}
						?>

						//If dependent field added then call this function
						<?php
							if (isset($m[$i][30]) && strlen($m[$i][30]) > 1) {
								$dependentFields = explode("|", $m[$i][30]);
								$sourceId = "kreon-grid-".$d[3].$m[$i][1] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
											onBlurClearDependentField($('#{$sourceId}'), '" . trim($dependentField) . "');
										;
									";
								}
							}
						?>

						var currentFieldId = $('#DropDownModalID').val();
						if(<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?> == currentFieldId){
							if(currentFieldId == 'kreon-grid-aadjamount-text' || currentFieldId == 'kreon-grid-aadjamt-text'){
								if( pressedButtonId == ""){
									$('#saveAdjAmtButton').click();
								}else{
									pressedButtonId = "";
								}
							}
							var tabindex = $('#'+currentFieldId).attr("tabindex");
							tabindex++;

							if(<?php echo $m[$i][25]; ?> == 1){
								if($("#"+<?php echo "'kreon-grid-".$d[3].$m[$i][1]."'"; ?>).val() != ''){							
									onBlurUpdateLostFocusTabIndex(currentFieldId,<?php echo $m[$i][0]; ?>);
								}
							}

							//Check validation using sp on lost focus
							if(<?php echo $m[$i][21]; ?> == 1){
								validateOnLostFocusSp(<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?>,<?php echo "'".$d[7]."'"; ?>);
							}
					
							setTimeout(
								function() {
									// console.log("Line 7718 focus")
									$("[tabindex='"+tabindex+"']").focus();
								}, 300);
						}
					})

					$(document).ready(function () {
						// Focus on the open button after the modal is shown
						// $('#'+<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?>).focus(function() {
						// 	toggleModal();
						// });		

						$('#'+<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?>).on('focus', function(e) {
							toggleModal(e); // Use the event object from the handler
						});	
					});

				</script>
			<?php
		}

		if($m[$i][0] == 17){ //Single-select Popup Datatable
			
			$index = ((-1) * $m[$i][3]) - 1;
			global $moreextradb;
			//updated by pornima now moreextradb getting using dbFieldName
			// $dbarray = $moreextradb[$index];
			$dbarray = $moreextradb[$d[7]][$m[$i][1]];

			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
						$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}else{
						$gridInputVal = '';
					}
				}
			}

			if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
				$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0]." where " . $dbarray[1] ."=". $gridInputVal . " " .$dbarray[3];					
				$result1 = db::getInstance()->db_select($sql1, "F-14336: Cl-");
				$row1 = $result1['result_set'];	
			}
		
			$flds .= "<td class=".$thClass."><input type='button' data-type='".$m[$i][0]."' onclick='toggleModal(event)' class='form-control' tabindex='".$m[$i][24]."' name='kreon-grid-".$d[3]."".$m[$i][1]."-text[]' id='kreon-grid-".$d[3]."".$m[$i][1]."-text' data-label='".$m[$i][2]."' ";
			
			$SPName = 'sp_GetData_'.$FormID.'_'.$d[7].'_'.$m[$i][1];
			$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
			$checkSp = db::getInstance()->db_select($sql, "F-14344: Cl-");
			if($checkSp['result_set'][0]['found'] == 1){
				$flds .=" data-systemtype=\"2\"";
			}else{
				$flds .=" data-systemtype=\"1\"";
			}
			
			$flds .= " style='text-align: left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis'>";
			$flds .= "<input type='hidden' id='kreon-grid-".$d[3].$m[$i][1]."' name='kreon-grid-".$d[3]."".$m[$i][1]."[]' value='".$gridInputVal."' tabindex='".$m[$i][24]."'></td> ";
			
			echo $ddtableIncludes;
			$row1 = [];
		?>
			<script>
				var pressedButtonId='';
				// Capture the button ID when a button is clicked to trigger saveAdjAmtButton button
				if(<?php echo "'".$m[$i][1]."'"; ?> == 'adjamount' || <?php echo "'".$m[$i][1]."'"; ?> == 'adjamt'){
					// alert("hi");
					$('#saveAdjAmtCloseButton').on('click', function() {
						pressedButtonId = $(this).attr('id');
					});
				}

				
				//On escape button press cursor move to next tabindex field
				$('#myModal').on('hidden.bs.modal', function (e) {	
					hasMoreData = false;		
					$('#myModal .modal-body').off('scroll');		
					var currentFieldId = $('#DropDownModalID').val();
				
					if(<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?> == currentFieldId){
						if(currentFieldId == 'kreon-grid-aadjamount-text' || currentFieldId == 'kreon-grid-aadjamt-text'){
							if( pressedButtonId == ""){
								$('#saveAdjAmtButton').click();
								console.log("after data");
							}else{
								pressedButtonId = "";
							}
						}
						var tabindex = $('#'+currentFieldId).attr("tabindex");
						tabindex++;
						//If noneditable field added then call this function
						<?php
							if (isset($m[$i][31]) && strlen($m[$i][31]) > 1) {
								$dependentFields = explode("|", $m[$i][31]);
								$sourceId = "kreon-grid-".$d[3].$m[$i][1] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
											onBlurNonEditableFields($('#{$sourceId}'), '" . trim($dependentField) . "');
										;
									";
								}
							}
						?>

						//If dependent field added then call this function
						<?php

							if (isset($m[$i][30]) && strlen($m[$i][30]) > 1) {
							
								$dependentFields = explode("|", $m[$i][30]);
								$sourceId = "kreon-grid-".$d[3].$m[$i][1] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
											onBlurClearDependentField($('#{$sourceId}'), '" . trim($dependentField) . "');
										;
									";
								}
							}
						?>

						

						if(<?php echo $m[$i][25]; ?> == 1){
							if($("#"+<?php echo "'kreon-grid-".$d[3].$m[$i][1]."'"; ?>).val() != ''){							
								onBlurUpdateLostFocusTabIndex(currentFieldId,<?php echo $m[$i][0]; ?>);
							}
						}

						//Check validation using sp on lost focus
						if(<?php echo $m[$i][21]; ?> == 1){
							validateOnLostFocusSp(<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?>,<?php echo "'".$d[7]."'"; ?>);
						}
				
						// setTimeout(
                        //     function() {
								console.log("Line 7718 focus tabindex", tabindex);
								$("[tabindex='"+tabindex+"']").focus();
							// }, 300);
					}
				})

				$(document).ready(function () {
					// Focus on the open button after the modal is shown
					// $('#'+<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?>).focus(function() {
					// 	toggleModal();
					// });	
					
					$('#'+<?php echo "'kreon-grid-".$d[3].$m[$i][1]."-text'"; ?>).on('focus', function(e) {
						console.log("in field ")
						if (!$(this).is('[readonly]')) {
							toggleModal(e); // Use the event object from the handler
						};
					});
				});

			</script>
		<?php
		}

        if($m[$i][0] == 18){

			//carry on field
			if(isset($_SESSION['carryOn'])){
				if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
					if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
						$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
						unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
					}else{
						$gridInputVal = '';
					}
				}
			}

			if($gridInputVal != NULL){
				if(gettype($gridInputVal) == 'string'){
					$date = strtotime($gridInputVal);
					$gridInputVal = date('h:i', $date);
				}else{
					$gridInputVal = $gridInputVal->format('h:i');
				}
			}

			$flds .= '<td class='.$thClass.'><input class="form-control" type="time" value="'.$gridInputVal.'"  name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" '.$m[$i][6].' tabindex="'.$m[$i][24].'" ';
			
			//Check validation using sp on lost focus
			if($m[$i][21] == 1){
				$flds .= "onfocusout=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
			}

			if($m[$i][23] != 0){ //to check if field readonly
				$flds .= " readonly ";
			}

			//Once lost focus from perticular field then again don't allow to focus on this field
			if($m[$i][25] == 1){
				$flds .= "onblur=\"onBlurUpdateLostFocusTabIndex(this,'".$m[$i][0]."');\"";
			}

			$flds .='/></td>';
		}
		
		if($m[$i][0] == 19){	//Dropdown From DB

			//If dependent field added then call this function
			if (strlen($m[$i][30]) > 1) {
				$dependentFields = explode("|",$m[$i][30]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('select2:select', function(e) {
								onBlurClearDependentField(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			//If dependent field added then call this function
			if (strlen($m[$i][31]) > 1) {
				$dependentFields = explode("|",$m[$i][31]);
				echo "<script>
					$(document).ready(function() {";

						foreach ($dependentFields as $dependentField) {
							echo "$('#kreon-grid-" . $d[3] . $m[$i][1] . "').on('select2:select', function(e) {
								onBlurNonEditableFields(this, '" . trim($dependentField) . "');
							});";
						}

					echo "});
					</script>";
			}

			// select option by enter then cursor going to next field
			echo "<script>
				$(document).ready(function(){

					// $('#kreon-grid-".$d[3].$m[$i][1]."').on('select2:select, select2:close', function (e) { 
					// 	console.log('in');
					// 	var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
					// 	focusable = form.find('input,a,select,button,textarea').filter(':visible');
					// 	next = focusable.eq(focusable.index(this)+1);
					// 	if (next.length) {
					// 		next.focus();
					// 	} 
					// 	return false;
					// });

					//Onload focus on TabIndex if field tabindex 1
                    if('".$m[$i][24]."' == 1){
                        setTimeout(
                            function() {
                                $('#kreon-grid-".$d[3].$m[$i][1]."').next('span').find('.select2-selection--single').focus();
                            }, 300);
                    }

					//Once lost focus from perticular field then again don't allow to focus on this field
					if('".$m[$i][25]."' == 1){
						$('#kreon-grid-".$d[3].$m[$i][1]."').on('select2:open select2:select', function (e) {
							onBlurUpdateLostFocusTabIndex(this,'".$m[$i][0]."');
						});
					}

					if('".$m[$i][23]."' == 1){ //to check if field readonly
						setTimeout(
                            function() {
                                $('#kreon-grid-".$d[3].$m[$i][1]."').next('span').find('.select2-selection--single').css('pointer-events','none').css('background','#eee');
                            }, 300);
					}
				});
			</script>";
			
			if($m[$i][3] < 0){	//IF to be taken from DB
				$index = ((-1) * $m[$i][3]) - 1;
				global $moreextradb;

				//updated by pornima now moreextradb getting using dbFieldName
				// $dbarray = $moreextradb[$index];
				$dbarray = $moreextradb[$d[7]][$m[$i][1]];

				//carry on field
				if(isset($_SESSION['carryOn'])){
					if(trim($FormID) == trim($_SESSION['carryOn']['FormId'])){
						if(isset($_SESSION['carryOn'][$d[3].$m[$i][1]])){
							$gridInputVal = $_SESSION['carryOn'][$d[3].$m[$i][1]];
							unset($_SESSION['carryOn'][$d[3].$m[$i][1]]);
						}else{
							$gridInputVal = '';
						}
					}
				}

				$sql = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0]." ".$dbarray[3] ." ";
				$eresult = db::getInstance()->db_select($sql, "F-14587: Cl-");
			
		
				if(strlen($m[$i][17]) > 2 && $gridInputVal !=''){
					// If carryon field then added in where condition
					$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0];
					if(strlen($dbarray[3]) > 1){
						$sql1 .= " ".$dbarray[3];
					}else{
						$sql1 .= " WHERE 1=1";
					}
					$sql1 .= " AND ".$dbarray[1]."=".$gridInputVal;

					$result1 = db::getInstance()->db_select($sql1, "F-14600: Cl-");
					$p = $result1['result_set'][0][$dbarray[1]];
				}else if(strlen($m[$i][17]) > 0){
					// If Deault value then added in where condition
					$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0];	
					if(strlen($dbarray[3]) > 1){
						$sql1 .= " ".$dbarray[3];
					}else{
						$sql1 .= " WHERE 1=1";
					}
					$sql1 .= " AND ".$dbarray[1]."=".$m[$i][17];

					$result1 = db::getInstance()->db_select($sql1, "F-14612: Cl-");

					$p = $result1['result_set'][0][$dbarray[1]];
				}else if($gridInputVal !=''){
					// If carryon field then added in where condition
					$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0];
					if(strlen($dbarray[3]) > 1){
						$sql1 .= " ".$dbarray[3];
					}else{
						$sql1 .= " WHERE 1=1";
					}
					$sql1 .= " AND ".$dbarray[1]."=".$gridInputVal;

					$result1 = db::getInstance()->db_select($sql1, "F-14625: Cl-");
					$p = $result1['result_set'][0][$dbarray[1]];
				}

				
				
				$flds .= '<td class='.$thClass.'><select data-plugin-selectTwo name="kreon-grid-'.$d[3].''.$m[$i][1].'[]"  placeholder="'.$m[$i][2].'" id="kreon-grid-'.$d[3].''.$m[$i][1].'" class="form-control populate" tabindex="'.$m[$i][24].'"';

				$changeScript = "";

				$onchangeHidden = "";

				if($m[$i][8] == 1){
					$onchange = " onchange=\"CreateOnchangeScriptGrid(this);\"";
					$flds .= $onchange;
					$onchangeHidden = '<input type="hidden" id="kreon-grid-'.$d[3].$m[$i][1].'-hidden" value="' . $m[$i][9] . '" />';//,' . $m[$i][1] . ',' . $m[$i][0] . '
				}

				//Check validation using sp onChange
				if($m[$i][22] == 1){
					$flds .= "onchange=\"validateOnChangeSp(this,'".$d[7]."');\"";
				}

				//Check validation using sp on change
				if($m[$i][21] == 1){
					$flds .= "onchange=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
				}

				//Check validation using sp on change
				if($m[$i][21] == 1){
						$flds .= "onchange=\"validateOnLostFocusSp(this,'".$d[7]."');\"";
				}

				//On change exicute formula
				$onkeyupHidden ='';
				if(strlen($m[$i][11]) > 2){
					$onkeyupHidden = "";
					$flds .= " onchange=\"CreateOnkeyupScriptGrid(this,'grid');\"";
					$onkeyupHidden = '<input type="hidden" id="kreon-grid-'.$d[3].$m[$i][1].'-onkeyup-hidden" value="' . $m[$i][11] . '" />';
				}

				$flds .= '>';


				// if(strlen($m[$i][6]) > 4){
				// 	//Use for get conditional data
				// 	echo "<script>
				// 	$(document).ready(function(){
				// 		$('#kreon-grid-".$d[3].$m[$i][1]."').on('select2:open', function (e) {
							
				// 			var str1 = 'parameters';
				// 			var parametersPos = -1;
				// 			var thissParameters = '".$m[$i][6]."';
				// 			if(thissParameters.indexOf(str1) != -1){
				// 				parametersPos = thissParameters.indexOf(str1);
				// 			}

				// 			if(parametersPos != -1){
				// 				var parametersParams = thissParameters.substring(
				// 					thissParameters.indexOf('{') + 1, 
				// 					thissParameters.lastIndexOf('}')
				// 				);
				// 			}

				// 			if(parametersParams.length > 3){
				// 				var hidden = $('form').find(':hidden');	
				// 				hidden.show();   
				// 				var  formSerialize = $('form').serialize();	
				// 				hidden.hide(); 	

				// 				$.ajax({
				// 					type : 'POST',
				// 					dataType: 'json',
				// 					data : {FieldOtherCondition : '".$m[$i][6]."', gridSerial:'".$d[3]."',searchText: formSerialize, GridID:'".$d[7]."', dbarray0: '".$dbarray[0]."', dbarray1:'".$dbarray[1]."', dbarray2: '".$dbarray[2]."', dbarray3: '".$dbarray[3]."'},
				// 					url : 'getPreLoadedDropDownValue.php',
				// 					success : function(result){
				// 						var newOption = '';
				// 						// $('#kreon-grid-".$d[3]."".$m[$i][1]."').empty().trigger('change');

				// 						for(var j=0; j < result['data'].length; j++){ 
				// 							newOption += '<option value=\"'+result['data'][j]['".$dbarray[1]."']+'\">'+result['data'][j]['".$dbarray[2]."']+'</option>';
				// 							/* var newOption = $('<option ></option>').val(result['data'][j]['".$dbarray[1]."']).text(result['data'][j]['".$dbarray[2]."']) */
				// 						}	
				// 						// if($('#kreon-grid-".$d[3]."".$m[$i][1]."').data('select2')) {
				// 							// $('#kreon-grid-".$d[3]."".$m[$i][1]."').select2('open');
				// 							$('#kreon-grid-".$d[3]."".$m[$i][1]."').append(newOption);
				// 							// $('#kreon-grid-".$d[3]."".$m[$i][1]."').select2('close');
				// 						// }
										
				// 					}
				// 				});
				// 			}
				// 		});
				// 	});
				// 	</script>";
				// }else{
					if(sizeof($eresult) > 0){
						if(sizeof($eresult['result_set']) > 0){
							for($j = 0; $j < sizeof($eresult['result_set']); $j++){
								$k = $eresult['result_set'][$j][$dbarray[1]];  //ID	
								if($p == $k) {
									$flds .= '<option selected value="'. $k .'" >'.$eresult['result_set'][$j][$dbarray[2]].'</option>&nbsp;';
								}
								else {
									$flds .='<option value="'. $k .'" >'.$eresult['result_set'][$j][$dbarray[2]].'</option>&nbsp;';
								}
							}
						}
					}
				// }

				$flds .= '</select>'.$onchangeHidden.'</td>';

			}else{			

				$flds .= '<td class='.$thClass.'><select name="'.$d[3].''.$m[$i][1].'[]" placeholder="'.$m[$i][2].'" id="'.$m[$i][1].'" class="form-control" '.$m[$i][6].' tabindex="'.$m[$i][24].'"';
				
				//Check validation using sp onChange
				if($m[$i][22] == 1){
					$flds .= "onchange=\"validateOnChangeSp(this,'".$d[7]."');\"";
				}

				$flds .= '>';
				// $flds .= '><option value="0">'.$m[$i][2].'</option>';

				for($j = 0; $j < sizeof($r[$m[$i][3]]); $j++){
					$k = $j+1;  //value
					$flds .= '<option value="'. $k .'" >'.$r[$m[$i][3]][$j].'</option>&nbsp;';
				}

				$flds .= '</select></td>';
			}
		}

		if($m[$i][0] == 27){  // Label with Button triggering Bootstrap Modal

			//Set default value
			if(strlen($m[$i][17]) > 0 && $gridInputVal == ""){
				$gridInputVal = $m[$i][17];
			}

			$flds .= '<td class='.$thClass.'><input type="text" class="form-control open-popup" onclick="openCustomPopup(\''.$d[7].'_'.$m[$i][1].'\',\''.$m[$i][6].'\')" data-popup-id="'.$d[7].'_'.$m[$i][1].'" data-extra="'.$m[$i][6].'"  style="text-align: left;white-space: nowrap;overflow:hidden;text-overflow:ellipsis;"
			name="kreon-grid-'.$d[3].''.$m[$i][1].'[]" id="kreon-grid-'.$d[3].''.$m[$i][1].'" '.$m[$i][6].' value="'.$gridInputVal.'" tabindex="'.$m[$i][24].'" readonly /></td>';
		
			?>
			<script>
				//On escape button press cursor move to next tabindex field
				$('#popupGrid').on('hidden.bs.modal', function (e) {
					var currentFieldId = $('#popupGridID').val();
					if(<?php echo "'kreon-grid-".$d[3].$m[$i][1]."'"; ?> == currentFieldId){
						//If noneditable field added then call this function
						<?php
							// echo "hi".$arr[53];												
							if (strlen($m[$i][31]) > 1) {
								$dependentFields = explode("|", $m[$i][31]);
								$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
											onBlurNonEditableFields($('#{$sourceId}'), '" . trim($dependentField) . "');
										;
									";
								}
							}
						?>

						//If dependent field then call on blur
						<?php
							if (strlen($m[$i][32]) > 1) {
								$dependentFields = explode("|",$m[$i][32]);
								$sourceId = $arr[0] . "-text"; // e.g., 'field123-text'
								foreach ($dependentFields as $dependentField) {
									echo "
										onBlurClearDependentField($('#{$sourceId}'), '" . trim($dependentField) . "');
									";
								}
							}
						?>

						var tabindex = $('#'+currentFieldId).attr("tabindex");
						tabindex++;
						$("[tabindex='"+tabindex+"']").focus();
						// console.log(tabindex);

					}
				})
			</script>
			<?php
		}
	}
	
	?>

	<!-- On grid last field tab press Then add or update row -->
	<script>

		$(document).ready(function() {
		var isKeyDown = false;
		var blockNextFocus = false;
		$(document).on('keydown', '#panel<?php echo $d[3]; ?> #GridTable tbody > tr:first > td input, #panel<?php echo $d[3]; ?> #GridTable tbody > tr:first > td select', function(event) {
			console.log('call keydown');
			// event.stopPropagation();
			// event.preventDefault(); 
			var lastFieldId = <?php echo "'".$lastFieldId."'"; ?>;
			var targetId = event.target.id.trim();

			if(lastFieldId.trim() == targetId.trim()){
				console.log(lastFieldId.trim() +"=="+ targetId.trim());
				var targetIdSplit = event.target.id.split('-');
				var gridSerialNo = targetIdSplit[2].charAt(0);
				// console.log(lastFieldId.trim() +"=="+ targetId.trim())
				if (event.key === "Tab" && !event.shiftKey){
					// console.log("pornima gridserial","<?php echo $d[3]; ?>");
					// event.preventDefault(); // Prevent default tab behavior
					// onGridLastFieldAddRow("panel<?php echo $d[3]; ?>");	
					// console.log("after onGridLastFieldAddRow");
					// //The issue occurs when trying to move the focus from one grid to the next grid after adding a row. The following code should be updated to fix this behavior. 
					// setTimeout(function() {
					// 	var nextField = $(event.target)
					// 	if (nextField.length) {
					// 		var tabindex = parseInt(nextField.attr('tabindex'))+2;
						
					// 		console.log("keydown function tabindex",tabindex);
					// 		$("[tabindex='"+tabindex+"']").focus();
					// 	}
					// }, 0);

					onGridLastFieldAddRow("panel<?php echo $d[3]; ?>", function() {
						console.log("blockNextFocus",blockNextFocus);
						// If AddRow() failed → blockNextFocus = true
						if (blockNextFocus) {
							blockNextFocus = false;
							return; // Do NOT shift focus
						}
						console.log("blockNextFocus1",blockNextFocus);
						// AddRow success → now move to next tabindex
						let nextField = $(event.target);
						if (nextField.length) {
							let tabindex = parseInt(nextField.attr('tabindex')) + 2;
							$("[tabindex='" + tabindex + "']").focus();
						}
					});
				}
			}
		});
		
		});
	</script>

	<?php
	$tableHead .= '<th style="width:50px;padding:2px 3px !important;"></th>';
	$gridLastTabIndex = $maxTabindex+1;
	$flds .= '<td style="width:50px;padding1:2px 3px !important;" class="AddEdit" >
				<a  style="padding:3px;"  href="javascript:void(0)" class="btn btn-success add'.$d[3].'" tabindex="'.$gridLastTabIndex.'" title="Alt+G">
					<span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span>
				</a>
				<a  style="padding:3px; display:none;" href="javascript:void(0)" class="btn btn-success update'.$d[3].'">
					<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
				</a>
				<a  style="padding:3px; margin-left:2px;" href="javascript:void(0)" class="btn btn-info refresh'.$d[3].'">
					<span class="glyphicon glyphicon glyphicon-refresh" aria-hidden="true"></span>
				</a>
				<input type="hidden" name="'.$d[3].'GridEditID[]" id="'.$d[3].'GridEditID" value="0">
				<input type="hidden" name="'.$d[3].'GridTempID[]" id="'.$d[3].'GridTempID" value="0">
			</td>';
	$flds .= '</div>';
	$end = '</div></tr>';		
	$script = '<script>
			$(document).ready(function(){
				'.$changeScript.'
				//add more row fields
				var mArray = '.json_encode($m).';
				var gridCalculationFieldName = [];
				var gridCalculationType = [];
				// console.log(mArray);
				//Get current row data

				function getCurrentRowDataForSpValidation(onCLickVariable, mArray,gridEdit){
					// console.log("getCurrentRowDataForSpValidation",onCLickVariable, mArray,gridEdit);
					var cuurrentRowData = "";
					var cuurrentRowDataWithComma = "";
					
					
					for(var t=0; t < mArray.length; t++){			
						if(mArray[t][0] == 17 || mArray[t][0] == 16){
							if(gridEdit == 1){
								var fldvalue= onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
							}else{
								var fldvalue= onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val();
							}
						}else{
							if(gridEdit == 1){
							var fldvalue = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
							}else{
								var fldvalue = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val();
							}
						}
						
						cuurrentRowData += mArray[t][1]+"=";
						if(mArray[t][0] == 0 || mArray[t][0] == 1 || mArray[t][0] == 3 || mArray[t][0] == 6 || mArray[t][0] == 8 || mArray[t][0] == 18 || mArray[t][0] == 27){
							cuurrentRowData += fldvalue != "" ? fldvalue : "";
						}else if(mArray[t][0] == 2 || mArray[t][0] == 5 || mArray[t][0] == 7 || mArray[t][0] == 9 || mArray[t][0] == 10 || mArray[t][0] == 11 || mArray[t][0] == 15 || mArray[t][0] == 16 || mArray[t][0] == 17 || mArray[t][0] == 19){
								if(fldvalue == null){
									cuurrentRowData += 0;
								}else{
									cuurrentRowData += fldvalue != "" ? fldvalue : 0;
								}
						}else if(mArray[t][0] == 12 || mArray[t][0] == 13){
							cuurrentRowData += 0;
						}
						if(t != mArray.length-1)
							cuurrentRowData += "|";

						var decimal=  /^-?\d*\.?\d*$/;

						cuurrentRowDataWithComma += mArray[t][1]+"=";
						if(mArray[t][0] == 0 || mArray[t][0] == 1 || mArray[t][0] == 3 || mArray[t][0] == 5 || mArray[t][0] == 6 || mArray[t][0] == 8 || mArray[t][0] == 18 || mArray[t][0] == 27 ){
							// console.log(mArray[t][1] +" == "+ mArray[t][0] +" == "+ fldvalue);
							if(fldvalue == undefined || fldvalue == "" || fldvalue == null){
								// if(mArray[t][0] == 5){
									// console.log("if"+mArray[t][1]);
									cuurrentRowDataWithComma += (fldvalue != "" && fldvalue != null) ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
								// }else{
								// 	cuurrentRowDataWithComma += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
								// }
							}else{
								
								if(fldvalue.match(decimal)) {
									// console.log("decimal"+mArray[t][1]);
									cuurrentRowDataWithComma += fldvalue != "" ? fldvalue : "\'\'\'\'"; //remove single quote
								}else{
									// console.log("not decimal"+mArray[t][1]);
									cuurrentRowDataWithComma += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
								}
							}
						}else if(mArray[t][0] == 2 || mArray[t][0] == 7 || mArray[t][0] == 9 || mArray[t][0] == 10 || mArray[t][0] == 11 || mArray[t][0] == 15 || mArray[t][0] == 19){
							cuurrentRowDataWithComma += fldvalue != "" ? fldvalue : 0;
						}else if(mArray[t][0] == 12 || mArray[t][0] == 13){
							cuurrentRowDataWithComma += 0;
						}else if(mArray[t][0] == 16 || mArray[t][0] == 17){
							
							cuurrentRowDataWithComma += (fldvalue != "" && fldvalue != "null") ? "\'\'"+fldvalue+"\'\'" : "\'\'0\'\'";

						}
						if(t != mArray.length-1)
							cuurrentRowDataWithComma += ",";
					}
					return [cuurrentRowData,cuurrentRowDataWithComma];
				}

				
			
				$(".add'.$d[3].'").click(function(){
					// console.log("call add function");
					//Add Button disabled
					$(".add'.$d[3].'").attr("disabled", true);
					
					var onCLickVariable = $(this);
					var gridEdit = 0
					var [currentData,cuurrentRowDataWithComma] = getCurrentRowDataForSpValidation(onCLickVariable,mArray,gridEdit);
					
					var prevCnt = $("#cnt'.$d[3].'").val();	

					//Check the DeletedGridRowID field — if a deleted row ID is available, reuse that ID for the new row; otherwise, assign a new ID
					var deletedGridRowIDs = $("#DeletedGridRowID'.$d[3].'").val();
					if(deletedGridRowIDs.length > 0){
						// Split string into array
						var allIDs = deletedGridRowIDs.split(",");

						// Filter by prefix and sort ascending
						var filteredIDs = allIDs
							.sort((x, y) => parseInt(x.slice(1)) - parseInt(y.slice(1))); // numeric sort

						// Get first value (smallest number)
						var firstValue = filteredIDs[0];
						var cnt = parseInt(firstValue.slice(1));
	
					}else{
						var cnt = +prevCnt + 1;
					}

					// console.log("going into ajax");
					$.ajax({
						type : "POST",
						dataType: "json",
						data : {ValidationOn:"gridsave", formData: currentData, formDataWithComma:cuurrentRowDataWithComma, mainFormData:$("form").serialize(), FormID:"'.$FormID.'", GridID:$("#GridId'.$d[3].'").val(), GridRowTempId: cnt},
						url : "validateForm.php",
						success: function(output) {
							console.log("O/p",output);
							if(output["status"] == true){
								if(output["data"]["Success"] == 1){
									
									// await AddRow(onCLickVariable,prevCnt,cnt);
									AddRow(onCLickVariable, prevCnt, cnt).then(() => {
										$(".add'.$d[3].'").attr("disabled", false);
										
										if(output["tempData"]){
											console.log(output["tempData"][0]);
											$("#"+Object.keys(output["tempData"][0])).empty();
											for(var i=0; i<output["tempData"].length; i++){
												$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
											}
										}
									});
								}else{
									if(output["data"]["Success"] == 2){
										if (confirm(output["data"]["Msg"]+". Are you sure you want to submit?") == true) {
											// await AddRow(onCLickVariable,prevCnt,cnt);
											AddRow(onCLickVariable, prevCnt, cnt).then(() => {
												$(".add'.$d[3].'").attr("disabled", false);
												if(output["tempData"]){
													$("#"+Object.keys(output["tempData"][0])).empty();
													for(var i=0; i<output["tempData"].length; i++){
														$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
													}
												}
											});

										}else {
											$(".add'.$d[3].'").attr("disabled", false);
										}
									}else if(output["data"]["Success"] == 0){
										alert(output["data"]["Msg"]);
										$(".add'.$d[3].'").attr("disabled", false);
									}else{
										alert("Internal Server Error");
										$(".add'.$d[3].'").attr("disabled", false);
									}
								}
							}else{
								AddRow(onCLickVariable, prevCnt, cnt).then(() => {
									// await AddRow(onCLickVariable,prevCnt,cnt);
									$(".add'.$d[3].'").attr("disabled", false);
								});
							}
						}
					});
				});

				async function getBase64(file) {
					return new Promise((resolve) => {
						// Check if the file is a valid Blob or File object
						if (!(file instanceof Blob)) {
						console.error("Expected a Blob or File object");
						return resolve(null); // Resolve with null in case of an error
						}

						const reader = new FileReader();
						
						reader.onload = () => {
						// Resolve with the base64 string (cleaned up)
						resolve(reader.result.replace("data:", "").replace(/^.+,/, ""));
						};
						
						reader.onerror = () => {
						// Resolve with null if an error occurs while reading the file
						resolve(null);
						};
						
						// Read the file as a data URL (base64)
						reader.readAsDataURL(file);
					});
				}

				async function base64AjaxFunction(base64String, imgFieldName, gridSerial, ext, prevCnt, gridId) {
				console.log("base64AjaxFunction", imgFieldName, gridSerial, ext, prevCnt, gridId);

				// Wrap the AJAX call in a Promise so we can use await
				const result = await new Promise((resolve, reject) => {
					$.ajax({
						type: "POST",
						url: "media.php",
						data: { Media: base64String, ext: ext, gridId: gridId, imgFieldName: imgFieldName },
						success: function (response) {
							try {
								const parsedResult = JSON.parse(response);
								console.log(parsedResult);
								if (parsedResult.response === "true") {
									resolve(parsedResult);  // Resolving the promise with the result
								} else {
									alert("Error while saving data..!");
									resolve(null);  // Resolving with null in case of error
								}
							} catch (error) {
								reject(error);  // Rejecting if JSON parsing fails
							}
						},
						error: function (xhr, status, error) {
							reject(error);  // Rejecting in case of AJAX error
						}
					});
				});

				return result;
			}


				//this function use for after adding row focus move on field type 5
				function focusSelect2Search() {
					const searchField = document.querySelector(".select2-container--open .select2-search__field");
					if (searchField) {
						searchField.focus();
					} else {
						setTimeout(focusSelect2Search, 50); // Try again in 50ms
					}
				}


				// Add row in grid
				async function AddRow(onCLickVariable,prevCnt,cnt){
					console.log("AddRow FN")
					var fieldArray = [];
					var mfld = "";
					var thClass="";
					var MediaDetails;
					
					for(var t=0; t < mArray.length; t++){
						console.log("new F-15231: ",mArray, t);
						if(mArray[t][0] == 17 || mArray[t][0] == 16){
							var fldvalue = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val();
							
							var fldvalue1 = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val();
							
						}else{
							var fldvalue = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1].trim()).val();
						}
						
						fieldArray.push([mArray[t][0],"kreon-grid-'.$d[3].'"+mArray[t][1],mArray[t][16],mArray[t][17],mArray[t][12],mArray[t][23]]); //fieldtype,dbfieldname,CarryOn,DefaultValue,GridCalculation,ReadOnly
						console.log("new F-15242: ", t, fieldArray);
						
						if(mArray[t][5] == 1 && fldvalue == ""){
							blockNextFocus = true;
							console.log("pornima",mArray[t][0], " - ", mArray[t][5], " - ", fldvalue);
							if(mArray[t][0] == 17 || mArray[t][0] == 16){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").css("border","1px solid red");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").focus();

							}else if(mArray[t][0] == 5 || mArray[t][0] == 19){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).next("span").css("border","1px solid red");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).focus();
							}else{
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).css("border","1px solid red");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).focus();
							}
							
							alert("First column cannot be blank");
							return false;
						}else if(mArray[t][5] == 1 && fldvalue == "0"){
							console.log("pornima1",mArray[t][0], " - ", mArray[t][5], " - ", fldvalue);
							if(mArray[t][0] == 5 || mArray[t][0] == 19){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).next("span").css("border","1px solid red");
							}else{
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).css("border","1px solid red");
							}
							$("#kreon-grid-'.$d[3].'"+mArray[t][1]).focus();
							alert("First column cannot be 0");
							return false;
						}

						if(mArray[t][26] == 0){ //To check visibility
							thClass = " thHidden ";
						}

						if(mArray[t][0] == 0){
							fldvalue = fldvalue.replace("\'", "&lsquo;");
							mfld += "<td class=\'"+thClass+"\'><input readonly type=\"hidden\" value=\'"+fldvalue+"\' class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'></td>";
						}

						if(mArray[t][0] == 1){
							fldvalue = fldvalue.replace("\'", "&lsquo;");
							mfld += "<td class=\'"+thClass+"\'><input readonly type=\"text\" value=\'"+fldvalue+"\' class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'></td>";

							// If GridCalculation 1 then add sum in footer
							if(mArray[t][12] > 0){
								if (!gridCalculationFieldName.includes(mArray[t][1])) {
									gridCalculationFieldName.push(mArray[t][1]);
									gridCalculationType.push(mArray[t][12]);
								}
							}
						}

						if(mArray[t][0] == 3){
							fldvalue = fldvalue.replace("\'", "&lsquo;");
							mfld += "<td class=\'"+thClass+"\'><textarea readonly type=\"number\" class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'>"+fldvalue+"</textarea></td>";
						}

						if(mArray[t][0] == 7){
							
							mfld += "<td class=\'"+thClass+"\'><input readonly type=\"number\" value=\'"+fldvalue+"\' class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'></td>";
							if(mArray[t][12] > 0){
								if (!gridCalculationFieldName.includes(mArray[t][1])) {
									gridCalculationFieldName.push(mArray[t][1]);
									gridCalculationType.push(mArray[t][12]);
								}
							}
							
						}

						if(mArray[t][0] == 6){
							mfld += "<td class=\'"+thClass+"\'><input readonly type=\"date\" value=\'"+fldvalue+"\' class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'></td>";
						}

						if(mArray[t][0] == 5 || mArray[t][0] == 19){
							var selectedOption = $("#kreon-grid-'.$d[3].'"+mArray[t][1] + " :selected").text();
							
							// Check if fldvalue is null and adjust both fldvalue and selectedOption
							mfld += "<td class=\'"+thClass+"\'><select readonly style=\'pointer-events: none;\' name=\''.$d[3].'"+mArray[t][1]+"[]\'  placeholder=\'"+mArray[t][2]+"\' id=\''.$d[3].'"+mArray[t][1]+"\' class=\'form-control populate\'>";
							
							if(fldvalue === null || fldvalue == 0 || fldvalue === "0"){
								// console.log("if");
								mfld += "<option value=\'0\'>" + mArray[t][2] + "</option>";
							}else{
								// console.log("else");
								mfld += "<option value=\'"+fldvalue+"\'>"+selectedOption+"</option>";
							}
							mfld += "</select></td>";

							// var selectedOption = $("#kreon-grid-'.$d[3].'"+mArray[t][1] + " :selected").text();
							// mfld += "<td class=\'"+thClass+"\'><select readonly style=\'pointer-events: none;\' name=\''.$d[3].'"+mArray[t][1]+"[]\'  placeholder=\'"+mArray[t][2]+"\' id=\''.$d[3].'"+mArray[t][1]+"\' class=\'form-control populate\'>";
							// fldvalue = fldvalue === null ? 0 : fldvalue;
							// mfld += "<option value=\'"+fldvalue+"\'>"+selectedOption+"</option>";
							// mfld += "</select></td>";
						}


						if(mArray[t][0] == 12){
							
							var file = $("#kreon-grid-'.$d[3].'"+mArray[t][1]).prop("files")[0];
							var imgFieldName = mArray[t][1];
							var gridSerial = "'.$d[3].'";
							var filePath = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(); 
							var ext = filePath.substr(filePath.lastIndexOf(".")+1,filePath.length);
							var targetRowId = gridSerial+""+cnt;
							var gridId = "'.$d[7].'";
							var imgFlag = false;
							console.log(t, imgFieldName, gridSerial, ext, targetRowId, gridId);

							if(file !== undefined){
								// Get base64 string & assign to function
								base64String = await getBase64(file);
								if(base64String !== null){
									// Await the result of base64AjaxFunction before proceeding
									let MediaResult = await base64AjaxFunction(base64String, imgFieldName, gridSerial, ext, targetRowId, gridId);

									if (MediaResult && MediaResult.response === "true") {
										var MediaID = MediaResult.data;
										var MediaPath = MediaResult.imagepath;

										if (MediaID == 0) {
											console.log("MediaID is 0", MediaID);
										} else {
										 	imgFlag = true;
											console.log("MediaID is not 0", MediaID, MediaPath);
											mfld += "<td class=\'" + thClass + "\'><input readonly type=\'hidden\' value=\'" + MediaID + "\' class=\'form-control\' name=\'' . $d[3] . '" + mArray[t][1] + "[]\' id=\'' . $d[3] . '" + mArray[t][1] + "\'>"
												+ "<a target=\'_blank\' href=\'" + MediaPath + "\'><img src=\'" + MediaPath + "\' width=\'60\'></a>"
												+ "</td>";
										}
									} else {
										console.log("Error while fetching MediaID");
									}
								}
							}
							if(!imgFlag){
								mfld += "<td class=\'" + thClass + "\'><input readonly type=\'hidden\' value=\'\' class=\'form-control\' name=\'' . $d[3] . '" + mArray[t][1] + "[]\' id=\'' . $d[3] . '"+ mArray[t][1] + "\'></td>";
							}
							/*
							// //Get base64 string & assing to function
							// base64String = await getBase64(file)
							// // MediaResult = await base64AjaxFunction(base64String,imgFieldName,gridSerial,ext,targetRowId,gridId)
							// var MediaID = 0; var MediaPath= "";
							// base64AjaxFunction(base64String,imgFieldName,gridSerial,ext,targetRowId,gridId).then(function(MediaResult) {
							// 	console.log("MediaResult", MediaResult)
							// 	MediaID = MediaResult.data;
							// 	MediaPath = MediaResult.imagepath;
							// });
							
							// if(MediaID == 0){
							// 	console.log("MediaID is 0", MediaID)
							// 	mfld += "<td class=\'"+thClass+"\'><input readonly type=\"hidden\" value=\"\" class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'></td>";
							// }else{
							// 	console.log("MediaID is not 0", MediaID, MediaPath)
							// 	mfld += "<td class=\'"+thClass+"\'><input readonly type=\"hidden\" value=\"" + MediaID + "\" class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'>"
							// 		+ "<a target=\"_blank\" href=\'" + MediaPath + "\'><img src=\'" + MediaPath + "\' width=\"60\"></a>"
							// 		+ "</td>";
							// }	
							*/
							
						}

						if(mArray[t][0] == 16){
							mfld += "<td class=\'"+thClass+"\'><input type=\"text\" value=\'"+fldvalue+"\' class=\'form-control\'  name=\''.$d[3].'"+mArray[t][1]+"-text[]\'   id=\''.$d[3].'"+mArray[t][1]+"-text\'><input type=\"hidden\" id=\''.$d[3].'"+mArray[t][1]+"\' name=\''.$d[3].'"+mArray[t][1]+"[]\' value=\'"+fldvalue1+"\'></td>";
							console.log(mfld);
							// If GridCalculation 1 then add sum in footer
							if(mArray[t][12] > 0){
								if (!gridCalculationFieldName.includes(mArray[t][1])) {
									gridCalculationFieldName.push(mArray[t][1]);
									gridCalculationType.push(mArray[t][12]);
								}
							}
						}

						if(mArray[t][0] == 17){
							mfld += "<td class=\'"+thClass+"\'><input disabled type=\"text\" value=\'"+fldvalue+"\' class=\'form-control\'  name=\''.$d[3].'"+mArray[t][1]+"-text[]\'   id=\''.$d[3].'"+mArray[t][1]+"-text\'><input type=\"hidden\" id=\''.$d[3].'"+mArray[t][1]+"\' name=\''.$d[3].'"+mArray[t][1]+"[]\' value=\'"+fldvalue1+"\'></td>";
							// console.log(mfld);
							// If GridCalculation 1 then add sum in footer
							if(mArray[t][12] > 0){
								if (!gridCalculationFieldName.includes(mArray[t][1])) {
									gridCalculationFieldName.push(mArray[t][1]);
									gridCalculationType.push(mArray[t][12]);
								}
							}
						}

						if(mArray[t][0] == 18){
							mfld += "<td class=\'"+thClass+"\'><input readonly type=\"time\" value=\'"+fldvalue+"\' class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'></td>";
						}

						if(mArray[t][0] == 27){  // Label with Button triggering Bootstrap Modal
							mfld += "<td class=\'"+thClass+"\'><input readonly type=\"text\" value=\'"+fldvalue+"\' class=\'form-control\'   name=\''.$d[3].'"+mArray[t][1]+"[]\'   id=\''.$d[3].'"+mArray[t][1]+"\'></td>";
						}
					}

					//Check the DeletedGridRowID field — if a deleted row ID is available, reuse that ID for the new row; otherwise, assign a new ID
					var deletedGridRowIDs = $("#DeletedGridRowID'.$d[3].'").val();
					if(deletedGridRowIDs.length > 0){
						var cnt = +prevCnt + 1;

						// Split string into array
						var allIDs = deletedGridRowIDs.split(",");

						// Filter by prefix and sort ascending
						var filteredIDs = allIDs
							.sort((x, y) => parseInt(x.slice(1)) - parseInt(y.slice(1))); // numeric sort

						// Get first value (smallest number)
						var firstValue = filteredIDs[0];
						var prevCnt = parseInt(firstValue.slice(1));
						
						// Remove that first value from main list
						var updatedIDs = allIDs.filter(id => id !== firstValue);

						// Update the hidden field
						$("#DeletedGridRowID'.$d[3].'").val(updatedIDs.join(","));

						var headofGrid = \''.$headerGridStart.'\' + prevCnt + \''.$headerGridEnd.'\';

						mfld += "<td><a style=\"padding:3px;margin:2px;\" href=\"javascript:void(0)\" class=\"btn btn-info edits'.$d[3].'\"><span class=\"glyphicon glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a><a style=\"padding:2px 3px;\" href=\"javascript:void(0)\" class=\"btn btn-danger removes'.$d[3].'\"><span class=\"glyphicon glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a><input type=\"hidden\" name=\"'.$d[3].'GridEditID[]\" id=\"'.$d[3].'GridEditID\" value=\"0\"><input type=\"hidden\" name=\"'.$d[3].'GridTempID[]\" id=\"'.$d[3].'GridTempID\" value=\'"+prevCnt+"\'></td>";
						var end =\''.$end.'\';
						document.getElementById("cnt'.$d[3].'").value = cnt;
						
					}else{
						prevCnt = parseInt(prevCnt)+1;

						cnt = await checkGridTempIDUnique("'.$d[3].'",cnt);
						var headofGrid = \''.$headerGridStart.'\' + cnt + \''.$headerGridEnd.'\';

						mfld += "<td><a style=\"padding:3px;margin:2px;\" href=\"javascript:void(0)\" class=\"btn btn-info edits'.$d[3].'\"><span class=\"glyphicon glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></a><a style=\"padding:2px 3px;\" href=\"javascript:void(0)\" class=\"btn btn-danger removes'.$d[3].'\"><span class=\"glyphicon glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></a><input type=\"hidden\" name=\"'.$d[3].'GridEditID[]\" id=\"'.$d[3].'GridEditID\" value=\"0\"><input type=\"hidden\" name=\"'.$d[3].'GridTempID[]\" id=\"'.$d[3].'GridTempID\" value=\'"+cnt+"\'></td>";
						var end =\''.$end.'\';
						document.getElementById("cnt'.$d[3].'").value = cnt;
					}
					
			
					
					$("#panel'.$d[3].' table tbody tr:first").after(headofGrid + mfld + end);
					// $("#panel'.$d[3].' table tbody").append(headofGrid + mfld + end);
					
					//Call grid total calculation functions
					if(gridCalculationFieldName.length > 0){
						CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType,"'.$d[3].'");	
					}

					//Clear input value of first row
					for(var s=0; s < fieldArray.length; s++){
						if(fieldArray[s][2] != 1 && fieldArray[s][2] != 2){
							
							if(fieldArray[s][0] == 5 || fieldArray[s][0] == 19){
							
								if (fieldArray[s][3] && fieldArray[s][3].length > 0) {
									//If Default value
									if(fieldArray[s][2] == null || fieldArray[s][2] == 0){
										
										// $("#"+fieldArray[s][1]).select2("open");
										$("#"+fieldArray[s][1]).val(fieldArray[s][3]).trigger("change");
										// $("#"+fieldArray[s][1]).select2("close");
									}
								}else{
									// Step 1: Get the current onchange function as a string. onchange function remove & then adding because after adding row onchange function triggering so
									let onchangeFunction = $("#" + fieldArray[s][1]).attr("onchange");

									// Step 2: If onchange function exists, store it, remove it temporarily
									if (onchangeFunction) {
										// Step 2: Remove the onchange attribute temporarily
										$("#" + fieldArray[s][1]).removeAttr("onchange");

										// $("#"+fieldArray[s][1]).select2("open");
										$("#"+fieldArray[s][1]).val(0).trigger("change");
										// $("#"+fieldArray[s][1]).select2("close");

										// Step 4: Re-add the original onchange function with the stored value
										$("#" + fieldArray[s][1]).attr("onchange", onchangeFunction);
									}else{
										// $("#"+fieldArray[s][1]).select2("open");
										$("#"+fieldArray[s][1]).val(0).trigger("change");
										// $("#"+fieldArray[s][1]).select2("close");
									}
								}

								//after add if not readonly then remove readonly
								if(fieldArray[s][5] != 1){
									$("#"+fieldArray[s][1]).next("span").find(".select2-selection--single").prop("readonly", false).css("pointer-events","").css("background-color","white");
								}
							}
						
							fieldName = fieldArray[s][1].split("-");
							
							if(fieldArray[s][0] == 17 || fieldArray[s][0] == 16){
								console.log("pornima in field type 17 ",fieldName,fieldArray[s][3]);
								if(fieldArray[s][3] == null || fieldArray[s][3] == 0 || fieldArray[s][3].length == 0){
									$("#"+fieldName[0]+"-"+fieldName[1]+"-'.$d[3].'"+fieldName[2].slice(1)+"-text").val("");
									$("#"+fieldName[0]+"-"+fieldName[1]+"-'.$d[3].'"+fieldName[2].slice(1)).val("");
								}
								
								//after add if not readonly then remove readonly
								if(fieldArray[s][5] != 1){
									$("#"+fieldName[0]+"-"+fieldName[1]+"-'.$d[3].'"+fieldName[2].slice(1)+"-text").prop("readonly", false).css("pointer-events","").css("background-color","white");
								}
							}else{
								if(fieldArray[s][3] == null){
									$("#"+fieldArray[s][1].trim()).val("");
									$("#'.$d[3].'GridTempID").val(0);
								}else{
									$("#"+fieldArray[s][1]).val(fieldArray[s][3]);	
								}

								//after add if not readonly then remove readonly
								if(fieldArray[s][5] != 1){
									$("#"+fieldArray[s][1]).prop("readonly", false).css("pointer-events","").css("background-color","white");
								}		
							}

							$("#"+fieldArray[s][1]).css("border","1px solid #aa8a");
						}

						if(fieldArray[s][2] == 2){
							var fieldValueStr = $("#"+fieldArray[s][1]).val();
							var splitIndex = fieldValueStr.lastIndexOf("-");
							var part1 = fieldValueStr.substring(0, splitIndex); // Before the last hyphen
							var part2 = fieldValueStr.substring(splitIndex + 1); // After the last hyphen

							var increementValue = parseInt(part2)+1;
							if(part1.length > 0){
								var changeValue = part1+"-"+increementValue;
							}else{
								var changeValue = increementValue;
							}
							$("#"+fieldArray[s][1]).val(changeValue);
						}
					}

				
					var isFocusOnSpecificField = false;
					if("'.$d[9].'".length > 1){
						//Cursor focus on grid perticular field that was mention in AfterGridAddCursorPosition field
						isFocusOnSpecificField = true;
					}else{
						//on click add button next grid not found then exicute this code. else as per tab index it will move focus to next field
						var addButtonTabIndex = parseInt($(".add'.$d[3].'").attr("tabindex"), 10);
					
						if (!isNaN(addButtonTabIndex)) {
							addButtonTabIndex++;
							if ($("form [tabindex="+addButtonTabIndex+"]").length == 0) {
								//on row add Cursor focus on grid first field					
								if("'.$d[9].'".length < 1){
									if(mArray[0][0] == 17){
										console.log("if");
										$("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
									}else if(mArray[0][0] == 16){
										$("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
									}else{
										$("#kreon-grid-'.$d[3].'"+mArray[0][1]).focus(); //Cursor focus on grid first field
									}
								}
									// else{

									// //Cursor focus on grid perticular field that was mention in AfterGridAddCursorPosition field
									// isFocusOnSpecificField = true;
									
									// }
							}
						}
					}


					if(isFocusOnSpecificField){
						for(var s=0; s < fieldArray.length; s++){
							if (fieldArray[s][0] == 17 || fieldArray[s][0] == 16) {
								if (fieldArray[s][1]+"-text" == "kreon-grid-' . $d[3] . '' . $d[9] . '-text") {
									$("#" + fieldArray[s][1]+"-text").focus();
									break;
								}
							}else if(fieldArray[s][0] == 5){
								if(fieldArray[s][1] == "kreon-grid-'.$d[3].''.$d[9].'"){
									// console.log(fieldArray[s][1] +"=="+ "kreon-grid-'.$d[3].''.$d[9].'");
									// $("#" + fieldArray[s][1])
									// 	.one("select2:open", function () {
									// 		setTimeout(() => {
									// 			document.querySelector(".select2-container--open .select2-search__field")?.focus();
									// 		}, 1000);
									// 	})
									// 	.select2("open");

									// $("#" + fieldArray[s][1]).val(0).trigger("change"); // Optional: reset value

									$("#" + fieldArray[s][1]).select2("open");
									focusSelect2Search();
									break;
								}
							}else{
								if(fieldArray[s][1] == "kreon-grid-'.$d[3].''.$d[9].'"){
									console.log(fieldArray[s][1] +"=="+ "kreon-grid-'.$d[3].''.$d[9].'");
									$("#" + fieldArray[s][1]).focus();
									break;
								}
							}
						}
					}
			
				}
				async function checkGridTempIDUnique(ser, oldCnt){
					console.log("checkGrid Temp ID", ser, oldCnt);
					while ($(".grp" + ser + " #" + ser + "GridTempID").filter(function () {
							// console.log("checking", $(this).val());
							return $(this).val() == oldCnt;
						}).length > 0) {
						oldCnt++;
					}
					// console.log("checkGrid Temp ID", ser, oldCnt);
					return oldCnt;
				}
				//remove row
				$("#panel'.$d[3].'").on("click",".removes'.$d[3].'",function(){
					//Delete Button disabled
					$(".removes'.$d[3].'").attr("disabled", true);

					var onCLickVariable = $(this);
					var gridEdit = 1;
					var [currentData, cuurrentRowDataWithComma] = getCurrentRowDataForSpValidation(onCLickVariable,mArray,gridEdit);
					console.log(currentData);
					var GridEditId = onCLickVariable.closest("tr").find("#'.$d[3].'GridEditID").val();
					var GridTempId = onCLickVariable.closest("tr").find("#'.$d[3].'GridTempID").val();
					

					$.ajax({
						type : "POST",
						dataType: "json",
						data : {ValidationOn:"griddelete", formData: currentData, FormID:"'.$FormID.'", GridID:$("#GridId'.$d[3].'").val(), GridEditID: GridEditId, GridRowTempId: GridTempId},
						url : "validateForm.php",
						success:function(output) {
							if(output["status"] == true){
								if(output["data"]["Success"] == 1){
									var rowCount = $(".grid'.$d[3].' #GridTable tbody tr").length;
									if(rowCount == 2){
										if(output["data"]["EditableFields"]){
											//on grid last row delete refresh dependent fields
											refreshDependentEditableFields(output["data"]["EditableFields"]);	
										}
									}

									RemoveRow(onCLickVariable);
									$(".removes'.$d[3].'").attr("disabled", false);
									if(output["tempData"]){
										console.log(output["tempData"][0]);
										$("#"+Object.keys(output["tempData"][0])).empty();
										for(var i=0; i<output["tempData"].length; i++){
											$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
										}
									}
								}else{
									if(output["data"]["Success"] == 2){
										var cleanedMsg = output["data"]["Msg"]
										.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
										.replace(/\\\\/g, "");     // remove remaining double backslashes

										if (confirm(cleanedMsg+". Are you sure you want to submit?") == true) {
											var rowCount = $(".grid'.$d[3].' #GridTable tbody tr").length;
											if(rowCount == 2){
												//on grid last row delete refresh dependent fields
												refreshDependentEditableFields(output["data"]["EditableFields"]);
												
											}
											RemoveRow(onCLickVariable);
											$(".removes'.$d[3].'").attr("disabled", false);
											if(output["tempData"]){
												// console.log(output["tempData"][0]);
												$("#"+Object.keys(output["tempData"][0])).empty();
												for(var i=0; i<output["tempData"].length; i++){
													$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
												}
											}
										} else {
											$(".removes'.$d[3].'").attr("disabled", false);
										}
									}else if(output["data"]["Success"] == 0){
										var cleanedMsg = output["data"]["Msg"]
										.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
										.replace(/\\\\/g, "");     // remove remaining double backslashes
										alert(cleanedMsg);
										$(".removes'.$d[3].'").attr("disabled", false);
									}else{
										alert("Internal Server Error");
										$(".add'.$d[3].'").attr("disabled", false);
									}
								}
							}else{
								RemoveRow(onCLickVariable);
								$(".removes'.$d[3].'").attr("disabled", false);
							}
						}
					});
				});

			
				function refreshDependentEditableFields(dependentfields) {
					console.log("dependentfields",dependentfields);
					var dependentFields = dependentfields.split(/\|/).map(s => s.trim());

					dependentFields.forEach(function(depField) {
						console.log("Processing:", depField);

						var match = depField.match(/^(\d+)_([^_].*)$/);
						let field;

						if (match) {
							var numberPart = match[1];  // e.g., "1738"
							var textPart = match[2];    // e.g., "designid"

							var className = $("#grid-id-" + numberPart).attr("class");
							var lastChar = className ? className.slice(-1) : ""; // avoid error if className is undefined
							depField = "kreon-grid-" + lastChar + textPart;
							field = document.getElementById(depField);
						} else {
							field = document.getElementById(depField);
						}
						console.log("field",field);
						if (!field) return; // skip if field is not found

						let fieldType = field?.type;
						console.log("fieldType",fieldType);
						// ✅ clear sibling visible input with -text ID
						$(field).siblings("input[id=" + depField + "-text]").each(function () {
							console.log("depField",$(this));
							$(this).val("");
							$(this).css({"pointer-events": "","background": ""});
						});

						// ✅ Reset value based on type
						if (fieldType === "text" || fieldType === "date" || fieldType === "number" || fieldType === "email" || fieldType === "textarea" || fieldType === "time" || fieldType === "hidden") {
							$("#" + depField).val("");
							$("#" + depField).prop("readonly", false);
						} else if (fieldType === "select-one") {
							$("#" + depField).val(0).trigger("change");
						}
					});
				}

				function RemoveRow(onCLickVariable){
					// If GridCalculation 1 then add sum in footer
					for(var t=0; t < mArray.length; t++){
						//If GridCalculation greater than 0 then add field name & calculation type in array
						if(mArray[t][12] > 0){
							if (!gridCalculationFieldName.includes(mArray[t][1])) {
								gridCalculationFieldName.push(mArray[t][1]);
								gridCalculationType.push(mArray[t][12]);
							}
						}
					}

					//Add in hidden variable for when adding any new row then get this id
					var DeletedRowId = onCLickVariable.closest("tr").attr("id");
					var $deletedField = $("#DeletedGridRowID'.$d[3].'");
					var currentValue = $deletedField.val();

					if (currentValue) {
						// Check if DeletedRowId is already in the list
						var ids = currentValue.split(",");
						if (!ids.includes(DeletedRowId.toString())) {
							ids.push(DeletedRowId);
						}
						$deletedField.val(ids.join(","));
					} else {
						$deletedField.val(DeletedRowId);
					}

					var cnt = document.getElementById("cnt'.$d[3].'").value;
					cnt = +cnt - 1;
					onCLickVariable.parents(".grp'.$d[3].'").remove();
					document.getElementById("cnt'.$d[3].'").value=cnt;

					//Call grid total calculation function
					if(gridCalculationFieldName.length > 0){
						CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType,"'.$d[3].'");	
					}
				}

				//On edit validation if noneditablefields get then add readonly in respective field
				// function UpdateNonEditableField(NonEditableFieldString, SerialNo){
				// 	console.log("NonEditableFieldString",NonEditableFieldString);
				// 	var NonEditableFields = NonEditableFieldString.split("|");
				// 	console.log("NonEditableFieldString",NonEditableFields);
				// 	for(var i =0; i < NonEditableFields.length; i++){
				// 		var type = $("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).prop("type");
				// 		// console.log(NonEditableFields[i],type);
				// 		if(type == "text" || type == "date" || type == "number" || type == "email" || type == "textarea" || type == "time" || type == "hidden"){
				// 			console.log("#kreon-grid-" + SerialNo + NonEditableFields[i].trim());
				// 			$("#kreon-grid-" + SerialNo + NonEditableFields[i].trim())
				// 			.siblings("input[id=\'kreon-grid-" + SerialNo + NonEditableFields[i].trim() + "-text\']")
				// 			.each(function () {
				// 				console.log("test1",NonEditableFields[i].trim());
				// 				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()+"-text").css("pointer-events","none").css("background","#eee");
				// 				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()+"-text").prop("readonly",true);
				// 			});

				// 			$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none").css("background","#eee");
							
				// 		}else if(type == "select-one"){
				// 			$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).next("span").find(".select2-selection--single").css("pointer-events","none").css("background","#eee");
				// 		}else if(type == "select-multiple"){
				// 			$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).next("span").find(".select2-selection--multiple").css("pointer-events","none").css("background","#eee");
				// 		}else if(type == "checkbox"){
				// 			if($("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).parent().hasClass("switch-primary") == true){
				// 				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).parent().css("pointer-events","none");
				// 			}else{
				// 				$("*[id*="+NonEditableFields[i].trim()+"]").each(function() {
				// 					$(this).css("pointer-events","none");
				// 				});
				// 			}
				// 		}else if(type == "radio"){
				// 			$("*[id*="+NonEditableFields[i].trim()+"]").each(function() {
				// 					$(this).css("pointer-events","none");
				// 				});
				// 		}else if(type == "file"){
				// 			if($("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).prop("multiple") == true){
				// 				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none");
				// 				$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).nextAll().find("span").remove();	
				// 			}
				// 		}else{
				// 			$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none").css("background","#eee");
				// 		}
				// 	}
						
				// }

				// //edit row 
				// $("#panel'.$d[3].'").on("click",".edits'.$d[3].'",function(){

				// 	$(".edits'.$d[3].'").attr("disabled", true);

				// 	var onCLickVariable = $(this);
				// 	var gridEdit = 1;
				// 	var [currentData, cuurrentRowDataWithComma] = getCurrentRowDataForSpValidation(onCLickVariable,mArray,gridEdit);
			
				// 	//On edit previour row edit & remove button enabled
				// 	if($(".AddEdit a:nth-child(3)").attr("id") != undefined){
				// 		// Find the last <td> in the first row
				// 		var firstRowLastTdId = $(".AddEdit a:nth-child(3)").attr("id");
								
				// 		// Find the second row using the ID from the last <td> in the first row
				// 		$("tr#" + firstRowLastTdId).find("td:last").find(".edits'.$d[3].'").show();
				// 		$("tr#" + firstRowLastTdId).find("td:last").find(".removes'.$d[3].'").show();
				// 	}

				// 	var GridEditId = onCLickVariable.closest("tr").find("#'.$d[3].'GridEditID").val();
				// 	var GridTempId = onCLickVariable.closest("tr").find("#'.$d[3].'GridTempID").val();

				// 	$.ajax({
				// 		type : "POST",
				// 		dataType: "json",
				// 		data : {ValidationOn:"gridedit", formData: currentData, formDataWithComma:cuurrentRowDataWithComma, FormID:"'.$FormID.'", GridID:$("#GridId'.$d[3].'").val(), GridEditID: GridEditId, GridRowTempId: GridTempId},
				// 		url : "validateForm.php",
				// 		success:function(output) {
						
				// 			if(output["status"] == true){
				// 				if(output["data"]["Success"] == 1){
				// 					console.log("output",output);
				// 					//Remove edited row edit & delete button
				// 					onCLickVariable.closest("tr").find("td:last").find(".edits'.$d[3].'").css("display","none");
				// 					onCLickVariable.closest("tr").find("td:last").find(".removes'.$d[3].'").css("display","none");
									
				// 					if(output["data"]["NonEditableFields"]){
				// 						var nEditableFields = output["data"]["NonEditableFields"];
				// 					}else{
				// 						var nEditableFields = "";
				// 					}
				// 					EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields);
				// 					// if(output["data"]["NonEditableFields"]){
												
				// 					// 	return UpdateNonEditableField(output["data"]["NonEditableFields"],"'.$d[3].'");
				// 					// }
				// 					$(".edits'.$d[3].'").attr("disabled", false);

									
									
				// 				}else{
				// 					if(output["data"]["Success"] == 2){
				// 						var cleanedMsg = output["data"]["Msg"]
				// 								.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
				// 								.replace(/\\\\/g, "");     // remove remaining double backslashes
												
				// 						if (confirm(cleanMsg+". Are you sure you want to submit?") == true) {
				// 							//Remove edited row edit & delete button
				// 							onCLickVariable.closest("tr").find("td:last").find(".edits'.$d[3].'").css("display","none");
				// 							onCLickVariable.closest("tr").find("td:last").find(".removes'.$d[3].'").css("display","none");

				// 							if(output["data"]["NonEditableFields"]){
				// 								var nEditableFields = output["data"]["NonEditableFields"];
				// 							}else{
				// 								var nEditableFields = "";
				// 							}

				// 							EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields);
				// 							// if(output["data"]["NonEditableFields"]){
												
				// 							// 	return UpdateNonEditableField(output["data"]["NonEditableFields"],"'.$d[3].'");
				// 							// }
				// 							$(".edits'.$d[3].'").attr("disabled", false);
				// 						} else {
				// 							$(".edits'.$d[3].'").attr("disabled", false);
				// 						}
				// 					}else if(output["data"]["Success"] == 0){
				// 						var cleanedMsg = output["data"]["Msg"]
				// 							.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
				// 							.replace(/\\\\/g, "");     // remove remaining double backslashes
				// 						alert(cleanedMsg);
				// 						$(".edits'.$d[3].'").attr("disabled", false);
				// 					}else{
				// 						alert("Internal Server Error");
				// 						$(".add'.$d[3].'").attr("disabled", false);
				// 					}
				// 				}
				// 			}else{
				// 				//Remove edited row edit & delete button
				// 				onCLickVariable.closest("tr").find("td:last").find(".edits'.$d[3].'").css("display","none");
				// 				onCLickVariable.closest("tr").find("td:last").find(".removes'.$d[3].'").css("display","none");
								
				// 				var nEditableFields = "";
				// 				EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields);
				// 				$(".edits'.$d[3].'").attr("disabled", false);
				// 			}
				// 		}
				// 	});
				// });

				// // Edit row in grid
				// function EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields){
				// 	console.log("EDITING....sending cursor to '.$d[9].'")
				// 	var row = onCLickVariable.parents("tr").attr("id");
					
				// 	var rowClass = $("#" + row).attr("class");
				// 	$("." + rowClass).removeClass("being-edited");
				// 	$("#" + row).addClass("being-edited");

				// 	var row1 = $(".grid'.$d[3].'").find("#GridTable tbody tr:first");

				// 	$(".AddEdit a:nth-child(2)").attr("id", row);
				// 	$(".AddEdit a:nth-child(2)").attr("tabindex", "'.$gridLastTabIndex.'");
				// 	$(".AddEdit a:nth-child(3)").attr("id", row);
				// 	$(".AddEdit").find("#'.$d[3].'GridEditID").val(GridEditId);
				// 	$(".AddEdit").find("#'.$d[3].'GridTempID").val(GridTempId);

				// 	row1.find(".AddEdit a:nth-child(2)").show();
				// 	row1.find(".AddEdit a:nth-child(3)").show();
				// 	row1.find(".AddEdit a:nth-child(1)").css("display","none");

				// 	// $(".AddEdit a:nth-child(2)").show();
				// 	// $(".AddEdit a:nth-child(3)").show();
				// 	// $(".AddEdit a:nth-child(1)").css("display","none");

					
				// 	for(var t=0; t < mArray.length; t++){
				// 		if(mArray[t][0] == 17 || mArray[t][0] == 16){
				// 			var EditFldvalue = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]+"-text").val();
				// 			var EditFldvalue1 = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
				// 		}else if(mArray[t][0] == 12){
				// 			var EditFldvalue = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).next("a").attr("href");
				// 			var EditFldvalue1 = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
							
				// 		}else{
				// 			var EditFldvalue = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
						
				// 		}
						
				// 		if(mArray[t][0] == 5 || mArray[t][0] == 19){
				// 			var selectedOption = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1] + " :selected").text();
				// 			var $newOption = $("<option selected=\"selected\"></option>").val(EditFldvalue).text(selectedOption)
				// 			// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("open");
				// 			$("#kreon-grid-'.$d[3].'"+mArray[t][1]).append($newOption);
				// 			// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("close");

				// 		}else if(mArray[t][0] == 17 || mArray[t][0] == 16){
				// 			$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val(EditFldvalue);
				// 			$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(EditFldvalue1);
							
				// 			if (mArray[t][18] == 1 || mArray[t][23] == 1) {
				// 				var $input = $("#kreon-grid-' . $d[3] . '" + mArray[t][1]+"-text");
				// 				if (!$input.is("[readonly]")) {
				// 					$input.prop("readonly", true);
				// 				}
				// 			}
				// 		}else if(mArray[t][0] == 12){
				// 			if(EditFldvalue1 != 0){
				// 				console.log(EditFldvalue1,EditFldvalue);
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").after("<input readonly=\"\" type=\"hidden\" value=\'"+EditFldvalue1+"\' name=\"kreon-grid-'.$d[3].'"+mArray[t][1]+"[]\" id=\"kreon-grid-'.$d[3].'"+mArray[t][1]+"\"><a target=\"_blank\" href=\'"+EditFldvalue+"\'><img src=\'"+EditFldvalue+"\' width=\"60\"></a>")
				// 			}
				// 		}else{
							
				// 			$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(EditFldvalue);
			
				// 			//Grid calculation on edit button
				// 			// if(mArray[t][12] > 0){
				// 			// 	console.log(mArray[t][12]+" == "+mArray[t][1]);
				// 			// 	CreateOnChangeScriptGridCalculation("kreon-grid-'.$d[3].'"+mArray[t][1], mArray[t][12],"grid",0);
				// 			// }
				// 		}

				// 		if(mArray[t][18] == 1){
				// 			$("#kreon-grid-'.$d[3].'"+mArray[t][1]).prop("readonly", true); 
				// 		}			
				// 	}

				// 	if(nEditableFields.length > 0){
				// 		console.log("UpdateNonEditableField");
				// 		UpdateNonEditableField(nEditableFields,"'.$d[3].'");
				// 	}

				// 	//Cursor focus on grid perticular field that was mention in AfterGridAddCursorPosition field
				// 	if("'.$d[9].'".length > 1){
				// 		$("#kreon-grid-'.$d[3].$d[9].'").focus(); 
				// 	}else{
				// 		if("'.$d[9].'".length < 1){
				// 			if(mArray[0][0] == 17){
				// 				console.log("ififififi");
				// 				var field = $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text");
				// 				if (!field.is("[readonly]")) {   // only focus if not readonly
				// 					console.log("a3");
				// 					console.log("pornima fields",field, field.is("[readonly]"));
				// 					field.focus();
				// 				}
				// 				// $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
				// 			}else if(mArray[0][0] == 16){
				// 				console.log("pornima1 fields",field);
				// 				$("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
				// 			}else{
				// 				console.log("pornima2 fields",field);
				// 				$("#kreon-grid-'.$d[3].'"+mArray[0][1]).focus(); //Cursor focus on grid first field
				// 			}
								
				// 		}
				// 	}
				// }

				// $("#panel'.$d[3].'").on("click",".update'.$d[3].'",function(){
				// 	$(".update'.$d[3].'").attr("disabled", true);

				// 	var onCLickVariable = $(this);
				// 	var gridEdit = 0;
				// 	var [currentData, cuurrentRowDataWithComma] = getCurrentRowDataForSpValidation(onCLickVariable,mArray,gridEdit);
				// 	var GridTempId = onCLickVariable.closest("tr").find("#'.$d[3].'GridTempID").val();

				// 	$.ajax({
				// 		type : "POST",
				// 		dataType: "json",
				// 		data : {ValidationOn:"gridupdate", formData: currentData, formDataWithComma:cuurrentRowDataWithComma, mainFormData:$("form").serialize(), FormID:"'.$FormID.'", GridID:$("#GridId'.$d[3].'").val(), GridEditID: onCLickVariable.closest("tr").find("#'.$d[3].'GridEditID").val(),GridRowTempId: GridTempId},
				// 		url : "validateForm.php",
				// 		success:function(output) {
				// 			if(output["status"] == true){
							
				// 				if(output["data"]["Success"] == 1){
				// 					UpdateRow(onCLickVariable);
				// 					$(".update'.$d[3].'").attr("disabled", false);
				// 					if(output["tempData"]){
				// 						$("#"+Object.keys(output["tempData"][0])).empty();
				// 						for(var i=0; i<output["tempData"].length; i++){
				// 							$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
				// 						}
				// 					}
				// 				}else{
				// 					if(output["data"]["Success"] == 2){
				// 						var cleanedMsg = output["data"]["Msg"]
				// 								.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
				// 								.replace(/\\\\/g, "");     // remove remaining double backslashes
												
				// 						if (confirm(cleanMsg+". Are you sure you want to submit?") == true) {
				// 							UpdateRow(onCLickVariable);
				// 							$(".update'.$d[3].'").attr("disabled", false);
				// 							if(output["tempData"]){
				// 								$("#"+Object.keys(output["tempData"][0])).empty();
				// 								for(var i=0; i<output["tempData"].length; i++){
				// 									$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
				// 								}
				// 							}
				// 						} else {
				// 							$(".update'.$d[3].'").attr("disabled", false);
				// 						}
				// 					}else if(output["data"]["Success"] == 0){
				// 						var cleanedMsg = output["data"]["Msg"]
				// 							.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
				// 							.replace(/\\\\/g, "");     // remove remaining double backslashes
				// 						alert(cleanedMsg);
				// 						$(".update'.$d[3].'").attr("disabled", false);
				// 					}else{
				// 						alert("Internal Server Error");
				// 						$(".update'.$d[3].'").attr("disabled", false);
				// 					}
				// 				}
				// 			}else{
				// 				UpdateRow(onCLickVariable);
				// 				$(".update'.$d[3].'").attr("disabled", false);
				// 			}
				// 		}
				// 	});
					
				// });

				// async function UpdateRow(onCLickVariable){
				// 	element = $(".AddEdit a:nth-child(2)");
				// 	var targetRowId = element.attr("id").split("-").pop();	//a1, a2 ...
				// 	$(".AddEdit a:nth-child(2)").removeAttr("id");
				// 	$(".AddEdit a:nth-child(3)").removeAttr("id");
				// 	$(".AddEdit").find("#'.$d[3].'GridEditID").val(0);

				// 	//edited row show edit & remove button
				// 	$("#"+targetRowId).find("td:last").find(".edits'.$d[3].'").css("display","block");
				// 	$("#"+targetRowId).find("td:last").find(".removes'.$d[3].'").css("display","block");

				// 	for(var t=0; t < mArray.length; t++){
				// 		if(mArray[t][0] == 17 || mArray[t][0] == 16){
				// 			var fldvalue = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val();
				// 			var fldvalue1 = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val();
				// 		}else if(mArray[t][0] == 12){
				// 			var fldvalue = $("#kreon-grid-'.$d[3].'"+mArray[t][1]).prop("files")[0];
				// 		}else{
				// 			var fldvalue = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val();
				// 		}

				// 		if(mArray[t][0] == 5 || mArray[t][0] == 19){
				// 			var selectedOption = $("#kreon-grid-'.$d[3].'"+mArray[t][1] + " :selected").text();
				// 			var $newOption = $("<option selected=\"selected\"></option>").val(fldvalue).text(selectedOption)

				// 			$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).append($newOption).trigger("change");
							

				// 			if((mArray[t][17] == null || mArray[t][17].length == 0) || (mArray[t][16] == null || mArray[t][16].length == 0)){

				// 				// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("open");
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(0).trigger("change"); // Remove DD selected field from first row
				// 				// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("close");
				// 			}

				// 			//after update if not readonly then remove readonly
				// 			if(mArray[t][23] != 1){
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).next("span").find(".select2-selection--single").prop("readonly", false).css("pointer-events","").css("background-color","white");
				// 			}

				// 		}else if(mArray[t][0] == 17 || mArray[t][0] == 16){
				// 			$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]+"-text").val(fldvalue);
				// 			$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).val(fldvalue1);

				// 			//If GridCalculation greater than 0 then add field name & calculation type in array
				// 			if(mArray[t][12] > 0){
				// 				if (!gridCalculationFieldName.includes(mArray[t][1])) {
				// 					gridCalculationFieldName.push(mArray[t][1]);
				// 					gridCalculationType.push(mArray[t][12]);
				// 				}
				// 			}

				// 			if((mArray[t][17] == null || mArray[t][17].length == 0) || (mArray[t][16] == null || mArray[t][16].length == 0)){
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val("");
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
				// 			}

				// 			if(mArray[t][23] != 1){			
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").prop("readonly", false).css("pointer-events","").css("background-color","white");
				// 			}
				// 		}else if(mArray[t][0] == 12){
				// 			if(fldvalue == undefined){
				// 				if($("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().length != 0){
				// 					$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().remove();
				// 					$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().remove();
				// 				}
								
				// 			}else{
				// 				var imgFieldName = mArray[t][1];
				// 				var gridSerial = "'.$d[3].'";
				// 				var filePath = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(); 
				// 				var ext = filePath.substr(filePath.lastIndexOf(".")+1,filePath.length);

				// 				var gridId = "'.$d[7].'";
				// 				var imgFlag = false;

				// 				$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).next().remove();
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().remove();

				// 				base64String = await getBase64(fldvalue);

				// 				if(base64String !== null){
				// 					// Await the result of base64AjaxFunction before proceeding
				// 					let MediaResult = await base64AjaxFunction(base64String, imgFieldName, gridSerial, ext, targetRowId, gridId);

				// 					if (MediaResult && MediaResult.response === "true") {
				// 						var MediaID = MediaResult.data;
				// 						var MediaPath = MediaResult.imagepath;

				// 						if (MediaID == 0) {
				// 							console.log("MediaID is 0", MediaID);
				// 						} else {
				// 							imgFlag = true;
				// 							console.log("MediaID is not 0", MediaID, MediaPath);
				// 							$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).val(MediaID);
				// 							$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).after("<a target=\"_blank\" href=\'"+MediaPath+"\'><img src=\'"+MediaPath+"\' width=\"60\"></a>")

				// 							// $("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).next().remove();
				// 							$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").nextAll("a").first().remove();
				// 						}
				// 					} else {
				// 						console.log("Error while fetching MediaID");
				// 					}
				// 				}

				// 				//Get base64 string & assing to function
				// 				// getBase64(fldvalue).then(
				// 				// 	base64String => {
				// 				// 		base64AjaxFunction(base64String,imgFieldName,gridSerial,ext,targetRowId,gridId)
				// 				// 	  }
				// 				// );
				// 			}
				// 		}else{
							
				// 			$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).val(fldvalue);
							

				// 			if(mArray[t][17] == null && mArray[t][16] == null){
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
				// 			}else if(mArray[t][17] != null){
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(mArray[t][17]);
				// 			}else if(mArray[t][16] != null){
				// 				// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(mArray[t][16]);
				// 			}

				// 			//If not readonly & if temporary lock then do it readable
				// 			if(mArray[t][23] != 1){
				// 				console.log("in 23",mArray[t][1]);
				// 				$("#kreon-grid-'.$d[3].'"+mArray[t][1]).prop("readonly", false).css("pointer-events","").css("background-color","white");
				// 			}

				// 			//If GridCalculation greater than 0 then add field name & calculation type in array
				// 			if(mArray[t][12] > 0){
				// 				if (!gridCalculationFieldName.includes(mArray[t][1])) {
				// 					gridCalculationFieldName.push(mArray[t][1]);
				// 					gridCalculationType.push(mArray[t][12]);
				// 				}
				// 			}

				// 		}

				// 		$(".AddEdit a:nth-child(1)").show();
				// 		$(".AddEdit a:nth-child(2)").css("display","none");
				// 		$(".AddEdit a:nth-child(3)").css("display","none");
				// 	}

				// 	var gridAlphabet = targetRowId.slice(0,1);
				// 	var gridNumber = +targetRowId.slice(1) + 1;
					
				// 	$("#" + gridAlphabet + gridNumber + " td a.edits" + gridAlphabet).click();

				// 	//Call grid total calculation function
				// 	if(gridCalculationFieldName.length > 0){
				// 		CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType,"'.$d[3].'");	
				// 	}
					
				// 	var isFocusOnSpecificField = false;
				// 	if("'.$d[9].'".length > 1){
				// 		//Cursor focus on grid perticular field that was mention in AfterGridAddCursorPosition field
				// 		isFocusOnSpecificField = true;
				// 	}else{
				// 		//on click add button next grid not found then exicute this code. else as per tab index it will move focus to next field
					
				// 		var addButton = $(".add'.$d[3].'");
				// 		if (addButton.is(":visible")) {
				// 			var addButtonTabIndex = parseInt($(".add'.$d[3].'").attr("tabindex"), 10);
				// 			console.log("addButtonTabIndex",addButtonTabIndex);
				// 			if (!isNaN(addButtonTabIndex)) {
				// 				addButtonTabIndex++;
				// 				if ($("form [tabindex="+addButtonTabIndex+"]").length == 0) {
				// 					//on row add Cursor focus on grid first field					
				// 					if("'.$d[9].'".length < 1){
				// 						if(mArray[0][0] == 17){
				// 							console.log("if");
				// 							var field = $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text");
				// 							if (!field.is("[readonly]")) {   // only focus if not readonly
				// 								console.log("pornima fields",field, field.is("[readonly]"));
				// 								field.focus();
				// 							}
				// 							// $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
				// 						}else if(mArray[0][0] == 16){
				// 							console.log("pornima1 fields",field);
				// 							$("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
				// 						}else{
				// 							console.log("pornima2 fields",field);
				// 							$("#kreon-grid-'.$d[3].'"+mArray[0][1]).focus(); //Cursor focus on grid first field
				// 						}
				// 					}
				// 				}
				// 			}
				// 		}

						
				// 	}


				// 	if(isFocusOnSpecificField){
				// 		var cursorPositionField = "kreon-grid-' . $d[3] . '' . $d[9] . '";
				// 		var cursorField = document.getElementById(cursorPositionField);
				// 		var cursorFieldType = cursorField.type;

				// 		// if field type 16, 17
				// 		$(cursorField).siblings("input[id=\'" + cursorPositionField + "-text\']").each(function () {
				// 			if (!$(this).is("[readonly]")) {
				// 				$(this).focus();
				// 			}
				// 		});

				// 		if(cursorFieldType == "text" || cursorFieldType == "date" || cursorFieldType == "number" || cursorFieldType == "email" || cursorFieldType == "textarea" || cursorFieldType == "time"){

				// 			$("#" + cursorPositionField).focus();
				// 		}else if(cursorFieldType == "select-one"){
				// 			$("#" + cursorPositionField).select2("open");
				// 			focusSelect2Search();
				// 		}
				// 	}
				// }


				async function UpdateNonEditableField(NonEditableFieldString, SerialNo){
					console.log("NonEditableFieldString",NonEditableFieldString);
					var NonEditableFields = NonEditableFieldString.split("|");
					console.log("NonEditableFieldString",NonEditableFields);
					for(var i =0; i < NonEditableFields.length; i++){
						var type = $("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).prop("type");
						// console.log(NonEditableFields[i],type);
						if(type == "text" || type == "date" || type == "number" || type == "email" || type == "textarea" || type == "time" || type == "hidden"){
							console.log("#kreon-grid-" + SerialNo + NonEditableFields[i].trim());
							$("#kreon-grid-" + SerialNo + NonEditableFields[i].trim())
							.siblings("input[id=\'kreon-grid-" + SerialNo + NonEditableFields[i].trim() + "-text\']")
							.each(function () {
								console.log("test1",NonEditableFields[i].trim());
								$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()+"-text").css("pointer-events","none").css("background","#eee");
								$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()+"-text").prop("readonly",true);
							});

							$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none").css("background","#eee");
							
						}else if(type == "select-one"){
							$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).next("span").find(".select2-selection--single").css("pointer-events","none").css("background","#eee");
						}else if(type == "select-multiple"){
							$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).next("span").find(".select2-selection--multiple").css("pointer-events","none").css("background","#eee");
						}else if(type == "checkbox"){
							if($("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).parent().hasClass("switch-primary") == true){
								$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).parent().css("pointer-events","none");
							}else{
								$("*[id*="+NonEditableFields[i].trim()+"]").each(function() {
									$(this).css("pointer-events","none");
								});
							}
						}else if(type == "radio"){
							$("*[id*="+NonEditableFields[i].trim()+"]").each(function() {
									$(this).css("pointer-events","none");
								});
						}else if(type == "file"){
							if($("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).prop("multiple") == true){
								$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none");
								$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).nextAll().find("span").remove();	
							}
						}else{
							$("#kreon-grid-"+SerialNo+NonEditableFields[i].trim()).css("pointer-events","none").css("background","#eee");
						}
					}
					console.log("end of UpdateNonEditableField");
				}

				//edit row 
				$("#panel'.$d[3].'").on("click",".edits'.$d[3].'",async function(){

					$(".edits'.$d[3].'").attr("disabled", true);

					var onCLickVariable = $(this);
					var gridEdit = 1;
					var [currentData, cuurrentRowDataWithComma] = getCurrentRowDataForSpValidation(onCLickVariable,mArray,gridEdit);
			
					//On edit previour row edit & remove button enabled
					if($(".AddEdit a:nth-child(3)").attr("id") != undefined){
						// Find the last <td> in the first row
						var firstRowLastTdId = $(".AddEdit a:nth-child(3)").attr("id");
								
						// Find the second row using the ID from the last <td> in the first row
						$("tr#" + firstRowLastTdId).find("td:last").find(".edits'.$d[3].'").show();
						$("tr#" + firstRowLastTdId).find("td:last").find(".removes'.$d[3].'").show();
					}

					var GridEditId = onCLickVariable.closest("tr").find("#'.$d[3].'GridEditID").val();
					var GridTempId = onCLickVariable.closest("tr").find("#'.$d[3].'GridTempID").val();

					try{
						const output = await $.ajax({
							type : "POST",
							dataType: "json",
							data : {ValidationOn:"gridedit", formData: currentData, formDataWithComma:cuurrentRowDataWithComma, FormID:"'.$FormID.'", GridID:$("#GridId'.$d[3].'").val(), GridEditID: GridEditId, GridRowTempId: GridTempId},
							url : "validateForm.php"
						});

						if(output["status"] == true){
								if(output["data"]["Success"] == 1){
									console.log("output",output);
									//Remove edited row edit & delete button
									onCLickVariable.closest("tr").find("td:last").find(".edits'.$d[3].'").css("display","none");
									onCLickVariable.closest("tr").find("td:last").find(".removes'.$d[3].'").css("display","none");
									
									if(output["data"]["NonEditableFields"]){
										var nEditableFields = output["data"]["NonEditableFields"];
									}else{
										var nEditableFields = "";
									}
									await EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields);

									$(".edits'.$d[3].'").attr("disabled", false);
	
								}else{
									if(output["data"]["Success"] == 2){
										var cleanedMsg = output["data"]["Msg"]
												.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
												.replace(/\\\\/g, "");     // remove remaining double backslashes
												
										if (confirm(cleanMsg+". Are you sure you want to submit?") == true) {
											//Remove edited row edit & delete button
											onCLickVariable.closest("tr").find("td:last").find(".edits'.$d[3].'").css("display","none");
											onCLickVariable.closest("tr").find("td:last").find(".removes'.$d[3].'").css("display","none");

											if(output["data"]["NonEditableFields"]){
												var nEditableFields = output["data"]["NonEditableFields"];
											}else{
												var nEditableFields = "";
											}

											await EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields);

											$(".edits'.$d[3].'").attr("disabled", false);
										} else {
											$(".edits'.$d[3].'").attr("disabled", false);
										}
									}else if(output["data"]["Success"] == 0){
										var cleanedMsg = output["data"]["Msg"]
											.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
											.replace(/\\\\/g, "");     // remove remaining double backslashes
										alert(cleanedMsg);
										$(".edits'.$d[3].'").attr("disabled", false);
									}else{
										alert("Internal Server Error");
										$(".add'.$d[3].'").attr("disabled", false);
									}
								}
							}else{
								//Remove edited row edit & delete button
								onCLickVariable.closest("tr").find("td:last").find(".edits'.$d[3].'").css("display","none");
								onCLickVariable.closest("tr").find("td:last").find(".removes'.$d[3].'").css("display","none");
								
								var nEditableFields = "";
								await EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields);
								$(".edits'.$d[3].'").attr("disabled", false);
							}
					}catch (err) {
						console.error("AJAX error:", err);
						alert("Error while processing request.");
					}
				});

				// Edit row in grid
				async function EditRow(onCLickVariable,GridEditId,GridTempId,nEditableFields){
					console.log("EDITING....sending cursor to '.$d[9].'")
					var row = onCLickVariable.parents("tr").attr("id");
					
					var rowClass = $("#" + row).attr("class");
					$("." + rowClass).removeClass("being-edited");
					$("#" + row).addClass("being-edited");

					var row1 = $(".grid'.$d[3].'").find("#GridTable tbody tr:first");

					$(".AddEdit a:nth-child(2)").attr("id", row);
					$(".AddEdit a:nth-child(2)").attr("tabindex", "'.$gridLastTabIndex.'");
					$(".AddEdit a:nth-child(3)").attr("id", row);
					$(".AddEdit").find("#'.$d[3].'GridEditID").val(GridEditId);
					$(".AddEdit").find("#'.$d[3].'GridTempID").val(GridTempId);

					row1.find(".AddEdit a:nth-child(2)").show();
					row1.find(".AddEdit a:nth-child(3)").show();
					row1.find(".AddEdit a:nth-child(1)").css("display","none");

					// $(".AddEdit a:nth-child(2)").show();
					// $(".AddEdit a:nth-child(3)").show();
					// $(".AddEdit a:nth-child(1)").css("display","none");

					
					for(var t=0; t < mArray.length; t++){
						if(mArray[t][0] == 17 || mArray[t][0] == 16){
							var EditFldvalue = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]+"-text").val();
							var EditFldvalue1 = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
						}else if(mArray[t][0] == 12){
							var EditFldvalue = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).next("a").attr("href");
							var EditFldvalue1 = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
							
						}else{
							var EditFldvalue = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1]).val();
						
						}
						
						if(mArray[t][0] == 5 || mArray[t][0] == 19){
							var selectedOption = onCLickVariable.closest("tr").find("#'.$d[3].'"+mArray[t][1] + " :selected").text();
							var $newOption = $("<option selected=\"selected\"></option>").val(EditFldvalue).text(selectedOption)
							// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("open");
							$("#kreon-grid-'.$d[3].'"+mArray[t][1]).append($newOption);
							// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("close");

						}else if(mArray[t][0] == 17 || mArray[t][0] == 16){
							$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val(EditFldvalue);
							$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(EditFldvalue1);
							
							if (mArray[t][18] == 1 || mArray[t][23] == 1) {
								var $input = $("#kreon-grid-' . $d[3] . '" + mArray[t][1]+"-text");
								if (!$input.is("[readonly]")) {
									$input.prop("readonly", true);
								}
							}
						}else if(mArray[t][0] == 12){
							if(EditFldvalue1 != 0){
								console.log(EditFldvalue1,EditFldvalue);
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").after("<input readonly=\"\" type=\"hidden\" value=\'"+EditFldvalue1+"\' name=\"kreon-grid-'.$d[3].'"+mArray[t][1]+"[]\" id=\"kreon-grid-'.$d[3].'"+mArray[t][1]+"\"><a target=\"_blank\" href=\'"+EditFldvalue+"\'><img src=\'"+EditFldvalue+"\' width=\"60\"></a>")
							}
						}else{
							
							$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(EditFldvalue);
			
							//Grid calculation on edit button
							// if(mArray[t][12] > 0){
							// 	console.log(mArray[t][12]+" == "+mArray[t][1]);
							// 	CreateOnChangeScriptGridCalculation("kreon-grid-'.$d[3].'"+mArray[t][1], mArray[t][12],"grid",0);
							// }
						}

						if(mArray[t][18] == 1){
							$("#kreon-grid-'.$d[3].'"+mArray[t][1]).prop("readonly", true); 
						}			
					}

					if(nEditableFields.length > 0){
						console.log("before UpdateNonEditableField");
						await UpdateNonEditableField(nEditableFields,"'.$d[3].'");
					}

					//Cursor focus on grid perticular field that was mention in AfterGridAddCursorPosition field
					if("'.$d[9].'".length > 1){
						$("#kreon-grid-'.$d[3].$d[9].'").focus(); 
					}else{
						if("'.$d[9].'".length < 1){
							if(mArray[0][0] == 17){
								console.log("ififififi");
								var field = $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text");
								console.log(field);
								if (!field.is("[readonly]")) {   // only focus if not readonly
									console.log("a3");
									console.log("pornima fields",field, field.is("[readonly]"));
									field.focus();
								}
								// $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
							}else if(mArray[0][0] == 16){
								console.log("pornima1 fields",field);
								$("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
							}else{
								console.log("pornima2 fields",field);
								$("#kreon-grid-'.$d[3].'"+mArray[0][1]).focus(); //Cursor focus on grid first field
							}
								
						}
					}
				}

				$("#panel'.$d[3].'").on("click",".update'.$d[3].'",async function(){
					$(".update'.$d[3].'").attr("disabled", true);

					var onCLickVariable = $(this);
					var gridEdit = 0;
					var [currentData, cuurrentRowDataWithComma] = getCurrentRowDataForSpValidation(onCLickVariable,mArray,gridEdit);
					var GridTempId = onCLickVariable.closest("tr").find("#'.$d[3].'GridTempID").val();

					try{
						var output = await $.ajax({
							type : "POST",
							dataType: "json",
							data : {ValidationOn:"gridupdate", formData: currentData, formDataWithComma:cuurrentRowDataWithComma, mainFormData:$("form").serialize(), FormID:"'.$FormID.'", GridID:$("#GridId'.$d[3].'").val(), GridEditID: onCLickVariable.closest("tr").find("#'.$d[3].'GridEditID").val(),GridRowTempId: GridTempId},
							url : "validateForm.php"
						});

						if(output["status"] == true){
							
							if(output["data"]["Success"] == 1){
								await UpdateRow(onCLickVariable);
								$(".update'.$d[3].'").attr("disabled", false);
								if(output["tempData"]){
									$("#"+Object.keys(output["tempData"][0])).empty();
									for(var i=0; i<output["tempData"].length; i++){
										$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
									}
								}
							}else{
								if(output["data"]["Success"] == 2){
									var cleanedMsg = output["data"]["Msg"]
											.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
											.replace(/\\\\/g, "");     // remove remaining double backslashes
											
									if (confirm(cleanMsg+". Are you sure you want to submit?") == true) {
										await UpdateRow(onCLickVariable);
										$(".update'.$d[3].'").attr("disabled", false);
										if(output["tempData"]){
											$("#"+Object.keys(output["tempData"][0])).empty();
											for(var i=0; i<output["tempData"].length; i++){
												$("#"+Object.keys(output["tempData"][i])).append(Object.values(output["tempData"][i]));
											}
										}
									} else {
										$(".update'.$d[3].'").attr("disabled", false);
									}
								}else if(output["data"]["Success"] == 0){
									var cleanedMsg = output["data"]["Msg"]
										.replace(/\\\\n/g, "\n")   // turn \\n into real newlines
										.replace(/\\\\/g, "");     // remove remaining double backslashes
									alert(cleanedMsg);
									$(".update'.$d[3].'").attr("disabled", false);
								}else{
									alert("Internal Server Error");
									$(".update'.$d[3].'").attr("disabled", false);
								}
							}
						}else{
							await UpdateRow(onCLickVariable);
							$(".update'.$d[3].'").attr("disabled", false);
						}
					}catch (err) {
						console.error("AJAX error:", err);
						alert("Error while processing request.");
					}

					
				});

				async function UpdateRow(onCLickVariable){
					element = $(".AddEdit a:nth-child(2)");
					var targetRowId = element.attr("id").split("-").pop();	//a1, a2 ...
					$(".AddEdit a:nth-child(2)").removeAttr("id");
					$(".AddEdit a:nth-child(3)").removeAttr("id");
					$(".AddEdit").find("#'.$d[3].'GridEditID").val(0);

					//edited row show edit & remove button
					$("#"+targetRowId).find("td:last").find(".edits'.$d[3].'").css("display","block");
					$("#"+targetRowId).find("td:last").find(".removes'.$d[3].'").css("display","block");

					for(var t=0; t < mArray.length; t++){
						if(mArray[t][0] == 17 || mArray[t][0] == 16){
							var fldvalue = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val();
							var fldvalue1 = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val();
						}else if(mArray[t][0] == 12){
							var fldvalue = $("#kreon-grid-'.$d[3].'"+mArray[t][1]).prop("files")[0];
						}else{
							var fldvalue = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val();
						}

						if(mArray[t][0] == 5 || mArray[t][0] == 19){
							var selectedOption = $("#kreon-grid-'.$d[3].'"+mArray[t][1] + " :selected").text();
							var $newOption = $("<option selected=\"selected\"></option>").val(fldvalue).text(selectedOption)

							$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).append($newOption).trigger("change");
							

							if((mArray[t][17] == null || mArray[t][17].length == 0) || (mArray[t][16] == null || mArray[t][16].length == 0)){

								// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("open");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(0).trigger("change"); // Remove DD selected field from first row
								// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).select2("close");
							}

							//after update if not readonly then remove readonly
							if(mArray[t][23] != 1){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).next("span").find(".select2-selection--single").prop("readonly", false).css("pointer-events","").css("background-color","white");
							}

						}else if(mArray[t][0] == 17 || mArray[t][0] == 16){
							$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]+"-text").val(fldvalue);
							$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).val(fldvalue1);

							//If GridCalculation greater than 0 then add field name & calculation type in array
							if(mArray[t][12] > 0){
								if (!gridCalculationFieldName.includes(mArray[t][1])) {
									gridCalculationFieldName.push(mArray[t][1]);
									gridCalculationType.push(mArray[t][12]);
								}
							}

							if((mArray[t][17] == null || mArray[t][17].length == 0) || (mArray[t][16] == null || mArray[t][16].length == 0)){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val("");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
							}

							if(mArray[t][23] != 1){			
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").prop("readonly", false).css("pointer-events","").css("background-color","white");
							}
						}else if(mArray[t][0] == 12){
							if(fldvalue == undefined){
								if($("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().length != 0){
									$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().remove();
									$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().remove();
								}
								
							}else{
								var imgFieldName = mArray[t][1];
								var gridSerial = "'.$d[3].'";
								var filePath = onCLickVariable.closest("tr").find("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(); 
								var ext = filePath.substr(filePath.lastIndexOf(".")+1,filePath.length);

								var gridId = "'.$d[7].'";
								var imgFlag = false;

								$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).next().remove();
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").next().remove();

								base64String = await getBase64(fldvalue);

								if(base64String !== null){
									// Await the result of base64AjaxFunction before proceeding
									let MediaResult = await base64AjaxFunction(base64String, imgFieldName, gridSerial, ext, targetRowId, gridId);

									if (MediaResult && MediaResult.response === "true") {
										var MediaID = MediaResult.data;
										var MediaPath = MediaResult.imagepath;

										if (MediaID == 0) {
											console.log("MediaID is 0", MediaID);
										} else {
											imgFlag = true;
											console.log("MediaID is not 0", MediaID, MediaPath);
											$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).val(MediaID);
											$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).after("<a target=\"_blank\" href=\'"+MediaPath+"\'><img src=\'"+MediaPath+"\' width=\"60\"></a>")

											// $("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).next().remove();
											$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").nextAll("a").first().remove();
										}
									} else {
										console.log("Error while fetching MediaID");
									}
								}

								//Get base64 string & assing to function
								// getBase64(fldvalue).then(
								// 	base64String => {
								// 		base64AjaxFunction(base64String,imgFieldName,gridSerial,ext,targetRowId,gridId)
								// 	  }
								// );
							}
						}else{
							
							$("#"+targetRowId).find("#'.$d[3].'"+mArray[t][1]).val(fldvalue);
							

							if(mArray[t][17] == null && mArray[t][16] == null){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
							}else if(mArray[t][17] != null){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(mArray[t][17]);
							}else if(mArray[t][16] != null){
								// $("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(mArray[t][16]);
							}

							//If not readonly & if temporary lock then do it readable
							if(mArray[t][23] != 1){
								console.log("in 23",mArray[t][1]);
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).prop("readonly", false).css("pointer-events","").css("background-color","white");
							}

							//If GridCalculation greater than 0 then add field name & calculation type in array
							if(mArray[t][12] > 0){
								if (!gridCalculationFieldName.includes(mArray[t][1])) {
									gridCalculationFieldName.push(mArray[t][1]);
									gridCalculationType.push(mArray[t][12]);
								}
							}

						}

						$(".AddEdit a:nth-child(1)").show();
						$(".AddEdit a:nth-child(2)").css("display","none");
						$(".AddEdit a:nth-child(3)").css("display","none");
					}

					var gridAlphabet = targetRowId.slice(0,1);
					var gridNumber = +targetRowId.slice(1) + 1;
					
					$("#" + gridAlphabet + gridNumber + " td a.edits" + gridAlphabet).click();
					// await triggerEditClick(gridAlphabet, gridNumber);

					// Optional: wait a bit to ensure click is processed (DOM/UI updated)
					await new Promise(resolve => setTimeout(resolve, 100)); 

					//Call grid total calculation function
					if(gridCalculationFieldName.length > 0){
						await CreateOnChangeScriptGridCalculation(gridCalculationFieldName, gridCalculationType,"'.$d[3].'");	
					}
					
					var isFocusOnSpecificField = false;
					if("'.$d[9].'".length > 1){
						//Cursor focus on grid perticular field that was mention in AfterGridAddCursorPosition field
						isFocusOnSpecificField = true;
					}else{
						//on click add button next grid not found then exicute this code. else as per tab index it will move focus to next field
					
						var addButton = $(".add'.$d[3].'");
						if (addButton.is(":visible")) {
							var addButtonTabIndex = parseInt($(".add'.$d[3].'").attr("tabindex"), 10);
							console.log("addButtonTabIndex",addButtonTabIndex);
							if (!isNaN(addButtonTabIndex)) {
								addButtonTabIndex++;
								if ($("form [tabindex="+addButtonTabIndex+"]").length == 0) {
									//on row add Cursor focus on grid first field					
									if("'.$d[9].'".length < 1){
										if(mArray[0][0] == 17){
											console.log("if");
											var field = $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text");
											if (!field.is("[readonly]")) {   // only focus if not readonly
												console.log("pornima fields",field, field.is("[readonly]"));
												field.focus();
											}
											// $("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
										}else if(mArray[0][0] == 16){
											console.log("pornima1 fields",field);
											$("#kreon-grid-'.$d[3].'"+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
										}else{
											console.log("pornima2 fields",field);
											$("#kreon-grid-'.$d[3].'"+mArray[0][1]).focus(); //Cursor focus on grid first field
										}
									}
								}
							}
						}

						
					}


					if(isFocusOnSpecificField){
						var cursorPositionField = "kreon-grid-' . $d[3] . '' . $d[9] . '";
						var cursorField = document.getElementById(cursorPositionField);if (cursorField) {
							var cursorFieldType = cursorField.type;
							// now you can use cursorFieldType safely
						}

						// var cursorFieldType = cursorField.type;

						// if field type 16, 17
						$(cursorField).siblings("input[id=\'" + cursorPositionField + "-text\']").each(function () {
							if (!$(this).is("[readonly]")) {
								$(this).focus();
							}
						});

						if(cursorFieldType == "text" || cursorFieldType == "date" || cursorFieldType == "number" || cursorFieldType == "email" || cursorFieldType == "textarea" || cursorFieldType == "time"){

							$("#" + cursorPositionField).focus();
						}else if(cursorFieldType == "select-one"){
							$("#" + cursorPositionField).select2("open");
							focusSelect2Search();
						}
					}
				}

				$("#panel'.$d[3].'").on("click",".refresh'.$d[3].'",function(){
					element = $(".AddEdit a:nth-child(2)");

					if(element.attr("id") != undefined){
						var targetRowId = element.attr("id").split("-").pop();
						$(".AddEdit a:nth-child(2)").removeAttr("id");
						$(".AddEdit a:nth-child(3)").removeAttr("id");
						var rowClass = $("#" + targetRowId).attr("class");
						$("." + rowClass.replace(" ",".")).removeClass("being-edited");

						var editRowId = $("#" + targetRowId).attr("id");
						$("#"+editRowId).find("td:last a:nth-child(1)").show();
						$("#"+editRowId).find("td:last a:nth-child(2)").show();
					}

					$("#'.$d[3].'GridEditID").val(0);
					$("#'.$d[3].'GridTempID").val(0);

					for(var t=0; t < mArray.length; t++){
						if(mArray[t][0] == 5 || mArray[t][0] == 19){
							if(!mArray[t][17] || mArray[t][17].trim().length <= 0){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val(null).trigger("change"); // Remove DD selected field from first row
							}
						}else if(mArray[t][0] == 17){
							if(!mArray[t][17] || mArray[t][17].trim().length <= 0){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val("");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
							}
						}else if(mArray[t][0] == 16){
							if(!mArray[t][17] || mArray[t][17].trim().length <= 0){
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]+"-text").val("");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
							}
						}else if(mArray[t][0] == 12){
							if(!mArray[t][17] || mArray[t][17].trim().length <= 0){
								//Remove thumbnail & input value
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
								$("#kreon-grid-'.$d[3].'"+mArray[t][1]).parent("label").nextAll("a").first().remove();
							}
						}

						if(!mArray[t][17] || mArray[t][17].trim().length <= 0){
						
							$("#kreon-grid-'.$d[3].'"+mArray[t][1]).val("");
						}
						$(".AddEdit a:nth-child(1)").show();
						$(".AddEdit a:nth-child(2)").css("display","none");
						$(".AddEdit a:nth-child(3)").css("display","none");

					}
				});

			});
		</script>';
		// print_r($v);
		if(empty($v)){
			$fieldCount = 0;
		}else{
			
			$tableStart = '<table style="table-layout: fixed;word-wrap: break-word;" id="GridTable" class="table table-responsive table-bordered table-hover tmp_GridTable'.$d[3].'">';
			$tableEnd = '</table>';
			$tableHead = '<thead class=" thead-light"><tr>';
			$fvals = '';
			$headerGridStart = '<tr class="grp'.$d[3].'" id="'.$d[3];
			$headerGridEnd   = '">';

			global $moreextradb;
			$gridCalculationFieldName = [];
			$gridCalculationType = [];


			// echo "<pre></pre></br>";
			// print_r($m[4]);

			for($i = 0; $i < sizeof($m); $i++){		   //style='width:".$m[$i][7]."px' width='".$m[$i][7]."'
				if($m[$i][26] == 0 ){  //to check visibility
					$thClass = " thHidden ";
				}else{
					$thClass = "";
				}
				$tableHead .= "<th class='".$thClass."' style='width:".$m[$i][7]."px' >".$m[$i][2]."";

				if($m[$i][13] > 0){

					$tableHead .= '<button type="button" class="btn btn-primary btn-sm amodal" style="margin-left:2px;" id="AddBtnModal-'.$m[$i][1].'" value="'.$m[$i][13].'-'.$m[$i][1].'-'.$formType.'">Add</button>';

				}

				$tableHead .="</th>";
			}
			$tableHead .= '<th style="width:50px;padding:2px 3px !important;"></th>';

			// if($_SESSION['user_id'] == 1020){
			// 	echo "<pre>";
			// 	print_r($v);
			// 	echo "</pre>";
			// }


			// This section code code optimization form field type 5
			$allInputVals = [];
			$fieldData = []; // stores IDs per dropdown definition

			for ($k = 0; $k < sizeof($v); $k++) {
				for ($i = 0; $i < sizeof($m); $i++) {
					if ($m[$i][0] == 5 && $m[$i][3] < 0) { // dropdown-from-DB
						$dbarray = $moreextradb[$d[7]][$m[$i][1]];
						$fieldKey = $d[7] . '|' . $m[$i][1]; // unique key per field

						$inputVal = isset($v[$k][$i]) ? $v[$k][$i] : null;
						if ($inputVal !== null && $inputVal != '') {
							// Group values by field key
							$fieldData[$fieldKey]['ids'][] = $inputVal;
							$fieldData[$fieldKey]['dbarray'] = $dbarray;
						}
					}
				}
			}

			$fieldOptions = []; // id→label cache per field
			foreach ($fieldData as $key => $info) {
				$dbarray = $info['dbarray'];
				$ids = array_unique($info['ids']);
				$idList = implode(',', array_map('intval', $ids));

				$sql = "SELECT {$dbarray[1]}, {$dbarray[2]} 
						FROM {$dbarray[0]} 
						WHERE {$dbarray[1]} IN ($idList)";

				$result = db::getInstance()->db_select($sql, "F-16223: Cl-");

				$fieldOptions[$key] = [];
				foreach ($result['result_set'] as $row) {
					$fieldOptions[$key][$row[$dbarray[1]]] = $row[$dbarray[2]];
				}
			}
			
			for($k = 0; $k < sizeof($v); $k++){
				// $fvals .= $headerGridStart . $k . $headerGridEnd;
				if($_SESSION['user_id'] == 1025) echo sizeof($v);
				// 	echo $headerGridStart; 
				// }
				$fvals .= $headerGridStart . sizeof($v)-$k . $headerGridEnd;
				for($i = 0; $i < sizeof($m); $i++){

                    $inputVal = isset($v[$k][$i]) ? $v[$k][$i] : null;

					if($m[$i][26] == 0 ){  //to check visibility
						$thClass .= " style='display:none;' ";
					}else{
						$thClass = "";
					}

					if($m[$i][0] == 0){
					
					    $fvals .= '<td '.$thClass.'><input readonly type="hidden" class="form-control" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" value="'.$inputVal.'" ';

						$fvals .= '></td>';
					}

					if($m[$i][0] == 1){

						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}

					    $fvals .= '<td '.$thClass.'><input readonly type="text" class="form-control'.$extraClass.'" title="'.$inputVal.'" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" value="'.htmlspecialchars($inputVal,ENT_QUOTES).'" ';

						$fvals .= '></td>';

						// If GridCalculation 1 then add sum in footer
						if($m[$i][12] == 1 || $m[$i][12] == 2 || $m[$i][12] == 3){
							if (!in_array($m[$i][1], $gridCalculationFieldName)) {
								array_push($gridCalculationFieldName, $m[$i][1]);
								array_push($gridCalculationType,$m[$i][12]);
							}
						}
					
						//$fvals .= '<td><input type="text" value="'.$inputVal.'" class="form-control" name="'.$d[3].''.$m[$i][1].'[]" placeholder="'.$m[$i][2].'" /></td>';
					}

					if($m[$i][0] == 3){
						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}
					    $fvals .= '<td ><textarea readonly class="form-control'.$extraClass.'" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" '.$m[$i][6].'>'.$inputVal.'</textarea></td>';
					}

            		if($m[$i][0] == 12){	//IF Image
            		    $gridImg = "";
            		    if($inputVal > 0){

            		        $sql1 = "SELECT * FROM kmainmedia WHERE MediaID = " . $inputVal;
							$result1 = db::getInstance()->db_select($sql1, "F-16171: Cl-");
							$tmpRes = array_change_key_case($result1['result_set'][0]);
							// print_r($tmpRes);
							$tmpMediaName = $tmpRes[strtolower('MediaName')];
							$tmpMediaFolder = $tmpRes[strtolower('MediaFolder')];
							$tmpMediaType = $tmpRes[strtolower('MediaType')];
							if($result1['num_rows'] > 0)
								if(str_contains($tmpMediaType, "png") || str_contains($tmpMediaType, "jpeg") || str_contains($tmpMediaType, "jpg") || str_contains($tmpMediaType, "gif")){
									$gridImg = '<a target="_blank" href="'.$tmpMediaFolder.$tmpMediaName.'"><img src="'.$tmpMediaFolder.$tmpMediaName.'" width="60" /></a>';
								}else{
									$gridImg = '<a target="_blank" id="downloadImg" href="'.$tmpMediaFolder.$tmpMediaName.'">VIEW</a>';

								}
            		    }

            			$fvals .= '<td><input readonly type="hidden" value="'.$inputVal.'" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" '.$m[$i][6].' />'.$gridImg.'</td>';
            		}

            		if($m[$i][0] == 6){	//IF Date BOX	added by sneha on 01-11-2023
						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}

						//If date coming 1900-01-01 like this then show empty date
						if($inputVal == '1900-01-01' || $inputVal == '01-01-1990'){
							$inputVal = '';
						}

            			$fvals .= '<td '.$thClass.'><input readonly type="date" value="'.$inputVal.'" class="form-control dyn1'.$extraClass.'" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" placeholder="'.$m[$i][2].'" '.$m[$i][6].' /></td>';
            		}

					if($m[$i][0] == 7){	//IF Number BOX	added by pornima on 29-1-2024
						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}

            			$fvals .= '<td ><input readonly type="number" value="'.$inputVal.'" class="form-control'.$extraClass.'" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" '.$m[$i][6].' /></td>';

						// If GridCalculation 1 then add sum in footer
						if($m[$i][12] == 1 || $m[$i][12] == 2 || $m[$i][12] == 3){
							if (!in_array($m[$i][1], $gridCalculationFieldName)) {
								array_push($gridCalculationFieldName, $m[$i][1]);
								array_push($gridCalculationType,$m[$i][12]);
							}
						}
            		}

					if($m[$i][0] == 5){ // iF DD

						if($m[$i][3] < 0){ //FROM DB

							$index = ((-1) * $m[$i][3]) - 1;
							global $moreextradb;
							//updated by pornima now moreextradb getting using dbFieldName
							// $dbarray = $moreextradb[$index];
							$dbarray = $moreextradb[$d[7]][$m[$i][1]];

							$fieldKey = $d[7] . '|' . $m[$i][1];

							$inputVal = isset($v[$k][$i]) ? $v[$k][$i] : '';
							// echo "<br>inputval",$inputVal;
							// print_r($fieldOptions);
							$displayText = $fieldOptions[$fieldKey][$inputVal] ?? '';

							if ($m[$i][32] == 1) {
								$extraClass = " clickable-grid-input";
							} else {
								$extraClass = "";
							}
							
							$onchangeHidden = "";
							$fvals .= '<td><select readonly style="pointer-events:none;" 
									name="'.$d[3].$m[$i][1].'[]" 
									id="'.$d[3].$m[$i][1].'" 
									class="form-control grid-input'.$extraClass.'" title="'.htmlspecialchars($displayText, ENT_QUOTES).'">
										<option value="'.$inputVal.'" selected>'.$displayText.'</option>
									</select>'.$onchangeHidden.'</td>';
							
							// $sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0];				
							// if(strlen($dbarray[3]) > 1){
							// 	$sql1 .= " ".$dbarray[3];
							// }else{
							// 	$sql1 .= " WHERE 1=1";
							// }
							// $sql1 .= " AND ".$dbarray[1] ."=". $inputVal ;
							
							// $result1 = db::getInstance()->db_select($sql1, "F-16223: Cl-");

							// if ($m[$i][32] == 1) {
							// 	$extraClass = " clickable-grid-input";
							// } else {
							// 	$extraClass = "";
							// }
							
							// $row1 = $result1['result_set'];		

							

			
						}
						//else{
							//$fvals .= '<td><select name="'.$d[3].''.$m[$i][1].'[]" placeholder="'.$m[$i][2].'" id="'.$m[$i][1].'" class="form-control" '.$m[$i][6].' ><option value="0">'.$m[$i][2].'</option>';
							//for($j = 0; $j < sizeof($r[$m[$i][3]]); $j++){
								//$p = $j+1;  //value
								//if($p == $inputVal) $fvals .= '<option selected value="'. $p .'" >'.$r[$m[$i][3]][$j].'</option>&nbsp;';
								//else $fvals .= '<option value="'. $p .'" >'.$r[$m[$i][3]][$j].'</option>&nbsp;';
							//}
							$fvals .= '</select></td>';
						//}
					}

					if($m[$i][0] == 16){ //Multy-select Popup Datatable
						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}
						// echo "hi";
						if($m[$i][3] < 0){ //FROM DB
							// $index = ((-1) * $m[$i][3]) - 1;
							global $moreextradb;
							// print_r($moreextradb);
							$mapTable = $moreextradb[$d[7]][$m[$i][1]][5];				
							$mapIndex = $moreextradb[$d[7]][$m[$i][1]][6];				
							$mapVariant = $moreextradb[$d[7]][$m[$i][1]][7];
							$joinTable = $moreextradb[$d[7]][$m[$i][1]][0];
							$joinIndex = $moreextradb[$d[7]][$m[$i][1]][1];
							$mapTableEid = $moreextradb[$d[7]][$m[$i][1]][1];
							$mapTableElb = $moreextradb[$d[7]][$m[$i][1]][2];

							$mapTableQuery = 'SELECT '. $joinTable.'.'.$mapTableEid .','. $joinTable.'.'.$mapTableElb .' FROM ' . $mapTable ;
							$mapTableQuery .= ' LEFT JOIN ' . $joinTable . ' ON ' . $mapTable.'.'.$mapVariant . ' = ' . $joinTable.'.'.$joinIndex . ' WHERE ' . $mapIndex . ' = ' . $v[$k][sizeof($v[$k])-2] ;
							
							$mapQueryResult = db::getInstance()->db_select($mapTableQuery, "F-16281: Cl-");
							
							$mapQueryData = $mapQueryResult['result_set'];
							
							$mapQueryValue = [];
							$mapQueryID = [];
							if(is_array($mapQueryData)){
								for($t=0; $t<sizeof($mapQueryData); $t++){
									array_push($mapQueryValue, $mapQueryData[$t][$mapTableEid]);
									array_push($mapQueryID, $mapQueryData[$t][$mapTableElb]);
								}
								$mTValue = implode(',', $mapQueryValue);
								$mTID = implode(',', $mapQueryID);
							}
						}
						$fvals .= "<td><input disabled type='text'  id='".$d[3].$m[$i][1]."-text' name='".$d[3].$m[$i][1]."-text[]'  data-tag-class='badge badge-primary' class='form-control".$extraClass."' style='cursor: pointer;background-color: white;' value='".$mTID."'><input type='hidden' id='".$d[3].$m[$i][1]."' name='".$d[3].$m[$i][1]."[]' value='".$mTValue."'></td> ";

					}

					if($m[$i][0] == 17){ //Single-select Popup Datatable
						if(strlen($m[$i][6]) > 3){
							$str1 = 'AdjustableAmount';
							$AdjustableAmountPos = -1;
							if (strpos($m[$i][6], $str1) !== false){
								$AdjustableAmountPos = strpos($m[$i][6],$str1);
							}
							if($AdjustableAmountPos != -1){
								$newArr = substr($m[$i][6], $AdjustableAmountPos);
								$AdjustableAmountS = substr($newArr, strpos($newArr, '{')+1, strpos($newArr,'}') - 1);
								$AdjustableAmountStatus = str_replace('}','',$AdjustableAmountS);
							}
						}

						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}
						

						if(trim($AdjustableAmountStatus) == 'enable'){
							if($m[$i][1] == 'adjamount' || $m[$i][1] == 'adjamt'){
								$fvals .= "<td><input disabled type='text'  id='".$d[3]."".$m[$i][1]."-text' name='".$d[3]."".$m[$i][1]."-text[]'  data-tag-class='badge badge-primary' class='form-control".$extraClass."' style='cursor: pointer;' value='".$inputVal."'><input type='hidden' id='".$d[3]."".$m[$i][1]."' name='".$d[3]."".$m[$i][1]."[]' value='".$inputVal."'></td> ";
								$AdjustableAmountStatus = '';
							}
						}else{
							if($m[$i][3] < 0){ //FROM DB
								$index = ((-1) * $m[$i][3]) - 1;
								global $moreextradb;
								//updated by pornima now moreextradb getting using dbFieldName
								// $dbarray = $moreextradb[$index];
								$dbarray = $moreextradb[$d[7]][$m[$i][1]];
								// print_r($dbarray);
								$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0]." ".$dbarray[3] ." WHERE ".$dbarray[1]."='".$inputVal."'";					
								$result1 = db::getInstance()->db_select($sql1, "F-16328: Cl-");
								$row1 = $result1['result_set'];	
								if($k_debug){	echo '<br /><br />' . $sql1 . '<br />'; print_r($result1); echo '<br /><br />'; }
							}
							$fvals .= "<td><input disabled type='text'  id='".$d[3].$m[$i][1]."-text' name='".$d[3].$m[$i][1]."-text[]'  data-tag-class='badge badge-primary' class='form-control".$extraClass."' style='cursor: pointer;' value='".$row1[0][$dbarray[2]]."'><input type='hidden' id='".$d[3].$m[$i][1]."' name='".$d[3].$m[$i][1]."[]' value='".$inputVal."'></td> ";
						}

						// If GridCalculation 1 then add sum in footer
						if($m[$i][12] == 1 || $m[$i][12] == 2 || $m[$i][12] == 3){
							if (!in_array($m[$i][1], $gridCalculationFieldName)) {
								array_push($gridCalculationFieldName, $m[$i][1]);
								array_push($gridCalculationType,$m[$i][12]);
							}
						}
					}

                    if($m[$i][0] == 18){
						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}
                        // echo $inputVal;
						$fvals .= '<td ><input disabled class="form-control'.$extraClass.'" type="time" value="'.$inputVal.'"  name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" "'.$m[$i][6].'" /></td>';
					}

                    if($m[$i][0] == 19){ // iF DD
						if($m[$i][3] < 0){ //FROM DB
							$index = ((-1) * $m[$i][3]) - 1;
							global $moreextradb;

							if ($m[$i][32] == 1) {
								$extraClass = " clickable-grid-input";
							} else {
								$extraClass = "";
							}

							//updated by pornima now moreextradb getting using dbFieldName
							// $dbarray = $moreextradb[$index];
							$dbarray = $moreextradb[$d[7]][$m[$i][1]];
							$sql1 = "SELECT ".$dbarray[1].",".$dbarray[2]." FROM ".$dbarray[0]." ". $dbarray[3];					
							$result1 = db::getInstance()->db_select($sql1, "F-16349: Cl-");
							$row1 = $result1['result_set'];												
							$fvals .= '<td><select readonly style="pointer-events: none;" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" class="form-control'.$extraClass.'"  ';
							$onchangeHidden = "";
							// if($m[$i][8] == 1){
							// 	$onchange = " onchange=\"CreateOnchangeScriptGrid(this);\"";
							// 	$fvals .= $onchange;
							// 	$onchangeHidden = '<input type="hidden" id="kreon-grid-'.$d[3].$m[$i][1].'-hidden" value="' . $m[$i][9] . '" />';//,' . $m[$i][1] . ',' . $m[$i][0] . '
							// 	// $changeScript .= "$('[name=\"".$d[3].$m[$i][1]."[]\"]').change(function(evt) { alert('The option with value ' + $(this).val() + ' and text ' + evt.target.value + ' ' + $(this).text() + ' was selected.'); });";
							// }
							$fvals .= '>';
							// $fvals .= '><option value="0">'.$m[$i][2].'</option>';

							for($j = 0; $j < sizeof($row1); $j++){ 
								if($inputVal == $row1[$j][$dbarray[1]])
									$fvals .= '<option value="'. $row1[$j][$dbarray[1]] .'" selected>'.$row1[$j][$dbarray[2]].'</option>&nbsp;';
								else
									$fvals .= '<option value="'. $row1[$j][$dbarray[1]] .'" >'.$row1[$j][$dbarray[2]].'</option>&nbsp;';
							}
							$fvals .= '</select>'.$onchangeHidden.'</td>';
						}
						else{
							$fvals .= '<td><select name="'.$d[3].''.$m[$i][1].'[]" placeholder="'.$m[$i][2].'" id="'.$m[$i][1].'" class="form-control" '.$m[$i][6].' >'; //<option value="0">'.$m[$i][2].'</option>

							for($j = 0; $j < sizeof($r[$m[$i][3]]); $j++){
								$p = $j+1;  //value
								if($p == $inputVal) $fvals .= '<option selected value="'. $p .'" >'.$r[$m[$i][3]][$j].'</option>&nbsp;';
								else $fvals .= '<option value="'. $p .'" >'.$r[$m[$i][3]][$j].'</option>&nbsp;';
							}
							$fvals .= '</select></td>';
						}
					}

					if($m[$i][0] == 27){  // Label with Button triggering Bootstrap Modal
						if ($m[$i][32] == 1) {
							$extraClass = " clickable-grid-input";
						} else {
							$extraClass = "";
						}
						$fvals .= '<td ><input readonly type="text" value="'.$inputVal.'" class="form-control'.$extraClass.'" name="'.$d[3].''.$m[$i][1].'[]" id="'.$d[3].''.$m[$i][1].'" '.$m[$i][6].' /></td>';

					}

				}
			
				if(isset($_REQUEST['preview'])){
					$isPreview = 1;
				}else{
					$isPreview = 0;
				}
					// echo $isPreview ." == ". strlen($db[5]) ." == ". strlen($d[12]);
				
				// echo "jjjj".$v[$k][sizeof($v[$k])-1];
				$fvals .= '<td style="padding1:2px 3px !important;"><a style="padding:3px;margin:2px;" href="javascript:void(0)" class="btn btn-info edits'.$d[3].'"><span class="glyphicon glyphicon glyphicon-pencil" aria-hidden="true"></span></a><a style="padding:3px;" href="javascript:void(0)" class="btn btn-danger removes'.$d[3].'"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span></a><input type="hidden" name="'.$d[3].'GridEditID[]" id="'.$d[3].'GridEditID" value="'.$v[$k][sizeof($v[$k])-2].'"><input type="hidden" name="'.$d[3].'GridTempID[]" id="'.$d[3].'GridTempID" value="'.$v[$k][sizeof($v[$k])-1].'">';
				
				if($isPreview == 1 && strlen($db[5]) > 3 && strlen($d[12]) > 3) {
					if($d[12] == 'uniqueid'){
						$gRowId = $v[$k][sizeof($v[$k])-1];
					}else if($d[12] == 'id'){
						$gRowId = $v[$k][sizeof($v[$k])-2];
					}
					$fvals .= '<button class="btn btn-primary bizbtn grid-barcode-btn" style="font-size:10px;" data-toggle="tooltip" data-placement="bottom" title="Barcode" onclick="ListViewBarcodePrint(\''.$id.'\',\''.$gRowId.'\')"><i class="fa fa-barcode"></i></button>';
				}
				
				$fvals .= '</td>';
				$fvals .= '</tr>';
				//$fvals .= '<td><a href="javascript:void(0)" class="btn btn-danger removes'.$d[3].'"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>';
			}	

			

			$fieldCount = $k;
		}

		$fldCnt = '<input type="hidden" value="'.$fieldCount.'" name="cnt'.$d[3].'" id="cnt'.$d[3].'" data-minrowsreq="'.$d[11].'"><input type="hidden" value="'.$d[7].'" name="GridId'.$d[3].'" id="GridId'.$d[3].'"><input type="hidden" value="" name="DeletedGridRowID'.$d[3].'" id="DeletedGridRowID'.$d[3].'">';
		$tableHead .= "</tr>";
		$tableHead .= "</thead>";
		
		$hiddenTableForImport = '<table class="hidden" id="GridTable'.$d[3].'">'.$tableHead.'</table>';
		//echo htmlspecialchars($tableHead);
		$footerGrid = "";
		// if($d[6] == 1){	
			$footerGrid = '<tfoot><tr>'; //class="grp'.$d[3].'" id="'.$d[3].'GridFooter"
				for($i = 0; $i < sizeof($m); $i++){	
					// echo sizeof($m);
					if($m[$i][12] > 0 ){	
						$footerGrid .= '<td><input type="number" class="form-control" readonly name="" id="'.$d[3]."".$m[$i][1].'Footer" value=""></td>';
					}else{
						if($m[$i][0] > 0 || $m[$i][26] == 1){ 
							$footerGrid .= '<td ></td>';
						}
					}
				}
				// $footerGrid .= '<td></td>';
			$footerGrid .= '</tr></tfoot>';
		// }

		if($gridCalculationFieldName != null && count($gridCalculationFieldName) > 0){
			?>
			<script>
				setTimeout(
					function() {
						CreateOnChangeScriptGridCalculation(<?php echo json_encode($gridCalculationFieldName); ?>,<?php echo json_encode($gridCalculationType); ?>,<?php echo "'".$d[3]."'"; ?>);
					},
				500);
			</script>
			<?php
		}

		

		if(empty($v)){
			return $script . $temp . $fldCnt . $hiddenTableForImport . $tableStart . $tableHead . $headerGridStart . "0" . $headerGridEnd . $flds . $end . $footerGrid . $tableEnd."</div></div>";
		}else{
			
			return $script . $temp . $fldCnt . $hiddenTableForImport . $tableStart . $tableHead . $flds . $fvals . $end . $footerGrid . $tableEnd."</div></div>";
		}
}

function debugArray($arr){		//DebugArray($result);
	print("<pre>".print_r($arr,true)."</pre>");
}

	//Reqd for More Grid ID Section Identifier. Also Reqd for View mode serials
	//$serials = array("a", "b", "c", "d", "e", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q");

	include 'model.php';

	include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

	

	// Function to log developer-level errors to the DeveloperErrorLogs table
	function logDevError($FieldName, $FormID, $session, $desc, $solution) {
		// SQL INSERT statement to log error details into DeveloperErrorLogs
		$sqlDev = "INSERT INTO DeveloperErrorLogs (
			[FormID], [CompanyID], [DivisionID], [YearCode], [Database_name],
			[ErrorCode], [ErrorField], [Description], [RecommendedSolution], [CreatedBy], [CreatedAt]
		) VALUES (
			$FormID,
			{$session['dbCompany']},
			{$session['dbDivision']},
			{$session['dbYearID']},
			'{$session['dbName']}',
			100,
			'$FieldName',
			'$desc',
			'$solution',
			{$session['user_id']},
			GETDATE()
		)";
		// Execute the insert query using the master DB instance
		db::getInstanceMaster()->db_insertQuery($sqlDev, "F-16478");
	}

	function array_change_key_case_recursive($array) {
		$result = [];
		foreach ($array as $key => $value) {
			$lowercaseKey = strtolower($key);
			if (is_array($value)) {
				$result[$lowercaseKey] = array_change_key_case_recursive($value); // Recursively change case for nested arrays
			} else {
				$result[$lowercaseKey] = $value;
			}
		}
		return $result;
	}

	if($viewpage == 1){	//VIEW MODE

		// Check if the FormEditValidationMessage is set in the session
		if (isset($_SESSION['FormEditValidationMessage'])) {
			$alertMessage = Encoding::fixUTF8($_SESSION['FormEditValidationMessage'],Encoding::ICONV_IGNORE);

			// Display the alert with JavaScript
			// echo '<script>alert("' . htmlspecialchars($alertMessage, ENT_QUOTES, 'UTF-8') . '");</script>';
			echo "<script>alert('" . $alertMessage . "');</script>";
			
			// Unset the session variable after displaying the alert so it doesn't show again on refresh
			unset($_SESSION['FormEditValidationMessage']);
		}


		function handleDeleteEntry($delID, $FormID, $db) {
			$isDeletedFlag = false;
			$deleteErrorMsg = '';
			$deleteConfirm = 0;

			// Check if delete SP exists
			$deleteSPName = "sp_ValidateDelete_$FormID";
			$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO' AND routine_name = '$deleteSPName'";
			$sqlresult = db::getInstance()->db_select($sql, "F-16517: Cl-");

			

			if ($sqlresult['result_set'][0]['found'] == 0) {
				$deleteConfirm = 1; // No SP, delete directly
			} else {
				// Call SP to check validations before deleting
				$session = 'YearCode=' . $_SESSION['dbYear'] . ' AND DivisionId=' . $_SESSION['dbDivision'] . ' AND CompanyId=' . $_SESSION['dbCompany'] . ' AND FormID=' . $FormID;
				$sp['params'] = ['@DELETEID', '@TABLENAME', '@USERID', '@SESSION'];
				$sp['values'] = ["'$delID'", "'".$db[0]."'", "'".$_SESSION['user_id']."'", "'$session'"];

				$result = db::getInstance()->db_sp_select($deleteSPName, $sp['params'], $sp['values'], "F-16529: Cl-");
				
				if ($result['error'] == 1) {
					$deleteConfirm = -1;
					$deleteErrorMsg = $result['error_statement'];
				} else {
					$row = $result['result_set'][0][0];
					$deleteConfirm = ($row['Success'] == 1) ? 1 : -1;
					
					if ($deleteConfirm == -1) {
						$deleteErrorMsg = $row['Msg'];
					}
				}
			}

			// Return confirmation result and any message
			return [
				'deleteConfirm' => $deleteConfirm,
				'errorMsg' => $deleteErrorMsg
			];
		}

		// ========== MAIN DELETE ENTRY FLOW ==========
		$isDeletedFlag = false;
		$deleteConfirm = 0;
		$deleteErrorMsg = 'Unable to delete';
		if(isset($_POST["delID"]) || isset($_GET['delID'])){	//check if delete was called
			if(isset($_POST["delID"])){
				$delID = $_POST["delID"];
			}else{
				$delID = $_GET["delID"];
			}


			if($delID > 0){
				// alert("hi",$delID);

				/*20-10-2025 : This section will check if anyone is in entry edit mode, and if so, it will not allow deleting the same entry*/
				$sql = "SELECT * FROM kFormEditLock 
						WHERE FormID = $FormID AND EntryID = $delID AND CompanyID = {$_SESSION['dbCompany']} 
						AND DivisionID = {$_SESSION['dbDivision']} AND YearCode = '{$_SESSION['dbYear']}' 
						 AND isDeleted = 0"; //AND UserID <> {$_SESSION['user_id']}

				
				
				$sqlresult = db::getInstance()->db_select($sql, "F-17519: Cl-");

				if ($sqlresult['num_rows'] > 0) {
					//If user editing this entry then redirect to priview page & show message
					$userQuery = "SELECT * FROM users WHERE ID={$sqlresult['result_set'][0]['UserID']}";
					$userResult = db::getInstanceMaster()->db_select($userQuery, "F-17524");

					$_SESSION['FormEditValidationMessage'] = $userResult['result_set'][0]['Username'] ." is currently editing this entry. Yoy can not delete this entry.";

					// $_SESSION['FormEditValidationMessage'] = "$userResult['result_set'][0]['Username'] is currently editing this entry. Yoy can not delete this entry.";

					$fullURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				
					// Redirect user to the referring page, indicating a view mode with the form ID
					echo '<script>window.location="'.$fullURL.'";</script>';
					exit(); // Stop script execution after redirect
					
				
				}


				/*1742025 This section will checck session & db companyid, divisionid, yearcode are same then allow to edit */

				if($viewSettings[12] != 1)
				{
					$checkSessionData = "SELECT * FROM " . $db[0] . " WHERE " . $db[1] . " = " . $delID;
					$resultSessionData = db::getInstance()->db_select($checkSessionData, "F-16570: Cl-");
					$record = $resultSessionData['result_set'][0];
					
					$checks = [
						'CompanyId'  => [$_SESSION['dbCompany'], $record['CompanyId'] ?? null],
						'DivisionId' => [$_SESSION['dbDivision'], $record['DivisionId'] ?? null],
						'YearCode'   => [$_SESSION['dbYear'], $record['YearCode'] ?? null],
					];
				
					
					foreach ($checks as $field => $values) {

						$v1 = (int) $values[0];
						$v2 = $values[1];

						if (is_null($v2)) {
							// Skip comparison if DB value is missing
							continue;
						}

						if ($v1 !== (int) $v2) {

							logDevError($field, $FormID, $_SESSION, "$field mismatch: Session = $sessionValue, DB = $dbValue", "Mismatch in $field");

							$_SESSION['FormEditValidationMessage'] = "Entry Not Deleted. $field mismatch";

							$fullURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						
							// Redirect user to the referring page, indicating a view mode with the form ID
							echo '<script>window.location="'.$fullURL.'";</script>';
							exit(); // Stop script execution after redirect
						}
					}

				}

				
				
				/* --------------------------------------------- */

				// Step 1: validate deletion
				$checkResult = handleDeleteEntry($delID, $FormID, $db);
				
				$deleteConfirm = $checkResult['deleteConfirm'];
				$deleteErrorMsg = $checkResult['errorMsg'];

				

				// Step 2: get current URL and clean up
				$fullURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				if (isset($_GET['delID'])) {
					$fullURL = preg_replace('/&delID=.*$/', '', $fullURL);
				}

				// Step 3: show confirm popup if allowed
				if ($deleteConfirm == 1 && !isset($_POST['confirm'])) {
					echo "<form id='confirmDeleteForm' method='POST' action=''>
						<input type='hidden' name='delID' value='$delID'>
						<input type='hidden' name='confirm' value='yes'>
					</form>
					<script>
						if (confirm('Are you sure you want to delete this entry?')) {
							document.getElementById('confirmDeleteForm').submit();
						}else{
							window.location.href = '$fullURL';
						}
					</script>";
					exit();
				}else if ($deleteConfirm == -1) {

					$cleanURL = preg_replace('/([&?])confirm=yes(&)?/', '$1', $fullURL);
					$cleanURL = rtrim($cleanURL, '&?'); // Clean trailing & or ?
					$deleteErrorMsg = stripcslashes($deleteErrorMsg);
					$deleteErrorMsg = str_replace('"', '', $deleteErrorMsg);
					// $deleteErrorMsg = json_encode($deleteErrorMsg);
					// if($_SESSION['user_id'] == 1020){
					// 	echo $deleteErrorMsg;
					// 	echo "<br>".$cleanURL;
					// 	exit();
					// }
					echo "<script>alert('$deleteErrorMsg'); window.location='$cleanURL';</script>";
				}

				// Step 4: if confirm=yes, proceed with actual delete
				if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
					// Re-fetch original record
					$delData = "SELECT * FROM " . $db[0] . " WHERE " . $db[1] . " = " . $delID;
					$delResult = db::getInstance()->db_select($delData, "F-16655: Cl-");

					$query1 = "DELETE FROM " . $db[0] . " WHERE " . $db[1] . " = " . $delID;
					$query1result = db::getInstance()->db_update($query1, $FormID, "F-16658: Cl-");

					if ($query1result['error']) {
						$isDeletedFlag = false;
						$deleteErrorMsg = $query1result['error_statement'];
					} else {
						$isDeletedFlag = true;

						// Delete from grid tables
						$query2 = "SELECT GridId FROM kmainfields WHERE FieldType=14 AND FormID=$FormID";
						$query2result = db::getInstanceMaster()->db_select($query2, "F-16668");
						$gridResult = $query2result['result_set'];

						for ($i = 0; $i < sizeof($gridResult); $i++) {
							$query3 = "SELECT TableName, TablePrimaryKey, TableUnique FROM kmaingrid WHERE GridId=" . $gridResult[$i]['GridId'];
							$query3result = db::getInstanceMaster()->db_select($query3, "F-16673");
							$tableInfo = $query3result['result_set'][0];

							$query4 = "DELETE FROM " . $tableInfo['TableName'] . " WHERE " . $tableInfo['TablePrimaryKey'] . " = '" . $delResult['result_set'][0][$tableInfo['TableUnique']] . "'";
							db::getInstance()->db_update($query4, $FormID, "F-16677: Cl-");
						}
					}

					// Remove &confirm=yes or ?confirm=yes from the URL
					$cleanURL = preg_replace('/([&?])confirm=yes(&)?/', '$1', $fullURL);
					$cleanURL = rtrim($cleanURL, '&?'); // Clean trailing & or ?



					// Final redirect or alert
					if ($isDeletedFlag) {
						echo '<script>window.location="' . $cleanURL . '";</script>';
					} else {
						$deleteErrorMsg = stripcslashes($deleteErrorMsg);
						$deleteErrorMsg = str_replace('"', '', $deleteErrorMsg);
						echo "<script>alert('$deleteErrorMsg'); window.location='$cleanURL';</script>";
					}
				} 
			}
		}

		$viewvals = array();

		//there are 3 ways to get the data - SP, View, Table
		if(strlen($db[3]) > 0){ //If ListViewDBName
			$sqlfields = "TOP 1 " . $db[3].".*";
		}else if(strlen($db[4]) > 0){ //If SPName
			$sqlfields = "TOP 1 " . $db[4].".*";
		}else{	//Table Name
			$sqlfields = "TOP 1 " . $db[0].".*";
		}
		
		
		$sqljoin = "";

		$serialCntFrImages = 0;

		if(strlen($db[3]) == 0 && strlen($db[4]) == 0){		//if it is not using SP or View, means Table name
			if(isset($extradb)){ 
				for($i = 0;$i < sizeof($extradb); $i++){
					//if(isset($extra))
					$temp = ""; $noFlag = 0; 
					//$mediaFlag = 0;
					for($j = 0; $j < sizeof($code); $j++){
						if($extradb[$i][0] == $code[$j][3]){

							$temp = $code[$j][0];

							if($code[$j][1] == 10) $noFlag=1; 

							if($code[$j][1] == 11) $noFlag=1; 

							if($code[$j][1] == 12) $noFlag=1; 

							if($code[$j][1] == 13) $noFlag=1; 

							break;
						}
					}

					if($noFlag) goto a;

					$sqlfields .= " , COALESCE(".$serials[$i].".".$extradb[$i][3].", '-') as ".$temp.$serials[$i];
					
					$sqljoin .= " LEFT JOIN ".$extradb[$i][1]." ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i].".".$extradb[$i][2] ;

					//if($mediaFlag) goto a;
					a: $temp="";
				}
				$serialCntFrImages = sizeof($extradb);
			}
		}
	
		//FOR MEDIA JOIN ONLY 12 on List View & 13 cannot be on List View
		if(strlen($db[3]) == 0 &&  strlen($db[4]) == 0){		//if it is not using SP or View, means Table name
			if(isset($code)){
				for($j = 0; $j < sizeof($code); $j++){
					if($code[$j][1] == 12){ 

						$temp = $code[$j][0];

						$sqlfields .= " , ISNULL(".$serials[$i].".MediaName, '-') as ".$temp.$serials[$i]."Name";

						$sqlfields .= " , ISNULL(".$serials[$i].".MediaFolder, '-') as ".$temp.$serials[$i]."Folder";

						$sqlfields .= " , ISNULL(".$serials[$i].".MediaType, '-') as ".$temp.$serials[$i]."Type";

						$sqljoin .= " LEFT JOIN kmainmedia ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i++].".MediaID";
					}
				}
			}else{
				echo "Please add Form fields";
				exit();
			}
				
		}

		/************NEW 12 07 2020************/
		if(!isset($forceCondition)){
			$forceCondition = "";
		}
		if(strlen($forceCondition) > 2){
		    $db[2] = $forceCondition;
		}else{
			if(strlen($db[2]) > 2){
				$db[2] = " ".$db[2];
			}elseif(strlen($db[3]) > 2){
				$db[3] = $db[3];
			}elseif(strlen($db[4]) > 2){
				$db[4] = $db[4];
			}else{
				$db[2] = " Order by ".$db[0].'.'.$db[1]." Desc";
			}
		}
		
		if(strlen($db[4]) > 0){		//USING SP
			$sql = $db[4]; //." Order by ".$db[0].'.'.$db[1]." Desc";
			$sqlColumns = "sp_describe_first_result_set N'$db[4]'";
			// $sqlColumns = $db[4];
			$data['params'] = [];
			$sp['values'] = [];

			$resultColumns = db::getInstance()->db_sp_select($sqlColumns, $data['params'], $sp['values'], "F-16800: Cl-");
	
			$resultColumnsRow = $resultColumns['result_set'];
		}else if(strlen($db[3]) > 0){	//USING VIEW
			$sql = "SELECT ".$sqlfields." FROM ".$db[3]; //." Order by ".$db[0].'.'.$db[1]." Desc";
			$sqlColumns = "SELECT * FROM information_schema.columns WHERE table_name="."'".trim($db[3])."'";

			$resultColumns = db::getInstance()->db_select($sqlColumns, "F-16807: Cl-");
			$resultColumnsRow = $resultColumns['result_set'];
			
		}else{		//USING TABLE
			$sql = "SELECT ".$sqlfields." FROM ".$db[0]." " .$sqljoin."  ".$db[2]; //." Order by ".$db[0].'.'.$db[1]." Desc";
		}
		//$sql = "SELECT ".$sqlfields." FROM ".$db[0]." " .$sqljoin." Order by ".$db[0].'.'.$db[1]." Desc";
		
		if($k_debug){ echo '<br/>' . $sql; }

		if (in_array($db[0],$MainDBTable)){	//CHECK WHY IS THIS USED?????????????????????
			$Instance = db::getInstanceMaster();
			$dbName = 'Main';
			$line = "F-16820";
		}else{
			$Instance = db::getInstance();
			$dbName = $_SESSION['dbName'];
			$line = "F-16824: Cl-";
		}

		if(strlen($db[4]) > 0){
			$resultColumns = db::getInstance()->db_sp_select($sql, $data['params'], $sp['values'], "F-16826: Cl-");
		}else{
			$result = $Instance->db_select($sql, $line);
		}
		
		if($k_debug){ echo '<br/>'; print_r($result); }
		// print("<pre>".print_r($result)."</pre>");
		$sr = array();

		for($j = 0; $j < sizeof($code); $j++){
			if($code[$j][1] == 12 || $code[$j][1] == 13 ){
				$sr[$j] = $serialCntFrImages++;
			}
		}

		if(strlen($db[3]) == 0 || strlen($db[4]) == 0){
			for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row
				for($j = 0; $j < sizeof($code); $j++){
					//echo "<br />" . $code[$j][3];
					if($code[$j][1] == 14 ){
						//Grid 
						$viewvals[$i][$j] = "";
					}else{
						if($code[$j][1] == 10 ){ //DB REFERENCE WITH MULTIPLE
							$viewvals[$i][$j] = "";
						}else{
							if($code[$j][1] == 11 || $code[$j][1] == 13 || $code[$j][1] == 16){ //DB REFERENCE WITH MULTIPLE
								$viewvals[$i][$j] = "";
							}else{
								if($code[$j][1] == 12){ //SINGLE MEDIA 
									$mediaType = $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Type"];
									if($mediaType == "jpg" || $mediaType == "jpeg" || $mediaType == "png" || $mediaType == "bmp" ){
										$viewvals[$i][$j] = "<a href='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' target='_blank'>" . "<img src='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' height='100px'>"."</a>";
									}else{
										$viewvals[$i][$j] = "<a href='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' target='_blank'>" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."</a>";
									}
								}else{							
									/*REMOVED EMAIL FROM DB REFERENCE 10 03 2021*/							
									if($code[$j][1] == 9 || $code[$j][1] == 10 || $code[$j][3] < 0 ) //DB REFERENCE 
										$viewvals[$i][$j] = $result['result_set'][$i][$code[$j][0].$serials[(-1*$code[$j][3])-1]];
									else 
										$viewvals[$i][$j] = $result['result_set'][$i][$code[$j][0]];
								}
							}
						}
					}
				}

				//$serialCntFrImages++;
				// print_r($viewvals); //exit();

				$viewvals[$i][$j] = $result['result_set'][$i][$db[1]];

				// print_r($db); exit();
				// print_r($viewvals);
			}
		}
		// print_r($viewvals);
		$k_table_title = "List View";
		// 		$k_table_button_link = $_SERVER['PHP_SELF'].'?form='.$FormID;
		// 		$k_table_button = "Add New";

		if($pageAccessForUser['AddBtn'] == 1 || $bypassUserRoles) { 
    		$k_table_button_link = $_SERVER['PHP_SELF'].'?form='.$FormID;
    		$k_table_button = "Add New";
		}

		//$k_print_title = "Print Title";
		$k_table_headings = '<tr>';
		$k_table_headings1 = '';
		
		//VALIDATION TO CHECK IF PRIMARY KEY IS AVAILABLE IN SP OR VIEW
		$isPrimaryKeyPresent = false;

		// if($FormID == 3106){
		// 	echo "<pre>";
		// 	print_r($viewcode);
		// 	// echo $sql;
		// }


		if(strlen($db[3]) > 0 || strlen($db[4]) > 0){
			$columnArray = [];
		
			if(strlen($db[4]) > 0){
				if(is_array($resultColumnsRow[0])){
					for($i=0;$i<sizeof($resultColumnsRow[0]); $i++){
						$columnArray[$i]['Field'] = $resultColumnsRow[0][$i]['name'];
						$columnArray[$i]['Type'] = $resultColumnsRow[0][$i]['system_type_name'];
						
						if($db[1] == $columnArray[$i]['Field'])	$isPrimaryKeyPresent = true;
					}
				}
			}else if(strlen($db[3]) > 0){
				for($i=0;$i<sizeof($resultColumnsRow); $i++){
					// if($resultColumnsRow[$i]['COLUMN_NAME'] == $db[1]) continue;	//ADDED BY MITESH FOR VIEW NAME
					$columnArray[$i]['Field'] = $resultColumnsRow[$i]['COLUMN_NAME'];
					$columnArray[$i]['Type'] = $resultColumnsRow[$i]['DATA_TYPE'];
					// echo $db[1] . " && " . $columnArray[$i]['Field'] . "<br />";
					if($db[1] == $columnArray[$i]['Field'])	$isPrimaryKeyPresent = true;
				}
			}
			//VALIDATION TO CHECK IF PRIMARY KEY IS AVAILABLE IN SP OR VIEW
			if(!$isPrimaryKeyPresent)	{ 
				if($_SESSION['Category'] == 2) //Show error for developer login else only error code
					echo "<p style='font-size:20px; color:red;'>Error Code 635: Primary Key not present in LIST VIEW</p>";
				else 
					echo "<p style='font-size:20px; color:red;'>Error Code 635: ERROR IN STRUCTURE. CONTACT DEVELOPER</p>";
				$sqlDev = "INSERT INTO DeveloperErrorLogs([FormID],[CompanyID],[DivisionID],[YearCode],[Database_name],[ErrorCode],[ErrorField],[Description],[RecommendedSolution],[CreatedBy],[CreatedAt])Values("
							. $FormID .",". $_SESSION['dbCompany'].",".$_SESSION['dbDivision'].",".$_SESSION['dbYearID'].",'".$_SESSION['dbName']."',635,'".$m[$i][1]."','Primary Key not present in LIST VIEW','Add Primary Key in LIST VIEW',".$_SESSION['user_id'].",GETDATE())";
				$resultDev = db::getInstanceMaster()->db_insertQuery($sqlDev, "F-16938");
				// echo "ERROR IN STRUCTURE. CONTACT DEVELOPER.<script>console.log('Primary Key not present in LIST VIEW');</script>";
				goto NoTablePrint; 
			}

			// array_shift($columnArray);
			$extraButtonCount = 0;
			for($j=0;$j<sizeof($viewcode); $j++){
				if($viewcode[$j][0] == "-2"){
					if($pageAccessForUser['EditBtn'] == 1 || $bypassUserRoles)
						array_push($columnArray, ['Field' => "Edit", 'Type' => "-2"]);
						$extraButtonCount++;
				}else{
					if($viewcode[$j][0] == "-3"){
						if($pageAccessForUser['DeleteBtn'] == 1 || $bypassUserRoles)
							array_push($columnArray, ['Field' => "Delete", 'Type' => "-3"]);
							$extraButtonCount++;				
					}else{
						if($viewcode[$j][0] == "-4"){
							if($pageAccessForUser['OtherBtn'] == 1 || $bypassUserRoles)
								array_push($columnArray, ['Field' => "Action", 'Type' => "-4"]);
								$extraButtonCount++;
						}else{
							if($viewcode[$j][0] == "-5"){
								if($pageAccessForUser['ViewBtn'] == 1 || $bypassUserRoles)
									array_push($columnArray, ['Field' => "View", 'Type' => "-5"]);
									$extraButtonCount++;
							}else{
								if($viewcode[$j][0] == "-6"){
									if($pageAccessForUser['SaveAndPreviewBtn'] == 1 || $bypassUserRoles)
										array_push($columnArray, ['Field' => "SaveAndPreview", 'Type' => "-6"]);
										$extraButtonCount++;
								}else{
									if($viewcode[$j][0] == "-1" )
										array_unshift($columnArray, ['Field' => "Sr. No", 'Type' => "-1"]);

								}
							}	
						}
					}
				}
			}
			
			//Added column for checkbox
			array_unshift($columnArray,['Field' => "checkbox", 'Type' => "-99"]);
			// echo "<pre>";
			// print_r($columnArray);
			echo "<script> var viewcodeArray = []; </script>";
			for($i=0;$i<sizeof($columnArray); $i++){
				if($columnArray[$i]['Type'] > 0){
					$k_table_headings .= '<th>'.$columnArray[$i]['Field'].'</th>';
					$k_table_headings1 .= '<th>';
					if($columnArray[$i]['Type'] > 0 ){
						echo "<script>
							viewcodeArray.push('".$columnArray[$i]['Field']."'); 
							var currentId = '".$columnArray[$i]['Field']."'; // Get the ID
								if (currentId.indexOf(' ') !== -1) {
								// Alert that the ID has a space
								alert(currentId+' search ID contain a space');
							}
						</script>";
						$k_table_headings1 .= "<input type='search' class='form-control' ";
						$k_table_headings1 .= 'id="'.$columnArray[$i]['Field'].'" name="'.$columnArray[$i]['Field'].'" placeholder="'.$columnArray[$i]['Field'].'">';

						echo '<script>
								$(document).ready(function() { 
									$("#'.$columnArray[$i]['Field'].'").keypress(function(e) {
										if(e.which == 13) {
											var variable = "";
											var value = "";
											for(var m=0; m<viewcodeArray.length; m++){
												if(viewcodeArray[m] != ""){
													// Check if the ID contains a space
													// if (viewcodeArray[m].indexOf(" ") !== -1) {
													// 	alert("ID containing space: " + viewcodeArray[m]);
													// 	return; // Stop further execution if theres an ID with space
													// }
													
													if($("#"+viewcodeArray[m]).val() != "" && $("#"+viewcodeArray[m]).val() != undefined){
														value += $("#"+viewcodeArray[m]).val();
														value += ",";
														variable += viewcodeArray[m]+",";
													}
												}
											}
											if (value.charAt(value.length - 1) === ",") {
												value = value.slice(0, -1);
											}
											if (variable.charAt(variable.length - 1) === ",") {
												variable = variable.slice(0, -1);
											}
											$("#datatable-table").DataTable().destroy();
											console.log(variable,value);
											if(value != undefined && value != ""){
												load_data(variable,value);
											}else{
												variable = "";
												value = "";
												load_data(variable,value);
											}
										}
									});
								}); 
							</script>';
					}
					$k_table_headings1 .= '</th>';
				}else{
					if($columnArray[$i]['Type'] == "-99"){	//FOR CHECKBOX
						$k_table_headings .= '<th></th>';
						$k_table_headings1 .= '<th></th>';
					}
					if($columnArray[$i]['Type'] == "-1"){	//FOR Sr No
						$k_table_headings .= '<th>'.$columnArray[$i]['Field'].'</th>';
						$k_table_headings1 .= '<th></th>';
					}
				}				
			}
			$k_table_headings .= '<th>Action(s)</th>';
			$k_table_headings1 .= '<th></th>';
		}else{
			
			//Added column for checkbox
			array_unshift($viewcode,['0' => '-99', '1' => "checkbox", '2' => "", '3' => "", '4' => ""]);

			echo "<script> var viewcodeArray = []; </script>";
			for($i=0;$i<sizeof($viewcode); $i++){

				if($viewcode[$i][0] == "-99"){	//FOR CHECKBOX
					$k_table_headings .= '<th></th>';
					$k_table_headings1 .= '<th></th>';
				}else{
					if($viewcode[$i][0] == "-1"){	//FOR Sr No
						$k_table_headings .= '<th>'.$viewcode[$i][1].'</th>';
						$k_table_headings1 .= '<th></th>';
					}else{
							if($viewcode[$i][1] != "Sr. No." && $viewcode[$i][1] != "Edit" && $viewcode[$i][1] != "Delete" && $viewcode[$i][1] != "Action" && $viewcode[$i][1] != "View" && $viewcode[$i][1] != "SaveAndPreview"){
							$k_table_headings .= '<th>'.$viewcode[$i][1].'</th>';
							$k_table_headings1 .= '<th>';

							echo "<script>viewcodeArray.push('".$viewcode[$i][3]."'); </script>";
							$k_table_headings1 .= "<input type='search' class='form-control' ";
							$k_table_headings1 .= 'id="'.$viewcode[$i][3].'" name="'.$viewcode[$i][3].'" placeholder="'.$viewcode[$i][1].'">';

							echo '<script>
								$(document).ready(function() { 
									$("#'.$viewcode[$i][3].'").keypress(function(e) {
										if(e.which == 13) {
											var variable = "";
											var value = "";
											for(var m=0; m<viewcodeArray.length; m++){
												if(viewcodeArray[m] != ""){
													
												if($("#"+viewcodeArray[m]).val() != ""){
														value += $("#"+viewcodeArray[m]).val();
														value += ",";
														variable += viewcodeArray[m]+",";
													}
												}
											}
											if (value.charAt(value.length - 1) === ",") {
												value = value.slice(0, -1);
											}
											if (variable.charAt(variable.length - 1) === ",") {
												variable = variable.slice(0, -1);
											}
											$("#datatable-table").DataTable().destroy();
											if(value != undefined && value != "")
											{
												load_data(variable,value);
											}
											else
											{
												variable = "";
												value = "";
												load_data(variable,value);
											}
										}
									});
								}); 
							</script>';
							}
						
					}
				}
				
			}
			$k_table_headings .= '<th>Action(s)</th>';
			$k_table_headings1 .= '<th></th>';
		}
		
		// print_r($result);
		// var_dump($viewvals);
		$k_table_headings .= '</tr>';
		$k_table_body='';
		/*
			// if(strlen($db[3]) > 0){
			// 	/*
			// 	This was used earlier for list view but as the data is coming from Fetch.php dynamically,
			// 	now this is not required.
			// 	for($i=0; $i<sizeof($result['result_set']); $i++){
			// 		$k_table_body .= '<tr>';
			// 		for($j=0; $j<sizeof($columnArray); $j++){

			// 			if($columnArray[$j]['Field'] == "Edit"){	//EDIT 	
			// 				// if(is_array($viewvals[$i])){
			// 				$x = '<form name="form"  action="'.$_SERVER['PHP_SELF'].'?form='.$FormID.'" method="POST">
			// 						<input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							
			// 						<button class="btn btn-primary bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="edit"><i class="fa fa-pencil"></i></button>
			// 					</form>' ; 
		
			// 				$k_table_body .= '<td>'. $x .'</td>';
			// 				// }		
			// 			}else{
			// 				if($columnArray[$j]['Field'] == "View"){	//View 	
			// 					$viewlink = "";
			// 					if(isset($viewcodeextra)){
			// 						for($p = 0; $p < sizeof($viewcodeextra); $p++){
			// 							if($viewcodeextra[$p][0] == -3){
			// 								$viewlink = $viewcodeextra[$p][1];
			// 								break;
			// 							}
			// 						}
			// 					}
			// 					$x = '<form action="' . $viewlink . '?view='.$viewvals[$i][sizeof($viewvals[$i])-1].'" method="POST">
			// 							<input type="hidden" name="viewID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />
			// 							<button class="btn btn-primary bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="view" ><i class="fa fa-eye"></i></button>
			// 						 </form>' ; 
			// 					$k_table_body .= '<td>'. $x .'</td>';		
			// 				}else{
			// 					if($columnArray[$j]['Field'] == "Delete"){	//DELETE 	
			// 						$viewlink = "";
			// 						if(isset($viewcodeextra)){
			// 							for($p = 0; $p < sizeof($viewcodeextra); $p++){
			// 								if($viewcodeextra[$p][0] == -3){
			// 									$viewlink = $viewcodeextra[$p][1];
			// 									break;
			// 								}
			// 							}
			// 						}
			// 						// if(is_array($viewvals[$i])){
			// 						$x = '<form  method="POST">
			// 								<input type="hidden" name="delID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />
			// 								<button class="btn btn-danger bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="view" ><i class="fa fa-trash"></i></button>
			// 							 </form>' ; 
			// 						$k_table_body .= '<td>'. $x .'</td>';
			// 						// }		
			// 					}else{
			// 						if($columnArray[$j]['Field'] == "Action"){	//OTHER BTN 									
			// 							$x = '<form action="' . $viewSettings[7] . '" method="POST">
			// 									<input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />
			// 									<button class="btn btn-primary bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="" ><i class="fa '.$viewSettings[6].'"></i></button>
			// 								 </form>' ; 
					
			// 							$k_table_body .= '<td>'. $x .'</td>';		
			// 						}else{
			// 							if($columnArray[$j]['Field'] == "Sr. No"){ //Serial Number
			// 								$x = $i + 1 ; 
			// 								$k_table_body .= '<td>'. $x .'</td>';	
			// 							}else{	
											
			// 								if($columnArray[$j]['Type'] == "date" || $columnArray[$j]['Type'] == "timestamp" || $columnArray[$j]['Type'] == "smalldatetime"){ //if DATE
			// 									// echo gettype($result['result_set'][$i][$columnArray[$j]['Field']]);
			// 									$temp = $result['result_set'][$i][$columnArray[$j]['Field']];
			// 									if($temp != NULL){
			// 										if (gettype($temp) == "string"){
			// 											// $temp = $temp->format('Y-m-d');
			// 											$temp =  date("d-m-Y", strtotime($temp));
			// 										}else{
			// 											$temp = $temp->format('d-m-Y');
			// 										}
			// 									}
			// 									// echo $temp;
			// 									$k_table_body .= '<td>'.$temp.'</td>';			
			// 								}else{
			// 									// echo "<br>".$columnArray[$j]['Field'];
			// 									$k_table_body .= '<td>'.$result['result_set'][$i][$columnArray[$j]['Field']].'</td>';			
			// 								}
			// 							}
			// 						}								
			// 					}
								
			// 				}
			// 			}
			// 		}
				
			// 		$k_table_body .= '</tr>';
			// 	}
			// 	* /
			// }else{
			// 	/*for($i=0;$i<sizeof($viewvals); $i++){

			// 		$k_table_body .= '<tr>';

			// 		for($j=0;$j<sizeof($viewcode); $j++){

			// 			//echo '<br>'.$viewcode[$j][0].'=>'.$viewvals[$i][$viewcode[$j][0]];

			// 			if($viewcode[$j][0] >= 0){	

			// 				$temp = $viewvals[$i][$viewcode[$j][0]];

			// 				//echo $viewcode[$j][0];

			// 				if($code[$viewcode[$j][0]][1] == 2){ //if SELECT

			// 					if($temp == 0) $temp = '-';

			// 					else $temp = $radio[$code[$viewcode[$j][0]][3]][$temp-1];
			// 				}

			// 				if($code[$viewcode[$j][0]][1] == 6){ //if DATE
			// 					if($temp != NULL){		
			// 						if (gettype($temp) == "string"){

			// 							$temp =  date("d-m-Y", strtotime($temp));
					
			// 						}else{
			// 							$temp = $temp->format('d-m-Y');
			// 						}
			// 					}
				
			// 					//if (gettype($temp) == "string"){
									
			// 						//$temp =  date("d-m-Y", strtotime($temp));

			// 					//}else{
							
			// 						//$temp = $temp->format('d-m-Y');
			// 					//}
			// 				}

			// 				if($code[$viewcode[$j][0]][1] == 12){ //if MEDIA

			// 					//$temp =  "<img src=";
			// 				}

			// 				$k_table_body .= '<td>'.$temp.'</td>';			
			// 			}

			// 			if($viewcode[$j][0] == -1){ //Serial Number
			// 				$x = $i + 1 ; 
			// 				$k_table_body .= '<td>'. $x .'</td>';		
			// 			}

			// 			if($viewcode[$j][0] == -2){	//EDIT 	
					
			// 				$x = '<form name="form"  action="'.$_SERVER['PHP_SELF'].'?form='.$FormID.'" method="POST">

			// 						<input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							

			// 						<button class="btn btn-primary bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="edit" ><i class="fa fa-pencil"></i></button>

			// 					</form>' ; 

			// 				$k_table_body .= '<td>'. $x .'</td>';		
			// 			}

			// 			if($viewcode[$j][0] == -9){	//View 	

			// 				$viewlink = "";

			// 				if(isset($viewcodeextra)){

			// 					for($p = 0; $p < sizeof($viewcodeextra); $p++){

			// 						if($viewcodeextra[$p][0] == -3){

			// 							$viewlink = $viewcodeextra[$p][1];
			// 							break;
			// 						}
			// 					}
			// 				}

			// 				$x = '<form action="' . $viewlink . '?view='.$viewvals[$i][sizeof($viewvals[$i])-1].'" method="POST">

			// 						<input type="hidden" name="viewID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />

			// 						<button class="btn btn-primary bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="view" ><i class="fa fa-eye"></i></button>

			// 					</form>' ; 

			// 				$k_table_body .= '<td>'. $x .'</td>';		
			// 			}

			// 			if($viewcode[$j][0] == -3){	//DELETE 	

			// 				$viewlink = "";

			// 				if(isset($viewcodeextra)){

			// 					for($p = 0; $p < sizeof($viewcodeextra); $p++){

			// 						if($viewcodeextra[$p][0] == -3){

			// 							$viewlink = $viewcodeextra[$p][1];

			// 							break;
			// 						}
			// 					}
			// 				}

			// 				$x = '<form  method="POST">
			// 						<input type="hidden" name="delID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />

			// 						<button class="btn btn-danger bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="view" ><i class="fa fa-trash"></i></button>

			// 					</form>' ; 
			// 				$k_table_body .= '<td>'. $x .'</td>';		
			// 			}

			// 			if($viewcode[$j][0] == -4){	//OTHER BTN 	
				
			// 				$x = '<form action="' . $viewSettings[7] . '" method="POST">

			// 						<input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />

			// 						<button class="btn btn-primary bizbtn" style="font-size;10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="" ><i class="fa '.$viewSettings[6].'"></i></button>
			// 					</form>' ; 

			// 				$k_table_body .= '<td>'. $x .'</td>';		
			// 			}
			// 		}

			// 		$k_table_body .= '</tr>';
			// 	}* /

			// }
			
		*/
		include "k_files/k_table.php";
		NoTablePrint:
	} else {	
		$lockRefresh = true;
		if(isset($_REQUEST['preview'])){
			$editID = $_REQUEST['preview'];
			$isPreview = 1;
			$lockRefresh = false;
		}

		if(isset($_REQUEST['display'])){
			$editID = $_REQUEST['display'];
			$isView = 1;
			echo "<style>
				.form-control[disabled]{
					border: 0;
					box-shadow: none;
					border-bottom: 1px solid #ccc;
					border-radius: 0;
				}
				.select2-container--default.select2-container--disabled .select2-selection--single {
					cursor: not-allowed;
					border: 0;
					box-shadow: none;
					border-bottom: 1px solid #ccc;
					border-radius: 0;
				  }
			</style>";
		}

		if(isset($_REQUEST['edit'])){
			$editID = $_REQUEST['edit'];
		}
			
		if($editID > 0){ //EDIT MODE

			/*1742025 This section will check session & db companyid, divisionid, yearcode are same then allow to edit */
			
			if($viewSettings[12] != 1)
			{
				$checkDbData = "SELECT * FROM ".$db[0]." WHERE ".$db[1]." =".$editID;
				$resultDbData = db::getInstance()->db_select($checkDbData, "F-17406: Cl-");
				$caseSensitiveResultDbData = array_change_key_case_recursive($resultDbData);

				// Prepare an array of session-based checks comparing session data with database data
				$checks = [
					'CompanyId' => [$_SESSION['dbCompany'], $caseSensitiveResultDbData['result_set'][0]['companyid']],
					'DivisionId' => [$_SESSION['dbDivision'], $caseSensitiveResultDbData['result_set'][0]['divisionid']],
					'YearCode' => [$_SESSION['dbYear'], $caseSensitiveResultDbData['result_set'][0]['yearcode']],
				];
				// if($FormID == 5380){
				// 	echo $checkDbData;
				// 	print_r($caseSensitiveResultDbData['result_set']);
				// 	print_r($checks);
				// 	exit();
				// }

				// Loop through each check and compare the session value with the corresponding database value
				foreach ($checks as $field => [$expected, $posted]) {
					// If any value does not match, log the error and redirect user back to the form view
					if ($posted != $expected) {
						logDevError($field, $FormID, $_SESSION, "$field mismatch: POST = $expected, Expected = $posted", "Mismatch post & session $field");

						// Set the alert message in the session
						$_SESSION['FormEditValidationMessage'] = "Entry Not Edited. $field mismatch"; // Customize the message

						$fullURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&view=1";

						// Parse the URL components
						$parsedUrl = parse_url($fullURL);

						// Convert query string to an associative array
						parse_str($parsedUrl['query'] ?? '', $queryParams);

						// Remove 'preview' if it exists
						if (isset($queryParams['preview'])) {
							unset($queryParams['preview']);
						}

						// Optional: Add or update 'view=1' if needed
						$queryParams['view'] = 1;

						// Rebuild the query string
						$newQuery = http_build_query($queryParams);

						// Reconstruct the clean URL
						$cleanURL = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
						if (!empty($newQuery)) {
							$cleanURL .= '?' . $newQuery;
						}

						// Redirect user to the referring page, indicating a view mode with the form ID
						echo '<script>window.location="'.$cleanURL.'";</script>';
						exit(); // Stop script execution after redirect
					}
				}
			}

			/* 13042025
			This section will check if the entry is open in edit mode.
			0. Check if its open in Edit mode and not in preview mode
			1. Check if table exist in client db
			2. If not, create table =>> CREATE TABLE [kFormEditLock](
										[ID] [bigint] IDENTITY(1,1),
										[EntryID] [bigint] NULL,
										[FormID] [int] NULL,
										[UserID] [int] NULL,
										[CompanyID] [int] NULL,
										[DivisionID] [int] NULL,
										[YearCode] nvarchar(10) NULL,
										[isDeleted] [bit] NULL,
										[CreatedAt] [datetime] NULL,
										[UpdatedAt] [datetime] NULL
									) ON [PRIMARY]
			3. Check if entry id exists for any other user in the table (isDeleted = 0)
			4. If exists then open the page in Preview mode. $_REQUEST['preview'] = $editID; ALSO SHOW WHICH USER HAD OPENED THE ENTRY 
			5. If not, Insert a new row in the above table with all its params. (isDel = 0 & Created at GETDATE())
			=> This will get removed only in form unload API : isDeleted=1 & UpdatedAT = Getdate()
			=> Check this table for this user when he tries to change the company. Disallow
			=> If user logs out then all the isDeleted for the user should be 1 and updatedAt timestatmp
			*/

			//ENTRY IS OPEN IN EDIT MODE
			if(!isset($_REQUEST['preview'])){
				echo '<script>$(document).ready(function(){
						$(".page-header .breadcrumbs li").html("");
							});</script>';
		
					$checkTableExist = "SELECT * FROM information_schema.columns WHERE table_name='kFormEditLock'";
					$result = db::getInstance()->db_select($checkTableExist, "F-17494: Cl-");

					if ($result['num_rows'] == 0) {
						$query = "CREATE TABLE [kFormEditLock] (
							[ID] [bigint] IDENTITY(1,1) PRIMARY KEY,
							[EntryID] [bigint] NULL,
							[FormID] [int] NULL,
							[UserID] [int] NULL,
							[CompanyID] [int] NULL,
							[DivisionID] [int] NULL,
							[YearCode] nvarchar(10) NULL,
							[isDeleted] [bit] NULL,
							[CreatedAt] [datetime] NULL,
							[UpdatedAt] [datetime] NULL
						) ON [PRIMARY];";
						
						$createResult = db::getInstance()->db_create_table($query, "F-17510: Cl-");
					}

					// Common logic after ensuring table exists
					$sql = "SELECT * FROM kFormEditLock 
							WHERE FormID = $FormID AND EntryID = $editID AND CompanyID = {$_SESSION['dbCompany']} 
							AND DivisionID = {$_SESSION['dbDivision']} AND YearCode = '{$_SESSION['dbYear']}' 
							AND UserID <> {$_SESSION['user_id']} AND isDeleted = 0";
					
					$sqlresult = db::getInstance()->db_select($sql, "F-17519: Cl-");

					if ($sqlresult['num_rows'] > 0) {
						//If user editing this entry then redirect to priview page & show message
						$userQuery = "SELECT * FROM users WHERE ID={$sqlresult['result_set'][0]['UserID']}";
						$userResult = db::getInstanceMaster()->db_select($userQuery, "F-17524");
						
						$fullURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&preview=".$editID;
						echo '<script>
							alert("' . $userResult['result_set'][0]['Username'] . ' is currently editing this entry. You will be able to view in preview mode only.");
							window.location="'.$fullURL.'";</script>';
						exit();
					} else {
						$sql1 = "INSERT INTO kFormEditLock 
							(EntryID, FormID, UserID, CompanyID, DivisionID, YearCode, isDeleted, CreatedAt) 
							VALUES ($editID, $FormID, {$_SESSION['user_id']}, {$_SESSION['dbCompany']}, {$_SESSION['dbDivision']}, '{$_SESSION['dbYear']}', 0, GETDATE())";
						
						$sqlresult1 = db::getInstance()->db_insertQuery($sql1, "F-17536: Cl-");
					}
			}

			if($FormID == 4921){
				if (!empty($_POST)) {
					print_r($_PO☻ST);
					// Loop through all POST parameters
					foreach ($_POST as $key => $value) {
						if (isset($value)) {
							?>
							<script>
								$(document).ready(function(){
									<?php if ($key === 'previousFormID') { ?>
										$('#adjustmentFormId').val('<?php echo $value; ?>');
									<?php } else { ?>
										$('#<?php echo $key; ?>').val('<?php echo $value; ?>');
									<?php } ?>
									// var selector = <?php echo json_encode($key); ?>;
									// var value = <?php echo json_encode($value); ?>;

									// if ($(selector).length > 0) {
										
									// 	console.log("Setting value for: " + selector);
									// 	$(selector).val(value);
									// }
								});
							</script>
							<?php	
						}
					}
				}
			}

			//This section will check on before edite mode validation 
			//update by pornima if condition this code only work when page in edit mode
			if(!isset($_REQUEST['preview'])){
				//To check if edit SP exists in the db 
				$editSPName = "sp_ValidateEdit_$FormID";
				$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$editSPName'";
				$sqlresult = db::getInstance()->db_select($sql, "F-17578: Cl-");
				
				
				$editFlag = 1;

				if($sqlresult['result_set'][0]['found'] == 1){
					
					$PreviewStatus = 0;
					if(isset($_REQUEST['edit'])){
						$PreviewStatus = 1;
					}
					//CALL Edit SP to check validations before editing the entry
					$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND Preview='.$PreviewStatus.'';

					$sp['params'] = ['@EDITID','@TABLENAME','@USERID','@SESSION'];
					$sp['values'] = ["'$editID'","'".$db[0]."'","'".$_SESSION['user_id']."'","'$session'"];
			
					$result = db::getInstance()->db_sp_select($editSPName, $sp['params'], $sp['values'], "F-17590: Cl-");

					
					// print_r($result);
					$result = array_change_key_case_recursive($result);

					

					if($result['error'] == 1){
						$ErrorMsg = $result['error_statement'];
					}else{
	
						// print_r($result['result_set'][0][0]['Success']);
						$row = $result['result_set'][0][0];

						
						if($row['success'] == 1){
							
							if($row['noneditable']){
								$nonEditableFieldArray = explode(",",$row['noneditable']);
								$nonEditableFieldString = '';
								// print_r($nonEditableFieldArray);
								for($i=0; $i<sizeof($nonEditableFieldArray); $i++){
									$sql1 = "SELECT FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".trim($nonEditableFieldArray[$i])."'";
									
									$sql1result = db::getInstanceMaster()->db_select($sql1, "F-17611");
									if($sql1result['num_rows'] > 0){
										$nonEditableFieldString .= trim($nonEditableFieldArray[$i]).":".trim($sql1result['result_set'][0]['FieldType']);
										if($i != sizeof($nonEditableFieldArray)-1){
											$nonEditableFieldString .= " | ";
										}
									}
								}
								
								$nEditableFields = explode("|",$nonEditableFieldString);
								for($i=0; $i<sizeof($nEditableFields); $i++){
									// echo $nonEditableFieldArray[$i];
									$fieldWithType = explode(":",$nEditableFields[$i]);
									if($fieldWithType[1] == 1 || $fieldWithType[1] == 6 || $fieldWithType[1] == 7 || $fieldWithType[1] == 8 || $fieldWithType[1] == 3 || $fieldWithType[1] == 18){
										echo "<script>$(document).ready(function() { $('#".trim($fieldWithType[0])."').prop('readonly', true).css('background','#eee'); });</script>";	
									}else if($fieldWithType[1] == 5 || $fieldWithType[1] == 19){
										echo "<script>$(window).on('load', function() {
												$('#".trim($fieldWithType[0])."').select2({
													// your Select2 config
												}).on('select2:opening', function (e) {
													e.preventDefault(); // prevents dropdown from opening
												}).prop('readonly', true) // this won't have much effect on select
												.css('pointer-events', 'none');

												setTimeout(
													function() {
														$('#".trim($fieldWithType[0])."').next('span').find('.select2-selection--single').css('background-color','#eee')
													},
												300);

												// $('#".trim($fieldWithType[0])."').select2({
												// 	disabled: true
												// });
												// console.log($('#".trim($fieldWithType[0])."').next('span').find('.select2-selection--single').css('background-color','#eee'));
												// $('#".trim($fieldWithType[0])."').next('span').find('.select2-selection--single').css('background-color','#eee'); 
												// select2Elem.prop('readonly', true).css('pointer-events', 'none').css('background-color', '#eee');
											});
										</script>";
									}else if($fieldWithType[1] == 12 || $fieldWithType[1] == 13){
										echo "<script>$(document).ready(function() { 
												if($('#".trim($fieldWithType[0])."').prop('multiple') == true){
													$('#".trim($fieldWithType[0])."').css('pointer-events','none');
													// console.log($('#'+NonEditableFields[i]).parent());
													$('#".trim($fieldWithType[0])."').nextAll().find('span').remove()
												}
											});</script>";	
									}else if($fieldWithType[1] == 16 || $fieldWithType[1] == 17){
										echo "<script>$(document).ready(function() { $('#".trim($fieldWithType[0])."-text').prop('readonly', true).css('background','#eee').css('pointer-events','none').css('text-align','left'); });</script>";	
									}
								}
							}
							// print_r($result['result_set'][1]);
							if($result['result_set'][1]){
								?>
								<script>
									$(document).ready(function() {
										var tempData = <?php echo json_encode($result['result_set'][1]); ?>;

										// Empty the target element based on the key
										$("#" + Object.keys(tempData[0])[0]).empty();  // This will empty the element with ID 'Form_40473'

										// Loop through the array and append the content
										for (var i = 0; i < tempData.length; i++) {
											var key = Object.keys(tempData[i])[0];  // Extract the key (e.g., "Form_40473")
											var value = Object.values(tempData[i])[0];  // Get the corresponding value (HTML string)
											// Append the HTML content to the element with the ID that matches the key
											console.log(key);
											console.log(value);
											$("#" + key).append(value);  // Append the HTML content
										}
									});
								</script>
								<?php
							}
						}else if($row['success'] == 0){
							
							// if($FormID == 5189){
							// 	print_r($row);
							// 	exit();
							// }
							//If Success 0 then don't allow to edit & redirect to listview page
							$fullURL = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&view=1";
							
							// Set the alert message in the session
							$_SESSION['FormEditValidationMessage'] = $row['msg']; // Customize the message
			
							echo '<script>
								window.location.href ="'.$fullURL.'";
							</script>';
						}
					}
				}
			}

			if(isset($_REQUEST['preview'])){
				
				$editSPName = "sp_ValidatePreview_$FormID";
				
				$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$editSPName'";
				
				$sqlresult = db::getInstance()->db_select($sql, "F-17711: Cl-");

				if($sqlresult['result_set'][0]['found'] == 1){	//if preview SP found
					//CALL preview SP to check validations before editing the entry
					$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.'';

					$sp['params'] = ['@EDITID','@TABLENAME','@USERID','@SESSION'];
					$sp['values'] = ["'$editID'","'".$db[0]."'","'".$_SESSION['user_id']."'","'$session'"];
			
					$result = db::getInstance()->db_sp_select($editSPName, $sp['params'], $sp['values'], "F-17720: Cl-");
	
					$result = array_change_key_case_recursive($result);

					// if($FormID == 5189){
					// 	print_r($result);
					// }

					if($result['error'] == 1){
						$ErrorMsg = $result['error_statement'];
					}else{
						// print_r($result['result_set'][0][0]['Success']);
						$row = $result['result_set'][0][0];
						
						if($row['success'] == 1){

							if($result['result_set'][1]){
								?>
								<script>
									$(document).ready(function() {
										var tempData = <?php echo json_encode($result['result_set'][1]); ?>;

										// Empty the target element based on the key
										$("#" + Object.keys(tempData[0])[0]).empty();  // This will empty the element with ID 'Form_40473'

										// Loop through the array and append the content
										for (var i = 0; i < tempData.length; i++) {
											var key = Object.keys(tempData[i])[0];  // Extract the key (e.g., "Form_40473")
											var value = Object.values(tempData[i])[0];  // Get the corresponding value (HTML string)
											// Append the HTML content to the element with the ID that matches the key
											$("#" + key).append(value);  // Append the HTML content
										}
									});
								</script>
								<?php
							}
						}
					}
				}
			}

			$sql = "SELECT * FROM ".$db[0]." WHERE ".$db[1]." =".$editID;
			$result = db::getInstance()->db_select($sql, "F-17762: Cl-");
			
			if($k_debug)	echo '<br /><br />'.$sql . '<br /><br />';
			if($k_debug)	echo '<br /><br />' . print_r($result) . '<br /><br />';
			for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row
				
				for($j = 0; $j < sizeof($code); $j++){
					
					if($code[$j][1] == 10){  //FOR MAPPING TABLE Multi-Select
						$temp = array();
						//SELECT * FROM map_vendor_categories LEFT JOIN categories ON map_vendor_categories.cat_id = categories.cat_id WHERE vendor_id = 1
						
						$mapArray  = $extradb[((-1)*$code[$j][3])-1][5];
						
						$joinTable = $extradb[((-1)*$code[$j][3])-1][1];
						
						$joinIndex = $extradb[((-1)*$code[$j][3])-1][2];
						
						$mapTable = $mapArray[0];
						
						$mapIndex = $mapArray[1];
						
						$mapVariant = $mapArray[2];
						
						$sql = 'SELECT * FROM ' . $mapTable  . ' WHERE ' . $mapIndex . ' = ' . $editID ;///. ' LEFT JOIN ' . $joinTable . ' ON ' . $mapTable.'.'.$mapVariant . ' = ' . $joinTable.'.'.$joinIndex . ' WHERE ' . $mapIndex . ' = ' . $editID ;
						
						$rs = db::getInstance()->db_select($sql, "F-17788: Cl-");
						if($k_debug)	echo '<br /><br />' . $sql . '<br />' . print_r($rs) . '<br /><br />';
						//	print_r($rs['result_set']);
						
						$code[$j][4] = $rs['result_set'];
					}else{
						if($code[$j][1] == 11 || $code[$j][1] == 9){  //FOR MAPPING TABLE Multi-Select

							$temp = array();

							$mapArray  = $extradb[((-1)*$code[$j][3])-1];

							$joinTable = $extradb[((-1)*$code[$j][3])-1][1];

							$joinIndex = $extradb[((-1)*$code[$j][3])-1][2];

							$mapTable = $mapArray[6];

							$mapIndex = $mapArray[7];

							$mapVariant = $mapArray[8];

							$sql = 'SELECT * FROM ' . $mapTable  . ' WHERE ' . $mapIndex . ' = ' . $editID ;

							///. ' LEFT JOIN ' . $joinTable . ' ON ' . $mapTable.'.'.$mapVariant . ' = ' . $joinTable.'.'.$joinIndex . ' WHERE ' . $mapIndex . ' = ' . $editID ;

							$rs = db::getInstance()->db_select($sql, "F-17814: Cl-");
							if($k_debug)	echo '<br /><br />' . $sql . '<br />' . print_r($rs) . '<br /><br />';
							$code[$j][4] = $rs['result_set'];

						}else{
							if($code[$j][1] == 13){  //FOR MAPPING TABLE Multi-Select

							    //echo "<br />" . $code[$j][1];
							    //print_r($code[$j]);
								//echo "<br />";
								//print_r($extradb[((-1)*$code[$j][3])-1]);
          
					        	$temp = array();

								$mapArray  = $extradb[((-1)*$code[$j][3])-1];

								$joinTable = "kmainmedia";

								$joinIndex = "MediaId";

								$mapTable = $mapArray[6];

								$mapIndex = $mapArray[7];

								$mapVariant = $mapArray[8];

								$sql = 'SELECT kmainmedia.MediaId, kmainmedia.MediaName, kmainmedia.MediaType, kmainmedia.MediaFolder FROM ' . $mapTable . ' LEFT JOIN ' . $joinTable . ' ON ' . $mapTable.'.' .$mapVariant . ' = ' . $joinTable . '.' . $joinIndex . ' WHERE ' . $mapIndex . ' = ' . $editID ;

								$rs = db::getInstance()->db_select($sql, "F-17842: Cl-");
								if($k_debug)	echo '<br /><br />' . $sql . '<br />' . print_r($rs) . '<br /><br />';
								//print_r($rs['result_set']);

								?>
								<style>
									.button-container {
									position: relative;
									display: inline-block;
									}

									.button-link {
									padding: 3px 10px;
									background-color: #007bff;
									color: white;
									text-decoration: none;
									border-radius: 4px;
									font-family: sans-serif;
									display: inline-block;
									position: relative;
									margin-right:6px;
									}

									.close-button {
									position: absolute;
									top: -6px;
									right: -6px;
									background-color: #d8d8d8;
									color: white;
									width: 20px;
									height: 20px;
									text-align: center;
									line-height: 20px;
									border-radius: 50%;
									cursor: pointer;
									font-size: 12px;
									}
								</style>

								<?php

								$images = "";

								for($z = 0; $z < sizeof($rs['result_set']); $z++){
									
									if(strlen($rs['result_set'][$z]['MediaName']) > 4){
										if(str_contains($rs['result_set'][$z]['MediaName'], ".png") || str_contains($rs['result_set'][$z]['MediaName'], ".jpeg")
											|| str_contains($rs['result_set'][$z]['MediaName'], ".jpg")){
											$images .= "
												<div id='".$code[$j][0]."".$rs['result_set'][$z]['MediaId']."' style='display: inline'>
													<a id='downloadImg' href='".SITE_ROOT.$rs['result_set'][$z]['MediaFolder']."/".$rs['result_set'][$z]['MediaName']."' target='_blank'><img src='".SITE_ROOT.$rs['result_set'][$z]['MediaFolder']."/".$rs['result_set'][$z]['MediaName']."' width='100' height='auto' style='/max-height:100px;/ margin-right:10px;border: 1px solid #d7d7d7a6;margin-top: 7px;'/></a>
													<span onclick='deleteImage(13,\"".$code[$j][0]."\",".$rs['result_set'][$z]['MediaId'].");' style='background: #d8d8d8;position: absolute;margin-left: -23px;margin-top: -3px;color: white;width: 21px;text-align: center;border-radius: 21px;cursor: pointer;'>X</span>
												</div>";
										}else{
											
											// $images .= "
											// 	<div id='".$code[$j][0]."".$rs['result_set'][$z]['MediaId']."' style='display: inline'>
											// 		<a href='".SITE_ROOT.$rs['result_set'][$z]['MediaFolder']."/".$rs['result_set'][$z]['MediaName']."' target='_blank'>VIEW</a>
											// 		<span onclick='deleteImage(13,\"".$code[$j][0]."\",".$rs['result_set'][$z]['MediaId'].");' style='background: #d8d8d8;position: absolute;margin-left: 0px;margin-top: -8px;color: white;width: 21px;text-align: center;border-radius: 21px;cursor: pointer;'>X</span>
											// 	</div>";

											$images .= "
											<div id='".$code[$j][0]."".$rs['result_set'][$z]['MediaId']."' class='button-container'>
												<a id='downloadImg' href='".SITE_ROOT.$rs['result_set'][$z]['MediaFolder']."/".$rs['result_set'][$z]['MediaName']."' target='_blank' class='button-link'>VIEW</a>
												<span class='close-button' onclick='deleteImage(13,\"".$code[$j][0]."\",".$rs['result_set'][$z]['MediaId'].");'>X</span>
											</div>";
										}
									}
								}
								// if($z > 0){
								    // $code[$j][4] = "<div class='' id='".$arr[0]."Img'>" . $images . "</div>";
								// }else{
								    $code[$j][4] = "$images";
								// }					

							}else{
								if($code[$j][1] == 12){

									//echo "<br />" . $code[$j][1];
									//print_r($code[$j]);
									//echo "<br />";
									//print_r($extradb[((-1)*$code[$j][3])-1]);
					                $temp = array();
									$mapArray  = $extradb[((-1)*$code[$j][3])-1];
									$joinTable = $extradb[((-1)*$code[$j][3])-1][1];
									$joinIndex = $extradb[((-1)*$code[$j][3])-1][2];
									$sql = 'SELECT kmainmedia.MediaId, kmainmedia.MediaName, kmainmedia.MediaType, kmainmedia.MediaFolder FROM kmainmedia 

									LEFT JOIN ' . $db[0] . ' ON ' . $db[0] . '.' . $code[$j][0].' = kmainmedia.MediaID'.' WHERE ' . $db[0] . '.' . $db[1] . ' = ' . $editID ;

									$rs = db::getInstance()->db_select($sql, "F-17932: Cl-");

									$images = ""; //print_r($rs);

									for($z = 0; $z < sizeof($rs['result_set']); $z++){
										if(strlen($rs['result_set'][$z]['MediaName']) > 4){
											if(str_contains($rs['result_set'][$z]['MediaName'], ".png") || str_contains($rs['result_set'][$z]['MediaName'], ".jpeg")
												|| str_contains($rs['result_set'][$z]['MediaName'], ".jpg")){
											
												$images .= "
													<div id='".$code[$j][0]."".$rs['result_set'][$z]['MediaId']."' style='display: inline'>
														<a href='".SITE_ROOT.$rs['result_set'][$z]['MediaFolder']."/".$rs['result_set'][$z]['MediaName']."' target='_blank'><img src='".SITE_ROOT.$rs['result_set'][$z]['MediaFolder']."/".$rs['result_set'][$z]['MediaName']."' width='100' height='auto' style='/max-height:100px;/ margin-right:10px;border: 1px solid #d7d7d7a6;margin-top: 7px;'/></a>
														<span onclick='deleteImage(12,\"".$code[$j][0]."\",".$rs['result_set'][$z]['MediaId'].");' style='background: #d8d8d8;position: absolute;margin-left: -5px;margin-top: -3px;color: white;width: 21px;text-align: center;border-radius: 21px;cursor: pointer;'>X</span>
													</div>";
											}else{
										
												$images .= "
													<div id='".$code[$j][0]."".$rs['result_set'][$z]['MediaId']."' style='display: inline'>
														<a href='".SITE_ROOT.$rs['result_set'][$z]['MediaFolder']."/".$rs['result_set'][$z]['MediaName']."' target='_blank'>VIEW</a>
														<span onclick='deleteImage(12,\"".$code[$j][0]."\",".$rs['result_set'][$z]['MediaId'].");' style='background: #d8d8d8;position: absolute;margin-left: 0px;margin-top: -8px;color: white;width: 21px;text-align: center;border-radius: 21px;cursor: pointer;'>X</span>
													</div>";
											}
										}
									}
									$code[$j][4] = $images;
								}else{
									if($code[$j][1] == 14){
										//Ignore GRIDS
									}else{
										if($code[$j][1] == 16){  //FOR MAPPING TABLE Multi-Select
											
											$temp = array();				
											$mapArray  = $extradb[((-1)*$code[$j][3])-1];
											$joinTable = $extradb[((-1)*$code[$j][3])-1][1];
											$joinIndex = $extradb[((-1)*$code[$j][3])-1][2];				
											$mapTable = $mapArray[6];				
											$mapIndex = $mapArray[7];				
											$mapVariant = $mapArray[8];
											// $sql = 'SELECT * FROM ' . $mapTable ;
											$sql = 'SELECT '.$mapTable.'.'.$mapVariant.' , '.$joinTable.'.'.$mapArray[3].' FROM ' . $mapTable;
											$sql .= ' LEFT JOIN ' . $joinTable . ' ON ' . $mapTable.'.'.$mapVariant . ' = ' . $joinTable.'.'.$joinIndex . ' WHERE ' . $mapTable .'.'. $mapIndex . ' = ' . $editID ;
											
											$rs = db::getInstance()->db_select($sql, "F-16658: Cl-");
											// if($_SESSION['user_id'] == 1020){
											// 	print_r($mapArray[3]);
											// 	echo 'SELECT '.$mapTable.'.'.$mapVariant.' , '.$joinTable.'.'.$mapArray[3].' LEFT JOIN ' . $joinTable . ' ON ' . $mapTable.'.'.$mapVariant . ' = ' . $joinTable.'.'.$joinIndex . ' WHERE ' . $mapTable .'.'. $mapIndex . ' = ' . $editID;
											// 	echo "<pre>";
											// 	print_r($rs);
											// 	echo "</pre>";
											// }				
											if($k_debug)	echo '<br /><br />' . $sql . '<br />' . print_r($rs) . '<br /><br />';
											$code[$j][4] = $rs['result_set'];
											
										}else{
											//  echo $code[$j][1] . "<br />";
											// print_r($result['result_set'][$i]['Username']);
											// echo $result['result_set'][$i]['CarryOn'];
											
											//tmp array to convert the array to case insesitive:
											$result_case_insensitive = $result['result_set'][$i];

											$result_case_insensitive = array_change_key_case($result_case_insensitive);

											// if($FormID == 4568 && $code[$j][1] == 1) echo "<br /><br />".print_r($result_case_insensitive);
											
											// print_r($result_case_insensitive);
											// if($FormID == 4568 && $code[$j][1] == 1) echo "<br /><br />".$code[$j][0];
											// if($FormID == 4568 && $code[$j][1] == 1) echo "<br /><br />".print_r($result_case_insensitive);
											$code[$j][4] = $result_case_insensitive[strtolower($code[$j][0])];
											// $code[$j][4] = $result['result_set'][$i][$code[$j][0]];
										}
									}
								}
							}
						}
					}
				}
			} 
			$buttonname = "UPDATE";
			if(isset($isPreview) == 1){
				$k_table_title = "Preview";
				$k_table_log_button = '<button class="btn btn-warning btn-xs" onclick="openLogModal()">Logs</button>';
				$k_table_sqlsp_button = '<button class="btn btn-info btn-xs" onclick="openSQLModal(\'full\')">SQL</button>';
				$k_table_requirement_button = '<button class="btn btn-success btn-xs" onclick="openRequirementModal()">Requirement</button>';
			}else{
				$k_table_title = "Edit";
				$k_table_log_button = '<button class="btn btn-warning btn-xs" onclick="openLogModal()">Logs</button>';
			}

			if(isset($isView) == 1){
				$k_table_title = "View";
			}
			$buttonsaveaddmore = "UpdateAddMore";
			
			echo '<script>
				$(window).ready(function() { 
					$("form.form-bordered").on("keypress", function (event) { 
						//console.log("aaya"); 
						var keyPressed = event.keyCode || event.which; 
						if (keyPressed === 13) { 
							//alert("You pressed the Enter key!!"); 
							event.preventDefault(); 
							return false; 
						} 
					}); 
				}); </script>
			';
			
			//	print_r($result);
			//SCRIPT FOR DELETING IMAGE
			?>
			<script>
			    // function deleteImage(fieldType, fieldName, mediaID){
				// 	alert('delete image');
			    //     var fid = $("#FormID").val();

			    //     $.ajax({

                //         url: "form-api.php", 
                //         type: 'POST',
                //         data: {apicase:'1', fid: fid, fieldType:fieldType, fieldName:fieldName, mediaID:mediaID},
                //         dataType: 'json',
                //         success: function(result){
                //             console.log(result);
                //             if(result.error){

                //                 alert(result.error_msg);
                //                 //console.log(result.error_msg);
                //             }else{

				// 				alert(result.data);

                //                 if(mediaID === undefined){

                //                     $('#' + fieldName).html("Image deleted.");

                //                     setTimeout(
                //                         function() {
                //                             $('#' + fieldName).html("");
                //                         },
                //                         2000);
                //                 }else{
                //                     $('#' + fieldName + mediaID).html("Image deleted.");
                //                     setTimeout(

				// 						function() {

                //                             $('#' + fieldName + mediaID).html("");
                //                         },
                //                         2000);
                //                 }
                //             }
                //         },
				// 		error: function(jqXHR, textStatus, errorThrown) {
				// 			console.log("Error 261: ", textStatus);
				// 			// console.log("Got ERROR Data frm API", jqXHR);
				// 			// callback(new Error(textStatus || errorThrown));
				// 		}
                //     });
			    // }

				function deleteImage(fieldType, fieldName, mediaID){
					alert('delete image');
			        var fid = $("#FormID").val();

			        $.ajax({

                        url: "deleteImage.php", 
                        type: 'POST',
                        data: { fid: fid, fieldType:fieldType, fieldName:fieldName, mediaID:mediaID},
                        dataType: 'json',
                        success: function(result){
                            console.log(result);
                            if(result.error){

                                alert(result.error_msg);
                                //console.log(result.error_msg);
                            }else{

								alert(result.data);
								console.log("mediaID",mediaID);
                                if(mediaID === undefined){
									console.log("if");
                                    $('#' + fieldName).html("Image deleted.");

                                    setTimeout(
                                        function() {
                                            $('#' + fieldName).html("");
                                        },
                                        2000);
                                }else{
									console.log("else");
                                    $('#' + fieldName + mediaID).html("Image deleted.");
                                    setTimeout(

										function() {

                                            $('#' + fieldName + mediaID).html("");
                                        },
                                        2000);
                                }
                            }
                        },
						error: function(jqXHR, textStatus, errorThrown) {
							console.log("Error 261: ", textStatus);
							// console.log("Got ERROR Data frm API", jqXHR);
							// callback(new Error(textStatus || errorThrown));
						}
                    });
			    }
			</script>

			<?php
			
		} else { 	//ADD MODE
			if($k_debug){ echo "<br /><br />MITESH DEBUG->-><pre>"; print_r($moreextradb);echo "</pre>";}
			//Sp call for delete temporary table data
			$SPName = 'sp_ValidateAdd_'.$FormID;
			$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
			$sqlresult = db::getInstance()->db_select($sql, "F-18160: Cl-");
			
			if($sqlresult['result_set'][0]['found'] == 1){
				$PreviewStatus = 0;
				if(isset($_REQUEST['OpenMode'])){
					$PreviewStatus = 1;
				}
				$session ='YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND Preview='.$PreviewStatus.'';
				
				
				
				$data['params'] = ['@USERID','@TABLENAME','@FORMID','@session'];
				$sp['values'] = [$_SESSION['user_id'],$db[0],$FormID,"'$session'"];
				$result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values'], "F-18167: Cl-");
				// if($_SESSION['user_id'] == 1020){
				// 	print_r($result);
				// }
				// print_r($result);
				// exit();
			}

			//Carry on logic
			$url = explode("&",$_SERVER['REQUEST_URI']);
			$carryOn = [];
			if(sizeof($url) > 1){
				array_shift($url);
				for($i=0; $i<sizeof($url); $i++){
					$urlArray = explode("=",$url[$i]);
					$ParamField = $urlArray[0];
					$ParamValue = $urlArray[1];
					
					// ${$ParamField} = isset($_REQUEST[$ParamField]) ? $_REQUEST[$ParamField] : "";
					
					if(isset($_REQUEST[$ParamField])){
						$carryOn += array('FormId'=>$FormID,$ParamField=>$_REQUEST[$ParamField]);
						$_SESSION['carryOn'] = $carryOn;
					}
				}
			}

			$k_table_title = "Add New";

			$buttonname = "SAVE";
			$buttonsaveaddmore = "SaveAddMore";
			

			echo '<script>
				$(window).ready(function() { 
					$("form.form-bordered").on("keypress", function (event) { 
						//console.log("aaya"); 
						var keyPressed = event.keyCode || event.which; 
						if (keyPressed === 13) { 
							//alert("You pressed the Enter key!!"); 
							event.preventDefault(); 
							return false; 
						} 
					}); 
				}); </script>
			';

			if($FormID == 4921){
				if (!empty($_POST)) {
					// Loop through all POST parameters
					foreach ($_POST as $key => $value) {
						if (isset($value)) {
							?>
							<script>
								$(document).ready(function(){
									<?php if ($key === 'previousFormID') { ?>
										$('#adjustmentFormId').val('<?php echo $value; ?>');
									<?php } else { ?>
										$('#<?php echo $key; ?>').val('<?php echo $value; ?>');
									<?php } ?>
								});
							</script>
							<?php	
						}
					}
				}
			}
		}

		// if(isset($ReportID))
		if($ReportID == 0) {
		?>
		<script>
		$(document).ready(function () {
			// console.log("viewpage <?php echo $viewpage;?>");
			// console.log("formid <?php echo $FormID;?>");
			// console.log("ReportID <?php echo $ReportID;?>");
			// console.log("editID <?php echo $editID;?>");
			// 🔒 Block F5 and Ctrl+R
			$(document).on('keydown', function (e) {
				if (e.which === 116 || (e.ctrlKey && e.which === 82)) {
					e.preventDefault();
					alert('Page refresh is disabled!');
				}
			});
		});
		</script>
		<?php } ?>
        <style type="text/css">
			
			.toggle-content{
                border: 1px solid #d0d0d0;
                overflow: hidden;
                margin-bottom: 10px;
                padding: 10px;
                background: #f5f5f58c;
            }
			
            .toggle label{
                color: inherit !important;
                /*display: inline-block;*/
                max-width: 100%;
                margin-bottom: 5px;
            }
            .cke_textarea_inline{

               border: 1px solid black;
            }

            input[type="file"] {
                display: none;
            }

            .custom-file-upload {

                border: 1px solid #ccc;
                display: inline-block;
                padding: 6px 12px;
                cursor: pointer;
                width: 100%;
                margin-top: 27px;
            }

			
			td.select-checkbox.checkbox_align {
				padding-left: 15px !important;
				text-align: left;
			}
			table.dataTable > tbody > tr > td.select-checkbox:before{
				left: 0;
			}
			table.dataTable tbody th, table.dataTable tbody td {
				vertical-align: middle;
			}
        </style>
    
		<script src='assets/ckeditor/ckeditor.js'></script>

		<section class="panel forminit">

			<header class="panel-heading"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<div style="display: flex; justify-content: space-between;">
					<!-- Left Section: Title -->
					<h2 class="panel-title" style="margin: 0;"><?php echo isset($k_table_title) ? $k_table_title : ""; ?></h2>

					<!-- Right Section: Buttons -->
					<?php if (isset($_REQUEST['preview'])) { ?>

						<div style="display: flex; gap: 8px;">
							<button class="btn btn-warning btn-xs" id="prev-btn" data-direction="-1">Previous</button>
							<button class="btn btn-warning btn-xs" id="next-btn" data-direction="1">Next</button>
						</div>

						<script>
							$(document).ready(function () {
								const formID = parseInt('<?php echo $FormID; ?>');
								let currentID = parseInt('<?php echo isset($_REQUEST['preview']) ? $_REQUEST['preview'] : 0; ?>');

								$('#prev-btn, #next-btn').on('click', function () {
									const direction = parseInt($(this).attr('data-direction'));
									loadPreviewRecord(direction);
								});

								function loadPreviewRecord(direction) {
									$.ajax({
										type: 'POST',
										url: 'getPrevNextRecord.php',
										dataType: 'json',
										data: {
											currentID: currentID,
											formID: formID,
											direction: direction
										},
										beforeSend: function() {
											$('#prev-btn, #next-btn').prop('disabled', true).text('Loading...');
										},
										success: function (response) {
											if (response.status === 'success' && response.nextID) {
												// Update URL and reload page in preview mode
												window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?form=" + formID + "&preview=" + response.nextID;
											} else {
												alert('No more records in this direction.');
											}
										},
										error: function (xhr, status, error) {
											console.error('Error:', error);
											alert('Error fetching record.');
										},
										complete: function() {
											$('#prev-btn').text('Previous').prop('disabled', false);
											$('#next-btn').text('Next').prop('disabled', false);
										}
									});
								}
							});
						</script>
						
					<?php } ?>

					
					<!-- Right Section: Logs & SQL -->
					<div style="display: flex; gap: 8px;">
					<?php 
						if(isset($k_table_log_button)){
							// Button to trigger modal for log
							echo $k_table_log_button;
						} 
						if(isset($k_table_sqlsp_button)){
							if($_SESSION['Category'] == 2){
								// Button to trigger modal for sql stored procedure
								echo $k_table_sqlsp_button;
							}
						} 
						if(isset($k_table_sqlsp_button)){
							// Button to trigger open requirement modal
							echo $k_table_requirement_button;
							
						} 
						
					?>
					</div>
					
				</div>

				<p class="panel-subtitle"><?php echo isset($k_table_subtitle) ? $k_table_subtitle : ""; ?></p>
			</header>

				<div class="panel-body">

					<form autocomplete="off" name="form" id="form" class="form-bordered"  method="post" action="db.php" enctype="multipart/form-data"> <?php
					//onsubmit="validateFormOnSave(event);"
					echo '<input type="hidden" name="FormID" id="FormID" value='.$FormID.' />';
					
	}

?>
<!-- https://github.com/linways/table-to-excel -->
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
<!-- USED FOR EXPORTING SP DATA TO EXCEL WITH PROTECTION -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<div class="modal fade" id="ImportExcelModal">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal">×</button>  -->
				<h4 class="modal-title">Imported Data</h4>                                                         
				<h6 class="modal-subtitle">Please check the result columns for error and re-upload the excel.</h6>
			</div> 
			<div class="modal-body" >
				<!-- <form id="modalForm" name="modal" role="form"> -->
					<div id="ModelContent" >

					</div>
					<div class="modal-footer" style="margin-top:10px;">					
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<!-- <button type="button" class="btn btn-success" id="submit">Submit</button> -->
					</div>
				<!-- </form> -->
			</div>   
		</div>                                                                       
	</div>                                          
</div>
<script>
	// function ImportAddResultInGrid(ddRowSelectType,selectedItemId,DBFieldType,DBFieldName,isGrid,requestParams,formReeponseString){
	function ImportGridExcelValidateSP(gridData, GridID, EditID){
		console.log("gridData",gridData);
		var excelData = gridData;
		var allreadyValidate = false;
		$.ajax({
			type : 'POST',
			dataType: 'json',
			data : {gridData : gridData, GridID : GridID, FormID: <?php echo $FormID; ?>, EditID: EditID},
			url : 'getGridExcelValidateData.php',
			success : function(result){
				console.log("result from Validate Import");
				console.log(result);
				var gridIdentifier = $('#grid-id-'+GridID).attr('class');
				var gridSerialNo = gridIdentifier.slice(4);

				if(result['output'] == null || result['output'] == undefined){
					alert("Error in Import: Output not in correct Format. Please contact developer.");
				}
				var Output = result['output'][0];
				var GridData = result['gridData'];	//validated data to be entered in the grid
				var GridFieldData = result['data'];	//datastructure

				if(Output['Success'] == 1){
					if(GridData.length > 0){
						$('#cnt'+gridSerialNo).val(0);
						$('.tmp_GridTable'+gridSerialNo+' tbody tr').not(':first').remove();
						// console.log("excelData", excelData);
						
						for(var l=0; l<GridData.length; l++){
							// var tmp = `<tr><td>${l + 1}</td>`;
							// var head = `<tr><th>SrNo</th>`;			
							for(var k=0; k<GridFieldData.length; k++){
								// tmp += `<td>${GridData[l][GridFieldData[k]['DbFieldName']]}</td>`;
								// head += `<th>${GridFieldData[k]['DisplayName']}</th>`;
								var gFieldTyp = GridFieldData[k]['FieldType'];
								var gGridData = GridData[l][GridFieldData[k]['DbFieldName']];
								var gDispName = GridFieldData[k]['DisplayName'].trim();
								console.log("Finding in excel -",l,gDispName.replace(/^\n|\n$/g, ''))
								var gDispData = excelData[l][gDispName.replace(/^\n|\n$/g, '')];
								var gFieldNam = GridFieldData[k]['DbFieldName'];

								console.log(gFieldTyp + " ==>> " + gGridData + " <<==>> " + gFieldNam + " -> " + gDispData + ' => #kreon-grid-' + gridSerialNo + gFieldNam);
								if(gFieldTyp == '1' || gFieldTyp == '3' || gFieldTyp == '7' || gFieldTyp == '8'){
									$('#kreon-grid-'+gridSerialNo+''+ gFieldNam).val(gGridData);
								}else if(gFieldTyp == '5' || gFieldTyp == '19'){
									// var newOption = new Option(gDispData, gGridData, false, false); 
									// $('#kreon-grid-'+gridSerialNo+'' + gFieldNam).append(newOption) //.trigger('change');
									// $('#kreon-grid-'+gridSerialNo+'' + gFieldNam).append('<option selected="selected" value="'+gGridData+'">'+gDispData+'</option>').trigger('change');
									// alert(gGridData)
									// $('#kreon-grid-'+gridSerialNo+'' + gFieldNam).val(gGridData).trigger('change'); 

									// var newOption = new Option(gDispData, gGridData, true, true); 
									// $('#mySelect').append(newOption).trigger('change');
									// console.log( "gGridData, GridData,l,GridFieldData[k]['DbFieldName']");
									// console.log( gGridData, GridData,l,GridFieldData[k]['DbFieldName']);
									// console.log("gDispData,excelData,l,gDispName.replace(/^\n|\n$/g, '')");
									// console.log(gDispData,excelData,l,gDispName.replace(/^\n|\n$/g, ''));
									var $newOption = $("<option selected=\"selected\"></option>").val(gGridData).text(gDispData)
									$('#kreon-grid-'+gridSerialNo+'' + gFieldNam).append($newOption).trigger("change");
								}else if(gFieldTyp == '17'){
									// console.log("testing fld17",GridData,l, GridFieldData[k]['DbFieldName'], gGridData, '#kreon-grid-'+gridSerialNo+gFieldNam)
									$('#kreon-grid-'+gridSerialNo+gFieldNam+'-text').val(gGridData);
									$('#kreon-grid-'+gridSerialNo+gFieldNam).val(gGridData);
								}else if(gFieldTyp == '6'){
									// console.log(gGridData);
									var dateObj = gGridData;
									var date = new Date(dateObj);
									var inputDateValue = date.toISOString().split('T')[0]; // will still be "2025-04-15"
									$('#kreon-grid-'+gridSerialNo+gFieldNam).val(inputDateValue);
								}
							}
							//Add row
							ImportAddNewRow($(this),result['data'],gridSerialNo,0,allreadyValidate=true);	
							// break;	
						}
						alert("Import successful");
					}
					
				}else{
					if(+Output['Success'] == 3){
						alert("Data saved succesfully.")
					}else{
						alert("Error in input data: " + Output['Msg']);

						$("#ImportExcelModal").modal({backdrop: 'static', keyboard: false},'show');
						$("#ImportExcelModal #ModelContent").append('<table class="table table-striped table-bordered table-hover table-condensed" id="ImportExcelTable"><thead></thead><tbody></tbody></table>');

						var GridData = result['gridData'];
						var GridFieldData = result['data'];

						for(var l=0; l<GridData.length; l++){
							var tmp = `<tr><td>${l + 1}</td>`;
							var head = `<tr><th>SrNo</th>`;			
							for(var k=0; k<GridFieldData.length; k++){
								tmp += `<td>${GridData[l][GridFieldData[k]['DbFieldName']]}</td>`;
								head += `<th>${GridFieldData[k]['DisplayName']}</th>`;
								// if(GridFieldData[k]['FieldType'] == '1' || GridFieldData[k]['FieldType'] == '3' || GridFieldData[k]['FieldType'] == '6' || GridFieldData[k]['FieldType'] == '7' || GridFieldData[k]['FieldType'] == '8'){
								// 	console.log(GridFieldData[k]['FieldType'] +"  == "+GridData[l][GridFieldData[k]['DbFieldName']]);
								// 	$('#kreon-grid-'+gridSerialNo+''+GridFieldData[k]['DbFieldName']).val(GridData[l][GridFieldData[k]['DbFieldName']]);
								// }else if(GridFieldData[k]['FieldType'] == '5' || GridFieldData[k]['FieldType'] == '19'){
								// 	var $newOption = $("<option selected=\"selected\"></option>").val(GridData[l][GridFieldData[k]['DbFieldName']]).text(GridData[l][GridFieldData[k]['DbFieldName']])
								// 	$('#kreon-grid-'+gridSerialNo+''+GridFieldData[k]['DbFieldName']).append($newOption).trigger("change");
								// }else if(GridFieldData[k]['FieldType'] == '17'){
								// 	$('#kreon-grid-'+gridSerialNo+'SingleDDModal'+GridFieldData[k]['DbFieldName']).val(GridData[l][GridFieldData[k]['DbFieldName']]);
								// 	$('#kreon-grid-'+gridSerialNo+'SingleDDModal-hidden-'+GridFieldData[k]['DbFieldName']).val(GridData[l][GridFieldData[k]['DbFieldName']]);
								// }
							}
							if(l == 0){
								head +=`<th>Result</th></tr>`;
								$("#ImportExcelModal #ModelContent #ImportExcelTable thead").append(head);
							}
							if(GridData[l]['ImportValidationResult'] == null || GridData[l]['ImportValidationResult'] == 'null' || GridData[l]['ImportValidationResult'] == '')
								tmp += `<td>-</td></tr>`;
							else
								tmp += `<td style="background: red;color: white;">${GridData[l]['ImportValidationResult']}</td></tr>`;
							$("#ImportExcelModal #ModelContent #ImportExcelTable tbody").append(tmp);
							//Add row
							// ImportAddNewRow($(this),result['data'],gridSerialNo,0);		
						}
					}
				}
			}
		});
	}

	function ImportAddNewRow(onCLickVariable,mArray,gridSerialNo,selectedRowId,allreadyValidate){
		console.log("Adding Row", mArray)
		var fieldArray = [];
		var mfld = "";
		var headerGridStart = '<tr class="grp'+gridSerialNo+'" data-rowid="'+selectedRowId+'" id="'+gridSerialNo;
		var headerGridEnd   = '">';
		var cuurrentRowData = "";
		var cuurrentRowDataWithComma = "";
		
		for(var t=0; t < mArray.length; t++){
			if(mArray[t]['FieldType'] == 17){
				// var fldvalue = onCLickVariable.closest("tr").find('#kreon-grid-'+gridSerialNo+'SingleDDModal'+mArray[t]['DbFieldName']).val();
				var fldvalue = $('#kreon-grid-'+gridSerialNo+mArray[t]['DbFieldName']+'-text').val();
				// var fldvalue1 = onCLickVariable.closest("tr").find('#kreon-grid-'+gridSerialNo+'SingleDDModal-hidden-'+mArray[t]['DbFieldName']).val();
				var fldvalue1 = $('#kreon-grid-'+gridSerialNo+mArray[t]['DbFieldName']).val();
			}else{
				var fldvalue = $('#kreon-grid-'+gridSerialNo+''+mArray[t]['DbFieldName']).val();
			}
			// console.log(fldvalue);
			fieldArray.push([mArray[t]['FieldType'],'kreon-grid-'+gridSerialNo+''+mArray[t]['DbFieldName']]); //,mArray[t]['CarryOn']
			
			//Required validation not using becuse it validate in Add Result In Grid function
			// if(mArray[t]['Required'] == 1 && fldvalue == "" || fldvalue == "0"){
			// 	alert(mArray[t]['DbFieldName']+" field is required");
			// 	if(ddRowSelectType == 'multi'){
			// 		var selectedRowIds = $("[data-rowid='" + selectedRowId + "']");
					
			// 		RemoveGridRow(gridSerialNo,selectedRowIds,ddRowSelectType);
			// 	}else{
			// 		RemoveGridRow(gridSerialNo,selectedItemId,ddRowSelectType);
			// 	}
			// }

			if(mArray[t]['FieldType'] == 1){
				mfld += "<td><input readonly type='text' value='"+fldvalue+"' class='form-control'   name='"+gridSerialNo+""+mArray[t]['DbFieldName']+"[]'   id='"+gridSerialNo+""+mArray[t]['DbFieldName']+"' ></td>";
			}
			if(mArray[t]['FieldType'] == 3){
				mfld += "<td><textarea readonly type='number' class='form-control'   name='"+gridSerialNo+""+mArray[t]['DbFieldName']+"[]'   id='"+gridSerialNo+""+mArray[t]['DbFieldName']+"'>"+fldvalue+"</textarea></td>";
			}
			if(mArray[t]['FieldType'] == 7){
				mfld += "<td><input readonly type='number' value='"+fldvalue+"' class='form-control'   name='"+gridSerialNo+""+mArray[t]['DbFieldName']+"[]'   id='"+gridSerialNo+""+mArray[t]['DbFieldName']+"'></td>";
			}
			if(mArray[t]['FieldType'] == 6){
				mfld += "<td><input readonly type='date' value='"+fldvalue+"' class='form-control'   name='"+gridSerialNo+""+mArray[t]['DbFieldName']+"[]'   id='"+gridSerialNo+""+mArray[t]['DbFieldName']+"'></td>";
			}
			if(mArray[t]['FieldType'] == 5 || mArray[t]['FieldType'] == 19){
				var selectedOption = $("#kreon-grid-"+gridSerialNo+""+mArray[t]['DbFieldName'] + " :selected").text();
				mfld += "<td><select readonly style='pointer-events: none;' name='"+gridSerialNo+""+mArray[t]['DbFieldName']+"[]'  placeholder='"+mArray[t]['DisplayName']+"\' id='"+gridSerialNo+""+mArray[t]['DbFieldName']+"' class=\'form-control populate\'>";
				mfld += "><option value='"+fldvalue+"'>"+selectedOption+"</option>";
				mfld += "</select></td>";
			}
			if(mArray[t]['FieldType'] == 17){
				mfld += "<td><input disabled type='text' value='"+fldvalue+"' class='form-control'  name='"+gridSerialNo+mArray[t]['DbFieldName']+"-text[]'  id='"+gridSerialNo+mArray[t]['DbFieldName']+"-text'><input type='hidden' id='"+gridSerialNo + mArray[t]['DbFieldName']+"' name='"+gridSerialNo+""+mArray[t]['DbFieldName']+"[]' value=\'"+fldvalue1+"\'></td>";
			}
			if(mArray[t]['FieldType'] == 18){
				mfld += "<td><input readonly type='time' value='"+fldvalue+"' class='form-control'   name='"+gridSerialNo+""+mArray[t]['DbFieldName']+"[]\'   id='"+gridSerialNo+""+mArray[t]['DbFieldName']+"'></td>";
			}	
			//pass value to sp at adding row
			cuurrentRowData += mArray[t]['DbFieldName']+"=";
			if(mArray[t]['FieldType'] == 0 || mArray[t]['FieldType'] == 1 || mArray[t]['FieldType'] == 3 || mArray[t]['FieldType'] == 6 || mArray[t]['FieldType'] == 8 || mArray[t]['FieldType'] == 12 || mArray[t]['FieldType'] == 13 || mArray[t]['FieldType'] == 18){
				cuurrentRowData += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
			}else if(mArray[t]['FieldType'] == 2 || mArray[t]['FieldType'] == 5 || mArray[t]['FieldType'] == 7 || mArray[t]['FieldType'] == 9 || mArray[t]['FieldType'] == 10 || mArray[t]['FieldType'] == 11 || mArray[t]['FieldType'] == 15 || mArray[t]['FieldType'] == 19){
				cuurrentRowData += fldvalue != "" ? fldvalue : 0;
			}else if(mArray[t]['FieldType'] == 17){
				cuurrentRowData += fldvalue1 != "" ? fldvalue1 : 0;
			}
			if(t != mArray.length-1)
				cuurrentRowData += "|";

			cuurrentRowDataWithComma += mArray[t]['DbFieldName']+"=";
			if(mArray[t]['FieldType'] == 0 || mArray[t]['FieldType'] == 1 || mArray[t]['FieldType'] == 3 || mArray[t]['FieldType'] == 6 || mArray[t]['FieldType'] == 8 || mArray[t]['FieldType'] == 12 || mArray[t]['FieldType'] == 13 || mArray[t]['FieldType'] == 18){
				cuurrentRowDataWithComma += fldvalue != "" ? "\'\'"+fldvalue+"\'\'" : "\'\'\'\'";
			}else if(mArray[t]['FieldType'] == 2 || mArray[t]['FieldType'] == 5 || mArray[t]['FieldType'] == 7 || mArray[t]['FieldType'] == 9 || mArray[t]['FieldType'] == 10 || mArray[t]['FieldType'] == 11 || mArray[t]['FieldType'] == 15 || mArray[t]['FieldType'] == 19){
				cuurrentRowDataWithComma += fldvalue != "" ? fldvalue : 0;
			}else if(mArray[t]['FieldType'] == 17){
				cuurrentRowDataWithComma += fldvalue1 != "" ? fldvalue1 : 0;
			}
			if(t != mArray.length-1)
				cuurrentRowDataWithComma += ",";
		}
		
		var cnt = $('#cnt'+gridSerialNo).val();	
		cnt = +cnt + 1;
		mfld += "<td><a style='padding:2px 3px;' href='javascript:void(0)' class='btn btn-danger removes"+gridSerialNo+"'><span class='glyphicon glyphicon glyphicon-remove' aria-hidden='true'></span></a><a style='padding:3px;margin:2px;' href='javascript:void(0)' class='btn btn-info edits"+gridSerialNo+"'><span class='glyphicon glyphicon glyphicon-pencil' aria-hidden='true'></span></a><input type='hidden' name='"+gridSerialNo+"GridEditID[]' id='"+gridSerialNo+"GridEditID' value='0'><input type='hidden' name='"+gridSerialNo+"GridTempID[]' id='"+gridSerialNo+"GridTempID' value='"+cnt+"'></td>";
		var headofGrid = headerGridStart+''+cnt +''+headerGridEnd;
		var end = end ;
		document.getElementById('cnt'+gridSerialNo).value = cnt;
		
		if(allreadyValidate == true){
			$('#panel'+gridSerialNo+' table tbody').append(headofGrid + mfld + end);
			$(".add"+gridSerialNo).attr("disabled", false);
		}else{
			$.ajax({
				type : "POST",
				dataType: "json",
				data : {ValidationOn:"gridsave", formData: cuurrentRowData, formDataWithComma:cuurrentRowDataWithComma, mainFormData:$("form").serialize(), FormID:<?php echo $FormID?>, GridID:$('#GridId'+gridSerialNo).val(), GridRowTempId: cnt},
				url : "validateForm.php",
				success:function(output) {

					if(output["status"] == true){
						if(output["data"]["Success"] == 1){									
							$('#panel'+gridSerialNo+' table tbody').append(headofGrid + mfld + end);
							$(".add"+gridSerialNo).attr("disabled", false);
						}else{
							if(output["data"]["Success"] == 2){
								if (confirm(output["data"]["Msg"]+". Are you sure you want to add?") == true) {
									$('#panel'+gridSerialNo+' table tbody').append(headofGrid + mfld + end);
									$(".add"+gridSerialNo).attr("disabled", false);
								} else {
									$(".add"+gridSerialNo).attr("disabled", false);
								}
							}else{
								// alert(output["data"]["Msg"]);
								$(".add"+gridSerialNo).attr("disabled", false);
							}
						}		
					}else{
						$('#panel'+gridSerialNo+' table tbody').append(headofGrid + mfld + end);
						// $(".add'.$d[3].'").attr("disabled", false);
					}
				}
			});
		}
		
		//Clear input value of first row
		for(var s=0; s < fieldArray.length; s++){
			// if(fieldArray[s][2] != 1){				
				if(fieldArray[s][0] == 5){
					$("#"+fieldArray[s][1]).val(null).trigger("change");
				}
				if(fieldArray[s][0] == 17){
					fieldName = fieldArray[s][1].split("-");
					$("#"+fieldName[0]+"-"+fieldName[1]+"-"+gridSerialNo+fieldName[2].slice(1)+"-text").val("");
					$("#"+fieldName[0]+"-"+fieldName[1]+"-"+gridSerialNo+fieldName[2].slice(1)).val("");
				}else{
					document.getElementById(fieldArray[s][1]).value = "";
				}
				$("#"+fieldArray[s][1]).css("border","1px solid #aa8a");
			// }
		}
		
		if(mArray[0]['FieldType'] == 17){
			$("#kreon-grid-"+gridSerialNo+mArray[0][1]+"-text").focus(); //Cursor focus on grid first field
		}else{
			$("#kreon-grid-"+gridSerialNo+""+mArray[0][1]).focus(); //Cursor focus on grid first field
		}	
	}

	// async function exportGridTableToExcelusingSP(GridID, filename = ''){
	// 	//Grid ID, FormID, User ID
	// 	// ajax
	// 	//fprm 3721
	// 	await new Promise((resolve, reject) => {
	// 		$.ajax({
	// 			type: "POST",
	// 			url: "importSpDataIntoExcel.php",
	// 			data: { GridID: GridID, FormID: <?php echo $FormID ?>, UserID: <?php echo $_SESSION['user_id']; ?>},
	// 			success: function (response) {
	// 				try {
	// 					const parsedResult = JSON.parse(response);
	// 					if (parsedResult.response === "true") {
	// 						resolve(parsedResult);  // Resolving the promise with the result
	// 					} else {
	// 						alert("Error while saving data..!");
	// 						resolve(null);  // Resolving with null in case of error
	// 					}
	// 				} catch (error) {
	// 					reject(error);  // Rejecting if JSON parsing fails
	// 				}
	// 			},
	// 			error: function (xhr, status, error) {
	// 				reject(error);  // Rejecting in case of AJAX error
	// 			}
	// 		});
	// 	});

	// }

	
	async function exportGridTableToExcelusingSP(GridID, filename = 'export') {
		var editID = $('#editID').val();
		try {
			// Make the AJAX call to the server
			const response = await new Promise((resolve, reject) => {
				$.ajax({
					type: "POST",
					url: "importSpDataIntoExcel.php", // The PHP file handling the data
					data: {
						GridID: GridID,
						FormID: <?php echo $FormID; ?>,
						UserID: <?php echo $_SESSION['user_id']; ?>,
						editID: editID
					},
					success: function (response) {
						try {
							const parsedResult = JSON.parse(response);
							if (parsedResult.response === "true") {
								resolve(parsedResult);  // Resolve with the successful result
							} else {
								alert("Error: " + parsedResult.message);
								resolve(null);  // Resolve with null in case of error
							}
						} catch (error) {
							reject(error);  // Reject if JSON parsing fails
						}
					},
					error: function (xhr, status, error) {
						reject(error);  // Reject if AJAX fails
					}
				});
			});

			// Process the response if it's successful
			if (response) {

				generateExcelFromJson(response, filename);  // <--- call here

				// let jsonData = response;
				// console.log("success",response, response.sheets);
				// if(response.sheets !== undefined){
				// 	//MULTI SHEETS
				// 	if (jsonData.response === "true" && jsonData.sheets) {
				// 		const wb = XLSX.utils.book_new();  // Create a new workbook

				// 		jsonData.sheets.forEach(sheet => {
				// 			// Convert data objects into an array of arrays
				// 			const formattedData = sheet.data.map(row => sheet.headers.map(header => row[header] || ""));

				// 			// Create worksheet with headers and formatted data
				// 			const ws = XLSX.utils.aoa_to_sheet([sheet.headers, ...formattedData]);

				// 			// Append worksheet to workbook
				// 			XLSX.utils.book_append_sheet(wb, ws, sheet.sheetName);
				// 		});

				// 		// Export the workbook to an Excel file
				// 		XLSX.writeFile(wb, 'exported_data.xlsx');
				// 	} else {
				// 		alert('No data found or error fetching data.');
				// 	}
				// }else{
				// 	//SINGLE SHEET
				// 	// Extract headers
				// 	const headers = jsonData.headers;

				// 	// Convert data to array format
				// 	//const data = jsonData.data.map(row => headers.map(header => row[header] || ""));
				// 	const data = jsonData.data.map(row => 
				// 	headers.map(header => {
				// 		const value = row[header];
				// 		return value === 0 || value ? value : ""; // Keep 0 as 0, otherwise empty string
				// 	})
				// 	);
				// 	// Add headers to the data array
				// 	data.unshift(headers);

				// 	// Create worksheet
				// 	const ws = XLSX.utils.aoa_to_sheet(data);

				// 	// Protect the sheet
				// 	ws['!protect'] = {
				// 		password: "1234",  // Set your password
				// 		sheet: true,
				// 		formatCells: false,
				// 		formatColumns: false,
				// 		formatRows: false
				// 	};

				// 	// Create workbook
				// 	const wb = XLSX.utils.book_new();
				// 	XLSX.utils.book_append_sheet(wb, ws, "ProtectedSheet");

				// 	// Save the file
				// 	XLSX.writeFile(wb, filename+".xlsx");
				// }
				// const { headers, data } = response;

				// // Create the table dynamically from the response data
				// const table = document.createElement('table');
				// table.id = 'data-table'; // Set table ID for export

				// // Create table header row
				// const thead = document.createElement('thead');
				// const headerRow = document.createElement('tr');
				// headers.forEach(function (header) {
				// 	const th = document.createElement('th');
				// 	th.textContent = header; // Set header text
				// 	headerRow.appendChild(th);
				// });
				// thead.appendChild(headerRow);
				// table.appendChild(thead);

				// // Create table body rows
				// const tbody = document.createElement('tbody');
				// data.forEach(function (rowData) {
				// 	const row = document.createElement('tr');
				// 	headers.forEach(function (header) {
				// 		const td = document.createElement('td');
				// 		td.textContent = rowData[header];  // Fill table cell with data
				// 		row.appendChild(td);
				// 	});
				// 	tbody.appendChild(row);
				// });
				// table.appendChild(tbody);

				// // Append the table to the document body (or specific container)
				// document.body.appendChild(table);

				// filename = filename + '.xlsx';
				
				// // Now use TableToExcel.js to export the table to an Excel file
				// TableToExcel.convert(table, {
				// 	name: filename, // Excel file name
				// 	sheet: {
				// 	name: 'Sheet 1' // Name of the sheet
				// 	}
				// });

				// // Optionally remove the table after export (to keep the page clean)
				// document.body.removeChild(table);

				// // Protect specific cells using exceljs
				// const ExcelJS = window.ExcelJS;
				// const workbook = new ExcelJS.Workbook();

				// // Load the generated Excel file
				// fetch(filename)
				// 	.then(response => response.arrayBuffer())
				// 	.then(buffer => workbook.xlsx.load(buffer))
				// 	.then(() => {
				// 		const worksheet = workbook.getWorksheet('Sheet 1');

				// 		// Protect the entire worksheet
				// 		worksheet.eachRow({ includeEmpty: true }, function(row, rowNumber) {
				// 			row.eachCell({ includeEmpty: true }, function(cell, colNumber) {
				// 				cell.protection = { locked: true };
				// 			});
				// 		});

				// 		// Unlock specific cells (e.g., cells in row 3 and below)
				// 		for (let rowNumber = 3; rowNumber <= worksheet.rowCount; rowNumber++) {
				// 			worksheet.getRow(rowNumber).eachCell({ includeEmpty: true }, function(cell, colNumber) {
				// 				cell.protection = { locked: false };
				// 			});
				// 		}

				// 		// Protect the worksheet with a password
				// 		worksheet.protect('password', {
				// 			selectLockedCells: true,
				// 			selectUnlockedCells: true
				// 		});

				// 		// Save the updated workbook
				// 		workbook.xlsx.writeBuffer().then(buffer => {
				// 			const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
				// 			saveAs(blob, filename);
				// 		});
				// 	});
			}			

		} catch (error) {
			console.error('Error during export:', error);
		}
	}

	function generateExcelFromJson(jsonData, filename) {
		try {
			if (jsonData.sheets !== undefined) {
				// MULTI-SHEET
				// if (jsonData.response === "true" && jsonData.sheets) {
				// 	const wb = XLSX.utils.book_new();

				// 	jsonData.sheets.forEach(sheet => {
				// 		const formattedData = sheet.data.map(row => 
				// 			sheet.headers.map(header => row[header] || "")
				// 		);
				// 		const ws = XLSX.utils.aoa_to_sheet([sheet.headers, ...formattedData]);
				// 		XLSX.utils.book_append_sheet(wb, ws, sheet.sheetName);
				// 	});

				// 	XLSX.writeFile(wb, filename + '.xlsx');
				// } else {
				// 	alert('No data found or error fetching data.');
				// }

				if (jsonData.response === "true" && jsonData.sheets) {
					const wb = XLSX.utils.book_new();

					jsonData.sheets.forEach(sheet => {
						const formattedData = sheet.data.map(row =>
							sheet.headers.map(header => {
								const value = row[header];

								// ✅ Handle nested date objects
								if (value && typeof value === 'object') {
									if ('date' in value) {
										// Return only date part (remove time)
										return value.date.split(' ')[0];
									}
									// If not a date object, convert to JSON string (fallback)
									return JSON.stringify(value);
								}

								// Return value or empty string (but keep 0)
								return value === 0 ? 0 : value || "";
							})
						);

						// Include headers in the top row
						const ws = XLSX.utils.aoa_to_sheet([sheet.headers, ...formattedData]);

						XLSX.utils.book_append_sheet(wb, ws, sheet.sheetName);
					});

					XLSX.writeFile(wb, filename + '.xlsx');
				} else {
					alert('No data found or error fetching data.');
				}
			} else {
				// SINGLE SHEET
				const headers = jsonData.headers;
				const data = jsonData.data.map(row =>
					headers.map(header => {
						const value = row[header];
						return value === 0 || value ? value : "";
					})
				);
				data.unshift(headers); // Add headers to top

				const ws = XLSX.utils.aoa_to_sheet(data);

				// Optional: Sheet protection
				ws['!protect'] = {
					password: "1234",
					sheet: true,
					formatCells: false,
					formatColumns: false,
					formatRows: false
				};

				const wb = XLSX.utils.book_new();
				XLSX.utils.book_append_sheet(wb, ws, "ProtectedSheet");

				XLSX.writeFile(wb, filename + ".xlsx");
			}
		} catch (err) {
			console.error("Excel generation error:", err);
			alert("Something went wrong while generating Excel.");
		}
	}




	function exportGridTableToExcel(datatable, filename = ''){
		TableToExcel.convert(document.getElementById(datatable),{
			name: filename?filename+".xlsx":"excel_data.xlsx"
		});

		/*var downloadLink;
		// var dataType = 'application/vnd.ms-excel';
		var dataType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
		// console.log(document.getElementById("GridTable"))
		// console.log(document.getElementsByClassName("GridTablea"))
		// console.log(document.getElements("#panela #GridTable"))
		// console.log($("#panela #GridTable").text())
		// var tableSelect = document.getElementsByClassName(datatable) //$("#panela #GridTable");//document.getElementById(datatable).getElementsByTagName('table');
		// var tableHTML = tableSelect[0].outerHTML.replace(/ /g, '%20');

		var tableSelect = document.getElementById(datatable);
		var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

		// Specify file name
		filename = filename?filename+'.xls':'excel_data.xls';
		
		// Create download link element
		downloadLink = document.createElement("a");
		document.body.appendChild(downloadLink);
		if(navigator.msSaveOrOpenBlob){
			var blob = new Blob(['\ufeff', tableHTML], {
				type: dataType
			});
			navigator.msSaveOrOpenBlob( blob, filename);
		}else{
			// Create a link to the file
			downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
			// Setting the file name
			downloadLink.download = filename;
			//triggering the function
			downloadLink.click();
		}*/
	}

	
</script>
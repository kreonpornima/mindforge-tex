<?php 
	// echo $k_table_body;
	/* ?>		
	<section class="panel">
		<header class="panel-heading">
			<h2 class="panel-title"><?php echo isset($k_table_title)?$k_table_title : "Table Title"; ?></h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-tabletools" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
				<thead>
					<?php echo isset($k_table_headings)?$k_table_headings:"<tr><th></th></tr>"; ?>
				</thead>
				<tbody>
					<?php echo isset($k_table_body)?$k_table_body:"<tr><td></td></tr>"; ?>
				</tbody>
			</table>
		</div>
	</section> 
		<?php */ 
		echo "<script>var FormID = $FormID;</script>";
	?>
		<script type="text/javascript" language="javascript" src="./assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script>
			function exportTableToExcel(datatable, filename = ''){
				var downloadLink;
				var dataType = 'application/vnd.ms-excel';
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
				}
			}

			function getSelectedRecords() {
				let checkboxes = document.getElementsByName('printRecords');
				let result = "";
				
				for (var i = 0; i < checkboxes.length; i++) {
					if (checkboxes[i].checked) {
						result += checkboxes[i].value;
						if(i != checkboxes.length - 1){
							result += ",";
						}
					}
				}
				window.location=`./test/?id=${result}`;
			}
		</script>
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<!--a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a-->
					<?php 
						if($access['canAdd']){
							$k_table_button_link2 = isset($k_table_button_link2)? $k_table_button_link2 : '#';
							if(isset($k_table_button2)){
								echo "<a href=". $k_table_button_link2 ."><button class='btn btn-danger' id='formAddNewBtn' name='addnew'>". $k_table_button2 ."<span style='font-size: smaller;'>(Alt+N)</span></button></a>";
							}
							$k_table_button_link = isset($k_table_button_link)? $k_table_button_link : '#';
							if(isset($k_table_button)){
								echo "<a href=". $k_table_button_link ."><button class='btn btn-danger' id='formAddNewBtn' name='addnew'>". $k_table_button ."<span style='font-size: smaller;'>(Alt+N)</span></button></a>";
							}
						}
					?>
					<button id="listviewExportExcel" class="btn btn-primary" style="font-size:10px;">Export To Excel</button>
					<!-- <button onclick="getSelectedRecords()" class="btn btn-primary bizbtn" style="font-size:10px;">Print Records</button> -->
				    <!-- <button onclick="exportTableToExcel('datatable')" class="btn btn-primary bizbtn" style="font-size:10px;">Export Data</button> -->
					<?php 
						if(strlen($viewSettings[15]) > 2){
							?>
							<div style="display: inline-block;"> 
								<form action="bulk-form-import.php?view=1" method="POST">
									<input type="hidden" name="FormID" value="<?php echo $FormID ?>" />	
									<input type="hidden" name="FormName" value="<?php echo $viewSettings[0]; ?>" />	
									<button onclick="importBulkDataFromExcel()" class="btn btn-primary ImportBulkBtn" style="font-size:10px;">Bulk Import</button>
								</form>	
							</div>
							<script>
								function importBulkDataFromExcel(){
									// window.location = "bulk-form-import.php";
								}
							</script>
							<?php 
						}
						if($editID == 0) echo '<button class="btn btn-warning bizbtn" style="font-size:10px" onclick="openLogModal(\'full\')">Logs</button>';
						if($editID == 0){
							if($_SESSION['Category'] == 2){
								echo '<button class="btn btn-info bizbtn" style="margin-left:5px;font-size:10px;" onclick="openSQLModal(\'full\')">SQL</button>';
								echo $k_table_formdesigner_button;
								if($viewSettings[19] == 1){
									echo '<button class="btn btn-info bizbtn" style="margin-left:5px;font-size:10px;;" onclick="openCloningModal()" id="formCloning" data-formname="'.$viewSettings[0].'" data-formfields="'.$displayFormFieldNames.'">Form Cloning</button>';
								}
							}
							echo $k_table_requirement_button = '<button class="btn btn-success bizbtn" style="margin-left:5px;font-size:10px;" onclick="openRequirementModal()">Requirement</button>';
						}
					?>
				</div>
				<h2 class="panel-title"><?php echo isset($k_table_title)?$k_table_title : "Table Title"; ?></h2>
				<p class="panel-subtitle"><?php echo isset($k_table_subtitle) ? $k_table_subtitle : ""; ?></p>
			</header>
			<div class="panel-body" id="datatable">
					<!--table class="table table-bordered table-striped mb-none" id="datatable" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf"-->
				<table class="table table-bordered table-striped mb-none" id="datatable-table" data-swf-path="assets/vendor/jquery-datatables/extras/TableTools/swf/copy_csv_xls_pdf.swf">
					<!--table class="table table-bordered table-striped mb-none" id="datatable-default"-->
					<thead>
						<?php echo isset($k_table_headings)?$k_table_headings:"<tr><th></th></tr>"; ?>
						<?php echo isset($k_table_headings1)?"<tr>".$k_table_headings1."</tr>":"<tr><th></th></tr>"; ?>
					</thead>
				</table>
				<script>
					$(document).ready(function(){
						load_data();
					
						// setTimeout(
						// 	function() {
						// 		$("#datatable-table tr td:last-child").css('display','flex').css('gap','2px');
						// 	},200);
						
					});
				</script>
			</div>
		</section>

<!-- <blockquote> -->
  <!-- <pre> -->
    <!-- <code> -->
		<!-- <![CDATA[Your <code> here]]> -->
		<?php 
			// echo str_replace("<","&lt;",str_replace("&","&amp;",$k_table_headings1));
			?>
    <!-- </code> -->
  <!-- </pre> -->
<!-- </blockquote> -->

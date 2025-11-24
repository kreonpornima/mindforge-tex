<?php 
//include "k_files/k_config.php";
$k_head_keywords = "";
$k_head_desc = "Admin Template";
$k_head_author = "KreonSolutions.com";
$k_head_login_check = 1;
$k_page_title = $k_head_title; 
//include "k_files/k_header.php";

$k_debug = isset($k_debug) ? $k_debug : 0;

$ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
$FormID = $ReportID;
$editID = 0;
$viewpage = 0;

include "form-init.php";
echo '</form></div></section>
	<script>
		$(".panel.forminit").hide();
	</script>';

include 'reportModel.php'; //REPORT MODEL

function createReportFilters($arr, $viewResult,$requestArray){
    global $k_debug;
	
	// print_r($arr);
	
	$divClass = "";
	if($arr[5] !=0 ){	//Fields Size XS
		$divClass .= " col-xs-" . $arr[5] . " ";
	}

	if($arr[6] !=0 ){	//Field Size SM
		$divClass .= " col-sm-" . $arr[6] . " ";
	}

	if($arr[7] !=0 ){	//Fields Size MD
		$divClass .= " col-md-" . $arr[7] . " ";
	}

	if($arr[5] == 0 && $arr[6] == 0 && $arr[7] == 0 ){ //both the sizes are not set
		$divClass .= " col-md-4 ";
	}

    if($arr[3] == 1){ 	//Textbox
		if(isset($requestArray[$arr[1]])){
			$inputValue = $requestArray[$arr[1]];
		}else{
			$inputValue = "";
		}
		return "<div class='".$divClass."'><label>".$arr[0]."</label><input class='form-control dyn1' value='".$inputValue."' type='text' name='".$arr[1]."' id='".$arr[1]."' /></div>";
    }
    
    if($arr[3] == 6){ 	//Date
		if(isset($requestArray[$arr[1]])){
			$inputValue = $requestArray[$arr[1]];
		}else{
			$inputValue = "";
		}
		return "<div class='".$divClass."'><label>".$arr[0]."</label><input class='form-control dyn1' type='date' name='".$arr[1]."' id='".$arr[1]."' value='". $inputValue ."'/></div>";
	}

    if($arr[3] == 5){ 	//SELECT from DB
		$flds = '<div class='.$divClass.'><label>'.$arr[1].'</label>';

		$flds .= '<select data-plugin-selectTwo class="form-control populate '.$arr[1].'" name="'.$arr[2].'" id="'.$arr[2].'" class="form-control populate"';
		$flds .= '><option value=""></option>';
		
		$tmpID = array();
		$tmpLabel = array();
		for($j = 0; $j < $viewResult['num_rows']; $j++){
			$tmpID[$j] = $viewResult['result_set'][$j][$arr[2]];
			$tmpLabel[$j] =$viewResult['result_set'][$j][$arr[1]];
		}
		
		$finalID = array_unique($tmpID);
		$finalLabel = array_unique($tmpLabel);
		//print_r($finalID);
		for($i = 0; $i <= sizeof($tmpID); $i++){
			if(isset($finalID[$i]) || isset($finalLabel[$i])){
				//Sprint_r(gettype($finalLabel[$i]));
				//if(in_array(isset($requestArray[$arr[2]]),$finalID)){
				if(isset($requestArray[$arr[2]])){
					if(in_array($finalID[$j], $requestArray[$arr[2]])){
						$flds .= '<option selected value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					} else{
						$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					}
				}else{
					$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
				}

			}
		}
        $flds .= '</select></div>';
		return $flds;
	}

	if($arr[3] == 11){ 	//MULTI SELECT SEARCH from DB WITH MAPPING TABLE
		$flds = "<div class='".$divClass."'><label>".$arr[0]."</label>";
		$flds .= '<select multiple data-plugin-selectTwo class="form-control populate '.$arr[1].'" name="'.$arr[2].'[]">';		   
		
		$tmpID = array();
		$tmpLabel = array();
		for($j = 0; $j < $viewResult['num_rows']; $j++){
			$tmpID[$j] = $viewResult['result_set'][$j][$arr[2]];
			$tmpLabel[$j] =$viewResult['result_set'][$j][$arr[1]];
		}
		
		//print_r($tmpID);
		$finalID = array_unique($tmpID);
		$finalLabel = array_unique($tmpLabel);
		//print_r($finalID);
		//print_r($requestArray);
		for($j = 0; $j < sizeof($tmpID); $j++){
			if(isset($finalID[$j]) || isset($finalLabel[$j])){
				//if(in_array(isset($requestArray[$arr[2]][$j]),$finalID)){
				if(isset($requestArray[$arr[2]])){
					if(in_array($finalID[$j], $requestArray[$arr[2]])){
						$flds .= '<option selected value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					} else{
						$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					}
				} else{
					$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
				}
			}
		}
        $flds .= '</select></div>';
		return $flds;
	}	
}

function createReportTable($result1, $viewResult){
	// print_r($viewResult);
	$align = "";
	$sum = 0;
	$tableFld = "";
	$flag = 0;
	$sumField = array();
	// $totalField = "";
	// print_r($result1);
	$tableFld = '<thead>';
            
                $columns = array();
				$tableFld .= "<tr>";
                for($i = 0; $i < $result1['num_rows']; $i++){
					$row = $result1['result_set'][$i];
    				array_push($columns,array("ViewFieldName" => $row['ViewFieldName'], "Alignment" => $row['Alignment'], "ShowTotal" => $row['ShowTotal']));
                    $tableFld .= "<th>" . $row['DisplayName'] . "</th>";              
                }
                $tableFld .= "</tr>";
				
				$tableFld .= '</thead><tbody>';
                
				
                for($j = 0; $j < $viewResult['num_rows']; $j++){
					
					$tableFld .= "<tr>";
                    $row1 = $viewResult['result_set'][$j];
					
					//print_r($row1);
                    for($i=0; $i<count($columns); $i++){
						// print_r([$columns[$i]['ViewFieldName']]);
						if(in_array($columns[$i]['Alignment'], array("1","0"))){	
							$align = "left";
						}elseif($columns[$i]['Alignment'] =="2"){
							$align = "center";
						}elseif($columns[$i]['Alignment'] == "3"){
							$align = "right";
						}					
						
                        $tableFld .= "<td align= '".$align."'>" . $row1[$columns[$i]['ViewFieldName']] . "</td>";  
                    }
					
                    $tableFld .= "</tr>";
                }
				$footerTotal = array();
				for($i=0; $i<count($columns); $i++){
					if($columns[$i]['ShowTotal'] == 1){
						$flag = 1;
						$footerTotal[$i] = array_sum(array_column($viewResult['result_set'],$columns[$i]['ViewFieldName']));
					}
				}
        
		$tableFld .= '</tbody>';
		if($flag == 1){
			$tableFld .= '<tfoot>';
				$tableFld .= '<tr>';
				for($i=0; $i<count($columns); $i++){
					if($columns[$i]['ShowTotal'] == 1){
						$tableFld .= '<td align="'.$align.'">'.$footerTotal[$i].'</td>';
					}else{
						$tableFld .= '<td align="'.$align.'"></td>';
					}
				}
				$tableFld .= '</tfoot>';
				$tableFld .= '</tr>';
		
		}
		
		return $tableFld;
}
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
					$("#logItems").html("<p>No Data Found..</p>");
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
    </style>
    <script>
		// When the button is clicked, open the modal and fetch data
		var currentPage = 1;
		var pageSize = 5;
		var totalRecords = 0;

		function openSQLModal(){
			// alert(type);
			$('#SQLModal').modal('show');
			currentPage = 1;
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
                                                <input type="checkbox" class="sp-checkbox" data-id="${spId}" name="spId" value="${row['ProcedureName']}"> → <a href="#" onclick="loadDefinition('${child}')">${child}</a>
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
			// $.ajax({
			// 	url: 'getSQLData.php', // Replace with your server endpoint
			// 	method: 'POST',
			// 	dataType: 'json',
			// 	data: {FormID: <?php echo $FormID; ?>,ModalType:'sql'},
			// 	success: function(response) {
					
			// 		const rows = response.data || [];
			// 		const CompanyRows = response.GroupCompanies || [];
			// 		totalRecords = response.total || 0;

			// 		$('#spCompanyGroups').html('<strong>Groups using this form</strong> : '+response.companyGroups);

			// 		const ddTbody = $("#SQLItems").empty();

			// 		const ddCompaniesTbody = $("#GroupCompaniesData").empty();

			// 		if (rows.length === 0) {
			// 			ddTbody.append("<tr><td colspan='1'>No Log Found..</td></tr>");
			// 		} else {
            //             rows.forEach((row, index) => {
            //                 const spId = `sp_${index}`;
            //                 const hasChildren = row.CalledSPs && row.CalledSPs.length > 0;

            //                 const toggleIcon = hasChildren ? `<span class="toggle-icon" onclick="toggleChildren('${spId}')">▶</span>` : '';
            //                 const parentRow = `
            //                     <tr>
            //                         <td>
			// 							<input type="checkbox" class="sp-checkbox" data-id="${spId}" name="spId" value="${row['ProcedureName']}">
            //                             ${toggleIcon}
            //                             <a href="#" onclick="loadDefinition('${row['ProcedureName']}')">${row['ProcedureName']}</a>
            //                         </td>
            //                     </tr>
            //                 `;

            //                 ddTbody.append(parentRow);

            //                 if (hasChildren) {
            //                     row.CalledSPs.forEach(child => {
            //                         const childRow = `
            //                             <tr class="child-of-${spId}" style="display: none;">
            //                                 <td style="padding-left: 35px;">
            //                                     <input type="checkbox" class="sp-checkbox" data-id="${spId}" name="spId" value="${row['ProcedureName']}"> → <a href="#" onclick="loadDefinition('${child}')">${child}</a>
            //                                 </td>
            //                             </tr>
            //                         `;
            //                         ddTbody.append(childRow);
            //                     });
            //                 }
            //             });

			// 			// rowHtml = '';
            //             // CompanyRows.forEach((row, index) => {
			// 			// 	console.log(row);
            //             //     rowHtml += `<input type="checkbox" id="checkbox" class="group-checkbox" value="${row['Companyid']}"> ${row['Company']}<br>`;

            //             // });
			// 			// ddCompaniesTbody.append(rowHtml);

			// 			htmlRows = '';
			// 			CompanyRows.forEach((row, index) => {
			// 				const htmlRows = `
            //                     <tr>
            //                         <td>
			// 							<input type="checkbox" class="company-checkbox" id="spId" name="spId" value="${row['Companyid']}"> ${row['Company']}
            //                         </td>
            //                     </tr>
            //                 `;

            //                 ddCompaniesTbody.append(htmlRows);
			// 			});
			// 		}
			// 	},
			// 	error: function(xhr, status, error) {
			// 		console.error('Failed to load data:', error);
			// 		callback(false); // Callback with false on error
			// 	}
			// });
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


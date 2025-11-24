<?php
require_once ('dbClass.php');
$k_head_title = 'Page Role Access';
$k_head_keywords ='Page Role Access';
$k_head_desc ='';
$k_head_author ='KreonSolutions.com';
$k_page_title ='Page Role Access';

//$k_debug = 1;
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$viewpage = isset($_GET['view']) ? $_GET['view'] : 0;
$viewID = isset($_POST['viewID']) ? $_POST['viewID'] : 0;
$group_id = isset ($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;

$val = "";
if((int)$editID > 0){
	$sql="SELECT * FROM pagerolemaster where RoleId = " . $editID;
	$result = db::getInstanceMaster()->db_select($sql);	
	for($i = 0; $i < $result['num_rows']; $i++){
		$val = $result['result_set'][$i]['Label'];
	}
}

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-alpine.css">
<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.2.1/dist/ag-grid-enterprise.js?t=55198984654"></script>

<style>
	.scrollable-table {
		width: 100%;
		border-collapse: collapse;
	}

	.scrollable-table thead {
		background: #f1f1f1; /* keep header visible */
		display: table-header-group;
	}

	.scrollable-table tbody {
		display: block;
		max-height: 200px;   /* desired table height */
		overflow-y: auto;
	}

	.scrollable-table tr {
		display: table;
		width: 100%;
		table-layout: fixed;  /* keeps columns aligned */
	}
</style>

<script>
	let gridApi;

	// Custom header component with search input
	const columnDefs = [
		// {
		//   field: 'module',
		//   headerName: 'Module',
		//   cellRenderer: 'agGroupCellRenderer',
		//   width: 250
		// },
		{
		headerName: 'Add',
		field: 'AddBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'AddBtn')
		},
		{
		headerName: 'Edit',
		field: 'EditBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'EditBtn')
		},
		{
		headerName: 'Delete',
		field: 'DeleteBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'DeleteBtn')
		},
		{
		headerName: 'ListView',
		field: 'ListView',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'ListView')
		},
		{
		headerName: 'BarcodePrint',
		field: 'OtherBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'OtherBtn')
		},
		{
		headerName: 'EwayBillBtn',
		field: 'EwayBillBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'EwayBillBtn')
		},
		{
		headerName: 'EinvoiceBtn',
		field: 'EinvoiceBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'EinvoiceBtn')
		},
		{
		headerName: 'PdfReportBtn',
		field: 'PdfReportBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'PdfReportBtn')
		},
		{
		headerName: 'GridReportBtn',
		field: 'GridReportBtn',
		width: 80,
		cellRenderer: params => checkboxRenderer(params, 'GridReportBtn')
		},
		{
		field:'Level1',
		hide: true,
		// suppressToolPanel: true
		},
		{
		field:'Level2',
		hide: true,
		// suppressToolPanel: true
		},
		{
		field:'Level3',
		hide: true,
		// suppressToolPanel: true
		},
	];

	const myTheme = agGrid.themeQuartz.withParams({	
		accentColor: "#15274F",
			backgroundColor: "#000000",
			borderRadius: 3,
			browserColorScheme: "inherit",
			columnBorder: true,
			fontFamily: {
				googleFont: "Roboto"
			},
			fontSize: 12,
			foregroundColor: "#0D0E0F",
			headerFontSize: 14,
			spacing: 1,
			wrapperBorderRadius: 5,
			rowVerticalPaddingScale: 0.6,
	});

	const gridOptions = {
		columnDefs,
		theme: myTheme,
		rowData: [], // initially empty
		getRowId: params =>`${params.data.Level1}`, // params.data.id,
		treeData: true,
		animateRows: true,
		groupDefaultExpanded: -1,
		treeDataParentIdField: 'parentId',
		autoGroupColumnDef: {
			// headerName: 'Module',
			// headerComponent: SearchHeader,
			// filter: "agTextColumnFilter",
			filter: 'agMultiColumnFilter',
			filterValueGetter: (params) => {
				return params.data.module;
			},
			// filter: true,
			width: 250,
			cellRendererParams: {
				suppressCount: true,
				innerRenderer: (params) => {
					return params.data?.module ?? '';
				}
			}
		},
		defaultColDef: {
		resizable: false
		},
		onGridReady: function () {
		console.log("✅ Grid is ready. Loading data...");
		loadData(); // ← This will now be called properly
		}
	};


	function checkboxRenderer(params, perm) {
		if (!params.node || !params.data) {
		return document.createTextNode(''); // safe fallback
		}

		const isChecked = params.data?.[perm] ?? false;
		const input = document.createElement('input');
		input.type = 'checkbox';
		input.checked = isChecked;

		// Force update if stale
		setTimeout(() => {
		input.checked = isChecked;
		}, 0);

		input.addEventListener('change', () => {
			const value = input.checked;

			// ✅ Set value on current node
			if (params.node?.setDataValue) {
				params.node.setDataValue(perm, value);
			}

			// ✅ Propagate to children
			propagateToChildren(params.node, perm, value);

			// ✅ Propagate to parent
			propagateToParent(params.node, perm);
		});

		return input;
	}

	function propagateToChildren(node, perm, value) {
		if (!node.childrenAfterGroup) return;

		node.childrenAfterGroup.forEach(child => {
		if (child.setDataValue) {
			child.setDataValue(perm, value);
			// recurse for deeper children
			propagateToChildren(child, perm, value);
		}
		});
	}

	function propagateToParent(node, perm) {
		const parent = node.parent;
		if (!parent || !parent.setDataValue || !parent.childrenAfterGroup) return;

		const allChecked = parent.childrenAfterGroup.every(child => child.data?.[perm]);
		const anyChecked = parent.childrenAfterGroup.some(child => child.data?.[perm]);

		parent.setDataValue(perm, anyChecked); // If at least one child checked, set true
		if (!anyChecked) {
			parent.setDataValue(perm, false); // uncheck parent if none are checked
		}

		// continue up the tree
		propagateToParent(parent, perm);
	}


	async function loadData() {
		try {
		// const response = await fetch('menus_loader.php');
		const response = await fetch('menus_loader.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({ roleId:<?php echo $editID; ?>, group_id:<?php echo $group_id; ?> })
		});
		

		// if (!response.ok) {
		//   throw new Error(`HTTP error! status: ${response.status}`);
		// }
		console.log("Response object:", response);
		const text = await response.text();
		// console.log("Raw response text:", text);

		const rawData = JSON.parse(text);
		console.log("Parsed JSON:", rawData);

		const flatModules = rawData.map(row => ({
			// id: row.Level1,
			// module: `[${row.Level1}] ${row.displayname1}`,  // <- Include ID here
			module: row.displayname1 + (row.child_count ? ` (${row.child_count})` : ''),
			parentId: row.parent1 || null,
			AddBtn: row.AddBtn === "1" || row.AddBtn === 1 ? true : false,
			EditBtn: row.EditBtn === "1" || row.EditBtn === 1 ? true : false,
			DeleteBtn: row.DeleteBtn === "1" || row.DeleteBtn === 1 ? true : false,
			ListView: row.ListView === "1" || row.ListView === 1 ? true : false,
			OtherBtn: row.OtherBtn === "1" || row.OtherBtn === 1 ? true : false,
			EwayBillBtn: row.EwayBillBtn === "1" || row.EwayBillBtn === 1 ? true : false,
			EinvoiceBtn: row.EinvoiceBtn === "1" || row.EinvoiceBtn === 1 ? true : false,
			PdfReportBtn: row.PdfReportBtn === "1" || row.PdfReportBtn === 1 ? true : false,
			GridReportBtn: row.GridReportBtn === "1" || row.GridReportBtn === 1 ? true : false,
			// add: false,
			// edit: false,
			// delete: false,
			// view: false,
			// print: false,
			Level1: row.Level1,
			Level2: row.Level2,
			Level3: row.Level3,
		}));

		console.log(flatModules);
		console.log("loadData load...");

		// ✅ Defensive check
		if (gridApi) {
			gridApi.setGridOption('rowData',flatModules); 
			setTimeout(() => {
				gridApi.refreshCells({ force: true });
				gridApi.autoSizeAllColumns(); //This auto-sizes all columns based on content
			}, 100); // let it render first
			// gridApi.setRowData(flatModules);
		} else {
			console.error("gridOptions.api is not ready yet.");
		}
		} catch (error) {
		console.error("Error fetching or parsing data:", error);
		}
	}


	document.addEventListener('DOMContentLoaded', function () {
		const gridDiv = document.getElementById('myGrid');
		gridApi = agGrid.createGrid(gridDiv, gridOptions);
	});

	// function saveRights() {
	// 	const rights = [];
	// 	gridApi.forEachNode(node => {
	// 	const { id, module, AddBtn, EditBtn, DeleteBtn, ListView, OtherBtn, Level1, Level2, Level3 } = node.data;
	// 	rights.push({ id, module, AddBtn, EditBtn, DeleteBtn, ListView, OtherBtn, Level1, Level2, Level3 });
	// 	});
	// 	console.log('Saved Rights:', rights);
	// 	// alert("Rights saved to console (F12 to view).");

	// 	fetch('save_rights.php', {
	// 	method: 'POST',
	// 	headers: { 'Content-Type': 'application/json' },
	// 	body: JSON.stringify(rights),
	// 	})
	// 	.then(res => res.json())
	// 	.then(data => {
	// 		console.log('Server Response:', data);
	// 		alert('Rights saved to database.');
	// 	})
	// 	.catch(err => {
	// 		console.error('Error saving rights:', err);
	// 		alert('Failed to save rights.');
	// 	});
	// }

	document.addEventListener("DOMContentLoaded", function () {
	const form = document.getElementById('rightsForm');
	if (!form) {
		console.error("Form with ID 'rightsForm' not found.");
		return;
	}

	form.addEventListener('submit', function (e) {
		e.preventDefault(); // prevent default form submission
		 // just to confirm it runs

		const rights = [];
		gridApi.forEachNode(node => {
			const { module, AddBtn, EditBtn, DeleteBtn, ListView, OtherBtn, EwayBillBtn, EinvoiceBtn, PdfReportBtn, GridReportBtn, Level1, Level2, Level3 } = node.data;
			rights.push({ module, AddBtn, EditBtn, DeleteBtn, ListView, OtherBtn, EwayBillBtn, EinvoiceBtn, PdfReportBtn, GridReportBtn, Level1, Level2, Level3 });
		});

		document.getElementById('rightsJson').value = JSON.stringify(rights);
		console.log("Rights JSON Set:", document.getElementById('rightsJson').value);

		console.log($('#rightsJson').val());
		// alert("hi");
		this.submit(); // manually trigger form submit
	});
});

  
</script>


<?php
include 'k_files/k_header.php';
$k_head_include = '
		<link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
		<link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		
		
		<style>
			// .multi-check {
			// 	border: 1px solid #cacaca;
			// 	padding: 5px;
			// 	padding-left: 10px;
			// 	max-height: 90px;
			// 	overflow-y: scroll;
			// }
			html, body {
				height: 100%;
				margin: 0;
				font-family: Arial, sans-serif;
			}
			.ag-theme-alpine {
				height: 500px;
				width: 100%;
			}

			
		</style>
';


?>	
<!-- <script>
    $(document).ready(function() {
        $('#addAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_add').prop('checked', true);
            }else{
                $('.ch_add').prop('checked', false);
            }     
        });
        $('#editAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_edit').prop('checked', true);
            }else{
                $('.ch_edit').prop('checked', false);
            }     
        });
        $('#delAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_delete').prop('checked', true);
            }else{
                $('.ch_delete').prop('checked', false);
            }     
        });
        $('#listAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_listview').prop('checked', true);
            }else{
                $('.ch_listview').prop('checked', false);
            }     
        });
        $('#otherAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_other').prop('checked', true);
            }else{
                $('.ch_other').prop('checked', false);
            }     
        });
        
    });

</script> -->






<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Page Role Access</h2>
	</header>
<div class="panel-body">
	
	<div class="col-md-12">
		<form class="form-bordered" id="rightsForm" method="post" action="PageRoleAccessdb.php" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-8">
			
				<div class="col-md-4"><label>Role Name <span class="required">*</span></label>
						<input required="" class="form-control dyn1" value="<?php echo $val; ?>" type="text" name="Label" id="Label" />
					</div>
				</div>
			</div>
			
			<hr/>

			<div class="row" style="margin-bottom:20px;">
				<div class="col-md-6"  >
					<table class="table table-bordered table-striped mb-none scrollable-table"  >
						<thead class=" thead-light">
							<tr>
								<th style="width:60px" width="60">Company</th>
								<!-- <th style="width:60px" width="60">Add <input type="checkbox" id="addAll" /></th> -->
							</tr>	
						</thead>	
						<tbody>	
						<?php 
							$sql1="Select CONCAT(AiCompany.Label,' - ', AiDivision.Label, ' - ', AiReg.Year) as Name,AiReg.ID From AiReg 
							LEFT JOIN AiCompany ON AiReg.CompanyID = AiCompany.ID 
							LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID
							LEFT JOIN AiDivision ON AiReg.DivisionID = AiDivision.ID
							WHERE AiGroup.ID = '".$group_id."'";
							$result1 = db::getInstanceMaster()->db_select($sql1);	
							// print_r($result1);
							for($i = 0; $i < $result1['num_rows']; $i++){
								$regId 		= $result1['result_set'][$i]['ID'];
								$groupName 	= $result1['result_set'][$i]['Name'];

							
								if((int)$editID > 0){
									$sql2 = "SELECT * FROM CompanyRoleAccess where RoleID = " . $editID . " AND RegID = " . $regId;
									$result2 = db::getInstanceMaster()->db_select($sql2);
								
									if(count($result2['result_set']) > 0){
										$checked = 1;
									}else{
										$checked = 0;
									}
									
								}
								?>
								<tr>
									<td><input type="checkbox" id="regId" name="regId[]" value="<?php echo $regId; ?>" <?php echo ($checked==1 ? 'checked' : '');?> />&nbsp;&nbsp;<?php echo $groupName;?></td>
									
								</tr>
								<?php
							}
						
							?>
						</tbody>
					</table>
				</div>

				<div class="col-md-6" >
					<table class="table table-bordered table-striped mb-none scrollable-table" >
						<thead class=" thead-light">
							<tr>
								<th style="width:60px" width="60">Geo Locking (<a href="geoLocking.php?view=1">Add IP Address</a>)</th>
								<!-- <th style="width:60px" width="60">Add <input type="checkbox" id="addAll" /></th> -->
							</tr>	
						</thead>	
						<tbody>	
						<?php 
							$sql1="select * from geoLockings WHERE isActive = 1 AND GroupID = '".$group_id."'";
							$result1 = db::getInstanceMaster()->db_select($sql1);	
							// print_r($result1);

							if($result1['num_rows'] > 0){
								for($i = 0; $i < $result1['num_rows']; $i++){
									$ipaddressid = $result1['result_set'][$i]['ID'];
									$name = $result1['result_set'][$i]['Name'];
									$ipv4address = $result1['result_set'][$i]['IPv4Address'];

									if((int)$editID > 0){
										$sql2 = "SELECT * FROM MapRoleIP where RoleID = " . $editID . " AND IPAddressID = " . $ipaddressid;
										$result2 = db::getInstanceMaster()->db_select($sql2);
									
										if(count($result2['result_set']) > 0){
											$checked = 1;
										}else{
											$checked = 0;
										}
										
									}
						
									?>
									<tr>
										<td><input type="checkbox" id="ipAddressId" name="ipAddressId[]" value="<?php echo $ipaddressid; ?>" <?php echo ($checked==1 ? 'checked' : '');?> />&nbsp;&nbsp;<?php echo $name ." (".$ipv4address.")";?> </td>
										
									</tr>
									<?php
								}
							}else{
								?>
								<tr>
									<td> Geo Locking is disabled. If you are a super admin, you can enable it from the <a href="settings.php"> setting. </a></td>
									
								</tr>
								<?php
							}
						
							?>
						</tbody>
					</table>

					<br>

					<div class="col-md-10"><label> Geo Locking Department Head</label>
							<select multiple data-plugin-selectTwo name="DepartmentHead[]" id="DepartmentHead" class="form-control populate" >
								<?php
									$sql = 'SELECT ID, Name FROM users where isActive = 1 and GroupID = ' . $_SESSION['group_id'] . ' and ID != '.$_SESSION['user_id'].'  order by ID';
									$result1 = db::getInstanceMaster()->db_select($sql, "L-882");
									// Output the number of rows
									$num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);

									// 2. If edit mode, get existing selected users
									$selectedUsers = [];
									if ((int)$editID > 0) {
										echo $sql2 = "SELECT UserID FROM MapGeoLockingHead WHERE RoleID = " . $editID;  // replace with your table
										$result2 = db::getInstanceMaster()->db_select($sql2);
										if (!empty($result2['result_set'])) {
											foreach ($result2['result_set'] as $row) {
												$selectedUsers[] = $row['UserID'];
											}
										}
									}
									// echo "Number of rows in the result set: $num_rows<br>";
									// Loop through the result set and output options
									for ($i = 0; $i < $num_rows; $i++) {
										$id = $result1['result_set'][$i]['ID'];
										$name = $result1['result_set'][$i]['Name'];
										$selected = in_array($id, $selectedUsers) ? 'selected' : '';
										echo '<option class="gridTemplate" value="' . $id . '" ' . $selected . '>' . $name . '</option>';
									}
								?>
							</select>
				    </div>


				</div>
			</div>

			
			<!-- load roles -->
			<input type="hidden" id="rightsJson" name="rightsJson" value="">

			<div id="myGrid" class="ag-theme-alpine"></div>
			<?php
				if((int)$editID > 0){
					$btnName = "Update";
				}else{
					$btnName = "SAVE";
				}
			?>
			<div class="row">
				<div class="col-md-12">
					<label class="col-md-4 control-label"></label>
					<input type="hidden" value="<?php echo $editID; ?>" name="editID"><br>
					<input type="submit" value="<?php echo $btnName; ?>" class="btn btn-primary">
					<input type="hidden" id="totalPages" name="totalPages" value="<?php echo $i; ?>" />
					<a href="roles.php?view=1" class="btn btn-danger">CANCEL</a>			
				</div>
			</div>

				
		</form> 
	</div>	


	
</div>


<?php include "k_files/k_footer.php"; ?>
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
		width: 180,
		cellRenderer: params => checkboxRenderer(params, 'AddBtn'),
        // checkboxSelection: true, 
        headerCheckboxSelection: true,  // This will add a checkbox in the header

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

    function checkboxRenderer(params) {
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = params.value || false; // Default to unchecked

        checkbox.addEventListener('change', () => {
            // Update the data when the checkbox is toggled
            params.node.setDataValue(params.column.getColId(), checkbox.checked);

            // Propagate the change to the parent and child nodes
            propagateToParent(params.node, params.column.getColId());
            propagateToChildren(params.node, params.column.getColId(), checkbox.checked);

            // Update the header checkbox state after the change
            updateHeaderCheckboxState(params.column.getColId());
        });

        return checkbox;
    }
    function propagateToParent(node, colId) {
        const parent = node.parent;
        if (!parent) return;

        const allChecked = parent.childrenAfterGroup.every(child => child.data[colId]);
        parent.setDataValue(colId, allChecked);

        // Continue propagation up the tree if needed
        propagateToParent(parent, colId);
    }

    function propagateToChildren(node, colId, value) {
        if (!node.childrenAfterGroup) return;

        node.childrenAfterGroup.forEach(child => {
            child.setDataValue(colId, value);
            propagateToChildren(child, colId, value); // Recursively propagate to deeper children
        });
    }
     // Function to update the header checkbox state based on the column's row checkboxes
    function updateHeaderCheckboxState(colId) {
        const column = gridApi.getColumnState().find(col => col.colId === colId);
        if (!column) return;

        const allChecked = gridApi.getRowNode().every(node => node.data[colId]);
        const anyChecked = gridApi.getRowNode().some(node => node.data[colId]);

        if (allChecked) {
            column.setDataValue(true); // Set header checkbox to checked
        } else if (anyChecked) {
            column.setDataValue(true); // Indeterminate state if some checkboxes are checked
        } else {
            column.setDataValue(false); // Set header checkbox to unchecked
        }

        gridApi.refreshHeader(); // Refresh header to update checkbox state
    }


	/*
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
	}*/


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

			<table class="table table-bordered table-striped mb-none">
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

			</br></br>

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Drilldown</title>
    <!-- Include ag-Grid styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-alpine.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        p {
        font-size: 1em;
        margin-bottom: 1em;
        margin-top: 0;
        }

        .container {
        max-width: 960px;
        height: 100%;
        margin: 10% auto;
        padding: 2.5em;
        }

        form > div {
        display: flex;
        background-color: #edf6ff;
        }

        form > div > p {
        min-width: 20%;
        }

        form p {
        color: #0b0b18;
        }

        .full-width-detail {
        padding-top: 4px;
        }

        .full-width-details {
        float: left;
        padding: 5px;
        margin: 5px;
        width: 150px;
        }

        .full-width-grid {
        margin-left: 10px;
        padding-top: 25px;
        display: block;
        height: 310px;
        }

        .pointer-class {
        cursor: pointer;
        }

        .master-container {
            display: flex;
            align-items: center;
        }

        label {
            display: block;
            margin: 0.95em 5%;
            font-weight: bold;
        }

    </style>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Include ag-Grid -->
	<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/ag-charts-enterprise@9.0.0/dist/umd/ag-charts-enterprise.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.noStyle.js"></script> -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/ag-charts-community@9.0.0/dist/umd/ag-charts-community.js"></script> -->
</head>
<body>
    <?php 
    include 'dbClass.php';
    $ReportID = 3144;// isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
    include 'reportModel.php';
    // echo $db[1];
    $ResultStruct = array();
    $EditableStruct = array();
    if(strlen($db[1]) > 2){
        $filterString = "";
        $separator = "|";
        foreach($_REQUEST as $name => $value) {
            if($name != "ReportID" && $name != "view" && $name != "formid" && $name != "Submit" ) {
                $filterString .= $name."=".$value.$separator;
            }
        }
        // echo "'".$filterString."'";
        $filterString = "quality=478|quality-text=Filafil|design=12179,12,8715,10083,12343,9763|design-text=253,254,256,264,259,258|username=tejas|";
        $SPresult = db::getInstance()->db_sp_select($db[1], array('@params'), array("'".$filterString."'"));
        $ResultSet = $SPresult['result_set'][0];        //['result_set'][0] should have the data 
        $ResultStruct = $SPresult['result_set'][1];     //['result_set'][1] should have the structure
        $ResultCnt = isset($ResultSet) ? sizeof($ResultSet) : 0;
        // print_r($SPresult);
    }
    $finalResult = array();
    $jsonData = "[";
    $separator = "";
    include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding
    for($i = 0; $i < $ResultCnt; $i++){
        foreach($ResultSet[$i] as $key => $value){
            //echo $key . "-";
            if(is_numeric($value)) {
                $valueINT = (float) $value;
                $finalResult[$i][$key] = $valueINT;
            } else {
                if ($value instanceof DateTime){
                    $finalResult[$i][$key] = ($value)->format('Y-m-d');
                }else{
                    $finalResult[$i][$key] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);//, Encoding::ICONV_TRANSLIT);
                }
            }
        }
    }
    // print_r($finalResult);
    
    if($ResultStruct == null) $ResultStruct = array();
    // echo json_encode(array($finalResult, $ResultStruct, $EditableStruct));
    
    ?>
    
    <!-- <h1>MasterDetail Individual cols</h1> -->
    <div id="myGrid" class="ag-theme-alpine" style="height: 100vh; width: 100%;"></div>
    <script src="data2.js"></script>
    <!-- <script src="DetailCellRenderer.js"></script> -->
    <!-- <script src="CostDetail.js"></script> -->
    <!-- <script src="SalesDetail.js"></script> -->
    <!-- <script src="OrdersFormDetail.js"></script> -->
    <!-- <script src="index.js"></script> -->
    <script>

        async function getData1(par, col) { 
            console.log("params", par, par.dsnoid)
            try {
                const response = await fetch('getDataForAGMasterDetail.php?col=' + col + '&DesignID='+ par.dsnoid );
                const data = await response.json();
                console.log('API->',data); 
                return data;
            } catch (error) {
                console.error('Error fetching data:', error);
                return [];
            }
        }

		class DetailGrid {
			constructor(params) {
				console.log("in DetailGrid Class", params)
				this.params = params;
                console.log("COLUMNS => ", params.context.selectedDetail)
				// this.rowData = await getData();
				// this.rowData = params.data.data;
				
				if (params.context.newRecords) {
					let continent = this.params.data.continent
					this.rowData = this.rowData.concat(
						params.context.newRecords[continent]
					);
				}
			}

			eGui() {
				var eTemp = document.createElement('div');
				eTemp.innerHTML = this.getTemplate();
				this.eGui = eTemp.firstElementChild;

				this.setupDetailGrid();
				return this.eGui;
			}

			async setupDetailGrid() {
                var apiResponse = await getData1(this.params.data, this.params.context.selectedDetail);
                if(apiResponse.data == null || apiResponse.data == undefined) {
                    $('.full-width-grid.ag-theme-alpine').html('<h3 style="text-align: center;">NO DATA</h3>');
                    return;
                }
                this.rowData = apiResponse.data;
                console.log(apiResponse);
                var dataStructure = apiResponse.Structure;

                let filterParams = {maxNumConditions:5};
                var dateFilterParams = {
                    comparator: (filterLocalDateAtMidnight, cellValue) => {
                        var dateAsString = cellValue;
                        if (dateAsString == null) return -1;
                        var dateParts = dateAsString.split("-");
                        var cellDate = new Date(cellValue);
                        console.log(cellDate);
                        if (filterLocalDateAtMidnight.getTime() === cellDate.getTime()) {
                            return 0;
                        }
                        if (cellDate < filterLocalDateAtMidnight) {
                            return -1;
                        }
                        if (cellDate > filterLocalDateAtMidnight) {
                            return 1;
                        }
                        return 0;
                    },
                    maxNumConditions:5,
                    minValidYear: 1980,
                    maxValidYear: 2040,
                    // inRangeFloatingFilterDateFormat: "Do MMM YYYY",
                    // valueFormatter: function (params) {
                    //     return moment(params.value).format('D MMM YYYY');
                    // },
                };
                var colDefs = [];
                const keys = Object.keys(dataStructure);
                keys.forEach(key => {
                    const dataType = dataStructure[key]['DATA_TYPE'];
                    const colName = dataStructure[key]['COLUMN_NAME'];
                    if(dataType == "int" || dataType == "bigint" || dataType == "float" || dataType == "decimal" || dataType == "money"){
                        colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agNumberColumnFilter', 'filterParams': filterParams});
                    }else if(dataType == "date" || dataType == "smalldatetime" || dataType == "datetime"){
                        colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agDateColumnFilter','filterParams': dateFilterParams,'valueFormatter': dateFormatter, 'comparator': dateComparator,});
                    }else{  //VARCHAR 
                        colDefs.push({ 'field': colName, 'colId':colName , 'cellDataType': 'text', 'filter':'agMultiColumnFilter', 'filterParams': filterParams});
                    }
                });
                console.log("ColDefs", colDefs)
				var detailGridOptions = {
                    columnDefs: colDefs,
					// columnDefs: [
					// 	{ field: 'lotno' },
					// 	{ field: 'pcs' },
					// 	{ field: 'balqty' },
					// 	{ field: 'design' },
					// 	{ field: 'quality' },
					// 	{ field: 'grade' },
					// 	{ field: 'Allot' },
					// 	{ field: 'godown' },

					// 	// { field: 'country', rowGroup: true },
					// 	// { field: 'sales', aggFunc: 'sum' },
					// 	// { field: 'cost' },
					// 	// { field: 'product', pivot: true },
					// ],
					defaultColDef: {
						flex: 1,
						minWidth: 150,
					},
					// pivotMode: true,
					rowData: this.rowData,
                    autoSizeStrategy: {
                        type: 'fitGridWidth',
                    }
				};
				var eDetailGrid = this.eGui.querySelector('.full-width-grid');
				// new agGrid.Grid(eDetailGrid, detailGridOptions);
				// this.detailGridApi = detailGridOptions.api;
				this.detailGridApi = agGrid.createGrid(eDetailGrid, detailGridOptions);
				var masterGridApi = this.params.api;
				var rowId = this.params.node.id;
				var gridInfo = {
					id: rowId,
					api: detailGridOptions.api,
					columnApi: detailGridOptions.columnApi,
				};
				masterGridApi.addDetailGridInfo(rowId, gridInfo);
			}

			getTemplate() {
				var template = `<div class="full-width-panel">
                    <div class="full-width-details"></div>
                    <div class="full-width-grid ag-theme-alpine"></div>
				</div>`;
				return template;
			}
		}

		class DetailCellRenderer {
			init(params) {
				console.log("in DetailCellRenderer Class")
				this.params = params;
				var colId = params.context.selectedDetail;
				// console.log(params)
                var setDetailGrid = new DetailGrid(params);
                this.eGui = setDetailGrid.eGui();
				// if (colId === "cost") {
                //     var costDetail = new CostDetail(params);
                //     this.eGui = costDetail.eGui();
				// } else if (colId === "orders") {
                //     var ordersFormDetail = new OrdersFormDetail(params);
                //     this.eGui = ordersFormDetail.eGui();
				// } else if (colId === "sales") {
                //     var salesDetail = new SalesDetail(params);
                //     this.eGui = salesDetail.eGui();
				// }
			}
			getGui() {
				return this.eGui;
			}
		}

		const treeOpen = 'https://raw.githubusercontent.com/LouisMoore-agGrid/js-ag-grid-52eyso/50413f659cdfbe903ec14d9a5d4b7cf175b76637/tree-open.svg';
		const treeClosed = 'https://raw.githubusercontent.com/LouisMoore-agGrid/js-ag-grid-52eyso/aacef9f45dae7ea5822c4b76bf1c981a74451435/tree-closed.svg';

		var columnDefs = [
			{ field: 'QUALITY' },
			{ field: 'DESIGN' },
			{ field: 'FAC_PCS' },
			{ field: 'FAC_MTRS', cellRenderer: (params) => makeMasterCellRenderer(params, 'FAC_MTRS') },
			{ field: 'PAC_PCS' },
			{ field: 'PAC_MTRS', cellRenderer: (params) => makeMasterCellRenderer(params, 'PAC_MTRS')  },
			{ field: 'ORD_MTRS', cellRenderer: (params) => makeMasterCellRenderer(params, 'ORD_MTRS')  },
			{ field: 'BAL_QTY' },
			{ field: 'DYG_PCS' },
			{ field: 'DYG_MTRS', cellRenderer: (params) => makeMasterCellRenderer(params, 'DYG_MTRS')  },
			{ field: 'FAC_PCS' },
			{ field: 'PO_MTRS', cellRenderer: (params) => makeMasterCellRenderer(params, 'PO_MTRS'), },
			{ field: 'BASE_DESIGN' },
			{ field: 'SIMILAR_DESIGN' },
			{ field: 'BASE_QUALITY' },
			{ field: 'SIMILAR_QUALITY' },
			{ field: 'dsnoid' },
		];

		const gridOptions = {
			columnDefs: columnDefs,
			detailRowAutoHeight: true,
			rowData: rowData, 
			masterDetail: true,
			detailCellRenderer: 'myDetailCellRenderer',
			components: {
				myDetailCellRenderer: DetailCellRenderer, 
			},
			context:{
				salesDetail:0,
				chevKeyMap: {},
			},
            autoSizeStrategy: {
                type: 'fitCellContents',
                // type: 'fitGridWidth',
            }
			// enableCharts: true,
			// enableRangeSelection: true,
		};

		function makeMasterCellRenderer(params, col) {
			console.log("in makeMasterCellRenderer", params)
			let isExpanded = params.node.expanded;
			let container = document.createElement('div');
			let chevron = document.createElement('img');
			let span = document.createElement('span');
			let openCol = null;

			chevron.classList.add(`row-${params.node.data.id}`);
			chevron.classList.add('pointer-class');
			container.classList.add('master-container');

			console.log("params.context", params.context)
			if (params.context) {
				openCol = params.context.chevKeyMap[chevron.className];
			}
			let chevronState = isExpanded && col === openCol ? treeOpen : treeClosed;
			chevron.setAttribute('src', chevronState);

			switch (col) {
				case 'orders':
					span.innerText = 'Orders Form';
					container.appendChild(chevron);
					break;
				default:
					span.innerText = params.value;
					container.appendChild(chevron);
					break;
			}

			chevron.addEventListener('click', (event) => {
				console.log("OPening")
				let chevron = event.target;
				openDetail(params, col, chevron);
			});

			container.appendChild(span);
			return container;
		}

		const openDetail = (params, column, cellRenderer) => {
			console.log("In Opendetail")
			if (
				gridOptions.context &&
				gridOptions.context.chevKeyMap[cellRenderer.className] === column &&
				params.node.expanded
			) {
				// console.log("==>>",gridOptions.context.chevKeyMap[cellRenderer.className])
				params.node.setExpanded(false);
				cellRenderer.setAttribute('src', treeClosed);
				return;
			}
			//  gridApi.setGridOption("context", { reportingCurrency: value });
			// gridOptions.context = { ...gridOptions.context, selectedDetail: column };
			gridApi.setGridOption("context", { selectedDetail: column });
			console.log(gridOptions)
			// console.log(gridApi)
			let className = '';
			cellRenderer.classList.forEach((cssClass) => {
				if (cssClass.indexOf('row') !== -1) {
					className = cssClass;
				}
			});
			let nodeRenderers = document.querySelectorAll(`.${className}`);
			nodeRenderers.forEach((renderer) => {
				renderer.setAttribute('src', treeClosed);
			});
			params.node.setExpanded(true);
			if (gridOptions.context.chevKeyMap) {
				gridOptions.context.chevKeyMap[cellRenderer.className] = column;
			} else {
				gridOptions.context.chevKeyMap = {};
				gridOptions.context.chevKeyMap[cellRenderer.className] = column;
			}
			cellRenderer.setAttribute('src', treeOpen);

			if (params.node.detailNode) {
				params.api.redrawRows({ rowNodes: [params.node.detailNode] });
			}
		};

		// new agGrid.Grid(document.querySelector('#myGrid'), gridOptions);
		// Initialize the grid using the new createGrid method
		const gridApi = agGrid.createGrid(document.querySelector('#myGrid'), gridOptions);

		// You can now use gridApi for further API calls
		// console.log(gridApi); // Example: logs the grid API object

	 </script>
</body>
</html>

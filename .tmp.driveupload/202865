<?php
  $filterCode = array();
  $ReportID = isset($_REQUEST['ReportID']) ? $_REQUEST['ReportID'] : 0;
  $SelectedTemplateID = isset($_REQUEST['SelectedTemplateID']) ? $_REQUEST['SelectedTemplateID'] : 0;
  $k_head_title="Report";
  $k_head_include = "";
  include "report-init-new.php";
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
      $url = "https://";   
  else  
      $url = "http://";  
  $url .= $_SERVER['HTTP_HOST'];   
  $url .= $_SERVER['REQUEST_URI'];
  $urlpos = strpos($url, '&', strpos($url, '&') + 1);
  $url = substr($url, 0, $urlpos) . "&ReportID=" . $ReportID;
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community@31.3.2/dist/ag-grid-community.js?t=1715777153731"></script> -->
<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.2.1/dist/ag-grid-enterprise.js?t=55198984654"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/ag-charts-enterprise@11.2.0/dist/umd/ag-charts-enterprise.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>


<style>
  /* .ag-row-even.ag-row-level-1.ag-full-width-row{
    overflow-y: auto;
  } 
  .ag-header {
    position: sticky;
    top: 0;
    z-index: 10;
  } */
  .ag-filter-active {
    :where(.ag-icon-filter) {
        /* clip-path: path("M8,0C8,4.415 11.585,8 16,8L16,16L0,16L0,0L8,0Z"); */
        color: #ffffff;
    }
  }
  .ag-filter-active {
    &:after {
        background-color: #ff0000;
    }
  }
  .editing-header{ background-color: #33639f; color: white;}
  .ag-root:not(.ag-detail-grid) .ag-header {
    /* .ag-header { */
      background-color: #09284e;
      color: white;
      text-transform: capitalize;
  }
   .ag-group-value { display: inline-flex; }
  #pivotgrid {
    margin-top: 20px;
  }

  .currency {
    text-align: center;
  }

  .dx-treeview-node .dx-checkbox {
    display: none;
  }
  span.cross-filter {
    cursor: pointer;
    margin-left: 4px;
    margin-right: 4px;
    background: #bfbfbf;
    padding: 0 5px;
    border-radius: 10px;
  }
  .filter-selected{
    background: #bebebe96;
    border-radius: 15px;
    padding: 0 0 0 8px;
    color: #424242;
    margin-right: 2px;
    margin-left: 2px; 
  }


  #selectedFiltersList div{
    display: flex;
  }
  .wrapper {
      display: flex;
      flex-direction: column;
      height: 100%;
  }

  #myGrid {
      flex: 1 1 auto;
        /* width: 1380px; */
      height:650px;
  }

  .my-chart {
    flex: 1 1 auto; 
    /* height: 100px; */
    /* width: 100px; */
  }
  .enlarged {
    width: 400px;
    height: 300px;
  }
  .ag-theme-balham{
    --ag-cell-horizontal-border: solid;
    --ag-odd-row-background-color: #eef2f2c9;
  }
  .ag-grid-custom-settings{
    width: 100%;
  }
  button.btn-secondary{
    width: 120px;
  }
  .switchbox{
    margin-left: 6px;
    margin-top: -7px;
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 4px;
      bottom: 3px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(24px);
      -ms-transform: translateX(24px);
      transform: translateX(24px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
  }
</style>
<style>
          .loader,
        .loader:after {
            border-radius: 50%;
            width: 10em;
            height: 10em;
        }
        .loader {            
            margin: 250px auto;
            font-size: 10px;
            position: relative;
            text-indent: -9999em;
            border-top: 1.1em solid rgba(255, 255, 255, 0.2);
            border-right: 1.1em solid rgba(255, 255, 255, 0.2);
            border-bottom: 1.1em solid rgba(255, 255, 255, 0.2);
            border-left: 1.1em solid #ffffff;
            -webkit-transform: translateZ(0);
            -ms-transform: translateZ(0);
            transform: translateZ(0);
            -webkit-animation: load8 1.1s infinite linear;
            animation: load8 1.1s infinite linear;
        }
        @-webkit-keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes load8 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        #loadingDiv {
            position:absolute;;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background-color:#00000012;
        }

</style>

<!-- SCRIPT FOR TYPE AND TEMPLATE -->
<script>
	var templateId = "0";
	var typeId="0";
  var tempName='' ;
  var templateDescription ='';
  var kreon =0;
  var tempName_for_modal;
  let call_for_template = false;
  let ogTemplateId;
  let pivotglobalsource=0;
  let templateg;
  let filterflag=false;
  let gridApi;
  let topg=0;
  let topfilters;
  let topsort;
  var pivotglobalstate;
  let agState;
  let h;
  let data = [];
  let allData = null;
  let allDataKeys = null;
  let DataStructure = null;
  let editableStructure = null;
  let DrillStructure = null;
  let gridOptions = null;
  let count=0;
  let toppivot = 0;
  let checkboxState = [];
  let storeColDefs = null;
  let SelectedTemplateID = <?php echo $SelectedTemplateID; ?>;

  // agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-059380}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{30 June 2024}____[v3]_[0102]_MTcxOTcwMjAwMDAwMA==59fc6bfa6d27f2fc6c8e0be66a04b355");
  //--workinglicense changed to the below on 11/03/2025 
  // agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-061119}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 July 2024}____[v3]_[0102]_MTcyMjM4MDQwMDAwMA==945278da60ff465f559911e628a1a59f"); //new
  agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-076336}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 March 2025}____[v3]_[0102]_MTc0MzM3NTYwMDAwMA==c6567fdb808acaba121aed5798506e61"); //new taken from ai mindforge

  // use on template selection
  function mergeTemplateState(freshDefs, savedState) {
  const savedMap = new Map(savedState.map(c => [c.colId, c]));

  return freshDefs.map(def => {
      const saved = savedMap.get(def.colId);
      if (!saved) return def;

      return {
        ...def,
        sort: saved.sort,
        width: saved.width,
        hide: saved.hide,
        pinned: saved.pinned,
        rowGroupIndex: saved.rowGroupIndex,
        aggFunc: saved.aggFunc,
        pivot: saved.pivot,
        pivotIndex: saved.pivotIndex,
      };
    });
  }

  $(document).ready(function () {
    var selectedType;
    $('.datagrid-display').hide(); // Hide datagrid-display initially
    $('.pivotgrid-display').hide(); // Hide pivotgrid-display initially
    $('.typeSelect').change(function () {
      $('#groupColumnIdsDiv').innerHTML="";
      $(".groupColumnIdsDiv").hide();

      $('#groupColumnIdsDivExpand').innerHTML="";
      $(".groupColumnIdsDivExpand").hide();

      checkboxState = [];
      console.log("pornima on document ready",checkboxState);
      selectedType = $(this).val();
      $('.datagrid-display').hide(); // Hide datagrid-display
      $('.pivotgrid-display').hide(); // Hide pivotgrid-display
      $("#templateSelect").val(''); // Clear template selection
      if (selectedType === "1") {
        $('.gridTemplate1').show(); // Show templates with TemplateTypeID 1 (Pivot Grid)
        $('.gridTemplate2').hide(); // Hide templates with TemplateTypeID 2 (Data Grid)
        // $('.pivotgrid-div').html('<div>   <div id="myGrid" style="width: 1380px; height: 590px" class="ag-theme-balham"></div></div>');
        // $('.pivotgrid-div').html('<div class="wrapper"><div id="myGrid" class="ag-theme-balham my-grid"></div><div id="myChart" class="ag-theme-balham my-chart"></div></div>');
        $('.pivotgrid-div').html('<div class="wrapper"> <div id="myGrid" class="ag-theme-balham my-grid"></div><div id="myChart" class="ag-theme-balham my-chart"></div></div>');
        $('.pivotgrid-display').show(); // Show pivotgrid-display if Pivot Grid is selected
        loadPivotGridData();
      } else if (selectedType === "2") {
        $('.gridTemplate1').hide(); // Hide templates with TemplateTypeID 1 (Pivot Grid)
        $('.gridTemplate2').show(); // Show templates with TemplateTypeID 2 (Data Grid)
      }
      // console.log("CHANGED TEMPLATE ID - " + typeId);
		  typeId = $("#typeSelect").val();
	  });
    $('.templateSelect').change(function () {
      $(".groupColumnIdsDiv").hide();
      $('#groupColumnIdsDiv').innerHTML="";

      $(".groupColumnIdsDivExpand").hide();
      $('#groupColumnIdsDivExpand').innerHTML="";

      $(".renameBtn").show();
      $(".deleteBtn").show();
      $(".updateBtn").show();
      $(".saveBtn").text('Save Template As');
      $(".copyBtn").show();
      $(".schdBtn").show();
      checkboxState = [];
      console.log("pornima on document ready1",checkboxState);
      // alert("1");
      if (selectedType === "1") {
        // $('.pivotgrid-div').html('<div id="myGrid" style="width: 1380px; height: 590px" class="ag-theme-balham"></div>');
        // $('.pivotgrid-div').html('<div class="wrapper"><div id="myGrid" class="ag-theme-balham my-grid"></div><div id="myChart" class="ag-theme-balham my-chart"></div></div>');
        $('.pivotgrid-div').html('<div class="wrapper"> <div id="myGrid" class="ag-theme-balham my-grid"></div><div id="myChart" class="ag-theme-balham my-chart"></div></div>');
        $('.pivotgrid-display').show(); // Show pivotgrid-display if Pivot Grid is selected
        $('.datagrid-display').hide(); // Hide datagrid-display
        $('.datagrid-div').html('');
        loadPivotGridData();
      } else if (selectedType === "2") {
        $('.datagrid-div').html('<div class="datagrid-display"><div class="dx-viewport"><div class="demo-container"><div id="gridContainer"></div><div id="scrolling-mode"></div><div id=editing-mode></div></div></div></div></div></div>');
        $('.datagrid-display').show(); // Show datagrid-display if Data Grid is selected
        $('.pivotgrid-display').hide(); // Hide pivotgrid-display 
        $('.pivotgrid-div').html('');
        loadDataGridData();
      }
      templateId = $("#templateSelect").val();
      ogTemplateId=templateId;

      // console.log("CHANGED TEMPLATE ID - " + templateId);
      tempName=$('#templateSelect').find('option:selected').text();
      console.log("tempname",tempName);
      gridApi.setGridOption("enableAdvancedFilter", false);
      
      getDataFromAPI(<?php echo $ReportID; ?>, templateId, tempName, templateDescription, typeId, (error, data) => {
        console.log("get data api", data);
        if (error) {
          console.error('Error fetching data:', error);
          // console.log("in if");
        } else {
            pivotglobalsource=data;
            
            // console.log("trty",pivotglobalsource);
            // console.log("Fetched",data.columns);
            $(".groupColumnIdsDiv").hide();
            $('#groupColumnIdsDiv').html("");

            $(".groupColumnIdsDivExpand").hide();
            $('#groupColumnIdsDivExpand').html("");

            checkboxState = [];
            console.log("pornima get data from api",checkboxState);
           
            // CHANGE FOR ADVANCED fILTER -2
            if(data.filter !== undefined){
              if (data.filter.advancedFilterModel) {
                gridApi.setGridOption("enableAdvancedFilter", true);
                $("#advanced-filter-switch").prop('checked', true);
                gridApi.setAdvancedFilterModel(data.filter.advancedFilterModel)
              }
            }
            templateg=0;
            topsort=pivotglobalsource;
            // FOR NORMAL FILTERS
            topfilters=0;
            if(data.filter != undefined){
              topfilters =data.filter.filterModel
              gridApi.setFilterModel(topfilters);
              // CHANGE FOR ADVANCED FILTER - 3
              if(topfilters)
                gridApi.setGridOption("enableAdvancedFilter", false);
            }
            // console.log("DrillStructure", DrillStructure)
            if(DrillStructure.length == 0){
              toppivot = data.pivot;
              // console.log("Top Pivot in Template Select", toppivot);
              if(toppivot){
                gridApi.setGridOption("pivotMode", toppivot.pivotMode);
              }
              checkboxState = data.checkboxState;
              let CB_rowGroupID = [];
              // console.log("CB State=> ", checkboxState, CB_rowGroupID);
              if(pivotglobalsource.rowGroup)
                CB_rowGroupID = pivotglobalsource.rowGroup.groupColIds;
              // checkboxState = CB_rowGroupID;
              console.log("CB State=> ", checkboxState, CB_rowGroupID);
              if(checkboxState){
                checkboxState.forEach(([id, checked]) => {
                    const checkbox = document.getElementById(id);
                    console.log(checkbox, checked)
                    if (checkbox) {
                        checkbox.checked = checked; // Check/uncheck based on the value
                    } 
                });
              }
              console.log("Test1",checkboxState);
              
              // console.log("sort",pivotglobalsource.sort);
              // console.log("in getdatafrom Api in ongrid Ready",topfilters,tempName);
              gridApi.closeToolPanel();
              gridApi.applyColumnState({ 
                  state: data.columns,
                  applyOrder: true,
              });

              // gridApi.setGridOption('columnDefs', data.columnDefs);

              const mergedDefs = mergeTemplateState(gridApi.getColumnDefs(), data.columns);
              gridApi.setGridOption('columnDefs',mergedDefs);

              // RESTORE CHARTS (if template contains chartModels)
              if (data.chartModels && data.chartModels.length > 0) {
                  console.log("Restoring charts from template:", data.chartModels);

                  // Delay required because grid must fully re-render first
                  setTimeout(() => {
                      data.chartModels.forEach(model => {
                          try {
                              gridApi.restoreChart(model);
                              console.log("Chart restored:", model.chartId || model);
                          } catch (err) {
                              console.error("Error restoring chart:", err, model);
                          }
                      });
                  }, 250);
              }
            
              // if (data.rowGroupExpansion?.expandedRowGroupIds) {
              //     gridApi.forEachNode(node => {
              //         if (node.group) {
              //           // console.log('2nd expandedRowGroupIds', node)
              //           const shouldExpand = data.rowGroupExpansion.expandedRowGroupIds.includes(node.id);
              //           node.setExpanded(shouldExpand); // Expand only if it was expanded before
              //         }
              //     });
              // }else{
              //   gridApi.collapseAll();
              // }

              //repeatParent checkbox check on the basis of value
              if (data.repeatParent !== undefined) {
                repeatParentvalue = data.repeatParent;
                if(repeatParentvalue == 1){
                  gridApi.setGridOption("showOpenedGroup", true);
                }else{
                  gridApi.setGridOption("showOpenedGroup", false);
                }

                setOpenedGroupOnRepeatParentValue(repeatParentvalue);
                
              }

              //showGrandTotal checkbox check on the basis of value
              if (data.showGrandTotal !== undefined) {
                grandTotalValue = data.showGrandTotal;
                if(grandTotalValue == 1){
                   $("#showGrandTotal").prop('checked', true);
                  // gridApi.setGridOption("showOpenedGroup", true);
                }else{
                   $("#showGrandTotal").prop('checked', false);
                  // gridApi.setGridOption("showOpenedGroup", false);
                }
              }

              //groupDisplayType set here
              if (data.groupDisplayType != '' && data.groupDisplayType != undefined && data.groupDisplayType != null) {
                gridApi.setGridOption("groupDisplayType", data.groupDisplayType);
                gridApi.setGridOption("pivotMode", data.groupDisplayType === 'multipleColumn' ? true : false);
                $('#groupDisplayType').val(data.groupDisplayType);
                $('#group_display_type').val(data.groupDisplayType);
                gridApi.setGridOption('groupHideOpenParents',data.groupDisplayType === 'multipleColumn' ? true : false);
              }else{
                gridApi.setGridOption("groupDisplayType", 'multipleColumns');
                $('#groupDisplayType').val('multipleColumns');
                $('#group_display_type').val(data.groupDisplayType);
                gridApi.setGridOption('groupHideOpenParents',true);
              }

              $('#pdf_size').val(data.pdf_size);
              $('#pdfSizeclassSelector').val(data.pdf_size);
              $('#pdf_orientation').val(data.pdf_orientation);
              $('#pdfOrientationclassSelector').val(data.pdf_orientation);
              $('#pdf_imgw').val(data.pdf_imgw);
              $('#pdfImgwclassSelector').val(data.pdf_imgw);
              $('#pdf_font_size').val(data.pdf_font_size);
              $('#pdfFontSizeclassSelector').val(data.pdf_font_size);
              $('#pdf_cell_padding').val(data.pdf_cell_padding);
              $('#pdfCellPaddingclassSelector').val(data.pdf_cell_padding);

            }
        }
        console.log('gridOptions template',gridOptions)
      });
      
    });
    $('.typeSelect').val('1').trigger('change');
  });

</script>

<script>

  /**CHAT GPT FOR Export Btn 2 *
  function calculateCustomTotals() {
    const groupKeys = {}; // Object to store aggregated totals by group key

    // Iterate over each row node to calculate totals
    gridApi.forEachNodeAfterFilterAndSort(node => {
      if (node.group) {
        // Group node
        const groupKey = node.key; // Key of the current group
        const groupData = node.aggData; // Aggregated data (totals) for the group

        if (!groupKeys[groupKey]) {
          groupKeys[groupKey] = {
            data: [], // Array to hold rows of current group
            totals: {}, // Object to store totals for current group
          };
        }

        // Push current node's data to group's data array
        groupKeys[groupKey].data.push(node.data);

        // Calculate totals for each column
        Object.keys(groupData).forEach(field => {
          if (typeof groupData[field] === 'number') {
            if (!groupKeys[groupKey].totals[field]) {
              groupKeys[groupKey].totals[field] = 0;
            }
            groupKeys[groupKey].totals[field] += groupData[field];
          }
        });
      }
    });
      console.log(groupKeys);
    return groupKeys;
  }

  function exportGridDataToPdf(gridApi) {
    const columnDefs = gridOptions.columnDefs;

    const groupKeys = calculateCustomTotals();

    const columnHeaders = columnDefs.map(colDef => ({ text: colDef.headerName }));

    const rowData = [];
    Object.keys(groupKeys).forEach(groupKey => {
      console.log(groupKey)
      // Add group data rows
      groupKeys[groupKey].data.forEach(data => {
        const row = [];
        columnHeaders.forEach(header => {
          row.push({ text: data[header.text.toLowerCase()] });
        });
        rowData.push(row);
      });

      // Add totals row
      const totalsRow = [];
      columnHeaders.forEach(header => {
        const field = header.text.toLowerCase();
        if (groupKeys[groupKey].totals[field] !== undefined) {
          totalsRow.push({ text: groupKeys[groupKey].totals[field].toString() });
        } else {
          totalsRow.push({ text: '' }); // Empty cell for non-numeric columns
        }
      });
      rowData.push(totalsRow);
    });
    console.log(rowData);
    const docDefinition = {
      content: [
        { text: 'Ag-Grid Export to PDF with Custom Totals', style: 'header' },
        {
          table: {
            headerRows: 1,
            widths: columnDefs.map(colDef => 'auto'),
            body: [
              columnHeaders.map(header => ({ text: header.text, style: 'tableHeader' })),
              ...rowData
            ]
          }
        }
      ],
      styles: {
        header: {
          fontSize: 18,
          bold: true,
          alignment: 'center',
          margin: [0, 0, 0, 20]
        },
        tableHeader: {
          bold: true,
          fontSize: 12,
          color: 'black',
          fillColor: '#f0f0f0'
        }
      }
    };

    const pdfDoc = pdfMake.createPdf(docDefinition);
    pdfDoc.download('grid-export.pdf');
  }
  */


  /*
    function getHeaderToExport(gridApi) {
      var columns = gridApi.getAllDisplayedColumns();
      return columns.map(function(column) {
          var field = column.getColDef().field;
          var sort = column.getSort();
          var headerName = column.getColDef().headerName || field;
          var headerNameUppercase = headerName ? headerName[0].toUpperCase() + headerName.slice(1) : '';
          var headerCell = {
              text: headerNameUppercase + (sort ? " (" + sort + ")" : ""),
              bold: true,
              margin: [0, 12, 0, 0]
          };
          return headerCell;
      });
    }

    function convertImageToDataUR1L(url, callback) {
      var img = new Image();
      img.crossOrigin = 'Anonymous';
      img.onload = function() {
          var canvas = document.createElement('canvas');
          canvas.width = this.width;
          canvas.height = this.height;
          var ctx = canvas.getContext('2d');
          ctx.drawImage(this, 0, 0);
          var dataURL = canvas.toDataURL('image/png');
          callback(dataURL);
      };
      img.onerror = function() {
          callback(null);
      };
      img.src = "https://wsrv.nl/?url=" + url;
    }
    function convertImageToDataURL(url) {
        return new Promise((resolve, reject) => {
            var proxyUrl = "https://wsrv.nl/?url=" + encodeURIComponent(url);
            var img = new Image();
            img.crossOrigin = 'Anonymous';
            img.onload = function() {
                var canvas = document.createElement('canvas');
                canvas.width = this.width;
                canvas.height = this.height;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(this, 0, 0);
                var dataURL = canvas.toDataURL('image/png');
                console.log("resolving", dataURL);
                resolve(dataURL);
            };
            img.onerror = function() {
                console.log("resolving error", url);
                resolve(null);
            };
            img.src = proxyUrl;
            console.log("resolving promise", img.src);
        });
    }


    function getRowsToExportPivot(gridApi) {
        var columns = gridApi.getAllDisplayedColumns();
        var getCellToExport = function(column, node) {
          var columnName = column.getColDef().headerName || '';
          var value = gridApi.getValue(column, node) || '';
          if (columnName.includes('IMG_') && value.includes('http')) {
            console.log(columnName, "adding image =>", value);
            return convertImageToDataURL(value).then(dataURL => ({
                image: dataURL,
                ...column.getColDef().cellStyle
            }));
              // convertImageToDataURL(value, function(dataURL) {
              //     callback({
              //         image: "https://wsrv.nl/?url=" + dataURL,
              //         ...column.getColDef().cellStyle
              //     });
              // });
          } else {
            return {
                  text: value,
                  ...column.getColDef().cellStyle
              };
          }
        };


      // var getCellToExport = function(column, node) {
      //     return {
      //         text: gridApi.getValue(column, node) || '',
      //         ...column.getColDef().cellStyle
      //     };
      // };

      var totalRowGroups = $('input.rowGrpTtl').length;
      var totalRowGroupsChecked = $('input.rowGrpTtl:checked').length;
      // console.log(totalRowGroups, totalRowGroupsChecked);

      var rowsToExport = [];
      var totalRows = [];
      
      const columnLength = columns.length;
      var stackRows = [];
      var stack = [];
      var stackTotalRows = [];
      var stackTotalRowsField = [];
      var grandTotal = new Array(columnLength).fill(0);
      var maxTotalCols = -1;
      var totalRowLast = [];
      // console.log(grandTotal);

      gridApi.forEachNodeAfterFilterAndSort(function(node) {
          var rowToExport = columns.map(function(column) {
              // console.log("rowToExport=>", getCellToExport(column, node))
              return getCellToExport(column, node);
          });
          console.log("rowToExport=>" );
          console.log( rowToExport);
          if(node.group){
              stack.push(node.allChildrenCount)
              //PUSH ONLY IF THE checkbox is selected
              stackTotalRows[node.level] = rowToExport;
              stackTotalRowsField[node.level] = node.field;
              if(node.level > maxTotalCols)   maxTotalCols = node.level;
              // console.log("max", maxTotalCols);
              if(node.level == 0) {
                  //for grand Total
                  for(var i = maxTotalCols; i < columnLength; i++){
                      // console.log(i, rowToExport[i].text, isNumeric(rowToExport[i].text))
                      if(isNumeric(rowToExport[i].text))
                          grandTotal[i] += rowToExport[i].text;
                  }
                  // console.log(grandTotal, rowToExport);
              }
          }else{
              stackRows.push(rowToExport)
              // console.log("Final Row: ", rowToExport);

              if(stack.length > 0){
                  //for deducting the pushed row count
                  for(var i = 0; i < stack.length; i++){
                      stack[i] = stack[i] - 1;
                  }
                  //
                  for(var i = stack.length - 1 ; i >= 0; i--){
                      if(stack[i] <= 0){
                          var tmp = stack.pop();
                          var tmp1 = stackTotalRows.pop();
                          var tmp2 = stackTotalRowsField.pop();
                          //if checkboxstate total rows are displayed, then show the total rows
                          if($("#groupColumnIdsDiv #" + tmp2).is(":checked")){
                              var totalText = tmp1[i].text;
                              for(var j = 0; j < tmp1.length; j++){
                                  tmp1[j].bold = true;
                                  if(j <= i)
                                      tmp1[j].text = '';
                              }
                              tmp1[i].text = 'Total ' + totalText;
                              stackRows.push(tmp1)
                              console.log("Popped", tmp2, tmp1)
                              // totalRowLast = tmp1;
                          }
                      }else{
                          break;
                      }
                  }
              }
          }
          // console.log(node.group, node.allChildrenCount, stack, stackRows, rowToExport, node);
          // console.log("=> ", node.group, node.allChildrenCount, node.footer);
          // console.log("Total Row: ", rowToExport);
          // // Check if the node is a total row
          // if (node.group || node.allChildrenCount || node.footer) {
          //     // console.log("=> ", node.group, node.allChildrenCount, node.footer);
          //     // console.log("Total Row: ", rowToExport);
          //     totalRows.push(rowToExport);
          // } else {
          //     rowsToExport.push(rowToExport);
          // }
      });

      // console.log("Stack", stackRows)
      for(var i = 0; i < columnLength; i++){
          var t = new Object();
          if(grandTotal[i] !== 0)
              t.text = grandTotal[i]; 
              // totalRowLast[i]['text'] = grandTotal[i]; 
          else
              t.text = '';
              // totalRowLast[i]['text'] = ''; 
          t.bold = true;
          // totalRowLast[i]['bold'] = true; 
          totalRowLast.push(t);
      }
      totalRowLast[0].text = "GRAND TOTAL";
      // console.log("Stack", stackRows)
      // console.log("Grd Total", totalRowLast)
      return stackRows.concat(new Array(totalRowLast));
      // Concatenate totalRows at the end of rowsToExport
      // return rowsToExport.concat(totalRows);
  }

  function getRowsToExport(gridApi) {
      if (gridApi.isPivotMode()) {
          return getRowsToExportPivot(gridApi);
      }
      var columns = gridApi.getAllDisplayedColumns();
      var getCellToExport = function(column, node) {
          return {
              text: gridApi.getValue(column, node) || '',
              ...column.getColDef().cellStyle
          };
      };
      var rowsToExport = [];
      gridApi.forEachNodeAfterFilterAndSort(function(node) {
          var rowToExport = columns.map(function(column) {
              return getCellToExport(column, node);
          });
          rowsToExport.push(rowToExport);
      });
      return rowsToExport;
  }

  var HEADER_ROW_COLOR = '#ccc';
  var EVEN_ROW_COLOR = '#f8f8f8';
  var ODD_ROW_COLOR = '#fff';
  var PDF_INNER_BORDER_COLOR = '#dde2eb';
  var PDF_OUTER_BORDER_COLOR = '#babfc7';

  function createLayout(numberOfHeaderRows) {
      return {
          fillColor: function(rowIndex) {
              if (rowIndex < numberOfHeaderRows) {
                  return HEADER_ROW_COLOR;
              }
              return rowIndex % 2 === 0 ? EVEN_ROW_COLOR : ODD_ROW_COLOR;
          },
          vLineWidth: function(rowIndex, node) {
              return 1;
          },
          hLineColor: function(rowIndex, node) {
              return rowIndex === 0 || rowIndex === node.table.body.length ? PDF_OUTER_BORDER_COLOR : PDF_INNER_BORDER_COLOR;
          },
          vLineColor: function(rowIndex, node) {
              return rowIndex === 0 || rowIndex === node.table.widths.length ? PDF_OUTER_BORDER_COLOR : PDF_INNER_BORDER_COLOR;
          }
      };
  }

  function getDocument(gridApi) {
      var columns = gridApi.getAllDisplayedColumns();
      var headerRow = getHeaderToExport(gridApi);
      var rows = getRowsToExport(gridApi);
      console.log("Header Row", headerRow);
      console.log("Rows")
      console.log(rows)
      var title = $(".page-header h2").html();
      var subtitle = "(" + $(".templateSelect option:selected").text() + ")";
      var widthArray = Array(columns.length).fill('auto');
      widthArray[0] = '*';
      widthArray[1] = '*';
      widthArray[2] = '*';

      return {
          pageSize: $('#pdf_size').val(),
          pageOrientation: $('#pdf_orientation').val(),
          header: 'simple text',
          footer: {
              columns: [
                  { text: '<?php echo "Report generated from AI-ERP at - " . date("jS F Y h:i:s A"); ?>', alignment: 'right', fontSize: 9, color: '#a0a0a0', margin: [0, 0, 20, 0] }
              ]
          },
          content: [
              { text: title, fontSize: 18, bold: true, style: 'header', alignment: 'center' },
              { text: subtitle, fontSize: 14, style: 'header', alignment: 'center' },
              {
                  border: [true, true, true, true],
                  table: {
                      dontBreakRows: true,
                      headerRows: 1,
                      widths: widthArray,
                      body: [headerRow].concat(rows),
                      heights: function(rowIndex) {
                          return rowIndex === 0 ? 40 : 15;
                      }
                  },
                  layout: createLayout(1)
              }
          ],
          pageMargins: [10, 10, 10, 15]
      };
  }

  function exportToPDF(gridApi) {
      var doc = getDocument(gridApi);
      pdfMake.createPdf(doc).download(tempName || 'download.pdf');
  }
  */

  

  var isNumeric = function(num){
      return (typeof(num) === 'number' || typeof(num) === "string" && num.trim() !== '') && !isNaN(num);  
  }
  
  var HEADER_ROW_COLOR = '#ccc';
  var EVEN_ROW_COLOR = '#f8f8f8';
  var ODD_ROW_COLOR = '#fff';
  var PDF_INNER_BORDER_COLOR = '#dde2eb';
  var PDF_OUTER_BORDER_COLOR = '#babfc7';

  function convertImageToDataURL(url) {
        return new Promise((resolve, reject) => {
            var proxyUrl = "https://wsrv.nl/?url=<?php echo URL_ROOT;?>" + encodeURIComponent(url);
            var img = new Image();
            img.crossOrigin = 'Anonymous';
            img.onload = function() {
                var canvas = document.createElement('canvas');
                canvas.width = this.width;
                canvas.height = this.height;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(this, 0, 0);
                var dataURL = canvas.toDataURL('image/png');
                // console.log("resolving", dataURL);
                resolve(dataURL);
            };
            img.onerror = function() {
                // console.log("resolving error", url);
                resolve(null);
            };
            img.src = proxyUrl;
            // console.log("resolving promise", img.src);
        });
  }

  
  function getHeaderToExport(gridApi) {
    var columns = gridApi.getAllDisplayedColumns();
    return columns.map(function(column) {
        var field = column.getColDef().field;
        var sort = column.getSort();
        var headerName = column.getColDef().headerName || field;
        var headerNameUppercase = headerName ? headerName[0].toUpperCase() + headerName.slice(1) : '';
        var headerPivot = column.getColDef().pivotKeys ?? "";
        if(headerPivot){
          headerNameUppercase = headerPivot[0] + " > " + headerNameUppercase;
        }
        var headerCell = {
            text: headerNameUppercase + (sort ? " (" + sort + ")" : ""),
            bold: true,
            margin: [0, 12, 0, 0]
        };
        return headerCell;
    });
  }
  
  function createLayout(numberOfHeaderRows) {
      return {
          fillColor: function(rowIndex) {
              if (rowIndex < numberOfHeaderRows) {
                  return HEADER_ROW_COLOR;
              }
              return rowIndex % 2 === 0 ? EVEN_ROW_COLOR : ODD_ROW_COLOR;
          },
          vLineWidth: function(rowIndex, node) {
              return 1;
          },
          hLineColor: function(rowIndex, node) {
              return rowIndex === 0 || rowIndex === node.table.body.length ? PDF_OUTER_BORDER_COLOR : PDF_INNER_BORDER_COLOR;
          },
          vLineColor: function(rowIndex, node) {
              return rowIndex === 0 || rowIndex === node.table.widths.length ? PDF_OUTER_BORDER_COLOR : PDF_INNER_BORDER_COLOR;
          }
      };
  }

  async function getRowsToExportPivot(gridApi) {
      var columns = gridApi.getAllDisplayedColumns();

      var getCellToExport = async function(column, node) {
          var columnName = column.getColDef().headerName || '';
          // console.log("Mitesh",columnName,column,node)
          var value = ''; //gridApi.getValue(column, node) || '';
          // console.log(columnName);
          if (columnName.includes('IMG_')) {
            // console.log('inside img_');
            if(value.includes('http')){
              // console.log('inside http');
              try {
                  const dataURL = await convertImageToDataURL(value);
                  // console.log(dataURL)
                  if (!dataURL) throw new Error('Data URL is null');
                  return {
                      image: dataURL,
                      width: parseInt($('#pdf_imgw').val()) || 50,
                      height: parseInt($('#pdf_imgw').val()) || 50,
                      ...column.getColDef().cellStyle
                  };
              } catch (error) {
                  console.error("Image conversion failed for URL:", value, error);
                  return {
                      text: "-",
                      ...column.getColDef().cellStyle
                  };
              }
            } else {
                return {
                    text: "-",
                    ...column.getColDef().cellStyle
                };
            }
          } else {
              return {
                  text: value,
                  ...column.getColDef().cellStyle
              };
          }
      };

      
      // width: $('#pdf_imgw').val() || 50,
      // height: $('#pdf_imgw').val() || 50,

      var totalRowGroups = $('input.rowGrpTtl').length;
      var totalRowGroupsChecked = $('input.rowGrpTtl:checked').length;

      var rowsToExport = [];
      var totalRows = [];

      const columnLength = columns.length;
      var stackRows = [];
      var stack = [];
      var stackTotalRows = [];
      var stackTotalRowsField = [];
      var grandTotal = new Array(columnLength).fill(0);
      var maxTotalCols = -1;
      var totalRowLast = []; 

      var processNode = async function(node) {
          var rowToExport = await Promise.all(columns.map(async function(column) {
              return await getCellToExport(column, node);
          }));
          rowToExport = rowToExport.map(cell => cell || { text: '', bold: false });
          // console.log("rowToExport=>", rowToExport);

          if (node.group) {
              stack.push(node.allChildrenCount);
              stackTotalRows[node.level] = rowToExport;
              stackTotalRowsField[node.level] = node.field;
              if (node.level > maxTotalCols) maxTotalCols = node.level;
              if (node.level == 0) {
                  for (var i = maxTotalCols; i < columnLength; i++) {
                      if (isNumeric(rowToExport[i].text)) grandTotal[i] += rowToExport[i].text;
                  }
              }
          } else {
              stackRows.push(rowToExport);
              // console.log("rowToExport pushed");
              if (stack.length > 0) {
                  for (var i = 0; i < stack.length; i++) {
                      stack[i] = stack[i] - 1;
                  }
                  for (var i = stack.length - 1; i >= 0; i--) {
                    if (stack[i] <= 0) {
                      var tmp = stack.pop();
                      var tmp1 = stackTotalRows.pop();
                      var tmp2 = stackTotalRowsField.pop();
                      // console.log(tmp2)
                      // console.log("len: ", $("#groupColumnIdsDiv #" + tmp2).length)
                      if($("#groupColumnIdsDiv #" + tmp2).length){
                        if ($("#groupColumnIdsDiv #" + tmp2).is(":checked")) {
                            var totalText = tmp1[i].text;
                            for (var j = 0; j < tmp1.length; j++) {
                                tmp1[j].bold = true;
                                if (j <= i) tmp1[j].text = '';
                            }
                            tmp1[i].text = 'Total ' + totalText;
                            // console.log("rowToExport Total=>", tmp1);
                            stackRows.push(tmp1);
                            // console.log("Popped", tmp2, tmp1);
                        }
                      }

                      if($("#groupColumnIdsDivExpand #" + tmp2).length){
                        if ($("#groupColumnIdsDivExpand #" + tmp2).is(":checked")) {
                            var totalText = tmp1[i].text;
                            for (var j = 0; j < tmp1.length; j++) {
                                tmp1[j].bold = true;
                                if (j <= i) tmp1[j].text = '';
                            }
                            tmp1[i].text = 'Total ' + totalText;
                            // console.log("rowToExport Total=>", tmp1);
                            stackRows.push(tmp1);
                            // console.log("Popped", tmp2, tmp1);
                        }
                      }
                    } else {
                        break;
                    }
                  }
              }
          }
      };

      // Iterate over nodes using forEachNodeAfterFilterAndSort
      var nodes = [];
      gridApi.forEachNodeAfterFilterAndSort(function(node) {
          nodes.push(node);
      });

      for (let node of nodes) {
          await processNode(node);
      }

      for (var i = 0; i < columnLength; i++) {
          var t = {};
          t.text = grandTotal[i] !== 0 ? grandTotal[i] : '';
          t.bold = true;
          totalRowLast.push(t);
      }
      totalRowLast[0].text = "GRAND TOTAL";

      return stackRows.concat([totalRowLast]);
  }

  async function getRowsToExport(gridApi) {
      if (gridApi.isPivotMode()) {
          return await getRowsToExportPivot(gridApi);
      }
      var columns = gridApi.getAllDisplayedColumns();
      // var getCellToExport = async function(column, node) {
      //     return {
      //         text: gridApi.getValue(column, node) || '',
      //         ...column.getColDef().cellStyle
      //     };
      // };
      // var getCellToExport = async function(column, node) {
      //     return {
      //         text: node.data[column.colId] || '',
      //         ...column.getColDef().cellStyle
      //     };
      // };
      var getCellToExport = async function(column, node) {
          return {
              text: column.getColDef().valueGetter
                  ? column.getColDef().valueGetter({ data: node.data, node: node })
                  : '',
              ...column.getColDef().cellStyle
          };
      };
      var rowsToExport = [];
      var nodes = [];
      gridApi.forEachNodeAfterFilterAndSort(function(node) {
          nodes.push(node);
      });

      for (let node of nodes) {
          var rowToExport = await Promise.all(columns.map(async function(column) {
              return await getCellToExport(column, node);
          }));
          rowToExport = rowToExport.map(cell => cell || { text: '', bold: false });
          rowsToExport.push(rowToExport);
      }
      return rowsToExport;
  }

  /*
    async function getRowsToExportPivot(gridApi) {
        var columns = gridApi.getAllDisplayedColumns();

        var getCellToExport = async function(column, node) {
            var columnName = column.getColDef().headerName || '';
            //var value = gridApi.getValue(column, node) || '';
            var value = '';  // Initialize value

            // Access the value of the cell directly from node.data or use a valueGetter
            if (column.getColDef().valueGetter) {
                // If the column has a custom valueGetter, use it
                value = column.getColDef().valueGetter({ data: node.data }) || '';
            } else {
                // Otherwise, access the value directly from the row data
                value = node.data[column.getColId()] || '';  // Using column.getColId() to access the correct column's data
            }
            console.log(columnName);
            if (columnName.includes('IMG_')) {
              // console.log('inside img_');
              if(value.includes('http')){
                // console.log('inside http');
                try {
                    const dataURL = await convertImageToDataURL(value);
                    // console.log(dataURL)
                    if (!dataURL) throw new Error('Data URL is null');
                    return {
                        image: dataURL,
                        width: parseInt($('#pdf_imgw').val()) || 50,
                        height: parseInt($('#pdf_imgw').val()) || 50,
                        ...column.getColDef().cellStyle
                    };
                } catch (error) {
                    console.error("Image conversion failed for URL:", value, error);
                    return {
                        text: "-",
                        ...column.getColDef().cellStyle
                    };
                }
              } else {
                  return {
                      text: "-",
                      ...column.getColDef().cellStyle
                  };
              }
            } else {
                return {
                    text: value,
                    ...column.getColDef().cellStyle
                };
            }
        };

        
        // width: $('#pdf_imgw').val() || 50,
        // height: $('#pdf_imgw').val() || 50,

        var totalRowGroups = $('input.rowGrpTtl').length;
        var totalRowGroupsChecked = $('input.rowGrpTtl:checked').length;

        var rowsToExport = [];
        var totalRows = [];

        const columnLength = columns.length;
        var stackRows = [];
        var stack = [];
        var stackTotalRows = [];
        var stackTotalRowsField = [];
        var grandTotal = new Array(columnLength).fill(0);
        var maxTotalCols = -1;
        var totalRowLast = []; 

        var processNode = async function(node) {
            var rowToExport = await Promise.all(columns.map(async function(column) {
                return await getCellToExport(column, node);
            }));
            rowToExport = rowToExport.map(cell => cell || { text: '', bold: false });
            console.log("rowToExport=>", rowToExport);

            if (node.group) {
                stack.push(node.allChildrenCount);
                stackTotalRows[node.level] = rowToExport;
                stackTotalRowsField[node.level] = node.field;
                if (node.level > maxTotalCols) maxTotalCols = node.level;
                if (node.level == 0) {
                    for (var i = maxTotalCols; i < columnLength; i++) {
                        if (isNumeric(rowToExport[i].text)) grandTotal[i] += rowToExport[i].text;
                    }
                }
            } else {
                stackRows.push(rowToExport);
                console.log("rowToExport pushed");
                if (stack.length > 0) {
                    for (var i = 0; i < stack.length; i++) {
                        stack[i] = stack[i] - 1;
                    }
                    for (var i = stack.length - 1; i >= 0; i--) {
                      if (stack[i] <= 0) {
                        var tmp = stack.pop();
                        var tmp1 = stackTotalRows.pop();
                        var tmp2 = stackTotalRowsField.pop();
                        console.log(tmp2)
                        console.log("len: ", $("#groupColumnIdsDiv #" + tmp2).length)
                        if($("#groupColumnIdsDiv #" + tmp2).length){
                          if ($("#groupColumnIdsDiv #" + tmp2).is(":checked")) {
                              var totalText = tmp1[i].text;
                              for (var j = 0; j < tmp1.length; j++) {
                                  tmp1[j].bold = true;
                                  if (j <= i) tmp1[j].text = '';
                              }
                              tmp1[i].text = 'Total ' + totalText;
                              console.log("rowToExport Total=>", tmp1);
                              stackRows.push(tmp1);
                              console.log("Popped", tmp2, tmp1);
                          }
                        }
                      } else {
                          break;
                      }
                    }
                }
            }
        };

        // Iterate over nodes using forEachNodeAfterFilterAndSort
        var nodes = [];
        gridApi.forEachNodeAfterFilterAndSort(function(node) {
            nodes.push(node);
        });

        for (let node of nodes) {
            await processNode(node);
        }

        for (var i = 0; i < columnLength; i++) {
            var t = {};
            t.text = grandTotal[i] !== 0 ? grandTotal[i] : '';
            t.bold = true;
            totalRowLast.push(t);
        }
        totalRowLast[0].text = "GRAND TOTAL";

        return stackRows.concat([totalRowLast]);
    }

    async function getRowsToExport(gridApi) {
        if (gridApi.isPivotMode()) {
            return await getRowsToExportPivot(gridApi);
        }
        var columns = gridApi.getAllDisplayedColumns();
        var getCellToExport = async function(column, node) {
          var columnName = column.getColDef().headerName || '';
          var value = '';  // Initialize value

          // Use valueGetter if defined in the column
          if (column.getColDef().valueGetter) {
              value = column.getColDef().valueGetter({ data: node.data }) || '';
          } else {
              // Otherwise, access the value directly from the row data using column.getColId()
              value = node.data[column.getColId()] || '';
          }

          console.log(columnName, value);

          return {
              text: value,  // Return the value for the cell
              ...column.getColDef().cellStyle // Apply any column cell styling (like font color, etc.)
          };
        };
        // var getCellToExport = async function(column, node) {
        //     return {
        //         text: gridApi.getValue(column, node) || '',
        //         ...column.getColDef().cellStyle
        //     };
        // };
        var rowsToExport = [];
        var nodes = [];
        gridApi.forEachNodeAfterFilterAndSort(function(node) {
            nodes.push(node);
        });

        for (let node of nodes) {
            var rowToExport = await Promise.all(columns.map(async function(column) {
                return await getCellToExport(column, node);
            }));
            rowToExport = rowToExport.map(cell => cell || { text: '', bold: false });
            rowsToExport.push(rowToExport);
        }
        return rowsToExport;
    }
  */

  async function getDocument(gridApi) {
      var columns = gridApi.getAllDisplayedColumns();
      var headerRow = getHeaderToExport(gridApi);
      var rows = await getRowsToExport(gridApi);
      // console.log("Header Row", headerRow);
      // console.log("Rows", rows);
      var title = $(".page-header h2").html();
      var subtitle = "(" + $(".templateSelect option:selected").text() + ")";
      var widthArray = Array(columns.length).fill('auto');
      widthArray[0] = '*';
      widthArray[1] = '*';
      widthArray[2] = '*';

      return {
          pageSize: $('#pdf_size').val(),
          pageOrientation: $('#pdf_orientation').val(),
          header: 'simple text',
          footer: {
              columns: [
                { text: '<?php echo "Report generated from AI enabled MindForge-ERP at - " . date("jS F Y h:i:s A"); ?>', alignment: 'right', fontSize: 9, color: '#a0a0a0', margin: [0, 0, 20, 0] }
              ]
          },
          content: [
              { text: title, fontSize: 18, bold: true, style: 'header', alignment: 'center' },
              { text: subtitle, fontSize: 14, style: 'header', alignment: 'center' },
              {
                  border: [true, true, true, true],
                  table: {
                      dontBreakRows: true,
                      headerRows: 1,
                      widths: widthArray,
                      body: [headerRow].concat(rows),
                      heights: function(rowIndex) {
                          return rowIndex === 0 ? 40 : 15;
                      }
                  },
                  layout: createLayout(1)
              }
          ],
          pageMargins: [10, 10, 10, 15]
      };
  }

  // async function exportToPDF(gridApi) {
  //     // console.log(gridApi)
  //     $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
  //     var doc = await getDocument(gridApi);
  //     // console.log("Loading PDF", doc)
  //     pdfMake.createPdf(doc).download(tempName || 'download.pdf');
  //     setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
  // }

  function exportToPDF(gridApi) {
    exportGridPdf(gridApi);   // pass the GridApi instance
  }

  //backup of todays
  // function exportGridPdf(api) {
  //   if (!api) { alert('Grid API missing'); return; }

  //   /* ── user options ─────────────────────────────────────────────── */
  //   const repeatGroupKeys  = false; //$('#repeatKeysChk').is(':checked');
  //   const repeatPivotKeys  = false; //$('#repeatPivotChk').is(':checked');
  //   const lastGroupKey = {};           // cache colId → last value printed
  //   const lastPivotKey = {};           // cache pivot colId → last value

  //   /* ── grid meta ────────────────────────────────────────────────── */
  //   const cols          = api.getAllDisplayedColumns();     // visible columns
  //   const pivotMode     = api.isPivotMode();
  //   const pivotCols     = api.getPivotColumns();
  //   const lastRowIndex  = api.getDisplayedRowCount() - 1;   // bottom row index

  //   /* ── helpers ──────────────────────────────────────────────────── */
  //   function keyForAutoGroup(colId, node) {
  //     for (let cur=node; cur; cur=cur.parent)
  //       if (cur.groupData && colId in cur.groupData) return cur.groupData[colId];
  //     return '';
  //   }

  //   //formating cell number
  //   function formatForPdf(raw, colDef) {
  //     if (raw === '' || isNaN(raw)) return String(raw);          // not numeric
  //     if (typeof colDef.valueFormatter === 'function') {
  //       return colDef.valueFormatter({ value: raw });            // reuse grid rule
  //     }
  //     return Number(raw).toFixed(2);                             // default 0.00
  //   }

  //   function toProperCase(str) {
  //     return String(str)
  //       .replace(/([a-z])([A-Z])/g, '$1 $2')  // split camelCase into words
  //       .replace(/\w\S*/g, txt =>
  //         txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
  //       );
  //   }

  //   function cellText(col, node) {
  //     const id  = col.getColId();
  //     const def = col.getColDef();

  //     /* ── group rows ─────────────────────────────────────────────── */
  //     if (node.group) {

  //       /* grouped column that remains in the grid (design, shade …) */
  //       if (node.groupData && id in node.groupData) {
  //         const k = node.groupData[id];           // key value

  //         if (repeatGroupKeys) return k;          // checkbox: repeat or not
  //         if (k !== lastGroupKey[id]) {
  //           lastGroupKey[id] = k;                 // first occurrence
  //           return k;
  //         }
  //         return '';                              // duplicates blanked
  //       }

  //       /* auto-generated group column */
  //       if (id.startsWith('ag-Grid-AutoColumn-'))
  //         return keyForAutoGroup(id, node);

  //       /* group-level aggregates */
  //       if (node.aggData && id in node.aggData)
  //         return node.aggData[id];

  //       return '';
  //     }

  //     /* ── pivot key columns ─ (unchanged) ────────────────────────── */
  //     if (pivotMode && node.aggData) {
  //       const pIdx = pivotCols.findIndex(p => p.getColId() === id);
  //       if (pIdx >= 0) {
  //         const k = node.pivotKeys?.[pIdx] ?? '';
  //         if (repeatPivotKeys) return k;
  //         if (k !== lastPivotKey[id]) { lastPivotKey[id] = k; return k; }
  //         return '';
  //       }
  //       return node.aggData[id] ?? '';
  //     }

  //     /* ── regular leaf rows / numeric aggregates ─────────────────── */
  //     if (node.data && def.field)             return node.data[def.field];
  //     if (node.aggData && id in node.aggData) return node.aggData[id];
  //     return '';
  //   }


  //   const pdfCell = (v,d)=>({
  //     text : formatForPdf(v, d),//String(v),
  //     margin:[3,4],
  //     ...(d.cellStyle||{}),
  //     ...(v!=='' && !isNaN(v) ? { alignment:'right' } : {})
  //   });

  //   /* ── build header ──────────────────────────────────────────────── */
  //   // const header = cols.map(c => ({
  //   //   text  : c.getColDef().headerName || c.getColDef().field,
  //   //   bold  : true, margin:[3,4]
  //   // }));
   
  //   const headerRows = [];
  //   // const cols = api.getAllDisplayedColumns(); // keep this as is

  //   // 1. Generate top-level header only if `columnGroupShow` or `pivotKeys` exist
  //   const hasTopHeader = cols.some(col => {
  //     const def = col.getColDef();
  //     return !!def.pivotKeys || !!col.getParent();
  //   });



  //   if (hasTopHeader) {
  //     const topHeader = [];
  //     let currentGroup = '';
  //     let span = 0;

  //     for (let i = 0; i <= cols.length; i++) {
  //       const col = cols[i];
  //       const def = col?.getColDef?.() || {};
  //       const group = def.pivotKeys?.[0] || '';

  //       if (i === 0) {
  //         currentGroup = group;
  //         span = 1;
  //       } else if (group === currentGroup) {
  //         span++;
  //       } else {
  //         if (span > 0) {
  //           topHeader.push({
  //             text: currentGroup || '', 
  //             bold: true,
  //             colSpan: span,
  //             alignment: 'center',
  //             margin: [3, 4]
  //           });
  //           for (let j = 1; j < span; j++) {
  //             topHeader.push({ text: '', colSpan: 1 });
  //           }
  //         }
  //         currentGroup = group;
  //         span = 1;
  //       }
  //     }

  //     headerRows.push(topHeader);
  //   }

  //   function capitalize(str) {
  //     return str?.charAt(0).toUpperCase() + str?.slice(1).toLowerCase();
  //   }

  //   const subHeader = cols.map(col => {
  //     const colId = col.getColId();
  //     const def = col.getColDef();
  //     const pivotColDef = def?.pivotValueColumn?.colDef;
  //     const aggFunc = pivotColDef?.aggFunc || def?.aggFunc;
  //     const field = pivotColDef?.field || def?.field;
  //     const isCheckbox = colId === 'ag-Grid-SelectionColumn';
  //     let headerText = capitalize(def.headerName) ?? colId;

  //     // If aggFunc exists and field exists, format as Sum(Qty)
  //     if (aggFunc) {
  //       headerText = `${capitalize(aggFunc)}(${capitalize(def.headerName) ?? colId})`;
  //       console.log("aggFunc",aggFunc);
  //     }

  //     return {
  //       text: isCheckbox ? '' : headerText,
  //       bold: true,
  //       alignment: 'center',
  //       margin: [3, 4]
  //     };
  //   });


  //   headerRows.push(subHeader); // always push this


  //   const body = headerRows;


  //   // const body   = [header];
  //   const totals = Array(cols.length).fill(0);

  //   /* ── rows ──────────────────────────────────────────────────────── */
  //   for (let r = 0; r <= lastRowIndex; r++) {
  //     const node = api.getDisplayedRowAtIndex(r);
  //     const row  = cols.map(c => pdfCell(cellText(c,node), c.getColDef()));
  //     body.push(row);

  //     if (node.leafGroup || !node.group)
  //       row.forEach((cell,i)=> totals[i] += (+cell.text || 0));

  //     /* label bottom-most grid-supplied total row only */
  //     if (
  //       r === lastRowIndex &&
  //       node.group && !node.key && node.aggData
  //     ) {
  //       row[0].text = 'GRAND TOTAL';
  //       row.forEach(c => c.bold = true);
  //     }
  //   }

  //   /* ── create & download PDF ────────────────────────────────────────── */
  //   const fileName   = 'AGGridReport.pdf';
  //   var title = $(".page-header h2").html();
  //   var selectedText = $(".templateSelect option:selected").text().trim();
  //   var subtitle = selectedText ? "(" + selectedText + ")" : "";
  //   // var subtitle = "(" + $(".templateSelect option:selected").text() + ")";
  //   const titleText = tempName;//'Warehouse Stock';
  //   const timeStamp  = new Date().toLocaleString('en-GB', {
  //     day   :'2-digit', month:'short', year:'numeric',
  //     hour  :'2-digit', minute:'2-digit', second:'2-digit'
  //   });

  //   /* ── create & download PDF (your size / orientation pickers) ───── */
  //   pdfMake.createPdf({
  //     pageSize       : $('#pdf_size').val(),          // e.g. A3 or A4
  //     pageOrientation: $('#pdf_orientation').val(),   // portrait / landscape
  //     pageMargins    : [20,20,20,40],

  //     /* footer (runs on every page) */
  //     footer: function(currentPage, pageCount){
  //       return {
  //         columns: [
  //           { text: '' },
  //           { text: '<?php echo "Report generated from AI enabled MindForge-ERP at - " . date("jS F Y h:i:s A"); ?>', alignment: 'right', fontSize: 9, color: '#a0a0a0', margin: [0, 0, 20, 0] }
  //           // {
  //           //   text : `${timeStamp}   |   page ${currentPage} of ${pageCount}`,
  //           //   alignment:'right',
  //           //   fontSize : 9,
  //           //   color    : '#666'
  //           // }
  //         ],
  //         margin:[0,0,20,0]
  //       };
  //     },

  //     content: [
  //       { text: title, fontSize: 18, bold: true, style: 'header', alignment: 'center' },
  //       { text: subtitle, fontSize: 14, style: 'header', alignment: 'center' },
  //       // ...(subtitle.trim() ? [{ text: subtitle, fontSize: 14, style: 'header', alignment: 'center' }] : []),

  //       /* 2) the table */
  //       {
  //         table : {
  //           headerRows:1,
  //           widths    : cols.map(()=>'auto'),
  //           body      : body
  //         },
  //         layout : {                    // thin grey grid lines
  //           hLineWidth:()=>0.5, vLineWidth:()=>0.5,
  //           hLineColor:()=>'#bbb', vLineColor:()=>'#bbb'
  //         }
  //       }
  //     ]

  //   }).download(tempName || 'download.pdf');
  //   // }).download(tempName.replace(/[^a-zA-Z0-9.\[\]\(\)-_]/g, '') || 'download.pdf');

  // }


  // function exportGridPdf(api) {
  //   if (!api) { alert('Grid API missing'); return; }

  //   /* ── user options ─────────────────────────────────────────────── */
  //   const repeatGroupKeys  = false; //$('#repeatKeysChk').is(':checked');
  //   const repeatPivotKeys  = false; //$('#repeatPivotChk').is(':checked');
  //   const lastGroupKey = {};           // cache colId → last value printed
  //   const lastPivotKey = {};           // cache pivot colId → last value

  //   /* ── grid meta ────────────────────────────────────────────────── */
  //   const cols          = api.getAllDisplayedColumns();     // visible columns
  //   const pivotMode     = api.isPivotMode();
  //   const pivotCols     = api.getPivotColumns();
  //   const lastRowIndex  = api.getDisplayedRowCount() - 1;   // bottom row index

  //   /* ── helpers ──────────────────────────────────────────────────── */
  //   function keyForAutoGroup(colId, node) {
  //     for (let cur=node; cur; cur=cur.parent)
  //       if (cur.groupData && colId in cur.groupData) return cur.groupData[colId];
  //     return '';
  //   }

  //   // formating cell number
  //   // function formatForPdf(raw, colDef) {
      
  //   //   if (raw === '' || isNaN(raw)) return String(raw);          // not numeric
  //   //   if (typeof colDef.valueFormatter === 'function') {
  //   //     console.log("pornima",raw,colDef.valueFormatter({ value: raw }));
  //   //     return colDef.valueFormatter({ value: raw });            // reuse grid rule
  //   //   }
  //   //   console.log("pornima1",raw,Number(raw).toFixed(2));
  //   //   return Number(raw).toFixed(2);                             // default 0.00
  //   // }

  //   function formatForPdf(raw, colDef) {
  //     // Empty or non-numeric values → return as string
  //     // if (raw === '' || raw === null || raw === undefined || isNaN(raw)) {
  //     //   return String(raw ?? '');
  //     // }

  //     // 1️⃣ Handle empty / null / undefined
  //     if (raw === '' || raw === null || raw === undefined) return '';

  //     // Convert once
  //     const strRaw = String(raw).trim();

  //     // 2️⃣ Detect date-like values (YYYY-MM-DD or ISO string)
  //     // e.g., "2025-10-14", "2025-10-14T00:00:00Z"
  //     if (/^\d{4}-\d{2}-\d{2}/.test(strRaw)) {
  //       const d = new Date(strRaw);
  //       if (!isNaN(d.getTime())) {
  //         const day = String(d.getDate()).padStart(2, '0');
  //         const month = String(d.getMonth() + 1).padStart(2, '0');
  //         const year = d.getFullYear();
  //         return `${day}-${month}-${year}`;
  //       }
  //     }

  //     // 3️⃣ Handle non-numeric strings (like "N/A", "Text", etc.)
  //     if (isNaN(raw)) return strRaw;

  //     const num = Number(raw);

  //     // ✅ Case 1: If original value contains a decimal point, keep same precision
  //     // if (strRaw.includes('.')) {
  //     //   const match = strRaw.match(/\.(\d+)/);          // find how many decimals exist
  //     //   const decimals = match ? match[1].length : 0;
  //     //   return num.toFixed(decimals);
  //     // }

  //     if (strRaw.includes('.')) {
  //       const decimals = (strRaw.split('.')[1] || '').length;

  //       // Limit decimals to a reasonable range (max 6 to avoid JS noise)
  //       const safeDecimals = Math.min(decimals, 6);

  //       // Round safely and remove floating-point garbage
  //       return parseFloat(num.toFixed(safeDecimals)).toFixed(
  //         decimals > 2 ? 2 : decimals
  //       );
  //     }

  //     // ✅ Case 2: No decimal point originally → return clean integer
  //     if (Number.isInteger(num)) {
  //       return String(num);
  //     }

  //     // ✅ Case 3: Rare fallback (e.g. 12.5 but source didn't include .)
  //     return num % 1 === 0 ? String(num) : num.toFixed(2);
  //   }



  //   function toProperCase(str) {
  //     return String(str)
  //       .replace(/([a-z])([A-Z])/g, '$1 $2')  // split camelCase into words
  //       .replace(/\w\S*/g, txt =>
  //         txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
  //       );
  //   }

  //   function cellText(col, node) {
  //     const id  = col.getColId();
  //     const def = col.getColDef();

  //     /* ── group rows ─────────────────────────────────────────────── */
  //     if (node.group) {

  //       /* grouped column that remains in the grid (design, shade …) */
  //       if (node.groupData && id in node.groupData) {
  //         const k = node.groupData[id];           // key value

  //         if (repeatGroupKeys) return k;          // checkbox: repeat or not
  //         if (k !== lastGroupKey[id]) {
  //           lastGroupKey[id] = k;                 // first occurrence
  //           return k;
  //         }
  //         return '';                              // duplicates blanked
  //       }

  //       /* auto-generated group column */
  //       if (id.startsWith('ag-Grid-AutoColumn-'))
  //         return keyForAutoGroup(id, node);

  //       /* group-level aggregates */
  //       if (node.aggData && id in node.aggData)
  //         return node.aggData[id];

  //       return '';
  //     }

  //     /* ── pivot key columns ─ (unchanged) ────────────────────────── */
  //     if (pivotMode && node.aggData) {
  //       const pIdx = pivotCols.findIndex(p => p.getColId() === id);
  //       if (pIdx >= 0) {
  //         const k = node.pivotKeys?.[pIdx] ?? '';
  //         if (repeatPivotKeys) return k;
  //         if (k !== lastPivotKey[id]) { lastPivotKey[id] = k; return k; }
  //         return '';
  //       }
  //       return node.aggData[id] ?? '';
  //     }

  //     /* ── regular leaf rows / numeric aggregates ─────────────────── */
  //     if (node.data && def.field)             return node.data[def.field];
  //     if (node.aggData && id in node.aggData) return node.aggData[id];
  //     return '';
  //   }


  //   const pdfCell = (v,d)=>({
  //     text : formatForPdf(v, d),//String(v),
  //     margin:[3,4],
  //     ...(d.cellStyle||{}),
  //     ...(v!=='' && !isNaN(v) ? { alignment:'right' } : {})
  //   });

  //   /* ── build header ──────────────────────────────────────────────── */
  //   // const header = cols.map(c => ({
  //   //   text  : c.getColDef().headerName || c.getColDef().field,
  //   //   bold  : true, margin:[3,4]
  //   // }));
   
  //   const headerRows = [];
  //   // const cols = api.getAllDisplayedColumns(); // keep this as is

  //   // 1. Generate top-level header only if `columnGroupShow` or `pivotKeys` exist
  //   const hasTopHeader = cols.some(col => {
  //     const def = col.getColDef();
  //     return !!def.pivotKeys || !!col.getParent();
  //   });



  //   if (hasTopHeader) {
  //     const topHeader = [];
  //     let currentGroup = '';
  //     let span = 0;

  //     for (let i = 0; i <= cols.length; i++) {
  //       const col = cols[i];
  //       const def = col?.getColDef?.() || {};
  //       const group = def.pivotKeys?.[0] || '';

  //       if (i === 0) {
  //         currentGroup = group;
  //         span = 1;
  //       } else if (group === currentGroup) {
  //         span++;
  //       } else {
  //         if (span > 0) {
  //           topHeader.push({
  //             text: currentGroup || '', 
  //             bold: true,
  //             colSpan: span,
  //             alignment: 'center',
  //             margin: [3, 4]
  //           });
  //           for (let j = 1; j < span; j++) {
  //             topHeader.push({ text: '', colSpan: 1 });
  //           }
  //         }
  //         currentGroup = group;
  //         span = 1;
  //       }
  //     }

  //     headerRows.push(topHeader);
  //   }

  //   function capitalize(str) {
  //     return str?.charAt(0).toUpperCase() + str?.slice(1).toLowerCase();
  //   }

  //   const subHeader = cols.map(col => {
  //     const colId = col.getColId();
  //     const def = col.getColDef();
  //     const pivotColDef = def?.pivotValueColumn?.colDef;
  //     const aggFunc = pivotColDef?.aggFunc || def?.aggFunc;
  //     const field = pivotColDef?.field || def?.field;
  //     const isCheckbox = colId === 'ag-Grid-SelectionColumn';
  //     let headerText = capitalize(def.headerName) ?? colId;

  //     // If aggFunc exists and field exists, format as Sum(Qty)
  //     if (aggFunc) {
  //       headerText = `${capitalize(aggFunc)}(${capitalize(def.headerName) ?? colId})`;
  //       console.log("aggFunc",aggFunc);
  //     }

  //     return {
  //       text: isCheckbox ? '' : headerText,
  //       bold: true,
  //       alignment: 'center',
  //       margin: [3, 4]
  //     };
  //   });


  //   headerRows.push(subHeader); // always push this


  //   const body = headerRows;


  //   // const body   = [header];
  //   const totals = Array(cols.length).fill(0);

  //   /* ── rows ──────────────────────────────────────────────────────── */
  //   for (let r = 0; r <= lastRowIndex; r++) {
  //     const node = api.getDisplayedRowAtIndex(r);
  //     const row  = cols.map(c => pdfCell(cellText(c,node), c.getColDef()));
  //     // body.push(row);

  //     // if (node.leafGroup || !node.group)
  //     //   row.forEach((cell,i)=> totals[i] += (+cell.text || 0));

  //     // /* label bottom-most grid-supplied total row only */
  //     // if (
  //     //   r === lastRowIndex &&
  //     //   node.group && !node.key && node.aggData
  //     // ) {
  //     //   row[0].text = 'GRAND TOTAL';
  //     //   row.forEach(c => c.bold = true);
  //     // }

  //     const showGrandTotal = document.getElementById('showGrandTotal')?.checked;
  //     const isGrandTotalRow = r === lastRowIndex && node.group && !node.key && node.aggData;

  //     if (showGrandTotal || !isGrandTotalRow) {
  //       body.push(row);

  //       if (!node.group || node.leafGroup)
  //         row.forEach((cell, i) => totals[i] += (+cell.text || 0));

  //       if (showGrandTotal && isGrandTotalRow) {
  //         row[0].text = 'GRAND TOTAL';
  //         row.forEach(c => c.bold = true);
  //       }
  //     }
  //   }

  //   /* ── create & download PDF ────────────────────────────────────────── */
  //   const fileName   = 'AGGridReport.pdf';
  //   var title = $(".page-header h2").html();
  //   var selectedText = $(".templateSelect option:selected").text().trim();
  //   var subtitle = selectedText ? "(" + selectedText + ")" : "";
  //   // var subtitle = "(" + $(".templateSelect option:selected").text() + ")";
  //   const titleText = tempName;//'Warehouse Stock';
  //   const timeStamp  = new Date().toLocaleString('en-GB', {
  //     day   :'2-digit', month:'short', year:'numeric',
  //     hour  :'2-digit', minute:'2-digit', second:'2-digit'
  //   });
  //   var ssdt = "<?php echo isset($_GET['ssdt']) && $_GET['ssdt'] ? date('d-m-Y', strtotime($_GET['ssdt'])) : ''; ?>";
  //   var lldt = "<?php echo isset($_GET['lldt']) && $_GET['lldt'] ? date('d-m-Y', strtotime($_GET['lldt'])) : ''; ?>";
  //   var companyName   = $("#company option:selected").text();


  //   /* ── create & download PDF (your size / orientation pickers) ───── */
  //   pdfMake.createPdf({
  //     pageSize       : $('#pdf_size').val(),          // e.g. A3 or A4
  //     pageOrientation: $('#pdf_orientation').val(),   // portrait / landscape
  //     pageMargins    : [20,20,20,40],

  //     /* footer (runs on every page) */
  //     footer: function(currentPage, pageCount){
  //       return {
  //         columns: [
  //           { text: '' },
  //           { 
  //             text: `Report generated from AI MindForge-ERP at - <?php echo date("jS F Y h:i:s A"); ?> | Page ${currentPage} of ${pageCount}`,
  //             // text: '<?php echo "Report generated from AI enabled MindForge-ERP at - " . date("jS F Y h:i:s A"); ?> |   Page ${currentPage} of ${pageCount} ', 
  //             alignment: 'right', fontSize: 9, color: '#a0a0a0', margin: [0, 0, 20, 0] }
  //           // {
  //           //   text : `${timeStamp}   |   page ${currentPage} of ${pageCount}`,
  //           //   alignment:'right',
  //           //   fontSize : 9,
  //           //   color    : '#666'
  //           // }
  //         ],
  //         margin:[0,0,20,0]
  //       };
  //     },


  //     content: [
  //       { text: companyName, fontSize: 18, bold: true, alignment: 'center', margin: [0, 0, 0, 5] },
  //       { text: title, fontSize: 12, bold: true, style: 'header', alignment: 'center' },
  //       { text: subtitle, fontSize: 12, style: 'header', alignment: 'center' },
  //       // ...(subtitle.trim() ? [{ text: subtitle, fontSize: 14, style: 'header', alignment: 'center' }] : []),

  //       // company name line

  //       // optional SSD/LLDT line
  //       ...(ssdt || lldt ? [{
  //         text: `From: ${ssdt || '-'}   |   To: ${lldt || '-'}`,
  //         fontSize: 10, alignment: 'center', margin:[0,0,0,5]
  //       }] : []),

  //       /* 2) the table */
  //       {
  //         table : {
  //           headerRows:1,
  //           widths    : cols.map(()=>'auto'),
  //           body      : body
  //         },
  //         layout : {                    // thin grey grid lines
  //           hLineWidth:()=>0.5, vLineWidth:()=>0.5,
  //           hLineColor:()=>'#bbb', vLineColor:()=>'#bbb'
  //         }
  //       }
  //     ]

  //   }).download(tempName || 'download.pdf');
  //   // }).download(tempName.replace(/[^a-zA-Z0-9.\[\]\(\)-_]/g, '') || 'download.pdf');

  // }

  var reportParams = <?php echo json_encode($_GET, JSON_UNESCAPED_SLASHES); ?>;

  function exportGridPdf(api) {
    if (!api) { alert('Grid API missing'); return; }
    console.log("datastructure",DataStructure, editableStructure, DrillStructure, allDataKeys);

    const columnTypeMap = DataStructure.map(col => ({
      name: col.COLUMN_NAME,
      datatype: col.DATA_TYPE.toLowerCase()
    }));

    console.log(columnTypeMap);


    /* ── user options ─────────────────────────────────────────────── */
    const repeatGroupKeys  = false; //$('#repeatKeysChk').is(':checked');
    const repeatPivotKeys  = false; //$('#repeatPivotChk').is(':checked');
    const lastGroupKey = {};           // cache colId → last value printed
    const lastPivotKey = {};           // cache pivot colId → last value

    /* ── grid meta ────────────────────────────────────────────────── */
    const cols          = api.getAllDisplayedColumns();     // visible columns
    const pivotMode     = api.isPivotMode();
    const pivotCols     = api.getPivotColumns();
    const lastRowIndex  = api.getDisplayedRowCount() - 1;   // bottom row index

    /* ── helpers ──────────────────────────────────────────────────── */
    function keyForAutoGroup(colId, node) {
      for (let cur=node; cur; cur=cur.parent)
        if (cur.groupData && colId in cur.groupData) return cur.groupData[colId];
      return '';
    }

    function formatForPdf(raw, colDef) {
      // Empty or non-numeric values → return as string
      // if (raw === '' || raw === null || raw === undefined || isNaN(raw)) {
      //   return String(raw ?? '');
      // }

      // 1️⃣ Handle empty / null / undefined
      if (raw === '' || raw === null || raw === undefined) return '';

      // Convert once
      const strRaw = String(raw).trim();

      // 🔹 Get datatype from your array (like [{ name:'salesman', datatype:'varchar' }])
      const fieldName = (colDef.field || colDef.colId || '').toLowerCase();
      const matched = columnTypeMap.find(
        col => col.name.toLowerCase() === fieldName
      );
      const dataType = (matched?.datatype || colDef.dataType || colDef.cellDataType || '').toLowerCase();

      if (['varchar', 'nvarchar', 'nchar', 'string', 'char'].includes(dataType)) {
        return strRaw;
      }


      if (['date', 'datetime', 'smalldatetime'].includes(dataType) || /^\d{4}-\d{2}-\d{2}/.test(strRaw)) {
        const d = new Date(strRaw);
        if (!isNaN(d.getTime())) {
          const day = String(d.getDate()).padStart(2, '0');
          const month = String(d.getMonth() + 1).padStart(2, '0');
          const year = d.getFullYear();
          return `${day}-${month}-${year}`;
        }
        return strRaw;
      }

  
      if (['int', 'bigint', 'float', 'decimal', 'money', 'number'].includes(dataType)) {
          if (isNaN(raw)) return strRaw;

          const num = Number(raw);
          const decimals = (strRaw.split('.')[1] || '').length;

          // ✅ If original had decimals → preserve up to 2
          if (decimals > 0) {
            return num.toFixed(Math.min(decimals, 2));  // 105.60 → 105.60, 26.00 → 26.00
          }

          // ✅ If original is integer (no decimals) → keep it clean
          if (Number.isInteger(num)) {
            return String(num);  // 1 → 1
          }

          // ✅ Fallback: show 2 decimals for any floating-point artifacts
          return num.toFixed(2);
        }
    

      // ✅ Case 3: Rare fallback (e.g. 12.5 but source didn't include .)
      // return num % 1 === 0 ? String(num) : num.toFixed(2);
      return strRaw;
    }

    function toProperCase(str) {
      return String(str)
        .replace(/([a-z])([A-Z])/g, '$1 $2')  // split camelCase into words
        .replace(/\w\S*/g, txt =>
          txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase()
        );
    }

    function cellText(col, node) {
      const id  = col.getColId();
      const def = col.getColDef();

      /* ── group rows ─────────────────────────────────────────────── */
      if (node.group) {

        /* grouped column that remains in the grid (design, shade …) */
        if (node.groupData && id in node.groupData) {
          const k = node.groupData[id];           // key value

          if (repeatGroupKeys) return k;          // checkbox: repeat or not
          if (k !== lastGroupKey[id]) {
            lastGroupKey[id] = k;                 // first occurrence
            return k;
          }
          return '';                              // duplicates blanked
        }

        /* auto-generated group column */
        if (id.startsWith('ag-Grid-AutoColumn-'))
          return keyForAutoGroup(id, node);

        /* group-level aggregates */
        if (node.aggData && id in node.aggData)
          return node.aggData[id];

        return '';
      }

      /* ── pivot key columns ─ (unchanged) ────────────────────────── */
      if (pivotMode && node.aggData) {
        const pIdx = pivotCols.findIndex(p => p.getColId() === id);
        if (pIdx >= 0) {
          const k = node.pivotKeys?.[pIdx] ?? '';
          if (repeatPivotKeys) return k;
          if (k !== lastPivotKey[id]) { lastPivotKey[id] = k; return k; }
          return '';
        }
        return node.aggData[id] ?? '';
      }
      
      /* ── regular leaf rows / numeric aggregates ─────────────────── */
      if (node.data && def.field)             return node.data[def.field];
      if (node.aggData && id in node.aggData) return node.aggData[id];
      return '';
    }

    const pdfCell = (v, d) => {
      // console.log("pornima",v,d)
      // const dataType = (d.dataType || d.cellDataType || '').toLowerCase();
      // const formatted = formatForPdf(v, d);

      // 🔹 Find datatype from your array based on column field name
      const fieldName = (d.headerName || '').toLowerCase();
      const matched = columnTypeMap.find(
        col => col.name.toLowerCase() === fieldName
      );

      const dataType = (matched?.datatype || d.dataType || d.cellDataType || '').toLowerCase();

      // 🔹 Format using your existing formatter
      const formatted = formatForPdf(v, { ...d, dataType });

      //Decide alignment based on data type
      let alignment = 'left';
      if (['int', 'bigint', 'float', 'decimal', 'money', 'number'].includes(dataType)) {
        alignment = 'right';
      }else {
        alignment = 'left';
      }

      return {
        text: formatted,
        // margin: [3, 4],
        margin: [0,0,0,0],
        alignment,
        ...(d.cellStyle || {}),
        // lineHeight: 0.9,          // remove extra bottom space
        noWrap: false
      };
    };
   
    const headerRows = [];
    // const cols = api.getAllDisplayedColumns(); // keep this as is

    // 1. Generate top-level header only if `columnGroupShow` or `pivotKeys` exist
    const hasTopHeader = cols.some(col => {
      const def = col.getColDef();
      return !!def.pivotKeys || !!col.getParent();
    });

    if (hasTopHeader) {
      const topHeader = [];
      let currentGroup = '';
      let span = 0;

      for (let i = 0; i < cols.length; i++) {
        const col = cols[i];
        const def = col?.getColDef?.() || {};
        const group = def.pivotKeys?.[0] || '';

        if (i === 0) {
          currentGroup = group;
          span = 1;
        } else if (group === currentGroup) {
          span++;
        } else {
          // flush previous group
          topHeader.push({
            text: currentGroup || '',
            bold: true,
            colSpan: span,
            alignment: 'center',
            margin: [3, 4]
          });
          for (let j = 1; j < span; j++) topHeader.push({}); // fillers as empty objects

          currentGroup = group;
          span = 1;
        }
      }
      // flush the last (non-empty) group
      if (span > 0) {
        topHeader.push({
          text: currentGroup || '',
          bold: true,
          colSpan: span,
          alignment: 'center',
          margin: [3, 4]
        });
        for (let j = 1; j < span; j++) topHeader.push({});
      }

      headerRows.push(topHeader);
    }


    function capitalize(str) {
      return str?.charAt(0).toUpperCase() + str?.slice(1).toLowerCase();
    }

    const subHeader = cols.map(col => {
      const colId = col.getColId();
      const def = col.getColDef();
      const pivotColDef = def?.pivotValueColumn?.colDef;
      const aggFunc = pivotColDef?.aggFunc || def?.aggFunc;
      const field = pivotColDef?.field || def?.field;
      const isCheckbox = colId === 'ag-Grid-SelectionColumn';
      let headerText = capitalize(def.headerName) ?? colId;

      // If aggFunc exists and field exists, format as Sum(Qty)
      if (aggFunc) {
        headerText = `${capitalize(aggFunc)}(${capitalize(def.headerName) ?? colId})`;
        console.log("aggFunc",aggFunc, headerText);
      }

      // 🔹 Remove only "Sum(...)" but keep others (Avg, Max, etc.)
      if (typeof headerText === 'string') {
        headerText = headerText.replace(/^Sum\((.*?)\)$/i, '$1').trim();
      }

      return {
        text: isCheckbox ? '' : headerText,
        bold: true,
        alignment: 'center',
        margin: [3, 4]
      };
    });

    headerRows.push(subHeader); // always push this
    const body = headerRows;
    // const body   = [header];
    const totals = Array(cols.length).fill(0);

    /* ── rows ──────────────────────────────────────────────────────── */
    for (let r = 0; r <= lastRowIndex; r++) {
      const node = api.getDisplayedRowAtIndex(r);
      const row  = cols.map(c => pdfCell(cellText(c,node), c.getColDef()));
      // body.push(row);

      // if (node.leafGroup || !node.group)
      //   row.forEach((cell,i)=> totals[i] += (+cell.text || 0));

      // /* label bottom-most grid-supplied total row only */
      // if (
      //   r === lastRowIndex &&
      //   node.group && !node.key && node.aggData
      // ) {
      //   row[0].text = 'GRAND TOTAL';
      //   row.forEach(c => c.bold = true);
      // }

      const showGrandTotal = document.getElementById('showGrandTotal')?.checked;
      const isGrandTotalRow = r === lastRowIndex && node.group && !node.key && node.aggData;
      // console.log('isGrandTotalRow')
      if (showGrandTotal || !isGrandTotalRow) {
        body.push(row);
        // console.log(row)
        if (!node.group || node.leafGroup)
          row.forEach((cell, i) => totals[i] += (+cell.text || 0));
        // console.log(totals)
        if (showGrandTotal && isGrandTotalRow) {
          row[0].text = 'GRAND TOTAL';
          row.forEach(c => c.bold = true);
        }
      }
    }

    /* ── create & download PDF ────────────────────────────────────────── */
    const fileName   = 'AGGridReport.pdf';
    var title = $(".page-header h2").html();
    var selectedText = $(".templateSelect option:selected").text().trim();
    var subtitle = selectedText ? "(" + selectedText + ")" : "";
    // var subtitle = "(" + $(".templateSelect option:selected").text() + ")";
    const titleText = tempName;//'Warehouse Stock';
    const timeStamp  = new Date().toLocaleString('en-GB', {
      day   :'2-digit', month:'short', year:'numeric',
      hour  :'2-digit', minute:'2-digit', second:'2-digit'
    });
    // var ssdt = "<?php echo isset($_GET['ssdt']) && $_GET['ssdt'] ? date('d-m-Y', strtotime($_GET['ssdt'])) : ''; ?>";
    // var lldt = "<?php echo isset($_GET['lldt']) && $_GET['lldt'] ? date('d-m-Y', strtotime($_GET['lldt'])) : ''; ?>";
    var companyName   = $("#company option:selected").text();

    /* 🔹 format all GET parameters dynamically (with dropdown label detection) */
    let formattedParams = [];
    const skipKeys = ['ReportID', 'view', 'template', 'username', 'print', 'Submit', 'company']; // skip system params

    for (let key in reportParams) {
      if (!reportParams[key] || skipKeys.includes(key)) continue;

      let value = String(reportParams[key]).trim();
      let label = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()); // default fallback

      // ✅ Try to find the <label> associated with this input/select element
      const fieldEl = document.querySelector(`[name='${key}'], #${key}`);
      if (fieldEl) {
        const parent = fieldEl.closest('div'); // find enclosing div (label usually inside)
        const labelEl = parent ? parent.querySelector('label') : null;
        if (labelEl && labelEl.textContent.trim() !== '') {
          label = labelEl.textContent.replace('*', '').trim(); // use form label, remove asterisk
        }
      }

      // 🔸 Detect dropdowns and fetch selected label instead of ID
      const dropdown = document.querySelector(`#${key}`);
      if (dropdown && dropdown.tagName === 'SELECT') {
        const selectedOption = dropdown.options[dropdown.selectedIndex];
        if (selectedOption && selectedOption.text) {
          value = selectedOption.text.trim();
        }
      }

      // 🔸 Format date (YYYY-MM-DD → DD-MM-YYYY)
      if (/^\d{4}-\d{2}-\d{2}/.test(value)) {
        const [yyyy, mm, dd] = value.split('T')[0].split('-');
        value = `${dd}-${mm}-${yyyy}`;
      }

      formattedParams.push(`${label}: ${value}`);
    }

    /* ✅ All parameters on one single line (left aligned) */
    const paramLines = [
      {
        text: formattedParams.join(' | '),
        fontSize: 10,
        alignment: 'center',
        margin: [40, 2, 0, 5], // left padding for neatness
        noWrap: false           // allows wrapping only if absolutely necessary
      }
    ];

    const padding = parseInt($('#pdf_cell_padding').val()) || 3;

    /* ── create & download PDF (your size / orientation pickers) ───── */
    pdfMake.createPdf({
      pageSize       : $('#pdf_size').val(),          // e.g. A3 or A4
      pageOrientation: $('#pdf_orientation').val(),   // portrait / landscape
      pageMargins    : [20,20,20,40],

      defaultStyle: {
        fontSize: parseInt($('#pdf_font_size').val()) || 9, 
      },

      /* footer (runs on every page) */
      footer: function(currentPage, pageCount){
        return {
          columns: [
            { text: '' },
            { 
              text: `Report generated from AI MindForge-ERP at - <?php echo date("jS F Y h:i:s A"); ?> | Page ${currentPage} of ${pageCount}`,
              // text: '<?php echo "Report generated from AI enabled MindForge-ERP at - " . date("jS F Y h:i:s A"); ?> |   Page ${currentPage} of ${pageCount} ', 
              alignment: 'right', fontSize: 9, color: '#a0a0a0', margin: [0, 0, 20, 0] }
            // {
            //   text : `${timeStamp}   |   page ${currentPage} of ${pageCount}`,
            //   alignment:'right',
            //   fontSize : 9,
            //   color    : '#666'
            // }
          ],
          margin:[0,0,20,0]
        };
      },


      content: [
        { text: companyName, fontSize: 18, bold: true, alignment: 'center', margin: [0, 0, 0, 5] },
        // { text: title, fontSize: 12, bold: true, style: 'header', alignment: 'center' },
        // { text: subtitle, fontSize: 12, style: 'header', alignment: 'center' },
        // 🔹 Title + Subtitle in one line
        {
          text: [
            { text: title + ' ', bold: true }, // title
            { text: subtitle ? subtitle : '' } // subtitle
          ],
          fontSize: 12,
          alignment: 'center',
          margin: [0, 0, 0, 2] // small bottom margin only
        },
        // ...(subtitle.trim() ? [{ text: subtitle, fontSize: 14, style: 'header', alignment: 'center' }] : []),

        // company name line
        // 🔹 Dynamic filter parameters
      ...paramLines,

        // optional SSD/LLDT line
        // ...(ssdt || lldt ? [{
        //   text: `From: ${ssdt || '-'}   |   To: ${lldt || '-'}`,
        //   fontSize: 10, alignment: 'center', margin:[0,0,0,5]
        // }] : []),

        /* 2) the table */
        {
          table : {
            headerRows:1,
            widths    : cols.map(()=>'auto'),
            body      : body
          },
          layout : {                    // thin grey grid lines
            // hLineWidth:()=>0.5, vLineWidth:()=>0.5,
            hLineColor:()=>'#bbb', vLineColor:()=>'#bbb',
            paddingLeft:  () => padding,
            paddingRight: () => padding,
            paddingTop:   () => padding,
            paddingBottom:() => padding,

            //This forces top/left/right padding to visually appear
            // minCellHeight: padding * 2
            
          },
          
        }
      ]

    }).download(tempName || 'download.pdf');
    // }).download(tempName.replace(/[^a-zA-Z0-9.\[\]\(\)-_]/g, '') || 'download.pdf');

  }




  async function exportToExcel(gridApi) {
      // console.log(gridApi)
      $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
      // var doc = await getDocument(gridApi);
      // console.log("Loading PDF", doc)
      // pdfMake.createPdf(doc).download(tempName || 'download.pdf');
      setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
      setTimeout(() => {
        if (gridApi) {
            gridApi.exportDataAsExcel({
                sheetName: 'Report',
                fileName: 'Excel_export.xlsx'
            });
        } else {
            console.error("Grid API not initialized yet!");
        }
      }, 500);
  }
  function removeLoader(){
      $( "#loadingDiv" ).fadeOut(500, function() {
        // fadeOut complete. Remove the loading div
        $( "#loadingDiv" ).remove(); //makes page more lightweight 
    });  
  }
</script>  

<!-- HTML FOR DISPLAYING FILTERS -->
<?php 
if(is_array($code)){
   ?>
  <section class="panel report-filters-section">
    <header class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle filter-section" data-panel-toggle=""></a>
        </div>
          <h2 class="panel-title">Report Filters</h2>
      </div>
      <div>
        <?php if($_SESSION['Category'] == 2){ ?>
          <button class="btn btn-info btn-xs" onclick="openSQLModal('full')">SQL</button>
          <button style="margin-right:40px;" class="btn btn-success btn-xs" onclick="openRequirementModal()">Requirements</button>
        <?php } ?>
      </div>
        <!-- <p class="panel-subtitle">2 of 4 filters selected</p> -->


     


      </header>
      <div class="panel-body">
        <form method="get">
          <div class="col-md allfields filterSection">
              
              <?php 
              
                  $group_id = isset ($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;
                  $role_id = isset ($_SESSION['access']) ? $_SESSION['access'] : 0;
                  
                  $sql = "SELECT a.* FROM CompanyRoleAccess Right Join (
                              Select Aireg.ID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
                              AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
                              AiGroup.Label as GroupName, AiGroup.ID as GroupID, AiYear.sdate, AiYear.edate 
                              From Aireg 
                              LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
                              LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
                              LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID 
                              LEFT JOIN AiYear ON Aireg.Year = AiYear.Label
                              WHERE AiGroup.ID = '".$group_id."'
                          ) a ON CompanyRoleAccess.RegID = a.ID 
                          where CompanyRoleAccess.RoleID = '".$role_id."'";
                  $results = db::getInstanceMaster()->db_select($sql);
                  $Companies = [];
                  $Division = [];
                  $Year = [];

                  // Initialize default dates
                  $lldt_value = date('Y-m-d'); // Today's date by default for lldt

                  // Override lldt_value if it's in $_GET
                  if (isset($_GET['lldt']) && $_GET['lldt'] != '') {
                      $lldt_value = htmlspecialchars($_GET['lldt']);
                  }

                  // $dt = date('Y-m-d');
                  for ($j=0; $j<sizeof($results['result_set']); $j++) {
                      if($_SESSION['dbCompany'] == $results['result_set'][$j]['CompanyID']){
                          $dt = $results['result_set'][$j]['sdate']->format('Y-m-d'); // for example
                          $CompanyID = $results['result_set'][$j]['CompanyID'];
                          $DivisionID = $results['result_set'][$j]['DivisionID'];
                          $YearSelected = $results['result_set'][$j]['Year'];
                      }
                      array_push($Companies,(array("ID"=>$results['result_set'][$j]['CompanyID'],"Name"=>$results['result_set'][$j]['CompanyName'])));
                      array_push($Division,(array("ID"=>$results['result_set'][$j]['DivisionID'],"Name"=>$results['result_set'][$j]['DivisionName'])));
                      array_push($Year,   (array("ID"=>$results['result_set'][$j]['Year'],"Name"=>$results['result_set'][$j]['Year'])));
                  }
                  $uniqueCompanies = array_map("unserialize", array_unique(array_map("serialize",$Companies)));
                  $uniqueCompanies2 = array_values($uniqueCompanies);
                  
                  $uniqueDivision = array_map("unserialize", array_unique(array_map("serialize",$Division)));
                  $uniqueDivision2 = array_values($uniqueDivision);

                  $uniqueYear = array_map("unserialize", array_unique(array_map("serialize",$Year)));
                  //  print_r($uniqueYear);
                  $uniqueYear2 = array_values($uniqueYear);
                  
             
                  $dateRange = validateDate();
                  $date_min = $dateRange['date_min'];
                  $date_max = $dateRange['date_max'];

                  // Default Date for from date
                  if(strlen($viewSettings[18]) >= 1 && $viewSettings[18] == 'today'){
                      $tempDate = date('Y-m-d');
                      
                      if ($tempDate >= $date_min && $tempDate <= $date_max) {
                        $dt = $tempDate;
                      }

                  }elseif(strlen($viewSettings[18]) >= 1 && $viewSettings[18] == 'tomorrow'){
                      $datetime = new DateTime('tomorrow');
                      $tempDate = $datetime->format('Y-m-d');
                      // validateDate()
                      if ($tempDate >= $date_min && $tempDate <= $date_max) {
                        $dt = $tempDate;
                      }
                  }

                  // Default Date for to date
                  if(strlen($viewSettings[20]) >= 1 && $viewSettings[20] == 'today'){
                      $tempDate = date('Y-m-d');
                      
                      if ($tempDate >= $date_min && $tempDate <= $date_max) {
                        $lldt_value = $tempDate;
                      }

                  }elseif(strlen($viewSettings[20]) >= 1 && $viewSettings[20] == 'tomorrow'){
                      $datetime = new DateTime('tomorrow');
                      $tempDate = $datetime->format('Y-m-d');
                      // validateDate()
                      if ($tempDate >= $date_min && $tempDate <= $date_max) {
                        $lldt_value = $tempDate;
                      }
                  }elseif(strlen($viewSettings[20]) >= 1 && $viewSettings[20] == 'yearenddate'){
                      $lldt_value = $date_max;
                  }
                 
                  
              ?>
              <div class=" col-md-2 col-xs-6 ">
                  <label>From Date<span class="required"> *</span></label>
                  <input maxlength="4" pattern="\d{4}" class="form-control dyn1" value="<?php echo $dt; ?>" type="date" name="ssdt" id="ssdt"  tabindex="2"/>
              </div>
              <div class=" col-md-2 col-xs-6 ">
                  <label>To Date<span class="required"> *</span></label>
                  <input maxlength="4" pattern="\d{4}" class="form-control dyn1" value="<?php echo $lldt_value ?>" type="date" name="lldt" id="lldt" tabindex="3" />
              </div>
              <div class="col-md-2" >
                  <label for="">Company<span class="required"> *</span></label>
                  <select name="company" class="form-control" id="company" tabindex="4" required>
                      <option value></option>
                      <?php
                          $tmp = "";
                          for($k=0; $k<sizeof($uniqueCompanies2); $k++){
                              if($CompanyID == $uniqueCompanies2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                              echo '<option '.$tmp.' value="'.$uniqueCompanies2[$k]['ID'].'">'.$uniqueCompanies2[$k]['Name'].'</option>';
                          }
                      ?>
                  </select>
              </div>
              <div class="col-md-2" >
                  <label for="">Division<span class="required"> *</span></label>
                  <select name="division" class="form-control" id="division" tabindex="5" required>
                      <option value></option>
                      <?php
                          $tmp = "";
                          for($k=0; $k<sizeof($uniqueDivision2); $k++){
                              // if($DivisionID == $uniqueDivision2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                              if($_SESSION['dbDivision'] == $uniqueDivision2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                              echo '<option '.$tmp.' value="'.$uniqueDivision2[$k]['ID'].'">'.$uniqueDivision2[$k]['Name'].'</option>';
                          }
                      ?>
                  </select>
              </div>
              <div class="col-md-2" >
                  <label for="">Year:</label>
                  <select name="year" class="form-control" id="year" tabindex="6">
                      <option value></option>
                      <?php
                      // print_r($uniqueYear2);
                          $tmp = "";
                          for($k=0; $k<sizeof($uniqueYear2); $k++){
                              if($_SESSION['dbYearID'] == $uniqueYear2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                              // if($YearSelected == $uniqueYear2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                              echo '<option '.$tmp.' value="'.$uniqueYear2[$k]['ID'].'">'.$uniqueYear2[$k]['Name'].'</option>';
                          }
                      ?>
                  </select>
              </div>
          </div>

          <div class="col-md allfields filterSection">
            <?php
              $filterCode = array();
              $filterString="&";
              $tmp = "";

              // print_r($_GET);
              foreach($_GET as $name => $value) {
                $name = htmlspecialchars($name);
                if($name == "ReportID" || $name == "view"){
                  $value = htmlspecialchars($value);
                  echo '<input type="hidden" name="'. $name .'" value="'. $value .'">';
                }else{
                  if(strlen($value) > 0){
                    if($value !== 0 && $value !== '0'){
                      $filterCode[$name] = $value;
                      if (str_contains($name, "-text")) {
                        $tmp = $name . "=" . $value . "&";
                      }else{
                        $filterString .= $name . "=" . $value . "&" . $tmp;
                        $tmp = '';
                      }
                    }
                  }
                }
              }
              
              $div="";
                // echo '<div id="loader" class="spinner-border text-primary center" role="status"><span class="sr-only">Loading...</span></div>';
                // print_r($code);
              // if(is_array($code)){
                for($i = 0; $i < sizeof($code); $i++){
                  // echo '<div class="'.$code[$i][0].'">';
                    // echo createInputs($code[$i]);
                  // echo  '</div>';
                  if((int)$code[$i][1] !== 22 && (int)$code[$i][1] !== 21) echo '<div class="'.$code[$i][0].'">';
                    echo createInputs($code[$i],$FormID,$editID);
                  if((int)$code[$i][1] !== 21 && (int)$code[$i][1] !== 22) echo  '</div>';
                }
              // }

            ?>
          </div>
          <div class="row">
            <div class="reportTable">
              <div class="col-md-4">
                <label>&nbsp;</label><br/> 
                <input class="btn btn-danger" type="submit" id="submit" onclick="savingTemplate()" name="Submit" value="FILTER">
                <a href="<?php echo $url; ?>" class="btn btn-primary">CLEAR</a><br />
                <!-- <img src="loading-gif.gif" id="loading" style="width: 60px;margin-top: 30px;"/> -->
              </div>
            <!-- </div> -->
          </div>
        </form>
      </div>
  </section>
  <?php 
}else{
  $code = array();
}

if($_GET['Submit'] == "FILTER"){ // commented by pornima|| sizeof($code) == 0?>
<!-- <button onclick="exportToExcelAndPDF()">Export to Excel and PDF</button> -->
<script>
       async function exportToExcelAndPDF() {
            // Retrieve the row data dynamically from the grid
            const rowData = [];
            // gridApi.forEachNode(
            gridApi.forEachNodeAfterFilter(
                    node => node.data !== undefined ? rowData.push(node.data) : ""
                );

            // Log row data to ensure it is retrieved correctly
            // console.log('Row Data:', rowData);

            // Check if row data is retrieved correctly
            if (rowData.length === 0) {
                console.error('No data found in the grid.');
                return;
            }

            // Create a workbook and add worksheet with row data
            const workbook = XLSX.utils.book_new();
            const ws = XLSX.utils.json_to_sheet(rowData);
            XLSX.utils.book_append_sheet(workbook, ws, "Sheet1");

            // Write the workbook to a binary string
            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });

            // Convert the binary string to a base64 string (required by jsPDF)
            const excelData = new Uint8Array(excelBuffer);
            // const base64Excel = btoa(String.fromCharCode(...excelData));
            const base64Excel = btoa(new Uint8Array(excelBuffer).reduce(function (data, byte) {
                                    return data + String.fromCharCode(byte);
                                }, ''));

            // btoa(String.fromCharCode(...excelData));

            // Create a hidden link element and trigger a download
            const link = document.createElement('a');
            link.href = `data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,${base64Excel}`;
            link.download = 'table.xlsx';
            link.click();

            // Convert JSON data to array for jsPDF
            const pdfData = XLSX.utils.sheet_to_json(ws, { header: 1 });
            // console.log('PDF Data:', pdfData);

            // Check if PDF data is valid
            if (pdfData.length === 0) {
                console.error('No data found for PDF generation.');
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.autoTable({
                head: [pdfData[0]],
                body: pdfData.slice(1)
            });

            // Save the PDF
            doc.save('table.pdf');
        }
    </script>

<!-- HTML FOR DISPLAYING REPORT -->
<section class="panel" style="margin-bottom: -10px;">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="panel-action panel-action-toggle" data-panel-toggle=""></a>
    </div>
    <h2 class="panel-title">Report</h2>
    <!-- <p class="panel-subtitle">2 of 4 filters selected</p> -->
  </header>
 
  <div class="panel-body">
    <div class="col-md-3 type hidden" >
      <label for="type">Type:</label>
      <select name="type" id="typeSelect" class="typeSelect form-control">
        <option value></option>
        <?php
        $sql ='SELECT ID, Label FROM kreporttypes';
        $result = db::getInstanceMaster()->db_select($sql);
        for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row
            echo '<option value="'.$result['result_set'][$i]['ID'].'">' . $result['result_set'][$i]['Label'] . '</option>';
            break;
          }
        ?>
      </select>
    </div>

    <div class="col-md-3 template" >
      <label for="template">Template:</label>
      <select name="template" class="templateSelect form-control" id="templateSelect">
        <option value=""></option>
          <?php
            $sql = 'SELECT ID, TemplateName, TemplateTypeID  FROM kreport_template_data where ReportID = ' . $ReportID .' AND GroupID = '.$_SESSION['group_id'];
            $result1 = db::getInstanceMaster()->db_select($sql);
            // Output the number of rows
            $num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
            // echo "Number of rows in the result set: $num_rows<br>";
            
            // Loop through the result set and output options
            for ($i = 0; $i < $num_rows; $i++) {
              echo '<option class="gridTemplate' . $result1['result_set'][$i]['TemplateTypeID'] . '" value="' . $result1['result_set'][$i]['ID'] . '" >' . $result1['result_set'][$i]['TemplateName'] . '</option>';
            }
          ?>
      </select>
    </div>
    
      <div class="col-md-3" >
          <?php if($_SESSION['Category'] == 2){ ?>
            <button class="btn btn-secondary copyBtn" style='margin-top: 25px;display:none;width:100px;' onclick="openGroupModal()">Copy</button>
          <?php } ?>
          <button class="btn btn-secondary schdBtn" style='margin-top: 25px;display:none;width:100px;' onclick="openSchdModal()">Scheduler</button>
      </div>

    <div style='text-align:right;'>
      <input type="hidden" id="pdf_size" value="A4" />
      <input type="hidden" id="pdf_orientation" value="Landscape" />
      <input type="hidden" id="pdf_imgw" value="50" />
      <input type="hidden" id="pdf_font_size" value="9" />
      <input type="hidden" id="pdf_cell_padding" value="1" />
      <input type="hidden" id="group_display_type" value="multipleColumns" />
      <a href='#' class='btn btn-secondary renameBtn' style='margin-top: 25px;display:none;' onclick='renameTemplate();'>Rename</a>
      <a href='#' class='btn btn-secondary deleteBtn' style='margin-top: 25px;display:none;' onclick='deleteTemplate();'>Delete</a>
      <button id="pdf" class="btn btn-secondary" style="margin-top: 25px;width: 44px;font-size: 22px;margin-left: 5px;margin-right: 5px;background: none;color: #09284e;padding: 0 !important;" onClick="exportToPDF(gridApi)" title="Export to PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
      <button id="pdf" class="btn btn-secondary" style="margin-top: 25px;width: 44px;font-size: 22px;margin-left: 5px;margin-right: 5px;background: none;color: #09284e;padding: 0 !important;" onClick="exportToExcel(gridApi)" title="Export to Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
      <!-- <button id="pdf" class="btn btn-secondary" style="margin-top: 25px;" onClick="exportGridDataToPdf(gridApi)">Export to PDF 2</button> -->
      <a href='#' class='btn btn-primary saveBtn' style='margin-top: 25px;' onclick='$("#saveAsModal").modal("show");'>Save Template</a>
      <a href='#' class='btn btn-primary updateBtn' style='margin-top: 25px; margin-left: 10px;display:none;' onclick='save()'>Update</a>
    </div>
    
    <div class="modal fade" id="saveAsModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button> 
            <h4 class="modal-title">Add</h4>                                                             
          </div> 
          <div class="modal-body" >
            <!-- <form id="modalForm" name="modal" role="form">  -->
              <div id="ModelContent" >
                <input class=" form-control" type="text" id ="templatetitle" name="templatetitle" placeholder="Enter the template name:"><br/>
                <!-- <br/> -->
                <input class=" form-control" type="hidden" id ="templatedescription" name="templatedescription" placeholder="Enter the template description:">
                <input type="hidden" id ="templateRename" value="0" /> 
              </div>
              <div class="modal-footer" style="margin-top:10px;">					
                <button type="button" class="btn btn-primary" data-dismiss="modal" onClick="modalvalue()">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
              </div>
            <!-- </form> -->
          </div>   
        </div>                                                                       
      </div>                                          
    </div>
  </div>
  <!-- <button onclick="onBtPrint()">Print</button> -->
  <!-- <div id="groupColumnIds"></div> -->

  <!-- HTML FOR DISPLAYING PIVOT GRID -->
  <section class="pivotgrid-div"> 
    <!-- WRITTEN ON LINE 183 -->
  </section>

  <!-- HTML FOR DISPLAYING PIVOT GRID -->
  <section class="datagrid-div">
    <!-- WRITTEN ON LINE 189 -->
  </section>
</section>
   
<script>
  // let checkboxState = []; // Define as let for reassignment

  function printDiv(divId) {
      // var printContents = document.getElementById(divId).innerHTML;
      // var originalContents = document.body.innerHTML;
      // document.body.innerHTML = printContents;
      window.print();
      // document.body.innerHTML = originalContents;
  }

  function onBtPrint() {
    // console.log("btn clicked");
    setPrinterFriendly(gridApi);
    // window.print();
    setTimeout(() => {
      // print();
      printDiv("myGrid");
      setNormal(gridApi);
    }, 2000);
  }

  function setPrinterFriendly(api) {
    // console.log("set printer");
    const eGridDiv = document.querySelector("#myGrid");
    eGridDiv.style.width = "";
    eGridDiv.style.height = "";
    api.setGridOption("domLayout", "print");
  }

  function setNormal(api) {
    console.log("set normal");
    const eGridDiv = document.querySelector("#myGrid");
    eGridDiv.style.width = "1380px";
    eGridDiv.style.height = "600px";

    api.setGridOption("domLayout", undefined);
  }

  function deleteTemplate(){
    var templateId = $("#templateSelect").val();
    if(templateId > 0){
      if(confirm("Are you sure you want to delete the selected template?")){
        console.log("Deleting Template")
        $.post(
          'AgGridReportDataStorage.php', 
          { ReportID:<?php echo $ReportID; ?>,deleteID:1, templateId:templateId} ,
          function(returnedData){
            console.log(returnedData);
            alert("Template Deleted");
            $("#templateSelect").val("");
            $("#templateSelect option[value='" + templateId + "']").remove();
            $(".renameBtn").hide();
            $(".deleteBtn").hide();
            $(".updateBtn").hide();
            $(".copyBtn").hide();
            $(".schdBtn").hide();
          }, 
          'json')
          .fail(function(){
              console.log("error");
              alert("Some error occured");
          });
      }else{
        // alert("Na")
      }
    }
  }


  function scheduleReportSubmit(){
    var templateId = $("#templateSelect").val();
    var selectedUserIds = $('#sch_users').val();
    var sch_users_email = $('#sch_users_email').val();
    var sch_users_whatsapp = $('#sch_users_whatsapp').val();
    var sch_time = $("#sch_time").val();

    /* 🔹 format all GET parameters dynamically (with dropdown label detection) */

    let formattedParams = [];
    const skipKeys = ['ReportID', 'view', 'template', 'username', 'print', 'Submit', 'company']; // skip system params

    for (let key in reportParams) {
      if (!reportParams[key] || skipKeys.includes(key)) continue;

      let value = String(reportParams[key]).trim();
      let label = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()); // default fallback

      // ✅ Try to find the <label> associated with this input/select element
      const fieldEl = document.querySelector(`[name='${key}'], #${key}`);
      if (fieldEl) {
        const parent = fieldEl.closest('div'); // find enclosing div (label usually inside)
        const labelEl = parent ? parent.querySelector('label') : null;
        if (labelEl && labelEl.textContent.trim() !== '') {
          label = labelEl.textContent.replace('*', '').trim(); // use form label, remove asterisk
        }
      }

      // 🔸 Detect dropdowns and fetch selected label instead of ID
      const dropdown = document.querySelector(`#${key}`);
      if (dropdown && dropdown.tagName === 'SELECT') {
        const selectedOption = dropdown.options[dropdown.selectedIndex];
        if (selectedOption && selectedOption.text) {
          value = selectedOption.text.trim();
        }
      }

      // 🔸 Format date (YYYY-MM-DD → DD-MM-YYYY)
      if (/^\d{4}-\d{2}-\d{2}/.test(value)) {
        const [yyyy, mm, dd] = value.split('T')[0].split('-');
        value = `${dd}-${mm}-${yyyy}`;
      }

      formattedParams.push(`${label}: ${value}`);
    }

    var formattedParamsString = formattedParams.join(' | ');
    console.log("formattedParamsString",formattedParamsString);

    if(templateId > 0){
      // if(confirm("Are you sure you want to delete the selected template?")){
        console.log("Schedule Template")
        $.post(
          'setReportSchedule.php', 
          { ReportID:<?php echo $ReportID; ?>, templateId:templateId, sch_time:sch_time, selectedUserIds: selectedUserIds, sch_users_email:sch_users_email,sch_users_whatsapp:sch_users_whatsapp, filters: formattedParamsString} ,
          function(returnedData){
            console.log(returnedData);
            alert("Report scheduled successfully!");
          }, 
          'json')
          .fail(function(){
              console.log("error");
              alert("Some error occured");
          });
      // }else{
      //   // alert("Na")
      // }
    }
  }

  //Copy report template
  function copyReportTemplate(){
    var templateId = $("#templateSelect").val();

     // ✅ Get all selected checkboxes with class 'item-checkbox'
    var selectedGroupIds = [];
    $(".group-checkbox:checked").each(function () {
        selectedGroupIds.push($(this).val());
    });

    if(templateId > 0){
      // if(confirm("Are you sure you want to delete the selected template?")){
        console.log("Copy Template")
        $.post(
          'AgGridReportDataStorage.php', 
          { ReportID:<?php echo $ReportID; ?>,copyTemplateID:1, templateId:templateId, selectedGroups: selectedGroupIds} ,
          function(returnedData){
            console.log(returnedData);
            alert("Template copy");
            $("#templateSelect").val("");
            $("#templateSelect option[value='" + templateId + "']").remove();
            $(".renameBtn").hide();
            $(".deleteBtn").hide();
            $(".updateBtn").hide();
            $(".copyBtn").hide();
            $(".schdBtn").hide();
          }, 
          'json')
          .fail(function(){
              console.log("error");
              alert("Some error occured");
          });
      // }else{
      //   // alert("Na")
      // }
    }
  }

  function renameTemplate(){
    $(".modal-title").html("Rename");
    $("#templatedescription").hide();
    $("#templatetitle").val($(".templateSelect option:selected").text());
    $("#templateRename").val($(".templateSelect").val());
    $("#saveAsModal").modal("show");

    // $("#templatedescription").show();
    // $(".modal-title").html("Add");
    // $("#templatetitle").val("Add");
    // $("#templateRename").val('0');
  }

  function modalvalue(){
      // console.log("<= ***** SAVE AS ***** =>");
      // templateId=0;
      tempName = $("#templatetitle").val();
      templateDescription = $("#templatedescription").val();
      // console.log("tempName",tempName);
      // $("#templatetitle").val("");
      $("#templatedescription").val("");
      tempName_for_modal=tempName;
      h = gridApi.getState();
      console.log("Checking getState() fn before saving", h)
      h.repeatParent= $("#repeatParent").prop("checked") == true ? 1 : 0; 
      j = gridApi.getColumnState();
      h.columns=j;
      h.columnDefs = storeColDefs;
      h.checkboxState= checkboxState;
      
      h.repeatParent= $("#repeatParent").val() === "on" ? 1 : 0; 
      h.showGrandTotal = $("#showGrandTotal").val() === "on" ? 1 : 0; 
      h.pdf_size = $("#pdf_size").val();
      h.pdf_orientation = $("#pdf_orientation").val();
      h.pdf_imgw = $('#pdf_imgw').val();
      h.pdf_font_size = $("#pdf_font_size").val();
      h.pdf_cell_padding = $('#pdf_cell_padding').val();
      h.groupDisplayType = $('#group_display_type').val();
      h.sort_Column = $('#sort_Column').val();
      

      const groupState = [];
      // gridApi.forEachNode(node => {
      //     if (node.group) {
      //         groupState.push({ key: node.key, expanded: node.expanded });
      //     }
      // });
      // h.groupState = groupState;
      pivotglobalstate = h;
      // console.log("pornima pivoteglobalstate",pivotglobalstate);
      var templateRename = $("#templateRename").val();

      
      // ✅ Step 1: Check Columns
      const checkboxes = document.querySelectorAll('.ag-column-select-list .ag-checkbox-input');
      let anyChecked = Array.from(checkboxes).some(cb => cb.checked);

      // ✅ Step 2: Check Row Groups
      const rowGroupPanel = document.querySelector('.ag-column-drop-row-group');
      const rowGroupColumns = rowGroupPanel ?
          rowGroupPanel.querySelectorAll('.ag-column-drop-cell-text') : [];

      // ✅ Step 3: Check Values
      const valuesPanel = document.querySelector('.ag-column-drop-aggregation');
      const valueColumns = valuesPanel ?
          valuesPanel.querySelectorAll('.ag-column-drop-cell-text') : [];

      // ✅ Combined condition — show alert only if all are empty
      if (!anyChecked && rowGroupColumns.length === 0 && valueColumns.length === 0) {
          // alert("Please select at least one column, add a Row Group, or add a Value before saving the template.");
          // return false;
      }

      if(tempName.length == 0){
        alert("Please add template name.");
        return false;
      }

      $("#templatetitle").val("");

      // sendStorageRequestSaveAs(tempName, "json", "POST", pivotglobalstate, templateDescription, 0, templateRename);
  }
  
</script>   

<!-- SCRIPT FOR DATA GRID -->
<script>
  window.jsPDF = window.jspdf.jsPDF;
  /*
  function loadDataGridData(){
    let selectedId=[];
    let isArray=[];
    $(() => {
      let changedBySelectBox;
      let titleSelectBox;
      let clearSelectionButton;
      let showIdButton;
      let editingType=0;
      const scrollingModeOptions = ['standard', 'virtual'];
      const dataGrid = $('#gridContainer').dxDataGrid({
        dataSource: heet,
        editing: {
          mode:editingType,
        
          allowUpdating: true,
          allowAdding: true,
          allowDeleting: true,
          selectTextOnEditStart: true,
          startEditAction: 'click',
        },
        selection: {
          mode: 'multiple',
        },
        pager: {
          showPageSizeSelector: true,
          allowedPageSizes: [10, 25, 50, 100,500],
        },
        groupPanel: {
          visible: true,
        },
        sorting: {
          mode: 'multiple',
        },
        filterRow: {
          visible: true,
          applyFilter: 'auto',
        },
        headerFilter: {
          visible: true,
        },
        filterPanel: { visible: true },
        columnChooser: {
          enabled: true
        },
        // focusedRowEnabled: true,
        summary: {
          totalItems: [{
            name: 'SelectedRowsSummary',
            showInColumn: 'SaleAmount',
            displayFormat: 'Sum: {0}',
            valueFormat: 'Meter',
            summaryType: 'custom',
          }],
          calculateCustomSummary(options) {
            if (options.name === 'SelectedRowsSummary') {
              if (options.summaryProcess === 'start') {
                options.totalValue = 0;
              }
              if (options.summaryProcess === 'calculate') {
                if (options.component.isRowSelected(options.value.ID)) {
                  options.totalValue += options.value.SaleAmount;
                }
              }
            }
          },
        },
        onSelectionChanged(selectedItems) {
          var selectedKeys = dataGrid.getSelectedRowKeys();
          var selectedData = dataGrid.getSelectedRowsData();
          idArray = selectedKeys.map(item => item.id);
          const data = selectedItems.selectedRowsData;
          if (data.length > 0) {
            $('#selected-items-container').text(
              data
                .map((value) => `${value.FirstName} ${value.LastName}`)
                .join(', '),
            );
          } else {
            $('#selected-items-container').text('Nobody has been selected');
          }
          // if (!changedBySelectBox) {
          //   titleSelectBox.option('value', null);
          // }

          changedBySelectBox = false;
          clearSelectionButton.option('disabled', !data.length);
        },
        toolbar: {
          items: [
            {
              widget: 'dxButton',
              location: 'before',
              options: {
                text: 'Clear Selection',
                disabled: true,
                onInitialized(e) {
                  clearSelectionButton = e.component;
                },
                onClick() {
                  dataGrid.clearSelection();
                },
              },
            },
            {
              text:'Hide Columns',
              onClick(){
                dataGrid.showColumnChooser();
              },
            },
            {
              widget: 'dxButton',
              location: 'before',
              options: {
                text: 'Show ID',


                onClick() {
                  // console.log(idArray);
                },
              },
            },
          ],
        },
        export: {
          enabled: true,
          allowExportSelectedData: true,
        },
        stateStoring: {
          enabled: true,
          type: "custom",
          customLoad: function () {
            // console.log("load called from datagrid");
              return sendStorageRequest("storageKey", "json", "GET");
          },
          customSave: function (state) {
            // console.log("save called from datagrid");
            // console.log("save",state);
            // alert("jj");
            passingstate(state);
            if(kreon==1){
              // console.log("in if condition of cutomSave");
              sendStorageRequest("storageKey", "text", "PUT", state);
            }
          }
        },
        scrolling:{
          mode:'virtual'
        },
        columnChooser: {
          enabled: true,
          mode: "dragAndDrop" // or "select"
        },
        onExporting(e) {
          const workbook = new ExcelJS.Workbook();
          const worksheet = workbook.addWorksheet('Employees');
          DevExpress.excelExporter.exportDataGrid({
            component: e.component,
            worksheet,
            autoFilterEnabled: true,
          }).then(() => {
            workbook.xlsx.writeBuffer().then((buffer) => {
              saveAs(new Blob([buffer], { type: 'application/octet-stream' }), ''+tempName+'-'+getTodaysDate()+'-'+time+'.xlsx');
            });
          });
        },
      }).dxDataGrid('instance');
      const resizingModes = ['batch', 'form'];
      $('#editing-mode').dxCheckBox({
        text: 'Show Page Size Selector',
        value: true,
        onValueChanged(data) {
          dataGrid.option('pager.showPageSizeSelector', data.value);
        },
      });
      $('#scrolling-mode').dxSelectBox({
        value: 'standard',
        items: scrollingModeOptions,
        inputAttr: { 'aria-label': 'Scrolling Mode' },
        width: 250,
        onValueChanged(e) {
          dataGrid.option('scrolling.mode', e.value);
        },
      }).dxSelectBox('instance');
    });
  }
  */
</script>

<!-- SCRIPT FOR PIVOT GRID -->
<script>
  function save() {
    // alert("SAVING");
    // pivotglobalstate = h;
    // console.log("sent for saving",pivotglobalstate);
    // // console.log();
    // return sendStorageRequest("organisatieKey", "text", "PUT", pivotglobalstate);
    h = gridApi.getState();
    console.log("repeatParent",$("#repeatParent").val());
    h.repeatParent= $("#repeatParent").prop("checked") == true ? 1 : 0; 
    h.showGrandTotal = $("#showGrandTotal").val() === "on" ? 1 : 0; 
    h.pdf_size = $("#pdf_size").val();
    h.pdf_orientation = $("#pdf_orientation").val();
    h.pdf_imgw = $('#pdf_imgw').val();
    h.pdf_font_size = $("#pdf_font_size").val();
    h.pdf_cell_padding = $('#pdf_cell_padding').val();
    h.checkboxState= checkboxState;
    h.groupDisplayType = $('#group_display_type').val();

    const chartModels = gridApi.getChartModels();
    h.chartModels = chartModels || [];
    console.log("Saved chartModels:", h.chartModels);
    

    var sort_ColumnsValues = [];

    $("input[name='sort_ColumnsValues[]']:checked").each(function () {
        sort_ColumnsValues.push($(this).val());
    });
    h.sort_Column = sort_ColumnsValues;

    j=gridApi.getColumnState();
    h.columns=j;
    h.columnDefs=storeColDefs;
    pivotglobalstate = h;
    // console.log("sent for saving",h);
    // console.log("Sort Mode in save function ",gridApi.getFilterModel());
    // console.log(pivotglobalstate);
    // console.log("save",count++);
    // console.log(pivotglobalsource.concat(j));;
    // console.log("h",h);
    // console.log("j",j);
    // return sendStorageRequest("organisatieKey", "text", "PUT", pivotglobalstate);

    
    // ✅ Step 1: Check Columns
    const checkboxes = document.querySelectorAll('.ag-column-select-list .ag-checkbox-input');
    let anyChecked = Array.from(checkboxes).some(cb => cb.checked);

    // ✅ Step 2: Check Row Groups
    const rowGroupPanel = document.querySelector('.ag-column-drop-row-group');
    const rowGroupColumns = rowGroupPanel ?
        rowGroupPanel.querySelectorAll('.ag-column-drop-cell-text') : [];

    // ✅ Step 3: Check Values
    const valuesPanel = document.querySelector('.ag-column-drop-aggregation');
    const valueColumns = valuesPanel ?
        valuesPanel.querySelectorAll('.ag-column-drop-cell-text') : [];

    // ✅ Combined condition — show alert only if all are empty
    if (!anyChecked && rowGroupColumns.length === 0 && valueColumns.length === 0) {
        // alert("Please select at least one column, add a Row Group, or add a Value before saving the template.");
        // return false;
    }

    // if(templateId)
    // console.log("pivotglobalstate", pivotglobalstate);
    return sendStorageRequestSaveAs(tempName, "json", "POST", pivotglobalstate, templateDescription, templateId, 0);
  } 

  function passingstate(state) {
    // console.log("in global save", state);
    globalstate = state;
    expandAll = [];
    filterValues = [];
    // console.log("passing");
    globalstate.fields.forEach(function(item, index) {
        if (item.area == "row" || item.area == "column") {
            expandAll.push(item.dataField);
            count++;
            item.expanded = true;
        }
        if (item.filterValues != null && Array.isArray(item.filterValues)) {
            filterValues.push({ dataField: item.dataField, filterValues: item.filterValues });
        }
    });
    // updateFiltersUI();
  }

  function getDataFromAPI(reportID, templateId, tempName, templateDescription, typeId, callback) {
    console.log("getDataFromAPI",reportID, templateId, tempName, templateDescription, typeId, callback)
    $.ajax({
      url: `AgGridReportDataStorage.php`,
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json"
      },
      data: { ReportID:reportID,templateId:templateId,tempName:tempName,templateDescription:templateDescription,typeID:typeId} ,
      type: "GET", 
      dataType: "json",
      success: function(data) {
        // console.log("Got Data frm API", data);
        callback(null, data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log("Got ERROR Data frm API", jqXHR);
        console.log("Got ERROR Data frm API", textStatus);
        callback(new Error(textStatus || errorThrown));
      }
    });
  }

  function sendStorageRequestSaveAs(tempName, datatype, type, data,templateDescription, templateId, renameID = 0) {
    console.log("<=***** SAVING *****=>",tempName, datatype, type, data,templateDescription, templateId, renameID);

    if (data.hasOwnProperty('rowGroupExpansion')) {
        delete data.rowGroupExpansion;
        // console.log('rowGroupExpansion removed successfully', data);
    } else {
        // console.log('rowGroupExpansion not found');
    }

    // alert("in function");
    $.post(
        'AgGridReportDataStorage.php', 
        { ReportID:<?php echo $ReportID; ?>,renameID:renameID, templateId:templateId,tempName:tempName,templateDescription:templateDescription,typeID:1,data: JSON.stringify(data)} ,
        function(returnedData){
          console.log(returnedData);
          
          if(+renameID > 0){
            $("#templatedescription").show();
            $(".modal-title").html("Add");
            $("#templatetitle").val("Add");
            $("#templateRename").val('0');
            // $(".templateSelect option[value='" + renameID + "']").text(tempName);
            $('.templateSelect option:selected').text(tempName);
            // $('.templateSelect option:contains("'+$('#templateSelect').find('option:selected').text()+'")').text(tempName);
          }else{
            if(+templateId == 0){
              templateId = returnedData;
              $('#templateSelect').append($("<option selected></option>").attr("value", returnedData).text(tempName)); 
            }
          }
        }, 
        'json')
        .fail(function(){
            console.log("error",renameID);
            if(+renameID > 0){
              $("#templatedescription").show();
              $(".modal-title").html("Add");
              $("#templatetitle").val("Add");
              $("#templateRename").val('0');
            }
        });
    return;





    // var deferred = $.Deferred();
    // console.log(data);
    // $.ajax({
    //   url: `AgGridReportDataStorage.php`,
    //   headers: {
    //     Accept: "application/json",
    //     "Content-Type": "application/json"
    //   },
    //   data: { ReportID:<?php echo $ReportID; ?>,templateId:templateId,tempName:tempName,templateDescription:templateDescription,typeID:typeId,data: JSON.stringify(data)} ,
    //   type: "POST", 
    //   dataType: "json",
    //   success: function(data) {
    //     console.log("Got Data frm API", data);
    //     deferred.resolve(data);
    //     // callback(null, data);
    //   },
    //   error: function(jqXHR, textStatus, errorThrown) {
    //     console.log("Got ERROR Data frm API", jqXHR);
    //     console.log("Got ERROR Data frm API", textStatus);
    //     deferred.reject();
    //     // callback(new Error(textStatus || errorThrown));
    //   }
    // });
  }

  function sendStorageRequest(key, datatype, type, data) {
    var deferred = $.Deferred();
    if (data !== undefined) var d = JSON.stringify(data);
    else var d = "";
    // console.log(d);
    // console.log("ss",tempName_for_modal);
    if(call_for_template){
        templateId=0
        tempName=tempName_for_modal;
        // console.log(tempName_for_modal)
    }else{
      templateId = $("#templateSelect").val();
    }
    if(type === "PUT"){
        type = "POST";
        datatype = "json";
    }
    // console.log(tempName);
    // console.log("templateId", templateId);
    // console.log(call_for_tem
    var storageRequestSettings = {
        // url: "AgGridReportDataStorage.php?ReportID=<?php echo $ReportID; ?>"+
        //       "&templateId=" + templateId +
        //       "&tempName="+ tempName +
        //       "&templateDescription="+ templateDescription + 
        //       "&typeID=" + typeId +
        //       "&data=" + d ,
        url: "AgGridReportDataStorage.php",
        data: {ReportID:<?php echo $ReportID; ?>,templateId:templateId,tempName:tempName,templateDescription:templateDescription,typeID:typeId,data:d},
        // headers: {
        //   Accept: "text/html",
        //   "Content-Type": "text/html",
        // },
        headers: {
        Accept: "application/json",
        "Content-Type": "application/json"
        },
        type: type,
        dataType: datatype,
        success: function(data) {
          // console.log(data)
          deferred.resolve(data);
          // console.log("tempname",tempName);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown)
          console.log(textStatus)
          deferred.reject();
        },
    };
    templateId=ogTemplateId;
    tempName='';
    if (data) {
        storageRequestSettings.data = JSON.stringify(data);
    } else {
    }
    $.ajax(storageRequestSettings);
    return deferred.promise();
  }

  function saveState() {
    // h=gridApi.getState();
    h=gridApi.getColumnState();
    // console.log("In Save State",h); 
    // console.log("Full state");
    // alert("h");
    // console.log(gridApi.getState());
    // console.log(gridApi.getFilterModel());

    // savedFilterModel = gridApi.getFilterModel();
    // var keys = Object.keys(savedFilterModel);
    // var savedFilters = keys.length > 0 ? keys.join(", ") : "(none)";
    // console.log(savedFilters);

    // gridApi.setFilterModel('{"SABDEPART": {"filterType": "multi","filterModels": [{"filterType": "text","type": "contains","filter": "local"},null]}}');
    // gridApi.setFilterModel({"SABDEPART": {"filterType": "multi","filterModels": [null,{"values": ["Local Sheet"],"filterType": "set"}]},"PPROCESS": {"filterType": "multi","filterModels": [null,{"values": ["Stenter-Eff"],"filterType": "set"}]}});
  }   

  // Row Data Interface
  class CompanyLogoRenderer {
    eGui;
    modal;
    modalContent;
    modalImage;
    closeButton;

    init(params) {
      // console.log("params", params);
      let companyLogo = document.createElement('img');  // Create an image element
      companyLogo.src = "https://wsrv.nl/?url=<?php echo URL_ROOT;?>" + params.value;
      // console.log(companyLogo.src);
      companyLogo.setAttribute('style', 'display: block; width: 100px; height: auto; max-height: 50%; margin-right: 12px; filter: brightness(1.1); cursor: pointer;');
      // Add click event to show modal with enlarged image
      companyLogo.addEventListener('click', this.showModal.bind(this, companyLogo.src));
      this.eGui = document.createElement('span');
      this.eGui.setAttribute('style', 'display: flex; height: 100%; width: 100%; align-items: center');
      this.eGui.appendChild(companyLogo);
      this.createModal();
    }

    getGui() {
        return this.eGui;
    }

    refresh(params) {
        return false;
    }

    createModal() {
      // Create modal element
      this.modal = document.createElement('div');
      this.modal.setAttribute('style', 'display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.8); align-items: center; justify-content: center;');

      // Create modal content wrapper
      this.modalContent = document.createElement('div');
      this.modalContent.setAttribute('style', 'position: relative; display: flex; align-items: center;');

      // Create modal image
      this.modalImage = document.createElement('img');
      this.modalImage.setAttribute('style', 'max-width: 60%; max-height: 60%; margin: auto; display: block;');

      // Create close button
      this.closeButton = document.createElement('span');
      this.closeButton.innerHTML = '&times;';
      this.closeButton.setAttribute('style', 'color: white; font-size: 40px; font-weight: bold; cursor: pointer; margin-left: 20px; background-color: rgba(0, 0, 0, 0.5); padding: 10px; border-radius: 50%;');
      this.closeButton.addEventListener('click', this.hideModal.bind(this));
      this.modalContent.appendChild(this.modalImage);
      this.modalContent.appendChild(this.closeButton);
      this.modal.appendChild(this.modalContent);
      document.body.appendChild(this.modal);
    }

    showModal(src) {
      this.modalImage.src = src;
      this.modal.style.display = 'flex';
    }

    hideModal() {
      this.modal.style.display = 'none';
    }
  }
  /*
  class CompanyLogoRenderer1 {
    eGui;    
    // Optional: Params for rendering. The same params that are passed to the cellRenderer function.
    init(params) {
      // console.log("params",params);
      // alert("llllll ")
      let companyLogo = document.createElement('img');
      companyLogo.src = params.value;
      // console.log(companyLogo.src);
      // companyLogo.src = https://images.pexels.com/photos/674010/pexels-photo-674010.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1
      companyLogo.setAttribute('style', 'display: block; width: 25px; height: auto; max-height: 50%; margin-right: 12px; filter: brightness(1.1)');
      let companyName = document.createElement('p');
      companyName.textContent = params.value;
      companyName.setAttribute('style', 'text-overflow: ellipsis; overflow: hidden; white-space: nowrap;');
      this.eGui = document.createElement('span');
      this.eGui.setAttribute('style', 'display: flex; height: 100%; width: 100%; align-items: center')
      this.eGui.appendChild(companyLogo)
      // this.eGui.appendChild(companyName)
    }
    
    // Required: Return the DOM element of the component, this is what the grid puts into the cell
    getGui() {
      return this.eGui;
    }
    
    // Required: Get the cell to refresh.
    refresh(params) {
      return false
    }
  }*/
  
  class MedalRenderer  {
    init(params) {
        this.total = "100";

        this.eGui = document.createElement('div');
        this.eGui.style.textAlign = "left";//center
        this.eGui.classList.add('ag-column-panel')
        this.eGui.classList.add('ag-grid-custom-settings')

        const label = document.createElement('span');
        label.innerText = "Testing Filters";
        this.eGui.appendChild(label);

        this.eButton = document.createElement('button');
        this.buttonListener = this.buttonClicked.bind(this);
        this.eButton.addEventListener("click", this.buttonListener);
        this.eButton.textContent = 'Apply Filters';

        this.eSelect = document.createElement('select');

        this.eGui.appendChild(label);
        this.eGui.appendChild(this.eButton);
        this.eGui.innerHTML = ''
          + '<div class="ag-pivot-mode-panel">'
            + '<div class="ag-pivot-mode-select ag-labeled ag-label-align-right ag-toggle-button ag-input-field">'
              + '<div class="ag-input-field-label ag-label ag-toggle-button-label" style="font-weight: bold">Custom Report Settings</div>'
            + '</div>'
          + '</div>'

          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select" style="max-height1: 100px;flex: unset;"><br />'
            + '<label>Theme Options: </label>'
            + '<select id="classSelector" class="form-control" onChange="$(\'#myGrid\').attr(\'class\', \'my-grid \' + this.value); $(\'#myChart\').attr(\'class\', \'my-chart \' + this.value);" style="margin-bottom: 10px">'
            + '<option value="ag-theme-balham">Balham</option><option value="ag-theme-alpine">Alpine</option><option value="ag-theme-material">Material</option><option value="ag-theme-quartz">Quartz</option></select>'
          + '</div>'
          
          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select" style="max-height1: 100px;flex: unset;"><br />'
            + '<div class="ag-pivot-mode-panel">'
              + '<label>Advance Filters: </label><br />'
              + '<div class="switchbox"><label class="switch"><input type="checkbox" id="advanced-filter-switch" onchange="setGridOptionsBasedOnCheckbox1()" /><span class="slider round"></span></label></div>'
              + '<!--input type="checkbox" name="test" id="test" value="1" data-plugin-ios-switch="" onchange="setGridOptionsBasedOnCheckbox1()" style="display: none;" >'
              + '<!--div class="ag-pivot-mode-select ag-labeled ag-label-align-right ag-toggle-button ag-input-field" style="display: block;">'
                + '<div ref="eLabel" class="ag-input-field-label ag-label ag-toggle-button-label" aria-hidden="false" id="ag-41-label1"></div>'
                + '<div ref="eWrapper" class="ag-wrapper ag-input-wrapper ag-toggle-button-input-wrapper" role="presentation">'
                  + '<input ref="eInput" class="ag-input-field-input ag-toggle-button-input" aria-labelledby="ag-41-label1" type="checkbox" id="ag-41-input1" tabindex="0">'
                + '</div>'
              + '</div-->'
            + '</div>'
          + '</div>' 
          
          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select" style="max-height1: 100px;flex: unset;"><br />'
            + '<div class="ag-pivot-mode-panel">'
              + '<label>Repeat parent value : </label><br />'
              + '<div class="switchbox"><label class="switch"><input type="checkbox" id="repeatParent" onchange="setOpenedGroupOnRepeatParent()" /><span class="slider round"></span></label></div>'
              + '<!--input type="checkbox" name="test" id="test" value="1" data-plugin-ios-switch="" onchange="setGridOptionsBasedOnCheckbox1()" style="display: none;" >'
              + '<!--div class="ag-pivot-mode-select ag-labeled ag-label-align-right ag-toggle-button ag-input-field" style="display: block;">'
                + '<div ref="eLabel" class="ag-input-field-label ag-label ag-toggle-button-label" aria-hidden="false" id="ag-41-label1"></div>'
                + '<div ref="eWrapper" class="ag-wrapper ag-input-wrapper ag-toggle-button-input-wrapper" role="presentation">'
                  + '<input ref="eInput" class="ag-input-field-input ag-toggle-button-input" aria-labelledby="repeatParent" type="checkbox" id="repeatParent" tabindex="0">'
                + '</div>'
              + '</div-->'
            + '</div>'
          + '</div>' 
          
          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select" style="max-height1: 100px;flex: unset;"><br />'
            + '<div class="ag-pivot-mode-panel">'
              + '<label>Show Grand Total : </label><br />'
              + '<div class="switchbox"><label class="switch"><input type="checkbox" id="showGrandTotal" onchange="setShowGrandTotal()" /><span class="slider round"></span></label></div>'
              + '<!--input type="checkbox" name="test" id="test" value="1" data-plugin-ios-switch="" onchange="setShowGrandTotal()" style="display: none;" >'
              + '<!--div class="ag-pivot-mode-select ag-labeled ag-label-align-right ag-toggle-button ag-input-field" style="display: block;">'
                + '<div ref="eLabel" class="ag-input-field-label ag-label ag-toggle-button-label" aria-hidden="false" id="ag-41-label1"></div>'
                + '<div ref="eWrapper" class="ag-wrapper ag-input-wrapper ag-toggle-button-input-wrapper" role="presentation">'
                  + '<input ref="eInput" class="ag-input-field-input ag-toggle-button-input" aria-labelledby="showGrandTotal" type="checkbox" id="repeatParent" tabindex="0">'
                + '</div>'
              + '</div-->'
            + '</div>'
          + '</div>'

          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select" style="max-height1: 150px;overflow:auto;flex: unset;"><br />'
            + '<label>Group Display Type: </label>'
            + '<select id="groupDisplayType" class="form-control" onchange="setGroupDisplayType()">'
              + '<option value="multipleColumns">multipleColumns</option>'
              + '<option value="singleColumn">singleColumn</option>'
              + '<option value="groupRows">groupRows</option>'
            + '</select>'
            + '<div id=""></div>'
          + '</div>'

          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select groupColumnIdsDiv" style="display:none;max-height: 100px;overflow:auto;flex: unset;"><br />'
            + '<label>Show Row Group Total: </label>'
            + '<div id="groupColumnIdsDiv"></div>'
          + '</div>'

          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select groupColumnIdsDivExpand" style="display:none;max-height: 100px;overflow:auto;flex: unset;"><br />'
            + '<label>Expand Row Group : </label>'
            + '<div id="groupColumnIdsDivExpand"></div>'
          + '</div>'

          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select" style="max-height1: 100px;overflow:auto;flex: unset;"><br />'
            + '<label>Export PDF Settings: </label>'
            + '<select id="pdfSizeclassSelector" class="form-control" onChange="$(\'#pdf_size\').attr(\'value\', this.value); ">'
              + '<option value="A4">A4</option>'
              + '<option value="A3">A3</option>'
              + '<option value="A2">A2</option>'
              + '<option value="A1">A1</option>'
              + '<option value="A5">A5</option>'
              + '<option value="LETTER">Letter</option>'
              + '<option value="LEGAL">Legal</option>'
            + '</select>'
            + '<select id="pdfOrientationclassSelector" class="form-control" onChange="$(\'#pdf_orientation\').attr(\'value\', this.value); " style="margin: 10px 0">'
              + '<option value="Landscape">Landscape</option>'
              + '<option value="Portrait">Portrait</option>'
            + '</select>'
            + '<label>Image Width (px): </label>'
            + '<span style="font-size: 9px;">If the image doesn\'t come as desired on the PDF, try adjusting the PDF Page size. </span>'
            + '<input id="pdfImgwclassSelector" class="form-control" value="50" onChange="$(\'#pdf_imgw\').attr(\'value\', this.value); " style="margin: 0 0 10px 0">'
            + '<label>Font Size (px): </label>'
            + '<input id="pdfFontSizeclassSelector" class="form-control" value="9" onChange="$(\'#pdf_font_size\').attr(\'value\', this.value); " style="margin: 0 0 10px 0">'
            + '<label>Cell Padding (px): </label>'
            + '<input id="pdfCellPaddingclassSelector" class="form-control" value="2" onChange="$(\'#pdf_cell_padding\').attr(\'value\', this.value); " style="margin: 0 0 10px 0">'
            + '<div id=""></div>'
          + '</div>'
          ;
    }

    buttonClicked() {
        // alert(`${this.total} medals won!`)
    }

    getGui() {
        return this.eGui
    }

    refresh(params) {
        return false;
    }

    destroy() {
        // this.eButton.removeEventListener("click", this.buttonListener);
    }
  }

  /* START OF DRILL SCRIPTS */
    function makeMasterCellRenderer(params, col) {
			// console.log("in makeMasterCellRenderer", params)
      // console.log("Rendering Master Cell for Row:", params.node.data?.id || params.node.id);
      if (!params.node || !params.node.data) {
          console.error("Invalid node data, skipping rendering.");
          return document.createElement('span'); // Avoid undefined references
      }

			let container = document.createElement('div');
			let chevron = document.createElement('img');
			let span = document.createElement('span');
      let rowId = params?.data?.id || params?.node?.id || 'unknown'; // ← Fallback added
      // let isExpanded = !!params.context?.chevKeyMap?.[`row-${rowId}`];
      let isExpanded =  params.api.getRowNode(rowId)?.expanded;
      // let openCol = params.context?.chevKeyMap?.[`row-${rowId}`] || null;
      var openCol = params.context ? params.context.selectedDetail : null;

      // console.log("=>", rowId, isExpanded, col, openCol, params.context)
      if (rowId !== 'unknown') {
          chevron.classList.add(`row-${rowId}`);
      }
      // chevron.classList.add(`row-${rowId}`); // Avoid 'row-undefined'
      chevron.classList.add('pointer-class');
      container.classList.add('master-container');

			let chevronState = isExpanded && col === openCol ? treeOpen : treeClosed;
			chevron.setAttribute('src', chevronState);
      // chevron.src = isExpanded ? treeOpen : treeClosed;
      span.innerText = params.value || '';
      container.appendChild(chevron);
      container.appendChild(span);

      chevron.addEventListener('click', (event) => {
          // console.log("Opening detail grid...");
          let clickedChevron = event.target;
          openDetail(params, col, clickedChevron);
      });

      return container;
		}

    const openDetail = (params, column, cellRenderer) => {
        console.log("In openDetail");
        // Ensure gridApi is accessible
        if (!gridOptions || !gridApi || !params.node) {
            console.error("Grid or node not initialized.");
            return;
        }

        let className = '';
        cellRenderer.classList.forEach(cssClass => {
            if (cssClass.startsWith('row')) {
                className = cssClass;
            }
        });
        if (!className) {
            console.error("Invalid class name reference in chevron.");
            return;
        }
        // console.log(gridOptions.context);
        // setTimeout(() => {
        //     console.log(gridOptions.context.chevKeyMap);
        // }, 500);
        if (gridOptions.context.chevKeyMap[className] === column && params.node.expanded) {
            // console.log("Before Closing:", params.node.data);
            params.node.setExpanded(false);
            // console.log("After Closing:", params.node.data);
            cellRenderer.setAttribute('src', treeClosed);

            // **Fix: Remove reference properly to prevent undefined errors**
            delete gridOptions.context.chevKeyMap[className];
            // **Explicitly refresh the grid to ensure proper cleanup**
            // params.api.refreshCells({ force: true });
            // setTimeout(() => {
            //     console.log("Refreshing row renderers...");
            //     // params.api.redrawRows({ rowNodes: [params.node] });
            // }, 2000);

            return;
        }

        gridApi.setGridOption("context", { selectedDetail: column });

        let nodeRenderers = document.querySelectorAll(`.${className}`);
        nodeRenderers.forEach(renderer => renderer.setAttribute('src', treeClosed));

        params.node.setExpanded(true);
        gridOptions.context.chevKeyMap[className] = column;

        cellRenderer.setAttribute('src', treeOpen);

        if (params.node.detailNode) {
            params.api.redrawRows({ rowNodes: [params.node.detailNode] });
        }
    };
       
		class DetailGrid {
			constructor(params) {
				console.log("in DetailGrid Class", params)
				this.params = params;
        // console.log("COLUMNS => ", params.context.selectedDetail)
				// this.rowData = await getData();
				// this.rowData = params.data.data;
				
				if (params.context.newRecords) {
					let continent = this.params.data.continent
					this.rowData = this.rowData.concat(
						params.context.newRecords[continent]
					);
				}
			}
      getGui() {
        console.log('DetailGrid: getGui called');
        var eTemp = document.createElement('div');
        eTemp.innerHTML = this.getTemplate();
        this.eGui = eTemp.firstElementChild;

        this.setupDetailGrid();
        return this.eGui;
      }
			// eGui() {
			// 	var eTemp = document.createElement('div');
			// 	eTemp.innerHTML = this.getTemplate();
			// 	this.eGui = eTemp.firstElementChild;

			// 	this.setupDetailGrid();
			// 	return this.eGui;
			// }

			async setupDetailGrid() {
				console.log('in setupDetailGrid')
        var apiResponse = await getData1(this.params.data, this.params.context.selectedDetail);
        // console.log('apiResponse',apiResponse);
        if (!apiResponse || apiResponse.length < 2) {
            $('.full-width-grid.ag-theme-alpine').html('<h3 style="text-align: center;">NO DATA</h3>');
            return;
        }
        if (apiResponse[0] == null || apiResponse[1] == null) {
            $('.full-width-grid.ag-theme-alpine').html('<h3 style="text-align: center;">NO DATA</h3>');
            return;
        }
        let rowData = apiResponse[0]; // First array contains the row data
        const dataStructure = apiResponse[1]; // Second array contains column definitions

        // Fix: normalize keys to lowercase to match colDefs
        rowData = rowData.map(row => {
          const lowerCaseRow = {};
          for (let key in row) {
            if (row.hasOwnProperty(key)) {
              lowerCaseRow[key.toLowerCase()] = row[key];
            }
          }
          return lowerCaseRow;
        });

        //added this block by pornima for date is not showing proper in drilldown detail grid
        rowData = rowData.map(row => {
          Object.keys(row).forEach(key => {
            if (
              row[key] &&
              typeof row[key] === 'object' &&
              row[key].date &&
              typeof row[key].date === 'string'
            ) {
              // Extract only date part (YYYY-MM-DD)
              row[key] = row[key].date.split(' ')[0];
            }
          });
          return row;
        });
        
        if (!rowData || rowData.length === 0) {
            $('.full-width-grid.ag-theme-alpine').html('<h3 style="text-align: center;">NO DATA</h3>');
            return;
        }
        var dateFilterParams = {
            comparator: (filterLocalDateAtMidnight, cellValue) => {
                var dateAsString = cellValue;
                if (dateAsString == null) return -1;
                var dateParts = dateAsString.split("-");
                var cellDate = new Date(cellValue);
                // console.log(cellDate);
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
        let filterParams = { maxNumConditions: 5 };
        var colDefs = dataStructure.map(col => {
            let colDef = {
                field: col.COLUMN_NAME.toLowerCase(),
                colId: col.COLUMN_NAME.toLowerCase(),
                filter: ["int", "bigint", "float", "decimal", "money"].includes(col.DATA_TYPE) ? 'agNumberColumnFilter' : 'agMultiColumnFilter',
                filterParams
            };
            // Add date formatting & comparison if data type is date
            if (["date", "smalldatetime", "datetime"].includes(col.DATA_TYPE)) {
                console.log("<br><br>pornima<br>");
                colDef.filter = 'agDateColumnFilter';
                colDef.filterParams = dateFilterParams;
                colDef.valueFormatter = dateFormatter;
                colDef.comparator = dateComparator;
            }
            if (["int", "bigint", "float", "decimal", "money"].includes(col.DATA_TYPE)) {
                colDef.valueFormatter = params => {
                    // console.log("MS NAN:", params.value)
                    let value = Number(params.value); // Convert value to a number
                    return !isNaN(value)
                        ? (value === "" ? 0 :
                            (['float', 'decimal', 'money'].includes(col.DATA_TYPE) // Use col.DATA_TYPE instead of dataType
                                ? `${value.toFixed(3)}`
                                : `${value.toFixed(0)}`
                            )
                        ) : 0;
                };
            }

            return colDef;
        });
        // console.log("ColDefs", colDefs);
        const myDTheme = agGrid.themeAlpine.withParams({
          accentColor: "#15274F",
              backgroundColor: "#FFFFFF",
              borderRadius: 3,
              browserColorScheme: "inherit",
              columnBorder: true,
              fontFamily: {
                  googleFont: "Roboto"
              },
              fontSize: 12,
              foregroundColor: "#0D0E0F",
              headerFontSize: 14,
              spacing: 3,
              wrapperBorderRadius: 5
        });
				var detailGridOptions = {
          theme: myDTheme,
          columnDefs: colDefs,
					rowData: rowData,
          multiSortKey: "ctrl",
					defaultColDef: {
						flex: 1,
						minWidth: 150,
					},
          // domLayout: 'autoHeight',
          autoSizeStrategy: {
            type: 'fitCellContents',
          }
				};
				var eDetailGrid = this.eGui.querySelector('.full-width-grid');
				// new agGrid.Grid(eDetailGrid, detailGridOptions);
				// this.detailGridApi = detailGridOptions.api;
				this.detailGridApi = agGrid.createGrid(eDetailGrid, detailGridOptions);
        // console.log("Mounting detail grid in element:", eDetailGrid);

				var masterGridApi = this.params.api;
        // console.log("DETAIL API", this.params);
				var rowId = this.params.node.id;
				var gridInfo = {
					id: rowId,
					api: detailGridOptions.api,
					columnApi: detailGridOptions.columnApi,
				};
				masterGridApi.addDetailGridInfo(rowId, gridInfo);
        // console.log("Detail DOM:", this.eGui.outerHTML);
			}

			getTemplate() {
				var template = `<div class="full-width-panel">
                    <div class="full-width-details"></div>
                    <div class="full-width-grid ag-theme-alpine" style="height: 300px;"></div>
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
                // this.eGui = setDetailGrid.eGui();
                this.eGui = setDetailGrid.getGui();

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

    async function getData1(par, col) { 
        // console.log("params", par, par.dsnoid)
        try {
            const mappedData = Object.fromEntries(
              allDataKeys.map((key, index) => [key, par[index]])
            );
            // console.log("mappeddata",mappedData)
            const queryString = new URLSearchParams(mappedData).toString();  // Convert row data to query string
            const response = await fetch(`/getDataForAGMasterDetail.php?detail_FormID=<?php echo $ReportID; ?>&detail_col_name=${col}&${queryString}`);
            // const response = await fetch('getDataForAGMasterDetail.php?col=' + col + '&DesignID='+ par.dsnoid );
            const data = await response.json();
            // console.log('API->',data); 
            return data;
        } catch (error) {
            console.error('Error fetching data:', error);
            return [];
        }
    }

		const treeOpen = 'https://raw.githubusercontent.com/LouisMoore-agGrid/js-ag-grid-52eyso/50413f659cdfbe903ec14d9a5d4b7cf175b76637/tree-open.svg';
		const treeClosed = 'https://raw.githubusercontent.com/LouisMoore-agGrid/js-ag-grid-52eyso/aacef9f45dae7ea5822c4b76bf1c981a74451435/tree-closed.svg';
	
  /* END OF DRILL SCRIPTS */

  const columnDefs = [];
    // // row group columns
    // { field: "country", rowGroup: true ,filter: "agTextColumnFilter"},
    // { field: "athlete", rowGroup: true ,filter: "agTextColumnFilter"},

    // // pivot column
    // {
    //   headerName: "Year",
    //   // to mix it up a bit, here we are using a valueGetter for the year column.
    //   valueGetter: "data.year",
    //   pivot: true,
    // },

    // // aggregation columns
    // { field: "gold", aggFunc: "sum",filter: "agTextColumnFilter" },
    // { field: "silver", aggFunc: "sum",filter: "agTextColumnFilter" },
    // { field: "bronze", aggFunc: "sum",filter: "agTextColumnFilter" },
    // { field: "total", aggFunc: "sum" ,filter: "agTextColumnFilter"},

    //  {field: "mission",enablePivot: true ,valueFormatter: (params) => {return "" + params.value.toLocaleString();},checkboxSelection: true,filter: "agTextColumnFilter",pivot:true},
    //   {field: "company",enablePivot: true ,cellRenderer: CompanyLogoRenderer, filter: "agTextColumnFilter",pivot:true},
    //   {field: "location",enablePivot: true , filter: "agTextColumnFilter",pivot:true ,},
    //   {field: "date" , enablePivot: true,filter: 'agDateColumnFilter',pivot:true},
    //   {field: "price", enablePivot: true,filter: 'agNumberColumnFilter',pivot:true},
    //   {field: "successful",enablePivot: true, filter: 'agNumberColumnFilter',pivot:true },
    //   {field: "rocket",enablePivot: true, cellClassRules: {'rag-green': params => params.value === true,}, filter: "agTextColumnFilter",pivot:true},
  // ];
  //   console.log("tetapply");
  // const myTheme = themeQuartz
	// .withParams({
  //       accentColor: "#196099",
  //       backgroundColor: "#FFFFFF",
  //       borderColor: "#0000006B",
  //       borderRadius: 2,
  //       browserColorScheme: "dark",
  //       chromeBackgroundColor: {
  //           ref: "foregroundColor",
  //           mix: 0.07,
  //           onto: "backgroundColor"
  //       },
  //       columnBorder: true,
  //       fontFamily: {
  //           googleFont: "Roboto" 
  //       },
  //       fontSize: 13,
  //       foregroundColor: "#000000",
  //       headerBackgroundColor: "#152178",
  //       headerFontSize: 14,
  //       headerTextColor: "#FFFFFF",
  //       spacing: 3,
  //       wrapperBorderRadius: 4
  //   });
  const myTheme = agGrid.themeQuartz.withParams({
    accentColor: "#15274F",
        backgroundColor: "#FFFFFF",
        borderRadius: 3,
        browserColorScheme: "inherit",
        columnBorder: true,
        fontFamily: {
            googleFont: "Roboto"
        },
        fontSize: 12,
        foregroundColor: "#0D0E0F",
        headerFontSize: 14,
        spacing: 3,
        wrapperBorderRadius: 5
        //     accentColor: "#196099",
        // backgroundColor: "#FFFFFF",
        // borderColor: "#0000006B",
        // borderRadius: 2,
        // browserColorScheme: "dark",
        // chromeBackgroundColor: {
        //     ref: "foregroundColor",
        //     mix: 0.07,
        //     onto: "backgroundColor"
        // },
        // columnBorder: true,
        // fontFamily: {
        //     googleFont: "Roboto"
        // },
        // fontSize: 13,
        // foregroundColor: "#000000",
        // headerBackgroundColor: "#152178",
        // headerFontSize: 14,
        // headerTextColor: "#FFFFFF",
        // spacing: 3,
        // wrapperBorderRadius: 4
  });
 
  let savedCheckboxState = [];
  let expandCheckboxesInitialized = false;
  let sortApplied = false;
  let isSortColumn = true;

  // console.log("DrillStructure.length for Grid Options", DrillStructure)
  if(DrillStructure == null){
    // alert("h");
    gridOptions = {
        // enableAdvancedFilter: true,
        getRowId: params => params.data?.[0]?.toString(),  // ✅ Add this line here
        theme: myTheme,
        columnDefs: columnDefs,
        grandTotalRow: 'bottom',
        groupDisplayType: $('#group_display_type').val(),
        // groupDisplayType: 'groupRows',
        groupHideOpenParents: $('#group_display_type').val() == 'multipleColumn' ? true : false,      // false → show parent row
        pivotRowTotals: 'after',
        multiSortKey: "ctrl",
        showOpenedGroup: false,       // true → repeat
        groupDefaultExpanded: -1,
        // groupIncludeFooter: true,
        // groupIncludeTotalFooter: true,
        // groupDisplayType: 'multipleColumns' ,
        // rangeChart: true,
        // contextmenu: {        
        //   enabled: true,        
        //   menuItems: [            
        //     'chartRange',            
        //     'chartRangeGroupedColumn',            
        //     'chartRangeLine',            
        //     'chartRangeAreaColumnCombo'        
        //   ]
        // },
        // treeData: false,
        //if($ReportID == 3164) echo 'editType: "fullRow",'; 
        defaultColDef: {
          //if($ReportID == 3164) echo 'editable: true,'; 
          flex: 1,
          // minWidth: 150, //cancelled due to sizetofit
          suppressSizeToFit: true, //deprecated
          enableRowGroup: true,
          enablePivot: true,
          enableValue: true,
            //   filter: true, 
          filter: true, //"agMultiColumnFilter",
          // floatingFilter: true,
        },
        // autoSizeStrategy:{
        //   type: "fitCellContents",
        // },
        // onColumnResized: (params) => {
        //   console.log("resized..", params);
        // },
        autoSizeStrategy: {
          type: "fitCellContents",
          // defaultMaxWidth: 150,
          // defaultMinWidth: 80,
        },
        autoGroupColumnDef: {
          cellRendererParams: {
              suppressCount: true,
              // totalValueGetter: params =>  {
              //   const isRootLevel = params.node.level === -1;
              //   console.log('autoGroupColumnDef', params.node.level, isRootLevel, params.node)
              //   if (isRootLevel) {                  
              //       return 'Grand Total';
              //   }
              //   console.log('autoGroupColumnDef', `Sub Total (${params.value})`)
              //   return `Sub Total (${params.value})`;
              // },
          },
          // minWidth: 180,
          // filter: "agMultiColumnFilter",
          // filterValueGetter: (params) => params.data.company,
          filter: "agGroupColumnFilter",
          // rowGroupPanelShow: "always", //deprecated
          rowGroupIndex:0,
          columnGroupShow: "open", //closed or open
          // groupDisplayType: "multipleColumns", //deprecated
        },      
        icons: {
          "cog-wheel": '<i class="fa fa-gear fa-spin1" aria-hidden="true"></i>',
        },
        onGridReady:e=>{
          console.log("on grid ready**************")
          topg=0;

          // Initialize checkboxState based on savedCheckboxState if it's not undefined
          console.log("data**************")
          console.log(data)
          if(data !== undefined){
            if (data.checkboxState !== undefined) {
              savedCheckboxState = data.checkboxState;
              // console.log("savedCheckboxState", savedCheckboxState);
              savedCheckboxState.forEach(item => {
                const index = checkboxState.findIndex(([columnId]) => columnId === item[0]);
                if (index >= 0) {
                  checkboxState[index][1] = item[1];
                } else {
                  checkboxState.push([item[0], item[1]]);
                }
              });
            } else {
              // Clear checkboxState if there's no savedCheckboxState
              checkboxState = [];
            }
          } else {
              // Clear checkboxState if there's no savedCheckboxState
            checkboxState = [];
          }
           console.log("Test2",checkboxState);
          // Update checkboxes in the UI
          updateCheckboxUI();

          // Hide or show the checkbox div based on checkboxState
          updateCheckboxVisibility();
          if(+SelectedTemplateID > 0){
            $('#templateSelect').val(SelectedTemplateID).trigger('change');
            SelectedTemplateID = 0;
          }
          // console.log("autosizing all columns")
          // gridApi.sizeColumnsToFit();

        },



        onStateUpdated:event =>{
          console.log("OnStateUpdated Event")
          topg++
          templateg++;
          if(topg==3){
            // console.log("Filters in StateUpdatedEvent", topfilters);
            if(topfilters !== undefined) gridApi.setFilterModel(topfilters);
            gridApi.applyColumnState({ 
              state: pivotglobalsource.columns,
              applyOrder: true,
            });
          }

          //Added for RowGroupTotal checkboxes
          let rowg = gridApi.getState();
          // console.log(rowg);
          let groupColIds = [];
          // console.log("groupColIds", rowg.rowGroup?.groupColIds)
          // console.log("checkboxstate 5: ", checkboxState)
          //checkboxState = [];
          if(checkboxState !== undefined){
            // if (checkboxState.length > 0) {
              if(rowg.rowGroup !== undefined){
                // console.log("groupColIds", rowg.rowGroup.groupColIds)
                // groupColIds = rowg.rowGroup.groupColIds;
                groupColIds = rowg.rowGroup.groupColIds;
                // groupColIds = groupColIds.replace("/", "_");
              }
              // Update checkboxState to include all group column IDs
              // groupColIds.forEach(id => {
              //   if (!checkboxState.some(([columnId]) => columnId === id)) {
              //     // console.log("setting checkboxstate")
              //     checkboxState.push([id, false]); // Initialize to unchecked
              //   }
              // });

               // 🔹 Build a copy of old state to preserve previous selections
              const prevState = [...checkboxState];

              groupColIds.forEach(id => {
                // --- 1️⃣ Normal checkbox (e.g. "Party")
                const existing = prevState.find(([columnId]) => columnId === id);
                if (existing) {
                  // keep old state
                  const [columnId, checked] = existing;
                  if (!checkboxState.some(([c]) => c === columnId)) {
                    checkboxState.push([columnId, checked]);
                  }
                } else if (!checkboxState.some(([c]) => c === id)) {
                  checkboxState.push([id, false]);
                }

                // --- 2️⃣ Expand checkbox (e.g. "ExpRG_Party")
                const expId = "ExpRG_" + id;
                const existingExp = prevState.find(([columnId]) => columnId === expId);
                if (existingExp) {
                  const [columnId, checked] = existingExp;
                  if (!checkboxState.some(([c]) => c === columnId)) {
                    checkboxState.push([columnId, checked]);
                  }
                } else if (!checkboxState.some(([c]) => c === expId)) {
                  checkboxState.push([expId, false]);
                }
              });
              
              // Remove unchecked checkboxes that are no longer in the groupColIds
              // checkboxState = checkboxState.filter(([columnId]) => groupColIds.includes(columnId));

              // 🔹 Keep only entries that still correspond to an existing group
              checkboxState = checkboxState.filter(([columnId]) => {
                const cleanId = columnId.replace(/^ExpRG_/, "");
                return groupColIds.includes(cleanId);
              });
            // }
          }
          
          // Update UI only if there are checkboxes to display
          if(checkboxState !== undefined){  //if (checkboxState.length > 0) {
            // console.log("After Setting checkboxstate 2", checkboxState)
            $(".groupColumnIdsDiv").show();
            document.getElementById("groupColumnIdsDiv").innerHTML = generateCheckboxHTML(groupColIds);

            $(".groupColumnIdsDivExpand").show();
            document.getElementById("groupColumnIdsDivExpand").innerHTML = generateCheckboxExpandRowGroupHTML(groupColIds);

            // console.log("checkboxState after update:", checkboxState);
            addCheckboxListeners();
            updateCheckboxVisibility(); // Update visibility based on checkboxState

            addExpandCheckboxListeners();
            updateExpandCheckboxVisibility(); // Update visibility based on checkboxState
            
          } else {
            // console.log("After Setting checkboxstate 2 else", checkboxState)
            $(".groupColumnIdsDiv").hide();
            document.getElementById("groupColumnIdsDiv").innerHTML = ''; // Clear the checkbox div

            $(".groupColumnIdsDivExpand").hide();
            document.getElementById("groupColumnIdsDivExpand").innerHTML = ''; // Clear the checkbox div

            checkboxState = [];
             console.log("Test4",checkboxState);
            // console.log("checkbox State after Cleared: ", checkboxState);
          }
        },
        // sideBar:true,
        sideBar: {
          toolPanels: [
            "columns","filters",
            {
              id: "settings",
              labelKey: "settings",
              labelDefault: "Settings",
              iconKey: "cog-wheel",
              toolPanel: "medalRenderer",
              toolPanelParams: {
                title: "Custom Stats",
              },

            },
          ],
          defaultToolPanel: "columns",
        },
        components: {
          medalRenderer: MedalRenderer,
          myDetailCellRenderer: DetailCellRenderer, //MASTER DETAIL DRILL
        },
        // detailCellRenderer: 'myDetailCellRenderer',
        // masterDetail: true,
        animateRows:true,
        groupSuppressBlankHeader: true,
        // enableFillHandle:true,  //deprecated
        rowGroupPanelShow: "always",
        // enableRangeSelection: true, //deprecated
        cellSelection:true,
        // cellSelection:{
        //   handle: { 
        //       mode: 'range',
        //   }
        // },
        enableCharts:true,
        popupParent:document.body,
        //rowSelection: "multiple",//deprecated
        rowSelection: {
          mode: 'multiRow',
          checkboxes: true,
          headerCheckbox: true,
          enableSelectionWithoutKeys: true,
          // enableClickSelection: true,
          },
        suppressStickyTotalRow: 'false', //group/ grand/ true/ false
        statusBar: {
            statusPanels: [
            { statusPanel: "agTotalAndFilteredRowCountComponent" },
            // { statusPanel: "agTotalRowCountComponent" },
            // { statusPanel: "agFilteredRowCountComponent" },
            // { statusPanel: "agSelectedRowCountComponent" },
            { statusPanel: "agAggregationComponent" },
            ],
        },
        // enableRangeSelection: true,
        cellSelection: true,

        // groupTotalRow: "bottom",
        groupTotalRow: (params) => {
          // if(params.node.level === 0) console.log("In Group Total: ", checkboxState);
          // console.log("groupTotalRow fn: ", params.node.field, checkboxState, params);
          if(checkboxState !== undefined){
            for(var i = 0; i < checkboxState.length; i++){
              if(checkboxState[i][0] === allDataKeys[params.node.field]){
                if(checkboxState[i][1]){
                  return "bottom";
                }
              }
            }
          }
           console.log("Test5",checkboxState);
          return undefined;
            //     // params.api.redrawRows({ rowNodes: [params.node] });
        },
        // grandTotalRow: "bottom",
        groupDefaultExpanded: -1,
        suppressMenuHide: true,
        onColumnRowGroupChanged: (params) => {
          var tmp3D = ['wt','weight'];
          var tmp0D = ['pc','pcs','piece','pieces'];
          const containsAnyCI = (str, substrings) => substrings.some(sub => str.toLowerCase().includes(sub.toLowerCase()));
          params.api.getAllGridColumns().forEach(col => {
            console.log("col",col, col.colId);
              if (col.getColDef().enableValue) {
                  col.getColDef().valueFormatter = (cellParams) => {
                      if (cellParams.value != null && !isNaN(cellParams.value)) {
                          if(containsAnyCI(col.colId, tmp3D)) return Number(cellParams.value).toFixed(3);
                          if(containsAnyCI(col.colId, tmp0D)) return Number(cellParams.value).toFixed(0);
                          return Number(cellParams.value).toFixed(2);
                      }
                      return cellParams.value;
                  }; 
              }
          });
          // Force refresh to apply valueFormatters
          params.api.refreshCells({ force: true });
        },
    };
    // console.log("********************DetailCellRender CHECK", gridOptions);
  }
  function getTotalRowParams(nodes){
    // console.log("Field=> ", nodes.field);
    return "bottom";
  }

    function autoConvertNumericStrings1(data, structure) {
      return data;
      //if issue arrises, use the new function given below this fn* ****************************
      return data.map(row => {
        const newRow = { ...row };
        for (const key in newRow) {
          const value = newRow[key];
          if (typeof value === 'string' && !isNaN(value)) {
            console.log(key, newRow, newRow[key])
            newRow[key] = parseFloat(value);
          }
        }
        return newRow;
      });
    }
    /* NEW FUNCTION*/
    function autoConvertNumericStrings(data, structure) {
      // Build a lookup of which column indexes should be numeric
      const numericTypes = ['int', 'float', 'money', 'decimal', 'double', 'numeric'];
      
      // Get indexes of numeric columns
      const numericColumnIndexes = structure
          .map((col, index) => numericTypes.includes(col.DATA_TYPE) ? index : -1)
          .filter(index => index !== -1);
      // console.log("numericColumnIndexes",numericColumnIndexes)

      // Convert only numeric columns
      return data.map(row => {
          const newRow = [...row]; // Since data is in array format (not objects)
          numericColumnIndexes.forEach(index => {
              // console.log(index, newRow, newRow[index])
              const value = newRow[index];
              if (typeof value === 'string' && !isNaN(value)) {
                  newRow[index] = parseFloat(value);
              }
          });
          return newRow;
      });
    }
   

  function loadPivotGridData() {
      $("html, body").animate({ scrollTop: $(document).height() }, 1000);
      var gridDiv = document.querySelector("#myGrid");
      // console.log("allData", allData);
      if(allData !== null){
        
            gridApi = agGrid.createGrid(gridDiv, gridOptions);
            // console.log(">>>>***", allData[0])
            // dynamicallyConfigureColumnsFromObject(DataStructure, [], [], allDataKeys)            
              dynamicallyConfigureColumnsFromObject(DataStructure, editableStructure, DrillStructure, allDataKeys)
          gridApi.setGridOption('rowData', allData); //gridApi.setRowData(data); deprecated
          // console.log("Filters in loadPivot allData != null", topfilters);
          gridApi.setFilterModel(topfilters);
      }else{
      
        // fetch("reportGetDataFromView2.php?ReportID=<?php echo $ReportID . $filterString . "&username=" . $_SESSION['email']; ?>").then(function (response) {
          fetch("reportGetDataFromView22.php?ReportID=<?php echo $ReportID . $filterString . "&username=" . $_SESSION['email']; ?>").then(function (response) {
            return response.json(); 
          }).then(function (fullData1) {
            var reportServerSettings = fullData1[5];
            if(reportServerSettings[0]){
              // console.log("filterString ",filterString);
              // fetch("https://139.5.190.101:4343/MFapi/reportGetData.php?ReportID=<?php echo $ReportID . $filterString . "&username=" . $_SESSION['email']; ?>").then(function (response) {
                fetch(reportServerSettings[1] + "reportGetData.php?ReportID=<?php echo $ReportID . $filterString . "&username=u" . $_SESSION['email'] . "&RegUser=".$_SESSION['RegID']; ?>").then(function (response) {
                    return response.json();
                }).then(function (fullData) { 
                    // console.log('*******DATA FROM DB********');
                    console.log("fullData",fullData);
                    data = autoConvertNumericStrings(fullData[0], fullData[1]);
                    DataStructure = fullData[1];
                    editableStructure = fullData1[2];
                    DrillStructure = fullData1[3];
                    allDataKeys = fullData[4];
                    allData = data;
                    if(DrillStructure.length > 0){
                        // console.log("DRILL", columnDefs);
                        gridOptions = {
                            theme: myTheme,
                            columnDefs,
                            rowData: allData,
                            masterDetail: true,
                            multiSortKey: "ctrl",
                            // detailCellRendererParams: {
                            //     detailGridOptions: {
                            //         className: 'detail-grid' // Assign a class to detail grid
                            //     }
                            // },
                            // className: 'master-grid',
                            // getRowId: params => params.data.uniqueid + "",
                            getRowId: params => params.data.drillid + "",
                            autoSizeStrategy: {
                              type: 'fitCellContents',
                            },
                            // getRowId: params => 'row-' + params.node?.rowIndex,
                            detailCellRenderer: 'myDetailCellRenderer',
                            components: { myDetailCellRenderer: DetailCellRenderer },
                            context: { 
                                selectedDetails: DrillStructure,  
                                chevKeyMap: {} 
                            },  // Store multiple columns
                            onGridReady: (params) => {
                                // window.gridApi = params.api;
                                window.gridColumnApi = params.columnApi;
                            },
                            onRowGroupOpened: function(event) {
                                const context = event.api.getContext?.() || event.api.context;
                                const rowId = event.node?.data?.id;
                                const key = `row-${rowId}`;

                                if (!rowId || !context?.chevKeyMap) return;

                                if (event.node.expanded) {
                                    context.chevKeyMap[key] = event.column?.colId || context.selectedDetail;
                                } else {
                                    delete context.chevKeyMap[key];
                                }
                            },
                        };
                        // console.log("********************DetailCellRender CHECK2", gridOptions);
                        gridApi = agGrid.createGrid(gridDiv, gridOptions);
                    }else{
                        gridApi = agGrid.createGrid(gridDiv, gridOptions);
                    }
                    // dynamicallyConfigureColumnsFromObject(data[0])
                    
                    dynamicallyConfigureColumnsFromObject(DataStructure, editableStructure, DrillStructure, allDataKeys)
                    toppivot = data.pivot;
                    if(data.filter != undefined) topfilters = data.filter.filterModel;
                    // console.log(data);
                    // gridApi.setGridOption('rowData', data);
                    const allDataWithIds = allData.map((row, index) => ({
                        ...row,
                        drillid: `row-${index}` 
                    }));
                    gridApi.setGridOption('rowData', allDataWithIds); 
                    // console.log("Filters in loadPivot allData=null", topfilters);
                    gridApi.setFilterModel(topfilters);
                    // console.log(gridApi);
                });
            }else{
              fullData = fullData1;
              // console.log('*******DATA FROM DB********');
              console.log("Drill Structure",fullData);
              data = autoConvertNumericStrings(fullData[0], fullData[1]);
              // console.log(data, fullData)
              DataStructure = fullData[1];
              editableStructure = fullData1[2];
              DrillStructure = fullData1[3];
              allDataKeys = fullData[4];
              console.log("allDataKeys",allDataKeys);
              allData = data;
              if(DrillStructure.length > 0){
                  // console.log("DRILL", columnDefs);
                  gridOptions = {
                      theme: myTheme,
                      columnDefs,
                      rowData: allData,
                      masterDetail: true,
                      multiSortKey: "ctrl",
                      // detailCellRendererParams: {
                      //     detailGridOptions: {
                      //         className: 'detail-grid' // Assign a class to detail grid
                      //     }
                      // },
                      // className: 'master-grid',
                      // getRowId: params => params.data.uniqueid + "",
                      autoSizeStrategy: {
                        type: 'fitCellContents',
                      },
                      getRowId: params => params.data.drillid + "",
                      // getRowId: params => 'row-' + params.node?.rowIndex,
                      detailCellRenderer: 'myDetailCellRenderer',
                      components: { myDetailCellRenderer: DetailCellRenderer },
                      context: { 
                          selectedDetails: DrillStructure,  
                          chevKeyMap: {} 
                      },  // Store multiple columns
                      onGridReady: (params) => {
                          // window.gridApi = params.api;
                          window.gridColumnApi = params.columnApi;
                      },

                      onRowGroupOpened: function(event) {
                          const context = event.api.getContext?.() || event.api.context;
                          const rowId = event.node?.data?.id;
                          const key = `row-${rowId}`;

                          if (!rowId || !context?.chevKeyMap) return;

                          if (event.node.expanded) {
                              context.chevKeyMap[key] = event.column?.colId || context.selectedDetail;
                          } else {
                              delete context.chevKeyMap[key];
                          }
                      },
                  };
                  // console.log("********************DetailCellRender CHECK2", gridOptions);
                  gridApi = agGrid.createGrid(gridDiv, gridOptions);
              }else{
                  gridApi = agGrid.createGrid(gridDiv, gridOptions);
              }
              
              // dynamicallyConfigureColumnsFromObject(data[0])
              dynamicallyConfigureColumnsFromObject(DataStructure, editableStructure, DrillStructure, allDataKeys)
              toppivot = data.pivot;
              if(data.filter != undefined) topfilters = data.filter.filterModel;
              // console.log(data);
              // gridApi.setGridOption('rowData', data);
              const allDataWithIds = allData.map((row, index) => ({
                  ...row,
                  drillid: `row-${index}` 
              }));
              gridApi.setGridOption('rowData', allDataWithIds); 
              // console.log("Filters in loadPivot allData=null", topfilters);
              gridApi.setFilterModel(topfilters);
              // console.log(gridApi);
            }
            console.log('gridOptions',gridOptions)
        });
      }
      // console.log("Top Pivot in LoadPivotGrid", toppivot);
      if(toppivot){
        gridApi.setGridOption("pivotMode", toppivot.pivotMode);
      }
      // if(+SelectedTemplateID > 0){
      //   $('#templateSelect').val(SelectedTemplateID).trigger('change');
      // }
    }

  function createFakeServer(allData) {
    return {
      getData: (request) => {
        // in this simplified fake server all rows are contained in an array
        const requestedRows = allData.slice(request.startRow, request.endRow);

        return {
          success: true,
          rows: requestedRows,
        };
      },
    };
  }

  function createServerSideDatasource(server) {
    return {
      getRows: (params) => {
        // console.log("[Datasource] - rows requested by grid: ", params.request);

        // get data for request from our fake server
        const response = server.getData(params.request);

        // simulating real server call with a 500ms delay
        setTimeout(() => {
          if (response.success) {
            // supply rows for requested block to grid
            params.success({ rowData: response.rows });
          } else {
            params.fail();
          }
        }, 500);
      },
    };
  }

  function isValidDate(date) {
    var reg = /^(?:(?:1[6-9]|[2-9]\d)?\d{2})(?:(?:(\/|-|\.)(?:0?[13578]|1[02])\1(?:31))|(?:(\/|-|\.)(?:0?[13-9]|1[0-2])\2(?:29|30)))$|^(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(\/|-|\.)0?2\3(?:29)$|^(?:(?:1[6-9]|[2-9]\d)?\d{2})(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:0?[1-9]|1\d|2[0-8])$/;
    return reg.test(date);
    // return date && Object.prototype.toString.call(date) === "[object Date]" && !isNaN(date);
  }

  // DATA FORMATTING
  // function dateFormatter(params) {
  //   // console.log("///////////////", params);
  //   if(params == null)  return null;
  //   if(params.value == null)  return null;
  //   if(params.value.length > 5){
  //     var dateAsString = params.value;
  //     var dateParts = dateAsString.split("-");
  //     // console.log("==>>");
  //     // console.log(`${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`);
  //     return `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
  //   }else{
  //     return null;
  //   }
  // }

  //updated by pornima when refresh row on update field then date field coming [object object]. resolving this issue this function updated
  // function dateFormatter(params) {
  //   const value = params.value;
  //   if (!value) return '';

  //   if (typeof value === 'string' && /^\d{4}-\d{2}-\d{2}/.test(value)) {
  //     const [yyyy, mm, dd] = value.split(' ')[0].split('-');
  //     return `${dd}-${mm}-${yyyy}`;
  //   }
  //   if (typeof value === 'string' && /^\d{2}-\d{2}-\d{4}/.test(value)) {
  //     return value; // already in correct format
  //   }

  //   return value;
  // };

  function dateFormatter(params) {
  const value = params.value;
  if (!value) return '';

  const str = String(value).trim();

  // 🧹 Handle invalid / placeholder dates
  if (str === '1900-01-01' || str === '1900-01-01 00:00:00' || str === '1900-01-01T00:00:00' || str === '0000-00-00' || str === '1970-01-01' || str.toLowerCase() === 'null') {
    return ''; // show as blank
  }

  // 🗓️ Format valid dates as dd-mm-yyyy
  if (/^\d{4}-\d{2}-\d{2}/.test(str)) {
    const [yyyy, mm, dd] = str.split(' ')[0].split('-');
    return `${dd}-${mm}-${yyyy}`;
  }

  // already formatted
  if (/^\d{2}-\d{2}-\d{4}/.test(str)) return str;

  return str;
}


  // DATE COMPARATOR FOR SORTING
  function dateComparator(date1, date2) {
    // console.log(">>>>>>>", date1, date2)
    var date1Number = _monthToNum(date1);
    var date2Number = _monthToNum(date2);
    //console.log(date1, date1Number)
    if (date1Number === null && date2Number === null) {
      return 0;
    }
    if (date1Number === null) {
      return -1;
    }
    if (date2Number === null) {
      return 1;
    }

    return date1Number - date2Number;
    return 1;
  }

  // HELPER FOR DATE COMPARISON
  function _monthToNum(date) {
    if (date === undefined || date === null || date.length !== 10) {
      return null;
    }
    var yearNumber = date.substring(0, 4);
    var monthNumber = date.substring(5, 7);
    var dayNumber = date.substring(8, 10);
    // console.log(date, yearNumber, monthNumber, dayNumber);
    var result = yearNumber * 10000 + monthNumber * 100 + dayNumber;
    // 29/08/2004 => 20040829
    return result;
  }

  function normalizeDateFields(row) {
    const normalized = { ...row };

    for (const key in row) {
      const val = row[key];

      // Check if it's a date-like object from the server (with .date inside)
      if (
        val &&
        typeof val === 'object' &&
        typeof val.date === 'string' &&
        /^\d{4}-\d{2}-\d{2}/.test(val.date)
      ) {
        try {
          const parsedDate = new Date(val.date);
          if (!isNaN(parsedDate)) {
            const dd = String(parsedDate.getDate()).padStart(2, '0');
            const mm = String(parsedDate.getMonth() + 1).padStart(2, '0');
            const yyyy = parsedDate.getFullYear();
            normalized[key] = `${dd}-${mm}-${yyyy}`;
          } else {
            normalized[key] = '';
          }
        } catch {
          normalized[key] = '';
        }
      }
    }

    return normalized;
  }

  function dynamicallyConfigureColumnsFromObject(anObject, editableStructure = [], DrillStructure = [], allDataKeys=[]){
    const colDefs = gridApi.getColumnDefs();
    console.log("editStruct", editableStructure);
    colDefs.length=0;
    const keys = Object.keys(anObject);
    keys.forEach(key => {
        // console.log(anObject[key]); //anObject[key]['COLUMN_NAME'];
        let filter;
        let checkBox = "";
        let filterParams = {maxNumConditions:5};
        var dateFilterParams = {
            comparator: (filterLocalDateAtMidnight, cellValue) => {
                console.log("**********" , cellValue)
                var dateAsString = cellValue;
                if (dateAsString == null) return -1;
                var dateParts = dateAsString.split("-");
                var cellDate = new Date(cellValue);
                var cellDate = new Date(
                  Number(dateParts[2]),
                  Number(dateParts[1]) - 1,
                  Number(dateParts[0]),
                );
                cellDate = new Date(
                  Number(dateParts[0]),
                  Number(dateParts[1])-1,
                  Number(dateParts[2]),
                );
                console.log(cellDate, dateParts);
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
        const dataType = anObject[key]['DATA_TYPE']; //const dataType = typeof anObject[key];
        //   const colName = anObject[key]['COLUMN_NAME'];
        const colName = allDataKeys[key];
        const colNameID = key;
        //Check if colName is in editableStructure
        var editData = [];
        for(var i = 0; i < editableStructure.length; i++){
          if(colName == editableStructure[i][0]){
            editData = editableStructure[i];
            break;
          }
        }
        console.log("editData",editData,editData[1]);
        var DrillData = '';
        // console.log("DRILLSTRUCTURE" , DrillStructure, colName);
        for(var i = 0; i < DrillStructure.length; i++){
          if(DrillStructure[i] && colName){
          if(colName.toLowerCase() == DrillStructure[i].toLowerCase()){
            DrillData = DrillStructure[i].toLowerCase();
            break;
          }}
        }

        // console.log(colName, " - ", dataType)
        if(dataType == "int" || dataType == "bigint" || dataType == "float" || dataType == "decimal" || dataType == "money"){
          // console.log(colName, " - ", dataType, " => NUMBER");
          // colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agNumberColumnFilter', 'filterParams': filterParams});
          if(editData.length > 0){
            
            if(editData[1] == 7){
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, headerClass: 'editing-header',
                cellEditor: 'agNumberCellEditor',
                cellEditorParams: {
                    preventStepping: true
                },
                'filter':'agNumberColumnFilter',
                'filterParams': filterParams, 
                cellStyle: { 'text-align': 'right' },
                editable: true,
                valueSetter: (params) => {
                                const newValue = params.newValue;
                                const valueChanged = params.data[params.colDef.field] !== newValue;
                                // console.log("valueChanged",valueChanged);
                                if (valueChanged) {
                                    var oldValue = params.data[params.colDef.field];
                                    var dataMain = params.data;
                                    // console.log(dataMain)
                                    var result = [];
                                    var UpdatePrimaryKey = 0;
                                    for(var i in dataMain){
                                      // console.log('GETTING ID', dataMain,i, editData[3])
                                      // if(editData[3] === i){
                                      if(allDataKeys[i].toUpperCase() === editData[3].toUpperCase()){
                                        // console.log("Matched", dataMain[i])
                                        UpdatePrimaryKey = dataMain[i];
                                        // result.push([i, dataMain [i]]);
                                        break;
                                      }
                                    }
                                    // console.log(`Old Value: ${oldValue}, New Value: ${newValue} for ID: ${UpdatePrimaryKey} on Field: ${params.colDef.field}` );
                                    params.data[params.colDef.field] = newValue; // Update data
                                    var session ='YearCode=<?php echo $_SESSION['dbYear']; ?> AND DivisionId=<?php echo $_SESSION['dbDivision']; ?> AND CompanyId=<?php echo $_SESSION['dbCompany']; ?> AND UserID=<?php echo $_SESSION['user_id']; ?>';
                                    // console.log("UPDATING==>>>>", params.data)
                                    var mappedData = Object.fromEntries(
                                      allDataKeys.map((key, index) => [key, params.data[index]])
                                    );
                                    $.ajax({
                                        url: `reportGridUpdateData.php`,
                                        headers: {
                                          Accept: "application/json",
                                          "Content-Type": "application/json"
                                        },
                                        data: {ReportID: <?php echo $ReportID; ?>,ID:UpdatePrimaryKey,Field:allDataKeys[params.colDef.field],oldValue:oldValue,newValue:newValue, session: session, RowData: mappedData} ,
                                        type: "GET", 
                                        dataType: "json",
                                        success: function(data) {
                                          // console.log("Got Data frm API", data);
                                          // callback(null, data);
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                          console.log("Got ERROR Data frm API", jqXHR);
                                          console.log("Got ERROR Data frm API", textStatus);
                                          // callback(new Error(textStatus || errorThrown));
                                        }
                                      });
                                }
                                return valueChanged; // Return true if changed
                            },
                            });
            }else{
              colDefs.push({ 'field': colNameID, 'colId' : colName , headerClass: 'editing-header', 'headerName': colName, 'filter':'agNumberColumnFilter', 'filterParams': filterParams, cellStyle: { 'text-align': 'right' }});
            }
          }else{
            if(DrillData.length > 1){
              // console.log("FOUND DRILL DATA IN NUMBERS")
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, 'filter':'agNumberColumnFilter', 'filterParams': filterParams,   cellStyle: { 'text-align': 'right' }, cellRenderer: (params) => makeMasterCellRenderer(params, colName),
                    valueFormatter: params => {
                      let value = Number(params.value); // Convert value to a number
                      // console.log("MS NAN:", params.value, dataType, value, `${value.toFixed(0)}`)
                      return !isNaN(value)
                          ? (value === "" ? 0 :
                              (['float', 'decimal', 'money'].includes(dataType)
                                  ? `${value.toFixed(3)}`
                                  : `${value.toFixed(0)}`
                              )
                          ) : 0;
                    }});
            }else{
                  colDefs.push({  
                    valueFormatter: params => {
                      // if(isNaN(params.value)) console.log("MS NAN:", params.value)
                      let value = Number(params.value); // Convert value to a number
                      return !isNaN(value)
                          ? (value === "" ? 0 :
                              (['float', 'decimal', 'money'].includes(dataType)
                                  ? `${value.toFixed(3)}`
                                  : `${value.toFixed(0)}`
                              )
                          ) : 0;
                    },
                                // valueFormatter: params => 
                                //       params.value !== null 
                                //       ? (params.value == "" 
                                //         ? 0 
                                //         : (['float', 'decimal', 'money'].includes(dataType) 
                                //           ? `${params.value?.toFixed(3)}` 
                                //           : `${params.value?.toFixed(0)}`
                                //         )
                                //       ) : 0 , 
                            'field': colNameID, 'colId' : colName , 'headerName': colName, 'filter':'agNumberColumnFilter', 'filterParams': filterParams,   cellStyle: { 'text-align': 'right' }});
            }
          }
        }else if(dataType == "date" || dataType == "smalldatetime" || dataType == "datetime"){
          console.log(colName, " - ", dataType, " => DATE");
          // colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agDateColumnFilter','filterParams': dateFilterParams,'valueFormatter': dateFormatter, 'comparator': dateComparator,});
          // colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agNumberColumnFilter', 'filterParams': filterParams});
          if(editData.length > 0){
            if(editData[1] == 6){
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName,headerClass: 'editing-header',
                cellEditor: 'agDateStringCellEditor',
                'filter':'agNumberColumnFilter',
                'valueFormatter': dateFormatter, 
                'comparator': dateComparator,
                'filter':'agDateColumnFilter',
                'filterParams': dateFilterParams, 
                editable: true,
                valueSetter: async (params) => {
                                console.log("Value Setter" , params)
                                var newValue = params.newValue;
                                const valueChanged = params.data[params.colDef.field] !== newValue;
                                // console.log("valueChanged",valueChanged);
                                if (valueChanged) {
                                    var oldValue = params.data[params.colDef.field];
                                    var dataMain = params.data;
                                    // console.log(dataMain)
                                    var result = [];
                                    var UpdatePrimaryKey = 0;
                                    for(var i in dataMain){
                                      // console.log(i, editData[3])
                                      // if(editData[3] === i){
                                      if(allDataKeys[i].toUpperCase() === editData[3].toUpperCase()){
                                        // console.log("Matched", dataMain[i])
                                        UpdatePrimaryKey = dataMain[i];
                                        // result.push([i, dataMain [i]]);
                                        break;
                                      }
                                    }
                                    // console.log(`Old Value: ${oldValue}, New Value: ${newValue} for ID: ${UpdatePrimaryKey} on Field: ${params.colDef.field}` );
                                    params.data[params.colDef.field] = newValue; // Update data
                                    var session ='YearCode=<?php echo $_SESSION['dbYear']; ?> AND DivisionId=<?php echo $_SESSION['dbDivision']; ?> AND CompanyId=<?php echo $_SESSION['dbCompany']; ?> AND UserID=<?php echo $_SESSION['user_id']; ?>';
                                    var enteredDate = newValue;
                                    if( newValue !== null){
                                      var parts = newValue.split('-'); 
                                      newValue = parts[2] + '-' + parts[1] + '-' + parts[0];
                                    }
                                    // console.log("UPDATING==>>>>", params.data)
                                    var mappedData = Object.fromEntries(
                                      allDataKeys.map((key, index) => [key, params.data[index]])
                                    );
                                    $.ajax({
                                        url: `reportGridUpdateData.php`,
                                        headers: {
                                          Accept: "application/json",
                                          "Content-Type": "application/json"
                                        },
                                        data: {ReportID: <?php echo $ReportID; ?>,ID:UpdatePrimaryKey,Field:allDataKeys[params.colDef.field],oldValue:oldValue,newValue:newValue, session: session, RowData: mappedData} ,
                                        type: "GET", 
                                        dataType: "json",
                                        success: function(data) {
                                          // console.log("Got Data frm API", data);
                                          if(data.error == "1"){
                                            alert(data.error_statement)
                                            params.data[params.colDef.field] = oldValue; 
                                            return false;
                                          }            
                                          // params.data[params.colDef.field] = enteredDate; // Update data
                                          return true;
                                          // callback(null, data);
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                          console.log("Got ERROR Data frm API", jqXHR);
                                          console.log("Got ERROR Data frm API", textStatus);
                                          params.data[params.colDef.field] = oldValue; 
                                            // callback(new Error(textStatus || errorThrown));
                                        }
                                      });
                                }
                                return valueChanged; // Return true if changed
                            },
                            });
            }else{
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName,headerClass: 'editing-header', 'filter':'agDateColumnFilter','filterParams': dateFilterParams,'valueFormatter': dateFormatter, 'comparator': dateComparator,});
              // colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agNumberColumnFilter', 'filterParams': filterParams});
            }
          }else{
            
            if(DrillData.length > 1){
              // console.log("FOUND DRILL DATA IN date")
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, 'filter':'agDateColumnFilter','filterParams': dateFilterParams, 'valueFormatter': dateFormatter, 'comparator': dateComparator, cellRenderer: (params) => makeMasterCellRenderer(params, colName) });
            }else{
              console.log("PORNIMA1", editData);
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, 'filter':'agDateColumnFilter','filterParams': dateFilterParams,'valueFormatter': dateFormatter, 'comparator': dateComparator,});
              // colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agNumberColumnFilter', 'filterParams': filterParams});
            }
          }
          /*
          if(editData.length > 0){
            console.log("editData", editData);
            if(editData[1] == 9999){
              colDefs.push({ 
                'field': colName, 
                'cellEditor': "agDateStringCellEditor", 
                'colId':colName , 
                'valueFormatter': dateFormatter, 
                'comparator': dateComparator,
                // 'cellDataType': 'text', 
                'filter':'agDateColumnFilter',
                'filterParams': dateFilterParams, 
                editable: true, 
                valueSetter: async (params) => {
                  const nv = params.newValue;
                  var resp = await updateGridData(params, editData);
                  console.log("resp", resp, nv, params.data, params.colDef.field)
                  if(resp){
                    params.data[params.colDef.field] = nv; // Update data
                    console.log(params.data)
                    return true;
                  }else{
                    return false;
                  }
                },
              });
            }
          }else{
            colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agDateColumnFilter','filterParams': dateFilterParams,'valueFormatter': dateFormatter, 'comparator': dateComparator,});
          }*/
        }else if(anObject[key]['COLUMN_NAME'].match("^IMG_") || anObject[key]['COLUMN_NAME'].match("^img_")){
          // console.log(colName, " - ", dataType, " => IMAGE");
          colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, 'cellRenderer': CompanyLogoRenderer });
        }else{  //VARCHAR 
          // console.log(colName, " - ", dataType, " => OTHERS");
          if(editData.length > 0){
            
            if(editData[1] == 5){
              var allNames = [];
              var v = editData[2].map(item => item.Label);
              // allNames.push(""); allNames.push(v);
              allNames = [...[""], ...v];
              // console.log(allNames);
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, headerClass: 'editing-header',
                      'cellEditor': "agRichSelectCellEditor", 'cellDataType': 'text', 'filter':'agMultiColumnFilter', 
                            'filterParams': filterParams, editable: true,
                            'cellEditorParams': {
                              // values: allNames, 
                              // values: getValueFromServer(params), 
                              values: (params) => {
                                // console.log("getValueFromServer", params);
                                return new Promise((resolve, reject) => {
                                    getValueFromServer(params)  // Fetch values using your function
                                        .then(response => {
                                            resolve(response);  // Resolve with the fetched data
                                        })
                                        .catch(error => {
                                            console.error("Error fetching values:", error);
                                            reject([]);  // Reject with an empty array in case of error
                                        });
                                });
                                // return new Promise((resolve) => {
                                //   resolve(getValueFromServer(params.data));
                                //   // setTimeout(() => resolve(['English', 'Spanish', 'French', 'Portuguese', '(other)']), 3000);
                                // });
                              },
                              // values: getValueFromServer(), 
                              // valueListMaxHeight: 120,
                              // valueListMaxWidth: 120,
                              allowTyping: true,
                              filterList: true,
                              highlightMatch: true,
                              searchType: "matchAny",
                              valueListMaxHeight: 120, // Adjust dropdown height
                              searchEnabled: true, // Enable search bar
                            }, 
                            valueSetter: (params) => {
                                // console.log("Value Setter" , params)
                                const newValue = params.newValue;
                                const valueChanged = params.data[params.colDef.field] !== newValue;
                                if (valueChanged) {
                                    var oldValue = params.data[params.colDef.field];
                                    var dataMain = params.data;
                                    // console.log(dataMain)
                                    var result = [];
                                    var UpdatePrimaryKey = 0;
                                
                                    for(var i in dataMain){
                                      // if(editData[3] === i){
                                      // allDataKeys.indexOf(col);
                                      if(allDataKeys[i].toUpperCase() === editData[3].toUpperCase()){
                                        // console.log('GETTING ID', dataMain,i, editData[3], allDataKeys)
                                        // console.log("Matched", dataMain[i])
                                        UpdatePrimaryKey = dataMain[i];
                                        // result.push([i, dataMain [i]]);
                                        break;
                                      }
                                    }
                                    // console.log(`Old Value: ${oldValue}, New Value: ${newValue} for ID: ${UpdatePrimaryKey} on Field: ${allDataKeys[params.colDef.field]}` );
                                    params.data[params.colDef.field] = newValue; // Update data
                                    var session ='YearCode=<?php echo $_SESSION['dbYear']; ?> AND DivisionId=<?php echo $_SESSION['dbDivision']; ?> AND CompanyId=<?php echo $_SESSION['dbCompany']; ?> AND UserID=<?php echo $_SESSION['user_id']; ?>';
                                    // console.log("UPDATING==>>>>", params.data)
                                    var mappedData = Object.fromEntries(
                                      allDataKeys.map((key, index) => [key, params.data[index]])
                                    );
                                    
                                    $.ajax({
                                        url: `reportGridUpdateData.php`,
                                        headers: {
                                          Accept: "application/json",
                                          "Content-Type": "application/json"
                                        },
                                        data: {ReportID: <?php echo $ReportID; ?>,ID:UpdatePrimaryKey,Field:allDataKeys[params.colDef.field],oldValue:oldValue,newValue:newValue, session:session, RowData: mappedData} ,
                                        type: "GET", 
                                        dataType: "json",
                                        success: function(data) {
                                          // console.log("Got Data frm API", data);
                                          // callback(null, data);

                                          // const rawRow = data['CurrentRowResponse']; // array-style row, e.g. [2990884, 884, '000001', ...]
        
                                          // const updatedRow = normalizeDateFields(rawRow);
                                          // console.log("updatedRow",updatedRow);
                                          // // Convert object to array-style row
                                          // const rowAsArray = allDataKeys.map(key => updatedRow[key]);

                                          // const rowId = updatedRow['ID']?.toString(); // this must match getRowId
                                          // console.log("rowId",rowId);
                                          // const result = gridApi.applyTransaction({ update: [rowAsArray] });

                                          // if (!result.update || result.updsuccessfullyate.length === 0) {
                                          //   const node = gridApi.getRowNode(rowId);

                                          //   if (node) {
                                          //     node.setData(updatedRow);
                                          //     console.log('Row updated  (fallback)');
                                          //   } else {
                                          //     console.warn('Row not found for update:', rowId);
                                          //   }
                                          // }



                                          const originalFields = data['CurrentRowResponse'];

                                          // Convert all keys to lowercase for safe comparison
                                          const lowerCasedFields = {};
                                          Object.keys(originalFields).forEach(key => {
                                              lowerCasedFields[key.toLowerCase()] = originalFields[key];
                                          });
                   
                                          const rowId = lowerCasedFields['id']?.toString(); // Now always safe

                                          if (!rowId) {
                                              console.warn("Row ID not found in response:", originalFields);
                                              return;
                                          }

                                          const rowNode = gridApi.getRowNode(rowId);

                                          if (rowNode) {
                                              // Update only the fields (excluding id) using original case keys
                                              for (const field in originalFields) {
                                                  if (field.toLowerCase() !== 'id' && originalFields.hasOwnProperty(field)) {
                                                      rowNode.setDataValue(field, originalFields[field]);
                                                  }
                                              }
                                              console.log("Updated specific fields:", originalFields);
                                          } else {
                                              console.warn("Row not found for partial update:", rowId);
                                          }

                                          // Force redraw
                                          gridApi.refreshCells({
                                              rowNodes: [rowNode],
                                              force: true,
                                              suppressFlash: true
                                          });

                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                          console.log("Got ERROR Data frm API", jqXHR);
                                          console.log("Got ERROR Data frm API", textStatus);
                                          // callback(new Error(textStatus || errorThrown));
                                        }
                                    });
                                }
                                return valueChanged; // Return true if changed
                            },
                            });
            }
            
            if(editData[1] == 1){
              console.log("editdata length",editData.length,colDefs);
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, headerClass: 'editing-header','cellEditor': "agTextCellEditor",  'cellDataType': 'text', 'filter':'agMultiColumnFilter', 
                            'filterParams': filterParams, editable: true, 
                              valueSetter: (params) => {
                                console.log("Value Setter" , params)
                                const newValue = params.newValue;
                                const valueChanged = params.data[params.colDef.field] !== newValue;
                                // console.log("valueChanged",valueChanged);
                                if (valueChanged) {
                                    var oldValue = params.data[params.colDef.field];
                                    var dataMain = params.data;
                                    console.log(dataMain);
                                    console.log(editData);
                                    console.log(allDataKeys);
                                    var result = [];
                                    var UpdatePrimaryKey = 0;
                                    for(var i in dataMain){
                                      console.log(allDataKeys[i], editData[3])
                                      // if(editData[3] === i){
                                      if(allDataKeys[i].toUpperCase() === editData[3].toUpperCase()){
                                        // console.log("Matched", dataMain[i])
                                        UpdatePrimaryKey = dataMain[i];
                                        // result.push([i, dataMain [i]]);
                                        break;
                                      }
                                    }
                                    // console.log(`Old Value: ${oldValue}, New Value: ${newValue} for ID: ${UpdatePrimaryKey} on Field: ${params.colDef.field}` );
                                    params.data[params.colDef.field] = newValue; // Update data
                                    var session ='YearCode=<?php echo $_SESSION['dbYear']; ?> AND DivisionId=<?php echo $_SESSION['dbDivision']; ?> AND CompanyId=<?php echo $_SESSION['dbCompany']; ?> AND UserID=<?php echo $_SESSION['user_id']; ?>';
                                    var mappedData = Object.fromEntries(
                                      allDataKeys.map((key, index) => [key, params.data[index]])
                                    );
                                   
                                    // console.log("UPDATING==>>>>", params.data)
                                    $.ajax({
                                        url: `reportGridUpdateData.php`,
                                        headers: {
                                          Accept: "application/json",
                                          "Content-Type": "application/json"
                                        },
                                        data: {ReportID: <?php echo $ReportID; ?>,ID:UpdatePrimaryKey,Field:allDataKeys[params.colDef.field],oldValue:oldValue,newValue:newValue, session: session, RowData: mappedData} ,
                                        type: "GET", 
                                        dataType: "json",
                                        success: function(data) {
                                          // console.log("Got Data frm API", data);
                                          // callback(null, data);
                                          // const rawRow = data['CurrentRowResponse']; // array-style row, e.g. [2990884, 884, '000001', ...]
        
                                          // const updatedRow = normalizeDateFields(rawRow);
                                          // console.log("updatedRow",updatedRow);
                                          // // Convert object to array-style row
                                          // const rowAsArray = allDataKeys.map(key => updatedRow[key]);

                                          // const rowId = updatedRow['ID']?.toString(); // this must match getRowId
                                        
                                          // const result = gridApi.applyTransaction({ update: [rowAsArray] });

                                          // if (!result.update || result.update.length === 0) {
                                          //   const node = gridApi.getRowNode(rowId);

                                          //   if (node) {
                                          //     node.setData(updatedRow);
                                          //     console.log('Row updated successfully (fallback)');
                                          //   } else {
                                          //     console.warn('Row not found for update:', rowId);
                                          //   }
                                          // }


                                          const updatedFields = data['CurrentRowResponse'];

                                          const originalFields = data['CurrentRowResponse'];

                                          // Convert all keys to lowercase for safe comparison
                                          const lowerCasedFields = {};
                                          Object.keys(originalFields).forEach(key => {
                                              lowerCasedFields[key.toLowerCase()] = originalFields[key];
                                          });

                                          const rowId = lowerCasedFields['id']?.toString(); // Now always safe

                                          if (!rowId) {
                                              console.warn("Row ID not found in response:", originalFields);
                                              return;
                                          }

                                          const rowNode = gridApi.getRowNode(rowId);

                                          if (rowNode) {
                                              // Update only the fields (excluding id) using original case keys
                                              for (const field in originalFields) {
                                                  if (field.toLowerCase() !== 'id' && originalFields.hasOwnProperty(field)) {
                                                      rowNode.setDataValue(field, originalFields[field]);
                                                  }
                                              }
                                              console.log("Updated specific fields:", originalFields);
                                          } else {
                                              console.warn("Row not found for partial update:", rowId);
                                          }

                                          
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
                                          console.log("Got ERROR Data frm API", jqXHR);
                                          console.log("Got ERROR Data frm API", textStatus);
                                          // callback(new Error(textStatus || errorThrown));
                                        }
                                      });
                                }
                                return valueChanged; // Return true if changed
                            },
                            });
            }
          }else{
            if(DrillData.length > 1){
              // console.log("FOUND DRILL DATA IN VARCHAR")
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, 'cellDataType': 'text', 'filter':'agMultiColumnFilter', 'filterParams': filterParams,  cellRenderer: (params) => makeMasterCellRenderer(params, colName) });
            }else{
              const isEntryNo = 0;//colName.toLowerCase() === 'entryno' || colName.toLowerCase() === 'entno';
              colDefs.push({ 'field': colNameID, 'colId' : colName , 'headerName': colName, 
                'cellDataType': 'text', 
                'filter':'agMultiColumnFilter', 
                // valueGetter: isEntryNo
                //       ? (params) => {
                //         var EntryNoColID = allDataKeys.indexOf('entryno')
                //           console.log("isEntryNo",params.data,EntryNoColID, allDataKeys)
                //             const value = params.data && params.data[EntryNoColID];
                //             return value ? value.toString().padStart(6, '0') : '';
                //         }
                //       : undefined,
                // valueGetter: (params) => {
                //     var tmpC = allDataKeys.indexOf(colName)
                //     let value = params.data ? params.data[tmpC] : '';
                //     console.log("isEntryNo",params.data,tmpC,colName, value, allDataKeys)
                //     // Ensure always returned as string
                //     return value !== undefined && value !== null ? value.toString() : '';
                // },
                cellRenderer: (params) => {
                    // console.log("CR: ", params.value);
                    // return params.value ? params.value.toString() : '-';
                    const value = params.value?.toString();
                    const isUrl = value?.startsWith("http://") || value?.startsWith("https://");
                    
                    return isUrl
                      ? `<a href="${value}" target="_blank" rel="noopener noreferrer">LINK</a>`
                      : (value || '-');
                },
                filterParams: {
                    maxNumConditions:5,
                    valueFormatter: (params) => {
                        return params.value ? params.value.toString() : '';
                    },
                    // Ensures AG Grid treats the filter keys as string, even if they look like numbers
                    // keyCreator: (params) => {
                    //     console.log("KC: ", params.value)
                    //     return params.value ? params.value.toString() : '';
                    // }
                },
                // valueFormatter: (params) => {
                //     console.log("VF: ", params.value)
                //     return params.value ? params.value.toString() : '';
                // },
              });
            }
          }
        }
    });
    storeColDefs = colDefs;
    console.log('coldefs', colDefs);
    gridApi.setGridOption('columnDefs', colDefs); //gridApi.setColumnDefs(colDefs);
    // gridApi.autoSizeColumns();
  }

  async function updateGridData(params, editData){
    // console.log("Value Setter" , params)
    var FieldType = editData[1];
    var newValue = params.newValue;
    const valueChanged = params.data[params.colDef.field] !== newValue;
    if (valueChanged) {
      var oldValue = params.data[params.colDef.field];
      var dataMain = params.data;
      var result = [];
      var UpdatePrimaryKey = 0;
      for(var i in dataMain){
        if(allDataKeys[i].toUpperCase() === editData[3].toUpperCase()){
          UpdatePrimaryKey = dataMain[i];
          break;
        }
      }
      // console.log(`Old Value: ${oldValue}, New Value: ${newValue} for ID: ${UpdatePrimaryKey} on Field: ${params.colDef.field}` );
      var session ='YearCode=<?php echo $_SESSION['dbYear']; ?> AND DivisionId=<?php echo $_SESSION['dbDivision']; ?> AND CompanyId=<?php echo $_SESSION['dbCompany']; ?> AND UserID=<?php echo $_SESSION['user_id']; ?>';
      if(FieldType == 6){
        var parts = newValue.split('-'); 
        newValue = parts[2] + '-' + parts[1] + '-' + parts[0];
      }
      if(UpdatePrimaryKey == 0){
        alert("Primary Key not found. Please contact developer.");
        return false;
      }else{
        console.log("UPDATING2==>>>>", params.data)
        await $.ajax({
          url: `reportGridUpdateData.php`,
          headers: {
            Accept: "application/json",
            "Content-Type": "application/json"
          },
          data: {ReportID: <?php echo $ReportID; ?>,ID:UpdatePrimaryKey,Field:allDataKeys[params.colDef.field],oldValue:oldValue,newValue:newValue, session: session} ,
          type: "GET", 
          dataType: "json",
          success: function(data) {
            // console.log("Got Data frm API", data);
            if(data.error == "1"){
              alert(data.error_statement)
              return false;
            }            
            return true;
            // callback(null, data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log("Got ERROR Data frm API", jqXHR);
            console.log("Got ERROR Data frm API", textStatus);
              return false;
              // callback(new Error(textStatus || errorThrown));
          }
        });
      }
    }
    return valueChanged;
  }

  async function getValueFromServer(params) {
    // console.log("getValueFromServer", params);
    const mappedData = Object.fromEntries(
      allDataKeys.map((key, index) => [key, params.data[index]])
    );
    // console.log("mappeddata",mappedData)
    // Wrap the $.ajax call in a Promise
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `getReportDynamicUpdateData.php`,
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json"
            },
            data: { params: mappedData, Field: allDataKeys[params.colDef.field], ReportID: <?php echo $ReportID; ?> },
            type: "GET", 
            dataType: "json",
            success: function(data) {
                // console.log(data);
                resolve(data);  // Resolve the Promise with the data
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Got ERROR Data from API", jqXHR);
                console.log("Got ERROR Data from API", textStatus);
                reject([]);  // Reject the Promise with an empty array in case of error
            }
        });
    });
  }

  function generateCheckboxHTML(groupColIds) {
    // console.log("groupColIds & checkboxState", groupColIds, checkboxState);
    return groupColIds.map(id => `
      <div style="margin-right: 10px; display: inline-block;">
        <input class="rowGrpTtl" type="checkbox" id="${id.replace("/","_")}" name="${id}" value="${id}" ${isChecked(id) ? 'checked' : ''}>
        <label for="${id}">${id}</label>
      </div><br />
    `).join('');
  }

  function generateCheckboxExpandRowGroupHTML(groupColIds) {
    // console.log("groupColIds & checkboxState", groupColIds, checkboxState);
    return groupColIds.map(id => `
      <div style="margin-right: 10px; display: inline-block;">
        <input class="rowGrpExpand" type="checkbox" id="ExpRG_${id.replace("/","_")}" name="ExpRG_${id}" value="${id}" ${isChecked(id) ? 'checked' : ''}>
        <label for="${id}">${id}</label>
      </div><br />
    `).join('');
  }


  // function isChecked(id) {
  //   console.log("checkboxState columnid isChecked? : ", id)
  //   return checkboxState.some(([columnId, checked]) => columnId === id && checked);
  // }
  function isChecked(id) {
    // console.log("checking for ID ->", id , " in ", checkboxState );
    if (!Array.isArray(checkboxState)) {
        return false;
    }
    const checkbox = checkboxState.find(([columnId]) => columnId === id);
    return checkbox ? checkbox[1] : false;
  }

  function addCheckboxListeners() {
    // console.log("adding checkbox listeners");
    const checkboxes = document.querySelectorAll('#groupColumnIdsDiv input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', (event) => {
        updateCheckboxState(event.target.id, event.target.checked);
        // updateGridOptions
        // console.log("checkboxState after change:", checkboxState);
        // gridApi.refreshCells({ force: true });
      });
    });
  }

  // function addExpandCheckboxListeners() {
  //   console.log("Test8",checkboxState);
  //   // checkboxes for expnd Row Group
  //   const checkboxes1 = document.querySelectorAll('#groupColumnIdsDivExpand input[type="checkbox"]');
  //   checkboxes1.forEach(checkbox => {
  //     console.log("Test13",checkboxes1);
  //     checkbox.addEventListener('change', (event) => {
  //       // eventTargetID = event.target.id.replace("ExpRG_","");
  //       // console.log("checkboxState after change:", event.target.id, event.target.checked, eventTargetID);
  //       updateCheckboxState1(event.target.id, event.target.checked);
  //        console.log("Test9",checkboxState);
  //       // updateGridOptions
  //       // gridApi.refreshCells({ force: true });
  //     });
  //   });
  // }

  function addExpandCheckboxListeners() {
    console.log("Test8", checkboxState);

    // Select all expand-row-group checkboxes
    const checkboxes1 = document.querySelectorAll('#groupColumnIdsDivExpand input[type="checkbox"]');

    checkboxes1.forEach(checkbox => {
      const id = checkbox.id;

      // --- 1️⃣ Sync the checkbox UI with current checkboxState array ---
      const existing = checkboxState.find(([columnId]) => columnId === id);
      if (existing) {
        checkbox.checked = !!existing[1]; // true or false
      }

      // --- 2️⃣ If checkbox not yet tracked, add it ---
      if (!existing) {
        checkboxState.push([id, checkbox.checked]);
      }

      // --- 3️⃣ Prevent duplicate listeners ---
      checkbox.removeEventListener('change', handleExpandCheckboxChange);
      checkbox.addEventListener('change', handleExpandCheckboxChange);
    });

    console.log("Synced expand checkboxes →", checkboxState);
  }

  // Separate change handler to avoid rebinding same logic repeatedly
  function handleExpandCheckboxChange(event) {
    const { id, checked } = event.target;
    console.log("Expand checkbox changed:", id, checked);
    updateCheckboxState1(id, checked);  // your existing logic
    console.log("Updated checkboxState:", checkboxState);
  }


  function updateCheckboxState(id, checked) {
    // console.log("updateCheckboxState called for id:", id, "checked:", checked);
    const index = checkboxState.findIndex(([columnId]) => columnId === id);
    if (index >= 0) {
      checkboxState[index][1] = checked;
    } else {
      checkboxState.push([id, checked]);
    }
    // toggleGroupTotals(id, checked) 
     console.log("Test10",checkboxState);
  }

  function initExpandCheckboxes() {
    if (expandCheckboxesInitialized) return; // stop if already initialized

    expandCheckboxesInitialized = true;      // mark as initialized

    const expandCheckboxes = document.querySelectorAll('#groupColumnIdsDivExpand input[type="checkbox"]');
    
    expandCheckboxes.forEach(cb => {
      const id = cb.id;
      const isChecked = cb.checked;

      // if not already in array, add it
      if (!checkboxState.some(([columnId]) => columnId === id)) {
        checkboxState.push([id, isChecked]);
      }
    });
    console.log("Test11",checkboxState);
    // console.log("After initExpandCheckboxes:", checkboxState);

  }

  function updateCheckboxState1(id, checked) {
    initExpandCheckboxes(); 
    const index = checkboxState.findIndex(([columnId]) => columnId === id);
    console.log("updateCheckboxState called for id:", id, "checked:", checked);
    if (index >= 0) {
      console.log("if");
      checkboxState[index][1] = checked;
    } else {
       console.log("else");
       checkboxState.push([id, checked]);
    }
    // console.log("checkboxState",checkboxState);
    toggleExpandGroup(id, checked) 
    console.log("Test12",checkboxState);
    // console.log("checkboxState updated:", checkboxState);
  }

 

  // === Expand/Collapse Row Groups Dynamically ===
  function toggleExpandGroup(fieldName, isChecked) {
      fieldName = fieldName.replace("ExpRG_","");
      console.log("toggle",fieldName,isChecked);
      // if (!window.gridApi) return; // grid not ready yet

      // Read current row-group columns in order (level 0, 1, 2, …)
      const state = gridApi.getState();
      const groupColIds = (state && state.rowGroup && state.rowGroup.groupColIds) ? state.rowGroup.groupColIds : [];

      // Find which group LEVEL this checkbox corresponds to
      const levelIndex = groupColIds.indexOf(fieldName);

      if (levelIndex === -1) {
        console.log('No match for checkbox id:', fieldName, 'Current groups:', groupColIds);
        return;
      }

      // Expand/collapse only nodes at that level
      gridApi.forEachNode(node => {
        if (node.group && node.level === levelIndex) {
          node.setExpanded(isChecked);
        }
      });
  }

  function toggleGroupTotals(column, showTotals) {
    const columnDefs = gridApi.getColumnDefs(); // Get current column definitions
    // console.log("toggleGroupTotals", columnDefs)
      columnDefs.forEach(colDef => {
          if (colDef.field === column) {
              colDef.showRowGroup = showTotals ? column : false;
          }
      });
      // console.log(gridOptions)
      // console.log(columnDefs)
      // console.log(gridApi)
      // gridApi.setGridOption("columnDefs", gridOptions.columnDefs);
      // gridApi.setColumnDefs(gridOptions.columnDefs); // Refresh grid
  }

  function updateCheckboxUI() {
    // console.log("in updateCheckboxUI()")
    const checkboxes = document.querySelectorAll('#groupColumnIdsDiv input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
      const id = checkbox.id;
      checkbox.checked = isChecked(id);
    });

    const checkboxes1 = document.querySelectorAll('#groupColumnIdsDivExpand input[type="checkbox"]');
    checkboxes1.forEach(checkbox => {
      const id = checkbox.id;
      checkbox.checked = isChecked(id);
    });
  }

  function updateCheckboxVisibility() {
    // console.log("in updateCheckboxVisibility()", checkboxState);
    const groupColumnIdsDiv = document.getElementById("groupColumnIdsDiv");
    if (checkboxState !== undefined) {
      if (checkboxState.length > 0) {
        groupColumnIdsDiv.style.display = "block";
      } else {
        groupColumnIdsDiv.style.display = "none";
      }
    }

  }

  function updateExpandCheckboxVisibility() {
    // console.log("in updateCheckboxVisibility()", checkboxState);
    const groupColumnIdsDivExpand = document.getElementById("groupColumnIdsDivExpand");
    if (checkboxState !== undefined) {
      if (checkboxState.length > 0) {
        groupColumnIdsDivExpand.style.display = "block";
      } else {
        groupColumnIdsDivExpand.style.display = "none";
      }
    }

    // const groupColumnIdsDivExpand = document.getElementById("groupColumnIdsDivExpand");
    // if (checkboxState !== undefined) {
    //   if (checkboxState.length > 0) {
    //     groupColumnIdsDivExpand.style.display = "block";
    //   } else {
    //     groupColumnIdsDivExpand.style.display = "none";
    //   }
    // }
  }
  // setTimeout( function(){ 
  //   // Do something after 1 second 
  //   test();
  // }  , 3000 );

  // function test(){
  //   console.log("test")
  //   gridApi.updateGridOptions("enableAdvancedFilter", "true");
  // }

  /*  //FOR ADVANCED FILTER - 5 
  const checkbox = document.getElementById('test');
  document.addEventListener('DOMContentLoaded', function() { // Function to set grid options based on checkbox state
    // Listen for change events on the checkbox
    checkbox.addEventListener('change', setGridOptionsBasedOnCheckbox);
    
    // Function to programmatically set the checkbox state
    function setGridOptionsBasedOnCheckbox() {
      if (checkbox.checked) {
          gridApi.setGridOption("enableAdvancedFilter", true);
          console.log("checked");
      } else {
          gridApi.setGridOption("enableAdvancedFilter", false);
          console.log("unchecked");
      }
    }
  });*/


  // Function to programmatically set the checkbox state
  function setGridOptionsBasedOnCheckbox1() {
    // console.log($("#advanced-filter-switch").prop('checked'))
    if ($("#advanced-filter-switch").prop('checked') == true) {
        gridApi.setGridOption("enableAdvancedFilter", true);
        // console.log("checked");
    } else {
        gridApi.setGridOption("enableAdvancedFilter", false);
        // console.log("unchecked");
    }
  }

  // Function to programmatically set the repeatParent checkbox state
  function setOpenedGroupOnRepeatParent(){
    // If repeatParent value is 1, check the checkbox, otherwise uncheck it
    if ($("#repeatParent").prop('checked') == true) {
        gridApi.setGridOption("showOpenedGroup", true);
    } else {
        gridApi.setGridOption("showOpenedGroup", false);
    }

  }

  function setOpenedGroupOnRepeatParentValue(repeatParent){
    // If repeatParent value is 1, check the checkbox, otherwise uncheck it
    if (repeatParent === 1) {
        $("#repeatParent").prop('checked', true); // Check the checkbox
    } else {
        $("#repeatParent").prop('checked', false); // Uncheck the checkbox
    }
  }

  // Set group display type 
  function setGroupDisplayType(){
    const value = document.getElementById("groupDisplayType").value; 
    gridApi.setGridOption("pivotMode", false);
    gridApi.setGridOption("groupDisplayType", value);
    gridApi.setGridOption("suppressRowGroupHidesColumns", true);
    gridApi.setGridOption('groupHideOpenParents',value === 'multipleColumn' ? true : false);
    $('#group_display_type').val(value);
  }

</script>

<!-- Scheduler --> 
<script>
  function openSchdModal(){
    // alert(type); 
    getSchedulerData();  // Call AJAX to fetch data when modal opens
  }

  function getSchedulerData(){
    $.ajax({
      url: 'getReportSchedulerData.php', 
      method: 'POST',
      dataType: 'json',
      data: {ReportID: <?php echo $ReportID; ?>,},
      success: function(response) {
        if(!response.success){
          alert(response.msg);
          return;
        }
        $('#SchdModal').modal('show');
        const rows = response.data || [];
        const ddTbody = $("#schdList").empty();
        // console.log(rows);
        if (response.telegram_users.length === 0 && response.email_users.length === 0 && response.whatsapp_users.length === 0) {
          ddTbody.append("No Data Found");
        } else {
          const $select = $('<select></select>').attr('id', 'sch_time').addClass('form-control');
          $.each(rows, function (index, item) {
            // console.log(item);
            const $option = $('<option></option>')
              .val(item.ID)
              .text(item.Time);
            $select.append($option);
          });
           const $wrapper1 = $('<div></div>')
            .addClass('col-md-6 sch_time_div')
            .append($select);
           const $wrapper = $('<div></div>')
            .addClass('row')
            .append($wrapper1);
          $("#schdList").append($wrapper);
          $(".sch_time_div").prepend("<label>Time</label>");
          
          var dataS = '<div class="col-md-6"><label>Page Size</label><select class="form-control" name="sch_size">'
              + '<option value="A4">A4</option>'
              + '<option value="A3">A3</option>'
              + '<option value="A2">A2</option>'
              + '<option value="A1">A1</option>'
              + '<option value="A5">A5</option>'
              + '<option value="LETTER">Letter</option>'
              + '<option value="LEGAL">Legal</option>'
            + '</select></div>'
            + '<div class="col-md-6"><label>Page Orientation</label><select class="form-control" name="sch_orientation">'
              + '<option value="Landscape">Landscape</option>'
              + '<option value="Portrait">Portrait</option>'
            + '</select></div>' ; 
          $(".sch_time_div").after(dataS);
          var userOptions = "";
          $.each(response.telegram_users, function (index, item) {
            userOptions += "<option value='"+item.ID+"'>"+item.Name+"</option>";
          });
          $(".sch_time_div").after("<div class='col-md-6'><label>Telegram Users</label><select id='sch_users' class='form-control' style='width:100%' multiple data-plugin-select2>"+userOptions+"</select></div>");
          userOptions = "";
          $.each(response.email_users, function (index, item) {
            userOptions += "<option value='"+item.ID+"'>"+item.Name+"</option>";
          });
          $(".sch_time_div").after("<div class='col-md-6'><label>Email Users</label><select id='sch_users_email' class='form-control' style='width:100%' multiple data-plugin-select2>"+userOptions+"</select></div>");
          userOptions = "";
          $.each(response.whatsapp_users, function (index, item) {
            userOptions += "<option value='"+item.ID+"'>"+item.Name+"</option>";
          });
          // $(".sch_time_div").after("<div class='col-md-6'><label>WhatsApp Users</label><select id='sch_users_whatsapp' class='form-control' style='width:100%' multiple data-plugin-select2>"+userOptions+"</select></div>");

          $('#sch_users').select2(); 
          $('#sch_users_email').select2(); 
          // $('#sch_users_whatsapp').select2(); 
          
        }
      },
      error: function(xhr, status, error) {
        console.error('Failed to load data:', error);
        callback(false); // Callback with false on error
      }
    });
  }
</script>

	<div class="modal fade" id="SchdModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Schedule Report</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="schdList">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal" onclick='scheduleReportSubmit()'>Submit</button>
				</div>
			</div>
		</div>
	</div>

    <script>
      $(document).ready(function () {
        setTimeout(function(){ 
          $(".filter-section").click();
        }, 500);

      });
    </script>
  </>
<?php 
} ?>
<!--GENERAL ON LOAD SCRIPT FOR THE ENTIRE PAGE -->
<script>
      $(document).ready(function() {
          $(".page-header h2").html("<?php echo $viewReportSettings[1]; ?>");
          $(document).prop('title', '<?php echo $viewReportSettings[1]; ?>');
      });
    </script>
<?php

	include "report-close.php"; 
?>
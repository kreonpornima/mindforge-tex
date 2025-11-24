<?php
  $filterCode = array();
  $ReportID = isset($_REQUEST['ReportID']) ? $_REQUEST['ReportID'] : 0;
  //ReportID=3164 for testing of editable dropdown
  $k_head_title="Report";
  $k_head_include = "";
//   include "report-init-new.php";
  //print_r($code);
  // echo "Database" . $_SESSION['dbName'] . "uid" . $_SESSION['dbUser'];
  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
      $url = "https://";   
  else  
      $url = "http://";  
  $url .= $_SERVER['HTTP_HOST'];   
  $url .= $_SERVER['REQUEST_URI'];
  $urlpos = strpos($url, '&', strpos($url, '&') + 1);
  $url = substr($url, 0, $urlpos) . "&ReportID=" . $ReportID;
 
?>

<!-- <link rel="stylesheet" type="text/css" href="/assets/vendor/jquery-datatables/extras/TableTools/css/dataTables.tableTools.css"> -->
<!-- <script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/buttons.bootstrap4.min.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="/assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script> -->
<link rel="stylesheet" href="	https://cdn3.devexpress.com/jslib/23.2.4/css/dx.light.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.4/js/dx.all.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.1.1/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community@31.3.2/dist/ag-grid-community.js?t=1715777153731"></script> -->
<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script> -->

<!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

<style>
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

  /* #filters{
    display:none;
    
  } */
  /* @media print {
    body {
      visibility: hidden;
    }
    #myGrid {
      visibility: visible;
      position: absolute;
      left: 0;
      top: 0;
    }
  } */
  .wrapper {
      display: flex;
      flex-direction: column;
      height: 100%;
  }

  #myGrid {
      flex: 1 1 auto;
        /* width: 1380px; */
      height:595px;
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
</style>
<style>
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
  let allData = null;
  let DataStructure = null;
  let count=0;
  let toppivot = 0;
  var data = [];

  // agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-059380}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{30 June 2024}____[v3]_[0102]_MTcxOTcwMjAwMDAwMA==59fc6bfa6d27f2fc6c8e0be66a04b355");
  agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-061119}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 July 2024}____[v3]_[0102]_MTcyMjM4MDQwMDAwMA==945278da60ff465f559911e628a1a59f"); //new
  
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
          var value = gridApi.getValue(column, node) || '';
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
          return {
              text: gridApi.getValue(column, node) || '',
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

  async function getDocument(gridApi) {
      var columns = gridApi.getAllDisplayedColumns();
      var headerRow = getHeaderToExport(gridApi);
      var rows = await getRowsToExport(gridApi);
      console.log("Header Row", headerRow);
      console.log("Rows", rows);
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

  async function exportToPDF(gridApi) {
    
      $('body').append('<div style="" id="loadingDiv"><div class="loader">Loading...</div></div>');
      var doc = await getDocument(gridApi);
      console.log("Loading PDF", doc)
      pdfMake.createPdf(doc).download(tempName || 'download.pdf');
      setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.
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
$code = null;
if(is_array($code)){
   ?>
  <section class="panel report-filters-section">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="panel-action panel-action-toggle filter-section" data-panel-toggle=""></a>
      </div>
        <h2 class="panel-title">Report Filters</h2>
        <!-- <p class="panel-subtitle">2 of 4 filters selected</p> -->
      </header>
      <div class="panel-body">
        <form method="get">
          <div class="col-md allfields filterSection">
            <?php
              $filterCode = array();
              $filterString="&";
              $tmp = "";
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
              //print_r($filterCode);
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
if($_GET['Submit'] == "FILTER" || sizeof($code) == 0){ ?>
<!-- <button onclick="exportToExcelAndPDF()">Export to Excel and PDF</button> -->
<!-- <script>
       async function exportToExcelAndPDF() {
            // Retrieve the row data dynamically from the grid
            const rowData = [];
            gridApi.forEachNode(
                    node => node.data !== undefined ? rowData.push(node.data) : ""
                );

            // Log row data to ensure it is retrieved correctly
            console.log('Row Data:', rowData);

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
            console.log('PDF Data:', pdfData);

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
    </script> -->

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
        <option value="1">Pivot</option>
        <!-- <option value></option> -->
        <?php
        // $sql ='SELECT ID, Label FROM kreporttypes';
        // $result = db::getInstanceMaster()->db_select($sql);
        // for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row
        //     echo '<option value="'.$result['result_set'][$i]['ID'].'">' . $result['result_set'][$i]['Label'] . '</option>';
        //     break;
        //   }
        ?>
      </select>
    </div>

    <div class="col-md-3 template" >
      <label for="template">Template:</label>
      <select name="template" class="templateSelect form-control" id="templateSelect">
        <option value=""></option>
        <option value="1">A</option>
        <option value="2">B</option>
          <?php
            // $sql = 'SELECT ID, TemplateName, TemplateTypeID FROM kreport_template_data where ReportID = ' . $ReportID;
            // '$result1 = db::getInstanceMaster()->db_select($sql);
            // Output the number of rows
            // $num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
            // echo "Number of rows in the result set: $num_rows<br>";
            
            // Loop through the result set and output options
            // for ($i = 0; $i < $num_rows; $i++) {
              // echo '<option class="gridTemplate' . $result1['result_set'][$i]['TemplateTypeID'] . '" value="' . $result1['result_set'][$i]['ID'] . '">' . $result1['result_set'][$i]['TemplateName'] . '</option>';
            // }
          ?>
      </select>
    </div>

    <div style='text-align:right;'>
      <input type="hidden" id="pdf_size" value="A4" />
      <input type="hidden" id="pdf_orientation" value="Landscape" />
      <input type="hidden" id="pdf_imgw" value="50" />
      <a href='#' class='btn btn-secondary renameBtn' style='margin-top: 25px;display:none;' onclick='renameTemplate();'>Rename Template</a>
      <a href='#' class='btn btn-secondary deleteBtn' style='margin-top: 25px;display:none;' onclick='deleteTemplate();'>Delete Template</a>
      <button id="pdf" class="btn btn-secondary" style="margin-top: 25px;" onClick="exportToPDF(gridApi)">Export to PDF</button>
      <!-- <button id="pdf" class="btn btn-secondary" style="margin-top: 25px;" onClick="exportGridDataToPdf(gridApi)">Export to PDF 2</button> -->
      <a href='#' class='btn btn-primary' style='margin-top: 25px;' onclick='$("#saveAsModal").modal("show");'>Save Template As</a>
      <a href='#' class='btn btn-primary' style='margin-top: 25px; margin-left: 10px;' onclick='save()'>Save</a>
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
  let checkboxState = []; // Define as let for reassignment

  function printDiv(divId) {
      // var printContents = document.getElementById(divId).innerHTML;
      // var originalContents = document.body.innerHTML;
      // document.body.innerHTML = printContents;
      window.print();
      // document.body.innerHTML = originalContents;
  }

  function onBtPrint() {
    console.log("btn clicked");
    setPrinterFriendly(gridApi);
    // window.print();
    setTimeout(() => {
      // print();
      printDiv("myGrid");
      setNormal(gridApi);
    }, 2000);
  }

  function setPrinterFriendly(api) {
    console.log("set printer");
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
      console.log("<= ***** SAVE AS ***** =>");
      alert("<= ***** SAVE AS ***** =>");
      // templateId=0;
      tempName = $("#templatetitle").val();
      templateDescription = $("#templatedescription").val();
      // console.log("tempName",tempName);
      $("#templatetitle").val("");
      $("#templatedescription").val("");
      tempName_for_modal=tempName;
      console.log(tempName_for_modal);
      // console.log("modal report ID",);
      // console.log("modal templateId",templateId);
      // console.log("modal tempName",tempName);
      // console.log("modal template Description",templateDescription);
      // console.log("modal typeID",typeId);
      // console.log("modal state",h);
      // tempName="";
      // templateDescription = "";
      // call_for_template = true;
      // console.log(call_for_template);
      h = gridApi.getState();
      j = gridApi.getColumnState();
      h.columns=j;
      pivotglobalstate = h;
      var templateRename = $("#templateRename").val();
      // sendStorageRequest("storageKey", "text", "PUT", pivotglobalstate);
      sendStorageRequestSaveAs(tempName, "json", "POST", pivotglobalstate, templateDescription, 0, templateRename);
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
    alert("SAVING");
    // pivotglobalstate = h;
    // console.log("sent for saving",pivotglobalstate);
    // // console.log();
    // return sendStorageRequest("organisatieKey", "text", "PUT", pivotglobalstate);
    h = gridApi.getState();
    h.checkboxState= checkboxState 
    j=gridApi.getColumnState();
    h.columns=j;
    pivotglobalstate = h;
    // console.log("sent for saving",h);
    // console.log("Sort Mode in save function ",gridApi.getFilterModel());
    // console.log(pivotglobalstate);
    // console.log("save",count++);
    // console.log(pivotglobalsource.concat(j));;
    console.log("h",h);
    // console.log("j",j);
    // return sendStorageRequest("organisatieKey", "text", "PUT", pivotglobalstate);
    templateId = $("#templateSelect").val();
    // if(templateId)
    console.log("templateId", templateId);
    return sendStorageRequestSaveAs(tempName, "json", "POST", pivotglobalstate, templateDescription, templateId);
  } 

  function passingstate(state) {
    console.log("in global save", state);
    globalstate = state;
    expandAll = [];
    filterValues = [];
    console.log("passing");
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
        console.log("Got Data frm API", data);
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
    console.log("<=***** SAVING *****=>");
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
            console.log("error");
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
    console.log(d);
    console.log("ss",tempName_for_modal);
    if(call_for_template){
        templateId=0
        tempName=tempName_for_modal;
        console.log(tempName_for_modal)
    }else{
      templateId = $("#templateSelect").val();
    }
    if(type === "PUT"){
        type = "POST";
        datatype = "json";
    }
    console.log(tempName);
    console.log("templateId", templateId);
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
          console.log(data)
          deferred.resolve(data);
          console.log("tempname",tempName);
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
    console.log("In Save State",h); 
    console.log("Full state");
    // alert("h");
    console.log(gridApi.getState());
    console.log(gridApi.getFilterModel());

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
      companyLogo.src = "https://wsrv.nl/?url=" + params.value;
      // console.log(companyLogo.src);
      companyLogo.setAttribute('style', 'display: block; width: 25px; height: auto; max-height: 50%; margin-right: 12px; filter: brightness(1.1); cursor: pointer;');
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

          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select groupColumnIdsDiv" style="display:none;max-height: 100px;overflow:auto;flex: unset;"><br />'
            + '<label>Show Row Group Total: </label>'
            + '<div id="groupColumnIdsDiv"></div>'
          + '</div>'

          + '<div class="col-md-12 ag-column-select ag-column-panel-column-select" style="max-height1: 100px;overflow:auto;flex: unset;"><br />'
            + '<label>Export PDF Settings: </label>'
            + '<select id="classSelector" class="form-control" onChange="$(\'#pdf_size\').attr(\'value\', this.value); ">'
              + '<option value="A4">A4</option>'
              + '<option value="A3">A3</option>'
              + '<option value="A2">A2</option>'
              + '<option value="A1">A1</option>'
              + '<option value="A5">A5</option>'
              + '<option value="LETTER">Letter</option>'
              + '<option value="LEGAL">Legal</option>'
            + '</select>'
            + '<select id="classSelector" class="form-control" onChange="$(\'#pdf_orientation\').attr(\'value\', this.value); " style="margin: 10px 0">'
              + '<option value="Landscape">Landscape</option>'
              + '<option value="Portrait">Portrait</option>'
            + '</select>'
            + '<label>Image Width (px): </label>'
            + '<span style="font-size: 9px;">If the image doesn\'t come as desired on the PDF, try adjusting the PDF Page size. </span>'
            + '<input id="classSelector" class="form-control" value="50" onChange="$(\'#pdf_imgw\').attr(\'value\', this.value); " style="margin: 0 0 10px 0">'
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
  

  function onFirstDataRendered(params) {
  // Ensure all rows start collapsed after the grid is first rendered
  params.api.forEachNode((rowNode) => {
    rowNode.setExpanded(false);
  });
}
// callRecords: [
//     { Name: "Call 1", City: "Los Angeles" },
//     { Name: "Call 2", City: "Los Angeles" }
// ];


  let savedCheckboxState = [];
  const gridOptions ={
      // enableAdvancedFilter: true,
            columnDefs: columnDefs,
        masterDetail: true,
        detailCellRendererParams: (params) => {
          const nameMatch = params.data === "Alice" || params.data.name === "Harper Johnson";
          // console.log(params.data.);
          // Define detail grid options based on the condition
          let detailGridOptions;
          if (nameMatch) {
            detailGridOptions = {
              columnDefs: [{ field: "account" }],
              defaultColDef: {
                flex: 1,
              },
            };
          } else {
            detailGridOptions = {
              columnDefs: [
                { field: "Qualityname" },
                { field: "Rate" },
                { field: "UOM" },
                { field: "Product_Group" },
              ],
              defaultColDef: {
                flex: 1,
              },
            };
          }

          return {
            detailGridOptions,
            getDetailRowData: (params) => {
              console.log("Loading detail data for:", params.data);

              $.ajax({
                url: `mastergrid.php`,
                headers: {
                  Accept: "application/json",
                  "Content-Type": "application/json",
                },
                data: { data: params.data, ReportID: <?php echo  $ReportID; ?>, },
                type: "GET",
                dataType: "json",
                success: function (data) {
                  console.log("Received data from API:", data, " for ", params.data);

                  // Flatten data if it's an array of arrays
                  const flatData = data.flat();

                  if (Array.isArray(flatData) && flatData.length > 0) {
                    console.log("Flattened data array is not empty. Passing to successCallback.", flatData);
                    params.successCallback(flatData);  // Pass flattened array to successCallback
                  } else {
                    console.log("Flattened data array is empty or undefined. Passing empty array to successCallback.");
                    params.successCallback([]); // Empty if no records
                  }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  console.log("Error fetching data from API:", textStatus, errorThrown);
                  params.successCallback([]); // Use an empty array on error to prevent table issues
                },
              });
            },
          };
        },
        onFirstDataRendered: onFirstDataRendered,
        onRowSelected: (event) => {
          // Only expand if row is selected
          if (event.node.isSelected()) {
            event.node.setExpanded(true); // Expand selected row
          } else {
            event.node.setExpanded(false); // Collapse unselected row
          }
        },

      // treeData: false,
      <?php if($ReportID == 3164) echo 'editType: "fullRow",'; ?>
      defaultColDef: {
        <?php if($ReportID == 3164) echo 'editable: true,'; ?>
        flex: 1,
        // minWidth: 150, //cancelled due to sizetofit
        // supressSizeToFit: true,
        enableRowGroup: true,
        enablePivot: true,
        enableValue: true,
          //   filter: true, 
        filter: true, //"agMultiColumnFilter",
        floatingFilter: true,
      },
      autoSizeStrategy:{
        type: "fitCellContents",
      },
      defaultColDef: {
        // editable: true,
        flex: 1,
        filter: true,
        floatingFilter: true,
        // enableRowGroup: true,
        // filterParams: { buttons: ["apply", "clear"] },
      },
      autoGroupColumnDef: {
        cellRendererParams: {
            suppressCount: true
        },
        // minWidth: 180,
        // filter: "agMultiColumnFilter",
        // filterValueGetter: (params) => params.data.company,
        filter: "agGroupColumnFilter",
        // rowGroupPanelShow: "always",
        // groupDisplayType: "multipleColumns",
      },
      
      // onCellValueChanged: onCellValueChanged,
      icons: {
        "cog-wheel": '<i class="fa fa-gear fa-spin1" aria-hidden="true"></i>',
      },
      onGridReady:e=>{
        topg=0;
        /*if(tempName){ 
          getDataFromAPI(<?php echo $ReportID; ?>, templateId, tempName, templateDescription, typeId, (error, data) => {
            // console.log("in grid getData",count++);
            if (error) {
              console.error('Error fetching data:', error);
              // console.log("in if");
            } else {
              // alert("before fetching ")
              pivotglobalsource=data;
              // console.log("trty",pivotglobalsource);
              // console.log("Fetched",data);
              // console.log("daata.filter",data.filter);
              // console.log("data.filter.filterMOdel",data.filter.filterModel);

              console.log(data.columns);
              gridApi.applyColumnState({ 
                state: data.columns,
                applyOrder: true,
              });
              console.log("Top Pivot in GridReady", toppivot);
              if(toppivot){
                gridApi.setGridOption("pivotMode", toppivot.pivotMode);
              }
              
              topfilters=undefined;
              if(data.filter != undefined){
                  topfilters =data.filter.filterModel
                  gridApi.setFilterModel(topfilters);
              }
              // console.log("After Fetche",gridApi.getState());
            }
          });
        }
        */
        // Initialize checkboxState based on savedCheckboxState if it's not undefined
        if(data !== undefined){
          if (data.checkboxState !== undefined) {
            savedCheckboxState = data.checkboxState;
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
        //     // Clear checkboxState if there's no savedCheckboxState
          checkboxState = [];
        }
        // Update checkboxes in the UI
        updateCheckboxUI();

        // Hide or show the checkbox div based on checkboxState
        updateCheckboxVisibility();
      },
      onStateUpdated:event =>{
        topg++
        templateg++;
        if(topg==3){
          console.log("Filters in StateUpdatedEvent", topfilters);
          if(topfilters !== undefined) gridApi.setFilterModel(topfilters);
          gridApi.applyColumnState({ 
            state: pivotglobalsource.columns,
            applyOrder: true,
          });
        }


        //Added for RowGroupTotal checkboxes
        let rowg = gridApi.getState();
        console.log(rowg);
          let groupColIds = [];
          let checkboxState = [];
        if(rowg.rowGroup !== undefined){
          console.log(rowg.rowGroup.groupColIds)
          // groupColIds = rowg.rowGroup.groupColIds;
          groupColIds = rowg.rowGroup.groupColIds;
          // groupColIds = groupColIds.replace("/", "_");
        }
        // console.log("before checkboxstate", groupColIds)
        // Update checkboxState to include all group column IDs
        groupColIds.forEach(id => {
          // console.log("checkboxstate currently: ", checkboxState)
          if (!checkboxState.some(([columnId]) => columnId === id)) {
            // console.log("setting checkboxstate")
            checkboxState.push([id, false]); // Initialize to unchecked
          }
        });
        // console.log("After Setting checkboxstate", checkboxState)
        // Remove unchecked checkboxes that are no longer in the groupColIds
        checkboxState = checkboxState.filter(([columnId]) => groupColIds.includes(columnId));

        // Update UI only if there are checkboxes to display
        if (checkboxState.length > 0) {
          // console.log("After Setting checkboxstate 2", checkboxState)
          $(".groupColumnIdsDiv").show();
          document.getElementById("groupColumnIdsDiv").innerHTML = generateCheckboxHTML(groupColIds);
          // console.log("checkboxState after update:", checkboxState);
          addCheckboxListeners();
          updateCheckboxVisibility(); // Update visibility based on checkboxState
        } else {
          $(".groupColumnIdsDiv").hide();
          document.getElementById("groupColumnIdsDiv").innerHTML = ''; // Clear the checkbox div
          checkboxState = [];
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
      },
      animateRows:true,
      groupHideOpenParents: true,
      groupSuppressBlankHeader: true,
      // enableFillHandle:true,
      rowGroupPanelShow: "always",
      // enableRangeSelection: true,
      enableCharts:true,
      popupParent:document.body,
      // rowSelection: "multiple",
      suppressStickyTotalRow: 'grand', //group/ grand/ true/ false
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
      // groupDefaultExpanded: 9,
      // groupHideOpenParents: true,
      // groupDisplayType: "multipleColumns",
      // sideBar: true,
      // onFilterChanged(params) {
      //     const filterModel = params.api.getFilterModel();
      //     console.log("Filterchange", filterModel);
      //     localStorage.setItem('filterModel', JSON.stringify(filterModel));
      // }
      // onFilterChanged = (
      //     event: FilterChangedEvent<TData>
      // ) => void;

      // onFirstDataRendered(params) {
      //     const filterModel = JSON.parse(localStorage.getItem('filterModel'));
      //     console.log("Render", filterModel);
      //     if (filterModel) {
      //         params.api.setFilterModel(filterModel);
      //     }
      // },

      // use the server-side row model instead of the default 'client-side'
      //   rowModelType: "serverSide",
      //   pivotMode: true,
      
      // enableAdvancedFilter: true,
      // initialState: {
      //     filter: {
      //     advancedFilterModel: initialAdvancedFilterModel,
      //     },
      // },
      // onFirstDataRendered: (params) => {
      //     params.api.showAdvancedFilterBuilder();
      // },  
      // onGridReady: (params) => {
          // console.log("Grid Ready", params)
          // params.api.getToolPanelInstance("filters").expandFilters();
          // gridApi.setFilterModel('{"SABDEPART": {"filterType": "multi","filterModels": [null,{"values": ["Local Sheet"],"filterType": "set"}]},"PPROCESS": {"filterType": "multi","filterModels": [null,{"values": ["Stenter-Eff"],"filterType": "set"}]}}');
          // gridApi.onFilterChanged();
      // },
      // onColumnEverythingChanged: params => {
      //     console.log(params.columnApi.getAllDisplayedColumns().map(col => col.colId))
      // }

      // groupTotalRow: "bottom",
      // groupTotalRow: UseGroupTotalRow<TData>,
      
      groupTotalRow: (params) => {
        // if(params.node.level === 0) console.log("In Group Total: ", checkboxState);
        if(checkboxState !== undefined){
          for(var i = 0; i < checkboxState.length; i++){
            if(checkboxState[i][0] === params.node.field){
              if(checkboxState[i][1]){
                return "bottom";
              }
            }
          }
        }
        return undefined;
        // return getTotalRowParams(params.node);
        // // console.log(params.node);
        // const node = params.node;
        // // console.log(node.level + " => " + node.field);
        // if(node && node.field == "jobno"){
        //   console.log(node.field)
        //   return undefined;}
        // else 
        //   return "bottom";
        // // if(node && node.level === 0) return "bottom";
        // // if(node && node.level === 1) return "bottom";
        // // if(node && node.level === 2) return "bottom";
        // // if(node && node.level === 4) return undefined;
        // // else return "bottom";
      },
      grandTotalRow: "bottom",
      groupDefaultExpanded: -1,
      // supressMenuHide: true,
  };
  function onCellValueChanged( CellValueChangedEvent) {
  console.log("Data after change is",data);
}
  function getTotalRowParams(nodes){
    console.log("Field=> ", nodes.field);
    return "bottom";
  }

    // interface UseGroupTotalRow<TData = any> {
    //     (params: GetGroupIncludeTotalRowParams<TData>) : 'top' | 'bottom' | undefined
    // }

    // interface GetGroupIncludeTotalRowParams<TData = any, TContext = any> {
    //   node: IRowNode<TData>;
    //   // The grid api. 
    //   api: GridApi<TData>;
    //   // Application context as set on `gridOptions.context`. 
    //   context: TContext;
    // }
</script>

<script>
  $(document).ready(function () {
    var selectedType = "1";
    $('.datagrid-display').hide(); // Hide datagrid-display initially
    $('.pivotgrid-display').hide(); // Hide pivotgrid-display initially
    $('.typeSelect').change(function () {
      $('#groupColumnIdsDiv').innerHTML="";
      $(".groupColumnIdsDiv").hide();
      checkboxState = [];
      //   selectedType = $(this).val();
      selectedType = "1";
      
      $('.datagrid-display').hide(); // Hide datagrid-display
      $('.pivotgrid-display').hide(); // Hide pivotgrid-display
      $("#templateSelect").val(''); // Clear template selection
      if (selectedType === "1") {
        // alert(selectedType);
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
      $(".renameBtn").show();
      $(".deleteBtn").show();
      checkboxState = [];
      // alert(selectedType);
      if (selectedType === "1") {
        var gridDiv = document.querySelector("#myGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);
        console.log(gridApi);
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
      
      gridApi.setGridOption("enableAdvancedFilter", false);

      getDataFromAPI(<?php echo $ReportID; ?>, templateId, tempName, templateDescription, typeId, (error, data) => {
        console.log("in api");
        if (error) {
          console.error('Error fetching data:', error);
          console.log("in if");
        } else {
            pivotglobalsource=data;
            console.log("trty",pivotglobalsource);
            console.log("Fetched",data.columns);
            $(".groupColumnIdsDiv").hide();
            $('#groupColumnIdsDiv').html("");
            checkboxState = [];
            // CHANGE FOR ADVANCED fILTER -2
            if (data.filter.advancedFilterModel) {
              gridApi.setGridOption("enableAdvancedFilter", true);
              $("#advanced-filter-switch").prop('checked', true);
              gridApi.setAdvancedFilterModel(data.filter.advancedFilterModel)
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
            toppivot = data.pivot;
            console.log("Top Pivot in Template Select", toppivot);
            if(toppivot){
              gridApi.setGridOption("pivotMode", toppivot.pivotMode);
            }
            checkboxState = data.checkboxState;
            console.log("CB State=> ", checkboxState);
            // console.log("sort",pivotglobalsource.sort);
            // console.log("in getdatafrom Api in ongrid Ready",topfilters,tempName);
            gridApi.closeToolPanel();
            gridApi.applyColumnState({ 
                state: data.columns,
                applyOrder: true,
            });
            // console.log("After Fetche",gridApi.getState());
            // console.log("Sort Model",gridApi.getFilterModel());
        }
      });
      
    });
    setTimeout(function(){ 
      $('.typeSelect').val('1').trigger('change');
        }, 1000);
    // $('.typeSelect').val('1').trigger('change');
  });
</script>
<script>
function loadPivotGridData() {
  console.log("ccalled loadPivotGridData");
  $("html, body").animate({ scrollTop: $(document).height() }, 1000);
  
  // var gridDiv = document.querySelector("#myGrid");
  // gridApi = agGrid.createGrid(gridDiv, gridOptions);
  // console.log(gridApi);
  console.log("topfilters", topfilters);

  if (allData !== null) {
    console.log(">>>>***", allData[0]);
    dynamicallyConfigureColumnsFromObject(DataStructure);
    gridApi.setGridOption('rowData', allData);
    console.log("Filters in loadPivot allData != null", topfilters);
    gridApi.setFilterModel(topfilters);
  } else {
    fetch("reportGetDataFromView2.php?ReportID=<?php echo $ReportID; ?>")
    // fetch("mastergrid.php")  
    .then(function (response) {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.json();
      })
      .then(function (fullData) {
        console.log('*******DATA FROM DB********');
        console.log(fullData);

        data = fullData[0];
        DataStructure = fullData[1];
        allData = data;

        dynamicallyConfigureColumnsFromObject(DataStructure);

        toppivot = data.pivot || {}; // Ensure pivot object exists
        if (data.filter != undefined) {
          topfilters = data.filter.filterModel;
        }
        
        console.log(data);
        gridApi.setGridOption('rowData', data);
        console.log("Filters in loadPivot allData=null", topfilters);
        gridApi.setFilterModel(topfilters);
        console.log(gridApi);
      })
      .catch(function (error) {
        console.error("Error fetching data: ", error);
      });
  }

  console.log("Top Pivot in LoadPivotGrid", toppivot);
  
  if (toppivot) {
    gridApi.setGridOption("pivotMode", toppivot.pivotMode);
  }
}
</script>
<script>


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
        console.log("[Datasource] - rows requested by grid: ", params.request);

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
  function dateFormatter(params) {
    // console.log("///////////////", params);
    if(params == null)  return null;
    if(params.value == null)  return null;
    if(params.value.length > 5){
      var dateAsString = params.value;
      var dateParts = dateAsString.split("-");
      console.log(`${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`);
      return `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
    }else{
      return null;
    }
  }

  // DATE COMPARATOR FOR SORTING
  function dateComparator(date1, date2) {
    // console.log(">>>>>>>", date1, date2)
    /*var date1Number = _monthToNum(date1);
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

    return date1Number - date2Number;*/
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

  function dynamicallyConfigureColumnsFromObject(anObject){
    console.log(gridApi);
    var gridDiv = document.querySelector("#myGrid");
    gridApi = agGrid.createGrid(gridDiv, gridOptions);
    const colDefs = gridApi.getColumnDefs();
    colDefs.length=0;
    console.log("anObject");
    console.log(anObject);
    const keys = Object.keys(anObject);
      keys.forEach(key => {
          console.log(anObject[key]); //anObject[key]['COLUMN_NAME'];
          let filter;
          let checkBox = "";
          // if(colDefs.length == 0) checkBox = ", 'checkboxSelection':true, 'showDisabledCheckboxes':true";
          let filterParams = {maxNumConditions:5};
          var dateFilterParams = {
              comparator: (filterLocalDateAtMidnight, cellValue) => {
                  // console.log("**********" , cellValue)
                  var dateAsString = cellValue;
                  if (dateAsString == null) return -1;
                  var dateParts = dateAsString.split("-");
                  var cellDate = new Date(cellValue);
                  // var cellDate = new Date(
                  //   Number(dateParts[2]),
                  //   Number(dateParts[1]) - 1,
                  //   Number(dateParts[0]),
                  // );
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
          const dataType = anObject[key]['DATA_TYPE']; //const dataType = typeof anObject[key];
          const colName = anObject[key]['COLUMN_NAME'];
          // console.log(colName, " - ", dataType)
          if(dataType == "int" || dataType == "bigint" || dataType == "float" || dataType == "decimal" || dataType == "money"){
            console.log(colName, " - ", dataType, " => NUMBER");
            if(colDefs.length == 0)  
              colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agNumberColumnFilter', 'filterParams': filterParams, 'checkboxSelection':true,'showDisabledCheckboxes':true});
            else 
              colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agNumberColumnFilter', 'filterParams': filterParams});
          }else if(dataType == "date" || dataType == "smalldatetime" || dataType == "datetime"){
            console.log(colName, " - ", dataType, " => DATE");
            colDefs.push({ 'field': colName, 'colId':colName , 'filter':'agDateColumnFilter','filterParams': dateFilterParams,'valueFormatter': dateFormatter, 'comparator': dateComparator,});
          }else if(anObject[key]['COLUMN_NAME'].match("^IMG_")){
            console.log(colName, " - ", dataType, " => IMAGE");
            colDefs.push({ 'field': colName, 'colId':colName , 'cellRenderer': CompanyLogoRenderer });
          }else{  //VARCHAR 
            console.log(colName, " - ", dataType, " => OTHERS");
            if(colDefs.length == 0) {
              colDefs.push({ 'field': colName, 'colId':colName , 'cellDataType': 'text', 'filter':'agMultiColumnFilter', 'filterParams': filterParams, 'checkboxSelection':true,'showDisabledCheckboxes':true});
            } 
              // else{
              //   colDefs.push({ 'field': colName, 'cellEditor': "agSelectCellEditor", 'cellEditorParams': {values: ["Porsche", "Toyota", "Ford", "AAA", "BBB", "CCC"]}, 
              //   'colId':colName , 'cellDataType': 'text', 'filter':'agMultiColumnFilter', 'filterParams': filterParams});
              // }
              else {  // For VARCHAR or other types
                  console.log(colName, " - ", dataType, " => OTHERS");

                  let cellEditorParams = {};

                  // Set different dropdown values based on column name
                  if (colName === 'Name') {
                      cellEditorParams = { values: ["Alice", "Bob", "Charlie"] }; // Dropdown options for Name
                  } else if (colName === 'City') {
                      cellEditorParams = { values: ["New York", "Los Angeles", "Chicago"] }; // Dropdown options for City
                  } else {
                      cellEditorParams = { values: ["Default1", "Default2", "Default3"] }; // Default options for other columns
                  }

                  if (colDefs.length === 0) {
                      colDefs.push({
                          field: colName,
                          colId: colName,
                          cellDataType: 'text',
                          filter: 'agMultiColumnFilter',
                          filterParams: filterParams,
                          // checkboxSelection: true,
                          showDisabledCheckboxes: true,
                          cellEditor: "agSelectCellEditor",
                          cellEditorParams: cellEditorParams // Use the defined params here
                      });
                  } else {
                      colDefs.push({
                          field: colName,
                          cellEditor: "agSelectCellEditor",
                          cellEditorParams: cellEditorParams, // Use the defined params here
                          colId: colName,
                          cellDataType: 'text',
                          filter: 'agMultiColumnFilter',
                          filterParams: filterParams,
                          // editable: true,
                          valueSetter: (params) => {
                              console.log("Value Setter" , params)
                              const newValue = params.newValue;
                              const valueChanged = params.data[params.colDef.field] !== newValue;
                              if (valueChanged) {
                                  var oldValue = params.data[params.colDef.field];
                                  console.log(`Old Value: ${params.data[params.colDef.field]}, New Value: ${newValue} for ID: ${params.data.ID} on Field: ${params.colDef.field}` );
                                  params.data[params.colDef.field] = newValue; // Update data
                                  // console.log(`Old Value: ${params.data[params.colDef.field]}, New Value: ${newValue}`);
                                  $.ajax({
                                      url: `updated_data.php`,
                                      headers: {
                                        Accept: "application/json",
                                        "Content-Type": "application/json"
                                      },
                                      data: { ID:params.data.ID,Field:params.colDef.field,oldValue:oldValue,newValue:newValue} ,
                                      type: "GET", 
                                      dataType: "json",
                                      success: function(data) {
                                        console.log("Got Data frm API", data);
                                        callback(null, data);
                                      },
                                      error: function(jqXHR, textStatus, errorThrown) {
                                        console.log("Got ERROR Data frm API", jqXHR);
                                        console.log("Got ERROR Data frm API", textStatus);
                                        callback(new Error(textStatus || errorThrown));
                                      }
                                    });
                              }
                              return valueChanged; // Return true if changed
                          },
                          // valueGetter: (params) => {
                          //     const cellValue = "Default Name"; // Fallback if the property doesn't exist
                          //     return params.data?.[params.colDef.field] || cellValue; // Use optional chaining for safety
                          // },
                      });
                  }
                  
                }

          }

          // console.log("DT: ", dataType, key, isValidDate(anObject[key]));
          /*if((dataType=="string" || dataType=="object") && !isValidDate(anObject[key])){ //and not a date
            if (key.match("^IMG_")) {
              // console.log(key);
              colDefs.push({ 'field': key, 'colId':key , 'cellRenderer': CompanyLogoRenderer });
            }else{
              if(colDefs.length == 0)  
                colDefs.push({ 'field': key, 'colId':key , 'filter':'agMultiColumnFilter', 'filterParams': filterParams, 'checkboxSelection':true, 'showDisabledCheckboxes':true});
              else
                colDefs.push({ 'field': key, 'colId':key , 'filter':'agMultiColumnFilter', 'filterParams': filterParams});
            }
          }else if(dataType=="number"){
            if(colDefs.length == 0)  
              colDefs.push({ 'field': key, 'colId':key , 'filter':'agNumberColumnFilter', 'filterParams': filterParams, 'checkboxSelection':true, 'showDisabledCheckboxes':true});
            else 
              colDefs.push({ 'field': key, 'colId':key , 'filter':'agNumberColumnFilter', 'filterParams': filterParams});
          }else if(isValidDate(anObject[key])){ //dataType=="date"
            // console.log("DT: ", dataType, key, isValidDate(anObject[key]));
            colDefs.push({ 'field': key, 'colId':key , 'filter':'agDateColumnFilter','filterParams': dateFilterParams,'valueFormatter': dateFormatter, 'comparator': dateComparator,});
          }else{
            colDefs.push({ 'field': key, 'colId':key , 'filter':'agMultiColumnFilter', 'filterParams': filterParams});
          }*/
      });
      console.log(colDefs);
    gridApi.setGridOption('columnDefs', colDefs); //gridApi.setColumnDefs(colDefs);
  }
  

  function generateCheckboxHTML(groupColIds) {
    // alert(groupColIds);
    return groupColIds.map(id => `
      <div style="margin-right: 10px; display: inline-block;">
        <input class="rowGrpTtl" type="checkbox" id="${id.replace("/","_")}" name="${id}" value="${id}" ${isChecked(id) ? 'checked' : ''}>
        <label for="${id}">${id}</label>
      </div><br />
    `).join('');
  }

  // function isChecked(id) {
  //   console.log("checkboxState columnid isChecked? : ", id)
  //   return checkboxState.some(([columnId, checked]) => columnId === id && checked);
  // }
  function isChecked(id) {
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
      });
    });
  }

  function updateCheckboxState(id, checked) {
    // console.log("updateCheckboxState called for id:", id, "checked:", checked);
    const index = checkboxState.findIndex(([columnId]) => columnId === id);
    if (index >= 0) {
      checkboxState[index][1] = checked;
    } else {
      checkboxState.push([id, checked]);
    }
    // console.log("checkboxState updated:", checkboxState);
  }

  function updateCheckboxUI() {
    const checkboxes = document.querySelectorAll('#groupColumnIdsDiv input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
      const id = checkbox.id;
      checkbox.checked = isChecked(id);
    });
  }

  function updateCheckboxVisibility() {
    const groupColumnIdsDiv = document.getElementById("groupColumnIdsDiv");
    if (checkboxState.length > 0) {
      groupColumnIdsDiv.style.display = "block";
    } else {
      groupColumnIdsDiv.style.display = "none";
    }
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
</script>

<!-- <img src="http://103.29.116.147:9999/TEX/assets/images/kreon-logo.png" width="100px" /> -->
  
    <script>
      $(document).ready(function () {
        setTimeout(function(){ 
          $(".filter-section").click();
        }, 1000);
        
      });
    </script>
  </>
<?php 
} ?>
<!--GENERAL ON LOAD SCRIPT FOR THE ENTIRE PAGE -->
<script>
      $(document).ready(function() {
          $(".page-header").html("<h2><?php //echo $viewReportSettings[1]; ?></h2>");
          $(document).prop('title', '<?php //echo $viewReportSettings[1]; ?>');
      });
    </script>
<?php

	// include "report-close.php"; 
?>
<?php
include_once('dbClass.php');
session_start();

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : 0;
$ImportFormName = isset($_POST['FormName']) ? $_POST['FormName'] : "";
// print_r($_POST);
// ini_set('display_errors', 1); 
// error_reporting(0);
$k_head_title="Import";
$k_page_title ='Import';
include 'k_files/k_header.php';

echo '<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.0/dist/xlsx.full.min.js"></script>';
if(isset($_GET['view'])){
    if(!$_GET['view'] == 1){
        echo "Error occurred.";  exit();
    }
}else{
    echo "Error occurred.";  exit();
}
// echo '<br /><center><img src="assets/images/AASHVAST.png" style="height: 100px;margin-top: -8px;margin-left:10px;"><h2>Welcome to Ashvast';
$sql = "SELECT DisplayName, FieldType FROM kmainfields WHERE FormId = " . $FormID . " order by DisplayOrder";
$result = db::getInstanceMaster()->db_select($sql);
// print_r($result);
$tmp = '<table class="hidden" id="FormTable"><thead><tr>';
for($i = 0; $i < $result['num_rows']; $i++){
    //Not for 0,12,13,14,20,21,22,24
    $avoidFields = array(0,12,13,14,20,21,22,24);
    if(!in_array($result['result_set'][$i]['FieldType'], $avoidFields))
        $tmp .= "<th>" . $result['result_set'][$i]['DisplayName'] . "</th>";
}
$sql = "select GridId, DisplayName, FieldType from kgridfields where GridId IN (SELECT GridId FROM kmainfields WHERE FormId = " . $FormID . " AND FieldType = 14) order by GridId,DisplayOrder";
$sql = "select kgridfields.GridId, CONCAT(GridTitle, ' : ',DisplayName) as DisplayName
        from kgridfields 
        left join kmaingrid on kgridfields.GridId = kmaingrid.GridId 
        where 
            kgridfields.GridId IN (SELECT GridId FROM kmainfields WHERE FormId = " . $FormID . " AND FieldType = 14) 
            AND FieldType NOT IN (0,12,13,14,20,21,22,24) 
        order by kgridfields.GridId,DisplayOrder";
$result = db::getInstanceMaster()->db_select($sql);
$GridID = 0;
for($i = 0; $i < $result['num_rows']; $i++){
    // $avoidFields = array(0,12,13,14,20,21,22,24);
    // if($GridID !== $result['result_set'][$i]['GridId']){
    //     $GridID = $result['result_set'][$i]['GridId'];
    //     // $tmp .= "<th>GRID</th>";
    // } 
    // if(!in_array($result['result_set'][$i]['FieldType'], $avoidFields))
    $tmp .= "<th>" . $result['result_set'][$i]['DisplayName'] . "</th>";
}
echo $tmp .= '</tr></thead></table>';
?>
<section class="panel forminit">
    <header class="panel-heading"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <h2 class="panel-title">Bulk Import for - <?php echo $ImportFormName; ?></h2>
        <!-- <p class="panel-subtitle"><?php echo isset($k_table_subtitle) ? $k_table_subtitle : ""; ?></p> -->
    </header>
    <div class="panel-body">
        <!-- <h2>Upload Excel File for Validation</h2> -->
        <input type="file" id="uploadExcel" />
        <br />
        <a style="font-size: 11px;margin-top: -8px;display: block;float: left;padding-bottom: 0;" href="#" onclick="exportFormTableToExcel('FormTable','Excel Import Template for Form - <?php echo $ImportFormName; ?>')" class="btn bizbtn" >Download Template</a>
        <br />
        <br />
        <button class="btn btn-primary" id="uploadButton">Upload & Validate</button>
        <div id="validationResults" style="overflow:auto"></div>
        <script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
        <script>
            document.getElementById('uploadButton').addEventListener('click', function () {
                var fileInput = document.getElementById('uploadExcel');
                var file = fileInput.files[0];
                if (!file) {
                    alert('Please choose an Excel file to upload.');
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    var data = new Uint8Array(e.target.result);
                    var workbook = XLSX.read(data, { type: 'array' });
                    
                    // Assuming the first sheet is to be processed
                    var firstSheet = workbook.Sheets[workbook.SheetNames[0]];

                    // Convert sheet to JSON (rows represented as arrays)
                    var jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1, defval: "" });
                    // alert(jsonData)
                    console.log(jsonData)
                    // Send data for validation
                    validateData(jsonData);
                };
                reader.onerror = function (error) {
                    console.error("Error reading file:", error);
                };
                reader.readAsArrayBuffer(file);
            });

            function validateData(data) {
                $.ajax({
                    url: 'validateExcelImport.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { excelData: JSON.stringify(data), FormID: <?php echo $FormID; ?> },
                    success: function (response) {
                        // Display data and validation errors
                        console.log(response);
                        // if(+response.output[0].Success == 0)
                        alert(response.output[0].Msg);
                        buildTable((response.formData));
                    },
                    error: function (xhr, status, error) {
                        alert('An error occurred while validating data.');
                    }
                });
            }
            function buildTable(validationResults) {
                // let tableHtml = '<h5><u>Data with Validation Results</h5><table class="table table-bordered">';
                // tableHtml += '<thead><tr><th>Row</th><th>Data</th><th>Validation Error</th></tr></thead><tbody>';
                // console.log(validationResults)
                // // Loop through the validation results
                // validationResults.forEach(function (result, index) {
                //     console.log(index,result)
                //     tableHtml += '<tr>';
                //     tableHtml += '<td>' + (index + 1) + '</td>';  // Row number
                //     tableHtml += '<td>' + result[0] + '</td>';  // Data
                //     tableHtml += '<td>' + result[1] + '</td>';  // Data
                //     tableHtml += '<td>' + result[2] + '</td>';  // Data
                //     tableHtml += '<td class="error">' + result.error + '</td>';  // Validation error
                //     tableHtml += '</tr>';
                // });

                // tableHtml += '</tbody></table>';

                var data = validationResults;
                // console.log(data);
                // Create the table and add a class for styling
                var table = $('<table>').addClass('table table-bordered');
                
                // Create the table header
                var thead = $('<thead>');
                var headerRow = $('<tr>');
                
                // Add an additional header for the serial number column
                // headerRow.append($('<th>').text('Row No.'));
                
                // Loop through the first row of the data to create headers
                Object.keys(data[0]).forEach(function (header) {
                    headerRow.append($('<th>').text(header));
                });
                
                thead.append(headerRow);
                table.append(thead);
                
                // Create the table body
                var tbody = $('<tbody>');
                
                // Loop through the remaining rows to create table rows
                for (var i = 0; i < data.length; i++) {
                    var row = $('<tr>');
                    
                    // Add the serial number to the first column of each row
                    // row.append($('<td>').text(i)); // Auto-increment serial number
                    Object.values(data[i]).forEach(function (cellData) {
                        row.append($('<td>').text(cellData !== null ? cellData : 'N/A'));
                    });
                    
                    tbody.append(row);
                }
                
                table.append(tbody);
                
                // Append the table to the container in the HTML
                $('#validationResults').html(table);
            }


            
            function exportFormTableToExcel(datatable, filename = ''){
                TableToExcel.convert(document.getElementById(datatable),{
                    name: filename?filename+".xlsx":"excel_data.xlsx"
                });
            }
        </script>
    </div>
</section>

<?php
include "k_files/k_footer.php"; 
?>
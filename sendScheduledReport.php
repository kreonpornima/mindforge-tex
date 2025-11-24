<?php 
include_once('dbClass.php');
//Default values
$company = 17; 
$DivisionID = 1;

$task_id = $argv[1] ?? ($_REQUEST['task_id'] ?? null);
// echo "\n".date('dd-mm-yyyy h:i:s'); sendScheduledReport.php
echo "\nTASKID: " . $task_id . "\n";
$sql = 'select kReportSchedule.ReportID AS ReportID, kReportSchedule.TemplateID AS TemplateID, kReportSchedule.CompanyID AS CompanyID, kReportSchedule.DivisionID AS DivisionID, kReportSchedule.GroupID AS GroupID, kReportSchedule.Filters AS Filters, kmainforms.FormName AS FormName  
        from kReportSchedule LEFT JOIN kmainforms ON kmainforms.FormID = kReportSchedule.ReportID  where kReportSchedule.ID = ' . $task_id;
$result = db::getInstanceMaster()->db_select($sql);
// print_r($result);
if($result['num_rows'] > 0){
    $row = $result['result_set'][0];
    $ReportID = $row['ReportID'];
    $_SESSION['ReportName'] = $row['FormName'];
    $TemplateID = $row['TemplateID'];
    $CompanyID = $row['CompanyID'];
    $DivisionID = $row['DivisionID'];
    $_SESSION['group_id'] = $row['GroupID'];
    $_SESSION['filters'] = $row['Filters'];
    $query = "SELECT CONCAT(AiCompany.Label,' - ', AiDivision.Label, ' - ', AiReg.Year) as Name, Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, Aireg.Database_name, Aireg.Ip, Aireg.Port, Aireg.Sql_User_Id, 
        Aireg.Decrypted_Password, AiCompany.GroupID, Aireg.dtbases, Aireg.ID as RegID
        from Aireg 
        LEFT JOIN AiCompany ON AiReg.CompanyID = AiCompany.ID 
        LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID
        LEFT JOIN AiDivision ON AiReg.DivisionID = AiDivision.ID
        where Aireg.CompanyID='".$CompanyID."' and Aireg.DivisionID='".$DivisionID."' ";

    $result = db::getInstanceMaster()->db_select($query);
    // print_r($result);
    $row = $result['result_set'];
    if(sizeof($row) > 0){
        for($i = 0; $i < count($row); $i++){
            $_SESSION['RegID'] = $row[$i]['RegID'];
            $_SESSION['dbCompanyName'] = $row[$i]['Name'];
            $_SESSION['dbHost'] = $row[$i]['Ip'].','.$row[$i]['Port'];
            $_SESSION['dbUser'] = $row[$i]['Sql_User_Id'];
            $_SESSION['dbPass'] = $row[$i]['Decrypted_Password'];
            $_SESSION['dbName'] = $row[$i]['Database_name'];
            $_SESSION['dbCompany'] = $row[$i]['CompanyID'];
            $_SESSION['dbDivision'] = $row[$i]['DivisionID'];            
            $_SESSION['dbYear'] = $row[$i]['Year']; //only used at dbMySQL. To be removed.
            $_SESSION['dbYearID'] = $yearID;    //Doesn't have Year Code ID. Please Add it
            $_SESSION['Category'] = 2;
        }
    }
}else{
    echo "ERROR"; exit;
    // $ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
    // $TemplateID = (isset($_GET['TemplateID']) ? $_GET['TemplateID'] : 0);
}
$_SESSION['email'] = $UserID = 'autoGen';
include 'reportModel.php';
$db[1] = "sp_GridReport_" . $ReportID;

$ResultStruct = array();
$EditableStruct = array();
$finalResult = array();
$finalKeys = array();
$filterString = "";
$separator = "|";
foreach($_REQUEST as $name => $value) {
    if($name != "ReportID" && $name != "view" && $name != "formid" && $name != "Submit" ) {
        // If it's a Username and value is a 10-digit mobile number
        if (strtolower($name) === 'username' && preg_match('/^\d{10}$/', $value)) {
            $value = 'u' . $value;
        }
        $filterString .= $name."=".$value.$separator;
    }
}
// print_r($viewReportServerSettings);
// print_r($db);
// echo "----";
$table = '##u_gridreportdata_' . $UserID . '_' . $ReportID;
$filterString = 'ssdt=2025-04-01|lldt=2025-10-23|company='.$CompanyID.'|division='.$DivisionID.'|username='.$UserID.'|year=2526|'.$_SESSION['dbYearID'];
if($viewReportServerSettings[0] == 2){
    // echo "viewReportServerSettings";
    //reportSchedulerGetDatar
    $url = $viewReportServerSettings[1] . "reportSchedulerGetData.php?ReportID=" . $ReportID . "&" . str_replace("|", "&", $filterString) . "&username=u" . $_SESSION['email'] . "&RegUser=".$_SESSION['RegID'];  // Replace with the API URL
    /*$ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 20,

        // TLS security – keep these ON
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,

        // If PHP can't find your CA store, uncomment one of these:
        // CURLOPT_CAINFO => '/etc/ssl/certs/ca-certificates.crt',   // Linux
        // CURLOPT_CAINFO => 'C:\\php\\extras\\ssl\\cacert.pem',      // Windows

        // Optional hardening (use only if needed):
        // CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
        // CURLOPT_PINNEDPUBLICKEY => 'sha256//BASE64PIN==',
        // CURLOPT_SSL_VERIFYSTATUS => true,
        // CURLOPT_CERTINFO => true,
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Error('.curl_errno($ch).'): '.curl_error($ch);
        // For debugging the chain (if you enabled CERTINFO):
        // var_dump(curl_getinfo($ch, CURLINFO_CERTINFO));
    } else {
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code >= 200 && $code < 300) {
            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo 'JSON parse error: '.json_last_error_msg();
            } else {
                print_r($data);
            }
        } else {
            echo "HTTP $code\n".substr($response, 0, 500);
        }
    }
    curl_close($ch);*/
    $insecure = true; // DEV ONLY
    echo $url;
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 20,

        // Insecure testing (turn OFF verification)
        CURLOPT_SSL_VERIFYPEER => $insecure ? false : true,
        CURLOPT_SSL_VERIFYHOST => $insecure ? 0 : 2, // 0 disables hostname check; 2 is the safe default
    ]);

    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Error('.curl_errno($ch).'): '.curl_error($ch);
    } else {
        print_r(json_decode($response, true));
    }
    curl_close($ch);

    // data = autoConvertNumericStrings(fullData[0], fullData[1]);
        /*    DataStructure = fullData[1];
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
                    // detailCellRendererParams: {
                    //     detailGridOptions: {
                    //         className: 'detail-grid' // Assign a class to detail grid
                    //     }
                    // },
                    // className: 'master-grid',
                    // getRowId: params => params.data.uniqueid + "",
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
        }); */
}else{ 
    // echo "=>";
    if(strlen($db[1]) > 2){
        // echo "'".$filterString."'"; 
        echo "\nEXEC " . $db[1] . "'" . $filterString . "','" . $table . "'";
        $SPresult = db::getInstance()->db_sp_select($db[1], array('@params','@table'), array("'".$filterString."'","'".$table."'"));
        echo "\n";
        // print_r($SPresult);
    }
}

$sql = 'select * from kreport_template_data where ID = ' . $TemplateID; // . '; --AND '; 
$results = db::getInstanceMaster()->db_select($sql);
// print_r($results);
$ReportJson = $results['result_set'][0]['ReportJson'] ?? '';
$template = json_decode($ReportJson, true); 
$templateName = $results['result_set'][0]['TemplateName'] ?? '';

// Clean up unused node
unset($template['rowGroupExpansion']);

// Build grouped + grand total SQL
$queries = buildSqlFromAgGridTemplate($template, $table);
// print_r($queries); 
echo "-- Main Query:\n" . $queries['grouped'] . "\n"; 
echo "\n-- Grand Total Query:\n" . $queries['grand'] . "\n";

// 1️⃣ Fetch main rows
$rows_result = db::getInstance()->db_select($queries['grouped']);
$rows = $rows_result['result_set'] ?? [];

// 2️⃣ Fetch grand total (if any columns exist)
$grand_total_row = [];
if (!empty($queries['grand'])) {
    $total_result = db::getInstance()->db_select($queries['grand']);
    $grand_total_row = $total_result['result_set'][0] ?? []; 
}

// 3️⃣ Merge grand total row into main rows
if ($grand_total_row) {
    $grand_total_row_display = $grand_total_row;
    $grand_total_row_display['monthname'] = 'Grand Total'; // Or any label
    $rows[] = $grand_total_row_display;
}

$report_name = $viewReportSettings[1];
$sql = $queries['grouped'];
$results = db::getInstance()->db_select($sql);
$rows = $results['result_set'] ?? [];

// 3️⃣ Load TCPDF
/*require_once('tcpdf/tcpdf.php'); // adjust path

class MyCustomPDF extends TCPDF {
    // Dynamic header/footer content
    public $headerLeft = '';
    public $headerRight = '';
    public $footerLeft = '';
    public $footerRight = '';
    public $headerLineHeight = 2; // space after line

    // Header
    public function Header() {
        $this->SetFont('helvetica', 'I', 10);

        // Calculate page width dynamically
        $pageWidth = $this->getPageWidth() - $this->lMargin - $this->rMargin;

        // Header left
        $this->SetY(10); // starting 10mm from top
        $this->Cell($pageWidth / 2, 6, $this->headerLeft, 0, 0, 'L');

        // Header right
        $this->SetFont('helvetica', '', 10);
        $this->Cell($pageWidth / 2, 6, $this->headerRight, 0, 1, 'R');

        // Draw a full-width line below header
        $y = $this->GetY() + 2; // slightly below text
        $this->Line($this->lMargin, $y, $this->getPageWidth() - $this->rMargin, $y);

        // Adjust Y for spacing after line
        $this->SetY($y + $this->headerLineHeight);
    }

    // Footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);

        $pageWidth = $this->getPageWidth() - $this->lMargin - $this->rMargin;

        // Footer left
        $this->Cell($pageWidth / 2, 10, $this->footerLeft, 0, 0, 'L');

        // Footer right: page number
        $this->Cell($pageWidth / 2, 10, $this->footerRight ?: 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'R');
    }
}

// 4️⃣ Create new PDF document 
// $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$orientation = 'L'; // 'P' = portrait, 'L' = landscape
$pdf = new MyCustomPDF($orientation, 'mm', 'A4', true, 'UTF-8', false);

// Set dynamic header variables
// $pdf->reportTitle = "Report1: $report_name";
// $pdf->generatedBy = "ERP2 System";

$pdf->headerLeft  = "$report_name";             // Left header
$pdf->headerRight = "";                         // Right header 
$pdf->footerLeft  = "Report auto-generated from AI enabled MindForge-ERP at - " . date("jS F Y h:i:s A");                   // Left footer
$pdf->footerRight = "";                         // Right footer (optional, can be page number)

// Set document info 
$pdf->SetCreator('MyERP');
$pdf->SetAuthor('ERP1 System');
$pdf->SetTitle("$report_name - $templateName");
$pdf->SetMargins(10, 20, 10); // top margin increased for header
$pdf->SetAutoPageBreak(TRUE, 20); // bottom margin for footer
$pdf->AddPage();

// 5️⃣ Add Title
$pdf->SetFont('helvetica', 'B', 15);
$pdf->Cell(0, 2, "$report_name", 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 2, "($templateName)", 0, 1, 'C');

// 6️⃣ Add a table header
$pdf->SetFont('helvetica', 'B', 12);

$columns = array_keys($rows[0] ?? []); // get columns dynamically

foreach ($columns as $col) {
    $pdf->Cell(30, 7, ucfirst($col), 1, 0, 'C');
}
$pdf->Ln();

// 7️⃣ Add table data
$pdf->SetFont('helvetica', '', 11);
foreach ($rows as $row) {
    foreach ($columns as $col) {
        $value = $row[$col] ?? '';

        // Convert DateTime objects to string
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d H:i:s'); // adjust format as needed
        }

        // Optional: convert numeric strings to formatted numbers
        if (is_numeric($value)) {
            $value = number_format($value, 2);
            $align = 'R';
        } else {
            $align = 'C';
        }

        $pdf->Cell(30, 6, $value, 1, 0, $align);
    }
    $pdf->Ln();
}


// 8️⃣ Save PDF to disk
$output_dir = "V:\\xampp\\htdocs\\tex\\reports\\pdf\\";
// $output_dir = "V:\\xampp\\htdocs\\tex\\reports\\";
if (!file_exists($output_dir)) {
    mkdir($output_dir, 0777, true);
}

$file_path = $output_dir . "MF_AutoReport{$task_id}_" . date('Ymd_His') . ".pdf";
$pdf->Output($file_path, 'F'); // 'F' = save to file

echo "\nPDF report generated successfully: $file_path\n";
// exit;
*/
require_once('tcpdf/tcpdf.php');

// ----------------- Custom PDF Class -----------------
class MyCustomPDF extends TCPDF {
    public $headerLeft = '';
    public $headerRight = '';
    public $footerLeft = '';
    public $footerRight = '';

    public function Header() {
        $this->SetFont('helvetica', 'B', 10);
        // $margins = $this->getMargins();
        // $pageWidth = $this->getPageWidth() - $margins['left'] - $margins['right'];

        // // Print header text
        // $this->Cell($pageWidth / 2, 8, $this->headerLeft, 0, 0, 'L');
        // $this->Cell($pageWidth / 2, 8, $this->headerRight, 0, 1, 'R');

        // Draw line below header
        // $y = $this->GetY() + 2;
        // $this->Line($margins['left'], $y, $this->getPageWidth() - $margins['right'], $y);

        // Add spacing below line
        // $this->Ln(4);
    }

    // public function Footer() {
    //     $this->SetY(-15);
    //     $this->SetFont('helvetica', 'I', 8);
    //     $margins = $this->getMargins();
    //     $pageWidth = $this->getPageWidth() - $margins['left'] - $margins['right'];
    //     $this->Cell($pageWidth/2, 10, $this->footerLeft, 0, 0, 'L');
    //     $this->Cell($pageWidth/2, 10,
    //         $this->footerRight ?: 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),
    //         0, 0, 'R'
    //     );
    // }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', '', 8);
        $margins = $this->getMargins();
        $pageWidth = $this->getPageWidth() - $margins['left'] - $margins['right'];

        // Left text
        $this->Cell($pageWidth / 2, 10, $this->footerLeft, 0, 0, 'L');

        // Right side text + page numbers
        $rightText = $this->footerRight . " | Page " . $this->getAliasNumPage() . " / " . $this->getAliasNbPages();
        $this->Cell($pageWidth / 2, 10, $rightText, 0, 0, 'R');
    }
}

if(1){ //PDF initial code
    // ----------------- Initialize PDF -----------------
    $orientation = 'L'; // 'P' = portrait, 'L' = landscape
    $pdf = new MyCustomPDF($orientation, 'mm', 'A4', true, 'UTF-8', false);

    // Example report info
    $report_name = "{$_SESSION['ReportName']}";
    // $templateName = "Template XYZ";
    // $task_id = 123;

    // Dynamic header/footer
    // $pdf->headerLeft = $report_name;
    // $pdf->headerRight = "";
    $pdf->footerLeft = "";
    $pdf->footerRight = "Report generated from AI MindForge-ERP at - ".date("jS F Y h:i:s A");

    // ----------------- Document meta info -----------------
    $pdf->SetCreator('MindForge-ERP');
    $pdf->SetAuthor('MindForge System');
    $pdf->SetTitle("{$_SESSION['dbCompanyName']} - {$report_name}");

    // ----------------- Page and Margin setup -----------------
    $pdf->setPrintHeader(false);   // 🚫 Disable reserved TCPDF header area
    $pdf->setPrintFooter(true);    // ✅ Keep footer
    $pdf->SetMargins(10, 10, 10);  // reduce top margin from 25 → 10
    $pdf->SetAutoPageBreak(TRUE, 20);
    $pdf->AddPage();

    // ----------------- Report Title Section -----------------
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 8, $_SESSION['dbCompanyName'], 0, 1, 'C'); // Company name centered

    $pdf->SetFont('helvetica', '', 12);
    $titleText = $report_name;
    if (!empty($templateName)) {
        $titleText .= " ({$templateName})";
    }
    $pdf->Cell(0, 7, $titleText, 0, 1, 'C'); // Report name + template

    // ✅ Add filters line
    if (!empty($_SESSION['filters'])) {
        $pdf->SetFont('helvetica', '', 10); // smaller regular font
        // $pdf->SetTextColor(80, 80, 80);     // subtle gray color
        $pdf->Cell(0, 6, $_SESSION['filters'], 0, 1, 'C');
        // $pdf->SetTextColor(0, 0, 0);        // reset to black
    }

    $pdf->Ln(5);

    // ----------------- Table Data Setup -----------------
    $rows = $rows ?? []; // AG Grid output
    $columns = array_keys($rows[0] ?? []);

    // ----------------- Calculate Dynamic Column Widths -----------------
    $pdf->SetFont('helvetica', '', 11);
    $cellWidths = [];
    $pageWidth = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right'];
    $totalWidth = 0;
}

foreach ($columns as $col) {
    $maxWidth = $pdf->GetStringWidth(ucwords(str_replace('_',' ',$col))) + 6; // header
    foreach ($rows as $row) {
        $value = $row[$col] ?? '';
        if ($value instanceof DateTime) $value = $value->format('Y-m-d H:i:s');
        elseif (is_array($value)) $value = implode(', ', $value);
        elseif (is_object($value)) $value = json_encode($value);
        $w = $pdf->GetStringWidth((string)$value) + 6;
        if ($w > $maxWidth) $maxWidth = $w;
    }
    $cellWidths[$col] = $maxWidth;
    $totalWidth += $maxWidth;
}

// Scale down if table wider than page
if ($totalWidth > $pageWidth) {
    $scale = $pageWidth / $totalWidth;
    foreach ($cellWidths as $col => $w) $cellWidths[$col] = $w * $scale;
}

// ----------------- Function to Draw Table Header -----------------
function drawTableHeader($pdf, $columns, $cellWidths) {
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetFillColor(220,220,220);
    foreach ($columns as $col) {
        $pdf->Cell($cellWidths[$col], 7, ucwords(str_replace('_',' ',$col)), 1, 0, 'C', 1);
    }
    $pdf->Ln();
}

// Draw header for the first page
drawTableHeader($pdf, $columns, $cellWidths);

// ----------------- Render Table Body -----------------
$pdf->SetFont('helvetica', '', 11);

foreach ($rows as $row) {
    $maxHeight = 6; // default row height

    // Step 1: Calculate max height for this row
    foreach ($columns as $col) {
        $value = (string)($row[$col] ?? '');
        $h = $pdf->getStringHeight($cellWidths[$col], $value);
        if ($h > $maxHeight) $maxHeight = $h;
    }

    // Step 2: Remember starting X and Y before printing row
    $x = $pdf->GetX();
    $y = $pdf->GetY();

    // Step 3: Print all columns in the same row
    foreach ($columns as $col) {
        $value = (string)($row[$col] ?? '');
        $align = is_numeric(str_replace(',', '', $value)) ? 'R' : 'L';
        $pdf->MultiCell(
            $cellWidths[$col],
            $maxHeight,
            $value,
            1,       // border
            $align,  // alignment
            false,   // fill
            0,       // ln=0 (stay in same row)
            '',      // x
            '',      // y
            true,    // reset height
            0,       // stretch
            false,   // ishtml
            true,    // autopadding
            $maxHeight,
            'M'      // vertical align middle
        );
    }

    // Step 4: Move cursor to next line
    $pdf->Ln($maxHeight);

    // Step 5: Page break check
    if ($pdf->GetY() > $pdf->getPageHeight() - 20) {
        $pdf->AddPage();
        drawTableHeader($pdf, $columns, $cellWidths);
    }
}


// ----------------- Save PDF -----------------
$output_dir = "V:\\xampp\\htdocs\\tex\\reports\\pdf\\";
if (!file_exists($output_dir)) mkdir($output_dir, 0777, true);

$file_path = $output_dir . "MF_AutoReport_{$task_id}_" . date('Ymd_His') . ".pdf";
$pdf->Output($file_path, 'F');

echo "\nPDF report generated successfully: $file_path\n";
exit();



$pdfPath = $file_path;
if(1){
    // Validate file
    if (!file_exists($pdfPath)) {
        http_response_code(400);
        exit("File not found: {$pdfPath}");
    }
    //GET USER DETAILS FOR TELEGRAM:
    echo $sql = "Select TelegramID, Name from Map_ReportSchedule_Users LEFT JOIN users on UserID = ID where TelegramID IS NOT NULL AND Channel=1 AND ReportScheduleID = " . $task_id;
    $result = db::getInstanceMaster()->db_select($sql);
    // print_r($result);
    if($result['num_rows'] > 0){   
        
        $botToken = TELEGRAM_TOKEN;
        // $chatId = 352356680; //RM
        // $chatId = 416265626; //MS

        $caption  = "Here is your report 📄";
        $parseMode = 'HTML'; // or 'MarkdownV2' or leave empty

        $apiUrl = "https://api.telegram.org/bot{$botToken}/sendDocument";
        for($i = 0; $i < $result['num_rows']; $i++){
            $row = $result['result_set'][$i];
            $chatId = $row['TelegramID'];
            if(strlen($chatId) == 0) continue;
            // Build POST fields
            $postFields = [
                'chat_id'    => $chatId,
                'caption'    => $caption,
                'document'   => new CURLFile($pdfPath, 'application/pdf', basename($pdfPath)),
                // 'disable_content_type_detection' => true, // uncomment if Telegram guesses type wrongly
            ];
            if (!empty($parseMode)) {
                $postFields['parse_mode'] = $parseMode;
            }
            echo "\nsending report to " . $row['Name'];
            // cURL request
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $apiUrl,
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS     => $postFields,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT        => 60,
            ]);
            $response = curl_exec($ch);

            if ($response === false) {
                $err = curl_error($ch);
                curl_close($ch);
                http_response_code(500);
                exit("cURL error: {$err}");
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Decode Telegram response
            $decoded = json_decode($response, true);
            if ($httpCode === 200 && isset($decoded['ok']) && $decoded['ok'] === true) {
                echo "✅ Sent! File message_id: " . $decoded['result']['message_id'];
            } else {
                // Show Telegram error for easier debugging
                echo "❌ Telegram API error ({$httpCode}): " . $response;
            }
        }
    }

    //GET USER DETAILS FOR EMAIL:
    $sql = "Select EmailID, Name from Map_ReportSchedule_Users LEFT JOIN users on UserID = ID where LEN(EmailID)>5 AND Channel=2 AND ReportScheduleID = " . $task_id;
    $result = db::getInstanceMaster()->db_select($sql);
    // print_r($result);
    if($result['num_rows'] > 0){   
        
        $To          = 'ai.mindforgeerp@gmail.com;miteshsonigra7@gmail.com';
        $Subject     = 'Mindforge Auto-report - ' . $report_name ;
        $Body        = '<p>Please find attached.<br />'.$report_name .' - '. $templateName.'</p>';
        $IsHtml      = 1;
        $Attachments = $pdfPath;
        $Importance  = 'High';
    
        for($i = 0; $i < $result['num_rows']; $i++){
            $row = $result['result_set'][$i];
            $To = $row['EmailID'];
            // if(strlen($chatId) == 0) continue;
            // $To = 'miteshrocks007@gmail.com';
            $data['params'] = ['@To','@Subject','@Body','@IsHtml','@Attachments','@Importance'];
            $sp['values'] = ["'" . $To ."'","'". $Subject ."'","'". $Body ."'","'". $IsHtml ."'","'". $Attachments ."'","'". $Importance ."'"];
            $result = db::getInstanceMaster()->db_sp_select('sp_SendEmail_Mindforge', $data['params'], $sp['values']); 
            // print_r($result);
            // exit;
            // Decode Telegram response 
            // $decoded = json_decode($response, true);
            // if ($httpCode === 200 && isset($decoded['ok']) && $decoded['ok'] === true) {
            //     echo "✅ Sent! File message_id: " . $decoded['result']['message_id'];
            // } else {
            //     // Show Telegram error for easier debugging
            //     echo "❌ Telegram API error ({$httpCode}): " . $response;
            // }
        }
    }
}

//REMOVE ALL SESSION VARS

function buildSqlFromAgGridTemplate(array $template, string $table): array {
    echo "<pre>";
    print_r($template);
    // Core pieces from template
    $groupCols      = $template['rowGroup']['groupColIds']     ?? [];
    $aggregations   = $template['aggregation']['aggregationModel'] ?? [];
    $filters        = $template['filter']['filterModel']       ?? [];
    $pivotMode      = $template['pivot']['pivotMode']          ?? false;
    $pivotCols      = $template['pivot']['pivotColIds']        ?? [];
    $checkboxState  = $template['checkboxState']               ?? [];

    $where       = [];
    $pivotValues = [];

    /* ---------------------------------------------------
       1️⃣ Handle advancedFilterModel (join-based filters)
       --------------------------------------------------- */
    if (!empty($template['filter']['advancedFilterModel'])) {
        $adv = $template['filter']['advancedFilterModel'];
            print_r($adv);
        if (($adv['filterType'] ?? '') === 'join' && !empty($adv['conditions'])) {
            $logic   = strtoupper($adv['type'] ?? 'AND'); // AND / OR
            $clauses = [];

            foreach ($adv['conditions'] as $cond) {
                $col        = $cond['colId']      ?? '';
                $type       = strtolower($cond['type'] ?? '');
                $filterType = strtolower($cond['filterType'] ?? '');
                $val        = $cond['filter']     ?? '';

                if ($col === '') continue;

                // 🔹 Text filters
                if ($filterType === 'text') {
                    switch ($type) {
                        case 'contains':
                            $clauses[] = "[$col] LIKE '%" . addslashes($val) . "%'";
                            break;
                        case 'notcontains':
                            $clauses[] = "[$col] NOT LIKE '%" . addslashes($val) . "%'";
                            break;
                        case 'equals':
                            $clauses[] = "[$col] = '" . addslashes($val) . "'";
                            break;
                        case 'notequals':
                            $clauses[] = "[$col] <> '" . addslashes($val) . "'";
                            break;
                        case 'blank':
                            $clauses[] = "([$col] IS NULL OR LTRIM(RTRIM([$col])) = '')";
                            break;
                        case 'notblank':
                            $clauses[] = "([$col] IS NOT NULL AND LTRIM(RTRIM([$col])) <> '')";
                            break;
                    }
                }

                // 🔹 Number filters
                elseif ($filterType === 'number') {
                    if ($val === '' && $val !== 0 && $val !== '0') continue;
                    switch ($type) {
                        case 'equals':
                            $clauses[] = "[$col] = $val";
                            break;
                        case 'notequals':
                            $clauses[] = "[$col] <> $val";
                            break;
                        case 'greaterthan':
                            $clauses[] = "[$col] > $val";
                            break;
                        case 'greaterthanorequal':
                            $clauses[] = "[$col] >= $val";
                            break;
                        case 'lessthan':
                            $clauses[] = "[$col] < $val";
                            break;
                        case 'lessthanorequal':
                            $clauses[] = "[$col] <= $val";
                            break;
                    }
                }
            }

            if (!empty($clauses)) {
                $where[] = '(' . implode(" $logic ", $clauses) . ')';
            }
        }
    }

    // ✅ Process filters into WHERE clause and pivot values
    foreach ($filters as $col => $filter) {
        $filterType = strtolower($filter['filterType'] ?? '');

        switch ($filterType) {

            /* -------------------------------------------------
            MULTI FILTER (can be SET or TEXT with conditions)
            ------------------------------------------------- */
            case 'multi':
                if (!empty($filter['filterModels']) && is_array($filter['filterModels'])) {
                    foreach ($filter['filterModels'] as $model) {
                        if (empty($model) || !is_array($model)) continue;

                        $mFilterType = strtolower($model['filterType'] ?? '');

                        // 1️⃣ Old-style SET filter: { filterType: 'set', values: [...] }
                        if ($mFilterType === 'set' && !empty($model['values'])) {
                            $vals = array_map(
                                fn($v) => "'" . addslashes($v) . "'",
                                $model['values']
                            );
                            $where[] = "[$col] IN (" . implode(", ", $vals) . ")";
                            if (in_array($col, $pivotCols)) {
                                $pivotValues = array_merge($pivotValues, $model['values']);
                            }
                        }

                        // 2️⃣ New text multi filter with conditions[] + operator
                        elseif ($mFilterType === 'text' && !empty($model['conditions'])) {
                            $op  = strtoupper($model['operator'] ?? 'AND'); // AND/OR
                            $sub = [];

                            foreach ($model['conditions'] as $cond) {
                                if (empty($cond) || !is_array($cond)) continue;
                                $cType   = strtolower($cond['type']   ?? '');
                                $cVal    = $cond['filter'] ?? '';

                                switch ($cType) {
                                    case 'contains':
                                        $sub[] = "[$col] LIKE '%" . addslashes($cVal) . "%'";
                                        break;
                                    case 'notcontains':
                                        $sub[] = "[$col] NOT LIKE '%" . addslashes($cVal) . "%'";
                                        break;
                                    case 'equals':
                                        $sub[] = "[$col] = '" . addslashes($cVal) . "'";
                                        break;
                                    case 'notequals':
                                        $sub[] = "[$col] <> '" . addslashes($cVal) . "'";
                                        break;
                                    case 'blank':
                                        $sub[] = "([$col] IS NULL OR LTRIM(RTRIM([$col])) = '')";
                                        break;
                                    case 'notblank':
                                        $sub[] = "([$col] IS NOT NULL AND LTRIM(RTRIM([$col])) <> '')";
                                        break;
                                }
                            }

                            if (!empty($sub)) {
                                $where[] = '(' . implode(" $op ", $sub) . ')';
                            }
                        }

                        // 3️⃣ Simple text multi filter without conditions (like Control: contains 'debtor')
                        elseif ($mFilterType === 'text') {
                            $tType = strtolower($model['type']   ?? '');
                            $tVal  = $model['filter'] ?? '';

                            switch ($tType) {
                                case 'contains':
                                    $where[] = "[$col] LIKE '%" . addslashes($tVal) . "%'";
                                    break;
                                case 'notcontains':
                                    $where[] = "[$col] NOT LIKE '%" . addslashes($tVal) . "%'";
                                    break;
                                case 'equals':
                                    $where[] = "[$col] = '" . addslashes($tVal) . "'";
                                    break;
                                case 'notequals':
                                    $where[] = "[$col] <> '" . addslashes($tVal) . "'";
                                    break;
                                case 'blank':
                                    $where[] = "([$col] IS NULL OR LTRIM(RTRIM([$col])) = '')";
                                    break;
                                case 'notblank':
                                    $where[] = "([$col] IS NOT NULL AND LTRIM(RTRIM([$col])) <> '')";
                                    break;
                            }
                        }
                    }
                }
                break;

            /* -------------------------------------------------
            NUMBER FILTER (simple types + inRange)
            ------------------------------------------------- */
            case 'number':
                $t  = strtolower($filter['type'] ?? '');
                $fv = $filter['filter']    ?? null;
                $ft = $filter['filterTo']  ?? null;

                if ($t === 'inrange' && $fv !== null && $ft !== null) {
                    $where[] = "[$col] BETWEEN $fv AND $ft";
                } else {
                    switch ($t) {
                        case 'equals':
                            $where[] = "[$col] = $fv";
                            break;
                        case 'notequals':
                            $where[] = "[$col] <> $fv";
                            break;
                        case 'greaterthan':
                            $where[] = "[$col] > $fv";
                            break;
                        case 'greaterthanorequal':
                            $where[] = "[$col] >= $fv";
                            break;
                        case 'lessthan':
                            $where[] = "[$col] < $fv";
                            break;
                        case 'lessthanorequal':
                            $where[] = "[$col] <= $fv";
                            break;
                    }
                }
                break;

            /* -------------------------------------------------
            DATE FILTER (blank / notBlank etc.)
            ------------------------------------------------- */
            case 'date':
                $t = strtolower($filter['type'] ?? '');

                switch ($t) {
                    case 'blank':
                        // assuming CLEARDT is NULL when blank
                        $where[] = "[$col] IS NULL";
                        break;
                    case 'notblank':
                        $where[] = "[$col] IS NOT NULL";
                        break;

                    // If you later use date equals / ranges, you can add here:
                    // case 'equals':
                    //     $d = $filter['dateFrom'] ?? '';
                    //     if ($d !== '') $where[] = "CONVERT(date, [$col]) = CONVERT(date, '$d')";
                    //     break;
                }
                break;
        }
    }


    /* ---------------------------------------------------
       3️⃣ WHERE clause build
       --------------------------------------------------- */
    $whereClause   = $where ? implode(' AND ', $where) : '1=1';
    $groupBy       = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrouped = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrand   = [];

    /* ---------------------------------------------------
       4️⃣ Pivot support (unchanged)
       --------------------------------------------------- */
    if ($pivotMode && $pivotCols) {
        $pivotCol = $pivotCols[0];
        if (empty($pivotValues)) {
            $sql = "SELECT DISTINCT [$pivotCol] FROM [$table] WHERE $whereClause";
            $res = db::getInstance()->db_select($sql);
            foreach ($res['result_set'] ?? [] as $row) {
                $pivotValues[] = $row[$pivotCol];
            }
        }
    }

    /* ---------------------------------------------------
       5️⃣ Aggregations (your existing logic)
       --------------------------------------------------- */
    if ($pivotMode && $pivotCols && $pivotValues) {
        foreach ($pivotValues as $val) {
            foreach ($aggregations as $agg) {
                $field    = $agg['colId'];
                $func     = strtoupper($agg['aggFunc']);
                $pivotCol = $pivotCols[0];
                $label    = ucwords($val) . " / " . ucfirst($func) . "(" . ucwords(str_replace('_', ' ', $field)) . ")";
                $selectGrouped[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS [$label]";
            }
        }

        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func  = strtoupper($agg['aggFunc']);
            foreach ($pivotValues as $val) {
                $selectGrouped[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS 'total_{$val}_{$field}'";
            }
            $selectGrand[] = "$func([$field]) AS 'total_{$field}'";
        }
    } else {
        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func  = strtoupper($agg['aggFunc']);
            $selectGrouped[] = "$func([$field]) AS total_{$field}";
            $selectGrand[]   = "$func([$field]) AS total_{$field}";
        }
    }

    /* ---------------------------------------------------
       6️⃣ Safety: if no groups & no aggregations → SELECT *
       --------------------------------------------------- */
    if (empty($selectGrouped)) {
        // No groupCols, no aggregations: just return raw rows with filters applied
        $selectGrouped[] = '*';
    }

    /* ---------------------------------------------------
       7️⃣ Build final queries
       --------------------------------------------------- */
    $queries = [];

    // Main grouped/detail query
    $queries['grouped'] =
        "SELECT " . implode(", ", $selectGrouped) .
        "\nFROM [$table]\nWHERE $whereClause\n" .
        ($groupBy ? "GROUP BY " . implode(', ', $groupBy) : '');

    // Grand total query (only if we have aggregates)
    if (!empty($selectGrand)) {
        $queries['grand'] =
            "SELECT " . implode(", ", $selectGrand) .
            "\nFROM [$table]\nWHERE $whereClause";
    } else {
        $queries['grand'] = '';   // so your caller's `if (!empty($queries['grand']))` works
    }

    return $queries;
}


function buildSqlFromAgGridTemplate1(array $template, string $table): array {
    // print_r($template); echo $table;
    // exit;
    $groupCols = $template['rowGroup']['groupColIds'] ?? [];
    $aggregations = $template['aggregation']['aggregationModel'] ?? [];
    $filters = $template['filter']['filterModel'] ?? [];
    $pivotMode = $template['pivot']['pivotMode'] ?? false;
    $pivotCols = $template['pivot']['pivotColIds'] ?? [];
    $checkboxState = $template['checkboxState'] ?? [];

    $where = []; 
    $pivotValues = [];

    // Process filters into WHERE clause and pivot values
    foreach ($filters as $col => $filter) {
        switch ($filter['filterType']) {
            case 'multi':
                foreach ($filter['filterModels'] as $model) {
                    if ($model && $model['filterType'] === 'set') {
                        $vals = array_map(fn($v) => "'" . addslashes($v) . "'", $model['values']);
                        $where[] = "[$col] IN (" . implode(", ", $vals) . ")";
                        if (in_array($col, $pivotCols)) {
                            $pivotValues = array_merge($pivotValues, $model['values']);
                        }
                    }
                }
                break;
            case 'number':
                if ($filter['type'] === 'inRange') {
                    $where[] = "[$col] BETWEEN {$filter['filter']} AND {$filter['filterTo']}";
                } elseif ($filter['operator'] === 'AND') {
                    foreach ($filter['conditions'] as $cond) {
                        $type = $cond['type'];
                        $val = $cond['filter']; 
                        if ($type === 'greaterThan') $where[] = "[$col] > $val";
                        if ($type === 'lessThan') $where[] = "[$col] < $val";
                    }
                }
                break;
        }
    }

    $whereClause = $where ? implode(' AND ', $where) : '1=1';
    $groupBy = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrouped = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrand = [];

    // ✅ Fallback to dynamic pivot value fetch if pivot values are empty
    if ($pivotMode && $pivotCols) {
        $pivotCol = $pivotCols[0];
        if (empty($pivotValues)) {
            $sql = "SELECT DISTINCT [$pivotCol] FROM [$table] WHERE $whereClause";
            $res = db::getInstance()->db_select($sql);
            for ($j = 0; $j < sizeof($res['result_set']); $j++) {
                $pivotValues[] = $res['result_set'][$j][$pivotCol];
            } 
        }
    }

    // ➕ Build SELECT expressions for pivot columns and column-wise totals
    if ($pivotMode && $pivotCols && $pivotValues) {
        foreach ($pivotValues as $val) {
            foreach ($aggregations as $agg) {
                $field = $agg['colId'];
                $func = strtoupper($agg['aggFunc']);
                $pivotCol = $pivotCols[0];
                $label = ucwords($val) . " / " . ucfirst($func) . "(" . ucwords(str_replace('_', ' ', $field)) . ")";
                $selectGrouped[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS [$label]";
            }
        }

        // Add column-wise totals for pivot columns (summing across pivoted values)
        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func = strtoupper($agg['aggFunc']);
            // Column-wise total for the pivoted columns
            foreach ($pivotValues as $val) {
                $selectGrouped[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS 'total_{$val}_{$field}'";
            }
            $selectGrand[] = "$func([$field]) AS 'total_{$field}'";
        }
    } else {
        // If no pivot columns or pivot values, default to aggregating by group columns
        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func = strtoupper($agg['aggFunc']);
            $selectGrouped[] = "$func([$field]) AS total_{$field}";
            $selectGrand[] = "$func([$field]) AS total_{$field}";
        }
    }

    $queries = [];
  
    // Main grouped query
    $queries['grouped'] = "SELECT " . implode(", ", $selectGrouped) . "\nFROM [$table]\nWHERE $whereClause\n" . 
                          ($groupBy ? "GROUP BY " . implode(', ', $groupBy) : '');

    // Subtotals for row group levels (based on checkboxState)
    $queries['subtotals'] = [];
    foreach ($checkboxState as [$col, $include]) {
        if ($include) {
            $level = array_search($col, $groupCols);
            if ($level !== false && $level >= 0) {
                $partialGroup = array_slice($groupCols, 0, $level + 1);
                $selectPartial = array_map(fn($g) => "[$g]", $partialGroup);

                if ($pivotMode && $pivotCols && $pivotValues) {
                    foreach ($pivotValues as $val) {
                        foreach ($aggregations as $agg) {
                            $field = $agg['colId'];
                            $func = strtoupper($agg['aggFunc']);
                            $pivotCol = $pivotCols[0];
                            $label = ucwords($val) . " / " . ucfirst($func) . "(" . ucwords(str_replace('_', ' ', $field)) . ")";
                            $selectPartial[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS [$label]";
                        }
                    }
                    foreach ($aggregations as $agg) {
                        $field = $agg['colId']; 
                        $func = strtoupper($agg['aggFunc']);
                        $selectPartial[] = "$func([$field]) AS 'total_{$field}'";
                    }
                } else { 
                    foreach ($aggregations as $agg) {
                        $field = $agg['colId'];
                        $func = strtoupper($agg['aggFunc']);
                        $selectPartial[] = "$func([$field]) AS 'total_{$field}'";
                    }
                }

                $queries['subtotals'][$col] = "SELECT " . implode(", ", $selectPartial) . "\nFROM [$table]\nWHERE $whereClause\n" . 
                                              "GROUP BY " . implode(", ", array_map(fn($g) => "[$g]", $partialGroup));
            }
        }
    }

    // Grand total query
    $queries['grand'] = "SELECT " . implode(", ", $selectGrand) . "\nFROM [$table]\nWHERE $whereClause";

    return $queries;
}
?>
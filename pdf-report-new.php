<?php
include_once('dbClass.php');
require __DIR__ . '/vendor/autoload.php';
session_start();

use Mpdf\Mpdf;
use Twig\Loader\ArrayLoader;
use Twig\Environment;

try {
    // 1️⃣ Input parameters
    $templateId = $_GET['templateId'] ?? null;
    $recordId   = $_GET['id'] ?? null;

    if (!$templateId) {
        throw new Exception("TemplateID is required (e.g. ?templateId=4741&id=123)");
    }

    // 2️⃣ Fetch template configuration from DB
    $sql = "SELECT TOP 1 ID AS TemplateID,TemplateName,ReportType,HtmlTemplate,PageSize,Orientation FROM kReport_PDF_Templates_New
        WHERE ID = {$templateId}";

    $result = db::getInstanceMaster()->db_select($sql);
    if (empty($result['result_set'])) {
        throw new Exception("No template found for TemplateID {$templateId}");
    } 
    // print_r($result); exit;
    $templateRow = $result['result_set'][0];
    $spName      = $templateRow['StoredProcedure'] ?? 'sp_NewPdfReport_' . $templateId;
    $pageSize    = $templateRow['PageSize'] ?? 'A4';
    $orientation = $templateRow['Orientation'] ?? 'P';
    $reportType  = $templateRow['ReportType'] ?? 'Generic';
    $htmlSource  = $templateRow['HtmlTemplate'] ?? '';
    $htmlPath    = $templateRow['HtmlTemplatePath'] ?? '';
    // $htmlPath = 'invoice.html';
    // Load from file if path given
    if (empty($htmlSource) && !empty($htmlPath)) {
        $filePath = __DIR__ . '/pdf-report-templates/' . $htmlPath;
        if (file_exists($filePath)) {
            $htmlSource = file_get_contents($filePath);
        } else {
            throw new Exception("Template file not found: {$htmlPath}");
        }
    }
    if (empty($htmlSource)) {
        throw new Exception("No HTML template content found for TemplateID {$templateId}");
    }

    // 3️⃣ Call SP defined in template (must follow standard output pattern)
    // if (empty($spName)) {
    //     throw new Exception("StoredProcedure not defined for TemplateID {$templateId}");
    // }

    function convertSerializedToArray($var){
        $data = explode("&",$var);
        // print_r($data );
        $result = array();
        // echo json_encode($data);
        for($i=0; $i<count($data); $i++){
            $tmp = explode("=", $data[$i]);
            if(strlen($tmp[1])>0){  //removing blanks
                if($tmp[1] != '0')      //removing 0 vals
                    $result[$tmp[0]] = $tmp[1];
            }
        }
        return $result;
    }

    //CALL SP with params: EntryID, Session, Filters
    $filterData = isset($_GET['filterData']) ? urldecode($_GET['filterData']) : "";
    $filterDataC = convertSerializedToArray($filterData);
    $andFilters = '';
    $separator = '';
    $filterKeys = array_keys($filterDataC);
    for($i = 0; $i < sizeof($filterDataC); $i++){
        $andFilters .= $separator . $filterKeys[$i] . "=" . $filterDataC[$filterKeys[$i]] . "";
        $separator = '|';
    }
    $session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.'';
    // $spName = 'sp_temp_GetReportData'; // . $templateId
    $sp['params'] = ['@EntryID', '@session', '@filters'];
    $sp['values'] = ["'$recordId'","'$session'", "'$andFilters'"]; 

    $spResult = db::getInstanceMaster()->db_sp_select($spName, $sp['params'], $sp['values']);
    
    if (empty($spResult) || empty($spResult['result_set'])) {
        throw new Exception("No data returned from SP {$spName}");
    }

    // 4️⃣ Handle multiple result sets dynamically
    $allSets = $spResult['result_set'];
    $tables  = [];
    $headerData = [];
    $namedTables = [];
    $resultNames = [];

    /**
     * Convention:
     * - 1st result set: may contain field "ResultNames" = comma-separated table names ("Header,Items,HSN")
     * - The rest of the sets follow that order
     */
    if (!empty($allSets[0])) {
        $headerData = $allSets[0][0]; // single-row header
        if (!empty($headerData['ResultNames'])) {
            $resultNames = array_map('trim', explode(',', $headerData['ResultNames']));
            unset($headerData['ResultNames']);
        }
    }

    // Map sets dynamically
    foreach ($allSets as $i => $set) {
        if (empty($set)) continue;
        $name = $resultNames[$i] ?? "Table{$i}";
        $namedTables[$name] = $set;
    }

    // 5️⃣ Prepare Twig data context
    $data = array_merge($headerData, [
        'tables'      => $namedTables,   // all data tables
        'tableCount'  => count($namedTables),
        'ReportType'  => $reportType,
        'TemplateID'  => $templateId,
        'RecordID'    => $recordId,
        'GeneratedOn' => date('Y-m-d H:i:s')
    ]);

    // 6️⃣ Render HTML via Twig
    $loader = new ArrayLoader(['tpl' => $htmlSource]);
    $twig   = new Environment($loader, ['autoescape' => false]);
    $html   = $twig->render('tpl', $data);

    // 7️⃣ Generate PDF using mPDF
    $mpdf = new Mpdf([
        'format'      => $pageSize,
        'orientation' => $orientation,
        'margin_top'  => 10,
        'margin_bottom' => 10
    ]);

    // Optional header/footer
    $mpdf->SetHTMLHeader("<div style='text-align:center;font-weight:bold;'>{$reportType} - Page {PAGENO}/{nbpg}</div>");
    $mpdf->SetHTMLFooter("<div style='text-align:right;font-size:10px;'>Generated: {DATE j-m-Y H:i}</div>");

    $mpdf->WriteHTML($html);
    $mpdf->Output("Report_{$templateId}_{$recordId}.pdf", 'I');
}

catch (Exception $e) {
    echo "<h3 style='color:red;'>Error:</h3><pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
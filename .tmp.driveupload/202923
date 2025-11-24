<?php
include_once('dbClass.php');
session_start();

$data = json_decode(file_get_contents("php://input"), true);

$TemplateID   = $data['TemplateID'] ?? 0;
$templateName = $data['templateName'] ?? '';
$html         = $data['html'] ?? '';
$pageSize     = $data['pageSize'] ?? 'A4';
$orientation  = $data['orientation'] ?? 'P';
$reportType   = $data['reportType'] ?? 'Generic';
$userId       = $_SESSION['user_id'] ?? 0;

if ($TemplateID == 0) {

    // INSERT NEW TEMPLATE
    $sql = "INSERT INTO kReport_PDF_Templates_New (TemplateName, ReportType, HtmlTemplate, PageSize, Orientation, CreatedBy)
            VALUES ($templateName, $reportType, $html, $pageSize, $orientation, $userId)";

    $result = db::getInstanceMaster()->db_insertQuery($sql);

    echo $result['last_id'];

} else {

    // UPDATE TEMPLATE
    $sql = "UPDATE kReport_PDF_Templates_New 
            SET TemplateName = ?, HtmlTemplate = ?, PageSize = ?, Orientation = ?, UpdatedBy = ?
            WHERE ID = ?";

    db::getInstanceMaster()->db_update(
        $sql, [$templateName, $html, $pageSize, $orientation, $userId, $TemplateID]
    );

    echo $TemplateID;
}

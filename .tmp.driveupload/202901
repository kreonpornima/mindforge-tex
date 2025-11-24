<?php
include_once('dbClass.php');
session_start();
$templateId = $_GET['templateId'] ?? 1;

try {
    $sql = "SELECT HtmlTemplate FROM kReport_PDF_Templates_New WHERE ID = " . $templateId;
    $result = db::getInstanceMaster()->db_select($sql);
    echo $result['result_set'][0]['HtmlTemplate'] ?? "<h2>No template found</h2>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// PS C:\Users\Administrator> scp -P 5726 "C:\Program Files\Microsoft SQL Server\MSSQL16.MSSQLSERVER\MSSQL\Backup\main.bak" root@161.248.37.80:/var/opt/mssql/backup/
// root@161.248.37.80's password:
// main.bak                                                                              100% 3876MB   6.2MB/s   10:25
// PS C:\Users\Administrator>
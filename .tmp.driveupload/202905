<?php
include_once('dbClass.php');
session_start();

$templateId = $_GET['templateId'] ?? 0;
$recordId = $_GET['recordId'] ?? 0;

if (!$templateId) {
    echo json_encode([]);
    exit;
}

// 1️⃣ Get Stored Procedure name from template table
$spName = "sp_NewPdfReport_" . $templateId;

// 2️⃣ Prepare SP parameters (dummy testing call)
$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.'';
$andFilters = '';
$spParams = ['@EntryID', '@session', '@filters'];
$spValues = ["'$recordId'","'$session'", "'$andFilters'"]; 

// 3️⃣ Execute SP
$spResult = db::getInstanceMaster()->db_sp_select($spName, $spParams, $spValues);

// No result? Return empty
if (empty($spResult['result_set']) || empty($spResult['result_set'][0])) {
    echo json_encode([]);
    exit;
}

// 4️⃣ First resultset → header fields
$firstRow = $spResult['result_set'][0][0];

// Remove ResultNames if present
if (isset($firstRow['ResultNames'])) {
    unset($firstRow['ResultNames']);
}

// 5️⃣ Extract field names
$variables = array_keys($firstRow);

// 6️⃣ EXTRA: extract loop table names from ResultNames
$loopVars = [];

if (!empty($spResult['result_set'][0][0]['ResultNames'])) {
    $names = explode(',', $spResult['result_set'][0][0]['ResultNames']);

    foreach ($names as $n) {
        $loopVars[] = trim($n);   // eg: Items, HSN, Taxes
    }
}

// Final output
echo json_encode([
    "variables" => $variables,     // header-level variables
    "loops"     => $loopVars       // tables/loops names
]);

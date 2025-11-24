<?php 
require_once ('dbClass.php');
$ReportID = $_REQUEST['ReportID'] ?? 0; 
$TemplateID = $_REQUEST['templateId'] ?? 0; 

$output = array();
$query = "SELECT * from kreport_pdf_templates WHERE ID = " . $TemplateID;
$resultT = db::getInstanceMaster()->db_select($query);
$rowT = $resultT['result_set'];

$query = "SELECT * from kreport_pdf_template_params WHERE TemplateID = " . $TemplateID;
$result = db::getInstanceMaster()->db_select($query);
// print_r($result);
for ($j=0; $j<sizeof($result['result_set']); $j++) {
    if($result['result_set'][$j]['FieldType'] == 5){
        $query1 = "SELECT " . $result['result_set'][$j]['TablePrimary'] . "," . $result['result_set'][$j]['TableLabel'] . " FROM " . $result['result_set'][$j]['TableFromDb'] . " " . $result['result_set'][$j]['TableCondition'];
        $result1 = db::getInstance()->db_select($query1);
        $output[$result['result_set'][$j]['ID']]['result_set'] = $result1['result_set'];
        $output[$result['result_set'][$j]['ID']]['ID'] = $result['result_set'][$j]['TablePrimary'];
        $output[$result['result_set'][$j]['ID']]['Label'] = $result['result_set'][$j]['TableLabel'];
    }
} 
$row = $result['result_set'];


if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}
header('Content-Encoding: gzip');
header('Content-Type: application/json');
echo json_encode(array($row,$output,$rowT));
ob_end_flush();
exit();
 ?>


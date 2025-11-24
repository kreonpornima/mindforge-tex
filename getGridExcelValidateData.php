<?php
require_once ('dbClass.php');

// $spName = isset($_REQUEST['spName']) ? $_REQUEST['spName'] : "";
$gridData = isset($_REQUEST['gridData']) ? $_REQUEST['gridData'] : "";
$GridID = isset($_REQUEST['GridID']) ? $_REQUEST['GridID'] : "";
$FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : "";
$EditID = isset($_REQUEST['EditID']) ? $_REQUEST['EditID'] : "";

//print_r($gridData); exit;
//remove data with empty KEYS
foreach ($gridData as &$row) {
    foreach ($row as $key => $value) {
        // Check if the key is empty
        // echo "=>" . $key;
        if (trim($key) === "" || trim($key) === "0" || trim($key) == '__EMPTY' || preg_match("/^_[0-9]/", trim($key))) {
            unset($row[$key]); // Remove the element with the empty key
        }
    }
}
unset($row); // Break reference to avoid accidental modifications

//get all fields applicable for the grid
$sql1 = "SELECT * FROM kgridfields where GridId=$GridID AND Visibility=1 ORDER BY DisplayOrder";
$sql1result = db::getInstanceMaster()->db_select($sql1);

// $columnCount = sizeof($sql1result);
// $excelColCount = sizeof($gridData[0]);
// $excelRowCount = sizeof($gridData);
// if($columnCount !== $excelColCount){    echo "Error Ex101: Invalid data."; }

//Get SP Name for validation of the import
//sp_ImportGrid_2234
// $sql = "SELECT GridImportSPName FROM kmaingrid where GridId=$GridID";
// $sqlresult = db::getInstanceMaster()->db_select($sql);

$tableName = "tempGridImport_" . $_SESSION['email'] . "_" . $GridID;
$q = "DROP TABLE IF EXISTS " . $tableName . ";";
$q .= " CREATE TABLE " . $tableName . " (";
$sep = '';
$cols = '';
for($i = 0; $i < sizeof($sql1result['result_set']); $i++){
    $q .= $sep . $sql1result['result_set'][$i]['DbFieldName'] . " nvarchar(max) NULL";
    $cols .= $sep . $sql1result['result_set'][$i]['DbFieldName'];
    $sep = ',';
}
$q .= " , ImportValidationResult nvarchar(max) NULL)";
// echo $q; echo "<br />";
$result = db::getInstance()->db_create_table($q);
// print_r($result);

// $spParam = '';
$sep = '';
$query = "INSERT INTO " .  $tableName . " (".$cols.") VALUES "; 
$multiQueries = array();
$multiQueries[0] = $query;
$mqCnt = 0;
for($i = 0; $i < sizeof($gridData); $i++){
    $multiQueries[$mqCnt] .= $sep . "('" . implode("','", $gridData[$i]) . "')";
    $sep = ", ";
    if($i == 999 || $i == 1998 || $i == 2997){
        $sep = '';
        // $mqCnt++;
        $multiQueries[++$mqCnt] = $query;
    }
}

for($i = 0; $i <= $mqCnt; $i++){
    $result = db::getInstance()->db_insertQuery($multiQueries[$i]);
}
// print_r($result);

$sp = [];
$sp['name'] = "sp_ImportGrid_" . $GridID;
// $sp['name'] = $sqlresult['result_set'][0]['GridImportSPName'];
$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND UserId='.$_SESSION['user_id'].' AND FormID='.$FormID.' AND EditID='.$EditID.'';
$sp['params'] = ['@params','@session'];
$sp['values'] = ["'".$tableName."'","'$session'"];
// $sp['values'] = ["'".json_encode($gridData)."'"];
                                                         
$result = db::getInstance()->db_sp_select($sp['name'], $sp['params'], $sp['values']);
// print_r($result);
// exit();
// CHECK ImportValidationResult 
//Output => Success, Msg, Data in the table
// if Success == 0 => Error : Show Msg & Do not proceed
// if Success == 1 => Pass : Proceed
// if Success == 2 => Prompt : Take user confirmation whether to proceed or not by showing the Msg
// if Success == 3 => Don't show data in the grid.
// print_r($result);
if($result['result_set'][0][0]['Success'] == 1 || $result['result_set'][0][0]['Success'] == 2){
    //Get data from temp Table to check for validation 
    $sql = "SELECT * FROM $tableName ORDER BY sno ";
    $sqlresult = db::getInstance()->db_select($sql);
    $arr = array("data" =>  $sql1result['result_set'], "gridData" =>$sqlresult['result_set'], "output" => $result['result_set'][0]);
}else{
    $sql = "SELECT * FROM $tableName ORDER BY sno ";
    $sqlresult = db::getInstance()->db_select($sql);
    $arr = array("data" =>  $sql1result['result_set'], "gridData" =>$sqlresult['result_set'], "output" => $result['result_set'][0]);
}


if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}
header('Content-Encoding: gzip');
header('Content-Type: application/json');
echo json_encode($arr);
ob_end_flush();

exit();
?>
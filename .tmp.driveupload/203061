<?php 
include_once('dbClass.php');

// $ar = json_decode($_POST['excelData']);

$formData = isset($_REQUEST['excelData']) ? json_decode($_REQUEST['excelData']) : "";
$FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : "";

//print_r($formData); exit;
//remove data with empty KEYS
foreach ($formData as &$row) {
    foreach ($row as $key => $value) {
        // Check if the key is empty
        // echo "Key: " . $key . " | Value: " . $value . "<br />"; // Debugging Output
        if (trim($key) === "" || trim($key) === "0" || trim($key) == '__EMPTY' || preg_match("/^_[0-9]/", trim($key))) {
            // unset($row[$key]); // Remove the element with the empty key
            //*******************************
            // REMOVED THE ABOVE LINE AS IT WAS GIVING ISSUE BY OMITING THE FIRST COLUMN IN VALJ MARKETING MASTER - MITESH */
        }
    }
}
// print_r($formData); exit;
unset($row); // Break reference to avoid accidental modifications

//get all fields applicable for the grid
$sql1 = "SELECT * FROM kmainfields where FormId=$FormID AND Visibility=1 AND FieldType <> 14 AND FieldType < 20 ORDER BY DisplayOrder";
$sql1 = "SELECT DbFieldName FROM kmainfields where FormId=$FormID AND Visibility=1 AND FieldType NOT IN (0,12,13,14,20,21,22,24) ORDER BY DisplayOrder";
$sql1 = "SELECT * FROM (
            SELECT TOP 100 PERCENT DbFieldName AS Field 
            FROM kmainfields 
            WHERE FormId = " . $FormID . " AND Visibility = 1 
            AND FieldType NOT IN (0,12,13,14,20,21,22,24) 
            ORDER BY DisplayOrder
        ) AS a
        UNION ALL
        SELECT * FROM (
            SELECT TOP 100 PERCENT CONCAT('G', kgridfields.GridId, '_', DbFieldName) AS Field
            FROM kgridfields 
            LEFT JOIN kmaingrid ON kgridfields.GridId = kmaingrid.GridId 
            WHERE kgridfields.GridId IN (
                SELECT GridId FROM kmainfields WHERE FormId = " . $FormID . " AND FieldType = 14
            )
            AND FieldType NOT IN (0,12,13,14,20,21,22,24) 
            ORDER BY kgridfields.GridId, DisplayOrder
        ) AS b";
$sql1result = db::getInstanceMaster()->db_select($sql1);

// $columnCount = sizeof($sql1result);
// $excelColCount = sizeof($formData[0]);
// $excelRowCount = sizeof($formData);
// if($columnCount !== $excelColCount){    echo "Error Ex101: Invalid data."; }

//Get SP Name for validation of the import
//sp_ImportGrid_2234
// $sql = "SELECT GridImportSPName FROM kmaingrid where FormID=$FormID";
// $sqlresult = db::getInstanceMaster()->db_select($sql);


/* select kgridfields.GridId, CONCAT('G',kgridfields.GridId, '_',DbFieldName) as Field, DisplayName, FieldType, GridTitle 
        from kgridfields 
        left join kmaingrid on kgridfields.GridId = kmaingrid.GridId 
        where 
            kgridfields.GridId IN (SELECT GridId FROM kmainfields WHERE FormId = " . $FormID . " AND FieldType = 14) 
            AND FieldType NOT IN (0,12,13,14,20,21,22,24) 
        order by kgridfields.GridId,DisplayOrder";*/

$tableName = "tempFormImport_" . $_SESSION['email'] . "_" . $FormID;
$q = "DROP TABLE IF EXISTS " . $tableName . ";";
$q .= " CREATE TABLE " . $tableName . " (ExcelRowID int null, ";
$sep = '';
$cols = 'ExcelRowID, ';
for($i = 0; $i < sizeof($sql1result['result_set']); $i++){
    $q .= $sep . $sql1result['result_set'][$i]['Field'] . " nvarchar(max) NULL";
    $cols .= $sep . $sql1result['result_set'][$i]['Field'];
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
for($i = 1; $i < sizeof($formData); $i++){  //CHANGED FROM 0 to 1 as 1st row is giving headers
    // $multiQueries[$mqCnt] .= $sep . "('" . implode("','", $formData[$i]) . "')";
    $escapedData = array_map(fn($item) => str_replace("'", "''", $item), $formData[$i]);
    $multiQueries[$mqCnt] .= $sep . "(".$i.",'" . implode("','", $escapedData) . "')";

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
$sp['name'] = "sp_ImportForm";
// $sp['name'] = $sqlresult['result_set'][0]['GridImportSPName'];
$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND UserId='.$_SESSION['user_id'].' AND FormID='.$FormID.' AND EditID='.$EditID.'';
$sp['params'] = ['@params','@session'];
$sp['values'] = ["'".$tableName."'","'$session'"];
// $sp['values'] = ["'".json_encode($formData)."'"];
                                                         
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
    $sql = "SELECT * FROM $tableName"; // ORDER BY sno removed
    $sqlresult = db::getInstance()->db_select($sql);
    $arr = array("data" =>  $sql1result['result_set'], "formData" =>$sqlresult['result_set'], "output" => $result['result_set'][0]);
}else{
    $sql = "SELECT * FROM $tableName"; // ORDER BY sno removed
    $sqlresult = db::getInstance()->db_select($sql);
    $arr = array("data" =>  $sql1result['result_set'], "formData" =>$sqlresult['result_set'], "output" => $result['result_set'][0]);
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



// echo json_encode($_POST['excelData']);
// echo ($_POST['excelData']);
?>
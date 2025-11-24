<?php
require_once ('dbClass.php');
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
// include 'model.php';

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

// Retrieve the 'start' and 'limit' parameters from the request (for pagination)
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 30;
$EditID = isset($_POST['EditID']) ? (int)$_POST['EditID'] : 0;
$ColumnFilters = isset($_POST['ColumnFilters']) ? $_POST['ColumnFilters'] : '';
$isFilter = 0;

$FilterCondition = '';

if(strlen($ColumnFilters) > 3){
    $ColumnFiltersArray = explode("|",$ColumnFilters);
    for($i=0; $i<count($ColumnFiltersArray); $i++){
        $ColumnFilter = explode(":",$ColumnFiltersArray[$i]);
        $FilterCondition .= " AND ";
        $FilterCondition .= $ColumnFilter[0]." like '%".$ColumnFilter[1]."%'"; 
    }
}
if($EditID == 0)
    $query = "SELECT logs.Mode, logs.field, logs.oldValue, logs.newValue, ISNULL(logs.GridID, '-') AS GridID, users.Name, logs.CreatedAt FROM logs LEFT JOIN users ON users.ID = logs.CreatedBy WHERE logs.FormID=$FormID ORDER BY logs.ID DESC";
else
    $query = "SELECT logs.Mode, logs.field, logs.oldValue, logs.newValue, ISNULL(logs.GridID, '-') AS GridID, users.Name, logs.CreatedAt FROM logs LEFT JOIN users ON users.ID = logs.CreatedBy WHERE logs.FormID=$FormID AND logs.EditId = $EditID ORDER BY logs.ID DESC";

// logs.CompanyId, logs.DivisionId, logs.YearCode, logs.FormID,
// $query = "SELECT Mode, field, oldValue, newValue, b.label as CompanyId, c.name as DivisionId, a.YearCode, a.FormID, d.Name as CreatedBy FROM logs a 
// left join company_view b on a.CompanyId=b.id
// left join division_view c on a.DivisionId=c.id
// left join mst_users d on a.createdby=d.id WHERE a.FormID=$FormID";

if(strlen($FilterCondition) > 0){
    $query .= $FilterCondition;
}

// echo $query;

$result = db::getInstance()->db_select($query);
// print_r($result)['result_set'];
$arr = array("data" => $result['result_set']); 


$arr['success'] = true;
// Return the paged data as a JSON response
echo json_encode($arr);

?>
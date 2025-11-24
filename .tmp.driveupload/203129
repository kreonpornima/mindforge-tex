<?php
//fetch.php
require_once ('dbClass.php');

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
$db[0] = isset($_POST['fromRepo']) ? $_POST['fromRepo'] : '0';
$responseParams = isset($_POST['responseParams']) ? $_POST['responseParams'] : '0';

// $MainDBTable = array("AiCompany","AiDivision","AiGroup","AiGroupLicense","AiGroupProductAccess","AiProductCategory",
// "AiReg","AiYear","CompanyRoleAccess","kgridfields","kmainfields","kmainforms","kmaingrid","kmainmedia","kpageaccess",
// "kreport_datagrid_data","kreport_pivot_data","kReportFields","kReportFielters","kReportHeader","master_fieldtype","Master_ModuleType","pageroleaccesss","pagerolemaster","users");

// if (in_array($db[0],$MainDBTable)){
//     $Instance = db::getInstanceMaster();
//     $dbName = 'Main';
// }else{
//     $Instance = db::getInstance();
//     $dbName = $_SESSION['dbName'];
// }

// echo $sql1 ="SELECT COLUMN_NAME FROM ".$dbName.".INFORMATION_SCHEMA.KEY_COLUMN_USAGE
// WHERE TABLE_NAME LIKE '".$db[0]."' AND CONSTRAINT_NAME LIKE 'PK%'";

// $sqlresult = $Instance->db_select($sql1);
// $getPrimaryKey = $sqlresult['result_set'][0]['COLUMN_NAME'];

$DbFieldNames = explode(',',$responseParams);

$queryForCount = "SELECT count($DbFieldNames[0]) AS cnt ";

$queryWithoutCount = "SELECT $responseParams ";


$query .= " From $db[0] ";

$query .= " WHERE 1=1 ";

// echo $queryForCount . $query;

$number_filter = db::getInstance()->db_select($queryForCount . $query);
     
$number_filter_row = $number_filter['result_set'][0]['cnt'];

// echo $number_filter_row;

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY "'.$DbFieldNames[0].'" DESC ';
}

$query1 = '';

if($_POST["length"] != 1)
{
    // $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    $query1 .= ' OFFSET ' . $_POST['start'] . ' ROWS FETCH NEXT ' . $_POST['length'] . ' ROWS ONLY';

}

$query2 = $queryWithoutCount . $query . $query1;
$result = db::getInstance()->db_select($query2);

$data = array();

$row = $result['result_set'];


for($i=0; $i<sizeof($row); $i++){
    $sub_array = array();
    
    // print_r($row[$i]);echo "<br />>>" .$row[$i]["ID"]; 
    // for($j=0; $j<count($DbFieldNames); $j++){
    foreach($DbFieldNames as $key=>$value){
        array_push($sub_array,$row[$i][trim($value)]);
    }

    $data[] = $sub_array;
}
// print_r($data);
function get_all_data($tableName,$getPrimaryKey)
{
 $query = "SELECT COUNT($getPrimaryKey) as cnt FROM $tableName";
 $result = db::getInstance()->db_select($query);

//  $result = mysqli_query($connect, $query);
 return $result['result_set'][0]['cnt'];
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($db[0],$getPrimaryKey),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}
header('Content-Encoding: gzip');
header('Content-Type: application/json');
echo json_encode($output);
ob_end_flush();

?>
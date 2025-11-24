<?php 
require_once('dbClass.php');
session_start();
$output = array();
$output["response"] = "false";
$templateId = isset($_GET['templateId']) ? $_GET['templateId'] : "";
$ReportID = isset($_GET['ReportID']) ? $_GET['ReportID'] : "";
$filterData = isset($_GET['filterData']) ? urldecode($_GET['filterData']) : "";

$ssdt = isset($_GET['ssdt']) ? ($_GET['ssdt']) : "";
$lldt = isset($_GET['lldt']) ? ($_GET['lldt']) : "";
$company = isset($_GET['company']) ? ($_GET['company']) : "";
$division = isset($_GET['division']) ? ($_GET['division']) : "";
$year = isset($_GET['year']) ? ($_GET['year']) : "";
$printer = isset($_GET['printer']) ? ($_GET['printer']) : "";
$papersize = isset($_GET['papersize']) ? ($_GET['papersize']) : "";
$paperorientation = isset($_GET['paperorientation']) ? ($_GET['paperorientation']) : "";

// If it's a Username and value is a 10-digit mobile number
$email = $_SESSION["email"];
if (preg_match('/^\d{10}$/', $email)) {
		$email = 'u' . $email;
	}

$username = str_replace("_", "", $email);

$filterDataC = convertSerializedToArray($filterData);
// echo json_encode($filterDataC);
//$andFilters = str_replace("&", " and ", $filterData);
$andFilters = '';
$separator = '';
$filterKeys = array_keys($filterDataC);
for($i = 0; $i < sizeof($filterDataC); $i++){
    $andFilters .= $separator . $filterKeys[$i] . "=" . $filterDataC[$filterKeys[$i]] . "";
    $separator = '|';
}
// echo $andFilters;
// exit();

$paramData = isset($_GET['paramData']) ? urldecode($_GET['paramData']) : "";
$paramDataC = convertSerializedToArrayWithBlanks($paramData);
// echo json_encode($paramDataC);
// echo json_encode($_SESSION);
$paramString = '';
$separator = '';
$filterKeys = array_keys($paramDataC);
for($i = 0; $i < sizeof($paramDataC); $i++){
    if(strlen($filterKeys[$i]) > 0){
        $paramString .= $separator . "{?" . $filterKeys[$i] . "}=" . $paramDataC[$filterKeys[$i]];
        $separator = '|';
    }
}
// echo $paramString;

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

function convertSerializedToArrayWithBlanks($var){
    $data = explode("&",$var);
    // print_r($data );
    $result = array();
    // echo json_encode($data);
    for($i=0; $i<count($data); $i++){
        $tmp = explode("=", $data[$i]);
        // if(strlen($tmp[1])>0){  //removing blanks
            // if($tmp[1] != '0')      //removing 0 vals
                $result[$tmp[0]] = $tmp[1];
        // }
    }
    return $result;
}


$sql = 'SELECT * FROM kreport_pdf_templates where ID = ' . $templateId;
$result1 = db::getInstanceMaster()->db_select($sql);
$num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
$SPName = $result1['result_set'][0]['SPName'];
$RptFileName = $result1['result_set'][0]['RptFileName'];



// {"reg":"1","entryno":"2","entrydate":"2024-01-02","trsppay":"asd","sender":"0","broker":"0","remark":"44554"}
// {"Name":"ttt","Type":"oooo"}
// {"LoginAttempt":1,"email":"shri","user_id":1013,"access":1,"group_id":7,"dbCompanyName":"VALIANT GLASS WORKS PVT. LTD. - Valiant - 2425",
//     "dbHost":"106.201.231.148,4545","dbUser":"sa","dbPass":"Erp@123","dbName":"Valianterp","dbCompany":12,"dbDivision":2,"dbYear":2425,
//     "csrftoken":"7916d46745030cfc2bb5bfc809b380a2"}
//  print_r($_SESSION);
// echo "<br />";
// echo "<br />";
// echo $ddbb;
$sql = "SELECT dtbases FROM Aireg where CompanyID=" . $company . " AND DivisionID=" . $division . " AND Year=" . $year;
$result1 = db::getInstanceMaster()->db_select($sql);
$num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
if($num_rows > 0){
    $dtbases = $result1['result_set'][0]['dtbases'];
}
$ddbb = strlen($dtbases) > 0 ? $dtbases : $_SESSION["dbName"];
$sql = "INSERT INTO ReportJobs
           (cuser,servername,databasename,userid,psw,reportname,rptpath,pdfpath,DSN,pdfname,reporterror,ReportParams,Parameter,
           ssdt,lldt,companyid, divisionid,PrinterID,PaperSizeID,PaperOrientation)
     VALUES ( '" . $username . "','" . $_SESSION["dbHost"] . "', '" . $ddbb . "','" . $_SESSION["dbUser"] . "',
        '" . $_SESSION["dbPass"] . "','" . $RptFileName . "','" . CODE_PATH . REPORT_PATH . "','" . CODE_PATH . REPORT_PATH . "pdf\\',
        '','','','".$andFilters."','".$paramString."'
        ,'".$ssdt."','".$lldt."','".$company."','".$division."'
        ,'".$printer."','".$papersize."','".$paperorientation."')";
$result = db::getInstanceMaster()->db_insertQuery($sql);
$lastID = $result["last_id"];
// print_r($result);
// exit();


    $data['name'] = $SPName;
    $data['params'] = ['@User','@FilterData'];
    $sp['values'] = ["'" . $username ."'","'". $andFilters ."'"];
    $result = db::getInstance()->db_sp_select($data['name'], $data['params'], $sp['values']); 
    // print_r($result);
    // exit();

    // $lastID = 23;

    //$answer = exec( CODE_PATH . REPORT_PATH . "MainPDFReport.exe $lastID");
    // echo $answer; 
    $descriptorspec = [
        0 => ["pipe", "r"],   // stdin
        1 => ["pipe", "w"],   // stdout
        2 => ["pipe", "w"]    // stderr
    ];

    $process = proc_open(CODE_PATH . REPORT_PATH . "MainPDFReport.exe $lastID", $descriptorspec, $pipes);

    if (is_resource($process)) {
        // Optionally set stream timeouts
        stream_set_timeout($pipes[1], 10);
        stream_set_timeout($pipes[2], 10);

        $output = stream_get_contents($pipes[1]);
        $error  = stream_get_contents($pipes[2]);

        fclose($pipes[1]);
        fclose($pipes[2]);

        $return_value = proc_close($process);

        if ($return_value !== 0) {
            throw new Exception("EXE failed: $error");
        }
    }

    
    $sql = 'SELECT * FROM ReportJobs where ID = ' . $lastID;
    $result1 = db::getInstanceMaster()->db_select($sql);
    $num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
    if($num_rows > 0){
        $PDF = $result1['result_set'][0]['pdfname'];
        $pdfpath = $result1['result_set'][0]['pdfname'];
        if((int)$PDF == -1){
            $output["response"] = "false";
            $output["data"] = "ErrorCode PR105: Error in PDF - " . $result1['result_set'][0]['reporterror'];
        }else{
            $output["response"] = "true";
            $output["data"] = $PDF;
        }
    }
    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
        ob_start("ob_gzhandler");
    } else {
        ob_start();
    }
    header('Content-Encoding: gzip');
    header('Content-Type: application/json');
    echo json_encode($output);
    ob_end_flush();
    exit();
?>
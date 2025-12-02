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
$exporttype = isset($_GET['exporttype']) ? ($_GET['exporttype']) : null;

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
           ssdt,lldt,companyid, divisionid,PrinterID,PaperSizeID,PaperOrientation, export_type)
     VALUES ( '" . $username . "','" . $_SESSION["dbHost"] . "', '" . $ddbb . "','" . $_SESSION["dbUser"] . "',
        '" . $_SESSION["dbPass"] . "','" . $RptFileName . "','" . CODE_PATH . REPORT_PATH . "','" . CODE_PATH . REPORT_PATH . "pdf\\',
        '','','','".$andFilters."','".$paramString."'
        ,'".$ssdt."','".$lldt."','".$company."','".$division."'
        ,'".$printer."','".$papersize."','".$paperorientation."', '".$exporttype."')";
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

    $answer = exec( CODE_PATH . REPORT_PATH . "MainPDFReportExport.exe $lastID");
    // // $answer = exec( CODE_PATH . REPORT_PATH . "RunReport.bat $lastID");
    // $lastID = intval($lastID); // sanitize
    // // $answer = exec();
    // $cmd = CODE_PATH . REPORT_PATH . "RunReport.bat $lastID";
    // exec($cmd, $output, $status);
    // if ($status !== 0) {
    //     throw new Exception("PDF export failed. Check log at reports");
    // }

    /*$exePath = CODE_PATH . REPORT_PATH . "MainPDFReportExport.exe";
        $cmd = escapeshellarg($exePath) . " " . escapeshellarg($lastID);

        $descriptorspec = [
            0 => ["pipe", "r"],   // stdin
            1 => ["pipe", "w"],   // stdout
            2 => ["pipe", "w"]    // stderr
        ];

        $process = proc_open($cmd, $descriptorspec, $pipes);

        if (is_resource($process)) {
            // Make pipes non-blocking
            stream_set_blocking($pipes[1], false);
            stream_set_blocking($pipes[2], false);

            $start = time();
            $timeout = 6; // seconds

            $stdout = '';
            $stderr = '';

            while (true) {
                $stdout .= stream_get_contents($pipes[1]);
                $stderr .= stream_get_contents($pipes[2]);

                $status = proc_get_status($process);

                if (!$status['running']) break; // finished normally

                if (time() - $start > $timeout) {
                    // Timed out — kill the process
                    proc_terminate($process, 9);
                    throw new Exception("MainPDFReportExport.exe timed out after {$timeout}s.\n\nError: $stderr");
                }

                usleep(200000); // wait 0.2 sec before checking again
            }

            fclose($pipes[1]);
            fclose($pipes[2]);

            $exitCode = proc_close($process);

            if ($exitCode !== 0) {
                throw new Exception("MainPDFReportExport.exe failed with exit code $exitCode\n\nError: $stderr");
            }

            // ✅ Execution finished successfully
            // You can now safely read or serve the output PDF
            $outputFile = REPORT_PATH . "ExportedReport_$lastID.pdf";
            if (file_exists($outputFile)) {
                // proceed with it
            } else {
                throw new Exception("PDF not found after successful execution.");
            }

        } else {
            throw new Exception("Failed to start MainPDFReportExport.exe process.");
        }*/

    // echo $answer; 

/**
 * Run a command with both wall-clock and idle timeouts.
 * - $timeoutSec: absolute cap (e.g., 300 = 5 minutes)
 * - $idleTimeoutSec: kill if there's no stdout/stderr for this long (e.g., 60s)
 * Returns ['exitCode', 'stdout', 'stderr', 'timedOut' (bool), 'idleTimedOut' (bool)]
 */
/*function runWithTimeout(string $cmd, int $timeoutSec = 300, int $idleTimeoutSec = 60): array {
    $descriptorspec = [
        0 => ["pipe", "r"], // stdin
        1 => ["pipe", "w"], // stdout
        2 => ["pipe", "w"], // stderr
    ];

    // Important on Windows: bypass shell quirks; still okay to pass full cmd line
    $process = proc_open($cmd, $descriptorspec, $pipes, null, null, ['bypass_shell' => true]);

    if (!is_resource($process)) {
        throw new RuntimeException("Failed to start process.");
    }

    // Non-blocking streams
    stream_set_blocking($pipes[1], false);
    stream_set_blocking($pipes[2], false);

    $start = time();
    $lastActivity = $start;
    $stdout = '';
    $stderr = '';
    $timedOut = false;
    $idleTimedOut = false;

    while (true) {
        $status = proc_get_status($process);
        $running = $status['running'];

        // Read any available output
        $o = stream_get_contents($pipes[1]);
        if ($o !== false && $o !== '') { $stdout .= $o; $lastActivity = time(); }

        $e = stream_get_contents($pipes[2]);
        if ($e !== false && $e !== '') { $stderr .= $e; $lastActivity = time(); }

        // Check timeouts
        $now = time();
        if (($now - $start) >= $timeoutSec) {
            $timedOut = true;
            break;
        }
        if (($now - $lastActivity) >= $idleTimeoutSec) {
            $idleTimedOut = true;
            break;
        }

        if (!$running) break;

        // Avoid busy loop; also lets output accumulate
        usleep(100_000); // 100 ms
    }

    if ($timedOut || $idleTimedOut) {
        // Try graceful terminate, then force kill (Windows-safe)
        @proc_terminate($process); // SIGTERM on *nix; on Windows asks nicely
        // If still alive, force kill the tree
        $status = proc_get_status($process);
        if ($status['running'] && isset($status['pid'])) {
            $pid = (int)$status['pid'];
            if (stripos(PHP_OS, 'WIN') === 0) {
                // Kill process tree on Windows
                exec("taskkill /F /T /PID $pid");
            } else {
                exec("kill -9 $pid");
            }
        }
    }

    // Close pipes to avoid deadlocks
    foreach ($pipes as $p) { if (is_resource($p)) fclose($p); }

    // MUST call proc_close to collect exit code
    $exitCode = proc_close($process);

    return [
        'exitCode'      => $exitCode,
        'stdout'        => $stdout,
        'stderr'        => $stderr,
        'timedOut'      => $timedOut,
        'idleTimedOut'  => $idleTimedOut,
    ];
}

    // $answer = exec( CODE_PATH . REPORT_PATH . "MainPDFReportExport.exe $lastID");
// Example usage
$cmd = CODE_PATH . REPORT_PATH . "MainPDFReportExport.exe " . escapeshellarg($lastID);
$result = runWithTimeout($cmd,  600,  90);

if ($result['timedOut'] || $result['idleTimedOut']) {
    throw new RuntimeException(
        "Report generator hung (" .
        ($result['timedOut'] ? "wall timeout" : "idle timeout") .
        "). Stderr: " . $result['stderr']
    );
}
if ($result['exitCode'] !== 0) {
    throw new RuntimeException("EXE failed (code {$result['exitCode']}): {$result['stderr']}");
}
// $result['stdout'] has any logs you print from the EXE
*/
    
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
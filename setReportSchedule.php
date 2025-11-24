<?php
require_once ('dbClass.php');
$ReportID = isset($_POST['ReportID']) ? $_POST['ReportID'] : '0';
$templateId = isset($_POST['templateId']) ? $_POST['templateId'] : '0';
$sch_time = isset($_POST['sch_time']) ? $_POST['sch_time'] : '0';
$selectedUserIds = isset($_POST['selectedUserIds']) ? $_POST['selectedUserIds'] : [];
$sch_users_email = isset($_POST['sch_users_email']) ? $_POST['sch_users_email'] : [];
$sch_users_whatsapp = isset($_POST['sch_users_whatsapp']) ? $_POST['sch_users_whatsapp'] : [];
$filters = isset($_POST['filters']) ? $_POST['filters'] : '';

$sql = 'INSERT INTO kReportSchedule([GroupID],[CompanyID],[DivisionID],[YearCode],[ReportID],[TemplateID],[ScheduleTimeID],[ScheduleType],[CreatedBy],[CreatedAt],[isDeleted],[filters])
     VALUES ('.$_SESSION['group_id'].','.$_SESSION['dbCompany'].','.$_SESSION['dbDivision'].',\''.$_SESSION['dbYearID'].'\','.$ReportID.','.$templateId.',
     '.$sch_time.',0,'.$_SESSION['user_id'].',GETDATE(),0,\''.$filters.'\')';
    //  exit();
$result = db::getInstanceMaster()->db_insertQuery($sql);
$ID = $result['last_id'];
// $ID = 5;

//TELEGRAM USERS
$sql = "INSERT INTO Map_ReportSchedule_Users (ReportScheduleID,UserID, Channel) VALUES ";
$sep = "";
for($i = 0; $i < sizeof($selectedUserIds); $i++){
    $sql .= $sep . "(".$ID.",".$selectedUserIds[$i].",1)"; //TELEGRAM = 1
    $sep = ",";
}
$result = db::getInstanceMaster()->db_insertQuery($sql);
//EMAIL USERS
$sql = "INSERT INTO Map_ReportSchedule_Users (ReportScheduleID,UserID, Channel) VALUES ";
$sep = "";
for($i = 0; $i < sizeof($sch_users_email); $i++){
    $sql .= $sep . "(".$ID.",".$sch_users_email[$i].",2)"; //EMAIL = 2
    $sep = ",";
}
$result = db::getInstanceMaster()->db_insertQuery($sql);
//WHATSAPP USERS
$sql = "INSERT INTO Map_ReportSchedule_Users (ReportScheduleID,UserID, Channel) VALUES ";
$sep = "";
for($i = 0; $i < sizeof($sch_users_whatsapp); $i++){
    $sql .= $sep . "(".$ID.",".$sch_users_whatsapp[$i].",3)"; //WHATSAPP = 3
    $sep = ",";
}
$result = db::getInstanceMaster()->db_insertQuery($sql);

// print_r($result);
if($ID > 0){
    $sql = "select Time from kReportScheduleMaster where ID =" . $sch_time;
    $result1 = db::getInstanceMaster()->db_select($sql);
    $time = $result1['result_set'][0]['Time'];
    $task_name = "MF_Report_Schedule_".$ID;
    //schtasks /delete /tn 'MF_Report_Schedule_5' /f
    $output = [];
    $return_var = 0;
    $cmd = "C:\\Windows\\System32\\schtasks.exe /create /tn $task_name /tr \"\\\\localhost\\V$\\xampp\\htdocs\\tex\\RunScheduledReport.bat $ID\" /sc daily /st $time /RU SYSTEM 2>&1";
    exec($cmd, $output, $return_var);
    // exec("C:\\Windows\\System32\\schtasks.exe /query", $output, $return_var);
    if ($return_var === 0) {
        // echo "Task successfully created!\n";
        // echo "Output:\n" . implode("\n", $output);
        echo json_encode([
            'success' => true,
            'data' => $result,
        ]);
    } else {
        // echo "Return Code: $return_var\n";
        // echo "Output:\n";
        // print_r($output);
        // echo "\n\nTask creation failed! Exit code: $return_var\n";
        // echo "Output:\n" . implode("\n", $output);
        echo json_encode([
            'success' => false,
            'data' => $result,
        ]);
    }
}else{
    echo json_encode([
        'success' => false,
        'data' => $result,
    ]);
}
exit;
?>
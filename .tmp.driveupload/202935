<?php
require_once ('dbClass.php');
$FormID = isset($_POST['ReportID']) ? $_POST['ReportID'] : '0';

//CHECK if SP is available in desired format
$SPName = "sp_GridReport_$FormID";
$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO' AND routine_name = '$SPName'";
$sqlresult = db::getInstance()->db_select($sql);			

if ($sqlresult['result_set'][0]['found'] == 0) {
    //SP NOT FOUND
    echo json_encode([
            'success' => false,
            'msg' => "Scheduler not available for this report. Kindly contact developer to activate scheduler for this report."
        ]);
} else {
    // SP FOUND
    $sql = 'Select ID, Time from kReportScheduleMaster WHERE ID NOT IN (select ScheduleTimeID from kReportSchedule where GroupID = ' . $_SESSION['group_id'] . ' )';
    $result = db::getInstanceMaster()->db_select($sql);
    $sql1 = 'select ID,Name,Category from users where (Category = 2 OR GroupID = ' . $_SESSION['group_id'] . ') AND LEN(TelegramID)>5  order by Category, Name ';
    $result1 = db::getInstanceMaster()->db_select($sql1);
    $sql1 = 'select ID,Name,Category from users where (Category = 2 OR GroupID = ' . $_SESSION['group_id'] . ') AND LEN(EmailID)>5  order by Category, Name ';
    $result2 = db::getInstanceMaster()->db_select($sql1);
    $sql1 = 'select ID,Name,Category from users where (Category = 2 OR GroupID = ' . $_SESSION['group_id'] . ') AND ISNUMERIC(Username) = 1 AND LEN(Username) = 10  order by Category, Name ';
    $result3 = db::getInstanceMaster()->db_select($sql1);
    echo json_encode([
            'success' => true,
            'data' => $result['result_set'],
            'telegram_users' => $result1['result_set'],
            'email_users' => $result2['result_set'],
            'whatsapp_users' => $result3['result_set'],
        ]);        
}
exit;
?>
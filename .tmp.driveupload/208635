<?php
include "../dbClass.php"; // your MSSQL connection
$userId = $_REQUEST['user_id'];  // already logged in on mobile
$tenantid = $_REQUEST['tenantid'];
$token = $_REQUEST['token'];

$sql = "UPDATE qr_login_sessions
        SET status='APPROVED', approved_userid= ".$userId.", expireson=DATEADD(minute,1,GETDATE())
        WHERE session_token='".$token."' AND tenantid='".$tenantid."' AND status='PENDING'";
$result = db::getInstanceMaster()->db_update($sql);
// $params = [$userId, $token, $tenantid];
// $result = sqlsrv_query($conn, $sql, $params);
// print_r($result);
if($result['num_rows'] > 0){
  echo json_encode(['success'=>true]);
} else {
  echo json_encode(['success'=>false, 'error'=>'Invalid or expired token']);
}
?>

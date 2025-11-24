<?php
include "../dbClass.php"; // your MSSQL connection
$token = $_GET['token'];
$tenantid = $_GET['tenantid'];

$sql = "SELECT status FROM qr_login_sessions WHERE session_token='".$token."' AND tenantid='".$tenantid."' AND status='PENDING' AND expireson > GETDATE()";
$result = db::getInstanceMaster()->db_select($sql);
$row = $result['result_set'][0];

if($row){
    echo "QR valid. Please confirm in the app.";
} else {
    echo "QR expired or invalid.";
}
?>

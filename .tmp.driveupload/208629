<?php
include "../dbClass.php"; // your MSSQL connection

$tenantid = $_POST['tenantid'];
$token = bin2hex(random_bytes(16));
$expiry = date('Y-m-d H:i:s', strtotime('+2 minutes'));

echo $sql = "INSERT INTO qr_login_sessions (tenantid, session_token, expireson, web_useragent, web_ip)
        VALUES ('" . $tenantid. "', '" . $token . "', GETDATE(), '" . $_SERVER['HTTP_USER_AGENT']."','". $_SERVER['REMOTE_ADDR']."')";

// $params = [$tenantid, $token, $expiry, $_SERVER['HTTP_USER_AGENT'], $_SERVER['REMOTE_ADDR']];
// sqlsrv_query($conn, $sql, $params);

$qrUrl = "https://api.mindforgeerp.com/api/qr_claim.php?token=$token&tenantid=$tenantid";

// Return base64 QR image
include 'generateBarcodeImage.php';

ob_start();
// QRcode::png($qrUrl, null, QR_ECLEVEL_L, 5);
// $imageString = base64_encode(ob_get_contents());
$imageString = base64_encode(generateQRCodeWithoutFile($qrUrl));
ob_end_clean();

echo json_encode([
  'success' => true,
  'token' => $token,
  'qr_base64' => "data:image/png;base64,$imageString"
]);
?>

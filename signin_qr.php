<?php
// qr_login.php

require_once 'barcode/vendor/autoload.php'; // Correct path to the autoload file

use Com\Tecnick\Barcode\Barcode;

include "dbClass.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    $tenantid = $_POST['tenantid'];
    $action   = $_POST['action'];

    // helper to generate QR
    function generateQR($tenantid, $oldToken = null) {
        global $conn;

        // Expire old token if present
        if ($oldToken) {
            $result = db::getInstanceMaster()->db_update("UPDATE qr_login_sessions SET status='EXPIRED' WHERE session_token= '" .$oldToken . "'");
        }

        // Create new token
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+2 minutes'));

        $sql = "INSERT INTO qr_login_sessions (tenantid, session_token, expireson, web_useragent, web_ip)
            VALUES ('" . $tenantid. "', '" . $token . "', DATEADD(minute,2,GETDATE()), '" . $_SERVER['HTTP_USER_AGENT']."','". $_SERVER['REMOTE_ADDR']."')";
            // VALUES ('" . $tenantid. "', '" . $token . "', GETDATE(), '" . $_SERVER['HTTP_USER_AGENT']."','". $_SERVER['REMOTE_ADDR']."')";
        $result = db::getInstanceMaster()->db_insertQuery($sql);

        $qrUrl = "https://ai.mindforgeerp.com/api/qr_claim.php?token=$token&tenantid=$tenantid";

        $barcode = new Barcode();
        $bobj = $barcode->getBarcodeObj('QRCODE,H', $qrUrl, -16, -16, 'black', array(-2, -2, -2, -2))->setBackgroundColor('white');
        $img = base64_encode($bobj->getPngData());

        return ['token' => $token, 'qr_base64' => "data:image/png;base64," . $img];
    }

    if ($action === 'init') {
        echo json_encode(generateQR($tenantid));
        exit;
    }

    if ($action === 'refresh') {
        $old = $_POST['old_token'] ?? null;
        echo json_encode(generateQR($tenantid, $old));
        exit;
    }

    if ($action === 'check') {
        // console.log("checking...");
        $token = $_POST['token'];
        $sql = "SELECT status, approved_userid FROM qr_login_sessions WHERE session_token='".$token."' AND tenantid='".$tenantid."' AND expireson > GETDATE()";
        $result = db::getInstanceMaster()->db_select($sql);
        // print_r($result);
        $row = $result['result_set'][0];
        $rowOutput = $row;
        // echo json_encode($rowOutput);
        if($row['status'] == 'APPROVED'){
            $approved_userid = $row['approved_userid'];

            $sql = "SELECT users.ID as uid, users.Username, users.isActive, Password, Name, Role, users.GroupID, LastCompanyID, LastDivisionID, 
                        LastYear, UserType, Category, 
                        TelegramID, LoginOTP, datediff(second, OTPGeneratedAt,GETDATE()) as OTPExpiry, AiCompany.GroupID as DeveloperGroupID, 
                        Aireg.dtbases, Aireg.ID as RegID
                        FROM users 
                        LEFT JOIN AiCompany ON users.LastCompanyID = AiCompany.ID 
                        LEFT JOIN AiGroup ON users.GroupID = AiGroup.ID 
                        LEFT JOIN Aireg ON users.LastCompanyID=Aireg.CompanyID AND users.LastDivisionID=Aireg.DivisionID
                        WHERE AiGroup.isActive = 1 AND users.ID='".$approved_userid."'"; 
	        $result = db::getInstanceMaster()->db_select($sql);	
            // print_r($result);
            for($i = 0; $i < $result['num_rows']; $i++){
                $user_id = $result['result_set'][$i]['uid'];
                // $dbpwd = $result['result_set'][$i]['Password'];
                $RegID = $result['result_set'][$i]['RegID'];
                $role = $result['result_set'][$i]['Role'];
                $group = $result['result_set'][$i]['GroupID'];
                $UserType = $result['result_set'][$i]['UserType'];
                $Username = $result['result_set'][$i]['Username'];
                $LastCompanyID = $result['result_set'][$i]['LastCompanyID'];
                $LastDivisionID = $result['result_set'][$i]['LastDivisionID'];
                $LastYear = $result['result_set'][$i]['LastYear'];
                $isActive = $result['result_set'][$i]['isActive'];
                
                if($result['result_set'][$i]['Category'] == null)
                    $Category = 1;
                else
                    $Category = $result['result_set'][$i]['Category'];
                $TelegramID = $result['result_set'][$i]['TelegramID'];
                $LoginOTP = $result['result_set'][$i]['LoginOTP'];
                $OTPExpiry = $result['result_set'][$i]['OTPExpiry'];
                if($Category == 2)
                    $group = $result['result_set'][$i]['DeveloperGroupID'];
                break;
            }
            
            $pwdErrorFlag = 1;
            if ($isActive == 0) { //updated by pornima for inactive user
                $pwdErrorFlag = 7; // Inactive user
            }else {
                if ($result['num_rows'] == 0){
                    $pwdErrorFlag = 1;
                }else{
                    $pwdErrorFlag = 0;
                }
            }
            if ($pwdErrorFlag == 0){
                $_SESSION['RegID'] = $RegID;
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['access'] = $role;
                $_SESSION['group_id'] = $group;
                $_SESSION['LoginKey'] = md5($email . rand(100000,999999));
                $_SESSION['UserType'] = $UserType;
                $_SESSION['Category'] = $Category;
                $_SESSION['username'] = $Username;
                // $_SESSION['dtbases']  = $dtbases;
                if($Category == 2){
                    $Filename = './logs/dev_'.$email . '.proflog' ;
                    if (file_exists($Filename)) {
                        unlink($Filename);
                    }
                }
                $sql = "update users set LoginKey = '".$_SESSION['LoginKey']."', LastUsageAt=getdate() where ID = " . $user_id; //
                $result = db::getInstanceMaster()->db_update($sql);
                $companySet = false;
                if($LastCompanyID > 0 && $LastDivisionID > 0){
                    $query = "SELECT CONCAT(AiCompany.Label,' - ', AiDivision.Label, ' - ', AiReg.Year) as Name, Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, Aireg.Database_name, Aireg.Ip, Aireg.Port, Aireg.Sql_User_Id, 
                            Aireg.Decrypted_Password, Aireg.ID as RegID
                            from Aireg 
                            LEFT JOIN AiCompany ON AiReg.CompanyID = AiCompany.ID 
                            LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID
                            LEFT JOIN AiDivision ON AiReg.DivisionID = AiDivision.ID
                            where Aireg.CompanyID='".$LastCompanyID."' and Aireg.DivisionID='".$LastDivisionID."' and Aireg.Year='".$LastYear."' ";
                    $result = db::getInstanceMaster()->db_select($query);
                    $row = $result['result_set'];
                    if(sizeof($row) > 0){
                        for($i = 0; $i < count($row); $i++){
                            $companySet = true;
                            $_SESSION['RegID'] = $row[$i]['RegID'];
                            $_SESSION['dbCompanyName'] = $row[$i]['Name'];
                            $_SESSION['dbHost'] = $row[$i]['Ip'].','.$row[$i]['Port'];
                            $_SESSION['dbUser'] = $row[$i]['Sql_User_Id'];
                            $_SESSION['dbPass'] = $row[$i]['Decrypted_Password'];
                            $_SESSION['dbName'] = $row[$i]['Database_name'];
                            $_SESSION['dbCompany'] = $row[$i]['CompanyID'];
                            $_SESSION['dbDivision'] = $row[$i]['DivisionID'];
                            $_SESSION['dbYear'] = $row[$i]['Year']; //only used at dbMySQL. To be removed.
                            $_SESSION['dbYearID'] = $yearID;    //Doesn't have Year Code ID. Please Add it
                        }
                    }
                }
                // echo "<br/>Success!!<br />";
                date_default_timezone_set('Asia/Calcutta'); 
                $oldLog = $email.'_'. date('Y-m-d_h-i-s a');
                rename('logs/'.$email.'.log', 'logs/'.$oldLog .'.log');
                $source = 'logs/'.$oldLog.'.log';
                $destination = LOG_PATH . $email.'_'. date('Y-m-d_h-i-s a') .'.log';
                if (copy($source, $destination)) {
                    unlink($source); 
                } 
                
                //On logout, check if the current user has any edit mode active, then release the edit mode
                $editLockQuery = "UPDATE kFormEditLock set isDeleted=1, UpdatedAt=GETDATE() WHERE UserID = {$_SESSION['user_id']} AND isDeleted = 0 AND CompanyID = {$_SESSION['dbCompany']} AND DivisionID = {$_SESSION['dbDivision']}";
                $query1result = db::getInstance()->db_update($editLockQuery);

                if($companySet){
                    // echo '<script>window.location.replace("home.php");</script>';
                    $pwdErrorFlag = 0;
                }else{
                    // echo '<script>window.location.replace("company.php");</script>';
                    $pwdErrorFlag = -1;
                }
            }else{
                // echo '<script>window.location.replace("signin.php?error='.$pwdErrorFlag.'");</script>';
            }
        }

        if ($rowOutput) {
            $rowOutput['pwdErrorFlag'] = $pwdErrorFlag;
            echo json_encode($rowOutput);
        } else {
            echo json_encode(['status' => 'EXPIRED']);
        }
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <title>Mindforge ERP - QR Login</title>

  <!-- Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="assets/stylesheets/theme.css" />
  <link rel="stylesheet" href="assets/stylesheets/theme-custom.css" />

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    #qr-box { position: relative; }
    body {
      background: linear-gradient(135deg, #e0f7fa, #e8eaf6, #ffffff);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Open Sans', sans-serif;
    }
    .login-wrapper {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      width: 95%;
      max-width: 420px;
      padding: 2.5rem;
      text-align: center;
      backdrop-filter: blur(6px);
    }
    .login-logo img { max-height: 60px; margin-bottom: 1rem; }
    .login-title {
      font-weight: 700; font-size: 1.6rem;
      color: #2e3b55; margin-bottom: 1rem;
      margin-top: 1rem;
      text-transform: uppercase; letter-spacing: 1px;
    }
    #qr-box {
      background: #fff;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
      display: inline-block;
      width: 100%;
      margin-top: 0.5rem;
    }
    #qr {
      width: 260px; height: 260px; border-radius: 8px;
      margin-bottom: 1rem; border: 1px solid #eee;
    }
    #qr-status {
      margin-top: 10px;
      font-size: 1.2rem;
      font-weight: 500;
      color: #3f51b5;
    }
    #refresh-spinner {
      display: none;
      font-size: 0.9rem;
      color: #888;
      margin-top: 8px;
    }
    .instructions {
      text-align: left;
      margin-top: 1.5rem;
      font-size: 1.2rem;
      color: #555;
    }
    .instructions ol {
      padding-left: 1.2rem;
    }
    .btn-back {
      background: #3f51b5;
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 10px;
      width: 100%;
      margin-top: 1.5rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding: 10px;
      text-shadow: 1px 2px 3px rgba(0,0,0,0.3);
      transition: 0.3s;
    }
    .btn-back:hover {
      background: #3949ab;
      color: white;
    }
    .login-footer {
      text-align: center;
      font-size: 1rem;
      color: #888;
      margin-top: 1.5rem;
    }
  </style>
</head>

<body>
  <div class="login-wrapper">
    <div class="login-logo">
      <!-- <img src="assets/images/kreon-logo.png" alt="Mindforge ERP Logo"> -->
       <img src="img/MF-Logo.jpg" alt="Mindforge ERP Logo" style="max-height: 155px;max-width:83vw;">
    </div>


    <div id="qr-box">
    <h2 class="login-title"><i class="fa fa-qrcode text-primary"></i> QR Code Login</h2>
      <!-- <h5 class="text-muted mb-3">Scan this QR to Login</h5> -->
      <img id="qr" src="qr_generate.php" alt="QR Code">
      <div id="overlay-btn"
          style="display:none; position:absolute; top:50%; left:50%;
                  transform:translate(-50%,-50%);
                  background:rgba(255,255,255,0.85);
                  border-radius:10px;
                  padding:20px;
                  cursor:pointer;
                  box-shadow:0 0 10px rgba(0,0,0,0.3);">
        <button class="btn btn-primary" onclick="restartQRSession()">
          <i class="fa fa-refresh"></i> Click to Start
        </button>
      </div>

      <div id="qr-status">Waiting for scan...</div>
      <div id="refresh-spinner"><i class="fa fa-spinner fa-spin"></i> Refreshing QR...</div>
    </div>
    <h4 style="font-weight:600;">Coming soon... Currently under Beta-testing phase.</h4>
    <button class="btn-back" onclick="window.location.href='signin.php'">
      <i class="fa fa-arrow-left"></i> Back to Password-based Login
    </button>
    <div class="instructions">
      <h5 style="font-weight:600; margin-bottom: 0.5rem;">Steps to Login Using QR</h5>
      <ol>
        <li>Open the <strong>Mindforge ERP Mobile App</strong> on your phone.</li>
        <li>Go to <strong>→ QR Login</strong> section in the app.</li>
        <li>Point your phone’s camera at the QR code above.</li>
        <li>Wait for the app to confirm your login.</li>
        <li>You’ll be automatically redirected once verified.</li>
      </ol>
      <p class="text-muted small mt-2">
        For security, this QR code expires every 20 seconds.
      </p>
    </div>

    <div class="login-footer">
      &copy; <?php echo date("Y"); ?> | Mindforge Innovations ERP | Empowering Textile & Beyond
    </div>
  </div>


<script>
    let tenantId = 1;            // set dynamically in your ERP
    let qrToken = null;
    // let refreshInterval = 60000; // 60 seconds
    let refreshInterval = 20000; // refresh QR every 20s
    let pollingInterval = null;
    let refreshTimer = null;
    let totalRuntime = 60000 - 100; // 3 minutes = 180000 ms
    let sessionTimer = null;


    /*function generateQR() {
    $.post('signin_qr.php', { action: 'init', tenantid: tenantId }, function(res) {
        $("#qr").attr("src", res.qr_base64);
        qrToken = res.token;
        $("#qr-status").text("Scan with your ERP mobile app");
        startPolling();
        startAutoRefresh();
    }, 'json');
    }

    function refreshQR() {
    $("#refresh-spinner").show();
    $.post('signin_qr.php', { action: 'refresh', tenantid: tenantId, old_token: qrToken }, function(res) {
        $("#qr").attr("src", res.qr_base64);
        qrToken = res.token;
        $("#refresh-spinner").hide();
        $("#qr-status").text("Scan with your ERP mobile app");
        startPolling();
    }, 'json');
    }

    function startAutoRefresh() {
    setInterval(refreshQR, refreshInterval);
    }

    function startPolling() {
    (function poll() {
        console.log("polling started");
        $.ajax({
        url: 'signin_qr.php',
        method: 'POST',
        dataType: 'json',
        data: { action: 'check', tenantid: tenantId, token: qrToken },
        success: function(res) {
            console.log("poll response:", res);
            if (res.status === 'APPROVED') {
                $("#qr-status").text("Approved! Logging in...");
                window.location.href = 'home.php';
                // alert("h");
            } else if (res.status === 'EXPIRED') {
            $("#qr-status").text("QR expired. Refreshing...");
            refreshQR();
            } else {
            setTimeout(poll, 2000); // continue polling
            }
        },
        error: function(xhr, status, err) {
            console.warn("Polling failed:", err);
            setTimeout(poll, 4000); // retry after delay even if error
        }
        });
    })();
    }*/

    function generateQR() {
      $("#overlay-btn").hide(); // hide restart overlay
      $("#qr-status").text("Scan with your ERP mobile app");

      $.post('signin_qr.php', { action: 'init', tenantid: tenantId }, function(res) {
        $("#qr").attr("src", res.qr_base64);
        qrToken = res.token;
        startPolling();
        startAutoRefresh();
        startSessionTimer();
      }, 'json');
    }

    function refreshQR() {
      $("#refresh-spinner").show();
      $.post('signin_qr.php', { action: 'refresh', tenantid: tenantId, old_token: qrToken }, function(res) {
        $("#qr").attr("src", res.qr_base64);
        qrToken = res.token;
        $("#refresh-spinner").hide();
        $("#qr-status").text("Scan with your ERP mobile app");
      }, 'json');
    }

    function startAutoRefresh() {
      refreshTimer = setInterval(refreshQR, refreshInterval);
    }

    function startPolling() {
      (function poll() {
        $.ajax({
          url: 'signin_qr.php',
          method: 'POST',
          dataType: 'json',
          data: { action: 'check', tenantid: tenantId, token: qrToken },
          success: function(res) {
            if (res.status === 'APPROVED') {
              $("#qr-status").text("Approved! Logging in...");
              clearAllTimers();
              window.location.href = 'home.php';
            } else if (res.status === 'EXPIRED') {
              $("#qr-status").text("QR expired. Refreshing...");
              refreshQR();
            } else {
              pollingInterval = setTimeout(poll, 2000);
            }
          },
          error: function() {
            pollingInterval = setTimeout(poll, 4000);
          }
        });
      })();
    }

    function startSessionTimer() {
      clearTimeout(sessionTimer);
      sessionTimer = setTimeout(stopAllProcesses, totalRuntime);
    }

    function clearAllTimers() {
      clearInterval(refreshTimer);
      clearTimeout(pollingInterval);
      clearTimeout(sessionTimer);
    }

    function stopAllProcesses() {
      clearAllTimers();
      $("#qr-status").text("Session expired. Click below to start again.");
      $("#overlay-btn").fadeIn();
    }

    $(document).ready(() => generateQR());
</script>

</body>
</html>

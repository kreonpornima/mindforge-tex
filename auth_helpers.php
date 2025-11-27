<?php 
    use Com\Tecnick\Barcode\Barcode;

    function sendTelegramOTP($UserID, $TelegramID){
        $otp= rand(100000, 999999);
        $messageResponse = sendMessage($TelegramID, "Welcome to Mindforge AI ERP. Your OTP is " . $otp . ". Valid for 5mins only.", TELEGRAM_TOKEN);
        // echo "Message Response: " . $messageResponse . "\n\n";
        $sql = "UPDATE users SET TelegramResponse = '".$messageResponse."', LoginOTP = '".$otp."', OTPGeneratedAt = GETDATE() WHERE ID = " . $UserID;
        $result = db::getInstanceMaster()->db_update($sql);	
        $msg = json_decode($messageResponse, true); 
        // echo "<pre>" . print_r($msg) . "</pre>";
        if($msg['ok'] == 1){
            $UpdateMsg = 'Telegram OTP sent succesfully.';
        }else{
            if(strlen($msg['description']) > 1){
                echo $msg['description'];
                echo '<script>window.location.replace("signin.php?error=5&error_msg='.$msg['description'].'.\n Please check your Telegram ID or Register of MF_ERPbot from Telegram.");</script>';
                exit;
            }			
        }
    }

    function sendTelegramOTP_TwoFactor($UserID, $TelegramID, $Name, $headUserID, $RoleID){
        $otp= rand(100000, 999999);
        $messageResponse = sendMessage($TelegramID, "
        ".$Name." is trying to login to Mindforge AI ERP from an unauthorized location. Share this OTP in order to authorize the user's access " . $otp . " (valid for 10mins). If the access looks suspicious, do not share the OTP.", TELEGRAM_TOKEN);
        // echo "Message Response: " . $messageResponse . "\n\n";
        // $sql = "UPDATE users SET TelegramResponse = '".$messageResponse."', LoginOTP = '".$otp."', OTPGeneratedAt = GETDATE() WHERE ID = " . $UserID;
        $sql = "INSERT INTO map_user_twofactorotp (UserID, RoleID, HeadID, OTP, isVerified)
            VALUES (" . ($UserID ?: 'NULL') . ", 
                    " . $RoleID . ", 
                    " . $headUserID . ", 
                    '" . addslashes($otp) . "',  0)";
                 
        $result = db::getInstanceMaster()->db_insertQuery($sql);	
        $msg = json_decode($messageResponse, true); 
        // echo "<pre>" . print_r($msg) . "</pre>";
        if($msg['ok'] == 1){
            $UpdateMsg = 'Telegram OTP sent succesfully.';
        }else{
            if(strlen($msg['description']) > 1){
                echo $msg['description'];
                echo '<script>window.location.replace("signin.php?error=5&error_msg='.$msg['description'].'.\n Please check your Telegram ID or Register of MF_ERPbot from Telegram.");</script>';
                exit;
            }		
        }
    }

    // Function to send a message on TELEGRAM
	function sendMessage($chat_id, $message, $token) {
		$url = "https://api.telegram.org/bot$token/sendMessage";
		$data = [
			'chat_id' => $chat_id,
			'text' => $message
		];
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		// print_r($response);		
		return $response;
	}

    function restoreMainDbSession($email){
        // Load user
        $sql = "SELECT users.ID as uid, users.Username, users.isActive, Password, Name, Role, users.GroupID, 
                        LastCompanyID, LastDivisionID, LastYear, UserType, Category, TelegramID, LoginOTP,
                        DATEDIFF(SECOND, OTPGeneratedAt, GETDATE()) as OTPExpiry,
                        AiCompany.GroupID as DeveloperGroupID,
                        Aireg.ID as RegID,
                        AiGroup.isGeoLockingEnabled
                FROM users
                LEFT JOIN AiCompany ON users.LastCompanyID = AiCompany.ID
                LEFT JOIN Aireg ON users.LastCompanyID = Aireg.CompanyID AND users.LastDivisionID = Aireg.DivisionID
                LEFT JOIN AiGroup ON users.GroupID = AiGroup.ID
                WHERE Username = '" . addslashes($email) . "'";

        $result = db::getInstanceMaster()->db_select($sql);
        
        $dbNameCheck = db::getInstanceMaster()->db_select("SELECT DB_NAME() AS DbName");
       
        if($result['num_rows'] > 0){
            $row = $result['result_set'][0];

            $_SESSION['RegID'] = $row['RegID'];
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row['uid'];
            $_SESSION['access'] = $row['Role'];
            $_SESSION['group_id'] = $row['GroupID'];
            $_SESSION['LoginKey'] = md5($email . rand(100000,999999));
            $_SESSION['UserType'] = $row['UserType'];
            $_SESSION['Category'] = $row['Category'];
            $_SESSION['username'] = $row['Username']; 
        }
        
    }

    // Function to add access log
    function logAccess($UserID, $Username, $LoginType, $Status, $isOutsideGeolocking, $Message = '', $Password = '', $TwoFactorAuthUserName = '') {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $sql = "select * from users where ID=".$UserID;
        $sqlResult = db::getInstanceMaster()->db_select($sql);
  
        if ($sqlResult['num_rows'] == 0) {
            return false;
        }

    
        if($sqlResult['result_set'][0]['GroupID'] == 16){

            $sql = "select * from Aireg where CompanyID=22";
            
        }else{
            if($sqlResult['result_set'][0]['LastCompanyID'] != null || strlen($sqlResult['result_set'][0]['LastCompanyID']) > 0){
                
                $sql = "SELECT Aireg.* FROM Users LEFT JOIN Aireg ON Aireg.CompanyID = Users.LastCompanyID WHERE Users.ID =".$UserID;
                
            }else{ // if($sqlResult['result_set'][0]['LastCompanyID'] == null || strlen($sqlResult['result_set'][0]['LastCompanyID']) == 0)

                $sql = "SELECT Aireg.* FROM Users LEFT JOIN AiCompany ON AiCompany.GroupID = Users.GroupID LEFT JOIN Aireg ON Aireg.CompanyID = AiCOmpany.ID WHERE Users.ID =".$UserID;
            }
        }
        
        $getCompanyResult = db::getInstanceMaster()->db_select($sql);

        $_SESSION['dbHost'] = $getCompanyResult['result_set'][0]['Ip'].','.$getCompanyResult['result_set'][0]['Port'];
        $_SESSION['dbUser'] = $getCompanyResult['result_set'][0]['Sql_User_Id'];
        $_SESSION['dbPass'] = $getCompanyResult['result_set'][0]['Decrypted_Password'];
        $_SESSION['dbName'] = $getCompanyResult['result_set'][0]['Database_name'];
 

        $checkTableExist = "SELECT * FROM information_schema.columns WHERE table_name='user_access_log'";
        $result = db::getInstance()->db_select($checkTableExist);
        
    
        if ($result['num_rows'] == 0) {
           
            $query = "CREATE TABLE [user_access_log] (
                                [ID] [bigint] IDENTITY(1,1) PRIMARY KEY,
                                [UserID] [int] NULL,

                                [Username] [nvarchar](255) NULL,
                                [Password] [nvarchar](255) NULL,
                                [LoginType] [nvarchar](50) NULL,
                                [IPAddress] [nvarchar](100) NULL,
                                [Status] [nvarchar](20) NULL,
                                [Message] [nvarchar](1000) NULL,
                                [TwoFactorAuthUserName] [nvarchar](255) NULL,
                                [isOutsideGeolocking] [tinyint] NULL,
                                [CreatedAt] [datetime] NOT NULL DEFAULT (GETDATE())
                            ) ON [PRIMARY];";
            $createResult = db::getInstance()->db_create_table($query, "F-17510: Cl-");
        }

        $sql = "INSERT INTO user_access_log (UserID, Username, LoginType, IPAddress, Status, Message, Password, TwoFactorAuthUserName, isOutsideGeolocking)
            VALUES (" . ($UserID ?: 'NULL') . ", 
                    '" . addslashes($Username) . "', 
                    '" . addslashes($LoginType) . "', 
                    '" . addslashes($ip) . "', 
                    '" . addslashes($Status) . "', 
                    '" . addslashes($Message) . "',
                    '" . addslashes($Password) ."',
                    '" . addslashes($TwoFactorAuthUserName) ."',
                    ".$isOutsideGeolocking.")";

             
                    
        // exit();
        db::getInstance()->db_insertQuery($sql);

        // $dbNameCheck = db::getInstance()->db_select("SELECT DB_NAME() AS DbName");

        //Unset cloing session
        unset($_SESSION['dbHost'], $_SESSION['dbUser'], $_SESSION['dbPass'], $_SESSION['dbName']);
        
        restoreMainDbSession($Username);
    }

    // Validate user GeoLocking and send Telegram OTP
    function validateGeoLockingAndSendOTP(string $email): array {
        $response = [
            'status' => false,
            'error_msg' => '',
            'error_code'=> 0,
            'TelegramID' => '',
            'UserID' => 0,
            'GroupID' => 0,
            'isGeoLockingEnabled' => 0,
            'UserIsActive' => 0,
            'GroupIsActive' => 0,
            'RoleID' => 0,
            'ip_ok' => true,
            'sentUsers' => []
        ];

        $sql = "SELECT TelegramID, users.ID, isGeoLockingEnabled, users.GroupID, Role, 
                    users.isActive AS UserIsActive, AiGroup.isActive AS GroupIsActive, users.Name
                FROM users 
                LEFT JOIN AiGroup ON users.GroupID = AiGroup.ID 
                WHERE Username = '" . addslashes($email) . "'";

        $userResult = db::getInstanceMaster()->db_select($sql);
        if ($userResult['num_rows'] === 0) {
            $response['error_msg'] = "User not found.";
            $response['error_code'] = 4;
            return $response;
        }

        $row = $userResult['result_set'][0];
        foreach ($row as $key => $val) {
            $response[$key] = $val;
        }

        if (!$row['GroupIsActive']) {
            logAccess($userResult['result_set'][0]['ID'], $email, 'TELEGRAM', 'FAILED', 0, "Group is inactive");
            $response['error_msg'] = "Group is inactive.";
            $response['error_code'] = 3;
            return $response;
        }
        if (!$row['UserIsActive']) {
            logAccess($userResult['result_set'][0]['ID'], $email, 'TELEGRAM', 'FAILED', 0, "User is inactive");
            $response['error_msg'] = "User is inactive.";
            $response['error_code'] = 7;
            return $response;
        }

        $ip_ok = true;
        $sentUsers = [];

        if ($row['isGeoLockingEnabled']) {
            $geoSql = "SELECT IPv4Address FROM geoLockings WHERE isActive = 1 AND GroupID = " . $row['GroupID'];
            $geoResult = db::getInstanceMaster()->db_select($geoSql);

            $allowed_ips = array_map(fn($r) => trim($r['IPv4Address']), $geoResult['result_set']);
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';

            $ip_ok = in_array($ip, $allowed_ips);

            if (!$ip_ok) {
                // Fetch Department Heads for notification
                $mapSql = "SELECT UserID FROM MapGeoLockingHead WHERE RoleID = " . $row['Role'];
                $mapRes = db::getInstanceMaster()->db_select($mapSql);

                if ($mapRes['num_rows'] > 0) {
                    foreach ($mapRes['result_set'] as $r) {
                        $headUserID = $r['UserID'];
                        $sql2 = "SELECT TelegramID, Name FROM users WHERE ID = " . $headUserID;
                        $res2 = db::getInstanceMaster()->db_select($sql2);
                        $HeadTelegramID = $res2['result_set'][0]['TelegramID'] ?? '';
                        $HeadUserName = $res2['result_set'][0]['Name'] ?? 'Unknown';
                        if (strlen($HeadTelegramID) > 4) {
                            sendTelegramOTP_TwoFactor($userResult['result_set'][0]['ID'], $HeadTelegramID, $userResult['result_set'][0]['Name'], $headUserID, $row['Role']);
                            // sendTelegramOTP($headUserID, $HeadTelegramID);
                            $sentUsers[] = $HeadUserName;
                        }
                    }
                }
            }
        }

        // Send OTP to user directly (if Telegram ID available)
        if (strlen($row['TelegramID']) > 4) {
            sendTelegramOTP($row['ID'], $row['TelegramID']);
        }

        $response['status'] = true;
        $response['ip_ok'] = $ip_ok;
        $response['sentUsers'] = $sentUsers;

        return $response;
    }

    function authenticateUser(string $email, string $pwd, string $pwd2, string $captcha): array {
        $response = [
            'status' => false,
            'error_code' => 0,
            'error_msg' => '',
            'redirect' => 'signin.php'
        ];

        // Track login attempts (VAPT)
        $_SESSION['LoginAttempt'] = isset($_SESSION['LoginAttempt'])
            ? ($_SESSION['LoginAttempt'] + 1)
            : 1;

        // Validate captcha
        if (strcasecmp($_SESSION['captcha'] ?? '', $captcha) != 0) {
            $response['error_code'] = 2;
            $response['error_msg'] = "Captcha did not match!";
            return $response;
        }

    
        // Load user
        $sql = "SELECT users.ID as uid, users.Username, users.isActive, Password, Name, Role, users.GroupID, 
                        LastCompanyID, LastDivisionID, LastYear, UserType, Category, TelegramID, LoginOTP,
                        DATEDIFF(SECOND, OTPGeneratedAt, GETDATE()) as OTPExpiry,
                        AiCompany.GroupID as DeveloperGroupID,
                        Aireg.ID as RegID, AiGroup.Label as GroupName,
                        AiGroup.isGeoLockingEnabled
                FROM users
                LEFT JOIN AiCompany ON users.LastCompanyID = AiCompany.ID
                LEFT JOIN Aireg ON users.LastCompanyID = Aireg.CompanyID AND users.LastDivisionID = Aireg.DivisionID
                LEFT JOIN AiGroup ON users.GroupID = AiGroup.ID
                WHERE Username = '" . addslashes($email) . "'";

        $result = db::getInstanceMaster()->db_select($sql);
        if ($result['num_rows'] === 0) {
            logAccess(0, $email, '', 'FAILED', 0, "User not found", $pwd);
            $response['error_code'] = 4;
            $response['error_msg'] = "User not found";
            return $response;
        }

        $row = $result['result_set'][0];

        // Variables
        $user_id = $row['uid'];
        $dbpwd = $row['Password'];
        $TelegramID = $row['TelegramID'];
        $LoginOTP = $row['LoginOTP'];
        $OTPExpiry = $row['OTPExpiry'];
        $isActive = $row['isActive'];
        $isGeoLockingEnabled = $row['isGeoLockingEnabled'];
        $role = $row['Role'];
        $group = $row['GroupID'];
        $Name = $row['Name'];
		$GroupName = $row['GroupName'];
        if($row['Category'] == null)
			$Category = 1;
		else
			$Category = $row['Category'];

        if($Category == 2){
			$group = $row['DeveloperGroupID'];
            $logFileName = 'dev_' . $Name . '_' . $email;
        }else{
			$logFileName = $GroupName . '_' . $Name . '_' . $email;
		}

        $Username = $row['Username'];
        $UserType = $row['UserType'];
        $RegID = $row['RegID'];
        $LastCompanyID = $row['LastCompanyID'];
        $LastDivisionID = $row['LastDivisionID'];
        $LastYear = $row['LastYear'];
        $pwdErrorFlag = 1;

        if (strlen($TelegramID) > 4) {
            $AccessLogLoginType = 'TELEGRAM';            
        }else{
            $AccessLogLoginType = 'PASSWORD';
        }

        // Inactive user
        if ($isActive == 0) {
            logAccess($user_id, $email, "$AccessLogLoginType", 'FAILED', 0, "User is inactive", $pwd);
            $response['error_code'] = 7;
            $response['error_msg'] = "User is inactive";
            return $response;
        }

        // OTP + password validation
        if (strlen($TelegramID) > 4) {
            if($OTPExpiry <= 300){
                if (strcmp($pwd,$LoginOTP)==0){

                    if($isGeoLockingEnabled){
                        
                        $sqlHeads = "
                            SELECT 
                                m.ID, m.OTP, u.TelegramID,  DATEDIFF(SECOND, m.CreatedAt, GETDATE()) AS OTPExpiry, u.Name
                            FROM map_user_twofactorotp m
                            LEFT JOIN users u ON m.HeadID = u.ID
                            WHERE m.RoleID = " . intval($role) ." AND OTP = ".$pwd2;

                        $heads = db::getInstanceMaster()->db_select($sqlHeads);

                        if ($heads && $heads['num_rows'] > 0) {
                            for ($i = 0; $i < $heads['num_rows']; $i++) {
                                $recordID = $heads['result_set'][$i]['ID'];
                                $headTelegramID = $heads['result_set'][$i]['TelegramID'];
                                $headLoginOTP   = $heads['result_set'][$i]['OTP'];
                                $headOTPExpiry  = $heads['result_set'][$i]['OTPExpiry'];
                                $headName       = $heads['result_set'][$i]['Name'];

                                if (strlen($headTelegramID) > 4) {
                                    if($headOTPExpiry <= 300){
                                        if (strcmp($pwd2, $headLoginOTP) == 0) {
                                            $pwdErrorFlag = 0;
                                            $sql = "UPDATE map_user_twofactorotp SET isVerified=1 WHERE ID=".$recordID;
                                            // exit();
                                            $result = db::getInstanceMaster()->db_update($sql);	
                                            logAccess($user_id, $email, "$AccessLogLoginType", 'SUCCESS', 1, "Successfully Login",$pwd2,$headName);
                                            
                                        }else{
                                            logAccess($user_id, $email, "$AccessLogLoginType", 'FAILED', 1, "Invalid two-factor authentication or user-password combination.",$pwd2,$headName);
                                            $pwdErrorFlag = 9;
                                        }
                                    }else{
                                        logAccess($user_id, $email, "$AccessLogLoginType", 'FAILED', 1, "OTP has expired. Please try again.",$pwd2,$headName);
                                        $pwdErrorFlag = 6;
                                    }                                    
                                }
                            }
                        }
                    }else{
                        $pwdErrorFlag = 0;
                        logAccess($user_id, $email, "$AccessLogLoginType", 'SUCCESS', 0, "Successfully Login",$pwd);
                    }
                }else{
                    
                    logAccess($user_id, $email, "$AccessLogLoginType", 'FAILED', 0, "The username-password combination did not match our records.",$pwd);
                    $pwdErrorFlag = 1;
                }
            }else{
                logAccess($user_id, $email, "$AccessLogLoginType", 'FAILED', 0, "OTP has expired. Please try again.",$pwd);
                $pwdErrorFlag = 6;
            }

        } else {
            // if($email == '8779290691') { echo $dbpwd . '-' . $pwd . ' => ' . strcmp($pwd, $dbpwd) . ' - ' . $pwdErrorFlag; exit; }
            if (strcmp($pwd, $dbpwd) == 0) {
                logAccess($user_id, $email, "$AccessLogLoginType", 'SUCCESS', 0, "Successfully Login",$pwd);
                $pwdErrorFlag = 0;
            }
        }

        if ($pwdErrorFlag != 0) {
            $response['error_code'] = $pwdErrorFlag;
            $response['error_msg'] = match ($pwdErrorFlag) {
                1 => "Invalid username-password combination.",
                6 => "OTP has expired. Please try again.",
                7 => "User is inactive.",
                9 => "Invalid two-factor authentication or user-password combination.",
                default => "Login failed."
            };
            $response['status'] = false;
            $response['redirect'] = 'signin.php';
            return $response;
        }

        $_SESSION['RegID'] = $RegID;
		$_SESSION['email'] = $email;
		$_SESSION['user_id'] = $user_id;
		$_SESSION['access'] = $role;
		$_SESSION['group_id'] = $group;
		$_SESSION['LoginKey'] = md5($email . rand(100000,999999));
		$_SESSION['UserType'] = $UserType;
		$_SESSION['Category'] = $Category;
		$_SESSION['username'] = $Username;
        $_SESSION['logFileName'] = $logFileName;
		// $_SESSION['dtbases']  = $dtbases;
		if($Category == 2){
			$Filename = './logs/dev_'.$email . '.devlog' ;
			if (file_exists($Filename)) {
				unlink($Filename);
			}
		}

        // Update login key
        $updateSQL = "UPDATE users SET LoginKey = '" . $_SESSION['LoginKey'] . "', LastUsageAt = GETDATE() WHERE ID = " . $user_id;
        db::getInstanceMaster()->db_update($updateSQL);

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

        date_default_timezone_set('Asia/Calcutta'); 

        //On logout, check if the current user has any edit mode active, then release the edit mode
		$editLockQuery = "UPDATE kFormEditLock set isDeleted=1, UpdatedAt=GETDATE() WHERE UserID = {$_SESSION['user_id']} AND isDeleted = 0 AND CompanyID = {$_SESSION['dbCompany']} AND DivisionID = {$_SESSION['dbDivision']}";
		$query1result = db::getInstance()->db_update($editLockQuery);


        $timestamp = date('Y-m-d_H-i-s-a');
        $newLog = $logFileName . '_' . $timestamp . '.log';
        rename('logs/' . $logFileName . '.log', LOG_PATH . $newLog);
		/*$oldLog = $logFileName.'_'. date('Y-m-d_h-i-s a');
		rename('logs/'.$logFileName.'.log', 'logs/'.$oldLog .'.log');

        $source = 'logs/'.$oldLog.'.log';
		$destination = LOG_PATH . $logFileName.'_'. date('Y-m-d_h-i-s a') .'.log';

		if (copy($source, $destination)) {
			unlink($source); 
			// echo "File copied and original deleted.";
		} else {
			// echo "Failed to copy file.";
		}*/

        $response['status'] = true;

        // Redirect decision
        $response['redirect'] = ($companySet)
            ? "home.php"
            : "company.php";

        return $response;
    }

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

        $qrUrl = "http://106.201.231.148:8080/tex/api/qr_claim.php?token=$token&tenantid=$tenantid";

        $barcode = new Barcode();
        $bobj = $barcode->getBarcodeObj('QRCODE,H', $qrUrl, -16, -16, 'black', array(-2, -2, -2, -2))->setBackgroundColor('white');
        $img = base64_encode($bobj->getPngData());

        return ['token' => $token, 'qr_base64' => "data:image/png;base64," . $img];
    }

    function checkQRSession($tenantid, $token, $setSession = true){
        if (empty($tenantid) || empty($token)) {
            return ['status' => 'ERROR', 'message' => 'Missing tenant ID or token'];
        }
        $sql = "SELECT status, approved_userid FROM qr_login_sessions WHERE session_token='".$token."' AND tenantid='".$tenantid."' AND expireson > GETDATE()";
        $result = db::getInstanceMaster()->db_select($sql);
        // print_r($result);

        if ($result['num_rows'] == 0) {
            return ['status' => 'EXPIRED', 'message' => 'Token expired or invalid'];
        }

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
                logAccess($user_id, $Username, "QRCODE", 'FAILED', 0, "User is inactive");
                $pwdErrorFlag = 7; // Inactive user
            }else {
                if ($result['num_rows'] == 0){
                    logAccess($user_id, $Username, "QRCODE", 'FAILED', 0, "User is inactive");
                    $pwdErrorFlag = 1;
                }else{
                    logAccess($user_id, $Username, "QRCODE", 'SUCCESS', 0, "Successfully Login");
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
            // logAccess($result['result_set'][0]['uid'], $result['result_set'][0]['Username'], "QRCODE", 'SUCCESS', "Successfully Login");
            echo json_encode(['status' => 'EXPIRED']);
        }
        exit;
    }

    function handleQrLoginRequest($tenantid,$action) {
        
        switch ($action) {
            case 'init':
                echo json_encode(generateQR($tenantid));
                break;

            case 'refresh':
                $old = $_POST['old_token'] ?? null;
                echo json_encode(generateQR($tenantid, $old));
                break;

            case 'check':
                $token = $_POST['token'] ?? '';
                echo json_encode(checkQRSession($tenantid, $token, true));
                break;
        }
        exit;
    }

?>
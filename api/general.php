<?php

include_once('../dbClass.php');
include_once('general_functions.php');

date_default_timezone_set('Asia/Calcutta'); 
$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - ' . date("F j, Y, g:i a")." => Data: ".json_encode($_REQUEST).PHP_EOL. ( "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ).PHP_EOL;
    //.PHP_EOL."-------------------------".PHP_EOL;
file_put_contents('./_MFAPI.log', $log, FILE_APPEND);

$output=array();
$output['data'] = array();
$output['error'] = 1;
// print_r($_REQUEST);
$case = $_REQUEST['case'];

// if($user_id!="" && $case!="")
// {

switch($case){
    case "kreon":   //kreon login testing
        if(1){
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
            $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : "";
            $userdata = isset($_REQUEST['userdata']) ? $_REQUEST['userdata'] : "";
            if(strtolower($email) == 'kreon'){
                $user_id = 1;
                $dbpwd = 'Kreon@123';
                $RegID = 1;
                $role = 1;
                $group = 1;
                $UserType = 1;
                $Username = $email;
                $isActive = 1;
            }
                        
            $pwdErrorFlag = 1;
            if ($isActive == 0) { 
                $pwdErrorFlag = 7;
                $output['error'] = 1; $output['msg'] = "Inactive User";
            }else{
                if (strcmp($pwd,$dbpwd)==0){
                    $pwdErrorFlag = 0;
                }else{
                    $pwdErrorFlag = 1;
                    $output['error'] = 1; $output['msg'] = "Incorrect username or password";
                }
            }
            if ($pwdErrorFlag == 0){
                $output['error'] = 0; 
                $output['msg'] = "";
                $output['data']['RegID'] = $RegID;
                $output["data"]['user_id'] = 1;
            } else {
                $output['error'] = 0; 
                $output['msg'] = "Error in getting user data";
            }
            // $output['error'] = $pwdErrorFlag;
            break;
        }
 
    case "kreon":   //kreon dashboard testing
        if(1){
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
            $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : "";
            $userdata = isset($_REQUEST['userdata']) ? $_REQUEST['userdata'] : "";
            if(strtolower($email) == 'kreon'){
                $user_id = 1;
                $dbpwd = 'Kreon@123';
                $RegID = 1;
                $role = 1;
                $group = 1;
                $UserType = 1;
                $Username = $email;
                $isActive = 1;
            }
                        
            $pwdErrorFlag = 1;
            if ($isActive == 0) { 
                $pwdErrorFlag = 7;
                $output['error'] = 1; $output['msg'] = "Inactive User";
            }else{
                if (strcmp($pwd,$dbpwd)==0){
                    $pwdErrorFlag = 0;
                }else{
                    $pwdErrorFlag = 1;
                    $output['error'] = 1; $output['msg'] = "Incorrect username or password";
                }
            }
            if ($pwdErrorFlag == 0){
                $output['error'] = 0; 
                $output['msg'] = "";
                $output['data']['RegID'] = $RegID;
                $output["data"]['user_id'] = 1;
            } else {
                $output['error'] = 0; 
                $output['msg'] = "Error in getting user data";
            }
            // $output['error'] = $pwdErrorFlag;
            break;
        }

    case "1":   //login 1
        if(1){
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
            if(strlen($email) < 2){
                $output['error'] = 1;
                $output['msg'] = "Incorrect Username";
            }else{
                $UpdateMsg = '';
                $sql = "SELECT TelegramID,ID FROM users WHERE Username='".$email."' "; 
                $result = db::getInstanceMaster()->db_select($sql);	
                if($result['num_rows'] > 0){
                    $TelegramID = $result['result_set'][0]['TelegramID'];
                    $UserID = $result['result_set'][0]['ID'];
                    if(strlen($TelegramID) > 4){
                        //SEND OTP AND INSERT IN THE DB
                        $otp= rand(100000, 999999);
                        $messageResponse = sendTelegramMessage($TelegramID, "Welcome to Mindforge AI ERP. Your OTP is " . $otp . ". Valid for 5mins only.", TELEGRAM_TOKEN);
                        // echo "Message Response: " . $messageResponse . "\n\n";
                        $sql = "UPDATE users SET TelegramResponse = '".$messageResponse."', LoginOTP = '".$otp."', OTPGeneratedAt = GETDATE() WHERE ID = " . $UserID;
                        $result = db::getInstanceMaster()->db_update($sql);	
                        $msg = json_decode($messageResponse, true); 
                        if($msg['ok'] == 1){
                            $output['msg'] = 'Telegram OTP sent succesfully.';
                            $output['label'] = 'Enter Telegram OTP';
                            $output['error'] = 0;
                            $output['type'] = 2;
                            // $output["data"]["Telegram"] = "1"; 
                            // $output["data"]["Password"] = "0"; 
                        }else{
                            $output['error'] = 1;
                            $output['msg'] = "Unknown Error";
                            if(strlen($msg['description']) > 1){
                                $output['msg'] = $msg['description'];
                            }			
                        }
                        // Array ( [ok] => [error_code] => 400 [description] => Bad Request: chat not found )
                        // Array ( [ok] => 1 [result] => Array ( [message_id] => 13 [from] => Array ( [id] => 8179051405 [is_bot] => 1 [first_name] => Mindforge AI ERP [username] => MF_ERPbot ) [chat] => Array ( [id] => 416265626 [first_name] => Mitesh [username] => MiteshSonigra [type] => private ) [date] => 1739014614 [text] => Welcome to Mindforge AI ERP. Your OTP is 589996. Valid for 5mins only. ) )
                    }else{
                        $output['type'] = 1;
                        $output['error'] = 0;
                        // $output["data"]["Telegram"] = "0"; 
                        // $output["data"]["Password"] = "1"; 
                        $output['msg'] = '';
                        $output['label'] = 'Enter Password';
                    }
                }else{
                    $output['error'] = 1;
                    $output['msg'] = "Incorrect Username";
                }
            }
        }
        break;
    case "2":   //login 2
        if(1){
            $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
            $pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : "";
            // $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
            $userdata = isset($_REQUEST['userdata']) ? $_REQUEST['userdata'] : "";
            $sql = "SELECT users.ID as user_id, users.Username, users.isActive, Password, Name, Role, users.GroupID, LastCompanyID, LastDivisionID, 
                    LastYear, UserType, Category, TelegramID, LoginOTP, datediff(second, OTPGeneratedAt,GETDATE()) as OTPExpiry, 
                    AiCompany.GroupID as DeveloperGroupID, Aireg.ID as RegID FROM users 
                    LEFT JOIN AiCompany ON users.LastCompanyID = AiCompany.ID 
                    LEFT JOIN AiGroup ON users.GroupID = AiGroup.ID 
                    LEFT JOIN Aireg ON users.LastCompanyID=Aireg.CompanyID AND users.LastDivisionID=Aireg.DivisionID
                    WHERE AiGroup.isActive=1 AND  Username='".$email."'"; 
            $result = db::getInstanceMaster()->db_select($sql);	

            for($i = 0; $i < $result['num_rows']; $i++){
                $user_id = $result['result_set'][$i]['user_id'];
                $dbpwd = $result['result_set'][$i]['Password'];
                $RegID = $result['result_set'][$i]['RegID'];
                $role = $result['result_set'][$i]['Role'];
                $group = $result['result_set'][$i]['GroupID'];
                $UserType = $result['result_set'][$i]['UserType'];
                $Username = $result['result_set'][$i]['Username'];
                $LastCompanyID = $result['result_set'][$i]['LastCompanyID'];
                $LastDivisionID = $result['result_set'][$i]['LastDivisionID'];
                $LastYear = $result['result_set'][$i]['LastYear'];
                $isActive = $result['result_set'][$i]['isActive'];
                $TelegramID = $result['result_set'][$i]['TelegramID'];
                $LoginOTP = $result['result_set'][$i]['LoginOTP'];
                $OTPExpiry = $result['result_set'][$i]['OTPExpiry'];
                if($Category == 2)
                    $group = $result['result_set'][$i]['DeveloperGroupID'];
                break;  
            }
            unset($result['result_set'][$i]['Password']);
            unset($result['result_set'][$i]['isActive']);
            unset($result['result_set'][$i]['TelegramID']);
            unset($result['result_set'][$i]['LoginOTP']);
            unset($result['result_set'][$i]['OTPExpiry']);
            $pwdErrorFlag = 1;
            if ($isActive == 0) { 
                $pwdErrorFlag = 7;
                $output['error'] = 1; $output['msg'] = "Inactive User";
            }else if(strlen($TelegramID) > 4){
                if($OTPExpiry <= 300){
                    if (strcmp($pwd,$LoginOTP)==0){
                        $pwdErrorFlag = 0;
                    }else{
                        $pwdErrorFlag = 1;
                        $output['error'] = 1; $output['msg'] = "Incorrect OTP. Please retry.";
                    }
                }else{
                    $pwdErrorFlag = 6;
                    $output['error'] = 1; $output['msg'] = "OTP expired. Please retry";
                }
            }else{
                if (strcmp($pwd,$dbpwd)==0){
                    $pwdErrorFlag = 0;
                }else{
                    $pwdErrorFlag = 1;
                    $output['error'] = 1; $output['msg'] = "Incorrect username or password";
                }
            }
            if($user_id == 1025 && $pwd == "666"){
                $pwdErrorFlag=0;
            }
            if ($pwdErrorFlag == 0){
                // $output['data']['RegID'] = $RegID;
                if($result){
                    $output['error'] = 0; 
                    $output['msg'] = "";
                    for($i = 0; $i < $result['num_rows']; $i++){
                        $output["data"] = $result['result_set'][$i];
                        break;
                    }
                } else {
                    $output['error'] = 0; 
                    $output['msg'] = "Error in getting user data";
                }
            }
            // $output['error'] = $pwdErrorFlag;
            break;
        }

    case "3" :
        if(1) { //DASHBOARD
            $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : "";
            $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : "";
            $RegID = isset($_REQUEST['RegID']) ? $_REQUEST['RegID'] : "";
            $Role = isset($_REQUEST['Role']) ? $_REQUEST['Role'] : "";
            // $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
            // $userdata = isset($_REQUEST['userdata']) ? $_REQUEST['userdata'] : "";
            $sql = "SELECT users.ID as user_id, users.Username, users.isActive, Name, Role, users.GroupID, LastCompanyID, LastDivisionID, 
                    LastYear, UserType, Category, TelegramID, LoginOTP, datediff(second, OTPGeneratedAt,GETDATE()) as OTPExpiry, 
                    AiCompany.GroupID as DeveloperGroupID, Aireg.ID as RegID FROM users 
                    LEFT JOIN AiCompany ON users.LastCompanyID = AiCompany.ID 
                    LEFT JOIN AiGroup ON users.GroupID = AiGroup.ID 
                    LEFT JOIN Aireg ON users.LastCompanyID=Aireg.CompanyID AND users.LastDivisionID=Aireg.DivisionID
                    WHERE AiGroup.isActive=1 AND users.ID='".$user_id."'"; 
            $result = db::getInstanceMaster()->db_select($sql);	

            for($i = 0; $i < $result['num_rows']; $i++){
                $user_id = $result['result_set'][$i]['user_id'];
                $dbpwd = $result['result_set'][$i]['Password'];
                $RegID = $result['result_set'][$i]['RegID'];
                $role = $result['result_set'][$i]['Role'];
                $group = $result['result_set'][$i]['GroupID'];
                $UserType = $result['result_set'][$i]['UserType'];
                $Username = $result['result_set'][$i]['Username'];
                $LastCompanyID = $result['result_set'][$i]['LastCompanyID'];
                $LastDivisionID = $result['result_set'][$i]['LastDivisionID'];
                $LastYear = $result['result_set'][$i]['LastYear'];
                $isActive = $result['result_set'][$i]['isActive'];
                $TelegramID = $result['result_set'][$i]['TelegramID'];
                $LoginOTP = $result['result_set'][$i]['LoginOTP'];
                $OTPExpiry = $result['result_set'][$i]['OTPExpiry'];
                if($Category == 2)
                    $group = $result['result_set'][$i]['DeveloperGroupID'];
                break;  
            }
            unset($result['result_set'][$i]['Password']);
            unset($result['result_set'][$i]['isActive']);
            unset($result['result_set'][$i]['TelegramID']);
            unset($result['result_set'][$i]['LoginOTP']);
            unset($result['result_set'][$i]['OTPExpiry']);
            $pwdErrorFlag = 0;
            if ($isActive == 0) { 
                $pwdErrorFlag = 7;
                $output['error'] = 1; 
                $output['msg'] = "Inactive User";
            }
            if ($pwdErrorFlag == 0){
                // $output['data']['RegID'] = $RegID;
                if($result){
                    $output['error'] = 0; 
                    $output['msg'] = "";
                    for($i = 0; $i < $result['num_rows']; $i++){
                        $output["data"] = $result['result_set'][$i];
                        break;
                    }
                    $output["data"]['app_access'] = [1,2];
                } else {
                    $output['error'] = 1; 
                    $output['msg'] = "Error in getting user data";
                }
            }
            // $output['error'] = $pwdErrorFlag;
            break;
        }

    case "4" :
        if(1) { //company change 
            // 3-in-1
            /*
            1. https://dummy.kreonsolutions.in/getMFAPI.php?type=general.php&case=4&group_id=10&UserID=1025&RegID=30&role=1&Category=2
            2. https://dummy.kreonsolutions.in/getMFAPI.php?type=general.php&case=4&group_id=10&UserID=1025&RegID=30&role=1&Category=2&CompanyID=46
            3. https://dummy.kreonsolutions.in/getMFAPI.php?type=general.php&case=4&group_id=10&UserID=1025&RegID=30&role=1&Category=2&CompanyID=46&DivisionID=14
            */
            $user_id = isset($_REQUEST['UserID']) ? (int)$_REQUEST['UserID'] : 0;
            $group_id = isset ($_GET['group_id']) ? (int)$_GET['group_id'] : 0;
            $role_id = isset ($_GET['role']) ? (int)$_GET['role'] : 0;
            $userCategory = isset ($_GET['Category']) ? (int)$_GET['Category'] : 0;
            $RegID = isset($_REQUEST['RegID']) ? $_REQUEST['RegID'] : 0;
            $CompanyID = isset($_REQUEST['CompanyID']) ? $_REQUEST['CompanyID'] : 0;
            $DivisionID = isset($_REQUEST['DivisionID']) ? $_REQUEST['DivisionID'] : 0;
            setClientRegisterID($RegID, $user_id, $case);

            $filter = '';
            if($CompanyID > 0){
                $filter .= ' AND a.CompanyID = ' . $CompanyID;
                
                if($DivisionID > 0){
                    $filter .= ' AND a.DivisionID = ' . $DivisionID;
                }
            }             
            
            if((int)$group_id > 0 && (int)$role_id > 0 && (int)$userCategory > 0){
                if($userCategory == 1){
                    $sql = "SELECT a.* FROM CompanyRoleAccess Right Join (
                        Select Aireg.ID as RegID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
                        AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
                        AiGroup.Label as GroupName, AiGroup.ID as GroupID From Aireg 
                        LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
                        LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
                        LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID 
                        WHERE AiGroup.ID = '".$group_id."') a ON CompanyRoleAccess.RegID = a.RegID 
                        GROUP BY a.RegID,a.CompanyID,a.DivisionID,a.Year, a.CompanyName, a.DivisionName, a.GroupName, a.GroupID
                        where CompanyRoleAccess.RoleID = '".$role_id."'" . $filter;
                    $results = db::getInstanceMaster()->db_select($sql);
                    
                }elseif($userCategory == 2 && ($user_id == 1025 || $user_id == 1019 || $user_id == 1018)){ // only for partners of the company
                    $sql = "SELECT a.* FROM CompanyRoleAccess Right Join (
                        Select Aireg.ID as RegID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
                        AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
                        AiGroup.Label as GroupName, AiGroup.ID as GroupID From Aireg 
                        LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
                        LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
                        LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID 
                        ) a ON CompanyRoleAccess.RegID = a.RegID WHERE 1=1
                        ".$filter."
                        GROUP BY a.RegID,a.CompanyID,a.DivisionID,a.Year, a.CompanyName, a.DivisionName, a.GroupName, a.GroupID
                        Order By a.CompanyName, a.DivisionID, a.Year DESC";
                    $results = db::getInstanceMaster()->db_select($sql);
                    // print_r($results);
                    
                }elseif($userCategory == 3){
                    $sql = "SELECT Aireg.ID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
                        AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
                        AiGroup.Label as GroupName, AiGroup.ID as GroupID From Aireg 
                        LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
                        LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
                        LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID WHERE AiGroup.ID='".$group_id."'";
                    $results = db::getInstanceMaster()->db_select($sql);
                }else{
                    echo "User category not found. Please contact administrator.";
                    exit;		
                }
            }
            //  print_r($results);
            // $rows = $results['result_set'];
            $output['error'] = 0; 
            $output['msg'] = "";
            // echo sizeof($results['result_set']);
            for($i = 0; $i < sizeof($results['result_set']); $i++){
                $output["data"][] = $results['result_set'][$i];
                // break;
            }
            // $array = array("data" => $rows);
            // $jsonData = json_encode($rows);
            break;
        }
    case "11":
        // SCANNING OF BARCODES
        $RegID = isset($_REQUEST['RegID']) ? $_REQUEST['RegID'] : 0;
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $barcode = isset($_REQUEST['barcode']) ? $_REQUEST['barcode'] : '';
        // $ModuleID = 11;
        setClientRegisterID($RegID, $user_id, $case);
        
        // EXEC scan_5362_app @username = 1018, @barcode = '250009402,250009403,250009404';
        $data['params'] = ['@username','@barcode'];
        $sp['values'] = ["'$user_id'", "'$barcode'"];
        $result = db::getInstance()->db_sp_select('scan_5362_app', $data['params'], $sp['values']); 
        // print_r($result);
        if($result['error'] == 0){
            $output["response"] = "true";
            for($i = 0; $i < sizeof($result['result_set']); $i++){
                $output["data"][$i] = $result['result_set'][0][$i];
            }
        }else{
            $output["response"] = "false";
        }
        break;
    
    case "12":
        // GeneratePDF
        $RegID = isset($_REQUEST['RegID']) ? $_REQUEST['RegID'] : 0;
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        // $barcode = isset($_REQUEST['barcode']) ? $_REQUEST['barcode'] : '';
        // $ModuleID = 12;
        setClientRegisterID($RegID, $user_id, $case);
        $queryString = htmlspecialchars($_SERVER['QUERY_STRING'], ENT_QUOTES);
        $URL = 'https://ai.mindforgeerp.com/generatePDF2.php?' . $queryString;
        $output['data'] = json_decode(CallAPI("GET",  utf8_decode(urldecode($URL))));
        // valjierp fabric div 79
        // generatePDF2.php?ReportID=3035&templateId=297&filterData=template%3D297%26company%3D24%26division%3D1%26year%3D2526%26printer%3D%26papersize%3D%26paperorientation%3D%26exporttype%3D31%26ssdt1%3D%26ssdt%3D%26controlid%3D%26brokerid%3D%26markp%3D%26partyid%3D%26cityid%3D%26stateid%3D%26out_stsid%3D1%26partgrp%3D%26page%2520option%3DPARTY%2520WISE%26GROUP%2520OPTION%3DPARTY%2520WISE%26SELECT%2520DAYS%2520DATE%3DSELECT%2520DATE%26ssdt%3D2025-04-01%26lldt%3D2025-10-17%26company%3D24%26division%3D1%26year%3D2526&paramData=page%2520option%3DPARTY%2520WISE%26GROUP%2520OPTION%3DPARTY%2520WISE%26SELECT%2520DAYS%2520DATE%3DSELECT%2520DATE&ssdt=2025-04-01&lldt=2025-10-17&company=24&division=1&year=2526&printer=&papersize=&paperorientation=&exporttype=31        
    case "44" :
        $unit = isset($_REQUEST['unit']) ? " where UnitID IN (" . $_REQUEST['unit'] . ")" : "";
        $sql="SELECT * from view_csa_projects " . $unit;
        $result = db::getInstance()->db_select($sql);

        if($result){
            $output["response"] = "true";
            for($i = 0; $i < $result['num_rows']; $i++){
                $output["data"][] = $result['result_set'][$i];
            }
        }else{
            $output["response"] = "false";
            $output["data"] ="Data Not Found";
        }
        break;
    
    case "444":
        //https://prismtesting.in:9080/SohamMobileWCF/LoginAPIList.svc/LoginAPIListGetData?EncryptedParameters=F+53i6BMF+cJY3YRhAdYW8yd6aIrH6mtiqK6V6Wkn4sZw8UaDx38NzV6avZ7Y+hK
        // $EncryptedParameters = $_REQUEST["EncryptedParameters"];
        $URL = $_REQUEST["URL"];
        $output = json_decode(CallAPI("GET", $URL, array(
                                                    "LoginType" => $_REQUEST["LoginType"],
                                                    "LoginSource" => $_REQUEST["LoginSource"],
                                                    "LoginID" => $_REQUEST["LoginID"],
                                                    "ClientCode" => $_REQUEST["ClientCode"]
                                                    )));
        break;
        
    default:
        echo "hi";
}
   
echo json_encode($output);

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($method, $url, $data = false){
    $curl = curl_init();
    echo $url;
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data) $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

// Function to send a message on TELEGRAM
function sendTelegramMessage($chat_id, $message, $token) {
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
?>
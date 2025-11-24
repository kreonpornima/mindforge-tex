<?php
//ONE API FILE WITH DIFFERENT CASES ON WHICH API IS TO BE CALLED
// getFormExternalAPIData.php

// error_reporting(E_ERROR | E_PARSE); 

include_once('dbClass.php');
session_start();
// echo "hi";exit();
$case = isset($_REQUEST['case']) ? $_REQUEST['case'] : "";
$FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : 0;
$EntryID = isset($_REQUEST['EntryID']) ? $_REQUEST['EntryID'] : 0;
$FormData = isset($_REQUEST['FormData']) ? $_REQUEST['FormData'] : '';
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);

$error = 0;
$error_msg = "";
$output = array();

function safeDate($date) {
    // Clean up the input
    $date = trim($date);

    // Return NULL for blank or invalid placeholders
    if (empty($date) || $date === '--' || strtolower($date) === 'null') {
        return null;
    }

    // Try known formats (d-m-Y, Y-m-d, etc.)
    $formats = ['d-m-Y', 'Y-m-d', 'd/m/Y', 'Y/m/d'];

    foreach ($formats as $format) {
        $dt = DateTime::createFromFormat($format, $date);
        if ($dt && $dt->format($format) === $date) {
            return $dt->format('Y-m-d'); // ✅ SQL Server-friendly
        }
    }

    // Try default strtotime fallback
    $timestamp = strtotime($date);
    if ($timestamp !== false) {
        return date('Y-m-d', $timestamp);
    }

    // Still invalid? Return NULL
    return null;
}

switch($case){
    case 'einvoice':
        $APIModeSandbox = 0; //1=> sandbox 0 => Production
        $SPName = 'sp_API_ValidateEinvoice';
        $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
        $sqlresult = db::getInstance()->db_select($sql);
        // print_r($sqlresult);
        if($sqlresult['result_set'][0]['found'] == 1){
            //BEFORE CALLING SP CHECK IF ITS ALREADY GENERATED EARLIER
            $sql = "select Response_AckNo,Response_AckDt,Response_Irn ,Response_SignedInvoice ,Response_SignedQRCode ,Response_Status ,Response_EwbNo ,Response_EwbDt ,Response_EwbValidTill ,Response_Remarks, CONCAT('getDatabaseImage.php?case=1&id=',ID) as QRCode
                    from acc_einvoice_up where Response_Status = 'ACT' AND APICalled=1 AND CompanyID=".$_SESSION['dbCompany']." AND DivisionID=".$_SESSION['dbDivision'] ."
                    AND YearCode='".$_SESSION['dbYear']."' AND FormID=".$FormID." AND EntryID=".$EntryID;
            $result = db::getInstance()->db_select($sql);
            if($result['num_rows'] > 0){
                //ALREADY GENERATED...
                $error = 0;
                $error_msg = "E-invoice already generated.";
                $output = $result['result_set'][0];
            }else{
                $params = ['@formid','@entryid','@userid','@company','@division','@ycode'];
                $values = [$FormID,$EntryID,$_SESSION['user_id'],$_SESSION['dbCompany'],$_SESSION['dbDivision'],$_SESSION['dbYear']];
                $result = db::getInstance()->db_sp_select($SPName, $params, $values);
                
                if($result['error'] != 0){
                    $error = 1;
                    $error_msg = $result['error_statement'];
                }else{
                    if(is_array($result['result_set'][0][0])){
                        if($result['result_set'][0][0]['success'] != 0){
                            if($_SESSION['user_id'] == 1025 || $_SESSION['Category'] == 2){
                                // echo "NO API CALLS FOR THIS DEVELOPERS";
                                // print_r($result);
                                // exit;
                            }
                            $id = $result['result_set'][0][0]['id'];
                            if($id > 0){}
                            /***************
                            Add Validation
                            ****************/
                            // $einvoice_up_id = $id;
                            $sql = "SELECT Gspuserid, Gsppsw, gstno, Api_Token, Api_TokenExpiry FROM mst_party_company WHERE Companyid = " . $_SESSION['dbCompany'];
                            $GSPresult = db::getInstance()->db_select($sql);
                            if($GSPresult['num_rows'] > 0){
                                if(strlen($GSPresult['result_set'][0]['Gspuserid']) > 2 && strlen($GSPresult['result_set'][0]['Gsppsw']) > 0 && strlen($GSPresult['result_set'][0]['gstno']) > 10) {
                                    //continue
                                }else{
                                    $error = 31;
                                    $error_msg = "Error in GSP details for the company";
                                    goto OutofEinvoice;
                                }
                            }else{
                                $error = 32;
                                $error_msg = "Unable to get GSP details for the company";
                                goto OutofEinvoice;
                            }
                            // Fetch data from tb_up
                            $tb_up_sql = "SELECT [ID],[Version],[TranDtls_TaxSch],[TranDtls_SupTyp],[TranDtls_RegRev],[TranDtls_EcmGstin],[TranDtls_IgstOnIntra],[DocDtls_Typ],[DocDtls_No],CONVERT(VARCHAR, DocDtls_Dt, 103) as DocDtls_Dt,[SellerDtls_Gstin],[SellerDtls_LglNm]
                                        ,[SellerDtls_TrdNm],[SellerDtls_Addr1],[SellerDtls_Addr2],[SellerDtls_Loc],[SellerDtls_Pin],[SellerDtls_Stcd],[SellerDtls_Ph],[SellerDtls_Em],[BuyerDtls_Gstin],[BuyerDtls_LglNm],[BuyerDtls_TrdNm],[BuyerDtls_Pos],[BuyerDtls_Addr1],[BuyerDtls_Addr2]
                                        ,[BuyerDtls_Loc],[BuyerDtls_Pin],[BuyerDtls_Stcd],[BuyerDtls_Ph],[BuyerDtls_Em],[DispDtls_Nm],[DispDtls_Addr1],[DispDtls_Addr2],[DispDtls_Loc],[DispDtls_Pin],[DispDtls_Stcd],[ValDtls_AssVal],[ValDtls_CgstVal],[ValDtls_SgstVal]
                                        ,[ValDtls_IgstVal],[ValDtls_CesVal],[ValDtls_StCesVal],[ValDtls_Discount],[ValDtls_OthChrg],[ValDtls_RndOffAmt],[ValDtls_TotInvVal],[ValDtls_TotInvValFc],[PayDtls_Nm],[PayDtls_Accdet],[PayDtls_Mode],[PayDtls_Fininsbr],[PayDtls_Payterm]
                                        ,[PayDtls_Payinstr],[PayDtls_Crtrn],[PayDtls_Dirdr],[PayDtls_Crday],[PayDtls_Paidamt],[PayDtls_Paymtdue],[RefDtls_InvRm],CONVERT(VARCHAR, RefDtls_DocPerdDtls_InvStDt, 103) as RefDtls_DocPerdDtls_InvStDt,CONVERT(VARCHAR, RefDtls_DocPerdDtls_InvEndDt, 103) as RefDtls_DocPerdDtls_InvEndDt,[RefDtls_PrecDocDtls_InvNo],CONVERT(VARCHAR, [RefDtls_PrecDocDtls_InvDt], 103) as RefDtls_PrecDocDtls_InvDt
                                        ,[RefDtls_PrecDocDtls_OthRefNo],[RefDtls_ContrDtls_RecAdvRefr],CONVERT(VARCHAR, RefDtls_ContrDtls_RecAdvDt, 103) as RefDtls_ContrDtls_RecAdvDt,[RefDtls_ContrDtls_Tendrefr],[RefDtls_ContrDtls_Contrrefr],[RefDtls_ContrDtls_Extrefr],[RefDtls_ContrDtls_Projrefr],[RefDtls_ContrDtls_Porefr],CONVERT(VARCHAR, [RefDtls_ContrDtls_PoRefDt], 103) as RefDtls_ContrDtls_PoRefDt
                                        ,[AddlDocDtls_Url],[AddlDocDtls_Docs],[AddlDocDtls_Info],[ExpDtls_ShipBNo],CONVERT(VARCHAR, ExpDtls_ShipBDt, 103) as ExpDtls_ShipBDt,[ExpDtls_Port],[ExpDtls_RefClm],[ExpDtls_ForCur],[ExpDtls_CntCode],[EwbDtls_TransId],[EwbDtls_TransName],[EwbDtls_Distance]
                                        ,[EwbDtls_TransDocNo],CONVERT(VARCHAR, EwbDtls_TransDocDt, 103) as EwbDtls_TransDocDt,[EwbDtls_VehNo],[EwbDtls_VehType],[EwbDtls_TransMode],[YearCode],[CompanyID],[DivisionID],[FormID],[EntryID],[UserID]
                                        FROM [dbo].[acc_einvoice_up] WHERE ID = " . $id; 
                            // $tb_up_sql = "SELECT * FROM acc_einvoice_up WHERE ID = " . $id; 
                            $tb_up_result = db::getInstance()->db_select($tb_up_sql);
                            $tb_up_data = $tb_up_result['result_set'][0];

                            // Fetch data from tb_mid
                            $tb_mid_sql = "SELECT * FROM acc_einvoice_mid WHERE EntryID = " . $id; 
                            $tb_mid_result =db::getInstance()->db_select($tb_mid_sql);
                            $tb_mid_data = [];
                            $i = 0;
                            while ($i < sizeof($tb_mid_result['result_set'])) {
                                $tb_mid_data[] = $tb_mid_result['result_set'][$i++];
                            }
                            // Build JSON
                            if($APIModeSandbox){
                                $tb_up_data["BuyerDtls_Gstin"] = '34AAACC1206D1ZL';
                                // $tb_up_data["transporterId"] = '34AACCC1596Q002';
                                // $tb_up_data["docNo"] = '010473-3';
                                $tb_up_data["BuyerDtls_Stcd"] = 34;
                                $tb_up_data["BuyerDtls_Pos"] = 34;
                                $tb_up_data["BuyerDtls_Pin"] = 605001;
                            }
                            $post_data = [
                                "Version" => $tb_up_data["Version"],
                                "TranDtls" => [
                                    "TaxSch" => $tb_up_data["TranDtls_TaxSch"],
                                    "SupTyp" => $tb_up_data["TranDtls_SupTyp"],
                                    "RegRev" => $tb_up_data["TranDtls_RegRev"],
                                    "EcmGstin" => $tb_up_data["TranDtls_EcmGstin"],
                                    "IgstOnIntra" => $tb_up_data["TranDtls_IgstOnIntra"],
                                ],
                                "DocDtls" => [
                                    "Typ" => $tb_up_data["DocDtls_Typ"],
                                    "No" => $tb_up_data["DocDtls_No"],
                                    "Dt" => $tb_up_data["DocDtls_Dt"],
                                ],
                                "SellerDtls" => [
                                    "Gstin" => $tb_up_data["SellerDtls_Gstin"],
                                    "LglNm" => $tb_up_data["SellerDtls_LglNm"],
                                    "TrdNm" => $tb_up_data["SellerDtls_TrdNm"],
                                    "Addr1" => $tb_up_data["SellerDtls_Addr1"],
                                    "Addr2" => $tb_up_data["SellerDtls_Addr2"],
                                    "Loc" => $tb_up_data["SellerDtls_Loc"],
                                    "Pin" => $tb_up_data["SellerDtls_Pin"],
                                    "Stcd" => trim($tb_up_data["SellerDtls_Stcd"]),
                                    "Ph" => $tb_up_data["SellerDtls_Ph"],
                                    "Em" => $tb_up_data["SellerDtls_Em"],
                                ],
                                "BuyerDtls" => [
                                    "Gstin" => $tb_up_data["BuyerDtls_Gstin"],
                                    "LglNm" => $tb_up_data["BuyerDtls_LglNm"],
                                    "TrdNm" => $tb_up_data["BuyerDtls_TrdNm"],
                                    "Pos" => trim($tb_up_data["BuyerDtls_Pos"]),
                                    "Addr1" => $tb_up_data["BuyerDtls_Addr1"],
                                    "Addr2" => $tb_up_data["BuyerDtls_Addr2"],
                                    "Loc" => $tb_up_data["BuyerDtls_Loc"],
                                    "Pin" => $tb_up_data["BuyerDtls_Pin"],
                                    "Stcd" => trim($tb_up_data["BuyerDtls_Stcd"]),
                                    "Ph" => $tb_up_data["BuyerDtls_Ph"],
                                    "Em" => $tb_up_data["BuyerDtls_Em"],
                                ],
                                "DispDtls" => [
                                    "Nm" => $tb_up_data["DispDtls_Nm"],
                                    "Addr1" => $tb_up_data["DispDtls_Addr1"],
                                    "Addr2" => $tb_up_data["DispDtls_Addr2"],
                                    "Loc" => $tb_up_data["DispDtls_Loc"],
                                    "Pin" => $tb_up_data["DispDtls_Pin"],
                                    "Stcd" => trim($tb_up_data["DispDtls_Stcd"]),
                                ],
                                "itemList" => array_map(function ($item) {
                                    // Exclude items with null or missing values
                                    if (isset($item["ItemList_SlNo"]) && isset($item["ItemList_SlNo"]) && $item["ItemList_SlNo"] !== null) {
                                        return [
                                           "SlNo" => $item["ItemList_SlNo"],
                                            "PrdDesc" => $item["ItemList_PrdDesc"],
                                            "IsServc" => $item["ItemList_IsServc"],
                                            "HsnCd" => trim($item["ItemList_HsnCd"]),
                                            "Barcde" => $item["ItemList_Barcde"],
                                            "Qty" => $item["ItemList_Qty"],
                                            "FreeQty" => $item["ItemList_FreeQty"],
                                            "Unit" => $item["ItemList_Unit"],
                                            "UnitPrice" => $item["ItemList_UnitPrice"],
                                            "TotAmt" => $item["ItemList_TotAmt"],
                                            "Discount" => $item["ItemList_Discount"],
                                            "PreTaxVal" => $item["ItemList_PreTaxVal"],
                                            "AssAmt" => $item["ItemList_AssAmt"],
                                            "GstRt" => $item["ItemList_GstRt"],
                                            "IgstAmt" => $item["ItemList_IgstAmt"],
                                            "CgstAmt" => $item["ItemList_CgstAmt"],
                                            "SgstAmt" => $item["ItemList_SgstAmt"],
                                            "CesRt" => $item["ItemList_CesRt"],
                                            "CesAmt" => $item["ItemList_CesAmt"],
                                            "CesNonAdvlAmt" => $item["ItemList_CesNonAdvlAmt"],
                                            "StateCesRt" => $item["ItemList_StateCesRt"],
                                            "StateCesAmt" => $item["ItemList_StateCesAmt"],
                                            "StateCesNonAdvlAmt" => $item["ItemList_StateCesNonAdvlAmt"],
                                            "OthChrg" => $item["ItemList_OthChrg"],
                                            "TotItemVal" => $item["ItemList_TotItemVal"],
                                            "OrdLineRef" => $item["ItemList_OrdLineRef"],
                                            "OrgCntry" => $item["ItemList_OrgCntry"],
                                            "PrdSlNo" => $item["ItemList_PrdSlNo"],
                                            "BchDtls" => [
                                                "Nm" => $item["ItemList_BchDtls_Nm"],
                                                "Expdt" => $item["ItemList_BchDtls_Expdt"],
                                                "wrDt" => $item["ItemList_BchDtls_wrDt"],
                                            ],
                                            "AttribDtls" => [
                                                [
                                                    "Nm" => $item["ItemList_AttribDtls_Nm"],
                                                    "Val" => $item["ItemList_AttribDtls_Val"],
                                                ]
                                            ]
                                        ];
                                    }
                                    return null; // Return null for invalid items
                                }, $tb_mid_data),
                                "ValDtls" => [
                                    "AssVal" => $tb_up_data["ValDtls_AssVal"],
                                    "CgstVal" => $tb_up_data["ValDtls_CgstVal"],
                                    "SgstVal" => $tb_up_data["ValDtls_SgstVal"],
                                    "IgstVal" => $tb_up_data["ValDtls_IgstVal"],
                                    "CesVal" => $tb_up_data["ValDtls_CesVal"],
                                    "StCesVal" => $tb_up_data["ValDtls_StCesVal"],
                                    "Discount" => $tb_up_data["ValDtls_Discount"],
                                    "OthChrg" => $tb_up_data["ValDtls_OthChrg"],
                                    "RndOffAmt" => $tb_up_data["ValDtls_RndOffAmt"],
                                    "TotInvVal" => $tb_up_data["ValDtls_TotInvVal"],
                                    "TotInvValFc" => $tb_up_data["ValDtls_TotInvValFc"],
                                ],
                                "PayDtls" => [
                                    "Nm" => $tb_up_data["PayDtls_Nm"],
                                    "Accdet" => $tb_up_data["PayDtls_Accdet"],
                                    "Mode" => $tb_up_data["PayDtls_Mode"],
                                    "Fininsbr" => $tb_up_data["PayDtls_Fininsbr"],
                                    "Payterm" => $tb_up_data["PayDtls_Payterm"],
                                    "Payinstr" => $tb_up_data["PayDtls_Payinstr"],
                                    "Crtrn" => $tb_up_data["PayDtls_Crtrn"],
                                    "Dirdr" => $tb_up_data["PayDtls_Dirdr"],
                                    "Crday" => $tb_up_data["PayDtls_Crday"],
                                    "Paidamt" => $tb_up_data["PayDtls_Paidamt"],
                                    "Paymtdue" => $tb_up_data["PayDtls_Paymtdue"],
                                ],
                                "RefDtls" => [
                                    "InvRm" => $tb_up_data["RefDtls_InvRm"],
                                    "DocPerdDtls" => [
                                        "InvStDt" => $tb_up_data["RefDtls_DocPerdDtls_InvStDt"],
                                        "InvEndDt" => $tb_up_data["RefDtls_DocPerdDtls_InvEndDt"],
                                    ],
                                    "PrecDocDtls" => [
                                        [
                                            "InvNo" => $tb_up_data["RefDtls_PrecDocDtls_InvNo"],
                                            "InvDt" => $tb_up_data["RefDtls_PrecDocDtls_InvDt"],
                                            "OthRefNo" => $tb_up_data["RefDtls_PrecDocDtls_OthRefNo"],
                                        ]
                                    ],
                                    "ContrDtls" => [
                                        [
                                            "RecAdvRefr" => $tb_up_data["RefDtls_ContrDtls_RecAdvRefr"],
                                            "RecAdvDt" => $tb_up_data["RefDtls_ContrDtls_RecAdvDt"],
                                            "Tendrefr" => $tb_up_data["RefDtls_ContrDtls_Tendrefr"],
                                            "Contrrefr" => $tb_up_data["RefDtls_ContrDtls_Contrrefr"],
                                            "Extrefr" => $tb_up_data["RefDtls_ContrDtls_Extrefr"],
                                            "Projrefr" => $tb_up_data["RefDtls_ContrDtls_Projrefr"],
                                            "Porefr" => $tb_up_data["RefDtls_ContrDtls_Porefr"],
                                            "PoRefDt" => $tb_up_data["RefDtls_ContrDtls_PoRefDt"],
                                        ]
                                    ]
                                ],
                                "AddlDocDtls" => [
                                    [
                                        "Url" => $tb_up_data["AddlDocDtls_Url"],
                                        "Docs" => $tb_up_data["AddlDocDtls_Docs"],
                                        "Info" => $tb_up_data["AddlDocDtls_Info"],
                                    ]
                                ]
                                    ];
                                    /*,
                                "EwbDtls" => [
                                    "TransId" => $tb_up_data["EwbDtls_TransId"],
                                    "TransName" => $tb_up_data["EwbDtls_TransName"],
                                    "Distance" => $tb_up_data["EwbDtls_Distance"],
                                    "TransDocNo" => $tb_up_data["EwbDtls_TransDocNo"],
                                    "TransDocDt" => $tb_up_data["EwbDtls_TransDocDt"],
                                    "VehNo" => $tb_up_data["EwbDtls_VehNo"],
                                    "VehType" => $tb_up_data["EwbDtls_VehType"],
                                    "TransMode" => $tb_up_data["EwbDtls_TransMode"],
                                ]
                            */
                            
                            // Convert to JSON
                            $json_output = json_encode($post_data, JSON_PRETTY_PRINT);
                            // echo $json_output;
                            $APIPost = $json_output;
                            // if($EntryID == 41615) print_r($post_data);

                            //CALL API
                            $access_token = '1XPLm4qjAVTeoiUXs4Tw74XDP';
                            $aspid = '1773362725';
                            $password = 'Mf89%3DN32]mIZ}1bn'; 

                            $sql = "SELECT Api_Token FROM mst_party_company WHERE Api_TokenExpiry BETWEEN GETDATE() AND DATEADD(HOUR, 6, GETDATE()) AND Companyid = " . $_SESSION['dbCompany'];
                            $Tresult = db::getInstance()->db_select($sql);
                            // print_r($Tresult);
                            if($Tresult['num_rows'] > 0){
                                $access_token = $Tresult['result_set'][0]['Api_Token'];
                            }else{
                                $response = getGSTTokenProduction($GSPresult['result_set'][0]['Gspuserid'], $GSPresult['result_set'][0]['Gsppsw'], $GSPresult['result_set'][0]['gstno']);
                                
                                $sql = "UPDATE acc_einvoice_up SET Token_APIResponse = '" . db::getInstance()->real_escape_string(json_encode($response)) . "',
                                        Token_APIPost = '" . db::getInstance()->real_escape_string($GSPresult['result_set'][0]['Gspuserid'] . ' = ' . $GSPresult['result_set'][0]['Gsppsw'] . ' = ' . $GSPresult['result_set'][0]['gstno']) . "' WHERE ID = $id";
                                db::getInstance()->db_update($sql);

                                // print_r($response);
                                if(isset($response['Status'])){
                                    if($response['Status'] == 1){
                                        $access_token = $response['Data']['AuthToken'];
                                        $token_expiry = $response['Data']['TokenExpiry'];
                                        $sql = "UPDATE mst_party_company SET Api_Token = '".$response['Data']['AuthToken']."', Api_TokenExpiry ='".$response['Data']['TokenExpiry']."' WHERE Companyid = " . $_SESSION['dbCompany'];
                                        db::getInstance()->db_update($sql);
                                    }
                                }
                            }
                            
                            // $APIUrl = 'https://gstsandbox.charteredinfo.com/eicore/dec/v1.03/Invoice?aspid='.$aspid.'&password='.$password.'&Gstin=34AACCC1596Q002&eInvPwd=abc34*&AuthToken='.$access_token.'&QrCodeSize=250&ParseIrnResp=0&User_name=TaxProEnvPON&fortally=1';
                            // https://einvapi.charteredinfo.com/v1.03/dec/ewayapi?action=<postaction>&aspid=< aspid >&password=< password >&gstin=< gstin >&username=<username >&authtoken=<authtoken>
                            $APIUrl = 'https://einvapi.charteredinfo.com/eicore/dec/v1.03/Invoice?QrCodeSize=113&aspid='.$aspid.'&password='.$password.'&Gstin='.$GSPresult['result_set'][0]['gstno'].'&AuthToken='.$access_token.'&User_name='.$GSPresult['result_set'][0]['Gspuserid'].'';
                            $APIResponse1 = callAPICurl($APIUrl, $APIPost);
                            // print_r($APIResponse1);
                            
                            //INSERT RESPONSE IN DB ---
                            $sql = "UPDATE acc_einvoice_up SET
                                    APICalled = 1,APICalledAt= GETDATE(),APIResponse = '" . db::getInstance()->real_escape_string($APIResponse1) . "',
                                    APIURL = '$APIUrl',APIPost = '" . db::getInstance()->real_escape_string($APIPost) . "',
                                    Response_Error ='' WHERE ID = $id";
                            db::getInstance()->db_update($sql);
                            // echo gettype($APIResponse1);
                            if (!is_array($APIResponse1)) {
                                // print_r($APIResponse1);
                                // $APIResponse = json_decode($APIResponse1, true);
                                // if (isset($APIResponse['Data'])) {
                                //     $APIResponse['Data'] = json_decode($APIResponse['Data'], true);
                                // }
                                $jsonString = stripslashes($APIResponse1); 
                                $jsonString = preg_replace('/"Data":"({.*})"/', '"Data":$1', $jsonString);
                                $array = json_decode($jsonString, true);

                                if (json_last_error() !== JSON_ERROR_NONE) {
                                    echo "Error in decoding JSON: " . json_last_error_msg();
                                } else {
                                    // echo 'no error';
                                    // Decode the nested 'Data' field
                                    if (isset($array['Data']) && is_string($array['Data'])) {
                                        $array['Data'] = json_decode($array['Data'], true);
                                        if (json_last_error() !== JSON_ERROR_NONE) {
                                            echo "Error in decoding nested JSON: " . json_last_error_msg();
                                        } else {
                                            // echo "New array";
                                            // print_r($array); // Print the final array
                                        }
                                    }
                                }
                                $APIResponse = $array;
                            }else{
                                $APIResponse = $APIResponse1;
                            }
                            //Check for errors:
                            // if($APIResponse['Status'] == 0 || $APIResponse['Status'] == "0"){
                            if(0){
                                $error = 2;
                                $error_msg = $APIResponse['error_message'];
                            }else{
                                if(is_array($APIResponse['ErrorDetails'])){
                                    $error = 1;
                                    $error_msg = $APIResponse['ErrorDetails'][0]['ErrorMessage'];
                                    // echo $APIResponse['ErrorDetails'][0]['ErrorCode'] . "<br />";
                                    if($APIResponse['ErrorDetails'][0]['ErrorCode'] == '2150'){
                                        //DUPLICATE IRN
                                        $APIResponse['Data'] = $APIResponse['InfoDtls'][0]['Desc'];
                                        $APIResponse['Status'] = 1;
                                        
                                        //AS IRN is already generated, we have to get SignedQRCode from IRN
                                        //https://einvapi.charteredinfo.com/eicore/dec/v1.03/Invoice/irn/<Irn_no>?QrCodeSize=250
                                        $APIUrl = 'https://einvapi.charteredinfo.com/eicore/dec/v1.03/Invoice/irn/'.$APIResponse['InfoDtls'][0]['Desc']['Irn'].'?QrCodeSize=113&aspid='.$aspid.'&password='.$password.'&Gstin='.$GSPresult['result_set'][0]['gstno'].'&AuthToken='.$access_token.'&User_name='.$GSPresult['result_set'][0]['Gspuserid'].'';
                                        $APIResponse1 = callAPICurl($APIUrl, null, 'GET');
                                        if (!is_array($APIResponse1)) {
                                            // print_r($APIResponse1);
                                            // $APIResponse = json_decode($APIResponse1, true);
                                            // if (isset($APIResponse['Data'])) {
                                            //     $APIResponse['Data'] = json_decode($APIResponse['Data'], true);
                                            // }
                                            $jsonString = stripslashes($APIResponse1); 
                                            $jsonString = preg_replace('/"Data":"({.*})"/', '"Data":$1', $jsonString);
                                            $array = json_decode($jsonString, true);
            
                                            if (json_last_error() !== JSON_ERROR_NONE) {
                                                echo "Error in decoding JSON: " . json_last_error_msg();
                                            } else {
                                                // echo 'no error';
                                                // Decode the nested 'Data' field
                                                if (isset($array['Data']) && is_string($array['Data'])) {
                                                    $array['Data'] = json_decode($array['Data'], true);
                                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                                        echo "Error in decoding nested JSON: " . json_last_error_msg();
                                                    } else {
                                                        // echo "New array";
                                                        // print_r($array); // Print the final array
                                                    }
                                                }
                                            }
                                            $APIResponse = $array;
                                        }else{
                                            $APIResponse = $APIResponse1;
                                        }
                                        // echo "==>>,,<<" . print_r($APIResponse);
                                        $sql = "UPDATE acc_einvoice_up SET
                                                Dup_APICalled = 1,Dup_APICalledAt= GETDATE(),Dup_APIResponse = '" . db::getInstance()->real_escape_string($APIResponse1) . "',
                                                Dup_APIURL = '$APIUrl' WHERE ID = $id";
                                        db::getInstance()->db_update($sql);
                                        goto continueEinvoice;
                                    }
                                }else{
                                    continueEinvoice:
                                    if($APIResponse['Status'] == 1 && is_array($APIResponse['Data'])){
                                        // echo "SUCCESS";
                                        $d = $APIResponse['Data'];
                                        $output = $d;
                                        
                                        // $data = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjNCRTE3RTUxNDE5MjUyMjY0N0YwMUZEQkZGNTI3MUFENTI2OEQ3MzUiLCJ4NXQiOiJPLUYtVVVHU1VpWkg4Ql9iXzFKeHJWSm8xelUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJOSUMgU2FuZGJveCIsImRhdGEiOiJ7XCJTZWxsZXJHc3RpblwiOlwiMzRBQUNDQzE1OTZRMDAyXCIsXCJCdXllckdzdGluXCI6XCIyOUFXR1BWNzEwN0IxWjFcIixcIkRvY05vXCI6XCJET0MxLzYwOTM2LTEwXCIsXCJEb2NUeXBcIjpcIklOVlwiLFwiRG9jRHRcIjpcIjAyLzAzLzIwMjVcIixcIlRvdEludlZhbFwiOjEyOTA4LFwiSXRlbUNudFwiOjEsXCJNYWluSHNuQ29kZVwiOlwiMTAwMVwiLFwiSXJuXCI6XCI0NWRmNTk1NmE1NjEwM2Y5ZWE3ZjA3YjQ4NjIwZjU5YTQ1ZTZjNjE3NmQyMTE3OWE0MDFiMmI5Nzk5NjgzNWMzXCIsXCJJcm5EdFwiOlwiMjAyNS0wMy0xNyAxNjoxNjozOFwifSJ9.FkndqNcmwqi8GSbQ4qHMU1OpuHochIbdvIzm0uyJNVqJAhw6geBgsSasKh557z3zQV6A6aoUC_6m-C_D9rs-vRerUl2XG9dbamI9tlPC0H6iZhRod8BwBLoP33rtEL9WpO_XdtheBUwmhquI2qI_C5Mj1p2AxiSIpA3nD5tPAw4mPElJ9knFB7-xw7ZiuDVT_DeH1xJMDnEoBy1wO0Lz12l-wKZIDdcfzrFN-WrOTTu43eIVGjgk-xSnMZEPAmrO1Fs8n2DD2pIFbtHMaytgufhmeGcL5ZalAVSOBUCZlSYq-PP1Cz7MkuyDH-3zmb9-qMCPHi7iiSjmoS2chhxA_w'; // The data to encode in the QR code
                                        $outputFolder = 'qrcodes'; // Folder to save the QR code image
                                        $fileName = 'Einvoice_'.$FormID.'_'.$_SESSION['dbCompany'].'_'.$EntryID.'.png'; // Name of the output file
                                        
                                        include_once('generateBarcodeImage.php');
                                        $filePath = generateQRCode($d['SignedQRCode'], $outputFolder, $fileName);
                                        $fullFile = CODE_PATH . $outputFolder . '\\' . $fileName; 
                                        
                                        $sql = "UPDATE acc_einvoice_up SET 
                                                Response_AckNo = '".$d['AckNo']."',
                                                Response_AckDt ='".$d['AckDt']."',
                                                Response_Irn ='".$d['Irn']."',
                                                Response_SignedInvoice ='".$d['SignedInvoice']."',
                                                Response_SignedQRCode ='".$d['SignedQRCode']."',
                                                Response_Status ='".$d['Status']."',
                                                Response_EwbNo ='".$d['EwbNo']."',
                                                Response_EwbDt ='".$d['EwbDt']."',
                                                Response_EwbValidTill ='".$d['EwbValidTill']."',
                                                Response_Remarks ='".db::getInstance()->real_escape_string($d['Remarks'] ?? "")."',
                                                Response_Error ='',                                            
                                                Response_QRImageName = '" . $fullFile . "'
                                                WHERE ID = " . $id;
                                            // Response_QRImage = '".$img."',
                                            // Response_QRImageName = '" . $fileName . "'
                                                db::getInstance()->db_update($sql);
                                        /* Update image in the above table using linkserver SP*/

                                        $binary = file_get_contents($fullFile);
                                        $hex = "0x" . bin2hex($binary);
                                        $sql = "update acc_einvoice_up SET Response_QRImage=".$hex." WHERE ID = " . $id;
                                        $result = db::getInstance()->db_update($sql);

                                        // $session ='YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';
                                        // $data['params'] = ['@servername','@ipaddress','@database','@userid','@password','@id'];

                                        // $sp['values'] = ["'" . $_SESSION['dbName'] . "_" . $_SESSION['user_id'] . "'",
                                        //                  "'" . $_SESSION['dbHost'] . "'",
                                        //                  "'" . $_SESSION['dbName'] . "'",
                                        //                  "'" . $_SESSION['dbUser'] . "'",
                                        //                  "'" . $_SESSION['dbPass'] . "'",
                                        //                  $id
                                        //                 ];
                                        // $result = db::getInstanceMaster()->db_sp_select('SP_AddLinkServer', $data['params'], $sp['values']);

                                        $output['QRCode'] = 'getDatabaseImage.php?case=1&id=' . $id;
                                    }
                                }
                            }

                        }else{
                            //SHOW ERROR MSG FROM VALIDATION SP
                            $error = 4;
                            $error_msg = isset($result['result_set'][0][0]['Msg']) ? $result['result_set'][0][0]['Msg'] : 'Error in Validation';
                        }
                    }else{
                        $error = 5;
                        $error_msg = 'Error in Validation Output';
                    }
                }
            }
        }
        OutofEinvoice:
        break;

    case 'einvoice-test':
        $APIModeSandbox = 1; //1=> sandbox 0 => Production
        //sp_API_ValidateEinvoice
        $spExists = false;
        $SPName = 'sp_API_ValidateEinvoice';
        $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
        $sqlresult = db::getInstance()->db_select($sql);
        // print_r($sqlresult);
        // echo $_SESSION['dbName'];
        if($sqlresult['result_set'][0]['found'] == 1){
            //BEFORE CALLING SP CHECK IF ITS ALREADY GENERATED EARLIER
            $sql = "select Response_AckNo,Response_AckDt,Response_Irn ,Response_SignedInvoice ,Response_SignedQRCode ,Response_Status ,Response_EwbNo ,Response_EwbDt ,Response_EwbValidTill ,Response_Remarks, CONCAT('getDatabaseImage.php?case=1&id=',ID) as QRCode
                    from acc_einvoice_up where Response_Status = 'ACT' AND APICalled=1 AND CompanyID=".$_SESSION['dbCompany']." AND DivisionID=".$_SESSION['dbDivision'] ."
                    AND YearCode='".$_SESSION['dbYear']."' AND FormID=".$FormID." AND EntryID=".$EntryID;
            $result = db::getInstance()->db_select($sql);
            if($result['num_rows'] > 0){
                //ALREADY GENERATED...
                $error = 0;
                $error_msg = "E-invoice already generated.";
                $output = $result['result_set'][0];
            }else{
                $spExists = true;
                $params = ['@formid','@entryid','@userid','@company','@division','@ycode'];
                $values = [$FormID,$EntryID,$_SESSION['user_id'],$_SESSION['dbCompany'],$_SESSION['dbDivision'],$_SESSION['dbYear']];
                $result = db::getInstance()->db_sp_select($SPName, $params, $values);
                // echo "<br />Calling SP<br />";
                // print_r($result);
                /*
                    Array(
                        [error] => 0
                        [error_statement] => 
                        [result_set] => Array
                            (
                                [0] => Array
                                    (
                                        [0] => Array
                                            (
                                                [success] => 1
                                                [id] => 21
                                            )

                                    )

                            )

                    )

                */
                if($result['error'] != 0){
                    $error = 1;
                    $error_msg = $result['error_statement'];
                }else{
                    if(is_array($result['result_set'][0][0])){
                        if($result['result_set'][0][0]['success'] != 0){

                            $id = $result['result_set'][0][0]['id'];
                            if($id > 0){}
                            /***************
                            Add Validation
                            ****************/
                            // $einvoice_up_id = $id;
                            // Fetch data from tb_up
                            $tb_up_sql = "SELECT [ID],[Version],[TranDtls_TaxSch],[TranDtls_SupTyp],[TranDtls_RegRev],[TranDtls_EcmGstin],[TranDtls_IgstOnIntra],[DocDtls_Typ],[DocDtls_No],CONVERT(VARCHAR, DocDtls_Dt, 103) as DocDtls_Dt,[SellerDtls_Gstin],[SellerDtls_LglNm]
                                        ,[SellerDtls_TrdNm],[SellerDtls_Addr1],[SellerDtls_Addr2],[SellerDtls_Loc],[SellerDtls_Pin],[SellerDtls_Stcd],[SellerDtls_Ph],[SellerDtls_Em],[BuyerDtls_Gstin],[BuyerDtls_LglNm],[BuyerDtls_TrdNm],[BuyerDtls_Pos],[BuyerDtls_Addr1],[BuyerDtls_Addr2]
                                        ,[BuyerDtls_Loc],[BuyerDtls_Pin],[BuyerDtls_Stcd],[BuyerDtls_Ph],[BuyerDtls_Em],[DispDtls_Nm],[DispDtls_Addr1],[DispDtls_Addr2],[DispDtls_Loc],[DispDtls_Pin],[DispDtls_Stcd],[ValDtls_AssVal],[ValDtls_CgstVal],[ValDtls_SgstVal]
                                        ,[ValDtls_IgstVal],[ValDtls_CesVal],[ValDtls_StCesVal],[ValDtls_Discount],[ValDtls_OthChrg],[ValDtls_RndOffAmt],[ValDtls_TotInvVal],[ValDtls_TotInvValFc],[PayDtls_Nm],[PayDtls_Accdet],[PayDtls_Mode],[PayDtls_Fininsbr],[PayDtls_Payterm]
                                        ,[PayDtls_Payinstr],[PayDtls_Crtrn],[PayDtls_Dirdr],[PayDtls_Crday],[PayDtls_Paidamt],[PayDtls_Paymtdue],[RefDtls_InvRm],CONVERT(VARCHAR, RefDtls_DocPerdDtls_InvStDt, 103) as RefDtls_DocPerdDtls_InvStDt,CONVERT(VARCHAR, RefDtls_DocPerdDtls_InvEndDt, 103) as RefDtls_DocPerdDtls_InvEndDt,[RefDtls_PrecDocDtls_InvNo],CONVERT(VARCHAR, [RefDtls_PrecDocDtls_InvDt], 103) as RefDtls_PrecDocDtls_InvDt
                                        ,[RefDtls_PrecDocDtls_OthRefNo],[RefDtls_ContrDtls_RecAdvRefr],CONVERT(VARCHAR, RefDtls_ContrDtls_RecAdvDt, 103) as RefDtls_ContrDtls_RecAdvDt,[RefDtls_ContrDtls_Tendrefr],[RefDtls_ContrDtls_Contrrefr],[RefDtls_ContrDtls_Extrefr],[RefDtls_ContrDtls_Projrefr],[RefDtls_ContrDtls_Porefr],CONVERT(VARCHAR, [RefDtls_ContrDtls_PoRefDt], 103) as RefDtls_ContrDtls_PoRefDt
                                        ,[AddlDocDtls_Url],[AddlDocDtls_Docs],[AddlDocDtls_Info],[ExpDtls_ShipBNo],CONVERT(VARCHAR, ExpDtls_ShipBDt, 103) as ExpDtls_ShipBDt,[ExpDtls_Port],[ExpDtls_RefClm],[ExpDtls_ForCur],[ExpDtls_CntCode],[EwbDtls_TransId],[EwbDtls_TransName],[EwbDtls_Distance]
                                        ,[EwbDtls_TransDocNo],CONVERT(VARCHAR, EwbDtls_TransDocDt, 103) as EwbDtls_TransDocDt,[EwbDtls_VehNo],[EwbDtls_VehType],[EwbDtls_TransMode],[YearCode],[CompanyID],[DivisionID],[FormID],[EntryID],[UserID]
                                        FROM [dbo].[acc_einvoice_up] WHERE ID = " . $id; 
                            // $tb_up_sql = "SELECT * FROM acc_einvoice_up WHERE ID = " . $id; 
                            $tb_up_result = db::getInstance()->db_select($tb_up_sql);
                            $tb_up_data = $tb_up_result['result_set'][0];

                            // Fetch data from tb_mid
                            $tb_mid_sql = "SELECT * FROM acc_einvoice_mid WHERE EntryID = " . $id; 
                            $tb_mid_result =db::getInstance()->db_select($tb_mid_sql);
                            $tb_mid_data = [];
                            $i = 0;
                            while ($i < sizeof($tb_mid_result['result_set'])) {
                                $tb_mid_data[] = $tb_mid_result['result_set'][$i++];
                            }
                            // print_r($tb_mid_result);
                            // Build JSON
                            if($APIModeSandbox){
                                $tb_up_data["BuyerDtls_Gstin"] = '34AAACC1206D1ZL';
                                // $tb_up_data["transporterId"] = '34AACCC1596Q002';
                                // $tb_up_data["docNo"] = '010473-3';
                                $tb_up_data["BuyerDtls_Stcd"] = 34;
                                $tb_up_data["BuyerDtls_Pos"] = 34;
                                $tb_up_data["BuyerDtls_Pin"] = 605001;
                            }
                            $post_data = [
                                "Version" => $tb_up_data["Version"],
                                "TranDtls" => [
                                    "TaxSch" => $tb_up_data["TranDtls_TaxSch"],
                                    "SupTyp" => $tb_up_data["TranDtls_SupTyp"],
                                    "RegRev" => $tb_up_data["TranDtls_RegRev"],
                                    "EcmGstin" => $tb_up_data["TranDtls_EcmGstin"],
                                    "IgstOnIntra" => $tb_up_data["TranDtls_IgstOnIntra"],
                                ],
                                "DocDtls" => [
                                    "Typ" => $tb_up_data["DocDtls_Typ"],
                                    "No" => $tb_up_data["DocDtls_No"],
                                    "Dt" => $tb_up_data["DocDtls_Dt"],
                                ],
                                "SellerDtls" => [
                                    "Gstin" => $tb_up_data["SellerDtls_Gstin"],
                                    "LglNm" => $tb_up_data["SellerDtls_LglNm"],
                                    "TrdNm" => $tb_up_data["SellerDtls_TrdNm"],
                                    "Addr1" => $tb_up_data["SellerDtls_Addr1"],
                                    "Addr2" => $tb_up_data["SellerDtls_Addr2"],
                                    "Loc" => $tb_up_data["SellerDtls_Loc"],
                                    "Pin" => $tb_up_data["SellerDtls_Pin"],
                                    "Stcd" => trim($tb_up_data["SellerDtls_Stcd"]),
                                    "Ph" => $tb_up_data["SellerDtls_Ph"],
                                    "Em" => $tb_up_data["SellerDtls_Em"],
                                ],
                                "BuyerDtls" => [
                                    "Gstin" => $tb_up_data["BuyerDtls_Gstin"],
                                    "LglNm" => $tb_up_data["BuyerDtls_LglNm"],
                                    "TrdNm" => $tb_up_data["BuyerDtls_TrdNm"],
                                    "Pos" => trim($tb_up_data["BuyerDtls_Pos"]),
                                    "Addr1" => $tb_up_data["BuyerDtls_Addr1"],
                                    "Addr2" => $tb_up_data["BuyerDtls_Addr2"],
                                    "Loc" => $tb_up_data["BuyerDtls_Loc"],
                                    "Pin" => $tb_up_data["BuyerDtls_Pin"],
                                    "Stcd" => trim($tb_up_data["BuyerDtls_Stcd"]),
                                    "Ph" => $tb_up_data["BuyerDtls_Ph"],
                                    "Em" => $tb_up_data["BuyerDtls_Em"],
                                ],
                                "DispDtls" => [
                                    "Nm" => $tb_up_data["DispDtls_Nm"],
                                    "Addr1" => $tb_up_data["DispDtls_Addr1"],
                                    "Addr2" => $tb_up_data["DispDtls_Addr2"],
                                    "Loc" => $tb_up_data["DispDtls_Loc"],
                                    "Pin" => $tb_up_data["DispDtls_Pin"],
                                    "Stcd" => trim($tb_up_data["DispDtls_Stcd"]),
                                ],
                                "itemList" => array_map(function ($item) {
                                    // Exclude items with null or missing values
                                    if (isset($item["ItemList_SlNo"]) && isset($item["ItemList_SlNo"]) && $item["ItemList_SlNo"] !== null) {
                                        return [
                                            "SlNo" => $item["ItemList_SlNo"],
                                            "PrdDesc" => $item["ItemList_PrdDesc"],
                                            "IsServc" => $item["ItemList_IsServc"],
                                            "HsnCd" => $item["ItemList_HsnCd"],
                                            "Barcde" => $item["ItemList_Barcde"],
                                            "Qty" => $item["ItemList_Qty"],
                                            "FreeQty" => $item["ItemList_FreeQty"],
                                            "Unit" => $item["ItemList_Unit"],
                                            "UnitPrice" => $item["ItemList_UnitPrice"],
                                            "TotAmt" => $item["ItemList_TotAmt"],
                                            "Discount" => $item["ItemList_Discount"],
                                            "PreTaxVal" => $item["ItemList_PreTaxVal"],
                                            "AssAmt" => $item["ItemList_AssAmt"],
                                            "GstRt" => $item["ItemList_GstRt"],
                                            "IgstAmt" => $item["ItemList_IgstAmt"],
                                            "CgstAmt" => $item["ItemList_CgstAmt"],
                                            "SgstAmt" => $item["ItemList_SgstAmt"],
                                            "CesRt" => $item["ItemList_CesRt"],
                                            "CesAmt" => $item["ItemList_CesAmt"],
                                            "CesNonAdvlAmt" => $item["ItemList_CesNonAdvlAmt"],
                                            "StateCesRt" => $item["ItemList_StateCesRt"],
                                            "StateCesAmt" => $item["ItemList_StateCesAmt"],
                                            "StateCesNonAdvlAmt" => $item["ItemList_StateCesNonAdvlAmt"],
                                            "OthChrg" => $item["ItemList_OthChrg"],
                                            "TotItemVal" => $item["ItemList_TotItemVal"],
                                            "OrdLineRef" => $item["ItemList_OrdLineRef"],
                                            "OrgCntry" => $item["ItemList_OrgCntry"],
                                            "PrdSlNo" => $item["ItemList_PrdSlNo"],
                                            "BchDtls" => [
                                                "Nm" => $item["ItemList_BchDtls_Nm"],
                                                "Expdt" => $item["ItemList_BchDtls_Expdt"],
                                                "wrDt" => $item["ItemList_BchDtls_wrDt"],
                                            ],
                                            "AttribDtls" => [
                                                [
                                                    "Nm" => $item["ItemList_AttribDtls_Nm"],
                                                    "Val" => $item["ItemList_AttribDtls_Val"],
                                                ]
                                            ]
                                        ];
                                    }
                                    return null; // Return null for invalid items
                                }, $tb_mid_data),
                                "ValDtls" => [
                                    "AssVal" => $tb_up_data["ValDtls_AssVal"],
                                    "CgstVal" => $tb_up_data["ValDtls_CgstVal"],
                                    "SgstVal" => $tb_up_data["ValDtls_SgstVal"],
                                    "IgstVal" => $tb_up_data["ValDtls_IgstVal"],
                                    "CesVal" => $tb_up_data["ValDtls_CesVal"],
                                    "StCesVal" => $tb_up_data["ValDtls_StCesVal"],
                                    "Discount" => $tb_up_data["ValDtls_Discount"],
                                    "OthChrg" => $tb_up_data["ValDtls_OthChrg"],
                                    "RndOffAmt" => $tb_up_data["ValDtls_RndOffAmt"],
                                    "TotInvVal" => $tb_up_data["ValDtls_TotInvVal"],
                                    "TotInvValFc" => $tb_up_data["ValDtls_TotInvValFc"],
                                ],
                                "PayDtls" => [
                                    "Nm" => $tb_up_data["PayDtls_Nm"],
                                    "Accdet" => $tb_up_data["PayDtls_Accdet"],
                                    "Mode" => $tb_up_data["PayDtls_Mode"],
                                    "Fininsbr" => $tb_up_data["PayDtls_Fininsbr"],
                                    "Payterm" => $tb_up_data["PayDtls_Payterm"],
                                    "Payinstr" => $tb_up_data["PayDtls_Payinstr"],
                                    "Crtrn" => $tb_up_data["PayDtls_Crtrn"],
                                    "Dirdr" => $tb_up_data["PayDtls_Dirdr"],
                                    "Crday" => $tb_up_data["PayDtls_Crday"],
                                    "Paidamt" => $tb_up_data["PayDtls_Paidamt"],
                                    "Paymtdue" => $tb_up_data["PayDtls_Paymtdue"],
                                ],
                                "RefDtls" => [
                                    "InvRm" => $tb_up_data["RefDtls_InvRm"],
                                    "DocPerdDtls" => [
                                        "InvStDt" => $tb_up_data["RefDtls_DocPerdDtls_InvStDt"],
                                        "InvEndDt" => $tb_up_data["RefDtls_DocPerdDtls_InvEndDt"],
                                    ],
                                    "PrecDocDtls" => [
                                        [
                                            "InvNo" => $tb_up_data["RefDtls_PrecDocDtls_InvNo"],
                                            "InvDt" => $tb_up_data["RefDtls_PrecDocDtls_InvDt"],
                                            "OthRefNo" => $tb_up_data["RefDtls_PrecDocDtls_OthRefNo"],
                                        ]
                                    ],
                                    "ContrDtls" => [
                                        [
                                            "RecAdvRefr" => $tb_up_data["RefDtls_ContrDtls_RecAdvRefr"],
                                            "RecAdvDt" => $tb_up_data["RefDtls_ContrDtls_RecAdvDt"],
                                            "Tendrefr" => $tb_up_data["RefDtls_ContrDtls_Tendrefr"],
                                            "Contrrefr" => $tb_up_data["RefDtls_ContrDtls_Contrrefr"],
                                            "Extrefr" => $tb_up_data["RefDtls_ContrDtls_Extrefr"],
                                            "Projrefr" => $tb_up_data["RefDtls_ContrDtls_Projrefr"],
                                            "Porefr" => $tb_up_data["RefDtls_ContrDtls_Porefr"],
                                            "PoRefDt" => $tb_up_data["RefDtls_ContrDtls_PoRefDt"],
                                        ]
                                    ]
                                ],
                                "AddlDocDtls" => [
                                    [
                                        "Url" => $tb_up_data["AddlDocDtls_Url"],
                                        "Docs" => $tb_up_data["AddlDocDtls_Docs"],
                                        "Info" => $tb_up_data["AddlDocDtls_Info"],
                                    ]
                                ]
                                    ];
                                    /*,
                                "EwbDtls" => [
                                    "TransId" => $tb_up_data["EwbDtls_TransId"],
                                    "TransName" => $tb_up_data["EwbDtls_TransName"],
                                    "Distance" => $tb_up_data["EwbDtls_Distance"],
                                    "TransDocNo" => $tb_up_data["EwbDtls_TransDocNo"],
                                    "TransDocDt" => $tb_up_data["EwbDtls_TransDocDt"],
                                    "VehNo" => $tb_up_data["EwbDtls_VehNo"],
                                    "VehType" => $tb_up_data["EwbDtls_VehType"],
                                    "TransMode" => $tb_up_data["EwbDtls_TransMode"],
                                ]
                            */
                            
                            // Convert to JSON
                            $json_output = json_encode($post_data, JSON_PRETTY_PRINT);
                            // echo $json_output;
                            $APIPost = $json_output;

                            //CALL API
                            $access_token = '1XPLm4qjAVTeoiUXs4Tw74XDP';
                            $aspid = '1773362725';
                            $password = 'Mf89%3DN32]mIZ}1bn'; 

                            $response = getGSTToken();
                            // print_r($response);
                            if(isset($response['Status'])){
                                if($response['Status'] == 1){
                                    $access_token = $response['Data']['AuthToken'];
                                    $token_expiry = $response['Data']['TokenExpiry'];
                                }
                            }
                            /**
                                 * ERROR:
                                 * {"status_cd": "0","error": {"error_cd": "GSP001GA","message": "Invalid Length of 'gstin' in Request Header or Query Param."}}
                                 * 
                                 * SUCCESS:
                                 * {
                                    "Status": 1,
                                    "Data": {
                                        "ClientId": "AACCC29GSPR5CM0",
                                        "UserName": "TaxProEnvPON",
                                        "AuthToken": "1NutQQW9NNNKoByKOeEQxWI1U",
                                        "Sek": "",
                                        "TokenExpiry": "2025-03-15 22:06:02"
                                    },
                                    "ErrorDetails": null,
                                    "InfoDtls": null
                                }
                            */                            
                            $APIUrl = 'https://gstsandbox.charteredinfo.com/eicore/dec/v1.03/Invoice?aspid='.$aspid.'&password='.$password.'&Gstin=34AACCC1596Q002&eInvPwd=abc34*&AuthToken='.$access_token.'&QrCodeSize=250&ParseIrnResp=0&User_name=TaxProEnvPON&fortally=1';
                            $APIPost1 = '{
                                            "Version": "1.1",
                                            "TranDtls": {
                                                "TaxSch": "GST",
                                                "SupTyp": "B2B",
                                                "RegRev": "Y",
                                                "EcmGstin": null,
                                                "IgstOnIntra": "N"
                                            },
                                            "DocDtls": {
                                                "Typ": "INV",
                                                "No": "DOC1/60938-8",
                                                "Dt": "02/03/2025"
                                            },
                                            "SellerDtls": {
                                                "Gstin": "34AACCC1596Q002",
                                                "LglNm": "NIC company pvt ltd",
                                                "TrdNm": "NIC Industries",
                                                "Addr1": "5th block, kuvempu layout",
                                                "Addr2": "kuvempu layout",
                                                "Loc": "GANDHINAGAR",
                                                "Pin": 605001,
                                                "Stcd": "34",
                                                "Ph": "9000000000",
                                                "Em": "abc@gmail.com"
                                            },
                                            "BuyerDtls": {
                                                "Gstin": "29AWGPV7107B1Z1",
                                                "LglNm": "XYZ company pvt ltd",
                                                "TrdNm": "XYZ Industries",
                                                "Pos": "12",
                                                "Addr1": "7th block, kuvempu layout",
                                                "Addr2": "kuvempu layout",
                                                "Loc": "GANDHINAGAR",
                                                "Pin": 562160,
                                                "Stcd": "29",
                                                "Ph": "91111111111",
                                                "Em": "xyz@yahoo.com"
                                            },
                                            "DispDtls": {
                                                "Nm": "ABC company pvt ltd",
                                                "Addr1": "7th block, kuvempu layout",
                                                "Addr2": "kuvempu layout",
                                                "Loc": "Banagalore",
                                                "Pin": 562160,
                                                "Stcd": "29"
                                            },
                                            "ItemList": [
                                                {
                                                    "SlNo": "1",
                                                    "PrdDesc": "Rice",
                                                    "IsServc": "N",
                                                    "HsnCd": "1001",
                                                    "Barcde": "12356",
                                                    "Qty": 100.345,
                                                    "FreeQty": 10,
                                                    "Unit": "BAG",
                                                    "UnitPrice": 99.545,
                                                    "TotAmt": 9978.84,
                                                    "Discount": 0,
                                                    "PreTaxVal": 1,
                                                    "AssAmt": 9978.84,
                                                    "GstRt": 12.0,
                                                    "IgstAmt": 1197.46,
                                                    "CgstAmt": 0,
                                                    "SgstAmt": 0,
                                                    "CesRt": 5,
                                                    "CesAmt": 498.94,
                                                    "CesNonAdvlAmt": 10,
                                                    "StateCesRt": 12,
                                                    "StateCesAmt": 1197.46,
                                                    "StateCesNonAdvlAmt": 5,
                                                    "OthChrg": 10,
                                                    "TotItemVal": 12897.7,
                                                    "OrdLineRef": "3256",
                                                    "OrgCntry": "AG",
                                                    "PrdSlNo": "12345",
                                                    "BchDtls": {
                                                        "Nm": "123456",
                                                        "Expdt": "01/08/2020",
                                                        "wrDt": "01/09/2020"
                                                    },
                                                    "AttribDtls": [
                                                        {
                                                            "Nm": "Rice",
                                                            "Val": "10000"
                                                        }
                                                    ]
                                                }
                                            ],
                                            "ValDtls": {
                                                "AssVal": 9978.84,
                                                "CgstVal": 0,
                                                "SgstVal": 0,
                                                "IgstVal": 1197.46,
                                                "CesVal": 508.94,
                                                "StCesVal": 1202.46,
                                                "Discount": 10,
                                                "OthChrg": 20,
                                                "RndOffAmt": 0.3,
                                                "TotInvVal": 12908,
                                                "TotInvValFc": 12897.7
                                            },
                                            "PayDtls": {
                                                "Nm": "ABCDE",
                                                "Accdet": "5697389713210",
                                                "Mode": "Cash",
                                                "Fininsbr": "SBIN11000",
                                                "Payterm": "100",
                                                "Payinstr": "Gift",
                                                "Crtrn": "test",
                                                "Dirdr": "test",
                                                "Crday": 100,
                                                "Paidamt": 10000,
                                                "Paymtdue": 5000
                                            },
                                            "RefDtls": {
                                                "InvRm": "TEST",
                                                "DocPerdDtls": {
                                                    "InvStDt": "01/08/2020",
                                                    "InvEndDt": "01/09/2020"
                                                },
                                                "PrecDocDtls": [
                                                    {
                                                        "InvNo": "DOC/002",
                                                        "InvDt": "01/08/2020",
                                                        "OthRefNo": "123456"
                                                    }
                                                ],
                                                "ContrDtls": [
                                                    {
                                                        "RecAdvRefr": "Doc/003",
                                                        "RecAdvDt": "01/08/2020",
                                                        "Tendrefr": "Abc001",
                                                        "Contrrefr": "Co123",
                                                        "Extrefr": "Yo456",
                                                        "Projrefr": "Doc-456",
                                                        "Porefr": "Doc-789",
                                                        "PoRefDt": "01/08/2020"
                                                    }
                                                ]
                                            },
                                            "AddlDocDtls": [
                                                {
                                                    "Url": "https://einv-apisandbox.nic.in",
                                                    "Docs": "Test Doc",
                                                    "Info": "Document Test"
                                                }
                                            ],
                                            "EwbDtls": {
                                                "TransId": null,
                                                "TransName": null,
                                                "Distance": 1,
                                                "TransDocNo": null,
                                                "TransDocDt": null,
                                                "VehNo": "ka123456",
                                                "VehType": "R",
                                                "TransMode": "1"
                                            }
                                    }';

                            $APIResponse1 = callAPICurl($APIUrl, $APIPost);
                            // echo $APIPost;
                            //INSERT RESPONSE IN DB ---
                            $sql = "UPDATE acc_einvoice_up SET
                                    APICalled = 1,APICalledAt= GETDATE(),APIResponse = '" . db::getInstance()->real_escape_string($APIResponse1) . "',
                                    APIURL = '$APIUrl',APIPost = '" . db::getInstance()->real_escape_string($APIPost) . "',
                                    Response_Error ='' WHERE ID = $id";
                            db::getInstance()->db_update($sql);
                            // echo gettype($APIResponse1);
                            if (!is_array($APIResponse1)) {
                                // print_r($APIResponse1);
                                // $APIResponse = json_decode($APIResponse1, true);
                                // if (isset($APIResponse['Data'])) {
                                //     $APIResponse['Data'] = json_decode($APIResponse['Data'], true);
                                // }
                                $jsonString = stripslashes($APIResponse1); 
                                $jsonString = preg_replace('/"Data":"({.*})"/', '"Data":$1', $jsonString);
                                $array = json_decode($jsonString, true);

                                if (json_last_error() !== JSON_ERROR_NONE) {
                                    echo "Error in decoding JSON: " . json_last_error_msg();
                                } else {
                                    // echo 'no error';
                                    // Decode the nested 'Data' field
                                    if (isset($array['Data']) && is_string($array['Data'])) {
                                        $array['Data'] = json_decode($array['Data'], true);
                                        if (json_last_error() !== JSON_ERROR_NONE) {
                                            echo "Error in decoding nested JSON: " . json_last_error_msg();
                                        } else {
                                            // echo "New array";
                                            // print_r($array); // Print the final array
                                        }
                                    }
                                }
                                $APIResponse = $array;
                            }else{
                                $APIResponse = $APIResponse1;
                            }
                            
                            /*
                                {Status: "0", Data: null, ErrorDetails: [{ErrorCode: "2150", ErrorMessage: "Duplicate IRN"}],…}
                                Data
                                : 
                                null
                                ErrorDetails
                                : 
                                [{ErrorCode: "2150", ErrorMessage: "Duplicate IRN"}]
                                0
                                : 
                                {ErrorCode: "2150", ErrorMessage: "Duplicate IRN"}
                                ErrorCode
                                : 
                                "2150"
                                ErrorMessage
                                : 
                                "Duplicate IRN"
                                InfoDtls
                                : 
                                [{InfCd: "DUPIRN", Desc: {AckNo: 152510024521002, AckDt: "2025-03-08 12:24:00",…}}]
                                0
                                : 
                                {InfCd: "DUPIRN", Desc: {AckNo: 152510024521002, AckDt: "2025-03-08 12:24:00",…}}
                                Desc
                                : 
                                {AckNo: 152510024521002, AckDt: "2025-03-08 12:24:00",…}
                                AckDt
                                : 
                                "2025-03-08 12:24:00"
                                AckNo
                                : 
                                152510024521002
                                Irn
                                : 
                                "34f69bc52f5d101a68c22d561e8d1edeb96953799f34feab16b7d154307b110b"
                                InfCd
                                : 
                                "DUPIRN"
                                Status
                                : 
                                "0"
                                error_cd
                                : 
                                ""
                                error_message
                                : 
                                ""
                                status_cd
                                : 
                                "1" 
                            */
                            /**** SUCCESS
                             * 
                             * {"Status":"1","Data":"{"AckNo":152510024538118,"AckDt":"2025-03-15 19:59:08","Irn":"c5dcfa9f8cf4d9751b4d6e4c595bc5cd43f3fadadbebc47b028b77d580129ede","SignedInvoice":"eyJhbGciOiJSUzI1NiIsImtpZCI6IjNCRTE3RTUxNDE5MjUyMjY0N0YwMUZEQkZGNTI3MUFENTI2OEQ3MzUiLCJ4NXQiOiJPLUYtVVVHU1VpWkg4Ql9iXzFKeHJWSm8xelUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJOSUMgU2FuZGJveCIsImRhdGEiOiJ7XCJBY2tOb1wiOjE1MjUxMDAyNDUzODExOCxcIkFja0R0XCI6XCIyMDI1LTAzLTE1IDE5OjU5OjA4XCIsXCJJcm5cIjpcImM1ZGNmYTlmOGNmNGQ5NzUxYjRkNmU0YzU5NWJjNWNkNDNmM2ZhZGFkYmViYzQ3YjAyOGI3N2Q1ODAxMjllZGVcIixcIlZlcnNpb25cIjpcIjEuMVwiLFwiVHJhbkR0bHNcIjp7XCJUYXhTY2hcIjpcIkdTVFwiLFwiU3VwVHlwXCI6XCJCMkJcIixcIlJlZ1JldlwiOlwiWVwiLFwiSWdzdE9uSW50cmFcIjpcIk5cIn0sXCJEb2NEdGxzXCI6e1wiVHlwXCI6XCJJTlZcIixcIk5vXCI6XCJET0MxLzYwOTUxXCIsXCJEdFwiOlwiMDIvMDMvMjAyNVwifSxcIlNlbGxlckR0bHNcIjp7XCJHc3RpblwiOlwiMzRBQUNDQzE1OTZRMDAyXCIsXCJMZ2xObVwiOlwiTklDIGNvbXBhbnkgcHZ0IGx0ZFwiLFwiVHJkTm1cIjpcIk5JQyBJbmR1c3RyaWVzXCIsXCJBZGRyMVwiOlwiNXRoIGJsb2NrLCBrdXZlbXB1IGxheW91dFwiLFwiQWRkcjJcIjpcImt1dmVtcHUgbGF5b3V0XCIsXCJMb2NcIjpcIkdBTkRISU5BR0FSXCIsXCJQaW5cIjo2MDUwMDEsXCJTdGNkXCI6XCIzNFwiLFwiUGhcIjpcIjkwMDAwMDAwMDBcIixcIkVtXCI6XCJhYmNAZ21haWwuY29tXCJ9LFwiQnV5ZXJEdGxzXCI6e1wiR3N0aW5cIjpcIjI5QVdHUFY3MTA3QjFaMVwiLFwiTGdsTm1cIjpcIlhZWiBjb21wYW55IHB2dCBsdGRcIixcIlRyZE5tXCI6XCJYWVogSW5kdXN0cmllc1wiLFwiUG9zXCI6XCIxMlwiLFwiQWRkcjFcIjpcIjd0aCBibG9jaywga3V2ZW1wdSBsYXlvdXRcIixcIkFkZHIyXCI6XCJrdXZlbXB1IGxheW91dFwiLFwiTG9jXCI6XCJHQU5ESElOQUdBUlwiLFwiUGluXCI6NTYyMTYwLFwiUGhcIjpcIjkxMTExMTExMTExXCIsXCJFbVwiOlwieHl6QHlhaG9vLmNvbVwiLFwiU3RjZFwiOlwiMjlcIn0sXCJEaXNwRHRsc1wiOntcIk5tXCI6XCJBQkMgY29tcGFueSBwdnQgbHRkXCIsXCJBZGRyMVwiOlwiN3RoIGJsb2NrLCBrdXZlbXB1IGxheW91dFwiLFwiQWRkcjJcIjpcImt1dmVtcHUgbGF5b3V0XCIsXCJMb2NcIjpcIkJhbmFnYWxvcmVcIixcIlBpblwiOjU2MjE2MCxcIlN0Y2RcIjpcIjI5XCJ9LFwiSXRlbUxpc3RcIjpbe1wiSXRlbU5vXCI6MCxcIlNsTm9cIjpcIjFcIixcIklzU2VydmNcIjpcIk5cIixcIlByZERlc2NcIjpcIlJpY2VcIixcIkhzbkNkXCI6XCIxMDAxXCIsXCJCYXJjZGVcIjpcIjEyMzU2XCIsXCJRdHlcIjoxMDAuMzQ1LFwiRnJlZVF0eVwiOjEwLFwiVW5pdFwiOlwiQkFHXCIsXCJVbml0UHJpY2VcIjo5OS41NDUsXCJUb3RBbXRcIjo5OTc4Ljg0LFwiRGlzY291bnRcIjowLFwiUHJlVGF4VmFsXCI6MSxcIkFzc0FtdFwiOjk5NzguODQsXCJHc3RSdFwiOjEyLjAsXCJJZ3N0QW10XCI6MTE5Ny40NixcIkNnc3RBbXRcIjowLFwiU2dzdEFtdFwiOjAsXCJDZXNSdFwiOjUsXCJDZXNBbXRcIjo0OTguOTQsXCJDZXNOb25BZHZsQW10XCI6MTAsXCJTdGF0ZUNlc1J0XCI6MTIsXCJTdGF0ZUNlc0FtdFwiOjExOTcuNDYsXCJTdGF0ZUNlc05vbkFkdmxBbXRcIjo1LFwiT3RoQ2hyZ1wiOjEwLFwiVG90SXRlbVZhbFwiOjEyODk3LjcsXCJPcmRMaW5lUmVmXCI6XCIzMjU2XCIsXCJPcmdDbnRyeVwiOlwiQUdcIixcIlByZFNsTm9cIjpcIjEyMzQ1XCIsXCJCY2hEdGxzXCI6e1wiTm1cIjpcIjEyMzQ1NlwiLFwiRXhwRHRcIjpcIjAxLzA4LzIwMjBcIixcIldyRHRcIjpcIjAxLzA5LzIwMjBcIn0sXCJBdHRyaWJEdGxzXCI6W3tcIk5tXCI6XCJSaWNlXCIsXCJWYWxcIjpcIjEwMDAwXCJ9XX1dLFwiVmFsRHRsc1wiOntcIkFzc1ZhbFwiOjk5NzguODQsXCJDZ3N0VmFsXCI6MCxcIlNnc3RWYWxcIjowLFwiSWdzdFZhbFwiOjExOTcuNDYsXCJDZXNWYWxcIjo1MDguOTQsXCJTdENlc1ZhbFwiOjEyMDIuNDYsXCJEaXNjb3VudFwiOjEwLFwiT3RoQ2hyZ1wiOjIwLFwiUm5kT2ZmQW10XCI6MC4zLFwiVG90SW52VmFsXCI6MTI5MDgsXCJUb3RJbnZWYWxGY1wiOjEyODk3Ljd9LFwiUGF5RHRsc1wiOntcIk5tXCI6XCJBQkNERVwiLFwiQWNjRGV0XCI6XCI1Njk3Mzg5NzEzMjEwXCIsXCJNb2RlXCI6XCJDYXNoXCIsXCJGaW5JbnNCclwiOlwiU0JJTjExMDAwXCIsXCJQYXlUZXJtXCI6XCIxMDBcIixcIlBheUluc3RyXCI6XCJHaWZ0XCIsXCJDclRyblwiOlwidGVzdFwiLFwiRGlyRHJcIjpcInRlc3RcIixcIkNyRGF5XCI6MTAwLFwiUGFpZEFtdFwiOjEwMDAwLFwiUGF5bXREdWVcIjo1MDAwfSxcIlJlZkR0bHNcIjp7XCJJbnZSbVwiOlwiVEVTVFwiLFwiRG9jUGVyZER0bHNcIjp7XCJJbnZTdER0XCI6XCIwMS8wOC8yMDIwXCIsXCJJbnZFbmREdFwiOlwiMDEvMDkvMjAyMFwifSxcIlByZWNEb2NEdGxzXCI6W3tcIkludk5vXCI6XCJET0MvMDAyXCIsXCJJbnZEdFwiOlwiMDEvMDgvMjAyMFwiLFwiT3RoUmVmTm9cIjpcIjEyMzQ1NlwifV0sXCJDb250ckR0bHNcIjpbe1wiUmVjQWR2UmVmclwiOlwiRG9jLzAwM1wiLFwiUmVjQWR2RHRcIjpcIjAxLzA4LzIwMjBcIixcIlRlbmRSZWZyXCI6XCJBYmMwMDFcIixcIkNvbnRyUmVmclwiOlwiQ28xMjNcIixcIkV4dFJlZnJcIjpcIllvNDU2XCIsXCJQcm9qUmVmclwiOlwiRG9jLTQ1NlwiLFwiUE9SZWZyXCI6XCJEb2MtNzg5XCIsXCJQT1JlZkR0XCI6XCIwMS8wOC8yMDIwXCJ9XX0sXCJBZGRsRG9jRHRsc1wiOlt7XCJVcmxcIjpcImh0dHBzOi8vZWludi1hcGlzYW5kYm94Lm5pYy5pblwiLFwiRG9jc1wiOlwiVGVzdCBEb2NcIixcIkluZm9cIjpcIkRvY3VtZW50IFRlc3RcIn1dLFwiRXdiRHRsc1wiOntcIlRyYW5zTW9kZVwiOlwiMVwiLFwiRGlzdGFuY2VcIjoxLFwiVmVoTm9cIjpcImthMTIzNDU2XCIsXCJWZWhUeXBlXCI6XCJSXCJ9fSJ9.jorzCUhqap0JgV-WDeJM-AFjjcaxs6JoLiwIaqSt6NY1IOylJoj89X-t5HAddSDN-FFOIpI0YKnEVX9n2mfPXfhzxNhao3wFOV8YGMXwJj5llQYhgQWb1SmCyoGpCdtI2lSzJxk-4RHizZxdfk-jUW8P3ovRJ4Lj_IXEMrzdj7T_Nret5rRbP1kgiB43J02o57CQxkyQC9_dZlfMyPZ0lHN3y2sYg2F0br5ASSUTAFXDnQqSdoaNx1azsR7m0Y5vKMqUYi7er5zhVxYciqIVnWO-7EQ_SIeV6FrbSXPv0iFJ5Q7zCGtxfkN5goyQx8zT-XylW-hOwgTKPsyeBLUOzg","SignedQRCode":"eyJhbGciOiJSUzI1NiIsImtpZCI6IjNCRTE3RTUxNDE5MjUyMjY0N0YwMUZEQkZGNTI3MUFENTI2OEQ3MzUiLCJ4NXQiOiJPLUYtVVVHU1VpWkg4Ql9iXzFKeHJWSm8xelUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJOSUMgU2FuZGJveCIsImRhdGEiOiJ7XCJTZWxsZXJHc3RpblwiOlwiMzRBQUNDQzE1OTZRMDAyXCIsXCJCdXllckdzdGluXCI6XCIyOUFXR1BWNzEwN0IxWjFcIixcIkRvY05vXCI6XCJET0MxLzYwOTUxXCIsXCJEb2NUeXBcIjpcIklOVlwiLFwiRG9jRHRcIjpcIjAyLzAzLzIwMjVcIixcIlRvdEludlZhbFwiOjEyOTA4LFwiSXRlbUNudFwiOjEsXCJNYWluSHNuQ29kZVwiOlwiMTAwMVwiLFwiSXJuXCI6XCJjNWRjZmE5ZjhjZjRkOTc1MWI0ZDZlNGM1OTViYzVjZDQzZjNmYWRhZGJlYmM0N2IwMjhiNzdkNTgwMTI5ZWRlXCIsXCJJcm5EdFwiOlwiMjAyNS0wMy0xNSAxOTo1OTowOFwifSJ9.Y3k4lvYoSevleZGlbdtdjYjgCJ6y-5fmCLF6dWcDcOzA7chMf8te9wOZxzYKNp__kCWlL_Z3CqYzAwzaYvfXUr4Wo2kDIF4e48R-nKEeOw0b23DbC05mVkeEF5L27a74amlW7zA2R83jerAFRRCaet7n64yPrM5R_ibE6Bslnb7i2zRoZiARJi7pq4wTO0f6942G4I9QtcxN5bDdAyhBEMXFKdZGJ9esGfD-QkrxTrPrrieWxS9Q12tN_0xWHGUcFSlU5JoAniAuHVNeNTNR_1xDp4cNQTErEIiHQ2iGeiEfISFF1HuLjRcCjg9L0lei7Pr6W4vizwv_xs4wKTidJw","Status":"ACT","EwbNo":531008946729,"EwbDt":"2025-03-15 19:59:00","EwbValidTill":"2025-03-16 23:59:00","Remarks":null}","ErrorDetails":null,"InfoDtls":null,"status_cd":"1","error_cd":"","error_message":""}
                             * 
                             * */ 

                            //Check for errors:
                            //token error:{"status_cd":"0","error_cd":"GSP752","error_message":"Error: eInvoice AuthToken not found or expired."}
                            if($APIResponse['status_cd'] == 0 || $APIResponse['status_cd'] == "0"){
                                $error = 2;
                                $error_msg = $APIResponse['error_message'];
                            }else{
                                if(is_array($APIResponse['ErrorDetails'])){
                                    $error = 3;
                                    $error_msg = $APIResponse['ErrorDetails'][0]['ErrorMessage'];
                                }else{
                                    if($APIResponse['status_cd'] == 1 && is_array($APIResponse['Data'])){
                                        // echo "SUCCESS";
                                        $d = $APIResponse['Data'];
                                        $output = $d;
                                        
                                        // $data = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjNCRTE3RTUxNDE5MjUyMjY0N0YwMUZEQkZGNTI3MUFENTI2OEQ3MzUiLCJ4NXQiOiJPLUYtVVVHU1VpWkg4Ql9iXzFKeHJWSm8xelUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJOSUMgU2FuZGJveCIsImRhdGEiOiJ7XCJTZWxsZXJHc3RpblwiOlwiMzRBQUNDQzE1OTZRMDAyXCIsXCJCdXllckdzdGluXCI6XCIyOUFXR1BWNzEwN0IxWjFcIixcIkRvY05vXCI6XCJET0MxLzYwOTM2LTEwXCIsXCJEb2NUeXBcIjpcIklOVlwiLFwiRG9jRHRcIjpcIjAyLzAzLzIwMjVcIixcIlRvdEludlZhbFwiOjEyOTA4LFwiSXRlbUNudFwiOjEsXCJNYWluSHNuQ29kZVwiOlwiMTAwMVwiLFwiSXJuXCI6XCI0NWRmNTk1NmE1NjEwM2Y5ZWE3ZjA3YjQ4NjIwZjU5YTQ1ZTZjNjE3NmQyMTE3OWE0MDFiMmI5Nzk5NjgzNWMzXCIsXCJJcm5EdFwiOlwiMjAyNS0wMy0xNyAxNjoxNjozOFwifSJ9.FkndqNcmwqi8GSbQ4qHMU1OpuHochIbdvIzm0uyJNVqJAhw6geBgsSasKh557z3zQV6A6aoUC_6m-C_D9rs-vRerUl2XG9dbamI9tlPC0H6iZhRod8BwBLoP33rtEL9WpO_XdtheBUwmhquI2qI_C5Mj1p2AxiSIpA3nD5tPAw4mPElJ9knFB7-xw7ZiuDVT_DeH1xJMDnEoBy1wO0Lz12l-wKZIDdcfzrFN-WrOTTu43eIVGjgk-xSnMZEPAmrO1Fs8n2DD2pIFbtHMaytgufhmeGcL5ZalAVSOBUCZlSYq-PP1Cz7MkuyDH-3zmb9-qMCPHi7iiSjmoS2chhxA_w'; // The data to encode in the QR code
                                        $outputFolder = 'qrcodes'; // Folder to save the QR code image
                                        $fileName = 'Einvoice_'.$FormID.'_'.$_SESSION['dbCompany'].'_'.$EntryID.'.png'; // Name of the output file
                                        
                                        include_once('generateBarcodeImage.php');
                                        $filePath = generateQRCode($d['SignedQRCode'], $outputFolder, $fileName);
                                        $fullFile = CODE_PATH . $outputFolder . '\\' . $fileName; 
                                        
                                        // $sql = "INSERT INTO EinvoiceImageTmp ([id],[EntryID],[CompanyID],[DivisionID],[YearCode],[FormID],[Response_QRImage],[Image_name]) VALUES(".$id.",".$id.",'".$_SESSION['dbCompany']."','".$_SESSION['dbDivision']."','".$_SESSION['dbYear']."','".$FormID."',SELECT * FROM OPENROWSET(BULK N'" . $fullFile . "', SINGLE_BLOB) AS ImageFile,'".$fullFile."')";
                                        // db::getInstanceMaster()->db_insertQuery($sql);

                                        // $rs = db::getInstanceMaster()->db_select("SELECT * FROM OPENROWSET(BULK N'" . $fullFile . "', SINGLE_BLOB) AS ImageFile");
                                        // print_r($rs);
                                        // $img = strlen($rs['result_set'][0]['BulkColumn']) > 2 ? $rs['result_set'][0]['BulkColumn'] : null;
                                        $sql = "UPDATE acc_einvoice_up SET 
                                                Response_AckNo = '".$d['AckNo']."',
                                                Response_AckDt ='".$d['AckDt']."',
                                                Response_Irn ='".$d['Irn']."',
                                                Response_SignedInvoice ='".$d['SignedInvoice']."',
                                                Response_SignedQRCode ='".$d['SignedQRCode']."',
                                                Response_Status ='".$d['Status']."',
                                                Response_EwbNo ='".$d['EwbNo']."',
                                                Response_EwbDt ='".$d['EwbDt']."',
                                                Response_EwbValidTill ='".$d['EwbValidTill']."',
                                                Response_Remarks ='".db::getInstance()->real_escape_string($d['Remarks'])."',
                                                Response_Error ='',                                            
                                                Response_QRImageName = '" . $fullFile . "'
                                                WHERE ID = " . $id;
                                            // Response_QRImage = '".$img."',
                                            // Response_QRImageName = '" . $fileName . "'
                                                db::getInstance()->db_update($sql);
                                        /* Update image in the above table using linkserver SP*/
                                        

                                        $binary = file_get_contents($fullFile);
                                        $hex = "0x" . bin2hex($binary);
                                        $sql = "update acc_einvoice_up SET Response_QRImage=".$hex." WHERE ID = " . $id;
                                        $result = db::getInstance()->db_update($sql);
                                        // $session ='YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';
                                        // $data['params'] = ['@servername','@ipaddress','@database','@userid','@password','@id'];

                                        // $sp['values'] = [$_SESSION['dbCompanyName'] . "_" . $_SESSION['user_id'],
                                        //                     $_SESSION['dbHost'],
                                        //                     $_SESSION['dbName'],
                                        //                     $_SESSION['user_id'],
                                        //                     $_SESSION['dbPass'],
                                        //                     $id
                                        //                 ];
                                        // $result = db::getInstance()->db_sp_select('SP_AddLinkServer', $data['params'], $sp['values']);

                                        $output['QRCode'] = 'getDatabaseImage.php?case=1&id=' . $id;
                                    }
                                }
                            }

                        }else{
                            //SHOW ERROR MSG FROM VALIDATION SP
                            $error = 4;
                            $error_msg = isset($result['result_set'][0][0]['Msg']) ? $result['result_set'][0][0]['Msg'] : 'Error in Validation';
                        }
                    }else{
                        $error = 5;
                        $error_msg = 'Error in Validation Output';
                    }
                }
            }
        }
    
        break;
    case 'eway':
        $APIModeSandbox = 0; //1=> sandbox 0 => Production
        $spExists = false;
        $SPName = 'sp_API_ValidateEwaybill';
        $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
        $sqlresult = db::getInstance()->db_select($sql);
        // print_r($sqlresult);
        // echo $_SESSION['dbName'];
        if($sqlresult['result_set'][0]['found'] == 1){
            //BEFORE CALLING SP CHECK IF ITS ALREADY GENERATED EARLIER
            $sql = "select * from acc_ewaybill_up where  CompanyID=".$_SESSION['dbCompany']." AND DivisionID=".$_SESSION['dbDivision'] ."
                    AND YearCode='".$_SESSION['dbYear']."' AND FormID=".$FormID." AND EntryID=".$EntryID . " AND APICalled=1 AND API_Status=1";
            $result = db::getInstance()->db_select($sql);
            if($result['num_rows'] > 0){
                //ALREADY GENERATED...
                $error = 12;
                $error_msg = "E-way Bill already generated.";
                $output = $result['result_set'][0];
            }else{
                $spExists = true;
                $params = ['@formid','@entryid','@userid','@company','@division','@ycode', '@form'];
                $values = [$FormID,$EntryID,$_SESSION['user_id'],$_SESSION['dbCompany'],$_SESSION['dbDivision'],$_SESSION['dbYear'], "'" . str_replace("'", "''",$FormData ?? '') . "'"];
                $result = db::getInstance()->db_sp_select($SPName, $params, $values);
                if($result['error'] != 0){
                    $error = 1;
                    $error_msg = $result['error_statement'];
                }else{
                    if(is_array($result['result_set'][0][0])){
                        // print_r($result);
                        if($result['result_set'][0][0]['success'] !== 0){

                            $id = $result['result_set'][0][0]['id'];
                            if($id > 0){}
                            /***************
                            Add Validation
                            ****************/
                            $sql = "SELECT Gspuserid, Gsppsw, gstno, Api_Token, Api_TokenExpiry FROM mst_party_company WHERE Companyid = " . $_SESSION['dbCompany'];
                            $GSPresult = db::getInstance()->db_select($sql);
                            if($GSPresult['num_rows'] > 0){
                                if(strlen($GSPresult['result_set'][0]['Gspuserid']) > 2 && strlen($GSPresult['result_set'][0]['Gsppsw']) > 0 && strlen($GSPresult['result_set'][0]['gstno']) > 10) {
                                    //continue
                                }else{
                                    $error = 31;
                                    $error_msg = "Error in GSP details for the company";
                                    goto OutofEway;
                                }
                            }else{
                                $error = 32;
                                $error_msg = "Unable to get GSP details for the company";
                                goto OutofEway;
                            }
                            // Fetch data from tb_up
                            $tb_up_sql = "SELECT [ID],[supplyType],[subSupplyType],[subSupplyDesc],[docType],[docNo],CONVERT(VARCHAR, docDate, 103) as docDate,[fromGstin],[fromTrdName],[fromAddr1],[fromAddr2],[fromPlace],[fromPincode],[actFromStateCode],[fromStateCode],[toGstin],[toTrdName],[toAddr1],[toAddr2],[toPlace],[toPincode]
                                        ,[actToStateCode],[toStateCode],[transactionType],[otherValue],[totalValue],[cgstValue],[sgstValue],[igstValue],[cessValue],[cessNonAdvolValue],[totInvValue],[transporterId],[transporterName],[transDocNo],[transMode],[transDistance],CONVERT(VARCHAR, transDocDate, 103) as transDocDate,[vehicleNo],[vehicleType]
                                        FROM [dbo].[acc_ewaybill_up] WHERE ID = " . $id; 
                            $tb_up_result = db::getInstance()->db_select($tb_up_sql);
                            $tb_up_data = $tb_up_result['result_set'][0];

                            // Fetch data from tb_mid
                            $tb_mid_sql = "SELECT * FROM acc_ewaybill_mid WHERE EntryID = " . $id; 
                            $tb_mid_result =db::getInstance()->db_select($tb_mid_sql);
                            // print_r($tb_up_result);
                            $tb_mid_data = [];
                            $i = 0;
                            while ($i < sizeof($tb_mid_result['result_set'])) {
                                $tb_mid_data[] = $tb_mid_result['result_set'][$i++];
                            }
                            
                            if(strlen($tb_up_data["vehicleNo"]) == 0){
                                $tb_up_data["transMode"] = null;
                            }
                            $APIPost = [
                                "supplyType" => $tb_up_data["supplyType"],
                                "subSupplyType" => $tb_up_data["subSupplyType"],
                                "subSupplyDesc" => $tb_up_data["subSupplyDesc"],
                                "docType" => $tb_up_data["docType"],
                                "docNo" => $tb_up_data["docNo"],
                                "docDate" => $tb_up_data["docDate"],
                                "fromGstin" => $tb_up_data["fromGstin"],
                                "fromTrdName" => $tb_up_data["fromTrdName"],
                                "fromAddr1" => $tb_up_data["fromAddr1"],
                                "fromAddr2" => $tb_up_data["fromAddr2"],
                                "fromPlace" => $tb_up_data["fromPlace"],
                                "fromPincode" => $tb_up_data["fromPincode"],
                                "actFromStateCode" => $tb_up_data["actFromStateCode"],
                                "fromStateCode" => $tb_up_data["fromStateCode"],
                                "toGstin" => $tb_up_data["toGstin"],
                                "toTrdName" => $tb_up_data["toTrdName"],
                                "toAddr1" => $tb_up_data["toAddr1"],
                                "toAddr2" => $tb_up_data["toAddr2"],
                                "toPlace" => $tb_up_data["toPlace"],
                                "toPincode" => $tb_up_data["toPincode"],
                                "actToStateCode" => $tb_up_data["actToStateCode"],
                                "toStateCode" => $tb_up_data["toStateCode"],
                                "transactionType" => $tb_up_data["transactionType"],
                                "otherValue" => $tb_up_data["otherValue"],
                                "totalValue" => $tb_up_data["totalValue"],
                                "cgstValue" => $tb_up_data["cgstValue"],
                                "sgstValue" => $tb_up_data["sgstValue"],
                                "igstValue" => $tb_up_data["igstValue"],
                                "cessValue" => $tb_up_data["cessValue"],
                                "cessNonAdvolValue" => $tb_up_data["cessNonAdvolValue"],
                                "totInvValue" => $tb_up_data["totInvValue"],
                                "transporterId" => $tb_up_data["transporterId"],
                                "transporterName" => $tb_up_data["transporterName"],
                                "transDocNo" => $tb_up_data["transDocNo"],
                                "transMode" => $tb_up_data["transMode"],
                                "transDistance" => $tb_up_data["transDistance"],
                                "transDocDate" => $tb_up_data["transDocDate"],
                                "vehicleNo" => $tb_up_data["vehicleNo"],
                                "vehicleType" => $tb_up_data["vehicleType"],
                                "itemList" => array_map(function ($item) {
                                    // Exclude items with null or missing values
                                    if (isset($item["itemList_productName"]) && isset($item["itemList_quantity"]) && $item["itemList_quantity"] !== null) {
                                        return [
                                            "productName" => $item["itemList_productName"],
                                            "productDesc" => $item["itemList_productDesc"] ?? '', // Default to empty string if key is missing
                                            "hsnCode" => $item["itemList_hsnCode"] ?? '', // Default to empty string
                                            "quantity" => $item["itemList_quantity"],
                                            "qtyUnit" => $item["itemList_qtyUnit"] ?? '', // Default to empty string
                                            "cgstRate" => $item["itemList_cgstRate"] ?? 0, // Default to 0 if key is missing
                                            "sgstRate" => $item["itemList_sgstRate"] ?? 0,
                                            "igstRate" => $item["itemList_igstRate"] ?? 0,
                                            "cessRate" => $item["itemList_cessRate"] ?? 0,
                                            "cessNonadvol" => $item["itemList_cessNonadvol"] ?? 0,
                                            "taxableAmount" => $item["itemList_taxableAmount"] ?? 0
                                        ];
                                    }
                                    return null; // Return null for invalid items
                                }, $tb_mid_data)
                            ];
                            
                            // Remove null entries from itemList
                            $APIPost['itemList'] = array_filter($APIPost['itemList']);
                            
                            $APIPost = json_encode($APIPost, JSON_PRETTY_PRINT);
                            // echo $APIPost;
                            //CALL API
                            $access_token = '1XPLm4qjAVTeoiUXs4Tw74XDP';
                            $aspid = '1773362725';
                            $password = 'Mf89%3DN32]mIZ}1bn'; 

                            $sql = "SELECT Api_Token FROM mst_party_company WHERE Api_TokenExpiry BETWEEN GETDATE() AND DATEADD(HOUR, 6, GETDATE()) AND Companyid = " . $_SESSION['dbCompany'];
                            $Tresult = db::getInstance()->db_select($sql);
                            // print_r($Tresult);
                            if($Tresult['num_rows'] > 0){
                                $access_token = $Tresult['result_set'][0]['Api_Token'];
                            }else{
                                $response = getGSTTokenProduction($GSPresult['result_set'][0]['Gspuserid'], $GSPresult['result_set'][0]['Gsppsw'], $GSPresult['result_set'][0]['gstno']);
                                
                                // $sql = "UPDATE acc_einvoice_up SET Token_APIResponse = '" . db::getInstance()->real_escape_string(json_encode($response)) . "',
                                //         Token_APIPost = '" . db::getInstance()->real_escape_string($GSPresult['result_set'][0]['Gspuserid'] . ' = ' . $GSPresult['result_set'][0]['Gsppsw'] . ' = ' . $GSPresult['result_set'][0]['gstno']) . "' WHERE ID = $id";
                                // db::getInstance()->db_update($sql);

                                if(isset($response['Status'])){
                                    if($response['Status'] == 1){
                                        $access_token = $response['Data']['AuthToken'];
                                        $token_expiry = $response['Data']['TokenExpiry'];
                                        $sql = "UPDATE mst_party_company SET Api_Token = '".$response['Data']['AuthToken']."', Api_TokenExpiry ='".$response['Data']['TokenExpiry']."' WHERE Companyid = " . $_SESSION['dbCompany'];
                                        db::getInstance()->db_update($sql);
                                    }
                                }
                            }
                            // print_r($response);
                            if(isset($response['Status'])){
                                if($response['Status'] == 1){
                                    $access_token = $response['Data']['AuthToken'];
                                    $token_expiry = $response['Data']['TokenExpiry'];
                                }
                            }   
                            // break;                        
                            // $APIUrl = 'http://gstsandbox.charteredinfo.com/ewaybillapi/dec/v1.03/ewayapi?action=GENEWAYBILL&'.$aspid.'&password='.$password.'&Gstin=34AACCC1596Q002&eInvPwd=abc34*&AuthToken='.$access_token.'&QrCodeSize=250&ParseIrnResp=0&User_name=TaxProEnvPON&fortally=1';
                            $APIUrl = 'https://einvapi.charteredinfo.com/v1.03/dec/ewayapi?action=GENEWAYBILL&'.$aspid.'&password='.$password.'&Gstin='.$GSPresult['result_set'][0]['gstno'].'&AuthToken='.$access_token.'&User_name=' . $GSPresult['result_set'][0]['Gspuserid'];
                           
                            $APIResponse1 = callAPICurl($APIUrl, $APIPost);
                            // print_r($APIResponse1);
                            //INSERT RESPONSE IN DB
                            $sql = "UPDATE acc_ewaybill_up SET APICalled = 1,APICalledAt= GETDATE(),APIResponse = '$APIResponse1',
                                    APIURL = '$APIUrl',APIPost = '$APIPost' WHERE ID = $id";
                            $res = db::getInstance()->db_update($sql);
                            // print_r($res);
                            if (!is_array($APIResponse1)) {
                                // $jsonString = stripslashes($APIResponse1); 
                                $APIResponse = json_decode($APIResponse1, true);
                            }else{
                                $APIResponse = $APIResponse1;
                            }
                            if(0){
                                // if($APIResponse['status_cd'] == 0 || $APIResponse['status_cd'] == "0"){
                                $error = 2;
                                $error_msg = $APIResponse['error']['message'];
                            }else{
                                // echo "in 1st else";
                                if(isset($APIResponse['status_cd']) && is_array($APIResponse['error'])){
                                    $error = 3;
                                    $error_msg = $APIResponse['error']['message'];
                                }else{
                                    // echo "in else";
                                    $output = $APIResponse;
                                    // if($APIResponse['status_cd'] == 1 || $APIResponse['status_cd'] == "1" ){
                                        $tmp = '';
                                        if(isset($APIResponse['ewayBillNo'])) $tmp = ' API_Status = 1,';
                                        $sql = "UPDATE acc_ewaybill_up SET 
                                                Response_EwaybillNo = '".$APIResponse['ewayBillNo']."',
                                                Response_EwaybillDate ='".$APIResponse['ewayBillDate']."',
                                                ".$tmp."
                                                Response_ValidUpto ='".$APIResponse['validUpto']."'
                                                WHERE ID = " . $id;
                                        $res = db::getInstance()->db_update($sql);
                                        // print_r($res);
                                    // }
                                }
                            }
                        }else{
                            //SHOW ERROR MSG FROM VALIDATION SP
                            $error = 4;
                            $error_msg = isset($result['result_set'][0][0]['Msg']) ? $result['result_set'][0][0]['Msg'] : 'Error in Validation';
                        }
                    }else{
                        $error = 5;
                        $error_msg = 'Error in Validation Output';
                    }
                }
            }
        }
        OutofEway:
        break;
    case 'eway-test':
        $APIModeSandbox = 1; //1=> sandbox 0 => Production
        $spExists = false;
        $SPName = 'sp_API_ValidateEwaybill';
        $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
        $sqlresult = db::getInstance()->db_select($sql);
        // print_r($sqlresult);
        // echo $_SESSION['dbName'];
        if($sqlresult['result_set'][0]['found'] == 1){
            //BEFORE CALLING SP CHECK IF ITS ALREADY GENERATED EARLIER
            $sql = "select * from acc_ewaybill_up where  CompanyID=".$_SESSION['dbCompany']." AND DivisionID=".$_SESSION['dbDivision'] ."
                    AND YearCode='".$_SESSION['dbYear']."' AND FormID=".$FormID." AND EntryID=".$EntryID . " AND APICalled=1 AND API_Status=1";
            $result = db::getInstance()->db_select($sql);
            if($result['num_rows'] > 0){
                //ALREADY GENERATED...
                $error = 0;
                $error_msg = "E-way Bill already generated.";
                $output = $result['result_set'][0];
            }else{
                $spExists = true;
                $params = ['@formid','@entryid','@userid','@company','@division','@ycode', '@form'];
                $values = [$FormID,$EntryID,$_SESSION['user_id'],$_SESSION['dbCompany'],$_SESSION['dbDivision'],$_SESSION['dbYear'], "'" . str_replace("'", "''",$FormData ?? '') . "'"];
                $result = db::getInstance()->db_sp_select($SPName, $params, $values);
                // echo "<br />Calling SP<br />";
                // print_r($result);
                // exit;
                /*
                    Array(
                        [error] => 0
                        [error_statement] => 
                        [result_set] => Array
                            (
                                [0] => Array
                                    (
                                        [0] => Array
                                            (
                                                [success] => 1
                                                [id] => 21
                                            )

                                    )

                            )

                    )

                */
                if($result['error'] != 0){
                    $error = 1;
                    $error_msg = $result['error_statement'];
                }else{
                    if(is_array($result['result_set'][0][0])){
                        if($result['result_set'][0][0]['success'] !== 0){

                            $id = $result['result_set'][0][0]['id'];
                            if($id > 0){}
                            /***************
                            Add Validation
                            ****************/
                            // Fetch data from tb_up
                            $tb_up_sql = "SELECT [ID],[supplyType],[subSupplyType],[subSupplyDesc],[docType],[docNo],CONVERT(VARCHAR, docDate, 103) as docDate,[fromGstin],[fromTrdName],[fromAddr1],[fromAddr2],[fromPlace],[fromPincode],[actFromStateCode],[fromStateCode],[toGstin],[toTrdName],[toAddr1],[toAddr2],[toPlace],[toPincode]
                                        ,[actToStateCode],[toStateCode],[transactionType],[otherValue],[totalValue],[cgstValue],[sgstValue],[igstValue],[cessValue],[cessNonAdvolValue],[totInvValue],[transporterId],[transporterName],[transDocNo],[transMode],[transDistance],CONVERT(VARCHAR, transDocDate, 103) as transDocDate,[vehicleNo],[vehicleType]
                                        FROM [dbo].[acc_ewaybill_up] WHERE ID = " . $id; 
                            $tb_up_result = db::getInstance()->db_select($tb_up_sql);
                            $tb_up_data = $tb_up_result['result_set'][0];

                            // Fetch data from tb_mid
                            $tb_mid_sql = "SELECT * FROM acc_ewaybill_mid WHERE EntryID = " . $id; 
                            $tb_mid_result =db::getInstance()->db_select($tb_mid_sql);
                            // print_r($tb_up_result);
                            $tb_mid_data = [];
                            $i = 0;
                            while ($i < sizeof($tb_mid_result['result_set'])) {
                                $tb_mid_data[] = $tb_mid_result['result_set'][$i++];
                            }
                            // print_r($tb_mid_data);
                            if($APIModeSandbox){
                                $tb_up_data["fromGstin"] = '34AACCC1596Q002';
                                $tb_up_data["transporterId"] = '34AACCC1596Q002';
                                $tb_up_data["docNo"] = '010473-3';
                                $tb_up_data["fromStateCode"] = 34;
                                $tb_up_data["actFromStateCode"] = 34;
                                $tb_up_data["fromPincode"] = 605001;
                            }
                            $APIPost = [
                                "supplyType" => $tb_up_data["supplyType"],
                                "subSupplyType" => $tb_up_data["subSupplyType"],
                                "subSupplyDesc" => $tb_up_data["subSupplyDesc"],
                                "docType" => $tb_up_data["docType"],
                                "docNo" => $tb_up_data["docNo"],
                                "docDate" => $tb_up_data["docDate"],
                                "fromGstin" => $tb_up_data["fromGstin"],
                                "fromTrdName" => $tb_up_data["fromTrdName"],
                                "fromAddr1" => $tb_up_data["fromAddr1"],
                                "fromAddr2" => $tb_up_data["fromAddr2"],
                                "fromPlace" => $tb_up_data["fromPlace"],
                                "fromPincode" => $tb_up_data["fromPincode"],
                                "actFromStateCode" => $tb_up_data["actFromStateCode"],
                                "fromStateCode" => $tb_up_data["fromStateCode"],
                                "toGstin" => $tb_up_data["toGstin"],
                                "toTrdName" => $tb_up_data["toTrdName"],
                                "toAddr1" => $tb_up_data["toAddr1"],
                                "toAddr2" => $tb_up_data["toAddr2"],
                                "toPlace" => $tb_up_data["toPlace"],
                                "toPincode" => $tb_up_data["toPincode"],
                                "actToStateCode" => $tb_up_data["actToStateCode"],
                                "toStateCode" => $tb_up_data["toStateCode"],
                                "transactionType" => $tb_up_data["transactionType"],
                                "otherValue" => $tb_up_data["otherValue"],
                                "totalValue" => $tb_up_data["totalValue"],
                                "cgstValue" => $tb_up_data["cgstValue"],
                                "sgstValue" => $tb_up_data["sgstValue"],
                                "igstValue" => $tb_up_data["igstValue"],
                                "cessValue" => $tb_up_data["cessValue"],
                                "cessNonAdvolValue" => $tb_up_data["cessNonAdvolValue"],
                                "totInvValue" => $tb_up_data["totInvValue"],
                                "transporterId" => $tb_up_data["transporterId"],
                                "transporterName" => $tb_up_data["transporterName"],
                                "transDocNo" => $tb_up_data["transDocNo"],
                                "transMode" => $tb_up_data["transMode"],
                                "transDistance" => $tb_up_data["transDistance"],
                                "transDocDate" => $tb_up_data["transDocDate"],
                                "vehicleNo" => $tb_up_data["vehicleNo"],
                                "vehicleType" => $tb_up_data["vehicleType"],
                                "itemList" => array_map(function ($item) {
                                    // Exclude items with null or missing values
                                    if (isset($item["itemList_productName"]) && isset($item["itemList_quantity"]) && $item["itemList_quantity"] !== null) {
                                        return [
                                            "productName" => $item["itemList_productName"],
                                            "productDesc" => $item["itemList_productDesc"] ?? '', // Default to empty string if key is missing
                                            "hsnCode" => $item["itemList_hsnCode"] ?? '', // Default to empty string
                                            "quantity" => $item["itemList_quantity"],
                                            "qtyUnit" => $item["itemList_qtyUnit"] ?? '', // Default to empty string
                                            "cgstRate" => $item["itemList_cgstRate"] ?? 0, // Default to 0 if key is missing
                                            "sgstRate" => $item["itemList_sgstRate"] ?? 0,
                                            "igstRate" => $item["itemList_igstRate"] ?? 0,
                                            "cessRate" => $item["itemList_cessRate"] ?? 0,
                                            "cessNonadvol" => $item["itemList_cessNonadvol"] ?? 0,
                                            "taxableAmount" => $item["itemList_taxableAmount"] ?? 0
                                        ];
                                    }
                                    return null; // Return null for invalid items
                                }, $tb_mid_data)
                            ];
                            
                            // Remove null entries from itemList
                            $APIPost['itemList'] = array_filter($APIPost['itemList']);
                            
                            $APIPost = json_encode($APIPost, JSON_PRETTY_PRINT);
                            // echo $APIPost;
                            //CALL API
                            $access_token = '1XPLm4qjAVTeoiUXs4Tw74XDP';
                            $aspid = '1773362725';
                            $password = 'Mf89%3DN32]mIZ}1bn'; 

                            $response = getGSTToken();
                            // print_r($response);
                            if(isset($response['Status'])){
                                if($response['Status'] == 1){
                                    $access_token = $response['Data']['AuthToken'];
                                    $token_expiry = $response['Data']['TokenExpiry'];
                                }
                            }                           
                            $APIUrl = 'http://gstsandbox.charteredinfo.com/ewaybillapi/dec/v1.03/ewayapi?action=GENEWAYBILL&'.$aspid.'&password='.$password.'&Gstin=34AACCC1596Q002&eInvPwd=abc34*&AuthToken='.$access_token.'&QrCodeSize=250&ParseIrnResp=0&User_name=TaxProEnvPON&fortally=1';
                            $APIPost1 = '{
                                "supplyType": "O",
                                "subSupplyType": "1",
                                "subSupplyDesc": "",
                                "docType": "INV",
                                "docNo": "EWB1-001",
                                "docDate": "11/11/2024",
                                "fromGstin": "34AACCC1596Q002",
                                "fromTrdName": "welton",
                                "fromAddr1": "2ND CROSS NO 59  19  A",
                                "fromAddr2": "GROUND FLOOR OSBORNE ROAD",
                                "fromPlace": "FRAZER TOWN",
                                "fromPincode": 605001,
                                "actFromStateCode": 34,
                                "fromStateCode": 34,
                                "toGstin": "29AACCC1596Q000",
                                "toTrdName": "sthuthya",
                                "toAddr1": "Shree Nilaya",
                                "toAddr2": "Dasarahosahalli",
                                "toPlace": "Beml Nagar",
                                "toPincode": 562160,
                                "actToStateCode": 29,
                                "toStateCode": 29,
                                "transactionType": 4,
                                "otherValue": "-100",
                                "totalValue": 56099,
                                "cgstValue": 0,
                                "sgstValue": 0,
                                "igstValue": 300.67,
                                "cessValue": 400.56,
                                "cessNonAdvolValue": 400,
                                "totInvValue": 68358,
                                "transporterId": "",
                                "transporterName": "",
                                "transDocNo": "",
                                "transMode": "1",
                                "transDistance": "362",
                                "transDocDate": "",
                                "vehicleNo": "PVC1234",
                                "vehicleType": "R",
                                "itemList": [
                                    {
                                        "productName": "BLAZER-1",
                                        "productDesc": "BLAZER-1",
                                        "hsnCode": 4421,
                                        "quantity": 25,
                                        "qtyUnit": "NOS",
                                        "cgstRate": 0,
                                        "sgstRate": 0,
                                        "igstRate": 3,
                                        "cessRate": 3,
                                        "cessNonadvol": 0,
                                        "taxableAmount": 5609
                                    }
                                ]
                            }';

                            $APIResponse1 = callAPICurl($APIUrl, $APIPost);
                            // print_r($APIResponse1);
                            //INSERT RESPONSE IN DB
                            $sql = "UPDATE acc_ewaybill_up SET APICalled = 1,APICalledAt= GETDATE(),APIResponse = '$APIResponse1',
                                    APIURL = '$APIUrl',APIPost = '$APIPost' WHERE ID = $id";
                            $res = db::getInstance()->db_update($sql);
                            // print_r($res);
                            if (!is_array($APIResponse1)) {
                                // $jsonString = stripslashes($APIResponse1); 
                                $APIResponse = json_decode($APIResponse1, true);
                            }else{
                                $APIResponse = $APIResponse1;
                            }
                            if($APIResponse['status_cd'] == 0 || $APIResponse['status_cd'] == "0"){
                                $error = 2;
                                $error_msg = $APIResponse['error_message'];
                            }else{
                                // echo "in 1st else";
                                if(is_array($APIResponse['ErrorDetails'])){
                                    $error = 3;
                                    $error_msg = $APIResponse['ErrorDetails'][0]['ErrorMessage'];
                                }else{
                                    // echo "in else";
                                    $output = $APIResponse;
                                    if($APIResponse['status_cd'] == 1 || $APIResponse['status_cd'] == "1" ){
                                        $tmp = '';
                                        if(isset($APIResponse['ewayBillNo'])) $tmp = ' API_Status = 1,';
                                        $sql = "UPDATE acc_ewaybill_up SET 
                                                Response_EwaybillNo = '".$APIResponse['ewayBillNo']."',
                                                Response_EwaybillDate ='".$APIResponse['ewayBillDate']."',
                                                ".$tmp."
                                                Response_ValidUpto ='".$APIResponse['validUpto']."'
                                                WHERE ID = " . $id;
                                        $res = db::getInstance()->db_update($sql);
                                        // print_r($res);
                                    }
                                }
                            }
                        }else{
                            //SHOW ERROR MSG FROM VALIDATION SP
                            $error = 4;
                            $error_msg = isset($result['result_set'][0][0]['Msg']) ? $result['result_set'][0][0]['Msg'] : 'Error in Validation';
                        }
                    }else{
                        $error = 5;
                        $error_msg = 'Error in Validation Output';
                    }
                }
            }
        }
    
        break;
    case 'eway_data':
        $sql = "select * from acc_ewaybill_up where  CompanyID=".$_SESSION['dbCompany']." AND DivisionID=".$_SESSION['dbDivision'] ."
        AND YearCode='".$_SESSION['dbYear']."' AND FormID=".$FormID." AND EntryID=".$EntryID . " AND APICalled=1 AND API_Status=1";
        $result = db::getInstance()->db_select($sql);
        if($result['num_rows'] == 0){
            $sql = "select * from acc_ewaybill_up where ID IN (select max(id) from acc_ewaybill_up  
                    where  CompanyID=".$_SESSION['dbCompany']." AND DivisionID=".$_SESSION['dbDivision'] ."
                    AND YearCode='".$_SESSION['dbYear']."' AND FormID=".$FormID." AND EntryID=".$EntryID . ")";
            $result = db::getInstance()->db_select($sql);
        }
        $output = $result;
        $sql = "select TOP 1 Transportername,Transporterid,Transmode,Transactiontype,Vehicleno,Vehicletype,Transdistance 
                    from acc_ewaybill_view where CompanyID=".$_SESSION['dbCompany']." AND DivisionID=".$_SESSION['dbDivision'] ."
                    AND YearCode='".$_SESSION['dbYear']."' AND id = " . $EntryID . " AND FormID = " . $FormID; 
        $result = db::getInstance()->db_select($sql);
        $output['TransportData'] = $result;
        break;
    
    case 'gstr1':
        $period = isset($_REQUEST['period']) ? $_REQUEST['period'] : 0;

        if ($period == 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Period is required. Please provide a valid period.'
            ]);
            exit();
        }
        
        // if($result['num_rows'] > 0){}
        $ASPID = '1773362725';
        $ASPPassword = 'Mf89%3DN32]mIZ}1bn';
        // Extract first 2 digits of dbYear (e.g., 2526 → 25)
        $yearShort = substr($_SESSION['dbYear'], 0, 2);
        // Add "20" in front to get full year
        $year = "20" . $yearShort;
        // Format month to 2 digits
        $month = str_pad($period, 2, '0', STR_PAD_LEFT);
        // Combine to get retPeriod
        $RetPeriod = $month . $year;
        $otp = $_POST['otp'];

        // Log data for B2B & CDNR requests
        $logData = [
            'case_type' => 'gstr1',
            'request_url' => '',
            'otp' => $otp,
            'access_token' => '',
            'b2b_url' => '',
            'cdnr_url' => '',
            'b2b_response' => '',
            'cdnr_response' => ''
        ];

        /*
        1. IF OTP rcvd : call authtoken, update token in db, SET GSTAuth = true & go to step 5
        2. Else: Check token expiry
        3. If token not valid: Call otp API and return
        4. If token valid: SET GSTAuth = true
        5. Call B2B Api & update in db
        6. Call CDNR Api & update in db
        7. Return
        */
        $GSTAuth = false;

        if(strlen($otp) > 3){
            // Step 2: Get New Token using OTP
            $sql = "SELECT Gspuserid, Gsppsw, gstno, Gst_Api_Token, Gst_Api_TokenExpiry, gstusername FROM mst_party_company WHERE Companyid = " . $_SESSION['dbCompany'];
            $GSPresult = db::getInstance()->db_select($sql);
        
            $GSTIN = $GSPresult['result_set'][0]['gstno'];
            $GSTUsername = $GSPresult['result_set'][0]['gstusername'];

            $params = [
                "action"   => "AUTHTOKEN",
                "aspid"    => "1773362725",
                "password" => "Mf89=N32]mIZ}1bn",
                "gstin"    => "$GSTIN",
                "username" => "$GSTUsername",
                "OTP"      => "$otp"
            ];

            $authData = getGstAuthToken($params);
            // print_r($authData);
            // echo $authData['status_cd'];
            // echo getType($authData['status_cd']);
            if ($authData['status_cd'] == '1') {
                // echo "<br />Recvd Auth Token";
                $GSTToken = $authData['auth_token'];
                $expiry = date("Y-m-d H:i:s", strtotime('+6 hours'));

                // Save token
                $sql = "UPDATE mst_party_company SET Gst_Api_Token = '".$GSTToken."', Gst_Api_TokenExpiry ='".$expiry."' WHERE Companyid = " . $_SESSION['dbCompany'];
                db::getInstance()->db_update($sql);

                // Log the access token
                $logData['access_token'] = $GSTToken;
                $GSTAuth = true;
            } else {
                echo "Invalid OTP or GSTN error: " . ($authData['error']['message'] ?? 'Unknown');
                exit;
            }    
        } else{
            // step 2: check token expiry
            $sql = "SELECT Gst_Api_Token,gstno,gstusername FROM mst_party_company WHERE Gst_Api_TokenExpiry BETWEEN GETDATE() AND DATEADD(HOUR, 6, GETDATE())  AND Companyid = " . $_SESSION['dbCompany'];
            $Tresult = db::getInstance()->db_select($sql);
            // print_r($Tresult);
            $GSTToken = $Tresult['result_set'][0]['Gst_Api_Token'] ?? null;
            
            if($Tresult['num_rows'] > 0 && $GSTToken != null){
                $GSTIN = $Tresult['result_set'][0]['gstno'];
                $GSTUsername = $Tresult['result_set'][0]['gstusername'];
                $GSTAuth = true;
            }else{

                $sql = "SELECT Gspuserid, Gsppsw, gstno, Gst_Api_Token, Gst_Api_TokenExpiry, gstusername FROM mst_party_company WHERE Companyid = " . $_SESSION['dbCompany'];
                $GSPresult = db::getInstance()->db_select($sql);
            
                $GSTIN = $GSPresult['result_set'][0]['gstno'];
                $GSTUsername = $GSPresult['result_set'][0]['gstusername'];

                // Call otp API and return
                $OTPRequestUrl = "https://gstapi.charteredinfo.com/taxpayerapi/dec/v1.0/authenticate?action=OTPREQUEST&aspid={$ASPID}&password={$ASPPassword}&gstin={$GSTIN}&username={$GSTUsername}";
                $response = file_get_contents($OTPRequestUrl);
                $responseData = json_decode($response, true);
                $isAuth = false;
                if ($responseData['status_cd'] == '1') {
                    // OTP request successful, now prompt user for OTP
                    echo "OTP_REQUIRED";
                    exit;
                } else {
                    // If OTP request fails, handle the error
                    echo "Failed to request OTP. Error: " . $responseData['error']['message'];
                    exit;
                }
            }
        }
     
        if($GSTAuth){

            
            $checkPortalTableExist = "SELECT * FROM information_schema.columns WHERE table_name='acc_Einvoice_portal'";
            $portalResult = db::getInstance()->db_select($checkPortalTableExist);

            if ($portalResult['num_rows'] == 0) {
                $query = "CREATE TABLE acc_Einvoice_portal(
                        [id] [int] IDENTITY(1,1) PRIMARY KEY NOT NULL,
                        [party_id] [int] NULL,
                        [inum] [varchar](50) NULL,
                        [irn] [varchar](500) NULL,
                        [val] [decimal](18, 2) NULL,
                        [inv_typ] [char](1) NULL,
                        [srctyp] [varchar](50) NULL,
                        [pos] [varchar](5) NULL,
                        [idt] [date] NULL,
                        [irngendate] [date] NULL,
                        [autodftdt] [date] NULL,
                        [rchrg] [char](1) NULL,
                        [autodft] [varchar](50) NULL,
                        [chksum] [varchar](500) NULL,
                        [einvstatus] [varchar](10) NULL,
                        [isDelete] [int] NOT NULL DEFAULT 0,
                        [ctin] [varchar](500) NULL,
                        [trdname] [varchar](500) NULL,
                        [einvoiceType] [varchar](25) NULL,
                        [gstin] [varchar](500) NULL,
                        [retPeriod] [varchar](50) NULL,
                )";
                
                db::getInstance()->db_create_table($query);
            }

            $checkPortalItemTableExist = "SELECT * FROM information_schema.columns WHERE table_name='acc_Einvoice_portal_det'";
            $portalItemResult = db::getInstance()->db_select($checkPortalItemTableExist);

            if ($portalItemResult['num_rows'] == 0) {
                $query1 = "CREATE TABLE acc_Einvoice_portal_det(
                    [id] [int] IDENTITY(1,1) PRIMARY KEY NOT NULL,
                    [invoice_id] [int] NULL,
                    [num] [int] NULL,
                    [rt] [decimal](6, 2) NULL,
                    [txval] [decimal](18, 2) NULL,
                    [camt] [decimal](18, 2) NULL,
                    [samt] [decimal](18, 2) NULL,
                    [iamt] [decimal](18, 2) NULL,
                    [csamt] [decimal](18, 2) NULL,
                    [isDelete] [int] NOT NULL DEFAULT 0
                )";
                
                db::getInstance()->db_create_table($query1);
            }

            $checkRequestLogTableExist = "SELECT * FROM information_schema.columns WHERE table_name='acc_request_logs'";
            $requestLogResult = db::getInstance()->db_select($checkRequestLogTableExist);

            if ($requestLogResult['num_rows'] == 0) {
                $query2 = "CREATE TABLE acc_request_logs (
                    id INT IDENTITY PRIMARY KEY,
                    case_type VARCHAR(50) NULL,
                    request_url VARCHAR(MAX) NULL,
                    otp VARCHAR(100) NULL,
                    access_token VARCHAR(255) NULL,
                    b2b_url VARCHAR(MAX) NULL,
                    cdnr_url VARCHAR(MAX) NULL,
                    b2b_response VARCHAR(MAX) NULL,
                    cdnr_response VARCHAR(MAX) NULL,
                    created_at DATETIME2(0) NULL DEFAULT GETDATE()
                )";
                
                db::getInstance()->db_create_table($query2);
            }

            // Step 1: Get all party_ids for this GSTIN and retPeriod
            // $getPartyIDs = "SELECT id, gstin, retPeriod 
            //                 FROM acc_einvoice_portal_party 
            //                 WHERE gstin='$GSTIN' 
            //                 AND retPeriod = '$RetPeriod' AND isDelete=0";
            // $partyResult = db::getInstance()->db_select($getPartyIDs);

            $getPortalIDs = "SELECT id, gstin, retPeriod 
                            FROM acc_einvoice_portal 
                            WHERE gstin='$GSTIN' 
                            AND retPeriod = '$RetPeriod' AND isDelete=0";
            $portalResult = db::getInstance()->db_select($getPortalIDs);
            
            // if (!empty($partyResult['result_set'])) {
            //     foreach ($partyResult['result_set'] as $row) {
            //         $partyIdToDelete = $row['id'];

            //         // Step 2: Get invoice_ids for this party
            //         $getInvoiceIDs = "SELECT id FROM acc_Einvoice_portal WHERE party_id = $partyIdToDelete";
            //         $invoiceResult = db::getInstance()->db_select($getInvoiceIDs);

            //         if (!empty($invoiceResult['result_set'])) {
            //             foreach ($invoiceResult['result_set'] as $invRow) {
            //                 $invoiceIdToDelete = $invRow['id'];

            //                 // Step 3: Soft delete invoice item details
            //                 $delItems = "UPDATE acc_Einvoice_portal_det SET isDelete = 1 WHERE invoice_id = $invoiceIdToDelete";
            //                 db::getInstance()->db_update($delItems);
            //             }

            //             // Step 4: Soft delete invoices
            //             $delInvoices = "UPDATE acc_Einvoice_portal SET isDelete = 1 WHERE party_id = $partyIdToDelete";
            //             db::getInstance()->db_update($delInvoices);
            //         }

            //         // Step 5: Soft delete party record
            //         $delParty = "UPDATE acc_einvoice_portal_party SET isDelete = 1 WHERE id = $partyIdToDelete";
            //         db::getInstance()->db_update($delParty);
            //     }
            // }

            // if (!empty($portalResult['result_set'])) {
            //     foreach ($portalResult['result_set'] as $row) {
            //         $portalIdToDelete = $row['id'];

            //         $getItemIDs = "SELECT id FROM acc_Einvoice_portal_det WHERE invoice_id = $portalIdToDelete";
            //         $ItemResult = db::getInstance()->db_select($getItemIDs);

            //         if (!empty($ItemResult['result_set'])) {
            //             foreach ($ItemResult['result_set'] as $itemRow) {
            //                 $itemIdToDelete = $itemRow['id'];

            //                 // Step 3: Soft delete invoice item details
            //                $delItems = "UPDATE acc_Einvoice_portal_det SET isDelete = 1 WHERE invoice_id = $portalIdToDelete";
            //                 db::getInstance()->db_update($delItems);
            //             }

            //         }

            //         $delInvoices = "UPDATE acc_Einvoice_portal SET isDelete = 1 WHERE id = $portalIdToDelete";
            //         db::getInstance()->db_update($delInvoices);

            //     }
            // }

            if (!empty($portalResult['result_set'])) {
                foreach ($portalResult['result_set'] as $row) {
                    $portalIdToDelete = $row['id'];

                    // Soft delete all items related to the current portal in a single query
                    $delItems = "UPDATE acc_Einvoice_portal_det SET isDelete = 1 WHERE invoice_id = $portalIdToDelete";
                    db::getInstance()->db_update($delItems);

                    // Soft delete the invoice
                    $delInvoices = "UPDATE acc_Einvoice_portal SET isDelete = 1 WHERE id = $portalIdToDelete";
                    db::getInstance()->db_update($delInvoices);
                }
            }


            //  step 5: GET B2B einvoice json
            $b2beinvoiceurl = "https://gstapi.charteredinfo.com/taxpayerapi/dec/v1.1/returns/einvoice?action=EINV&aspid=".$ASPID."&password=".$ASPPassword."&gstin=".$GSTIN."&username=".$GSTUsername."&authtoken=".$GSTToken."&ret_period=".$RetPeriod."&sec=B2B";
            // echo $b2beinvoiceurl;
            $logData['b2b_url'] = $b2beinvoiceurl;
            $b2bResponse = file_get_contents($b2beinvoiceurl);
            $b2bData = json_decode($b2bResponse, true);
            $logData['b2b_response'] = json_encode($b2bData);
            $b2bGstin = $b2bData['gstin'];
            

            // print_r($b2bData);
            foreach ($b2bData['b2b'] as $party) {
                $ctin = $party['ctin'];
                $trdname = $party['trdname'];

                // $set = ['ctin', 'trdname','einvoiceType','gstin','retPeriod'];
                // $val = [$ctin, $trdname,'B2B',$b2bGstin,$RetPeriod];
                // // print_r($set);
                // // $saveParty = "INSERT INTO acc_einvoice_portal_party (ctin, trdname) VALUES ('$ctin', '$trdname')";
                // $partyResult = db::getInstance()->db_insert("acc_einvoice_portal_party",$set,$val);
                // $partyLastId = $partyResult['last_id'] ;
                // $set = [];
                // $val = [];

                foreach ($party['inv'] as $inv) {
                    $set = ['ctin', 'trdname','einvoiceType','gstin','retPeriod', 'inum', 'irn', 'val', 'inv_typ', 'srctyp', 'pos','idt','irngendate', 'autodftdt', 'rchrg', 'autodft', 'chksum', 'einvstatus'];
                    $val = [$ctin, $trdname,'B2B',$b2bGstin,$RetPeriod, $inv['inum'], $inv['irn'], $inv['val'], $inv['inv_typ'], $inv['srctyp'], $inv['pos'], safeDate($inv['dt']),safeDate($inv['irngendate']), safeDate($inv['autodftdt']), $inv['rchrg'], $inv['autodft'], $inv['chksum'], $inv['einvstatus']];
                    // $saveParty = "INSERT INTO acc_einvoice_portal_party (ctin, trdname) VALUES ('$ctin', '$trdname')";
                    $einvoiceResult = db::getInstance()->db_insert("acc_Einvoice_portal",$set,$val);
                    $invoice_id = $einvoiceResult['last_id'];
                    $set = [];
                    $val = [];

                    foreach ($inv['itms'] as $item) {
                        $det = $item['itm_det'];
                        $set = ['invoice_id', 'num', 'rt', 'txval', 'camt', 'samt', 'iamt', 'csamt'];
                        $val = [$invoice_id,$item['num'],$det['rt'],$det['txval'],$det['camt'],$det['samt'],$det['iamt'],$det['csamt']];
                        $einvoiceResult = db::getInstance()->db_insert("acc_Einvoice_portal_det",$set,$val);
                        $set = [];
                        $val = [];
                    }
                }

            }

            //  step 6: GET CDNR einvoice json
            $cdnreinvoiceurl = "https://gstapi.charteredinfo.com/taxpayerapi/dec/v1.1/returns/einvoice?action=EINV&aspid=".$ASPID."&password=".$ASPPassword."&gstin=".$GSTIN."&username=".$GSTUsername."&authtoken=".$GSTToken."&ret_period=".$RetPeriod."&sec=CDNR";
            $logData['cdnr_url'] = $cdnreinvoiceurl;
            $cdnrResponse = file_get_contents($cdnreinvoiceurl);
    
            $cdnrData = json_decode($cdnrResponse, true);
            $logData['cdnr_response'] = json_encode($cdnrData);
            $cdnrGstin = $cdnrData['gstin'];
            // print_r($cdnrData);
            foreach ($cdnrData['cdnr'] as $party) {
                $ctin = $party['ctin'];
                $trdname = $party['trdname'];

                // $set = ['ctin', 'trdname','einvoiceType','gstin','retPeriod'];
                // $val = [$ctin, $trdname,'CDNR',$cdnrGstin,$RetPeriod];
                // // $saveParty = "INSERT INTO acc_einvoice_portal_party (ctin, trdname) VALUES ('$ctin', '$trdname')";
                // $partyResult = db::getInstance()->db_insert("acc_einvoice_portal_party",$set,$val);
                // $partyLastId = $partyResult['last_id'];
                // $set = [];
                // $val = [];
                
                foreach ($party['nt'] as $inv) {
                    $set = ['ctin', 'trdname','einvoiceType','gstin','retPeriod','inum', 'irn', 'val', 'inv_typ', 'srctyp', 'pos','idt','irngendate', 'autodftdt', 'rchrg', 'autodft', 'chksum', 'einvstatus'];
                    $val = [$ctin, $trdname,'CDNR',$cdnrGstin,$RetPeriod, $inv['inum'], $inv['irn'], $inv['val'], $inv['inv_typ'], $inv['srctyp'], $inv['pos'], safeDate($inv['dt']),safeDate($inv['irngendate']), safeDate($inv['autodftdt']), $inv['rchrg'], $inv['autodft'], $inv['chksum'], $inv['einvstatus']];
                    // $saveParty = "INSERT INTO acc_einvoice_portal_party (ctin, trdname) VALUES ('$ctin', '$trdname')";
                    $einvoiceResult = db::getInstance()->db_insert("acc_Einvoice_portal",$set,$val);
                    $invoice_id = $einvoiceResult['last_id'];
                    $set = [];
                    $val = [];

                    foreach ($inv['itms'] as $item) {
                        $det = $item['itm_det'];
                        $set = ['invoice_id', 'num', 'rt', 'txval', 'camt', 'samt', 'iamt', 'csamt'];
                        $val = [$invoice_id,$item['num'],$det['rt'],$det['txval'],$det['camt'],$det['samt'],$det['iamt'],$det['csamt']];
                        $einvoiceResult = db::getInstance()->db_insert("acc_Einvoice_portal_det",$set,$val);
                        $set = [];
                        $val = [];
                    }
                }

            }

            // Insert log data into the database
            $insertLogQuery = "INSERT INTO acc_request_logs (case_type, request_url, otp, access_token, b2b_url, cdnr_url, b2b_response, cdnr_response) 
                               VALUES ('gst', '$b2beinvoiceurl', '$otp', '$GSTToken', '$b2beinvoiceurl', '$cdnreinvoiceurl', '{$logData['b2b_response']}', '{$logData['cdnr_response']}')";
            db::getInstance()->db_insertQuery($insertLogQuery);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Successfully Completed',
            ]);
            exit();
            
        }

    case 'gstr2':
        $period = isset($_REQUEST['period']) ? $_REQUEST['period'] : 0;

        if ($period == 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Period is required. Please provide a valid period.'
            ]);
            exit();
        }
        
        // if($result['num_rows'] > 0){}
        $ASPID = '1773362725';
        $ASPPassword = 'Mf89%3DN32]mIZ}1bn';
        // Extract first 2 digits of dbYear (e.g., 2526 → 25)
        $yearShort = substr($_SESSION['dbYear'], 0, 2);
        // Add "20" in front to get full year
        $year = "20" . $yearShort;
        // Format month to 2 digits
        $month = str_pad($period, 2, '0', STR_PAD_LEFT);
        // Combine to get retPeriod
        $RetPeriod = $month . $year;
        $otp = $_POST['otp'];

       

        // Log data for B2B & CDNR requests
        $logData = [
            'case_type' => 'gstr2b',
            'request_url' => '',
            'otp' => $otp,
            'access_token' => '',
            'gstr2b_url' => '',
            'b2b_response' => '',
            'b2ba_response' => '',
            'cdnr_response' => ''
        ];

        /*
        1. IF OTP rcvd : call authtoken, update token in db, SET GSTAuth = true & go to step 5
        2. Else: Check token expiry
        3. If token not valid: Call otp API and return
        4. If token valid: SET GSTAuth = true
        5. Call B2B Api & update in db
        6. Call CDNR Api & update in db
        7. Return
        */
        $GSTAuth = false;

        if(strlen($otp) > 3){
            // Step 2: Get New Token using OTP
            $sql = "SELECT Gspuserid, Gsppsw, gstno, Gst_Api_Token, Gst_Api_TokenExpiry, gstusername FROM mst_party_company WHERE Companyid = " . $_SESSION['dbCompany'];
            $GSPresult = db::getInstance()->db_select($sql);
        
            $GSTIN = $GSPresult['result_set'][0]['gstno'];
            $GSTUsername = $GSPresult['result_set'][0]['gstusername'];

            $params = [
                "action"   => "AUTHTOKEN",
                "aspid"    => "1773362725",
                "password" => "Mf89=N32]mIZ}1bn",
                "gstin"    => "$GSTIN",
                "username" => "$GSTUsername",
                "OTP"      => "$otp"
            ];

            $authData = getGstAuthToken($params);
            // print_r($authData);
            // echo $authData['status_cd'];
            // echo getType($authData['status_cd']);
            if ($authData['status_cd'] == '1') {
                // echo "<br />Recvd Auth Token";
                $GSTToken = $authData['auth_token'];
                $expiry = date("Y-m-d H:i:s", strtotime('+6 hours'));

                // Save token
                $sql = "UPDATE mst_party_company SET Gst_Api_Token = '".$GSTToken."', Gst_Api_TokenExpiry ='".$expiry."' WHERE Companyid = " . $_SESSION['dbCompany'];
                db::getInstance()->db_update($sql);

                // Log the access token
                $logData['access_token'] = $GSTToken;
                $GSTAuth = true;
            } else {
                echo "Invalid OTP or GSTN error: " . ($authData['error']['message'] ?? 'Unknown');
                exit;
            }    
        } else{
            // step 2: check token expiry
            $sql = "SELECT Gst_Api_Token,gstno,gstusername FROM mst_party_company WHERE Gst_Api_TokenExpiry BETWEEN GETDATE() AND DATEADD(HOUR, 6, GETDATE())  AND Companyid = " . $_SESSION['dbCompany'];
            $Tresult = db::getInstance()->db_select($sql);
            // print_r($Tresult);
            $GSTToken = $Tresult['result_set'][0]['Gst_Api_Token'] ?? null;
            
            if($Tresult['num_rows'] > 0 && $GSTToken != null){
                $GSTIN = $Tresult['result_set'][0]['gstno'];
                $GSTUsername = $Tresult['result_set'][0]['gstusername'];
                $GSTAuth = true;
            }else{

                $sql = "SELECT Gspuserid, Gsppsw, gstno, Gst_Api_Token, Gst_Api_TokenExpiry, gstusername FROM mst_party_company WHERE Companyid = " . $_SESSION['dbCompany'];
                $GSPresult = db::getInstance()->db_select($sql);
            
                $GSTIN = $GSPresult['result_set'][0]['gstno'];
                $GSTUsername = $GSPresult['result_set'][0]['gstusername'];

                // Call otp API and return
                $OTPRequestUrl = "https://gstapi.charteredinfo.com/taxpayerapi/dec/v1.0/authenticate?action=OTPREQUEST&aspid={$ASPID}&password={$ASPPassword}&gstin={$GSTIN}&username={$GSTUsername}";
                $response = file_get_contents($OTPRequestUrl);
                $responseData = json_decode($response, true);
                $isAuth = false;
                if ($responseData['status_cd'] == '1') {
                    // OTP request successful, now prompt user for OTP
                    echo "OTP_REQUIRED";
                    exit;
                } else {
                    // If OTP request fails, handle the error
                    echo "Failed to request OTP. Error: " . $responseData['error']['message'];
                    exit;
                }
            }
        }
     
        if($GSTAuth){

            $checkB2BPartyTableExist = "SELECT * FROM information_schema.columns WHERE table_name='gstr2b_einvoice_portal'";
            $b2bPartyResult = db::getInstance()->db_select($checkB2BPartyTableExist);

            if ($b2bPartyResult['num_rows'] == 0) {
                $query = "CREATE TABLE gstr2b_einvoice_portal (
                    id INT IDENTITY PRIMARY KEY,
                    CompanyID INT NOT NULL,
                    einvoicetype VARCHAR(50) NOT NULL,
                    ctin VARCHAR(15) NOT NULL,
                    trdnm NVARCHAR(255) NOT NULL,
                    supfildt DATE NULL,
                    supprd VARCHAR(6) NULL,
                    retperiod varchar(50) NULL,
                    rtnprd varchar(50) NULL,
                    inum NVARCHAR(50) NULL,
                    typ CHAR(1) NULL,
                    dt DATE NULL,
                    val DECIMAL(18,2) NULL,
                    pos VARCHAR(5) NULL,
                    rev CHAR(1) NULL,
                    itcavl CHAR(1) NULL,
                    rsn NVARCHAR(255) NULL,
                    igst DECIMAL(18,2) NULL,
                    cgst DECIMAL(18,2) NULL,
                    sgst DECIMAL(18,2) NULL,
                    cess DECIMAL(18,2) NULL,
                    txval DECIMAL(18,2) NULL,
                    srctyp NVARCHAR(50) NULL,
                    irn NVARCHAR(100) NULL,
                    irngendate DATE NULL,
                    imsStatus CHAR(1) NULL,
                    oinum NVARCHAR(50) NULL,
                    oidt DATE NULL,
                    ntnum NVARCHAR(50) NULL,
                    suptyp NVARCHAR(25) NULL,
                    isDelete int  NOT NULL DEFAULT 0
                )";
                
                db::getInstance()->db_create_table($query);
            }else{
                $tmp = "IF NOT EXISTS ( 
                            SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'gstr2b_einvoice_portal' AND COLUMN_NAME = 'CompanyID'
                        )
                        BEGIN
                            ALTER TABLE gstr2b_einvoice_portal ADD CompanyID int;
                        END";
                db::getInstance()->db_select($tmp);
            }

            $checkRequestLogTableExist = "SELECT * FROM information_schema.columns WHERE table_name='gstr2b_request_logs'";
            $requestLogResult = db::getInstance()->db_select($checkRequestLogTableExist);

            if ($requestLogResult['num_rows'] == 0) {
                $query2 = "CREATE TABLE gstr2b_request_logs (
                    id INT IDENTITY PRIMARY KEY,
                    case_type VARCHAR(50) NULL,
                    request_url VARCHAR(MAX) NULL,
                    otp VARCHAR(100) NULL,
                    access_token VARCHAR(255) NULL,
                    gstr2b_url VARCHAR(MAX) NULL,
                    b2b_response VARCHAR(MAX) NULL,
                    b2ba_response VARCHAR(MAX) NULL,
                    cdnr_response VARCHAR(MAX) NULL,
                    created_at DATETIME2(0) NULL DEFAULT GETDATE()
                )";
                
                db::getInstance()->db_create_table($query2);
            }


            $getPortalIDs = "SELECT id, ctin, retperiod, rtnprd
                            FROM gstr2b_einvoice_portal 
                            WHERE retperiod = '$RetPeriod' AND rtnprd = '$RetPeriod' AND isDelete=0";
            $portalResult = db::getInstance()->db_select($getPortalIDs);
            
            if (!empty($portalResult['result_set'])) {
                foreach ($portalResult['result_set'] as $row) {
                    $portalIdToDelete = $row['id'];

                    // Soft delete all items related to the current portal in a single query
                    $delItems = "UPDATE gstr2b_einvoice_portal SET isDelete = 1 WHERE id = $portalIdToDelete";
                    db::getInstance()->db_update($delItems);
                }
            }


            //  step 5: GET Details of gstr2b json
            $getGstr2bGetDetailurl = "https://gstapi.charteredinfo.com/taxpayerapi/dec/v4.0/returns/gstr2b?action=GET2B&aspid=".$ASPID."&password=".$ASPPassword."&gstin=".$GSTIN."&username=".$GSTUsername."&authtoken=".$GSTToken."&ret_period=".$RetPeriod."&rtnprd=".$RetPeriod."&file_num=1";


            $logData['gstr2b_url'] = $getGstr2bGetDetailurl;
            $gstr2Response = file_get_contents($getGstr2bGetDetailurl);
            $gstr2Data = json_decode($gstr2Response, true);
            $logData['b2b_response'] = json_encode($gstr2Data['data']['docdata']['b2b']);
            $logData['b2ba_response'] = json_encode($gstr2Data['data']['docdata']['b2ba']);
            $logData['cdnnr_response'] = json_encode($gstr2Data['data']['docdata']['cdnr']);

            //insert b2b data
            foreach ($gstr2Data['data']['docdata']['b2b'] as $party) {
                $ctin = $party['ctin'];
                $trdnm = $party['trdnm'];
                $supfildt = $party['supfildt'];
                $supprd = $party['supprd'];

                foreach ($party['inv'] as $inv) {
                    $set = ['einvoicetype','ctin', 'trdnm','supfildt','supprd','retperiod','rtnprd','inum', 'typ', 'dt', 'val', 'rev', 'itcavl', 'rsn','igst','cgst','sgst','cess','txval','srctyp','irn','irngendate','imsStatus', 'CompanyID'];
                    $val = ['B2B',$ctin, $trdnm, safeDate($supfildt),$supprd,$RetPeriod,$RetPeriod,$inv['inum'],$inv['typ'],safeDate($inv['dt']),$inv['val'],$inv['rev'],$inv['itcavl'],$inv['rsn'],$inv['igst'],$inv['cgst'],$inv['sgst'],$inv['cess'],$inv['txval'],$inv['srctyp'],$inv['irn'],safeDate($inv['irngendate']),$inv['imsStatus'], $_SESSION['dbCompany']];
                    // $saveParty = "INSERT INTO acc_einvoice_portal_party (ctin, trdname) VALUES ('$ctin', '$trdname')";
                    $gstr2bResult = db::getInstance()->db_insert("gstr2b_einvoice_portal",$set,$val);
                    $set = [];
                    $val = [];

                }
            }
            
            //insert b2ba data
            foreach ($gstr2Data['data']['docdata']['b2ba'] as $party) {
                $ctin = $party['ctin'];
                $trdnm = $party['trdnm'];
                $supfildt = $party['supfildt'];
                $supprd = $party['supprd'];

                foreach ($party['inv'] as $inv) {
                    $set = ['einvoicetype','ctin', 'trdnm','supfildt','supprd','retperiod','rtnprd','oinum', 'oidt', 'inum', 'typ', 'dt', 'val', 'pos','rev','itcavl','rsn','igst','cgst','sgst','cess','txval','imsStatus', 'CompanyID'];
                    $val = ['B2BA',$ctin, $trdnm, safeDate($supfildt),$supprd,$RetPeriod,$RetPeriod,$inv['oinum'],safeDate($inv['oidt']),$inv['inum'],$inv['typ'],safeDate($inv['dt']),$inv['val'],$inv['pos'],$inv['rev'],$inv['itcavl'],$inv['rsn'],$inv['igst'],$inv['cgst'],$inv['sgst'],$inv['cess'],$inv['txval'],$inv['imsStatus'], $_SESSION['dbCompany']];
                    // $saveParty = "INSERT INTO acc_einvoice_portal_party (ctin, trdname) VALUES ('$ctin', '$trdname')";
                    $gstr2bResult = db::getInstance()->db_insert("gstr2b_einvoice_portal",$set,$val);
                    $set = [];
                    $val = [];

                }
            }

            // Insert cdnr data
            foreach ($gstr2Data['data']['docdata']['cdnr'] as $party) {
                $ctin = $party['ctin'];
                $trdnm = $party['trdnm'];
                $supfildt = $party['supfildt'];
                $supprd = $party['supprd'];

                foreach ($party['nt'] as $nt) {
                    $set = ['einvoicetype','ctin', 'trdnm','supfildt','supprd','retperiod','rtnprd','dt','ntnum','val','rsn','suptyp','typ','itcavl','pos','rev','igst','cgst','sgst','cess','txval','imsStatus','CompanyID'];
                    $val = ['CDNR',$ctin, $trdnm, safeDate($supfildt),$supprd,$RetPeriod,$RetPeriod,safeDate($nt['dt']),$nt['ntnum'],$nt['val'],$nt['rsn'],$nt['suptyp'],$nt['typ'],$nt['itcavl'],$nt['pos'],$nt['rev'],$nt['igst'],$nt['cgst'],$nt['sgst'],$nt['cess'],$nt['txval'],$nt['imsStatus'], $_SESSION['dbCompany']];
                    // $saveParty = "INSERT INTO acc_einvoice_portal_party (ctin, trdname) VALUES ('$ctin', '$trdname')";
                    $gstr2bResult = db::getInstance()->db_insert("gstr2b_einvoice_portal",$set,$val);
                    $set = [];
                    $val = [];

                }
            }

            // Insert log data into the database
            $insertLogQuery = "INSERT INTO gstr2b_request_logs (case_type, request_url, otp, access_token, gstr2b_url, b2b_response, b2ba_response, cdnr_response) VALUES ('gstr2b', '', '$otp', '$GSTToken', '{$logData['gstr2b_url']}', '{$logData['b2b_response']}', '{$logData['b2ba_response']}', '{$logData['cdnr_response']}')";
            db::getInstance()->db_insertQuery($insertLogQuery);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Successfully Completed',
            ]);
            exit();
            
        }
   
 

    default:
    
        
}
// if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
//     ob_start("ob_gzhandler");
// } else {
//     ob_start();
// }
// header('Content-Encoding: gzip');
// header('Content-Type: application/json');
// echo json_encode(array('error' => $error, 'error_msg' => $error_msg, 'output' => $output));
// ob_end_flush();
// exit;

// Enable gzip only if zlib compression is not already enabled
if (!ini_get('zlib.output_compression') && 
    isset($_SERVER['HTTP_ACCEPT_ENCODING']) && 
    strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {

    ob_start('ob_gzhandler');
} else {
    ob_start();
}

header('Content-Type: application/json');
echo json_encode([
    'error' => $error, 
    'error_msg' => $error_msg, 
    'output' => $output
]);

ob_end_flush();
exit;


function getGSTTokenProduction($Gspuserid, $Gsppsw, $gstno){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        // CURLOPT_URL => 'https://gstsandbox.charteredinfo.com/eivital/dec/v1.04/auth?aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&Gstin=34AACCC1596Q002&User_name=TaxProEnvPON&eInvPwd=abc34*',
        // https://einvapi.charteredinfo.com/v1.03/dec/auth?action=ACCESSTOKEN&aspid=<aspid>&password=<asppassword>&gstin=<gstin>&username=<username>&ewbpwd=<ewbpwd>
        CURLOPT_URL => 'https://einvapi.charteredinfo.com/eivital/dec/v1.04/auth?aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&Gstin='.$gstno.'&User_name='.$Gspuserid.'&eInvPwd='.$Gsppsw.'', 
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'aspid: 1773362725',
            'password: Mf89=N32]mIZ}1bn'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response, true);
    return $response;
}

function getGSTToken(){

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://gstsandbox.charteredinfo.com/eivital/dec/v1.04/auth?aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&Gstin=34AACCC1596Q002&User_name=TaxProEnvPON&eInvPwd=abc34*',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'aspid: 1773362725',
            'password: Mf89=N32]mIZ}1bn'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, true);

    return $response;
}

function callAPICurl($APIUrl, $APIPost, $method = 'POST'){

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $APIUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $APIPost,
        CURLOPT_HTTPHEADER => array(
            'aspid: 1773362725',
            'password: Mf89=N32]mIZ}1bn',
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;

}

function getGstAuthToken($params){
    $authTokenUrl = "https://gstapi.charteredinfo.com/taxpayerapi/dec/v1.0/authenticate?" . http_build_query($params);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $authTokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable only for dev/testing
    curl_setopt($ch, CURLOPT_FAILONERROR, false); // Get full response even if HTTP error
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: GSTClient/1.0',
        'Accept: application/json',
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // echo "<br /> Response Auth: ";
    // print_r($response);
    // echo "<br /> HTTPCode Auth: ";
    // print_r($httpcode);

    
    return $authData = json_decode($response, true);
    

    curl_close($ch);
}

?>
<?php
//fetch.php
require_once ('dbClass.php');
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
// include 'model.php';

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding

// date_default_timezone_set('Asia/Calcutta'); 
// $devLogs  = PHP_EOL."-------------------------".PHP_EOL."User: ".$_SESSION['email'].' - '.date("F j, Y, g:i a")." => Data: ".json_encode($_REQUEST).PHP_EOL. ( "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" );

$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : '0';
$DBFieldName = isset($_POST['DBFieldName']) ? $_POST['DBFieldName'] : '';
$DBFieldType = isset($_POST['DBFieldType']) ? $_POST['DBFieldType'] : '0';
$requestParams = isset($_POST['requestParams']) ? $_POST['requestParams'] : '';
$isGrid = isset($_POST['isGrid']) ? $_POST['isGrid'] : '0';
$formData = isset($_POST['formData']) ? $_POST['formData'] : '0';

$isFilter = 0;
if($isGrid == 1){
    $sql = "SELECT FieldOtherConditions,FieldType FROM kgridfields where GridId=$GridID AND DbFieldName='".$DBFieldName."'";
}else{
    if($DBFieldType==14){
        $sql = "SELECT FieldOtherConditions,FieldType FROM kmainfields where FormId=$FormID AND GridId='".$GridID."'";
    }else{

        $sql = "SELECT FieldOtherConditions,FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".$DBFieldName."'";
    }
}

$sqlresult = db::getInstanceMaster()->db_select($sql);
// $devLogs .= PHP_EOL . $query2;
// if($result['error'] == 1) $devLogs .= PHP_EOL . $result['error_statement'];

// print_r($sqlresult);
$FieldOtherConditions = $sqlresult['result_set'][0]['FieldOtherConditions'];


$str1 = 'response';
$responsePos = -1;
if (strpos($FieldOtherConditions, $str1) !== false){
    $responsePos = strpos($FieldOtherConditions,$str1);
}


$str2 = 'DB';
$DBPos = -1;
if (strpos($FieldOtherConditions, $str2) !== false){
    $DBPos = strpos($FieldOtherConditions,$str2);
}

$newArr = ['', ''];

if($DBPos != -1 && $responsePos != -1){
    $splitIndex = $DBPos > $responsePos ? $DBPos : $responsePos;
    $newArr[0] = substr($FieldOtherConditions,0,$splitIndex - 1);
    $newArr[1] = substr($FieldOtherConditions, $splitIndex);

    $str3 = 'DB';
    $DBPos1 = -1;
    if (strpos($newArr[1], $str3) !== false){
        $DBPos1 = strpos($newArr[1],$str3);
    }

    $str4 = 'params';
    $paramPos = -1;
    if (strpos($newArr[1], $str4) !== false){
        $paramPos = strpos($newArr[1],$str4);
    }

    $str5 = 'parameters';
    $parametersPos = -1;
    if (strpos($newArr[1], $str5) !== false){
        $parametersPos = strpos($newArr[1],$str5);
    }

    $str6 = 'PopulateSpName';
    $PopulateSpPos = -1;
    if (strpos($newArr[1], $str6) !== false){
        $PopulateSpPos = strpos($newArr[1],$str6);
    }

    $str7 = 'gridResponse';
    $gridResponsePos = -1;
    if (strpos($newArr[1], $str7) !== false){
        $gridResponsePos = strpos($newArr[1],$str7);
    }

    $str8 = 'PopulateField';
    $PopulateFieldPos = -1;
    if (strpos($newArr[1], $str8) !== false){
        $PopulateFieldPos = strpos($newArr[1],$str8);
    }

    $str9 = 'DataSpName';
    $DataSpNamePos = -1;
    if (strpos($newArr[1], $str9) !== false){
        $DataSpNamePos = strpos($newArr[1],$str9);
    }

    $str10 = 'PopulateGrid';
    $PopulateGridPos = -1;
    if (strpos($newArr[1], $str10) !== false){
        $PopulateGridPos = strpos($newArr[1],$str10);
    }

    $str11 = 'PopulateFieldInGrid';
    $PopulateGridFieldPos = -1;
    if (strpos($newArr[1], $str11) !== false){
        $PopulateGridFieldPos = strpos($newArr[1],$str11);
    }

    $str12 = 'PopulateDB';
    $PopulateDBPos = -1;
    if (strpos($newArr[1], $str12) !== false){
        $PopulateDBPos = strpos($newArr[1],$str12);
    }

    $str13 = 'OrderBy';
    $OrderByPos = -1;
    if (strpos($newArr[1], $str13) !== false){
        $OrderByPos = strpos($newArr[1],$str13);
    }

    $str14 = 'formResponse';
    $formResponsePos = -1;
    if (strpos($newArr[1], $str14) !== false){
        $formResponsePos = strpos($newArr[1],$str14);
    }

    $str15 = 'TotalColumnIndex';
    $TotalColumnIndexPos = -1;
    if (strpos($newArr[1], $str15) !== false){
        $TotalColumnIndexPos = strpos($newArr[1],$str15);
    }

    $str16 = 'DynamicGridInsertFirstRowEdit';
    $DynamicGridInsertFirstRowEditPos = -1;
    if (strpos($newArr[1], $str16) !== false){
        $DynamicGridInsertFirstRowEditPos = strpos($newArr[1],$str16);
    }

    $str17 = 'EditableFields';
    $EditableFieldsPos = -1;
    if (strpos($newArr[1], $str17) !== false){
        $EditableFieldsPos = strpos($newArr[1],$str17);
    }

    $str18 = 'AdjustableAmount';
    $AdjustableAmountPos = -1;
    if (strpos($newArr[1], $str18) !== false){
        $AdjustableAmountPos = strpos($newArr[1],$str18);
    }

    if($DBPos1 != -1){
        if($DataSpNamePos != -1){
            if($paramPos != -1){
                $newArr[2] = substr($newArr[1], 0, $DataSpNamePos);
                if($parametersPos != -1){
                    if($PopulateSpPos != -1){
                        if($PopulateDBPos != -1){
                            if($gridResponsePos != -1){
                                if($formResponsePos != -1){
                                    if($PopulateFieldPos != -1){
                                        if($PopulateGridFieldPos != -1){
                                            if($PopulateGridPos != -1){
                                                if($OrderByPos != -1){
                                                    if($TotalColumnIndexPos != -1){
                                                        if($DynamicGridInsertFirstRowEditPos != -1){
                                                            if($EditableFieldsPos != -1){
                                                                if($AdjustableAmountPos != -1){
                                                                    $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                                                    $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                                                    $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                                                    $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                                                    $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                                                    $newArr[6] = substr($newArr[1],$gridResponsePos, $formResponsePos-$gridResponsePos);
                                                                    $newArr[13] = substr($newArr[1],$formResponsePos,$PopulateFieldPos-$formResponsePos);
                                                                    $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridFieldPos-$PopulateFieldPos);
                                                                    $newArr[10] = substr($newArr[1],$PopulateGridFieldPos,$PopulateGridPos-$PopulateGridFieldPos);
                                                                    $newArr[9] = substr($newArr[1],$PopulateGridPos, $OrderByPos-$PopulateGridPos);
                                                                    $newArr[12] = substr($newArr[1],$OrderByPos,$TotalColumnIndexPos-$OrderByPos);
                                                                    $newArr[14] = substr($newArr[1],$TotalColumnIndexPos, $DynamicGridInsertFirstRowEditPos-$TotalColumnIndexPos);
                                                                    $newArr[15] = substr($newArr[1],$DynamicGridInsertFirstRowEditPos,$EditableFieldsPos-$DynamicGridInsertFirstRowEditPos);
                                                                    $newArr[16] = substr($newArr[1],$EditableFieldsPos,$AdjustableAmountPos-$EditableFieldsPos);
                                                                    $newArr[17] = substr($newArr[1],$AdjustableAmountPos);
                                                                }else{
                                                                    $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                                                    $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                                                    $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                                                    $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                                                    $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                                                    $newArr[6] = substr($newArr[1],$gridResponsePos, $formResponsePos-$gridResponsePos);
                                                                    $newArr[13] = substr($newArr[1],$formResponsePos,$PopulateFieldPos-$formResponsePos);
                                                                    $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridFieldPos-$PopulateFieldPos);
                                                                    $newArr[10] = substr($newArr[1],$PopulateGridFieldPos,$PopulateGridPos-$PopulateGridFieldPos);
                                                                    $newArr[9] = substr($newArr[1],$PopulateGridPos, $OrderByPos-$PopulateGridPos);
                                                                    $newArr[12] = substr($newArr[1],$OrderByPos,$TotalColumnIndexPos-$OrderByPos);
                                                                    $newArr[14] = substr($newArr[1],$TotalColumnIndexPos, $DynamicGridInsertFirstRowEditPos-$TotalColumnIndexPos);
                                                                    $newArr[15] = substr($newArr[1],$DynamicGridInsertFirstRowEditPos,$EditableFieldsPos-$DynamicGridInsertFirstRowEditPos);
                                                                    $newArr[16] = substr($newArr[1],$EditableFieldsPos);
                                                                    $newArr[17] = "";
                                                                }
                                                            }else{
                                                                $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                                                $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                                                $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                                                $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                                                $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                                                $newArr[6] = substr($newArr[1],$gridResponsePos, $formResponsePos-$gridResponsePos);
                                                                $newArr[13] = substr($newArr[1],$formResponsePos,$PopulateFieldPos-$formResponsePos);
                                                                $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridFieldPos-$PopulateFieldPos);
                                                                $newArr[10] = substr($newArr[1],$PopulateGridFieldPos,$PopulateGridPos-$PopulateGridFieldPos);
                                                                $newArr[9] = substr($newArr[1],$PopulateGridPos, $OrderByPos-$PopulateGridPos);
                                                                $newArr[12] = substr($newArr[1],$OrderByPos,$TotalColumnIndexPos-$OrderByPos);
                                                                $newArr[14] = substr($newArr[1],$TotalColumnIndexPos, $DynamicGridInsertFirstRowEditPos-$TotalColumnIndexPos);
                                                                $newArr[15] = substr($newArr[1],$DynamicGridInsertFirstRowEditPos);
                                                                $newArr[16] = "";
                                                            }
                                                        }else{
                                                            $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                                            $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                                            $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                                            $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                                            $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                                            $newArr[6] = substr($newArr[1],$gridResponsePos, $formResponsePos-$gridResponsePos);
                                                            $newArr[13] = substr($newArr[1],$formResponsePos,$PopulateFieldPos-$formResponsePos);
                                                            $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridFieldPos-$PopulateFieldPos);
                                                            $newArr[10] = substr($newArr[1],$PopulateGridFieldPos,$PopulateGridPos-$PopulateGridFieldPos);
                                                            $newArr[9] = substr($newArr[1],$PopulateGridPos, $OrderByPos-$PopulateGridPos);
                                                            $newArr[12] = substr($newArr[1],$OrderByPos,$TotalColumnIndexPos-$OrderByPos);
                                                            $newArr[14] = substr($newArr[1],$TotalColumnIndexPos);
                                                            $newArr[15] = "";

                                                        }
                                                    }else{
                                                        $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                                        $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                                        $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                                        $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                                        $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                                        $newArr[6] = substr($newArr[1],$gridResponsePos, $formResponsePos-$gridResponsePos);
                                                        $newArr[13] = substr($newArr[1],$formResponsePos,$PopulateFieldPos-$formResponsePos);
                                                        $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridFieldPos-$PopulateFieldPos);
                                                        $newArr[10] = substr($newArr[1],$PopulateGridFieldPos,$PopulateGridPos-$PopulateGridFieldPos);
                                                        $newArr[9] = substr($newArr[1],$PopulateGridPos, $OrderByPos-$PopulateGridPos);
                                                        $newArr[12] = substr($newArr[1],$OrderByPos);
                                                        $newArr[14] = "";
                                                    }
                                                }else{
                                                    $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                                    $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                                    $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                                    $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                                    $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                                    $newArr[6] = substr($newArr[1],$gridResponsePos, $PopulateFieldPos-$gridResponsePos);
                                                    $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridFieldPos-$PopulateFieldPos);
                                                    $newArr[10] = substr($newArr[1],$PopulateGridFieldPos,$PopulateGridPos-$PopulateGridFieldPos);
                                                    $newArr[9] = substr($newArr[1],$PopulateGridPos);
                                                    $newArr[12] = "";
                                                }
                                            }else{
                                                $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                                $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                                $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                                $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                                $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                                $newArr[6] = substr($newArr[1],$gridResponsePos, $PopulateFieldPos-$gridResponsePos);
                                                $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridFieldPos-$PopulateFieldPos);
                                                $newArr[10] = substr($newArr[1],$PopulateGridFieldPos);
                                                $newArr[9] = "";
                                                $newArr[12] = "";
                                            }
                                        }
                                        else{
                                            $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                            $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                            $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                            $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                            $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                            $newArr[6] = substr($newArr[1],$gridResponsePos, $PopulateFieldPos-$gridResponsePos);
                                            $newArr[7] = substr($newArr[1],$PopulateFieldPos);
                                            $newArr[10] = "";
                                            $newArr[9] = "";
                                            $newArr[12] = "";
                                        }        
                                    }else{
                                        $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                        $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                        $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                        $newArr[5] = substr($newArr[1],$PopulateSpPos,$PopulateDBPos-$PopulateSpPos);
                                        $newArr[11] = substr($newArr[1],$PopulateDBPos,$gridResponsePos-$PopulateDBPos);
                                        $newArr[6] = substr($newArr[1],$gridResponsePos);
                                        $newArr[7] = "";
                                        $newArr[10] = "";
                                        $newArr[9] = "";
                                        $newArr[12] = "";
                                    }
                                }else{
                                    $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                    $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                    $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                    $newArr[5] = substr($newArr[1],$PopulateSpPos);
                                    $newArr[11] = "";
                                    $newArr[6] = "";
                                    $newArr[13] = "";
                                    $newArr[7] = "";
                                    $newArr[10] = "";
                                    $newArr[9] = "";
                                    $newArr[12] = "";
                                }
    
                            }else{
                                $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                                $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                                $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                                $newArr[5] = substr($newArr[1],$PopulateSpPos);
                                $newArr[11] = "";
                                $newArr[6] = "";
                                $newArr[13] = "";
                                $newArr[7] = "";
                                $newArr[10] = "";
                                $newArr[9] = "";
                                $newArr[12] = "";
                            }
                        }else{
                            $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                            $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                            $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                            $newArr[5] = substr($newArr[1],$PopulateSpPos, $PopulateDBPos-$PopulateSpPos);
                            $newArr[11] = substr($newArr[1],$PopulateDBPos);
                            $newArr[6] = "";
                        }
                    }else{
                        $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                        $newArr[3] = substr($newArr[1], $paramPos, $parametersPos-$paramPos);
                        $newArr[4] = substr($newArr[1],$parametersPos);
                        $newArr[5] = "";
                        
                    }
                }else{
                    if($PopulateSpPos != -1){
                        $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                        $newArr[3] = substr($newArr[1], $paramPos, $PopulateSpPos-$paramPos);
                        $newArr[4] = "";
                        $newArr[5] = substr($newArr[1],$PopulateSpPos);

                    }else{
                        $newArr[8] = substr($newArr[1], $DataSpNamePos, $paramPos-$DataSpNamePos);
                        $newArr[3] = substr($newArr[1], $paramPos);
                    }
                }
            }else{
                if($parametersPos != -1){
                    $newArr[2] = substr($newArr[1], 0, $parametersPos);
                    if($PopulateSpPos != -1){
                        $newArr[3] = "";
                        $newArr[4] = substr($newArr[1],$parametersPos,$PopulateSpPos-$parametersPos);
                        $newArr[5] = substr($newArr[1],$PopulateSpPos);

                    }else{
                        $newArr[3] = "";
                        $newArr[4] = substr($newArr[1],$parametersPos);
                        $newArr[5] = "";
                    }
                }else{
                    $newArr[2] = substr($newArr[1],$DBPos1);
                }

            }
        }
    }

    // echo "<br>".$newArr[0];
    // echo "<br><br>".$newArr[1];
    // echo "<br><br>".$newArr[2];
    // echo "<br><br>".$newArr[8];
    // echo "<br><br>".$newArr[3];
    // echo "<br><br>".$newArr[4];
    // echo "<br><br>".$newArr[5];
    // echo "<br><br>".$newArr[6];
    // echo "<br><br>".$newArr[7];
    // echo "<br><br>".$newArr[10];
    // echo "<br><br>".$newArr[9];
    
    
    
    $rParams = substr($newArr[0], strpos($newArr[0], '{')+1, strpos($newArr[0],'}') - 1);
    $responseParams = str_replace('}','',$rParams);
    
    $DBParams = substr($newArr[2] , strpos($newArr[2], '{')+1, strpos($newArr[2],'}') - 1);
    $db[0] = str_replace('}','',$DBParams);
    
    if($newArr[3] != ""){
        $pParams = substr($newArr[3] , strpos($newArr[3], '{')+1, strpos($newArr[3],'}') - 1);
        $paramParams = str_replace('}','',$pParams);
    }
    
    if($newArr[4] != ""){
        $paraParams = substr($newArr[4] , strpos($newArr[4], '{')+1, strpos($newArr[4],'}') - 1);
        $parametersParams = str_replace('}','',$paraParams);
    }
    
    if($newArr[5] != ""){
        $spParams = substr($newArr[5] , strpos($newArr[5], '{')+1, strpos($newArr[5],'}') - 1);
        $spParams = str_replace('}','',$spParams);
    }

    if($newArr[6] != ""){
        $gridParams = substr($newArr[6] , strpos($newArr[6], '{')+1, strpos($newArr[6],'}') - 1);
        $gridResponseParams = str_replace('}','',$gridParams);
    }

    if($newArr[7] != ""){
        $PFieldParams = substr($newArr[7] , strpos($newArr[7], '{')+1, strpos($newArr[7],'}') - 1);
        $OldPopulateFieldParams = str_replace('}','',$PFieldParams);
    }

    if($newArr[8] != ""){
        $DSpParams = substr($newArr[8] , strpos($newArr[8], '{')+1, strpos($newArr[8],'}') - 1);
        $DataSpParams = str_replace('}','',$DSpParams);
    }

    if($newArr[9] != ""){
        $PopulateGridParams = substr($newArr[9] , strpos($newArr[9], '{')+1, strpos($newArr[9],'}') - 1);
        $PopulateGrid = str_replace('}','',$PopulateGridParams);
    }

    if($newArr[10] != ""){
        $PGridFieldParams = substr($newArr[10] , strpos($newArr[10], '{')+1, strpos($newArr[10],'}') - 1);
        $OldPopulateGridFieldParams = str_replace('}','',$PGridFieldParams);
    }

    if($newArr[11] != ""){
        $PSpDbParams = substr($newArr[11] , strpos($newArr[11], '{')+1, strpos($newArr[11],'}') - 1);
        $PopulateSpDbParams = str_replace('}','',$PSpDbParams);
    }

    if($newArr[12] != ""){
        $ExtractOrderByParams = substr($newArr[12] , strpos($newArr[12], '{')+1, strpos($newArr[12],'}') - 1);
        $OrderByParams = str_replace('}','',$ExtractOrderByParams);
    }

    if($newArr[13] != ""){
        $ExtractFormResponse = substr($newArr[13] , strpos($newArr[13], '{')+1, strpos($newArr[13],'}') - 1);
        $formResponseParams = str_replace('}','',$ExtractFormResponse);
    }

    if($newArr[14] != ""){
        $TotalColumnResponse = substr($newArr[14] , strpos($newArr[14], '{')+1, strpos($newArr[4],'}') - 1);
        $TotalColumnIndexResponse = str_replace('}','',$TotalColumnResponse); 
    }

    if($newArr[15] != ""){
        $DynamicGridInsertFirstRowEditRes = substr($newArr[15] , strpos($newArr[15], '{')+1, strpos($newArr[15],'}') - 1);
        $DynamicGridInsertFirstRowEditResponse = str_replace('}','',$DynamicGridInsertFirstRowEditRes); 
    }

    if($newArr[16] != ""){
        $EditableFieldsRes = substr($newArr[16] , strpos($newArr[16], '{')+1, strpos($newArr[16],'}') - 1);
        $EditableFieldsResponse = str_replace('}','',$EditableFieldsRes); 
    }

    if($newArr[17] != ""){
        $AdjustableAmountRes = substr($newArr[17] , strpos($newArr[17], '{')+1, strpos($newArr[17],'}') - 1);
        $AdjustableAmountResponse = str_replace('}','',$AdjustableAmountRes);
    }
    
    
    $prevResponseParams = explode("|",$responseParams);
    $finalResponseParams = [];
    for($l=0; $l < count($prevResponseParams); $l++){

        if(preg_match("/\([^)]+\)/", $prevResponseParams[$l], $match)){
            preg_match("/\([^)]+\)/", $prevResponseParams[$l], $matches);
            $responseParamsArray = explode('(',$prevResponseParams[$l]);

            array_push($finalResponseParams,$responseParamsArray[0]);
            array_push($finalResponseParams,trim($matches[0], '()'));
        }
        else{
            array_push($finalResponseParams,$prevResponseParams[$l]);
        }
    }
    $stringResponse = implode(',',$finalResponseParams);

    $finalParamParams = explode("|",$parametersParams);
    
}




// $sql1 = "SHOW KEYS FROM $db[0] where key_name ='PRIMARY'";
// $sqlresult1 = db::getInstance()->db_select($sql1);
// $getPrimaryKey = $sqlresult1['result_set'][0]['Column_name'];

$queryForCount = "SELECT count($finalResponseParams[0]) AS cnt ";

$queryWithoutCount = "SELECT $stringResponse ";

$query .= " From $db[0] ";

$query .= " WHERE 1=1 ";

if(strlen($requestParams) > 5){
    // $Parameters = explode('|', $requestParams);
    // for($n=0; $n<count($Parameters); $n++){
    //     foreach($finalResponseParams as $key=>$value){
    //         $Fields .="COALESCE(".$value.",'-')";
    //         if($key != count($finalResponseParams)-1){
    //             $Fields .= ",'|',";
    //         }
    //     }
    //     $query .= 'AND concat('.$Fields.') LIKE \'%'.$Parameters[$n].'%\' ';
    //     $Fields = '';
    // }

    $query .= 'AND '.trim($requestParams);
    $isFilter = 1;
    
}

if(isset($_POST["is_variable"]) && isset($_POST["is_value"]))
{
    if($_POST["is_value"] != null){
        // echo $_POST["is_variable"];
        $variables = explode(',',$_POST["is_variable"]);
        
        $values = explode(',',$_POST["is_value"]);
        
        for($m=0; $m<count($variables); $m++){
            $flag = 0;
            foreach ($finalResponseParams as $sqlf) {
                // if (strpos($sqlf, $variables[$m]) !== false){
                //     echo $variables[$m];
                //     $query .= "AND ".$variables[$m]." LIKE '%".$values[$m]."%' "; 
                // }

                if (trim($sqlf) === trim($variables[$m])){
                    // echo $sqlf."===".$variables[$m];
                    if(strlen($DataSpParams) > 1){
                        $query .= " AND ".$variables[$m]." LIKE ''%".$values[$m]."%'' "; 
                    }else{
                        $query .= " AND ".$variables[$m]." LIKE '%".$values[$m]."%' "; 
                    }
                }
            }
        }
        $isFilter = 1;
    }
} 
// echo $query;
if(isset($_POST["search"]["value"]))
{
    if(strlen($_POST["search"]["value"]) > 3){
        foreach($finalResponseParams as $key=>$value){
            if(strlen($DataSpParams) > 1){
                $Fields .=trim($value);
            }else{
                $Fields .="COALESCE(".$value.",'-')";
            }
            if($key != count($finalResponseParams)-1){
                if(strlen($DataSpParams) > 1){
                    $Fields .= ",";
                }else{
                    $Fields .= ",'|',";
                }
            }
        }
        if(strlen($DataSpParams) > 1){
            $query .= 'AND concat('.' '.$Fields.' '.') LIKE \'\'%'.$_POST["search"]["value"].'%\'\' ';
        }else{
            $query .= 'AND concat('.$Fields.') LIKE \'%'.$_POST["search"]["value"].'%\' ';
        }
    }
}


// echo $query;
$number_filter = db::getInstance()->db_select($queryForCount . $query);
     
$number_filter_row = $number_filter['result_set'][0]['cnt'];

if(isset($_POST["order"]))
{   
    
    // echo strlen($OrderByParams);
    if(strlen($OrderByParams) > 1){
        if($_POST["order"][0]['column'] == 0){
            $query .= ' ORDER BY ' .$OrderByParams;
        }else{
            foreach($finalResponseParams as $key=>$value){
                if($key == $_POST["order"][0]['column']){
                    $query .= ' ORDER BY ' .$value.' '.$_POST['order']['0']['dir'];
                }
            }
        }
    }else{
        // foreach($finalResponseParams as $key=>$value){
        //     if($key == $_POST["order"][0]['column']){
        //         $query .= ' ORDER BY ' .$value.' '.$_POST['order']['0']['dir'];
        //     }
        // }
        $query .= ' ORDER BY "'.$finalResponseParams[0].'" DESC ';
    }
}
else
{
    $query .= ' ORDER BY "'.$finalResponseParams[0].'" DESC ';
}


$query1 = '';

if($_POST["length"] != 1)
{
    $query1 .= ' OFFSET ' . $_POST['start'] . ' ROWS FETCH NEXT ' . $_POST['length'] . ' ROWS ONLY';
}

if(strlen($db[0]) > 1){
    // print_r($data);
    $query2 = $queryWithoutCount . $query . $query1;
    $result = db::getInstance()->db_select($query2);
    // print_r($result);
    $data = array();

    $row = $result['result_set'];

    $DbFieldNames = explode(',',$stringResponse);

    for($i=0; $i<sizeof($row); $i++){
        $sub_array = array();
        
        foreach($DbFieldNames as $key=>$value){
            if(gettype($row[$i][trim($value)]) == 'object'){
                $temp = $row[$i][trim($value)];
                array_push($sub_array, $temp->format('d-m-Y'));
			
            }else{
                if(trim($value) == 'pending'){
                    array_push($sub_array,'<input type="text" readonly class="form-control " name="pending" id="pending" value="'.Encoding::fixUTF8($row[$i][trim('pending')],Encoding::ICONV_IGNORE).'"/>');
                }else if(trim($value) == 'adjamount' || trim($value) == 'adjamt'){
                    // Determine which value to use: adjamount or adjamt
                    if (isset($row[$i]['adjamount'])) {
                        $adjField = 'adjamount';
                        $adjValue = $row[$i]['adjamount'];
                    } elseif (isset($row[$i]['adjamt'])) {
                        $adjField = 'adjamt';
                        $adjValue = $row[$i]['adjamt'];
                    }

                    $adjValue = Encoding::fixUTF8($adjValue, Encoding::ICONV_IGNORE);

                    array_push($sub_array,'<div class="d-flex align-items-center"><input type="number" style="float:left;width:80%;" class="form-control"  onkeyup="getBillCalculation(this,\'keyup\',\''.$adjField.'\')" name="'.trim($value).'" id="'.trim($value).'" min="0" max="'.Encoding::fixUTF8($row[$i]['pending'],Encoding::ICONV_IGNORE).'" value="'.$adjValue.'"/><a  style="padding:3px;" href="javascript:void(0)" class="btn btn-success autofill" onclick="autoFill(this,\'' . $adjField . '\')"><span style="float:left;width:10%;" class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></a></div>');
                    
                }else if(trim($value) == 'balance' && trim($value) == 'adjamount' || trim($value) == 'adjamt'){
                    array_push($sub_array,'<input type="number" class="form-control" name="balance" id="balance" value="'.Encoding::fixUTF8($row[$i][trim('balance')],Encoding::ICONV_IGNORE).'"/>');
                }else{
                    array_push($sub_array,Encoding::fixUTF8($row[$i][trim($value)],Encoding::ICONV_IGNORE));
                }
            }
        }

        $data[] = $sub_array;
    }

    function get_all_data($tableName,$getPrimaryKey)
    {
     $query = "SELECT COUNT($getPrimaryKey) as cnt FROM $tableName";
     $result = db::getInstance()->db_select($query);

     return $result['result_set'][0]['cnt'];
    }



    $output = array(
     "draw"    => intval($_POST["draw"]),
     "recordsTotal"  =>  get_all_data($db[0],trim($finalResponseParams[0])),
     "recordsFiltered" => $number_filter_row,
     "data"    => $data
    );

}

// echo $DataSpParams
if(strlen($DataSpParams) > 1){

    // echo $DataSpParams;
    $queryArray = explode('WHERE',$query . $query1);

    $sql1 = "SELECT name FROM users WHERE id='".$_SESSION['user_id']."' ";
    $sql1result = db::getInstanceMaster()->db_select($sql1);	
    $username = $sql1result['result_set'][0]['name'];
    $queryArray[1] = trim($queryArray[1]);
    // echo $query2 = $queryWithoutCount . $query . $query1;

    $data = explode("&",$formData);
    $finalArray = array();
    $finalCnt = 0;
    $separator = "";
    for($i=0; $i<count($data); $i++){
        if (strpos($data[$i], "csrftoken") === false){
                    $finalArray[$finalCnt] .= $separator . $data[$i];
                    $separator = "|";
            }
    }

    // echo $queryArray[1];
    $data['name'] = $DataSpParams;
    $session .= 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND userid='.$_SESSION['user_id'].' ';
    $data['params'] = ['@whereCondition','@isFilter','@username','@session'];
    $sp['values'] = ["'$queryArray[1]'","$isFilter","'$username'","'$session'"];

    array_push($data['params'],'@form');
    array_push($sp['values'],"'".urldecode($finalArray[0])."'");

   
    $result = db::getInstance()->db_sp_select($data['name'], $data['params'], $sp['values']); 
    // print_r($result);
    // exit();
    $data = array();

    if($result['result_set']){

        for($k=0; $k<count($result['result_set'][0]); $k++){
            $dataArray = array();
            for($l=0; $l<count($result['result_set'][0][$k]); $l++){
                if (array_key_exists(trim($finalResponseParams[$l]),$result['result_set'][0][$k])){
                    if(trim($finalResponseParams[$l]) == 'pending'){
                        array_push($dataArray,'<input type="text" readonly class="form-control " name="pending" id="pending" value="'.Encoding::fixUTF8($result['result_set'][0][$k]['pending'],Encoding::ICONV_IGNORE).'"/>');
                    }else if(trim($finalResponseParams[$l]) == 'adjamount'){
                        array_push($dataArray,'<div class="d-flex align-items-center"><input type="number" style="float:left;width:80%;" class="form-control"  onkeyup="getBillCalculation(this,\'keyup\',\'adjamount\')" name="adjamount" id="adjamount" min="0" max="'.$result['result_set'][0][$k]['pending'].'" value="'.Encoding::fixUTF8($result['result_set'][0][$k]['adjamount'],Encoding::ICONV_IGNORE).'"/><a  style="padding:3px;" href="javascript:void(0)" class="btn btn-success autofill" onclick="autoFill(this,\'adjamount\')"><span style="float:left;width:10%;" class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></a></div>');
                    }else if(trim($finalResponseParams[$l]) == 'balance' && trim($finalResponseParams[$l]) == 'adjamount'){
                        array_push($dataArray,'<input type="number" class="form-control" name="balance" id="balance" value="'.Encoding::fixUTF8($result['result_set'][0][$k]['balance'],Encoding::ICONV_IGNORE).'"/>');
                    }else{
                        array_push($dataArray, Encoding::fixUTF8($result['result_set'][0][$k][trim($finalResponseParams[$l])],Encoding::ICONV_IGNORE));
                    }
                }
            }
            $data[] = $dataArray;
        }
    }

    $output = array(
        "draw"    => intval($_POST["draw"]),
        "recordsTotal"  =>  $result['result_set'][2][0]['recordstotal'],
        "recordsFiltered" => $result['result_set'][1][0]['recordsFiltered'],
        "data"    => $data
    );

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

?>
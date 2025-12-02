<?php

require_once ('dbClass.php');
$FormID = isset($_GET['FormID']) ? $_GET['FormID'] : '0';
include 'model.php';

$GridID = isset($_GET['GridID']) ? $_GET['GridID'] : '0';
$DBFieldName = isset($_GET['DBFieldName']) ? $_GET['DBFieldName'] : '';
$DBFieldType = isset($_GET['DBFieldType']) ? $_GET['DBFieldType'] : '0';
$isGrid = isset($_GET['isGrid']) ? $_GET['isGrid'] : '0';

if($isGrid == 1){
   $sql = "SELECT FieldOtherConditions,FieldType FROM kgridfields where GridId=$GridID AND DbFieldName='".$DBFieldName."'";
}else{
    if($DBFieldType==14){
       $sql = "SELECT FieldOtherConditions,FieldType FROM kmainfields where FormId=$FormID AND GridId='".$GridID."'"; // AND DbFieldName='".$DBFieldName."'";
    }else{
        $sql = "SELECT FieldOtherConditions,FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".$DBFieldName."'";
    }
}



$sqlresult = db::getInstanceMaster()->db_select($sql);

$FieldOtherConditions = trim($sqlresult['result_set'][0]['FieldOtherConditions']);
$FieldType = $sqlresult['result_set'][0]['FieldType'];


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

    $str19 = 'RequiredField';
    $RequiredFieldPos = -1;
    if (strpos($newArr[1], $str19) !== false){
        $RequiredFieldPos = strpos($newArr[1],$str19);
    }

    $str20 = "SelectAllCheckbox";
    $SselectAllCheckboxPos = -1;
    if (strpos($newArr[1], $str20) !== false){
        $SelectAllCheckboxPos = strpos($newArr[1],$str20);
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
                                                                    if($RequiredFieldPos != -1){
                                                                        if($SelectAllCheckboxPos != -1){
                                                                          
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
                                                                            $newArr[17] = substr($newArr[1],$AdjustableAmountPos,$RequiredFieldPos-$AdjustableAmountPos);
                                                                            $newArr[18] = substr($newArr[1],$RequiredFieldPos,$SelectAllCheckboxPos-$RequiredFieldPos);
                                                                            $newArr[19] = substr($newArr[1],$SelectAllCheckboxPos);
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
                                                                            $newArr[16] = substr($newArr[1],$EditableFieldsPos,$AdjustableAmountPos-$EditableFieldsPos);
                                                                            $newArr[17] = substr($newArr[1],$AdjustableAmountPos,$RequiredFieldPos-$AdjustableAmountPos);
                                                                            $newArr[18] = substr($newArr[1],$RequiredFieldPos);
                                                                            $newArr[19] = "";
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
                                                                        $newArr[15] = substr($newArr[1],$DynamicGridInsertFirstRowEditPos,$EditableFieldsPos-$DynamicGridInsertFirstRowEditPos);
                                                                        $newArr[16] = substr($newArr[1],$EditableFieldsPos,$AdjustableAmountPos-$EditableFieldsPos);
                                                                        $newArr[17] = substr($newArr[1],$AdjustableAmountPos);
                                                                        $newArr[18] = "";
                                                                        $newArr[19] = "";
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
                                                                    $newArr[15] = substr($newArr[1],$DynamicGridInsertFirstRowEditPos,$EditableFieldsPos-$DynamicGridInsertFirstRowEditPos);
                                                                    $newArr[16] = substr($newArr[1],$EditableFieldsPos);
                                                                    $newArr[17] = "";
                                                                    $newArr[18] = "";
                                                                    $newArr[19] = "";
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
                                        $newArr[6] = substr($newArr[1],$gridResponsePos, $formResponsePos-$gridResponsePos);
                                        $newArr[13] = "";
                                        $newArr[7] = substr($newArr[1],$PopulateFieldPos,$PopulateGridPos-$PopulateFieldPos);
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

   
    // if($_SESSION['ueser_id'] == 1020){
    //     echo "<br>".$newArr[0];
    //     echo "<br><br>".$newArr[1];
    //     echo "<br><br>".$newArr[2];
    //     echo "<br><br>".$newArr[8];
    //     echo "<br><br>".$newArr[3];
    //     echo "<br><br>".$newArr[4];
    //     echo "<br><br>".$newArr[5];
    //     echo "<br><br>".$newArr[11];
    //     echo "<br><br>".$newArr[6];
    //     echo "<br><br>".$newArr[13];
    //     echo "<br><br>".$newArr[7];
    //     echo "<br><br>".$newArr[10];
    //     echo "<br><br>".$newArr[9];
    //     echo "<br><br>".$newArr[12];
    // }
    


    

    $rParams = substr($newArr[0], strpos($newArr[0], '{')+1, strpos($newArr[0],'}') - 1);
    $responseParams = str_replace('}','',$rParams);

    $DBParams = substr($newArr[2] , strpos($newArr[2], '{')+1, strpos($newArr[2],'}') - 1);
    $db[0] = str_replace('}','',$DBParams);
    
    if(strlen($newArr[3]) > 0){
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

    if($newArr[18] != ""){
        $RequiredFieldRes = substr($newArr[18] , strpos($newArr[18], '{')+1, strpos($newArr[18],'}') - 1);
        $RequiredFieldResponse = str_replace('}','',$RequiredFieldRes);
    }

    if($newArr[19] != ""){
        $SelectAllCheckboxRes = substr($newArr[19] , strpos($newArr[19], '{')+1, strpos($newArr[19],'}') - 1);
        $SelectAllCheckboxResponse = str_replace('}','',$SelectAllCheckboxRes);
    }

    // echo $formResponseParams;
    if(strlen($formResponseParams) > 3){
 
        $formResponseParamsArray = explode("|",$formResponseParams);
        
        $formResponseFields = "";
        $formResponseParamsExplode = [];
        for($i=0; $i<sizeof($formResponseParamsArray); $i++){
            $formResponseParamsExplode = explode(":",$formResponseParamsArray[$i]);
            $sql1 = "SELECT FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".trim($formResponseParamsExplode[1])."'";
            // if($FormID == 4894){
            //     echo $sql1;
            // }
            $sql1result = db::getInstanceMaster()->db_select($sql1);
            if($sql1result['num_rows'] > 0){
                $formResponseFields .= trim($formResponseParamsExplode[0]).":".trim($formResponseParamsExplode[1]).":".trim($sql1result['result_set'][0]['FieldType']);
                if($i != sizeof($formResponseParamsArray)-1){
                    $formResponseFields .= " | ";
                }
            }
        }
    }
    // echo $formResponseFields;

    if(strlen($OldPopulateFieldParams) > 3){
        $PopulateFields = explode("|",$OldPopulateFieldParams);
        // print_r($PopulateFields);
        $PopulateFieldsArray = [];
        $PopulateFieldParams = "";
        for($i=0; $i<sizeof($PopulateFields); $i++){
            $PopulateFieldsArray = explode(":",$PopulateFields[$i]);
          
            $sql1 = "SELECT FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".trim($PopulateFieldsArray[0])."'";
            
            $sql1result = db::getInstanceMaster()->db_select($sql1);
            if($sql1result['num_rows'] > 0){
                $PopulateFieldParams .= trim($PopulateFieldsArray[0]).":".trim($PopulateFieldsArray[1]).":".trim($sql1result['result_set'][0]['FieldType']);

                if($PopulateFieldsArray[2]){
                    $PopulateFieldParams .= ":".trim($PopulateFieldsArray[2]);
                }

                if($i != sizeof($PopulateFields)-1){
                    $PopulateFieldParams .= " | ";
                }
            }
        }
    }

    if(strlen($OldPopulateGridFieldParams) > 3){
        $PopulateGridFields = explode("|",$OldPopulateGridFieldParams);
        $PopulateGridFieldsArray = [];
        $PopulateGridFieldParams = "";
        for($i=0; $i<sizeof($PopulateGridFields); $i++){
            $PopulateGridFieldsArray = explode(":",$PopulateGridFields[$i]);
            
            if($isGrid==1){
                $sql2 = "SELECT FieldType FROM kgridfields where GridId=$GridID AND DbFieldName='".trim($PopulateGridFieldsArray[0])."'";
            }else{
                $gridid = explode(":",$PopulateGrid);
                $sql2 = "SELECT FieldType FROM kgridfields where GridId=$gridid[1] AND DbFieldName='".trim($PopulateGridFieldsArray[0])."'";
            }
            $sql2result = db::getInstanceMaster()->db_select($sql2);
            if($sql2result['num_rows'] > 0){

                $PopulateGridFieldParams .= trim($PopulateGridFieldsArray[0]).":".trim($PopulateGridFieldsArray[1]).":".trim($sql2result['result_set'][0]['FieldType']);

                if($PopulateGridFieldsArray[2]){
                    $PopulateGridFieldParams .= ":".trim($PopulateGridFieldsArray[2]);
                }

                if($i != sizeof($PopulateGridFields)-1){
                    $PopulateGridFieldParams .= " | ";
                }
            }
        }
    }


    $prevResponseParams = explode("|",$responseParams);
    $finalResponseParams = [];
    $hiddenColumns = [];
    for($l=0; $l < count($prevResponseParams); $l++){

        if(preg_match("/\([^)]+\)/", $prevResponseParams[$l], $match)){
            preg_match("/\([^)]+\)/", $prevResponseParams[$l], $matches);
            $responseParamsArray = explode('(',$prevResponseParams[$l]);

            array_push($finalResponseParams,$responseParamsArray[0]);
            array_push($finalResponseParams,trim($matches[0], '()'));
            array_push($hiddenColumns,trim($matches[0], '()'));
        }
        else{
            array_push($finalResponseParams,$prevResponseParams[$l]);

        }
    }

    $hiddenColumnsString = '';
    if(sizeof($hiddenColumns) > 0){
        $hiddenColumns = array_map('ucfirst', $hiddenColumns);
        $hiddenColumnsString = implode(",",$hiddenColumns);
    }

    $finalParamParams = explode("|",$paramParams);

    // $PopulateGrid = '';
    if(strlen($gridResponseParams) > 3){
        
        $gridResponseParamsFinal = explode("|",$gridResponseParams);
        $gridid = explode(":",$PopulateGrid);
        for($i=0; $i<sizeof($gridResponseParamsFinal); $i++){
            $splitParams = explode(":",$gridResponseParamsFinal[$i]);
            $dbField = trim($splitParams[0]);
            $sql1 = "SELECT FieldType FROM kgridfields WHERE GridId=$gridid[1] AND DbFieldName='$dbField'";
            $sql1result = db::getInstanceMaster()->db_select($sql1);
            $finalGridResponseParams .= trim($splitParams[0]).":".trim($splitParams[1]).":".trim($sql1result['result_set'][0]['FieldType']);
            if($splitParams[2]){
                $finalGridResponseParams .= ":".trim($splitParams[2]);
            }
            if($i < count($gridResponseParamsFinal)-1){
                $finalGridResponseParams .= "|";
            }
        }

        
    }
    
    if(strlen($DynamicGridInsertFirstRowEditResponse) > 2){
        $DynamicGridInsertFirstRowEditParams  = trim(strtolower($DynamicGridInsertFirstRowEditResponse));
    }

}

// $columns = [];

// for($i=0; $i<count($finalResponseParams); $i++){
//     array_push($columns,(array("data" => trim($finalResponseParams[$i]), "name" => trim($finalResponseParams[$i]))));
// }

$columns = [];
$seen = [];

if (count($finalResponseParams) > 0) {
    for ($i = 0; $i < count($finalResponseParams); $i++) {
        $param = trim($finalResponseParams[$i]);

        if (!in_array($param, $seen)) {
            $columns[] = array("data" => $param, "name" => $param);
            $seen[] = $param;
        }
    }
}

$arr = array("columns" => $columns, "hiddenColumns" => $hiddenColumnsString, "params" => $finalParamParams, "requestParams" => $parametersParams, "gridResponseParams" => $finalGridResponseParams, "responseParams"=>$responseParams, "PopulateFields"=>$PopulateFieldParams, "PopulateGridFields"=>$PopulateGridFieldParams, "PopulateGrid"=>$PopulateGrid, "FormResponse"=>$formResponseFields, "TotalColumnIndexResponse"=>$TotalColumnIndexResponse, "DynamicGridInsertFirstRowEdit"=>$DynamicGridInsertFirstRowEditParams, "EditableFields"=>$EditableFieldsResponse, "AdjustableAmount"=> $AdjustableAmountResponse, "RequiredFields" => $RequiredFieldResponse, "SelectAllCheckbox" => $SelectAllCheckboxResponse);


echo json_encode($arr);

?>
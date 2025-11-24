<?php
require_once ('dbClass.php');
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
// include 'model.php';

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding


// Retrieve the 'start' and 'limit' parameters from the request (for pagination)
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$limit = isset($_POST['limit']) ? (int)$_POST['limit'] : 30;
$DBFieldName = isset($_POST['DBFieldName']) ? $_POST['DBFieldName'] : '';
$ColumnFilters = isset($_POST['ColumnFilters']) ? $_POST['ColumnFilters'] : '';
$GlobalSearch = isset($_POST['GlobalSearch']) ? $_POST['GlobalSearch'] : '';
$DBFieldType = isset($_POST['DBFieldType']) ? $_POST['DBFieldType'] : 0;
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : 0;
$requestParams = isset($_POST['requestParams']) ? $_POST['requestParams'] : '';
$isGrid = isset($_POST['isGrid']) ? $_POST['isGrid'] : 0;
$formData = isset($_POST['formData']) ? $_POST['formData'] : '0';
$isFilter = 0;

if($isGrid == 1){
    $sql = "SELECT FieldOtherConditions,FieldType FROM kgridfields where GridId=$GridID AND DbFieldName='".$DBFieldName."'";
}else{
    if($DBFieldType == 14){
        $sql = "SELECT FieldOtherConditions,FieldType FROM kmainfields where FormId=$FormID AND GridId='".$GridID."'";
    }else{
        $sql = "SELECT FieldOtherConditions,FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".$DBFieldName."'";
    }
}
// echo $sql;
// echo $sql = "SELECT FieldOtherConditions,FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".$DBFieldName."'";
$sqlresult = db::getInstanceMaster()->db_select($sql);
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
    // echo "<br><br>".$newArr[11];
    // echo "<br><br>".$newArr[12];
    
    
    
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

    if($newArr[18] != ""){
        $RequiredFieldRes = substr($newArr[18] , strpos($newArr[18], '{')+1, strpos($newArr[18],'}') - 1);
        $RequiredFieldResponse = str_replace('}','',$RequiredFieldRes);
    }
    
    if($newArr[19] != ""){
        $SelectAllCheckboxRes = substr($newArr[19] , strpos($newArr[19], '{')+1, strpos($newArr[19],'}') - 1);
        $SelectAllCheckboxResponse = str_replace('}','',$SelectAllCheckboxRes);
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

// $sqlcount = "SELECT count(".$finalResponseParams[0].") as noOfRecords FROM ".$db[0];
// $sqlcountresult = db::getInstance()->db_select($sqlcount);

$sql = "SELECT ".$stringResponse." FROM ".$db[0]." WHERE 1=1 ";
if (strlen($ColumnFilters) > 3) {
    $ColumnFiltersArray = explode("|", $ColumnFilters);
    for ($i = 0; $i < count($ColumnFiltersArray); $i++) {
        $ColumnFilter = explode(":", $ColumnFiltersArray[$i]);
        $columnName = $ColumnFilter[0];
        $searchValue = $ColumnFilter[1];

        // ✅ Remove 'populate_search_' if present
        if (strpos($columnName, 'populate_search_') === 0) {
            $columnName = substr($columnName, strlen('populate_search_'));
        }
        $searchValue = str_replace("'", "''", $searchValue);
        // ✅ Add to SQL with AND
        // $sql .= " AND $columnName LIKE '%" . addslashes($searchValue) . "%'";
        // $sql .= " AND $columnName LIKE '%" . $searchValue . "%'";

        // ✅ Detect if $searchValue looks like a date (dd-mm-yyyy or yyyy-mm-dd)
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $searchValue) || preg_match('/^\d{4}-\d{2}-\d{2}$/', $searchValue)) {
            // 🔹 Convert to SQL format (yyyy-mm-dd) if it’s dd-mm-yyyy
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $searchValue)) {
                $parts = explode("-", $searchValue);
                $searchValue = $parts[2] . "-" . $parts[1] . "-" . $parts[0];
            }

            // ✅ Add date comparison (ignore time part)
            $sql .= " AND CONVERT(date, $columnName) = '" . $searchValue . "'";
        } else {
            // ✅ Default text search
            $sql .= " AND $columnName LIKE '%" . $searchValue . "%'";
        }

    }
}
// if(strlen($ColumnFilters) > 3){
//     // $sql .= " WHERE ";
//     $ColumnFiltersArray = explode("|",$ColumnFilters);
//     for($i=0; $i<count($ColumnFiltersArray); $i++){
//         $ColumnFilter = explode(":",$ColumnFiltersArray[$i]);

//         // if($i != count($ColumnFiltersArray)-1){
//             $sql .= " AND ";
//         // }

//         $sql .= $ColumnFilter[0]." like '%".$ColumnFilter[1]."%'"; 
//     }
// }

if(strlen($GlobalSearch) > 1){
    // if(strlen($ColumnFilters) == 0){
    //     $sql .= ' WHERE';
    // }else{
        $sql .= ' AND';
    // }
    $sql .= ' concat('.' '.$stringResponse.' '.') LIKE \'%'.$GlobalSearch.'%\' ';
}

if(strlen($requestParams) > 3)
{
    // if(strlen($ColumnFilters) == 0 && strlen($ColumnFilters)  == 0){
    //     $sql .= ' WHERE';
    // }else{
        $sql .= ' AND';
    // }
    $sql .= ' '.$requestParams;
}

if(strlen($OrderByParams) > 1){
    $sql .= " ORDER BY ".$OrderByParams;
}else{
    $sql .= " ORDER BY ".$finalResponseParams[0];
}
// if(strlen($ColumnFilters) == 0 && strlen($GlobalSearch) == 0){
if($limit != 0 ){
    $sql .= " OFFSET ".$start." ROWS FETCH NEXT ".$limit." ROWS ONLY ";
}
// }

$dataArray = [];
$data = array();

if(strlen($db[0]) > 1){

    // $data = Encoding::fixUTF8($sqlresult['result_set'],Encoding::ICONV_IGNORE);
    $sqlresult = db::getInstance()->db_select($sql);

    // if($FormID == 4578)
    // {
    //     echo $sql;
    //     echo "<pre>";
    //     print_r($sqlresult);
    //     echo "</pre>";
    //     exit();
    // } 

    $row = $sqlresult['result_set'];

    $DbFieldNames = explode(',', $stringResponse);
    $data = array();

    for ($i = 0; $i < sizeof($row); $i++) {
        $sub_array = array();

        foreach ($DbFieldNames as $key => $value) {
            $fieldName = trim($value);  // Remove extra spaces

            if (gettype($row[$i][$fieldName]) == 'object') {
                $temp = $row[$i][$fieldName];
                $sub_array[$fieldName] = $temp->format('d-m-Y');  // Using field name as the key
            } else {
                if ($fieldName == 'pending') {
                    $sub_array[$fieldName] = '<input type="text" readonly class="form-control " name="pending" id="pending" style="text-align:right;" value="'.Encoding::fixUTF8($row[$i]['pending'], Encoding::ICONV_IGNORE).'"/>';
                } else if ($fieldName == 'adjamount') {
                    $sub_array[$fieldName] = '<div class="form-inline"><input type="number" style="width:70%;" class="form-control" onkeyup="getBillCalculation(this,\'keyup\',\'adjamount\')" name="'. $fieldName .'" id="'. $fieldName .'" min="0" max="'.Encoding::fixUTF8($row[$i]['pending'],Encoding::ICONV_IGNORE).'" value="'.Encoding::fixUTF8($row[$i]['adjamount'],Encoding::ICONV_IGNORE).'"/><a style="padding:3px;" href="javascript:void(0)" class="btn btn-success autofill" onclick="autoFill(this,\'adjamount\')"><span style="float:left;width:10%;" class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span></a></div>';
                } else if ($fieldName == 'balance' && trim($value) == 'adjamount') {
                    $sub_array[$fieldName] = '<input type="number" class="form-control" name="balance" id="balance" value="'.Encoding::fixUTF8($row[$i]['balance'], Encoding::ICONV_IGNORE).'"/>';
                } else {
                    $sub_array[$fieldName] = Encoding::fixUTF8($row[$i][$fieldName], Encoding::ICONV_IGNORE);
                }
            }
        }

        // Add the associative sub_array to $data
        $data[] = $sub_array;
    }

   

}

if(strlen($DataSpParams) > 1){

    // echo $sql;
    // echo $DataSpParams;
    $queryArray = explode('WHERE',$sql);
    
    
    $sql1 = "SELECT name FROM users WHERE id='".$_SESSION['user_id']."' ";
    $sql1result = db::getInstanceMaster()->db_select($sql1);	
    $username = $sql1result['result_set'][0]['name'];
    $queryArray[1] = trim($queryArray[1]);
    // print_r($queryArray);
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

    // print_r($finalArray);
    $data['name'] = $DataSpParams;
    $session .= 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' AND userid='.$_SESSION['user_id'].' ';
    $data['params'] = ['@whereCondition','@isFilter','@username','@session','@form'];
    $sp['values'] = ["'$queryArray[1]'","$isFilter","'$username'","'$session'","'".urldecode($finalArray[0])."'"];


    $result = db::getInstance()->db_sp_select($data['name'], $data['params'], $sp['values']);

    // if($_SESSION['user_id'] == 1020){
    //     print_r($result);
    // }

    $data = array();
    if($result['result_set']){

        // Loop through each row of results
        // foreach ($result['result_set'][0] as $k => $row) {
        //     $dataArray = array();

        //     // Loop through each parameter in the finalResponseParams array
        //     foreach ($finalResponseParams as $l => $param) {
        //         $param = trim($param);  // Remove extra spaces from the parameter name
        //         // echo $param;
                
        //         if (array_key_exists($param, $row)) {
        //             // Handle specific fields
        //             if ($param == 'pending') {
        //                 $dataArray[$param] = '<input type="text" readonly class="form-control" name="pending" id="pending" style="text-align:right;" value="'.Encoding::fixUTF8($row['pending'], Encoding::ICONV_IGNORE).'"/>';
        //             } elseif ($param == 'adjamount') {
        //                 $dataArray[$param] = '<div class="form-inline"><input type="number" style="width:70%;" class="form-control" onkeyup="getBillCalculation(this,\'keyup\',\'adjamount\')" name="adjamount" id="adjamount" min="0" max="'.$row['pending'].'" value="'.Encoding::fixUTF8($row['adjamount'], Encoding::ICONV_IGNORE).'"/><a style="padding:3px;" href="javascript:void(0)" class="btn btn-success autofill" onclick="autoFill(this,\'adjamount\')"><span  class="glyphicon glyphicon glyphicon-ok" aria-hidden="true" title="(Alt+K)"></span></a></div>';
        //             } elseif ($param == 'balance') {
        //                 $dataArray[$param] = '<input type="number" class="form-control" name="balance" id="balance" value="'.Encoding::fixUTF8($row['balance'], Encoding::ICONV_IGNORE).'"/>';
        //             } else {
        //                 if (gettype($row[$param]) == 'object') {
        //                     $temp = $row[$param];
        //                     $dataArray[$param] = $temp->format('d-m-Y');  // Using field name as the key
        //                 }else{
        //                     // For other fields, just store the value
        //                     $dataArray[$param] = Encoding::fixUTF8($row[$param], Encoding::ICONV_IGNORE);
        //                 }
        //             }
        //         }
        //     }
        //     // Add the row as an associative array to $data
        //     $data[] = $dataArray;
        // }

        // Loop through each row of results
        foreach ($result['result_set'][0] as $k => $row) {
            $dataArray = array();

            // Create a lowercase-key map of $row for case-insensitive matching
            $rowLower = array_change_key_case($row, CASE_LOWER);

            // Loop through each parameter in the finalResponseParams array
            foreach ($finalResponseParams as $l => $param) {
                $param = trim($param);  // Remove extra spaces from the parameter name
                $paramLower = strtolower($param);
                // echo $param;
                
                if (array_key_exists($paramLower, $rowLower)) {
                    $value = $rowLower[$paramLower];

                    // Handle specific fields
                    if ($paramLower == 'pending') {
                        $dataArray[$param] = '<input type="text" readonly class="form-control" name="pending" id="pending" style="text-align:right;" value="'.Encoding::fixUTF8($row['pending'], Encoding::ICONV_IGNORE).'"/>';
                    } elseif ($paramLower == 'adjamount') {
                        $dataArray[$param] = '<div class="form-inline"><input type="number" style="width:70%;" class="form-control" onkeyup="getBillCalculation(this,\'keyup\',\'adjamount\')" name="adjamount" id="adjamount" min="0" max="'.$rowLower['pending'].'" value="'.Encoding::fixUTF8($row['adjamount'], Encoding::ICONV_IGNORE).'"/><a style="padding:3px;" href="javascript:void(0)" class="btn btn-success autofill" onclick="autoFill(this,\'adjamount\')"><span  class="glyphicon glyphicon glyphicon-ok" aria-hidden="true" title="(Alt+K)"></span></a></div>';
                    } elseif ($paramLower == 'balance') {
                        $dataArray[$param] = '<input type="number" class="form-control" name="balance" id="balance" value="'.Encoding::fixUTF8($row['balance'], Encoding::ICONV_IGNORE).'"/>';
                    } else {
                        if (gettype($value) == 'object') {
                            // $temp = $row[$param];
                            $dataArray[$param] = $value->format('d-m-Y');  // Using field name as the key
                        }else{
                            // For other fields, just store the value
                            $dataArray[$param] = Encoding::fixUTF8($value, Encoding::ICONV_IGNORE);
                        }
                    }
                }
            }
            // Add the row as an associative array to $data
            $data[] = $dataArray;
        }

        
    }

}

$arr = array("data" => $data); //,"dataLength" => $sqlcountresult['result_set'][0]['noOfRecords']

if($result['result_set'][1]){
    // echo $result['result_set'][1][0]['netamt'];
    if(strlen($result['result_set'][1][0]['netamt']) > 2){
        $arr['netamt'] = $result['result_set'][1][0]['netamt'];
    }
}

// Return the paged data as a JSON response
echo json_encode($arr);

?>
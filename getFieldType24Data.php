<?php
require_once ('dbClass.php');
$FieldOtherCondition = isset($_POST['FieldOtherCondition']) ? $_POST['FieldOtherCondition'] : '';
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '';


$newArr = ['', ''];

if(strlen($FieldOtherCondition) > 5){
    
    $str1 = 'SpName';
    $spNamePos = -1;
    if (strpos($FieldOtherCondition, $str1) !== false){
        $spNamePos = strpos($FieldOtherCondition,$str1);
    }

    $str2 = 'FormParameters';
    $FormparametersPos = -1;
    if (strpos($FieldOtherCondition, $str2) !== false){
        $FormparametersPos = strpos($FieldOtherCondition,$str2);
    }

    $str3 = 'GridResponse';
    $GridResponsePos = -1;
    if (strpos($FieldOtherCondition, $str3) !== false){
        $GridResponsePos = strpos($FieldOtherCondition,$str3);
    }

    $str4 = 'PopulateGrid';
    $PopulateGridPos = -1;
    if (strpos($FieldOtherCondition, $str4) !== false){
        $PopulateGridPos = strpos($FieldOtherCondition,$str4);
    }

    $str5 = 'cursor';
    $CursorPos = -1;
    if (strpos($FieldOtherCondition, $str5) !== false){
        $CursorPos = strpos($FieldOtherCondition,$str5);
    }

    $str6 = 'PopulateField';
    $PopulateFieldPos = -1;
    if (strpos($FieldOtherCondition, $str6) !== false){
        $PopulateFieldPos = strpos($FieldOtherCondition,$str6);
    }
    $str7 = 'Type';
    $BtnTypePos = -1;
    if (strpos($FieldOtherCondition, $str7) !== false){
        $BtnTypePos = strpos($FieldOtherCondition,$str7);
    }
    

    if($spNamePos != -1){
        if($FormparametersPos != -1){
            if($GridResponsePos != -1){
                if($PopulateFieldPos != -1){
                    if($PopulateGridPos != -1){
                        if($CursorPos != -1){
                            $newArr[0] = substr($FieldOtherCondition, $spNamePos, $FormparametersPos-$spNamePos);
                            $newArr[1] = substr($FieldOtherCondition, $FormparametersPos, $GridResponsePos-$FormparametersPos);
                            $newArr[2] = substr($FieldOtherCondition, $GridResponsePos, $PopulateFieldPos-$GridResponsePos);
                            $newArr[5] = substr($FieldOtherCondition, $PopulateFieldPos, $PopulateGridPos-$PopulateFieldPos);
                            $newArr[3] = substr($FieldOtherCondition, $PopulateGridPos, $CursorPos-$PopulateGridPos);
                            $newArr[4] = substr($FieldOtherCondition, $CursorPos);
                            $newArr[6] = substr($FieldOtherCondition, $BtnTypePos);
                        }
                    }
                }
            }
        }
    }

    // echo "<br>". $newArr[0];
    // echo "<br>". $newArr[1];
    // echo "<br>". $newArr[2];
    // echo "<br>". $newArr[3];
    // echo "<br>". $newArr[4];
    // echo "<br>". $newArr[5];



    if(strlen($newArr[0]) > 0){
        $spName = substr($newArr[0] , strpos($newArr[0], '{')+1, strpos($newArr[0],'}') - 1);
        $spNameParams = str_replace('}','',$spName);
    }

    if(strlen($newArr[1]) > 0){
        $parameters = substr($newArr[1] , strpos($newArr[1], '{')+1, strpos($newArr[1],'}') - 1);
        $FormparametersParams = str_replace('}','',$parameters);
    }

    if(strlen($newArr[2]) > 0){
        $GridResponse = substr($newArr[2] , strpos($newArr[2], '{')+1, strpos($newArr[2],'}') - 1);
        $GridResponseParams = str_replace('}','',$GridResponse);
    }

    if(strlen($newArr[3]) > 0){
        $PopulateGrid = substr($newArr[3] , strpos($newArr[3], '{')+1, strpos($newArr[3],'}') - 1);
        $PopulateGridID = str_replace('}','',$PopulateGrid);
        $GridId = [];
        $GridId = explode(':',$PopulateGridID);
    }

    if(strlen($newArr[4]) > 0){
        $cursor = substr($newArr[4] , strpos($newArr[4], '{')+1, strpos($newArr[4],'}') - 1);
        $CursorPosition = str_replace('}','',$cursor);
    }

    if(strlen($newArr[5]) > 0){
        $PField = substr($newArr[5] , strpos($newArr[5], '{')+1, strpos($newArr[5],'}') - 1);
        $PopulateFieldParam = str_replace('}','',$PField);
    }

    if(strlen($newArr[6]) > 0){
        $BTField = substr($newArr[6] , strpos($newArr[6], '{')+1, strpos($newArr[6],'}') - strpos($newArr[6], '{')-1);
        $BtnTypeParam = str_replace('}','',$BTField);
    }

    
    if(strlen($FormparametersParams) > 3){
        $FormparametersParamsArray = explode("|",$FormparametersParams);
        $formResponseFields = "";

        for($i=0; $i<sizeof($FormparametersParamsArray); $i++){
            $sql1 = "SELECT FieldType FROM kmainfields where FormId=$FormID AND DbFieldName='".trim($FormparametersParamsArray[$i])."'";
            
            $sql1result = db::getInstanceMaster()->db_select($sql1);
            
            if($sql1result['num_rows'] > 0){
                $formResponseFields .= trim($FormparametersParamsArray[$i]).":".trim($sql1result['result_set'][0]['FieldType']);
                if($i != sizeof($FormparametersParamsArray)-1){
                    $formResponseFields .= " | ";
                }
            }
        }
    }

    if(strlen($GridResponseParams) > 3){
        $gridResponseParamsFinal = explode("|",$GridResponseParams);
        $gridid = explode(":",$PopulateGridID);
       
        for($i=0; $i<sizeof($gridResponseParamsFinal); $i++){
            $splitParams = explode(":",$gridResponseParamsFinal[$i]);
            $dbField = trim($splitParams[0]);
            $sql1 = "SELECT * FROM kgridfields WHERE GridId=$gridid[1] AND DbFieldName='$dbField'";
            $sql1result = db::getInstanceMaster()->db_select($sql1);
            $finalGridResponseParams .= trim($splitParams[0]).":".trim($splitParams[1]).":".trim($sql1result['result_set'][0]['FieldType']);
            if($splitParams[2]){
                $finalGridResponseParams .= ":".trim($splitParams[2]);
            }

            $finalGridResponseParams .= ":".trim($sql1result['result_set'][0]['Required']);
            
            if($i < count($gridResponseParamsFinal)-1){
                $finalGridResponseParams .= "|";
            }
        }
    }
    if(strlen($PopulateFieldParam) > 3){
        $PopulateFieldParamFinal = explode("|",$PopulateFieldParam);
        $PopulateFieldParamArray = [];
        
        for($i=0; $i<sizeof($PopulateFieldParamFinal); $i++){
            $sql2 = "SELECT FieldType FROM kmainfields WHERE FormId=$FormID AND DbFieldName='".trim($PopulateFieldParamFinal[$i])."'";
            $sql2result = db::getInstanceMaster()->db_select($sql2);
            $finalPopulateField .= trim($PopulateFieldParamFinal[$i]).":".trim($sql2result['result_set'][0]['FieldType']);
            
            if($i < count($PopulateFieldParamFinal)-1){
                $finalPopulateField .= "|";
            }
        }
        
    }
}

$arr = array("SpName" => trim($spNameParams), "FormParameters" => $formResponseFields, "GridResponse" => $finalGridResponseParams, "GridId" => $GridId[1], "CursorPosition" => $CursorPosition, "PopulateField" => $finalPopulateField, "Type" => $BtnTypeParam);
echo json_encode($arr);

?>
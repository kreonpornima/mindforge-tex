<?php 
require_once ('dbClass.php');
$fieldOtherCondition = isset($_POST['FieldOtherCondition']) ? $_POST['FieldOtherCondition'] : "";
$gridSerial = isset($_POST['gridSerial']) ? $_POST['gridSerial'] : "";
$searchText = isset($_POST['searchText']) ? $_POST['searchText'] : "";
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : 0;
$dbarray0 = isset($_POST['dbarray0']) ? $_POST['dbarray0'] : '';
$dbarray1 = isset($_POST['dbarray1']) ? $_POST['dbarray1'] : '';
$dbarray2 = isset($_POST['dbarray2']) ? $_POST['dbarray2'] : '';
$dbarray3 = isset($_POST['dbarray3']) ? $_POST['dbarray3'] : '';


// print_r($dbarray);

$str1 = 'parameters';
$parametersPos = -1;
if (strpos($fieldOtherCondition, $str1) !== false){
    $parametersPos = strpos($fieldOtherCondition,$str1);
}

$searchText1Array = explode('&',$searchText);
$searchParameters = '';
if($parametersPos != -1){
    $extractParameters = substr($fieldOtherCondition , strpos($fieldOtherCondition, '{')+1, strpos($fieldOtherCondition,'}') - 1);
    $extractedparameters = str_replace('}','',$extractParameters);

    $extractedparameters = preg_replace('~\s*([?])~',  ' ?', $extractedparameters);
    $extractedparameters = preg_replace('~\s*([#])~',  ' #', $extractedparameters);

    

    if(strlen($extractedparameters) > 1){
        $parameters = explode(" ",$extractedparameters);
    
        for($i=0; $i<sizeof($parameters); $i++){
            
            if(strpos(trim($parameters[$i]), '?') !== false || strpos(trim($parameters[$i]), '#') !== false){

                if(strlen($parameters[$i]) > 1){
                    if($GridID > 0){
                        if(strpos(trim($parameters[$i]), '?') !== false){

                            $qExtractedString = "kreon-grid-".$gridSerial ."".str_replace('?', '', trim($parameters[$i]));
                            
                        }else if(strpos(trim($parameters[$i]), '#') !== false){
                            $qExtractedString = str_replace('#', '', trim($parameters[$i]));
                            
                        }
                    }else{
                        $qExtractedString = str_replace('?', '', trim($parameters[$i]));
                    }

                    if(strlen($qExtractedString) > 0){
                        for($j=0; $j<sizeof($searchText1Array); $j++){
                            $splitSearchText1Array = explode("=",$searchText1Array[$j]);

                            $formSerializeFieldUrlDecode = urldecode($splitSearchText1Array[0]);

                            $formSerializeField = str_replace(array( '[', ']' ), '', $formSerializeFieldUrlDecode);
                           
                            if(trim($formSerializeField) == trim($qExtractedString)){
                       
                                $searchParameters .= $splitSearchText1Array[1] !="" ? $splitSearchText1Array[1] : '';
                                $searchParameters .= " ";
                            }
                        }
                    }
                }
            }else{
                $searchParameters .= trim($parameters[$i]) ." ";
            }
        }
        
        // $searchParameters .= " AND";
    }
}

$sql1 = "SELECT ".$dbarray1.",".$dbarray2." FROM ".$dbarray0." WHERE 1=1";

if(strlen($dbarray3) > 2){
    $sql1 .= " AND ".$dbarray3;
}

if(strlen($searchParameters) > 2){
    $sql1 .= " AND ".$searchParameters;
}

$sql1 .= " ORDER BY ".$dbarray2;

$result = db::getInstance()->db_select($sql1);

$row = $result['result_set'];
$arr = array("data" => $row);
echo json_encode($arr);

?>
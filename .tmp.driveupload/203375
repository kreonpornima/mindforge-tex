<?php 
require_once ('dbClass.php');

include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding
// header('Content-Type: application/json; charset=utf-8');

$searchText = isset($_POST['searchText']) ? $_POST['searchText'] : "";
$searchParam = isset($_POST['searchParam']) ? $_POST['searchParam'] : "";
$fromRepo = isset($_POST['fromRepo']) ? $_POST['fromRepo'] : "";
$repoCondition = isset($_POST['repoCondition']) ? $_POST['repoCondition'] : "";
$responseParams = isset($_POST['responseParams']) ? $_POST['responseParams'] : "";
$searchParam1 = isset($_POST['searchText1']) ? $_POST['searchText1'] : "";
$searchText1 = isset($_POST['searchText1']) ? $_POST['searchText1'] : "";
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : 0;
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : 0;
$currentId = isset($_POST['currentId']) ? $_POST['currentId'] : "";
$gridserial = isset($_POST['gridSerial']) ? $_POST['gridSerial'] : "";

if($GridID > 0){
    $sql = "SELECT FieldType, FieldOtherConditions FROM kgridfields where GridId=".$GridID." AND DbFieldName='$currentId'";
}else{
    $sql = "SELECT FieldType, FieldOtherConditions FROM kmainfields where FormId=".$FormID." AND DbFieldName='$currentId'";
}

$sqlresult = db::getInstanceMaster()->db_select($sql);

$fieldOtherCondition = $sqlresult['result_set'][0]['FieldOtherConditions'];
$fieldtype = $sqlresult['result_set'][0]['FieldType'];

$str1 = 'parameters';
$parametersPos = -1;
if (strpos($fieldOtherCondition, $str1) !== false){
    $parametersPos = strpos($fieldOtherCondition,$str1);
}

$searchText1 = urldecode($searchText1);
$searchText1Array = explode('&',$searchText1);
$searchParameters = '';
if($parametersPos != -1){
    $extractParameters = substr($fieldOtherCondition , strpos($fieldOtherCondition, '{')+1, strpos($fieldOtherCondition,'}') - 1);
    $extractedparameters = str_replace('}','',$extractParameters);

    $extractedparameters = preg_replace('~\s*([?])~',  ' ?', $extractedparameters);
    $extractedparameters = preg_replace('~\s*([#])~',  ' #', $extractedparameters);
    $extractedparameters = preg_replace('~\s*([!])~',  ' !', $extractedparameters);
    $extractedparameters = preg_replace('~\s*([)])~',  ' )', $extractedparameters);

    if(strlen($extractedparameters) > 1){
        $parameters = explode(" ",$extractedparameters);
    
        for($i=0; $i<sizeof($parameters); $i++){
            
            if(strpos(trim($parameters[$i]), '?') !== false || strpos(trim($parameters[$i]), '#') !== false || strpos(trim($parameters[$i]), '!') !== false){

                if(strlen($parameters[$i]) > 1){
                    if($GridID > 0){
                        if(strpos(trim($parameters[$i]), '?') !== false){

                            $qExtractedString = "kreon-grid-".$gridserial ."".str_replace('?', '', trim($parameters[$i]));
                            
                        }else if(strpos(trim($parameters[$i]), '#') !== false){
                            $qExtractedString = str_replace('#', '', trim($parameters[$i]));
                            
                        }else if(strpos(trim($parameters[$i]), '!') !== false){
                            $qExtractedString = str_replace('!', '', trim($parameters[$i]));
                            if(trim($qExtractedString) == 'companyid'){
                                $searchParameters .= $_SESSION['dbCompany'];
                                $searchParameters .= " ";
                            }else if(trim($qExtractedString) == 'userid'){
                                $searchParameters .= $_SESSION['user_id'];
                                $searchParameters .= " ";
                            }else if(trim($qExtractedString) == 'formid'){
                                $searchParameters .= $FormID;
                                $searchParameters .= " "; 
                            }
                        }
                    }else{
                        if(strpos(trim($parameters[$i]), '!') !== false){
                            $qExtractedString = str_replace('!', '', trim($parameters[$i]));
                            if(trim($qExtractedString) == 'companyid'){
                                $searchParameters .= $_SESSION['dbCompany'];
                                $searchParameters .= " ";
                            }else if(trim($qExtractedString) == 'userid'){
                                $searchParameters .= $_SESSION['user_id'];
                                $searchParameters .= " ";
                            }else if(trim($qExtractedString) == 'formid'){
                                $searchParameters .= $FormID;
                                $searchParameters .= " ";
                            }
                        }else{
                            $qExtractedString = str_replace('#', '', trim($parameters[$i]));
                        }
                    }

                    if(strlen($qExtractedString) > 0){
                     
                        for($j=0; $j<sizeof($searchText1Array); $j++){
                            $splitSearchText1Array = explode("=",$searchText1Array[$j]);

                            $formSerializeFieldUrlDecode = urldecode($splitSearchText1Array[0]);
                            $qExtractedString = str_replace(array( '[', ']'), '', $qExtractedString);
                            $formSerializeField = str_replace(array( '[', ']'), '', $formSerializeFieldUrlDecode);
                            // echo trim($qExtractedString);
                            // echo "<br>".$splitSearchText1Array[1]  ."==". trim($qExtractedString);
                            if(trim($formSerializeField) == trim($qExtractedString)){
                                // echo trim($formSerializeField) ."==". trim($qExtractedString);
                                // echo  $splitSearchText1Array[1];
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
        
        $searchParameters .= " AND";
    }
}
// echo $searchParameters;



$tmpArr = explode("," , $responseParams);
$tmpOrd = $tmpArr[1];
$tmpArr[0] .= " as ddID ";
$tmpArr[1] .= " as ddVal ";
$responseParams = implode(",", $tmpArr);
// $query = "SELECT " . $responseParams . " from " . $fromRepo . " where " . $searchParam . " like '%".$searchText."%'";
//SELECT BNAME FROM ASAB15 WHERE BNAME LIKE NOV ORDER BY CASE WHEN BNAME LIKE NOV THEN 1 ELSE 2 END, BNAME
$query = "SELECT " . $responseParams . " from " . $fromRepo;

if(strlen($searchParameters) == 0 && strlen($repoCondition) == 0){
    $query .= " WHERE 1=1 AND ";
}

if(strlen($repoCondition) > 1){
    $query .= $repoCondition." AND ";
}

$query .= " ".$searchParameters . " " . $searchParam . " like '%".urldecode($searchText)."%'  ORDER BY CASE WHEN $tmpOrd LIKE '".$searchText."%' THEN 1 ELSE 2 END, $tmpOrd ";
// echo $query;
$result = db::getInstance()->db_select($query);

$row = $result['result_set'];

$data = [];
for($i=0; $i<count($result['result_set']); $i++){
    array_push($data, array('ddID'=>$row[$i]['ddID'],'ddVal'=>Encoding::fixUTF8($row[$i]['ddVal']),Encoding::ICONV_IGNORE));
}

$arr = array("data" => $data);

echo json_encode($arr);

 ?>


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

$fieldOtherCondition = trim($sqlresult['result_set'][0]['FieldOtherConditions']);
$fieldtype = $sqlresult['result_set'][0]['FieldType'];

// function extractSection($text, $keyword) {
//     $pos = strpos($text, $keyword . '{');
//     if ($pos !== false) {
//         $start = strpos($text, '{', $pos);
//         $end   = strpos($text, '}', $start);
//         if ($start !== false && $end !== false) {
//             return trim(substr($text, $start + 1, $end - $start - 1));
//         }
//     }
//     return null;
// }

function extractSection($text, $keyword) {
    if (preg_match('/' . preg_quote($keyword, '/') . '\s*{([^}]*)}/i', $text, $matches)) {
        return trim($matches[1]);
    }
    return null;
}


$parameters = extractSection($fieldOtherCondition, 'parameters');

$dropdownFromDB = extractSection($fieldOtherCondition, 'dropdownFromDB');



if(strlen($dropdownFromDB) > 5){
    $fromRepo = $dropdownFromDB;
}


$searchText1 = urldecode($searchText1);
$searchText1Array = explode('&',$searchText1);
$searchParameters = '';
if(strlen($parameters) > 5 ){

    if (strlen($parameters) > 1) {
        // Sample input string
        $inputString = $parameters;
    
        // Define the regular expression to match the desired patterns
        $regex = '/([?#!][a-zA-Z0-9_]+)/';  
    
        // Initialize an empty array to hold the matches
        $matches = [];
    
        // Use preg_match_all to find all matches
        preg_match_all($regex, $inputString, $matches);
    
        // Use only the first capture group (the actual matched parametersParams values)
        $parametersParams = $matches[1];
    
        // print_r($parametersParams); // Debug: print the extracted parametersParams
    
        for ($i = 0; $i < sizeof($parametersParams); $i++) {
            $param = trim($parametersParams[$i]);
    
            if (strpos($param, '?') !== false || strpos($param, '#') !== false || strpos($param, '!') !== false) {
                if (strlen($param) > 1) {
                    if ($GridID > 0) {
                        // Handle different cases based on '?' or '#' or '!'
                        if (strpos($param, '?') !== false) {
                            $qExtractedString = "kreon-grid-" . $gridserial . str_replace('?', '', $param);
                        } elseif (strpos($param, '#') !== false) {
                            $qExtractedString = str_replace('#', '', $param);
                        } elseif (strpos($param, '!') !== false) {
                            $qExtractedString = str_replace('!', '', $param);
                            // Add specific logic for 'companyid', 'userid', 'yearcode'
                            if ($qExtractedString == 'companyid') {
                                $replaceString = $_SESSION['dbCompany'] . " ";
                            } elseif ($qExtractedString == 'userid') {
                                $replaceString = $_SESSION['user_id'] . " ";
                            } elseif ($qExtractedString == 'yearcode') {
                                $replaceString = $_SESSION['dbYear'] . " ";
                            }else if(trim($qExtractedString) == 'formid'){
                                $replaceString .= $FormID; 
                            } elseif ($qExtractedString == 'divisionid') {
                                $replaceString = $_SESSION['dbDivision'] . " ";
                            }
                        }
                    } else {
                        // Case when $GridID <= 0
                        if (strpos($param, '!') !== false) {
                            $qExtractedString = str_replace('!', '', $param);
                            // Handle specific parameters
                            if ($qExtractedString == 'companyid') {
                                $replaceString = $_SESSION['dbCompany'] . " ";
                            } elseif ($qExtractedString == 'userid') {
                                $replaceString = $_SESSION['user_id'] . " ";
                            } elseif ($qExtractedString == 'yearcode') {
                                $replaceString = $_SESSION['dbYear'] . " ";
                            }else if(trim($qExtractedString) == 'formid'){
                                $replaceString .= $FormID; 
                            }elseif ($qExtractedString == 'divisionid') {
                                $replaceString = $_SESSION['dbDivision'] . " ";
                            }
                        } else {
                            $qExtractedString = str_replace('#', '', $param);
                        }
                    }
    
                    // Ensure qExtractedString is non-empty before continuing
                    if (strlen($qExtractedString) > 0) {
                        // Loop over $searchText1Array and match values
                        for ($j = 0; $j < sizeof($searchText1Array); $j++) {
                            $splitSearchText1Array = explode("=", $searchText1Array[$j]);
                            $formSerializeFieldUrlDecode = urldecode($splitSearchText1Array[0]);
                            $qExtractedString = str_replace(array('[', ']'), '', $qExtractedString);
                            $formSerializeField = str_replace(array('[', ']'), '', $formSerializeFieldUrlDecode);
    
                            if (trim($formSerializeField) == trim($qExtractedString)) {
                                // Append the corresponding value to $searchParameters
                                $replaceString = $splitSearchText1Array[1] != "" ? $splitSearchText1Array[1] : '';
                                // $replaceString .= " ";
                            }
                        }
                    }
                    // print_r($parameters[$i]);
                    // echo "<br>".$replaceString . " == ".$parameters[$i];
                    $inputString = str_replace($parametersParams[$i], $replaceString, $inputString);
                }
            } 
            // else {
            //     // Handle parameters without special characters
            //     $searchParameters .= $param . " ";
            // }
        }
        $searchParameters = $inputString;
        // Append "AND" to the search parameters
        $searchParameters .= " AND";
    }
    
}





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
    $query .= " ".$repoCondition." AND ";
}


$query .= " ".$searchParameters . " " . $searchParam . " like '%".urldecode($searchText)."%'  ORDER BY CASE WHEN $tmpOrd LIKE '".$searchText."%' THEN 1 ELSE 2 END, $tmpOrd ";

// if($_SESSION['user_id'] == 1020){
//     echo $query;
// }

$result = db::getInstance()->db_select($query);

$row = $result['result_set'];

$data = [];
for($i=0; $i<count($result['result_set']); $i++){
    array_push($data, array('ddID'=>$row[$i]['ddID'],'ddVal'=>Encoding::fixUTF8($row[$i]['ddVal']),Encoding::ICONV_IGNORE));
}

$arr = array("data" => $data);

echo json_encode($arr);

 ?>


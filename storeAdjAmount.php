<?php 

require_once ('dbClass.php');

$jsonData = isset($_POST['jsonData']) ? $_POST['jsonData'] : "";
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : "";

// print_r($jsonData);

$data['name'] = 'SP_ADJDETAILS_'.$FormID;
// $session .= 'YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';
$data['params'] = ['@jsonData'];
$data['values'] = ["'".json_encode($jsonData)."'"];

$result = db::getInstance()->db_sp_select($data['name'], $data['params'], $data['values']); 
// print_r($result);
$row = $result['result_set'][0][0];

if($row['GridResponse']){
    if(strlen($row['GridResponse']) > 5){
        $row['GridResponse'] = trim($row['GridResponse']);

        $str1 = 'GridResponse';
        $GridResponsePos = -1;
        if (strpos($row['GridResponse'], $str1) !== false){
            $GridResponsePos = strpos($row['GridResponse'],$str1);
        }

        if($GridResponsePos != -1){
            $GridResponseParameters = substr($row['GridResponse'] , strpos($row['GridResponse'], '{')+1, strpos($row['GridResponse'],'}') - 1);
            $GridResponse = str_replace('}','',$GridResponseParameters);

            if(strlen($GridResponse) > 5){
                $row = array("GridResponse" => $GridResponse,"Msg"=>$row['Msg'],"Success"=>$row['Success']);
            } 
        }
    }
}
$arr = array("data" => $row);
// print_r($arr);
echo json_encode($arr);

?>
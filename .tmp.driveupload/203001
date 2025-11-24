<?php

    require_once ('dbClass.php');
    
    $FormID = isset($_REQUEST['FormID']) ? $_REQUEST['FormID'] : '0';
    $FieldID = isset($_REQUEST['FieldID']) ? $_REQUEST['FieldID'] : '';
    $SPName = 'sp_PopupFormGetData_'.$FormID.'_'.$FieldID;
    $ColumnFilters = isset($_REQUEST['ColumnFilters']) ? $_REQUEST['ColumnFilters'] : '';
    $conditionString = isset($_REQUEST['conditionString']) ? $_REQUEST['conditionString'] : '';
    $jsonData = isset($_REQUEST['jsonData']) ? $_REQUEST['jsonData'] : '';
    
    $FilterCondition = '';

    if(strlen($ColumnFilters) > 3){
        $ColumnFiltersArray = explode("|",$ColumnFilters);
        for($i=0; $i<count($ColumnFiltersArray); $i++){
            $ColumnFilter = explode(":",$ColumnFiltersArray[$i]);
            $FilterCondition .= " AND ";
            $FilterCondition .= $ColumnFilter[0]." like '%".$ColumnFilter[1]."%'"; 
        }
    }
    // echo $FilterCondition;
    $sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
    $checkSp = db::getInstance()->db_select($sql);
 
    if($checkSp['result_set'][0]['found'] == 1){
        $data['params'] = ['@FormID','@FieldID','@FilterCondition','@ConditionString','@JsonData'];
        $sp['values'] = ["'$FormID'","'$FieldID'","'".$FilterCondition."'","'".$conditionString."'","'".$jsonData."'"];
        $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
       
    }

    // if($_SESSION['user_id'] == 1020){
    //     print_r($result);
    // }

    // Default values
    $rangelimit = 100;
    $step = 1;

    // Handle RangeLimit
    if (isset($result['result_set'][2][0]['RangeLimit'])) {
        $rangelimit = $result['result_set'][2][0]['RangeLimit'];
    } elseif (isset($result['result_set'][1][0]['RangeLimit'])) {
        // sometimes data not exists and RangeLimit shifts to [1]
        $rangelimit = $result['result_set'][1][0]['RangeLimit'];
    }

    // Handle Step
    if (isset($result['result_set'][3][0]['Step'])) {
        $step = $result['result_set'][3][0]['Step'];
    } elseif (isset($result['result_set'][2][0]['Step'])) {
        // sometimes data not exists and Step shifts to [2]
        $step = $result['result_set'][2][0]['Step'];
    }

    // Handle FieldJson (always at index 0)
    $fields = isset($result['result_set'][0][0]['FieldJson'])
        ? $result['result_set'][0][0]['FieldJson']
        : '[]';

    // Handle data — if exists
    $data = [];
    if (isset($result['result_set'][1][0]) && !isset($result['result_set'][1][0]['RangeLimit'])) {
        $data = $result['result_set'][1];
    }

    $arr = [
        "fields" => $fields,
        "data" => $data,
        "rangelimit" => $rangelimit,
        "step" => $step
    ];
    echo json_encode($arr);

?>
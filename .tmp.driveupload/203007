<?php 
    session_start();
    require_once('dbClass.php');

    $col = $colName = isset($_REQUEST['detail_col_name']) ? $_REQUEST['detail_col_name'] : '';
    $FormID = isset($_REQUEST['detail_FormID']) ? $_REQUEST['detail_FormID'] : 0;

    // $data = array();
    // $sql =  "select SPDrillReport, SPDrillUniqueID FROM kReportGridDrillReports where FormID = " . $FormID . " AND DbFieldName = '".$colName."'";
    // $result = db::getInstanceMaster()->db_select($sql);
    // // print_r($result);
    // $SPName = "sp_Drilldown_" . $FormID . "_" . $colName ; //$result['result_set'][0]['SPDrillReport'];
    // $param = $_REQUEST[$result['result_set'][0]['SPDrillUniqueID']];
    // $data['params'] = ['@ID'];
    // $sp['values'] = ["'$param'"];
    // $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']); 

    $SPName = "sp_Drilldown_" . $FormID ;
    $param = $_REQUEST[$result['result_set'][0]['SPDrillUniqueID']];
    $RowDataArray = $_REQUEST;
    $SessionArray = $_SESSION;
    // print_r($RowDataArray);
    // print_r($SessionArray);
    $keysToMerge = ['user_id'];
    $filteredArray2 = array_intersect_key($SessionArray, array_flip($keysToMerge));
    $merged = array_merge($RowDataArray, $filteredArray2);
    $RowData = json_encode($merged);
    $data['params'] = ['@Column','@ID','@RowData'];
    $sp['values'] = ["'$colName'","'$param'","'$RowData'"];
    
    $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']); 
    
    echo json_encode(array($result['result_set'][0],$result['result_set'][1]));
    exit;

?>
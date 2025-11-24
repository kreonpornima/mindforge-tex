<?php 
    session_start();
    require_once('dbClass.php');

    $col = $colName = isset($_REQUEST['detail_col_name']) ? $_REQUEST['detail_col_name'] : '';
    $FormID = isset($_REQUEST['detail_FormID']) ? $_REQUEST['detail_FormID'] : 0;

    $data = array();
    $sql =  "select SPDrillUniqueID FROM kReportGridDrillReports where FormID = " . $FormID . " AND DbFieldName = '".$colName."'";
    $result = db::getInstanceMaster()->db_select($sql);
    // print_r($result);
    $output =array();
    if(isset($_REQUEST[$result['result_set'][0]['SPDrillUniqueID']])){
        if($_REQUEST[$result['result_set'][0]['SPDrillUniqueID']] > 0){
            $SPName = "sp_Drilldown_" . $FormID . "_" . $colName ; 
            $data['params'] = ['@ID'];
            $param = $_REQUEST[$result['result_set'][0]['SPDrillUniqueID']];
            $sp['values'] = ["'$param'"];
            $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']); 
            $output = array($result['result_set'][0],$result['result_set'][1]);
        }else{
            $output = array('error' => true, 'Msg' => 'The ' . $result['result_set'][0]['SPDrillUniqueID'] . ' field does not exist.');
        }
    }else{
        $output = array('error' => true, 'Msg' => 'The ' . $result['result_set'][0]['SPDrillUniqueID'] . ' field does not exist.');
    }
    
    // if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
        ob_start("ob_gzhandler");
    // } else {
    //     ob_start();
    // }
    header('Content-Encoding: gzip');
    header('Content-Type: application/json');
    echo json_encode($output);
    ob_end_flush();
    exit;

?>
<?php 
    session_start();
    require_once('dbClass.php');
    function replace_space_in_keys($array) {
        $modified_array = [];
        foreach ($array as $key => $value) {
            $new_key = str_replace(' ', '_', $key);
            $modified_array[$new_key] = $value;
        }
        return $modified_array;
    }

    $p = isset($_REQUEST['params']) ? replace_space_in_keys($_REQUEST['params']) : [];

    $ReportID = isset($_REQUEST['ReportID']) ? $_REQUEST['ReportID'] : 0;
    $Field = isset($_REQUEST['Field']) ? $_REQUEST['Field'] : '';
    // $params = implode('|',$p);
    // echo "<br>".$params = http_build_query($p, '', '|');

    $params = implode('|', array_map(
        fn($k, $v) => "$k=$v",
        array_keys($p),
        $p
    ));

    $session = 'YearCode='.$_SESSION['dbYear'].'|DivisionId='.$_SESSION['dbDivision'].'|CompanyId='.$_SESSION['dbCompany'].'|FormID='.$ReportID.'|UserID='.$_SESSION['user_id'];
    $data['params'] = ['@params','@session'];
    $sp['values'] = ["'$params'", "'$session'"];
   
    $sql = "SELECT GetDataFromSP FROM kReportGridEditableFields WHERE DbFieldName='".$Field."' AND  FormID=".$ReportID;
    $result = db::getInstanceMaster()->db_select($sql);
    $SPName = $result['result_set'][0]['GetDataFromSP'];

    $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']); 
    // print_r($result['result_set'][0]);

    // $normal_array = array_map(function($item) {
    //     return $item['name'];
    // }, $result['result_set'][0]);
   
    $data = $result['result_set'][0];
    //  $key_name = key($data[0]); // Get the first key of the first sub-array (e.g., "name")

    // Validate to prevent errors
    if (!is_array($data) || count($data) == 0) {
        $normal_array = [];    // return empty response
    } else {
        $key_name = key($data[0]); // Get the first key of the first sub-array (e.g., "name")
        // Convert to normal array by extracting the dynamic key values
        $normal_array = array_map(function($item) use ($key_name) {
            return $item[$key_name]; // Use the dynamic key name
        }, $data);
    }

    //  $normal_array = array_map(function($item) use ($key_name) {
    //         return $item[$key_name]; // Use the dynamic key name
    //     }, $data);

    // print_r(array_values($result['result_set'][0]));
    // print_r($normal_array);

    // echo json_encode(array_values($result['result_set'][0]));
    
    
    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
        ob_start("ob_gzhandler");
    } else {
        ob_start();
    }
    header('Content-Encoding: gzip');
    header('Content-Type: application/json');
    echo json_encode($normal_array);
    ob_end_flush(); 
    exit;

?>
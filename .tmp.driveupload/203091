<?php
    require_once ('dbClass.php');
    // Read the raw POST input
    $input = file_get_contents('php://input');

    // Decode the JSON
    $data = json_decode($input, true); // `true` returns associative array

    // Access parameters
    $roleId = $data['roleId'] ?? null;
    $groupId = $data['group_id'] ?? null;

    $SPName = 'GroupRoleAccess';
    $data['params'] = ['@GROUPID','@ROLEID','@USERID','@CATEGORYID'];
    $sp['values'] = ["'".$groupId."'","'". $roleId."'","'".$_SESSION['user_id']."'","'".$_SESSION['Category']."'"];
    // print_r($sp['values']);
    $result = db::getInstanceMaster()->db_sp_select($SPName, $data['params'], $sp['values']);

  
    // print_r($result);
   
    echo json_encode($result['result_set'][0]);


?>

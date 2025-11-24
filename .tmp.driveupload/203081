<?php

require_once ('dbClass.php');

// Receive posted JSON data
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Role ID (could be posted separately or assumed)
$roleID = $_SESSION['access']; // You can modify this to dynamically get from POST or session

foreach ($data as $item) {
    // $level1 = $item['level1'];
    // $level2 = $item['level2'];
    // $level3 = $item['level3'];
    $pageID = $item['Level1'];
    // $pageId = !empty($level3) ? $level3 : (!empty($level2) ? $level2 : $level1);
    $add = isset($item['AddBtn']) && $item['AddBtn'] ? 1 : 0;
    $edit = isset($item['EditBtn']) && $item['EditBtn'] ? 1 : 0;
    $delete = isset($item['DeleteBtn']) && $item['DeleteBtn'] ? 1 : 0;
    $view = isset($item['ListView']) && $item['ListView'] ? 1 : 0;
    $print = isset($item['OtherBtn']) && $item['OtherBtn'] ? 1 : 0;

    // Check if record exists
    $checkSql = "SELECT ID FROM pageroleaccess_pornima WHERE RoleID = $roleID AND PageAccessID = $pageID";
    $checkStmt = db::getInstanceMaster()->db_select($checkSql);	

    if ($checkStmt['num_rows'] > 0) {
        // Update existing record
        $updateSql = "UPDATE pageroleaccess_pornima SET AddBtn=$add, EditBtn=$edit, DeleteBtn=$delete, ListView=$view, OtherBtn=$print WHERE RoleID=$roleID AND PageAccessID=$pageID";
        $result = db::getInstanceMaster()->db_update($updateSql);
    } else {
        // Insert new record
        $insertSql = "INSERT INTO pageroleaccess_pornima (RoleID, PageAccessID, AddBtn, EditBtn, DeleteBtn, ListView, OtherBtn)
                      VALUES ($roleID, $pageID, $add, $edit, $delete, $view, $print)";

        $result = db::getInstanceMaster()->db_insertQuery($insertSql);
    }

}


echo json_encode(["status" => "success"]);
?>

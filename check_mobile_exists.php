<?php
require_once ('dbClass.php');

$username = $_POST['username'];
$editID = isset($_POST['editID']) ? (int)$_POST['editID'] : 0;

// Prepare and run query
$sql = "SELECT COUNT(*) as cnt FROM users WHERE Username = '" . addslashes($username) . "'";
if ($editID > 0) {
    $sql .= " AND ID != $editID";
}

$result = db::getInstanceMaster()->db_select($sql);
if ($result && $result['num_rows'] > 0 && $result['result_set'][0]['cnt'] > 0) {
    echo "exists";
} else {
    echo "ok";
}
?>

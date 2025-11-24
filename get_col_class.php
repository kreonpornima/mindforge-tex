<?php
include_once('dbClass.php');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'Missing ID']);
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT col_class FROM dashboard_reports WHERE id = $id";
$res = db::getInstance()->db_select($sql);

if (!empty($res['result_set'])) {
    echo json_encode(['col_class' => $res['result_set'][0]['col_class']]);
} else {
    echo json_encode(['col_class' => 'col-md-6']);
}

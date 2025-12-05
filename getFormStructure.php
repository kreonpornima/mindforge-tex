<?php
    include "dbClass.php";
    $db = db::getInstanceMaster();

    $FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
    $FieldName = isset($_POST['FieldName']) ? $_POST['FieldName'] : '0';
    // echo "SELECT * FROM kmainforms WHERE FormId = $FormID";
    // Fetch form metadata
    $form = $db->db_select("SELECT * FROM kmainforms WHERE FormId = $FormID");
    $form = $form['result_set'][0]; // single record


    // Fetch fields
    $fieldsColumns = $db->db_select("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'kmainfields' ");

    $fields = $db->db_select("
        SELECT * FROM kmainfields 
        WHERE FormId = $FormID AND DbFieldName = '".$FieldName."'
        ORDER BY DisplayOrder
    ");

    // Fetch grids (if any)
    $grids = $db->db_select("
        SELECT * FROM kmaingrid 
        WHERE GridId IN (SELECT GridId FROM kmainfields WHERE FormId = $FormID)
    ");

    $arr = array(
        "form"            => $form,
        "fieldsColumns"   => $fieldsColumns['result_set'],
        "fields"          => $fields['result_set'],
        "grids"           => $grids,
        "editingAllowed"  => ($form['result_set'][0]['isOpenForDevelopment'] == 1)
    );
    echo json_encode($arr);
?>

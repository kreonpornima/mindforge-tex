<?php
    // include "dbClass.php";
    $db = db::getInstanceMaster();



    // echo $formId = $_POST['FormID'];

    // Fetch form metadata
    $form = $db->db_select("SELECT * FROM kmainforms WHERE FormId = $FormID");
    $form = $form[0]; // single record

    // Fetch fields
    $fields = $db->db_select("
        SELECT * FROM kmainfields 
        WHERE FormId = $FormID 
        ORDER BY DisplayOrder
    ");

    // Fetch grids (if any)
    $grids = $db->db_select("
        SELECT * FROM kmaingrid 
        WHERE GridId IN (SELECT GridId FROM kmainfields WHERE FormId = $FormID)
    ");

    echo json_encode([
        "form"            => $form,
        "fields"          => $fields,
        "grids"           => $grids,
        "editingAllowed"  => ($form['isOpenForDevelopment'] == 1)
    ]);
?>

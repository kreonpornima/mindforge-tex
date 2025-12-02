<?php
include "dbClass.php";
$db = new dbClass();

$fieldId     = $_POST["fieldId"];
$label       = $_POST["label"];
$placeholder = $_POST["placeholder"];
$required    = $_POST["required"];
$visible     = $_POST["visibility"];
$size        = $_POST["size"];

// Fetch field to get FormId
$field = $db->db_select("SELECT FormId FROM kmainfields WHERE main_id = $fieldId");
$formId = $field[0]["FormId"];

// Check if editing allowed
$form = $db->db_select("SELECT isOpenForDevelopment FROM kmainforms WHERE FormId = $formId");
if ($form[0]["isOpenForDevelopment"] != 1) {
    echo json_encode(["success" => false, "message" => "Editing not allowed"]);
    exit;
}

// Update query
$query = "
UPDATE kmainfields SET
    DisplayName      = '$label',
    OtherAttributes  = '$placeholder',
    Required         = $required,
    Visibility       = $visible,
    FieldSizeMD      = $size
WHERE main_id = $fieldId
";

$update = $db->db_update($query);

echo json_encode([
    "success" => $update ? true : false
]);
?>

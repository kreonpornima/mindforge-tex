<?php

$db = db::getInstanceMaster();

$fieldId = $_POST["fieldId"];

// Fetch field row
$field = $db->db_select("SELECT * FROM kmainfields WHERE main_id = $fieldId");
$field = $field[0];
// Get parent form
$form   = $db->db_select("SELECT isOpenForDevelopment FROM kmainforms WHERE FormId = $FormID");
$dev    = $form[0]["isOpenForDevelopment"];

// If form is locked, block editing
if ($dev != 1) {
    echo json_encode(["error" => "Editing is disabled for this form."]);
    exit;
}

// Build editable UI HTML
$html = '
<div class="prop-group">
    <label>Label</label>
    <input type="text" id="fldLabel" class="form-control"
           value="'.htmlspecialchars($field["DisplayName"]).'">
</div>

<div class="prop-group">
    <label>Placeholder / Attributes</label>
    <input type="text" id="fldPlaceholder" class="form-control"
           value="'.htmlspecialchars($field["OtherAttributes"]).'">
</div>

<div class="prop-group">
    <label>Required</label>
    <input type="checkbox" id="fldRequired" '.($field["Required"] ? "checked" : "").'>
</div>

<div class="prop-group">
    <label>Visible</label>
    <input type="checkbox" id="fldVisible" '.($field["Visibility"] ? "checked" : "").'>
</div>

<div class="prop-group">
    <label>Field Width (Bootstrap MD Column Size)</label>
    <input type="number" id="fldSize" class="form-control"
           min="1" max="12"
           value="'.$field["FieldSizeMD"].'">
</div>

<button onclick="saveFieldProperties('.$fieldId.')" class="btn btn-primary" style="margin-top:10px;">
    Save
</button>
';

echo json_encode(["html" => $html]);
?>

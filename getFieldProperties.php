<?php
include "dbClass.php";
$db = db::getInstanceMaster();

$fieldId = $_POST["fieldId"];
$type = isset($_POST['type']) ? $_POST['type'] : '';
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
$FieldName = isset($_POST['FieldName']) ? $_POST['FieldName'] : '0';
$GridID = isset($_POST['GridID']) ? $_POST['GridID'] : '0';
$response = ["html" => ""];

// Get parent form
$form   = $db->db_select("SELECT isOpenForDevelopment FROM kmainforms WHERE FormId = $FormID");
$dev = $form['result_set'][0]["isOpenForDevelopment"];

// If form is locked, block editing
// if ($dev != 1) {
//     echo json_encode(["error" => "Editing is disabled for this form."]);
//     // exit;
// }


if ($type == "form") {

    $fieldsColumns = $db->db_select("
        SELECT COLUMN_NAME, DATA_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'kmainforms'
    ");

    $fields = $db->db_select("
        SELECT * FROM kmainforms 
        WHERE FormId = $FormID
    ");

    $exclude = ['CreatedAt','UpdatedAt','FormId','CREATEDAT'];


    ob_start();
    echo "<h3>[".$fields['result_set'][0]['FormTitle']."]</h3>";
    echo "<ul class='kmain-list'>";

    foreach ($fieldsColumns["result_set"] as $col) {
        $name = $col["COLUMN_NAME"];
        if (in_array($name, $exclude)) continue;

        $value = $fields["result_set"][0][$name] ?? "";

        if ($name === "main_id") {
            echo "<input type='hidden' name='$name' value='$value'>";
            continue;
        }

        $type = ($col["DATA_TYPE"] == "int" || $col["DATA_TYPE"] == "smallint" || $col["DATA_TYPE"] == "tinyint") ? "number" : "text";
        // If number type and value is empty, set default to 0
        if ($type === "number" && ($value === null || $value === '')) {
            $value = 0;
        }

        echo "
            <li style='list-style:none;margin-bottom:5px;'>
                $name:
                <input type='$type' name='$name' class='form-control' value='$value'>
            </li>
        ";
    }

    echo "</ul>";

    $response["html"] = ob_get_clean();
}

if ($type == "fields") {

    $fieldsColumns = $db->db_select("
        SELECT COLUMN_NAME, DATA_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'kmainfields'
    ");

    $fieldname = trim($FieldName);          
    $fieldname = str_replace('-text', '', $fieldname);

    // echo " SELECT * FROM kmainfields WHERE FormId = $FormID AND DbFieldName = '$fieldname'";
    $fields = $db->db_select("
        SELECT * FROM kmainfields 
        WHERE FormId = $FormID AND DbFieldName = '$fieldname'
    ");

    $exclude = ['CreatedAt','UpdatedAt','FormId','MDRelationTable','MDPrimary','MDLabel','MDCondition','MDRelationKey','MDForeign','CREATEDAT','OLDID','olddbfield','oldrowid','CreatedBy','old_uniqueid'];


    ob_start();
    echo "<h3>[$FieldName]</h3>";
    echo "<ul class='kmain-list'>";

    foreach ($fieldsColumns["result_set"] as $col) {
        $name = $col["COLUMN_NAME"];
        if (in_array($name, $exclude)) continue;

        $value = $fields["result_set"][0][$name] ?? "";

        if ($name === "main_id") {
            echo "<input type='hidden' name='$name' value='$value'>";
            continue;
        }

        // $type = ($col["DATA_TYPE"] == "int" || $col["DATA_TYPE"] == "smallint" || $col["DATA_TYPE"] == "tinyint") ? "number" : "text";
        // // If number type and value is empty, set default to 0
        // if ($type === "number" && ($value === null || $value === '')) {
        //     $value = 0;
        // }

        // Detect type
        $dbType = strtolower($col["DATA_TYPE"]);
        $type = "text";

        if (in_array($dbType, ["int", "smallint", "tinyint"])) {
            $type = "number";

            if ($value === null || $value === '') {
                $value = 0;
            }
        }
        elseif (in_array($dbType, ["datetime", "smalldatetime", "timestamp", "datetime2"])) {
            $type = "datetime-local";

            if (!empty($value)) {

                // If value is DateTime object → convert to string
                if ($value instanceof DateTime) {
                    $value = $value->format("Y-m-d H:i:s");
                }

                $value = date("Y-m-d\TH:i", strtotime($value));
            }
        }
        elseif ($dbType == "date") {
            $type = "date";

            if (!empty($value)) {

                if ($value instanceof DateTime) {
                    $value = $value->format("Y-m-d");
                } else {
                    $value = date("Y-m-d", strtotime($value));
                }
            }
        }

        if($name == 'FieldOtherConditions'){
            echo "
                <li style='list-style:none;margin-bottom:5px;'>
                    $name:
                    <textarea type='$type' name='$name' rows='5' class='form-control' style='height: auto !important;'> $value</textarea>
                </li>
            ";
        }else{
            echo "
                <li style='list-style:none;margin-bottom:5px;'>
                    $name:
                    <input type='$type' name='$name' class='form-control' value='$value'>
                </li>
            ";
        }
    }

    echo "</ul>";

    $response["html"] = ob_get_clean();
}

if ($type == "grid") {

    $fieldsColumns = $db->db_select("
        SELECT COLUMN_NAME, DATA_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'kmaingrid'
    ");

    $fields = $db->db_select("
        SELECT * FROM kmaingrid 
        WHERE GridId = $GridID
    ");

    $exclude = ['CreatedAt','UpdatedAt','GridId','CREATEDAT','OLDID','OLD_TABLENAME','OLD_UNIQUEID'];


    ob_start();
    echo "<h3>[".$fields['result_set'][0]['GridTitle']."]</h3>";
    echo "<h6>GridID: $GridID</h6>";
    echo "<ul class='kmain-list'>";

    foreach ($fieldsColumns["result_set"] as $col) {
        $name = $col["COLUMN_NAME"];
        if (in_array($name, $exclude)) continue;

        $value = $fields["result_set"][0][$name] ?? "";

        if ($name === "main_id") {
            echo "<input type='hidden' name='$name' value='$value'>";
            continue;
        }

        $type = ($col["DATA_TYPE"] == "int" || $col["DATA_TYPE"] == "smallint" || $col["DATA_TYPE"] == "tinyint") ? "number" : "text";
        // If number type and value is empty, set default to 0
        if ($type === "number" && ($value === null || $value === '')) {
            $value = 0;
        }

        echo "
            <li style='list-style:none;margin-bottom:5px;'>
                $name:
                <input type='$type' name='$name' class='form-control' value='$value'>
            </li>
        ";
    }

    echo "</ul>";

    $response["html"] = ob_get_clean();
}

if ($type == "gridfields") {

    $fieldsColumns = $db->db_select("
        SELECT COLUMN_NAME, DATA_TYPE 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'kgridfields'
    ");

    $fieldname = trim($FieldName);          
    $fieldname = str_replace('-text', '', $fieldname);
    // echo "SELECT * FROM kgridfields WHERE GridId = $GridID AND DisplayName = '$FieldName'";
    $fields = $db->db_select("
        SELECT * FROM kgridfields 
        WHERE GridId = $GridID AND DisplayName = '$fieldname'
    ");

    $exclude = ['CreatedAt','UpdatedAt','GridId','CREATEDAT','olddbfield','old_tablename','OLD_UNIQUEID',];


    ob_start();
    echo "<h3>[$FieldName]</h3>";
    echo "<h6>GridID: $GridID</h6>";
    echo "<ul class='kmain-list'>";

    foreach ($fieldsColumns["result_set"] as $col) {
        $name = $col["COLUMN_NAME"];
        if (in_array($name, $exclude)) continue;

        $value = $fields["result_set"][0][$name] ?? "";

        if ($name === "GridFieldId") {
            echo "<input type='hidden' name='$name' value='$value'>";
            continue;
        }

        $type = ($col["DATA_TYPE"] == "int" || $col["DATA_TYPE"] == "smallint" || $col["DATA_TYPE"] == "tinyint") ? "number" : "text";
        // If number type and value is empty, set default to 0
        if ($type === "number" && ($value === null || $value === '')) {
            $value = 0;
        }

        if($name == 'FieldOtherConditions'){
            echo "
                <li style='list-style:none;margin-bottom:5px;'>
                    $name:
                    <textarea type='$type' name='$name' rows='5' class='form-control' style='height: auto !important;'>$value</textarea>
                </li>
            ";
        }else{
            echo "
                <li style='list-style:none;margin-bottom:5px;'>
                    $name:
                    <input type='$type' name='$name' class='form-control' value='$value'>
                </li>
            ";
        }

    }

    echo "</ul>";

    $response["html"] = ob_get_clean();
}


echo json_encode($response);

// Fetch form fields
// $fieldsColumns = $db->db_select("SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'kmainfields' ");

// $fields = $db->db_select("
//     SELECT * FROM kmainfields 
//     WHERE FormId = $FormID AND DbFieldName = '".$FieldName."'
//     ORDER BY DisplayOrder
// ");

// $arr = array(
//     "fieldsColumns"   => $fieldsColumns['result_set'],
//     "fields"          => $fields['result_set'],
//     "editingAllowed"  => ($form['result_set'][0]['isOpenForDevelopment'] == 1)
// );
// echo json_encode($arr);


// echo json_encode(["html" => $html]);
?>

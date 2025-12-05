<?php
include "dbClass.php";
$db = db::getInstanceMaster();

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : 0;
$saveType = isset($_POST['saveType']) ? $_POST['saveType'] : '';

$form   = $db->db_select("SELECT isOpenForDevelopment FROM kmainforms WHERE FormId = $FormID");
$dev = $form['result_set'][0]["isOpenForDevelopment"];

// If form is locked, block editing
if ($dev != 1) {
    echo json_encode(["success" => false, "message" => "Editing not allowed"]);
    exit;
}

// Helper function to safely quote values
function quote($val) {
    global $db;
    if ($val === '' || $val === null) return "NULL";
    // Escape single quotes
    $val = str_replace("'", "''", $val);
    return "'$val'";
}

if($saveType == 'fields'){
    $MainID = isset($_POST['main_id']) ? $_POST['main_id'] : 0;
    $DbFieldName = isset($_POST['DbFieldName']) ? $_POST['DbFieldName'] : '';
    $FieldType = isset($_POST['FieldType']) ? $_POST['FieldType'] : 0;
    $DisplayName = isset($_POST['DisplayName']) ? $_POST['DisplayName'] : '';
    $FieldOtherConditions = isset($_POST['FieldOtherConditions']) ? $_POST['FieldOtherConditions'] : '';
    $Required = isset($_POST['Required']) ? $_POST['Required'] : 0;
    $OtherAttributes = isset($_POST['OtherAttributes']) ? $_POST['OtherAttributes'] : '';
    $FieldSizeMD = isset($_POST['FieldSizeMD']) ? $_POST['FieldSizeMD'] : 0;
    $FieldSizeSM = isset($_POST['FieldSizeSM']) ? $_POST['FieldSizeSM'] : 0;
    $FieldSizeXS = isset($_POST['FieldSizeXS']) ? $_POST['FieldSizeXS'] : 0;
    $Visibility = isset($_POST['Visibility']) ? $_POST['Visibility'] : 0;
    $TextLength = isset($_POST['TextLength']) ? $_POST['TextLength'] : 0;
    $TextMax = isset($_POST['TextMax']) ? $_POST['TextMax'] : 0;
    $TextMin = isset($_POST['TextMin']) ? $_POST['TextMin'] : 0;
    $ReadOnly = isset($_POST['ReadOnly']) ? $_POST['ReadOnly'] : 0;
    $TabIndex = isset($_POST['TabIndex']) ? $_POST['TabIndex'] : 0;
    $ValueFromDb = isset($_POST['ValueFromDb']) ? $_POST['ValueFromDb'] : 0;
    $TableFromDb = isset($_POST['TableFromDb']) ? $_POST['TableFromDb'] : '';
    $TablePrimary = isset($_POST['TablePrimary']) ? $_POST['TablePrimary'] : '';
    $TableLabel = isset($_POST['TableLabel']) ? $_POST['TableLabel'] : '';
    $TableCondition = isset($_POST['TableCondition']) ? $_POST['TableCondition'] : '';
    $TableMapTable = isset($_POST['TableMapTable']) ? $_POST['TableMapTable'] : '';
    $TableMapPrimary = isset($_POST['TableMapPrimary']) ? $_POST['TableMapPrimary'] : '';
    $TableMapOtherKey = isset($_POST['TableMapOtherKey']) ? $_POST['TableMapOtherKey'] : '';
    $Onchange = isset($_POST['Onchange']) ? $_POST['Onchange'] : '';
    $OnchangeParameters = isset($_POST['OnchangeParameters']) ? $_POST['OnchangeParameters'] : '';
    $DisplayOrder = isset($_POST['DisplayOrder']) ? $_POST['DisplayOrder'] : 0;
    $ViewOrder = isset($_POST['ViewOrder']) ? $_POST['ViewOrder'] : 0;
    $ViewDisplayName = isset($_POST['ViewDisplayName']) ? $_POST['ViewDisplayName'] : '';
    $ViewSerial = isset($_POST['ViewSerial']) ? $_POST['ViewSerial'] : 0;
    $ViewEdit = isset($_POST['ViewEdit']) ? $_POST['ViewEdit'] : 0;
    $ViewDelete = isset($_POST['ViewDelete']) ? $_POST['ViewDelete'] : 0;
    $GridId = isset($_POST['GridId']) ? $_POST['GridId'] : 0;
    // $MDRelationTable = isset($_POST['MDRelationTable']) ? $_POST['MDRelationTable'] : '';
    // $MDPrimary = isset($_POST['MDPrimary']) ? $_POST['MDPrimary'] : '';
    // $MDLabel = isset($_POST['MDLabel']) ? $_POST['MDLabel'] : '';
    // $MDCondition = isset($_POST['MDCondition']) ? $_POST['MDCondition'] : '';
    // $MDRelationKey = isset($_POST['MDRelationKey']) ? $_POST['MDRelationKey'] : '';
    // $MDForeign = isset($_POST['MDForeign']) ? $_POST['MDForeign'] : '';
    $Onkeyup = isset($_POST['Onkeyup']) ? $_POST['Onkeyup'] : '';
    $OnkeyupParameters = isset($_POST['OnkeyupParameters']) ? $_POST['OnkeyupParameters'] : '';
    $TextareaHeight = isset($_POST['TextareaHeight']) ? $_POST['TextareaHeight'] : 0;
    $DynamicFreeFill = isset($_POST['DynamicFreeFill']) ? $_POST['DynamicFreeFill'] : 0;
    $OnDynamicFreeFill = isset($_POST['OnDynamicFreeFill']) ? $_POST['OnDynamicFreeFill'] : 0;
    $AddMaster = isset($_POST['AddMaster']) ? $_POxST['AddMaster'] : 0;
    $DropDownYesNo = isset($_POST['DropDownYesNo']) ? $_POST['DropDownYesNo'] : 0;
    $OnDropDownYesNo = isset($_POST['OnDropDownYesNo']) ? $_POST['OnDropDownYesNo'] : 0;
    $ShowTextBoxInGrid = isset($_POST['ShowTextBoxInGrid']) ? $_POST['ShowTextBoxInGrid'] : 0;
    $OnLostFocusYesNo = isset($_POST['OnLostFocusYesNo']) ? $_POST['OnLostFocusYesNo'] : 0;
    $OnLostFocus = isset($_POST['OnLostFocus']) ? $_POST['OnLostFocus'] : '';
    $OnDropDownAjax = isset($_POST['OnDropDownAjax']) ? $_POST['OnDropDownAjax'] : '';
    $DDSearchMinimumInputLength = isset($_POST['DDSearchMinimumInputLength']) ? $_POST['DDSearchMinimumInputLength'] : 0;
    $CarryOn = isset($_POST['CarryOn']) ? $_POST['CarryOn'] : 0;
    $DefaultValue = (isset($_POST['DefaultValue']) && $_POST['DefaultValue'] !== '') ? $_POST['DefaultValue'] : 0;
    $dt = isset($_POST['dt']) ? $_POST['dt'] : '';
    $isNotEditable = isset($_POST['isNotEditable']) ? $_POST['isNotEditable'] : 0;
    $RegExpression = isset($_POST['RegExpression']) ? $_POST['RegExpression'] : '';
    $OnLostFocusSp = isset($_POST['OnLostFocusSp']) ? $_POST['OnLostFocusSp'] : '';
    $OnChangeSp = isset($_POST['OnChangeSp']) ? $_POST['OnChangeSp'] : '';
    $OnClickSp = isset($_POST['OnClickSp']) ? $_POST['OnClickSp'] : '';
    $DbFieldid = isset($_POST['DbFieldid']) ? $_POST['DbFieldid'] : '';
    $DefaultField = isset($_POST['DefaultField']) ? $_POST['DefaultField'] : '';
    $SqlQueryOnInsert = isset($_POST['SqlQueryOnInsert']) ? $_POST['SqlQueryOnInsert'] : '';
    $NotAllowCursorOnLostFocus = isset($_POST['NotAllowCursorOnLostFocus']) ? $_POST['NotAllowCursorOnLostFocus'] : 0;
    $AfterGridAddCursorPosition = isset($_POST['AfterGridAddCursorPosition']) ? $_POST['AfterGridAddCursorPosition'] : '';
    $GridTableHeight = isset($_POST['GridTableHeight']) ? $_POST['GridTableHeight'] : 0;
    $isBarcodeTextbox = isset($_POST['isBarcodeTextbox']) ? $_POST['isBarcodeTextbox'] : '';
    $DecimalPlaces = isset($_POST['DecimalPlaces']) ? $_POST['DecimalPlaces'] : 0;
    $DependentField = isset($_POST['DependentField']) ? $_POST['DependentField'] : '';
    $NonEditableFields = isset($_POST['NonEditableFields']) ? $_POST['NonEditableFields'] : 0;


    // Check if editing allowed
    $form = $db->db_select("SELECT isOpenForDevelopment FROM kmainforms WHERE FormId = $FormID");
    if ($form['result_set'][0]["isOpenForDevelopment"] != 1) {
        echo json_encode(["success" => false, "message" => "Editing not allowed"]);
        exit;
    }

    // MDRelationTable = ".quote($MDRelationTable).",
        // MDPrimary = ".quote($MDPrimary).",
        // MDLabel = ".quote($MDLabel).",
        // MDCondition = ".quote($MDCondition).",
        // MDRelationKey = $MDRelationKey,
        // MDForeign = $MDForeign,

    // Update query
    $query = "UPDATE kmainfields SET
        DbFieldName = ".quote($DbFieldName).",
        FieldType = $FieldType,
        DisplayName = ".quote($DisplayName).",
        FieldOtherConditions = ".quote($FieldOtherConditions).",
        Required = $Required,
        OtherAttributes = ".quote($OtherAttributes).",
        FieldSizeMD = $FieldSizeMD,
        FieldSizeSM = $FieldSizeSM,
        FieldSizeXS = $FieldSizeXS,
        Visibility = $Visibility,
        TextLength = $TextLength,
        TextMax = $TextMax,
        TextMin = $TextMin,
        ReadOnly = $ReadOnly,
        TabIndex = $TabIndex,
        ValueFromDb = $ValueFromDb,
        TableFromDb = ".quote($TableFromDb).",
        TablePrimary = ".quote($TablePrimary).",
        TableLabel = ".quote($TableLabel).",
        TableCondition = ".quote($TableCondition).",
        TableMapTable = ".quote($TableMapTable).",
        TableMapPrimary = ".quote($TableMapPrimary).",
        TableMapOtherKey = ".quote($TableMapOtherKey).",
        Onchange = $Onchange,
        OnchangeParameters = ".quote($OnchangeParameters).",
        DisplayOrder = $DisplayOrder,
        ViewOrder = $ViewOrder,
        ViewDisplayName = ".quote($ViewDisplayName).",
        ViewSerial = $ViewSerial,
        ViewEdit = $ViewEdit,
        ViewDelete = $ViewDelete,
        GridId = $GridId,
        Onkeyup = $Onkeyup,
        OnkeyupParameters = ".quote($OnkeyupParameters).",
        TextareaHeight = $TextareaHeight,
        DynamicFreeFill = $DynamicFreeFill,
        OnDynamicFreeFill = ".quote($OnDynamicFreeFill).",
        AddMaster = ".quote($AddMaster).",
        DropDownYesNo = $DropDownYesNo,
        OnDropDownYesNo = ".quote($OnDropDownYesNo).",
        ShowTextBoxInGrid = ".quote($ShowTextBoxInGrid).",
        OnLostFocusYesNo = $OnLostFocusYesNo,
        OnLostFocus = ".quote($OnLostFocus).",
        OnDropDownAjax = ".quote($OnDropDownAjax).",
        DDSearchMinimumInputLength = $DDSearchMinimumInputLength,
        CarryOn = $CarryOn,
        DefaultValue = $DefaultValue,
        dt = " . (!empty($dt) ? "'" . str_replace("'", "''", $dt) . "'" : "NULL") . ",
        isNotEditable = $isNotEditable,
        RegExpression = ".quote($RegExpression).",
        OnLostFocusSp = $OnLostFocusSp,
        OnChangeSp = $OnChangeSp,
        OnClickSp = $OnClickSp,
        DbFieldid = $DbFieldid,
        DefaultField = ".quote($DefaultField).",
        SqlQueryOnInsert = ".quote($SqlQueryOnInsert).",
        NotAllowCursorOnLostFocus = $NotAllowCursorOnLostFocus,
        AfterGridAddCursorPosition = ".quote($AfterGridAddCursorPosition).",
        GridTableHeight = $GridTableHeight,
        isBarcodeTextbox = $isBarcodeTextbox,
        DecimalPlaces = $DecimalPlaces,
        DependentField = ".quote($DependentField).",
        NonEditableFields = ".quote($NonEditableFields)."

    WHERE main_id = $MainID
    ";

    $update = $db->db_update($query);
}

if($saveType == 'form'){
    $FormName = isset($_POST['FormName']) ? $_POST['FormName'] : '';
    $FormTitle = isset($_POST['FormTitle']) ? $_POST['FormTitle'] : '';
    $TableName = isset($_POST['TableName']) ? $_POST['TableName'] : '';
    $TablePrimaryKey = isset($_POST['TablePrimaryKey']) ? $_POST['TablePrimaryKey'] : '';
    $TableCondition = isset($_POST['TableCondition']) ? $_POST['TableCondition'] : '';
    $ViewSerialNo = isset($_POST['ViewSerialNo']) ? $_POST['ViewSerialNo'] : 0;
    $ViewEditBtn = isset($_POST['ViewEditBtn']) ? $_POST['ViewEditBtn'] : 0;
    $ViewDeleteBtn = isset($_POST['ViewDeleteBtn']) ? $_POST['ViewDeleteBtn'] : 0;
    $ViewOtherBtn = isset($_POST['ViewOtherBtn']) ? $_POST['ViewOtherBtn'] : 0;
    $OtherBtnIcon = isset($_POST['OtherBtnIcon']) ? $_POST['OtherBtnIcon'] : '';
    $OtherBtnLink = isset($_POST['OtherBtnLink']) ? $_POST['OtherBtnLink'] : '';
    $SaveAddMore = isset($_POST['SaveAddMore']) ? $_POST['SaveAddMore'] : 0;
    $SaveAndPreview = isset($_POST['SaveAndPreview']) ? $_POST['SaveAndPreview'] : 0;
    $ListViewDBName = isset($_POST['ListViewDBName']) ? $_POST['ListViewDBName'] : '';
    $SessionDefault = isset($_POST['SessionDefault']) ? $_POST['SessionDefault'] : '';
    $ListViewNoOfData = isset($_POST['ListViewNoOfData']) ? $_POST['ListViewNoOfData'] : 0;
    $ProductCategoryID = isset($_POST['ProductCategoryID']) ? $_POST['ProductCategoryID'] : 0;
    $ModuleType = isset($_POST['ModuleType']) ? $_POST['ModuleType'] : 0;
    $ModuleStandard = isset($_POST['ModuleStandard']) ? $_POST['ModuleStandard'] : 0;
    $ViewViewBtn = isset($_POST['ViewViewBtn']) ? $_POST['ViewViewBtn'] : 0;
    $OrderBy = isset($_POST['OrderBy']) ? $_POST['OrderBy'] : '';
    $SPName = isset($_POST['SPName']) ? $_POST['SPName'] : '';
    $moduleid = isset($_POST['moduleid']) ? $_POST['moduleid'] : 0;
    $AfterAddCursorPosition = isset($_POST['AfterAddCursorPosition']) ? $_POST['AfterAddCursorPosition'] : '';
    $FormImportSPName = isset($_POST['FormImportSPName']) ? $_POST['FormImportSPName'] : '';
    $BarcodeSPName = isset($_POST['BarcodeSPName']) ? $_POST['BarcodeSPName'] : '';
    $formtype = isset($_POST['formtype']) ? $_POST['formtype'] : '';
    $credit = isset($_POST['credit']) ? $_POST['credit'] : 0;
    $debit = isset($_POST['debit']) ? $_POST['debit'] : 0;
    $formcode = isset($_POST['formcode']) ? $_POST['formcode'] : '';
    $PrintReportID = isset($_POST['PrintReportID']) ? $_POST['PrintReportID'] : 0;
    $refid = isset($_POST['refid']) ? $_POST['refid'] : 0;
    $BtnEinvoice = isset($_POST['BtnEinvoice']) ? $_POST['BtnEinvoice'] : 0;
    $BtnEwaybill = isset($_POST['BtnEwaybill']) ? $_POST['BtnEwaybill'] : 0;
    $BtnGstr1 = isset($_POST['BtnGstr1']) ? $_POST['BtnGstr1'] : 0;
    $BtnGstr2 = isset($_POST['BtnGstr2']) ? $_POST['BtnGstr2'] : 0;
    $SaveBtn = isset($_POST['SaveBtn']) ? $_POST['SaveBtn'] : 0;
    $PreviewAddNewBtn = isset($_POST['PreviewAddNewBtn']) ? $_POST['PreviewAddNewBtn'] : 0;
    $PreviewEditBtn = isset($_POST['PreviewEditBtn']) ? $_POST['PreviewEditBtn'] : 0;
    $PreviewDeleteBtn = isset($_POST['PreviewDeleteBtn']) ? $_POST['PreviewDeleteBtn'] : 0;
    $PreviewBackBtn = isset($_POST['PreviewBackBtn']) ? $_POST['PreviewBackBtn'] : 0;
    $isOpenForDevelopment = isset($_POST['isOpenForDevelopment']) ? $_POST['isOpenForDevelopment'] : 0;
    $ReportDefaultFromDate = isset($_POST['ReportDefaultFromDate']) ? $_POST['ReportDefaultFromDate'] : '';
    $ReportDefaultToDate = isset($_POST['ReportDefaultToDate']) ? $_POST['ReportDefaultToDate'] : '';
    $ReportSortBy = isset($_POST['ReportSortBy']) ? $_POST['ReportSortBy'] : '';

    // if ($TableCondition == NULL) {
    //     // Stop execution and return error
    //     echo json_encode([
    //         "success" => false,
    //         "message" => "TableCondition is required. Cannot save."
    //     ]);
    //     exit; // important to stop further processing
    // }

    $TableConditionSQL = ($TableCondition === '' || $TableCondition === null) ? "''" : quote($TableCondition);
    $OtherBtnIconSQL = ($OtherBtnIcon === '' || $OtherBtnIcon === null) ? "''" : quote($OtherBtnIcon);
    $OtherBtnLinkSQL = ($OtherBtnLink === '' || $OtherBtnLink === null) ? "''" : quote($OtherBtnLink);

    $query = "UPDATE kmainforms SET
        FormName = ".quote($FormName).",
        FormTitle = ".quote($FormTitle).",
        TableName = ".quote($TableName).",
        TablePrimaryKey = ".quote($TablePrimaryKey).",
        TableCondition =  $TableConditionSQL,
        ViewSerialNo = $ViewSerialNo,
        ViewEditBtn = $ViewEditBtn,
        ViewDeleteBtn = $ViewDeleteBtn,
        ViewOtherBtn = $ViewOtherBtn,
        OtherBtnIcon = $OtherBtnIconSQL,
        OtherBtnLink = $OtherBtnLinkSQL,
        SaveAddMore = $SaveAddMore,
        SaveAndPreview = $SaveAndPreview,
        ListViewDBName = ". quote($ListViewDBName) .",
        SessionDefault = ". quote($SessionDefault) .",
        ListViewNoOfData = $ListViewNoOfData,
        ProductCategoryID = $ProductCategoryID,
        ModuleType = $ModuleType,
        ModuleStandard = $ModuleStandard,
        ViewViewBtn = $ViewViewBtn,
        OrderBy = ". quote($OrderBy) .",
        SPName = ". quote($SPName) .",
        moduleid = $moduleid,
        AfterAddCursorPosition = ". quote($AfterAddCursorPosition) .",
        FormImportSPName = ". quote($FormImportSPName) .",
        BarcodeSPName = ". quote($BarcodeSPName) .",
        formtype = ". quote($formtype) .",
        credit = $credit,
        debit = $debit,
        formcode = ". quote($formcode) .",
        PrintReportID = $PrintReportID,
        refid = $refid,
        BtnEinvoice = $BtnEinvoice,
        BtnEwaybill = $BtnEwaybill,
        BtnGstr1 = $BtnGstr1,
        BtnGstr2 = $BtnGstr2,
        SaveBtn = $SaveBtn,
        PreviewAddNewBtn = $PreviewAddNewBtn,
        PreviewEditBtn = $PreviewEditBtn,
        PreviewDeleteBtn = $PreviewDeleteBtn,
        PreviewBackBtn = $PreviewBackBtn,
        isOpenForDevelopment = $isOpenForDevelopment,
        ReportDefaultFromDate = ". quote($ReportDefaultFromDate) .",
        ReportDefaultToDate = ". quote($ReportDefaultToDate).",
        ReportSortBy = ". quote($ReportSortBy) ."
    WHERE FormId = $FormID
    ";
    // exit();
    $update = $db->db_update($query);
}

if($saveType == 'grid'){
    $GridID = isset($_POST['gridID']) ? $_POST['gridID'] : '';
    $GridName = isset($_POST['GridName']) ? $_POST['GridName'] : '';
    $GridTitle = isset($_POST['GridTitle']) ? $_POST['GridTitle'] : '';
    $TableName = isset($_POST['TableName']) ? $_POST['TableName'] : '';
    $TablePrimaryKey = isset($_POST['TablePrimaryKey']) ? $_POST['TablePrimaryKey'] : '';
    $TableCondition = isset($_POST['TableCondition']) ? $_POST['TableCondition'] : '';
    $TableUnique = isset($_POST['TableUnique']) ? $_POST['TableUnique'] : '';
    $GridCalculation = isset($_POST['GridCalculation']) ? $_POST['GridCalculation'] : '';
    $BCODE = isset($_POST['BCODE']) ? $_POST['BCODE'] : '';
    $GridImportSPName = isset($_POST['GridImportSPName']) ? $_POST['GridImportSPName'] : '';
    $AfterGridAddCursorPosition = isset($_POST['AfterGridAddCursorPosition']) ? $_POST['AfterGridAddCursorPosition'] : '';
    $OrderBy = isset($_POST['OrderBy']) ? $_POST['OrderBy'] : '';
    $MinRowsRequired = isset($_POST['MinRowsRequired']) ? $_POST['MinRowsRequired'] : '';
    $RowwiseBarcodeUniqueID = isset($_POST['RowwiseBarcodeUniqueID']) ? $_POST['RowwiseBarcodeUniqueID'] : '';

    $TableConditionSQL = ($TableCondition === '' || $TableCondition === null) ? "''" : quote($TableCondition);
    $TableUniqueSQL = ($TableUnique === '' || $TableUnique === null) ? "''" : quote($TableUnique);

    $query = "UPDATE kmaingrid SET
        GridName = ".quote($GridName).",
        GridTitle = ".quote($GridTitle).",
        TableName = ".quote($TableName).",
        TablePrimaryKey = ".quote($TablePrimaryKey).",
        TableCondition =  $TableConditionSQL,
        TableUnique = $TableUniqueSQL,
        GridCalculation = $GridCalculation,
        BCODE = ". quote($BCODE,) .",
        GridImportSPName = ". quote($GridImportSPName) .",
        AfterGridAddCursorPosition = ". quote($AfterGridAddCursorPosition) .",
        OrderBy = ". quote($OrderBy) .",
        MinRowsRequired = $MinRowsRequired,
        RowwiseBarcodeUniqueID = ". quote($RowwiseBarcodeUniqueID) ."
    WHERE GridId = $GridID
    ";

    $update = $db->db_update($query);
}

if($saveType == 'gridfields'){
    $GridID = isset($_POST['gridID']) ? $_POST['gridID'] : 0;
    $GridFieldId = isset($_POST['GridFieldId']) ? $_POST['GridFieldId'] : 0;
    $DbFieldName = isset($_POST['DbFieldName']) ? $_POST['DbFieldName'] : '';
    $FieldType = isset($_POST['FieldType']) ? $_POST['FieldType'] : '';
    $DisplayName = isset($_POST['DisplayName']) ? $_POST['DisplayName'] : '';
    $CellMinWidth = isset($_POST['CellMinWidth']) ? $_POST['CellMinWidth'] : 0;
    $FieldOtherConditions = isset($_POST['FieldOtherConditions']) ? $_POST['FieldOtherConditions'] : '';
    $Required = isset($_POST['Required']) ? $_POST['Required'] : 0;
    $OtherAttributes = isset($_POST['OtherAttributes']) ? $_POST['OtherAttributes'] : '';
    $ValueFromDb = isset($_POST['ValueFromDb']) ? $_POST['ValueFromDb'] : '';
    $TableFromDb = isset($_POST['TableFromDb']) ? $_POST['TableFromDb'] : '';
    $TablePrimary = isset($_POST['TablePrimary']) ? $_POST['TablePrimary'] : '';
    $TableLabel = isset($_POST['TableLabel']) ? $_POST['TableLabel'] : '';
    $TableCondition = isset($_POST['TableCondition']) ? $_POST['TableCondition'] : '';
    $DisplayOrder = isset($_POST['DisplayOrder']) ? $_POST['DisplayOrder'] : 0;
    $ViewOrder = isset($_POST['ViewOrder']) ? $_POST['ViewOrder'] : 0;
    $ViewDisplayName = isset($_POST['ViewDisplayName']) ? $_POST['ViewDisplayName'] : '';
    $Onchange = isset($_POST['Onchange']) ? $_POST['Onchange'] : 0;
    $OnchangeParameters = isset($_POST['OnchangeParameters']) ? $_POST['OnchangeParameters'] : '';
    $Onkeyup = isset($_POST['Onkeyup']) ? $_POST['Onkeyup'] : 0;
    $OnkeyupParameters = isset($_POST['OnkeyupParameters']) ? $_POST['OnkeyupParameters'] : '';
    $GridCalculation = isset($_POST['GridCalculation']) ? $_POST['GridCalculation'] : 0;
    $AddMaster = isset($_POST['AddMaster']) ? $_POST['AddMaster'] : 0;
    $OnDropDownAjax = isset($_POST['OnDropDownAjax']) ? $_POST['OnDropDownAjax'] : '';
    $DDSearchMinimumInputLength = isset($_POST['DDSearchMinimumInputLength']) ? $_POST['DDSearchMinimumInputLength'] : 0;
    $CarryOn = isset($_POST['CarryOn']) ? $_POST['CarryOn'] : 0;
    $DefaultValue = isset($_POST['DefaultValue']) ? $_POST['DefaultValue'] : '';
    $isNotEditable = isset($_POST['isNotEditable']) ? $_POST['isNotEditable'] : 0;
    $RegExpression = isset($_POST['RegExpression']) ? $_POST['RegExpression'] : '';
    $OnKeyupEnter = isset($_POST['OnKeyupEnter']) ? $_POST['OnKeyupEnter'] : '';
    $TableMapTable = isset($_POST['TableMapTable']) ? $_POST['TableMapTable'] : '';
    $TableMapPrimary = isset($_POST['TableMapPrimary']) ? $_POST['TableMapPrimary'] : '';
    $TableMapOtherKey = isset($_POST['TableMapOtherKey']) ? $_POST['TableMapOtherKey'] : '';
    $OnLostFocusSp = isset($_POST['OnLostFocusSp']) ? $_POST['OnLostFocusSp'] : 0;
    $OnChangeSp = isset($_POST['OnChangeSp']) ? $_POST['OnChangeSp'] : 0;
    $ReadOnly = isset($_POST['ReadOnly']) ? $_POST['ReadOnly'] : 0;
    $TabIndex = isset($_POST['TabIndex']) ? $_POST['TabIndex'] : 0;
    $OnLostFocusCalculation = isset($_POST['OnLostFocusCalculation']) ? $_POST['OnLostFocusCalculation'] : '';
    $NotAllowCursorOnLostFocus = isset($_POST['NotAllowCursorOnLostFocus']) ? $_POST['NotAllowCursorOnLostFocus'] : 0;
    $Visibility = isset($_POST['Visibility']) ? $_POST['Visibility'] : 0;
    $SqlQueryOnInsert = isset($_POST['SqlQueryOnInsert']) ? $_POST['SqlQueryOnInsert'] : '';
    $DecimalPlaces = isset($_POST['DecimalPlaces']) ? $_POST['DecimalPlaces'] : 0;
    $DependentField = isset($_POST['DependentField']) ? $_POST['DependentField'] : '';
    $NonEditableFields = isset($_POST['NonEditableFields']) ? $_POST['NonEditableFields'] : '';
    $ClickableInput = isset($_POST['ClickableInput']) ? $_POST['ClickableInput'] : 0;



    $TableFromDbSQL = ($TableFromDb === '' || $TableFromDb === null) ? "''" : quote($TableFromDb);
    $TablePrimarySQL = ($TablePrimary === '' || $TablePrimary === null) ? "''" : quote($TablePrimary);
    $TableLabelSQL = ($TableLabel === '' || $TableLabel === null) ? "''" : quote($TableLabel);
    $TableConditionSQL = ($TableCondition === '' || $TableCondition === null) ? "''" : quote($TableCondition);

    $query = "UPDATE kgridfields SET
        DbFieldName = ".quote($DbFieldName).",
        FieldType = ".quote($FieldType).",
        DisplayName = ".quote($DisplayName).",
        CellMinWidth = $CellMinWidth,
        FieldOtherConditions =  ". quote($FieldOtherConditions) .",
        Required = $Required,
        OtherAttributes = ". quote($OtherAttributes) .",
        ValueFromDb = ". quote($ValueFromDb,) .",
        TableFromDb = $TableFromDbSQL,
        TablePrimary = $TablePrimarySQL,
        TableLabel = $TableLabelSQL,
        TableCondition = $TableConditionSQL,
        DisplayOrder = $DisplayOrder,
        ViewOrder = $ViewOrder,
        ViewDisplayName = ".quote($ViewDisplayName).",
        Onchange = $Onchange,
        OnchangeParameters = ". quote($OnchangeParameters) .",
        Onkeyup =  $Onkeyup,
        OnkeyupParameters = ". quote($OnkeyupParameters) .",
        GridCalculation = $GridCalculation,
        AddMaster = $AddMaster,
        OnDropDownAjax = ". quote($OnDropDownAjax) .",
        DDSearchMinimumInputLength = $DDSearchMinimumInputLength,
        CarryOn = $CarryOn,
        DefaultValue = ". quote($DefaultValue) .",
        isNotEditable = $isNotEditable,
        RegExpression = ". quote($RegExpression) .",
        OnKeyupEnter = ". quote($OnKeyupEnter) .",
        TableMapTable = ".quote($TableMapTable).",
        TableMapPrimary = ". quote($TableMapPrimary) .",
        TableMapOtherKey = ". quote($TableMapOtherKey) .",
        OnLostFocusSp =  $OnLostFocusSp,
        OnChangeSp = $OnChangeSp,
        ReadOnly = $ReadOnly,
        TabIndex = $TabIndex,
        OnLostFocusCalculation = ". quote($OnLostFocusCalculation) .",
        NotAllowCursorOnLostFocus = $NotAllowCursorOnLostFocus,
        Visibility = $Visibility,
        SqlQueryOnInsert = ". quote($SqlQueryOnInsert) .",
        DecimalPlaces = $DecimalPlaces,
        DependentField = ". quote($DependentField) .",
        NonEditableFields = ".quote($NonEditableFields) .",
        ClickableInput = $ClickableInput
    WHERE GridFieldId = $GridFieldId
    ";
    // exit();
    $update = $db->db_update($query);
}

echo json_encode([
    "success" => $update ? true : false
]);
?>

<?php

require_once ('dbClass.php');
session_start();

$SourceFormID = isset($_POST['SourceFormId']) ? $_POST['SourceFormId'] : '0';
$DestinationFormID = isset($_POST['NewFormId']) ? $_POST['NewFormId'] : '0';
$ModalType = isset($_POST['ModalType']) ? $_POST['ModalType'] : '';
$SelectedMainIdsJson = isset($_POST['SelectedMainIdsJson']) ? $_POST['SelectedMainIdsJson'] : '';
$CreatedBy = isset($_POST['CreatedBy']) ? $_POST['CreatedBy'] : '0'; 
$dbCompany = $_SESSION['dbCompany'] ?? 0;
$dbDivision = $_SESSION['dbDivision'] ?? 0;
$dbYear = $_SESSION['dbYear'] ?? 0;
$dryRun = isset($_POST['dryRun']) ? (string)$_POST['dryRun'] : 0;
// $dryRun = isset($_POST['dryRun']) && (string)$_POST['dryRun'] === '1';

function restoreMainDbSession($dbCompany, $dbDivision, $dbYear) {
    $getCurrentUserCredentials = "
        SELECT DISTINCT CompanyID, Sql_User_Id, Database_name, Decrypted_Password, Ip, Port
        FROM Aireg
        WHERE CompanyID = $dbCompany AND DivisionID = '$dbDivision' AND Year = '$dbYear'
    ";
    addSqlToBundle($getCurrentUserCredentials, ['action' => 'GET_DB_CREDENTIALS', 'object' => 'Aireg', 'company' => 'Main']);
    $currentUserCredential = db::getInstanceMaster()->db_select($getCurrentUserCredentials);

    if (empty($currentUserCredential['result_set'])) {
        throw new Exception("No current user credentials found for CompanyID: $dbCompany");
    }

    $_SESSION['dbHost'] = $currentUserCredential['result_set'][0]['Ip'] . ',' . $currentUserCredential['result_set'][0]['Port'];
    $_SESSION['dbUser'] = $currentUserCredential['result_set'][0]['Sql_User_Id'];
    $_SESSION['dbPass'] = $currentUserCredential['result_set'][0]['Decrypted_Password'];
    $_SESSION['dbName'] = $currentUserCredential['result_set'][0]['Database_name'];
}

function addUniqueByType($tableName) {
    // use globals for your arrays
    global $SourceFormTables, $SourceFormViews;

    if (empty($tableName)) {
        return;
    }

    $checkTableType = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '".$tableName."' AND TABLE_SCHEMA = 'dbo'";
    addSqlToBundle($checkTableType, ['action' => 'CHECK_TABLE', 'object' => 'kmainfields', 'company' => 'Main']);
    $checkTableTypeResult = db::getInstance()->db_select($checkTableType);

    if (!empty($checkTableTypeResult['result_set'])) {
        $tableType = $checkTableTypeResult['result_set'][0]['TABLE_TYPE'];

        if ($tableType === "BASE TABLE") {
            // check uniqueness before pushing
            if (!in_array($tableName, $SourceFormTables, true)) {
                $SourceFormTables[] = $tableName;
            }
        } else { // VIEW
            if (!in_array($tableName, $SourceFormViews, true)) {
                $SourceFormViews[] = $tableName;
            }
        }
    }
}

function getValueFromKey($str, $key) {
    $pattern = "/$key\{(.*?)\}/";  // non-greedy match
    if (preg_match($pattern, $str, $matches)) {
        // Clean the value → remove anything in parentheses and after
        $cleanValue = preg_replace('/\(.*$/', '', $matches[1]);
        return trim($cleanValue);
    }
    return null;
}

function addCloneLog($logID, $actionType, $objectName, $ddl, $companyID) {
    $mapLogSQL = "INSERT INTO mapFormCloningLogs (LogID, ActionType, ObjectName, SqlScript, CreatedOn, DestinationCompanyID)
        VALUES ($logID,'".addslashes($actionType)."','".addslashes($objectName)."',".($ddl ? "'".addslashes($ddl)."'" : "NULL").", GETDATE(), $companyID)";
    $mapLogSQLResult=db::getInstanceMaster()->db_insertQuery($mapLogSQL);
    // print_r($mapLogSQLResult);
}

function getCloneDbSession($destCompany){
    //Fetch source company credentials
    $getUserCredentials = "select DISTINCT CompanyID, Sql_User_Id, Database_name, Decrypted_Password, Ip, Port from Aireg where CompanyID=$destCompany";
    addSqlToBundle($getUserCredentials, ['action' => 'SELECT_TABLE', 'object' => 'Aireg', 'company' => $destCompany]);
    $userCredential = db::getInstanceMaster()->db_select($getUserCredentials);

    if (empty($userCredential['result_set'])) {
        throw new Exception("No cloning credentials found for CompanyID: $destCompany");
    }

    $_SESSION['clone_dbHost'] = trim($userCredential['result_set'][0]['Ip']).','.trim($userCredential['result_set'][0]['Port']);
    $_SESSION['clone_dbUser'] = trim($userCredential['result_set'][0]['Sql_User_Id']);
    $_SESSION['clone_dbPass'] = trim($userCredential['result_set'][0]['Decrypted_Password']);
    $_SESSION['clone_dbName'] = trim($userCredential['result_set'][0]['Database_name']);
    

    // after setting $_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], etc.
    db::resetCloningInstance(); // clear the old singleton
    $cloneDb = db::getInstanceCloning(); // reconnect with new session var

    $dbNameCheck = db::getInstanceCloning()->db_select("SELECT DB_NAME() AS DbName");
    addCloneLog($logID, "DEBUG_DB", $SourceFormTables[$j], "Currently connected to: ".$dbNameCheck['result_set'][0]['DbName'], $destCompany);
}

/** DRY-RUN: Keep a bundle of SQL to download */
if (!isset($_SESSION['clone_sql'])) {
    $_SESSION['clone_sql'] = [];
}
function addSqlToBundle($sql, $meta = []) {
    if (!is_string($sql) || trim($sql) === '') return;
    $_SESSION['clone_sql'][] = [
        'sql'  => rtrim($sql, " \t\n\r;") . ";",
        'meta' => $meta,
        'ts'   => date('Y-m-d H:i:s')
    ];
}
function addSection($title) {
    $_SESSION['clone_sql'][] = [
        'sql'  => "-- ===================== {$title} =====================",
        'meta' => ['section' => $title],
        'ts'   => date('Y-m-d H:i:s')
    ];
}

try {
    if($ModalType == 'formFields'){
        $logSQL = "INSERT INTO formCloningLogs (SourceFormID, DestinationFormID, SourceCompanyID, CreatedOn, CreatedBy, SourceType)
                VALUES ( $SourceFormID, $DestinationFormID, $dbCompany, GETDATE(),'".$_SESSION['user_id']."', 'formclone')";
        $logSqlResult = db::getInstanceMaster()->db_insertQuery($logSQL);
        $logID = $logSqlResult['last_id'];

        $data['name'] = 'formCloning1';
        $data['params'] = ['@SourceFormId','@NewFormId','@SelectedMainIdsJson','@CreatedBy','@logID'];
        $data['values'] = ["'$SourceFormID'","'$DestinationFormID'","'$SelectedMainIdsJson'","'$CreatedBy'","'$logID'"];

        $result = db::getInstanceMaster()->db_sp_select($data['name'], $data['params'], $data['values']); 
        // print_r($result);
        if($result['error'] == 1){
            echo json_encode([
                "success" => false,
                "message" => $result['error_statement'],
                "logID" => $logID
            ]);
        }else{
            echo json_encode([
                "success" => true,
                "message" => "Form cloned successfully!",
                "logID" => $logID
            ]);
        }
    }else if($ModalType == 'dataStructure'){
        $SourceCompany = isset($_POST['SourceCompany']) ? $_POST['SourceCompany'] : '0';
        $DestinationCompany = isset($_POST['DestinationCompany']) ? $_POST['DestinationCompany'] : [];
        $logID = isset($_POST['logID']) ? (int)$_POST['logID'] : 0;
        $isSelectAllTables = isset($_POST['isSelectAllTables']) ? $_POST['isSelectAllTables'] : 0;
        $isSelectAllViews = isset($_POST['isSelectAllViews']) ? $_POST['isSelectAllViews'] : 0;

        
        if($DestinationCompany){
            $DestinationCompany = json_decode($DestinationCompany, true);
        }

        if (!$dryRun) {
            if($logID == 0){
                // Add record in log table
                $logSQL = "INSERT INTO formCloningLogs (SourceFormID, DestinationFormID, SourceCompanyID, CreatedOn, CreatedBy, SourceType)
                        VALUES ( $SourceFormID, $DestinationFormID, $SourceCompany, GETDATE(),'".$_SESSION['user_id']."', 'formclone')";
                $logSqlResult = db::getInstanceMaster()->db_insertQuery($logSQL);
                $logID = $logSqlResult['last_id'];
            }
        }


        $getCompanyName = "SELECT * FROM Aicompany WHERE ID=$SourceCompany";
        $getCompanyNameResult = db::getInstanceMaster()->db_select($getCompanyName);

        // Initialize bundle for this run
        $_SESSION['clone_sql'] = [];
        addSection("FORM CLONING ".($dryRun ? "DRY-RUN" : "EXECUTION"));
        addSqlToBundle("-- SourceForm: {$SourceFormID}  DestinationForm: {$DestinationFormID}");
        addSqlToBundle("-- SourceCompany: {$getCompanyNameResult['result_set'][0]['Label']}  DestCompanies: ".json_encode($DestinationCompany));
        addSqlToBundle("-- Flags: Tables={$isSelectAllTables} Views={$isSelectAllViews}");


        // Table & view Validation 
        $query = "SELECT TableName,ListViewDBName FROM kmainforms where FormID=$SourceFormID";
        addSqlToBundle($query, ['action' => 'SELECT_TABLE', 'object' => 'kmainforms', 'company' => 'Main']);
        $result = db::getInstanceMaster()->db_select($query);

        $SourceFormTables = [];
        $SourceFormViews = [];

        addUniqueByType($result['result_set'][0]['TableName']);
        // $SourceFormView[] = $result['result_set'][0]['TableName'];

        if($result['result_set'][0]['ListViewDBName']){
            addUniqueByType($result['result_set'][0]['ListViewDBName']);
            // $SourceFormView[] = $result['result_set'][0]['ListViewDBName'];
        }

        $query2 = "SELECT FieldType,TableFromDB,TableMapTable, FieldOtherConditions, GridId FROM kmainfields where FormId=$SourceFormID";
        addSqlToBundle($query2, ['action' => 'SELECT_TABLE', 'object' => 'kmainfields', 'company' => 'Main']);
        $result2 = db::getInstanceMaster()->db_select($query2);
        
        $formFields = $result2['result_set'];
        

        for($i=0; $i<count($formFields); $i++){
            if($formFields[$i]['FieldType'] == 5){
                // echo $formFields[$i]['TableFromDB'];
                addUniqueByType($formFields[$i]['TableFromDB']);
                // addUnique($SourceFormView, $formFields[$i]['TableFromDB']);
            }else if($formFields[$i]['FieldType'] == 16 || $formFields[$i]['FieldType'] == 17){
                addUniqueByType($formFields[$i]['TableFromDB']);
                // addUnique($SourceFormView, $formFields[$i]['TableFromDB']);

                if($formFields[$i]['FieldOtherConditions']){
                    $fieldOtherConditionString = $formFields[$i]['FieldOtherConditions'];

                    $dbValue = getValueFromKey($fieldOtherConditionString, "DB");
                    addUniqueByType($dbValue);
                    // addUnique($SourceFormView, $dbValue);

                    $populateDbValue = getValueFromKey($fieldOtherConditionString, "PopulateDB");
                    addUniqueByType($populateDbValue);
                    // addUnique($SourceFormView, $populateDbValue);
                }

                // If field type 16 add TableMapTable in SourceFromView array
                if($formFields[$i]['TableMapTable']){
                    addUniqueByType($formFields[$i]['TableMapTable']);
                    // addUnique($SourceFormView, $formFields[$i]['TableMapTable']);
                }
                
            }else if($formFields[$i]['FieldType'] == 14){
                $getKmainGrid = "SELECT TableName FROM kmaingrid WHERE GridId=".$formFields[$i]['GridId'];
                $getKmainGridTable = db::getInstanceMaster()->db_select($getKmainGrid);
                addUniqueByType($getKmainGridTable['result_set'][0]['TableName']);
                // addUnique($SourceFormView, $getKmainGridTable['result_set'][0]['TableName']);

                // Get kgridfields table
                $query3 = "SELECT FieldType,TableFromDB,TableMapTable, FieldOtherConditions, GridId FROM kgridfields where GridId=".$formFields[$i]['GridId'];
                $result3 = db::getInstanceMaster()->db_select($query3);
                $gridFields = $result3['result_set'];
                
                for($j=0; $j<count($gridFields); $j++){
                    if($gridFields[$j]['FieldType'] == 5){
                        addUniqueByType($gridFields[$j]['TableFromDB']);
                        // addUnique($SourceFormView,  $gridFields[$j]['TableFromDB']);

                    }else if($gridFields[$j]['FieldType'] == 16 || $gridFields[$j]['FieldType'] == 17){
                        addUniqueByType($gridFields[$j]['TableFromDB']);
                        // addUnique($SourceFormView,  $gridFields[$j]['TableFromDB']);

                        if($gridFields[$j]['FieldOtherConditions']){

                            $dbValue1 = getValueFromKey($gridFields[$j]['FieldOtherConditions'], "DB");
                            addUniqueByType($dbValue1);
                            // addUnique($SourceFormView,  $dbValue1);
                        
                            $populateDbValue1 = getValueFromKey($gridFields[$j]['FieldOtherConditions'], "PopulateDB");
                            addUniqueByType($populateDbValue1);
                            // addUnique($SourceFormView,  $populateDbValue1);
                        }

                        // If field type 16 add TableMapTable in SourceFromView array
                        if($gridFields[$j]['TableMapTable']){
                            addUniqueByType($gridFields[$j]['TableMapTable']);
                            // addUnique($SourceFormView,  $gridFields[$j]['TableMapTable']);
                        } 
                    }
                }
            }
        }

        for($k=0; $k < count($DestinationCompany); $k++){
            

            //If Select All Tables checked
            if($isSelectAllTables && count($SourceFormTables) > 0){

                addSection("TABLES");

                for($j=0; $j<count($SourceFormTables); $j++){
                    $query1 = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '".$SourceFormTables[$j]."' AND TABLE_SCHEMA = 'dbo'";
                    addSqlToBundle($checkQuery, ['action' => 'CHECK_TABLE_EXIST', 'object' => $SourceFormTables[$j], 'company' => 'Main']);
                    $result1 = db::getInstance()->db_select($query1);
                    
                    if($result1['num_rows'] == 0){
                        if(!$dryRun){
                            // --- Table not found → CREATE ---
                            addCloneLog($logID, "TABLE_NOT_FOUND", $SourceFormTables[$j], "`$SourceFormTables[$j]`: Table does not exist in destination company.", $DestinationCompany[$k]);
                        }
                        
                        getCloneDbSession($DestinationCompany[$k]);
                        
                        // $dbNameCheck = db::getInstanceCloning()->db_select("SELECT DB_NAME() AS DbName");
                        // addCloneLog($logID, "DEBUG_DB", $SourceFormTables[$j], "Currently connected to: ".$dbNameCheck['result_set'][0]['DbName']);

                        // check is table or view
                        $checkQuery = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '".$SourceFormTables[$j]."' AND TABLE_SCHEMA = 'dbo'";
                        addSqlToBundle($checkQuery, ['action' => 'CHECK_TABLE_EXIST', 'object' => $SourceFormTables[$j], 'company' => 'Main']);
                        $checkQueryResult = db::getInstanceCloning()->db_select($checkQuery);

                        if (empty($checkQueryResult['result_set'])) {
                            if (!$dryRun) {
                                addCloneLog($logID,"TABLE_NOT_FOUND", $SourceFormTables[$j], "{$SourceFormTables[$j]}: Table OR View does not exists in source company => skipped ", $DestinationCompany[$k]);
                            }

                        }else{
                            echo "hi";
                            // Step 1: Get columns with datatype, identity, nullability
                            $colQuery = "
                                SELECT 
                                    c.name AS ColumnName,
                                    t.name AS DataType,
                                    c.max_length AS MaxLength,
                                    c.precision,
                                    c.scale,
                                    c.is_nullable,
                                    c.is_identity,
                                    ic.seed_value,
                                    ic.increment_value
                                FROM sys.columns c
                                JOIN sys.types t ON c.user_type_id = t.user_type_id
                                LEFT JOIN sys.identity_columns ic 
                                    ON c.object_id = ic.object_id AND c.column_id = ic.column_id
                                WHERE c.object_id = OBJECT_ID('$SourceFormTables[$j]')
                                ORDER BY c.column_id;
                            ";
                            addSqlToBundle($colQuery, ['action' => 'GET_TABLE_STRUCTURE', 'object' => $SourceFormTables[$j], 'company' => $DestinationCompany[$k]]);
                            $cols = db::getInstanceCloning()->db_select($colQuery);

                            if (empty($cols['result_set'])) {
                                if (!$dryRun) {
                                    addCloneLog($logID,"TABLE_COLUMNS_NOT_FOUND", $SourceFormTables[$j], "{$SourceFormTables[$j]} : Columns does not exist.",$DestinationCompany[$k]);
                                }
                            }else{
                                // Step 2: Get primary key columns
                                $pkQuery = "
                                    SELECT 
                                        c.name AS ColumnName
                                    FROM sys.indexes i
                                    JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
                                    JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
                                    WHERE i.is_primary_key = 1 AND i.object_id = OBJECT_ID('$SourceFormTables[$j]')
                                    ORDER BY ic.key_ordinal;
                                ";
                                addSqlToBundle($pkQuery, ['action' => 'GET_TABLE_PRIMARYKEY', 'object' => $SourceFormTables[$j], 'company' => $DestinationCompany[$k]]);
                                $pks = db::getInstanceCloning()->db_select($pkQuery);

                                if (empty($pks['result_set'])) {
                                    if (!$dryRun) {
                                        addCloneLog($logID, "TABLE_PK_NOT_FOUND", $SourceFormTables[$j], "{$SourceFormTables[$j]} : PrimaryKey not exist.",$DestinationCompany[$k]);
                                    }
                                }else{
                                    $primaryKeys = [];
                                    foreach ($pks['result_set'] as $pk) {
                                        $primaryKeys[] = "[".$pk['ColumnName']."]";
                                    }

                                    // Step 3: Build CREATE TABLE script
                                    $columns = [];
                                    foreach ($cols['result_set'] as $col) {
                                        $line = "[".$col['ColumnName']."] ".strtoupper($col['DataType']);

                                        // Handle length-based types
                                        if (in_array(strtolower($col['DataType']), ['varchar','nvarchar','char','nchar','binary','varbinary'])) {
                                            if ($col['MaxLength'] == -1) {
                                                $line .= "(MAX)";
                                            } else {
                                                $line .= "(" . ($col['MaxLength'] > 0 ? $col['MaxLength'] : 1) . ")";
                                            }
                                        } elseif (in_array(strtolower($col['DataType']), ['decimal','numeric'])) {
                                            $line .= "(".$col['precision'].",".$col['scale'].")";
                                        }

                                        // Identity
                                        if ($col['is_identity'] == 1) {
                                            $line .= " IDENTITY(".$col['seed_value'].",".$col['increment_value'].")";
                                        }

                                        // Nullability
                                        $line .= ($col['is_nullable'] == 1 ? " NULL" : " NOT NULL");

                                        $columns[] = $line;
                                    }

                                    // Add primary key constraint
                                    if (!empty($primaryKeys)) {
                                        $columns[] = "CONSTRAINT [PK_$SourceFormTables[$j]] PRIMARY KEY (".implode(", ", $primaryKeys).")";
                                    }

                                    //Unset cloing session
                                    unset($_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], $_SESSION['clone_dbPass'], $_SESSION['clone_dbName']);

                                    
                                    // ✅ Restore main DB session after successful clone
                                    restoreMainDbSession($dbCompany, $dbDivision, $dbYear);

                                    // addCloneLog("SESSION_RESTORED", $SourceFormTables[$j], "Reset destination db session.", $SourceFormID, $DestinationFormID,$SourceCompany, $DestinationCompany[$k] );

                                    $ddl = "CREATE TABLE [$SourceFormTables[$j]] (" . implode(", ", $columns) . ");";
                                    addSqlToBundle($ddl, ['action' => 'CREATE_TABLE', 'object' => $SourceFormTables[$j], 'company' => $DestinationCompany[$k]]);

                                    if (!$dryRun) {
                                        // Step 4: Execute CREATE TABLE in current DB
                                        $result = db::getInstance()->db_create_table($ddl);
                                        // Log table creation
                                        addCloneLog($logID, "CREATE_TABLE", $SourceFormTables[$j], $ddl, $DestinationCompany[$k]);
                                    } 
                                }
                            }    
                        }

                    }else{

                        getCloneDbSession($DestinationCompany[$k]);
                        // $dbNameCheck = db::getInstanceCloning()->db_select("SELECT DB_NAME() AS DbName");
                        // addCloneLog($logID, "DEBUG_DB", $SourceFormTables[$j], "Currently connected to: ".$dbNameCheck['result_set'][0]['DbName']);


                        // check is table or view
                        $checkQuery = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '".$SourceFormTables[$j]."' AND TABLE_SCHEMA = 'dbo'";
                        addSqlToBundle($checkQuery, ['action' => 'SELECT_TABLE', 'object' => $SourceFormTables[$j], 'company' => $DestinationCompany[$k]]);
                        $checkQueryResult = db::getInstanceCloning()->db_select($checkQuery);
                       
                        if(empty($checkQueryResult['result_set'])){
                            if(!$dryRun){
                                addCloneLog($logID, "TABLE_NOT_FOUND", $SourceFormTables[$j], "{$SourceFormTables[$j]}: Table OR View not exist in source company => Skipped ",$DestinationCompany[$k]);
                            }
                        }else{
                            // Step 2: Get source structure
                            $query1 = "select * from information_schema.columns WHERE table_name='".$SourceFormTables[$j]."'";
                            addSqlToBundle($query1, ['action' => 'SELECT_TABLE', 'object' => $SourceFormTables[$j], 'company' => $DestinationCompany[$k]]);
                            $sourceTableStructure = db::getInstanceCloning()->db_select($query1);
                         
                            if(empty($sourceTableStructure['result_set'])){
                                if(!$dryRun){
                                    addCloneLog($logID, "TABLE_COLUMNS_NOT_FOUND", $SourceFormTables[$j], "{$SourceFormTables[$j]} : Columns does not exist.",$DestinationCompany[$k]);
                                }
                            }else{
                                //Unset cloing session
                                unset($_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], $_SESSION['clone_dbPass'], $_SESSION['clone_dbName']);

                                // ✅ Restore main DB session after successful clone
                                restoreMainDbSession($dbCompany, $dbDivision, $dbYear);

                                // addCloneLog("RESTORE_SESSION", $SourceFormTables[$j], "Restore source db session", $SourceFormID, $DestinationFormID,$SourceCompany, $DestinationCompany[$k] );

                                $query1 = "select * from information_schema.columns WHERE table_name='".$result['result_set'][0]['TableName']."'";
                                addSqlToBundle($query1, ['action' => 'SELECT_TABLE', 'object' => $result['result_set'][0]['TableName'], 'company' => 'Main']);
                                // Step 2: Get destination structure
                                $destinationTableStructure = db::getInstance()->db_select($query1);
                                
                                if(empty($sourceTableStructure['result_set'])){
                                    if(!$dryRun){
                                        addCloneLog($logID, "TABLE_COLUMNS_NOT_FOUND", $SourceFormTables[$j], "{$SourceFormTables[$j]} : Destination table columns does not exist.",$DestinationCompany[$k] );
                                    }
                                }else{

                                    // Convert to arrays for easy comparison
                                    $sourceCols = array_column($sourceTableStructure['result_set'], null, 'COLUMN_NAME');
                                    $destCols   = array_column($destinationTableStructure['result_set'], null, 'COLUMN_NAME');
                                    $allMatch = true; // Flag to track if everything is equal

                                    // Step 3: Compare and add missing columns
                                    foreach ($sourceCols as $colName => $colDef) {
                                    
                                        if (!isset($destCols[$colName])) {
                                            // Build ALTER TABLE query
                                            $nullable = ($colDef['IS_NULLABLE'] === "YES") ? "NULL" : "NOT NULL";
                                            $default  = ($colDef['COLUMN_DEFAULT'] !== null) ? "DEFAULT '" . $colDef['COLUMN_DEFAULT'] . "'" : "";
                                            
                                            $alterSQL = "ALTER TABLE $SourceFormTables[$j] ADD $colName " . $colDef['DATA_TYPE'] . " " . $nullable . " " . $default . " " . $colDef['EXTRA'];
                                            addSqlToBundle($alterSQL, ['action' => 'ALTER_TABLE', 'object' => $SourceFormTables[$j], 'company' => $_SESSION['dbCompany']]);

                                            if(!$dryRun){
                                                // Execute alter statement
                                                $alterQueryResult = db::getInstance()->db_update($alterSQL);
                                                if($alterQueryResult['error'] == 0){
                                                    $allMatch = false;
                                                    addCloneLog($logID, "MISSIÄNG_COLUMN", $SourceFormTables[$j], "{$SourceFormTables[$j]} Table {$colName} column is missing.",$DestinationCompany[$k] );
                                                    addCloneLog($logID, "ADD_COLUMN", $SourceFormTables[$j], $alterSQL, $DestinationCompany[$k]);
                                                }
                                            }
                                        }
                                    }

                                    // After loop → if all columns matched, log once
                                    if ($allMatch) {
                                        if(!$dryRun){
                                            addCloneLog($logID,"ALREADY_EXISTS", $SourceFormTables[$j],"{$SourceFormTables[$j]} Table already exist => Skipped", $DestinationCompany[$k]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            //If Select All Views checked
            if($isSelectAllViews && count($SourceFormViews) > 0){

                addSection("VIEWS");

                for($j=0; $j<count($SourceFormViews); $j++){
                    $query1 = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '".$SourceFormViews[$j]."' AND TABLE_SCHEMA = 'dbo'";
                    addSqlToBundle($query1, ['action' => 'SELECT_TABLE', 'object' => $SourceFormTables[$j], 'company' => $_SESSION['dbCompany']]);
                    $result1 = db::getInstance()->db_select($query1);

                    if($result1['num_rows'] == 0){
                        if(!$dryRun){
                            // --- Table not found → CREATE ---
                            addCloneLog($logID, "VIEW_NOT_FOUND", $SourceFormViews[$j], "`$SourceFormViews[$j]`: Table does not exist in destination company.");
                        }

                        getCloneDbSession($DestinationCompany[$k]);

                        // Get view definition from source DB
                        $viewQuery = "
                            SELECT sm.definition
                            FROM sys.sql_modules sm
                            JOIN sys.objects o ON sm.object_id = o.object_id
                            WHERE o.object_id = OBJECT_ID('dbo.$SourceFormViews[$j]')
                        ";
                        addSqlToBundle($viewQuery, ['action' => 'CHECK_VIEW_DEFINATION', 'object' => $SourceFormViews[$j], 'company' => $DestinationCompany[$k]]);
                        $viewDef = db::getInstanceCloning()->db_select($viewQuery);

                        if (empty($viewDef['result_set'])) {
                            if(!$dryRun){
                                addCloneLog($logID, "VIEW_NOT_FOUND", $SourceFormViews[$j], "{$SourceFormViews[$j]}: View defination does not exist in source database.",$DestinationCompany[$k]);
                            }
                            // throw new Exception("No definition found for view: $SourceFormView[$j]");
                        }else{
                            $ddl = $viewDef['result_set'][0]['definition'];
    
                            // Unset clone session and restore main DB
                            unset($_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], $_SESSION['clone_dbPass'], $_SESSION['clone_dbName']);
                            restoreMainDbSession($dbCompany, $dbDivision, $dbYear);
    
                            if(!$dryRun){
                                addCloneLog($logID, "SESSION_RESTORED", $SourceFormViews[$j], "Restore source db session.", $DestinationCompany[$k]);
                                $result = db::getInstance()->db_update($ddl);
                                addCloneLog($logID, "CREATE_VIEW", $SourceFormViews[$j], $ddl,$DestinationCompany[$k]);
                            }
                        } 
                    }else{

                        getCloneDbSession($DestinationCompany[$k]);

                        // check is table or view
                        $checkQuery = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '".$SourceFormViews[$j]."' AND TABLE_SCHEMA = 'dbo'";
                        addSqlToBundle($checkQuery, ['action' => 'CHECK_VIEW_EXIST', 'object' => $SourceFormTables[$j], 'company' => $DestinationCompany[$k]]);
                        $checkQueryResult = db::getInstanceCloning()->db_select($checkQuery);
                    
                        if(!$dryRun){
                            if(empty($checkQueryResult['result_set'])){
                                addCloneLog($logID, "VIEW_NOT_FOUND", $SourceFormViews[$j], "{$SourceFormViews[$j]}: Table OR View not exist in source company => Skipped ",$DestinationCompany[$k]);
                            }else{ 
                                addCloneLog($logID,"ALREADY_EXISTS", $SourceFormViews[$j],"{$SourceFormViews[$j]} already exists => Skipped",$DestinationCompany[$k]);  
                            }
                        }
                    }
                }
            }
   
        }

        $response = [
            "success" => true,
            "rows"    => [],
            "logs"    => []
        ];

        // Read SPs from SOURCE company
        // if ($SourceCompany > 0 && count($SelectedMainIdsJson) > 0) {
            // Sp Cloning in destination company
            $data['name'] = 'SPCloning2';
            $sourceQuery = "SELECT GridId, DbFieldName FROM kmainfields WHERE FormId = $SourceFormID AND FieldType = 14";
            addSqlToBundle($checkQuery, ['action' => 'SELECT_TABLE', 'object' => 'kmainfields', 'company' => 'Main']);
            $destinationQuery = "SELECT GridId, DbFieldName FROM kmainfields WHERE FormId = $DestinationFormID AND FieldType = 14";
            addSqlToBundle($checkQuery, ['action' => 'SELECT_TABLE', 'object' => 'kmainfields', 'company' => 'Main']);

            $sourceRows = db::getInstanceMaster()->db_select($sourceQuery)['result_set'];
            $destinationRows = db::getInstanceMaster()->db_select($destinationQuery)['result_set'];


            // Index destination by DbFieldName for quick lookup
            $destinationMap = [];
            foreach ($destinationRows as $row) {
                $destinationMap[strtolower($row['DbFieldName'])] = $row['GridId'];
            }

            // Build mapping dynamically
            $gridMap = [];
            foreach ($sourceRows as $src) {
                $dbFieldName = strtolower($src['DbFieldName']);
                if (isset($destinationMap[$dbFieldName])) {
                    $gridMap[] = [
                        "SourceGridId" => (int)$src['GridId'],
                        "DestinationGridId" => (int)$destinationMap[$dbFieldName]
                    ];
                }
            }

            $data['params'] = ['@sourceCompanyId','@companyids','@spname','@SourceFormId','@DestinationFormId','@GridMapJson','@LogId'];
            $data['values'] = ["'$SourceCompany'","'".json_encode($DestinationCompany)."'","'$SelectedMainIdsJson'","'$SourceFormID'","'$DestinationFormID'","'".json_encode($gridMap)."'","'$logID'"];

            $result = db::getInstanceMaster()->db_sp_select($data['name'], $data['params'], $data['values']); 

            // print_r($result);

            // Flatten the nested arrays to just get Messages
            if (isset($result['result_set']) && is_array($result['result_set'])) {
                foreach ($result['result_set'] as $set) {
                    if (is_array($set)) {
                        foreach ($set as $row) {
                            // lift only known columns; tolerate missing keys
                            $response['rows'][] = [
                                "Status"          => $row['Status']          ?? null,
                                "SourceProc"      => $row['SourceProc']      ?? null,
                                "TargetProc"      => $row['TargetProc']      ?? null,
                                "TargetDB"        => $row['TargetDB']        ?? null,
                                "TargetCompanyId" => $row['TargetCompanyId'] ?? null,
                                "ErrorNumber"     => $row['ErrorNumber']     ?? null,
                                "ErrorMessage"    => $row['ErrorMessage']    ?? null,
                            ];
                        }
                    }
                }
            }

        // }

        $DestinationCompanyIds = implode(",", $DestinationCompany);

        $logs = "SELECT b.*,c.Label AS SourceCompany, d.Label AS DestinationCompany, e.Name AS CreatedBy FROM formCloningLogs a 
                LEFT JOIN mapFormCloningLogs b ON a.id=b.LogID 
                LEFT JOIN AiCompany c ON c.ID = a.SourceCompanyID
                LEFT JOIN AiCompany d ON d.ID = b.DestinationCompanyID
                LEFT JOIN users e ON e.ID = a.CreatedBy
                WHERE a.SourceFormID = $SourceFormID AND a.DestinationFormID = $DestinationFormID AND a.SourceCompanyID = $SourceCompany AND a.CreatedBy = $CreatedBy AND a.SourceType='formclone'";
        addSqlToBundle($logs, ['action' => 'SELECT_TABLE', 'object' => 'formCloningLogs', 'company' => 'Main']);
        $logResult = db::getInstanceMaster()->db_select($logs); 

        if (isset($logResult['result_set']) && is_array($logResult['result_set'])) {
            foreach ($logResult['result_set'] as $row) {
                $response['logs'][] = [
                    "Action"          => $row['ActionType'] ?? null,
                    "ObjectName"      => $row['ObjectName'] ?? null,
                    "Desccription"    => $row['SqlScript'] ?? null,
                    "SourceCompany"   => $row['SourceCompany'] ?? null,
                    "DestinationCompany" => $row['DestinationCompany'] ?? null,
                    "CreatedOn"       =>isset($row['CreatedOn']) 
                                        ? ($row['CreatedOn'] instanceof DateTime 
                                            ? $row['CreatedOn']->format('Y-m-d H:i:s') 
                                            : $row['CreatedOn']) 
                                        : null,
                    "CreatedBy"       => $row['CreatedBy'] ?? null,
                ];
            }
        }

        echo json_encode($response);
    
       
    }
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

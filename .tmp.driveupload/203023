<?php
require_once ('dbClass.php');
session_start();

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
$spValues = isset($_POST['sp']) ? $_POST['sp'] : [];
$companyValues = isset($_POST['company']) ? $_POST['company'] : [];
$CreatedBy = $_SESSION['user_id'] ?? 0;
$dbCompany = $_SESSION['dbCompany'] ?? 0;
$dbDivision = $_SESSION['dbDivision'] ?? 0;
$dbYear = $_SESSION['dbYear'] ?? 0;

$response = ['success' => false, 'message' => 'Unhandled failure'];

function restoreMainDbSession($dbCompany, $dbDivision, $dbYear) {
    $getCurrentUserCredentials = "
        SELECT DISTINCT CompanyID, Sql_User_Id, Database_name, Decrypted_Password, Ip, Port
        FROM Aireg
        WHERE CompanyID = $dbCompany AND DivisionID = '$dbDivision' AND Year = '$dbYear'
    ";
    $currentUserCredential = db::getInstanceMaster()->db_select($getCurrentUserCredentials);

    if (empty($currentUserCredential['result_set'])) {
        throw new Exception("No current user credentials found for CompanyID: $dbCompany");
    }

    $_SESSION['dbHost'] = $currentUserCredential['result_set'][0]['Ip'] . ',' . $currentUserCredential['result_set'][0]['Port'];
    $_SESSION['dbUser'] = $currentUserCredential['result_set'][0]['Sql_User_Id'];
    $_SESSION['dbPass'] = $currentUserCredential['result_set'][0]['Decrypted_Password'];
    $_SESSION['dbName'] = $currentUserCredential['result_set'][0]['Database_name'];
}

function addCloneLog($logID, $actionType, $objectName, $ddl, $companyID) {
    $ddlSafe = $ddl ? str_replace("'", "''", $ddl) : "NULL";
    $mapLogSQL = "INSERT INTO mapFormCloningLogs (LogID, ActionType, ObjectName, SqlScript, CreatedOn, DestinationCompanyID)
        VALUES ($logID,'".addslashes($actionType)."','".addslashes($objectName)."',".($ddl ? "'$ddlSafe'" : "NULL").", GETDATE(), $companyID)";
    $mapLogSQLResult=db::getInstanceMaster()->db_insertQuery($mapLogSQL);
}


try{
    //  db::getInstance()->db_query("BEGIN TRANSACTION"); // Start transaction
    
    $logSQL = "INSERT INTO formCloningLogs (SourceFormID, DestinationFormID, SourceCompanyID, CreatedOn, CreatedBy, SourceType)
                VALUES ($FormID, '0','". $dbCompany."', GETDATE(),'".$_SESSION['user_id']."', 'spclone')";
    $logSqlResult = db::getInstanceMaster()->db_insertQuery($logSQL);
    $logID = $logSqlResult['last_id'];

    foreach ($companyValues as $companyID) {
        

        foreach ($spValues as $spName) {

            // 1. Get Procedure Definition
            $defQuery = "SELECT OBJECT_DEFINITION(OBJECT_ID('$spName')) AS Definition";
            $defResult = db::getInstance()->db_select($defQuery);
            $definition = $defResult['result_set'][0]['Definition'] ?? '';

            if (!$definition) {
                addCloneLog($logID, "NOT_FOUND", $SourceFormView[$j], "`$spName`: No definition found.", $companyID);
                throw new Exception("No definition found for $spName");
            }

            // 2. Insert into DeveloperDataCloning
            $definitionEscaped = str_replace("'", "''", $definition); // escape for SQL insert
            $insertSQL = "
                INSERT INTO DeveloperDataCloning (
                    ObjectName, FormID, FromCompanyID, ToCompanyID,
                    DroppedObjectData, CreatedBy, CreatedAt
                )
                VALUES (
                    '$spName', $FormID, $dbCompany, $companyID,
                    '$definitionEscaped', '$CreatedBy', GETDATE()
                )
            ";
            db::getInstanceMaster()->db_insertQuery($insertSQL);

            if (!db::getInstanceMaster()->db_insertQuery($insertSQL)) {
                throw new Exception("Failed to insert into DeveloperDataCloning for $spName");
            }
            
            $getUserCredentials = "select DISTINCT CompanyID, Sql_User_Id, Database_name, Decrypted_Password, Ip, Port from Aireg where CompanyID=$companyID";
            $userCredential = db::getInstanceMaster()->db_select($getUserCredentials);

            if (empty($userCredential['result_set'])) {
                addCloneLog($logID, "NOT_FOUND", $companyID, "`$companyID`: No cloning credentials found.", $companyID);
                throw new Exception("No cloning credentials found for CompanyID: $companyID");
            }
           
            $_SESSION['clone_dbHost'] = trim($userCredential['result_set'][0]['Ip']).','.trim($userCredential['result_set'][0]['Port']);
            $_SESSION['clone_dbUser'] = trim($userCredential['result_set'][0]['Sql_User_Id']);
            $_SESSION['clone_dbPass'] = trim($userCredential['result_set'][0]['Decrypted_Password']);
            $_SESSION['clone_dbName'] = trim($userCredential['result_set'][0]['Database_name']);

            // echo "<br>".$_SESSION['clone_dbHost']." = ".$_SESSION['clone_dbUser']." = ". $_SESSION['clone_dbPass']." = " . $_SESSION['clone_dbName'];

            // 3. Drop Procedure
            // $dropSQL = "IF OBJECT_ID('$spName', 'P') IS NOT NULL DROP PROCEDURE $spName";
            // db::getInstanceCloning()->db_insertQuery($dropSQL);

            // if (!db::getInstanceCloning()->db_insertQuery($dropSQL)) {
            //     throw new Exception("Failed to drop procedure $spName");
            // }

            // // 4. Recreate Procedure
            // if (!db::getInstanceCloning()->db_create_procedure($definition)) {
            //     throw new Exception("Failed to recreate procedure $spName");
            // }

            // after setting $_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], etc.
            db::resetCloningInstance(); // clear the old singleton
            $cloneDb = db::getInstanceCloning(); // reconnect with new session vars

            $dbNameCheck = db::getInstanceCloning()->db_select("SELECT DB_NAME() AS DbName");
            addCloneLog($logID, "DEBUG_DB", $spName, "Currently connected to: ".$dbNameCheck['result_set'][0]['DbName'], $companyID);

            $checkSQL = "SELECT OBJECT_ID('$spName','P') AS ProcId";
            $existsResult = db::getInstanceCloning()->db_select($checkSQL);
            $exists = $existsResult['result_set'][0]['ProcId'] ?? null;

            if ($exists) {
                // 1. Get Destination Company Procedure Definition
                $defQueryDest = "SELECT OBJECT_DEFINITION(OBJECT_ID('$spName')) AS Definition";
                $defResultDest = db::getInstanceCloning()->db_select($defQueryDest);
                $definitionDest = $defResultDest['result_set'][0]['Definition'] ?? '';

                // Procedure exists → ALTER
                // $alterDefinition = preg_replace('/^\s*CREATE\s+PROCEDURE/i', 'ALTER PROCEDURE', $definition);
                $alterDefinition = preg_replace('/^\s*CREATE(\s+OR\s+ALTER)?\s+PROCEDURE/i', 'ALTER PROCEDURE', $definition);
                if (!db::getInstanceCloning()->db_create_procedure($alterDefinition)) {
                    addCloneLog($logID, "ALTER_SP", $spName, "`$spName`: Failed to ALTER procedure.", $companyID);
                    throw new Exception("Failed to ALTER procedure $spName");
                }else{
                    addCloneLog($logID, "ALTER_SP", $spName, $alterDefinition, $companyID);
                }
            } else {
                // Procedure does not exist → CREATE
                if (!db::getInstanceCloning()->db_create_procedure($definition)) {
                    addCloneLog($logID, "ERROR", $spName, "`$spName`: Failed to CREATE procedure.", $companyID);
                    throw new Exception("Failed to CREATE procedure $spName");
                }else{
                    addCloneLog($logID, "CREATE_SP", $spName, $definition, $companyID);
                }
            }

            

            //Unset cloing session
            unset($_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], $_SESSION['clone_dbPass'], $_SESSION['clone_dbName']);

            // ✅ Restore main DB session after successful clone
            restoreMainDbSession($dbCompany, $dbDivision, $dbYear);
        }
    }

   
    //  db::getInstance()->db_query("COMMIT");
    $response = ['success' => true, 'message' => 'Stored procedures backed up and recreated.'];

} catch (Exception $e) {
    //Rollback & Cleanup
    db::getInstance()->db_insertQuery("ROLLBACK");
    unset($_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], $_SESSION['clone_dbPass'], $_SESSION['clone_dbName']);

    // ✅ Force-restore main DB session even after failure
    restoreMainDbSession($dbCompany, $dbDivision, $dbYear);

    $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
}

echo json_encode($response);



?>
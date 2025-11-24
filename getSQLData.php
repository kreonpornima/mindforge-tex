<?php
require_once ('dbClass.php');

$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
$ModalType = isset($_POST['ModalType']) ? $_POST['ModalType'] : '';
$dbCompany = $_SESSION['dbCompany'] ?? 0;
$dbDivision = $_SESSION['dbDivision'] ?? 0;
$dbYear = $_SESSION['dbYear'] ?? 0;

include 'model.php';
include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding


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

if($ModalType == 'sql'){
    $query = "SELECT name AS ProcedureName, OBJECT_DEFINITION(object_id) AS definition 
            FROM sys.procedures 
            WHERE name LIKE '%" . $FormID . "%' AND type='P' AND name NOT LIKE '%_old'
            ORDER BY name ";
            // OFFSET $start ROWS FETCH NEXT $limit ROWS ONLY;";

    $result = db::getInstance()->db_select($query);

    // Get total count
    $query1 = "SELECT COUNT(*) AS TotalCount FROM sys.procedures WHERE name LIKE '%" . $FormID . "%' AND name NOT LIKE '%_old'";
    $result1 = db::getInstance()->db_select($query1);

    // Build result
    $data = [];
    foreach ($result['result_set'] as $row) {
        $calledSPs = [];
        $procedureName = $row['ProcedureName'];

        // Use dependency-based sub-SP lookup
        $subSpQuery = "
            SELECT b.name AS SubProcedureName
            FROM sys.sysdepends a
            LEFT JOIN sys.objects b ON a.depid = b.object_id
            WHERE a.id = OBJECT_ID('$procedureName') AND b.type = 'P'
        ";

        $subSpResult = db::getInstance()->db_select($subSpQuery);

        if (!empty($subSpResult['result_set'])) {
            foreach ($subSpResult['result_set'] as $subRow) {
                $calledSPs[] = $subRow['SubProcedureName'];
            }
            $calledSPs = array_unique($calledSPs);
        }

        $data[] = [
            'ProcedureName' => $row['ProcedureName'],
            'CalledSPs' => $calledSPs
        ];
    }

    // Get company group
    // $getCompanyGroup = "SELECT STRING_AGG(Company_Group, ', ') AS CompanyGroups FROM Form_Group WHERE formid = $FormID";
    $getCompanyGroup = "SELECT STRING_AGG(Company_Group, ', ') AS CompanyGroups FROM (SELECT DISTINCT Company_Group FROM Form_Group WHERE formid = $FormID) AS DistinctGroups";
    $CompanyGroups = db::getInstanceMaster()->db_select($getCompanyGroup);

    
    $getGroupCompanies = "select Companyid, Company from Form_Group WHERE formid = $FormID"; 
    $GroupCompanies = db::getInstanceMaster()->db_select($getGroupCompanies);
 

    echo json_encode([
        'success' => true,
        'data' => $data,
        'companyGroups' => $CompanyGroups['result_set'][0]['CompanyGroups'],
        'GroupCompanies' => $GroupCompanies['result_set'],
        'total' => $result1['result_set'][0]['TotalCount']
    ]);
}else if($ModalType == 'clone'){
    $DestinationFormID = isset($_POST['DestinationFormID']) ? $_POST['DestinationFormID'] : '0';

    //Sorce Form Field
    $sql = "SELECT main_id, DbFieldName, DisplayName FROM kmainfields WHERE FormId = $FormID";
    $result = db::getInstanceMaster()->db_select($sql);
    // print_r($result);
    $fields = [];
    if (!empty($result['result_set'])) {
        foreach ($result['result_set'] as $field) {
            $fields[] = [
                'id'   => $field['main_id'],
                'name' => $field['DisplayName'],   // or use $field['DisplayName'] if you prefer
                'DbFieldName' => $field['DbFieldName']
            ];
        }
    }

    //Destination form field if exist
    $sql1 = "SELECT main_id, DbFieldName, DisplayName FROM kmainfields WHERE FormId = $DestinationFormID";
    $result1 = db::getInstanceMaster()->db_select($sql1);
    // print_r($result);
    $destinationfields = [];
    if (!empty($result1['result_set'])) {
        foreach ($result1['result_set'] as $field) {
            $destinationfields[] = [
                'id'   => $field['main_id'],
                'name' => $field['DisplayName'],   // or use $field['DisplayName'] if you prefer
                'DbFieldName' => $field['DbFieldName']
            ];
        }
    }

    echo json_encode([
        'success' => true,
        'fields'  => $fields,
        'destinationfields' => $destinationfields
    ]);
  
}else if($ModalType == 'cloneSP'){
    
    $DestinationFormID = isset($_POST['DestinationFormID']) ? $_POST['DestinationFormID'] : '0';
    $sourceCompany = isset($_POST['sourceCompany']) ? $_POST['sourceCompany'] : '0';
    $destinationCompany = isset($_POST['destinationCompany']) ? $_POST['destinationCompany'] : '0';
    
    $DestinationFormSp = [];
    if($destinationCompany){
        //Destination form sps if exist
        $query = "SELECT name AS ProcedureName, OBJECT_DEFINITION(object_id) AS definition 
            FROM sys.procedures 
            WHERE name LIKE '%" . $DestinationFormID . "%' AND type='P' AND name NOT LIKE '%_old'
            ORDER BY name ";
            // OFFSET $start ROWS FETCH NEXT $limit ROWS ONLY;";

        $result = db::getInstance()->db_select($query);

        // Build result
       
        foreach ($result['result_set'] as $row) {
            $calledSPs = [];
            $procedureName = $row['ProcedureName'];

            // Use dependency-based sub-SP lookup
            $subSpQuery = "
                SELECT b.name AS SubProcedureName
                FROM sys.sysdepends a
                LEFT JOIN sys.objects b ON a.depid = b.object_id
                WHERE a.id = OBJECT_ID('$procedureName') AND b.type = 'P'
            ";

            $subSpResult = db::getInstance()->db_select($subSpQuery);
            if (!empty($subSpResult['result_set'])) {
                foreach ($subSpResult['result_set'] as $subRow) {
                    $calledSPs[] = $subRow['SubProcedureName'];
                }
                $calledSPs = array_unique($calledSPs);
            }

            $DestinationFormSp[] = [
                'ProcedureName' => $row['ProcedureName'],
                'CalledSPs' => $calledSPs
            ];
        }

        // print_r($DestinationFormSp);
    }
    

    $SourceFormSp = [];
    if($sourceCompany){

        // Source form sps if exist
        $getUserCredentials = "select DISTINCT CompanyID, Sql_User_Id, Database_name, Decrypted_Password, Ip, Port from Aireg where CompanyID=$sourceCompany";
        $userCredential = db::getInstanceMaster()->db_select($getUserCredentials);
    
        if (empty($userCredential['result_set'])) {
            throw new Exception("No cloning credentials found for CompanyID: $sourceCompany");
        }
        
        $_SESSION['clone_dbHost'] = trim($userCredential['result_set'][0]['Ip']).','.trim($userCredential['result_set'][0]['Port']);
        $_SESSION['clone_dbUser'] = trim($userCredential['result_set'][0]['Sql_User_Id']);
        $_SESSION['clone_dbPass'] = trim($userCredential['result_set'][0]['Decrypted_Password']);
        $_SESSION['clone_dbName'] = trim($userCredential['result_set'][0]['Database_name']);
    
        $query = "SELECT name AS ProcedureName, OBJECT_DEFINITION(object_id) AS definition 
                FROM sys.procedures 
                WHERE name LIKE '%" . $FormID . "%' AND type='P' AND name NOT LIKE '%_old'
                ORDER BY name ";
                // OFFSET $start ROWS FETCH NEXT $limit ROWS ONLY;";
    
        $result = db::getInstanceCloning()->db_select($query);
    
        //Unset cloing session
        unset($_SESSION['clone_dbHost'], $_SESSION['clone_dbUser'], $_SESSION['clone_dbPass'], $_SESSION['clone_dbName']);
    
        // ✅ Restore main DB session after successful clone
        restoreMainDbSession($dbCompany, $dbDivision, $dbYear);
    
        // Build result
        foreach ($result['result_set'] as $row) {
            $calledSourceSPs = [];
            $procedureName = $row['ProcedureName'];
    
            // Use dependency-based sub-SP lookup
            $subSpQuery = "
                SELECT b.name AS SubProcedureName
                FROM sys.sysdepends a
                LEFT JOIN sys.objects b ON a.depid = b.object_id
                WHERE a.id = OBJECT_ID('$procedureName') AND b.type = 'P'
            ";
    
            $subSpResult = db::getInstanceCloning()->db_select($subSpQuery);
    
            if (!empty($subSpResult['result_set'])) {
                foreach ($subSpResult['result_set'] as $subRow) {
                    $calledSourceSPs[] = $subRow['SubProcedureName'];
                }
                $calledSourceSPs = array_unique($calledSourceSPs);
            }
    
            $SourceFormSp[] = [
                'ProcedureName' => $row['ProcedureName'],
                'calledSourceSPs' => $calledSourceSPs
            ];
        }
    }

    echo json_encode([
        'success' => true,
        'destinationFormSp' => $DestinationFormSp,
        'sourceFormSp' => $SourceFormSp
    ]);



}else{
    $getCompanyGroup = "SELECT Company_Groupid,Company_Group FROM (SELECT DISTINCT Company_Groupid,Company_Group FROM Form_Group WHERE formid = $FormID) AS DistinctGroups";
    $CompanyGroups = db::getInstanceMaster()->db_select($getCompanyGroup);

    echo json_encode([
        'success' => true,
        'companyGroups' => $CompanyGroups['result_set']
    ]);
}



?>
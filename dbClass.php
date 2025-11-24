<?php
// $dbType = 1;	//MySQL
$dbType = 2;	//MSSQL/ Sql Server

// // Get the current session max lifetime (in seconds)
// $sessionMaxLifetime = ini_get('session.gc_maxlifetime');
// // Get the current session cookie lifetime (in seconds)
// $sessionCookieLifetime = ini_get('session.cookie_lifetime');
// echo "Session Max Lifetime: " . $sessionMaxLifetime . " seconds<br>";
// echo "Session Cookie Lifetime: " . $sessionCookieLifetime . " seconds";
function makeDir($path){
    return is_dir($path) || mkdir($path);
}

/*function extractAttribute($att_list, $att_name){
   //$mediaFields[$mf]["folder"] = "img/"; 
   //if($k_debug) echo "<br />OTHER Attributes: " . $att_list;
   $temp = explode("|", $att_list); //Other Attributes added on 18 01 2021 
   for($t = 0; $t < sizeof($temp); $t++){
       if(strrpos($temp[$t], $att_name) !== FALSE){ //Match found
           $str = substr($temp[$t], strlen($att_name . '="'), strlen($temp[$t]) - 12);
           if(strlen($str) > 0) return $str;
           break;
       }
   }
   return null;
}*/
function extractAttribute($att_list, $att_name){
   // Use regex to find the attribute in the format 'att_name="value"'
   // echo $att_list;
   if (preg_match('/' . preg_quote($att_name) . '="([^"]*)"/', $att_list, $matches)) {
       return $matches[1];
   }
   return null;
}
function extractParameters($params){	//FOR ADDING PARAMETERS IN kmainforms. To be used on list view
   /*
       ycode=SESSION(yearcode)
       //ycode=VARIABLE(yearcode)
       ycode=DEFAULT(2324)
       ycode=FIELD(dbfieldname) //POST value copy
   */
   //echo "=========================>>>>>>>>>>" . $params;
   // where division = 1 AND (ycode = '2324' OR ycode = '2425') AND Company = 1
   // where division=DEFAULT(1) AND (ycode=SESSION(ycode) OR ycode = '2425') AND Company = 1

   $finalParams = "";
   $temp = explode("|", $params);
   
   for($t = 0; $t < sizeof($temp); $t++){
       if (preg_match('/=(.*?)\(/', $temp[$t], $match) == 1) {
           $function = trim($match[1]);
           if (preg_match('/\((.*?)\)/', $temp[$t], $val) == 1) {
               $value=$val[1];
           }
           $var = substr($temp[$t], 0, strpos($temp[$t], "="));

           if($function == "SESSION"){
               return $_SESSION[$value];
           }
           if($function == "DEFAULT"){
               return $value;
           }
           if($function == "FIELD"){
               return $value;
           }
       }else{
           // echo "<br />" . $temp[$t];
       }
   }
}
function getSPParams($var){
   $spname = preg_replace("/\([^)]+\)/","",$var);
   $sp['name'] = $spname;
   
   $params = substr($var , strpos($var, '(')+1, strpos($var,')') - 1);
   $spParams = str_replace(')','',$params);

   $dataArray = explode(',',$spParams);
   $set = [];
   $val = [];
   for($j=0; $j<count($dataArray); $j++){
       $element = explode("=",$dataArray[$j]);
       array_push($set,$element[0]);
       array_push($val,$element[1]);
   }
   $sp['params'] = $set;
   $sp['values'] = $val;
   
   //$var = Grid_Populate_1162_fld1(@PRODID=sabid,@tmp=qualityID)
   // $sp['name'] = 'Grid_Populate_1162_fld1';
   // $sp['params'] = array('@PRODID','@tmp' );
   // $sp['values'] = array('sabid','qualityID');
   return $sp;
}

function UserAccess($FormID,$RoleID){
    // - Group Access to the product :  select * from AiGroupProductAccess;
   // - Product Access to the module : select * from AiProductCategory;
    // - Module access to Role : select * from pageroleaccess;
    // - Company access to role : select * from CompanyRoleAccess;
    // - Role access to user : select * from users;
    // - User & Role access to Modes of access :  
   // - Secure all access file to superadmin
   // - PDF Report template rights in user access
    // - Check year, Division and company when edit, update,save or delete
   // - Access to static pages like roles.php, users, etc.

   //If user is developer then bypass user access
   if($_SESSION['Category'] == 2 || $_SESSION['Category'] == 3){
        // Step 1: Check if the FormID is accessible based on company and group access to the product
       $formAccessQuery = "
           SELECT k.FormId 
           FROM kmainforms k
           WHERE k.ProductCategoryID IN (
               SELECT agpa.ProductCategoryID 
               FROM AiGroupProductAccess agpa
               WHERE agpa.GroupID = (
                   SELECT ac.GroupID 
                   FROM AiCompany ac 
                   WHERE ac.ID = {$_SESSION['dbCompany']}	
               )
               AND agpa.isActive <> 0
           ) 
       ";

       // Add condition for specific FormID if it's set
       if (!empty($FormID) && $FormID > 0) {
           $formAccessQuery .= " AND k.FormId = " . intval($FormID);
       }

       $formResult = db::getInstanceMaster()->db_select($formAccessQuery, "dbc-132");
       
       if($formResult['num_rows'] == 0){
           return ['canAdd' => 0, 'canEdit' => 0, 'canDelete' => 0, 'canBarccodePrint' => 0, 'canEwayBill' => 0, 'canEinvoice' => 0, 'canPdfReport' => 0, 'canGridReport' => 0];
       }
       
       return ['canAdd' => 1, 'canEdit' => 1, 'canDelete' => 1, 'canBarccodePrint' => 1, 'canEwayBill' => 1, 'canEinvoice' => 1, 'canPdfReport' => 1, 'canGridReport' => 1];
   }

   //IF user is superadmin
   // if($_SESSION['Category'] == 3){
   // 	//check companyRole access
   // 	$selectsql="SELECT * FROM CompanyRoleAccess where RoleID = " . $RoleID ." AND RegID = ".$_SESSION['dbCompany'];
   // 	$selectResult = db::getInstanceMaster()->db_select($selectsql);

   // 	if($selectResult['num_rows'] == 0){
   // 		//Insert role access ti company
   // 		$sql ="INSERT into CompanyRoleAccess (RoleID, RegID) VALUES ('".$RoleID."','".$_SESSION['dbCompany']."')";
   // 		$result = db::getInstanceMaster()->db_insertQuery($sql);

   // 		//Get product of current company
   // 		$sql1="SELECT kpageaccess.ID FROM kpageaccess
   // 			LEFT JOIN kmainforms ON kpageaccess.FormId = kmainforms.FormId
   // 			LEFT JOIN AiGroupProductAccess ON kmainforms.ProductCategoryID = AiGroupProductAccess.ProductCategoryID
   // 			WHERE AiGroupProductAccess.GroupID = (
   // 				SELECT GroupID 
   // 				FROM AiCompany 
   // 				WHERE ID = {$_SESSION['dbCompany']}
   // 			) AND AiGroupProductAccess.isActive <> 0";
   // 		$getPageAccessID = db::getInstanceMaster()->db_select($sql1);

       
   // 		//Insert current company product to superadmin role which is 54
   // 		$queryVals = "INSERT INTO pageroleaccess (RoleID, PageAccessID, AddBtn,EditBtn,ListView,OtherBtn, DeleteBtn) 
   // 							VALUES ";
   // 		$separator = "";
   // 		for($i = 0; $i < $getPageAccessID['num_rows']; $i++){
   // 			$queryVals .= $separator . "(" . $RoleID . ", " . $getPageAccessID['result_set'][$i]['ID'] . ", 1,1,1,0,1)";
   // 			$separator = ", ";
   // 		}
   // 		$result = db::getInstanceMaster()->db_insertQuery($queryVals);

   // 	}
   // 	return ['canAdd' => 1, 'canEdit' => 1, 'canDelete' => 1];
   // }

    // Step 1: Check if the FormID is accessible based on company and group access to the product
   $formAccessQuery = "
       SELECT k.FormId 
       FROM kmainforms k
       WHERE k.ProductCategoryID IN (
           SELECT agpa.ProductCategoryID 
           FROM AiGroupProductAccess agpa
           WHERE agpa.GroupID = (
               SELECT ac.GroupID 
               FROM AiCompany ac 
               WHERE ac.ID = {$_SESSION['dbCompany']}	
           )
           AND agpa.isActive <> 0
       ) AND k.FormId=$FormID
   ";

   

   $formAccessResult = db::getInstanceMaster()->db_select($formAccessQuery, "dbc-194");

   if ($formAccessResult['num_rows'] == 0) {
       return ['canAdd' => 0, 'canEdit' => 0, 'canDelete' => 0, 'canBarccodePrint' => 0, 'canEwayBill' => 0, 'canEinvoice' => 0, 'canPdfReport' => 0, 'canGridReport' => 0];
   }

   // $allowedFormIDs = array_column($formAccessResult['result_set'] ?? [], 'FormId');

   // // Step 2: If the requested FormID is not in the allowed list, deny access
   // if (!in_array($FormID, $allowedFormIDs)) {
   //     // Optionally redirect here
   //     // header("Location: home.php"); exit;
       
   //     return ['canAdd' => 0, 'canEdit' => 0, 'canDelete' => 0];
   // }

   

   // Step 3: Proceed to role-based access check
   // $checkUserRoles = 'SELECT * FROM pageroleaccess WHERE PageAccessID IN (
   // 	SELECT a.ID 
   // 	FROM kpageaccess a 
   // 	WHERE FormId = '.$FormID.'
   // )
   // AND RoleID = '.$RoleID;	

   $checkUserRoles = 'SELECT pageroleaccess.*, kpageaccess.FileName, kmainforms.ModuleType
       FROM pageroleaccess 
       JOIN kpageaccess ON pageroleaccess.PageAccessID = kpageaccess.ID 
       JOIN kmainforms ON kpageaccess.FormId = kmainforms.FormId
       WHERE kpageaccess.FormId = '.$FormID.' 
       AND pageroleaccess.RoleID = '.$RoleID;

   
   $resultUserRoles = db::getInstanceMaster()->db_select($checkUserRoles);

   if (!empty($resultUserRoles) && is_array($resultUserRoles)) {
       $record = $resultUserRoles['result_set'][0];

       // Check ModuleType and FileName condition
       if (($record['ModuleType'] == 6 || $record['ModuleType'] == 4) && strpos($record['FileName'], 'list-data') !== false) {
           return ['canAdd' => 0, 'canEdit' => 0, 'canDelete' => 0, 'canBarccodePrint' => 0, 'canEwayBill' => 0, 'canEinvoice' => 0, 'canPdfReport' => 0, 'canGridReport' => 0];
       }

       return [
           'canAdd' => (isset($record['AddBtn']) && $record['AddBtn'] == 1) ? 1 : 0,
           'canEdit' => (isset($record['EditBtn']) && $record['EditBtn'] == 1) ? 1 : 0,
           'canDelete' => (isset($record['DeleteBtn']) && $record['DeleteBtn'] == 1) ? 1 : 0,
           'canBarccodePrint' => (isset($record['OtherBtn']) && $record['OtherBtn'] == 1) ? 1 : 0, 
           'canEwayBill' => (isset($record['EwayBillBtn']) && $record['EwayBillBtn'] == 1) ? 1 : 0, 
           'canEinvoice' => (isset($record['EinvoiceBtn']) && $record['EinvoiceBtn'] == 1) ? 1 : 0, 
           'canPdfReport' => (isset($record['PdfReportBtn']) && $record['PdfReportBtn'] == 1) ? 1 : 0, 
           'canGridReport' => (isset($record['GridReportBtn']) && $record['GridReportBtn'] == 1) ? 1 : 0
       ];
   }

   return ['canAdd' => 0, 'canEdit' => 0, 'canDelete' => 0, 'canBarccodePrint' => 0, 'canEwayBill' => 0, 'canEinvoice' => 0, 'canPdfReport' => 0, 'canGridReport' => 0]; // default: no access
}

// function extractTableAndCondition($sql, $queryType) {
//    // Check the type of query and use a pattern based on it
//    if (strtoupper($queryType) == 'DELETE') {
//        // Regular expression for DELETE query
//        $pattern = "/DELETE\s+FROM\s+`?(\w+)`?\s+WHERE\s+(.+)$/i";
       
//        if (preg_match($pattern, $sql, $matches)) {
//            $tableName = $matches[1]; // Table name (e.g., 'test')
//            // $whereCondition = $matches[2]; // WHERE condition (e.g., 'id = 12')
//            $whereCondition = rtrim(trim($matches[2]), ";");  // WHERE condition (e.g., 'id = 12')

//            return [
//                'table' => $tableName,
//                'where' => $whereCondition
//            ];
//        }
//    } elseif (strtoupper($queryType) == 'UPDATE') {
//        // Regular expression for UPDATE query
//        $pattern = "/UPDATE\s+`?(\w+)`?\s+SET\s+(.+?)\s+WHERE\s+(.+)$/i";

//        if (preg_match($pattern, $sql, $matches)) {
//            $tableName = $matches[1]; // Table name (e.g., 'test')
//            $setValues = $matches[2]; // SET values (e.g., 'fld1 = 'test5', fld3 = ''')
//            $whereCondition = $matches[3]; // WHERE condition (e.g., 'id = 17')
           
//            // Parse the SET values into an associative array
//            $newData = [];

//            // Update the regular expression for parsing the SET statement
//            // $patternSetValues = '/\s*`?(\w+)`?\s*=\s*([^,]+(?:,[^,]+)*)\s*/';
//            $patternSetValues = '/\s*`?(\w+)`?\s*=\s*([\'"]?)(.*?)(\2)\s*/';

//            // Match each SET item with the updated pattern
//            preg_match_all($patternSetValues, $setValues, $matchesSet);

//            foreach ($matchesSet[1] as $index => $field) {
//                $value = $matchesSet[3][$index];
//                // $value = trim($value, " '"); // Remove any surrounding spaces or quotes

//                // Remove leading and trailing single quotes if present
//                // if ((substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
//                // 	$value = substr($value, 1, -1);  // Remove the outer single quotes
//                // }

//                // Add to the newData associative array
//                $newData[$field] = $value;
//            }

//            return [
//                'table' => $tableName,
//                'where' => $whereCondition,
//                'new_data' => $newData
//            ];
//        }
//    }

//    return null; // Return null if no match found
// }


function parseInsertValues($valueStr) {
    $values = [];
    $buffer = '';
    $inString = false;
    $quoteChar = '';
    $bracketLevel = 0;
    $len = strlen($valueStr);

    for ($i = 0; $i < $len; $i++) {
        $char = $valueStr[$i];

        if ($inString) {
            $buffer .= $char;
            if ($char === $quoteChar && $valueStr[$i - 1] !== '\\') {
                $inString = false;
            }
        } else {
            if ($char === "'" || $char === '"') {
                $inString = true;
                $quoteChar = $char;
                $buffer .= $char;
            } elseif ($char === '(') {
                $bracketLevel++;
                $buffer .= $char;
            } elseif ($char === ')') {
                $bracketLevel--;
                $buffer .= $char;
            } elseif ($char === ',' && $bracketLevel === 0) {
                $values[] = trim($buffer);
                $buffer = '';
            } else {
                $buffer .= $char;
            }
        }
    }

    if (strlen(trim($buffer)) > 0) {
        $values[] = trim($buffer);
    }

    return $values;
}


function extractTableAndCondition($sql, $queryType) {
   // Check the type of query and use a pattern based on it
   if (strtoupper($queryType) == 'DELETE') {
       // Regular expression for DELETE query
       $pattern = "/DELETE\s+FROM\s+`?(\w+)`?\s+WHERE\s+(.+)$/i";
       
       if (preg_match($pattern, $sql, $matches)) {
           $tableName = $matches[1]; // Table name (e.g., 'test')
           // $whereCondition = $matches[2]; // WHERE condition (e.g., 'id = 12')
           $whereCondition = rtrim(trim($matches[2]), ";");  // WHERE condition (e.g., 'id = 12')

           return [
               'table' => $tableName,
               'where' => $whereCondition
           ];
       }
   } elseif (strtoupper($queryType) == 'UPDATE') {
       // Regular expression for UPDATE query
       $pattern = "/UPDATE\s+`?(\w+)`?\s+SET\s+(.+?)\s+WHERE\s+(.+)$/i";

       if (preg_match($pattern, $sql, $matches)) {
           $tableName = $matches[1]; // Table name (e.g., 'test')
           $setValues = $matches[2]; // SET values (e.g., 'fld1 = 'test5', fld3 = ''')
           $whereCondition = $matches[3]; // WHERE condition (e.g., 'id = 17')
           
           // Parse the SET values into an associative array
           $newData = [];

           // Update the regular expression for parsing the SET statement
           // $patternSetValues = '/\s*`?(\w+)`?\s*=\s*([^,]+(?:,[^,]+)*)\s*/';
           $patternSetValues = '/\s*`?(\w+)`?\s*=\s*([\'"]?)(.*?)(\2)\s*/';

           // Match each SET item with the updated pattern
           preg_match_all($patternSetValues, $setValues, $matchesSet);

           foreach ($matchesSet[1] as $index => $field) {
               $value = $matchesSet[3][$index];
               // $value = trim($value, " '"); // Remove any surrounding spaces or quotes

               // Remove leading and trailing single quotes if present
               // if ((substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
               // 	$value = substr($value, 1, -1);  // Remove the outer single quotes
               // }

               // Add to the newData associative array
               $newData[$field] = $value;
           }

           return [
               'table' => $tableName,
               'where' => $whereCondition,
               'new_data' => $newData
           ];
       }
   }elseif (strtoupper($queryType) == 'INSERT') {
        // Handle INSERT INTO
        $pattern = '/INSERT\s+INTO\s+`?(\w+)`?\s*\((.*?)\)\s*VALUES\s*(.+)/is';
        if (preg_match($pattern, $sql, $matches)) {
            $tableName = $matches[1];
            $columns = array_map('trim', explode(',', $matches[2])); // This is your column list

            $valuesPart = trim($matches[3]);
            $rows = [];

            // Match each (...) value group (handles expressions like concat(...) too)
            preg_match_all('/\((?>[^()]+|(?R))*\)/', $valuesPart, $valueMatches);

            foreach ($valueMatches[0] as $rowGroup) {
                $rowGroup = trim($rowGroup, '()');
                $rowValues = parseInsertValues($rowGroup); // custom helper (must be defined)
                $rowAssoc = [];

                foreach ($columns as $index => $col) {
                    $col = trim($col, "` ");
                    $rowAssoc[$col] = isset($rowValues[$index]) ? $rowValues[$index] : null;
                }

                $rows[] = $rowAssoc;
            }

            return [
                'table' => $tableName,
                'columns' => $columns,     // <-- include this
                'new_data' => $rows
            ];
        }
    }

   return null; // Return null if no match found
}

// validate date financial year wise
function validateDate(){
		$DateValidation = "From=YearCode_Start&To=YearCode_End";

		$DateValidationArr = explode('&', $DateValidation); 
		$sql = "select sdate,edate from AiYear where Label = '" . $_SESSION['dbYear'] . "'";
		$result = db::getInstanceMaster()->db_select($sql, "F-9703");
		// if($FormID == 3010)	print_r($result);
		$yearStartDate = $result['result_set'][0]['sdate'];
		$yearStartDate = $yearStartDate->format('Y-m-d');
		// if($FormID == 3010)	echo $yearStartDate;
		$yearEndDate = $result['result_set'][0]['edate'];
		$yearEndDate = $yearEndDate->format('Y-m-d');
		// if($FormID == 3010)	echo $yearEndDate;
		foreach ($DateValidationArr as $pair) { 
			list($key, $value) = explode('=', $pair); 
			// if($FormID == 2644)	echo $key . ',' . $value;
			if (strtolower($key) === 'from') { 
				$date_min = $value;
				if(strtolower($date_min) == 'yearcode_start'){
					$date_min = $yearStartDate;
				}
				if(strtolower($date_min) == 'yearcode_end'){
					$date_min = $yearEndDate;
				}
				if(strtolower($date_min) == 'today'){
					$date_min = date("Y-m-d");
				}
				if(strtolower($date_min) == 'tomorrow'){
					$date_min = date("Y-m-d",strtotime("tomorrow"));
				}
				if(strtolower($date_min) == 'yesterday'){
					$date_min = date("Y-m-d",strtotime("yesterday"));
				}
			} elseif (strtolower($key) === 'to') { 
				$date_max = $value; 
				if(strtolower($date_max) == 'yearcode_start'){
					$date_max = $yearStartDate;
				}
				if(strtolower($date_max) == 'yearcode_end'){
					$date_max = $yearEndDate;
				}
				if(strtolower($date_max) == 'today'){
					$date_max = date("Y-m-d");
				}
				if(strtolower($date_max) == 'tomorrow'){
					// $datetime = new DateTime('tomorrow');
					// $date_max = $datetime->format('Y-m-d H:i:s');
					$date_max = date("Y-m-d",strtotime("tomorrow"));
				}
				if(strtolower($date_max) == 'yesterday'){
					// $tmp = new DateTime(); 
					// $tmp->modify('-1 day');
					$date_max = date("Y-m-d",strtotime("yesterday"));
				}
			} 
		}

		return [
			'date_min' => $date_min,
			'date_max' => $date_max
		];
	} 


if($dbType == 1)	include('dbClassMySQL.php');
if($dbType == 2)	include('dbClassMSSQL.php');
// echo "<script>alert('HI')</script>";
// extractParameters("ycode=SESSION(yearcode)|division=DEFAULT(test)");
?>
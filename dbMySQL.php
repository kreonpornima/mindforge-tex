<?php
// if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
//   header('Method Not Allowed', true, 405);
//   echo "This method requests are not accepted for this resource";
//   exit;
// }

// FOR VAPT
session_start(); 
$token = filter_input(INPUT_POST, 'csrftoken', FILTER_SANITIZE_STRING);
// echo "<br />" . $_SESSION['csrftoken'];

//this code commented because when user working with 2 tab then on save getting 405 error
// if (!$token || $token !== $_SESSION['csrftoken']) {
//     // return 405 http status code
//     header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
//     exit;
// }



$k_debug = 0;
include_once('dbClass.php');
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : 0;

// if($_SESSION['user_id'] == 1022){
 	// if($FormID == 5842) $k_debug = 1;
// }
// if($FormID == 5382) echo "Number of POST variables: ".count($_POST);
// if($FormID == 4556) echo "Size of POST data in bytes: ".strlen(serialize($_POST));
// if($FormID == 4556) echo "Raw size of POST request in bytes: ". $_SERVER['CONTENT_LENGTH']; exit();

// if($FormID == 4921){
// 	print_r($_POST);
// }

if($FormID == 0){
	echo "No Model Exists.";
	exit();
}
// if($FormID == 3667) $k_debug = 1;
include 'model.php'; 

$CreatedBy =  $_SESSION['user_id'];
$CreatedAt = date('Y-m-d H:i:s');
$UpdatedAt = date('Y-m-d H:i:s');
$UpdatedBy = $_SESSION['user_id'];
$CompanyId = $_SESSION['dbCompany'];
$DivisionId = $_SESSION['dbDivision'];
$YearCode = $_SESSION['dbYear'];
$Role = $_SESSION['access'];
// $ModuleId = $viewSettings[14];

//Code for generate uniqueid added by pornima on date 13/11/2024
$uniqueQuery = "concat(  right(".$YearCode." ,2) , right( concat( '000000000000' , next value for  uniqueid".$YearCode." ) ,9) )";




function printDebug($k_debug, $var, $title){
	if($k_debug > 0){
		echo "<br />" . $title . ": ";
		if($k_debug == 2){ 
			print"<pre>";
			print_r($var);
			print"</pre>";
		}else
			print_r($var);
		echo "<br />";
	}
}


$editID = isset ($_POST['editID']) ? $_POST['editID'] : 0; 
$saveButton = isset ($_POST['kreonClickButton']) ? $_POST['kreonClickButton'] : 0; 

$user_id = isset ($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

if($user_id == 0){
	//REDIRECT TO LOGOUT AS USER ID NOT AVAILABLE IN SESSION
}else{
	$_POST['created_by'] = $user_id;
}

echo "SAVING DATA... Do Not Press Back or Refresh";
if($k_debug) echo "<br/><br/>POST VARIABLES: ";
if($k_debug) print_r($_POST);
// printDebug(2, $_POST, "POST VARIABLE");
if($k_debug) echo "<br/><br/>CODE VARIABLE: ";
if($k_debug) print_r($code);
if($k_debug) echo "<br/><br/>FILES: "; 
if($k_debug) print_r($_FILES);
// printDebug(2, $_FILES, "Attachments/ Files");
// echo "<br/><br/>"; 
// if($k_debug) print_r($dynamix);
// printDebug(2, $dynamix, "Dynamix Grid");
// echo "<br/><br/>"; 
//  exit();

/*
	ADD & EDIT FOR ALL
		Image				Gallery		
	1	Enable				Disable				
	2	Disable				Enable				
	3	No Data				No Data				
	4	Data				No Data				
	5	No Data				Data				
	6	Data				Data				
	7	Multiple Enabled	Disable		
							if only 1 image
*/

//*************Validate Save & Edit if missmatch session & post companyid, divisionid, yearcode */

 
if($viewSettings[12] != 1)
{
	// Function to log developer-level errors to the DeveloperErrorLogs table
	function logDevError($FieldName, $FormID, $session, $desc, $solution) {
		// SQL INSERT statement to log error details into DeveloperErrorLogs
		$sqlDev = "INSERT INTO DeveloperErrorLogs (
			[FormID], [CompanyID], [DivisionID], [YearCode], [Database_name],
			[ErrorCode], [ErrorField], [Description], [RecommendedSolution], [CreatedBy], [CreatedAt]
		) VALUES (
			$FormID,
			{$session['dbCompany']},
			{$session['dbDivision']},
			{$session['dbYearID']},
			'{$session['dbName']}',
			100,
			'$FieldName',
			'$desc',
			'$solution',
			{$session['user_id']},
			GETDATE()
		)";
		// Execute the insert query using the master DB instance
		db::getInstanceMaster()->db_insertQuery($sqlDev);
	}

	// Define the expected and posted values for validation
	$checks = [
		'CompanyId' => [$CompanyId, $_POST['kreon-companyid']],
		'DivisionId' => [$DivisionId, $_POST['kreon-divisionid']],
		'YearCode' => [$YearCode, $_POST['kreon-yearcode']],
	];

	// Loop through each field to validate posted values against expected ones
	foreach ($checks as $field => [$expected, $posted]) {
		// If values don't match and it's an edit operation, log with "POST = expected"
		if ($posted != $expected) {
			if($editID > 0){
				// Set the alert message in the session
				$_SESSION['FormEditValidationMessage'] = "Entry Not Deleted. $field mismatch: POST = $expected, Expected = $posted"; // Customize the message
				logDevError($field, $FormID, $_SESSION, "$field mismatch: POST = $expected, Expected = $posted", "Mismatch post & session $field");
			}else{
				// Set the alert message in the session
				$_SESSION['FormEditValidationMessage'] = "Entry Not Deleted. $field mismatch: POST = $posted, Expected = $expected"; // Customize the message
				logDevError($field, $FormID, $_SESSION, "$field mismatch: POST = $posted, Expected = $expected", "Mismatch post & session $field");
			}
			// Redirect back to the referring page with view=1 and the current form ID
			echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'&view=1&form='.$FormID.'";</script>';
			exit(); // Stop script execution after redirection
		}
	}
}



/**************MEDIA****************/

if(isset($_FILES)){

	$mediaFields = array();
	$mf = 0;
	$atname="";

	//FOR MEDIA TYPE 12
	for($i = 0; $i<sizeof($code); $i++){

		if($code[$i][1] == 12){

			$atname = $code[$i][0];

			$mediaFields[$mf] = $_FILES[$code[$i][0]];

			$mediaFields[$mf]["CodeArray"] = $i;

			$mediaFields[$mf]["MediaId"][0] = 0;

			

			//Other Attributes added on 18 01 2021 

			$mediaFields[$mf]["folder"] = "img/"; 

			if($k_debug) echo "<br />OTHER Attributes: " . $code[$i][8] . "<br />";

			$att_value = extractAttribute($code[$i][8], "IMAGEPATH");
			if($k_debug) echo "<br />Folder: " . $att_value . "<br />";
			if(strlen($att_value) > 0 && $att_value != null) $mediaFields[$mf]["folder"] = $att_value;

			//Other Attributes added on 18 01 2021

			

			//MODIFIED 19 03 2021 for multiple image controls on one page

			if(isset($_FILES[$atname])){

				if($_FILES[$atname]["size"][0] > 0){

					//echo "MF-".$mf;

					//print_r($mediaFields);

					$z = $mf;

					//for($z = 0; $z <= $mf; $z++){	

						for($j=0; $j<count($mediaFields[$z]['name']); $j++){ //ARRAY for Multiple Files Uploaded in same input

							//$target_dir = "img/";

							$target_dir = SITE_ROOT . $mediaFields[$z]["folder"];
							makeDir($target_dir);

							$imageFileType = strtolower(pathinfo($mediaFields[$z]["name"][$j],PATHINFO_EXTENSION));

							$imageFileName = basename($mediaFields[$z]["name"][$j],".".$imageFileType);

							$imageSize = $mediaFields[$z]["size"][$j];

							//$check = getimagesize($mediaFields[$z]["tmp_name"]);

							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "csv" && $imageFileType != "xlsx" && $imageFileType != "sql") { 

								//Allow certain file formats (use strcmp here)

								echo "<script> alert('Sorry, only JPG, JPEG, PNG, CSV, XLSX, GIF & SQL files are allowed.');</script>";

								// echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';

								exit();

							}

							$existCnt = 0;

							$existCheck = "";

							recheck:

								if($existCnt > 0) 	$existCheck = " (" . $existCnt . ")";

								$target_file = $target_dir . $imageFileName . $existCheck . "." . $imageFileType ;

								//if($k_debug) echo "<br />" . $target_file;

								if (file_exists($target_file)) { // Check if file already exists

									$existCnt++;

									goto recheck;

								}else{

									if($k_debug) echo "<br />CHECKED Duplicates & file adjusted to- " . $target_file;

								}

							if($k_debug) echo "<br />" .  "Starting Move File...";

							if(move_uploaded_file($mediaFields[$z]["tmp_name"][$j], $target_file)){

								if($k_debug) echo "<br />The file ". basename($mediaFields[$z]["name"][$j]). " has been uploaded.";

								$mediaFields[$z]["name"][$j] = basename($target_file);

								

								/****Insert Media****/

								$set = array();

								$val = array();

								$k = 0;

								$set[$k] = "MediaName";

								$val[$k++] = $mediaFields[$z]['name'][$j];

								$set[$k] = "MediaType";

								$val[$k++] = strtolower(pathinfo($mediaFields[$z]["name"][$j],PATHINFO_EXTENSION));

								$set[$k] = "MediaFolder";

								$val[$k++] = $mediaFields[$z]["folder"];

								$result = db::getInstance()->db_insert("kmainmedia",$set,$val);

								if($k_debug) echo "<br /><br />The uploaded file has been saved to DB- ";

								if($k_debug) print_r($result); 

								$mediaFields[$z]['MediaId'][$j] = $result['last_id'];

								/*******/

							}else{

								echo "<script> alert('Sorry, there was an error uploading your file.');</script>";

								// echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';

								exit();

							}

						}

					//}

				}
			}else{
				$mediaFields[$i]['MediaId'][$j] = 0;
			}
			$mf++;
		}
	}

	//FOR MEDIA TYPE 13
	$atname="";
	for($i = 0; $i<sizeof($code); $i++){
		//$mf = 0;
	    if($code[$i][1] == 13 ){
			//echo "<br />-*-*-*-*-*-*-*-*-*-*- STARTING 13 -*-*-*-*-*-*-*-*-*-<br />";
			$atname = $code[$i][0];
			$mediaFields[$mf] = $_FILES[$code[$i][0]];
			$mediaFields[$mf]["CodeArray"] = $i;
			$mediaFields[$mf]["MediaId"][0] = 0;			
			$mediaFields[$mf]["folder"] = "img/"; 
			if($k_debug) echo "<br />OTHER Attributes: " . $code[$i][8] . "<br />";
			$att_value = extractAttribute($code[$i][8], "IMAGEPATH");
			if($k_debug) echo "<br />Folder: " . $att_value . "<br />";
			if(strlen($att_value) > 0 && $att_value != null) $mediaFields[$mf]["folder"] = $att_value;
			if(isset($_FILES[$atname])){
				if($_FILES[$atname]["size"][0] > 0){
					$z = $mf;
						for($j=0; $j<count($mediaFields[$z]['name']); $j++){ //ARRAY for Multiple Files Uploaded in same input
							//$target_dir = "img/";
							$target_dir = SITE_ROOT . $mediaFields[$z]["folder"];
							makeDir($target_dir);
							$imageFileType = strtolower(pathinfo($mediaFields[$z]["name"][$j],PATHINFO_EXTENSION));

							$imageFileName = basename($mediaFields[$z]["name"][$j],".".$imageFileType);

							$imageSize = $mediaFields[$z]["size"][$j];

							//$check = getimagesize($mediaFields[$z]["tmp_name"]);

							if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "csv" && $imageFileType != "xlsx" && $imageFileType != "sql") { 

								//Allow certain file formats (use strcmp here)

								echo "<script> alert('Sorry, only JPG, JPEG, PNG, GIF & SQL files are allowed.');</script>";

								echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';

								exit();

							}

							$existCnt = 0;

							$existCheck = "";

							recheck13:

								if($existCnt > 0) 	$existCheck = " (" . $existCnt . ")";

								$target_file = $target_dir . $imageFileName . $existCheck . "." . $imageFileType ;

								//if($k_debug) echo "<br />" . $target_file;

								if (file_exists($target_file)) { // Check if file already exists

									$existCnt++;

									goto recheck13;

								}else{

									if($k_debug) echo "<br />CHECKED Duplicates & file adjusted to- " . $target_file;

								}

							if($k_debug) echo "<br />" .  "Starting Move File...";

							if(move_uploaded_file($mediaFields[$z]["tmp_name"][$j], $target_file)){

								if($k_debug) echo "<br />The file ". basename($mediaFields[$z]["name"][$j]). " has been uploaded.";

								$mediaFields[$z]["name"][$j] = basename($target_file);

								

								/****Insert Media****/

								$set = array();

								$val = array();

								$k = 0;

								$set[$k] = "MediaName";

								$val[$k++] = $mediaFields[$z]['name'][$j];

								$set[$k] = "MediaType";

								$val[$k++] = strtolower(pathinfo($mediaFields[$z]["name"][$j],PATHINFO_EXTENSION));

								$set[$k] = "MediaFolder";

								$val[$k++] = $mediaFields[$z]["folder"];

								$result = db::getInstance()->db_insert("kmainmedia",$set,$val);

								if($k_debug) echo "<br /><br />The uploaded file has been saved to DB- ";

								if($k_debug) print_r($result); 

								$mediaFields[$z]['MediaId'][$j] = $result['last_id'];

								/*******/

							}else{

								echo "<script> alert('Sorry, there was an error uploading your file.');</script>";

								echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'";</script>';

								exit();

							}

						}

					//}

				}

			}else{

				$mediaFields[$i]['MediaId'][$j] = 0;

			}

			$mf++;

		}
		
	}  

	

	//FOR GRID MEDIA TYPE 12

	$imageInGrid = array();

    $igCnt = 0;

    $POSTgrid = array();

    // for($i=0; $i < sizeof($dynamix); $i++){ //iterate to number of GRIDS
		
    //     $snglGrid = $dynamix[$i][0];

    //     $gridAlphabet = $dynamix[$i][1][3];

    //     for($m = 0; $m < sizeof($snglGrid); $m++){  //iterate to the grid field

    //         if($snglGrid[$m][0] == 12){             //check if field is an image

    //             $imageInGrid[$igCnt] = array();

    //             $imageInGrid[$igCnt][0] = $snglGrid[$m][1];     //Name of field

    //             $imageInGrid[$igCnt][1] = $gridAlphabet;        //Alphabet for accessing

                

    //             echo "<br /><br/>" . $key = $imageInGrid[$igCnt][1] . $imageInGrid[$igCnt][0];

    //             $POSTgrid[$key] = array();

    //             if(array_key_exists($key, $_FILES)){

    //                 $temp = array();

    //                 for($j = 0; $j < sizeof($_FILES[$key]["error"]); $j++){ //if no error then image exist

    //                     $POSTgrid[$key][$j] = 0; 

    //                     $temp[$j]=0;

    //                     if($_FILES[$key]["error"][$j] == 0){  

    //                         //STORE IMAGE AND SAVE IN DATABASE

    //                         if($_FILES[$key]["size"][$j] > 0){

    //                             if($k_debug) echo "<br /> Checking => " . $_FILES[$key]["name"][$j];

    //                             $target_dir = "img/";

    //         					$target_dir = SITE_ROOT . $target_dir;

    //         					$imageFileType = strtolower(pathinfo($_FILES[$key]["name"][$j],PATHINFO_EXTENSION));

    //         					$imageFileName = basename($_FILES[$key]["name"][$j],".".$imageFileType);

    //         					$imageSize = $_FILES[$key]["size"][$j];

    //         					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "csv" && $imageFileType != "xlsx" && $imageFileType != "sql") {   //Allow certain file formats (use strcmp here)

    //         						echo "<script> alert('Sorry, only JPG, JPEG, PNG, CSV, XLSX, GIF & SQL files are allowed.');</script>";

    //         						exit();

    //         					}

    //         					$existCnt = 0;

    //         					$existCheck = "";

    //         					recheck2:

    //         						if($existCnt > 0) 	$existCheck = " (" . $existCnt . ")";

    //         						$target_file = $target_dir . $imageFileName . $existCheck . "." . $imageFileType ;

    //         						if (file_exists($target_file)) { // Check if file already exists

    //         							$existCnt++;

    //         							goto recheck2;

    //         						}else{

    //         							if($k_debug) echo "<br />CHECKED Duplicates & file adjusted to- " . $target_file;

    //         						}

    //         					if($k_debug) echo "<br />Uploading file ". $target_file . "...";

    //         					if(move_uploaded_file($_FILES[$key]["tmp_name"][$j], $target_file)){

    //         						if($k_debug) echo "<br />The file ". basename($_FILES[$key]["name"][$j]). " has been uploaded as " . $target_file;

    //         						$_FILES[$key]["name"][$j] = basename($target_file);

            						

    //         						/****Insert Media****/

    //             						$set = array();

    //             						$val = array();

    //             						$k = 0;

    //             						$set[$k] = "MediaName";

    //             						$val[$k++] = $_FILES[$key]['name'][$j];

    //             						$set[$k] = "MediaType";

    //             						$val[$k++] = strtolower(pathinfo($_FILES[$key]["name"][$j],PATHINFO_EXTENSION));

    //             						$set[$k] = "MediaFolder";

    //             						$val[$k++] = "img/";

    //             						$result = db::getInstance()->db_insert("kmainmedia",$set,$val);

    //             						if($k_debug) echo "<br /><br />The uploaded file has been saved to DB- ";

    //             						if($k_debug) print_r($result); 

    //             						$dynamix[$i][1][4] = $POSTgrid[$key][$j] = $temp[$j] = $result['last_id'];

    //         						/*******/

    //         					}else{

    //         					    echo move_uploaded_file($_FILES[$key]["tmp_name"][$j], $target_file);
    //         						echo "<script> alert('Sorry, there was an error uploading your file.');</script>";
    //         						exit();
    //         					}
    //         				}
    //                     }else{
	// 						//added by pornima on 8-9-2024 for if field type image but before save & sending kmainfield id
	// 						$dynamix[$i][1][4] = $POSTgrid[$key][$j] = $temp[$j] = $_POST['aimg'][$j];
	// 					}
    //                 }
    //                 $_POST[$key] = $temp;
    //             }
    //             $igCnt++;
    //         }
    //     }
    // }
    // print_r($imageInGrid);
    // echo "<br/><br/>"; 
    // printDebug(2, $POSTgrid, "POST Image Grid");
}

// printDebug(2, $_POST, "POST VARIABLE");
// echo "<br/><br/>";
// exit();

/**************END MEDIA***************/

    if($k_debug) print_r($mediaFields); 

	//echo "<pre>";



	$many2many = array(); $m=0;

	$m2mdb = array(); $mdb=0; $m2mdbtype = array();

	$gm2mdb = array(); $gmdb=0; $gm2mdbtype = array();
	$ExistSerialArray = [];
	$mappingGridId = [];

if($editID > 0){
	
	//EDIT
	$_POST['UpdatedBy'] = $UpdatedBy;
	$_POST['UpdatedAt'] = $UpdatedAt;
	$_POST['CompanyId'] = $CompanyId;
	$_POST['DivisionId'] = $DivisionId;
	$_POST['YearCode'] = $YearCode;
	// $_POST['moduleid'] = $ModuleId;
	
	array_push($code, array('UpdatedBy',1,''.'UpdatedBy','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('UpdatedAt',6,''.'UpdatedAt','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''));

	array_push($code, array('CompanyId',1,''.'CompanyId','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('DivisionId',1,''.'DivisionId','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('YearCode',1,''.'YearCode','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('FormID',1,'','FormID','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''));
	//,array('moduleid',1,''.'moduleid','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')

	$Grids=array();
	for($i = 0; $i < sizeof($serials); $i++){
		if(isset($_POST['GridId' . $serials[$i]])){
			$Grids[$i] = array();
			$Grids[$i]['var'] = $serials[$i];
			// $Grids[$i]['cnt'] = $_POST['cnt' . $serials[$i]]; //gives issue if cnt is different than grid rows cnt
			$Grids[$i]['cnt'] = sizeof($_POST[$serials[$i] . 'GridTempID']) - 1;
			$_POST['cnt' . $serials[$i]] = $Grids[$i]['cnt']; //due to issues of ct not coming same

			for($j = 0; $j < $Grids[$i]['cnt']; $j++){
				$_POST[$serials[$i] . 'UpdatedBy'][$j] = $UpdatedBy;
				$_POST[$serials[$i] . 'UpdatedAt'][$j] = $UpdatedAt;
				$_POST[$serials[$i] . 'CompanyId'][$j] = $CompanyId;
				$_POST[$serials[$i] . 'DivisionId'][$j] = $DivisionId;
				$_POST[$serials[$i] . 'YearCode'][$j] = $YearCode;
				// $_POST[$serials[$i] . 'moduleid'][$j] = $ModuleId;
				$_POST[$serials[$i] . 'FormID'][$j] = $FormID;

				
			}
		}
	}
	
	$separator = "";

	$sql = "UPDATE ".$db[0]." SET ";//`".$code[0][0]."` = '". mysql_real_escape_string($_POST[$code[0][0]]) ."'";
	
	for($i = 0; $i<sizeof($code); $i++){
		

		if($code[$i][1] == 14 || $code[$i][7] == 0){ //If Grid or If Display order = 0

		}else{

			if($code[$i][1] == 10){	//FOR MANY TO MANY MAPPING

				$many2many[$m++] = $i;

			}else{
			
				if($code[$i][1] == 9 || $code[$i][1] == 11 || $code[$i][1] == 13 || $code[$i][1] == 16){ //FOR MANY TO MANY MAPPING IN OTHER TABLE & for Multiple Images
					
					$m2mdbtype[$mdb] = $code[$i][1];

					$m2mdb[$mdb++] = $i;

					if($code[$i][1] == 13){

						for($l = 0; $l<$mf; $l++){	

							if($mediaFields[$l]['CodeArray'] == $i){

							    if($mediaFields[$l]['MediaId'] > 0)	

							        $_POST[$code[$i][0]] = $mediaFields[$l]['MediaId'];

								break;

							}

						}

					}

				}else{ //ALL OTHER DO GO IN MAIN DATABASE TABLE OF THE MODEL

				    if($code[$i][1] == 12){ //SINGLE IMAGE UPLOAD

						/*

						$val[$k] = 0;

						for($l = 0; $l<$mf; $l++){	

							if($mediaFields[$l]['CodeArray'] == $i){

								$val[$k] = $mediaFields[$l]['MediaId'][0];

								break;

							}

						}

						*/

						//$val[$k] = 0; //commented due to error when no Media is passed

						for($l = 0; $l<$mf; $l++){

							if($mediaFields[$l]['CodeArray'] == $i){								

								//$val = isset($_POST[$code[$i][0]]) ? ($_POST[$code[$i][0]]) : "";

            					//$val = db::getInstance()-> real_escape_string($val);

								if($mediaFields[$l]['MediaId'][0] > 0){

									$sql .= $separator." ".$code[$i][0]." = '". $mediaFields[$l]['MediaId'][0] ."' ";

									$separator = ",";

								}

								break;

							}

						}

					}else{

						
						if($code[$i][1] != 21 && $code[$i][1] != 22 && $code[$i][1] != 23 && $code[$i][1] != 25 && $code[$i][1] != 24){
							$val = isset($_POST[$code[$i][0]]) ? ($_POST[$code[$i][0]]) : "";

							$val = str_replace("<script>","",$val);    //ADDED FOR VAPT 

							$val = str_replace("</script>","",$val);   //ADDED FOR VAPT 

							$val = str_replace("</","",$val);          //ADDED FOR VAPT 

							$val = str_replace("><","",$val);          //ADDED FOR VAPT 

							$val = str_replace("onerror","",$val);     //ADDED FOR VAPT 

							// \"><img src=x onerror=alert(\"Hacked\")>
							//echo "*******".$val;
							$val = db::getInstance()-> real_escape_string($val);

							if($code[$i][1] == 6){
								$val = !empty($val) ? "'".$val."'" : 'null';
								$sql .= $separator." ".$code[$i][0]." =".$val."";
								
							}else{
								$sql .= $separator." ".$code[$i][0]." = '". $val ."' ";
							}

							$separator = ",";
						}
					}

				}

			}

		}

	}
	$sql = $sql . " WHERE ".$db[1]." = ".$editID;

	if($k_debug) echo '<br/>CD108: '.$sql.'<br/>';

	$result = db::getInstance()->db_update($sql);	

	if($k_debug) print_r($result);

	
	// echo "1=>>********";
	// print_r($mdb);
	// echo "2=>>********";
	// print_r($m2mdb);
	
	//echo "::::::::DD102" . $mdb;
	if(sizeof($dynamix) > 0){

		$dbPK = array();
		$postGridRowPK = [];
		$mainDB = $db;
		for($i = 0; $i < sizeof($dynamix); $i++){
			$sq = "SELECT " . $dynamix[$i][1][5] . " FROM " . $mainDB[0] . " WHERE " . $mainDB[1] . " = " . $editID;
			$rs = db::getInstance()->db_select($sq);
			$upID = $rs['result_set'][0][$dynamix[$i][1][5]];
			

			array_push($dynamix[$i][0], array(1,'UpdatedBy','UpdatedBy','','','','','','','','','','','','','','','','','','','',''),array(6,'UpdatedAt','UpdatedAt','','','','','','','','','','','','','','','','','','','','',''));
			
			array_push($dynamix[$i][0], array(1,'CompanyId','CompanyId','','','','','','','','','','','','','','','','','','','','',''),array(1,'DivisionId','DivisionId','','','','','','','','','','','','','','','','','','','','',''),array(1,'YearCode','YearCode','','','','','','','','','','','','','','','','','','','','',''),array(1,'FormID','FormID','','','','','','','','','','','','','','','','','','','','',''));
			//,array(1,'moduleid','moduleid','','','','','','','','','','','','','','','','','','','','','')

			// echo "<br/>************************************************<br/>";
			// if($k_debug) print_r($dynamix);
			// echo "<br/>************************************************<br/>";
			// if($k_debug) print_r($_POST);
			// printDebug(2, $dynamix, "Dynamix Grid");
		
			$db = $dynamix[$i][1][0];

			$fk = $dynamix[$i][1][1];

			$pk = $dynamix[$i][1][5];
			

			$sql = 'SELECT '.$pk.' FROM '. $db.' WHERE '. $fk . ' = '. $upID;

			printDebug($k_debug, $sql, "CD108 in Dynamix block: ");

			$result = db::getInstance()->db_select($sql);

			printDebug($k_debug, $result, "CD108 Dynamix Result: ");
		
			for($j = 0; $j <= $result['num_rows'] ; $j++){
				$dbPK[$i][$j] = $result['result_set'][$j][$pk];
			}

			$cntDB = $result['num_rows'];
			//Chaangedby Purnima on 8-3-2024 issue giving while updating grid
			$cntFn = $_POST['cnt'.$dynamix[$i][1][3]]; //$cntFn = $_POST['cnt'.$dynamix[$i][1][3]] - 1;

			if($k_debug) echo "<br />DBcnt: " . $cntDB . "<br />";

			if($k_debug) echo "<br />FNcnt: " . $cntFn . "<br />";
			// $Grids[$i]['cnt'] = sizeof($_POST[$serials[$i] . 'GridTempID']) - 1;
			if($k_debug) echo "<br />GridsCnt: " . $Grids[$i]['cnt'] . "<br />";

			if($k_debug) print_r($dbPK);

			//Remove first 0 from post GridEditID
			array_shift($_POST[$dynamix[$i][1][3]."GridEditID"]);

			if($k_debug) print_r($_POST[$dynamix[$i][1][3]."GridEditID"]);
			
			$t1 = array(); $cntt1 = 0; 

			$t2 = array(); $cntt2 = 0;	
			
			$t3 = array(); $cntt3 = 0;

			$t1[$cntt1++] = $pk;


			for($j = 0; $j < sizeof($dynamix[$i][0]); $j++){ //LOOPING ON FIELDS

				$t1[$cntt1++] = $dynamix[$i][0][$j][1];

				//Adding field type
				$t3[$cntt3++] = $dynamix[$i][0][$j][0];

				//for field type 9,11,13 & 16
				if($dynamix[$i][0][$j][0] == 9 || $dynamix[$i][0][$j][0] == 11 || $dynamix[$i][0][$j][0] == 13 || $dynamix[$i][0][$j][0] == 16 	){
					$elementToAdd =  $dynamix[$i][0][$j][1];

					// Check if the element already exists in $gm2mdb before adding it
					if (!in_array($elementToAdd, $gm2mdb)) {
						$gm2mdb[$gmdb++] = $dynamix[$i][0][$j][1]; // dbfieldname
						array_push($ExistSerialArray,$dynamix[$i][1][3]); //Serial No push into array
						array_push($mappingGridId,$dynamix[$i][1][7]); // Grid Id
					}

					
					// $gm2mdb[$gmdb++] = $dynamix[$i][0][$j][1];
				}

			}
			
			//updated by pornima on 2/12/2024 for getting primary key in reverse order
			// $pkCount = ($_POST['cnt'.$dynamix[$i][1][3]]);
			// if($k_debug) echo "<br />pkCount: " . $pkCount . "<br />";

			for($j = 0; $j < ($_POST['cnt'.$dynamix[$i][1][3]]); $j++){ //LOOPING ON NUMBER OF POSTS PASSED BY FORM
				if(isset($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j])){

					//if(strlen($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j]) >= 0){

					    $t2[$cntt2] = array();

				        $ct2 = 0;

					    // $t2[$cntt2][$ct2] = db::getInstance()->real_escape_string($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j]);

					    for($k = 0; $k < sizeof($dynamix[$i][0]); $k++){	//LOOPING NUMBER OF FIELDS IN THE DYNAMIC

					        if($dynamix[$i][0][$k][0] == 12){   //FOR MEDIA IN GRID

					            if($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j] == 0){
					               	$sql4 = 'SELECT ' . $dynamix[$i][0][$k][1] . ' FROM '. $db.' WHERE '. $t1[0] . ' = '. $t2[$cntt2][0];

					                if($k_debug)    echo "<br/><br/>Check Existing Image Grid - " . $sql4;

                    			    $result4 = db::getInstance()->db_select($sql4);

									if($k_debug) echo "<br>"; print_r($result4);

                    			    if($result4['num_rows'] > 0) {

										$t2[$cntt2][$ct2++] = $result['result_set'][0][$dynamix[$i][0][$k][1]];
									}else{
										//else condition added by pornima if $result4 is empty then issue coming in t2 array image 0 value not adding in t2. updated on 27/03/2025
										$t2[$cntt2][$ct2++] = $_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j];
									}

					            }else{
									//added by pornima for adding image in grid
									// $t2[$cntt2][$ct2++] = $dynamix[$i][1][4];
									$t2[$cntt2][$ct2++] = $_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j];
									
								}

					        }else{
								//if condition Added by pornima on date 19-10-2024 for SqlQueryOnInsert
								if(strlen($dynamix[$i][0][$k][28]) > 5 && $dynamix[$i][0][$k][28] != NULL){
									$searchParamValue = array(
										array('yearcode', $_SESSION['dbYear']),
										array('companyid', $_SESSION['dbCompany']),
										array('divisionid', $_SESSION['dbDivision']),
										array('userid', $_SESSION['user_id']),
										array('formid', $FormID),
										array('editid', $upID)
									);

									$st = $dynamix[$i][0][$k][28];
									foreach ($searchParamValue as $var) {
										// $pattern = '/!' . preg_quote($var[0], '/') . '\b/';
										$pattern = '/!' . preg_quote($var[0], '/') . '(?=[^a-zA-Z0-9]|$)/';
										$st = preg_replace($pattern, $var[1], $st);
									}
									$t2[$cntt2][$ct2++] = '(SqlQueryOnInsert '.$st.')';

								}else{
								
									$t2[$cntt2][$ct2++] = db::getInstance()->real_escape_string($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j]);
								}
					        }

					    }

					    $cntt2++;
						// if(count($dbPK[$i]) > 1){
						// 	array_unshift($t2[$j], $dbPK[$i][$pkCount-1]);
						// 	$pkCount--;
						// }else{
						// 	array_unshift($t2[$j], 0);
						// }

						// array_unshift($t2[$j], $dbPK[0][$j]);

					//}

				}
			}
			
			if($k_debug){ echo "<br/><br/>T1: "; print_r($t1); }

			if($k_debug){ echo "<br/><br/>T2: "; print_r($t2); }

			if($k_debug){ echo "<br/><br/>T3: "; print_r($t3); }

			// Example of dbPK (to simulate data in the database)
			$postPK = $_POST[$dynamix[$i][1][3]."GridEditID"];

			// Flatten dbPK for easier comparison
			$dbPKFlattened = $dbPK[$i];

			// Remove the first element 
			if (is_array($t1) && count($t1) > 0) {
				// $pk = array_shift($t1);
				array_shift($t1);
			}

			// Step 1: DELETE rows from $dbPK that are not in $postPK
			foreach ($dbPKFlattened as $dbValue) {
				if (!in_array($dbValue, $postPK)) {
					// Generate DELETE query for values in dbPK not present in postPK
					if(isset($dbValue)){

						$sql = "DELETE FROM $db WHERE $pk = $dbValue;";
	
						if($k_debug) echo '<br/>CD107: '.$sql.'<br/>';
	
						$result = db::getInstance()->db_update($sql);
	
						if($k_debug) print_r($result);
					}
				}
			}

			// // Step 2: Loop through $postPK and compare with $T2 data
			foreach ($postPK as $index => $primaryKey) {
				// Directly access the corresponding row in T2
				$row = $t2[$index];

				// If primary key is 0, perform INSERT
				if ($primaryKey == 0) {
					$columns = [];
					$values = [];

					// Add the foreign key column and its value
					$columns[] = $fk; // Add the foreign key field to the columns array
					
					// $values[] = $editID == 'null' ? "null" : "'{$editID}'"; // Add the corresponding value for the foreign key
					//The issue occurred when, instead of using the ID, another field was used for the foreign key. In such cases, the above row wasn't working correctly, so this was added to fix it.
					$values[] = $upID == 'null' ? "null" : "'{$upID}'"; 

					// Build columns and values for the INSERT query
					if (is_array($t1) && count($t1) > 0) {
						for ($s = 0; $s < count($t1); $s++) {
							$columns[] = $t1[$s];  // Field names from T1

							if($t3[$s] == 16){
								$values[] = "null";
							}else if($t3[$s] == 6){
								$dateval = empty($row[$s]) ? "NULL" : $row[$s];
								
								if($dateval == 'NULL'){
									// $vals .= ", null";
									$values[] = "null";
								
								}else{
									$values[] = "'{$row[$s]}'";
								}
								
 							}else{
								if($row[$s] == 'null'){
									$values[] = "null";  // Data from T2
								}else{
									if(strpos($row[$s], 'SqlQueryOnInsert') !== false){
										$values[] =  str_replace('SqlQueryOnInsert', '', $row[$s]); 
									}else{
										$values[] = "'{$row[$s]}'";  // Data from T2
									}
								}
							}
						}
					}

					// Add the uniqueid to columns and values
					$columns[] = 'uniqueid';  // Add 'uniqueid' to the columns array
					$values[] = $uniqueQuery;  // Generate a unique ID and add to the values array

					// Generate INSERT query
					$sql = "INSERT INTO $db (" . implode(",", $columns) . ") VALUES (" . implode(",", $values) . ");";

					if($k_debug) echo '<br/>CD107: '.$sql.'<br/>';

					$result = db::getInstance()->db_insertQuery($sql);

					if($k_debug) print_r($result);

					if($result['error'] == 0){
						// Remove 0 elements
						$postPK = array_filter($postPK, function($value) {
							return $value !=='0';
						});

						// Re-index the array (to reset the keys)
						$postPK = array_values($postPK);

						// Add an element at the beginning
						array_unshift($postPK,$result['last_id']);
					}
				
				}
				// If primary key exists in both $dbPK and $postPK, perform UPDATE
				elseif (is_array($dbPKFlattened) && in_array($primaryKey, $dbPKFlattened)) {
					$setFields = [];
					
					if (is_array($t1) && count($t1) > 0) {
						for ($p = 0; $p < count($t1); $p++) {
							if($t3[$p] == 16){
								$values[] = "null";
							}else if($t3[$p] == 6){
								$dateval = empty($row[$p]) ? "NULL" : $row[$p];
								
								if($dateval == 'NULL'){
									// $vals .= ", null";
									$setFields[] = "{$t1[$p]} = null";
								
								}else{
									$setFields[] = "{$t1[$p]} = '{$row[$p]}'";;
								}
								
 							}else{
								if(strpos($row[$p], 'SqlQueryOnInsert') == false){
									if ($row[$p] !== null) {
										$setFields[] = "{$t1[$p]} = '{$row[$p]}'";
									} else {
										$setFields[] = "{$t1[$p]} = NULL";  // If value is null, set to NULL
									}
								}
							}
						}
					}
					
					// Generate UPDATE query for the row
					$sql = "UPDATE $db SET " . implode(",", $setFields) . " WHERE ".$pk ." = {$primaryKey};";

					if($k_debug) echo '<br/>CD107: '.$sql.'<br/>';

					$result = db::getInstance()->db_insertQuery($sql);

					if($k_debug) print_r($result);
				
				}
			}

			$postGridRowPK[] = $postPK;
			//echo "<br/>************************************************<br/>";
		}
	}
	
	//CODE FOR GRID MULTIPLE MANY TO MANY RELATION MAPPING TABLE CODE 11 & 13 & 9 & 16
	for($i = 0; $i < $gmdb; $i++){	 //SAMPLE USED IN model-vendor.ph

		$mapArray = $moreextradb[$mappingGridId[$i]][$gm2mdb[$i]];
		$mapTable = $mapArray[5];
		$mapIndex = $mapArray[6];
		$mapVariant = $mapArray[7];
		$SerialNo = $ExistSerialArray[$i];

		// Find elements in $dbPK that are not in $postGridRowPK
		// if (isset($postGridRowPK[$i]) && is_array($postGridRowPK[$i]) && sizeof($postGridRowPK[$i]) > 0 && isset($dbPK[$i]) && is_array($dbPK[$i]) && sizeof($dbPK[$i]) > 0) {

		// 	$diffDb = array_diff($dbPK[$i], $postGridRowPK[$i]);

		// 	$diffDb = array_values($diffDb); // Reindex array if necessary

		// 	for($m=0; $m < sizeof($diffDb); $m++){
		// 		$query2 = "DELETE FROM ". $mapTable . " WHERE " . $mapIndex . " = " . $diffDb[$m];
		// 		if($k_debug) echo "<br/><br>DELETE QUERY ".$query2;
		// 		$result = db::getInstance()->db_update($query2);
		// 	}
		// }


		if (isset($_POST[$ExistSerialArray[$i].$gm2mdb[$i]]) && is_array($_POST[$ExistSerialArray[$i].$gm2mdb[$i]]) && sizeof($_POST[$ExistSerialArray[$i].$gm2mdb[$i]]) > 0) {
			for($j=0; $j<sizeof($_POST[$ExistSerialArray[$i].$gm2mdb[$i]]); $j++){
				
				if(strlen($_POST[$ExistSerialArray[$i].$gm2mdb[$i]][$j]) > 0){
					$postGridRowCnt = array_search($ExistSerialArray[$i], $serials);
					
					// if(sizeof($postGridRowPK[$i]) > 0){
					if (isset($postGridRowPK[$postGridRowCnt]) && is_countable($postGridRowPK[$postGridRowCnt]) && sizeof($postGridRowPK[$postGridRowCnt]) > 0) {
						// if (isset($postGridRowPK[$i]) && is_countable($postGridRowPK[$i]) && sizeof($postGridRowPK[$i]) > 0) {
						$mapValues = explode(',', $_POST[$ExistSerialArray[$i].$gm2mdb[$i]][$j]);

						// Step 1: Check if the foreign key exists in the mapping table
						$query1 = "SELECT $mapVariant FROM $mapTable WHERE $mapIndex = ".$postGridRowPK[$postGridRowCnt][$j];
						$checkExistIds = db::getInstance()->db_select($query1);


						// Extract the mapVariant values into a new array
						$existIds = array_map(function($item) use ($mapVariant) {
							return $item[$mapVariant]; // Accessing the value using the key in $mapVariant
						}, $checkExistIds['result_set']);

						$postIds = explode(",",$_POST[$ExistSerialArray[$i].$gm2mdb[$i]][$j]);

						// Case 1: If both arrays are the same, do nothing

						// Case 2: If both arrays are not same
						if ($existIds !== $postIds) {
							// Step 2: Insert new records from $postIds that are not in $existIds
							$newIds = array_diff($postIds, $existIds); // Find new IDs that need to be inserted
							foreach ($newIds as $newId) {
								// Insert new record
								if($k_debug) echo "<br/><br>INSERT INTO ". $mapTable ."-". $mapIndex ."-". $mapVariant ."-". $postGridRowPK[$postGridRowCnt][$j] ."-". $newId;
								$result = db::getInstance()->db_insert($mapTable, array($mapIndex, $mapVariant),array($postGridRowPK[$postGridRowCnt][$j], $newId));
								if($k_debug) echo "<br/><br>INSERT QUERY RESULT"; print_r($result);
							}

							// Step 3: Delete records from $existIds that are not in $postIds
							$toDelete = array_diff($existIds, $postIds); // Find IDs to delete
							if (!empty($toDelete)) {
								foreach($toDelete as $deleteId){
									$query2 = "DELETE FROM ". $mapTable . " WHERE " . $mapIndex . " = " . $postGridRowPK[$postGridRowCnt][$j] ." AND ". $mapVariant . "=". $deleteId;
									if($k_debug) echo "<br/><br>DELETE QUERY ".$query2;
									$result = db::getInstance()->db_update($query2);
								}
							}
						}
					}
					
				}
			}
		}
	}

	//echo "::::::::DD103" . $mdb;
	//CD104 	//DELETE ALL MANY TO MANY ENTRIES FOR CODE 10
	for($i = 0; $i < $m; $i++){	

		$mapArray = $extradb[((-1)*$code[$many2many[$i]][3])-1][5];

		$mapTable = $mapArray[0];

		$mapIndex = $mapArray[1];

		$mapVariant = $mapArray[2];

		$mapValues = $_POST[$code[$many2many[$i]][0]];

		if($mapValues){
			for($j = 0; $j < sizeof($mapValues); $j++){		

				if($k_debug) echo '<br/> CD104: '. $sql = 'DELETE FROM '. $mapTable.' WHERE '. $mapIndex . ' = '. $editID;

				$result = db::getInstance()->db_update($sql);

			}
		}

		//print_r($mapValues); exit();

	}

	//CD105		//DELETE ALL MANY TO MANY ENTRIES IN MAPPING TABLE (number 11, 9, 16)
	for($i = 0; $i < $mdb; $i++){
		
	    if($m2mdbtype[$i] == 11 || $m2mdbtype[$i] == 9 || $m2mdbtype[$i] == 16){
			
    		$mapArray = $extradb[((-1)*$code[$m2mdb[$i]][3])-1];

    		$mapTable = $mapArray[6];

    		$mapIndex = $mapArray[7];
			
    		$mapVariant = $mapArray[8];
			
    		$mapValues = $_POST[$code[$m2mdb[$i]][0]];
			
    		//echo "<br />";
			
    		//print_r($mapValues);
			
    		//echo "<br />";
			
    		// print_r($mapArray);
			
    		//print_r($mapValues);
			
    		// commented as required to delete only once for($j = 0; $j < sizeof($mapValues); $j++){		

				$sql = 'DELETE FROM '. $mapTable.' WHERE '. $mapIndex . ' = '. $editID;
				
    			if($k_debug)  echo '<br/>CD105:'. $sql;
				
    			$result = db::getInstance()->db_update($sql);

    			if($k_debug) print_r($result);
				
				//}
				
				//print_r($mapValues); exit();
				
			}

	}

	//CD106		//DELETE ALL MOREDB ENTRIES
	/*for($i = 0; $i < sizeof($dynamix); $i++){

		$db = $dynamix[$i][1][0];

		$fk = $dynamix[$i][1][1];

		$sql = 'DELETE FROM '. $db.' WHERE '. $fk . ' = '. $editID;

		if($k_debug) echo '<br/>CD106: '.$sql.'<br/>';

		//$result = db::getInstance()->db_update($sql);

		//if($k_debug) print_r($result);

	}*/

	//CD101  //CODE FOR MULTIPLE MANY TO MANY RELATION MAPPING TABLE CODE 10
	for($i = 0; $i < $m; $i++){	
		
		$mapArray = $extradb[((-1)*$code[$many2many[$i]][3])-1][5];

		$mapTable = $mapArray[0];

		$mapIndex = $mapArray[1];

		$mapVariant = $mapArray[2];

		$mapValues = $_POST[$code[$many2many[$i]][0]];

		if($mapValues){
			for($j = 0; $j < sizeof($mapValues); $j++)	{	

				if($k_debug) echo "<br/>CD101: INSERT INTO ". $mapTable.$mapTable . $mapIndex . $mapVariant . $editID . $mapValues[$j];

				$result = db::getInstance()->db_insert($mapTable, array($mapIndex, $mapVariant),array($editID, $mapValues[$j]));

				if($k_debug) print_r($result);

			}
		}

	}

	//CD102		//CODE FOR MULTIPLE MANY TO MANY RELATION MAPPING TABLE CODE 11 & 13 & 9
	for($i = 0; $i < $mdb; $i++){	 //SAMPLE USED IN model-vendor.php
		
		$mapArray = $extradb[((-1)*$code[$m2mdb[$i]][3])-1];
		
		$mapTable = $mapArray[6];
		
		$mapIndex = $mapArray[7];
		
		$mapVariant = $mapArray[8];

		
		if(!is_array($_POST[$code[$m2mdb[$i]][0]])){ 

		    if(strlen($_POST[$code[$m2mdb[$i]][0]]) > 0)    $mapValues = explode(',', $_POST[$code[$m2mdb[$i]][0]]);

		    else $mapValues = array();

		}else { $mapValues = $_POST[$code[$m2mdb[$i]][0]]; }

		//echo "<br />";
		
		//print_r($mapValues);

		//echo "<br />";

		//print_r($mapArray);

		for($j = 0; $j < sizeof($mapValues); $j++){

		    if($mapValues[$j] > 0){

    			if($k_debug)

    				echo "<br/>CD102:	INSERT INTO " . $mapTable ." (" . $mapIndex .",". $mapVariant .") VALUES(" . $editID .",". $mapValues[$j].")";

    			$result = db::getInstance()->db_insert($mapTable, array($mapIndex, $mapVariant),array($editID, $mapValues[$j]));

    			if($k_debug) print_r($result);

		    }

		}

	}

	//CD103 	//COMMON DYNAMIC FIELDS INSERT
	/*for($i = 0; $i < sizeof($dynamix); $i++){ //LOOPING ALL THE DYNAMIC ARRAYS

		$db = $dynamix[$i][1][0];

		$fk = $dynamix[$i][1][1];

		$sql = "INSERT INTO ". $db . " (".$fk."";

		for($j = 0; $j < sizeof($dynamix[$i][0]); $j++){ //LOOPING ON FIELDS

			$sql .= "," . $dynamix[$i][0][$j][1];

		}

		$sql = $sql . " ) VALUES";

		$vals = "";

		for($j = 0; $j < ($_POST['cnt'.$dynamix[$i][1][3]]); $j++){ //LOOPING ON NUMBER OF POSTS PASSED BY FORM

			if(isset($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j])){

				if(strlen($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j]) > 0){

					$vals .= "(".$editID ;

					for($k = 0; $k < sizeof($dynamix[$i][0]); $k++){	//LOOPING NUMBER OF FIELDS IN THE DYNAMIC

						$vals .= ", '". db::getInstance()->real_escape_string($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j]) ."'";

					}

					$vals .= "),";

				}

			}

		}

		$sql = $sql . substr($vals, 0, -1);

		//if($k_debug) echo '<br/>CD103: '.$sql.'<br/>';

		//$result = db::getInstance()->db_insertQuery($sql);

		//if($k_debug) print_r($result);

	}*/

	

	//exit();

	//Sp call after form submit added by pornima on 2-8-2024
	$SPName = 'sp_afterupdate_'.$FormID;
	$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
	$sqlresult = db::getInstance()->db_select($sql);
	
	if($sqlresult['result_set'][0]['found'] == 1){
		$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';

		$data['params'] = ['@updatedid','@userid','@session'];
		$sp['values'] = [$editID,$user_id,"'$session'"];
		$result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
		// if($_SESSION['user_id'] == 1020){

		// 	print_r($result);
		// 	exit();
		// }
		// exit();
	}

}else{
	
	//INSERT	
	$_POST['CreatedBy'] = $CreatedBy;
	$_POST['CreatedAt'] = $CreatedAt;
	$_POST['CompanyId'] = $CompanyId;
	$_POST['DivisionId'] = $DivisionId;
	$_POST['YearCode'] = $YearCode;
	// $_POST['moduleid'] = $ModuleId;
	$_POST['uniqueid'] = $uniqueQuery;
	
	array_push($code, array('CreatedBy',1,''.'CreatedBy','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',$_SESSION['user_id']),array('CreatedAt',6,''.'CreatedAt','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''));

	//If Module type transaction then add below fields into table
	// if($viewSettings[12] == 2){
		array_push($code, array('CompanyId',1,''.'CompanyId','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('DivisionId',1,''.'DivisionId','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('YearCode',1,''.'YearCode','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('FormID',1,'','FormID','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),array('uniqueid',1,'','uniqueid','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''));
		// ,array('moduleid',1,''.'moduleid','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',''),
	// }

	$Grids=array();
	for($i = 0; $i < sizeof($serials); $i++){
		if(isset($_POST['GridId' . $serials[$i]])){
			$Grids[$i] = array();
			$Grids[$i]['var'] = $serials[$i];
			// $Grids[$i]['cnt'] = $_POST['cnt' . $serials[$i]]; //gives issue if cnt is different than grid rows cnt
			$Grids[$i]['cnt'] = sizeof($_POST[$serials[$i] . 'GridTempID']) - 1;
			$_POST['cnt' . $serials[$i]] = $Grids[$i]['cnt']; //due to issues of ct not coming same
			
			for($j = 0; $j < $Grids[$i]['cnt']; $j++){
				$_POST[$serials[$i] . 'CreatedBy'][$j] = $CreatedBy;
				$_POST[$serials[$i] . 'CreatedAt'][$j] = $CreatedAt;
				$_POST[$serials[$i] . 'CompanyId'][$j] = $CompanyId;
				$_POST[$serials[$i] . 'DivisionId'][$j] = $DivisionId;
				$_POST[$serials[$i] . 'YearCode'][$j] = $YearCode;
				// $_POST[$serials[$i] . 'moduleid'][$j] = $ModuleId;
				$_POST[$serials[$i] . 'FormID'][$j] = $FormID;

			}
		}
	}
	if($k_debug) print_r($_POST);
	
	$set = array();

	$val = array();

	$k = 0;

	for($i = 0; $i<sizeof($code); $i++){
			

		if($code[$i][1] == 14 || $code[$i][7] == 0){ //If Grid or If Display order = 0

		

		}else{

			if($code[$i][1] == 10){ //FOR MANY TO MANY MAPPING 

				$many2many[$m++] = $i;

			}else{

			    //FIELD 9 MULTICHECKBOX ADDED FOR CAPAPI
				
				if($code[$i][1] == 9 || $code[$i][1] == 11 || $code[$i][1] == 13 || $code[$i][1] == 16){ //FOR MANY TO MANY MAPPING IN OTHER TABLE & for Multiple Images

					$m2mdb[$mdb++] = $i;

					if($code[$i][1] == 13){

						for($l = 0; $l<$mf; $l++){	

							if($mediaFields[$l]['CodeArray'] == $i){

								$_POST[$code[$i][0]] = $mediaFields[$l]['MediaId'];

								break;

							}

						}

					}

				}else{

					if($code[$i][1] == 12){ //SINGLE IMAGE UPLOAD

						if($k_debug) echo "<br /><br />*-*-*-*-*-*-" . $i;

						$val[$k] = 0;

						for($l = 0; $l<$mf; $l++){

							//if($k_debug) echo "<br />" . $mediaFields[$l]['CodeArray'];

							if($mediaFields[$l]['CodeArray'] == $i){

								$val[$k] = $mediaFields[$l]['MediaId'][0];

								break;

							}

						}

					}else{
					
						if($code[$i][1] != 21 && $code[$i][1] != 22 && $code[$i][1] != 23 && $code[$i][1] != 25 && $code[$i][1] != 24){

							//Added by pornima on date 8-8-2024 for SqlQueryOnInsert
							if(strlen($code[$i][38]) > 5){
						
								if(strlen($_POST[$code[$i][0]]) > 0){
									$val[$k] = isset($_POST[$code[$i][0]]) ? db::getInstance()->real_escape_string($_POST[$code[$i][0]]) : "";
								}else{

									$st = $code[$i][38];
									$searchParamValue = array(
										array('yearcode', $_SESSION['dbYear']),
										array('companyid', $_SESSION['dbCompany']),
										array('divisionid', $_SESSION['dbDivision']),
										array('userid', $_SESSION['user_id']),
										array('formid', $FormID),
										array('registerid', isset($_POST['registerid']) ? $_POST['registerid'] : 0),
										array('reg', isset($_POST['reg']) ? $_POST['reg'] : 0),
										array('editid',$editID)
									);
									foreach ($searchParamValue as $var) {
										// $pattern = '/!' . preg_quote($var[0], '/') . '\b/';
										$pattern = '/!' . preg_quote($var[0], '/') . '(?=[^a-zA-Z0-9]|$)/';
										$st = preg_replace($pattern, $var[1], $st);
									}
									// echo "pornima<br />*************2".$st;
									$val[$k] = "(SqlQueryOnInsert ".$st.")";
								}
								
							}else{
								// $val[$k] = isset($_POST[$code[$i][0]]) ? db::getInstance()->real_escape_string($_POST[$code[$i][0]]) : "";
								// echo "<br>".trim($code[$i][0]). " == ".$_POST[trim($code[$i][0])];
								$val[$k] = isset($_POST[trim($code[$i][0])]) ? $_POST[trim($code[$i][0])] : "";

								if($val[$k] == 'null'){
									$val[$k] = null;
								}else{
									$val[$k] = $val[$k] ;
								}

							}	
							
							$val[$k] = str_replace("<script>", "",$val[$k]);      //ADDED FOR VAPT 

							$val[$k] = str_replace("</script>","",$val[$k]);      //ADDED FOR VAPT

							$val[$k] = str_replace("</","",$val[$k]);          //ADDED FOR VAPT 

							$val[$k] = str_replace("><","",$val[$k]);          //ADDED FOR VAPT 

							$val[$k] = str_replace("onerror","",$val[$k]);     //ADDED FOR VAPT 
						}
					}

					if($code[$i][1] != 21 && $code[$i][1] != 22 && $code[$i][1] != 23 && $code[$i][1] != 25 && $code[$i][1] != 24){
						$set[$k] = $code[$i][0];

						$k++;
					}

				}

			}

		}

	}
	

	if($k_debug) echo "<br /><br />INSERT INTO VALS=> ";
	if($k_debug) print_r($val);
	
	// exit();
	$result = db::getInstance()->db_insert($db[0],$set,$val);
	// $result['last_id'] = 99999;
	if($k_debug) print_r($result); 

	
	$editID = $result['last_id'];

	//CODE FOR MULTIPLE MANY TO MANY RELATION MAPPING TABLE CODE 10

	for($i = 0; $i < $m; $i++){	

		$mapArray = $extradb[((-1)*$code[$many2many[$i]][3])-1][5];

		$mapTable = $mapArray[0];

		$mapIndex = $mapArray[1];

		$mapVariant = $mapArray[2];

		$mapValues = $_POST[$code[$many2many[$i]][0]];

		if($mapValues){

			for($j = 0; $j < sizeof($mapValues); $j++)	{	
	
				$result = db::getInstance()->db_insert($mapTable, array($mapIndex, $mapVariant),array($editID, $mapValues[$j]));
	
			}
		}

	}

    // 	echo "*****************";

    // 	print_r($extradb);

    	// echo "*****************";
    	// print_r($mdb);
	// print_r($m2mdb);


	//FIELD 9 MULTICHECKBOX ADDED FOR CAPAPI

	//CODE FOR MULTIPLE MANY TO MANY RELATION MAPPING TABLE CODE 11 & 13 & 16

	for($i = 0; $i < $mdb; $i++){	 //SAMPLE USED IN model-vendor.php
		
		$mapArray = $extradb[((-1)*$code[$m2mdb[$i]][3])-1];

		$mapTable = $mapArray[6];

		$mapIndex = $mapArray[7];

		$mapVariant = $mapArray[8];

		// 		echo "<br />DATA: "; print_r($_POST[$code[$m2mdb[$i]][0]]);

		if(!is_array($_POST[$code[$m2mdb[$i]][0]])){ 

		    if(strlen($_POST[$code[$m2mdb[$i]][0]]) > 0)    $mapValues = explode(',', $_POST[$code[$m2mdb[$i]][0]]);

		    else $mapValues = array();

		}else { $mapValues = $_POST[$code[$m2mdb[$i]][0]]; }

		// 		echo "<br />".print_r($mapArray)."<br />";

		// 		echo "<br />".print_r($mapValues)."<br />";

		for($j = 0; $j < sizeof($mapValues); $j++){

			if($k_debug) echo "<br/>INSERT INTO ". $mapTable ."-". $mapIndex ."-". $mapVariant ."-". $editID ."-". $mapValues[$j];

			$result = db::getInstance()->db_insert($mapTable, array($mapIndex, $mapVariant),array($editID, $mapValues[$j]));

			print_r($result);

		}

	}

	

	//COMMON DYNAMIC FIELDS INSERT
	
	if($k_debug) echo "<br/><br/>"; 

	if($k_debug) print_r($dynamix);
	$mainDB = $db;
	
	for($i = 0; $i < sizeof($dynamix); $i++){ //LOOPING ALL THE DYNAMIC ARRAYS
		
		//CreatedBy & CreatedAt added in dynamix
		array_push($dynamix[$i][0], array(1,'CreatedBy','CreatedBy','','','','','','','','','','','','','','','','','','','',''),array(1,'CreatedAt','CreatedAt','','','','','','','','','','','','','','','','','','','','',''),array(1,'CompanyId','CompanyId','','','','','','','','','','','','','','','','','','','','',''),array(1,'DivisionId','DivisionId','','','','','','','','','','','','','','','','','','','','',''),array(1,'YearCode','YearCode','','','','','','','','','','','','','','','','','','','','',''),array(1,'FormID','FormID','','','','','','','','','','','','','','','','','','','','',''));
		//,array(1,'moduleid','moduleid','','','','','','','','','','','','','','','','','','','','','')

		$db = $dynamix[$i][1][0];

		$fk = $dynamix[$i][1][1];
		$sq = "SELECT " . $dynamix[$i][1][5] . " FROM " . $mainDB[0] . " WHERE " . $mainDB[1] . " = " . $editID;
		$rs = db::getInstance()->db_select($sq);
		$upID = $rs['result_set'][0][$dynamix[$i][1][5]];
		if($k_debug) echo "<br /><br />";;
		if($k_debug) echo "<br />==>>><<<==";
		// if($k_debug) print_r($dynamix[$i]);
		// if($k_debug) echo "<br />";
		if($k_debug) echo $sq;
		if($k_debug) echo "<br />";
		if($k_debug) print_r($rs);
		if($k_debug) echo "<br />";
		if($k_debug) echo "<br />";
		$sql = "INSERT INTO ". $db . " (".$fk."";

		for($j = 0; $j < sizeof($dynamix[$i][0]); $j++){ //LOOPING ON FIELDS

			$sql .= "," . $dynamix[$i][0][$j][1];

		}

		$sql .= ", uniqueid";

		$sql = $sql . " ) VALUES";

		$vals = "";

		$dynamixflag  = false;
		

		for($j = 0; $j < ($_POST['cnt'.$dynamix[$i][1][3]]); $j++){ //LOOPING ON NUMBER OF POSTS PASSED BY FORM

			if(isset($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j])){

			    //echo "<br/>". $j." -".$_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j];

				// if(strlen($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j]) > 0){	//REMOVED validation of the first field as the grid style has changed

					$dynamixflag = true;

					$vals .= "(".$upID ;

					for($k = 0; $k < sizeof($dynamix[$i][0]); $k++){	//LOOPING NUMBER OF FIELDS IN THE DYNAMIC

						// $vals .= ", '". db::getInstance()->real_escape_string($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j]) ."'";
						//if condition Added by pornima on date 18-10-2024 for SqlQueryOnInsert
						
						if(strlen($dynamix[$i][0][$k][28]) > 5){
					
							if(strlen($dynamix[$i][0][$k][28]) > 5 && $dynamix[$i][0][$k][28] != NULL){

								$st = $dynamix[$i][0][$k][28];
								$searchParamValue = array(
									array('yearcode', $_SESSION['dbYear']),
									array('companyid', $_SESSION['dbCompany']),
									array('divisionid', $_SESSION['dbDivision']),
									array('userid', $_SESSION['user_id']),
									array('formid', $FormID),
									array('editid',$upID)
								);
								foreach ($searchParamValue as $var) {
									// $pattern = '/!' . preg_quote($var[0], '/') . '\b/';
									$pattern = '/!' . preg_quote($var[0], '/') . '(?=[^a-zA-Z0-9]|$)/';
									$st = preg_replace($pattern, $var[1], $st);
								}
								// echo "<br />*************2".$st;
								$vals .= ", (".$st.")";
							}
						}else{
							//if condition updated by pornima for field type 9,11,,13 & 16
							if($dynamix[$i][0][$k][0] == 9 || $dynamix[$i][0][$k][0] == 11 || $dynamix[$i][0][$k][0] == 13 ||$dynamix[$i][0][$k][0] == 16){ //FOR MANY TO MANY MAPPING IN OTHER TABLE
								// Concatenate the two values (this is just an example of what you're doing)
								$elementToAdd =  $dynamix[$i][0][$k][1];

								// Check if the element already exists in $gm2mdb before adding it
								if (!in_array($elementToAdd, $gm2mdb)) {
									$gm2mdb[$gmdb++] = $dynamix[$i][0][$k][1]; // dbFieldName
									array_push($ExistSerialArray,$dynamix[$i][1][3]); //Serial No
									array_push($mappingGridId,$dynamix[$i][1][7]); // Grid Id
								}
								
								$vals .= ", null";
							}else if($dynamix[$i][0][$k][0] == 6){
								
								$dateval = empty($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j]) ? "NULL" : $_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j];
								
								if($dateval == 'NULL'){
									$vals .= ", null";
								
								}else{
									$vals .= ", '".db::getInstance()->real_escape_string($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j])."'";
									
								}
								
							}else{
								if(db::getInstance()->real_escape_string($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j]) == 'null'){
									$vals .= ", null";
								}else{
									$vals .= ", '".db::getInstance()->real_escape_string($_POST[$dynamix[$i][1][3].$dynamix[$i][0][$k][1]][$j])."'";
								}
							}
						}
					}

					$vals .= ",".$uniqueQuery; 

					$vals .= "),";

				// }

			}

		}

		$sql = $sql . substr($vals, 0, -1);
		
		if($dynamixflag){

    		if($k_debug) echo '<br/> CD201: '. $sql;

    		$result = db::getInstance()->db_insertQuery($sql);
    		if($k_debug) print_r($result);

			//updated by pornima for getting last inserted id
			//get count of insert query
			// Regular expression to count occurrences of a row (based on the `VALUES` keyword)
			preg_match_all('/\(\d+,.*?\)/', $sql, $matches);

			// Output the count of rows
			$rowsAffected = count($matches[0]);

			$lastid = $result['last_id'];

			//Not getting inserted id so using select query getting this
			$query4 = "SELECT TOP $rowsAffected id FROM $db WHERE $fk = $upID AND CreatedBy= '{$_SESSION['user_id']}' OR UpdatedBy= '{$_SESSION['user_id']}' ORDER BY id DESC ";
			$query4Result = db::getInstance()->db_select($query4);


			// Extract the result from query4Result and push the ids to the $GridPK array
			if (isset($query4Result['result_set'])) {
				// Temporary array to hold the IDs
				$tempArray = [];
		
				// Iterate over the result_set and extract the ids
				foreach ($query4Result['result_set'] as $item) {
					$tempArray[] = $item['id'];  // Add each id to the temporary array
				}
		
				// After extracting all ids, push the tempArray into $GridPK
				if (count($tempArray) > 0) {
					$GridPK[] = $tempArray;
				}
			}

		}	
	}	


	
	// for($i = 0; $i < $gmdb; $i++){	 //SAMPLE USED IN model-vendor.php

	// 	$mapArray = $moreextradb[$gm2mdb[$i]];
	// 	$mapTable = $mapArray[5];
	// 	$mapIndex = $mapArray[6];
	// 	$mapVariant = $mapArray[7];
	// 	// $SerialNo = $ExistSerialArray[$i];
	// 	$postGridRowCnt = array_search($ExistSerialArray[$i], $serials);
	// 	echo "<br>postGridRowCnt ".$postGridRowCnt;
	// 	print_r($postGridRowCnt);
	// 	if (isset($GridPK[$postGridRowCnt]) && is_array($GridPK[$postGridRowCnt])) {
	// 		$GridRowPK = array_reverse($GridPK[$postGridRowCnt]);
	// 	} else {
	// 		// Handle the case where it's null or not an array
	// 		$GridRowPK = []; // or handle error/log it
	// 	}
	// 	// $GridRowPK = array_reverse($GridPK[$i]);

	// 	echo "<br>GridRowPK";
	// 	print_r($GridRowPK);

	// 	for($j=0; $j<sizeof($_POST[$ExistSerialArray[$i].$gm2mdb[$i]]); $j++){
	// 		if(strlen($_POST[$ExistSerialArray[$i].$gm2mdb[$i]][$j]) > 0){
	// 			$postGridRowCnt = array_search($ExistSerialArray[$i], $serials);
	// 			$mapValues = explode(',', $_POST[$ExistSerialArray[$i].$gm2mdb[$i]][$j]);
				
	// 			for($k = 0; $k < sizeof($mapValues); $k++){
	// 				if($k_debug) echo "<br/><br>INSERT INTO ". $mapTable ."-". $mapIndex ."-". $mapVariant ."-". $GridRowPK[$postGridRowCnt] ."-". $mapValues[$k];
		
	// 				$result = db::getInstance()->db_insert($mapTable, array($mapIndex, $mapVariant),array($GridRowPK[$postGridRowCnt], $mapValues[$k]));
	// 			}	
	// 		}
	// 	}
		
	// }

	//CODE FOR GRID MULTIPLE MANY TO MANY RELATION MAPPING TABLE CODE 11 & 13 & 16
	for($i = 0; $i < $gmdb; $i++){	 //SAMPLE USED IN model-vendor.php

		$mapArray = $moreextradb[$mappingGridId[$i]][$gm2mdb[$i]];
		$mapTable = $mapArray[5];
		$mapIndex = $mapArray[6];
		$mapVariant = $mapArray[7];
		$postGridRowCnt = array_search($ExistSerialArray[$i], $serials);

		if (isset($GridPK[$postGridRowCnt]) && is_array($GridPK[$postGridRowCnt])) {
			$GridRowPK = array_reverse($GridPK[$postGridRowCnt]);
		} else {
			// Handle the case where it's null or not an array
			$GridRowPK = []; // or handle error/log it
		}

		for($j=0; $j<sizeof($_POST[$ExistSerialArray[$i].$gm2mdb[$i]]); $j++){
			if(strlen($_POST[$ExistSerialArray[$i].$gm2mdb[$i]][$j]) > 0){
				$mapValues = explode(',', $_POST[$ExistSerialArray[$i].$gm2mdb[$i]][$j]);

				for($k = 0; $k < sizeof($mapValues); $k++){
					if($k_debug) echo "<br/><br>INSERT INTO ". $mapTable ."-". $mapIndex ."-". $mapVariant ."-". $GridRowPK[$j] ."-". $mapValues[$k];
		
					$result = db::getInstance()->db_insert($mapTable, array($mapIndex, $mapVariant),array($GridRowPK[$j], $mapValues[$k]));
					
				}	
			}
		}
		
	}


	//Sp call after form submit added by pornima on 2-8-2024
	$SPName = 'sp_aftersave_'.$FormID;
	$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
	$sqlresult = db::getInstance()->db_select($sql);
	
	if($sqlresult['result_set'][0]['found'] == 1){
		$session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';

		$data['params'] = ['@insertedid','@userid','@session'];
		$sp['values'] = [$editID,$user_id,"'$session'"];
		$result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
		// print_r($result);
		// exit();
	}

}

	if($k_debug) echo $saveButton;
	if($k_debug) exit();

	$edited = 0;
	if ($editID > 0) $edited = 1;
	else $edited = 2;

    //echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'?view=1&save='.$edited.'";</script>';
	unset($_SESSION['carryOn']);
	if($saveButton == "SaveAddMore" || $saveButton == "UpdateAddMore"){ //redirect on click button SaveAddMore
		$CarryOnField = '';
		$arrayField = [];
		for($i=0; $i < sizeof($code); $i++){
			if($code[$i][30] == 1){
				$CarryOnFieldVal = isset($_POST[$code[$i][0]]) ? ($_POST[$code[$i][0]]) : "";
				$CarryOnField .= '&'.$code[$i][0].'='.$CarryOnFieldVal.'';
			}
		}
		for($i = 0; $i < sizeof($dynamix); $i++){ //LOOPING ALL THE DYNAMIC ARRAYS
			for($j = 0; $j < ($_POST['cnt'.$dynamix[$i][1][3]]); $j++){ //LOOPING ON NUMBER OF POSTS PASSED BY FORM		
				if($dynamix[$i][0][$j][16] == 1){
					if(isset($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j])){
						// echo "<br>".$dynamix[$i][1][3].$dynamix[$i][0][$j][1];
						if(strlen($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j]) > 0){
							$CarryOnField .= '&'.trim($dynamix[$i][1][3].$dynamix[$i][0][$j][1])."=".$_POST[$dynamix[$i][1][3].$dynamix[$i][0][$j][1]][$_POST['cnt'.$dynamix[$i][1][3]]-1];
						}
					}
				}else if($dynamix[$i][0][$j][16] == 2){
					if(isset($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j])){
						// echo "<br>".$dynamix[$i][1][3].$dynamix[$i][0][$j][1];
						if(strlen($_POST[$dynamix[$i][1][3].$dynamix[$i][0][0][1]][$j]) > 0){
							$CarryOnField .= '&'.trim($dynamix[$i][1][3].$dynamix[$i][0][$j][1])."=".$_POST[$dynamix[$i][1][3].$dynamix[$i][0][$j][1]][$_POST['cnt'.$dynamix[$i][1][3]]-1];
						}
					}
				}
			}
		}
		// echo $CarryOnField;
		echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].''.$CarryOnField.'";</script>';
	}elseif($saveButton == "SaveAndPreview"){
		if(isset($_POST['adjustmentFormId']) && strlen($_POST['adjustmentFormId']) > 3 && $_POST['adjustmentFormId'] != 4921 && $FormID == 4921){
			$adjustmentFormId = $_POST['adjustmentFormId'];
			$url = $_SERVER['HTTP_REFERER'] ?? 'fallback.php';
			$referer = preg_replace('/(form=)\d+/', '${1}' . $adjustmentFormId, $url);
			$delimiter = (strpos($referer, '?') !== false) ? '&' : '?';
			
			header("Location: " . $referer . $delimiter . "preview=" . $_POST['entryid']);
			exit();
		}else{
			$referer = $_SERVER['HTTP_REFERER'] ?? 'fallback.php';
			$delimiter = (strpos($referer, '?') !== false) ? '&' : '?';
			header("Location: " . $referer . $delimiter . "preview=" . $editID);
			exit;
		}
		// echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'&preview='.$editID.'";</script>';
	}else{		
		echo '<script>window.location="'.$_SERVER['HTTP_REFERER'].'&view=1&save='.$edited.'";</script>';
	}
	exit();	
?>
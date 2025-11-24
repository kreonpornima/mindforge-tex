<?php 

	//Reqd for More Grid ID Section Identifier. Also Reqd for View mode serials

	$serials = array("a", "b", "c", "d", "e", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "aa", "ab", "ac", "ad", "ae", "af", "ag", "ah", "aj", "ak", "al", "am", "an", "ap", "aq", "ar", "au", "av", "aw", "ax", "ay", "az");


	$MainDBTable = array(
		"AiCompany",
		"AiDivision",
		"AiGroup",
		"AiGroupLicense",
		"AiGroupProductAccess",
		"AiProductCategory",
		"AiReg",
		"AiYear",
		"CompanyRoleAccess",
		"kgridfields",
		"kmainfields",
		"kmainforms",
		"kmaingrid","kmainmedia","kpageaccess",
"kreport_datagrid_data","kreport_pivot_data","kReportFields","kReportFielters","kReportHeader","master_fieldtype","Master_ModuleType","pageroleaccesss","pagerolemaster","users");



	$metaConfig = array(

				"kmainforms", 		//0 - Form Table				

				"FormId", 			//1 - Form Table PK

				"kmainfields", 		//2 - Fields Table

				"FormId", 			//3 - Fields Table F-K

				"kgridfields", 		//4 - Grid Fields Table

				"GridId", 			//5 - Grid Fields Table F-K

				"kmaingrid", 		//6 - Grid Fields Main Table

				"GridId", 			//7 - Grid Fields Main Table PK

				);

				

	/*	$metaConfig = array(

				"kMainForms", 		//0 - Form Table				

				"FormId", 			//1 - Form Table PK

				"kMainFields", 		//2 - Fields Table

				"FormId", 			//3 - Fields Table F-K

				"kGridFields", 		//4 - Grid Fields Table

				"GridId", 			//5 - Grid Fields Table F-K

				"kMainGrid", 		//6 - Grid Fields Main Table

				"GridId", 			//7 - Grid Fields Main Table PK

				);

				*/



		$FormID = isset($FormID) ? $FormID : 0;
			
		if($FormID == 0){

			echo "No Model Exists.";

			exit();

		}



		$code = array();
		$more = array();

		$db = array();

		$viewCNT = 0;

		$editBtn = 0;

		$delBtn = 0;

		$viewBtn = 0;

		$saveAddMore = 0;
		
		$saveAndPreview = 0;

		$saveBtn = 0;

		$PreviewAddNewBtn = 0;

		$PreviewEditBtn = 0;

		$PreviewDeleteBtn = 0;

		$PreviewBackBtn = 0;

		$viewcode = array();

		$extraCNT = 0;

		$numOfMoreDb = 0;

		$dynamix = array();

		$moreextradb = array();

		$moreExtraCNT = 0;

		

		//0=hidden 1=Text Box; 2=SelectDropDown 3=textbox 4=radio 5=Select-from-DB 6=date 7=number 8=Email 9=Checkbox-From-DB 10=MULTI-SELECT-from-DB 11=MULTI SELECT SEARCH from DB WITH MAPPING TABLE	 12=Single Media Upload 13=Multiple Media Upload
		
		$sql = "SELECT * FROM ".$metaConfig[0]." WHERE ".$metaConfig[1]." = '".$FormID."'";

		$result = db::getInstanceMaster()->db_select($sql);
		
		$viewSettings = array();

		for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row

			$viewSettings[0] = $result['result_set'][$i]['FormName'];

			$viewSettings[1] = $result['result_set'][$i]['FormTitle'];

			$viewSettings[2] = $result['result_set'][$i]['ViewSerialNo'];

			$viewSettings[3] = $result['result_set'][$i]['ViewEditBtn'];

			$viewSettings[4] = $result['result_set'][$i]['ViewDeleteBtn'];

			$viewSettings[5] = $result['result_set'][$i]['ViewOtherBtn'];

			$viewSettings[6] = $result['result_set'][$i]['OtherBtnIcon'];

			$viewSettings[7] = $result['result_set'][$i]['OtherBtnLink'];

			$viewSettings[8] = $result['result_set'][$i]['SessionDefault'];

			$viewSettings[9] = $result['result_set'][$i]['ListViewNoOfData'];

			$viewSettings[10] = $result['result_set'][$i]['OrderBy'];

			$viewSettings[11] = $result['result_set'][$i]['ProductCategoryID'];

			$viewSettings[12] = $result['result_set'][$i]['ModuleType'];

			$viewSettings[13] = $result['result_set'][$i]['ModuleStandard'];

			$viewSettings[14] = $result['result_set'][$i]['moduleid'];

			$viewSettings[15] = $result['result_set'][$i]['FormImportSPName'];

			$viewSettings[16] = $result['result_set'][$i]['PrintReportID'];



			$db[0] = $result['result_set'][$i]['TableName'];

			$db[1] = $result['result_set'][$i]['TablePrimaryKey'];

			$db[2] = $result['result_set'][$i]['TableCondition'];

			$db[3] = $result['result_set'][$i]['ListViewDBName'];

			$db[4] = $result['result_set'][$i]['SPName'];


			if($result['result_set'][$i]['ViewSerialNo'] == 1){

				$viewcode[$viewCNT][0] = -1;

				$viewcode[$viewCNT][1] = "Sr. No.";

				$viewcode[$viewCNT][2] = 0;

				$viewcode[$viewCNT][3] = "";

				$viewcode[$viewCNT][4] = 0;

				$viewCNT++;

			}

			$editBtn = $delBtn = $otherBtn = $viewBtn = $saveAddMore = $saveAndPreview = $saveBtn = $PreviewAddNewBtn = $PreviewEditBtn = $PreviewDeleteBtn = $PreviewBackBtn = $BtnEinvoice = $BtnEwaybill = $BtnGstr1 = $BtnGstr2 = 0;

			if($result['result_set'][$i]['ViewEditBtn'] == 1){
				$editBtn = 1;
			}

			if($result['result_set'][$i]['ViewDeleteBtn'] == 1){
				$delBtn = 1;
			}

			if($result['result_set'][$i]['ViewOtherBtn'] == 1){
				$otherBtn = 1;
				$otherBtnIcon = $result['result_set'][$i]['OtherBtnIcon'];
				$OtherBtnLink = $result['result_set'][$i]['OtherBtnLink'];
			}

			if($result['result_set'][$i]['ViewViewBtn'] == 1){
				$viewBtn = 1;
			}

			if($result['result_set'][$i]['SaveAddMore'] == 1){
				$saveAddMore = 1;
			}

			if($result['result_set'][$i]['SaveAndPreview'] == 1){
				$saveAndPreview = 1;
			}

			if($result['result_set'][$i]['SaveBtn'] == 1 || $result['result_set'][$i]['SaveBtn'] == ""){
				$saveBtn = 1;
			}

			if($result['result_set'][$i]['PreviewAddNewBtn'] == 1 || $result['result_set'][$i]['PreviewAddNewBtn'] == ""){
				$PreviewAddNewBtn = 1;
			}

			if($result['result_set'][$i]['PreviewEditBtn'] == 1 || $result['result_set'][$i]['PreviewEditBtn'] == ""){
				$PreviewEditBtn = 1;
			}

			if($result['result_set'][$i]['PreviewDeleteBtn'] == 1 || $result['result_set'][$i]['PreviewDeleteBtn'] == ""){
				$PreviewDeleteBtn = 1;
			}

			if($result['result_set'][$i]['PreviewBackBtn'] == 1 || $result['result_set'][$i]['PreviewBackBtn'] == ""){
				$PreviewBackBtn = 1;
			}


			

			if($result['result_set'][$i]['BtnEinvoice'] == 1){
				$BtnEinvoice = 1;
			}
			if($result['result_set'][$i]['BtnEwaybill'] == 1){
				$BtnEwaybill = 1;
			}
			if($result['result_set'][$i]['BtnGstr1'] == 1){
				$BtnGstr1 = 1;
			}
			if($result['result_set'][$i]['BtnGstr2'] == 1){
				$BtnGstr2 = 1;
			}
			 

			if($i == 0) break;  //instead of TOP 1 or LIMIT 1

		}

		

		$sql = "SELECT * FROM ".$metaConfig[2]." WHERE ".$metaConfig[3]." = '".$FormID."' ORDER BY DisplayOrder";

		$result = db::getInstanceMaster()->db_select($sql);

		

		for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row

				$code[$i][0] = trim($result['result_set'][$i]['DbFieldName']); 			//Db Field Name QQQQQQ

				$code[$i][1] = $result['result_set'][$i]['FieldType'];				//Type

				$code[$i][2] = $result['result_set'][$i]['DisplayName'];			//Label

				$code[$i][3] = 0;													//Field Attribute (negative for extradb)

				$code[$i][4] = "";													//DB Value

				$code[$i][5] = $result['result_set'][$i]['Required'];				//Required or Not

				$code[$i][6] = $result['result_set'][$i]['FieldOtherConditions'];	//Other Conditions in an Input Tag

				$code[$i][7] = $result['result_set'][$i]['DisplayOrder']; 			//Display Order

				$code[$i][8] = $result['result_set'][$i]['OtherAttributes']; 		//Other Attributes added on 18 01 2021 
				
				$code[$i][9] = $result['result_set'][$i]['TextLength'];				//Text maxlength

				$code[$i][10] = $result['result_set'][$i]['TextMax'];				//Field max value

				$code[$i][11] = $result['result_set'][$i]['TextMin'];				//Field minimum value
				
				$code[$i][12] = $result['result_set'][$i]['ReadOnly'];				//Field readonly

				$code[$i][13] = $result['result_set'][$i]['Visibility'];			//Field visibility

				$code[$i][14] = $result['result_set'][$i]['FieldSizeSM'];				//Field size

				$code[$i][15] = $result['result_set'][$i]['FieldSizeMD'];				//Field size

				$code[$i][16] = $result['result_set'][$i]['FieldSizeXS'];				//Field size

				$code[$i][17] = $result['result_set'][$i]['Onchange'];					//Field onchange

				$code[$i][18] = $result['result_set'][$i]['OnchangeParameters'];		//Field onchange parameters

				$code[$i][19] = $result['result_set'][$i]['ShowTextBoxInGrid'];			//ShowTextBoxInGrid

				$code[$i][20] = $result['result_set'][$i]['TextareaHeight'];			//ShowTextBoxInGrid

				$code[$i][21] = $result['result_set'][$i]['DynamicFreeFill'];			//DynamicFreeFill

				$code[$i][22] = $result['result_set'][$i]['OnDynamicFreeFill'];			//OnDynamicFreeFill
				
				$code[$i][23] = $result['result_set'][$i]['AddMaster'];					//AddMaster

				$code[$i][24] = $result['result_set'][$i]['DropDownYesNo'];				//DropDownYesNo

				$code[$i][25] = $result['result_set'][$i]['OnDropDownYesNo'];			//OnDropDownYesNo

				$code[$i][26] = $result['result_set'][$i]['OnLostFocusYesNo'];			//OnLostFocusYesNo

				$code[$i][27] = $result['result_set'][$i]['OnLostFocus'];				//OnLostFocus use for checking duplicate value

				$code[$i][28] = $result['result_set'][$i]['OnDropDownAjax'];			//OnDropDownAjax

				$code[$i][29] = $result['result_set'][$i]['DDSearchMinimumInputLength']; //DDSearchMinimumInputLength

				$code[$i][30] = $result['result_set'][$i]['CarryOn']; 					//CarryOn

				$code[$i][31] = $result['result_set'][$i]['DefaultValue']; 				//DefaultValue

				$code[$i][32] = $result['result_set'][$i]['isNotEditable']; 				//isNotEditable

				$code[$i][33] = $result['result_set'][$i]['RegExpression']; 			//RegExpression

				$code[$i][34] = $result['result_set'][$i]['GridId']; 					//GridId

				$code[$i][35] = $result['result_set'][$i]['OnLostFocusSp'];				//OnLostFocusSp using sp check validation

				$code[$i][36] = $result['result_set'][$i]['OnChangeSp'];				//OnChangeSp using sp check validation

				$code[$i][37] = $result['result_set'][$i]['OnClickSp'];					//OnClickSp using sp check validation

				$code[$i][38] = $result['result_set'][$i]['SqlQueryOnInsert'];			//SqlQueryOnInsert using for on save add perticular format value

				$code[$i][39] = $result['result_set'][$i]['TabIndex'];					//TabIndex using for on save add perticular format value

				$code[$i][40] = $result['result_set'][$i]['OnkeyupParameters'];			//OnkeyupParameters using for onkeyup calculation

				$code[$i][41] = $result['result_set'][$i]['NotAllowCursorOnLostFocus'];	//NotAllowCursorOnLostFocus using for onkeyup calculation

				$code[$i][42] = $result['result_set'][$i]['GridTableHeight'];			//GridTableHeight using for define table height
				
				$code[$i][43] = $result['result_set'][$i]['isBarcodeTextbox'];			//isBarcodeTextbox so that the data deletes after enter is pressed in the textbox

				$code[$i][44] = $result['result_set'][$i]['DecimalPlaces'];				//DecimalPlaces use for dynamically get DecimalPlaces

				//ADDED BY MITESH ON 18-02-2025 to avoid use of extras+db for ag-grid
				$code[$i][45]  = $result['result_set'][$i]['TableFromDb'];
				$code[$i][46]  = $result['result_set'][$i]['TablePrimary'];
				$code[$i][47]  = $result['result_set'][$i]['TableLabel'];
				$code[$i][48]  = $result['result_set'][$i]['TableCondition'];
				$code[$i][49]  = $result['result_set'][$i]['TableMapTable'];
				$code[$i][50]  = $result['result_set'][$i]['TableMapPrimary'];
				$code[$i][51]  = $result['result_set'][$i]['TableMapOtherKey'];

			$GridId = $result['result_set'][$i]['GridId']; 

			$fld = $result['result_set'][$i]['FieldType'];

			if($fld == 14 && $GridId > 0){

				$gridinfo = array($code[$i][0],$code[$i][6],$code[$i][39],$code[$i][2],$code[$i][42]); //Added by pornima for showingMultiple select dropdown on 28/5/2024

				//Check if it is moredb

				/*$more = array();

				$moredb = array();

				$moredb = array($result['result_set'][$i]['MDRelationTable'],

								$result['result_set'][$i]['MDPrimary'],

								$result['result_set'][$i]['MDLabel'],

								"",

								$result['result_set'][$i]['MDCondition'] );

				$moredb[3] = $serials[$numOfMoreDb] . $numOfMoreDb ; //4th should be section identifier

				*/

				//Check if it is moredb

				$sql1 = "SELECT * FROM ".$metaConfig[6]." WHERE ".$metaConfig[7]." = '".$GridId."' ";

				$result1 = db::getInstanceMaster()->db_select($sql1);

				//print_r($result1);

				$more = array();

				$moredb = array();
  
				for($j = 0; $j < $result1['num_rows']; $j++){ 

					$moredb = array($result1['result_set'][$j]['TableName'],	//0

									$result1['result_set'][$j]['TablePrimaryKey'],

									$result1['result_set'][$j]['GridTitle'],

									"",

									$result1['result_set'][$j]['TableCondition'],	//4

									$result1['result_set'][$j]['TableUnique'],		//5
									
									$result1['result_set'][$j]['GridCalculation'],	//6

									// $result1['result_set'][$j]['AddMaster'],

									$result1['result_set'][$j]['GridId'],  //7. Added by pornima for adding GridId in grid main div

									"", //$result1['result_set'][$j]['GridImportSPName'],  //8. Added by Mitesh on 26/9/24 for importing bulk in grid using excel or csv

									$result1['result_set'][$j]['AfterGridAddCursorPosition'],  //9. AfterGridAddCursorPosition use where FieldType is 14 for after adding row in grid then cursor set on perticular field

									$result1['result_set'][$j]['OrderBy'],  //10 use for arrange order of grid data

									$result1['result_set'][$j]['MinRowsRequired']  //MinRowsRequired for a form to save


								);    //TableUnique changed to ID on 02-Nov-2023 ($result1['result_set'][$j]['ID'])

					//$moredb[3] = $serials[$numOfMoreDb] . $numOfMoreDb ; //4th should be section identifier

					$moredb[3] = $serials[$numOfMoreDb]; //4th should be section identifier
					if($j == 0) break;  //instead of TOP 1 or LIMIT 1
				}

				// print_r($moredb); exit();

				$sql = "SELECT * FROM ".$metaConfig[4]." WHERE ".$metaConfig[5]." = ".$GridId." ORDER BY DisplayOrder";

				$moreResult = db::getInstanceMaster()->db_select($sql);

				

				for($j = 0; $j < $moreResult['num_rows']; $j++){ 

					$more[$j][0] = $moreResult['result_set'][$j]['FieldType'];				//Type

					$more[$j][1] = $moreResult['result_set'][$j]['DbFieldName'];            //Db Field Name

					$more[$j][2] = $moreResult['result_set'][$j]['DisplayName'];            //Label

					$more[$j][3] = 0;                                                       //Field Attribute (negative for extradb)

					$more[$j][4] = "";                                                      //DB Value

					$more[$j][5] = $moreResult['result_set'][$j]['Required'];               //Required or Not

					$more[$j][6] = $moreResult['result_set'][$j]['FieldOtherConditions'];   //Other Conditions in an Input Tag

					$more[$j][7] = $moreResult['result_set'][$j]['CellMinWidth'];   		//CellMinWidth

					$more[$j][8] = $moreResult['result_set'][$j]['Onchange'];   			//Onchange
					
					$more[$j][9] = $moreResult['result_set'][$j]['OnchangeParameters'];   	//Onchange Parameters
					
					$more[$j][10] = $moreResult['result_set'][$j]['Onkeyup'];   				//Keyup

					$more[$j][11] = $moreResult['result_set'][$j]['OnkeyupParameters'];   		//Keyup Parameters
					
					$more[$j][12] = $moreResult['result_set'][$j]['GridCalculation'];			//GridCalculation

					$more[$j][13] = $moreResult['result_set'][$j]['AddMaster'];					//AddMaster

					$more[$j][14] = $moreResult['result_set'][$j]['OnDropDownAjax'];			//OnDropDownAjax

					$more[$j][15] = $moreResult['result_set'][$j]['DDSearchMinimumInputLength']; //DDSearchMinimumInputLength

					$more[$j][16] = $moreResult['result_set'][$j]['CarryOn']; 					//CarryOn

					$more[$j][17] = $moreResult['result_set'][$j]['DefaultValue']; 				//DefaultValue

					$more[$j][18] = $moreResult['result_set'][$j]['isNotEditable']; 			//isNotEditable

					$more[$j][19] = $moreResult['result_set'][$j]['RegExpression']; 			//RegExpression

					$more[$j][20] = $moreResult['result_set'][$j]['OnKeyupEnter']; 				//OnKeyupEnter  Use for barcode scanning

					$more[$j][21] = $moreResult['result_set'][$j]['OnLostFocusSp'];				//OnLostFocusSp using sp check validation

					$more[$j][22] = $moreResult['result_set'][$j]['OnChangeSp'];				//OnChangeSp using sp check validation

					$more[$j][23] = $moreResult['result_set'][$j]['ReadOnly'];					//ReadOnly

					$more[$j][24] = $moreResult['result_set'][$j]['TabIndex'];					//TabIndex

					$more[$j][25] = $moreResult['result_set'][$j]['NotAllowCursorOnLostFocus'];	//TabIndex

					$more[$j][26] = $moreResult['result_set'][$j]['Visibility'];				//Visibility

					$more[$j][27] = $moreResult['result_set'][$j]['OnLostFocus'];				//OnLostFocus use for checking duplicate value

					$more[$j][28] = $moreResult['result_set'][$j]['SqlQueryOnInsert'];			//SqlQueryOnInsert using for on save add perticular format value
					
					$more[$j][29] = $moreResult['result_set'][$j]['DecimalPlaces'];				//DecimalScale using for define decimal points


					$valueFromDB = $moreResult['result_set'][$j]['ValueFromDb'];

					if($valueFromDB < 0){

						$more[$j][3] = -1 * ($moreExtraCNT + 1);

						//updated by pornima moreextra data get using dbFieldName
						// $moreextradb[$moreExtraCNT][0] = $moreResult['result_set'][$j]['TableFromDb'];

						// $moreextradb[$moreExtraCNT][1] = $moreResult['result_set'][$j]['TablePrimary'];

						// $moreextradb[$moreExtraCNT][2] = $moreResult['result_set'][$j]['TableLabel'];

						// $moreextradb[$moreExtraCNT][3] = $moreResult['result_set'][$j]['TableCondition'];

						$moreextradb[$more[$j][1]][0] = $moreResult['result_set'][$j]['TableFromDb'];

						$moreextradb[$more[$j][1]][1] = $moreResult['result_set'][$j]['TablePrimary'];

						$moreextradb[$more[$j][1]][2] = $moreResult['result_set'][$j]['TableLabel'];

						$moreextradb[$more[$j][1]][3] = $moreResult['result_set'][$j]['TableCondition'];

						$moreextradb[$more[$j][1]][4] = "";

						$moreextradb[$more[$j][1]][5] = $moreResult['result_set'][$j]['TableMapTable'];

						$moreextradb[$more[$j][1]][6] = $moreResult['result_set'][$j]['TableMapPrimary'];

						$moreextradb[$more[$j][1]][7] = $moreResult['result_set'][$j]['TableMapOtherKey'];
						
						$moreExtraCNT++;

					} 
					
					// if($FormID == 3818) print_r($moreResult['result_set'][$j]);
					// if($FormID == 3818) echo "<br /><br />";
					// if($FormID == 3818) echo $sql . $moreResult['result_set'][$j]['DecimalScale']. "<br /><br />";
				}

				$dynamix[$numOfMoreDb] = array();

				$dynamix[$numOfMoreDb][0] = $more;

				$dynamix[$numOfMoreDb][1] = $moredb;

				$dynamix[$numOfMoreDb][2] = $gridinfo; //Added by pornima for showingMultiple select dropdown on 28/5/2024

				$numOfMoreDb++;

			

			}else{

				//If not moredb then normal

				

				if(!$result['result_set'][$i]['ViewOrder'] == 0) { 

					$viewcode[$viewCNT][0] = $i;

					$viewcode[$viewCNT][1] = $result['result_set'][$i]['ViewDisplayName'];

					$viewcode[$viewCNT][2] = $result['result_set'][$i]['ViewOrder'];

					$viewcode[$viewCNT][3] = $result['result_set'][$i]['DbFieldName'];

					$viewcode[$viewCNT][4] = $result['result_set'][$i]['ValueFromDb']; 		//Reference from Other Table

					$viewCNT++;

				}

			

				$temp = $result['result_set'][$i]['ValueFromDb'];

				if(strlen($temp) > 0 && $temp < 0){ //if($temp < 0){

					//echo $temp;

					$code[$i][3] = -1 * ($extraCNT + 1);

					$extradb[$extraCNT][0] = -1 * ($extraCNT + 1);

					$extradb[$extraCNT][1] = $result['result_set'][$i]['TableFromDb'];

					$extradb[$extraCNT][2] = $result['result_set'][$i]['TablePrimary'];

					$extradb[$extraCNT][3] = $result['result_set'][$i]['TableLabel'];

					$extradb[$extraCNT][4] = $result['result_set'][$i]['TableCondition'];

					$extradb[$extraCNT][5] = "";

					$extradb[$extraCNT][6] = $result['result_set'][$i]['TableMapTable'];

					$extradb[$extraCNT][7] = $result['result_set'][$i]['TableMapPrimary'];

					$extradb[$extraCNT][8] = $result['result_set'][$i]['TableMapOtherKey'];

					$extraCNT++;

				}

			}

		}

		

		if($editBtn){

			$viewcode[$viewCNT][0] = -2;

			$viewcode[$viewCNT][1] = "Edit";

			$viewcode[$viewCNT][2] = $viewCNT + 1;

			$viewcode[$viewCNT][3] = "";

			$viewcode[$viewCNT][4] = 0;

			$viewCNT++;

		}

		if($delBtn){

			$viewcode[$viewCNT][0] = -3;

			$viewcode[$viewCNT][1] = "Delete";

			$viewcode[$viewCNT][2] = $viewCNT + 1;

			$viewcode[$viewCNT][3] = "";

			$viewcode[$viewCNT][4] = 0;

			$viewCNT++;

		}

		if($otherBtn){

			$viewcode[$viewCNT][0] = -4;

			$viewcode[$viewCNT][1] = "Action";

			$viewcode[$viewCNT][2] = $viewCNT + 1;

			$viewcode[$viewCNT][3] = "";

			$viewcode[$viewCNT][4] = 0;

			$viewCNT++;

		}

		if($viewBtn){

			$viewcode[$viewCNT][0] = -5;

			$viewcode[$viewCNT][1] = "View";

			$viewcode[$viewCNT][2] = $viewCNT + 1;

			$viewcode[$viewCNT][3] = "";

			$viewcode[$viewCNT][4] = 0;

			$viewCNT++;

		}

		if($saveAndPreview){

			$viewcode[$viewCNT][0] = -6;

			$viewcode[$viewCNT][1] = "SaveAndPreview";

			$viewcode[$viewCNT][2] = $viewCNT + 1;

			$viewcode[$viewCNT][3] = "";

			$viewcode[$viewCNT][4] = 0;

			$viewCNT++;

		}



		array_multisort(array_column($viewcode, 2), SORT_ASC, $viewcode);

	
	
		//debugArray($viewcode);

		

/*

META DATA

$viewSettings = Main Form Data



*/
// print_r($extradb);
// echo "<br />";
// print_r($moreextradb);
// echo "<br />";
// print_r($dynamix);
// echo "<br />";
// print_r($db);

// if($FormID == 5292){

// 	print_r($extradb);
// 	echo "<br />";
// 	print_r($moreextradb);
// 	echo "<br />";
// 	print_r($dynamix);
// 	echo "<br />";
// 	print_r($db);
// }

?>

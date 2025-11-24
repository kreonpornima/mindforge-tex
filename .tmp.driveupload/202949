<?php

$reportMetaConfig = array(

    "kmainforms", 			//0 - Report Header Table				
    "FormId", 			    //1 - Report Header Table PK
    "kReportFields", 		//2 - Report Fields Table
    "ReportHeaderID", 		//3 - Report Fields Table F-K
    "kReportFilters", 		//4 - Report Filter Table
    "ReportHeaderID", 		//5 - Filters Report Header Table PK

);
	
$viewCNT = 0;
$ReportID = isset($ReportID) ? $ReportID : 0;

if($ReportID == 0){
	echo "No Model Exists.";
	exit();
}

$sql = "SELECT DataFromClientServer,DataFromClientURL, ImageToClientServer, ImageToClientServer  FROM AiGroup WHERE ID = ".$_SESSION['group_id']."";
$resultServer = db::getInstanceMaster()->db_select($sql);
$viewReportServerSettings[0] = $resultServer['result_set'][0]['DataFromClientServer'];
$viewReportServerSettings[1] = $resultServer['result_set'][0]['DataFromClientURL'];
/*if($_SESSION['group_id'] == 18){
	$viewReportServerSettings[0] = '';
	$viewReportServerSettings[1] = '';
}*/
$sql = "SELECT * FROM ".$reportMetaConfig[0]." WHERE ".$reportMetaConfig[1]." = '".$ReportID."'";
$result = db::getInstanceMaster()->db_select($sql);
$viewReportSettings = array();

for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row

	$viewReportSettings[0] = $result['result_set'][$i]['FormName'];

	$viewReportSettings[1] = $result['result_set'][$i]['FormTitle'];

	$viewReportSettings[2] = $result['result_set'][$i]['ViewSerialNo'];

	$viewReportSettings[3] = $result['result_set'][$i]['ViewEditBtn'];

	$viewReportSettings[4] = $result['result_set'][$i]['ViewDeleteBtn'];

	$viewReportSettings[5] = $result['result_set'][$i]['ViewOtherBtn'];

	$viewReportSettings[6] = $result['result_set'][$i]['OtherBtnIcon'];

	$viewReportSettings[7] = $result['result_set'][$i]['OtherBtnLink'];

	$viewReportSettings[8] = $result['result_set'][$i]['SessionDefault'];

	$viewReportSettings[9] = $result['result_set'][$i]['ListViewNoOfData'];

	$viewReportSettings[10] = 0;	//Chart Integration in Pivot Grid = 0 or 1

	$viewReportSettings[11] = 0;	//Drill Down feature in Pivot Grid = 0 or 1
	
	// $viewReportSettings[3] = $result['result_set'][$i]['ShowSerialNum'];

	$db[0] = $result['result_set'][$i]['TableName'];
	
	$db[1] = $result['result_set'][$i]['SPName'];

	if($result['result_set'][$i]['ShowSerialNum'] == 1){
		$viewcode[$viewCNT][0] = -1;
		$viewcode[$viewCNT][1] = "Sr. No.";
		$viewcode[$viewCNT][2] = 0;
		$viewcode[$viewCNT][3] = "";
		$viewcode[$viewCNT][4] = 0;
		$viewCNT++;
	}
	if($i == 0) break;  //instead of TOP 1 or LIMIT 1
}
/*
$sql1 = "SELECT * FROM ".$reportMetaConfig[2]." WHERE ".$reportMetaConfig[3]." = '".$ReportID."' ORDER BY OrderNo";
$result1 = db::getInstanceMaster()->db_select($sql1);
for($i = 0; $i < $result1['num_rows']; $i++){ 	//WHILE LOOP FOR $row

		$code[$i][0] = $result1['result_set'][$i]['ViewFieldName'];		//Db Field Name QQQQQQ

		$code[$i][1] = $result1['result_set'][$i]['DisplayName'];		//Type

		$code[$i][2] = $result1['result_set'][$i]['OrderNo'];			//Label

		$code[$i][3] = $result1['result_set'][$i]['ShowTotal'];			//Field Attribute (negative for extradb)

		$code[$i][4] = $result1['result_set'][$i]['OtherConditions'];	//DB Value

}

$sql2 = "SELECT * FROM ".$reportMetaConfig[4]." WHERE ".$reportMetaConfig[5]." = '".$ReportID."' ";

$result2 = db::getInstanceMaster()->db_select($sql2);

for($i = 0; $i < $result2['num_rows']; $i++){ 	//WHILE LOOP FOR $row

		$filterCode[$i][0] = $result2['result_set'][$i]['FilterLabel'];		//Db Field Name QQQQQQ

		$filterCode[$i][1] = $result2['result_set'][$i]['ViewFieldName'];	//Type

		$filterCode[$i][2] = $result2['result_set'][$i]['ViewFieldID'];		//Label

		$filterCode[$i][3] = $result2['result_set'][$i]['FilterType'];		//Field Attribute (negative for extradb)

		$filterCode[$i][4] = $result2['result_set'][$i]['OtherConditions'];	//DB Value

		$filterCode[$i][5] = $result2['result_set'][$i]['FieldSizeSM'];

		$filterCode[$i][6] = $result2['result_set'][$i]['FieldSizeMD'];

		$filterCode[$i][7] = $result2['result_set'][$i]['FieldSizeXS'];

}*/

?>
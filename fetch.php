<?php
//fetch.php
require_once ('dbClass.php');
$FormID = isset($_POST['FormID']) ? $_POST['FormID'] : '0';
include 'model.php';
include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");  //used for UNICODE conversion / encoding
// echo "==>>>>>" . $viewSettings[16];
// date_default_timezone_set('Asia/Calcutta'); 
// $log  = "-------------------------".PHP_EOL."User: ".$_SESSION['email'].' - '.date("F j, Y, g:i a")." => Data: ".json_encode($_REQUEST).PHP_EOL. ( "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ).PHP_EOL;
// file_put_contents('./logs/'.$_SESSION['email'].'.log', $log, FILE_APPEND);
// $MainDBTable = array("AiCompany","AiDivision","AiGroup","AiGroupLicense","AiGroupProductAccess","AiProductCategory",
// "AiReg","AiYear","CompanyRoleAccess","kgridfields","kmainfields","kmainforms","kmaingrid","kmainmedia","kpageaccess",
// "kreport_datagrid_data","kreport_pivot_data","kReportFields","kReportFielters","kReportHeader","master_fieldtype","Master_ModuleType","pageroleaccesss","pagerolemaster","users");

$viewvals = array();
$isFilter = 0;

$db[4] = '';
$spExists = false;
$SPName = 'sp_listview_'.$FormID;
$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
$sqlresult = db::getInstance()->db_select($sql,"FTC-21");
if($sqlresult['result_set'][0]['found'] == 1){
    $db[4] = $SPName;
}


if(strlen($db[4]) > 0){ //If ListView SPName
    $sqlfields = $db[4].".*";
}else if(strlen($db[3]) > 0){ //If ListViewDBName
    $sqlfields = $db[3].".*";
}else{
    $sqlfields = $db[0].".*";
}

$sqljoin = "";

$serialCntFrImages = 0;
$sqlfieldsArray2 = [];
$sqlfieldsArray3 = [];

if(strlen($db[3]) == 0 || strlen($db[4]) == 0){
    if(isset($extradb)){ 
        for($i = 0;$i < sizeof($extradb); $i++){
            //if(isset($extra))
            $temp = ""; $noFlag = 0; 
            //$mediaFlag = 0;
            for($j = 0; $j < sizeof($code); $j++){
                if($extradb[$i][0] == $code[$j][3]){

                    $temp = $code[$j][0];

                    if($code[$j][1] == 10) $noFlag=1; 

                    if($code[$j][1] == 11) $noFlag=1; 

                    if($code[$j][1] == 12) $noFlag=1; 

                    if($code[$j][1] == 13) $noFlag=1; 

                    break;
                }
            }

            if($noFlag) goto a;

            $sqlfields .= " , COALESCE(".$serials[$i].".".$extradb[$i][3].", '-') as ".$temp.$serials[$i];
         
            array_push($sqlfieldsArray2, $serials[$i].".".$extradb[$i][3]." as ".$temp.$serials[$i]);
            array_push($sqlfieldsArray3, $serials[$i].".".$extradb[$i][3]);

            $sqljoin .= " LEFT JOIN ".$extradb[$i][1]." ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i].".".$extradb[$i][2] ;

            //if($mediaFlag) goto a;
            a: $temp="";
        }
        $serialCntFrImages = sizeof($extradb);
    }
}


//FOR MEDIA JOIN ONLY 12 on List View & 13 cannot be on List View
for($j = 0; $j < sizeof($code); $j++){
    if($code[$j][1] == 12){ 

        $temp = $code[$j][0];
        $sqlfields .= " , ISNULL(".$serials[$i].".MediaName, '-') as ".$temp.$serials[$i]."Name";

        $sqlfields .= " , ISNULL(".$serials[$i].".MediaFolder, '-') as ".$temp.$serials[$i]."Folder";

        $sqlfields .= " , ISNULL(".$serials[$i].".MediaType, '-') as ".$temp.$serials[$i]."Type";

        $sqljoin .= " LEFT JOIN kmainmedia ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i++].".MediaID";
    }
}

if(!isset($forceCondition)){
    $forceCondition = "";
}

// if(strlen($forceCondition) > 2){
//     $db[2] = $forceCondition;
// }else{
//     if(strlen($db[2]) > 2){
//         $db[2] = " ".$db[2];
//     }elseif(strlen($db[3]) > 2){
//         $db[3] = " ".$db[3];
//     }else{

//         $db[2] = " Order by ".$db[0].'.'.$db[1]." Desc";
//     }
// }


if (in_array($db[0],$MainDBTable)){
    $Instance = db::getInstanceMaster();
    $dbName = 'Main';
}else{
    $Instance = db::getInstance();
    $dbName = $_SESSION['dbName'];
}

//check user role access
$access = UserAccess($FormID, $_SESSION['access']); // make sure $FormID and $RoleID are defined

//Get primary key
// echo $sql1 ="SELECT COLUMN_NAME FROM ".$dbName.".INFORMATION_SCHEMA.KEY_COLUMN_USAGE
// WHERE TABLE_NAME LIKE '".$db[0]."' AND CONSTRAINT_NAME LIKE 'PK%'";

// $sqlresult = $Instance->db_select($sql1);

// $getPrimaryKey = $sqlresult['result_set'][0]['COLUMN_NAME'];
// echo $viewcode[1][3];



// if(strlen($db[4]) > 0){
//     $queryForCount = "Exec count(".$db[4].".".$db[1].") AS cnt ";
// }else
if(strlen($db[3]) > 0){
    $db[0] = $db[3];
    $queryForCount = "SELECT count(".$db[0].".".$db[1].") AS cnt ";
}else{
    // $queryForCount = "SELECT count(".$db[0].".".$viewcode[1][3].") AS cnt ";
    $queryForCount = "SELECT count(".$db[0].".".$db[1].") AS cnt ";
}


$query = '';

if(strlen($db[4]) > 0){
    $queryWithoutCount = " "; //." Order by ".$db[0].'.'.$db[1]." Desc";
    $query .= $db[4];
    
    $sqlColumns = "sp_describe_first_result_set N'$db[4]'";
    $data['params'] = [];
    $sp['values'] = [];

    $resultColumns = db::getInstance()->db_sp_select($sqlColumns, $data['params'], $sp['values'],"FTC-155");
    $resultColumnsRow = $resultColumns['result_set'];
}elseif(strlen($db[3]) > 0){
    $queryWithoutCount = "SELECT * "; //." Order by ".$db[0].'.'.$db[1]." Desc";
    $query .= " From ".$db[3];
    
    $sqlColumns = "SELECT * FROM information_schema.columns WHERE table_name='".trim($db[3])."'";

    $resultColumns = db::getInstance()->db_select($sqlColumns,"FTC-165");
    $resultColumnsRow = $resultColumns['result_set'];
    
}else{
    $queryWithoutCount = "SELECT ".$sqlfields; //." Order by ".$db[0].'.'.$db[1]." Desc";
    $query .= " From ".$db[0]." " .$sqljoin;
}


if(strlen($db[4]) > 1){
    $query .= " WHERE ";
}else{
    $query .= " WHERE 1=1 ";
}

if($FormID == 1){
    $forceCondition = ' users.GroupID = ' . $_SESSION['group_id'] . ' ';
}
if(strlen($forceCondition) > 2){
    $db[2] = $forceCondition;
}else{
    // elseif(strlen($db[3]) > 2){
    //     $db[3] = " ".$db[3];
    // }
}
if(strlen($db[2]) > 2){
    $query .= " AND ".$db[2]." ";
}

$flag = 0;
$sqlfieldsArray1 = [];
$sqlfieldsArray = [];


// for($i=0; $i<sizeof($viewcode); $i++){
//     if($viewcode[$i][3] !="" && $viewcode[$i][4] < 0){
//         $sql = "select TableFromDb from kmainfields where FormId='".$FormID."'  AND DbFieldName='".$viewcode[$i][3]."'";
//         $result = db::getInstanceMaster()->db_select($sql,"FT-202");
        
//         if(strlen($result['result_set'][0]['TableFromDb']) == 0){
//             array_push($sqlfieldsArray1, $db[0].".".$viewcode[$i][3]);
//         } 
//     }else{
//         if($viewcode[$i][3] !=""){
//             array_push($sqlfieldsArray1, $db[0].".".$viewcode[$i][3]);
//         }
//     }
// }


// 1. Collect all DbFieldNames first
$dbFieldNames = [];
for ($i = 0; $i < sizeof($viewcode); $i++) {
    if (!empty($viewcode[$i][3])) {
        $dbFieldNames[] = "'" . addslashes($viewcode[$i][3]) . "'";
    }
}

// 2. If any field names exist, get all TableFromDb in one query
$fieldToTable = [];
if (!empty($dbFieldNames)) {
    $inClause = implode(',', $dbFieldNames);
    $sql = "SELECT DbFieldName, TableFromDb 
            FROM kmainfields 
            WHERE FormId = '$FormID' 
            AND DbFieldName IN ($inClause)";
    $result = db::getInstanceMaster()->db_select($sql, "FT-202");

    // Create mapping for quick lookup
    foreach ($result['result_set'] as $row) {
        $fieldToTable[$row['DbFieldName']] = $row['TableFromDb'];
    }
}

// 3. Use the mapping instead of querying each time
for ($i = 0; $i < sizeof($viewcode); $i++) {
    $fieldName = $viewcode[$i][3] ?? '';
    if ($fieldName !== '') {
        $tableFromDb = $fieldToTable[$fieldName] ?? '';

        if ($viewcode[$i][4] < 0 && strlen($tableFromDb) == 0) {
            $sqlfieldsArray1[] = $db[0] . "." . $fieldName;
        } elseif ($viewcode[$i][4] >= 0) {
            $sqlfieldsArray1[] = $db[0] . "." . $fieldName;
        }
    }
}



if(strlen($db[3]) > 0 || strlen($db[4]) > 0){
    
    $columnArray = [];

    if(strlen($db[4]) > 0){

        for($i=0;$i<sizeof($resultColumnsRow[0]); $i++){

            $columnArray[$i]['Field'] = $resultColumnsRow[0][$i]['name'];
            $columnArray[$i]['Type'] = $resultColumnsRow[0][$i]['system_type_name'];
        }
    }else if(strlen($db[3]) > 0){

        for($i=0;$i<sizeof($resultColumnsRow); $i++){
            $columnArray[$i]['Field'] = $resultColumnsRow[$i]['COLUMN_NAME'];
            $columnArray[$i]['Type'] = $resultColumnsRow[$i]['DATA_TYPE'];
        }
    }
    
    // array_shift($columnArray);
    for($j=0;$j<sizeof($viewcode); $j++){
        if($viewcode[$j][0] == "-2"){
            // if($pageAccessForUser['EditBtn'] == 1 || $bypassUserRoles)
                array_push($columnArray, ['Field' => "Edit", 'Type' => "-2"]);
        }else{
            if($viewcode[$j][0] == "-3"){
                // if($pageAccessForUser['DeleteBtn'] == 1 || $bypassUserRoles)
                    array_push($columnArray, ['Field' => "Delete", 'Type' => "-3"]);
            }else{
                if($viewcode[$j][1] == "-4"){
                    // if($pageAccessForUser['OtherBtn'] == 1 || $bypassUserRoles)
                        array_push($columnArray, ['Field' => "Action", 'Type' => "-4"]);
                }else{
                    if($viewcode[$j][0] == "-5"){
                        // if($pageAccessForUser['OtherBtn'] == 1 || $bypassUserRoles)
                            array_push($columnArray, ['Field' => "View", 'Type' => "-5"]);
                    }else{
                        
                        if($viewcode[$j][0] == "-1" )
                            array_unshift($columnArray, ['Field' => "Sr. No", 'Type' => "-1"]);
                        
                    }
                }
            }
        }
    }

    for($i=0;$i<sizeof($columnArray); $i++){        
		if($columnArray[$i]['Type'] >= -1)
            $k_table_headings .= '<th>'.$columnArray[$i]['Field'].'</th>';
        if($i == (sizeof($columnArray) - 1))
            $k_table_headings .= '<th>Action</th>'; 
        //$k_table_headings .= '<th>'.$columnArray[$i]['Field'].'</th>';
    }

    $columnArrayWithoutExtraField=[];
    for($h=0; $h<count($columnArray); $h++){
        if($columnArray[$h]['Field'] != "Edit" && $columnArray[$h]['Field'] != "Delete" && $columnArray[$h]['Field'] != "Sr. No"){
            array_push($columnArrayWithoutExtraField, $columnArray[$h]['Field']);
        }
    }
}


if(isset($_POST["is_variable"]) && isset($_POST["is_value"])){
    
    // print_r($_POST["is_value"]);
    if($_POST["is_value"] != null){
        $variables = explode(',',$_POST["is_variable"]);
        $values = explode(',',$_POST["is_value"]);

        if(strlen($db[3]) > 0 || strlen($db[4]) > 0){ // For Listview

            for($m=0; $m<count($variables); $m++){
                $query .= " AND ".$variables[$m]." LIKE '%".$values[$m]."%' ";
            }
            $isFilter = 1;

        }else{ // For TableName

            
            for($m=0; $m<count($variables); $m++){
                $flag = 0;

                
    
                foreach ($sqlfieldsArray1 as $sqlf) {

                    if (strpos($sqlf, $variables[$m]) !== false){
                        // $sqlNewArray = explode("as",$sqlf);
                        $query .= " AND ".$sqlf." LIKE '%".$values[$m]."%' ";
                        $flag = 1;
                        break;
                    }
                }
    
                if($flag != 1){
                    // if($FormID == 3106){
                    //     print_r($sqlfieldsArray2 );
                    //     echo "else";
                    // }
                    foreach ($sqlfieldsArray2 as $sqlf) {
                        if (strpos($sqlf, $variables[$m]) !== false){
                            $sqlNewArray = explode("as",$sqlf);
                            $query .= "AND ".$sqlNewArray[0]." LIKE '%".$values[$m]."%' ";
                            // $flag = 1;
                            break;
                        }
                    }
                }
                // if($flag != 1){
                //     $searchVariable = $db[0].".".$variables[$m];
                //     $query .= "AND ".$searchVariable." LIKE '%".$values[$m]."%' ";
                // }
            }
        }        
    }
}


// print_r($columnArray);

$sqlfieldsArray = array_merge($sqlfieldsArray1,$sqlfieldsArray3);
$Fields = "";
if(isset($_POST["search"]["value"])){    
    if(strlen($_POST["search"]["value"]) > 3){
        if(strlen($db[3]) > 0 || strlen($db[4]) > 0){
            foreach($columnArrayWithoutExtraField as $key=>$value){
                $Fields .="COALESCE(".$value.",'-')";
                if($key != count($columnArrayWithoutExtraField)-1){
                    $Fields .= ",'|',";
                }
            }
        }else{
            foreach($sqlfieldsArray as $key=>$value){
                $Fields .="COALESCE(".$value.",'-')";
                if($key != count($sqlfieldsArray)-1){
                    $Fields .= ",'|',";
                }
            }
        }
        $query .= 'AND concat('.$Fields.') LIKE \'%'.$_POST["search"]["value"].'%\' ';
    }
}

if(strlen($db[4]) == 0 ){ //$viewSettings[12] == 2 && 
    if($viewSettings[12] == 2){
        if(strlen($db[3]) > 0){
            $query .= 'AND YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' ';
        }else{
            $query .= 'AND '.$db[0].'.YearCode= '.$_SESSION['dbYear'].' AND '.$db[0].'.DivisionId='.$_SESSION['dbDivision'].' AND '.$db[0].'.CompanyId='.$_SESSION['dbCompany'].' ';
        }
    }
}


// echo $queryForCount . $query;
if(strlen($db[4]) == 0 ){
    $number_filter = db::getInstance()->db_select($queryForCount . $query);
    // print_r($number_filter);
    $number_filter_row = $number_filter['result_set'][0]['cnt'];
}


if(isset($_POST["order"])){
   
    if(strlen($db[3]) > 0 || strlen($db[4]) > 0){
        foreach($columnArrayWithoutExtraField as $key=>$value){
            if($key == $_POST["order"][0]['column']-2){
                $key ." == ". $value ." == ". $_POST["order"][0]['column']-1;
                $query .= 'ORDER BY ' .$value.' '.$_POST['order']['0']['dir'];
            }
        }
    }else{
        foreach($sqlfieldsArray as $key=>$value){
            if($key == $_POST["order"][0]['column']-2){
                $key ." == ". $value ." == ". $_POST["order"][0]['column']-1;
                $query .= ' ORDER BY ' .$value.' '.$_POST['order']['0']['dir'];
            }
        }
    }
}else{
    if(strlen($db[3]) > 0 || strlen($db[4]) > 0){ 
        if(strlen($viewSettings[10]) > 0){
            $query .= ' ORDER BY ' .$viewSettings[10];
        }else{
            $query .= ' ORDER BY "'.$columnArray[1]['Field'].'" DESC ';
        }
    }else{
        if(strlen($viewSettings[10]) > 0){
            $query .= ' ORDER BY ' .$viewSettings[10];
        }else{
            $query .= ' ORDER BY "'.$viewcode[1][3].'" DESC ';
        }
    }
}

$query1 = '';

if($_POST["length"] != 1)
{
    $query1 .= ' OFFSET ' . $_POST['start'] . ' ROWS FETCH NEXT ' . $_POST['length'] . ' ROWS ONLY';
}


$query2 = $queryWithoutCount . $query . $query1;


if(strlen($db[4]) > 1){

    $queryArray = explode('WHERE',$query2);
    // print_r($queryArray);

    $sql1 = "SELECT name FROM users WHERE id='".$_SESSION['user_id']."' ";
    $sql1result = db::getInstanceMaster()->db_select($sql1, "FT-432");	
    $username = $sql1result['result_set'][0]['name'];

    $data['name'] = $db[4];
    $session = 'YearCode='.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';

    $data['params'] = ['@whereCondition','@isFilter','@username','@session'];
    $sp['values'] = ["'$queryArray[1]'","$isFilter","'$username'", "'$session'"];
   

    $result = db::getInstance()->db_sp_select($data['name'], $data['params'], $sp['values'], "FTC-443"); 
    // print_r($result);
}else{
   
    $result = db::getInstance()->db_select($query2, "FTC-424");

}
// print_r($code);
for($j = 0; $j < sizeof($code); $j++){
    
    if($code[$j][1] == 12 || $code[$j][1] == 13 ){
        $sr[$j] = $serialCntFrImages++;
    }
}

// if($FormID == 5101){
//     print_r($result);
// }

if($db[4] > 0){
    if($result['result_set'][1]){
        
        for($i=0; $i<count($result['result_set'][1]); $i++){
            for($j = 0; $j < sizeof($columnArray); $j++){
                if (array_key_exists($columnArray[$j]['Field'],$result['result_set'][1][$i])){
                    if($columnArray[$j]['Type'] == "date" || $columnArray[$j]['Type'] == "timestamp" || $columnArray[$j]['Type'] == "smalldatetime" || $columnArray[$j]['Type'] == "datetime"){ //if DATE
                            
                        $temp = $result['result_set'][1][$i][$columnArray[$j]['Field']];
                        
                        if($temp != NULL){
                            if (gettype($temp) == "string"){
                                $temp =  date("d-m-Y", strtotime($temp));
                            }else{
                                $temp = $temp->format('d-m-Y');
                            }
                        }
                        $viewvals[$i][$j] = $temp;
                    }else{
    
                        $viewvals[$i][$j] = $result['result_set'][1][$i][$columnArray[$j]['Field']];
                    }
                }
            }
        }
    }
   
}elseif($db[3] > 0){
    if($result['result_set']){
        for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row

            for($j = 0; $j < sizeof($code); $j++){
                //echo "<br />" . $code[$j][3];
                if($code[$j][1] == 14 ){
                    //Grid 
                    $viewvals[$i][$j] = "";
                }else{
                    if($code[$j][1] == 10 ){ //DB REFERENCE WITH MULTIPLE
                        $viewvals[$i][$j] = "";
                    }else{
                        if($code[$j][1] == 11 || $code[$j][1] == 13 || $code[$j][1] == 16 ){ //DB REFERENCE WITH MULTIPLE
                            $viewvals[$i][$j] = "";
                        }else{
                            if($code[$j][1] == 12){ //SINGLE MEDIA 
                                $mediaType = $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Type"];
                                if($mediaType == "jpg" || $mediaType == "jpeg" || $mediaType == "png" || $mediaType == "bmp" ){
                                    $viewvals[$i][$j] = "<a href='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' target='_blank'>" . "<img src='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' height='100px'>"."</a>";
                                }else{
                                    $viewvals[$i][$j] = "<a href='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' target='_blank'>" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."</a>";
                                }
                            }else{							
        
                                /*REMOVED EMAIL FROM DB REFERENCE 10 03 2021*/							
        
                                if($code[$j][1] == 9 || $code[$j][1] == 10 || $code[$j][3] < 0 ) //DB REFERENCE 
        
                                    $viewvals[$i][$j] = $result['result_set'][$i][$code[$j][0].$serials[(-1*$code[$j][3])-1]];
                                else 
        
                                    $viewvals[$i][$j] = $result['result_set'][$i][$code[$j][0]];
                            }
                        }
                    }
                }
            }
        
            //$serialCntFrImages++;
            
            $viewvals[$i][$j] = $result['result_set'][$i][$db[1]];
            
        
            // print_r($db); exit();
            // print_r($viewvals);
        }
    }
    // for($i=0; $i<count($result['result_set']); $i++){
    //     for($j = 0; $j < sizeof($columnArray); $j++){
    //         if (array_key_exists($columnArray[$j]['Field'],$result['result_set'][$i])){
    //             if($columnArray[$j]['Type'] == "date" || $columnArray[$j]['Type'] == "timestamp" || $columnArray[$j]['Type'] == "smalldatetime" || $columnArray[$j]['Type'] == "datetime"){ //if DATE
                        
    //                 $temp = $result['result_set'][$i][$columnArray[$j]['Field']];
                    
    //                 if($temp != NULL){
    //                     if (gettype($temp) == "string"){
    //                         $temp =  date("d-m-Y", strtotime($temp));
    //                     }else{
    //                         $temp = $temp->format('d-m-Y');
    //                     }
    //                 }
    //                 $viewvals[$i][$j] = $temp;
    //             }else{

    //                 $viewvals[$i][$j] = $result['result_set'][$i][$columnArray[$j]['Field']];
    //             }
    //         }
    //     }
    // }
   
}else{
    for($i = 0; $i < $result['num_rows']; $i++){ //WHILE LOOP FOR $row
    
        for($j = 0; $j < sizeof($code); $j++){
            //echo "<br />" . $code[$j][3];
            if($code[$j][1] == 14 ){
                //Grid 
                $viewvals[$i][$j] = "";
            }else{
                if($code[$j][1] == 10 ){ //DB REFERENCE WITH MULTIPLE
                    $viewvals[$i][$j] = "";
                }else{
                    if($code[$j][1] == 11 || $code[$j][1] == 13 || $code[$j][1] == 16 ){ //DB REFERENCE WITH MULTIPLE
                        $viewvals[$i][$j] = "";
                    }else{
                        if($code[$j][1] == 12){ //SINGLE MEDIA 
                            $mediaType = $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Type"];
                            if($mediaType == "jpg" || $mediaType == "jpeg" || $mediaType == "png" || $mediaType == "bmp" ){
                                $viewvals[$i][$j] = "<a href='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' target='_blank'>" . "<img src='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' height='100px'>"."</a>";
                            }else{
                                $viewvals[$i][$j] = "<a href='" . SITE_ROOT . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Folder"] . "" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."' target='_blank'>" . $result['result_set'][$i][$code[$j][0].$serials[$sr[$j]]."Name"]."</a>";
                            }
                        }else{							
    
                            /*REMOVED EMAIL FROM DB REFERENCE 10 03 2021*/							
    
                            if($code[$j][1] == 9 || $code[$j][1] == 10 || $code[$j][3] < 0 ) //DB REFERENCE 
    
                                $viewvals[$i][$j] = $result['result_set'][$i][$code[$j][0].$serials[(-1*$code[$j][3])-1]];
                            else 
    
                                $viewvals[$i][$j] = $result['result_set'][$i][$code[$j][0]];
                        }
                    }
                }
            }
        }

        $viewvals[$i][$j] = $result['result_set'][$i][$db[1]];

    }
}


// print_r($viewvals);
// print_r($resultColumnsRow);

//check if Barcode print SP exists
$isBarcodePrintBtn = false;
$SPName = 'sp_BarcodePrint_'.$FormID;
$sql = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$SPName'";
$sqlresult = db::getInstance()->db_select($sql,"FTC-610");
if($sqlresult['result_set'][0]['found'] == 1){
    $isBarcodePrintBtn = true;
    // $data['params'] = ['@ycode','@division','@company','@insertedid','@userid'];
    // $sp['values'] = [$_SESSION['dbYear'],$_SESSION['dbDivision'],$_SESSION['dbCompany'],$editID,$user_id];
    // $result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
    // print_r($result);
    // exit();
}

// if($FormID == 5101){
//     print_r($viewvals);
// }



$formType = isset($viewSettings[17]) ? trim($viewSettings[17]) : '';

function checkEwaybillAndEinvoice($editID, $FormID, $formType) {
    
    // $invoiceForm = "SELECT * FROM kmainforms 
    //                 WHERE formtype IN ('INV','BIL','SGR','PGR') 
    //                   AND TableName = 'acc_trns' 
    //                   AND FormId = $FormID";
    

    // $getInvForm = db::getInstance()->db_select($invoiceForm, "FTC-626");

    // $formType = isset($viewSettings[17]) ? trim($viewSettings[17]) : '';

    // if($_SESSION['user_id'] == 1020){
    //     echo $formType;
    //     if (in_array($formType, ['INV', 'BIL', 'SGR', 'PGR'])){
    //         echo "hi";
    //     }
    // }
    
    // if ($getInvForm['num_rows'] == 1) {
    if (in_array(strtoupper($formType), ['INV', 'BIL', 'SGR', 'PGR'])) {
        $result = [
            'ewaybill_generated' => false,
            'einvoice_generated' => false
        ];

        $checkEwaybill = "SELECT 1 FROM acc_ewaybill_up 
                          WHERE entryid = $editID 
                            AND Response_EwaybillNo <> '' 
                            AND API_Status = 1";

        $getEwaybill = db::getInstance()->db_select($checkEwaybill, "FTC-640");

        if ($getEwaybill['num_rows'] > 0) {
            $result['ewaybill_generated'] = true;
        }

        $checkEInvoice = "SELECT 1 FROM acc_einvoice_up 
                          WHERE entryid = $editID 
                            AND Response_Status = 'act'";

        $getEInvoice = db::getInstance()->db_select($checkEInvoice, "FTC-651");
        if ($getEInvoice['num_rows'] > 0) {
            $result['einvoice_generated'] = true;
        }

        return $result;
    }

    return null; // Not an invoice-type form
}



$data = array();
$k = 0;
if(strlen($db[4]) > 0 ){
    
    if (isset($result['result_set'][1][0]) && is_array($result['result_set'][1][0]) && !array_key_exists('recordsfiltered', array_change_key_case($result['result_set'][1][0], CASE_LOWER))){
        
        for($i=0; $i<sizeof($result['result_set'][1]); $i++){
         
            $sub_array = array();
            //Added checkbox at first column
            $checkbox = "<input type='checkbox' name='printRecords' id='".$viewvals[$i][1]."' value='".$viewvals[$i][1]."'>";
            array_push($sub_array,$checkbox);
            $lastColumn = "";
            // print_r($columnArray);
            for($j=0; $j<sizeof($columnArray); $j++){
                   
                // print_r($viewvals[$i][1]); echo "</br>";
                // echo $columnArray[$j]['Field'];
                if($columnArray[$j]['Field'] == "Edit"){	//EDIT 	  
                    if($access['canEdit']){   
                        //check invoice form ewaybill & einvoice bill if anyone generated then don't allow to edit & delete from preview page
                        $checkStatus = checkEwaybillAndEinvoice($viewvals[$i][1], $FormID, $formType);
                        
                        if ($checkStatus['ewaybill_generated'] != 1 && $checkStatus['einvoice_generated'] != 1) {
                            $lastColumn .= '<form  name="form"  action="list-data.php?form='.$FormID.'" method="POST">
                                    <input type="hidden" name="editID" value='.$viewvals[$i][1].' />							
                                    <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="edit" ><i class="fa fa-pencil"></i></button>
                                </form>' ; 
                        }
                        // array_push($sub_array,$x);
                    }
                }else{
                    if($columnArray[$j]['Field'] == "View"){	//Preview 	  
                        $lastColumn .= '<form  name="form"  action="list-data.php?form='.$FormID.'&preview='.$viewvals[$i][1].'" method="POST">
                                <input type="hidden" name="editID" value='.$viewvals[$i][1].' />							
                                <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Preview (Ctrl + P)" ><i class="fa fa-eye"></i></button>
                            </form>' ; 
                        // array_push($sub_array,$x);
                    }else{
                        
                        if($columnArray[$j]['Field'] == "Delete"){	//DELETE 	
                            
                            $viewlink = "";
                            if(isset($viewcodeextra)){
                                for($p = 0; $p < sizeof($viewcodeextra); $p++){
                                    if($viewcodeextra[$p][0] == -3){
                                        $viewlink = $viewcodeextra[$p][1];
                                        break;
                                    }
                                }
                            }
        
                            if($access['canDelete']){
                                    //check invoice form ewaybill & einvoice bill if anyone generated then don't allow to edit & delete from preview page
                                $checkStatus = checkEwaybillAndEinvoice($viewvals[$i][1], $FormID, $formType);
                                
                                if ($checkStatus['ewaybill_generated'] != 1 && $checkStatus['einvoice_generated'] != 1) {
                                    $lastColumn .= '<form   method="POST" >
                                            <input type="hidden" name="delID" value='.$viewvals[$i][1].' />    
                                            <button class="btn btn-danger bizbtn" id="delButton" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Delete" ><i class="fa fa-trash"></i></button>
                                        </form>' ; 
                                }
                                // array_push($sub_array,$x);	
                            }
                            
                        }else{
                            if($columnArray[$j]['Field'] == "Action"){	//OTHER BTN 	
                                $lastColumn .= '<form  action="' . $viewSettings[7] . '" method="POST">
                                        <input type="hidden" name="editID" value='.$viewvals[$i][1].' />        
                                        <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="" ><i class="fa '.$viewSettings[6].'"></i></button>
                                    </form>' ; 
                                // array_push($sub_array,$x);	
                                
                            }else{
                                if($columnArray[$j]['Field'] == "Sr. No"){ //Serial Number
                                    
                                    if($i == 0){
                                        $k = 1;
                                    }
                                    $x = $_POST['start'] + $k ; 
                                    array_push($sub_array,$x);
                                    $k++;
                                }else{	
                                    if($columnArray[$j]['Type'] == "date" || $columnArray[$j]['Type'] == "timestamp" || $columnArray[$j]['Type'] == "smalldatetime" || $columnArray[$j]['Type'] == "datetime"){ //if DATE
                            
                                        // print_r($result['result_set']);
                                        $temp = $result['result_set'][1][$i][$columnArray[$j]['Field']];
                                        
                                        if($temp != NULL){
                                            if (gettype($temp) == "string"){
                                                $temp =  date("d-m-Y", strtotime($temp));
                                            }else{
                                                $temp = $temp->format('d-m-Y');
                                            }
                                        }
                                        
                                        array_push($sub_array,$temp);	
                                    }else{
                                        array_push($sub_array,Encoding::fixUTF8($result['result_set'][1][$i][$columnArray[$j]['Field']],Encoding::ICONV_IGNORE));
                                    }
                                }
                            }
                        }
                        
                    }
                }
                // echo $columnArray[$j]['Field'];
            }
            // if($access['canBarccodePrint']){
                if($isBarcodePrintBtn){
                    $lastColumn .= '<button id="list-view-barcode-btn" class="btn btn-primary bizbtn" style="font-size:10px;" data-toggle="tooltip" data-placement="bottom" title="Barcode" onclick="ListViewBarcodePrint(\''.$viewvals[$i][1].'\')"><i class="fa fa-barcode"></i></button>';
                    // $lastColumn .= '<form  name="form"  action="print-barcodes.php?form='.$FormID.'" method="POST">
                    //                     <input type="hidden" name="editID" value='.$viewvals[$i][1].' />							
                    //                     <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Print Barcode" ><i class="fa fa-barcode"></i></button>
                    //                 </form>' ; 
                }
            // }
            //code to add print btn
            if((int)$viewSettings[16] > 0)
                $lastColumn .= '<button id="list-view-print-btn" class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="PRINT" onclick="ListViewVoucherPrint(\''.$viewvals[$i][1].'\')"><i class="fa fa-print"></i></button>';
                
            array_push($sub_array,"<div class='listview-actions'>" . $lastColumn . "</div>");
            $data[] = $sub_array;
        }
    }
    
}elseif(strlen($db[3]) > 0){
    if($result['result_set']){
        for($i=0; $i<sizeof($result['result_set']); $i++){
            $sub_array = array();
            $lastColumn = '';
            //Added checkbox at first column
            $checkbox = "<input type='checkbox' name='printRecords' id='".$result['result_set'][$i]['id']."' value='".$result['result_set'][$i]['id']."'>";
            array_push($sub_array,$checkbox);
            
            // print_r($columnArray);
            for($j=0; $j<sizeof($columnArray); $j++){
                // echo $viewvals[$i][sizeof($viewvals[$i])-1]."</br>";
                // echo $columnArray[$j]['Field'];
                if($columnArray[$j]['Field'] == "Edit"){	//EDIT 	  
                    if($access['canEdit']){    
                        //check invoice form ewaybill & einvoice bill if anyone generated then don't allow to edit & delete from preview page
                        $checkStatus = checkEwaybillAndEinvoice($viewvals[$i][1], $FormID, $formType);
                            
                        if ($checkStatus['ewaybill_generated'] != 1 && $checkStatus['einvoice_generated'] != 1) {        
                            $lastColumn .= '<form  name="form"  action="list-data.php?form='.$FormID.'" method="POST">
                                    <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							
                                    <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="edit" ><i class="fa fa-pencil"></i></button>
                                </form>' ; 
                        }
                        // array_push($sub_array,$x);
                    }
                }else{
                    if($columnArray[$j]['Field'] == "View"){	//Preview 	  
                        $lastColumn .= '<form  name="form"  action="list-data.php?form='.$FormID.'&preview='.$viewvals[$i][sizeof($viewvals[$i])-1].'" method="POST">
                                <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							
                                <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Preview (Ctrl + P)" ><i class="fa fa-eye"></i></button>
                            </form>' ; 
                        // array_push($sub_array,$x);
                    }else{
                       
                        if($columnArray[$j]['Field'] == "Delete"){	//DELETE 	
                            $viewlink = "";
                            if(isset($viewcodeextra)){
                                for($p = 0; $p < sizeof($viewcodeextra); $p++){
                                    if($viewcodeextra[$p][0] == -3){
                                        $viewlink = $viewcodeextra[$p][1];
                                        break;
                                    }
                                }
                            }
        
                            if($access['canDelete']){
                                 //check invoice form ewaybill & einvoice bill if anyone generated then don't allow to edit & delete from preview page
                                $checkStatus = checkEwaybillAndEinvoice($viewvals[$i][sizeof($viewvals[$i])-1], $FormID, $formType);
                                
                                if ($checkStatus['ewaybill_generated'] != 1 && $checkStatus['einvoice_generated'] != 1) {
                                    $lastColumn .= '<form method="POST" >
                                            <input type="hidden" name="delID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />    
                                            <button class="btn btn-danger bizbtn" id="delButton" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Delete" ><i class="fa fa-trash"></i></button>
                                        </form>' ; 
                                }
                                // array_push($sub_array,$x);
                            }	
                            
                        }else{
                            if($columnArray[$j]['Field'] == "Action"){	//OTHER BTN 	
                                $lastColumn .= '<form  action="' . $viewSettings[7] . '" method="POST">
                                        <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />
                                        <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="" ><i class="fa '.$viewSettings[6].'"></i></button>
                                    </form>' ; 
                                // array_push($sub_array,$x);	
                                
                            }else{
                                if($columnArray[$j]['Field'] == "Sr. No"){ //Serial Number
                                    
                                    if($i == 0){
                                        $k = 1;
                                    }
                                    $x = $_POST['start'] + $k ; 
                                    array_push($sub_array,$x);
                                    $k++;
                                }else{	
                                    if($columnArray[$j]['Type'] == "date" || $columnArray[$j]['Type'] == "timestamp" || $columnArray[$j]['Type'] == "smalldatetime" || $columnArray[$j]['Type'] == "datetime"){ //if DATE
                            
                                        // print_r($result['result_set']);
                                        $temp = $result['result_set'][$i][$columnArray[$j]['Field']];
                                        
                                        if($temp != NULL){
                                            if (gettype($temp) == "string"){
                                                $temp =  date("d-m-Y", strtotime($temp));
                                            }else{
                                                $temp = $temp->format('d-m-Y');
                                            }
                                        }
                                        
                                        array_push($sub_array,$temp);	
                                    }else{
                                        array_push($sub_array,Encoding::fixUTF8($result['result_set'][$i][$columnArray[$j]['Field']],Encoding::ICONV_IGNORE));
                                    }
                                }
                            }
                        }
                        
                    }
                }
                // echo $columnArray[$j]['Field'];
            }
            // if($access['canBarccodePrint']){
                if($isBarcodePrintBtn){
                    $lastColumn .= '<button id="list-view-barcode-btn" class="btn btn-primary bizbtn" style="font-size:10px;" data-toggle="tooltip" data-placement="bottom" title="Barcode" onclick="ListViewBarcodePrint(\''.$viewvals[$i][1].'\')"><i class="fa fa-barcode"></i></button>';
                    $lastColumn .= '<form  name="form"  action="print-barcodes.php?form='.$FormID.'" method="POST">
                                        <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							
                                        <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Print Barcode" ><i class="fa fa-barcode"></i></button>
                                    </form>' ; 
                }
            // }
            
            //code to add print btn
            if((int)$viewSettings[16] > 0)
                $lastColumn .= '<button id="list-view-print-btn" class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="PRINT" onclick="ListViewVoucherPrint(\''.$viewvals[$i][sizeof($viewvals[$i])-1].'\')"><i class="fa fa-print"></i></button>';

            array_push($sub_array,"<div class='listview-actions'>" . $lastColumn . "</div>");
            $data[] = $sub_array;
        }
    }
}else{

    for($i=0;$i<sizeof($viewvals); $i++){
        $sub_array = array();
        $lastColumn = '';
        //Added checkbox at first column
        $checkbox = "<input type='checkbox' name='printRecords' id='".$viewvals[$i]['id']."' value='".$result['result_set'][$i]['id']."'>";
        array_push($sub_array,$checkbox);
        
        for($j=0;$j<sizeof($viewcode); $j++){
           
            if($viewcode[$j][0] >= 0){
        
                $temp = $viewvals[$i][$viewcode[$j][0]];
                if($code[$viewcode[$j][0]][1] == 2){ //if SELECT

                    if($temp == 0) $temp = '-';

                    else $temp = $radio[$code[$viewcode[$j][0]][3]][$temp-1];
                }

                if($code[$viewcode[$j][0]][1] == 6){ //if DATE
                    
                    if($temp != NULL){
                        if (gettype($temp) == "string"){
                            $temp =  date("d-m-Y", strtotime($temp));
                        }else{
                            $temp = $temp->format('d-m-Y');
                        }
                    }
                }

                if($code[$viewcode[$j][0]][1] == 12){ //if MEDIA
                    //$temp =  "<img src=";
                }
                
                array_push($sub_array,Encoding::fixUTF8($temp,Encoding::ICONV_IGNORE));
            }

            if($viewcode[$j][0] == -1){ //Serial Number
                if($i == 0){
                    $k = $k+1;
                }
                $x = $_POST['start'] + $k ; 
                $k++;
                array_push($sub_array,$x);	
            }

            if($viewcode[$j][0] == -2){ //Edit
                if($access['canEdit']){
                    //check invoice form ewaybill & einvoice bill if anyone generated then don't allow to edit & delete from preview page
                    $checkStatus = checkEwaybillAndEinvoice($viewvals[$i][1], $FormID, $formType);
                            
                    if ($checkStatus['ewaybill_generated'] != 1 && $checkStatus['einvoice_generated'] != 1) {
                        $lastColumn .= '<form  name="form"  action="list-data.php?form='.$FormID.'" method="POST">
                                <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							
                                <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="edit" ><i class="fa fa-pencil"></i></button>
                            </form>' ; 
                    }
                }

                // $x = '<button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="edit" onclick="validateFormOnEdit(event,'.$viewvals[$i][sizeof($viewvals[$i])-1].');"><i class="fa fa-pencil"></i></button>' ; 

                // array_push($sub_array,$x);
            }

            if($viewcode[$j][0] == -5){ //Preview	  
                $lastColumn .= '<form  name="form"  action="list-data.php?form='.$FormID.'&preview='.$viewvals[$i][sizeof($viewvals[$i])-1].'" method="POST">
                        <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							
                        <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Preview (Ctrl + P)" ><i class="fa fa-eye"></i></button>
                    </form>' ; 
                // array_push($sub_array,$x);
            }

            if($viewcode[$j][0] == -3){ //Delete
                $viewlink = "";
                if(isset($viewcodeextra)){
                    for($p = 0; $p < sizeof($viewcodeextra); $p++){
                        if($viewcodeextra[$p][0] == -3){
                            $viewlink = $viewcodeextra[$p][1];
                            break;
                        }
                    }
                }

                if($access['canDelete']){
                    //check invoice form ewaybill & einvoice bill if anyone generated then don't allow to edit & delete from preview page
                    $checkStatus = checkEwaybillAndEinvoice($viewvals[$i][sizeof($viewvals[$i])-1], $FormID, $formType);
                    
                    if ($checkStatus['ewaybill_generated'] != 1 && $checkStatus['einvoice_generated'] != 1) {
                        $lastColumn .= '<form method="POST" >
                                <input type="hidden" name="delID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />
                                <button class="btn btn-danger bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="view" ><i class="fa fa-trash"></i></button>
                                </form>' ; 
                    }

                    // array_push($sub_array,$x);
                }
            }
            
            if($viewcode[$j][0] == -4){	//OTHER BTN 	
                $lastColumn .= '<form  action="' . $viewSettings[7] . '" method="POST">
                        <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />
                        <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="" ><i class="fa '.$viewSettings[6].'"></i></button>
                     </form>' ; 
                // array_push($sub_array,$x);		
            }
        }
        
        // if($access['canBarccodePrint']){
            if($isBarcodePrintBtn){
                $lastColumn .= '<button id="list-view-barcode-btn" class="btn btn-primary bizbtn" style="font-size:10px;" data-toggle="tooltip" data-placement="bottom" title="Barcode" onclick="ListViewBarcodePrint(\''.$viewvals[$i][1].'\')"><i class="fa fa-barcode"></i></button>';
                $lastColumn .= '<form  name="form"  action="print-barcodes.php?form='.$FormID.'" method="POST">
                                    <input type="hidden" name="editID" value='.$viewvals[$i][sizeof($viewvals[$i])-1].' />							
                                    <button class="btn btn-primary bizbtn" style="font-size:10px;" type="submit" data-toggle="tooltip" data-placement="bottom" title="Print Barcode" ><i class="fa fa-barcode"></i></button>
                                </form>' ; 
            }
        // }
        array_push($sub_array,"<div class='listview-actions'>" . $lastColumn . "</div>");
        // print_r($sub_array);
        $data[] = $sub_array;
    }
}

// print_r($data);


if(strlen($db[4]) > 1){
    $output = array(
        "draw"    => intval($_POST["draw"]),
        "recordsTotal"  =>  $result['result_set'][3][0]['recordstotal'],
        "recordsFiltered" => $result['result_set'][2][0]['recordsFiltered'],
        "data"    => $data
    );
}else{
    
    function get_all_data($tableName,$getPrimaryKey,$FormID){
        $query = "SELECT COUNT($getPrimaryKey) as cnt FROM $tableName WHERE 1=1 ";
        if($FormID == 1)   $query .= " AND GroupID = " . $_SESSION['group_id'] . " ";
        if($viewSettings[12] == 2){
            $query .= ' AND YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' ';
        }
        $result1 = db::getInstance()->db_select($query,"FTC-1050");

        return $result1['result_set'][0]['cnt'];
    }

    if($isFilter == 0){
        $number_filter_row = get_all_data($db[0],$db[1],$FormID);
    }
    // else{
    //     $number_filter_row = $result['num_rows'];
    // }
    
    $output = array(
        "draw"    => intval($_POST["draw"]),
        "recordsTotal"  =>  get_all_data($db[0],$db[1],$FormID),
        "recordsFiltered" => $number_filter_row,
        "data"    => $data
    );
}

if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    ob_start("ob_gzhandler");
} else {
    ob_start();
}
header('Content-Encoding: gzip');
header('Content-Type: application/json');
echo json_encode($output);
ob_end_flush();

?>
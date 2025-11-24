<?php
include '../dbClass.php';
// $ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
$FormID = isset($_GET['FormID']) ? $_GET['FormID'] : 0;
// include '../reportModel.php';
// $FormID = isset($_REQUEST['form']) ? $_REQUEST['form'] : 0;
// echo "hi";exit();
$k_head_title="Form";
$k_head_include = "";
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$viewpage = isset($_GET['view']) ? $_GET['view'] : 0;
include "../model.php";

// // Database configuration
// $host = 'localhost';      // Change if necessary
// $dbname = 'my_database';  // Your database name
// $username = 'root';       // Your database username
// $password = '';           // Your database password
// $FormID = isset($_GET['FormID']) ? $_GET['FormID'] : 0;
/*
Array
(
    [0] => Array
        (
            [0] => Entdt
            [1] => 6
            [2] => Date
            [3] => 0
            [4] => 
            [5] => 0
            [6] => 
            [7] => 1
            [8] => DateValidation="From=YearCode_Start&To=YearCode_End"
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 1
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 
            [19] => 
            [20] => 0
            [21] => 0
            [22] => 
            [23] => 0
            [24] => 
            [25] => 
            [26] => 0
            [27] => 
            [28] => 
            [29] => 0
            [30] => 0
            [31] => 
            [32] => 0
            [33] => 
            [34] => 0
            [35] => 0
            [36] => 0
            [37] => 0
            [38] => 
            [39] => 1
            [40] => 
            [41] => 0
            [42] => 250
            [43] => 
        )

    [1] => Array
        (
            [0] => Party
            [1] => 5
            [2] => Party
            [3] => -1
            [4] => 
            [5] => 0
            [6] => 
            [7] => 2
            [8] => 
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 1
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 
            [19] => 
            [20] => 0
            [21] => 0
            [22] => 
            [23] => 0
            [24] => 
            [25] => 
            [26] => 0
            [27] => 
            [28] => Response{pid | bname } DB { ASAB9}
            [29] => 0
            [30] => 0
            [31] => 
            [32] => 0
            [33] => 
            [34] => 0
            [35] => 0
            [36] => 0
            [37] => 0
            [38] => 
            [39] => 2
            [40] => 
            [41] => 0
            [42] => 250
            [43] => 
        )

    [2] => Array
        (
            [0] => TaskDescription
            [1] => 3
            [2] => Task Description
            [3] => 0
            [4] => 
            [5] => 1
            [6] => 
            [7] => 3
            [8] => 
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 1
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 
            [19] => 
            [20] => 2
            [21] => 0
            [22] => 
            [23] => 0
            [24] => 0
            [25] => 
            [26] => 0
            [27] => 
            [28] => 
            [29] => 0
            [30] => 0
            [31] => 
            [32] => 0
            [33] => 
            [34] => 0
            [35] => 0
            [36] => 0
            [37] => 0
            [38] => 
            [39] => 3
            [40] => 
            [41] => 0
            [42] => 250
            [43] => 
        )

    [3] => Array
        (
            [0] => isOnTime
            [1] => 15
            [2] => OnTime?
            [3] => 0
            [4] => 
            [5] => 0
            [6] => 
            [7] => 4
            [8] => 
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 0
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 
            [19] => 
            [20] => 0
            [21] => 0
            [22] => 
            [23] => 0
            [24] => 
            [25] => 
            [26] => 0
            [27] => 
            [28] => 
            [29] => 0
            [30] => 0
            [31] => 
            [32] => 0
            [33] => 
            [34] => 0
            [35] => 0
            [36] => 0
            [37] => 0
            [38] => 
            [39] => 4
            [40] => 
            [41] => 0
            [42] => 250
            [43] => 
        )

    [4] => Array
        (
            [0] => minutes
            [1] => 7
            [2] => Minutes
            [3] => 0
            [4] => 
            [5] => 0
            [6] => 
            [7] => 5
            [8] => 
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 1
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 
            [19] => 
            [20] => 0
            [21] => 0
            [22] => 
            [23] => 0
            [24] => 
            [25] => 
            [26] => 0
            [27] => 
            [28] => 
            [29] => 0
            [30] => 0
            [31] => 
            [32] => 0
            [33] => 
            [34] => 0
            [35] => 0
            [36] => 0
            [37] => 0
            [38] => 
            [39] => 5
            [40] => 
            [41] => 0
            [42] => 250
            [43] => 
        )

    [5] => Array
        (
            [0] => Category
            [1] => 5
            [2] => Category
            [3] => -2
            [4] => 
            [5] => 0
            [6] => 
            [7] => 6
            [8] => 
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 1
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 
            [19] => 
            [20] => 0
            [21] => 0
            [22] => 
            [23] => 0
            [24] => 
            [25] => 
            [26] => 0
            [27] => 
            [28] => 
            [29] => 0
            [30] => 0
            [31] => 
            [32] => 0
            [33] => 
            [34] => 0
            [35] => 0
            [36] => 0
            [37] => 0
            [38] => 
            [39] => 6
            [40] => 
            [41] => 0
            [42] => 250
            [43] => 
        )

    [6] => Array
        (
            [0] => Remark
            [1] => 1
            [2] => Remark
            [3] => 0
            [4] => 
            [5] => 0
            [6] => 
            [7] => 7
            [8] => 
            [9] => 0
            [10] => 0
            [11] => 0
            [12] => 0
            [13] => 1
            [14] => 0
            [15] => 0
            [16] => 0
            [17] => 0
            [18] => 
            [19] => 
            [20] => 0
            [21] => 0
            [22] => 
            [23] => 0
            [24] => 
            [25] => 
            [26] => 0
            [27] => 
            [28] => 
            [29] => 0
            [30] => 0
            [31] => 
            [32] => 0
            [33] => 
            [34] => 0
            [35] => 0
            [36] => 0
            [37] => 0
            [38] => 
            [39] => 7
            [40] => 
            [41] => 0
            [42] => 250
            [43] => 
        )

)


*/
// echo $FormID;

if($FormID > 0){    
    $viewvals = array();
    //there are 3 ways to get the data - SP, View, Table
    //if(strlen($db[3]) > 0){ //If ListViewDBName
        // $sqlfields = " " . $db[3].".*";
    // }else if(strlen($db[4]) > 0){ //If SPName
        // $sqlfields = " " . $db[4].".*";
    // }else{	//Table Name
        $sqlfields = " " . $db[0].".*";
    // }
    $sqljoin = "";
    $serialCntFrImages = 0;
    //if(strlen($db[3]) == 0 && strlen($db[4]) == 0){		//if it is not using SP or View, means Table name
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
                $sqlfields .= " , COALESCE(".$serials[$i].".".$extradb[$i][3].", '-') as ".$temp."_ddVal";
                $sqljoin .= " LEFT JOIN ".$extradb[$i][1]." ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i].".".$extradb[$i][2] ;
                //if($mediaFlag) goto a;
                a: $temp="";
            }
            $serialCntFrImages = sizeof($extradb);
        }
    // }

    //FOR MEDIA JOIN ONLY 12 on List View & 13 cannot be on List View
    // if(strlen($db[3]) == 0 &&  strlen($db[4]) == 0){		//if it is not using SP or View, means Table name
        if(isset($code)){
            for($j = 0; $j < sizeof($code); $j++){
                if($code[$j][1] == 12){ 
                    $temp = $code[$j][0];
                    $sqlfields .= " , ISNULL(".$serials[$i].".MediaName, '-') as ".$temp.$serials[$i]."Name";
                    $sqlfields .= " , ISNULL(".$serials[$i].".MediaFolder, '-') as ".$temp.$serials[$i]."Folder";
                    $sqlfields .= " , ISNULL(".$serials[$i].".MediaType, '-') as ".$temp.$serials[$i]."Type";
                    $sqljoin .= " LEFT JOIN kmainmedia ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i++].".MediaID";
                }
            }
        }else{
            echo "Please add Form fields";
            exit();
        }				
    // }
    // if(strlen($db[4]) > 0){		//USING SP
    //     $sql = $db[4]; //." Order by ".$db[0].'.'.$db[1]." Desc";
    //     $sqlColumns = "sp_describe_first_result_set N'$db[4]'";
    //     // $sqlColumns = $db[4];
    //     $data['params'] = [];
    //     $sp['values'] = [];
    //     $resultColumns = db::getInstance()->db_sp_select($sqlColumns, $data['params'], $sp['values']);
    //     $resultColumnsRow = $resultColumns['result_set'];
    // }else if(strlen($db[3]) > 0){	//USING VIEW
    //     $sql = "SELECT ".$sqlfields." FROM ".$db[3]; //." Order by ".$db[0].'.'.$db[1]." Desc";
    //     $sqlColumns = "SELECT * FROM information_schema.columns WHERE table_name="."'".trim($db[3])."'";
    //     $resultColumns = db::getInstance()->db_select($sqlColumns);
    //     $resultColumnsRow = $resultColumns['result_set'];
    // }else{		//USING TABLE
        if(strlen($db[2]) > 0)
            $sql = "SELECT ".$sqlfields." FROM ".$db[0]." " .$sqljoin."  ".$db[2]; //." Order by ".$db[0].'.'.$db[1]." Desc";
        else
            $sql = "SELECT ".$sqlfields." FROM ".$db[0]." " .$sqljoin."  Order by ".$db[0].'.'.$db[1]." Desc";
        //   $sql = "SELECT ".$sqlfields." FROM ".$db[0]." " .$sqljoin." ORDER BY ".$db[2]." DESC";
    // }

    // if (in_array($db[0],$MainDBTable)){	//CHECK WHY IS THIS USED?????????????????????
    //     $Instance = db::getInstanceMaster();
    //     $dbName = 'Main';
    // }else{
        // $Instance = db::getInstance();
        // $dbName = $_SESSION['dbName'];
    // }
    // if(strlen($db[4]) > 0){
    //     $resultColumns = db::getInstance()->db_sp_select($sql, $data['params'], $sp['values']);
    // }else{
        $result = db::getInstance()->db_select($sql);
    // }
    echo json_encode(array($result["result_set"],$code));
}
exit;


//THIS CODE IS NOT BEING USED AS IT GETS DATA FROM LISTVIEWDBNAME OR SP
if($FormID > 0){    
		$viewvals = array();
		//there are 3 ways to get the data - SP, View, Table
		if(strlen($db[3]) > 0){ //If ListViewDBName
			$sqlfields = " " . $db[3].".*";
		}else if(strlen($db[4]) > 0){ //If SPName
			$sqlfields = " " . $db[4].".*";
		}else{	//Table Name
			$sqlfields = " " . $db[0].".*";
		}
		// echo $sqlfields;
		$sqljoin = "";
		$serialCntFrImages = 0;
		if(strlen($db[3]) == 0 && strlen($db[4]) == 0){		//if it is not using SP or View, means Table name
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
					if($noFlag) goto na;
					$sqlfields .= " , COALESCE(".$serials[$i].".".$extradb[$i][3].", '-') as ".$temp."_ddVal";
					$sqljoin .= " LEFT JOIN ".$extradb[$i][1]." ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i].".".$extradb[$i][2] ;
					//if($mediaFlag) goto a;
					na: $temp="";
				}
				$serialCntFrImages = sizeof($extradb);
			}
		}
	
		//FOR MEDIA JOIN ONLY 12 on List View & 13 cannot be on List View
		if(strlen($db[3]) == 0 &&  strlen($db[4]) == 0){		//if it is not using SP or View, means Table name
			if(isset($code)){
				for($j = 0; $j < sizeof($code); $j++){
					if($code[$j][1] == 12){ 
						$temp = $code[$j][0];
						$sqlfields .= " , ISNULL(".$serials[$i].".MediaName, '-') as ".$temp.$serials[$i]."Name";
						$sqlfields .= " , ISNULL(".$serials[$i].".MediaFolder, '-') as ".$temp.$serials[$i]."Folder";
						$sqlfields .= " , ISNULL(".$serials[$i].".MediaType, '-') as ".$temp.$serials[$i]."Type";
						$sqljoin .= " LEFT JOIN kmainmedia ".$serials[$i]." ON ".$db[0].".".$temp." = ".$serials[$i++].".MediaID";
					}
				}
			}else{
				echo "Please add Form fields";
				exit();
			}				
		}
        if(strlen($db[4]) > 0){		//USING SP
			$sql = $db[4]; //." Order by ".$db[0].'.'.$db[1]." Desc";
			$sqlColumns = "sp_describe_first_result_set N'$db[4]'";
			// $sqlColumns = $db[4];
			$data['params'] = [];
			$sp['values'] = [];
			$resultColumns = db::getInstance()->db_sp_select($sqlColumns, $data['params'], $sp['values']);
			$resultColumnsRow = $resultColumns['result_set'];
		}else if(strlen($db[3]) > 0){	//USING VIEW
			$sql = "SELECT ".$sqlfields." FROM ".$db[3]; //." Order by ".$db[0].'.'.$db[1]." Desc";
			$sqlColumns = "SELECT * FROM information_schema.columns WHERE table_name="."'".trim($db[3])."'";
			$resultColumns = db::getInstance()->db_select($sqlColumns);
			$resultColumnsRow = $resultColumns['result_set'];
		}else{		//USING TABLE
			 $sql = "SELECT ".$sqlfields." FROM ".$db[0]." " .$sqljoin."  ".$db[2]; //." Order by ".$db[0].'.'.$db[1]." Desc";
            //   $sql = "SELECT ".$sqlfields." FROM ".$db[0]." " .$sqljoin." ORDER BY ".$db[2]." DESC";
		}
  
		if (in_array($db[0],$MainDBTable)){	//CHECK WHY IS THIS USED?????????????????????
			$Instance = db::getInstanceMaster();
			$dbName = 'Main';
		}else{
			$Instance = db::getInstance();
			$dbName = $_SESSION['dbName'];
		}
        if(strlen($db[4]) > 0){
			$resultColumns = db::getInstance()->db_sp_select($sql, $data['params'], $sp['values']);
		}else{
			$result = $Instance->db_select($sql);
		}
    echo json_encode(array($result["result_set"],$code));
}
exit;
?>
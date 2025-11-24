<?php 
//include "k_files/k_config.php";
$k_head_keywords = "";
$k_head_desc = "Admin Template";
$k_head_author = "KreonSolutions.com";
$k_head_login_check = 1;
$k_page_title = $k_head_title; 
include "k_files/k_header.php";

// $k_table_title = $k_head_title;
$ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
$k_debug = isset($k_debug) ? $k_debug : 0;

include 'reportModel.php';
// echo "report-init";exit();
//REPORT MODEL

function createReportFilters($arr, $viewResult,$requestArray){
    global $k_debug;

	// print_r($arr);
	
	$divClass = "";
	if($arr[5] !=0 ){	//Fields Size XS
		$divClass .= " col-xs-" . $arr[5] . " ";
	}

	if($arr[6] !=0 ){	//Field Size SM
		$divClass .= " col-sm-" . $arr[6] . " ";
	}

	if($arr[7] !=0 ){	//Fields Size MD
		$divClass .= " col-md-" . $arr[7] . " ";
	}

	if($arr[5] == 0 && $arr[6] == 0 && $arr[7] == 0 ){ //both the sizes are not set
		$divClass .= " col-md-4 ";
	}

    if($arr[3] == 1){ 	//Textbox
		if(isset($requestArray[$arr[1]])){
			$inputValue = $requestArray[$arr[1]];
		}else{
			$inputValue = "";
		}
		return "<div class='".$divClass."'><label>".$arr[0]."</label><input class='form-control dyn1' value='".$inputValue."' type='text' name='".$arr[1]."' id='".$arr[1]."' /></div>";
    }
    
    if($arr[3] == 6){ 	//Date
		if(isset($requestArray[$arr[1]])){
			$inputValue = $requestArray[$arr[1]];
		}else{
			$inputValue = "";
		}
		return "<div class='".$divClass."'><label>".$arr[0]."</label><input class='form-control dyn1' type='date' name='".$arr[1]."' id='".$arr[1]."' value='". $inputValue ."'/></div>";
	}

    if($arr[3] == 5){ 	//SELECT from DB
		$flds = '<div class='.$divClass.'><label>'.$arr[1].'</label>';

		$flds .= '<select data-plugin-selectTwo class="form-control populate '.$arr[1].'" name="'.$arr[2].'" id="'.$arr[2].'" class="form-control populate"';
		$flds .= '><option value=""></option>';
		
		$tmpID = array();
		$tmpLabel = array();
		for($j = 0; $j < $viewResult['num_rows']; $j++){
			$tmpID[$j] = $viewResult['result_set'][$j][$arr[2]];
			$tmpLabel[$j] =$viewResult['result_set'][$j][$arr[1]];
		}
		
		$finalID = array_unique($tmpID);
		$finalLabel = array_unique($tmpLabel);
		//print_r($finalID);
		for($i = 0; $i <= sizeof($tmpID); $i++){
			if(isset($finalID[$i]) || isset($finalLabel[$i])){
				//Sprint_r(gettype($finalLabel[$i]));
				//if(in_array(isset($requestArray[$arr[2]]),$finalID)){
				if(isset($requestArray[$arr[2]])){
					if(in_array($finalID[$j], $requestArray[$arr[2]])){
						$flds .= '<option selected value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					} else{
						$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					}
				}else{
					$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
				}

			}
		}
        $flds .= '</select></div>';
		return $flds;
	}

	if($arr[3] == 11){ 	//MULTI SELECT SEARCH from DB WITH MAPPING TABLE
		$flds = "<div class='".$divClass."'><label>".$arr[0]."</label>";
		$flds .= '<select multiple data-plugin-selectTwo class="form-control populate '.$arr[1].'" name="'.$arr[2].'[]">';		   
		
		$tmpID = array();
		$tmpLabel = array();
		for($j = 0; $j < $viewResult['num_rows']; $j++){
			$tmpID[$j] = $viewResult['result_set'][$j][$arr[2]];
			$tmpLabel[$j] =$viewResult['result_set'][$j][$arr[1]];
		}
		
		//print_r($tmpID);
		$finalID = array_unique($tmpID);
		$finalLabel = array_unique($tmpLabel);
		//print_r($finalID);
		//print_r($requestArray);
		for($j = 0; $j < sizeof($tmpID); $j++){
			if(isset($finalID[$j]) || isset($finalLabel[$j])){
				//if(in_array(isset($requestArray[$arr[2]][$j]),$finalID)){
				if(isset($requestArray[$arr[2]])){
					if(in_array($finalID[$j], $requestArray[$arr[2]])){
						$flds .= '<option selected value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					} else{
						$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
					}
				} else{
					$flds .= '<option value="'.$finalID[$j].'">'.$finalLabel[$j].'</option>';
				}
			}
		}
        $flds .= '</select></div>';
		return $flds;
	}	
}

function createReportTable($result1, $viewResult){
	// print_r($viewResult);
	$align = "";
	$sum = 0;
	$tableFld = "";
	$flag = 0;
	$sumField = array();
	// $totalField = "";
	// print_r($result1);
	$tableFld = '<thead>';
            
                $columns = array();
				$tableFld .= "<tr>";
                for($i = 0; $i < $result1['num_rows']; $i++){
					$row = $result1['result_set'][$i];
    				array_push($columns,array("ViewFieldName" => $row['ViewFieldName'], "Alignment" => $row['Alignment'], "ShowTotal" => $row['ShowTotal']));
                    $tableFld .= "<th>" . $row['DisplayName'] . "</th>";              
                }
                $tableFld .= "</tr>";
				
				$tableFld .= '</thead><tbody>';
                
				
                for($j = 0; $j < $viewResult['num_rows']; $j++){
					
					$tableFld .= "<tr>";
                    $row1 = $viewResult['result_set'][$j];
					
					//print_r($row1);
                    for($i=0; $i<count($columns); $i++){
						// print_r([$columns[$i]['ViewFieldName']]);
						if(in_array($columns[$i]['Alignment'], array("1","0"))){	
							$align = "left";
						}elseif($columns[$i]['Alignment'] =="2"){
							$align = "center";
						}elseif($columns[$i]['Alignment'] == "3"){
							$align = "right";
						}					
						
                        $tableFld .= "<td align= '".$align."'>" . $row1[$columns[$i]['ViewFieldName']] . "</td>";  
                    }
					
                    $tableFld .= "</tr>";
                }
				$footerTotal = array();
				for($i=0; $i<count($columns); $i++){
					if($columns[$i]['ShowTotal'] == 1){
						$flag = 1;
						$footerTotal[$i] = array_sum(array_column($viewResult['result_set'],$columns[$i]['ViewFieldName']));
					}
				}
        
		$tableFld .= '</tbody>';
		if($flag == 1){
			$tableFld .= '<tfoot>';
				$tableFld .= '<tr>';
				for($i=0; $i<count($columns); $i++){
					if($columns[$i]['ShowTotal'] == 1){
						$tableFld .= '<td align="'.$align.'">'.$footerTotal[$i].'</td>';
					}else{
						$tableFld .= '<td align="'.$align.'"></td>';
					}
				}
				$tableFld .= '</tfoot>';
				$tableFld .= '</tr>';
		
		}
		
		return $tableFld;
}

?>
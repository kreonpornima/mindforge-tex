<!-- https://js.devexpress.com/jQuery/Documentation/ApiReference/Data_Layer/PivotGridDataSource/ -->

<?php
  $filterCode = array();
  $ReportID = isset($_REQUEST['ReportID']) ? $_REQUEST['ReportID'] : 0;
  $k_head_title="Report";
  $k_head_include = "";
  include "report-init.php";

  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
      $url = "https://";   
  else  
      $url = "http://";  
  $url .= $_SERVER['HTTP_HOST'];   
  $url.= $_SERVER['REQUEST_URI'];
  $urlpos = strpos($url, '&', strpos($url, '&') + 1);
  $url = substr($url, 0, $urlpos);
  $sql = "SELECT * FROM $db[0] WHERE 1=1 LIMIT 10";
  $requestArray = [];

  for($i = 0; $i < sizeof($filterCode); $i++){
      if(isset($_REQUEST[$filterCode[$i][1]]) || isset($_REQUEST[$filterCode[$i][2]])){
          if(isset($_REQUEST[$filterCode[$i][1]])){
              $requestArray[$filterCode[$i][1]] = $_REQUEST[$filterCode[$i][1]];
          }else{
              $requestArray[$filterCode[$i][2]] = $_REQUEST[$filterCode[$i][2]];
          }
      }
  }
  // echo $viewReportSettings[3];

  foreach($_REQUEST as $name => $value) {
      if($name != "ReportID" && $name != "view") {
          // $requestArray[$name] = $value;
          if(isset($name)) {
              if(gettype($value) == "array") {
                  if(sizeof($value) > 0) {
                      $sql .= " AND $name IN ('" . implode("','", $value) . "' ) ";
                  }
              } else {
                  if(is_numeric($value)) {
                      $valueINT = (int) $value;
                      if($valueINT !== 0) {
                         $sql .= " AND $name = $valueINT ";
                      }
                  } else {
                      if(strlen($value) > 0) {
                          $sql .= " AND $name = '$value' ";
                      }
                  }
              }
          }
      }
  }

  // echo 
  $viewResult = db::getInstance()->db_select($sql);
  // print_r($viewResult);
  // echo json_encode($viewResult['result_set']);
  $dateColumns = array();
  $dateColumnCount = 0;
  
  for($i =0; $i < $viewResult['num_rows']; $i++){
    foreach($viewResult['result_set'][$i] as $key => $value){
      if (validateDate($value, 'Y/m/d')) {  // it's a date
        if(!in_array($key, $dateColumns)) $dateColumns[$dateColumnCount++] = $key;
      }
      if (validateDate($value, 'Y-m-d')) {  // it's a date
        if(!in_array($key, $dateColumns)) $dateColumns[$dateColumnCount++] = $key;
      }
    }
  }
  // print_r($dateColumns);
  if($dateColumnCount > 0){
    $dateDataSource = "fields :[";
    $separator = "";
    for($i = 0; $i < $dateColumnCount; $i++){
      $dateDataSource .= $separator . "{
          dataField:'".$dateColumns[$i]."',
          dataType:'date'
        }";
      $separator = ",";
    }
      $dateDataSource .= "],";
  }
  function validateDate($date, $format = 'Y-m-d'){
      $d = DateTime::createFromFormat($format, $date);
      // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
      return $d && $d->format($format) === $date;
  }
?>
<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script>

<div id="myGrid" style="height: 100%" class="ag-theme-quartz"></div>
 
<script>
    agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-059380}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{30 June 2024}____[v3]_[0102]_MTcxOTcwMjAwMDAwMA==59fc6bfa6d27f2fc6c8e0be66a04b355");

    let gridApi;

    const gridOptions = {
        columnDefs: [
            { field: "athlete" },
            { field: "age" },
            { field: "country" },
            { field: "year" },
            { field: "date" },
            { field: "sport" },
            { field: "gold" },
            { field: "silver" },
            { field: "bronze" },
            { field: "total" },
        ],
        defaultColDef: {
            editable: true,
            cellDataType: false,
        },
    };

    console.log("111");
    // setup the grid after the page has finished loading
    document.addEventListener("DOMContentLoaded", () => {
        const gridDiv = document.querySelector("#myGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);
        console.log("222");

        fetch("https://www.ag-grid.com/example-assets/olympic-winners.json")
            .then((response) => response.json())
            .then((data) => gridApi.setGridOption("rowData", data));
    });

</script>  
   
<?php 
	include "report-close.php"; 
?>
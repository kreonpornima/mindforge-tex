<?php
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
// echo $url;

$sql = "SELECT * FROM $db[0] WHERE 1=1 ";
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

foreach($_REQUEST as  $name => $value){
    if($name != "ReportID" && $name != "view"){
        // $requestArray[$name] = $value;
        if(isset($name)){
            if(gettype($value) == "array"){
                if(sizeof($value) > 0) $sql .= " AND $name IN ( " . implode(",", $value) . " ) ";
            }else{
                if(strlen($value) > 0) $sql .= " AND $name = $value ";
            }
        }
    }
}
// echo $sql;
$viewResult = db::getInstance()->db_select($sql);

?>

<!-- <link rel="stylesheet" type="text/css" href="/assets/vendor/jquery-datatables/extras/TableTools/css/dataTables.tableTools.css">
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/buttons.bootstrap4.min.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/buttons.print.min.js"></script> -->

<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 

<link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/23.2.4/css/dx.light.css">
<!-- <link rel="stylesheet" href="index.css"> -->

<script type="text/javascript" src="https://cdn3.devexpress.com/jslib/23.2.4/js/dx.all.js"></script>
<!-- <script type="text/javascript" src="index.js"></script> -->

<section class="panel">
    <header class="panel-heading">
		<div class="panel-actions"></div>
		<h2 class="panel-title"><?php echo $viewReportSettings[0]; ?></h2>
		<p class="panel-subtitle"></p>
	</header>
	<!-- <form method="get">
	<div class="panel-body">

	</div>
	</form> -->
    <!--<div class="panel-body">-->
    <div class="panel-body" class="dx-viewport">
		<div id="dataGrid">HIIII</div>
			<style>
                #dataGrid {
                    height: 500px;
                }
			</style>

            <script>    
                $(function () {
                    // Fetch data from the URL
                    fetch("reportGetDataFromView.php?ViewName=<?php echo $ReportID; ?>")
                    .then((response) => response.json())
                    .then((dataObject) => {
                        // Check if dataObject is an object and has 'data' property
                        if (typeof dataObject === "object" && dataObject.hasOwnProperty("data")) {
                            const dataArray = dataObject.data; // Extract the 'data' array
                            console.log("Fetched data:", dataArray); // Log the fetched data to console for inspection

                            $("#dataGrid").dxDataGrid({
                                dataSource: dataArray,
                                // keyExpr: "ID",
                                // columns: [
                                //     { dataField: "id" },
                                //     { dataField: "title" },
                                //     { dataField: "price" },
                                //     { dataField: "rating" },
                                //     { dataField: "stock" },
                                //     { dataField: "discountprecentage" }
                                // ],
                                showBorders: true,
                                filterRow: {
                                    visible: true,
                                    applyFilter: "auto"
                                },
                                
                                filterPanel: { visible: true },
                                headerFilter: { visible: true },

                                searchPanel: {
                                    visible: true,
                                    width: 240,
                                    placeholder: "Search..."
                                },
                                paging: {
                                    pageSize: 10
                                },
                                columnChooser: {
                                    enabled: true,
                                    // mode: "dragAndDrop" // or "select"
                                },
                                stateStoring: {
                                    enabled: false,
                                    type: "custom",
                                    customLoad: function () {
                                        return sendStorageRequest("organisatieKey", "json", "GET",dataArray);
                                    },
                                    customSave: function (gridState) {
                                        console.log(gridState);
                                        return sendStorageRequest("organisatieKey", "text", "PUT", gridState);
                                    },
                                }
                            });
                        } 
                        else {
                            console.error("Error: Invalid data format or missing 'data' array.");
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching data:", error);
                    });
                });
                
                // function sendStorageRequest(key, datatype, type, data) {
                //     var deferred = $.Deferred();
                //     if(data !== undefined)
                //         var d = JSON.stringify(data);
                //     else
                //         var d = "";
                //     console.log(data); //<-- here it is showing undefined while returning 
                //     var storageRequestSettings = {
                //         url:
                //             "reportDataGrid1DataStorage.php?ReportID=<?php echo $ReportID; ?>&data=" + d,
                //             // key,
                //             headers: {
                //             Accept: "text/html",
                //             "Content-Type": "text/html",
                //         },
                //         type: type,
                //         dataType: datatype,
                //         success: function (data) {
                //             console.log("Success");

                //             console.log(data);
                //             deferred.resolve(data);
                //         },
                //         error: function (jqXHR, textStatus, errorThrown) {
                //             deferred.reject();
                //         },
                //     };
                //     if (data) {
                //         console.log("SENDING...");
                //         storageRequestSettings.data = JSON.stringify(data); 
                //     } else {
                //         console.log("RECEIVING...");
                //     }
                //     $.ajax(storageRequestSettings);
                //     return deferred.promise();
                // } --> OG

                function sendStorageRequest(key, datatype, type, data) {
                    console.log("HELLL");
                    var deferred = $.Deferred();
                    var d = data !== undefined ? JSON.stringify(data) : "";
                    console.log(data);

                    var storageRequestSettings = {
                        url: "reportDataGridDataStorage.php?ReportID=<?php echo $ReportID; ?>&data=" + d,
                        headers: {
                            Accept: "text/html",
                            "Content-Type": "text/html",
                        },
                        type: type,
                        dataType: datatype,
                        success: function (data) {
                            console.log("Success");
                            console.log(data);
                            deferred.resolve(data);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            deferred.reject();
                        },
                    };

                    if (data) {
                        console.log("SENDING...");
                        // console.log(data);
                        storageRequestSettings.data = JSON.stringify(data); 
                    } else {
                        console.log("RECEIVING...");
                    }

                    $.ajax(storageRequestSettings);
                    return deferred.promise();
                }

            </script>
            
    </div>
</section>








<!--GENERAL ON LOAD SCRIPT FOR THE ENTIRE PAGE -->
<script>
	$(document).ready(function() {
	    $(".page-header").html("<h2><?php echo $viewReportSettings[1]; ?></h2>");
	    $(document).prop('title', '<?php echo $viewReportSettings[1]; ?>');
	//    // $('form').attr('action', 'db_backup_31.php');
	});
	function getTodaysDate(){
	    var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = ((''+day).length<2 ? '0' : '') + day + '/'
            + ((''+month).length<2 ? '0' : '') + month + '/' 
            + d.getFullYear();
        return(output);
	}
	function formatDate(dt){
        const d = new Date(dt);
        // return d.getDate().toString().padStart(2, '0') + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = ((''+day).length<2 ? '0' : '') + day + '/'
            + ((''+month).length<2 ? '0' : '') + month + '/' 
            + d.getFullYear();
        return(output);
	}
	function formatReverseDate(dt){
        const d = new Date(dt);
        // return d.getDate().toString().padStart(2, '0') + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = d.getFullYear() + '-'
            + ((''+month).length<2 ? '0' : '') + month + '-' 
            + ((''+day).length<2 ? '0' : '') + day
            ;
        return(output);
	}
	
	//FUNCTION NOT YET USED BUT CAN BE USED INSTEAD OF formatReverseDate
	function getDateFormat(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
        
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        var date = new Date();
        date.toLocaleDateString();
        
        return [day, month, year].join('-');
    }

</script>

<?php 
	include "report-close.php"; 
?>
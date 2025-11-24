<?php

include_once('dbClass.php');
session_start();
ini_set('display_errors', 1); 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
error_reporting(0);
$k_head_title="HOME";
$k_page_title ='HOME';
include 'k_files/k_header.php';
// echo "hello";
// echo count($result['result_set'][0]);
// echo '<br /><center><h2>Welcome';

if(count($result['result_set']) == 0){
    echo '<h5>There are no module assign to this user. Please contact to Administrator of this company</h5>';
}else{
    if($result['result_set'][0][0]['MenuLevel'] == 2){
        echo "<h5>user doesnt have access to menu level 1</h5>";
    }else{
        echo '<br /><center><h2>Welcome</h2>';
    }
}
// if($_SESSION['user_id'] == 1025 ){
//     // echo $sql = "SELECT * FROM OPENROWSET(BULK N'V:\\xampp\\htdocs\\tex\\qrcodes\\Einvoice_5189_17_356.png', SINGLE_BLOB) AS ImageFile";
//     echo $sql = "SELECT * FROM OPENROWSET(BULK N'C:\\Temp\\Einvoice_5189_17_356.png', SINGLE_BLOB) AS ImageFile";
//     $rs = db::getInstanceMaster()->db_select($sql);
//     print_r($rs);
//     echo "<br />";
    
//     // echo $sql = "SELECT * FROM OPENROWSET(BULK N'V:\\xampp\\htdocs\\tex\\qrcodes\\Einvoice_5189_17_356.png', SINGLE_BLOB) AS ImageFile";
//     // $rs = db::getInstance()->db_update($sql);
//     // print_r($rs);
// }
// echo $_SESSION['dbName'];


if($_SESSION['dbCompany'] != 23){
?>
<button id="syncButton" class="btn btn-warning">Sync Data</button>
<?php } ?>

<?php
// echo $_SESSION['group_id'];
include "k_files/k_footer.php"; 
?>
<script>
    $(document).ready(function(){
        $(".sidebar-toggle").click();
        $("#mySearch").focus();
        $(".page-header h2").html("Home");
	    $(document).prop('title', 'Home');
        // setTimeout(function() {
        //     $("#mySearch").val(' ');
        //     }, 2000);
    });

    $("#syncButton").on("click", function() {
        $.ajax({
            url: "syncData.php", // Create this PHP file
            type: "POST",
            data: { action: "sync" },
            success: function(response) {
                // console.log("Response: " + response);
                console.log("✅ Sync success:\n" + response);
                alert("✅ Sync completed.\nCheck console for details.");
            },
            error: function(xhr) {
                // alert("Error: " + error);
                console.error("❌ Sync failed:", xhr.responseText);
                alert("❌ Sync failed:\n" + xhr.responseText);
            }
        });
    });
</script>

    
<?php


session_start();
$k_head_title = "Master Roles";
$k_page_title = 'Master Roles';
include 'k_files/k_header.php';

$k_head_include = '
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <style>
        .multi-check {
            border: 1px solid #cacaca;
            padding: 5px;
            padding-left: 10px;
            max-height: 90px;
            overflow-y: scroll;
        }
        button.btn.btn-danger {
            display: none;
        }
    </style>
';

$k_table_title = "Settings";

$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$viewpage = isset($_GET['view']) ? $_GET['view'] : 0;
$viewID = isset($_POST['viewID']) ? $_POST['viewID'] : 0;

$isGeoLocking = "";
// if((int)$editID > 0){
	$sql = "SELECT * FROM settings WHERE UserID = {$_SESSION['user_id']}";
	$result = db::getInstanceMaster()->db_select($sql);	
	for($i = 0; $i < $result['num_rows']; $i++){
        $isGeoLocking= $result['result_set'][$i]['isGeoLocking']; 
	}
// }



?>

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <!-- Extra Buttons (optional) -->
        </div>
        <h2 class="panel-title"><?php echo $k_table_title; ?></h2>
        <p class="panel-subtitle"><?php echo isset($k_table_subtitle) ? $k_table_subtitle : ""; ?></p>
    </header>
    <div class="panel-body">
        <form class="form-bordered" method="post" id="settingsForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3"><label>Enable Geo Locking </label></br></div>
                <div class="col-md-3">
                    <div class='switch switch-sm switch-primary'>
                        <input type='checkbox' class="form-control dyn1" name="isGeoLocking" id="isGeoLocking" value='1' data-plugin-ios-switch=''  style='display: none;' tabindex="8" <?= ($isGeoLocking == 1 ? "checked='checked'" : "") ?>>
                    </div>
                </div>
            </div>

        </form>
        <!-- <table class="table table-bordered table-striped" id="datatable-table">
            <thead>
                <?php echo $k_table_headings; ?>
            </thead>
            <tbody>
                <?php echo $k_table_body; ?>
            </tbody>
        </table> -->
    </div>
</section>

<!-- DataTables JS and Initialization -->
<!-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {

        // 🔹 Trigger AJAX submit whenever checkbox changes
        $('#isGeoLocking').on('change', function() {
            var formData = $('#settingsForm').serialize(); // get all form fields
            console.log(formData);
            $.ajax({
                url: 'settingdb.php',
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    console.log('Saving settings...');
                },
                success: function(response) {
                    console.log('Server response:', response);
                    // Optional toast or alert
                    // alert('Settings saved successfully!');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Error saving settings.');
                }
            });
        });

    });
</script>


<?php
$k_footer_before = '
    <script src="/assets/vendor/select2/js/select2.js"></script>
    <script src="/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
';


include "k_files/k_footer.php";
?>

<?php
$k_head_title = 'Geo Locking Manage';
$k_head_keywords ='Geo locking';
$k_head_desc ='';
$k_head_author ='KreonSolutions.com';
$k_page_title ='Geo Locking';
include 'k_files/k_header.php';
$k_head_include = '
		<link rel="stylesheet" href="assets/vendor/select2/css/select2.css" />
		<link rel="stylesheet" href="assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		
		<style>
			.multi-check {
				border: 1px solid #cacaca;
				padding: 5px;
				padding-left: 10px;
				max-height: 90px;
				overflow-y: scroll;
			}
		</style>
';

$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$viewpage = isset($_GET['view']) ? $_GET['view'] : 0;
$viewID = isset($_POST['viewID']) ? $_POST['viewID'] : 0;

$ipv4address = $name = $role = $group = $isactive = "";
if((int)$editID > 0){
	$sql="SELECT geoLockings.ID as ID, geoLockings.Name as Name, geoLockings.IPv4Address as IPv4Address, AiGroup.Label as Label, geoLockings.isActive as isActive FROM geoLockings LEFT JOIN AiGroup ON AiGroup.ID = geoLockings.GroupID where geoLockings.ID = " . $editID;
	$result = db::getInstanceMaster()->db_select($sql);	
	for($i = 0; $i < $result['num_rows']; $i++){
        $name= $result['result_set'][$i]['Name']; 
        $ipv4address= $result['result_set'][$i]['IPv4Address']; 
        $role= $result['result_set'][$i]['Role']; 
        $group = $result['result_set'][$i]['Label']; 
        $isactive= $result['result_set'][$i]['isActive']; 
	}
}

if((int)$editID > 0){
    $btnName = "Update";
}else{
    $btnName = "SAVE";
}

?>

<script>
    $(document).ready(function() {
        const isEditMode = <?php echo ((int)$editID > 0) ? 'true' : 'false'; ?>;
        let hasShownError = false; // New flag to prevent infinite alerts

        function updateLabel(fieldId, isRequired) {
            const label = $("label[for='" + fieldId + "']");
            label.find(".required").remove();
            if (isRequired) {
                label.append('<span class="required"> *</span>');
            }
        }

        function showError(inputId, message) {
            if (hasShownError) return;
            hasShownError = true;
            alert(message);
            setTimeout(function () {
                $('#' + inputId).focus();
                hasShownError = false;
            }, 100);
        }



        $('form').on('submit', function (e) {
            const username = $('#username').val();
            let valid = true;

            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>


	
<script>
    $(document).ready(function() {
        $('#addAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_add').prop('checked', true);
            }else{
                $('.ch_add').prop('checked', false);
            }     
        });
        $('#editAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_edit').prop('checked', true);
            }else{
                $('.ch_edit').prop('checked', false);
            }     
        });
        $('#delAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_delete').prop('checked', true);
            }else{
                $('.ch_delete').prop('checked', false);
            }     
        });
        $('#listAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_listview').prop('checked', true);
            }else{
                $('.ch_listview').prop('checked', false);
            }     
        });
        $('#otherAll').change(function() {
            if(this.checked) {
                var returnVal = confirm("Are you sure?");
                $(this).prop("checked", returnVal);
                if(returnVal)   $('.ch_other').prop('checked', true);
            }else{
                $('.ch_other').prop('checked', false);
            }     
        });
        
    });

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Users</h2>
	</header>
<div class="panel-body">
	<div class="col-md-12">
		<form class="form-bordered" method="post" action="geoLockingdb.php" enctype="multipart/form-data">
			<div class="row">
    			<div class="col-md-12">
                    <div class="col-md-3"><label>Name <span class="required">*</span></label>
				        <input required="" class="form-control dyn1" value="<?php echo $name; ?>" type="text" name="name" id="name" tabindex="1"/>
				    </div>

    				<div class="col-md-3"><label>IPv4 Address <span class="required">*</span></label>
				        <input required="" class="form-control dyn1" value="<?php echo $ipv4address; ?>" type="text" name="ipv4address" id="ipv4address" tabindex="3"/>
				    </div>

                    <div class="col-md-3"><label>isActive </label></br>
                        <div class='switch switch-sm switch-primary'>
                            <input type='checkbox' class="form-control dyn1" name="isActive" id="isActive" value='1' data-plugin-ios-switch=''  style='display: none;' tabindex="8" <?= ($isactive == 1 ? "checked='checked'" : "") ?>>
                        </div>
				    </div

				</div>

			</div>
			
		</br></br>
					
			<div class="row">
    			<div class="col-md-12">
    				<label class="col-md-4 control-label"></label>
    				<input type="hidden" value="<?php echo $editID; ?>" name="editID"><br>
    				<input type="submit" value="<?php echo $btnName; ?>" class="btn btn-primary">
    				<a href="geoLockingdb.php?view=1" class="btn btn-danger">CANCEL</a>			
    			</div>
			</div>
		</form> 
	</div>	
</div>
<?php include "k_files/k_footer.php"; ?>
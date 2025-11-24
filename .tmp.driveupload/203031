<?php
$k_head_title = 'User Manage';
$k_head_keywords ='Page Role Access';
$k_head_desc ='';
$k_head_author ='KreonSolutions.com';
$k_page_title ='Page Role Access';
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

$username = $name = $role = $groupid = $authmode = $password = $telegramid = $emailid = $usercategory = $isactive = "";
if((int)$editID > 0){
	$sql="SELECT * FROM users where ID = " . $editID;
	$result = db::getInstanceMaster()->db_select($sql);	
	for($i = 0; $i < $result['num_rows']; $i++){
        $username= $result['result_set'][$i]['Username']; 
        $name= $result['result_set'][$i]['Name']; 
        $role= $result['result_set'][$i]['Role']; 
        $groupid = $result['result_set'][$i]['GroupID']; 
        $authmode = $result['result_set'][$i]['Authmode']; 
        $password= $result['result_set'][$i]['Password']; 
        $telegramid = $result['result_set'][$i]['TelegramID']; 
        $emailid = $result['result_set'][$i]['EmailID']; 
        $usercategory= $result['result_set'][$i]['Category']; 
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

        function toggleFields() {
            const mode = $('#authmode').val();

            if (!isEditMode) {
                $('#password, #telegramId').val('');
            }

            $('#password, #telegramId').prop('readonly', true).prop('required', false);
            updateLabel("password", false);
            updateLabel("telegramId", false);

            if (mode == '1') {
                $('#password').prop('readonly', false).prop('required', true);
                updateLabel("password", true);
            } else if (mode == '2') {
                $('#telegramId').prop('readonly', false).prop('required', true);
                updateLabel("telegramId", true);
            } else if (mode == '3') {
                // Optional for WhatsApp OTP
            }
        }

        $("label").each(function() {
            const input = $(this).nextAll('input, select').first();
            if (input.length && !$(this).attr('for')) {
                $(this).attr('for', input.attr('id'));
            }
        });

        $('#authmode').change(toggleFields);
        toggleFields();

        function isValidMobile(mobile) {
            return /^\d{10}$/.test(mobile);
            // return /^[6-9]\d{9}$/.test(mobile);
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

        $('#username').blur(function () {
            const username = $(this).val();

            if (username === '') {
                // Allow empty value (required will handle on submit)
                return;
            }

            if (!isValidMobile(username)) {
                showError('username', 'Please enter a valid 10-digit mobile number starting with 6-9.');
                return;
            }

            $.ajax({
                url: 'check_mobile_exists.php',
                method: 'POST',
                data: { username: username, editID: <?php echo (int)$editID; ?> },
                success: function (response) {
                    if (response === 'exists') {
                        $('#username').val('');
                        showError('username', 'This mobile number is already registered.');
                    }
                }
            });
        });

        $('#username').on('input', function () {
            hasShownError = false;
        });

        $('form').on('submit', function (e) {
            const username = $('#username').val();
            let valid = true;

            if (!isValidMobile(username)) {
                showError('username', 'Please enter a valid 10-digit mobile number starting with 6-9.');
                valid = false;
            }

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
		<form class="form-bordered" method="post" action="usersdb.php" enctype="multipart/form-data">
			<div class="row">
    			<div class="col-md-12">
                    <div class="col-md-3"><label>Name <span class="required">*</span></label>
				        <input required="" class="form-control dyn1" value="<?php echo $name; ?>" type="text" name="name" id="name" tabindex="1"/>
				    </div>

                    <div class="col-md-3"><label>Role <span class="required">*</span></label>
                        <?php
                            $sql="SELECT * FROM pagerolemaster WHERE GroupID = " . $_SESSION['group_id'] ." AND RoleId != 54";
                            $result = db::getInstanceMaster()->db_select($sql);	
                        ?>
                        <select class="form-control dyn1" name="role" id="role" tabindex="2">
                            <?php 
                                if (!empty($result['result_set'])) {
                                    foreach ($result['result_set'] as $row) {
                                        $selected = ($row['RoleId'] == $role) ? 'selected' : '';
                                        echo '<option value="' . $row['RoleId'] . '" ' . $selected . '>' . htmlspecialchars($row['Label']) . '</option>';
                                    }
                                }else {
                                    echo '<option value="">Select</option>';
                                }
                            ?>
                        </select>
				        
				    </div>

    				<div class="col-md-3"><label>Username <span class="required">*</span></label>
				        <input required="" class="form-control dyn1" value="<?php echo $username; ?>" type="text" name="username" id="username" tabindex="3"/>
				    </div>

                    <div class="col-md-3"><label>Authmode <span class="required">*</span></label>
                        <select class="form-control dyn1" name="authmode" id="authmode" tabindex="4">
                            <option value="">Select</option>
                            <option value="1" <?php echo ($authmode == 1) ? 'selected' : ''; ?> >Password</option>
                            <option value="2" <?php echo ($authmode == 2) ? 'selected' : ''; ?>>Telegram OTP</option>
                            <option value="3" <?php echo ($authmode == 3) ? 'selected' : ''; ?>>WhatsApp OTP</option>
                        </select>
				    </div>

				</div>

                <div class="col-md-12">
                    <div class="col-md-3"><label>Password</label>
				        <input readonly required="" class="form-control dyn1" value="<?php echo $password; ?>" type="text" name="password" id="password" tabindex="5"/>
				    </div>

                    <div class="col-md-3"><label>TelegramID </label>
				        <input readonly required="" class="form-control dyn1" value="<?php echo $telegramid; ?>" type="text" name="telegramId" id="telegramId" tabindex="6"/>
				    </div>

                    <div class="col-md-3"><label>EmailID </label>
				        <input class="form-control dyn1" value="<?php echo $emailid; ?>" type="text" name="emailId" id="emailId" tabindex="7"/>
				    </div>

                    <div class="col-md-3"><label>isActive </label></br>
                        <div class='switch switch-sm switch-primary'>
                            <input type='checkbox' class="form-control dyn1" name="isActive" id="isActive" value='1' data-plugin-ios-switch=''  style='display: none;' tabindex="8" <?= ($isactive == 1 ? "checked='checked'" : "") ?>>
                        </div>
				    </div>

    				<!-- <div class="col-md-3"><label>GroupID <span class="required">*</span></label>
				        <input readonly class="form-control dyn1" value="<?php echo $_SESSION['group_id']; ?>" type="text" name="groupId" id="groupId" tabindex="7"/>
				    </div>

                    <div class="col-md-3"><label>User Category <span class="required">*</span></label>
                        <?php
                            $sql="SELECT * FROM Master_UserType";
                            $result = db::getInstanceMaster()->db_select($sql);	
                        ?>
                        <select class="form-control dyn1" name="userCategory" id="userCategory" tabindex="8">
                            <?php 
                                if (!empty($result['result_set'])) {
                                    foreach ($result['result_set'] as $row) {
                                        $selected = ($row['ID'] == $usercategory) ? 'selected' : '';
                                        echo '<option value="' . $row['ID'] . '"  ' . $selected . '>' . htmlspecialchars($row['Label']) . '</option>';
                                    }
                                }else {
                                    echo '<option value="">Select</option>';
                                }
                            ?>
                        </select>
				    </div> -->

				</div>
       
			</div>
			
		<hr/>



		</br></br>
					
			<div class="row">
    			<div class="col-md-12">
    				<label class="col-md-4 control-label"></label>
    				<input type="hidden" value="<?php echo $editID; ?>" name="editID"><br>
    				<input type="submit" value="<?php echo $btnName; ?>" class="btn btn-primary">
    				<a href="users.php?view=1" class="btn btn-danger">CANCEL</a>			
    			</div>
			</div>
		</form> 
	</div>	
</div>
<?php include "k_files/k_footer.php"; ?>
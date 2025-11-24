<?php
$k_head_title = 'Change Password';
$k_head_keywords ='Change Password';
$k_head_desc ='Change Password';
$k_head_author ='KreonSolutions.com';
$k_page_title ='Change Password';
include 'k_files/k_header.php';
$k_head_include = '';

$user_id = isset ($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$val = "";
if((int)$user_id > 0){

?>	
<script>
    // Password strength regex
    const passwordStrengthRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$()=+{<>}#^!%*?&]{8,20}$/;

    function passwordCheck(){
        $('#passwordStrengthError').hide();
        $('#passwordMatchError').hide();
        $("#cp_btn").attr("disabled", true);
        const newPassword = $('#pwd1').val();
        const confirmPassword = $('#pwd2').val();
        if (passwordStrengthRegex.test(newPassword)) {
            $('#passwordStrength').text('Password strength: Strong').css('color', 'green');
            $('#passwordStrengthError').hide();
            if (newPassword !== confirmPassword) {
                $('#passwordMatchError').show();
            } else {
                $('#passwordMatchError').hide();
                $("#cp_btn").attr("disabled", false);
            }
        } else {
            $('#passwordStrength').text('Password must be at least 8 characters, contain a number, a special character, and a letter.').css('color', 'orange');
            $('#passwordStrengthError').show();
        }
    }
    $(document).ready(function() {

        $('#changePasswordForm').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            const oldPassword = $('#pwd').val();
            const newPassword = $('#pwd1').val();
            const confirmPassword = $('#pwd2').val();
            
            // Validate password strength and matching passwords before sending the data
            if (!passwordStrengthRegex.test(newPassword) || newPassword !== confirmPassword) {
                if (!passwordStrengthRegex.test(newPassword)) {
                    $('#passwordStrengthError').show();
                }
                if (newPassword !== confirmPassword) {
                    $('#passwordMatchError').show();
                }
                return; // Exit the function if validation fails
            }

            // Send the form data using AJAX
            const formData = {
                oldPassword: oldPassword,
                newPassword: newPassword,
                confirmPassword: confirmPassword
            };

            $.ajax({
                url: 'change-password-db.php',  
                type: 'POST',
                data: formData,
                success: function(res) {
                    var response = JSON.parse(res);
                    // console.log(response);
                    // console.log(response.success);
                    if (response.success === true) {
                        alert('Password changed successfully!');
                        $('#changePasswordForm')[0].reset();
                        window.location="home.php";
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error); 
                }
            });
        });
    });
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<section class="panel">
	<header class="panel-heading">
		<h2 class="panel-title">Change Password</h2>
	</header>
<div class="panel-body">
	<div class="col-md-12">
		<!-- <form class="form-bordered" method="post" id="changePasswordForm" action="change-password-db.php"> -->
		<form class="form-bordered" id="changePasswordForm">
			<div class="row">
                <div class="col-md-4"><label>Old Password <span class="required">*</span></label>
                    <input required class="form-control dyn1" type="password" name="pwd" id="pwd" />
                </div>
			</div>
			<div class="row">
                <div class="col-md-4"><label>New Password <span class="required">*</span></label>
                    <input required class="form-control dyn1" type="password" name="pwd1" id="pwd1" onkeyup="passwordCheck()"/>
                    <div id="passwordStrength"></div>
                </div>
			</div>
			<div class="row">
                <div class="col-md-4"><label>Re-enter New Password <span class="required">*</span></label>
                    <input required class="form-control dyn1" type="password" name="pwd2" id="pwd2" onkeyup="passwordCheck()"/>
                </div>
			</div>
            <hr/>				
            <div class="row">
                <div class="col-md-4">
                    <div id="passwordMatchError" style="color: red; display: none;">Passwords do not match!</div>
                    <div id="passwordStrengthError" style="color: red; display: none;">Password is too weak!</div>
                    <input type="submit" value="Change Password" class="btn btn-primary" id="cp_btn" disabled>
                    <a href="home.php" class="btn btn-danger">CANCEL</a>			
                </div>
            </div>
		</form> 
	</div>	
</div>
<?php 
}else{
    echo '<script>window.location="logout.php";</script>';
}
include "k_files/k_footer.php"; 
?>
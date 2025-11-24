<!doctype html>
<?php 
    session_start();
    session_unset();
	session_destroy(); 
    if(isset($_GET['error'])){ $error_msg = $_GET['error']; }else{ $error_msg = 0; }
	if(isset($_GET['newreg'])){ $newreg = $_GET['newreg']; }else{ $newreg = 0; }
?>
<html lang="en" class="fixed">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <title>Mindforge ERP - Login</title>

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
  <link rel="stylesheet" href="assets/stylesheets/theme.css" />
  <link rel="stylesheet" href="assets/stylesheets/theme-custom.css" />

  <style>
    body {
      background: linear-gradient(135deg, #e0f7fa, #e8eaf6, #ffffff);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Open Sans', sans-serif;
    }
    .login-wrapper {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      width: 95%;
      max-width: 420px;
      padding: 2.5rem;
      backdrop-filter: blur(6px);
      transition: 0.3s;
    }
    /* .login-wrapper:hover { transform: translateY(-4px); } */
    .login-logo { text-align: center; margin-bottom: 1.5rem; }
    .login-logo img { max-height: 60px; }
    .login-title {
      text-align: center; font-weight: 700; font-size: 1.4rem;
      color: #2e3b55; margin-bottom: 1.2rem; text-transform: uppercase;
    }
    .form-group label { font-weight: 600; color: #555; }
    .form-control {
      border-radius: 8px; border: 1px solid #ccc; box-shadow: none; transition: 0.2s;
    }
    .form-control:focus {
      border-color: #3f51b5;
      box-shadow: 0 0 0 0.2rem rgba(63, 81, 181, 0.1);
    }
    .btn-primary {
      background: #3f51b5; border: none; border-radius: 10px; font-weight: 600;
      transition: background 0.3s;
      text-shadow: 1px 2px 3px rgb(0 0 0 / 40%) !important;
    }
    .btn-primary:hover { background: #3949ab; }
    .login-footer {
      text-align: center; font-size: 1rem; color: #888; margin-top: 1rem;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <div class="login-logo">
        <img src="img/MF-Logo.jpg" alt="Mindforge ERP Logo" style="max-height: 155px;max-width:83vw;">
      <!-- <img src="assets/images/kreon-logo.png" alt="Mindforge ERP Logo"> --> 
    </div>

    <h2 class="login-title" style="letter-spacing: 1px;font-size: 1.6rem;">Login</h2>

    <?php
        if($error_msg  == 1){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Sorry!</strong> The username-password combination did not match our records. Please try again.
        </div><?php
        }
        if($error_msg  == 2){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Captcha did not match!</strong> Please try again.
        </div><?php
        }
        if($error_msg  == 3){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Sorry!</strong> The user is de-activated by the Admin. Please contact admin for re-activaton.
        </div><?php
        }
        if($error_msg  == 4){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Enter a valid username.
        </div><?php
        }
        if($error_msg  == 5){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            ERROR <?php echo $_GET['error_msg']; ?>
        </div><?php
        }
        if($error_msg  == 6){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            OTP has expired. Please try again.
        </div><?php
        }
        if($error_msg  == 7){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            User is not active.
        </div><?php
        }
        if($error_msg  == 8){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Group is not active.
        </div><?php
        }
        if($error_msg  == 9){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Invalid two-factor authentication or user-password combination.
        </div><?php
        }
        if($newreg  == 1){
            ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Congratulations!</strong> You have successfully registered. Please login with the registered details.
        </div><?php
        }
    ?>

    <form action="signin-pwd.php" method="POST">
        <div class="form-group">
            <label for="username">Enter Username</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="email" id="userEmail" class="form-control input-lg" placeholder="Username" required>
          <!-- <input name="email" type="text" id="userEmail" required class="form-control input-lg" /> -->
            </div>
        </div>
        <!-- <div style="text-align: right;font-size: 12px;">
            <a href="recover-password.php" style="color: grey;">Forgot Password?</a>
        </div> -->
        <button type="submit" class="btn btn-primary btn-block btn-lg mt-3" style="letter-spacing: 2px;text-transform: uppercase;background: #3f51b5;">Next</button>

        <span style="text-align: center;width: 100%;display: block;margin: 8px 0;line-height: 2rem;letter-spacing: 1px;">OR</span>
        
        <div class="">
            <a class="btn btn-primary btn-block btn-lg mt-3" href="signin_qr.php">Login with QR Code</a>
        </div>
    </form>

    <div class="login-footer">
      &copy; <?php echo date("Y"); ?> | Mindforge Innovations ERP | Empowering Textile & Beyond
    </div>
  </div>

  <script src="assets/vendor/jquery/jquery.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
  <script>$(document).ready(() => $("#userEmail").focus());</script>
</body>
</html>
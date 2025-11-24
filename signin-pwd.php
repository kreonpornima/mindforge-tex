<!doctype html>
<?php 

  require_once('dbClass.php');
  session_start();
	require_once('auth_helpers.php');

    $email = isset($_POST['email']) ? $_POST['email'] : "";
    if(strlen($email) < 2){
      echo '<script>window.location.replace("signin.php?error=4");</script>';
      exit();
    }
    
    $result = validateGeoLockingAndSendOTP($email);

    if (!$result['status']) {
      // $error_msg = 5; // default generic error
      echo '<script>window.location.replace("signin.php?error=' . $result['error_code'] . '");</script>';
      exit;
    }

    $TelegramID = $result['TelegramID'];
    $UserID = $result['UserID'];
    $GroupID = $result['GroupID'];
    $isGeoLockingEnabled = $result['isGeoLockingEnabled'];
    $UserIsActive = $result['UserIsActive'];
    $GroupIsActive = $result['GroupIsActive'];
    $RoleID = $result['RoleID'];
    $ip_ok = $result['ip_ok'];
    $sentUsers = $result['sentUsers'] ?? [];

?>
<html lang="en" class="fixed">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <title>Mindforge ERP - Password</title>

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
    .login-logo { text-align: center; margin-bottom: 1.5rem; }
    .login-logo img { max-height: 60px; }
    .login-title {
      text-align: center;
      font-weight: 700;
      font-size: 1.6rem;
      color: #2e3b55;
      margin-bottom: 1.2rem;
      text-transform: uppercase;
      letter-spacing: 1px;
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
      background: #3f51b5;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      transition: background 0.3s;
      text-shadow: 1px 2px 3px rgb(0 0 0 / 40%) !important;
    }
    .btn-primary:hover { background: #3949ab; }
    .back-link {
      text-align: left;
      margin-top: 0.5rem;
    }
    .back-link a { color: #3f51b5; text-decoration: none; font-size: 0.9rem; }
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

    <h2 class="login-title"><i class="fa fa-lock text-primary"></i> Enter Password</h2>

    <?php 
      if($isGeoLockingEnabled){
        if (!empty($sentUsers)) {
          echo '<div class="alert alert-success mt-sm">';
          echo '<strong>Telegram OTP sent to:</strong> ';
          foreach ($sentUsers as $name) {
            echo htmlspecialchars($name);
          }
          echo '</div>';
        }else{
          echo '<div class="alert alert-danger mt-sm">';
          echo '<strong>No Telegram ID found for Department Heads.</strong><br>';
          echo '</div>';
          
        }
      }
    ?>

    <form action="login_db.php" method="post">
      <div class="form-group">
        <label style="display: inline;">Username</label>
      <div class="back-link mt-3" style="display: inline;float: right;">
        <a href="signin.php" style="font-size: 1.2rem;"><i class="fa fa-arrow-left"></i> Change Username</a>
      </div>
        <div class="input-group" style="width: 100%;">
          <span class="input-group-addon"><i class="fa fa-user"></i></span>
          <input name="email" type="text" readonly="" class="form-control input-lg" value="<?php echo htmlspecialchars($email); ?>">
        </div>
      </div>

      <div class="form-group">
        <?php if(strlen($TelegramID) > 4){ ?>
          <label>Telegram OTP</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input name="pwd" type="text" required class="form-control input-lg" placeholder="Enter 6-digit OTP">
          </div>
          <p class="text-success small"><?php echo $UpdateMsg; ?></p>
        <?php } else { ?>
          <label>Password</label>
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input name="pwd" type="password" required class="form-control input-lg" placeholder="Enter your password">
          </div>
        <?php } ?>
      </div>

      <?php if(!$ip_ok){ ?>
      <div class="form-group">
        <label>Two-Factor Authentication OTP</label>
        <div class="input-group">
          <span class="input-group-addon"><i class="fa fa-shield"></i></span>
          <input name="pwd2" type="text" required class="form-control input-lg" placeholder="Enter 2FA OTP">
        </div>
        <small class="text-warning">You are logging in from an unrecognized IP.</small>
      </div>
      <?php } ?>

      <input type="hidden" name="ip_ok" value="<?php echo $ip_ok ? '1' : '0'; ?>">
      <input type="hidden" name="isGeoLockingEnabled" value="<?php echo $isGeoLockingEnabled; ?>">
        <br />
      <!-- <button type="submit" class="btn btn-primary btn-block btn-lg mt-3">Login</button> -->
        <button type="submit" class="btn btn-primary btn-block btn-lg mt-3" style="letter-spacing: 2px;text-transform: uppercase;background: #3f51b5;">Login</button>

        <span style="text-align: center;width: 100%;display: block;margin: 8px 0;line-height: 2rem;letter-spacing: 1px;">OR</span>
        
        <div class="">
            <a class="btn btn-primary btn-block btn-lg mt-3" href="signin_qr.php">Login with QR Code</a>
        </div>
    </form>

    <div class="login-footer">
      &copy; <?php echo date("Y"); ?> | By Mindforge Innovations ERP | Empowering Textile & Beyond
    </div>
  </div>

  <script src="assets/vendor/jquery/jquery.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
  <script>$(document).ready(() => $("input[name='pwd']").focus());</script>
</body>
</html>

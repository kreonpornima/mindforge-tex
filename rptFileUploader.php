
<?php
$target_dir = "reports/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// session_destroy();
session_start();

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = filesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an rpt";
    $uploadOk = 1;
  } else {
    echo "File is not an rpt.";
    $_SESSION['message'] = 'File is not an rpt.';
    $uploadOk = 0;
  }
}


// Check if file already exists
// if (file_exists($target_file)) {
//   echo "Sorry, file already exists.";
//   $_SESSION['message'] = 'Sorry, file already exists.';
//   $uploadOk = 0;
// }

// Check file size
if ($_FILES["fileToUpload"]["size"] > 1048576*5) {  //5MB
  echo "Sorry, your file is too large.";
  $_SESSION['message'] = 'Sorry, your file is too large.';

  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "rpt" ) {
  echo "Sorry, only RPT files are allowed.";
  $_SESSION['message'] = 'Sorry, only RPT files are allowed.';
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
  header("Location: rptUploader.php");
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    header("Location: rptUploader.php");
  } else {
    echo "Sorry, there was an error uploading your file.";
    $_SESSION['message'] = 'Sorry, there was an error uploading your file.';
  }
}


?>

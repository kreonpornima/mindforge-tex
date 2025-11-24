<?php 
session_start();
$switch = isset($_POST['action']) ? $_POST['action'] : 2;
$userCategory = isset ($_SESSION['Category']) ? $_SESSION['Category'] : 0;
$Username = isset ($_SESSION['email']) ? $_SESSION['email'] : '';
if($userCategory == 2){
    $Filename = './logs/dev_'.$Username . '.proflog' ;
}else{
    exit;
}
if($switch == 1){
    $fileHandle = fopen($Filename, 'w');

    // Check if the file was successfully opened
    if ($fileHandle) {
        $content = "Starting SQL Profiler.";

        // Write the content to the file
        if (fwrite($fileHandle, $content)) {
            echo "File '$Filename' has been created successfully.";
        } else {
            echo "Error: Unable to write to the file '$Filename'.";
        }

        // Close the file handle
        fclose($fileHandle);
    } else {
        echo "Error: Unable to open the file '$Filename'.";
    }
}
if($switch == 0){
    if (file_exists($Filename)) {
        rename('./logs/dev_'.$Username . '.proflog', './logs/dev/dev_'.$Username . '-' . date('Y-m-d_h-i-s a') .'.proflog');
        // if (unlink($Filename)) {
        //     echo "File '$Filename' has been deleted successfully.";
        // } else {
        //     echo "Error: Unable to delete the file '$Filename'.";
        // }
    } else {
        echo "Error: File '$Filename' does not exist.";
    }
}
exit;
?>


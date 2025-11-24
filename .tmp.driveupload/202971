<?php 
session_start();
//require_once ('dbClass.php');
$userCategory = isset ($_SESSION['Category']) ? $_SESSION['Category'] : 0;
$Username = isset ($_SESSION['email']) ? $_SESSION['email'] : '';
if($userCategory == 2){
    $Filename = './logs/dev_'.$Username . '.proflog' ;
    if(file_exists($Filename)){
        $content = file_get_contents($Filename);
        echo $content;	
    }
}
// foreach($dir as $file) {
//   if(is_file($file)) {
//     $mod_date=date("F d Y H:i:s.", filemtime($file));
//     echo "<br>$file last modified on ". $mod_date;
//   } else {
//     echo "<br>$file is not a correct file";
//   }
// }
exit;
?>


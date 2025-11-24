<?php
    include_once('dbClass.php');
	$output=array();	
   // $base=$_REQUEST['Media'];
    $base = isset($_REQUEST['Media']) ? $_REQUEST['Media'] : "";
    $ext=isset($_REQUEST['ext']) ? $_REQUEST['ext'] : "";
    $gridId = isset($_REQUEST['gridId']) ? $_REQUEST['gridId'] : 0;
    $imgFieldName = isset($_REQUEST['imgFieldName']) ? $_REQUEST['imgFieldName'] : "";

    $query = "SELECT * FROM kgridfields WHERE GridId=$gridId AND DbFieldName='".$imgFieldName."'";
    $result = db::getInstanceMaster()->db_select($query);

    $folder = extractAttribute($result['result_set'][0]['OtherAttributes'], "IMAGEPATH");


	$binary=base64_decode($base);
	header('Content-Type: bitmap; charset=utf-8');
	$filename = md5(uniqid(rand(),true));
	
    // Check if folder exists, if not create it
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);  // true allows nested directories to be created
    }

    $filename = $filename . '.' . $ext;
    $file = fopen($folder.$filename, 'wb');
    if ($file === false) {
        die('Failed to open file for writing.');
    }
    
    fwrite($file, $binary);
    fclose($file);
    $Caption = 	isset($_REQUEST['Caption']) ? $_REQUEST['Caption'] : "";

    if(strlen($folder) > 0 && $folder != null){
        $MediaFolder = $folder;
    }else{
        $MediaFolder = "img/";
    }
    
    //echo 'Image upload complete!!, Please check your php file directory……';

if(!isset($_REQUEST['Media']) )
{
    $output["response"] = "false";
	$output["data"] = "Please enter all fields.";
}elseif(isset($_REQUEST['Media'])){

    if($_REQUEST['Media']!="")
    {
    	
       $sql="INSERT INTO kmainmedia (MediaName,MediaType,MediaFolder) 
                    values (
						'".$filename."','".$ext."','".$MediaFolder."'
						)";
        $result = db::getInstance()->db_insertQuery($sql);
        $lastid = $result['last_id'];
    }
}
$output["response"] = "true";
$output["data"] = $lastid;
$output["imagepath"] = $MediaFolder."".$filename;
echo json_encode($output);
	
?>
<?php
include_once('./dbClass.php');
error_reporting(E_ALL & ~E_WARNING & ~E_DEPRECATED & ~E_NOTICE);
// Get the ID from query string
$imageID = isset($_GET['id']) ? intval($_GET['id']) : 0;
$case  = isset($_GET['case']) ? intval($_GET['case']) : 0;

switch ($case){
    case '1':
        // ini_set('zlib.output_compression', 0);
        $sql = "SELECT Response_QRImage,Response_QRImageName, Response_SignedQRCode FROM acc_einvoice_up WHERE ID = " . $imageID;
        $result = db::getInstance()->db_select($sql);
        $imageData = $result['result_set'][0]['Response_QRImage'];
        $imageName = $result['result_set'][0]['Response_QRImageName'];
        $signedQRCode = $result['result_set'][0]['Response_SignedQRCode'];
        if ($imageData !== null && strlen($imageData) > 4 ) {
            header("Content-Type: image/png"); // Adjust this if needed
            echo $imageData;
        } else {
            if(strlen($imageName) < 4 || $imageName == null){
                echo "Image not generated.";
            }else{
                $binary = file_get_contents($imageName);
                $hex = "0x" . bin2hex($binary);

                $sql = "update acc_einvoice_up SET Response_QRImage=".$hex." WHERE ID = " . $imageID;
                $result = db::getInstance()->db_update($sql);

                // $session ='YearCode= '.$_SESSION['dbYear'].' AND DivisionId='.$_SESSION['dbDivision'].' AND CompanyId='.$_SESSION['dbCompany'].' AND FormID='.$FormID.' ';
                // $data['params'] = ['@servername','@ipaddress','@database','@userid','@password','@id','@imagebinary'];

                // $sp['values'] = ["'" . $_SESSION['dbName'] . "_" . $_SESSION['user_id'] . "'",
                //                     "'" . $_SESSION['dbHost'] . "'",
                //                     "'" . $_SESSION['dbName'] . "'",
                //                     "'" . $_SESSION['dbUser'] . "'",
                //                     "'" . $_SESSION['dbPass'] . "'",
                //                     $imageID,
                //                     "'" . '' . "'"
                //                 ];
                //                 echo $imageName;
                $outputFolder = 'qrcodes'; // Folder to save the QR code image                
                $fullFile = CODE_PATH . $outputFolder . '\\' . $fileName; 
                // $fullFile = URL_ROOT . $outputFolder . '/' . $fileName; 
                include_once('generateBarcodeImage.php');
                $imageBaseName = basename(trim($fullFile));

//$imagePath = "uploads/myimage.jpg";   // Your image file
// $imageData = ;  // Binary data

                $filePath = generateQRCode($signedQRCode, $outputFolder, $imageBaseName);
                
                // $result = db::getInstanceMaster()->db_sp_select('SP_AddLinkServer2', $data['params'], $sp['values']);
                $sql = "SELECT Response_QRImage FROM acc_einvoice_up WHERE ID = " . $imageID;
                $result = db::getInstance()->db_select($sql);
                $imageData = $result['result_set'][0]['Response_QRImage'];
                 if ($imageData !== null) {
                    header("Content-Type: image/png"); // Adjust this if needed
                    echo $imageData;
                } else {
                    echo "Image not found.";
                }
            }
        }
        if (ob_get_length()) { @ob_end_flush(); }
        break;

}
?>

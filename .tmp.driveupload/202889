<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/php_errors.log');

require_once 'barcode/vendor/autoload.php'; // Correct path to the autoload file

use Com\Tecnick\Barcode\Barcode;

function generateQRCode($data, $outputFolder, $fileName) {
    try {
        $barcode = new Barcode();

        // Generate QR object safely
        $qrCode = $barcode->getBarcodeObj(
            'QRCODE,H', 
            $data, 
            -4, 
            -4, 
            'black', 
            array(0, 0, 0, 0)
        )->setBackgroundColor('white');

        $imageData = $qrCode->getPngData();

        // Ensure output folder
        if (!is_dir($outputFolder)) {
            mkdir($outputFolder, 0777, true);
        }

        $filePath = rtrim($outputFolder, '/\\') . '/' . $fileName;
        $bytesWritten = file_put_contents($filePath, $imageData);

        if ($bytesWritten === false) {
            throw new Exception("Failed to write QR image to file: $filePath");
        }

        return $filePath;

    } catch (Throwable $e) {
        // Log error to a file or show it in dev mode
        error_log("QR generation failed for data: $data\nError: " . $e->getMessage());
        return false;
    }
}


function generateQRCodeOLD($data, $outputFolder, $fileName) {
    // Create a Barcode object
    $barcode = new Barcode();
    // echo 'in generateQRCode';
    // Generate the QR code object
    $qrCode = $barcode->getBarcodeObj(
        'QRCODE,H', // QR code type with high error correction
        $data,      // Data to encode
        -4,         // Width of the QR code
        -4,         // Height of the QR code
        'black',    // Foreground color
        array(0, 0, 0, 0) // Padding (optional)
    )->setBackgroundColor('white'); // Background color

    // Get the QR code as PNG data
    $imageData = $qrCode->getPngData();

    // Ensure the output folder exists
    if (!is_dir($outputFolder)) {
        mkdir($outputFolder, 0777, true); // Create the folder if it doesn't exist
    }

    // Save the QR code image to the specified folder
    $filePath = rtrim($outputFolder, '/') . '/' . $fileName;
    file_put_contents($filePath, $imageData);

    return $filePath; // Return the path to the saved QR code image 
}


function generateQRCodeWithoutFile($data) {
    // Create a Barcode object
    $barcode = new Barcode();
    // echo 'in generateQRCode';
    // Generate the QR code object
    $qrCode = $barcode->getBarcodeObj(
        'QRCODE,H', // QR code type with high error correction
        $data,      // Data to encode
        -16,         // Width of the QR code
        -16,         // Height of the QR code
        'black',    // Foreground color
        array(0, 0, 0, 0) // Padding (optional)
    )->setBackgroundColor('white'); // Background color

    // Get the QR code as PNG data
    return $qrCode->getPngData();
}

// Usage example
// $data = 'eyJhbGciOiJSUzI1NiIsImtpZCI6IjNCRTE3RTUxNDE5MjUyMjY0N0YwMUZEQkZGNTI3MUFENTI2OEQ3MzUiLCJ4NXQiOiJPLUYtVVVHU1VpWkg4Ql9iXzFKeHJWSm8xelUiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJOSUMgU2FuZGJveCIsImRhdGEiOiJ7XCJTZWxsZXJHc3RpblwiOlwiMzRBQUNDQzE1OTZRMDAyXCIsXCJCdXllckdzdGluXCI6XCIyOUFXR1BWNzEwN0IxWjFcIixcIkRvY05vXCI6XCJET0MxLzYwOTM2LTEwXCIsXCJEb2NUeXBcIjpcIklOVlwiLFwiRG9jRHRcIjpcIjAyLzAzLzIwMjVcIixcIlRvdEludlZhbFwiOjEyOTA4LFwiSXRlbUNudFwiOjEsXCJNYWluSHNuQ29kZVwiOlwiMTAwMVwiLFwiSXJuXCI6XCI0NWRmNTk1NmE1NjEwM2Y5ZWE3ZjA3YjQ4NjIwZjU5YTQ1ZTZjNjE3NmQyMTE3OWE0MDFiMmI5Nzk5NjgzNWMzXCIsXCJJcm5EdFwiOlwiMjAyNS0wMy0xNyAxNjoxNjozOFwifSJ9.FkndqNcmwqi8GSbQ4qHMU1OpuHochIbdvIzm0uyJNVqJAhw6geBgsSasKh557z3zQV6A6aoUC_6m-C_D9rs-vRerUl2XG9dbamI9tlPC0H6iZhRod8BwBLoP33rtEL9WpO_XdtheBUwmhquI2qI_C5Mj1p2AxiSIpA3nD5tPAw4mPElJ9knFB7-xw7ZiuDVT_DeH1xJMDnEoBy1wO0Lz12l-wKZIDdcfzrFN-WrOTTu43eIVGjgk-xSnMZEPAmrO1Fs8n2DD2pIFbtHMaytgufhmeGcL5ZalAVSOBUCZlSYq-PP1Cz7MkuyDH-3zmb9-qMCPHi7iiSjmoS2chhxA_w'; // The data to encode in the QR code
// $outputFolder = 'qrcodes'; // Folder to save the QR code image
// $fileName = 'example_qr.png'; // Name of the output file

// $filePath = generateQRCode($data, $outputFolder, $fileName);
// echo "QR code has been saved to: " . $filePath;
?>
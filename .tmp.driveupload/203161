<?php
$chat_id = '1272937851'; //shiv
$chat_id = '416265626'; //mits
$chat_id = '1765470626'; //son
$chat_id = '352356680'; //rits
// $token = '6767010167:AAGTsKwC4kqEXXnuAK2DduL80sEQJStUXu8';
$token = '8179051405:AAFlGQ_o3gH9g4XDgaMt1_aNcQ2Zv0cIFW8';

// Function to send a message
function sendMessage($chat_id, $message, $token) {
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text' => $message
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Function to send a photo
function sendPhoto($chat_id, $photoPath, $token) {
    $url = "https://api.telegram.org/bot$token/sendPhoto";
    $photo = new CURLFile($photoPath);
    $data = [
        'chat_id' => $chat_id,
        'photo' => $photo
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Function to send a document
function sendDocument($chat_id, $documentPath, $token) {
    $url = "https://api.telegram.org/bot$token/sendDocument";
    $document = new CURLFile($documentPath);
    $data = [
        'chat_id' => $chat_id,
        'document' => $document
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

// Send a message
$messageResponse = sendMessage($chat_id, "Hello! Here is a message.", $token);
echo "Message Response: " . $messageResponse . "\n";
exit;
// Send a photo
$photoPath = 'D:/backups/photo.png';  // Replace with actual photo path
$photoResponse = sendPhoto($chat_id, $photoPath, $token);
echo "Photo Response: " . $photoResponse . "\n";

// Send a document
$documentPath = 'D:/backups/dummy-pdf_2.pdf';  // Path to your document
$documentResponse = sendDocument($chat_id, $documentPath, $token);
echo "Document Response: " . $documentResponse . "\n";

?>

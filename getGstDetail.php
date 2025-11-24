<?php

$aspid = "1773362725";
$gstin = "33AANCS2882A1ZG";
$password = "Mf89%3DN32]mIZ}1bn";  // no need to urlencode manually
$authToken = "186c793e489e4ff8aaff113fb0003373"; // Replace with valid AuthToken
$ret_period = "022022"; //072024
$username = 'TN_NT2.2265';
$otp = '575757';

// echo "<br><br>"."https://gstsandbox.charteredinfo.com/taxpayerapi/dec/v1.0/authenticate?action=AUTHTOKEN&aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&gstin=33AANCS2882A1ZG&username=TN_NT2.2265&OTP=575757";


// $url = "https://gstsandbox.charteredinfo.com/taxpayerapi/dec/v1.0/authenticate?action=AUTHTOKEN"
//      . "&aspid=" . urlencode($aspid)
//      . "&password=" . $password
//      . "&gstin=" . urlencode($gstin)
//      . "&username=" . urlencode($username)
//      . "&OTP=" . urlencode($otp);

// // Optional: headers
// $options = [
//     "http" => [
//         "method"  => "GET",
//         "header"  => "Accept: application/json\r\n"
//     ]
// ];

// // Create stream context
// $context = stream_context_create($options);

// // Call the API
// $response = file_get_contents($url, false, $context);

// // Decode the JSON into an associative array
// $data = json_decode($response, true);

// // Check and get the auth_token
// if (isset($data['status_cd']) && $data['status_cd'] === "1") {
//     $authToken = $data['auth_token'];
//     echo "Auth Token: " . $authToken;
// } else {
//     echo "Failed to get Auth Token. Response: " . $response;
// }

// https://gstsandbox.charteredinfo.com/taxpayerapi/dec/v2.1/returns/gstr1?action=RETSAVE&aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&gstin=33AANCS2882A1ZG&username=TN_NT2.2265&authtoken=186c793e489e4ff8aaff113fb0003373&ret_period=022022

// // ✅ API Endpoint for RETSUM (summary)
 $url1 = "https://gstsandbox.charteredinfo.com/taxpayerapi/dec/v2.1/returns/gstr1?action=RETSAVE"
     . "&aspid=" . urlencode($aspid)
     . "&password=" . $password
     . "&gstin=" . urlencode($gstin)
     . "&username=" . urlencode($username)
     . "&authtoken=" . $authToken
     . "&ret_period=" . urlencode($ret_period);


// ✅ Add headers including AuthToken and Content-Type
$headers = [
    "Content-Type: application/json",
    "AuthToken: " . $authToken
];

$options = [
    "http" => [
        "method" => "GET",
        "header" => implode("\r\n", $headers),
        "ignore_errors" => true
    ]
];

$context = stream_context_create($options);

// ✅ Execute API Call
$response = file_get_contents($url1, false, $context);

// ✅ Handle Response
if ($response === FALSE) {
    echo "Error calling RETSUM API";
} else {
    header("Content-Type: application/json");
    echo $response;
}

?>


<!-- https://gstsandbox.charteredinfo.com/taxpayerapi/dec/v1.0/authenticate?action=AUTHTOKEN&aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&gstin=33AANCS2882A1ZG&username=TN_NT2.2265&OTP=575757 -->

<!-- https://gstsandbox.charteredinfo.com/taxpayerapi/dec/v4.1/returns/gstr1?action=RETSUM&aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&gstin=33AANCS2882A1ZG&username=TN_NT2.2265&authtoken=186c793e489e4ff8aaff113fb0003373&ret_period=022022 -->

<!-- https://gstsandbox.charteredinfo.com/taxpayerapi/dec/v4.1/returns/gstr1?action=B2B&action_required=Y&aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&gstin=33AANCS2882A1ZG&username=TN_NT2.2265&authtoken=186c793e489e4ff8aaff113fb0003373&ret_period=022025 -->

<!-- https://gstapi.charteredinfo.com/taxpayerapi/dec/v1.0/authenticate?action=OTPREQUEST&aspid=1773362725&password=Mf89%3DN32]mIZ}1bn&gstin=27ACCFM2976P1ZI&username=mindforge_inno. -->

<!-- https://gstapi.charteredinfo.com/aspapi/v1.0/getapibalance?aspid=1773362725&password=Mf89%3DN32]mIZ}1bn& -->
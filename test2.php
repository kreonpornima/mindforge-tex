<?php
$ch = curl_init("http://106.201.231.148:8080/tex/api/general.php?case=1&email=7021676069");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
if(curl_errno($ch)){
    echo 'Error: ' . curl_error($ch);
} else {
    echo "OK\n";
}
$info = curl_getinfo($ch);
print_r($info);
curl_close($ch);
?>

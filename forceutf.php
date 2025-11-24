<?php
// use \ForceUTF8\Encoding;
include("assets/forceutf8-master/src/ForceUTF8/Encoding.php");

$str = "FÃÂ©dération Camerounaise—de—Football\n"; // Uses U+2014 which is invalid ISO8859-1 but exists in Win1252
// $str = "60X60/165×x 104-132 (4/1 Satin)"; // Uses U+2014 which is invalid ISO8859-1 but exists in Win1252
echo Encoding::fixUTF8($str); // Will break U+2014
echo Encoding::fixUTF8($str, Encoding::ICONV_IGNORE); // Will preserve U+2014
echo Encoding::fixUTF8($str, Encoding::ICONV_TRANSLIT); // Will preserve U+2014

?>
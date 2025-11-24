<?php 
// session_start()
include_once('dbClass.php');
// print_r($_REQUEST);
$FormID = $_REQUEST['form'];
$editID = $_REQUEST['editID'];
$TempID = $_REQUEST['TempID'];

$SPName = 'sp_BarcodePrint_' . $FormID.'_'.$TempID;
$data['params'] = ['@ycode','@division','@company','@insertedid','@userid'];
$sp['values'] = [$_SESSION['dbYear'],$_SESSION['dbDivision'],$_SESSION['dbCompany'],$editID,$_SESSION['user_id']];
$result = db::getInstance()->db_sp_select($SPName, $data['params'], $sp['values']);
// print_r($result);
if(sizeof($result['result_set']) > 0)
{
for($i = 0; $i < sizeof($result['result_set'][0]); $i++){
    $row = $result['result_set'][0][$i];
    $Design = $row['design'];
    $d = explode('$showBarcode', $Design);
    if(strlen($row['pageStyle']) > 2){
        $pageStyle = $row['pageStyle'];
    }else{
        $pageStyle = 'margin: 0cm;';
    }
    echo '
        <link href="https://fontlibrary.org/face/idautomationhc39m-code-39-barcode" rel="stylesheet">
        <style>
            * {
                font-family: "IDAHC39M Code 39 Barcode", Times, serif;
            }
        </style>
        <style>
            @page {
                size: '.$row['pageWidth'].'mm '.$row['pageHeight'].'mm;
            }
            @media print {
                print-color-adjust: exact; 
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            @media print {
                @page { margin: 0; }
                body { '.$pageStyle.' }
                .pagebreak {
                    clear: both;
                    page-break-after: always;
                }
            }
            .barcode-wrapper{
                '.$row['barcodeStyle'].'
            }
        </style>';

    for($j = 0;$j < sizeof($d); $j++){
        echo $d[$j];
        if($j < sizeof($d)-1){
            $barcode         = $row['barcode'];
            $type            = $row['type'];
            $barWidth        = $row['barWidth'];
            $barHeight       = $row['barHeight'];
            $foreColor       = $row['foreColor'];
            $padding         = $row['padding'];
            $backgroundColor = $row['backgroundColor'];
            include("barcode/s2.php");  //ADDED A CLASS IN src/Type.php line 421 under public function getHtmlDiv() barcode
        }
    } 
    echo '<div class="pagebreak"></div>';
}
?>
<script>
    window.onload = function() { window.print(); }
</script>
<?php
}else{
    echo "NO DATA AVAILABLE";
}
exit;

     /*
        method 1:
        <div style="white-space: nowrap; max-width: 100%; overflow: hidden; text-overflow: ellipsis;">
            This is a sentence that will fit into the container and be truncated if necessary.
        </div>


        method 2:
        <div class="resize-text">
        This text will adjust to fit its container without wrapping.
        </div>

        <style>
        .resize-text {
            font-size: 3vw; // Responsive font size based on viewport width 
            white-space: nowrap; // Prevent text wrapping 
            overflow: hidden; // Hide text overflow 
            width: fit-content; // Adjust the width of the container to fit the text 
            text-align: center; // Center-align the text 
            background-color: lightgray; // For visualization 
            padding: 10px; // Some padding 
        }
        </style>

        
        method 3: 
        <div class="resize-text">
            This text will adjust both in font size and width to fit its container.
            </div>

            <style>
            .resize-text {
                font-size: clamp(10px, 3vw, 40px); /* Dynamically adjust font size between 10px and 40px 
                white-space: nowrap; /* Prevent text wrapping 
                width: fit-content; /* Adjust container width to fit text 
                text-align: center; /* Center-align the text 
                background-color: lightgray; /* For visualization 
                padding: 10px; /* Some padding 
            }
            </style>

        
        method 4:
            tmpPrintBarcode.php
    */
?>
<p style="font-size: 32px;margin-top:0px;margin-bottom:20px;text-align:center;"><u><b>KREON</b></u></p><br />
<span style="font-size: 32px;margin-top:0px;margin-bottom:0px;">Process: Jagatanand Process</span><br />
<span style="font-size: 32px;margin-top:0px;margin-bottom:0px;">Quality: Tumble Berry</span><br />
<span style="font-size: 32px;margin-top:0px;margin-bottom:0px;">Shade: 04</span><br />
<span style="font-size: 32px;margin-top:0px;margin-bottom:0px;">Lot No: TB-08855</span><br />
<span style="font-size: 32px;margin-top:0px;margin-bottom:0px;">Location: WH-001</span><br />
<span style="font-size: 32px;margin-top:0px;margin-bottom:0px;">Mtr: 104.5</span><br />
<?php 
    $barcode = "KR2422143";
    $type = "C128";
    $barWidth = "-3";
    $barHeight = "-50";
    $foreColor = "black";
    $padding = 0;
    $backgroundColor = "white";
    include("barcode/s2.php"); 
?>
<p style="font-size: 32px;margin:0px;letter-spacing:1px; text-align:center;">KR2422143</p>
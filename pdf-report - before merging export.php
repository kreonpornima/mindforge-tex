<?php
$FormID = isset($_REQUEST['form']) ? $_REQUEST['form'] : 0;
$PDFPrint = isset($_REQUEST['PDFPrint']) ? $_REQUEST['PDFPrint'] : 0;
$k_head_title="Form";
$k_head_include = "";
// $editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$editID = 0;
$viewpage = 0;
// $viewpage = isset($_GET['view']) ? $_GET['view'] : 0;

include "form-init.php";

//$PDFPrint gives template ID and it comes from Voucher printing where template and parameters are already selected
if($PDFPrint > 0){
    $all_params = $_REQUEST; 
    $excluded_keys = ['form', 'PDFPrint'];
    foreach ($excluded_keys as $key) { 
        if (isset($all_params[$key])) { 
            unset($all_params[$key]); 
        } 
    }
} 

?>

<div class="container1">
    <div class="row">
        <div class="col-md-12 allfields templateSection">
            <div class="col-md-3 template" >
                <label for="template">PDF Report Template <span class="required"> *</span></label>
                <select name="template" class="templateSelect form-control" id="templateSelect" tabindex="1" required>
                    <option value=""></option>
                    <?php
                        $sql = 'SELECT ID, TemplateName FROM kreport_pdf_templates where isActive = 1 and ReportID = ' . $FormID . '  order by TemplateOrder';
                        $result1 = db::getInstanceMaster()->db_select($sql);
                        // Output the number of rows
                        $num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
                        // echo "Number of rows in the result set: $num_rows<br>";
                        // Loop through the result set and output options
                        for ($i = 0; $i < $num_rows; $i++) {
                            if($PDFPrint == $result1['result_set'][$i]['ID'])
                                echo '<option class="gridTemplate" selected value="' . $result1['result_set'][$i]['ID'] . '">' . $result1['result_set'][$i]['TemplateName'] . '</option>';
                            else
                                echo '<option class="gridTemplate" value="' . $result1['result_set'][$i]['ID'] . '">' . $result1['result_set'][$i]['TemplateName'] . '</option>';
                        }
                    ?>
                </select>
            </div>
            <?php 
            
                $group_id = isset ($_SESSION['group_id']) ? $_SESSION['group_id'] : 0;
                $role_id = isset ($_SESSION['access']) ? $_SESSION['access'] : 0;
                
                $sql = "SELECT a.* FROM CompanyRoleAccess Right Join (
                            Select Aireg.ID,Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, 
                            AiCompany.Label as CompanyName, AiDivision.Label as DivisionName, 
                            AiGroup.Label as GroupName, AiGroup.ID as GroupID, AiYear.sdate, AiYear.edate 
                            From Aireg 
                            LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
                            LEFT JOIN AiDivision ON Aireg.DivisionID = AiDivision.ID 
                            LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID 
                            LEFT JOIN AiYear ON Aireg.Year = AiYear.Label
                            WHERE AiGroup.ID = '".$group_id."'
                        ) a ON CompanyRoleAccess.RegID = a.ID 
                        where CompanyRoleAccess.RoleID = '".$role_id."'";
                $results = db::getInstanceMaster()->db_select($sql);
                $Companies = [];
                $Division = [];
                $Year = [];
                // $dt = date('Y-m-d');
                for ($j=0; $j<sizeof($results['result_set']); $j++) {
                    if($_SESSION['dbCompany'] == $results['result_set'][$j]['CompanyID']){
                        $dt = $results['result_set'][$j]['sdate']->format('Y-m-d'); // for example
                        $CompanyID = $results['result_set'][$j]['CompanyID'];
                        $DivisionID = $results['result_set'][$j]['DivisionID'];
                        $YearSelected = $results['result_set'][$j]['Year'];
                    }
                    array_push($Companies,(array("ID"=>$results['result_set'][$j]['CompanyID'],"Name"=>$results['result_set'][$j]['CompanyName'])));
                    array_push($Division,(array("ID"=>$results['result_set'][$j]['DivisionID'],"Name"=>$results['result_set'][$j]['DivisionName'])));
                    array_push($Year,   (array("ID"=>$results['result_set'][$j]['Year'],"Name"=>$results['result_set'][$j]['Year'])));
                }
                $uniqueCompanies = array_map("unserialize", array_unique(array_map("serialize",$Companies)));
                $uniqueCompanies2 = array_values($uniqueCompanies);
                
                $uniqueDivision = array_map("unserialize", array_unique(array_map("serialize",$Division)));
                $uniqueDivision2 = array_values($uniqueDivision);
                
                $uniqueYear = array_map("unserialize", array_unique(array_map("serialize",$Year)));
                $uniqueYear2 = array_values($uniqueYear);
                
            ?>
            <div class=" col-xs-2 ">
                <label>From Date<span class="required"> *</span></label>
                <input maxlength="4" pattern="\d{4}" class="form-control dyn1" value="<?php echo $dt; ?>" type="date" name="ssdt" id="ssdt"  tabindex="2"/>
            </div>
            <div class=" col-xs-2 ">
                <label>To Date<span class="required"> *</span></label>
                <input maxlength="4" pattern="\d{4}" class="form-control dyn1" value="<?php echo date('Y-m-d'); ?>" type="date" name="lldt" id="lldt" tabindex="3" />
            </div>
            <div class="col-md-2" >
                <label for="">Company<span class="required"> *</span></label>
                <select name="company" class="form-control" id="company" tabindex="4" required>
                    <option value></option>
                    <?php
                        $tmp = "";
                        for($k=0; $k<sizeof($uniqueCompanies2); $k++){
                            if($CompanyID == $uniqueCompanies2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                            echo '<option '.$tmp.' value="'.$uniqueCompanies2[$k]['ID'].'">'.$uniqueCompanies2[$k]['Name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-2" >
                <label for="">Division<span class="required"> *</span></label>
                <select name="division" class="form-control" id="division" tabindex="5" required>
                    <option value></option>
                    <?php
                        $tmp = "";
                        for($k=0; $k<sizeof($uniqueDivision2); $k++){
                            if($DivisionID == $uniqueDivision2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                            echo '<option '.$tmp.' value="'.$uniqueDivision2[$k]['ID'].'">'.$uniqueDivision2[$k]['Name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-1" >
                <label for="">Year:</label>
                <select name="year" class="form-control" id="year" tabindex="6">
                    <option value></option>
                    <?php
                        $tmp = "";
                        for($k=0; $k<sizeof($uniqueYear2); $k++){
                            if($YearSelected == $uniqueYear2[$k]['ID']) $tmp = 'selected'; else $tmp = '';
                            echo '<option '.$tmp.' value="'.$uniqueYear2[$k]['ID'].'">'.$uniqueYear2[$k]['Name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-2" >
                <label for="">Printer:</label>
                <select name="printer" class="form-control" id="printer" tabindex="7">
                    <option value></option>
                    <?php
                        //mst_printer, mst_papersize, mst_orientation tables are created in main database. Please check.
                        $query1 = "SELECT * FROM mst_printer";
                        $result1 = db::getInstanceMaster()->db_select($query1);
                        for($k = 0; $k < sizeof($result1['result_set']); $k++){
                            echo '<option value="'.$result1['result_set'][$k]['id'].'">'.$result1['result_set'][$k]['name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-2" >
                <label for="">Paper Size:</label>
                <select name="papersize" class="form-control" id="papersize" tabindex="9">
                    <option value></option>
                    <?php
                        //mst_printer, mst_papersize, mst_orientation tables are created in main database. Please check.
                        $query1 = "SELECT * FROM mst_papersize";
                        $result1 = db::getInstanceMaster()->db_select($query1);
                        for($k = 0; $k < sizeof($result1['result_set']); $k++){
                            echo '<option value="'.$result1['result_set'][$k]['id'].'">'.$result1['result_set'][$k]['name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-2" >
                <label for="">Paper Orientation:</label>
                <select name="paperorientation" class="form-control" id="paperorientation" tabindex="10">
                    <option value></option>
                    <?php
                        //mst_printer, mst_papersize, mst_orientation tables are created in main database. Please check.
                        $query1 = "SELECT * FROM mst_orientation";
                        $result1 = db::getInstanceMaster()->db_select($query1);
                        for($k = 0; $k < sizeof($result1['result_set']); $k++){
                            echo '<option value="'.$result1['result_set'][$k]['id'].'">'.$result1['result_set'][$k]['name'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-2" >
                <label for="">Export Type:</label>
                <select name="exporttype" class="form-control" id="exporttype" tabindex="10">
                    <option value></option>
                    <?php
                        //mst_printer, mst_papersize, mst_orientation tables are created in main database. Please check.
                        $query1 = "select * from master_crexportoptions where id is not null";
                        $result1 = db::getInstanceMaster()->db_select($query1);
                        for($k = 0; $k < sizeof($result1['result_set']); $k++){
                            echo '<option value="'.$result1['result_set'][$k]['id'].'">'.$result1['result_set'][$k]['name'].'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 allfields filterSection">
            <?php $div="";
                // echo '<div id="loader" class="spinner-border text-primary center" role="status"><span class="sr-only">Loading...</span></div>';
                // print_r($code);
                if($code !== null){

                    for($i = 0; $i < sizeof($code); $i++){
                        // echo '<div class="'.$code[$i][0].'">';
                        // echo createInputs($code[$i]);
                        // echo  '</div>';
                        if((int)$code[$i][1] !== 22 && (int)$code[$i][1] !== 21) echo '<div class="'.$code[$i][0].'">';
                        echo createInputs($code[$i],$FormID,$editID);
                        if((int)$code[$i][1] !== 21 && (int)$code[$i][1] !== 22) echo  '</div>';
                    }
                }else{
                    $sqlDev = "INSERT INTO DeveloperErrorLogs([FormID],[CompanyID],[DivisionID],[YearCode],[Database_name],[ErrorCode],[ErrorField],[Description],[RecommendedSolution],[CreatedBy],[CreatedAt])Values("
								. $FormID .",". $_SESSION['dbCompany'].",".$_SESSION['dbDivision'].",".$_SESSION['dbYearID'].",'".$_SESSION['dbName']."',652,'".$m[$i][1]."','Field are not created','Add fields in kmainfields',".$_SESSION['user_id'].",GETDATE())";
					$resultDev = db::getInstanceMaster()->db_insertQuery($sqlDev);
                }

            ?>
        </div>
        <div class="col-md-12 allfields paramSection" style="display:none;">
            <h4>Report Parameters</h4>
        </div>
        <!-- <div class="col-md-12 allgrids"> -->
        <!-- <br /><br /> -->
            <?php 
            // for($i = 0; $i < sizeof($dynamix); $i++){
                // echo createMore1($dynamix[$i][0], $dynamix[$i][1], $dynamix[$i][2], $radio, $editID,$FormID);
            // }
            ?>
        <!-- </div> -->
    </div>
</div>

<?php
$buttonsHtml = '';
if ($_SESSION['Category'] == 2) {
    $buttonsHtml = '
        <button class="btn btn-info btn-xs" onclick="openSQLModal(\'full\')">SQL</button>
        <button class="btn btn-success btn-xs" style="margin-right:40px;" onclick="openRequirementModal()">Requirements</button>';
}
?>


<!--GENERAL ON LOAD SCRIPT FOR THE ENTIRE PAGE VIEW EDIT AND ADD-->
<script>
	$(document).ready(function() {
        $('form').attr('action', '');
        $('form').attr('onsubmit', '');
        $(".panel-title").html("Report Filters");
        // $(".panel-heading").hide();
        // $(".panel-heading").append('<div class="panel-actions"><a href="#" class="panel-action panel-action-toggle filter-section" data-panel-toggle=""></a></div>');
        $(".panel-heading").html(`<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="panel-actions">
                                    <a href="#" class="panel-action panel-action-toggle filter-section" data-panel-toggle=""></a>
                                </div>
                                <h2 class="panel-title" style="margin: 0;">Report Filters</h2>
                                </div>
                                <div>
                                    <?= $buttonsHtml ?>
                                </div>
                            </div>`);
	    $(".page-header h2").html("<h2><?php echo $viewSettings[1]; ?></h2>");
	    $(document).prop('title', '<?php echo $viewSettings[1]; ?>');
	    // $('form').attr('action', 'db_backup_31.php');

        $('.templateSelect').change(function () {
            // alert(this.value);
            var reportID = <?php echo $FormID; ?>;
            var templateId = this.value;
            if(+templateId > 0){
                $(".paramSection").html('');
                $.ajax({
                    url: `getPDFReportTemplateParams.php`,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json"
                    },
                    data: { ReportID:reportID,templateId:templateId} ,
                    type: "GET", 
                    dataType: "json",
                    success: function(res) {
                        console.log("Got Data frm API", res);
                        // callback(null, data);
                        data = res[0];
                        var i = 0;
                        var params = '';
                        for(i = 0; i < data.length; i++){
                            otherAtt = ''; labelAtt = ''; def='';
                            if(data[i]['FieldType'] == 1){
                                if(data[i]['Required'] == 1){    otherAtt = " required "; labelAtt = '<span class="required"> *</span>';}
                                if(data[i]['DefaultValue'] !== null){    def = data[i]['DefaultValue']; }
                                params += '<div class="col-md-4"><label>'+data[i]['DisplayName']+labelAtt+'</label><input ' +otherAtt+ ' class="form-control" value="'+def+'" type="text" name="'+data[i]['FieldName']+'" id="'+data[i]['FieldName']+'" /></div>';
                            }
                            if(data[i]['FieldType'] == 5){
            
                                if(data[i]['Required'] == 1){    otherAtt = " required "; labelAtt = '<span class="required"> *</span>';}
                                if(data[i]['DefaultValue'] !== null){ def = data[i]['DefaultValue']; }
                                params += '<div class="col-md-4"><label>'+data[i]['DisplayName']+labelAtt+'</label><select ' +otherAtt+ 'class="form-control"  name="'+data[i]['FieldName']+'" id="'+data[i]['FieldName']+'"><option></option>';
                                var tmp = res[1][data[i]['ID']];
                                // console.log(tmp['result_set']);
                                // var sel = "";
                                for(j = 0; j < tmp['result_set'].length; j++){
                                    sel = "";
                                    if(def == tmp['result_set'][j][tmp['ID']])  sel = "selected";
                                    params += '<option '+sel+' value="'+tmp['result_set'][j][tmp['ID']]+'">'+tmp['result_set'][j][tmp['Label']]+'</option>';
                                }
                                params += '</select></div>';
                            }
                        }
                        console.log("i "+i);
                        if(i > 0){
                            
                            $(".paramSection").show();
                            $(".paramSection").html("<div class='col-md-12'><h4>Report Parameters</h4></div>" + params);
                            <?php 
                            if($PDFPrint > 0){
                                // print_r($all_params);
                                // echo "hhhhhhhhhhhhhhi";
                                foreach($all_params as $key => $value){
                                    echo '$("#' . $key . '").val("'.$value.'");  ';
                                }
                                // echo "console.log('clicking...');";
                                // echo "setTimeout(function() { $('#SaveUpdate').trigger('click'); console.log('clicked...');}, 1000);";
                            }
                            ?>
                        }
                        
                        <?php  if($PDFPrint > 0){
                                echo "console.log('clicking...');";
                                echo "setTimeout(function() { $('#SaveUpdate').trigger('click'); console.log('clicked...');}, 1000);";
                        } ?>
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Got ERROR Data frm API", jqXHR);
                        console.log("Got ERROR Data frm API", textStatus);
                        callback(new Error(textStatus || errorThrown));
                    }
                });
            }
        });        
       
       <?php 
       if($PDFPrint > 0) echo "$('.templateSelect').val('".$PDFPrint."').trigger('change');";
       ?>
	});
    function generatePDF(){
        // console.log("generate pdf");
        var reportID = <?php echo $FormID; ?>;
        var templateId = $('#templateSelect').val();
        // if(+reportID > 0){
        //     if(+templateId > 0){

        //     }
        // }
        var required = $('input,textarea,select').filter('[required]:visible');
        var allRequired = true;
        console.log(required)
        required.each(function(){
            // alert($(this).val());
            if($(this).val() == ''){    
                allRequired = false;
                alert("Missing data in the field - " + $(this).attr('id'));
                return false;
            }
        });

        if(!allRequired){
            // alert("Complete");
            return;
        }
        // return;
        // console.log($('.filterSection :input,textarea,select,text').serialize());

        var filterData = $('.filterSection :input,textarea,select,text').serialize() + '&ssdt=' + $("#ssdt").val() + '&lldt=' + $("#lldt").val() + '&company=' + $("#company").val() + '&division=' + $("#division").val() + '&year=' + $("#year").val();
        // console.log("filterData",filterData);
        // var filterData = $('.filterSection :input,textarea,select').serialize().replace(/&/g, '|') + '|ssdt=' + $("#ssdt").val() + '|lldt=' + $("#lldt").val() + '|company=' + $("#company").val() + '|division=' + $("#division").val() + '|year=' + $("#year").val();
        $('#pdfviewer').html('');
        $("#loader").show();
        // setTimeout(function(){ 
            $(".filter-section").click();
        // }, 1000);
        $.ajax({
            url: `generatePDF.php`,
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json"
            },
            data: { 
                ReportID:reportID,
                templateId:templateId,
                filterData: filterData,
                paramData: $('.paramSection :input').serialize(),
                ssdt:$("#ssdt").val(),
                lldt:$("#lldt").val(),
                company:$("#company").val(),
                division:$("#division").val(),
                year:$("#year").val(),
                printer:$("#printer").val(),
                papersize:$("#papersize").val(),
                paperorientation:$("#paperorientation").val(),
            } ,
            type: "GET", 
            dataType: "json",
            success: function(data) {
                $("#loader").hide();
                console.log("Got Data frm API", data);
                if(data.data.length > 5){
                    var pdflink = "<?php echo URL_ROOT . PDF_PATH;?>" + data.data;
                    // var pdflink = "<?php echo 'https://'.$_SERVER['HTTP_HOST'];?>/tex/reports/pdf/" + data.data;
                    console.log(pdflink);
                    // console.log('<?php echo $_SERVER['HTTP_HOST'];?>')
                    var iframe = $('<iframe>');
                    iframe.attr('src',pdflink);
                    iframe.attr('style','width: 100%;height: 100%;min-height: 900px;');
                    $('#pdfviewer').append(iframe);
                }else{
                    alert("Error generating the PDF");
                }
                // callback(null, data);
                // var i = 0;
                // var params = '';
                // for(i = 0; i < data.length; i++){
                //     if(data[i]['FieldType'] == 1){
                //         params += '<div class="col-md-4"><label>'+data[i]['DisplayName']+'</label><input class="form-control" value="" type="text" name="'+data[i]['FieldName']+'" id="'+data[i]['FieldName']+'" /></div>';
                //     }
                // }
                // if(i > 0){
                //     $(".filterSection").show();
                //     $(".filterSection").html("<div class='col-md-12'><h4>Report Parameters</h4></div>" + params);
                // }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#loader").hide();
                console.log("Got ERROR Data frm API", jqXHR);
                console.log("Got ERROR Data frm API", textStatus);
                // callback(new Error(textStatus || errorThrown));
            }
        });



    }
</script>

<?php 
//echo $_SESSION['dtbases'];
                
	include "pdf-report-close.php"; 
?>
<div id="loader" class="spinner-border text-primary center" style="display:none" role="status"><span class="sr-only">Loading...</span></div>

<?php
$FormID = isset($_REQUEST['form']) ? $_REQUEST['form'] : 0;

//open roles.php
if($FormID == 5356) {
    header("Location: roles.php?view=1");
    exit;
}

//open users.php
if($FormID == 1) {
    header("Location: users.php?view=1");
    exit;
}

$k_head_title="Form";
$k_head_include = "";
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$viewpage = isset($_GET['view']) ? $_GET['view'] : 0;
$formDesigner = 0;
if($editID == 0 && $viewpage == 0)
    $formDesigner =isset($_GET['formDesigner']) ? $_GET['formDesigner'] : 0;

include "form-init.php";
?>

<script>
    function onGridLastFieldAddRow(panelID,callback) {
        console.log("inside function onGridLastFieldAddRow ",panelID)
        var tmp = document.getElementById(panelID).querySelector('table');
        // console.log(tmp);
        // Find the panel ID of the parent element
        panelID = tmp.parentElement.id;
        // console.log(panelID,panelID.slice(-1));

        // Check if the row has an 'update' button or not.
        var updateId = $('#panel' + panelID.slice(-1))
            .find('#GridTable')
            .find('tbody > tr:first > td:last')
            .find('.update' + panelID.slice(-1))
            .attr('id');
        // console.log("updateId"+updateId);
        if (updateId === undefined) {
            console.log("calling add function");
            // If no update button exists, click 'add' only once.
            $(".add" + panelID.slice(-1)).click();
        } else {
            // If an update button exists, click 'update'.
            $(".update" + panelID.slice(-1)).click();
        }

        if (typeof callback === "function") {
            callback();
        }
    }
    
    let isShiftTab = false;
    var isClearClick = false;

    // Track if Shift + Tab was pressed
    $(document).on('keydown', function (e) {
        // console.log("keydown",e.keyCode,e.shiftKey);
        if (e.keyCode === 9 && e.shiftKey) {
            isShiftTab = true;
        } else {
            isShiftTab = false;
        }
    });
    

    $(document).on('select2:close', 'select', function (e) {
        if (isClearClick) {
            isClearClick = false; // Reset flag
            return; // Skip the rest of the code
        }

        const select2Data = $(this).data('select2');
       
        if (select2Data && select2Data.$dropdown) {
            let currentFieldId = select2Data.$dropdown.find('ul.select2-results__options').attr('id');

            if (!currentFieldId && select2Data.$dropdown.attr('id')) {
                currentFieldId = select2Data.$dropdown.attr('id');
            }

            const currentFieldIds = currentFieldId.split('-');
            let gridLastFieldId = '';

            if (currentFieldIds.length > 3) {
                const SerialNumber = currentFieldIds[3][0];

                gridLastFieldId = $('#panel' + SerialNumber + ' #GridTable tbody')
                    .find('input[id*="kreon-grid-' + SerialNumber + '"], textarea[id*="kreon-grid-' + SerialNumber + '"], select[id*="kreon-grid-' + SerialNumber + '"]')
                    .filter(function () {
                        const $el = $(this);
                        const isFileInput = $el.attr('type') === 'file';
                        if (!isFileInput && ($el.is(':hidden') || $el.prop('readonly'))) return false;

                        if ($el.is('select.select2-hidden-accessible')) {
                            const $select2 = $el.next('.select2').find('.select2-selection');
                            if ($select2.css('pointer-events') === 'none') return false;
                            const tabIndex = $select2.attr('tabindex');
                            if (tabIndex === "-1") return false;
                            return true;
                        }

                        if ($el.attr('tabindex') === "-1") return false;
                        return true;
                    })
                    .last()
                    .attr('id');
            }

            const currentFieldIdStr = currentFieldIds[1] + "-" + currentFieldIds[2] + "-" + currentFieldIds[3];
            console.log("gridLastFieldId", gridLastFieldId + "==" + currentFieldIdStr);

            if (gridLastFieldId === currentFieldIdStr && !isShiftTab) {
                e.preventDefault();
                onGridLastFieldAddRow("panel" + currentFieldIds[3].charAt(0));
            } else {
                if ($('#' + currentFieldIds[1]).data('select2')) {
                    $('#' + currentFieldIds[1]).select2('close');
                }

                let tabindex;
                if (currentFieldIds.length > 3) {
                    tabindex = $('#kreon-grid-' + currentFieldIds[3])
                        .next('span')
                        .find('.select2-selection--single')
                        .attr('tabindex');
                } else {
                    tabindex = $('.' + currentFieldIds[1] + ' span span span').attr('tabindex');
                }

                tabindex = parseInt(tabindex || 0);
                if (isShiftTab) {
                    tabindex--;
                } else {
                    tabindex++;
                }

                
                console.log("newTabIndex", tabindex);
                $("[tabindex='" + tabindex + "']").focus();

                // Reset shift+tab flag after usage
                isShiftTab = false;
            }
        }
    });
    

    // $(document).on('select2:close', 'select', function (e) {
    //     // Get the Select2 instance data
    //     var select2Data = $(this).data('select2');

    //     if (select2Data && select2Data.$dropdown) {
    //         // $dropdown is a jQuery object representing the dropdown container (often the <ul> itself or its wrapper)
    //         var currentFieldId = select2Data.$dropdown.find('ul.select2-results__options').attr('id');

    //         console.log('select2 has closed - ',currentFieldId);
    //         // If the $dropdown itself is the <ul>, you can just use:
    //         // var ulId = select2Data.$dropdown.attr('id');

    //         // Check if the dropdown directly has an ID
    //         if (!currentFieldId && select2Data.$dropdown.attr('id')) {
    //             currentFieldId = select2Data.$dropdown.attr('id');
    //         }

    //         var currentFieldIds = currentFieldId.split('-');
    //         var gridLastFieldId = '';

    //         if(currentFieldIds.length > 3){
    //             var SerialNumber = currentFieldIds[3][0];
                
    //             gridLastFieldId = $('#panel' + SerialNumber + ' #GridTable tbody')
    //             .find('input[id*="kreon-grid-' + SerialNumber + '"], textarea[id*="kreon-grid-' + SerialNumber + '"], select[id*="kreon-grid-' + SerialNumber + '"]')
    //             .filter(function () {
    //                 const $el = $(this);

    //                 const isFileInput = $el.attr('type') === 'file';

    //                  // For non-file inputs, exclude hidden or readonly fields
    //                 if (!isFileInput && ($el.is(':hidden') || $el.prop('readonly'))) {
    //                     return false;
    //                 }


    //                 // Exclude hidden and readonly fields
    //                 // if ($el.is(':hidden') || $el.prop('readonly')) return false;

    //                 // Special case for select2
    //                 if ($el.is('select.select2-hidden-accessible')) {
    //                     const $select2 = $el.next('.select2').find('.select2-selection');

    //                     // Exclude if pointer-events is none
    //                     if ($select2.css('pointer-events') === 'none') return false;

    //                     // Check tabindex on the visible select2 element
    //                     const tabIndex = $select2.attr('tabindex');
    //                     if (tabIndex === "-1") return false;

    //                     return true;
    //                 }

    //                 // General tabindex check for normal fields
    //                 if ($el.attr('tabindex') === "-1") return false;

    //                 return true;
    //             })
    //             .last()
    //             .attr('id');

    //         }
    //         console.log("gridLastFieldId",gridLastFieldId +"=="+ currentFieldIds[1]+"-"+currentFieldIds[2]+"-"+currentFieldIds[3]);
    //         if(gridLastFieldId == currentFieldIds[1]+"-"+currentFieldIds[2]+"-"+currentFieldIds[3] && !e.shiftKey){
    //             e.preventDefault(); // Prevent default tab behavior
    //             onGridLastFieldAddRow("panel"+currentFieldIds[3].charAt(0));
    //         }else{

    //             if($('#'+currentFieldIds[1]).data('select2')) {
    //                 $('#'+currentFieldIds[1]).select2('close');
    //             }
    //             if(currentFieldIds.length > 3){
    //                 // var tabindex = $('.kreon-grid-'+currentFieldIds[3] + ' span span span').attr('tabindex');
    //                 var tabindex = $('#kreon-grid-'+currentFieldIds[3]).next('span').find('.select2-selection--single').attr('tabindex');
    //             }else{
    //                 var tabindex = $('.'+currentFieldIds[1] + ' span span span').attr('tabindex');
    //             }
    //             console.log("Current Tabindex",tabindex);
    //             if(e.shiftKey){
    //                 // console.log('shiftkeydown')
    //                 tabindex--;
    //             }else{
    //                 // console.log('inkeydown')
    //                 tabindex++;
    //             }
    //             console.log("newTabIndex", tabindex); 

    //          $("[tabindex='"+tabindex+"']").focus();
                
    //         }
    //     }
    // });
    

</script>

<?php


if($viewpage > 0){
    ?>
    <style>
        table.dataTable tbody th, table.dataTable tbody td, .table > thead > tr > th  {
            padding: 1px 4px !important;
            vertical-align: middle;
            white-space: nowrap;
        }
        table.dataTable thead th, table.dataTable thead td {
            padding: 2px 3px !important;
        }
        td .btn {
            padding: 3px 8px;
        }
        th .form-control {
            display: block;
            height: 27px;
            padding: 2px 6px;
            font-size: 12px;
            line-height: 1.22857143;
        }
        th{
            text-transform: capitalize;
        }
        .panel-heading {
            padding: 12px;
        }


        /* ADDED FOR SCROLL STATIC ACTION BAR */


        table.dataTable {
            width: 100%;
            border-collapse: collapse;
        }

        /* Horizontal scrolling area */
        .table-container {
            position: relative;
            width: 100%;
            overflow-x: auto;
        }

        /* Scrollable table */
        .scrollable-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Style for sticky last column */
        table.dataTable th:last-child,
        table.dataTable td:last-child {
            position: -webkit-sticky; /* Safari */
            position: sticky;
            right: 0;
            background-color: #fff; /* Optional: Makes the sticky column white */
            z-index: 1; /* Ensure the sticky column is above the rest */
        }

        /* Optional: Add a shadow effect to make it visually clear it's sticky */
        table.dataTable th:last-child,
        table.dataTable td:last-child {
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
    <?php
}else{

    ?>

    <style>
        input[type="number"] {
            text-align: right;
        }
        #GridTable thead th:last-child, #GridTable table td:last-child {
            position: -webkit-sticky;
            position: sticky;
            right: 0;
            background-color: #fff;
            z-index: 1;
        }
        #GridTable tbody tr td:last-child {
            display: flex;
        }
        #GridTable tbody tr td:last-child .btn{
            display: inline-flex;
        }
        .form-control {
            height: 26px !important;
            padding: 1px 2px !important;
            font-size: 12px !important;
        }
        #GridTable .form-control:read-only {
            border-radius: 0 !important;
        }
        #GridTable select:read-only{
            appearance: none;
        }
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
            padding: 0px !important;
        }
        .select2-container .select2-selection--single{
            height: 26px;
        }
        .table-bordered > thead > tr > th {
            font-weight: 200;
            font-size: 12px;
        }
        label{
            margin-bottom: 0;
        }
        tr.being-edited input, tr.being-edited select { /* GRID EdiT HIGHLIGHT */
            box-shadow: 0 0 5px rgba(81, 203, 238, 1);
            padding: 3px 0px 3px 3px !important;
            margin: 5px 1px 3px 0px;
            border: 1px solid rgba(81, 203, 238, 1);
        }

        /* Code for sticky thead tbody & tbody first row */
        .table-bordered > thead > tr > th {
            font-weight: 200;
            font-size: 13px;
            background-color: #09284e;
            color: white;
            text-align: left;
            padding-left:3px !important;
            /* padding: 10px; */
            position: sticky;
            top: 0;
            z-index: 2;
            white-space: nowrap;
            height: 26px;
            vertical-align: middle;
        }

        #GridTable tbody tr:first-child td {
            position: sticky;
            top: 10px;
            background-color: #f1f1f1;
            z-index: 1;
        }
        .panel-heading {
            padding: 8px !important;
        }
        .toggle.active > label {
            background: #09284e !important;
            border-color: #09284e;
            color: white !important;
            padding: 6px 20px 6px 10px;
        }
        .toggle > label {
            padding: 6px 20px 6px 10px;
        }
        .toggle label {
            border-left-color: #09284e;
            margin-bottom: 0px;
        }
        .switch.switch-primary .ios-switch .on-background {
            background: #09284e;
        }
        #GridTable tfoot tr td {
            background-color: #09284e;
            /* background-color: #ffffff; */
            color: white;
            text-align: left;
            /* padding: 10px; */
            position: sticky;
            /* top: 0; */
            z-index: 2;
            bottom: 0;
            top: auto;
        }

        #GridTable tfoot tr td input{
            background-color: #09284e;
            color: white;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 25px;
        }

    </style>

    <div class="container1">
        <div class="row">
            <div class="col-md-12 allfields">
                <?php                 
                    echo '<div id="loader" class="spinner-border text-primary center" role="status"><span class="sr-only">Loading...</span></div>';
                    $cntDyn = 0;
                    

                    if(sizeof($code) <= 0){
                        echo "Oops!!! No Fields Added. Please contact the developer.";
                    }else{
                        $finalGridCount = 0;

                        
                        
                        for($i = 0; $i < sizeof($code); $i++){
                            if((int)$code[$i][1] !== 22 && (int)$code[$i][1] !== 21) echo '<div class="'.$code[$i][0].'">';
                            
                            echo createInputs($code[$i],$FormID,$editID);
                            if($code[$i][1] == 14){
                                echo '</div><div class="col-md-12 allgrids"><div class="row">';
                                // print_r($dynamix[$cntDyn][1]);
                                $finalGridCount++;
                                echo createMore1($dynamix[$cntDyn][0], $dynamix[$cntDyn][1], $dynamix[$cntDyn][2], $radio, $editID, $FormID, $db);
                                echo '</div></div><div class="col-md-12 allfields">';
                                $cntDyn++;
                            }
                            if((int)$code[$i][1] !== 21 && (int)$code[$i][1] !== 22) echo  '</div>';
                        }
                        echo '<input type="hidden" name="finalGridCount" id="finalGridCount" value="' . $finalGridCount . '" />';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php 
    //ALL FORMS ARE FOR CUTPACK CUSTOMIZATION
    if($FormID == 4699 || $FormID == 5184 || $FormID == 5260 || $FormID == 5175 || $FormID == 5275 || $FormID == 5498 || $FormID == 5573 || $FormID == 5660 || $FormID == 5670 || $FormID == 5175 || $FormID == 5694 || $FormID == 5535 || $FormID == 5754 || $FormID == 5809 || $FormID == 5813 || $FormID == 5923 || $FormID == 5884){

        if(isset($_REQUEST['preview'])){
			$isPreview = 1;
		}

        ?>
        <style>
            /* ONLY FOR CUTPACK */
            span#select2-lumpnoselection-container {
                padding: 0 2px;
            }
            span#select2-lumpnoselection-container ~ span.select2-selection__arrow {
                display: none;
            }
        </style>
        <script>
            var isPreview = <?php echo (int)$isPreview; ?>;
            //in edit mode set all rows hidden
            filterRows('-');
            /* ONLY FOR CUTPACK */
            function changeDDValue(id,val,text){
                console.log('changeDDValue');
                var $newOption = $("<option selected=\"selected\"></option>").val(val).text(text)
                // $('#'+id).select2('open');
                // $('#'+id).append($newOption);//.trigger("change");
                // $('#'+id).select2('close');
                $('#'+id).append($newOption).trigger("change");
                console.log("changedDDvalue",id,val,text)
            }
            function calculateCutpackTotal(){
                console.log("calculateCutpackTotal FN")
                var totalPcs = 0;
                var totalMtrs = 0;
                $('#GridTable tbody tr:not(.hidden):gt(0)').each(function() {
                    var pcsInput = $(this).find('td:eq(5) input');
                    var mtrsInput = $(this).find('td:eq(6) input');
                    
                    if (pcsInput.length > 0) {
                        var pcs = parseFloat(pcsInput.val()) || 0;
                        // console.log('PCS Value:', pcs);
                        totalPcs += pcs;
                    } 
                    if (mtrsInput.length > 0) {
                        var mtrs = parseFloat(mtrsInput.val()) || 0;
                        // console.log('MTRS Value:', mtrs);
                        totalMtrs += mtrs;
                    } 
                });
                $("#apcsFooter").val(totalPcs);
                $("#aqtyFooter").val(totalMtrs);
                console.log('Total PCS:', totalPcs);
                console.log('Total Mtrs:', totalMtrs);
            }
            //remove row button clicked
            $("#panela").on("click",".removesa",function(){
                console.log("Recalc1")
                setTimeout(
					function() {
                        console.log("Recalc")
						calculateCutpackTotal();
                        $("#mtrs").focus();
                        $('#mtrs').focusout();
                        $('#mtrs').trigger('blur');
                        setTimeout(
                            function() {
                                $("#cut").focus();
                                $('#cut').focusout();
                                $('#cut').trigger('blur');
                                setTimeout(
                                    function() {
                                        $("#mtrs").focus();
                                        $('#mtrs').focusout();
                                        $('#mtrs').trigger('blur');
                                        setTimeout(
                                            function() {
                                                $("#cut").focus();
                                                $('#cut').focusout();
                                                $('#cut').trigger('blur');
                                                setTimeout(
                                                    function() {
                                                        $("#mtrs").focus();
                                                        $('#mtrs').focusout();
                                                        $('#mtrs').trigger('blur');
                                                    },
                                                1500);
                                            },
                                        500);
                                    },
                                500);
                            },
                        500);
					},
				500);
            });
            $("#panela").on("click",".updatea",function(){
                setTimeout(
					function() {
						calculateCutpackTotal();
					},
				2000);
            });
            $("#panela").on("click",".adda",function(){
                setTimeout(
					function() {
                        console.log("from adda click")
						calculateCutpackTotal();
					},
				2000);
            });
            $(".button #ButtonClickFillGridField-button button").click(function(){
                setTimeout(
					function() {
                        console.log("from confirm btn click")
						calculateCutpackTotal();
					},
				2000);
            });
            function modifySelected(pcsno){
                $('#Form_36561 table tr').each(function() { 
                    var secondColumnValue = $(this).find('td:eq(1)').text(); 
                    console.log("REMOVED2", secondColumnValue)
                    if (secondColumnValue === pcsno) { 

                    }
                });
                var id = 
                cpSelection(id);
            }
            function changeCutpackSelection(id){
                // console.log("changeCutpackSelection",id);
                var bal = $("#balancemtrs").val();
                var cut = $("#cut_mtrs").val();
                $("#apcsFooter").val('0');
                $("#amtrsFooter").val('0');
                if((+bal !== 0 && +cut !== 0)){
                    alert("Please complete the current selected lump first.");
                    return;
                }
                cpSelection(id)
            }
            function cpSelection(id){
                $.ajax({
                    url: `getGreyCutpackSelection.php`,
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json"
                    },
                    data: {id:id, FormID:<?php echo $FormID ?>} ,
                    type: "GET", 
                    dataType: "json",
                    success: function(res) {
                        // console.log("Got Data frm API", res);
                        var data = res[0];
                        console.log(res, data);

                        const targetFields = [
                        "refid", "id", "pcsno", "quality", "qualityid", "design", "designid",
                        "shade", "shadeid", "pcs", "qty", "grade", "gradeid", "weight",
                        "rate", "balancemeters", "cutmtrs"
                        ];

                        const matched = {};
                        const others = {};

                        for (const key in data) {
                            if (targetFields.includes(key)) {
                                matched[key] = data[key];
                            } else {
                                others[key] = data[key];
                                const element = document.getElementById(key);
                                
                                if (element) {
                                    if (element.type === "select-one") {
                                        // For dropdowns (select elements)
                                        const valueToSelect = others[key];
                                        // const option = Array.from(element.options).find(opt => opt.value == valueToSelect || opt.text == valueToSelect);
                                        // if (option) {
                                        //     console.log("hi",option);
                                        //     element.value = option.value; // Select by value
                                        // } else {
                                        //     // Option not found, you can optionally add it
                                        //     const newOption = new Option(valueToSelect, valueToSelect, true, true);
                                        //     console.log("hello",newOption);
                                        //     element.add(newOption);
                                        // }

                                        const option = Array.from(element.options).find(
                                            opt => opt.value == valueToSelect || opt.text.trim() == valueToSelect
                                        );
                                        console.log("option",option);

                                        if (option) {
                                            element.value = option.value;
                                        } else {
                                            // Option not found — add dynamically if needed
                                            const newOption = new Option(valueToSelect, valueToSelect, true, true);
                                            element.add(newOption);
                                        }
                                    } else {
                                        element.value = others[key]; // For divs, spans, etc.
                                    }
                                }
                            }
                        }

                        console.log("Matched Fields:", matched);
                        console.log("Other Fields:", others);

                        $("#lump_mtrs").val(data.qty);
                        $("#balancemtrs").val(data.balancemeters);
                        $("#cut_mtrs").val(data.cutmtrs);
                        $("#mtrs").val('0');
                        // $("#cut").val('0');
                        $("#totalmtrs").val('0');
                        // $("#balancemtrs").val(data.balancemeters);
                        $("#lumpnoselection").val(data.pcsno);
                        console.log($("#refid").val(), data.refid);
                        $("#barrefid").val(data.refid);
                        console.log($("#barrefid").val(), data.refid);
                        // changeDDValue('lumpnoselection',data.id,data.pcsno)			
                        changeDDValue('qualityid',data.qualityid,data.quality)			
                        changeDDValue('designid',data.designid,data.design)			
                        changeDDValue('shadeid',data.shadeid,data.shade)			
                        // changeDDValue('gradeid',data.gradeid,data.grade);

                        

                        if(isPreview != 1){
                            // If preview mode open then don't exicute this
                            if(data.cursorPositionCutpack){
                                if(data.cursorPositionCutpack.length > 1){
                                    var element = $('#' + data.cursorPositionCutpack);
                                    var element17 = $('#' + data.cursorPositionCutpack + '-text');
                                    console.log('Element 0', element);
                                    if (element.length) {
                                        if(element17.length){
                                            element17.click();
                                        }else{
                                            var tagName = element.prop('tagName').toLowerCase();
                                            var inputType = element.attr('type'); // Only relevant for <input>
                                            var dataType = element.data('type');  // Reads data-type attribute
                                            console.log('Element 1', tagName, inputType);
                                            if (tagName === 'select') {
                                                $('select#' + data.cursorPositionCutpack).select2('open');
                                            } else if (tagName === 'textarea') {
                                                $("#" + data.cursorPositionCutpack).focus();
                                            } else if (tagName === 'input') {
                                                // var inputType = element.attr('type');
                                                if(inputType){
                                                    if(+inputType == 17){
                                                        $("#" + data.cursorPositionCutpack + "-text").click();
                                                    }else{
                                                        $("#" + data.cursorPositionCutpack).focus();
                                                    }
                                                }else{
                                                    $("#" + data.cursorPositionCutpack).focus();
                                                }
                                            } else {
                                                console.log('Unknown element type');
                                            }
                                        }

                                    } else {
                                        console.log('Element not found');
                                    }
                                }else{
                                    $('select#gradeid').select2('open');
                                }
                            }else{
                                $('select#gradeid').select2('open');
                            }
                        }

                        filterRows(data.pcsno)
                        CreateOnChangeScriptGridCalculation(["pcs","qty"], [1,1],["a"]);

                        // CreateOnChangeScriptGridCalculation("kreon-grid-apcsno", 1,"dynamic",0);
                        // CreateOnChangeScriptGridCalculation("kreon-grid-amtrs", 1,"dynamic",0);
                        calculateCutpackTotal();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Got ERROR Data frm API", jqXHR);
                        console.log("Got ERROR Data frm API", textStatus);
                        // callback(new Error(textStatus || errorThrown));
                    }
                });
            }
            function filterRows(searchValue) {
                $('.tmp_GridTablea tbody tr:gt(0)').each(function() { 
                    var rowMatches = false; 
                    $(this).find('input[type="text"]').each(function() { 
                        var cellValue = $(this).val().toLowerCase(); 
                        console.log("cellValue",cellValue);
                        if (cellValue.includes(searchValue)) { 
                            rowMatches = true; 
                        } 
                    }); 
                    if (rowMatches) { 
                        $(this).removeClass('hidden'); 
                    } 
                    else { 
                        $(this).addClass('hidden'); 
                    } 
                });
            }
            /*
            function showAllRows() {
                const rows = document.getElementById('dataTable').getElementsByTagName('tr');
                for (let i = 1; i < rows.length; i++) { // Skip the header row
                rows[i].style.display = '';
                }
                document.getElementById('filterInput').value = ''; // Clear the input box
            }
            */
        </script>
        <?php 
    }
    //FOR BANK RECONCILIATION
    if($FormID == 2896){
        ?>
        <script>
            $(document).ready(function(){
                $("#bankreco, #bankreco1, #bankrecoexport").on('click', function(event) {
                    event.preventDefault(); // stops any default behavior (like form submission)

                    const clickedId = this.id; // 'bankreco' or 'bankreco1'
                    if(clickedId == 'bankrecoexport'){
                        loadBankRecoData(clickedId);
                    }else{
                        $('#myModal').modal('show');
                        // Attach one-time event to modal
                        $('#myModal').one('shown.bs.modal', function () {
                            var ddTbody = $("#dropdownItems");
                            ddTbody.empty();
                            $('#ShowAdjustableAmountField').css('display', 'flex');
                            $('.PopupAmount').css('display','none');
                            $('.PopupBalance').css('display','none');
                            // $("#pillContainer").show();
                            // $('#pillContainerClear').css("display","none");
                            $('#PopulateGridButton').hide();
                            $('#PopupAdjamount').val(0.00);
                            $("#pillContainer").hide();
                            triggeringButtonId = clickedId;
                            console.log("triggeringButtonId",triggeringButtonId);
                            $('#DropDownModalID').val(triggeringButtonId);
                            loadBankRecoData(clickedId);
                            $("#clearSelection").hide();
                            $(".modal-footer").html("<p>Shortcut: Press Alt + K to jump to the next row and auto-fill it with the previous date.</p>");
                        });
                    }
                    // alert('Picked: ');
                });

            

                // $("#bankrecoexport").on('click', function(event) {
                //     event.preventDefault(); // stops any default behavior (like form submission)
                //     loadBankRecoData('bankrecoexport');
                //     // alert('Picked: ');
                // });    
            });
        </script>
        <?php
    }
    ?>
    <!-- Added by pornima on date 11-01-2024 -->
    <input type="hidden" name="callScriptBeforeUnload" id="callScriptBeforeUnload" value="1">
    <script>
           window.addEventListener('beforeunload', function (event) {
                // In amount adjustment form don't want to delete temp table
                // if(+$("#callScriptBeforeUnload").val() == 1){
                    console.log('calling unload...**********',$("#callScriptBeforeUnload").val())
                    var url = 'formUnloadAPI.php?FormID=<?php echo $FormID; ?>&EntryID=<?php echo $editID; ?>&UnloadData=' + +$("#callScriptBeforeUnload").val() + ' ';
                    var data = JSON.stringify({ message: 'Page is being closed' });
                    
                    if (navigator.sendBeacon) {
                        // Use navigator.sendBeacon if supported
                        navigator.sendBeacon(url, data);
                    } else {
                        // Fallback to fetch
                        fetch(url, {
                            method: 'POST',
                            body: data,
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        }).catch(function (error) {
                            console.error('Error:', error);
                        });
                    }
                // }else{
                    // console.log('not calling unload...**********',$("#callScriptBeforeUnload").val())
                // }
           
               // Note: returnValue is assigned for compatibility purposes.
               // event.returnValue = '';
           });
           
        // });
    </script>

    <?php
}
?>

<?php if(isset($_REQUEST['preview']) || $viewpage > 0){ ?>
    <script>
        function ListViewVoucherPrint(editID){
            $("#PrintReportID").val(editID);
            $('#list-view-print-modal').modal('show');
        }

        function ListViewVoucherPrintOpen(FormID){
            if(+$("#reportTemplateSelect").val() > 0){
                var allFilled = true; 
                $('.reportParamSection input[required]').each(function() { 
                    if (!$(this).val()) { 
                        allFilled = false; 
                        return false; 
                    } 
                }); 
                if (allFilled) { 
                    var otherParams = '&id=' + $("#PrintReportID").val();
                    var cntParams = $("#PrintReportParamsCnt").val();
                    if(+cntParams > 0){
                        otherParams += "&" + $('#list-view-print-modal-body .reportParamSection').find('input, select').serialize();
                    }
                    console.log("otherParams",otherParams);
                    window.open('pdf-report.php?form=' + FormID + '&PDFPrint=' + $("#reportTemplateSelect").val() + otherParams, '_blank', 'width=800,height=600');
                } else { 
                    alert('Please fill all required parameters.'); 
                }
            } else {
                alert("Select a Template");
            }  
            return;
        }

        $(document).ready(function() {
            $('.reportTemplateSelect').change(function () {
                console.log(this.value);
                var reportID = $("#PrintReportID").val();
                var templateId = this.value;
                $(".reportParamSection").html('');
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
                                if(data[i]['DefaultValue'] !== null){    def = data[i]['DefaultValue']; }
                                params += '<div class="col-md-4"><label>'+data[i]['DisplayName']+labelAtt+'</label><select ' +otherAtt+ 'class="form-control"  name="'+data[i]['FieldName']+'" id="'+data[i]['FieldName']+'"><option></option>';
                                var tmp = res[1][data[i]['ID']];
                                // var sel = "";
                                for(j = 0; j < tmp['result_set'].length; j++){
                                    sel = "";
                                    if(def == tmp['result_set'][j][tmp['ID']])  sel = "selected";
                                    params += '<option '+sel+' value="'+tmp['result_set'][j][tmp['ID']]+'">'+tmp['result_set'][j][tmp['Label']]+'</option>';
                                }
                                params += '</select></div>';
                            }
                        }
                        if(i > 0){
                            $(".reportParamSection").show();
                            $(".reportParamSection").html("<div class='col-md-12'><h5>Report Parameters</h5></div>" + params);
                        }
                        $("#PrintReportParamsCnt").val(i);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Got ERROR Data frm API", jqXHR);
                        console.log("Got ERROR Data frm API", textStatus);
                        callback(new Error(textStatus || errorThrown));
                    }
                });
            });
            
        });

        function ListViewBarcodePrint(editID, gridRowId = null){
            $("#BarcodeReportID").val(editID);
            $("#GdRowID").val(gridRowId);
            $('#list-view-barcode-modal').modal('show');
        }
        
        function ListViewBarcodePrintOpen(FormID){
            var gRowId = $("#GdRowID").val();
            if(gRowId){
                window.open('print-barcodes.php?form=' + FormID + '&TempID=' + $("#barcodeTemplateSelect").val()+'&editID='+$("#BarcodeReportID").val()+'&gridRowEditID='+$("#GdRowID").val(), '_blank', 'width=800,height=600');
            }else{
                window.open('print-barcodes.php?form=' + FormID + '&TempID=' + $("#barcodeTemplateSelect").val()+'&editID='+$("#BarcodeReportID").val(), '_blank', 'width=800,height=600');
            }
        }
    </script>
    <?php 
    if((int)$viewSettings[16] > 0){  
        ?>
        <div class="modal fade" id="list-view-print-modal" tabindex="-1" role="dialog" aria-labelledby="Print" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle" style="display:contents;">Print Template</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="list-view-print-modal-body" class="modal-body" style="min-height: 200px;">
                        <input type="hidden" name="" id="PrintReportID" value="" />
                        <input type="hidden" name="" id="PrintReportParamsCnt" value="0" />
                        <div class="row">
                            <div class="col-md-6 template" >
                                <label for="template">Select Print Template <span class="required"> *</span></label>
                                <!-- <select name="template" class="reportTemplateSelect form-control" id="reportTemplateSelect" tabindex="1" required>
                                    <option value=""></option>
                                    <?php
                                        $sql = 'SELECT ID, TemplateName FROM kreport_pdf_templates where isActive = 1 and ReportID = ' . $viewSettings[16] . '  order by TemplateOrder';
                                        
                                        $result1 = db::getInstanceMaster()->db_select($sql, "L-882");
                                        // Output the number of rows
                                        $num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
                                        // echo "Number of rows in the result set: $num_rows<br>";
                                        // Loop through the result set and output options
                                        for ($i = 0; $i < $num_rows; $i++) {
                                            echo '<option class="gridTemplate" value="' . $result1['result_set'][$i]['ID'] . '">' . $result1['result_set'][$i]['TemplateName'] . '</option>';
                                        }
                                    ?>
                                </select> -->

                                <select name="template" class="reportTemplateSelect form-control" id="reportTemplateSelect" tabindex="1" required>
                                    <!-- <option value=""></option> -->
                                    <?php
                                    $sql = "select * from kreport_pdf_templates WHERE ID IN (
                                            select TemplateId from map_kreport_pdf_templates where formid=$FormID
                                            and templateid not in (select pdfreportid from  map_pdfreport_groups )
                                            union all
                                            select TemplateId from map_kreport_pdf_templates WHERE TemplateId IN
                                            (select PDFReportID from map_pdfreport_groups  where groupid ={$_SESSION['group_id']}
                                            and pdfreportid in (select templateid from map_kreport_pdf_templates where formid=$FormID))
                                            ) ORDER BY TemplateOrder";

                                        $result1 = db::getInstanceMaster()->db_select($sql,"L-907");
                                        $num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);

                                        for ($i = 0; $i < $num_rows; $i++) {
                                            $template = $result1['result_set'][$i];
                                            echo '<option class="gridTemplate" value="' . $template['ID'] . '" ' . $template['Selected'] . '>' . $template['TemplateName'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="allfields reportParamSection" style="display:none;">
                                <h5>Parameters</h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="printModalCloseBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="printModalPrintBtn" class="btn btn-primary" onclick="ListViewVoucherPrintOpen(<?php echo $viewSettings[16] ?>)">PRINT</button>
                    </div>
                </div>
            </div>
        </div>
        <?php 
    }
    $sql = 'SELECT ID, BarcodeTemplateName FROM kFormBarcodeTemplates WHERE FormID='.$FormID.' order by ID';
    $result1 = db::getInstanceMaster()->db_select($sql, "L-952");
    $num_rows = isset($result1['num_rows']) ? $result1['num_rows'] : count($result1['result_set']);
    if($num_rows > 0){
        ?>
        <div class="modal fade" id="list-view-barcode-modal" tabindex="-1" role="dialog" aria-labelledby="Print" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle" style="display:contents;">Print Template</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="list-view-barcode-modal-body" class="modal-body" style="min-height: 200px;">
                        <input type="hidden" name="" id="BarcodeReportID" value="" />
                        <input type="hidden" name="" id="GdRowID" value="0" />
                        <div class="row">
                            <div class="col-md-6 template" >
                                <label for="template">Select Barcode Template <span class="required"> *</span></label>
                                <select name="template" class="reportTemplateSelect form-control" id="barcodeTemplateSelect" tabindex="1" required>
                                    <option value=""></option>
                                    <?php
                                        // echo "Number of rows in the result set: $num_rows<br>";
                                        // Loop through the result set and output options
                                        for ($i = 0; $i < $num_rows; $i++) {
                                            $tempDataSpName = "sp_BarcodePrint_".$FormID."_".$result1['result_set'][$i]['ID'];
                                            $checkSp = "SELECT COUNT(*) AS found FROM information_schema.routines WHERE routine_schema = 'DBO'  AND  routine_name = '$tempDataSpName'";
                                            $checkSpResult = db::getInstance()->db_select($checkSp, "L-960: Cl-");
                                            if($checkSpResult['result_set'][0]['found'] == 1){
                                                echo '<option class="gridTemplate" value="' . $result1['result_set'][$i]['ID'] . '">' . $result1['result_set'][$i]['BarcodeTemplateName'] . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="allfields reportParamSection" style="display:none;">
                                <h5>Parameters</h5>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="barcodeModalCloseBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="barcodeModalPrintBtn" class="btn btn-primary" onclick="ListViewBarcodePrintOpen(<?php echo $FormID; ?>)">PRINT</button>
                    </div>
                </div>
            </div>
        </div>        
        <?php 
    }
} ?>

<!--GENERAL ON LOAD SCRIPT FOR THE ENTIRE PAGE VIEW EDIT AND ADD-->
<script>
	$(document).ready(function() {
	    $(".page-header h2").html("<h2><?php echo $viewSettings[1]; ?></h2>");
	    $(document).prop('title', '<?php echo $viewSettings[1]; ?>');
	   // $('form').attr('action', 'db_backup_31.php');
	});
	function getTodaysDate(){
	    var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = ((''+day).length<2 ? '0' : '') + day + '/'
            + ((''+month).length<2 ? '0' : '') + month + '/' 
            + d.getFullYear();
        return(output);
	}
	function formatDate(dt){
        const d = new Date(dt);
        // return d.getDate().toString().padStart(2, '0') + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = ((''+day).length<2 ? '0' : '') + day + '/'
            + ((''+month).length<2 ? '0' : '') + month + '/' 
            + d.getFullYear();
        return(output);
	}
	function formatReverseDate(dt){
        const d = new Date(dt);
        // return d.getDate().toString().padStart(2, '0') + '/' + d.getMonth() + 1 + '/' + d.getFullYear();
        var month = d.getMonth()+1;
        var day = d.getDate();
        var output = d.getFullYear() + '-'
            + ((''+month).length<2 ? '0' : '') + month + '-' 
            + ((''+day).length<2 ? '0' : '') + day
            ;
        return(output);
	}
	
	//FUNCTION NOT YET USED BUT CAN BE USED INSTEAD OF formatReverseDate
	function getDateFormat(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
        
        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;
        var date = new Date();
        date.toLocaleDateString();
        
        return [day, month, year].join('-');
    }
    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector("#loader").style.visibility = "visible";
        } 
        else {
            document.querySelector("#loader").style.display = "none";
        }
    };

</script>

<?php 
	include "form-close.php"; 
?>
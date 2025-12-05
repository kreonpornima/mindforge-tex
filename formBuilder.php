<?php
    // include "dbClass.php";
    $db = db::getInstanceMaster();
    $form   = $db->db_select("SELECT isOpenForDevelopment FROM kmainforms WHERE FormId = $FormID");
    $dev = $form['result_set'][0]["isOpenForDevelopment"];

?>

<script>
    $(document).ready(function(){

        // $("#cancelButton").parent('div').remove();
        $(".panel-title").text("Designer Mode");
        $(".allfields").each(function () {

            // Find the label inside each .allfields
            let label = $(this).find("label");

            label.each(function () {
                // Check if this label is inside .allgrids
                if ($(this).closest(".allgrids").length > 0) {
                    // Add "Form Properties" button for grid fields
                    if ($(this).siblings("button.field-settings-icon").length === 0) {

                        // Get parent div ID
                        let parentDivId = $(this).closest("div").attr("id");
                        let gridid = parentDivId.split("-").pop();
                        console.log("Parent div ID:", gridid);

                        $(this).append(`
                            <span data-type="grid" data-gridid='${gridid}' title="Grid Properties" class="field-settings-icon" style="
                                cursor: pointer;
                                font-size: 10px;
                                vertical-align: middle;
                            ">✏️</span>
                        `);

                        $(this).closest(".allgrids").find("table thead th").each(function() {
                            if ($(this).text().trim() !== '') {
                                var label = $(this).text().trim();
                                $(this).html(`<a href="#" class="field-settings-icon" data-type="gridfields" data-gridid='${gridid}'>${label}</a>`);
                            }
                        });
                    }
                } else {
                    // Add edit icon for normal fields
                    if ($(this).find(".field-settings-icon").length === 0) {
                        $(this).css("position", "relative");
                        $(this).append(`
                            <span data-type="fields" data-gridid='0' class="field-settings-icon" style="
                                cursor: pointer;
                                font-size: 10px;
                                vertical-align: middle;
                            ">✏️</span>
                        `);
                    }
                }
            });
        });

        $(".panel-heading h2.panel-title").after(
            `<div style='position: absolute;right: 12px;'>
                <button class="btn btn-danger btn-xs field-settings-icon" data-type="form" data-gridid='0' style="">Form Properties</button>
                <a href="<?php  echo $_SERVER['PHP_SELF'] . '?form=' . $FormID ; ?>" class="btn btn-info btn-xs " style="">Close Designer</button>
            </div>`
        );
    });

    // CLICK EVENT FOR GEAR ICON
    $(document).on("click", ".field-settings-icon", function () {
        // find nearest input/select/textarea inside the .allfields block
        let label = $(this).closest("label");
        
        let type = $(this).data("type"); 
        $("#saveProperties").attr("data-savetype", type);
        let gridid = $(this).data("gridid"); 
        $("#saveProperties").attr("data-savegrid", gridid);

        if(type == 'gridfields'){
            var fieldName = $(this).text().trim();
        }else{
            // find input/select/textarea immediately after that label
            let field = label.nextAll("input, select, textarea, button").first();
            var fieldName = field.attr("id");
        }
        openFieldPropertyPanel(this,fieldName,type,gridid);
    });

    function openFieldPropertyPanel(icon,fieldName,type,gridid) {
        let label = $(icon).closest("label").text().trim();
        // $("#fp_fieldname").text(label);

        loadProperties(fieldName,type,gridid);
        // open panel
        $("#fieldPropertiesPanel").addClass("open");
    }

    // Close panel
    $(document).on("click", "#closePanelBtn", function () {
        $("#fieldPropertiesPanel").removeClass("open");
    });

    $(document).on("click", "#saveProperties", function () {
        let formData = {};
        let saveType = $(this).data("savetype");
        let savegridID = $(this).data("savegrid");
  

        $(".kmain-list").find("input, select, textarea, button").each(function () {
            let name = $(this).attr("name");
            let value = $(this).val();

            if (name) {  
                formData[name] = value;  
            }
        });

        // Add extra data
        formData["FormID"] = <?php echo $FormID; ?>;
        formData["saveType"] = saveType;
        formData["gridID"] = savegridID;

        console.log("Sending data:", formData);
        $.ajax({
            url: "saveProperties.php",
            method: "POST",
            data: formData,
            success: function (result) {
                let results = JSON.parse(result);
                if (results['success']) {
                    alert("properties updated successfully!");
                    $('#closePanelBtn').click();
                } else {
                    if(results['message']){
                        alert(results['message']);
                    }else{

                        alert("Failed to save!");
                    }
                }
            }
        });
    });

    function loadProperties(fieldName,type,gridid) {
        if(type == 'fields'){
            $('#propertiesHeader').text('Field Properties');
        }else if(type == 'form'){
            $('#propertiesHeader').text('Form Properties');
        }else if(type == 'grid'){
            $('#propertiesHeader').text('Grid Properties');
        }else if(type == 'gridfields'){
            $('#propertiesHeader').text('Grid Field Props');
        }


        const excludeFields = ['CreatedAt', 'UpdatedAt', 'FormId','MDRelationTable','MDPrimary','MDLabel','MDCondition','MDRelationKey','MDForeign'];
        $.ajax({
            url: "getFieldProperties.php",
            method: "POST",
            data: { type: type, FormID: <?php echo $FormID; ?>, FieldName: fieldName, GridID:gridid },
            success: function (result) {
                let res = JSON.parse(result);

                if (res.error) {
                    alert(res.error);
                    return;
                }

                $("#dynamicPanelContent").html(res.html);
                // let results = JSON.parse(result);
                // var fieldsColumn = results['fieldsColumns'];
                // var fields = results['fields']; // actual field data
                // let html = "";//<button id='saveProperties' class='btn btn-primary'>Update</button>
                // html += "<ul class='kmain-list'>";

                // fieldsColumn.forEach(f => {
                //     if (!excludeFields.includes(f.COLUMN_NAME)) {
                //         // Use a default value if not found
                        

                //         if(f.COLUMN_NAME == 'main_id'){
                //             const value = fields[0][f.COLUMN_NAME] ? (fields[0][f.COLUMN_NAME] || '') : '';
                //             html +=`<input type="hidden" name="${f.COLUMN_NAME}" class="form-control" value="${value}" />`;
                //         }else{
                //             if(f.DATA_TYPE == 'int' || f.DATA_TYPE == 'smallint' || f.DATA_TYPE == 'bigint'){ 
                //                 const value = fields[0][f.COLUMN_NAME] ? (fields[0][f.COLUMN_NAME] || '') : 0;
                //                 html += `
                //                     <li class="kmain-item" style="list-style-type: none; margin-bottom: 5px;">
                //                         ${f.COLUMN_NAME}: 
                //                         <input type="number" name="${f.COLUMN_NAME}" class="form-control" value="${value}" />
                                        
                //                     </li>
                //                 `;
                //             }else{
                //                 const value = fields[0][f.COLUMN_NAME] ? (fields[0][f.COLUMN_NAME] || '') : '';
                //                 html += `
                //                     <li class="kmain-item" style="list-style-type: none; margin-bottom: 5px;">
                //                         ${f.COLUMN_NAME}: 
                //                         <input type="text" name="${f.COLUMN_NAME}" class="form-control" value="${value}" />
                                        
                //                     </li>
                //                 `;
                //             }
                //         }
                //     }
                // });

                // html += "</ul>";
                // $("#dynamicPanelContent").html(html);
            }
        });
    }


</script>

<style>
    #fieldPropertiesPanel {
        width: 300px;
        height: 100%;
        background: #fff;
        position: fixed;
        top: 0;
        right: -300px; /* hidden */
        border-left: 2px solid #ccc;
        transition: 0.3s;
        z-index: 9999;
        display: flex;
        flex-direction: column;
    }

    #fieldPropertiesPanel.open {
        right: 0;
    }

    .panel-header {
        font-size: 18px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #ccc;
        flex-shrink: 0; /* keep header fixed */
    }

    #closePanelBtn {
        cursor: pointer;
        font-size: 20px;
    }

    .panel-body {
        padding: 10px;
        flex-grow: 1; /* take remaining space */
        /* overflow-y: auto; make scrollable */
    }

</style>

<div id="fieldPropertiesPanel">
    <div class="panel-header">
        <span id="propertiesHeader">Field Properties</span><?php if($dev == 1){ ?> <button id='saveProperties'  data-savetype="" data-savegrid="" class='btn btn-danger'>Update</button><?php } ?>
        <?php if($dev != 1){ echo "<br><span style='font-size: 12px;color: red;position: absolute;top: 40px;'>Not Open For Developement.</span>"; } ?>
        <span id="closePanelBtn">✖</span>
    </div>

    <div class="panel-body">

        <div id="dynamicPanelContent">
            <!-- All kmainfields will load here -->
        </div>

    </div>
</div>



<!-- https://js.devexpress.com/jQuery/Documentation/ApiReference/Data_Layer/PivotGridDataSource/ -->
<?php
if(1){
  $filterCode = array();
  $ReportID = isset($_REQUEST['ReportID']) ? $_REQUEST['ReportID'] : 0;
  $k_head_title="Report";
  $k_head_include = "";
  include "report-init-ent1.php";

  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
      $url = "https://";   
  else  
      $url = "http://";  
  $url .= $_SERVER['HTTP_HOST'];   
  $url.= $_SERVER['REQUEST_URI'];
  $urlpos = strpos($url, '&', strpos($url, '&') + 1);
  $url = substr($url, 0, $urlpos);
  $sql = "SELECT * FROM $db[0] WHERE 1=1 LIMIT 10";
  $requestArray = [];
 
  for($i = 0; $i < sizeof($filterCode); $i++){
      if(isset($_REQUEST[$filterCode[$i][1]]) || isset($_REQUEST[$filterCode[$i][2]])){
          if(isset($_REQUEST[$filterCode[$i][1]])){
              $requestArray[$filterCode[$i][1]] = $_REQUEST[$filterCode[$i][1]];
          }else{
              $requestArray[$filterCode[$i][2]] = $_REQUEST[$filterCode[$i][2]];
          }
      }
  }
  // echo $viewReportSettings[3];

  foreach($_REQUEST as $name => $value) {
      if($name != "ReportID" && $name != "view") {
          // $requestArray[$name] = $value;
          if(isset($name)) {
              if(gettype($value) == "array") {
                  if(sizeof($value) > 0) {
                      $sql .= " AND $name IN ('" . implode("','", $value) . "' ) ";
                  }
              } else {
                  if(is_numeric($value)) {
                      $valueINT = (int) $value;
                      if($valueINT !== 0) {
                         $sql .= " AND $name = $valueINT ";
                      }
                  } else {
                      if(strlen($value) > 0) {
                          $sql .= " AND $name = '$value' ";
                      }
                  }
              }
          }
      }
  }

  // echo 
  $viewResult = db::getInstance()->db_select($sql);
  // print_r($viewResult);
  // echo json_encode($viewResult['result_set']);
  $dateColumns = array();
  $dateColumnCount = 0;
  
  for($i =0; $i < $viewResult['num_rows']; $i++){
    foreach($viewResult['result_set'][$i] as $key => $value){
      if (validateDate($value, 'Y/m/d')) {  // it's a date
        if(!in_array($key, $dateColumns)) $dateColumns[$dateColumnCount++] = $key;
      }
      if (validateDate($value, 'Y-m-d')) {  // it's a date
        if(!in_array($key, $dateColumns)) $dateColumns[$dateColumnCount++] = $key;
      }
    }
  }
  // print_r($dateColumns);
  if($dateColumnCount > 0){
    $dateDataSource = "fields :[";
    $separator = "";
    for($i = 0; $i < $dateColumnCount; $i++){
      $dateDataSource .= $separator . "{
          dataField:'".$dateColumns[$i]."',
          dataType:'date'
        }";
      $separator = ",";
    }
      $dateDataSource .= "],";
  }
  function validateDate($date, $format = 'Y-m-d'){
      $d = DateTime::createFromFormat($format, $date);
      // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
      return $d && $d->format($format) === $date;
  }
}
?>
<style>
    .mood-renderer {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
    }

    .mood {
        border-radius: 15px;
        border: 1px solid grey;
        background-color: #e6e6e6;
        padding: 15px;
        text-align: center;
        display: inline-block;
        outline: none;
    }

    .default {
        border: 1px solid transparent !important;
        padding: 4px;
    }

    .selected {
        border: 1px solid lightgreen !important;
        padding: 4px;
    }

    .numeric-input {
        box-sizing: border-box;
        padding-left: var(--ag-grid-size);
        width: 100%;
        height: 100%;
    }

    .my-simple-editor {
        box-sizing: border-box;
        padding-left: var(--ag-grid-size);
        width: 100%;
        height: 100%;
    }

    #myGrid {
      flex: 1 1 auto;
        /* width: 1380px; */
      height:600px;
    }

</style>


<script>
      (function () {
        const appLocation = "";
        window.__basePath = appLocation;
      })();
</script>
<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script>

<div id="myGrid" class="ag-theme-quartz"></div>
 
<script>
    // agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-059380}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{30 June 2024}____[v3]_[0102]_MTcxOTcwMjAwMDAwMA==59fc6bfa6d27f2fc6c8e0be66a04b355");
    agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-061119}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 July 2024}____[v3]_[0102]_MTcyMjM4MDQwMDAwMA==945278da60ff465f559911e628a1a59f"); //new

    function getData() {
        const cloneObject = (obj) => JSON.parse(JSON.stringify(obj));

        const students = [
            {
                first_name: 'Bob',
                last_name: 'Harrison',
                age: 15,
                gender: 'Male',
                mood: 'Happy',
                mood1: 'Happy',
                color: 'Aqua',
                date: '2024-07-10',
            },
            {
                first_name: 'Mary',
                last_name: 'Wilson',
                gender: 'Female',
                age: 11,
                mood: 'Sad',
                mood1: 'Sad',
                color: 'Beige',
                date: '2024-07-09',
            },
            {
                first_name: 'Zahid',
                last_name: 'Khan',
                gender: 'Male',
                age: 12,
                mood: 'Happy',
                mood1: 'Happy',
                color: 'Green',
                date: '2024-07-13',
            },
            {
                first_name: 'Jerry',
                last_name: 'Mane',
                gender: 'Male',
                age: 12,
                mood: 'Happy',
                mood1: 'Happy',
                color: 'Blue',
                date: '2024-07-14',
            },
        ];

        // double the array twice, make more data!
        students.forEach((item) => {
            students.push(cloneObject(item));
        });
        students.forEach((item) => {
            students.push(cloneObject(item));
        });
        students.forEach((item) => {
            students.push(cloneObject(item));
        });

        return students;
    }

    class GenderRenderer  {
        eGui;
        init(params) {
            this.eGui = document.createElement('span');
            if (params.value) {
                const icon = params.value === 'Male' ? 'fa-male' : 'fa-female';
                this.eGui.innerHTML = `<i class="fa ${icon}"></i> ${params.value}`;
            }
        }

        getGui() {
            return this.eGui;
        }
        refresh(params) {
            return false;
        }
    }

    class MoodEditor  {
        defaultImgStyle;
        selectedImgStyle;
        mood;
        container;
        happyImg;
        sadImg;

        constructor() {
            this.defaultImgStyle = 'padding-left:10px; padding-right:10px;  border: 1px solid transparent; padding: 4px;';
            this.selectedImgStyle = 'padding-left:10px; padding-right:10px; border: 1px solid lightgreen; padding: 4px;';
        }

        onKeyDown(event) {
            const key = event.key;
            if (
                key === 'ArrowLeft' || // left
                key === 'ArrowRight'
            ) {
                // right
                this.toggleMood();
                event.stopPropagation();
            }
        }

        toggleMood() {
            this.selectMood(this.mood === 'Happy' ? 'Sad' : 'Happy');
        }

        init(params) {
            this.container = document.createElement('div');
            this.container.style =
                'border-radius: 15px; border: 1px solid grey;background-color: #e6e6e6;padding: 15px; text-align:center;display:inline-block;outline:none';
            this.container.tabIndex = '0'; // to allow the div to capture events

            this.happyImg = document.createElement('img');
            this.happyImg.src = 'https://www.ag-grid.com/example-assets/smileys/happy.png';
            this.happyImg.style = this.defaultImgStyle;

            this.sadImg = document.createElement('img');
            this.sadImg.src = 'https://www.ag-grid.com/example-assets/smileys/sad.png';
            this.sadImg.style = this.defaultImgStyle;

            this.container.appendChild(this.happyImg);
            this.container.appendChild(this.sadImg);

            this.happyImg.addEventListener('click', () => {
                this.selectMood('Happy');
                params.stopEditing();
            });
            this.sadImg.addEventListener('click', () => {
                this.selectMood('Sad');
                params.stopEditing();
            });
            this.container.addEventListener('keydown', (event) => {
                this.onKeyDown(event);
            });

            this.selectMood(params.value);
        }

        selectMood(mood) {
            this.mood = mood;
            this.happyImg.style = mood === 'Happy' ? this.selectedImgStyle : this.defaultImgStyle;
            this.sadImg.style = mood === 'Sad' ? this.selectedImgStyle : this.defaultImgStyle;
        }

        // gets called once when grid ready to insert the element
        getGui() {
            return this.container;
        }

        afterGuiAttached() {
            this.container.focus();
        }

        getValue() {
            return this.mood;
        }

        // any cleanup we need to be done here
        destroy() {}

        isPopup() {
            return true;
        }
    }

    class MoodRenderer  {
        eGui;
        init(params) {
            const div = (this.eGui = document.createElement('div'));
            div.className = 'mood-renderer';

            if (params.value !== '' || params.value !== undefined) {
                const imgForMood =
                    params.value === 'Happy'
                        ? 'https://www.ag-grid.com/example-assets/smileys/happy.png'
                        : 'https://www.ag-grid.com/example-assets/smileys/sad.png';
                this.eGui.innerHTML = `<img width="20px" src="${imgForMood}" />`;
            }
        }

        getGui() {
            return this.eGui;
        }

        refresh(params) {
            return false;
        }
    }

    class SimpleTextEditor  {
        gui;
        params;

        init(params) {
            console.log(params);
            this.gui = document.createElement('input');
            this.gui.type = 'text';
            this.gui.classList.add('my-simple-editor');

            this.params = params;

            let startValue = params.value;
            const eventKey = params.eventKey;
            const isBackspace = eventKey === 'Backspace';

            if (isBackspace) {
                startValue = '';
            } else if (eventKey && eventKey.length === 1) {
                startValue = eventKey;
            }

            if (startValue !== null && startValue !== undefined) {
                this.gui.value = startValue;
            }
        }

        getGui() {
            return this.gui;
        }

        getValue() {
            console.log(this.gui.value);
            return this.gui.value;
        }

        afterGuiAttached() {
            this.gui.focus();
        }
    }

    const createPill = (color) => {
        const colorSpan = document.createElement('span');
        const text = document.createTextNode(color);

        colorSpan.style.backgroundColor = `color-mix(in srgb, transparent, ${color} 20%)`;
        colorSpan.style.boxShadow = `0 0 0 1px color-mix(in srgb, transparent, ${color} 50%)`;
        colorSpan.style.borderColor = color;
        colorSpan.append(text);

        return colorSpan;
    };

    const createTag = (color) => {
        const colorSpan = document.createElement('span');
        const text = document.createTextNode(color);

        colorSpan.style.borderColor = color;
        colorSpan.appendChild(text);

        return colorSpan;
    };

    class ColourCellRenderer  {
        eGui;

        init(params) {
            const eGui = (this.eGui = document.createElement('div'));
            eGui.classList.add('custom-color-cell-renderer');

            const { value } = params;

            let values = [];

            if (Array.isArray(value)) {
                eGui.classList.add('color-pill');
                values = value;
            } else {
                eGui.classList.add('color-tag');
                values = [value];
            }

            const len = values.length;

            for (let i = 0; i < len; i++) {
                const currentValue = values[i];
                if (currentValue == null || currentValue === '') {
                    continue;
                }

                const el = eGui.classList.contains('color-pill') ? createPill(currentValue) : createTag(currentValue);

                eGui.appendChild(el);
            }
        }

        getGui() {
            return this.eGui;
        }

        refresh() {
            return false;
        }
    }

    const valueFormatter = (params) => {
        const { value } = params;
        if (Array.isArray(value)) {
            return value.join(", ");
        }
        return value;
    };

    const valueParser = (params) => {
        const { newValue } = params;
        if (newValue == null || newValue === "") {
            return null;
        }
        return params.newValue.split(",");
    };

    function getValueFromServer(params) {
        return new Promise((resolve) => {
            setTimeout(() => resolve(
                                    ["English", "Spanish", "French", "Portuguese", "(other)"]
                                ), 1000);
        });
    }

    const colors = ['AliceBlue', 'AntiqueWhite', 'Aqua', 'Aquamarine', 'Azure', 'Beige', 'Bisque', 'Black', 'BlanchedAlmond', 'Blue', 'BlueViolet', 'Brown', 'BurlyWood', 'CadetBlue', 'Chartreuse', 'Chocolate', 'Coral', 'CornflowerBlue', 'Cornsilk', 'Crimson', 'Cyan', 'DarkBlue', 'DarkCyan', 'DarkGoldenrod', 'DarkGray', 'DarkGreen', 'DarkGrey', 'DarkKhaki', 'DarkMagenta', 'DarkOliveGreen', 'DarkOrange', 'DarkOrchid', 'DarkRed', 'DarkSalmon', 'DarkSeaGreen', 'DarkSlateBlue', 'DarkSlateGray', 'DarkSlateGrey', 'DarkTurquoise', 'DarkViolet', 'DeepPink', 'DeepSkyBlue', 'DimGray', 'DodgerBlue', 'FireBrick', 'FloralWhite', 'ForestGreen', 'Fuchsia', 'Gainsboro', 'GhostWhite', 'Gold', 'Goldenrod', 'Gray', 'Green', 'GreenYellow', 'Grey', 'Honeydew', 'HotPink', 'IndianRed', 'Indigo', 'Ivory', 'Khaki', 'Lavender', 'LavenderBlush', 'LawnGreen', 'LemonChiffon', 'LightBlue', 'LightCoral', 'LightCyan', 'LightGoldenrodYellow', 'LightGray', 'LightGreen', 'LightGrey', 'LightPink', 'LightSalmon', 'LightSeaGreen', 'LightSkyBlue', 'LightSlateGray', 'LightSlateGrey', 'LightSteelBlue', 'LightYellow', 'Lime', 'LimeGreen', 'Linen', 'Magenta', 'Maroon', 'MediumAquamarine', 'MediumBlue', 'MediumOrchid', 'MediumPurple', 'MediumSeaGreen', 'MediumSlateBlue', 'MediumSpringGreen', 'MediumTurquoise', 'MediumVioletRed', 'MidnightBlue', 'MintCream', 'MistyRose', 'Moccasin', 'NavajoWhite', 'Navy', 'OldLace', 'Olive', 'OliveDrab', 'Orange', 'OrangeRed', 'Orchid', 'PaleGoldenrod', 'PaleGreen', 'PaleTurquoise', 'PaleVioletRed', 'PapayaWhip', 'PeachPuff', 'Peru', 'Pink', 'Plum', 'PowderBlue', 'Purple', 'Rebeccapurple', 'Red', 'RosyBrown', 'RoyalBlue', 'SaddleBrown', 'Salmon', 'SandyBrown', 'SeaGreen', 'Seashell', 'Sienna', 'Silver', 'SkyBlue', 'SlateBlue', 'SlateGray', 'SlateGrey', 'Snow', 'SpringGreen', 'SteelBlue', 'Tan', 'Teal', 'Thistle', 'Tomato', 'Turquoise', 'Violet', 'Wheat', 'White', 'WhiteSmoke', 'Yellow', 'YellowGreen'];

    const columnDefs = [
        { 
            field: "first_name", 
            cellEditor: 'agTextCellEditor',
            cellEditorParams: {
                maxLength: 10
            },
            headerName: "Provided Text" 
        },
        {
            field: "last_name",
            headerName: "Custom Text",
            cellEditor: SimpleTextEditor,
        },
        {
            field: "age",
            headerName: "Provided Number",
            cellEditor: "agNumberCellEditor",
            cellEditorParams: {
                precision: 2,
                step: 0.25,
                showStepperButtons: true,
                // preventStepping: true,
            }

        },
        {
            field: "gender",
            headerName: "Provided Rich Select",
            cellRenderer: GenderRenderer,
            cellEditor: "agRichSelectCellEditor",   //agSelectCellEditor
            cellEditorParams: {
                cellRenderer: GenderRenderer,
                values: ["Male", "Female","Male", "Female","Male", "Female","Male", "Female","Male", "Female","Male", "Female","Male", "Female","Male", "Female","Male", "Female"],
                valueListMaxHeight: 120,
                // valueListMaxWidth: 120,
                allowTyping: true,
                filterList: true,
                highlightMatch: true,
                searchType: "matchAny", //"match"
                // formatValue: value => value.toUpperCase()

            },
        },
        {
            field: "mood",
            headerName: "Custom Mood",
            cellRenderer: MoodRenderer,
            cellEditor: MoodEditor,
            cellEditorPopup: true,
        },
        {
            field: "mood1",
            headerName: "Custom Mood",
            cellEditor: 'agLargeTextCellEditor',
            cellEditorPopup: true,
            cellEditorParams: {
                maxLength: 100,
                rows: 5,
                cols: 10
            }
        },
        // {
        //     headerName: "Date Editor",
        //     field: "date",
        //     valueFormatter: (params) => {
        //     if (!params.value) {
        //         return "";
        //     }
        //     alert(params.value.getMonth());
        //     const month = params.value.getMonth() + 1;
        //     const day = params.value.getDate();
        //     return `${params.value.getFullYear()}-${month < 10 ? "0" + month : month}-${day < 10 ? "0" + day : day}`;
        //     },
        //     cellEditor: "agDateCellEditor",
        // },
        {
            headerName: "Ajax Values",
            field: "color",                             //https://www.ag-grid.com/javascript-data-grid/provided-cell-editors-rich-select/
            cellEditor: "agRichSelectCellEditor",
            cellEditorParams: {
                values: getValueFromServer,
                // multiSelect: true,
                searchType: "matchAny",
                allowTyping: true,
                filterList: true,
                highlightMatch: true,
                valueListMaxHeight: 220,
            },
        },
        {
            headerName: "Multi Select",
            field: "color",
            cellEditor: "agRichSelectCellEditor",
            cellEditorParams: {
                values: colors,
                multiSelect: true,
                searchType: "matchAny",
                filterList: true,
                highlightMatch: true,
                valueListMaxHeight: 220,
            },
        },
        {
            headerName: "Multi Select (No Pills)",
            field: "color",
            cellEditor: "agRichSelectCellEditor",
            cellEditorParams: {
                values: colors,
                suppressMultiSelectPillRenderer: true,
                multiSelect: true,
                searchType: "matchAny",
                filterList: true,
                highlightMatch: true,
                valueListMaxHeight: 220,
            },
        },
        {
            headerName: "Multi Select (With Renderer)",
            field: "color",
            cellRenderer: ColourCellRenderer,
            cellEditor: "agRichSelectCellEditor",
            cellEditorParams: {
                values: colors,
                cellRenderer: ColourCellRenderer,
                suppressMultiSelectPillRenderer: true,
                multiSelect: true,
                searchType: "matchAny",
                filterList: true,
                highlightMatch: true,
                valueListMaxHeight: 220,
            },
        },


    ];

    let gridApi;

    const gridOptions = {
        columnDefs: columnDefs,
        rowData: getData(),
        defaultColDef: {
            editable: true,
            flex: 1,
            minWidth: 100,
            valueFormatter: valueFormatter,
            valueParser: valueParser,
        },
    };

    // setup the grid after the page has finished loading
    document.addEventListener("DOMContentLoaded", () => {
        const gridDiv = document.querySelector("#myGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);
    });

</script>  
   
<?php 
	include "report-close.php"; 
?>
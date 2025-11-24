<!doctype html>
<html lang="en">
  <head>
    <title>Report Data Entry</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <style media="only screen">
      :root,
      body {
        height: 100%;
        width: 100%;
        margin: 0;
        box-sizing: border-box;
        -webkit-overflow-scrolling: touch;
      }

      html {
        position: absolute;
        top: 0;
        left: 0;
        padding: 0;
        overflow: auto;
        font-family: -apple-system, "system-ui", "Segoe UI", Roboto,
          "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif,
          "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
          "Noto Color Emoji";
      }

      body {
        padding: 16px;
        overflow: auto;
        background-color: transparent;
      }
    </style>
  </head>
  <body>
    <div id="myGrid" style="height: 100%" class="ag-theme-quartz"></div>
    <script>
      (function () {
        const appLocation = "";
        window.__basePath = appLocation;
      })();
    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community@31.3.2/dist/ag-grid-community.js?t=1717759368766"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script>
    <script>
        agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-059380}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{30 June 2024}____[v3]_[0102]_MTcxOTcwMjAwMDAwMA==59fc6bfa6d27f2fc6c8e0be66a04b355");
        let gridApi;
        const gridOptions = {
        columnDefs: [
            { field: "athlete" },
            { field: "age" },
            { field: "country" },
            { field: "year" },
            { field: "date" },
            { field: "sport" },
            { field: "gold" },
            { field: "silver" },
            { field: "bronze" },
            { field: "total" },
        ],
        defaultColDef: {
            editable: true,
            cellDataType: false,
        },
        };

        // setup the grid after the page has finished loading
        document.addEventListener("DOMContentLoaded", () => {
        const gridDiv = document.querySelector("#myGrid");
        gridApi = agGrid.createGrid(gridDiv, gridOptions);

        fetch("https://www.ag-grid.com/example-assets/olympic-winners.json")
            .then((response) => response.json())
            .then((data) => gridApi.setGridOption("rowData", data));
        });


    </script>
  </body>
</html>
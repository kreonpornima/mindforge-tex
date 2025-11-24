<!doctype html>
<html lang="en">
  <head>
    <title>AG Large Data</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.2.1/dist/ag-grid-enterprise.js?t=55198984654"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/ag-charts-enterprise@11.2.0/dist/umd/ag-charts-enterprise.min.js"></script>
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
    <div id="myGrid" style="height: 100%"></div>
    <script>
        agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-076336}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 March 2025}____[v3]_[0102]_MTc0MzM3NTYwMDAwMA==c6567fdb808acaba121aed5798506e61"); //new taken from ai mindforge
        (function () {
            const appLocation = "";

            window.__basePath = appLocation;
        })();

        let gridApi;

        const gridOptions = {
        // columnDefs: [
        //     { field: "athlete", minWidth: 220 },
        //     { field: "country", minWidth: 200 },
        //     { field: "year" },
        //     { field: "sport", minWidth: 200 },
        //     { field: "gold" },
        //     { field: "silver" },
        //     { field: "bronze" },
        // ],

        defaultColDef: {
            flex: 1,
            minWidth: 100,
            sortable: false,
        },

        // use the server-side row model instead of the default 'client-side'
        rowModelType: "serverSide",
        };

        // setup the grid after the page has finished loading
        // document.addEventListener("DOMContentLoaded", function () {
        //     const gridDiv = document.querySelector("#myGrid");
        //     gridApi = agGrid.createGrid(gridDiv, gridOptions);

        //     fetch("https://www.ag-grid.com/example-assets/olympic-winners.json")
        //         .then((response) => response.json())
        //         .then(function (data) {
        //             // setup the fake server with entire dataset
        //             const fakeServer = createFakeServer(data);

        //             // create datasource with a reference to the fake server
        //             const datasource = createServerSideDatasource(fakeServer);

        //             // register the datasource with the grid
        //             gridApi.setGridOption("serverSideDatasource", datasource);
        //     });
        // });
        document.addEventListener("DOMContentLoaded", function () {
            const gridDiv = document.querySelector("#myGrid");
            let gridApi = agGrid.createGrid(gridDiv, gridOptions);

            fetch("https://ai.mindforgeerp.com/reportGetDataFromView2.php?ReportID=5130&Submit=FILTER&&username=mitesh")
                .then(response => response.json())
                .then((res) => {
                    // console.log(res);
                    var data = res[0];
                    var colStructure = res[1];
                    // { data, colStructure } = res;
                    // Set column definitions dynamically
                    gridApi.setGridOption("columnDefs", generateColumnDefs(colStructure));

                    // Setup fake server with fetched data
                    const fakeServer = createFakeServer(data);
                    const datasource = createServerSideDatasource(fakeServer);

                    // Register the datasource with the grid
                    gridApi.setGridOption("serverSideDatasource", datasource);
                })
                .catch(error => console.error("Error fetching data:", error));
        });

        function generateColumnDefs(colStructure) {
            return colStructure.map(col => ({
                field: col.COLUMN_NAME, // Assuming column names exist in colStructure
                headerName: col.COLUMN_NAME.replace(/_/g, ' ').toUpperCase(), // Format header name
                sortable: true,
                filter: true,
                resizable: true,
                // editable: col.IS_EDITABLE || false, // Set editable based on schema
                ...(col.DATA_TYPE === 'float' || col.DATA_TYPE === 'bigint' ? { type: 'numericColumn', cellStyle: { textAlign: 'right' } } : {})
            }));
        }
        function createServerSideDatasource(server) {
            return {
                getRows: (params) => {
                    console.log("[Datasource] - rows requested by grid: ", params.request);
                    const response = server.getData(params.request);

                    setTimeout(() => {
                        if (response.success) {
                            params.success({ rowData: response.rows });
                        } else {
                            params.fail();
                        }
                    }, 500);
                }
            };
        }


        // function createServerSideDatasource(server) {
        //     return {
        //         getRows: (params) => {
        //         console.log("[Datasource] - rows requested by grid: ", params.request);

        //         // get data for request from our fake server
        //         const response = server.getData(params.request);

        //         // simulating real server call with a 500ms delay
        //         setTimeout(() => {
        //             if (response.success) {
        //             // supply rows for requested block to grid
        //             params.success({ rowData: response.rows });
        //             } else {
        //             params.fail();
        //             }
        //         }, 500);
        //         },
        //     };
        // }

        function createFakeServer(allData) {
        return {
            getData: (request) => {
            // in this simplified fake server all rows are contained in an array
            const requestedRows = allData.slice(request.startRow, request.endRow);

            return {
                success: true,
                rows: requestedRows,
            };
            },
        };
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.2.4/dist/ag-grid-enterprise.min.js?t=1745843960475"></script>
    <script src="main.js"></script>
  </body>
</html>
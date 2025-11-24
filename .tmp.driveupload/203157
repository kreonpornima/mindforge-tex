<!doctype html>
<html lang="en">
  <head>
    <title>Dynamic Parameters</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex" />
    <link
      href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;700&amp;display=swap"
      rel="stylesheet"
    />
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
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    />
  </head>
  <body>
    <div id="myGrid" style="height: 100%"></div>
    <script>
      (function () {
        const appLocation = "";

        window.__basePath = appLocation;
      })();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.0.3/dist/ag-grid-enterprise.min.js?t=1734620819232"></script>
    <script>
        function getData() {
            return [
                {
                    name: 'Bob Harrison',
                    gender: 'Male',
                    address: '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Mary Wilson',
                    gender: 'Female',
                    age: 11,
                    address: '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215',
                    city: 'New York',
                    country: 'USA',
                },
                {
                    name: 'Zahid Khan',
                    gender: 'Male',
                    age: 12,
                    address: '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Jerry Mane',
                    gender: 'Male',
                    age: 12,
                    address: '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Bob Harrison',
                    gender: 'Male',
                    address: '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Mary Wilson',
                    gender: 'Female',
                    age: 11,
                    address: '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Zahid Khan',
                    gender: 'Male',
                    age: 12,
                    address: '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Jerry Mane',
                    gender: 'Male',
                    age: 12,
                    address: '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Bob Harrison',
                    gender: 'Male',
                    address: '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Mary Wilson',
                    gender: 'Female',
                    age: 11,
                    address: '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Zahid Khan',
                    gender: 'Male',
                    age: 12,
                    address: '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Jerry Mane',
                    gender: 'Male',
                    age: 12,
                    address: '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Bob Harrison',
                    gender: 'Male',
                    address: '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Mary Wilson',
                    gender: 'Female',
                    age: 11,
                    address: '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Zahid Khan',
                    gender: 'Male',
                    age: 12,
                    address: '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Jerry Mane',
                    gender: 'Male',
                    age: 12,
                    address: '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Bob Harrison',
                    gender: 'Male',
                    address: '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Mary Wilson',
                    gender: 'Female',
                    age: 11,
                    address: '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Zahid Khan',
                    gender: 'Male',
                    age: 12,
                    address: '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Jerry Mane',
                    gender: 'Male',
                    age: 12,
                    address: '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Bob Harrison',
                    gender: 'Male',
                    address: '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Mary Wilson',
                    gender: 'Female',
                    age: 11,
                    address: '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Zahid Khan',
                    gender: 'Male',
                    age: 12,
                    address: '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186',
                    city: 'Dublin',
                    country: 'Ireland',
                },
                {
                    name: 'Jerry Mane',
                    gender: 'Male',
                    age: 12,
                    address: '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634',
                    city: 'Dublin',
                    country: 'Ireland',
                },
            ];
        }
        
        async function fetchCityData(country) {
            try {
                const response = await fetch(`getDataForDynUpdate.php?id=${country}`);
                console.log(response)
                const data = await response.json();
                console.log(data.country)
                return data.country;
            } catch (error) {
                console.error('Error fetching city data:', error);
                return [];
            }
        }
        class GenderCellRenderer  {
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
        const cellCellEditorParams = async (params) => {
            const selectedCountry = params.data.country;
            // const allowedCities = countyToCityMap(selectedCountry);
            const allowedCities = await fetchCityData(selectedCountry); 
            return { 
                values: allowedCities, 
                formatValue: (value) => `${value} (${selectedCountry})`, 
                allowTyping: true,
                filterList: true,
                highlightMatch: true,
                valueListMaxHeight: 220,
                // multiSelect: true,
                // searchType: 'matchAny',

            }; 
        };
        async function getValueFromServer(params) {
            try {
                const response = await fetch(`getDataForDynUpdate.php?id=${params}`);
                const data = await response.json();
                console.log(data.country)
                return data.country;
            } catch (error) {
                console.error('Error fetching city data:', error);
                return [];
            }
            return allowedCities;
            // return new Promise((resolve) => {
            //     setTimeout(() => resolve(['English', 'Spanish', 'French', 'Portuguese', '(other)']), 5000);
            // });
        }

        let gridApi;

        const gridOptions = {
            columnDefs: [
                { field: "name" },
                {
                    field: "gender",
                    cellRenderer: GenderCellRenderer,
                    cellEditor: "agRichSelectCellEditor",
                    cellEditorParams: {
                        values: ["Male", "Female"],
                        cellRenderer: GenderCellRenderer,
                    },
                },
                {
                    field: "country",
                    cellEditor: "agRichSelectCellEditor",
                    cellEditorParams: {
                        cellHeight: 50,
                        values: ["Ireland", "USA"],
                    },
                },
                {
                    field: "city", cellEditor: "agRichSelectCellEditor", 
                    // cellEditorParams: "cellCellEditorParams",
                    cellEditorParams: {
                        values: getValueFromServer(),
                    }
                },
                {
                    field: "address",
                    cellEditor: "agLargeTextCellEditor",
                    cellEditorPopup: true,
                    minWidth: 550,
                },
            ],
            defaultColDef: {
                flex: 1,
                minWidth: 130,
                editable: true,
            },
            rowData: getData(),
            onCellValueChanged: onCellValueChanged,
        };

        function countyToCityMap(match) {
            const map = {
                Ireland: ["Dublin", "Cork", "Galway"],
                USA: ["New York", "Los Angeles", "Chicago", "Houston"],
            };
            return map[match];
        }

        function onCellValueChanged(params) {
            const colId = params.column.getId();
            console.log("onCellValueChanged", colId)
            if (colId === "country") {
                const selectedCountry = params.data.country;
                const selectedCity = params.data.city;
                const allowedCities = countyToCityMap(selectedCountry) || [];
                const cityMismatch = allowedCities.indexOf(selectedCity) < 0;

                if (cityMismatch) {
                    params.node.setDataValue("city", null);
                }
            }
        }

            // setup the grid after the page has finished loading
        document.addEventListener("DOMContentLoaded", () => {
            const gridDiv = document.querySelector("#myGrid");
            gridApi = agGrid.createGrid(gridDiv, gridOptions);
        });

    </script>
  </body>
</html>
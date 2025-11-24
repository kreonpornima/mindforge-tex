<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Interactive AG Grid Switch</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-grid.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-alpine.css" />

  <script src="https://cdn.jsdelivr.net/npm/ag-grid-community/dist/ag-grid-community.min.js"></script>

  <style>
    #gridContainer {
      height: 400px;
      width: 100%;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div id="gridContainer"></div>

  <script>
    let gridOptions = null;
    let gridDiv = null;

    const datasets = {
      cars: [
        { make: "Toyota", model: "Celica", price: 35000 },
        { make: "Ford", model: "Mondeo", price: 32000 },
        { make: "Porsche", model: "Boxter", price: 72000 }
      ],
      students: [
        { name: "Tim", class: "BSC", marks: 35, outof: 50 }, 
        { name: "Far", class: "HSC", marks: 32, outof: 50 }, 
        { name: "Pint", class: "SSC", marks: 72, outof: 100 } 
      ]
    };

    // function getDynamicColumnDefs(rowData) {
    //   if (!rowData || rowData.length === 0) return [];
    //   const sample = rowData[0];
    //   console.log('Sample', sample);
    //   return Object.keys(sample).map(key => ({ field: key }));
    // }
    function getDynamicColumnDefs(rowData) {
        if (!rowData || rowData.length === 0) return [];

        const sample = rowData[0];

        return Object.keys(sample).map(key => {
            var columnDef = { };

            if (key === "make" || key === "class") {
                columnDef = { field: key,
                            cellRenderer: (params) => {
                                // return `<button style="cursor:pointer;">${params.value}</button>`;
                                return `<span style="color:blue; cursor:pointer; text-decoration:underline;">${params.value}</span>`;
                            } };
                columnDef.cellStyle = {
                    cursor: "pointer",
                    color: "blue",
                    textDecoration: "underline"
                };
                columnDef.tooltipValueGetter = () => `Click to switch dataset`;
            }else{
                columnDef = { field: key };
            }

            return columnDef;
        });
    }

    function createGrid(rowData) {
      gridDiv = document.createElement('div');
      gridDiv.id = 'myGrid';
      gridDiv.className = 'ag-theme-alpine';
      gridDiv.style.height = '100%';
      gridDiv.style.width = '100%';

      document.getElementById('gridContainer').appendChild(gridDiv);

      gridOptions = {
        columnDefs: getDynamicColumnDefs(rowData),
        rowData: rowData,
        onCellClicked: handleCellClick
      };

      agGrid.createGrid(gridDiv, gridOptions);
    }

    function destroyGrid() {
      if (gridOptions && gridOptions.api) {
        gridOptions.api.destroy();
      }
      document.getElementById('gridContainer').innerHTML = "";
    }

    function handleCellClick(event) {
        console.log("Clicked cell:", event.colDef.field);
        console.log("Full row data:", event.data);

      if (event.colDef.field === "make") {
        recreateGrid("students"); // switch to student dataset
      } else if (event.colDef.field === "class") {
        recreateGrid("cars"); // switch to cars dataset
      }
    }

    function recreateGrid(type) {
      destroyGrid();
      const data = datasets[type];
      createGrid(data);
    }

    // Load the initial grid (cars)
    document.addEventListener("DOMContentLoaded", () => {
      recreateGrid("cars");
    });
  </script>

</body>
</html>

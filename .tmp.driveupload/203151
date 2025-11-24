<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dynamic AG Grid with Varying Datasets</title>

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

  <button onclick="recreateGrid()">Recreate Grid</button>
  <div id="gridContainer"></div>

  <script>
    let gridOptions = null;
    let gridDiv = null;
    let recreateCount = 0;

    const datasets = [
      [
        { make: "Toyota", model: "Celica", price: 35000 },
        { make: "Ford", model: "Mondeo", price: 32000 },
        { make: "Porsche", model: "Boxter", price: 72000 }
      ],
      [
        { name: "Tim", class: "BSC", marks: 35, outof: 50 }, 
        { name: "Far", class: "HSC", marks: 32, outof: 50 }, 
        { name: "Pint", class: "SSC", marks: 72, outof: 100 } 
      ]
    ];

    function getDynamicColumnDefs(rowData) {
      if (!rowData || rowData.length === 0) return [];

      const sample = rowData[0];
      return Object.keys(sample).map(key => ({ field: key }));
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
        rowData: rowData
      };

      agGrid.createGrid(gridDiv, gridOptions);
    }

    function destroyGrid() {
      if (gridOptions && gridOptions.api) {
        gridOptions.api.destroy();
      }
      document.getElementById('gridContainer').innerHTML = "";
    }

    function recreateGrid() {
      destroyGrid();

      const data = datasets[recreateCount % datasets.length];
      recreateCount++;

      createGrid(data);
    }

    document.addEventListener("DOMContentLoaded", recreateGrid);
  </script>

</body>
</html>

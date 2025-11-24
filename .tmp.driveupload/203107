<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AG Grid Row Group Totals Control</title>
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/styles/ag-grid.css">
    <link rel="stylesheet" href="https://unpkg.com/ag-grid-community/styles/ag-theme-quartz.css">
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Using Inter font */
            margin: 20px;
            background-color: #f4f7f6;
            color: #333;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
        }
        #checkboxContainer {
            background-color: #ffffff;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .checkbox-item input[type="checkbox"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #3498db;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            outline: none;
            transition: background-color 0.2s, border-color 0.2s;
        }
        .checkbox-item input[type="checkbox"]:checked {
            background-color: #3498db;
            border-color: #3498db;
        }
        .checkbox-item input[type="checkbox"]:checked::after {
            content: '✔';
            color: #fff;
            font-size: 14px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .checkbox-item label {
            cursor: pointer;
            font-weight: 500;
            color: #555;
        }
        #myGrid {
            height: 500px; /* Fixed height for the grid */
            width: 100%;
            border-radius: 12px;
            overflow: hidden; /* Ensures rounded corners apply to grid content */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        /* Custom styling for AG Grid group rows */
        .ag-row-group {
            background-color: #e8f5e9 !important; /* Light green for group rows */
            font-weight: bold;
            color: #2e7d32; /* Darker green text */
        }
        .ag-theme-quartz {
            --ag-borders: none; /* Remove default borders for a cleaner look */
            --ag-row-hover-color: #f0f0f0;
            --ag-selected-row-background-color: #e0e0e0;
            --ag-header-background-color: #3498db; /* Blue header */
            --ag-header-foreground-color: #ffffff; /* White header text */
            --ag-odd-row-background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h1>AG Grid: Dynamic Row Group Totals</h1>

    <div id="checkboxContainer">
        </div>

    <div id="myGrid" class="ag-theme-quartz"></div>

    {/* <script src="https://unpkg.com/ag-grid-community/dist/ag-grid-community.min.js"></script> */}
    <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.2.1/dist/ag-grid-enterprise.js?t=55198984654"></script>
    <script>
    agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-076336}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 March 2025}____[v3]_[0102]_MTc0MzM3NTYwMDAwMA==c6567fdb808acaba121aed5798506e61"); //new taken from ai mindforge
        // Global state to track which row group totals are visible
        // Key: columnId, Value: boolean (true for show, false for hide)
        window.rowGroupTotalsVisibility = {};

        // AG Grid options
        const gridOptions = {
            // Define columns
            columnDefs: [
                // Row group columns (hidden, but used for grouping)
                { field: 'country', rowGroup: true,  },
                { field: 'sport', rowGroup: true, },
                // Value columns with aggregation functions
                { field: 'gold', aggFunc: 'sum', headerName: 'Gold Medals' },
                { field: 'silver', aggFunc: 'sum', headerName: 'Silver Medals' },
                { field: 'bronze', aggFunc: 'sum', headerName: 'Bronze Medals' },
                { field: 'total', aggFunc: 'sum', headerName: 'Total Medals' }
            ],
            // Sample data
            rowData: [
                { country: 'USA', sport: 'Swimming', gold: 10, silver: 5, bronze: 2, total: 17 },
                { country: 'USA', sport: 'Athletics', gold: 8, silver: 7, bronze: 3, total: 18 },
                { country: 'Canada', sport: 'Ice Hockey', gold: 6, silver: 4, bronze: 1, total: 11 },
                { country: 'Canada', sport: 'Swimming', gold: 5, silver: 3, bronze: 2, total: 10 },
                { country: 'Mexico', sport: 'Football', gold: 3, silver: 2, bronze: 1, total: 6 },
                { country: 'USA', sport: 'Swimming', gold: 4, silver: 1, bronze: 0, total: 5 },
                { country: 'Canada', sport: 'Ice Hockey', gold: 2, silver: 1, bronze: 1, total: 4 },
                { country: 'Mexico', sport: 'Swimming', gold: 1, silver: 1, bronze: 1, total: 3 },
            ],
            // Enable row grouping
            rowGroupPanelShow: 'always', // Show the row group panel
            groupDisplayType: 'custom', // Crucial for custom group row rendering
            sideBar:'columns',
            // showRowGroup: true,
            // Custom renderer for group rows
            groupRowRendererParams: {
                innerRenderer: (params) => {
                    console.log('innerRenderer')
                    // params.node is the group node
                    // params.value is the group key (e.g., 'USA', 'Swimming')
                    // params.node.field is the column ID this group is based on (e.g., 'country', 'sport')
                    // params.node.aggData contains the aggregated values for this group

                    const colId = params.node.field;
                    // Check if totals for this specific group column should be shown
                    const showTotals = window.rowGroupTotalsVisibility[colId];
                    const totals = params.node.aggData; // Aggregated data for the group

                    let content = `<span>${params.value}</span> (${params.node.allChildrenCount} items)`;

                    if (showTotals && totals) {
                        // Dynamically add totals for relevant aggregated columns
                        // Only show if the column has an aggFunc defined
                        const aggregatedFields = gridOptions.columnDefs
                            .filter(col => col.aggFunc && totals[col.field] !== undefined)
                            .map(col => `${col.headerName.replace(' Medals', '')}: ${totals[col.field]}`);

                        if (aggregatedFields.length > 0) {
                            content += ` - <strong>${aggregatedFields.join(', ')}</strong>`;
                        }
                    }
                    return content;
                }
            },

            // Callback function when the grid is ready
            onGridReady: function(params) {
                console.log('onGridReady')
                    // Store gridApi and columnApi globally for easy access
                window.gridApi = params.api;
                window.columnApi = params.columnApi;

                // Identify row group columns from columnDefs
                const rowGroupCols = gridOptions.columnDefs.filter(col => col.rowGroup);

                // Initialize visibility state for all row group columns to true (show by default)
                rowGroupCols.forEach(col => {
                    window.rowGroupTotalsVisibility[col.field] = true;
                });

                // Generate the external checkboxes
                generateCheckboxes(rowGroupCols);
            }
        };

        // Function to generate checkboxes dynamically
        function generateCheckboxes(rowGroupColumns) {
            console.log('generateCheckboxes')
            const checkboxContainer = document.getElementById('checkboxContainer');
            checkboxContainer.innerHTML = ''; // Clear existing content

            rowGroupColumns.forEach(col => {
                const checkboxDiv = document.createElement('div');
                checkboxDiv.className = 'checkbox-item';

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.id = `checkbox-${col.field}`;
                checkbox.checked = window.rowGroupTotalsVisibility[col.field]; // Set initial state
                checkbox.addEventListener('change', (event) => {
                    const isChecked = event.target.checked;
                    const colId = col.field;
                    window.rowGroupTotalsVisibility[colId] = isChecked; // Update global state
                    console.log(window.rowGroupTotalsVisibility)
                    updateGridDisplay(); // Trigger grid refresh
                });

                const label = document.createElement('label');
                label.htmlFor = `checkbox-${col.field}`;
                // Make the label more descriptive
                label.textContent = `Show totals for "${col.field.charAt(0).toUpperCase() + col.field.slice(1)}" group`;

                checkboxDiv.appendChild(checkbox);
                checkboxDiv.appendChild(label);
                checkboxContainer.appendChild(checkboxDiv);
            });
        }

        // Function to trigger grid display update
        function updateGridDisplay() {
            console.log('updateGridDisplay')
            const newGroupRowRendererParams = {
                innerRenderer: (params) => {
                    const colId = params.node.field;
                    const showTotals = window.rowGroupTotalsVisibility[colId];
                    const totals = params.node.aggData;

                    let content = `<span>${params.value}</span> (${params.node.allChildrenCount} items)`;

                    if (showTotals && totals) {
                        const aggregatedFields = gridOptions.columnDefs
                            .filter(col => col.aggFunc && totals[col.field] !== undefined)
                            .map(col => `${col.headerName.replace(' Medals', '')}: ${totals[col.field]}`);

                        if (aggregatedFields.length > 0) {
                            content += ` - <strong>${aggregatedFields.join(', ')}</strong>`;
                        }
                    }
                    return content;
                }
            };
            window.gridApi.setGridOption('groupRowRendererParams', newGroupRowRendererParams);
            // window.gridApi.refreshCells({ force: true });
            // window.gridApi.onGroupExpandedOrCollapsed();
        }

        // Initialize the grid when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            const gridDiv = document.querySelector('#myGrid');
            // new agGrid.Grid(gridDiv, gridOptions);
            gridApi = agGrid.createGrid(gridDiv, gridOptions);
        });
    </script>
</body>
</html>

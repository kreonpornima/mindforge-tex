<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AG Grid Tree User Rights</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ag-grid-community/styles/ag-theme-alpine.css">
  <!-- <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise/dist/ag-grid-enterprise.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.2.1/dist/ag-grid-enterprise.js?t=55198984654"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
    }
    .ag-theme-alpine {
      height: 500px;
      width: 100%;
    }
  </style>
</head>
<body>

<h3>
  <label><b>Select Role:</b></label>
  <select id="roleSelect">
    <option value="admin">Admin</option>
    <option value="user">User</option>
  </select>
  <button onclick="saveRights()">Save Rights</button>
</h3>

<div id="myGrid" class="ag-theme-alpine"></div>

<script>
  let gridApi;
  // agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-076336}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 March 2025}____[v3]_[0102]_MTc0MzM3NTYwMDAwMA==c6567fdb808acaba121aed5798506e61"); //new taken from ai mindforge

  // Custom header component with search input
  

  const columnDefs = [
    // {
    //   field: 'module',
    //   headerName: 'Module',
    //   cellRenderer: 'agGroupCellRenderer',
    //   width: 250
    // },
    {
      headerName: 'Add',
      field: 'AddBtn',
      width: 80,
      cellRenderer: params => checkboxRenderer(params, 'AddBtn')
    },
    {
      headerName: 'Edit',
      field: 'EditBtn',
      width: 80,
      cellRenderer: params => checkboxRenderer(params, 'EditBtn')
    },
    {
      headerName: 'Delete',
      field: 'DeleteBtn',
      width: 80,
      cellRenderer: params => checkboxRenderer(params, 'DeleteBtn')
    },
    {
      headerName: 'View',
      field: 'ListView',
      width: 80,
      cellRenderer: params => checkboxRenderer(params, 'ListView')
    },
    {
      headerName: 'Print',
      field: 'OtherBtn',
      width: 80,
      cellRenderer: params => checkboxRenderer(params, 'OtherBtn')
    },
    {
      field:'Level1',
      hide: true,
      // suppressToolPanel: true
    },
    {
      field:'Level2',
      hide: true,
      // suppressToolPanel: true
    },
    {
      field:'Level3',
      hide: true,
      // suppressToolPanel: true
    },
  ];
  const myTheme = agGrid.themeQuartz.withParams({
    accentColor: "#15274F",
        backgroundColor: "#000000",
        borderRadius: 3,
        browserColorScheme: "inherit",
        columnBorder: true,
        fontFamily: {
            googleFont: "Roboto"
        },
        fontSize: 12,
        foregroundColor: "#0D0E0F",
        headerFontSize: 14,
        spacing: 1,
        wrapperBorderRadius: 5,
        rowVerticalPaddingScale: 0.6,
        //     accentColor: "#196099",
        // backgroundColor: "#FFFFFF",
        // borderColor: "#0000006B",
        // borderRadius: 2,
        // browserColorScheme: "dark",
        // chromeBackgroundColor: {
        //     ref: "foregroundColor",
        //     mix: 0.07,
        //     onto: "backgroundColor"
        // },
        // columnBorder: true,
        // fontFamily: {
        //     googleFont: "Roboto"
        // },
        // fontSize: 13,
        // foregroundColor: "#000000",
        // headerBackgroundColor: "#152178",
        // headerFontSize: 14,
        // headerTextColor: "#FFFFFF",
        // spacing: 3,
        // wrapperBorderRadius: 4
  });

  const gridOptions = {
    columnDefs,
    theme: myTheme,
    rowData: [], // initially empty
    getRowId: params =>`${params.data.Level1}`, // params.data.id,
    treeData: true,
    animateRows: true,
    groupDefaultExpanded: -1,
    treeDataParentIdField: 'parentId',
    autoGroupColumnDef: {
      // headerName: 'Module',
      // headerComponent: SearchHeader,
      // filter: "agTextColumnFilter",
      filter: 'agMultiColumnFilter',
      filterValueGetter: (params) => {
        return params.data.module;
      },
      // filter: true,
      width: 250,
      cellRendererParams: {
        suppressCount: true,
        innerRenderer: (params) => {
          return params.data?.module ?? '';
        }
      }
    },
    defaultColDef: {
      resizable: true
    },
    onGridReady: function () {
      console.log("✅ Grid is ready. Loading data...");
      loadData(); // ← This will now be called properly
    }
  };


  function checkboxRenderer(params, perm) {
    if (!params.node || !params.data) {
      return document.createTextNode(''); // safe fallback
    }

    const isChecked = params.data?.[perm] ?? false;
    const input = document.createElement('input');
    input.type = 'checkbox';
    input.checked = isChecked;

    // Force update if stale
    setTimeout(() => {
      input.checked = isChecked;
    }, 0);

    input.addEventListener('change', () => {
      const value = input.checked;

      // ✅ Set value on current node
      if (params.node?.setDataValue) {
        params.node.setDataValue(perm, value);
      }

      // ✅ Propagate to children
      propagateToChildren(params.node, perm, value);

      // ✅ Propagate to parent
      propagateToParent(params.node, perm);
    });

    return input;
  }

  function propagateToChildren(node, perm, value) {
    if (!node.childrenAfterGroup) return;

    node.childrenAfterGroup.forEach(child => {
      if (child.setDataValue) {
        child.setDataValue(perm, value);
        // recurse for deeper children
        propagateToChildren(child, perm, value);
      }
    });
  }

  function propagateToParent(node, perm) {
    const parent = node.parent;
    if (!parent || !parent.setDataValue || !parent.childrenAfterGroup) return;

    const allChecked = parent.childrenAfterGroup.every(child => child.data?.[perm]);
    const anyChecked = parent.childrenAfterGroup.some(child => child.data?.[perm]);

    parent.setDataValue(perm, anyChecked); // If at least one child checked, set true
    if (!anyChecked) {
      parent.setDataValue(perm, false); // uncheck parent if none are checked
    }

    // continue up the tree
    propagateToParent(parent, perm);
  }


  async function loadData() {
    try {
      const response = await fetch('menus_loader.php');
     

      // if (!response.ok) {
      //   throw new Error(`HTTP error! status: ${response.status}`);
      // }
      console.log("Response object:", response);
      const text = await response.text();
      // console.log("Raw response text:", text);

      const rawData = JSON.parse(text);
      console.log("Parsed JSON:", rawData);

      const flatModules = rawData.map(row => ({
        // id: row.Level1,
        // module: `[${row.Level1}] ${row.displayname1}`,  // <- Include ID here
        module: row.displayname1 + (row.child_count ? ` (${row.child_count})` : ''),
        parentId: row.parent1 || null,
        AddBtn: row.AddBtn === "1" || row.AddBtn === 1 ? true : false,
        EditBtn: row.EditBtn === "1" || row.EditBtn === 1 ? true : false,
        DeleteBtn: row.DeleteBtn === "1" || row.DeleteBtn === 1 ? true : false,
        ListView: row.ListView === "1" || row.ListView === 1 ? true : false,
        OtherBtn: row.OtherBtn === "1" || row.OtherBtn === 1 ? true : false,
        // add: false,
        // edit: false,
        // delete: false,
        // view: false,
        // print: false,
        Level1: row.Level1,
        Level2: row.Level2,
        Level3: row.Level3,
      }));

      console.log(flatModules);
      console.log("loadData load...");

      // ✅ Defensive check
      if (gridApi) {
        gridApi.setGridOption('rowData',flatModules); 
        setTimeout(() => {
          gridApi.refreshCells({ force: true });
        }, 100); // let it render first
        // gridApi.setRowData(flatModules);
      } else {
        console.error("gridOptions.api is not ready yet.");
      }
    } catch (error) {
      console.error("Error fetching or parsing data:", error);
    }
  }


  document.addEventListener('DOMContentLoaded', function () {
    const gridDiv = document.getElementById('myGrid');
    gridApi = agGrid.createGrid(gridDiv, gridOptions);
  });

  function saveRights() {
    const rights = [];
    gridApi.forEachNode(node => {
      const { id, module, AddBtn, EditBtn, DeleteBtn, ListView, OtherBtn, Level1, Level2, Level3 } = node.data;
      rights.push({ id, module, AddBtn, EditBtn, DeleteBtn, ListView, OtherBtn, Level1, Level2, Level3 });
    });
    console.log('Saved Rights:', rights);
    // alert("Rights saved to console (F12 to view).");

    fetch('save_rights.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(rights),
    })
      .then(res => res.json())
      .then(data => {
        console.log('Server Response:', data);
        alert('Rights saved to database.');
      })
      .catch(err => {
        console.error('Error saving rights:', err);
        alert('Failed to save rights.');
      });
  }

  
</script>

</body>
</html>

<?php
include_once('dbClass.php');
session_start();
$k_head_title = $k_page_title = 'HOME';
include 'k_files/k_header.php';

// Fetch report configurations from the database
$sql = "SELECT * FROM dashboard_reports1 ORDER BY id ASC";
$results = db::getInstance()->db_select($sql);

// Get username from session
$username = $_SESSION['username'] ?? 'guest'; // fallback in case session is not set
?>

<div class="container-fluid">
    <?php
    $totalCol = 0;
    echo '<div class="row">';

    foreach ($results['result_set'] as $report) {
        preg_match('/col-md-(\d+)/', $report['col_class'], $matches);
        $colWidth = isset($matches[1]) ? intval($matches[1]) : 12;
        $totalCol += $colWidth;

        if ($totalCol > 12) {
            echo '</div><div class="row">';
            $totalCol = $colWidth;
        }

        $gridId = 'grid' . $report['id'];

        echo '<div class="' . $report['col_class'] . '">';
        echo '  <section class="panel ' . $gridId . '">';
        echo '    <header class="panel-heading">';
        echo '      <div style="display: flex; justify-content: space-between;">';
        echo '        <h2 class="panel-title">Report</h2>';
        echo '      </div>';
        echo '      <p class="panel-subtitle">Template</p>';
        echo '    </header>';
        echo '    <div class="panel-body">';
        echo '      <div id="' . $gridId . '" class="ag-theme-alpine" style="height: 300px;"></div>';
        echo '    </div>';
        echo '  </section>';
        echo '</div>';
    }

    echo '</div>';
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/ag-grid-enterprise@33.2.1/dist/ag-grid-enterprise.js"></script>
<script src="https://cdn.jsdelivr.net/npm/ag-charts-enterprise@11.2.0/dist/umd/ag-charts-enterprise.min.js"></script>
<script>
    agGrid.LicenseManager.setLicenseKey("[TRIAL]_this_{AG_Charts_and_AG_Grid}_Enterprise_key_{AG-076336}_is_granted_for_evaluation_only___Use_in_production_is_not_permitted___Please_report_misuse_to_legal@ag-grid.com___For_help_with_purchasing_a_production_key_please_contact_info@ag-grid.com___You_are_granted_a_{Single_Application}_Developer_License_for_one_application_only___All_Front-End_JavaScript_developers_working_on_the_application_would_need_to_be_licensed___This_key_will_deactivate_on_{31 March 2025}____[v3]_[0102]_MTc0MzM3NTYwMDAwMA==c6567fdb808acaba121aed5798506e61");

    async function initializeGrid(gridId, apiUrl) {
        const { 0: rowData, 1: columnStructure } = await fetchGridData(apiUrl);

        const gridOptions = {
            columnDefs: generateColumnDefs(columnStructure),
            rowData: rowData,
            pagination: true,
            defaultColDef: { flex: 1, filter: true, sortable: true },
        };

        agGrid.createGrid(document.getElementById(gridId), gridOptions);
    }

    async function initializeGrid1(gridId, apiUrl) {
        const { 0: rowData, 1: columnStructure, 4: gridConfig, 5: TemplateName, 6: ReportName } = await fetchGridData(apiUrl);
        const parsedConfig = JSON.parse(gridConfig);

        $("." + gridId + " .panel-title").text(ReportName);
        $("." + gridId + " .panel-subtitle").html(TemplateName);

        const gridOptions = {
            columnDefs: generateColumnDefs(columnStructure),
            rowData: rowData,
            pagination: true,
            defaultColDef: { flex: 1, filter: true, sortable: true },
            pivotMode: parsedConfig?.pivot?.pivotMode ?? false,
            onGridReady: params => {
                if (params.api) {
                    window[`${gridId}Api`] = params.api;

                    // Apply saved configurations if available
                    if (parsedConfig?.columnSizing?.columnSizingModel) {
                        params.api.applyColumnState({
                            state: parsedConfig.columnSizing.columnSizingModel,
                            applyOrder: true
                        });
                    }
                    if (parsedConfig?.sort?.sortModel) {
                        params.api.applyColumnState({
                            state: parsedConfig.sort.sortModel.map(model => ({
                                colId: model.colId,
                                sort: model.sort
                            })),
                            applyOrder: true
                        });
                    }
                    if (parsedConfig?.rowGroup?.groupColIds) {
                        params.api.applyColumnState({
                            state: parsedConfig.rowGroup.groupColIds.map(colId => ({ colId, rowGroup: true }))
                        });
                    }
                    if (parsedConfig?.aggregation?.aggregationModel) {
                        params.api.applyColumnState({
                            state: parsedConfig.aggregation.aggregationModel.map(model => ({
                                colId: model.colId,
                                aggFunc: model.aggFunc
                            })),
                            applyOrder: true
                        });
                    }
                    if (parsedConfig?.columnVisibility?.hiddenColIds) {
                        parsedConfig.columnVisibility.hiddenColIds.forEach(colId => {
                            if (params.columnApi) {
                                params.columnApi.setColumnVisible(colId, false);
                            }
                        });
                    }
                    if (parsedConfig?.focusedCell) {
                        params.api.setFocusedCell(parsedConfig.focusedCell.rowIndex, parsedConfig.focusedCell.colId);
                    }
                }
            }
        };

        agGrid.createGrid(document.getElementById(gridId), gridOptions);
    }

    async function fetchGridData(apiUrl) {
        console.log("Fetching from:", apiUrl);
        try {
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error("Failed to fetch data");
            return await response.json();
        } catch (error) {
            console.error("Error fetching data:", error);
            return { rowData: [], columnStructure: [] };
        }
    }

    function generateColumnDefs(columnStructure) {
        return columnStructure.map(col => ({
            field: col.COLUMN_NAME,
            headerName: col.COLUMN_NAME.replace(/_/g, ' ').toUpperCase(),
            sortable: true,
            filter: true,
            resizable: true,
            editable: false,
            ...(col.DATA_TYPE === 'float' || col.DATA_TYPE === 'bigint' ? {
                type: 'numericColumn',
                cellStyle: { textAlign: 'right' }
            } : {})
        }));
    }

    document.addEventListener("DOMContentLoaded", function () {
        <?php
        foreach ($results['result_set'] as $report) {
            $baseUrl = 'https://ai.mindforgeerp.com/reportGetDataFromView2-Template.php';
            $params = ['username' => $username];

            if (!empty($report['template_id'])) {
                $params['ReportID'] = 0;
                $params['TemplateID'] = $report['template_id'];
            } else {
                $params['ReportID'] = $report['report_id']; // actually report_id
            }

            $constructedUrl = $baseUrl . '?' . http_build_query($params);
            $jsUrl = json_encode($constructedUrl);

            $gridId = 'grid' . $report['id'];
            if ($report['is_primary']) {
                echo "initializeGrid1('$gridId', ".$jsUrl.");\n";
            } else {
                echo "initializeGrid('$gridId', ".$jsUrl.");\n";
            }
        }
        ?>
    });
</script>

<?php include "k_files/k_footer.php"; ?>
<script>
    $(document).ready(function () {
        $(".page-header h2").html("Dashboard");
        $(document).prop('title', 'Dashboard');
    });
</script>

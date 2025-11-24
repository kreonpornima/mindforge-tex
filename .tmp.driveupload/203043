<?php 
include_once('dbClass.php');

$ReportID = isset($ReportID) ? $ReportID : (isset($_GET['ReportID']) ? $_GET['ReportID'] : 0);
$TemplateID = (isset($_GET['TemplateID']) ? $_GET['TemplateID'] : 0);
$UserID = 'autoGen';
include 'reportModel.php';
$db[1] = "sp_GridReport_" . $ReportID;

$ResultStruct = array();
$EditableStruct = array();
$finalResult = array();
$finalKeys = array();
$filterString = "";
$separator = "|";
foreach($_REQUEST as $name => $value) {
    if($name != "ReportID" && $name != "view" && $name != "formid" && $name != "Submit" ) {
        // If it's a Username and value is a 10-digit mobile number
        if (strtolower($name) === 'username' && preg_match('/^\d{10}$/', $value)) {
            $value = 'u' . $value;
        }
        $filterString .= $name."=".$value.$separator;
    }
}

if($viewReportServerSettings[0]){

}else{ 
    if(strlen($db[1]) > 2){
        // echo "'".$filterString."'";
        $filterString = 'ssdt=2025-04-01|lldt=2025-07-23|company=17|division=1|username='.$UserID.'|';
        $SPresult = db::getInstance()->db_sp_select($db[1], array('@params','@table'), array("'".$filterString."'","'".$db[1]."'"));
        print_r($SPresult);
        // $ResultSet = $SPresult['result_set'][0];        //['result_set'][0] should have the data 
        // $ResultStruct = $SPresult['result_set'][1];     //['result_set'][1] should have the structure
        // $ResultCnt = isset($ResultSet) ? sizeof($ResultSet) : 0;
    }
}



$sql = 'select * from kreport_template_data where ID = 2409'; 
$sql = 'select * from kreport_template_data where ID = 2413'; 
$sql = 'select * from kreport_template_data where ID = ' . $TemplateID . '; --AND '; 
$results = db::getInstanceMaster()->db_select($sql);
// print_r($results);
$ReportJson = $results['result_set'][0]['ReportJson'] ?? '';
$template = json_decode($ReportJson, true); 

// Clean up unused node
unset($template['rowGroupExpansion']);

// Build grouped + grand total SQL
$table = '##u_gridreportdata_' . $UserID . '_' . $ReportID;
$queries = buildSqlFromAgGridTemplate($template, $table);
// print_r($queries); 
echo "-- Main Query:<br />" . $queries['grouped'] . "\n\n"; 
echo "<br />-- Grand Total Query:<br />" . $queries['grand'] . "\n";

 
function buildSqlFromAgGridTemplate(array $template, string $table): array {
    $groupCols = $template['rowGroup']['groupColIds'] ?? [];
    $aggregations = $template['aggregation']['aggregationModel'] ?? [];
    $filters = $template['filter']['filterModel'] ?? [];
    $pivotMode = $template['pivot']['pivotMode'] ?? false;
    $pivotCols = $template['pivot']['pivotColIds'] ?? [];
    $checkboxState = $template['checkboxState'] ?? [];

    $where = []; 
    $pivotValues = [];

    // Process filters into WHERE clause and pivot values
    foreach ($filters as $col => $filter) {
        switch ($filter['filterType']) {
            case 'multi':
                foreach ($filter['filterModels'] as $model) {
                    if ($model && $model['filterType'] === 'set') {
                        $vals = array_map(fn($v) => "'" . addslashes($v) . "'", $model['values']);
                        $where[] = "[$col] IN (" . implode(", ", $vals) . ")";
                        if (in_array($col, $pivotCols)) {
                            $pivotValues = array_merge($pivotValues, $model['values']);
                        }
                    }
                }
                break;
            case 'number':
                if ($filter['type'] === 'inRange') {
                    $where[] = "[$col] BETWEEN {$filter['filter']} AND {$filter['filterTo']}";
                } elseif ($filter['operator'] === 'AND') {
                    foreach ($filter['conditions'] as $cond) {
                        $type = $cond['type'];
                        $val = $cond['filter']; 
                        if ($type === 'greaterThan') $where[] = "[$col] > $val";
                        if ($type === 'lessThan') $where[] = "[$col] < $val";
                    }
                }
                break;
        }
    }

    $whereClause = $where ? implode(' AND ', $where) : '1=1';
    $groupBy = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrouped = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrand = [];

    // ✅ Fallback to dynamic pivot value fetch if pivot values are empty
    if ($pivotMode && $pivotCols) {
        $pivotCol = $pivotCols[0];
        if (empty($pivotValues)) {
            $sql = "SELECT DISTINCT [$pivotCol] FROM [$table] WHERE $whereClause";
            $res = db::getInstance()->db_select($sql);
            for ($j = 0; $j < sizeof($res['result_set']); $j++) {
                $pivotValues[] = $res['result_set'][$j][$pivotCol];
            } 
        }
    }

    // ➕ Build SELECT expressions for pivot columns and column-wise totals
    if ($pivotMode && $pivotCols && $pivotValues) {
        foreach ($pivotValues as $val) {
            foreach ($aggregations as $agg) {
                $field = $agg['colId'];
                $func = strtoupper($agg['aggFunc']);
                $pivotCol = $pivotCols[0];
                $label = ucwords($val) . " / " . ucfirst($func) . "(" . ucwords(str_replace('_', ' ', $field)) . ")";
                $selectGrouped[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS [$label]";
            }
        }

        // Add column-wise totals for pivot columns (summing across pivoted values)
        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func = strtoupper($agg['aggFunc']);
            // Column-wise total for the pivoted columns
            foreach ($pivotValues as $val) {
                $selectGrouped[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS total_{$val}_{$field}";
            }
            $selectGrand[] = "$func([$field]) AS total_{$field}";
        }
    } else {
        // If no pivot columns or pivot values, default to aggregating by group columns
        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func = strtoupper($agg['aggFunc']);
            $selectGrouped[] = "$func([$field]) AS total_{$field}";
            $selectGrand[] = "$func([$field]) AS total_{$field}";
        }
    }

    $queries = [];
  
    // Main grouped query
    $queries['grouped'] = "SELECT " . implode(", ", $selectGrouped) . "\nFROM [$table]\nWHERE $whereClause\n" . 
                          ($groupBy ? "GROUP BY " . implode(', ', $groupBy) : '');

    // Subtotals for row group levels (based on checkboxState)
    $queries['subtotals'] = [];
    foreach ($checkboxState as [$col, $include]) {
        if ($include) {
            $level = array_search($col, $groupCols);
            if ($level !== false && $level >= 0) {
                $partialGroup = array_slice($groupCols, 0, $level + 1);
                $selectPartial = array_map(fn($g) => "[$g]", $partialGroup);

                if ($pivotMode && $pivotCols && $pivotValues) {
                    foreach ($pivotValues as $val) {
                        foreach ($aggregations as $agg) {
                            $field = $agg['colId'];
                            $func = strtoupper($agg['aggFunc']);
                            $pivotCol = $pivotCols[0];
                            $label = ucwords($val) . " / " . ucfirst($func) . "(" . ucwords(str_replace('_', ' ', $field)) . ")";
                            $selectPartial[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS [$label]";
                        }
                    }
                    foreach ($aggregations as $agg) {
                        $field = $agg['colId']; 
                        $func = strtoupper($agg['aggFunc']);
                        $selectPartial[] = "$func([$field]) AS total_{$field}";
                    }
                } else { 
                    foreach ($aggregations as $agg) {
                        $field = $agg['colId'];
                        $func = strtoupper($agg['aggFunc']);
                        $selectPartial[] = "$func([$field]) AS total_{$field}";
                    }
                }

                $queries['subtotals'][$col] = "SELECT " . implode(", ", $selectPartial) . "\nFROM [$table]\nWHERE $whereClause\n" . 
                                              "GROUP BY " . implode(", ", array_map(fn($g) => "[$g]", $partialGroup));
            }
        }
    }

    // Grand total query
    $queries['grand'] = "SELECT " . implode(", ", $selectGrand) . "\nFROM [$table]\nWHERE $whereClause";

    return $queries;
}


/*function buildSqlFromAgGridTemplate1(array $template, string $table): array {
    $groupCols = $template['rowGroup']['groupColIds'] ?? [];
    $aggregations = $template['aggregation']['aggregationModel'] ?? [];
    $filters = $template['filter']['filterModel'] ?? [];
    $pivotMode = $template['pivot']['pivotMode'] ?? false;
    $pivotCols = $template['pivot']['pivotColIds'] ?? [];
    $checkboxState = $template['checkboxState'] ?? [];

    $where = [];
    $pivotValues = [];

    // Process filters into WHERE clause and pivot values
    foreach ($filters as $col => $filter) {
        switch ($filter['filterType']) {
            case 'multi':
                foreach ($filter['filterModels'] as $model) {
                    if ($model && $model['filterType'] === 'set') {
                        $vals = array_map(fn($v) => "'" . addslashes($v) . "'", $model['values']);
                        $where[] = "[$col] IN (" . implode(", ", $vals) . ")";
                        if (in_array($col, $pivotCols)) {
                            $pivotValues = array_merge($pivotValues, $model['values']);
                        }
                    }
                }
                break;
            case 'number':
                if ($filter['type'] === 'inRange') {
                    $where[] = "[$col] BETWEEN {$filter['filter']} AND {$filter['filterTo']}";
                } elseif ($filter['operator'] === 'AND') {
                    foreach ($filter['conditions'] as $cond) {
                        $type = $cond['type'];
                        $val = $cond['filter'];
                        if ($type === 'greaterThan') $where[] = "[$col] > $val";
                        if ($type === 'lessThan') $where[] = "[$col] < $val";
                    }
                }
                break;
        }
    }

    $whereClause = $where ? implode(' AND ', $where) : '1=1';
    $groupBy = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrouped = array_map(fn($col) => "[$col]", $groupCols);
    $selectGrand = [];

    if ($pivotMode && $pivotCols) {
        $pivotCol = $pivotCols[0];
        if (empty($pivotValues)) {
            $sql = "SELECT DISTINCT [$pivotCol] FROM [$table] WHERE $whereClause";
            $res = db::getInstance()->db_select($sql);
            //print_r($res);
            for ($j=0; $j<sizeof($res['result_set']); $j++) {
                $pivotValues[] = $res['result_set'][$j][$pivotCol];
            }
        }
    }

    // ➕ Build SELECT expressions for pivot columns
    // echo '<br />' . $pivotMode;
    // echo '<br />' ; print_r($pivotCols);
    // echo '<br />' ; print_r($pivotValues);
    if ($pivotMode && $pivotCols && $pivotValues) {
        foreach ($pivotValues as $val) {
            foreach ($aggregations as $agg) {
                $field = $agg['colId'];
                $func = strtoupper($agg['aggFunc']);
                $pivotCol = $pivotCols[0];
                $label = ucwords($val) . " / " . ucfirst($func) . "(" . ucwords(str_replace('_', ' ', $field)) . ")";
                $selectGrouped[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS [$label]";
            }
        }
        // Add row totals (for each aggregation)
        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func = strtoupper($agg['aggFunc']);
            $selectGrouped[] = "$func([$field]) AS total_{$field}";
            $selectGrand[] = "$func([$field]) AS total_{$field}";
        }
    } else {
        // If no pivot columns or pivot values, default to aggregating by group columns
        foreach ($aggregations as $agg) {
            $field = $agg['colId'];
            $func = strtoupper($agg['aggFunc']);
            $selectGrouped[] = "$func([$field]) AS total_{$field}";
            $selectGrand[] = "$func([$field]) AS total_{$field}";
        }
    }

    $queries = [];

    // Main grouped query
    $queries['grouped'] = "SELECT " . implode(", ", $selectGrouped) . "\nFROM [$table]\nWHERE $whereClause\n" . 
                          ($groupBy ? "GROUP BY " . implode(', ', $groupBy) : '');

    // Subtotals for row group levels (based on checkboxState)
    $queries['subtotals'] = [];
    foreach ($checkboxState as [$col, $include]) {
        if ($include) {
            $level = array_search($col, $groupCols);
            if ($level !== false && $level >= 0) {
                $partialGroup = array_slice($groupCols, 0, $level + 1);
                $selectPartial = array_map(fn($g) => "[$g]", $partialGroup);

                if ($pivotMode && $pivotCols && $pivotValues) {
                    foreach ($pivotValues as $val) {
                        foreach ($aggregations as $agg) {
                            $field = $agg['colId'];
                            $func = strtoupper($agg['aggFunc']);
                            $pivotCol = $pivotCols[0];
                            $label = ucwords($val) . " / " . ucfirst($func) . "(" . ucwords(str_replace('_', ' ', $field)) . ")";
                            $selectPartial[] = "$func(CASE WHEN [$pivotCol] = '" . addslashes($val) . "' THEN [$field] ELSE 0 END) AS [$label]";
                        }
                    }
                    foreach ($aggregations as $agg) {
                        $field = $agg['colId'];
                        $func = strtoupper($agg['aggFunc']);
                        $selectPartial[] = "$func([$field]) AS total_{$field}";
                    }
                } else {
                    foreach ($aggregations as $agg) {
                        $field = $agg['colId'];
                        $func = strtoupper($agg['aggFunc']);
                        $selectPartial[] = "$func([$field]) AS total_{$field}";
                    }
                }

                $queries['subtotals'][$col] = "SELECT " . implode(", ", $selectPartial) . "\nFROM [$table]\nWHERE $whereClause\n" . 
                                              "GROUP BY " . implode(", ", array_map(fn($g) => "[$g]", $partialGroup));
            }
        }
    }

    // Grand total query
    $queries['grand'] = "SELECT " . implode(", ", $selectGrand) . "\nFROM [$table]\nWHERE $whereClause";

    return $queries;
}
*/
?>
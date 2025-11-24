<?php
include_once('dbClass.php'); // Include your DB class
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'sync' && $_SESSION['group_id'] > 0) {
    try {
        // 🔧 Define table sync configurations
        $syncConfigs = [
            [
                'sourceTable' => 'users',
                'destinationTable' => 'users',
                'joinClause' => '',
                'whereClause' => "GroupID = (SELECT ac.GroupID FROM AiCompany ac WHERE ac.ID = {$_SESSION['dbCompany']}) OR users.Category=2",
                'fieldMapping' => [
                    'ID' => 'ID',
                    // 'ID' => 'ID',
                    'Username' => 'Username',
                    'Name' => 'Name'
                ],
                'columnDefinitions' => [
                    'ID' => 'INT',
                    // 'UserID' => 'INT',
                    'Username' => 'VARCHAR(255)',
                    'Name' => 'VARCHAR(255)'
                ]
            ],
            [
                'sourceTable' => 'kpageaccess',
                'destinationTable' => 'kpageaccess',
                'joinClause' => "
                    LEFT JOIN kmainforms ON kpageaccess.FormId = kmainforms.FormId
                ",
                'whereClause' => "
                    kpageaccess.FormId IN (
                        SELECT k.FormId
                        FROM kmainforms k
                        WHERE k.ProductCategoryID IN (
                            SELECT agpa.ProductCategoryID
                            FROM AiGroupProductAccess agpa
                            WHERE agpa.GroupID = (
                                SELECT ac.GroupID
                                FROM AiCompany ac
                                WHERE ac.ID = {$_SESSION['dbCompany']}
                            )
                            AND agpa.isActive <> 0
                        )
                    )
                ",
                'fieldMapping' => [
                    'kpageaccess.parentMenu' => 'parentMenu',
                    'kpageaccess.FormId' => 'FormId',
                    'kpageaccess.displayname' => 'displayname'
                ],
                'columnDefinitions' => [
                    'parentMenu' => 'INT',
                    'FormId' => 'INT',
                    'displayname' => 'VARCHAR(255)'
                ]
            ],
            [
                'sourceTable' => 'kmainforms',
                'destinationTable' => 'kmainforms',
                'joinClause' => '',
                'whereClause' => "kmainforms.ProductCategoryID IN (
                    SELECT agpa.ProductCategoryID
                    FROM AiGroupProductAccess agpa
                    WHERE agpa.GroupID = (
                        SELECT ac.GroupID
                        FROM AiCompany ac
                        WHERE ac.ID = {$_SESSION['dbCompany']}
                    )
                    AND agpa.isActive <> 0)",
                'fieldMapping' => [
                    'FormId' => 'FormId',
                    'FormName' => 'FormName',
                    'TableName' => 'TableName',
                    'formtype' => 'formtype',
                    'formcode' => 'formcode',
                    'credit' => 'credit',
                    'debit' => 'debit',
                    'OLDID' => 'OLDID'
                    ],
                'columnDefinitions' => [
                    'FormId' => 'INT',
                    'FormName' => 'VARCHAR(255)',
                    'TableName' => 'VARCHAR(255)',
                    'formtype' => 'VARCHAR(255)',
                    'formcode' => 'VARCHAR(255)',
                    'credit' => 'VARCHAR(255)',
                    'debit' => 'VARCHAR(255)',
                    'OLDID' => 'BIGINT'
                    ]
            ],
            [
                'sourceTable' => 'kmaingrid',
                'destinationTable' => 'kmaingrid',
                'joinClause' => "LEFT JOIN kmainfields ON kmaingrid.GridId=kmainfields.GridId
                    LEFT JOIN kmainforms ON kmainfields.FormId=kmainforms.FormId
                        WHERE kmainforms.ProductCategoryID IN (
                            SELECT agpa.ProductCategoryID
                            FROM AiGroupProductAccess agpa
                            WHERE agpa.GroupID = (
                                SELECT ac.GroupID
                                FROM AiCompany ac
                                WHERE ac.ID = {$_SESSION['dbCompany']}
                            )
                            AND agpa.isActive <> 0
                        ) GROUP BY kmaingrid.GridId, kmaingrid.GridName, kmaingrid.GridTitle, kmaingrid.TableName ",
                'whereClause' => "",
                'fieldMapping' => [
                    'kmaingrid.GridId' => 'GridId',
                    'kmaingrid.GridName' => 'GridName',
                    'kmaingrid.GridTitle' => 'GridTitle',
                    'kmaingrid.TableName' => 'TableName',
                    // 'kmaingrid.TablePrimaryKey' => 'TablePrimaryKey',
                    // 'kmaingrid.TableUnique' => 'TableUnique'
                ],
                'columnDefinitions' => [
                    'GridId' => 'INT',
                    'GridName' => 'VARCHAR(255)',
                    'GridTitle' => 'VARCHAR(255)',
                    'TableName' => 'VARCHAR(255)',
                    // 'TablePrimaryKey' => 'VARCHAR(255)',
                    // 'TableUnique' => 'VARCHAR(255)'
                ]
            ],
            [
                'sourceTable' => 'kmainfields',
                'destinationTable' => 'kmainfields',
                'joinClause' => "
                    LEFT JOIN kmainforms ON kmainfields.FormId=kmainforms.FormId
                    WHERE kmainforms.ProductCategoryID IN (
                        SELECT agpa.ProductCategoryID
                        FROM AiGroupProductAccess agpa
                        WHERE agpa.GroupID = (
                            SELECT ac.GroupID
                            FROM AiCompany ac
                            WHERE ac.ID = {$_SESSION['dbCompany']}
                        )
                        AND agpa.isActive <> 0
                    )
                ",
                'whereClause' => "",
                'fieldMapping' => [
                    'kmainfields.main_id' => 'main_id',
                    'kmainfields.FormId' => 'FormId',
                    'kmainfields.DbFieldName' => 'DbFieldName',
                    'kmainfields.FieldType' => 'FieldType',
                    'kmainfields.DisplayName' => 'DisplayName',
                    'kmainfields.Visibility' => 'Visibility',
                    'kmainfields.TabIndex' => 'TabIndex',
                    // 'kmainfields.ValueFromDb' => 'ValueFromDb',
                    'kmainfields.TableFromDb' => 'TableFromDb',
                    // 'kmainfields.TablePrimary' => 'TablePrimary', 
                    // 'kmainfields.TableLabel' => 'TableLabel', 
                    // 'kmainfields.TableCondition' => 'TableCondition',
                    // 'kmainfields.TableMapTable' => 'TableMapTable',
                    // 'kmainfields.TableMapPrimary' => 'TableMapPrimary', 
                    // 'kmainfields.TableMapOtherKey' => 'TableMapOtherKey', 
                    'kmainfields.GridId' => 'GridId', 
                    'kmainfields.MDRelationTable' => 'MDRelationTable', 
                    // 'kmainfields.MDPrimary' => 'MDPrimary',
                    // 'kmainfields.MDLabel' => 'MDLabel',
                    'kmainfields.DisplayOrder' => 'DisplayOrder'
                ],
                'columnDefinitions' => [
                    'main_id' => 'INT',
                    'FormId' => 'INT',
                    'DbFieldName' => 'VARCHAR(255)',
                    'FieldType' => 'VARCHAR(255)',
                    'DisplayName' => 'VARCHAR(255)',
                    'Visibility' => 'SMALLINT',
                    'TabIndex' => 'INT',
                    // 'ValueFromDb' => 'VARCHAR(255)',
                    'TableFromDb' => 'VARCHAR(255)',
                    // 'TablePrimary' => 'VARCHAR(255)', 
                    // 'TableLabel' => 'VARCHAR(255)', 
                    // 'TableCondition' => 'VARCHAR(255)',
                    // 'TableMapTable' => 'VARCHAR(255)',
                    // 'TableMapPrimary' => 'VARCHAR(255)', 
                    // 'TableMapOtherKey' => 'VARCHAR(255)', 
                    'GridId' => 'INT', 
                    'MDRelationTable' => 'VARCHAR(255)', 
                    // 'MDPrimary' => 'VARCHAR(255)',
                    // 'MDLabel' => 'VARCHAR(255)',
                    'DisplayOrder' => 'INT'
                ]
            ],
            [
                'sourceTable' => 'kgridfields',
                'destinationTable' => 'kgridfields',
                'joinClause' => "LEFT JOIN kmaingrid ON kgridfields.GridId=kmaingrid.GridId
                        LEFT JOIN kmainfields ON kmaingrid.GridId=kmainfields.GridId
                        LEFT JOIN kmainforms ON kmainfields.FormId=kmainforms.FormId
                        WHERE kmainforms.ProductCategoryID IN (
                            SELECT agpa.ProductCategoryID
                            FROM AiGroupProductAccess agpa
                            WHERE agpa.GroupID = (
                                SELECT ac.GroupID
                                FROM AiCompany ac
                                WHERE ac.ID = {$_SESSION['dbCompany']}
                            )
                            AND agpa.isActive <> 0
                        ) GROUP BY kgridfields.GridFieldId, kgridfields.GridId, kgridfields.DbFieldName, 
                            kgridfields.FieldType, kgridfields.DisplayName, kgridfields.Visibility, kgridfields.DisplayOrder, kgridfields.TableFromDb ",
                'whereClause' => "",
                'fieldMapping' => [
                    'kgridfields.GridFieldId' => 'GridFieldId',
                    'kgridfields.GridId' => 'GridId',
                    'kgridfields.DbFieldName' => 'DbFieldName',
                    'kgridfields.FieldType' => 'FieldType',
                    'kgridfields.DisplayName' => 'DisplayName',
                    'kgridfields.Visibility' => 'Visibility',
                    // 'kgridfields.ValueFromDb' => 'ValueFromDb',
                    'kgridfields.TableFromDb' => 'TableFromDb',
                    // 'kgridfields.TablePrimary' => 'TablePrimary', 
                    // 'kgridfields.TableLabel' => 'TableLabel', 
                    'kgridfields.DisplayOrder' => 'DisplayOrder',
                    // 'kgridfields.SqlQueryOnInsert' => 'SqlQueryOnInsert'
                ],
                'columnDefinitions' => [
                    'GridFieldId' => 'INT',
                    'GridId' => 'INT',
                    'DbFieldName' => 'VARCHAR(255)',
                    'FieldType' => 'VARCHAR(255)',
                    'DisplayName' => 'VARCHAR(255)',
                    // 'ValueFromDb' => 'varchar(255)',
                    'TableFromDb' => 'VARCHAR(255)',
                    // 'TablePrimary' => 'VARCHAR(255)', 
                    // 'TableLabel' => 'VARCHAR(255)', 
                    'Visibility' => 'INT',
                    'DisplayOrder' => 'INT',
                    // 'SqlQueryOnInsert' => 'VARCHAR(500)'
                ]
            ]
            ,
            [
                'sourceTable' => 'Aireg',
                'destinationTable' => 'Aireg',
                'joinClause' => " LEFT JOIN AiCompany ON Aireg.CompanyID = AiCompany.ID 
                            WHERE AiCompany.GroupID =  {$_SESSION['group_id']}",
                'whereClause' => "",
                'fieldMapping' => [ // aireg.ID, aireg.CompanyID, aireg.DivisionID, Year, Database_name
                    'Aireg.ID' => 'ID',
                    'Aireg.CompanyID' => 'CompanyID',
                    'Aireg.DivisionID' => 'DivisionID',
                    'Aireg.Year' => 'Year',
                    'Aireg.Database_name' => 'Database_name',
                ],
                'columnDefinitions' => [
                    'ID' => 'INT',
                    'CompanyID' => 'INT',
                    'DivisionID' => 'INT',
                    'Year' => 'VARCHAR(255)',
                    'Database_name' => 'VARCHAR(255)',
                ]
            ]

            
            // ➕ Add more table configs here...
        ];

        foreach ($syncConfigs as $config) {
            syncTable($config);
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}


/**
 * 🔁 Sync a table from source DB to destination DB
 */
// function syncTable($config) {
//     // return null;
//     $sourceTable = $config['sourceTable'];
//     $destinationTable = $config['destinationTable'];
//     $whereClause = $config['whereClause'] ?? '';
//     $joinClause = $config['joinClause'] ?? '';
//     $fieldMapping = $config['fieldMapping'];
//     $columnDefinitions = $config['columnDefinitions'];
//     $errors = [];
//     $messages = [];


//     // ✅ Step 1: Build SELECT from source
//     $selectCols = implode(", ", array_keys($fieldMapping));
//     $sql = "SELECT $selectCols FROM $sourceTable";

//     if (!empty($config['joinClause'])) {
//         $sql .= " " . $config['joinClause'];
//     }

//     if (!empty($whereClause)) {
//         $sql .= " WHERE $whereClause";
//     }

//     // echo "<br>".$sql."<br>";
//     // exit();
   
//     $data = db::getInstanceMaster()->db_select($sql);

//     if (!$data || !isset($data['result_set'])) {
//         echo "❌ Failed to select data from `$sourceTable`. Check query or connection.<br>";
//         return;
//     }

//     if (empty($data['result_set'])) {
//         echo "⚠ No data to sync from `$sourceTable`.<br>";
//         return;
//     }

//     $rows = $data['result_set'];

//     // ✅ Step 3: Drop destination table before inserting new data
//     $dropSql = "DROP TABLE $destinationTable";
//     $result = db::getInstance()->db_insertQuery($dropSql);
//     // print_r($result);

//     if ($result['error'] == 1) {
//         http_response_code(500);
//         echo "❌ Failed to drop table `$destinationTable`.".$result['error_statement']."<br>";
//         return;
//     }

//     // if (!db::getInstance()->db_insertQuery($dropSql)) {
//     //     echo "❌ Failed to drop table `$destinationTable`.<br>";
//     //     return;
//     // }
//     echo "🧹 drop `$destinationTable` before insert.<br>";

//     // ✅ Step 2: Check if destination table exists
//     $checkTableSql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$destinationTable'";
//     $tableExists = db::getInstance()->db_select($checkTableSql);

//     if (empty($tableExists['result_set'])) {
//         // $cols = ["ID INT IDENTITY(1,1) PRIMARY KEY"]; // Auto ID
//         foreach ($columnDefinitions as $col => $type) {
//             $cols[] = "$col $type";
//         }
//         $createSql = "CREATE TABLE $destinationTable (" . implode(", ", $cols) . ")";

//         db::getInstance()->db_insertQuery($createSql);
//         echo "✅ Created table `$destinationTable`.<br>";
//     }

    

//     // // ✅ Step 3: Truncate destination table before inserting new data
//     // $truncateSql = "TRUNCATE TABLE $destinationTable";
//     // db::getInstance()->db_insertQuery($truncateSql);
//     // echo "🧹 Truncated `$destinationTable` before insert.<br>";

//     // ✅ Step 3: Insert data
//     $inserted = 0;


//     $fields = [];
//     $allValues = [];

//     foreach ($rows as $row) {
//         $rowValues = [];

//         foreach ($fieldMapping as $src => $dest) {
//             // Set field names once
//             if (!in_array($dest, $fields)) {
//                 $fields[] = $dest;
//             }

//             // Extract actual column name (remove alias/table prefix)
//             $srcField = (strrpos($src, '.') !== false) ? substr($src, strrpos($src, '.') + 1) : $src;

//             $val = db::getInstance()-> real_escape_string($row[$srcField]); //addslashes($row[$srcField]);

//             // Determine if the column is a string type from columnDefinitions
//             $colType = strtoupper($columnDefinitions[$dest]);

//             $isStringType = (
//                 strpos($colType, 'CHAR') !== false ||
//                 strpos($colType, 'TEXT') !== false ||
//                 strpos($colType, 'DATE') !== false || // For DATE/TIMESTAMP types
//                 strpos($colType, 'TIME') !== false
//             );

//             if ($val === null || $val === '') {
//                 $rowValues[] = "NULL";
//             } else {
//                 $rowValues[] = $isStringType ? "'$val'" : $val;
//             }
//         }

//         $allValues[] = "(" . implode(",", $rowValues) . ")";
//     }

//     // print_r($fields);
//     // exit();

//     // Now build and run one big insert
//     if (!empty($allValues)) {
//         $insertSql = "INSERT INTO $destinationTable (" . implode(',', $fields) . ") VALUES " . implode(",\n", $allValues) . ";";
//         if (!db::getInstance()->db_insertQuery($insertSql)) {
//             echo "❌ Failed to insert data into `$destinationTable`.<br>";
//             return;
//         }
//         echo "✅ Inserted " . count($rows) . " row(s) into `$destinationTable`.<br>";
//     }
// }

function syncTable($config) {
    $sourceTable = $config['sourceTable'];
    $destinationTable = $config['destinationTable'];
    $whereClause = $config['whereClause'] ?? '';
    $joinClause = $config['joinClause'] ?? '';
    $fieldMapping = $config['fieldMapping'];
    $columnDefinitions = $config['columnDefinitions'];

    $errors = [];
    $messages = [];

    // Step 1: Build SELECT query
    $selectCols = implode(", ", array_keys($fieldMapping));
    $sql = "SELECT $selectCols FROM $sourceTable";

    if (!empty($joinClause)) {
        $sql .= " $joinClause";
    }

    if (!empty($whereClause)) {
        $sql .= " WHERE $whereClause";
    }


    $data = db::getInstanceMaster()->db_select($sql);

    if (!$data || !isset($data['result_set'])) {
        $errors[] = "❌ Failed to select data from `$sourceTable`. Check query or connection.";
    } elseif (empty($data['result_set'])) {
        $messages[] = "⚠ No data to sync from `$sourceTable`.";
    } else {
        $rows = $data['result_set'];

        // Drop destination table
        // $dropSql = "DROP TABLE $destinationTable";
        $dropSql = "IF OBJECT_ID('dbo.$destinationTable', 'U') IS NOT NULL DROP TABLE dbo.$destinationTable;";
        $dropResult = db::getInstance()->db_insertQuery($dropSql);

        if (isset($dropResult['error']) && $dropResult['error'] == 1) {
            $errors[] = "❌ Failed to drop table `$destinationTable`.\n" . $dropResult['error_statement'];
        } else {
            $messages[] = "🧹 Dropped `$destinationTable` before insert.";

            // Check if table exists (it won’t)
            $checkTableSql = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$destinationTable'";
            $tableExists = db::getInstance()->db_select($checkTableSql);

            if (empty($tableExists['result_set'])) {
                $cols = [];
                foreach ($columnDefinitions as $col => $type) {
                    $cols[] = "$col $type";
                }
                $createSql = "CREATE TABLE $destinationTable (" . implode(", ", $cols) . ")";
                $createResult = db::getInstance()->db_insertQuery($createSql);

                if (isset($createResult['error']) && $createResult['error'] == 1) {
                    $errors[] = "❌ Failed to create table `$destinationTable`.\n" . $createResult['error_statement'];
                } else {
                    $messages[] = "✅ Created table `$destinationTable`.";
                }
            }

            // Insert data
            $fields = [];
            $allValues = [];

            foreach ($rows as $row) {
                $rowValues = [];
                foreach ($fieldMapping as $src => $dest) {
                    if (!in_array($dest, $fields)) {
                        $fields[] = $dest;
                    }

                    $srcField = (strrpos($src, '.') !== false) ? substr($src, strrpos($src, '.') + 1) : $src;
                    $val = db::getInstance()->real_escape_string($row[$srcField]);
                    $colType = strtoupper($columnDefinitions[$dest]);

                    $isStringType = (
                        strpos($colType, 'CHAR') !== false ||
                        strpos($colType, 'TEXT') !== false ||
                        strpos($colType, 'DATE') !== false ||
                        strpos($colType, 'TIME') !== false
                    );

                    $rowValues[] = ($val === null || $val === '') ? "NULL" : ($isStringType ? "'$val'" : $val);
                }
                $allValues[] = "(" . implode(",", $rowValues) . ")";
            }

            if (!empty($allValues)) {

                $batchSize = 500;
                $totalRows = count($allValues);
                $batches = array_chunk($allValues, $batchSize);

                foreach ($batches as $batchIndex => $batchValues) {
                    $insertSql = "INSERT INTO $destinationTable (" . implode(',', $fields) . ") VALUES " . implode(",\n", $batchValues) . ";";
                    $insertResult = db::getInstance()->db_insertQuery($insertSql);

                    if (isset($insertResult['error']) && $insertResult['error'] == 1) {
                        $errors[] = "❌ Failed to insert batch #" . ($batchIndex + 1) . " into `$destinationTable`.\n" . $insertResult['error_statement'];
                        break; // optional: stop on first failure
                    } else {
                        $messages[] = "✅ Inserted batch #" . ($batchIndex + 1) . " (" . count($batchValues) . " row(s)) into `$destinationTable`. \n";
                    }
                }
            }

            
        }
    }

    // Final response: only show error if exists
    if (!empty($errors)) {
        http_response_code(500);
        echo implode("\n", $errors);
    } else {
        echo implode("\n", $messages);
    }
}

?>


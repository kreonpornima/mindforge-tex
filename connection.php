<?php

$serverName = "localhost,4545";
$database = "Main";
$uid = "sa";
$pass = "Erp@123";

$connection = [
    "Database" => $database,
    "uid" => $uid,
    "pwd" => $pass
];

//phpinfo();

//echo "<pre>";
//print_r(PDO::getAvailableDrivers());

$conn = sqlsrv_connect($serverName, $connection);
if(!$conn)
    die(print_r(sqlsrv_errors(), true));
    
//1st Method
$tsql = "EXEC SelectAllKmainforms @ProductCategoryID = 1,@ModuleType = 4";
$stmt = sqlsrv_query( $conn, $tsql);  


//2nd method
// $ModuleType = '4';
// $ProductCategoryID = '1';

// $params = array(
//     array($ProductCategoryID, SQLSRV_PARAM_IN),
//     array($ModuleType, SQLSRV_PARAM_IN)

// );
// $SQL = "{CALL SelectAllKmainforms(?, ?)}";
// $stmt = sqlsrv_query($conn, $SQL, $params);



if ( $stmt )  
{  
     while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<pre></pre>";
        print_r($row);
        
    }
}   
else   
{  
     echo "Error in statement execution.\n";  
     die( print_r( sqlsrv_errors(), true));  
}  

// map_purchaseinward_products

// purchaseinward

?>
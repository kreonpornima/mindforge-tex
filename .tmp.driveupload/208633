<?php
function setClientRegisterID($RegID, $user_id, $ModuleID){
    //ALSO CHECK IF USER HAS ACCESS TO THE COMPANY
    $query = "SELECT CONCAT(AiCompany.Label,' - ', AiDivision.Label, ' - ', AiReg.Year) as Name, Aireg.CompanyID, Aireg.DivisionID, Aireg.Year, Aireg.Database_name, Aireg.Ip, Aireg.Port, Aireg.Sql_User_Id, 
    Aireg.Decrypted_Password, AiCompany.GroupID, Aireg.dtbases, Aireg.ID as RegID
    from Aireg 
    LEFT JOIN AiCompany ON AiReg.CompanyID = AiCompany.ID 
    LEFT JOIN AiGroup ON AiCompany.GroupID = AiGroup.ID
    LEFT JOIN AiDivision ON AiReg.DivisionID = AiDivision.ID
    where Aireg.ID='".$RegID."' ";
    $result = db::getInstanceMaster()->db_select($query);
    // print_r($result);
    $row = $result['result_set'];
    if(sizeof($row) > 0){
        for($i = 0; $i < count($row); $i++){
            $_SESSION['RegID'] = $row[$i]['RegID'];
            $_SESSION['dbCompanyName'] = $row[$i]['Name'];
            $_SESSION['dbHost'] = $row[$i]['Ip'].','.$row[$i]['Port'];
            $_SESSION['dbUser'] = $row[$i]['Sql_User_Id'];
            $_SESSION['dbPass'] = $row[$i]['Decrypted_Password'];
            $_SESSION['dbName'] = $row[$i]['Database_name'];
            $_SESSION['dbCompany'] = $row[$i]['CompanyID'];
            $_SESSION['dbDivision'] = $row[$i]['DivisionID'];
            if($_SESSION['Category'] == 2)
                $_SESSION['group_id'] = $row[$i]['GroupID'];
            
            $_SESSION['dbYear'] = $row[$i]['Year']; //only used at dbMySQL. To be removed.
            $_SESSION['dbYearID'] = $yearID;    //Doesn't have Year Code ID. Please Add it
        }
    }
    // print_r($_SESSION);
}
?>
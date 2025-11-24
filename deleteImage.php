<?php 
    require_once ('dbClass.php');

    $formID = isset($_POST['fid']) ? $_POST['fid'] : 0;
    $fieldType = isset($_POST['fieldType']) ? $_POST['fieldType'] : 0;
    $fieldName = isset($_POST['fieldName']) ? $_POST['fieldName'] : null;
    $mediaID = isset($_POST['mediaID']) ? $_POST['mediaID'] : 0;

    // exit();

    if($formID == 0 || $fieldType == 0 ||  $fieldName == NULL){ //$mediaID == 0 ||
        $response["error"] = true;
        $response["error_msg"] = "Error Processing your Request. Please try again.";
    }else{
       $sql = "SELECT OtherAttributes, ValueFromDb, TableMapTable, TableMapPrimary, TableMapOtherKey, TableName, TablePrimaryKey 
                FROM kmainfields 
                LEFT JOIN kmainforms ON kmainfields.FormId = kmainforms.FormId
                WHERE kmainfields.FormId = " . $formID . " AND DbFieldName LIKE '" . $fieldName ."'" ;
        $result = db::getInstanceMaster()->db_select($sql);
        // print_r($result['num_rows'] );
        if($result['num_rows'] > 0){
            $row = $result['result_set'][0];
            $FormTable = $row["TableName"];
            $FormTablePK = $row["TablePrimaryKey"];
            $MapTable = $row["TableMapTable"];
            $MapTablePK = $row["TableMapPrimary"];
            $MapTableOtherKey = $row["TableMapOtherKey"];
            
            if($fieldType == 12){ //direct delete from table
                $sql = "UPDATE " . $FormTable . " SET  " . $fieldName . " =  0 WHERE " . $fieldName . " = " . $mediaID . "";
                $result = db::getInstance()->db_update($sql);
                $sql = "UPDATE kmainmedia SET isDeleted = 1 WHERE MediaId = " . $mediaID . "";
                $result = db::getInstance()->db_update($sql);
                $response["error"] = false;
                $response["data"] = "Image Deleted Successfully.";
            } 
            if($fieldType == 13){ //Find mapping table and then delete from table
                $sql = "DELETE FROM " . $MapTable . " WHERE " . $MapTableOtherKey . " = " . $mediaID . "";
                $result = db::getInstance()->db_update($sql);
                $sql = "UPDATE kmainmedia SET isDeleted = 1 WHERE MediaId = " . $mediaID . "";
                $result = db::getInstance()->db_update($sql);
                $response["error"] = false;
                $response["data"] = "Image Deleted Successfully.";
            }
        }else{
            $response["error"] = true;
            $response["error_msg"] = "Error while deleting the image. Please try again.";
        }
    }

    echo json_encode($response);

?>
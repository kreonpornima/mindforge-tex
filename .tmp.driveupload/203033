<?php
session_start();
include_once("dbClass.php");

// Assuming you are using a simple PHP backend, you can modify it to fit your security needs (e.g., password hashing).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    // Check if the passwords match
    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    // Password strength check
    $passwordStrengthRegex = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$()=+{<>}#^!%*?&]{8,20}$/';
    if (!preg_match($passwordStrengthRegex, $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Password is too weak.']);
        exit;
    }

    // Hash the password before storing it (important for security)
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in the database (Example query, adjust based on your setup)
    // Assume $db is your database connection
    $sql = "UPDATE users SET password='$newPassword' WHERE ID={$_SESSION['user_id']}";
    db::getInstanceMaster()->db_insertQuery($sql);
    // $stmt = $db->prepare("UPDATE users SET password = ? WHERE user_id = ?");
    // $stmt->bind_param("si", $hashedPassword, $userId);
    // $stmt->execute();

    // Simulate a success response (replace with actual database logic)
    echo json_encode(['success' => true, 'message' => 'Password changed successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
exit;












$k_debug = 0;

if($k_debug) echo "<br />" . print_r($_POST);
//exit();

$role = isset($_POST['Label']) ? $_POST['Label'] : 0;
$editID = isset($_POST['editID']) ? $_POST['editID'] : 0;
$regID = isset($_POST['regId']) ? $_POST['regId'] : 0;


if((int)$editID > 0){
  
    $sql = "UPDATE pagerolemaster SET Label = '" . $role . "' WHERE RoleId = " . $editID;
    $result = db::getInstanceMaster()->db_update($sql);
    // exit();
    $sql = "Delete from pageroleaccess where RoleID = " . $editID;
    $result = db::getInstanceMaster()->db_update($sql);
    $roleID = $editID;
}else{
   
    $sql ="INSERT into pagerolemaster (Label) VALUES ('".$role."')";
    $result = db::getInstanceMaster()->db_insertQuery($sql);
    $roleID = $result['last_id'];
    // exit();
}
if($k_debug) echo "<br />" . $sql; 
if($k_debug) echo "<br />" . print_r($result);

    $queryVals = "INSERT INTO pageroleaccess (RoleID, PageAccessID, AddBtn,EditBtn,ListView,OtherBtn, DeleteBtn) 
    							VALUES ";
    $separator = "";
    for($i = 0; $i < $_POST['totalPages']; $i++){
    	$queryVals .= $separator . "(" . $roleID . ", " . $_POST['accessId'][$i][0] . ", ";
    	if(isset($_POST['add'][$i][0])){  $queryVals .=  ($_POST['add'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=   "0" . ", ";}
    	if(isset($_POST['edit'][$i][0])){ $queryVals .=  ($_POST['edit'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	if(isset($_POST['listview'][$i][0])){ $queryVals .=  ($_POST['listview'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	if(isset($_POST['other'][$i][0])){ $queryVals .=  ($_POST['other'][$i][0] == "on" ? 1 : 0) . ", "; }else{ $queryVals .=  "0" . ", ";}
    	if(isset($_POST['delete'][$i][0])){ $queryVals .=  ($_POST['delete'][$i][0] == "on" ? 1 : 0) . ""; }else{ $queryVals .=  "0" . "";}
    	$queryVals .= ")";
    	$separator = ", ";
    }
    if($k_debug) echo "<br />" . $queryVals;
    $result = db::getInstanceMaster()->db_insertQuery($queryVals);
    if($k_debug) echo "<br />" . print_r($result);
    

    if($regID){
        if($editID > 0){
            $roleID = $editID;
        }
        $sql1 = "select * from CompanyRoleAccess where RoleID = '".$roleID."' ";
        $result1 = db::getInstanceMaster()->db_insertQuery($sql1);
        if($result1){
            $sql2 = "DELETE from CompanyRoleAccess where RoleID = '".$roleID."' ";
            $result2 = db::getInstanceMaster()->db_insertQuery($sql2);
        }
        for($j=0; $j<sizeof($regID); $j++){
            $sql3 ="INSERT into CompanyRoleAccess (RoleID,RegID) VALUES ('".$roleID."','".$regID[$j]."')";
            $result = db::getInstanceMaster()->db_insertQuery($sql3);   
        }
    }
    // exit();
// echo '<script>alert("data sent successfully");</script>';

if($k_debug) exit();
// if($k_debug) echo "<br />" . print_r($result);
echo '<script>window.location="roles.php";</script>';
?>	
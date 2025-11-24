<?php
define ('SITE_ROOT', ""); //added on 18 01 2021

header("X-Frame-Options: SAMEORIGIN");
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header_remove("X-Powered-By");

        // echo "=> " . print_r($_SERVER); exit();
        header("Access-Control-Allow-Origin: https://capapi.kreonsolutions.in/");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1200');    // cache for 20mins
        // header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST');
        // header("Access-Control-Allow-Headers: X-Requested-With");        
        // header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

$k_debug = 0;
session_start();

class db extends mysqli {
	// single instance of self shared among all instances
	private static $instance = null;
	private $env = 1; //0 = Localhost; 1 = Live Server
	private $user = "root";
	private $pass = "";
	private $dbName = "klabs_kframe";
	private $dbHost = "localhost";
	
	// db connection config vars
	private $user1 = "kreoninprimary_krdemoadmin";
	private $pass1 = "Cjo%Oq&%!zea";
	private $dbName1 = "kreoninprimary_krdemo";
	private $dbHost1 = "localhost";
	private $dbDebug = 0;
	
	//This method must be static, and must return an instance of the object if the object does not already exist.
	public static function getInstance() {
		if (!self::$instance instanceof self) {	
			self::$instance = new self(0);	//0 added for MASTER 
		}
		return self::$instance;
	}
	//This method must be static, and must return an instance of the object if the object does not already exist.
	public static function getInstanceClient() {
		if (!self::$instance instanceof self) {	
			self::$instance = new self(1);	//1 added for Client 
		}
		return self::$instance;
	}
	// The clone and wakeup methods prevents external instantiation of copies of the Singleton class, thus eliminating the possibility of duplicate objects.
	public function __clone() {
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
	
	public function __wakeup() {
		trigger_error('De-serializing is not allowed.', E_USER_ERROR);
	}
	
	function __destruct() {
        ob_end_flush();
		//print "Destroying " . __CLASS__ . "\n";
		//parent::__destruct();
    }
	
	public function __construct($dbType) {
		//$dbType => 0 for Master, 1 for Client
		if($dbType == 0){
			if($this->env == 1){
				parent::__construct($this->dbHost1, $this->user1, $this->pass1, $this->dbName1);
				parent::set_charset('utf8');
			}else{			
				parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
				parent::set_charset('utf-8');
			}
		}
		if($dbType == 1){
			parent::__construct($_SESSION['dbHost'], $_SESSION['dbUser'], $_SESSION['dbPass'], $_SESSION['dbName']);
			parent::set_charset('utf8');
		}
		if (mysqli_connect_error()) {
			exit('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
		}
	}
	
	public function query_valid($query){
		if($this->query($query)){
			return true;
		}
	} 
	
	public function get_result($query) {
		$result = $this->query($query);
		if ($result->num_rows > 0){
			//$row = $result->fetch_assoc();
			return $result;
		}else{
			return null;
		}
	}
	//SELECT Fn
	public function db_select($query) { ///returns "result_set, error, error_statement, num_rows
		$output = array();
		$output['result_set'] = array();
		$output['error'] = "1";
		// echo $query;				
		//$this->set_charset("utf-8");
		$output['error_statement'] = "";
		if ($result = $this->query($query)) {
			$output['error'] = "0";
			$output['num_rows'] = $result->num_rows;
			while($row = $result->fetch_assoc()){
				$output['result_set'][] = $row;
			}
			$result->free();
		} else {
			$output['error_statement'] = "Error: " . $this->error;
		}
		// print_r($output);
		return $output;
	}
	//UPDATE Fn
	public function db_update($query) { ///SAME for DELETE & UPDATE
		$output = array();
		$output['error'] = "1";
		$output['error_statement'] = "";
		if ($this->query($query)) {
			$output['error'] = "0";
			$output['num_rows'] = $this->affected_rows;
		} else {
			$output['error_statement'] = "Error: " . $this->error;
		}
		return $output;
	}
	//INSERT Fn
	public function db_insert($table, $set, $val) { ///returns should have at least 1 set & set==val
		$output = array();
		$output['error'] = "1";
		$output['error_statement'] = "";
		if(!(strlen($table) > 0 && sizeof($set) > 0 && sizeof($set) == sizeof($val))){
			$output['error_statement'] = "Invalid Arguments";
			return $output;
		}
		$s1 = "INSERT INTO ".$table." ("; 
		$s2 = " ";
		$separator = "";
		for($i = 0; $i < sizeof($set); $i++){
			$s1 .= $separator . $set[$i];
			$s2 .= $separator . "'" . mysqli_real_escape_string($this, $val[$i]) . "'";
			$separator = ",";
		}
		$sql = $s1 . " ) Values( " . $s2 . ")";
	//	echo $sql;
		//exit();
		if ($result = $this->query($sql)) {
			$output['error'] = "0";
			$output['last_id'] = $this->insert_id; //returns 0 if PK not set/AI
		} else {
			$output['error'] = "1";
			$output['error_statement'] = "Error: " . $this->error;
		}
	//	print_r($output);
		return $output;
	}
	
	//INSERT Fn with Query
	public function db_insertQuery($query) {  //returns should have at least 1 set
		// echo $query;
		$sql = $query;
		$output = array();
		$output['error'] = "1";
		$output['error_statement'] = "";
		// echo $query;exit();
		if(!(strlen($query) > 0)){
			$output['error_statement'] = "Invalid Arguments";
			return $output;
		}
		//$s1 = "INSERT INTO ".$table." ("; 
		//$s2 = " ";
		//$separator = "";
		//for($i = 0; $i < sizeof($set); $i++){
		//	$s1 .= $separator . $set[$i];
		//	$s2 .= $separator . "'" . mysqli_real_escape_string($this, $val[$i]) . "'";
		//	$separator = ",";
		//}
		//$sql = $s1 . " ) Values( " . $s2 . ")";
		// echo $query;exit();
		if ($result = $this->query($sql)) {
			$output['error'] = "0";
			$output['last_id'] = $this->insert_id; //returns 0 if PK not set/AI
		} else {
			$output['error'] = "1";
			$output['error_statement'] = "Error: " . $this->error;
		}
		return $output;
	}	
}
?>
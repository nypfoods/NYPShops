<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}

function addtoUser($id) {
	global $db,$ldb;
	$sql = "REPLACE INTO  `users`(`uid`,`uname`,`epwd`,`fname`,`lname`,`mname`,`desg`,`dept`,`email`,`mob`,`tbl`,`mid`,`fid`,`stid`)
		SELECT eid,uname,epwd,fname,lname,mname,designation,department,email,mnumber,'employee',mid,fid,stid FROM employee 
		WHERE eid='$id'";
	$data = $ldb->setData($sql);
	$ret = array();
	$ret["msg"] = $data["msg"];
	$ret["error"] = $data["error"];
	return json_encode($ret);
}

?>
<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function updateprofile($param) {
		global $ldb;
		$param = json_decode($param,true);
		$sql = "UPDATE employee set lname='{$param["lname"]}',address1='{$param["address1"]}',address2='{$param["address2"]}',mnumber='{$param["mnumber"]}',dob='{$param["dob"]}',gender='{$param["gender"]}' where eid = '{$param["eid"]}'";
		$res=$ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
	}
function getUserDetails(){
	global $ldb,$udtl;
	$sql="select * from employee where eid='{$udtl['uid']}'";
	$res=$ldb->getDBData($sql);
	return json_encode($res);
}
?>
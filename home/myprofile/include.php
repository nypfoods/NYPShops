<?php 
class Controler {
	public $glb =  array();
	public $test = "Example Data";
	public $ldb = null;
	function __construct($glb) {
		global $ldb;
		$this->ldb = $ldb;
		$this->glb = $glb;
	}
}

	function updateprofile($param) {
		global $ldb;
		$param = json_decode($param,true);
		$sql = "UPDATE customer set efname = '{$param["efname"]}',elname='{$param["elname"]}',address1='{$param["address1"]}',address2='{$param["address2"]}',mnumber='{$param["mnumber"]}',dob='{$param["dob"]}',gender='{$param["gender"]}' where eid = '{$param["eid"]}'";
		$res=$ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
	}
?>
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

function changepass($param) {
	global $ldb,$db;
	$param = json_decode($param,true);
	$eid = getUserId('eid');
	$oldpwd=md5($param['oldpwd']);
	$epwd=md5($param['epwd']);
	$sql = "select epwd from customer where eid='$eid' and epwd='$oldpwd'";
	$res = ($ldb->getDBData($sql))["data"];
	if(count($res)>0) {
		$sql = "UPDATE customer set epwd = '$epwd' where eid='$eid' ";
		$ures	=	$ldb->getDBData($sql);
		$ures 	= 	$db->setData($sql);
		return json_encode($ures);
	} else {
	$res["error"] = true;
			$res["msg"] = "Please Enter Correct Password";
			 return json_encode($res);
	}
}



?>
<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}


function addbill($param) {
global $ldb;
	$param = json_decode($param,true);
	$pdata["id"] = uniqid();
	$pdata["uname"] = $param["uname"];
$pdata["amount"] =$param["amount"];
$pdata["pnote"] = $param["pnote"];
$pdata["date"]= date("Y-m-d");
			$sql = sqlinsert($pdata,"utility_bill","insert");
		$res = $ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
}
function addutility($param) {
global $ldb;
	$param = json_decode($param,true);
	$pdata["id"] = uniqid();
	$pdata["uname"] = $param["uname"];
			$sql = sqlinsert($pdata,"utility_list","insert");
		$res = $ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
}
?>
<?php 
class Controler {
		public $glb =  array();
		public $test = "Example Data";
		public $ldb = null;
		public $db = null;
	function __construct($glb) {
		global $ldb,$db;
		$this->ldb = $ldb;
		$this->glb = $glb;
		$this->db = $db;
	}
}

function placecartorder() {
	global $ldb;
	$pdata["odate"] = date("Y-m-d");
	$pdata["ordsts"] = 'B';
	$sql="select IFNULL(max(bilno),0)+1 as blnum from orders where ordsts='B'";
	$pdata["bilno"]=($ldb->getDBData($sql))["data"][0]["blnum"];
	if($itemid!=false) {
		$itemid = $itemid[0]["itmid"];
		$sql = "UPDATE `counter` SET `pqty` = `pqty`+1 where `itmid` = '$itemid'";
		$res = $ldb->getDBData($sql);

	} else {
		$sql = sqlinsert($pdata,"counter","insert");
		$res = $ldb->getDBData($sql);
	}
	return $res?json_encode($res):$sql;
}


?>
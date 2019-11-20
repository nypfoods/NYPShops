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

function changestatus($param) {
	global $ldb;
	$res = false;
	$sql = "No Sql";

	$param = json_decode($param,true);
	$eid=$param['eid'];
	$ordlst =  $ldb->getDBData("select stname from orders where ordid='{$param['ordid']}' and ordsts='R'");
	$stname = 	$ordlst["data"][0]['stname'];

	$cdb = new DB();
	$cdb->dbLogin($ldb->host,$ldb->username,$ldb->password);
	$cdb->setDB($stname);
	$sqldel="delete from orders where ordsts='P' and ordid='0' ";
	$cdb->getDBData($sqldel);
	$ldb->getDBdata($sqldel."and stname='{$stname}'");
	
	$sql = "update orders set ordsts='P' where ordid='{$param['ordid']}' and ordsts='R' ";
	
	$res = $cdb->getDBData($sql);
	$ret = exportOrders($eid,"and ordid='{$param['ordid']}'",$stname);
	$res["exportOrders"] = $ret;
	return $res?json_encode($res):$sql;
}

?>
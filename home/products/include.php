<?php 
class Controler {
	public $ldb = null;
	public $db = null;
	public $tpcookie = array();
	function __construct($glb) {
		global $ldb,$db,$tpcookie;
		$this->ldb = $ldb;
		$this->db = $db;
		$this->tpcookie = $tpcookie;
	}
}

function checkProductInCart($prd) {
	global $ldb;
	$pqty = (isset($prd["pqty"])&&$prd["pqty"]>0)?$prd["pqty"]:1;
	$sql = "select * from orders where pid = '{$prd["pid"]}' and uid='{$prd["uid"]}' and ordsts='P' and extras='{$prd["extras"]}'";
	$res = $ldb->getDBData($sql);
	$ret = array();
	$updf = count($res["data"])>0;
	if($updf) {
		$ret["itmid"] = $res["data"][0]["itmid"];
		$ret["pqty"] = 	$res["data"][0]["pqty"]+$pqty;
	} else {
		$ret["itmid"] = uniqid();
		$ret["pqty"] = $pqty;
	}
	return $ret;
}

function addtocart($param) {
	global $ldb,$tpcookie;
	$param = json_decode($param,true);
	unset($param["regtime"]);
	unset($param["updtime"]);
	$uid = getUserId('eid');
	$param["uid"] 	= $param["eid"] = $uid;
	$ret = checkProductInCart($param);
	$param = array_merge($param,$ret);
	$param["odate"] = date("Y-m-d");
	$sql = sqlinsert($param,"orders","insert");
	$res = $ldb->getDBData($sql);
	$res["export"] = exportOrders($uid,"and itmid='{$ret['itmid']}'");
	return json_encode($res);
}

function getproductdata($param) {
	global $ldb;
	$param = json_decode($param,true);
	$sql="select * from mapproduct where pid='{$param["pid"]}'";
	$res["pname"]=($ldb->getDBData($sql))["data"][0]["pname"];
	$res["pdesc"]=($ldb->getDBData($sql))["data"][0]["pdesc"];
	$res["psz"]=($ldb->getDBData($sql))["data"][0]["psz"];
	$res["pqty"]=($ldb->getDBData($sql))["data"][0]["pqty"];
	
    return 	json_encode($res);
}
?>
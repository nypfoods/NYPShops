<?php 
class Controler {
		public $glb =  array();
		public $test = "Example Data";
		public $ldb = null;
		public $db = null;
		public $req = array();
	function __construct($glb) {
		global $ldb,$db;
			$this->req = $_REQUEST;
			$this->ldb = $ldb;
			$this->glb = $glb;
			$this->db = $db;
	}
}

function placecartorder($param) {
	global $ldb;
	$param = json_decode($param,true);
	$pdata["odate"] = date("Y-m-d");
	$pdata["ordsts"] = 'B';
	$param["ordpyid"] = uniqid();
	$pdata["onum"]=($ldb->getDBData("select IFNULL(max(onum),0)+1 as onum from orders"))["data"][0]["onum"];
	$sql="select IFNULL(max(bilno),0)+1 as blnum from orders where ordsts='B'";
	$pdata["bilno"]=($ldb->getDBData($sql))["data"][0]["blnum"];
	$uid = getUserId('eid');
	$dsql = "update orders set bilno='{$pdata["bilno"]}',ordsts='{$pdata["ordsts"]}',odate='{$pdata["odate"]}',ordsts='B',ordpyid='{$param["ordpyid"]}',onum='{$pdata["onum"]}' where ordsts='R' and bilno = '0' and ordid='{$param["ordid"]}'";

	$res = $ldb->getDBData($dsql);
/*	$ret["eid"]=$param["eid"];*/
	$res["bilno"] = $pdata["bilno"];
	$res["odate"] = $pdata["odate"];
	$res["ordid"] = $param["ordid"];
	$ret = $res;
	exportOrders(""," and ordid = '{$param["ordid"]}' ");
    return 	json_encode($ret);
}
function emailurl($param){
	global $smtpmail;
	$param = json_decode($param,true);
	$content  = curl($param["url"]);
	$rese = send_mail($param['email'],"{$param['sbj']}",$content);
	$ret = array();
	$ret["res"] = $rese;
	return json_encode($ret);
}

?>
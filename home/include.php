<?php 
	class Controler {
		public $udtl = array();
		public $ldb = null;
		public $db = null;
		public $glb = "";
		function __construct($glb) {
			global $ldb,$db,$udtl;
			$this->glb = $glb;
			$this->ldb = $ldb;
			$this->db = $db;
			$this->udtl = $udtl;
		}
	}

	function checkStoreDistance($lat,$lng) {
		global $db;
		$gkey = "AIzaSyCUJFCcq8e31FpwUGt7timiBHrnNwUK6g4";
		$dis = INF;
		//$dis = -1;
		$gidex = 0;
		$res = $db->getDBData("select * from outlet where 1");
		$res = $res["data"];
		$darr = array();
		foreach ($res as $k => $v) {
			$lat1 = $v["lat"];
			$lng1 = $v["lng"];
			$nresstr = getMapDistance($lat1,$lng1,$lat,$lng,$gkey);
			$nres = json_decode($nresstr,true);
			$ndis = $nres["dis"];
			$darr[$k] = $ndis;
			if($ndis!=null&&$dis>$ndis) {
				$dis = $ndis;
				$gidex = $k;
			}
		}
		$ret["dis"] = $dis;
		$ret["gidex"] = $gidex;
		$ret["darr"] = $darr;
		$ret["res"] = $res[$gidex];
		return (count($res)>0)?$ret:false;
	}

	function insertMissingCustomer($ret,$sdb){
		$res = $ret[0];
		$sql = sqlinsert($res,"customer","replace");
		$res = $sdb->getDBData($sql);
		return $res;
	}

	function checkUserLoginByStore($store) {
		global $udtl,$ldb,$islogin;
		if(isset($udtl["eid"])) {
			$sql = "select * from `customer` where eid ='{$udtl['eid']}'";
			$sdb = new DB();
			$sdb->dbLogin($ldb->host,$ldb->username,$ldb->password);
			$sdb->setDB($store['usname']);
			$insres = null;
			if($islogin) {
				$res = ($sdb->getDBData($sql))["data"];
				if(count($res)<=0) {
					$ret = ($ldb->getDBData($sql))["data"];
					if(count($ret)>0){
						$insres = insertMissingCustomer($ret,$sdb);
					}
				}
			} else {

			}
			sleep(1);
			$ret = $ldb->getDBData($sql);
		}
		//$ret["insertMissingCustomer"] = $insres;
		$ret["udtl"] = json_encode($udtl);
		return $ret;
	}

	function getStore($param) {
		global $db;
		$param = json_decode($param,true);
		$ret = array();
		$ret["error"] = true;
		$lat = $param[1]["lat"];
		$lng = $param[1]["lng"];
		$chkdst = checkStoreDistance($lat,$lng);
		$res = $chkdst["res"];
		if(count($res)>0) {
		 	$ret["db"] = $res["usname"];
		 	$ckres = checkUserLoginByStore($res);
		 	//$ret['checkUserLoginByStore'] = $ckres;
		 	$ret["error"] = false;
		 	$_SESSION["mytpaddress"] = $param[2];
		 	$_SESSION["db"] = $res["usname"];
		 	$ret["cusDtl"] = getCustomerDetails($_SESSION["db"]);
		}
		$ret["param"] = $param;
		$ret["checkStoreDistance"] = $chkdst;
		return json_encode($ret);
	}

	function getCustomerDetails($dbname){
		global $db,$udtl;
		$cdb = new DB();
		$cdb->dbLogin($db->host,$db->username,$db->password);
		$cdb->setDB($dbname);
		$isql = sqlinsert($udtl,"customer","replace");
		$res = $cdb->setData($isql);
		return $res;
	}
?>
<?php 
class Controler {
	public $ldb = null;
	public $db = null;
	function __construct($glb) {
		global $ldb,$db;
		$this->ldb = $ldb;
		$this->db = $db;
	}
}

	

	function updatecartorder($param) {
		global $ldb;
		$dbname = $ldb->dbname;
		$param = json_decode($param,true);
		$param["eid"] = isset($param["eid"])?$param["eid"]:"";
		$param["address2"] = isset($param["address2"])?$param["address2"]:"";
		$param["onote"] = isset($param["onote"])?$param["onote"]:"";
		$param["ordid"] = md5(uniqid().$dbname);
		$ret = array();
		$cdata = getCostomerDetails($param);
		if($cdata) {
			$cdata1['eid']=$cdata['eid'];
			$param = array_merge($param,$cdata1);
		} else {
			$ret["error"] = true;
			$ret["msg"] = "Error in inserting customer";
		}
		$uid = getUserId('eid');
		$dsql = "update orders set eid='{$param["eid"]}',euname='{$param["efname"]}',mnumber='{$param["mnumber"]}',address1='{$param["address1"]}',address2='{$param["address2"]}',email='{$param["email"]}',ordid='{$param["ordid"]}',cpnamt='{$param["cpnamt"]}',cpnid='{$param["cpnid"]}',onote='{$param["onote"]}',ordsts='R',uid='{$param['eid']}' where ordsts='P' and bilno = '0' and uid='$uid'";
		$res = $ldb->getDBData($dsql);
		$ret["eid"]=$param["eid"];
		$ret["ordid"] = $param["ordid"];
		$ret = array_merge($ret,$res);
		exportOrders($ret["eid"]," and ordid='{$ret["ordid"]}'");
	    return 	json_encode($ret);
	}

	function getCostomerDetails($param) {
		global $ldb,$db;
		$sql = "select euname,mnumber,address1,eid,email,address2,efname,elname from customer where eid = '{$param["eid"]}' or mnumber='{$param["mnumber"]}' or email='{$param["email"]}'";
		$res = ($ldb->getDBData($sql))["data"];
		if(count($res)>0) {
			$ures= $res[0];
			return $ures;
		} else {
			$emp = array();
			$epwd = uniqid();
			$emp["epwd"] = md5($epwd);
			$emp["euname"]=strtolower($param["email"]);
			$emp["efname"]=ucwords($param["efname"]); 
			$emp["elname"]=ucwords($param["elname"]); 
			$emp["mnumber"]=$param["mnumber"];
			$emp["address1"]=$param["address1"];
			$emp["address2"]=$param["address2"];
			$emp["email"]=$param["email"];
			$emp["etlat"] = 0;
			$emp["etlag"] = 0;
			$emp["eid"] = uniqid();
			$ins = sqlinsert($emp,"customer");
			$db->getDBData($ins);
			$inrtd = $ldb->getDBData($ins);
			if($inrtd["error"]) {
				return json_encode($inrtd);
			} else {
				unset($emp["etlat"]);
				unset($emp["etlag"]);
			$cont = "Mr/Mrs {$emp['efname']} {$emp['elname']}, <br/>Welcome to New York Pizza <br/>\n
				Username:\t<b>{$emp["euname"]}</b>\n<br/>
				Password:\t<b>$epwd</b>\n<br/>
				http://online.new-yorkpizza.com/index.php?path=/home/login&db=nypz
				";
				send_mail($param["email"],"Wellcome to New York Pizza",$cont);
				return $emp;
			}
		}
	}
?>
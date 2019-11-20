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
function addtopurchase($param) {
	global $ldb;
	$param = json_decode($param,true);
	$pdata["pursts"] = 'P';
	$pdata["dstatus"] = 0;
	$pdata["bilno"] = 0;
	$pdata["purid"] = uniqid();
	$pdata["uid"] = $_COOKIE["PHPSESSID"];
	$pdata["pid"] = $param['pid'];
	$pdata["pqty"]=$pdata["dqty"] =$param['pqty'];
	$pdata["pveg"] = $param['pveg'];
	$pdata["pname"] = $param['pname'];
	$pdata["pnum"] = $param['pnum'];
	$pdata["pcat"] = $param['pcat'];
	$pdata["ptype"] = $param['ptype'];
	$pdata["psz"] = $param['psz'];
	$pdata["punt"] = $param['punt'];
	$pdata["purdesc"] = $param['purdesc'];
	$pdata["vid"]	= $param["vid"];
	$pdata["vname"]		= 	$param["vname"];
	$pdata["vmob"]		= 	$param["vmob"];
	$pdata["vemail"]		= 	$param["vemail"];
	$pdata["vaddress"]		= $param["vaddress"];
	$pdata["vprice"]=$pdata["dprice"]= $param["vprice"];


	$sql="select * from online_vendor where vid='{$pdata["vid"]}'";
	$res=$ldb->getDBdata($sql);
	$uname = $res["data"][0]["usname"];

	$ndb = new DB();
	$ndb->dbLogin($ldb->host,$ldb->username,$ldb->password);
	$ndb->setDB($uname);

	$rof = false;
	$vqty = "0";
	$nres = $ndb->getDBData("select * from products where pid='{$pdata["pid"]}'");
	if(count($nres["data"])>0){
	$nres = $nres["data"][0];
	$vqty = $nres["pqty"];
	if($nres["pqty"]>$pdata["pqty"]) {
	$rof = true;
	}
	}
	$pures = $ldb->getDBData("select * from purchase where pid='{$pdata["pid"]}' and vid='{$pdata["vid"]}' and pursts='P'");
	if(count($pures["data"])>0){
	$pures = $pures["data"][0];
	$remqty=($nres["pqty"]-$pures["pqty"]);
	if($remqty>$pdata["pqty"]){
	$rof = true;
	}
	else{
	$rof = false;
	}
	}
		

	if($rof) {

		$chkpid = chkprd($pdata["pid"],$pdata["vid"],$pdata["psz"]);
		if($chkpid!=false) {
			$pqty = $chkpid[0]["pqty"];
			$sql = "UPDATE purchase SET pqty = $pqty+{$pdata['pqty']},purdesc='{$pdata['purdesc']}' where pid = '{$pdata['pid']}' and vid = '{$pdata['vid']}'";
			$res = $ldb->getDBData($sql);
		} else {
			$sql = sqlinsert($pdata,"purchase","insert");
			$res = $ldb->getDBData($sql);
		}

		
		return json_encode($res);
	}
	$ret = array();
	$ret["error"] = true;
	$ret["res"] = $nres;
	$ret["msg"] = "Vendor does not have more than $vqty quantity";
	return json_encode($ret);
}
function purchase_order($param){
	global $ldb;
	$param = json_decode($param,true);
	$odate = date("Y-m-d");
	$ordid = uniqid();
	$sql = "update purchase set pursts='O',odate='{$odate}',ordid='{$ordid}',dstatus=0 where pursts='P' and vid='{$param["vid"]}'";
	$ret = $ldb->getDBData($sql);
	$ret['ordid']=$ordid;
	return $ret?json_encode($ret):$sql;
}
function updateswitch($ordid,$bilno){
	global $ldb;
	$date=date("Y-m-d");
	$sql = "update purchase set ddate='{$date}',bilno='{$bilno}' where ordid='{$ordid}'";
	$ret = $ldb->getDBData($sql);
	return $ret?json_encode($ret):$sql;
}
function readdtopurchase($param){
	global $ldb,$db;
	$param = json_decode($param,true);
	$pdata["pursts"] = 'P';
	$pdata["purid"] = uniqid();
	$pdata["uid"] = $_COOKIE["PHPSESSID"];
	$pdata["dstatus"] = 0;
	$pdata["bilno"] = 0;
	$pdata["pid"] = $param['pid'];
	$pdata["vid"] = $param['vid'];
	$pdata["pqty"] =$pdata["dqty"] = $param['rqty'];
	$pdata["vprice"] =$pdata["dprice"]= $param['vprice'];
	$sql="select * from online_vendor where vid='{$pdata["vid"]}'";
	$res=$ldb->getDBdata($sql);
	$pdata["vname"]=$res["data"][0]["name"];
	$pdata["vmob"]=$res["data"][0]["mobno"];
	$pdata["vemail"]=$res["data"][0]["email"];
	$pdata["vaddress"]=$res["data"][0]["adresss"];
	$uname = $res["data"][0]["usname"];
	$ndb = new DB();
	$ndb->dbLogin($ldb->host,$ldb->username,$ldb->password);
	$ndb->setDB($uname);
	$rof = false;
	$vqty = "0";
	$nres = $ndb->getDBData("select * from products where pid='{$pdata["pid"]}'");
	if(count($nres["data"])>0){
		$nres = $nres["data"][0];
		$vqty = $nres["pqty"];
		if($nres["pqty"]>$pdata["pqty"]) {
			$rof = true;
		}
	}
	$pures = $ldb->getDBData("select * from purchase where pid='{$pdata["pid"]}' and vid='{$pdata["vid"]}' and pursts='P'");
	if(count($pures["data"])>0){
		$pures = $pures["data"][0];
		$remqty=($nres["pqty"]-$pures["pqty"]);
			if($remqty>$pdata["pqty"]){
				$rof = true;
				}
			else{
				$rof = false;
			}
				
		}

	if($rof) {
		$sql1="select * from rawproducts where pid='{$pdata["pid"]}'";
		$res1=$ldb->getDBdata($sql1);
		$pdata["pnum"]=$res1["data"][0]["pnum"];
		$pdata["pveg"]=$res1["data"][0]["pveg"];
		$pdata["pname"]=$res1["data"][0]["pname"];
		$pdata["pcat"]=$res1["data"][0]["pcat"];
		$pdata["psz"]=$res1["data"][0]["psz"];
		$pdata["punt"]=$res1["data"][0]["punt"];

		$chkpid = chkprd($pdata["pid"],$pdata["vid"],$pdata["psz"]);
		if($chkpid!=false) {
			$pqty = $chkpid[0]["pqty"];
			$sql2 = "UPDATE purchase SET pqty = $pqty+{$pdata['pqty']} where pid = '{$pdata['pid']}' and vid = '{$pdata['vid']}'";
			$res2 = $ldb->getDBData($sql2);
		} else {
			$sql2 = sqlinsert($pdata,"purchase","insert");
			$res2 = $ldb->getDBData($sql2);
		}
		return json_encode($res2);
	} 
	$ret = array();
	$ret["error"] = true;
	$ret["res"] = $nres;
	$ret["msg"] = "Vendor does not have more than $vqty quantity";
	return json_encode($ret);
}
function chkprd($pid,$vid,$psz) {
	global $ldb;
	$res = $ldb->getDBData("select pid,pqty,vid,pursts from purchase where pid = '$pid' and pursts = 'P' and psz='$psz' and vid='$vid'");
	return count($res)>0?$res["data"]:false;
}


function updateIstatus($sts,$json){
	global $ldb;
	$ret = [];
	$row = json_decode($json,true);
	$ddate = "";
	if($row["ddate"]=="-"||$row["ddate"]==""){
		$today = date("Y-m-d");
		$ddate = ",ddate='$today'";
		$row["ddate"] = $today;
	}
	$swupd = "UPDATE purchase set istatus='$sts' $ddate where purid='{$row['purid']}'";
	$ret['istatus']=$res = $ldb->setData($swupd);
	if(!$res["error"]) {
		if($sts=="1") {
			$op = "+";
		} else {
			$op = "-";
		}
		$ret['updstock']=updstock($row,$op,"rawproducts");
	}
	return json_encode($ret);
}

function updstock($row,$op,$tbl) {
	global $ldb;
	$_SESSION["op"] = $op;
	$prd = getPrd($row["pnum"],$tbl);
	$vals = array();
	$vals["pid"] = $prd["pid"];
	$vals["pnum"] = $prd["pnum"];
	$vals["pcat"] = $prd["pcat"];
	$vals["ptype"] = $prd["ptype"];
	$vals["psz"] = $prd["psz"];
	$vals["posp"] = $prd["posp"];
	$vals["tbl"] = $tbl;
	$vals["sdate"] = $row["ddate"];
	$vals["pname"] = $prd["pname"];
	$vals["ob"] = $prd["pqty"];
	$vals["pur"] = $row["dqty"];
	$vals["cb"] = 0;
	$whr = "pnum='{$vals["pnum"]}' and sdate='{$vals["sdate"]}'";
	$chk=function($k,$v,$f,$ks,$vs){
		$op = $_SESSION["op"];
		$valstr = "(t.`ob`+(t.`pur`$op'{$vs['pur']}')+t.`inp`+t.`sadd`)-(t.`oup`+t.`used`+t.`less`)";
		switch ($k) {
			case 'pur':
				return "t.`pur`$op'{$vs[$k]}'";
			case 'cb':
				return "IF($valstr>0,$valstr,0)";
			default:
				return false;
		}
	};
	$sql = insertSQL("stock_close",$vals,$whr,$chk);
	unset($_SESSION["op"]);
	$res = $ldb->setData($sql);
	if(!$res["error"]&&$tbl=="products") {
		$res["rawp"] = updRawStock($vals,$op);
	}
	return $res;

}

function getPrd($pnum,$tbl,$whr="") {
	global $ldb;
	$res = $ldb->getDBData("select * from `$tbl` where pnum='$pnum' $whr");
	return $res["data"][0];
}
?>
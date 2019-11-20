<?php
class Controler {
	public $glb =  array();
	public $ldb = null;
	function __construct($glb) {
		global $ldb;
		$this->ldb = $ldb;
		$this->glb = $glb;
		$this->vdtl = getvnddtl();
	}
}

function getvnddtl() {
	global $ldb,$udtl,$db;
	$res = $db->getDBData("select * from online_vendor where usname='{$udtl['uname']}'");
	if(count($res["data"])>0){
		return $res["data"][0];
	} else {
		return false;
	}
}


function chksz($parm) {
	global $ldb;
	$pd = array();
	$pd["szid"] = uniqid();
	$pd["szname"] = $parm["bunt"];
	$pd["sznum"] = $parm["blkno"];
	$sql = insertSQL("sizes",$pd,"szname='{$pd["szname"]}'");
	$ret = array();
	$ret = $ldb->setData($sql);
	return $ret;
}


function addtocart($parm) {
	global $ldb,$udtl;
	$pd = json_decode($parm,true);
	unset($pd["qty"]);
	$pd["id"] =  uniqid();
	$pd["vid"] = $udtl["uid"];
	$pd["vname"] = $udtl["fname"];
	$pd["vdtl"] = json_encode($udtl);
	$pd['bilno']=0;
	$sql = sqlinsert($pd,"vendor_quotation");
	$ret = array();
	$ret = $ldb->setData($sql);
	$ret["chksz"] = chksz($pd);
	$ret["pd"] = $pd;
	return json_encode($ret);
}
function updatebill($param){
	global $ldb,$udtl;
	$uid=$udtl['uid'];
	$param = json_decode($param,true);
	$sql="select IFNULL(max(bilno),0)+1 as blnum from vendor_quotation where bstatus<>'P' and vid='$uid'";
	$bilno=($ldb->getDBData($sql))["data"][0]["blnum"];
	$billdate = date("Y-m-d");
	$ordid=uniqid();
	$dsql = "UPDATE vendor_quotation SET bstatus='B',billdate='$billdate',bilno='$bilno',billamt='{$param["billamt"]}',ordid='$ordid' where bstatus='P' and bilno = '0' and vid='$uid'";
		$res = $ldb->getDBData($dsql);
		$res["bilno"] = $bilno;
		$res["billdate"] = $billdate;
	
	return 	json_encode($res);
}


function updateitem($param) {
	global $db;
	$pd = json_decode($param,true);
	$id = $pd["id"];
	$bunt = $pd["bunt"];
	$blkno = $pd["blkno"];
	$blkamt = $pd["blkamt"];
	$pgst = $pd["pgst"];
	$pname = $pd["pname"];
	$pd["posp"] = $posp = round($pd["blkamt"]/$pd["blkno"],2);
	if($id=="-") {
		$pd["id"] = uniqid();
		unset($pd["amount"]);
		unset($pd["new"]);
		$sql = sqlinsert($pd,"vendor_quotation");
	} else {
		$sql = "UPDATE vendor_quotation set bunt='$bunt',blkno='$blkno',blkamt='$blkamt',posp='$posp',pgst='$pgst',pname='$pname' where id='{$id}'";
	}
	$res = $db->setData($sql);
	return json_encode($res);
}
function clearcart() {
	global $db;
	$vdtl = getvnddtl();
	$sql = "DELETE from vendor_quotation where bilno='0' and bstatus='P' and vid='{$vdtl['vid']}'";
	$res = $db->getDBData($sql);
	return json_encode($res);
}

function getProducts() {
	global $db;
	$vdtl = getvnddtl();
	$uni = uniqid();
	$sql = "REPLACE INTO vendor_quotation(`id`, `pid`, `pnum`, `pname`, `punt`, `posp`, `pcat`, `ptype`, `pdvsn`, `pgst`, `vid`, `vname`)";
	$sql.="select id,pid,pnum,pname,punt,posp,pcat,ptype,pdvsn,pgst,'{$vdtl['vid']}' as vid,'{$vdtl['name']}' as vname from (select *,concat('$uni',(@sl:=@sl+1)) as id from rawproducts as r,(select @sl:=0) as sl where find_in_set(pcat,'{$vdtl['pservices']}' ) group by pid) as vendor_quotation";
	$res = $db->getDBData($sql);
	return json_encode($res);
}

function backtocart($d){
	global $db;
	$row = json_decode($d,true);
	$ordid=uniqid();
	$today = date("Y-m-d");
	$sql = "INSERT INTO `vendor_quotation` select  concat(`id`,'$ordid') as `id`, `pid`, `pnum`, `pname`, `pqty`, `bunt`, `punt`, `posp`, `pcat`, `ptype`, `pdvsn`, 0 as bilno, 0 as `ordid`, '$today' as `billdate`,`billamt`, `pgst`, `vid`, `vname`, `vdtl`, `blkno`, `blkamt`, 'P' as `bstatus`,'' as `cmt`, CURRENT_TIMESTAMP as regtime,CURRENT_TIMESTAMP as `updtime` from vendor_quotation where ordid='{$row['ordid']}'";
	return json_encode($db->setData($sql));
}
?>
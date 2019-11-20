<?php
class Controler {
	public $glb =  array();
	public $ldb = null;
	function __construct($glb) {
		global $ldb;
		$this->ldb = $ldb;
		$this->glb = $glb;
	}
}
function updateproduct($param){
	global $ldb;
	$param = json_decode($param,true);
	$pdata["pid"] = $param['pid'];
	$sql = "select * from rawproducts where pid = '{$pdata['pid']}'";
 	$oldprd = ($ldb->getDBData($sql,""))["data"];
 	if(count($oldprd)>0) {
 		$oldprd = $oldprd[0];
 		$vprice = explode(",",$oldprd['vprice']);
		$vid = explode(",",$oldprd['vid']);
		$vname = explode(",",$oldprd['vname']);
		$pos = count($vid);
		if($vids[0]==""){$pos=0;}
		$vid[$pos] 	= $param["vid"];
		$vprice[$pos] = $param["vprice"];
		$vname[$pos] = $param["vname"];
		$pdata["vid"] = implode(",",$vid);
		$pdata["vprice"] = implode(",",$vprice);
		$pdata["vname"] = implode(",",$vname);
		$sql = "UPDATE rawproducts SET vname='{$pdata['vname']}',vid='{$pdata['vid']}',vprice = '{$pdata['vprice']}' WHERE pid='{$pdata['pid']}'";
   		$res = $ldb->getDBData($sql);
   		return json_encode($res);
 	} else {
 		return json_encode(array('sql' =>$sql));
 	}
}
function deletevprice($pid,$vid){
	global $ldb;
	$oldprd = ($ldb->getDBData("select * from rawproducts where pid = '$pid'",""))["data"];
 	if(count($oldprd)>0) {
 		$oldprd = $oldprd[0];
 		$vprice = explode(",",$oldprd['vprice']);
		$vids = explode(",",$oldprd['vid']);
		$vname = explode(",",$oldprd['vname']);
		$pos = array_search($vid,$vids);
		if($vids[0]==""){$pos=0;}
		if($pos!==false) {
			unset($vids[$pos]);
			unset($vprice[$pos]);
			unset($vname[$pos]);
		}
		$pdata["pid"] = $pid;
		$pdata["vid"] = implode(",",$vids);
		$pdata["vprice"] = implode(",",$vprice);
		$pdata["vname"] = implode(",",$vname);
		$sql = "UPDATE rawproducts SET vname='{$pdata['vname']}',vid='{$pdata['vid']}',vprice = '{$pdata['vprice']}' WHERE pid='{$pdata['pid']}'";
   		$res = $ldb->getDBData($sql);
   		return json_encode($res);
 	}
}
function approvestatus($param){
	global $ldb;
	$ret = array();
	$pd = json_decode($param,true);
	$apsatus = $pd[0]["apstatus"];
	$bstatus= $apsatus?"A":"R";
	$sql = "";
	foreach ($pd as $k => $v) {
		$sql.="UPDATE vendor_quotation set cmt='{$v['cmt']}', bstatus='$bstatus' where id='{$v['id']}'".";";
	}
	$res = $ldb->setData($sql);
	if($res["error"]) {
		$res["msg"] = "Some error occoured bill not updated";
	} else {
		$msg = $bstatus=="A"?"Approved":"Rejected";
		$res["msg"] = "Quotation has been $msg";
	}
	return json_encode($res);
}
?>
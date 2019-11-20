<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function transferItem($tqty,$pid,$invfrom,$invto){
	global $ldb;
	$sql="select * from rawproducts where pinv='$invto' and pid='$pid'";
	$res=$ldb->getDBData($sql)['data'];
	if(count($res)<=0){
		$sql1="insert into rawproducts (`uid`, `pid`, `itmid`, `pname`, `pslno`, `pbrd`, `pdvsn`, `pcat`, `ptype`, `penb`, `pveg`, `psz`, `ppkt`, `punt`,`pqty`, `mqty`, `ptqty`, `pdesc`, `pcp`, `pmrp`, `pwsp`, `posp`, `pgst`, `pdip`, `pdia`,`pinv`, `vid`, `vname`, `vprice`, `expdate`, `supd`) select `uid`, `pid`, `itmid`, `pname`, `pslno`, `pbrd`, `pdvsn`, `pcat`, `ptype`, `penb`, `pveg`, `psz`, `ppkt`, `punt`, '$tqty' as `pqty`, `mqty`, `ptqty`, `pdesc`, `pcp`, `pmrp`, `pwsp`, `posp`, `pgst`, `pdip`, `pdia`,'$invto' as pinv, `vid`, `vname`, `vprice`, `expdate`, `supd` from rawproducts where pinv='$invfrom' and pid='$pid'";
		$res1 = $ldb->setData($sql1);
	} else {
		$sql1="update rawproducts set pqty=pqty+'$tqty' where pinv='$invto' and pid='$pid'";
		$res1=$ldb->setData($sql1);
	}
	$res2 = array();
	if($res1['error']==false){
		$sql2="update rawproducts set pqty=pqty-'$tqty' where pinv='$invfrom' and pid='$pid'";
		$res2=$ldb->setData($sql2);
	}
	$res=array();
	$res['error']	=	$res1['error'] && $res2['error'];
	$res['sql']		=	$sql.";".$sql1.";".$sql2;
	return json_encode($res);
}
function bulkTransfer($param){
	$ret = array();
	$ret["error"] = true;
	$pd = json_decode($param,true);
	foreach ($pd["mrow"] as $k => $v) {
		$tqty = $v["tqty"];
		$pid = $v["pid"];
		$invfrom = $pd["invfrom"];
		$invto = $pd["invto"];
		$res = transferItem($tqty,$pid,$invfrom,$invto);
		$res = json_decode($res,true);
		$ret["error"] = $ret["error"]&&$res["error"];
		$ret["mrg"] = $ret["error"]?$res["Some error occoured"]:"";
		$ret["sql"] = $res["sql"];
	}
	return json_encode($ret);
}



?>
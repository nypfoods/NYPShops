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


function emailurl($param){
	global $smtpmail;
	$param = json_decode($param,true);
	$content  = curl($param["url"]);
	$rese = send_mail($param['email'],"Invoice# {$param['sbj']}",$content);
	$ret = array();
	$ret["res"] = $rese;
	return json_encode($ret);
}

function changestatus($param) {
	global $ldb;
	$res = false;
	$sql = "No Sql";

	$param = json_decode($param,true);
	$eid=$param['eid'];

if($param['dboys']!=''){
	$sql = "update orders set ordsts='P',dboys='{$param['dboys']}' where ordid='{$param['ordid']}'";
}
else{
	$sql = "update orders set ordsts='P' where ordid='{$param['ordid']}'";
}
		
		$res = $ldb->getDBData($sql);
		$ret = exportOrders($eid,"and ordid='{$param['ordid']}'");
		$res["exportOrders"] = $ret;
	return $res?json_encode($res):$sql;
}
function counterstatus($param) {
	global $ldb;
	$res = false;
	$sql = "No Sql";
	$param = json_decode($param,true);
	$pdate=date("Y-m-d H:i:s");
		$sql = "update counter set ordsts='Pr',pdatetime='$pdate' where ordid='{$param['ordid']}'";
		$res = $ldb->getDBData($sql);	
	return $res?json_encode($res):$sql;
}
?>
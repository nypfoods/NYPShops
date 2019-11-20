<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function update_apstatus($status,$id,$apdate){
	global $ldb;
	$res = false;
	$sql = "No Sql";
	$sql = "update approval set status='$status',apdate='$apdate' where id='$id'";
	$res = $ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
}
function emailurl($param){
	global $smtpmail,$ldb;
	$param = json_decode($param,true);
	$content  = curl($param["url"]);
	$rese = send_mail($param['email'],"{$param['sbj']}",$content);
	$ret = array();
	$ret["res"] = $rese;
	$sql1 = "update approval set bansts='1' where id='{$param["id"]}'";
	$res = $ldb->getDBData($sql1);
	return json_encode($ret);
}
?>
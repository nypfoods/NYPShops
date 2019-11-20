<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function addecounter($param){
	global $ldb;
	$param = json_decode($param,true);
	$pdata["eid"] = $param["eid"];
	$pdata["cid"] = $param["cid"];
	$pdata["cname"] = $param["cname"];
	$sql = "UPDATE users SET cid='{$pdata['cid']}',cname='{$pdata['cname']}' where uid = '{$pdata['eid']}'";
		$res = $ldb->getDBData($sql);
		return $res?json_encode($res):$sql;
}
?>
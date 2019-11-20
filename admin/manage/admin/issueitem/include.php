<?php 
class Controler {
		public $glb = array();
	public $ldb = null;
	function __construct($glb) {
		global $ldb;
		$this->glb = $glb;
		$this->ldb = $ldb;
	}
}


function updateIssue($isid) {
	global $ldb;
	$res = false;
	$sql = "No Sql";
	
		$sql = "update issueitem set status='S' where isid='$isid'";
		$res = $ldb->getDBData($sql);
	
	return $res?json_encode($res):$sql;
}


function delIssue($isid) {
	global $ldb;
	$res = false;
	$sql = "No Sql";
	
		$sql = "update issueitem set status='C' where isid='$isid'";
		$res = $ldb->getDBData($sql);
	
	return $res?json_encode($res):$sql;
}
function issueitem($isid,$dep,$idate){
	global $ldb;
	$sql="select IFNULL(max(isno),0)+1 as blnum from issueitem";
	$res=$ldb->getDBData($sql);
		$sql="";
	foreach ($res['data'] as $key => $value) {
		foreach ($res["data"][$key] as $i => $val) {
			$isno=$res["data"][$key][$i];
		$dsql = "update issueitem set status='S',dep='$dep',idate='$idate',isno='$isno' where status='CRT'";
	$resp = $ldb->getDBData($dsql);
	return $resp?$resp:$dsql;
		}
		
	}
}
?>
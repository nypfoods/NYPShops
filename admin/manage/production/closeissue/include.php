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


function updateIssue($isid,$cdate) {
	global $ldb;
	$res = false;
	$sql = "No Sql";
	
		$sql = "update issueitem set status='CLS',rqty=0,cdate='$cdate' where isid='$isid'";
		$res = $ldb->getDBData($sql);
	
	return $res?json_encode($res):$sql;
}
?>
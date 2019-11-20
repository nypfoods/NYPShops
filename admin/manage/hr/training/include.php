<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}


function addtraining($param) {
global $ldb;
	$param = json_decode($param,true);
	$pdata["trid"] = uniqid();
	$pdata["name"] = $param["name"];
	$pdata["description"] = $param["description"];
	$pdata["department"] =$param["department"];
	$pdata["fromtime"] = $param["fromtime"];
	$pdata["totime"] =$param["totime"];
	$pdata["fromdate"] =$param["fromdate"];
	$pdata["todate"] =$param["todate"];
	$sql = sqlinsert($pdata,"training","insert");
	$res = $ldb->getDBData($sql);
	return 	json_encode($res);
}
?>
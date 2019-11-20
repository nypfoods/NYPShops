<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function addtest($param,$json) {
global $ldb;
	$param = json_decode($param,true);
		$pdata["id"] = uniqid();
	  $pdata["department"] = $param['department'];
    $pdata["designation"] = $param['designation'];
    $pdata["question"] = $json;
    $pdata["testdate"] = $param['testdate'];
	
			$sql = sqlinsert($pdata,"create_test","insert");
		$res = $ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
}
?>
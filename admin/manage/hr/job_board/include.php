<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function addjob($param) {
global $ldb;
	$param = json_decode($param,true);
		$pdata["id"] = uniqid();
	  $pdata["department"] = $param['department'];
    $pdata["designation"] = $param['designation'];
    $pdata["title"] = $param['title'];
    $pdata["skill"] =$param['skill'];
    $pdata["description"] = $param['description'];
	
			$sql = sqlinsert($pdata,"job_board","insert");
		$res = $ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
}
?>
<?php 
	class Controler {
		public $glb = "";
		public $test = "Example Data";
		function __construct($glb) {
			$this->glb = $glb;
		}
	}
	function updatedesc($bnrid,$bnrdesc){
	global $ldb;
	$res = false;
	$sql = "No Sql";
	
		$sql = "update banner set bnrdesc='$bnrdesc' where bnrid='$bnrid'";
		$res = $ldb->getDBData($sql);
	
	return $res?json_encode($res):$sql;
}
?>
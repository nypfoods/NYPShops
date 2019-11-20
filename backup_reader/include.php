<?php 
class Controler {
	public $ldb = null;
	public $db = null;
	function __construct($glb) {
		global $ldb,$db;
		$this->ldb = $ldb;
		$this->db = $db;
	}
}

function executeCmd($cmd){
	$output = array();
	$cmds = explode("\n",$cmd);
	foreach ($cmds as $k => $c) {
		exec($c,$output);
		echo json_encode($output);
	}
}

?>
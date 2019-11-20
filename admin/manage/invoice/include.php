<?php 
class Controler {
	public $glb =  array();
	public $test = "Example Data";
	public $ldb = null;
	public $db = null;
	function __construct($glb) {
		global $ldb,$db;
		$this->ldb = $ldb;
		$this->glb = $glb;
		$this->db = $db;
	}
}
?>
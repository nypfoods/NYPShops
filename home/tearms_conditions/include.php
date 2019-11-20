<?php
class Controler {
	public $udtl = array();
	public $ldb = null;
	public $db = null;
	public $glb = "";
	function __construct($glb) {
		global $ldb,$db,$udtl;
		$this->glb = $glb;
		$this->ldb = $ldb;
		$this->db = $db;
		$this->udtl = $udtl;
	}
}
?>
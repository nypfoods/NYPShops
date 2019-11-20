<?php 
	class Controler {
		public $glb = "";
		public $test = "Example Data";
		public $ldb = null;
		public $db = null;
		function __construct($glb) {
			global $ldb,$db;
			$this->glb = $glb;
			$this->ldb = $ldb;
			$this->db = $db;
		}
	}

?>
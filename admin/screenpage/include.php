<?php 
	class Controler {
		public $glb = "";
		public $menulstar = "[]";
		public $rscreen = null;
		function __construct($glb) {
			global $rscreen,$gmenu;
			$this->rscreen = $gmenu;
			$this->glb = $glb;
		}
	}
?>
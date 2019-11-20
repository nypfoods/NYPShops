<?php 
	class Controler {
		public $rscreen = array();
		public $mscreen = array();
		function __construct($glb) {
			global $rscreen,$mscreen;
			$this->glb = $glb;
			$this->mscreen = $mscreen;
			$this->rscreen = $rscreen;
		}
	}
	function custest(){
	    return "Custom Test Function";
	}
?>
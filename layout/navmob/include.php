<?php 
class Controler {
	public $glb = array();
	public $udtl = array();
	function __construct($glb) {
		global $udtl;
		$this->udtl = $udtl;
		$this->glb = $glb;
	}
}
?>
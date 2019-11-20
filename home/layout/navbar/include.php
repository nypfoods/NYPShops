<?php 
class Controler {
public $glb = array();
public $udtl = array();
public $rscreen = array();
public $gmenu = array();
	function __construct($glb) {
		global $udtl,$rscreen,$gmenu;
		$this->udtl = $udtl;
		$this->glb = $glb;
		$this->rscreen = $rscreen;
		$this->gmenu = $gmenu;
	}
}
?>
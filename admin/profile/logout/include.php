<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}

function logout() {
	unset($_SESSION["lgtbl"]);
	unset($_SESSION["lgusr"]);
	unset($_SESSION["lgpwd"]);
	unset($_SESSION["pkey"]);
	unset($_SESSION["ukey"]);
	return screen_url("/admin");
}
?>
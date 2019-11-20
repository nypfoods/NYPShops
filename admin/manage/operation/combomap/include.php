<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}

function updatecombo(...$arr) {
	global $ldb;
	$combo = $arr[1];
	$pid = $arr[0];
	$res = $ldb->setData("update `products` set combo = '$combo' where pid='$pid'");
	return json_encode($res);
}
?>
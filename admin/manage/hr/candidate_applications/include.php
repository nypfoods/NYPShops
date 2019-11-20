<?php
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function emailurl($param){
	global $smtpmail;
	$param = json_decode($param,true);
	$content  = $param["content"];
	$rese = send_mail($param['email'],"{$param['sbj']}",$content);
	$ret = array();
	$ret["res"] = $rese;
	$ret["url"] = $param["url"];
 	return json_encode($ret);
}

?>
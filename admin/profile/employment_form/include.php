<?php 
class Controler {
	function __construct($glb) {
	}
}

function submitform($json){
	global $udtl,$db;
	$pd = [];
	$pd["id"] = uniqid();
	$pd["eid"] = $udtl["uid"];
	$pd["fname"] = $udtl["uname"];
	$pd["detail"] = $json;
	$sql = sqlinsert($pd,"employment_form");
	$res = $db->setData($sql);
	return json_encode($res);
}
?>
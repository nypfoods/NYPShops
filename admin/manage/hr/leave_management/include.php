<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function update_apstatus($status,$id,$apdate){
	global $ldb;
	$res = false;
	$sql = "No Sql";
	$count = $ldb->getDBData("select lfrom,lto from employee_leave where id='$id'");
	$lfrom=$count["data"][0]["lfrom"];
	$lto=$count["data"][0]["lto"];
	if($status=='A'){
		$sql = "update employee_leave set status='$status',apdate='$apdate',a_days=DATEDIFF('$lto','$lfrom') where id='$id'";
	}
	else{
	$sql = "update employee_leave set status='$status',apdate='$apdate',a_days='0' where id='$id'";	
	}
	
	$res = $ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
}
?>
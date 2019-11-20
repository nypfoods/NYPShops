<?php 
class Controler {
	public $ldb = null;
	public $db = null;
	function __construct($glb) {
		global $ldb,$db;
		$this->ldb = $ldb;
		$this->db = $db;
	}
}

function submitattendace($date,$eid,$attendence_status,$reason,$department) {
	global $ldb;
	$eid = explode(",",$eid);
	$attendence_status = explode(",",$attendence_status);
	$reason = explode(",",$reason);
	$department = explode(",",$department);
	$res = array();
	$err = "";$erri=-1;
	foreach ($eid as $i => $val) {
		$obj = array();
		$obj["eid"] = $eid[$i];
		$obj["attendance_status"] = $attendence_status[$i];
		$obj["reason"] = $reason[$i];
		$obj["department"] = $department[$i];
		$obj["aid"] = uniqid();
		$obj["working_date"] = $date;
		$sql = sqlinsert($obj,"attendance","replace");
		$res[$i] = $ldb->setData($sql);
		if($res[$i]["error"]) {
			$err = $res[$i]["msg"];
		}
	}
	$ret = array();
	$ret["error"] = ($err!="");
	$ret["msg"] = $err;
	if($erri!=-1) {
		$ret["sql"] = $res[$erri]["sql"];
	}
	return json_encode($ret);

}
?>
<?php 
class Controler {
	public $glb = array();
	public $ldb = null;
	function __construct($glb) {
		global $ldb;
		$this->glb = $glb;
		$this->ldb = $ldb;
	}
};


function productEnable($pid,$val) {
	global $ldb;
	$sql = "select * from products where pid='$pid'";
	$res = $ldb->getDBData($sql);
	$pd = array();
	$ret = array();
	if(count($res["data"])>0) {
		$pd = $res["data"][0];
	}
	if($val&&count($pd)>0) {
		$chksql = "select * from products where pinv='Sales' and pname='{$pd['pname']}' and psz='{$pd['psz']}'";
		$res = ($ldb->getDBData($chksql))["data"];
		if(count($res)==0) {
			$pd["pinv"] = "Sales";
			$pd["penb"] = 1;
			unset($pd["pnum"]);
			$sql = sqlinsert($pd,"products");
			$ret = $ldb->setData($sql);		
		}
	} else if(count($pd)>0){
		$delsql =  "DELETE FROM `products` WHERE pinv='Sales' and pname='{$pd['pname']}' and psz='{$pd['psz']}'";
		$ret = $ldb->setData($delsql);
	} else {
		$pd["penb"] = 0;
		$sql = sqlinsert($pd,"products");
		$ret = $ldb->setData($sql);
	}
	return json_encode($ret);
}
?>
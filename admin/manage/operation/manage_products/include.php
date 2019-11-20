<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}

function addproduct(...$arr) {
	global $ldb;
	$pd = array();
	$pd["pname"] 	= $arr[0];
	$pd["pdvsn"] 	= $arr[1];
	$pd["pcat"] 	= $arr[2];
	$pd["ptype"] 	= $arr[3];
	$pd["pgst"] 	= $arr[4];
	$pd["psz"] 		= $arr[5];
	$pd["pqty"] 	= $arr[6];
	$pd["mqty"] 	= $arr[7];
	$pd["punt"] 	= $arr[8];
	$pd["pcp"] 		= $arr[9];
	$pd["posp"] 	= $arr[10];
	$pd["pmrp"] 	= $arr[11];
	$pd["pdesc"] 	= $arr[12];
	$pd["vid"] 		= $arr[13];
	$pd["vname"] 	= $arr[14];
	$pd["vprice"] 	= $arr[15];
	$pd["pveg"] 	= $arr[16];
	$pd["ingredients"] = $arr[17];
	$pd["psug"] 	= $arr[18];
	$psz 	= explode(",",$pd["psz"]);
	$pqty 	= explode(",",$pd["pqty"]);
	$mqty 	= explode(",",$pd["mqty"]);
	$punt 	= explode(",",$pd["punt"]);
	$pcp 	= explode(",",$pd["pcp"]);
	$posp 	= explode(",",$pd["posp"]);
	$pmrp 	= explode(",",$pd["pmrp"]);
	$ing 	= explode("#-sep-#",$pd["ingredients"]);
	$sql = "";
	$pd["itmid"] = uniqid();
	foreach ($psz as $i => $val) {
		$pd["pid"] 	= uniqid();
		$pd["psz"] 	= isset($psz[$i])?$psz[$i]:"N/A";
		$pd["pqty"] = isset($pqty[$i])?$pqty[$i]:"0";
		$pd["mqty"] = isset($mqty[$i])?$mqty[$i]:"0";
		$pd["punt"] = isset($punt[$i])?$punt[$i]:"Grms";
		$pd["pcp"] 	= isset($pcp[$i])?$pcp[$i]:"0";
		$pd["posp"] = isset($posp[$i])?$posp[$i]:"0";
		$pd["pmrp"] = isset($pmrp[$i])?$pmrp[$i]:"0";
		$pd["ingredients"] = isset($ing[$i])?$ing[$i]:"[]";
		$sql .= sqlinsert($pd,"products").";";	
	}
	$res = $ldb->setData($sql);
	return json_encode($res);
}

?>
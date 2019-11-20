<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}
function addtoday(){
	global $ldb;
	$id = uniqid();
	$sql="REPLACE INTO `closing_bill`(`id`, `total`,`sgst`,`cgst`,`sub_total`,`tdate`,`type`,`cpnamt`) select '$id' as id,sum(pamt) as total,sum(gstamt)/2 as sgst,sum(gstamt)/2 as cgst,sum(pamt-gstamt-cpnamt) as subtotal,CURRENT_DATE,'ALL',sum(cpnamt) from (select sum(@pamt:=posp*pqty) as pamt,sum(@gstamt:=((posp*pqty)*(pgst/100))) as gstamt,sum(@pamt-@gstamt) as damt,DATE_FORMAT(odate, '%Y-%m-%d'),min(cpnamt) as cpnamt   from counter where DATE(odate) = CURDATE() and bilno!='0' and ordsts='S') as dayclose";
	$id = uniqid()."1";
	$sql.=";REPLACE INTO `closing_bill`(`id`, `total`,`sgst`,`cgst`,`sub_total`,`tdate`,`type`,`cpnamt`) select '$id' as id,sum(pamt) as total,sum(gstamt)/2 as sgst,sum(gstamt)/2 as cgst,sum(pamt-gstamt-cpnamt) as subtotal,CURRENT_DATE,'ONLINE',sum(cpnamt) from (select sum(@pamt:=posp*pqty) as pamt,sum(@gstamt:=((posp*pqty)*(pgst/100))) as gstamt,sum(@pamt-@gstamt) as damt,DATE_FORMAT(odate, '%Y-%m-%d'),min(cpnamt) as cpnamt from orders where DATE(odate) = CURDATE() and bilno!='0' and ordsts='S') as dayclose";
	$amt =  array('CASH','E-WALLET','CARD','THIRD-PARTY');
	foreach ($amt as $key => $cash) {
		$id = uniqid().$key;
		$sql.=";REPLACE INTO `closing_bill`(`id`, `total`,`sgst`,`cgst`,`sub_total`,`tdate`,`type`,`cpnamt`) select '$id' as id,sum(pamt) as total,sum(gstamt)/2 as sgst,sum(gstamt)/2 as cgst,sum(pamt-gstamt-cpnamt) as subtotal,CURRENT_DATE,'$cash',sum(cpnamt) from (select sum(@pamt:=posp*pqty) as pamt,sum(@gstamt:=((posp*pqty)*(pgst/100))) as gstamt,sum(@pamt-@gstamt) as damt,DATE_FORMAT(odate, '%Y-%m-%d'),min(cpnamt) as cpnamt   from counter where DATE(odate) = CURDATE() and bilno!='0' and pmtd='$cash' and ordsts='S') as dayclose";
	}
	
	$res = $ldb->setData($sql);
	$res["date"] = date("Y-m-d");
	$ret = $res;
	//unset($res["sql"]);
	return json_encode($ret);
}
function workingcash($param) {
global $ldb;
	$param = json_decode($param,true);
	$pdata["id"] = uniqid();
	$pdata["type"] = $param['type'];
	$pdata["name"] = $param['name'];
	$pdata["date"]= date("Y-m-d");
	$pdata["working_cash"] = $param["working_cash"];
			$sql = sqlinsert($pdata,"working_cash","insert");
		$res = $ldb->getDBData($sql);
	return $res?json_encode($res):$sql;
}
function emailurl($param){
	global $smtpmail;
	$param = json_decode($param,true);
	$content  = curl($param["url"]);
	$rese = send_mail($param['email'],"{$param['sbj']}",$content);
	$ret = array();
	$ret["res"] = $rese;
	return json_encode($ret);
}

?>
<?php 
include 'global/phpqrcode/qrlib.php';
class Controler {
	public $glb =  array();
	public $test = "Example Data";
	public $ldb = null;
	function __construct($glb) {
		global $ldb;
		$this->ldb = $ldb;
		$this->glb = $glb;
	}
}

function qrCode($name="qr",$text="GEEKS FOR GEEKS"){
    $path = 'res/qr/'; 
    $file = $path.$name.".png"; 
    $ecc = 'L'; 
    $pixel_Size = 10; 
    $frame_Size = 10;
    QRcode::png($text,$file,$ecc,$pixel_Size,$frame_Size);
    return get_url("res/qr/{$name}.png");
}

function createProduct($param) {
	global $ldb,$udtl;
	$pd = array();
	$pd["uid"] = $udtl["uid"];
	$pd["pid"] = uniqid();
	$pd["pinv"] = "Sales";
	$pd["pname"] = $param["pname"];
	$pd["pqty"] = "0";
	$pd["psz"] = " - ";
	$pd["itmid"] = $pd["pid"];
	$pd["pveg"] = "1";
	$pd["pcat"] = $param["pcat"];
	$pd["ptype"] = $param["ptype"];
	$pd["posp"] = $pd["pmrp"] = $param["posp"];
	$pd["pgst"]  = $param["pgst"];
	$sql = sqlinsert($pd,"products");
	$res = $ldb->setData($sql);
	return $pd;
}
function getRawPrds($vals) {
	global $ldb;
	$sql = "select r.*,
	( @pos := Jpos(s.ingredients ->> '$[*].ipnum',r.pnum) ) AS pos, 
	Jex(s.ingredients, Concat('$[', @pos, '].ipqty'))      AS used
	FROM   rawproducts AS r, 
	(
	    SELECT p.ingredients, p.posp AS sp, c.* 
		FROM  counter AS c, products AS p 
		WHERE  Jpos(c.ptpng ->> '$[*].pnum', p.pnum) <>- 1 
	    AND odate = '{$vals["sdate"]}' 
	    AND c.pnum='{$vals["pnum"]}'
	    UNION
	    SELECT p.ingredients, p.posp AS sp, c.* 
	    FROM   counter AS c 
	    LEFT JOIN products AS p 
	    ON p.pid = c.pid 
	    WHERE odate = '{$vals["sdate"]}' 
	    AND c.pnum='{$vals["pnum"]}'
	) as s 
	WHERE  
	Jpos(s.ingredients ->> '$[*].ipnum', r.pnum) <>- 1";
	$res = $ldb->getDBData($sql);
	return $res;
}

function updRawStock($vals,$op="-") {
	global $ldb;
	$res = getRawPrds($vals);
	$ret = array();
	$ret["rawPrd"] = $res;
	if(count($res["data"])>0) {
		$data = $res["data"];
		$sql = "";
		foreach ($data as $k => $row) {
			$row["oqty"] = $row["pqty"];
			$row["pqty"] = $vals["used"]*$row["used"];
			$row["odate"] = $vals["sdate"];
			$ret[$row["pnum"]] = updtoStock($row,$row,$op,"rawproducts");
		}
	}
	return $ret;
}

function delcnt($param) {
	$pd = json_decode($param,true);
	$pd["sdate"] = $pd["odate"];
	addQty($pd["itmid"],$pd["pqty"],0);
}

function getPrd($pnum,$tbl,$whr="") {
	global $ldb;
	$res = $ldb->getDBData("select * from `$tbl` where pnum='$pnum' $whr");
	return $res["data"][0];
}

function updtoStock($pdata,$param,$op="+",$tbl="products") {
	global $ldb;
	$_SESSION["op"] = $op;
	$prd = getPrd($pdata["pnum"],$tbl);
	$vals = array();
	$vals["pid"] = $pdata["pid"];
	$vals["pnum"] = $pdata["pnum"];
	$vals["pcat"] = $pdata["pcat"];
	$vals["ptype"] = $pdata["ptype"];
	$vals["psz"] = $pdata["psz"];
	$vals["posp"] = $pdata["posp"];
	$vals["tbl"] = $tbl;
	$vals["sdate"] = $pdata["odate"];
	$vals["pname"] = $pdata["pname"];
	$vals["used"] = $pdata["pqty"];
	$vals["ob"] = $prd["pqty"];
	$cb = $vals["ob"]-$vals["used"];
	$vals["cb"] = $cb>0?$cb:0;
	$whr = "pnum='{$vals["pnum"]}' and sdate='{$vals["sdate"]}'";
	$chk=function($k,$v,$f,$ks,$vs){
		$op = $_SESSION["op"];
		$valstr = "(t.`ob`+t.`pur`+t.`inp`+t.`sadd`)-(t.`oup`+(t.`used`$op'{$vs['used']}')+t.`less`)";
		switch ($k) {
			case 'used':
				return "t.`used`$op'{$vs[$k]}'";
			case 'cb':
				return "IF($valstr>0,$valstr,0)";
			default:
				return false;
		}
	};
	$sql = insertSQL("stock_close",$vals,$whr,$chk);
	unset($_SESSION["op"]);
	$res = $ldb->setData($sql);
	if(!$res["error"]&&$tbl=="products") {
		$res["rawp"] = updRawStock($vals,$op);
	}
	return $res;
}

function addQty($itmid,$qty,$add) {
	global $ldb;
	$res = $ldb->getDBData("select * from counter where itmid = '$itmid'");
	$pd = $res["data"][0];
	$rem = $pd["pqty"];
	$pd["pqty"] = $qty;
	$rem = $rem-$pd["pqty"];
	if($add==1) {
		$sql = "update counter set pqty=pqty+'$qty' where itmid = '$itmid'";
		$res = $ldb->setData($sql);
		if(!$res["error"]) {
			$res["stock"] = updtoStock($pd,$pd,$op="+");
		}
	} else {
		$stockres=updtoStock($pd,$pd,$op="-");
		if(!$stockres["error"]) {
			if($rem>0) {
				$sql = "update counter set pqty=IF(pqty-'$qty'>0,pqty-'$qty',0) where itmid = '$itmid'";
			} else {
				$sql = "DELETE FROM `counter` WHERE itmid = '$itmid'";
			}
		}
		$res = $ldb->setData($sql);
		$res["stock"] = $stockres;
	}
	return json_encode($res);
}

function addcounter($param) {
	global $ldb;
	$param = json_decode($param,true);
	if(!isset($param['pid'])) {
		$qty = $param["pqty"];
		$pd = createProduct($param);
		$param = array_merge($param,$pd);
		$param["pqty"] = $qty;
	}
	$pdata["odate"] = date("Y-m-d");
	$pdata["ordsts"] = 'P';
	$pdata["bilno"] = 0;
	$pdata["itmid"] = uniqid();	
	$pdata["uid"] = $_COOKIE["PHPSESSID"];
	$pdata["pid"] = $param['pid'];
	$pdata["pnum"] = $param['pnum'];
	$pdata["pqty"] =$param['pqty'];
	$pdata["pmrp"] = $param['pmrp'];
	$pdata["posp"] = $param['posp'];
	$pdata["bchn"] = $param['bchn'];
	$pdata["pveg"] = $param['pveg'];
	$pdata["otamt"] = $param['otamt'];
	$pdata["pname"] = $param['pname'];
	$pdata["pcat"] = $param['pcat'];
	$pdata["ptype"] = $param['ptype'];
	$pdata["pgst"] = $param['pgst'];
	$pdata["odatetime"] = $pdata["regtime"] = $param["regtime"];
	$pdata["ptpng"] = isset($param["toppings"])?$param["toppings"]:"[]";
	$pdata["psz"] = $param['psz'];
	$pdata["pdesc"] = "";
	$itemid = chkprd($pdata["pnum"],$pdata["bchn"],$pdata["uid"]);
	if($itemid!=false) {
		$itemid = $itemid[0]["itmid"];
		$sql = "UPDATE counter SET pqty = pqty+{$param['pqty']} where itmid = '$itemid'";
		$res = $ldb->getDBData($sql);

	} else {
		$whr = "pid='{$pdata["pid"]}' and bchn='{$pdata["bchn"]}' and bilno='0' ";
		$chk = function($k,$v,$f,$ks,$vs){
			switch ($k) {
				case 'pqty':
				return "t.pqty+'{$vs[$k]}'";
				case 'itmid':
				return "t.itmid";
				default:
				return false;
			}
		};
		$sql = insertSQL("counter",$pdata,$whr,$chk);
		$res = $ldb->getDBData($sql);
	}
	if(!$res["error"]) {
		$res["stock"]=updtoStock($pdata,$param);
	}
	return $res?json_encode($res):$sql;
}

function chkprd($pnum,$bchn,$uid) {
	global $ldb;
	$res = $ldb->getDBData("select itmid,pqty from counter where pnum = '$pnum' and ordsts = 'C' and uid='$uid' and bchn='$bchn'");
	return count($res)>0?$res["data"]:false;
}

function checkCart($bchn) {
	global $ldb;
	$sql = "select * from counter where ordsts='P' and bilno='0' and bchn='$bchn'";
	return count($ldb->getDBData($sql)["data"])>0;
}

function getCostomerDetails($param) {
	global $ldb,$db;
	$sql = "select euname,mnumber,address1,eid from customer where  mnumber='{$param["mnumber"]}'";
	$res = $ldb->getDBData($sql)["data"];
	if(count($res)>0) {
		$ures = $res[0];
		return $ures;
	} else {
		$emp = array();
		$epwd=uniqid();
		if($param["email"]!=''){
			$uname=strtolower($param["email"]);
		} else {
			$uname=strtolower($param["efname"]);
		}
		$emp["euname"]=$uname;
		$emp["epwd"]=md5($epwd);
		$emp["efname"]=ucwords($param["efname"]); 
		$emp["mnumber"]=$param["mnumber"];
		$emp["address1"]=$param["address1"];
		$emp["email"]=$param["email"];
		$emp["etlat"] = 0;
		$emp["etlag"] = 0;
		$emp["eid"] = uniqid();
		$ins = sqlinsert($emp,"customer");
		$inrtd = $ldb->getDBData($ins);
		if($inrtd["error"]) {
			print_r($inrtd);
			return json_encode($inrtd);
		} else {
			unset($emp["etlat"]);
			unset($emp["etlag"]);
			if($emp["email"]){
				
				$cont = "Hello Mr/Mrs {$emp['efname']}, <br/>Welcome to New York Pizza Family we are happy serve you the world's best pizza.<br/>\n
				Username:\t<b>{$emp["euname"]}</b>\n<br/>
				Password:\t<b>$epwd</b>\n<br/>
				http://online.new-yorkpizza.com/index.php?path=/home/login&db=nypz
				";
				send_mail($param["email"],"Wellcome to New York Pizza",$cont);
			}
			
			return $emp;	
		}
	}
}

function updatebillcounter($param) {
	global $ldb,$udtl;
	$param = json_decode($param,true);
	$param["ordid"] = md5(uniqid().$ldb->dbname);
	$pdata["bchn"] = $param['bchn'];
	$pdata["pmtd"]=$param["pmtd"];
	$param["odate"] = date("Y-m-d");
	$year = date("Y");
	$sql="select IFNULL(max(bilno),0)+1 as blnum from counter where ordsts<>'P' and odate>'$year-04-00'";
	$param["bilno"]=($ldb->getDBData($sql))["data"][0]["blnum"];
	$today = date("Y-m-d");
	$sql="select IFNULL(max(bildn),0)+1 as blnum from counter where ordsts<>'P' and odate>='$today'";
	$param["bildn"]=($ldb->getDBData($sql))["data"][0]["blnum"];
	$ret = array();
	if(checkCart($param["bchn"])) {
		$cdata = getCostomerDetails($param);
		if($cdata) {
			$cdata1['eid']=$cdata['eid'];
			$param = array_merge($param,$cdata1);
		} else {
			$ret["error"] = true;
			$ret["msg"] = "Error in inserting customer";
		}
		$dsql = "update counter set eid='{$param["eid"]}',email='{$param['email']}',euname='{$param["efname"]}',mnumber='{$param["mnumber"]}',address1='{$param["address1"]}',ordid='{$param["ordid"]}',ordsts='{$param["ordsts"]}',odate='{$param["odate"]}',bildn='{$param["bildn"]}',bilno='{$param["bilno"]}',cpnamt='{$param["cpnamt"]}',cpnid='{$param["cpnid"]}',ppaid='{$param["ppaid"]}',pmtd='{$param["pmtd"]}' where ordsts='P' and bilno = '0' and bchn = '{$param["bchn"]}'";
		$res = $ldb->getDBData($dsql);
		$ret = array_merge($ret,$res);
		$ret["bilno"] = $param["bilno"];
		$ret["odate"] = $param["odate"];
		//$ret["payment_link"] = paymentLink($param,$ret);
	} else {
		$ret["error"] = true;
		$ret["msg"] = "Cart is empty";
	}
	return 	json_encode($ret);
}

function paymentLink($pd,$ret){
	global $udtl;
	$pd = array_merge(array(),$pd);
	$pd['shop_name'] = $udtl["shop_name"];
	$pd['shop_upi'] = $udtl["shop_upi"];
	$pd['name'] = $ret["odate"]."_".$ret["bilno"];
	$paysuc = screen_url("/payment");
	$paysuc = str_replace("local.sln-billing.com","new-yorkpizza.com", $paysuc);
	$paysuc = str_replace("&db=sln","",$paysuc);
	$paysuc = urlencode($paysuc);
	$paysuc .= "&ordid={$pd["ordid"]}";
	foreach ($pd as $k => $v) {
		$pd[$k] = urlencode($v);
	}
	$trdtl = "&tid={$pd["ordid"]}&tr={$pd["ordid"]}&url=$paysuc";
	$payname = str_replace("_","|",$pd['name']);
	$url = "upi://pay?pn={$pd['shop_name']}&pa={$pd['shop_upi']}&tn=Sale Bill|$payname&am={$pd["ppaid"]}&cu=INR&mode=04$trdtl";
	qrCode($pd['name'],$url);
	return $url;
}

function settleAmt($json) {
	global $ldb;
	$pd = json_decode($json,true);
	$sql = "UPDATE counter set ordsts='S',pmtd='{$pd["pmtd"]}' where ordid='{$pd["ordid"]}'";
	$res = $ldb->setData($sql);
	return json_encode($res);
}

function updatedesc($itmid,$otdesc){
	global $ldb;
	$res = false;
	$sql = "No Sql";
	
		$sql = "update counter set otdesc='$otdesc' where itmid='$itmid'";
		$res = $ldb->getDBData($sql);
	
	return $res?json_encode($res):$sql;
}

function emailurl($param){
	global $smtpmail;
	$param = json_decode($param,true);
	$content  = curl($param["url"]);
	$rese = send_mail($param['email'],"Invoice# {$param['sbj']}",$content);
	$ret = array();
	$ret["res"] = $rese;
	return json_encode($ret);
}

function changestatus($param) {
	global $ldb;
	$res = false;
	$sql = "No Sql";

	$param = json_decode($param,true);
	$eid=$param['eid'];
	if($param['cancel']==true){
		$ordsts='C';
	} else {
		if($param['ordsts']=='B'){
			$ordsts='K';
		}
		else if($param['ordsts']=='K'){
			$ordsts='O';
		}
		else if($param['ordsts']=='O'){
			$ordsts='S';
		}
	}
if($param['dboys']!=''){
	$sql = "update orders set ordsts='{$ordsts}',dboys='{$param['dboys']}' where ordid='{$param['ordid']}'";
}
else{
	$sql = "update orders set ordsts='{$ordsts}' where ordid='{$param['ordid']}'";
}
		
		$res = $ldb->getDBData($sql);
		$ret = exportOrders($eid,"and ordid='{$param['ordid']}'");
		$res["exportOrders"] = $ret;
	return $res?json_encode($res):$sql;
}
function counterstatus($param) {
	global $ldb;
	$res = false;
	$sql = "No Sql";
	$param = json_decode($param,true);
		$sql = "update counter set ordsts='S' where ordid='{$param['ordid']}'";
		$res = $ldb->getDBData($sql);	
	return $res?json_encode($res):$sql;
}
?>
<?php
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}

function importTable($name,$ndb,$sql="") {
	global $db,$ldb,$res;
	$sql = $sql==""?"select * from $name":$sql;
	$res = $db->getDBData($sql);
	$sql="";
	foreach ($res['data'] as $key => $value) {
		foreach ($res["data"][$key] as $i => $val) {
			$res["data"][$key][$i] = $res["data"][$key][$i]=="NULL"?'null':$res["data"][$key][$i];
		}
		$sql.=sqlinsert($res["data"][$key],$name).";";
	}
	 $res = $ndb->getDBData($sql);
	 $ret = array();
	 $ret["sql"] = $res;
	if($res){
		$ret["res"] = 1;
	}
	else{
		$ret["res"] = 0;
	}
	return $ret;
}

function importData($arr,$ndb,$sqls=array()) {
	global $db,$ldb;
	$ret = array();
	$res = 1;
	foreach ($arr as $k => $val) {
		$sql = isset($sqls[$val])?$sqls[$val]:"";
		$tmp = importTable($val,$ndb,$sql);
		$res *= $tmp["res"];
		$ret[$val] = $tmp;
	}
	$ret["res"] = $res;
    return $ret;
}

function importFunc($usname,$ndb) {
	$csql = getFun();
	$res =$ndb->execSQL($csql,"{-del-}");
	return $res;
}

function insertDefaultData($usname,$ndb,$epwd,$name) {
	global $db;
	$retres = array();
	$sqls = array();
	$crsql = "";
	if($name!='vendor'){
		$chksql = "select * from online_franchise where usname = '$usname'";
		$res = $db->getDBData($chksql);
		if(count($res["data"])>0) {
			$frdtl = $res["data"][0];
			//$crsql	.=	fileRead("./sql/ins.sql");
			$crsql .= "INSERT INTO `users`(`uid`, `uname`, `epwd`, `fname`, `desg`, `email`, `mob`, `tbl`,`dept`) VALUES ('1','$usname','$epwd','Admin','Owner','{$frdtl['pemail']}','{$frdtl['pmob']}','online_franchise','Admin')";
			$retres = $ndb->setData($crsql);
			$db->setData("INSERT INTO `users`(`uid`, `uname`, `epwd`, `fname`, `desg`, `email`, `mob`, `tbl`,`dept`) VALUES ('{$frdtl['id']}','$usname','$epwd','$usname','Owner','{$frdtl['pemail']}','{$frdtl['pmob']}','online_franchise','Admin')");
		} else {
			$retres["chksql"] = $chksql;
		}
		$sqls["rawproducts"] = "select * from rawproducts where (pdvsn='Sale Product' or pdvsn='Custom Option') and pinv='Godown'";
	} else {
		$chksql = "select * from online_vendor where usname = '$usname'";
		$res = $db->getDBData($chksql);
		if(count($res["data"])>0) {
			$frdtl = $res["data"][0];
			/*$crsql	.=	fileRead("./sql/ins.sql");*/
			$crsql .= "INSERT INTO `users`(`uid`, `uname`, `epwd`, `fname`, `desg`, `email`, `mob`, `tbl`,`dept`) VALUES ('1','$usname','$epwd','Admin','Owner','{$frdtl['email']}','{$frdtl['mobno']}','online_vendor','Admin')";
			$retres = $ndb->setData($crsql);
			$db->setData("INSERT INTO `users`(`uid`, `uname`, `epwd`, `fname`, `desg`, `email`, `mob`, `tbl`,`dept`) VALUES ('{$frdtl['vid']}','$usname','$epwd','$usname','Owner','{$frdtl['email']}','{$frdtl['mobno']}','online_vendor','Admin')");

		} else {
			$retres["chksql"] = $chksql;
		}
		$sqls["rawproducts"] = "select * from rawproducts where pcat='Perishable' and ptype='Raw Food' and pinv='Godown'";
		$sql["products"]="select * from products where pdvsn='Finished raw products'";
	}
	$tbls = array("products","bnrs","cat","combo","coupons","department","designation","countries","states","cities","rawproducts");
	$retres["importData"] = importData($tbls,$ndb,$sqls);
	return $retres;
}

function createFranchise($usname,$epwd,$name) {
	global $ldb,$_CONFIG;
	$ndb = new DB();
	$ndb->dbLogin($_CONFIG["host"],$_CONFIG["username"],$_CONFIG["password"]);
	$ndb->setDB($usname);
	$csql = getCreatSql();
	$ret = array();
	$ret["creatTable"] = $ndb->setData($csql);
	$ret["creatFunction"] = importFunc($usname,$ndb);
	sleep(2);
	$ret["defaultData"] = insertDefaultData($usname,$ndb,$epwd,$name);
	return $ret;
}


function activerow($param){
	global $ldb,$db;
	$param = json_decode($param,true);
	$id = $param["id"];
	$usname = $param["usname"];
	$pwd = rand(999,9999);
	$epwd = md5($pwd);
	$_SESSION[base64_encode($usname)] = $pwd;
	if($param["name"]=="master" || $param["name"]=="franchise"){
		$sql1 = "update online_franchise set active='{$param["active"]}',uspwd='$epwd' where id='{$param["id"]}'";
		$res1 = $ldb->getDBData($sql1);
	}
	else if($param["name"]=="vendor"){
		$sql1 = "update online_vendor set active='{$param["active"]}',uspwd='$epwd' where vid='{$param["id"]}'";
		$res1 = $ldb->getDBData($sql1);
	}
	$ret = array();
	if($param["name"]=="master") {
		$ret["master"] = $db->setData("INSERT INTO `users`(`uid`, `uname`, `epwd`, `fname`, `desg`, `email`, `mob`, `tbl`,`dept`,`status`) SELECT id,usname,uspwd,pname,'Master Franchise',pemail,pmob,'online_franchise','Sales',active from online_franchise where usname = 'NYPMFA1915' and NOT EXISTS(select * from users where uname='$usname')");
	}

	$ret["res1"] = $res1;
	$sql2 = "update users set epwd='$epwd',status='{$param["active"]}' where uid='{$param["id"]}'";
	$res2 = $ldb->getDBData($sql2);
	$ret["res2"] = $res2;
		if(($param["name"]=="franchise" || $param["name"]=="vendor") && $param["active"]==1){
			$name=$param["name"];
			$crdbres = createFranchise($usname,$epwd,$name);
			$res2["crdbres"] = $crdbres;
		} else if(($param["name"]=="franchise" || $param["name"]=="vendor") && $param["active"]==0) {
			/*$db->setData("drop database $usname");*/
		}
	$ret["error"] = ($ret["res2"]["error"]&&$ret["res1"]["error"]);
	$ret["msg"] = "Some error occured";
	return json_encode($ret);
}
/*function emailurl($param){
global $smtpmail;
$param = json_decode($param,true);
$content = $param["content"];
$rese = send_mail($param['email'],"{$param['sbj']}",$content);
$ret = array();
$ret["res"] = $rese;
return json_encode($ret);
}*/
function afranchise($id,$uid,$usname,$dbty){
	global $ldb;
	$res = false;
	$sql = "No Sql";
		if($dbty=='master' || $dbty=='franchise'){
			

		$uspwd = rand(999,9999);
		$_SESSION[base64_encode($usname)] = $uspwd;
		$uspwd=md5($uspwd);
		$sql1 = "update online_franchise set approve='1',usname='$usname',uspwd='$uspwd' where id='$id'";
		$res1 = $ldb->getDBData($sql1);
		$sql = "REPLACE INTO  `users`(`uid`,`uname`,`epwd`,`fname`,`email`,`mob`,`tbl`,`status`)
		SELECT id,usname,uspwd,pname,pemail,pmob,'online_franchise','0' FROM online_franchise 
		WHERE id='$id'";
	$data = $ldb->setData($sql);
	}
	else if($dbty=='vendor'){
		
		$uspwd = rand(999,9999);
		$_SESSION[base64_encode($usname)] = $uspwd;
		$uspwd=md5($uspwd);
		$sql1 = "update online_vendor set approve='1',usname='$usname',uspwd='$uspwd' where vid='$id'";
		$res1 = $ldb->getDBData($sql1);
		$sql = "REPLACE INTO  `users`(`uid`,`uname`,`epwd`,`fname`,`email`,`mob`,`tbl`,`status`)
		SELECT vid,usname,uspwd,name,email,mobno,'online_vendor','0' FROM online_vendor
		WHERE vid='$id'";
	$data = $ldb->setData($sql);
	}
	return $res1?json_encode($res1):$sql1;
}
?>
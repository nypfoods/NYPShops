<?php 
class Controler {
	public $glb = array();
	public $ldb = null;
	public $session = null;
	public $udtl = null;
	public $islogin=null;
	public $dashurl=null;
	function __construct($glb) {
		global $ldb,$udtl,$db,$islogin,$dashurl;
		$this->glb = $glb;
		$this->ldb = $ldb;
		$this->udtl = $udtl;
		$this->session = $_SESSION;
		$this->islogin=$islogin;
		$this->dashurl=$dashurl;

		//$res = globalSql("select * from `dbname`.customer where 1");
	}
}

$dashurl = screen_url("/admin/dashboard");
function adminlogin($param) {
	global $ldb,$site,$basepath,$http,$session,$dashurl;
	if(strlen($param["password"])==32&&$param["lg"]==$param["password"]){
		$param["epwd"] = $param["password"];
	} else {
		$param["epwd"] = md5($param["password"]);	
	}
	$sql = "select * from users where uname='{$param["username"]}' and epwd='{$param["epwd"]}'";
	$res = $ldb->getDBData($sql);
	if(count($res["data"])>0){
		$_SESSION["lgtbl"]="users";
		$_SESSION["lgusr"] = $param["username"];
		$_SESSION["lgpwd"] = $param["epwd"];
		$_SESSION["udb"] = true;
		$crdkey = md5("credentials");
		$crdval = base64_encode(json_encode($_SESSION));
		echo "<script>$.cookie('$crdkey','$crdval');window.location='$dashurl';</script>";
	} else {

	}

}



?>
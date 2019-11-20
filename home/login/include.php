<?php 
class Controler {
	public $glb =  array();
	public $test = "Example Data";
	public $ldb = null;
	function __construct($glb) {
		global $ldb,$udtl;
		$this->ldb = $ldb;
		$this->glb = $glb;
		if(count($udtl)>0&&!isset($udtl['efname'])) {
			$url=screen_url('logout');
			echo "<script>
			window.location='$url';
			</script>";
		}
	}
}
function signin($value)
{
	global $ldb;
	$pwd=md5($value['epwd']);
	$sql="select * from customer where euname='{$value['euname']}' and epwd='$pwd' ";
	$res = $ldb->getDBData($sql);
	if(count($res["data"])>0){
		$res = $res["data"][0];
		$_SESSION["lgtbl"] = "customer";
		$_SESSION["lgusr"] = $res['euname'];
		$_SESSION["lgpwd"] = $res['epwd'];
		$_SESSION["pkey"] = "epwd";
		$_SESSION["ukey"] = "euname";
		$url  = screen_url("home");
		echo "<script>
		window.location='$url';
		</script>";
	} else {
		$resjson = json_encode($res);
		echo "<script>
		console.log('res',$resjson);
		talert('Invalid Credentials','Error...!',()=>{});
		</script>";
	}
}

if(count($udtl)>0) {
	$url  = screen_url("home");
	echo "<script>
	window.location='$url';
	</script>";
}

function sendOTP($param) {
	$param  = json_decode($param,true);
	$otp = rand(999,9999);
	$ret = array();
	$_SESSION["otp"] = $otp;
	$itemid = chkcustomer($pdata["email"],$pdata["mnumber"]);
	if($itemid==false) {
		$ret["error"] = true;
		$ret["msg"] = "Account already exists";
		return json_encode($ret);
	}
	$res = send_mail($param["email"],"Registration OTP $otp","Hello user your registration OTP is $otp")." send status";
	$ret["error"] = $res!="1";
	$ret["msg"] = "Problem in sending email";
	return json_encode($ret);
}

function addsignup($param) {
	global $ldb;
	$param = json_decode($param,true);
	$ret = array();
	$ret["error"] = false;
	if($_SESSION["otp"]==$param["otp"]) {
		$pdata["eid"] = uniqid();
		$pdata["mnumber"] =$param["mnumber"];
		$pdata["email"] = $param['email'];
		$pdata["efname"] = $param['efname'];
		$pdata["elname"] = $param['elname'];
		$pdata["euname"] = $param['email'];
		$pdata["epwd"] = md5($param['epwd']);
		$pdata['etlat']=0;
		$pdata['etlag']=0;
		
		 $itemid = chkcustomer($pdata["email"],$pdata["mnumber"]);
		 if($itemid!=false) {
			$eid = $itemid[0]["eid"];
			$res["error"] = true;
			$res["msg"] = "Your account already exist";
		}  
		else {
			$sql = sqlinsert($pdata,"customer","insert");
			$res = $ldb->getDBData($sql);
			$_SESSION["lgtbl"] = "customer";
			$_SESSION["lgusr"] = $pdata['euname'];
			$_SESSION["lgpwd"] = $pdata['epwd'];
			$_SESSION["pkey"] = "epwd";
			$_SESSION["ukey"] = "euname";
		}
		$ret = array_merge($ret,$res);
	} else {
		$ret["error"] = true;
		$ret["msg"] = "OTP Missmatch";
	}
	return json_encode($ret);
}

function chkcustomer($email,$num) {
	global $ldb;
	$res = $ldb->getDBData("select efname,elname,eid from customer where mnumber = '$num' and email = '$email'");
	return count($res["data"])>0?$res["data"]:false;
}

function emailurl($url,$invoice,$email){
	$content  = curl($url);
	$rese = send_mail($email,"Invoice# $invoice",$content);
}

function forget_password($param)
{
	global $ldb;
	$param = json_decode($param,true);
	$ret = array();
	$ret["error"] = false;
	$sql="select * from customer where email='{$param['mobile']}' or mnumber='{$param['mobile']}'";
	$res=$ldb->getDBData($sql);
	$res = $res["data"];
	if(count($res)>0) {
		$res = $res[0];
		$pwd = uniqid();
		$epwd=md5($pwd);
		$sql="update customer set epwd='$epwd' where eid='{$res['eid']}'";
		$upres = $ldb->setData($sql);
		$con="Dear {$res['efname']},<br> 
		Your new credentials are <br/>
		username: <b>{$res['euname']}</b><br/>
		password: <b>$pwd</b>";
		$ret["ret"] = send_mail($res['email'],"Password Reset Notice",$con);
	} else {
		$ret["error"] = true;
		$ret["msg"] = "Sorry given credentials does't exist ";
	}
	return json_encode($ret);
}


?>
<?php 
	function login($parm) {
		global $db,$appname,$rtf;
		$epwd = md5($parm["pwd"]);
		$sql = "SELECT eid FROM `customer` WHERE `euname` = '{$parm["uname"]}' and epwd = '{$epwd}'";
		$res = $db->getData($sql);
		if(count($res)>0) {
			$_SESSION["userid"] = $res[0][0];
			$_SESSION["logtable"] = "customer";
			$_SESSION["logid"] = "eid";
			$_SESSION["name"] = "efname,elname";
			return "<script>window.location='$rtf$appname/admin/home'</script>";
		} else {
			//return "<script>alert('Invalid Credentials');</script>";
			return "<script>window.location='$appname/home'</script>";
		}
	}

	function custom($parm) {
		print_r($parm);
		echo "Demo Function";
	}
?>
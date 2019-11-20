<?php
setup_mail("3.13.255.115","info@new-yorkpizza.com","Infony@123","info@new-yorkpizza.com","New-York Pizza.Co");


function exportOrders($eid="",$whr="",$stname=null) {
		global $db,$ldb;
		$eidwh = $eid!=""?"eid = '$eid'":"1";
		$stname = ($stname==null?$ldb->dbname:$stname);
		$cdb = new DB();
		$cdb->dbLogin($ldb->host,$ldb->username,$ldb->password);
		$cdb->setDB($stname);
		$oet = $cdb->getDBData("select * from orders where $eidwh $whr");
		$res = $oet["data"];
		if(count($res)>0) {
			$sql = "";
			foreach ($res as $i => $row) {
				foreach ($row as $key => $value) {
					$row[$key] = $row[$key]=="NULL"?'0':$row[$key];
				}
				$row["stname"] = ($stname==null?$ldb->dbname:$stname); 
				$sql .= sqlinsert($row,"orders","replace").";";
			}
			$res = $db->getDBData($sql);
			return $res;
		} else {
			return array('sts' =>'Order not found' ,'sql'=>$oet );
		}
	}
?>
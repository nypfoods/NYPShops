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
function updateStock($date) {
  global $ldb;
  $sql = "update rawproducts as r join (SELECT pid,(ob+pur+inp+sadd-(used+less+oup)) as cb FROM `stock_close` where sdate='$date') as s ON r.pid = s.pid set r.pqty = s.cb,r.supd = '$date' where pinv = 'Production'";
  $res = $ldb->setData($sql);
  return json_encode($res); 
}
function updatecb($parm) {
  global $ldb;
  $parm = json_decode($parm,true);
  $diff = $parm["ncb"] - ($parm["cb"]-$parm["sadd"]+$parm["less"]);
  $diffabs = abs($diff); 
  $addf = $diff>0?true:false;
  $fld = "";
  $cfld = "";
  if($addf&&$diff!=0){
    $fld="sadd";$cfld="less";
    $updstr = "(cb+oup-pur-inp)+$diffabs";
  } else if($diff!=0) {
    $fld="less";$cfld="sadd";
    $updstr = "(cb+oup-pur-inp)+$diffabs";
  }
  if($diff!=0) {
    $sql = "UPDATE `stock_close` SET $fld = $diffabs,$cfld='0',cb=(ob+pur+sadd+inp-(used+less+oup)) where pid='{$parm['pid']}' and sdate='{$parm['sdate']}'";
  } else {
    $sql = "UPDATE `stock_close` SET sadd = '0',less='0',cb=(ob+pur+sadd+inp-(used+less+oup)) where pid='{$parm['pid']}' and sdate='{$parm['sdate']}'";
  }
  $res = $ldb->setData($sql);
  return json_encode($res);
}

?>
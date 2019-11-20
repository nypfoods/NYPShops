<?php
class Controler {
	public $udtl = array();
	public $ldb = null;
	public $db = null;
	public $glb = "";
	function __construct($glb) {
		global $ldb,$db,$udtl;
		$this->glb = $glb;
		$this->ldb = $ldb;
		$this->db = $db;
		$this->udtl = $udtl;
	}
}

function moveDocs($arr,$vid,$ssid){
	foreach ($arr as $key => $val) {
		$old = "upload/vendor/onlineforms/temp/$ssid/$val";
		$new = "upload/vendor/onlineforms/$vid/$val";
		move($old,$new);
	}
}

function sendVendorDoc($id,$name,$tel,$address,$ssid,$doc) {
	global $smtpmail;
	moveDocs(explode(",",$doc),$id,$ssid);
	$smtpmail->fromName = "NYP Foods|".$name;
	$file = get_url("upload/vendor/onlineforms/$id/vendor_registration.pdf");
	return send_mail("admin@new-yorkpizza.com",
		"VEN Enquiry NO:$id $tel",
		"New Vendor Request has arrived please check out the attachment PDF<br/>
		<b>Address:</b><p>$address</p>",
		"amitarora@new-yorkpizza.com,myppkworld@gmail.com",
		$file
	);
}
?>
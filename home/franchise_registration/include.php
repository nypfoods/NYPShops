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

function sendFranchiseDoc($id,$loc,$name) {
	global $smtpmail;
	$smtpmail->fromName = "NYP Foods|".$name;
	$file = get_url("upload/franchise/onlineforms/$id/franchise_registration.pdf");
	$fl = file_get_contents($file);
	echo $file;
	return send_mail("admin@new-yorkpizza.com",
		"FER Enquiry NO:$id $loc","New Franchise Request has arrived please check out the attachment PDF"
		,
		"amitarora@new-yorkpizza.com,myppkworld@gmail.com",
		$file
	);
}

?>
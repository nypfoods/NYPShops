<?php 
class Controler {
	public $glb = array();
	public $ldb = null;
	function __construct($glb) {
		global $ldb;
		$this->glb = $glb;
		$this->ldb = $ldb;
	}
}
function sendOfferDoc($email,$sub,$body,$folnam) {
	global $smtpmail,$ldb;
	$smtpmail->fromName = "NYP Foods";
	$emailstr = str_replace(".", "", $email);
	$file = get_url("upload/${ldb}/employee/$emailstr/$folnam/doc.pdf");
	$fl = file_get_contents($file);
	return send_mail("$email",
		"$sub","$body"
		,
		"",
		$file
	);
}
?>
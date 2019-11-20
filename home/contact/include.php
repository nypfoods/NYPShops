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

	function sendmail($param) {
		//setup_mail("mail.bmd24.in","info@bmd24.in","9916540397","enquiry@new-yorkpizza.com","Customer Enquiry");
		setup_mail("3.13.255.115","enquiry@new-yorkpizza.com","Enquiryny@123","enquiry@new-yorkpizza.com","New-York Pizza.Co");
		$param = json_decode($param,true);
		$msg = "
			<b>From</b> 		: 	{$param["email"]} 	<br/>
			<b>First Name</b>  	:	{$param["fname"]} 	<br/>
			<b>Last Name</b> 	:	{$param["lname"]} 	<br/>
			<b>Phone</b>		:	{$param["mob"]}   	<br/>
			<b>Message</b> 		:	{$param["message"]} <br/>
			<b>Email</b> 		: 	{$param["email"]}   <br/>
		 ";
		$res = send_mail("contact@new-yorkpizza.com","Enquiry From {$param['fname']}",$msg);
		//$res = send_mail("myppkworld@gmail.com","Enquiry From {$param['fname']}",$msg);
		$ret = array();
		if($res=="1") {
			$ret["error"] = false;
			$ret["msg"] = "Your enquiry is successfully sent. We will ping you back in some time";
			$res = send_mail($param["email"],"Enquiry Acknowledgment from New York Pizza.Co",$msg);
		} else {
			$ret["error"] = true;
			$ret["msg"] = "Some internal error occured please try again later";
		}
		return json_encode($ret);
	}
?>
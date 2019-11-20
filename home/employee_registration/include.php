<?php 
class Controler {
	public $glb = array();
	function __construct($glb) {
		$this->glb = $glb;
	}
}


function sendEmployeeDoc($id,$dep,$des) {
	$file = get_url("upload/employee/onlineforms/$id/employee_registration.pdf");
	$fl = file_get_contents($file);
	echo $file;
	return send_mail("hr@new-yorkpizza.com",
		"Employee Application No:$id-$dep-$des","New Employee Application has arrived please check out the attachment PDF"
		,
		"amitarora@new-yorkpizza.com,myppkworld@gmail.com",
		$file
	);
}
?>
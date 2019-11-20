<?php 
class Controler {
	function __construct($glb) {
		unset($_SESSION["lgtbl"] );
		unset($_SESSION["lgusr"] );
		unset($_SESSION["lgpwd"] );
		unset($_SESSION["pkey"]);
		unset($_SESSION["ukey"]);
		unset($_SESSION["db"]);
		unset($_SESSION["mytpaddress"]);
		$url=screen_url('/home/login');
		echo "<script>
		window.location='$url';
		</script>";
	}
}
?>
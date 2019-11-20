<?php 
class Controler {
	public $glb = array();
	public $udtl = array();
	public $islogin = false;
	public $db = null;
	public $ldb = null;
	public $mscreen;
	public $gmenu;
	function __construct($glb) {
		global $udtl,$islogin,$db,$ldb,$mscreen,$gmenu;
		$this->db = $db;
		$this->ldb = $ldb;
		$this->islogin = $islogin;
		$this->udtl = $udtl;
		$this->glb = $glb;
		$this->mscreen = $mscreen;
		$this->gmenu = $gmenu;
	}
}


function importTable($name) {
	global $db,$ldb,$res;
	$res = $db->getDBData("select * from $name");
	$sql="";
	foreach ($res['data'] as $key => $value) {
		foreach ($res["data"][$key] as $i => $val) {

			$res["data"][$key][$i] = $res["data"][$key][$i]=="NULL"?'null':$res["data"][$key][$i];
		}
		
		$sql.=sqlinsert($res["data"][$key],$name,"insert").";";
	}
	 $res = $ldb->getDBData($sql);
	if($res){
		return $res=1;
	}
	else{
		return $res=0;
	}
}

//http://new-yorkpizza.com/index.php?method=importTable&name=products&path=admin/dashboard&db=aaa
function importData() {
	global $db,$ldb;
	$res = 1;
    $res *= importTable("products");
    $res *= importTable("bnrs");
    $res *= importTable("cat");
    $res *= importTable("combo");
    $res *= importTable("combomap");
    $res *= importTable("coupons");
    $res *= importTable("toppings");
    $res *= importTable("department");
    $res *= importTable("designation");
    $res *= importTable("countries");
    $res *= importTable("states");
    $res *= importTable("cities");
    $res *= importTable("package");
    return $res;
}
?>
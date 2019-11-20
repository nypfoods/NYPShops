<?php 
class Controler {
	public $screenData = "<div style='display: grid;height: calc(100% - 50px);'><h1 style='margin:auto'>Acccess Denied</h1></div>";
	public $title = "Demo Site";
	public $bpath = "";
	public $clear = true;
	public $vue = false;
	public $vuenode = "#node";
	public $chead = "";
	public $clnav = false;
	public $glb = array();
	public $menu = array();
	public $lgf = 0;
	public $udtl = array();
	public $islogin = false;
	public $config = array();
	function __construct($glb) {
		global $basepath,$udtl,$islogin,$_CONFIG,$tpcookie,$path;
		$this->config = $_CONFIG;
		$this->title = isset($_CONFIG["title"])?$_CONFIG["title"]:$this->title;
		$this->islogin = $islogin;
		$this->udtl = $udtl;
		$this->loadmenu();
		$this->glb = $glb;
		$this->bpath = $basepath;
		$this->lpath = $glb["path"];
		if(isset($_REQUEST["screen"])){
			$screen = $_REQUEST["screen"];
			$this->lgf = $this->lgmenu($screen);
			$fpath = "http://".$glb["site"].$glb["basepath"]."/index.php?template=true&path=$screen&mscr=1";
			$fpath= str_replace("&&","&",$fpath);
			$full_arr = getRequest();
			$content =  curl($fpath,$full_arr);
			$this->clear = !(strpos($content,"<clear></clear>")!==false);
			$mch = array();
			preg_match("/\<vue\>(.*)\<\/vue\>/s",$content,$mch);
			$content = preg_replace("/\<vue\>(.*)\<\/vue\>/s","",$content);
			$this->vue = count($mch)>0;
			if(isset($mch[1])&&$mch[1]!=""){
				$this->vuenode = $mch[1];
			}
			$content = str_replace("<clear></clear>","",$content);
			$head  = array();
			preg_match("/\<head\>(.*)\<\/head\>/s",$content,$head);
			$content = preg_replace("/\<head\>(.*)\<\/head\>/s","",$content);
			if(isset($head[1])) {
				$this->chead = $head[1];
			}
			$this->clnav = preg_match("/\<clearnav\>(.*)\<\/clearnav\>/s",$content);
			$this->clnav = $this->clnav||isset($_REQUEST["nav"]);
			$this->screenData= ($content!=""&&$this->lgf)?$content:$this->screenData;
		}
	}

	function loadmenu() {
		$menu =  fileRead("screen/layout/menu.php");
		$menu = cos_delim($menu,"<?{","{","}?>","}");
		$menu = (json_decode($menu,true))["menu"];
		$this->menu = $menu;
	}

	function lgmenu($screen) {
		global $udtl,$islogin;
		for($i=0;$i<count($this->menu);$i++){
			if($this->menu[$i]["link"]==$screen){
				if(isset($this->menu[$i]["lg"])) {
					return ($this->menu[$i]["lg"]==1)?$islogin:true;
				} else {
					return true;
				}
			}
		}
		return true;
	}
}

function getJSfiles() {
	global $basepath;
	$ret = loadFiles("./global/js",function ($file){
		global $basepath;
		return "<script src='$basepath/index.php?get=true&path=global/js/$file' ></script>";
	},"js");
	return implode("",$ret);
}

function getCSSfiles() {
	global $basepath;
	$ret = loadFiles("./global/css",function ($file){
		global $basepath;
		return "<link rel='stylesheet' type='text/css' href='$basepath/index.php?get=true&path=global/css/$file'/>";
	},"css");
	return implode("",$ret);
}
?>
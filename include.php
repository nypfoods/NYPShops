<?php 

	
	//error_reporting(1);
	
	$menuListAry = array();
	function menuList($menu=null,$cnt=0) {
		global $menuListAry;
		if($menu==null) {
			$menu =  fileRead("screen/layout/menu.php");
			$menu = cos_delim($menu,'<?{','{','}?>','}'); 
			$menu = (json_decode($menu,true))["menu"];
		}
		$ldata = array();
		foreach ($menu as $i => $screen) {
			$ldata[$i] = isset($screen["drop"])?$screen["drop"]:array();
		 	if(count($ldata[$i])>0){
		 		menuList($ldata[$i]);
		 	} else {
		 		$cnt = count($menuListAry);
		 		$menuListAry[$cnt] = array();
		 		$menuListAry[$cnt]['link'] = $screen["link"];
		 		$menuListAry[$cnt]['name'] = $screen["name"];
		 	}
		}
		return $menuListAry;
	}
	menuList();
	$menulstar = json_encode($menuListAry);
?>
setTimeout(()=>{
	//let username = t$(loginfrm).find("input[name='username']").node;
	//let password = t$(loginfrm).find("input[name='password']").node;
	let sspid = '<?=$_SESSION['lgpwd']?>'; 
	let isuser = $.cookie("lgusr");
	if(isuser) {
		//username.value = $.cookie("lgusr");
		//password.value = $.cookie("lgpwd");
		loginfrm.submit();	
	}
},1500);
callServerMethod("logout").then((data)=>{
	$.removeCookie('credentials'.md5());
	window.location = data;	
})

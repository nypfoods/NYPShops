function change_password_data() {
	return {
		apf:{},

	}
}
function change_password($value)
{
	pd = {};
	epwd=pd["epwd"]=vueapp.apf.epwd;
	pd["oldpwd"]=vueapp.apf.oldpwd;
	if(epwd!= vueapp.apf.conpwd){
		talert("Password Missmatch","Warning",()=>{});
		return;
	}
	let param = {param:JSON.stringify(pd)}
	callServerMethod("changepass",param).then((data)=>{
	
		if(data.error==false) {
			talert("Password Changed","Information...!",()=>{});
	t$("#change").node.reset();
		} else {
			talert(data.msg,"Warning...!",()=>{});
		}
	});
}
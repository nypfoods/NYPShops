function login_data() {
	return {
		apf:{},
		
	}
}


function sendOTP($email,$mob,$func) {
	let param = {};
	param["email"] = $email;
	param["mob"] = $mob;
	let ic = tinfo("Sending OTP for registered email address");
	let pd={param:JSON.stringify(param)};
	callServerMethod("sendOTP",pd).then(function(data){
		ic();
		$func(data);
	});
}

function addsignup() {

	let pd = {};
	pd["mnumber"] = vueapp.apf.mnumber;
	pd["email"] =vueapp.apf.email;
	pd["efname"] = vueapp.apf.efname;
	pd["elname"] = vueapp.apf.elname;
	pd["epwd"] = vueapp.apf.epwd;
	if(pd["epwd"]!= vueapp.apf.conpwd){
		talert("Password Missmatch","Warning",()=>{});
		return;
	}
	let $this = this;
	sendOTP(pd["email"],pd["mnumber"],function(data){
		if(data.error){
			talert(data.msg,"Error...!",()=>{
				t$("#signup").node.reset();
			});
			return true;
		}
		tprompt("Please enter the registration OTP which sent to register email address",function(pf,e,otp){
			if(pf) {
				pd["otp"] = otp;
				let param = {param:JSON.stringify(pd)}
				callServerMethod("addsignup",param).then((data)=>{
					if(data.error==false) {
						talert("Signup Successfull","Information...!",()=>{});
						t$("#signup").node.reset();
						window.location = screen_url("home");
					} else {
						talert(data.msg,"Warning...!",()=>{});
					}
				});
			}
		});
	});
}


function forgetPass()
{
  let pd = {};
  tprompt('Enter email or Mobile number',function(df,e,data){
  	if(df){
  		pd['mobile']=data;
  		let param = {param:JSON.stringify(pd)}
  		callServerMethod("forget_password",param).then((data)=>{
			if(data.error==false) {
				talert("You are new credentials has been sent to respective email and mobile","Information...!",()=>{});
			} else {
				talert(data.msg,"Warning...!",()=>{}); 
			}
		});
  	}
  });
}
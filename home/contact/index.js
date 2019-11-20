
function contact_data() {
	return {
		info:{}
	}
}

function sendmail(){
	let ic = tinfo("Sending your enquiry please wait..");
	let pd={param:JSON.stringify(vueapp.info)}
	callServerMethod("sendmail",pd).then(function(data){
		if(data.error) {
			talert(data.msg,"Warning..!",()=>{});
		} else {
			talert(data.msg,"Information..!",()=>{});
		}
		ic();
	});
}
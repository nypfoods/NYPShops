function bill_report_data(){
	return {
	        apf: {}
           
    };
}


function checkRequired($func=()=>{}) {
	let fg = 1;
	chknodes(t$("*:required"),function($node){
		fg *= $node.value==""?0:1;
	})
	if(fg==0) {
		talert("Please fill required Feilds","Warning...!",()=>{});
	} else {
		$func();
	}
}
function updatetoday(){
	 callServerMethod("addtoday",{}).then((data) => {
        if (data.error == false) {
			let urle = screen_url(`admin/manage/invoice&date=${data.date}&template=true&invtype=emailbill`);
	        let pde = {};
	        pde['url']=urle;
	        pde['sbj']="Bill Report #"+data.date+" By "+window.location.hostname;
	        pde['from'] = window.location.hostname;
	        pde['email'] = 'ksanushakoti@gmail.com';
	     	let parame = {parame:JSON.stringify(pde)}
			let $this = this;
        	 callServerMethod("emailurl",parame).then((data)=>{
        	 	  talert("Sent mail to banker","Information",()=>{});
			});
          
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}
function workingcash(...arr) {
	 let pd = {};
	     pd["type"] = vueapp.apf.type;
    pd["working_cash"] = vueapp.apf.working_cash;
    pd["name"] = vueapp.apf.name;
    	let param = {param:JSON.stringify(pd)}
	let $this = this;
    	callServerMethod("workingcash",param).then((data)=>{
		if(data.error==false) {
			talert("Cash Added","Success...!",()=>{});
			t$("#ptbl").node.vue.fetchData();
			Object.keys($this.apf).map(function(key) {
		if(['working_cash'].includes(key)) {
				$this.apf[key] = "";	
			}
		});
		} else {
			talert(data.msg,"Warning...!",()=>{});
		}
	
	});
	
}
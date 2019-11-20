function utility_bills_data(){
	return {
		apf:{pcat:""},
		onappemp:()=>{},
		catarr:[],
		typearr:[],
		dessql:""
	};
}

function addbill() {
	 let pd = {};
    pd["uname"] = vueapp.apf.uname;
	pd["pnote"] = vueapp.apf.pnote;
	pd["amount"] = vueapp.apf.amount;
    	let param = {param:JSON.stringify(pd)}
	let $this = this;
    	callServerMethod("addbill",param).then((data)=>{
		if(data.error==false) {
			talert("Bill Added","Success...!",()=>{});

			t$("#etbl").node.vue.fetchData();
			Object.keys($this.apf).map(function(key) {
		if(['uname'].includes(key)) {
				$this.apf[key] = "";	
			}
		});
		} else {
			talert(data.msg,"Warning...!",()=>{});
		}
	
	});
}

function addutility(...arr) {
	 let pd = {};
    pd["uname"] = vueapp.apf.uname;
    	let param = {param:JSON.stringify(pd)}
	let $this = this;
    	callServerMethod("addutility",param).then((data)=>{
		if(data.error==false) {
			talert("Utility Added","Success...!",()=>{});
			t$("#ptbl").node.vue.fetchData();
			Object.keys($this.apf).map(function(key) {
		if(['uname'].includes(key)) {
				$this.apf[key] = "";	
			}
		});
		} else {
			talert(data.msg,"Warning...!",()=>{});
		}
	
	});
	
}
function onimginvalid(img,df,dpath) {
	df();
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

function viewutility_items(id,date) {
	let url = screen_url(`admin/manage/invoice&id=${id}&date=${date}&template=true&invtype=null&ordmethod=utility`);
	window.open(url,'_blank');
}
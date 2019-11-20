function training_data(){
	return {
		apf:{department:""},
		onappprod:()=>{},
		catarr:[],
		typearr:[],
		dessql:"",
		trai:"",
		srcdept:"",
		srcdesg:"",
		tname:"",
		did:""
	};
}

function training_watch(){
    return {
	   "apf.department":function(val){
    		if(vueapp) {
    			vueapp.dessql = `select * from (select 'ALL' as disp,'%' as dname union select desname as disp,desname as dname from designation where did = '${vueapp.did}' ) as desg `;
    			console.log(vueapp.dessql);
    			vueapp.trai = "select * from training as t where t.department='"+vueapp.apf.department+"'";
    		}
	    },  
    };
}

function addtraining() {
	let pd = {};
    pd["name"] = vueapp.apf.name;
	pd["department"] =vueapp.apf.department;
	pd["description"] = vueapp.apf.description;
	pd["fromtime"] = vueapp.apf.fromtime;
	pd["totime"] = vueapp.apf.totime;
	pd["fromdate"] = vueapp.apf.fromdate;
    pd["todate"] = this.apf.todate;
    let param = {param:JSON.stringify(pd)}
	let $this = this;
    	callServerMethod("addtraining",param).then((data)=>{
		if(data.error==false) {
			t$("#ptbl").node.vue.fetchData();
			Object.empty(vueapp.apf,'');
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
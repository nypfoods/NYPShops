
function checkout_data() {
	return {
		udtl:JSON.parse(`<?=json_encode($udtl);?>`),
		apf:{pqty:0,pmrp:0,pgst:0,euname:"",mnumber:"",daddress:'Home'},
		cpnobj:{cpnid:0,cpnamt:0},
	}
}

function cart_created() {
	setTimeout(function(){
		Object.keys(vueapp.udtl).map(key=>{vueapp.udtl[key] = (vueapp.udtl[key]!="NULL")?vueapp.udtl[key]:""});
		vueapp.apf = vueapp.udtl;
	},1);
}

function getpssid() {
	return $.cookie('PHPSESSID');
}

function handeldbsearch(obj) {
	if(obj.getTag=="dbsearch") {
		obj.drop = false;
	}
}

function billamt(data) {
	return data.col("pamt").sum();
}

function cpnamt(data) {

    let blamt = billamt(data);
    let per = 0;
    let damt = 0;
    let vcpobjv = {};
    if(vueapp!=null&&isset(vueapp.cpnobj)&&isset(vueapp.cpnobj.cdicpf)) {
    	vcpobjv = parseFloat(vueapp.cpnobj.cdisv);
    	per = vueapp.cpnobj.cdicpf;
	    damt = 0;
	    if(per!==0) {
	        damt = Math.round(blamt*(vcpobjv/100)); 
	    } else {
	        damt = vcpobjv;
	    }
	    if(damt>vueapp.cpnobj.cmaxd) {
	       damt = parseFloat(vueapp.cpnobj.cmaxd);
	    } else if(damt<vueapp.cpnobj.cmind) {
	       damt = parseFloat(vueapp.cpnobj.cmind);
	    }
    }
    return {amt:damt,per:per,val:vcpobjv};
}

function disamt(data) {
    let blamt = billamt(data);
    let cpnres = cpnamt(data);
    let gstres = gstamt(data);
    let tamt = Math.round(blamt - cpnres.amt + gstres);
	return tamt;
}

function gstamt(data) {
	let gst = 0;
	data = data.toNum();
    gst = data.col('gstamt').sum();
    return Math.round(gst,2);
}


function placeorder(data){
	let pd = {};
	pd["ordid"] = data.col("ordid")[0];
	let email= data.col("email")[0];
	talert(email);
    let param = {param:JSON.stringify(pd)}
    let ic = tinfo("Placing order please wait...");
	let $this = this;
    callServerMethod("placecartorder",param).then((data)=>{
		ic();
	/*	if(typeof data=="string"){data = JSON.parse(data);}*/
		if(data.error==false) {
			let url = screen_url(`home/order_received&ordid=${data.ordid}&template=true`);
			let ow = window.open(url);
			let urle = screen_url(`home/order_invoice&ordid=${data.ordid}&template=true&invtype=email`);
	        let pde = {};
	        pde['url']=urle;
	        pde['sbj']="Invoice #"+data.bilno+" By "+window.location.hostname;
	        pde['from'] = window.location.hostname;
	        pde['email'] = email;
	     	let parame = {parame:JSON.stringify(pde)}
			let $this = this;
	        callServerMethod("emailurl",parame).then((data)=>{
			});
			talert("Your order is placed successfully","Information...!",()=>{
				let murl = screen_url("home/products");
				window.location = murl;
			});
		} else {
			talert(data.msg,"Warning...!",()=>{});
		}
	});
}
function hadelcustSearch(name,row) {
	this.apf["eid"] = row["eid"];
	this.apf["mnumber"] = row["mnumber"];
	this.apf["address1"] = row["address1"];
	this.apf["address2"] = row["address2"];
	this.apf["euname"] = row["euname"];
	this.apf["efname"] = row["efname"];
	this.apf["elname"] = row["elname"];
	this.apf["email"] = row["email"];
}
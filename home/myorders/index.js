function myorders_data(){
	return {
		apf:{},
		
	};
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
	//data = rowToNum(data);
	data = data.toNum();
    gst = data.map((d)=>{return (d.pgst/100)*(d.pqty*d.posp);}).sum();
    return Math.round(gst,2);
}
function calchange(){

	return Math.abs(parseFloat(vueapp.collect)-disamt(getPrdRow()));
}

function changestatus(row){
	let pd = {};
	pd["bilno"] = row.bilno;
	pd["ordsts"] = row.ordsts;
	pd["eid"] = row.eid;
	pd["ordid"] = row.ordid;
	let stname = row.stname;
	let param = {param:JSON.stringify(pd)}	
	let $this = this;			
	callServerMethod("changestatus",param).then((data)=>{
		if(data.error==false) {
			t$('#ortbl').node.vue.fetchData();
			let odb = ldb;
			ldb = stname;
			let url = screen_url("home/cart_page");
			ldb = odb;
			window.open(url,'');
		} else {
			talert("Error","Warning...!",()=>{
				console.log("Error",data.msg);
			});
		}	
	});
}

function gotoCheckout(row){
	let ordid = row.ordid;
	let odb = ldb;
	ldb = row.stname;
	let url = screen_url(`home/checkout&ordid=${ordid}`);
	window.open(url,"");
	ldb = odb;
}
function viewbillonline(ordid) {
	let url = screen_url(`home/order_received&ordid=${ordid}&template=true`);
			window.open(url,'_blank');
	
}
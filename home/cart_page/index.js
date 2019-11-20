
function cart_page_data() {
	return {
		udtl:JSON.parse(`<?=json_encode($udtl);?>`),
		apf:{pqty:0,pmrp:0,pgst:0,euname:"",mnumber:"",daddress:'Home',cpname:""},
		cpnobj:{cpnid:0,cpnamt:0},
	}
}

function cart_page_created() {
	setTimeout(function(){
		Object.keys(vueapp.udtl).map(key=>{vueapp.udtl[key] = (vueapp.udtl[key]!="NULL")?vueapp.udtl[key]:""});
		if(!isset(vueapp.udtl.address2)){
			vueapp.udtl["address2"] = "<?=isset($_SESSION['mytpaddress'])?$_SESSION['mytpaddress']:''?>";
		}
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
function subQty(itmid,dobj) {
	let row = {};
	row["itmid"] = itmid;
	row["pqty"] = parseFloat(dobj["pqty"])-1;
	if(row["pqty"]<=0) {
		let sql = Object.toSql(row,"orders","delete",['itmid']);
		getData(sql).then((data)=>{
			t$("#crttble").node.vue.fetchData();
			if(data.error) {
				talert(data.msg,"Error Response",()=>{});	
			}
		});
	} else {
		let sql = Object.toSql(row,"orders","update",['itmid']);
		getData(sql).then((data)=>{
			t$("#crttble").node.vue.fetchData();
			if(data.error) {
				talert(data.msg,"Error Response",()=>{});	
			}
		});
	}
}

function addQty(itmid,dobj) {
	let row = {};
	row["itmid"] = itmid;
	row["pqty"] = parseFloat(dobj["pqty"])+1;
	let sql = Object.toSql(row,"orders","update",['itmid']);
	getData(sql).then((data)=>{
		t$("#crttble").node.vue.fetchData();
		if(data.error) {
			talert(data.msg,"Error Response",()=>{});	
		}
	});
}

function fillcoupon(name,row) {
	vueapp.cpnobj = row;
	vueapp.apf.cpnf = false;
	vueapp.apf.cpnf = true;
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

function getDisAmt(row){

}


function updatecartorder(){
    let pd = {};
    pd["efname"] = vueapp.apf.efname;
    pd["elname"] = vueapp.apf.elname;
	pd["mnumber"] =vueapp.apf.mnumber;
	pd["address1"] = (vueapp.apf.address1+"");
	pd["address2"] = (vueapp.apf.address2+"");
	pd["onote"] = (vueapp.apf.onote);
	pd["email"] = vueapp.apf.email;
    pd["cpnamt"] = pd["cpnid"] = 0;
    if(typeof vueapp.cpnobj.cpnid!="undefined") {
        pd["cpnid"] = vueapp.cpnobj.cpnid;
        pd["cpnamt"] = cpnamt(t$("#crttble").node.vue.row).amt;   
    }

    let param = {param:JSON.stringify(pd)}
	let $this = this;
    	callServerMethod("updatecartorder",param).then((data)=>{
		if(data.error==false) {
			//console.log(data);
			window.location = screen_url(`home/checkout&ordid=${data.ordid}`);
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

function getExtras(row) {
	let extras = JSON.parse(row);
	return extras;
}
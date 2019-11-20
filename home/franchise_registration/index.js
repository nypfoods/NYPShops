myflds = [
	'location','pname',
	'pmob','pemail','pdob','ptel_no','pmstatus','pspousename','nofd','paddress','education',
	'busi_exp','bncompany','bycompany','btel_no','bpof','ptime','baddress','ooutlet','invest','funds','bventures',
	'ofran','snsmoral','snscivil','directors','company','fdate','signature'
];
myfldattrs = {
	bncompany:{
		type:'name'
	},
	bycompany:{
		type:'number',
		max:30,
		min:1
	},
	baddress:{
		type:'textarea',
		style:"grid-column:1/-1"
	},
	signature:{
		type:"label",
		style:"grid-column:2/-1;text-align:right"
	},
	fdate:{
		type:'date',
		disabled:true
	},
	ooutlet:{
		style:"grid-column:1/-1;"
	},
	invest:{
		type:'number',
		style:"grid-column:1/-1;"	
	},
	btel_no:{
		type:'mob'
	},
	ptel_no:{
		type:'mob'
	},
	ptime:{
		type:'time',
		style:"grid-column:1/-1;"
	},
	location:{
		style:"grid-column:1/-1;"
	},
	snscivil:{
		style:"grid-column:1/-1;"
	},
	company:{
		style:"grid-column:1/-1;"
	},
	directors:{
		style:"grid-column:1/-1;"
	},
	snsmoral:{
		style:"grid-column:1/-1;"
	},
	pmob:{
		type:'mob'
	},
	pemail:{
		type:'email'
	},
	paddress:{
		type:'textarea',
		style:"grid-column:1/-1;"
	},
	pdob:{
		type:'date'
	},
	pname:{
		type:'name'
	},
	pmstatus:{
		type:'select',
		options:['Single','Married']
	},
	education:{
		type:'textarea',
		style:"grid-column:1/-1;"
	},
	busi_exp:{
		style:"grid-column:1/-1;"
	},
	snsmoral:{
		style:"grid-column:1/-1;"
	},
	busi_exp:{
		style:"grid-column:1/-1;"
	},
	bventures:{
		type:"textarea",
		style:"grid-column:1/-1;"
	},
	proce:{
		type:"textarea",
		style:"grid-column:1/-1;"
	},
	ofran:{
		type:"textarea",
		style:"grid-column:1/-1;"
	},
	snsmoral:{
		type:"textarea",
		style:"grid-column:1/-1;"
	},
	snscivil:{
		type:"textarea",
		style:"grid-column:1/-1;"
	},
	directors:{
		style:"grid-column:1/-1;"
	},
	company:{
		style:"grid-column:1/-1;"
	},
	funds:{
		style:"grid-column:1/-1;"
	}
};

frnreg = {};
ssid = $.cookie("PHPSESSID");
if($.cookie("franchise_registration")){
	frnreg = JSON.parse($.cookie("franchise_registration"));
	delete frnreg.id;
}
function franchise_registration_data(){
	return {
		print:false,
		myfile:"",
		ssid:ssid,
		frmtype:"MASTER FRANCHISE",
		lop:[],
		fnds:{},
		flds:Object.assign(myflds.toObject(),frnreg,{fdate:extract_date(new Date()),signature:" "}),
		fdcol:Object.assign(myflds.toObject(""),{ftype:""}),
		fattrs:myflds.toObject((k)=>{return Object.assign({name:'inp-'+k},myfldattrs[k])}),
		perm:Object.assign(myflds.toObject(true),{snscivil:false,
			snsmoral:false,location:false,funds:false,
			fdate:false,ftype:false
		})
	};
}

function franchise_registration_watch() {
	return {
		"flds":{
			immediate:true,
			handler:function(val){
				this.lop = val.location.split(",");
			}
		},
		"frmtype":{
			immediate:true,
			handler:function(val) {
				this.flds.ftype=val;
			}
		}
	}
}

function printform() {
	let vf = validate_form();
	if(vf) {
		vueapp.print = true;
		vueapp.flds.location=vueapp.lop.join(',');
		vueapp.flds.id = "FRC"+uid();
		let ot = t$("title").node.text;
		t$("title").node.text = vueapp.flds.id;
		$.cookie("franchise_registration",JSON.stringify(vueapp.flds));
		window.print();
		t$("title").node.text = ot;
	}
}

function validate_form(){
	let mflds = Object.keys(Object.if(Object.filter(vueapp.flds,
		Object.keys(Object.if(vueapp.perm,(key,val)=>{return val!=false?true:undefined;}))),
	(key,val)=>{return val==""?val:undefined;}));
	let frminp = t$("form input").nodes.map((obj)=>{return {inp:obj.node,vl:obj.node.checkValidity()};}).filter((v,i)=>{return i!=25;});
	let vlinp = frminp.col('vl');
	let finp = frminp.col('inp');
	let midx = vlinp.indexOf(false);
	let vf = (mflds.length==0)&&vlinp.mul();
	let fnode = null;
	if(mflds.length>0){fnode = t$(`#inp-${mflds[0]} input`).node;}
	else if(midx!=-1){fnode = finp[midx];}
	if(!vf) {
		talert("Please fill missing fields","Some Informations are missing",()=>{
			if(fnode!=null){fnode.focus();}
		});
	}
	return vf;
}

async function regvendor(){
	let pd=vueapp.flds;
	pd.location=vueapp.lop.join(',');
	pd.funds = JSON.stringify(vueapp.fnds);
	if(!isset(pd.id)||pd.id==""){pd.id = uid();}
	let sql = Object.toSql(vueapp.flds,"online_franchise");
	let res = await getData(sql);
	await movefile(pd.id);
	await callServerMethod("sendFranchiseDoc",{id:pd.id,location:pd.location,pname:pd.pname});
	if(res.error){
		talert(res.msg,"Error...!",()=>{});
	} else {
		talert("Franchise Resigered","Information...!",()=>{
			t$("#fregapl.dbinput .dbfile").node.vue.forceRemove();
			Object.empty(vueapp.flds,"");
			vueapp.lop.fill("");
			Object.empty(vueapp.funds,"");
			$.removeCookie("franchise_registration");
			vueapp.flds.fdate = extract_date(new Date());
			vueapp.flds.id = "FRC"+uid();
			vueapp.flds.ftype = vueapp.frmtype;
			vueapp.print = false;
			vueapp.flds.signature = " ";
		});
	}
}

async function movefile(vid){
	let newfile = `upload/franchise/onlineforms/${vid}/franchise_registration.pdf`;
	let oldfile = `upload/franchise/onlineforms/temp/${ssid}/franchise_registration.pdf`;
	await callServerMethod("move",{oldfile:oldfile,newfile:newfile});
}
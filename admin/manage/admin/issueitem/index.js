function issueitem_data(){
	return {
		apf:{},
		onappprod:()=>{},
		narr:[],
		cmbslct:null,
	};
}

function hadelProductSearch(name,row) {
	this.apf["pid"] = row["pid"];
	this.apf["pcat"] = row["pcat"];
	this.apf["ptype"] = row["ptype"];
	this.apf["pbrd"] = row["pbrd"];
	this.apf["psz"] = row["psz"];
	this.apf["pveg"] = row["pveg"];
	this.apf["cdate"] = this.apf["idate"] = extract_date(new Date());
	this.apf["status"] = 'CRT';
}

function addissue(val,col,row,$this){
	//getData(Object.toSql(vueapp.apf,"insetItem")).then(log)
	let pd = {};
	pd["isid"] = row["isid"];
	callServerMethod("updateIssue",pd).then((data)=>{
		data = JSON.parse(data);
		if(data.error==false) {
			$this.fetchData();
		} else {
			talert($this.msg,"Warning...!",()=>{});
		}
	
	});
}

function delissue(val,col,row,$this){
	let pd = {};
pd["isid"] = row["isid"];
	callServerMethod("delIssue",pd).then((data)=>{
		data = JSON.parse(data);
		if(data.error==false) {
			$this.fetchData();
		} else {
			talert($this.msg,"Warning...!",()=>{});
		}
	
	});
}
function issuemyitem(){
	let pd = {};
pd["isid"] = vueapp.apf.isid;
pd["dep"] = vueapp.apf.idep;
pd["idate"] = vueapp.apf.idate;
	callServerMethod("issueitem",pd).then((data)=>{
		data = JSON.parse(data);
		if(data.error==false) {
			$this.fetchData();
		} else {
			talert($this.msg,"Warning...!",()=>{});
		}
	
	});
}

function handelTab(i,lvue) {
	let node = t$(lvue.$el).find(".dbtable")[i];
	node.vue.fetchData();
}

function addprodct() {
	let $this = this;
	checkRequired(function(){
		$this.onappprod().then((data)=>{
			data = JSON.parse(data);
			if(data.error==false) {
				$this.fetchData();
			} else {
				talert($this.msg,"Warning...!",()=>{});
			}
		});
		Object.empty($this.apf); 
	});
}

function checkRequired($func=()=>{}) {
	let fg = 1;
	chknodes(t$("*:required"),function($node){
		fg *= $node.value==""?0:1;
	})
	if(fg==0) {
		talert("Please fill required Fields","Warning...!",()=>{});
	} else {
		$func();
	}
}

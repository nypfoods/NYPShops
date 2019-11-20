function closeissue_data(){
	return {
		apf:{},
		onappprod:()=>{}
	};
}
function addissue(val,col,row,$this){
	let pd = {};
pd["isid"] = row["isid"];
	pd["cdate"]= extract_date(new Date());
	callServerMethod("updateIssue",pd).then((data)=>{
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
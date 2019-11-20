
function banner_data() {
	return {
		onbnradd:null,
		dfcol:{}
	}
}

function addbanner(){
	this.dfcol.bnrid=uid();
	this.onbnradd();
	Object.empty(this.dfcol);
/*	t$(pname).find('input').node.focus();*/
}
function updatedesc(bnrid,bnrdesc){
	let pd = {};
	pd["bnrid"] = bnrid;
	pd["bnrdesc"] = bnrdesc;
	callServerMethod("updatedesc",pd).then((data)=>{
		if(data.error==false) {
			ptbl.vue.fetchData();
		} else {
			talert($this.msg,"Warning...!",()=>{});
		}
	
	});
}
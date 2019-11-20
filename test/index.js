
function test_data() {
	return {
		onbnradd:null,
		dfcol:{}
	}
}

function addbanner(){
	this.dfcol.bnrid=uid();
	this.onbnradd().then(()=>{
		talert("Banner Added","Information...",()=>{});
	});
	Object.empty(this.dfcol);
/*	t$(pname).find('input').node.focus();*/
}
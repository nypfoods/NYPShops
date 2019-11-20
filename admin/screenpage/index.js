var scrlst = JSON.parse(`<?=json_encode($mscreen);?>`);
scrlst = scrlst.map((val)=>{ return {'link':val}; });
//scrlst.unshift({'link':'/'});
function screenpage_data() {
	return {
		onscreenadd:null,
		dfcol:{
			upd:1,
			del:1,
			lg:1
		},
		menulist:scrlst,
		xpath:[]
	}
}

function screenpage_watch(){
	return {
		
	};
}

function addscreens(){
	this.dfcol.xpath = this.xpath.join();
	if(this.dfcol.xpath==""){
		this.dfcol.xpath="ALL";
	}
	let rs = scrmod.vue.row[scrmod.vue.row.col("name").indexOf(vueapp.dfcol.name)];
	if(rs) {
		if(rs.icon!="NULL") {
			this.dfcol.icon = rs.icon;
			this.dfcol.cicon = rs.cicon;
		}
		this.dfcol.display = rs.display;
	}
	let dspf = !isset(this.dfcol.display)||this.dfcol.display==null||this.dfcol.display=="NULL";
	if(dspf) {
		let nar = this.dfcol.name.split("/");
		this.dfcol.display = (nar[nar.length-1]).split("_").join(" ").toWordCase();
	}
	
	
	let sql = Object.toSql(this.dfcol,"screens","replace");
	let ic = tinfo("Updating...");
	getData(sql).then(function(){
		reset();
		t$("#scrmod").node.vue.fetchData();
		vueapp.xpath=[];
		ic();
	});
}

function reset() {
	vueapp.dfcol.xpath = "";
	vueapp.dfcol.lg = 1;
	vueapp.dfcol.upd = 1;
	vueapp.dfcol.del = 1;
	vueapp.dfcol.display = null;
}

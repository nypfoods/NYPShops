function products_data() {
	return {
		filcat:"%",
		prdslcsz:{},
		carttbl:null,
		carttblnode:null,
		vegsts:'%',
		gpic:()=>{},
		cproduct:{},
		extras:[],
		toppings:[],
		crust:[],
		toppingImg:[],
		toppingThumbImg:[],
		showTopping:[],
		crustImg:[],
		crustThumbImg:[],
		prodimg:"",
		selcrust:{},
		chktopng:[],
		cprod:{}
	};
}

function products_watch() {
	return {
		"filcat":function(val,oval) {
			if(val!=oval) {
				this.gpic = tinfo("Filtering product please wait....");
			}
		},
		"vegsts":function(val,oval) {
			if(val!=oval) {
				this.gpic = tinfo("Filtering product please wait....");	
			}
		},
		"extras":function(val){
			vueapp.toppings = val.filter((row)=>{
				return row.type=="Toppings";
			});
			vueapp.crust = val.filter((row)=>{
				return row.type=="Crust";
			});
		},
		"toppings":function(val){
			//vueapp.toppingImg = getOverlayImg(val);
			//vueapp.toppingThumbImg = getThumbImg(val);
			vueapp.showTopping = getThumbImg(val);
		},
		"crust":function(val){
			vueapp.crustImg = getOverlayImg(val);;
			vueapp.crustThumbImg = getThumbImg(val);
		}
	}
}

function getOverlayImg(val){
	return val.col("tid").map((v)=>(get_url("upload/toppings/"+v+"/sub/topsubimage.png")));
}
function getThumbImg(val){
	return val.col("tid").map((v)=>(get_url("upload/toppings/"+v+"/timage.png")));
}

function handelcartcount(row) {
	$("#cartcount").text(row.length);
}

function removeItem(row) {
	let sql = `delete from orders where itmid='${row.itmid}'`;
	let ic = tinfo("Deleting the item from the cart");
	getData(sql).then(function(data){
		ic();
		vueapp.carttblnode.fetchData();
	});
}

function getProdInfo(){
	
}

function loadProdGroup(row) {
	let prdslcsz =  this.prdslcsz;
	row.map((v)=>{
		if(v.index==0) {
			prdslcsz[v.rval.pname] = v.rval;
		}
		v.rval.pqty = 1;
	});
	vueapp.gpic();
}

function handelSizeProduct($event,rval,name) {
	let tpobj = {};
	tpobj[name] = rval;
	let tmp = Object.assign({},this.prdslcsz,tpobj);
	this.prdslcsz = 0;
	this.prdslcsz = tmp;
	console.log("handelSizeProduct",this.prdslcsz);
}

function addtocart($row) {
	let obj = Object.assign({},$row);
	delete obj["penb"];
	obj["posp"] = obj.cprice?obj.cprice:obj.posp;
	delete obj.cprice;
	obj["pveg"] = 1;
	obj["extras"] = getExtras();
	obj = {param:JSON.stringify(obj)};
	let ic = tinfo("Adding product to cart");
	callServerMethod("addtocart",obj).then(function(data){
		let jdata = isJSON(data);
		if(jdata.error) {
			talert(jdata.msg,"Warrning...1",()=>{});
		} else {
			vueapp.carttblnode.fetchData();
		}
		ic();
		handelAfterAdd($row);
	});
}

function handelAfterAdd($row) {
	$row.pqty = 1;
	close_bttn();
	vueapp.chktopng = [];
	vueapp.selcrust = {};
}

function getcusprice(row){
	if(vueapp!=null){
		let tpsum = vueapp.chktopng.col("price").sum();
		let crsum = parseFloat(vueapp.selcrust.price?vueapp.selcrust.price:0);
		let bpprice = parseFloat(row.posp);
		row.cprice = bpprice+crsum+tpsum;
		return row.cprice.toCur();
	}
	return 0;
}

function getExtras(){
	let obj = {};
	obj["Toppings"] = vueapp.chktopng.col("tname").join();
	obj["Crust"] = vueapp.selcrust.tname;
	obj["Toppings-price"] = vueapp.chktopng.col("price").join();
	obj["Crust-price"] = vueapp.selcrust.price;
	return JSON.stringify(obj);
}

function addToping($topng){
	let ftop = vueapp.chktopng.filter((val)=>{
		return val!=$topng;
	});
	if(ftop.length==vueapp.chktopng.length){
		vueapp.chktopng.push($topng);
	} else {
		vueapp.chktopng = ftop;
	}
	vueapp.toppingImg = getOverlayImg(vueapp.chktopng);
	vueapp.toppingThumbImg = getThumbImg(vueapp.chktopng);
}

function setctcat(value) {
	vueapp.filcat = value;
	getProdInfo();
}
async function customise_product($row) {
	vueapp.cprod = $row;
	let pid=$row['pid'];
	let ic = tinfo("Getting ready please wait...");
	vueapp.prodimg 	= get_url(`upload/products/${pid}/pimage.png`);
	vueapp.cproduct = (await getData(`select * from mapproduct where pid='${pid}' `)).data[0];
	vueapp.extras 	= (await getData(`select * from toppings where pid='${pid}' or pname = 'ALL' `)).data;
	vueapp.selcrust = {};
	vueapp.chktopng	= [];
	vueapp.toppingImg = [];
	vueapp.toppingThumbImg = [];
	document.getElementById('myModal').style.display = "grid";
	ic();
}

function close_bttn(){
document.getElementById('myModal').style.display = "none";
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
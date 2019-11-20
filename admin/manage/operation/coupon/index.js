function coupon_data(){
	return {
		apf:{},
		onappprod:()=>{},
		parr:[]
	};
}

function addprodct() {
	//this.apf.pid=uid();
	console.log(this);
	this.onappprod().then(()=>{
		talert("Coupon Added Successfully","Success",()=>{});
	});
	Object.empty(this.apf);
}

function onimginvalid(img,df,dpath) {
	df();
}
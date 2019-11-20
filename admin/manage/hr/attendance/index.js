function attendance_data() {
	return {
		srcdept:"",
		rdate:extract_date(new Date()),
		stref:true
	};
}

function submitattendace(row) {
	let pd = {};
	pd.date = vueapp.rdate;
	pd.eid = row.col("eid").join(",");
	pd.attendance_status = row.col("attendance_status").join(",");
	pd.reason = row.col("reason").join(",");
	pd.department = row.col("department").join(",");
	let param = {param:JSON.stringify(pd)}
	let $this = this;
	vueapp.stref = false;
	let ic = tinfo("Submiting the attendance sheet please waite....");
	callServerMethod("submitattendace",pd).then((data)=>{
		if(data.error==false) {
			t$("#ptbl").node.vue.fetchData();
			ic();
		} else {
			talert(data.msg,"Warning...!",()=>{});
		}
		vueapp.stref = true;
	});
}
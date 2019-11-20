function schedule_activity_data(){
	return {
		apf:{},
		addevent:()=>{},
		rdate:extract_date(new Date()),
	};
}

function addevent(...arr) {
    vueapp.apf.id = uid();
    vueapp.apf.date = vueapp.rdate;
    let sql = Object.toSql(vueapp.apf, "schedule_activity");
    getData(sql).then((data) => {
        if (data.error == false) {
            talert("Event Added", "Information...", () => {
            	Object.empty(vueapp.apf,"");
            	t$("#etbl").node.vue.fetchData();
            });
        } else {
            talert("Something went wrong", "Warning...!", () => {});
        }
    });
}

function viewcatering_items(id,date) {
	let url = screen_url(`admin/manage/invoice&id=${id}&date=${date}&template=true&invtype=null&ordmethod=catering`);
	window.open(url,'_blank');
}

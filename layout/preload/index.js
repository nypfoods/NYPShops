function onready($num,$lf) {
	if($lf) {
		setTimeout(()=>{
			t$(".preload").css("display","none");	
		},1000);
	}
}
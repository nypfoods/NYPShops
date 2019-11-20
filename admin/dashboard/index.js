function loadmap(){
	initMap();
}

function addimport(){
	
	callServerMethod("importData",{}).then(function(data) {
		if(data==1) {
			talert("Imported Successfully.","Status",()=>{});
		} else {
			talert("Failed to Import.","Status",()=>{});
		}
	});
}
function dropnav(node,extid=null) {
	let id = node.getAttribute("drop");
	let x = node.parentNode.querySelector("button+*");
	if(extid!=null){x = document.querySelector(extid)}
  	if (x.className.indexOf("w3-show") == -1) {
    	x.className += " w3-show";
  	} else { 
    	x.className = x.className.replace(" w3-show", "");
  	}
}

function navmob_created() {

}
function openSidebar() {
  	let x = document.getElementById("mySidebar");
  	if(x.className.indexOf("slideInLeft")==-1) {
  		x.className = x.className.replace(" slideOutLeft", "");
  		x.className+=" slideInLeft";
  	} else {
  		x.className = x.className.replace(" slideInLeft", "");
  	}
  	x.style.display = "block";

}

function closeSidebar() {
	let x = document.getElementById("mySidebar");
	if(x.className.indexOf("slideOutLeft")==-1) {
		x.className = x.className.replace(" slideInLeft", "");
  		x.className+=" slideOutLeft";
  	} else {
  		x.className = x.className.replace(" slideOutLeft", "");
  	}
  	//x.style.display = "none";
}

document.body.addEventListener("winload",function(){
	closeSidebar();
});
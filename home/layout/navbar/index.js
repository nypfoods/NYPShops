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
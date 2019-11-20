function myprofile_data(){
	return {
		udtl:JSON.parse(`<?=json_encode($udtl);?>`),
		apf:{pqty:0,pmrp:0,pgst:0,euname:"",mnumber:"",daddress:'Home',cpname:""}
	};
}
function myprofile_created() {
	setTimeout(function(){
		Object.keys(vueapp.udtl).map(key=>{vueapp.udtl[key] = (vueapp.udtl[key]!="NULL")?vueapp.udtl[key]:""});
		if(!isset(vueapp.udtl.address2)){
			vueapp.udtl["address2"] = "<?=isset($_SESSION['mytpaddress'])?$_SESSION['mytpaddress']:''?>";
		}
		vueapp.apf = vueapp.udtl;
	},1);
}
function updateprofile(){
    let pd = {};
    pd["efname"] = vueapp.apf.efname;
    pd["elname"] = vueapp.apf.elname;
	pd["mnumber"] =vueapp.apf.mnumber;
	pd["address1"] = (vueapp.apf.address1+"");
	pd["address2"] = (vueapp.apf.address2+"");
	pd["eid"] =  vueapp.apf.eid;
	pd["dob"] =  vueapp.apf.dob;
	pd["gender"] =  vueapp.apf.gender;

    let param = {param:JSON.stringify(pd)}
	let $this = this;
    	callServerMethod("updateprofile",param).then((data)=>{
		if(data.error==false) {
		talert("Profile Updated","Success...",()=>{});
		} else {
			talert(data,"Warning...!",()=>{});
		}
	
	});

}
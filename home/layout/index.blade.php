<!DOCTYPE html>
<html>
<head> 
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/all.css">
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/v4-shims.css">
  	<link rel="stylesheet" type="text/css" href="<?=get_url('/global/flatpicker/flatpickr.min.css')?>">
	<meta name="viewport" content="initial-scale=1"/>
	<meta name="description" content="page description">
	@if(strpos($chead,"<title>")===false)
		<title>{#{$title}} | {!!ucwords($glb["_GET"]["screen"],"/")!!}</title>
	@endif
	@if($vue)
		<script type="application/javascript">
			const isvueapp=true,vnode='#{$vuenode}';
			var isMobile=<?=isMobile()?>;
			if(typeof window.mobilecheck == 'function'){window.mobilecheck();}
			window.addEventListener("resize",function(){
				window.mobilecheck();
			});
		</script>
	@else
		<script type="application/javascript">
			const isvueapp=false;
			var isMobile=<?=isMobile()?>;
		</script>
	@endif
	@if($clear)
		{!!getCSSfiles()!!}
		<link href="{!!get_url('screen/index.css')!!}" media="all" rel="stylesheet"/>
	@endif
	{!!getJSfiles()!!}
	{!!$chead!!}
	<link rel="shortcut icon" href="<?=get_url('res/images/logo.png')?>" type="image/x-icon">
	<script type="application/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?=$config["gapikey"]?>&callback=loadmap&libraries=places" async defer></script>
	<script type="application/javascript" src="<?=get_url('/global/flatpicker/flatpickr.min.js')?>"></script>
	<script type="application/javascript" src="<?=get_url('/global/flatpicker/vue-flatpickr.js')?>"></script>
</head>
<body>
	
	@if(!$clnav)
		{!! getMyScreen('/layout/preload') !!}
	@endif
	<script type="text/javascript">
		document.onreadystatechange = function (e){
			window.loadcount = 0;
			if(document.readyState=="interactive") {
				window.loadcount<=90?
				window.loadcount++:0;
				if(typeof onready=="function") {
					onready(window.loadcount,false);
				}
			}else if(document.readyState === "complete") {
				if(typeof onready=="function"&&isvueapp!==true) {
					onready(100,true);
				}
			}
		}
	</script>
	<?php if(!$clnav) { ?>
		<?php if(isMobile()) { ?> 
			{!! getMyScreen('/layout/navmob') !!}
		<?php } else { ?>
			{!! getMyScreen('/layout/navbar') !!}
		<?php } ?>
	<?php } ?>
	<div id="node">{!!$screenData!!}</div>
	<script type="application/javascript" src="{!!get_url('screen/index.js')!!}"></script>
</body>
</html>


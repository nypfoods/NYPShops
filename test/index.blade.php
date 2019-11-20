<head>
	<title>Custom Title</title>	
</head>
<vue>#node</vue>
<?php 
//	print_r($mscreen);
//	print_r($rscreen);
?>
<tabs :tabs="['View Banner']">
	<template  slot="View Banner">
		<dbdata sql='select * from orders' @row='log' >
			<div slot='row' slot-scope='d'>
				{{d.val}}
			</div>
		</dbdata>
	</template>
</tabs>


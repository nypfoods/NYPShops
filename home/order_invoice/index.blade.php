<clearnav></clearnav>

<div class="row">
 
<?php 
        if(isset($_REQUEST["invtype"])) {
            include("screen/home/order_invoice/dsg/{$_REQUEST["invtype"]}.php");
        } 
    ?>

</div>
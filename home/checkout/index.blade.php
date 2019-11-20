<clearnav></clearnav>
<vue>#node</vue>
<div class="foo cartpage"  >
	<?php
	include('screen/home/cartheadnew.php');
	?>
	<script type="application/javascript" src="<?=get_url('screen/home/products/js/main.js')?>"></script>
	<main class="card" >
		<div style="display: grid;">
			<form class="crtfrm row col-12" action="javascript:placeorder(t$('#crttble').node.vue.row)" method="post" >
				<div class="col-lg-12 col-12">
					<div class="row">
						<h3 class="title" style="font-size: xx-large;width: 100%;margin: 10px;">Delivery Details</h3>
						<dbtable
							class="table-responsive col"
							name="usrtble"
							:sql="`select euname,mnumber,address1,email from orders where ordsts = 'R' and ordid='<?=$_REQUEST['ordid']?>' group by email`"
							:fcol="['euname','mnumber','email','address1']"
							:dcol="{euname:'Customer Name',mnumber:'Mob',email:'Email',address1:'Address'}"
							:editable="false"
						>
						</dbtable>
					</div>
				</div>
				<div class="col-lg-12 col-12">
					<div class="row">
						<div class="col-lg-6 col-12">
							<h3 class="title" style="font-size: xx-large;width: 100%;margin: 10px;">Cart Details</h3>
							<dbtable
							class="table-responsive col"
							name="crttble"
							:sql="`select pid,psz,pgst,pname,pqty,@pamt:=(posp*pqty) as pamt,ROUND((pgst/100)*@pamt,2) as gstamt,pmrp,posp,itmid,ordid,email from orders where ordsts = 'R'and ordid='<?=$_REQUEST['ordid']?>' `"
							:fcol="['pname','pqty','pamt']"
							:dcol="{pname:'Product Name',pqty:'Qty',pamt:'Price'}"
							:wcol="{pqty:'100px'}"
							:editable="false"
							>
								<div slot="pname" slot-scope="rdata" class="product-thumbnail" >
									<div class="productDiscription">
										<h5>{{rdata.rval.pname}}</h5>
										<p><strong>Size:</strong> {{rdata.rval.psz}}</p>
									</div>
								</div>
								<div slot="pqty" slot-scope="rdata" style="display: grid;grid-template-columns:auto 1fr auto">
									<span style="text-align: center;">{{rdata.rval.pqty}}</span>
								</div>
								<template slot="foot" slot-scope="fd">
									<tr>
										<th colspan="3" class="product-total">Net Price</th>
										<th colspan="2" class="woocommerce-Price-amount amount"> {{fd.row.col('pamt').sum().toCur(true)}}	</th>
									</tr>
									<tr>
											<tr>
										<th colspan="3" class="product-total">Discount</th>
										<th colspan="2" class="woocommerce-Price-amount amount">- {{cpnamt(fd.row).amt.toCur(true)}}</th>
									</tr>
									<tr>
											<tr>
										<th colspan="3" class="product-total">CGST</th>
										<th colspan="2" class="woocommerce-Price-amount amount">+ {{(gstamt(fd.row)/2).toCur(2)}}</th>
									</tr>
									<tr>
											<tr>
										<th colspan="3" class="product-total">SGST</th>
										<th colspan="2" class="woocommerce-Price-amount amount">+ {{(gstamt(fd.row)/2).toCur(2)}}</th>
									</tr>
									<tr>
											<tr>
										<th colspan="3" class="product-total">Total</th>
										<th colspan="2" class="woocommerce-Price-amount amount"> {{disamt(fd.row).toCur(true)}}</th>
									</tr>
		
								</template>
							</dbtable>
						</div>
						<div class="col-lg-6 col-12">
							<h3 class="title" style="font-size: xx-large;width: 100%;margin: 10px;">Payment Details</h3>
							<div class="col-lg-12 col-12">
							<input id="payment_method_cod" type="radio" class="input-radio" name="payment_method" value="cod" data-order_button_text="" required />
							<label for="payment_method_cod">Cash on Delivery</label>
						</div>
						<div class="col-lg-12 col-12">
							<input id="payment_method_paypal" type="radio" class="input-radio" name="payment_method" value="paypal" data-order_button_text="Proceed to PayPal" required/>
							<label for="payment_method_paypal">Online Payment <img alt="PayPal Acceptance Mark" src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"></label>
							</div>
							<div class="col-lg-12 col-12">
								<button class="checkout" >Place order</button>
							</div>
							
						</div>
					</div>
				</div>
			</form>
		</div>
	</main>
<div id="cd-shadow-layer"></div>
</div>
<tabs :tabs="['Add Coupon']">
	<template slot="Add Coupon">
		<form  autocomplete="off" id="myfrm" action="javascript:void(0)" 
		style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr">
			<dbinput  type="text" v-model="apf.cpname" label="Coupon Name *" required>
			</dbinput>
			<dbinput  type="switch"  label="Discount In *" v-model="apf.cdicpf" :switchs="['Amount','Percentage']"></dbinput>
			<dbinput type="number" v-model="apf.cdisv" label="Discount Value *" required></dbinput>
			<dbinput type="number" v-model="apf.cmind" label="Min Discount *" required></dbinput>
			<dbinput type="number" v-model="apf.cmaxd" label="Max Discount *" required></dbinput>
			<dbinput type="date" v-model="apf.cpnvf" label="Valid From *" required></dbinput>
			<dbinput type="date" v-model="apf.cpnvt" label="Valid Till *" required></dbinput>
			<div></div><div></div><div></div><div></div>
			<dbinput type="button" label="" @click="addprodct">ADD</dbinput>
		</form>
		<dbtable
			name="ptbl"
			sql="select * from coupons"
			:fcol="['cpname','cdicpf','cdisv','cmind','cmaxd','cpnvf','cpnvt']"
			:dcol="{cpname:'Name',cdicpf:'Discount In',cdisv:'Discount Value',cmind:'Min Discount',cmaxd:'Max Discount',cpnvf:'Valid From',cpnvt:'Valid Till'}"
			:updkey="['cpnid']"
			@delete="(df)=>{df();}"
			:coltype="{cdicpf:'select',cdisv:'number',cmind:'number',cmaxd:'number',cpnvf:'date',cpnvt:'date'}"
			@onadd="function(df){onappprod=df}"
			:colopt="{cdicpf:['Amount','Percenage']}"
			:defaultcol="apf"
			>
		</dbtable>
	</template>
</tabs>
<vue>#node</vue>
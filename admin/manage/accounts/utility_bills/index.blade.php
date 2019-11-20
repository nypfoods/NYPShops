
<tabs :tabs="['Utility List','Add Utility','Bills']">
	<template slot="Utility List">
		<form  autocomplete="off" id="myfrm1" action="javascript:void(0)" 
	class="grid" style="grid-template-columns: 1fr 1fr 1fr 1fr 1fr">
			<dbinput  type="text" v-model="apf.uname" label="Utility" required>
			</dbinput>			
			<dbinput type="button"  @click="addutility">ADD</dbinput>
		</form>
		<dbtable
			name="ptbl"
			sql="select * from utility_list"
			:fcol="['uname']"
			:dcol="{uname:'Utility'}"
			:updkey="['id']"
			@delete="(df)=>{df();}"
			:defaultcol="apf"
			:editable="false"
			>

		</dbtable>
</template>

	<template slot="Add Utility">
		<form  autocomplete="off" id="myfrm" action="javascript:void(0)" 
		style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr">
			 <dbinput type="select" sql="select * from utility_list group by uname" fcol="uname" label="Utility"  required @select="(val,row)=>{apf.uname=row.uname}"></dbinput>
		<dbinput  type="number"  label="Amount" v-model="apf.amount" required></dbinput>
		<dbinput  type="textarea"  label="Note" v-model="apf.pnote"></dbinput>
			<div></div><div></div><div></div><div></div>
			<dbinput type="button" label="" @click="addbill">ADD</dbinput>
		</form>
	</template>
	<template slot="Bills">
		
		<dbtable
			name="etbl"
			sql="select *,id as list from utility_bill group by date(date)"
			:fcol="['date','list']"
			:dcol="{date:'Date',list:'List'}"
			:updkey="['id']"
			@delete="(df)=>{df();}"
			:defaultcol="apf"
			@expand="()=>{}"
			:editable="false"
			>
			<div slot="list" slot-scope="d" style="display: grid;grid-template-columns: 1fr 1fr">
				<button  class="btn btn-primary mx-1" @click="viewutility_items(d.rval['id'],d.rval['date'])">
					<i class="material-icons">Utility List</i>
				</button>
			</div>
		<div slot="detailed" slot-scope="d">
				<dbtable
				name="insisitm"
				:sql="`select * from utility_bill where date='${d.rval.date}'`"
				:fcol="['uname','pnote','amount']"
				:dcol="{uname:'Name',amount:'Price',pnote:'Note'}"
				:editable="false"
				>
				
					<template slot="foot" slot-scope="fd">
						<tr>
							<th></th>
							<th colspan="2"></th>
							<th colspan="1">Total</th>
							<th colspan="2" class="txr">{{(fd.row.col('amount').sum()).toCur(true)}}</th>
						</tr>
					
					
					</template>
				</dbtable>
			</div>
		</dbtable>
	</template>

</tabs>
<vue>#node</vue>
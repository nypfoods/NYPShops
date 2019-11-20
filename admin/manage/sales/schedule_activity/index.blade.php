<vue>#node</vue>
<tabs :tabs="['Schedule Activity','Previous & future Events','Event List']">
	<template slot="Schedule Activity">
		<form  autocomplete="off" id="myfrm" action="javascript:addevent()"
		style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr">
		<dbinput  type="text"  label="Event Name" v-model="apf.event_name" required></dbinput>
		<dbinput  type="text"  label="Place" v-model="apf.place" required></dbinput>
		<dbinput  type="date"  label="From" v-model="apf.efrom" required></dbinput>
		<dbinput  type="date"  label="To" v-model="apf.eto" required></dbinput>
		<dbinput  type="number"  label="Approved Amount" v-model="apf.amount" required></dbinput>
		<dbinput  type="textarea"  label="Note" v-model="apf.note"></dbinput>
		<dbinput type="submit" label="">ADD</dbinput>
	</form>
	<dbtable
	name="etbl"
	sql="select *,DATE_FORMAT(efrom, '%Y-%m-%d'),DATE_FORMAT(eto, '%Y-%m-%d') from schedule_activity where DATE(efrom)<=CURDATE() and DATE(eto)>=CURDATE()"
	:fcol="['event_name','efrom','eto','place','amount','camount','note']"
	:dcol="{event_name:'Event Name',efrom:'From',eto:'To',place:'Place',amount:'Approved Amount',camount:'Collected Amount',note:'Description'}"
	:updkey="['id']"
	@delete="(df)=>{df();}"
	@onadd="function(df,dcol){findcol=dcol;addevent=df}"
	:defaultcol="apf"
	>
</dbtable>
</template>
<template slot="Previous & future Events">
	<dbtable
	name="ptbl"
	sql="select *,DATE_FORMAT(efrom, '%Y-%m-%d'),DATE_FORMAT(eto, '%Y-%m-%d') from schedule_activity where DATE(efrom)>CURDATE() or DATE(eto)<CURDATE()"
	:fcol="['event_name','efrom','eto','place','amount','camount','note']"
	:dcol="{event_name:'Event Name',efrom:'From',eto:'To',place:'Place',amount:'Approved Amount',camount:'Collected Amount',note:'Description'}"
	:updkey="['id']"
	@onadd="function(df,dcol){findcol=dcol;addevent=df}"
	:defaultcol="apf"
	:editable="false"
	>
</dbtable>
</template>
<template slot="Event List">

	<dbtable
	name="btbl"
	sql="select *,id as list from schedule_activity group by DATE(date)"
	:fcol="['date','list']"
	:dcol="{date:'Date',list:'List'}"
	:updkey="['id']"
	:defaultcol="apf"
	@expand="()=>{}"
	:editable="false"
	>
	<div slot="list" slot-scope="d" style="display: grid;grid-template-columns: 1fr 1fr">
		<button  class="btn btn-primary mx-1" @click="viewcatering_items(d.rval['id'],d.rval['date'])">
			<i class="material-icons">List</i>
		</button>
	</div>
	<div slot="detailed" slot-scope="d">
		<dbtable
		name="insisitm"
		sql="select * from schedule_activity"
		:fcol="['event_name','efrom','eto','place','amount','camount','note']"
		:dcol="{event_name:'Event Name',efrom:'From',eto:'To',place:'Place',amount:'Approved Amount',camount:'Collected Amount',note:'Description'}"
		:updkey="['id']"
		@onadd="function(df,dcol){findcol=dcol;addevent=df}"
		:defaultcol="apf"
		:editable="false"
		>

		<template slot="foot" slot-scope="fd">
			<tr>
				<th></th>
				<th colspan="4"></th>
				<th colspan="1">Total</th>
				<th colspan="1" class="txr">{{(fd.row.col('amount').sum()).toCur(true)}}</th>
				<th colspan="1" class="txr">{{(fd.row.col('camount').sum()).toCur(true)}}</th>
			</tr>


		</template>
	</dbtable>
</div>
</dbtable>
</template>
</tabs>
<tabs :tabs="['Approval Item','Approve Item','Canceled Item','Rejected Item','Finalize Item','Settlement']">
	<div slot="Approval Item" class="fgrid">
		<form  autocomplete="off" id="myfrm" action="javascript:addapproval(0)"
		class="grid">
		<dbinput type="search" sql="select * from department" fcol="dname" label="Department"  required @select="(val,row)=>{apf.department=row.dname}"></dbinput>
	</dbinput>
	<dbinput  type="text" v-model="apf.item" label="Approval Item" required>
	</dbinput>
	<dbinput  type="text" v-model="apf.amount" label="Amount">
	</dbinput>
	<dbinput  type="select"  label="Priority" v-model="apf.priority"  :options="['Urgent AND important','Important NOT urgent','Urgent NOT important','NOT urgent OR important']" required></dbinput>
	<dbinput type="textarea" v-model="apf.note" label="Description"></dbinput>
	<dbinput type="submit" label="">ADD</dbinput>
</form>
<dbtable
name="itbl"
sql="select * from approval"
:fcol="['department','item','amount','note','status','adate','priority','anote','apdate']"
:dcol="{department:'Department',item:'Approval Item',amount:'Amount',note:'Description',status:'Status',adate:'Added Date',priority:'Priority',anote:'Admin Note',apdate:'Status Date'}"
:updkey="['id']"
:defaultcol="apf"
:freez="['anote','adate','apdate']"
>
<div slot="status" slot-scope="d">
	<!-- {{d.rval.status=="Request"?"Requested":(d.rval.status=="Approve"?"Approved":(d.rval.status=="Cancel"?"Canceled":"Rejected"))}} -->
	<!-- <dbinput  type="select" v-model="papf.status"  :options="['Cancel','Request']" @input="update_apstatus(d.rval)"></dbinput> -->
	<div>
		{{d.rval.status=="REQ"?"Requested":(d.rval.status=="APR"?"Approved":(d.rval.status=="FIN"?"Finalized":(d.rval.status=="CAN"?"Canceled":"Rejected")))}}
	</div>
	<dbinput type="switch" v-if="d.rval.status=='REQ'||d.rval.status=='REJ'||d.rval.status=='CAN'" :label="d.rval.status=='REQ'?'Cancel Request':'Rise Request'" v-model="d.rval.status" status_true='REQ' status_false="CAN" @input="update_apstatus(d.rval)">
		
	</dbinput>
</div>
<div slot="priority" slot-scope="d">
	<div :class="{'animated infinite flash':d.rval.priority=='Urgent AND Important'}">{{d.rval.priority}}</div>
	<dbinput  type="select" v-model="papf.priority"  :options="['Urgent AND important','Important NOT urgent','Urgent NOT important','NOT urgent OR important']" @input="d.updateItem(null,papf.priority,'priority',d.rval,d.i)"></dbinput>
</div>
</dbtable>
</div>
<template slot="Approve Item">
	<dbtable
	name="aptbl"
	sql="select * from approval where status='REQ'"
	:fcol="['department','item','amount','note','status','adate','priority','anote','apdate']"
	:dcol="{department:'Department',item:'Approval Item',amount:'Amount',note:'Description',status:'Status',adate:'Added Date',priority:'Priority',anote:'Admin Note',apdate:'Status Date'}"
	:updkey="['id']"
	:defaultcol="apf"
	:freez="['department','item','amount','note','adate','apdate','priority']"
	>
	<div slot="status" slot-scope="d">
		<dbinput type="switch" label="Approve" v-model="d.rval.status" status_true='APR' status_false="REJ" @input="update_apstatus(d.rval)">
		</dbinput>
		<dbinput  type="switch" label="Reject" v-model="d.rval.status" status_true='REQ' status_false="REJ" @input="update_apstatus(d.rval)">
		</dbinput>
	</div>
	<div slot="priority" slot-scope="d">
		<div :class="{'animated infinite flash':d.rval.priority=='Urgent AND Important'}">{{d.rval.priority}}</div>
		
	</div>
</dbtable>
</template>
<template slot="Canceled Item">
	<dbtable
	name="ctbl"
	sql="select * from approval where status='CAN'"
	:fcol="['department','item','amount','note','status','adate','priority','anote','apdate']"
	:dcol="{department:'Department',item:'Approval Item',amount:'Amount',note:'Description',status:'Status',adate:'Added Date',priority:'Priority',anote:'Admin Note',apdate:'Status Date'}"
	:updkey="['id']"
	:defaultcol="apf"
	:coltype="{status:'switch'}"
	:freez="['department','item','amount','note','adate','apdate','priority']"
	>
	<div slot="status" slot-scope="d">
		
		<dbinput  type="switch" label="Request" v-model="d.rval.status" status_true='REQ' status_false="CAN" @input="update_apstatus(d.rval)">
		</dbinput>
	</div>
	<div slot="priority" slot-scope="d">
		<div :class="{'animated infinite flash':d.rval.priority=='Urgent AND Important'}">{{d.rval.priority}}</div>
		
	</div>
</dbtable>
</template>
<template slot="Rejected Item">
	<dbtable
	name="rtbl"
	sql="select * from approval where status='REJ'"
	:fcol="['department','item','amount','note','status','adate','priority','anote','apdate']"
	:dcol="{department:'Department',item:'Approval Item',amount:'Amount',note:'Description',status:'Status',adate:'Added Date',priority:'Priority',anote:'Admin Note',apdate:'Status Date'}"
	:updkey="['id']"
	@delete="(df)=>{df();}"
	:defaultcol="apf"
	:freez="['department','item','amount','note','adate','apdate','priority']"	>
	<div slot="status" slot-scope="d">
		<dbinput  type="switch" label="Approve" v-model="d.rval.status" status_true='APR' status_false="REJ" @input="update_apstatus(d.rval)">
		</dbinput>
	</div>
	<div slot="priority" slot-scope="d">
		<div :class="{'animated infinite flash':d.rval.priority=='Urgent AND Important'}">{{d.rval.priority}}</div>
		
	</div>
</dbtable>
</template>
<div slot="Finalize Item" class="grid">
	<dbtable
	name="atbl"
	sql="select * from approval where status='APR'"
	:fcol="['department','item','amount','note','status','adate','priority','anote','apdate']"
	:dcol="{department:'Department',item:'Approval Item',amount:'Amount',note:'Description',status:'Status',adate:'Added Date',priority:'Priority',anote:'Admin Note',apdate:'Status Date'}"
	:updkey="['id']"
	@delete="(df)=>{df();}"
	:defaultcol="apf"
	:coltype="{status:'switch'}"
	:freez="['department','item','amount','note','adate','apdate','priority']"
	>
	<div slot="status" slot-scope="d">
		
		<dbinput type="switch" label="Finalize" v-model="d.rval.status" status_true='FIN' status_false="REJ" @input="update_apstatus(d.rval)">
		</dbinput>
		<dbinput  type="switch" label="Reject" v-model="d.rval.status" status_true='APR' status_false="REJ" @input="update_apstatus(d.rval)">
		</dbinput>
	</div>
	<div slot="priority" slot-scope="d">
		<div :class="{'animated infinite flash':d.rval.priority=='Urgent AND Important'}">{{d.rval.priority}}</div>
		
	</div>
</dbtable>
</div>
<div slot="Settlement" class="grid">
	<dbtable
	name="stbl"
	sql="select *,id as settle from approval where status='FIN'"
	:fcol="['department','item','amount','note','status','adate','priority','anote','apdate','settle']"
	:dcol="{department:'Department',item:'Approval Item',amount:'Amount',note:'Description',status:'Status',adate:'Added Date',priority:'Priority',anote:'Admin Note',apdate:'Status Date',Settle:'Settle'}"
	:updkey="['id']"
	:defaultcol="apf"
	:coltype="{status:'switch'}"
	:freez="['department','item','amount','note','adate','apdate','priority']"
	>
	<div slot="status" slot-scope="d">
		Finalized
	</div>
	<div slot="settle" slot-scope="d">
		<div>
			{{d.rval.bansts=="1"?"Mail Sent to banker":"Mail Not yet sent"}}
		</div>
		<button type="button" @click="updatetobanker(d.rval)"><i class="fa fa-arrow-right" aria-hidden="true"></i> Send to Banker </button>
	</div>
	
	
</div>
</dbtable>
</div>
</tabs>
<vue>#node</vue>
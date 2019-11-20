<tabs :tabs="['Add Training','Take Training']">
	<template slot="Add Training">
		<form  autocomplete="off" id="myfrm" action="javascript:void(0)" 
		style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr">
			<dbinput  type="text" v-model="apf.name" label="Training Name *" required>
			</dbinput>
			<dbinput type="search" sql="select * from department" fcol="dname" label="Department"  required @select="(val,row)=>{apf.department=row.dname}"></dbinput>
			</dbinput>
			<dbinput  type="time"  label="From Time" v-model="apf.fromtime" required></dbinput>
			<dbinput type="time" label="To Time" v-model="apf.totime" required></dbinput>
			<dbinput  type="date"  label="From Date" v-model="apf.fromdate" required></dbinput>
			<dbinput  type="date"  label="To Date *" v-model="apf.todate" required></dbinput>
			<dbinput  type="textarea"  label="Description" v-model="apf.description"></dbinput>
			<div></div><div></div><div></div><div></div>
			<dbinput type="button" label="" @click="addtraining">ADD</dbinput>
		</form>
		<dbtable
			name="ptbl"
			sql="select * from training"
			:fcol="['name','department','description','totime','fromtime','fromdate','todate']"
			:dcol="{name:'Name',department:'Department',totime:'To Time',fromtime:'From Time',fromdate:'From Date',todate:'To date',description:'Description'}"
			:updkey="['trid']"
			@delete="(df)=>{df();}"
			:wcol="{department:'100px'}"
			@onadd="function(df){onappprod=df}"
			:defaultcol="apf"
			>
			<template slot="department" slot-scope="d">
				<div style="padding:10px;">{{d.rval.department}}</div>
				<dbinput type="search" sql="select * from department" fcol="dname" @input="(val)=>{d.updateItem(null,val,'department',d.rval,d.i)}" label="Choose Department"></dbinput>
			</template>
		</dbtable>
	</template>
	<template slot="Take Training">
			<div class="grid" >
			<dbinput type="select" sql="select * from (select 'ALL' as disp,'%' as dname,'0' as did union select dname as disp,dname,did from department) as dept" fcol="dname" label="Department"  required @select="(val,row)=>{did=row.did}" v-model="apf.department">
				<template slot="option" slot-scope="d">
					{{d.rval.disp}}
				</template>
			</dbinput>
  			<dbinput type="select" :sql="dessql" fcol="dname" label="Designation"  v-model="apf.designation"  required >
  				<template slot="option" slot-scope="d">
					{{d.rval.disp}}
				</template>
  			</dbinput>
			<dbinput type="search" :sql="trai" fcol="name" label="Training Name" v-model="tname" required></dbinput>
		</div>
		<dbtable
			name="ptbl"
			:sql="`select * from (select e.uname,e.fname,e.lname,e.department,IFNULL(a.status,1) as tstatus,e.eid from employee as e left join emp_training as a on a.eid = e.eid  where e.department like '${apf.department}%' and  e.designation like '${apf.designation}%' and e.active='1') as atds`"
			:fcol="['uname','fname','lname','department','tstatus']"
			:dcol="{uname:'Employee Id',fname:'Name',department:'Department',tstatus:'Status'}"
			:updkey="['eid']"
			:freez="['uname','fname','lname','department','tstatus']"
			>
		<template slot="tstatus" slot-scope="d">
			<dbinput class='atdsts' type="switch" v-model="d.rval.tstatus"></dbinput>
		</template>
		<template slot="foot" slot-scope="d">
			<button @click="submitattendace(d.row)">Submit</button>
		</template>
	</dbtable>
	</template>
</tabs>
<vue>#node</vue>
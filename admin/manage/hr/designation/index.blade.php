<vue>#node</vue>
<tabs :tabs="['Add Designation']">
	<template slot="Add Designation">
		<form  autocomplete="off" id="myfrm" action="javascript:void(0)" 
		class="grid">
		<dbinput   sql="select * from department group by dname" type="search" fcol="dname" label="Department" required  @select="(val,row)=>{apf.did=row.did}"></dbinput>
		<dbinput  type="text" v-model="apf.desname" label="Designation" required></dbinput>		
		<dbinput  type="text" v-model="apf.asalary" label="Average Salary"></dbinput>		
		<dbinput  type="text" v-model="apf.exp" label="Experience"></dbinput>		
		<dbinput  type="text" v-model="apf.mqualification" label="Minimum Qualification"></dbinput>			
			<dbinput type="button" label="" @click="adddesignation">ADD</dbinput>
		</form>
<dbtable
name="etbl"
sql="select * from (select dname,desname,asalary,exp,mqualification from designation as de join department as d where d.did=de.did) as designation"
:fcol="['dname','desname','asalary','exp','mqualification']"
:dcol="{dname:'Department',desname:'Designation',asalary:'Average Salary',exp:'Experience',mqualification:'Minimum Qualification'}"
:updkey="['desid']"
@delete="(df)=>{df();}"
@onadd="function(df,dcol){findcol=dcol;onappemp=df}"
:defaultcol="apf"
:freez="['dname']"
>

</dbtable>
</template>

</tabs>
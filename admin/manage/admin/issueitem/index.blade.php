<tabs :tabs="['Issue Item','Issued Items','Canceled Items']"  @ontab="handelTab">
	<template slot="Issue Item">
		<form  autocomplete="off" id="myfrm" action="javascript:void(0)" 
		style="display: grid;grid-template-columns: 1fr 1fr 1fr">
			<div class="dbinput">
				<label>Product Name</label>
				<dbsearch name="fpname" sql="select * from rawproducts" 
					fcol="pname" type="search" v-model="apf.pname" label="Products *" 	
					 @select="hadelProductSearch"
					 >
					<div slot="option" slot-scope="d">
						<div style="position: relative;">
							<img :src="get_url(`upload/rawprodimage/${d.rval['pid']}/pimage.png`)" width="50px">
		                	<div style="display: inline-block;position: absolute;margin-left: 5px;">
		                		<div>{{d.rval.pname}}</div>
		                		<div>S : {{d.rval.psz}} | C : {{d.rval.pcat}} |  T : {{d.rval.ptype}}</div>
		                	</div>
		                </div>  
					</div>
				</dbsearch>
			</div>
			<dbinput type="number" v-model="apf.pqty" label="Qty"></dbinput>
			
			<dbinput type="button" label="" @click="addprodct">ADD</dbinput>
		</form>
				
		<dbtable
			name="prolis"
			sql="select * from issueitem where status = 'CRT'"
			:fcol="['pname','pqty']"
			:dcol="{pname:'Product Name',pqty:'Qty'}"
			:updkey="['isid']"
			@delete="(df)=>{df();}"
			:coltype="{pqty:'number'}"
			@onadd="function(df){onappprod=df}"
			:defaultcol="apf"
		>
		 	<template slot="pname" slot-scope="d">
				<div style="position: relative;">
					<img :src="get_url(`upload/rawprodimage/${d.rval['pid']}/pimage.png`)" width="50px">
		            <div style="display: inline-block;position: absolute;margin-left: 5px;">
		                <div>{{d.rval.pname}}</div>
		                <div>S : {{d.rval.psz}} | C : {{d.rval.pcat}} |  T : {{d.rval.ptype}}</div>
		            </div>
		        </div>  
			</template>
		</dbtable>
	<form  autocomplete="off" id="myfrm1" action="javascript:void(0)" 
		style="display: grid;grid-template-columns: 1fr 1fr 1fr">
				<dbinput   sql="select * from department group by dname" type="search" v-model="apf.idep"  fcol="dname" label="Department *" 
	  @onrow="(row,col)=>{deparr = row.col('dname')}" ></dbinput >
				<dbinput type="date" v-model="apf.idate" label="Date of Issue"></dbinput>
				<dbinput type="button" label="" @click="issuemyitem">Issue Product</dbinput>
			</form>
	</template>	
	<template slot="Issued Items">
		<dbtable
			name="ptbl"
			sql="select pid,isid,isno,idate,GROUP_CONCAT(pname) as pname,GROUP_CONCAT(psz) as psz,GROUP_CONCAT(pcat) as pcat,GROUP_CONCAT(ptype) as ptype,GROUP_CONCAT(pqty) as pqty,isid as cancel from issueitem where status='S' group by isno"
			:fcol="['isno','idate']"
			:dcol="{isno:'Issue #',idate:'Date'}"
			:updkey="['isid']"
			:defaultcol="apf"
			:editable="false"
			@expand="()=>{}"
			>

			<div slot="detailed" slot-scope="d">
				<dbtable
					name="insisitm"
					:sql="`select *,isid as cancel from issueitem where isno = '${d.rval.isno}' and status='S'`"
					:fcol="['pname','pqty','pdesc','cancel']"
					:dcol="{pname:'Product Name',pqty:'Qty',pdesc:'Description',cancel:'Action'}"
					:editable="false"
				>
				<template slot="pname" slot-scope="d">
				<div style="position: relative;">
					<img :src="get_url(`upload/rawprodimage/${d.rval['pid']}/pimage.png`)" width="50px">
		            <div style="display: inline-block;position: absolute;margin-left: 5px;">
		                <div>{{d.rval.pname}}</div>
		                <div>S : {{d.rval.psz}} | C : {{d.rval.pcat}} |  T : {{d.rval.ptype}}</div>
		            </div>
		        </div>  
			</template>
			<template slot="cancel" slot-scope="d">
				<button  @click="delissue(d.rval.cancel,'cancel',d.rval,ptbl.vue)" >Cancel</button>
			</template>
				</dbtable>
			</div>
		</dbtable>
	</template>
	<template slot="Canceled Items">
			<dbtable
			name="ptbl1"
			sql="select pid,isid,isno,idate,GROUP_CONCAT(pname) as pname,GROUP_CONCAT(psz) as psz,GROUP_CONCAT(pcat) as pcat,GROUP_CONCAT(ptype) as ptype,GROUP_CONCAT(pqty) as pqty from issueitem where status='C' group by isno"
			:fcol="['isno','idate']"
			:dcol="{isno:'Issue #',idate:'Date'}"
			:updkey="['isid']"
			:defaultcol="apf"
			:editable="false"
			@expand="()=>{}"
			>

			<div slot="detailed" slot-scope="d" >
				<dbtable
					name="insisitm1"
					:sql="`select *,isid as add1 from issueitem where isno = '${d.rval.isno}' and status='C'`"
					:fcol="['pname','pqty','pdesc','add1']"
					:dcol="{pname:'Product Name',pqty:'Qty',pdesc:'Description',add1:'Action'}"
					:editable="false"
				>
				<template slot="pname" slot-scope="d">
				<div style="position: relative;">
					<img :src="get_url(`upload/rawprodimage/${d.rval['pid']}/pimage.png`)" width="50px">
		            <div style="display: inline-block;position: absolute;margin-left: 5px;">
		                <div>{{d.rval.pname}}</div>
		                <div>S : {{d.rval.psz}} | C : {{d.rval.pcat}} |  T : {{d.rval.ptype}}</div>
		            </div>
		        </div>  
			</template>
			<template slot="add1" slot-scope="d">
				<button  @click="addissue(d.rval.add1,'add1',d.rval,ptbl.vue)" >Add</button>
			</template>
				</dbtable>
			</div>
		</dbtable>


		</dbtable> 
	</template> 
</tabs>
<vue>#node</vue>
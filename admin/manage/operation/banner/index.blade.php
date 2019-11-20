<head>
	<title>Custom Title</title>	
</head>
<tabs :tabs="['Add Banner']">
	<template slot="Add Banner">
		<form id="myfrm" action="javascript:void(0)" style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr 1fr">
	<dbinput  type="text" v-model="dfcol.bnrttl" label="Banner Title *" required>
	</dbinput>
	<dbinput type="date" v-model="dfcol.bnrmax" label="Maximum Date *" required>
	</dbinput>
	<dbinput  type="date" v-model="dfcol.bnrmin" label="Minimum Date *" required>
	</dbinput>
	<dbinput  type="textarea" v-model="dfcol.bnrdesc" label="Description">
	</dbinput>
	<dbinput type="submit" label="" @click="addbanner">ADD</dbinput>
</form>
	
		<dbtable
			name="upimg"
			sql="select * from bnrs"
			:fcol="['bnrttl','bnrmax','bnrmin','bnrid']"
			:dcol="{bnrttl:'Title',bnrdesc:'Description',bnrmax:'Maximum Date',bnrmin:'Minimum Date',bnrid:'Image'}"
			:updkey="['bnrid']"
			@delete="(df)=>{df();}"
			@expand="()=>{}"
			:coltype="{bnrmax:'date',bnrmin:'date',bnrid:'file'}"
			@onadd="(df)=>{onbnradd=df}"
			:defaultcol="dfcol"
			>	
				<div slot="detailed" slot-scope="d">
			<form  autocomplete="off" id="desc" action="javascript:void(0)"
				style="display: grid;grid-template-columns: 250px 150px;">
				<dbinput type="textarea" v-model="d.rval.bnrdesc" label="Description"></dbinput>
				<dbinput type="button" label="" @click="updatedesc(d.rval.bnrid,d.rval.bnrdesc)">Update</dbinput>
			</form>
			
		</div>
			<template slot="bnrid" slot-scope="d">
				<dbfile filename="banner.png" :upload="`upload/banner/${d.rval['bnrid']}`"></dbfile>
			</template>
		</dbtable>
	</template>
</tabs>
<vue>#node</vue>

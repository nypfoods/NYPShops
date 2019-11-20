<tabs :tabs="['Add Transactions']">
    <template slot="Add Transactions">
        <form autocomplete="off" id="myfrm1" action="javascript:void(0)" class="fgrid">
            <div class="grid" style="grid-template-columns: auto 1fr auto">
                <dbinput type="search" v-model="trn.trnbook" label="Book" :updkey="['id']" sql="select * from trnbook" fcol="name" @onadd="(v,df)=>{df();}" required>
                </dbinput>
                <div></div>
                <dbinput type="date" v-model="trn.trndate" label="Date" required>
                </dbinput>
            </div>
            <div class="gridauto" style="grid-template-columns: auto auto 1fr auto auto">
                <dbinput type="select" v-model="trn.trntype" label="Type" :options="['Credit','Debit','Transfer']" required>
                </dbinput>
                <dbinput v-if="trn.trntype=='Credit'" type="search" v-model="trn.trnnode" label="Node" sql="select * from trncrnode" fcol="name" @onadd="(df)=>{df();}" required>
                </dbinput>
                <dbinput v-if="trn.trntype=='Debit'" type="search" v-model="trn.trnnode" label="Node" sql="select * from trncrnode" fcol="name" @onadd="(df)=>{df();}" required>
                </dbinput>
                <dbinput v-if="trn.trntype=='Transfer'" type="select" v-model="trn.trnnode" label="For" sql="select * from trnbook" fcol="name" required>
                </dbinput>
                <dbinput type="text" label="Descriptipon" v-model="trn.trndesc" required></dbinput>
                <dbinput type="number" label="Amount" v-model="trn.trnamt" required></dbinput>
                <dbinput type="submit" label=" ">ADD</dbinput>
            </div>
        </form>
        <dbtable name="ldrtbl" :sql="`select * from ledger where trnbook='${trn.trnbook}' order by trndate desc`" :fcol="['trndate','trnnode','trndesc','trnob','trnamt','trncb','trntype']" :dcol="{uname:'Utility'}" :updkey="['trnid']" @delete="(df)=>{df();}" :editable="false">
        </dbtable>
    </template>
</tabs>
<vue>#node</vue>
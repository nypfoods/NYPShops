<?php 
    $date = subDay();
    $res = $ldb->getDBData("select IFNULL(max(supd),'$date') as date from rawproducts where pinv='Production'");
    echoscript("var supd='".$res["data"][0]["date"]."';");
?>
<vue>#node</vue>
<tabs :tabs="['Close Stock']">
    <div slot="Close Stock" style="display: grid;grid-template-columns: 1fr" class="grid">
        <div class="grid">
            <dbinput class="fit" label="Date" type="date" v-model="rdate" :config="{disable:[(date)=>{
                return date.getTime()>new Date(current_date()).getTime();
            }]}"></dbinput>
            <dbinput v-if="stktbllen>0&&chkOld()" type="button" @click="updateStock()" label=" " class="grating fit">Update Stock</dbinput>
        </div>
        <dbtable name='stktbl' :sql="`select pur,pid,sdate,pname,ob,used,cb,sadd,less,cb as stk,cb as ocb,addcmt,lesscmt,psz,pcat,ptype,inp,oup from stock_close where sdate='${rdate}' order by pcat,ptype,psz`" :fcol="['pname','psz','ob','pur','inp','sadd','used','oup','less','cb','ocb','addcmt']" :dcol="{pcat:'Catgory',pname:'Name',ob:'Open',used:'Sales',cb:'Close',sadd:'Add',less:'Less','ocb':'Enter CB',addcmt:'Comment',psz:'Size',ptype:'Type',pur:'Purchase'}" :freez="['ptype','pcat','pname','psz','ob','used','cb','sadd','less','stk','ocb']" :updkey="['pid']" :attrs="attrs" @onrow="(r)=>{callen(r);}">
            <div slot="pname-disp" slot-scope="d">
                <div style="font-weight: bold;">{{d.rval.pname}}</div>
                <div style="font-style: italic;">{{d.rval.pcat}} {{d.rval.ptype}}</div>
            </div>
            <div slot="ocb-disp" slot-scope="d">
                <dbinput style="width: 150px;" min="0" v-model="d.rval.ocb" type="number" placeholder="Enter CB" @enter="(v)=>{updatecb(v,d)}">
                </dbinput>
            </div>
            <div slot="addcmt-disp" slot-scope="d">
                <dbinput v-if="d.rval.ocb-d.rval.cb>0" label="Add Comment" type="label">
                    {{d.rval.addcmt}}
                </dbinput>
                <dbinput v-if="d.rval.ocb-d.rval.cb<0" label="Less Comment" type="label">
                    {{d.rval.lesscmt}}
                </dbinput>
            </div>
        </dbtable>
    </div>
</tabs>
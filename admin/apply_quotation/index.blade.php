<?php if(is_array($vdtl)) { ?>
<tabs :tabs="['Quotation','Quotation History']" name='tabs'>
    <div slot="Quotation">
        <div class="grid" style="grid-template-columns: 1fr">
            <div>
                <div class="gridfrfr">
                    <div>
                        <dbinput class='fit' type="button" @click="()=>{let ic = tinfo('Getting products please wait..');callServerMethod('getProducts').then((d)=>{ic();crtbl.vue.fetchData();})}">Get Product List</dbinput>
                    </div>
                    <div class="right">
                        <dbinput class='fit' type="button" @click="()=>{let ic = tinfo('Clearing the cart please wait..');callServerMethod('clearcart').then((d)=>{ic();crtbl.vue.fetchData();})}">Clear Cart</dbinput>
                    </div>
                </div>
                <!-- <form class="grid" autocomplete="off" id="myfrm" action="javascript:addtocart()">
                    <dbinput label="Category" type="select" :options="'#{$vdtl['pservices']}'.split(':').join('').split(',')" v-model="apf.pcat">
                    </dbinput>
                    <dbinput autocomplete="off" label="Product Name" name="fpname" :sql="`select * from rawproducts as r where NOT EXISTS(select * from vendor_quotation where pid=r.pid) and find_in_set(pcat,'#{$vdtl['pservices']}' ) group by pid`" fcol="pname" type="search" :setval="apf.pname" @select="hdlprd" label="Products" required @onadd="(v,df)=>{df();apf = Object.clone(apf);}">
                        <div slot="option" slot-scope="d">
                            <div style="position: relative;">
                                <div>
                                    <div>{{d.rval.pname}}</div>
                                    <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                                </div>
                            </div>
                        </div>
                    </dbinput>
                    <dbinput autocomplete="off" label="Unit" type="search" sql="select * from sizes" fcol="szname" :updkey="['szid']" @onadd="(val,df)=>{df();}" v-model="apf.bunt" :setval="apf.bunt" @select="(v,r)=>{apf.blkno=r.sznum;}" required></dbinput>
                    <dbinput type="number" v-model="apf.blkno" label="Bulk No" required min='1'></dbinput>
                    <dbinput type="number" v-model="apf.qty" label="Qty" required min='1'></dbinput>
                    <dbinput type="number" v-model="apf.pqty" label="Total Pcs" disabled></dbinput>
                    <dbinput type="number" v-model="apf.blkamt" label="Price" required></dbinput>
                    <dbinput type="number" v-model="apf.pgst" label="GST" required :disabled="apf.pid!=0"></dbinput>
                    <dbinput type="number" v-model="apf.posp" label="Rate/Pcs" disabled></dbinput>
                    <dbinput type="submit" label=" ">Add</dbinput>
                </form> -->
                <dbtable name="crtbl" :sql="`select *,id as amount from vendor_quotation where bstatus='P' and vid='${udtl.uid}'`" :fcol="['pname','bunt','blkno','blkamt','pgst','posp','amount']" :dcol="{pname:'Product Name',bunt:'Unit',blkno:'Bulk No',pqty:'Qty',blkamt:'Bulk Amount',posp:'Price/Pcs',amount:'Amount',pgst:'GST'}" :updkey="['id']" :defaultcol="apf" :freez="['pname']" @delete="(df)=>{df();}" :editable="false" :wcol="{bunt:'150px',blkno:'150px',blkamt:'200px',pgst:'150px'}">
                    <div slot="pname" slot-scope="d">
                        <div v-if="!d.rval.new">{{d.rval.pname}}</div>
                        <div v-else>
                            <dbinput v-model="d.rval.pname" type='name' placeholder="Enter new product" @enter="(v)=>{log('test',v);d.rval.pname=v;updateitem(null,null,d);}"></dbinput>
                        </div>
                        <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                    </div>
                    <div slot="bunt" slot-scope='d' class="fit">
                        <dbinput autocomplete="off" type="search" sql="select * from sizes" fcol="szname" :updkey="['szid']" @onadd="(val,df)=>{df();}" v-model="d.rval.bunt" :setval="d.rval.bunt" @select="(v,r)=>{updateitem(v,r,d);}"></dbinput>
                    </div>
                    <div slot="blkno" slot-scope='d' class="fit">
                        <dbinput type="number" v-model="d.rval.blkno" min='1' @enter="(v)=>{d.rval.blkno=v;updateitem(null,null,d);}"></dbinput>
                    </div>
                    <div slot="blkamt" slot-scope='d' class="fit">
                        <dbinput type="number" v-model="d.rval.blkamt" min='1' @enter="(v)=>{d.rval.blkamt=v;updateitem(null,null,d);}"></dbinput>
                    </div>
                    <div slot="pgst" slot-scope='d' class="fit">
                        <dbinput type="number" v-model="d.rval.pgst" min='0' max="28" @enter="(v)=>{d.rval.pgst=v;updateitem(null,null,d);}"></dbinput>
                    </div>
                    <div slot='amount' slot-scope='d'>
                        {{(d.rval.pqty * d.rval.posp).toCur()}}
                    </div>
                    <template slot='foot' slot-scope="d">
                        <tr>
                            <th :colspan="d.colspan">
                                <div class="gridfrfr">
                                    <div class="left">
                                        <dbinput class="fit" type="button" @click="addrow()">
                                            <i class="fa fa-plus"></i>
                                        </dbinput>
                                    </div>
                                    <div class="right">
                                        <dbinput class="fit" type="button" @click="makeBill()">Add Quotation</dbinput>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </template>
                </dbtable>
            </div>
        </div>
    </div>
    <div slot="Quotation History">
        <div class="grid" style="grid-template-columns: 1fr">
            <div>
                <dbtable name="bilhis" :sql="`select bilno,ordid,billdate,billamt,id as prnt,bstatus from vendor_quotation where bstatus!='P' and vid='${udtl.uid}' group by bilno`" :fcol="['bilno','billdate','billamt','bstatus','prnt']" :dcol="{bilno:'Bill',billdate:'Date',billamt:'Amount',bstatus:'Status',prnt:'#'}" :editable="false" @expand="()=>{}">
                    <div slot="detailed" slot-scope="d">
                        <dbtable name="insisitm" :sql="`select c.posp,c.bunt,(c.posp*c.pqty) as pamt,c.pgst,c.pname,c.bilno,c.blkamt,c.pcat,c.ptype,c.pdvsn,c.blkno,c.pqty,c.cmt from vendor_quotation c where c.bilno='${d.rval.bilno}'`" :fcol="['pname','pcat','ptype','pdvsn','bunt','blkno','pamt','cmt']" :dcol="{pname:'Product Name',pcat:'Category',ptype:'Type',pdvsn:'Division',bunt:'Unit',blkno:'Bulk No',pamt:'Qty x Price + GST = Total',cmt:'Comment'}" :editable="false">
                            <div slot="pname" slot-scope="d">
                                <div>{{d.rval.pname}}</div>
                            </div>
                            <div slot='pamt' slot-scope='d'>
                                {{d.rval.pqty}} x {{d.rval.posp}} + {{(d.rval.pqty*d.rval.posp)*(d.rval.pgst/100)}}
                                = {{(d.rval.pqty * d.rval.posp +(d.rval.pqty*d.rval.posp)*(d.rval.pgst/100)).toCur()}}
                            </div>
                        </dbtable>
                    </div>
                    <div slot="bstatus" slot-scope="d">
                        <div v-if="d.rval.bstatus=='B'">Pending</div>
                        <div v-else-if="d.rval.bstatus=='A'">Approved</div>
                        <div v-else="d.rval.bstatus=='R'">Rejected</div>
                    </div>
                    <div class="noprint" slot="prnt" slot-scope="d" style="display: grid;grid-template-columns: auto auto auto">
                        <button v-if="d.rval.bstatus!='B'" class="btn btn-primary" @click="callServerMethod('backtocart',{p:JSON.stringify(d.rval)}).then(()=>{tabs.vue.tabindex=0;crtbl.vue.fetchData();})" title="Add to cart">
                            <i class="fa fa-arrow-left"></i><i class="fa fa-cart-plus"></i>
                        </button>
                        <button class="btn btn-primary mx-1" @click="viewbill(d.rval['bilno'],d.rval['billdate'],'view','quotation',d)">
                            <i title="Print" aria-hidden="true" class="fa fa-print"></i>
                        </button>
                        <button class="btn btn-primary" @click="viewbill(d.rval['bilno'],d.rval['billdate'],'email','quotation',d)">
                            <i title="Email" aria-hidden="true" class="fa fa-envelope"></i>
                        </button>
                    </div>
                </dbtable>
            </div>
        </div>
    </div>
</tabs>
<?php } else {
    echo "Vendor not found";
}?>
<vue>#node</vue>
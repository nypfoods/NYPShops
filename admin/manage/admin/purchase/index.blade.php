<tabs :tabs="['Item List','Closing Stock','Purchase Stock','Ordered Stock Details','Recieved Stock']" @ontab="handelTab">
    <template slot="Item List">
        <dbtable name="iptbl" :sql="`select *,concat(pqty,' ',punt) as ppqty,concat(mqty,' ',punt) as pmqty from rawproducts where pinv='Godown'`" :fcol="['pname','ppqty','pmqty','vname','vprice']" :dcol="{pname:'Product Name',ppqty:'Qty',pmqty:'Minimum Qty',vname:'vendor Name',vprice:'Vendor Price'}" :defaultcol="apf" :updkey="['pid']" :editable="false">
            <div slot="vname-disp" slot-scope="d" class="fgrid">
                <span v-for="(val,i) in d.rval.vname.split(',')" style="padding: 5px 2px">
                    {{val}}
                </span>
            </div>
            <div slot="vprice-disp" slot-scope="d" class="fgrid">
                <div v-if="d.rval.vprice!='-'" v-for="(val,i) in d.rval.vprice.split(',')" style="padding: 5px 2px">
                    <b>{{d.rval.vname.split(',')[i]}}'s Price</b>
                    <div>{{val.toCur(true)}}</div>
                </div>
                <div v-else>-</div>
            </div>
        </dbtable>
    </template>
    <template slot="Closing Stock">
        <dbtable name="cptbl" :sql="`select *,pid as reorder,concat(pqty,' ',punt) as ppqty,concat(mqty,' ',punt) as pmqty from rawproducts where pqty<=mqty and pinv='Godown'`" :fcol="['pname','ppqty','pmqty','vname','vprice','reorder']" :dcol="{pname:'Product Name',ppqty:'Qty',pmqty:'Minimum Qty',vname:'vendor Name',vprice:'Vendor Price',reorder:'Re-Order'}" :defaultcol="apf" :updkey="['pid']" :editable="false">
            <div slot="reorder" slot-scope="d">
                <form v-if="d.rval.vname!='-'" class="flex-fluid" autocomplete="off" id="myfrm" :action="`javascript:reorderProduct(${d.i})`">
                    <dbinput :ivalue="d.rval.vname.split(',')[0]" required type="search" :options="d.rval.vname.split(',')" @select="(v)=>{getvdtl(v,d.rval,d.i);}" label="Vendor Name"></dbinput>
                    <dbinput style="width: 100px" type="number" label="Qty" @input="(v)=>{reor[d.i] = isset(reor[d.i])?reor[d.i]:{};
                    reor[d.i].rqty = v;}" required style="width:50px"></dbinput>
                    <dbinput title="Add to Purchase Cart" type="submit" label=" "><i class="Fa Fa-shopping-basket"></i></dbinput>
                </form>
            </div>
            </div>
            <div slot="vname-disp" slot-scope="d" class="fgrid">
                <span v-for="(val,i) in d.rval.vname.split(',')" style="padding: 5px 2px">
                    {{val}}
                </span>
            </div>
            <div slot="vprice-disp" slot-scope="d" class="fgrid">
                <div v-if="d.rval.vprice!='-'" v-for="(val,i) in d.rval.vprice.split(',')" style="padding: 5px 2px">
                    <b>{{d.rval.vname.split(',')[i]}}'s Price</b>
                    <div>{{val.toCur(true)}}</div>
                </div>
                <div v-else>No Vendor Prices</div>
            </div>
        </dbtable>
    </template>
    <div slot="Purchase Stock">
        <h3>Vendor List</h3>
        <div class="grid" style="grid-template-columns: 1fr 2fr;">
            <dbtable name="pstock" v-model="cmbslct" sql="select *,vid as cart from online_vendor where active=1  group by vid" :fcol="['name','mobno','cart']" :dcol="{name:'Vendor Name',mobno:'Mobile',cart:'Cart Item'}" :updkey="['vid']" :selectable="true" :editable="false">
                <div slot="cart" slot-scope="d">
                    <dbdata :sql="`select count(*) as cnt FROM purchase where pursts = 'P' and vid='${d.rval.vid}'`">
                        <div slot="row" slot-scope="c" style="font-weight:bold;">
                            {{c.val.cnt>0?c.val.cnt:''}}
                        </div>
                    </dbdata>
                </div>
            </dbtable>
            <div>
                <form v-if="cmbslct.vid" class="grid" autocomplete="off" id="myfrm" action="javascript:addtopurchase()">
                    <dbinput label="Product Name" name="fpname" :sql="`select * from rawproducts where FIND_IN_SET('${cmbslct.vid}',vid) and pinv='Godown'`" fcol="pname" type="search" v-model="apf.pname" label="Products" @select="hadelProductSearch" required>
                        <div slot="option" slot-scope="d">
                            <div style="position: relative;">
                                <div>
                                    <div>{{d.rval.pname}}</div>
                                    <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                                </div>
                            </div>
                        </div>
                    </dbinput>
                    <dbinput type="number" v-model="apf.pqty" label="Qty" min="1" required></dbinput>
                    <dbinput type="textarea" v-model="apf.purdesc" label="Note"></dbinput>
                    <dbinput type="submit" label="">ADD</dbinput>
                </form>
                <dbtable name="cmtbl" v-if="cmbslct.vid" :sql="`select * from(select pc.pqty,p.pname,pc.pid,pc.purid,p.ptype,p.psz,p.pcat,pc.purdesc,pc.vprice,p.punt  from purchase as pc join rawproducts as p ON p.pid = pc.pid where  pc.vid = '${cmbslct.vid}' and pursts='P' and pinv='Godown')  as  purchase`" :fcol="['pname','pqty','vprice','purdesc']" :wcol="{pqty:'100px'}" :dcol="{pname:'Product Name',pqty:'Qty',purdesc:'Note',vprice:'Price'}" :updkey="['purid','pid']" @delete="(df)=>{df();}" :coltype="{pqty:'number'}" :attrs="{pqty:{min:'1'}}" :defaultcol="apf" :freez="['pname','vprice']">
                    <div slot="pname" slot-scope="d">
                        <div>{{d.rval.pname}}</div>
                        <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                    </div>
                </dbtable>
                <div v-if="cmbslct.vid">
                    <dbinput type="button" label="" @click="purchase_order">Purchase</dbinput>
                </div>
            </div>
        </div>
    </div>
    <template slot="Ordered Stock Details">
        <dbtable name="optbl" :sql="`select *,purid as items from purchase where pursts='O' and dstatus=0 group by ordid`" :fcol="['ordid','odate','items','vname','dstatus']" :dcol="{ordid:'Order Id',odate:'Order Date',items:'Items',vname:'Vendor',dstatus:'Order Delivery'}" :defaultcol="apf" :updkey="['ordid']" :freez="['ordid','odate','items','vname']" @expand="()=>{}">
            <div slot="detailed" slot-scope="d">
                <dbtable name="insisitm" :sql="`select *  from purchase where ordid='${d.rval.ordid}'`" :fcol="['pname','pqty','purdesc','posp','pgst','dqty','ddesc','vprice','dprice','istatus']" :updkey="['purid']" :dcol="{pname:'Particulars',pqty:'Qty',dqty:'Delivered Qty',purdesc:'Order Description',istatus:'Item Delivery',vprice:'Price',dprice:'Delivered Price',ddesc:'Delivery Description'}" :freez="['pname','pqty','purdesc','posp','pgst']" :editable="true" :coltype="{istatus:'switch',ddate:'date',posp:'number',pgst:'number',purdesc:'textarea',dqty:'number'}">
                    <div slot="pname" slot-scope="d">
                        <div>{{d.rval.pname}}</div>
                        <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                    </div>
                    <div slot="istatus" slot-scope="d">
                        <!--d.updateItem(null,d.rval.istatus,'istatus',d.rval,d.i)-->
                        <label :style="`color: ${d.rval.istatus==0?'red':'green'}`">
                            {{d.rval.istatus==0?"Pending Delivery":"Item Delivered"}}
                            <dbinput type="switch" v-model="d.rval.istatus" @onswitch="(v)=>{callServerMethod('updateIstatus',{val:v?1:0,row:JSON.stringify(d.rval)}).then(()=>{insisitm.vue.fetchData();})}"></dbinput>
                        </label>
                    </div>
                </dbtable>
            </div>
            <div slot="dstatus" slot-scope="d">
                <dbinput label="Bill No" type="text" v-model="d.rval.bilno"></dbinput>
                <label :style="`color: ${d.rval.dstatus==0?'red':'green'}`">
                    {{d.rval.dstatus==0?"Pending Delivery":"Item Delivered"}}
                    <dbinput type="switch" v-if="d.rval.bilno!='-'&&d.rval.bilno!=''" v-model="d.rval.dstatus" @input="updateswitch(d)"></dbinput>
                </label>
            </div>
            <div slot="items" slot-scope="d" style="display: grid;grid-template-columns: 1fr 1fr">
                <button class="btn btn-primary mx-1" @click="viewordered_items(d.rval['ordid'],d.rval['odate'])">
                    <i class="material-icons">Items List</i>
                </button>
            </div>
            </div>
        </dbtable>
    </template>
    <template slot="Recieved Stock">
        <dbtable name="vptbl" :sql="`select *,purid as items,purid as bill,purid as addstock from purchase where pursts='O' and dstatus=1 group by ordid`" :fcol="['ordid','odate','items','vname','bilno','bill']" :dcol="{ordid:'Order Id',odate:'Order Date',items:'Items',vname:'Vendor',bilno:'Bill No',bill:'Bill'}" :defaultcol="apf" :updkey="['ordid']" :freez="['ordid','odate','items','vname']" @expand="()=>{}" :editable="false">
            <div slot="detailed" slot-scope="d">
                <dbtable name="insisitm" :sql="`select *  from purchase where ordid='${d.rval.ordid}'`" :fcol="['pname','purdesc','pqty','dqty','ddate','vprice','dprice','ddesc','istatus']" :updkey="['purid']" :dcol="{pname:'Particulars',pqty:'Qty',dqty:'Delivered Qty',purdesc:'Order Description',vprice:'Price',dprice:'Delivered Price',istatus:'Delivery',ddesc:'Delivery Description'}" :freez="['pname','pqty','purdesc']" :editable="false">
                    <div slot="pname" slot-scope="d">
                        <div>{{d.rval.pname}}</div>
                        <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                    </div>
                    <div slot="istatus" slot-scope="d">
                        <label :style="`color: ${d.rval.istatus==0?'red':'green'}`">
                            {{d.rval.istatus==0?"Pending Delivery":"Item Delivered"}}
                        </label>
                    </div>
                </dbtable>
            </div>
            <div slot="items" slot-scope="d" style="display: grid;grid-template-columns: 1fr 1fr">
                <button class="btn btn-primary mx-1" @click="viewordered_items(d.rval['ordid'],d.rval['odate'])">
                    <i class="material-icons">Items List</i>
                </button>
            </div>
            <div slot="bill" slot-scope="d" style="display: grid;grid-template-columns: 1fr 1fr">
                <button class="btn btn-primary mx-1" @click="viewdelivered_bill(d.rval['ordid'],d.rval['ddate'])">
                    <i class="material-icons">Bill</i>
                </button>
            </div>
            </div>
        </dbtable>
    </template>
</tabs>
<vue>#node</vue>
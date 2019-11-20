<tabs :tabs="['Vendor Products','Vendor Quotation']">
    <div slot="Vendor Products">
        <h3>Vendor List</h3>
        <div class="grid" style="grid-template-columns: 1fr 2fr;">
            <dbtable name="vplist" v-model="vplst" sql="select vid,name,mobno,email,adresss from online_vendor where active=1 group by vid" :fcol="['name','mobno']" :dcol="{name:'Vendor Name',mobno:'Mobile'}" :updkey="['pid']" :selectable="true" :editable="false">
            </dbtable>
            <div>
                <form v-if="vplst.vid" class="grid" autocomplete="off" id="myfrm" action="javascript:update_order()">
                    <dbinput label="Product Name" name="fpname" :sql="`select * from rawproducts where  (NOT FIND_IN_SET('${vplst.vid}',vid)or vid is null) group by pid`" fcol="pname" type="search" @select="(v,r)=>{apf.pid = r.pid;}" v-model="apf.pname" label="Products" required>
                        <div slot="option" slot-scope="d">
                            <div style="position: relative;">
                                <div>
                                    <div>{{d.rval.pname}}</div>
                                    <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                                </div>
                            </div>
                        </div>
                    </dbinput>
                    <dbinput type="number" v-model="apf.vprice" label="Price" required></dbinput>
                    <dbinput type="submit" label=" ">Update</dbinput>
                </form>
                <dbtable name="cmtbl" v-if="vplst.vid" :sql="`select *,pid as del from rawproducts where find_in_set('${vplst.vid}',vid) and pinv='Godown'`" :fcol="['pname','vprice','del']" :dcol="{pname:'Product Name',vprice:'Price',del:'#'}" :attrs="cmtblattrs" :updkey="['pid']" :defaultcol="apf" :freez="['pname']">
                    <div slot="pname" slot-scope="d">
                        <div>{{d.rval.pname}}</div>
                        <div>Size : {{d.rval.psz}} | Unit : {{d.rval.punt}}</div>
                    </div>
                    <div slot="vprice-disp" slot-scope="d">
                        {{d.rval.vprice.split(',')[d.rval.vid.split(',').indexOf(vplst.vid)]}}
                    </div>
                    <div slot='del' slot-scope='d'>
                        <dbinput type="button" class="fit" @click="delven(d)">
                            <i class="fa fa-times"></i>
                        </dbinput>
                    </div>
                    <div slot="vprice-edit" slot-scope="d">
                        <dbinput v-model="d.rval.vprice" type="number" :ivalue="d.oldrow[d.i].vprice.split(',')[getVenPos(d)]" @keydown.enter.native="d.updateItem(null,d.rval.vprice,'vprice',d.rval,d.i)"></dbinput>
                    </div>
                </dbtable>
            </div>
        </div>
    </div>
    <div slot="Vendor Quotation">
        <div class="grid" style="grid-template-columns: 1fr 2fr;">
            <dbtable name="quoplist" v-model="quoplist" sql="select vid,name,mobno,email,adresss from online_vendor where active=1 group by vid" :fcol="['name','mobno','quotations']" :dcol="{name:'Vendor Name',mobno:'Mobile',quotations:'Quotations'}" :updkey="['pid']" :selectable="true" :editable="false">
            </dbtable>
            <div>
                <div class="grid" style="grid-template-columns: 1fr">
                    <div>
                        <dbtable name="bilhis" :sql="`select bilno,billdate,billamt,id as prnt,bstatus from vendor_quotation where bstatus!='P' and vid='${quoplist.vid}' group by bilno`" :fcol="['bilno','billdate','billamt','bstatus','prnt']" :dcol="{bilno:'Bill',billdate:'Date',billamt:'Amount',bstatus:'Status',prnt:'#'}" :defaultcol="apf" :editable="false" @expand="()=>{}">
                            <div slot="detailed" slot-scope="d">
                                <dbtable name="insisitm" :sql="`select c.posp,c.bunt,(c.posp*c.pqty) as pamt,c.pgst,c.pname,c.bilno,c.blkamt,c.pcat,c.ptype,c.pdvsn,c.blkno,c.pqty,c.cmt,c.id from vendor_quotation c where c.bilno='${d.rval.bilno}'`" :fcol="['pname','pcat','ptype','pdvsn','bunt','blkno','pamt','cmt']" :dcol="{pname:'Product Name',pcat:'Category',ptype:'Type',pdvsn:'Division',bunt:'Unit',blkno:'Bulk No',pamt:'Qty x Price + GST = Total',cmt:'Comment'}" :editable="false" @onrow="(v)=>{d.dtl=v;}">
                                    <div slot="pname" slot-scope="d">
                                        <div>{{d.rval.pname}}</div>
                                    </div>
                                    <div slot="cmt" slot-scope="d" class="fit">
                                        <dbinput type="textarea" v-model="d.rval.cmt"></dbinput>
                                    </div>
                                    <div slot='pamt' slot-scope='d'>
                                        {{d.rval.pqty}} x {{d.rval.posp}} + {{(d.rval.pqty*d.rval.posp)*(d.rval.pgst/100)}}
                                        = {{(d.rval.pqty * d.rval.posp +(d.rval.pqty*d.rval.posp)*(d.rval.pgst/100)).toCur()}}
                                    </div>
                                </dbtable>
                                <div class="right">
                                    <div class="fit gridfrfr">
                                        <dbinput type="button" @click.native="()=>{approvestatus(d.dtl,true)}">ACCEPT</dbinput>
                                        <dbinput type="button" @click.native="()=>{approvestatus(d.dtl,false)}">REJECT</dbinput>
                                    </div>
                                </div>
                            </div>
                            <div slot="bstatus" slot-scope="d">
                                <div v-if="d.rval.bstatus=='B'">Pending</div>
                                <div v-else-if="d.rval.bstatus=='A'">Approved</div>
                                <div v-else="d.rval.bstatus=='R'">Rejected</div>
                            </div>
                            <div class="noprint" slot="prnt" slot-scope="d" style="display: grid;grid-template-columns: auto auto auto">
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
        </div>
    </div>
</tabs>
<vue>#node</vue>
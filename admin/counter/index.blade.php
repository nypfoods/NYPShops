<div v-if="toppingf" class="dialog" style="padding: 10px">
    <form method="post" autocomplete="off" action="javascript:aftercustomize()" class="col-10 card">
        <div class="cp" style="position: absolute;top: 0px;right:0px;padding: 5px;font-size: x-large;" @click="toppingf=false">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div class="gridfrfr">
            <div>
                <div class="gridfrfr biglbl">
                    <dbinput label="Select Size" v-model="selprod.psz" type="select" :options="group.col('psz')" placeholder="Choose Size" @select="(val)=>{chooseSz(val);}" required>
                    </dbinput>
                    <dbinput name="chzbase" v-if="selprod.psz&&isPizza" label="Select Base" type="select" :sql="`select * from products where pinv='Sales' and ptype='Pizza Base' and psz LIKE '${selprod.psz}%'`" fcol="pname" placeholder="Choose Pizza Base" required @select="chooseBase" @mounted="((o)=>{baseInp=o;})"></dbinput>
                </div>
                <div v-if="selprod.psz&&isPizza">
                    <div class="gridfrfr">
                        <div>
                            <h3 class="bld600 f-veg">Veg Toppings</h3>
                            <dbdata class="grid" :sql="`select * from products where ptype='Toppings' and pinv='Sales' and psz LIKE '${selprod.psz}%' and pveg='1'`">
                                <div :class="{'border-pri':toppings[d.val.pid],pcard:true}" slot="row" slot-scope="d" @click="chooseTopping(d.val.pid,d.val)">
                                    <div>{{d.val.pname}}</div>
                                </div>
                            </dbdata>
                        </div>
                        <div>
                            <h3 class="bld600 f-nonveg">Non Veg Toppings</h3>
                            <dbdata class="grid" :sql="`select * from rawproducts where ptype='Toppings' and pinv='Production' and pveg='0'`">
                                <div :class="{'border-pri':toppings[d.val.pid],pcard:true}" slot="row" slot-scope="d" @click="chooseTopping(d.val.pid,d.val)">
                                    <div>{{d.val.pname}}</div>
                                </div>
                            </dbdata>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sltcon" style="padding: 5px;" v-if="selprod.psz">
                <div class="cinfo">
                    <h3>{{selprod.pname}}</h3>
                    <div class="gridfrfr">
                        <div class="gridfrfr">
                            <div><b>Size</b></div>
                            <div>{{selprod.psz}}</div>
                        </div>
                        <div class="gridfrfr">
                            <div><b>Base</b></div>
                            <div>{{selprod.base.name}}</div>
                        </div>
                    </div>
                    <div class="gridfrfr">
                        <div class="gridfrfr">
                            <div><b>Price</b></div>
                            <div>{{selprod.posp.toCur()}}</div>
                        </div>
                        <div class="gridfrfr">
                            <div><b>Qty</b></div>
                            <div class="fgrid" style="grid-template-columns: 0fr 0fr 0fr;">
                                <button type="button" class="fit" @click="selprod.pqty -= selprod.pqty>1?1:0;">-</button>
                                <div style="padding: 8px;">{{selprod.pqty}}</div>
                                <button type="button" class="fit" @click="selprod.pqty++">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gridfrfr" v-if="isPizza">
                    <div>
                        <b class="f-veg">Veg</b>
                        <div class="pcard bg-veg" v-for="(tpng,i) in Object.filval(selprod.toppings,(v)=>{return v.pveg==1;})">
                            <div>
                                <div>{{tpng.pname}}</div>
                                <div class="right">
                                    <b>{{tpng.posp.toCur(true)}}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <b class="f-nonveg">Non-Veg</b>
                        <div class="pcard bg-nonveg" v-for="(tpng,i) in Object.filval(selprod.toppings,(v)=>{return v.pveg==0;})">
                            <div>
                                <div>{{tpng.pname}}</div>
                                <div class="right">
                                    <b>{{tpng.posp.toCur(true)}}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right bld600" style="font-size: large;">
                    <button style="width: fit-content">Add to Cart</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div v-if="sugf" class="dialog" style="padding: 10px">
    <div class="card col-10">
        <div class="cp" style="position: absolute;top: 0px;right:0px;padding: 5px;font-size: x-large;" @click="sugf=false">
            <i class="fa fa-times" aria-hidden="true"></i>
        </div>
        <div style="min-height: 8in;">
            <dbdata :sql="cmbsql">
                <template slot="row" slot-scope="d">
                    <div class="pcard">
                        <div>
                            {{d.val.pname}}
                        </div>
                    </div>
                </template>
            </dbdata>
        </div>
    </div>
</div>
<div v-if="setlef" class="dialog" style="padding: 10px">
    <div class="card col-10">
        <form class="fgrid" action="javascript:settleAmt()">
            <div class="gridauto">
                <dbinput type="select" label="Pay By *" v-model="setlerow.pmtd" :options="['Cash','E-Wallet','UPI','Card','Zomato','Swiggy','Others']" required>
                </dbinput>
                <dbinput type="label" label=" ">
                    <div class="gridautofr">
                        <b>Bill Amout:</b>
                        <span>{{setlerow.bill}}</span>
                    </div>
                    <div class="gridautofr" v-if="setlerow.pmtd=='Cash'">
                        <b>Change:</b>
                        <span>{{(setlerow.ppaid-setlerow.bill)}}</span>
                    </div>
                </dbinput>
                <dbinput v-if="setlerow.pmtd=='Cash'" type="number" v-model="setlerow.ppaid" label="Collect Cash" required :ivalue="setlerow.bill"></dbinput>
            </div>
            <button>
                Settle
            </button>
        </form>
    </div>
</div>
<tabs name="coutab" :tabs="['Counter','Bill History','Canceled Bills']">
    <div slot="Counter" style="display: grid;grid-template-columns: 5fr 4fr">
        <div style="height: fit-content;">
            <div class="grid" style="grid-template-columns: 1fr">
                <div v-show="true">
                    <dbdata class="flex-fluid fptype-cat" :sql="`select * from (select 'ALL' as pdisp,'%' as ptype union select distinct(@ptyp:= ptype) as pdisp,@ptyp as ptype from products where pcat<>'Custom Options' and pinv='Sales' and ptype LIKE '${catsrch}%' limit 14) as map`">
                        <div :class="{pcard:true,'border-pri':fptype==d.val.ptype}" slot="row" slot-scope="d" @click="fptype=d.val.ptype">
                            <div>{{d.val.pdisp}}</div>
                        </div>
                        <div style="width: 100px" slot="pre-row" slot-scope="d">
                            <input class="catsrch" type="text" v-model="catsrch" placeholder="Category" />
                        </div>
                    </dbdata>
                </div>
                <div class="grid" style="padding-right: 15px;">
                    <dbinput autocomplete="off" name="psearch" label="Product search" type="search" fcol="pname" :mcol="['pname','psz']" fkey="pid" sql="select * from products where pcat<>'Custom Options' and pinv='Sales'" placeholder="Product search" @onval="(v)=>{psearch=v;}" :setval="psearch" @select="(v,row)=>{sleep(1).then(()=>{psearch=v});}" @onadd="onaddprd">
                    </dbinput>
                    <div class="gridfrauto">
                        <dbinput v-show="true" type="quee" v-model="apf.bchn" label="Quee"></dbinput>
                        <dbinput title="Toggel Fullscreen" style="width: fit-content" type="button" @click="getfullscr()">
                            <i class="fa fa-arrows-alt"></i>
                        </dbinput>
                    </div>
                </div>
                <dbdata name="shwitms" class="grid" :sql="`select * from products where ptype like '${fptype}%' and pcat<>'Custom Options' and pinv='Sales' and (pname LIKE '${psearch}%' or barcode='${psearch}' or pnum='${psearch}' or pid='${psearch}' or pslno='${psearch}' ) `" @ondata="ononedata" groupby="itmid" style="grid-template-columns: repeat(auto-fit,minmax(150px,1fr));max-height: 500px;overflow-y: auto;">
                    <template slot="row" slot-scope="d">
                        <button :class="{prodcard:true,cp:true,cstmpz:d.val.group.length>1}" :style="'height: 80px;'" @click="addprodctpre(d.val)">
                            <div style="height: 100%" class="cp">
                                <div class="fgrid">
                                    <h4>{{d.val.pname}}</h4>
                                </div>
                                <div v-if="!(d.val.group.length>1)" class="price">
                                    {{d.val.posp.toCur(true)}}
                                </div>
                            </div>
                        </button>
                    </template>
                </dbdata>
            </div>
        </div>
        <tabs name="crtchk" :tabs="chktbs" @ontab="(t)=>{chktbs=(t==0)?['Cart']:chktbs}">
            <div slot="Cart" style="height: 100%;max-height: calc(100% - 35px);">
                <div v-if="isCartNotEmpty()" class="right">
                    <button type="button" style="width: fit-content;" @click="proceed()">Proceed</button>
                </div>
                <dbtable name="ptbl" :sql="`select *,(posp*pqty) as pamt from counter where bchn = '${apf.bchn}' and ordsts='P'`" :wcol="{otamt:'70px'}" :fcol="['pname','otamt']" :dcol="{pname:'Particulars',pcat:'Category',ptype:'Type',pqty:'Quantity',otamt:'Amt',posp:'Price',pgst:'GST',pdesc:'Description'}" :updkey="['itmid']" @delete="(df)=>{df();}" @onadd="function(df){onappprod=df}" :defaultcol="apf" :editable="false" :mng="false" @onrow="change = calchange();" @expand="()=>{}" :attrs="{del:delcnt}">
                    <template slot="pname" slot-scope="d">
                        <div class="fgrid">
                            <div>
                                <div>
                                    <div>{{d.rval.pname}}</div>
                                    <div class="gridfrfr">
                                        <div class="gridautofr">
                                            <b>GST:</b>
                                            <div>{{d.rval.pgst}}%</div>
                                        </div>
                                        <div class="gridautofr">
                                            <b>Price:</b>
                                            <div>{{d.rval.posp}}</div>
                                        </div>
                                    </div>
                                    <div class="fgrid" style="grid-template-columns: 0fr 0fr 0fr 0fr;">
                                        <b style="padding: 8px">Qty:</b>
                                        <button class="fit" @click="subQty(d.rval.itmid,d.rval)">-</button>
                                        <div style="padding: 8px;">{{d.rval.pqty}}</div>
                                        <button class="fit" @click="addQty(d.rval.itmid,d.rval)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template slot="otamt" slot-scope="d">
                        {{d.rval.pqty*d.rval.posp}}
                    </template>
                    <div slot="detailed" slot-scope="d">
                        <form autocomplete="off" id="desc" action="javascript:void(0)" style="display: grid;grid-template-columns: 1fr 1fr">
                            <dbinput type="textarea" v-model="d.rval.otdesc" label="Description"></dbinput>
                            <dbinput type="button" label="" @click="updatedesc(d.rval.itmid,d.rval.otdesc)">Update</dbinput>
                        </form>
                    </div>
                    <template slot="thead" slot-scope="fd" v-if="isCartNotEmpty()">
                        <tr>
                            <th colspan="2">Total</th>
                            <th colspan="3" class="txr h5">
                                {{(billamt(getPrdRow())+gstamt(getPrdRow())).toCur(true)}}
                            </th>
                        </tr>
                    </template>
                    <template slot="foot" slot-scope="fd" v-if="isCartNotEmpty()">
                        <tr>
                            <th colspan="2">Sub Total</th>
                            <th colspan="3" class="txr">{{fd.row.col('pamt').sum().toCur(true)}}</th>
                        </tr>
                        <tr>
                            <th colspan="2">CGST</th>
                            <th colspan="3" class="txr">
                                + {{(gstamt(getPrdRow())/2).toCur(true)}}
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">SGST</th>
                            <th colspan="3" class="txr">
                                + {{(gstamt(getPrdRow())/2).toCur(true)}}
                            </th>
                        </tr>
                    </template>
                </dbtable>
            </div>
            <div slot="Checkout" style="height: 100%;max-height: calc(100% - 35px);">
                <form autocomplete="off" method="post" action="javascript:updatebillcounter()" class="grid">
                    <dbinput sql="select * from(SELECT efname,email,elname,euname,concat(efname,elname) as ename,mnumber,eid,address1 from customer) as customer" fcol="mnumber" type="search" label="Mob" required v-model="apf.mnumber" @select="hadelcustSearch">
                    </dbinput>
                    <dbinput type="email" v-model="apf.email" label="Email"></dbinput>
                    <dbinput style="grid-column: 1/-1;" type="text" v-model="apf.efname" label="Customer Name *" required></dbinput>
                    <dbinput type="textarea" v-model="apf.address1" label="Address" style="grid-column: 1/-1;"></dbinput>
                    <div class="gridfrfr">
                        <dbinput name="cpn" sql="SELECT * from coupons where CURDATE()>=cpnvf and CURDATE()<=cpnvt" fcol="cpname" type="search" v-model="apf.cpname" label="Apply Coupon" @select="fillcoupon">
                        </dbinput>
                        <dbinput name="pmtd" type="select" label="Pay By *" v-model="apf.pmtd" :options="['Cash','E-Wallet','UPI','Card','Zomato','Swiggy','Others']" required>
                        </dbinput>
                    </div>
                    <div>
                        <label>Amount - Discount + GST</label>
                        <div>
                            {{billamt(getPrdRow())}} - {{cpnamt(getPrdRow()).amt}} + {{ gstamt(getPrdRow()) }} = <b>{{(disamt(getPrdRow())).toCur(true)}}</b>
                        </div>
                    </div>
                    <dbinput v-if="apf.pmtd=='Cash'" type="number" v-model="apf.ppaid" label="Collect Cash" required></dbinput>
                    <dbinput name="change" :label="collect-disamt(getPrdRow())>0?'Change':'Pending'" type="label"><span>{{change.toCur(true)}}</span>
                    </dbinput>
                    <div v-if="disamt(getPrdRow())>=0" class="gridfrfr">
                        <!-- <dbinput class="" v-if="isCartNotEmpty()" type="submit" @click="tokenf=true;pmtd[1].vue.search = 'Others';" label="">Make Estimate</dbinput> -->
                        <dbinput class="" v-if="isCartNotEmpty()" type="submit" @click="tokenf=false" label="">Make Bill</dbinput>
                    </div>
                </form>
            </div>
        </tabs>
    </div>
    <div slot="Settlement">
        <dbtable name="stltbl" sql="select ordid,bchn,bilno,bildn,odate,email,euname,mnumber,sum(@amt:=(posp*pqty)) as amt,sum(@gst:=ROUND(@amt*(pgst/100))) as gst,@gst as sgst,@row:=IFNULL(@row,1)+1 as i, sum(@amt+@gst-IF(@row=1,cpnamt,0)) as bill from counter where ordsts='B' and odate=CURRENT_DATE group by ordid" :fcol="['bildn','bilno','bchn','odate','euname', 'mnumber','gst','sgst','bill','amt']" :dcol="{bildn:'Token',bilno:'Bill',euname:'Name',mnumber:'Ph',bill:'Amount',amt:'#',gst:'CGST',sgst:'SGST',odate:'Date',pdatetime:'Prepared Date',ddatetime:'Delivered Date',email:'Email',bchn:'Ord'}" :defaultcol="apf" :editable="false" @expand="()=>{}" :updkey="['bilno']" :row_atr="myrowatr">
            <div slot="detailed" slot-scope="d">
                <dbtable name="insisitm" :sql="`select * from(select c.itmid,c.itmid as base,c.pname,c.ptpng,c.psz,c.pqty,c.posp,(c.posp*c.pqty) as pamt,c.cpnamt,c.pgst,c.cpnid,p.ingredients  from counter c join products p where c.pid=p.pid and c.bilno='${d.rval.bilno}' and pinv='sales') as counter`" :fcol="['pname','ptpng','itmid','psz','pamt']" :dcol="{pname:'Product Name',ptpng:'Toppings',psz:'Size',pamt:'Qty x Price = Total',itmid:'base',otdesc:'Description'}" :editable="false">
                    <template slot="pamt" slot-scope="d">
                        {{d.rval.pqty }}
                        <span>x</span>(
                        {{d.rval.posp-(d.rval.ptpng.json().col('posp').sum())}}
                        <span v-if="d.rval.ptpng.json().col('posp').sum()>0">
                            <span>+</span>
                            {{d.rval.ptpng.json().col('posp').sum()}}
                        </span>
                        )
                        <span>=</span> {{d.rval.pamt}}
                    </template>
                    <template slot="ptpng" slot-scope="d">
                        <div v-if="d.rval.pname=='Custom Pizza'">
                            <table class="col" style="border-style: dashed;border: 1px solid #761a1a;">
                                <thead>
                                    <tr>
                                        <th>Veg</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(val,i) in d.rval.ptpng.json()" v-if="val.ptype!='Pizza Base'">
                                        <td>{{val.pveg==0?"Non Veg":"Veg"}}</td>
                                        <td>{{val.pname}}</td>
                                        <td>{{val.posp}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="Object.values(d.rval.ingredients.json()).length>0">
                            <h4 class="center"><b>Ingredients</b></h4>
                            <div v-for="(val,i) in d.rval.ingredients.json()" v-if="val.ipname!=''">
                                <span>{{val.ipname}}</span>
                            </div>
                        </div>
                    </template>
                    <template slot="itmid" slot-scope="d">
                        <div style="font-size: 17px;" v-for="(val,i) in d.rval.ptpng.json()" v-if="val.ptype=='Pizza Base'">
                            <table class="col" style="border-style: dashed;border: 1px solid #252553;">
                                <thead>
                                    <tr>
                                        <th>Base</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{val.pname}}</td>
                                        <td>{{val.posp}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                    <template slot="foot" slot-scope="fd">
                        <tr>
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Sub Total</th>
                            <th colspan="2" class="txr">{{(fd.row.col('pamt').sum()).toCur(true)}}</th>
                        </tr>
                        <tr v-if="(isset(fd.row[0])?fd.row[0].cpnamt:0)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Discount</th>
                            <th colspan="2" class="txr h5">
                                - {{(isset(fd.row[0])?fd.row[0].cpnamt:0).toCur(true)}}
                            </th>
                        </tr>
                        <tr v-if="(gstamt(fd.row)/2)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">CGST</th>
                            <th colspan="2" class="txr">
                                + {{(gstamt(fd.row)/2).toCur(2)}}
                            </th>
                        </tr>
                        <tr v-if="(gstamt(fd.row)/2)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">SGST</th>
                            <th colspan="2" class="txr">
                                + {{(gstamt(fd.row)/2).toCur(2)}}
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Total</th>
                            <th colspan="2" class="txr h5">
                                {{(billamt(fd.row)-(isset(fd.row[0])?fd.row[0].cpnamt:0)+gstamt(fd.row)).toCur(true)}}
                            </th>
                        </tr>
                    </template>
                </dbtable>
            </div>
            <div class="noprint" slot="amt" slot-scope="d" style="display: grid;grid-template-columns: auto auto auto">
                <button class="btn btn-primary mx-1" @click="settle(d.rval)">
                    <i title="Settle" class="fa fa-handshake-o" aria-hidden="true"></i>
                </button>
                <button class="btn btn-primary mx-1" @click="viewbill(d.rval['bilno'],d.rval['odate'],'view','counter',d)">
                    <i title="Print" aria-hidden="true" class="fa fa-print"></i>
                </button>
                <button class="btn btn-primary" @click="viewbill(d.rval['bilno'],d.rval['odate'],'email','counter',d)">
                    <i title="Email" aria-hidden="true" class="fa fa-envelope"></i>
                </button>
            </div>
            <div slot="bill-disp" slot-scope="d">
                {{d.rval.bill.toCur(true)}}
            </div>
            <div slot="gst-disp" slot-scope="d">
                {{(d.rval.gst/2).toCur(2)}}
            </div>
            <div slot="sgst-disp" slot-scope="d">
                {{(d.rval.gst/2).toCur(2)}}
            </div>
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="gridauto">
                            <div class="gridfrfr">
                                <div>GST</div>
                                <div>
                                    {{(d.row.col('gst').sum()).toCur()}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>CGST</div>
                                <div>
                                    {{(d.row.col('gst').sum()/2).toCur(2)}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>SGST</div>
                                <div>
                                    {{(d.row.col('gst').sum()/2).toCur(2)}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>Amount</div>
                                <div>
                                    {{(d.row.col('bill').sum()).toCur()}}
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </template>
        </dbtable>
    </div>
    <div slot="Bill History">
        <div class="gridauto">
            <dbinput class="fit" label="Month" type="month" @select="(a,s,e,mn,m)=>{rep.frm=s;rep.to=e;}">
            </dbinput>
            <dbinput class="fit" v-model="rep.frm" label="From" type="date">
            </dbinput>
            <dbinput class="fit" v-model="rep.to" label="To" type="date">
            </dbinput>
        </div>
        <dbtable name="bltbl" :sql="`select ordid,bchn,pmtd,bilno,bildn,odate,email,dboys,euname,mnumber,sum(@amt:=(posp*pqty)) as amt,sum(@gst:=ROUND(@amt*(pgst/100))) as gst,cpnamt as sgst,@row:=IFNULL(@row,1)+1 as i, sum(@amt+@gst-IF(@row=1,cpnamt,0)) as bill,ordsts from counter where bilno!=0 and odate>='${rep.frm}' and odate<='${rep.to}' and ordsts!='C'  group by ordid`" :fcol="['bildn','bilno','bchn','odate','pmtd','euname', 'mnumber','gst','sgst','bill','ordsts','amt']" :dcol="{bildn:'Tkn',bilno:'Bill',euname:'Name',mnumber:'Ph',bill:'Amount',amt:'#',gst:'CGST',sgst:'SGST',odate:'Date',pdatetime:'Prepared Date',ddatetime:'Delivered Date',email:'Email',pmtd:'Pay By',bchn:'Ord',ordsts:'Status'}" :defaultcol="apf" :editable="false" @expand="()=>{}" :updkey="['bilno']" :row_atr="myrowatr">
            <div slot="detailed" slot-scope="d">
                <dbtable name="insisitm" :sql="`select * from(select c.itmid,c.itmid as base,c.pname,c.ptpng,c.psz,c.pqty,c.posp,(c.posp*c.pqty) as pamt,c.cpnamt,c.pgst,c.cpnid,p.ingredients  from counter c join products p where c.pid=p.pid and c.bilno='${d.rval.bilno}' and pinv='sales') as counter`" :fcol="['pname','ptpng','itmid','psz','pamt']" :dcol="{pname:'Product Name',ptpng:'Toppings',psz:'Size',pamt:'Qty x Price = Total',itmid:'base',otdesc:'Description'}" :editable="false">
                    <template slot="pamt" slot-scope="d">
                        {{d.rval.pqty }}
                        <span>x</span>(
                        {{d.rval.posp-(d.rval.ptpng.json().col('posp').sum())}}
                        <span v-if="d.rval.ptpng.json().col('posp').sum()>0">
                            <span>+</span>
                            {{d.rval.ptpng.json().col('posp').sum()}}
                        </span>
                        )
                        <span>=</span> {{d.rval.pamt}}
                    </template>
                    <template slot="ptpng" slot-scope="d">
                        <div v-if="d.rval.pname=='Custom Pizza'">
                            <table class="col" style="border-style: dashed;border: 1px solid #761a1a;">
                                <thead>
                                    <tr>
                                        <th>Veg</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(val,i) in d.rval.ptpng.json()" v-if="val.ptype!='Pizza Base'">
                                        <td>{{val.pveg==0?"Non Veg":"Veg"}}</td>
                                        <td>{{val.pname}}</td>
                                        <td>{{val.posp}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="Object.values(d.rval.ingredients.json()).length>0">
                            <h4 class="center"><b>Ingredients</b></h4>
                            <div v-for="(val,i) in d.rval.ingredients.json()" v-if="val.ipname!=''">
                                <span>{{val.ipname}}</span>
                            </div>
                        </div>
                    </template>
                    <template slot="itmid" slot-scope="d">
                        <div style="font-size: 17px;" v-for="(val,i) in d.rval.ptpng.json()" v-if="val.ptype=='Pizza Base'">
                            <table class="col" style="border-style: dashed;border: 1px solid #252553;">
                                <thead>
                                    <tr>
                                        <th>Base</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{val.pname}}</td>
                                        <td>{{val.posp}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                    <template slot="foot" slot-scope="fd">
                        <tr>
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Sub Total</th>
                            <th colspan="2" class="txr">{{(fd.row.col('pamt').sum()).toCur(true)}}</th>
                        </tr>
                        <tr v-if="(isset(fd.row[0])?fd.row[0].cpnamt:0)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Discount</th>
                            <th colspan="2" class="txr h5">
                                - {{(isset(fd.row[0])?fd.row[0].cpnamt:0).toCur(true)}}
                            </th>
                        </tr>
                        <tr v-if="(gstamt(fd.row)/2)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">CGST</th>
                            <th colspan="2" class="txr">
                                + {{(gstamt(fd.row)/2).toCur(2)}}
                            </th>
                        </tr>
                        <tr v-if="(gstamt(fd.row)/2)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">SGST</th>
                            <th colspan="2" class="txr">
                                + {{(gstamt(fd.row)/2).toCur(2)}}
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Total</th>
                            <th colspan="2" class="txr h5">
                                {{(billamt(fd.row)-(isset(fd.row[0])?fd.row[0].cpnamt:0)+gstamt(fd.row)).toCur(true)}}
                            </th>
                        </tr>
                    </template>
                </dbtable>
            </div>
            <div class="noprint" slot="amt" slot-scope="d" style="display: grid;grid-template-columns: auto">
                <div v-if="!d.rval.bchn.includes('Wi')">
                    <dbinput type="select" v-model='d.rval.dboys.json().name' fcol='fname' fkey="uname" sql="select * from employee where designation='Delivery Boy'" :all="true" @select="(v,r)=>{d.updateItem(null,JSON.stringify({id:v,name:r.fname}),'dboys',d.rval,d.i)}" label="Choose delivery boy">
                    </dbinput>
                </div>
                <div class="gridfrfr" style="grid-template-columns: 1fr 1fr 1fr">
                    <button class="btn btn-primary mx-1" @click="tconfirm('Do you really want to cancel?','Warning..').then((f)=>{f[0]?d.updateItem(null,'C','ordsts',d.rval,d.i):'';cltbl.vue.fetchData();})">Cancel</button>
                    <button class="btn btn-primary mx-1" @click="viewbill(d.rval['bilno'],d.rval['odate'],'view','counter',d)">
                        <i title="Print" aria-hidden="true" class="fa fa-print"></i>
                    </button>
                    <button class="btn btn-primary" @click="viewbill(d.rval['bilno'],d.rval['odate'],'email','counter',d)">
                        <i title="Email" aria-hidden="true" class="fa fa-envelope"></i>
                    </button>
                </div>
            </div>
            <div slot="ordsts" slot-scope='d'>
                <div :class="'sts '+d.rval.ordsts" v-if="isset({B:'Ordered',Pr:'Prepared',S:'Delivered'}[d.rval.ordsts])" style="height: 40px">
                    <span>{{ {B:'B:Ordered',Pr:'Pr:Prepared',S:'S:Delivered'}[d.rval.ordsts] }}</span>
                </div>
            </div>
            <div slot="bill-disp" slot-scope="d">
                {{d.rval.bill.toCur(true)}}
            </div>
            <div slot="gst-disp" slot-scope="d">
                {{(d.rval.gst/2).toCur(2)}}
            </div>
            <div slot="sgst-disp" slot-scope="d">
                {{(d.rval.gst/2).toCur(2)}}
            </div>
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="gridauto">
                            <div class="gridfrfr">
                                <div>GST</div>
                                <div>
                                    {{(d.row.col('gst').sum()).toCur()}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>CGST</div>
                                <div>
                                    {{(d.row.col('gst').sum()/2).toCur(2)}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>SGST</div>
                                <div>
                                    {{(d.row.col('gst').sum()/2).toCur(2)}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>Amount</div>
                                <div>
                                    {{(d.row.col('bill').sum()).toCur()}}
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </template>
        </dbtable>
    </div>
    <div slot="Canceled Bills">
        <div class="gridauto">
            <dbinput class="fit" label="Month" type="month" @select="(a,s,e,mn,m)=>{rep.frm=s;rep.to=e;}">
            </dbinput>
            <dbinput class="fit" v-model="rep.frm" label="From" type="date">
            </dbinput>
            <dbinput class="fit" v-model="rep.to" label="To" type="date">
            </dbinput>
        </div>
        <dbtable name="cltbl" :sql="`select ordid,bchn,pmtd,bilno,bildn,odate,email,dboys,euname,mnumber,sum(@amt:=(posp*pqty)) as amt,sum(@gst:=ROUND(@amt*(pgst/100))) as gst,cpnamt as sgst,@row:=IFNULL(@row,1)+1 as i, sum(@amt+@gst-IF(@row=1,cpnamt,0)) as bill,ordsts from counter where bilno!=0 and odate>='${rep.frm}' and odate<='${rep.to}' and ordsts='C'  group by ordid`" :fcol="['bildn','bilno','bchn','odate','pmtd','euname', 'mnumber','gst','sgst','bill','amt']" :dcol="{bildn:'Tkn',bilno:'Bill',euname:'Name',mnumber:'Ph',bill:'Amount',amt:'#',gst:'CGST',sgst:'SGST',odate:'Date',pdatetime:'Prepared Date',ddatetime:'Delivered Date',email:'Email',pmtd:'Pay By',bchn:'Ord',ordsts:'Status'}" :defaultcol="apf" :editable="false" @expand="()=>{}" :updkey="['bilno']" :row_atr="myrowatr">
            <div slot="detailed" slot-scope="d">
                <dbtable name="insisitm" :sql="`select * from(select c.itmid,c.itmid as base,c.pname,c.ptpng,c.psz,c.pqty,c.posp,(c.posp*c.pqty) as pamt,c.cpnamt,c.pgst,c.cpnid,p.ingredients  from counter c join products p where c.pid=p.pid and c.bilno='${d.rval.bilno}' and pinv='sales') as counter`" :fcol="['pname','ptpng','itmid','psz','pamt']" :dcol="{pname:'Product Name',ptpng:'Toppings',psz:'Size',pamt:'Qty x Price = Total',itmid:'base',otdesc:'Description'}" :editable="false">
                    <template slot="pamt" slot-scope="d">
                        {{d.rval.pqty }}
                        <span>x</span>(
                        {{d.rval.posp-(d.rval.ptpng.json().col('posp').sum())}}
                        <span v-if="d.rval.ptpng.json().col('posp').sum()>0">
                            <span>+</span>
                            {{d.rval.ptpng.json().col('posp').sum()}}
                        </span>
                        )
                        <span>=</span> {{d.rval.pamt}}
                    </template>
                    <template slot="ptpng" slot-scope="d">
                        <div v-if="d.rval.pname=='Custom Pizza'">
                            <table class="col" style="border-style: dashed;border: 1px solid #761a1a;">
                                <thead>
                                    <tr>
                                        <th>Veg</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(val,i) in d.rval.ptpng.json()" v-if="val.ptype!='Pizza Base'">
                                        <td>{{val.pveg==0?"Non Veg":"Veg"}}</td>
                                        <td>{{val.pname}}</td>
                                        <td>{{val.posp}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-if="Object.values(d.rval.ingredients.json()).length>0">
                            <h4 class="center"><b>Ingredients</b></h4>
                            <div v-for="(val,i) in d.rval.ingredients.json()" v-if="val.ipname!=''">
                                <span>{{val.ipname}}</span>
                            </div>
                        </div>
                    </template>
                    <template slot="itmid" slot-scope="d">
                        <div style="font-size: 17px;" v-for="(val,i) in d.rval.ptpng.json()" v-if="val.ptype=='Pizza Base'">
                            <table class="col" style="border-style: dashed;border: 1px solid #252553;">
                                <thead>
                                    <tr>
                                        <th>Base</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{val.pname}}</td>
                                        <td>{{val.posp}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </template>
                    <template slot="foot" slot-scope="fd">
                        <tr>
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Sub Total</th>
                            <th colspan="2" class="txr">{{(fd.row.col('pamt').sum()).toCur(true)}}</th>
                        </tr>
                        <tr v-if="(isset(fd.row[0])?fd.row[0].cpnamt:0)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Discount</th>
                            <th colspan="2" class="txr h5">
                                - {{(isset(fd.row[0])?fd.row[0].cpnamt:0).toCur(true)}}
                            </th>
                        </tr>
                        <tr v-if="(gstamt(fd.row)/2)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">CGST</th>
                            <th colspan="2" class="txr">
                                + {{(gstamt(fd.row)/2).toCur(2)}}
                            </th>
                        </tr>
                        <tr v-if="(gstamt(fd.row)/2)!=0">
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">SGST</th>
                            <th colspan="2" class="txr">
                                + {{(gstamt(fd.row)/2).toCur(2)}}
                            </th>
                        </tr>
                        <tr>
                            <th></th>
                            <th colspan="3"></th>
                            <th colspan="1">Total</th>
                            <th colspan="2" class="txr h5">
                                {{(billamt(fd.row)-(isset(fd.row[0])?fd.row[0].cpnamt:0)+gstamt(fd.row)).toCur(true)}}
                            </th>
                        </tr>
                    </template>
                </dbtable>
            </div>
            <div class="noprint" slot="amt" slot-scope="d" style="display: grid;grid-template-columns: auto">
                <div v-if="!d.rval.bchn.includes('Wi')">
                    <dbinput type="select" v-model='d.rval.dboys.json().name' fcol='fname' fkey="uname" sql="select * from employee where designation='Delivery Boy'" :all="true" @select="(v,r)=>{d.updateItem(null,JSON.stringify({id:v,name:r.fname}),'dboys',d.rval,d.i)}" label="Choose delivery boy">
                    </dbinput>
                </div>
                <div class="gridfrfr" style="grid-template-columns: 1fr 1fr 1fr">
                    <button class="btn btn-primary mx-1" @click="tconfirm('Confirm the restore','Warning..').then((f)=>{f[0]?d.updateItem(null,'S','ordsts',d.rval,d.i):'';bltbl.vue.fetchData();})">Restore</button>
                    <button class="btn btn-primary mx-1" @click="viewbill(d.rval['bilno'],d.rval['odate'],'view','counter',d)">
                        <i title="Print" aria-hidden="true" class="fa fa-print"></i>
                    </button>
                    <button class="btn btn-primary" @click="viewbill(d.rval['bilno'],d.rval['odate'],'email','counter',d)">
                        <i title="Email" aria-hidden="true" class="fa fa-envelope"></i>
                    </button>
                </div>
            </div>
            <div slot="ordsts" slot-scope='d'>
                <div :class="'sts '+d.rval.ordsts" v-if="isset({B:'Ordered',Pr:'Prepared',S:'Delivered'}[d.rval.ordsts])" style="height: 40px">
                    <span>{{ {B:'B:Ordered',Pr:'Pr:Prepared',S:'S:Delivered'}[d.rval.ordsts] }}</span>
                </div>
            </div>
            <div slot="bill-disp" slot-scope="d">
                {{d.rval.bill.toCur(true)}}
            </div>
            <div slot="gst-disp" slot-scope="d">
                {{(d.rval.gst/2).toCur(2)}}
            </div>
            <div slot="sgst-disp" slot-scope="d">
                {{(d.rval.gst/2).toCur(2)}}
            </div>
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="gridauto">
                            <div class="gridfrfr">
                                <div>GST</div>
                                <div>
                                    {{(d.row.col('gst').sum()).toCur()}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>CGST</div>
                                <div>
                                    {{(d.row.col('gst').sum()/2).toCur(2)}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>SGST</div>
                                <div>
                                    {{(d.row.col('gst').sum()/2).toCur(2)}}
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div>Amount</div>
                                <div>
                                    {{(d.row.col('bill').sum()).toCur()}}
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </template>
        </dbtable>
    </div>
</tabs>
<vue>#node</vue>
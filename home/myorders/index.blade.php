<clearnav></clearnav>
<vue>#cntfrm</vue>
<div class="foo">
    <?php
	include('screen/home/carthead.php');
	?>
    <link rel="stylesheet" href="<?=get_url('screen/home/contact/css/footer.css')?>">
    <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/main.css')?>">
    <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/line-icons.css')?>">
    <script type="application/javascript" src="<?=get_url('screen/home/products/js/main.js')?>"></script>
    <main id="cntfrm">
        <div class="contact-form-with-address">
            <div class="container" style="background: #fff !important">
                <h3 style="padding: 10px">My Orders</h3>
                <section class="ftco-about d-md-flex">
                    <dbtable name="ortbl" sql="select eid,onum,ordid,ordid as status,ordsts,bilno,odate,@disc:=MAX(cpnamt) as disc,euname,mnumber,round(SUM((posp+(posp*(pgst/100)))*pqty)-@disc) as bamt,(pgst/100),itmid,stname,itmid as bill from orders where ordsts!='P' and eid='<?=getUserId('eid')?>' group by ordid order by odate desc" :fcol="['onum','status','odate','bamt','bill']" :dcol="{onum:'Order #',bamt:'Total',odate:'Date',status:'Status',bill:'Bill'}" :defaultcol="apf" :editable="false" @expand="()=>{}">
                        <template slot="status" slot-scope="d">
                            <div style="position: relative;">
                                <span v-if="d.rval.ordsts=='R'">
                                    <div style="display: grid;grid-template-columns: 1fr 1fr 1fr;">
                                        <label style="background:orange;padding: 5px;">Pending</label>
                                        <button @click="changestatus(d.rval)">Proceed to Cart</button>
                                        <button style="background:green" @click="gotoCheckout(d.rval)">Checkout</button>
                                    </div>
                                </span>
                                <span v-if="d.rval.ordsts=='C'">
                                    <button style="background:red">Canceled by shop</button>
                                </span>
                                <span v-if="d.rval.ordsts=='B'">
                                    <button style="background:Green">Order Placed</button>
                                </span>
                                <span v-if="d.rval.ordsts=='K'">
                                    <button style="background:Green">Preparing</button>
                                </span>
                                <span v-if="d.rval.ordsts=='O'">
                                    <button style="background:Green">Out For Delivery</button>
                                </span>
                                <span v-if="d.rval.ordsts=='S'">
                                    <button style="background:Green">Delivered</button>
                                </span>
                            </div>
                        </template>
                        <div slot="bill" v-if="(d.rval.ordsts!='P' && d.rval.ordsts!='R')" slot-scope="d" style="display: grid;grid-template-columns: 1fr 1fr">
                            <button class="btn btn-primary mx-1" @click="viewbillonline(d.rval['ordid'])">
                                <i class="material-icons">print</i>
                            </button>
                            </button>
                        </div>
                        <div slot="detailed" slot-scope="d">
                            <dbtable name="insisitm" :sql="`select *,(posp*pqty) as pamt  from orders where ordid='${d.rval.ordid}'`" :fcol="['pname','pqty','posp','pamt']" :dcol="{pname:'Product Name',pqty:'Qty',posp:'Price',pamt:'Total',otdesc:'Description'}" :editable="false">
                                <template slot="pname" slot-scope="d">
                                    <div style="position: relative;">
                                        <span v-if="d.rval.pcat=='combo'">
                                            <img :src="get_url(`upload/comboimage/${d.rval['pid']}/comboimg.png`)" width="50px">
                                        </span>
                                        <span v-if="d.rval.pcat!='combo'">
                                            <img :src="get_url(`upload/products/${d.rval['pid']}/pimage.png`)" width="50px">
                                        </span>
                                        <div style="display: inline-block;position: absolute;margin-left: 5px;">
                                            <div>{{d.rval.pname}}</div>
                                            <div>S : {{d.rval.psz}} | C : {{d.rval.pcat}} | T : {{d.rval.ptype}}</div>
                                        </div>
                                    </div>
                                </template>
                                <template slot="foot" slot-scope="fd">
                                    <tr>
                                        <th></th>
                                        <th colspan="2"></th>
                                        <th colspan="1">Sub Total</th>
                                        <th colspan="2" class="txr">{{fd.row.col('pamt').sum().toCur(true)}}</th>
                                    </tr>
                                    <tr v-if='isset(fd.row[0])?fd.row[0].cpnamt:0!=0'>
                                        <th></th>
                                        <th colspan="2"></th>
                                        <th colspan="1">Discount</th>
                                        <th colspan="2" class="txr h5">
                                            - {{(isset(fd.row[0])?fd.row[0].cpnamt:0).toCur(true)}}
                                        </th>
                                    </tr>
                                    <tr v-if='gstamt(fd.row)/2!=0'>
                                        <th></th>
                                        <th colspan="2"></th>
                                        <th colspan="1">CGST</th>
                                        <th colspan="2" class="txr">
                                            + {{(gstamt(fd.row)/2).toCur(2)}}
                                        </th>
                                    </tr>
                                    <tr v-if='gstamt(fd.row)/2!=0'>
                                        <th></th>
                                        <th colspan="2"></th>
                                        <th colspan="1">SGST</th>
                                        <th colspan="2" class="txr">
                                            + {{(gstamt(fd.row)/2).toCur(2)}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th colspan="2"></th>
                                        <th colspan="1">Total</th>
                                        <th colspan="2" class="txr h5">
                                            {{(billamt(fd.row)-(isset(fd.row[0])?fd.row[0].cpnamt:0)+gstamt(fd.row)).toCur(true)}}
                                        </th>
                                    </tr>
                                </template>
                            </dbtable>
                        </div>
                    </dbtable>
                </section>
            </div>
        </div>
    </main>
    <div id="cd-shadow-layer"></div>
    <?php include('screen/home/footer.php'); ?>
</div>
<clearnav></clearnav>
<link rel="stylesheet" href="<?=get_url('screen/home/products/css/proroductcard.css')?>">
<div class="foo">
    <?php include("screen/home/carthead.php"); ?>
    <script type="application/javascript" src="<?=get_url('screen/home/products/js/main.js')?>"></script>
    <vue>#productmenu</vue>
    <div id="productmenu">
        <?php 
		$ptype = ($ldb->getDBData("select distinct(ptype) as ptype from mapproduct"))["data"];
		$icon = array();
		foreach ($ptype as $key => $val) {
			switch ($val["ptype"]) {
				case 'Category Demo':
				$icon[$val["ptype"]] = "fas fa-search";
				break;
				default:
				$icon[$val["ptype"]] = "";
			}
		}
		?>
        <div class="filterbar">
            <div :class="{active:filcat=='%'}" onclick="setctcat('%')">
                ALL
            </div>
            <?php foreach($ptype as $key=>$val) { ?>
            <div :class="{active:filcat=='<?=$val['ptype']?>'}" onclick="setctcat('<?=$val['ptype']?>')">
                <!-- <i class="<?=$icon[$val["ptype"]]?>" style="font-size: x-large;margin: auto;position: relative;top: 10px;margin-right: 10px;"></i> -->
                <?=strtoupper($val["ptype"])?>
            </div>
            <?php } ?>
        </div>
        <main style="margin-top: 20px">
            <div class="vegfilter">
                <b :class="{active:vegsts=='%'}" @click="vegsts='%';getProdInfo();">All</b>
                <b :class="{active:vegsts=='1'}" @click="vegsts='1';getProdInfo();">Veg</b>
                <b :class="{active:vegsts=='0'}" @click="vegsts='0';getProdInfo();">Non-Veg</b>
            </div>
            <ul class="cd-container">
                <dbdata name="cartcon" :sql="`select * from mapproduct where penb=1 and ptype LIKE '${filcat}' and pveg LIKE '${vegsts}' `" :group="['pname']" @row="loadProdGroup">
                    <template slot="row" slot-scope="d">
                        <template v-if="d.row.length>0">
                            <li v-if="(d.i==0||d.row[d.i].rval.ptype!=d.row[d.i-1].rval.ptype)&&filcat=='%'" class="product_seperate" :id="d.val.rval.ptype.toIdCase()">
                                <h2>{{d.val.rval.ptype.toWordCase()}}</h2>
                            </li>
                        </template>
                        <li v-if="d.val.index==0" class="product">
                            <div class="container page-wrapper">
                                <div class="page-inner">
                                    <div class="row">
                                        <div class="el-wrapper">
                                            <div class="box-up">
                                                <span v-if="d.val.rval.ptype=='combos'">
                                                    <img class="img" :src="get_url(`upload/comboimage/${d.val.rval['pid']}/comboimg.png`)" onerror="this.src=get_url('res/images/demo.png')" />
                                                </span>
                                                <span v-if="d.val.rval.ptype!='combos'">
                                                    <img class="img" :src="get_url(`upload/products/${d.val.rval['pid']}/pimage.png`)" onerror="this.src=get_url('res/images/demo.png')" />
                                                </span>
                                                <div class="img-info">
                                                    <div class="info-inner">
                                                        <span class="p-name">{{d.val.rval.pname}}</span>
                                                        <span class="p-company"><b>Type</b>: {{d.val.rval.ptype}}</span>
                                                    </div>
                                                    <!-- <span class="a-pqty">
														<div style="display:grid;grid-template-columns:50px 50px 50px 50px;">
															<span class="cpqtylbl">Qty: </span>
															<button @click="d.val.rval.pqty-=(d.val.rval.pqty>1)?1:0" >-</button>
															<b class="cpqty">{{d.val.rval.pqty}}</b>
															<button @click="d.val.rval.pqty++">+</button>
														</div>
													</span> -->
                                                    <span v-if="d.val.rval.ptype=='Pizza'">
                                                        <div class="a-size">Available sizes :
                                                            <span class="size">
                                                                <span v-for="(grpitm,i) in d.val.group" :class="{active:prdslcsz[d.val.rval.pname]==grpitm.rval}" @click="$event.preventDefault();handelSizeProduct($event,grpitm.rval,d.val.rval.pname);">
                                                                    {{grpitm.rval.psz}}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <button id="popup" class="" @click="customise_product(prdslcsz[d.val.rval.pname])">Customise Now</button>
                                            <div class="box-down" @click="addtocart(prdslcsz[d.val.rval.pname])">
                                                <div class="h-bg">
                                                    <div class="h-bg-inner"></div>
                                                </div>
                                                <a class="cart" href="javascript:void(0)">
                                                    <span class="price">
                                                        <i class="fas fa-shopping-cart"></i>
                                                        {{prdslcsz[d.val.rval.pname]["pmrp"].toCur(true)}}
                                                    </span>
                                                    <span class="add-to-cart">
                                                        <span class="txt">Add to cart</span>
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </template>
                </dbdata>
            </ul>
        </main>
        <div id="cd-shadow-layer"></div>
        <dbdata class="cdcart" name="cd-cart" sql="select pname,pqty,(pqty*posp) as pamt,itmid from orders where ordsts = 'P' and eid='<?=getUserId('eid')?>' " @row="(val)=>{carttbl=val;handelcartcount(carttbl)}" @mounted="(val)=>{carttblnode=val}">
            <template slot="row" slot-scope="cd" v-if="cd.i==0">
                <span style="width: 100% !important">
                    <h2>Cart</h2>
                </span>
                <ul class="cd-cart-items">
                    <li v-for="rval in cd.row">
                        <span class="cd-qty">{{rval.pqty}}x</span> {{rval.pname}}
                        <div class="cd-price">{{rval.pamt.toCur(true)}}</div>
                        <button @click="removeItem(rval)" class="cd-item-remove cd-img-replace"></button>
                    </li>
                </ul>
                <div class="cd-cart-total" v-if="carttbl.length>0" style="width: 100% !important">
                    <p>Total
                        <span>
                            <b style="font-weight: bold;">{{carttbl.col('pamt').sum().toCur(true)}}</b>
                        </span>
                    </p>
                </div>
                <a href="<?=screen_url('home/cart_page')?>" class="checkout-btn">Checkout</a>
                <p class="cd-go-to-cart">
                    <a href="<?=screen_url('home/cart_page')?>">Go to cart page</a>
                </p>
            </template>
        </dbdata>
        <!-- cd-cart -->
        <!-- 	model -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="close_bttn()">&times;</span>
                <div class="row" style="border:1px solid var(--secondary);height: 100%;margin: 0px;">
                    <div class="col-12 col-lg-6" style="height: inherit;">
                        <prodimg :prodimg="prodimg" :overlay="toppingImg" :thumb="toppingThumbImg">
                        </prodimg>
                    </div>
                    <div class="col-12 col-lg-6" style="background:#ffffff47;height: inherit;overflow-y: auto;">
                        <div class="row crustcon">
                            <h3 class="col-12">Choose Crust</h3>
                            <div :class="{'col-4':true,crust:true,active:item==selcrust}" v-for="item in crust" @click="selcrust=((selcrust==item)?{}:item);">
                                <div style="display: grid;grid-template-columns: auto 1fr;">
                                    <div style="width: 40px;height: 40px;">
                                        <img :src="get_url('upload/toppings/'+item.tid+'/timage.png')">
                                    </div>
                                    <div>
                                        <div class="row name">
                                            {{item.tname}}
                                        </div>
                                        <div class="row price">
                                            {{item.price.toCur(true)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="crustcon">
                                <h3 class="col-12">Add Extra Toppings</h3>
                            </div>
                        </div>
                        <tabs :tabs="['Veg','Non-Veg']" class="row">
                            <div slot="Veg" class="">
                                <div class="row crustcon" style="margin: 0px">
                                    <div :class="{'col-6':true,crust:true,active:chktopng.includes(item)}" v-for="item in toppings.filter((val)=>{ return val.tveg==false;})" @click="addToping(item)">
                                        <div style="display: grid;grid-template-columns: auto 1fr;">
                                            <div style="width: 40px;height: 40px;">
                                                <img :src="get_url('upload/toppings/'+item.tid+'/timage.png')">
                                            </div>
                                            <div>
                                                <div class="row name">
                                                    {{item.tname}}
                                                </div>
                                                <div class="row price">
                                                    {{item.price.toCur(true)}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div slot="Non-Veg" class="">
                                <div class="row crustcon" style="margin: 0px">
                                    <div :class="{'col-6':true,crust:true,active:chktopng.includes(item)}" v-for="item in toppings.filter((val)=>{ return val.tveg==true;})" @click="addToping(item)">
                                        <div style="display: grid;grid-template-columns: auto 1fr;">
                                            <div style="width: 40px;height: 40px;">
                                                <img :src="get_url('upload/toppings/'+item.tid+'/timage.png')">
                                            </div>
                                            <div>
                                                <div class="row name">
                                                    {{item.tname}}
                                                </div>
                                                <div class="row price">
                                                    {{item.price.toCur(true)}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tabs>
                        <div class="row">
                            <div class="crustcon col-12">
                                <h3>Choose Qty</h3>
                            </div>
                            <div class="col"></div>
                            <div class="col-10 col-lg-6 crustcon">
                                <div style="display:grid;grid-template-columns:50px 50px 50px;">
                                    <button @click="cprod.pqty-=(cprod.pqty>1)?1:0">-</button>
                                    <b class="cpqty">{{cprod.pqty}}</b>
                                    <button @click="cprod.pqty++">+</button>
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div style="display: grid;grid-template-columns: 1fr auto">
                                    <div></div>
                                    <button style="padding: 10px;font-size: x-large;margin-top: 30px;" @click="addtocart(cprod)">
                                        <i class="fas fa-shopping-cart"></i>
                                        {{getcusprice(cprod)}}
                                        ADD TO CART
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- model end -->
    </div>
</div>
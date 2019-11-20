<vue>#node</vue>
<tabs :tabs="['Add Products','Product List','Enable Product']">
    <div slot="Add Products" class="fgrid">
        <dbform name="addrawprd" :forms="['Product Details','Ingredients']" action="javascript:addproduct()" method="post" autocompleate="off" sbtn="Add Product">
            <div slot="Product Details" class="gridautofr">
                <div class="fgrid">
                    <dbinput v-model="arp.pname" type="name" label="Name" required></dbinput>
                    <dbinput v-model="arp.pdvsn" type="search" :updkey="['dvid']" sql="select * from dvsn" fcol="dvsnname" label="Division" @onadd="(v,df)=>{df();}" required></dbinput>
                    <dbinput v-model="arp.pcat" type="search" :updkey="['catid']" sql="select * from cat" fcol="catname" label="Category" @onadd="(v,df)=>{df();}" required></dbinput>
                    <dbinput v-model="arp.ptype" type="search" :updkey="['typid']" sql="select * from type" fcol="typname" @onadd="(v,df)=>{df();}" label="Type" required></dbinput>
                    <dbinput v-model="arp.pgst" type="number" label="GST" min="0" required></dbinput>
                    <dbinput v-model="arp.pveg" type="switch" label="is Veg ?" required>
                        {{arp.pveg?"Yes":"No"}}
                    </dbinput>
                </div>
                <div class="fgrid" style="padding: 0px 10px;">
                    <table class="col">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Size</th>
                                <th>Stock</th>
                                <th>Min</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>MRP</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(v,i) in tarp.psz">
                                <td>{{i+1}}</td>
                                <td>
                                    <dbinput type="search" sql="select name from psz" fcol="name" :updkey="['pszid']" @onadd="(val,df)=>{df();}" v-model="tarp.psz[i]" :all="true" required></dbinput>
                                </td>
                                <td>
                                    <dbinput v-model="tarp.pqty[i]" min="0" type="number" required></dbinput>
                                </td>
                                <td>
                                    <dbinput v-model="tarp.mqty[i]" min="0" type="number" required></dbinput>
                                </td>
                                <td>
                                    <dbinput type="search" v-model="tarp.punt[i]" sql="select * from sizes" fcol="szname" :updkey="['szid']" :all="true" @onadd="(v,df)=>{df();}" required></dbinput>
                                </td>
                                <td>
                                    <dbinput v-model="tarp.posp[i]" min="0" type="number" required></dbinput>
                                </td>
                                <td>
                                    <dbinput v-model="tarp.pmrp[i]" min="0" type="number" required></dbinput>
                                </td>
                                <td>
                                    <dbinput type="label">
                                        <button type="button" v-if="i==(tarp.psz.length-1)" style="width: fit-content" @click="addpsz(i);">+ADD</button>
                                        <button type="button" v-else style="width: fit-content" @click="filterpz(i)">
                                            -DEL
                                        </button>
                                    </dbinput>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <dbinput v-model="arp.pdesc" type="textarea" label="Description"></dbinput>
                </div>
            </div>
            <div slot="Ingredients">
                <div class="fgrid" style="padding: 0px 10px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Ingredients List</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(sz,j) in tarp.psz">
                                <td>{{arp.pname}} - {{sz}}</td>
                                <td>
                                    <table class="col">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Ingredient</th>
                                                <th>Qty</th>
                                                <th>Unit</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(v,i) in tarp.ifname[j]">
                                                <td>{{i+1}}</td>
                                                <td>
                                                    <dbinput type="search" sql="SELECT *,concat(pname,'-',psz) as fullname FROM rawproducts where pcat = 'Perishable'" fcol="fullname" v-model="tarp.ifname[j][i]" @select="(v,r)=>{seting(v,r,i,j);}"></dbinput>
                                                </td>
                                                <td>
                                                    <dbinput v-model="tarp.ipqty[j][i]" min="0" type="number"></dbinput>
                                                </td>
                                                <th>
                                                    {{tarp.ipunt[j][i]}}
                                                </th>
                                                <td>
                                                    <dbinput type="label">
                                                        <button type="button" v-if="i==(tarp.ifname[j].length-1)" style="width: fit-content" @click="adding(i,j);">+ADD</button>
                                                        <button type="button" v-else style="width: fit-content" @click="filtering(i,j)">
                                                            -DEL
                                                        </button>
                                                    </dbinput>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- <div slot="Choose Suggestion" class="fgrid">
                <div v-for="(sg,i) in sug" class="fgrid" style="grid-template-columns: 1fr auto auto auto 1fr;">
                    <div></div>
                    <b>{{i+1}}</b>
                    <dbinput v-model="sug[i]" type="select" sql="select * from type" fcol="typname"></dbinput>
                    <button type="button" @click="sug = sug.filter((v,j)=>(i!=j)).map((v)=>v);">X</button>
                    <div></div>
                </div>
                <div class="fgrid" style="grid-template-columns: 1fr auto 1fr;">
                    <div></div>
                    <button type="button" @click="sug[sug.length]='';sug = sug.map((v)=>v)">Add Suggestions</button>
                    <div></div>
                </div>
            </div>
            <div slot="Vendor Details" class="gridautofr">
                <dbinput type="multi-search" label="Vendor" sql="select * from vendor" fcol="vname" @multi-select="(v)=>{arp.vname=v.col('vname').join();arp.vid=v.col('vid').join();}"></dbinput>
                <div class="grid">
                    <table>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Price</th>
                        </tr>
                        <tr v-for="(nm,i) in arp.vname.split(',')" v-if="arp.vname!=''">
                            <td>{{i+1}}</td>
                            <td>{{nm}}</td>
                            <td>
                                <dbinput type="number" v-model="tarp.vprice[i]" placeholder="Price" min="0" required></dbinput>
                            </td>
                        </tr>
                    </table>
                </div>
            </div> -->
        </dbform>
    </div>
    <div slot="Product List" class="fgrid">
        <dbtable name="ptbl" class="col" sql="select * from products where pinv='Sales' order by regtime desc" :fcol="['pname','psz','pdvsn','pcat','ptype','pqty','punt','mqty','posp','pmrp','ingredients','pveg']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']">
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="flex-fluid center">
                            <!-- <div class="flex-fluid">
                                <div>Cost Value :</div>
                                <div>
                                    <dbinput v-model="sv" type="search" sql="select * from vendor" fcol="vname" placeholder="Choose Vendor"></dbinput>
                                </div>
                                <div>{{d.row.map((v)=>{return isNaZ(v.vprice.split(',')[v.vname.split(',').indexOf(sv)])*v.pqty}).sum().toCur()}}</div>
                            </div> -->
                            <div>Sell Value : {{d.row.map((v)=>{return isNaZ(v.posp)*v.pqty}).sum().toCur()}}</div>
                            <div>MRP Value : {{d.row.map((v)=>{return isNaZ(v.pmrp)*v.pqty}).sum().toCur()}}</div>
                        </div>
                    </th>
                </tr>
            </template>
            <!-- <div slot="vname-disp" slot-scope="d" class="fgrid">
                <span v-for="(val,i) in d.rval.vname.split(',')" style="padding: 5px 2px">
                    {{val}}
                </span>
            </div>
            <div slot="vprice-disp" slot-scope="d" class="fgrid">
                <div v-if="d.rval.vprice!='NULL'" v-for="(val,i) in d.rval.vprice.split(',')" style="padding: 5px 2px">
                    <b>{{d.rval.vname.split(',')[i]}}'s Price</b>
                    <div>{{val.toCur(true)}}</div>
                </div>
                <div v-else>No Vendor Prices</div>
            </div>
            <div slot="vprice-edit" slot-scope="d" class="fgrid">
                <dbinput type="number" min='0' v-if="d.rval.vid!='NULL'" v-for="(val,i) in d.rval.vid.split(',')" style="padding: 5px 2px" :label="d.rval.vname.split(',')[i]+`'s Price`" v-model="edit.vprice[val]" @mounted="edit.vprice[val]=(d.rval.vprice!='NULL'&&isset(d.rval.vprice.split(',')[i]))?d.rval.vprice.split(',')[i]:''">
                </dbinput>
                <dbinput v-if="d.rval.vid!='NULL'" type="button" @click="d.updateItem(null,Object.values(edit.vprice).join(),'vprice',d.rval,d.i);edit.vprice=[];">UPDATE</dbinput>
                <dbinput v-else type="button" @click="d.updateItem(null,'','vprice',d.rval,d.i);edit.vprice=[];">Close</dbinput>
            </div> -->
            <div slot="ingredients-disp" slot-scope="d" class="fgrid">
                <div class="gridfrauto" v-for="(ing,i) in Object.fill(d.rval.ingredients.json(),d.i,ing)">
                    <div>{{i+1}} {{ing.ifname}}</div>
                    <div>{{ing.ipqty}} {{ing.ipunt}} {{ing.posp}}</div>
                </div>
            </div>
            <div slot="ingredients-edit" slot-scope="d" class="fgrid">
                <table>
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Ingredients</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(ig,i) in ing[d.i]">
                            <td>{{i+1}}</td>
                            <td>
                                <dbinput type="select" sql="SELECT *,concat(pname,'-',psz) as fullname FROM rawproducts where pcat = 'Perishable'" fcol="fullname" v-model="ing[d.i][i].ifname" fcol="fname" @select="(v,r)=>{upding(d.i,i,r);}" :all="true" required></dbinput>
                            </td>
                            <td>
                                <dbinput type="number" v-model="ing[d.i][i].ipqty"></dbinput>
                            </td>
                            <td>
                                <button type="button" @click="ingdel(d.i,i);">-DEL</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                #
                            </td>
                            <td>
                                <button type="button" @click="ingadd(d.i)">ADD</button>
                            </td>
                            <td>
                                <button type="button" @click="d.updateItem(null,JSON.stringify(ing[d.i]),'ingredients',d.rval,d.i);">UPDATE</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div slot="pveg" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.pveg" @onswitch="(v)=>{d.updateItem(null,v,'pveg',d.rval,d.i);}">{{(d.rval.pveg+'').parse('int')?'Veg':'Non Veg'}}</dbinput>
            </div>
        </dbtable>
    </div>
    <div slot="Enable Product" class="fgrid">
        <dbtable name="etbl" class="col" sql="select * from products order by regtime desc" :fcol="['pname','psz','penb']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']">
            <div slot="penb" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.penb" type="switch" @onswitch="(v)=>{d.updateItem(null,v,'penb',d.rval,d.i);}">
                    {{(d.rval.penb+'').parse('int')?'Yes':'No'}}
                </dbinput>
            </div>
        </dbtable>
    </div>
</tabs>
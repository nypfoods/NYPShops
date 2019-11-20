<vue>#node</vue>
<tabs :tabs="['Add Products','Product List','Add Vendor']">
    <div slot="Add Products" class="fgrid">
        <form name="addrawprd" :forms="['Product Details']" action="javascript:addproduct()" method="post" autocompleate="off" sbtn="Add Product">
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
                                    <dbinput type="search" sql="select name from psz" fcol="name" :updkey="['pszid']" @onadd="(val,df)=>{df();}" v-model="tarp.psz[i]" required></dbinput>
                                </td>
                                <td>
                                    <dbinput v-model="tarp.pqty[i]" min="0" type="number" required></dbinput>
                                </td>
                                <td>
                                    <dbinput v-model="tarp.mqty[i]" min="0" type="number" required></dbinput>
                                </td>
                                <td>
                                    <dbinput type="search" v-model="tarp.punt[i]" sql="select * from sizes" fcol="szname" :updkey="['szid']" @onadd="(v,df)=>{df();}" required></dbinput>
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
            <div>
                <dbinput type="submit" style="width: fit-content;float: right;">Submit</dbinput>
            </div>
        </form>
    </div>
    <div slot="Product List" class="fgrid">
        <dbtable name="ptbl" class="col" sql="select * from rawproducts where pinv='Production' order by regtime desc" :fcol="['pname','psz','pdvsn','pcat','ptype','punt','pqty','mqty','posp','pmrp','pveg','penb']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']">
            <div slot="pveg" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.pveg" @onswitch="(v)=>{d.updateItem(null,v,'pveg',d.rval,d.i);}">{{(d.rval.pveg+'').parse('int')?'Veg':'Non Veg'}}</dbinput>
            </div>
            <div slot="penb" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.penb" type="switch" @onswitch="(v)=>{d.updateItem(null,v,'penb',d.rval,d.i);}">
                    {{(d.rval.penb+'').parse('int')?'Yes':'No'}}
                </dbinput>
            </div>
        </dbtable>
    </div>
    <div slot="Add Vendor" class="fgrid">
        <dbtable name="pvtbl" class="col" sql="select * from rawproducts where pinv='Production' order by regtime desc" :fcol="['pname','psz','pdvsn','pcat','pqty','mqty','ptype','vname','vprice']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']" :freez="['pname']">
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="flex-fluid center">
                            <div class="flex-fluid">
                                <div>Cost Value :</div>
                                <div>
                                    <dbinput v-model="sv" type="search" sql="select * from online_vendor" fcol="name" placeholder="Choose Vendor"></dbinput>
                                </div>
                                <div>{{d.row.map((v)=>{return isNaZ(v.vprice.split(',')[v.vname.split(',').indexOf(sv)])*v.pqty}).sum().toCur()}}</div>
                            </div>
                            <div>Sell Value : {{d.row.map((v)=>{return isNaZ(v.posp)*v.pqty}).sum().toCur()}}</div>
                            <div>MRP Value : {{d.row.map((v)=>{return isNaZ(v.pmrp)*v.pqty}).sum().toCur()}}</div>
                        </div>
                    </th>
                </tr>
            </template>
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
            <div slot="vprice-edit" slot-scope="d" class="fgrid">
                <dbinput type="number" min='0' v-if="d.rval.vid!='-'" v-for="(val,i) in d.rval.vid.split(',')" style="padding: 5px 2px" :label="d.rval.vname.split(',')[i]+`'s Price`" v-model="edit.vprice[val]" @mounted="edit.vprice[val]=(d.rval.vprice!='NULL'&&isset(d.rval.vprice.split(',')[i]))?d.rval.vprice.split(',')[i]:''">
                </dbinput>
                <dbinput v-if="d.rval.vid!='-'" type="button" @click="d.updateItem(null,Object.values(edit.vprice).join(),'vprice',d.rval,d.i);edit.vprice=[];">UPDATE</dbinput>
                <dbinput v-else type="button" @click="d.updateItem(null,'','vprice',d.rval,d.i);edit.vprice=[];">Close</dbinput>
            </div>
        </dbtable>
    </div>
</tabs>
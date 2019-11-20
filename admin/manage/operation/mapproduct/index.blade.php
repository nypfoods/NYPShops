<tabs :tabs="['Map Products','View Map Products','Enabled Products','Disabled Products']">
    <template slot="Map Products">
        <dbtable name="ptbl" class="col" sql="select * from products where pinv='Production' and penb='1' order by regtime desc" :fcol="['pname','psz','pcat','ptype','pqty','mqty','posp','pmrp','penb']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']">
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="flex-fluid center">
                            <div>Sell Value : {{d.row.map((v)=>{return isNaZ(v.posp)*v.pqty}).sum().toCur()}}</div>
                            <div>MRP Value : {{d.row.map((v)=>{return isNaZ(v.pmrp)*v.pqty}).sum().toCur()}}</div>
                        </div>
                    </th>
                </tr>
            </template>
            <div slot="pqty-disp" slot-scope="d">
                {{d.rval.pqty}} {{d.rval.punt}}
            </div>
            <div slot="penb" slot-scope="d">
                <dbinput v-model="getBool(saleprod,d.rval,d.i)[d.i]" type="switch" :status_true="true" :status_false="false" @onswitch="(v)=>{mapProduct(v,d.rval,d.fetchData);}">
                    {{getBool(saleprod,d.rval,d.i)[d.i]?"Yes":"No"}}
                </dbinput>
            </div>
        </dbtable>
    </template>
    <template slot="View Map Products">
        <dbtable name="stbl" class="col" sql="select * from products where pinv='Sales' order by regtime desc" :fcol="['pname','psz','pcat','ptype','pqty','mqty','posp','pmrp','penb','pveg']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']" @onrow="chkenb">
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="flex-fluid center">
                            <div>Sell Value : {{d.row.map((v)=>{return isNaZ(v.posp)*v.pqty}).sum().toCur()}}</div>
                            <div>MRP Value : {{d.row.map((v)=>{return isNaZ(v.pmrp)*v.pqty}).sum().toCur()}}</div>
                        </div>
                    </th>
                </tr>
            </template>
            <div slot="pqty-disp" slot-scope="d">
                {{d.rval.pqty}} {{d.rval.punt}}
            </div>
            <div slot="penb" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.penb" type="switch" @onswitch="(v)=>{d.updateItem(null,v,'penb',d.rval,d.i);}">
                    {{(d.rval.penb+'').parse('int')?'Yes':'No'}}
                </dbinput>
            </div>
            <div slot="pveg" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.pveg" @onswitch="(v)=>{d.updateItem(null,v,'pveg',d.rval,d.i);}">{{(d.rval.pveg+'').parse('int')?'Veg':'Non Veg'}}</dbinput>
            </div>
        </dbtable>
    </template>
    <template slot="Enabled Products">
        <dbtable name="estbl" class="col" sql="select * from products where pinv='Sales' and penb=1 order by regtime desc" :fcol="['pname','psz','pcat','ptype','pqty','mqty','posp','pmrp','penb','pveg']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']">
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="flex-fluid center">
                            <div>Sell Value : {{d.row.map((v)=>{return isNaZ(v.posp)*v.pqty}).sum().toCur()}}</div>
                            <div>MRP Value : {{d.row.map((v)=>{return isNaZ(v.pmrp)*v.pqty}).sum().toCur()}}</div>
                        </div>
                    </th>
                </tr>
            </template>
            <div slot="pqty-disp" slot-scope="d">
                {{d.rval.pqty}} {{d.rval.punt}}
            </div>
            <div slot="penb" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.penb" type="switch" @onswitch="(v)=>{d.updateItem(null,v,'penb',d.rval,d.i);}">
                    {{(d.rval.penb+'').parse('int')?'Yes':'No'}}
                </dbinput>
            </div>
            <div slot="pveg" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.pveg" @onswitch="(v)=>{d.updateItem(null,v,'pveg',d.rval,d.i);}">{{(d.rval.pveg+'').parse('int')?'Veg':'Non Veg'}}</dbinput>
            </div>
        </dbtable>
    </template>
    <template slot="Disabled Products">
        <dbtable name="dstbl" class="col" sql="select * from products where pinv='Sales' and penb=0 order by regtime desc" :fcol="['pname','psz','pcat','ptype','pqty','mqty','posp','pmrp','penb','pveg']" :dcol="dcol" :attrs="attrs" @delete="(df)=>{df()}" :updkey="['pid']">
            <template slot="thead" slot-scope="d">
                <tr>
                    <th :colspan="d.colspan">
                        <div class="flex-fluid center">
                            <div>Sell Value : {{d.row.map((v)=>{return isNaZ(v.posp)*v.pqty}).sum().toCur()}}</div>
                            <div>MRP Value : {{d.row.map((v)=>{return isNaZ(v.pmrp)*v.pqty}).sum().toCur()}}</div>
                        </div>
                    </th>
                </tr>
            </template>
            <div slot="pqty-disp" slot-scope="d">
                {{d.rval.pqty}} {{d.rval.punt}}
            </div>
            <div slot="penb" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.penb" type="switch" @onswitch="(v)=>{d.updateItem(null,v,'penb',d.rval,d.i);}">
                    {{(d.rval.penb+'').parse('int')?'Yes':'No'}}
                </dbinput>
            </div>
            <div slot="pveg" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.pveg" @onswitch="(v)=>{d.updateItem(null,v,'pveg',d.rval,d.i);}">{{(d.rval.pveg+'').parse('int')?'Veg':'Non Veg'}}</dbinput>
            </div>
        </dbtable>
    </template>
</tabs>
<vue>#node</vue>
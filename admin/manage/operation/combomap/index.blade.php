<div style="display: grid;grid-template-columns: 1fr 2fr">
    <div>
        <h3 class="center">Combo List</h3>
        <dbtable name="ptbl" v-model="combo" sql="select * from products where ptype='Combo' and pinv='Production'" :fcol="['pname','psz','posp']" :dcol="{pname:'Product Name',psz:'Size',posp:'Price'}" :selectable="true" :editable="false">
        </dbtable>
    </div>
    <div class="fgrid">
        <table v-if="combo">
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(prd,i) in comboobj">
                    <td class="center">{{i+1}}</td>
                    <td>
                        <dbinput type="search" v-model="comboobj[i].pname" sql="select * from products where pcat='Showcase' and pinv='Sales' and ptype<>'Combo'" fcol="pname" @select="(v,r)=>{hdlPrdSrch(i,r);}">
                        </dbinput>
                    </td>
                    <td>
                        <dbinput type="number" v-model="comboobj[i].pqty" @select="(v,r)=>{hdlPrdSrch(i);}">
                        </dbinput>
                    </td>
                    <td>
                        {{comboobj[i].posp}}
                    </td>
                    <td>
                        <button style="width: fit-content" @click="rmvecomboprd(i);">-DEL</button>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2">
                        Total:{{comboobj.map((v)=>v.posp*v.pqty).sum().toCur()}}
                    </th>
                    <td colspan="3" class="right">
                        <button style="width: fit-content" @click="()=>{addcomboprd()}">+ADD</button>
                        <button style="width: fit-content" @click="updatecombo">UPDATE</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<vue>#node</vue>
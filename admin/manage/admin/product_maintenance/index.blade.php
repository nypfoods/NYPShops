<tabs :tabs="['Product Maintainance']">
    <template slot="Product Maintainance">
        <div class="gridfrfr">
            <div>
                <div class="gridfrfr">
                    <dbinput type="select" :options="['Multi Transfer','Single Transfer']" v-model="trns" label="Method"></dbinput>
                    <dbinput type="select" label="From" :sql="`select * from inventory where name<>'${invfrom}'`" v-model="invfrom" fcol="name" :all="true"></dbinput>
                </div>
                <dbtable name="tfrom" :sql="`select *,IF(pqty>0,pqty,0) as tqty from rawproducts where pinv='${invfrom}'`" :fcol="['pname','pqty','mqty','tqty']" :dcol="{pname:'Product Name',pqty:'Qty',mqty:'Minimum',tqty:'Transfer'}" :editable="false" :multiselect="trns=='Multi Transfer'">
                    <div slot="tqty_th" slot-scope="d" v-if="trns=='Multi Transfer'">
                        <div class="gridfrauto">
                            <dbinput class="fit" type="button" @click="bulkTransfer(d,$event)">Transfer</dbinput>
                        </div>
                    </div>
                    <div slot="pname-disp" slot-scope="d">
                        <div style="font-weight: bold;">{{d.rval.pname}}</div>
                        <div style="font-style: italic;">{{d.rval.pcat}} {{d.rval.ptype}}</div>
                    </div>
                    <div slot="tqty" slot-scope="d">
                        <div class="gridfrauto" v-if="invfrom!=invto&&(d.rval.tqty>0||d.rval.tqty=='')&&((trns=='Multi Transfer' && d.mrow.includes(d.rval))||(trns=='Single Transfer'))">
                            <dbinput type="number" v-model="d.rval.tqty"></dbinput>
                            <dbinput v-if="trns=='Single Transfer'" type="button" @click="transferItem(d)" class="fit">Send</dbinput>
                        </div>
                    </div>
                </dbtable>
            </div>
            <div>
                <dbinput type="select" label="To" :sql="`select * from inventory where name<>'${invto}'`" v-model="invto" fcol="name" :all="true"></dbinput>
                <dbtable v-if="invfrom!=invto" name="tto" :sql="`select * from rawproducts where pinv='${invto}'`" :fcol="['pname','pqty','mqty']" :dcol="{pname:'Product Name',pqty:'Qty',mqty:'Minimum'}" :editable="false"></dbtable>
            </div>
        </div>
    </template>
</tabs>
<vue>#node</vue>
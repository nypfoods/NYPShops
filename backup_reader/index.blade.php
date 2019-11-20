<vue>#node</vue>
<tabs :tabs="['phpMyAdmin','Console','JSON Reader']">
    <div slot="JSON Reader">
        <div class="gridautofr">
            <div class="box card cardin">
                <dbtree :mytree="root.mytree" @input="loadmytree" root="/backup"></dbtree>
            </div>
            <div>
                <dbtable :fcol="tbl.fcol" :tbldata="tbl" :editable="false">
                </dbtable>
            </div>
        </div>
    </div>
    <div slot="Console" class="fgrid" style="height: calc(100% - 115px);">
        <div class="gridfrauto">
            <dbinput type="textarea" label="Command Area" v-model="cmd" :wordcase="false">
            </dbinput>
            <dbinput type="button" @click="executeCmd()" label=" ">Execute</dbinput>
        </div>
        <b>Output:</b>
        <div class="col" style="max-height: calc(100%);overflow: auto;">
            <code v-html="output">
            </code>
        </div>
    </div>
    <div slot="phpMyAdmin" class="gridautofr">
        <div class="fgrid" style="height: fit-content;">
            <div class="cp mytable" v-for="table in tables" @click="exsql=`select * from ${table} where 1`">
                {{table}}
            </div>
        </div>
        <div class="fgrid">
            <div class="gridfrauto">
                <div class="col">
                    <dbinput type="textarea" v-model="mysql" :wordcase="false"></dbinput>
                </div>
                <div>
                    <dbinput type="number" v-model="numcol">
                    </dbinput>
                    <dbinput type="button" label=" " @click="setMySql()">RUN</dbinput>
                </div>
            </div>
            <dbtable :sql="exsql" :fcol="mycol" @onrow="setMyCol">
            </dbtable>
        </div>
    </div>
</tabs>
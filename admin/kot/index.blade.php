<tabs :tabs="['Kitchen Orders']">
    <template slot="Kitchen Orders">
        <div>
            <dbdata name="ordrs" class="fgrid" :sql="`select eid,ordid,ordsts,bilno,regtime,bchn from counter  where ordsts='B'`" groupby="bilno">
                <template slot="row" slot-scope="b">
                    <div class="card">
                        <div style="font-weight: bold;">
                            <div class="gridfrfr">
                                <div class="gridautofr">
                                    <div>Counter Order# </div>
                                    <div class="pl-5">{{b.val.bilno}}</div>
                                </div>
                                <div class="gridautofr">
                                    <div>Table# </div>
                                    <div class="pl-5"><b>{{b.val.bchn}}</b></div>
                                </div>
                            </div>
                            <div class="gridfrfr">
                                <div class="gridautofr">
                                    <div>Punched@ </div>
                                    <div class="pl-5"><b>{{extract_time(new Date(b.val.regtime)) }}</b></div>
                                </div>
                                <div class="gridautofr">
                                    <div>Time Used </div>
                                    <div class="pl-5" v-if="round(((elapsed_time).getTime()-(new Date(b.val.regtime)).getTime())/(1000*60),2)>30">
                                        <b>
                                            <span style="color: red">{{round(((elapsed_time).getTime()-(new Date(b.val.regtime)).getTime())/(1000*60),2)}}</span>
                                        </b>
                                    </div>
                                    <div class="pl-5" v-if="round(((elapsed_time).getTime()-(new Date(b.val.regtime)).getTime())/(1000*60),2)<30">
                                        <b>
                                            <span style="color: green">{{round(((elapsed_time).getTime()-(new Date(b.val.regtime)).getTime())/(1000*60),2)}}</span>
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <dbdata :sql="`select * from(select ordid,bilno,c.pname,ptpng,c.regtime,ingredients,c.psz,c.pqty,p.pveg from counter as c join products as p where c.ordsts='B' and c.pid=p.pid and pinv='sales' and bilno='${b.val.bilno}') as counter`">
                            <div slot="row" slot-scope="d">
                                <h2 :class="{center:true,'f-veg':d.val.pveg==1,'f-nonveg':d.val.pveg==0}"><b>{{d.val.pname}}</b></h2>
                                <div>
                                    <div class="gridauto">
                                        <span style="font-size: 17px;" v-for="(val,i) in d.val.ptpng.json()" v-if="val.ptype=='Pizza Base'"><b>Pizza Base :</b> {{val.pname}}
                                        </span>
                                        <span style="font-size: 17px;"> <b>Size :</b> {{d.val.psz}}</span>
                                        <span style="font-size: 17px;"> <b>Qty :</b> {{d.val.pqty}}</span>
                                    </div>
                                    <div v-if="d.val.pname=='Custom Pizza'">
                                        <h4 class="center"><b>Toppings</b></h4>
                                        <table class="col">
                                            <thead>
                                                <tr>
                                                    <th>Veg</th>
                                                    <th>Name</th>
                                                    <th>Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(val,i) in d.val.ptpng.json()" v-if="val.ptype!='Pizza Base'">
                                                    <td>{{val.pveg==0?"Non Veg":"Veg"}}</td>
                                                    <td>{{val.pname}}</td>
                                                    <td>{{val.pqty}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-if="Object.values(d.val.ingredients.json()).length>0">
                                        <h4 class="center"><b>Ingredients</b></h4>
                                        <div v-for="(val,i) in d.val.ingredients.json()" v-if="val.ipname!=''">
                                            <span>{{val.ipname}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </dbdata>
                        <button @click="counterstatus(b.val['bilno'],b.val['ordsts'],b.val['eid'],b.val['ordid'])" class="btn"><i class="fa fa-arrow-right" aria-hidden="true"></i> Prepared</button>
                    </div>
                </template>
            </dbdata>
        </div>
    </template>
</tabs>
<vue>#node</vue>
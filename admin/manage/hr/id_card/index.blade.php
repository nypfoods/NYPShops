<vue>#node</vue>
<tabs :tabs="['Generate ID Card']">
    <div slot="Generate ID Card" class="fgrid">
        <div id="appreg">
            <div>
                <div class="flex-fluid">
                    <dbinput v-model="flds.department" type="select" sql="select * from department" fcol="dname" label="Department" :ivalue="flds.department"></dbinput>
                    <dbinput v-model="flds.designation" type="select" :sql="dessql" fcol="desname" label="Designation"></dbinput>
                    <dbinput v-model="flds.fname" type="search" :sql="fsql" fcol="fname" label="Employee Name"></dbinput>
                </div>
                <div>
                    <div class="grid c-card cardsss a4lw">
                        <dbdata name="cardsss" class="grid" :sql="idsql">
                            <template slot="row" slot-scope="d">
                                <div class="card">
                                    <div style="height: 100%" class="cp">
                                        <div style="text-align:left;">
                                            <div>
                                                <h2 class="center">IDENTITY CARD</h2>
                                            </div>
                                            <div class="gridautofr">
                                                <div style="width:150px;height: 150px">
                                                    <dbfile class="imgo" :upload="`upload/${ldb}/employee/${d.val.eid}`" filename="pp.png" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}" :isedit="false">
                                                        <div slot="onupload"></div>
                                                    </dbfile>
                                                </div>
                                                <div style="min-width: 230px;">
                                                    <div class="fgrid">
                                                        <label>Name</label>
                                                        <b class="right">{{d.val.fname}}</b>
                                                    </div>
                                                    <div class="fgrid">
                                                        <label>Designation</label>
                                                        <b class="right">{{d.val.designation}}</b>
                                                    </div>
                                                    <div class="fgrid">
                                                        <label>Employee Id</label>
                                                        <b class="right">{{d.val.uname}}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </dbdata>
                    </div>
                </div>
            </div>
        </div>
        <dbinput type="button" value="" @click="t$('.cardsss').print()">Print</dbinput>
    </div>
</tabs>
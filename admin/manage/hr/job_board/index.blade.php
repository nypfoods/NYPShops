<vue>#node</vue>
<tabs :tabs="['Add Job','View Jobs']">
    <div slot="Add Job" class="fgrid">
        <div id="appreg">
            <div>
                <form autocomplete="off" class="grid" name="myfrm" action="javascript:addjob()" @invalid="" @onnext="">
                    <dbinput v-model="flds.department" type="search" sql="select * from department" fcol="dname" label="Department" :ivalue="flds.department" required></dbinput>
                    <dbinput v-model="flds.designation" type="search" :sql="dessql" fcol="desname" label="Designation" required></dbinput>
                    <dbinput type="text" label="Title" v-model="flds.title" required></dbinput>
                    <dbinput type="text" label="Skill Set" v-model="flds.skill" required></dbinput>
                    <dbinput type="textarea" label="Description" v-model="flds.description" required></dbinput>
                    <dbinput type="submit" value="" label=" ">Submit</dbinput>
                </form>
            </div>
        </div>
    </div>
    <div slot="View Jobs" class="fgrid">
        <dbtable name="ptbl" class="col" sql="select * from job_board order by regtime desc" :fcol="['department','designation','title','skill','description','status']" :dcol="dcol" @delete="(df)=>{df()}" :updkey="['id']" :editable="false">
            <div slot="status" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.status" type="switch" @onswitch="(v)=>{d.updateItem(null,v,'status',d.rval,d.i);}">
                    {{(d.rval.status+'').parse('int')?'Yes':'No'}}
                </dbinput>
            </div>
        </dbtable>
    </div>
</tabs>
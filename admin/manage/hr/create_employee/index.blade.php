<vue>#node</vue>
<tabs :tabs="['Add Employee','Employee List','Enabled Employee','Disabled Employee','Upload Photos']">
    <template slot="Add Employee">
        <dbform :forms="['General Details','Personal Details','Bank Details']" autocomplete="off" name="myfrm" action="javascript:void(0)" @invalid="" @onnext="" @onsubmit="addemployee()">
            <div slot="General Details" class="grid">
                <dbinput type="search" sql="select * from online_employee where complete=1" v-model="regpf.sid" fcol="uname" label="Select Id" @select="hadelEmployeeSearch"></dbinput>
                <dbinput type="name" label="First Name " v-model="apf.fname" required></dbinput>
                <dbinput type="name" label="Middle Name" v-model="apf.mname"></dbinput>
                <dbinput type="name" label="Last Name " v-model="apf.lname" required></dbinput>
                <dbinput type="email" label="Email" v-model="apf.email" required></dbinput>
                <dbinput type="date" label="DOB" v-model="apf.dob" required></dbinput>
                <dbinput type="select" label="Merital Status " v-model="apf.merital_status" :options="['Married','Single']" required></dbinput>
                <dbinput type="date" label="Joining Date" v-model="apf.doj" required></dbinput>
                <dbinput type="number" label="Experience" v-model="apf.exp" required></dbinput>
                <dbinput type="number" label="CTC" v-model="apf.ctc" required></dbinput>
                <dbinput type="select" label="Package Name" :updkey="['pkgid']" sql="select * from package" :fcol="['pkgname']" v-model="apf.pkgname" @select="(val,row)=>{apf.pkgid=row.pkgid;}" required>
                </dbinput>
                <!-- <dbinput  :updkey="['bid']" sql="select * from blocation" type="location"  fcol="blname" label="Business Location" required @select="handelBlocation"></dbinput> -->
                <dbinput type="select" sql="select * from department" fcol="dname" label="Department" required @select="(val,row)=>{apf.department=row.dname}"></dbinput>
                <dbinput type="select" :sql="dessql" fcol="desname" label="Designation" required @select="(val,row)=>{apf.designation=row.desname}"></dbinput>
                <dbinput type="select" label="Gender " v-model="apf.gender" :options="['Male','Female']" required></dbinput>
                <dbinput type="text" label="Note" v-model="apf.note"></dbinput>
                <dbinput type="file" label="Upload Profile" :upload="`upload/${ldb}/employee/temp/${ssid}/`" filename="pp.png" style="width:250px;height: 250px" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}" @upload="(tpath,src)=>{tempf['pp']=tpath}" @created="(obj)=>{imgobj['pp']=obj;}" @amounted="(obj)=>{tempf['pp']=obj.tpath}"></dbinput>
                <dbinput type="file" label="Experience Certificate" :upload="`upload/${ldb}/employee/temp/${ssid}/`" filename="ec.png" style="width:250px;height: 250px" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}" @upload="(tpath,src)=>{tempf['ec']=tpath}" @created="(obj)=>{imgobj['ec']=obj;}" @amounted="(obj)=>{tempf['ec']=obj.tpath}"></dbinput>
            </div>
            <div slot="Personal Details" class="flex-fluid" style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr">
                <dbinput type="mob" label="Mobile Number" v-model="apf.mnumber" required></dbinput>
                <dbinput type="mob" label="Landline number" v-model="apf.lnumber"></dbinput>
                <dbinput type="textarea" label="Addres" v-model="apf.address1" required></dbinput>
                <dbinput type="textarea" label="Additional Address Details" v-model="apf.address2"></dbinput>
                <dbinput :updkey="['sid']" sql="select * from state group by state" type="search" v-model="apf.state" fcol="state" label="State" @onadd="(val,df)=>{df();}" :defaultcol="{sid:uid()}" @onrow="(row,col)=>{statearr = row.col('state')}" required></dbinput>
                <dbinput :updkey="['cid']" :defaultcol="{cid:uid()}" sql="select * from city group by city" type="search" v-model="apf.city" fcol="city" label="City" @onadd="(val,df)=>{df();}" @onrow="(row,col)=>{cityarr = row.col('city')}" required></dbinput>
                <dbinput type="select" label="Working Shift" v-model="apf.shift" :options="['Morning','Night']"></dbinput>
                <dbinput type="text" label="Pincode" v-model="apf.pincode"></dbinput>
                <dbinput type="text" label="Guardian Name" v-model="apf.nokname"></dbinput>
                <dbinput type="text" label="Guardian Email" v-model="apf.nokemail"></dbinput>
                <dbinput type="text" label="Guardian Number" v-model="apf.nokmnumber"></dbinput>
                <dbinput type="text" label="Guardian Address" v-model="apf.nokaddress"></dbinput>
                <dbinput type="file" label="Upload Aadhar" :upload="`upload/${ldb}/employee/temp/${ssid}/`" filename="adhar.png" style="width:250px;height: 250px" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}" @upload="(tpath,src)=>{tempf['adhar']=tpath}" @created="(obj)=>{imgobj['adhar']=obj;}" @amounted="(obj)=>{tempf['adhar']=obj.tpath}"></dbinput>
                <dbinput type="file" label="Upload Pan" :upload="`upload/${ldb}/employee/temp/${ssid}/`" filename="pan.png" style="width:250px;height: 250px" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}" @upload="(tpath,src)=>{tempf['pan']=tpath}" @created="(obj)=>{imgobj['pan']=obj;}" @amounted="(obj)=>{tempf['pan']=obj.tpath}"></dbinput>
                <dbinput type="file" label="Upload DL" :upload="`upload/${ldb}/employee/temp/${ssid}/`" filename="dl.png" style="width:250px;height: 250px" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}" @upload="(tpath,src)=>{tempf['dl']=tpath}" @created="(obj)=>{imgobj['dl']=obj;}" @amounted="(obj)=>{tempf['dl']=obj.tpath}"></dbinput>
            </div>
            <div slot="Bank Details" class="flex-fluid" style="display: grid;grid-template-columns: 1fr 1fr 1fr 1fr">
                <dbinput type="name" label="Bank Name" v-model="apf.bank"></dbinput>
                <dbinput type="text" label="Account number" v-model="apf.anum"></dbinput>
                <dbinput type="text" label="AccountHolder Name" v-model="apf.aholname"></dbinput>
                <dbinput type="text" label="Branch Name" v-model="apf.branch"></dbinput>
                <dbinput type="text" label="IFSC Code" v-model="apf.ifsc"></dbinput>
                <dbinput type="pan" label="Pan number" v-model="apf.pan"></dbinput>
                <dbinput type="file" label="Upload Bank Document" :upload="`upload/${ldb}/employee/temp/${ssid}/`" filename="bank.png" style="width:250px;height: 250px" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}" @upload="(tpath,src)=>{tempf['bank']=tpath}" @created="(obj)=>{imgobj['bank']=obj;}" @amounted="(obj)=>{tempf['bank']=obj.tpath}"></dbinput>
            </div>
        </dbform>
    </template>
    <template slot="Employee List">
        <dbtable name="etbl" sql="select * from employee where active=1" :fcol="['fname','lname','department','designation','doj','email','mnumber','active']" :dcol="{fname:'First Name',lname:'Last Name',department:'Department',designation:'Designation',doj:'Joining date',email:'Email',mnumber:'Mobile Number',active:'Access Status'}" :updkey="['eid']" @delete="(df)=>{df();}" :coltype="{active:'switch',department:'select',designation:'select',
    state:'select',city:'select',
    business_location:'location',email:'email',doj:'date',mnumber:'mob'}" :colopt="{department:deparr,designation:desarr,state:statearr,city:cityarr}" @onadd="function(df,dcol){findcol=dcol;onappemp=df}" :defaultcol="apf" @expand="()=>{}">
            <template slot="detailed" slot-scope="d">
                <formfill action="javascript:alert('submited');" :fcol="Object.filter(d.rval,[],['epwd','eid','uid','mid','fid','stid','uname','regtime','updtime','active','enum','pfrom','pto','pdesignation','pdepartment'],updemp.fval)" :dcol="Object.assign(updemp.dcol,{pcompany:' '})" :attrs="updemp.attrs" :visible="{pcompany:false}">
                    <template slot="pcompany_pre-content">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Previous Company Name</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(val,i) in d.rval.pcompany.split(',')">
                                    <td>{{i+1}}</td>
                                    <td>{{val}}</td>
                                    <td>{{d.rval.pfrom.split(',')[i]}}</td>
                                    <td>{{d.rval.pto.split(',')[i]}}</td>
                                    <td>{{d.rval.pdepartment.split(',')[i]}}</td>
                                    <td>{{d.rval.pdesignation.split(',')[i]}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <template slot="extra" slot-scope="d">
                        <dbinput label="" type="submit">UPDATE</dbinput>
                    </template>
                </formfill>
            </template>
            <template slot="active" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.active" @input="d.updateItem(null,d.rval.active,'active',d.rval,d.i)"></dbinput>
            </template>
        </dbtable>
    </template>
    <template slot="Enabled Employee">
        <dbtable sql="select * from employee where active=1" :fcol="['fname','lname','department','designation','doj','business_location','email','mnumber','active']" :dcol="{fname:'First Name',lname:'Last Name',department:'Department',designation:'Designation',doj:'Joining date',business_location:'Business Location',email:'Email',mnumber:'Mobile Number',active:'Access Status'}" :updkey="['eid']" :editable="false" :coltype="{active:'switch',department:'select',designation:'select',state:'select',city:'select',business_location:'location'}" :colopt="{department:deparr,designation:desarr,state:statearr,city:cityarr}">
            <template slot="active" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.active" @input="d.updateItem(null,d.rval.active,'active',d.rval,d.i)"></dbinput>
            </template>
        </dbtable>
    </template>
    <template slot="Disabled Employee">
        <dbtable sql="select * from employee where active=0" :fcol="['fname','lname','department','designation','doj','business_location','email','mnumber','active']" :dcol="{fname:'First Name',lname:'Last Name',department:'Department',designation:'Designation',doj:'Joining date',business_location:'Business Location',email:'Email',mnumber:'Mobile Number',active:'Access Status'}" :updkey="['eid']" :editable="false" :coltype="{active:'switch',department:'select',designation:'select',state:'select',city:'select',business_location:'location'}" :colopt="{department:deparr,designation:desarr,state:statearr,city:cityarr}">
            <template slot="active" slot-scope="d">
                <dbinput type="switch" v-model="d.rval.active" @input="d.updateItem(null,d.rval.active,'active',d.rval,d.i)"></dbinput>
            </template>
        </dbtable>
    </template>
    <template slot="Upload Photos">
        <dbtable name="upimg" sql="select eid,fname,mnumber,eid as aadhar,eid as pan,eid as bank,eid as dl,eid as ec,eid as pdf from employee" :fcol="['fname','eid','aadhar','pan','bank','dl','ec']" :dcol="{'fname':'First Name','eid':'Image','aadhar':'Aadhar','pan':'Pan','bank':'Bank Document','dl':'DL','ec':'Experience'}" :updkey="['eid']" :editable="false">
            <template slot="eid" slot-scope="d">
                <dbfile filename="pp.png" :upload="`upload/${ldb}/employee/${d.rval['eid']}`"></dbfile>
            </template>
            <template slot="aadhar" slot-scope="d">
                <dbfile filename="adhar.png" :upload="`upload/${ldb}/employee/${d.rval['eid']}`"></dbfile>
            </template>
            <template slot="pan" slot-scope="d">
                <dbfile filename="pan.png" :upload="`upload/${ldb}/employee/${d.rval['eid']}`"></dbfile>
            </template>
            <template slot="bank" slot-scope="d">
                <dbfile filename="bank.png" :upload="`upload/${ldb}/employee/${d.rval['eid']}`"></dbfile>
            </template>
            <template slot="dl" slot-scope="d">
                <dbfile filename="dl.png" :upload="`upload/${ldb}/employee/${d.rval['eid']}`"></dbfile>
            </template>
            <template slot="ec" slot-scope="d">
                <dbfile filename="ec.png" :upload="`upload/${ldb}/employee/${d.rval['eid']}`"></dbfile>
            </template>
        </dbtable>
    </template>
</tabs>
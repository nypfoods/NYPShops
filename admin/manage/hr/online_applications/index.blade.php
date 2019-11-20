<vue>#node</vue>
<tabs :tabs="['Master Franchise','Franchise','Vendor']">
    <template slot="Master Franchise">
        <dbtable name="etbl" sql="select *,id as pdf from online_franchise where ftype='MASTER FRANCHISE'" :fcol="['pname','pmob','pemail','ptel_no','ptime','pdf','approve','active']" :dcol="{pname:'Name',pmob:'Mobile Tel. No.',pemail:'Email',ptel_no:'Resi. Tel. No.',
        ptime:'Best Time to Call',active:'Access Status',pdf:'Form',approve:'Approve'}" :updkey="['id']" :coltype="{active:'switch'}" @delete="(df)=>{df();}" @delrow="(row,i)=>{delerowfiles(row,i,'franchise')}" :editable="false">
            <template slot="pdf" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/franchise/onlineforms/${d.rval['id']}/franchise_registration.pdf`)">Open</button>
            </template>
            <template slot="active" slot-scope="d">
                <div v-if="d.rval.approve==1">
                    <div>On active Mail will send to {{d.rval.pemail}}</div>
                    <dbinput type="switch" v-model="d.rval.active" @onswitch="(v)=>sendCredentials(d.rval,'master',v)"></dbinput>
                </div>
            </template>
            <div slot="approve" slot-scope="d">
                <button @click="approvemfranchise(d,'master')" v-if="d.rval.approve==0"> Approve</button>
                <div v-if="d.rval.approve==1" style="color:green">Approved</div>
            </div>
        </dbtable>
    </template>
    <template slot="Franchise">
        <dbtable name="fran" sql="select *,id as pdf from online_franchise where ftype='FRANCHISE'" :fcol="['pname','pmob','pemail','ptel_no','ptime','pdf','approve','active']" :dcol="{pname:'Name',pmob:'Mobile Tel. No.',pemail:'Email',ptel_no:'Resi. Tel. No.',
    ptime:'Best Time to Call',active:'Access Status',pdf:'Form',approve:'Approve'}" :updkey="['id']" :coltype="{active:'switch'}" @delete="(df)=>{df();}" :editable="false" @delrow="(row,i)=>{delerowfiles(row,i,'franchise')}">
            <template slot="pdf" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/franchise/onlineforms/${d.rval['id']}/franchise_registration.pdf`)">Open</button>
            </template>
            <template slot="active" slot-scope="d">
                <div v-if="d.rval.approve==1">
                    <div>On active Mail will send to {{d.rval.pemail}}</div>
                    <dbinput type="switch" v-model="d.rval.active" @onswitch="(v)=>sendCredentials(d.rval,'franchise',v)"></dbinput>
                </div>
            </template>
            <div slot="approve" slot-scope="d">
                <button @click="approvemfranchise(d,'franchise')" v-if="d.rval.approve==0"> Approve</button>
                <div v-if="d.rval.approve==1" style="color:green">Approved</div>
            </div>
        </dbtable>
    </template>
    <template slot="Vendor">
        <dbtable name="ven" sql="select *,vid as pdf from online_vendor" :fcol="['name','telno', 'email', 'whatsppno', 'mobno','pdf','gst_cert','isi','fssai','iso','aadhar','pan_card','cancel_cheque','approve','active']" :dcol="{name:'Name of the Firm',telno:'Tele No. (O)', email:'E – Mail', whatsppno:'Whats app No.(O)'
    , mobno:'Mobile No. (O)',pdf:'Form',active:'Access Status',approve:'Approve'}" :updkey="['vid']" :coltype="{active:'switch'}" @delete="(df)=>{df();}" :editable="false" @delrow="(row,i)=>{delerowfiles(row,i,'vendor')}">
            <template slot="pdf" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/vendor_registration.pdf`)">Open</button>
            </template>
            <template slot="gst_cert" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/gst_certificate.png`)">Open</button>
            </template>
            <template slot="isi" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/isi.png`)">Open</button>
            </template>
            <template slot="fssai" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/fssai.png`)">Open</button>
            </template>
            <template slot="iso" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/iso.png`)">Open</button>
            </template>
            <template slot="aadhar" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/aadhar.png`)">Open</button>
            </template>
            <template slot="pan_card" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/pan.png`)">Open</button>
            </template>
            <template slot="cancel_cheque" slot-scope="d">
                <button type="button" @click="window.open(`http://online.new-yorkpizza.com/index.php?get=true&path=upload/vendor/onlineforms/${d.rval['vid']}/cancel_cheque.png`)">Open</button>
            </template>
            <template slot="active" slot-scope="d">
                <div v-if="d.rval.approve==1">
                    <div>On active Mail will send to {{d.rval.email}}</div>
                    <dbinput type="switch" v-model="d.rval.active" @onswitch="(v)=>sendCredentials(d.rval,'vendor',v)"></dbinput>
                </div>
            </template>
            <div slot="approve" slot-scope="d">
                <button @click="approvemfranchise(d,'vendor')" v-if="d.rval.approve==0"> Approve</button>
                <div v-if="d.rval.approve==1" style="color:green">Approved</div>
            </div>
        </dbtable>
    </template>
    </dbtable>
    </template>
</tabs>
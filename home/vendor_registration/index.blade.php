<?php include("screen/home/carthead.php"); ?>
<clearnav></clearnav>
<vue>#node</vue>
<div id="vedreg">
    <div class="containers">
        <h1 class="hdl">Vendor Registration</h1>
        <formfill id="venreg" action="javascript:regvendor()" :fcol="flds" :dcol="fdcol" :attrs="fattrs" :visible="perm" autocomplete="off">
            <template slot="name_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><u>Company Details</u></div>
                </div>
                Name of the Firm
            </template>
            <template slot="adresss_pre-content" slot-scope="d">
                Address :-
            </template>
            <template slot="telno_pre-content" slot-scope="d">
                Tele No. (O)
            </template>
            <template slot="email_pre-content" slot-scope="d">
                E – Mail
            </template>
            <template slot="whatsppno_pre-content" slot-scope="d">
                Whats app No.(O)
            </template>
            <template slot="website_pre-content" slot-scope="d">
                Web Site
            </template>
            <template slot="mobno_pre-content" slot-scope="d">
                Mobile No. (O)
            </template>
            <template slot="owners_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>Name & Designation of Owner and Key people to be contacted</b></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10px;">
                                Sl
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Designation
                            </th>
                            <th>
                                Qualification
                            </th>
                            <th>
                                Contact Number
                            </th>
                            <th>
                                Place
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(n,i) in ownum">
                            <td style="width: 10px">
                                {{i+1}}
                            </td>
                            <td>
                                <dbinput v-model="own[i].name" type="name"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="own[i].department" type="name"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="own[i].qualification" type="text"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="own[i].mob" type="mob"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="own[i].place" type="name"></dbinput>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: right;">
                                <button type="button" style="width: fit-content" @click="ownum--;saveowner(own)">-</button>
                                <button type="button" style="width: fit-content" @click="own[ownum]={};ownum++;saveowner(own)">+</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template slot="nofbusiness_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back">
                        <b>Nature of Business (Please Pick any One)</b>
                    </div>
                </div>
                <div class="flex-fluid">
                    <dbinput @click="flds.nofbusiness='Manufacturing'" name="nofbusiness" type="radio" label="Manufacturing">
                    </dbinput>
                    <dbinput @click="flds.nofbusiness='Sole Selling Agent'" name="nofbusiness" type="radio" label="Sole Selling Agent">
                    </dbinput>
                    <dbinput @click="flds.nofbusiness='Dealer'" name="nofbusiness" type="radio" label="Dealer">
                    </dbinput>
                    <dbinput @click="flds.nofbusiness='Trader'" name="nofbusiness" type="radio" label="Trader">
                    </dbinput>
                    <dbinput @click="flds.nofbusiness='Agent'" name="nofbusiness" type="radio" label="Agent">
                    </dbinput>
                </div>
            </template>
            <template slot="nofcompany_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back">
                        <b>Nature of Company (Please Pick any One)</b>
                    </div>
                </div>
                <div class="flex-fluid">
                    <dbinput @click="flds.nofcompany='Proprietary'" name="nofcompany" type="radio" label="Proprietary">
                    </dbinput>
                    <dbinput @click="flds.nofcompany='Partnership'" name="nofcompany" type="radio" label="Partnership">
                    </dbinput>
                    <dbinput @click="flds.nofcompany='Private Ltd'" name="nofcompany" type="radio" label="Private Ltd">
                    </dbinput>
                    <dbinput @click="flds.nofcompany='Public Ltd.'" name="nofcompany" type="radio" label="Public Ltd.">
                    </dbinput>
                </div>
            </template>
            <template slot="yofesta_pre-content" slot-scope="d">
                Year of establishment
            </template>
            <template slot="vinvetp_pre-content" slot-scope="d">
                Values of Investment in Plant & Machinery
            </template>
            <template slot="scompany_pre-content" slot-scope="d">
                Number of employees
            </template>
            <template slot="erno_pre-content" slot-scope="d">
                Enterprise Registration No
            </template>
            <template slot="gstdetails_pre-content" slot-scope="d">
                GST Details
            </template>
            <template slot="panno_pre-content" slot-scope="d">
                PAN No.
            </template>
            <template slot="office_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>Factory / Offices Details</b></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10px;">
                                Sl
                            </th>
                            <th>
                                Address of Factory/Office
                            </th>
                            <th>
                                State
                            </th>
                            <th>
                                Contact Numbers
                            </th>
                            <th>
                                Email
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(n,i) in ofnum">
                            <td style="width: 10px">
                                {{i+1}}
                            </td>
                            <td>
                                <dbinput v-model="offices[i].address" type="name"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="offices[i].state" type="text"></dbinput>
                            </td>
                            <td>
                                <div class="grid" style="grid-template-columns: 1fr">
                                    <dbinput v-model="offices[i].mob" type="mob" label=""></dbinput>
                                </div>
                            </td>
                            <td>
                                <dbinput v-model="offices[i].email" type="email"></dbinput>
                            </td>
                        </tr>
                        <tr id="hd">
                            <td colspan="5" style="text-align: right;">
                                <button type="button" style="width: fit-content" @click="ofnum--;saveoffices(offices)">-</button>
                                <button type="button" style="width: fit-content" @click="offices[ofnum]={};ofnum++;saveoffices(offices)">+</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template slot="pservices_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>Name of the Items Produced/Products/Processed /Services provided:-</b></div>
                </div>
                <dbdata sql="select * from cat" class="grid" style="grid-template-columns: 1fr 1fr 1fr 1fr">
                    <div slot="row" slot-scope="r">
                        <dbinput :id="r.val.catname" type="checkbox" :placeholder="r.val.catname" @input="(v)=>{flds.pservices[r.i] = v?r.val.catname:undefined;}">
                        </dbinput>
                    </div>
                    <div slot="end" slot-scope="r" v-if="r.row.length==(r.i+1)">
                        <dbinput id="others" type="checkbox" placeholder="Others" @input="(v)=>{srvchk=v;flds.pservices[r.row.length]=v?flds.pservices[r.row.length]:undefined;}">
                        </dbinput>
                        <div v-if="srvchk">
                            <dbinput type="text" required @input="(v)=>{flds.pservices[r.row.length]=':'+v;}" placeholder="Enter your service"></dbinput>
                        </div>
                    </div>
                </dbdata>
            </template>
            <template slot="financial_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>Financial Details of Last Three Years (Rs. In Lacs) </b></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10px;">
                                No.
                            </th>
                            <th>
                                Year
                            </th>
                            <th>
                                Production
                            </th>
                            <th>
                                Annual Turn Over
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(n,i) in ofin">
                            <td style="width: 10px">
                                {{i+1}}
                            </td>
                            <td>
                                <dbinput v-model="financial[i].year" type="year"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="financial[i].production" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="financial[i].anualto" type="number"></dbinput>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" style="text-align: right;">
                                <button type="button" style="width: fit-content" @click="ofin--;savefinancial(financial)">-</button>
                                <button type="button" style="width: fit-content" @click="financial[ofin]={};ofin++;savefinancial(financial)">+</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template slot="client_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>Clients / References</b></div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 10px;">
                                Sl
                            </th>
                            <th>
                                Name & Address of the Company
                            </th>
                            <th>
                                Designation
                            </th>
                            <th>
                                Contact Number
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(n,i) in oclient">
                            <td style="width: 10px">
                                {{i+1}}
                            </td>
                            <td>
                                <dbinput v-model="client[i].name" type="name"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="client[i].designation" type="name"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="client[i].mob" type="number"></dbinput>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="text-align: right;">
                                <button type="button" style="width: fit-content" @click="oclient--;saveclient(client)">-</button>
                                <button type="button" style="width: fit-content" @click="client[oclient]={};oclient++;saveclient(client)">+</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template slot="client_post-content">
                <div class="mainback">
                    <div class="back"><b>Bank Details </b></div>
                </div>
            </template>
            <template slot="bank_name_pre-content" slot-scope="d">
                Name and address of the Bank:-
            </template>
            <template slot="bank_accno_pre-content" slot-scope="d">
                Bank Account No
            </template>
            <template slot="ifsc_pre-content" slot-scope="d">
                IFSC Code
            </template>
            <template slot="rwus_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>Whether any of your relative is working with us</b></div>
                </div>
                <dbinput type="switch" v-model="perm.rwus">
                    {{perm.rwus?"Yes":"No"}}
                </dbinput>
            </template>
            <template slot="rwus_post-content">
                <div class="mainback hd">
                    <div class="back"><b>Documents Required (Self attected photocopy with company seal):- </b></div>
                </div>
            </template>
            <template slot="gst_cert_pre-content" slot-scope="d">
                GST Certificate
            </template>
            <template slot="pan_card_pre-content" slot-scope="d">
                PAN CARD
            </template>
            <template slot="isi_pre-content" slot-scope="d">
                ISI (if applicable)
            </template>
            <template slot="fssai_pre-content" slot-scope="d">
                FSSAI (If applicable)
            </template>
            <template slot="iso_pre-content" slot-scope="d">
                ISO (If applicable)
            </template>
            <template slot="aadhar_pre-content" slot-scope="d">
                Adhaar Card
            </template>
            <template slot="cancel_cheque_pre-content" slot-scope="d">
                Cancelled Cheque
            </template>
            <template slot="lastplace_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b style="text-align: justify;">DECLARATION
                            The above information is true in all respects and we undertake to inform you if any change in the above particulars regarding our business from time to time.</b>
                    </div>
                </div>
            </template>
            <template slot="ldate_post-content">
                Date:{{flds.ldate}}
            </template>
            <template slot="signature_post-content">
                <b class="hdl">Signature</b>
            </template>
            <template slot="extra">
                <div id="hd" style="grid-column: 1 / -1;display: flex;margin: auto;" class="grid">
                    <dbinput class="hd" type="button" onclick="printform()">PRINT</dbinput>
                </div>
                <div v-if="printf" id="hd" style="grid-column: 1 / -1;display: flex;margin: auto;">
                    <dbinput name="fregapl" type="file" label="Upload filled and signatured form" :upload="`/upload/vendor/onlineforms/temp/${ssid}/`" filename="vendor_registration.pdf" formate="application" ftype="pdf" style="height:1in">
                    </dbinput>
                </div>
                <div v-if="printf" id="hd" style="grid-column: 1 / -1;display: flex;margin: auto;" class="grid">
                    <dbinput type="submit" style="width: fit-content;">REGISTER</dbinput>
                </div>
            </template>
        </formfill>
    </div>
</div>
<div id="cd-shadow-layer"></div>
<?php include('screen/home/footer.php'); ?>
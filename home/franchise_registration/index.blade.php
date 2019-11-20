<?php include("screen/home/carthead.php"); ?>
<clearnav></clearnav>
<vue>#node</vue>
<div id="frcreg">
    <div class="containers">
        <h1 class="frmlogo">
            <img src="<?=get_url('res/images/logo.png')?>" style="width: 100px;object-fit: contain;">
        </h1>
        <div style="display: grid;">
            <dbinput required="true" name="hd" label="Choose" style="width:fit-content;margin: auto;" v-model="flds.ftype" type="select" :options="['MASTER FRANCHISE','FRANCHISE']">
            </dbinput>
        </div>
        <h1 class="hdl">{{flds.ftype}} APPLICATION FORM</h1>
        <formfill id="frnregfrm" action="javascript:regvendor()" :fcol="flds" :dcol="fdcol" :attrs="fattrs" :visible="perm" autocomplete="off">
            <template slot="location_pre-content" slot-scope="d">
                <b>State/ Preferred Location</b>
                <div class="grid frmgrid">
                    <dbinput label="Option1" type="text" v-model="lop[0]" required="true"></dbinput>
                    <dbinput label="Option2" type="text" v-model="lop[1]"></dbinput>
                    <dbinput label="Option3" type="text" v-model="lop[2]"></dbinput>
                </div>
            </template>
            <template slot="location_post-content">
                <div class="mainback">
                    <div class="back">
                        <b>PERSONAL INFORMATION</b>
                    </div>
                </div>
            </template>
            <template slot="pname_pre-content" slot-scope="d">
                <label class="required">Name</label>
            </template>
            <template slot="paddress_pre-content" slot-scope="d">
                <label class="required">Address</label>
            </template>
            <template slot="ptel_no_pre-content" slot-scope="d">
                <label class="required">Resi Contact</label>
            </template>
            <template slot="pmob_pre-content" slot-scope="d">
                <label class="required">Mobile</label>
            </template>
            <template slot="pemail_pre-content" slot-scope="d">
                <label class="required">Email</label>
            </template>
            <template slot="pdob_pre-content" slot-scope="d">
                <label class="required">Date of Birth</label>
            </template>
            <template slot="pmstatus_pre-content" slot-scope="d">
                <label class="required">Marital Status</label>
            </template>
            <template slot="pspousename_pre-content" slot-scope="d">
                <label class="required">Spouse's Name</label>
            </template>
            <template slot="nofd_pre-content" slot-scope="d">
                <label class="required">Number of Dependents</label>
            </template>
            <template slot="education_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>EDUCATION</b></div>
                </div>
                State your educational qualification, including name and location of schools/ colleges, years completed and degree/s earned.
            </template>
            <template slot="busi_exp_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>BUSINESS EXPERIENCE </b></div>
                </div>
                Present Occupation
            </template>
            <template slot="bncompany_pre-content" slot-scope="d">
                Name of Company
            </template>
            <template slot="bycompany_pre-content" slot-scope="d">
                Years in company
            </template>
            <template slot="btel_no_pre-content" slot-scope="d">
                Tel. No.
            </template>
            <template slot="bpof_pre-content" slot-scope="d">
                <span style="white-space: nowrap;">Previous Occupation</span>
            </template>
            <template slot="ptime_pre-content" slot-scope="d">
                <span style="white-space: nowrap;">May we contact you at your business?</span>
                <dbinput type="switch" v-model="perm.ptime">
                    {{perm.ptime?"Yes":"No"}}
                </dbinput>
                <label v-if="perm.ptime" class="required">Prefered Time</label>
            </template>
            <template slot="baddress_pre-content" slot-scope="d">
                <span class="brk" style="margin-top: 10px">Address</span>
            </template>
            <template slot="baddress_post-content">
                <div class="mainback">
                    <div class="back"><b>BUSINESS INTEREST</b></div>
                </div>
            </template>
            <template slot="ooutlet_pre-content" slot-scope="d">
                To what extent will you be involved in the day-to-day operations Outlet?
            </template>
            <template slot="invest_pre-content" slot-scope="d">
                How much amount of money will you invest?
            </template>
            <template slot="funds_pre-content" slot-scope="d">
                What will be the source of the funds?
                <div class="flex-fluid">
                    <dbinput name="fundfrm" type="radio" @click.native="flds.funds='Personal'" label="Personal"></dbinput>
                    <dbinput name="fundfrm" type="radio" @click.native="flds.funds='Partnership'" label="Partnership"></dbinput>
                    <dbinput name="fundfrm" type="radio" @click.native="flds.funds='Loan'" label="Loan"></dbinput>
                    <dbinput name="fundfrm" type="radio" @click.native="flds.funds='Others'" label="Others"></dbinput>
                </div>
            </template>
            <template slot="bventures_pre-content" slot-scope="d">
                Do you have any experience of restaurant/ food business or any hospitality business ventures? (If so, please describe)
            </template>
            <template slot="ofran_pre-content" slot-scope="d">
                How early can you start the franchise ?
            </template>
            <template slot="snsmoral_pre-content" slot-scope="d">
                <div class="mainback">
                    <div class="back"><b>ADDITIONAL INFORMATION</b></div>
                </div>
                <span>Have you ever been convicted of any crime involving moral turpitude?</span>
                <dbinput type="switch" v-model="perm.snsmoral">
                    {{perm.snsmoral?"Yes please state nature and status":"No"}}
                </dbinput>
            </template>
            <template slot="snscivil_pre-content" slot-scope="d">
                <span>Is there any pending suit against you, whether civil or criminal?</span>
                <dbinput type="switch" v-model="perm.snscivil">
                    {{perm.snscivil?"Yes please state nature and status":"No"}}
                </dbinput>
            </template>
            <template slot="directors_pre-content" slot-scope="d">
                <div style="text-align: justify;">I hereby represent that all of the above answers are true and correct to the best of my knowledge and belief. I recognize NEW YORK PIZZA is not in any way obligated to offer a franchise to me because of our execution of this document. I understand that any false statement on this application shall be considered sufficient cause to deny further consideration. I understand that any inquiry regarding my character, personal characteristics and financial background maybe conducted as a result of information required by NEW YORK PIZZA/ NYP FOODS INDIA Pvt Ltd.</div>
                Director/s
            </template>
            <template slot="company_pre-content" slot-scope="d">
                Company:-
            </template>
            <template slot="fdate_pre-content">
                Date: {{flds.fdate}}
            </template>
            <template slot="signature_post-content">
                <span class="hdl">Signature</span>
            </template>
            <template slot="extra">
                <div id="hd" style="grid-column: 1 / -1;display: flex;margin: auto;" class="grid">
                    <dbinput class="hd" type="button" onclick="printform()">PRINT</dbinput>
                </div>
                <div v-if="print" id="hd" style="grid-column: 1 / -1;display: flex;margin: auto;">
                    <dbinput name="fregapl" type="file" label="Upload filled and signatured form" :upload="`/upload/franchise/onlineforms/temp/${ssid}/`" filename="franchise_registration.pdf" formate="application" ftype="pdf" v-model="myfile" style="height:1in">
                    </dbinput>
                </div>
                <div v-if="print" id="hd" style="grid-column: 1 / -1;display: flex;margin: auto;" class="grid">
                    <dbinput type="submit" style="width: fit-content;">REGISTER</dbinput>
                </div>
            </template>
        </formfill>
    </div>
</div>
<div id="cd-shadow-layer"></div>
<?php include('screen/home/footer.php'); ?>
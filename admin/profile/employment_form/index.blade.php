<vue>#node</vue>
<div id="prtcont" class="a4lw" style="margin: auto;border:2px solid">
    <form>
        <div class="grid" style="grid-template-columns: 2fr 1fr">
            <div>
                <div class="comimg">
                    <img src="#{get_url('/res/images/logo.png')}" />
                </div>
                <div class="gridautofr">
                    <label>Name of the Applicant</label>
                    <dbinput v-model="frm.appname" type="text"></dbinput>
                    <label>Area of interest</label>
                    <dbinput v-model="frm.areint" type="text"></dbinput>
                    <label>Position Applied for</label>
                    <dbinput v-model="frm.posapp" type="text"></dbinput>
                </div>
                <div>
                    <b>Like to be called:</b>
                </div>
                <div class="fnmnln grid" style="grid-template-columns: 1fr 1fr 1fr">
                    <dbinput label="First Name" v-model="frm.fname" type="text"></dbinput>
                    <dbinput label="Middle Name" v-model="frm.mname" type="text"></dbinput>
                    <dbinput label="Last Name" v-model="frm.lname" type="text"></dbinput>
                </div>
                <div class="gridfrfr">
                    <dbinput label="Date of Birth" v-model="frm.dob" type="date"></dbinput>
                    <dbinput label="Place of Birth" v-model="frm.pob" type="text"></dbinput>
                </div>
                <div>
                    <dbinput label="Gender" type="select" v-model="frm.gender" :options="['Male','Female']"></dbinput>
                </div>
            </div>
            <div class="bgrey center ins">
                <b>Instructions</b>
                <div class="left">
                    <ol>
                        <li>The applicant is requested to go through the following pages and fill in the required details.</li>
                        <li>Do not fill in the shaded portion of this form.</li>
                        <li>Please paste your latest passport sized photograph here</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="grid" style="grid-template-columns: 1fr 1fr 1fr">
            <div>
                <label>Preferred Work Location </label>
                <div v-for="i in 3">
                    <dbinput v-model="frm.pwl[i]" type="text"></dbinput>
                </div>
            </div>
            <div>
                <label>Preferred Field of Work</label>
                <div v-for="i in 3">
                    <dbinput v-model="frm.fow[i]" type="text"></dbinput>
                </div>
            </div>
            <div>
                <label>Hobbies and Interests</label>
                <div v-for="i in 3">
                    <dbinput v-model="frm.hai[i]" type="text"></dbinput>
                </div>
            </div>
        </div>
        <div class="pagebreak"></div>
        <div class="gridfrfr">
            <div class="brdr">
                <div class="label">
                    Present Address
                </div>
                <dbinput type="textarea" v-model="frm.pre.address"></dbinput>
                <div class="gridfrfr">
                    <dbinput label="City" type="name" v-model="frm.pre.city"></dbinput>
                    <dbinput label="Pin" type="number" v-model="frm.pre.pin"></dbinput>
                </div>
                <div class="gridfrfr">
                    <dbinput label="Tel No (Off.) " type="mob" v-model="frm.pre.teloff"></dbinput>
                    <dbinput label="Tel No (Res.) " type="mob" v-model="frm.pre.telres"></dbinput>
                </div>
                <div class="gridfrfr">
                    <dbinput label="Mail" type="email" v-model="frm.pre.mail"></dbinput>
                    <dbinput label="Mobile" type="mob" v-model="frm.pre.mob"></dbinput>
                </div>
            </div>
            <div class="brdr">
                <div class="label">Permanent Address</div>
                <dbinput type="textarea" v-model="frm.per.address"></dbinput>
                <div class="gridfrfr">
                    <dbinput label="City" type="name" v-model="frm.per.city"></dbinput>
                    <dbinput label="Pin" type="number" v-model="frm.per.pin"></dbinput>
                </div>
                <div class="gridfrfr">
                    <dbinput label="Tel No (Off.) " type="mob" v-model="frm.per.teloff"></dbinput>
                    <dbinput label="Tel No (Res.) " type="mob" v-model="frm.per.telres"></dbinput>
                </div>
                <div class="gridfrfr">
                    <dbinput label="Mail" type="email" v-model="frm.per.mail"></dbinput>
                    <dbinput label="Mobile" type="mob" v-model="frm.per.mob"></dbinput>
                </div>
            </div>
        </div>
        <div class="gridfrfr">
            <div class="brdr">
                <div class="grid lbl" style="grid-template-columns: 2fr 1fr 1fr 1fr">
                    <b>Languages Known</b>
                    <b>Speak</b>
                    <b>Read</b>
                    <b>Write</b>
                </div>
                <div v-for="i in 4" class="grid" style="grid-template-columns: 2fr 1fr 1fr 1fr;top:10px">
                    <div class="gridautofr">
                        <span>
                            {{i}}
                        </span>
                        <dbinput type="text" v-model="frm.lang[i].name"></dbinput>
                    </div>
                    <dbinput :id="`langspeak`+i" type="checkbox" v-model="frm.lang[i].speak">
                    </dbinput>
                    <dbinput :id="`langread`+i" type="checkbox" v-model="frm.lang[i].read">
                    </dbinput>
                    <dbinput :id="`langwrite`+i" type="checkbox" v-model="frm.lang[i].write">
                    </dbinput>
                </div>
            </div>
            <div>
                <div class="brdr">
                    <b>Passport Details</b>
                    <div class="fgrid">
                        <dbinput type="text" label="Passport Number" v-model="frm.pasport.num"></dbinput>
                        <dbinput type="text" label="Place Of Issue" v-model="frm.pasport.poi"></dbinput>
                        <dbinput type="date" label="Date Of Issue" v-model="frm.pasport.doi"></dbinput>
                        <dbinput type="date" label="Valid till" v-model="frm.pasport.vtill"></dbinput>
                        <dbinput type="text" label="Spl. Endorsements" v-model="frm.pasport.end"></dbinput>
                    </div>
                </div>
            </div>
        </div>
        <div class="fgrid">
            <div class="label">
                Family Background (Please include details of Parents, Siblings, Spouse, children)
            </div>
            <div>Marital Status</div>
            <div class="gridfrfr">
                <div class="gridfrfr">
                    <dbinput label="Married" id="mrtlsts" v-model="frm.mrtlsts" type="checkbox">
                    </dbinput>
                    <dbinput label="Single" id="mrtlsts" v-model="!frm.mrtlsts" :ivalue="!frm.mrtlsts" type="checkbox">
                    </dbinput>
                </div>
                <div v-if="frm.mrtlsts">
                    <dbinput type="date" label="Wedding Date" v-model="frm.wdngdate"></dbinput>
                </div>
            </div>
            <hr />
            <br />
            <div>
                <table>
                    <thead>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Relationship</th>
                        <th>Date Of Birth</th>
                        <th>Occupation/ Organisation</th>
                        <th>Dependent on you ? </th>
                    </thead>
                    <tbody>
                        <tr v-for="(v,i) in frm.fbg">
                            <td>
                                {{i+1}}
                            </td>
                            <td>
                                <dbinput type="name" v-model="frm.fbg[i].name"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.fbg[i].rel"></dbinput>
                            </td>
                            <td>
                                <dbinput type="date" v-model="frm.fbg[i].dob"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.fbg[i].occ"></dbinput>
                            </td>
                            <td>
                                <dbinput :id="`fbgdepend`+i" type="checkbox" v-model="frm.fbg[i].depend"></dbinput>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th colspan="6" class="right">
                            <div class="fit">
                                <button type="button" @click="frm.fbg.push({})">+</button>
                            </div>
                        </th>
                    </tfoot>
                </table>
            </div>
        </div>
        <div>
            <div class="label">
                ACADEMIC RECORD (Starting from Xth Class. Original Certificates will be required at the time of joining)
            </div>
            <table>
                <thead>
                    <th>Sl</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Degree/ Diploma Completed</th>
                    <th>College/ University</th>
                    <th>Major Subjects</th>
                    <th>% Marks/ Grade</th>
                    <th>Regular/ Part Time/ Correspondence</th>
                </thead>
                <tbody>
                    <tr v-for="(v,i) in frm.acadrec">
                        <td>
                            {{i+1}}
                        </td>
                        <td>
                            <dbinput type="date" v-model="frm.acadrec[i].from"></dbinput>
                        </td>
                        <td>
                            <dbinput type="date" v-model="frm.acadrec[i].to"></dbinput>
                        </td>
                        <td>
                            <dbinput type="text" v-model="frm.acadrec[i].degree"></dbinput>
                        </td>
                        <td>
                            <dbinput type="text" v-model="frm.acadrec[i].collage"></dbinput>
                        </td>
                        <td>
                            <dbinput type="text" v-model="frm.acadrec[i].major"></dbinput>
                        </td>
                        <td>
                            <dbinput type="text" v-model="frm.acadrec[i].grade"></dbinput>
                        </td>
                        <td>
                            <dbinput type="select" :options="['Regular','Part Time','Correspondance']" v-model="frm.acadrec[i].rpc"></dbinput>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <th colspan="8" class="right">
                        <div class="fit">
                            <button type="button" @click="frm.acadrec.push({})">+</button>
                        </div>
                    </th>
                </tfoot>
            </table>
        </div>
        <div>
            <div class="label">
                Projects/ Training/ Apprenticeship/ Articleship/ Professional Practice, if any
            </div>
            <div>
                <table class="full">
                    <thead>
                        <tr>
                            <th rowspan="2">Sl</th>
                            <th colspan="2">Duration</th>
                            <th rowspan="2">Institution/ Organisation & Location</th>
                            <th rowspan="2">Area/ Topic Covered </th>
                        </tr>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(v,i) in frm.projects">
                            <td>{{i+1}}</td>
                            <td>
                                <dbinput type="date" v-model="frm.projects[i].from"></dbinput>
                            </td>
                            <td>
                                <dbinput type="date" v-model="frm.projects[i].to"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.projects[i].ins"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.projects[i].topic"></dbinput>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th colspan="8" class="right">
                            <div class="fit">
                                <button type="button" @click="frm.projects.push({})">+</button>
                            </div>
                        </th>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="pagebreak"></div>
        <div>
            <div class="label">KNOWLEDGE/ SKILLS/ GEN INFO (Fill in specific topics/ subject areas) </div>
            <div class="grid" style="grid-template-columns: 2in 1fr">
                <div><b>Customer Service</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.customerservice" type="textarea"></dbinput>
                </div>
                <div><b>Research & Development </b></div>
                <div>
                    <dbinput v-model="frm.knowledge.rd" type="textarea"></dbinput>
                </div>
                <div><b>Content Development/ID </b></div>
                <div>
                    <dbinput v-model="frm.knowledge.condev" type="textarea"></dbinput>
                </div>
                <div><b>Sales & Marketing</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.salesmark" type="textarea"></dbinput>
                </div>
                <div><b>Human Resources</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.hr" type="textarea"></dbinput>
                </div>
                <div><b>Training & Development</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.trining" type="textarea"></dbinput>
                </div>
                <div><b>IT Skills</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.itskill" type="textarea"></dbinput>
                </div>
                <div><b>General Management</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.gmangmnt" type="textarea"></dbinput>
                </div>
                <div><b>Other Skills (Please specify)</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.otskill" type="textarea"></dbinput>
                </div>
                <div><b>Memberships in Professional Bodies</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.mipb" type="textarea"></dbinput>
                </div>
                <div><b>Presentations & Publications (attach separate sheet, if required)</b></div>
                <div>
                    <dbinput v-model="frm.knowledge.prpl" type="textarea"></dbinput>
                </div>
            </div>
        </div>
        <div>
            <div class="label">
                WORK EXPERIENCE RECORD (Please start with the Present/ Last Organisation)
            </div>
            <div>
                <table class="full">
                    <thead>
                        <tr>
                            <th rowspan="3">Sl</th>
                            <th colspan="2">Duration</th>
                            <th rowspan="3">Total Exp. In months</th>
                            <th rowspan="3">Name and Address of the Organisation </th>
                            <th rowspan="3">
                                Basic Nature of Duties
                            </th>
                            <th>
                                Designation
                            </th>
                            <th>
                                Sallary
                            </th>
                            <th rowspan="3">
                                Reasons for Leaving
                            </th>
                        </tr>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>On joining </th>
                            <th>On Joining</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>On Leaving </th>
                            <th>On Leaving</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(v,i) in frm.workexp">
                            <td>{{i+1}}</td>
                            <td>
                                <dbinput type="date" v-model="frm.workexp[i].from"></dbinput>
                            </td>
                            <td>
                                <dbinput type="date" v-model="frm.workexp[i].to"></dbinput>
                            </td>
                            <td>
                                <dbinput type="number" v-model="frm.workexp[i].expmnt"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.workexp[i].nameorg"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.workexp[i].bnd"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.workexp[i].degonj"></dbinput>
                                <dbinput type="text" v-model="frm.workexp[i].degonl"></dbinput>
                            </td>
                            <td>
                                <dbinput type="number" v-model="frm.workexp[i].salonj"></dbinput>
                                <dbinput type="number" v-model="frm.workexp[i].salonl"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.workexp[i].rfl"></dbinput>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th colspan="9" class="right">
                            <div class="fit">
                                <button type="button" @click="frm.workexp.push({})">+</button>
                            </div>
                        </th>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="pagebreak"></div>
        <div class="fgrid">
            <div class="label">
                BREAK-UP OF SALARY IN PRESENT EMPLOYMENT
            </div>
            <div class="gridfrfr">
                <dbinput label="Last Revised on" type="date">
                </dbinput>
                <dbinput label="Next Revision Due on" type="date">
                </dbinput>
            </div>
            <hr />
            <br />
            <div class="brdr ttbl">
                <table>
                    <thead>
                        <th>A. Monthly</th>
                        <th>Rs.</th>
                        <th>Taxable
                            (Y/ N/ Partly)
                        </th>
                        <th>B. Annual Components</th>
                        <th>Rs.</th>
                        <th>Taxable
                            (Y/N)
                        </th>
                        <th>C. Benefits</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Salary</td>
                            <td>
                                <dbinput v-model="frm.salary.basicrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.basictax"></dbinput>
                            </td>
                            <td></td>
                            <td>
                                <dbinput v-model="frm.salary.basiccomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.basiccomptax"></dbinput>
                            </td>
                            <td>Gratuity</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>DA</td>
                            <td>
                                <dbinput v-model="frm.salary.dars" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.datax"></dbinput>
                            </td>
                            <td>Leave Travel Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.dacomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.dacomptax"></dbinput>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>HRA/ CLA</td>
                            <td>
                                <dbinput v-model="frm.salary.hrars" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.hratax"></dbinput>
                            </td>
                            <td></td>
                            <td>
                                <dbinput v-model="frm.salary.hracomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.hracomptax"></dbinput>
                            </td>
                            <td>Bonus/ Ex Gratia</td>
                            <td rowspan="8">Vehicle Type<br>
                                (Pl. tick)<br>
                                Self<br>
                                Co. Owned<br>
                                Co. loan<br>
                                Loan Original<br>
                                Interest Rate<br>
                                Repayment Period<br>
                                Balance due
                            </td>
                        </tr>
                        <tr>
                            <td>Conveyance (Excluding official)</td>
                            <td>
                                <dbinput v-model="frm.salary.conveyancers" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.conveyancetax"></dbinput>
                            </td>
                            <td>Medical Reimb. (Domiciliary)</td>
                            <td>
                                <dbinput v-model="frm.salary.conveyancecomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.conveyancecomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>City Compensatory Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.cityrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.citytax"></dbinput>
                            </td>
                            <td>Medical (Hospitalisation)</td>
                            <td>
                                <dbinput v-model="frm.salary.citycomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.citycomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Lunch Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.lunchrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.lunchtax"></dbinput>
                            </td>
                            <td>Furnishing Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.lunchcomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.lunchcomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Special Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.specialrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.specialtax"></dbinput>
                            </td>
                            <td>PL/CL (no. of days)</td>
                            <td>
                                <dbinput v-model="frm.salary.specialcomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.specialcomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Entertainment Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.entrrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.entrtax"></dbinput>
                            </td>
                            <td>Repair & Maintenance</td>
                            <td>
                                <dbinput v-model="frm.salary.entrcomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.entrcomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Newspapers & Magazines Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.newsrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.newstax"></dbinput>
                            </td>
                            <td>Superannuation % <dbinput v-model="frm.salary.newsannuation" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.newscomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.newscomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Education Allowance</td>
                            <td>
                                <dbinput v-model="frm.salary.edurs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.edutax"></dbinput>
                            </td>
                            <td>PF % <dbinput v-model="frm.salary.edupf" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.educomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.educomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <td colspan="6"></td>
                        <td>Petrol Expenses
                            Maintenance
                            Driver
                        </td>
                        <td>Personal <dbinput v-model="frm.salary.pers" type="number"></dbinput>
                            Official <dbinput v-model="frm.salary.official" type="number"></dbinput>
                        </td>
                        </tr>
                        <tr v-for="(v,i) in frm.salary.otral">
                            <td>
                                Other Allowances
                                {{i+1}}
                                <dbinput type="text" v-model="frm.salary.otral[i].otr"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.otral[i].otrrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.otral[i].otrtax"></dbinput>
                            </td>
                            <td>
                                Other Allowances
                                {{i+1}}
                                <dbinput type="text" v-model="frm.salary.otral[i].otrannu"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.otral[i].comprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.otral[i].comptax"></dbinput>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="right">
                                <div class="fit">
                                    <button type="button" @click="frm.salary.otral.push({})">+</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Gross Monthly (i)</td>
                            <td>
                                <dbinput v-model="frm.salary.grossrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.grosstax"></dbinput>
                            </td>
                            <td>Gross Annual (ii)
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.grosscomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.grosscomptax"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr v-for="(v,i) in frm.salary.deduct">
                            <td>
                                Deductions
                                {{i+1}}
                                <dbinput type="text" v-model="frm.salary.deduct[i].dedc"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.deduct[i].otrrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.deduct[i].otrtax"></dbinput>
                            </td>
                            <td>
                                Deductions
                                {{i+1}}
                                <dbinput type="text" v-model="frm.salary.deduct[i].otrannu"></dbinput>
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.deduct[i].comprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.deduct[i].comptax"></dbinput>
                            </td>
                            <td>Others
                                {{i+1}}
                                <dbinput type="text" v-model="frm.salary.deduct[i].others"></dbinput>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="9" class="right">
                                <div class="fit">
                                    <button type="button" @click="frm.salary.deduct.push({})">+</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Sub Total A</td>
                            <td>
                                <dbinput v-model="frm.salary.subttlrs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No','Partly']" v-model="frm.salary.subttltax"></dbinput>
                            </td>
                            <td>Sub Total B
                            </td>
                            <td>
                                <dbinput v-model="frm.salary.subttlcomprs" type="number"></dbinput>
                            </td>
                            <td>
                                <dbinput type="select" :options="['Yes','No']" v-model="frm.salary.subttlcomptax"></dbinput>
                            </td>
                            <td>Cost to Company
                                [(A i) *12 + B ii +C]
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td rowspan="2">Joining Time required</td>
                            <td colspan="2" rowspan="2">
                                <dbinput v-model="frm.salary.joining" type="text"></dbinput>
                            </td>
                            <td>Expected Compensation:
                            </td>
                            <td colspan="4">
                                <dbinput v-model="frm.salary.excomp" type="number"></dbinput>
                            </td>
                        </tr>
                        <tr>
                            <td>Monthly Gross</td>
                            <td colspan="2">
                                <dbinput v-model="frm.salary.mgross" type="number"></dbinput>
                            </td>
                            </td>
                            <td>Annual Cost to Company </td>
                            <td colspan="3">
                                <dbinput v-model="frm.salary.annualcost" type="number"></dbinput>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="brdr">
            <div>
                <div>
                    <b>Please specify the structure (reporting relationship) of your position/ department in your present/ last organisation.</b>
                </div>
                <dbinput type="textarea" v-model="frm.pstsrel"></dbinput>
            </div>
            <div class="gridfrfr">
                <div class="brdr">
                    <dbinput id="nygochave" v-model="frm.nygochave" type="checkbox" placeholder="Have you ever been considered for employment in New York Pizza or any New York Pizza group of companies?"></dbinput>
                    <div v-if="frm.nygochave" class="fgrid">
                        <dbinput type="text" label="Position" v-model="frm.haveny.pos"></dbinput>
                        <dbinput type="text" label="Met by" v-model="frm.haveny.metby"></dbinput>
                        <dbinput type="text" label="Location" v-model="frm.haveny.loc"></dbinput>
                        <dbinput type="date" label="Date" v-model="frm.haveny.date"></dbinput>
                    </div>
                </div>
                <div class="brdr">
                    <div>People you know at New York Pizza (Name, division, location)</div>
                    <div v-for="i in 4">
                        <div class="gridautofr">
                            <span>{{i}}</span>
                            <dbinput type="text" v-model="frm.knwny[i]"></dbinput>
                        </div>
                    </div>
                </div>
                <div class="brdr">
                    <div>What are your major strengths ?</div>
                    <div v-for="i in 3">
                        <div class="gridautofr">
                            <span>{{i}}</span>
                            <dbinput type="text" v-model="frm.strength[i]"></dbinput>
                        </div>
                    </div>
                </div>
                <div class="brdr">
                    <div>What do you think are your areas for improvement ?</div>
                    <div v-for="i in 3">
                        <div class="gridautofr">
                            <span>{{i}}</span>
                            <dbinput type="text" v-model="frm.improvement[i]"></dbinput>
                        </div>
                    </div>
                </div>
                <div class="brdr">
                    <div>What do you think is your greatest achievement in life ?</div>
                    <dbinput type="textarea" v-model="frm.achvntlife"></dbinput>
                </div>
                <div class="brdr">
                    <div>What are your career objectives ?</div>
                    <dbinput type="textarea" v-model="frm.objectives"></dbinput>
                </div>
            </div>
        </div>
        <div class="pagebreak"></div>
        <div>
            <div class="label">
                <b>REFERENCES:</b> List any three persons not related to you, who are professionally, known to you. Do you have any objection to our referring to them? Yes/ No (Please tick mark)
            </div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Full Name</th>
                            <th>Full Address</th>
                            <th>Tel. Nos. / Mobile no./ Email </th>
                            <th>Position/ Business</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(v,i) in frm.references">
                            <td>{{i+1}}</td>
                            <td>
                                <dbinput type="text" v-model="frm.references[i].name"></dbinput>
                            </td>
                            <td>
                                <dbinput type="textarea" v-model="frm.references[i].address"></dbinput>
                            </td>
                            <td>
                                <dbinput type="textarea" v-model="frm.references[i].tel"></dbinput>
                            </td>
                            <td>
                                <dbinput type="text" v-model="frm.references[i].pos"></dbinput>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th colspan="5" class="right">
                            <div class="fit">
                                <button type="button" @click="frm.references.push({})">+</button>
                            </div>
                        </th>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="gridfrfr">
            <div class="brdr">
                <dbinput id="criminal" type="checkbox" v-model="frm.criminal" placeholder="Have you ever been arrested, indicted or summoned as a defendant in a criminal proceeding, or convicted, fined or imprisoned for violation of any law (Excluding minor traffic violations) "></dbinput>
                <div v-if="frm.criminal">
                    <dbinput type="textarea" label="Details" v-model="frm.crmdetail"></dbinput>
                </div>
            </div>
            <div class="brdr">
                <div>
                    I certify that the statements made by me
                    are true, complete and correct to the best
                    of my knowledge and belief. I understand
                    that any material misrepresentation or
                    omission made hereon or any other
                    document requested by New York Pizza,
                    renders me liable to termination or
                    dismissal.
                </div>
                <div>
                    <dbinput label="Place" type="name" v-model="frm.place"></dbinput>
                    <dbinput label="Date" type="date" v-model="frm.date" disabled></dbinput>
                    <div style="height: 1in">
                    </div>
                    <div>Signature</div>
                </div>
            </div>
        </div>
        <div style="height: 2in;border:4px solid">
            <div class="center">
                <b>FOR OFFICE USE ONLY</b>
            </div>
        </div>
        <div class="middle">
            <div class="fit">
                <button @click="submitform">
                    SUBMIT
                </button>
            </div>
        </div>
    </form>
</div>
<div class="middle">
    <div class="fit">
        <button type="button" @click="t$('#prtcont').print()">
            PRINT
        </button>
    </div>
</div>
tfcol = ['department', 'designation', 'fname', 'lname', 'email', 'mnumber', 'dob', 'merital_status', 'gender', 'address1', 'country', 'state',
    'city', 'pcompany', 'pfrom', 'pto', 'pdesignation', 'pdepartment'
];

function candidate_applications_data() {
    return {
        popup: false,
        tabs: ['Applications', 'Approved List', 'Rejected List'],
        render: true,
        jstatus: {
            t1: [],
            t2: [],
            management: [],
            verification: [],
            processing: [],
            approve: []
        },
        ajstatus: {
            t1: [],
            t2: [],
            management: [],
            verification: [],
            processing: [],
            approve: []
        },
        rjstatus: {
            t1: [],
            t2: [],
            management: [],
            verification: [],
            processing: [],
            approve: []
        },
        window: window,
        apf: { country: "", state: "", city: "", department: "" },
        tempf: {},
        imgobj: {},
        ldb: ldb,
        onappemp: () => {},
        deparr: [],
        desarr: [],
        busarr: [],
        statearr: [],
        cityarr: [],
        ssid: $.cookie('PHPSESSID'),
        findcol: [],
        udtl: udtl,
        stsql: "",
        cisql: "",
        dessql: "",
        updemp: {
            fcol: tfcol,
            dcol: {
                fname: 'User Name',
                btc: 'Best Time To Contact',
                exp: 'Experience',
                fname: 'First Name',
                lname: 'Last Name',
                department: 'Department',
                designation: 'Designation',
                email: 'Email',
                mnumber: 'Mobile Number',
                dob: 'DOB',
                merital_status: 'Merital Status',
                gender: 'Gender',
                address1: 'Address',
                country: 'Country',
                state: 'State',
                city: 'City',
                pcompany: 'Previous company',
                management: 'Management',
                pfrom: 'from',
                pto: 'to',
                pdesignation: 'Previous designation',
                pdepartment: 'Previous department'
            },
            fval: {},
            attrs: Object.assign(tfcol.extend(['uname', 'exp', 'btc']).toObject({ type: "label" }), {
                pcompany: {
                    style: "grid-column:-1/1"
                }
            })
        },
        hrfreez: [],
        reattrs: {
            processing: {
                val: function(row, col, val, ms, whr, tblnm, isql) {
                    log('row', val.json().type);
                    let upex = val.json().process == "Rejected" ? ",reject='1'" : ",reject='0'";
                    let protype = "";
                    if (val.json().type == 'Processing') {
                        protype = ",protype = 'processing'";
                    } else if (val.json().type == 'Technical 1') {
                        protype = ",protype = 't1'";
                    } else if (val.json().type == 'Technical 2') {
                        protype = ",protype = 't2'";
                    } else if (val.json().type == 'Management') {
                        protype = ",protype = 'management'";
                    } else if (val.json().type == 'Hr(salary & verification)') {
                        protype = ",protype = 'verification'";
                    }
                    if (val.json().type) {
                        return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} ${protype} WHERE ${whr}`;
                    } else {
                        return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} WHERE ${whr}`;
                    }
                },
                onedit: function(row, col, obj) {
                    return !(row.reject == 1 || row.protype != 'processing');
                }
            },
            t1: {
                val: function(row, col, val, ms, whr, tblnm, isql) {
                    log('type', val.json().process);
                    let upex = val.json().process == "Rejected" ? ",reject='1'" : ",reject='0'";
                    let protype = "";
                    if (val.json().type == 'Processing') {
                        protype = ",protype = 'processing'";
                    } else if (val.json().type == 'Technical 1') {
                        protype = ",protype = 't1'";
                    } else if (val.json().type == 'Technical 2') {
                        protype = ",protype = 't2'";
                    } else if (val.json().type == 'Management') {
                        protype = ",protype = 'management'";
                    } else if (val.json().type == 'Hr(salary & verification)') {
                        protype = ",protype = 'verification'";
                    }
                    if (val.json().type) {
                        return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} ${protype} WHERE ${whr}`;
                    } else {
                        return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} WHERE ${whr}`;
                    }

                },
                onedit: function(row, col, obj) {
                    return !(row.reject == 1 || row.protype != 't1');
                }
            },
            t2: {
                val: function(row, col, val, ms, whr, tblnm, isql) {
                    let upex = val.json().process == "Rejected" ? ",reject='1'" : ",reject='0'";
                    let protype = "";
                    if (val.json().type == 'Processing') {
                        protype = ",protype = 'processing'";
                    } else if (val.json().type == 'Technical 1') {
                        protype = ",protype = 't1'";
                    } else if (val.json().type == 'Technical 2') {
                        protype = ",protype = 't2'";
                    } else if (val.json().type == 'Management') {
                        protype = ",protype = 'management'";
                    } else if (val.json().type == 'Hr(salary & verification)') {
                        protype = ",protype = 'verification'";
                    }
                    return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} ${protype} WHERE ${whr}`;
                },
                onedit: function(row, col, obj) {
                    return !(row.reject == 1 || row.protype != 't2');
                }
            },
            management: {
                val: function(row, col, val, ms, whr, tblnm, isql) {
                    let upex = val.json().process == "Rejected" ? ",reject='1'" : ",reject='0'";
                    let protype = "";
                    if (val.json().type == 'Processing') {
                        protype = ",protype = 'processing'";
                    } else if (val.json().type == 'Technical 1') {
                        protype = ",protype = 't1'";
                    } else if (val.json().type == 'Technical 2') {
                        protype = ",protype = 't2'";
                    } else if (val.json().type == 'Management') {
                        protype = ",protype = 'management'";
                    } else if (val.json().type == 'Hr(salary & verification)') {
                        protype = ",protype = 'verification'";
                    }
                    if (val.json().type) {
                        return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} ${protype} WHERE ${whr}`;
                    } else {
                        return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} WHERE ${whr}`;
                    }
                },
                onedit: function(row, col, obj) {
                    return !(row.reject == 1 || row.protype != 'management');
                }
            },

            verification: {
                val: function(row, col, val, ms, whr, tblnm, isql) {
                    let pkgid = val.json().pkgid ? ",pkgid='" + val.json().pkgid + "'" : ",pkgid=''";
                    let pkgname = val.json().pkgname ? ",pkgname='" + val.json().pkgname + "'" : ",pkgname=''";
                    let joindate = val.json().joindate ? ",joindate='" + val.json().joindate + "'" : ",joindate=''";
                    let location = val.json().location ? ",location='" + val.json().location + "'" : ",location=''";
                    let salary = val.json().salary ? ",salary='" + val.json().salary + "'" : ",salary=''";
                    let upex = val.json().process == "Rejected" ? ",reject='1'" : ",reject='0'";
                    let aprv = val.json().process == "Selected" ? ",complete='1'" : ",complete='0'";
                    return `UPDATE ${tblnm} SET ${col}='${val}' ${upex} ${aprv} ${joindate} ${location} ${salary} ${pkgid} ${pkgname} WHERE ${whr}`;
                },
                onedit: function(row, col, obj) {
                    return !(row.reject == 1 || row.protype != 'verification');
                }
            },

        }

    };
}

function filterTabs() {
    let ftab = this.tabs;
    if (udtl.uid != "1") {
        ftab = ftab.filter((v) => { return v == 'Applications'; });
        ftab = ftab.extend(['Approved List', 'Rejected List']);
    }
    if (udtl.dept == "HR") {
        ftab = ftab.extend(['Approve Candidate', 'Approved List', 'Rejected List']);
    }
    return ftab;
}

function getsql($name) {

    let res;
    if (udtl.dept == 'HR' || udtl.dept == 'Admin') {
        res = 'select *,oeid as pdf,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where reject=0 and complete=0';
    } else {
        res = 'select *,oeid as pdf,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where reject=0 and complete=0 and department="' + udtl.dept + '"';
    }

    return res;
}

function getapprlsql() {
    let res;
    if (udtl.dept == 'HR' || udtl.dept == 'Admin') {
        res = 'select *,oeid as pdf,oeid as offer,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where  complete=1';
    } else {
        res = 'select *,oeid as pdf,oeid as offer,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where  complete=1 and department="' + udtl.dept + '"';
    }
    return res;
}

function getpapprsql() {
    let res;
    if (udtl.dept == 'HR' || udtl.dept == 'Admin') {
        res = 'select *,oeid as pdf,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where complete=1';
    } else {
        res = 'select *,oeid as pdf,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where  complete=1 and department="' + udtl.dept + '"';
    }
    return res;
}

function getrejsql() {
    let res;
    if (udtl.dept == 'HR' || udtl.dept == 'Admin') {
        res = 'select *,oeid as pdf,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where reject=1';
    } else {
        res = 'select *,oeid as pdf,concat(fname,"-",department,"-",designation,"-",mnumber) as edtl from online_employee where reject=1 and department="' + udtl.dept + '"';
    }
    return res;
}

function HRhandelEdit(row) {
    log("HRhandelEdit", row);
}


function onimginvalid(img, df) {
    df();
}

function delerowfiles(row, i, name) {
    callServerMethod("listDir", { cpath: `./upload/${name}/onlineforms/${row['pdf']}`, path: "/" }).then(async (data) => {
        let arr = data.map(async (file) => {
            return await callServerMethod("DelDirF", { cpath: `./upload/${name}/onlineforms/${row['pdf']}/${file}`, path: "/" });
        });
        let done = await arr[arr.length - 1];
        callServerMethod("DelDirF", { cpath: `./upload/${name}/onlineforms/${row['pdf']}`, path: "/" });
    });
}


function getJstatus(val, name, i, ref = "jstatus") {
    let def = {
        process: '',
        type: '',
        remarks: ''
    };
    if (name == "processing") { delete def.processing };
    if (name == "t1") { delete def.t1 };
    if (name == "t2") { delete def.t2 };
    if (name == "management") { delete def.management };
    if (name == "verification") { delete def.verification };
    if (name == "approve") { delete def.approve };
    vueapp[ref][name][i] = isset(vueapp[ref][name][i]) ? vueapp[ref][name][i] : {};
    if (val == false) {
        vueapp[ref][name][i] = def;
        return [];
    } else {
        vueapp[ref][name][i] = val;
        return Object.keys(vueapp[ref][name][i]);
    }
}

function renderui() {
    vueapp.render = false;
    sleep(500).then(() => {
        vueapp.render = true;
    });
}

function sendoffer(eid, $method, $name, print = "") {
    let url = "";
    if ($method == 'email') {
        tprompt('Enter Email Address', async (pf, e, val) => {
            if (pf) {
                url = screen_url(`admin/manage/invoice&eid=${eid}&display=${$method}&invtype=${$name}&sent=${udtl.fname}&ordmethod=offer`);
                let pd = {};
                let content = await $get(url, {}, false);
                pd['content'] = content;
                pd['url'] = url;
                pd['sbj'] = "Job Offer From NYP FOODS INDIA PVT LTD";
                pd['from'] = window.location.hostname;
                pd['email'] = val;
                let param = {
                    param: JSON.stringify(pd)
                }
                let $this = this;
                let ic = tinfo("Email sending please wait....");
                callServerMethod("emailurl", param).then((data) => {
                    ic();
                    if (data.res) {
                        talert("Email sent ", "Information...!", () => {});
                    } else {
                        talert("Email not sent ", "Warning...!", () => {});
                    }

                });
            } else {

            }
        });
    } else {
        url = screen_url(`admin/manage/invoice&eid=${eid}&display=${$method}&invtype=${$name}&sent=${udtl.fname}&ordmethod=offer${print}`);
        window.open(url, '_blank');
    }


}
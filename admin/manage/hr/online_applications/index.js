tfcol = ['department', 'designation', 'fname', 'lname', 'email', 'mnumber', 'dob', 'merital_status', 'gender', 'address1', 'country', 'state',
    'city', 'pcompany', 'pfrom', 'pto', 'pdesignation', 'pdepartment'
];

function online_applications_data() {
    return {
        render: true,
        jstatus: {
            hr: [],
            t1: [],
            t2: [],
            practical: [],
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
                uname: 'User Name',
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

    };
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
async function approvemfranchise(d, $name) {
    let pd = {};
    if ($name == 'master') {
        pd["id"] = d.rval.id;
        pd["uid"] = udtl.uid;
        let location = d.rval.location;
        let fnum = d.rval.fnum;
        let todate = new Date().getFullYear().toString().substr(-2);
        pd["usname"] = ('NYPMF' + location.substring(0, 3) + todate + fnum).toUpperCase();
        pd['dbty'] = $name;
        $this = this;
    } else if ($name == 'franchise') {
        pd["id"] = d.rval.id;
        pd["uid"] = udtl.uid;
        let location = d.rval.location;
        let fnum = d.rval.fnum;
        let todate = new Date().getFullYear().toString().substr(-2);
        pd["usname"] = ('NYPF' + location.substring(0, 3) + todate + fnum).toUpperCase();
        pd['dbty'] = $name;
        pd["location"] = location;
        $this = this;
    } else if ($name == 'vendor') {
        pd["id"] = d.rval.vid;
        pd["uid"] = udtl.uid;
        let fnum = d.rval.vnum;
        let todate = new Date().getFullYear().toString().substr(-2);
        pd["usname"] = ('NYPVE' + todate + fnum).toUpperCase();
        pd['dbty'] = $name;
        $this = this;
    }

    callServerMethod("afranchise", pd).then((data) => {

        if (data.error == false) {
            talert("Approved", "Information...", () => {});
            t$("#etbl").node.vue.fetchData();
            t$("#ven").node.vue.fetchData();
            t$("#fran").node.vue.fetchData();
        } else {
            talert($this.msg, "Warning...!");
        }
    });
}

function getJstatus(val, name, i) {
    let def = {
        process: '',
        status: '',
        department: '',
        remarks: ''
    };
    if (name == "processing") { delete def.processing };
    if (name == "hr") { delete def.hr };
    if (name == "t1") { delete def.t1 };
    if (name == "t2") { delete def.t2 };
    if (name == "practical") { delete def.practical };
    if (name == "verification") { delete def.verification };
    if (name == "approve") { delete def.approve };
    vueapp.jstatus[name][i] = isset(vueapp.jstatus[name][i]) ? vueapp.jstatus[name][i] : {};
    if (val == false) {
        vueapp.jstatus[name][i] = def;
    } else {
        vueapp.jstatus[name][i] = val;
    }
    return Object.keys(vueapp.jstatus[name][i]);
}

function renderui() {
    vueapp.render = false;
    sleep(500).then(() => {
        vueapp.render = true;
    });
}

function sendCredentials(val, $name, $active) {
    let pd = {};
    pd["usname"] = val.usname;
    pd['active'] = $active;
    pd['name'] = $name;
    if ($name == 'vendor') {
        pd['id'] = val.vid;
    } else {
        pd['id'] = val.id;
    }
    let param = { param: JSON.stringify(pd) }
    callServerMethod("activerow", param).then(async (data) => {
        trace('fdg');
        if (data.error == false) {
            if (pd['active'] == '1') {
                $this = this;
                let urle = screen_url(`admin/manage/invoice&id=${pd['id']}&name=${$name}&invtype=sendCredentials`);
                log('fff', urle);
                let content = await $get(urle, {}, false);
                let pde = {};
                pde['content'] = content;
                pde['sbj'] = "Account Credentials By " + window.location.hostname;
                pde['from'] = window.location.hostname;
                pde['email'] = 'myppkworld@gmail.com';
                let parame = { parame: JSON.stringify(pde) }
                callServerMethod("emailurl", parame).then((data) => {
                    talert("Approved mail sent with login credentials", "Information...", () => {});
                });
            } else {
                talert('Account Desabled', "Success...!", () => {});
            }
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}
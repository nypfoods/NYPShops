tfcol = ['department', 'designation', 'fname', 'lname', 'email', 'mnumber', 'dob', 'merital_status', 'gender', 'address1', 'country', 'state',
    'city', 'pcompany', 'pfrom', 'pto', 'pdesignation', 'pdepartment'
];

function create_employee_data() {
    return {
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
        apf: { country: "", state: "", city: "", department: "", mid: udtl.mid, fid: udtl.fid, stid: udtl.stid },
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
        regpf: {},
        sfran: "select * from franchise where mid='" + udtl.mid + "'",
        sout: "select * from outlet where fid='" + udtl.fid + "' and mid='" + udtl.mid + "'",
        dessql: "",
        updemp: {
            fcol: ['fname', 'lname', 'department', 'designation', 'doj', 'business_location', 'email', 'mnumber', 'pcompany', 'pfrom', 'pto', 'pdesignation', 'pdepartment'],
            dcol: {
                fname: 'First Name',
                mname: 'Middle Name',
                lname: 'Last Name',
                department: 'Department',
                designation: 'Designation',
                doj: 'Joining date',
                business_location: 'Business Location',
                email: 'Email',
                mnumber: 'Mobile Number',
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

function create_employee_watch() {
    return {
        "apf.country": function(val) {
            if (vueapp) {
                vueapp.stsql = "select * from states where country='" + vueapp.apf.country + "'";
            }
        },
        "apf.state": function(val) {
            if (vueapp) {
                vueapp.cisql = "select * from cities where state='" + vueapp.apf.state + "'";
            }
        },
        "apf.department": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from(select desname from designation as ds join department as d  where d.did=ds.did and dname='" + vueapp.apf.department + "') as designation";
            }
        },
        "apf.mid": function(val) {
            if (vueapp) {
                log(val);
                vueapp.sfran = "select * from franchise where mid='" + vueapp.apf.mid + "'";
            }
        },
        "apf.fid": function(val) {
            if (vueapp) {
                vueapp.sout = "select * from outlet where fid='" + vueapp.apf.fid + "' and mid='" + vueapp.apf.mid + "'";
            }
        },
    };
}
async function addemployee(...arr) {
    console.log("a", this);
    this.findcol["epwd"] = this.findcol["fname"].md5();
    let department = this.findcol["department"];
    let empn = (await getData("select IFNULL(max(enum),0)+1 as enum from employee")).data[0].enum;
    let todate = new Date().getFullYear().toString().substr(-2);
    this.findcol["uname"] = ('NYP' + department.substring(0, 3) + todate + empn).toUpperCase();
    let vid = uid();
    this.findcol["uid"] = udtl.uid;
    this.findcol["enum"] = empn;
    this.findcol["eid"] = vid;
    let $this = this;
    this.onappemp(this.findcol).then(async (data) => {
        if (data.error == false) {
            await callServerMethod("addtoUser", { id: vid });
            await addimg("pp", vid);
            await addimg("ec", vid);
            await addimg("adhar", vid);
            await addimg("pan", vid);
            await addimg("bank", vid);
            await addimg("dl", vid);
            let id = vueapp.regpf.sid;
            /*  await callServerMethod("move",{oldfile:oldfile,newfile:newfile});*/
            talert("Employee Added", "Information...", () => {});
            myfrm.vue.showTab(0);
            Object.keys(vueapp.tempf).map((f) => {
                vueapp.imgobj[f].forceRemove();
            });
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
    Object.empty(this.apf);
}

function onimginvalid(img, df) {
    df();
}



async function addimg(name, vid) {
    let newfile = `upload/${ldb}/employee/${vid}/${name}.png`;
    let oldfile = vueapp.tempf[name];
    await callServerMethod("move", { oldfile: oldfile, newfile: newfile });
}
async function handelBlocation(name, obj) {
    vueapp.apf.business_location = name;
    vueapp.apf.place_id = obj.place_id;
    await getlatlngByPlaceId(vueapp.apf.place_id, function(res) {
        res = res.results;
        if (Object.keys(res).length > 0) {
            vueapp.apf.lat = res[0].geometry.location.lat;
            vueapp.apf.lng = res[0].geometry.location.lng;
        }
    });
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

function hadelEmployeeSearch(name, row) {
    this.apf["fname"] = row["fname"];
    this.apf["lname"] = row["lname"];
    this.apf["email"] = row["email"];
    this.apf["mnumber"] = row["mnumber"];
    this.apf["dob"] = row["dob"];
    this.apf["merital_status"] = row["merital_status"];
    this.apf["gender"] = row["gender"];
    this.apf["address1"] = row["address1"];
    this.apf["country"] = row["country"];
    this.apf["state"] = row["state"];
    this.apf["city"] = row["city"];
    this.apf["exp"] = row["exp"];
    this.apf["department"] = row["department"];
    this.apf["designation"] = row["designation"];
    this.apf["pcompany"] = row["pcompany"];
    this.apf["pfrom"] = row["pfrom"];
    this.apf["pto"] = row["pto"];
    this.apf["pdepartment"] = row["pdepartment"];
    this.apf["pdesignation"] = row["pdesignation"];


}

function releaseoffer(id) {
    let url = screen_url(`admin/manage/hr/offer_letter&id=${id}`);
    window.open(url, '_blank');
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
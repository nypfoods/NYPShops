ssid = $.cookie("PHPSESSID");

function employee_registration_data() {
    return {
        dcol: {
            jobdetail: "Job Details",
            department: "Department",
            designation: "Designation",
            skill: "Skill",
            title: "Title",
            description: "Description",
            status: "Active",

        },
        chktbs: ["Openings"],
        apf: { country: "", state: "", city: "", department: "" },
        job: {},
        tempf: {},
        imgobj: {},
        ldb: ldb,
        onappemp: () => {},
        statearr: [],
        cityarr: [],
        ssid: ssid,
        findcol: [],
        pcompany: [],
        pfrom: [],
        pto: [],
        comp: {},
        dessql: "",
        pdepartment: [],
        pdesignation: [],
        udtl: udtl,
        stsql: "",
        cisql: "",
        compnum: 1,
    };
}

function employee_registration_watch() {
    return {
        "apf.country": function(val) {
            this.stsql = "select * from states where country='" + val + "'";
        },
        "apf.state": function(val) {
            if (vueapp) {
                vueapp.cisql = "select * from cities where state='" + val + "'";
            }
        },
        "apf.department": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from(select desname from designation as ds join department as d  where d.did=ds.did and dname='" + vueapp.apf.department + "') as designation";
            }
        },
    };
}




async function addemployee(...arr) {
    vueapp.apf.pcompany = vueapp.pcompany.join(',');
    vueapp.apf.pfrom = vueapp.pfrom.join(',');
    vueapp.apf.pto = vueapp.pto.join(',');
    vueapp.apf.pdepartment = vueapp.pdepartment.join(',');
    vueapp.apf.pdesignation = vueapp.pdesignation.join(',');
    vueapp.apf.epwd = (vueapp.apf.fname).md5();
    let pd = Object.assign({}, vueapp.apf);
    pd.job_id = vueapp.job.id;
    pd.designation = vueapp.job.designation;
    pd.department = vueapp.job.department;
    let empn = (await getData("select IFNULL(max(enum),0)+1 as enum from online_employee")).data[0].enum;
    let todate = new Date().getFullYear().toString().substr(-2);
    pd["uname"] = ('NYP' + pd.department.substring(0, 3) + todate + empn).toUpperCase();
    let vid = uid();
    pd.enum = empn;
    pd.oeid = vid;
    let $this = this;
    let sql = Object.toSql(pd, "online_employee", "insert");
    await callServerMethod("sendEmployeeDoc", { id: pd.oeid, dep: pd.department, des: pd.designation });
    let res = await getData(sql);
    await addimg("employee_registration", pd.oeid);
    await addimg("pp", pd.oeid);
    if (res.error) {
        talert(res.msg, "Error...!", () => {});
    } else {
        talert("Application Submitted Successfully.We will revert back to you soon", "Information...", () => {
            t$("#fregapl.dbinput .dbfile").node.vue.forceRemove();
            t$("#imgpr.dbinput .dbfile").node.vue.forceRemove();
            Object.empty(vueapp.pcompany, "");
            Object.empty(vueapp.pfrom, "");
            Object.empty(vueapp.pto, "");
            Object.empty(vueapp.pdepartment, "");
            Object.empty(vueapp.pdesignation, "");


        });

    }

}

function onimginvalid(img, df) {
    df();
}



async function addimg(name, vid) {
    let newfile = "";
    let oldfile = "";
    if (name == 'employee_registration') {
        newfile = `upload/employee/onlineforms/${vid}/${name}.pdf`;
        oldfile = `upload/employee/onlineforms/temp/${ssid}/${name}.pdf`;
    } else {
        newfile = `upload/employee/onlineforms/${vid}/${name}.png`;
        oldfile = `upload/employee/onlineforms/temp/${ssid}/${name}.png`;
    }

    await callServerMethod("move", { oldfile: oldfile, newfile: newfile });
}
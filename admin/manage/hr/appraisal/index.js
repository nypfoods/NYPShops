function appraisal_data() {
    return {
        dessql: "",
        fsql: "",
        flds: { department: "", designation: "", fname: "", month: "" },
        chkopt: ['Poor', 'Average', 'Good', 'Excellent', 'Outstanding'],
        chkoptv: [1, 2, 3, 4, 5],
        rdate: extract_date(new Date()),
        apf: { department: "", designation: "", fname: "", month: "" },
        month: Object.values($month).map((val) => { return val.toWordCase(); }),
        rep: {},
        sbf: false,
        rdtls: {},
        getf: false,
        redrep: true
    };
}

ratekey = ['ujr', 'prs', 'kao', 'wia', 'rms', 'cip', 'rtp', 'aeg', 'cmt', 'mps', 'aie', 'pim', 'lc', 'iaet', 'oat', 'www', 'pitd', 'cig', 'hta', 'rstr', 'del', 'pmot'];

async function getMonthRating() {
    vueapp.getf = true;
    let res = await getData(`select * from appraisal where month='${vueapp.flds.month}' and eid='${vueapp.flds.eid}'`);
    if (res.data.length > 0) {
        res.col.map(function(val) {
            if (ratekey.includes(val)) {
                vueapp.rep[val] = vueapp.chkopt[res.data[0][val] - 1];
                t$(`#${val} input[value='${vueapp.rep[val]}']`).node.click();
                t$(`#${val} input[value='${vueapp.rep[val]}']`).attr('checked', true);
            }
        });
        vueapp.sbf = true;
        vueapp.rdtls = res.data[0];
    }
}

function appraisal_watch() {
    return {
        "flds.department": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from(select desname from designation as ds join department as d  where d.did=ds.did and dname='" + vueapp.flds.department + "') as designation";
            }
            this.getf = false;
        },
        "flds.designation": function(val) {
            if (vueapp) {
                vueapp.fsql = "select * from employee as e where   designation='" + vueapp.flds.designation + "' and department='" + vueapp.flds.department + "'";
            }
            this.getf = false;
        },
        "flds.month": function() {
            this.getf = false;
        },
        "flds.eid": function() {
            this.getf = false;
        },
        "apf.department": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from(select desname from designation as ds join department as d  where d.did=ds.did and dname='" + vueapp.apf.department + "') as designation";
            }
        },
        "apf.designation": function(val) {
            if (vueapp) {
                vueapp.fsql = "select * from employee as e where   designation='" + vueapp.apf.designation + "' and department='" + vueapp.apf.department + "'";
            }
        },

    };
}

async function addappraisal(...arr) {
    vueapp.flds.id = uid();
    vueapp.flds.adate = vueapp.rdate;
    if (vueapp.sbf) {
        vueapp.flds.id = vueapp.rdtls.id;
    }
    let flds = Object.assign({}, vueapp.flds, vueapp.rdtls);
    let sql = Object.toSql(flds, "appraisal", "replace");
    getData(sql).then((data) => {
        if (data.error == false) {
            talert("Appraisal added", "Information...", () => {
                let sv = vueapp.flds.month;
                Object.empty(vueapp.flds, "");
                vueapp.flds.month = sv;
                /*  t$("#itbl").node.vue.fetchData();
  t$("#itbl").node.vue.reloadTbl();*/
            });
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}
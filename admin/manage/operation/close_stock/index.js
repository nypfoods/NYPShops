function close_stock_data() {
    return {
        invfrom: "Vendor",
        invto: "Stock",
        trns: "Single Transfer",
        supd: supd,
        cdate: current_date(),
        rdate: (supd == current_date() ? supd : addDay(supd)),
        rdtls: {},
        getf: false,
        sbf: false,
        flds: {},
        stktbllen: -1,
        attrs: {
            "addcmt": {
                val: function(row, col, val, ms, whr, tblnm, isql) {
                    let addf = (row.ocb - row.cb) > 0;
                    let fld = addf ? "addcmt" : "lesscmt";
                    log("addcmt", addf, row, fld);
                    return `UPDATE ${tblnm} SET ${fld}='${val}' WHERE ${whr}`;
                }
            }
        }
    };
}

function close_stock_watch() {
    return {

    };
}

function onpageloaded() {

}

function callen(r) {
    vueapp.stktbllen = r.length;
    if (!chkOld()) {
        let fcol = stktbl.vue.fcol.filter((val) => val != 'ocb');
        if (fcol.length < stktbl.vue.fcol.length) {
            stktbl.vue.fcol = stktbl.vue.fcol.filter((val) => val != 'ocb');
        }
    }
}

function chkOld() {
    let chf = (new Date(supd)).getTime() < (new Date(vueapp.rdate)).getTime() ||
        supd == current_date();
    return chf
}


async function getreport() {
    let ic = tinfo("Geting stock info please wait...");
    callServerMethod("getstocklist", { date: vueapp.rdate }).then((data) => {
        ic();
        stktbl.vue.fetchData();
    });
}

async function updateclosestock(...arr) {
    vueapp.flds.id = uid();
    vueapp.flds.sdate = vueapp.rdate;
    if (vueapp.sbf) {
        vueapp.flds.id = vueapp.rdtls.id;
    }
    let flds = Object.assign({}, vueapp.flds, vueapp.rdtls);
    let sql = Object.toSql(flds, "stock_close", "replace");
    getData(sql).then((data) => {
        if (data.error == false) {
            talert("Stock Closed", "Information...", () => {
                Object.empty(vueapp.flds, "");
            });
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}

function clearreport() {
    let ic = tinfo("Clearing stock info please wait...");
    callServerMethod("clearreport", { rdate: vueapp.rdate }).then(() => {
        stktbl.vue.fetchData();
        ic();
    });
}

function updateStock() {
    let ic = tinfo("Updating stock info please wait...");
    callServerMethod("updateStock", { rdate: vueapp.rdate }).then(() => {
        stktbl.vue.fetchData();
        ic();
    });
}

function updatecb(v, d) {
    let pd = Object.assign({}, d.rval);
    pd.ncb = v;
    pd = JSON.stringify(pd);
    let ic = tinfo("Updating CB please wait...");
    callServerMethod("updatecb", { parm: pd }).then(() => {
        stktbl.vue.fetchData();
        ic();
    })
}

function updatestock(d) {

    let ic = tinfo('Updating Please Wait...');
    let pd = { qty: d.rval.dqty, pid: d.rval.pid, ordid: d.rval.ordid };
    callServerMethod("updatestockitem", pd).then((data) => {
        if (data.error == false) {
            tfrom.vue.searchData();
            talert("Transfer Successfull", "Success...!", () => {
                tto.vue.searchVal = d.rval.pname;
                tto.vue.searchData();
            });
        } else {
            talert("Error", "Warning...!", () => {});
        }
        ic();
    });


}

function bulkTransfer(d, e) {
    e.stopPropagation();
    let send = {};
    send.mrow = d.mrow;
    let pd = { pd: JSON.stringify(send) };
    callServerMethod("bulkTransfer", pd).then((data) => {
        if (data.error == false) {
            tfrom.vue.fetchData();
            tto.vue.fetchData();
            tfrom.vue.mrow = [];
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}
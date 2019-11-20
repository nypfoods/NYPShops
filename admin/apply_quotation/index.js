function apply_quotation_data() {
    return {
        apf: { blkno: 1, blkamt: 1, qty: 1, blkno: 1, pqty: 0, posp: 0 },
        udtl: JSON.parse(`<?=json_encode($udtl);?>`),
        elapsed_time: new Date(),
    };
}

t$("#node").on("winload", () => {
    ldb = "nypz";
});

function addrow() {
    let row = crtbl.vue.row;
    let obj = Object.clone(row[row.length - 1]);
    obj.pname = "";
    obj.id = "-";
    obj.new = true;
    row[row.length] = obj;
    crtbl.vue.row = Object.clone(row);
}

function updateitem(v, r, d) {
    d.rval.blkno = r != null ? r.sznum : d.rval.blkno;
    d.rval.bunt = v != null ? v : d.rval.bunt;
    let ic = tinfo("Updaing information....");
    callServerMethod('updateitem', { rval: JSON.stringify(d.rval) }).then((d) => {
        crtbl.vue.fetchData();
        ic();
    });
}

function onpageloaded() {
    ldb = "nypz";
}

function apply_quotation_watch() {
    return {
        "apf.qty": {
            immediate: true,
            handler: function(val) {
                this.apf.pqty = val * this.apf.blkno;
            }
        },
        "apf.blkno": function(val) {
            if (typeof val == "string") { val = val.parse('float'); }
            this.apf.pqty = val * this.apf.qty;
        },
        "apf.pqty": function(val) {
            this.apf.posp = round(this.apf.blkamt / val, 2);
        },
        "apf.blkamt": function(val) {
            this.apf.posp = round(val / this.apf.pqty, 2);
        }
    };
}

function hdlprd(v, r) {
    if (r != null) {
        vueapp.apf.punt = r.punt;
        vueapp.apf.pid = r.pid;
        vueapp.apf.pnum = r.pnum;
        vueapp.apf.pname = r.pname;
        vueapp.apf.pgst = r.pgst;
        vueapp.apf.pcat = r.pcat;
        vueapp.apf.ptype = r.ptype;
        vueapp.apf.pdvsn = r.pdvsn;
    } else {
        vueapp.apf.pid = 0;
        vueapp.apf.pnum = 0;
        vueapp.apf.pname = v;
    }
}

function makeBill() {
    let pd = {};
    let ic = tinfo("Updating your order please wait");
    pd["billamt"] = (billamt(getPrdRow()) + gstamt(getPrdRow()));
    log('hgf', pd["billamt"]);
    let param = {
        param: JSON.stringify(checkEventObj(pd))
    }
    callServerMethod("updatebill", param).then((data) => {
        if (data.error == false) {
            crtbl.vue.fetchData();
            bilhis.vue.fetchData();
            Object.empty(vueapp.apf, "");
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
        ic();
    });
}

function billamt(data) {
    return data.col("blkamt").sum();
}

function gstamt(data) {
    let gst = 0;
    data = data.toNum();
    gst = data.map((d) => {
        return (d.pgst / 100) * (d.pqty * d.posp);
    }).sum();
    return Math.round(gst, 2);
}

function getPrdRow() {
    if (isCartNotEmpty()) {
        return t$("#crtbl").node.vue.row;
    } else {
        return [];
    }
}

function isCartNotEmpty() {
    let ptbl = t$("#crtbl").node;
    return crtbl != null && crtbl.vue != null && crtbl.vue.row.length > 0;
}

function checkEventObj(obj) {
    let keys = Object.keys(obj);
    keys.map((k) => {
        let val = obj[k];
        if (val instanceof Event) {
            obj[k] = val.target.defaultValue;
        } else if (val == null) {
            obj[k] = "";
        }
    });
    return obj;
}

function addtocart() {
    vueapp.apf.billdate = extract_date();
    let pd = JSON.stringify(vueapp.apf);
    let ic = tinfo("Adding to cart please wait...");
    callServerMethod("addtocart", { pd: pd }).then((data) => {
        if (data.error) {
            talert(data.msg, "Some error occured");
        } else {
            crtbl.vue.fetchData();
        }
        Object.empty(vueapp.apf, "");
        ic();
    });
}

function viewbill(bilno, odate, $method, $name, d, print = "") {
    let url = "";
    if ($method == 'email') {
        tprompt('Enter Email Address', async (pf, e, val) => {
            if (pf) {
                url = screen_url(`admin/manage/invoice&bilno=${bilno}&odate=${odate}&display=${$method}&invtype=${$name}&template=true`);
                let pd = {};
                let content = await $get(url, {}, false);
                pd['content'] = content;
                pd['url'] = url;
                pd['sbj'] = "Invoice #" + bilno + " By " + window.location.hostname;
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
        }, { value: d.rval.email });
    } else {
        url = screen_url(`admin/manage/invoice&bilno=${bilno}&odate=${odate}&display=${$method}&invtype=${$name}${print}&template=true`);
        window.open(url, '_blank');
    }


}
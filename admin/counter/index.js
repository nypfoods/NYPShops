function counter_data() {
    return {
        psrch: "",
        catsrch: "",
        psearch: "",
        fptype: "%",
        apf: {
            pqty: 0,
            pmrp: 0,
            pgst: 0,
            euname: "",
            mnumber: "",
            dboys: [],
            ppaid: 0
        },
        catarr: [],
        typearr: [],
        onappprod: () => {},
        cpnobj: {
            cpnid: 0,
            cpnamt: 0
        },
        collect: 0,
        paymode: "Cash",
        bchnslct: null,
        cpnf: false,
        change: 0,
        sugf: false,
        toppingf: false,
        selprod: {},
        base: "",
        group: [],
        toppings: {},
        baseInp: undefined,
        chktbs: ['Cart'],
        cmbsql: `select distinct p1.* from products as p1,(select distinct pname,psz from counter where bilno=0) as p2 where p1.combo like concat('%"pname":"',p2.pname,'"%')  and combo <>"NULL" and pinv = 'Sales'`,
        tokenf: false,
        setlef: false,
        setlerow: {},
        rep: {
            frm: extract_date(),
            to: extract_date()
        }
    };
}

function settle(row) {
    vueapp.setlef = true;
    vueapp.setlerow = row;
}

function myrowatr(r) {
    let ar = ["Wi", "Pa", "Dl", "On", "Ot"];
    for (a of ar) {
        if (r.bchn.includes(a)) {
            return a + " " + r.ordsts;
        }
    }
}

async function delcnt(tbl, row, i, whr, dsql, obj) {
    let pd = JSON.stringify(row);
    pd = { pd: pd };
    let ic = tinfo("Deleting item please wait...");
    await callServerMethod("delcnt", pd);
    ic();
    return dsql;
}

function settleAmt() {
    let ic = tinfo("Settling your bill please wait");
    let pd = { pd: JSON.stringify(vueapp.setlerow) };
    callServerMethod("settleAmt", pd).then((data) => {
        if (data.error) {
            talert(data.msg, "Warning...!");
        } else {
            stltbl.vue.fetchData();
            bltbl.vue.fetchData();
        }
        vueapp.setlef = false;
        vueapp.setlerow = {};
        ic();
    });
}

function proceed() {
    if (isCartNotEmpty()) {
        vueapp.chktbs = vueapp.chktbs.extend(['Checkout']);
        //vueapp.sugf = true;
        t$("#crtchk").node.vue.tabindex = 1;
    }
}

function counter_computed() {
    return {
        "isPizza": function() {
            return this.selprod.ptype == "Pizza";
        }
    }
}

function getimg(row) {
    if (row.ptype == "combos") {
        return get_url(`upload/comboimage/${row['pid']}/comboimg.png`);
    } else {
        return get_url(`upload/products/${row['pid']}/pimage.png`);
    }
}

function getfullscr() {
    if (!t$("#navbar").hasClass("fullscr")) {
        t$("#navbar").class("fullscr");
        t$("#coutab>div:first-child").class("fullscr");
    } else {
        t$("#navbar").removeClass("fullscr");
        t$("#coutab>div:first-child").removeClass("fullscr");
    }
}

function parentTab(i, lvue) {
    if (i > 0) {
        let node = t$(lvue.$el).find(".dbtable")[i + 2];
        node.vue.fetchData();
    }
}

function counter_watch() {
    return {
        "psrch": function(val) {
            if (val instanceof Event) {
                this.psrch = val.target.defaultValue;
            }
        },
        "apf.cpname": function(val) {
            let nf = ((val instanceof Event) || vueapp.cpnobj.cpnid == 0) && val != "";
            let acval = "";
            if (val instanceof Event) {
                acval = val.target.value;
            }
            if (nf) {
                let acvali = (acval + "").parse("int");
                if (!isNaN(acvali)) {
                    if ((acval + "").includes("%")) {
                        this.apf.cpnamt = round(billamt(getPrdRow()) * (acvali / 100), 1);
                    } else {
                        this.apf.cpnamt = acvali;
                    }
                } else {
                    this.apf.cpname = acval;
                }
            }
            return acval;
        },
        "apf.ppaid": function(val) {
            this.collect = val;
        },
        collect: function(val) {
            this.change = calchange();
        },
        "apf.mnumber": function(val) {
            return val.mob();
        },
        "toppingf": function(val) {
            if (val == false) {
                this.selprod = {};
            }
        }
    };
}

function getPrdRow() {
    if (isCartNotEmpty()) {
        return t$("#ptbl").node.vue.row;
    } else {
        return [];
    }
}

function isCartNotEmpty() {
    let ptbl = t$("#ptbl").node;
    return ptbl != null && ptbl.vue != null && ptbl.vue.row.length > 0;
}

function chooseSz(sz, row = null) {
    if (isset(vueapp.baseInp)) {
        vueapp.baseInp.root.search = "";
    }
    let idx = vueapp.group.col('psz').indexOf(sz);
    if (row == null) {
        vueapp.selprod = Object.assign({}, vueapp.group[idx]);
    } else {
        vueapp.selprod = Object.assign({}, row);
    }
    vueapp.selprod.toppings = {};
    vueapp.selprod.base = {};
    vueapp.selprod.pqty = 1;
    vueapp.selprod.posp = (vueapp.selprod.posp - 0);
    vueapp.selprod.bposp = vueapp.selprod.posp;
    vueapp.toppings = {};
}

function adjustPrice() {
    vueapp.selprod.posp = vueapp.selprod.bposp
    if (isset(vueapp.selprod.toppings)) {
        vueapp.selprod.posp += Object.values(vueapp.selprod.toppings).col('posp').sum();
    }
    if (isset(vueapp.selprod.base.posp)) {
        vueapp.selprod.posp += (vueapp.selprod.base.posp - 0);
    }
}

function chooseTopping(i, row) {
    if (!isset(vueapp.selprod.toppings[i])) {
        let ipqty = 0;
        if (Object.keys(row.ingredients.json()).length > 0) {
            ipqty = row.ingredients.json()[0]["ipqty"];
        }
        vueapp.selprod.toppings[i] = {
            pid: row.pid,
            pnum: row.pnum,
            psz: row.psz,
            pname: row.pname,
            posp: row.posp,
            pveg: row.pveg,
            pqty: ipqty,
            ptype: 'Toppings'
        };
        vueapp.toppings[i] = true;
    } else {
        vueapp.selprod.toppings = Object.filval(vueapp.selprod.toppings, (v, j) => (j != i));
        vueapp.toppings[i] = false;
    }
    vueapp.selprod.toppings = Object.assign({}, vueapp.selprod.toppings);
    adjustPrice();
    vueapp.toppings = Object.assign({}, vueapp.toppings);
    vueapp.selprod = Object.assign({}, vueapp.selprod);

}

function handelPsearch(val, row, $this) {
    vueapp.psearch = row.pnum;
}

function onaddprd(val) {
    if (val != "") {
        sleep(300).then(() => {
            addprodctpre({ pname: val, pcat: "NEW", ptype: "NEW", group: [] });
            vueapp.psearch = "";
        });
    }
}

function ononedata(row, data) {
    let af = vueapp.psearch == row.pname;
    af = af || vueapp.psearch == row.pnum;
    af = af || vueapp.psearch == row.pslno;
    af = af || vueapp.psearch == row.pid;
    if (af) {
        addprodctpre(row);
        vueapp.psearch = "";
    }
}

function aftercustomize() {
    addprodct(vueapp.selprod);
    vueapp.toppingf = false;
}

async function addprodctpre(row) {
    let cpz = row.ptype == "Pizza";
    row.oqty = row.pqty;
    row.group = row.group.orderBy('int', 'psz');
    if (isset(row.group) && (row.group.length > 1 || cpz)) {
        vueapp.group = row.group;
        if (cpz) {
            chooseSz(row.psz, row);
        }
        let ic = tinfo("Customize your dish");
        vueapp.toppingf = true;
        ic();
        sleep(100).then(() => {
            let nd = t$("#chzbase input").node;
            if (nd) {
                nd.focus();
            }
        });
    } else {
        let nrow = Object.clone(row);
        await sleep(300);
        let rqty = await tprompt("Enter Qty for " + nrow.pname, () => {}, { type: "number", value: 1, min: 1 });
        if (rqty[0]) {
            nrow.pqty = rqty[2];
        }
        let rpgst = [rqty[0]];
        if (!isset(nrow.pgst) && rqty[0]) {
            await sleep(300);
            rpgst = await tprompt("Enter GST for " + nrow.pname, () => {}, { type: "number", value: '', min: 1 });
            if (rpgst[0]) { nrow.pgst = rpgst[2]; }
        }
        let rposp = [rpgst[0]];
        if (!isset(nrow.posp) && rpgst[0]) {
            await sleep(300);
            rposp = await tprompt("Enter Selling Price for " + nrow.pname, () => {}, { type: "number", value: '', min: 1 });
            if (rposp[0]) {
                nrow.pmrp = nrow.posp = rposp[2];
            }
        }
        if (rposp[0] === 0 || rposp[0]) {
            addprodct(nrow);
        }
    }
}

function chooseBase(name, row, $this) {
    ipqty = 1;
    if (Object.keys(row.ingredients.json()).length > 0) {
        ipqty = row.ingredients.json()[0]["ipqty"];
    }
    vueapp.selprod.base = {};
    vueapp.selprod.base.pnum = row.pnum;
    vueapp.selprod.base.pid = row.pid;
    vueapp.selprod.base.pname = name;
    vueapp.selprod.base.posp = (row.posp - 0);
    vueapp.selprod.base.pmrp = (row.pmrp - 0);
    vueapp.selprod.base.ptype = "Pizza Base";
    vueapp.selprod.base.pqty = ipqty;
    adjustPrice();
}

function addprodct(row) {
    let pd = {};
    pd["pnum"] = row.pnum;
    pd["pid"] = row.pid;
    pd["pqty"] = row.pqty;
    pd["oqty"] = row.oqty;
    pd["pmrp"] = row.pmrp;
    pd["posp"] = row.posp;
    pd["pveg"] = row.pveg;
    pd["bchn"] = vueapp.apf.bchn;
    pd["otamt"] = row.pqty * row.posp;
    pd["pname"] = row.pname;
    pd["pcat"] = row.pcat;
    pd["ptype"] = row.ptype;
    pd["pgst"] = row.pgst;
    pd["psz"] = row.psz;
    pd["regtime"] = extract_timestamp(new Date());
    if (isset(row.toppings)) {
        let tpng = Object.values(row.toppings);
        let len = tpng.length;
        if (isset(row.base)) {
            tpng[len] = row.base;
        }
        pd["toppings"] = JSON.stringify(tpng);
    }
    let param = {
        param: JSON.stringify(pd)
    }
    let $this = this;
    let ic = tinfo("Product adding please wait");
    callServerMethod("addcounter", param).then((data) => {
        if (data.error == false) {
            t$("#ptbl").node.vue.fetchData();
            t$("#crtchk").node.vue.tabindex = 0;
            vueapp.chktbs = ['Cart'];
            t$("#psearch input").node.focus();
        } else {
            talert(data.msg, "Warning...!", () => {
                t$("#psearch input").node.focus();
            });
        }
        vueapp.psearch = "";
        ic();
    });
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

function updatebillcounter() {
    let pd = {};
    pd["ordsts"] = vueapp.tokenf ? "B" : "S";
    pd["efname"] = vueapp.apf.efname;
    pd["email"] = vueapp.apf.email;
    pd["mnumber"] = vueapp.apf.mnumber;
    pd["address1"] = vueapp.apf.address1;
    pd["pmtd"] = vueapp.apf.pmtd;
    pd["cpnamt"] = pd["cpnid"] = 0;
    pd["bchn"] = vueapp.apf.bchn;
    if (typeof vueapp.cpnobj.cpnid != "undefined") {
        pd["cpnid"] = vueapp.cpnobj.cpnid;
        pd["cpnamt"] = cpnamt(getPrdRow()).amt;
    }
    if (vueapp.apf.pmtd == "Cash") {
        pd["ppaid"] = vueapp.collect;
    } else {
        pd["ppaid"] = (billamt(getPrdRow()) + gstamt(getPrdRow()));
    }
    let param = {
        param: JSON.stringify(checkEventObj(pd))
    }
    let $this = this;
    let ic = tinfo("Updating your order please wait");
    callServerMethod("updatebillcounter", param).then((data) => {
        if (data.error == false) {
            ptbl.vue.fetchData();
            stltbl.vue.fetchData();
            bltbl.vue.fetchData();
            if (!vueapp.tokenf) {
                viewbill(data.bilno, data.odate, 'view', 'counter', data, print = "&print=true");
            } else {
                talert("Estimate Created", "Information");
            }
            let bchn = vueapp.apf.bchn;
            Object.empty(vueapp.apf, "");
            vueapp.apf.ppaid = 0;
            vueapp.chktbs = ['Cart'];
            vueapp.apf.bchn = bchn;
            t$("#crtchk").node.vue.tabindex = 0;
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
        ic();
    });
}

function onimginvalid(img, df, dpath) {
    df();
}

function hadelcustSearch(name, row) {
    this.apf["mnumber"] = row["mnumber"];
    this.apf["address1"] = row["address1"];
    this.apf["efname"] = row["efname"];
    this.apf["email"] = row["email"];
}

function handelTab(i, lvue) {
    let node = t$(lvue.$el).find(".dbtable")[i];
    node.vue.fetchData();
}

function subQty(itmid, dobj) {
    let pd = {};
    pd["itmid"] = itmid;
    pd["qty"] = 1;
    pd["add"] = 0;
    let ic = tinfo("Updating Qty please wait....");
    callServerMethod("addQty", pd).then((data) => {
        if (data.error == false) {
            ptbl.vue.fetchData();
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
        ic();
    });
}

function addQty(itmid, dobj) {
    let pd = {};
    pd["itmid"] = itmid;
    pd["qty"] = 1;
    pd["add"] = 1;
    let ic = tinfo("Updating Qty please wait....");
    callServerMethod("addQty", pd).then((data) => {
        if (data.error == false) {
            ptbl.vue.fetchData();
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
        ic();
    });
}

function billamt(data) {
    return data.col("pamt").sum();
}

function fillcoupon(name, row) {
    vueapp.cpnobj = row;
    vueapp.apf.cpnf = false;
    vueapp.apf.cpnf = true;
    vueapp.change = calchange();
}

function cpnamt(data) {

    let blamt = billamt(data);
    let per = 0;
    let damt = (vueapp != null) ? (vueapp.apf.cpnamt || 0) : 0;
    let vcpobjv = {};
    if (vueapp != null && isset(vueapp.cpnobj) && isset(vueapp.cpnobj.cdicpf)) {
        vcpobjv = parseFloat(vueapp.cpnobj.cdisv);
        per = vueapp.cpnobj.cdicpf;
        damt = 0;
        if (per !== 0) {
            damt = Math.round(blamt * (vcpobjv / 100));
        } else {
            damt = vcpobjv;
        }
        if (damt > vueapp.cpnobj.cmaxd) {
            damt = parseFloat(vueapp.cpnobj.cmaxd);
        } else if (damt < vueapp.cpnobj.cmind) {
            damt = parseFloat(vueapp.cpnobj.cmind);
        }
    }
    return {
        amt: damt,
        per: per,
        val: vcpobjv
    };
}

function disamt(data) {
    let blamt = billamt(data);
    let cpnres = cpnamt(data);
    let gstres = gstamt(data);
    let tamt = Math.round(blamt - cpnres.amt + gstres);
    return tamt;
}

function gstamt(data) {
    let gst = 0;
    //data = rowToNum(data);
    data = data.toNum();
    gst = data.map((d) => {
        return (d.pgst / 100) * (d.pqty * d.posp);
    }).sum();
    return Math.round(gst, 2);
}

function calchange() {

    return Math.abs(parseFloat(vueapp.collect) - disamt(getPrdRow()));
}

function updatedesc(itmid, otdesc) {
    let pd = {};
    pd["itmid"] = itmid;
    pd["otdesc"] = otdesc;
    callServerMethod("updatedesc", pd).then((data) => {
        if (data.error == false) {
            ptbl.vue.fetchData();
        } else {
            talert(data.msg, "Warning...!", () => {});
        }

    });
}

function viewbill(bilno, odate, $method, $name, d, print = "") {
    let url = "";
    if ($method == 'email') {
        tprompt('Enter Email Address', async (pf, e, val) => {
            if (pf) {
                url = screen_url(`admin/manage/invoice&bilno=${bilno}&odate=${odate}&display=${$method}&invtype=${$name}&ordmethod=counter&template=true`);
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
        url = screen_url(`admin/manage/invoice&bilno=${bilno}&odate=${odate}&display=${$method}&invtype=${$name}&ordmethod=counter${print}&template=true`);
        window.open(url, '_blank');
    }


}



function changestatus(d, cancel = false) {
    let pd = {};

    pd["bilno"] = d.rval.bilno;
    pd["ordsts"] = d.rval.ordsts;
    pd["eid"] = d.rval.eid;
    pd["ordid"] = d.rval.ordid;
    pd["cancel"] = cancel;
    pd["dboys"] = vueapp.apf.dboys[d.i];
    if (pd["dboys"] == "NULL" || pd["dboys"] == "" || !pd["dboys"]) {
        talert("Please select Delivery Boy", "Warning...!", () => {});
        return;
    }
    let param = {
        param: JSON.stringify(pd)
    }
    let $this = this;
    let ic = tinfo("Sending  please wait....");
    callServerMethod("changestatus", param).then((data) => {
        ic();
        if (data.error == false) {

            ptbl.vue.fetchData();

            talert("Status Changed", "Information...!", () => {});
        } else {
            talert("Error", "Warning...!", () => {});
        }

    });
}

function counterstatus(bilno, sts, eid, ordid) {
    let pd = {};
    pd["bilno"] = bilno;
    pd["ordsts"] = sts;
    pd["eid"] = eid;
    pd["ordid"] = ordid;
    if (vueapp.apf.dboys[d.i]) {
        pd["dboys"] = vueapp.apf.dboys[d.i];
    } else {
        pd["dboys"] = "";
    }


    let param = {
        param: JSON.stringify(pd)
    }
    let $this = this;
    let ic = tinfo("Sending to kitchen please wait....");
    callServerMethod("counterstatus", param).then((data) => {
        ic();
        if (data.error == false) {
            t$('#kctbl').node.vue.fetchData();
            t$('#pctbl').node.vue.fetchData();
            t$('#dctbl').node.vue.fetchData();
            talert("Status Changed", "Information...!", () => {});
        } else {
            talert("Error", "Warning...!", () => {});
        }

    });
}
function purchase_data() {
    return {
        apf: { pqty: 1, purdesc: "" },
        cmbslct: { purid: '' },
        reor: [{ rqty: 1 }],
        elapsed_time: new Date(),
        papf: {},

    };
}


function handelTab(i, lvue) {
    let node = t$(lvue.$el).find(".dbtable")[i];
    node.vue.fetchData();
}

function hadelcustSearch(name, row) {
    vueapp.apf["uid"] = row["uid"];
    vueapp.apf["mnumber"] = row["mnumber"];
    vueapp.apf["address1"] = row["address1"];
    vueapp.apf["fname"] = row["fname"];
    vueapp.apf["email"] = row["email"];
    vueapp.apf["vname"] = row["vname"];

}

function addtopurchase() {
    let pd = {};
    let vprice = vueapp.apf.vprice.split(',');
    let vid = vueapp.apf.vid.split(',');
    let idx = vid.indexOf(vueapp.cmbslct.vid);

    pd["pid"] = vueapp.apf.pid;
    pd["pqty"] = vueapp.apf.pqty;
    pd["purdesc"] = vueapp.apf.purdesc;
    pd["pveg"] = vueapp.apf.pveg;
    pd["pname"] = vueapp.apf.pname;
    pd["pcat"] = vueapp.apf.pcat;
    pd["ptype"] = vueapp.apf.ptype;
    pd["psz"] = vueapp.apf.psz;
    pd["punt"] = vueapp.apf.punt;
    pd["pnum"] = vueapp.apf.pnum;
    pd["vid"] = vueapp.cmbslct.vid;
    pd["vprice"] = vprice[idx];
    pd["vname"] = vueapp.cmbslct.name;
    pd["vmob"] = vueapp.cmbslct.mobno;
    pd["vemail"] = vueapp.cmbslct.email;
    pd["vaddress"] = vueapp.cmbslct.adresss;
    /*    pd["posp"] = vprice[idx];*/
    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("addtopurchase", param).then((data) => {
        if (data.error == false) {
            pstock.vue.fetchData();
            t$("#cmtbl").node.vue.fetchData();
            talert("Product Added to cart", "Information...", () => {});
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}

function hadelProductSearch(name, row) {
    vueapp.apf["pid"] = row["pid"];
    vueapp.apf["pcat"] = row["pcat"];
    vueapp.apf["ptype"] = row["ptype"];
    vueapp.apf["psz"] = row["psz"];
    vueapp.apf["pveg"] = row["pveg"];
    vueapp.apf["vprice"] = row["vprice"];
    vueapp.apf["vid"] = row["vid"];
    vueapp.apf["pgst"] = row["pgst"];
    vueapp.apf["punt"] = row["punt"];
    vueapp.apf["pnum"] = row["pnum"];
}

function psearch(name, row) {
    this.apf["vid"] = row["vid"];

}

function purchase_order() {
    if (cmtbl.vue.row.length <= 0) {
        talert("Please add some products", "Warning...!", () => {});
        return;
    }
    let pd = {};
    pd["vid"] = vueapp.cmbslct.vid;
    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("purchase_order", param).then((data) => {
        if (data.error == false) {
            let url = screen_url(`admin/manage/invoice&ordid=${data.ordid}&template=true&invtype=null&ordmethod=purchase`);
            window.open(url, '_blank');
            t$("#cmtbl").node.vue.fetchData();
            talert("Purchase Request Successfull", "Information...", () => {});
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}

function delivery_status() {
    callServerMethod("purchase_order").then((data) => {
        if (data) {
            let url = screen_url(`admin/manage/invoice&ordid=${data.ordid}&odate=${data.odate}&template=true&invtype=null&ordmethod=purchase`);
            window.open(url, '_blank');
            t$("#ptbl").node.vue.fetchData();

        } else {
            talert(data.msg, "Warning...!", () => {});
        }

    });
}

function viewordered_items(ordid, odate) {
    let url = screen_url(`admin/manage/invoice&ordid=${ordid}&odate=${odate}&template=true&invtype=null&ordmethod=purchase`);
    window.open(url, '_blank');
}

function viewdelivered_bill(ordid, ddate) {
    let url = screen_url(`admin/manage/invoice&ordid=${ordid}&ddate=${ddate}&template=true&invtype=null&ordmethod=purchasebill`);
    window.open(url, '_blank');
}
async function updateswitch(d) {
    await callServerMethod("updateswitch", { id: d.rval.ordid, billno: d.rval.bilno });
    d.updateItem(null, d.rval.dstatus, 'dstatus', d.rval, d.i);
    t$("#vptbl").node.vue.fetchData();
}

function reorderProduct(i) {

    let pd = {};
    pd["pid"] = vueapp.reor[i].pid;
    pd["vid"] = vueapp.reor[i].vid;
    pd["rqty"] = vueapp.reor[i].rqty;
    pd["vprice"] = vueapp.reor[i].vprice;
    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("readdtopurchase", param).then((data) => {
        if (data.error == false) {
            pstock.vue.fetchData();
            talert("Product Added to cart", "Information...", () => {});
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });


}

function getvdtl(vname, row, i) {
    vueapp.reor[i] = isset(vueapp.reor[i]) ? vueapp.reor[i] : {};
    let idx = row.vname.split(",").indexOf(vname);
    let vid = row.vid.split(",")[idx];
    let vprice = row.vprice.split(",")[idx];
    vueapp.reor[i].vid = vid;
    vueapp.reor[i].pid = row.pid;
    vueapp.reor[i].vprice = vprice;
}
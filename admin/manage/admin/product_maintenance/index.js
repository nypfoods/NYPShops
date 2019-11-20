function product_maintenance_data() {
    return {
        invfrom: "Godown",
        invto: "Production",
        trns: "Single Transfer"
    };
}

function addmaintenance() {
    let pd = {};
    pd["pname"] = vueapp.apf.pname;
    pd["pcat"] = vueapp.apf.pcat;
    pd["pnote"] = vueapp.apf.pnote;
    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("addmaintenance", param).then((data) => {
        if (data.error == false) {
            t$("#ptbl").node.vue.fetchData();
        } else {
            talert(data.msg, "Warning...!", () => {});
        }

    });
}

function bulkTransfer(d, e) {
    e.stopPropagation();
    let send = {};
    send.mrow = d.mrow;
    send.invfrom = vueapp.invfrom;
    send.invto = vueapp.invto;
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

function onimginvalid(img, df, dpath) {
    df();
}

function checkRequired($func = () => {}) {
    let fg = 1;
    chknodes(t$("*:required"), function($node) {
        fg *= $node.value == "" ? 0 : 1;
    })
    if (fg == 0) {
        talert("Please fill required Feilds", "Warning...!", () => {});
    } else {
        $func();
    }
}

function product_maintenance_watch() {
    return {

        "apf.pcat": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from rawproducts where pcat='" + vueapp.apf.pcat + "'";
            }
        },
    };
}

function transferItem(d) {
    let exec = () => {
        let ic = tinfo('Transfering Please Wait...');
        let pd = { qty: d.rval.tqty, pid: d.rval.pid, invfrm: vueapp.invfrom, invto: vueapp.invto };
        callServerMethod("transferItem", pd).then((data) => {
            if (data.error == false) {
                tfrom.vue.searchData();
                talert("Done", "Success...!", () => {
                    tto.vue.searchVal = d.rval.pname;
                    tto.vue.searchData();
                });
            } else {
                talert("Error", "Warning...!", () => {});
            }
            ic();
        });
    };
    if (d.rval.pqty.parse('float') <= d.rval.mqty.parse('float')) {
        tconfirm('Quantity is less than minimum Qty.Are you sure to transfer?', 'Warning', (f) => { if (f) { exec(); } });
    } else {
        exec();
    }
}

function changestatus(row) {
    let pd = {};
    pd["id"] = row.id;

    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("changestatus", param).then((data) => {
        if (data.error == false) {
            t$('#insisitm').node.vue.fetchData();
            talert("Done", "Success...!", () => {});
        } else {
            talert("Error", "Warning...!", () => {});
        }
    });
}
function kot_data() {
    return {
        apf: {},
        extract_time: extract_time,
        elapsed_time: new Date()
    };
}

t$("#node").on("onintervel", () => {
    if (vueapp != null) {
        vueapp.elapsed_time = new Date();
    }
    t$("#ordrs").node.vue.fetchData();
});

function getElapsedTime() {
    return extract_time(vueapp.elapsed_time);
}



function changestatus(d, cancel = false) {
    let pd = {};

    pd["bilno"] = d.rval.bilno;
    pd["ordsts"] = d.rval.ordsts;
    pd["eid"] = d.rval.eid;
    pd["ordid"] = d.rval.ordid;
    pd["cancel"] = cancel;
    pd["dboys"] = vueapp.apf.dboys[d.i];
    log("dboys", vueapp.apf.dboys, d.i, pd["dboys"]);
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
    let param = {
        param: JSON.stringify(pd)
    }
    let $this = this;
    tconfirm("Do you really want to compleate this order (Warning this action is irreversible)", "Warning", (f) => {
        if (f) {
            let ic = tinfo("Order Prepared....");
            callServerMethod("counterstatus", param).then((data) => {
                ic();
                if (data.error == false) {
                    t$("#ordrs").node.vue.fetchData();
                } else {
                    talert("Error", "Warning...!", () => {});
                }

            });
        }
    });
}
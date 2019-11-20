function vendor_product_data() {
    return {
        vplst: {},
        quoplist: {},
        apf: {},
        elapsed_time: new Date(),
        cmtblattrs: {
            vprice: {
                type: "number",
                val: function(row, col, val, a, whr, tblname) {
                    let vprice = row.vprice.split(",");
                    let vid = row.vid.split(",");
                    let pos = vid.indexOf(vueapp.vplst.vid);
                    vprice[pos] = val;
                    let nval = vprice.join(",");
                    let sql = `UPDATE ${tblname} SET vprice = '${nval}' WHERE ${whr};`;
                    return sql;
                }
            }
        }
    };
}

function approvestatus(r, v) {
    r[0].apstatus = v;
    let pd = JSON.stringify(r);
    let ic = tinfo("Updating Please wait...");
    callServerMethod("approvestatus", { prm: pd }).then((data) => {
        talert(data.msg, "Information");
        bilhis.vue.fetchData();
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

function delven(d) {
    let pid = d.rval.pid;
    let vid = vueapp.vplst.vid;
    tconfirm("Are you sure you want to delete this Product", "Warning", (f) => {
        if (f) {
            let ic = tinfo("Deleting Product registry please wait....");
            callServerMethod("deletevprice", { pid: pid, vid: vid }).then((data) => {
                if (data.error) {
                    talert(data.msg, "Error....", () => {});
                } else {
                    t$("#cmtbl").node.vue.fetchData();
                }
                ic();
            });
        }
    });
}

function getVenPos(d) {
    let vids = d.rval.vid.split(",");
    return vids.indexOf(vueapp.vplst.vid);
}

function update_order() {
    let pd = {};
    pd['pid'] = vueapp.apf.pid;
    pd['vprice'] = vueapp.apf.vprice;
    pd['vid'] = vueapp.vplst.vid;
    pd['vname'] = vueapp.vplst.name;
    let param = { param: JSON.stringify(pd) }
    let ic = tinfo("Updating Product registry please wait....");
    callServerMethod("updateproduct", param).then((data) => {
        if (data.error) {
            talert(data.msg, "Error....", () => {});
        } else {
            vueapp.apf.pname = "";
            vueapp.apf.vprice = "";
            t$("#cmtbl").node.vue.fetchData();
        }
        ic();
    });
}
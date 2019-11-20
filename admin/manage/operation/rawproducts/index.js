function rawproducts_data() {
    return {
        dcol: {
            pname: "Product Name",
            pcat: "Category",
            ptype: "Type",
            pveg: "Veg",
            psz: "Size",
            pqty: "Stock",
            mqty: "Min Stock",
            vname: "Vendor Name",
            vprice: "Cost",
            posp: "Sale",
            pmrp: "MRP",
            punt: "Unit",
            pdvsn: 'Division',
            penb: 'Enable'
        },
        attrs: {
            pcat: {
                type: "select",
                sql: "select * from cat",
                fcol: "catname"
            },
            ptype: {
                type: "select",
                sql: "select * from type",
                fcol: "typname"
            },
            punt: {
                type: "select",
                sql: "select * from sizes",
                fcol: "szname"
            },
            psz: {
                type: "select",
                sql: "select name from psz",
                fcol: "name"
            },
            pdvsn: {
                type: "select",
                sql: "select dvsnname from dvsn",
                fcol: "dvsnname"
            },
            vname: {
                type: "multi-search",
                sql: "select *,name as vname from online_vendor where active=1",
                fcol: "name",
                val: function(row, col, val, ms, whr, tblnm, isql) {
                    console.log("vname", val);
                    let vid = ms.col('vid');
                    return `UPDATE ${tblnm} SET vname='${val}',vid='${vid}' WHERE ${whr}`;
                },
                all: true
            },
            pqty: {
                type: "number"
            },
            mqty: {
                type: "number"
            },
            posp: {
                type: "number"
            },
            pmrp: {
                type: "number"
            }
        },
        arp: {
            pname: "",
            pcat: "",
            ptype: "",
            pdvsn: "",
            pgst: 0,
            psz: "",
            pqty: 0,
            mqty: 0,
            punt: "Grms",
            pcp: 0,
            posp: 0,
            pmrp: 0,
            pdesc: "",
            vid: "",
            vname: "",
            vprice: "",
            pveg: 1
        },
        tarp: {
            vprice: [],
            psz: ['N/A'],
            pcp: [0],
            posp: [0],
            pmrp: [0],
            pqty: [0],
            mqty: [0],
            punt: ['Grms']
        },
        edit: {
            vprice: {}
        },
        sv: ""
    };
}

function getvprice() {
    return vueapp.arp.vid.split(",").map(function(val, i) {
        return vueapp.tarp.vprice[i];
    }).join();
}

function getpdtlbysz(name) {
    let psz = vueapp.tarp.psz;
    return psz.map(function(val, i) {
        return vueapp.tarp[name][i];
    }).join();
}

function filterpz(i) {
    vueapp.tarp.psz = vueapp.tarp.psz.filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.pqty = vueapp.tarp.pqty.filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.mqty = vueapp.tarp.mqty.filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.posp = vueapp.tarp.posp.filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.pmrp = vueapp.tarp.pmrp.filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.pcp = vueapp.tarp.pcp.filter((val, j) => {
        return j != i;
    });
}

function addpsz(i) {
    vueapp.tarp.psz = vueapp.tarp.psz.map((v) => v).extend(['N/A'], true);
    ['pcp', 'posp', 'pmrp', 'pqty', 'mqty'].map((k) => {
        vueapp.tarp[k][i + 1] = 0;
    });
    vueapp.tarp.punt[i + 1] = "Grms";
}

function addproduct() {
    let pd = vueapp.arp;
    pd.vprice = getvprice();
    pd.psz = getpdtlbysz("psz");
    pd.pqty = getpdtlbysz("pqty");
    pd.mqty = getpdtlbysz("mqty");
    pd.posp = getpdtlbysz("posp");
    pd.pcp = getpdtlbysz("pcp");
    pd.pmrp = getpdtlbysz("pmrp");
    callServerMethod("addproduct", pd).then((data) => {
        if (data.error == false) {
            t$("#ptbl").node.vue.fetchData();
            t$("#pvtbl").node.vue.fetchData();
            talert("Product Added", "Information", () => { appprdreset(); });

        } else {
            talert(data.msg, "Error....", () => {});
        }
    });
}

function appprdreset() {
    /*  t$('#addrawprd').node.vue.showTab(0);*/
    Object.empty(vueapp.arp, "", ['pname', 'pcat', 'ptype', 'pdvsn', 'psz', 'pdesc', 'vid', 'vname', 'vprice']);
    Object.empty(vueapp.arp, 0, ['pgst', 'pqty', 'mqty', 'pcp', 'posp', 'pmrp']);
    Object.empty(vueapp.arp, 1, ['pveg']);
    Object.empty(vueapp.arp, "Grms", ['punt']);
    Object.empty(vueapp.tarp, [0], ['pqty', 'mqty', 'pcp', 'posp', 'pmrp']);
    Object.empty(vueapp.tarp, ['N/A'], ['psz']);
    Object.empty(vueapp.tarp, ['Grms'], ['punt']);
}
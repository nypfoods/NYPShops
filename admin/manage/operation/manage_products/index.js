function manage_products_data() {
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
            ingredients: "Ingredients",
            penb: "Product Status",
            pveg: "Veg Status",
            pdvsn: 'Division',
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
            pdvsn: {
                type: "select",
                sql: "select dvsnname from dvsn",
                fcol: "dvsnname"
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
            vname: {
                type: "multi-search",
                sql: "select * from online_vendor",
                fcol: "name",
                val: function(row, col, val, ms, whr, tblnm, isql) {
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
            pdvsn: "",
            pcat: "",
            ptype: "",
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
            pveg: 1,
            ingredients: "",
            psug: ""
        },
        tarp: {
            vprice: [],
            psz: ['N/A'],
            psug: [''],
            pcp: [0],
            posp: [0],
            pmrp: [0],
            pqty: [0],
            mqty: [0],
            punt: ['Grms'],
            ifname: [
                ['']
            ],
            ipnum: [
                ['']
            ],
            ipid: [
                ['']
            ],
            ipname: [
                ['']
            ],
            ipcat: [
                ['']
            ],
            iptype: [
                ['']
            ],
            ipqty: [
                [0]
            ],
            ipunt: [
                ['Grms']
            ],
            iposp: [
                [0]
            ],
            ipmrp: [
                [0]
            ],
            ipdvsn: [
                ['']
            ]
        },
        edit: {
            vprice: {}
        },
        ing: [],
        sv: "",
        sug: []
    };
}

function seting(val, row, i, j) {
    log(val, row, i, j);
    vueapp.tarp.ipid[j][i] = row.pid;
    vueapp.tarp.ipnum[j][i] = row.pnum;
    vueapp.tarp.ipname[j][i] = row.pname;
    vueapp.tarp.ipdvsn[j][i] = row.ipdvsn;
    vueapp.tarp.ipcat[j][i] = row.pcat;
    vueapp.tarp.iptype[j][i] = row.ptype;
    vueapp.tarp.ipunt[j][i] = row.punt;
    vueapp.tarp.iposp[j][i] = row.posp;
    vueapp.tarp.iposp[j][i] = row.pmrp;
}

function ingadd(i) {
    let len = vueapp.ing[i].length;
    vueapp.ing[i][len] = {
        ifname: "",
        ipname: "",
        ipdvsn: "",
        ipcat: "",
        iptype: "",
        ipqty: 0,
        iposp: 0,
        ipunt: "Grms",
        iposp: 0,
        ipmrp: 0
    };
    vueapp.ing = vueapp.ing.map((v) => v);
}

function ingdel(i, j) {
    vueapp.ing[i] = [].extend(vueapp.ing[i].filter((v, k) => k != j));
    vueapp.ing = vueapp.ing.map((v) => v);
}

function upding(i, j, row) {
    vueapp.ing[i][j].ipnum = row.pnum;
    vueapp.ing[i][j].ipid = row.pid;
    vueapp.ing[i][j].ipname = row.pname;
    vueapp.ing[i][j].ipdvsn = row.pdvsn;
    vueapp.ing[i][j].ipcat = row.pcat;
    vueapp.ing[i][j].iptype = row.ptype;
    vueapp.ing[i][j].ipunt = row.punt;
    vueapp.ing[i][j].iposp = row.posp;
    vueapp.ing[i][j].ipmrp = row.pmrp;
}

function adding(i, j) {
    ['ifname', 'ipnum', 'ipid', 'ipname', 'ipdvsn', 'ipcat', 'iptype', 'ipunt', 'ipqty', 'iposp', 'ipmrp'].map((k) => {
        vueapp.tarp[k][j] = isset(vueapp.tarp[k][j]) ? vueapp.tarp[k][j] : [];
    });
    vueapp.tarp.ifname[j] = vueapp.tarp.ifname[j].map((v) => v);
    vueapp.tarp.ifname[j][i + 1] = "";
    ['ipnum', 'ipid', 'ipname', 'ipdvsn', 'ipcat', 'iptype'].map((k) => {
        vueapp.tarp[k][j][i + 1] = '';
    });
    vueapp.tarp['ipqty'][j][i + 1] = 0;
    vueapp.tarp['iposp'][j][i + 1] = 0;
    vueapp.tarp['ipmrp'][j][i + 1] = 0;
    vueapp.tarp['ipunt'][j][i + 1] = "Grms";
    vueapp.tarp.ifname = vueapp.tarp.ifname.map((v) => { return v });
}

function filtering(i, k) {
    vueapp.tarp.ifname[k] = vueapp.tarp.ifname[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipid[k] = vueapp.tarp.ipid[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipnum[k] = vueapp.tarp.ipnum[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipname[k] = vueapp.tarp.ipname[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipdvsn[k] = vueapp.tarp.ipdvsn[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipcat[k] = vueapp.tarp.ipcat[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.iptype[k] = vueapp.tarp.iptype[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipqty[k] = vueapp.tarp.ipqty[k].filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipunt[k] = vueapp.tarp.ipunt.filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.iposp[k] = vueapp.tarp.iposp.filter((val, j) => {
        return j != i;
    });
    vueapp.tarp.ipmrp[k] = vueapp.tarp.ipmrp.filter((val, j) => {
        return j != i;
    });
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

function getpdtlbyifname() {
    let psz = vueapp.tarp.psz;
    let obj = [];
    psz.map((sz, l) => {
        ['ifname', 'ipnum', 'ipid', 'ipname', 'ipdvsn', 'ipcat', 'iptype', 'ipqty', 'ipunt', 'iposp', 'ipmrp']
        .map((k, j) => {
            let ifname = vueapp.tarp.ifname[l];
            obj[l] = isset(obj[l]) ? obj[l] : [];
            ifname.map(function(val, i) {
                obj[l][i] = isset(obj[l][i]) ? obj[l][i] : {};
                obj[l][i][k] = vueapp.tarp[k][l][i];
            });
        });
    });
    obj = obj.map((v) => { return JSON.stringify(v); });
    return obj.join("#-sep-#");
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
    adding(-1, i + 1);
    vueapp.tarp.psz = vueapp.tarp.psz.map((v) => v).extend(['N/A'], true);
    ['pcp', 'posp', 'pmrp', 'pqty', 'mqty', ''].map((k) => {
        vueapp.tarp[k][i + 1] = 0;
    });
    vueapp.tarp.punt[i + 1] = "Grms";
}

function getSug() {
    return JSON.stringify(vueapp.sug);
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
    pd.ingredients = getpdtlbyifname();
    pd.psug = getSug();
    callServerMethod("addproduct", pd).then((data) => {
        if (data.error) {
            talert(data.msg, "Error....", () => {});
        } else {
            t$("#ptbl").node.vue.fetchData();
            t$("#etbl").node.vue.fetchData();
            talert("Product Added", "Information", () => { appprdreset(); });
        }
    });
}

function appprdreset() {
    t$('#addrawprd').node.vue.showTab(0);
    Object.empty(vueapp.arp, "", ['pname', 'pdvsn', 'pcat', 'ptype', 'psz', 'pdesc', 'vid', 'vname', 'vprice']);
    Object.empty(vueapp.arp, 0, ['pgst', 'pqty', 'mqty', 'pcp', 'posp', 'pmrp']);
    Object.empty(vueapp.arp, 1, ['pveg']);
    Object.empty(vueapp.arp, "Grms", ['punt']);
    Object.empty(vueapp.tarp, [0], ['pqty', 'mqty', 'pcp', 'posp', 'pmrp']);
    Object.empty(vueapp.tarp, ['N/A'], ['psz']);
    Object.empty(vueapp.tarp, ['Grms'], ['punt']);
    Object.empty(vueapp.tarp, [
        ['']
    ], ['ipname', 'ipnum', 'ipid', 'ipcat', 'iptype', 'ifname']);
    Object.empty(vueapp.tarp, [
        ['Grms']
    ], ['ipunt']);
    Object.empty(vueapp.tarp, [
        [0]
    ], ['ipqty', 'iposp', 'ipmrp']);
    vueapp.sug = [];
}
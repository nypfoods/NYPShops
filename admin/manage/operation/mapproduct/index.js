function mapproduct_data() {
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
            penb: "Enable"
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
        saleprod: [],
        bool: []
    };
}

function chkenb(data) {
    vueapp.saleprod = data.map((v) => v);
}


function mapProduct(val, row, fd) {
    let pd = {};
    pd["pid"] = row["pid"];
    val = val ? 1 : 0;
    pd["penb"] = val;
    callServerMethod("productEnable", pd).then((data) => {
        if (data.error == false) {
            t$("#stbl").node.vue.fetchData();
            t$("#estbl").node.vue.fetchData();
            t$("#dstbl").node.vue.fetchData();
            fd();
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}

function getBool(rowa, row, i) {
    vueapp.bool[i] = rowa.col("pid").includes(row.pid);
    return vueapp.bool;
}
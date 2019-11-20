function mapcounter_data() {
    return {
        apf: {},
        eapf: {},
        onappemp: () => {},
    };
}

function addcounter(...arr) {
    let sql = "insert into counter_map (`id`,`cname`) values ('" + uid() + "','" + vueapp.apf.cname + "')";
    getData(sql).then((data) => {
        if (data.error == false) {
            talert("Counter Added", "Information...", () => {
                Object.empty(vueapp.apf, "");
                t$("#ctbl").node.vue.fetchData();
                t$("#ctbl").node.vue.reloadTbl();
            });
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}

function addemployee(...arr) {
    let pd = {};
    pd["eid"] = vueapp.eapf.eid;
    pd["cname"] = vueapp.eapf.cname;
    pd["cid"] = vueapp.eapf.cid;
    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("addecounter", param).then((data) => {
        if (data.error == false) {
            Object.empty(vueapp.eapf, "");
            t$("#etbl").node.vue.fetchData();
            t$("#etbl").node.vue.reloadTbl();
            talert("Employee added to Counter", "Information...", () => {});
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });

}
function combomap_data() {
    return {
        combo: "",
        comboobj: ""
    };
}

function combomap_watch() {
    return {
        combo: function(v) {
            if (v.combo.json()) {
                this.comboobj = v.combo.json();
            } else {
                this.comboobj = [];
            }

        }
    };
}

function rmvecomboprd(i) {
    vueapp.comboobj = vueapp.comboobj.filter((v, j) => j != i);
}

function addcomboprd() {
    vueapp.comboobj[vueapp.comboobj.length] = {};
    vueapp.comboobj = vueapp.comboobj.map((v) => v);
}

function hdlPrdSrch(i, r) {
    vueapp.comboobj[i].pid = r.pid;
    vueapp.comboobj[i].posp = r.posp;
    vueapp.comboobj[i].pmrp = r.pmrp;
    vueapp.comboobj[i].punt = r.punt;
    vueapp.comboobj[i].pcat = r.pcat;
    vueapp.comboobj[i].ptype = r.ptype;
    vueapp.comboobj[i].pinv = r.pinv;
    vueapp.comboobj[i].pnum = r.pnum;
}

function updatecombo() {
    let pd = {};
    pd.pid = vueapp.combo.pid;
    pd.json = JSON.stringify(vueapp.comboobj);
    callServerMethod("updatecombo", pd).then((data) => {
        if (data.error) {
            talert(data.msg, "Error", () => {});
        } else {
            talert("Combo Updated", "Information", () => {
                t$("#ptbl").node.vue.fetchData();
            });
        }
    });
}
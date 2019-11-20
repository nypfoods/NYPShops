function approval_data() {
    return {
        apf: {},
        rdate: extract_date(new Date()),
        status: [''],
        papf: {}
    };
}

function addapproval(...arr) {
    vueapp.apf.id = uid();
    vueapp.apf.adate = vueapp.rdate;
    vueapp.apf.status = "REQ";
    let sql = Object.toSql(vueapp.apf, "approval");
    getData(sql).then((data) => {
        if (data.error == false) {
            talert("Added for approval", "Information...", () => {
                Object.empty(vueapp.apf, "");
                t$("#itbl").node.vue.fetchData();
                t$("#itbl").node.vue.reloadTbl();
            });
        } else {
            talert(data.msg, "Warning...!", () => {});
        }
    });
}

function update_apstatus(row) {
    let pd = {};
    pd["status"] = row.status;
    //pd["anote"] = anote;
    pd["id"] = row.id;
    pd["apdate"] = vueapp.rdate;
    callServerMethod("update_apstatus", pd).then((data) => {
        if (data.error == false) {
            t$("#atbl").node.vue.fetchData();
            t$("#stbl").node.vue.fetchData();
            t$("#itbl").node.vue.fetchData();
            t$("#aptbl").node.vue.fetchData();
            t$("#ctbl").node.vue.fetchData();
            t$("#rtbl").node.vue.fetchData();
        } else {
            talert("Something Went Wrong", "Warning...!", () => {});
        }
    });
}

function updatetobanker(row) {
    let urle = screen_url(`admin/manage/invoice&id=${row.id}&date=${vueapp.rdate}&template=true&invtype=itemrequest`);
    let pde = {};
    pde['url'] = urle;
    pde['sbj'] = "Item Request#" + row.id + " By " + window.location.hostname;
    pde['from'] = window.location.hostname;
    pde['email'] = 'ksanushakoti@gmail.com';
    pde['id'] = row.id;
    let parame = { parame: JSON.stringify(pde) }
    let $this = this;
    callServerMethod("emailurl", parame).then((data) => {
        t$("#stbl").node.vue.fetchData();
        talert("Sent mail to banker", "Information", () => {});
    });


}
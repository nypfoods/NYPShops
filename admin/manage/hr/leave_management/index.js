function leave_management_data() {
    return {
        apf: {},
        addevent: () => {},
        rdate: extract_date(new Date()),
        udtl: JSON.parse(`<?=json_encode($udtl);?>`),
    };
}

function leavetype(...arr) {
    vueapp.apf.id = uid();
    let sql = Object.toSql(vueapp.apf, "leave_type");
    getData(sql).then((data) => {
        if (data.error == false) {
            talert("Leave Type Added", "Information...", () => {
                Object.empty(vueapp.apf, "");
                t$("#ttbl").node.vue.fetchData();
            });
        } else {
            talert("Something went wrong", "Warning...!", () => {});
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
            t$("#rtbl").node.vue.fetchData();
            t$("#aptbl").node.vue.fetchData();
            t$("#atbl").node.vue.fetchData();
            t$("#ttbl").node.vue.fetchData();
            talert("Status changed", "Success...!", () => {});
        } else {
            talert("Something Went Wrong", "Warning...!", () => {});
        }
    });
}
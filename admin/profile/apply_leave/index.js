function apply_leave_data() {
    return {
        apf: {},
        addevent: () => {},
        rdate: extract_date(new Date()),
        udtl: JSON.parse(`<?=json_encode($udtl);?>`),
    };
}

function applyleave(...arr) {
    vueapp.apf.id = uid();
    vueapp.apf.adate = vueapp.rdate;
    vueapp.apf.uname = vueapp.udtl.uname;
    vueapp.apf.eid = vueapp.udtl.uid;
    vueapp.apf.fname = vueapp.udtl.fname;
    vueapp.apf.department = udtl.dept;
    let sql = Object.toSql(vueapp.apf, "employee_leave");
    getData(sql).then((data) => {
        if (data.error == false) {
            talert("Leave Applied.Wait for approval from HR", "Information...", () => {
                Object.empty(vueapp.apf, "");
                t$("#etbl").node.vue.fetchData();
            });
        } else {
            talert("Something went wrong", "Warning...!", () => {});
        }
    });
}
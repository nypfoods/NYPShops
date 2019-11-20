function job_board_data() {
    return {
        dcol: {
            department: "Department",
            designation: "Designation",
            skill: "Skill",
            title: "Title",
            description: "Description",
            status: "Active",

        },

        dessql: "",
        flds: { department: "", designation: "" },
        ldb: ldb

    };
}


function job_board_watch() {
    return {
        "flds.department": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from(select desname from designation as ds join department as d  where d.did=ds.did and dname='" + vueapp.flds.department + "') as designation";

            }
        },

    };
}

function addjob(...arr) {
    let pd = {};
    pd["department"] = vueapp.flds.department;
    pd["designation"] = vueapp.flds.designation;
    pd["title"] = vueapp.flds.title;
    pd["skill"] = vueapp.flds.skill;
    pd["description"] = vueapp.flds.description;
    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("addjob", param).then((data) => {
        if (data.error == false) {
            talert("Job Added", "Success...!", () => {});
            t$("#ptbl").node.vue.fetchData();
            Object.keys($this.flds).map(function(key) {
                if (['working_cash'].includes(key)) {
                    $this.flds[key] = "";
                }
            });
        } else {
            talert(data.msg, "Warning...!", () => {});
        }

    });
}
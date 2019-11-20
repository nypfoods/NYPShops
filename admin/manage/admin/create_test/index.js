function create_test_data() {
    return {
        apf: {},
        dessql: "",
        qst: [{}]
    };
}

function addtest(...arr) {
    let pd = {};
    pd["department"] = vueapp.apf.department;
    pd["designation"] = vueapp.apf.designation;
    pd["testdate"] = vueapp.apf.testdate;
    let param = JSON.stringify(pd)
    let question = vueapp.qst;
    let json = JSON.stringify(question);
    callServerMethod("addtest", { param: param, json: json }).then((data) => {
        if (data.error == false) {
            talert("Question Added", "Success...!", () => {});
            t$("#etbl").node.vue.fetchData();

        } else {
            talert(data.msg, "Warning...!", () => {});
        }

    });
}

function create_test_watch() {
    return {
        "apf.department": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from(select desname from designation as ds join department as d  where d.did=ds.did and dname='" + vueapp.apf.department + "') as designation";
            }
        },
    };
}

function checkRequired($func = () => {}) {
    let fg = 1;
    chknodes(t$("*:required"), function($node) {
        fg *= $node.value == "" ? 0 : 1;
    })
    if (fg == 0) {
        talert("Please fill required Feilds", "Warning...!", () => {});
    } else {
        $func();
    }
}
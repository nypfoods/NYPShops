function settings_data() {
    return {
        apf: {},
        ldb: ldb,
        udtl: JSON.parse(`<?=json_encode($udtl);?>`),

    };
}



function onimginvalid(img, df) {
    df();
}

function profile_created() {
    callServerMethod("getUserDetails").then((res) => {
        if (!res.error && res.data.length > 0) {
            let rdata = res.data[0];
            Object.keys(rdata).map(key => {
                rdata[key] = rdata[key] == "NULL" ? "" : rdata[key];
            });
            vueapp.apf = rdata;
        } else {
            talert(data.msg, "Error...", () => {});
        }
    });
}

function updateprofile() {
    let pd = {};
    pd["fname"] = vueapp.apf.efname;
    pd["lname"] = vueapp.apf.elname;
    pd["mnumber"] = vueapp.apf.mnumber;
    pd["address1"] = (vueapp.apf.address1 + "");
    pd["address2"] = (vueapp.apf.address2 + "");
    pd["eid"] = vueapp.apf.eid;
    pd["dob"] = vueapp.apf.dob;
    pd["gender"] = vueapp.apf.gender;

    let param = { param: JSON.stringify(pd) }
    let $this = this;
    callServerMethod("updateprofile", param).then((data) => {
        if (data.error == false) {
            talert("Profile Updated", "Success...", () => {});
        } else {
            talert(data, "Warning...!", () => {});
        }

    });

}
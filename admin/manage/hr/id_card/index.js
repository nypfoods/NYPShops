function id_card_data() {
    return {
        dessql: "",
        fsql: "",
        flds: { department: "", designation: "", fname: "" },
        idsql: "",
        ldb: ldb

    };
}

function getidcard() {
    if (vueapp != null) {
        let flds = vueapp.flds;
        return "" + `select * from (select e.uname,e.fname,e.lname,e.designation,e.eid from employee as e   where e.department like '${flds.department}%' and e.designation like '${flds.designation}%' and e.fname like '${flds.fname}%' and e.active='1') as emp`;
    } else {
        return "";
    }
}

function id_card_watch() {
    return {
        "flds.department": function(val) {
            if (vueapp) {
                vueapp.dessql = "select * from(select desname from designation as ds join department as d  where d.did=ds.did and dname='" + vueapp.flds.department + "') as designation";
            }
            vueapp.idsql = getidcard();
            vueapp.getf = false;
        },
        "flds.designation": function(val) {
            if (vueapp) {
                vueapp.fsql = "select * from employee as e where   designation='" + vueapp.flds.designation + "' and department='" + vueapp.flds.department + "'";
            }
            vueapp.getf = false;
            vueapp.idsql = getidcard();
        },
        "flds.fname": function(val) {
            vueapp.idsql = getidcard();
        },
    };
}
function employment_form_data() {
    return {
        frm: {
            pwl: [],
            fow: [],
            hai: [],
            pre: {},
            per: {},
            lang: [
                { speak: false, read: false },
                { speak: false, read: false },
                { speak: false, read: false },
                { speak: false, read: false },
                { speak: false, read: false }
            ],
            pasport: {},
            fbg: [{}],
            acadrec: [{}],

            projects: [{}],
            knowledge: {},
            workexp: [{}],
            salary: {
                otral: [{}],
                deduct: [{}],
            },
            haveny: {},
            knwny: [],
            strength: [],
            improvement: [],
            references: [{}],
            date: extract_date()
        }
    };
}

function submitform() {
    let frm = vueapp.frm;
    let json = JSON.stringify(frm);
    callServerMethod("submitform", { json: json }).then((d) => {
        if (d.error) {
            talert(d.msg, "Warning...!");
        } else {
            talert("Submition successfull", "Information");
            Object.empty(vueapp.frm, "");
            vueapp.frm = [{}];
            ObjectReset(vueapp.frm, "");
        }
    })
}

function ObjectReset(obj, res = "") {
    if (obj instanceof Array) {
        obj = obj.map((v, i) => {
            if (v instanceof Array) {
                return ObjectReset(v, res);
            } else if (v instanceof Object) {
                return ObjectReset(v, res);
            } else {
                return res;
            }
        });
        return obj;
    } else if (obj instanceof Object) {
        Object.keys(obj).map((k) => {
            v = obj[k];
            if (v instanceof Array) {
                ObjectReset(v, res);
            } else if (v instanceof Object) {
                ObjectReset(v, res);
            } else {
                obj[k] = res;
            }
        });
        obj = Object.clone(obj);
        return obj;
    }
}
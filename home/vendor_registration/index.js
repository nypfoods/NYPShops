myflds = [
    'name', 'adresss', 'telno', 'email', 'whatsppno', 'mobno', 'website', 'owners', 'nofbusiness',
    'nofcompany', 'yofesta', 'vinvetp', 'scompany', 'erno', 'gstdetails',
    'panno', 'office', 'pservices', 'financial', 'client', 'bank_name', 'bank_accno', 'ifsc',
    'rwus', 'gst_cert', 'pan_card', 'isi', 'fssai',
    'iso', 'aadhar', 'cancel_cheque', 'lastplace', 'ldate', 'signature'
];
ssid = $.cookie("PHPSESSID");
venreg = {};
if ($.cookie("vendor_registration")) {
    venreg = JSON.parse($.cookie("vendor_registration"));
    delete venreg.vid;
}

myfattr = {
    mobno: {
        type: 'mob'
    },
    email: {
        type: 'email'
    },
    telno: {
        type: 'mob'
    },
    whatsppno: {
        type: 'mob'
    },
    adresss: {
        type: 'textarea',
        style: "grid-column:1/-1;",

    },
    location: {
        style: "grid-column:1/-1;",

    },
    lastplace: {
        style: "grid-column:1/-1;",

    },
    gst_cert: {
        class: 'hd',
        type: "file",
        upload: `upload/vendor/onlineforms/temp/${ssid}/`,
        filename: "gst_certificate.png"

    },
    isi: {
        class: 'hd',
        type: "file",
        upload: `upload/vendor/onlineforms/temp/${ssid}/`,
        filename: "isi.png"
    },
    fssai: {
        class: 'hd',
        type: "file",
        upload: `upload/vendor/onlineforms/temp/${ssid}/`,
        filename: "fssai.png"
    },
    iso: {
        class: 'hd',
        type: "file",
        upload: `upload/vendor/onlineforms/temp/${ssid}/`,
        filename: "iso.png"
    },
    aadhar: {
        class: 'hd',
        type: "file",
        upload: `upload/vendor/onlineforms/temp/${ssid}/`,
        filename: "aadhar.png"
    },
    pan_card: {
        class: 'hd',
        type: "file",
        upload: `upload/vendor/onlineforms/temp/${ssid}/`,
        filename: "pan.png"
    },
    cancel_cheque: {
        class: 'hd',
        type: "file",
        upload: `upload/vendor/onlineforms/temp/${ssid}/`,
        filename: "cancel_cheque.jpg"
    },
    rwus: {
        style: "grid-column:1/-1;",

    },
    client: {
        style: "grid-column:1/-1;",

    },
    financial: {
        style: "grid-column:1/-1;",

    },
    pservices: {
        type: 'select',
        sql: "select * from cat",
        fcol: 'catname',
        style: "grid-column:1/-1;",

    },
    office: {
        style: "grid-column:1/-1;"
    },
    nofbusiness: {
        style: "grid-column:1/-1;",

    },
    nofcompany: {
        style: "grid-column:1/-1;",

    },
    owners: {
        style: "grid-column:1/-1;",
    },
    name: {
        style: "grid-column:1/-1;"
    },
    signature: {
        type: "label",
        style: "grid-column:2/-1;text-align:right"
    }
};


function vendor_registration_data() {
    return {
        srvchk:false,
        printf: false,
        offices: [{}],
        financial: [{}],
        client: [{}],
        ofnum: 0,
        oclient: 0,
        own: [{}],
        ofin: 1,
        ownum: 1,
        ssid: ssid,
        flds: Object.assign(myflds.toObject(), venreg, {
            ldate: extract_date(new Date()),
            pservices: []
        }),
        fdcol: Object.assign(myflds.toObject(" ")),
        fattrs: myflds.toObject((k) => {
            return Object.assign({
                name: 'inp-' + k,
                placehoder: "Enter"
            }, myfattr[k])
        }),
        perm: Object.assign(
            myflds.toObject(true), {
                nofbusiness: false,
                nofcompany: false,
                signature: false,
                owners: false,
                isother: false,
                office: false,
                financial: false,
                client: false,
                ldate: false,
                lastplace: false,
                pservices: false
            })
    };
}

function saveoffices(val) {
    vueapp.flds.office = JSON.stringify(val);
}

function saveowner(val) {
    vueapp.flds.owners = JSON.stringify(val);
}

function savefinancial(val) {
    vueapp.flds.financial = JSON.stringify(val);
}

function saveclient(val) {
    vueapp.flds.client = JSON.stringify(val);
}

function printform() {
    let vf = validate_form();
    if (vf) {
        saveclient(vueapp.client);
        savefinancial(vueapp.financial);
        saveowner(vueapp.own);
        saveoffices(vueapp.offices);
        vueapp.printf = true;
        vueapp.flds.vid = "VEN" + uid();
        let ot = t$("title").node.text;
        t$("title").node.text = vueapp.flds.vid;
        $.cookie("vendor_registration", JSON.stringify(vueapp.flds));
        window.print();
        t$("title").node.text = ot;
    }
}

function validate_form() {
    let mflds = Object.keys(Object.if(
        Object.filter(vueapp.flds, Object.keys(Object.if(vueapp.perm, (key, val) => {
            return val == false ? undefined : true;
        })).filter((val) => {
            let inc = ['gst_cert', 'pan_card', 'isi', 'fssai', 'iso', 'aadhar', 'cancel_cheque'];
            return inc.includes(val) ? false : true;
        })),
        (key, val) => {
            return val == "" ? val : undefined;
        }));
    let frminp = t$("form input").nodes.map((obj) => {
        return {
            inp: obj.node,
            vl: obj.node.checkValidity()
        };
    }).filter((v, i) => {
        return i != 25;
    });
    let vlinp = frminp.col('vl');
    let finp = frminp.col('inp');
    let midx = vlinp.indexOf(false);
    let vf = (mflds.length == 0) && vlinp.mul();
    let fnode = null;
    if (mflds.length > 0) {
        fnode = t$(`#inp-${mflds[0]} input`).node;
    } else if (midx != -1) {
        fnode = finp[midx];
    }
    if (!vf) {
        talert("Please fill missing fields", "Some Informations are missing", () => {
            if (fnode != null) {
                fnode.focus();
            }
        });
    }
    return vf;
}

async function regvendor() {
    let pd = vueapp.flds;
    if (!isset(pd.vid)) {
        pd.vid = "VEN" + uid();
    }
    pd.pservices = vueapp.flds.pservices.filter((v) => v != undefined).join();
    let sql = Object.toSql(vueapp.flds, "online_vendor");
    let res = await getData(sql);
    //await movefile(pd.vid);
    await callServerMethod("sendVendorDoc", {
        id: pd.vid,
        pname: pd.name,
        tel: pd.telno,
        adresss: pd.adresss,
        ssid: ssid,
        doc: "vendor_registration.pdf,gst_certificate.png,iso.png,isi.png,pan.png,aadhar.png,fssai.png,cancel_cheque.jpg"
    });
    if (res.error) {
        talert(res.msg, "Error...!", () => {});
    } else {
        talert("Vendor Registered", "Information...!", () => {});
        t$("#fregapl.dbinput .dbfile").node.vue.forceRemove();
        let nds = t$(".dbinput .dbfile").nodes;
        nds.map((file) => {
            file.node.vue.forceRemove();
        });
        Object.empty(vueapp.flds, "");
        vueapp.financial = [{}];
        vueapp.client = [{}];
        vueapp.own = [{}];
        vueapp.offices = [{}];
        $.removeCookie("vendor_registration");
        vueapp.flds.ldate = extract_date(new Date());
        vueapp.flds.vid = "VEN" + uid();
        vueapp.printf = false;
        t$("#venreg form").node.reset();
    }
}


async function movefile(vid) {
    let newfile = `upload/vendor/onlineforms/${vid}/vendor_registration.pdf`;
    let oldfile = `upload/vendor/onlineforms/temp/${ssid}/vendor_registration.pdf`;
    await callServerMethod("move", {
        oldfile: oldfile,
        newfile: newfile
    });
}
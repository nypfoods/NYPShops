function designation_data() {
    return {
        apf: {},
        onappemp: () => {},
    };
}

function adddesignation(...arr) {
    let $this = this;
    checkRequired(function() {
        $this.apf["desid"] = uid();
        $this.onappemp(this.findcol).then((data) => {
            if (typeof data == "string") { data = JSON.parse(data); }
            if (data.error == false) {
                talert("Designation Added", "Information...", () => {});

            } else {
                talert($this.msg, "Warning...!", () => {});
            }
        });
        Object.keys($this.apf).map(function(key) {
            if (['dname', 'desname', 'asalary', 'exp', 'mqualification'].includes(key)) {
                $this.apf[key] = "";
            }
        });
    });
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
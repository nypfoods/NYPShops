function backup_reader_data() {
    return {
        dbs: [],
        root: { name: "backup", mytree: [] },
        cmd: "",
        output: "",
        path: "",
        tbl: {
            fcol: []
        },
        exsql: "",
        mysql: "",
        mycol: [],
        tables: [],
        numcol: 6
    };
}

async function onpageloaded() {
    loadmytree(vueapp.root, "/");
    getData("SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'").then((res) => {
        vueapp.tables = res.data.col("Tables_in_sharemarketdb");
    });
};

function setMySql() {
    if (vueapp.mysql.toLowerCase().includes("select")) {
        vueapp.exsql = vueapp.mysql;
    } else {
        getData(vueapp.mysql).then((data) => {
            talert(JSON.stringify(data), "Information", () => {});
        });
    }

}

function setMyCol(data, col) {
    vueapp.mycol = col.filter((v, i) => { return i < vueapp.numcol; });
}

function backup_reader_watch() {
    return {
        numcol: function(val) {
            this.mycol = this.col.filter((v, i) => { return i < val; });
        }
    }
}

async function loadmytree(valobj, root, vue) {
    root = root.split("#").join("/");
    root = root.split("//").join("/");
    let path = root + "/" + valobj.name;
    path = path.split("//").join("/");
    if (!path.includes(".")) {
        let itms = await getListDir(path);
        if (itms instanceof Array) {
            valobj.mytree = itms.map((v) => {
                let obj = {};
                obj.name = v;
                obj.mytree = undefined;
                if (!v.includes(".")) {
                    obj.mytree = [];
                }
                return obj;
            }).filter((val) => {
                let v = val.name;
                if (!v.includes(".") || (v.includes(".") && v.includes(".json") && !v.includes("full.json"))) {
                    return val;
                }
            });
        }
    } else {
        getFile(path);
        vue.drop = -1;
    }
}

function feedData(tbl) {
    tbl.row = vueapp.tbl.data;
}

async function getFile(path) {
    vueapp.path = path;
    let res = await $get(get_url(path));
    res.fcol = res.col.filter((v, i) => i <= 5);
    vueapp.tbl = res;
}


function executeCmd() {
    let pd = { cmd: vueapp.cmd };
    pd.cmd = pd.cmd.split("`").join("'");
    let ic = tinfo("Executing cmd please wait....");
    callServerMethod("executeCmd", pd).then((data) => {
        if (typeof data == "string") {
            vueapp.output = data;
        } else {
            data = data.map((v) => '<br/>' + v);
            vueapp.output = JSON.stringify(data);
        }
        ic();
    });
}
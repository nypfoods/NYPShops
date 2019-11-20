<vue>#node</vue>
<div class="grid">
    <?php
    function fillarr($val) {
        global $udtl;
        switch ($udtl["tbl"]) {
            case "online_vendor":
            $screen = ["Apply Quotation"];
            return in_array($val["display"],$screen);
            default:
                return true;
        }
    }
    $gmenu = array_filter($gmenu,"fillarr");
    foreach ($gmenu as $k => $val) {
        $val["cicon"] = $val["cicon"]=="-"?"":$val["cicon"];
        $lf = strtoupper($val["display"])!="LOGOUT"&&$val["slg"]!="1";
        $lf = $lf&&strpos($val["name"],"admin")!==false;
        $lf = $lf&&$val["name"]!=$glb["mscrpath"];
        if($lf) {
    ?>
    <a href="<?=screen_url($val['name'])?>">
        <div class="card">
            <div class="icon">
                <i class="<?=$val['icon']?>">
                    <?=$val['cicon']?>
                </i>
            </div>
            <div class="text">
                <?=$val["display"]?>
            </div>
        </div>
    </a>
    <?php 
        }
    }
    ?>
    <?php if($udtl['tbl']=='online_franchise'){ ?>
    <a href="javascript:addimport()">
        <div class="card">
            <div class="icon">
                <i class="fa fa-download">
                </i>
            </div>
            <div class="text">
                Import Data
            </div>
        </div>
    </a>
    <?php } ?>
</div>
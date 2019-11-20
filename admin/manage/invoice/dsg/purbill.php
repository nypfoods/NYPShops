<?php
$dbname = $ldb->dbname;
$strdtl = array();
$tpres = $db->getDBData("select * from store where usname='$dbname'");
if(count($tpres["data"])<=0) {
    $strdtl["franchise_name"] = "New York Pizz.Co";
    $strdtl["business_location"] = "Demo Location";
} else {
    $strdtl = $tpres["data"][0];
}
$sql = "select * from purchase where ".
"ordid='{$_REQUEST['ordid']}' ";
$res = $ldb->getDBData($sql);
if(count($res["data"])>0) {
  
    $ddate=$res["data"][0]["ddate"];
    $odate = $res["data"][0]["odate"];
    $bilno = $res["data"][0]["bilno"];
    $vname = $res["data"][0]["vname"];
    $vmob = $res["data"][0]["vmob"];
    $vemail = $res["data"][0]["vemail"];
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        <?=$odate?> Bill :
        <?=$_REQUEST['ordid']?>
    </title>
    <style rel="stylesheet">
    nav {
        display: none !important;
    }

    #mainapp {
        margin-top: 40px !important;
    }

    body {
        background: white !important;
    }

    .invoice-box {
        background: white;
        margin: 0;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
        width: 4in;
        margin: auto;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:last-child {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }

    table tr.total td,
    table tr.heading td,
    table tr.item td {
        text-align: right;
    }

    table tr.total td:first-child,
    table tr.heading td:first-child,
    table tr.item td:first-child {
        text-align: left;
    }

    table tr.total td:last-child,
    table tr.heading td:last-child,
    table tr.item td:last-child {
        text-align: right;
    }

    .top table tr td:last-child,
    .information table tr td:last-child {
        text-align: right;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="7">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="<?=get_url('res/images/logo.png')?>" style="width: 100%;max-width: 85px;object-fit: contain;">
                            </td>
                            <td>
                                <div>Order #
                                    <?="<b>".$_REQUEST['ordid']."</b>" ?>
                                </div>
                                <div>Bill #
                                    <?="<b>".$bilno."</b>" ?>
                                </div>
                                <div>Date:
                                    <?= $ddate ?><br></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="1">
                    <h3>
                        <?=$strdtl["franchise_name"]?>
                    </h3>
                    <?=$strdtl["business_location"]?>
                </td>
                <td colspan="3">
                    <h3>
                        <?="<b>".$vname."</b>" ?>
                    </h3>
                    <?=$vmob?><br>
                    <?=$vemail?>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Particulars
                </td>
                <td>
                    Qty x price
                </td>
                <td>
                    Total
                </td>
            </tr>
            <?php
                $amt = 0;
                $gstamt = 0;
                for($i=0;$i<count($res["data"]);$i++) {
                    $itm =  $res["data"][$i];
                    $tamt = $itm["dqty"]*$itm["dprice"];
                   
                    $amt += $tamt;
                   
                    ?>
            <tr class="item">
                <td>
                    <div><b>
                            <?=$itm["pname"];?></b></div>
                    <div>
                        <?=" Size: ".$itm["psz"];?>|
                        <?=" Unit: ".$itm["punt"];?>
                    </div>
                    <?php if($itm["purdesc"]!="") { ?>
                    <div>
                        <?="Discription: ".$itm["purdesc"]?>
                    </div>
                    <?php } ?>
                </td>
                <td>
                    <?=$itm["dqty"];?> x
                    <?=$itm["dprice"];?>
                </td>
                <td>
                    <?=$tamt;?>
                </td>
            </tr>
            <?php } ?>
            <?php
                $grdtot=round($amt);
              
                ?>
            <tr class="total">
                <td colspan="1"></td>
                <td>
                    <h3>Total</h3>
                </td>
                <td>
                    <h3>
                        <?=toInr(round($grdtot))?>
                    </h3>
                </td>
            </tr>
            <tr class="heading">
                <td colspan="5" style="text-align:left">
                    <?= "Rupees ".ucwords(num2words($grdtot));?>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<?php } ?>
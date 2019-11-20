<?php
$dbname = $ldb->dbname;
$strdtl = array();
$tpres = $db->getDBData("select * from store where usname='$dbname'");
if(count($tpres["data"])<=0) {
    $strdtl["franchise_name"] = "New York Pizza.Co";
    $strdtl["business_location"] = "{$strdtl["franchise_name"]}";
} else {
    $strdtl = $tpres["data"][0];
}

$bilno = "";
$odate = "";
$ordid = $_REQUEST["ordid"];
$sql = "select * from `orders` where ".
"ordid='$ordid'";

$res = $ldb->getDBData($sql);


if(count($res["data"])>0) {
    $cpnid=$res["data"][0]["cpnid"];
    $cpnamt=$res["data"][0]["cpnamt"];
    $bchn=$res["data"][0]["bchn"];
    $bilno = $res["data"][0]["bilno"];
    $odate = $res["data"][0]["odate"];
    $cpndtl = $ldb->getDBData("select * from coupons where cpnid='$cpnid'");
    if(count($cpndtl['data'])>0) {
        $cpndtl = $cpndtl["data"][0];
    } else {
        $cpndtl = array();
        $cpndtl["cdicpf"] = 0;
        $cpnamt = 0;
    }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$odate?> Bill<?=$bchn."-".$bilno?></title>
    
    <style rel="stylesheet" >
        nav {
            display:none !important;
        }
        #mainapp {
            margin-top:40px !important;
        }
        body {
            background:white !important;
            display: grid;
        }
        .invoice-box {
            margin: 0;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            width: 80%;
            margin: auto;
            background-color: rgba(255,255,255,0.9);
            background-blend-mode: lighten;
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            background-image: url(<?=get_url("res/images/logo.png")?>);
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

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:last-child {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    /*
    @media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
    width: 100%;
    display: block;
    text-align: center;
    }
    
    .invoice-box table tr.information table td {
    width: 100%;
    display: block;
    text-align: center;
    }
    }
    */
    /** RTL **/
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
                    <td colspan="5">
                        <table>
                            <tr>
                                <td class="title">
                                    <img
                                    src="<?=get_url('res/images/logo.png')?>"
                                    style="width: 100%;max-width: 85px;object-fit: contain;">
                                </td>

                                <td>
                                    <div>Invoice # <?=$bchn."-<b>".$bilno."</b>" ?></div>
                                    <div>Date: <?=$odate ?><br></div>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="5">
                        <table>
                            <tr>
                                <td >
                                    <h3><?=$strdtl["franchise_name"]?></h3>
                                    <div><?=$strdtl["business_location"]?></div>
                                </td>

                                <td>
                                    <h3 class="mb-1"><?=$res["data"][0]["euname"]?></h3>
                                    <div><?=$res["data"][0]["mnumber"] ?></div>
                                    <div><?=$res["data"][0]["address1"] ?></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="heading">
                    <td>
                        Particulars
                    </td>
                    <td>
                        Qty
                    </td>
                    <td>
                        Rate
                    </td>
                
                    <td>
                        Amount
                    </td>
                </tr>

                <?php
                $amt = 0;
                $gstamt = 0;
                for($i=0;$i<count($res["data"]);$i++) {
                    $itm =  $res["data"][$i];
                    $tamt = $itm["pqty"]*$itm["posp"];
                    $pgst = $itm["pgst"];
                    $amt += $tamt;
                    $gstamt += $tamt*($pgst/100);
                    ?>
                    <tr class="item">
                        <td>
                            <div><b><?=$itm["pname"];?></b></div>
                            <div><?="C: ".$itm["pcat"]." T: ".$itm["ptype"]." S: ".$itm["psz"];?></div>
                            <?php if($itm["pdesc"]!="") { ?>
                                <div><?="Discription: ".$itm["pdesc"]?></div>
                            <?php } ?>
                        </td>
                        <td>
                            <?=$itm["pqty"];?>
                        </td>
                        <td>
                            <?=toInr($itm["posp"]);?>
                        </td>
                        
                        <td >
                             <?=toInr($tamt);?>
                        </td>
                    </tr>
                <?php } ?>

                <tr class="item">
                    <td colspan="2"></td>
                    <td>Sub Total</td>
                    <td  >
                         <?=toInr($amt);?>
                    </td>
                </tr>
                <?php if($cpnamt>0) { ?>
                    <tr class="item">
                        <td colspan="3"></td>
                        <td>
                            Discount
                            <?php if($cpndtl["cdicpf"]==1) { ?>
                                <span><?=$cpndtl["cdisv"]?> %</span>
                            <?php } ?>
                        </td>
                        <td  >
                            - <?=toInr($cpnamt)?>
                        </td>
                    </tr>
                <?php } ?>
                <?php
                $grdtot=round($amt-$cpnamt+$gstamt);
                $tgst = ($gstamt/$amt)*100;
                $cgst = round($tgst/2,2);
                $chkgstt = array(5,12,18,28);
                $sgstf = in_array($tgst,$chkgstt);
                $cgst = $sgstf?($cgst+" %"):"";
                ?>
                <tr class="item">
                    <td colspan="2"></td>
                    <td>
                        SGST
                        <?=$cgst?>
                    </td>
                    <td>+  <?=toInr(round($gstamt/2,2))?></td>
                </tr>
                <tr class="item">
                    <td colspan="2"></td>
                    <td>CGST
                        <?=$cgst?>
                    </td>
                    <td>+  <?=toInr(round($gstamt/2,2))?></td>
                </tr>
                <tr class="total">
                    <td colspan="2"></td>
                    <td><h3>Total</h3></td>
                    <td  >
                        <h3> <?=toInr(round($grdtot))?></h3>
                    </td>
                </tr>
                <tr class="heading">
                    <td colspan="4" style="text-align:left">
                        <?= ucwords(num2words($grdtot));?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
<?php } ?>
<?php
$dbname = $ldb->dbname;
$strdtl = array();
$tpres = $db->getDBData("select * from store where usname='$dbname'");
if(count($tpres["data"])<=0) {
$strdtl["franchise_name"] = "New York Pizz.Co";
$strdtl["business_location"] = "Banglore";
} else {
$strdtl = $tpres["data"][0];
}
$bilno = $_REQUEST["bilno"];
$odate = $_REQUEST["odate"];
$method = $_REQUEST["display"];
$itype = $_REQUEST["invtype"];
$sql = "select * from `vendor_quotation` where ".
"bilno='$bilno' and billdate='$odate'";
$res = $ldb->getDBData($sql);
if(count($res["data"])>0) {
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        <?=$_REQUEST["odate"]?> Bill
        <?=$_REQUEST["bilno"]?>
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
        padding: 15px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
        width: 4in;
        margin: auto !important;
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

    @media print {
        .invoice-box {
            margin: auto !important;
        }
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
                                <img src="<?=get_url('res/images/logo.png')?>" style="width: 100%;max-width: 85px;object-fit: contain;">
                            </td>
                            <td>
                                <div>Invoice #
                                    <?=$_REQUEST['bilno']."</b>" ?>
                                </div>
                                <div>Date:
                                    <?=$_REQUEST['odate'] ?><br></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="5">
                    <table>
                        <tr>
                            <td>
                                <h3>
                                    <?=$strdtl["franchise_name"]?>
                                </h3>
                                <div>
                                    <?=$strdtl["business_location"]?>
                                </div>
                            </td>
                            <td>
                                <h3 class="mb-1">
                                    <?=$res["data"][0]["vname"]?>
                                </h3>
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
                    Qty x Price + GST = Total
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
                    <div><b>
                            <?=$itm["pname"];?></b><br>
                    </div>
                </td>
                <td>
                    <?=$itm["pqty"];?> x
                    <?=$itm["posp"];?> +
                    <?=$itm["pgst"];?>
                    =
                   <?=$itm["pqty"] * $itm["posp"]+$itm["pgst"]?>                </td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="5" style="font-size: 10px">
                    This is computer generated invoice no signature required
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<?php } ?>
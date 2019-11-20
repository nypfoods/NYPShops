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
$sql = "select * from approval where ".
"id='{$_REQUEST['id']}' ";
$res = $ldb->getDBData($sql);
if(count($res["data"])>0) {
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$date?></title>
    
    <style rel="stylesheet" >
        nav {
            display:none !important;
        }
        #mainapp {
            margin-top:40px !important;
        }
        body {
            background:white !important;
        }
        .invoice-box {
            background:white;
            margin: 0;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
            width: 80%;
            margin-left: 150px;
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
                                    <img
                                    src="<?=get_url('res/images/logo.png')?>"
                                    style="width: 100%;max-width: 85px;object-fit: contain;">
                                </td>

                                <td>
                                    <div>Order # <?="<b>".$_REQUEST['id']."</b>" ?></div>
                                   
                                    <div>Date: <?= $_REQUEST['date'] ?><br></div>
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

                              
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="heading">
                    <td>
                      Item
                    </td>
                    <td>
                       Department
                    </td>
                    
                      <td>
                        Amount
                    </td>
                     <td>
                        Priority
                    </td>
                  
                </tr>

                 <?php
                $amt = 0;

                for($i=0;$i<count($res["data"]);$i++) {
                           $itm =  $res["data"][$i];
                   
                    
                    ?>
                    <tr class="item">
                        <td>
                            <?=$itm["item"];?>
                        </td>
                        <td>
                            <div><b><?=$itm["department"];?></b></div>
                            <?php if($itm["note"]!="") { ?>
                                <div><?="Item Note: ".$itm["note"]?></div>
                            <?php } ?>
                            <?php if($itm["anote"]!="") { ?>
                                <div><?="Admin Note: ".$itm["anote"]?></div>
                            <?php } ?>
                        </td>

                         <td>
                            <?=toInr($itm["amount"]);?>
                        </td>
                        <td>
                            <?=$itm["priority"];?>
                        </td>
                    </tr>
                <?php } ?>
               
            </table>
        </div>
    </body>
</html>
<?php } ?>
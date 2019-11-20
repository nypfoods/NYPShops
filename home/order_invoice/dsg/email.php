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
if(count($res['data'])>0) {
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
    </head>
    <body style=""  >
        <div class="invoice-box" style="max-width: 800px; margin: auto; padding: 30px;font-size: 16px; line-height: 24px; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; color: #555;display: grid;background:#f5f5f5cf;">
            <table cellpadding="0" cellspacing="0" style="width: 100%; line-height: inherit; text-align: left;" width="100%" align="left">
                <tr class="top">
                    <td colspan="5" style="padding: 5px; vertical-align: top;" valign="top">
                        <table style="width: 100%; line-height: inherit; text-align: left;" width="100%" align="left">
                            <tr>
                                <td class="title" style="padding: 5px; vertical-align: top; padding-bottom: 20px; font-size: 45px; line-height: 45px; color: #333;" valign="top">
                                    <img
                                   src="<?=get_url('res/images/logo.png')?>"
                                    style="width: 100%;max-width: 85px;object-fit: contain;">
                                </td>
                                
                                <td style="padding: 5px; vertical-align: top; text-align: right; padding-bottom: 20px;" valign="top" align="right">
                                    <div>Invoice # <?=$bchn."-<b>".$bilno."</b>" ?></div>
                                    <div>Date: <?=$odate ?><br></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                <tr class="information">
                    <td colspan="5" style="padding: 5px; vertical-align: top;" valign="top">
                        <table style="width: 100%; line-height: inherit; text-align: left;" width="100%" align="left">
                            <tr>
                                <td style="padding: 5px; vertical-align: top; padding-bottom: 40px;" valign="top">
                                    <h3><?=$strdtl["franchise_name"]?></h3>
                                    <div><?=$strdtl["business_location"]?></div>
                                </td>
                                
                                <td style="padding: 5px; vertical-align: top; text-align: right; padding-bottom: 40px;" valign="top" align="right">
                                    <h3 class="mb-1"><?=$res["data"][0]["euname"]?></h3>
                                    <div><?=$res["data"][0]['mnumber'] ?></div>
                                    <div><?=$res["data"][0]['address1'] ?></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="heading">
                    <td style="padding: 5px; vertical-align: top; background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;" valign="top">
                        Particulars
                    </td>
                    
                    <td style="padding: 5px; vertical-align: top; text-align: right; background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;" valign="top" align="right">
                        Qty
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;" valign="top" align="right">
                        Rate
                    </td>
                    
                    <td style="padding: 5px; vertical-align: top; text-align: right; background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;" valign="top" align="right">
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
                    <td style="padding: 5px; vertical-align: top; border-bottom: 1px solid #eee;" valign="top">
                        <div><?=$itm["pname"];?></div>
                        <div><?="C: ".$itm["pcat"]." T: ".$itm["ptype"]." S: ".$itm["psz"];?></div>
                        <?php if($itm["pdesc"]!="") { ?>
                        <div><?="Discription: ".$itm["pdesc"]?></div>
                        <?php } ?>
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        <?=$itm["pqty"];?>
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        <?=toInr($itm["posp"]);?>
                    </td>
              
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        <?=toInr($tamt);?>
                    </td>
                </tr>
                <?php } ?>
                <tr class="item">
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" colspan="2" ></td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        Sub Total
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        <?=toInr($amt);?>
                    </td>
                </tr>
                <?php if($cpnamt>0) { ?>
                <tr class="item">
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" colspan="2" ></td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        Discount
                        <?php if($cpndtl["cdicpf"]==1) { ?>
                        <span><?=$cpndtl["cdisv"]?> %</span>
                        <?php } ?>
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
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
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" colspan="2" ></td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        SGST
                        
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        + <?=toInr(round($gstamt/2,2))?>
                    </td>
                </tr>
                <tr class="item">
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" colspan="2" ></td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        CGST
                       
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        + <?=toInr(round($gstamt/2,2))?>
                    </td>

                </tr>
           
               <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" colspan="2" ></td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        Total
                        
                    </td>
                    <td style="padding: 5px; vertical-align: top; text-align: right; border-bottom: 1px solid #eee;" valign="top" align="right">
                        <?=toInr($grdtot);?>
                    </td>
                <tr class="heading">
                    <td colspan="5" style="padding: 5px; vertical-align: top; background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;" valign="top">
                        <?= "Rupees ".ucwords(num2words($grdtot));?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
<?php } ?>
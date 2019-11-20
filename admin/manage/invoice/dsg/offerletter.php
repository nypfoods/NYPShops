<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        Offer Letter
    </title>
    <style rel="stylesheet">
    h3 {
        align-content: center;
    }

    nav {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .lhla4 {
        background-image: url('<?=get_url("/res/images/LH-A4L.png")?>');
        background-size: 100% 100%;
    }

    #appreg .container {
        padding-top: 2.5in;
        padding-left: 1in;
        padding-right: 0.5in;
        text-align: justify;
    }
    </style>
</head>
<?php
$eid = $_REQUEST["eid"];
$hr= $_REQUEST["sent"];
    $sql = "select * from `online_employee` where "."oeid='$eid'";
$res = $ldb->getDBData($sql);
if(count($res["data"])>0) {
    $fname=$res["data"][0]["fname"];
    $lname=$res["data"][0]["lname"];
    $address=$res["data"][0]["address1"];
    $country=$res["data"][0]["country"];
    $state=$res["data"][0]["state"];
    $city=$res["data"][0]["city"];
    $department=$res["data"][0]["department"];
    $designation=$res["data"][0]["designation"];
    $location=$res["data"][0]["location"];
    $joindate=$res["data"][0]["joindate"];
    $full=$fname." ".$lname;

?>

<body>
    <div id="appreg" class="a4lw a4lh lhla4">
        <div class="container">
            <h3>
                <b> <span style="font-size: 14px;"> Date:
                        <?=date('Y-m-d')?></span></b>
            </h3>
            <b>To,</b><br>
            <p>
                <?=$address?><br>
                <?=$city?><br>
                <?=$state?><br>
                <?=$country?><br></p>
            <p>Dear Mr./Ms.
                <b>
                    <?=$full?>,</b><br>
                With reference to your application and subsequent interviews you had with us, we are pleased to offer you a position of <b>"
                    <?=$department." ".$designation?>"</b> on the following terms:-
                <ul>
                    <li> You will be stationed at
                        <b>
                            <u>
                                <?=ucwords($location)?></u></b> however company holds the right to transfer you to any location/ department (if needed).</li>
                    <li> You shall be willing to travel within India or abroad, if the organization feels the requirement.</li>
                    <li> Date of joining -
                        <b>
                            <u>
                                <?=$joindate?></u></b>.</li>
                    <li> Salary and perks - as per predefined structure (shall be communicated to you at the time of joining).</li>
                    <li>Detailed appointment letter outlining the employment terms and conditions will be issued to you after joining</li>
                </ul>
                We welcome you to the organization and look forward to a meaningful and long term association.<br>
                Cordially<br>
                <span style="margin-bottom: 50px">
                    <b>
                        <?=$hr ?>
                        <div style="height: 50px">
                            MANAGER - HR
                        </div>
                    </b>
                </span>
                <span style="font-size:10px;">This is system generated letter does not require signature<br></span>
                <div style="height: 50px">Note:- Kindly acknowledge the offer as your acceptance.</div>
                <footer style="position: relative;top:100px">NYP FOODS INDIA PVT LTD; A622 Bestech Business Square Sector 66, Mohali - 160071.
                    E-mail - info@new-yorkpizza.com; website - www.new-yorkpizza.com
                </footer>
        </div>
    </div>
</body>
<?php }

    ?>

</html>
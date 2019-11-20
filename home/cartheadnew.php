<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?=get_url('screen/home/products/css/reset.css')?>"> <!-- CSS reset -->
<!-- <link rel="stylesheet" href="<?=get_url('screen/home/products/css/style.css')?>"> -->
<!-- Gem style -->
<link rel="stylesheet" href="<?=get_url('global/owl/assets/owl.carousel.min.css')?>">
<link rel="stylesheet" href="<?=get_url('global/owl/assets/owl.theme.default.min.css')?>">
<script src="<?=get_url('screen/home/products/js/modernizr.js')?>"></script> <!-- Modernizr -->
<script src="<?=get_url('global/owl/owl.carousel.min.js')?>"></script>
<link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/header.css')?>"> <!-- CSS reset -->
<header>
    <a href="http://new-yorkpizza.com">
        <div id="logo"><img src="<?=get_url('res/images/logo.png')?>" alt="Homepage" style="width: 100px;"></div>
    </a>
    <div id="cd-hamburger-menu"><a class="cd-img-replace" href="#0">Menu</a></div>
    <?php if($_REQUEST["path"]=="/home/products") { ?>
    <div id="cd-cart-trigger">
        <a class="cd-img-replace" href="#0">
            <span class="w3-badge" id="cartcount"></span>
            <?=$_REQUEST["path"]?>
        </a>
    </div>
    <?php } ?>
</header>
<?php 
    function isActive($screen) {
        if($_REQUEST["path"]==$screen) {
            return "current";
        } else {
            return "";
        }
    }
?>
<nav id="main-nav">
    <ul>
        <li class="lihome">
            <?php $dbstr = "&db=".$dbname; ?>
            <?php $ldbstr = isset($_SESSION["db"])?"&db=".$_SESSION["db"]:null; ?>
            <a class="<?=isActive(" home")?>" href="
                <?=screen_url('/home',$dbstr)?>">Home</a>
        </li>
        <li class="liabout">
            <a class="<?=isActive(" home/about")?>" href="<?=screen_url('/home/about')?>">About us</a>
        </li>
        <!--      <li class="listorelist">
            <a class="<?=isActive("/home/employee_registration")?>" href="<?=screen_url('/home/employee_registration',$dbstr)?>">
                Career
            </a>
        </li> -->
        <li class="licontact">
            <a class="<?=isActive(" home/contact")?>" href="<?=screen_url('/home/contact')?>">Locate Us</a>
        </li>
       <!-- <?php if($_REQUEST["path"]!="home") { ?>
<li class="limenu">
    <a class="<?=isActive(" home/products")?>" href="<?=screen_url('/home/products',$ldbstr)?>">Menu</a>
</li>
<?php } ?> -->
        <?php 
            if(count($udtl)>0&&!isset($udtl['efname'])) {
                $url=screen_url('/logout');
                echo "<script>
                window.location='$url';
                </script>";
            }
        ?>
        <?php if(count($udtl)>0) { ?>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">
                <i class="fa fa-user" aria-hidden="true"></i> Welcome
                <?=strtoupper($udtl["efname"]);?>
            </a>
            <div class="dropdown-content">
                <a class="<?=isActive(" home/myprofile")?>" href="<?=screen_url('/home/myprofile',$dbstr)?>">
                    Profile
                </a>
                <a class="<?=isActive(" home/myorders")?>" href="<?=screen_url('/home/myorders',$dbstr)?>">
                    My Orders
                </a>
                <a class="<?=isActive(" home/change_pass")?>" href="<?=screen_url('/home/change_pass',$dbstr)?>">
                    Change Password
                </a>
                <a class="<?=isActive(" logout")?>" href="
                    <?=screen_url('/logout')?>">
                    Logout
                </a>
            </div>
        </li>
        <?php } else { ?>
        <li><a class="<?=isActive("/home/login")?>" href="<?=screen_url('/home/login',$dbstr)?>">Login</a></li>
        <?php } ?>
    </ul>
</nav>
<div id="loader">
    <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>
<?php 
function isActive($screen) {
    if($_REQUEST["path"]==$screen) {
        return "active";
    } else {
        return "";
    }
}

?>
<link rel="stylesheet" href="<?=get_url('screen/home/navbar.css')?>">
<div class="topnav" id="myTopnav">
    <a href="<?=screen_url('/home')?>" class="brand">
        <div id="logo">
            <img src="<?=get_url('res/images/logo.png')?>" alt="Homepage" style="width: 100px;">
        </div>
    </a>
    <a href="<?=screen_url('/home/login')?>" class="<?=isActive("/home/login")?>">Login </a> <a href="<?=screen_url('/home/contact')?>" class="<?=isActive("/home/contact")?>">Contact Us</a> <a href="<?=screen_url('/home/about')?>" class="<?=isActive("/home/about")?>">About Us</a> <a href="<?=screen_url('/home')?>" class="<?=isActive("/home")?>">Home </a> <a href="javascript:void(0);" class="icon" onclick="t$('#myTopnav').toggelClass('responsive')">
        <i class="fa fa-bars"></i>
    </a>
</div>
<div id="loader">
    <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>
<link rel="stylesheet" href="<?=get_url('global/owl/assets/owl.carousel.min.css')?>">
<link rel="stylesheet" href="<?=get_url('global/owl/assets/owl.theme.default.min.css')?>">
<script src="<?=get_url('global/owl/owl.carousel.min.js')?>"></script>
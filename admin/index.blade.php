<?php 
if(!isset($_SESSION["lgusr"])){
    $_SESSION["lgusr"] = "";
    $_SESSION["lgpwd"] = "";
}
?>
<div style="display: grid;height: calc(100% - 50px)">
    <div style="margin: auto;">
        <form action="<?=screen_url('/admin');?>" method="post" id="loginfrm" autocomplete="on">
            <div class="imgcontainer">
                <img src="<?=get_url('res/images/logo.png')?>" alt="Avatar" class="avatar">
            </div>
            <div class="container">
                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" value="<?=$_SESSION['lgusr']?>" required>
                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <input type="hidden" name="cmethod" value="adminlogin" />
                <button type="submit">Login</button>
                <div class="container" style="background-color:#f1f1f1;text-align: right;">
                    <span class="psw">Forgot <a href="#">password?</a></span>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
if($islogin) {
    echo "<script>window.location='$dashurl';</script>";
} else {
    // $crdkey = md5("credentials");
    // if(isset($_COOKIE[$crdkey])) {
    //  $tpsession = json_decode(base64_decode($_COOKIE[$crdkey]),true);
    //  $_SESSION = array_merge($_SESSION,$tpsession);
    //  echo "<script>window.location=window.location.href;</script>";
    // }
} ?>
<vue>#loginfrm</vue>
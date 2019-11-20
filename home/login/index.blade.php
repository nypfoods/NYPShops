<clearnav></clearnav>
<vue>#signup</vue>
<div class="foo">
    <?php include("screen/home/carthead.php"); ?>
    <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/bootstrap.min.css')?>">
    <script type="application/javascript" src="<?=get_url('screen/home/products/js/main.js')?>"></script>
    <div class="loginpage">
        <div class="login-wrap">
            <div class="login-html">
                <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
                <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
                <div class="login-form">
                    <div class="sign-in-htm">
                        <form action="" method="post">
                            <div class="group">
                                <label for="user" class="label">Username</label>
                                <input name="euname" id="user" v-model="apf.euname" type="text" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Password</label>
                                <input name="epwd" id="pass" v-model="apf.epwd" type="password" class="input" data-type="password" required>
                            </div>
                            <div class="group">
                                <input id="check" type="checkbox" class="check" checked>
                                <label for="check"><span class="icon"></span> Keep me Signed in</label>
                            </div>
                            <div class="group">
                                <button type="submit" name="cmethod" value="signin">Sign In</button>
                            </div>
                            <div class="hr"></div>
                            <div class="foot-lnk">
                                <a href="javascript:void(0)" onclick="forgetPass()">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                    <div class="sign-up-htm">
                        <form action="javascript:addsignup()" method="post" id="signup">
                            <div class="group">
                                <label for="user" class="label">First Name</label>
                                <input id="user" v-model="apf.efname" type="text" class="input" required>
                            </div>
                            <div class="group">
                                <label for="user" class="label">Last Name</label>
                                <input id="user" v-model="apf.elname" type="text" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Mobile Number</label>
                                <input id="user" v-model="apf.mnumber" type="number" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Email Address</label>
                                <input id="pass" v-model="apf.email" type="text" class="input" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Password</label>
                                <input id="pass" v-model="apf.epwd" type="password" class="input" data-type="password" required>
                            </div>
                            <div class="group">
                                <label for="pass" class="label">Repeat Password</label>
                                <input id="pass" v-model="apf.conpwd" type="password" class="input" data-type="password" required>
                            </div>
                            <div class="group">
                                <button type="submit">Sign Up</button>
                            </div>
                            <div class="hr"></div>
                            <div class="foot-lnk">
                                <label for="tab-1" style="color: white">Already Member?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="cd-shadow-layer"></div>
    <?php include('screen/home/footer.php'); ?>
</div>
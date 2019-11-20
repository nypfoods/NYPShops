<clearnav></clearnav>
<vue>#node</vue>
<div class="foo"  >
   <?php include("screen/home/cartheadnew.php"); ?>
      <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/bootstrap.min.css')?>">
   <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/line-icons.css')?>">
   <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/main.css')?>">
   <script type="application/javascript" src="<?=get_url('screen/home/products/js/main.js')?>"></script>
   <div class="loginpage">
      <div class="login-wrap">
         <div class="login-html">
            <h3>Change Password</h3>
            <div class="login-form">
               <div class="sign-in-htm">
                   <form action="javascript:change_password()" method="post" id="change" >
                  <div class="group">
                     <label for="cpass" class="label">Current Password *</label>
                     <input id="cpass" v-model="apf.oldpwd" type="password" class="input" data-type="password" required>
                  </div>
                   <div class="group">
                     <label for="pass" class="label">New Password *</label>
                     <input id="pass" v-model="apf.epwd" type="password" class="input" data-type="password" required>
                  </div>
                  <div class="group">
                     <label for="conpass" class="label">Confirm Password *</label>
                     <input id="conpass" v-model="apf.conpwd" type="password" class="input" data-type="password" required>
                  </div>
                  <div class="group">
                     <button type="submit">Update</button>
                  </div>
               </form>
               </div>
        
            </div>
         </div>
      </div>
   </div>
    <?php include("screen/home/footer.php"); ?>
</div>
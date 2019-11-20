<vue>#node</vue>
<div class="foo"  >
   <div class="loginpage">
      <div class="login-wrap">
         <div class="login-html">
           <h3 style="color: black;font-size: 10px">Change Password</h3>
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
</div>
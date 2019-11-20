<div class="row">
	<div class="col"></div>
	<div class="col-lg-8 col-sm-12">
		<div class="card">
		  <div class="row">
		  	<div class="col-lg-6 col-md-12 bg-login-image"></div>
		  	<div class="col-lg-6 col-md-12 lgform">
		  		<form autocomplete="off" method="post" class="column" action="<?=$rtf?>/admin/login">
					<b-form-group
					  label="Enter your username"
					  invalid-feedback="Enter Username"
					  :state="true"
					>
					  <b-form-input :state="true" name="uname" v-model="username" trim placeholder="Enter Username" />
					</b-form-group>
					<b-form-group
					  label="Enter your password"
					  invalid-feedback="Enter Password"
					  :state="true"
					>
					  <b-form-input :state="true" name="pwd" v-model="password" type="password" trim placeholder="Enter Password" />
					</b-form-group>
					<b-button type="submit" name="method" class="first-btn" value="login" block variant="primary">Let me in.</b-button>
			  	</form>
		  	</div>
		  </div>
		</div>
	</div>
	<div class="col"></div>
</div>
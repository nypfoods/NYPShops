<clearnav></clearnav>
<vue>#node</vue>
<div class="foo">
    <?php
	include('screen/home/carthead.php');
	?>
    <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/line-icons.css')?>">
    <link rel="stylesheet" href="<?=get_url('screen/home/assets/homecss/main.css')?>">
    <script type="application/javascript" src="<?=get_url('screen/home/products/js/main.js')?>"></script>
    <main id="cntfrm">
        <div class="contact-form-with-address">
            <div class="container" style="background: #fff !important">
                <h3>Profile</h3>
                <div class="row">
                    <div class="col-sm-3">
                        <!--left col-->
                        <div class="text-center">
                            <dbfile upload="upload/#{$dbname}/customer/#{$udtl['eid']}/" filename="profile.png" style="width:250px;height: 250px" name="imgpr" @onerror="(obj)=>{obj.src=get_url('res/images/demo.png')}"></dbfile>
                        </div>
                    </div>
                    <!--/col-3-->
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="home">
                                <form class="crtfrm row" action="javascript:updateprofile()" method="post">
                                    <dbinput type="label" label="Email" class="col-lg-6">
                                        {{apf.email}}
                                    </dbinput>
                                    <dbinput title="Ex. Mob 9XXXXXXXXXX" type="mob" class="col-lg-6" label="Mob " v-model="apf.mnumber" required placeholder="Ex. Mob 9XXXXXXXXXX">
                                    </dbinput>
                                    <dbinput type="name" v-model="apf.efname" label="First Name" class="col-lg-6" required>
                                    </dbinput>
                                    <dbinput type="name" v-model="apf.elname" label="Last Name" class="col-lg-6"></dbinput>
                                    <dbinput type="textarea" v-model="apf.address1" label="Address Details" class="col-lg-6" required>
                                    </dbinput>
                                    <dbinput type="textarea" v-model="apf.address2" label="Additional Address Information " class="col-lg-6">
                                    </dbinput>
                                    <dbinput type="select" label="Gender" v-model="apf.gender" :options="['Male','Female']" class="col-lg-6"></dbinput>
                                    <dbinput type="date" label="DOB" v-model="apf.dob" class="col-lg-6"></dbinput>
                                    <dbinput type="submit" class="update col-lg-6" label="">Update</dbinput>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
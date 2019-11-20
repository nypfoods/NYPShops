<clearnav></clearnav>
<vue>#cntfrm</vue>
<div class="foo">
    <?php
   include('screen/home/carthead.php');
   ?>
    <!-- CSS reset -->
    <link rel="stylesheet" href="<?=get_url('screen/home/contact/css/main.css')?>">
    <link rel="stylesheet" href="<?=get_url('screen/home/contact/css/util.css')?>">
    <script type="application/javascript" src="<?=get_url('screen/home/products/js/main.js')?>"></script>
    <main id="cntfrm">
        <div class="container-contact100">
            <div class="wrap-contact100">
                <form class="contact100-form validate-form" action="javascript:sendmail()">
                    <span class="contact100-form-title">
                        Other Enquiry
                    </span>
                    <label class="label-input100" for="first-name">Tell us your name *</label>
                    <div class="wrap-input100 rs1-wrap-input100 validate-input" data-validate="Type first name">
                        <input id="first-name" v-model="info.fname" class="input100" type="text" name="first-name" placeholder="First name" required>
                        <span class="focus-input100"></span>
                    </div>
                    <div class="wrap-input100 rs2-wrap-input100 validate-input" data-validate="Type last name">
                        <input class="input100" v-model="info.lname" type="text" name="last-name" placeholder="Last name">
                        <span class="focus-input100"></span>
                    </div>
                    <label class="label-input100" for="email">Enter your email *</label>
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input id="email" class="input100" v-model="info.email" type="text" name="email" placeholder="Eg. example@email.com" required>
                        <span class="focus-input100"></span>
                    </div>
                    <label class="label-input100" for="phone">Enter phone number *</label>
                    <div class="wrap-input100">
                        <input id="phone" class="input100" v-model="info.mob" type="text" name="phone" placeholder="Eg. +1 (919) 592-6444" required>
                        <span class="focus-input100"></span>
                    </div>
                    <label class="label-input100" for="message">Message *</label>
                    <div class="wrap-input100 validate-input" data-validate="Message is required">
                        <textarea id="message" class="input100" v-model="info.message" name="message" placeholder="Write us a message" required></textarea>
                        <span class="focus-input100"></span>
                    </div>
                    <div class="container-contact100-form-btn">
                        <button class="contact100-form-btn">
                            Send Message
                        </button>
                    </div>
                </form>
                <div class="contact100-more flex-col-c-m" style="background-image: url('http://online.new-yorkpizza.com/images/about.jpg');">
                    <div class="flex-w size1 p-b-47">
                        <div class="txt1 p-r-25">
                            <span class="lnr lnr-map-marker"></span>
                        </div>
                        <div class="flex-col size2">
                            <h2 style="font-weight: bold;">Contact us for</h2>
                            <hr />
                            <div class="links grid" style="width: 100%">
                                <a href="<?=screen_url('/home/franchise_registration')?>">Master Franchise / Franchise</a>
                                <a href="<?=screen_url('/home/vendor_registration')?>">Vendor</a>
                                <a href="<?=screen_url('/home/employee_registration')?>">Career</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex-w size1 p-b-47">
                        <div class="txt1 p-r-25">
                            <span class="lnr lnr-map-marker"></span>
                        </div>
                        <div class="flex-col size2">
                            <h2 style="font-weight: bold;">Corporate Office</h2>
                            <hr />
                            <span class="txt2">
                                <i class="fa fa-address-card" aria-hidden="true"></i> 575 Madison Ave, New York, NY 10022, USA
                            </span>
                        </div>
                    </div>
                    <div class="dis-flex size1 p-b-47">
                        <div class="txt1 p-r-25">
                            <span class="lnr lnr-phone-handset"></span>
                        </div>
                        <div class="flex-col size2">
                            <h2 style="font-weight: bold;">Lets Talk</h2>
                            <hr />
                            <span class="txt2">
                                <i class="fa fa-phone" aria-hidden="true"></i> +1 (919) 592-6444
                            </span>
                        </div>
                    </div>
                    <div class="dis-flex size1 p-b-47">
                        <div class="txt1 p-r-25">
                            <span class="lnr lnr-envelope"></span>
                        </div>
                        <div class="flex-col size2">
                            <span class="txt1">
                                General Support
                            </span>
                            <hr />
                            <span class="txt2">
                                <i class="fa fa-envelope" aria-hidden="true"></i> contact@new-yorkpizza.com
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.011584334975!2d-73.97454928509386!3d40.761769942507186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c258fac19c5333%3A0xceac8f1eda9acef3!2s575+Madison+Ave+%231006%2C+New+York%2C+NY+10022%2C+USA!5e0!3m2!1sen!2sin!4v1544374556181" width="100%" height="462" frameborder="0" allowfullscreen=""></iframe>
        </div>
    </main>
    <div id="cd-shadow-layer"></div>
    <?php 
      include('screen/home/footer.php'); 
    ?>
</div>
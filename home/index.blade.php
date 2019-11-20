<clearnav></clearnav>
<vue>.vuerun</vue>
<div class="getlocation vuerun" style="display: none;">
    <gmaps name="mapcon" id="cgmapid" style="width: 100?;height: 500px" @input="(...ar)=>{curAddrObj=ar;}">
        <button v-if="curAddrObj.length>0" class="gpsconfirm" @click="closegps()">Proceed</button>
    </gmaps>
</div>
<div class="foo cartpage">
    <?php include('screen/home/carthead.php'); ?>
    <section class="home-slider owl-carousel img vuerun">
        <div v-for="i in 7" :class="`slider-item item${i}`">
            <div class="overlay"></div>
            <div class="overlay triangle "></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">
                </div>
            </div>
        </div>
    </section>
    <div class="over-text">
        <div>
            <h1 class="mb-4" style="font-size: calc((100vh + 100vw)/(100 / 3));font-weight: bold;">We are coming to
                <span class="india">
                    <span class="orange-f">IN</span><span class="white-f">D</span><span class="green-f">IA</span>
                </span>
                soon....
            </h1>
            <div class="frnch hide">
                Franchisee Opportunity
                <span class="ath">
                    Authentic New-York Style Pizza
                </span>
            </div>
            <div class="center hide">
                <button onclick="opengps()" class="ordnow fitw">Order Now</button>
            </div>
        </div>
    </div>
</div>
<div>
    <?php include('screen/home/footer.php'); ?>
</div>
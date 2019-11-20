function carousel() {
    window.owl = $('.home-slider').owlCarousel({
        loop: true,
        autoplay: true,
        margin: 0,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav: true,
        autoplayHoverPause: true,
        items: 1,
        navText: ["<span class='snavcon left'><i class='fa fa-angle-left'></i></span>",
            "<span class='snavcon right'><i class='fa fa-angle-right'></i></span>"
        ],
    });
    t$(".home-slider").prepend(t$(".over-text"));
    owl.on('changed.owl.carousel', function(event) {
        let i = event.item.index + 1;
        let node = t$(`.owl-item:nth-child(${i}) .overlay.triangle`);
        sleep(500).then(() => {
            node.animateCSS("slideInLeft");
        });
    });
}

function onpageloaded() {
    carousel();
}

function home_data() {
    return {
        curAddrObj: []
    }
}

function closegps() {
    let ic = tinfo("Fetching store please wait...");
    let pd = { param: JSON.stringify(this.curAddrObj) };
    callServerMethod("getStore", pd).then(function(data) {
        ic();
        if (data.error) {
            talert("Sorry no store found near to your location", "Apolagize...!", () => {});
        } else {
            ldb = data.db;
            window.location = screen_url("home/products");
        }
        closepopup();
    });
}

function closepopup() {
    t$(".getlocation").css("display", "none");
}

function opengps() {
    t$(".getlocation").css("display", "block");
    mapcon.vue.currentplace = "Banglore";
    t$(".getlocation").on("click", function(e) {
        if (e.target === this) {
            closepopup();
        }
    });
    onmapselect();
}

function onmapselect() {
    setTimeout(function() {
        $("#mapcon ul li")[0].click();
    }, 500);
}
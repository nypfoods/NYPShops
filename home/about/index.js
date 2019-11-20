function carousel() {
    $('#gallery').owlCarousel({
        loop: true,
        autoplay: true,
        margin: 0,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        nav: true,
        autoplayHoverPause: false,
        items: 4,
        navText: ["<span class='snavcon left'><i class='fa fa-angle-left'></i></span>",
            "<span class='snavcon right'><i class='fa fa-angle-right'></i></span>"
        ],
    });
}

t$("#node").on("winload", () => {
    carousel();
    $('#gallery .gallery-item img').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });
});

function about_data() {
    return {

    }
}
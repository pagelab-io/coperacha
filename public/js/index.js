(function () {

    // Init sliders
    $('#SliderMethods').slider({
        slideSpeed: 500,
        play: 000,
        preload: true,
        withPagination: false,
        withNavigation: false
    });

    $('#SliderTestimonials').slider({
        slideSpeed: 500,
        play: 10000,
        preload: true,
        classNavigation: 'inverse',
        qty: 3
    });

    // Share implementation
    var share = new Share();
    share.setup({
        networks: {
            facebook: {
                load_sdk: true,
                app_id: "1581295808831173",
                title: 'Coperacha',
                image: $('meta[itemprop="image"]').attr('content'),
                description: $('meta[name="description"]').attr('content'),
                url: location.toString() ,
                caption: 'Coperacha'
            }
        }
    });

    $('#btnShareFb').on("click", function (evt) {
        evt.preventDefault();
        share.network_facebook();
    });

})();
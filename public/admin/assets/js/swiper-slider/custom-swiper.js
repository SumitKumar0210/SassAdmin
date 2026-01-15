(function ($) {
    "use strict";
    var swiper = new Swiper(".mySwiper", {
        effect: "cards",
        grabCursor: true,
        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
        },
    });
})(jQuery);
(function ($) {
    'use strict';
    jQuery(document).ready(function () {
        $(window).load(function () {
            $(".typing").typed({
                strings: ["How to use ?"],
                typeSpeed: 50
            });
        });
    });
})(jQuery);
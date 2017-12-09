(function (a) {
    a.fn.tmStickUp = function (r) {
        var m = {
            corectionValue: 0
        };
        a.extend(m, r);
        var h = a(this),
                c = a(window),
                n = a(document),
                g = 0,
                d = 0,
                e = 0,
                p = 0,
                b, k = 0,
                l = "",
                o, i = 0,
                j = 0;
        q();

        function q() {
            parentContainer = h.parent();
            g = parseInt(h.offset().top);
            e = parseInt(h.css("margin-top"));
            d = parseInt(h.outerHeight(true));
            i = parseInt(a(".container").width());
            a('<div class="pseudoStickyBlock"></div>').insertAfter(h);
            b = a(".pseudoStickyBlock");
            b.css({
                position: "relative",
                display: "block"
            });
            h.on("rePosition", function (s, t) {
                j = t;
                n.trigger("scroll")
            });
            f()
        }

        function f() {
            n.on("scroll", function () {
                o = a(this).scrollTop();
                if (o > k) {
                    l = "down"
                } else {
                    l = "up"
                }
                k = o;
                p = parseInt(n.scrollTop());
                if (g - e < p) {
                    h.addClass("isStuck");
                    h.css({
                        position: "fixed",
                        top: j,
                        zIndex: 999,
                        left: 0,
                        right: 0,
                        margin: "0 auto"
                    });
                    b.css({
                        height: d
                    })
                } else {
                    h.removeClass("isStuck");
                    h.css({
                        position: "relative",
                        top: 0
                    });
                    b.css({
                        height: 0
                    })
                }
            }).trigger("scroll")
        }
    }
})(jQuery);
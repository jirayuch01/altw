$(function () {
    var d = document.querySelector && document.querySelector('meta[name="viewport"]'),
            c = navigator.userAgent,
            b = function () {
                d.content = "width=device-width, minimum-scale=0.25, maximum-scale=1.6"
            },
            f = function () {
                if (d && /iPhone|iPad/.test(c) && !/Opera Mini/.test(c)) {
                    d.content = "width=device-width, minimum-scale=1.0, maximum-scale=1.0";
                    document.addEventListener("gesturestart", b, false)
                }
            };
    f();
    if (window.orientation != undefined) {
        var e = /ipod|ipad|iphone/gi,
                a = c.match(e);
        if (!a) {
            $(".sf-menu li").each(function () {
                if ($(">ul", this)[0]) {
                    $(">a", this).toggle(function () {
                        return false
                    }, function () {
                        window.location.href = $(this).attr("href")
                    })
                }
            })
        }
    }
});
var ua = navigator.userAgent.toLocaleLowerCase(),
        regV = /ipod|ipad|iphone/gi,
        result = ua.match(regV),
        userScale = "";
if (!result) {
    userScale = ",user-scalable=0"
}
document.write('<meta name="viewport" content="width=device-width,initial-scale=1.0' + userScale + '">');
var currentYear = (new Date).getFullYear();
$(document).ready(function () {
    $("#copyright-year").text((new Date).getFullYear())
});
$(function () {
    $(".sf-menu").superfish({
        autoArrows: true
    })
});

function include(a) {
    document.write('<script type="text/javascript" src="' + a + '"><\/script>')
}
include("assets/js/device.js");
include("assets/js/jquery.mousewheel.js");
include("assets/js/jquery.simplr.smoothscroll.js");
$(function () {
    if ($("html").hasClass("desktop")) {
        $.srSmoothscroll()
    }
});
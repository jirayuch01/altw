$(function () {
    $('.button').click(function () {
        var value = $(this).attr('scrollValue');
        $('#view').animate({scrollLeft: value});
    });
});

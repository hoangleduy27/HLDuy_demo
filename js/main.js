setTimeout(function() {
    $(".preload-bg").fadeToggle();
}, 1500);

$(window).scroll(function() {
    if ($(window).width() >= 740) {
        $(".navbar-wrap").toggleClass("navbar--scroll-1", $(this).scrollTop() > 100);
    }
});

$(window).resize(function() {
    if ($(window).width() < 740) {
        $(".navbar-wrap").addClass("navbar--scroll-1");
    } else {
        $(".navbar-wrap").removeClass("navbar--scroll-1");
        $(".mobile-menu").hide();
    }
});

if ($(window).width() < 740) {
    $(".navbar-wrap").addClass("navbar--scroll-1");
}

$(".bar-icon").on("click", function() {
    $(this).toggleClass("change");
    $(".mobile-menu").slideToggle();
});
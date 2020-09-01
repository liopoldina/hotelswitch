$(function() {
    //carrousels
    $(".destinations").slick({
        slidesToShow: 4,
        arrows: true,
        swipe: false,
        infinite: false,
        accessibility: false
    });
    $(".hotels").slick({
        slidesToShow: 3,
        arrows: true,
        swipe: false,
        infinite: false,
        accessibility: false
    });
});

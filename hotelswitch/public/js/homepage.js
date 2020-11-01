$(function() {
    //carrousels
    $(".destinations").slick({
        slidesToShow: 4,
        arrows: true,
        swipe: false,
        infinite: false,
        accessibility: false,
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    slidesToShow: 3,
                    arrows: false,
                    swipe: true,
                    dots: true
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                    swipe: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    swipe: true,
                    dots: true
                }
            }
        ]
    });
    $(".hotels").slick({
        slidesToShow: 3,
        arrows: true,
        swipe: false,
        infinite: false,
        accessibility: false,
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    slidesToShow: 3,
                    arrows: false,
                    swipe: true,
                    dots: true
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    arrows: false,
                    swipe: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    swipe: true,
                    dots: true
                }
            }
        ]
    });
});

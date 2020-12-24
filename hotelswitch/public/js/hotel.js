$(function() {
    // 1) Slideshow left and right
    h.image_index = 0;

    $("#slide").attr("src", h.images[0]);

    $(".min_slide")
        .first()
        .addClass("min_slide_selected");

    $(".arrow_left", this).click(function() {
        slide("left");
    });
    $(".arrow_right", this).click(function() {
        slide("right");
    });

    //mobile Swipe
    var slideshow = document.getElementById("slideshow");
    var hammertime = new Hammer(slideshow);

    hammertime.on("swiperight", function() {
        slide("left");
    });

    hammertime.on("swipeleft", function() {
        slide("right");
    });

    function slide(direction) {
        if (direction == "left") {
            h.image_index--;
        }
        if (direction == "right") {
            h.image_index++;
        }
        if (h.image_index >= h.images.length) {
            h.image_index = 0;
        }
        if (h.image_index < 0) {
            h.image_index = h.images.length - 1;
        }
        $(".min_slide").removeClass("min_slide_selected");
        $(".slide_img[index=" + h.image_index + "]")
            .parent()
            .addClass("min_slide_selected");
        $("#slide").attr("src", h.images[h.image_index]);
    }

    // 2) Slideshow index
    $(".slide_img", this).click(function() {
        $(".min_slide").removeClass("min_slide_selected");
        $(this)
            .parent()
            .addClass("min_slide_selected");
        $("#slide").attr("src", $(this).attr("main"));
        h.image_index = parseInt($(this).attr("index"));
    });

    // 3) Change Search
    //open update
    $(".dates_boxes, .guests_box, .update_wrapper").click(function() {
        $("#update_overlay").addClass("display_update_overlay");
        $("body").css("overflow", "hidden"); //disable scroll
    });
    //close update
    $(".update_close").click(function() {
        $("#update_overlay").removeClass("display_update_overlay");
        $("body").css("overflow", "auto"); //enable scroll
    });
    //close update on clicked outside (on overlay)
    $(document).mousedown(function(e) {
        if ($("#update_overlay").hasClass("display_update_overlay")) {
            var overlay = $(".update_overlay");
            if (overlay.is(e.target)) {
                $("#update_overlay").removeClass("display_update_overlay");
                $("body").css("overflow", "auto"); //enable scroll
            }
        }
    });

    // show hide guests_selection
    $(document).click(function(e) {
        if (
            ($(".guests_wrapper_update").is(e.target) ||
                !$(".guests_wrapper_update").has(e.target).length == 0) &&
            $(".guests_selection_update").css("display") == "none"
        ) {
            $(".guests_selection_update").css("display", "flex");
            $(".guests_wrapper_update").css(
                "outline",
                "-webkit-focus-ring-color auto 1px"
            );
        } else if (
            !$(".guests_selection_update").is(e.target) &&
            $(".guests_selection_update").has(e.target).length == 0
        ) {
            $(".guests_selection_update").css("display", "none");
            $(".guests_wrapper_update").css("outline", "none");
        }
    });

    // date_range_picker update
    // get today date
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, "0");
    var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + "/" + dd + "/" + yyyy;

    // date_range_picker

    if ($("#update_range").val() == "") {
        $("#update_range")
            .daterangepicker({
                autoApply: true,
                minDate: today,
                maxDate: "12/31/2021",
                endDate: moment().add(1, "days"),
                maxSpan: {
                    days: 27
                },
                locale: {
                    // format: "DD/MM/YY",
                }
            })
            .data("daterangepicker")
            .container.addClass("daterangepicker_update");
    } else {
        $("#update_range")
            .daterangepicker({
                autoApply: true,
                minDate: today,
                maxDate: "12/31/2021",
                maxSpan: {
                    days: 27
                },
                locale: {
                    // format: "DD/MM/YY",
                }
            })
            .data("daterangepicker")
            .container.addClass("daterangepicker_update");
    }
});

$(function() {
    // 1) Slideshow left and right
    h.image_index = 0;

    $("#slide").attr("src", h.images[0]);

    $(".arrow_right ", this).click(function() {
        if (h.image_index == h.images.length - 1) {
            h.image_index = 0;
        } else {
            h.image_index++;
        }
        $(".min_slide").removeClass("min_slide_selected");
        $(".slide_img[index=" + h.image_index + "]")
            .parent()
            .addClass("min_slide_selected");
        $("#slide").attr("src", h.images[h.image_index]);
    });

    $(".arrow_left", this).click(function() {
        if (h.image_index == 0) {
            h.image_index = h.images.length - 1;
        } else {
            h.image_index--;
        }
        $(".min_slide").removeClass("min_slide_selected");
        $(".slide_img[index=" + h.image_index + "]")
            .parent()
            .addClass("min_slide_selected");
        $("#slide").attr("src", h.images[h.image_index]);
    });

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
    //open map
    $(".dates_wrapper, .guests_wrapper, .update_wrapper").click(function() {
        $("#update_overlay").addClass("display_update_overlay");
        $("body").css("overflow", "hidden"); //disable scroll
    });
    //close map on cross
    $(".update_close").click(function() {
        $("#update_overlay").removeClass("display_update_overlay");
        $("body").css("overflow", "auto"); //enable scroll
    });
    //close map on clicked outside (on overlay)
    $(document).mousedown(function(e) {
        if ($("#update_overlay").hasClass("display_update_overlay")) {
            var overlay = $(".update_overlay");
            if (overlay.is(e.target)) {
                $("#update_overlay").removeClass("display_update_overlay");
                $("body").css("overflow", "auto"); //enable scroll
            }
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
        $("#update_range").daterangepicker({
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
        });
    } else {
        $("#update_range").daterangepicker({
            autoApply: true,
            minDate: today,
            maxDate: "12/31/2021",
            maxSpan: {
                days: 27
            },
            locale: {
                // format: "DD/MM/YY",
            }
        });
    }
});

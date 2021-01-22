$(function() {
    // 1) show hide if click outside
    // user menu
    $(document).click(function(e) {
        if (
            ($(".account_dropdown").is(e.target) ||
                !$(".account_dropdown").has(e.target).length == 0) &&
            $(".dropdown_menu").css("display") == "none"
        ) {
            $(".dropdown_menu").css("display", "block");
        } else if (
            !$(".dropdown_menu").is(e.target) &&
            $(".dropdown_menu").has(e.target).length == 0
        ) {
            $(".dropdown_menu").css("display", "none");
        }
    });

    // guests_selection
    $(document).click(function(e) {
        if (
            ($(".guests_wrapper").is(e.target) ||
                !$(".guests_wrapper").has(e.target).length == 0) &&
            $(".guests_selection").css("display") == "none"
        ) {
            $(".guests_selection").css("display", "flex");
            $(".guests_wrapper").css(
                "outline",
                "-webkit-focus-ring-color auto 1px"
            );
        } else if (
            !$(".guests_selection").is(e.target) &&
            $(".guests_selection").has(e.target).length == 0
        ) {
            $(".guests_selection").css("display", "none");
            $(".guests_wrapper").css("outline", "none");
        }
    });

    // 2) guests selection

    $(".item_selection i").click(function() {
        number =
            parseInt(
                $(this)
                    .siblings("input")
                    .val()
            ) + parseInt($(this).data("value"));

        // min max
        min = $(this)
            .siblings("input")
            .attr("min");
        max = $(this)
            .siblings("input")
            .attr("max");
        if (number > max) {
            number = max;
        }
        if (number < min) {
            number = min;
        }

        // singular or plural
        if (number == 1) {
            number_text = $(this)
                .siblings("input")
                .data("singular");
        } else {
            number_text = $(this)
                .siblings("input")
                .data("plural");
        }
        $(this)
            .siblings("div")
            .children(".item_type")
            .text(number_text);

        // change input value
        $(this)
            .siblings("input")
            .val(number);

        // change individual box text
        $(this)
            .siblings("div")
            .children(".item_number")
            .text(number);

        // change total box text
        total_text =
            $(this)
                .parent()
                .parent()
                .find(".item_number")
                .eq(0)
                .text() +
            " " +
            $(this)
                .parent()
                .parent()
                .find(".item_type")
                .eq(0)
                .text() +
            ", " +
            $(this)
                .parent()
                .parent()
                .find(".item_number")
                .eq(1)
                .text() +
            " " +
            $(this)
                .parent()
                .parent()
                .find(".item_type")
                .eq(1)
                .text();
        if ($("#children").val() > 0) {
            total_text =
                total_text +
                ", " +
                $(this)
                    .parent()
                    .parent()
                    .find(".item_number")
                    .eq(2)
                    .text() +
                " " +
                $(this)
                    .parent()
                    .parent()
                    .find(".item_type")
                    .eq(2)
                    .text();
        }

        $(this)
            .parent()
            .parent()
            .siblings(".box_content")
            .text(total_text);
    });

    // 3) destination autocomplete
    $("#destination")
        .autocomplete(
            {
                select: function(event, ui) {
                    event.preventDefault();
                    $("#destination").val(ui.item.label); // display the label
                    $("#place_id").val(ui.item.place_id);
                    $("#lat").val(ui.item.coords.lat);
                    $("#lon").val(ui.item.coords.lon);
                    $(event.target).autocomplete("close");
                    setTimeout(function() {
                        $(event.target).blur();
                    });
                },
                source: function(request, cb) {
                    $.ajax({
                        url: "autocomplete",
                        method: "GET",
                        dataType: "json",
                        data: {
                            name: request.term,
                            session: $("#autocomplete_session").val()
                        },
                        success: function(res) {
                            cb(res);
                        }
                    });
                }
            },
            {
                //autocomplete options
                autoFocus: true,
                // delay: 200,
                minLength: 3
            }
        )
        .bind("focus", function() {
            //make autocomplete open on click
            $(this).autocomplete("search");
        });

    // 4) date_range_picker
    // get today date
    var date_format = "DD MMM YYYY";

    var today = new Date();
    var DD = String(today.getDate()).padStart(2, "0");
    var MMM = today.toLocaleString("default", { month: "short" });
    var YYYY = today.getFullYear();
    today = DD + " " + MMM + " " + YYYY;

    // date_range_picker
    if ($("#date_range").val() == "") {
        // case homepage
        $("#date_range").daterangepicker({
            autoApply: true,
            minDate: today,
            maxDate: "31 Dec 2022",
            endDate: moment().add(1, "days"),
            maxSpan: {
                days: 27
            },
            locale: {
                format: date_format
            }
        });
    } else {
        // case search and hotel page
        $("#date_range").daterangepicker(
            {
                autoApply: true,
                minDate: today,
                maxDate: "31 Dec 2022",
                maxSpan: {
                    days: 27
                },
                locale: {
                    format: date_format
                }
            },

            //change displays nights under range picket
            function(start, end, label) {
                nr_nights = (end - start) / (1000 * 3600 * 24);
                nr_nights = Math.round(Math.abs(nr_nights)) - 1;

                if (nr_nights == 1) {
                    $("#nights").text(nr_nights + " night stay");
                } else {
                    $("#nights").text(nr_nights + " nights stay");
                }
            }
        );
    }
});

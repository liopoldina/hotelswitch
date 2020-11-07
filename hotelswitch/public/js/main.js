$(function() {
    // 1) dropdown menu
    $(".account_dropdown").click(function() {
        if ($(".dropdown_menu").hasClass("dropdown_menu_show")) {
            $(".dropdown_menu").removeClass("dropdown_menu_show");
        } else {
            $(".dropdown_menu").addClass("dropdown_menu_show");
        }
    });

    //hide if click outside
    $(document).click(function(e) {
        var dropdown = $(".account_dropdown");
        var container = $(".dropdown_menu");

        // if the target of the click isn't the container nor a descendant of the container
        if (
            !container.is(e.target) &&
            container.has(e.target).length === 0 &&
            !dropdown.is(e.target)
        ) {
            $(".dropdown_menu").removeClass("dropdown_menu_show");
        }
    });

    // 2) destination autocomplete
    $("#destination")
        .autocomplete(
            {
                select: function(event, ui) {
                    event.preventDefault();
                    $("#destination").val(ui.item.label); // display the label
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
                            name: request.term
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

    // 3) date_range_picker
    // get today date
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, "0");
    var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + "/" + dd + "/" + yyyy;

    // date_range_picker

    if ($("#date_range").val() == "") {
        // case homepage
        $("#date_range").daterangepicker({
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
        // case search and hotel page
        $("#date_range").daterangepicker(
            {
                autoApply: true,
                minDate: today,
                maxDate: "12/31/2021",
                maxSpan: {
                    days: 27
                },
                locale: {
                    // format: "DD/MM/YY",
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

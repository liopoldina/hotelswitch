$(function() {
    // 0) dropdown menu
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

    // 1) destination autocomplete
    $("#destination")
        .autocomplete(
            {
                select: function(event, ui) {
                    event.preventDefault();
                    $("#destination").val(ui.item.label); // display the label
                    $("#lat").val(ui.item.coords.lat);
                    $("#lon").val(ui.item.coords.lon);
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

    // 2) alterar cor selected sort
    $(".sort_item", this).click(function() {
        $(".sort_item").removeClass("sort_selected");
        $(this).addClass("sort_selected");
        console.log($(this).attr("id"));
        switch ($(this).attr("id")) {
            case "sort_our_top_picks":
                m.filters.sort = "minRate";
                m.filters.sort_order = 1;
                break;
            case "sort_lowest_price_first":
                m.filters.sort = "minRate";
                m.filters.sort_order = 1;
                break;
            case "sort_stars":
                if (m.filters.sort == "categoryCode") {
                    m.filters.sort_order = -1 * m.filters.sort_order;
                } else {
                    m.filters.sort_order = -1;
                }
                m.filters.sort = "categoryCode";
                break;
            case "sort_distance_from_center":
                if (m.filters.sort == "distance_center") {
                    m.filters.sort_order = -1 * m.filters.sort_order;
                } else {
                    m.filters.sort_order = 1;
                }
                m.filters.sort = "distance_center";
                break;
            case "sort_review_score":
                if (m.filters.sort == "score") {
                    m.filters.sort_order = -1 * m.filters.sort_order;
                } else {
                    m.filters.sort_order = -1;
                }
                m.filters.sort = "score";
                break;
        }
        get_filter_results();
    });

    // 3) loading
    $(".switch, .hopping_select").click(function() {
        $(".hotel_boxes_wrapper").addClass("hotelbox_loading");
        $(".page_loading_wrapper ").addClass("filter_loading_wrapper_show");
        setTimeout(function() {
            $(".hotel_boxes_wrapper").removeClass("hotelbox_loading");
            $(".page_loading_wrapper ").removeClass(
                "filter_loading_wrapper_show"
            );
        }, 1000);
    });

    // 4) get today date to set in minDate in date_range_picker
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, "0");
    var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
    var yyyy = today.getFullYear();
    today = mm + "/" + dd + "/" + yyyy;

    // 5) date_range_picker
    $("#date_range").daterangepicker(
        {
            autoApply: true,
            minDate: today,
            maxDate: "12/31/2020",
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

    // 6) Delete policy separator dot if payment policy doesn't exists
    if ($(".payment_policy").is(":empty")) {
        $(".policy_separator")
            .children()
            .text("");
    }

    // 7) Delete hotel reviews wrapper if there is no reviews
    $(".hotel_review")
        .has(".score:empty")
        .remove();

    // 8) Open and close map
    //open map
    $(".map_wrapper").click(function() {
        $("#map_overlay").addClass("display_map_overlay");
        $("body").css("overflow", "hidden"); //disable scroll
    });
    //close map on cross
    $(".map_close").click(function() {
        $("#map_overlay").removeClass("display_map_overlay");
        $("body").css("overflow", "auto"); //enable scroll
    });
    //close map on clicked outside
    $(document).mouseup(function(e) {
        if ($("#map_overlay").hasClass("display_map_overlay")) {
            var container = $("#map_popup");
            if (
                !container.is(e.target) &&
                container.has(e.target).length === 0
            ) {
                $("#map_overlay").removeClass("display_map_overlay");
                $("body").css("overflow", "auto"); //enable scroll
            }
        }
    });

    // 9 Price Range Slider
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 150,
        step: 5,
        values: [0, 150],
        slide: function(event, ui) {
            if (ui.values[1] == 150) {
                $("#amount").val(
                    "€" + ui.values[0] + " - €" + ui.values[1] + "+"
                );
            } else {
                $("#amount").val("€" + ui.values[0] + " - €" + ui.values[1]);
            }
            m.filters.price_range = {};
            m.filters.price_range.minimum_price = ui.values[0];
            m.filters.price_range.maximum_price = ui.values[1];
            if (ui.values[1] == 150) {
                m.filters.price_range.maximum_price = 999;
            }
        },
        stop: function(event, ui) {
            get_filter_results();
        }
    });

    $("#amount").val(
        "€" +
            $("#slider-range").slider("values", 0) +
            " - €" +
            $("#slider-range").slider("values", 1) +
            "+"
    );

    // 10 Uncheck radio button on clicked
    $("input:radio").on("click", function(e) {
        var inp = $(this); //cache the selector
        if (inp.is(".theone")) {
            //see if it has the selected class
            inp.prop("checked", false).removeClass("theone");
            return;
        }
        $("input:radio[name='" + inp.prop("name") + "'].theone").removeClass(
            "theone"
        );
        inp.addClass("theone");
    });

    // 11) Get value of selected filters
    var template = $("#hotelbox").clone();

    $(".check_box").click(function() {
        m.filters.price_range = {};
        m.filters.price_range.minimum_price = $("#slider-range").slider(
            "values",
            0
        );
        m.filters.price_range.maximum_price = $("#slider-range").slider(
            "values",
            1
        );

        if (m.filters.price_range.maximum_price == 150) {
            m.filters.price_range.maximum_price = 999;
        }
        // stars
        m.filters.stars = [];
        $("input:checkbox[name=stars]:checked").each(function() {
            m.filters.stars.push($(this).val());
        });
        m.filters.stars = m.filters.stars.reverse();
        m.filters.stars = m.filters.stars.join(",");
        if (m.filters.stars == "") {
            m.filters.stars = "5,4,3,2,1";
        }
        // distance from center
        m.filters.distance_center = parseFloat(
            $("input:radio[name=distance_center]:checked").val()
        );
        if (isNaN(m.filters.distance_center)) {
            m.filters.distance_center = 10;
        }

        // cancellation policy
        m.filters.free_cancellation = $(
            "input:checkbox[name=free_cancellation]:checked"
        ).val();

        if (m.filters.free_cancellation != "true") {
            m.filters.free_cancellation = false;
        }
        // minimum score
        m.filters.minimum_score = parseFloat(
            $("input:radio[name=minimum_score]:checked").val()
        );

        // call function get_filter_results
        get_filter_results();
    });

    function get_filter_results() {
        $(".hotel_boxes_wrapper").addClass("hotelbox_loading");
        $(".page_loading_wrapper").addClass("filter_loading_wrapper_show");
        $(".page_loading").addClass("page_loading_show");
        $(".page_end_wrapper").removeClass("page_end_wrapper_show");

        function filter(callback) {
            $.ajax({
                url: "results",
                method: "GET",
                dataType: "json",
                data: {
                    mode: "filter",
                    m: m
                },
                success: callback
            });
        }

        filter(function(result) {
            m.destination_header = result["m"]["destination_header"];
            m.index = result["m"]["index"];
            m.next_index = result["m"]["next_index"];

            if (result["hotels"] == null) {
                $(".hotelbox").remove();
                $(".hotel_boxes_wrapper").removeClass("hotelbox_loading");
                $(".page_loading_wrapper ").removeClass(
                    "filter_loading_wrapper_show"
                );
                $(".page_loading").removeClass("page_loading_show");
                $(".page_end_message span").text(
                    "There are no properties that match your search criteria."
                );
                $(".page_end_wrapper").addClass("page_end_wrapper_show");
                $("html, body").animate({ scrollTop: 0 }, "slow");
            } else {
                hotel = result["hotels"];
                $(".hotelbox").remove();
                for (var i = 0; i < hotel.length; i++) {
                    var box = template.clone();
                    $(box)
                        .find(".search_cover_photo")
                        .attr("src", hotel[i].search_cover_photo);
                    $(box)
                        .find(".name")
                        .text(hotel[i].name);
                    $(box)
                        .find(".stars")
                        .text(hotel[i].stars_symbol);
                    $(box)
                        .find(".quality")
                        .text(hotel[i].quality);
                    $(box)
                        .find(".nr_reviews")
                        .text(hotel[i].nr_reviews);
                    $(box)
                        .find(".score")
                        .text(hotel[i].score);
                    $(box)
                        .find(".district")
                        .text(hotel[i].district);
                    $(box)
                        .find(".distance_center")
                        .text(hotel[i].distance_center);
                    $(box)
                        .find(".city")
                        .text(hotel[i].city);
                    $(box)
                        .find(".room_name")
                        .text(hotel[i].room_name);
                    $(box)
                        .find(".cancellation_policy")
                        .text(hotel[i].cancellation_policy);
                    $(box)
                        .find(".price")
                        .text(hotel[i].price);
                    $(box)
                        .find(".link")
                        .attr(
                            "href",
                            "hotel?hotel_id=" +
                                hotel[i].id +
                                "&m=" +
                                JSON.stringify(m)
                        );
                    $(box)
                        .find(".link_name")
                        .attr(
                            "href",
                            "hotel?hotel_id=" +
                                hotel[i].id +
                                "&m=" +
                                JSON.stringify(m)
                        );
                    $(".hotel_boxes_wrapper").append($(box));
                }
                $(".hotel_boxes_wrapper").removeClass("hotelbox_loading");
                $(".page_loading_wrapper ").removeClass(
                    "filter_loading_wrapper_show"
                );
                $(".page_loading").removeClass("page_loading_show");
            }
        });
    }

    // 12) load more results if scrooll all the way down
    $(window).scroll(function() {
        if (
            Math.ceil($(window).scrollTop() + $(window).height()) >=
            $(document).height()
        ) {
            // call function get_page_results
            if (m.next_index == "no more results") {
            } else {
                get_page_results();
            }
        }
    });

    function get_page_results() {
        $(".page_loading").addClass("page_loading_show");

        function getpage(callback) {
            $.ajax({
                url: "results",
                method: "GET",
                dataType: "json",
                data: {
                    mode: "page",
                    m: m
                },
                success: callback
            });
        }

        getpage(function(result) {
            m.index = result["m"]["index"];
            m.next_index = result["m"]["next_index"];

            if (m.next_index == "no more results") {
                $(".page_loading").removeClass("page_loading_show");
                $(".page_end_message span").text(
                    "There are no more properties that match your search criteria."
                );
                $(".page_end_wrapper").addClass("page_end_wrapper_show");
            } else {
                initial_length = hotel.length;
                hotel = hotel.concat(result["hotels"]);
                $(".page_loading").removeClass("page_loading_show");
                for (var i = initial_length; i < hotel.length; i++) {
                    var box = template.clone();
                    $(box)
                        .find(".search_cover_photo")
                        .attr("src", hotel[i].search_cover_photo);
                    $(box)
                        .find(".name")
                        .text(hotel[i].name);
                    $(box)
                        .find(".stars")
                        .text(hotel[i].stars_symbol);
                    $(box)
                        .find(".quality")
                        .text(hotel[i].quality);
                    $(box)
                        .find(".nr_reviews")
                        .text(hotel[i].nr_reviews);
                    $(box)
                        .find(".score")
                        .text(hotel[i].score);
                    $(box)
                        .find(".district")
                        .text(hotel[i].district);
                    $(box)
                        .find(".distance_center")
                        .text(hotel[i].distance_center);
                    $(box)
                        .find(".city")
                        .text(hotel[i].city);
                    $(box)
                        .find(".room_name")
                        .text(hotel[i].room_name);

                    $(box)
                        .find(".cancellation_policy")
                        .text(hotel[i].cancellation_policy);
                    $(box)
                        .find(".price")
                        .text(hotel[i].price);
                    $(box)
                        .find(".link")
                        .attr(
                            "href",
                            "hotel?hotel_id=" +
                                hotel[i].id +
                                "&m=" +
                                JSON.stringify(m)
                        );
                    $(box)
                        .find(".link_name")
                        .attr(
                            "href",
                            "hotel?hotel_id=" +
                                hotel[i].id +
                                "&m=" +
                                JSON.stringify(m)
                        );
                    $(".hotel_boxes_wrapper").append($(box));
                }
            }
        });
    }

    //end jquery
});

// 13) load more results if scrooll all the way down
function image_error(image) {
    image.onerror = "";
    image.src =
        "http://photos.hotelbeds.com/giata/bigger/36/363373/363373a_hb_ro_008.jpg";
    return true;
}

// JUST JAVASCRIPT
//14) Google Maps

// Map options
var options = {
    center: { lat: 38.715, lng: -9.142685 },
    zoom: 15,
    gestureHandling: "greedy" //no need to press ctrl to mouse zoom
};
// New map
function initMap() {
    var map = new google.maps.Map(document.getElementById("map"), options);
    // Add Marker Function
    function addMarker(props) {
        var marker = new google.maps.Marker({
            position: props.coords,
            map: map
        });
        //Info Window
        var infoWindow = new google.maps.InfoWindow({
            content: props.content
        });
        marker.addListener("click", function() {
            infoWindow.open(map, marker);
        });
    }
    //Create markets dynamically
    var markers = [];
    for (var i = 0; i < hotel.length; i++) {
        markers[i] = {
            coords: {
                lat: parseFloat(hotel[i].coords.lat),
                lng: parseFloat(hotel[i].coords.lon)
            },
            content: "<h1>" + hotel[i].name + "</h1>"
        };
        addMarker(markers[i]);
    }
}

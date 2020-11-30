$(function() {
    // 1) Delete policy separator and hotel reviews if not set
    $(".room_policy")
        .has(".payment_policy:not(:empty)")
        .children(".policy_separator")
        .text(".");

    $(".hotel_review")
        .has(".score:empty")
        .remove();

    // 2) Open and close map
    //open map
    $(".map_wrapper, .map_wrapper_mobile").click(function() {
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

    // 3) Price Range Slider
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
            results("filter");
        }
    });

    $("#amount").val(
        "€" +
            $("#slider-range").slider("values", 0) +
            " - €" +
            $("#slider-range").slider("values", 1) +
            "+"
    );

    // 4) Uncheck radio button on clicked
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

    // 5) Sort
    $(".sort_item, .sort_item_mobile", this).click(function() {
        // mobile

        setTimeout(function() {
            $(".sort_wrapper_mobile").css("display", "none");
        }, 500);

        //desktop
        if ($(this).hasClass("sort_selected")) {
            m.filters.sort_order = -1 * m.filters.sort_order;
            if (m.filters.sort_order == 1) {
                $("[name=" + $(this).attr("name") + "]")
                    .find("i")
                    .attr("class", "fas fa-arrow-up");
            } else {
                $("[name=" + $(this).attr("name") + "]")
                    .find("i")
                    .attr("class", "fas fa-arrow-down");
            }
        } else {
            $(".sort_selected").removeClass("sort_selected");
            $("[name=" + $(this).attr("name") + "]").addClass("sort_selected");
            m.filters.sort_order = $(this).attr("value");
        }

        m.filters.sort = $(this).attr("name");

        results("filter");
    });

    // 6) Sort Mobile
    $(".sort_mobile", this).click(function(e) {
        if (
            !$(e.target).hasClass("sort_item_mobile") &&
            !$(e.target)
                .parent()
                .hasClass("sort_item_mobile")
        ) {
            if ($(".sort_wrapper_mobile").css("display") == "none") {
                $(".sort_wrapper_mobile").css("display", "block");
            } else {
                $(".sort_wrapper_mobile").css("display", "none");
            }
        }
    });

    //hide if click outside
    $(document).click(function(e) {
        var dropdown = $(".mobile_bar_item");
        var container = $(".sort_wrapper_mobile");

        // if the target of the click isn't the container nor a descendant of the container
        if (
            !container.is(e.target) &&
            container.has(e.target).length === 0 &&
            !dropdown.is(e.target) &&
            dropdown.has(e.target).length === 0
        ) {
            $(".sort_wrapper_mobile").css("display", "none");
        }
    });

    // 7) Filter
    var template = $("#hotelbox").clone();
    // get value of selected filter
    $(".check_box, .show_results button").click(function() {
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
            m.filters.distance_center = 50;
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

        results("filter");
    });

    //Filter Mobile
    $(".filter_mobile, .filter_close, .show_results button").click(function() {
        if ($(".filter_wrapper").css("display") == "none") {
            $("body").addClass("no_scroll");
            $(".filter_wrapper").addClass("show");
        } else {
            $(".filter_wrapper").removeClass("show");
            $("body").removeClass("no_scroll");
        }
    });

    // 8) Pagination
    $(window).scroll(function() {
        if (
            Math.ceil($(window).scrollTop() + $(window).outerHeight()) >=
            $(document).height()
        ) {
            // call function get_page_results
            if (m.next_index == "no more results") {
            } else {
                results("page");
            }
        }
    });

    // 9) Function results
    function results(mode) {
        loading(mode, "start");

        function filter(callback) {
            $.ajax({
                url: "results",
                method: "GET",
                dataType: "json",
                data: {
                    mode: mode,
                    m: m
                },
                success: callback
            });
        }

        filter(function(result) {
            m.index = result["m"]["index"];
            m.next_index = result["m"]["next_index"];

            switch (mode) {
                case "filter":
                    $(".hotelbox").remove();
                    if (result["hotels"].length == 0) {
                        $(".no_results_message span").text(
                            "There are no properties that match your search criteria."
                        );
                        $(".no_results_wrapper").addClass(
                            "no_results_filter_show"
                        );
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                    } else {
                        hotel = result["hotels"];
                        build(0);
                    }
                    break;
                case "page":
                    if (result["hotels"].length == 0) {
                        $(".no_results_message span").text(
                            "There are no more properties that match your search criteria."
                        );
                        $(".no_results_wrapper").addClass(
                            "no_results_page_show"
                        );
                    } else {
                        initial_length = hotel.length;
                        hotel = hotel.concat(result["hotels"]);

                        build(initial_length);
                    }
                    break;
            }

            loading(mode, "stop");
        });
    }

    function loading(mode, state) {
        switch (mode + state) {
            case "filter" + "start":
                $(".hotel_boxes_wrapper").addClass("hotelbox_loading");
                $(".page_loading_wrapper").addClass(
                    "filter_loading_wrapper_show"
                );
                $(".page_loading").addClass("page_loading_show");
                $(".no_results_wrapper").removeClass("no_results_filter_show");
                $(".no_results_wrapper").removeClass("no_results_page_show");
                break;
            case "filter" + "stop":
                $(".hotel_boxes_wrapper").removeClass("hotelbox_loading");
                $(".page_loading_wrapper ").removeClass(
                    "filter_loading_wrapper_show"
                );
                $(".page_loading").removeClass("page_loading_show");
                break;
            case "page" + "start":
                $(".page_loading").addClass("page_loading_show");
                break;
            case "page" + "stop":
                $(".page_loading").removeClass("page_loading_show");
                break;
        }
    }

    function build(start_index) {
        for (i = start_index; i < hotel.length; i++) {
            var box = template.clone();
            $(box)
                .find(".search_cover_photo")
                .attr("src", hotel[i].search_cover_photo);
            $(box)
                .find(".search_cover_photo")
                .attr("data-hotel-id", hotel[i].id);
            $(box)
                .find(".search_cover_photo")
                .attr("data-index", 1);
            $(box)
                .find(".name")
                .text(hotel[i].name + " ");
            $(box)
                .find(".name")
                .append($('<div class="stars"></div>'));
            $(box)
                .find(".stars")
                .text(hotel[i].stars_symbol);
            $(box)
                .find(".quality")
                .text(hotel[i].quality);
            $(box)
                .find(".nr_reviews")
                .text(hotel[i].nr_reviews + " reviews");
            $(box)
                .find(".score_value")
                .text(hotel[i].score.toFixed(1));
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
                .find(".pick_score")
                .text(Math.round(hotel[i].pick_score) + "%");
            $(box)
                .find("meter")
                .attr("value", hotel[i].pick_score);
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
                    "hotel?hotel_id=" + hotel[i].id + "&m=" + JSON.stringify(m)
                );
            $(box)
                .find(".link_name")
                .attr(
                    "href",
                    "hotel?hotel_id=" + hotel[i].id + "&m=" + JSON.stringify(m)
                );
            $(".hotel_boxes_wrapper").append($(box));
        }
    }
});
//end jquery

// JUST JAVASCRIPT

// 10) replace non-existant hotel photo
function image_error(image) {
    image_types = ["a", "ro", "r", "f", "l", "ba", "w", "p", "k", "t"];

    id = $(image)
        .attr("data-hotel-id")
        .padStart(6, "0");
    index = parseInt($(image).attr("data-index")) + 1;
    type_index = parseInt($(image).attr("data-type-index"));

    $(image).attr("data-index", index);

    index_string = String(index).padStart(3, "0");

    image.src =
        "http://photos.hotelbeds.com/giata/bigger/" +
        id.substring(0, 2) +
        "/" +
        id +
        "/" +
        id +
        "a_hb_" +
        image_types[type_index] +
        "_" +
        index_string +
        ".jpg";

    if (index == 2) {
        type_index = type_index + 1;
        index = 0;
        $(image).attr("data-index", index);
        $(image).attr("data-type-index", type_index);
    }

    if (type_index == image_types.length) {
        $.ajax({
            url: "cover_image",
            method: "GET",
            data: {
                hotel_id: $(image).attr("data-hotel-id")
            },
            success: function(res) {
                image.src = res;
            }
        });
        image.onerror = "";
        console.log("laravel image");
    }
    return true;
}

// 11) Google Maps

// Map options
var options = {
    center: { lat: parseFloat(m.lat), lng: parseFloat(m.lon) },
    zoom: 15,
    gestureHandling: "greedy", //no need to press ctrl to mouse zoom
    mapTypeControl: false,
    streetViewControl: false,
    fullscreenControl: false
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

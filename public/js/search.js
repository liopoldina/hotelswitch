$(function() {
    // 1) Price Range Slider
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
            //  get_map_results if map is open
            if ($("#map_overlay").hasClass("display_map_overlay")) {
                get_map_results();
            }
        }
    });

    $("#amount").val(
        "€" +
            $("#slider-range").slider("values", 0) +
            " - €" +
            $("#slider-range").slider("values", 1) +
            "+"
    );

    // 2) Uncheck radio button on clicked
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

    // 3) Sort
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

    // 4) Sort Mobile
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

        if (
            !container.is(e.target) &&
            container.has(e.target).length === 0 &&
            !dropdown.is(e.target) &&
            dropdown.has(e.target).length === 0
        ) {
            $(".sort_wrapper_mobile").css("display", "none");
        }
    });

    // 5) Filter
    template = $(".hotelbox")
        .first()
        .clone();

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

        //  get_map_results if map is open
        if ($("#map_overlay").hasClass("display_map_overlay")) {
            get_map_results();
        }
    });

    //Filter Mobile
    $(
        ".filter_mobile, .filter_close, .show_results button, .map-filter-button"
    ).click(function() {
        if ($(".filter_wrapper").css("display") == "none") {
            $("body").addClass("no_scroll");
            $(".filter_wrapper").addClass("show");
        } else {
            $(".filter_wrapper").removeClass("show");
            $("body").removeClass("no_scroll");
        }
    });

    // 6) Pagination
    $(window).scroll(function() {
        if (
            Math.ceil($(window).scrollTop() + $(window).outerHeight()) >=
                $(document).height() &&
            window.location.pathname.split("/").pop() == "search"
        ) {
            // call function get_page_results
            if (m.next_index == "no more results") {
            } else {
                results("page");
            }
        }
    });

    // 7) Function results
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
            case "map" + "start":
                $("#map").css("filter", "opacity(40%)");
                $(".map_loading_gif ").css("display", "block");
                $(".map-no-results").css("display", "none");
                break;
            case "map" + "stop":
                $("#map").css("filter", "opacity(100%)");
                $(".map_loading_gif ").css("display", "none");
                break;
        }
    }

    function build(start_index) {
        for (i = start_index; i < hotel.length; i++) {
            box = fill(hotel[i]);
            $(".hotel_boxes_wrapper").append($(box));
        }
    }

    // 8) Fill function
    function fill(hotel) {
        var box = template.clone();
        $(box)
            .find(".search_cover_photo")
            .attr("src", hotel.search_cover_photo);
        $(box)
            .find(".search_cover_photo")
            .attr("data-hotel-id", hotel.id);
        $(box)
            .find(".search_cover_photo")
            .attr("data-index", 1);
        $(box)
            .find(".search_cover_photo")
            .attr("onerror", "image_error(this)");
        $(box).find(".name")[0].childNodes[0].nodeValue = hotel.name + " ";
        $(box)
            .find(".stars")
            .text(hotel.stars_symbol);
        $(box)
            .find(".quality")
            .text(hotel.quality);
        $(box)
            .find(".nr_reviews")
            .text(hotel.nr_reviews + " reviews");
        $(box)
            .find(".score_value")
            .text(hotel.score.toFixed(1));
        $(box)
            .find(".district")
            .text(hotel.district);
        $(box)
            .find(".distance_center")
            .text(hotel.distance_center);
        $(box)
            .find(".city")
            .text(hotel.city);
        $(box)
            .find(".pick_score")
            .text(Math.round(hotel.pick_score) + "%");
        $(box)
            .find("meter")
            .attr("value", hotel.pick_score);
        $(box).find(".room_name")[0].childNodes[0].nodeValue =
            hotel.room_number + " x " + hotel.room_name;
        $(box)
            .find("i")
            .remove();
        $(box)
            .find(".guests_multiplier, .children_multiplier")
            .text("");
        if (m.adults_per_room + m.children_per_room > 3) {
            $('<i class="fas fa-user"></i>').insertBefore(
                $(box).find(".guests_multiplier")
            );
            $(box)
                .find(".adults_multiplier")
                .text("x " + (m.adults_per_room + m.children_per_room));
        } else {
            for (g = 0; g < m.adults_per_room + m.children_per_room; g++) {
                $(box)
                    .find(".room_guests_icon")
                    .append(' <i class="fas fa-user"></i>');
            }
        }
        if (hotel.board == "Room Only") {
            $(box)
                .find(".board")
                .text("");
        } else {
            $(box)
                .find(".board")
                .text(hotel.board);
        }
        if (hotel.cancellation_policy == "NRF") {
            $(box)
                .find(".cancellation_policy")
                .text("");
        } else {
            $(box)
                .find(".cancellation_policy")
                .text("Free Cancellation");
        }
        $(box)
            .find(".price")
            .text(hotel.price);
        $(box)
            .find(".link")
            .attr(
                "href",
                "hotel?hotel_id=" + hotel.id + "&m=" + JSON.stringify(m)
            );
        $(box)
            .find(".link_name")
            .attr(
                "href",
                "hotel?hotel_id=" + hotel.id + "&m=" + JSON.stringify(m)
            );
        return box;
    }

    // 9) Map
    initMap();

    //open map
    $(
        ".map_wrapper, .map_wrapper_mobile, .hotel_map_wrapper, .see_map, .head_map"
    ).click(function() {
        $("#map_overlay").addClass("display_map_overlay");
        $("body").css("overflow", "hidden"); //disable scroll
        if ($(window).width() > 675) {
            $(".map_left").append($(".filter_wrapper"));
        }
        get_map_results();
    });
    //close map on cross
    function map_close() {
        $("#map_overlay").removeClass("display_map_overlay");
        $("body").css("overflow", "auto"); //enable scroll
        if ($(window).width() > 675) {
            $(".left_content").append($(".filter_wrapper"));
        }
    }

    $(".map_close").click(function() {
        map_close();
    });

    //close map on clicked outside
    $(document).mouseup(function(e) {
        if ($("#map_overlay").hasClass("display_map_overlay")) {
            if (
                !$("#map_popup").is(e.target) &&
                $("#map_popup").has(e.target).length === 0 &&
                !$(".filter_wrapper").is(e.target) &&
                $(".filter_wrapper").has(e.target).length === 0
            ) {
                map_close();
            }
        }
    });

    // map results
    function map_results(callback) {
        loading("map", "start");

        $.ajax({
            url: "results",
            method: "GET",
            dataType: "json",
            data: {
                mode: "map",
                m: m
            },
            success: callback
        });
    }

    markers = [];

    function get_map_results() {
        map_results(function(result) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null); // clear markers
            }

            markers = [];

            hotels_map = result["hotels"];

            if (hotels_map.length === 0) {
                $(".map-no-results").css("display", "flex");
                $(".map_loading_gif ").css("display", "none");
            } else {
                addMarkers();
            }
        });
    }

    function addMarkers() {
        for (var i = 0; i < hotels_map.length; i++) {
            markers.push(
                addMarker(hotels_map[i], function() {
                    if (i == hotels_map.length - 1) {
                        set_main_marker();

                        setTimeout(function() {
                            loading("map", "stop");
                        }, 500);
                    }
                })
            );
        }
    }

    function addMarker(hotel_map, callback) {
        var marker = new google.maps.Marker({
            position: {
                lat: parseFloat(hotel_map.coords.lat),
                lng: parseFloat(hotel_map.coords.lon)
            },
            icon: "images/map/marker.png",
            map: map,
            id: hotel_map.id
        });

        if ($(window).width() > 675) {
            marker.addListener("mouseover", function() {
                marker.setIcon("images/map/marker-hover.png");
                infoWindow.setContent(fill(hotel_map)[0]);
                infoWindow.open(map, marker);
            });
            marker.addListener("mouseout", function() {
                marker.setIcon("images/map/marker.png");
                infoWindow.close();
            });
            marker.addListener("click", function() {
                window.open(
                    "hotel?hotel_id=" + hotel_map.id + "&m=" + JSON.stringify(m)
                );
            });
        } else {
            marker.addListener("click", function() {
                if (typeof last_marker !== "undefined") {
                    last_marker.setIcon("images/map/marker.png");
                }
                marker.setIcon("images/map/marker-hover.png");
                last_marker = marker;
                infoWindow.setContent(fill(hotel_map)[0]);
                infoWindow.open(map, marker);
            });
            map.addListener("drag", function() {
                last_marker.setIcon("images/map/marker.png");
                infoWindow.close();
            });
            $(document).click(function(e) {
                if (
                    !$(".gm-style-iw").is(e.target) &&
                    $(".gm-style-iw").has(e.target).length === 0 &&
                    !$("img[draggable=false]").is(e.target)
                ) {
                    infoWindow.close();
                    if (marker.id != m.hotel_id) {
                        marker.setIcon("images/map/marker.png");
                    }
                }
            });
        }
        callback();
        return marker;
    }

    function set_main_marker() {
        for (var i = 0; i < markers.length; i++) {
            if (markers[i].id == m.hotel_id) {
                var icon = {
                    url: "images/map/marker-hover.png",
                    scaledSize: new google.maps.Size(30, 45)
                };
                markers[i].setIcon(icon);
                markers[i].setZIndex(1);

                markers[i].setAnimation(google.maps.Animation.BOUNCE);

                stopAnimation(markers[i]);
                function stopAnimation(marker) {
                    setTimeout(function() {
                        marker.setAnimation(null);
                    }, 3000);
                }

                google.maps.event.clearInstanceListeners(markers[i]);

                var index = i;

                var content = fill(hotels_map[index])[0];

                $(content)
                    .find(".hotel_book")
                    .remove();

                $(content)
                    .find("a")
                    .removeAttr("href");

                if ($(window).width() > 675) {
                    markers[i].addListener("mouseover", function() {
                        infoWindow.setContent(content);
                        infoWindow.open(map, markers[index]);
                    });

                    markers[i].addListener("mouseout", function() {
                        infoWindow.close();
                    });
                } else {
                    markers[i].addListener("click", function() {
                        infoWindow.setContent(content);
                        infoWindow.open(map, markers[index]);
                    });
                }
            }
        }
    }
});
//end jquery

// New map
function initMap() {
    map = new google.maps.Map(document.getElementById("map"), options);
    infoWindow = new google.maps.InfoWindow({});
}
var options = {
    center: { lat: parseFloat(m.lat), lng: parseFloat(m.lon) },
    zoom: 15,
    gestureHandling: "greedy", //no need to press ctrl to mouse zoom
    mapTypeControl: false,
    streetViewControl: false,
    fullscreenControl: false,
    clickableIcons: false
};

// 10) replace non-existant hotel cover photos
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
    }
    return true;
}

@section('hopping')
<div id="hopping" class="hopping_wrapper">
    <div class="hopping_toggle">
        <div class="hooping_title tooltip">
            <span>Switch Hotels</span>
            <span class="tooltiptext change_hotels">Change Hotels mid trip to get the best deal!</span>
        </div>
        <div class="toogle_wrapper">
            <label class="switch">
                <input type="checkbox" checked />
                <span class="slider round"></span>
            </label>
        </div>
    </div>
    <div class="hopping_filter">
        <div class="hopping_filter_name_wrapper tooltip">
            <span>Min. saving per hotel:</span>
            <span class="tooltiptext min_saving">Would you change hotels mid trip for €40? What about
                for
                €100?</span>
        </div>
        <div class="hopping_select_wrapper">
            <select type="text" id="minimum_hopp_saving" name="minimum_hopp_saving" class="hopping_select">
                <option value="25€">
                    25€
                </option>
                <option value="40€" selected>
                    40€
                </option>
                <option value="60€"> 60€ </option>
                <option value="80€">
                    80€
                </option>
                <option value="100€">
                    100€
                </option>
            </select>
        </div>
    </div>

    <div class="hopping_filter">
        <div class="hopping_filter_name_wrapper tooltip">
            <span>Max. hotels distance:</span>
            <span class="tooltiptext max_hopp">Choose the maximum distance between two consecutives
                hotels</span>
        </div>
        <div class="hopping_select_wrapper">
            <select type="text" id="maximum_hopp_distance" name="maximum_hopp_distance" class="hopping_select">
                <option value="250m">
                    100m
                </option>
                <option value="250m" selected>
                    250m
                </option>
                <option value="500m">
                    500m
                </option>
                <option value="1km">
                    1km
                </option>
                <option value="2km">
                    2km
                </option>
                <option value="5km">
                    5km
                </option>
            </select>
        </div>
    </div>
</div>
@endsection

@section('left_search')
<div id="filter" class="filter_wrapper">
    <div class="filter_title">Filter by:</div>
    <div class="filter_section">
        <div class="section_title">Price per night</div>
        <div class="price_range_item">
            <label for="amount"></label>
            <div class="amount_wrapper">
                <input type="text" id="amount" readonly>
            </div>
            <div class="slider_range_wrapper">
                <div id="slider-range"></div>
            </div>
        </div>
    </div>

    <div class="filter_section">
        <div class="section_title">Star Rating</div>
        <div class="section_item">
            <input type="checkbox" id="1_star" class="check_box" name="stars" value="1" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="1_star">1 star</label>
            </div>
        </div>
        <div class="section_item">
            <input type="checkbox" id="2_stars" class="check_box" name="stars" value="2" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="2_stars">2 stars</label>
            </div>
        </div>
        <div class="section_item">
            <input type="checkbox" id="3_stars" class="check_box" name="stars" value="3" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="3_stars">3 stars</label>
            </div>
        </div>
        <div class="section_item">
            <input type="checkbox" id="4_stars" class="check_box" name="stars" value="4" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="4_stars">4 stars</label>
            </div>
        </div>
        <div class="section_item">
            <input type="checkbox" id="5_stars" class="check_box" name="stars" value="5" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="5_stars">5 stars</label>
            </div>
        </div>
    </div>

    <div class="filter_section">
        <div class="section_title">Distance from center</div>
        <div class="section_item">
            <input type="radio" id="500m" class="check_box" name="distance_center" value="0.5" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="500m">Less than 500m</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="1km" class="check_box" name="distance_center" value="1" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="1km">Less than 1km</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="3km" class="check_box" name="distance_center" value="3" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="3km">Less than 3km</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="5km" class="check_box" name="distance_center" value="5" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="5km">Less than 5km</label>
            </div>
        </div>
    </div>

    <div class="filter_section">
        <div class="section_title">Reservation Policy</div>
        <div class="section_item">
            <input type="checkbox" id="free_cancellation" class="check_box" name="free_cancellation" value="true" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="free_cancellation">Free cancellation</label>
            </div>
        </div>
    </div>

    <div class="filter_section">
        <div class="section_title">Minimum Score</div>
        <div class="section_item">
            <input type="radio" id="wonderful" class="check_box" name="minimum_score" value="9" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="wonderful">Wonderful: 9</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="very_good" class="check_box" name="minimum_score" value="8" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="very_good">Very Good: 8</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="good" class="check_box" name="minimum_score" value="7" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="good">Good: 7</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="pleasant" class="check_box" name="minimum_score" value="6" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="pleasant">Pleasant: 6</label>
            </div>
        </div>
    </div>
</div>
@endsection

@section('right_search')
<div id=search_page class="right">
    <div class="search_top">
        <div class="destination_header_wrapper">
            <span class="destination_header">Lisbon, Portugal </span>
        </div>
        <div class="sort_by">
            <span>Sort by:</span>
        </div>
        <div class="map_wrapper" id="map_wrapper">
            <div class="position_icon">
                <i class="fas fa-map-marker-alt fa-lg"></i>
            </div>
            <div class="map_text">
                <span>Map</span>
            </div>
        </div>
    </div>
    <div class="sort_wrapper">
        <div id="sort_our_top_picks" class="sort_item">
            <span>Our Top Picks</span>
        </div>
        <div id="sort_lowest_price_first" class="sort_item sort_selected">
            <span>Lowest Price First</span>
        </div>
        <div id="sort_stars" class="sort_item">
            <span>Stars</span>
        </div>
        <div id="sort_distance_from_center" class="sort_item">
            <span>Distance from center</span>
        </div>
        <div id="sort_review_score" class="sort_item sort_item_last_border">
            <span>Review Score</span>
        </div>
    </div>
    <div class="hotel_boxes_wrapper" id="hotel_boxes_wrapper">
        <div class="hotelbox" id="hotelbox">
            <div class="hotelbox_inside">
                <div class="hotel_photo">
                    <img src="./images/search/hotel_cover.jpg" class="search_cover_photo" alt="hotel_cover"
                        onerror="image_error(this);" />
                </div>
                <div class="hotel_content">
                    <div class="hotel_head">
                        <a class="link_name" href="hotel.php" target="_blank">
                            <span class="name">Hotel Royal Sample</span>
                        </a>
                        <div class="stars_wrapper">
                            <span class="stars">★★★★★</span>
                        </div>
                    </div>
                    <div class="hotel_review">
                        <div class="quality_number">
                            <div class="quality_wrapper">
                                <span class="quality">Good</span>
                            </div>
                            <div class="nr_reviews_wrapper">
                                <span class="nr_reviews">1,654</span>
                                <span>reviews</span>
                            </div>
                        </div>
                        <div class="score_wrapper">
                            <span class="score">9.5</span>
                        </div>
                    </div>
                    <div class="address_wrapper">
                        <div class="address">
                            <span class="district">District</span>
                            <span class="city">City</span>
                        </div>
                        <div class="address_separator">
                            <span>.</span>
                        </div>
                        <div class="distance_center_wrapper">
                            <span class="distance_center">250m from center</span>
                        </div>
                    </div>
                    <div class="hotel_room">
                        <div class="room_title">
                            <div class="room_name_wrapper">
                                <span class="room_name">Standard Double Room</span>
                            </div>
                            <div class="room_separator">
                                <span>-</span>
                            </div>
                            <div class="room_guests_icon">
                                <img src="./images/search/guest_icon.png" alt="guest_icon" />
                                <img src="./images/search/guest_icon.png" alt="guest_icon" />
                            </div>
                            <div class="nights_guests">
                                <span class="nights">2 nights</span>
                                <span>, </span>
                                <span class="adults">2 adults</span>
                            </div>
                        </div>
                        <div class="bed_type_wrapper">
                            <span class="bed_type">1 Double Bed</span>
                        </div>
                        <div class="policy_price_wrapper">
                            <div class="room_policy">
                                <div class="cancellation_policy_wrapper">
                                    <span class="cancellation_policy">Free cancellation</span>
                                </div>
                                <div class="policy_separator">
                                    <span>.</span>
                                </div>
                                <div class="payment_policy_wrapper">
                                    <span class="payment_policy">No prepayment needed</span>
                                </div>
                            </div>
                            <div class="price_wrapper">
                                <span class="price">€ 99</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hotel_book">
                    <a class="link" href="hotel.php" target="_blank">
                        <button>Select Room</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page_loading_wrapper">
        <div class="page_loading">
            <img src="images/search/page_loading.gif" alt="page_loading">
        </div>
    </div>
    <div class="page_end_wrapper">
        <div class="page_end_icon">
            <img src="./images/search/information_icon.jpg" alt="page_end_icon">
        </div>
        <div class="page_end_message">
            <span>There are no more properties that match your search criteria.</span>
        </div>
    </div>
</div>
@endsection

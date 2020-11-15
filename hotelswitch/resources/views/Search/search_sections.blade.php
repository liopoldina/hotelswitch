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
            <input type="radio" id="exceptional" class="check_box" name="minimum_score" value="5" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="exceptional">Exceptional: 5.0</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="wonderful" class="check_box" name="minimum_score" value="4.5" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="wonderful">Wonderful: 4.5</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="very_good" class="check_box" name="minimum_score" value="4" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="very_good">Very Good: 4.0</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="good" class="check_box" name="minimum_score" value="3.5" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="good">Good: 3.5</label>
            </div>
        </div>
        <div class="section_item">
            <input type="radio" id="pleasant" class="check_box" name="minimum_score" value="3" />
            <div class="check_box"></div>
            <div class="label_wrapper">
                <label for="pleasant">Pleasant: 3.0</label>
            </div>
        </div>
    </div>
</div>
@endsection

@section('right_search')
<div id=search_page class="right_content">
    <div class="search_top">
        <div class="destination_header_wrapper">
            <span class="destination_header">{{$m->destination ?? 'Lisbon, Portugal'}} </span>
            <span class="sort_by">Sort by:</span>
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
        <div class="sort_item" name="top_picks" value=-1>
            <div class="sort_item_wrapper">
                <span>Top Bargains</span>
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
        <div class="sort_item sort_selected" name="minRate" value=1>
            <div class="sort_item_wrapper">
                <span>Price</span>
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="sort_item" name="categoryCode" value=-1>
            <div class="sort_item_wrapper">
                <span>Stars</span>
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
        <div class="sort_item" name="distance_center" value=1>
            <div class="sort_item_wrapper">
                <span>Distance center</span>
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
        <div class="sort_item" name="score" value=-1>
            <div class="sort_item_wrapper">
                <span>Review Score</span>
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>
    </div>
    <div class="hotel_boxes_wrapper" id="hotel_boxes_wrapper">
        @php
        $nr_results = 2;
        if(isset($hotel)){$nr_results = count($hotel);}
        @endphp

        @for ($i = 0; $i < $nr_results ; $i++) <div class="hotelbox" id="hotelbox">
            <div class="hotel_photo">
                <img src={{$hotel[$i]->search_cover_photo ?? './images/search/hotel_cover.jpg'}}
                    class="search_cover_photo loading_image" alt="hotel_cover" data-hotel-id={{$hotel[$i]->id}}
                    data-index=1 data-type-index=0 onerror=image_error(this) />
            </div>
            <div class="hotel_content">
                <div class="hotel_head">
                    <a class="link_name"
                        href='hotel?hotel_id={{$hotel[$i]->id ?? ''}}&m={{isset($m) ? json_encode($m) :''}}'
                        target="_blank">
                        <div class="name">{{$hotel[$i]->name ?? 'Hotel Royal Sample'}} <div class="stars">
                                {{$hotel[$i]->stars_symbol ?? '★★★★★'}}</div>
                        </div>
                    </a>
                    <div class="quality_score_wrapper">
                        <div class="quality_nr_reviews">
                            <span class="quality">{{$hotel[$i]->quality ?? 'Good'}}</span>
                            <span class="nr_reviews">{{$hotel[$i]->nr_reviews ?? '1,654'}} reviews</span>
                        </div>
                        <div class="score_wrapper">
                            <img src={{asset("images/search/tripadvisor_logo.png")}} alt="tripadvisor_logo">
                            <span class="score"><strong
                                    class="score_value">{{number_format($hotel[$i]->score,1)?? '4.5'}}</strong>/5.0</span>
                        </div>
                    </div>
                </div>
                <div class="address_wrapper">
                    <span class="district">{{$hotel[$i]->district ?? ''}}</span>
                    <span class="city">{{$hotel[$i]->city ?? 'City'}}</span>
                    <span class="address_separator">.</span>
                    <span class="distance_center"> {{$hotel[$i]->distance_center ??  '250m from center'}}</span>
                </div>
                <div class="hotel_room">
                    <div class="room_title">
                        <div class="room_name">{{$hotel[$i]->room_name ?? 'Standard Double Room'}}
                            <div class="room_guests_icon">
                                <span class="room_separator">-</span>
                                <img class=guest_icon src="./images/search/guest_icon.png" alt="guest_icon" />
                                <img class=guest_icon src="./images/search/guest_icon.png" alt="guest_icon" />
                            </div>
                        </div>
                        <div class="nights_guests">
                            <span class="nights">{{$m->nights_text ?? '2 nights'}}</span>
                            <span>, </span>
                            <span class="adults">{{$m->adults_text ?? '2 adults'}}</span>
                        </div>
                    </div>
                    <div class="rate_wrapper">
                        <div class="rate_left">
                            <span class="bed_type">{{$hotel[$i]->bed_type ?? '1 Double Bed'}}</span>
                            <div class="room_policy">
                                <span
                                    class="cancellation_policy">{{$hotel[$i]->cancellation_policy ?? 'Free cancellation'}}</span>
                                <span class="policy_separator"></span>
                                <span class="payment_policy">{{$hotel[$i]->payment_policy ?? ''}}</span>
                            </div>
                        </div>
                        <span class="price">{{$hotel[$i]->price ?? '€99'}}</span>
                    </div>
                </div>
                <div class="hotel_book">
                    <a class="link" href='hotel?hotel_id={{$hotel[$i]->id ?? ''}}&m={{isset($m) ? json_encode($m) :''}}'
                        target="_blank">
                        <button>Select Room</button>
                    </a>
                </div>
            </div>
            @isset($hotel[$i]->pick_score)
            <div class="deal_wrapper">
                <meter min="0" low="33" high="66" max="100" optimum="100" value={{$hotel[$i]->pick_score}}></meter>
                <span class="pick_tittle">Bargain Score:</span>
                <span class="pick_score">{{round($hotel[$i]->pick_score)}}%</span>

            </div>
            @endisset

    </div>
    @endfor

</div>
<div class="page_loading_wrapper">
    <div class="page_loading">
        <img src="images/search/page_loading.gif" alt="page_loading">
    </div>
</div>
<div class="no_results_wrapper">
    <div class="no_results_icon">
        <img src="./images/search/information_icon.jpg" alt="page_end_icon">
    </div>
    <div class="no_results_message">
        <span>There are no more properties that match your search criteria.</span>
    </div>
</div>
</div>
@endsection

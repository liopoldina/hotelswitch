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
        <div class="filter_title">
            <i class="fas fa-filter filter_icon" aria-hidden="true"></i>
            <span>Filter</span>
            <i class="fas fa-times filter_close"></i>
        </div>
        <div class="filter_mobile_scroll">
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
        <div class="show_results">
            <button>Show Results</button>
        </div>
    </div>
@endsection

@section('right_search')
    <div id=search_page class="right_content">
        <div class="mobile_bar">
            <div class="mobile_bar_item sort_mobile">
                <i class="fas fa-sort"></i>
                <span>Sort</span>
                <div class="sort_wrapper_mobile">
                    <div class="triangle-up">
                    </div>
                    <div class="sort_item_mobile" name="top_picks" value=-1>
                        <span>Top Deals</span>
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="sort_item_mobile sort_selected" name="minRate" value=1>
                        <span>Price</span>
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="sort_item_mobile" name="categoryCode" value=-1>
                        <span>Stars</span>
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="sort_item_mobile" name="distance_center" value=1>
                        <span>Distance center</span>
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="sort_item_mobile" name="score" value=-1>
                        <span>Review Score</span>
                        <i class="fas fa-arrow-down"></i>
                    </div>
                </div>
            </div>
            <div class="mobile_bar_item filter_mobile">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
            </div>
            <div class="mobile_bar_item map_wrapper_mobile">
                <i class="fas fa-map-marked-alt"></i>
                <span>Map</span>
            </div>
        </div>
        <div class="search_top">
            <div class="destination_header_wrapper">
                <span class="destination_header">{{ $m->destination}} </span>
                <span class="sort_by">Sort by:</span>
            </div>
            <div class="map_wrapper">
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
                    <span>Top Deals</span>
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

            @for ($i = 0; $i < $nr_results; $i++)
                <div class="hotelbox">
                    <div class="hotel_photo">
                        <a class="link" href='hotel?hotel_id={{ $hotel[$i]->id}}&m={{json_encode($m)}}'
                            target="_blank">
                        <img src={{ $hotel[$i]->search_cover_photo}}
                            class="search_cover_photo loading_image" alt="hotel_cover" data-hotel-id={{ $hotel[$i]->id }}
                            data-index=1 data-type-index=0 onerror=image_error(this) />
                        </a>
                    </div>
                    <div class="hotel_content">
                        <div class="hotel_head">
                            <a class="link_name"
                                href='hotel?hotel_id={{ $hotel[$i]->id}}&m={{json_encode($m)}}'
                                target="_blank">
                                <div class="name">{{ $hotel[$i]->name}}
                                    <div class="stars">
                                        {{ $hotel[$i]->stars_symbol}}
                                    </div>
                                </div>
                            </a>
                            <div class="quality_score_wrapper">
                                <div class="quality_nr_reviews">
                                    <span class="quality">{{ $hotel[$i]->quality}}</span>
                                    <span class="nr_reviews">{{ $hotel[$i]->nr_reviews}} reviews</span>
                                </div>
                                <div class="score_wrapper">
                                    <img src={{ asset('images/search/tripadvisor_logo.png') }} alt="tripadvisor_logo">
                                    <span class="score"><strong
                                            class="score_value">{{ number_format($hotel[$i]->score, 1)}}</strong>/5.0</span>
                                </div>
                            </div>
                        </div>
                        <div class="address_wrapper">
                            <span class="district">{{ $hotel[$i]->district}}</span>
                            <span class="city">{{ $hotel[$i]->city}}</span>
                            <span class="address_separator">.</span>
                            <span class="distance_center"> {{ $hotel[$i]->distance_center}}</span>
                        </div>
                        <div class="hotel_room">
                            <a class="link" href='hotel?hotel_id={{ $hotel[$i]->id }}&m={{json_encode($m)}}'
                                target="_blank">
                                <div class="room_title">
                                    <div class="room_name">{{ $hotel[$i]->room_number}} x {{ $hotel[$i]->room_name}}
                                        <div class="room_guests_icon">
                                            <span class="room_separator">-</span>
                                            @if(($m->adults_per_room + $m->children_per_room)  > 3)
                                            <i class="fas fa-user"></i>
                                            <span class="guests_multiplier">x {{($m->adults_per_room + $m->children_per_room)}}</span>
                                            @else
                                            @for ($g = 0; $g < ($m->adults_per_room + $m->children_per_room); $g++)
                                                <i class="fas fa-user"></i>
                                            @endfor
                                            @endif
                                        </div>
                                    </div>
                                    <div class="nights_guests">
                                        <span class="nights">{{ $m->nights_text}}</span>
                                        <span>, </span>
                                        <span class="adults">{{ $m->adults > 1 ? $m->adults . " adults" : $m->adults . " adult"   }}</span>
                                        <span class="children">{{ $m->children > 1 ? ", " . $m->children . " children" : ($m->children == 1 ? ", " . $m->children . " child" : "") }}</span>
                                    </div>
                                </div>
                                <div class="rate_wrapper">
                                    <div class="rate_left">
                                        {{-- <span class="bed_type">{{ $hotel[$i]->bed_type}}</span> --}}
                                        <div class="room_policy">
                                            <span class="board">{{$hotel[$i]->board == "Room Only" ? "" : $hotel[$i]->board}}</span>
                                        </div>
                                        <div class="room_policy">
                                            <span class="cancellation_policy">{{ $hotel[$i]->cancellation_policy == "NRF" ? "" :  "Free Cancellation"}}</span>
                                        </div>
                                    </div>
                                    <span class="price">{{ $hotel[$i]->price}}</span>
                                </div>
                            </a>
                        </div>
                        <div class="hotel_book">
                            <a class="link"
                                href='hotel?hotel_id={{ $hotel[$i]->id}}&m={{json_encode($m)}}'
                                target="_blank">
                                <button>Select Room</button>
                            </a>
                        </div>
                    </div>
                    @isset($hotel[$i]->pick_score)
                        <div class="deal_wrapper">
                            <meter min="0" low="33" high="66" max="100" optimum="100"
                                value={{ $hotel[$i]->pick_score }}></meter>
                            <div class="pick_tittle">
                                <span class="hotel_bold">Deal</span>
                                {{-- <span class="mind_green">Mind</span>
                                <span class="mind_register">&#174</span>  --}}
                                <span class="score_text">Score</span>
                            </div>
                            <span class="pick_score">{{ round($hotel[$i]->pick_score) }}%</span>

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
        <div class="no_results_wrapper {{empty($hotel) ? "no_results_filter_show" :""}}">
            <img class="no_results_icon" src="./images/search/information_icon.jpg" alt="page_end_icon">
            <span class="no_results_message">There are no more properties that match your search criteria.</span>
        </div>
    </div>
@endsection

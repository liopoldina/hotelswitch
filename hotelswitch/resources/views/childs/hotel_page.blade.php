@section('left_hotel')
<div id="hotel_left">
    <div class="hp_location">
        <div class="hp_map_wrapper" id="map_wrapper">
            <div class="hp_position_icon">
                <i class="fas fa-map-marker-alt fa-2x"></i>
            </div>
            <div class="hp_map_text">
                <span>Hotel Location</span>
            </div>
        </div>
        <div class="hp_location_rating">
            <div class="hp_location_score">
                <span>9.0</span>
            </div>
            <div class="hp_location_quality_wrapper">
                <span class="hp_location_quality">Exceptional</span>
                <span class="hp_location_text">Location rating score</span>
            </div>
        </div>
        <div class="hp_location_item">
            <i class="fas fa-medal gold"></i>
            <span><strong class="gold_background">Exceptional location</strong> - Downtown
            </span>
        </div>
        <div class="hp_location_item">
            <i class="fas fa-building red"></i>
            <span><strong>Popular neighborhood</strong></span>
        </div>
        <div class="hp_location_divider"></div>
        <span class="hp_points_tittle">Points of Interest</span>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Rossio Square</span>
            <span class="hp_point_distance">250 m</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Santa Justa Elevator</span>
            <span class="hp_point_distance">440 m</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Castelo de São Jorge</span>
            <span class="hp_point_distance">650 m</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Miradouro da Senhora do Monte</span>
            <span class="hp_point_distance">710 m</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Praca do Comercio</span>
            <span class="hp_point_distance">990 m</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Alfama</span>
            <span class="hp_point_distance">1.22 km</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Museu Calouste Gulbenkian</span>
            <span class="hp_point_distance">2.7 km</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Lisbon Oceanarium</span>
            <span class="hp_point_distance">250 m</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Jeronimos Monastery</span>
            <span class="hp_point_distance">6.08 km</span>
        </div>
        <div class="hp_point_of_interest">
            <span class="hp_point_name">Torre de Belém</span>
            <span class="hp_point_distance">7.08 km</span>
        </div>
    </div>
</div>
@endsection

@section('right_hotel')
<div id=hotel_page class="right">
    <div class="hp_top_bar">
        <a href="#availability">Info & Prices</a>
        <a href="#facilities">Facilities</a>
        <a href="#houserules">Hotel Policies</a>
        <a href="#houserules">Guest reviews</a>
    </div>
    <div class="hp_head">
        <div class="hp_head_tittle">
            <div class="hp_tittle">
                <span class="hp_name">{{$h->name ?? 'Hotel Royal Sample'}}</span>
                <div class="hp_stars_wrapper">
                    <span class="hp_stars">{{$h->stars_symbol  ?? '★★★★★'}}</span>
                </div>
            </div>
            <div class="hp_address">
                <i class="fas fa-map-marker-alt hp_map_icon" aria-hidden="true"></i>
                <span class="hp_address_content">{{$h->address ?? 'Av. D. João II, n.º 27, Parque das Nações, Lisboa,
                    1990-083, Portugal'}}</span>
                <span>-</span>
                <span class="hp_see_map">See Map</span>
            </div>
            <div class="hp_distance_center">
                <span class="hp_distance_center_content">{{ $h->distance_center  ?? '355 m from city center'}}
                </span>
            </div>
            <div class="hp_spotlight_wrapper">
                <div class="hp_spotlight">
                    <i class="fas fa-hand-sparkles green" aria-hidden="true"></i><span>Excellent
                        Cleanliness</span>
                </div>
                <div class="hp_spotlight">
                    <i class="fas fa-wifi green" aria-hidden="true"></i><span>Free Wi-fi</span>
                </div>
                <div class="hp_spotlight">
                    <i class="far fa-building green" aria-hidden="true"></i><span>City center</span>
                </div>
            </div>
        </div>
        <div class="hp_head_book">
            <div class="hp_nightly_price">
                <span class="hp_header_price">€
                    {{isset($h) ? intval($h->offer[0]["rates"][0]["net"])/$h->nights : '99' }}</span>
            </div>
            <div class="hp_head_nightly_text">
                <span>nightly price per room</span>
            </div>
            <div class="hp_total_price">
                <strong
                    class="hp_total_price_text">{{isset($h) ? intval($h->offer[0]["rates"][0]["net"]) : '198' }}€</strong>
                <span class="hp_header_nights">for {{isset($h) ? $h->nights_text : 'for 2 nights'}}</span>
            </div>
            <div class="hp_head_button">
                <a href="">
                    <button>Reserve</button>
                </a>
            </div>
        </div>
    </div>
    <div class="hp_gallery">
        <div class="hp_slideshow">
            <div class="hp_slide">
                <img id=slide
                    src={{isset($h) ? $h->images[0] : 'http://photos.hotelbeds.com/giata/bigger/36/363373/363373a_hb_a_002.jpg' }}
                    alt="">
            </div>
            <div class="arrow_left">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="arrow_right">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
        <div class="hp_slides_index">
            @isset($h)
            @for ($i=0; $i < count($h->images_min); $i++)<div class="hp_min_slide"><img class="hp_slide_img"
                        src={{$h->images_min[$i]}} alt="" main={{$h->images[$i]}} index={{$i}}>
                </div>@endfor
                @endisset
        </div>
        <div class="hp_hotel_review">
            <div class="quality_number">
                <div class="quality_wrapper">
                    <span class="quality">{{$h->quality ?? 'Very Good'}}</span>
                </div>
                <div class="nr_reviews_wrapper">
                    <span class="nr_reviews">{{$h->nr_reviews ?? '1423'}}</span>
                    <span>reviews</span>
                </div>
            </div>
            <div class="score_wrapper">
                <span class="score">{{$h->score ?? '8'}}</span>
            </div>
        </div>
    </div>
    <div class="hp_description_wrapper">
        <div class="hp_description">
            <div class="hp_description_tittle">
                <span>Stay in the heart of Lisbon</span>
            </div>
            <div class="hp_descrition_text">

                @if(isset($h))

                @foreach ($h->paragraphs as $paragraph)
                <p>{{ $paragraph }}</p>
                @endforeach

                @else
                <p>The Luxe Hotel, located in Lisbon’s historical centre, is close to Anjos Metro Station
                    and downtown Lisbon is within walking distance. Free Wi-Fi is offered throughout the
                    property.</p>
                <p>Luxe Hotel By Turim Hoteis offers contemporary rooms decorated with chic furnishings and
                    earthy colours. Each has satellite TV and modern bathrooms.</p>
                <p>Guests can enjoy a daily continental breakfast at the Luxe Hotel By Turin Hoteis. The
                    hotel also features a bar.</p>
                <p>Eduardo VII Park and Liberty Avenue are both less than 2 km from Hotel Luxe. At the
                    24-hour front desk, guests can ask for more information about the local area.</p>
                <p>We speak your language!</p>
                @endif

            </div>
        </div>
        <div class="hp_top_facilities">
            <span class="hp_top_facilities_tittle">Most popular facilities
            </span>
            <div class="hp_top_facility">
                <i class="fas fa-wifi green"></i><span>Free Wi-fi</span>
            </div>
            <div class="hp_top_facility">
                <i class="fas fa-parking blue"></i><span>Private parking</span>
            </div>
            <div class="hp_top_facility ">
                <i class="fas fa-concierge-bell gold"></i><span>Room service</span>
            </div>
            <div class="hp_top_facility ">
                <i class="fas fa-utensils"></i><span>Restaurant</span>
            </div>
            <div class="hp_top_facility ">
                <i class="fas fa-smoking-ban"></i><span>Non-smoking rooms</span>
            </div>
            <a href="#facilities">
                <button>See All Facilities</button>
            </a>
        </div>

    </div>

    <div class="hp_availability" id="availability">
        <div class="hp_section_tittle">
            <span>Choose your room</span>
        </div>
        <div class="hp_search">
            <div class="hp_dates_wrapper hp_search_box">
                <div class="hp_dates_box">
                    <div class="hp_box_wrapper">
                        <div class="hp_box_title"><span>Check-in</span></div>
                        <div class="hp_box_text"><span class="hp_box_check_in">{{$h->check_in ?? '2020-07-22'}}</span>
                        </div>
                    </div>
                </div>
                <div class="hp_dates_box hp_box_divider">
                    <div class="hp_box_wrapper">
                        <div class="hp_box_title"><span>Checkout</span></div>
                        <div class="hp_box_text"><span class="hp_box_check_out">{{$h->check_out ?? '2020-07-25'}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hp_guests_wrapper hp_search_box">
                <div class="hp_box_wrapper">
                    <div class="hp_box_title"><span>Guests</span></div>
                    <div class="hp_box_text"><span
                            class="hp_box_guests">{{isset($h) ? $h->rooms_text . ", " . $h->adults_text  : '1 room, 2 adults'}}</span>
                    </div>
                </div>
            </div>
            <div class="hp_update_wrapper hp_search_box">
                <button>Update prices</button>
            </div>
        </div>
        <div class="hp_rooms_header">
            <div class="hp_header_box hp_header_room_type">
                <span>Room Type</span>
            </div>
            <div class="hp_header_box hp_header_offers">
                <span>Your Choices</span>
            </div>

            <div class="hp_header_box hp_header_select_rooms">
                <span>Select Rooms</span>
            </div>
        </div>
        <div class="hp_room">
            <div class="hp_room_wrapper">
                @if(isset($h))
                @for($r=0; $r<count($h->offer); $r++)
                    <div class="hp_room_content">
                        <div class="hp_room_type">
                            <div class="hp_room_image">
                                <img class="hp_room_img"
                                    src="http://photos.hotelbeds.com/giata/bigger/{{$h->offer[$r]["images"][0]["path"]}}"
                                    alt="">
                            </div>
                            <div class="hp_room_name">
                                <span class="room_name">{{MyLibrary::titleCase($h->offer[$r]["name"])}}</span>
                            </div>
                            <div class="hp_room_capacity">
                                <div class="room_guests_icon">
                                    @for($g=0; $g < $h->adults; $g++)
                                        <img src="./images/search/guest_icon.png" alt="guest_icon">
                                        @endfor
                                </div>
                                <span class="hp_offer_guests">{{$h->adults_text}}</span>
                            </div>
                            <div class="hp_more_details">
                                <span>See room details</span>
                            </div>
                            <div class="hp_amenity">
                                <i class="fas fa-wifi"></i>
                                <span>Wi-fi</span>
                            </div>
                            <div class="hp_amenity">
                                <i class="fas fa-fan"></i> <span>Air conditioning</span>
                            </div>
                            <ul class="hp_room_ul">
                                <li class="hp_room_li_price">The price shown is the final price for {{$h->nights_text}}
                                </li>
                                <li><strong>VAT already included</strong></li>
                                @isset($h->tourist_tax)
                                <li class="hp_tourist_tax">At the accommodation you will have to pay the
                                    touristic tax of €{{$h->tourist_tax }} per night not included in the price.</li>
                                @endisset
                            </ul>
                        </div>
                        <div class="hp_room_offers">
                            @for ($i=0; $i<count($h->offer[$r]["rates"]); $i++)
                                <div class="hp_room_offer">
                                    <div class="hp_room_total">
                                        <span class="hp_room_total_price">€
                                            {{intval($h->offer[$r]["rates"][$i]["net"])}}</span>
                                    </div>
                                    <div class="hp_room_nights">
                                        <span class='hp_nights_text'>for {{$h->nights_text}}</span>
                                    </div>
                                    @if($h->offer[$r]["rates"][$i]["boardName"] == 'BED AND BREAKFAST')
                                    <div class="hp_offer hp_breakfast_included" name="board">
                                        <i class="fas fa-coffee" name="board_icon"></i>
                                        <span class="hp_board_name">Breakfast included</span>
                                    </div>
                                    @else
                                    <div class="hp_offer" name="board">
                                        <i class="fas fa-bed" name="board_icon"></i>
                                        <span
                                            class="hp_board_name">{{MyLibrary::titleCase($h->offer[$r]["rates"][$i]["boardName"])}}</span>
                                    </div>
                                    @endif
                                    @if(MyLibrary::titleCase($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"])
                                    == 'Free cancellation')
                                    <div class="hp_offer hp_refundable" name="policy">
                                        <i class="fas fa-bookmark"></i>
                                        <span
                                            class="hp_policy">{{MyLibrary::titleCase($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"])}}</span>
                                    </div>
                                    @else
                                    <div class="hp_offer" name="policy">
                                        <i class="fas fa-bookmark"></i>
                                        <span
                                            class="hp_policy">{{MyLibrary::titleCase($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"])}}</span>
                                    </div>
                                    @endif
                                    @if($h->offer[$r]["rates"][$i]["allotment"] <= 5) <div
                                        class="hp_offer hp_rooms_left" name="rooms_left">
                                        <i class="fas fa-bell"></i>
                                        <span class="hp_rooms_left">Only {{$h->offer[$r]["rates"][$i]["allotment"]}}
                                            rooms left</span>
                                </div>
                                @endif
                        </div>
                        @endfor
                    </div>
                    <div class="hp_select_rooms">
                        @for ($i=0; $i<count($h->offer[$r]["rates"]); $i++)
                            <div class="hp_room_offer_select">
                                <select class="hp_nr_rooms" type="text" name="nr_rooms">
                                    @if (isset($h))
                                    @for ($n=1; $n <= $h->offer[$r]["rates"][$i]["allotment"]; $n++)
                                        <option value={{$n}}>{{$n}}</option>

                                        @endfor

                                        @else
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        @endif
                                </select>
                            </div>
                            @endfor
                    </div>
            </div>
            @endfor

            @else
            <div class="hp_room_content">
                <div class="hp_room_type">
                    <div class="hp_room_image">
                        <img class="hp_room_img"
                            src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/76168891.jpg?k=070d49a1fe9b29714fb19f97f6bfa5a942f9077d1caf048018dc1ba7fe3a35b0&o="
                            alt="">
                    </div>
                    <div class="hp_room_name">
                        <span class="room_name">Double Standard</span>
                    </div>
                    <div class="hp_room_capacity">
                        <div class="room_guests_icon">
                            <img src="./images/search/guest_icon.png" alt="guest_icon">
                            <img src="./images/search/guest_icon.png" alt="guest_icon">
                        </div>
                        <span class="hp_offer_guests">2 adults</span>
                    </div>
                    <div class="hp_more_details">
                        <span>See room details</span>
                    </div>
                    <div class="hp_amenity">
                        <i class="fas fa-wifi"></i>
                        <span>Wi-fi</span>
                    </div>
                    <div class="hp_amenity">
                        <i class="fas fa-fan"></i> <span>Air conditioning</span>
                    </div>
                    <ul class="hp_room_ul">
                        <li class="hp_room_li_price">The price shown is the final price for 2 nights
                        </li>
                        <li><strong>VAT already included</strong></li>
                        <li class="hp_tourist_tax">At the accommodation you will have to pay the
                            touristic tax of €2 per night not included in the price.</li>
                    </ul>
                </div>
                <div class="hp_room_offers">
                    <div class="hp_room_offer">
                        <div class="hp_room_total">
                            <span class="hp_room_total_price">€ 198</span>
                        </div>
                        <div class="hp_room_nights">
                            <span class='hp_nights_text'>for 2 nights</span>
                        </div>
                        <div class="hp_offer" name="board">
                            <i class="fas fa-bed" name="board_icon"></i>
                            <span class="hp_board_name">Room only</span>
                        </div>
                        <div class="hp_offer" name="policy">
                            <i class="fas fa-bookmark"></i>
                            <span class="hp_policy">Non-refundable rate</span>
                        </div>
                        <div class="hp_offer hp_rooms_left" name="rooms_left">
                            <i class="fas fa-bell"></i>
                            <span class="hp_rooms_left">Only 4 rooms left</span>
                        </div>
                    </div>
                    <div class="hp_room_offer">
                        <div class="hp_room_total">
                            <span class="hp_room_total_price">€ 228</span>
                        </div>
                        <div class="hp_room_nights">
                            <span class='hp_nights_text'>for 2 nights</span>
                        </div>
                        <div class="hp_offer hp_breakfast_included">
                            <i class="fas fa-coffee"></i>
                            <span class="hp_board_name">Breakfast included</span>
                        </div>
                        <div class="hp_offer hp_refundable">
                            <i class="fas fa-bookmark"></i>
                            <span class="hp_policy">Free cancellation</span>
                        </div>
                        <div class="hp_offer hp_rooms_left">
                            <i class="fas fa-bell"></i>
                            <span class="hp_rooms_left">Only 4 rooms left</span>
                        </div>
                    </div>
                </div>
                <div class="hp_select_rooms">
                    <div class="hp_room_offer_select">
                        <select class="hp_nr_rooms" type="text" name="nr_rooms">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="hp_room_offer_select">
                        <select class="hp_nr_rooms" type="text" name="nr_rooms">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="hp_room_content">
                <div class="hp_room_type">
                    <div class="hp_room_image">
                        <img class="hp_room_img"
                            src="https://cf.bstatic.com/xdata/images/hotel/max1024x768/68967572.jpg?k=03c826bff712d342618947560b97f1de9ef26f0ec33cf079ce00c44b80fc7d04&o="
                            alt="">
                    </div>
                    <div class="hp_room_name">
                        <span class="room_name">Double Classic</span>
                    </div>
                    <div class="hp_room_capacity">
                        <div class="room_guests_icon">
                            <img src="./images/search/guest_icon.png" alt="guest_icon">
                            <img src="./images/search/guest_icon.png" alt="guest_icon">
                        </div>
                        <span class="hp_offer_guests">2 adults</span>
                    </div>
                    <div class="hp_more_details">
                        <span>See room details</span>
                    </div>
                    <div class="hp_amenity">
                        <i class="fas fa-wifi"></i>
                        <span>Wi-fi</span>
                    </div>
                    <div class="hp_amenity">
                        <i class="fas fa-fan"></i> <span>Air conditioning</span>
                    </div>
                    <ul class="hp_room_ul">
                        <li class="hp_room_li_price">The price shown is the final price for 2 nights
                        </li>
                        <li><strong>VAT already included</strong></li>
                        <li class="hp_tourist_tax">At the accommodation you will have to pay the
                            touristic tax of €2 per night not included in the price.</li>
                    </ul>
                </div>
                <div class="hp_room_offers">
                    <div class="hp_room_offer">
                        <div class="hp_room_total">
                            <span class="hp_room_total_price">€ 248</span>
                        </div>
                        <div class="hp_room_nights">
                            <span class='hp_nights_text'>for 2 nights</span>
                        </div>
                        <div class="hp_offer" name="board">
                            <i class="fas fa-bed" name="board_icon"></i>
                            <span class="hp_board_name">Room only</span>
                        </div>
                        <div class="hp_offer" name="policy">
                            <i class="fas fa-bookmark"></i>
                            <span class="hp_policy">Non-refundable rate</span>
                        </div>
                        <div class="hp_offer hp_rooms_left" name="rooms_left">
                            <i class="fas fa-bell"></i>
                            <span class="hp_rooms_left">Only 2 rooms left</span>
                        </div>
                    </div>
                    <div class="hp_room_offer">
                        <div class="hp_room_total">
                            <span class="hp_room_total_price">€ 278</span>
                        </div>
                        <div class="hp_room_nights">
                            <span class='hp_nights_text'>for 2 nights</span>
                        </div>
                        <div class="hp_offer hp_breakfast_included">
                            <i class="fas fa-coffee"></i>
                            <span class="hp_board_name">Breakfast included</span>
                        </div>
                        <div class="hp_offer hp_refundable">
                            <i class="fas fa-bookmark"></i>
                            <span class="hp_policy">Free cancellation</span>
                        </div>
                        <div class="hp_offer hp_rooms_left">
                            <i class="fas fa-bell"></i>
                            <span class="hp_rooms_left">Only 2 rooms left</span>
                        </div>
                    </div>
                </div>
                <div class="hp_select_rooms">
                    <div class="hp_room_offer_select">
                        <select class="hp_nr_rooms" type="text" name="nr_rooms">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="hp_room_offer_select">
                        <select class="hp_nr_rooms" type="text" name="nr_rooms">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="hp_room_reserve">
            <a href="book">
                <button>I'll reserve</button>
            </a>
            <ul>
                <li>Confirmation is immediate</li>
                <li>No registration required
                </li>
                <li>No booking or credit card fees!</li>
            </ul>
        </div>
    </div>
</div>
<div class="hp_facilities" id="facilities">
    <div class="hp_section_tittle">
        <span>Hotel Facilities</span>
    </div>
    <div class="hp_facilities_wrapper">

        @if(isset($h))

        @php
        $keys = array_keys($h->facilities);
        @endphp

        @for ($i=0; $i < count($h->facilities); $i++)
            @if (!empty($h->facilities[$keys[$i]]))
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class='{{$h->icons->facility_groups[$i]}}'></i><span>{{$keys[$i]}}</span>
                </div>
                <ul class="facilities_list">
                    @foreach ($h->facilities[$keys[$i]] as $li)
                    <li>{{$li}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @endfor

            @else

            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-bath"></i><span>Bathroom</span>
                </div>
                <ul class="facilities_list">
                    <li>Toilet paper</li>
                    <li>Towels</li>
                    <li>Bathtub or shower</li>
                    <li>Private Bathroom</li>
                    <li>Toilet</li>
                    <li>Free toiletries</li>
                    <li>Hairdryer</li>
                    <li>Shower</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-bed"></i><span>Bedroom</span>
                </div>
                <ul class="facilities_list">
                    <li>Linens</li>
                    <li>Wardrobe or closet</li>
                </ul>
            </div>

            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-mountain"></i><span>View</span>
                </div>
                <ul class="facilities_list">
                    <li>View</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-cloud-sun"></i><span>Outdoors</span>
                </div>
                <ul class="facilities_list">
                    <li>Patio</li>
                    <li>Terrace</li>
                    <li>Garden</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-blender"></i><span>Kitchen</span>
                </div>
                <ul class="facilities_list">
                    <li>Electric kettle</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-bed"></i><span>Room Amenities</span>
                </div>
                <ul class="facilities_list">
                    <li>Socket near the bed</li>
                    <li>Clothes rack</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-concierge-bell"></i><span>Services & Extras</span>
                </div>
                <ul class="facilities_list">
                    <li>Tickets to shows/attractions</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-paw"></i><span>Pets</span>
                </div>
                <ul class="facilities_list">
                    <li>Pets are not allowed</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-couch"></i><span>Living Area</span>
                </div>
                <ul class="facilities_list">
                    <li>Sitting area</li>
                    <li>Desk</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-snowboarding"></i><span>Activities</span>
                </div>
                <ul class="facilities_list">
                    <li>Table tennis</li>
                    <li>Windsurfing</li>
                    <li>Diving</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-tv"></i><span>Media & Technology</span>
                </div>
                <ul class="facilities_list">
                    <li>Flat-screen TV</li>
                    <li>Cable channels</li>
                    <li>Satellite channels</li>
                    <li>Radio</li>
                    <li>Telephone</li>
                    <li>TV</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-utensils"></i><span>Food & Drink</span>
                </div>
                <ul class="facilities_list">
                    <li>Chocolate/Cookies</li>
                    <li>Bottle of water</li>
                    <li>Tea/Coffee maker</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-wifi"></i><span>Internet</span>
                </div>
                <ul class="facilities_list">
                    <li>Free WiFi</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-parking"></i><span>Parking</span>
                </div>
                <ul class="facilities_list">
                    <li>Accessible parking</li>
                    <li>Electric vehicle charging station</li>
                    <li>Parking garage</li>
                    <li>Secure parking</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-bus-alt"></i><span>Transportation</span>
                </div>
                <ul class="facilities_list">
                    <li>Airport drop-off</li>
                    <li>Airport pickup</li>
                    <li>Public transit tickets</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-concierge-bell"></i><span>Front Desk Services</span>
                </div>
                <ul class="facilities_list">
                    <li>Baggage storage</li>
                    <li>Tour desk</li>
                    <li>24-hour front desk</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-users"></i><span>Entertainment & Family Services</span>
                </div>
                <ul class="facilities_list">
                    <li>Kids' TV channels</li>
                    <li>Babysitting/Child services</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-hand-sparkles"></i><span>Cleaning Services</span>
                </div>
                <ul class="facilities_list">
                    <li>Daily housekeeping</li>
                    <li>Shoeshine</li>
                    <li>Ironing service</li>
                    <li>Dry cleaning </li>
                    <li>Laundry</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-briefcase"></i><span>Business Facilities</span>
                </div>
                <ul class="facilities_list">
                    <li>Fax/Photocopying </li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-lock"></i><span>Safety & security</span>
                </div>
                <ul class="facilities_list">
                    <li>Fire extinguishers</li>
                    <li>CCTV in common areas</li>
                    <li>Smoke alarms</li>
                    <li>Security alarm</li>
                    <li>24-hour security</li>
                    <li>Safe</li>

                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-spa"></i><span>Wellness facilities</span>
                </div>
                <ul class="facilities_list">
                    <li>Spa Facilities</li>
                    <li>Outdoor pool</li>
                    <li>Massage</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-info-circle"></i><span>General</span>
                </div>
                <ul class="facilities_list">
                    <li>Shuttle service</li>
                    <li>Convenience store (on site)</li>
                    <li>Shared lounge/TV area</li>
                    <li>Airport shuttle</li>
                    <li>Shuttle service</li>
                    <li>Designated smoking area</li>
                    <li>Air conditioning</li>
                    <li>Smoke-free property</li>
                    <li>Hypoallergenic room available</li>
                    <li>Shops (on site)</li>
                    <li>Wake-up service</li>
                    <li>Heating</li>
                    <li>Soundproof</li>
                    <li>Private entrance</li>
                    <li>Car rental</li>
                    <li>Soundproof rooms</li>
                    <li>Elevator</li>
                    <li>Heating</li>
                    <li>Family rooms</li>
                    <li>Facilities for disabled guests</li>
                    <li>Non-smoking rooms</li>
                    <li>Iron</li>
                    <li>Newspapers</li>
                    <li>Wake-up service/Alarm clock</li>
                    <li>Air conditioning</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-wheelchair"></i></i><span>Accessibility</span>
                </div>
                <ul class="facilities_list">
                    <li>Bathroom emergency cord</li>
                    <li>Toilet with grab rails</li>
                    <li>Wheelchair accessible</li>
                    <li>Entire unit wheelchair accessible</li>
                    <li>Upper floors accessible by elevator</li>
                </ul>
            </div>
            <div class="hp_facilities_group">
                <div class="hp_facilitites_tittle">
                    <i class="fas fa-language"></i></i><span>Languages Spoken</span>
                </div>
                <ul class="facilities_list">
                    <li>English</li>
                    <li>Spanish</li>
                    <li>French</li>
                    <li>Portuguese</li>
                    <li>Romanian</li>
                    <li>Russian</li>
                </ul>
            </div>
            @endif

    </div>
</div>
<div class="hp_house_rules" id="houserules">
    <div class="hp_section_tittle">
        <span>Hotel Policies</span>
    </div>


    @if(isset($h))

    @php
    $keys = array_keys($h->policies);
    @endphp

    @for ($i=0; $i < count($h->policies)-1; $i++)

        <div class="hp_rule">
            <div class="hp_rule_tittle">
                <i class='{{$h->icons->policies[$i]}}'></i><span>{{$keys[$i]}}</span>
            </div>
            <div class="hp_rule_content">
                @foreach ($h->policies[$keys[$i]] as $span)
                <span>{{$span}}</span>
                @endforeach
            </div>
        </div>

        @endfor

        @else
        <div class="hp_rule">
            <div class="hp_rule_tittle">
                <i class="far fa-clock fa-lg"></i><span>Check-in and check-out</span>
            </div>
            <div class="hp_rule_content">
                <span>Check-in from 14:00</span>
                <span>Check-out time: before 12:00</span>
            </div>
        </div>
        <div class="hp_rule">
            <div class="hp_rule_tittle">
                <i class="fas fa-info-circle fa-lg"></i><span>Cancellation/Prepayment
                </span>
            </div>
            <div class="hp_rule_content">
                <span>You can find more information on the terms of cancellation or prepayment in the
                    booking terms of the rate you've chosen.
                </span>
            </div>
        </div>
        <div class="hp_rule">
            <div class="hp_rule_tittle">
                <i class="fas fa-child fa-lg"></i><span>Children and beds</span>
            </div>
            <div class="hp_rule_content">
                <span>Children of any age are welcome.</span>
                <span>Children aged 12 years and above are considered adults at this property.</span>
                <span>To see correct prices and occupancy information, please add the number of children in
                    your group and their ages to your search.</span>
            </div>
        </div>
        <div class="hp_rule">
            <div class="hp_rule_tittle">
                <i class="fas fa-utensils fa-lg"></i><span>Meals</span>
            </div>
            <div class="hp_rule_content">
                <span>Price of an additional breakfast: 8.00 EUR per person. Information about the type of
                    meals included in the price is indicated in the rate details.</span>
            </div>
        </div>
        <div class="hp_rule">
            <div class="hp_rule_tittle">
                <i class="fas fa-paw fa-lg"></i><span>Pets</span>
            </div>
            <div class="hp_rule_content">
                <span>Pets are not allowed.</span>
            </div>
        </div>
        @endif
        <div class="hp_rule">
            <div class="hp_rule_tittle">
                <i class="far fa-credit-card fa-lg"></i><span>Cards accepted</span>
            </div>
            <div class="hp_rule_content">
                @if(isset($h))

                @for ($i=0; $i < count($h->policies["Cards accepted"]); $i++)<i
                        class="{{$h->icons->cards[$h->policies["Cards accepted"][$i]]}}"></i>@endfor

                    @else
                    <i class="fab fa-cc-visa fa-2x"></i>
                    <i class="fab fa-cc-mastercard fa-2x"></i>
                    <i class="fab fa-cc-amex fa-2x"></i>
                    <i class="fab fa-cc-jcb fa-2x"></i>
                    <i class="fab fa-cc-discover fa-2x"></i>
                    @endif
            </div>
        </div>
</div>
</div>
@endsection

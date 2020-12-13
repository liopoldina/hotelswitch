@section('left_hotel')
    <div id="hotel_left">
        <div class="location">
            <div class="map_wrapper" id="map_wrapper">
                <div class="position_icon">
                    <i class="fas fa-map-marker-alt fa-2x"></i>
                </div>
                <div class="map_text">
                    <span>Hotel Location</span>
                </div>
            </div>
            <div class="location_rating">
                <div class="location_score">
                    <span>9.0</span>
                </div>
                <div class="location_quality_wrapper">
                    <span class="location_quality">Exceptional</span>
                    <span class="location_text">Location rating score</span>
                </div>
            </div>
            <div class="location_item">
                <i class="fas fa-medal gold"></i>
                <span><strong class="gold_background">Exceptional location</strong> - Downtown
            </span>
            </div>
            <div class="location_item">
                <i class="fas fa-building red"></i>
                <span><strong>Popular neighborhood</strong></span>
            </div>
            <div class="location_divider"></div>
            <span class="points_tittle">Points of Interest</span>
            <div class="point_of_interest">
                <span class="point_name">Rossio Square</span>
                <span class="point_distance">250 m</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Santa Justa Elevator</span>
                <span class="point_distance">440 m</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Castelo de São Jorge</span>
                <span class="point_distance">650 m</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Miradouro da Senhora do Monte</span>
                <span class="point_distance">710 m</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Praca do Comercio</span>
                <span class="point_distance">990 m</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Alfama</span>
                <span class="point_distance">1.22 km</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Museu Calouste Gulbenkian</span>
                <span class="point_distance">2.7 km</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Lisbon Oceanarium</span>
                <span class="point_distance">250 m</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Jeronimos Monastery</span>
                <span class="point_distance">6.08 km</span>
            </div>
            <div class="point_of_interest">
                <span class="point_name">Torre de Belém</span>
                <span class="point_distance">7.08 km</span>
            </div>
        </div>
    </div>
@endsection

@section('right_hotel')
    <div id=hotel_page class="right_content">
        <div class="top_bar">
            <a href="#availability">Info & Prices</a>
            <a href="#facilities">Facilities</a>
            <a href="#houserules">Hotel Policies</a>
            <a href="#houserules">Guest reviews</a>
        </div>
        <div class="head">
            <div class="head_tittle">
                <div class="tittle">
                    <span class="name">{{$h->name ?? 'Hotel Royal Sample'}}</span>
                    <div class="stars_wrapper">
                        <span class="stars">{{$h->stars_symbol  ?? '★★★★★'}}</span>
                    </div>
                </div>
                <div class="address">
                    <i class="fas fa-map-marker-alt map_icon" aria-hidden="true"></i>
                    <span class="address_content">{{$h->address ?? 'Av. D. João II, n.º 27, Parque das Nações, Lisboa,
                    1990-083, Portugal'}}</span>
                    <span>-</span>
                    <span class="see_map">See Map</span>
                </div>
                <div class="distance_center">
                <span class="distance_center_content">{{ $h->distance_center  ?? '355 m from city center'}}
                </span>
                </div>
                <div class="spotlight_wrapper">
                    <div class="spotlight">
                        <i class="fas fa-hand-sparkles green" aria-hidden="true"></i><span>Excellent
                        Cleanliness</span>
                    </div>
                    <div class="spotlight">
                        <i class="fas fa-wifi green" aria-hidden="true"></i><span>Free Wi-fi</span>
                    </div>
                    <div class="spotlight">
                        <i class="far fa-building green" aria-hidden="true"></i><span>City center</span>
                    </div>
                </div>
            </div>
            <div class="head_map" id="map_wrapper">
                <div class="head_map_icon">
                    <i class="fas fa-map-marker-alt fa-lg" aria-hidden="true"></i>
                </div>
                <div class="map_text">
                    <span>Map</span>
                </div>
            </div>
            @if(isset($h->offer))
                <div class="head_book">
                    <div class="nightly_price"><span class="header_price">€
                    {{isset($h) ? round(intval($h->offer[0]["rates"][0]["sellingRate"])/$h->nights) : '99' }}</span>
                    </div>
                    <div class="head_nightly_text">
                        <span>nightly price per room</span>
                    </div>
                    <div class="total_price">
                        <strong
                            class="total_price_text">{{isset($h) ? intval($h->offer[0]["rates"][0]["sellingRate"]) : '198' }}
                            €</strong>
                        <span class="header_nights">for {{isset($h) ? $h->nights_text : 'for 2 nights'}}</span>
                    </div>
                    <div class="head_button">
                        <a href="">
                            <button>Reserve</button>
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <div class="gallery">
            <div class="slideshow">
                <div class="slide">
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
            <div class="slides_index">
                @isset($h)
                    @for ($i=0; $i < count($h->images_min); $i++)<div class="min_slide"><img class="slide_img" src={{$h->images_min[$i]}} alt=""
                                                    main={{$h->images[$i]}}
                                                        index={{$i}}></div>@endfor
                @endisset
            </div>
            <div class="hotel_review">
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
        <div class="description_wrapper">
            <div class="description">
                <div class="description_tittle">
                    <span>Stay in the heart of Lisbon</span>
                </div>
                <div class="descrition_text">

                    @if(isset($h))

                        @foreach ($h->paragraphs as $paragraph)
                            <p>{{ htmlspecialchars_decode($paragraph) }}</p>
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
            <div class="top_facilities">
            <span class="top_facilities_tittle">Most popular facilities
            </span>
                <div class="top_facility">
                    <i class="fas fa-wifi green"></i><span>Free Wi-fi</span>
                </div>
                <div class="top_facility">
                    <i class="fas fa-parking blue"></i><span>Private parking</span>
                </div>
                <div class="top_facility ">
                    <i class="fas fa-concierge-bell gold"></i><span>Room service</span>
                </div>
                <div class="top_facility ">
                    <i class="fas fa-utensils"></i><span>Restaurant</span>
                </div>
                <div class="top_facility ">
                    <i class="fas fa-smoking-ban"></i><span>Non-smoking rooms</span>
                </div>
                <a href="#facilities">
                    <button>See All Facilities</button>
                </a>
            </div>

        </div>
        <div class="availability_facilitites_rules">
            <div class="availability" id="availability">
                <div class="section_tittle">
                    <span>Choose your room</span>
                </div>
                <div class="search_update">
                    <div class="dates_boxes search_box">
                        <div class="dates_box">
                            <div class="box_title">Check-in</div>
                            <div class="box_text">{{$h->check_in ?? '2020-07-22'}}</div>
                        </div>
                        <div class="box_divider"></div>
                        <div class="dates_box">
                            <div class="box_title">Checkout</div>
                            <div class="box_text">{{$h->check_out ?? '2020-07-25'}}</div>
                        </div>
                    </div>
                    <div class="guests_box search_box">
                        <div class="box_guests_wrapper">
                            <div class="box_title">Guests</div>
                            <div
                                class="box_text">{{isset($h->adults) ? $h->rooms_text . ", " . $h->adults_text  : '1 room, 2 adults'}}</div>
                        </div>
                    </div>
                    <div class="update_wrapper search_box">
                        <button>Change search</button>
                    </div>
                </div>
                <div class="rooms_header">
                    <div class="room_header_wrapper">
                        <div class="header_box header_room_type">
                            <span>Room Type</span>
                        </div>
                        <div class="room_header_sub_wrapper">
                            <div class="header_box header_offers">
                                <span>Your Choices</span>
                            </div>
                            <div class="header_box header_select_rooms">
                                <span>Select Rooms</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="room">
                    @if(isset($h->offer))
                        <div class="room_wrapper">
                            @for($r=0; $r<count($h->offer); $r++)
                                <div class="room_content">
                                    <div class="room_type">
                                        <div class="room_image">
                                            <img class="room_img"
                                                 src="http://photos.hotelbeds.com/giata/bigger/{{$h->offer[$r]["images"][0]["path"]}}"
                                                 alt="">
                                        </div>
                                        <div class="room_name">
                                            <span
                                                class="room_name">{{MyLibrary::titleCase($h->offer[$r]["name"])}}</span>
                                        </div>
                                        <div class="room_capacity">
                                            <div class="room_guests_icon">
                                                @for($g=0; $g < $h->adults; $g++)<img
                                                    src="./images/search/guest_icon.png"
                                                    alt="guest_icon">@endfor
                                            </div>
                                            <span class="offer_guests">{{$h->adults_text}}</span>
                                        </div>
                                        <div class="more_details">
                                            <span>See room details</span>
                                        </div>
                                        <div class="amenity">
                                            <i class="fas fa-wifi"></i>
                                            <span>Wi-fi</span>
                                        </div>
                                        <div class="amenity">
                                            <i class="fas fa-fan"></i> <span>Air conditioning</span>
                                        </div>
                                        <ul class="room_ul">
                                            <li class="room_li_price">The price shown is the final price for
                                                {{$h->nights_text}}
                                            </li>
                                            <li><strong>VAT already included</strong></li>
                                            @isset($h->tourist_tax)
                                                <li class="tourist_tax">At the accommodation you will have to pay the
                                                    touristic tax of €{{$h->tourist_tax }} per night not included in the
                                                    price.
                                                </li>
                                            @endisset
                                        </ul>
                                    </div>
                                    <div class="room_offers">
                                        @for ($i=0; $i<count($h->offer[$r]["rates"]); $i++)
                                            <div class="offer_select">
                                                <div class="room_offer">
                                                    <div class="room_total">
                                                <span
                                                    class="room_total_price">€{{intval($h->offer[$r]["rates"][$i]["sellingRate"])}}</span>
                                                    </div>
                                                    <div class="room_nights">
                                                        <span class='nights_text'>for {{$h->nights_text}}</span>
                                                    </div>
                                                    @if($h->offer[$r]["rates"][$i]["boardName"] == 'BED AND BREAKFAST')
                                                        <div class="offer breakfast_included" name="board">
                                                            <i class="fas fa-coffee" name="board_icon"></i>
                                                            <span class="board_name">Breakfast included</span>
                                                        </div>
                                                    @else
                                                        <div class="offer" name="board">
                                                            <i class="fas fa-bed" name="board_icon"></i>
                                                            <span
                                                                class="board_name">{{MyLibrary::titleCase($h->offer[$r]["rates"][$i]["boardName"])}}</span>
                                                        </div>
                                                    @endif
                                                    @if(MyLibrary::titleCase($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"])
                                                    == 'Free cancellation')
                                                        <div class="offer refundable" name="policy">
                                                            <i class="fas fa-bookmark"></i>
                                                            <span
                                                                class="policy">{{MyLibrary::titleCase($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"])}}</span>
                                                        </div>
                                                    @else
                                                        <div class="offer" name="policy">
                                                            <i class="fas fa-bookmark"></i>
                                                            <span
                                                                class="policy">{{MyLibrary::titleCase($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"])}}</span>
                                                        </div>
                                                    @endif
                                                    @if($h->offer[$r]["rates"][$i]["allotment"] <= 5)
                                                        <div class="offer rooms_left"
                                                             name="rooms_left">
                                                            <i class="fas fa-bell"></i>
                                                            <span class="rooms_left">Only {{$h->offer[$r]["rates"][$i]["allotment"]}}
                                                    rooms left</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="room_select">
                                                    <select class="nr_rooms" type="text" name="nr_rooms">
                                                        @if (isset($h))
                                                            @for ($n=0; $n <= $h->offer[$r]["rates"][$i]["allotment"]; $n++)
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
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="room_reserve">
                            <a href="book?rateKey={{$h->offer[0]["rates"][0]["rateKey"] ?? ''}}">
                                <button>Reserve</button>
                            </a>
                            <ul>
                                <li>Confirmation is immediate</li>
                                <li>No registration required
                                </li>
                                <li>No booking or credit card fees!</li>
                            </ul>
                        </div>

                    @else
                        <div class="no_avail_wrapper">
                            <div class="no_avail_icon">
                                <img src="./images/search/information_icon.jpg" alt="no_avail_icon">
                            </div>
                            <div class="no_avail_message">
                    <span>This property has no availability on our site from {{date("j M",strtotime($m->check_in))}} to
                        {{date("j M",strtotime($m->check_out))}}.</span>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <div class="facilities" id="facilities">
                <div class="section_tittle">
                    <span>Hotel Facilities</span>
                </div>
                <div class="facilities_wrapper">

                    @if(isset($h))

                        @php
                            $keys = array_keys($h->facilities);
                        @endphp

                        @for ($i=0; $i < count($h->facilities); $i++)
                            @if (!empty($h->facilities[$keys[$i]]))
                                <div class="facilities_group">
                                    <div class="facilitites_tittle">
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

                        <div class="facilities_group">
                            <div class="facilitites_tittle">
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
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-bed"></i><span>Bedroom</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Linens</li>
                                <li>Wardrobe or closet</li>
                            </ul>
                        </div>

                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-mountain"></i><span>View</span>
                            </div>
                            <ul class="facilities_list">
                                <li>View</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-cloud-sun"></i><span>Outdoors</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Patio</li>
                                <li>Terrace</li>
                                <li>Garden</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-blender"></i><span>Kitchen</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Electric kettle</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-bed"></i><span>Room Amenities</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Socket near the bed</li>
                                <li>Clothes rack</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-concierge-bell"></i><span>Services & Extras</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Tickets to shows/attractions</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-paw"></i><span>Pets</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Pets are not allowed</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-couch"></i><span>Living Area</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Sitting area</li>
                                <li>Desk</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-snowboarding"></i><span>Activities</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Table tennis</li>
                                <li>Windsurfing</li>
                                <li>Diving</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
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
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-utensils"></i><span>Food & Drink</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Chocolate/Cookies</li>
                                <li>Bottle of water</li>
                                <li>Tea/Coffee maker</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-wifi"></i><span>Internet</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Free WiFi</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-parking"></i><span>Parking</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Accessible parking</li>
                                <li>Electric vehicle charging station</li>
                                <li>Parking garage</li>
                                <li>Secure parking</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-bus-alt"></i><span>Transportation</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Airport drop-off</li>
                                <li>Airport pickup</li>
                                <li>Public transit tickets</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-concierge-bell"></i><span>Front Desk Services</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Baggage storage</li>
                                <li>Tour desk</li>
                                <li>24-hour front desk</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-users"></i><span>Entertainment & Family Services</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Kids' TV channels</li>
                                <li>Babysitting/Child services</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-hand-sparkles"></i><span>Cleaning Services</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Daily housekeeping</li>
                                <li>Shoeshine</li>
                                <li>Ironing service</li>
                                <li>Dry cleaning</li>
                                <li>Laundry</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-briefcase"></i><span>Business Facilities</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Fax/Photocopying</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
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
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-spa"></i><span>Wellness facilities</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Spa Facilities</li>
                                <li>Outdoor pool</li>
                                <li>Massage</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
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
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-wheelchair"></i><span>Accessibility</span>
                            </div>
                            <ul class="facilities_list">
                                <li>Bathroom emergency cord</li>
                                <li>Toilet with grab rails</li>
                                <li>Wheelchair accessible</li>
                                <li>Entire unit wheelchair accessible</li>
                                <li>Upper floors accessible by elevator</li>
                            </ul>
                        </div>
                        <div class="facilities_group">
                            <div class="facilitites_tittle">
                                <i class="fas fa-language"></i><span>Languages Spoken</span>
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
            <div class="house_rules" id="houserules">
                <div class="section_tittle">
                    <span>Hotel Policies</span>
                </div>


                @if(isset($h))

                    @php
                        $keys = array_keys($h->policies);
                    @endphp

                    @for ($i=0; $i < count($h->policies)-1; $i++)

                        <div class="rule">
                            <div class="rule_tittle">
                                <i class='{{$h->icons->policies[$i]}}'></i><span>{{$keys[$i]}}</span>
                            </div>
                            <div class="rule_content">
                                @foreach ($h->policies[$keys[$i]] as $span)
                                    <span>{{$span}}</span>
                                @endforeach
                            </div>
                        </div>

                    @endfor

                @else
                    <div class="rule">
                        <div class="rule_tittle">
                            <i class="far fa-clock fa-lg"></i><span>Check-in and check-out</span>
                        </div>
                        <div class="rule_content">
                            <span>Check-in from 14:00</span>
                            <span>Check-out time: before 12:00</span>
                        </div>
                    </div>
                    <div class="rule">
                        <div class="rule_tittle">
                            <i class="fas fa-info-circle fa-lg"></i><span>Cancellation/Prepayment
                    </span>
                        </div>
                        <div class="rule_content">
                    <span>You can find more information on the terms of cancellation or prepayment in the
                        booking terms of the rate you've chosen.
                    </span>
                        </div>
                    </div>
                    <div class="rule">
                        <div class="rule_tittle">
                            <i class="fas fa-child fa-lg"></i><span>Children and beds</span>
                        </div>
                        <div class="rule_content">
                            <span>Children of any age are welcome.</span>
                            <span>Children aged 12 years and above are considered adults at this property.</span>
                            <span>To see correct prices and occupancy information, please add the number of children in
                        your group and their ages to your search.</span>
                        </div>
                    </div>
                    <div class="rule">
                        <div class="rule_tittle">
                            <i class="fas fa-utensils fa-lg"></i><span>Meals</span>
                        </div>
                        <div class="rule_content">
                    <span>Price of an additional breakfast: 8.00 EUR per person. Information about the type of
                        meals included in the price is indicated in the rate details.</span>
                        </div>
                    </div>
                    <div class="rule">
                        <div class="rule_tittle">
                            <i class="fas fa-paw fa-lg"></i><span>Pets</span>
                        </div>
                        <div class="rule_content">
                            <span>Pets are not allowed.</span>
                        </div>
                    </div>
                @endif
                <div class="rule">
                    <div class="rule_tittle">
                        <i class="far fa-credit-card fa-lg"></i><span>Cards accepted</span>
                    </div>
                    <div class="rule_content">
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
    </div>
@endsection

@section('update_overlay')
    <div class="update_overlay" id=update_overlay>
        <div class="update_popup" id="update_popup">
            <div class="update_tittle">Change your search</div>
            <div class="search_bar_update">
                <form action="hotel" method="get">
                    @csrf
                    <input type="hidden" name="hotel_id" value={{$m->hotel_id}}>
                    <div class="dates_wrapper_update">
                        <label class="icon_label_update" for="update_range"><i class="fas fa-calendar-alt fa-lg"
                                                                               aria-hidden="true"></i>
                        </label>
                        <input type="text" id="update_range" name="date_range" class="bar_box_update dates_input_update"
                               value='{{$m->date_range ?? "" }}' required="">
                        <label for="update_range" class="check_in_update">Check-in</label>
                        <label for="update_range" class="check_out_update">Check-out</label>
                    </div>
                    <div class="guests_wrapper_update bar_box_update">
                        <i class="fas fa-user-friends fa-lg" aria-hidden="true"></i>
                        <div class="box_tittle_update">Guests</div>
                        <div class="box_content_update">1 room, 2 adults</div>
                        <input type="hidden" name="adults" value="2" required="">
                        <input type="hidden" name="children" value="0" required="">
                        <input type="hidden" name="rooms" value="1" required="">
                    </div>
                    <button class="bar_button_update" type="submit">Search</button>
                </form>
            </div>
            <div class="update_close">
                <div class="close"></div>
            </div>
        </div>
    </div>
@endsection

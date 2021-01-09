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
                <span class="name">{{$h->name}}</span>
                <div class="stars_wrapper">
                    <span class="stars">{{$h->stars_symbol}}</span>
                </div>
            </div>
            <div class="address">
                <i class="fas fa-map-marker-alt map_icon" aria-hidden="true"></i>
                <span class="address_content">{{$h->address}}</span>
                <span class="map_divider">-</span>
                <span class="see_map">See Map</span>
            </div>
            <div class="distance_center">
                <span class="distance_center_content">{{ $h->distance_center}}
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
                    {{round(intval($h->offer[0]["rates"][0]["sellingRate"])/($h->nights*$h->offer[0]["rates"][0]["rooms"]))}}</span>
            </div>
            <div class="head_nightly_text">
                <span>nightly price per room</span>
            </div>
            <div class="total_price">
                <strong class="total_price_text">{{intval($h->offer[0]["rates"][0]["sellingRate"])}}
                    €</strong>
                <span class="header_nights">for {{$h->rooms_text}}</span>
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
        <div class="slideshow" id="slideshow">
            <div class="slide">
                <img id=slide src={{$h->images[0]}} alt="">
            </div>
            <div class="arrow_left">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="arrow_right">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
        <div class="slides_index">
            @for ($i=0; $i < count($h->images_min); $i++)<div class="min_slide"><img class="slide_img"
                        src={{$h->images_min[$i]}} alt="" main={{$h->images[$i]}} index={{$i}}></div>@endfor
        </div>
        <div class="hotel_review">
            <div class="quality_number">
                <div class="quality_wrapper">
                    <span class="quality">{{$h->quality}}</span>
                </div>
                <div class="nr_reviews_wrapper">
                    <span class="nr_reviews">{{$h->nr_reviews}}</span>
                    <span>reviews</span>
                </div>
            </div>
            <div class="score_wrapper">
                <span class="score">{{$h->score}}</span>
            </div>
        </div>
    </div>
    <div class="description_wrapper">
        <div class="description">
            <div class="description_tittle">
                <span>Stay in the heart of Lisbon</span>
            </div>
            <div class="descrition_text">
                @foreach ($h->paragraphs as $paragraph)
                <p>{{ htmlspecialchars_decode($paragraph) }}</p>
                @endforeach
            </div>
        </div>
        <div class="top_facilities">
            <span class="top_facilities_tittle">Most popular facilities
            </span>
            <div class="top_facilities_wrapper">
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
                        <div class="box_text">{{date("d M Y",strtotime($h->check_in))}}</div>
                    </div>
                    <div class="box_divider"></div>
                    <div class="dates_box">
                        <div class="box_title">Checkout</div>
                        <div class="box_text">{{date("d M Y",strtotime($h->check_out))}}</div>
                    </div>
                </div>
                <div class="guests_box search_box">
                    <div class="box_guests_wrapper">
                        <div class="box_title">Guests</div>
                        <div class="box_text">
                            {{$m->rooms_text . ", " . $m->adults_text . ($m->children > 0 ? ", ".$m->children_text : "")}}
                        </div>
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
                                @isset($h->offer[$r]["images"])
                                <div class="room_image">
                                    <img class="room_img"
                                        src="http://photos.hotelbeds.com/giata/bigger/{{$h->offer[$r]["images"][0]["path"] ?? "36/363373/363373a_hb_ro_008.jpg"}}"
                                        alt="">
                                </div>
                                @endisset
                                <div class="room_name">
                                    <span class="room_name">{{$h->offer[$r]["rates"][0]["rooms"]}} x
                                        {{MyLibrary::titleCase($h->offer[$r]["name"])}}</span>
                                </div>
                                <div class="room_capacity">
                                    <div class="room_guests_icon">
                                        @for($a=0; $a < $h->offer[$r]["rates"][0]["adults"] +
                                            $h->offer[$r]["rates"][0]["children"] ; $a++)
                                            <i class="fas fa-user" aria-hidden="true"></i>
                                            @endfor
                                    </div>
                                </div>
                                @isset($h->offer[$r]["size"])
                                <div class="room_size">
                                    <i class="fas fa-ruler-combined"></i>
                                    <span>{{$h->offer[$r]["size"]}} m<sup>2</sup></span>
                                </div>
                                @endisset
                                <div class="more_details">
                                    <span>See room details</span>
                                </div>
                                @if(in_array("Wi-fi",$h->facilities["Internet"]))
                                <div class="amenity">
                                    <i class="fas fa-wifi"></i>
                                    <span>Wi-fi</span>
                                </div>
                                @endif
                                @if(in_array("Individually adjustable air conditioning",$h->facilities["Room Amenities"]))
                                <div class="amenity">
                                    <i class="far fa-snowflake"></i>
                                    <span>Air Conditioning</span>
                                </div>
                                @endif
                                @if(in_array("Central heating",$h->facilities["Room Amenities"]))
                                <div class="amenity">
                                    <i class="fas fa-temperature-high"></i>                         <span>Heating</span>
                                </div>
                                @endif
                                @isset($h->offer[$r]["roomFacilities"])
                                @foreach ($h->offer[$r]["roomFacilities"] as $roomFacility)
                                <div class="amenity">
                                    <i class="{{$roomFacility["icon"]}}"></i>
                                    <span>{{$roomFacility["description"]}}</span>
                                </div>
                                @endforeach
                                @endisset
                                <ul class="room_ul">
                                    <li class="room_li_price">The price shown is the final price for {{$h->rooms_text}}
                                        for {{$h->nights_text}}
                                    </li>
                                    <li><strong>VAT already included</strong></li>
                                    @isset($h->tourist_tax)
                                    <li class="tourist_tax">At the accommodation you will have to pay the
                                        touristic tax of €{{$h->tourist_tax }} per night not included in the
                                        price.
                                    </li>
                                    @endisset
                                </ul>
                                <div class="details_overlay">
                                    <div class="details_popup">
                                        <div class="details-room-name">
                                            <span>{{MyLibrary::titleCase($h->offer[$r]["name"])}}</span>
                                        </div>
                                        <div class="details-content">
                                            @isset($h->offer[$r]["images"])
                                            <div class="details_left">
                                                <div class="slick room_images">
                                                    @foreach($h->offer[$r]["images"] as $room_image)
                                                    <div>
                                                        <img src="http://photos.hotelbeds.com/giata/bigger/{{$room_image["path"]}}"
                                                            alt="">
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endisset
                                            <div class="details_rigth">
                                                @isset($h->offer[$r]["size"])
                                                <div class="details-size">
                                                    <i class="fas fa-ruler-combined"></i>
                                                    <span>Room size: {{$h->offer[$r]["size"]}} m<sup>2</sup></span>
                                                </div>
                                                @endisset
                                                @isset($h->offer[$r]["roomFacilities"])
                                                <div class="room-facilities-wrapper">
                                                    @foreach ($h->offer[$r]["roomFacilities"] as $roomFacility)
                                                    <div class="amenity">
                                                        <i class="{{$roomFacility["icon"]}}"></i>
                                                        <span>{{$roomFacility["description"]}}</span>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endisset
                                                <div class="room-facilities-wrapper">
                                                    @if (!empty($h->facilities["Bedroom"]))
                                                    <div class="facilities_group">
                                                        <div class="facilitites_tittle">
                                                            <i class="fas fa-bed"
                                                                aria-hidden="true"></i><span>Bedroom</span>
                                                        </div>
                                                        <ul class="facilities_list">
                                                            @foreach ($h->facilities["Bedroom"] as $li)
                                                            <li>{{$li}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                    @if (!empty($h->facilities["Room Amenities"]))
                                                    <div class="facilities_group">
                                                        <div class="facilitites_tittle">
                                                            <i class="fas fa-bed"
                                                                aria-hidden="true"></i><span>Room Amenities</span>
                                                        </div>
                                                        <ul class="facilities_list">
                                                            @foreach ($h->facilities["Room Amenities"] as $li)
                                                            <li>{{$li}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                    @if (!empty($h->facilities["Bathroom"]))
                                                    <div class="facilities_group">
                                                        <div class="facilitites_tittle">
                                                            <i class="fas fa-bath"
                                                                aria-hidden="true"></i><span>Bathroom</span>
                                                        </div>
                                                        <ul class="facilities_list">
                                                            @foreach ($h->facilities["Bathroom"] as $li)
                                                            <li>{{$li}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="room_close">
                                            <div class="close"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="room_offers">
                                @for ($i=0; $i<count($h->offer[$r]["rates"]); $i++)
                                    <div class="offer_select">
                                        <div class="room_offer">
                                            <div class="offer {{$h->offer[$r]["rates"][$i]["boardCode"] == 'BB' ? "green" : ""}}"
                                                name="board">
                                                @if($h->offer[$r]["rates"][$i]["boardCode"] == 'BB')
                                                <i class="fas fa-coffee" name="board_icon"></i>
                                                @else
                                                <i class="fas fa-bed" name="board_icon"></i>
                                                @endif
                                                <span
                                                    class="board_name">{{MyLibrary::board($h->offer[$r]["rates"][$i]["boardCode"])}}</span>
                                            </div>
                                            <div class="offer {{$h->offer[$r]["rates"][$i]["rateClass"] == 'RF' ? "green" : ""}}"
                                                name="policy">
                                                <i class="fas fa-bookmark"></i>
                                                <span
                                                    class="policy">{{$h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"]}}</span>
                                            </div>
                                            @if($h->offer[$r]["rates"][$i]["allotment"] <= 5) <div
                                                class="offer rooms_left" name="rooms_left">
                                                <i class="fas fa-bell"></i>
                                                <span class="rooms_left">Only
                                                    {{$h->offer[$r]["rates"][$i]["allotment"]}}
                                                    rooms left</span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="room_reserve">
                                        <div class="room_total">
                                            <span
                                                class="room_total_price">€{{intval($h->offer[$r]["rates"][$i]["sellingRate"])}}</span>
                                        </div>
                                        <span class='nights_text'>for {{$h->offer[$r]["rates"][$i]["rooms"]}}
                                            {{$h->offer[$r]["rates"][$i]["rooms"]>1?"rooms": "room"}} for
                                            {{$h->nights_text}}</span>
                                        <a href="book?rateKey={{$h->offer[$r]["rates"][$i]["rateKey"] . "&adults=" . $m->adults . "&children=" . $m->children}}"
                                            target="_blank">
                                            <button>Reserve</button>
                                        </a>
                                        <span
                                            class='price_per_night'>(<strong>{{round(intval($h->offer[$r]["rates"][$i]["sellingRate"])/($h->nights*$h->offer[$r]["rates"][$i]["rooms"]))}}€</strong>
                                            per night per room)</span>
                                        <span class='total_guests_text'>Guests: </span>
                                        <span
                                            class='total_guests'>{{$m->adults_text . ($m->children > 0 ? ", ".$m->children_text : "")}}
                                        </span>

                                    </div>
                            </div>
                            @endfor
                        </div>
                </div>
                @endfor
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
        </div>
    </div>
    <div class="house_rules" id="houserules">
        <div class="section_tittle">
            <span>Hotel Policies</span>
        </div>
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
            <div class="rule">
                <div class="rule_tittle">
                    <i class="far fa-credit-card fa-lg"></i><span>Cards accepted</span>
                </div>
                <div class="rule_content">
                    @for ($i=0; $i < count($h->policies["Cards accepted"]); $i++)<i
                            class="{{$h->icons->cards[$h->policies["Cards accepted"][$i]]}}"></i>@endfor
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
                        value='{{$m->date_range ?? "" }}' required="" readonly>
                    <label for="update_range" class="check_in_update">Check-in</label>
                    <label for="update_range" class="check_out_update">Check-out</label>
                </div>
                <div class="guests_wrapper_update bar_box_update">
                    <i class="fas fa-user-friends fa-lg" aria-hidden="true"></i>
                    <div class="box_tittle_update">Guests</div>
                    <div class="box_content_update box_content">
                        {{$m->rooms_text . ", " . $m->adults_text . ($m->children > 0 ? ", ".$m->children_text : "")}}
                    </div>
                    <div class="guests_selection guests_selection_update">
                        <div class="item_selection">
                            <i class="fas fa-minus" data-value=-1></i>
                            <div class="item_text">
                                <span class="item_number">{{$m->rooms}}</span>
                                <span class="item_type">{{$m->rooms == 1 ? "room" : "rooms"}}</span>
                            </div>
                            <i class="fas fa-plus" data-value=1></i>
                            <input type="hidden" id="rooms" name="rooms" value={{$m->rooms}} min=1 max=4
                                data-singular="room" data-plural="rooms" required>
                        </div>
                        <div class="item_selection">
                            <i class="fas fa-minus" data-value=-1></i>
                            <div class="item_text">
                                <span class="item_number">{{$m->adults}}</span>
                                <span class="item_type">{{$m->adults == 1 ? "adult" : "adults"}}</span>
                            </div>
                            <i class="fas fa-plus" data-value=1></i>
                            <input type="hidden" id="adults" name="adults" value={{$m->adults}} min=1 max=8
                                data-singular="adult" data-plural="adults" required>
                        </div>
                        <div class="item_selection">
                            <i class="fas fa-minus" data-value=-1></i>
                            <div class="item_text">
                                <span class="item_number">{{$m->children}}</span>
                                <span class="item_type">{{$m->children == 1 ? "child" : "children"}}</span>
                            </div>
                            <i class="fas fa-plus" data-value=1></i>
                            <input type="hidden" id="children" name="children" value={{$m->children}} min=0 max=2
                                data-singular="child" data-plural="children" required>
                        </div>
                    </div>
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
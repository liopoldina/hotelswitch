@extends('layouts.master')

@include('childs.head')

@section('head')
{{-- homepage specific --}}
<link rel="stylesheet" href={{asset('css/homepage.css')}} />
<script src={{ asset('js/homepage.js') }} defer></script>

{{-- particles --}}
<script src={{ asset('js/particle.js') }} defer></script>

{{-- slick carrousel --}}
<link rel="stylesheet" type="text/css" href={{ asset('slick/slick.css') }} />
<link rel="stylesheet" type="text/css" href={{ asset('slick/slick-theme.css') }} />
<script type="text/javascript" src={{ asset('slick/slick.min.js') }}></script>
@append

@section('content')
<div class="internal">
    <div class='first_section'>
        <div id="particle-canvas"></div>
        <div class='tittle_wrapper'>
            <div class="section_tittle">Book the Best Hotel Deals</div>
            <div class="section_text">Get the best prices on 200,000+ properties, worldwide
            </div>
        </div>
        <div class="search_bar">
            <form id="search" action="search" method="get" target="_blank">
                @csrf
                <div class='destination_wrapper'>
                    <i class="fas fa-map-marker-alt fa-lg"></i>
                    <input type="text" id="destination" name="destination" placeholder="where are you travelling to?"
                        class="ui-autocomplete-input bar_box destination_input" autocomplete="off">
                    <input type="hidden" id="lat" name="lat" value="">
                    <input type="hidden" id="lon" name="lon" value="">
                </div>
                <div class="dates_wrapper">
                    <i class="fas fa-calendar-alt fa-lg"></i>
                    <input type="text" id="date_range" name="date_range" value="08/29/2020 - 08/30/2020"
                        class='bar_box dates_input'>
                    <span class='check_in'>Check-in</span>
                    <span class='check_out'>Check-out</span>
                </div>
                <div class="guests_wrapper bar_box">
                    <i class="fas fa-user-friends fa-lg"></i>
                    <span class='box_tittle'>Guests</span>
                    <span class='box_content'>1 room, 2 adults </span>
                    <input type="hidden" id="adults" name="adults" value="2">
                    <input type="hidden" id="children" name="children" value="0">
                    <input type="hidden" id="rooms" name="rooms" value="1">
                </div>
                <button class='bar_button' type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class='why_section'>
        <div class="why_tittle">Let us find you the best deals</div>
        <div class=why_element>
            <i class="fas fa-brain"></i>
            <div class="why_section_tittle">Artifical Intelligence</div>
            <div class="why_section_text">Our proprietary artificial intelligence algorithm analyses reservations trends
                and millions of hotel
                prices to suggests you the <strong>best deals</strong>.</div>
        </div>
        <div class=why_element>
            <i class="fas fa-tags"></i>
            <div class="why_section_tittle">No Fake Promotions</div>
            <div class="why_section_text">Why would you care to have a big discount if the hotel is still too
                expensive for what it is? We only take into acccount <strong>what really matters</strong> to you such as
                location, reviews, room size etc. </div>
        </div>
        <div class=why_element>
            <i class="fas fa-thumbs-up"></i>
            <div class="why_section_tittle">Best Results</div>
            <div class="why_section_text">Most travel websites show you first the hotels that pay them the highest
                commission. We always show you the <strong>best results</strong> upfront.</div>
        </div>

        <div class=why_element>
            <i class="fas fa-city"></i>
            <div class="why_section_tittle">Switch Hotels</div>
            <div class="why_section_text">Sometimes variations in daily rates generate great deals if you are
                willing to stay in more than one hotel. We will also show you these <strong>opportunities</strong> in
                case you are up
                to switch hotels during your trip.</div>
        </div>
    </div>
    <div class="popular_section">
        <div class="carrousel">
            <div class="popular_tittle">Popular Destinations</div>
            <div class="slick destinations">
                <div>
                    <a href="search?destination=paris">
                        <img src={{asset("images\homepage\destinations\paris.jpg")}} alt="">
                        <span>Paris</span>
                    </a>
                </div>
                <div>
                    <a href="search?destination=rome">
                        <img src={{asset("images\homepage\destinations/rome.jpg")}} alt="">
                        <span>Rome</span>
                    </a>
                </div>
                <div>
                    <a href="search?destination=london">
                        <img src={{asset("images\homepage\destinations\london.jpg")}} alt="">
                        <span>London</span>
                    </a>
                </div>
                <div>
                    <a href="search?destination=istanbul">
                        <img src={{asset("images\homepage\destinations\istanbul.jpg")}} alt="">
                        <span>Istanbul</span>
                    </a>
                </div>
                <div>
                    <a href="search?destination=lisbon">
                        <img src={{asset("images\homepage\destinations\lisbon.jpg")}} alt="">
                        <span>Lisbon</span>
                    </a>
                </div>
                <div>
                    <a href="search?destination=barcelona_spain">
                        <img src={{asset("images\homepage\destinations\barcelona.jpg")}} alt="">
                        <span>Barcelona</span>
                    </a>
                </div>
                <div>
                    <a href="search?destination=riodejaneiro">
                        <img src={{asset("images\homepage\destinations/riodejaneiro.jpg")}} alt="">
                        <span>Rio de Janeiro</span>
                    </a>
                </div>
                <div>
                    <a href="search?destination=capetown">
                        <img src={{asset("images\homepage\destinations\capetown.jpg")}} alt="">
                        <span>Cape Town</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="carrousel carrousel_last">
            <div class="popular_tittle">Top Hotels</div>
            <div class="slick hotels">
                <div>
                    <a href="hotel?hotel_id=61830">
                        <img src={{asset("images/homepage/hotels/komaneka_at_monkey_forest.jpg")}} alt="">
                        <span><strong>Komaneka at Monkey Forest</strong></span>
                        <span>Ubud, Bali</span>
                    </a>
                </div>
                <div>
                    <a href="hotel?hotel_id=142659">
                        <img src={{asset("images/homepage/hotels/armani_hotel_dubai.jpg")}} alt="">
                        <span><strong>Armani Hotel Dubai</strong></span>
                        <span>Dubai, UAE</span>
                    </a>
                </div>
                <div>
                    <a href="hotel?hotel_id=573311">
                        <img src={{asset("images/homepage/hotels/the_knickerbocker.jpg")}} alt="">
                        <span><strong>The Knickerbocker</strong></span>
                        <span>New York, US</span>
                    </a>
                </div>
                <div>
                    <a href="hotel?hotel_id=74316">
                        <img src={{asset("images/homepage/hotels/the_fullerton_hotel.jpg")}} alt="">
                        <span><strong>The Fullerton Hotel</strong></span>
                        <span>Singapore</span>
                    </a>
                </div>
                <div>
                    <a href="hotel?hotel_id=6638">
                        <img src={{asset("images/homepage/hotels/the_langham_london.jpg")}} alt="">
                        <span><strong>The Langham London</strong></span>
                        <span>London, UK</span>
                    </a>
                </div>
                <div>
                    <a href="hotel?hotel_id=79400">
                        <img src={{asset("images/homepage/hotels/the_tongsai_bay.jpg")}} alt="">
                        <span><strong>The Tongsai Bay</strong></span>
                        <span>Koh Samui, Thailand</span>
                    </a>
                </div>
                <div>
                    <a href="hotel?hotel_id=542606">
                        <img src={{asset("images/homepage/hotels/waldorf_astoria_beverly_hills.jpg")}} alt="">
                        <span><strong>Waldorf Astoria Beverly Hills</strong></span>
                        <span>Los Angeles, US</span>
                    </a>
                </div>
                <div>
                    <a href="hotel?hotel_id=363373">
                        <img src={{asset("images/homepage/hotels/rossio_garden_hotel.jpg")}} alt="">
                        <span><strong>Rossio Garden Hotel</strong></span>
                        <span>Lisbon, Portugal</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="distinctive_section">
        <div class="distinction_wrapper">
            <i class="fas fa-hotel"></i>
            <span class='distinction_tittle'>More than 200.000 hotels</span>
            <span class='distinction_text'>In 65 countries worldwide</span>
        </div>
        <div class="distinction_wrapper">
            <i class="fas fa-thumbs-up"></i>
            <span class='distinction_tittle'>Instant confirmation</span>
            <span class='distinction_text'>You will receive your confirmation immediately</span>
        </div>
        <div class="distinction_wrapper">
            <i class="fas fa-piggy-bank"></i>
            <span class='distinction_tittle'>Best price</span>
            <span class='distinction_text'>Save money with our competitive rates
            </span>
        </div>
        <div class="distinction_wrapper">
            <i class="fas fa-headset"></i>
            <span class='distinction_tittle'>Professional customer support</span>
            <span class='distinction_text'>Dedicated service staff will assist you</span>
        </div>
    </div>

</div>
</div>
@endsection

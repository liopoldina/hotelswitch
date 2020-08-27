<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
</head>

<body>
    <div class="header">
        <a href="search">
            <div class="logo_wrapper">
                <span class="hotel">Hotel</span><span class="hopping">Switch</span><span class="com">.com</span>
            </div>
        </a>
        <div class="user_wrapper">
            <div class="user_items">
                <div id="currency_wrapper"><a id="currency" href="#">€</a></div>
            </div>
            <div class="user_items">
                <img id="flag" src="./images/header/bandeira.png" alt="idioma" />
            </div>
            @if (Route::has('login'))
            @auth
            <div class="user_items header_buttons">
                <a href="{{ url('/home') }}">
                    <button>Home</button>
                </a>
            </div>
            @else
            @if (Route::has('register'))
            <div class="user_items header_buttons">
                <a href="{{ route('register') }}">
                    <button>Register</button>
                </a>
            </div>
            @endif
            <div class="user_items header_buttons">
                <a href="{{ route('login') }}">
                    <button>Sign in</button>
                </a>
            </div>
            @endauth
            @endif
        </div>
    </div>

    <div class="internal">
        <div class="internal_wrapper">
            <div class="left">
                @yield('search_box')
                {{-- @yield ('hopping') --}}
                @yield ('left_search')
                @yield ('left_hotel')
            </div>
            @yield ('right_search')
            @yield ('right_hotel')
        </div>
    </div>

    <div class="footer">
        <div class="first_footer">
            <div class="first_footer_items_wrapper">
                <div class="first_footer_item">
                    <button>Manage your Booking</button>
                </div>
                <div class="first_footer_item">
                    <button>Customer Service Help</button>
                </div>
            </div>
        </div>
        <div class="second_footer">
            <div class="copyright_wrapper">
                <span>Copyright &#169; 2020 HotelHopping.com&#174;</span>
                <span>All rights reserved</span>
            </div>
            <div class="second_footer_items_wrapper">
                <div class="second_footer_item">
                    <a href="#">Investor Relationships</a>
                </div>
                <div class="second_footer_item">
                    <a href="#">Careers</a>
                </div>
                <div class="second_footer_item">
                    <a href="#">About HotelHopping.com</a>
                </div>
                <div class="second_footer_item">
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </div>
    <div class="map_overlay" id=map_overlay>
        <div class="map_popup" id="map_popup">
            <div class="map_left"></div>
            <div class="map_right" id="map"></div>
        </div>
        <div class="map_close">
            <div class="close"></div>
        </div>
</body>

</html>

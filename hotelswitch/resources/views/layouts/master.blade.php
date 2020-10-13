<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
</head>

<body>
    <div class="header">
        <a href="{{ route('homepage.index') }}">
            <div class="logo_wrapper">
                <span class="hotel">H</span><span class="hopping">S</span><span class="com">.c</span>
            </div>
        </a>
        <div class="user_wrapper">
            <div class="user_items">
                <div id="currency_wrapper"><a id="currency" href="#">€</a></div>
            </div>
            <div class="user_items">
                <img id="flag" src={{asset('images/header/bandeira.png')}} alt="idioma" />
            </div>
            @guest
            <div class="user_items header_buttons">
                <a href="{{ route('register') }}">
                    <button>Register</button>
                </a>
            </div>
            <div class="user_items header_buttons">
                <a href="{{ route('login') }}">
                    <button>Login</button>
                </a>
            </div>
            @endguest
            @auth
            <div class="user_items account_dropdown">
                {{ Auth::user()->name }} <span class="caret"></span>
            </div>
            <div class='dropdown_menu'>
                <a class="dropdown_item" href="{{ route('my_reservations') }}">
                    My Reservations
                </a>
                <a class="dropdown_item" href="{{ route('settings') }}">
                    Settings
                </a>
                <a class="dropdown_item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>


        </div>
        @endauth

    </div>
    </div>


    @yield('content')


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
                    <a href="#">About HotelHopping.com</a>
                </div>
                <div class="second_footer_item">
                    <a href="#">Terms of Service</a>
                </div>
                <div class="second_footer_item">
                    <a href="#">Privacy Policy</a>
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

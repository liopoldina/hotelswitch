<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
</head>

<body>
    <div class="header">
        <div class="header_content">
            <div class="logo_wrapper">
                <a href="{{ route('homepage.index') }}">
                    <img class="logo_img" src="{{asset('images/header/logo.png')}}" alt="">
                    <div class="logo_text">
                        <span class="logo_hotel">{{ env("BRAND_FIRST") }}</span>
                        <span class="logo_brand">{{ env("BRAND_LAST") }}</span>
                    </div>
                </a>
            </div>
            <div class="user_wrapper">
                <div class="user_items">
                    <a id="currency" href="#">€</a>
                </div>
                {{-- <div class="user_items">
                    <img id="flag" src={{asset('images/header/bandeira.png')}} alt="idioma" />
                </div> --}}
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
                @endauth
            </div>
        </div>
    </div>

    @yield('content')


    <div class="footer">
        <div class="first_footer">
            <div class="first_footer_items_wrapper">
                <div class="first_footer_item">
                    <a href="{{ route('login') }}"><button>Manage your Booking</button></a>
                </div>
                <div class="first_footer_item">
                    <button>Customer Service Help</button>
                </div>
            </div>
        </div>
        <div class="second_footer">
            <div class="copyright_wrapper">
                <span>Copyright &#169; 2021 {{env("APP_NAME")}}.com&#174; All rights reserved</span>
            </div>
            <div class="second_footer_links">
                <a href="#">About {{env("APP_NAME")}}.com</a>
                <a href="{{ route('terms.index') }}">Terms & Conditions</a>
                <a href="{{ route('privacy.index') }}">Privacy Policy</a>
            </div>
            <div class="center_auxiliar"></div>
        </div>
    </div>
</body>

</html>

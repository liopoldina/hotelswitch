@extends('layouts.master')

@include('childs.head')

@section('head')
    <link rel="stylesheet" href={{ asset('css/search_form.css') }} />
    <link rel="stylesheet" href={{ asset('css/search.css') }} />
    <link rel="stylesheet" href={{ asset('css/hotel.css') }} />
    <script src={{asset('js/hammer.min.js')}}></script>
    
    {{-- slick carrousel --}}
    <link rel="stylesheet" type="text/css" href={{ asset('slick/slick.css') }} />
    <link rel="stylesheet" type="text/css" href={{ asset('slick/slick-theme.css') }} />
    <script type="text/javascript" src={{ asset('slick/slick.min.js') }}></script>


    <script src={{ asset('js/search.js') }}></script>
    <script src={{ asset('js/hotel.js') }}></script>
    <script defer
        src='https://maps.googleapis.com/maps/api/js?key=AIzaSyByN9fh3nvC4R9vn7G6BkNRnhoPbKYdMwk'>
    </script>
    @append

@include('Search.search_form')
@include('Hotel.hotel_sections')
@include('Map.map')  
    
@section('content')
    <div class="internal">
        <div class="internal_wrapper">
            <div class="left_content">
                @yield('search_box')
                @yield ('left_hotel')
            </div>
            @yield ('right_hotel')
        </div>
    </div>
    @yield ('update_overlay')
    @yield('map')
    @yield('hotelbox')
@endsection

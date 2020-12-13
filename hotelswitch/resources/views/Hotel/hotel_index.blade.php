@extends('layouts.master')

@include('childs.head')

@include('Search.search_form')

@include('Hotel.hotel_sections')

@section('head')
    <link rel="stylesheet" href={{ asset('css/search_form.css') }} />
    <link rel="stylesheet" href={{ asset('css/hotel.css') }} />
    <script src={{ asset('js/hotel.js') }}></script>
    @append

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
@endsection

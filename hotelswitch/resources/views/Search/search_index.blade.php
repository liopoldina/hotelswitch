@extends('layouts.master')

@include('childs.head')

@section('head')
    {{-- searchpage specific --}}
    <link rel="stylesheet" href={{ asset('css/search.css') }} />
    <link rel="stylesheet" href={{ asset('css/search_form.css') }} />
    <script src={{ asset('js/search.js') }}></script>
    <script async defer
        src='https://maps.googleapis.com/maps/api/js?key=AIzaSyByN9fh3nvC4R9vn7G6BkNRnhoPbKYdMwk&callback=initMap'>
    </script>
@append

@yield('internal_left_right')

@include('Search.search_form')
@include('Search.search_sections')
@include('Search.search_sections')

@section('content')
    <div class="internal">
        <div class="internal_wrapper">
            <div class="left_content">
                @yield('search_box')
                {{-- @yield ('hopping') --}}
                @yield ('left_search')
            </div>
            @yield ('right_search')
        </div>
    </div>
    <div class="map_overlay" id=map_overlay>
        <div class="map_popup" id="map_popup">
            <div class="map_left"></div>
            <div class="map_right">
                <div id="map"></div>
                <div class="map_loading_gif">
                    <img src="images/search/page_loading.gif" alt="page_loading">
                </div>
                <div class="map-filter-button">
                    <i class="fas fa-filter" aria-hidden="true"></i>
                    <span>Filter</span>
                </div>
                <div class="map-no-results">
                    <img class="no_results_icon" src="./images/search/information_icon.jpg" alt="page_end_icon">
                    <span>There are no properties that match your search criteria.</span>
                </div>
            </div>
            <div class="map_close">
                <div class="close"></div>
            </div>
        </div>
    </div>
@endsection



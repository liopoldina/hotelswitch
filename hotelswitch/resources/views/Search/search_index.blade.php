@extends('layouts.master')

@include('childs.head')

@section('head')
{{-- searchpage specific --}}
<link rel="stylesheet" href={{asset('css/search.css')}} />
<script src={{ asset('js/search.js') }}></script>
<script async defer
    src='https://maps.googleapis.com/maps/api/js?key=AIzaSyByN9fh3nvC4R9vn7G6BkNRnhoPbKYdMwk&callback=initMap'>
</script>
@append

@yield('internal_left_right')

@include('Search.search_form')

@include('Search.search_sections')

@section('content')
<div class="internal">
    <div class="internal_wrapper">
        <div class="left">
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
        <div class="map_right" id="map"></div>
    </div>
    <div class="map_close">
        <div class="close"></div>
    </div>
</div>
@endsection

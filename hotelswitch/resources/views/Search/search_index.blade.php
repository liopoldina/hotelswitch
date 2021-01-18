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
@include('Map.map')


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
    @yield('map')
@endsection


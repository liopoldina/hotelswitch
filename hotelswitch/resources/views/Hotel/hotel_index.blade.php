@extends('layouts.master')

@include('childs.head')

@include('Search.search_form')

@include('Hotel.hotel_sections')

@section('head')
<script src={{asset('js/hotel.js')}}></script>
@append

@section('content')
<div class="internal">
    <div class="internal_wrapper">
        <div class="left">
            @yield('search_box')
            @yield ('left_hotel')
        </div>
        @yield ('right_hotel')
    </div>
</div>
@endsection

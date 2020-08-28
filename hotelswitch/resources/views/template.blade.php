@extends('layouts.master')

@include('childs.head')

@include('childs.search_box')

@include('childs.search_page')

@include('childs.hotel_page')

@section('content')
@parent
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
@endsection

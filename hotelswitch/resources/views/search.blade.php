@extends('layouts.master')

@include('childs.head')

@yield('internal_left_right')

@include('childs.search_box')

@include('childs.search_page')

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
@endsection

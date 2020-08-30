@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/homepage.css')}} />
<script src="{{ asset('js/particle.js') }}" defer></script>
@append

@section('content')
<div class="internal">
    <div class='first_section'>
        <div id="particle-canvas"></div>
        <div class='tittle_wrapper'>
            <div class="section_tittle">Find the best hotel deals</div>
            <div class="section_text">Get the best prices on 1,000,000+ properties, worldwide
            </div>
        </div>
        <div class="search_bar">
            <form id="search" action="search" method="get" target="_blank">
                @csrf
                <div class='destination_wrapper'>
                    <i class="fas fa-map-marker-alt fa-lg"></i>
                    <input type="text" id="destination" name="destination" placeholder="where are you travelling to?"
                        class="ui-autocomplete-input bar_box destination_input" autocomplete="off">
                    <input type="hidden" id="destination_id" name="destination_id">
                    <input type="hidden" id="lat" name="lat" value="38.712526349309">
                    <input type="hidden" id="lon" name="lon" value="-9.1384437715424">
                </div>
                <div class="dates_wrapper">
                    <i class="fas fa-calendar-alt fa-lg"></i>
                    <input type="text" id="date_range" name="date_range" value="08/29/2020 - 08/30/2020"
                        class='bar_box dates_input'>
                    <span class='check_in'>Check-in</span>
                    <span class='check_out'>Check-out</span>
                </div>
                <div class="guests_wrapper bar_box">
                    <i class="fas fa-user-friends fa-lg"></i>
                    <span class='box_tittle'>Guests</span>
                    <span class='box_content'>1 room, 2 adults </span>
                    <input type="hidden" id="adults" name="adults" value="2">
                    <input type="hidden" id="children" name="children" value="0">
                    <input type="hidden" id="rooms" name="rooms" value="1">
                </div>
                <button class='bar_button' type="submit">Search</button>
            </form>
        </div>
    </div>
    <div class='why_section'>
        <div class="why_tittle">Powered by Artificial Intelligence</div>
        <div class=why_text>Our proprietaty</div>
    </div>
</div>
@endsection

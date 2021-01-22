@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/settings.css')}} />
<script src={{asset('js/settings.js')}}></script>
@append

@section('content')
<div class="container">
    <div class="wrapper">
        <div class="tittle_wrapper">Settings</div>
        <div class="content_wrapper">
            <div class="form_wrapper">
                @csrf
                <div class="item_wrapper email_wrapper">
                    <label>E-Mail Address*</label>
                    <input value="{{$user->email}}" disabled>
                </div>
                <div class="note_wrapper section_margin">
                    <span class='input_note'>*The e-mail address can't be modified </span>
                </div>
                <div class="item_wrapper">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{$user->name}}" id="name">
                    <div class="loading_wrapper">
                        <img src={{asset('images\settings\loading.gif')}} alt="loading_gif" class="loading_gif">
                        <i class=""></i>
                        <span class="loading_text"></span>
                    </div>
                </div>
                <div class="item_wrapper">
                    <label for="name">Birthday</label>
                    <select name="b_day" id="b_day">
                        <option></option>
                        @for($i=1; $i<=31; $i++) <option value={{$i}} {{$user->b_day == $i ? 'selected' : ''}}>{{$i}}
                            </option>
                            @endfor
                    </select>
                    <select name="b_month" id="b_month">
                        <option></option>
                        <option value="1" {{$user->b_month == 1 ? 'selected' : ''}}>January</option>
                        <option value="2" {{$user->b_month == 2 ? 'selected' : ''}}>February</option>
                        <option value="3" {{$user->b_month == 3 ? 'selected' : ''}}>March</option>
                        <option value="4" {{$user->b_month == 4 ? 'selected' : ''}}>April</option>
                        <option value="5" {{$user->b_month == 5 ? 'selected' : ''}}>May</option>
                        <option value="6" {{$user->b_month == 6 ? 'selected' : ''}}>June</option>
                        <option value="7" {{$user->b_month == 7 ? 'selected' : ''}}>July</option>
                        <option value="8" {{$user->b_month == 8 ? 'selected' : ''}}>August</option>
                        <option value="9" {{$user->b_month == 9 ? 'selected' : ''}}>September</option>
                        <option value="10" {{$user->b_month == 10 ? 'selected' : ''}}>October</option>
                        <option value="11" {{$user->b_month == 11 ? 'selected' : ''}}>November</option>
                        <option value="12" {{$user->b_month == 12 ? 'selected' : ''}}>December</option>
                    </select>
                    <select name="b_year" id="b_year">
                        <option></option>
                        @for($i=1900; $i<2020; $i++) <option value={{$i}} {{$user->b_year == $i ? 'selected' : ''}}>
                            {{$i}}
                            </option>
                            @endfor
                    </select>
                    <div class="loading_wrapper">
                        <img src={{asset('images\settings\loading.gif')}} alt="loading_gif" class="loading_gif">
                        <i class=""></i>
                        <span class="loading_text"></span>
                    </div>
                </div>
                <div class="item_wrapper section_margin">
                    <label for="country">Country</label>
                    <select name="country" id="country">
                        <option></option>
                        @foreach($countries as $country)
                        <option value={{$country['description']['content']}}
                            {{$user->country == $country['description']['content'] ? 'selected' : ''}}>
                            {{$country['description']['content']}}
                        </option>
                        @endforeach
                    </select>
                    <div class="loading_wrapper">
                        <img src={{asset('images\settings\loading.gif')}} alt="loading_gif" class="loading_gif">
                        <i class=""></i>
                        <span class="loading_text"></span>
                    </div>
                </div>
                <div class="item_wrapper password_wrapper">
                    <label>Change Password</label>
                    <a href="password/reset">
                        <button type="submit" class="password_reset">Reset Password</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/my_reservations.css')}} />
@append

@section('content')
<div class="container">
    <div class="wrapper">
        <div class="tittle_wrapper">My Reservations</div>
        <div class="content_wrapper">
            @if(count($reservations)==0)
            <div class='no_reservations'>There are no reservations with your email address. If you can't find you
                reservation or for any
                other question please <a href="">contact us</a>.</div>
            @else
            @foreach($reservations as $r)
            <a href="confirmation?id={{ $r['id'] ?? 'erBX9Y3nBzcuPWEImdjlkhz9gzK1t6TsgxdMRiqoWbJDgUHb53mNF5Xmx6r8CNk7q3bIdVDEAhLjaVymiaW8BAS9sK4GbU2T0OtokrSFvovvzHfNRO1UQhjCIpLGCZ0ROfN2OES651tAypf2ZnMjKTDG1FciaXJM48W5snwl2LqlcnYeQwEPSuRyfqorc7JiwxxudH06VTQuZsBUP4JACXl4tGIvKHeypkVFL7p98Q7gY'}}"
                target="blank_">
                <div class="reservation_wrapper">
                    <div class="booking_info">
                        <span class='reservation_info'>Reservation Number:
                            {{$r['reservation']['booking']['reference'] ?? '00-0000000'}}</span>
                        <span class='reservation_info'>Booked on:
                                {{date('j  M  Y',strtotime($r["created_at"])) ?? '1 Oct 2020'}}</span>
                    </div>
                    <div class="booking_wrapper">
                        <div class="reservation_left">
                            <img src="http://photos.hotelbeds.com/giata/bigger/{{$r['h']->images[0]['path'] ?? '00/008327/008327a_hb_r_004.jpg'}}"
                                alt="">
                        </div>
                        <div class='reservation_right'>
                            <div class="name_stars_wrapper">
                                <span
                                    class="hotel_name">{{$r['reservation']['booking']['hotel']['name'] ?? 'Hotel Sample'}}<sup>{{$r['h']->stars_symbol  ?? '★★'}}</sup></span>
                            </div>
                            <div class="hotel_address"><i class="fas fa-map-marker-alt" aria-hidden="true"></i>{{$r['h']->address ?? 'Avenida
                                Almirante
                                Reis, 188, Lisboa, 1000-055,
                                Portugal'}}</div>
                            <div class="dates_wrapper">
                                <div class="length_wrapper">
                                    <span class="lenght_tittle">Length of stay:</span>
                                    <span class="lenght">{{$r['h']->nights_text  ?? '1 night'}}</span>
                                </div>
                                <div class="dates">
                                    <div class="date_box">
                                        <span class="date_tittle">Check-in</span>
                                        <span
                                            class="date">{{isset($r) ? date('D j  M  Y',strtotime($r['reservation']['booking']['hotel']['checkIn'])) : 'Sat 3 Oct 2020'}}</span>
                                        <span class="hour">From
                                            {{substr($r['h']->policies['Check-in and check-out'][0]??'15:00',-5)}}</span>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="date_box">
                                        <span class="date_tittle">Check-out</span>
                                        <span
                                            class="date">{{isset($r) ? date('D j  M  Y',strtotime($r['reservation']['booking']['hotel']['checkOut'])) :  'Thu 15 Oct 2020'}}</span>
                                        <span class="hour">Until
                                            {{substr($r['h']->policies['Check-in and check-out'][1]??'11:00',-5)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

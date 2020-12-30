@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/confirmation.css')}} />
@append

@inject('MyLibrary', 'App\Libraries\MyLibrary')

@section('content')
<div class="confirmation_wrapper">
    <div class='top'>
        <div class='thank_you'> Thank you {{$r->first_name}}!</div>
        <div class='congratulations'><i class="far fa-thumbs-up"></i>Congratulations! Your Booking is confirmed.
        </div>
        <button class='print' onclick="window.print()"><i class="fas fa-print"></i>Print your reservation</button>
        <ul class="fa-ul">
            <li><i class="fa-li fa fa-check"></i>We sent you a confirmation email to
                <strong>{{$r->email}}</strong>
            </li>
            <li><i
                    class="fa-li fa fa-check"></i><strong>{{$r['reservation']['booking']['hotel']['name']}}</strong>
                is
                expecting you on the
                <strong>{{date('j \of F',strtotime($r['reservation']['booking']['hotel']['checkIn']))}}</strong>
            </li>
            <li><i class="fa-li fa fa-check"></i>You can contact the property directly by email to
                <strong>{{$h->email}}</strong> or by
                phone to <strong>{{$h->phone}}</strong></li>
        </ul>
    </div>
    <div class="hotel_wrapper">
        <img src="http://photos.hotelbeds.com/giata/bigger/{{ $h->images[0]["path"]  ?? '36/363373/363373a_hb_a_001.jpg'}}"
            alt="">
        <div class="hotel_info">
            <div class='hotel_name'>{{$r['reservation']['booking']['hotel']['name'] ?? 'Royal Hotel'}}
                <sup>{{ $h->stars_symbol ?? '★★★★★'}}</sup></div>
            <div class="hotel_address"><i
                    class="fas fa-map-marker-alt"></i>{{ $h->address ?? 'Rua John Doe 99, 1234-123 Lisboa'}}
            </div>
            <div class="phone"><i class="fas fa-phone"></i>{{$h->phone ?? '123456789'}}</div>
            <div class="email"><i class="fas fa-envelope"></i>{{$h->email ?? 'info@royalhotel.com'}}
            </div>
            <div class="dates_wrapper">
                <div class="date_box">
                    <span class="date_tittle">Check-in</span>
                    <span
                        class="date">{{isset($r) ? date('D j  M  Y',strtotime($r['reservation']['booking']['hotel']['checkIn'])) : 'Sun 11 Oct 2020'}}</span>
                    <span class="hour">From {{substr($h->policies['Check-in and check-out'][0]??'15:00',-5)}}</span>
                </div>
                <div class="divider"></div>
                <div class="date_box">
                    <span class="date_tittle">Check-out</span>
                    <span
                        class="date">{{isset($r) ? date('D j  M  Y',strtotime($r['reservation']['booking']['hotel']['checkOut'])) :  'Thu 15 Oct 2020'}}</span>
                    <span class="hour">Until
                        {{substr($h->policies['Check-in and check-out'][1]??'11:00',-5)}}</span>
                </div>
            </div>
        </div>
    </div>

    <div class='reservations_details'>
        <div class='detail'>
            <span class='detail_tittle'>Reservation Number</span>
            <span class='detail_content'>{{$r['reservation']['booking']['reference']}}</span>
        </div>
        <div class='detail'>
            <span class='detail_tittle'>Holder Name</span>
            <span
                class='detail_content'>{{$MyLibrary->titleCase($r['reservation']['booking']['holder']['name'] . " " . $r['reservation']['booking']['holder']['surname'])}}</span>
        </div>
        <div class='detail'>
            <span class='detail_tittle'>Number of Guests</span>
            <span class='detail_content'>{{$h->adults_text}}{{$h->children > 0 ? ", " . $h->children_text : ""}}</span>
        </div>
        <div class='detail'>
            <span class='detail_tittle'>Rooms</span>
            <span class='detail_content'>{{$r['reservation']['booking']['hotel']['rooms'][0]['rates']['0']['rooms']}} x {{$MyLibrary->titleCase($r['reservation']['booking']['hotel']['rooms'][0]['name'])}}</span>
        </div>
        <div class='detail'>
            <span class='detail_tittle'>Total length of stay</span>
            <span class='detail_content'>{{$h->nights_text}}</span>
        </div>
        <div class='detail'>
            <span class='detail_tittle'>Check-in</span>
            <span
                class='detail_content'>{{date('D j  M  Y',strtotime($r['reservation']['booking']['hotel']['checkIn']))}}</span>
        </div>
        <div class='detail'>
            <span class='detail_tittle'>Check-out</span>
            <span
                class='detail_content'>{{date('D j  M  Y',strtotime($r['reservation']['booking']['hotel']['checkOut']))}}</span>
        </div>
        <div class='detail'>
            <span class='detail_tittle'>Cancellation Policy</span>
            <span
                class='detail_content'>{{'Non-refundable rate'}}:
                If cancelled, modified
                or in case of
                no-show, the total price of the reservation will not be refunded.</span>
        </div>
        @isset($r['special_requests'])
        <div class='detail'>
            <span class='detail_tittle'>Special requests</span>
            <span class='detail_content'>{{$r['special_requests']}}</span>
        </div>
        @endisset
        @if(!isset($r))
        <div class='detail'>
            <span class='detail_tittle'>Special requests</span>
            <span class='detail_content'>If possible, we would a love a room in a top floor with a view. Thank
                you!</span>
        </div>
        @endisset
    </div>

    <div class='price_details'>
        <div class='price'>
            <span class='price_tittle'>1 x Double or Twin Room with Private Ensuite Bathroom</span>
            <span class='price_content'>€
                {{isset($r) ? round($r['reservation']['booking']['hotel']['rooms'][0]['rates'][0]['sellingRate']/1.06,2) : '54.57'}}</span>
        </div>
        <div class='price'>
            <span class='price_tittle'>6% VAT Included</span>
            <span class='price_content'>€
                {{isset($r) ? round($r['reservation']['booking']['hotel']['rooms'][0]['rates'][0]['sellingRate']/1.06*0.06,2) : '3.27'}}</span>
        </div>
        <div class='price total'>
            <span class='price_tittle'>Total Price</span>
            <span class='price_content'>€
                {{isset($r) ? $r['reservation']['booking']['hotel']['rooms'][0]['rates'][0]['sellingRate'] : '57.84'}}</span>
        </div>
        <div class="price_info">The full amount of the reservation was already paid and the booking is confirmed.
        </div>
        <div class="price_info">Please note that this is a non-refundable reservation and if cancelled, modified or
            in case of no-show, the total price of the reservation will not be refunded.</div>
        <div class="price_info">On arrival to the property it is due the city tourist
            tax of 2€ per person per night which is not included in the price.</div>
        <div class="price_info">All Special Requests are subject to availability and additional
            charges may apply.</div>
        <div class="price_info">Guests are required to show identification upon check-in.</div>
    </div>
</div>
@endsection

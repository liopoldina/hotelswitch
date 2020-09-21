@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/confirmation.css')}} />
@append

@inject('MyLibrary', 'App\Libraries\MyLibrary')


@section('content')
<div class="internal">
    <div class="internal_wrapper">
        <div class='top'>
            <div class='thank_you'> Thank you Pedro!</div>
            <div class='congratulations'><i class="far fa-thumbs-up"></i>Congratulations! Your Booking is confirmed.
            </div>
            <ul class="fa-ul">
                <li><i class="fa-li fa fa-check"></i>We sent you a confirmation email to
                    <strong>pfparames@gmail.com</strong>
                </li>
                <li><i class="fa-li fa fa-check"></i><strong>Rossio Garden Hotel</strong> is expecting you on the
                    <strong>11 of October</strong></li>
                <li><i class="fa-li fa fa-check"></i>You can contact the property directly by email to
                    <strong>info@rossiogardenhotel.com</strong> or by
                    phone to <strong>00351213404240</strong></li>
            </ul>

            <button class='print' onclick="window.print()"><i class="fas fa-print"></i>Print your reservation</button>

        </div>
        <div class="hotel_wrapper">
            <img src="http://photos.hotelbeds.com/giata/bigger/06/061830/061830a_hb_a_010.jpg" alt="">
            <div class="hotel_info">
                <div class='hotel_name'>Rossio Garden Hotel <sup>★★★★★</sup></div>
                <div class="hotel_address"><i class="fas fa-map-marker-alt"></i>R. do Jardim do Regedor 24, 1150-193
                    Lisboa </div>
                <div class="phone"><i class="fas fa-phone"></i>00351213404240</div>
                <div class="email"><i class="fas fa-envelope"></i>info@rossiogardenhotel.com</div>
                <div class="dates_wrapper">
                    <div class="date_box">
                        <span class="date_tittle">Check-in</span>
                        <span class="date">Sun 11 Oct 2020</span>
                        <span class="hour">From 14:00</span>
                    </div>
                    <div class="divider"></div>
                    <div class="date_box">
                        <span class="date_tittle">Check-out</span>
                        <span class="date">Thu 15 Oct 2020</span>
                        <span class="hour">Until
                            12:00</span>
                    </div>
                </div>


            </div>
        </div>

        <div class='reservations_details'>
            <div class='detail'>
                <span class='detail_tittle'>Reservation Number</span>
                <span class='detail_content'>1121001</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Guest Name</span>
                <span class='detail_content'>Pedro Costa</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Number of Guests</span>
                <span class='detail_content'>2 adults</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Room Type</span>
                <span class='detail_content'>1 x Double or Twin Room with Private Ensuite
                    Bathroom</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Total length of stay</span>
                <span class='detail_content'>4 nights</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Check-in</span>
                <span class='detail_content'>Sun 11 Oct 2020</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Check-out</span>
                <span class='detail_content'>Thu 15 Oct 2020</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Cancellation Policy</span>
                <span class='detail_content'>Non-refundable rate: If cancelled, modified
                    or in case of
                    no-show, the total price of the reservation will not be refunded.</span>
            </div>
            <div class='detail'>
                <span class='detail_tittle'>Special requests</span>
                <span class='detail_content'>If possible, we would a love a room in a top floor with a view. Thank
                    you!</span>
            </div>
        </div>

        <div class='price_details'>
            <div class='price'>
                <span class='price_tittle'>1 x Double or Twin Room with Private Ensuite Bathroom</span>
                <span class='price_content'>€ 54.57</span>
            </div>
            <div class='price'>
                <span class='price_tittle'>6% VAT Included</span>
                <span class='price_content'>€ 3.27</span>
            </div>
            <div class='price total'>
                <span class='price_tittle'>Total Price</span>
                <span class='price_content'>€ 57.84</span>
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
</div>
@endsection

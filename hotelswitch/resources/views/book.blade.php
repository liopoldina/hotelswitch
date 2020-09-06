@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/book.css')}} />
@append

@section('content')
<div class="internal">
    <div class="internal_wrapper">
        <div class="left">
            <div class="left_box">
                <div class="box_tittle">
                    <span>Property Details</span>
                </div>
                <img src="http://photos.hotelbeds.com/giata/bigger/36/363373/363373a_hb_a_001.jpg" alt="">
                <span class='hotel_name'>Rossio Garden Hotel</span>
                <span class='hotel_address'>Rua Jardim do Regedor, 24, Lisboa, 1150-194, Portugal</span>
                <div class="score">
                    <span>Fabulous </span>
                    <span>8.8</span>
                </div>
                <span class='reviews'>506 guest reviews</span>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Stay Dates</span>
                </div>

                <div class="dates_wrapper">
                    <div class="date_box">
                        <span class="date_tittle">Check-in</span>
                        <span class="date">Sun 11 Oct 2020</span>
                        <span class="hour">From 14:00</span>
                    </div>
                    <div class='divider'></div>
                    <div class="date_box">
                        <span class="date_tittle">Check-out</span>
                        <span class="date">Thu 15 Oct 2020</span>
                        <span class="hour">Until 12:00</span>
                    </div>
                </div>
                <span class='lenght_tittle'>Total length of stay:</span>
                <span class='lenght'>4 nights</span>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Room Selection</span>
                </div>
                <div class='room_type'>
                    <span>1</span>
                    <span>x</span>
                    <span>Double or Twin Room with Private Ensuite Bathroom</span>
                </div>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Price Summary</span>
                </div>
                <div class="price_line">
                    <span>1 Room</span>
                    <span>€ 54.57</span>
                </div>
                <div class="price_line">
                    <span>6% VAT</span>
                    <span>€ 3.27</span>
                </div>
                <div class="total_price">
                    <span>Total Price</span>
                    <span>€ 57.84</span>
                </div>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Cancellation Policy</span>
                </div>
                <span class='policy_tittle'>Non-refundable rate</span>
                <span class='policy_text'>Please note, if cancelled, modified or in case of no-show, the total
                    price of the reservation will
                    be charged.</span>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Additional Information</span>
                </div>
                <div class="additional_item">
                    <span class='additional_tittle'>City Tourist Tax</span>
                    <span class='additional_text'>On arrival to the property it is due the city tourist tax of 2€ per
                        person per
                        night.</span>
                </div>
            </div>
        </div>
        <div class="right">
            <form id='confirmation' action="confirmation" method='post'>
                @csrf
                <div class="step">
                    <i class="fas fa-user"></i>
                    <span>Step 1: Your details</span>
                </div>
                <div class="right_box">
                    <div class="name_wrapper">
                        <div class="input_wrapper">
                            <label for="first_name">First name</label>
                            <input type="text" id='first_name'>
                        </div>
                        <div class="input_wrapper">
                            <label for="last_name">Last name<span class='mandatory'>*</span></label>
                            <input type="text" id='last_name'>
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <label for="email">Email address<span class='mandatory'>*</span></label>
                        <input type="text" id='email'>
                        <span>Confirmation email goes to this address</span>
                    </div>
                    <div class="input_wrapper">
                        <label for="confirm_email">Confirm email address<span class='mandatory'>*</span></label>
                        <input type="text" id='confirm_email'>
                    </div>
                    <div class="input_wrapper">
                        <label for="phone">Cell phone number<span class='mandatory'>*</span></label>
                        <input type="number" id='phone'>
                        <span>We’ll only contact you in an emergency</span>
                    </div>
                    <div class='mandatory_wrapper'>
                        Almost done! Just fill in the <em>*</em> required info
                    </div>
                </div>
                <div class="step">
                    <i class="fas fa-bed"></i>
                    <span>Step 2: Room details</span>
                </div>
                <div class="right_box">
                    <span class='room_name'>Double or Twin Room with Private Ensuite Bathroom</span>
                    <div class="amenities">
                        <div class="amenity">
                            <i class="fas fa-wifi" aria-hidden="true"></i>
                            <span>Free Wi-fi</span>
                        </div>
                        <div class="amenity">
                            <i class="fas fa-fan" aria-hidden="true"></i>
                            <span>Air conditioning</span>
                        </div>
                        <div class="amenity">
                            <i class="fas fa-bath"></i>
                            <span>Ensuite bathroom</span>
                        </div>
                        <div class="amenity">
                            <i class="fas fa-tv"></i>
                            <span>Flat-screen TV</span>
                        </div>
                        <div class="amenity">
                            <i class="fas fa-volume-mute"></i>
                            <span>Soundproofing</span>
                        </div>
                    </div>
                </div>
                <div class="step">
                    <i class="fas fa-lock"></i>
                    <span>Step 3: Payment details</span>
                </div>
                <div class="right_box">
                    <div class="input_wrapper">
                        <label for="card_name">Cardholder's name<span class='mandatory'>*</span></label>
                        <input type="text" id='card_name'>
                    </div>
                    <div class="input_wrapper">
                        <label for="card_number">Card number<span class='mandatory'>*</span></label>
                        <input type="number" id='card_number' maxlength="20" placeholder='0000 0000 0000 0000'>
                    </div>
                    <div class="input_wrapper">
                        <label for="expiry_month">Expiry date<span class='mandatory'>*</span></label>
                        <input type="number" id='expiry_month' maxlength="2" placeholder='MM'>
                        <span id=expiry_divider>/</span>
                        <input type="number" id='expiry_year' maxlength="2" placeholder='YY'>

                    </div>
                    <div class="input_wrapper">
                        <label for="cvc">CVC-code<span class='mandatory'>*</span></label>
                        <input type="number" id='cvc' maxlength="4" placeholder='000'>
                    </div>
                    <div class='payment_info'>
                        <span>We accept the following payment methods</span>
                        <img src={{asset("/images/book/credit_card/visa.svg")}} alt="">
                        <img src={{asset("/images/book/credit_card/mastercard.svg")}} alt="">
                        <img src={{asset("/images/book/credit_card/maestro.svg")}} alt="">
                        <img src={{asset("/images/book/credit_card/amex.svg")}} alt="">
                        <img src={{asset("/images/book/credit_card/diners.svg")}} alt="">
                        <img src={{asset("/images/book/credit_card/jcb.svg")}} alt="">
                        <img src={{asset("/images/book/credit_card/discover.svg")}} alt="">
                        <div class="secure_wrapper">
                            <span>Your booking is safe and secure</span>
                            <div class="secure_item">
                                <i class="fas fa-check"></i>
                                <span>We use secure connection</span>
                            </div>
                            <div class="secure_item">
                                <i class="fas fa-check"></i>
                                <span>We protect your personal information</span>
                            </div>
                            <i class="fas fa-user-lock lock"></i>
                        </div>
                    </div>
                </div>
                <div class='booking_terms'>
                    <span>Your booking is with the Hotel directly and by completing this booking you agree to have read
                        and
                        accept the <em>Cancellation Policy</em> our <a href="">Terms of Service</a> and our <a
                            href="">Privacy
                            Policy</a>.</span>
                </div>
                <div class="confirm_wrapper">
                    <span>You will receive an instant confirmation in your email</span>
                    <button class='confirm_button' type='submit'><i class="fas fa-lock"></i>Confirm Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

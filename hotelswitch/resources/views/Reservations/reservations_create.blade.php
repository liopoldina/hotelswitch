@extends('layouts.master')

@include('childs.head')

@section('head')
<link rel="stylesheet" href={{asset('css/book.css')}} />
<script src={{asset('jquery-validate\jquery.validate.js')}}></script>
<script src={{asset('jquery-validate\additional-methods.js')}}></script>
<script src={{asset('js/book.js')}}></script>
@append

@inject('MyLibrary', 'App\Libraries\MyLibrary')


@section('content')
<div class="internal">
    <div class="internal_wrapper">
        <div class="left">
            <div class="left_box">
                <div class="box_tittle">
                    <span>Property Details</span>
                </div>
                <img src="{{ $h->images[0]  ?? 'http://photos.hotelbeds.com/giata/bigger/36/363373/363373a_hb_a_001.jpg'}}"
                    alt="">
                <span class='hotel_name'>{{ $rate->hotel->name  ?? 'Rossio Garden Hotel'}}</span>
                <span
                    class='hotel_address'>{{ $h->address  ?? 'Rua Jardim do Regedor, 24, Lisboa, 1150-194, Portugal'}}</span>
                <div class="score">
                    <span>{{ $h->quality  ?? 'Fabulous'}}</span>
                    <span>{{ $h->score  ?? '8.8'}}</span>
                </div>
                <span class='reviews'>{{ $h->nr_reviews  ?? '516'}} guest reviews</span>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Stay Dates</span>
                </div>

                <div class="dates_wrapper">
                    <div class="date_box">
                        <span class="date_tittle">Check-in</span>
                        <span
                            class="date">{{ isset($rate) ? date("D j M Y",strtotime($rate->hotel->checkIn))  : 'Sun 11 Oct 2020'}}</span>
                        <span class="hour">From {{substr($h->policies['Check-in and check-out'][0]??'14:00',-5)}}</span>
                    </div>
                    <div class='divider'></div>
                    <div class="date_box">
                        <span class="date_tittle">Check-out</span>
                        <span
                            class="date">{{ isset($rate) ? date("D j M Y",strtotime($rate->hotel->checkOut)) : 'Thu 15 Oct 2020'}}</span>
                        <span class="hour">Until
                            {{substr($h->policies['Check-in and check-out'][1]??'12:00',-5)}}</span>
                    </div>
                </div>
                <span class='lenght_tittle'>Total length of stay:</span>
                <span class='lenght'>{{ $h->nights_text  ?? '4 nights'}}</span>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Room Selection</span>
                </div>
                <div class='room_type'>
                    <span>1</span>
                    <span>x</span>
                    <span>{{isset($rate) ? $MyLibrary->titleCase($rate->hotel->rooms[0]->name) : 'Double or Twin Room with Private Ensuite Bathroom'}}</span>
                </div>
            </div>
            <div class="left_box">
                <div class="box_tittle">
                    <span>Price Summary</span>
                </div>
                <div class="price_line">
                    <span>1 Room</span>
                    <span>€
                        {{isset($rate) ? round($rate->hotel->rooms[0]->rates[0]->sellingRate/1.06,2) : '54.57'}}</span>
                </div>
                <div class="price_line">
                    <span>6% VAT</span>
                    <span>€
                        {{isset($rate) ? round($rate->hotel->rooms[0]->rates[0]->sellingRate/1.06*0.06,2) : '3.27'}}</span>
                </div>
                <div class="total_price">
                    <span>Total Price</span>
                    <span>€ {{isset($rate) ? $rate->hotel->rooms[0]->rates[0]->sellingRate : '57.84'}}</span>
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
            <form id='booking_form' action="book" method='post'>
                @csrf
                <input type="hidden" name="rateKey"
                    value="20200918|20200919|W|59|363373|DBL.ST|NRF-BAR|BB||1~2~0||N@03~~200e1~338881005~S~6CB7A556AFB24DC160042323544400AWUK00001590000000010248d8">
                <div class="step">
                    <i class="fas fa-user"></i>
                    <span>Step 1: Your details</span>
                </div>
                <div class="right_box">
                    <div class="name_wrapper">
                        <div class="input_wrapper">
                            <label for="first_name">First name</label>
                            <input type="text" id='first_name' name='first_name' required maxlength="30"
                                value={{old('first_name')}}>
                            @error('first_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input_wrapper">
                            <label for="last_name">Last name<span class='mandatory'>*</span></label>
                            <input type="text" id='last_name' name='last_name' required maxlength="30"
                                value={{old('last_name')}}>
                            @error('last_name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="input_wrapper">
                        <label for="email">Email address<span class='mandatory'>*</span></label>
                        <input type="text" id='email' name='email' required value={{old('email')}}>
                        <span class='info'>Confirmation email goes to this address</span>
                        @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input_wrapper">
                        <label for="email_confirmation">Confirm email address<span class='mandatory'>*</span></label>
                        <input type="text" id='email_confirmation' name='email_confirmation' required
                            value={{old('email_confirmation')}}>
                        @error('email_confirmation')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input_wrapper">
                        <label for="phone">Cell phone number<span class='mandatory'>*</span></label>
                        <input type="number" id='phone' name='phone' required value={{old('phone')}}>
                        <span class='info'>We’ll only contact you in an emergency</span>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
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
                    <span
                        class='room_name'>{{isset($rate) ? $MyLibrary->titleCase($rate->hotel->rooms[0]->name) : 'Double or Twin Room with Private Ensuite Bathroom'}}</span>
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
                    <div class="room_box">
                        <div class="room_left">
                            <img src="http://photos.hotelbeds.com/giata/bigger/41/419658/419658a_hb_ro_023.jpg" alt="">
                        </div>
                        <div class="room_right">

                            <div class="room_capacity">
                                <div class="guests_icon">
                                    @for($g=0; $g < $h->adults; $g++)<img src="./images/search/guest_icon.png"
                                            alt="guest_icon">@endfor
                                </div>
                                <span class="offer_guests">{{$h->adults_text}}</span>
                            </div>
                            <label for='special_requests'>Special Requests</label>
                            <textarea type="text" id='special_requests' name='special_requests'
                                maxlength="350"></textarea>
                            @error('special_requests')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
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
                        <input type="text" maxlength="30" id='card_name' name='card_name' required
                            value={{old('card_name')}}>
                        @error('card_name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input_wrapper">
                        <label for="card_number">Card number<span class='mandatory'>*</span></label>
                        <input type="number" id='card_number' name='card_number' required value={{old('card_number')}}>
                        @error('card_number')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input_wrapper">
                        <label for="expiry_month">Expiry date<span class='mandatory'>*</span></label>
                        <select name="expiry_month" id="expiry_month" placeholder='MM' required
                            value={{old('expiry_month')}}>
                            <option value="MM">MM</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <span id=expiry_divider>/</span>
                        <select name="expiry_year" id="expiry_year" placeholder='YY' required
                            value={{old('expiry_year')}}>
                            <option value="YY">YY</option>
                            @for($i=20;$i<=50;$i++) <option value={{$i}}>{{$i}}</option>
                                @endfor
                        </select>
                        @error('expiry_month')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                        @error('expiry_year')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input_wrapper">
                        <label for="cvc">CVC-code<span class='mandatory'>*</span></label>
                        <input type="text" id='cvc' name='cvc' placeholder='000' maxlength="4" required
                            value={{old('cvc')}}>
                        @error('cvc')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
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

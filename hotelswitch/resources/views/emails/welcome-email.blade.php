@component('mail::message')
Welcome to HotelSwitch.com

Thank you for creating your account.

Please verify your email so you can start managing your bookings.

@component('mail::button', ['url' => ''])
Verify Email
@endcomponent

All the best,<br>
{{ config('app.name') }}
@endcomponent

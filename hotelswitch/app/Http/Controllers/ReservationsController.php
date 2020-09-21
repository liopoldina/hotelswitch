<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;

use App\Libraries\MyLibrary;

use App\Repositories\ReservationsRepository;
use App\Repositories\HotelRepository;


class ReservationsController extends Controller
{
    public function create()
    {
        $data = request()->validate([
            'rateKey' => 'string|max:200',
            'collection_name' => 'string|max:200'
        ]);

    $rate = ReservationsRepository::CheckRate($data['rateKey']); 

    $m=  new \stdClass();

    $m->collection_name = $data["collection_name"];
    $m->hotel_id = $rate->hotel->code;
    
    $h = HotelRepository::get_hotel($m);

    return view('Reservations.reservations_create',[
        'rate' => $rate,
        'h' => $h
    ]);
    
    }

    public function store()
    {
        $data = request()->validate([
            'rateKey' => 'required|string|max:200',
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|email',
            'email_confirmation' => 'required|email|same:email',
            'phone' => 'required|numeric|digits_between:6,25',
            'special_requests' => 'nullable|string|max:350',
            'card_name' => 'required|string|max:30',
            'card_number' => 'required|numeric|digits_between:12,19',
            'expiry_month' => 'required|numeric|min:1|max:12',
            'expiry_year' => 'required|numeric|min:20|max:50',
            'cvc' => 'required|numeric|digits_between:3,4',
        ]);


        Reservation::create($data);

        $hash = 'A7D490E401D6676D9114BCF343F23B534B1AD666B03020C86CB0F6A3A94B8368';

        return redirect()->route('reservations.confirmation', $hash);
    }

    public function confirmation(){
        return view('Reservations.reservations_confirmation');
    }
    
    
}

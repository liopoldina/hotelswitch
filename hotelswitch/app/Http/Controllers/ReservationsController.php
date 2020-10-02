<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Static_Hotel;

use App\Libraries\MyLibrary;

use App\Repositories\ReservationsRepository;

class ReservationsController extends Controller
{
    public function create()
    {
        $data = request()->validate([
            'rateKey' => 'string|max:200',
            'collection_name' => 'string|max:200'
        ]);

        $rate = ReservationsRepository::CheckRate($data['rateKey']); 
        
        if (!isset($rate->hotel->rooms[0]->rates[0]->sellingRate)){   // set selling rate
        $rate->hotel->rooms[0]->rates[0]->sellingRate =  round($rate->hotel->rooms[0]->rates[0]->net * 1.06,2);
        }
        
        $m=  new \stdClass();
        
        $m->collection_name = $data["collection_name"];
        $m->hotel_id = $rate->hotel->code;
        
        $h = ReservationsRepository::get_hotel($m);
        
        // get room image
        foreach($h->offer as $offer){
            if($offer["code"] == $rate->hotel->rooms[0]->code){
                $rate->hotel->rooms[0]->image = $offer["images"][0]["path"];
                break;
            }
        }
        
        return view('Reservations.reservations_create',[
            'rate' => $rate,
            'h' => $h,
            'm' => $m
        ]);
        
    }

    public function store()
    {
        $data = request()->validate([
            'rateKey' => 'required|string|max:200',
            'collection_name' =>'required|string|max:200',
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

        // hotelbeds book
        $reservation = ReservationsRepository::Book($data); 

        if(!isset($reservation->booking->hotel->rooms[0]->rates[0]->sellingRate)){
            $reservation->booking->hotel->rooms[0]->rates[0]->sellingRate = round($reservation->booking->hotel->rooms[0]->rates[0]->net * 1.06,2);
        }

        $data = ['reservation' => $reservation] + $data;

        // generate id
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = rand ( 200 , 300 );        ;
        $id = substr(str_shuffle(str_repeat($permitted_chars, ceil($length/strlen($permitted_chars )) )),1,$length);

        $data = ['id' => $id] + $data;

        Reservation::create($data);

        return redirect()->route('reservations.confirmation',  ['id'=> $data['id']]);
    }

    public function confirmation(){

        $data = request()->validate([
            'id' => 'string|min:200|max:300',
        ]);

        $reservation = Reservation::find($data['id']);

        if(isset($reservation)){
            $m=  new \stdClass();
            $m->collection_name = $reservation["collection_name"];
            $m->hotel_id = $reservation["reservation"]["booking"]["hotel"]["code"];
            
            $h = ReservationsRepository::get_hotel($m);
            
            return view('Reservations.reservations_confirmation',[
                'r' => $reservation,
                'h'=> $h,
                ]);
        }else{ 
            // template
            return view('Reservations.reservations_confirmation');
        }
    }
}

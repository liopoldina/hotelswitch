<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reservation;
use App\Models\Static_Hotel;

use App\Libraries\MyLibrary;

use App\Repositories\ReservationsRepository;

use Illuminate\Validation\ValidationException;

class ReservationsController extends Controller
{
    public function create()
    {
        $data = request()->validate([
            'rateKey' => 'string|max:200',
            'adults' => 'numeric|min:1|max:8',
            'children' => 'numeric|min:0|max:2',
        ]);

        $m=  new \stdClass();
        $m->adults = $data['adults'];
        $m->children= $data['children'];

        $r = ReservationsRepository::CheckRate($data['rateKey']); 

        if($m->adults + $m->children > ($r->hotel->rooms[0]->rates[0]->adults + $r->hotel->rooms[0]->rates[0]->children) * $r->hotel->rooms[0]->rates[0]->rooms){
            throw ValidationException::withMessages(['guests' => 'Room capacity excedded']);
        }

        $h = ReservationsRepository::get_hotel($r->hotel->code, $r);
        
        // get room image
        foreach($h->images as $image){
            if(isset($image["roomCode"]) && $image["roomCode"] == $r->hotel->rooms[0]->code){
                $r->hotel->rooms[0]->image = $image["path"];
                break;
            }
        }
        
        return view('Reservations.reservations_create',[
            'r' => $r,
            'h' => $h,
            'm' => $m
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

        // hotelbeds book
        $r = ReservationsRepository::Book($data); 

        // generate id
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = rand ( 200 , 300 );
        $id = substr(str_shuffle(str_repeat($permitted_chars, ceil($length/strlen($permitted_chars )) )),1,$length);

        Reservation::create(
            [
            'id' => $id,
            'reservation' => $r 
            ] +
            $data
        );

        return redirect()->route('reservations.confirmation',  ['id'=> $id]);
    }

    
    public function confirmation(){

        $data = request()->validate([
            'id' => 'string|min:200|max:300',
        ]);

        $r = Reservation::find($data['id'])->toArray();
      
        $h = ReservationsRepository::get_hotel($r["reservation"]["booking"]["hotel"]["code"], $r);
        
        return view('Reservations.reservations_confirmation',[
            'r' => $r,
            'h'=> $h,
            ]);
       
    }
}

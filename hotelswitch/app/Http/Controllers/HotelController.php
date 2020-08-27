<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\HotelRepository;

class HotelController extends Controller
{
    public function index()
    {
        $m = json_decode(request()->m);
        $m->hotel_id =intval(request()->hotel_id);

        $h = HotelRepository::get_hotel($m);
        
       return view('hotel',[
                    'h' => $h,
                    'm' => $m
                ]);
  
    }
    
}

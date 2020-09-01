<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Static_Hotel;

use App\Repositories\HotelRepository;
use App\Repositories\MRepository;


class HotelController extends Controller
{
    public function index()
    {
        if(request()->has('m')){
        // case directly from search results
        $m = json_decode(request()->m);
        $m->hotel_id =intval(request()->hotel_id);
        } 
        else{
        // case directly to hotel page (needs to get collection first)
        $m=  new \stdClass();
        $m = MRepository::m($m);   
        $m->hotel_id =intval(request()->hotel_id);
        // adapt search repository get_collection to be able to also get by id
        }

        $h = HotelRepository::get_hotel($m);
        
        return view('hotel',[
                    'h' => $h,
                    'm' => $m
                ]);
    }
    
}

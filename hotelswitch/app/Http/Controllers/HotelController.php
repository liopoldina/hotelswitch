<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;


use App\Models\Static_Hotel;

use App\Repositories\HotelRepository;
use App\Repositories\MRepository;
use App\Repositories\SearchRepository;

use App\Libraries\MyLibrary;

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
        // case loading hotel page with just id (needs to get collection first)
        $m=  new \stdClass();
        $m = MRepository::m($m);   
        $m->hotel_id =intval(request()->hotel_id);
        $m->collection_name = $m->hotel_id ."_". $m->check_in ."_". $m->check_out ."_". $m->rooms ."_". $m->adults ."_".$m->children;
        if (!Schema::connection('hotelbeds')->hasTable($m->collection_name)){
            SearchRepository::get_collection($m, 'id');
            }
        }

        $h = HotelRepository::get_hotel($m);

        if(!isset($m->destination)){ // case loading hotel page with just id
            $m->destination = MyLibrary::titleCase($h->city) . ", " . $h->country;
            $m->lat = $h->coords["lat"];
            $m->lon = $h->coords["lon"];
        }
        
        return view('hotel',[
                    'h' => $h,
                    'm' => $m
                ]);
    }
    
}

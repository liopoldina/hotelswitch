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
        $data = (object) request()->validate([
            'm' => 'json',
            'hotel_id' => 'required|numeric|min:0|max:999999',
        ]);

        if(isset($data->m)){
        // case directly from search results
        $m = json_decode($data->m);
        $m->hotel_id =intval($data->hotel_id);
        } 
        else{
        // case loading hotel page with just id (needs to get collection first)
        $m=  new \stdClass();
        $m = MRepository::m($m);   
        $m->hotel_id =intval($data->hotel_id);
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
        
        return view('Hotel.hotel_index',[
                    'h' => $h,
                    'm' => $m
                ]);
    }
    
}

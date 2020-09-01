<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Libraries\MyLibrary;

use App\Repositories\SearchRepository;
use App\Repositories\MRepository;

class SearchController extends Controller
{   
    public function index()
    {  
        // get parameters
        $m=  new \stdClass();

        if(request()->has('lat')){
            // case from search box (with coordinates)
            $m->lat =  request()->lat;
            $m->lon =  request()->lon;
            $m->destination = request()->destination;
        } else {
            // case from city link (just with destination name)
            [$m->lat, $m->lon,  $m->destination] = MyLibrary::geocode(request()->destination);
        }
    
       // formats and completes $m with defaults attributes if missing
        $m = MRepository::m($m); 

        // get collection if doesn't exists
        $m->collection_name = $m->lat ."_". $m->lon ."_".$m->check_in ."_". $m->check_out ."_". $m->rooms ."_". $m->adults ."_".$m->children;

        if (!Schema::connection('hotelbeds')->hasTable($m->collection_name)){
        SearchRepository::get_collection($m);
        }

        // filters
        $m->index = 0;
        $m->filters["sort"]= 'minRate';
        $m->filters["sort_order"] = 1;
        $m->filters["price_range"]["maximum_price"]=999;
        $m->filters["price_range"]["minimum_price"]=0;
        $m->filters["stars"]="5,4,3,2,1";
        $m->filters["distance_center"]=50;
        $m->filters["free_cancellation"]=false;
        $m->filters["minimum_score"]=0;

        [$hotel,$m] = SearchRepository::get_results($m);

        return view('search',[
            'hotel' => $hotel,
            'm' => $m
        ]);
    }
}

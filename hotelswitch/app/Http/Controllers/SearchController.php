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

        $data = (object) request()->validate([
            'destination' => 'required|string|max:255',
            'lat' => 'min:-90|max:90',
            'lon' => 'min:-180|max:180',
            'date_range' => 'string',
            'adults' => 'numeric|min:1|max:8',
            'children' => 'numeric|min:0|max:2',
            'rooms' => 'numeric|min:1|max:4'
        ]);

        // get parameters
        $m=  new \stdClass();

        if(isset($data->lat)){
            // case from search box (with coordinates)
            $m->lat =  $data->lat;
            $m->lon =  $data->lon;
            $m->destination = $data->destination;
        } else {
            // case from city link (just with destination name)
            [$m->lat, $m->lon,  $m->destination] = MyLibrary::geocode($data->destination);
        }
    
       // formats and completes $m with defaults attributes if missing
        $m = MRepository::m($m); 

        // get collection if doesn't exists
        $m->collection_name = $m->lat ."_". $m->lon ."_".$m->check_in ."_". $m->check_out ."_". $m->rooms ."_". $m->adults ."_".$m->children;

        if (!Schema::connection('hotelbeds')->hasTable($m->collection_name)){
        SearchRepository::get_collection($m, 'geolocation');
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

        return view('Search.search_index',[
            'hotel' => $hotel,
            'm' => $m
        ]);
    }

    public function show()
    {   

        $data = (object) request()->validate([
            'm' => 'required',
            'mode' => 'required|string|max:10',
        ]);
        
        $m = (object) $data->m;
        $mode = $data->mode;
        
        $m->next_index=(int)$m->next_index;
        $m->filters["sort_order"] = (float) $m->filters["sort_order"];
        $m->filters["price_range"]["maximum_price"]=(float)$m->filters["price_range"]["maximum_price"];
        $m->filters["price_range"]["minimum_price"]=(float)$m->filters["price_range"]["minimum_price"];
        $m->filters["distance_center"]=(float)$m->filters["distance_center"];
        $m->filters["minimum_score"]=(float)$m->filters["minimum_score"];


        switch ($mode){
            case "page":
                $m->index = $m->next_index;
                $m->take = 10;
                break;
        
            case "filter":
                $m->index = 0;
                $m->take = 10;
                break; 

            case "map":
                $m->take = 500;
                break;           
        }

        [$hotel,$m] = SearchRepository::get_results($m);

        return array('hotels'=>$hotel,'m'=>$m,);
    }
}

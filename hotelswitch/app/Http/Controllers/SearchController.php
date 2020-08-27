<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Repositories\SearchRepository;
class SearchController extends Controller
{   
    public function index()
    {  
        // get parameters
        $m=  new \stdClass();
        if (count(request()->all()) == 0) {
            $m->destination = "Lisbon";
            $m->destination_id ="1063515";
            $m->destination_id ="";
            $m->lat = 38.7125263493089;
            $m->lon = -9.138443771542375;            
            $m->date_range= date("m/d/yy") . " - " . date("m/d/yy", strtotime(date('m/d/yy') . "+1 days"));
            $m->adults = 2;
            $m->children = 0;
            $m->rooms = 1;
        }else  {
            $m = (object) request()->all();
        };

        // format variables
        $date_range_array = explode(' ',trim($m->date_range));
        $m->check_in = strtotime($date_range_array[0]);
        $m->check_out = strtotime($date_range_array[2]);
        $m->nights = ($m->check_out - $m->check_in)/86400;
        $m->check_in = date("yy-m-d", $m->check_in );
        $m->check_out = date("yy-m-d", $m->check_out );

        if ($m->nights==1) {$m->nights_text = $m->nights." night";}
        else  {$m->nights_text = $m->nights." nights";}

        if ($m->adults==1) {$m->adults_text = $m->adults." adult";}
        else  {$m->adults_text = $m->adults." adults";}

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

<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\SearchRepository;

class ResultsController extends Controller
{   
    private  $searchRepository;

    public function __construct(SearchRepository $searchRepository){
        $this->searchRepository = $searchRepository;
    }

    public function index()
    {  
        $m=(object) request()->m;
        $mode=request()->mode;
        
        $m->next_index=(int)$m->next_index;
        $m->filters["sort_order"] = (float) $m->filters["sort_order"];
        $m->filters["price_range"]["maximum_price"]=(float)$m->filters["price_range"]["maximum_price"];
        $m->filters["price_range"]["minimum_price"]=(float)$m->filters["price_range"]["minimum_price"];
        $m->filters["distance_center"]=(float)$m->filters["distance_center"];
        $m->filters["minimum_score"]=(float)$m->filters["minimum_score"];


        switch ($mode){
            case "page":
                $m->index = $m->next_index;
                break;
        
            case "filter":
                $m->index = 0;
                break;        
        }

        [$hotel,$m] = SearchRepository::get_results($m);

        return array('hotels'=>$hotel,'m'=>$m,);

    }
}

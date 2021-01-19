<?php

namespace App\Http\Controllers\Autocomplete;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{   

    public function index()
    {  
        $query = rawurlencode(request()->name);
        $sessiontoken = rawurlencode(request()->session);

        $key ='AIzaSyByN9fh3nvC4R9vn7G6BkNRnhoPbKYdMwk';

        $url="https://maps.googleapis.com/maps/api/place/autocomplete/json?type=geocode" .
        "&key=" . $key . 
        "&sessiontoken=" . $sessiontoken .
        "&input=" . $query;

        $json=file_get_contents($url);
        
        $json = json_decode ($json);
        
        for ($i = 0; $i < count($json->predictions); $i++) {
            $response[]=new \stdClass();
            $response[$i]->label = strip_tags($json->predictions[$i]->description);
            $response[$i]->place_id = $json->predictions[$i]->place_id;
            $response[$i]->coords = ['lat'=> 0,'lon'=>0];
        }
        
        $response = json_encode ($response);

        return $response;
    }
}

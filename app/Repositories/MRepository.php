<?php

namespace App\Repositories;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\DB;

use App\Libraries\MyLibrary;

class MRepository{

    // formats and completes $m
    public static function m($m) { 

        // set default attributes in case of missing
        $m->date_range = (request()->has('date_range') ? request()->date_range : date("d M Y", strtotime(date('d M Y') . "+1 days")) . " - " . date("d M Y", strtotime(date('d M Y') . "+2 days")));
        $m->adults = (request()->has('adults') ? request()->adults :"2");
        $m->children = (request()->has('children') ? request()->children :"0");
        $m->rooms = (request()->has('rooms') ? request()->rooms :"1");

        // only adults mode
        $m->adults_per_room = ceil(($m->adults + $m->children)  /  $m->rooms);
        $m->children_per_room = 0;

        // children mode (needs at least one children per room)
        if($m->children >= $m->rooms){
            
            $m->adults_per_room = ceil($m->adults /  $m->rooms);
            $m->children_per_room = ceil($m->children /  $m->rooms);
    
                if($m->adults % 2 == 1 && $m->children % 2 == 1 && $m->rooms >= 2 && $m->adults_per_room >= 2 ){ 
                    $m->adults_per_room = $m->adults_per_room - 1;
                } 
        }

        // format variables
        $date_range_array = explode('- ',trim($m->date_range));
        $m->check_in = strtotime($date_range_array[0]);
        $m->check_out = strtotime($date_range_array[1]);
        $m->nights = ($m->check_out - $m->check_in)/86400;
        $m->check_in = date("Y-m-d", $m->check_in );
        $m->check_out = date("Y-m-d", $m->check_out );

        $m->nights_text = MyLibrary::number_text($m->nights,"nights");
        $m->adults_text = MyLibrary::number_text($m->adults,"adults");
        $m->rooms_text = MyLibrary::number_text($m->rooms,"rooms");
        $m->children_text = MyLibrary::number_text($m->children,"children");
        if ($m->children==0) {$m->children_text = "";}

        return $m;
    }

}

?>
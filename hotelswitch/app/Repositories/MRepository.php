<?php

namespace App\Repositories;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\DB;

use App\Libraries\MyLibrary;

class MRepository{

    // formats and completes $m
    public static function m($m) { 

        // set default attributes in case of missing
        $m->date_range = (request()->has('date_range') ? request()->date_range : date("m/d/yy", strtotime(date('m/d/yy') . "+1 days")) . " - " . date("m/d/yy", strtotime(date('m/d/yy') . "+2 days")));
        $m->adults = (request()->has('adults') ? request()->adults :"2");
        $m->children = (request()->has('children') ? request()->children :"0");
        $m->rooms = (request()->has('rooms') ? request()->rooms :"1");

        // format variables
        $date_range_array = explode(' ',trim($m->date_range));
        $m->check_in = strtotime($date_range_array[0]);
        $m->check_out = strtotime($date_range_array[2]);
        $m->nights = ($m->check_out - $m->check_in)/86400;
        $m->check_in = date("Y-m-d", $m->check_in );
        $m->check_out = date("Y-m-d", $m->check_out );

        if ($m->nights==1) {$m->nights_text = $m->nights." night";}
        else  {$m->nights_text = $m->nights." nights";}

        if ($m->adults==1) {$m->adults_text = $m->adults." adult";}
        else  {$m->adults_text = $m->adults." adults";}

        return $m;
    }

}

?>
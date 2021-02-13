<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class CoverImageController extends Controller
{
    public function show()
    {
            $data = (object) request()->validate([
            'hotel_id' => 'required|numeric|min:0|max:999999',
        ]);

        $image = DB::connection('mongodb_static') 
                ->table("hotels")
                ->where('code', intval($data->hotel_id))
                ->pluck('images')[0];

       return "https://photos.hotelbeds.com/giata/bigger/" . $image[0]["path"] ;
  
    }
    
}

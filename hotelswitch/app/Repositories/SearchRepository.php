<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Libraries\MyLibrary;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SearchRepository{

    public static function get_collection($m,$mode) {
    
        $client = new Client([
            'base_uri' => 'https://api.test.hotelbeds.com/hotel-api/1.0/'
        ]);
        
        $api_key='09561817f75e14b5b941446bffbb10ff';
        $secret='a0a2a7b764';
        $timestamp= time();
        $x_signature= hash('sha256', $api_key . $secret . $timestamp);
        
        $headers=[
            'Api-key'         => $api_key,
            'X-Signature'     => $x_signature,
            'Accept'          => 'application/json',
            'Accept-Encoding' => 'gzip',
            'Content-Type'    => 'application/json'
        ];
        
        switch ($mode){
            case 'geolocation':
                $body=[
                    "stay"=> [
                        "checkIn"  => $m->check_in,
                        "checkOut" => $m->check_out
                    ],
                    "occupancies"=> [
                        [
                        "rooms"   => $m->rooms,
                        "adults"  => $m->adults_per_room,
                        "children"=> $m->children_per_room
                        ]
                    ],
                    "geolocation" => [
                        "latitude"=> $m->lat,
                        "longitude"=> $m->lon,
                        "radius"=> 20,
                        "unit"=> "km"
                    ],
                    "accommodations"=> ["HOTEL"],
                    "dailyRate"=>"true",
                    "reviews"=>[
                        [
                        "type"=>"TRIPADVISOR",
                        "maxRate"=> 5,
                        "minRate"=> 1,
                        "minReviewCount"=> 100
                        ]
                    ],
                    "filter"=>[
                        "paymentType"=> "AT_WEB"
                    ]
                ];
                break;


            case 'id':
                $body=[
                    "stay"=> [
                        "checkIn"  => $m->check_in,
                        "checkOut" => $m->check_out
                    ],
                    "occupancies"=> [
                        [
                        "rooms"   => $m->rooms,
                        "adults"  => $m->adults,
                        "children"=> $m->children
                        ]
                    ],
                    "hotels" => [
                        "hotel"=> [$m->hotel_id]
                    ],                    "accommodations"=> ["HOTEL"],
                    "dailyRate"=>"true",
                    "reviews"=>[
                        [
                        "type"=>"TRIPADVISOR",
                        "maxRate"=> 5,
                        "minRate"=> 1,
                        "minReviewCount"=> 100
                        ]
                    ],
                    "filter"=>[
                        "paymentType"=> "AT_WEB"
                    ]
                ];
                break;

        }
        
        for ($i = 0; $i < $m->children_per_room; $i++){
            $body["occupancies"][0]["paxes"] [] = [ "type"=> "CH", "age"=> 12 ];
        }

        $response = $client->request('POST', 'hotels',  ['headers' => $headers,'json' => $body,]);
        
        $response_json = json_decode($response->getBody()->getContents());


        [$info, $hotels] = transform_collection($response_json, $m);


        DB::connection('hotelbeds')->table($m->collection_name)->raw( function ($collection) use ($info) {

            return $collection->insertone($info);
        }); 
        
        if(!empty($hotels)){
            DB::connection('hotelbeds')->table($m->collection_name)->raw( function ($collection) use ($hotels) {
    
                return $collection->insertMany($hotels);
            });
        }
        
        if(count($hotels) > 1){
        $process = new Process(['python', 'C:\wamp64\www\hotelhopping.com\science\client.py',$m->collection_name]);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
         // $r2 = $process->getOutput();
        }
        
    }



    public static function get_results($m){
    
        $star_rating=$m->filters["stars"];
    
        $star_rating=explode(',',$star_rating);
    
        for ($i = 0; $i < count($star_rating); $i++) {
            $star_rating [$i] =  $star_rating [$i] . "EST";
        } 


        if($m->filters["free_cancellation"] == "true"){ 
        $filter['cancellation_policy'] = 'Free Cancellation';
        }

        if($m->filters["sort"] == 'minRate'){$m->filters["sort"] = "rooms.0.rates.0.sellingRate";}

        if($m->filters["sort_order"] == 1){$sort_order = 'asc';}
        else{$sort_order = 'desc';}
    

        $inputs = DB::connection('hotelbeds')
                    ->table($m->collection_name)
                    ->whereBetween('rooms.0.rates.0.sellingRate',[$m->filters["price_range"]["minimum_price"]*$m->nights,$m->filters["price_range"]["maximum_price"]*$m->nights])
                    ->whereIn('categoryCode', $star_rating )
                    ->where('distance_center','<=', $m->filters["distance_center"])
                    ->where('score','>=', $m->filters["minimum_score"])
                    ->when($m->filters["free_cancellation"] == "true", function ($query, $role) {
        return $query->where('cancellation_policy', $role);})
                    ->orderBy($m->filters["sort"], $sort_order )
                    ->skip($m->index)
                    ->take(10)
                    ->get();


        foreach ($inputs as $input){
            $hotel[] = new Result($input,$m);
        }

        if (isset($hotel)){
            $m->next_index=$m->index+count($hotel);
        }
        else{
            $m->next_index="no more results";
            $hotel=[];
        }
        
        return array($hotel,$m);
    }

}

function transform_collection($response_json, $m){

    if($response_json->hotels->total == 0){
        $info = ["info"=> [ 
            "checkIn"  =>  $m->check_in,
            "checkOut" =>  $m->check_out,   
            "total"    =>  $response_json->hotels->total,
            "auditData"=>  $response_json->auditData]];

        return [$info, []];
    }


    $info = ["info"=> [
        "checkIn"  =>  $response_json->hotels->checkIn,
        "checkOut" =>  $response_json->hotels->checkOut,   
        "total"    =>  $response_json->hotels->total,
        "auditData"=>  $response_json->auditData]];
    
    foreach($response_json->hotels->hotels as $hotel){
    // string to float
        $hotel->minRate = (float) $hotel->minRate;
        $hotel->latitude = (float) $hotel->latitude;
        $hotel->longitude = (float) $hotel->longitude;
        // calculate distance center
        if(!isset($m->lat)){
        [$m->lat, $m->lon]= MyLibrary::geocode($hotel->destinationName);
        }
        $hotel->distance_center = MyLibrary::distance($hotel->latitude, $hotel->longitude,$m->lat,$m->lon);
        // cancellation policy
        $hotel->cancellation_policy = MyLibrary::cancellation_policy($hotel->rooms[0]->rates[0]->cancellationPolicies[0]->from);
        // score
        $hotel->score =  $hotel->reviews[0]->rate;
        // top_pick score
        if(!isset($hotel->top_picks)){
            $hotel->top_picks = 50;
            }
       
        // sellingRate
        for($i=0; $i < count($hotel->rooms); $i++){

            for($n=0; $n < count($hotel->rooms[$i]->rates); $n++) {

              // set selling rate if not defined
              if (!isset($hotel->rooms[$i]->rates[$n]->sellingRate)){   
                $hotel->rooms[$i]->rates[$n]->sellingRate = round($hotel->rooms[$i]->rates[$n]->net * 1.06,2);
                }
                $hotel->rooms[$i]->rates[$n]->sellingRate = (float) $hotel->rooms[$i]->rates[$n]->sellingRate;  
            }

        }
     
    }
    
    
    return [$info, $response_json->hotels->hotels];
}


class Result {
    var $name;
    var $search_cover_photo;
    var $stars;
    var $stars_symbol;

    var $score;
    var $quality;
    var $nr_reviews;

    var $city;
    var $district;
    var $distance_center;
    var $coords;

    var $pick_score;

    var $room_number;
    var $room_name;
    var $adults;
    var $children;
    var $bed_type;

    var $cancellation_deadline;
    var $cancellation_policy;
    var $payment_policy;

    var $price;

    var $id;
    
    // construct
    function __construct($input,$m){ 
                $this->id = $input["code"];
                $this->search_cover_photo = "http://photos.hotelbeds.com/giata/bigger/" . substr(str_pad($this->id, 6, '0', STR_PAD_LEFT), 0, -4) . "/" . str_pad($this->id, 6, '0', STR_PAD_LEFT) . "/" . str_pad($this->id, 6, '0', STR_PAD_LEFT) .  "a_hb_a_001.jpg";  //Time  0.8s

                // $this->images = DB::connection('mongodb_static') 
                // ->table("hotels")
                // ->where('code',   $this->id)
                // ->pluck('images')[0];

                // $this->search_cover_photo = "http://photos.hotelbeds.com/giata/bigger/" .$this->images[0]['path']; //Time  4.5s

                $this->name = $input["name"];
                $this->stars = (int)$input["categoryName"];
                $this->stars_symbol = MyLibrary::set_stars_symbol($this->stars);

                $this->score = $input["score"];
                $this->quality = MyLibrary::set_quality($this->score);
                $this->nr_reviews= $input["reviews"][0]["reviewCount"];

                $this->city = $input["zoneName"];
                // $this->district = $input["district"];

                $this->coords = ['lat'=>$input["latitude"],'lon'=>$input["longitude"]];
                $this->distance_center = round(MyLibrary::distance(
                    $this->coords["lat"],  $this->coords["lon"], $m->lat, $m->lon),1). " km from center";
                 
                if(isset($input["top_picks"])){ $this->pick_score =  $input["top_picks"];}

                $this->room_number = $input["rooms"][0]["rates"][0]["rooms"];
                $this->room_name = MyLibrary::titleCase($input["rooms"][0]["name"]);
                $this->adults = $input["rooms"][0]["rates"][0]["adults"];
                $this->children = $input["rooms"][0]["rates"][0]["children"];

                $this->set_bed_type();

                if (isset($input["rooms"][0]["rates"][0]["cancellationPolicies"][0]["from"])){
                $this->cancellation_deadline = $input["rooms"][0]["rates"][0]["cancellationPolicies"][0]["from"];
                $this->cancellation_policy = MyLibrary::cancellation_policy($this->cancellation_deadline);}
                
                // $this->payment_policy = 'Prepayment';

                $this->price = "€" . round($input["rooms"][0]["rates"][0]["sellingRate"]);
                    
                $this->sanitize();
    }

    function sanitize(){
        // add "Hotel" to name if didn't exist
        if (strpos($this->name, 'Hotel') == false) {
            $this->name = "Hotel " . $this->name;}

        // maximum name length
        if (strlen($this->name)>37) {$this->name = rtrim(substr($this->name,0,36))."."; };

        
    }

    function set_bed_type() { 

        if (strpos($this->room_name, 'Double or Twin') !== false) {
            $this->bed_type = "1 Double Bed or 2 Single Beds";}
        elseif(strpos($this->room_name, 'Twin') !== false){
            $this->bed_type = "2 Single Beds";
        }
        else {$this->bed_type = "1 Double Bed";}
        
    }
}
?>
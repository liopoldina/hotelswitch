<?php
class Hotel {
    var $check_in;
    var $check_out;
    var $nights;
    var $nights_text;
    var $adults;
    var $adults_text;
    var $rooms;
    var $rooms_text;

    var $name;
    var $stars;
    var $stars_symbol;

    var $city;
    var $country_code;
    var $country;
    var $address;

    var $coords;
    var $city_coords;
    var $distance_center;

    var $score;
    var $quality;
    var $nr_reviews;

    var $images;

    var $description;

    var $facilities;

    var $policies;

    var $offer;

    var $tourist_tax;

    // construct
    function __construct($static, $offer, $info)
    {           
                $this->check_in=$info["info"]["checkIn"];
                $this->check_out=$info["info"]["checkOut"];
                $this->nights= (strtotime($this->check_out) - strtotime($this->check_in))/86400;
                $this->nights_text = $this->nights . " nights";
                if ($this->nights=1){$this->nights_text = $this->nights . " night";}
                $this->adults =$offer["rooms"][0]["rates"][0]["adults"]; 
                $this->adults_text = $this->adults . " adults";
                if ($this->adults == 1){$this->adults_text = $this->adults . " adult";}
                $this->rooms = $offer["rooms"][0]["rates"][0]["rooms"];
                $this->rooms_text = $this->rooms . " rooms";
                if ($this->rooms == 1){$this->rooms_text = $this->rooms . " room";}

                $this->name = $static["name"]["content"];
                $this->stars = (int)$static["categoryCode"];
                $this->set_stars_symbol();

                $this->city=$static["city"]["content"];
                $this->country_code = $static["countryCode"];
                $this->get_country();
                $this->address=$this->titleCase($static["address"]["content"]).", ".$this->titleCase($this->city). ", " . $static["postalCode"] . ", " . $this->country;

                $this->coords = ['lat'=>$static["coordinates"]["latitude"],'lon'=>$static["coordinates"]["longitude"]];
                $this->city_coords = ['lat'=>38.71667,'lon'=>-9.13333];

                $this->distance_center = round($this->distance($this->coords["lat"],  $this->coords["lon"], $this->city_coords["lat"], $this->city_coords["lon"]),1). " km from center";

                $this->score = $offer["reviews"][0]["rate"] * 2;
                $this->set_quality();
                $this->nr_reviews= $offer["reviews"][0]["reviewCount"];

                $this->get_images($static["images"]);
            
                $this->description=$static["description"]["content"];

                $this->facilitites_aux=$static["facilities"];

                $facilities_aux=$this->get_facilities($static["facilities"]); 
                
                // instead of feeding $static["facilities"] to function get_policies, we feed $facilities_aux that is equal but already contains the description of the facility
                $this->facilitites_aux=$facilities_aux; //can delete this line later (just to check variable in browser dev)
                $this->get_policies($facilities_aux);

                $this->get_offer($offer['rooms'],$static);

                if($offer["rooms"][0]["rates"][0]["taxes"]["allIncluded"] == false){
                    $this->tourist_tax = intval($offer["rooms"][0]["rates"][0]["taxes"]["taxes"][0]["amount"])/$this->adults;
                }


                // $this->set_bed_type();
                // $this->sanitize();
    }

    function sanitize(){
        // add "Hotel" to name if didn't exist
        if (strpos($this->name, 'Hotel') == false) {
            $this->name = "Hotel " . $this->name;}

        // maximum name length
        if (strlen($this->name)>37) {$this->name = rtrim(substr($this->name,0,36))."."; };
        
    }

    function set_stars_symbol() {
        switch ($this->stars) {
            case 1:
                $this->stars_symbol="★";
                break;
            case 2:
                $this->stars_symbol="★★";
                break;
            case 3:
                $this->stars_symbol="★★★";
                break;
            case 4:
                $this->stars_symbol="★★★★";
                break;
            case 5:
                $this->stars_symbol="★★★★★";
                break;  }
            }

    function set_quality() {
        switch (true) {
            case $this->score>=9.5:
                $this->quality="Exceptional";
                break;
            case $this->score>=9:
                $this->quality="Wonderful";
                break;
            case $this->score>=8:
                $this->quality="Very Good";
                break;
            case $this->score>=7:
                $this->quality="Good";
                break;
            case $this->score<7:
                $this->quality="Plesant";
                break;;  }
            }

    function set_bed_type() { 

        if (strpos($this->room_name, 'Double or Twin') !== false) {
            $this->bed_type = "1 Double Bed or 2 Single Beds";}
        elseif(strpos($this->room_name, 'Twin') !== false){
            $this->bed_type = "2 Single Beds";
        }
        else {$this->bed_type = "1 Double Bed";}
        
    }

    function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("or", "VIII"))
    {
        /*
         * Exceptions in lower case are words you don't want converted
         * Exceptions all in upper case are any words you don't want converted to title case
         *   but should be converted to upper case, e.g.:
         *   king henry viii or king henry Viii should be King Henry VIII
         */
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $word) {
                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtoupper($word, "UTF-8");
                } elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $word = mb_strtolower($word, "UTF-8");
                } elseif (!in_array($word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
        }//foreach
        return $string;
    }

function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371)
  {
    /**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * param float $latitudeFrom Latitude of start point in [deg decimal]
 * param float $longitudeFrom Longitude of start point in [deg decimal]
 * param float $latitudeTo Latitude of target point in [deg decimal]
 * param float $longitudeTo Longitude of target point in [deg decimal]
 * param float $earthRadius Mean earth radius in [m]
 * return float Distance between points in [m] (same as earthRadius)
 */
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);
  
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
  
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
      cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
  }

  function get_country(){
    $c = new MongoDB\Client('mongodb://localhost:27017');
    $db = $c->static_content;

    $collection=$db->countries;
    
    $filter=[
        'code' => $this->country_code,
    ];
    
    $cursor=$collection->find ($filter);
    $cursor_decode = json_decode(json_encode($cursor->toArray()),true);

    $this->country=$cursor_decode[0]["description"]["content"];

  }

  function get_images($images){

    foreach ($images as $image) {
    $this->images[]= "http://photos.hotelbeds.com/giata/bigger/" . $image["path"];
    $this->images_min[]= "http://photos.hotelbeds.com/giata/small/" . $image["path"];

    }   
}

function get_facilities($facilities){
    $c = new MongoDB\Client('mongodb://localhost:27017');
    $db = $c->modified_static_content;

    $collection=$db->facilitygroups;

    $cursor=$collection->find ();
    $cursor_decode = json_decode(json_encode($cursor->toArray()),true);

    $this->facilities = array();

    foreach ($cursor_decode as $facility_group){
    $this->facilities[$facility_group["FacilityGroup"]]=array();
    }

for ($i=0; $i<count($facilities); $i++){
        $collection=$db->facilities;  

        $filter=['$and' =>[
            ['facilityGroupCode'=>$facilities[$i]["facilityGroupCode"]],
            ['code'=>$facilities[$i]["facilityCode"]]
            ]];  
        
        $options = [ 'projection' => ['_id' => 0, 'code' => 1, 'description' => 1]];

        $cursor=$collection->find ($filter,$options);
        $cursor_decode = json_decode(json_encode($cursor->toArray()),true);

        $facilities[$i]['description']=$cursor_decode[0]["description"]["content"];

        if(isset($cursor_decode[0]["description"]["FacilityGroup"])){

            if(!in_array($cursor_decode[0]["description"]["content"],$this->facilities[$cursor_decode[0]["description"]["FacilityGroup"]])){
    
                $this->facilities[$cursor_decode[0]["description"]["FacilityGroup"]][]=$cursor_decode[0]["description"]["content"];

            }
        }
    }

    return($facilities);
}

function get_policies($facilities){
    $this->policies['Check-in and check-out']=array();
    $this->policies['Cancellation/Prepayment']=array();
    $this->policies['Children and beds']=array();
    $this->policies['Meals']=array();
    $this->policies['Pets']=array();
    $this->policies['Cards accepted']=array();

    $this->policies['Cancellation/Prepayment'][]="You can find more information on the terms of cancellation or prepayment in the booking terms of the rate you've chosen.";

    // $this->policies['Children and beds'][]="Children of any age are welcome.";
    // $this->policies['Children and beds'][]="Children aged 12 years and above are considered adults at this property.";
    $this->policies['Children and beds'][]="To see correct prices and occupancy information, please add the number of children in your group and their ages to your search.";

    // $this->policies['Meals'][]="Price of an additional breakfast: 8.00 EUR per person.";
    $this->policies['Meals'][]="Information about the type of meals included in the price is indicated in the rate details.";

    for ($i=0; $i<count($facilities); $i++){

        switch ($facilities[$i]["description"]) {
            case "Check-in hour":
                $this->policies['Check-in and check-out'][]='Check-in from '. substr($facilities[$i]['timeFrom'], 0, -3);
            break;

            case "Check-out hour":
                $this->policies['Check-in and check-out'][]='Check-out time: before '. substr($facilities[$i]['timeTo'], 0, -3); 
            break;

            case "Small pets allowed (under 5 kg)":
                if($facilities[$i]['indYesOrNo'] == true){
                $this->policies['Pets'][]=$facilities[$i]["description"];
                }else{
                $this->policies['Pets'][]="Pets are not allowed.";
                }
            break;
        }

        if ($facilities[$i]["facilityGroupCode"]==30) {
            $this->policies['Cards accepted'][]=$facilities[$i]["description"];
        }
    }
}

function get_offer($rooms,$static){

    for ($i=0; $i < count($rooms); $i++){
        // get room images
        foreach($static["images"] as $image){
            if (isset($image["roomCode"]))
                if($rooms[$i]["code"] == $image["roomCode"]){
                    $rooms[$i]["images"][] = $image;
                } 
        }


        for ($n=0; $n < count($rooms[$i]["rates"]); $n++){

            // set cancellaton policy
            $rooms[$i]["rates"][$n]["cancellationPolicies"][0]["description"] = "Non-refundable rate"; //default

            if (isset($rooms[$i]["rates"][$n]["cancellationPolicies"][0]["from"])){        
                $time_to_deadline = (strtotime ($rooms[$i]["rates"][$n]["cancellationPolicies"][0]["from"]) - time())/60/60/24;
                if ($time_to_deadline>1){
                    $rooms[$i]["rates"][$n]["cancellationPolicies"][0]['description'] = "Free cancellation";}
            }

            //other
        }
    }
    $this->offer=$rooms;
}

}

?>


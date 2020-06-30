<?php

class Hotel {
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

    var $room_name;
    var $bed_type;

    var $cancellation_deadline;
    var $cancellation_policy;
    var $payment_policy;

    var $price;
    
    // construct
    function __construct($input,$coords){ 
                $this->name = $input["name"];
                $this->search_cover_photo = "./images/search/hotel_cover.jpg";
                $this->stars = (int)$input["categoryName"];
                $this->set_stars_symbol();

                $this->score = $input["reviews"][0]["rate"] * 2;
                $this->set_quality();
                $this->nr_reviews= $input["reviews"][0]["reviewCount"];

                $this->city = $input["zoneName"];
                // $this->district = $input["district"];

                $this->coords = ['lat'=>$input["latitude"],'lon'=>$input["longitude"]];
                $this->distance_center = round($this->distance(
                    $this->coords["lat"],  $this->coords["lon"], $coords["lat"], $coords["lon"]),1). " km from center";

                $this->room_name = $this->titleCase($input["rooms"][0]["name"]);
                $this->set_bed_type();

                $this->cancellation_deadline=$input["rooms"][0]["rates"][0]["cancellationPolicies"][0]["from"];
                $this->set_cancellation_policy();
                // $this->payment_policy = $input["room_payment_policy"];

                $this->price = "€" . round($input["rooms"][0]["rates"][0]["net"]);
                    
                $this->sanitize();
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

    function set_cancellation_policy() { 
        $time_to_deadline = (strtotime ($this->cancellation_deadline) - time())/60/60/24;

        if ($time_to_deadline>1){$this->cancellation_policy = "Free cancellation";}
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


}
?>
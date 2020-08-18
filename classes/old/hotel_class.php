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
    var $cancellation_policy;
    var $payment_policy;

    var $price;
    
    // construct
    function __construct($input){ 
                $this->name = $input["name"];
                $this->search_cover_photo = $input["search_cover_photo"];
                $this->stars = $input["stars"];
                $this->set_stars_symbol();

                if (isset($input["score"])) {$this->score = $input["score"];};
                if (isset($input["score"])) {$this->set_quality();};
                if (isset($input["nr_reviews"])) {$this->nr_reviews= $input["nr_reviews"];};

                $this->city = $input["city"];
                $this->district = $input["district"];
                $this->distance_center = $input["distance_center"] . " km from center";
                $this->coords = $input["coords"];

                $this->room_name = $input["room_name"];
                $this->bed_type = $input["room_bed_type"];
                $this->cancellation_policy = $input["room_cancellation_policy"];
                $this->payment_policy = $input["room_payment_policy"];

                if (isset($input["price"])) {$this->price = $input["price"];};
                    
                $this->sanitize();
    }

    function sanitize(){
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


}
?>
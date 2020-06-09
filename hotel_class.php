<?php

class Hotel {
    var $name;
    var $stars;
    var $stars_symbol;

    var $score;
    var $quality;
    var $nr_reviews;

    var $city;
    var $district;
    var $distance_center;

    var $room_name;
    var $bed_type;
    var $cancellation_policy;
    var $payment_policy;

    var $price;

    // construct from database
    function __construct($input){ 
                $this->name = $input["name"];
                $this->stars = $input["stars"];
                $this->score = $input["score"];
                $this->nr_reviews= $input["nr_reviews"];
                $this->city = $input["city"];
                $this->district = $input["district"] . ",";
                $this->distance_center = $input["distance_center"] . " km from center";
                $this->room_name = $input["room_name"];
                $this->bed_type = $input["room_bed_type"];
                $this->cancellation_policy = $input["room_cancellation_policy"];
                $this->payment_policy = $input["room_payment_policy"];
                if (isset($input["price"])) {$this->price = $input["price"];};
                $this->set_stars_symbol();
                $this->set_quality();
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
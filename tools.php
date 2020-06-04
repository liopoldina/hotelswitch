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
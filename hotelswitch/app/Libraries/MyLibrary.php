<?php

namespace App\Libraries;

Class MyLibrary {

    public static function set_stars_symbol($stars) {
        switch ($stars) {
            case 1:
                $stars_symbol="★";
                break;
            case 2:
                $stars_symbol="★★";
                break;
            case 3:
                $stars_symbol="★★★";
                break;
            case 4:
                $stars_symbol="★★★★";
                break;
            case 5:
                $stars_symbol="★★★★★";
                break;  }

        return $stars_symbol;
    }


    public static function set_quality($score) {
        switch ($score) {
            case $score>=9.5:
                $quality="Exceptional";
                break;
            case $score>=9:
                $quality="Wonderful";
                break;
            case $score>=8:
                $quality="Very Good";
                break;
            case $score>=7:
                $quality="Good";
                break;
            case $score<7:
                $quality="Plesant";
                break;;  }

        return $quality;
    }  

    public static function cancellation_policy($cancellation_deadline) { 
        $time_to_deadline = (strtotime ($cancellation_deadline) - time())/60/60/24;
    
        if ($time_to_deadline>1){$cancellation_policy = "Free Cancellation";}
        else {$cancellation_policy = "Non Refundable rate";}
    
        return $cancellation_policy;
    }
    
    

    public static function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("or", "VIII"))
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
    

    public static function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371){
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
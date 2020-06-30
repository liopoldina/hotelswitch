<?php
include "classes\hotel_class.php"; 

$m=$_GET["m"];

$next_url = $m["next_url"];

$check_in = $m["check_in"];
$check_out = $m["check_out"];
$destination_name = str_replace(' ', '%20',$m["destination_name"]);
$destination_id = $m["destination_id"];

$mode= $_GET["mode"];

switch ($mode){
    case "page":
        $url="https://uk.hotels.com/search/listings.json" .
        $next_url.
        "&cur=EUR";
        break;


    case "filter":
        $url = "https://uk.hotels.com/search/listings.json?" .
        "pn=1".
        "&cur=EUR".
        "&include-filters=true" .
        "&f-price-currency-code=EUR" .
        ((isset($m["nights"])) ? "&f-price-multiplier" . $m["nights"] : "") .
        ((isset($m["filters"]['price_range']["minimum_price"])) ? "&f-price-min=" . $m["filters"]['price_range']["minimum_price"] : "") .
        ((isset($m["filters"]['price_range']["maximum_price"])) ? "&f-price-max=" . $m["filters"]['price_range']["maximum_price"] : "") .
        ((isset($m["filters"]["stars"])) ? "&f-star-rating=" . $m["filters"]["stars"] : "") .
        ((isset($m["filters"]["minimum_score"])) ? "&f-guest-rating-min=" . $m["filters"]["minimum_score"] : "") .
        ((isset($m["filters"]["free_cancellation"])) ? "&f-pay-pref=fc" : "") .
        ((isset($m["filters"]["distance_center"])) ? "&f-distance=" . $m["filters"]["distance_center"] . "&f-lid=" . $destination_id : "") .
        "&f-accid=1" . //just hotels
        "&destination-id=" . $destination_id .
        "&q-destination=" . $destination_name .
        "&q-check-in=" . $check_in . 
        "&q-check-out=" . $check_out .
        "&q-rooms=1&q-room-0-adults=2&q-room-0-children=0";
        break;        
}

$command = escapeshellcmd("C:/wamp64/www/hotelhopping.com/scrapers/httpx_spider.py xhr $check_in $check_out $destination_name $destination_id $url");

$output = shell_exec($command);

$output_json=json_decode($output,true);

foreach ($output_json[0] as $value)
$hotel[] = new Hotel($value);

$m= new stdClass();
$m->next_url=$output_json[4];
$m->previous_url=$url;

if (isset($hotel)){
echo json_encode(array('hotels'=>$hotel,'m'=>$m,));
}
else {echo json_encode(array('m'=>$m,));}

?>
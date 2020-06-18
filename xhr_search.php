<?php
include "classes\hotel_class.php"; 

$url = $_GET["next_url"];
// $url="?q-check-out=2020-09-04&q-destination=Moscow,%20Russia&f-star-rating=5,4,3,2,1&start-index=10&q-check-in=2020-09-01&q-room-0-children=0&points=false&destination-id=1153093&q-room-0-adults=2&pg=1&q-rooms=1&resolved-location=CITY:1153093:UNKNOWN:UNKNOWN&f-accid=1&pn=2";

$parsed_url= parse_url($url);
parse_str($parsed_url['query'], $query);

$check_in = $query['q-check-in'];
$check_out = $query['q-check-out'];
$destination_name = str_replace(' ', '%20',$query['q-destination']);
$destination_id = $query['destination-id'];

$mode= $_GET["mode"];

switch ($mode){
    case "page":
        $url="https://uk.hotels.com/search/listings.json" .
        $url.
        "&cur=EUR";
        break;


    case "filter":
        $url = "https://uk.hotels.com/search/listings.json?" .
        "pn=1".
        "&cur=EUR".
        "&include-filters=true" .
        "&f-price-currency-code=EUR" .
        ((isset($_GET["nights"])) ? "&f-price-multiplier" . $_GET["nights"] : "") .
        ((isset($_GET["minimum_price"])) ? "&f-price-min=" . $_GET["minimum_price"] : "") .
        ((isset($_GET["maximum_price"])) ? "&f-price-max=" . $_GET["maximum_price"] : "") .
        ((isset($_GET["stars"])) ? "&f-star-rating=" . $_GET["stars"] : "") .
        ((isset($_GET["minimum_score"])) ? "&f-guest-rating-min=" . $_GET["minimum_score"] : "") .
        ((isset($_GET["free_cancellation"])) ? "&f-pay-pref=fc" : "") .
        ((isset($_GET["distance_center"])) ? "&f-distance=" . $_GET["distance_center"] . "&f-lid=" . $destination_id : "") .
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
$m->next_url=$output_json[2];
$m->previous_url=$url;

echo json_encode(array('hotels'=>$hotel,'auxiliar'=>$m,));
?>
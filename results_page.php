<?php
include "classes\hotel_class.php"; 
$m= new stdClass();

$url = $_GET["next_url"];
// $url="?q-check-out=2020-09-04&q-destination=Moscow,%20Russia&f-star-rating=5,4,3,2,1&start-index=10&q-check-in=2020-09-01&q-room-0-children=0&points=false&destination-id=1153093&q-room-0-adults=2&pg=1&q-rooms=1&resolved-location=CITY:1153093:UNKNOWN:UNKNOWN&f-accid=1&pn=2";

$parsed_url= parse_url($url);
parse_str($parsed_url['query'], $query);

$check_in = $query['q-check-in'];
$check_out = $query['q-check-out'];
$destination_name = urlencode($query['q-destination']);
$destination_id = $query['destination-id'];

$mode= "page";

$command = escapeshellcmd("C:/wamp64/www/hotelhopping.com/scrapers/httpx_spider.py $mode $check_in $check_out $destination_name $destination_id $url");

$output = shell_exec($command);

$output_json=json_decode($output,true);

foreach ($output_json[0] as $value)
$hotel[] = new Hotel($value);

$m->destination_header=$output_json[1];
$m->next_url=$output_json[2];

// echo "var page =" . json_encode($hotel) . "; var auxiliar=" . json_encode($m);

echo json_encode(array('hotels'=>$hotel,'auxiliar'=>$m,));
?>
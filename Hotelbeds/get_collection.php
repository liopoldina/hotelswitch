<?php
require 'vendor\autoload.php';
use GuzzleHttp\Client;

function get_collection($collection_name) {
    
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

$body=[
    "stay"=> [
        "checkIn"  => "2020-08-01",
        "checkOut" => "2020-08-03"
    ],
    "occupancies"=> [
        [
        "rooms"   => 1,
        "adults"  => 2,
        "children"=> 0
        ]
    ],
    "destination"=> [
        "code"=> "LIS"
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

$response = $client->request('POST', 'hotels',  ['headers' => $headers,'json' => $body,]);

$response_json = json_decode($response->getBody()->getContents());

#insert response into database
$c = new MongoDB\Client('mongodb://localhost:27017');
$db = $c->hotelbeds;

$db->createCollection($collection_name);
$collection=$db->{$collection_name};

$collection->insertOne(["info"=> [
 "checkIn"  =>  $response_json->hotels->checkIn,
 "checkOut" =>  $response_json->hotels->checkOut,   
 "total"    =>  $response_json->hotels->total,
 "auditData"=>  $response_json->auditData]]);

$collection->insertMany($response_json->hotels->hotels);

return $collection_name;
}
?>
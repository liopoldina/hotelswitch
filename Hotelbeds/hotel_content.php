<?php
require 'vendor\autoload.php';
use GuzzleHttp\Client;

    
$client = new Client([
    'base_uri' => 'https://api.test.hotelbeds.com/hotel-content-api/1.0/'
]);

$api_key='09561817f75e14b5b941446bffbb10ff';
$secret='a0a2a7b764';
$timestamp= time();
$x_signature= hash('sha256', $api_key . $secret . $timestamp);

$headers=[
    'Api-key'         => $api_key,
    'X-Signature'     => $x_signature,
    'Accept-Encoding' => 'gzip',
];

$step=400;

for ($i = 28701; $i <= 175000; $i += $step) {

$ii=$i+$step-1;

$params=[
    "fields"=> "all",
    "language"=> "ENG",
    "from" => $i,
    "to"=> $ii,
];

$response = $client->request('GET', 'hotels',  ['headers' => $headers,'query' => $params,]);

$response_json = json_decode($response->getBody()->getContents());

#insert response into database
$c = new MongoDB\Client('mongodb://localhost:27017');
$db = $c->static_content;

$collection=$db->{"hotels"};

$collection->insertMany($response_json->hotels);

echo($ii."\n");
}

?>
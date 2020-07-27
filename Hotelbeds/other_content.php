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

$step=1000;

for ($i = 1; $i <= 300000; $i += $step) {

$ii=$i+$step-1;

$params=[
    "fields"=> "all",
    "language"=> "ENG",
    "from" => $i,
    "to"=> $ii,
];

// countries 1 request
// destinations 5 requests
// rooms 3 requests
// boards 1 request
// accommodations 1 request
// categories 1 request
// chains 2 requests
// facilities 1 request
// facilityGroups 1 request
// issues 1 request
// languages 1 request
// promotions 1 request
// segments 1 request
// imagetypes 1 request

// The following operations are not considered mandatory, but we encourage its implementation as well:
// currencies 1 request
// terminals 2 requests
// rateComments This operation is optional because the information can be obtained with the CheckRate operation of the BookingAPI (if you do it for all rates). If you want to store them (as we recommend) then you would need 100 additional requests.


$response = $client->request('GET', 'types/groupcategories',  ['headers' => $headers,'query' => $params,]);

$response_json = json_decode($response->getBody()->getContents());

#insert response into database
$c = new MongoDB\Client('mongodb://localhost:27017');
$db = $c->static_content;

$collection=$db->{"groupcategories"};

$collection->insertMany($response_json->groupCategories);

echo($ii."\n");
}

?>
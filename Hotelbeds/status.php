<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://api.test.hotelbeds.com/hotel-api/1.0/'
]);

#headers
$api_key='09561817f75e14b5b941446bffbb10ff';
$secret='a0a2a7b764';
$timestamp= time();
$x_signature= hash('sha256', $api_key . $secret . $timestamp);

$headers=[
    'Api-key'         => $api_key,
    'X-Signature'     => $x_signature,
    'Accept'          => 'application/json',
    'Accept-Encoding' => 'gzip'
];

$response = $client->request('GET', 'status', ['headers' => $headers]);


echo($response->getBody()->getContents())


?>
<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'http://aif2.int.hotelbeds.com/aif2-pub-ws/files/'
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

#request
$response = $client->request('GET', 'full', ['headers' => $headers]);

file_put_contents("Hotelbeds/json/cache.json", $response->getBody()->getContents());



?>
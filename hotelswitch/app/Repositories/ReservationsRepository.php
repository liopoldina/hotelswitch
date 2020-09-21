<?php

namespace App\Repositories;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\DB;

use App\Libraries\MyLibrary;

class ReservationsRepository{

    public static function CheckRate($rateKey) {
    
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
            "rooms"=> [
                [
                "rateKey"  => $rateKey,
                ]
            ],
            "upselling" => 'false',
        ];

        $response = $client->request('POST', 'checkrates',  ['headers' => $headers,'json' => $body,]);
        
        return json_decode($response->getBody()->getContents());
                
    }



}


?>
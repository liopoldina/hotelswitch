<?php
require 'vendor\autoload.php';
require "classes\hotel_page_class.php"; 

function get_hotel_content($code){

$c = new MongoDB\Client('mongodb://localhost:27017');

$filter=[
    'code' => $code,
];

// get static content
$db = $c->static_content;
$collection=$db->hotels;

$cursor=$collection->find ($filter);
$static = json_decode(json_encode($cursor->toArray()),true);

// get offer
$db = $c->hotelbeds;
$collection=$db->{"38.712526349309_-9.1384437715424_2020-07-05_2020-07-06_1_2_2"};

$cursor=$collection->find ($filter);
$offer = json_decode(json_encode($cursor->toArray()),true);



$h = new Hotel($static[0],$offer[0]);

return $h;

}

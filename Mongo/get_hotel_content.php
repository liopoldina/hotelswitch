<?php
require 'vendor\autoload.php';
require "classes\hotel_page_class.php"; 

function get_hotel_content($code, $m){

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
$collection=$db->{$m->collection_name};

$cursor=$collection->find ($filter);
$offer = json_decode(json_encode($cursor->toArray()),true);

// get info
$options = [ 'projection' => ['info' => 1]];

$cursor=$collection->find ([],$options);
$info = json_decode(json_encode($cursor->toArray()),true);

$h = new Hotel($static[0],$offer[0],$info[0]);

return $h;

}

<?php
require 'vendor\autoload.php';
require "classes\hotel_page_class.php"; 

function get_hotel_content($code){

$c = new MongoDB\Client('mongodb://localhost:27017');

$db = $c->static_content;

$collection=$db->hotels;

$filter=[
    'code' => $code,
];

$cursor=$collection->find ($filter);

$input = json_decode(json_encode($cursor->toArray()),true);

$h = new Hotel($input[0]);

return $h;

}

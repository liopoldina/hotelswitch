<?php
require 'vendor\autoload.php';
require "classes\hotelbeds_classes.php"; 

function get_hotels($m, $collection_name){
$index=0;

$maximum_price= "150";
$minimum_price= "130";

$price_range=['$gte' => $minimum_price,'$lte' => $maximum_price];

$star_rating="5,4,3,2,1";

$star_rating=explode(',',$star_rating);

for ($i = 0; $i < count($star_rating); $i++) {
    $star_rating [$i] = ['categoryCode'=>  $star_rating [$i] . "EST"];
} 

$c = new MongoDB\Client('mongodb://localhost:27017');

$db = $c->hotelbeds;

$collection=$db->{$collection_name};


$filter=[
    'minRate' => $price_range,
    '$or'=>$star_rating
    
];
$options=[ 'skip' => $index,
           'limit'=> 10,
    
           'sort' => ['minRate' => 1],
          
           'projection'=>[    
           'name'=>1,
           'categoryName'=>1,
           'zoneName'=>1,
           'latitude'=>1,
           'longitude'=>1,
           'currency'=>1,
           'rooms'=> array( '$slice' => 1 ),
           'reviews'=> 1
           ]];

$cursor=$collection->find ($filter, $options);

$inputs = json_decode(json_encode($cursor->toArray()),true);



foreach ($inputs as $input){
    $hotel[] = new Hotel($input,$m->coords);
}

return $hotel;

}

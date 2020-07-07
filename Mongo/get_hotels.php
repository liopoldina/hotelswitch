<?php
require 'vendor\autoload.php';
require "classes\hotelbeds_classes.php"; 

function get_hotels($m, $collection_name){

isset($m->maximum_price) ? $maximum_price= $m->maximum_price : $maximum_price=1000;
isset($m->minimum_price) ? $minimum_price= $m->minimum_price : $minimum_price=0;

$price_range=['$gte' => (string) $minimum_price,'$lte' => (string) $maximum_price];

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
$options=[ 'skip' => $m->index,
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

if (isset($hotel)){
$m->next_index=$m->index+count($hotel);
}
else{
$m->next_index="no more results";
$hotel=[];
}

return $hotel;

}

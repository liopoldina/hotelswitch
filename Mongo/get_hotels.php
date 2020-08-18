<?php
require 'vendor/autoload.php';
require "classes/results_class.php";

function get_hotels($m){

$star_rating=$m->filters["stars"];

$star_rating=explode(',',$star_rating);

for ($i = 0; $i < count($star_rating); $i++) {
    $star_rating [$i] = ['categoryCode'=>  $star_rating [$i] . "EST"];
} 

$c = new MongoDB\Client('mongodb://localhost:27017');

$db = $c->hotelbeds;

$collection=$db->{$m->collection_name};

$filter=[
    'minRate' => ['$gte' => $m->filters["price_range"]["minimum_price"],'$lte' => $m->filters["price_range"]["maximum_price"]],
    '$or'=>$star_rating,
    'distance_center'=> ['$lte' => $m->filters["distance_center"]],
    'score' => ['$gte' => $m->filters["minimum_score"]],
];

if($m->filters["free_cancellation"] == "true"){ 
$filter['cancellation_policy']= 'Free Cancellation';
}

$options=[ 'skip' => $m->index,
           'limit'=> 10,
    
           'sort' => [$m->filters["sort"] => $m->filters["sort_order"] ],
          
           'projection'=>[
           'code'=>1,    
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

return array($hotel,$m);

}

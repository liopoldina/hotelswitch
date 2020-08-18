<?php
require 'vendor\autoload.php';

$c = new MongoDB\Client('mongodb://localhost:27017');

$db = $c->hotelbeds;

//$collection=$db->{"38.712526349309_-9.1384437715424_2020-08-17_2020-08-18_1_2_2";};

$collection=$db->{$m->collection_name};

$filter=[
    'name'=> [ '$exists'=> 'true']
];

$cursor=$collection->find($filter);

foreach ($cursor as $hotel){
$collection->updateone(
    array('_id'=> $hotel['_id']),
    array('$set' => array(
        // string to float
        'minRate'=> (float) $hotel['minRate'],
        'latitude'=> (float) $hotel['latitude'],
        'longitude'=> (float) $hotel['longitude'],
        // calculate distance center
        'distance_center'=> distance($hotel['latitude'], $hotel['longitude'],$m->coords["lat"],$m->coords["lon"]),
        // cancellation policy
        'cancellation_policy'=> cancellation_policy($hotel["rooms"][0]["rates"][0]["cancellationPolicies"][0]["from"]),
        // score
        'score'=> $hotel["reviews"][0]["rate"] * 2
        ))
    ); 
}

function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371){
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);
  
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
  
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
      cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
  }

function cancellation_policy($cancellation_deadline) { 
    $time_to_deadline = (strtotime ($cancellation_deadline) - time())/60/60/24;

    if ($time_to_deadline>1){$cancellation_policy = "Free Cancellation";}
    else {$cancellation_policy = "Non Refundable";}

    return $cancellation_policy;
}

?>
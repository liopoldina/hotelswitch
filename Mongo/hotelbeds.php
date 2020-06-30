<?php
require "Hotelbeds\get_collection.php";
require "Mongo\get_hotels.php";
require 'vendor\autoload.php';


$collection_name= $m->coords["lat"] ."_". $m->coords["lon"] ."_".$m->check_in ."_". $m->check_out ."_". $m->rooms ."_". $m->adults ."_".$m->adults;

$c = new MongoDB\Client('mongodb://localhost:27017');

// $collection_query = $c->hotelbeds->listCollections([
//     'filter' => [
//         'name' => $collection_name,
//      ], 
//   ]);

// $collection_query = $collection_query[0]->getName();


// $collectionNames = [];
// foreach ($collections as $collection) {
//   $collectionNames[] = $collection->getName();
// }


// $collection_name=get_collection($collection_name);
$collection_name="2020-06-28 13:07:26.573";

$hotel=get_hotels($m,$collection_name);

$m->destination_header=urldecode($m->destination_name) ;
?>
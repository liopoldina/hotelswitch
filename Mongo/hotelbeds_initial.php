<?php
require "Hotelbeds\get_collection.php";
require "Mongo\get_hotels.php";
require 'vendor\autoload.php';


$collection_name= $m->coords["lat"] ."_". $m->coords["lon"] ."_".$m->check_in ."_". $m->check_out ."_". $m->rooms ."_". $m->adults ."_".$m->adults;

$collection_name= "38.712526349309_-9.1384437715424_2020-07-05_2020-07-06_1_2_2";

$c = new MongoDB\Client('mongodb://localhost:27017');

$collections_query = $c->hotelbeds->listCollections([
    'filter' => [
        'name' => $collection_name,
     ], 
  ]);

  $collectionNames = [];
  foreach ($collections_query as $collection_query) {
    $collectionNames[] = $collection_query->getName();
  }

$exists = in_array($collection_name, $collectionNames);

if ($exists == false)
{$collection_name=get_collection($collection_name, $m);
}


$m->index=0;
$hotel=get_hotels($m,$collection_name);

$m->destination_header=urldecode($m->destination_name) ;
?>
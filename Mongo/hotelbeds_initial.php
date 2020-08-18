<?php
require "Hotelbeds\get_collection.php";
require "Mongo\get_hotels.php";
require 'vendor\autoload.php';

$m->collection_name = $m->coords["lat"] ."_". $m->coords["lon"] ."_".$m->check_in ."_". $m->check_out ."_". $m->rooms ."_". $m->adults ."_".$m->adults;

// $m->collection_name = "copia";

$c = new MongoDB\Client('mongodb://localhost:27017');

$collections_query = $c->hotelbeds->listCollections([
    'filter' => [
        'name' => $m->collection_name,
     ], 
  ]);

  $collectionNames = [];
  foreach ($collections_query as $collection_query) {
    $collectionNames[] = $collection_query->getName();
  }

$exists = in_array($m->collection_name, $collectionNames);

if ($exists == false)
{$m->collection_name = get_collection($m);
}

$m->index=0;

$m->filters["sort"]= 'minRate';
$m->filters["sort_order"] = 1;

$m->filters["price_range"]["maximum_price"]=999;
$m->filters["price_range"]["minimum_price"]=0;
$m->filters["stars"]="5,4,3,2,1";
$m->filters["distance_center"]=50;
$m->filters["free_cancellation"]=false;
$m->filters["minimum_score"]=0;


[$hotel,$m]=get_hotels($m);

// get_cover_images($hotel);

$m->destination_header=urldecode($m->destination_name);
?>
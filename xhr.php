<?php
require "Mongo\get_hotels.php";

$m=(object) $_GET["m"];
$mode= $_GET["mode"];

$m->next_index=(int)$m->next_index;
$m->filters["sort_order"] = (float) $m->filters["sort_order"];
$m->filters["price_range"]["maximum_price"]=(float)$m->filters["price_range"]["maximum_price"];
$m->filters["price_range"]["minimum_price"]=(float)$m->filters["price_range"]["minimum_price"];
$m->filters["distance_center"]=(float)$m->filters["distance_center"];
$m->filters["minimum_score"]=(float)$m->filters["minimum_score"];


switch ($mode){
    case "page":
        $m->index = $m->next_index;
        [$hotel,$m]=get_hotels($m);
         break;

    case "filter":
        $m->index = 0;
        [$hotel,$m]=get_hotels($m);
        break;        
}

if (isset($hotel)){
echo json_encode(array('hotels'=>$hotel,'m'=>$m,));
}
else {echo json_encode(array('m'=>$m,));}

?>
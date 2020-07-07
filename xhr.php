<?php
require "Mongo\get_hotels.php";


$m=(object) $_GET["m"];
$mode= $_GET["mode"];

$m->next_index=(int)$m->next_index;

$collection_name= "38.712526349309_-9.1384437715424_2020-07-05_2020-07-06_1_2_2";

switch ($mode){
    case "page":
        $m->index = $m->next_index;
        $hotel=get_hotels($m,$collection_name);
        break;


    case "filter":
        $hotel=get_hotels($m,$collection_name);
        break;        
}

if (isset($hotel)){
echo json_encode(array('hotels'=>$hotel,'m'=>$m,));
}
else {echo json_encode(array('m'=>$m,));}

?>
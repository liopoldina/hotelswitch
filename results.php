<?php
$m= new stdClass();

// 0) Defult Items: in case no filed is set
if (count($_GET)==0) {
    $m->destination_name = urlencode("Lisbon");
    $m->destination_id ="1063515";
    $m->destination_id ="";
    $m->coords=['lat'=> 38.7125263493089,'lon'=> -9.138443771542375];
    $date_range= date('m/d/yy') . " - " . date("m/d/yy", strtotime(date('m/d/yy') . "+1 days"));
    $m->adults = 2;
    $m->children = 0;
    $m->rooms = 1;}

// 1) Search items: receive get request fields
else  {
$m->destination_name = urlencode($_GET["destination"]);
$m->destination_id = $_GET["destination_id"];
$m->coords=['lat'=> $_GET["lat"],'lon'=> $_GET["lon"]];
$date_range=$_GET["date_range"];
$m->adults = $_GET["adults"];
$m->children = $_GET["children"];
$m->rooms = $_GET["rooms"];
};

$date_range_array = explode(' ',trim($date_range));
$m->check_in = strtotime($date_range_array[0]);
$m->check_out = strtotime($date_range_array[2]);
$m->nights = ($m->check_out - $m->check_in)/86400;

$m->check_in = date("yy-m-d", $m->check_in );
$m->check_out = date("yy-m-d", $m->check_out );

// 2) Get Data
include "./Mongo/hotelbeds_initial.php";

// 3) Dom - create dom document with template
$dom = new DOMDocument();
@$dom->loadHTMLFile("index.html"); //@ to ignore errors because of google maps url

$hotel_page = $dom-> getElementById("hotel_page");
$hotel_page->parentNode->removechild($hotel_page); // remove hotel page
$hotel_left = $dom-> getElementById("hotel_left");
$hotel_left->parentNode->removechild($hotel_left);

$hopping = $dom-> getElementById("hopping");
$hopping->parentNode->removechild($hopping); // remove hopping

$hotelbox = $dom-> getElementById("hotelbox");
$hotel_boxes_wrapper = $dom-> getElementById("hotel_boxes_wrapper");

$nr_results = count($hotel);
for ($i=0; $i < $nr_results-1 ; $i++) { 
$hotel_boxes_wrapper->appendChild($hotelbox->cloneNode(true) );
}

// 4) Xpath - get dom nodes 
$xpath = new DomXPath($dom);

$nodes= new stdClass();

$nodes->name = $xpath->query("//span[@class= 'name' ]");
$nodes->search_cover_photo = $xpath->query("//img[@class= 'search_cover_photo' ]");
$nodes->star = $xpath->query("//span[@class= 'stars' ]");
$nodes->score = $xpath->query("//span[@class= 'score' ]");
$nodes->quality = $xpath->query("//span[@class= 'quality' ]");
$nodes->nr_reviews = $xpath->query("//span[@class= 'nr_reviews' ]");
$nodes->city = $xpath->query("//span[@class= 'city' ]");
$nodes->district = $xpath->query("//span[@class= 'district' ]");
$nodes->distance_center = $xpath->query("//span[@class= 'distance_center' ]");
$nodes->room_name = $xpath->query("//span[@class= 'room_name' ]");
$nodes->bed_type = $xpath->query("//span[@class= 'bed_type' ]");
$nodes->cancellation_policy = $xpath->query("//span[@class= 'cancellation_policy' ]");
$nodes->payment_policy = $xpath->query("//span[@class= 'payment_policy' ]");
$nodes->nights = $xpath->query("//span[@class= 'nights' ]");
$nodes->adults = $xpath->query("//span[@class= 'adults' ]");
$nodes->price = $xpath->query("//span[@class= 'price' ]");

$nodes->destination_header = $xpath->query("//span[@class= 'destination_header' ]");

// 5) Populate - insert data in dom nodes
for ($i=0; $i < $nr_results ; $i++) { 
$nodes->name->item($i)->nodeValue= htmlspecialchars($hotel[$i]->name);
$nodes->search_cover_photo->item($i)->setAttribute('src',$hotel[$i]->search_cover_photo);
$nodes->star->item($i)->nodeValue= $hotel[$i]->stars_symbol;
$nodes->score->item($i)->nodeValue= $hotel[$i]->score;
$nodes->quality->item($i)->nodeValue= $hotel[$i]->quality;
$nodes->nr_reviews->item($i)->nodeValue= $hotel[$i]->nr_reviews;
$nodes->city->item($i)->nodeValue= $hotel[$i]->city;
$nodes->district->item($i)->nodeValue= $hotel[$i]->district;
$nodes->distance_center->item($i)->nodeValue= $hotel[$i]->distance_center;
$nodes->room_name->item($i)->nodeValue= $hotel[$i]->room_name;
$nodes->bed_type->item($i)->nodeValue= $hotel[$i]->bed_type;
$nodes->cancellation_policy->item($i)->nodeValue= $hotel[$i]->cancellation_policy;
$nodes->payment_policy->item($i)->nodeValue= $hotel[$i]->payment_policy;

if ($m->nights==1) {$nodes->nights->item($i)->nodeValue= $m->nights . " night";}
else  {$nodes->nights->item($i)->nodeValue= $m->nights . " nights";}

if ($m->adults==1) {$nodes->adults->item($i)->nodeValue= $m->adults . " adult";}
else  {$nodes->adults->item($i)->nodeValue= $m->adults . " adults";}

$nodes->price->item($i)->nodeValue= $hotel[$i]->price;
}

$nodes->destination_header->item(0)->nodeValue= $m->destination_header;

// 6) keep searchbox input
$dom-> getElementById("destination")->setAttribute("value",urldecode($m->destination_name) );

if (isset($m->coords)){
    $dom-> getElementById("lat")->setAttribute("value",urldecode($m->coords['lat']) );
    $dom-> getElementById("lon")->setAttribute("value",urldecode($m->coords['lon']) );

    }

$dom-> getElementById("date_range")->setAttribute("value",$date_range);

if ($m->nights==1) {$dom-> getElementById("nights")->nodeValue=$m->nights."-night stay";}
else  {$dom-> getElementById("nights")->nodeValue=$m->nights."-nights stay";}

switch ($m->adults) {
    case 1:
        $dom-> getElementById("1_adult")->setAttribute("selected","selected");
        break;
    case 2:
        $dom-> getElementById("2_adults")->setAttribute("selected","selected");
        break;
    case 3:
        $dom-> getElementById("3_adults")->setAttribute("selected","selected");
        break;
    case 4:
        $dom-> getElementById("4_adults")->setAttribute("selected","selected");
        break;
    }

switch ($m->children) {
    case 0:
        $dom-> getElementById("no_children")->setAttribute("selected","selected");
        break;
    case 1:
        $dom-> getElementById("1_child")->setAttribute("selected","selected");
        break;
    case 2:
        $dom-> getElementById("2_children")->setAttribute("selected","selected");
        break;
    }

switch ($m->rooms) {
    case 1:
        $dom-> getElementById("1_room")->setAttribute("selected","selected");
        break;
    case 2:
        $dom-> getElementById("2_rooms")->setAttribute("selected","selected");
        break;
    }
    
// 7) Pass variables to head
$script_element = $dom->createElement('script');
$script_node = $dom->createTextNode("var hotel =" . json_encode($hotel) . "; var m=" . json_encode($m));
$script_element->appendChild($script_node);
    
$head = $dom->getElementsByTagName('head');
$head->item(0)->appendChild($script_element);

// 8) Final: save dom html to temporary file and include
$php = $dom->saveHTML();
file_put_contents("temp/temp_hotel.html", $php);

include "temp/temp_hotel.html";


?>


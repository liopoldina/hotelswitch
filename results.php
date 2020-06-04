
<?php
//search items
$destination = $_GET["destination"];
$check_in = $_GET["check-in"];
$check_out = $_GET["check-out"];
$adults = $_GET["adults"];
$children = $_GET["children"];
$rooms = $_GET["rooms"];
$nights = (strtotime($check_out) - strtotime($check_in))/86400;


//create objects
include "tools.php";

$hotel = array();    
$hotel[] = new Hotel();   // add first object
$hotel[] = new Hotel();

$hotel[0]->name = "Rossio Garden Hotel";
$hotel[0]->stars = 3;
$hotel[0]->set_stars_symbol();
$hotel[0]->score = 7.9;
$hotel[0]->set_quality();
$hotel[0]->nr_reviews = "1,300";
$hotel[0]->city = "Lisbon";
$hotel[0]->district = "Santo António";
$hotel[0]->distance_center = "0.5 km";
$hotel[0]->room_name = "Double Room";
$hotel[0]->bed_type = "Double Bed";
$hotel[0]->cancellation_policy= "Free cancellation";
$hotel[0]->payment_policy= "No prepayment needed";
$hotel[0]->price = "49€";

$hotel[1]->name = "Rossio Boutique Hotel";
$hotel[1]->stars = 4;
$hotel[1]->set_stars_symbol();
$hotel[1]->score = 9.7;
$hotel[1]->set_quality();
$hotel[1]->nr_reviews = "756";
$hotel[1]->city = "Madrid";
$hotel[1]->district = "Santo António";
$hotel[1]->distance_center = "0.4 km";
$hotel[1]->room_name = "Twin Room";
$hotel[1]->bed_type = "Two Single Beds";
$hotel[1]->cancellation_policy= "Non Refundable";
$hotel[1]->payment_policy= "Prepayment needed";
$hotel[1]->price = "59€";

//create dom document with template
$dom = new DOMDocument();
$dom->loadHTMLFile("index.html");
$hotelbox = $dom-> getElementById("hotelbox");
$hotel_boxes_wrapper = $dom-> getElementById("hotel_boxes_wrapper");

$nr_results = 2;
for ($i=0; $i < $nr_results-1 ; $i++) { 
$hotel_boxes_wrapper->appendChild($hotelbox->cloneNode(true) );
}

//dynamically populate hotelboxes
$xpath = new DomXPath($dom);

$nodes_name = $xpath->query("//span[@class= 'name' ]");
$nodes_star = $xpath->query("//span[@class= 'stars' ]");
$nodes_score = $xpath->query("//span[@class= 'score' ]");
$nodes_quality = $xpath->query("//span[@class= 'quality' ]");
$nodes_nr_reviews = $xpath->query("//span[@class= 'nr_reviews' ]");
$nodes_city = $xpath->query("//span[@class= 'city' ]");
$nodes_district = $xpath->query("//span[@class= 'district' ]");
$nodes_distance_center = $xpath->query("//span[@class= 'distance_center' ]");
$nodes_room_name = $xpath->query("//span[@class= 'room_name' ]");
$nodes_bed_type = $xpath->query("//span[@class= 'bed_type' ]");
$nodes_cancellation_policy = $xpath->query("//span[@class= 'cancellation_policy' ]");
$nodes_payment_policy = $xpath->query("//span[@class= 'payment_policy' ]");
$nodes_nights = $xpath->query("//span[@class= 'nights' ]");
$nodes_adults = $xpath->query("//span[@class= 'adults' ]");
$nodes_price = $xpath->query("//span[@class= 'price' ]");


for ($i=0; $i < $nr_results ; $i++) { 
$nodes_name->item($i)->nodeValue= $hotel[$i]->name;
$nodes_star->item($i)->nodeValue= $hotel[$i]->stars_symbol;
$nodes_score->item($i)->nodeValue= $hotel[$i]->score;
$nodes_quality->item($i)->nodeValue= $hotel[$i]->quality;
$nodes_nr_reviews->item($i)->nodeValue= $hotel[$i]->nr_reviews;
$nodes_city->item($i)->nodeValue= $hotel[$i]->city;
$nodes_district->item($i)->nodeValue= $hotel[$i]->district;
$nodes_distance_center->item($i)->nodeValue= $hotel[$i]->distance_center;
$nodes_room_name->item($i)->nodeValue= $hotel[$i]->room_name;
$nodes_bed_type->item($i)->nodeValue= $hotel[$i]->bed_type;
$nodes_cancellation_policy->item($i)->nodeValue= $hotel[$i]->cancellation_policy;
$nodes_payment_policy->item($i)->nodeValue= $hotel[$i]->payment_policy;

if ($nights==1) {$nodes_nights->item($i)->nodeValue= $nights . " night";}
else  {$nodes_nights->item($i)->nodeValue= $nights . " nights";}

if ($adults==1) {$nodes_adults->item($i)->nodeValue= $adults . " adult";}
else  {$nodes_adults->item($i)->nodeValue= $adults . " adults";}

$nodes_price->item($i)->nodeValue= $hotel[$i]->price;
}

// keep searchbox input
$dom-> getElementById("check-in")->setAttribute("value",$check_in);
$dom-> getElementById("check-out")->setAttribute("value",$check_out);


switch ($adults) {
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

switch ($children) {
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


switch ($rooms) {
    case 1:
        $dom-> getElementById("1_room")->setAttribute("selected","selected");
        break;
    case 2:
        $dom-> getElementById("2_rooms")->setAttribute("selected","selected");
        break;
    }
    



// switch 
// $dom-> getElementById("1_adult")->setAttribute("value",$adults);

//selected="selected"

// keep filter checked
$nodes_filter_checkboxes = $xpath->query("//input[contains(@class, 'check_box')]");

$budget_filter=[50,100,150,"unlimited"];
$star_filter=[1,2,3,4,5,"unrated"];
$distance_filter=["1km","3km","5km"];
$policy_filter=["free_cancellation","no_creditcard","no_prepayment"];
$score_filter=[9,8,7,6,"no_rating"];

if(isset($_GET['budget'])) {
foreach ($budget_filter as $key=>$value) {
    if (in_array($value, $_GET['budget'])){
    $nodes_filter_checkboxes->item($key)->setAttribute("checked","true");
    }}}

if(isset($_GET['stars'])) {
foreach ($star_filter as $key=>$value) {
if (in_array($value, $_GET['stars'])){
$nodes_filter_checkboxes->item(4+$key)->setAttribute("checked","true");
}}}

if(isset($_GET['distance'])) {
    foreach ($distance_filter as $key=>$value) {
    if (in_array($value, $_GET['distance'])){
    $nodes_filter_checkboxes->item(10+$key)->setAttribute("checked","true");
    }}}

    
if(isset($_GET['policy'])) {
foreach ($policy_filter as $key=>$value) {
if (in_array($value, $_GET['policy'])){
$nodes_filter_checkboxes->item(13+$key)->setAttribute("checked","true");
}}}

if(isset($_GET['score'])) {
    foreach ($score_filter as $key=>$value) {
    if (in_array($value, $_GET['score'])){
    $nodes_filter_checkboxes->item(16+$key)->setAttribute("checked","true");
    }}}


//save final html to temporary file and include
$php = $dom->saveHTML();
file_put_contents("temp.html", $php);

include "temp.html";
?>


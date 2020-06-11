<?php
// 0) Defult Items: in case no filed is set
if (count($_GET)==0) {
    $destination_name = urlencode("Lisbon");
    $destination_id ="1063515";
    $destination_id ="";
    $date_range= date('m/d/yy') . " - " . date("m/d/yy", strtotime(date('m/d/yy') . "+1 days"));
    $adults = 2;
    $children = 0;
    $rooms = 1;}

// 1) Search items: receive get request fields
else  {
$destination_name = urlencode($_GET["destination"]);
$destination_id = $_GET["destination_id"];
$date_range=$_GET["date_range"];
$adults = $_GET["adults"];
$children = $_GET["children"];
$rooms = $_GET["rooms"];
};

$date_range_array = explode(' ',trim($date_range));
$check_in = strtotime($date_range_array[0]);
$check_out = strtotime($date_range_array[2]);
$nights = ($check_out - $check_in)/86400;

$check_in = date("yy-m-d", $check_in );
$check_out = date("yy-m-d", $check_out );

// 2) Get Data: - escolher data source
$data_source="scrape";
switch ($data_source){
    case "database":
        include "results_database.php";
        break;
    case "scrape":
        include "results_scraper.php";
        break;
}

// 3) Dom - create dom document with template
$dom = new DOMDocument();
$dom->loadHTMLFile("index.html");
$hotelbox = $dom-> getElementById("hotelbox");
$hotel_boxes_wrapper = $dom-> getElementById("hotel_boxes_wrapper");

$nr_results = count($hotel);
for ($i=0; $i < $nr_results-1 ; $i++) { 
$hotel_boxes_wrapper->appendChild($hotelbox->cloneNode(true) );
}

// 4) Xpath - get dom nodes 
$xpath = new DomXPath($dom);

$nodes_name = $xpath->query("//span[@class= 'name' ]");
$nodes_search_cover_photo = $xpath->query("//img[@class= 'search_cover_photo' ]");
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

$nodes_destination_header = $xpath->query("//span[@class= 'destination_header' ]");

// 5) Populate - insert data in dom nodes
for ($i=0; $i < $nr_results ; $i++) { 
$nodes_name->item($i)->nodeValue= htmlspecialchars($hotel[$i]->name);
$nodes_search_cover_photo->item($i)->setAttribute('src',$hotel[$i]->search_cover_photo);
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

$nodes_destination_header->item(0)->nodeValue= $hotel[0]->destination_header;

// 6) keep searchbox input
$dom-> getElementById("destination")->setAttribute("value",urldecode($destination_name) );

$dom-> getElementById("date_range")->setAttribute("value",$date_range);

if ($nights==1) {$dom-> getElementById("nights")->nodeValue=$nights."-night stay";}
else  {$dom-> getElementById("nights")->nodeValue=$nights."-nights stay";}

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
    
// 7) keep filter checked
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


// 8) Final: save dom html to temporary file and include
$php = $dom->saveHTML();
file_put_contents("temp/temp.html", $php);

include "temp/temp.html";
?>


<?php
require './Mongo/get_hotel_content.php';

$h= new stdClass();

$m = json_decode($_GET["m"]);
$h->id = intval($_GET["hotel_id"]);

$h=get_hotel_content($h->id, $m);

$dom = new DOMDocument();
@$dom->loadHTMLFile("index.html"); //@ to ignore errors because of google maps url

$xpath = new DomXPath($dom);

$hopping = $dom-> getElementById("hopping");
$hopping->parentNode->removechild($hopping); // remove hopping

$filter = $dom-> getElementById("filter");
$filter->parentNode->removechild($filter); // remove filter

$search_page = $dom-> getElementById("search_page");
$search_page->parentNode->removechild($search_page); // remove hotel page


// keep searchbox input
$dom-> getElementById("destination")->setAttribute("value",urldecode($m->destination_name) );

if (isset($m->coords)){
    $dom-> getElementById("lat")->setAttribute("value",urldecode($m->coords->lat) );
    $dom-> getElementById("lon")->setAttribute("value",urldecode($m->coords->lon) );

    }

$dom-> getElementById("date_range")->setAttribute("value",$m->date_range);

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
    

//Insert static content

// name
$hp_name=$xpath->query("//span[@class='hp_name']")->item(0);
$hp_name->nodeValue=htmlspecialchars($h->name);

// stars
$hp_stars=$xpath->query("//span[@class='hp_stars']")->item(0);
$hp_stars->nodeValue=$h->stars_symbol;

// address
$hp_name=$xpath->query("//span[@class='hp_address_content']")->item(0);
$hp_name->nodeValue=$h->address;

// distance center
$hp_distance_center=$xpath->query("//span[@class='hp_distance_center_content']")->item(0);
$hp_distance_center->nodeValue=$h->distance_center;

// score
$hp_score=$xpath->query("//span[@class='score']")->item(0);
$hp_score->nodeValue=$h->score;

// quality
$hp_quality=$xpath->query("//span[@class='quality']")->item(0);
$hp_quality->nodeValue=$h->quality;

// nr reviews
$hp_nr_reviews=$xpath->query("//span[@class='nr_reviews']")->item(0);
$hp_nr_reviews->nodeValue=$h->nr_reviews;

// property images
$slides_index=$xpath->query("//div[@class= 'hp_slides_index' ]")->item(0);
$min_slide=$xpath->query("//div[@class= 'hp_min_slide' ]")->item(0);

$slide_img = $xpath->query("//img[@class= 'hp_slide_img' ]")->item(0);
$slide_img->setAttribute('src',$h->images_min[0]);
$slide_img->setAttribute('main',$h->images[0]);
$slide_img->setAttribute('index',0);

$nr_results = count($h->images_min);
for ($i=1; $i < $nr_results ; $i++) { 
$slides_index->appendChild($min_slide->cloneNode(true));
$slide_img = $xpath->query("//img[@class= 'hp_slide_img' ]");
$slide_img->item($i)->setAttribute('src',$h->images_min[$i]);
$slide_img->item($i)->setAttribute('main',$h->images[$i]);
$slide_img->item($i)->setAttribute('index',$i);
}

$min_slide->setAttribute('class', 'hp_min_slide hp_min_slide_selected');

// description
$hp_description_text=$xpath->query("//div[@class='hp_descrition_text']")->item(0);
$paragraph = $dom->createElement('p');

$hp_description_text->nodeValue = "";

$description = explode('.', $h->description);
for ($i=0; $i<count($description)-1; $i++){
    $description[$i]=$description[$i].".";
}

for ($i=0; $i<count($description)/2-1; $i++){
    $paragraph->nodeValue= htmlspecialchars($description[$i*2].$description[$i*2+1]);
    $hp_description_text->appendChild($paragraph->cloneNode(true));
}


// facilities
$facilities_group=$xpath->query("//div[@class='hp_facilities_group']");
$facilities_ul=$xpath->query("//ul[@class='facilities_list']");

$keys = array_keys($h->facilities);

for ($i=0; $i < $facilities_group->length ; $i++) { 
    
    if(!empty($h->facilities[$keys[$i]])){

        $facilities_ul->item($i)->nodeValue="";
        
        foreach($h->facilities[$keys[$i]] as $li){
            $facility_li=$dom->createElement('li');
            $facility_li->nodeValue=htmlspecialchars($li);
            $facilities_ul->item($i)->appendChild($facility_li);
        }

    } else {$facilities_group->item($i)->parentNode->removeChild($facilities_group->item($i));}
}

// hotel policies
$hp_rule_content=$xpath->query("//div[@class='hp_rule_content']");
$hp_rule=$xpath->query("//div[@class='hp_rule']");

$keys = array_keys($h->policies);

for ($i=0; $i < count($h->policies); $i++) { 


     
    if(!empty($h->policies[$keys[$i]])){

        $hp_rule_content->item($i)->nodeValue="";

        if($keys[$i]=="Cards accepted"){
            $cards_aux=["Visa"=>"visa",
                        "MasterCard"=>"mastercard",
                        "American Express"=>"amex",
                        "JCB"=>"jcb",
                        "Diners Club"=>"diners-club"];
            foreach($h->policies[$keys[$i]] as $rule){
                if(isset($cards_aux[$rule])){
                    $card=$dom->createElement('i');
                    $card->setAttribute('class','fab fa-cc-' . $cards_aux[$rule] . ' fa-2x');
                    $hp_rule_content->item($hp_rule_content->length-1)->appendChild($card);
                }
            }
        }else{
            foreach($h->policies[$keys[$i]] as $rule){
                $rule_span=$dom->createElement('span');
                $rule_span->nodeValue=$rule;
                $hp_rule_content->item($i)->appendChild($rule_span);
            }
            }
    } 
    else {$hp_rule->item($i)->parentNode->removeChild($hp_rule->item($i));}
}

//Insert Offer (dynamic content)

// header offer
$hp_header_price = $xpath->query("//span[@class='hp_header_price']");
$hp_header_price->item(0)->nodeValue = '€ ' . intval($h->offer[0]["rates"][0]["net"])/$h->nights;

$hp_total_price_text = $xpath->query("//strong[@class='hp_total_price_text']");
$hp_total_price_text->item(0)->nodeValue = intval($h->offer[0]["rates"][0]["net"]) . "€";

$hp_header_nights = $xpath->query("//span[@class='hp_header_nights']");
$hp_header_nights->item(0)->nodeValue = $h->nights_text;

// search bar
$hp_header_price = $xpath->query("//span[@class='hp_box_check_in']");
$hp_header_price->item(0)->nodeValue = $h->check_in;

$hp_header_price = $xpath->query("//span[@class='hp_box_check_out']");
$hp_header_price->item(0)->nodeValue = $h->check_out;

$hp_header_price = $xpath->query("//span[@class='hp_box_guests']");
$hp_header_price->item(0)->nodeValue = $h->rooms_text . ", " . $h->adults_text;

// room boxes path
$hp_room_wrapper=$xpath->query("//div[@class='hp_room_wrapper']");
$hp_room_content=$xpath->query("//div[@class='hp_room_content']");

// create room boxes
$hp_room_wrapper->item(0)->nodeValue="";

for($r=0; $r<count($h->offer); $r++){

    // create room
    $hp_room_wrapper->item(0)->appendChild($hp_room_content->item(0)->cloneNode(True));

    // room path to make relative queries
    $hp_room_content=$xpath->query("//div[@class='hp_room_content']");

    // room image
    $hp_room_img=$xpath->query(".//img[@class='hp_room_img']", $hp_room_content->item($r));
    $hp_room_img->item(0)->setAttribute('src','http://photos.hotelbeds.com/giata/bigger/'.$h->offer[$r]["images"][0]["path"]);

    // room name
    $room_name=$xpath->query(".//span[@class='room_name']", $hp_room_content->item($r));
    $room_name->item(0)->nodeValue=$h->titleCase($h->offer[$r]["name"]);

     // adults icons
    $room_guests_icon = $xpath->query(".//div[@class='room_guests_icon']", $hp_room_content->item($r));
    $room_guests_icon->item(0)->nodeValue="";
    $guest_icon = $dom->createElement('img');
    $guest_icon->setAttribute('src', './images/search/guest_icon.png');
    for ($i=1; $i <= $h->adults; $i++){
        $room_guests_icon->item(0)->appendChild($guest_icon->cloneNode(true));
    }
 
    // adults text
    $hp_offer_guests = $xpath->query(".//span[@class='hp_offer_guests']", $hp_room_content->item($r));
    $hp_offer_guests->item(0)->nodeValue =  $h->adults_text;

     // li final price
    $hp_room_li_price = $xpath->query(".//li[@class='hp_room_li_price']", $hp_room_content->item($r));
    $hp_room_li_price->item(0)->nodeValue =  "The price shown is the final price for " . $h->nights_text; 

    // li tourist tax
    $hp_tourist_tax = $xpath->query(".//li[@class='hp_tourist_tax']", $hp_room_content->item($r));
    if (isset($h->tourist_tax)){
        $hp_tourist_tax->item(0)->nodeValue =  "At the accommodation you will have to pay the touristic tax of €" . $h->tourist_tax . " per person per night not included in the price."; 
        } else {$hp_tourist_tax->item(0)->setAttribute('style','display:none');
        }

    // room offers path (wrapper)
    $hp_room_offers=$xpath->query(".//div[@class='hp_room_offers']", $hp_room_content->item($r));
    $hp_select_rooms=$xpath->query(".//div[@class='hp_select_rooms']", $hp_room_content->item($r));

    // room offer path
    $hp_room_offer=$xpath->query(".//div[@class='hp_room_offer']", $hp_room_content->item($r));
    $hp_room_offer_select=$xpath->query(".//div[@class='hp_room_offer_select']", $hp_room_content->item($r));

    // delete offers inside wrapper
    $hp_room_offers->item(0)->nodeValue = "";
    $hp_select_rooms->item(0)->nodeValue = "";

        for ($i=0; $i<count($h->offer[$r]["rates"]); $i++){
            $hp_room_offers->item(0)->appendChild($hp_room_offer->item(0)->cloneNode(true));
            $hp_select_rooms->item(0)->appendChild($hp_room_offer_select->item(0)->cloneNode(true));
        }

    // price
    $hp_room_total_price=$xpath->query(".//span[@class='hp_room_total_price']", $hp_room_content->item($r));

    //nights
    $hp_nights_text=$xpath->query(".//span[@class='hp_nights_text']");

    // board
    $board=$xpath->query(".//div[@name='board']", $hp_room_content->item($r));
    $board_icon=$xpath->query(".//i[@name='board_icon']", $hp_room_content->item($r));
    $hp_board_name=$xpath->query(".//span[@class='hp_board_name']", $hp_room_content->item($r));

    // cancellation policy
    $policy=$xpath->query(".//div[@name='policy']", $hp_room_content->item($r));
    $hp_policy=$xpath->query(".//span[@class='hp_policy']", $hp_room_content->item($r));

    // rooms left
    $rooms_left=$xpath->query(".//div[@name='rooms_left']", $hp_room_content->item($r));
    $hp_rooms_left=$xpath->query(".//span[@class='hp_rooms_left']", $hp_room_content->item($r));

    // nr rooms select
    $hp_nr_rooms=$xpath->query(".//select[@class='hp_nr_rooms']", $hp_room_content->item($r));
    $select_option=$dom->createElement('option');

    for ($i=0; $i<count($h->offer[$r]["rates"]); $i++){

        // price
        $hp_room_total_price->item($i)->nodeValue='€ ' . intval($h->offer[$r]["rates"][$i]["net"]);
        $z=$hp_room_total_price->item($i)->nodeValue;
        
        // nights
        $hp_nights_text->item($i)->nodeValue= "for ". $h->nights_text;

        // board
        $hp_board_name->item($i)->nodeValue=$h->titleCase($h->offer[$r]["rates"][$i]["boardName"]);
        switch ($h->offer[$r]["rates"][$i]["boardName"]){
            case "BED AND BREAKFAST":
                $hp_board_name->item($i)->nodeValue='Breakfast included';
                $board->item($i)->setAttribute('class','hp_offer hp_breakfast_included');
                $board_icon->item($i)->setAttribute('class','fas fa-coffee');
            break;
        }

        // cancellation policy
        $hp_policy->item($i)->nodeValue=$h->titleCase($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"]);
        switch ($h->offer[$r]["rates"][$i]["cancellationPolicies"][0]["description"]){
            case "Free cancellation":
                $policy->item($i)->setAttribute('class','hp_offer hp_refundable');
            break;
        }

        // rooms left
        if($h->offer[$r]["rates"][$i]["allotment"] <= 5){
        $hp_rooms_left->item($i)->nodeValue="Only " . $h->offer[$r]["rates"][$i]["allotment"] . " rooms left" ;
        $rooms_left->item($i)->setAttribute('style','visibility:visible');
        } else {
        $rooms_left->item($i)->setAttribute('style','visibility:hidden');
        }

       // nr rooms select
        $hp_nr_rooms->item($i)->nodeValue="";

        for($n=1; $n <= $h->offer[$r]["rates"][$i]["allotment"]; $n++){
            $select_option->setAttribute('value', $n);
            $select_option->nodeValue = $n;
            $hp_nr_rooms->item($i)->appendChild($select_option->cloneNode(true));
        }
    }
}

// insert variables and links in head
$head = $dom->getElementsByTagName('head')->item(0);
    // insert variables
$script_variables = $dom->createElement('script');
$script_node = $dom->createTextNode("var h =" . json_encode($h) . "; var m=" . json_encode($m));
$script_variables->appendChild($script_node);
$head->appendChild($script_variables);

   // insert hotel.js
$script_js_link = $dom->createElement('script');
$script_js_link->setAttribute ('src', './js/hotel.js');
$head->appendChild($script_js_link);

$php = $dom->saveHTML();
file_put_contents("temp/temp_hotel.html", $php);

include "temp/temp_hotel.html";


?>

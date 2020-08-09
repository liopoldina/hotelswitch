<?php
$h= new stdClass();

include "./Mongo/hotel_page.php";

$dom = new DOMDocument();
@$dom->loadHTMLFile("index.html"); //@ to ignore errors because of google maps url

$xpath = new DomXPath($dom);

$hopping = $dom-> getElementById("hopping");
$hopping->parentNode->removechild($hopping); // remove hopping

$filter = $dom-> getElementById("filter");
$filter->parentNode->removechild($filter); // remove filter

$search_page = $dom-> getElementById("search_page");
$search_page->parentNode->removechild($search_page); // remove hotel page


//Insert static content

// name
$hp_name=$xpath->query("//span[@class='hp_name']")->item(0);
$hp_name->nodeValue=$h->name;

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

while ($hp_description_text->hasChildNodes()) {
    $hp_description_text -> removeChild($hp_description_text->firstChild);
  }

$description = explode('.', $h->description);
for ($i=0; $i<count($description)-1; $i++){
    $description[$i]=$description[$i].".";
}

for ($i=0; $i<count($description)/2-1; $i++){
    $paragraph->nodeValue= $description[$i*2].$description[$i*2+1];
    $hp_description_text->appendChild($paragraph->cloneNode(true));
}


// facilities
$facilities_group=$xpath->query("//div[@class='hp_facilities_group']");
$facilities_ul=$xpath->query("//ul[@class='facilities_list']");

$keys = array_keys($h->facilities);

for ($i=0; $i < $facilities_group->length ; $i++) { 
    
    if(!empty($h->facilities[$keys[$i]])){

        while ($facilities_ul->item($i)->hasChildNodes()) {
            $facilities_ul->item($i) -> removeChild( $facilities_ul->item($i)->firstChild);
          }


        foreach($h->facilities[$keys[$i]] as $li){
            $facility_li=$dom->createElement('li');
            $facility_li->nodeValue=$li;
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

        while ($hp_rule_content->item($i)->hasChildNodes()) {
            $hp_rule_content->item($i) -> removeChild( $hp_rule_content->item($i)->firstChild);
          }

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



// insert variables and links in head
$head = $dom->getElementsByTagName('head')->item(0);
    // insert variables
$script_variables = $dom->createElement('script');
$script_node = $dom->createTextNode("var h =" . json_encode($h) . "; var m=" . json_encode($h));
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

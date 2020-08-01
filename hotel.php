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


// name
$hp_name=$xpath->query("//span[@class='hp_name']")->item(0);
$hp_name->nodeValue=$h->name;

//adress
$hp_name=$xpath->query("//span[@class='hp_address_content']")->item(0);
$hp_name->nodeValue=$h->address;

// insert slide indexes
$h->images[0] =
"https://r-cf.bstatic.com/images/hotel/max1024x768/228/228385161.jpg";
$h->images[1] =
"https://q-cf.bstatic.com/images/hotel/max1280x900/228/228385038.jpg";
$h->images[2] =
"https://q-cf.bstatic.com/images/hotel/max1280x900/337/33716742.jpg";

$slides_index=$xpath->query("//div[@class= 'hp_slides_index' ]")->item(0);
$min_slide=$xpath->query("//div[@class= 'hp_min_slide' ]")->item(0);

$slide_img = $xpath->query("//img[@class= 'hp_slide_img' ]")->item(0);
$slide_img->setAttribute('src',$h->images[0]);
$slide_img->setAttribute('index',0);


$nr_results = count($h->images);
for ($i=1; $i < $nr_results ; $i++) { 
$slides_index->appendChild($min_slide->cloneNode(true));
$slide_img = $xpath->query("//img[@class= 'hp_slide_img' ]");
$slide_img->item($i)->setAttribute('src',$h->images[$i]);
$slide_img->item($i)->setAttribute('index',$i);

}

$min_slide->setAttribute('class', 'hp_min_slide hp_min_slide_selected');


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

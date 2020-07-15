<?php
$dom = new DOMDocument();
@$dom->loadHTMLFile("index.html"); //@ to ignore errors because of google maps url

$hopping = $dom-> getElementById("hopping");
$hopping->parentNode->removechild($hopping); // remove hopping

$filter = $dom-> getElementById("filter");
$filter->parentNode->removechild($filter); // remove filter

$search_page = $dom-> getElementById("search_page");
$search_page->parentNode->removechild($search_page); // remove hotel page

// insert variables and links in head
$head = $dom->getElementsByTagName('head')->item(0);
    // insert variables
// $script_variables = $dom->createElement('script');
// $script_node = $dom->createTextNode("var hotel =" . json_encode($hotel) . "; var m=" . json_encode($m));
// $script_variables->appendChild($script_node);
// $head->appendChild($script_variables);

   // insert hotel.js
$script_js_link = $dom->createElement('script');
$script_js_link->setAttribute ('src', './js/hotel.js');
$head->appendChild($script_js_link);


$php = $dom->saveHTML();
file_put_contents("temp/temp_hotel.html", $php);

include "temp/temp_hotel.html";


?>

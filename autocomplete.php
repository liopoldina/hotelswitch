<?php

$query= rawurlencode($_GET['name']);

$url="https://lookup.hotels.com/egta/suggest/champion/json?locale=en_GB&boostConfig=config-boost-champion&excludeLpa=false&groupedResults=true&maxResults=15&providerInfoTypes=LOCAL%2CMULTISOURCE%2CGDS%2CTPI&callback=srs&query=" . $query;

$json=file_get_contents($url);

$json=substr($json, 4,-1);

$json = json_decode ($json);

for ($i = 0; $i <= count($json->suggestions[0]->entities)-1; $i++) {
    $response[]=new stdClass();
    $response[$i]->label = strip_tags($json->suggestions[0]->entities[$i]->caption);
    $response[$i]->value = $json->suggestions[0]->entities[$i]->destinationId;
    $response[$i]->coords = ['lat'=>$json->suggestions[0]->entities[$i]->latitude,'lon'=>$json->suggestions[0]->entities[$i]->longitude];
  }

$response = json_encode ($response);

echo $response
?>
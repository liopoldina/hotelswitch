<?php

# choose scraper:
$m->scraper="httpx";
$m->mode="initial";

switch ($m->scraper){
    case "soup":
        include "classes\old\hotel_class_old.php"; 
        $command = escapeshellcmd("C:/wamp64/www/hotelhopping.com/scrapers/soup_spider.py $m->mode $m->check_in $m->check_out $m->destination_name $m->destination_id");
        break;
    case "httpx":
        include "classes\hotel_class.php"; ; #new hotel class is not supported by scrapy and soup
        $command = escapeshellcmd("C:/wamp64/www/hotelhopping.com/scrapers/httpx_spider.py $m->mode $m->check_in $m->check_out $m->destination_name $m->destination_id");
        break;        
}

$output = shell_exec($command);

$output_json=json_decode($output,true);

foreach ($output_json[0] as $value)
$hotel[] = new Hotel($value);

$m->destination_header=$output_json[1];
$m->next_url=$output_json[2];
?>

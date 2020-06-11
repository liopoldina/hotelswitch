<?php
include "hotel_class.php";

$scraper="soup";

switch ($scraper){
    case "scrapy":
        $command = escapeshellcmd('C:/wamp64/www/hotelhopping.com/scrapers/scrapy_spider.py');
        break;
    case "soup":
        $command = escapeshellcmd("C:/wamp64/www/hotelhopping.com/scrapers/soup_spider.py $check_in $check_out $destination_name $destination_id");
        break;
}

$output = shell_exec($command);

$json_data = file_get_contents('temp/hotels.json');

$hotels_json=json_decode($json_data,true);

foreach ($hotels_json as $value)
$hotel[] = new Hotel($value);
?>

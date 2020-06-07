<?php
include "tools.php";

$command = escapeshellcmd('C:/wamp64/www/hotelhopping.com/spyder.py');
$output = shell_exec($command);

$json_data = file_get_contents('hotels.json');

$hotels_json=json_decode($json_data,true);

foreach ($hotels_json as $value)
$hotel[] = new Hotel($value,"database");
?>

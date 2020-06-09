<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "";
$database="hoteldata";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Recreate Table Lisbon
$conn->query("DROP TABLE IF EXISTS `hoteldata`.`Lisbon`");

$sql= "CREATE TABLE `hoteldata`.`Lisbon` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `stars` INT NULL,
  `score` DECIMAL(2,1) NULL,
  `nr_reviews` INT NULL,
  `city` VARCHAR(45) NULL,
  `district` VARCHAR(45) NULL,
  `distance_center` VARCHAR(45) NULL,
  `room_id` INT NULL,
  `room_name` VARCHAR(45) NULL,
  `room_bed_type` VARCHAR(45) NULL,
  `room_cancellation_policy` VARCHAR(45) NULL,
  `room_payment_policy` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));
";

if ($conn->query($sql) === TRUE) {
  echo "Table Lisbon re-created sucefully\n";}
else { echo "Error creating table: " . $conn->error;};

// Sql to populate table Lisbon
$sql = "INSERT INTO lisbon (`id`, `name`, `stars`, `score`, `nr_reviews`, `city`, `district`, `distance_center`,`room_id`,`room_name`,`room_bed_type`,`room_cancellation_policy`, `room_payment_policy`) 
VALUES ('0', 'Rossio Garden Hotel', '3', '7.9', '1300', 'Lisbon', 'Santo António', '0.5', '0', 'Double Room', '1 Double Bed', 'Free cancellation', 'No prepayment needed');";
$sql .= "INSERT INTO lisbon (`id`, `name`, `stars`, `score`, `nr_reviews`, `city`, `district`, `distance_center`,`room_id`,`room_name`,`room_bed_type`,`room_cancellation_policy`, `room_payment_policy`) 
VALUES ('1', 'Rossio Boutique Hotel', '4', '9.7', '756', 'Lisbon', 'Misericórdia', '0.4', '1', 'Twin Room', '2 Single Beds', 'Non Refundable', 'Prepayment needed');";

if ($conn->multi_query($sql) === TRUE) {
  echo "Lisbon successfully populated\n";}
else { echo "Error populating table: " . $conn->error;};

$conn->close();
?>

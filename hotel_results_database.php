<?php
include "tools.php";

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

// get search results and pass to multidimensional array
$result = $conn->query("SELECT * FROM lisbon WHERE id in (0,1)");
$search_results = array();
while($search_result = $result->fetch_assoc()){
$search_results[] = $search_result;
}

// create hotel objects from multidimensional array
$hotel[] = new Hotel($search_results[0],"database");
$hotel[] = new Hotel($search_results[1],"database");

$hotel[0]->price = "49€";
$hotel[1]->price = "59€";

// $conn->close();
?>

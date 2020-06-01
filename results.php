<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$destination= $_GET["destination"];
$checkin= $_GET["check-in"];
?>


<h3>Destination:
<?php
echo ($destination);
?>  
</h3>

<h3>Check-in:
<?php 
echo ($checkin);
?> 
</h3>


</body>
</html>


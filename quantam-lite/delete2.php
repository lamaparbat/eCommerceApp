<?php
$con = mysqli_connect("localhost","root","","aroma");
$pid = $_POST["pid"];
$query = "UPDATE store SET discount = '0' WHERE pid = '$pid'";
mysqli_query($con, $query) or die(mysqli_error($on));
?>
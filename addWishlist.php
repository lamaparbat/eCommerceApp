<?php
include 'connection.php';
$pid = $_POST["id"];
$query = "INSERT INTO wishlist(pid) VALUES('$pid')";
mysqli_query($con,$query) or die(mysqli_error($con));
?>
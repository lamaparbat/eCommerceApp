<?php
include 'connection.php';
$id = $_POST["id"];
$query = "UPDATE orders SET order_status='cancelled' WHERE id = '$id'";
mysqli_query($con, $query) or die(mysqli_error($con));
?>
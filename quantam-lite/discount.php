<?php
$con = mysqli_connect("localhost","root","","aroma");
$pid = $pdiscount = 0;
$pid = $_POST["pid"];
$pdiscount = $_POST["discount"];

// update store by discount
$update_query = "UPDATE store SET discount = '$pdiscount' WHERE pid = '$pid'";
mysqli_query($con,$update_query) or die(mysqli_error($con));
?>
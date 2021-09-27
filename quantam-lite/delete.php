<?php
$con = mysqli_connect("localhost","root","","aroma");
$pid = $_POST["pid"];
$query = "DELETE FROM store WHERE pid = '$pid'";
mysqli_query($con, $query) or die(mysqli_error($on));
?>
<?php
include 'connection.php';
$pid = $_POST["id"];
$query = "DELETE FROM wishlist WHERE pid = '$pid'";
$result = mysqli_query($con,$query) or die(mysqli_error($con));
if($result){
	header("Location:wishlist.php");
}else{
	echo "Failed to removed from the wishlist!!";
}
?>
<?php 
include 'selected_product.php';
//insert the comment_likes into comment_like database
$comment_id = $_POST["comment_id"];
echo $comment_id;

// insert the likes into comment_like dbase and count the total likes on the select product
$query = "SELECT * FROM comment_like";
$result = mysqli_query($con,$query) or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
   if($row["email"] == $comment_email && $row["comment_id"] == $comment_id){
	    $found = "true";
	    break;
   }else{
	    $found = "false";
   }
}
if($found != "true"){
$insert_query = "INSERT INTO comment_like(comment_id,cid,email) VALUES('$comment_id','$customer_id','$comment_email')";
mysqli_query($con,$insert_query) or die(mysqli_error($con));
}

//update the likes on specific comment
$count = 0;
$query = "SELECT * FROM comment_like WHERE comment_id = '$comment_id'";
$result = mysqli_query($con,$query) or die(mysqli_error($con));
while($row = mysqli_fetch_assoc($result)){
	$count++;
}
// update the likes in comment database
$update_query = "UPDATE comment SET likes='$count' WHERE id='$comment_id'";
mysqli_query($con,$update_query) or die(mysqli_error($con));

?>
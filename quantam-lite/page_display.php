<?php 
$con = mysqli_connect("localhost","root","","aroma");

//get the page from store and home page
if(isset($_POST["id"])){
	$id = $_POST["id"];
	$query = "SELECT * FROM page WHERE id = '$id'";
	$fire = mysqli_query($con,$query) or die(mysqli_error($con));
	while($row = mysqli_fetch_assoc($fire)){
		$name = $row["name"];
		$description = $row["description"];
		$date = $row["date"];
		// <img src="/public_html/quantam-lite/upload/'.$img.'" class="card-img">
		$data = 
		'<div class="card">
		  
		  <div class="card-body">
		    <h6 class="card-title">'.$name.'</h6>
		    <p class="card-text">'.$description.'</p>
		    <p>'.$date.'</p>
		  </div>
		</div>';

		echo $data;
	}
}
?>
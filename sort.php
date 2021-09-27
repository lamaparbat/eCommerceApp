<?php
include 'connection.php';
$count = 0;
//get the search key from store and home page
if(isset($_POST["type"])){
	$type = $_POST["type"];
 if($type == "auto"){
   $query = "SELECT * FROM store ORDER BY id DESC";
 } else if ($type == "desc") {
  $query = "SELECT * FROM store ORDER BY pprice DESC";
 } else if ($type == "asc") {
  $query = "SELECT * FROM store ORDER BY pprice ASC";
 }else{
  $query = "SELECT * FROM trend ORDER BY id ASC";
}
	$fire = mysqli_query($con,$query) or die(mysqli_error($con));
	while($row = mysqli_fetch_assoc($fire)){
		$pid = $row["pid"];
		$img = $row["img"];
		$name = $row["pname"];
		$price = $row["pprice"];
		$count += 1;
		//extract the images into array
  $img_arr = explode("+",$row["img"]);
		$data = 
		'<div class="card">
		  <img src="./quantam-lite/upload/'.$img_arr[0].'" class="card-img">
		  <div class="card-body pt-2 pb-3">
		    <h6 class="card-title mb-1" style="letter-spacing:2px;">'.$name.'</h6>
		    <p class="card-text mb-2 text-danger" style="letter-spacing:2px;">$USD '.$price.'</p>
		    <form method="post">
		      <input type="hidden" name="pid" id="pid" value="">
		      <input type="submit" name="save" id="submit" style="visibility:hidden;position:absolute;">
		      <a href="#" class="btn btn-info rounded-0 pl-3 pr-3 pt-1 pb-1" onclick="sendSelectedProductId('.$pid.')">Quick Buy</a>
		    </form>
		    <input type="hidden" name="count" id="count" value="<?php echo $count; ?>">
		  </div>
		</div>';
		echo $data;
	}
}

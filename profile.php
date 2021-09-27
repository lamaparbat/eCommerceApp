<?php
include 'connection.php';
$cart_no = 0;
//check whether customer already login or not
session_start();
$username = $user_name =  "";
if (strlen(isset($_SESSION['email'])) != 0 && strlen(isset($_SESSION['password'])) != 0) {
  $uemail = $_SESSION["email"];
  $select_query0 = "SELECT * FROM customer WHERE email = '$uemail'";
  $fire1 = mysqli_query($con, $select_query0) or die(mysqli_error($con));
  while ($row = mysqli_fetch_assoc($fire1)) {
    $username = $row["uname"];
    $status = $row["status"];
    $created = $row["created"];
    $cid = $row["id"];
    $img = $row["img"];
    $user_phone = $row["phone_no"];
    $user_location = $row["location_value"];
  }
  $user_name = substr($username, 0, strpos($username, " "));
  if (strlen($user_name) == 0) {
    $user_name = $username;
  }
} else {
  header("Location: login.php");
}

$email = $phone = $location = "";
$select_query = "SELECT * FROM admin";
$fire = mysqli_query($con, $select_query) or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($fire)) {
  $email = $row["email"];
  $phone = $row["phone"];
  $location = $row["location"];
}

//get the customer overal transaction
$order_no = $cancelled = $processing = $paid = 0;
$select_query = "SELECT * FROM orders WHERE cid = '$cid'";
$fire = mysqli_query($con, $select_query) or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($fire)) {
  $order_no++;
  if ($row["order_status"] == "paid") {
    $paid++;
  }
  if ($row["order_status"] == "cancelled") {
    $cancelled++;
  }
  if ($row["order_status"] == "processing") {
    $processing++;
  }
}

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);

// get the total add cart count number
if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
}

// same as above but from search.php
if (isset($_POST["save"])) {
  $pid = $_POST["pid"];
  $_SESSION["pid"] = $pid;
  echo "<script>location.assign('selected_product.php')</script>";
}

// upload profile pictures
if (isset($_POST["profile_btn"])) {
  $src = $_FILES["file"]["name"];
  $temp = $_FILES["file"]["tmp_name"];
  //upload the file in local folder -> upload/
  move_uploaded_file($temp, "/Applications/XAMPP/xamppfiles/htdocs/aroma/quantam-lite/upload/" . $src);
  $update = "UPDATE customer SET img='$src' WHERE email = '$uemail'";
  $result = mysqli_query($con, $update) or die(mysqli_error($con));
  if ($result) {
    echo "<script>location.assign('profile.php')</script>";
  }
}

// update variable
$result = $color = "";
//update username
if (isset($_POST["username_btn"])) {
  $username = $_POST["username"];
  $update = "UPDATE customer SET uname='$username' WHERE email = '$email'";
  $result = mysqli_query($con, $update) or die(mysqli_error($con));
  if ($result) {
    $color = "text-success";
    $result = "Successfully Updated!";
  } else {
    $color = "text-danger";
    $result = "Failed to Update!";
  }
}

//update password
if (isset($_POST["password_btn"])) {
  $old_password = $_POST["old_password"];
  $new_password = $_POST["new_password"];

  //get the old password from dbase
  $query = "SELECT * FROM customer WHERE email='$email'";
  $fire = mysqli_query($con, $query) or die(mysqli_error($con));
  while ($row = mysqli_fetch_assoc($fire)) {
    $old_password_val =  $row["password"];
  }

  if ($old_password == $old_password_val) {
    $color = "text-success";
    $result = "Successfully Updated!";
    $update = "UPDATE customer SET password='$new_password' WHERE email = '$email'";
    mysqli_query($con, $update) or die(mysqli_error($con));
    if ($result) {
      $color = "text-success";
      $result = "Password changed Successfully!";
    }
  } else {
    $color = "text-danger";
    $result = "Old Password doesnt matched!";
  }
}

//update contact information
if (isset($_POST["contact_btn"])) {
  $uemail = $_POST["email"];
  $phone = $_POST["phone"];
  $location = $_POST["location"];

  $update = "UPDATE customer SET email='$uemail', phone_no='$phone',location_value='$location' WHERE email = '$email'";
  $result = mysqli_query($con, $update) or die(mysqli_error($con));
  if ($result) {
    $color = "text-success";
    $result = "Successfully Updated!";
    $_SESSION["email"] = $email;
  } else {
    $color = "text-danger";
    $result = "Failed to update!";
  }
}

//post status
if (isset($_POST["create_btn"])) {
  $title = $_POST["title"];
  $status = $_POST["status"];
  $src = $_FILES["file"]["name"];
  $temp = $_FILES["file"]["tmp_name"];

  //upload in local folder
  move_uploaded_file($tmp_name, "aroma/quantam-lite/upload/" . $src);

  //get current date
  $date = date("d/M/Y");


  $query = "INSERT INTO customer_status(img, title, status,date) VALUES('$src','$title','$status','$date')";
  mysqli_query($con, $query) or die(mysqli_error($con));
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Fashioner/Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!-- font awesome -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://use.fontawesome.com/b491cd4834.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="responsive.css">
  <style>
    /*loader*/
    #loader {
      top: 50px;
      height: 100vh;
      width: 100%;
      background-image: url('img/Spin-1s-200px.gif');
      background-repeat: no-repeat;
      background-position: center;
      position: fixed;
      background-color: white;
      z-index: 99999;
    }

    /*bottomNav*/
    #bottomNav {
      box-shadow: -webkit-box-shadow: -1px -2px 5px 0px rgba(125, 125, 125, 0.73);
      background-color: white;
      box-shadow: -1px -2px 5px 0px rgba(125, 125, 125, 0.73);
    }

    #bottomNav div i {
      font-size: 25px;
    }

    #bottomNav div span {
      margin-left: 0px;
      position: relative;
    }

    .container .row .col-md-12 #myorder .col-md-3 {
      margin-top: 20px;
    }

    @media(max-width: 990px) {
      .navbar .navbar-collapse form #username {
        margin-top: 15px;
      }
    }
  </style>
</head>

<body onload="loader()">
  <!-- navbar -->
  <?php include 'navbar.php'; ?>
  <!-- search bars -->
  <div class="container-fluid bg-light mt-4 pt-4 pb-3 position-fixed searchNav" style="z-index: 2;">
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <input class="form-control mr-sm-2 mt-1 rounded-0 border-dark" type="search" placeholder="Search your favourite product" aria-label="Search" id="nav-search">
      </div>
      <div class="col-sm-4"></div>
    </div>
  </div>

  <!-- searching result -->
  <div class="container pt-5" id="search_result">
    <h5></h5>
    <div class="row p-5">
      <div class="card-columns"></div>
    </div>
  </div>

  <!-- loader -->
  <div id="loader"></div>

  <!-- searching result -->
  <div class="container" id="search_result">
    <h5>Searching Result: </h5>
    <div class="row p-5">
      <div class="card-columns"></div>
    </div>
  </div>

  <div class="container" id="navigation">
    <!-- start row1 -->
    <div class="row">
      <div class="col-md-12">
        <div class="row" style="background-image: url('img/bg3.jpg'); background-size: cover;">
          <div class="col-md-12"><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <center>
              <div class="img-circle" style="height: 130px;width: 130px;background-size: cover; background-image:url('/aroma/quantam-lite/upload/<?php echo $img; ?>'); border:5px solid white; margin-top: 0px;">
                <div style=" height: 30px;width: 30px;margin-top: 90px; margin-left: 90px; background-color:#BBBABA; border-radius: 50%;"><i class="fa fa-camera text-dark mt-2" arial-hidden="true"></i>
                  <div></div>
            </center>
          </div>
        </div><br>
        <center>
          <h4><b><?php echo $username; ?></b></h4>
        </center>
        <div class="container pl-5 pr-5 text-dark">
          <center>
            <p style="max-width: 500px;"><?php echo $status; ?></p>
          </center>
        </div>
        <hr>
        <!-- navigation bar -->
        <div class="row" id="myorder">
          <div class="col-md-3">
            <a class="btn btn-secondary pl-5 pr-5 text-white" href="#!" onclick="profile_change()"><i class="fa fa-camera" arial-hidden="true"></i>&nbsp Change Profile Pictures<span class="sr-only">(current)</span></a>
          </div>
          <div class="col-md-3">
            <a class="btn btn-secondary pl-5 pr-5 text-white" href="#!" onclick="username_change()"><i class="fa fa-user" arial-hidden="true"></i>&nbsp Change User Name <span class="sr-only">(current)</span></a>
          </div>
          <div class="col-md-3">
            <a class="btn btn-secondary pl-5 pr-5 text-white" href="#!" onclick="password_change()"><i class="fa fa-key" arial-hidden="true"></i>&nbsp Change Password<span class="sr-only">(current)</span></a>
          </div>
          <div class="col-md-3">
            <a class="btn btn-secondary pl-4 pr-5 text-white" href="#!" onclick="contact_change()"><i class="fa fa-map-marker" arial-hidden="true"></i>&nbsp Change Contact Information <span class="sr-only">(current)</span></a>
          </div>
        </div>
        <hr>
        <!-- /end of navigation -->
        <!-- update form model -->
        <span class="<?php echo $color; ?>"><?php echo $result; ?></span>
        <div class="col-md-5" id="profile_change" style="padding: 20px; background-color: whitesmoke;">
          <h4>Update Profile Pictures</h4>
          <hr>
          <form class="form p-3" method="post" enctype="multipart/form-data">
            <label>Image File</label>
            <input class="form-control" type="file" name="file"><br>
            <input class="btn btn-primary" type="submit" name="profile_btn" value="Upload">
          </form>
        </div>
        <div class="col-md-4" id="username_change" style="padding: 20px; background-color: whitesmoke;">
          <h4>Update Username</h4>
          <hr>
          <form class="form p-3" method="post">
            <label>User Name</label>
            <input class="form-control" type="text" name="username" placeholder="Enter new User Name "><br>
            <input class="btn btn-primary" type="submit" name="username_btn" value="Update">
          </form>
        </div>
        <div class="col-md-4" id="password_change" style="padding: 20px; background-color: whitesmoke;">
          <h4>Update Password</h4>
          <hr>
          <form class="form p-3" method="post">
            <label>Old Password</label>
            <input class="form-control" type="password" name="old_password" placeholder="Enter old Password"><br>
            <label>New Password</label>
            <input class="form-control" type="password" name="new_password" placeholder="Enter new Password"><br>
            <input class="btn btn-primary" type="submit" name="password_btn" value="Update">
          </form>
        </div>
        <div class="col-md-4" id="contact_change" style="padding: 20px; background-color: whitesmoke;">
          <h4>Update Contact Information</h4>
          <hr>
          <form class="form p-3" method="post">
            <label>Email</label>
            <input class="form-control" type="text" name="email" placeholder="Enter new Email ID " value="<?php echo $email; ?>"><br>
            <label>Phone</label>
            <input class="form-control" type="text" name="phone" placeholder="Enter new Phone Number " value="<?php echo $user_phone; ?>"><br>
            <label>Location</label>
            <input class="form-control" type="text" name="location" placeholder="Enter new User Location " value="<?php echo $user_location; ?>"><br>
            <input class="btn btn-primary" type="submit" name="contact_btn" value="Update">
          </form>
        </div>
        <!-- /end of update model -->
      </div>
    </div><br>
    <!-- /end of update row1 -->
    <!-- start row2 -->
    <div class="row pb-5" id="customer_data">
      <!-- Displaying Customer Information -->
      <!-- biodata -->
      <div class="col-md-3">
        <h5><b>About My Transaction</b></h5>
        <hr>
        <h6><b>Total Bought:</b> <?php echo $paid; ?></h6>
        <h6><b>Total Ordered:</b> <?php echo $order_no; ?></h6>
        <h6><b>Total Cancelled:</b> <?php echo $cancelled; ?></h6>
        <h6><b>Total Processing:</b> <?php echo $processing; ?></h6>
        <h6><b>Joined Aroma:</b> <?php echo $created; ?></h6>
      </div>
      <!-- Purchasing transaction -->
      <div class="col-md-9">
        <h5 class="pb-2 mt-4"><b>Transaction History</b></h5>
        <!-- order data displaying in table -->
        <div class="table-responsive" style="overflow-y: scroll;">
          <table class="table bg-white">
            <!-- table heading -->
            <thead>
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">Date</th>
                <th scope="col">Remove</th>
              </tr>
            </thead>
            <!-- table body  -->
            <tbody>
              <?php
              $select = "SELECT * FROM orders WHERE cid='$cid'";
              $fire = mysqli_query($con, $select) or die(mysqli_error($con));
              while ($row = mysqli_fetch_assoc($fire)) {
                //set the order mode color (paid/processing/cancelled)
                if ($row["order_status"] == "paid") {
                  $color = "text-success";
                } else if ($row["order_status"] == "processing") {
                  $color = "text-info";
                } else {
                  $color = "text-danger";
                }
              ?>
                <tr class="col bg-light">
                  <td><?php echo $row["pname"]; ?></td>
                  <td>&nbsp&nbsp&nbsp <?php echo $row["quantity"]; ?></td>
                  <td>$USD <?php echo $row["total"]; ?></td>
                  <td><span class="<?php echo $color; ?>"><?php echo $row["order_status"]; ?></span></td>
                  <td><?php echo $row["date"]; ?></td>
                  <td><i class="fa fa-trash-o ml-3" onclick="delete_order(<?php echo $row["id"]; ?>)" style="cursor: pointer;"></i></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /end of Displaying Customer Information -->
    </div>
    <!-- /end of update row2 -->
  </div><br>



  <!-- footer -->
  <div class="footer">
    <div class="row brandName">
      <div class="col-md-12 text-center">
        <h2>Fashioner</h2>
      </div>
    </div>
    <div class="row subscribe" id="subscribe_form">
      <div class="col-md-12 text-center">
        <form method="post">
          <input type="hidden" name="pid" id="pidVal">
          <input type="email" name="email" id="email" placeholder=" Enter email to get update" required="">
          <input type="submit" name="submit" value="Subscribe" id="subscribe">
        </form>
      </div>
    </div>
    <div class="row footer_content">
      <div class="col-md-4">
        <h5>ABOUT US</h5>
        <p>Fashioner is a company in clothing fashions which stand for Higher standards and manufactures for the upper-end female clients. It focuses on classic and new trends to bring the smiles with fashions On women clients. </p>
        <h5>CONNECTED WITH</h5>
        <img src="img/us.png" height="45px" width="40px" style="margin-top: -5px;">
        <img class="ml-2" src="img/uk.png" height="25px" width="40px" style="margin-top: -5px;">
        <img class="ml-2" src="img/aus.png" height="42px" width="40px" style="margin-top: -5px;">
        <img class="ml-2" src="img/india.png" height="40px" width="40px" style="margin-top: -5px;">
      </div>
      <div class="col-md-2">
        <h5>SERVICES</h5>
        <li>Shipping & Delivery</li>
        <li>Unique Design</li>
        <li>Customer Services</li>
        <li>Cheaper to Expensive(Pricing)</li>
      </div>
      <div class="col-md-2">
        <h5>LATEST PRODUCT</h5>
        <li>Midi Dress</li>
        <li>Off the shoulders</li>
        <li>Shift Dress</li>
        <li>Bodycon Dress</li>
      </div>
      <div class="col-md-2">
        <h5>CONTACT US</h5>
        <li><?php echo $email; ?></li>
        <li><?php echo $phone; ?></li>
        <li><?php echo $location; ?></li>
        <i class="fa fa-facebook mt-2 ml-3" style="font-size: 20px;"></i>
        <i class="fa fa-envelope mt-2 ml-3" style="font-size: 20px;"></i>
        <i class="fa fa-instagram mt-2 ml-3" style="font-size: 22px;"></i>
        <i class="fa fa-twitter mt-2 ml-3" style="font-size: 22px;"></i>
      </div>
      <div class="container legalTerms">
        <img src="img/visa.png" class="ml-3" height="30px" width="40px">
        <img src="img/paypal.png" class="ml-3" height="32px" width="50px">
        <img src="img/discover.png" class="ml-3" height="32px" width="50px">
        <img src="img/master.png" class="ml-3" height="30px" width="50px">
        <div class="mt-2" id="seperator"></div>
        <div class="col-md-12 mt-2">
          <a href="cookies.php">COOKIES POLICY | </a>
          <a href="terms.php">TERMS OF USE | </a>
          <a href="privacy.php">PRIVACY POLICY | </a>
          <a href="HELP.php">HELP</a><br>
          <p>&copy 2021 ARONA.COM LLC. ALL RIGHTS RESERVED.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- bottom navbar -->
  <div class="container-fluid bg-light py-2 fixed-bottom" id="bottomNav">
    <div class="row d-flex justify-content-center">
      <div class="px-3 ml-0 border-right border-1" onclick="homeBottomIcon()">
        <i class='bx bx-home-circle mt-2 text-dark'></i>
      </div>
      <div class="px-3 ml-0 border-right border-1" id="cart1">
        <i class='bx bx-shopping-bag bx-flip-horizontal mt-2'></i>
        <span><?php echo $cart_no; ?></span>
        <input type="hidden" value="<?php echo $cart_no; ?>" id="cart_count">
      </div>
      <div class="px-3 ml-0 border-right border-1" onclick="wishlistBtn()">
        <i class='bx bx-heart bx-flip-horizontal mt-2 text-dark'></i>
        <span><?php echo $wishlist_count; ?></span>
      </div>
      <div class="px-3 ml-0 border-right border-1" onclick="userBottomIcon()">
        <i class='bx bx-user bx-flip-horizontal mt-2 text-dark'></i>
      </div>
      <div class="px-3 ml-0 border-right border-1" onclick="appearSeachbar()">
        <i class='bx bx-search mt-2 text-dark'></i>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<!--owl-carousel-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://use.fontawesome.com/b491cd4834.js"></script>
<script type="text/javascript" src="script_code.js"></script>
<script src="extraScript.js"></script>
<script src="sidebar.js"></script>
<script>
  //preloader
  var preloader = document.getElementById('loader');
  preloader.style.display = "auto";

  function loader() {
    setTimeout(() => {
      preloader.style.display = "none";
    }, 1000);
  }
  // update information
  $("#profile_change").css("display", "none")
  $("#username_change").css("display", "none")
  $("#password_change").css("display", "none")
  $("#contact_change").css("display", "none")

  function profile_change() {
    if ($("#profile_change").is(":visible")) {
      $("#profile_change").css("display", "none")
      $("#customer_data").css("display", "block")
    } else {
      $("#profile_change").css("display", "block")
      $("#username_change").css("display", "none")
      $("#contact_change").css("display", "none")
      $("#password_change").css("display", "none")
      $("#customer_data").css("display", "none")
    }
  }

  function username_change() {
    if ($("#username_change").is(":visible")) {
      $("#username_change").css("display", "none")
      $("#customer_data").css("display", "block")
    } else {
      $("#username_change").css("display", "block")
      $("#profile_change").css("display", "none")
      $("#contact_change").css("display", "none")
      $("#password_change").css("display", "none")
      $("#customer_data").css("display", "none")
    }
  }

  function password_change() {
    if ($("#password_change").is(":visible")) {
      $("#password_change").css("display", "none")
      $("#customer_data").css("display", "block")
    } else {
      $("#password_change").css("display", "block")
      $("#profile_change").css("display", "none")
      $("#contact_change").css("display", "none")
      $("#username_change").css("display", "none")
      $("#customer_data").css("display", "none")
    }
  }

  function contact_change() {
    if ($("#contact_change").is(":visible")) {
      $("#contact_change").css("display", "none")
      $("#customer_data").css("display", "block")
    } else {
      $("#contact_change").css("display", "block")
      $("#profile_change").css("display", "none")
      $("#password_change").css("display", "none")
      $("#username_change").css("display", "none")
      $("#customer_data").css("display", "none")
    }
  }
</script>

</html>
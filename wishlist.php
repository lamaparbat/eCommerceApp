<?php
include 'connection.php';
$count = $cart_no = 0;

//check whether customer already login or not
session_start();
$username = $user_name = "";
if (strlen(isset($_SESSION['email'])) != 0 && strlen(isset($_SESSION['password'])) != 0) {
  $uemail = $_SESSION["email"];
  $select_query0 = "SELECT * FROM customer WHERE email = '$uemail'";
  $fire1 = mysqli_query($con, $select_query0);
  while ($row = mysqli_fetch_assoc($fire1)) {
    $username = $row["uname"];
  }
  $user_name = substr($username, 0, strpos($username, " "));
  if (strlen($user_name) == 0) {
    $user_name = $username;
  }
}

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);


//get the size of session array
if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
}

//get the id of selected product from search bar
if (isset($_POST["getPid"])) {
  $pid = $_POST["pid"];
  $_SESSION["pid"] = $pid;
  echo "<script>location.assign('selected_product.php')</script>";
}

// same as above but from search.php
if (isset($_POST["save"])) {
  $pid = $_POST["pid"];
  $_SESSION["pid"] = $pid;
  echo "<script>location.assign('selected_product.php')</script>";
}

// subscribe and product love backend
$pid = 0;
$email = $found = "";
if (isset($_POST["submit"])) {
  $pid = $_POST["pid"];
  $email = $_POST["email"];
  if ($pid != "" && $email != "") {
    //check whether user already like that product or not?
    $select_query1 = "SELECT * FROM plove";
    $fire1 = mysqli_query($con, $select_query1) or die(mysqli_error($con));
    while ($row = mysqli_fetch_assoc($fire1)) {
      if ($row["email"] == $email && $row["pid"] == $pid) {
        echo "<script>alert('You already like that Product!!')</script>";
        $found = "true";
        break;
      } else {
        $found = "false";
      }
    }

    // if found is true then run below code
    if ($found == "false") {
      $insert_query = "INSERT INTO plove(pid,email) VALUES('$pid','$email')";
      mysqli_query($con, $insert_query) or die(mysqli_error($con));
      // get the number of likes on specific product 
      $select_query2 = "SELECT * FROM plove";
      $fire2 = mysqli_query($con, $select_query2) or die(mysqli_error($con));
      while ($row = mysqli_fetch_assoc($fire2)) {
        if ($row["pid"] == $pid) {
          $count++;
        }
      }

      // update the likes on store database
      $update_query = "UPDATE store SET likes='$count' WHERE pid='$pid'";
      mysqli_query($con, $update_query) or die(mysqli_error($con));
    }
  } else {
    //visitor subscriber
    $select_query3 = "SELECT * FROM visitors";
    $fire3 = mysqli_query($con, $select_query3) or die(mysqli_error($con));
    while ($row = mysqli_fetch_assoc($fire3)) {
      if ($row["email"] == $email) {
        echo "<script>alert('You already Subscribed Us!!')</script>";
        break;
      } else {
        $insert_query = "INSERT INTO visitors(email) VALUES('$email')";
        mysqli_query($con, $insert_query) or die(mysqli_error($con));
        echo "<script>alert('Thank You!!')</script>";
        break;
      }
    }
  }
}

// -> (buy button) get the selected product pid and store it into session 
if (isset($_POST["product_id"])) {
  $_SESSION["pid"] = $_POST["pid"];
  echo "<script>location.assign('selected_product.php')</script>";
}

// footer data
$email = $phone = $location = "";
$select_query = "SELECT * FROM admin";
$fire = mysqli_query($con, $select_query) or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($fire)) {
  $email = $row["email"];
  $phone = $row["phone"];
  $location = $row["location"];
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Fashioner</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!--owl-carousel-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- font awesome -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://use.fontawesome.com/b491cd4834.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="responsive.css">
  <link rel="stylesheet" type="text/css" href="extraCss.css">
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

    .collection .row .owl-theme .item #card-img #loveProduct {
      top: 10px;
      left: 10px;
      font-size: 20px;
      color: #555555;
      box-shadow: 3px 3px 3px #e78267;
      position: absolute;
      z-index: 2;
    }

    .navbar .navbar-collapse li {
      margin-left: 10px;
      border-top: 0.5px solid white;
      border-left: 0.5px solid white;
      border-right: 0.5px solid white;
    }

    .navbar .navbar-collapse li:hover {
      border-bottom: 0.5px solid red;
      transition: 1s linear;
      transform: scale(1.2);
      background-color: unset;
    }

    .banner {
      height: 500px;
      overflow: hidden;
    }

    @media (max-width: 1400px) {
      .banner {
        height: 100%;
      }
    }

    @media(max-width: 990px) {
      .navbar .navbar-collapse form #username {
        margin-top: 0px;
      }
    }

    #highlighted-nav {
      text-align: center;
    }

    #highlighted-nav a {
      color: white;
      font-size: 14px;
      letter-spacing: 1px;
      display: inline;
      cursor: pointer;
    }
  </style>
</head>

<body onload="loader()">
  <!-- highlighted lables -->
  <div class="container-fluid text-light fixed-top" id="highlighted-nav" style="background-color: #FF8469;">
    <a class="mt-2">FREE SHIPPING OVER $40 |</a>
    <a class="mt-2 ml-2">UPTO 50% OFF |</a>
    <a class="mt-2 ml-2">UPTO 70% OFF AVAILABLE</a>
  </div>
  <!-- navbar -->
  <?php include 'navbar.php'; ?>

  <!-- search bars -->
  <div class="container-fluid bg-light mt-5 pt-4 pb-3 position-fixed searchNav" style="z-index: 2;">
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <input class="form-control mr-sm-2 mt-1 rounded-0 border-dark" type="search" placeholder="Search your favourite product" aria-label="Search" id="nav-search">
      </div>
      <div class="col-sm-4"></div>
    </div>
  </div><br><br><br>
  <!-- searching result -->
  <div class="container pt-5" id="search_result">
    <h5></h5>
    <div class="row p-5">
      <div class="card-columns"></div>
    </div>
  </div>

  <!-- loader -->
  <div id="loader"></div>

  <!-- send selected product id -->
  <form method="post" action="index.php" id="selected_product_id">
    <input type="hidden" name="pid" id="pid">
    <input type="submit" name="getPid" id="send" class="d-none">
  </form>

  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-12">
        <div class="card-columns">
          <?php
          $select = "SELECT * FROM wishlist ORDER BY pid DESC";
          $fire = mysqli_query($con, $select) or die(mysqli_error($con));
          while ($row = mysqli_fetch_assoc($fire)) {
            $id = $row['pid'];
            $query = "SELECT * FROM store WHERE pid='$id'";
            $result = mysqli_query($con, $query) or die(mysqli_error($con));
            while ($row = mysqli_fetch_assoc($result)) {
              //extract the images into array
              $img_arr = explode("+", $row["img"]);
              // check for multi color product and store it into array
              $productName = $row["pname"];
              $colors = array();
              $index = 0;
              $query = "SELECT * FROM store WHERE pname='$productName'";
              $result = mysqli_query($con, $query) or die(mysqli_error($con));
              while ($array = mysqli_fetch_assoc($result)) {
                if ($array["pname"] == $productName) {
                  $colors[$index] = $array["color"];
                  $index++;
                }
              }
          ?>
              <!-- start of card -->
              <div class="card card1">
                <img src="./quantam-lite/upload/<?php echo $img_arr[0]; ?>" class="card-img-top">
                <a href="#subscribe_form" onclick="getPid(<?php echo $row["pid"]; ?>)">
                </a>
                <div class="card-body pt-2 pb-3">
                  <p class="card-text mb-0" style="letter-spacing: 1px;"><?php echo $row["pname"]; ?></p>
                  <p class="card-text text-danger mb-2" style="letter-spacing: 1px;">$USD <?php echo $row["pprice"]; ?></p>
                  <form method="post">
                    <input type="hidden" name="pid" value="<?php echo $row["pid"]; ?>">
                    <?php
                    foreach ($colors as $i) {
                    ?>
                      <div style="display: inline-block;">
                        <div class="ml-1" style="height:20px;width:20px;border:1px solid #333;background-color: <?php echo $i; ?>;cursor: pointer;"></div>
                      </div>
                    <?php } ?><br>
                    <input type="submit" class="btn btn-info mt-1 rounded-0 pr-2 pl-2 pt-0 pb-0" id="product_id" name="product_id" value="Buy Now">
                    <button type="button" class="btn btn-danger mt-1 rounded-0 pr-2 pl-2 pt-0 pb-0" name="product_id" onclick="removeWishlist(<?php echo $row["pid"]; ?>)"><i class="fa fa-times-circle"></i> &nbsp Remove from wishlist</button>
                  </form>
                </div>
              </div>
              <!-- /end of cards -->
          <?php }
          } ?>
        </div>
      </div>
    </div>
  </div>

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
  <div id="curtains"></div>

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
  //fade in love icon
  $(".collection .row .owl-theme .item #card-img #loveProduct").fadeOut(0)
  $(".collection .row .owl-theme .item #card-img #loveProduct").fadeIn(1000)

  //send the selected product id
  function sendSelectedProductId(id) {
    $("#selected_product_id #pid").val(id)
    $("#selected_product_id #send").click()
  }

  function loveProduct(event, id) {
    let classVal = event.target.className
    if (classVal == "fa fa-heart-o") {
      event.target.className = "fa fa-heart"
    } else {
      event.target.className = "fa fa-heart-o"
    }
  }

  //remove from wishlist
  function removeWishlist(id) {
    $.ajax({
      url: "removeWishlistProduct.php",
      method: "post",
      data: {
        data: true,
        id
      },
      success: function(data) {
        location.assign("removeWishlistProduct.php")
      }
    })
  }
</script>

</html>
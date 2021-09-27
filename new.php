<?php
include 'connection.php';
$cart_no = 0;
//check whether customer already login or not
session_start();
$username = $uemail = $user_name =  "";
if (strlen(isset($_SESSION['email'])) != 0 && strlen(isset($_SESSION['password'])) != 0) {
  $uemail = $_SESSION["email"];
  $select_query0 = "SELECT * FROM customer WHERE email = '$uemail'";
  $fire1 = mysqli_query($con, $select_query0) or die(mysqli_error($con));
  while ($row = mysqli_fetch_assoc($fire1)) {
    $username = $row["uname"];
  }
  $user_name = substr($username, 0, strpos($username, " "));
  if (strlen($user_name) == 0) {
    $user_name = $username;
  }
}

if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
}

$email = $phone = $location = "";
$select_query = "SELECT * FROM admin";
$fire = mysqli_query($con, $select_query) or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($fire)) {
  $email = $row["email"];
  $phone = $row["phone"];
  $location = $row["location"];
}

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);

// -> (buy button) get the selected product pid and store it into session 
if (isset($_POST["product_id"])) {
  $_SESSION["pid"] = $_POST["pid"];
  echo "<script>location.assign('selected_product.php')</script>";
}

// / same as above but from search.php
if (isset($_POST["save"])) {
  $pid = $_POST["pid"];
  $_SESSION["pid"] = $pid;
  echo "<script>location.assign('selected_product.php')</script>";
}

// get the search count from session
$search_count = 0;
$search_result_count = "";
$display = "d-none";
// sorting navigation bar handling
if (isset($_POST["search_btn"])) {
  // get size only if it is not empty
  if (isset($_POST["category"]) != "") {
    $category = $_POST["category"];
  } else {
    $category = "";
  }

  // get size only if it is not empty
  if (isset($_POST["size"]) != "") {
    $size = $_POST["size"];
  } else {
    $size = 0;
  }
  // get color only if it is not empty
  if (isset($_POST["color"]) != "") {
    $color = $_POST["color"];
  } else {
    $color = "";
  }
  //get price only if it is not empty
  if (isset($_POST["price"]) != "") {
    $price = $_POST["price"];
  } else {
    $price = "";
  }
  //price range calculation
  $dot_pos = strpos($price, "-");
  $low = substr($price, 0, $dot_pos);
  $high = substr($price, $dot_pos + 1);
  if ($high == "100") {
    $query = "SELECT * FROM store WHERE collectiontype ='$category' OR size = '$size' OR color = '$color' OR pprice>='$low'";
  } else if ($low == "0") {
    $query = "SELECT * FROM store WHERE collectiontype ='$category' OR size = '$size' OR color = '$color' OR pprice<='$high'";
  } else {
    $query = "SELECT * FROM store WHERE collectiontype ='$category' OR size = '$size' OR color = '$color' OR pprice>='$low' AND pprice<='$high'";
  }

  //data base mapping
  $fire = mysqli_query($con, $query) or die(mysqli_error($con));
  while ($row = mysqli_fetch_assoc($fire)) {
    $search_count++;
  }
  $display = "d-block";
  $search_result_count = 'Seaching Result: ' . $search_count;
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Fashioner</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!-- font awesome -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://use.fontawesome.com/b491cd4834.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="responsive.css">
  <style>
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

    .card .card-body #product_id {
      margin-top: -20px;
    }

    #search_model {
      padding: 10px;
      margin-top: -85px;
      margin-left: 1170px;
      width: 240px;
      position: absolute;
      z-index: 4444;
      background-color: #FFFFFF;
    }

    #curtains {
      top: 85px;
      height: 100vh;
      width: 100%;
      position: absolute;
      background-color: #5A5A5A;
      opacity: 0.5;
      z-index: 444;
    }

    .store {
      margin-top: -50px;
    }

    @media(max-width: 1300px) {
      #search_model {
        margin-left: 0px;
      }

      .store {
        margin-top: 0px;
      }
    }

    @media(max-width: 990px) {
      .navbar .navbar-collapse form #username {
        margin-top: 0px;
      }
    }
  </style>
</head>

<body onload="loader()">
  <!-- navbar -->
  <?php include 'navbar.php' ?>

  <!-- search bars -->
  <div class="container-fluid bg-light pt-4 pb-3 position-fixed searchNav" style="z-index: 2;">
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <input class="form-control mr-sm-2 mt-1 rounded-0 border-dark" type="search" placeholder="Search your favourite product" aria-label="Search" id="nav-search">
      </div>
      <div class="col-sm-4"></div>
    </div>
  </div>

  <!-- store  -->
  <div class="container-fluid mt-5 store">
    <!-- sorting navbar -->
    <form method="post">
      <nav class="navbar navbar-expand-lg">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item mr-auto">
            <h6 class="mt-2">500+ Products</h6>
          </li>
          <li class="nav-item"><a class="btn btn-light dropdown-toggle pl-3 pr-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filter</a></li>
          <li class="nav-item" id="sort">
            <div class="dropdown">
              <a class="btn btn-light dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort</a>
              <div class="dropdown-menu position-absolute" aria-labelledby="dropdownMenuButton" style="left:-130px;">
                <a class="dropdown-item" href="#" onclick="sort('auto')"><input type="radio" name="sort" value="recommend">&nbsp We Recommend</a>
                <a class="dropdown-item" href="#" onclick="sort('desc')"><input type="radio" name="sort" value="high-low">&nbsp Price(High to Low)</a>
                <a class="dropdown-item" href="#" onclick="sort('asc')"><input type="radio" name="sort" value="low-high">&nbsp Price(Low to High)</a>
                <a class="dropdown-item" href="#" onclick="sort('trend')"><input type="radio" name="sort" value="popular">&nbsp Most Popular</a>
              </div>
            </div>
          </li>
        </ul>
      </nav>
    </form>

    <div class="container">
      <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
          <div class="collapse" id="collapseExample">
            <form method="post">
              <div class="row p-3" style="border:0.2px solid #FAFAFA;background-color:#FAFAFA;">
                <div class="col-md-4 pt-4" style="height:300px;overflow-y:scroll;">
                  <span class="ml-4 pt-3 pb-3"><b>Category</b></span>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Accessories">&nbsp Accessories</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Beachwear">&nbsp Beachwear</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Coats & Jackets">&nbsp Coats & Jackets</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Co-ordinates">&nbsp Co-ordinates</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Denim">&nbsp Denim</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Dresses">&nbsp Dresses</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Jumpsuits">&nbsp Jumpsuits</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Jumpers & Cardigans">&nbsp Jumpers & Cardigans</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Loungewear">&nbsp Loungewear</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Nightwears">&nbsp Nightwears</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Shorts">&nbsp Shorts</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Skirts">&nbsp Skirts</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Swimwear">&nbsp Swimwear</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Tops">&nbsp Tops</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Tracksuits">&nbsp Tracksuits</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="category" value="Trousers">&nbsp Trousers</a>
                </div>
                <div class="col-md-2 pt-4" style="height:300px;overflow-y:scroll;">
                  <span class="ml-4 pt-3 pb-3"><b>SIZE</b></span>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="size" value="M/L">&nbsp M/L</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="size" value="L">&nbsp L</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="size" value="L/XL">&nbsp L/XL</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="size" value="XL">&nbsp XL</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="size" value="XXL">&nbsp XXL</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="size" value="XXXL">&nbsp XXXL</a>
                </div>
                <div class="col-md-3 pt-4" style="height:300px;overflow-y:scroll;">
                  <span class="ml-4 pt-3 pb-3"><b>COLOR</b></span>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Beige">&nbsp Beige</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Blue">&nbsp Blue</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Grey">&nbsp Grey</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Navy">&nbsp Navy</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Nude">&nbsp Nude</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Pink">&nbsp Pink</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Red">&nbsp Red</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="White">&nbsp White</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Brown">&nbsp Brown</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Green">&nbsp Green</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Khaki">&nbsp Khaki</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Orange">&nbsp Orange</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Purple">&nbsp Purple</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Silver">&nbsp Silver</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Yellow">&nbsp Yellow</a>
                  <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="Gold">&nbsp Gold</a>
                </div>
                <div class="col-md-3 pt-4" style="height:300px;overflow-y:scroll;">
                  <span class="ml-4 pt-3 pb-3"><b>PRICE</b></span>
                  <a class="dropdown-item" href="#"><input type="radio" name="price" value="0-5">&nbsp Under $5</a>
                  <a class="dropdown-item" href="#"><input type="radio" name="price" value="5-15">&nbsp $5-$15</a>
                  <a class="dropdown-item" href="#"><input type="radio" name="price" value="15-30">&nbsp $15-$30</a>
                  <a class="dropdown-item" href="#"><input type="radio" name="price" value="30-50">&nbsp $30-$50</a>
                  <a class="dropdown-item" href="#"><input type="radio" name="price" value="50-100">&nbsp $50-over</a>
                  <input class="btn btn-info mt-3 ml-4 pt-0 pb-0 pl-4 pr-4" type="submit" name="search_btn" value="apply">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid pt-2 pl-5 pr-5" id="sorting_nav_result">
      <div class="container-fluid">
        <h6 class="text-success ml-5 <?php echo $display; ?>"><?php echo $search_result_count; ?></h6>
      </div>
      <div class="row">
        <div class="card-columns p-3">
          <?php
          // sorting navigation bar handling
          if (isset($_POST["search_btn"])) {
            // get size only if it is not empty
            if (isset($_POST["category"]) != "") {
              $category = $_POST["category"];
            } else {
              $category = "";
            }

            // get size only if it is not empty
            if (isset($_POST["size"]) != "") {
              $size = $_POST["size"];
            } else {
              $size = 0;
            }
            // get color only if it is not empty
            if (isset($_POST["color"]) != "") {
              $color = $_POST["color"];
            } else {
              $color = "";
            }
            //get price only if it is not empty
            if (isset($_POST["price"]) != "") {
              $price = $_POST["price"];
            } else {
              $price = "";
            }
            //price range calculation
            $dot_pos = strpos($price, "-");
            $low = substr($price, 0, $dot_pos);
            $high = substr($price, $dot_pos + 1);
            if ($high == "100") {
              $query = "SELECT * FROM store WHERE collectiontype ='$category' OR size = '$size' OR color = '$color' OR pprice>='$low'";
            } else if ($low == "0") {
              $query = "SELECT * FROM store WHERE collectiontype ='$category' OR size = '$size' OR color = '$color' OR pprice<='$high'";
            } else {
              $query = "SELECT * FROM store WHERE collectiontype ='$category' OR size = '$size' OR color = '$color' OR pprice>='$low' AND pprice<='$high'";
            }

            //data base mapping
            $fire = mysqli_query($con, $query) or die(mysqli_error($con));
            while ($row = mysqli_fetch_assoc($fire)) {
              $pid = $row["pid"];
              $img = $row["img"];
              $name = $row["pname"];
              $price = $row["pprice"];
              //extract array image
              $img_arr = explode("+", $img);
              $data =
                '<div class="card">
            <img src="./quantam-lite/upload/' . $img_arr[0] . '" class="card-img">
            <div class="card-body">
              <h6 class="card-title">' . $name . '</h6>
              <p class="card-text">$USD ' . $price . '</p>
              <form method="post">
                <input type="hidden" name="pid" id="pid" value="">
                <input type="submit" name="save" id="submit" style="visibility:hidden;position:absolute;">
                <a href="#" class="btn btn-info" onclick="getId(' . $pid . ')">Get</a>
              </form>
            </div>
          </div>';
              echo $data;
            }
          }
          ?>
        </div>
      </div>
    </div>
    <!-- searching result -->
    <div class="container" id="search_result">
      <div class="row pb-5">
        <div class="card-columns pb-5"></div>
      </div>
    </div>

    <!-- loader -->
    <div id="loader"></div>

    <!-- trending -->
    <div class="container-fluid pl-5 pr-5 collection" id="clothing">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <div class="card-columns">
            <?php
            $month = date("M");
            $select = "SELECT * FROM store";
            $fire = mysqli_query($con, $select) or die(mysqli_error($con));
            while ($row = mysqli_fetch_assoc($fire)) {
              $date = $row["date"];
              if (strpos($date, $month) == true) {
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
                    <p class="card-text text-danger" style="letter-spacing: 1px;">$USD <?php echo $row["pprice"]; ?></p>
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
                    </form>
                  </div>
                </div>
                <!-- /end of cards -->
            <?php
              }
            }
            ?>
          </div>
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
  // get the sort type
  function sort(type) {
    $.ajax({
      url: "sort.php",
      method: "post",
      data: {
        data: true,
        type
      },
      success: function(data) {
        $(".store #sorting_nav_result .row .card-columns").html(data);
      }
    })
  }
</script>

</html>
<?php
include 'connection.php';
$total = $final = $cart_no =  0;
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
//get the size of array count -> total number of add to cart product
if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
} else {
  header("Location:index.php");
}
// start the session to store the pid and get the product details through pid
$id = $_SESSION["pid"];

$select_query = "SELECT * FROM store WHERE pid='$id'";
$fire = mysqli_query($con, $select_query) or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($fire)) {
  $pname = $row["pname"];
  $pprice = $row["pprice"];
  $likes = $row["likes"];
  $comments = $row["comments"];
  $img = $row["img"];
}

// count the total ORDER
$order_no = 0;
$select_query = "SELECT * FROM orders";
$fire = mysqli_query($con, $select_query) or die(mysqli_error($con));
$order_no = mysqli_num_rows($fire);

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);

$date = date("D/M/Y");
if (isset($_SESSION["aroma_total"])) {
  $total_cost = $_SESSION["aroma_total"];
}

// get the voucher code from customer 
$query = "SELECT * FROM customer WHERE uname = '$username'";
$fire = mysqli_query($con, $query) or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($fire)) {
  $voucher_code = $row["voucher_code"];
  $voucher_discount_percent = $row["voucher_discount_percent"];
}

//voucher code discount validation
$is_voucher_valid = "false";
if (isset($_POST["apply"])) {
  $voucher_code_no = $_POST["voucher_code"];
  if ($voucher_code != "") {
    if ($voucher_code_no == $voucher_code) {
      $is_voucher_valid = "true";
    }
  }
}

// confirm payment
if (isset($_POST["confirm_payment"])) {
  $payment_method = $_POST["payment_method"];
  $cnumber = $_POST["cnumber"];
  $cv = $_POST["cv"];
  $date = $_POST["date"];
  $card_owner = $_POST["card_owner"];
  if ($cnumber = "12" && $cv = "1201" && $card_owner = "parbat" && $payment_method != "") {
    $query = "INSERT INTO orders(cid,cname, pname, total, payment_status, payment_method,date,order_status) VALUES('$order_no','$username','$all_pname','$total_cost','Paid','$payment_method','$date','paid')";
    mysqli_query($con, $query) or die(mysqli_error($con));
    unset($_SESSION["cart"]);
    unset($_SESSION["quantity"]);
    unset($_SESSION["aroma_total"]);
    $_SESSION["cart"] = 0;
    $_SESSION["quantity"] = 0;
    $_SESSION["aroma_total"] = 0;
    echo "<script>location.assign('index.php')</script>";
  }
}

// cash on delivery payment
if (isset($_POST["cash_on_delivery"])) {
  // insert order id in dbase one by one
  $key = array_keys($_SESSION["cart"]);
  foreach ($key as $i) {
    if ($i != 0) {
      $pid = $_SESSION["cart"][$i];
      $quantity = $_SESSION["quantity"][$i];
      // get the product data using pid
      $query = "SELECT * FROM store WHERE pid = '$pid'";
      $fire = mysqli_query($con, $query) or die(mysqli_error($con));
      while ($row = mysqli_fetch_assoc($fire)) {
        $name = $row["pname"];
        $price = $row["pprice"];
        $query = "INSERT INTO orders(cid,cname, pname, quantity, total, payment_status, payment_method,date,order_status) VALUES('$cid','$username','$name','$quantity',$price,'cash on delivery',' ','$date','processing')";
        mysqli_query($con, $query) or die(mysqli_error($con));
      }
    }
  }

  unset($_SESSION["cart"]);
  unset($_SESSION["quantity"]);
  unset($_SESSION["aroma_total"]);
  $_SESSION["cart"][0] = 0;
  $_SESSION["quantity"][0] = 0;
  echo "<script>location.assign('index.php')</script>";
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
  <title>Fashioner / Shopping-Cart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <!-- font awesome -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://use.fontawesome.com/b491cd4834.js"></script>
  <!-- style.css -->
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

    /*bottomNav*/
    #bottomNav {
      box-shadow: -1px -2px 5px 0px rgba(125, 125, 125, 0.73);
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

    @media(max-width: 990px) {
      .navbar .navbar-collapse form #username {
        margin-top: 0px;
      }
    }

    /* cart.php */
    .store .row .col-md-8 .row .col-md-5 {
      padding-left: 30px;
    }

    @media(max-width: 1200px) {
      .store .row .col-md-8 .row .col-md-5 {
        padding-left: 80px;
      }
    }

    @media(max-width: 750px) {
      .store .row .col-md-8 .row .col-md-5 {
        padding-left: 20px;
      }

      .store .row .col-md-4 {
        margin-top: 15px;
        background-color: white;
      }
    }
  </style>
</head>

<body class="bg-light" onload="loader()">
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

  <!-- main container -->
  <div class="container store">
    <!-- Payment gateway -->
    <div class="container p-5" id="payment_gateway" style="position: absolute;left:0;">
      <div class="row">
        <div class="col-md-8 pt-4 pr-5 pl-5 pb-5 bg-white">
          <span onclick="previous()" style="cursor: pointer;"><i class="fa fa-arrow-left" aria-hidden="true"></i></span>
          <h5 class="text-center"><b>Payment Details</b></h5><br>
          <!-- gateway-card img -->
          <div class="row pl-5 pr-5">
            <div class="col-md-3"><img src="img/paytm.png" height="70px" width="130px"></div>
            <div class="col-md-3"><img src="img/master.png" height="70px" width="130px"></div>
            <div class="col-md-3"><img src="img/paypal.png" height="70px" width="130px"></div>
            <div class="col-md-3"><img src="img/discover.png" height="70px" width="130px"></div>
          </div><br>
          <form method="post">
            <div class="form-group">
              <select class="form-control" name="payment_method" id="payment_method">
                <option>Paypal</option>
                <option>Visa</option>
                <option>Master</option>
                <option>Discover</option>
              </select>
            </div>
            <input class="form-control" type="text" name="cnumber" id="cnumber" placeholder="Valid Card Number" required="">
            <div class="row mt-3">
              <div class="col-md-6">
                <label>Expiry Date</label>
                <input class="form-control" type="text" name="date" placeholder="MM/YY" required="" id="date">
              </div>
              <div class="col-md-6">
                <label>CV CODE</label>
                <input class="form-control" type="text" name="cv" placeholder="CVC" required="" id="cv">
              </div>
            </div><br>
            <input class="form-control mb-4" type="text" name="card_owner" id="card_owner" placeholder="Card Owner Name" required="" id="card_owner">
            <input class="form-control btn btn-success" type="submit" name="confirm_payment" value="Confirm Payment">
            <hr>
          </form>
          <form method="post">
            <center><input type="submit" name="cash_on_delivery" id="cash_on_delivery" value="Cash On delivery" class="btn btn-info pr-5 pl-5"></center>
          </form>
        </div>
      </div>
    </div><br>


    <!-- ADD-T0-CART -->
    <div class="row pt-2 pl-3 pr-2 pt-5 cart">
      <!-- col-md-7 -->
      <div class="col-md-8">
        <!-- dispaying CART product -->
        <?php
        // get the all pid from session array
        $key = array_keys($_SESSION["cart"]);
        foreach ($key as $i) {
          // echo $i;
          if ($i != 0) {
            $pid = $_SESSION["cart"][$i];
            $quantity = $_SESSION["quantity"][$i];
            // get the product data using pid
            $query = "SELECT * FROM store WHERE pid = '$pid'";
            $fire = mysqli_query($con, $query) or die(mysqli_error($con));
            while ($row = mysqli_fetch_assoc($fire)) {
              $id = $row["pid"];
              $name = $row["pname"];
              $price = $row["pprice"];
              $brand = $row["collectiontype"];
              $color = $row["color"];
              $img = $row["img"];
              $discount =  $row["discount"];
              $shipping = 5;

              //extract the images into array
              $img_arr = explode("+", $img);

              // calculation
              $total = $total + ($quantity * $price);
              if ($discount != 0) {
                $total = $total - ($total * $discount) / 100;
              }
              $vat = $total * (13 / 100);
              $final = $total + $vat + $shipping;

              $_SESSION["aroma_total"] = $final;

              //check if voucher code is inputed
              if ($is_voucher_valid == "true") {
                $voucher_discount_amount = ($voucher_discount_percent * $final) / 100;
                $final = $final - $voucher_discount_amount;
                $_SESSION["aroma_total"] = $final;

                //delete the voucher code
                $null = 0;
                $query = "UPDATE customer SET voucher_code = '$null' WHERE uname = '$username'";
                mysqli_query($con, $query) or die(mysqli_error($con));
              }
            }
        ?>
            <div class="row pt-4 pb-3 bg-white" style="margin-top: 5px; border-bottom: 0.5px solid #E1E0E0">
              <div class="col-md-2">
                <img src="./quantam-lite/upload/<?php echo $img_arr[0]; ?>" height="120px" width="130px">
              </div>
              <div class="col-md-5 mt-3">
                <h6><?php echo $name; ?></h6>
                <p class="text-secondary" style="margin-top: -10px;">Brand: <?php echo $brand; ?>, Color Family: <?php echo $color; ?></p>
              </div>
              <div class="col-md-2 mt-3">
                <h5 class="text-danger">Rs. <?php echo $price; ?></h5>
                <h6><del>Rs. 320</del></h6>
                <h6><?php echo $discount; ?>%</h6>
              </div>
              <div class="col-md-2 mt-4">
                <h6 class="mb-2" id="quantity_val">Quantity: <span id="quantity"><?php echo $quantity; ?></span></h6>
              </div>
              <div class="col-md-1 mt-3">
                &nbsp&nbsp&nbsp&nbsp<i class="fa fa-trash mt-4" arial-hidden="true" style="cursor: pointer;" onclick="delete_session(<?php echo $i; ?>)"></i>
              </div>
            </div>
            <!-- /end dispaying CART product  -->
        <?php
          }
        }
        ?>

      </div>
      <!-- /col-md-7 -->
      <!-- col-md-5 -->
      <div class="col-md-4 pb-2 mt-2">
        <h5 class="mt-2">Order Summary</h5><br>
        <p class="text-secondary">Product Price(<?php echo count($_SESSION["cart"]) - 1; ?> Items) <span style="margin-left: 90px; color: black;">$USD <?php echo $total; ?></span></p>
        <p class="text-secondary mt-2">Shipping Fee <span style="margin-left: 140px; color: black;">$USD 5</span></p>
        <!-- voucher code -->
        <form class="mt-2" method="post">
          <div class="row mt-2">
            <div class="col-md-8">
              <input class="form-control" type="text" name="voucher_code" id="voucher_code" placeholder="Enter Voucher Code ">
            </div>
            <div class="col-md-4">
              <input class="btn btn-info" type="submit" name="apply" value="APPLY" id="apply">
            </div>
          </div><br><br>
        </form>
        <!-- /end of voucher code -->
        <p>Total <span class="text-danger" style="margin-left: 150px; font-size: 18px;">$USD <?php echo $final; ?></span></p>
        <input type="submit" class="btn btn-info form-control" value="Proceed To Pay" onclick="gateway()">
      </div>
      <!-- /col-md-5 -->
    </div><br><br><br>
    <!-- /end of summary -->
  </div><br><br>
  </div>
  </div><br><br><br><br><br><br><br>
  <!-- /end of main container -->

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<!--owl-carousel-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="script_code.js"></script>
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

  // popup payment_verification model only if product added
  $("#payment_gateway").css("visibility", "hidden")
  $("#payment_gateway").css("z-index", "4")

  function gateway() {
    if (len > 10) {
      var count = $("#cart_count").attr("value")
      if (count >= 1) {
        $("#payment_gateway").css("visibility", "visible")
        $(".cart").css("visibility", "hidden")
      } else {
        alert("No product added!!")
      }
    } else {
      alert("Please Login to buy the product!")
      location.assign("login.php")
    }
  }

  function previous() {
    location.assign("cart.php")
  }
</script>

</html>
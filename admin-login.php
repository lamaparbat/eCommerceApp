<?php
include 'connection.php';
$result = $color = "";
if ($con) {
  //check whether customer already login or not
  session_start();
  $username = $user_name =  "";

  // get the total add cart count number
  if (isset($_SESSION["cart"]) != 0) {
    $cart_no = count($_SESSION["cart"]) - 1;
  } else {
    $cart_no = 0;
  }

  // login form handling
  if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $checkbox = $_POST["checkbox"];

    //select query 
    $select_query = "SELECT * FROM admin";
    $fire = mysqli_query($con, $select_query);
    while ($row = mysqli_fetch_assoc($fire)) {
      if ($row["email"] == $email && $row["password"] == $password) {
        $result = "Login successfull";
        $color = "text-success";

        // save user data if user wants to save?
        $_SESSION["aemail"] = $email;
        $_SESSION["apassword"] = $password;
        if ($checkbox == "save") {
          $_SESSION["aemail"] = $email;
          $_SESSION["apassword"] = $password;
        }

        echo "<script>location.assign('/aroma/quantam-lite/index.php');</script>";
      } else {
        $result = "Failed to login!";
        $color = "text-danger";
      }
    }
  }
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
  <script src="https://use.fontawesome.com/b491cd4834.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="responsive.css">
</head>

<body onload="loader()">
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg fixed-top bg-white border-light navbar-light pl-5 pr-4 pt-1 pb-0">
    <a class="navbar-brand" href="index.php"><img src="img/log.png" height="40px" width="40px"></a>
    <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse pb-2" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto pt-2">
        <li class="nav-item">
          <a class="nav-link text-dark" href="new.php" id="li_new">NEW<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="trend.php" id="li_trend">TREND<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="clothing.php" id="li_clothing">CLOTHING</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="shoes.php" id="li_shoes">SHOES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="accessories.php" id="li_accessories">ACCESSORIES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="sale.php" id="li_sale">SALE</a>
        </li>
      </ul>
    </div>
  </nav><br>

  <!-- loader -->
  <div id="loader"></div>

  <!-- searching result -->
  <div class="container" id="search_result">
    <h5>Searching Result: </h5>
    <div class="row p-5">
      <div class="card-columns"></div>
    </div>
  </div>

  <!-- login form -->
  <div class="container-fluid form">
    <div class="row">
      <div class="col-md-5">
        <div class="container-fluid component">
          <h4 class="ml-3">ADMIN LOGIN FORM</h4>
          <form method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email or phone number" required="">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Password" required="">
            </div>
            <div class="form-check">
              <input type="checkbox" name="checkbox" class="form-check-input" id="checkbox" value="save">
              <label class="form-check-label" for="exampleCheck1">Save Password?</label>
            </div>
            <p class="<?php echo $color; ?>" id="result" style="margin-top:-5px;"><?php echo $result; ?></p>
            <input type="submit" name="submit" class="btn btn-info" id="login"><br>
            <a href="/quantam-lite/forgot-password.php" for="exampleCheck1">Forgotten Password?</a><br>
          </form>
        </div>
      </div>
      <div class="col-md-7 p-3"><img src="img/login.png" class="img-fluid"></div>
    </div>
  </div><br><br>

  <!-- footer -->
  <div class="footer">
    <div class="row brandName">
      <div class="col-md-12 text-center">
        <h2>AROMA TAZEEN</h2>
      </div>
    </div>
    <div class="container-fluid subscribe" id="subscribe_form">
      <div class="row">
        <div class="col-md-12 text-center">
          <form method="post" action="">
            <input type="text" name="email" id="email" placeholder=" Enter email to get update">
            <button id="subscribe">SEND</button>
          </form>
        </div>
      </div>
    </div>
    <div class="row footer_content">
      <div class="col-md-4">
        <h5>ABOUT US</h5>
        <p>Aroma Tazeen is a company in clothing fashions which stand for Higher standards and manufactures for the upper-end female clients. It focuses on classic and new trends to bring the smiles with fashions On women clients. </p>
        <h5>CONNECTED WITH</h5>
        <img src="img/us.png" height="40px" width="40px">
        <img src="img/uk.png" height="40px" width="40px">
        <img src="img/aus.png" height="40px" width="40px">
        <img src="img/india.png" height="40px" width="40px">
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
        <img src="img/fb.png" class="ml-3 mt-1" height="20px" width="20px">
        <img src="img/insta.png" class="ml-2 mt-1" height="20px" width="20px">
        <img src="img/google.png" class="ml-2 mt-1" height="20px" width="20px">
        <img src="img/twitter.png" class="ml-2 mt-1" height="20px" width="20px">
      </div>
      <div class="container legalTerms">
        <img src="img/visa.png" class="ml-3" height="40px" width="40px">
        <img src="img/stripe.png" class="ml-3" height="40px" width="40px">
        <img src="img/paytm.png" class="ml-3" height="65px" width="65px">
        <img src="img/amazonpay.png" class="ml-3" height="45px" width="45px">
        <div id="seperator"></div>
        <div class="col-md-12 mt-2">
          <a href="cookies.php">COOKIES POLICY | </a>
          <a href="terms.php">TERMS OF USE | </a>
          <a href="privacy.php">PRIVACY POLICY | </a>
          <a href="help.php">HELP</a><br>
          <p>&copy 2021 ARONA.COM LLC. ALL RIGHTS RESERVED.</p>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="script_code.js"></script>
<script src="sidebar.js"></script>
<script>
  //preloader
  var preloader = document.getElementById('loader');
  preloader.style.display = "block";

  function loader() {
    setTimeout(() => {
      preloader.style.display = "none";
    }, 1000);
  }

  // / check the admin already  loggedin or not-> if loggedIn hide the signup and signin link
  var username = $("#username").val();
  // alert(username)
  var len = username.length;
  // visibility
  $("#username").css("visibility", "hidden");
  // $("#cart").css("visibility","hidden");
  $("#signin").css("visibility", "visible");
  // position
  $("#username").css("position", "absolute");
  // $("#cart").css("position","absolute");
  $("#signin").css("position", "static");
  $("#signin").css("position", "static");
  if (len != 10) {
    $("#username").css("visibility", "visible");
    //   $("#cart").css("visibility","visible");
    $("#username").css("position", "static");
    //   $("#cart").css("position","static");
    $("#signin").css("visibility", "hidden");
    $("#signin").css("position", "absolute");
  }

  // profile and login option selector
  $('#username').on('change', function() {
    var value = $(this).val();
    if (value == "Profile") {
      location.assign("profile.php")
    }
    if (value == "My Order") {
      location.assign("profile.php#myorder")
    }
    if (value == "Logout") {
      location.assign("logout.php")
    }
  });

  // change country region --> navbar - dropdown
  $(".navbar .collapse form #lang").attr("src", "img/us.jpeg")
  //uk
  $(".navbar .collapse form .dropdown-menu #UK").click(function() {
    $(".navbar .collapse form #lang").attr("src", "img/uk.png")
    $(".navbar .collapse form #title").text(" $ UK / EN")
    $(".welcome-text").css("display", "block")
    $("#sText .row .col-md-12 h5 span").text(" $ UK / EN")
  })
  //us
  $(".navbar .collapse form .dropdown-menu #US").click(function() {
    $(".navbar .collapse form #lang").attr("src", "img/us.jpeg")
    $(".navbar .collapse form #title").text(" $ USA / EN")
    $(".welcome-text").css("display", "block")
    $("#sText .row .col-md-12 h5 span").text(" $ USA / EN")
  })
  //aus
  $(".navbar .collapse form .dropdown-menu #AUS").click(function() {
    $(".navbar .collapse form #lang").attr("src", "img/aus.png")
    $(".navbar .collapse form #title").text(" $ AUSTRALIA / EN")
    $(".welcome-text").css("display", "block")
    $("#sText .row .col-md-12 h5 span").text(" $ AUSTRALIA / EN")
  })
  // INDIA
  $(".navbar .collapse form .dropdown-menu #INDIA").click(function() {
    $(".navbar .collapse form #lang").attr("src", "img/india.png")
    $(".navbar .collapse form #title").text(" $ INDIA / EN")
    $(".welcome-text").css("display", "block")
    $("#sText .row .col-md-12 h5 span").text(" $ INDIA / EN")
  })


  // redirect to card page only if there is product added
  $("#cart").click(function() {
    var count = $("#cart_count").attr("value")
    if (count >= 1) {
      location.assign("cart.php")
    } else {
      alert("No product added!!")
    }
  })
  // redirect to card page only if there is product added
  $("#cart1").click(function() {
    var count = $("#cart_count").attr("value")
    if (count >= 1) {
      location.assign("cart.php")
    } else {
      alert("No product added!!")
    }
  })
</script>

</html>
<?php
include 'connection.php';
$result = $color = "";
$cart_no = 0;
if ($con) {
  //check whether customer already login or not
  session_start();
  $username = $user_name =  "";
  if (isset($_SESSION["email"]) != "" && isset($_SESSION["password"]) != "") {
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

  // form handling when submit button clicked
  if (isset($_POST["signin"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $checkbox = $_POST["checkbox"];

    //select query 
    $select_query = "SELECT * FROM customer";
    $fire = mysqli_query($con, $select_query);
    while ($row = mysqli_fetch_assoc($fire)) {
      if ($row["email"] == $email && $row["password"] == $password) {
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $result = "Login Successfull!";
        $color = "text-success";

        // save user data if user wants to save?
        if ($checkbox == "save") {
          $_SESSION["email"] = $email;
          $_SESSION["password"] = $password;
        }
        echo "<script>location.assign('index.php');</script>";
        break;
      } else {
        $result = "Wrong email or password!";
        $color = "text-danger";
      }
    }
  }
}

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);

// *****  signup with google ******
$gmail = "";
include('config2.php');
// get the url of google login interface page
$googlLoginInterface = $google_client->createAuthUrl();
if (isset($_GET["code"])) {
  $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
  if (!isset($token['error'])) {
    $google_client->setAccessToken($token['access_token']);
    $_SESSION['access_token'] = $token['access_token'];
    $google_service = new Google_Service_Oauth2($google_client);
    $data = $google_service->userinfo->get();

    if (!empty($data['email'])) {
      $_SESSION['gmail'] = $data['email'];
      $gmail = $_SESSION['gmail'];
    }
  }
}

if ($gmail != "") {
  //checking the valid email or not
  $result = mysqli_query($con, "SELECT * FROM customer WHERE email = '$gmail'");
  $matchFound = mysqli_num_rows($result) > 0 ? 'yes' : 'no';
  if ($matchFound == 'yes') {
    $_SESSION["email"] = $gmail;
    $_SESSION["password"] = "google";
    echo "<script>location.assign('index.php');</script>";
  } else {
    echo "<script>alert('Email doesnt exist!')</script>";
    echo "<script>location.assign('login.php');</script>";
  }
}
//get the size of session array
if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
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

    #cart1 {
      visibility: hidden;
      position: absolute;
    }

    .navbar #nav-search {
      display: block;
    }

    .navbar #cart {
      display: block;
      font-size: 15px;
    }

    @media (min-height: 1366px) and (min-width: 1024px) {
      .navbar #nav-search {
        display: none;
      }
    }

    @media(max-width: 990px) {
      #cart1 {
        visibility: visible;
        position: static;
      }

      .navbar #cart {
        display: none;
      }

      .navbar .navbar-collapse form #username {
        margin-top: 15px;
      }
    }
  </style>
</head>

<body onload="loader()">
  <!-- navbar -->
  <?php include 'navbar.php'; ?>

  <!-- loader -->
  <div id="loader"></div>

  <!-- login form -->
  <div class="container-fluid form">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6" id="loginForm">
        <div class="container-fluid component">
          <h4 class="ml-3">LOGIN FORM</h4>
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
            <input type="submit" name="signin" class="btn btn-info" id="login"><br>
            <a href="/quantam-lite/forgot-password.php" for="exampleCheck1">Forgotten Password?</a><a class="ml-3" href="signup.php">Create a New Account?</a><br>
            <center>
              <div id="separator">
                <p>OR</p>
              </div>
            </center><br>
            <a href="<?php echo $googlLoginInterface; ?>" style="text-decoration: none;color:white;" class="btn btn-info form-control pt-2" id="loginG" onclick="signupGoogle()"><img src="img/google.png" height="20px" width="25px">LOGIN WITH GOOGLE</a><br>
          </form>
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div><br><br>

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
</script>

</html>
<?php
include 'connection.php';
$result = $color = "";
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

//get the size of session array
if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
}

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);


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

// new account creation 
$img = "";
if (isset($_POST["signup"])) {
  $uname = $_POST["uname"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $repassword = $_POST["repassword"];
  $img = $_FILES['file']['name'];
  $created_on = date("D/M/Y");

  //check whether customer already exist or not 
  $select_query = "SELECT * FROM customer";
  $result = mysqli_query($con, $select_query) or die(mysqli_error($con));
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row["email"] == $email) {
      echo "<script>alert('Account already created!! Thank You for in touch with us!!')</script>";
      $result = "Account already created!!";
      $color = "text-danger";
    } else {
      // upload insert image file into local file folder
      if ($img != "") {
        $temp = $_FILES['file']['tmp_name'];
        move_uploaded_file($temp, "quantam-lite/upload/" . $img) or die(mysqli_error($con));
      }

      //insert query 
      $insert_query = "INSERT INTO customer(uname, email, password, img,created) VALUES('$uname','$email','$password','$img','$created_on')";
      $fire = mysqli_query($con, $insert_query) or die(mysqli_error($con));
      if ($fire) {
        $result = "Account created successfully";
        $color = "text-success";
        echo "<script>location.assign('login.php');</script>";
      } else {
        $result = "Failed to create account!";
        $color = "text-danger";
      }
    }
  }
}

// *****  signup with google ******
$Uname = $Uimg = $Uemail = "";
include('config.php');
// get the url of google login interface page
$googlLoginInterface = $google_client->createAuthUrl();
if (isset($_GET["code"])) {
  $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
  if (!isset($token['error'])) {
    $google_client->setAccessToken($token['access_token']);
    $_SESSION['access_token'] = $token['access_token'];
    $google_service = new Google_Service_Oauth2($google_client);
    $data = $google_service->userinfo->get();

    if (!empty($data['given_name'])) {
      $_SESSION['uname'] = $data['given_name'];
    }

    if (!empty($data['family_name'])) {
      $_SESSION['uname'] = $_SESSION['uname'] . " " . $data['family_name'];
      $Uname = $_SESSION['uname'];
    }

    if (!empty($data['email'])) {
      $_SESSION['uemail'] = $data['email'];
      $Uemail = $_SESSION['uemail'];
    }

    if (!empty($data['gender'])) {
      // $_SESSION['user_gender'] = $data['gender'];
    }

    if (!empty($data['picture'])) {
      $_SESSION['uimg'] = $data['picture'];
      $Uimg = $_SESSION['uimg'];
    }
  }
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
  </style>
</head>

<body onload="loader()">
  <!-- navbar -->
  <?php include 'navbar.php'; ?>

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

  <!-- loader -->
  <div id="loader"></div>

  <!-- searching result -->
  <div class="container pt-5" id="search_result">
    <h5></h5>
    <div class="row p-5">
      <div class="card-columns"></div>
    </div>
  </div>

  <!-- login form -->
  <div class="container-fluid form">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6" id="signupForm">
        <div class="component">
          <h4 class="ml-3">SIGNUP FORM</h4>
          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="exampleInputEmail1">User Name</label>
              <input type="text" class="form-control" name="uname" id="uname" aria-describedby="emailHelp" placeholder="Enter User name" value="<?php echo $Uname; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Email address or Phone number</label>
              <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email or phone number" value="<?php echo $Uemail; ?>">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Enter new password">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Re-enter</label>
              <input type="password" class="form-control" name="repassword" id="repassword" placeholder="Re-enter new password">
            </div>
            <div class="form-group">
              <label class="exampleInputEmail1">Image File: &nbsp </label>
              <input type="file" id="file" name="file" style="position: absolute;visibility: hidden;">
              <span class="text-info" id="detector" style="cursor: pointer;">Click</span>
            </div>
            <p class="<?php echo $color; ?>" id="result" style="margin-top:-5px;"><?php echo $result; ?></p>
            <input type="submit" class="btn btn-info" name="signup" id="signup" value="Complete Submission">
            <input type="button" class="btn btn-info" name="login" id="login" value="Login Page" onclick="redirectToLogin()"><br><br>
            <img src="<?php echo $Uimg; ?>" class="img-fluid" id="img">
            <center>
              <div id="separator">
                <p>OR</p>
              </div>
            </center><br>
            <a href="<?php echo $googlLoginInterface; ?>" style="text-decoration: none;color:white;" class="btn btn-info form-control pt-2" id="loginG" onclick="signupGoogle()"><img src="img/google.png" height="20px" width="25px">SIGNUP WITH GOOGLE</a>
          </form>
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div><br><br>

  <!-- final submission newly created account -> pop model -->
  <div class="container-fluid googleData bg-white">
    <div class="row p-3">
      <div class="col-sm-4"></div>
      <div class="col-sm-4 pb-4 p-3 bg-light" id="mainData">
        <center><img src="https://media.giphy.com/media/3ohhwzIw3bISRhQWME/giphy.gif" height="200px" width="100%"></center>
        <p class="text-center">Thank you <?php echo $uname; ?> for joining us. We do our best to make you happy by providing you the best quality of unique product. Enjoy the website!</p>
        <center><a href="index.php" class="btn btn-danger">Online Registration Completed!</a></center>
      </div>
      <div class="col-sm-4"></div>
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

  <!-- message box toltip -->
  <div class="container-fluid pb-5 pr-3 fixed-bottom" id="messageHelper">
    <div class="row" id="messageBox">
      <div class="col-md-8"></div>
      <div class="col-md-4 p-3 bg-white">
        <div class="d-flex messageNav">
          <img src="img/log.png" height="40px" width="40px">
          <h5 class="mt-2 ml-3">Chat with Aroma Tazeen</h5>
          <ul class="d-flex pt-1 ml-auto list-unstyled">
            <li class="mr-3">
              <div id="messageIcon">
                <i class="fa fa-ellipsis-h" aria-hidden="true" onclick="appearMessageMedia()"></i>
              </div>
            </li>
            <li>
              <div id="messageIcon" onclick="appearMessageBox()"><i class="fa fa-minus" aria-hidden="true"></i>
              </div>
            </li>
          </ul>
        </div>

        <!-- connect with social media -->
        <div class="container-fluid mt-1 pt-2 mb-2" id="visitMedia">
          <div class="row">
            <div class="col-sm-12">
              <ul class="list-unstyled">
                <li class="mt-1">Visit Facebook Page</li>
                <li class="mt-1">Visit Whatsup Page</li>
                <li class="mt-1">Visit Instagram Page</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- message box area -->
        <div class="messageArea">
          <div class="incoming">
            <p>Hi Parbat, thanks for getting in touch. We'll get back to you soon. If your enquiry is regarding admissions, please dial 9801022637.</p>
          </div>
          <div class="outgoing">
            <p>Lorem ipsum dolor sit amet, consectetur voluptate velit essLorem ipsum dolor sit amet, consectetur voluptate velit </p>
          </div>
          <div class="outgoing">
            <p>Lorem ipsum dolor sit amet, consectetur voluptate velit essLorem ipsum dolor sit amet, consectetur voluptate velit </p>
          </div>
        </div>

        <!-- textarea and send button -->
        <input type="text" class="form-control pl-4 mt-3 bg-white" placeholder=" Ask your question...." id="messageInput"></input type="text">
        <i class="fa fa-paper-plane" id="messageSentIcon"></i>
      </div>
    </div><br>

    <!-- float message icon -->
    <div class="row mb-3">
      <div class="col-sm-9"></div>
      <div class="col-sm-3 d-flex">
        <img src="img/chat.png" height="60px" width="60px" class="img-fluid ml-auto" id="appearMessageBox" onclick="appearMessageBox()">
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
<script type="text/javascript" src="script_code.js"></script>
<script type="text/javascript" src="extraScript.js"></script>
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
  //auto click to submit btn to signup google form popup
  $(".googleData #mainData").css("display", "none")
  $(".googleData #mainData").css("position", "absolute")
  $(".googleData #mainData").css("height", "0vh")

  function signupGoogle() {
    $(".googleData #mainData").css("display", "block")
    $(".googleData #mainData").css("position", "fixed")
    $(".googleData #mainData").css("height", "100vh")
  }

  function redirectToLogin() {
    location.assign("login.php")
  }

  //select photo
  $("#detector").click(function() {
    $('#file').click();
    var file = document.querySelector('#file');
    file.addEventListener('change', function() {
      //code to retrive the file --> name and type
      $("[for=file]").html(this.files[0].name);
      //code to distinguish image or video type file
      var size = this.files[0].size;
      //image type file
      $("#img").attr("src", URL.createObjectURL(this.files[0]));
    })
  })
</script>

</html>
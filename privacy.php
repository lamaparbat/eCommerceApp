<?php
include 'connection.php';
$count = $cart_no = 0;
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
}

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);



//footer data
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
  <script src="https://use.fontawesome.com/b491cd4834.js"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" type="text/css" href="responsive.css">
  <style>
    /*loader*/
    #loader {
      height: 100vh;
      width: 100%;
      background-image: url('img/Spin-1s-200px.gif');
      background-repeat: no-repeat;
      background-position: center;
      position: fixed;
      background-color: white;
      z-index: 99999;
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
      <form class="form-inline mt-1">
        <!-- dropdown -->
        <a class="nav-link dropdown-toggle mr-2 text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style=""><img src="" height="20px" width="25px" style="margin-top: -3px;" id="lang"><span id="title">&nbsp$ USD / EN</span></a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="left: auto;">
          <a class="dropdown-item" href="#" id="US"><img src="img/us.jpeg" id="US" height="20px" width="25px"><span>&nbsp$ USD / EN</span></a>
          <a class="dropdown-item" href="#" id="UK"><img src="img/uk.png" height="25px" width="25px"><span> &nbsp$ UK / EN</span></a>
          <a class="dropdown-item" href="#" id="AUS"><img src="img/aus.png" height="25px" width="25px"><span> &nbsp$ AUS / EN</span></a>
          <!-- <div class="dropdown-divider"></div> -->
          <a class="dropdown-item" href="#" id="INDIA"><img src="img/india.png" height="25px" width="25px"><span>&nbsp$ IND / EN</span></a>
        </div>

        <select class="bg-light text-dark border-0" id="username" style="font-style:14px;">
          <option><b><?php echo $user_name; ?>'s Account</b></option>
          <option>
            <p id="profile">Profile</p>
          </option>
          <option>
            <p id="myorder">My Order</p>
          </option>
          <option>
            <p id="logout">Logout</p>
          </option>
        </select>&nbsp&nbsp&nbsp
        <a class="pr-4 text-dark" href="login.php" id="signin" style="text-decoration: none;font-weight:ligher;"><i class="fa fa-user-o" style="font-size: 22px;"></i></a><br>
      </form>
      <!-- cart button -->
      <button class="btn pt-0 pb-0 pr-3 pl-2 mr-2 mt-1 text-dark" id="cart" onclick="cart(<?php echo $cart_no; ?>)"><img class="mr-4" src="img/shopping-bag.png" height="22px" width="22px" style="cursor: pointer; margin-top: -5px;" onclick="cart(<?php echo $cart_no; ?>)"><span style="margin-left: -20px;position: relative;top: 5px;"><?php echo $cart_no; ?></span><input type="hidden" value="<?php echo $cart_no; ?>" id="cart_count"></button>
      <i class="fa fa-heart-o mt-1 mr-5" onclick="wishlistBtn()" style="font-size: 24px;cursor: pointer;">
        <font style="margin-left:1px;margin-top: 20px; font-size: 16px;"><?php echo $wishlist_count; ?></font>
      </i>
      <img class="mr-3" src="img/search.png" width="23px" height="23px" onclick="appearSeachbar()" style="margin-left: -26px;cursor: pointer;" id="topSearchIcon">
    </div>
  </nav><br><br>

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

  <!-- searching result -->
  <div class="container pt-5" id="search_result">
    <h5></h5>
    <div class="row p-5">
      <div class="card-columns"></div>
    </div>
  </div>

  <!-- loader -->
  <div id="loader"></div>

  <div class="container policy pt-5 pb-5 pl-2">
    <div class="row">
      <div class="col-md-12">
        Privacy Policy
        <h1>Privacy Policy for Aroma Tazeen Collections</h1>
        <p>At aroma tazeen, accessible from aromatazeen.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by aroma tazeen and how we use it.</p>
        <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>
        <p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in aroma tazeen. This policy is not applicable to any information collected offline or via channels other than this website. Our Privacy Policy was created with the help of the <a href="https://www.privacypolicygenerator.org/">Free Privacy Policy Generator</a>.</p>
        <h2>Consent</h2>
        <p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>
        <h2>Information we collect</h2>
        <p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>
        <p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>
        <p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>
        <h2>How we use your information</h2>
        <p>We use the information we collect in various ways, including to:</p>
        <ul>
          <li>Provide, operate, and maintain our website</li>
          <li>Improve, personalize, and expand our website</li>
          <li>Understand and analyze how you use our website</li>
          <li>Develop new products, services, features, and functionality</li>
          <li>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</li>
          <li>Send you emails</li>
          <li>Find and prevent fraud</li>
        </ul>
        <h2>Log Files</h2>
        <p>aroma tazeen follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information.</p>
        <h2>Advertising Partners Privacy Policies</h2>
        <P>You may consult this list to find the Privacy Policy for each of the advertising partners of aroma tazeen.</p>
        <p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on aroma tazeen, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>
        <p>Note that aroma tazeen has no access to or control over these cookies that are used by third-party advertisers.</p>
        <h2>Third Party Privacy Policies</h2>
        <p>aroma tazeen's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. </p>
        <p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites.</p>
        <h2>CCPA Privacy Rights (Do Not Sell My Personal Information)</h2>
        <p>Under the CCPA, among other rights, California consumers have the right to:</p>
        <p>Request that a business that collects a consumer's personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p>
        <p>Request that a business delete any personal data about the consumer that a business has collected.</p>
        <p>Request that a business that sells a consumer's personal data, not sell the consumer's personal data.</p>
        <p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>
        <h2>GDPR Data Protection Rights</h2>
        <p>We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p>
        <p>The right to access – You have the right to request copies of your personal data. We may charge you a small fee for this service.</p>
        <p>The right to rectification – You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p>
        <p>The right to erasure – You have the right to request that we erase your personal data, under certain conditions.</p>
        <p>The right to restrict processing – You have the right to request that we restrict the processing of your personal data, under certain conditions.</p>
        <p>The right to object to processing – You have the right to object to our processing of your personal data, under certain conditions.</p>
        <p>The right to data portability – You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p>
        <p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>
        <h2>Children's Information</h2>
        <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>
        <p>aroma tazeen does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>


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
</script>

</html>
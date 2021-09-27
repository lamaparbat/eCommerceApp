<?php
include 'connection.php';
//check whether customer already login or not
session_start();
$username = $user_name = "";
$cart_no = 0;
if (strlen(isset($_SESSION['email'])) != 0 && strlen(isset($_SESSION['password'])) != 0) {
  $uemail = $_SESSION["email"];
  $select_query0 = "SELECT * FROM customer WHERE email = '$uemail'";
  $fire1 = mysqli_query($con, $select_query0) or die(mysqli_error($con));
  while ($row = mysqli_fetch_assoc($fire1)) {
    $username = $row["uname"];
    $customer_id = $row["id"];
    $comment_email = $row["email"];
  }
  $user_name = substr($username, 0, strpos($username, " "));
  if (strlen($user_name) == 0) {
    $user_name = $username;
  }
}
if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
}

//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);

// get the selected product pid from session variable
$id = $_SESSION["pid"];

//get the id of selected product from search bar
if (isset($_POST["getPid"])) {
  $pid = $_POST["pid"];
  $_SESSION["pid"] = $pid;
  echo "<script>location.assign('selected_product.php')</script>";
}

//count the number of comment of comment dbase and update into store dbase
$query = "SELECT * FROM comment";
$fire = mysqli_query($con, $query) or die(mysqli_error($con));
$comment_no = mysqli_num_rows($fire);
// <-- update comment on store .php
$update_query = "UPDATE store SET comments='$comment_no' WHERE pid ='$id'";
mysqli_query($con, $update_query) or die(mysqli_error($con));


$select_query = "SELECT * FROM store WHERE pid='$id'";
$fire = mysqli_query($con, $select_query) or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($fire)) {
  $pid = $row["pid"];
  $pname = $row["pname"];
  $pprice = $row["pprice"];
  $likes = $row["likes"];
  $comments = $row["comments"];
  $img = $row["img"];
  $size = $row["size"];
  $ctype = $row["collectiontype"];
}
//extract the images into array
$img_arr = explode("+", $img);

//get the add to card value from session
if (isset($_POST["addCart"])) {
  $pid = $_POST["id"];
  $quantity = $_POST["quantity"];
  $size = $_POST["size"];
  $_SESSION["cart"][0] = 0;
  $_SESSION["quantity"][0] = 0;
  $_SESSION["size"][0] = 0;
  // count the number element in session array cart and increase it by 1
  $count1 = $cart_no = count($_SESSION["cart"]);
  $count1 += 1;

  // store the pid & quantity in session array
  $_SESSION["cart"][$count1] = $pid;
  $_SESSION["quantity"][$count1] = $quantity;
  $_SESSION["size"][$count1] = $size;
  echo "<script>location.assign('selected_product.php')</script>";
}

// customer message/comment
if (isset($_POST["send_comment"])) {
  $comment = $_POST["cmessage"];
  $date = date("D/M/Y");
  if ($customer_id == "") {
    echo "<script>alert('please login to comment!')</script>";
    echo "<script>location.assign('login.php')</script>";
  } else {
    $insert_query = "INSERT INTO comment(pid, cid, comment,date) VALUES('$id','$customer_id','$comment','$date')";
    mysqli_query($con, $insert_query) or die(mysqli_error($con));
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
  <!-- font awesome -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://use.fontawesome.com/b491cd4834.js"></script>
  <!--owl-carousel-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
      box-shadow:-1px -2px 5px 0px rgba(125, 125, 125, 0.73);
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

    #color {
      margin-top: -10px;
      height: 25px;
      width: 25px;
      border: 2px solid #333;
      border-radius: 50%;
    }

    #color:hover {
      cursor: pointer;
    }

    #size {
      margin-top: -10px;
      height: 25px;
      width: 30px;
      border: 2px solid #333;
      border-radius: 50%;
    }

    #size:hover {
      cursor: pointer;
    }

    .store .row .col-md-2 img:hover {
      cursor: pointer;
    }

    .store .row .col-md-2 img {
      height: 30%;
      width: 60%;
    }

    @media(max-width:1100px) {
      .store .row .col-md-2 img {
        width: 100%;
      }
    }

    @media (min-height: 1366px) and (min-width: 1024px) {
      .navbar #nav-search {
        display: none;
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
  <div class="container mt-5 store"><br />
    <!-- Display Buy product -->
    <div class="row pt-2 pl-3 pr-2">
      <!--default sub images1-->
      <div class="col-md-2 pr-3 pl-3 pb-4 pt-0 " id="subimage1">
        <img class="d-block ml-auto mb-1" src="./quantam-lite/upload/<?php echo $img_arr[0]; ?>" onclick="nextLook (event,'<?php echo $img_arr[0]; ?>')" id="img1">
        <img class="d-block ml-auto mb-1" src="./quantam-lite/upload/<?php echo $img_arr[1]; ?>" onclick="nextLook(event,'<?php echo $img_arr[1]; ?>')" id="img2">
        <img class="d-block ml-auto mb-1" src="./quantam-lite/upload/<?php echo $img_arr[2]; ?>" onclick="nextLook(event,'<?php echo $img_arr[2]; ?>')" id="img3">
      </div>
      <!--default sub images2-->
      <div class="col-md-2 pr-3 pl-3 pb-4 pt-0 " id="subimage2">
        <img class="d-block ml-auto mb-1" src="" onclick="" id="img1">
        <img class="d-block ml-auto mb-1" src="" onclick="" id="img2">
        <img class="d-block ml-auto mb-1" src="" onclick="" id="img3">
      </div>

      <div class="col-md-6 pb-5 bg-white">
        <div class="row">
          <div class="col-md-6">
            <img src="./quantam-lite/upload/<?php echo $img_arr[0]; ?>" style="height:100%;width:100%">
          </div>
          <div class="col-md-6 pt-2">
            <h4><?php echo $pname; ?></h4>
            <h6>Brand: <span class="text-info">House OF Versace</span></h6>
            <span><i class="fa fa-thumbs-o-up"></i>&nbsp<?php echo $likes; ?><i class="fa fa-comment-o ml-3"></i>&nbsp<?php echo $comment_no; ?></span><br>
            <h5 class="mt-3 text-danger">$USD <?php echo $pprice; ?></h5>
            <hr><br>
            <!--color-->
            <p>Color</p>
            <div class="d-flex text-center">
              <?php
              $query = "SELECT * FROM store WHERE pname='$pname'";
              $fire = mysqli_query($con, $query) or die(mysqli_error($con));
              while ($row = mysqli_fetch_assoc($fire)) {
                $img_arr = explode("+", $row["img"]);
              ?>
                <div id="color" style="background-color:<?php echo $row["color"]; ?>;" onclick="shuffleImage('<?php echo $img_arr[0]; ?>','<?php echo $img_arr[1]; ?>','<?php echo $img_arr[2]; ?>')"></div>&nbsp&nbsp
              <?php } ?>
            </div>
            <!--size-->
            <p>Size</p>
            <div class="d-flex text-center mb-2">
              <?php
              $size_arr = explode("+", $size);
              $len = count($size_arr);
              for ($i = 0; $i < $len; $i++) {
                if ($size_arr[$i] != "") {
              ?>
                  <div id="size" class="<?php echo $size_arr[$i]; ?> pb-4" onclick="getSize('<?php echo $size_arr[$i]; ?>')"><?php echo $size_arr[$i]; ?></div>&nbsp&nbsp&nbsp&nbsp
              <?php }
              } ?>
            </div>
            <span>Quantity</span> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <button class="btn btn-light" onclick="plus()">+</button>&nbsp&nbsp&nbsp&nbsp <span id="quantity">1</span> &nbsp&nbsp&nbsp&nbsp<button class="btn btn-light" onclick="minus()">-</button><br><br>
            <form method="post">
              <input type="hidden" name="quantity" id="quantity_val" value="">
              <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
              <input type="hidden" name="size" value="" id="psize">
              </center><input class="btn btn-dark text-white rounded-0" type="submit" name="addCart" value="Add to Cart" onclick="send_data()" style="width:200px">
            </form>
          </div>
        </div>
      </div>
      <!-- product delivery details -->
      <div class="col-md-4" style="background-color: #EEEEEE;"><br>
        <h6><b>Delivery Options</b><a href="#">&nbsp&nbsp Change</a></h6>
        <p class="text-secondary"><span><i class="fa fa-map-marker" aria-hidden="true" style="font-size: 20px;"></i></span>&nbsp&nbsp Bagmati, Kathmandu Metro 22 - Newroad Area, Newroad &nbsp&nbsp</p>
        <hr>
        <h6><b>Return & Warranty</b></h6>
        <p style="color: #575757;"><span><i class="fa fa-truck" aria-hidden="true" style="font-size: 20px;"></i></span>&nbsp&nbsp 7 Days Return &nbsp&nbsp
        <p style="font-size: 14px;margin-top: -20px;margin-left: 30px;color: #949494;">change of mind is not applicable</p>
        </p>
        <p style="color: #575757;"><span><i class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size: 20px;"></i></span>&nbsp&nbsp Warranty not available &nbsp&nbsp
        <p style="font-size: 14px;margin-top: -20px;margin-left: 30px;color: #949494;">change of mind is not applicable</p>
        </p>
        <hr>
      </div>
    </div>
  </div><br><br><br>

  <!-- Related Products -->
  <div class="container" id="relatedProduct">
    <h4>Related Product</h4>
    <div class="row">
      <div class="col-md-12 p-3">
        <!-- card-slider -->
        <!--card slider-->
        <div class="owl-carousel owl-theme">
          <?php
          $select = "SELECT * FROM store WHERE collectionType ='$ctype'";
          $fire = mysqli_query($con, $select) or die(mysqli_error($con));
          while ($row = mysqli_fetch_assoc($fire)) {
            //extract the images into array
            $img_arr = explode("+", $row["img"]);
          ?>
            <div class="item" onclick="sendSelectedProductId(<?php echo $row["pid"] ?>)">
              <img src="./quantam-lite/upload/<?php echo $img_arr[0]; ?>">
              <center>
                <h6 class="text-dark" style="margin-top:5px;padding-bottom:7px; font-size:15px; "><?php echo $row["pname"]; ?></h6>
                <p class="text-dark" style="margin-top:-15px;"><s class="text-danger">$<?php echo $row["pprice"]; ?></s>&nbsp $<?php echo $row["discount"]; ?></p>
              </center>
            </div>
          <?php } ?>
        </div>
        <!--/end of card slider-->
        <!-- /end of card-slider -->
      </div>
    </div>
  </div>
  <!-- /end of Related Products -->

  <br><br><br><br><br>
  <!-- rating reviews -->
  <div class="container rating_reviews">
    <!-- product description -->
    <div class="row product_description">
      <div class="col-md-8 bg-white p-3">
        <h5 class="">Product details of <?php echo $pname ?></h5>
        <div class="row pt-2 text-secondary">
          <div class="col-md-6">
            <h6>Full Description</h6>
          </div>
          <div class="col-md-6">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, Duis aute irure dolor in reprehenderit in voluptate velit esse
              cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>
      </div>
    </div><br><br>
    <!-- /end of product specification -->
    <!-- Product Commentry  -->
    <div class="row product_commentry">
      <div class="col-md-8 bg-white p-3">
        <h5>Any question regarding <?php echo $pname ?></h5>
        <hr>
        <form class="form" method="post">
          <textarea class="form-control" type="text" name="cmessage" placeholder="Enter your message: " style="height: 100px;"></textarea><br>
          <input class="btn btn-dark " type="submit" name="send_comment" value="Send Comment">
        </form>
      </div>
    </div><br>
    <!-- /end of Product Commentry  -->
    <!-- Product comments  -->
    <div class="row product_commentry">
      <div class="col-md-8 bg-white p-3">
        <h5>Comments</h5>
        <hr>
        <ul class="d-inline" style="list-style: none;">
          <!-- user comments -->
          <?php
          $query = "SELECT * FROM comment WHERE pid='$id'";
          $fire = mysqli_query($con, $query) or die(mysqli_error($con));
          while ($row = mysqli_fetch_assoc($fire)) {
            $comment_id = $row["id"];
            $cid = $row["cid"];
            $comment = $row["comment"];
            $likes = $row["likes"];

            //get the user image and name from customer database
            $query1 = "SELECT * FROM customer WHERE id='$cid'";
            $fire1 = mysqli_query($con, $query1) or die(mysqli_error($con));
            while ($row = mysqli_fetch_assoc($fire1)) {
              $src = $row["img"];
              $customer_name = $row["uname"];
              $customer_email = $row["email"];
            }

          ?>
            <li>
              <img src="./quantam-lite/upload/<?php echo $src; ?>" height="50px" width="50px" class="rounded-circle"><span><b>&nbsp&nbsp&nbsp&nbsp <?php echo $customer_name; ?></b></span><br>
              <p style="margin-left: 65px;margin-top: -15px;"><?php echo $comment; ?><br>
                <i class="fa fa-thumbs-o-up mt-2" aria-hidden="true" style="font-size: 20px;cursor: pointer;" onclick="comment_like(<?php echo $comment_id; ?>)"><?php echo $likes; ?></i>
                &nbsp&nbsp&nbsp&nbsp<a href="#" class="text-dark">Reply</a>
              </p>
            </li>
            <hr><br>
          <?php } ?>
          <!-- /end of user comments -->

        </ul>
      </div>
    </div>
    <!-- /end of Product comments  -->

  </div><br><br>
  <!-- /end of main container -->

  <!-- send selected product id -->
  <form method="post" action="index.php" id="selected_product_id">
    <input type="hidden" name="pid" id="pid">
    <input type="submit" name="getPid" id="send" class="d-none">
  </form>


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
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="/quantam-lite/assets/plugins/jquery/dist/jquery.min.js"></script>
<script src="/quantam-lite/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
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
  // quanty adjuster
  function plus() {
    var val = $("#quantity").text();
    if (val >= 5) {
      $("#quantity").text(5);
    } else {
      val++;
      $("#quantity").text(val);
    }
  }

  function minus() {
    var val = $("#quantity").text();
    if (val > 0) {
      val--;
      $("#quantity").text(val)
    }
  }

  // store quantity value to session
  function send_data() {
    var val = $("#quantity").text();
    $("#quantity_val").attr("value", val);
  }

  // auto click the comment_like_btn
  function comment_like(comment_id) {
    $.ajax({
      url: "comment_like_update.php",
      method: "post",
      data: {
        data: true,
        comment_id
      },
      success: function(result) {
        location.assign("selected_product.php");
      }
    })
  }

  // change the next look of selected product
  function nextLook(event, src) {
    console.log(src)
    $(".store .row .col-md-6 img").attr("src", "./quantam-lite/upload/" + src)
    if (event.target.id == "img1") {
      $(".store .row .col-md-2 #img1").css("border", "2px solid #ff6675")
      $(".store .row .col-md-2 #img2").css("border", "none")
      $(".store .row .col-md-2 #img3").css("border", "none")
    } else if (event.target.id == "img2") {
      $(".store .row .col-md-2 #img2").css("border", "2px solid #ff6675")
      $(".store .row .col-md-2 #img1").css("border", "none")
      $(".store .row .col-md-2 #img3").css("border", "none")
    } else {
      $(".store .row .col-md-2 #img3").css("border", "2px solid #ff6675")
      $(".store .row .col-md-2 #img1").css("border", "none")
      $(".store .row .col-md-2 #img2").css("border", "none")
    }
  }

  // shuffling selected image based on color
  $("#subimage1").css("display", "block")
  $("#subimage2").css("display", "none")

  function shuffleImage(img1, img2, img3) {
    // empty the src attr
    $(".store .row .col-md-2 #img1").attr("src", "")
    $(".store .row .col-md-2 #img2").attr("src", "")
    $(".store .row .col-md-2 #img3").attr("src", "")

    // empty the onclick attr
    $(".store .row .col-md-2 #img1").attr("onclick", "")
    $(".store .row .col-md-2 #img2").attr("onclick", "")
    $(".store .row .col-md-2 #img3").attr("onclick", "")

    //fill the new src value
    var src1 = "./quantam-lite/upload/" + img1
    var src2 = "./quantam-lite/upload/" + img2
    var src3 = "./quantam-lite/upload/" + img3

    $(".store .row .col-md-2 #img1").attr("src", src1)
    $(".store .row .col-md-2 #img2").attr("src", src2)
    $(".store .row .col-md-2 #img3").attr("src", src3)

    // fill the onclick attr
    $(".store .row .col-md-2 #img1").attr("onclick", "nextLook(event,'" + img1 + "')")
    $(".store .row .col-md-2 #img2").attr("onclick", "nextLook(event,'" + img2 + "')")
    $(".store .row .col-md-2 #img3").attr("onclick", "nextLook(event,'" + img3 + "')")

    $("#subimage1").css("display", "none")
    $("#subimage2").css("display", "block")

    //arranging images
    arrangeSubImage();
  }

  // subimages arranging
  function arrangeSubImage() {
    var img1 = $(".store .row .col-md-2 #img1").attr("src").length
    var img2 = $(".store .row .col-md-2 #img2").attr("src").length
    var img3 = $(".store .row .col-md-2 #img3").attr("src").length
    if (img1 > 27) {
      $(".store .row .col-md-2 #img1").css("visibility", "visible")
    } else {
      $(".store .row .col-md-2 #img1").css("visibility", "hidden")
    }
    if (img2 > 27) {
      $(".store .row .col-md-2 #img2").css("visibility", "visible")
    } else {
      $(".store .row .col-md-2 #img2").css("visibility", "hidden")
    }
    if (img3 > 27) {
      $(".store .row .col-md-2 #img3").css("visibility", "visible")
    } else {
      $(".store .row .col-md-2 #img3").css("visibility", "hidden")
    }

  }
  arrangeSubImage()

  //size handling 
  function getSize(size) {
    var cls = "." + size
    var bg = $("" + cls + "").css("background-color")
    if (bg == "rgb(255, 0, 0)") {
      $("" + cls + "").css("background-color", "white")
      $("" + cls + "").css("color", "black")
      $("#psize").attr("value", size);
    } else {
      $("" + cls + "").css("background-color", "red")
      $("" + cls + "").css("color", "white")
    }
    var val = $("#psize").attr("value")
  }
  //owl carousel
  $('.owl-carousel').owlCarousel({
    loop: false,
    margin: 10,
    nav: false,
    responsive: {
      0: {
        items: 2
      },
      600: {
        items: 3
      },
      1000: {
        items: 6
      }
    }
  })

  function sendSelectedProductId(id) {
    $("#selected_product_id #pid").val(id)
    $("#selected_product_id #send").click()
  }
</script>

</html>
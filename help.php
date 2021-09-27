<?php
include 'connection.php';

//check whether customer already login or not
session_start();
$username = $user_name =  "";
if (isset($_SESSION["email"]) && isset($_SESSION["password"])) {
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

// get the total add cart count number
if (isset($_SESSION["cart"]) != 0) {
  $cart_no = count($_SESSION["cart"]) - 1;
} else {
  $cart_no = 0;
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
</head>
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

  @media(max-width: 990px) {
    .navbar .navbar-collapse form #username {
      margin-top: 0px;
    }
  }

  @media(max-width: 1100px) {
    .help .row .col-md-2 h6 {
      padding: 0;
      position: absolute;
      visibility: hidden;
    }

    .help .row .col-md-10 {
      padding-top: 0px;
    }
  }
</style>

<body onload="loader()">
  <!-- navbar -->
  <?php include 'navbar.php'; ?><br /><br />

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
  <div class="container help">
    <div class="row">
      <!-- help navigation -->
      <div class="col-md-2">
        <h6 class="pt-3"><a href="#shipping" class="text-dark">Shipping & Delivery</a></h5>
          <h6 class="pt-3"><a href="#return" class="text-dark"> Return & Exchange Policy</a></h5>
            <h6 class="pt-3"><a href="#payment" class="text-dark"> Payment Methods</a></h5>
              <h6 class="pt-3"><a href="#faq" class="text-dark"> FAQ</a></h5>
                <h6 class="pt-3"><a href="#size" class="text-dark"> Size Guide</a></h5>
                  <h6 class="pt-3"><a href="#footer" class="text-dark"> More Information. Contact Us?</a></h5>
      </div>
      <!-- help content -->
      <div class="col-md-10">
        <!-- shipping and delivery -->
        <div class="card" id="shipping">
          <div class="card-body">
            <h4 class="card-title">Shipping and Delivery</h4>
            <p class="card-text">Normall the orders are shipped with 2-3 days and deliver is expected upto 5 days depend n a country. However we will respong shipping and deliver time within a day.</p>
          </div>
        </div>
        <!-- Return & Exchange Policy -->
        <div class="card" id="return">
          <div class="card-body">
            <h4 class="card-title">Return & Exchange Policy</h4>
            <p class="card-text">We at AromaTazeen appreciate our valued customers. However, the client when placing the order agrees to abide by the rules mentioned within this policy & the general policies of ‘Aroma Tazeen’ when placing their order. The brand accepts no liability for clients when in violation of any of the regulations within this policy.</p>
            <center>
              <h5>We strictly follow the "NO Refund" policy</h5>
            </center>
            <ul class="">
              <li>We only allow returns of defective or wrong sized items booked online, subject to conditions, provided the items are in original condition i.e., unwashed, new, unworn, unaltered, and with original tags and packaging.</li>
              <li>For eligible returns, customers should contact our customer support by email, phone call, SMS or WhatsApp. To be able to make a return, customers will need to provide the online order ID and images showing the nature of the defect within 48 hours of the delivery. Depending on the circumstances, the matter will be resolved as swiftly as possible by replacing the defective items with an exchange.</li>
              <li>Items bought on sale cannot be exchanged.</li>
              <li>The Company reserves the right to accept or deny the exchange request.</li>
              <li>This exchange policy does not apply to orders to be shipped outside Pakistan.</li>
              <li>Any shipping charges associated with the exchange will have to be borne by the customers.</li>
              <li>If there is no product available for exchange, a coupon of the credit amount will be given to the customer, after deducting the charges for courier and COD handling. That coupon can be used within three months to shop at aromatazeen.com (Applies only to orders within Pakistan)*</li>
              <li>We accept no cancellation of online orders that are customized.</li>
              <li>We don’t accept the cancellation of online orders that are urgent.</li>
            </ul>
          </div>
        </div>
        <!-- payment -->
        <div class="card" id="payment">
          <div class="card-body">
            <h4 class="card-title">Payment Methods</h4>
            <p class="card-text">COD (Cash on Delivery) and Payment with Cards and PayPal are the main mthods of payment.Cash on Deliver is only available in United Arab Emirates and Pakistan</p>
          </div>
        </div>
        <!-- faq -->
        <div class="card" id="faq">
          <div class="card-body">
            <h4 class="card-title">FAQ</h4>
            <h6 class="card-title pt-3">HOW DO I MAKE A PURCHASE?</h6>
            <p class="card-title">Shopping at Aroma Tazeen is simple and easy:</p>
            <p>Use the CLOTHING, WHAT'S NEW and FEATURES links.
              • Once you have found an item, choose your size and click on the ‘ADD TO BAG’ button on the product page. Review the items in your shopping bag by clicking the ‘MY BAG’ link at the top of the page.Click on ‘CHECKOUT’ to complete your order.</p>
            <h6 class="pt-3">DO I NEED TO SET UP AN ACCOUNT TO PLACE AN ORDER?</h6>
            <p>You can shop at Aroma Tazeen without creating an account. However, register with us and you’ll be able to enjoy the following benefits: Track your order and review past purchases.Save your address and card details so you can shop even quicker next time</p>
            <h6>HOW WILL I KNOW IF ORDER IS PLACED SUCCESSFULLY?</h6>
            <p>Once your order is successfully placed, you will receive a confirmation call, an email and a text message from www.aromatazeen.com. The email will have all the details related to your order. Order details can also be viewed at My Account -> My Orders if you have placed the order on your own online.</p>
            <h6>I TRIED PLACING MY ORDER USING MY DEBIT CARD/CREDIT CARD/NET BANKING BUT THE ORDER WAS NOT SUCCESSFUL. WHAT HAPPENS TO THE MONEY DEDUCTED FROM THE CARD?</h6>
            <p>Please check your bank/credit card account to ensure if your account has been debited. If your account has been debited after a payment failure, it is normally rolled back by banks within 7 business days. The time taken can vary from bank to bank and unfortunately, we won't be able to expedite this. Please check with your bank for more details.
              If your bank informs you please get back to us. If the money has been credited to our account, we would initiate a refund within 3 days of your request. The receipt of the refund would, however, depend on the mode of payment mode chosen by you. The expected timelines are as below:</p>
            <ul class="pl-5">
              <li>Net Banking 2-4 business days</li>
              <li>Debit Card 5-7 business days</li>
              <li>Credit Card 7-21 business days</li>
            </ul>
            <h6>CAN I PLACE A BULK ORDER FOR AN ITEM(S)?</h6>
            <p>To place a bulk order please drop a mail to info@aromatazeen.com with your requirements and the concerned team would get back to you</p>
            <h6>WHICH COUNTRIES DOES AROMA TAZEEN SHIP TO?</h6>
            <p>AROMA TAZEEN ships worldwide.</p>
            <h6>HOW DO I CHECK THE STATUS OF MY ORDER?</h6>
            <p>Your order status is updated to you via emails and text message at every step. Once your order is placed you would receive an email with your order details. Again, after your order is dispatched we will send you an SMS with your tracking details. Please check your spam and old SMS- for the status of your order, if you don't see any updates. In case of any unforeseen events which delay your order, you would receive a special update from our end.</p>
            <h6>HOW LONG DOES DELIVERY TAKE?</h6>
            <p>Orders are delivered within 3-5 working days from the date you place your order.Please note, during the holiday season, processing and shipping may take longer than 3-5 working days.</p>
            <h6>HOW MUCH DUTIES AND TAXES WILL I HAVE TO PAY?</h6>
            <p>Shipping charges do not include the applicable import duties or taxes that are due upon entry into the destination country.All duties and taxes are the responsibility of the customer and must be paid at the time of delivery.Please contact your local customs office for more information</p>
            <h6>I AM PLACING AN ORDER AS A GIFT TO MY LOVED ONE. WILL HE/SHE RECEIVE THE PRICE TAGS AND INVOICE?</h6>
            <p>Yes. Because of the prevalent regulations, we send the invoice along with the product. Tags are also left intact so that a product can be returned if your loved one faces any problem with it.</p>
            <h6>DO YOU ALLOW EXCHANGES?</h6>
            <p>Please read up our Exchange Policy for details.</p>
            <h6>CAN I CHANGE OR AMEND MY ORDER ONCE IT HAS BEEN PLACED?</h6>
            <p>We are unable to combine orders or add pieces to an existing order once it has been placed.We are unable to change the size and billing address once an order has been placed.</p>
            <h6>DOES AROMA TAZEEN SHIP TO MULTIPLE ADDRESSES?</h6>
            <p>We are only able to deliver to one address per order. If you would like to send your purchases to multiple addresses, we suggest that you place a separate order for each destination.</p>
          </div>
        </div>
        <!-- size guide -->
        <div class="card" id="size">
          <div class="card-body">
            <h4 class="card-ti  tle">Size Guide</h4><br>
            <img src="img/size.png" class="img-fluid">
          </div>
        </div>
        <!-- end of card details -->
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
        <h5>Fashioner</h5>
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
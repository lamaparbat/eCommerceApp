<?php
include 'connection.php';
$cart_no =  $count = 0;
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

//get the size of array count -> total number of add to cart product
if (!empty($_SESSION["cart"])) {
  $cart_no = count($_SESSION["cart"]) - 1;
}
//count the number of wishlist product
$wishlist_query = mysqli_query($con, "SELECT * FROM wishlist") or die(mysqli_error($con));
$wishlist_count = mysqli_num_rows($wishlist_query);


//footer sata
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

    .navbar #nav-search {
      display: block;
    }

    .navbar #cart1 {
      visibility: hidden;
      position: absolute;
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

    @media (min-height: 1366px) and (min-width: 1024px) {
      .navbar #nav-search {
        display: none;
      }
    }

    @media(max-width: 990px) {
      .navbar #cart1 {
        visibility: visible;
        position: static;
      }

      .navbar #cart {
        display: none;
      }

      .navbar #nav-search {
        display: none;
      }

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

  <div class="container policy mt-4 pt-5 pb-5 pl-2">
    <div class="row">
      <div class="col-md-12">
        <h2><strong>Terms and Conditions</strong></h2>
        <p>Welcome to aroma tazeen!</p>
        <p>These terms and conditions outline the rules and regulations for the use of Aroma Tazeen's Website, located at aromatazeen.com.</p>
        <p>By accessing this website we assume you accept these terms and conditions. Do not continue to use aroma tazeen if you do not agree to take all of the terms and conditions stated on this page.</p>
        <p>The following terminology applies to these Terms and Conditions, Privacy Statement and Disclaimer Notice and all Agreements: "Client", "You" and "Your" refers to you, the person log on this website and compliant to the Company’s terms and conditions. "The Company", "Ourselves", "We", "Our" and "Us", refers to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake the process of our assistance to the Client in the most appropriate manner for the express purpose of meeting the Client’s needs in respect of provision of the Company’s stated services, in accordance with and subject to, prevailing law of Netherlands. Any use of the above terminology or other words in the singular, plural, capitalization and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>
        <h3><strong>Cookies</strong></h3>
        <p>We employ the use of cookies. By accessing aroma tazeen, you agreed to use cookies in agreement with the Aroma Tazeen's Privacy Policy. </p>
        <p>Most interactive websites use cookies to let us retrieve the user’s details for each visit. Cookies are used by our website to enable the functionality of certain areas to make it easier for people visiting our website. Some of our affiliate/advertising partners may also use cookies.</p>
        <h3><strong>License</strong></h3>
        <p>Unless otherwise stated, Aroma Tazeen and/or its licensors own the intellectual property rights for all material on aroma tazeen. All intellectual property rights are reserved. You may access this from aroma tazeen for your own personal use subjected to restrictions set in these terms and conditions.</p>
        <p>You must not:</p>
        <ul>
          <li>Republish material from aroma tazeen</li>
          <li>Sell, rent or sub-license material from aroma tazeen</li>
          <li>Reproduce, duplicate or copy material from aroma tazeen</li>
          <li>Redistribute content from aroma tazeen</li>
        </ul>
        <p>This Agreement shall begin on the date hereof. Our Terms and Conditions were created with the help of the <a href="https://www.termsandconditionsgenerator.com">Terms And Conditions Generator</a> and the <a href="https://www.generateprivacypolicy.com">Privacy Policy Generator</a>.</p>
        <p>Parts of this website offer an opportunity for users to post and exchange opinions and information in certain areas of the website. Aroma Tazeen does not filter, edit, publish or review Comments prior to their presence on the website. Comments do not reflect the views and opinions of Aroma Tazeen,its agents and/or affiliates. Comments reflect the views and opinions of the person who post their views and opinions. To the extent permitted by applicable laws, Aroma Tazeen shall not be liable for the Comments or for any liability, damages or expenses caused and/or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this website.</p>
        <p>Aroma Tazeen reserves the right to monitor all Comments and to remove any Comments which can be considered inappropriate, offensive or causes breach of these Terms and Conditions.</p>
        <p>You warrant and represent that:</p>
        <ul>
          <li>You are entitled to post the Comments on our website and have all necessary licenses and consents to do so;</li>
          <li>The Comments do not invade any intellectual property right, including without limitation copyright, patent or trademark of any third party;</li>
          <li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material which is an invasion of privacy</li>
          <li>The Comments will not be used to solicit or promote business or custom or present commercial activities or unlawful activity.</li>
        </ul>
        <p>You hereby grant Aroma Tazeen a non-exclusive license to use, reproduce, edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats or media.</p>
        <h3><strong>Hyperlinking to our Content</strong></h3>
        <p>The following organizations may link to our Website without prior written approval:</p>
        <ul>
          <li>Government agencies;</li>
          <li>Search engines;</li>
          <li>News organizations;</li>
          <li>Online directory distributors may link to our Website in the same manner as they hyperlink to the Websites of other listed businesses; and</li>
          <li>System wide Accredited Businesses except soliciting non-profit organizations, charity shopping malls, and charity fundraising groups which may not hyperlink to our Web site.</li>
        </ul>
        <p>These organizations may link to our home page, to publications or to other Website information so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products and/or services; and (c) fits within the context of the linking party’s site.</p>
        <p>We may consider and approve other link requests from the following types of organizations:</p>
        <ul>
          <li>commonly-known consumer and/or business information sources;</li>
          <li>dot.com community sites;</li>
          <li>associations or other groups representing charities;</li>
          <li>online directory distributors;</li>
          <li>internet portals;</li>
          <li>accounting, law and consulting firms; and</li>
          <li>educational institutions and trade associations.</li>
        </ul>
        <p>We will approve link requests from these organizations if we decide that: (a) the link would not make us look unfavorably to ourselves or to our accredited businesses; (b) the organization does not have any negative records with us; (c) the benefit to us from the visibility of the hyperlink compensates the absence of Aroma Tazeen; and (d) the link is in the context of general resource information.</p>
        <p>These organizations may link to our home page so long as the link: (a) is not in any way deceptive; (b) does not falsely imply sponsorship, endorsement or approval of the linking party and its products or services; and (c) fits within the context of the linking party’s site.</p>
        <p>If you are one of the organizations listed in paragraph 2 above and are interested in linking to our website, you must inform us by sending an e-mail to Aroma Tazeen. Please include your name, your organization name, contact information as well as the URL of your site, a list of any URLs from which you intend to link to our Website, and a list of the URLs on our site to which you would like to link. Wait 2-3 weeks for a response.</p>
        <p>Approved organizations may hyperlink to our Website as follows:</p>
        <ul>
          <li>By use of our corporate name; or</li>
          <li>By use of the uniform resource locator being linked to; or</li>
          <li>By use of any other description of our Website being linked to that makes sense within the context and format of content on the linking party’s site.</li>
        </ul>

        <p>No use of Aroma Tazeen's logo or other artwork will be allowed for linking absent a trademark license agreement.</p>
        <h3><strong>iFrames</strong></h3>
        <p>Without prior approval and written permission, you may not create frames around our Webpages that alter in any way the visual presentation or appearance of our Website.</p>
        <h3><strong>Content Liability</strong></h3>
        <p>We shall not be hold responsible for any content that appears on your Website. You agree to protect and defend us against all claims that is rising on your Website. No link(s) should appear on any Website that may be interpreted as libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or other violation of, any third party rights.</p>
        <h3><strong>Your Privacy</strong></h3>
        <p>Please read Privacy Policy</p>
        <h3><strong>Reservation of Rights</strong></h3>
        <p>We reserve the right to request that you remove all links or any particular link to our Website. You approve to immediately remove all links to our Website upon request. We also reserve the right to amen these terms and conditions and it’s linking policy at any time. By continuously linking to our Website, you agree to be bound to and follow these linking terms and conditions.</p>
        <h3><strong>Removal of links from our website</strong></h3>
        <p>If you find any link on our Website that is offensive for any reason, you are free to contact and inform us any moment. We will consider requests to remove links but we are not obligated to or so or to respond to you directly.</p>
        <p>We do not ensure that the information on this website is correct, we do not warrant its completeness or accuracy; nor do we promise to ensure that the website remains available or that the material on the website is kept up to date.</p>
        <h3><strong>Disclaimer</strong></h3>
        <p>To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website. Nothing in this disclaimer will:</p>
        <ul>
          <li>limit or exclude our or your liability for death or personal injury;</li>
          <li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>
          <li>limit any of our or your liabilities in any way that is not permitted under applicable law; or</li>
          <li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>
        </ul>

        <p>The limitations and prohibitions of liability set in this Section and elsewhere in this disclaimer: (a) are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer, including liabilities arising in contract, in tort and for breach of statutory duty.</p>
        <p>As long as the website and the information and services on the website are provided free of charge, we will not be liable for any loss or damage of any nature.</p>

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
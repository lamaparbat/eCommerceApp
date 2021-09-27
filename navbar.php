<style>
   .sidenav {
      top: 0;
      height: 100vh;
      width: 100%;
      position: fixed;
      z-index: 444444;
      background-color: whitesmoke;
      overflow-y: scroll;
      display: none;
   }

   .navbar-toggler .navbar-toggler-icon {
      height: 25px;
      width: 25px;
      background-image: url("img/ham.png");
   }

   .sidenav::-webkit-scrollbar {
      display: none;
   }

   .sidenav h4 {
      margin-top: 8px;
      font-weight: bolder;
   }

   .sidenav .topNav #icons i {
      font-size: 23px;
      padding: 10px;
   }

   .sidenav .new .lists span {
      margin-top: 5px;
      margin-left: 10px;
   }

   .navbar .navbar-nav {
      display: flex;
   }

   @media only screen and (max-width: 1100px) {
      .sidenav {
         display: block;
      }

      .navbar .navbar-nav {
         display: none;
      }
   }
</style>
<nav class="navbar navbar-expand-lg fixed-top bg-white border-light navbar-light py-2 pl-5 pr-4 pt-1 pb-0">
   <a class="h3 mb-0 mr-5 text-bold text-dark" id="navbar-brand" href="index.php">Fashioner</a>
   <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" onclick="openSidebar()"></span>
   </button>
   <div class="collapse navbar-collapse pb-0" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item">
            <a class="nav-link py-0 text-dark" href="new.php" id="li_new">NEW<span class="sr-only">(current)</span></a>
         </li>
         <li class="nav-item">
            <a class="nav-link py-0 text-dark" href="trend.php" id="li_trend">TREND<span class="sr-only">(current)</span></a>
         </li>
         <li class="nav-item">
            <a class="nav-link py-0 text-dark" href="clothing.php" id="li_clothing">CLOTHING</a>
         </li>
         <li class="nav-item">
            <a class="nav-link py-0 text-dark" href="shoes.php" id="li_shoes">SHOES</a>
         </li>
         <li class="nav-item">
            <a class="nav-link py-0 text-dark" href="accessories.php" id="li_accessories">ACCESSORIES</a>
         </li>
         <li class="nav-item">
            <a class="nav-link py-0 text-dark" href="sale.php" id="li_sale">SALE</a>
         </li>
      </ul>
      <form class="form-inline mt-1" id="profileBtn">
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
      <i class="fa fa-heart-o mt-0 mr-5" id="wishlistBtn" onclick="wishlistBtn()" style="font-size: 24px;cursor: pointer;">
         <font style="margin-left:1px;margin-top: 20px; font-size: 16px;"><?php echo $wishlist_count; ?></font>
      </i>
      <img class="mr-3" src="img/search.png" width="23px" height="23px" onclick="appearSeachbar()" style="margin-left: -26px;cursor: pointer;" id="topSearchIcon">
   </div>
</nav><br />

<!-- side navigation bar -->
<div class="sidenav h-100">
   <!-- topnav -->
   <div class="topNav px-3 d-flex justify-content-between bg-white">
      <h4 onclick="homeBottomIcon()">Fashioner</h4>
      <div id="icons">
         <i class="fa fa-shopping-bag" onclick="cartBtn()"></i>
         <i class="fa fa-heart-o" onclick="wishlistBtn()"></i>
         <i class="fa fa-close" onclick="closeSidebar()"></i>
      </div>
   </div><br />
   <!-- new -->
   <div class="new d-flex justify-content-around">
      <div class="lists d-flex flex-column">
         <span class=""><u><b>New Products</b></u></span>
         <div class="d-flex mt-1">
            <span><a href="#">Dresses</a></span>
            <span><a href="#">Tops</a></span>
            <span><a href="#">Bottoms</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Swimwear</a></span>
            <span><a href="#">Accessories</a></span>
         </div>
      </div>
      <div class="lists d-flex flex-column"><br />
         <div class="d-flex mt-2">
            <span><a href="#">New Arrival</a></span>
            <span><a href="#">Loungewear</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Summer shop</a></span>
         </div>
      </div>
   </div><br />
   <!-- new -->
   <div class="new d-flex justify-content-around">
      <div class="lists d-flex flex-column">
         <span class=""><u><b>Clothing</b></u></span>
         <span>Tops</span>
         <div class="d-flex">
            <span><a href="#">Bodysuits</a></span>
            <span><a href="#">Shirt & Blouses</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Off The Shoulder Tops</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Hoodie + SweatShirts</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Sweaters + Cardigans</a></span>
         </div>
         <span>Coats & Jackets</span>
         <div class="d-flex">
            <span><a href="#">Blazers</a></span>
            <span><a href="#">Coats</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Denim Jackets</a></span>
            <span><a href="#">Fur Coats</a></span>
         </div>
      </div>
      <div class="lists d-flex flex-column"><br />
         <span class="mt-2">Bottom</span>
         <div class="d-flex mr-3">
            <span><a href="#">Shorts </a></span>
            <span><a href="#">Leggings</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Pants</a></span>
            <span><a href="#">Jeans</a></span>
         </div>
         <span>Skirts</span>
         <div class="d-flex">
            <span><a href="#">Mini Skirts</a></span>
            <span><a href="#">Midi Skirts</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Maxi Skirts</a></span>
         </div>
         <span>Swimsuits</span>
         <div class="d-flex">
            <span><a href="#">Bikinis</a></span>
            <span><a href="#">Cover ups</a></span>
         </div>
      </div>
   </div><br />
   <!-- new -->
   <div class="new d-flex justify-content-around">
      <div class="lists d-flex flex-column">
         <span class=""><u><b>Shoes</b></u></span>
         <div class="d-flex mt-1">
            <span><a href="#">Heels</a></span>
            <span><a href="#">Boots</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Flats</a></span>
            <span><a href="#">Sneakers</a></span>
         </div>
      </div>
      <div class="lists d-flex flex-column px-4"><br />
         <div class="d-flex mt-1 mx-3">
            <span><a href="#">Sandals</a></span>
            <span><a href="#">All Shoes</a></span>
         </div>
      </div>
   </div><br />
   <!-- new -->
   <div class="new d-flex justify-content-around">
      <div class="lists d-flex flex-column">
         <span><u><b>Accessories</b></u></span>
         <span>Bags</span>
         <div class="d-flex">
            <span><a href="#">Clutches</a></span>
            <span><a href="#">All Bags</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Cross Body Bags</a></span>
         </div>
         <div class="d-flex">
            <span><a class="text-dark" href="">Hair Ties & Bands</a></span>
         </div>
      </div>
      <div class="lists d-flex flex-column mt-1"><br />
         <span>Jwellery</span>
         <div class="d-flex">
            <span><a href="#">Necklace</a></span>
            <span><a href="#">Earring</a></span>
            <span><a href="#">Chokers</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Rings</a></span>
            <span><a href="#">Bracelets</a></span>
            <span><a href="#">All Jwellery</a></span>
         </div>
         <div class="d-flex">
            <span><a class="text-dark" href="">Sunglasses</a></span>
            <span><a class="text-dark" href="">Hats</a></span>
            <span><a class="text-dark" href="">Scarves</a></span>
         </div>
      </div>
   </div><br />
   <!-- new -->
   <div class="new d-flex justify-content-around">
      <div class="lists d-flex flex-column">
         <span class=""><u><b>Sale</b></u></span>
         <div class="d-flex mt-1">
            <span><a href="#">Dresses</a></span>
            <span><a href="#">Tops</a></span>
            <span><a href="#">Bottoms</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Swimwear</a></span>
            <span><a href="#">Accessories</a></span>
         </div>
      </div>
      <div class="lists d-flex flex-column"><br />
         <div class="d-flex mx-2 mt-2">
            <span><a href="#">New Arrival</a></span>
            <span><a href="#">Loungewear</a></span>
         </div>
         <div class="d-flex">
            <span><a href="#">Summer shop</a></span>
         </div>
      </div>
   </div><br />
</div>
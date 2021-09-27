<?php 
$con = mysqli_connect("localhost","root","","aroma");
//check whether customer already login or not
session_start();
$username = "";
if($_SESSION["aemail"] !="" && $_SESSION["apassword"] !=""){
  $uemail = $_SESSION["aemail"];
  $select_query0 = "SELECT * FROM admin WHERE email = '$uemail'";
  $fire1 = mysqli_query($con,$select_query0) or die(mysqli_error($con));
  while($row = mysqli_fetch_assoc($fire1)){
    $username = $row["uname"];
    $aimg = $row["img"];
  }
}

$pid = $pPrice = 1;
//various size get
$s1 = $s2 = $s3 = $s4 = $s5 = $size = $img1 = $img2 = $img3=  "";
$len = $discount = 0;
if(isset($_POST["upload"])){ 
  $cType = $_POST["cType"];
  $color = $_POST["color"];
  if(isset($_POST["s1"])){
		$s1 = $_POST["s1"];
	}
	if(isset($_POST["s2"])){
		$s2 = $_POST["s2"];
	}
	if(isset($_POST["s3"])){
		$s3 = $_POST["s3"];
	}
	if(isset($_POST["s4"])){
		$s4 = $_POST["s4"];
	}
	
	if(isset($_POST["s5"])){
		$s5 = $_POST["s5"];
	}
	$size = $s1."+".$s2."+".$s3."+".$s4."+".$s5;
    $pName = $_POST["pName"];
    $pPrice = $_POST["pPrice"];
    $discount = $_POST["discount"];
      
    $date = date("d/M/Y");
      
        $img1 = $_FILES['img1']['name'];
        $tmp_name1 = $_FILES['img1']['tmp_name'];
      move_uploaded_file($tmp_name1,"upload/".$img1);
          $img2 = $_FILES['img2']['name'];
          $tmp_name2 = $_FILES['img2']['tmp_name'];
          move_uploaded_file($tmp_name2,"upload/".$img2);

          $img3 = $_FILES['img3']['name'];
          $tmp_name3 = $_FILES['img3']['tmp_name'];
          move_uploaded_file($tmp_name3,"upload/".$img3);
      
      $img_arr = $img1."+".$img2."+".$img3;
      // count the total product
      $select_query = "SELECT * FROM store";
      $fire = mysqli_query($con,$select_query) or die(mysqli_error($con));
      while($row = mysqli_fetch_assoc($fire)){
        $pid++;
      }
      $insert_query = "INSERT INTO store(collectiontype,pid,size,color,pname,pprice,discount,img,date) VALUES('$cType','$pid','$size','$color','$pName','$pPrice','$discount','$img_arr','$date')";
      mysqli_query($con,$insert_query) or die(mysqli_error($con));
}

// update product data
if(isset($_POST["update"])){ 
  $pid = $_POST["pid"];
  $pName = $_POST["pname"];
  $pPrice = $_POST["pprice"];
  $color = $_POST["color"];
  $discount = $_POST["discount"];
  if($discount == ""){
      $discount = 0;
  }
  $update_query = "UPDATE store SET pname='$pName', pprice='$pPrice', color='$color', discount='$discount' WHERE pid = '$pid'";
  mysqli_query($con,$update_query) or die(mysqli_error($con));
  echo "<script>alert('successfully updated!!');</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Aroma Tazeen</title>
   <!-- Meta -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="description" content="Quantum Able Bootstrap 4 Admin Dashboard Template by codedthemes">
   <meta name="keywords" content="appestia, Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
   <meta name="author" content="codedthemes">
   <!-- Favicon icon -->
   <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
   <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
   <!-- Google font-->
   <link href="https://fonts.googleapis.com/css?family=Ubuntu:400,500,700" rel="stylesheet">
   <!-- themify -->
   <link rel="stylesheet" type="text/css" href="assets/icon/themify-icons/themify-icons.css">
   <!-- iconfont -->
   <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">
   <!-- simple line icon -->
   <link rel="stylesheet" type="text/css" href="assets/icon/simple-line-icons/css/simple-line-icons.css">
   <!-- Required Fremwork -->
   <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css">
   <!-- Weather css -->
   <link href="assets/css/svg-weather.css" rel="stylesheet">
   <!-- Style.css -->
   <link rel="stylesheet" type="text/css" href="assets/css/main.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
   <!-- Responsive.css-->
   <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
</head>

<body class="sidebar-mini fixed" style="background-color:#ebeff2;">
   <div class="wrapper">
      <div class="loader-bg">
         <div class="loader-bar">
         </div>
      </div>
      <!-- Navbar-->
      <header class="main-header-top hidden-print">
         <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
            <ul class="top-nav lft-nav">
               <li class="dropdown pc-rheader-submenu message-notification search-toggle">
                  <a href="#!" id="morphsearch-search" class="drop icon-circle txt-white">
                     <i class="ti-search"></i>
                  </a>
               </li>
            </ul>
            <!-- Navbar Right Menu-->
            <div class="navbar-custom-menu">
               <ul class="top-nav">
                  <!-- chat dropdown -->
                  <li class="pc-rheader-submenu ">
                     <a href="#!" class="drop icon-circle displayChatbox">
                        <i class="icon-bubbles"></i>
                        <span class="badge badge-danger header-badge">5</span>
                     </a>

                  </li>
                  <!-- window screen -->
                  <li class="pc-rheader-submenu">
                     <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                        <i class="icon-size-fullscreen"></i>
                     </a>

                  </li>
                  <!-- User Menu-->
                  <li class="dropdown">
                     <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                        <span><img class="img-circle" height="30px" width="30px" src="/aroma/quantam-lite/upload/<?php echo $aimg; ?>" alt="User Image"></span>
                        <span>&nbsp <b><?php echo $username; ?></b> <i class=" icofont icofont-simple-down"></i></span>

                     </a>
                     <ul class="dropdown-menu settings-menu">
                        <li><a href="profile.php"><i class="icon-user"></i> Profile</a></li>
                        <li><a href="#"><i class="icon-envelope-open"></i> My Messages</a></li>
                        <li class="p-0">
                           <div class="dropdown-divider m-0"></div>
                        </li>
                        <li><a href="logout.php"><i class="icon-logout"></i> Logout</a></li>

                     </ul>
                  </li>
               </ul>

               <!-- search -->
               <div id="morphsearch" class="morphsearch">
                  <form class="morphsearch-form">
                     <input class="morphsearch-input" type="search" placeholder="Search..." />
                     <button class="morphsearch-submit" type="submit">Search</button>
                  </form>
                  <div class="morphsearch-content">
                     <div class="dummy-column">
                        <h2>Recent</h2>
                        <a class="dummy-media-object" href="#!">
                           <img src="assets/images/avatar-1.png" alt="TooltipStylesInspiration" />
                           <h3>Tooltip Styles Inspiration</h3>
                        </a>
                        <a class="dummy-media-object" href="#!">
                           <img src="assets/images/avatar-1.png" alt="NotificationStyles" />
                           <h3>Notification Styles Inspiration</h3>
                        </a>
                     </div>
                  </div>
                  <!-- /morphsearch-content -->
                  <span class="morphsearch-close"><i class="icofont icofont-search-alt-1"></i></span>
               </div>
               <!-- search end -->
            </div>
         </nav>
      </header>
      <!-- Side-Nav-->
      <aside class="main-sidebar hidden-print ">
         <section class="sidebar" id="sidebar-scroll">
            <!-- Sidebar Menu-->
            <ul class="sidebar-menu">
                <li class="active treeview">
                    <a class="waves-effect waves-dark" href="index.php">
                        <i class="icon-speedometer"></i><span> Dashboard</span>
                    </a>                
                </li><br>
                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icon-briefcase"></i><span>Products</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="waves-effect waves-dark" href="trending.php"><i class="icon-arrow-right"></i>Trending Product</a></li>
                        <li><a class="waves-effect waves-dark" href="latest.php"><i class="icon-arrow-right"></i>Latest Product</a></li>
                        <li><a class="waves-effect waves-dark" href="offer.php"><i class="icon-arrow-right"></i>Sale Product</a></li>
                    </ul>
                </li>

                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icon-chart"></i><span>Sales</span><span class="label label-success menu-caption">new</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="waves-effect waves-dark" href="order.php"><i class="icon-arrow-right"></i>Orders</a></li>
                        <li><a class="waves-effect waves-dark" href="transaction.php"><i class="icon-arrow-right"></i>Transactions</a></li>
                    </ul>
                </li>

                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icon-book-open"></i><span>Coupons</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li><a class="waves-effect waves-dark" href="listCoupon.php"><i class="icon-arrow-right"></i>List coupons</a></li>
                        
                        <li><a class="waves-effect waves-dark" href="createCoupon.php"><i class="icon-arrow-right"></i>Create coupons</a></li>
                    </ul>
                </li>

                <li class="nav-level">--- More</li>

                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icon-docs"></i><span>Pages</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                      <ul class="treeview-menu">
                          <li><a class="waves-effect waves-dark" href="listPage.php" target="_blank"><i class="icon-arrow-right"></i>List Page</a></li>
                          
                          <li><a class="waves-effect waves-dark" href="createPage.php"><i class="icon-arrow-right"></i><span>Create Page</span></a></li>
                      </ul>    
                      <li><a class="waves-effect waves-dark" href="listPage.php" target="_blank"><i class="icon-arrow-right"></i>List Page</a></li>
                      <li><a class="waves-effect waves-dark" href="createPage.php"><i class="icon-arrow-right"></i>Create Page</a></li>      
                    </ul>
                </li>


                <li class="nav-level">--- Media</li>
                <!-- menus -->
                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>Menus</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="menuList.php">
                                <i class="icon-arrow-right"></i>
                                <span>Menu List</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="createMenu.php">
                                <i class="icon-arrow-right"></i>
                                <span>Create Menu</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Users -->
                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>Users</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="userList.php">
                                <i class="icon-arrow-right"></i>
                                <span>User List</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="createUser.php">
                                <i class="icon-arrow-right"></i>
                                <span>Create User</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Vendors -->
                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>Vendors</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="vendorList.php">
                                <i class="icon-arrow-right"></i>
                                <span>Vendor List</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="createVendor.php">
                                <i class="icon-arrow-right"></i>
                                <span>Create Vendor</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Localization -->
                <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>Localization</span><i class="icon-arrow-down"></i></a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="translation.php">
                                <i class="icon-arrow-right"></i>
                                <span>Translation</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="currency.php">
                                <i class="icon-arrow-right"></i>
                                <span>Currency rates</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a class="waves-effect waves-dark" href="taxes.php">
                                <i class="icon-arrow-right"></i>
                                <span>Taxes</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-level">--- Reports</li>
                <li class="treeview"><a class="waves-effect waves-dark" href="profile.php"><i class="icon-docs"></i><span>Setting</span></a>
                </li>
                <li class="treeview"><a class="waves-effect waves-dark" href="invoice.php"><i class="icon-docs"></i><span>Invoice</span></a></li>
                <li class="treeview"><a class="waves-effect waves-dark" href="logout.php"><i class="icon-docs"></i><span>Logout</span></a></li>
            </ul>
         </section>
      </aside>  
      <!-- Sidebar chat start -->
      <div id="sidebar" class="p-fixed header-users showChat">
         <div class="had-container">
            <div class="card card_main header-users-main">
               <div class="card-content user-box">

                  <div class="md-group-add-on p-20">
                     <span class="md-add-on">
                                    <i class="icofont icofont-search-alt-2 chat-search"></i>
                                 </span>
                     <div class="md-input-wrapper">
                        <input type="text" class="md-form-control" name="username" id="search-friends">
                        <label>Search</label>
                     </div>

                  </div>
                  <div class="media friendlist-main">

                     <h6>Friend List</h6>

                  </div>
                  <div class="main-friend-list">
                     <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                           <img class="media-object img-circle" src="assets/images/avatar-1.png" alt="Generic placeholder image">
                           <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                           <div class="friend-header">Josephin Doe</div>
                           <span>20min ago</span>
                        </div>
                     </div>
                     <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                        <a class="media-left" href="#!">
                           <img class="media-object img-circle" src="assets/images/avatar-2.png" alt="Generic placeholder image">
                           <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                           <div class="friend-header">Alice</div>
                           <span>1 hour ago</span>
                        </div>
                     </div>
                     <div class="media friendlist-box" data-id="7" data-status="offline" data-username="Michael Scofield" data-toggle="tooltip" data-placement="left" title="Michael Scofield">
                        <a class="media-left" href="#!">
                           <img class="media-object img-circle" src="assets/images/avatar-3.png" alt="Generic placeholder image">
                           <div class="live-status bg-danger"></div>
                        </a>
                        <div class="media-body">
                           <div class="friend-header">Michael Scofield</div>
                           <span>3 hours ago</span>
                        </div>
                     </div>
                     <!-- end of message -->
                  </div>
               </div>
            </div>
         </div>

      </div>
      <div class="showChat_inner">
         <div class="media chat-inner-header">
            <a class="back_chatBox">
               <i class="icofont icofont-rounded-left"></i> Josephin Doe
            </a>
         </div>
         <div class="media chat-messages">
            <a class="media-left photo-table" href="#!">
               <img class="media-object img-circle m-t-5" src="assets/images/avatar-1.png" alt="Generic placeholder image">
               <div class="live-status bg-success"></div>
            </a>
            <div class="media-body chat-menu-content">
               <div class="">
                  <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                  <p class="chat-time">8:20 a.m.</p>
               </div>
            </div>
         </div>
         <div class="media chat-messages">
            <div class="media-body chat-menu-reply">
               <div class="">
                  <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                  <p class="chat-time">8:20 a.m.</p>
               </div>
            </div>
            <div class="media-right photo-table">
               <a href="#!">
                  <img class="media-object img-circle m-t-5" src="assets/images/avatar-2.png" alt="Generic placeholder image">
                  <div class="live-status bg-success"></div>
               </a>
            </div>
         </div>
         <div class="media chat-reply-box">
            <div class="md-input-wrapper">
               <input type="text" class="md-form-control" id="inputEmail" name="inputEmail">
               <label>Share your thoughts</label>
               <span class="highlight"></span>
               <span class="bar"></span> <button type="button" class="chat-send waves-effect waves-light">
                     <i class="icofont icofont-location-arrow f-20 "></i>
                 </button>

            </div>

         </div>
      </div>
      <!-- Sidebar chat end-->

      <div class="content-wrapper">
         <!-- Container-fluid starts -->
         <!-- add product -->
         <div class="container">
           <div class="row">
             <div class="col-md-4">
              <h4 class="pt-4">Collections</h4><hr>
               <form class="form" id="form" method="post" action="collection.php" enctype="multipart/form-data">
                 <div class="form-group">
                    <select class="form-control" id="ctype" name="cType" style="width: 330px;" required="">
                      <option>Choose Collections(Category) Type</option>
                      <option>Beachwear</option>
                      <option>Coats & Jacket</option>
                      <option>Co-ordinates</option>
                      <option>Bodysuits</option>
                      <option>Denim</option>
                      <option>Dresses</option>
                      <option>Jumpsuits</option>
                      <option>Jumpers & Cardigans</option>
                      <option>Loungewears</option>
                      <option>Nightwears</option>
                      <option>Shorts</option>
                      <option>Swimwear</option>
                      <option>Tops</option>
                      <option>Tracksuits</option>
                      <option>Trouser</option>
                      <option>Accessories</option>
                      <option>Shoes</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <select class="form-control" id="cbrand" name="cbrand" style="width: 330px;" required="">
                      <option>Choose Brand</option>
                      <option>Vercase</option>
                      <option>Gucci</option>
                      <option>Nike</option>
                      <option>Adidas</option>
                      <option>Other</option>
                    </select>
                  </div>
                 <div class="dropdown">
                     <button class="btn btn-light dropdown-toggle pl-3 pr-5" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Product Size Available &nbsp&nbsp&nbsp</button>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                       <a class="dropdown-item pt-2 pb-2" href="#">
                         <input type="checkbox" name="s1" id="s1" value="XS">&nbsp XS
                       </a>
                       <a class="dropdown-item pt-2 pb-2" href="#">
                         <input type="checkbox" name="s2" id="s2" value="S">&nbsp S
                       </a>
                       <a class="dropdown-item pt-2 pb-2" href="#">
                          <input type="checkbox" name="s3" id="s3" value="M">&nbsp M
                       </a>
                       <a class="dropdown-item pt-2 pb-2" href="#">
                          <input type="checkbox" name="s4" id="s4" value="L">&nbsp L
                       </a>
                       <a class="dropdown-item pt-2 pb-2" href="#">
                          <input type="checkbox" name="s5" id="s5" value="XL">&nbsp XL
                       </a>
                     </div>
                 </div><br>
                 <div class="dropdown">
                     <button class="btn btn-light dropdown-toggle pl-3 pr-5" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Choose Product Color &nbsp&nbsp&nbsp</button>
                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="black">&nbsp Black</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="chocolate">&nbsp Chocolate</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="blue">&nbsp Blue</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="pink">&nbsp Pink</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="red">&nbsp Red</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="white">&nbsp White</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="white">&nbsp Grey</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="brown">&nbsp Brown</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="green">&nbsp Green</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="orange">&nbsp Orange</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="purple">&nbsp Purple</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="silver">&nbsp Silver</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="yellow">&nbsp Yellow</a>
                        <a class="dropdown-item" href="#"><input type="checkbox" name="color" value="gold">&nbsp Gold</a>
                    </div> 
                </div><br>
                 <input class="form-control mb-3" type="text" name="pName" placeholder="Enter Product Name " id="name" required="">
                 <input class="form-control mb-3" type="text" name="pPrice" placeholder="Enter Product Price " id="price" required="">
                 <input class="form-control mb-3" type="text" name="discount" placeholder="Enter Product Discount (Optional) " value="0" id="discount">
                 <div class="input-group mb-3">
                  <div class="custom-file">
                      <input type="file" name="img1" class="custom-file-input" value="" id="file1" onclick="select_photo1()">
                      <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Select Image1 (Face)</label>
                    </div>
                    </div>
                    <div class="input-group mb-3">
                  <div class="custom-file">
                      <input type="file" name="img2" class="custom-file-input" value="" id="file2" onclick="select_photo2()">
                      <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Select Image2 (Back)</label>
                    </div>
                    </div>
                    <div class="input-group mb-3">
                  <div class="custom-file">
                      <input type="file" name="img3" class="custom-file-input" value="" id="file3" onclick="select_photo3()">
                      <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Select Image3 (Center)</label>
                    </div>
                    </div><br>
                 <input type="submit" name="upload" class="btn btn-primary" value="Upload" id="upload">
               </form>
             </div>
             <div class="col-md-8"><br>
               <img src="" class="img-fluid" id="image" style="border-radius: 5px;">
             </div>
           </div>
         </div><br><br><br>
         <!-- display all product -->
         <div class="container-fluid pt-4 pr-3">
            <div class="row">
              <?php 
              $select = "SELECT* FROM store ORDER BY pid DESC";
              $fire = mysqli_query($con, $select) or die(mysqli_error($con));
              while($row = mysqli_fetch_assoc($fire)){
                  $img_arr = explode("+",$row["img"]);
              ?>
              <div class="col-md-3">
                <div class="card card2">
                  <img src="/aroma/quantam-lite/upload/<?php echo $img_arr[0]; ?>" class="card-img-top">
                  <div class="card-body">
                    <h6 class="card-title" style="margin-top: -10px;font-weight: bold;">Type: <?php echo $row['collectiontype']; ?></h6>
                    <h6 class="card-title" style="margin-top: -10px;font-weight: bold;"><?php echo $row['pname']; ?></h6>
                    <p class="card-title" style="margin-top: -10px;">$USD <?php echo $row['pprice']; ?></p>
                    <p class="card-title mt-1" style="margin-top: -10px;"><div style="background-color: <?php echo $row['color']; ?>; height: 15px;width: 15px;border:1px solid #333;"></div></p>
                    <button class="btn btn-dark pt-1 pb-1 pr-2 pl-2 text-white" style="font-size: 13px;" onclick="update(<?php echo $row['pid']; ?>,'<?php echo $row['pname']; ?>',<?php echo $row['pprice']; ?>,'<?php echo $row['color']; ?>','<?php echo $row['discount']; ?>','<?php echo $img_arr[0]; ?>')">Update</button>
                    <a class="btn btn-dark pt-1 pb-1 pr-2 pl-2 text-white" style="font-size: 13px;" onclick="sale(<?php echo $row["pid"]; ?>,'<?php echo $img_arr[0]; ?>','<?php echo $row["pname"]; ?>',<?php echo $row["pprice"]; ?>)">Sale</a>
                    <a class="btn btn-danger pt-1 pb-1 pr-2 pl-2 text-white ml-3" style="font-size: 13px;" onclick="Delete(<?php echo $row["pid"]; ?>)">Delete</a>
                  </div>
                </div>
              </div> 
              <?php } ?>
            </div>
         <!-- Container-fluid ends -->
      </div>
      
      <!-- discount update form -->
      <div class="container" id="discount_form">
        <button class="btn btn-danger" style="text-align: center;" onclick="turnoff()">Refresh</button><br><br>
        <div class="row"> 
          <div class="col-md-8">
            <div class="card">
              <img src="" id="img">
              <div class="card-body">
                <h6 class="card-title" id="name"><b></b></h6>
                <h6 class="card-title" id="price"><b></b></h6>
                   <input type="hidden" name="pid" id="pid">
                   <input type="text" class="form-control" name="discount" id="discount" placeholder="Enter product discount (%): " required=""><br>
                   <input type="submit" name="sale" value="Update" class="btn btn-primary"  onclick="sendData()">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /end of discount update form -->
    </div>
    <!-- curtains -->
    <div class="container-fluid bg-light" id="curtains" style="height: 100vh; z-index:2; position: absolute;top: 0;" onclick="turnoff()"></div>
   <!--product update form-->
      <div class="container" id="product_update">
          <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6 bg-white p-4">
                  <h5> Product Update</h5>
                  <div class="card">
                      <div class="card-body">
                          <form class="form" method="post">
                              <input type="hidden" name="pid" id="pid">
                              <lable>New Product Name</lable><br>
                              <input type="text" name="pname" id="pname" class="form-control"><br>
                              <lable>New Product price</lable><br>
                              <input type="text" name="pprice" id="pprice" class="form-control"><br>
                              <lable>New Product Color</lable><br>
                              <input type="text" name="color" id="color" class="form-control"><br>
                              <lable>New Discount Price(Optional)</lable><br>
                              <input type="text" name="discount" id="discount" class="form-control"><br>
                              <input type="submit" name="update" value="Update" class="btn btn-primary">
                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-md-3 bg-white pl-4 pt-5">
                  <img src="" class="card-img mt-3" id="img"><br><br>
              </div>
          </div>
      </div><br>
    <!-- Required Jqurey -->
   <script src="assets/plugins/Jquery/dist/jquery.min.js"></script>
   <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="assets/plugins/tether/dist/js/tether.min.js"></script>

   <!-- Required Fremwork -->
   <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
      <!-- waves effects.js -->
   <script src="assets/plugins/Waves/waves.min.js"></script>
   <!-- Scrollbar JS-->
   <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
   <script src="assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

   <!--classic JS-->
   <script src="assets/plugins/classie/classie.js"></script>

   <!-- Counter js  -->
   <script src="assets/plugins/waypoints/jquery.waypoints.min.js"></script>
   <script src="assets/plugins/countdown/js/jquery.counterup.js"></script>

   <!-- google line chart -->
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

   <!-- custom js -->
   <script type="text/javascript" src="assets/js/main.min.js"></script>
   <script type="text/javascript" src="assets/pages/dashboard.js"></script>
   <script type="text/javascript" src="assets/pages/elements.js"></script>
   <script src="assets/js/menu.min.js"></script>
   <script>
     //select photo
      function select_photo1(){
          var file = document.querySelector('#file1');
          file.addEventListener('change',function(){
          //code to retrive the file --> name and type
          $("[for=file]").html(this.files[0].name);
          $("#image").attr("src", URL.createObjectURL(this.files[0]));
        })
      }
      function select_photo2(){
          var file = document.querySelector('#file2');
          file.addEventListener('change',function(){
          //code to retrive the file --> name and type
          $("[for=file]").html(this.files[0].name);
          $("#image").attr("src", URL.createObjectURL(this.files[0]));
        })
      }
      function select_photo3(){
          var file = document.querySelector('#file3');
          file.addEventListener('change',function(){
          //code to retrive the file --> name and type
          $("[for=file]").html(this.files[0].name);
          $("#image").attr("src", URL.createObjectURL(this.files[0]));
        })
      }

      // ****** --> send product id to delete.php <-- ********
      var pid=0;
      // dissappear form
      $("#discount_form").css("visibility","hidden");
      $("#curtains").css("visibility","hidden");
      $("#discount_form").css("position","absolute");
      $(".content-wrapper").css("visibility","visible");
      $("#discount_form").css("z-index","4");
      $("#discount_form").css("top","100px");
      function sale(pid, img, name, price){
        // form appear on click
        $(".content-wrapper").css("visibility","hidden");
        $("#curtains").css("visibility","visible");
        $("#discount_form").css("visibility","visible");
        // filling the discount form 
        $("#discount_form #img").attr("src","/aroma/quantam-lite/upload/"+img);
        $("#discount_form #name").text(name);
        $("#discount_form #price").text(price);

        this.pid = pid;
      }

      function sendData(){
        var discount = $("#discount_form #discount").val();
        $.ajax({
          url:"discount.php",
          method:"post",
          data:{data:true, pid, discount},
          success:function(result){
            location.assign("collection.php")
          }
        })

      }

      // turn off the curtains
      function turnoff(){
        $("#curtains").css("visibility","hidden");
        location.assign("collection.php")
      }

      //  ****** ---> update discount price <---- *******
     $('.content-wrapper').css("display","block");
     $('#product_update').css("display","none");
     $('#product_update').css("position","absolute");
     $('#product_update').css("top","150px");
     $('#product_update').css("z-index","444");
     function update(pid,pname,pprice,color,discount,img){
      $("#curtains").css("visibility","visible");
      $('#product_update .row .col-md-3 #img').attr("src","/aroma/quantam-lite/upload/"+img);
      $('#product_update .row .col-md-6 .card .card-body #pid').val(pid);
      $('#product_update .row .col-md-6 .card .card-body #pprice').val(pprice);
      $('#product_update .row .col-md-6 .card .card-body #color').val(color);
      $('#product_update .row .col-md-6 .card .card-body #discount').val(discount);
      $('#product_update .row .col-md-6 .card .card-body #pname').val(pname);
      window.scrollTo({top: 0, behavior: 'smooth'});
      $('.content-wrapper').css("display","none");
      $('#product_update').css("display","block");
     }
     

      // ****** ---> send product id to delete.php <---- *******
      function Delete(pid){
        $.ajax({
          url:"delete.php",
          method:"post",
          data:{data:true, pid},
          success:function(result){
            location.assign("collection.php")
          }
        })
      }
   </script>  
</body>
</html>

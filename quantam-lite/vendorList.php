<?php 
$con = mysqli_connect("localhost","root","","aroma");

//check whether customer already login or not
session_start();
$username = "";
if(isset($_SESSION["aemail"]) !=" " && isset($_SESSION["apassword"]) !=" "){
  $uemail = $_SESSION["aemail"];
  $select_query0 = "SELECT * FROM admin WHERE email = '$uemail'";
  $fire1 = mysqli_query($con,$select_query0) or die(mysqli_error($con));
  while($row = mysqli_fetch_assoc($fire1)){
    $username = $row["uname"];
    $img = $row["img"];
  }
}

// delete the coupons
if(isset($_POST["submit"])){
  //get the coupon id
  $cid = $_POST["id"];
  
  $query = "DELETE FROM coupon WHERE id='$cid'";
  mysqli_query($con,$query) or die(mysqli_query($con, $query));
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
                        <span><img class="img-circle" height="30px" width="30px" src="/aroma/quantam-lite/upload/<?php echo $img; ?>" alt="User Image"></span>
                        <span>&nbsp <b><?php echo $username; ?></b> <i class=" icofont icofont-simple-down"></i></span>

                     </a>
                     <ul class="dropdown-menu settings-menu">
                        <li><a href="profile.php"><i class="icon-user"></i> Profile</a></li>
                        <li class="p-0">
                           <div class="dropdown-divider m-0"></div>
                        </li>
                        <li><a href="llogout.php"><i class="icon-logout"></i> Logout</a></li>
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
                        <li><a class="waves-effect waves-dark" href="collection.php"><i class="icon-arrow-right"></i>Collection Product</a></li>
                        <li><a class="waves-effect waves-dark" href="trending.php"><i class="icon-arrow-right"></i>Trending Product</a></li>
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
                          <li><a class="waves-effect waves-dark" href="listPage.php"><i class="icon-arrow-right"></i>List Page</a></li>
                          
                          <li><a class="waves-effect waves-dark" href="createPage.php" target="_blank"><i class="icon-arrow-right"></i><span>Create Page</span></a></li>
                      </ul>    
                      <li><a class="waves-effect waves-dark" href="listPage.php"><i class="icon-arrow-right"></i>List Page</a></li>
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
                <li class="treeview"><a class="waves-effect waves-dark" href="/aroma/admin-login.php"><i class="icon-docs"></i><span>Login</span></a></li>
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
         <br><br><h4 class="ml-2">Vendor Lists</h4>
         <div class="row">
           <div class="col-md-12">
             <!--Coupon list displaying in table -->
                <table class="table bg-white table-responsive" style="width: 100%; margin-bottom: 480px;">
                  <!-- table heading -->
                  <thead>
                    <tr>
                      <th scope="col">Vendor</th>
                      <th scope="col">Products</th>
                      <th scope="col">Store Name</th>
                      <th scope="col">Created Date</th>
                      <th scope="col">Wallet Balance</th>
                      <th scope="col">Revenue</th>
                    </tr>
                  </thead>
                  <!-- table body  -->
                  <tbody>
                  <?php 
                  $select = "SELECT * FROM vendor";
                  $fire = mysqli_query($con, $select) or die(mysqli_error($con));
                  while($row = mysqli_fetch_assoc($fire)){
                  ?>
                    <tr class="col">
                      <td><?php echo $row["vendor"]; ?></td>
                      <td><?php echo $row["product"]; ?></td>
                      <td><?php echo $row["store_name"]; ?></td>
                      <td><?php echo $row["date"]; ?></td>
                      <td><?php echo $row["wallet_balance"]; ?></td>
                      <td><?php echo $row["revenue"]; ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>
                <!-- /end of coupons list table -->
           </div>
         </div>
         <!-- Container-fluid ends -->
      </div>
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
     $(window).resize(function(){
      var width = $(window).width()

      //default
      $("#logo").css("visibility","visible")
      $("#logo").css("position","static")

      //change
      if(width<784){
        $("#logo").css("visibility","hidden")
        $("#logo").css("position","absolute")
        $("#logo").css("top","0")
      }
     })

     //  ****** ---> update discount price <---- *******
     $('.content-wrapper .container .row .col-md-4').css("visibility","hidden");
     $('.content-wrapper .container .row .col-md-4').css("position","absolute");
     function update(pid,ctype,ptype,pname,pprice,img){
      $('.content-wrapper .container .row .col-md-4 .form #pid').val(pid);
      $('.content-wrapper .container .row .col-md-4 .form #ctype').val(ctype);
      $('.content-wrapper .container .row .col-md-4 .form #ptype').val(ptype);
      $(".content-wrapper .container .row .col-md-4 .form #name").val(pname);
      $(".content-wrapper .container .row .col-md-4 .form #price").val(pprice);
      $(".content-wrapper .container .row .col-md-4 .form #file").attr("value",img);
      // visible col-md-4 container
      $('.content-wrapper .container .row .col-md-4').css("visibility","visible");
      $('.content-wrapper .container .row .col-md-4').css("position","static");
      window.scrollTo({top: 0, behavior: 'smooth'});
     }

      // refresh the page
      function refresh(){
        location.assign("trending.php");
      }

      // transfer the coupon code to this page
      function delete_coupon(id){
        $("#cid").attr("value",id);
        $("#btn").click();
      }

   </script>  
</body>
</html>

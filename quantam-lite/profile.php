<?php
$con = mysqli_connect("localhost","root","","aroma");

//check whether customer already login or not
session_start();
$username = "";
if(strlen(isset($_SESSION['aemail'])) !=0 && strlen(isset($_SESSION['apassword'])) !=0){
  $uemail = $_SESSION["aemail"];
  $select_query0 = "SELECT * FROM admin WHERE email = '$uemail'";
  $fire1 = mysqli_query($con,$select_query0) or die(mysqli_error($con));
  while($row = mysqli_fetch_assoc($fire1)){
    $username = $row["uname"];
    $img = $row["img"];
  }
}

// upload profile pictures
if(isset($_POST["profile_btn"])){
  $src = $_FILES["file"]["name"];
  $temp = $_FILES["file"]["tmp_name"];
  //upload the file in local folder -> upload/
  move_uploaded_file($temp, "/Applications/XAMPP/xamppfiles/htdocs/aroma/quantam-lite/upload/".$src);
  $update = "UPDATE admin SET img='$src' WHERE email = '$uemail'";
  $result = mysqli_query($con,$update) or die(mysqli_error($con));
  if($result){
    echo "<script>alert($src)</script>";
    // echo "<script>location.assign('profile.php')</script>";
  }
}

// update variable
$result = $color = "";
//update username
if(isset($_POST["username_btn"])){
  $username = $_POST["username"];
  $update = "UPDATE admin SET uname='$username' WHERE email = '$uemail'";
  $result = mysqli_query($con,$update) or die(mysqli_error($con));
  if($result){
    $color = "text-success";
    $result = "Successfully Updated!";
    echo "<script>location.assign('profile.php')</script>";
  }else{
    $color = "text-danger";
    $result = "Failed to Update!";
  }
}

//update password
if(isset($_POST["password_btn"])){
  $old_password = $_POST["old_password"];
  $new_password = $_POST["new_password"];

  //get the old password from dbase
  $query = "SELECT * FROM admin";
  $fire = mysqli_query($con,$query) or die(mysqli_error($con));
  while($row = mysqli_fetch_assoc($fire)){
    $old_password_val =  $row["password"];
  }

  if($old_password == $old_password_val){
    $color = "text-success";
    $result = "Successfully Updated!";
    $update = "UPDATE admin SET password='$new_password' WHERE email = '$uemail'";
    mysqli_query($con,$update) or die(mysqli_error($con));
    if($result){
      $color = "text-success";
      $result = "Password changed Successfully!";
      echo "<script>location.assign('profile.php')</script>";
    }
  }else{
    $color = "text-danger";
    $result = "Old Password doesnt matched!";
  }

}

//update contact information
if(isset($_POST["contact_btn"])){
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $location = $_POST["location"];

  $update = "UPDATE admin SET email='$email', phone='$phone',location='$location' WHERE email = '$uemail'";
  $result = mysqli_query($con,$update) or die(mysqli_error($con));
  if($result){
    $color = "text-success";
    $result = "Successfully Updated!";
    $_SESSION["aemail"] = $email;
    echo "<script>location.assign('profile.php')</script>";
  }else{
    $color = "text-danger";
    $result = "Failed to update!";
  }
}

//post status
if(isset($_POST["create_btn"])){
  $title = $_POST["title"];
  $status = $_POST["status"];
  $src = $_FILES["post_img"]["name"];
  $temp = $_FILES["post_img"]["tmp_name"];
  //upload in local folder
  move_uploaded_file($temp, "/Applications/XAMPP/xamppfiles/htdocs/aroma/quantam-lite/upload/".$src);

  //get current date
  $date = date("d/M/Y");


  $query = "INSERT INTO admin_status(img, title, status,date) VALUES('$src','$title','$status','$date')";
  mysqli_query($con,$query) or die(mysqli_error($con));
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
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
   <!-- font awesome -->
   <script src="https://use.fontawesome.com/b491cd4834.js"></script>
   <!-- Style.css -->
   <link rel="stylesheet" type="text/css" href="assets/css/main.css">
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
                      <li><a class="waves-effect waves-dark" href="collection.php"><i class="icon-arrow-right"></i>Collections</a></li>
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
                          <li><a class="waves-effect waves-dark" href="listPage.php"><i class="icon-arrow-right"></i>List Page</a></li>
                          
                          <li><a class="waves-effect waves-dark" href="createPage.php"><i class="icon-arrow-right"></i><span>Create Page</span></a></li>
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
         <!-- Container starts -->
         <div class="container">
            <div class="row" style="background-image: url('/aroma/img/bg5.jpg'); background-size: cover;">
              <div class="col-md-12"><br><br><br><br><br><br><br><br><br>
                <center><div class="img-circle" style="height: 130px;width: 130px;background-size: cover; background-image:url('/aroma/quantam-lite/upload/<?php echo $img; ?>'); border:5px solid white; margin-top: 0px;"><div style=" height: 30px;width: 30px;margin-top: 90px; margin-left: 70px; background-color:#BBBABA; border-radius: 50%;"><i class="fa fa-camera text-dark mt-2" arial-hidden="true"></i><div></div></center>
              </div>
            </div><br>  
            <center><h4><b><?php echo $username; ?></b></h4></center><hr>
            <nav class="navbar navbar-expand-lg navbar-light" style="margin-left: 00px;">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active" onclick="profile_change()">
                  <a class="btn btn-secondary text-white" href="#"><i class="fa fa-camera" arial-hidden="true"></i>&nbsp Change Profile Pictures<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active" onclick="username_change()">
                  <a class="btn btn-secondary text-white" href="#"><i class="fa fa-user" arial-hidden="true"></i>&nbsp Change User Name <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active" onclick="password_change()">
                  <a class="btn btn-secondary text-white" href="#"><i class="fa fa-key" arial-hidden="true"></i>&nbsp Change Password<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active" onclick="contact_change()">
                  <a class="btn btn-secondary text-white" href="#"><i class="fa fa-map-marker" arial-hidden="true"></i>&nbsp Change Contact Information <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active" onclick="create_post()">
                  <a class="btn btn-secondary text-white" href="#"><i class="fa fa-comments" arial-hidden="true"></i>&nbsp Post Status<span class="sr-only">(current)</span></a>
                </li>   
              </ul>
            </nav><br>
            <!-- update form model -->
            <div class="col-md-4 p-2 ml-1 mr-5" id="profile_change" style="padding: 20px; background-color: white;">
              <h4>Update Profile Pictures</h4>
              <span class="<?php echo $color; ?>"><?php echo $result; ?></span><hr>
              <form class="form p-5" method="post" enctype="multipart/form-data">
                <label>Image File</label>
                <img src="" class="img-fluid" id="img"><br>
                <input type="file" id="file" name="file" style="display: none;">
                <span class="text-info" id="detector" style="cursor: pointer;">Click</span><br><br>
                <input class="btn btn-primary" type="submit" name="profile_btn" value="Upload">
                </form>
            </div>
            <div class="col-md-4 p-2 ml-1 mr-5" id="username_change" style="padding: 20px; background-color: white;">
              <h4>Update Username</h4>
              <span class="<?php echo $color; ?>"><?php echo $result; ?></span><hr>
              <form class="form p-5" method="post">
                <label>User Name</label>
                <input class="form-control" type="text" name="username" placeholder="Enter new User Name "><br>
                <input class="btn btn-primary" type="submit" name="username_btn" value="Update">
                </form>
            </div>
            <div class="col-md-4 p-2 ml-1 mr-5" id="password_change" style="padding: 20px; background-color: white;">
              <h4>Update Password</h4>
              <span class="<?php echo $color; ?>"><?php echo $result; ?></span><hr>
              <form class="form p-5" method="post">
                <label>Old Password</label>
                <input class="form-control" type="password" name="old_password" placeholder="Enter old Password"><br>
                <label>New Password</label>
                <input class="form-control" type="password" name="new_password" placeholder="Enter new Password"><br>
                <input class="btn btn-primary" type="submit" name="password_btn" value="Update">
                </form>
            </div>
            <div class="col-md-4 p-2 ml-1 mr-5" id="contact_change" style="padding: 20px; background-color: white;">
              <h4>Update Contact Information</h4>
              <span class="<?php echo $color; ?>"><?php echo $result; ?></span><hr>
              <form class="form p-5" method="post">
                <label>Email</label>
                <input class="form-control" type="text" name="email" placeholder="Enter new Email ID "><br>
                <label>Phone</label>
                <input class="form-control" type="text" name="phone" placeholder="Enter new Phone Number "><br>
                <label>Location</label>
                <input class="form-control" type="text" name="location" placeholder="Enter new User Location "><br>
                <input class="btn btn-primary" type="submit" name="contact_btn" value="Update">
                </form>
            </div>
            <div class="col-md-4 p-2 ml-1 mr-5" id="create_post" style="padding: 20px; background-color: white;">
              <h4>CREATE A NEW POST</h4>
              <form class="form p-5" method="post" enctype="multipart/form-data">
                <label>POST TITLE</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Post Title" required=""><br>
                <label>TYPE YOUR  STATUS</label>
                <textarea class="form-control" name="status" style="height: 150px;"></textarea><br>
                <label>INSERT IMAGE(Optional)</label><br>
                <img src="" class="img-fluid" id="img"><br>
                <input type="file" id="file" name="post_img" style="display: none;">
                <span class="text-info" id="detector" style="cursor: pointer;">Click</span><br><br>
                <input class="btn btn-primary" type="submit" name="create_btn" value="POST">
                </form>
            </div>
            <!-- space occupier to fit the status content -->
            <div class="col-md-4 p-2 ml-1 mr-5" id="void" style="padding: 20px; background-color: white; visibility: hidden;">
              <h4>Update Contact Information</h4>
              <span class="<?php echo $color; ?>"><?php echo $result; ?></span><hr>
              <form class="form p-5" method="post">
                <label>Email</label>
                <input class="form-control" type="text" name="email" placeholder="Enter new Email ID "><br>
                <label>Phone</label>
                <input class="form-control" type="text" name="phone" placeholder="Enter new Phone Number "><br>
                <label>Location</label>
                <input class="form-control" type="text" name="location" placeholder="Enter new User Location "><br>
                <input class="btn btn-primary" type="button" name="create_btn1" value="Update" onclick="this.disabled=true">
                </form>
            </div>
            <!-- status post card display -->
            <div class="col-md-6 mt-2 p-5" style="height: 650px; overflow-y: scroll;">
              <h5 class="text-dark">NEWS FEED POST</h5><hr>
              <?php 
              $query = "SELECT * FROM admin_status";
              $fire = mysqli_query($con,$query) or die(mysqli_error($con));
              while($row = mysqli_fetch_assoc($fire)){
              ?>
              <div class="card">
                <img src="/aroma/quantam-lite/upload/<?php echo $row["img"]; ?>" class="card-img">
                <div class="card-body">
                  <h6 class="card-title"><?php echo $row["title"]; ?></h6>
                  <p style="margin-top: -10px;">Posted on: <?php echo $row["date"]; ?></p><br>
                  <p class="card-text"><?php echo $row["status"]; ?></p><br>
                </div>
              </div>
              <?php } ?>
              </div><br>
        </div>
       <!-- Container ends -->
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
     // update information
    $("#profile_change").css("display","none")
    $("#username_change").css("display","none")
    $("#password_change").css("display","none")
    $("#contact_change").css("display","none")
    $("#create_post").css("display","none")
    function profile_change(){
      var display = $("#profile_change").css("display")
      if(display == "none"){
        $("#void").css("display","none")
        $("#profile_change").css("display","block")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
        $("html, body").animate({ scrollTop: 300});
      }else{
        $("#void").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
      }
    }
    function username_change(){
      var display = $("#username_change").css("display")
      if(display == "none"){
        $("#void").css("display","none")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","block")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
        $("html, body").animate({ scrollTop: 300})
      }else{
        $("#void").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
      }
    }
    function password_change(){
      var display = $("#password_change").css("display")
      if(display == "none"){
        $("#void").css("display","none")
        $("#password_change").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
        $("html, body").animate({ scrollTop: 300})
      }else{
        $("#void").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
      }
    }
    function contact_change(){
      var display = $("#contact_change").css("display")
      if(display == "none"){
        $("#void").css("display","none")
        $("#contact_change").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#create_post").css("display","none")
        $("html, body").animate({ scrollTop: 300})
      }else{
        $("#void").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
      }
    }
    function create_post(){
      var display = $("#create_post").css("display")
      if(display == "none"){
        $("#void").css("display","none")
        $("#create_post").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("html, body").animate({ scrollTop: 300})
      }else{
        $("#void").css("display","block")
        $("#profile_change").css("display","none")
        $("#username_change").css("display","none")
        $("#password_change").css("display","none")
        $("#contact_change").css("display","none")
        $("#create_post").css("display","none")
      }
    }

    //update profile picture
    $("#detector").click(function(){
    $("#file").click();
        var file = document.querySelector('#file');
        file.addEventListener('change',function(){
        //code to retrive the file --> name and type
        $("[for=file]").html(this.files[0].name);
        //code to distinguish image or video type file
        var size = this.files[0].size;
        //image type file
        $("#img").attr("src", URL.createObjectURL(this.files[0]));
       })
    })

    //update post status picture
    $("#create_post #detector").click(function(){
    $("#create_post #file").click();
        var file = document.querySelector('#create_post #file');
        file.addEventListener('change',function(){
        //code to retrive the file --> name and type
        $("[for=file]").html(this.files[0].name);
        //code to distinguish image or video type file
        var size = this.files[0].size;
        //image type file
        $("#create_post #img").attr("src", URL.createObjectURL(this.files[0]));
       })
    })

   </script>
</body>
</html>

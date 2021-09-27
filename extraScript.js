
// change country region --> navbar - dropdown
$(".navbar .collapse form #lang").attr("src","img/us.jpeg")
//uk
$(".navbar .collapse form .dropdown-menu #UK").click(function(){
    $(".navbar .collapse form #lang").attr("src","img/uk.png")
    $(".navbar .collapse form #title").text(" $ UK / EN")
})
//us
$(".navbar .collapse form .dropdown-menu #US").click(function(){
    $(".navbar .collapse form #lang").attr("src","img/us.jpeg")
    $(".navbar .collapse form #title").text(" $ USA / EN")
})
//aus
$(".navbar .collapse form .dropdown-menu #AUS").click(function(){
    $(".navbar .collapse form #lang").attr("src","img/aus.png")
    $(".navbar .collapse form #title").text(" $ AUSTRALIA / EN")
})
// INDIA
$(".navbar .collapse form .dropdown-menu #INDIA").click(function(){
    $(".navbar .collapse form #lang").attr("src","img/india.png")
    $(".navbar .collapse form #title").text(" $ INDIA / EN")
})

// check the admin already  loggedin or not-> if loggedIn hide the signup and signin link
var username = $("#username").val();
var len = username.length;
// visibility
// $("#cart1").css("display","none");
$("#username").css("display","none");
// $("#cart").css("visibility","hidden");
$("#signin").css("visibility","visible");
// position 
// $("#cart").css("position","absolute");
$("#signin").css("position","static");
if(len > 10){
//   $("#cart1").css("display","block");
  $("#username").css("display","block");
//   $("#cart").css("visibility","visible");
//   $("#cart").css("position","static");
  $("#signin").css("visibility","hidden");
  $("#signin").css("position","absolute");
}

// profile and login option selector
$('#username').on('change', function() {
  var value = $(this).val();
  if(value == "Profile"){
    location.assign("profile.php")
  }
  if(value == "My Order"){
    location.assign("profile.php#myorder")
  }
  if(value == "Logout"){
    location.assign("logout.php")
  }
});

// redirect to card page only if there is product added
$("#cart").click(function(){
  var count = $("#cart_count").attr("value")
  if(count>=1){
    location.assign("cart.php")
  }else{
    alert("No product added!!")
  }
})

// redirect to card page only if there is product added
$("#cart1").click(function(){
  var count = $("#cart_count").attr("value")
  if(count>=1){
    location.assign("cart.php")
  }else{
    alert("No product added!!")
  }
})


/* ---> Cart.php <-----*/
// store quantity value to session
function send_data(){
  var val = $("#quantity").text();
  $("#quantity_val").attr("value",val);
}

//delete the cart product
function delete_session(id){
  $.ajax({
    url:"delete_cart_product.php",
    method:"post",
    data:{data:true,id},
    success: function(result){
      location.assign("cart.php");
    }
  })
}

/* ------> Bottom navbar function <--------*/
//wishlist btn click
function wishlistBtn(){
  location.assign('wishlist.php')
}
//redirect to homepage
function homeBottomIcon(){
  location.assign("index.php")
}
//redirect to login page
function userBottomIcon(){
  location.assign("profile.php")
}

//fade in love icon
$(".collection .row .owl-theme .item #card-img #loveProduct").fadeOut(0)
$(".collection .row .owl-theme .item #card-img #loveProduct").fadeIn(1000)

//send the selected product id
function sendSelectedProductId(id){
  $("#selected_product_id #pid").val(id)
  $("#selected_product_id #send").click()
}

function loveProduct(event,id){
  let classVal = event.target.className
  if( classVal == "fa fa-heart-o"){
    event.target.className = "fa fa-heart"
  }else{
    event.target.className = "fa fa-heart-o"
  }

  //send id to store on wishlist database
  $.ajax({
    url:"addWishlist.php",
    method:"post",
    data:{data:true, id},
    success:function(data){
      location.assign("")
    }
  })
}

// redirect to selected_product.php
function selected_product(pid){
  $.ajax({
    url:"selected_product.php",
    method:"post",
    data:{data:true, pid},
    success:function(result){
      location.assign("selected_product.php");
    }
  })
}
// get button click from search navbar
function getId(id){
  $("#pid").attr("value",id)
  $("#submit").click();
}

$(window).on("resize", () => {
  resizeTopNav()
})

function resizeTopNav() {
  $("#bottomNav").css("visibility", "hidden")
  $(".searchNav").css("display", "none")
  $("#topSearchIcon").css("display", "block")
  let width = $(document).width()
  if (width < 1000) {
    $("#highlighted-nav a").css("font-size", "10px")
    $("#bottomNav").css("visibility", "visible")
    $(".searchNav").css("display", "none")
    $("#topSearchIcon").css("display", "none")
  }
}
resizeTopNav()

function appearSeachbar(){
  let attrVal = $(".searchNav").css("display")
  if(attrVal == "block"){
    $(".searchNav").fadeOut(500)
  }else{
    $(".searchNav").fadeIn(500)
  }
}

//messagebox appear on click
function appearMessageBox(){
  let visible = $("#messageHelper #messageBox").css("display")
  if(visible == "flex"){
    $("#messageHelper #messageBox").css("display","none")
    $("#messageHelper #messageArea").css("display","none")
  }else{
    $("#messageHelper #messageBox").css("display","flex")
    $("#messageHelper #messageArea").css("display","flex")
  }
}
function appearMessageMedia(){
  let display = $(" #messageHelper .row .col-md-4 #visitMedia").css("display")
  if(display =="block"){
    $(" #messageHelper .row .col-md-4 #visitMedia").css("display","none")
  }else{
    $(" #messageHelper .row .col-md-4 #visitMedia").css("display","block")
  }
}

//on send btn click
$("#messageHelper .row .col-md-4 #messageSentIcon").on("click",function(){
  var message = $("#messageHelper .row .col-md-4 #messageInput").val()
  if(message.length != 0){
    $("#messageHelper .messageArea").append(`<div class='outgoing pb-2 mb-2'>${message}</div>`)
    $("#messageHelper .row .col-md-4 #messageInput").val("")
    $("#messageHelper .messageArea").scrollTop($(document).height())
  }
})

//on keyup
$("#messageHelper .row .col-md-4 #messageInput").on("keyup",function(){
  var message = $("#messageHelper .row .col-md-4 #messageInput").val()
  if(message.length != 0){
    $("#messageHelper .row .col-md-4 #messageSentIcon").css("color","green")
  }else{
    $("#messageHelper .row .col-md-4 #messageSentIcon").css("color","black")
  }
})

//send message on enter keyboard
$("#messageHelper .row .col-md-4 #messageInput").on("keypress",function(e){
  let key = e.keyCode
  if(key == 13){
    var message = $("#messageHelper .row .col-md-4 #messageInput").val()
    if(message.length != 0){
      $("#messageHelper .messageArea").append(`<div class='outgoing pb-2 mb-2'>${message}</div>`)
      $("#messageHelper .row .col-md-4 #messageInput").val("")
      $("#messageHelper .messageArea").scrollTop($(document).height())
    }
  }
})

$(document).ready(() => {
 $(".sidenav").css("display", "none")
})

//wishlist btn click
function wishlistBtn() {
 location.assign('wishlist.php')
}
//redirect to homepage
function homeBottomIcon() {
 location.assign("index.php")
}
//redirect to cart page
function cartBtn() {
 console.log("hcaker")
 location.assign("cart.php")
}
function openSidebar() {
 $(".sidenav").css("display", "block")
}

function closeSidebar() {
 $(".sidenav").css("display", "none")
}
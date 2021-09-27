
//wishlist btn click
function wishlistBtn() {
	location.assign('wishlist.php')
}

$("#search_result").css("display", "none")
$(".banner").css("display", "block")
$(".collection").css("display", "block")
$(".footer").css("display", "block")
$("#nav-search").on("keyup", function () {
	var val = $("#nav-search").val();
	if (val.length > 0) {
		$("#search_result").css("display", "block")
		$(".welcome-text").css("display", "none")
		$(".banner").css("display", "none")
		$(".collection").css("display", "none")
		$(".footer").css("display", "none")
	}

	// sending search key to the search.php page
	$.ajax({
		url: "search.php",
		method: "post",
		data: { data: true, val },
		success: function (data) {
			$("#search_result .row .card-columns").html(data);
		}
	})
})

//checking if searching field in empty
$("#nav-search").on("keydown", function () {
	var val = $("#nav-search").val();
	if (val.length == 1) {
		$(".welcome-text").css("display", "block")
		$("#search_result").css("display", "none")
		$(".banner").css("display", "block")
		$(".collection").css("display", "block")
		$(".footer").css("display", "block")
	}
})

// mobile view search bar
$("#search_bar center #search_input").on("keyup", function () {
	var val = $("#search_bar center #search_input").val();
	if (val.length > 0) {
		$("#search_result").css("display", "block")
		$(".welcome-text").css("display", "none")
		$(".banner").css("display", "none")
		$(".collection").css("display", "none")
		$(".footer").css("display", "none")
	}

	// sending search key to the search.php page
	$.ajax({
		url: "search.php",
		method: "post",
		data: { data: true, val },
		success: function (data) {
			$("#search_result .row .card-columns").html(data);
		}
	})
})

//get the pid 
function getPid(pid) {
	$("#pidVal").attr("value", pid);
}

//checking if searching field in empty
$("#search_bar center #search_input").on("keydown", function () {
	var val = $("#search_bar center #search_input").val();
	if (val.length == 1) {
		$(".welcome-text").css("display", "block")
		$("#search_result").css("display", "none")
		$(".banner").css("display", "block")
		$(".collection").css("display", "block")
		$(".footer").css("display", "block")
	}
})

// clicking on sorting navigation search bar
$("#search_btn").click(function () {
	$(".banner").css("display", "none")
	$(".collection").css("display", "none")
	$(".footer").css("display", "none")
})


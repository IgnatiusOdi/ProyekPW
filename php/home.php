<?php
	require_once('connection.php');

	if (isset($_REQUEST['logout'])) {
		unset($_SESSION['user']);
		header("Location: home.php");
	}

	if (isset($_POST['catalogg'])) {
		header("Location: search.php");
	}

	if (isset($_REQUEST['search'])) {
		$category = $_REQUEST['category'];
		$itemname = $_REQUEST['itemname'];

		$nextLocation = "search.php";

		if ($category != 0) {
			if ($category == 1) {
				$category = "Rackets";
			} else if ($category == 2) {
				$category = "Shoes";
			} else if ($category == 3) {
				$category = "Shuttlecocks";
			} else {
				$category = "Nets";
			}
			$nextLocation .= "?category=$category";
		}

		if ($itemname != "") {
			if ($category != 0) {
				$nextLocation .= "&itemname=$itemname";
			} else {
				$nextLocation .= "?itemname=$itemname";
			}
		}
		
		header("Location: $nextLocation");
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Badminton Kuy</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="../css/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="../css/slick.css" />
	<link type="text/css" rel="stylesheet" href="../css/slick-theme.css" />
	<link type="text/css" rel="stylesheet" href="../css/nouislider.min.css" />
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="../css/style.css" />
	<script src="../js/jquery.min.js"></script>
</head>

<body>
	<div id="header">
		<div class="container">
			<div class="row">
				<div class=" col-md-3 col-xs-12">
					<div class="header-logo col-md-12">
						<a href="#" class="logo">
							<img style="margin-left: 0px; margin-top: 10px; width: 100%;" src="../img/truelogo.png" alt="hai">
						</a>
					</div>

					<!-- <div class="kata " style="color: white; font-size: 20px;">
						Badminton Kuy
					</div> -->
				</div>

				<div class="col-md-5 col-xs-12" style="margin-top: 17px; margin-left: 20px;">
					<div class="header-search">
						<form action="" method="post">
							<select class="input-select" name="category">
								<option value="0">All Categories</option>
								<option value="1">Rackets</option>
								<option value="2">Shoes</option>
								<option value="3">Shuttlecocks</option>
								<option value="4">Nets</option>
							</select>
							<input class="input" name="itemname" placeholder="Search here">
							<button class="search-btn" name="search">Search</button>
						</form>
					</div>
				</div>

				<div class="col-md-3 col-xs-12" style="margin-top: 20px; float: right;">
					<form action="" method="post">
						<?php
						if (isset($_SESSION['user'])) {
							echo "<button class='btn btn-danger' name='logout'>Logout</button>";
						} else {
							echo "<button class='btn'><a href='login.php'>Sign in</a></button>";
						}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
	</header>

	<div class="section col-md-12 col-xs-6" style=" background-image: url(../img/catalog.jpg); background-size: cover; background-repeat: no-repeat; height: 700px; display: flex; align-items: center; justify-content:center;">
		<div class="row col-xl-12" style="flex-wrap: wrap; width: 100%; height: 100px;  display: flex; ">
			<div class="col-lg-12 col-md-12 col-xs-6" style="font-weight: 500; color: white; margin-top: -200px; font-size: 50px; ">
				<span>MAKE YOU </span>
				<br>
				<span>BE THE CHAMPION</span>
			</div>
			
			<div class="COL-lg-12 col-md-12 col-xs-6">
			<form action="" method="POST">
				<button name="catalogg"  class="" style="width:200px; height: 10vh; border-radius: 10px; padding: 10px; background-color: transparent; border: 4px solid white;"> <span style="color: white;font-weight: 500; text-transform: uppercase; font-size: 20px;">Shop Now</span></button>
			</form>
			</div>

		</div>
	</div>

	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- shop -->
				<div class="col-md-3 col-xs-6">
					<div class="product" id="rackets">
						<div class="product-img">
							<img src="../img/raket.jpg" alt="">
						</div>

						<div class="product-body">
							<p class="product-category">Category</p>
							<h3 class="product-name">Rackets</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</div> -->
						</div>
					</div>
				</div>
				<!-- /shop -->
				<div class="col-md-3 col-xs-6">
					<div class="product" id="shoes">
						<div class="product-img">
							<img src="../img/sepatu.jpg" alt="">
						</div>

						<div class="product-body">
							<p class="product-category">Category</p>
							<h3 class="product-name">Shoes</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</div> -->
						</div>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="product" id="cocks">
						<div class="product-img">
							<img src="../img/cocks.jpg" alt="">
						</div>

						<div class="product-body">
							<p class="product-category">Category</p>
							<h3 class="product-name">Shuttlecocks</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</div> -->
						</div>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
					<div class="product" id="nets">
						<div class="product-img">
							<img src="../img/nets.jpg" alt="">
						</div>

						<div class="product-body">
							<p class="product-category">Category</p>
							<h3 class="product-name">Nets</h3>
							<!-- <div class="product-rating">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</div> -->
						</div>
					</div>
				</div>
				<!-- shop -->

			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /SECTION -->


	<section>
		<div class="container">
			<div class="newsletter">

			</div>
			<h1>About Badminton Kuy</h1>
			Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque rem exercitationem debitis tempora laboriosam doloribus sit voluptates facere neque deleniti quos facilis iure reiciendis libero quod tenetur, magnam omnis ratione labore? Quam itaque architecto autem quis molestiae nesciunt. Magni eveniet voluptatibus quaerat aperiam voluptatum asperiores iusto beatae quisquam, sequi placeat quibusdam voluptate veniam animi illum? Beatae porro perspiciatis exercitationem. Non.
		</div>
	</section>
	<br>
	<section>
		<div class="newsletter">
			<h1 style="text-align:center;">Follow Us Now!!!</h1>
			<ul class="newsletter-follow">
				<li>
					<a href="#"><i class="fa fa-facebook"></i></a>
				</li>
				<li>
					<a href="#"><i class="fa fa-twitter"></i></a>
				</li>
				<li>
					<a href="#"><i class="fa fa-instagram"></i></a>
				</li>
				<li>
					<a href="#"><i class="fa fa-pinterest"></i></a>
				</li>
			</ul>
		</div>
	</section>
	<br><br><br><br><br>

	<footer>
		<!-- bottom footer -->
		<div id="bottom-footer" class="section">
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12 text-center">
						<span class="copyright" style="color: white;">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy;<script>
								document.write(new Date().getFullYear());
							</script> All rights reserved
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</span>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
	</footer>
	<script src="js/jquery.min.js"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script> -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		$(() => {
			$("#rackets").on("click", function() {
				window.location.href = 'search.php?category=Rackets';
			});
			$("#shoes").on("click", function() {
				window.location.href = 'search.php?category=Shoes';
			});
			$("#cocks").on("click", function() {
				window.location.href = 'search.php?category=Shuttlecocks';
			});
			$("#nets").on("click", function() {
				window.location.href = 'search.php?category=Nets';
			});
		});
	</script>
</body>

</html>
<?php
ob_start();
session_start();?>

<!DOCTYPE html>
<html lang="en">

<?php
  $homepage="index.php";
  // get the current file name
  $pagename= basename($_SERVER['PHP_SELF']);
  // check wheather current page is index.php or not
  if ($homepage == $pagename) {
			// echo $pagename;
  }   ?>
  
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>ICReAcH 2022</title>
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- Bootstrap 4.5 CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Style CSS -->
	<link rel="stylesheet" href="css/style.css">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap" rel="stylesheet">
	<!-- Box Icon -->
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
	<!-- Font Awesome  -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<script src="js/jquery-3.5.1.min.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-6257NN34QE"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', 'G-6257NN34QE');
	</script>
</head>
<body>

	<!-- Start Top bar with logo  -->

<div class="container-fluid" id="head">
	<div class="row row-brand">
		<div class=" brand-text"><h5>Organised by</h5>
			<a href="" class="navbar-brand"><img src="img/logo/igcarlogo.png" alt=""><br><span class="brand-text d-block mx-auto">IGCAR</span></a>
			<a href="" class="navbar-brand"><img src="img/logo/mrsilogo.png" alt=""><br><span class="brand-text d-block mx-auto">MRSI</span></a>
		</div>
		<div class=" topbar-title mx-auto text-center">
			<p class="topbar-head py-0 my-0"> ICReAcH 2022</p>
			<p class="py-0 my-0 topbar-text">International Conference on Recent Advances<br>in High Pressure Science and Technology</p>
			<p class="py-0 my-0 topbar-date">February, 8 - 10, 2022</p>
		</div>
		<div class=" brand-text">
		<a href="index.php" class="navbar-brand"><img class="icreach-logo" src="img/logo/icreachlogo.png" alt=""><br><span class="brand-text text-center">ICReAcH</span></a>
		</div>
	</div>
</div>

<!-- FLOATING MENU - START -->

<?php  /*
if (($pagename == "igcarglance.php") || ($pagename == "userstatus.php") || ($pagename == "registrationreport.php")) {
	// No Action
} else {
	?>

					<nav class="floating-menu">
						<h3>Quick links</h3>
				
						<?php 
						if (isset($_SESSION['uid'])){
							echo '<a href="abstractupload.php">Submit Manuscript</a>';
							echo '<a href="contactinformation.php">Update Contact</a>';
							echo '<a href="paymentdetails.php">Update Payment</a>';
							echo '<a href="logout.php">Logout</a> ';
						} else {
							echo '<a href="signup.php">Sign up</a> ';
							echo '<a href="importantdates.php">Important Dates</a>';
							echo '<a href="login.php">Submit Manuscript</a>';
							}
						?> 
					</nav>

<?php }  */ ?>


  <!-- FLOATING MENU - END -->

<!-- End Top bar with logo -->
<?php include 'menu.php'; ?>
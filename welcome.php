<?php include 'includes/header.php'; ?>
<?php

?>
<!-- Main Page Heading -->

<div class="mar-top40">&nbsp;</div>
<div class="mar-top20">&nbsp;</div>

<div class="section-header mar-bot30">
  <h2 class="section-heading animated" data-animation="bounceInUp">ICONS 2023 - Registration</h2>
</div>

<div class="col-12 text-center mt-3">
	<h3 class="text-dark pt-1">
		Welcome to <span style="color:blue"><b>ICONS 2023</b></span>
	</h3>
	<div class="border-top border-primary w-25 mx-auto my-3"></div>
	<!-- <p class="lead">For all of the Champions in the world.</p> -->
	<div class="p w-75 text-center mx-auto">
		<p>You have registered with the email id : <B><?php echo $_SESSION['ru_email']; ?></b></p>
<p>Your ICONS 2023 Id is : <b><?php echo $_SESSION['user_icons_id']; ?></b></p>
		<p>You will have to login to the website using the above email id and password<br>you provided during registration. <br>
			Once logged in, kindly update your contact information.</p>
			
		<p class="mar-top30"><b><a href="login.php"><mark class="mark1">Click here to Login</mark></a></b></p>
		<?php //header("Refresh:8; url=login.php"); ?>
	</div>
</div>
<br><br>
<?php include 'includes/footer.php'; ?>

<?php include 'includes/script.php'; ?>
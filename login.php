<?php include 'includes/header.php'; ?>


<div class="mar-top40">&nbsp;</div>
<div class="mar-top20">&nbsp;</div>
<!-- content page -->

<div class="section-header mar-bot30">
	<h2 class="section-heading animated" data-animation="bounceInUp">Login</h2>
</div>


<div class="container">
	<div class="row">
		<div class="col-sm-4">

		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-body">
					<form method="post">

						<h5 id="success" style="color:green;text-align:center"></h5>
						<h5 id="error" style="color:red;text-align:center"></h5>
						<fieldset class="form-group">
							<label for="">Email ID</label>
							<input type="email" name="lg_email" maxlength="150" class="form-control" id="" placeholder="Enter Your E-Mail" required>
						</fieldset>
						<fieldset class="form-group">
							<label for="">Password</label>
							<input type="password" name="lg_password" class="form-control" id="" placeholder="Password" minlength="6" required>
						</fieldset>
						<!--	<div class="g-recaptcha" data-sitekey="6LdTYBkUAAAAAGkaMmQwQxL9kCSZDOSva50FrQe-"></div><br/> -->
						<div class="row">
							<div class="col-sm-4">

							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<button type="submit" class="btn btn-primary" name="sublogin" id="sublogin">Login</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="mar-left10 pull-left">
								<p><a href="forgotpassword.php" style="color:#041554;"><b>Forgot Password?</b></a></p>
							</div>
							<!-- <div class="mar-right10 pull-right">
								<p><b><a href="signup.php">Sign-up Here.</a></b></p>
							</div> -->
						</div>

						<!-- <div class="row">
								<div class="mx-auto">
								<small><a href="verifyotp.php" style="color:#041554;text-align:center!important"><mark class="mark2">Verify OTP</mark></a></small>
								</div>
							</div> -->

						<hr class="hr-blue">
						Note:<br />
						<p class="form-group text-center">If you have any issues in signing up, logging in or during submission of Manuscript, please send a brief description of the issue to <a href="mailto:webteam.icons2023@gmail.com"><b>webteam.icons2023@gmail.com</b></a> with your contact details. Our web team will assist you in resolving the issue.</p>


					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
require('includes/connection.php');
// If form submitted, insert values into the database.
if (isset($_POST['lg_email'])) {
	$email    = $_POST['lg_email'];
	$password = md5($_POST['lg_password']);
	//  $epass=base64_encode($password);
	$active   = "1";

	//Checking is user existing in the database or not
	$query = "SELECT * FROM user_table WHERE ru_userid='" . $email . "' and ru_password='" . $password . "' and ru_active='" . $active . "'";

	// echo $query;
	// exit(0);

	$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) == 1) {
		if ($row['ru_verify_status'] == 1) {

			//  moving values to session
			//  $_SESSION['email'] = $email;
			$_SESSION['uid']		  = $row['ru_id'];
			$_SESSION['user_id']	= $row['ru_userid'];
			$_SESSION['icid'] 	= $row['ic_id'];
			$_SESSION['category'] = $row['ru_category'];

			// Redirect user to submitabstract.php
			echo '<script>document.getElementById("success").innerHTML = "Login successful. Redirecting...";</script>';

			//header("Location:http://kavilashtechnologies.in/emsidemo/authorinfo.php");
			echo '<meta http-equiv="Refresh" content="0; url=contactinformation.php">';
			//exit(0);
		} else {
			echo '<script>document.getElementById("error").innerHTML = "Email Verification Pending!";</script>';
		}
	} else {
		//   echo "Username/password is incorrect.";
		echo '<script>document.getElementById("error").innerHTML = "Username/Password is incorrect.";</script>';
	}
}

?>
<!-- footer -->
<?php include 'includes/footer.php'; ?>
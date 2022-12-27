<?php include 'includes/header.php'; ?>



<!-- content page -->

<div class="col-12 text-center mt-2">
	<h2 class="text-dark pt-1">
		Login
	</h2>
	<!-- <div class="border-top border-primary mx-auto my-3"></div> -->
	<!-- <p class="lead">For all of the Champions in the world.</p> -->

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
								<input type="password" name="lg_password" class="form-control" id="" placeholder="Password" minlength="6"  required>
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
								<div class="mr-auto">
									<p><small><a href="forgotpassword.php" style="color:#041554;"><b>Forgot Password?</b></a></small></p>
								</div>
								<div class="ml-auto">
								<p><small><b>Register Here.</b></small></p>
								</div>
							</div>

							<!-- <div class="row">
								<div class="mx-auto">
								<small><a href="verifyotp.php" style="color:#041554;text-align:center!important"><mark class="mark2">Verify OTP</mark></a></small>
								</div>
							</div> -->
							

							Note:<br/>
							<p class="form-group small text-center">If you have any issues in logging in or during submission of Manuscript, please send a brief description of the issue to <a href="mailto:icreach2022@igcar.gov.in"><b>icreach2022@igcar.gov.in</b></a> with your contact details. Our web team will assist you in resolving the issue.</p>


						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
require('includes/connection.php');
// If form submitted, insert values into the database.
if (isset($_POST['lg_email']))
{
	$email    = $_POST['lg_email'];
	$password = md5($_POST['lg_password']);
	//  $epass=base64_encode($password);
	$active   ="1";

	//Checking is user existing in the database or not
	$query = "SELECT * FROM icr_user_table WHERE ru_userid='".$email."' and ru_password='".$password."' and ru_active='".$active."'";
	
	// echo $query;
	// exit(0);

	$result = mysqli_query($connection,$query) or die(mysqli_error($connection));
	$row = mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result) == 1)
		{
			if ($row['ru_verify_status'] == 1) {
	
				//  moving values to session
				//  $_SESSION['email'] = $email;
				$_SESSION['uid']		  = $row['ru_id'];
				$_SESSION['user_id']	= $row['ru_userid'];
				$_SESSION['icrid'] 	= $row['icr_id'];
				$_SESSION['category'] = $row['ru_category'];
		
				// Redirect user to submitabstract.php
				echo'<script>document.getElementById("success").innerHTML = "Login successful. Redirecting...";</script>';
		
				//header("Location:http://kavilashtechnologies.in/emsidemo/authorinfo.php");
				echo '<meta http-equiv="Refresh" content="0; url=contactinformation.php">';
				//exit(0);
			} else {
					echo'<script>document.getElementById("error").innerHTML = "Email Verification Pending!";</script>'; 
				   }
		
		}else{
			//   echo "Username/password is incorrect.";
			echo'<script>document.getElementById("error").innerHTML = "Username/Password is incorrect.";</script>';
			 }
}

?>
<!-- footer -->
<?php include 'includes/footer.php'; ?>

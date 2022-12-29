<?php 
// session_start();
include 'includes/header.php'; 
require('includes/connection.php');  // get db connection

$errorMessage = '';
if(!empty($_POST["authenticate"]) && $_POST["otp"]!='') {
	$sqlQuery = "SELECT * FROM authentication WHERE otp='". $_POST["otp"]."' AND expired != 1"; //AND NOW() <= DATE_ADD(created, INTERVAL 1 HOUR)";

	$result = mysqli_query($connection, $sqlQuery);
	$count = mysqli_num_rows($result);
	if(!empty($count)) {
    //Correct OTP
		$sqlUpdate = "UPDATE authentication SET expired = 1 WHERE otp = '" . $_POST["otp"] . "'";
		$result = mysqli_query($connection, $sqlUpdate);
    //Update Verification Status
    $ru_email = $_SESSION['ru_email'];
    $active="1";
    $sqlUpdate="UPDATE user_table set ru_active='".$active."',ru_verify_status='".$active."' where ru_userid='".$ru_email."'";
    $result = mysqli_query($connection, $sqlUpdate);
    if (mysqli_affected_rows($connection) == 1){

// TODO : move ID to session. Trigger welcome email.
	$sqlID="SELECT ic_id from user_table where ru_userid='".$ru_email."'";
	$resultid = mysqli_query($connection, $sqlID);
	if (mysqli_affected_rows($connection) == 1){
		$row = $resultid->fetch_assoc();
		$_SESSION['user_icons_id'] = $row['ic_id'];
	}


      header("Location:welcome.php");
    } else {
      echo "ERROR Updating OTP. Contact Administrator";
      exit(0);
    }
    
		
	} else {
    //Incorrect OTP
		$errorMessage = "Invalid OTP!";
	}	
} else if(!empty($_POST["otp"])){
	$errorMessage = "Enter OTP!";	
}	
?>

<div class="col-12 text-center mt-3">
	<h2 class="text-dark pt-1">
		OTP Verification
	</h2>
	<div class="p w-75 text-center mx-auto">
		<p>Check your email for OTP. <br><span style="color:red;font-size:12px;">Check in the SPAM folder too.</span></p>
	</div>
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
              <?php if ($errorMessage != '') { ?>
                 <div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>
              <?php } ?>
							<fieldset class="form-group">
								<label for="">Enter OTP</label>
                <!-- <input type="text" class="form-control" id="otp" name="otp" placeholder="One Time Password"> -->
								<input type="text" class="form-control" id="otp" name="otp" placeholder="One Time Password" required>
							</fieldset>
							<div class="row">
								<div class="col-sm-4">

								</div>
								<div class="col-sm-4">
									<div class="form-group">
                    <!-- <input type="submit" name="authenticate" value="Submit" class="btn btn-success"> -->
									  <input type="submit" name="authenticate" value="Submit" class="btn btn-primary">
									</div>
								</div>
							</div>
							<!-- <div class="row">
								<div class="mr-auto">
									<p><small><a href="forgotpassword.php" style="color:#041554;"><b>Forgot Password?</b></a></small></p>
								</div>
								<div class="ml-auto">
								<p><small><a href="signup.php" style="color:#041554;text-align:right"><b>Register Here.</b></a></small></p>
								</div>
							</div> -->

							Note: 
							<p class="form-group small text-center">If you have any issues in signing in, please send a brief description of the issue to <a href="mailto:contact@icons2023.com">contact@icons2023.com</a> with your contact details. Our web team will assist you in resolving the issue.</p>


						</form>
					</div>
				</div>
			</div>
		</div>
	</div>




<!-- <div class="container">
  <div class="col-md-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="panel-title">Enter OTP</div>
      </div>
      <div style="padding-top:30px" class="panel-body">
        <?php // if ($errorMessage != '') { ?>
          <div id="login-alert" class="alert alert-danger col-sm-12"><?php // echo $errorMessage; ?></div>
        <?php // } ?>
        <form id="authenticateform" class="form-horizontal" role="form" method="POST" action="">
          <div style="margin-bottom: 25px" class="input-group">
            <label class="text-success">Check your email for OTP</label>
            <input type="text" class="form-control" id="otp" name="otp" placeholder="One Time Password">
          </div>
          <div style="margin-top:10px" class="form-group">
            <div class="col-sm-12 controls">
              <input type="submit" name="authenticate" value="Submit" class="btn btn-success">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> -->



<!-- footer flie -->
<?php include 'includes/footer.php'; ?>
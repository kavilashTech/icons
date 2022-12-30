<?php include 'includes/header.php'; ?>


<div class="mar-top40">&nbsp;</div>
<div class="mar-top20">&nbsp;</div>
<!-- content page -->

<div class="section-header mar-bot30">
  <h2 class="section-heading animated" data-animation="bounceInUp">Reset Password</h2>
</div>



<!-- Main Page Heading -->
<div class="container">
  <div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <form method="post" role="form">
            <fieldset class="form-group">
              <label for="">Enter New Password</label>
              <input type="hidden" value="<?php echo $_REQUEST['em']; ?>" id="em" name="em" />
              <input type="Password" name="npassword" class="form-control" id="npassword" placeholder="Password" required>
            </fieldset>

            <fieldset class="form-group">
              <label for="">Confirm Password</label>
              <input type="Password" name="rnpassword" class="form-control" id="rnpassword" placeholder="Confirm Password" required>
            </fieldset>
            <div class="row">
              <div class="col-sm-4">
              </div>
              <div class="col-sm-4">
                <button type="submit" name="psreset" class="btn btn-cta">Reset Password</button>
              </div>
            </div>
            <h5 id="error" style="color:red;text-align:center"></h5>
            <h5 id="success" style="color:green;text-align:center"></h5>
          </form>
        </div>
      </div>

      <?php
      require('includes/connection.php');
      // get email id
      if (isset($_REQUEST['psreset'])) {
        $password = $_REQUEST['npassword'];
        $rpassword = $_REQUEST['rnpassword'];
        // $reid=base64_decode($_REQUEST['em']);
        // $reemail = base64_decode($_REQUEST['em']);
        $reemail = $_REQUEST['em'];


        if ($password == $rpassword) {
          $updsql = "UPDATE user_table SET ru_password=md5('$password') WHERE ru_userid='$reemail'";
          if (mysqli_query($connection, $updsql)) {
            echo '<script>document.getElementById("success").innerHTML = "Password has been changed successfully. Please login. ";
								  </script>
									 ';
            echo '<meta http-equiv="Refresh" content="3; url=login.php">';
          } else {
            echo "Error updating record: Please contact Administrator. <BR>" . mysqli_error($connection);
          }
        } else {

          echo '<script>document.getElementById("error").innerHTML = "Password does not match";</script>';
        }
      }
      ?>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <div class="clearfix">&nbsp;</div>
      <br>
    </div>
  </div>
</div>

<!-- footer -->
<?php include 'includes/footer.php'; ?>
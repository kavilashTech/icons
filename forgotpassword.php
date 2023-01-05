<?php 
    include 'includes/header.php'; 
    include 'includes/menu.php'; 
?>



<div class="mar-top40">&nbsp;</div>
<div class="mar-top20">&nbsp;</div>
<!-- content page -->

<div class="section-header mar-bot30">
  <h2 class="section-heading animated" data-animation="bounceInUp">Forgot Password</h2>
</div>


<div class="container">
  <div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <form method="post" role="form">
            <fieldset class="form-group">
              <label for="">Email ID</label>
              <input type="email" name="forgotpassword" class="form-control" id="" placeholder="Enter Your E-Mail" required>
            </fieldset>
            <div align="center">
              <button type="submit" class="btn btn-cta " style="color:white;width:40%">Send</button>
              <a href="index.php" class=" btn btn-cancel" style="color:white;width:40%">Cancel</a>
            </div>
            <div align="center">
              <BR>
              <a href="login.php">Go back to Login!</a>
            </div>
            <h5 id="success" style="color:green;text-align:center"></h5>
            <h5 id="error" style="color:red;text-align:center"></h5>
          </form>
        </div>
      </div>


      <?php
      require('includes/connection.php');
      require('emailheaders.php');
      // get email id
      if (isset($_POST['forgotpassword'])) {
        $forgot = $_POST['forgotpassword'];
        $active = "1";
        // check the db base
        $query = "SELECT * FROM user_table WHERE ru_userid='" . $forgot . "' and ru_active='" . $active . "'";
        $result = mysqli_query($connection, $query);
        //echo $query;
        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $to=$row['ru_userid'];
  
          // START Email new Code ------------------------------------

          // $phpemail = new PHPMailer(true);

          // Sender info 
          // TODO From email id and Reply To - to be updated
          $phpemail->setFrom('sender@example.com', 'SenderName');
          $phpemail->addReplyTo('reply@example.com', 'SenderName');

          // Add a recipient 
          // $phpemail->addAddress('sampathraj.mp@gmail.com');
          $phpemail->addAddress("$to");

          //$phpemail->addCC('cc@example.com'); 
          //$phpemail->addBCC('bcc@example.com'); 

          // Set email format to HTML 
          $phpemail->isHTML(true);

          //embedded image
          // $phpemail->AddEmbeddedImage("/img/mail/img1.jpg", "mahabs", "Mahabs");

          // Set content-type header for sending HTML email 
          // TODO Check these lines
          // $headers = "MIME-Version: 1.0" . "\r\n"; 
          // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

          // Mail subject 
          $phpemail->Subject = 'ICONS 2023 - Password Reset';

          // ---------- Start Email MEssage using Template -------- //
          $variables = array();

          // To replace the path for images

          $variables['imgpath'] = SITE_URL;
          $variables['resetURL'] = SITE_URL.'resetpassword.php?em='. $to;
          // echo SITE_URL . "<BR>";

          //  echo $variables['resetURL'];

          $template = file_get_contents("templates/resetpasswordtemplate.html");

          foreach ($variables as $key => $value) {
            $template = str_replace('{{ ' . $key . ' }}', $value, $template);
          }

          // Mail body content 
          $phpemail->Body    = $template;

          // $message = $template;
          //        echo $template;
          // exit(0);
          // ---------- End Email MEssage using Template -------- //

          // Send email 
          if (!$phpemail->send()) {
            // Mail Failed.
            echo '<script>document.getElementById("error").innerHTML = "Password Reset Failed. Please contact Administrator.";</script>';
            // echo 'Message could not be sent. Mailer Error: ' . $phpemail->ErrorInfo;
          } else {
            //mail sent successfully, proceed with process.
            // header("Location:verify.php");
            echo '<script>document.getElementById("success").innerHTML = "Email sent to reset your password.</b> Please check your <B>SPAM FOLDER</B>";</script>';
          }
          // END email new code ---------------------------------------  

        } else {
          echo '<script>document.getElementById("error").innerHTML = "You are not a Registered User";</script>';
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
<?php include 'includes/script.php'; ?>
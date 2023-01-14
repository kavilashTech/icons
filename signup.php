<?php

use PHPMailer\PHPMailer\PHPMailer;

    include 'includes/header.php'; 
    include 'includes/menu.php'; 
?>

<script type="text/javascript">
  function testFunction() {
    //alert("test");
    var answer = document.getElementById("testQuestionA").value;
    if (answer == 20) {
      //alert('true');
      return true;
      //document.getElementById("formsignup").submit();
    }
    document.getElementById("error").innerHTML = 'Incorrect Information';
    return false;

  }
</script>
<div class="mar-top40">&nbsp;</div>
<div class="mar-top20">&nbsp;</div>
<!-- content page -->

<div class="section-header mar-bot30">
  <h2 class="section-heading animated" data-animation="bounceInUp">ICONS 2023 - Sign Up</h2>
</div>


<div class="container">
  <!-- <h3 style="text-align:center; color:red;">
    <br />
    Registration opens on January 01, 2023.<br /><br />
  </h3> -->


  <div class="container" style="max-width:420px">
    <div class="row">
      <div class="panel panel-default">
        <div class="panel-body">
          <form id="formsignup" role="form" method="post" action="signup.php" onsubmit="return testFunction();">
            <div id="success" style="color:green;text-align:center; font-size:12px;"></div> <br>
            <div id="error" style="color:red;text-align:center;font-size:12px;"></div>

            <div class="form-group">
              <label class="control-label" for="signupEmail">Email ID</label>
              <input id="" name="ru_email" type="email" maxlength="50" class="form-control" placeholder="Enter Your E-Mail" required>
            </div>

            <div class="form-group">
              <label class="control-label" for="signupPassword">Password</label>
              <input id="signupPassword" name="ru_password" type="password" minlength="6" maxlength="25" class="form-control" placeholder="At least 6 characters" required>
            </div>
            <div class="form-group">
              <label class="control-label" for="testQuestion">12 + 8 =</label>
              <input id="testQuestionA" name="testQuestionA" type="text" minlength="2" maxlength="20" class="form-control" placeholder="Enter Answer" required>
              <label id="helptestquestion" style="font-size:12px">Let us know you are not a ROBOT!</label>
            </div>
            <!-- <div class="g-recaptcha" data-sitekey="6Lex9RIUAAAAAKTF27FOxb1PCWk-noAq7aLnCCLv"></div> 
						   <div class="g-recaptcha" data-sitekey="6LdTYBkUAAAAAGkaMmQwQxL9kCSZDOSva50FrQe-"></div> -->

            <div class="row">
              <div class="mx-auto">
                <input type="submit" class="btn btn-cta pull-right mar-right10 mar-bot20" name="subregister" id="subregister" value="Register">
              </div>
            </div>

            <p class="form-group small text-center">By creating an account, you are agreeing to abide by the conference rules.</p>
            <!-- <p class="form-group small text-center">By creating an account, you are agreeing to our <a href="">Terms of Use</a> and our <a href="">Privacy Policy</a>.</p> -->
            <hr>
            <p class="form-group small text-center">Already have an account? <a href="login.php">Login</a></p>
            <p class="form-group small text-center">Forgot your password? <a href="forgotpassword.php">Forgot Password</a></p>
          </form>

          <br>
        </div>

      </div>
    </div>
  </div>
</div>

<?php
include "includes/connection.php";

if (isset($_POST['ru_email'])) {
  // getting form values
  $ru_email = $_POST['ru_email'];
  $ru_password = $_POST['ru_password'];


  // check wether the email id exists or not
  $sql = "SELECT * FROM user_table WHERE ru_userid='" . $ru_email . "'";
  $result = mysqli_query($connection, $sql);

  //  echo $sql;
  //  exit(0);

  if (mysqli_num_rows($result) > 0) {
    //User email exists. Show error message.
    echo '<script>document.getElementById("error").innerHTML = "Email ID is already Signed up. Please Login or use Forgot Password.";</script>';
  } else {
    // User does not exist. Create new record.
    $ru_reg = "INSERT into user_table (ru_userid,ru_password,ru_verify_status,ru_category,ru_active) VALUES ('$ru_email',md5('$ru_password'),0,'U',0)";
    //echo $ru_reg;
    //exit(0);
    $ins_sql = mysqli_query($connection, $ru_reg);

    // if ($ins_sql) {
    $last_id = mysqli_insert_id($connection);

    //  echo $ic_id="ic202200".$last_id;
    $idcount = strlen((string)$last_id);
    switch ($idcount) {
        // case '4':
        //   $ic_id = "IC2022" . $last_id;
        //   break;
      case '3':
        $ic_id = "IC2023" . $last_id;
        break;
      case '2':
        $ic_id = "IC20230" . $last_id;
        break;
      case '1':
        $ic_id = "IC202300" . $last_id;
        break;
      default:
        $ic_id = "IC2023000" . $last_id;
        break;
    }
    // echo 'ic ID : ' , $ic_id , '  ';
    //  update the ic id
    $sql = "UPDATE user_table SET ic_id='" . $ic_id . "' WHERE ru_id='" . $last_id . "'";

    if (mysqli_query($connection, $sql)) {


      require('emailheaders.php');

      //Create otp as random number
      $otp = rand(100000, 999999);


      // START Email new Code ------------------------------------

      // $phpemail = new PHPMailer(true);

      // Sender info 
      // TODO From email id and Reply To - to be updated
      $phpemail->setFrom('icons@igcar.gov.in', 'ICONS 2023');
      $phpemail->addReplyTo('icons@igcar.gov.in', 'ICONS 2023');

      // Add a recipient 
      $phpemail->addAddress($ru_email);
      // $phpemail->addAddress('sampathraj.mp@gmail.com');

      // $phpemail->addCC('sampathraj.mp@gmail.com'); 
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
      $phpemail->Subject = 'ICONS 2023 Registration - OTP verification';



      // ---------- Start Email MEssage using Template -------- //
      // $message = 'OTP = ' . $otp . '<BR>';

      // echo "message : " . $message;
      // echo "<BR> site url : " . SITE_URL;
      // exit(0);

      $variables = array();

      $variables['otp'] = $otp;
      $variables['imgpath'] = SITE_URL;
      // echo $variables['imgpath'];

      $template = file_get_contents("templates/otpemailtemplate.html");

      foreach ($variables as $key => $value) {
        $template = str_replace('{{ ' . $key . ' }}', $value, $template);
      }

      // Mail body content 
      // $bodyContent = '<h1>How to Send Email from Localhost using PHP by CodexWorld</h1>';
      // $bodyContent .= '<p>This HTML email is sent from the localhost server using PHP by <b>CodexWorld</b></p>';
      $phpemail->Body    = $template;


      // $message = $template;
      //        echo $template;
      // exit(0);
      // ---------- End Email MEssage using Template -------- //

      // Send email 
      if (!$phpemail->send()) {
                // Mail Failed.
                echo "Could not send email. Please contact Administrator.";
        // echo 'Message could not be sent. Mailer Error: ' . $phpemail->ErrorInfo;
      } else {
        //mail sent successfully, proceed with process.
        $insertQuery = "INSERT INTO authentication(otp,	expired, created) VALUES ('" . $otp . "', 0, '" . date("Y-m-d H:i:s") . "')";
        // echo $insertQuery . "   " . $otp;
        // exit(0);
        $result = mysqli_query($connection, $insertQuery);
        $insertID = mysqli_insert_id($connection);
        if (!empty($insertID)) {
          $_SESSION['ru_email'] = $ru_email;
          header("Location:verify.php");
        // echo 'Message has been sent.';
      } else {
        //Authentication OTP insert failed.
        echo '<script>document.getElementById("success").innerHTML = "<span style=\x22color:red\x22>OTP Failed.";</script>';
      }
      echo '<script>document.getElementById("success").innerHTML = "<span style=\x22color:red\x22>Verification email sent. <b>ACTIVATE your account by clicking on the VERIFY Link in the email.</b> Please check your <B>SPAM FOLDER</B>.</span>";</script>';
    } 
      // END email new code ---------------------------------------    
    
  } else {
      //Update of IC ID Failed
      echo "Could not update Database. Please contact Administrator."; // . mysqli_error($connection);
    }
  }
}

?>

<?php include 'includes/footer.php'; ?>
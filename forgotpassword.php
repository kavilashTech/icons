<?php include 'includes/header.php'; ?>



<div class="mar-top40">&nbsp;</div>
<div class="mar-top20">&nbsp;</div>
<!-- content page -->

<div class="section-header mar-bot30">
	<h2 class="section-heading animated" data-animation="bounceInUp">Forgot Password</h2>
</div>


<div class="container">
	<div class="container-fluid">
    <!-- Main Page Heading -->
    <!-- <div class="col-12 text-center mt-3">
      <h2 class="text-dark pt-1">
        Forgot Password
      </h2>
      <div class="border-top border-primary w-25 mx-auto my-3"></div> -->
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
                                <button type="submit" class="btn btn-primary" style="color:white;width:40%">Send</button>
	                            <a href="index.php" class=" btn btn-primary" style="color:white;width:40%">Cancel</a>
                                </div>
                                <div align="center">
                                <BR>
                                <a href="login.php">Go back to Login!</a>
                                </div>
                          <h5 id="message" style="color:green;text-align:center"></h5>
						   <h5 id="error" style="color:red;text-align:center"></h5>
                        </form>
                     </div>
                   </div>

				   
                  <?php
                   require('includes/connection.php');
				   require ('emailheaders.php');
                   // get email id
                       if (isset($_POST['forgotpassword']))
                       {
                          $forgot=$_POST['forgotpassword'];
                         $active="1";
                         // check the db base
                         $query="SELECT * FROM user_table WHERE ru_userid='".$forgot."' and ru_active='".$active."'";
                         $result=mysqli_query($connection,$query);
//echo $query;
                        if (mysqli_num_rows($result) > 0)
                        {

                          // TODO : Update phpmailer based email.
                            // output data of each row
							$replyto = "contact@icreach2022.com";
							$row = mysqli_fetch_assoc($result);
							
                            $usermail= base64_encode($row['ru_userid']);
                            $to=$row['ru_userid'];
                            $subject="ICREACH 2022 - Reset Password";
						   
							$headers  = "From: ICREACH 2022 <contact@icreach2022.com>\r\n";     
							$headers .= "Reply-To: $replyto \r\n"; //message header
							$headers .= 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= "Return-Path: $replyto\r\n";
							$headers .= "X-Mailer: PHP \r\n";
							
							 $message = '
							   <!DOCTYPE html>
<html lang="en">
<head>
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style media="screen">
    #header{
      background-image: url(img/subheadimg.jpg);
      background-size: cover;
    }
    #header p{
      font-size: 35px;
	  font-weight:bold;
      color:#fff;
      text-align: center;
      padding-top: 20px;
    }
    .footer{
      background-color:#000033;
      color:#fff;
      text-align: center;
      margin: 0px;
      padding: 0px;
    }
    #mail p{

    }
    #mail h5{

    }
    .container{
      margin-left: 20px;
      margin-right: 20px;

    }
    body{
      margin:25px;
    }
	.button {
    //background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
	
}
  </style>
</head>

<body>
  <div class="container" style="padding-left:20%;padding-right:20%">
   <!-- Header image - START -->
    <div class="container" id="header" style=" ">
      <div class="row">
        <div class="col-xs-2">
          <p>&nbsp;</p>
        </div>
        <div class="col-xs-8">
          
        </div>
        <div class="col-xs-2">
          <p>&nbsp;</p>
        </div>
      </div>
    </div>
   <!-- Header image - END -->
	
    <div class="container" id="mail" style="">
          <p style="font-size:24px;color:#000;text-align:center"><b>Reset Password</b></p>
          <form style="width:100%;">
          <div class="form-group">
            <label for="">Please use the below link to reset your ICREACH 2022 Conference account password:</label>
          </div><br/>
          <div class="form-group" style="text-align:center">
		 <a href="'.SITE_URL.'resetpassword.php?em='. $usermail.'" style="color:red; font-weight:bold;" >RESET MY PASSWORD!</a>
		</div>
		<br/>
</form>
  <p style="font-size:15px">Best regards,</p>
  <p style="font-size:15px">ICREACH 2022 Team</p>
 
</div>
<div class="container footer">
<p class="footer">Copyrights ICREACH 2022 (2021-22). All rights reserved.</p> </div> </div>


<!-- jQuery first, then Bootstrap JS. --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"> </script> </body>

</html>

							   
							   ';
	
							   
							   mail($to, $subject, $message, $headers);
							    echo'<script>document.getElementById("message").innerHTML = "Email sent to reset your password. Please check.";</script>';
								//echo $message;
                        }
                        else
                        {
							echo'<script>document.getElementById("error").innerHTML = "You are not a Registered User";</script>';
                        
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
    </div>
	</div>

    <!-- footer -->
   <?php include 'includes/footer.php'; ?>

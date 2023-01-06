<?php include 'includes/connection.php';
include 'includes/header.php';
include 'includes/menu-loggedin.php';


if (!isset($_SESSION["uid"])) {
  echo '<meta http-equiv="Refresh" content="0; url=login.php">';
  exit(0);
}
$userid = $_SESSION['uid'];
$submitBtnText = "Submit";
$userEmail = "";

// echo '<BR><BR><BR><BR><BR><BR>';
if (isset($_POST['txtSubmit'])) {
  $submitFlag = $_POST['txtSubmit'];
  //echo $submitFlag;
} else {
  $submitFlag = "";
}
?>
<!-- added by  prakash on 12-04-17 -->
<!-- start -->
<script type="text/javascript">
  $(document).ready(function() {


    $('#fileToUpload').on('change', function() {
      myfile = $(this).val();
      var ext = myfile.split('.').pop();
      if (ext == "docx" || ext == "doc") {
        //alert(ext + '  OK');
      } else {
        alert('ERROR : Only .doc and .docx are allowed.');
        document.getElementById('fileToUpload').value = '';
      }
    });


    //To set the cursor while uploading

    /*	window.addEventListener("beforeunload", function (event) {
    	  document.body.style.cursor = 'wait';
    	  setTimeout(function(){document.body.style.cursor = 'default';},3000);
    	});*/

  });

  function checkForm() {
    return true;
  }

  function ValidateSubmit() {
    //alert('into validate submit');

    if (document.getElementById("subfupload").value == "Uploading File...") {
      alert('Please Wait. File is being uploaded');
      document.getElementById("subfupload").disabled = 'true';
      return false;
    } else {
      document.getElementById("subfupload").value = 'Uploading File...';
      return true;
    }
  }
</script>
<!-- end -->



<!-- Side Nav Bar - Logged in user -->
<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<!-- Header area start -->
<div class="section-header mar-bot30">
  <h2 class="section-heading animated" data-animation="bounceInUp">Abstract Submission</h2>
</div>

<div class="col-md-8">
  <h5 id="success" class="pull-right" style="color:green;"></h5>
  <h5 id="error" class="pull-right" style="color:red;"></h5>
</div>
<!-- Header area end -->


<!-- Main content Block -->


<div class="container" id="main">
  <div class="container-fluid pt-2">
    <p style="font-size:12px">All Fields marked with <span class="red">*</span> are mandatory</p>
    <!-- <form method="post" id="form1" class="form-horizontal" action=""> -->
    <div class="row">
      <form id="abstractuploadform" method="post" enctype="multipart/form-data" onsubmit="return ValidateSubmit();">

        <!-- TODO : delete    -->
        <p class="text-center" id="message" style="color:green"></p>
        <p class="text-center" id="error" style="color:red"></p>
        <input type="hidden" id="txtSubmit" name="txtSubmit" value="">
        <!-- added by prakash on 10/04/2017 -->
        <!-- start -->
        <!-- <div class="form-group">
          <div class="form-inline">
            <label for="chk_stud_lbl">Student</label>
            <input type="checkbox" name="chk_stud" id="chk_stud" value="Student">
          </div>
        </div> -->
        <!-- end -->

        <label for="abfile_name">Abstract Title <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="abfile_name" name="abfile_name" maxlength="150" required>

        <div class="form-group required">
          <!-- <div class="form-inline"> -->
          <label for="abfile_select_t1">Select a Topic <span style="color:red;">*</span></label>
          <select class="custom-select form-control" name="abfile_select_t1" id="abfile_select_t1" required>
            <option value="">Select...</option>
            <?php
            $sql = "SELECT * FROM topics where to_active='A' ORDER BY to_id";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['to_id'] . '" >' . $row['to_topic_name'] . '</option>';
              }
            } else {
              echo "No topics found";
            }

            ?>
          </select>
          <!-- </div> -->
        </div>
        <?php
        if (isset($_POST['abfile_select_t1'])) {
          $selecttp1 = $_POST['abfile_select_t1'];
        }
        ?>


        <label for="fileToUpload">Upload your Abstract <span style="color:red;">*</span><br><span style="color:blue;font-size:12px;">(Number of characters in Filename should not exceed <b>50</b>. No Special Characters Allowed in Filename.)</span></label>
        <div class="custom-file">
          <input type="file" class=" form-control" name="fileToUpload" id="fileToUpload" style="width:100%;" accept=".doc,.docx, application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
        </div>

        <label id="FileError" for="fileToUpload" class="control-label" style="margin-left:-3%"></label>

        <div class="form-group">
          <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
              <label id="ErrMessage" style="color:red !important;font-weight:600;"></label>
              <input type="submit" class="form-control btn-primary" value=<?php echo $submitBtnText;  ?> id="subfupload" name="subfupload">
            </div>
          </div>
          <p>Note:</p>
          <ul style="list-style-type: disc;padding-left:11%;">
            <li>File format must be MS-word document(.doc /.docx)</li>
            <li>Use the Action Menu to Edit / Delete an Abstract.</li>
          </ul>
        </div>
      </form>
    </div>
    <!-- </form> -->


    <!-- Uploaded files table start -->


    <table class="table table-bordered table-striped">
      <tr style="background-color:grey;color:#fff">
        <th width="5%">S.No.</th>
        <th width="20%">Abstract Title</th>
        <th width="30%">Topic</th>
        <th>Abstract(s)</th>
        <th width="7%">Actions</th>
      </tr>
      <?php
      // select the table data
      $userid = $_SESSION['uid'];
      $sno = "1";
      // $sql = "SELECT * FROM emsi_submission where user_table_ru_id=$userid ";
      //              $sql = "SELECT sub.*, (select subtop.to_topic_name from emsi_topics as subtop where sub.su_topic1 = subtop.to_id) as topic1, (select subtop.to_topic_name from emsi_topics as subtop where sub.su_topic2 = subtop.to_id) as topic2 FROM `emsi_submission` as sub  where sub.user_table_ru_id = $userid";
      $sql = "SELECT a.*, b.* FROM submission a, topics b where a.su_topic1=b.to_id and a.user_table_ru_id=$userid";

      $result = mysqli_query($connection, $sql);
      if (mysqli_num_rows($result) > 0) {
        //Change Submit Button Text if record exists;
        $submitBtnText = "Add Abstract";
        echo '<script>document.getElementById("subfupload").value = "' . $submitBtnText . '"</script>'; //  '';
        // modified by prakash on 13-04-2017
        // start

        echo '';
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tr >
                  <td>' . $sno . '</td>
                  <td>' . $row['su_abstracttitle'] . '</td>
                  <td>' . $row['to_topic_name'] . '</td>' ?>
          <!--  CF820200001001 : IC2023001001 -->
          <td>
            <?php echo '<a href="uploads/' . $row['su_abstract_path'] . '" download="' . substr($row['su_abstract_path'], 12) . '" title="' . $row['su_abstract_path'] . '">' . substr($row['su_abstract_path'], 12) . '</a></td>';
            echo '
                  <td><a href="abstractupload-edit.php?ed=' . $row['su_id'] . '" style="color:green"><i class="fa fa-edit" title="Edit"></i></a>&nbsp;&nbsp;';
            //&nbsp;&nbsp;<a href="uploads/'.$row['su_abstract_path'].'" style="color:green" download><i class="fa fa-download"></i></a>
            ?>

            <a href="abstractupload.php?dl=<?php echo $row['su_id']; ?>" onclick="return confirm('Please confirm to delete the Abstract!'); " title="Delete" style="color:red"><i class="fa fa-times"></i></a>
          </td>

          </tr>
      <?php
          $sno++;
        }
        //echo'</table></div>';
      } else {
        echo '<script>document.getElementById("message").innerHTML = "";</script>';
        // No data found
        echo '<tr><td colspan="5" align="center">No Abstracts Submitted yet!</td></tr>';
      } 
  ?>

      <!-- end 13-04-2017-->
    </table>


    <!-- Uploaded files table end -->

    <?php

    // if (isset($_POST['subfupload'])) {
    if (isset($_POST['txtSubmit'])) {
      //	 echo 'txtSubmit' . $_POST['txtSubmit'];
      //	exit(0);

      // uplaod file code
      // get file name size type
      $fileName = $_FILES["fileToUpload"]["name"];
      $fileSize = $_FILES["fileToUpload"]["size"] / 1024;
      $fileType = $_FILES["fileToUpload"]["type"];
      $fileTmpName = $_FILES["fileToUpload"]["tmp_name"];

      // check the file format
      if ($fileType == "application/msword" || $fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
        if ($fileSize <= 10000) {
          $userid = $_SESSION["uid"];
          // get count
          $sql = "SELECT * FROM submission where user_table_ru_id='$userid'";
          		  // echo $sql;
          		  // exit(0);
          $result = mysqli_query($connection, $sql);
          $rowcount = mysqli_num_rows($result);
          $ccount = $rowcount + 1;
          switch (strlen((string)$ccount)) {
            case '3':
              $count = $ccount;
              break;
            case '2':
              $count = "0" . $ccount;
              break;
            case '1':
              $count = "00" . $ccount;
              break;

            default:

              break;
          }

          //New file name
          $newFileName = $_SESSION['icid'] . $count . $fileName;
          $_SESSION['filename'] = $newFileName;

          //File upload path
          $uploadPath = "uploads/" . $newFileName;
          //chmod("uploads/".$newFileName, 0777);

          //function for upload file
          if (move_uploaded_file($fileTmpName, $uploadPath)) {
            echo '<script>document.getElementById("message").innerHTML = "Successfully uploaded";</script>';
          } else {
            echo '<p style="color:red"></p>';
            echo '<script>document.getElementById("error").innerHTML = "File upload failed.";</script>';
          }
        } else {
          echo '<p style="color:red"></p>';
          echo '<script>document.getElementById("error").innerHTML = "File size too large";</script>';
        }
      } else {
        echo '<p style="color:red"></p>';
        echo '<script>document.getElementById("error").innerHTML = "Invalid file format";</script>';
      }
      // insert the abstract details in db table
      $userid        = $_SESSION['uid'];

      $newFileName   = $_SESSION['filename'];
      $abname        = $_POST['abfile_name'];
      $tp_select1    = $_POST['abfile_select_t1'];

      $primaryEmail = $_SESSION['user_id'];
      //      $tp_select2    =$_POST['abfile_select_t2'];


      // added by prakash on 18-05-2017
      if (!empty($_REQUEST['chk_stud'])) {

        $chk_stud  = "Y";
      } else {

        $chk_stud  = "N";
      }

      // end 18-05-2017

      // modefied by prakash on 12-04-2017

      $query = "INSERT into submission (user_table_ru_id, su_abstract_path, su_abstracttitle,su_created_on, su_topic1, su_student ) VALUES ('$userid','$newFileName','$abname',now(),'$tp_select1','$chk_stud')";
// echo $query;
// exit(0);
      $result = mysqli_query($connection, $query);
      /*      if ($result == true) {
        $last_id = mysqli_insert_id($connection);

        $sql = "UPDATE emsi_files SET emsi_submission_su_id=".$last_id." WHERE user_table_ru_id = ".$_SESSION['uid']." and emsi_submission_su_id IS NULL";
        //exit(0);
        if (mysqli_query($connection, $sql)) {
          echo "";
        } else {

        }
      }
*/
      //EMSI ID $_SESSION['emsiid']
      //EMSI RU ID  $_SESSION['uid']
      /*Mail trigger for abstract submission start */

      //$emsql = "SELECT * FROM contact_table where user_table_ru_id = ".$_SESSION['uid'];
      $emsql = "SELECT a.au_addlemailid as addlemail, a.au_mobile, b.ru_userid FROM contact_table a, user_table b ";
      $emsql .= "WHERE a.user_table_ru_id = b.ru_id and a.user_table_ru_id = " . $_SESSION['uid'];
//       echo $emsql  . "<br>";
// exit(0);

      $emres = mysqli_query($connection, $emsql);
      $emrow = $emres->fetch_assoc();

      if ($emrow["addlemail"] == $emrow["ru_userid"]) {
        $userEmail = $primaryEmail;
        //echo "Matching emails ";
      } else {
        $userEmail = $primaryEmail . ", " . $emrow["addlemail"];
        //echo "NOT Matching emails ";
      }

      require('emailheaders.php');

      // $primaryEmail = $_SESSION['user_id'];
      //echo "<br>" . $userEmail;
      //	  exit(0);

      $email_to = ADMIN_EMAIL; // The email you are sending to (example)
      //$email_to = $emrow["au_emailid"];
      $email_from = "icons@igcar.gov.in"; // The email you are sending from (example)
      $email_subject = "ICONS 2023 Conference - New Abstract - " . $_SESSION['icid']; // The Subject of the email
      //$email_txt = "text body of message"; // Message that the email has in it

      $email_txt = '
      <!DOCTYPE html>
      <html lang="en">
      <head>
      <!-- Required meta tags always come first -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>ICNIB 2019</title>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
      <style media="screen">
      #header{
        background-image: url(img/subhead.png);
        background-size: cover;
      }
      #header p{
        font-size: 25px;
        color:white;
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
        margin-left: 50px;
        margin-right: 20px;

      }
      body{
        margin:25px;
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
          <img src="' . SITE_URL . 'img/emailheadimg1.jpg" alt="" class="img-resposnive center-block" width="600px">
        </div>
        <div class="col-xs-2">
          <p>&nbsp;</p>
        </div>
      </div>
    </div>
   <!-- Header image - END -->
	  
	  
      <div class="container" id="mail" style="">
      <!-- <p style="font-size:24px;color:#000;text-align:center"><b>New Abstract has been submitted.</b></p> -->
      <br/>

      <p>The details of the user who triggered this email is given below</p>
      </div>
      <br/>

      <div class="row">
      <div class="col-sm-2">

      </div>
      <div class="col-sm-8">

      <p><b>Abstract Submission Details</b></p>
      <table class="table table-bordered">
      <tr>
      <th width="50%">ICONS 2023 ID</th>
      <td>' . $_SESSION['icid'] . '</td>
      </tr>
      <tr>
      <th>E-Mail</th>
      <td>' . $primaryEmail . '</td>
      </tr>
      <tr>
      <th>Phone</th>
      <td>' . $emrow["au_mobile"] . '</td>
      </tr>
      </table>
      </div>
      </div>

      <p style="font-size:15px">Best regards,</p>
      <p style="font-size:15px">ICONS 2023 Web Team</p>

      </div>
      <div class="container footer">
      <p class="footer">Copyrights ICONS 2023 (2022-23). All rights reserved.</p> </div> </div>


      <!-- jQuery first, then Bootstrap JS. --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"> </script> </body>

      </html>
      ';

      //$$$ to check
      $fileatt = "uploads/" . $newFileName; // Path to the file (example)
      	  // echo $fileatt . "<BR>";
      	  // exit(0);
      //$fileatt = "/public_html/emsidemo/uploads/".$newFileName; // Path to the file (example)
      $fileatt_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document"; // File Type
      $fileatt_name = $newFileName; // Filename that will be used for the file as the attachment
      $file = fopen($fileatt, 'rb');
      $data = fread($file, filesize($fileatt));
      fclose($file);
      $semi_rand = md5(time());
      $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
      $headers = "From: $email_from"; // Who the email is from (example)
      $headers .= "\nMIME-Version: 1.0\n" .
        "Content-Type: multipart/mixed;\n" .
        " boundary=\"{$mime_boundary}\"";
      $email_message = "This is a multi-part message in MIME format.\n\n" .
        "--{$mime_boundary}\n" .
        "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $email_txt;
      $email_message .= "\n\n";
      $data = chunk_split(base64_encode($data));
      $email_message .= "--{$mime_boundary}\n" .
        "Content-Type: {$fileatt_type};\n" .
        " name=\"{$fileatt_name}\"\n" .
        "Content-Transfer-Encoding: base64\n\n" .
        $data . "\n\n" .
        "--{$mime_boundary}--\n";

      // echo $email_message;
      // exit(0);
      mail($email_to, $email_subject, $email_message, $headers);


      // Email to be sent to User
      //$email_to = ADMIN_EMAIL; // The email you are sending to (example)
      // Check whether sign in email and Contact Email are same. If not send mail to both email ids.

      // Variables : icId, icTitle, icFilename, imgpath

      $variables = array();

      $variables['imgpath'] = SITE_URL;
      $variables['icId'] = $_SESSION['icid'];
      $variables['icTitle'] = $abname;
      $variables['icFilename'] = $fileName;

      // echo $variables['imgpath'];

      $template = file_get_contents("abstractTemplate.html");

      foreach ($variables as $key => $value) {
        $template = str_replace('{{ ' . $key . ' }}', $value, $template);
      }
      $email_txt = $template;

      $email_to = $userEmail;
      $email_from = "icons@igcar.gov.in"; // The email you are sending from (example)
      $email_subject = "ICONS 2023 Conference - Abstract Received"; // The Subject of the email
      //$email_txt = "text body of message"; // Message that the email has in it



      $semi_rand = md5(time());
      $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
      $headers = "From: $email_from"; // Who the email is from (example)
      $headers .= "\nMIME-Version: 1.0\n" .
        "Content-Type: multipart/mixed;\n" .
        " boundary=\"{$mime_boundary}\"";
      $email_message = "This is a multi-part message in MIME format.\n\n" .
        "--{$mime_boundary}\n" .
        "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
        "Content-Transfer-Encoding: 7bit\n" . $email_txt;
      $email_message .= "\n\n";


      // echo $email_message;
      // echo $email_to;
      // exit(0);
      $sentusermail = mail($email_to, $email_subject, $email_message, $headers);
      if (!$sentusermail) {
        echo "<script>alert('Mail Notification Error! Contact Administrator!');</script>";
      }


      //header("Location:abstractupload.php");
      echo '<meta http-equiv="Refresh" content="2; url=abstractupload.php">';
    } /*Mail trigger for abstract submission end */


    //Delete Action - Start
    if (isset($_REQUEST['dl'])) { //File Delete Process
      $did = $_REQUEST['dl'];
      // $dlname=$_REQUEST['dlnm'];
      // select sub table data
      $sql = "SELECT * FROM submission where su_id='$did'";
      //echo "delete process : " . $sql . "<BR>";
      $result = mysqli_query($connection, $sql);

      if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
          //  delete the file from folder
          $dlname = $row['su_abstract_path'];
          echo $dlname . "<BR>";
          // exit(0);
          if (file_exists("uploads/" . $dlname)) {
            if (!unlink("uploads/" . $dlname)) {
              echo '<script>document.getElementById("error").innerHTML = "Error on deleting file. Please contact Administrator.";</script>';
              die("could not delete file. File Missing");
            } else {
              sleep(1);
            }
          } else {
            /*echo'<script>document.getElementById("error").innerHTML = "File Not Found. Please contact Administrator.";</script>';*/
          }
        }
      }



      // delete the file details in sub table
      $sql = "DELETE FROM submission WHERE su_id=" . $did;
      // echo $did . "<BR>";
      // echo $sql;
      // exit(0);
      if (mysqli_query($connection, $sql)) {
        echo '<script>document.getElementById("message").innerHTML = "File deleted successfully"; alert("File Deleted");</script>';
        //header("Location:abstractupload.php");
        echo '<meta http-equiv="Refresh" content="1; url=abstractupload.php">';
      } else {
        //  echo "Error deleting record: " . mysqli_error($connection);
        echo '<script>document.getElementById("error").innerHTML = "Error on deleting file. Please contact Administrator.";</script>';
      }
      //  }
    }  //isset($_REQUEST['dl']  END
    ?>
  </div>
</div> <!--  container main -->

<!-- footer -->
<?php include 'includes/footer.php'; ?>
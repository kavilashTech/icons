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
    <p class="align-center" style="font-size:14px;color:white;font-weight:bold;"><badge style="background-color:red">&nbsp;&nbsp;Abstract Submission Closed.&nbsp;&nbsp;</badge></p>
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
        <input type="text" class="form-control" id="abfile_name" name="abfile_name" maxlength="150" disabled>

        <div class="form-group required">
          <!-- <div class="form-inline"> -->
          <label for="abfile_select_t1">Select a Topic <span style="color:red;">*</span></label>
          <select class="custom-select form-control" name="abfile_select_t1" id="abfile_select_t1" disabled>
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
          <input type="file" class=" form-control" name="fileToUpload" id="fileToUpload" style="width:100%;" accept=".doc,.docx, application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" disabled>
        </div>

        <label id="FileError" for="fileToUpload" class="control-label" style="margin-left:-3%"></label>

        <div class="form-group">
          <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
              <label id="ErrMessage" style="color:red !important;font-weight:600;"></label>
              <input type="submit" class="form-control btn-primary" value=<?php echo $submitBtnText;  ?> id="subfupload" name="subfupload" disabled>
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


    <table class="table table-bordered table-striped" style="border-collapse:collapse;table-layout:fixed;">
      <tr style="background-color:grey;color:#fff">
        <th width="5%">S.No.</th>
        <th width="10%">Abstract Title</th>
        <th width="30%">Topic</th>
        <th width="30%">Abstract(s)</th>
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
                  <td><div style="white-space:normal;overflow-x:hidden">' . $row['su_abstracttitle'] . '</div></td>
                  <td><div style="white-space:normal;overflow-x:hidden">' . $row['to_topic_name'] . '</div></td>' ?>
          <!--  CF820200001001 : IC2023001001 -->
          <td><div style="white-space:normal;overflow-x:hidden">
            <?php echo '<a href="uploads/' . $row['su_abstract_path'] . '" download="' . substr($row['su_abstract_path'], 12) . '" title="' . $row['su_abstract_path'] . '">' . substr($row['su_abstract_path'], 12) . '</a></div></td>';
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

          //function for upload file into server
          if (move_uploaded_file($fileTmpName, $uploadPath)) {
            echo '<script>document.getElementById("message").innerHTML = "Successfully uploaded. Please wait for Page Refresh!";</script>';
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



      $query = "INSERT into submission (user_table_ru_id, su_abstract_path, su_abstracttitle,su_created_on, su_topic1, su_student ) VALUES ('$userid','$newFileName','$abname',now(),'$tp_select1','$chk_stud')";
      // echo $query;
      // exit(0);
      $result = mysqli_query($connection, $query);

      // --------------------------- Email Preparation
      /* EMAIL sent to Admin - Mail trigger for abstract submission -- start */

      $emsql = "SELECT a.au_addlemailid as addlemail, a.au_mobile, b.ru_userid FROM contact_table a, user_table b ";
      $emsql .= "WHERE a.user_table_ru_id = b.ru_id and a.user_table_ru_id = " . $_SESSION['uid'];
      // echo $emsql  . "<br>";
      // exit(0);

      $emres = mysqli_query($connection, $emsql);
      $emrow = $emres->fetch_assoc();

      if ($emrow["addlemail"] == $emrow["ru_userid"]) {
        $userEmail = $primaryEmail;
        //echo "Matching emails ";
      } else {
        $userEmail = $primaryEmail;
        $userEmail2 = $emrow["addlemail"];
        //echo "NOT Matching emails ";
      }

      require('emailheaders.php');

      // $primaryEmail = $_SESSION['user_id'];
      //echo "<br>" . $userEmail;
      //	  exit(0);

      // ------- variables 

      $variables = array();

      $variables['imgpath'] = SITE_URL;
      $variables['icId'] = $_SESSION['icid'];
      $variables['icTitle'] = $abname;
      $variables['icFilename'] = $fileName;
      $variables['icUserEmail'] = $primaryEmail;

      $template = file_get_contents("templates/adminabstractTemplate.html");

      foreach ($variables as $key => $value) {
        $template = str_replace('{{ ' . $key . ' }}', $value, $template);
      }
      $email_body = $template;

      // echo $email_txt;
      // exit(0);

      // --------variables end

      // --------------------------- New Email to Admin - START

      $phpemail->From = 'icons@igcar.gov.in';

      //admin email = sampathraj.mp@gmail.com
      $phpemail->AddAddress(ADMIN_EMAIL);

      $phpemail->addCC('icons2023.webteam@gmail.com'); 

      $phpemail->Subject = "New Abstract Submitted - " . $_SESSION['icid'];
      $phpemail->MsgHTML($email_body);
      $phpemail->AddAttachment("uploads/" . $newFileName);
      if (!$phpemail->Send()) {
        echo '<p style="color:red"></p>';
        echo '<script>document.getElementById("error").innerHTML = "Error sending email. Contact Administrator";</script>';
        exit;
      }
      //clear all mail receipients and Attachments
      $phpemail->clearAddresses();
      $phpemail->clearAttachments();

      // echo "Message was sent successfully";

      // --------------------------- New Email to Admin - END

      // --------------------------- New Email Notification to USER - START

      // ------- variables 

      $variables = array();

      $variables['imgpath'] = SITE_URL;
      $variables['icId'] = $_SESSION['icid'];
      $variables['icTitle'] = $abname;
      $variables['icFilename'] = $fileName;

      $template = file_get_contents("templates/abstractTemplate.html");

      foreach ($variables as $key => $value) {
        $template = str_replace('{{ ' . $key . ' }}', $value, $template);
      }

      $email_body = $template;

      // --------variables end

      $phpemail->From = 'icons@igcar.gov.in';

      //Primary Email
      $phpemail->AddAddress($userEmail);

      //Additional Email
      if (isset($userEmail2) && $userEmail2 != "" ) {
        // echo "additional emai :" . $userEmail2 . "]";
        // exit(0);
        $phpemail->AddAddress($userEmail2);
      }

      $phpemail->Subject = "ICONS 2023 Conference - Abstract Received - " . $_SESSION['icid'];
      $phpemail->MsgHTML($email_body);
      $phpemail->AddAttachment("uploads/" . $newFileName);

      if (!$phpemail->Send()) {
        echo '<p style="color:red"></p>';
        echo '<script>document.getElementById("error").innerHTML = "Error sending email. Contact Administrator";</script>';
        exit;
      }
      //clear all mail receipients and Attachments
      $phpemail->clearAddresses();
      $phpemail->clearAttachments();

      // echo "Message was sent successfully";

      // --------------------------- New Email Notification to USER - END
      
      // echo "<script>alert('Mail Notification Sent! You will be redirected to Abstract Page!');</script>";
      // echo '<script>document.getElementById("success").innerHTML = "Abstract Submission Mail Notification Success.";</script>';
      echo '<meta http-equiv="Refresh" content="0; url=abstractupload.php">';
    }    /*Mail trigger for abstract submission end */


    //Delete Action -------------------- Start
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
        echo '<meta http-equiv="Refresh" content="0; url=abstractupload.php">';
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
<?php include 'includes/connection.php';
include 'includes/header.php';
include 'includes/menu-loggedin.php';

if (!isset($_SESSION["uid"])) {
   echo '<meta http-equiv="Refresh" content="0; url=index.php">';
   exit(0);
}
$uid = $_SESSION["uid"];
?>
<?php
if (isset($_REQUEST['ed'])) {
   $edid = trim($_REQUEST['ed']);

   $sql = "SELECT * FROM submission where user_table_ru_id=" . $uid . " and su_id=" . $edid;


   $result = mysqli_query($connection, $sql);

   if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $name                =  $row['su_abstracttitle'];
      $topic1              =  $row['su_topic1'];
      //      $topic2              =  $row['su_topic2'];
      $abstract            =  substr($row['su_abstract_path'], 12);
      $abstractfilename      =  $row['su_abstract_path'];
      // added by prakash on 12-04-2017
      // start
      $su_presentation    =  explode(',', $row['su_presentation']);
      //$su_metcontest       =  $row['su_metcontest'];
      //$su_metcontestoptn   = $row['su_metcontestoptn'];
      // end

      // added by prakash on 18-05-2017
      $su_student    =  $row['su_student'];
      if ($su_student == 'Y') {
         $selected = "checked";
      } else {
         $selected = "";
      }

      // end
   }
}
?>
<!-- added by prakash on 12-04-2017 -->
<!-- start -->
<script type="text/javascript">
   $(document).ready(function() {

      //To validate and allow only .doc and .docx
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



   });

   function ValidateSubmit() {
      //alert('into validate submit');

      if (document.getElementById("fupload").value == "Uploading File...") {
         alert('Please Wait. File is being uploaded');
         document.getElementById("fupload").disabled = 'true';
         return false;
      } else {
         document.getElementById("fupload").value = 'Uploading File...';
         return true;
      }
   }


   // function to validate the check box group
   function checkboxchecked() {
      /*   var numberChecked=$("input[name='chk_present[]']:checked").length;

         if(numberChecked <   1){
            $("#errorTxt").html('this field is required');
            return false;
         }
         else{
            $("#errorTxt").html('');

         }*/
      //added by sampath 25-Jun-2019
      return true;
   }
</script>
<!-- end -->

<!-- Side Nav Bar - Logged in user -->
<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<!-- Header area start -->
<div class="section-header mar-bot30">
   <h2 class="section-heading animated" data-animation="bounceInUp">Abstract Submission - Edit</h2>
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

      <div class="row">
         <form class="form" method="post" method="post" enctype="multipart/form-data" onsubmit="return ValidateSubmit();">
            <p class="text-center" id="message" style="color:green"></p>
            <p class="text-center" id="error" style="color:red"></p>
            <input type="hidden" name="txt_filename" id="txt_filename" value="<?php echo $abstract; ?>">

            <div class="form-group required ">

               <!-- added by prakash on 10/04/2017 -->
               <!-- <div class="form-group">
                  <label for="chk_stud_lbl">Student</label>
                  <input type="checkbox" name="chk_stud" id="chk_stud" value="Student" <?php echo $selected; ?>>
               </div> -->

               <!-- end -->
               <label for="abfile_name">Abstract Title <span style="color:red;">*</span></label>
               <input type="text" class="form-control" id="abfile_name" name="abfile_name" value="<?php echo $name; ?>" placeholder="Abstract Title" maxlength="150" required>


            </div>
            <div class="form-group required">
               <label for="abfile_select_t1">Select a Topic <span style="color:red;">*</span></label>
               <select class="custom-select form-control" name="abfile_select_t1" id="abfile_select_t1" required>
                  <option value="">Select...</option>
                  <?php
                  $sql = "SELECT * FROM topics where  to_active='A' ORDER BY to_id";
                  $result = mysqli_query($connection, $sql);

                  if (mysqli_num_rows($result) > 0) {
                     // output data of each row
                     while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value=" <?php echo $row['to_id'];  ?> " <?php if ($row['to_id'] == $topic1) {
                                                                           echo "selected";
                                                                        } ?>><?php echo $row['to_topic_name']; ?></option>
                  <?php }
                  } else {
                     echo "No Topic Selected";
                  }

                  ?>
               </select>


            </div>

            <label for="fileToUpload">Upload your Abstract <span style="color:red;">*</span><br><span style="color:blue;font-size:12px;">(Number of characters in Filename should not exceed <b>50</b>. No Special Characters Allowed in Filename.)<BR>
         Please note that the file already uploaded will be replaced.</span></label>
            <div class="custom-file">
               <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" style="width:100%;" accept=".doc,.docx, application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required>
            </div>

            <!-- <label for="">Upload your Abstract</label>
      <div class="form-inline">
        <div class="input-group" style="width:98%;margin:auto">
          <input type="file" name="fileToUpload" id="fileToUpload" accept=".doc,.docx, application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" required   >
        </div>
      </div> -->

            <p class="text-center"><a href="uploads/<?php echo $abstractfilename; ?>"><?php echo $abstract; ?></a></p>
            <br>
            <div class="form-group">
               <div class="row">
                  <div class="col-sm-3">
                  </div>
                  <div class="col-sm-3">
                     <input type="Submit" class="form-control btn-primary" value="Update" id="fupload" name="fupload" placeholder="" style="width:80%">
                  </div>
                  <div class="col-sm-3">
                     <a href="abstractupload.php" class=" btn btn-primary" style="color:white;width:80%">Cancel</a>
                  </div>
               </div>
            </div>
            <h5 id="smessage" style="color:green;text-align:center"></h5>
            <h5 id="emessage" style="color:red;text-align:center"></h5>
         </form>
         <?php
         if (isset($_POST['fupload'])) { //Update Process

            $upid = trim($_REQUEST['ed']);

            // get file name size type
            $fileName = $_FILES["fileToUpload"]["name"];
            $fileSize = $_FILES["fileToUpload"]["size"] / 1024;
            $fileType = $_FILES["fileToUpload"]["type"];
            $fileTmpName = $_FILES["fileToUpload"]["tmp_name"];

            if (!empty($fileName)) {

               // check the file format
               if ($fileType == "application/msword" || $fileType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
                  if ($fileSize <= 10000) {
                     // get count
                     $userid = $_SESSION["uid"];
                     // Query to fetch the document number. cf820200001 - IC2023001
                     $filenumberSQL = "SELECT su_id, su_abstract_path, max(SUBSTRING(su_abstract_path, 12, 3)) as DocNo FROM submission where user_table_ru_id=" . $userid . " order by su_id";

                     $filenumberResult = mysqli_query($connection, $filenumberSQL);
                     $row = mysqli_fetch_assoc($filenumberResult);
                     $filenumber = $row['DocNo'];
                     $ccount = $filenumber + 1;
                     //echo $filenumberSQL . "<br>";
                     //echo $filenumber . "   " . $ccount . "<br>";
                     //exit(0);
                     //sql string to update file name
                     /*                                           $ssql = "SELECT * FROM submission where user_table_ru_id='$userid'";
                                             $sresult = mysqli_query($connection, $ssql);
                                             $rowcount=mysqli_num_rows($sresult);
                                             $ccount=$rowcount+1;*/

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
                           //ic20230002
                           break;
                     }
                     //New file name
                     $newFileName = $_SESSION['icid'] . $count . $fileName;

                     $_SESSION['filename'] = $newFileName;

                     //File upload path
                     $uploadPath = "uploads/" . $newFileName;


                     //function for upload file
                     if (move_uploaded_file($fileTmpName, $uploadPath)) {
                        echo '<script>document.getElementById("message").innerHTML = "Successfully uploaded";</script>';
                        $upid       = trim($_REQUEST['ed']);

                        // sql string
                        $sql = "UPDATE submission SET su_abstract_path='$newFileName' WHERE su_id='$upid'";
                        //echo $sql;
                        //exit(0);
                        if (mysqli_query($connection, $sql)) {

                           $txt_filename  =  $_REQUEST['txt_filename'];
                           unlink("uploads/" . $txt_filename);
                        }
                     } else {
                        echo '<p style="color:red"></p>';
                        echo '<script>document.getElementById("fmessage").innerHTML = "File upload failed.";</script>';
                     }
                  } else {
                     echo '<p style="color:red"></p>';
                     echo '<script>document.getElementById("fmessage").innerHTML = "File size too large";</script>';
                  }
               } else {
                  echo '<p style="color:red"></p>';
                  echo '<script>document.getElementById("fmessage").innerHTML = "Invalid file format";</script>';
               }
            }
            // form data
            $upid       = trim($_REQUEST['ed']);
            $fname      = trim($_REQUEST['abfile_name']);
            $topic1     = trim($_REQUEST['abfile_select_t1']);
            // $topic2     = trim($_REQUEST['abfile_select_t2']);
            //$sel_metaloptn =  $_REQUEST['sel_metal'];

            // $chk_present   = implode(',', $_REQUEST['chk_present']);

            /*                                    $chk_metal="";

                                    if (!empty($_REQUEST['chk_metal'])) {
                                       $chk_metal     ='Yes';
                                    }
                                    else{
                                       $chk_metal     ='No';
                                    }
                                    $sel_metal = $_REQUEST['sel_metal'];


*/
            // added by prakash on 18-05-2017
            if (!empty($_REQUEST['chk_stud'])) {

               $chk_stud  = "Y";
            } else {

               $chk_stud  = "N";
            }

            //update timestamp
            //$updatetime = new DateTime();
            // end 18-05-2017
            // $filename   = $_SESSION['filename'];

            // sql string
            $sql = "UPDATE submission SET su_abstracttitle='$fname',su_updated_on=now(),su_topic1='$topic1',su_student='$chk_stud' WHERE su_id='$upid'";
            //echo "<BR>Update SQL : " . $sql;
            //exit(0);
            if (mysqli_query($connection, $sql)) {

               echo '<script>document.getElementById("smessage").innerHTML = "Successfully Updated";</script>';
               echo '<meta http-equiv="Refresh" content="0; url=abstractupload.php">';
            } else {
               echo '<script>document.getElementById("emessage").innerHTML = "Update Failed";</script>';
            }
         }

         ?>
      </div>

   </div>
</div>
<!-- footer -->
<?php include 'includes/footer.php'; ?>
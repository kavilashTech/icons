<?php
include "includes/connection.php";
include 'includes/header.php';
include 'includes/menu-loggedin.php';


$uid1 = "";
$insertflag = "N";

if (!isset($_SESSION["uid"]))
	{
	  echo '<meta http-equiv="Refresh" content="0; url=index.php">';
	  exit(0);
	
	}

$uid = trim($_SESSION["uid"]);
$email = trim($_SESSION["user_id"]);
$nationality ="";

//echo '<br><br><br><br><br>';
//echo "uid : " . $uid;
/*
if (isset($_REQUEST["txtFlag"]))
{
  echo $_REQUEST["txtFlag"] . " beginning echo " . "<BR>";

}
*/

// Edit mode : user id available

// Fetch data from database.
// show screen for editing
// Change button caption to update contact information.

// Submit to Main page


if (isset($_REQUEST["txtFlag"])) 
{

		// Coming from Main Page : txtFlag : EDIT
		// Select data and show for Editing.
		// Change button caption to "Update"

		$txtFlag = $_REQUEST["txtFlag"];

		//echo "1 - txtFlag Mode : " . $txtFlag . "<BR>";

		$fname 		= "";
		$lname		= "";
		$affi		= "";
		//$email		= "";
		$ademail	= "";
		$mobile		= "";
		$phone		= "";
	
		// Check whether data is already available for this user
		
		$selsql = "SELECT * FROM `contact_table` WHERE user_table_ru_id = " . $uid . " and au_active = 1" ;

		$arow= mysqli_query($connection, $selsql);

		if (mysqli_num_rows($arow) > 0) {
		
			$result=mysqli_fetch_assoc($arow);
			
			$fname 		= $result['au_firstname'];
			$lname		= $result['au_lastname'];
			$affi		= $result['au_affiliation'];
			//$email		= $result['au_emailid'];
			$ademail	= $result['au_addlemailid'];
			$mobile		= $result['au_mobile'];
			$phone		= $result['au_phone'];
			$nationality = $result['au_nationality'];
			$iim 		= $result['au_iim'];
			$isnt 		= $result['au_isnt'];
			$insis 		= $result['au_insis'];
			$sfa 		= $result['au_sfa'];

			$student 		= $result['au_student'];
			// Edit Mode - Record already available;
			$txtFlag = "UPDATE";
		
		} // No data in Database - This situation may not come.
		else 
			{
				echo " No data in database " ;
				exit(0);
			}
		
	}	else
		{
		// user came here directly.
		// redirect to login page
		//echo "2 - Flag : Flag not set. May Not be shown " . "<BR>";
//			  echo '<meta http-equiv="Refresh" content="0; url=index.php">';
			  exit(0);
		}
		
//echo " 3 : passed initial test, txtFlag : " . $txtFlag;
?>

<script type="text/javascript">

function editform()
{
	document.forms["form1"].action = "authorinfo-edit.php";
	document.forms["form1"].submit();

}

function emailcompare()
{
	var email = document.getElementById("txtemail").value;
	var addlemail = document.getElementById("txtaddlemail").value;

	if (email == addlemail)
	{
		//alert ("Email address should not be same.");
		document.getElementById("error").innerHTML = "Email address should not be same.";
		document.getElementById('btncontact').disabled = true;
		return false;
	}
	else
	{
		document.getElementById("error").innerHTML = "";
		document.getElementById('btncontact').disabled = false;
		return true;
	}

}

</script>
<!-- content page -->
<div class="mar-top30">&nbsp;</div>

<style>
.tbl-none td{
  border: none!important;
}

</style>

<?php include 'includes/admin_sidenav.php'; ?>


<div class="section-header mar-bot30">
	<h2 class="section-heading animated" data-animation="bounceInUp">Contact Information</h2>
</div>

<div class="col-md-8">
	<h5 id="success" class="pull-right" style="color:green;"></h5>
	<h5 id="error" class="pull-right" style="color:red;"></h5>
</div>



<div class="container" id="main">
  <div class="container-fluid pt-2">
    <div class="row">

      <!-- col-sm-3   end  -->
      <div class="col-sm-9">
        <div class="row">
          <div class="col-md-6">
            <h3 class="text-left" style="color:#084B8A">Contact Information <small>(Primary contact)</small></h3>
          </div>
          <div class="col-md-6">
            <p class="small text-right">All Fields marked with <span style="color:red">*</span> are mandatory</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <form method="post" id="form1" class="form-horizontal" action="contactinformation.php">
              <input type="hidden" id="txtFlag" name="txtFlag" value="<?php echo $txtFlag ?>" />


              <div class="form-group required">
                <div class="col-xs-6">
                  <div class="form-inline">
                  <label>First Name</label>
                    <input type="text" class="form-control" id="txtfname" name="txtfname" placeholder="Enter First Name" minlength="1" maxlength="45" required style="width:98%" value="<?php echo $fname; ?>">
                    <label for="" class="control-label" style="margin-top:-6%"></label>
                  </div>
                </div>
                <div class="col-xs-6">
                    <div class="form-inline">
                    <label>Last Name</label>
                      <input type="text" class="form-control" id="txtlname" name="txtlname" placeholder="Enter Last Name"  maxlength="45" required style="width:98%" value="<?php echo $lname; ?>">
                      <label for="" class="control-label" style="margin-top:-6%"></label>
                    </div>
                </div>
              </div>
              <div class="form-group required">
                <div class="col-xs-6">
                  <div class="form-inline">
                  <label>Affiliation</label>
                    <input type="text" class="form-control" id="txtaffi" name="txtaffi" placeholder="Enter Affiliation / Institution" minlength="1" maxlength="100" style="width:98%"  value="<?php echo $affi; ?>">
                    <label for="" class="control-label"></label>
                  </div>
                </div>

			<!-- Student Check box - START -->
			<!-- <div class="row mar-bot10"> -->
      <div class="col-xs-6">
					<label for="chk_student" >Student</label>&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="chk_student" id="chk_student" <?php if ($student == 'Y') {
																				echo 'checked';
																			}
																			?>>
					<span style="font-size:12px"> &nbsp;&nbsp;&nbsp;(Check this if you are a Student)</span>
      </div>
      </div>
			<!-- </div> -->
			<!-- Student Check box - END -->
              <div class="form-group required">
                <div class="col-xs-6">
                  <div class="form-inline">
                  <label>Mobile No.</label>
                    <input type="tel" class="form-control" id="txtmobile" name="txtmobile" placeholder="Enter Mobile" minlength="10" maxlength="15" required style="width:98%" value="<?php echo $mobile; ?>">
                    <label for="" class="control-label" style="margin-top:-6%"></label>
                  </div>
                </div>
                <div class="col-xs-6">
                <label>Alternate Mobile</label>
                  <input type="tel" class="form-control" id="txtphone" name="txtphone" placeholder="Enter Alternate Mobile"  maxlength="15" style="width:98%;"  value="<?php echo $phone; ?>">
                </div>
              </div>
              <div class="form-group required">
                <div class="col-xs-12">
                  <div class="form-inline">
                  <label>Primary Email (Not Editable)</label>
                    <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Enter E-mail" minlength="4" maxlength="150" required style="width:98%" value="<?php echo $email; ?>" readonly>
                    <label for="" class="control-label" style="margin-top:-6%"></label>
                  </div>
                </div>
              </div>
              <div class="form-group ">
                <div class="col-xs-12">
                  <div class="form-inline">
                  <label>Additional Email</label>
                    <input type="email" class="form-control" id="txtaddlemail" name="txtaddlemail" placeholder="Enter Additional E-mail" minlength="4" maxlength="150" style="width:98%" onblur="return emailcompare()"  value="<?php echo $ademail; ?>">
                    <label for="" class="control-label" style="margin-top:-6%"></label>
                  </div>
                </div>
              </div>
              <div class="form-group required">
                <div class="col-xs-12">
                <label for="sel_nationality" >Select Nationality <span style="color:red;">*</span></label>
                  <select class="custom-select form-control" name="sel_nationality" id="sel_nationality" required >
            		<!-- <option value="">Select...</option> -->

                    <?php 
                    $sql = "SELECT * FROM nationality where na_active='Y' ORDER BY na_id";
                    $result = mysqli_query($connection, $sql);
            
                    if (mysqli_num_rows($result) > 0) {
                      // output data of each row
                      while($row = mysqli_fetch_assoc($result)) { ?>
                        <option value= "<?php echo $row['na_id']; ?>" <?php if($row['na_id'] == $nationality ) {echo "selected"; } ?> > <?php echo $row['na_name']; ?></option>

                     <?php }
					  
                    } else {
                      echo "No topics found";
                    }
            
                    ?>
                  </select>

                 </div> 
               </div>
            <div class="form-group">
              <table class="tbl-none" width="100%">
                  <tr>
                    <td><label for="chk_iim">&nbsp;IIM Member</label>&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="chk_iim" id="chk_iim" <?php if ($iim == 'Y'){echo 'checked';}?>> 
                    <span style="font-size:12px">   &nbsp;&nbsp;&nbsp;(Check this if you are an IIM Member)</span></td>
                    <td></td>
                  </tr>
                </table>
              </div>
            <div class="form-group">
              <table class="tbl-none" width="100%">
                  <tr>
                    <td><label for="chk_isnt">&nbsp;ISNT Member</label>&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="chk_isnt" id="chk_isnt" <?php if ($isnt == 'Y'){echo 'checked';}?>> <span style="font-size:12px">   &nbsp;&nbsp;&nbsp;(Check this if you are an ISNT Member)</span></td>
                    <td></td>
                  </tr>
                </table>
              </div>

            <div class="form-group">
              <table class="tbl-none" width="100%">
                  <tr>
                    <td><label for="chk_insis">&nbsp;InSIS Member</label>&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="chk_insis" id="chk_insis" <?php if ($insis == 'Y'){echo 'checked';}?>> <span style="font-size:12px">   &nbsp;&nbsp;&nbsp;(Check this if you are an InSIS Member)</span></td>
                    <td></td>
                  </tr>
                </table>
              </div>
            <div class="form-group">
              <table class="tbl-none" width="100%">
                  <tr>
                    <td><label for="chk_sfa">&nbsp;SFA Member</label>&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="chk_sfa" id="chk_sfa" <?php if ($sfa == 'Y'){echo 'checked';}?>> <span style="font-size:12px">   &nbsp;&nbsp;&nbsp;(Check this if you are an SFA Member)</span></td>
                    <td></td>
                  </tr>
                </table>
              </div>

              <div class="form-group">
				<div class="col-xs-8">
                  <div class="form-inline">
                    <h5 id="success" style="color:green;text-align:center"></h5>
                    <h5 id="error" style="color:red;text-align:center"></h5>
                    </div>
                  </div>
</div>
                <!-- TODO : If data is already available, update button to Save Contact -->
                <?php //echo $mode;
            if ($txtFlag == "UPDATE") { ?>
            	<div align="center">
                <input type="submit" class="btn btn-primary" style="color:white;width:60%;font-size:14px;" name="btncontact" id="btncontact"  value="UPDATE CONTACT INFORMATION" >
				        <a href="contactinformation.php" class=" btn btn-primary" style="color:white;width:30%;font-size:14px;" >Cancel</a>
                </div>
                <?php } else if ($txtFlag == "ADD") {?>
                		<input type="submit" class="form-control btn-primary" name="btncontact"  value="ADD CONTACT INFORMATION">
                		<?php  }  ?>
              
            </form>
			<?php  if ($insertflag == "F")  {
          				echo'<script>document.getElementById("error").innerHTML = "Could not be added. Please contact Administrator.";</script>';
					} 
					else if ($insertflag == "S") {
						echo'<script>document.getElementById("success").innerHTML = "Added successfully.";</script>';
					}
					?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="v-10"></div>
<div class="v-10"></div>
<!-- footer -->
    <?php include 'includes/footer_loggedin.php'; ?>
    <?php include 'includes/script.php'; ?>
<?php
include "includes/connection.php";
include 'includes/header.php';


$uid1 = "";
$insertflag = "N";

if (!isset($_SESSION["uid"])) {
	echo '<meta http-equiv="Refresh" content="0; url=index.php">';
	exit(0);
}

$uid = trim($_SESSION["uid"]);
$email 		=	$_SESSION['user_id'];
$nationality = "";
$iim = "";
// echo "uid : " . $uid;
// echo '<br><br><br><br><br>';

// Fresh visit : txtFlag Not Set
// check database and fetch if available (edit Mode)
// Not In database : New Mode (Add Contact) : txtFlag = ADD

// txtFlag value set to "ADD" - coming from same page
// Insert data and change button to "Edit"
// Disable all fields.
// set txtFlag = "EDIT"


//txtFlag value set to "UPDATE" - coming from edit page.
// Update value to database and set txtFlag to "EDIT".
// Disable all fields

// Edit Button Click : Take To Edit Page

// EDIT Page

// Will come from this page
// if txtFlag is set to "EDIT" fetch data and show.
// 
// Update Button Click
// set txtFlag = "UPDATE". Sent to Contactinformation page.
//

if (!isset($_REQUEST["txtFlag"])) {

	// First time user comes to this page

	// Set the Mode for Add.
	$txtFlag = "ADD";


	$fname 		= "";
	$lname		= "";
	$affi		= "";
	//$email		= $emailid;
	$ademail	= "";
	$mobile		= "";
	$phone		= "";

	// Check whether data is already available for this user

	//		$selsql = "SELECT * FROM `icr_contact_table` WHERE icr_user_table_ru_id = " . $uid . " and au_active = 1" ;
	$selsql = "SELECT a.au_firstname, a.au_lastname, a.au_addlemailid, a.au_phone, a.au_mobile, a.au_affiliation, b.na_name, b.na_id as nationality, a.au_iim, a.au_isnt, a.au_insis FROM contact_table a, nationality b WHERE a.au_nationality = b.na_id and a.user_table_ru_id = " . $uid . " and au_active = 1";
	// echo '<br><br><br><br><br><br><br>';
	//  echo $selsql;
	//  exit(0);
	$arow = mysqli_query($connection, $selsql);

	if (mysqli_num_rows($arow) > 0) {


		$result = mysqli_fetch_assoc($arow);

		$fname 		= $result['au_firstname'];
		$lname		= $result['au_lastname'];
		$affi		= $result['au_affiliation'];
		//$email		= $result['au_emailid'];

		$email 		=	$_SESSION['user_id'];
		$ademail	= $result['au_addlemailid'];
		$mobile		= $result['au_mobile'];
		$phone		= $result['au_phone'];
		$iim		= $result['au_iim'];
		$isnt 		= $result['au_isnt'];
		$insis 		= $result['au_insis'];
		$nationality	= $result['nationality'];

		// Edit Mode - Record already available;
		$txtFlag = "EDIT";
		//echo "Record available in DB <BR>";
		//echo $iim;

	} else {
		// No data in Database - ADD Mode
		$txtFlag = "ADD";
		//echo " Location : No data in DB ";
	}
} else { // txtFlag set. From same page or from edit page
	// Check txtFlag value. Possible values : EDIT, ADD

	//echo "txtFlag is set to : " . $_REQUEST["txtFlag"];
	//exit(0);
	$txtFlag = $_REQUEST["txtFlag"];

	if ($txtFlag == "ADD") {
		//echo "<br>txtFlag = ADD";

		$inssql		= "";
		//$memtype 		= trim($_REQUEST["rad_memtype"]);
		$fname 		= trim($_REQUEST["txtfname"]);
		$lname		= trim($_REQUEST["txtlname"]);
		$affi			= trim($_REQUEST["txtaffi"]);
		//$email		= trim($_REQUEST["txtemail"]);

		$ademail	= trim($_REQUEST["txtaddlemail"]);
		$mobile		= trim($_REQUEST["txtmobile"]);
		$phone		= trim($_REQUEST["txtphone"]);
		$iim		= trim($_REQUEST["chk_iim"]);
		$isnt		= trim($_REQUEST["chk_isnt"]);
		$insis		= trim($_REQUEST["chk_insis"]);
		$nationality	= $_POST['sel_nationality'];

		// if (!empty($_REQUEST['chk_iim'])) {

		// $iim  = "Y";

		// }else{

		// $iim  = "N";
		// }

		$inssql = "INSERT into contact_table (au_firstname, au_lastname, au_affiliation, au_addlemailid, au_mobile, au_phone, au_nationality, au_iim, au_isnt, au_insis, user_table_ru_id, au_active) values
													   ('$fname', '$lname', '$affi', '$ademail', '$mobile', '$phone', $nationality, '$iim', '$isnt', '$insis', " . $_SESSION['uid'] . ", 1)";
		// echo $inssql . "<BR>";
		// 				echo $_REQUEST['sel_nationality'] . "<br>";
		// 				echo $nationality;
		// exit(0);

		//echo $inssql . "<BR>";
		//echo trim($_SESSION['category']);

		if (mysqli_query($connection, $inssql) == TRUE) {
			$insertflag = "S";
			$txtFlag = "EDIT"; // successfully inserted. Changing mode to EDIT.

			/*echo'<script>document.getElementById("success").innerHTML = "Added successfully.";</script>';*/
		} else {
			$insertflag = "F";
			/*echo'<script>document.getElementById("error").innerHTML = "Could not be added. Please contact Administrator.";</script>';*/
		}
	} //end of If function if txtflag == "ADD"

	else if ($txtFlag == "UPDATE") {
		// Update Query
		// echo " UID in Update section " . $uid;

		$updatesql		= "";
		//$memtype 		= trim($_REQUEST["rad_memtype"]);
		$fname 		= trim($_REQUEST["txtfname"]);
		$lname		= trim($_REQUEST["txtlname"]);
		$affi		= trim($_REQUEST["txtaffi"]);
		$email		= trim($_REQUEST["txtemail"]);
		$email		= $_SESSION['user_id'];
		$ademail	= trim($_REQUEST["txtaddlemail"]);
		$mobile		= trim($_REQUEST["txtmobile"]);
		$phone		= trim($_REQUEST["txtphone"]);
		$nationality	= $_POST['sel_nationality'];
		if (isset($_REQUEST["chk_iim"])) {
			$iim		= "Y";
		} else {
			$iim		= "N";
		}
		if (isset($_REQUEST["chk_isnt"])) {
			$isnt		= "Y";
		} else {
			$isnt		= "N";
		}
		if (isset($_REQUEST["chk_insis"])) {
			$insis		= "Y";
		} else {
			$insis		= "N";
		}



		/*			echo "<BR>Fname : " . $fname;
			echo "<BR>Lname : " . $lname;
			echo "<BR>Affi : " . $affi;
			echo "<BR>Email : " . $email;
			echo "<BR>AEmail : " . $ademail;
			echo "<BR>Mobile : " . $mobile;
			echo "<BR>Phone : " . $phone;
	*/
		$updatesql = "UPDATE contact_table SET au_firstname = '" . $fname . "', au_lastname = '" . $lname . "',
							 au_affiliation = '" . $affi . "',
							 au_addlemailid = '" . $ademail . "',
							 au_mobile = '" . $mobile . "',
							 au_phone = '" . $phone . "',
							 au_nationality = '" . $nationality . "',
							 au_iim = '" . $iim . "',
							 au_isnt = '" . $isnt . "',
							 au_insis = '" . $insis . "'
							 WHERE user_table_ru_id = " . $uid;

		//echo "<BR> " . $updatesql;
		//echo "<BR> " . $iim;
		//exit(0);

		if (mysqli_query($connection, $updatesql) == TRUE) {
			echo '<script>document.getElementById("success").innerHTML = "Updated successfully.";</script>';
			//echo '<meta http-equiv="Refresh" content="2; url=contactinformation.php">';
			$insertflag = "SU";
			$txtFlag = "EDIT";
		} else {
			echo '<script>document.getElementById("error").innerHTML = "Could not updated. Please contact Administrator.";</script>';
			$insertflag = "FU";
			$txtFlag = "FAIL";
		}
		// exit(0); 

	} // end of if txtflag == UPDATE



}
//echo '<br><br>';
//echo "txtFlag at beginning : " . $txtFlag;

?>

<script type="text/javascript">
	// $(document).ready(function() {

	// 	//document.getElementById("txtfname").value = document.getElementById("txtFlag").value;



	// });

	function disableEditFields() {

		if (document.getElementById("txtFlag").value == "EDIT") {
			document.getElementById("txtfname").disabled = true;
			document.getElementById("txtlname").disabled = true;
			document.getElementById("txtaffi").disabled = true;
			document.getElementById("txtmobile").disabled = true;
			document.getElementById("txtphone").disabled = true;
			document.getElementById("txtemail").disabled = true;
			document.getElementById("txtaddlemail").disabled = true;
			document.getElementById("chk_iim").disabled = true;
			document.getElementById("chk_isnt").disabled = true;
			document.getElementById("chk_insis").disabled = true;
			document.getElementById("sel_nationality").disabled = true;
		}

	}



	function editform() {
		document.forms["form1"].action = "contactinformation_edit.php";
		document.forms["form1"].submit();

	}

	function submitform() {


		document.getElementById("txtFlag").value = "ADD";
		document.forms["form1"].action = "contactinformation.php";
		//document.forms["form1"].submit();

	}

	function jsTrigger() {
		var fName1 = document.forms["form1"]["txtfname"].value;
		return true;
	}

	function goToLogin() {
		document.forms["form1"].action = "login.php";
		document.forms["form1"].submit();

	}

	function emailcompare() {
		var email = document.getElementById("txtemail").value;
		var addlemail = document.getElementById("txtaddlemail").value;

		if (email == addlemail) {
			//alert ("Email address should not be same.");
			document.getElementById("error").innerHTML = "Email address should not be same.";
			document.getElementById('btncontact').disabled = true;
			return false;
		} else {
			document.getElementById("error").innerHTML = "";
			document.getElementById('btncontact').disabled = false;
			return true;
		}

	}

	/* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
	function openNav() {
		//   document.getElementById("mySidenav").style.width = "250px";
		//   document.getElementById("main").style.marginLeft = "250px";
	}

	/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
	function closeNav() {
		//   document.getElementById("mySidenav").style.width = "0";
		//   document.getElementById("main").style.marginLeft = "0";
	}
</script>
<!-- content page -->


<!-- Side Nav Bar - Logged in user -->
<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>


<div class="section-header mar-bot30">
	<h2 class="section-heading animated" data-animation="bounceInUp">Contact Information</h2>
</div>

<div class="col-md-8">
	<h5 id="success" class="pull-right" style="color:green;"></h5>
	<h5 id="error" class="pull-right" style="color:red;"></h5>
</div>

<!-- Main content Block -->
<div class="container" id="main">
	<div class="container-fluid pt-2">
		<p style="font-size:12px">All Fields marked with <span class="red">*</span> are mandatory</p>
		<form method="post" id="form1" class="form-horizontal" action="">
			<div class="row">

				<div class="col-md-3">
					<div class="form-inline">
						<label>First Name<span class="red">*</span></label>

					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="txtfname" name="txtfname" placeholder="Enter First Name" minlength="1" maxlength="45" required value="<?php echo $fname; ?>">
					<label for="" class="control-label"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-inline">
						<label>Last Name<span class="red">*</span></label>

					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="txtlname" name="txtlname" placeholder="Enter Last Name" minlength="1" maxlength="45" value="<?php echo $lname; ?>">
					<label for="" class="control-label"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-inline">
						<label>Affiliation</label>

					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="txtaffi" name="txtaffi" placeholder="Enter Affiliation / Institution" minlength="1" maxlength="45" value="<?php echo $affi; ?>">
					<label for="" class="control-label"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-inline">
						<label>Mobile<span class="red">*</span></label>

					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="txtmobile" name="txtmobile" placeholder="Enter Mobile" minlength="1" maxlength="45" required value="<?php echo $mobile; ?>">
					<label for="" class="control-label"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-inline">
						<label>Alternate Mobile</label>

					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="txtphone" name="txtphone" placeholder="Enter Alternate Mobile" minlength="1" maxlength="45" value="<?php echo $phone; ?>">
					<label for="" class="control-label"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-inline">
						<label>Primary Email (Not Editable)</label>

					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="txtemail" name="txtemail" placeholder="Enter Email" minlength="1" maxlength="45" value="<?php echo $email; ?>" disabled>
					<label for="" class="control-label"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="form-inline">
						<label>Additional Email</label>

					</div>
				</div>
				<div class="col-md-6">
					<input type="text" class="form-control" id="txtaddlemail" name="txtaddlemail" placeholder="Enter Additional E-mail" minlength="1" maxlength="45" onblur="return emailcompare()" value="<?php echo $ademail; ?>">
					<label for="" class="control-label"></label>
				</div>
			</div>

			<div class="row">

				<div class="col-md-3 input-select">
					<label for="sel_nationality">Select Nationality <span class="red">*</span></label>
				</div>
				<div class="col-md-6">
					<select class="form-select " name="sel_nationality" id="sel_nationality" width="100%" required>
						<option value="">Select...</option>

						<?php
						$sql = "SELECT * FROM nationality where na_active='Y' ORDER BY na_id";
						$result = mysqli_query($connection, $sql);

						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while ($row = mysqli_fetch_assoc($result)) { ?>
								<option value="<?php echo $row['na_id']; ?>" <?php if ($row['na_id'] == $nationality) {
																					echo "selected";
																				} ?>> <?php echo $row['na_name']; ?></option>

						<?php }
						} else {
							echo "No Nationality found";
						}

						?>
					</select>
				</div>

			</div>
			<div class="row mar-top20">
				<div class="col-md-3">
					<label for="chk_iim">IIM Member</label>&nbsp;&nbsp;&nbsp;
				</div>
				<div class="col-md-6">
					<input type="checkbox" name="chk_iim" id="chk_iim" <?php if ($iim == 'Y') {
																			echo 'checked';
																		}
																		?>>
					<span style="font-size:12px"> &nbsp;&nbsp;&nbsp;(Check this if you are an IIM Member)</span>
				</div>
			</div>
			<div class="row mar-top20">
				<div class="col-md-3">
					<label for="chk_isnt">ISNT Member</label>&nbsp;&nbsp;&nbsp;
				</div>
				<div class="col-md-6">
					<input type="checkbox" name="chk_isnt" id="chk_isnt" <?php if ($isnt == 'Y') {
																				echo 'checked';
																			}
																			?>>
					<span style="font-size:12px"> &nbsp;&nbsp;&nbsp;(Check this if you are an ISNT Member)</span>
				</div>
			</div>
			<div class="row mar-top20">
				<div class="col-md-3">
					<label for="chk_insis">INSIS Member</label>&nbsp;&nbsp;&nbsp;
				</div>
				<div class="col-md-6">
					<input type="checkbox" name="chk_insis" id="chk_insis" <?php if ($insis == 'Y') {
																				echo 'checked';
																			}
																			?>>
					<span style="font-size:12px"> &nbsp;&nbsp;&nbsp;(Check this if you are an INSIS Member)</span>
				</div>
			</div>

	</div>



	<!-- <div class="col-sm-12"> -->

	<div class="row">
		<div class="col-xs-7">
			<!-- <form method="post" id="form1" class="form-horizontal" action=""> -->
			<input type="hidden" id="txtFlag" name="txtFlag" onubmit="return jsTrigger();" value="<?php echo $txtFlag ?>" />

			<div class="form-group">
				<div class="col-xs-8">
					<div class="form-inline">
						<h5 id="success" style="color:green;text-align:center"></h5>
						<h5 id="error" style="color:red;text-align:center"></h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9">
			<!-- TODO : If data is already available, update button to Save Contact -->
			<?php //echo $mode;
			if ($txtFlag == "EDIT") { ?>
				<!-- TODO : Change button type to submit and add onclick js function call. -->
				<!-- <input type="button" class="form-control btn-primary pull-right" name="btncontact" id="btncontact" value="EDIT CONTACT INFORMATION" style="font-size:14px;" "> -->
				<input type="submit" class="form-control btn-primary pull-right" name="btncontact" id="btncontact" value="EDIT CONTACT INFORMATION" style="font-size:14px;" onclick="editform()">
			<?php } else if ($txtFlag == "ADD") { ?>
				<input type="submit" class="form-control btn-primary pull-right" name="btncontact" id="btncontact" value="ADD CONTACT INFORMATION" style="font-size:14px;" onclick="submitform()">
			<?php } else if ($txtFlag == "FAIL") { ?>
				<input type="button" class="form-control btn-primary pull-right" name="btncontact" id="btncontact" value="BACK" style="font-size:14px;" onclick="goToLogin()">
			<?php }
			echo '<script type="text/javascript">disableEditFields();</script>';

			?>
		</div>
		<div class="mar-bot40">&nbsp;</div>
	</div>



	</form>
	<?php if ($insertflag == "F") {
		echo '<script>document.getElementById("error").innerHTML = "Contact details could not be added. Please contact Administrator.";</script>';
	} else if ($insertflag == "FU") {
		echo '<script>document.getElementById("error").innerHTML = "Contact details could not be Updated. Please contact Administrator.";</script>';
	} else if ($insertflag == "S") {
		echo '<script>document.getElementById("success").innerHTML = "Contact details Added successfully.";</script>';
	} else if ($insertflag == "SU") {
		echo '<script>document.getElementById("success").innerHTML = "Contact details Updated successfully.";</script>';
	}
	?>

	<!-- </div> -->
</div>
</div>


<!-- footer -->
<?php include 'includes/footer_loggedin.php'; ?>
<?php include 'includes/script.php'; ?>
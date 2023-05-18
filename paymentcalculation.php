<?php
include "includes/connection.php";
include 'includes/header.php';
include 'includes/menu-loggedin.php';

// $uid1 = "";
// $insertflag = "N";

if (!isset($_SESSION["uid"])) {
	echo '<meta http-equiv="Refresh" content="0; url=index.php">';
	exit(0);
}

$uid = trim($_SESSION["uid"]);
$email 		=	$_SESSION['user_id'];
$nationality = "";
$iim = "";


// if (!isset($_REQUEST["txtFlag"])) {

// First time user comes to this page

// Set the Mode for Add.
// $txtFlag = "ADD";


$fname 		= "";
$lname		= "";
$affi		= "";
//$email		= $emailid;
$ademail	= "";
$mobile		= "";
$phone		= "";
$isnt      = "";
$insis     = "";
$sfa     = "";

$student   = "";

//Fetch data from Database for user


$selsql = "SELECT a.au_firstname, a.au_lastname, a.au_addlemailid, a.au_phone, a.au_mobile, a.au_affiliation, b.na_name, b.na_id as nationality, a.au_iim, a.au_isnt, a.au_insis, a.au_sfa, a.au_student FROM contact_table a, nationality b WHERE a.au_nationality = b.na_id and a.user_table_ru_id = " . $uid . " and au_active = 1";
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
	$sfa 		= $result['au_sfa'];

	$student	= $result['au_student'];
	$nationality	= $result['nationality'];

	$naname = $result['na_name'];

	$member = "";
	if ($iim == 'Y') {
		$member = "IIM";
	}
	if ($isnt == 'Y') {
		$member .= " ISNT";
	}
	if ($insis == 'Y') {
		$member .= " INSIS";
	}
	if ($sfa == 'Y') {
		$member .= " SFA";
	}

	//Update Membership Flag
	if ($member != "") {
		$isMember = "Y";
	} else {
		$isMember = "N";
		$member = "None";
	}
	// $isMember = $member;

	//Update Student Flag
	$student = ($student == 'Y' ? 'YES' : 'NO');
} else {
?>

	<div class="mar-top30">&nbsp;</div>

	<?php include 'includes/admin_sidenav.php'; ?>

	<!-- Header area start -->
	<div class="section-header mar-bot30">
		<h2 class="section-heading animated" data-animation="bounceInUp">Payment Calculation</h2>
	</div>

	<!-- Header area end -->

	<!-- Main content Block -->
	<div class="container" id="main">
		<div class="container-fluid pt-2">
			<div class="userinfo">
				<table width="100%" class=" ">
					<tr>
						<td style="text-align:center;color:red;font-size:16px;font-weight:bold;" >Please update Contact Information</td>
					</tr>
					<tr>
						<td style="text-align:center">Contact Information is required to calculate Fees.</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="mar-top30">&nbsp;</div>
	<div class="mar-top30">&nbsp;</div>
	<div class="mar-top30">&nbsp;</div>
	<div class="mar-top30">&nbsp;</div>
	<div class="mar-top30">&nbsp;</div>
	<div class="mar-top30">&nbsp;</div>
	
		<?php

 include 'includes/footer_loggedin.php';
 include 'includes/script.php';
		exit(0);
	}

		?>


		<script type="text/javascript">
			//  $(document).ready(function() {

			function calculateFees(nationalityid) {
				var userCurrency = "";
				var userCountry = "";
				var userStudent = "Y";
				var userMembership = "Y";
				var userStudent = "N";

				var feeSummaryText = "";
				var totalFees = "";
				var GTotalFees = 0;


				if (nationalityid == 82) {
					userCountry = "IN";
					currency = "INR";

					confFees = 12000;
					memberFees = 10000;
					spouseFees = 5000;
					studentFees = 5000;


					preConf1 = 2000;
					preConf2 = 2000;

					var isMember = document.getElementById("isMember").value;
					if (isMember == 'Y') {
						confFees = memberFees;
					}
					var isStudent = document.getElementById("isStudent").value;
					if (isStudent == 'YES') {
						confFees = studentFees;
					}




				} else {
					userCountry = "US";
					currency = "USD";

					confFees = 400;
					spouseFees = 200;
					studentFees = 200;

					var isStudent = document.getElementById("isStudent").value;
					if (isStudent == 'YES') {
						confFees = studentFees;
					}

				}

				if (userCountry == "IN") {

					// var totalFees = "";

					var confFlag = 0;
					var preconfFlag1 = 0;
					var preconfFlag2 = 0;
					var spouseFlag = 0;


					if (document.getElementById("chk_conference").checked == true) {
						// totalFees = 12000;
						confFlag = 1;
					}
					if (document.getElementById("chk_preconference1").checked == true) {
						// totalFees = totalFees += 2000;
						preconfFlag1 = 1;
					}
					if (document.getElementById("chk_preconference2").checked == true) {
						// totalFees = totalFees += 2000;
						preconfFlag2 = 1;
					}
					if (document.getElementById("chk_spouse").checked == true) {
						// totalFees = totalFees += 5000;
						spouseFlag = 1;
					}


					if (confFlag == 1) {
						feeSummaryText = "Conference Fees :<BR>"
						totalFees = confFees + "<BR>";
						GTotalFees = confFees;

					}
					if (preconfFlag1 == 1) {
						feeSummaryText += "Pre-Conference (1) Fees :<BR>"
						totalFees += preConf1 + "<BR>";
						GTotalFees += preConf1;
					}
					if (preconfFlag2 == 1) {
						feeSummaryText += "Pre-Conference (2) Fees :<BR>"
						totalFees += preConf2 + "<BR>";
						GTotalFees += preConf2;
					}
					if (spouseFlag == 1) {
						feeSummaryText += "Spouse Fees :"
						totalFees += spouseFees + "<BR>";
						GTotalFees += spouseFees;
					}

					feeSummaryText = "<p>" + feeSummaryText + "</p>";
					// alert(feeSummaryText);


					document.getElementById("feesSummary").innerHTML = feeSummaryText;
					document.getElementById("feesValue").innerHTML = totalFees;
					document.getElementById("feesTotal").innerHTML = "Total";
					document.getElementById("feesTotalValue").innerHTML = GTotalFees;

					document.getElementById("hrTotal").style.visibility = 'visible';
					document.getElementById("hrTax").style.visibility = 'visible';

					//Calculate Tax
					taxAmount = GTotalFees * (18 / 100);

					document.getElementById("taxValue").innerHTML = "GST (18%)";
					document.getElementById("taxAmount").innerHTML = taxAmount;



					document.getElementById("totalWithTaxCaption").innerHTML = "Total (Including TAX)";
					document.getElementById("totalWithTaxAmount").innerHTML = taxAmount + GTotalFees;


				} else {
					// currency = "USD";
					var confFlag = 0;
					var preconfFlag = 0;
					var spouseFlag = 0;



					if (document.getElementById("chk_conference").checked == true) {
						// totalFees = 12000;
						confFlag = 1;
					}
					// if (document.getElementById("chk_preconference").checked == true) {
					// 	// totalFees = totalFees += 2000;
					// 	preconfFlag = 1;
					// }
					if (document.getElementById("chk_spouse").checked == true) {
						// totalFees = totalFees += 5000;
						spouseFlag = 1;
					}


					if (confFlag == 1) {
						feeSummaryText = "Conference Fees :<BR>"
						totalFees = confFees + "<BR>";
						GTotalFees = confFees;

					}
					// if (preconfFlag == 1) {
					// 	feeSummaryText += "Pre-Conference Fees :<BR>"
					// 	totalFees += preConf1 + "<BR>";
					// 	GTotalFees += preConf1;
					// }
					if (spouseFlag == 1) {
						feeSummaryText += "Spouse Fees :"
						totalFees += spouseFees + "<BR>";
						GTotalFees += spouseFees;
					}

					feeSummaryText = "<p>" + feeSummaryText + "</p>";
					// alert(feeSummaryText);


					document.getElementById("feesSummary").innerHTML = feeSummaryText;
					document.getElementById("feesValue").innerHTML = totalFees;
					document.getElementById("feesTotal").innerHTML = "Total";
					document.getElementById("feesTotalValue").innerHTML = GTotalFees;

					document.getElementById("hrTotal").style.visibility = 'visible';
					document.getElementById("hrTax").style.visibility = 'visible';

					//Calculate Tax
					taxAmount = GTotalFees * (18 / 100);

					document.getElementById("taxValue").innerHTML = "GST (18%)";
					document.getElementById("taxAmount").innerHTML = taxAmount;



					document.getElementById("totalWithTaxCaption").innerHTML = "Total (Including TAX)";
					document.getElementById("totalWithTaxAmount").innerHTML = taxAmount + GTotalFees;

				}
				document.getElementById("spanCurrency").innerHTML = "(" + currency + ")";


				// var totalCalculatedFees = confFees + preConf1 + spouseFees;
				// alert(totalCalculatedFees);

			}


			// });
		</script>

		<style>
			#hrTotal,
			#hrTax {
				margin-top: 2px !important;
				margin-bottom: 2px !important;
				border: 1px solid rgb(152 147 147)
			}
		</style>

		<!-- content page -->


		<!-- Side Nav Bar - Logged in user -->
		<div class="mar-top30">&nbsp;</div>

		<?php include 'includes/admin_sidenav.php'; ?>

		<!-- Header area start -->
		<div class="section-header mar-bot30">
			<h2 class="section-heading animated" data-animation="bounceInUp">Payment Calculation</h2>
		</div>

		<div class="col-md-8">
			<h5 id="success" class="pull-right" style="color:green;"></h5>
			<h5 id="error" class="pull-right" style="color:red;"></h5>
		</div>

		<input type="hidden" id="isStudent" value="<?php echo $student ?>">
		<input type="hidden" id="isMember" value="<?php echo $isMember ?>">


		<!-- Header area end -->

		<!-- Main content Block -->
		<div class="container" id="main">
			<div class="container-fluid pt-2">
				<div class="userinfo">
					<table width="100%" class=" ">
						<tr>
							<td id="tblCaption">Name</td>
							<td><?php echo $fname . "  " . $lname ?></td>
						</tr>
						<tr>
							<td>Nationality (Country)</td>
							<td><?php echo $naname   ?></td>
						</tr>
						<tr>
							<td>Membership</td>
							<td><?php echo $member ?></td>
						</tr>
						<tr>
							<td>Student</td>
							<td><?php echo $student ?></td>
						</tr>
					</table>
				</div>

				<div class="mar-top30">&nbsp;</div>

				<form action="">
					<h3 style="text-align:center">Fees Calculation</h3>

					<!-- Fees Calculation Block - left block - start -->
					<div class="col-xs-6 mx-auto block-info1">
						<div class="row mar-bot30">
							<p>Select the following options to calculate the total fees</p>
						</div>

						<div class="row mar-bot10">
							<div class="col-md-8">
								<label for="chk_conference" class="mar-left20">Attending Conference</label>
							</div>
							<div class="col-md-2">
								<input type="checkbox" name="chk_conference" id="chk_conference">
							</div>
						</div>

						<?php if ($nationality == 82) { ?>
							<div class="row mar-bot10" id="preconfBlock">
								<div class="col-md-8 ">
									<label for="chk_preconference1" class="mar-left20">Attending Pre-Conference Workshop<br><span style="font-weight:400">(FFASC)</span></label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" name="chk_preconference1" id="chk_preconference1">
								</div>
							</div>
							<div class="row mar-bot10" id="preconfBlock">
								<div class="col-md-8 ">
									<label for="chk_preconference2" class="mar-left20">Attending Pre-Conference Workshop<br><span style="font-weight:400"> (Large Size Components)</span></label>
								</div>
								<div class="col-md-2">
									<input type="checkbox" name="chk_preconference2" id="chk_preconference2">
								</div>
							</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-8">
								<label for="chk_spouse" class="mar-left20">Include Spouse</label>
							</div>
							<div class="col-md-2">
								<input type="checkbox" name="chk_spouse" id="chk_spouse">
							</div>
						</div>

						<div class="row ">
							<div class="btn btn-success btn-fees-calculate" onclick="javascript:calculateFees(<?php echo $nationality ?>);">Calculate</div>
						</div>
					</div>

					<!-- Fees Summary Block Start -->

					<div class="col-xs-4 mx-auto block-info2" style="min-height:200px;">
						<p style="text-align:center;padding-top:3px;"><strong>Fees Summary <span id="spanCurrency"></span> </strong></p>
						<div class="row" style="display:flex; flex-direction:row;">
							<div class="col-md-8" id="feesSummary" style="font-weight:500"></div>
							<div class="col-md-2" id="feesValue" style="font-weight:500;text-align:right;"></div>

						</div>
						<div class="row" style="margin-bottom:auto;margin-top:3px;">
							<hr id="hrTotal" style="visibility:hidden;">
							<div class="col-md-8" id="feesTotal" style="font-weight:bold;"></div>
							<div class="col-md-2" id="feesTotalValue" style="font-weight:bold;font-size:16px;text-align:right;"></div>
						</div>
						<div class="row" style="margin-top:3px;">
							<hr id="hrTax" style="visibility:hidden">
							<div class="col-md-8" id="taxValue" style="font-weight:500;color:black;font-size:14px;"></div>
							<div class="col-md-2" id="taxAmount" style="font-weight:500;font-size:14px;text-align:right;"></div>
						</div>
						<div class="row" style="margin-top:3px;">
							<!-- <hr id="hrTax" style="margin-left:10px; margin-right:10px;border:1px solid #e6e6e6;"> -->
							<div class="col-md-8" id="totalWithTaxCaption" style="font-weight:bold;color:black;font-size:14px;"></div>
							<div class="col-md-2" id="totalWithTaxAmount" style="font-weight:bold;font-size:16px;margin-bottom:10px;"></div>
						</div>
					</div>

				</form>
			</div>

			<div class="mar-top30">&nbsp;</div>
			<div class="mar-top30">&nbsp;</div>
			<div class="mar-top30">&nbsp;</div>



		</div>



		 <!-- footer -->
			<?php include 'includes/footer_loggedin.php'; ?>
			<?php include 'includes/script.php'; ?>
<?php
include "includes/connection.php";
include 'includes/header.php';
include 'includes/menu-loggedin.php';


if (!isset($_SESSION["uid"])) {
	header('Location: index.php');
	// echo '<meta http-equiv="Refresh" content="0; url=index.php">';
	exit(0);
}
//echo '	<br><br><br><br><br><br>';
//Redirecting to Payment View page, if already payment information added.
$uid = $_SESSION["uid"];
$selsql = "select * from payment where user_table_ru_id = " . $uid . " and pm_active=1";

$result = mysqli_query($connection, $selsql);
$numrows = mysqli_num_rows($result);

if(isset($_REQUEST["user_id"])){
echo trim($_REQUEST["mode"]);
} else {

	if ($numrows == 1) {

		header('Location: paymentdetails-edit.php');
		// echo '<meta http-equiv="Refresh" content="2; url=paymentdetails-edit.php">';
		exit(0);
	}
}


?>

<script>
	$(document).ready(function() {
		//$( "#txtpaydate" ).datepicker({  maxDate: new Date() });

		var dtToday = new Date();

		var month = dtToday.getMonth() + 1;
		var day = dtToday.getDate();
		var year = dtToday.getFullYear();
		if (month < 10)
			month = '0' + month.toString();
		if (day < 10)
			day = '0' + day.toString();

		var maxDate = year + '-' + month + '-' + day;

		$('#txtpaydate').attr('max', maxDate);


	});
</script>
<!-- content page -->


<!-- Side Nav Bar - Logged in user -->
<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<!-- Header area start -->
<div class="section-header mar-bot30">
	<h2 class="section-heading animated" data-animation="bounceInUp">Payment Information</h2>
</div>

<div class="col-md-8">
	<h5 id="success" class="pull-right" style="color:green;"></h5>
	<h5 id="error" class="pull-right" style="color:red;"></h5>
</div>

<!-- Header area end -->
<div class="container" id="main">
	<div class="container-fluid pt-2">

		<form method="post" class="form-horizontal" action="paymentdetails.php">
			<div class="row">
				<div class="col-md-6">
					<select class="form-control" name="selpay" id="selpay" required>
						<option value="">Mode of Payment</option>
						<option value="Cheque">Cheque</option>
						<option value="Demand Draft">Demand Draft</option>
						<option value="NEFT">NEFT</option>
						<option value="IMPS">IMPS</option>
						<option value="Wire Transfer">Wire Transfer</option>
						<option value="Institutional Payment">Institutional Payment</option>
						<option value="Google Pay">Google Pay</option>
					</select>
					<label for="" class="control-label" style="margin-top:-6%"></label>
				</div>
				<div class="col-md-3">
					<select class="form-control" name="sel_currency" id="sel_currency">
						<option value="Rs">Rs</option>
						<option value="USD">USD</option>
						<option value="EURO">EURO</option>
					</select>
				</div>
				<div class="col-md-3">
					<input type="number" class="form-control" id="txtamount" name="txtamount" placeholder="Amount" minlength="1" maxlength="45" required>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="txtbank" id="txtbank" class="form-control" value="" placeholder="Bank Name" minlength="3" maxlength="150" required>
				</div>
				<div class="col-md-4">
					<input type="text" name="txtbranch" id="txtbranch" class="form-control" value="" placeholder="Branch" minlength="3" maxlength="50" required>
					<label for="" class="control-label" style="margin-top:-6%"></label>
				</div>
				<div class="col-md-4">
					<input type="text" name="txtpaydate" id="txtpaydate" class="form-control" value="" placeholder="Payment Date" onfocus="(this.type='date')" required>
					<label for="" class="control-label" style="margin-top:-6%"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7">
					<input type="text" class="form-control" id="txttransid" name="txttransid" placeholder="Transaction ID" maxlength="50" required>
					<label for="" class="control-label" style="margin-top:-6%"></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7">
					<textarea name="txtacomm" id="txtacomm" class="form-control" rows="8" cols="80" placeholder="Comments"></textarea>
					<label for="" class="control-label" style="margin-top:-6%"></label>
				</div>
				<div class="col-md-4">
					<p style="font-weight:bold;">Notes:</p>
					<ul>
						<li style="font-weight:600;">For the Amount field, only Numbers and no currency format or special characters allowed.<br>
							<i>Sample amount format :</i> 2000<br>
						</li>
						<!-- <li><small class="text-muted">Cheque Payment would be credited only on realisation.<br/></small></li> -->
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-7">
				<input type="submit" class="form-control btn-success" name="subpayinfo" id="subpayinfo" width="200px" value="Add Payment Details">
				</div>
				<div class="mar-bot40">&nbsp;</div>
			</div>

		</form>

	</div>
</div>
<?php

if (isset($_REQUEST["subpayinfo"])) {
	$inssql		= "";
	$pmode 		  	= $_REQUEST["selpay"];
	$amount 		= $_REQUEST["txtamount"];
	$bank		    = $_REQUEST["txtbank"];
	$branch			= $_REQUEST["txtbranch"];
	$paydate		= $_REQUEST["txtpaydate"];
	$transid		= $_REQUEST["txttransid"];
	$comments		= $_REQUEST["txtacomm"];
	$currency		= $_REQUEST["sel_currency"];

	// for email view
	/* switch ($pay) {
		case "C":
		$pmode="Cheque";
		break;
		case "D":
		$pmode= "Demand Draft";
		break;
		case "N":
		$pmode = "NEFT";
		break;
		case "I":
		$pmode= "IMPS";
		break;
		case "W":
		$pmode= "Wire Transfer";
		break;
		case "P":
		$pmode= "Institutional Payment";
		break;

		default:
		$pmode="";
		break;
	} */

	// emsi member
	/*	if (isset($_REQUEST['txt_memberid']) && !empty($_REQUEST['txt_memberid'])) {
		$emsimember=$_REQUEST['txt_memberid'];
		$userid=$_SESSION['uid'];
		$sql="UPDATE emsi_user_table SET emsi_member='$emsimember' where ru_id='$userid' ";
		mysqli_query($connection, $sql);

	}
	elseif ($_REQUEST['txt_memberid'] == "0")
	{
		$emsimember=$_REQUEST['txt_memberid'];
		$userid=$_SESSION['uid'];
		$sql="UPDATE emsi_user_table SET emsi_member='$emsimember' where ru_id='$userid' ";

		if (mysqli_query($connection, $sql) === TRUE) {

			$ssql="SELECT emsi_id, ru_userid FROM emsi_user_table WHERE ru_id='$userid'";
			$result=(mysqli_query($connection, $ssql));

			if ($row=mysqli_num_rows($result)== 1) {
				$row=mysqli_fetch_assoc($result);
				$useremsiid		=$row['emsi_id'];

				$esql="SELECT au_emailid, au_mobile FROM emsi_author_table WHERE emsi_user_table_ru_id='$userid' AND au_author_type='P'" ;
				$sresult=mysqli_query($connection , $esql);

				if (mysqli_num_rows($sresult)== 1) {
					$arow=mysqli_fetch_assoc($sresult);

					$aemail  =$arow['au_emailid'];
					$amobile =$arow['au_mobile'];
				}

				require ('emailheaders.php');
				// sent mail to Admin mail
				// $email=base64_encode($ru_email);
				$replyto = "emsiwebteam@gmail.com";
				$to = ADMIN_EMAIL; //$useremail;   // to address user mail id
				$subject = 'EMSI-2017 Conference: '.$useremsiid.' requesting Membership ID';  //mail subject
				$headers  = "From: EMSI<info@emsi.org.in>\r\n";     
				$headers .= "Reply-To: $replyto \r\n"; //message header
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= "Return-Path: $replyto\r\n";
				$headers .= "X-Mailer: PHP \r\n";

				// echo       $msg='<a href="'.SITE_URL.'verify.php?em='. $email.'" >click here to confirm</a>';
				/* $message=file_get_contents('verify_header.php');
				$message.='<a href="'.SITE_URL.'verify.php?em='. $email.'" >click here to confirm</a>';
				$message.=file_get_contents('verify_footer.php');
				*/

	/*				$message = '
				 <!DOCTYPE html>
 				<html lang="en">
 				<head>
 				<!-- Required meta tags always come first -->
 				<meta charset="utf-8">
 				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 				<meta http-equiv="x-ua-compatible" content="ie=edge">
 				<title>emsi</title>
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
 				<table>
					<tr>
						<td> <img src="http://www.icreach2022.com/img/logo/emsi1.png" alt="" class="img-resposnive center-block"></td>
						<td><p style="color:navy; font-size:16px;"><b>ICREACH 2022 Conference - Requisition of Membership ID</b></p></td>
					</tr>
					</table>
 				<div class="container" id="mail" style="">
 				<!-- <p style="font-size:24px;color:#000;text-align:center"><b>Requisition of Membership ID</b></p> -->
 				<br/>

 				<p>This is an automated email from the EMSI Manuscript Submission System. Since this is an unmanned mail id, please DO NOT REPLY to this mail.
 				The details of the user who triggered this email is given below</p>
 				</div>
 				<br/>

 				<div class="row">
 				<div class="col-sm-2">

 				</div>
 				<div class="col-sm-8">

 				<p><b>Presenting Author Information</b></p>
 				<table class="table table-bordered">
 				<tr>
 				<th width="50%">EMSI ID</th>
 				<td>'.$useremsiid.'</td>
 				</tr>
 				<tr>
 				<th>E-Mail</th>
 				<td>'.$aemail.'</td>
 				</tr>
 				<tr>
 				<th>Phone</th>
 				<td>'.$amobile.'</td>
 				</tr>
 				</table>
 				<br/>
 				<p><b>Payment Information</b></p>
 				<table class="table table-bordered">
 				<tr>
 				<th width="50%">Mode of Payment </th>
 				<td>'.$pmode.'</td>

 				</tr>
 				<tr>
 				<th>Amount</th>
 				<td>'.$currency.' '.$amount.'</td>
 				<tr>
 				<tr><th>Bank Name</th>
 				<td>'.$bank.'</td>
 				<tr>
 				<tr><th>Branch</th>

 				<td>'.$branch.'</td>
 				<tr>
 				<tr><th>Payment date</th>

 				<td>'.$paydate.'</td>
 				<tr>
 				<tr><th>Transaction ID</th>

 				<td>'.$transid.'</td>
 				</tr>
 				<tr>
 				<th>Comments</th>
 				<td>'.$comments.'</td>
 				</tr>
 				</table>
 				</div>
 				</div>

 				<p style="font-size:15px">Best regards,</p>
 				<p style="font-size:15px">EMSI 2017 Team</p>

 				</div>
 				<div class="container footer">
 				<p class="footer">Copyrights EMSI 2017. All rights reserved.</p> </div> </div>


 				<!-- jQuery first, then Bootstrap JS. --> <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
 				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"> </script> </body>

 				</html>
				';

				// mail meassage
				mail($to, $subject, $message, $headers);
			}
		}
	}
	// emsi member
	if (isset($_REQUEST['txt_memberid'])) {
		$emsimember=$_REQUEST['txt_memberid'];
		$userid=$_SESSION['uid'];
		$sql="UPDATE emsi_user_table emsi_member='$emsimember' where ru_id='$userid' ";
		if (mysqli_query($connection, $sql) == TRUE)
		{

		}
	}
*/

	$inssql = "INSERT into payment (pm_mode_of_payment, pm_amount, pm_currency, pm_payment_date, pm_transaction_id, pm_payeebank, pm_branch, pm_comments, user_table_ru_id, pm_active) values ('$pmode', $amount,'$currency', '$paydate', '$transid', '$bank', '$branch', '$comments', " . $_SESSION['uid'] . ", 1)";

	if (mysqli_query($connection, $inssql) == TRUE) {
		echo '<script>document.getElementById("success").innerHTML = "Added successfully.";
		document.getElementById("subpayinfo").disabled = true;
		</script>';
		echo '<meta http-equiv="Refresh" content="2; url=paymentdetails-edit.php">';
		exit(0);
	} else {
		echo '<script>document.getElementById("errorpay").innerHTML = "Payment could not be added. Please contact Administrator.";</script>';
	}
}

?>
<!-- footer -->
<?php include 'includes/footer_loggedin.php'; ?>
<?php include 'includes/script.php'; ?>
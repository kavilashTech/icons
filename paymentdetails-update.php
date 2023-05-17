<?php
include "includes/connection.php";
include 'includes/header.php';
include 'includes/menu-loggedin.php';

if (!isset($_SESSION["uid"])) {
	header('Location: index.php');
	// echo '<meta http-equiv="Refresh" content="0; url=index.php">';
	exit(0);
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
<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<div class="section-header mar-bot30">
	<h2 class="section-heading animated" data-animation="bounceInUp">Payment Information</h2>
</div>
<div class="mar-top30">&nbsp;</div>
<div class="container" id="main">
	<div class="container-fluid" id="paymentDisplay">

		<div class="row">


			<div class="col-sm-7 pl-0">
				<form method="post" class="form" action="paymentdetails-update.php">
					<?php
					$selsql = "select * from payment where user_table_ru_id = " . $_SESSION["uid"] . " and pm_active=1";

					$result = mysqli_query($connection, $selsql);
					//$numrows = mysqli_num_rows($result);

					$row = $result->fetch_assoc();
					$pmid		=	$row['pm_id'];
					$pmode		=	$row['pm_mode_of_payment'];
					$amount 	=	number_format($row['pm_amount']);
					$currency 	=	$row['pm_currency'];
					$paydate	=	date("d-m-Y", strtotime($row["pm_payment_date"]));
					$tranid		=	$row['pm_transaction_id'];
					$bank		=	$row['pm_payeebank'];
					$branch		=	$row['pm_branch'];
					$comment	=	$row['pm_comments'];


					?>

					<div class="row">
						<div class="" id="successpay" style="color:green;font-weight:bold;text-align:center"></div>
						<div class="" id="errorpay" style="color:green;font-weight:bold;color:red;text-align: center"></div>
						<div class="col-sm-6">


							<div class="form-group required">
								<div class="form-inline">
									<input type="hidden" class="form-control " value="<?php echo $pmid; ?>" id="pmid" name="pmid">
									<select class="form-control" name="selpay" id="selpay">
										<option value="0">Mode of Payment</option>

										<?php


										$cmsg = "";
										$dmsg = "";
										$nmsg = "";
										$imsg = "";
										$wmsg = "";
										$pmsg = "";
										$gmsg = "";


										if ($row["pm_mode_of_payment"] == "Cheque") {
											$cmsg = "selected";
										} elseif ($row["pm_mode_of_payment"] == "Demand Draft") {
											$dmsg = "selected";
										} elseif ($row["pm_mode_of_payment"] == "NEFT") {
											$nmsg = "selected";
										} elseif ($row["pm_mode_of_payment"] == "IMPS") {
											$imsg = "selected";
										} elseif ($row["pm_mode_of_payment"] == "Wire Transfer") {
											$wmsg = "selected";
										} elseif ($row["pm_mode_of_payment"] == "Institutional Payment") {
											$pmsg = "selected";
										} elseif ($pmode == "Google Pay") {
											$gmsg = "selected";
										}


										?>

										<option value="Cheque" <?php echo $cmsg; ?>>Cheque</option>
										<option value="Demand Draft" <?php echo $dmsg; ?>>Demand Draft</option>
										<option value="NEFT" <?php echo $nmsg; ?>>NEFT</option>
										<option value="IMPS" <?php echo $imsg; ?>>IMPS</option>
										<option value="Wire Transfer" <?php echo $wmsg; ?>>Wire Transfer</option>
										<option value="Institutional Payment" <?php echo $pmsg; ?>>Institutional Payment</option>
										<option value="Google Pay" <?php echo $gmsg; ?>>Google Pay</option>

									</select>

									<label for="" class="control-label" style="margin-top:-6%"></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-5" style="padding-right: 0px;">
									<select class="form-control" name="sel_currency">
										<option value="Rs" <?php if ($row["pm_currency"] == "RS") {
																echo "selected";
															} else {
																echo "";
															} ?>>Rs</option>
										<option value="USD" <?php if ($row["pm_currency"] == "USD") {
																echo "selected";
															} else {
																echo "";
															} ?>>USD</option>
										<option value="EURO" <?php if ($row["pm_currency"] == "EURO") {
																	echo "selected";
																} else {
																	echo "";
																} ?>>EURO</option>
									</select>
								</div>
								<div class="col-sm-6" style="padding-right: 0px;
												padding-left: 6px;">
									<div class="form-group required">
										<div class="form-inline">
											<input type="text" class="form-control" id="txtamount" name="txtamount" value="<?php echo $row["pm_amount"]; ?>" placeholder="Amount" maxlength="5" required style="width:95%">
											<label for="" class="control-label" style="margin-top:-6%"></label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group required">
								<div class="form-inline">
									<input type="text" name="txtbank" id="txtbank" class="form-control" value="<?php echo $row["pm_payeebank"]; ?>" placeholder="Bank Name" minlength="3" maxlength="150" required style="width:95%">
									<label for="" class="control-label" style="margin-top:-6%"></label>
								</div>

							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group required">
								<div class="form-inline">
									<input type="text" name="txtbranch" id="txtbranch" class="form-control" placeholder="Branch" value="<?php echo $row["pm_branch"]; ?>" minlength="3" maxlength="50" required style="width:95%">
									<label for="" class="control-label" style="margin-top:-6%"></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group required">
								<div class="form-inline">
									<input type="text" name="txtpaydate" id="txtpaydate" class="form-control" value="<?php echo date("d-m-Y", strtotime($row["pm_payment_date"])); ?>" placeholder="Payment Date" onfocus="(this.type='date')" required style="width:95%">
									<label for="" class="control-label" style="margin-top:-6%"></label>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group required">
								<div class="form-inline">
									<input type="text" class="form-control" id="txttransid" name="txttransid" placeholder="Transaction ID" value="<?php echo $row["pm_transaction_id"]; ?>" maxlength="50" required style="width:95%">
									<label for="" class="control-label" style="margin-top:-6%"></label>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<div class="form-inline">
									<textarea name="txtacomm" id="txtacomm" class="form-control" rows="8" cols="80" style="width:99%"><?php echo $row["pm_comments"]; ?></textarea>
									<label for="" class="control-label" style="margin-top:-6%"></label>
								</div>
							</div>

						</div>
						<div class="col-sm-1">

						</div>
						<div class="col-sm-6">
							<div class="form-group">

								<div id="success" style="color:green;text-align:center; font-size:10px"></div>
								<div id="error" style="color:red;text-align:center; font-size:10px"></div>

								<!-- <h5 id="success" style="color:green;text-align:center"></h5> <br>
											<h5 id="error" style="color:red;text-align:center"></h5>
										-->
								<input type="submit" class="btn form-control btn-primary" name="subpayinfo" id="subpayinfo" value="Update Payment Details">
								<!-- <a href="paymentdetails-edit.php" class="btn btn-primary" class="center-block">UPDATE</a> -->

							</div>
						</div>
						<div class="col-sm-3">

							<a href="paymentdetails.php" class=" btn btn-primary">Cancel</a>
						</div>

					</div>

				</form>
			</div>
			<div class="col-sm-4">
				<p>Notes:</p>
				<ul>

					<li><small class="text-muted">Sample amount format 2000.<br>Only Numbers and no currency format or special characters allowed.<br /></small></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php


if (isset($_REQUEST["subpayinfo"])) {
	$inssql				= "";
	$pmid				= trim($_REQUEST["pmid"]);
	$pay 				= trim($_REQUEST["selpay"]);
	$amount 			= trim($_REQUEST["txtamount"]);
	$bank				= trim($_REQUEST["txtbank"]);
	$branch				= trim($_REQUEST["txtbranch"]);
	$paydate			= $_REQUEST["txtpaydate"]; //date("d-m-Y", strtotime($_REQUEST["txtpaydate"])); //trim($_REQUEST["txtpaydate"]);
	$transid			= trim($_REQUEST["txttransid"]);
	$comments			= trim($_REQUEST["txtacomm"]);
	$currency			= trim($_REQUEST["sel_currency"]);



	$paydate = date("Y-m-d", strtotime($paydate));

	$updsql = "UPDATE payment SET pm_mode_of_payment = '$pay', pm_currency='$currency', pm_amount = $amount,  pm_payment_date = '$paydate', pm_transaction_id = '$transid', pm_payeebank = '$bank', pm_branch = '$branch', pm_comments = '$comments', user_table_ru_id = " . $_SESSION['uid'] . ", pm_active = 1 WHERE pm_id = $pmid";


	if (mysqli_query($connection, $updsql) == TRUE) {
		echo '<script>document.getElementById("successpay").innerHTML = "Updated successfully.<br>";
	document.getElementById("subpayinfo").disabled = true;

	</script>';
		header('Location: paymentdetails-edit.php');
		// echo '<meta http-equiv="Refresh" content="2; url=paymentdetails-edit.php">';
		exit(0);
	} else {
		echo '<script>document.getElementById("errorpay").innerHTML = "Could not added. Please contact Administrator.";</script>';
	}
}
?>

<!-- footer -->
<?php include 'includes/footer_loggedin.php'; ?>
<?php include 'includes/script.php'; ?>
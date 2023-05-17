<?php

include "includes/connection.php";
include 'includes/header.php';
include 'includes/menu-loggedin.php';

if (!isset($_SESSION["uid"])) {
  header('Location: index.php');
  //  echo '<meta http-equiv="Refresh" content="0; url=index.php">';
  exit(0);
}
$uid = $_SESSION["uid"];

$selsql = "select * from payment where user_table_ru_id = " . $uid . " and pm_active=1";
//echo "<br><br><br><br>";
$result = mysqli_query($connection, $selsql) or die(mysqli_error($db));
$row = $result->fetch_assoc();

?>
<!-- content page -->

<style>
  #paymentDisplay .row div:first-child {
    color: red;
  }

  .tbl-payment {
    margin-left: auto;
    margin-right: auto;
    color: black;
  }

  .tbl-payment tr td {
    font-size: 18px;
    padding: 8px;
  }

  .tbl-payment tr td:first-child {
    color: blue;
    font-weight: 800;
  }

  .btnPaymentEdit {
    margin-top: 10px;
    width: 100px;
    text-align: center;
    display:inline; 
    float:right;
    border-radius:5px;
    color: white;
    text-decoration: none;
  }
</style>



<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<div class="section-header mar-bot30">
  <h2 class="section-heading animated" data-animation="bounceInUp">Payment Information</h2>
</div>
<div class="mar-top30">&nbsp;</div>
<div class="container" id="main">
  <div class="container-fluid" id="paymentDisplay">

      <div class="row">
      <div class="col-md-12">
        <table width="70%" style="margin-left:auto;margin-right:auto;" class="tbl-payment">
          <tr width="50%">
            <td>Mode of Payment:</td>
            <td><?php echo $row["pm_mode_of_payment"] ?></td>
          </tr>
          <tr>
            <td>Amount</td>
            <td><?php echo $row['pm_currency'] . "  " .  number_format($row["pm_amount"]) ?> </td>
          </tr>
          <tr>
            <td>Bank Name</td>
            <td><?php echo $row["pm_payeebank"] ?></td>
          </tr>
          <tr>
            <td>Branch</td>
            <td><?php echo $row["pm_branch"] ?></td>
          </tr>
          <tr>
            <td>Payment Date</td>
            <td><?php echo date("d-m-Y", strtotime($row["pm_payment_date"])); ?></td>
          </tr>
          <tr>
            <td>Transaction ID</td>
            <td><?php echo $row["pm_transaction_id"] ?></td>
          </tr>
          <tr>
            <td>Comments</td>
            <td><?php echo $row["pm_comments"] ?></td>
          </tr>
          <tr>
            <td colspan="2" style="border:none;padding-top:20px">
            <a href="paymentdetails-update.php?user_id=<?php echo $row["pm_id"]; ?>" class="btn-sm btn-primary btnPaymentEdit" >EDIT</a>
            </td>
          </tr>
        </table>
      </div>

    </div>

  </div>
</div>
<div class="mar-top30">&nbsp;</div>
<div class="mar-top30">&nbsp;</div>
<div class="mar-top30">&nbsp;</div>
<div class="mar-top30">&nbsp;</div>
<div class="mar-top30">&nbsp;</div>
<div class="mar-top30">&nbsp;</div>


<!-- footer -->
<?php include 'includes/footer_loggedin.php'; ?>
<?php include 'includes/script.php'; ?>
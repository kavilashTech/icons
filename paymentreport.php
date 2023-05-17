<?php
include 'includes/header.php';
include 'includes/connection.php';
include 'includes/menu-loggedin.php';

if (!isset($_SESSION["uid"])) {
   echo '<meta http-equiv="Refresh" content="0; url=index.php">';
   exit(0);
}
?>

<link href="pagination/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="pagination/css/A_green.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
   $(document).ready(function() {
      $("#table_pay").DataTable();
   });
</script>
<!-- content page -->

<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<div class="section-header mar-bot30">
   <h2 class="section-heading animated" data-animation="bounceInUp">Payment Report</h2>
</div>


<div class="container" id="main">
   <div class="container-fluid pt-2">
      <div class="row">
         <div class="float-right">
            <div class="row pull-right" style="padding-bottom:7px;">
               <?php

               //Export Starts
               if (isset($_REQUEST["subexport"])) {
                  //$filename = "tmpcsv/".strtotime("now").'.csv';
                  //echo $t = date_format(time(), "%d/%m/%Y");
                  $filename = "tmpcsv/paymentreport.csv";

                  //$expsql = "SELECT emuser.emsi_id as EMSIID, CONCAT(eauth.au_firstname, eauth.au_lastname) as PresentingAuthor, eauth.au_affiliation as Affiliation, empay.pm_currency as Currency, empay.pm_amount as AmountPaid, empay.pm_mode_of_payment as Instrument, empay.pm_transaction_id as TransactionNumber, date_format(empay.pm_payment_date,'%d-%M-%Y') as PaymentDate, empay.pm_payeebank as Bank, empay.pm_branch as Branch FROM `emsi_payment` as empay, emsi_author_table as eauth, emsi_user_table as emuser WHERE eauth.emsi_user_table_ru_id = empay.emsi_user_table_ru_id and eauth.au_author_type = 'P' and empay.emsi_user_table_ru_id = emuser.ru_id  ORDER BY `empay`.`emsi_user_table_ru_id` ASC";
                  //  $expsql = "SELECT icruser.icr_id as 'icr Id', CONCAT(icrcontact.au_firstname, ' ', icrcontact.au_lastname) as Name, icrcontact.au_affiliation as Affiliation, icrpay.pm_currency as Currency, icrpay.pm_amount as AmountPaid, 
                  //  		icrpay.pm_mode_of_payment as Instrument, icrpay.pm_transaction_id as 'Transaction Number',
                  // 		date_format(icrpay.pm_payment_date,'%d-%M-%Y') as 'Payment Date', icrpay.pm_payeebank as Bank, icrpay.pm_branch as Branch
                  // 		FROM icr_payment as icrpay, icr_contact_table as icrcontact, icr_user_table as icruser WHERE icrcontact.icr_user_table_ru_id = icrpay.icr_user_table_ru_id 
                  // 		and icruser.ru_id = icrpay.icr_user_table_ru_id 
                  // 		ORDER BY icrpay.icr_user_table_ru_id ASC";

                  $expsql = "SELECT user.ru_id, pay.*, contact.au_firstname, contact.au_lastname, contact.au_affiliation 
FROM payment as pay, contact_table as contact, user_table as user WHERE contact.user_table_ru_id = pay.user_table_ru_id 
and user.ru_id = pay.user_table_ru_id 
ORDER BY pay.user_table_ru_id ASC";
                  //  echo $expsql;


                  //  exit(0);

                  $result = mysqli_query($connection, $expsql);
                  $num_rows = mysqli_num_rows($result);

                  if (mysqli_num_rows($result) > 0) {
                     $row = mysqli_fetch_assoc($result);
                     $fp = fopen($filename, "w");
                     $seperator = "";
                     $comma = "";

                     foreach ($row as $name => $value) {
                        $seperator .= $comma . '' . str_replace('', '""', $name);
                        $comma = ",";
                     }

                     $seperator .= "\n";
                     fputs($fp, $seperator);

                     mysqli_data_seek($result, 0);
                     while ($row = mysqli_fetch_assoc($result)) {
                        $seperator = "";
                        $comma = "";

                        foreach ($row as $name => $value) {
                           $seperator .= $comma . '' . str_replace('', '""', $value);
                           $comma = ",";
                        }

                        $seperator .= "\n";
                        fputs($fp, $seperator);
                     }

                     fclose($fp);

                     echo '<a href="' . $filename . '" class="btn btn-default" style="color:green;padding-right:8px" download> <i class="fa fa-file-excel-o"></i> &nbsp;<b> Download</b></a>';
                  } else {
                     echo "No entries for export.";
                  }
               }

               //Export end


               if (!isset($_REQUEST["subexport"])) {
               ?>
                  <form name="export" method="post" action="paymentreport.php">
                     <button type="submit" class="form-control btn-export" value="Export To Excel" name="subexport" style="border-radius:5px;">Export to Excel</button>
                  </form>
               <?php } ?>
            </div>
         </div>
      </div>
      <div class="container-fluid">
         <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">

            </div>
         </div>


         <?php
         //----------------------------------- Paging Start ----------------------------


         include("pagination/function.php");
         $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
         //$page=1;
         $limit = 10; //if you want to dispaly 10 records per page then you have to change here
         $startpoint = ($page * $limit) - $limit;
         //echo $startpoint . "<br>";
         //SQL to pick up records

         //$sql="SELECT empay.*, eauth.au_firstname, eauth.au_lastname,eauth.au_affiliation FROM `emsi_payment` as empay, emsi_author_table as eauth WHERE eauth.emsi_user_table_ru_id = empay.emsi_user_table_ru_id and eauth.au_author_type = 'P' ORDER BY `empay`.`emsi_user_table_ru_id` ASC";
         $statement = "SELECT user.ru_id, pay.*, contact.au_firstname, contact.au_lastname, contact.au_affiliation 
					FROM payment as pay, contact_table as contact, user_table as user WHERE contact.user_table_ru_id = pay.user_table_ru_id 
					and user.ru_id = pay.user_table_ru_id 
					ORDER BY pay.user_table_ru_id ASC";
         // echo $sql;
         // exit(0);

         $strTest = "{$statement} LIMIT {$limit} OFFSET {$startpoint}";
         //echo $strTest . "<BR>";
         // echo $statement;

         //echo "{$statement} LIMIT {$startpoint} , {$limit}";
         // $res=mysqli_query($connection, " {$statement} LIMIT {$startpoint} , {$limit}");
         // $res = mysqli_query($connection, $strTest);

         $result = mysqli_query($connection, $strTest);
         if (mysqli_num_rows($result) > 0) {
            $sno = 1;
         ?>
            <div class="row justify-content-left">
               <div class="col-auto">
                  <table class="table table-responsive tbl-reports">
                     <thead>
                        <tr style="background-color:grey;color:white; text-align:center;">
                           <th style="vertical-align:middle; text-align:center;" width="3%" style="vertical-align:center">ICONS ID</th>
                           <th style="vertical-align:middle; text-align:center;">Name</th>
                           <th style=" text-align:center;" width="17%">Affiliation /Institution</th>
                           <th style="vertical-align:middle; text-align:center;">Amount Paid</th>
                           <th style="vertical-align:middle; text-align:center;">Instrument</th>
                           <th style="vertical-align:middle; text-align:center;">Transaction Number</th>
                           <th style="vertical-align:middle; text-align:center;" width="17%">Payment Date</th>
                           <th style="vertical-align:middle;text-align:center;">Bank, Branch </th>
                        </tr>
                     </thead>
                     <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                           <td><?php echo $row['ru_id']; ?></td>
                           <td><?php echo $row['au_firstname'] . ' ' . $row['au_lastname'] ?></td>
                           <td><?php echo $row['au_affiliation'] ?></td>
                           <td><?php echo $row['pm_currency'] . " " . number_format($row['pm_amount']) ?></td>
                           <td><?php
                                 echo $row['pm_mode_of_payment'];

                                 /* switch ($row['pm_mode_of_payment']) {
                              case 'P':
                              echo "Institutional Payment";
                              break;
                              case 'D':
                              echo "Demand Draft";
                              break;
                              case 'W':
                              echo "Wire Transfer";
                              break;
                              case 'I':
                              echo "IMPS";
                              break;
                              case 'N':
                              echo "NEFT";
                              break;
                              case 'C':
                              echo "Cheque";
                              break;
                              default:
                                 echo "Mode Of Payment";
                              break;
                           } */
                                 ?></td>
                           <td><?php echo $row['pm_transaction_id'] ?></td>
                           <td style="padding:8px 7px"><?php echo date("d-m-Y", strtotime($row['pm_payment_date']));  ?></td>
                           <td><?php echo $row['pm_payeebank'] ?>, <?php echo $row['pm_branch'] ?></td>
                        </tr>
                        </table>
                     <?php $sno++;
                     }
                  } else {

                     ?>
                     <!-- <div class="row ">
                        <div class="col-auto"> -->
                           <table class="table table-responsive tbl-reports">
                              <tr>
                                 <td style="text-align:center;color:red;">
                                    NO Records Found
                                 </td>
                              </tr>
                           </table>
                           <?php
                        } ?>
                          
                           <?php
                           echo "<div id='pagingg' align='right' >";
                           echo pagination($connection, $statement, $limit, $page);
                           echo "</div>";
                           ?>
                        </div>
                     </div>
               </div>
            </div>
      </div>
   </div>

   <!-- footer -->
   <?php include 'includes/script.php'; ?>
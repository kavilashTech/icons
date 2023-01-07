<?php
include 'includes/connection.php';
include 'includes/header.php';
include 'includes/menu-loggedin.php';

?>

<?php
if (!isset($_SESSION["uid"])) {
   echo '<meta http-equiv="Refresh" content="0; url=index.php">';
   exit(0);
}
?>
<style>
   .table-bordered thead td,
   .table-bordered thead th {
      font-size: 10px !important;
   }
</style>
<link href="pagination/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="pagination/css/A_green.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
   $(document).ready(function() {
      $("#table_userstatus").DataTable();
   });
</script>

<!-- content page -->
<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<div class="section-header mar-bot30">
   <h2 class="section-heading animated" data-animation="bounceInUp">User Status</h2>
</div>


<div class="container">
   <div class="container-fluid">
      <!-- <div id="myModalpapper" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="opacity:1;color:white">
                  <span aria-hidden="true">&times;</span>
               </button>
              
            </div>
            <div class="modal-body">
               <div class="" id="userdeatils">
               </div>
            </div>
         </div>
      </div>
   </div> -->
      <div class="row">

         <!-- page content -->
         <div class="col-sm-9">
            <!-- top header title -->
            <!-- report section -->
            <div class="container-fluid">
               <?php


               //----------------------------------- Paging Start ----------------------------


               include("pagination/function.php");
               $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
               //$page=1;
               $limit = 10; //if you want to dispaly 10 records per page then you have to change here
               $startpoint = ($page * $limit) - $limit;

               //SQL to pick up records 
               //you have to pass your query over here
               $statement = "SELECT * FROM user_table WHERE ru_id NOT IN (1) and ru_id <> '' and ru_userid <> '' ";

               //echo $statement;
               //echo "{$statement} LIMIT {$startpoint} , {$limit}";
               $res = mysqli_query($connection, " {$statement} LIMIT {$startpoint} , {$limit}");


               //check if result has any records.
               if (mysqli_num_rows($res) > 0) {
                  $sno = ($page * 10) - 9;
                  //echo "page " . $page; 
               ?>

                  <div class="row justify-content-left">
                     <div class="col-auto">
                        <table class="table table-responsive tbl-reports">
                           <thead>
                              <tr>
                                 <th width="4%">S.No.</th>
                                 <th>ICONS ID</th>
                                 <th>E-Mail ID</th>
                                 <th>Status</th>
                                 <th>Date Registered</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php

                              while ($row = mysqli_fetch_assoc($res)) {
                                 $vstatus = $row['ru_verify_status'];
                                 switch ($vstatus) {
                                    case '0':
                                       $status = 'E-Mail Sent,Verification is Pending';
                                       break;
                                    case '1':
                                       $status = 'E-Mail Verification Passed';
                                       break;
                                    case '2':
                                       $status = 'E-Mail Verification Error';
                                       break;
                                    default:
                                       $status = "";
                                       break;
                                 }

                              ?>
                                 <tr>
                                    <td><?php echo $sno; ?></td>
                                    <td><?php echo $row['ic_id'] ?></td>
                                    <td><?php echo $row['ru_userid'] ?></td>
                                    <td><?php echo $status; ?> </td>
                                    <td><?php echo date("d-M-Y", strtotime($row['ru_datecreated'])); ?></td>

                                 </tr>
                           <?php

                                 $sno++;
                              }
                           }    ?>
                           </tbody>
                        </table>
                        <?php
                        echo "<div id='pagingg' align='right' >";
                        echo pagination($connection, $statement, $limit, $page);
                        echo "</div>";
                        ?>
                        <!--     //----------------------------------- Paging End ---------------------------- -->
                     </div>
                  </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- footer -->
<?php //include 'includes/footer_loggedin.php'; ?>
<?php include 'includes/script.php'; ?>
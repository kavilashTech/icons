<?php
include 'includes/connection.php';
include 'includes/header.php';
include 'includes/menu-loggedin.php';

if (!isset($_SESSION["uid"])) {
   echo '<meta http-equiv="Refresh" content="0; url=index.php">';
   exit(0);
}
?>

<link href="pagination/css/pagination.css" rel="stylesheet" type="text/css" />
<link href="pagination/css/A_green.css" rel="stylesheet" type="text/css" />
<style>
   .table-bordered thead td,
   .table-bordered thead th {
      font-size: 10px !important;
   }
</style>
<script type="text/javascript">
   $(document).ready(function() {
      $("#table_tech").dataTable();
   });
</script>
<!-- content page -->

<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<div class="section-header mar-bot30">
   <h2 class="section-heading animated" data-animation="bounceInUp">Registration Report</h2>
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
               $filename = "tmpcsv/registrationreport.csv";

               //$expsql = "SELECT u.emsi_id as EMSIID, emauth.au_firstname as FirstName, emauth.au_lastname as LastName, emauth.au_affiliation as Affiliation, (select GROUP_CONCAT(s.su_abstracttitle SEPARATOR ' (o). ') from emsi_submission as s where s.emsi_user_table_ru_id = u.ru_id ) as Abstracts FROM emsi_author_table as emauth, emsi_user_table as u  where  emauth.au_author_type = 'P' and emauth.emsi_user_table_ru_id = u.ru_id";


               $expsql = "SELECT B.ic_id as 'id', A.au_firstname as Firstname, A.au_lastname as Lastname, B.ru_userid as Email, A.au_addlemailid as 'Additional Email', A.au_phone as Phone, A.au_mobile as Mobile, REPLACE(A.au_affiliation, ',',' ') as Affiliation, C.na_name as Nationality,
               A.au_student, A.au_iim, A.au_isnt, A.au_insis, A.au_sfa, A.au_memberid 
				 FROM contact_table A, user_table B, nationality C 
				 WHERE A.user_table_ru_id = B.ru_id 
				 AND A.au_nationality = C.na_id AND A.au_active = 1 order by B.ic_id";


               // echo $expsql;
               // echo "<br>UID :" . $_SESSION["uid"];
               // 	 exit(0);
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
               <form name="export" method="post" action="registrationreport.php">
                  <button type="submit" class="form-control btn btn-export" value="Export To Excel" name="subexport">Export to Excel</button>
               </form>
            <?php } ?>
         </div>
      </div>
   </div>



   <div class="container-fluid">

      <?php

      //----------------------------------- Paging Start ----------------------------


      include("pagination/function.php");
      $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
      //$page=1;
      $limit = 6; //if you want to dispaly 10 records per page then you have to change here
      $startpoint = ($page * $limit) - $limit;
      //echo $startpoint . "<br>";
      //SQL to pick up records
      // $statement = "SELECT a.su_id, a.su_abstract_path, c.au_firstname as Fname, c.au_lastname as Lname, a.su_abstracttitle as TITLE, SUBSTR(a.su_abstract_path,15) as Filename, b.ru_id, b.id as USERID
      // FROM submission a, user_table b, contact_table c
      // WHERE b.ru_id = a.user_table_ru_id
      //   AND b.ru_id = c.user_table_ru_id
      //   AND a.su_presentation = 'N'
      //   ORDER BY c.user_table_ru_id desc";

      $statement = "SELECT B.ic_id as icid, A.au_firstname, A.au_lastname, B.ru_userid as userid, A.au_addlemailid, A.au_phone, A.au_mobile as mobile, A.au_affiliation as affiliation, C.na_name as nationality,
                  A.au_student, A.au_iim, A.au_isnt, A.au_insis, A.au_sfa, A.au_memberid
                  FROM contact_table A, user_table B, nationality C 
                  WHERE A.user_table_ru_id = B.ru_id
                     AND A.au_nationality = C.na_id
                     AND  A.au_active = 1 order by B.ic_id desc";

      $strTest = "{$statement} LIMIT {$limit} OFFSET {$startpoint}";
      //                    echo $strTest . "<BR>";
      //           echo $statement;
      // exit(0);
      //echo "{$statement} LIMIT {$startpoint} , {$limit}";
      // $res=mysqli_query($connection, " {$statement} LIMIT {$startpoint} , {$limit}");
      $res = mysqli_query($connection, $strTest);

      //<!--     //----------------------------------- Paging End ---------------------------- -->

      // $sql = "SELECT B.id as icid, A.au_firstname, A.au_lastname, B.ru_userid as userid, A.au_addlemailid, A.au_phone, A.au_mobile as mobile, A.au_affiliation as affiliation, C.na_name as nationality, A.au_iim as iim
      // FROM contact_table A, user_table B, nationality C 
      // WHERE A.user_table_ru_id = B.ru_id
      // 	AND A.au_nationality = C.na_id
      // 	AND  A.au_active = 1 order by B.id";

      if (mysqli_num_rows($res) > 0) {
         // echo "Rows : " . mysqli_num_rows($res);
         $sno = 1;
      ?>

         <!-- $result=mysqli_query($connection, $sql);
            if (mysqli_num_rows($result) > 0) {
               $sno=1;
               ?> -->
         <div class="row justify-content-left">
            <div class="col-auto">
               <table class="table table-responsive tbl-reports">
                  <thead>
                     <tr>
                        <th style="vertical-align:middle; text-align:center;">ICONS ID</th>
                        <th style="vertical-align:middle; text-align:center;">Name</th>
                        <th style="vertical-align:middle; text-align:center;">Email</th>
                        <th style="vertical-align:middle; text-align:center;">Mobile</th>
                        <th style="vertical-align:middle; text-align:center;">Nationality</th>
                        <th style="vertical-align:middle; text-align:center;">Student</th>
                        <th style="vertical-align:middle; text-align:center;">Affiliation</th>
                        <th style="vertical-align:middle; text-align:center;">IIM</th>
                        <th style="vertical-align:middle; text-align:center;">ISNT</th>
                        <th style="vertical-align:middle; text-align:center;">InSIS</th>
                        <th style="vertical-align:middle; text-align:center;">SFA</th>
                        <th style="vertical-align:middle; text-align:center;">Member ID</th>
                        <!--                           <th style="vertical-align:middle; text-align:center;"width="5%">IIM Member</th>-->
                        <!--<th style="vertical-align:middle; text-align:center;">Abstract</th>-->

                     </tr>
                  </thead>

                  <?php

                  while ($row = mysqli_fetch_assoc($res)) { ?>

                     <tr>
                        <td><?php echo $row['icid']; ?></td>
                        <td><?php echo $row['au_firstname'] . ' ' . $row['au_lastname']; ?></td>
                        <td><?php echo $row['userid']; ?></td>
                        <td><?php echo $row['mobile']; ?></td>
                        <td><?php echo $row['nationality']; ?></td>
                        <td class="align-center"><?php echo $row['au_student']; ?></td>
                        <td><?php echo $row['affiliation']; ?></td>
                        <td class="align-center"><?php echo $row['au_iim']; ?></td>
                        <td class="align-center"><?php echo $row['au_isnt']; ?></td>
                        <td class="align-center"><?php echo $row['au_insis']; ?></td>
                        <td class="align-center"><?php echo $row['au_sfa']; ?></td>
                        <td class="align-center"><?php echo $row['au_memberid']; ?></td>

                        <!--          <td><?php //echo $row["Abstracts"]; 
                                          ?> </td>	-->
                     </tr>
               <?php $sno++;
                  }
               }

               ?>
               </table>

            </div>
            <?php
            echo "<div id='pagingg' align='right' >";
            echo pagination($connection, $statement, $limit, $page);
            echo "</div>";
            ?>
         </div>
   </div>
</div>


<!-- footer -->
<!-- <?php // include 'includes/footer_loggedin.php'; 
      ?> -->
<?php include 'includes/script.php'; ?>
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

<script type="text/javascript">
   $(document).ready(function() {
      $("#table_tech").dataTable();
   });
</script>

<!-- content page -->

<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<div class="section-header mar-bot30">
   <h2 class="section-heading animated" data-animation="bounceInUp">Abstract Submission Report</h2>
</div>


<div class="container" id="main">
   <div class="container-fluid pt-2">


      <div class="row">
         <div class="float-right">
            <div class="row pull-right" style="padding-bottom:7px;">
               <?php

               //Export Starts
               if (isset($_REQUEST["subexport"])) {

                  $filename = "tmpcsv/SubmissionReport.csv";

                  $expsql = "SELECT b.ic_id as 'IC ID', c.au_firstname as 'First Name', 
            c.au_lastname as 'Last Name', a.su_abstract_path as Filename, 
            a.su_abstracttitle as TITLE
            FROM submission a, user_table b, contact_table c
            WHERE b.ru_id = a.user_table_ru_id
            AND b.ru_id = c.user_table_ru_id
            AND a.su_presentation = 'N'
            ORDER BY c.user_table_ru_id";


                  // echo $expsql;
                  // echo "<br>UID :" . $_SESSION["uid"];
                  // exit(0);
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
                  <form name="export" method="post" action="abstractreport.php">
                     <button type="submit" class="form-control btn-export" value="Export To Excel" name="subexport" style="border-radius:5px;">Export to Excel</button>
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
         $limit = 10; //if you want to dispaly 10 records per page then you have to change here
         $startpoint = ($page * $limit) - $limit;
         //echo $startpoint . "<br>";
         //SQL to pick up records
         $statement = "SELECT a.su_id, a.su_abstract_path, c.au_firstname as Fname, c.au_lastname as Lname, a.su_abstracttitle as TITLE, SUBSTR(a.su_abstract_path,13) as Filename, b.ru_id, b.ic_id as USERID
                  FROM submission a, user_table b, contact_table c
                  WHERE b.ru_id = a.user_table_ru_id
                    AND b.ru_id = c.user_table_ru_id
                    AND a.su_presentation = 'N'
                    ORDER BY c.user_table_ru_id desc";

         $strTest = "{$statement} LIMIT {$limit} OFFSET {$startpoint}";
         //echo $strTest . "<BR>";
         // echo $statement;

         //echo "{$statement} LIMIT {$startpoint} , {$limit}";
         // $res=mysqli_query($connection, " {$statement} LIMIT {$startpoint} , {$limit}");
         $res = mysqli_query($connection, $strTest);


         //check if result has any records.
         if (mysqli_num_rows($res) > 0) {
            // echo "Rows : " . mysqli_num_rows($res);
            $sno = 1;
         ?>
            <div class="row justify-content-left">
               <div class="col-12">
                  <table class="table table-responsive tbl-reports">
                     <thead>
                        <tr>
                           <th style="vertical-align:middle; text-align:center;" width="12%">ICONS ID</th>
                           <th style="vertical-align:middle; text-align:center;" width=22%>Name</th>
                           <th style="vertical-align:middle; text-align:center;">Title</th>
                           <th style="vertical-align:middle; text-align:center;">Filename</th>
                        </tr>
                     </thead>

                     <?php

                     while ($row = mysqli_fetch_array($res)) {
                     ?>

                        <tr>
                           <td><?php echo $row['USERID']; ?></td>
                           <td><?php echo $row['Fname'] . " " . $row['Lname']; ?></td>
                           <td><?php echo $row['TITLE']; ?></td>
                           <td><a href="uploads/<?php echo $row['su_abstract_path']; ?>"><?php echo $row['Filename']; ?></a></td>
                           </td>
                        </tr>
                  <?php

                     }
                  }

                  ?>
                  <!--     //----------------------------------- Paging End ---------------------------- -->


                  </table>
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

<!-- footer -->
<!-- <?php // include 'includes/footer_loggedin.php'; 
      ?> -->
<?php include 'includes/script.php'; ?>
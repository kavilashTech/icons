<div id="mySidenav" class="sidenav">
    <div class="sidenav_id">
        Your ICONS 2023 ID :
        <p><?php 
        echo $_SESSION['icid']  
        ?></p>
    </div>
    <a id="side_menu" href="contactinformation.php">Contact Information</a>
    <a id="side_menu" href="paymentcalculation.php">Payment Calculation</a>
    <a id="side_menu" href="paymentdetails.php">Payment Details</a>
    <a id="side_menu" href="abstractupload.php">Submit Abstract</a>
    <a id="side_menu" href="docs/ICONS2023_draft_Abstract_template.docx">Download Abstract Template</a>
    <?php
    if ($_SESSION['category'] == 'A') {
    ?>
        <hr>
        <p class="sidenav_admin">Admin Menu</p>
        <a id="side_menu" href="userstatus.php">User Status</a>
        <a id="side_menu" href="registrationreport.php">Registration Report</a>
        <a id="side_menu" href="paymentreport.php">Payment Report</a>
        <a id="side_menu" href="abstractreport.php">Submission Report</a>
    <?php } ?>
<hr>
    <!-- <div class="help_note"><a href="#">Help</a></div> -->
</div>

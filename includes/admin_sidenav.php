<div id="mySidenav" class="sidenav">
    <div class="sidenav_id">
        Your ICONS 2023 ID :
        <p><?php 
        echo $_SESSION['icid']  
        ?></p>
    </div>
    <a id="side_menu" href="#">Contact Information</a>
    <a id="side_menu" href="#">Payment Information</a>
    <a id="side_menu" href="#">Abstract Submission</a>
    <?php
    if ($_SESSION['category'] == 'A') {
    ?>
        <hr>
        <p class="sidenav_admin">Admin Menu</p>
        <a id="side_menu" href="#">User Status</a>
        <a id="side_menu" href="#">Registration Report</a>
        <a id="side_menu" href="#">Payment Report</a>
        <a id="side_menu" href="#">Manuscript Report</a>
    <?php } ?>
<hr>
    <div class="help_note"><a href="#">Help</a></div>
</div>

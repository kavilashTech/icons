<?php
include "includes/connection.php";
include 'includes/header.php';
include 'includes/menu-loggedin.php';

?>


<!-- Side Nav Bar - Logged in user -->
<div class="mar-top30">&nbsp;</div>

<?php include 'includes/admin_sidenav.php'; ?>

<!-- Main content Block -->
<div class="container" id="main">
	<div class="container-fluid pt-2">
		<?php include 'contact.html'; ?>
	</div>
</div>


<!-- footer -->
<?php include 'includes/footer_loggedin.php'; ?>
<?php include 'includes/script.php'; ?>
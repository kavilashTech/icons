
  <nav class="navbar navbar-fixed-top clearfix" role="navigation"
    data-0="line-height:70px; height:70px; background-color:rgba(255,255,255,1);box-shadow:none;"
    data-300="line-height:70px; height:70px; background-color:rgba(255,255,255,1);box-shadow:0 1px 3px rgb(0 0 0 / 30%);">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"
          aria-expanded="false" aria-controls="navbar">
          <span class="fa fa-bars"></span>
        </button>

        <!-- <div class="navbar-logo">
          <a href="index.html"><img width="90px;" src="img/logo/icons_logo.png" alt="" ></a>
        </div> -->
		<?php
  $homepage="index.php";
  // get the current file name
  $pagename= basename($_SERVER['PHP_SELF']);
  // check wheather current page is index.php or not
  if ($homepage != $pagename) {
			// echo $pagename;
			echo '
			<a href="index.html"><img width="60px;" src="img/logo/icons_logo.png" alt="" ></a>
		  ';
  }   ?>

      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav" style="margin-top:10px;">
          <li class="active"><a href="index.php">Home</a></li>
          <!-- <li><a href="#section-contact">Conference</a></li> -->
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Conference <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="index.php#mark-about">About Conference</a></li>
              <li><a href="scope.php">Conference Objectives</a></li>
              <li><a href="organizers.php">Organizers</a></li>
              <li><a href="#">Committees</a></li>
              <li><a href="importantdates.php">Important Dates</a></li>
              <li><a href="venue.php">Venue</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Submission <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Submission Guidelines</a></li>
              <li><a href="#">Download Abstract Template</a></li>
              <li><a href="#">How to Submit Abstract</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Registration <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Registration information</a></li>
              <li><a href="#">Registration FAQ</a></li>
			  <?php
				if (!isset($_SESSION['uid'])){ 
				echo '<li><a href="#">Sign Up</a></li>';
				echo '<li><a href="#">Login</a></li>';
			
				} else {
					echo '<li><a href="contactinformation.php">Contact Information</a></li>';
					echo '<li><a href="paymentdetails.php">Payment Information</a></li>';
				}
				?>
              <!-- <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li> -->
            </ul>
          </li>

          <li><a href="contact.php">Contact</a></li>
          <li><a href="#" class="btn btn-login">Login</a></li>
        </ul>
      </div>
      <!--/.navbar-collapse -->
    </div>
  </nav>

  <!-- Top Spacing for pages except Index -->
  <div style="margin-top:70px"></div>
  <?php
  $homepage="index.php";
  // get the current file name
  $pagename= basename($_SERVER['PHP_SELF']);
  // check wheather current page is index.php or not
  if ($homepage != $pagename) {
			// echo $pagename;
//			echo '<div style="margin-top:100px"></div>';
  }   ?>

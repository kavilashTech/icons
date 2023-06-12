
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
			echo '<a href="index.php"><img width="60px;" src="img/logo/icons_logo.png" alt="" ></a>';
  }   ?>

      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav" style="margin-top:10px;">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Registration <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="registrationfees-loggedin.php">Registration Fees</a></li>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Guidelines <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="abstractguidelines-loggedin.php">Abstract Submission Guidelines</a></li>
            </ul>
          </li>

          <?php
				if (!isset($_SESSION['uid'])){  // if not signed in
          echo '<li class="dropdown">';
          echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Signup <span class="caret"></span></a>';
            echo '<ul class="dropdown-menu">';
            echo '<li><a href="#">Signup information</a></li>';
            // echo '<li><a href="#">Signup FAQ</a></li>';
    				echo '<li><a href="Signup.php">Sign Up</a></li>';
		    		echo '<li><a href="login.php">Login</a></li>';
            echo '</ul>
            </li>';
				} else {
					// echo '<li><a href="contactinformation.php">Contact Information</a></li>';
					// echo '<li><a href="">Payment Information</a></li>';
				}
				?>



          <li><a href="contact-loggedin.php">Contact</a></li>
            <?php
              if (isset($_SESSION['uid'])){
                echo '<li><a href="logout.php" class="btn btn-login">Logout</a></li>';
              } else {
                echo '<li><a href="login.php" class="btn btn-login">Login</a></li>';
              }
            ?>
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

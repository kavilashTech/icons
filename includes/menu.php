<!-- Floating menu Style Start ------------------------------------------ -->
<style>
  .floating-menu {
    font-family: sans-serif;
    font-size: 14px;
    /*background:#6666FF;*/
    background-color: #802d08;
    padding: 5px;
    width: 150px;
    z-index: 100;
    float: right;
    position: fixed;
    bottom: 60%;
    right: 0px;
    border-style: solid none solid solid;
    border-radius: 6px;
    border-color: #FFFFFF;
    border-bottom-width: medium;
    box-shadow: 0px 0px 30px #060c22;
  }

  .floating-menu a {
    font-size: 13px;
    font-family: 'Open Sans', Arial, sans-serif;
    display: block;
    margin: 0 0.5em;
    /*color:#8083FD;*/
    color: #FFFFFF;
    padding-bottom: 5px;
  }

  .floating-menu h3 {
    font-size: 14px;
    font-weight: bold;
    display: block;
    text-align: center;
    color: #FFFFFF;
    margin: 0 0 15px 5px;
  }

  @media (max-width:481px) {
    .floating-menu {
      display: none;
    }
  }
</style>

<!-- Floating Menu Style End  ------------------------------------------ -->


<nav class="navbar navbar-fixed-top clearfix" role="navigation" data-0="line-height:70px; height:70px; background-color:rgba(255,255,255,1);box-shadow:none;" data-300="line-height:70px; height:70px; background-color:rgba(255,255,255,1);box-shadow:0 1px 3px rgb(0 0 0 / 30%);">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="navbar">
        <span class="fa fa-bars"></span>
      </button>

      <!-- <div class="navbar-logo">
          <a href="index.html"><img width="90px;" src="img/logo/icons_logo.png" alt="" ></a>
        </div> -->
      <?php
      $homepage = "index.php";
      // get the current file name
      $pagename = basename($_SERVER['PHP_SELF']);
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
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">Conference <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php#mark-about">About Conference</a></li>
            <li><a href="scope.php">Conference Objectives</a></li>
            <li><a href="organizers.php">Organizers</a></li>
            <li><a href="speakerslist.php">Speakers List</a></li>
            <li><a href="importantdates.php">Important Dates</a></li>
            <li><a href="venue.php">Venue</a></li>
            <li><a href="sponsorship.php">Sponsorship</a></li>
          </ul>
        </li>
        <li><a href="organizingcommittee.php">Organizing Committee</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">Downloads <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="docs/ICONS2023_Brochure_02June23.pdf" title="ICONS 2023" target="_blank">Conference Brochure</a></li>
            <li><a href="docs/ICONS2023-Flyer_1.pdf" target="_blank">Conference Flyer</a></li>
            <li><a href="docs/ICONS2023_Brochure_02June23.pdf" target="_blank">Final Announcement</a></li>
            <li><a href="docs/ICONS2023-Pre-ConferenceWorkshop.pdf" target="_blank">Pre-Conf. Workshop-1</a></li>
            <li><a href="docs/preconf2-workshop-flyer.pdf" target="_blank">Pre-Conf. Workshop-2&nbsp;<img width="20px" src="img/badge-new.png"></a></li>


          </ul>
        </li>


        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">Submission <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="abstractguidelines.php">Abstract Guidelines</a></li>
            <li><a href="docs/ICONS2023_draft_Abstract_template.docx">Download Abstract Template</a></li>
            <li><a href="howtosubmit.php">How to Submit Abstract</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">Registration <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <!-- <li><a href="registrationguidelines.php">Registration Guidelines</a></li> -->
            <li><a href="registrationfees.php">Registration Fees</a></li>
            <li role="separator" class="divider"></li>

            <?php
            if (!isset($_SESSION['uid'])) {  // if not signed in
              // echo '<li class="dropdown">';
              // echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              // aria-expanded="false">Signup <span class="caret"></span></a>';
              // echo '<ul class="dropdown-menu">';
              echo '<li><a href="#">Signup information</a></li>';
              // echo '<li><a href="#">Signup FAQ</a></li>';
              echo '<li><a href="signup.php">Sign Up</a></li>';
              // echo '<li><a href="login.php">Login</a></li>';
              // echo '</ul>
              // </li>';
            } else {
              // echo '<li><a href="contactinformation.php">Contact Information</a></li>';
              // echo '<li><a href="">Payment Information</a></li>';
            }
            ?>

          </ul>
        </li>


        <!-- <li role="separator" class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li> -->


        <li><a href="contact.php">Contact</a></li>

        <?php
        if (isset($_SESSION['uid'])) {
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
$homepage = "index.php";
// get the current file name
$pagename = basename($_SERVER['PHP_SELF']);
// check wheather current page is index.php or not
if ($homepage != $pagename) {
  // echo $pagename;
  //			echo '<div style="margin-top:100px"></div>';
}   ?>


<!-- FLOATING MENU - START -->
<nav class="floating-menu">
  <a href="speakerslist.php" style="font-size:18px;font-weight:bold;padding-top:2px">Speakers List</a>
  <!-- <a href="importantdates.php">Imp. Dates</a>
  <a href="docs/CF-8_Souvenir.pdf" target="_blank"> Souvenir</a>
  <a href="manuscriptsubmission.php">Submit Manuscript</a> -->

</nav>
<!-- FLOATING MENU - END -->
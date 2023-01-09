
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
          <!-- <li class="active"><a href="contactinformation.php">Home</a></li> -->
          <!-- <li><a href="#section-contact">Conference</a></li> -->
          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Conference Logged in<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="index.php#mark-about">About Conference</a></li>
              <li><a href="scope.php">Conference Objectives</a></li>
              <li><a href="organizers.php">Organizers</a></li>
              <li><a href="importantdates.php">Important Dates</a></li>
              <li><a href="venue.php">Venue</a></li>
            </ul>
          </li> -->

          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button"
              aria-expanded="false">Submission <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="abstractguidelines.php">Abstract Guidelines</a></li>
              <li><a href="docs/ICONS2023_draft_Abstract_template.docx">Download Abstract Template</a></li>
              <li><a href="#">How to Submit Abstract</a></li>
            </ul>
          </li> -->
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
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registration Fees</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
        <!-- <thead>
              <tr class="purple-row">
                <th>Date</th>
                <th></th>
              </tr>
            </thead> -->

            <thead>
              <tr class="purple-row">
                <th >&nbsp;</th>
                <th class="align-center">
                  <p>Indian Delegates</p>
                  <p>INR (₹)</p>
                </th>
                <th class="align-center">
                  <p>Overseas Delegates</p>
                  <p>USD ($)</p>
                </th>
              </tr>
            </thead>

              <tbody>
              <tr>
                <td >Delegates</td>
                <td class="align-center">
                  <p>12,000</p>
                </td>
                <td class="align-center">
                  <p>400</p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Members of SFA, IIM, InSIS and ISNT</p>
                </td>
                <td class="align-center">
                  <p>10,000</p>
                </td>
                <td class="align-center">-</td>
              </tr>
              <tr>
                <td>
                  <p>Students</p>
                </td>
                <td class="align-center">
                  <p>5,000</p>
                </td>
                <td class="align-center">
                  <p>200</p>
                </td>
              </tr>
              <tr>
                <td>
                  <p>Spouse</p>
                </td>
                <td class="align-center">
                  <p>5,000</p>
                </td>
                <td class="align-center">
                  <p>200</p>
                </td>
              </tr>
              <tr>
                <td colspan="3" class="purple-row" ></td>
                <!-- <td width="132">&nbsp;</td>
                <td width="132">&nbsp;</td> -->
              </tr>
              <tr style="font-weight:bold">
                <td >
                  <p>Pre-conference workshop</p>
                </td>
                <td class="align-center">
                  <p>21<sup>st</sup> August, 2023</p>
                </td>
                <td class="align-center">
                  <p>22<sup>nd</sup> August, 2023</p>
                </td>
              </tr>
              <tr>
                <td class="align-center">-</td>
                <td class="align-center">
                  <p>₹ 2,000</p>
                </td>
                <td class="align-center">
                  <p>₹ 2,000</p>
                </td>
              </tr>
              </tbody>
              <tfoot style="font-size:12px;font-weight:bold">
              <tr>
                <td colspan="3" width="603">
                  <p>All prices exclusive of GST @ 18%</p>
                </td>
              </tr>
              </tfoot>
          </table>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
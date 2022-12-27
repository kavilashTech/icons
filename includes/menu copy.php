
<!-- Start new navigation -->
<!-- <div id="container"> -->
	<!-- <nav class="navbar"> -->
    <nav class="sticky-top">
		<div class="navbar navbar-expand-md mx-auto sticky-top">
		  <i class='bx bx-menu'></i>
		  <!-- <div class="logo"><a href="#">CodingLab</a></div> -->
		  <div class="nav-links mr-auto">
			<!-- <div class="sidebar-logo">
			  <span class="logo-name"></span>
			  <i class='bx bx-x' ></i>
			</div> -->
			<ul class="links navbar-left">
			  <!-- <li><a href="index.php" class="active"><i class="fa fa-home" style="font-size:22px;"></i></a></li> -->
			  <li>
				  <a href="index.php" class="active">Home&nbsp;<img src="img/badge-new.png" style="position:absolute;left:49px;top:-17px;"><i class="fa fa-chevron-down"></i></a>
				  <ul class="htmlCss-sub-menu sub-menu">
				  <li><a href="index.php#about">About ICReAcH</a></li>
				  <li><a href="docs/First_Circular_Icreach_2022.pdf" target="_blank">First Circular</a></li>
				  <li><a href="index.php#scope">Conference Scope</a></li>
				  <li><a href="index.php#presentationmode">Presentation Mode</a></li>
				  <li><a href="index.php#dates">Important Dates</a></li>
				  <li><a href="index.php#speaker">Speakers</a></li>
				  <li><a href="docs/conference_schedule.pdf" target="_blank">Conference Schedule</a></li>
				  <li><a href="docs/conference_abstract_book.pdf" target="_blank">Conference Abstract Book</a>&nbsp;<img src="img/badge-new.png"></li>
				  <!-- <li>Program Details</li> -->
				  </ul>
				</li>
			  <li>
				<a href="#">Registration&nbsp;<i class="fa fa-chevron-down"></i></a>
				<ul class="htmlCss-sub-menu sub-menu">
				<li><a href="registrationguidelines.php">Registration Guidelines</a></li>
				<li><a href="registrationfees.php">Registration Fees</a></li>
				<?php
				if (!isset($_SESSION['uid'])){ 
				echo '<li>&nbsp;&nbsp;&nbsp;Sign Up<span style="color:white">Closed</span></li>';
				echo '<li><a href="login.php">Login</a></li>';
			
				} else {
					echo '<li><a href="contactinformation.php">Contact Information</a></li>';
					echo '<li><a href="paymentdetails.php">Payment Information</a></li>';
				}
				?>

				  <!-- <li class="more">
					<span><a href="#">More</a>
					<i class='bx bxs-chevron-right arrow more-arrow'></i>
				  </span>
					<ul class="more-sub-menu sub-menu">
					  <li><a href="#">Neumorphism</a></li>
					  <li><a href="#">Pre-loader</a></li>
					  <li><a href="#">Glassmorphism</a></li>
					</ul>
				  </li> -->
				</ul>
			  </li>
			  <li>
				<a href="#">Submission&nbsp;<i class="fa fa-chevron-down"></i></a>
				<ul class="htmlCss-sub-menu sub-menu">

				<?php if(isset($_SESSION["uid"])){ 

				  echo '<li style="color:red;">&nbsp;&nbsp;&nbsp;Manuscript Submission </li>';
				}

				  ?>

					<li><a href="callforpapers.php">Call for Papers</a></li>
					<li><a href="submissionguidelines.php">Submission Guidelines</a></li>
					<li><a href="docs/ICREARCH-Abstract-template.docx" target="_blank">Manuscript Template</a></li>

				</ul>
			  </li>
			  <li><a href="publication.php">Publication</a></li>
			  
			  <li>
				<a href="#">Committees Details<i class="fa fa-chevron-down"></i></a>
				<ul class="htmlCss-sub-menu sub-menu">
				  <li><a href="advisorycommittee.php">Advisory Committee</a></li>
				  <li><a href="organizingcommittee.php">Organizing Committee</a></li>
				  <li><a href="localcommittee.php">Local Executive Committee</a></li>
				</ul>
			  </li>
			  <!-- <li>
				<a href="#">IGCAR at a Glance<i class="fa fa-chevron-down"></i></a>
				<ul class="htmlCss-sub-menu sub-menu">
				  <li><a href="igcarglance.php">Activities at IGCAR</a></li>
				</ul>
			  </li> -->
			  <li><a href="igcarglance.php">IGCAR at a Glance</a></li>
			  <li><a href="contact.php">Contact</a></li>
		  
			</ul>
			

		  </div>
		  <div class="login">
		  <?php 
		if (isset($_SESSION['uid'])){
			echo '<i><a href="logout.php"> <div class="btn btn-login">Logout</div></a></i>';
		} else {
			// echo '<button type="button" class="btn btn-login" data-toggle="modal" data-target="#buy-ticket-modal" data-ticket-type="standard-access">Login</button>';
			echo '<i><a href="login.php"><div class="btn btn-login">Login</div></a></i>';
			}
		?>
		</div>
		  <!-- <div class="search-box">
			<i class='bx bx-search'></i>
			<div class="input-box">
			  <input type="text" placeholder="Search...">
			</div>
		  </div> -->
		</div>
	  </nav>


<!-- End new navigation-->
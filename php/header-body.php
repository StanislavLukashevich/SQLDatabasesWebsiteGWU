<?php
	function permitted($plevel, $p) {
		// returns true if $plevel contains any of the roles in $p (if the intersection of $plevel and $p is not null)
		$levels = str_split($p);
		foreach ($levels as $level) {
			if (strpos($plevel, $level) !== false) return (true);
		}
		return(false);
	}
?>

<style>
  .stick-wrapper {
    position: fixed;

  }
</style>

<div data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

  <div class="site-wrap">

    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

      <div class="container">
        <div class="d-flex align-items-center">
          <div class="mx-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li>
                  <div class="site-logo">
                  <a href="<?= $_SESSION["navlink-prefix"] ?>home.php" class="d-block">
                    <img src="../images/logo.png" alt="Image" class="img-fluid">
                  </a>
                  </div>
                </li>
			<?php
	
				// Switch over perm level to figure out what to display in header	
				if (isset ($_SESSION['p_level'])) {
				  $plevel = $_SESSION['p_level'];

					// Admin (0)
					if (strpos ($plevel, "0") !== false) {
						echo '	
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . 'add_user.php">Create User</a>
							</li>
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . 'view_users.php" class="nav-link text-left">View Users</a>
							</li>
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . 'grades.php" class="nav-link text-left">Grades</a>
							</li>
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . 'transcript.php" class="nav-link text-left">Transcripts</a>
							</li>
							<li>
							  <a href="' . $_SESSION["navlink-prefix"] . 'courses.php" class="nav-link text-left">Courses</a>
							</li>
						';
					}

					// GS (1)
					else if (strpos ($plevel, "1") !== false) {
						echo '
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . 'view_users.php" class="nav-link text-left">View Users</a>
							</li>
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . 'grades.php" class="nav-link text-left">Grades</a>
							</li>
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . 'transcript.php" class="nav-link text-left">Transcripts</a>
							</li>	
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . '../ads/studentsel.php" class="nav-link text-left">Advising</a>
							</li>
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . '../apps/" class="nav-link text-left">Admissions</a>
							</li>
						';

					}

					// Chair (2)
					else if (strpos ($plevel, "2") !== false) {
					    echo '
							<li class="has-children">
								<a href="account.php" class="nav-link text-left">Account Info</a>
								<ul class="dropdown">
									<li><a href="' . $_SESSION["navlink-prefix"] . 'account.php">Update Info</a></li>
									<li><a href="' . $_SESSION["navlink-prefix"] . 'change_password.php">Change Password</a></li>
								</ul>
							</li>	
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . '../apps/" class="nav-link text-left">Admissions</a>
							</li>
						';
					}

					// Applicant (3)
					else if (strpos ($plevel, "3") !== false) {
						echo '
							<li class="has-children">
								<a href="' . $_SESSION["navlink-prefix"] . 'account.php" class="nav-link text-left">Account Info</a>
								<ul class="dropdown">
									<li><a href="' . $_SESSION["navlink-prefix"] . 'account.php">Update Info</a></li>
									<li><a href="' . $_SESSION["navlink-prefix"] . 'change_password.php">Change Password</a></li>
								</ul>
							</li>
							<li>
								<a href="' . $_SESSION["navlink-prefix"] . '../apps/" class="nav-link text-left">Admissions</a>
							</li>
						';
					}

					// Student (4)
					else if (strpos ($plevel, "4") !== false) {
						echo '	
							<li class="has-children">
								<a href="' . $_SESSION["navlink-prefix"] . 'account.php" class="nav-link text-left">Account Info</a>
								<ul class="dropdown">
									<li><a href="' . $_SESSION["navlink-prefix"] . 'account.php">Update Info</a></li>
									<li><a href="' . $_SESSION["navlink-prefix"] . 'change_password.php">Change Password</a></li>
								</ul>
							</li>
							<li>
							  <a href="' . $_SESSION["navlink-prefix"] . 'schedule.php" class="nav-link text-left">Schedule</a>
							</li>
							<li>
							  <a href="' . $_SESSION["navlink-prefix"] . 'courses.php" class="nav-link text-left">Registration</a>
							</li>
							<li>
							  <a href="' . $_SESSION["navlink-prefix"] . 'transcript.php" class="nav-link text-left">Transcript</a>
							</li>			
							<li class="has-children">
								<a href="" class="nav-link text-left">Advising</a>
								<ul class="dropdown">
									<li><a href="' . $_SESSION["navlink-prefix"] . '../ads/form1.php">Form One</a></li>
									<li><a href="' . $_SESSION["navlink-prefix"] . '../ads/applygraduate.php">Apply to Graduate</a></li>
								</ul>
							</li>
						';
					}

					// Alumni (5)
					else if (strpos ($plevel, "5") !== false) {
						echo '
							<li class="has-children">
                                <a href="' . $_SESSION["navlink-prefix"] . 'account.php" class="nav-link text-left">Account Info</a>
                                <ul class="dropdown">
                                    <li><a href="' . $_SESSION["navlink-prefix"] . 'account.php">Update Info</a></li>
                                    <li><a href="' . $_SESSION["navlink-prefix"] . 'change_password.php">Change Password</a></li>
                                </ul>
                            </li>
							<li>
							  <a href="' . $_SESSION["navlink-prefix"] . 'transcript.php" class="nav-link text-left">Transcript</a>
							</li>
						';
					}
					// Instructor (6), Reviewer (7), or Advisior (8)
					else if (strpos ($plevel, "6") !== false
								|| strpos ($plevel, "7") !== false
								|| strpos ($plevel, "8") !== false) {
					
						echo '
							<li class="has-children">
								<a href="' . $_SESSION["navlink-prefix"] . 'account.php" class="nav-link text-left">Account Info</a>
								<ul class="dropdown">
									<li><a href="' . $_SESSION["navlink-prefix"] . 'account.php">Update Info</a></li>
									<li><a href="' . $_SESSION["navlink-prefix"] . 'change_password.php">Change Password</a></li>
								</ul>
							</li>
						';
		
						if (strpos ($plevel, "6") !== false) {
							echo '	
								<li>
								  <a href="' . $_SESSION["navlink-prefix"] . 'schedule.php" class="nav-link text-left">Schedule</a>
								</li>
								<li>
								  <a href="' . $_SESSION["navlink-prefix"] . 'grades.php" class="nav-link text-left">Grades</a>
								</li>
							';
						}
						if (strpos ($plevel, "7") !== false) {
							echo'
								<li>
									<a href="' . $_SESSION["navlink-prefix"] . '../apps" class="nav-link text-left">Admissions</a>
								</li>
              ';
						}
						if (strpos ($plevel, "8") !== false) {
							echo '
								<li class="has-children">
									<a href="" class="nav-link text-left">Advising</a>
									<ul class="dropdown">
										<li><a href="' . $_SESSION["navlink-prefix"] . 'transcript.php" class="nav-link text-left">Transcript</a></li>
										<li><a href="' . $_SESSION["navlink-prefix"] . '../ads/studentsel.php" class="nav-link text-left">Advising</a></li>
									</ul>
								</li>
							';
						}
					}
				}

		        if (!isset($_SESSION['id'])) {
							echo'
								<li>
									<a href="' . $_SESSION["navlink-prefix"] . 'login.php" class="small btn btn-primary px-4 py-2 rounded-0">
										<span class="icon-unlock-alt"></span>		
											Log In 
									</a>
								</li>';
		         } else {
							 echo'
							  <li>
									<a href="' . $_SESSION["navlink-prefix"] . 'logout.php" style="Color: #FFFFFF;" class="small btn btn-primary rounded-2 px-4 py-2">Logout</a>
								</li>
							  ';
		         }
      		?>
			  </ul>
            </nav>

          </div>
        </div>
      </div>

    </header>

  <!-- loader -->
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg></div>

  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/jquery-migrate-3.0.1.min.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.stellar.min.js"></script>
  <script src="../js/jquery.countdown.min.js"></script>
  <script src="../js/bootstrap-datepicker.min.js"></script>
  <script src="../js/jquery.easing.1.3.js"></script>
  <script src="../js/aos.js"></script>
  <script src="../js/jquery.fancybox.min.js"></script>
  <script src="../js/jquery.sticky.js"></script>
  <script src="../js/jquery.mb.YTPlayer.min.js"></script>
  <script src="../js/main.js"></script>

  <script>
  	var currentPage = '<?php echo basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>';
  	var currentTab = $(".main-menu > li > a[href$='" + currentPage + "'");
  	currentTab.addClass('selected-tab');
  </script>

</div>

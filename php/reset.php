<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/jquery-ui.css">
  <link rel="stylesheet" href="../css/owl.carousel.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">
  <link rel="stylesheet" href="../css/owl.theme.default.min.css">

  <link rel="stylesheet" href="../css/jquery.fancybox.min.css">

  <link rel="stylesheet" href="../css/bootstrap-datepicker.css">

  <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">

  <link rel="stylesheet" href="../css/aos.css">
  <link href="../css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">

  <link rel="stylesheet" href="../css/style.css">

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
</head>

<body>

<?php
	include ('connectvars.php');
	// from https://w3programmings.com/how-to-execute-sql-file-directly-in-php/
	$host = DB_HOST;
	$name = DB_NAME;
	$db = new PDO("mysql:host=$host;dbname=$name", DB_USER, DB_PASSWORD);
	chdir("../sql");
	$query = file_get_contents("db_tables.sql");
	$query .= " " . file_get_contents("db_insert_classes.sql");
	$query .= " " . file_get_contents("db_insert_users.sql");
	$query .= " " . file_get_contents("db_insert_apps.sql");

	$stmt = $db->prepare($query);
	if ($stmt->execute()) {
		$reset = true;
		echo '
		<div class="d-flex flex-column align-items-center justify-content-center">
			<div class="row">
				<div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg>
				</div>
			</div>
		</div>';
		chdir('../php');
		// Now redirect back to home
		header ('Refresh: 1; URL=home.php?reset=success');
	}
	else { 
	    echo "Failed resetting database";
	 	print_r($stmt->errorInfo());
	}
?>

</body>
</html>

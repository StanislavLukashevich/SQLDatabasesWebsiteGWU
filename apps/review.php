<div class="d-flex" id="wrapper">

<?php
	require_once('./includes/utils.php');
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(!($dbc)){
		die('error connecting to DB');
		header('Refresh:0');
	}

	$applicantID = $_GET['applicantID'];

	//get applicant info from the application form
	$applicationQuery = "SELECT applicationID, term, degree, interest
				FROM application_form
				WHERE userID = '$applicantID'";

	$result = mysqli_query($dbc, $applicationQuery);
	$applicantInfo = mysqli_fetch_array($result);

	$applicationID = $applicantInfo['applicationID'];
	$term = $applicantInfo['term'];
	$degree = $applicantInfo['degree'];
	$interest = $applicantInfo['interest'];

	$expQuery = "SELECT * FROM experience WHERE applicationID = '$applicationID'";
	$expResult = mysqli_query($dbc, $expQuery);

	//link review form nav
	require_once('./includes/reviewHeader.php');	

?>

<div id="page-content-wrapper">

<div class="row">
<div id="review-container" class="col-xl-9 mx-auto">

  	<?php require_once('./reviewForms/applicantInfo.php'); ?>

</div>
</div>

</div>

</div>
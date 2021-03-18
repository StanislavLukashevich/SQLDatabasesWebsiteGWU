<?php
	// should set application decision status to 5, then have an option for GS to mark payment received and matriculate
	require_once('../includes/utils.php');
	ob_start();
	require_once('createApplication.php');
	ob_end_clean();
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
		$query = "UPDATE application_form SET decision = 6 WHERE applicationID = " . $_SESSION["appID"];
		try_insert($dbc, $query, 'Declined admisson for application with ID ' . $_SESSION["appID"]);
	}
?>
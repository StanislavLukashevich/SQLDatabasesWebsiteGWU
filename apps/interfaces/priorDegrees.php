<?php
	require_once('../includes/utils.php');

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$keys = array("institution", "gpa", "major", "gradYear", "degreeType");

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$query = "SELECT institution, gpa, major, gradYear, degreeType FROM prior_degrees ";
		$query .= "WHERE applicationID = " . $_SESSION["appID"];
		$data = try_query($dbc, $query, NULL);
		$output = array();
		while ($row = mysqli_fetch_row($data)) {
			array_push($output, array_combine($keys, $row));
		}
		echo json_encode($output);
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
		// create application if not already exists
		require_once('createApplication.php');

		if (isset($_POST["delete"])) {
			$query = "DELETE FROM prior_degrees WHERE applicationID = " . $_SESSION["appID"];
			foreach ($keys as $key) {
				$query .= " AND $key = '" . $_POST[$key] . "'";
			}
			try_query($dbc, $query, "Deleted degree from database.");
		} else {
			$query = "INSERT INTO prior_degrees (institution, gpa, major, gradYear, degreeType, applicationID) VALUES ( ";
			foreach ($keys as $key) {
				$query .= "'" . $_POST[$key] . "', ";
			}
			$query .= $_SESSION["appID"] . ")";
			try_insert($dbc, $query, "Added degree to database.");
		}
	}
	// TODO - permit degree deletion
?>
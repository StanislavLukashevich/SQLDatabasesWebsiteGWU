<?php
	require_once('../includes/utils.php');

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$keys = array("examDate", "totalScore");

	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		$query = "SELECT examDate, totalScore FROM TOEFL_score ";
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
			$query = "DELETE FROM TOEFL_score WHERE applicationID = " . $_SESSION["appID"];
			$query .= " AND examDate = '" . $_POST["examDate"] . "'";
			try_query($dbc, $query, "Deleted degree from database.");
		} else {
			$query = "INSERT INTO TOEFL_score (examDate, totalScore, applicationID) VALUES ( ";
			$_POST["examDate"] = date("Y-m-d", strtotime($_POST["examDate"]));
			foreach ($keys as $key) {
				$query .= "'" . $_POST[$key] . "', ";
			}
			$query .= $_SESSION["appID"] . ")";
			try_insert($dbc, $query, "Added score to database.");
		}
	}
	
?>
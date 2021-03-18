<?php
	require_once('../includes/utils.php');

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	echo 'received request';

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
		// create application if not already exists
		require_once('createApplication.php');
		$appID = $_SESSION["appID"];

		// handle file
		$filename = $_FILES['file']['name'];
		echo $filename;

		$newFilename = $appID . "-" . random_string(4) . ".pdf";
		$destination = "../data/transcripts/" . $newFilename;
		$uploadOk = 1;
		$fileType = pathinfo($destination, PATHINFO_EXTENSION);
		$valid_extensions = array("pdf");
		/* Check file extension */
		if( !in_array(strtolower($fileType), $valid_extensions) ) {
		   throw 'Failed file upload';
		}
		
		if (move_uploaded_file($_FILES['file']['tmp_name'], $destination)) {
			
			$query = "INSERT INTO transcript (applicationID, pathToFile, received) VALUES ($appID, '$newFilename', NOW())";
			try_query($dbc, $query, "Successfully inserted path in DB");
		}
		else {
			throw 'Failed file upload';
		}

	}
?>
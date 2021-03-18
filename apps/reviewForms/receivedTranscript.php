<!DOCTYPE HTML>

	<?php
		require_once('../includes/utils.php');

		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$applicationID = $_GET['applicationID'];
		$receivedDate = date("Y-m-d");

		$transcript_id = mt_rand(10000000, 99999999);
		$addTranscriptQuery = "INSERT INTO transcript VALUES ($applicationID, '" .  $transcript_id . ".pdf', '$receivedDate')";
		
		if($addTranscriptResult = try_query($dbc, $addTranscriptQuery, "happy times")){
			echo "<script> loadForm(\"./applicants.php\"); </script>";
		}else{
			echo"error inserting transcript";
		}
	?>

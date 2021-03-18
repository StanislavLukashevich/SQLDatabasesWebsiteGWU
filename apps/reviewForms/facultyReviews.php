<?php
	require_once('../includes/utils.php');
	
	$applicationID = $_GET['applicationID'];

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$IDquery = "SELECT userID FROM application_form WHERE applicationID = '$applicationID'";
	$IDresult = mysqli_query($dbc, $IDquery);

	$info = mysqli_fetch_array($IDresult);

	$applicantID = $info['userID'];

	$reviewsQuery = "SELECT * FROM review_form WHERE applicationID = '$applicationID'";
	$reviewResult = mysqli_query($dbc, $reviewsQuery);


?>

<h2 align="center">Applicant Reviews</h2>

<table class="table">
	<tr>
		<th>Reviewer</th>
		<th>Average Letter Score</th>
		<th>Recommendation</th>
	<tr/>

	<?php

	while($review = mysqli_fetch_array($reviewResult)){
		$fID = $review['facultyID'];
		$recommendation = $review['suggested_decision'];

		$fNameQuery = "SELECT CONCAT(personal_info.fname, ' ', personal_info.lname) AS name FROM users JOIN personal_info ON users.id = personal_info.user_id WHERE users.id = '$fID'";
		$facultyResult = mysqli_query($dbc, $fNameQuery);
		$facultyInfo = mysqli_fetch_array($facultyResult);

		$scoreQuery = "SELECT AVG(score) FROM letter_rating WHERE facultyID = '$fID'";
		$scoreResult = mysqli_query($dbc, $scoreQuery);
		$rating = mysqli_fetch_array($scoreResult);
		$score = $rating['AVG(score)'];

		$name = $facultyInfo['name'];
		$reasons = $review['reasons'];
		$comments = $review['comments'];

		echo "<tr>
				<td>$name</td>
				<td>$score</td>
				<td>$recommendation</td>
			</tr>
			<tr>
				<th>Reasons: </th>
				<td>$reasons </td>
			</tr>
			<tr>
				<th>Comments: </th>
				<td>$comments </td>
			</tr>";
	}

	?>
</table>

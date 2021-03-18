<?php
	require_once('../includes/utils.php');
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$applicationID = $_GET['applicationID'];
	//need to get applicant ID to connect back to main page
    $idQuery = "SELECT userID FROM application_form WHERE applicationID = '$applicationID'";
    $IDresult = mysqli_query($dbc, $idQuery);
    $info = mysqli_fetch_array($IDresult);
    $applicantID = $info['userID'];

    $degreesQuery = "SELECT * FROM prior_degrees WHERE applicationID = '$applicationID'";
    $degreeResult = mysqli_query($dbc, $degreesQuery);
?>

<h2 align="center">PriorDegrees</h2>
<table class="table">
	<tr>
		<th>College</th>
		<th>Graduation Year</th>
		<th>Degree</th>
		<th>Major</th>
		<th>GPA</th>
	</tr>

	<?php
		while($degree = mysqli_fetch_array($degreeResult)){
			$college = $degree['institution'];
			$year = $degree['gradYear'];
			$degreeType = $degree['degreeType'];
			$major = $degree['major'];
			$gpa = $degree['gpa'];

			echo "<tr>
					<td>$college</td>
					<td>$year</td>
					<td>$degreeType</td>
					<td>$major</td>
					<td>$gpa</td>
				</tr>";
		}
	?>
</table>

<?php

	//link previous and next pages
	$prevURL = "./qualifications.php";
	$nextURL = "./letters.php";

	// echo"<button class='btn btn-primary' id='prev' onclick='newPage($prevURL, $applicationID)'>Back</button>";
	// echo"<button class='btn btn-primary' id='next' onclick='newPage($nextURL, $applicationID)'>Next</button>";

?>

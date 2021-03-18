<?php
	require_once('../includes/utils.php');
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$applicationID = $_GET['applicationID'];
	$query = "SELECT userID FROM application_form WHERE applicationID = '$applicationID'";

	$result = mysqli_query($dbc, $query);
	$info = mysqli_fetch_array($result);

	$applicantID = $info['userID'];

?>

<h2 align="center">Recommended Decision</h2>
<?php echo"<form method='post' action='./reviewForms/submitRecommendation.php?applicationID=$applicationID'>"; ?>
		<label for="reject">Reject</label>
		<input type="radio" name="rating" id="reject" value="Reject">
			
			
		<label for="bdAdmit">Borderline Admit</label>
		<input type="radio" name="rating" id="bdAdm" value="Borderline Admit">

		<label for="admNoAid">Admit Without Aid</label>
		<input type="radio" name="rating" id="admNoAid" value="Admit Without Aid">

		<label for="admWAid">Admit With Aid</label>
		<input type="radio" name="rating" id="admWAid" value="Admit With Aid"><br/>

		<label for="reasons">Reasons</label>		
		<input type="text" name="reasons" id="reasons"><br/>

		<label for="comments">Comments</label>
		<input type="text" name="comments" id="comments" placeholder="Comments..."><br/>

		<label for="courses">Deficient Course (CS Course Number)</label>
		<input type="text" name="courses" id="courses" placeholder="Courses..."><br/>

		<button name="submit" class="btn btn-primary">Submit</button>
</form>

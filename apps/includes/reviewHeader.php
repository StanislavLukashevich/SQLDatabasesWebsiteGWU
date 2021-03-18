<!-- NAV menu to load each review form -->
<?php
	require_once('utils.php');
	//session_start();
	//$role = $_SESSION["p_level"];
	$nameQuery = "SELECT CONCAT(personal_info.fname, ' ', personal_info.lname) AS name FROM users LEFT JOIN personal_info ON users.id = personal_info.user_id WHERE users.id = '$applicantID'";
	$result = mysqli_query($dbc, $nameQuery);
	$applicantName = mysqli_fetch_array($result);
	$name = $applicantName['name'];
?>
<div class="bg-light border-right" id="sidebar-wrapper">
	<div id="side-nav-list" class="list-group list-group-flush">

		<b class='list-group-item side-nav-item'>Reviewing <?php echo $name; ?> (<?php echo $applicantID; ?>)</b>
	<?php

		$info = "review.php?applicantID=";
		$qual = "reviewForms/qualifications.php?applicationID=";
		$degrees = "reviewForms/priorDegrees.php?applicationID=";
		$letters = "reviewForms/letters.php?applicationID=";
		$recDecision = "reviewForms/recDecision.php?applicationID=";
		$revs = "reviewForms/facultyReviews.php?applicationID=";
		$final = "reviewForms/finalDecision.php?applicationID=";

		echo"
			<a class='list-group-item list-group-item-action side-nav-item selected' id='info' onclick='loadPage(\"$info$applicantID\", \"info\");'>Applicant Info</a>
			<a class='list-group-item list-group-item-action side-nav-item' id='qual' onclick='loadPage(\"$qual$applicationID\", \"qual\");'>Qualifications</a>
            <a class='list-group-item list-group-item-action side-nav-item' id='degrees' onclick='loadPage(\"$degrees$applicationID\", \"degrees\");'>Prior Degrees</a>
			<a class='list-group-item list-group-item-action side-nav-item' id='letters' onclick='loadPage(\"$letters$applicationID\", \"letters\");'>Recommendations</a>";

		if(check_permissions(2)){
			echo"<a class='list-group-item list-group-item-action side-nav-item' id='revs' onclick='loadPage(\"$revs$applicationID\", \"revs\");'>Reviews</a>";
			echo"<a class='list-group-item list-group-item-action side-nav-item' id='final' onclick='loadPage(\"$final$applicationID\", \"final\");'>Final Decision</a>";
		}else{
			echo "<a class='list-group-item list-group-item-action side-nav-item' id='rev' onclick='loadPage(\"$recDecision$applicationID\", \"rev\");'>Review</a>";
		}
    	?>
	</div>
</div>

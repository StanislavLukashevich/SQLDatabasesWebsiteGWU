
<?php
	require_once('../includes/utils.php');
	$applicationID = $_GET['applicationID'];
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	//need to get applicant ID to connect back to main page
        	$idQuery = "SELECT userID FROM application_form WHERE applicationID = '$applicationID'";
        	$result = mysqli_query($dbc, $idQuery);
        	$info = mysqli_fetch_array($result);
        	$applicantID = $info['userID'];

	$letterQuery = "SELECT * FROM rec_letter WHERE applicationID = '$applicationID'";
	$letterResult = mysqli_query($dbc, $letterQuery);

	$fID = $_SESSION["id"];


?>


<table class="table">
	<tr>
		<th>Written By</th>
		<th>Title</th>
		<th>Company</th>
		<th>Letter</th>
	</tr>
	<?php
		$index = 0;	
		while($letter = mysqli_fetch_array($letterResult)){
			$author = $letter['writerName'];
			$title = $letter['writerTitle'];
			$company = $letter['writerEmployer'];
			$letterID = $letter['letterID'];
			
			$displayQuery = "SELECT * FROM letter_rating WHERE facultyID = '$fID' AND letterID = '$letterID'";
			$displayResults = mysqli_query($dbc, $displayQuery);
			//only display letters the reviewer hasnt reviewed yet
			if(mysqli_num_rows($displayResults) == 0) :
	?>
				<tr>
					<td><?= $author ?></td>
					<td><?= $title ?></td>
					<td><?= $company ?></td>
					<td> <button class='btn btn-primary' onclick='viewLetter(<?= $letterID ?>)'>View Letter</button></td>
				</tr>
				</table>
				
				<form id='<?= $letterID ?>'>
				
					<label for='generic'>Generic</label>
					<input type='text' name='generic' placeholder='<Y/N>'/>
					<label for='credible'>Credible</label>
					<input type='text' name='credible' placeholder='<Y/N>'/>
					<label for='score'>Rating</label>
					<input type='text' name='score' placeholder='1 - 5'/>
					<button type="button" onclick='submitForm("./reviewForms/submitLetterRating.php?applicationID=<?= $applicationID ?>&letterID=<?= $letterID ?>", "<?= $letterID ?>")'>Submit</button>
				</form>
	<?php 
			endif; 
		}
	?>

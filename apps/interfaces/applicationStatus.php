
<?php
	require_once('../appvars.php');
	require_once('../includes/utils.php');

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$query = "SELECT decisions.description AS description, application_form.submitted AS submitted, decisions.decisionID AS decisionID FROM application_form ";
	$query .= "JOIN decisions ON decisions.decisionID = application_form.decision ";
	$query .= "WHERE application_form.applicationID = " . $_SESSION["appID"];
	$data = try_query($dbc, $query, NULL);
	$status = mysqli_fetch_array($data);
?>

<table class="table">
	<thead>
		<tr>
			<th scope="col">Application ID</th>
			<th scope="col">Submitted</th>
			<th scope="col">Status</th>
		</tr>
	</thead>
	<tbody>
			<tr>
				<td><?= $_SESSION["appID"] ?></td>
				<td><?= $status["submitted"] ? '<i class="fas fa-check" style="color: green"></i>' : '<i class="fas fa-times" style="color: red"></i>' ?></td>
				<td>
					<?= $status["description"] ?>
				</td>
			</tr>
	</tbody>
</table>

<!-- if under review, show missing materials -->
<?php if ($status["decisionID"] == 0): ?>
	<h4>Missing Materials</h4>
	<?php
		// things that could be missing:

		// personal info (anything null)
		$query = "SELECT term, interest, address1, city, state, zip FROM application_form WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$infoMissing = false;
		while ($row = mysqli_fetch_row($result)) {
			foreach ($row as $key => $val) {
				if ($val == NULL) $infoMissing = true;
			}
		}

		// no prior degrees
		$query = "SELECT COUNT(*) AS degree_count FROM prior_degrees WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$degree_count = mysqli_fetch_array($result)["degree_count"];

		// no test scores (of all kinds)
		$query = "SELECT COUNT(*) AS score_count FROM GRE_score WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$score_count_gre = mysqli_fetch_array($result)["score_count"];

		$query = "SELECT COUNT(*) AS score_count FROM TOEFL_score WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$score_count_toefl = mysqli_fetch_array($result)["score_count"];

		$query = "SELECT COUNT(*) AS score_count FROM Adv_GRE WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$score_count_adv = mysqli_fetch_array($result)["score_count"];

		// no work exp
		$query = "SELECT COUNT(*) AS exp_count FROM experience WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$exp_count = mysqli_fetch_array($result)["exp_count"];

		// no transcripts
		$query = "SELECT COUNT(*) AS transcript_count FROM transcript WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$transcript_count = mysqli_fetch_array($result)["transcript_count"];

		// no references
		$query = "SELECT COUNT(*) AS ref_count FROM rec_letter WHERE applicationID = " . $_SESSION["appID"];
		$result = try_query($dbc, $query, NULL);
		$ref_count = mysqli_fetch_array($result)["ref_count"];

		$canSubmit = (!$infoMissing) && ($transcript_count > 0) && ($ref_count > 0);

		if ($infoMissing || ($degree_count == 0) || ($score_count_gre == 0) || ($score_count_toefl == 0) || ($score_count_adv == 0) || ($exp_count == 0) || ($transcript_count == 0) || ($ref_count < 3)) :
	?>
		<p>You're missing some things. You don't have to turn them in, but including more materials helps the admissions committee get to know you better.</p>

		<ul id="missingMaterials">
		<?php
			if ($infoMissing) :
		?>
			<li class="req">Missing personal info</li>
		<?php
			endif;
			if ($degree_count == 0) :
		?>
			<li class="opt">No prior degrees entered</li>
		<?php
			endif;
			if ($score_count_gre == 0) :
		?>
			<li class="opt">No GRE scores entered</li>
		<?php
			endif;
			if ($score_count_toefl == 0) :
		?>
			<li class="opt">No TOEFL scores entered</li>
		<?php
			endif;
			if ($score_count_adv == 0) :
		?>
			<li class="opt">No GRE subject test scores entered</li>
		<?php
			endif;
			if ($exp_count == 0) :
		?>
			<li class="opt">No work experience entered</li>
		<?php
			endif;
			if ($transcript_count == 0) :
		?>
			<li class="req">No transcripts entered</li>
		<?php
			endif;
			if ($ref_count == 0) :
		?>
			<li class="req">No references listed</li>
		<?php
			elseif ($ref_count < 3) :
		?>
			<li class="opt">Less than three references listed</li>
		<?php
			endif;
		?>
		</ul>

		<script>
			$("#missingMaterials").find("li.req").each(function(index) {
				$(this).append("<span class='red'> (required)</span>");
			});
			$(".red").css("color", "red");
			$("#missingMaterials").find("li.opt").each(function(index) {
				$(this).append("<span class='green'> (optional)</span>");
			});
			$(".green").css("color", "green");
		</script>

	<?php
		else :
	?>
	<p>No materials are missing. Great job!</p>

	<?php endif; ?>

	<p>Before you submit your application, check that all information is complete and correct. You will not be able to make changes after you press submit. You will still be able to monitor your transcripts and references in this portal.</p>
	<button type="button" <?php if (!$canSubmit) echo 'disabled'; ?> onclick="submitApplication()">Submit Application</button>

<?php endif; ?>


<?php if ($status["decisionID"] == 2 || $status["decisionID"] == 3): ?>
	<p> Congratulations on your acceptance! If you choose to accept your offer of admission, please mail your deposit to the department to be matriculated.</p>
	<button type="button" onclick="acceptAdmission()">Accept Offer of Admission</button>
	<button type="button" onclick="rejectAdmission()">Reject Offer of Admission</button>
<?php elseif ($status["decisionID"] == 5): ?>
	<p>We are excited for you to join the department! To complete your matriculation, please mail your security deposit to the department (same as with your transcript). You will be matriculated upon receipt.</p>
<?php endif; ?>
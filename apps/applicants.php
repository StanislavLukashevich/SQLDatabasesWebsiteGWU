<?php

	require_once('./includes/utils.php');
	//connect to DB and get current applicants
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if(!($dbc)){
		die('Error connecting to DB');
	}

	$search_keys = array();

	if (isset($_POST["lname"]) && $_POST["lname"] != '') {
		$search_keys["lname"] = htmlspecialchars($_POST["lname"]);
    }
    if (isset($_POST["userID"]) && $_POST["userID"] != '') {
		$search_keys["userID"] = htmlspecialchars($_POST["userID"]);
    }
    if (isset($_POST["qYear"]) && $_POST["qYear"] != '') {
		$search_keys["qYear"] = htmlspecialchars($_POST["qYear"]);
    }
    if (isset($_POST["qTerm"]) && $_POST["qTerm"] != '') {
		$search_keys["qTerm"] = htmlspecialchars($_POST["qTerm"]);
    }
    if (isset($_POST["qDegree"]) && $_POST["qDegree"] != '') {
		$search_keys["qDegree"] = htmlspecialchars($_POST["qDegree"]);
    }

	function where_search_discrete($search_keys) {
		$where = "";
		if (isset($search_keys["qYear"])) {
			$where .= " AND DATE_FORMAT(application_form.term, '%Y') = '" . $search_keys["qYear"] . "'";
		}
		if (isset($search_keys["qTerm"])) {
			$where .= " AND IF(CAST(DATE_FORMAT(application_form.term, '%m') AS UNSIGNED) > 6, 'Fall', 'Spring') = '" . $search_keys["qTerm"] . "' ";
		}
		if (isset($search_keys["qDegree"])) {
			$where .= " AND application_form.degree = '" . $search_keys["qDegree"] . "' ";
		}
		return $where;
	}

    function where_search($search_keys) {
		$where = "";
		if (isset($search_keys["lname"])) {
			$where .= " AND LOWER(personal_info.lname) LIKE LOWER('" . $search_keys["lname"] ."') ";
		}
		if (isset($search_keys["userID"])) {
			$where .= " AND users.id = " . $search_keys["userID"];
		}
		$where .= where_search_discrete($search_keys);
		return $where;
	}

	//query for applicants (roleID 1) that have submitted the application (submitted = 1)
	$getApplicants = "SELECT users.id AS userID, CONCAT(personal_info.fname, ' ', personal_info.lname) AS name, application_form.applicationID, decisions.description AS status, decisions.decisionID AS decisionID, DATE_FORMAT(application_form.term, '%Y') AS year, IF(CAST(DATE_FORMAT(application_form.term, '%m') AS UNSIGNED) > 6, 'Fall', 'Spring') AS term, application_form.degree AS degree ";
	$getApplicants .= "FROM users LEFT JOIN personal_info ON users.id = personal_info.user_id ";
	$getApplicants .= "JOIN application_form ON users.id = application_form.userID ";
	$getApplicants .= "JOIN decisions on decisions.decisionID = application_form.decision ";
	$getApplicants .= "WHERE decisions.decisionID > 0 ";
    $getApplicants .= where_search($search_keys);
	$getApplicants .= " ORDER BY application_form.decision DESC";


	$applicantResult = mysqli_query($dbc, $getApplicants);

	$role = $_SESSION["p_level"];
	$fID = $_SESSION["id"];

?>

<head>

	<meta http-equiv="Content-Type" content="text/html cahrset=utf-8" />

	<title>Review Applications</title>

</head>

<body>
	<h2 align="center">Applications</h2><br/>

	<div class="row">
	<div class="col-xl-9 mx-auto">

	<form id="searchForm" method="get">
		<div class="form-label-group">
			<div class="form-row">
				<div class="form-group col-md-3">
					<input type="text" name="lname" value="<?php if (isset($search_keys['lname'])) echo $search_keys['lname']; ?>" class="form-control" placeholder="Search by last name">
				</div>
				<div class="form-group col-md-3">
					<input type="text" name="userID" value="<?php if (isset($search_keys['userID'])) echo $search_keys['userID']; ?>" class="form-control" placeholder="Search by ID">
				</div>
				<div class="form-group col-md-1">
				  <select name="qYear" class="form-control">
				  	<option value="">Year</option>
				  	<?php
				  		$query = "SELECT DISTINCT DATE_FORMAT(term, '%Y') AS year FROM application_form";
				  		$result = try_query($dbc, $query, NULL);
				  		while($option = mysqli_fetch_array($result)) :
				  			if ($option['year'] != '') :
				  	?>
				    <option value="<?= $option['year'] ?>" <?php if (isset($search_keys['qYear']) && $search_keys['qYear'] == $option['year']) echo 'selected'; ?>>
				    	<?= $option['year'] ?>
				    </option>
					<?php 
						endif;
						endwhile; 
					?>
				  </select>
				</div>
				<div class="form-group col-md-1">
				  <select name="qTerm" class="form-control">
				  	<option value="">Term</option>
				  	<?php
				  		$options = array("Fall", "Spring");
				  		foreach ($options as $option) :
				  	?>
					    <option value="<?= $option ?>" <?php if (isset($search_keys['qTerm']) && $search_keys['qTerm'] == $option) echo 'selected'; ?>><?= $option ?>
					    </option>
					<?php endforeach; ?>
				  </select>
				</div>
				<div class="form-group col-md-1">
				  <select name="qDegree" class="form-control">
				  	<option value="">Degree</option>
				  	<?php
				  		$query = "SELECT DISTINCT degree FROM application_form";
				  		$result = try_query($dbc, $query, NULL);
				  		while($option = mysqli_fetch_array($result)) :
				  	?>
				    <option value="<?= $option['degree'] ?>" <?php if (isset($search_keys['qDegree']) && $search_keys['qDegree'] == $option['degree']) echo 'selected'; ?>>
				    	<?= $option['degree'] ?>
				    </option>
					<?php endwhile; ?>
				  </select>
				</div>
				<div class="form-group col-md-2" id="button-row">
				</div>
			</div>
		</div>
	</form>

	<script>
		button = $.parseHTML('<button type="submit">Filter</button>');
		$("#button-row").append(button);
		form = $("#searchForm");
		form.submit(function(e) {
			e.preventDefault();
			$("#content").load("applicants.php", form.serializeArray(), function() {
				console.log("Searching");
			})
		});
	</script>

	<table class="applicantTable" style='width:100%' align='center'>
		<tr>
			<th>Term</th>
			<th>Program</th>
			<th>Applicant</th>
			<th>Review</th>
			<th>Status</th>
			<?php if (check_permissions(1)) : ?>
			<th>Mark Transcript Received</th>
			<th>Matriculate</th>
			<?php endif; ?>
		</tr>
		<?php if (!$applicantResult): ?>
		<tr class="bordered">
			<td colspan='4'>No results found.</td>
		</tr>
		<?php else: 
			while($applicant = mysqli_fetch_array($applicantResult)) {	
				$name = $applicant['name'];
				$userID = $applicant['userID'];
				$applicationID = $applicant['applicationID'];
				$status = $applicant['status'];
				$decisionID = $applicant['decisionID'];
				$year = $applicant["year"];
				$term = $applicant["term"];
				$degree = $applicant["degree"];

				$doneQuery = "SELECT * FROM review_form WHERE facultyID = '$fID' AND applicationID = '$applicationID'";
				$doneResult = mysqli_query($dbc, $doneQuery);
		?>
		<tr class="bordered">
			<td><?= $term ?><br><?= $year ?></td>	
			<td><?= $degree ?></td>
			<td><?= $name ?></td>
			<td>
			<?php if(mysqli_num_rows($doneResult) == 0): ?>
				<?php if ($decisionID == 1) : ?>
				<button class='btn btn-primary' id='<?= $userID ?>' onclick='reviewApplicant(<?= $userID ?>)'>Review</button>
				<?php else: ?>
				Final review complete.
				<?php endif; ?>
			<?php else: ?>
				Reviewed.
			<?php endif; ?>
			</td>
			<td>
				<?= $status ?>
			</td>
			<?php if (check_permissions(1)): 
				$transcriptQuery = "SELECT * FROM transcript WHERE applicationID = '$applicationID'";
				$transcriptResult = mysqli_query($dbc, $transcriptQuery);
				if(mysqli_num_rows($transcriptResult) == 0 && $decisionID == 1):
			?>
				<td>
					<button class='btn btn-primary' onclick='postAndResponse(\"./reviewForms/receivedTranscript.php\", {applicationID: \"<?= $applicationID ?>\"});location.reload()'>
					Received Transcript
					</button>
				</td>
				<?php else: ?>
					<td>
						Received
					</td>
				<?php endif; ?>

				<?php if ($decisionID == 5): ?>
					<td>
						<button class='btn btn-primary' onclick='postAndResponse("./reviewForms/matriculateStudent.php", {applicationID: "<?= $applicationID ?>"});location.reload()'>
						Matriculate
						</button>
					</td>
				<?php elseif ($decisionID == 7): ?>
					<td>Matriculated</td>
				<?php else: ?>
					<td>N/A</td>
				<?php endif; ?>
			<?php endif; ?>
		</tr>
		<?php 
			}
			endif; 
		?>
	</table>

	</div>
	</div>

	<?php if (check_permissions(1)): ?>

	<h2 align="center" style="margin-top: 2em;">Statistics</h2>
	<p align="center">Showing <?= isset($search_keys["qDegree"]) ? $search_keys["qDegree"] . " " : "" ?>admissions statistics for <?= !isset($search_keys["qTerm"]) ? "all terms" : $search_keys["qTerm"]?> <?= !isset($search_keys["qYear"]) ? "in all years" : $search_keys["qYear"] ?>.</p>

	<?php
		$queryAll = "SELECT COUNT(DISTINCT userID) AS num_applicants, AVG(GRE_score.totalScore) AS avg_gre";
		$queryAll .= " FROM application_form";
		$queryAll .= " JOIN personal_info ON application_form.userID = personal_info.user_id";
		$queryAll .= " LEFT JOIN GRE_score ON application_form.applicationID = GRE_score.applicationID WHERE application_form.submitted = 1";

		$queryAdmitted = $queryAll . " AND (application_form.decision = 2 OR application_form.decision = 3 OR application_form.decision > 4)";
		$queryRejected = $queryAll . " AND application_form.decision = 4";

		$queryAll .= where_search_discrete($search_keys);
		$queryRejected .= where_search_discrete($search_keys);
		$queryAdmitted .= where_search_discrete($search_keys);

	    $all = mysqli_fetch_array(try_query($dbc, $queryAll, NULL));
	    $admitted = mysqli_fetch_array(try_query($dbc, $queryAdmitted, NULL));
	    $rejected = mysqli_fetch_array(try_query($dbc, $queryRejected, NULL));
	?>

	<div class="row">
	<div class="col-xl-9 mx-auto">
		<table class="applicantTable" id="applicantStatistics" align='center'>
			<tr>
				<td>Total Applicants</td>
				<td><?= $all["num_applicants"] ?></td>
			</tr>
				<td>Admitted</td>
				<td><?= $admitted["num_applicants"] ?></td>
			</tr>
			<tr>
				<td>Rejected</td>
				<td><?= $rejected["num_applicants"] ?></td>
			</tr>
			<tr>
				<td>Average GRE (Total)</td>
				<td><?= $all["avg_gre"] == "" ? "N/A" : number_format($all["avg_gre"], 0) ?></td>
			</tr>
			<tr>
				<td>Average GRE (Admitted)</td>
				<td><?= $admitted["avg_gre"] == "" ? "N/A" : number_format($admitted["avg_gre"]) ?></td>
			</tr>
			<tr>
				<td>Average GRE (Rejected)</td>
				<td><?= $rejected["avg_gre"] == "" ? "N/A" : number_format($rejected["avg_gre"]) ?></td>
			</tr>
		</table>
	</div>
	</div>

	<?php endif; ?>

	<script>
		function reviewApplicant(applicantID) {
			//load the review form page
			var xhttp = new XMLHttpRequest();
			console.log("applicantID " + applicantID);	
			xhttp.onreadystatechange = function() {
				if((this.readyState == 4) && (this.status == 200)){
					document.getElementById('content').innerHTML = this.responseText;
				}
			};

			xhttp.open("GET","./review.php?applicantID="+applicantID, true);
			xhttp.setRequestHeader("Content-Type", "application-x-www-urlendcoded");
			xhttp.send();

		}
	</script>

</body>

</html>	

<?php
	require_once('../includes/utils.php');

	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
		$applicationID = $_POST['applicationID'];

		/// get the program applying for (from application_form)
		$query = "SELECT degree, userID FROM application_form WHERE applicationID = $applicationID";
		echo $query . "\n";
		$result = try_query(
			$dbc, 
			$query,
			"Successfully pulled degree program"
		);
		$row = mysqli_fetch_array($result);
		$program = $row["degree"];
		$applicantID = $row["userID"];
		/// get the recommended advisor (from decision_form)
		$query = "SELECT recommendedAdvisor FROM final_decision WHERE applicantID = $applicantID";
		echo $query . "\n";
		$result = try_query(
			$dbc, 
			$query,
			"Successfully pulled recommended advisor"
		);
		$advisor = mysqli_fetch_array($result)["recommendedAdvisor"];
		echo $advisor . "\n";
		
		// change permissions
		$query = "UPDATE users SET p_level = '4' WHERE id = $applicantID";
		echo $query . "\n";
		try_query($dbc, $query, "Changed applicant permissions to student permissions");

		// add to student table
		try {
			$matriculatedDate = date("Y");
			$query = "INSERT INTO student (u_id, program, advisorid, admit_year) VALUES ($applicantID, '$program', $advisor, '$matriculatedDate')";
			echo $query . "\n";
			try_query($dbc, $query, "Added applicant to student table");
		} catch (exception $e) {
			if ($dbc->errno == 1062) {
				// this is just a duplicate error - probably leftover from a previous try
				// no worries
				echo "Tried inserting student again, but student already found\n";
			}
			else {
				throw $e;
			}
		}

		// TODO: automatically register for deficient courses

		// Get next semester
		$today = new DateTime();

		// Find which season it is	
		if ($today < new DateTime ('August 29')) {
			$s = "Fall";
		} else {
			$s = "Spring";
		}

		$y = date ("Y");

		// Query deficient_courses table for all deficient courses for this $applicationID
		$query = "SELECT course_id AS c_no FROM deficient_courses WHERE applicationID = $applicationID";
		$results = try_query($dbc, $query, "Retrieved deficient course numbers");
		
		$reg_query = "INSERT INTO courses_taken (student_id, crn, grade) VALUES";
		$register = false;

		while($row = mysqli_fetch_array($results)) {
			$c_no = $row["c_no"];

			// Find the appropriate crn for this course
			$crn_query = "SELECT crn FROM catalog, schedule
						  WHERE c_no=$c_no and c_id=course_id and semester='$s' and year=$y and department='CSCI'";
			echo $crn_query . "\n";
			$crn_results = try_query($dbc, $crn_query, "Found crn's matching course no $c_no");

			// If a crn was found, register applicant for the class
			if ($crn_results) {
				$register = true;			

				$crn_row = mysqli_fetch_array ($crn_results);
				$crn = $crn_row['crn'];

				// Add another insert to the query for the course
				$reg_query = $reg_query . " ($applicantID, $crn, 'IP')"; 
				echo $reg_query . "\n";
			}
		}

		if ($register) {
			try {
				try_query($dbc, $reg_query, "Registered for course " . $c_no);
			}
			catch (exception $e) {
				if ($dbc->errno == 1062) {
					echo "Duplicate course registration, but no worries\n";
				}
				else {
					throw $e;
				}
			}
		}

		// if all that worked, set decision to matriculated (7)
		$query = "UPDATE application_form SET decision = 7 WHERE applicationID = $applicationID";;
		try_insert($dbc, $query, 'Set application to matriculated with ID $applicationID');
	}
?>

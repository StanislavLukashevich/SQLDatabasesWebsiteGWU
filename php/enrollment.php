<!DOCTYPE html>
<html lang="en">

<head>
	<title> Enrollment - Ginerale ARGS</title>

    <?php
		if (empty($id)) {
			header("Location: login.php");
		}

		if (strcmp ($_SESSION['p_level'], "4") == 0) {
			header("Location: home.php");
		}	

		if (empty($_GET['cid'])) {
			header("Location: grades.php");
		}
		
		$query = 'SELECT department, c_no, title FROM catalog WHERE c_id="'. $_GET['cid'] .'"';
		$course = mysqli_query ($dbc, $query);
		$course = mysqli_fetch_array ($course);

		if (substr ($_GET['semester'], 0, 1) == "F") {
			$sem = "Fall";
		} else {
			$sem = "Spring";
		}

		$y = substr ($_GET['semester'], -4);

		$course = $course['department'] . " " . $course['c_no'] . ": " . $course['title'];

		// Query for all the students in this course
		$query = "SELECT student_id, fname, lname, grade, courses_taken.crn
						  FROM courses_taken, schedule, catalog, personal_info
						  WHERE courses_taken.crn=schedule.crn 
							and user_id=student_id
							and schedule.course_id=catalog.c_id
							and catalog.c_id='". $_GET['cid'] ."'
							and semester='$sem' and year='$y'
				 ";
		$students = mysqli_query ($dbc, $query);

		// Variable to track the last student that's grades were updated
		$last_update = "";

		// Check if grades need to be updated
		while ($s = mysqli_fetch_array ($students)) {
			if (isset ($_POST['U'. $s['student_id']])) {
				$grade = $_POST['U'. $s['student_id']];

				// If this is not a faculty, then grades can be editied infinitely	
				if (strpos ($_SESSION['p_level'], "6") !== true) {
					$update_query = 'UPDATE courses_taken SET grade="'. $grade .'" 
									 WHERE student_id="'. $s['student_id'] .'" and crn="'. $s['crn'] .'"';
					mysqli_query ($dbc, $update_query);

					// Set the last update so the select menu for the grade can be made 
					// green to show user that the changes have been made
					$last_update = $s['student_id'];
				} 
				// For faculty, only update if the grade hasn't been set
				else if (strcmp ($grade, "IP") != 0) { 
					$update_query = 'UPDATE courses_taken SET grade="'. $grade .'" 
									 WHERE student_id="'. $s['student_id'] .'" and crn="'. $s['crn'] .'"';
					mysqli_query ($dbc, $update_query);
				}
			}
		}
	?>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

	<div class="container">
            <div class="row mt-5">
				<h2 class="text-primary"> <?php echo $course; ?> </h2>
			</div>
            <div class="row">
				<h3 class="text-secondary"> <?php echo $sem . " " . $y; ?> </h3>
			</div>
			
            <div class="row">
				<p><strong class="text-black d-block"> 
					To change a student's grade, use the dropdown menu and click the submit button for each student. 
				</strong></p>
			</div>

			<div class="row mt-3">
			<table class="table table-bordered">

				<thead>
					<tr class="text-center table-primary">
						<th scope="col"> U_ID </th>
						<th scope="col"> First Name </th>
						<th scope="col"> Last Name </th>
						<th scope="col"> Grade </th>
						<th scope="col"></th>
					</tr>
				</thead>

				<tbody>

			<?php
				$students = mysqli_query ($dbc, $query);
				while ($students && $s = mysqli_fetch_array ($students)) {
					echo '<tr class="text-center">';

					// Print each field of each student, except for grade
					for ($i = 0; $i < 3; $i++) {
						echo '<td class="align-middle">' . $s[$i] . '</td>';
					}

					// Check if grade has been set OR this is not a faculty	
					if (strcmp ($s['grade'], "IP") == 0 || strpos ($_SESSION['p_level'], "6") === false) {
						// Add a dropdown to enter grade 
						echo '<td class="align-middle"> 
								<form action="grades.php?cid='. $_GET['cid'] .'&semester='. $_GET['semester'] .'" method="post">';
						
						// If this was the last grade changed, make the select green
						if (strcmp ($s["student_id"], $last_update) == 0) {
							echo '<select class="btn btn-primary" name="U'. $s['student_id'] .'">';
							$last_update = "";
						} else { // Make it the normal, muted grey
							echo '<select class="btn btn-muted" name="U'. $s['student_id'] .'">';
						}

						$grades = array ("IP", "A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D+", "D", "D-", "F");

						foreach ($grades as $g) {
							// If this option is the current grade for student, set it as selected
							if (strcmp ($g, $s['grade']) == 0) {
								echo '<option value="'. $g .'" selected="selected"> '. $g .'</option>';
							} else { // Echo normal option (unselected)
								echo '<option value="'. $g .'"> '. $g .'</option>';
							}
						}
						
						echo '</td> </select>';
						echo '<td> <input type="submit" value="Submit Grade" class="btn btn-danger"> </td>';
						echo '</form>';
					} else { // Grade has already been set, no need for dropdown menu
						echo '<td class="align-middle">' . $s['grade'] . '</td>';
						echo '<td class="align-middle"> <button class="btn btn-muted" disabled> Submit Grade </button> </td>';
					}
					echo '</tr>';
				}
			?>
				</tbody>

			</table>	
			</div>	
	</div>

</body>

</html>



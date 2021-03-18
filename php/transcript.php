<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transcript - Ginerale ARGS </title>
    <?php
      include_once ('header.php'); 
	?>

</head>

<body>

<br><br><br>

    <div class="container mt-5">
		<h1 class="text-primary"> Transcript </h1>

        <?php
            include ('connectvars.php');		

			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	
			$id = "";

            // If current user is not a student, show a dropdown menu to select a student
            if (isset ($_SESSION['p_level']) && strcmp ($_SESSION['p_level'], '4') != 0 
					&& strcmp ($_SESSION['p_level'], '5') != 0) {
				echo '<form method="get" action="transcript.php">
						<input name="search" type="text" 
							placeholder="Enter student ID number" autocomplete="off">
						<input type="submit" value="Search" class="btn btn-secondary">
					  </form>';

				if (isset ($_GET['search'])) {
					$id = trim ($_GET['search']);
				}
			}
	
			if (isset ($_SESSION['id']) && (strcmp ($_SESSION['p_level'], "4") == 0
					|| strcmp ($_SESSION['p_level'], "5") == 0)) { 
				$id = $_SESSION['id'];
			}

			$query = "SELECT fname, lname FROM personal_info WHERE user_id=$id";
			$result = mysqli_query ($dbc, $query);

			if ($result) {
				$name = mysqli_fetch_array ($result);
				$name = $name['fname'] . " " . $name['lname'];
				
				echo "<br><h2> <span class='text-secondary'> Now viewing: $name </span> </h2>";
			}
			
            // Find all semesters this student took classes in
            $query = "SELECT semester, year
                      FROM courses_taken, schedule, personal_info
                      WHERE student_id=$id and courses_taken.crn=schedule.crn 
                      GROUP BY semester, year
					  ORDER BY year ASC, semester DESC";
            $semesters = mysqli_query ($dbc, $query);

			$empty_transcript = True;
			$total_credits = 0;
			$total_grade_pts = 0;

            while ($semesters && $s = mysqli_fetch_array($semesters)) {

				// There is at least one semester, set flag accordingly
				$empty_transcript = False;

                echo '
                <div class="row">
                    <div class="col d-flex flex-col mt-2">
                        <th class="p-2 mx-2 text-white" scope="col-6"> <h3><span class="text-primary">Semester: ' .
                        $s['semester'] . ' ' . $s['year']
                        . '</span></h3> </th>
                    </div>
                </div>

                <div class="row">
                    <table class=" border-left border-right table">

                    <thead>

                         <tr class="text-center table-light">
                            <th scope="col">Department</th>
                            <th scope="col">Course Number</th>
                            <th scope="col">Course Name</th>
                            <th scope="col">Credit Hours</th>
                            <th scope="col">Instructor</th>
                            <th scope="col">Grade</th>
                        </tr>
                    </thead>
                ';

                // Find all courses this student has taken/is taking
                $query = "SELECT c_no, department, title, credits, grade, personal_info.lname
                          FROM schedule, courses_taught, catalog, courses_taken, personal_info
                          WHERE student_id=$id and user_id=courses_taught.f_id
                            and courses_taken.crn=schedule.crn and catalog.c_id=schedule.course_id
							and courses_taught.crn=courses_taken.crn
							and semester='". $s['semester'] ."' and year=". $s['year'];
                $classes = mysqli_query ($dbc, $query);
				
				$grades = [];

                while ($c = mysqli_fetch_array($classes)) {
                    echo '
                    <tbody>
                        <tr class="text-center">
                            <td>'. $c['department'] .'</td>
                            <td>'. $c['c_no'] .'</td>
                            <td>'. $c['title'] .'</td>
                            <td>'. $c['credits'] .'</td>
                            <td>'. $c['lname'] .'</td>
                            <td>'. $c['grade'] .'</td>
                        </tr>
                    </tbody>
                    ';
					array_push ($grades, [$c['grade'], $c['credits']]);
                }

				$term_credits = 0;
				$term_grade_pts = 0;
				$total_gpa = 0;

				foreach ($grades as &$g) {
					switch ($g[0]) {
						case 'A':
							$g[0] = 4.0;
							break;
						case 'A-':
							$g[0] = 3.7;
							break;
						case 'B+':
							$g[0] = 3.3;
							break;
						case 'B':
							$g[0] = 3.0;
							break;
						case 'B-':
							$g[0] = 2.7;
							break;
						case 'C+':
							$g[0] = 2.3;
							break;
						case 'C':
							$g[0] = 2.0;
							break;
						case 'C-':
							$g[0] = 1.7;
							break;
						case 'D+':
							$g[0] = 1.3;
							break;
						case 'D':
							$g[0] = 1.0;
							break;
						case 'D-':
							$g[0] = 0.7;
							break;
						case 'F':
							$g[0] = 0.0;
							break;
						case 'IP':
							$g[0] = -1;
							break;
					}

					// Only add totals if this class has a final grade
					if ($g[0] > 0) {
						// Add credits
						$term_credits += $g[1];
						// Now calculate quality pts and add to total
						$term_grade_pts += $g[0] * $g[1];
					}
				}

				if ($term_credits > 0) {
					// Now calculate final gpa for the semester
					$term_gpa = $term_grade_pts / $term_credits;

					$total_grade_pts += $term_grade_pts;
					$total_credits += $term_credits;
				} else {
					$term_gpa = 0;
				}

				if ($total_credits) {
					$total_gpa = $total_grade_pts / $total_credits;
				}

                echo "
                    </table>
					<div class='alert alert-success'>
						Current Term GPA: <span class='text-primary'> $term_gpa </span>
						<br /> Cumulative GPA: <span class='text-primary'> $total_gpa </span>
					</div>
                </div>
                ";
            }

			// Check if transcript is empty and this is a student
			if ($empty_transcript && strcmp ($_SESSION['p_level'], "4") == 0) {
				echo '<div class="container pt-3">
					      <h4 class="pl-1 font-weight-lighter"> <small>
						    You have not taken any classes and are not currently registered for any.
						  </small></h4>
					  </div>';
			} else if($empty_transcript){
				echo '<div class="container pt-3">
					      <h4 class="pl-1 font-weight-lighter"> <small>
							Student has not taken any classes and is not currently registered for any.
						  </small></h4>
					  </div>';
			}

        ?>

    </div>

</body>

</html>

<!DOCTYPE HTML>

<html>

	<?php
		require_once('../includes/utils.php');

		$fID = $_SESSION["id"];
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

		$applicationID = $_GET['applicationID'];

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$recDecision = $_POST['rating'];
			$reasons = $_POST['reasons'];
			if(alpha($reasons)){
				$comments = $_POST['comments'];
				if(alpha($comments)){
					$course_no = $_POST['courses'];

					if ($course_no != '') {
						// check for course in catalog
						$query = "SELECT * FROM catalog WHERE c_no = $course_no";
						if (mysqli_num_rows(try_query($dbc, $query, NULL)) < 1) {
							exit("No course found with number ($course_no). Check your course number and try again.");
						}
						// add the courses, if possible
						$insertCourses = "INSERT INTO deficient_courses VALUES ($applicationID, $course_no)";
						try {
							try_insert($dbc, $insertCourses, 'successfully inserted deficient course');
						} catch (exception $e) {
							echo $e;
						}
					}

					// now add the review and redirect
					$insertReview = "INSERT INTO 
								review_form(facultyID, applicationID, suggested_decision, reasons, comments)
								VALUES ('$fID', '$applicationID', '$recDecision', '$reasons', '$comments')";	
					$inserted = try_insert($dbc, $insertReview, 'recommendation entered, thank you!');
					if (!is_null($inserted)) {
						header("Location: ../index.php");
					}
				}else{
					echo"Invalid input, comments cannot contain numbers or special characters";
				}
			}else{
				echo"Invalid input, reasons cannot contain numbers or special characters";
			}
		}

		

	?>

<html>

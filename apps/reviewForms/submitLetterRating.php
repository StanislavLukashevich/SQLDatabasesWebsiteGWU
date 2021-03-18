<?php
	//echo"in submit letter ";
	require_once('../includes/utils.php');

	$fID = $_SESSION["id"];
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$applicationID = $_GET['applicationID'];
	$letterID = $_GET['letterID'];

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_POST)){
			$generic = $_POST['generic'];
			if((strcmp($generic, "Y") == 0) || (strcmp($generic, "N") == 0)){
				$credible = $_POST['credible'];
				if((strcmp($credible, "Y") == 0) || (strcmp($credible, "N") == 0)){
					$score = $_POST['score'];
					if((ctype_digit($score)) && ($score <= 5) && ($score >= 1)){
						$insertQuery = "INSERT INTO letter_rating VALUES
			       					($fID, $letterID, '$credible', '$generic', $score)";
						$result = try_query($dbc, $insertQuery, NULL);
					}else{
						echo"<script> alert('Invalid input: score must be a digit 1 - 5'); </script>";
					}
				}else{
					echo"<script> alert('Invalid input: credible should be Y or N'); </script>";
				}
			

			}else{
				echo "<script> alert('Invalid input: generic should be Y or N'); </script>";
			}	

		}
	}

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$query = "SELECT credible, generic, score FROM letter_rating WHERE ";
		$query .= "facultyID = $fID AND letterID = $letterID";
		$result = try_query($dbc, $query, NULL);
		$keys = array("credible", "generic", "score");
		$row = mysqli_fetch_row($result);
		if (!is_null($row)) {
			$output = array_combine($keys, $row);
			echo json_encode($output);
		}	
	}

?>

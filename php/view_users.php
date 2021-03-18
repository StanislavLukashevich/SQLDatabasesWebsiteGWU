<?php
include_once ('header.php'); 

if (!isset ($_SESSION["id"]) || (strcmp ($_SESSION["p_level"], "0") != 0 && strcmp ($_SESSION["p_level"], "1") != 0)) {
    header("Location: login.php");
}

if (isset ($_POST['role'])) {
	// Applicant Selected
	if (strcmp ($_POST['role'], "3") == 0) {
		header ("Location: ../apps/");
	} 

	// Alumni selected	
	else if (strcmp ($_POST['role'], "5") == 0) {
		header ("Location: ../ads/studentsel.php");
	}

	$role[$_POST['role']] = "selected";
}

session_start();

if (isset ($_GET['filter'])) {
	$_POST['role'] = "4";
	$role['4'] = "selected";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title> Users - Ginerale ARGS </title>
</head>

<body>

	<div class="container mt-5">
		<div class="row">
			<h1 class="text-primary"> Users </h1> <br>
		</div>
	
		<div class="row mt-2">
			<input class="form-control" id="search_filter" type="text" placeholder="Search...">
		</div>

		<div class="row mt-2">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="col-md">	
					<select name="role" class="btn btn-secondary">
					<?php echo "
						<option value=''> All Types </option>
						<option value='0' ". $role['0'] ."> Admin </option>
						<option value='1' ". $role['1'] ."> GS </option>
						<option value='2' ". $role['2'] ."> Chair </option>
						<option value='3' ". $role['3'] ."> Applicant </option>
						<option value='4' ". $role['4'] ."> Student </option>
						<option value='5' ". $role['5'] ."> Alumni </option>
						<option value='6' ". $role['6'] ."> Faculty Instructor</option>
						<option value='7' ". $role['7'] ."> Faculty Reviewer </option>
						<option value='8' ". $role['8'] ."> Faculty Advisor </option>
					"; ?>
					</select>
					<input type="submit" value="Select Role" class="btn btn-primary">		
				</div>
			</form>
		</div>

		<?php

			if (isset ($_POST['role'])) {
				$role = $_POST['role'];

				if ($role == "4") { // Student 
					include_once ("students.php");	
				} else {
					include_once ("users.php");	
				}
			} else {
				include_once ("users.php");	
			}

		?>	
	
	</div>	

</body>

<script>
    $(document).ready(function(){
    $("#search_filter").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#users_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
</script>

</html>

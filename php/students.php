<?php
include_once ('header-meta.php');
include_once ('connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset ($_GET['id'])) { 
	// Query to delete from each relation
	$query = 'DELETE FROM courses_taken WHERE student_id="'. $_GET['id'] .'";';
	$query = $query . 'DELETE FROM student WHERE u_id="'. $_GET['id'] .'";';
	$query = $query . 'DELETE FROM personal_info WHERE user_id="'. $_GET['id'] .'";';
	$query = $query . 'DELETE FROM users WHERE id="'. $_GET['id'] .'";';

	mysqli_multi_query ($dbc, $query);

	header ('Location: view_users.php');
}

// Find all unique admit years in student table
$query = "SELECT admit_year FROM student GROUP BY admit_year ORDER BY admit_year ASC";
$years = mysqli_query ($dbc, $query);

$ms_sel = "";
$phd_sel = "";

if (isset ($_GET['program'])) {
	if (strcmp ($_GET['program'], "MS") == 0) {
		$ms_sel = "selected";
	} else if (strcmp ($_GET['program'], "PhD") == 0) {
		$phd_sel = "selected";
	}
}

$year_sel = [];
if (isset ($_GET['year'])) {
	$year_sel[$_GET['year']] = "selected";
}

?>

<!DOCTYPE html>
<html lang="en">

<body>

<div class="container mt-2">

<div class="row">
	<form method="get" action="view_users.php">
		<div class="col-md">	
			<select name="program" class="btn btn-secondary">
				<option value=""> All Degrees </option>
				<option value="MS" <?php echo $ms_sel; ?>> MS </option>
				<option value="PhD" <?php echo $phd_sel; ?>> PhD </option>
			</select>
			<select name="year" class="btn btn-secondary">
				<option value=""> All Years </option>
				<?php 
					while ($y = mysqli_fetch_array ($years)) {
						$new_year = $y['admit_year'];
						echo "<option value='$new_year' ".$year_sel[$new_year]."> $new_year </option>";
					}
				?>
			</select>
			<input type="submit" name="filter" value="Filter" class="btn btn-primary">		
		</div>
	</form>
</div>

<div class="row mt-5">
	<table class="table table-bordered">
		<thead>
			<tr class="text-center table-primary">
				<th scope="col"> ID </th>
				<th scope="col"> Role </th>
				<th scope="col"> First Name </th>
				<th scope="col"> Last Name </th>
				<th scope="col"> Email </th>
				<th scope="col"> Address </th>
				<th scope="col"> Program </th>
				<th scope="col"> Admit Year </th>
				<th scope="col"> </th>
			</tr>
		</thead>

		<tbody id="users_table">

	<?php
		$query = 'SELECT id, p_level, fname, lname, email, address, program, admit_year
				  FROM users, personal_info, student
				  WHERE id=user_id and u_id=id';

		if (isset ($_GET['program']) && $_GET['program']) {
			$query = $query . " and program='". $_GET['program'] . "'";
		}
		if (isset ($_GET['year']) && $_GET['year']) {
			$query = $query . " and admit_year='". $_GET['year'] ."'";
		}

		$users = mysqli_query ($dbc, $query);

		while ($users && $u = mysqli_fetch_assoc ($users)) {
			echo '<tr class="text-center">';

			$u['id'] = sprintf ("%08s", $u['id']);

			$u['p_level'] = "Student";

			foreach ($u as $data) {
				echo '<td class="align-middle">' . $data . '</td>';
			}

			// Add the buttons
			echo '<td class="align-middle">';

			// Add the view transcript button
			echo '<a href="transcript.php?search='. $u['id'] .'" class="btn btn-primary"> View Transcript </a>';

			// Add the edit button
			// Only add if this isn't admin or GS
			if (strcmp ($u['p_level'], "Admin") != 0 && strcmp ($u['p_level'], "GS") != 0) {
				echo '<a href="account.php?id='. $u['id'] .'" class="btn btn-warning"> Edit </a>';
			}

			// Add the delete button
			// Only allow a working delete button for Admin
			if (strcmp ($_SESSION['p_level'], "0") == 0) {
				if (strcmp ($u['p_level'], "Admin") != 0 && strcmp ($u['p_level'], "GS") != 0) {
					echo '<a href="students.php?id='. $u['id'] .'" class="btn btn-danger"> Delete </a>';
				}
			}

			echo '</td> </tr>';
		}
	?>
		</tbody>

	</table>
</div>		
</div>		
</div>		

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

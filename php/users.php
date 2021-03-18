<?php
include_once ('header-meta.php');
include_once ('connectvars.php');

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset ($_GET['id'])) { 
	// Query to delete from each relation
	$query = 'DELETE FROM courses_taught WHERE f_id="'. $_GET['id'] .'";';
	$query = $query . 'DELETE FROM faculty WHERE f_id="'. $_GET['id'] .'";';
	$query = $query . 'DELETE FROM personal_info WHERE user_id="'. $_GET['id'] .'";';
	$query = $query . 'DELETE FROM users WHERE id="'. $_GET['id'] .'";';

	mysqli_multi_query ($dbc, $query);

	header ('Location: view_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<body>

<div class="container mt-5">

<div class="row mt-5">
	<table class="table table-bordered">
		<thead>
			<tr class="text-center table-primary">
				<th scope="col"> ID </th>
				<th scope="col"> Role </th>
				<th scope="col"> First Name </th>
				<th scope="col"> Last Name </th>
				<th> </th>
			</tr>
		</thead>

		<tbody id="users_table">

	<?php
		$query = 'SELECT id, p_level, fname, lname
				  FROM users, personal_info
				  WHERE id=user_id';

		if (isset ($_POST['role'])) {
			$filter = $_POST['role'];
		
			$query = $query . " and p_level LIKE '%$filter%'";
		}

		$query = $query . ' ORDER BY p_level ASC';

		$users = mysqli_query ($dbc, $query);

		while ($users && $u = mysqli_fetch_assoc ($users)) {
			echo '<tr class="text-center">';

			$u['id'] = sprintf ("%08s", $u['id']);

			$plevel = $u['p_level'];

			if (strpos ($plevel, "0") !== false)
				$type = "Admin";
			if (strpos ($plevel, "1") !== false)
				$type = "GS";
			if (strpos ($plevel, "2") !== false)
				$type = "Chair";
			if (strpos ($plevel, "3") !== false)
				$type = "Applicant";
			if (strpos ($plevel, "4") !== false)
				$type = "Student";
			if (strpos ($plevel, "5") !== false)
				$type = "Alumni";
			if (strpos ($plevel, "6") !== false)
				$type = "Faculty Instructor";
			if (strpos ($plevel, "7") !== false) {
				if (empty ($type))
					$type = "Faculty Reviewer";
				else
					$type = $type . ", Reviewer";
			}
			if (strpos ($plevel, "8") !== false) {
				if (empty ($type))
					$type = "Faculty Advisor";
				else
					$type = $type . ", Advisor";
			}
	
			$u['p_level'] = $type;	
			$type = "";

			foreach ($u as $data) {
				echo '<td class="align-middle">' . $data . '</td>';
			}

			// Add the buttons
			echo '<td class="align-middle">';

			// Add the edit button
			// Only add if this isn't admin or GS
			if (strcmp ($u['p_level'], "Admin") != 0 && strcmp ($u['p_level'], "GS") != 0) {
				echo '<a href="account.php?id='. $u['id'] .'" class="btn btn-warning"> Edit </a>';
			}

			// Add the delete button
			// Only allow a working delete button for Admin
			if (strcmp ($_SESSION['p_level'], "0") == 0) {
				if (strcmp ($u['p_level'], "Admin") != 0 && strcmp ($u['p_level'], "GS") != 0) {
					echo '<a href="users.php?id='. $u['id'] .'" class="btn btn-danger"> Delete </a>';
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

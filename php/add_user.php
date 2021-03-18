<!DOCTYPE html>
<html lang="en">

<style>
    .not-nav {
        margin-top: 3%; 
    }
</style>

<head>
  <?php require_once ('header.php'); ?>  
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

<?php
  require_once('connectvars.php');
  // TODO: Start the session

  if (!isset($_SESSION['id'])){ // If user is not logged in redirect to login
          header("Location: login.php");
  }

  $infoUpdatedMsg = "";
  $success = false; 
  $filled = false;

  if (isset($_POST['submit'])) {

      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_privilege = mysqli_real_escape_string($dbc, trim($_POST['plevel']));

      if (!empty($user_username) && !empty($user_privilege)) {
        $query = "INSERT INTO users (id, p_level, password) VALUES ('$user_username', '$user_privilege', '$user_username')";
        $data = mysqli_query($dbc, $query);
        // If The log-in is OK
        if ($data) {
          $infoUpdatedMsg = "New User Created";
		  $success = true;
        }
        else {
          $infoUpdatedMsg = 'Error: You must enter a valid user id and privilege level to create a new user.';
        }
      }
      else {
		$infoUpdatedMsg = 'Error: you must enter a user id and privilege level to create a new user.';
      }
	  $filled = true;
    }
?>

<body>
  <br />
  <div class="site-section">
  <div class="container">
  <div class="row justify-content-center">
      <div class="col-md-5">

		<?php
			if ($success) {
			   echo "<div class='alert alert-success' role='alert'>
						$infoUpdatedMsg
					</div>";
			} else if (!$success && $filled) {
				echo "<div class='alert alert-danger' role='alert'>
						$infoUpdatedMsg
					 </div>";
			} 
		?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="row">
            <div class="col-md-12 form-group">
              <label for="username">New User ID: </label>
              <input type="text" maxlength=8 id="username" name="username" class="form-control form-control-lg">
            </div>
            <div class="col-md-12 form-group">
              <label for="plevel">New User Privilege Level: </label>
			  <select id="plevel" name="plevel" class="form-control form-control-lg">
				<option value=""> Select </option>
				<option value="2"> Chair </option>
				<option value="3"> Applicant </option>
				<option value="4"> Student </option>
				<option value="5"> Alumni </option>
				<option value="6"> Instructor </option>
				<option value="7"> Faculty Reviewer </option>
				<option value="8"> Faculty Advisor </option>
			  </select>
			</div>
          </div>
          <div class="row">
            <div class="col-12">
              <input type="submit" value="Create User" class="btn btn-primary btn-lg px-5" name="submit">
<?php
  if (empty($_SESSION['id'])) {
    echo '<br><br><p class="text-danger">' . $error_msg . '</p>';
  }
?>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>

<?php


  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  // TODO: Start the session
  session_start();  

  // Clear the error message
  $error_msg = "";
  require_once('connectvars.php');
  // TODO: If the user isn't logged in, try to log them in
  if (empty($user_username) || empty($user_password)) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

       
      if (!empty($user_username) && !empty($user_password)) {
        // TODO: Look up the username and password in the database
	$query = "select id, p_level, password  from users  where id = '$user_username' and password = '$user_password'";      
	//echo "the query sent is: " . $query . "</br>";       
	$data = mysqli_query($dbc, $query);

        // If The log-in is OK 
        if (mysqli_num_rows($data) == 1) {
          
          
          $row = mysqli_fetch_array($data);

          //TODO: so set the user ID and username session vars
          $_SESSION['id'] = $row['id'];
          $_SESSION['p_level'] = $row['p_level'];

          //TODO: redirect to index.php 
          $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/advising.php';
          header('Location: ' . $home_url);
        }
        else {
          // The username/password are incorrect so set an error message
          $error_msg = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $error_msg = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }  
  if (empty($_SESSION['uID'])) {
  	echo '<p class="error">' . $error_msg . '</p>';
  
  }

  // Insert the page header
  $page_title = 'GWU Advising System';
  require_once('header.php');
  require_once('navmenu.php');

?>

  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <legend>Log In</legend>
      <label for="username">Username/Email:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      <label for="password">Password:</label>
      <input type="password" name="password" />
    </fieldset>
    <input type="submit" value="Log In" name="submit" />
  </form>




<?php
  // Insert the page footer
  require_once('footer.php');
?>

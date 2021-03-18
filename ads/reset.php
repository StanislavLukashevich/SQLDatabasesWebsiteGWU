<?php
  session_start();
	$page_title = 'GWU Advising System';


	//Load php tag into file once
  require_once('connectvars.php');
  require_once('appvars.php');
	require_once('header.php');
  require_once('navmenu.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>

  <html>
    <body>
      <h1>The Reset Button</h1>
        <form name=reset action = "<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="submit" value="Reset" name="submit">
        </form>
    </body>
  </html>

<?php

  if(isset($_POST['submit'])){
    $script_path = '/home/ead/bboltiansky/public_html/teamwuhan/Deliverables/public_html';
    $command = 'mysql'
            . ' --host=' . DB_HOST
            . ' --user=' . DB_USER
            . ' --password=' . DB_PASSWORD
            . ' --database=' . DB_NAME
            . ' --execute="SOURCE ' . $script_path
    ;
    $output1 = shell_exec($command . '/populatedatabase.sql"');
  }

  require_once('footer.php');

?>

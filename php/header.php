<!DOCTYPE html>
<html lang="en">

<?php
if (!isset($_SESSION)) {
  session_start ();
}
?>

<head>
  <?php 
  	require_once('header-meta.php'); 
  ?>
</head>

<body>
<?php
	$_SESSION["navlink-prefix"] = "./";
	require_once('header-body.php'); 
?>

</body>

</html>
